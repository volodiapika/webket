/* get messages */
jQuery(function ($) {

	$('form').submit(function (event) {
        event.preventDefault();       
		var form = $(this);
        if (form.attr('id') == 'jform') {
        	var formData = new FormData(this);
			$.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
		        data: formData,
		        mimeType: "multipart/form-data",
		        contentType: false,
		        cache: false,
		        processData: false
		    }).success(function () {
		        $('.success').css('display', 'block');
		        $('.success').html('Your message has been submitted.');
		        setTimeout(function () {
                    document.location = '/';
                }, 3000);
		    }).fail(function (jqXHR, textStatus, errorThrown) {
		    	var alertText = '';
		        var textResponse = jqXHR.responseText;
		        var jsonResponse = jQuery.parseJSON(textResponse);
		        $.each(jsonResponse, function (n, elem) {
		            alertText = alertText + elem + "<br />";
		        });
		        $('.error').css('display', 'block');
		        $('.error').html(alertText);
		        setTimeout(function () {
                    $('.error').css('display', 'none');
                }, 3000);
		    });
		}
	});
    
	$(".btn.btn-default.decode").click(function() {
		$.ajax({
		  url: '/message/decode/text?password='
		  	+ encodeURIComponent($('#password').val())
		  	+ '&idmessage=' + encodeURIComponent($('#idmessage').val()),
		  success: function(data) {
		  	if (data == '')
		  		alert('Password wrong or text is empty.');
		    $('#decode').text(data);
		  }
		});
	});
	
});
