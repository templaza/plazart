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
<div class="plazart-admin-header clearfix">
    <div class="controls-row">
        <div class="control-group plazart-control-group">
            <div class="control-label plazart-control-label">
                <label id="plazart-styles-list-lbl" for="plazart-styles-list" class="hasTip"
                       title="<?php echo JText::_('PLAZART_SELECT_STYLE_DESC'); ?>"><?php echo JText::_('PLAZART_SELECT_STYLE_LABEL'); ?></label>
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
                <input type="text" size="35"
                       value="<?php echo $form->getValue('client_id') == 0 ? JText::_('JSITE') : JText::_('JADMINISTRATOR'); ?>	"
                       class="input readonly" readonly="readonly"/>
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

<fieldset>
    <div class="plazart-admin clearfix">
        <div class="plazart-admin-nav">
            <ul class="nav nav-tabs">
                <li<?php echo $plazartlock == 'overview_params' ? ' class="active"' : '' ?>><a href="#overview_params" data-toggle="tab"><?php echo JText::_('PLAZART_OVERVIEW_LABEL'); ?></a>
                </li>
                <?php
                foreach ($fieldSets as $name => $fieldSet) :
                if (!in_array($name,array('layout_params', 'navigation_params', 'preset_params','font_params', 'color_params', 'dev_params','injection_params'))):
                    $label = !empty($fieldSet->label) ? $fieldSet->label : 'COM_TEMPLATES_' . $name . '_FIELDSET_LABEL';
                    ?>
                    <li<?php echo $plazartlock == preg_replace('/\s+/', ' ', $name) ? ' class="active"' : '' ?>><a
                            href="#<?php echo preg_replace('/\s+/', ' ', $name); ?>"
                            data-toggle="tab"><?php echo JText::_($label) ?></a></li>
                <?php
                endif;
                endforeach;
                ?>
                <?php if ($user->authorise('core.edit', 'com_menu') && ($form->getValue('client_id') == 0)): ?>
                    <?php if ($canDo->get('core.edit.state')) : ?>
                        <li<?php echo $plazartlock == 'assignment' ? ' class="active"' : '' ?>><a href="#assignment_params" data-toggle="tab"><?php echo JText::_('PLAZART_MENUS_ASSIGNMENT_LABEL'); ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="plazart-admin-tabcontent tab-content clearfix">
            <div class="tab-pane tab-overview clearfix<?php echo $plazartlock == 'overview_params' ? ' active' : '' ?>" id="overview_params">
                <?php
                $default_overview_override = PLAZART_TEMPLATE_PATH . '/admin/default_overview.php';
                if (file_exists($default_overview_override)) {
                    include $default_overview_override;
                } else {
                    include PLAZART_ADMIN_PATH . '/admin/tpls/default_overview.php';
                }
                ?>
            </div>
            <?php
            foreach ($fieldSets as $name => $fieldSet) :
                if (!in_array($name,array('layout_params', 'navigation_params', 'preset_params','font_params', 'color_params', 'dev_params','injection_params'))):
                ?>
                <div class="tab-pane<?php echo $plazartlock == preg_replace('/\s+/', ' ', $name) ? ' active' : '' ?>"
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
                endif;
            endforeach; ?>

            <?php if ($user->authorise('core.edit', 'com_menu') && $form->getValue('client_id') == 0): ?>
                <?php if ($canDo->get('core.edit.state')) : ?>
                    <div class="tab-pane clearfix<?php echo $plazartlock == 'assignment' ? ' active' : '' ?>"
                         id="assignment_params">
                        <?php include PLAZART_ADMIN_PATH . '/admin/tpls/default_assignment.php'; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</fieldset>