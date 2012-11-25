<div class="files">
<?php
		if ( function_exists('get_the_powerpress_content') ) {
				if ( $content = get_the_powerpress_content() ) {
						echo '<h3>Listen</h3>';
						echo $content;
						$values = powerpress_get_enclosure_data(get_the_ID());
						?>
						<div class="download-meta">
							<span class="show-size"><?php echo convergence_display_size($values); ?></span>
							&bull;
							<span class="show-length"><?php echo convergence_display_length($values); ?></span>
						</div>
						<?php
				} else {
						?>
						<!-- files are not assigned -->
						<?php
				}
		} else {
						?>
						<!-- podcast engine is non-functional -->
						<?php
		}
?>
</div>