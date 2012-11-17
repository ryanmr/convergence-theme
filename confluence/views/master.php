<?php

if (!class_exists('Confluence')) exit();

wp_nonce_field($nonce_path, $nonce_key);


?>

<div class="confluence-metabox">

	<div class="block">
		<p>
			<label><Strong>Hosts:</strong> <input type="text" class="widefat" name="confluence-host-basic" value="<?php echo esc_attr( get_post_meta($object->ID, 'confluence-host-basic', true) ); ?>" /></label>
		</p>
	</div>


	<div class="block">
		<p>
			<label><strong>Guests:</strong> <input type="text" class="widefat" name="confluence-guest-basic" value="<?php echo esc_attr( get_post_meta($object->ID, 'confluence-guest-basic', true) ); ?>" /></label>
		</p>
	</div>
	<div class="block">
		<p>
			<label>This episode's content is <em><span title="Not Safe For Work?">NSFW</span></em>: 
				<input type="checkbox" name="confluence-nsfw" <?php checked(get_post_meta($object->ID, 'confluence-nsfw', true)); ?> value="<?php echo esc_attr( get_post_meta($object->ID, 'confluence-nsfw', true) ); ?>" />
			</label>
		</p>
	</div>

</div>
<div>
<pre>
<?php print_r(get_post_meta($object->ID)); ?>
</pre>
</div>