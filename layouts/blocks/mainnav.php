<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<!-- MAIN NAVIGATION -->
<nav id="plazart-mainnav" class="wrap plazart-mainnav navbar-collapse-fixed-top navbar navbar-default">
    <div class="navbar-inner">
      <div class="navbar-header">
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
        <i class="fa fa-bars"></i>
      </button>
      </div>
  	  <div class="nav-collapse navbar-collapse collapse<?php echo $this->getParam('navigation_collapse_showsub', 1) ? ' always-show' : '' ?>">
      <?php if ($this->getParam('navigation_type') == 'megamenu') : ?>
        <?php $this->megamenu($this->getParam('mm_type', 'mainmenu')) ?>
      <?php else : ?>
        <jdoc:include type="modules" name="menu" style="raw" />
      <?php endif ?>
  		</div>
    </div>
</nav>
<!-- //MAIN NAVIGATION -->