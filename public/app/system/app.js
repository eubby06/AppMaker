"use strict";

(function() {

	var SystemApp = {

		//set base url
		baseUrl: 'http://spinn.dev',

		//initialize buttons
		init: function() {

	    	$('.js-btn-remove').on('click', SystemApp.removeModule);
	    	$('.js-btn-add').on('click', SystemApp.namePage);
		},

		namePage: function()
		{
			var pageName = $('.js-page-name').val();
			var moduleSelected = $('.js-select-modules option:selected').val();

			if(pageName == '')
			{
				alert('Oops! Please enter a page name');
				return;
			}

			//var underscoredName = pageName.replace(/\s+/g, '-').toLowerCase();

			$('.js-select-pages').append("<option value='"+moduleSelected+"-"+pageName+"' selected>"+pageName+"</option>");
		},

		removeModule: function()
		{
			$('.js-select-pages option:selected').each( function() {
	            $(this).remove();
	        });
		}
	}

	$(function() {	
		SystemApp.init();
	});
	
})();