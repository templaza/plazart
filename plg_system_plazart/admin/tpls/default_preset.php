<?php
/**
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2012-2015 TemPlaza.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       TemPlaza (contribute to this project at github
 * @Link:         http://www.templaza.com/
 *------------------------------------------------------------------------------
 */

defined('_JEXEC') or die;
$fieldSet   =   $fieldSets["preset_params"];
$name       =   'preset_params';
$fields     =   $form->getFieldset($name);
?>

<div class="plazart-admin-header clearfix">
    <div class="controls-row">
        <div class="control-group plazart-control-group">
            <div class="control-label plazart-control-label">
                <label id="config_manager_save_filename-lbl" for="config_manager_save_filename" class="hasTip"
                       title="<?php echo JText::_('PLAZART_PRESET_TPL_SAVE_DESC'); ?>"><?php echo JText::_('PLAZART_PRESET_TPL_SAVE'); ?></label>
            </div>
            <div class="controls plazart-controls">
                <input type="text" id="config_manager_save_filename" name="config_manager_save_filename"
                       class="input-medium" placeholder="<?php echo JText::_('PLAZART_PRESET_TPL_SAVE_PLACE'); ?>"/>
            </div>
        </div>
        <div class="control-group plazart-control-group">
            <div class="control-label plazart-control-label">
                <label id="jform_params_presetimage-lbl" for="jform_params_presetimage" class="hasTip"
                       title="<?php echo JText::_('PLAZART_PRESET_IMAGE_SAVE_DESC'); ?>"><?php echo JText::_('PLAZART_PRESET_IMAGE_SAVE'); ?></label>
            </div>
            <div class="controls plazart-controls">
                <?php echo $fields["jform_params_presetimage"]->input; ?>
            </div>
        </div>

        <div class="control-group plazart-control-group">
            <div class="control-label plazart-control-label">
                <label id="config_manager_presetdemo-lbl" for="config_manager_presetdemo" class="hasTip"
                       title="<?php echo JText::_('PLAZART_PRESET_DEMO_DESC'); ?>"><?php echo JText::_('PLAZART_PRESET_DEMO'); ?></label>
            </div>
            <div class="controls plazart-controls">
                <input type="text" id="config_manager_presetdemo" name="config_manager_presetdemo"
                       class="input-medium" placeholder="<?php echo JText::_('PLAZART_PRESET_DEMO_PLACE'); ?>"/>
            </div>
        </div>

        <div class="control-group plazart-control-group">
            <div class="control-label plazart-control-label">
                <label id="config_manager_presetdoc-lbl" for="config_manager_presetdoc" class="hasTip"
                       title="<?php echo JText::_('PLAZART_PRESET_DOC_DESC'); ?>"><?php echo JText::_('PLAZART_PRESET_DOC'); ?></label>
            </div>
            <div class="controls plazart-controls">
                <input type="text" id="config_manager_presetdoc" name="config_manager_presetdoc"
                       class="input-medium" placeholder="<?php echo JText::_('PLAZART_PRESET_DOC_PLACE'); ?>"/>
            </div>
        </div>
        <div class="control-group plazart-control-group">
            <div class="controls plazart-controls">
                <button id="config_manager_presetsave-btn" class="btn btn-success"><i class="fa fa-floppy-o"></i><?php echo JText::_('JAPPLY'); ?></button>
            </div>
        </div>
    </div>
</div>
<fieldset>
    <?php
    if (isset($fieldSet->description) && trim($fieldSet->description)) :
        echo '<div class="plazart-admin-fieldset-desc">' . (JText::_($fieldSet->description)) . '</div>';
    endif;
    ?>

    <div class="control-group plazart-control-group">
        <div class="plazart-presets">
            <?php echo $fields["jform_params_preset"]->input; ?>
        </div>
    </div>

</fieldset>