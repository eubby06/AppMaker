"use strict";

(function() {

	var SystemNotification = {

		//set base url
		baseUrl: 'http://spinn.dev',
		target: $('.js-target'),
		wrapper: $('.js-target-box'),
		inputMessage: $('.js-input-message'),

		//initialize buttons
		init: function() {

			SystemNotification.inputMessage.on('keyup', SystemNotification.countCharacters);

			$('#map').locationpicker({
				location: {latitude: 1.2800945, longitude: 103.85094909999998},	
				radius: 300,
				inputBinding: {
					latitudeInput: $('#map-lat'),
					longitudeInput: $('#map-lon'),
					radiusInput: $('#map-radius'),
					locationNameInput: $('#map-address')        
				},
				enableAutocomplete: true,
				onchanged: function(currentLocation, radius, isMarkerDropped) {
					alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
				}
			});

			SystemNotification.target.each(function()
			{
				$(this).on('ifChecked', SystemNotification.showTargetForm);
				$(this).on('ifUnchecked', SystemNotification.hideTargetForm);
			});

			$('.js-select-countries').multiselect({
	            includeSelectAllOption: true,
	            enableFiltering: true,
	            buttonWidth: '350px'
		    });

		    $('.js-select-roles').multiselect({
	            includeSelectAllOption: true,
	            enableFiltering: true,
	            buttonWidth: '350px'
		    });

		    $('.js-submit-btn').on('click', SystemNotification.submitForm);
		},

		submitForm: function(e) {

			var target = $('.js-selected-target').val();
			var appId = $('.js-app-id').val();

			var data = {};

			data.appId = appId;
			data.message = $('.js-input-message').val();

			switch(target)
			{
				case 'device':
					data.target = 'device';
				break;

				case 'group':
					data.target = 'group';
					data.roles = $('.js-select-roles').val();
				break;

				case 'country':
					data.target = 'country';
					data.countries = $('.js-select-countries').val();
				break;

				case 'location':
					data.target = 'location';
					data.latitude = $('.js-map-latitude').val();
					data.longitude = $('.js-map-longitude').val();
					data.radius = $('.js-map-radius').val();
				break;
			}
			
			SystemNotification.sendData(data);

			e.preventDefault();
		},

		sendData: function(data) {

			var overlay = new ItpOverlay("js-box-body");

 			$.ajax({
	        	type: "POST",
	            url: SystemNotification.baseUrl + '/api/notifications', 
	            data: data,
	            beforeSend: function() {
	            	overlay.show();
	            },
	            complete: function() {
	            	overlay.hide();
	            },
	            success: function(result) { 

	            	console.log(result);
	            }               
	        });

		},

		countCharacters: function() {
			var count = $(this).val().length;
			var limit = 140;

			$(this).next('.js-message-counter').text(count+'/140');
		},

		hideTargetForm: function() {
			$(this).find('.form-group').slideUp();
		},

		showTargetForm: function() {

			//get selected target and assigned to selected target input field
			$('.js-selected-target').val($(this).find('input[type=radio]').val());

			if( $(this).hasClass('js-target-location') )
			{
				$(this).find('.form-group').slideDown(function()
					{
						$('#map').locationpicker('autosize');
					});
			}
			else
			{
				SystemNotification.hideAllTargetForm();
				$(this).find('.form-group').slideDown();			
			}
		},

		hideAllTargetForm: function() {

			SystemNotification.target.each(function()
			{
				$(this).find('.form-group').slideUp();
			});
		}
	}

	$(function(){
		SystemNotification.init();
	});
	
})();