<?php

/**
 * Plazart Framework
 * Author: Sonle
 * Version: 4.3
 * @copyright   Copyright (C) 2012 - 2015 TemPlaza.com. All rights reserved.
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

$plazart = Plazart::getApp($this);

// get configured layout
$layout = $plazart->getLayout();
$plazart->loadLayout ($layout);