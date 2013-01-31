var val = 10;
var timer;

$(document).ready(function() {
	$('#barcode').focus();
	$('#lookup').submit(function() {
		$('.alert').hide();
		$('.progress').show();
	
		function updateProgress() {
			val += 10;
			$('.bar').css('width', val + '%');
			if (val < 100) {
				timer = setTimeout(updateProgress, 500);
			}
		}
		updateProgress();
		var barcode = $('#barcode').val();
		var scanning_lib = $('#scanning_library option:selected').val();
		
		$.post('/services/new-item/', {barcode: barcode, branch: scanning_lib}, function(data) {
			$('.alert-success').show();
			$('.added-title').html(data);
		});
			
		//$('.alert-error').text('The barcode lookup failed - no data').fadeIn();
		
		return false;
	});
});