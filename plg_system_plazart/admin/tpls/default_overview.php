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

jimport('joomla.updater.update');

$telem = PLAZART_TEMPLATE;
$felem = PLAZART_ADMIN;

$thasnew = false;
$ctversion = $ntversion = $xml->version;
$fhasnew = false;
$cfversion = $nfversion = $fxml->version;

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
  ->select('*')
  ->from('#__updates')
  ->where('(element = ' . $db->q($telem) . ') OR (element = ' . $db->q($felem) . ')');
$db->setQuery($query);
$results = $db->loadObjectList('element');

if(count($results)){
  if(isset($results[$telem]) && (int)$results[$telem]->version > (int)$ctversion){
    $thasnew = true;
    $ntversion = $results[$telem]->version;
  }
  
  if(isset($results[$felem]) && (int)$results[$felem]->version > (int)$cfversion){
    $fhasnew = true;
    $nfversion = $results[$felem]->version;
  }
}
$hasperm = JFactory::getUser()->authorise('core.manage', 'com_installer');

// Try to humanize the name
$xml->name = ucwords(str_replace('_', ' ', $xml->name));
$fxml->name = ucwords(str_replace('_', ' ', $fxml->name));

?>
<div class="plazart-admin-overview">

  <legend class="plazart-admin-form-legend"><?php echo JText::_('PLAZART_OVERVIEW_TPL_INFO')?></legend>
  <div id="plazart-admin-template-home" class="section">
  	<div class="row-fluid">

  		<div class="span8">
  			<?php if (is_file (PLAZART_TEMPLATE_PATH.'/templateInfo.php')): ?>
  			<div class="template-info row-fluid">
  				<?php include PLAZART_TEMPLATE_PATH.'/templateInfo.php' ?>
  			</div>
  			<?php endif ?>
  		</div>

      <div class="span4">
        <div id="plazart-admin-tpl-info" class="plazart-admin-overview-block clearfix">
          <h3><?php echo JText::_('PLAZART_OVERVIEW_TPL_INFO')?></h3>
          <dl class="info">
            <dt><?php echo JText::_('PLAZART_OVERVIEW_NAME')?></dt>
            <dd><?php echo $xml->name ?></dd>
            <dt><?php echo JText::_('PLAZART_OVERVIEW_VERSION')?></dt>
            <dd><?php echo $xml->version ?></dd>
            <dt><?php echo JText::_('PLAZART_OVERVIEW_CREATE_DATE')?></dt>
            <dd><?php echo $xml->creationDate ?></dd>
            <dt><?php echo JText::_('PLAZART_OVERVIEW_AUTHOR')?></dt>
            <dd><a href="<?php echo $xml->authorUrl ?>" title="<?php echo $xml->author ?>"><?php echo $xml->author ?></a></dd>
          </dl>
        </div>
        <div id="tplUpdater" class="plazart-admin-overview-block updater<?php echo $thasnew ? ' outdated' : '' ?> clearfix">
          <h3><?php echo JText::sprintf('PLAZART_OVERVIEW_TPL_VERSION'); ?></h3>
          <p><?php echo  JText::sprintf('PLAZART_OVERVIEW_TPL_SAME_MSG', $xml->version) ?></p>
          <a class="btn disappear" href="http://www.templaza.com/" title="<?php echo JText::_( 'PLAZART_OVERVIEW_GO_DOWNLOAD') ?>"><?php echo JText::_( 'PLAZART_OVERVIEW_GO_DOWNLOAD') ?></a>


        </div>
      </div>

    </div>
  </div>

  <legend class="plazart-admin-form-legend"><?php echo JText::_('PLAZART_OVERVIEW_FRMWRK_INFO')?></legend>
  <div id="plazart-admin-framework-home" class="section">

    <div class="row-fluid">

      <div class="span8">
        <?php if (is_file (PLAZART_ADMIN_PATH.'/admin/frameworkInfo.php')): ?>
        <div class="template-info row-fluid">
          <?php include PLAZART_ADMIN_PATH.'/admin/frameworkInfo.php' ?>
        </div>
        <?php endif ?>
      </div>

      <div class="span4">
        <div id="plazart-admin-frmk-info" class="plazart-admin-overview-block clearfix">
          <h3><?php echo JText::_('PLAZART_OVERVIEW_FRMWRK_INFO')?></h3>
          <dl class="info">
            <dt><?php echo JText::_('PLAZART_OVERVIEW_NAME')?></dt>
            <dd><?php echo $fxml->name ?></dd>
            <dt><?php echo JText::_('PLAZART_OVERVIEW_VERSION')?></dt>
            <dd><?php echo $fxml->version ?></dd>
            <dt><?php echo JText::_('PLAZART_OVERVIEW_CREATE_DATE')?></dt>
            <dd><?php echo $fxml->creationDate ?></dd>
            <dt><?php echo JText::_('PLAZART_OVERVIEW_AUTHOR')?></dt>
            <dd><a href="<?php echo $fxml->authorUrl ?>" title="<?php echo $fxml->author ?>"><?php echo $fxml->author ?></a></dd>
          </dl>
        </div>
        <div class="plazart-admin-overview-block updater<?php echo $fhasnew ? ' outdated' : '' ?> clearfix">
          <h3><?php echo JText::sprintf($fhasnew ? 'PLAZART_OVERVIEW_FRMWRK_NEW' : 'PLAZART_OVERVIEW_FRMWRK_SAME', $fxml->name)?></h3>
          <p><?php echo $fhasnew ? JText::sprintf('PLAZART_OVERVIEW_FRMWRK_NEW_MSG', $cfversion, $fxml->name, $nfversion) : JText::sprintf('PLAZART_OVERVIEW_FRMWRK_SAME_MSG', $cfversion) ?></p>
          <?php if($hasperm): ?>
          <a class="btn" href="index.php?option=com_installer&view=update" class="plazartcheck-framework" title="<?php echo JText::_( $fhasnew ? 'PLAZART_OVERVIEW_GO_DOWNLOAD' : 'PLAZART_OVERVIEW_CHECK_UPDATE') ?>"><?php echo JText::_( $fhasnew ? 'PLAZART_OVERVIEW_GO_DOWNLOAD' : 'PLAZART_OVERVIEW_CHECK_UPDATE') ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
	</div>
</div>
