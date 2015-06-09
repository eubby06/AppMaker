"use strict";

(function() {

	var ModuleForm = {

		//set base url
		baseUrl: 'http://spinn.dev',

		//initialize buttons
		init: function() {
			$('.js-item-view').on('click', ModuleForm.viewItem);

			$('#confirm-delete').on('show.bs.modal', ModuleForm.promptDelete);

			$('#js-form-range').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        'Last 7 Days': [moment().subtract('days', 6), moment()],
                        'Last 30 Days': [moment().subtract('days', 29), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    startDate: moment().subtract('days', 29),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
		},

		//delete confirmation
		promptDelete: function(e) {

	        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('url'));
	            
	        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
	   	
	    },

	    viewItem: function(e) {
	    	$('#js-view-item-modal').modal('show');

	    	e.preventDefault();
	    }
	}

	$(function() {	
		ModuleForm.init();
	});
	
})();