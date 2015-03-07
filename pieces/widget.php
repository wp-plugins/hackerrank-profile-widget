<aside class="widget">

    <div class="hackerRankWidget"
         id='widget<?php echo $this->id; ?>'
         ng-app='hackerRankWidgetApp'
         data-requestsurl="<?php echo $requestsUrl, '/', $username, '/' ?>">

        <header>
            <img src="http://hackerrank.com/assets/brand/h_mark_sm.png"/>
            <span><?php echo $instance['user'] ?></span>
            <div> | HackerRank</div>
        </header>

        <?php
        foreach ($this->options as $option) :
            if ($instance['show' . $option] == 'on') {
                if ($option != 'profile' && $option != 'scores' && $option != 'badges') {
                    echo '<h2>' . ucfirst($option) . '</h2>';
                }
                echo '<div class="' . $option . ' hrPane">';
                require($option . '.html');
                echo '</div>';
            }
        endforeach;
        ?>
    </div>

</aside>
