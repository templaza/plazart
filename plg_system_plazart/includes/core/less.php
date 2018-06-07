<?php
/**
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2012-2013 TemPlaza.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       TemPlaza
 * @Link:         http://templaza.com
 *------------------------------------------------------------------------------
 */
/**
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org
 *------------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die();

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

Plazart::import('core/path');

/**
 * PlazartLess class compile less
 *
 * @package Plazart
 */
class PlazartLess
{
    public static function compileTemplate ($theme = null) {
        $lesspath = 'templates'.DIRECTORY_SEPARATOR.PLAZART_TEMPLATE.DIRECTORY_SEPARATOR.'less'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR;
        $csspath = 'templates'.DIRECTORY_SEPARATOR.PLAZART_TEMPLATE.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR;

        if(!JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.$lesspath.'megamenu.less')
            && !JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.$lesspath.'template.less')){
            return false;
        }

        $less = new JLess;
        $less->setFormatter(new JLessFormatterJoomla);
        if(JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.$lesspath.'megamenu.less')) {
            $less->compileFile(JPATH_ROOT . DIRECTORY_SEPARATOR . $lesspath . 'megamenu.less', JPATH_ROOT . DIRECTORY_SEPARATOR . $csspath . 'megamenu.css');
        }

        if(JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.$lesspath.'template.less')) {
            $less->compileFile(JPATH_ROOT . DIRECTORY_SEPARATOR . $lesspath . 'template.less', JPATH_ROOT . DIRECTORY_SEPARATOR . $csspath . 'template.css');
        }
    }
}