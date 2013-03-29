jQuery(document).ready(function($){

	var elements = $('.home .episode-block img');
	elements.attr('width', '269');
	elements.attr('height', '150');
	elements.attr('src', 'http://i0.wp.com/the-nexus.tv/wp-content/uploads/2012/12/the-universe-wide-001.jpg');

	var shows = $('.home .show-name');
	shows.each(function(index){
		console.log(this);
		$(this).append('<span class="with-feature"> with Sam Ebertz</span>')
	});

});