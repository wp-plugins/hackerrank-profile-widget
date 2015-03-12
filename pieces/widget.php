<aside class="widget">

    <?php if (isset($config['customCss'])) : ?>
        <style><?php echo $config['customCss']; ?></style>
    <?php endif; ?>

    <?php if (isset($config['title'])) : ?>
        <?php echo $before_title . $config['title'] . $after_title; ?>
    <?php endif; ?>

    <div class="hackerRankWidget"
         id='<?php echo $this->id; ?>'
         data-requestsurl="<?php echo HACKERRANK_REQUESTS, '/', (isset($config['username']) ? $config['username'] : ''), '/' ?>">

        <?php if (!isset($config['hideBuiltInHeader']) || !$config['hideBuiltInHeader'] == 'on') : ?>
            <header>
                <img src="http://hackerrank.com/assets/brand/h_mark_sm.png" />
                <a class='hrHeaderUsername' target='_blank' href="https://hackerrank.com/<?php echo $config['username'] ?>">
                    <?php echo $config['username'] ?></a>
                <span class="separator"> |</span>
                <span>HackerRank</span>
            </header>
        <?php endif; ?>

        <div class="hackerRankWidgetContent">
            <?php
            foreach ($this->options as $option) {
                if (substr($option, 0, 4) === "show"
                    && isset($config[$option])
                    && $config[$option] == 'on'
                ) {
                    $optionName = str_replace('show', '', strtolower($option));
                    if ($optionName != 'profile'
                        && $optionName != 'scores'
                        && $optionName != 'badges'
                    ) {
                        echo '<h2>' . ucfirst($optionName) . '</h2>';
                    }
                    echo '<div class="hr' . ucfirst($optionName) . ' hrPane">';
                    require($optionName . '.html');
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</aside>