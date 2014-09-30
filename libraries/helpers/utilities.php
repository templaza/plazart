<?php 

/**
 * Plazart Framework
 * Author: Sonle
 * Version: 1.1
 * @copyright   Copyright (C) 2012 - 2013 TemPlaza.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

class TZTemplateUtilities {
    //
    private $parent;
    //
    function __construct($parent) {
    	$this->parent = $parent;
    }
    //
    public function overrideArrayParse($data) {
        $results = array();
        // exploding settings
        $exploded_data = explode("\r\n", $data);
        // parsing
        for ($i = 0; $i < count($exploded_data); $i++) {
            if(isset($exploded_data[$i])) {
	            // preparing pair key-value
	            $pair = explode('=', trim($exploded_data[$i]));
	            // extracting key and value from pair
	            if(count($pair) == 2){
	            	$key = $pair[0];
	            	$value = $pair[1];
	            	// checking existing of key in config array
	            	if (!isset($results[$key])) {
	            	    // setting value for key
	            	    $results[$key] = $value;
	            	}
	            }
            }
        }

        // return results array
        return $results;
    }

    public function lazyloading() {
        if(!$this->parent->API->get("js_lazyload", '0')) {
            return;
        }
        $data   =   JResponse::getBody();

        preg_match_all('/<img.*?>/ism',$data,$matches);
        if (!count($matches[0])) return;
        foreach ($matches[0] as $image) {
            if (preg_match('/data-original=["\'](.*?)["\']/i', $image)) continue;
            if (preg_match('/src=["\'](.*?)["\']/i', $image, $match)) {
                $src    =   $match[1];
                $image_rep  =   preg_replace('/src=["\'].*?["\']/i','src="'.PLAZART_TEMPLATE_REL.'/images/grey.gif" data-original="'.$src.'"',$image);
                $data   =   str_replace($image,$image_rep,$data);
            } else {
                continue;
            }

        }

        JResponse::setBody($data);
        return;
    }
}

// EOF