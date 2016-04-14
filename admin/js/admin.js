/**
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2012-2013 TemPlaza.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       TemPlaza
 * @Link:         http://templaza.com
 *------------------------------------------------------------------------------
 */
/**
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org
 *------------------------------------------------------------------------------
 */

var PlazartAdmin = window.PlazartAdmin || {};

!function ($) {
    "use strict";
	$.extend(PlazartAdmin, {

		initBuildLessBtn: function(){

            var tzsubmitform = function(task, form) {
                if (typeof(form) === 'undefined') {
                    form = document.getElementById('adminForm');
                }

                if (typeof(task) !== 'undefined' && task !== "") {
                    form.task.value = task;
                }

                // Submit the form.
                if (typeof form.onsubmit == 'function') {
                    form.onsubmit();
                }else {
                    if (typeof form.fireEvent == "function") {
                        form.fireEvent('onsubmit');
                    }else{
                        if (typeof $ == "function") {
                            $(form).submit();
                        }
                    }
                }
                form.submit();
            };
			//plazart added
			//$('#plazart-admin-tb-recompile').on('click', function(){
			//	var jrecompile = $(this);
			//	jrecompile.addClass('loading');
            //
			//	$.ajax({
			//		url: PlazartAdmin.adminurl,
			//		data: {'plazartaction': 'lesscall', 'styleid': PlazartAdmin.templateid },
			//		success: function(rsp){
			//			jrecompile.removeClass('loading');
            //
			//			rsp = $.trim(rsp);
			//			if(rsp){
			//				var json = rsp;
			//				if(rsp.charAt(0) != '[' && rsp.charAt(0) != '{'){
			//					json = rsp.match(new RegExp('{[\["].*}'));
			//					if(json && json[0]){
			//						json = json[0];
			//					}
			//				}
            //
			//				if(json && typeof json == 'string'){
			//					try {
			//						json = $.parseJSON(json);
			//					} catch (e){
			//						json = {
			//							error: PlazartAdmin.langs.unknownError
			//						}
			//					}
            //
			//					if(json && (json.error || json.successful)){
			//						PlazartAdmin.systemMessage(json.error || json.successful);
			//					}
			//				}
			//			}
			//		},
            //
			//		error: function(){
			//			jrecompile.removeClass('loading');
			//			PlazartAdmin.systemMessage(PlazartAdmin.langs.unknownError);
			//		}
			//	});
			//	return false;
			//});

			//$('#plazart-admin-tb-themer').on('click', function(){
			//	if(!PlazartAdmin.themermode){
			//		alert(PlazartAdmin.langs.enableThemeMagic);
			//	} else {
			//		window.location.href = PlazartAdmin.themerUrl;
			//	}
			//	return false;
			//});

			//for style toolbar
			$('#plazart-admin-tb-style-save-save').on('click', function(){
                var form = document.adminForm;
                var urlparts = form.action.split('#');
                var hash = window.location.hash;

                if(hash){
                    hash = hash.substring(1);
                    if(urlparts[0].indexOf('?') == -1){
                        urlparts[0] += '?plazartlock=' + hash;
                    } else {
                        urlparts[0] += '&plazartlock=' + hash;
                    }
                    form.action = urlparts.join('#');

                }
                tzsubmitform('style.apply',document.adminForm);
			});

            $('#config_manager_presetsave-btn').on('click', function(){
                var form = document.adminForm;
                var urlparts = form.action.split('#');
                var hash = window.location.hash;

                if(hash){
                    hash = hash.substring(1);
                    if(urlparts[0].indexOf('?') == -1){
                        urlparts[0] += '?plazartlock=' + hash;
                    } else {
                        urlparts[0] += '&plazartlock=' + hash;
                    }
                    form.action = urlparts.join('#');

                }
                tzsubmitform('style.apply',document.adminForm);
            });

			$('#plazart-admin-tb-style-save-close').on('click', function(){
                tzsubmitform('style.save',document.adminForm);
			});
			
			$('#plazart-admin-tb-style-save-clone').on('click', function(){
                tzsubmitform('style.save2copy',document.adminForm);
			});

			$('#plazart-admin-tb-close').on('click', function(){
                tzsubmitform(($(this).hasClass('template') ? 'template' : 'style') + '.cancel',document.adminForm);
			});
            $('#plazart-admin-tb-help').on('click', function(){
                if (PlazartAdmin.documentation) {
                    var win = window.open(PlazartAdmin.documentation, '_blank');
                    win.focus();
                }
            });
		},

		initRadioGroup: function(){
			//copy from J3.0
			// Turn radios into btn-group
			$('.radio.btn-group label').addClass('btn');
			$('.btn-group label').unbind('click').click(function() {
				var label = $(this),
					input = $('#' + label.attr('for'));

				if (!input.prop('checked')){
					label.closest('.btn-group')
						.find('label')
						.removeClass('active btn-success btn-danger btn-primary');

					label.addClass('active ' + (input.val() === '' ? 'btn-primary' : (input.val() === 0 ? 'btn-danger' : 'btn-success')));
					
					input.prop('checked', true).trigger('change');
				}
			});

			$('.plazart-admin-form').on('update', 'input[type=radio]', function(){
				if(this.checked){
					$(this)
						.closest('.btn-group')
						.find('label').removeClass('active btn-success btn-danger btn-primary')
						.filter('[for="' + this.id + '"]')
							.addClass('active ' + ($(this).val() === '' ? 'btn-primary' : ($(this).val() === 0 ? 'btn-danger' : 'btn-success')));
				}
			});

			$('.btn-group input[checked=checked]').each(function(){
				if($(this).val() === ''){
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-primary');
				} else if($(this).val() === 0){
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-danger');
				} else {
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-success');
				}
			});
		},
		
		initChosen: function(){
			$('#style-form').find('select:not(#plazart_layout_builder select)').chosen({
				disable_search_threshold : 10,
				allow_single_deselect : true
			});
		},

		initPlazartTitle: function(){
			var jptitle = $('.pagetitle');
			if (!jptitle.length){
				jptitle = $('.page-title');
			}

            if(!jptitle.length){
                return;
            }

            var titles = jptitle.html().split(':');

			jptitle.removeClass('icon-48-thememanager').html(titles[0] + '<small>' + titles[1] + '</small>');

			//remove joomla title
			$('#template-manager .tpl-desc-name').remove();

            //template manager - J2.5
            $('#template-manager-css')
                .closest('form').addClass('form-inline')
                .find('button[type=submit]').addClass('btn');
		},

		hideDisabled: function(){
			$('#style-form').find('[disabled="disabled"]').filter(function(){
                 if (typeof this.name != 'undefined')return this.name.match(/^.*?\[params\]\[(.*?)\]/)
			}).closest('.control-group').hide();
		},

        initPreSubmit: function(){

            var form = document.adminForm;
            if(!form){
                return false;
            }

            var onsubmit = form.onsubmit;

            form.onsubmit = function(e){
                var urlparts = form.action.split('#');

                if(/apply|save2copy/.test(form.task.value)){
                    var plazartactive = $('.plazart-admin-nav .active a').attr('href').replace(/.*(?=#[^\s]*$)/, '').substr(1);

                    if(urlparts[0].indexOf('?') == -1){
                        urlparts[0] += '?plazartlock=' + plazartactive;
                    } else {
                        urlparts[0] += '&plazartlock=' + plazartactive;
                    }

                    form.action = urlparts.join('#');
                }

                if($.isFunction(onsubmit)){
                    onsubmit();
                }
            };
        },

		initChangeStyle: function(){
			$('#plazart-styles-list').on('change', function(){
				window.location.href = PlazartAdmin.baseurl + '/index.php?option=com_templates&task=style.edit&id=' + this.value;
			});
		},

		initMarkChange: function(){
			var allinput = $(document.adminForm).find(':input')
				.each(function(){
					$(this).data('org-val', (this.type == 'radio' || this.type == 'checkbox') ? $(this).prop('checked') : $(this).val());
				});

			setTimeout(function() {
				allinput.on('change', function(){
					var jinput = $(this),
						oval = jinput.data('org-val'),
						nval = (this.type == 'radio' || this.type == 'checkbox') ? jinput.prop('checked') : jinput.val(),
						eq = true;

					if(oval != nval){
						if($.isArray(oval) && $.isArray(nval)){
							if(oval.length != nval.length){
								eq = false;
							} else {
								for(var i = 0; i < oval.length; i++){
									if(oval[i] != nval[i]){
										eq = false;
										break;
									}
								}
							}
						} else {
							eq = false;
						}
					}

					var jgroup = jinput.closest('.control-group'),
						jpane = jgroup.closest('.tab-pane'),
						chretain = Math.max(0, (jgroup.data('chretain') || 0) + (eq ? -1 : 1));

					jgroup.data('chretain', chretain) [chretain ? 'addClass' : 'removeClass']('plazart-changed');

					$('.plazart-admin-nav .nav li').eq(jpane.index())[(!eq || jpane.find('.plazart-changed').length) ? 'addClass' : 'removeClass']('plazart-changed');

				});
			}, 500);
		},

		initSystemMessage: function(){
			var jmessage = $('#system-message');
				
			if(!jmessage.length){
				jmessage = $('' + 
					'<dl id="system-message">' +
						'<dt class="message">Message</dt>' +
						'<dd class="message">' +
							'<ul><li></li></ul>' +
						'</dd>' +
					'</dl>').hide().appendTo($('#system-message-container'));
			}

			PlazartAdmin.message = jmessage;
		},

        initLayoutBuilder: function () {
            $('#plazart_layout_builder').parent().css('margin', '0');
        },

        initPreset: function () {
            $('.load-preset').click (function (e) {
                e.stopPropagation();
                e.preventDefault();
                $('#loadPreset').modal('toggle');
                var $thisPreset = jQuery(this);
                $('#loadPresetAccept').click(function(e){
                    $("#config_manager_load_filename").val($thisPreset.attr('data-preset'));
                    loadSaveOperation();
                });
            });

            $('.removepreset').click(function (e) {
                e.stopPropagation();
                e.preventDefault();
                $('#removePreset').modal('toggle');
                var $thisPreset = jQuery(this);
                $('#removePresetAccept').click(function(e){
                    $("#config_manager_load_filename").val($thisPreset.attr('data-preset'));
                    deleteOperation();
                });
            });
        },

        initColorStyle: function () {
            $('.plazartcolor_form').each(function(i,el){
                var base_id    =   $(el).find('input.tzFormHide');
                base_id        =   $(base_id).attr('id');

                var base_el    =   $('#'+base_id);
                if(base_el.val() === '') base_el.attr('value','color;rgba(0,0,0,0.8)');
                var values  =   (base_el.val()).split(';');
                // id of selectbox are different from input id
                base_id = base_id.replace('jform_params_color_', 'jformparamscolor_');

                setTimeout(function($this, value){
                    $(el).find('input.plazartcolorpicker').val(value);

                    $(el).find('input.plazartcolorpicker').spectrum({
                        flat:false,
                        showInput:true,
                        preferredFormat: "rgb",
                        showButtons:true,
                        showAlpha:true,
                        showPalette:true,
                        clickoutFiresChange:true,
                        cancelText:"cancel",
                        chooseText:"Choose",
                        palette : [ ['rgba(255, 255, 255, 0)'] ],
                        change: function(color) {
                            var currentcolor = color.toRgbString();
                            base_el.attr('value', $('#' + base_id + '_type').val() + ';' + currentcolor);
                        }
                    });

                    // $this.parent().find('>.popover .rowtextcolor').show();

                }, 300, base_el, values[1]);

                $('#' + base_id + '_type').change(function() {
                    var values  =   (base_el.val()).split(';');
                    base_el.attr('value', $('#' + base_id + '_type').val() + ';' + values[1]);
                });
            });

        },

        initFontStyle: function () {
            $('.tzfont_form').each(function(i, el) {
                el = $(el);

                var base_id = el.find('input.tzFormHide');
                base_id = $(base_id).attr('id');

                var base_el = $('#' + base_id);
                if(base_el.val() === '') base_el.attr('value','standard;Arial, Helvetica, sans-serif');
                var values = (base_el.val()).split(';');
                // id of selectbox are different from input id
                base_id = base_id.replace('jform_params_font_', 'jformparamsfont_');
                $('#'+base_id + '_type').attr('value', values[0]);

                if(values[0] == 'standard') {
                    $('#' + base_id + '_normal').attr('value', values[1]);
                    $('#' + base_id + '_google_own_link').fadeOut();
                    $('#' + base_id + '_google_own_font').fadeOut();
                    $('#' + base_id + '_google_own_link_label').fadeOut();
                    $('#' + base_id + '_google_own_font_label').fadeOut();
                    $('#' + base_id + '_edge_own_link').fadeOut();
                    $('#' + base_id + '_edge_own_font').fadeOut();
                    $('#' + base_id + '_edge_own_link_label').fadeOut();
                    $('#' + base_id + '_edge_own_font_label').fadeOut();
                    $('#' + base_id + '_squirrel_chzn').fadeOut();
                } else if(values[0] == 'google') {

                    $('#' + base_id + '_google_own_link').attr('value', values[2]);
                    $('#' + base_id + '_google_own_font').attr('value', values[3]);
                    $('#' + base_id + '_normal_chzn').fadeOut();
                    $('#' + base_id + '_squirrel_chzn').fadeOut();
                    $('#' + base_id + '_edge_own_link').fadeOut();
                    $('#' + base_id + '_edge_own_font').fadeOut();
                    $('#' + base_id + '_edge_own_link_label').fadeOut();
                    $('#' + base_id + '_edge_own_font_label').fadeOut();
                } else if(values[0] == 'squirrel') {
                    $('#' + base_id + '_squirrel').attr('value', values[1]);
                    $('#' + base_id + '_normal_chzn').fadeOut();
                    $('#' + base_id + '_google_own_link').fadeOut();
                    $('#' + base_id + '_google_own_font').fadeOut();
                    $('#' + base_id + '_google_own_link_label').fadeOut();
                    $('#' + base_id + '_google_own_font_label').fadeOut();
                    $('#' + base_id + '_edge_own_link').fadeOut();
                    $('#' + base_id + '_edge_own_font').fadeOut();
                    $('#' + base_id + '_edge_own_link_label').fadeOut();
                    $('#' + base_id + '_edge_own_font_label').fadeOut();
                } else if(values[0] == 'edge') {
                    $('#' + base_id + '_edge_own_link').attr('value', values[2]);
                    $('#' + base_id + '_edge_own_font').attr('value', values[3]);
                    $('#' + base_id + '_normal_chzn').fadeOut();
                    $('#' + base_id + '_squirrel_chzn').fadeOut();
                    $('#' + base_id + '_google_own_link').fadeOut();
                    $('#' + base_id + '_google_own_font').fadeOut();
                    $('#' + base_id + '_google_own_link_label').fadeOut();
                    $('#' + base_id + '_google_own_font_label').fadeOut();
                }

                $('#' + base_id + '_type').change(function() {
                    var values = (base_el.val()).split(';');

                    if($('#' + base_id + '_type').val() == 'standard') {
                        $('#' + base_id + '_normal_chzn').fadeIn();
                        $('#' + base_id + '_normal').trigger('change');
                        $('#' + base_id + '_google_own_link').fadeOut();
                        $('#' + base_id + '_google_own_font').fadeOut();
                        $('#' + base_id + '_google_own_link_label').fadeOut();
                        $('#' + base_id + '_google_own_font_label').fadeOut();
                        $('#' + base_id + '_edge_own_link').fadeOut();
                        $('#' + base_id + '_edge_own_font').fadeOut();
                        $('#' + base_id + '_edge_own_link_label').fadeOut();
                        $('#' + base_id + '_edge_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel_chzn').fadeOut();
                    } else if($('#' + base_id + '_type').val() == 'google') {

                        $('#' + base_id + '_normal_chzn').fadeOut();
                        $('#' + base_id + '_google_own_link').fadeIn();
                        $('#' + base_id + '_google_own_font').fadeIn();
                        $('#' + base_id + '_google_own_font').trigger('change');
                        $('#' + base_id + '_google_own_link_label').fadeIn();
                        $('#' + base_id + '_google_own_font_label').fadeIn();
                        $('#' + base_id + '_edge_own_link').fadeOut();
                        $('#' + base_id + '_edge_own_font').fadeOut();
                        $('#' + base_id + '_edge_own_link_label').fadeOut();
                        $('#' + base_id + '_edge_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel_chzn').fadeOut();
                    } else if($('#' + base_id + '_type').val() == 'squirrel') {
                        $('#' + base_id + '_normal_chzn').fadeOut();
                        $('#' + base_id + '_google_own_link').fadeOut();
                        $('#' + base_id + '_google_own_font').fadeOut();
                        $('#' + base_id + '_google_own_link_label').fadeOut();
                        $('#' + base_id + '_google_own_font_label').fadeOut();
                        $('#' + base_id + '_edge_own_link').fadeOut();
                        $('#' + base_id + '_edge_own_font').fadeOut();
                        $('#' + base_id + '_edge_own_link_label').fadeOut();
                        $('#' + base_id + '_edge_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel_chzn').fadeIn();
                        $('#' + base_id + '_squirrel').trigger('change');
                    } else if($('#' + base_id + '_type').val() == 'edge') {
                        $('#' + base_id + '_normal_chzn').fadeOut();
                        $('#' + base_id + '_edge_own_link').fadeIn();
                        $('#' + base_id + '_edge_own_font').fadeIn();
                        $('#' + base_id + '_edge_own_font').trigger('change');
                        $('#' + base_id + '_edge_own_link_label').fadeIn();
                        $('#' + base_id + '_edge_own_font_label').fadeIn();
                        $('#' + base_id + '_google_own_link').fadeOut();
                        $('#' + base_id + '_google_own_font').fadeOut();
                        $('#' + base_id + '_google_own_link_label').fadeOut();
                        $('#' + base_id + '_google_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel_chzn').fadeOut();
                    }
                });
                $('#' + base_id + '_type').blur(function() {
                    var values = (base_el.val()).split(';');

                    if($('#' + base_id + '_type').val() == 'standard') {
                        $('#' + base_id + '_normal').fadeIn();
                        $('#' + base_id + '_normal').trigger('change');
                        $('#' + base_id + '_google_own_link').fadeOut();
                        $('#' + base_id + '_google_own_font').fadeOut();
                        $('#' + base_id + '_google_own_link_label').fadeOut();
                        $('#' + base_id + '_google_own_font_label').fadeOut();
                        $('#' + base_id + '_edge_own_link').fadeOut();
                        $('#' + base_id + '_edge_own_font').fadeOut();
                        $('#' + base_id + '_edge_own_link_label').fadeOut();
                        $('#' + base_id + '_edge_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel').css('display', 'none');
                    } else if($('#' + base_id + '_type').val() == 'google') {
                        $('#' + base_id + '_normal').fadeOut();
                        $('#' + base_id + '_google_own_link').fadeIn();
                        $('#' + base_id + '_google_own_font').fadeIn();
                        $('#' + base_id + '_google_own_font').trigger('change');
                        $('#' + base_id + '_google_own_link_label').fadeIn();
                        $('#' + base_id + '_google_own_font_label').fadeIn();
                        $('#' + base_id + '_edge_own_link').fadeOut();
                        $('#' + base_id + '_edge_own_font').fadeOut();
                        $('#' + base_id + '_edge_own_link_label').fadeOut();
                        $('#' + base_id + '_edge_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel').css('display', 'none');
                    } else if($('#' + base_id + '_type').val() == 'squirrel') {
                        $('#' + base_id + '_normal').fadeOut();
                        $('#' + base_id + '_google_own_link').fadeOut();
                        $('#' + base_id + '_google_own_font').fadeOut();
                        $('#' + base_id + '_google_own_link_label').fadeOut();
                        $('#' + base_id + '_google_own_font_label').fadeOut();
                        $('#' + base_id + '_edge_own_link').fadeOut();
                        $('#' + base_id + '_edge_own_font').fadeOut();
                        $('#' + base_id + '_edge_own_link_label').fadeOut();
                        $('#' + base_id + '_edge_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel').fadeIn();
                        $('#' + base_id + '_squirrel').trigger('change');
                    } else if($('#' + base_id + '_type').val() == 'edge') {
                        $('#' + base_id + '_normal').fadeOut();
                        $('#' + base_id + '_edge_own_link').fadeIn();
                        $('#' + base_id + '_edge_own_font').fadeIn();
                        $('#' + base_id + '_edge_own_font').trigger('change');
                        $('#' + base_id + '_edge_own_link_label').fadeIn();
                        $('#' + base_id + '_edge_own_font_label').fadeIn();
                        $('#' + base_id + '_google_own_link').fadeOut();
                        $('#' + base_id + '_google_own_font').fadeOut();
                        $('#' + base_id + '_google_own_link_label').fadeOut();
                        $('#' + base_id + '_google_own_font_label').fadeOut();
                        $('#' + base_id + '_squirrel').css('display', 'none');
                    }
                });

                $('#' + base_id + '_normal').change(function() {
                    base_el.attr('value', $('#' + base_id + '_type').val() + ';' + $('#' + base_id + '_normal').val());
                });
                $('#' + base_id + '_normal').blur(function()  {
                    base_el.attr('value', $('#' + base_id + '_type').val() + ';' + $('#' + base_id + '_normal').val());
                });

                $('#' + base_id + '_google_own_link').keydown(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_google_own_link').val() + ';' +
                            $('#' + base_id + '_google_own_font').val()
                    );
                });
                $('#' + base_id + '_google_own_link').blur(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_google_own_link').val() + ';' +
                            $('#' + base_id + '_google_own_font').val()
                    );
                });

                $('#' + base_id + '_google_own_font').keydown(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_google_own_link').val() + ';' +
                            $('#' + base_id + '_google_own_font').val()
                    );
                });
                $('#' + base_id + '_google_own_font').blur(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_google_own_link').val() + ';' +
                            $('#' + base_id + '_google_own_font').val()
                    );
                });


                $('#' + base_id + '_edge_own_link').keydown(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_edge_own_link').val() + ';' +
                            $('#' + base_id + '_edge_own_font').val()
                    );
                });
                $('#' + base_id + '_edge_own_link').blur(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_edge_own_link').val() + ';' +
                            $('#' + base_id + '_edge_own_font').val()
                    );
                });

                $('#' + base_id + '_edge_own_font').keydown(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_edge_own_link').val() + ';' +
                            $('#' + base_id + '_edge_own_font').val()
                    );
                });
                $('#' + base_id + '_edge_own_font').blur(function() {
                    base_el.attr(
                        'value',
                        $('#' + base_id + '_type').val() + ';' +
                            'own;' +
                            $('#' + base_id + '_edge_own_link').val() + ';' +
                            $('#' + base_id + '_edge_own_font').val()
                    );
                });


                $('#' + base_id + '_squirrel').change(function() {
                    base_el.attr('value', $('#' + base_id + '_type').val() + ';' + $('#' + base_id + '_squirrel').val());
                });
                $('#' + base_id + '_squirrel').blur(function() { base_el.attr('value', $('#' + base_id + '_type').val() + ';' + $('#' + base_id + '_squirrel').val());
                });
            });
        },

        checkVersion: function () {
            if (tzclient.tzupdate && window.location.hostname != 'localhost') {
                $.post(tzclient.tzupdate, {option:'com_tz_membership', view:'checkversion', version:tzclient.version, pc:tzclient.name, s:tzclient.uri})
                    .done(function (data) {
                        if (compareVersion(tzclient.version, data)){
                            $('#tplUpdater').addClass('outdated').find('h3').text(PlazartAdmin.langs.updateHasNew);
                            $('#tplUpdater').find('p').html(PlazartAdmin.langs.updateHasNewMsg+'<strong>'+data+'</strong>.');
                            $('#tplUpdater').find('a').removeClass('disappear');
                        } else {
                            $('#tplUpdater').find('h3').text(PlazartAdmin.langs.updateLatestVersion);
                        }
                    });
            }
        },

		systemMessage: function(msg){
			PlazartAdmin.message.show();
			if(PlazartAdmin.message.find('li:first').length){
				PlazartAdmin.message.find('li:first').html(msg).show();
			} else {
				PlazartAdmin.message.html('' + 
					'<div class="alert">' +
						'<h4>Message</h4>' + 
						'<p>' + msg + '</p>' +
					'</div>');
			}
			
			clearTimeout(PlazartAdmin.msgid);
			PlazartAdmin.msgid = setTimeout(function(){
				PlazartAdmin.message.hide();
			}, 5000);
		},

		alert: function(msg, place){
			clearTimeout($(place).data('alertid'));
			$(place).after('' + 
				'<div class="alert">' +
					'<p>' + msg + '</p>' +
				'</div>').data('alertid', setTimeout(function(){
					$(place).nextAll('.alert').remove();
				}, 5000));
		},

        switchTab: function () {
            var hash = window.location.hash, config_arr = ['#global-config','#menu-config','#layout-config'];
            $('a[data-toggle="tab"]').on('shown', function (e) {
                var url = e.target.href;
                //window.location.hash = url.substring(url.indexOf('#')).replace ('_params', '');
                hash = url.substring(url.indexOf('#')).replace ('_params', '');
            });

            if (hash) {
                $('a[href="' + hash + '_params' + '"]').tab ('show');

            } else {
                var url = $('ul.nav-tabs li.active a').attr('href');
                if (url) {
                    //window.location.hash = url.substring(url.indexOf('#')).replace ('_params', '');
                } else {
                    $('ul.nav-tabs li:first a').tab ('show');
                }
            }
        },

        switchConfig: function() {
            $('.config-view').each(function (){
                if ($(this).hasClass('active')){
                    var plazartactive = $(this).attr('id').replace('plazart','plazart-tb');
                    $('#'+plazartactive).addClass('active');
                }
            });
            $('#plazart-tb-global-config').on('click', function(e){
                e.stopImmediatePropagation();
                $('.config-view').removeClass('active');
                $('.btn-config').removeClass('active');
                $('#plazart-global-config').addClass('active');
                $(this).addClass('active');
            });
            $('#plazart-tb-preset-config').on('click', function(e){
                e.stopImmediatePropagation();
                $('.config-view').removeClass('active');
                $('.btn-config').removeClass('active');
                $('#plazart-preset-config').addClass('active');
                $(this).addClass('active');
            });
            $('#plazart-tb-menu-config').on('click', function(e){
                e.stopImmediatePropagation();
                $('.config-view').removeClass('active');
                $('.btn-config').removeClass('active');
                $('#plazart-menu-config').addClass('active');
                $(this).addClass('active');
            });
            $('#plazart-tb-layout-config').on('click', function(e){
                e.stopImmediatePropagation();
                $('.config-view').removeClass('active');
                $('.btn-config').removeClass('active');
                $('#plazart-layout-config').addClass('active');
                $(this).addClass('active');
            });
            $('#plazart-tb-advanced-config').on('click', function(e){
                e.stopImmediatePropagation();
                $('.config-view').removeClass('active');
                $('.btn-config').removeClass('active');
                $('#plazart-advanced-config').addClass('active');
                $(this).addClass('active');
            });
            $('#plazart-tb-child-override-config').on('click', function(e){
                e.stopImmediatePropagation();
                $('.config-view').removeClass('active');
                $('.btn-config').removeClass('active');
                $('#plazart-child-override-config').addClass('active');
                $(this).addClass('active');
            });
        },

        fixValidate: function(){
            if(typeof JFormValidator != 'undefined'){

                //overwrite
                JFormValidator.prototype.isValid = function (form) {

                    var valid = true;

                    // Precompute label-field associations
                    var labels = document.getElementsByTagName('label');
                    for (var i = 0; i < labels.length; i++) {
                        if (labels[i].htmlFor !== '') {
                            var element = document.getElementById(labels[i].htmlFor);
                            if (element) {
                                element.labelref = labels[i];
                            }
                        }
                    }

                    // Validate form fields
                    var elements = form.getElements('fieldset').concat(Array.from(form.elements));
                    for (i = 0; i < elements.length; i++) {
                        if (this.validate(elements[i]) === false) {
                            valid = false;
                        }
                    }

                    // Run custom form validators if present
                    new Hash(this.custom).each(function (validator) {
                        if (validator.exec() !== true) {
                            valid = false;
                        }
                    });

                    if (!valid) {
                        var message = Joomla.JText._('JLIB_FORM_FIELD_INVALID');
                        var errors = jQuery("label.invalid");
                        var error = {};
                        error.error = [];
                        for (i=0;i < errors.length; i++) {
                            var label = jQuery(errors[i]).text();
                            if (label != 'undefined') {
                                error.error[i] = message+label.replace("*", "");
                            }
                        }
                        Joomla.renderMessages(error);
                    }

                    return valid;
                };

                JFormValidator.prototype.handleResponse = function(state, el){
                    // Set the element and its label (if exists) invalid state
                    if (state === false) {
                        el.addClass('invalid');
                        el.set('aria-invalid', 'true');
                        if (el.labelref) {
                            document.id(el.labelref).addClass('invalid');
                            document.id(el.labelref).set('aria-invalid', 'true');
                        }
                    } else {
                        el.removeClass('invalid');
                        el.set('aria-invalid', 'false');
                        if (el.labelref) {
                            document.id(el.labelref).removeClass('invalid');
                            document.id(el.labelref).set('aria-invalid', 'false');
                        }
                    }
                };

            }
        },

        ovCodeMirror: function() {
            if($('#child_file_edit2').length > 0) {
                var $editorOV = '';
                (function (cm) { cm.keyMap["default"]["Ctrl-Q"] = function (cm) { cm.setOption("fullScreen", !cm.getOption("fullScreen")); }; cm.keyMap["default"]["F10"] = function (cm) { cm.setOption("fullScreen", !cm.getOption("fullScreen")); }; cm.keyMap["default"]["Esc"] = function (cm) { cm.getOption("fullScreen") && cm.setOption("fullScreen", false); }; cm.modeURL = PlazartAdmin.rooturl + "\/media\/editors\/codemirror\/mode\/%N\/%N.min.js"; }(CodeMirror));
                (function (id, options) {
                    Joomla.editors.instances[id] = CodeMirror.fromTextArea(document.getElementById(id), options);
                    CodeMirror.autoLoadMode(Joomla.editors.instances[id], options.mode);
                    Joomla.editors.instances[id].on("gutterClick", function (cm, n, gutter) {
                        if (gutter != "CodeMirror-markergutter") { return; }
                        var info = cm.lineInfo(n);
                        var hasMarker = !!info.gutterMarkers && !!info.gutterMarkers["CodeMirror-markergutter"];
                        var makeMarker = function () {
                            var marker = document.createElement("div");
                            marker.className = "CodeMirror-markergutter-mark";
                            return marker;
                        };
                        cm.setGutterMarker(n, "CodeMirror-markergutter", hasMarker ? null : makeMarker());
                    });
                    !!jQuery && jQuery(function ($) {
                        $(document.body).on("shown shown.bs.tab shown.bs.modal", function () {
                            Joomla.editors.instances[id].refresh();
                        });
                    });
                    $editorOV = Joomla.editors.instances[id];
                }("child_file_edit2", {"autofocus":true,"lineWrapping":true,"styleActiveLine":true,"lineNumbers":true,"gutters":["CodeMirror-linenumbers","CodeMirror-foldgutter","CodeMirror-markergutter"],"foldGutter":true,"mode":"php","theme":"default","autoCloseTags":true,"matchTags":true,"autoCloseBrackets":true,"matchBrackets":true,"scrollbarStyle":"native","vimMode":false}));

                return $editorOV;
            }
        },

        ovChildMenuFd: function() {
            $('.config-view ul.directory-tree li.plz-folder a').click(function(){
                $(this).next().toggleClass('open');
            });
        },

        ovCheckDeleteInput: function() {

            //$('.btn-file-create:not(.disabled)').click(function(e){
            //    e.preventDefault();
            //    var $controll = $(this).closest('.control');
            //    if($(this).hasClass('btn-create-success')) {
            //        $(this).removeClass('btn-create-success');
            //        $('input.input-file-create', $controll).prop("checked", false);
            //    }else {
            //        $(this).addClass('btn-create-success');
            //        $('input.input-file-create', $controll).prop("checked", true);
            //    }
            //});
            //
            //$('.btn-file-delete:not(.disabled)').click(function(e){
            //    e.preventDefault();
            //    var $controll = $(this).closest('.control');
            //    if($(this).hasClass("btn-delete")) {
            //        $(this).removeClass("btn-delete");
            //        $('input.input-file-delete', $controll).prop("checked", false);
            //    }else {
            //        $(this).addClass("btn-delete");
            //        $('input.input-file-delete', $controll).prop("checked", true);
            //    }
            //});
        }



	});
	
	$(document).ready(function(){
		PlazartAdmin.initSystemMessage();
		PlazartAdmin.initMarkChange();
		PlazartAdmin.initPlazartTitle();
		PlazartAdmin.initBuildLessBtn();
		PlazartAdmin.initRadioGroup();
		PlazartAdmin.initChosen();
		PlazartAdmin.initPreSubmit();
		PlazartAdmin.hideDisabled();
		PlazartAdmin.initChangeStyle();
        PlazartAdmin.initLayoutBuilder();
		PlazartAdmin.switchTab();
		PlazartAdmin.switchConfig();
        PlazartAdmin.fixValidate();
        PlazartAdmin.ovChildMenuFd();
        PlazartAdmin.ovCheckDeleteInput();
        PlazartAdmin.ovCodeMirror();
	});

    $(window).load(function () {
        PlazartAdmin.initPreset();
        PlazartAdmin.initFontStyle();
        PlazartAdmin.initColorStyle();
        PlazartAdmin.checkVersion();
    });


    window.ovEditDefault = function(e) {
        e.preventDefault();
        $('#child_file_edit2').html("");
        PlazartAdmin.ovCodeMirror();
    }

    // function child loading
    window.ovLoading    = function() {

        var $htmlLoading    = '<div id="ov-loader"><div class="ov-loader"><div class="ov-inner one"></div><div class="ov-inner two"></div><div class="ov-inner three"></div></div></div>';
        $('body').append($htmlLoading);

    }

    window.ovRMLoading  = function() {
        $('#ov-loader').remove();
    }

    // End function child loading

    window.ovChildAjax = function($url) {

        var $editOv     = null;
        var $styleID    = '&styleid=' + PlazartAdmin.templateid;

        $('.btn-file-create').live('click', function(e){
            e.preventDefault();
            ovLoading();
            var $controll = $(this).closest('.control');
            var $fileValue  = $('input.input-file-create', $controll).val();
            $(this).removeClass('btn-file-create');
            $(this).addClass('btn-file-edit');

            jQuery.ajax({
                type: 'post',
                url: $url+'?plazartaction=copy_file' + $styleID,
                data: {
                    fieldvalue: $fileValue
                },
                complete: function(result){
                    ovRMLoading();
                    var $getResult  = result.responseText;
                    var $dataResult = $.parseJSON($getResult);
                    var $arrMess    = $dataResult.mess;
                    $arrMess.toString();
                    var $status     = $dataResult.status;
                    var $newFile    = $dataResult.newFile;
                    $('input.input-file-create', $controll).val($newFile);
                    $('input.input-file-delete', $controll).val($newFile);

                    if($status == 1) {
                        $controll.find('.btn-file-edit').html('<i class="fa fa-pencil"></i>Edit File');
                        $controll.find('.btn-file-delete').removeProp('disabled');
                        $controll.find('.btn-file-delete').addClass('btn-delete');
                        //$controll.find('.btn-group').append('<p class="mess success">Copy File Success</p>');
                        //$controll.find('.btn-group .mess').hide(3000,'linear');

                    }else {
                        $('#ovChildMess-error').append('<p>'+$arrMess+'</p>');
                        //$controll.find('.btn-group').append('<p class="mess error">Copy File Error</p>');
                    }
                }
            });
        });

        $('.btn-file-delete').live('click', function(e){
            e.preventDefault();

            var r = confirm("Do you want to delete the override file?");
            if (r == true) {
                ovLoading();
                var $controll   = $(this).closest('.control');
                var $fileDelete = $('input.input-file-create', $controll).val();
                jQuery.ajax({
                    type: 'post',
                    url: $url+'?plazartaction=delete_file' + $styleID,
                    data: {
                        fileDelete: $fileDelete
                    },
                    complete: function(result) {
                        ovRMLoading();
                        var $delResult      = result.responseText;
                        var $dataDResult    = $.parseJSON($delResult);
                        var $arrMess        = $dataDResult.mess;
                        $arrMess.toString();
                        var $status         = $dataDResult.status;
                        var $fileOld        = $dataDResult.fileOld;

                        if($status == 1) {

                            if($controll.find('.ov-file.btn-file-edit').length > 0) {

                                var $btnFile    = $controll.find('.btn.ov-file');
                                $btnFile.removeClass('btn-file-edit');
                                $btnFile.addClass('btn-file-create');
                                $btnFile.html('<i class="icon-copy"></i> Override File');
                                $controll.find('.btn-file-delete').prop("disabled", true);
                                $controll.find('.btn-file-delete').removeClass('btn-delete');

                                //$controll.find('.btn-group').append('<p class="mess success">Delete File Success</p>');

                                $('input.input-file-create', $controll).val($fileOld);
                                $('input.input-file-delete', $controll).val($fileOld);

                                //$controll.find('.btn-group .mess').hide(3000,'linear');

                            }
                        }else {
                            //$controll.find('.btn-group').append('<p class="mess error">'+$arrMess+'</p>');
                        }
                    }
                });
            }

        });

        $('.btn-file-edit').live('click', function(e){
            e.preventDefault();
            ovLoading();
            ovEditDefault(e);
            $('.sl-file-edit').css("display","none");
            $('.ovEditFile .control-head > div.control-button').fadeIn('slow');
            $('.CodeMirror.cm-s-default.CodeMirror-wrap').remove();

            var $controll   = $(this).closest('.control');
            var $fileEdit   = $('input.input-file-create', $controll).val();

            jQuery.ajax({
                type: 'post',
                url: $url+'?plazartaction=edit_file' + $styleID,
                data: {
                    fileEdit: $fileEdit
                },
                complete: function(result) {
                    ovRMLoading();
                    var $editResult     = result.responseText;
                    var $dataEFile      = $.parseJSON($editResult);
                    var $arrMess        = $dataEFile.mess;
                    $arrMess.toString();
                    var $status         = $dataEFile.status;
                    var $dataCFile      = $dataEFile.fileContent;
                    var $shortPath      = $dataEFile.filePath;
                    $('#inputFileSave').val($fileEdit);

                    if($status == 1) {
                        $('#child_file_edit2').html($dataCFile);
                        $('.fileNameEdit h2 span').html($shortPath);
                        $editOv = PlazartAdmin.ovCodeMirror();
                    }
                }
            });
        });

        $('.btnFileSave').live('click', function(e){
            e.preventDefault();
            ovLoading();
            var $fileSave   = $('#inputFileSave').val();

            var $fileNewData = '';

            if(typeof $fileSave != 'undefined') {
                $fileNewData = $editOv.getValue();
            }

            if($fileSave != '') {
                jQuery.ajax({
                    type: 'post',
                    url: $url+'?plazartaction=save_file' + $styleID,
                    data: {
                        fileSave: $fileSave,
                        newData: $fileNewData
                    },
                    complete: function(result) {
                        ovRMLoading();
                        var $saveResult     = result.responseText;
                        var $dataSFile      = $.parseJSON($saveResult);
                        var $arrMess        = $dataSFile.mess;
                        $arrMess.toString();
                        var $status         = $dataSFile.status;

                        if($status == 1) {
                            $('.ovEditFile .control-head .mess').html('<p class="success">'+$arrMess+'</p>');
                            $('.ovEditFile .control-head .mess').find('.success').fadeOut(3000);
                        }else {
                            $('.ovEditFile .control-head .mess').html('<p class="error">'+$arrMess+'</p>').hide(3000,'linear');
                            $('.ovEditFile .control-head .mess').find('.error').fadeOut(3000);
                        }
                    }
                });
            }

        });

        $('.btnFileCancel').live('click', function(e) {

            e.preventDefault();
            $('.sl-file-edit').css("display","block");
            ovEditDefault(e);
            $('.CodeMirror.cm-s-default.CodeMirror-wrap').remove();

            $('#inputFileSave').val('');
            $('.fileNameEdit h2 span').html('');
            $('.ovEditFile .control-head > div.control-button').fadeOut('slow');

        });

    };

    //window.ovCodeMirror = function() {
    //    var editor = CodeMirror.fromTextArea(document.getElementById("child_file_edit"), {
    //        mode: 'text/html',
    //        autoCloseTags: true
    //    });
    //}

}(jQuery);


