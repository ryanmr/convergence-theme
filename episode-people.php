<?php
	$people = array();
	$hosts = C::get_hosts();
	$guests = C::get_guests();
	$people = array_merge($hosts, $guests);
?>
<div class="episode-people">

	<h4>Hosts</h4>
	<ul>
		<?php foreach ($hosts as $host): ?>
			<li><?php echo $host; ?></li>
		<?php endforeach; ?>
	</ul>

	<h4>Guests</h4>
	<ul>
		<?php foreach ($guests as $guest): ?>
			<li><?php echo $guest; ?></li>
		<?php endforeach; ?>
	</ul>

</div>