<?php

if (!class_exists('Confluence')) exit();

wp_nonce_field($nonce_path, $nonce_key);


?>

<div class="confluence">
<p>

	<label>This episode's content is <em><span title="Not Safe For Work?">NSFW</span></em>: 
		<input type="checkbox" name="confluence-nsfw" <?php checked(get_post_meta($object->ID, 'confluence-nsfw', true)); ?> value="<?php esc_attr( get_post_meta($object->ID, 'confluence-nsfw', true) ); ?>" />
	</label>

</p>
</div>
<div>
<pre>
<?php //print_r(get_post_meta($object->ID)); ?>
</pre>
</div>