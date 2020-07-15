//<script>
/**
 * Password Validation for Ossn
 * Modfied the work of :
 *  		http://github.com/IoraHealth/jquery-password-validator
 *  		Made by Myke Cameron
 *  		Under MIT License
 * The modification except the orginal work released under Open Source Social Network License v3
 */ 
var PasswordValidation = new Array();
Array.prototype.remove = function() { //by https://stackoverflow.com/users/80860/kennebec
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
this["JST"] = this["JST"] || {};
this["JST"]["input_wrapper"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="jq-password-validator">\n';

}
return __p
};

this["JST"]["length"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="jq-password-validator__rule is-valid length">\n\t'+Ossn.Print('passwordvalidation:atleast', [((__t = ( length )) == null ? '' : __t)])+'\n</div>\n';

}
return __p
};

this["JST"]["popover"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="jq-password-validator__popover">\n\t<header>'+Ossn.Print('passwordvalidation:passwordmustbe')+'</header>\n</div>\n';

}
return __p
};

this["JST"]["row"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="jq-password-validator__rule ' +
((__t = ( ruleName )) == null ? '' : __t) +
'">\n\t<svg xmlns="http://www.w3.org/2000/svg" class="jq-password-validator__checkmark" viewBox="0 0 8 8">\n\t  <path d="M6.41 0l-.69.72-2.78 2.78-.81-.78-.72-.72-1.41 1.41.72.72 1.5 1.5.69.72.72-.72 3.5-3.5.72-.72-1.44-1.41z" transform="translate(0 1)" />\n\t</svg>\n\t' +
((__t = ( preface )) == null ? '' : __t) +
'\n\t<em>' +
((__t = ( message )) == null ? '' : __t) +
'</em>\n</div>\n';

}
return __p
};
;(function ( $, window, document, undefined ) {

	"use strict";

		// Plugin setup
		var pluginName = "passwordValidator",
				defaults = {
				length: 12,
				require: ["length", "lower", "upper", "digit"]
		};

		// The actual plugin constructor
		function Plugin ( element, options ) {
				this.element = element;
				this.settings = $.extend( {}, defaults, options );
				this._defaults = defaults;
				this._name = pluginName;
				this.init();
		}

		// Actual plugin code follows:

		// Regular expressions used for validation
		var validators = {
				upper: {
						validate: function ( password ) {
								if(password.match(/[A-Z]/) != null){
										PasswordValidation.remove('upper');
										return true;	
								} else {
									if(PasswordValidation.indexOf('upper') == -1){
										PasswordValidation.push('upper');	
									}
									return false;
								}								
						},
						message: Ossn.Print('passwordvalidation:capitalletter')
				},
				lower: {
						validate: function ( password ) {
								if(password.match(/[a-z]/) != null){
										PasswordValidation.remove('lower');
										return true;	
								} else {
									if(PasswordValidation.indexOf('lower') == -1){
										PasswordValidation.push('lower');	
									}
									return false;
								}
						},
						message: Ossn.Print('passwordvalidation:lowerletter')
				},
				digit: {
						validate: function ( password ) {
								if(password.match(/\d/) != null){
										PasswordValidation.remove('digit');
										return true;	
								} else {
									if(PasswordValidation.indexOf('digit') == -1){
										PasswordValidation.push('digit');	
									}
									return false;
								}								
								
						},
						message: Ossn.Print('passwordvalidation:number')
				},
				length: {
						validate: function ( password, settings ) {
								if(password.length >= settings.length){
									PasswordValidation.remove('length');
									return true;
								} 
								if(PasswordValidation.indexOf('length') == -1){
										PasswordValidation.push('length');	
								}
								return false;
						},
						message: function ( settings ) {
								return Ossn.Print('passwordvalidation:atleast', [settings.length]);
						},
						preface: "",
				}
		};

		// Avoid Plugin.prototype conflicts
		$.extend(Plugin.prototype, {
				init: function () {
						this.wrapInput( this.element );
						this.inputWrapper.append( this.buildUi() );
						this.bindBehavior();
				},

				wrapInput: function ( input ) {
						$(input).wrap( JST.input_wrapper() );
						this.inputWrapper = $( ".jq-password-validator" );
						return this.inputWrapper;
				},

				buildUi: function () {
						var ui = $( JST.popover() );
						var _this = this;

						_.each(this.settings.require, function ( requirement ) {
								var message;
								if ( validators[requirement].message instanceof Function ) {
										message = validators[requirement].message( _this.settings );
								} else {
										message = validators[requirement].message;
								}

								var preface = validators[requirement].preface;

								var ruleMarkup = JST.row({
									ruleName: requirement,
									message: message,
									preface: preface
								});

								ui.append( $( ruleMarkup ) );
						});

						this.ui = ui;
						ui.hide();
						return ui;
				},

				bindBehavior: function () {
						var _this = this;
						$( this.element ).on( "focus", function () {
								_this.validate();
								_this.showUi();
						} );
						$( this.element ).on( "blur", function () {
								_this.hideUi();
						} );
						$( this.element ).on( "keyup", function () {
							_this.validate();
						} );
				},

				showUi: function () {
						this.ui.show();
						$( this.element ).parent().removeClass("is-hidden");
						$( this.element ).parent().addClass("is-visible");
				},

				hideUi: function () {
						this.ui.hide();
						$( this.element ).parent().removeClass("is-visible");
						$( this.element ).parent().addClass("is-hidden");
				},

				validate: function () {
						var currentPassword = $(this.element).val();
						var _this = this;
						_.each( this.settings.require, function ( requirement) {
								if ( validators[requirement].validate(currentPassword, _this.settings ) ) {
 									_this.markRuleValid(requirement);
								} else {
									_this.markRuleInvalid(requirement);
								}
						});
						//console.log(PasswordValidation);
				},

				markRuleValid: function (ruleName) {
					var row = this.ui.find("." + ruleName);
					row.addClass( "is-valid" );
					row.removeClass( "is-invalid" );
				},

				markRuleInvalid: function (ruleName) {
					var row = this.ui.find("." + ruleName);
					row.removeClass( "is-valid" );
					row.addClass( "is-invalid" );
				}
		});

		// A really lightweight plugin wrapper around the constructor,
		// preventing against multiple instantiations
		$.fn[ pluginName ] = function ( options ) {
				return this.each(function() {
						if ( !$.data( this, "plugin_" + pluginName ) ) {
								$.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
						}
				});
		};

})( jQuery, window, document );
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
		PasswordValidation.push('length');
		$('#ossn-home-signup input[name="password"]').passwordValidator({
			require: ['length', 'lower', 'upper', 'digit'],
			length: <?php echo PasswordValidationLength; ?>
		});    
    });
});