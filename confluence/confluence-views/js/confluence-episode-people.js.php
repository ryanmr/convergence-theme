<script type="text/javascript">
	function create_new_person($) {

	    var str = '<div class="person-input">\
	    			<p style="text-align: right;">\
	    				<input type="text" class="widefat" name="confluence-person[]" />\
	    				<a class="remove" href="#">Remove Person</a>\
	    			</p>\
	    		   </div>';
	    var container = $(str);
	    $(container).find('a').click(function(){
	        container.remove();
	        return false;
	    });
	    return container;
	}

	jQuery(document).ready(function($){

		$('#people .contents a.remove').click(function(){
			$(this).parents('div.person-input').remove();
			return false;
		});

	    $('#people .add-action').click(function(){
	        $('#people .contents').append(create_new_person($));
	        return false;
	    });

	});
</script>