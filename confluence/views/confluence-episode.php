<?php

if (!class_exists('Confluence')) exit();

wp_nonce_field($nonce_path, $nonce_key);


?>

<div class="confluence-metabox">

	<div class="block">
		<p>
			<label>This episode's content is <em><span title="Not Safe For Work?">NSFW</span></em>: 
				<input type="checkbox" name="confluence-nsfw" <?php checked(get_post_meta($object->ID, 'confluence-nsfw', true)); ?> value="<?php echo esc_attr( get_post_meta($object->ID, 'confluence-nsfw', true) ); ?>" />
			</label>
		</p>
	</div>
	
	<div class="block">
		<p>
			<label title="Does episode have a Fringe associated with it?">Fringe URL: </label>
			<input type="text" class="widefat" name="confluence-fringe-url" value="<?php echo esc_attr(get_post_meta($object->ID, 'confluence-fringe-url', true)); ?>" />
		</p>
	</div>

</div>
<div>
<pre>
<?php print_r(get_post_meta($object->ID)); ?>
</pre>
</div>