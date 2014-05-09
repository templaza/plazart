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

if(!defined('PLAZART_TPL_COMPONENT')){
  define('PLAZART_TPL_COMPONENT', 1);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

  <head>
    <jdoc:include type="head" />
    <?php $this->loadBlock ('head') ?>  
  </head>

  <body>
    <section id="plazart-mainbody" class="container plazart-mainbody">
      <div class="row">
        <div id="plazart-content" class="plazart-content span12">
          <jdoc:include type="component" />    
        </div>
      </div>
    </section>
  </body>

</html>