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
$fieldSet   =   $fieldSets["navigation_params"];
$name       =   'navigation_params';
$fields     =   $form->getFieldset($name);
?>
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