<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 4/6/2016
 * Time: 8:43 AM
 */

defined('JPATH_PLATFORM') or die;

use Joomla\Registry\Registry;

JLoader::import('html',JPATH_SITE.'/libraries/joomla/document/html');

class JDocumentPlazartHTML extends JDocumentHTML {
    protected static $instances;
    protected $config;

    public function __construct($options = array()){
        $this -> config = new JRegistry();
        parent::__construct($options);
    }

    public function render($caching = false, $params = array()) {
        // Set up the params
        $document = JFactory::getDocument();

        $app =  JFactory::getApplication('site');

        $config = JFactory::getConfig();
        $template = $app->getTemplate(true);
        $paramsTem  = $template -> params;
        $fileOvClf  = $paramsTem->get('ov_clr_file','plz_child_');

        switch ($document->getType())
        {
            case 'feed':
                // No special processing for feeds
                break;

            case 'html':
            default:

                $file     = $app -> input->get('tmpl', 'index');

                if (!$config->get('offline') && ($file == 'offline'))
                {
                    $this->set('themeFile', 'index.php');
                }

                if ($config->get('offline') && !JFactory::getUser()->authorise('core.login.offline'))
                {
                    $this->setUserState('users.login.form.data', array('return' => JUri::getInstance()->toString()));
                    $this->set('themeFile', 'offline.php');
                    $this->setHeader('Status', '503 Service Temporarily Unavailable', 'true');
                }

                if (!is_dir(JPATH_THEMES . '/' . $template->template) && !$config->get('offline'))
                {
                    $this->set('themeFile', 'component.php');
                }

                // Ensure themeFile is set by now
                if ($this->get('themeFile') == '')
                {
                    $filePath   = JPATH_THEMES . '/' . $template->template . '/' .$fileOvClf.$file.'.php';
                    if( $file == 'component' && is_file($filePath)) {
                            $this->set('themeFile', $fileOvClf.$file . '.php');
                    }else {
                        $this->set('themeFile', $file . '.php');
                    }
                }

                break;
        }

        // Setup the document options.
        $docOptions['template'] = $template -> template;
        $docOptions['file']     = $this->get('themeFile', 'plz_index.php');
        $docOptions['params']   = $template -> params;

        if ($this->get('themes.base'))
        {
            $docOptions['directory'] = $this->get('themes.base');
        }
        // Fall back to constants.
        else
        {
            $docOptions['directory'] = defined('JPATH_THEMES') ? JPATH_THEMES : (defined('JPATH_BASE') ? JPATH_BASE : __DIR__) . '/themes';
        }

        // Parse the document.
        $document->parse($docOptions);

        $caching = false;

        if ($app->isSite() && $app->get('caching') && $app->get('caching', 2) == 2 && !JFactory::getUser()->get('id'))
        {
            $caching = true;
        }

        // Render the document.
        $data = $document->render($caching, $docOptions);

        return $data;

    }


    public function set($key, $value = null)
    {
        $previous = $this->config->get($key);
        $this->config->set($key, $value);

        return $previous;
    }


    public function get($key, $default = null)
    {
        return $this->config->get($key, $default);
    }

}