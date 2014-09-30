<?php

/**
 * Plazart Framework
 * Author: Sonle
 * Version: 1.1
 * @copyright   Copyright (C) 2012 - 2013 TemPlaza.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

class TZTemplateAPI {

	private $API;

	function __construct($parentTpl) {
		$this->API = $parentTpl;
	}

    public function addCSS($url, $type = 'text/css', $media = null) { 
        $this->API->addStyleSheet($url, $type, $media);
    }
    
    public function addJS($url) {
        $this->API->addScript($url);
    }
    
    public function addCSSRule($code) {
        $this->API->addStyleDeclaration($code);
    }
    
    public function addJSFragment($code) { 
    	$this->API->addScriptDeclaration($code); 
    }

    public function get($key, $default) {
        return $this->API->params->get($key, $default);
    }

    public function set($key, $default) {
        return $this->API->params->set($key, $default);
    }
    
    public function modules($rule) {
        return $this->API->countModules($rule);
    }
    
    public function URLbase() {
        return JURI::base();
    }
    
    public function URLtemplate() {
        return JURI::base() . "templates/" . $this->API->template;
    }
    
    public function URLpath() {
        return JPATH_SITE;
    }
    
    public function URLtemplatepath() {
        return $this->URLpath() . DS . "templates" . DS . $this->API->template;
    }
    
    public function getPageName() {
        $config = new JConfig();
        return $config->sitename;
    }
    
    public function addFavicon($icon) {
    	return $this->API->addFavicon($icon);
    }
}

// EOF