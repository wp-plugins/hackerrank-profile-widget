<p>
    <label for="<?php echo $this->get_field_id('title'); ?>">
        <input class="widefat"
               id="<?php echo $this->get_field_id('title'); ?>"
               name="<?php echo $this->get_field_name('title'); ?>"
               type="text"
               placeholder="Title of the widget"
               value="<?php echo esc_attr($title); ?>"/></label>

    <br><br>

    <input class="checkbox" type="checkbox" <?php checked($hideBuiltInHeader, 'on'); ?>
           id="<?php echo $this->get_field_id('hideBuiltInHeader'); ?>"
           name="<?php echo $this->get_field_name('hideBuiltInHeader'); ?>"/>
    <label for="<?php echo $this->get_field_id('hideBuiltInHeader'); ?>">
        Hide built-in header
    </label>

    <br><br>

    <label for="<?php echo $this->get_field_id('username'); ?>">
        <input class="widefat"
               id="<?php echo $this->get_field_id('username'); ?>"
               name="<?php echo $this->get_field_name('username'); ?>"
               type="text"
               placeholder="Your HackerRank username"
               style="width: 90%"
               value="<?php echo esc_attr($username); ?>"/></label>

    <?php if (!empty($username)) : ?>
        <a href="https://hackerrank.com/<?php echo esc_attr($username); ?>" target='_blank' title='Test link'>
            <img src='<?php echo HACKERRANK_PLUGIN_URL . 'css/link.png' ?>'></a>
    <?php endif; ?>

    <br><br>

    <?php foreach ($this->options as $option): ?>
        <?php if (substr($option, 0, 4) === "show"): ?>
            <input class="checkbox" type="checkbox" <?php checked(${$option}, 'on'); ?>
                   id="<?php echo $this->get_field_id($option); ?>"
                   name="<?php echo $this->get_field_name($option); ?>"/>
            <label for="<?php echo $this->get_field_id($option); ?>">
                <?php echo str_replace('show', '', $option); ?>
            </label>
            <br>
        <?php endif; ?>
    <?php endforeach; ?>
</p>
