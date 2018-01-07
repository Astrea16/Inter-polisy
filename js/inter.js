$(function(){
	$('.consultation').submit(function(){
		event.preventDefault();
		var formValid = true;
		$('.consultation input, textarea').each(function(){
			var formGroup = $(this).parents('.form-group');
			var glyphicon = formGroup.find('.form-control-feedback');
			if (this.checkValidity()) {
				formGroup.addClass('has-success').removeClass('has-error');
				glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-remove');
			} else{
				formGroup.addClass('has-error').removeClass('has-success');
				glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok');
				formValid = false; 
			}
		});
		  if (formValid){
			var formData = new FormData();
			formData.append('name', name);
			formData.append('email', email);
			formData.append('message', message);
			$.ajax({
				tupe: "POST",
				url: "inter.php",
				data: formData,
				contentType: false,
				processData: false,
				success : function(data){
					var $data =  JSON(data);
					$('#error').text('');
					if ($data.result == "success"){
						$('span.glyphicon').remove();
						$('#successMessage').removeClass('hidden');
					}
				},
				error: function (request) {
					$('#error').text('Произошла ошибка ' + request.responseText + ' при отправке данных.');
				}

			});
			setTimeout(function(){
			$(':input', '.consultation')
			.not(':button, :submit, :reset, :hidden')
			.val('')
		
			
		}, 3000);
		}
	});

});
