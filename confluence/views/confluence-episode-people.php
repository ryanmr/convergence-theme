<?php /* people.php */

if (!class_exists('Confluence')) exit();

wp_nonce_field($nonce_path, $nonce_key);

?>

<div class="confluence-metabox" id="people">

	<div class="block">
		<p>
			<label>Episode Hosts: </label>
		</p>
		<div class="container">

			<div class="contents">

				<?php
					$people = get_post_meta($object->ID, 'confluence-people');
					$once = array();
					$removed = 0;
					/*
						On each iteration, only output the Person meta entry box if it's not already there.
						This prevents duplicates.
					*/
					foreach ( $people as $person ):
						if ( in_array($person, $once) ) {
							$removed++;
							continue;
						}
						$once[] = $person;
				?>
					<div class="person-input">
						<p style="text-align: right;">
							<input type="text" class="widefat" value="<?php echo esc_attr($person); ?>" name="confluence-person[]" />
							<a class="remove" href="#">Remove Person</a>
						</p>
					</div>
				<?php endforeach; ?>

				<?php if ($removed > 0): ?>
						<p>There were duplicate entries removed. (<?php echo $removed; ?>)</p>
				<?php endif; ?>

			</div>

			<p><a href="#" class="add-action">Add Person</a></p>
		</div>

		<p>Remember: people must be added before hand and the values specified here are <em>slug idenitifers</em>.</p>

	</div>

</div>
<div>
<pre>
<?php //print_r(get_post_meta($object->ID)); ?>
</pre>
</div>