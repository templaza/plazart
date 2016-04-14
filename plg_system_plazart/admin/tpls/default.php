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
$canDo = version_compare( JVERSION, '3.2.2', 'ge' ) ? JHelperContent::getActions('com_templates') : TemplatesHelper::getActions();
$iswritable = is_writable('plazarttest.txt');
$fieldSets = $form->getFieldsets('params');
?>
<?php if($iswritable): ?>
<div id="plazart-admin-writable-message" class="alert warning">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong><?php echo JText::_('PLAZART_MSG_WARNING'); ?></strong> <?php echo JText::_('PLAZART_MSG_FILE_NOT_WRITABLE'); ?>
</div>
<?php endif;?>
<div class="plazart-admin-form clearfix">
<form action="<?php echo JRoute::_('index.php?option=com_templates&layout=edit&id='.$input->getInt('id')); ?>" method="post" name="adminForm" id="style-form" class="form-validate form-horizontal">
    <div class="configure-content">
        <div class="config-view<?php echo $plazartlock=='global-config' || !in_array($plazartlock,array('global-config', 'menu-config', 'layout-config','advanced-config','preset-config','child-override-config')) ? ' active': ''; ?>" id="plazart-global-config">
            <?php
            $default_global_override = PLAZART_TEMPLATE_PATH . '/admin/default_global.php';
            if(file_exists($default_global_override)) {
                include_once $default_global_override;
            } else {
                include_once PLAZART_ADMIN_PATH . '/admin/tpls/default_global.php';
            }
            ?>
        </div>
        <div class="config-view<?php echo $plazartlock=='preset-config'? ' active': ''; ?>" id="plazart-preset-config">
            <?php
            $default_menu_override = PLAZART_TEMPLATE_PATH . '/admin/default_preset.php';
            if(file_exists($default_menu_override)) {
                include_once $default_menu_override;
            } else {
                include_once PLAZART_ADMIN_PATH . '/admin/tpls/default_preset.php';
            }
            ?>
        </div>
        <div class="config-view<?php echo $plazartlock=='menu-config'? ' active': ''; ?>" id="plazart-menu-config">
            <?php
            $default_menu_override = PLAZART_TEMPLATE_PATH . '/admin/default_megamenu.php';
            if(file_exists($default_menu_override)) {
                include_once $default_menu_override;
            } else {
                include_once PLAZART_ADMIN_PATH . '/admin/tpls/default_megamenu.php';
            }
            ?>
        </div>
        <div class="config-view<?php echo $plazartlock=='layout-config'? ' active': ''; ?>" id="plazart-layout-config">
            <?php
            $default_layout_override = PLAZART_TEMPLATE_PATH . '/admin/default_layout.php';
            if(file_exists($default_layout_override)) {
                include_once $default_layout_override;
            } else {
                include_once PLAZART_ADMIN_PATH . '/admin/tpls/default_layout.php';
            }
            ?>
        </div>

        <div class="config-view<?php echo $plazartlock=='advanced-config'? ' active': ''; ?>" id="plazart-advanced-config">
            <?php
            $default_layout_override = PLAZART_TEMPLATE_PATH . '/admin/default_advanced.php';
            if(file_exists($default_layout_override)) {
                include_once $default_layout_override;
            } else {
                include_once PLAZART_ADMIN_PATH . '/admin/tpls/default_advanced.php';
            }
            ?>
        </div>
        <div class="config-view<?php echo $plazartlock=='child-override-config '; ?>" id="plazart-child-override-config">

            <?php

            $default_layout_override = PLAZART_TEMPLATE_PATH . '/admin/default_override.php';

            if(file_exists($default_layout_override)) {
                include_once $default_layout_override;
            } else {
                include_once PLAZART_ADMIN_PATH . '/admin/tpls/default_override.php';
            }
            ?>
        </div>

    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>

</form>
</div>