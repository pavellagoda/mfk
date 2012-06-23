$(function(){
	
	$('select#tour_id').change( function(){
		
		var idTour = $('select#tour_id option:selected').val();
		
		window.location.href = idTour;
		
	});	
});