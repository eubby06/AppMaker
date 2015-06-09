"use strict";

function camelCase(s) {
  return (s||'').toLowerCase().replace(/(\b|-|\_)\w/g, function(m) {
    return m.toUpperCase().replace(/\_/,'');
  });
}

(function() {

	var SpinnApp = {

		//set base url
		baseUrl: 'http://spinn.dev',

		//initialize buttons
		init: function() {

			//editing action button
			$('.js-edit-page-button').each(function() {
				$(this).on('click', SpinnApp.loadTemplate);
			});

			//add click event on delete page button
			$('.js-delete-page-button').each(function() {
				$(this).on('click', SpinnApp.deletePage);
			});

			//register create new app button; show modal box
			$('.js-create-app-button').on('click', SpinnApp.showCreateAppModal);

			//register add page buttons
			$('.js-add-page-button').each(function() {
				$(this).on('click', SpinnApp.submitAddPage);
			}); 
			//hide sidebar upon loading
			SpinnApp.hideSidebar();
		},

		//hide sidebar for edit mode
		hideSidebar: function() {

	        //If window is small enough, enable sidebar push menu
	        if ($(window).width() <= 992) {
	            $('.row-offcanvas').toggleClass('active');
	            $('.left-side').removeClass("collapse-left");
	            $(".right-side").removeClass("strech");
	            $('.row-offcanvas').toggleClass("relative");
	        } else {
	            //Else, enable content streching
	            $('.left-side').toggleClass("collapse-left");
	            $(".right-side").toggleClass("strech");
	            $('.col-md-7').switchClass('col-md-7','col-md-8');
	            $('.col-md-5').switchClass('col-md-5','col-md-4');
	        }
		},

		deletePage: function(e) {
			//page to be deleted
			var id = $(this).data('page-id');

			//initialize overlay
			var overlay = new ItpOverlay("js-pages-box");

 			$.ajax({
	        	type: "POST",
	            url: SpinnApp.baseUrl + '/apps/delete/module', 
	            data: {id: id},
	            beforeSend: function() {
	            	overlay.show();
	            },
	            complete: function() {
	            	overlay.hide();
	            },
	            success: function(result) { //return the pivot record id
	            	if(result == 'success') {
	            		$('#js-page-block-' + id).fadeOut();
	            	}
	            }               
	        });

			e.preventDefault();
		},

		//submit add page into app
		submitAddPage: function(e) {

			var appId = $(this).data('app');
			var moduleId = $(this).data('module');
			var pageName = $(this).data('page');

			var data = {
				app_id: appId,
				module_id: moduleId
			};	

			//hide alert message
			$('.js-alert').hide();

			//initialize overlay
			var overlay = new ItpOverlay("js-pages-box");

	        $.ajax({
	        	type: "POST",
	            url: SpinnApp.baseUrl + '/apps/add/module', 
	            data: data,
	            beforeSend: function() {
	            	overlay.show();
	            },
	            complete: function() {
	            	overlay.hide();
	            },
	            success: function(id) { //return the pivot record id
	            	var pageId = id;
			        var source   = $("#js-add-page-template").html();
					var template = Handlebars.compile(source);
					var data = {name: pageName, id: pageId};

					var $container = $('.js-app-pages-container');

					//load page box
					$container.append(template(data)).fadeIn();

		            //initialize buttons here that are only available after template is loaded
			        $('.js-create-app-submit').on('click', SpinnApp.submitCreateAppForm);

			        //add click event on delete page button
			        $('.js-delete-page-button.' + pageId).on('click', SpinnApp.deletePage);

			        //trigger click to show edit page
			        $container.find('.js-edit-page-button.' + pageId).on('click', SpinnApp.loadTemplate);
			        $container.find('.js-edit-page-button').trigger('click');         	
	            }               
	        });  

			e.preventDefault();
		},

		//submit create app form
		submitCreateAppForm: function(e) {

			var appName = $('.js-input-app-name').val();
			var appType = $('.js-input-app-type').val();
			var appFacebook = $('.js-input-app-facebook').val();

			var data = { 
				name: appName,
				type: appType,
				facebook: appFacebook
			};

	        $.ajax({
	        	type: "POST",
	            url: SpinnApp.baseUrl + '/apps/create', 
	            data: data,
	            success: function(app) {
	            	if(app) {
	            		window.location = SpinnApp.baseUrl + "/apps/edit/" + app.package_name;
	            	}
	            }               
	        });  

			e.preventDefault();
		},

		//this shows create app modal
		showCreateAppModal: function(e) {

	        var source   = $("#js-create-app-template").html();
			var template = Handlebars.compile(source);
			var data = {title: "My New Post", body: "This is my first post!"};

			$(".js-modal-container").html(template(data));

            $('.js-create-app-modal').modal('show');

            //initialize buttons here that are only available after template is loaded
	        $('.js-create-app-submit').on('click', SpinnApp.submitCreateAppForm);

			e.preventDefault();
		},

		//load css file
		loadStyling: function(pageName) {
			//load css only once
			if(!$('link.' + pageName).length) {
	            $("head").append("<link>");
				var css = $("head").children(":last");
				css.attr({
					rel:  "stylesheet",
					type: "text/css",
					class: pageName,
					href: SpinnApp.baseUrl + '/app/modules/' + pageName + '/' + pageName + ".css"
				});
			}
		},

		//load module main script
		loadScript: function(pageName, pageId) {

	            $.getScript( SpinnApp.baseUrl + '/app/modules/' + pageName + '/' + pageName + '.js', function(){
          			//initialize class name
            		var className = camelCase(pageName);
	            	eval( className + ".init(" + pageId + ");");
	            });

		},

		//load template for the page being edited
		loadTemplate: function(e) {			
			var pageName = $(this).data('page-name');
			var pageId = $(this).data('page-id');

	        $.ajax({
	            url: SpinnApp.baseUrl + '/app/modules/' + pageName + '/' + pageName + '.html', 
	            success: function(tmpl) {

	                //loading template
	                $("#js-editing-container-template").html(tmpl);

	                //load css
	                SpinnApp.loadStyling(pageName);

	                //load script
	                SpinnApp.loadScript(pageName, pageId);
	            }               
	        });  

	        e.preventDefault();
		}

	};

	//initialize about module object
	SpinnApp.init();
	
})();