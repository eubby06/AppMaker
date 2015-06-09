"use strict";

(function() {

	var SystemPermission = {

		//set base url
		baseUrl: 'http://spinn.dev',

		//initialize buttons
		init: function() {

			$('.js-select-privileges').multiselect({
	            includeSelectAllOption: true,
	            enableFiltering: true,
	            buttonWidth: '250px'
	        });

			$('input.js-permission-allow').on('ifChecked', SystemPermission.showPrivileges);
			$('input.js-permission-allow').on('ifUnchecked', SystemPermission.hidePrivileges);
		},

		showPrivileges: function(event) {

			var parent = $(this).parent().parent().parent();

	   		parent.find('.js-privileges-container').show();
	    },

	    hidePrivileges: function(event) {

			var parent = $(this).parent().parent().parent();
			var container = parent.find('.js-privileges-container');

			container.find('.js-select-privileges').multiselect('deselectAll', false);
			container.find('.js-select-privileges').multiselect('updateButtonText');
	   		container.hide();
	    }
	}

	$(function() {	
		SystemPermission.init();
	});
	
})();