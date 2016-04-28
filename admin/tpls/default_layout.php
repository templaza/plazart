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
$fieldSet   =   $fieldSets["layout_params"];
$name       =   'layout_params';
$fields     =   $form->getFieldset($name);

$paramsT    = $japp->getUserState('oparams');
$layoutSave = $paramsT['layoutsave'];
if(isset($layoutSave) && $layoutSave != '' && $layoutSave != 0) {
    $layoutSave = 1;
}else {
    $layoutSave = 0;
}

?>
<?php if($layoutSave == 1):?>
<div class="plazart-admin-header clearfix">
    <div class="controls-row">
        <div class="control-group plazart-control-group">
            <div class="control-label plazart-control-label">
                <label id="config_manager_layoutsave-lbl" for="config_manager_layoutsave" class="hasTip"
                       title="<?php echo JText::_('PLAZART_LAYOUT_SAVE'); ?>"><?php echo JText::_('PLAZART_LAYOUT_SAVE'); ?></label>
            </div>
            <div class="controls plazart-controls layoutsave">
                <button type="button" id="config_manager_layoutsave-btn" class="btn btn-success"><i class="fa fa-floppy-o"></i><?php echo JText::_('JAPPLY'); ?></button>
                <div class="mess"></div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<fieldset>
    <?php
    if (isset($fieldSet->description) && trim($fieldSet->description)) :
        echo '<div class="plazart-admin-fieldset-desc">' . (JText::_($fieldSet->description)) . '</div>';
    endif;

    foreach ($fields as $field) :

        $hide = ($field->type === 'PlazartDepend' && $form->getFieldAttribute($field->fieldname, 'function', '', $field->group) == '@group');
        if ($field->type == 'Text') {
            // add placeholder to Text input
            $textinput = str_replace('/>', ' placeholder="' . $form->getFieldAttribute($field->fieldname, 'default', '', $field->group) . '"/>', $field->input);
        }
        ?>
        <?php if ($field->hidden || ($field->type == 'PlazartDepend' && !$field->label)) : ?>
        <?php echo $field->input; ?>
    <?php else : ?>
        <div class="control-group plazart-control-group<?php echo $hide ? ' hide' : '' ?>">
            <div class="control-label plazart-control-label">
                <?php echo $field->label; ?>
            </div>
            <div class="controls plazart-controls">
                <?php echo $field->type == 'Text' ? $textinput : $field->input ?>
            </div>
        </div>
    <?php endif; ?>

    <?php endforeach; ?>
</fieldset>
<?php
    $idTemplate = JFactory::getApplication()->input->get('id');
?>
<script type="text/javascript">

    jQuery(document).ready(function($){

        $('#config_manager_layoutsave-btn').live('click', function(e){
            var url_base    = "<?php echo JUri::root();?>";
            var IDTemplate  = <?php echo $idTemplate;?>;
            var result      = '';
            window.saveAjaxLayout(url_base,IDTemplate);
        });
        <?php if($layoutSave == 0):?>
        document.adminForm.onsubmit = function() {
            window.LayoutJSave();
        }
        <?php endif;?>

    });
</script>
