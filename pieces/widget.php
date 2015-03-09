<aside class="widget">
    <?php if (isset($instance['title'])) : ?>
        <?php echo $before_title . $instance['title'] . $after_title; ?>
    <?php endif; ?>

    <div class="hackerRankWidget"
         id='<?php echo $this->id; ?>'
         data-requestsurl="<?php echo $requestsUrl, '/', (isset($instance['username']) ? $instance['username'] : ''), '/' ?>">

        <?php if (!isset($instance['Hide_built-in_header']) || !$instance['Hide_built-in_header'] == 'on') : ?>
            <header>
                <img src="http://hackerrank.com/assets/brand/h_mark_sm.png"/>
            <span>
                <?php echo(isset($instance['username']) ? $instance['username'] : '') ?>
            </span>
                <span class="separator">|</span>
                <span>HackerRank</span>
            </header>
        <?php endif; ?>

        <?php
        foreach ($this->options['showOptions'] as $option) :
            if ($instance['show' . $option] == 'on') {
                if ($option != 'profile' && $option != 'scores' && $option != 'badges') {
                    echo '<h2>' . ucfirst($option) . '</h2>';
                }
                echo '<div class="hr' . ucfirst($option) . ' hrPane">';
                require($option . '.html');
                echo '</div>';
            }
        endforeach;
        ?>
    </div>

</aside>