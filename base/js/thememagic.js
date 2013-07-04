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
 
!function($){
	PlazartTheme = window.PlazartTheme || {};

	$.extend(PlazartTheme, {
		handleLink: function(){
			var links = document.links,
				forms = document.forms,
				origin = [window.location.protocol, '//', window.location.hostname, window.location.port].join(''),
				iter, i, il;

			for(i = 0, il = links.length; i < il; i++) {
				iter = links[i];

				if(iter.href && iter.hostname == window.location.hostname && iter.href.indexOf('#') == -1){
					iter.href = iter.href + (iter.href.lastIndexOf('?') != -1 ? '&' : '?') + (iter.href.lastIndexOf('themer=') == -1 ? 'themer=Y' : ''); 
				}
			}

			
			for(i = 0, il = forms.length; i < il; i++) {
				iter = forms[i];

				if(iter.action.indexOf(origin) == 0){
					iter.action = iter.action + (iter.action.lastIndexOf('?') != -1 ? '&' : '?') + (iter.action.lastIndexOf('themer=') == -1 ? 'themer=Y' : ''); 
				}
			}

			//10 seconds, if the Less build not complete, we just show the page instead of blank page
			PlazartTheme.sid = setTimeout(PlazartTheme.bodyReady, 10000);
		},
		applyLess: function(data){
			if(data && typeof data == 'object'){
				PlazartTheme.vars = data.vars;
				PlazartTheme.others = data.others;
				PlazartTheme.theme = data.theme;		
			}
			
			less.refresh(true);
		},

		onCompile: function(completed, total){
			if(window.parent != window && window.parent.PlazartTheme){
				window.parent.PlazartTheme.onCompile(completed, total);
			}

			if(completed >= total){
				PlazartTheme.bodyReady();
			}
		},

		bodyReady: function(){
			clearTimeout(PlazartTheme.sid);

			if(!this.ready){
				$(document).ready(function(){
					PlazartTheme.ready = 1;
					$(document.body).addClass('ready');
				});
			} else {
				$(document.body).addClass('ready');
			}
		}
	});

	$(document).ready(function(){
		PlazartTheme.handleLink();
	});
	
}(jQuery);
