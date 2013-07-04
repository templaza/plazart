jQuery(window).load(function(){
    // enable config manager
    initConfigManager();
	// fonts forms
	jQuery('.tzfont_form').each(function(i, el) {
		el = jQuery(el);

		var base_id = el.find('input.tzFormHide');
		base_id = jQuery(base_id).attr('id');
		
		var base_el = jQuery('#' + base_id);
		if(base_el.val() == '') base_el.attr('value','standard;Arial, Helvetica, sans-serif');
		var values = (base_el.val()).split(';');
		// id of selectbox are different from input id
		base_id = base_id.replace('jform_params_font_', 'jformparamsfont_');
		jQuery('#'+base_id + '_type').attr('value', values[0]);

		if(values[0] == 'standard') {
			jQuery('#' + base_id + '_normal').attr('value', values[1]);
			jQuery('#' + base_id + '_google_own_link').fadeOut();
			jQuery('#' + base_id + '_google_own_font').fadeOut();
			jQuery('#' + base_id + '_google_own_link_label').fadeOut();
			jQuery('#' + base_id + '_google_own_font_label').fadeOut();
			jQuery('#' + base_id + '_edge_own_link').fadeOut();
			jQuery('#' + base_id + '_edge_own_font').fadeOut();
			jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
			jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
			jQuery('#' + base_id + '_squirrel_chzn').fadeOut();
		} else if(values[0] == 'google') {

			jQuery('#' + base_id + '_google_own_link').attr('value', values[2]);
			jQuery('#' + base_id + '_google_own_font').attr('value', values[3]);
			jQuery('#' + base_id + '_normal_chzn').fadeOut();
			jQuery('#' + base_id + '_squirrel_chzn').fadeOut();
			jQuery('#' + base_id + '_edge_own_link').fadeOut();
			jQuery('#' + base_id + '_edge_own_font').fadeOut();
			jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
			jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
		} else if(values[0] == 'squirrel') {
			jQuery('#' + base_id + '_squirrel').attr('value', values[1]);
			jQuery('#' + base_id + '_normal_chzn').fadeOut();
			jQuery('#' + base_id + '_google_own_link').fadeOut();
			jQuery('#' + base_id + '_google_own_font').fadeOut();
			jQuery('#' + base_id + '_google_own_link_label').fadeOut();
			jQuery('#' + base_id + '_google_own_font_label').fadeOut();
			jQuery('#' + base_id + '_edge_own_link').fadeOut();
			jQuery('#' + base_id + '_edge_own_font').fadeOut();
			jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
			jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
		} else if(values[0] == 'edge') {
			jQuery('#' + base_id + '_edge_own_link').attr('value', values[2]);
			jQuery('#' + base_id + '_edge_own_font').attr('value', values[3]);
			jQuery('#' + base_id + '_normal_chzn').fadeOut();
			jQuery('#' + base_id + '_squirrel_chzn').fadeOut();
			jQuery('#' + base_id + '_google_own_link').fadeOut();
			jQuery('#' + base_id + '_google_own_font').fadeOut();
			jQuery('#' + base_id + '_google_own_link_label').fadeOut();
			jQuery('#' + base_id + '_google_own_font_label').fadeOut();
		}

		jQuery('#' + base_id + '_type').change(function() {
				var values = (base_el.val()).split(';');

				if(jQuery('#' + base_id + '_type').val() == 'standard') {
					jQuery('#' + base_id + '_normal_chzn').fadeIn();
					jQuery('#' + base_id + '_normal').trigger('change');
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_link').fadeOut();
					jQuery('#' + base_id + '_edge_own_font').fadeOut();
					jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel_chzn').fadeOut();
				} else if(jQuery('#' + base_id + '_type').val() == 'google') {

					jQuery('#' + base_id + '_normal_chzn').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeIn();
					jQuery('#' + base_id + '_google_own_font').fadeIn();
					jQuery('#' + base_id + '_google_own_font').trigger('change');
					jQuery('#' + base_id + '_google_own_link_label').fadeIn();
					jQuery('#' + base_id + '_google_own_font_label').fadeIn();
					jQuery('#' + base_id + '_edge_own_link').fadeOut();
					jQuery('#' + base_id + '_edge_own_font').fadeOut();
					jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel_chzn').fadeOut();
				} else if(jQuery('#' + base_id + '_type').val() == 'squirrel') {
					jQuery('#' + base_id + '_normal_chzn').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_link').fadeOut();
					jQuery('#' + base_id + '_edge_own_font').fadeOut();
					jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel_chzn').fadeIn();
					jQuery('#' + base_id + '_squirrel').trigger('change');
				} else if(jQuery('#' + base_id + '_type').val() == 'edge') {
					jQuery('#' + base_id + '_normal_chzn').fadeOut();
					jQuery('#' + base_id + '_edge_own_link').fadeIn();
					jQuery('#' + base_id + '_edge_own_font').fadeIn();
					jQuery('#' + base_id + '_edge_own_font').trigger('change');
					jQuery('#' + base_id + '_edge_own_link_label').fadeIn();
					jQuery('#' + base_id + '_edge_own_font_label').fadeIn();
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel_chzn').fadeOut();
				} 
			});
			jQuery('#' + base_id + '_type').blur(function() {
				var values = (base_el.val()).split(';');
				
				if(jQuery('#' + base_id + '_type').val() == 'standard') {
					jQuery('#' + base_id + '_normal').fadeIn();
					jQuery('#' + base_id + '_normal').trigger('change');
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_link').fadeOut();
					jQuery('#' + base_id + '_edge_own_font').fadeOut();
					jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').css('display', 'none');
				} else if(jQuery('#' + base_id + '_type').val() == 'google') {
					jQuery('#' + base_id + '_normal').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeIn();
					jQuery('#' + base_id + '_google_own_font').fadeIn();
					jQuery('#' + base_id + '_google_own_font').trigger('change');
					jQuery('#' + base_id + '_google_own_link_label').fadeIn();
					jQuery('#' + base_id + '_google_own_font_label').fadeIn();
					jQuery('#' + base_id + '_edge_own_link').fadeOut();
					jQuery('#' + base_id + '_edge_own_font').fadeOut();
					jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').css('display', 'none');
				} else if(jQuery('#' + base_id + '_type').val() == 'squirrel') {
					jQuery('#' + base_id + '_normal').fadeOut();
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_link').fadeOut();
					jQuery('#' + base_id + '_edge_own_font').fadeOut();
					jQuery('#' + base_id + '_edge_own_link_label').fadeOut();
					jQuery('#' + base_id + '_edge_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').fadeIn();
					jQuery('#' + base_id + '_squirrel').trigger('change');
				} else if(jQuery('#' + base_id + '_type').val() == 'edge') {
					jQuery('#' + base_id + '_normal').fadeOut();
					jQuery('#' + base_id + '_edge_own_link').fadeIn();
					jQuery('#' + base_id + '_edge_own_font').fadeIn();
					jQuery('#' + base_id + '_edge_own_font').trigger('change');
					jQuery('#' + base_id + '_edge_own_link_label').fadeIn();
					jQuery('#' + base_id + '_edge_own_font_label').fadeIn();
					jQuery('#' + base_id + '_google_own_link').fadeOut();
					jQuery('#' + base_id + '_google_own_font').fadeOut();
					jQuery('#' + base_id + '_google_own_link_label').fadeOut();
					jQuery('#' + base_id + '_google_own_font_label').fadeOut();
					jQuery('#' + base_id + '_squirrel').css('display', 'none');
				}
		});
		
		jQuery('#' + base_id + '_normal').change(function() {
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_normal').val()); 
		});
		jQuery('#' + base_id + '_normal').blur(function()  { 
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_normal').val());
		});
		
		jQuery('#' + base_id + '_google_own_link').keydown(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
		jQuery('#' + base_id + '_google_own_link').blur(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
		
		jQuery('#' + base_id + '_google_own_font').keydown(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
		jQuery('#' + base_id + '_google_own_font').blur(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_google_own_link').val() + ';' +
				jQuery('#' + base_id + '_google_own_font').val()
			);
		});
		
		
		jQuery('#' + base_id + '_edge_own_link').keydown(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_edge_own_link').val() + ';' +
				jQuery('#' + base_id + '_edge_own_font').val()
			);
		});
		jQuery('#' + base_id + '_edge_own_link').blur(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_edge_own_link').val() + ';' +
				jQuery('#' + base_id + '_edge_own_font').val()
			);
		});
		
		jQuery('#' + base_id + '_edge_own_font').keydown(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_edge_own_link').val() + ';' +
				jQuery('#' + base_id + '_edge_own_font').val()
			);
		});
		jQuery('#' + base_id + '_edge_own_font').blur(function() {
			base_el.attr(
				'value',
				jQuery('#' + base_id + '_type').val() + ';' +
				'own;' +
				jQuery('#' + base_id + '_edge_own_link').val() + ';' +
				jQuery('#' + base_id + '_edge_own_font').val()
			);
		});
	
		
		jQuery('#' + base_id + '_squirrel').change(function() { 
			base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_squirrel').val()); 
		});
		jQuery('#' + base_id + '_squirrel').blur(function() { base_el.attr('value', jQuery('#' + base_id + '_type').val() + ';' + jQuery('#' + base_id + '_squirrel').val());
		});
	});
});

