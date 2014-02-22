<?php

/**
 * Plazart Framework
 * Author: Sonle
 * Version: 1.1
 * @copyright   Copyright (C) 2012 - 2013 TemPlaza.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

// No direct access.
defined('_JEXEC') or die;

class TZRules {
    static public $rules = array();
    static public $body;

    public static function setRule($pattern, $replace) {
        self::$rules[$pattern] = $replace;
    }

    public static function parseIt()
    {
        if(!version_compare(JVERSION,'3.2','>=')){
            jimport('joomla.environment.response');
        }
        self::$body = JResponse::getBody();
        // if the custom rules are defined
        if(count(self::$rules)) {
            // use it for parsing the website
            foreach (self::$rules as $pattern => $replace) {
                self::$body = preg_replace($pattern, $replace, self::$body);
            }
        }
        return self::$body;
    }
}