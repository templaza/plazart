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
?>

<fieldset>
    <div class="plazart-admin clearfix">
        <div class="plazart-admin-nav">
            <ul class="nav nav-tabs">
                <?php
                $i = 0;
                foreach ($fieldSets as $name => $fieldSet) :
                    if(in_array($name,array('font_params', 'color_params', 'dev_params','injection_params'))):
                        $label = !empty($fieldSet->label) ? $fieldSet->label : 'COM_TEMPLATES_' . $name . '_FIELDSET_LABEL';
                        ?>
                        <li<?php if($i == 0) {echo ' class="active"';}  ?>><a
                                href="#<?php echo preg_replace('/\s+/', ' ', $name); ?>"
                                data-toggle="tab"><?php echo JText::_($label) ?></a></li>
                    <?php
                    $i++;
                    endif;
                endforeach;
                ?>
            </ul>
        </div>
        <div class="plazart-admin-tabcontent tab-content clearfix">

            <?php
            $j = 0;
            foreach ($fieldSets as $name => $fieldSet) :
                if(in_array($name,array('font_params', 'color_params', 'dev_params','injection_params'))): ?>

                    <div class="tab-pane<?php if($j == 0) {echo ' active';}?>"
                         id="<?php echo preg_replace('/\s+/', ' ', $name); ?>">
                        <?php

                        if (isset($fieldSet->description) && trim($fieldSet->description)) :
                            echo '<div class="plazart-admin-fieldset-desc">' . (JText::_($fieldSet->description)) . '</div>';
                        endif;

                        foreach ($form->getFieldset($name) as $field) :
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
                    </div>

                <?php
                endif; // end if check params

            endforeach; ?>

        </div>
    </div>
</fieldset>