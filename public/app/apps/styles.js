"use strict";

(function() {

	//object for theme
	var AppTheme = {

		$container: { },
		$themesWrapper: { },
		$theme: { },
		data: { theme: null },

		init: function(elem) {
			AppTheme.$container 	= $(elem);
			AppTheme.$themesWrapper = AppTheme.$container.find('.js-themes');
			AppTheme.$themes 		= AppTheme.$container.find('.js-theme');

			AppTheme.$themes.each(function() {
				$(this).on('click', AppTheme.selectTheme);
			});
		},

		selectTheme: function(e) {

			var selectedTheme = $(this).data('id');

			//unhighlight text
			AppTheme.deselectTheme();

			//highlight selected theme
			$(this).addClass('selected');

			//data for form submission
			AppTheme.data.theme = selectedTheme;

			e.preventDefault();
		},

		deselectTheme: function() {
			AppTheme.$themes.each(function() {
				$(this).removeClass('selected');
			});
		}
	};

	//object for navigation
	var AppNavigation = {

		$container: { },
		$navigationsWrapper: { },
		$navigation: { },
		data: { navigation: null },

		init: function(elem) {
			AppNavigation.$container 			= $(elem);
			AppNavigation.$navigationsWrapper 	= AppNavigation.$container.find('.js-navigations');
			AppNavigation.$navigations 			= AppNavigation.$container.find('.js-navigation');

			AppNavigation.$navigations.each(function() {
				$(this).on('click', AppNavigation.selectNavigation);
			});
		},

		selectNavigation: function(e) {

			var selectedNavigation = $(this).data('id');

			//unhighlight text
			AppNavigation.deselectTheme();

			//highlight selected theme
			$(this).addClass('selected');

			//data for form submission
			AppNavigation.data.navigation = selectedNavigation;

			e.preventDefault();
		},

		deselectTheme: function() {
			AppNavigation.$navigations.each(function() {
				$(this).removeClass('selected');
			});
		}	
	};

	//object for colorscheme
	var AppColorScheme = {

		$container: { },
		$schemes: { },
		selectedScheme: { },
		data: { scheme: null},

		init: function(elem) {
			//div wrapper
			AppColorScheme.$container = $(elem);
			AppColorScheme.$colorSchemesContainer = AppColorScheme.$container.find('.js-color-schemes-container');

			//load color schemes
			AppColorScheme.loadThemeColorSchemes();

			//initialize color picker
			$(".js-color-picker").colorpicker();

			//select all schemes
			AppColorScheme.$schemes = AppColorScheme.$container.find('.js-scheme');

			AppColorScheme.$schemes.each(function() {
				$(this).on('click', AppColorScheme.selectScheme);
			});
		},

		selectScheme: function(e) {

			var selectedSchemeId = $(this).data('id');

			//get selected scheme by id (this is pulled in from json data)
			AppColorScheme.selectedScheme = AppColorScheme.getThemeColorSchemeById(selectedSchemeId);

			//unhighlight text
			AppColorScheme.deselectScheme();

			//highlight selected theme
			$(this).addClass('selected');

			//data for form submission
			AppColorScheme.data.scheme = selectedSchemeId;

			//populate editable colors
			AppColorScheme.populateEditableColors();

			e.preventDefault();
		},

		populateEditableColors: function() {
			var $editableSchemeColors = AppColorScheme.$container.find('.js-colors-container');

			$editableSchemeColors.find('.js-background').val(AppColorScheme.selectedScheme.values.background).keyup();
			$editableSchemeColors.find('.js-title').val(AppColorScheme.selectedScheme.values.title).keyup();
			$editableSchemeColors.find('.js-text').val(AppColorScheme.selectedScheme.values.text).keyup();
			$editableSchemeColors.find('.js-accent').val(AppColorScheme.selectedScheme.values.accent).keyup();
			$editableSchemeColors.find('.js-link').val(AppColorScheme.selectedScheme.values.link).keyup();
			$editableSchemeColors.find('.js-border').val(AppColorScheme.selectedScheme.values.border).keyup();
		},

		deselectScheme: function() {
			AppColorScheme.$schemes.each(function() {
				$(this).removeClass('selected');
			});
		},

		loadThemeColorSchemes: function () {
			//configure handlebars
			var source   = AppColorScheme.$container.find("#js-color-scheme-template").html();
			var template = Handlebars.compile(source);
			var data = AppColorScheme.getThemeColorSchemes();

			//loading page
			AppColorScheme.$colorSchemesContainer.append(template(data)).fadeIn();

			//cache schemes data
			AppColorScheme.schemes = data;

			//colorize squares
			AppColorScheme.colorizeBoxes();

			//colorize user current scheme
			AppColorScheme.colorizeCurrent();
		},

		colorizeCurrent: function() {

			for(var i = 0; i < AppColorScheme.schemes.schemes.length; i++) {
			    var obj = AppColorScheme.schemes.schemes[i];

			    if(obj.selected == true) {
			    	AppColorScheme.selectedScheme = obj;
			    }
			}

			AppColorScheme.populateEditableColors();
		},

		colorizeBoxes: function() {
			//get all color boxes
			var $boxes = $('.js-color-box');

			//change background to the value of data-color
			$boxes.each(function() {
				$(this).css('background', $(this).data('color'));
			});
		},

		getThemeColorSchemeById: function(id) {

			for(var i = 0; i < AppColorScheme.schemes.schemes.length; i++) {
			    var obj = AppColorScheme.schemes.schemes[i];

			    if(obj.id == id) {
			    	return obj;
			    }
			}
		},

		getThemeColorSchemes: function() {
			//data in json
			return { 'schemes': [
				{ 
					'id'		: 0,
					'name'		: 'reddish',
					'values'	: 
								{
									'background': '#330000',
									'title'		: '#330033',
									'text'		: '#330066',
									'accent'	: '#330099',
									'link'		: '#3300CC',
									'border'	: '#3300FF'
								}, 
					'selected' 	: false 
				},
				{ 
					'id'		: 1,
					'name'		: 'pinkish',
					'values'	: 
								{
									'background': '#990000',
									'title'		: '#990033',
									'text'		: '#990066',
									'accent'	: '#990099',
									'link'		: '#9900CC',
									'border'	: '#9900FF'
								}, 
					'selected' 	: true 
				},
				{ 
					'id'		: 2,
					'name'		: 'bluesh',
					'values'	: 
								{
									'background': '#999900',
									'title'		: '#999933',
									'text'		: '#999966',
									'accent'	: '#999999',
									'link'		: '#9999CC',
									'border'	: '#9999FF'
								}, 
					'selected' 	: false 
				},
				{ 
					'id'		: 3,
					'name'		: 'greyish',
					'values'	: 
								{
									'background': '#333300',
									'title'		: '#333333',
									'text'		: '#333366',
									'accent'	: '#333399',
									'link'		: '#3333CC',
									'border'	: '#3333FF'
								}, 
					'selected' 	: false 
				}
			]};
		}
	};

	//object for background
	var AppBackground = {

		$container: { },
		$backgroundWrapper: { },
		$background: { },
		data: { background: null },

		init: function(elem) {
			AppBackground.$container 			= $(elem);
			AppBackground.$backgroundsWrapper 	= AppBackground.$container.find('.js-background-container');

			//load backgrounds
			AppBackground.loadThemeBackgrounds();

			//select anchors after they are loaded
			AppBackground.$backgrounds 			= AppBackground.$container.find('.js-background');

			AppBackground.$backgrounds.each(function() {
				$(this).on('click', AppBackground.selectBackground);
			});

			AppBackground.$container.find('.js-uploader-btn').on('click', AppBackground.showUploaderForm);

			//initialize picture cut plugin
			$("#container_image_mobile").PictureCut({
                InputOfImageDirectory       : "image",
                PluginFolderOnServer        : "/js/plugins/picture-cut/",
                FolderOnServer              : "/img/uploads/background/",
                EnableCrop                  : true,
                CropWindowStyle             : "Bootstrap",
                ImageButtonCSS			  	: {
									              border:"1px #CCC solid",
									              width :86,
									              height:126
									           },
				enableResize 				: false,
				CropModes					: {
									              widescreen: true,
									              letterbox: true,
									              free   : false
									            }
              });

			//initialize picture cut plugin
			$("#container_image_tablet").PictureCut({
                  	InputOfImageDirectory       : "image",
                  	PluginFolderOnServer        : "/js/plugins/picture-cut/",
                  	FolderOnServer              : "/img/uploads/background/",
                  	EnableCrop                  : true,
                  	CropWindowStyle             : "Bootstrap",
                  	ImageButtonCSS			    : {
									              border:"1px #CCC solid",
									              width :158,
									              height:132
									            },
					enableResize 				: false,
					CropModes					: {
									              widescreen: true,
									              letterbox: true,
									              free   : false
									            }
              });
		},

		showUploaderForm: function(e) {

            $('.js-background-uploader-modal').modal('show');

			e.preventDefault();
		},

		selectBackground: function(e) {

			var selectedBackground = $(this).data('id');

			//unhighlight text
			AppBackground.deselectBackground();

			//highlight selected theme
			$(this).addClass('selected');

			//data for form submission
			AppBackground.data.background = selectedBackground;

			e.preventDefault();
		},

		deselectBackground: function() {
			AppBackground.$backgrounds.each(function() {
				$(this).removeClass('selected');
			});
		},

		loadThemeBackgrounds: function () {
			//configure handlebars
			var source   = AppBackground.$container.find("#js-background-template").html();
			var template = Handlebars.compile(source);
			var data = AppBackground.getThemeBackgrounds();

			//loading page
			AppBackground.$backgroundsWrapper.append(template(data)).fadeIn();
		},

		getThemeBackgrounds: function() {
			//data in json
			return { 'backgrounds': [
				{ 
					'id'		: 0,
					'name'		: 'forest',
					'file'		: 'bg8_preview', 
					'selected' 	: false 
				},
				{ 
					'id'		: 1,
					'name'		: 'mountain',
					'file'		: 'bg9_preview', 
					'selected' 	: true 
				},
				{ 
					'id'		: 2,
					'name'		: 'sky',
					'file'		: 'construction_preview', 
					'selected' 	: false 
				},
				{ 
					'id'		: 3,
					'name'		: 'wood',
					'file'		: 'consulting_preview', 
					'selected' 	: false 
				}
			]};
		}	
	};

	var AppMain = {

		init: function(elem) {
			$(elem).on('click', AppMain.saveChanges);
		},

		saveChanges: function(e) {

			console.log('theme: ' + AppTheme.data.theme + 
						'nav: ' + AppNavigation.data.navigation +
						'scheme: ' + AppColorScheme.data.scheme +
						'background: ' + AppBackground.data.background);

			e.preventDefault();
		}
	};

	AppTheme.init('.js-app-styles-tab');
	AppNavigation.init('.js-app-styles-tab');
	AppColorScheme.init('.js-color-scheme-block');
	AppBackground.init('.js-color-scheme-block');
	AppMain.init('.js-save-app-styles');

})();