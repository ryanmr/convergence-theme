<?php
if (!class_exists('Confluence')) exit();
?>

<style type="text/css">
	
#most-recent .meta {
	font-size: .8em;
}
#most-recent .datetime {
	float: left;
}
#most-recent .ago {
	float: right;
	text-transform: uppercase;
}
#most-recent .inner {
	padding: 1em;
}

#most-recent .title-bag {
	text-align: center;
	font-size: 1.5em;
}
#most-recent .truncated-description {
	font-size: 1em;
	line-height: 1.3em;
}
#most-recent hr {
	margin-bottom: 2em;
}

</style>

<div id="most-recent">
	<div class="inner">
	
	<?php foreach ($recent['show'] as $post): //var_dump($post); ?>
		<div class="episode">
			<h4 class="title-bag"><?php echo(convergence_episode_title((object)$post)); ?></h4>
			<div><p><?php echo($post['post_excerpt']); ?></p></div>
			<div class="meta"></div>
		</div>
	<?php endforeach; ?>

	<hr />

	<?php foreach ($recent['fringe'] as $post): //var_dump($post); ?>
		<div class="episode">
			<h4 class="title-bag"><?php echo(convergence_episode_title((object)$post)); ?></h4>
			<div><p><?php echo($post['post_excerpt']); ?></p></div>
			<div class="meta"></div>
		</div>
	<?php endforeach; ?>

	</div>
</div>