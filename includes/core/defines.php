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

// No direct access
defined('_JEXEC') or die;

define ('PLAZART_PLUGIN', 'plg_system_plazart');

define ('PLAZART_ADMIN', 'plazart');
define ('PLAZART_ADMIN_PATH', dirname(dirname(dirname(__FILE__))));
define ('PLAZART_ADMIN_URL', JURI::root(true).'/plugins/system/'.PLAZART_ADMIN);
define ('PLAZART_ADMIN_REL', 'plugins/system/'.PLAZART_ADMIN);
