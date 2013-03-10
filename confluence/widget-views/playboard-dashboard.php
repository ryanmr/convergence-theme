<?php
if (!class_exists('Confluence')) exit();
?>

<style type="text/css">
	
#scoreboard .inner {
	font-size: 1.3em;
	padding: 1em;
}

#scoreboard .data-list,
#scoreboard .stats-list {
	-moz-column-count:3; /* Firefox */
	-webkit-column-count:3; /* Safari and Chrome */
	column-count:3;
}
#scoreboard .data-list {
	margin-top: 0;
	padding-bottom: .5em;
	border-bottom: 1px solid #eee;
}
#scoreboard .stats-list {
	margin-bottom: 0;
}

#scoreboard .series-short-name,
#scoreboard .stats-list dt {
	text-align: center;
	font-size: 1.2em;
	padding: .3em;
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

</style>

		<div id="scoreboard" class="box grid_6">
			<div class="inner">
				
				<dl class="data-list">
					<dt class="series-short-name">ATN</dt>
					<dd class="series-episode-count">63</dd>

					<dt class="series-short-name">CS</dt>
					<dd class="series-episode-count">15</dd>

					<dt class="series-short-name">DM</dt>
					<dd class="series-episode-count">0</dd>
					
					<dt class="series-short-name">EB</dt>
					<dd class="series-episode-count">24</dd>
					
					<dt class="series-short-name">NS</dt>
					<dd class="series-episode-count">16</dd>
					
					<dt class="series-short-name">SS</dt>
					<dd class="series-episode-count">0</dd>
					
					<dt class="series-short-name">TF</dt>
					<dd class="series-episode-count">50</dd>
					
					<dt class="series-short-name">TED</dt>
					<dd class="series-episode-count">0</dd>
					
					<dt class="series-short-name">TU</dt>
					<dd class="series-episode-count">19</dd>
										
				</dl>
				
				<dl class="stats-list">
					<dt>Total</dt>
					<dd>181</dd>
					<dt>30 Days</dt>
					<dd>22</dd>
					<dt>7 Days</dt>
					<dd>6</dd>
				</dl>
				
			</div>
		</div>