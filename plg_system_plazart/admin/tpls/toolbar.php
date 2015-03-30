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
?>

<div id="plazart-admin-toolbar" class="btn-toolbar">
	<?php
	if($input->getCmd('view') == 'style'):
	?>
  <div id="plazart-admin-tb-save" class="btn-group">
    <button id="plazart-admin-tb-style-save-save" class="btn btn-success"><i class="fa fa-floppy-o"></i>Save</button>
    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>&nbsp;
    </button>
    <ul class="dropdown-menu">
      <li id="plazart-admin-tb-style-save-close"><a href="#"><?php echo JText::_('PLAZART_TOOLBAR_SAVECLOSE') ?></a></li>
      <li id="plazart-admin-tb-style-save-clone"><a href="#"><?php echo JText::_('PLAZART_TOOLBAR_SAVE_AS_CLONE') ?></a></li>
    </ul>
  </div>
  <?php 
  endif;
  ?>

	<div id="plazart-admin-tb-global" class="btn-group">
		<button class="btn btn-config active"><i class="fa fa-cog"></i><?php echo JText::_('PLAZART_GLOBAL_LABEL') ?></button>
	</div>

    <div id="plazart-admin-tb-megamenu" class="btn-group">
        <button class="btn btn-config"><i class="fa fa-bars"></i><?php echo JText::_('PLAZART_NAVIGATION_LABEL') ?></button>
    </div>

    <div id="plazart-admin-tb-layout" class="btn-group">
        <button class="btn btn-config"><i class="fa fa-columns"></i><?php echo JText::_('PLAZART_LAYOUT_LABEL') ?></button>
    </div>

	<div id="plazart-admin-tb-close" class="btn-group <?php echo $input->getCmd('view') ?>">
		<button class="btn "><i class="fa fa-times"></i><?php echo JText::_('PLAZART_TOOLBAR_CLOSE') ?></button>
	</div>
	<div id="plazart-admin-tb-help" class="btn-group <?php echo $input->getCmd('view') ?>">
		<button class="btn"><i class="fa fa-wheelchair"></i><?php echo JText::_('PLAZART_TOOLBAR_HELP') ?></button>
	</div>

</div>