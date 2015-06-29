<?php
/*
 * HackerRank Profile Widget for WordPress
 *
 *     Copyright (C) 2015 Henrique Dias <hacdias@gmail.com>
 *     Copyright (C) 2015 Luís Soares <lsoares@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>
<aside class="widget">

	<?php if ( isset( $config['customCss'] ) ) : ?>
		<style><?php echo $config['customCss']; ?></style>
	<?php endif; ?>

	<?php if ( isset( $config['title'] ) ) : ?>
		<?php echo $before_title . $config['title'] . $after_title; ?>
	<?php endif; ?>

	<div class="hackerrank-widget"
	     id='<?php echo $this->id; ?>'
	     data-requestsurl="<?php echo HACKERRANK_REQUESTS, '/', ( isset( $config['username'] ) ? $config['username'] : '' ), '/' ?>">

		<?php if ( ! isset( $config['hideBuiltInHeader'] ) || ! $config['hideBuiltInHeader'] == 'on' ) : ?>
			<header class="hackerrank-widget-header">
				<img class="hackerrank-widget-company-logo" src="https://d3keuzeb2crhkn.cloudfront.net/hackerrank/assets/brand/h_mark_sm.png"/>
                <div class="hackerrank-widget-header-text">
                    <a class='hackerrank-widget-header-link' target='_blank'
                       href="https://www.hackerrank.com/<?php echo $config['username'] ?>">
                        <?php echo $config['username'] ?></a>
                    <span class="separator"> |</span>
                    <span>HackerRank</span>
                </div>
			</header>
		<?php endif; ?>

		<div class="hackerrank-widget-content">
			<?php
			foreach ( $this->options as $option ) {
				if ( substr( $option, 0, 4 ) === "show"
				     && isset( $config[ $option ] )
				     && $config[ $option ] == 'on'
				) {
					$optionName = str_replace( 'show', '', strtolower( $option ) );
					if ( $optionName != 'profile'
					     && $optionName != 'scores'
					     && $optionName != 'badges'
					) {
						echo '<h2>' . ucfirst( $optionName ) . '</h2>';
					}
					echo '<div class="hr' . ucfirst( $optionName ) . ' hrPane">';
					require( $optionName . '.html' );
					echo '</div>';
				}
			}
			?>
		</div>
	</div>
</aside>
