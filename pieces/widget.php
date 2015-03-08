<aside class="widget">

    <div class="hackerRankWidget"
         id='<?php echo $this->id; ?>'
         data-requestsurl="<?php echo $requestsUrl, '/', $username, '/' ?>">

        <header>
            <img src="http://hackerrank.com/assets/brand/h_mark_sm.png"/>
            <span><?php echo $instance['user'] ?></span><span class="separator">|</span><span>HackerRank</span>
        </header>

        <?php
        foreach ($this->options as $option) :
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