<?php
if (!class_exists('Confluence')) exit();
?>

<style type="text/css">

#most-recent {
	margin-top: 1em;
}

#most-recent .meta {
	font-size: .8em;
}
#most-recent .edit {
	float: left;
}
#most-recent .datetime {
	float: right;
	text-transform: uppercase;
}

#most-recent .title-bag,
#most-recent h4 * {
	text-align: center;
	font-size: 1.2em;
}
#most-recent .truncated-description {
	font-size: 1em;
	line-height: 1.3em;
}
#most-recent hr {
	margin-bottom: 1.5em;
}

</style>

<div id="most-recent">
	<div class="inner">
	
	<?php foreach ($recent['show'] as $post): //var_dump($post); ?>
		<div class="episode">
			<h4 class="title-bag"><a href="<?php echo(get_permalink($post['ID'])); ?>"><?php echo(convergence_episode_title((object)$post)); ?></a></h4>
			<div><p><?php echo($post['post_excerpt']); ?></p></div>
			<div class="meta">
				
				<div class="edit">
					<a href="<?php echo(get_edit_post_link($post['ID'])); ?>">Edit</a>
				</div>
				<div class="datetime">
					<?php echo(human_time_difference( strtotime($post['post_date']), current_time('timestamp') ) . ' ago'); ?>
				</div>

			</div>
		</div>
	<?php endforeach; ?>

	<br class="clear" />
	<hr  />

	<?php foreach ($recent['fringe'] as $post): //var_dump($post); ?>
		<div class="episode">
			<h4 class="title-bag"><a href="<?php echo(get_permalink($post['ID'])); ?>"><?php echo(convergence_episode_title((object)$post)); ?></a></h4>
			<div><p><?php echo($post['post_excerpt']); ?></p></div>
			<div class="meta">
				
				<div class="edit">
					<a href="<?php echo(get_edit_post_link($post['ID'])); ?>">Edit</a>
				</div>
				<div class="datetime">
					<?php echo(human_time_difference( strtotime($post['post_date']), current_time('timestamp') ) . ' ago'); ?>
				</div>

			</div>
		</div>
	<?php endforeach; ?>

	<br class="clear" />

	</div>
</div>