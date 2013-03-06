<?php
if (!class_exists('Confluence')) exit();


?>

<style type="text/css">
	div.magic {
		padding: 2em;
		margin: 1em;
		font-size: 1.5em;
		background-color: #222;
		color: #fff;
	}
</style>

<?php
if ( false == isset($_GET['magic']) ) {
	echo('<div class="magic">magic is not initiated</div>');
	return;
}

$time_start = time();
$segment = '/json/' . $time_start . '/';
$path = WP_CONTENT_DIR . $segment;
$www = content_url() . $segment;
if ( !file_exists($path) ) {
	mkdir($path, 0777, true);
}

?>

<div class="magic">
	<p>magic export (to json) starting at ... <?php echo $time_start; ?></p>
</div>

<?php

$categories = get_categories();
$series = array();
foreach ($categories as $category) {
	
	$episodes = array();
	$q = new WP_Query(array(
		'category_name' => $category->slug,
		'posts_per_page' => -1
	));

	while ($q->have_posts()) {
		 $q->the_post();
		 $data = (powerpress_get_enclosure_data(get_the_ID()));
		 $episode = array(
		 	'name' => get_the_title(),
		 	'number' => get_episode_number(get_permalink()),
		 	'desc' => get_the_excerpt(),
		 	'content' => get_the_content(),
		 	'series' => $category->slug,
		 	'media' => $data['url'],
		 	'length' => $data['duration'],
		 	'filesize' => $data['size']
		 );
		 $episodes[] = $episode;

	}

	$series[] = array(
		'name' => $category->name,
		'short-name' => $category->slug,
		'desc' => $category->category_description
	);

	?>
		<div class="magic">
			<p>finished processing series: <?php echo $category->slug; ?> with <?php echo count($episodes) ?> episodes</p>
			<p> <a href="<?php echo $www . $category->slug . '-episodes.json'; ?>"><?php echo $category->slug . '-episodes.json' ?></a> </p>
		</div>
	<?php

	$episode_json = json_encode($episodes);
	file_put_contents($path . $category->slug . '-episodes.json', $episode_json);

}

$series_json = json_encode($series);
	file_put_contents($path . 'all-series.json', $series_json);	




?>
		<div class="magic">
			<p>finished exporting all series!</p>
			<p> <a href="<?php echo $www . 'all-series.json'; ?>"><?php echo 'all-series.json' ?></a> </p>
		</div>
