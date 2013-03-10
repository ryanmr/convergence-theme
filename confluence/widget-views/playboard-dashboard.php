<?php
if (!class_exists('Confluence')) exit();
?>

<style type="text/css">
	
#scoreboard {
	font-size: 1.3em;
}

#scoreboard .data-list {
	-moz-column-count:3; /* Firefox */
	-webkit-column-count:3; /* Safari and Chrome */
	column-count:3;
}
#scoreboard .stats-list {
	-moz-column-count:4; /* Firefox */
	-webkit-column-count:4; /* Safari and Chrome */
	column-count:4;
}

#scoreboard .data-list {
	margin-top: 0;
	padding-bottom: .5em;
	border-bottom: 1px solid #ccc;
}
#scoreboard .stats-list {
	margin-bottom: 0;
}

#scoreboard .series-short-name,
#scoreboard .stats-list dt {
	text-align: center;
	font-size: 1.2em;
	padding: .5em;
}
#scoreboard .series-episode-count,
#scoreboard .stats-list dd {
	font-size: 1em;
	padding-bottom: .85em;
	font-weight: bold;
	margin-left: 0;
	text-align: center;
}

#scoreboard .stats-list dt {
	font-size: 1em;
}
#scoreboard .stats-list dd {
	font-size: .9em;
}

#scoreboard .meta {
	font-size: .8em;
}

</style>

<div id="scoreboard" class="box grid_6">
	<div class="inner">
		
		<dl class="data-list">
<?php foreach ($playboard['series'] as $show): ?>
<dt class="series-short-name"><?php echo $show['slug']; ?></dt>
<dd class="series-episode-count"><?php echo $show['count']; ?></dd>
<?php endforeach; ?>
		</dl>
		
		<dl class="stats-list">
			<dt>Total</dt>
			<dd><?php echo($playboard['total_all']); ?></dd>
			<dt>90 Days</dt>
			<dd><?php echo($playboard['total_ninety']); ?></dd>
			<dt>30 Days</dt>
			<dd><?php echo($playboard['total_thirty']); ?></dd>
			<dt>7 Days</dt>
			<dd><?php echo($playboard['total_seven']); ?></dd>
		</dl>
		
		<div class="meta">
			<p class="datetime" title="<?php echo(date('l jS \of F Y h:i:s A', $playboard['last_update'])); ?>"><?php echo(date('l, F jS, Y', $playboard['last_update'])); ?></p>
		</div>

	</div>
</div>