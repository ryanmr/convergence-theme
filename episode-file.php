<div class="files">
<?php
		if ( function_exists('get_the_powerpress_content') ) {
				if ( $content = get_the_powerpress_content() ) {
						echo '<h3>Listen</h3>';
						echo $content;
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