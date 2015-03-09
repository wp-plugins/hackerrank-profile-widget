<p>
    <?php foreach ($this->options['text'] as $option): ?>
        <label for="<?php echo $this->get_field_id($option); ?>"><?php echo ucfirst($option); ?>:
            <input class="widefat"
                   id="<?php echo $this->get_field_id($option); ?>"
                   name="<?php echo $this->get_field_name($option); ?>"
                   type="text"
                <?php if ($option == 'username') echo 'style="width: 95%;";'; ?>
                   value="<?php echo esc_attr(${$option}); ?>"/></label>

        <?php if ($option == 'username'): ?>
            <?php if (!empty($option)) : ?>
                <a href="https://hackerrank.com/<?php echo esc_attr($option); ?>" target='_blank' title='Test link'>
                    <img src='https://cdn0.iconfinder.com/data/icons/feather/96/591256-link-16.png'></a>
            <?php endif; ?>
        <?php endif; ?>

        <br><br>
    <?php endforeach; ?>

    <?php foreach ($this->options['checkboxes'] as $option): ?>
        <input class="checkbox" type="checkbox" <?php checked($instance[$option], 'on'); ?>
               id="<?php echo $this->get_field_id($option); ?>"
               name="<?php echo $this->get_field_name($option); ?>"/>
        <label for="<?php echo $this->get_field_id($option); ?>">
            <?php echo str_replace('_', ' ', ucfirst($option)); ?>
        </label>
    <?php endforeach; ?>

    <br><br>

    <?php foreach ($this->options['showOptions'] as $option): ?>
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
