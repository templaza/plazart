<?php
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

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$user = JFactory::getUser();
$canDo = TemplatesHelper::getActions();
$iswritable = is_writable('plazarttest.txt');
?>
<?php if($iswritable): ?>
<div id="plazart-admin-writable-message" class="alert warning">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong><?php echo JText::_('PLAZART_MSG_WARNING'); ?></strong> <?php echo JText::_('PLAZART_MSG_FILE_NOT_WRITABLE'); ?>
</div>
<?php endif;?>
<div class="plazart-admin-form clearfix">
<form action="<?php echo JRoute::_('index.php?option=com_templates&layout=edit&id='.$input->getInt('id')); ?>" method="post" name="adminForm" id="style-form" class="form-validate form-horizontal">
	<div class="plazart-admin-header clearfix">
		<div class="controls-row">
			<div class="control-group plazart-control-group">
				<div class="control-label plazart-control-label">
					<label id="plazart-styles-list-lbl" for="plazart-styles-list" class="hasTip" title="<?php echo JText::_('PLAZART_SELECT_STYLE_DESC'); ?>"><?php echo JText::_('PLAZART_SELECT_STYLE_LABEL'); ?></label>
				</div>
				<div class="controls plazart-controls">
					<?php echo JHTML::_('select.genericlist', $styles, 'plazart-styles-list', 'autocomplete="off"', 'id', 'title', $input->get('id')); ?>
				</div>
			</div>
			<div class="control-group plazart-control-group">
				<div class="control-label plazart-control-label">
					<?php echo $form->getLabel('title'); ?>
				</div>
				<div class="controls plazart-controls">
					<?php echo $form->getInput('title'); ?>
				</div>
			</div>
			<div class="control-group plazart-control-group hide">
				<div class="control-label plazart-control-label">
					<?php echo $form->getLabel('template'); ?>
				</div>
				<div class="controls plazart-controls">
					<?php echo $form->getInput('template'); ?>
				</div>
			</div>
			<div class="control-group plazart-control-group hide">
				<div class="control-label plazart-control-label">
					<?php echo $form->getLabel('client_id'); ?>
				</div>
				<div class="controls plazart-controls">
					<?php echo $form->getInput('client_id'); ?>
					<input type="text" size="35" value="<?php echo $form->getValue('client_id') == 0 ? JText::_('JSITE') : JText::_('JADMINISTRATOR'); ?>	" class="input readonly" readonly="readonly" />
				</div>
			</div>
			<div class="control-group plazart-control-group">
				<div class="control-label plazart-control-label">
					<?php echo $form->getLabel('home'); ?>
				</div>
				<div class="controls plazart-controls">
					<?php echo $form->getInput('home'); ?>
				</div>
			</div>
		</div>
	</div>
    <div class="plazart-admin-header clearfix">
        <div class="controls-row">
            <div class="control-group plazart-control-group">
                <div class="control-label plazart-control-label">
                    <label id="tz-profiles-list-lbl" for="config_manager_load_filename" class="hasTip" title="<?php echo JText::_('TZ_SELECT_PROFILE_DESC'); ?>"><?php echo JText::_('TZ_SELECT_PROFILE_LABEL'); ?></label>
                </div>
                <div class="controls plazart-controls">
                    <?php echo JHTML::_('select.genericlist', $profiles, 'config_manager_load_filename', 'autocomplete="off"', 'value', 'text','default'); ?>
                    <button id="config_manager_load" class="btn"><i class="icon-download"></i><?php echo JText::_('TPL_TZ_LANG_CONFIG_LOAD_BTN'); ?></button>
                    <button id="config_manager_delete" class="btn"><i class="icon-remove"></i><?php echo JText::_('TPL_TZ_LANG_CONFIG_DELETE_BTN'); ?></button>
                </div>

            </div>
            <div class="control-group plazart-control-group">
                <div class="control-label plazart-control-label">
                    <label id="config_manager_save_filename-lbl" for="config_manager_save_filename" class="hasTip" title="<?php echo JText::_('TPL_TZ_LANG_CONFIG_SAVE_DESC'); ?>"><?php echo JText::_('TPL_TZ_LANG_CONFIG_SAVE'); ?></label>
                </div>
                <div class="controls plazart-controls">
                    <input type="text" id="config_manager_save_filename" name="config_manager_save_filename" class="input-medium" placeholder="<?php echo JText::_('TPL_TZ_LANG_CONFIG_YOUR_FILENAME'); ?>" />
                </div>

            </div>
        </div>
    </div>
	<fieldset>
    <div class="plazart-admin clearfix">
    	<div class="plazart-admin-nav">
			<ul class="nav nav-tabs">
				<li<?php echo $plazartlock == 'overview_params' ? ' class="active"' : ''?>><a href="#overview_params" data-toggle="tab"><?php echo JText::_('PLAZART_OVERVIEW_LABEL');?></a></li>
				<?php
				$fieldSets = $form->getFieldsets('params');
				foreach ($fieldSets as $name => $fieldSet) :
					$label = !empty($fieldSet->label) ? $fieldSet->label : 'COM_TEMPLATES_'.$name.'_FIELDSET_LABEL';
				?>
					<li<?php echo $plazartlock == preg_replace( '/\s+/', ' ', $name) ? ' class="active"' : ''?>><a href="#<?php echo preg_replace( '/\s+/', ' ', $name);?>" data-toggle="tab"><?php echo JText::_($label) ?></a></li>
				<?php
				endforeach;
				?>
				<?php if ($user->authorise('core.edit', 'com_menu') && ($form->getValue('client_id') == 0)):?>
					<?php if ($canDo->get('core.edit.state')) : ?>
							<li<?php echo $plazartlock == 'assignment' ? ' class="active"' : ''?>><a href="#assignment_params" data-toggle="tab"><?php echo JText::_('PLAZART_MENUS_ASSIGNMENT_LABEL');?></a></li>
					<?php endif; ?>
				<?php endif;?>
			</ul>
		</div>
		<div class="plazart-admin-tabcontent tab-content clearfix">
			<div class="tab-pane tab-overview clearfix<?php echo $plazartlock == 'overview_params' ? ' active' : ''?>" id="overview_params">
				<?php
				$default_overview_override = PLAZART_TEMPLATE_PATH . '/admin/default_overview.php';
				if(file_exists($default_overview_override)) {
					include $default_overview_override;
				} else {
					include PLAZART_ADMIN_PATH . '/admin/tpls/default_overview.php';
				}
				?>
			</div>
			<?php
			foreach ($fieldSets as $name => $fieldSet) :
				
				?>
				<div class="tab-pane<?php echo $plazartlock == preg_replace( '/\s+/', ' ', $name) ? ' active' : ''?>" id="<?php echo preg_replace( '/\s+/', ' ', $name); ?>">
					<?php

					if (isset($fieldSet->description) && trim($fieldSet->description)) :
						echo '<div class="plazart-admin-fieldset-desc">'.(JText::_($fieldSet->description)).'</div>';
					endif;

					foreach ($form->getFieldset($name) as $field) :
					$hide = ($field->type === 'PlazartDepend' && $form->getFieldAttribute($field->fieldname, 'function', '', $field->group) == '@group');
					if ($field->type == 'Text') {
						// add placeholder to Text input
						$textinput = str_replace ('/>', ' placeholder="'.$form->getFieldAttribute($field->fieldname, 'default', '', $field->group).'"/>', $field->input);
					}
					?>
					<?php if ($field->hidden || ($field->type == 'PlazartDepend' && !$field->label)) : ?>
						<?php echo $field->input; ?>
					<?php else : ?>
					<div class="control-group plazart-control-group<?php echo $hide ? ' hide' : ''?>">
						<div class="control-label plazart-control-label">
							<?php echo $field->label; ?>
						</div>
						<div class="controls plazart-controls">
							<?php echo $field->type=='Text'?$textinput:$field->input ?>
						</div>
					</div>
					<?php endif; ?>
				<?php endforeach; ?>
				</div>
			<?php endforeach;  ?>

			<?php if ($user->authorise('core.edit', 'com_menu') && $form->getValue('client_id') == 0):?>
				<?php if ($canDo->get('core.edit.state')) : ?>
					<div class="tab-pane clearfix<?php echo $plazartlock == 'assignment' ? ' active' : ''?>" id="assignment_params">
						<?php include PLAZART_ADMIN_PATH . '/admin/tpls/default_assignment.php'; ?>
					</div>
				<?php endif; ?>
			<?php endif;?>
		</div>
  </div>
	</fieldset>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
</div>