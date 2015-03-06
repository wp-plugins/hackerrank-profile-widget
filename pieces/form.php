<p>
    <input class="widefat" id="<?php echo $this->get_field_id('user'); ?>"
           placeholder="Your HackerRank username" required="true" style='width:300px;'
           name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo esc_attr($user); ?>"/>
    <?php if (!empty($user)) : ?>
        <a href="https://hackerrank.com/<?php echo esc_attr($user); ?>" target='_blank' title='Test link'>
            <img src='https://cdn0.iconfinder.com/data/icons/feather/96/591256-link-16.png'/></a>
    <?php endif; ?>

    <br/><br/>

    <?php foreach ($this->options as $option): ?>
        <?php $thisName = 'show' . $option; ?>

        <input class="checkbox" type="checkbox" <?php checked($instance[$thisName], 'on'); ?>
               id="<?php echo $this->get_field_id($thisName); ?>"
               name="<?php echo $this->get_field_name($thisName); ?>"/>
        <label for="<?php echo $this->get_field_id($thisName); ?>">
            <?php echo ucfirst($option); ?>
        </label>
        <br/>

    <?php endforeach; ?>
</p>
