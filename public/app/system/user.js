"use strict";

(function() {

	var SystemUser = {

		//set base url
		baseUrl: 'http://spinn.dev',

		//initialize buttons
		init: function() {

			$('.js-select-merchant').on('change', SystemUser.loadTypes);

			$('#confirm-delete').on('show.bs.modal', SystemUser.promptDelete);
		},

		//delete confirmation
		promptDelete: function(e) {

	        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('url'));
	            
	        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
	   	
	    },

		//hide sidebar for edit mode
		loadTypes: function() {

			var id = $(this).find('option:selected').val();
			var overlay = new ItpOverlay("js-box-body");

 			$.ajax({
	        	type: "GET",
	            url: SystemUser.baseUrl + '/api/roles', 
	            data: {merchantId: id},
	            beforeSend: function() {
	            	overlay.show();
	            },
	            complete: function() {
	            	overlay.hide();
	            },
	            success: function(result) { 

	            	if(result) {
		            	var roleSelect = $('.js-select-role');
		            	var typeSelect = $('.js-select-type');

		            	roleSelect.empty();

		            	//if merchant has been selected, then lock type to user only
		            	if(id != 0) {
		            		$('.js-select-type option[value="user"]').prop('selected',true);
		            		typeSelect.css('pointer-events', 'none');
		            		typeSelect.css('cursor', 'default');
		            	} else {
		            		$('.js-select-type option[value="0"]').prop('selected',true);
		            		typeSelect.removeAttr('style');
		            	}

		            	$.each(result, function(i, role)
		            	{
		            		roleSelect.append("<option value='" + i + "'>" + role + "</option>");
		            	});

				    }
	            }               
	        });

		}
	}

	SystemUser.init();

})();