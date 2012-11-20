<?php /* people.php */

if (!class_exists('Confluence')) exit();

wp_nonce_field($nonce_path, $nonce_key);

?>

<div class="confluence-metabox" id="people">

	<div class="block">
		<p>
			<label>People in this episode: 
				
			</label>
		</p>
	</div>

</div>
<div>
<pre>
<?php //print_r(get_post_meta($object->ID)); ?>
</pre>
</div>