<?php

/**
 * Plazart Framework
 * Author: Sonle
 * Version: 1.0.0
 * @copyright   Copyright (C) 2012 - 2013 TemPlaza.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */
 
// No direct access.
defined('_JEXEC') or die;

//check if plazart plugin is existed
if(!defined('PLAZART')){
    die(JText::_('Plazart framework does not ready! Please enable Plazart plugin system!'));
//    throw new Exception('Plazart framework not ready! Please install plazart plugin system!');
}

// include framework classes and files

Plazart::getApp($this);

require_once('libraries/plazart.render.php');
// run the framework
$tpl = new PlazartRender($this);