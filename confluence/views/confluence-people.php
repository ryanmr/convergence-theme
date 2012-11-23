<?php

if (!class_exists('Confluence')) exit();

wp_nonce_field($nonce_path, $nonce_key);


?>

<div class="confluence-metabox">

	<div class="block">
		<p>
			<label>Grvatar Email Address <em>(required)</em>: 
				<input type="text" class="widefat" name="confluence-person-gravatar" value="<?php echo esc_attr(get_post_meta($object->ID, 'confluence-person-gravatar', true)); ?>" />
			</label>
		</p>

		<p>
			<label>Website URL <em>(optional)</em>: 
				<input type="text" class="widefat" name="confluence-person-website" value="<?php echo esc_attr(get_post_meta($object->ID, 'confluence-person-website', true)); ?>" />
			</label>
		</p>

		<p>
			<label>Social URL <em>(optional)</em>: 
				<input type="text" class="widefat" name="confluence-person-social" value="<?php echo esc_attr(get_post_meta($object->ID, 'confluence-person-social', true)); ?>" />
			</label>
		</p>
	</div>

</div>
<div>
<pre>
<?php //print_r(get_post_meta($object->ID)); ?>
</pre>
</div>