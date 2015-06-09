"use strict";

(function() {

	var SystemRole = {

		//set base url
		baseUrl: 'http://spinn.dev',

		//initialize buttons
		init: function() {

			$('.js-select-merchant').on('change', SystemRole.loadTypes);
			$('#confirm-remove').on('show.bs.modal', SystemRole.promptRemove);
			$('#add-user').on('show.bs.modal', SystemRole.promptAdd);
		},

		//add user modal
		promptAdd: function(e) {

	        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('url'));
	    },

		//remove one confirmation
		promptRemove: function(e) {

	        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('url'));
	            
	        $('.debug-url').html('Remove URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
	   	
	    },

		//hide sidebar for edit mode
		loadTypes: function() {

			var id = $(this).find('option:selected').val();
			var overlay = new ItpOverlay("js-box-body");

 			$.ajax({
	        	type: "GET",
	            url: SystemRole.baseUrl + '/api/roles', 
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
		            		typeSelect.prop('disabled', true);
		            	} else {
		            		$('.js-select-type option[value="0"]').prop('selected',true);
		            		typeSelect.css('pointer-events', 'none');
		            		typeSelect.css('cursor', 'default');
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

	$(function() {	
		SystemRole.init();
	});

})();