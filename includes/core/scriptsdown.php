<?php

/**
 * @package plugin ScriptsDown
 * @copyright (C) 2010-2011 RicheyWeb - www.richeyweb.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ScriptsDown Copyright (c) 2010 Michael Richey.
 * ScriptsDown is licensed under the http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * ScriptsDown version 1.9 for Joomla 1.6.x/1.7.x devloped by RicheyWeb
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * ScriptsDown system plugin
 */
class PlazartScriptsDown {
    private $sanitizews;
    private $sanitizecss;
    private $params;
    /**
     * Constructor
     *
     * @access	protected
     * @param	object	$subject The object to observe
     * @param 	array   $config  An array that holds the plugin configuration
     * @since	1.0
     */
//    function plgSystemScriptsDown(&$subject, $config) {
//        parent::__construct($subject, $config);
//    }
    public function __construct() {
        $app = JFactory::getApplication();
        $this->sanitizews = array(
            'search'=>array('/\>[^\S ]+/s', //strip whitespaces after tags, except space
                '/[^\S ]+\</s', //strip whitespaces before tags, except space
                '/(\s)+/s'  // shorten multiple whitespace sequences                    
            ),
            'replace'=>array('>','<','\\1')
        );   
        $this->sanitizecss=array(
            'search'=>array('/\r\n/','/\r/','/\n/','/\t/','/; /','/: /','/\s{/','/{\s/','/\s}/','/}\s/','/;}/','/,\s/'),
            'replace'=>array('','','','',';',':','{','{','}','}','}',',')
        );
        $template       =   $app->getTemplate(true);
        $this->params   =   $template->params;
    }

    /* The scripts are all present after the document is rendered */

    function OptimizeCode() {
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        /* test that the page is not administrator && test that the document is HTML output */
        if ($app->isAdmin() || $doc->getType() != 'html')
            return;
        $pretty = (int)$this->params->get('pretty', 0);
        $stripcomments = (int)$this->params->get('stripcomments', 0);
        $sanitize = (int)$this->params->get('sanitize',0);
        $scriptdown = (int)$this->params->get('scriptdown',0);
        if (!$pretty && !$stripcomments && !$sanitize && !$scriptdown) return;

        $debug = (int)$app->getCfg('debug',0);
        if($debug) $pretty = true;
        $omit = array();
        /* now we know this is a frontend page and it is html - begin processing */
        /* first - prepare the omit array */

        if (strlen(trim($this->params->get('omit'))) > 0) {
            foreach (explode("\n", $this->params->get('omit')) as $omitme) {
                $omit[] = '/' . str_replace(array('/', '\''), array('\/', '\\\''), trim($omitme)) . '/i';
            }
            unset($omitme);
        }
        $moveme = array();
        $dom = new DOMDocument();
        $dom->recover = true;
        $dom->substituteEntities = true;
        if ($pretty) {
            $dom->formatOutput = true;
        } else {
            $dom->preserveWhiteSpace = false;
        }
        $source = JResponse::getBody();
        /* DOMDocument can get quite vocal when malformed HTML/XHTML is loaded.
         * First we grab the current level, and set the error reporting level
         * to zero, afterwards, we return it to the original value.  This trickery
         * is used to keep the logs clear of DOMDocument protests while loading the source.
         * I promise to set the level back as soon as I'm done loading source...
         */
        if(!$debug) $erlevel = error_reporting(0);
        $xhtml = (preg_match('/XHTML/', $source)) ? true : false;
        switch ($xhtml) {
            case true:
                $dom->loadXML($source);
                break;
            case false:
                $dom->loadHTML($source);
                break;
        }
        if(!$debug) error_reporting($erlevel); /* You see, error_reporting is back to normal - just like I promised */
        if ($pretty) {            
            $newline = $dom->createTextNode("\n");
        }
        
        if($sanitize && !$debug && !$pretty) {
            $this->_sanitizeCSS($dom->getElementsByTagName('style'));
        }                    
        
        if ($stripcomments && !$debug) {
            $comments = $this->_domComments($dom);
            foreach ($comments as $node)
                if (!preg_match('/\[endif]/i', $node->nodeValue)) // we don't remove IE conditionals
                    if ($node->parentNode->nodeName != 'script') // we also don't remove comments in javascript because some developers write JS inside of a comment
                        $node->parentNode->removeChild($node);
        }
        $body = @$dom->getElementsByTagName('body')->item(0);
        // Move script down
        if ($scriptdown) :
            foreach (@$dom->getElementsByTagName('head') as $head) {
                foreach (@$head->childNodes as $node) {
                    if ($node instanceof DOMComment) {
                        if (preg_match('/<script/i', $node->nodeValue))
                            $src = $node->nodeValue;
                    }
                    if ($node->nodeName == 'script' && $node->attributes->getNamedItem('type')->nodeValue == 'text/javascript') {
                        if (@$src = $node->attributes->getNamedItem('src')->nodeValue) {
                            // yay - $src was true, so we don't do anything here
                        } else {
                            $src = $node->nodeValue;
                        }
                    }
                    if (isset($src)) {
                        $move = ($this->params->get('exclude')) ? true : false;
                        foreach ($omit as $omitit) {
                            if (preg_match($omitit, $src) == 1) {
                                $move = ($this->params->get('exclude')) ? false : true;
                                break;
                            }
                        }
                        if ($move)
                            $moveme[] = $node;
                        unset($src);
                    }
                }
            }
            foreach ($moveme as $moveit) {
                $body->appendChild($moveit->cloneNode(true));
                if ($pretty) {
                    $body->appendChild($newline->cloneNode(false));
                }
                $moveit->parentNode->removeChild($moveit);
            }
        endif;
        $body = $xhtml ? $dom->saveXML() : $dom->saveHTML();
        JResponse::setBody($sanitize?preg_replace($this->sanitizews['search'],$this->sanitizews['replace'],$body):$body);
    }
    function _sanitizeCSS($styles) {
        foreach($styles as $node) 
            $node->nodeValue = preg_replace($this->sanitizecss['search'],$this->sanitizecss['replace'],$node->nodeValue);
    }
    function _domComments($node) {
        $comments = array();
        if ($node instanceof DOMComment) {
            $comments[] = $node;
        } else if (@$childnodes = $node->childNodes) {
            foreach ($childnodes as $childnode) {
                $comments = array_merge($comments, $this->_domComments($childnode));
            }
        }
        return $comments;
    }

}