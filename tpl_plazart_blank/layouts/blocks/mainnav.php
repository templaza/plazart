<?php
/**
 * @package   Plazart Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<!-- MAIN NAVIGATION -->
<nav id="plazart-mainnav" class="wrap plazart-mainnav navbar">
    <div class="navbar-inner">
      <div class="navbar-header">
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
        <i class="fa fa-bars"></i>
      </button>
      </div>
  	  <div class="nav-collapse navbar-collapse collapse">
      <?php if ($this->getParam('navigation_type','megamenu') == 'megamenu') : ?>
        <?php $this->megamenu($this->getParam('mm_type', 'mainmenu')) ?>
      <?php endif; ?>
      </div>
    </div>
</nav>
<!-- //MAIN NAVIGATION -->