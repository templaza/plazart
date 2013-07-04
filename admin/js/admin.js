/** 
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/plazartfw
 * @Link:         http://plazart-framework.org 
 *------------------------------------------------------------------------------
 */

var PlazartAdmin = window.PlazartAdmin || {};

!function ($) {

	$.extend(PlazartAdmin, {
		
		initBuildLessBtn: function(){
			//plazart added
			$('#plazart-admin-tb-recompile').on('click', function(){
				var jrecompile = $(this);
				jrecompile.addClass('loading');

				$.ajax({
					url: PlazartAdmin.adminurl,
					data: {'plazartaction': 'lesscall', 'styleid': PlazartAdmin.templateid },
					success: function(rsp){
						jrecompile.removeClass('loading');

						rsp = $.trim(rsp);
						if(rsp){
							var json = rsp;
							if(rsp.charAt(0) != '[' && rsp.charAt(0) != '{'){
								json = rsp.match(/{.*?}/);
								if(json && json[0]){
									json = json[0];
								}
							}

							if(json && typeof json == 'string'){
								try {
									json = $.parseJSON(json);
								} catch (e){
									json = {
										error: PlazartAdmin.langs.unknownError
									}
								}

								if(json && (json.error || json.successful)){
									PlazartAdmin.systemMessage(json.error || json.successful);
								}
							}
						}
					},

					error: function(){
						jrecompile.removeClass('loading');
						PlazartAdmin.systemMessage(PlazartAdmin.langs.unknownError);
					}
				});
				return false;
			});

			$('#plazart-admin-tb-themer').on('click', function(){
				if(!PlazartAdmin.themermode){
					alert(PlazartAdmin.langs.enableThemeMagic);
				} else {
					window.location.href = PlazartAdmin.themerUrl;
				}
				return false;
			});

			//for style toolbar
			$('#plazart-admin-tb-style-save-save').on('click', function(){
				Joomla.submitbutton('style.apply');
			});

			$('#plazart-admin-tb-style-save-close').on('click', function(){
				Joomla.submitbutton('style.save');
			});
			
			$('#plazart-admin-tb-style-save-clone').on('click', function(){
				Joomla.submitbutton('style.save2copy');
			});

			$('#plazart-admin-tb-close').on('click', function(){
				Joomla.submitbutton(($(this).hasClass('template') ? 'template' : 'style') + '.cancel');
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

					label.addClass('active ' + (input.val() == '' ? 'btn-primary' : (input.val() == 0 ? 'btn-danger' : 'btn-success')));
					
					input.prop('checked', true).trigger('change');
				}
			});

			$('.plazart-admin-form').on('update', 'input[type=radio]', function(){
				if(this.checked){
					$(this)
						.closest('.btn-group')
						.find('label').removeClass('active btn-success btn-danger btn-primary')
						.filter('[for="' + this.id + '"]')
							.addClass('active ' + ($(this).val() == '' ? 'btn-primary' : ($(this).val() == 0 ? 'btn-danger' : 'btn-success')));
				}
			});

			$('.btn-group input[checked=checked]').each(function(){
				if($(this).val() == ''){
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-primary');
				} else if($(this).val() == 0){
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-danger');
				} else {
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-success');
				}
			});
		},
		
		initChosen: function(){
			$('#style-form').find('select').chosen({
				disable_search_threshold : 10,
				allow_single_deselect : true
			});
		},

		initPlazartTitle: function(){
			var jptitle = $('.pagetitle');
			if (!jptitle.length){
				jptitle = $('.page-title');
			}

			var titles = jptitle.html().split(':');

			jptitle.removeClass('icon-48-thememanager').html(titles[0] + '<small>' + titles[1] + '</small>');

			//remove joomla title
			$('#template-manager .tpl-desc-name').remove();
		},

		hideDisabled: function(){
			$('#style-form').find('[disabled="disabled"]').filter(function(){
				return this.name.match(/^.*?\[params\]\[(.*?)\]/)
			}).closest('.control-group').hide();
		},

		initPreSubmit: function(){

			var form = document.adminForm;
			if(!form){
				return false;
			}

			var onsubmit = form.onsubmit;

			form.onsubmit = function(e){
				var json = {},
					urlparts = form.action.split('#');
					
				if(/apply|save2copy/.test(form['task'].value)){
					plazartactive = $('.plazart-admin-nav .active a').attr('href').replace(/.*(?=#[^\s]*$)/, '').substr(1);

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

					jgroup.data('chretain', chretain)
						[chretain ? 'addClass' : 'removeClass']('plazart-changed');

					$('.plazart-admin-nav .nav li').eq(jpane.index())[(!eq || jpane.find('.plazart-changed').length) ? 'addClass' : 'removeClass']('plazart-changed');

				});
			}, 500);
		},

		initCheckupdate: function(){
			
			var tinfo = $('#plazart-admin-tpl-info dd'),
				finfo = $('#plazart-admin-frmk-info dd');

			PlazartAdmin.chkupdating = null;
			PlazartAdmin.tplname = tinfo.eq(0).html();
			PlazartAdmin.tplversion = tinfo.eq(1).html();
			PlazartAdmin.frmkname = finfo.eq(0).html();
			PlazartAdmin.frmkversion = finfo.eq(1).html();
			
			$('#plazart-admin-framework-home .updater, #plazart-admin-template-home .updater').on('click', 'a.btn', function(){
				
				//if it is outdated, then we go direct to link
				if($(this).closest('.updater').hasClass('outdated')){
					return true;
				}

				//if we are checking, ignore this click, wait for it complete
				if(PlazartAdmin.chkupdating){
					return false;
				}

				//checking
				$(this).addClass('loading');
				PlazartAdmin.chkupdating = this;
				PlazartAdmin.checkUpdate();

				return false;
			});
		},

		checkUpdate: function(){
			$.ajax({
				url: PlazartAdmin.plazartupdateurl,
				data: {eid: PlazartAdmin.eids},
				success: function(data) {
					var jfrmk = $('#plazart-admin-framework-home .updater:first'),
						jtemp = $('#plazart-admin-template-home .updater:first');

					jfrmk.find('.btn').removeClass('loading');
					jtemp.find('.btn').removeClass('loading');
					
					try {
						var ulist = $.parseJSON(data);
					} catch(e) {
						PlazartAdmin.alert(PlazartAdmin.langs.updateFailedGetList, PlazartAdmin.chkupdating);
					}

					if (ulist instanceof Array) {
						if (ulist.length > 0) {
							
							var	chkfrmk = !jfrmk.hasClass('outdated'),
								chktemp = !jtemp.hasClass('outdated');

							if(chkfrmk || chktemp){
								for(var i = 0, il = ulist.length; i < il; i++){

									if(chkfrmk && ulist[i].element == PlazartAdmin.felement && ulist[i].type == 'plugin'){
										jfrmk.addClass('outdated');
										jfrmk.find('.btn').attr('href', PlazartAdmin.jupdateUrl).html(PlazartAdmin.langs.updateDownLatest);
										jfrmk.find('h3').html(PlazartAdmin.langs.updateHasNew.replace(/%s/g, PlazartAdmin.frmkname));
										
										var ridx = 0,
											rvals = [PlazartAdmin.frmkversion, PlazartAdmin.frmkname, ulist[i].version];
										jfrmk.find('p').html(PlazartAdmin.langs.updateCompare.replace(/%s/g, function(){
											return rvals[ridx++];
										}));

										PlazartAdmin.langs.updateCompare.replace(/%s/g, function(){ return '' })
									}
									if(chktemp && ulist[i].element == PlazartAdmin.telement && ulist[i].type == 'template'){
										jtemp.addClass('outdated');
										jtemp.find('.btn').attr('href', PlazartAdmin.jupdateUrl).html(PlazartAdmin.langs.updateDownLatest);

										jtemp.find('h3').html(PlazartAdmin.langs.updateHasNew.replace(/%s/g, PlazartAdmin.tplname));
										
										var ridx = 0,
											rvals = [PlazartAdmin.tplversion, PlazartAdmin.tplname, ulist[i].version];
										jtemp.find('p').html(PlazartAdmin.langs.updateCompare.replace(/%s/g, function(){
											return rvals[ridx++];
										}));
									}
								}

								PlazartAdmin.alert(PlazartAdmin.langs.updateChkComplete, PlazartAdmin.chkupdating);
							}
						}
					} else {
						PlazartAdmin.alert(PlazartAdmin.langs.updateFailedGetList, PlazartAdmin.chkupdating);
					}

					PlazartAdmin.chkupdating = null;
				},
				error: function() {
					PlazartAdmin.alert(PlazartAdmin.langs.updateFailedGetList, PlazartAdmin.chkupdating);
					PlazartAdmin.chkupdating = null;
				}
			});
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
			$('a[data-toggle="tab"]').on('shown', function (e) {
				var url = e.target.href;
			  	window.location.hash = url.substring(url.indexOf('#')).replace ('_params', '');
			});

			var hash = window.location.hash;
			if (hash) {
				$('a[href="' + hash + '_params' + '"]').tab ('show');
			} else {
				var url = $('ul.nav-tabs li.active a').attr('href');
				if (url) {
			  		window.location.hash = url.substring(url.indexOf('#')).replace ('_params', '');
				} else {
					$('ul.nav-tabs li:first a').tab ('show');
				}
			}
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
		//PlazartAdmin.initCheckupdate();
		PlazartAdmin.switchTab();
	});
	
}(jQuery);