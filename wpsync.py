#!/usr/bin/python
import os
import json
import tempfile
import subprocess
import shutil
import re

config_file = 'wpsync.json'

if not os.path.isfile(config_file):
    print 'There is no configuration file.'
    exit(1)

config = json.loads(open(config_file).read())

plugin_file = config['main-file'] if 'main-file' in config else 'plugin.php'
readme_file = 'readme.txt'

class DependenciesManager(object):
    __slots__ = {'main', 'folder', 'json', 'cnf', 'lock', 'config'}

def composer_update():
    composer = DependenciesManager()
    composer.main = 'composer.json'
    composer.lock = 'composer.lock'

    if os.path.isfile(composer.main):
        if os.path.isfile(composer.main):
            os.remove(composer.lock)

        composer.json = json.loads(open(composer.main)).read()
        composer.folder = 'vendor'

        if 'config' in composer.json:
            if 'vendor-dir' in composer.json['config']:
                composer.folder = composer.json['config']['vendor-dir']

        composer.folder = os.path.normpath(composer.folder)

        if os.path.isdir(composer.folder):
            shutil.rmtree(composer.folder)

        subprocess.call('composer install', shell=True)

    return


def bower_update():
    bower = DependenciesManager()
    bower.main = 'bower.json'
    bower.cnf = '.bowerrc'

    if os.path.isfile(bower.main):
        bower.json = json.loads(open(bower.main)).read()
        bower.folder = 'bower_components'

        if os.path.isfile(bower.cnf):
            bower.config = json.loads(open(bower.cnf)).read()

            if 'directory' in bower.config:
                bower.folder = bower.config['directory']

        if os.path.isdir(bower.folder):
            shutil.rmtree(bower.folder)

        subprocess.call('bower install', shell=True)

    return


def get_main_file_content():
    return open(plugin_file, 'r').read()

def get_readme_content():
    return open(readme_file, 'r').read()


def get_plugin_version():
    match = re.search("Version:[ \t]*[\d+\.]+\d", get_main_file_content())

    if match is None:
        print "We can't understand the version of your plugin :("
        exit(1)

    version = match.group(0)
    version = re.search("[\d+\.]+\d", version).group(0)

    version = version.split('.')
    return list(map(int, version))


def update_plugin_version_helper(index, version):
    if (version[index] + 1) > 9 and index != 0:
        version[index] = 0
        index -= 1
        update_plugin_version_helper(index, version)
    else:
        version[index] += 1

    return version


def update_plugin_version(version):
    # get the version index to update
    # major.minor[.build[.revision]]
    # default is build
    index = config['increase'] if 'increase' in config else 'build'

    if index == 'major':
        index = 0
    elif index == 'minor':
        index = 1
    elif index == 'build':
        index = 2
    elif index == 'revision':
        index = 3

    version = update_plugin_version_helper(index, version)
    new_version = ''

    for index in version:
        new_version += str(index) + '.'

    return new_version[:-1]

def change_version_on_files(version):
    main_content = get_main_file_content()
    main_content = re.sub('Version:[ \t]*[\d+\.]+\d', 'Version: ' + version, main_content)

    with open(plugin_file, 'w') as file:
        file.write(main_content)

    readme_content = get_readme_content()
    readme_content = re.sub('Stable tag:[ \t]*[\d+\.]+\d', 'Stable tag: ' + version, readme_content)

    with open(readme_file, 'w') as file:
        file.write(readme_content)

    return

def process_git_call(version):
    subprocess.call("git add -A", shell=True)
    subprocess.call("git tag v" + version, shell=True)
    subprocess.call("git commit -m 'v" + version + "'", shell=True)
    subprocess.call("git push", shell=True)
    subprocess.call("git push --tags", shell=True)
    return

def process_svn_call(version):
    main_path = os.path.dirname(os.path.realpath(__file__))
    temp_path = tempfile.mkdtemp()

    ignore_files = shutil.ignore_patterns(*config['ignore'])

    os.chdir(temp_path)

    subprocess.call("svn checkout " + config['svn'], shell=True)

    trunk_dir = os.path.join(temp_path, 'trunk')

    temporary_content = os.path.join(temp_path, 'contents_temp')

    shutil.copytree(main_path, temporary_content, False, ignore_files)

    svn_src = os.path.join(trunk_dir, '.svn')
    svn_dst = os.path.join(temporary_content, '.svn')

    shutil.copytree(svn_src, svn_dst)

    shutil.rmtree(trunk_dir)
    shutil.move(temporary_content, trunk_dir)

    os.chdir(trunk_dir)

    subprocess.call("svn add * --force", shell=True)
    subprocess.call("svn commit -m 'v" + version + "'", shell=True)

    os.chdir(main_path)
    shutil.rmtree(temp_path)
    return

#composer_update()
#bower_update()

pversion = get_plugin_version()
pversion = update_plugin_version(pversion)

try:
    input("Confirm you want to update your plugin to v" + pversion)
except SyntaxError:
    pass

change_version_on_files(pversion)
process_git_call(pversion)
process_svn_call(pversion)

try:
    input("Press any key to continue...")
except SyntaxError:
    pass
