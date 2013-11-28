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

Plazart::import ('extendable/extendable');

/**
 * PlazartTemplate class provides extended template tools used for Plazart framework
 *
 * @package Plazart
 */
class PlazartTemplate extends ObjectExtendable
{
    /**
     * Define constants
     *
     */
    protected static $maxcol = array( 'default' => 6, 'wide' => 6, 'normal' => 6, 'xtablet' => 4, 'tablet' => 3, 'mobile' => 2 );
    protected static $minspan = array( 'default' => 2, 'wide' => 2, 'normal' => 2, 'xtablet' => 3, 'tablet' => 4, 'mobile' => 6 );
    protected static $maxgrid = 12;
    protected static $maxcolumns = 6;

    /**
     *
     * Known Valid CSS Extension Types
     * @var array
     */
    protected static $cssexts = array(".css", ".css1", ".css2", ".css3");

    /**
     * Current template instance
     */
    public $_tpl = null;

    /**
     * Class constructor
     *
     * @param   object  $template Current template instance
     */
    public function __construct($template = null)
    {
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');

        if ($template) {
            $this->_tpl = $template;
            $this->_extend(array($template));
        }
    }

    /**
     * get template parameter
     *
     * @param   $name  parameter name
     * @param   $default  parameter default value
     *
     * @return   parameter value
     */
    public function getParam ($name, $default = null) {
        if (is_bool($name) && $name == true){
            return self::getInstance()->Param($name);
        }
        if (!$this->_tpl) {
            return self::getInstance()->Param ($name, $default);
        } else {
            return $this->_tpl->params->get ($name, $default);
        }
    }

    public function setParam ($name, $value) {
        return $this->_tpl->params->set ($name, $value);
    }

    /**
     * Get current layout tpls
     *
     * @return string Layout name
     */
    public function getLayout () {
        return JFactory::getApplication()->input->getCmd ('tmpl') ? JFactory::getApplication()->input->getCmd ('tmpl') : $this->getParam('layout','default');
    }

    /**
     * Load block content
     *
     * @param $block string
     *     Block name - the real block is tpls/blocks/[blockname].php
     *
     * @return string Block content
     */
    function loadBlock($block, $vars = array())
    {
        $path = PlazartPath::getPath ('layouts/blocks/'.$block.'.php');
        if ($path) {
            include $path;
        } else {
            echo "<div class=\"error\">Block [$block] not found!</div>";
        }
    }

    /**
     * Load block content
     *
     * @param $block string
     *     Block name - the real block is tpls/blocks/[blockname].php
     *
     * @return string Block content
     */
    function loadLayout($layout)
    {
        $path = PlazartPath::getPath ('layouts/'.$layout.'.php', 'layouts/default.php');

        if (is_file ($path)) {
            include $path;
        } else {
            echo "<div class=\"error\">Layout [$layout] or [Default] not found!</div>";
        }
    }

    /**
     * Load spotlight block
     *
     * @param $name string
     *     Name of the spotlight. Default will load positions base on this name: [name]-1, [name]-2...
     * @param $default_cols integer
     *     Default columns in the spotlight, changable in admin
     *
     */
    function spotlight($name, $positions, array $info = array())
    {
        $defpos = preg_split('/\s*,\s*/', $positions);
        $vars = is_array($info) ? $info : array();
        $cols = count($defpos);
        $poss = $defpos;

        $splparams = array();
        for($i = 1; $i <= self::$maxcolumns; $i++){
            $param = $this->getLayoutSetting('block'.$i.'@'.$name);
            if(empty($param)){
                break;
            } else {
                $splparams[] = $param;
            }
        }

        //we have configuration in setting file
        if(!empty($splparams)){
            $poss = array();
            foreach ($splparams as $idx => $splparam) {
                $param = (object)$splparam;
                $poss[] = isset($param->position) ? $param->position : $defpos[$idx];
            }

            $cols = count($poss);
        }

        // check if there's any modules
        if (!$this->countModules (implode(' or ', $poss))){
            return;
        }

        //empty - so we will use default configuration
        if(empty($splparams)){
            //generate a optimize default width
            $default = $this->genWidth('default', $cols);
            foreach ($poss as $i => $pos) {
                //is there any configuration param
                $var = isset($vars[$pos]) ? $vars[$pos] : '';

                $param = new stdClass;
                $param->position = $pos;

                $param->default = ($var && isset($var['default'])) ? $var['default'] : 'span' . $default[$i];
                if($var){
                    if(isset($var['wide'])){
                        $param->wide = $var['wide'];
                    }
                    if(isset($var['normal'])){
                        $param->normal = $var['normal'];
                    }
                    if(isset($var['xtablet'])){
                        $param->xtablet = $var['xtablet'];
                    }
                    if(isset($var['tablet'])){
                        $param->tablet = $var['tablet'];
                    }
                    if(isset($var['mobile'])){
                        $param->mobile = $var['mobile'];
                    }
                }

                $splparams[$i] = $param;
            }
        }

        //build data
        $datas = array();
        foreach ($splparams as $idx => $splparam){
            $param = (object)$splparam;

            $data = '';
            $data .= isset($param->default) ? ' data-default="' . $param->default . '"' : '';
            $data .= isset($param->wide) ? ' data-wide="' . $param->wide . '"' : '';
            $data .= isset($param->normal) ? ' data-normal="' . $param->normal . '"' : '';
            $data .= isset($param->xtablet) ? ' data-xtablet="' . $param->xtablet . '"' : '';
            $data .= isset($param->tablet) ? ' data-tablet="' . $param->tablet . '"' : '';
            $data .= isset($param->mobile) ? ' data-mobile="' . $param->mobile . '"' : '';

            $datas[] = $data;
        }

        //
        $vars['name'] = $name;
        $vars['splparams'] = $splparams;
        $vars['datas'] = $datas;
        $vars['cols'] = $cols;

        $this->loadBlock ('spotlight', $vars);
    }

    function megamenu($menutype){
        Plazart::import('menu/megamenu');
        $currentconfig = json_decode($this->getParam('mm_config', ''), true);

        //force to array
        if(!is_array($currentconfig)){
            $currentconfig = (array)$currentconfig;
        }

        //get user access levels
        $viewLevels = JFactory::getUser()->getAuthorisedViewLevels();
        $mmkey      = $menutype;
        $mmconfig   = array();
        if(!empty($currentconfig)){

            //find best fit configuration based on view level
            $vlevels = array_merge($viewLevels);
            if(is_array($vlevels) && in_array(3, $vlevels)){ //we assume, if a user is special, they should be registered also
                $vlevels[] = 2;
            }
            $vlevels = array_unique($vlevels);
            rsort($vlevels);

            if(is_array($vlevels) && count($vlevels)){
                //should check for special view level first
                if(in_array(3, $vlevels)){
                    array_unshift($vlevels, 3);
                }

                $found = false;
                foreach ($vlevels as $vlevel) {
                    $mmkey = $menutype . '-' . $vlevel;
                    if(isset($currentconfig[$mmkey])){
                        $found = true;
                        break;
                    }
                }

                //fallback
                if(!$found){
                    $mmkey = $menutype;
                }
            }

            //we try to switch the language if we are in public
            if($mmkey == $menutype){
                // check if available configuration for language override
                $langcode = substr(JFactory::getDocument()->language, 0, 2);
                if (isset($currentconfig[$menutype.'-'.$langcode])) {
                    $mmkey = $menutype = $menutype . '-' . $langcode;
                }
            }

            if(isset($currentconfig[$mmkey])){
                $mmconfig = $currentconfig[$mmkey];
            }
        }

        $mmconfig['access'] = $viewLevels;
        $menu = new PlazartMenuMegamenu ($menutype, $mmconfig, $this->getParam(true));
        $menu->render();
    }

    /**
     * Render page class
     */
    function bodyClass () {
        $input = JFactory::getApplication()->input;
        if($input->getCmd('option', '')){
            $classes[] = $input->getCmd('option', '');
        }
        if($input->getCmd('view', '')){
            $classes[] = 'view-' . $input->getCmd('view', '');
        }
        if($input->getCmd('layout', '')){
            $classes[] = 'layout-' . $input->getCmd('layout', '');
        }
        if($input->getCmd('task', '')){
            $classes[] = 'task-' . $input->getCmd('task', '');
        }
        if($input->getCmd('Itemid', '')){
            $classes[] = 'itemid-' . $input->getCmd('Itemid', '');
        }

        $menu = JFactory::getApplication()->getMenu();
        if($menu){
            $active = $menu->getActive();
            $default = $menu->getDefault();

            if ($active) {
                if($default && $active->id == $default->id){
                    $classes[] = 'home';
                }

                if ($active->params && $active->params->get('pageclass_sfx')) {
                    $classes[] = $active->params->get('pageclass_sfx');
                }
            }
        }


        return implode(' ', $classes);
    }

    /**
     * Wrap of document countModules function, get position from configuration before calculate
     */
//    function countModules($positions)
//    {
//        $pos = $this->getPosname ($positions);
//        return $this->_tpl && method_exists($this->_tpl, 'countModules') ? $this->_tpl->countModules ($pos) : 0;
//    }

    /**
     * Wrap of document countModules function, get position from configuration before calculate
     */
    function checkSpotlight($name, $positions)
    {
        $poss = array();

        for($i = 1; $i <= self::$maxcolumns; $i++){
            $param = $this->getLayoutSetting('block'.$i.'@'.$name);
            if(empty($param)){
                break;
            } else {
                $param = (object)$param;
                $poss[] = isset($param->position) ? $param->position : '';
            }
        }

        if(empty($poss)){
            $poss = preg_split('/\s*,\s*/', $positions);
        }

        return $this->_tpl && method_exists($this->_tpl, 'countModules') ? $this->_tpl->countModules (implode(' or ', $poss)) : 0;
    }

    /**
     * Check system messages
     */
    function hasMessage()
    {
        // Get the message queue
        $messages = JFactory::getApplication()->getMessageQueue();
        return !empty($messages);
    }

    /**
     * Get position name
     *
     * @param $poskey string
     *     the key used in block
     */
    function getPosname ($condition) {
        $operators = '(,|\+|\-|\*|\/|==|\!=|\<\>|\<|\>|\<=|\>=|and|or|xor)';
        $words = preg_split('# ' . $operators . ' #', $condition, null, PREG_SPLIT_DELIM_CAPTURE);
        for ($i = 0, $n = count($words); $i < $n; $i += 2) {
            // odd parts (modules)
            $name = strtolower($words[$i]);
            $words[$i] = $this->getLayoutSetting ($name, $name);
        }

        $poss = '';
        foreach ($words as $word) {
            if(is_string($word)){
                $poss .= ' ' . $word;
            } else {
                $poss .= ' ' . (is_array($word) ? $word['position'] : (isset($word->position) ? $word->position : $name));
            }
        }
        $poss = trim($poss);
        return $poss;
    }

    /**
     * echo position name
     *
     * @param $poskey string
     *     the key used in block
     */
    function posname ($condition) {
        echo $this->getPosname ($condition);
    }

    /**
     * Alias of posname
     *
     */
    function _p ($condition) {
        $this->posname ($condition);
    }

    /**
     * Add current template css base on template setting.
     *
     * @param $name String
     *     file name, without .css
     *
     * @return string Block content
     */
    function addCss ($name, $addresponsive = true) {
        $responsive = $addresponsive ? $this->getParam('responsive', 1) : false;
        $theme  =   $this->getParam('theme', 'default');
        $url = PlazartPath::getUrl('css/themes/' .$theme. '/' . $name . '.css');
        if (!$url) {
            $url = PlazartPath::getUrl('css/' . $name . '.css');
        }

        // Add this css into template
        if ($url) {
            $this->addStyleSheet($url);
        }

        if ($responsive) {
            $this->addCss ($name.'-responsive', false);
        }
    }

    /**
     * Add Plazart basic head
     */
    function addHead () {
        // BOOTSTRAP CSS
        $this->addCss ('bootstrap', false);
        $this->addCss ('bootstrap-responsive');
        // TEMPLATE CSS
        $this->addCss ('template', false);

        if ($this->getParam('navigation_type') == 'megamenu') :
            // add core megamenu.css in plugin
            // deprecated - will extend the core style into template megamenu.less & megamenu-responsive.less
            // to use variable overridden in template
            $this->addStyleSheet(PLAZART_URL.'/css/megamenu.css');
            if ($this->getParam('responsive', 1)) $this->addStyleSheet(PLAZART_URL.'/css/megamenu-responsive.css');

            // megamenu.css override in template
            $this->addCss ('megamenu');
        endif;

        // Add scripts
        if(version_compare(JVERSION, '3.0', 'ge')){
            JHtml::_('jquery.framework');
        } else {
            $scripts = @$this->_scripts;
            $jqueryIncluded = 0;
            if(is_array($scripts) && count($scripts)) {
                $pattern = '/(^|\/)jquery([-_]*\d+(\.\d+)+)?(\.min)?\.js/i';
                foreach ($scripts as $script => $opts) {
                    if(preg_match($pattern, $script)) {
                        $jqueryIncluded = 1;
                    }
                }
            }

            if(!$jqueryIncluded) {
                $this->addScript (PLAZART_URL.'/js/jquery-1.8.3' . ($this->getParam('devmode', 0) ? '' : '.min') . '.js');
                $this->addScript (PLAZART_URL.'/js/jquery.noconflict.js');
            }
        }
        define('JQUERY_INCLUDED', 1);

        // As joomla 3.0 bootstrap is buggy, we will not use it
        $this->addScript (PLAZART_URL.'/bootstrap/js/bootstrap.js');

        // add css/js for off-canvas
        if ($this->getParam('navigation_collapse_offcanvas', 1)) {
            $this->addCss ('off-canvas', false);
            $this->addScript (PLAZART_URL.'/js/off-canvas.js');
        }

        $this->addScript (PLAZART_URL.'/js/script.js');

        //menu control script
        if ($this->getParam ('navigation_trigger', 'hover') == 'hover'){
            $this->addScript (PLAZART_URL.'/js/menu.js');
        }

        //check and add additional assets
        $this->addExtraAssets();
    }

    /**
     * Update head - detect if devmode or themermode is enabled and less file existed, use less file instead of css
     */
    function updateHead () {
        // As Joomla 3.0 bootstrap is buggy, we will not use it
        // We also prevent both Joomla bootstrap and Plazart bootsrap are loaded
        $plazartbootstrap = false;
        $jabootstrap = false;
        if(version_compare(JVERSION, '3.0', 'ge')){
            $doc = JFactory::getDocument();
            $scripts = array();
            foreach ($doc->_scripts as $url => $script) {
                if(strpos($url, PLAZART_URL.'/bootstrap/js/bootstrap.js') !== false){
                    $plazartbootstrap = true;
                    if($jabootstrap){ //we already have the Joomla bootstrap and we also replace to Plazart bootstrap
                        continue;
                    }
                }

                if(preg_match('@media/jui/js/bootstrap(.min)?.js@', $url)){
                    if($plazartbootstrap){ //we have Plazart bootstrap, no need to add Joomla bootstrap
                        continue;
                    } else {
                        $scripts[PLAZART_URL.'/bootstrap/js/bootstrap.js'] = $script;
                    }

                    $jabootstrap = true;
                } else {
                    $scripts[$url] = $script;
                }
            }

            $doc->_scripts = $scripts;
        }
        // end update javascript

        $minify = $this->getParam('minify', 0);
        //only check for minify if devmode is disabled

        if($minify){
            Plazart::import ('core/minify');
            PlazartMinify::optimizecss($this);
        }
    }

    /**
     * Add some other condition assets (css, javascript)
     */
    function addExtraAssets(){
        $base = JURI::base(true);
        $regurl = '#(http|https)://([a-zA-Z0-9.]|%[0-9A-Za-z]|/|:[0-9]?)*#iu';
        foreach(array(PLAZART_PATH, PLAZART_TEMPLATE_PATH) as $bpath){
            //full path
            $afile = $bpath . '/etc/assets.xml';
            if(is_file($afile)){

                //load xml
                $axml = JFactory::getXML($afile);
                //parse stylesheets first if exist
                if($axml){
                    foreach($axml as $node => $nodevalue){
                        //ignore others node
                        if($node == 'stylesheets' || $node == 'scripts'){
                            foreach ($nodevalue->file as $file) {
                                $compatible = $file['compatible'];
                                if($compatible) {
                                    $parts = explode(' ', $compatible);
                                    $operator = '='; //exact equal to
                                    $operand = $parts[1];
                                    if(count($parts) == 2){
                                        $operator = $parts[0];
                                        $operand = $parts[1];
                                    }

                                    //compare with Joomla version
                                    if(!version_compare(JVERSION, $operand, $operator)){
                                        continue;
                                    }
                                }

                                $url = (string)$file;
                                if(substr($url, 0, 2) == '//'){ //external link

                                } else if ($url[0] == '/'){ //absolute link from based folder
                                    $url = is_file(JPATH_ROOT . $url) ? $base . $url : false;
                                } else if (!preg_match($regurl, $url)) { //not match a full url -> sure internal link
                                    $url = PlazartPath::getUrl($url);		// so get it
                                }

                                if($url){
                                    if($node == 'stylesheets'){
                                        $this->addStylesheet($url);
                                    } else {
                                        $this->addScript($url);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Auto generate optimize width in a row fit to 12 grid
     * @var (int) numpos: number columns in row
     */
    function fitWidth($numpos){
        $result = array();
        $avg = floor(self::$maxgrid / $numpos);
        $sum = 0;

        for($i = 0; $i < $numpos - 1; $i++){
            $result[] = $avg;
            $sum += $avg;
        }

        $result[] = self::$maxgrid - $sum;

        return $result;
    }

    /**
     * Generate auto calculate width
     */
    function genWidth($layout, $numpos){

        $cmaxcol = self::$maxcol[$layout];
        $cminspan = ($layout == 'mobile') ? self::$maxgrid : self::$minspan[$layout];
        $total = $cminspan * $numpos;
        $sum = 0;

        if($total < self::$maxgrid) {
            return $this->fitWidth($numpos);
        } else {
            $result = array();
            $rows = ceil($total / self::$maxgrid);
            $cols = ceil($numpos / $rows);

            for($i = 0; $i < $rows - 1; $i++){
                $result = array_merge($result, $this->fitWidth($cols));
                $numpos -= $cols;
            }

            $result = array_merge($result, $this->fitWidth($numpos));
        }

        return $result;
    }

    //Layout generater loading...

    private static $_instance;
    private $document;

    /**
     * making self object for singleton method
     *
     */
    final public static function getInstance()
    {
        if( !self::$_instance ){
            self::$_instance = new self();
            self::getInstance()->getDocument();
            self::getInstance()->getDocument()->generate = self::getInstance();
        }
        return self::$_instance;
    }


    /**
     * Get Document
     *
     * @param string $key
     */
    public static function getDocument($key=false)
    {
        self::getInstance()->document = JFactory::getDocument();
        $doc = self::getInstance()->document;
        if( is_string($key) ) return $doc->$key;

        return $doc;
    }

    /**
     * Get Template name
     *
     * @return string
     */
    public static function themeName()
    {
        //return self::getInstance()->getDocument()->template;
        return JFactory::getApplication()->getTemplate();
    }

    /**
     * Get Template name
     * @return string
     */
    public static function theme()
    {
        return self::getInstance()->themeName();
    }

    /**
     * Get theme path
     *
     * @param bool $base
     * @return string
     */
    public static function themePath($base=false)
    {
        if( $base==true ) return JURI::root(true).'/templates/'.self::getInstance()->themeName();

        return  JPATH_THEMES . '/' . self::getInstance()->themeName();
    }

    /**
     * Get theme path
     * @return string
     */
    public static function themeURL()
    {
        return self::getInstance()->themePath();
    }

    /**
     * Get Base Path
     *
     */
    public static function basePath()
    {
        return JPATH_BASE;
    }

    /**
     * Get Base URL
     *
     */
    public static function baseURL()
    {
        return JURI::root(true);
    }

    /**
     * Get Framework HELIX path
     *
     */
    public static function frameworkPath($base=false)
    {
        if( $base==true ) return JURI::root(true).'/plugins/system/plazart';

        return JPATH_PLUGINS . '/system/plazart';
    }

    public static function pluginPath($base=false){
        return self::getInstance()->frameworkPath($base);
    }

    private  $inPositions = array();

    private $beforeModule = array();
    private $afterModule = array();

    /**
     * Make string to slug
     *
     * @param mixed $text
     * @return string
     */

    public static function slug($text)
    {
        return preg_replace('/[^a-z0-9_]/i','-', strtolower($text));
    }

    /**
     * Get or set Template param. If value not setted params get and return,
     * else set params
     *
     * @param string $name
     * @param mixed $value
     */
    public static function Param($name=true, $value=NULL)    {

        // if $name = true, this will return all param data
        if( is_bool($name) and $name==true ){
            return JFactory::getApplication()->getTemplate(true)->params;
        }
        // if $value = null, this will return specific param data
        if( is_null($value) ) return JFactory::getApplication()->getTemplate(true)->params->get($name);
        // if $value not = null, this will set a value in specific name.

        $data = JFactory::getApplication()->getTemplate(true)->params->get($name);

        if( is_null($data) or !isset($data) ){
            JFactory::getApplication()->getTemplate(true)->params->set($name, $value);
            return $value;
        } else {
            return $data;
        }
    }

    /**
     * Saved layout
     *
     * @var string
     * @access private
     */
    private $layout='';
    /**
     * Generating row
     *
     * @param string $layout
     * @access private
     */
    private static function showRow($layout)
    {
        if( isset($layout->children) )
        {
            foreach( $layout->children as $i=>$v )
            {

                if( !isset($v->type) or !isset($v->position) ) continue;
                // hide component area
                if( $v->type=='component' and  self::getInstance()->hideComponentArea()) continue;

                if( $v->type=='component' or $v->type=='message' or $v->type == 'megamenu' ) return true;

                if( $v->position!='' ){
                    if( self::getInstance()->countModules( $v->position )  ) return true;
                    if( isset($v->children) ) self::getInstance()->showRow($v);
                }
            }
        }
    }


    /**
     * Hide Component Area from frontpage
     * return bool
     */
    private function hideComponentArea()
    {
        $hide = (bool) $this->getParam('hide_component_area',0);
        if( self::getInstance()->isFrontPage() and true==$hide ) return true;
        else return false;
        //
    }


    private $inline_css = '';

    private static function get_layout_value($class, $method){
        if( isset($class->$method) and $class->$method=="" ) return false;
        return (isset( $class->$method )) ? $class->$method : FALSE;
    }

    private static function get_color_value($class, $method){
        $get = isset( $class->$method ) ? $class->$method : 'rgba(255, 255, 255, 0)';
        return ('rgba(255, 255, 255, 0)'==$get) ? FALSE : $get;
    }

    private static function get_row_class($classname){

        $replace = array( 'container'=>'', 'container-fluid'=>'' );

        if( self::getInstance()->has_container_class($classname, 'container') or self::getInstance()->has_container_class($classname, 'container-fluid') ){
            return strtr($classname, $replace);
        }
        return $classname;
    }


    private static function has_container_class($classname, $hasclass){

        $class =  explode(' ', $classname);

        if( in_array($hasclass, $class) ){
            return true;
        }
        return false;
    }

    private static function get_container_class($classname, $hasclass){

        $class =  explode(' ', $classname);

        if( in_array($hasclass, $class) ){
            return $hasclass;
        }
        return '';
    }

    /**
     * Layout generator
     *
     * @param mixed $layout
     */
    private function generatelayout($layout)
    {
        foreach($layout as $index=>$value)
        {
            if( is_null( self::getInstance()->showRow($value) ) ) continue;

            // set html5 stracture
            switch( self::getInstance()->slug($value->name) ){
                case "header":
                    $sematic = 'header';
                    break;

                case "footer":
                    $sematic = 'footer';
                    break;

                default:
                    $sematic = 'section';
                    break;
            }

            //  self::getInstance()->layout.="\n\n".'<!-- Start Row: '.$index.' -->'."\n";
            //  start row


            $id = ' #tz-'. self::getInstance()->slug($value->name) .'-wrapper{'."\n";
            $link = ' #tz-'. self::getInstance()->slug($value->name) .'-wrapper a{'."\n";
            $linkhover = ' #tz-'. self::getInstance()->slug($value->name) .'-wrapper a:hover{'."\n";
            $endcss = "\n".'}';


            self::getInstance()->inline_css .= $id;
            if( self::getInstance()->get_color_value( $value, 'backgroundcolor' ) ){
                self::getInstance()->inline_css .= 'background: '. self::getInstance()->get_color_value( $value, 'backgroundcolor' ) .' !important;';
            }

            if( self::getInstance()->get_color_value( $value, 'textcolor' ) ){
                self::getInstance()->inline_css .= 'color: '. self::getInstance()->get_color_value( $value, 'textcolor' ) .' !important;';
            }


            if( FALSE !== self::getInstance()->get_layout_value( $value, 'margin' ) ){
                self::getInstance()->inline_css .= 'margin: '. self::getInstance()->get_layout_value( $value, 'margin' ) .' !important;';
            }
            if( FALSE !== self::getInstance()->get_layout_value( $value, 'padding' ) ){
                self::getInstance()->inline_css .= 'padding: '. self::getInstance()->get_layout_value( $value, 'padding' ) .' !important;';
            }
            self::getInstance()->inline_css .= $endcss;

            self::getInstance()->inline_css .= $link;
            if( self::getInstance()->get_color_value( $value, 'linkcolor' ) ){
                self::getInstance()->inline_css .= 'color: '. self::getInstance()->get_color_value( $value, 'linkcolor' ) .' !important;';
            }
            self::getInstance()->inline_css .= $endcss;

            self::getInstance()->inline_css .= $linkhover;
            if( self::getInstance()->get_color_value( $value, 'linkhovercolor' ) ){
                self::getInstance()->inline_css .= 'color: '. self::getInstance()->get_color_value( $value, 'linkhovercolor' ) .' !important;';
            }
            self::getInstance()->inline_css .= $endcss;

            self::getInstance()->layout.='<'.$sematic.' id="tz-'. self::getInstance()->slug($value->name) .'-wrapper"
                class="'. self::getInstance()->get_row_class($value->class) . ' '.((empty($value->responsive)?'':''.$value->responsive.'')).'">';
            //

            if(self::getInstance()->has_container_class($value->class,'container')
                or
                self::getInstance()->has_container_class($value->class,'container-fluid'))
            {
                //  start container
                self::getInstance()->layout.='<div class="'
                    . self::getInstance()->get_container_class($value->class,'container-fluid')
                    . self::getInstance()->get_container_class($value->class,'container')
                    . '">';
            }

            //   start row fluid
            self::getInstance()->layout.='<div class="row-fluid" id="'. self::getInstance()->slug($value->name) .'">';

            if( isset($value->children) )
            {
                $absspan   = 0;    //   absence span
                $absoffset = 0;    // absence offset
                $i = 1;            //  span increment

                $totalItem = count($value->children);  // total children
                $totalPublished = count($value->children);  // total publish children

                foreach( $value->children as $val )
                {
                    if( !isset($val->children) )
                    {
                        if( $val->type=='modules' )
                        {
                            if( !self::getInstance()->countModules($val->position))
                            {
                                $absspan+=$val->span;
                                $absoffset+=$val->offset;
                                $totalPublished--;
                                $totalItem--;
                            }
                        }
                    }
                }

                foreach( $value->children as $v )
                {
                    if( $v->type=='modules' )
                    {
                        if( !self::getInstance()->countModules($v->position))
                        {
                            continue;
                        }
                    }

                    // if include type message or compoennt, this span will get all absance spans
                    if($v->type=='message' or $v->type == 'megamenu' or  ($v->type=='component' and !$this->hideComponentArea() ))
                    {
                        $totalItem = $i;
                    }

                    // set absance span in last module span
                    if( $i==$totalItem){
                        if( empty($v->offset) )
                        {
                            $v->span+=$absspan+$absoffset;
                            $v->offset='';
                        }
                    }

                    // if position name "left" or "right", this will set html5 aside tag. otherwise div
                    switch($v->position){

                        case "left":
                        case "right":
                            $sematicSpan = 'aside';
                            break;

                        default:
                            $sematicSpan = 'div';
                            break;
                    }

                    // self::getInstance()->layout.= ' <!-- Start Span --> ';
                    // start span
                    //  debugging  data-i="'.$i.'" data-total="'.$totalPublished.'" data-absspan="'.$absspan.'"  data-type="'.$v->type.'"

                    if( $v->type=='component' and $this->hideComponentArea() ) continue;

                    if( empty($v->position) ) $wrid = 'tz-'.$v->type.'-area';
                    else $wrid = 'tz-'.$v->position;

                    self::getInstance()->layout.="\n".'<'.$sematicSpan.' id="'.strtolower($wrid).'" class="span'.$v->span.''.(empty($v->offset)?'':' offset'.$v->offset).''.((!isset($v->responsiveclass) or  empty($v->responsiveclass))?'':' '.$v->responsiveclass).''.(empty($v->customclass)?'':' '.$v->customclass).'">';

                    $i++;

                    if( $v->type=='message' ){
                        self::getInstance()->layout.='<jdoc:include type="message" />';
                    }
                    elseif( $v->type=='component' )
                    {
                        self::getInstance()->layout.='<section id="tz-component-wrapper">';
                        self::getInstance()->layout.='<div id="tz-component">';
                        self::getInstance()->layout.='<jdoc:include type="component" />';
                        self::getInstance()->layout.='</div>';
                        self::getInstance()->layout.='</section>';
                    }
                    elseif( $v->type=='modules' ){
                        if( $v->position!='')
                        {
                            self::getInstance()->layout.= self::getInstance()->getFeature($v->position, true);
                            self::getInstance()->layout.='<jdoc:include type="modules" name="'.$v->position.'"  style="'.$v->style.'" />';
                            self::getInstance()->layout.= self::getInstance()->getFeature($v->position, false);
                        }
                    }
                    elseif( $v->type == 'megamenu' ) {
                        ob_start();
                        $this->loadBlock('mainnav');
                        self::getInstance()->layout.= ob_get_clean();
                    }

                    if( isset($v->children) )
                    {
                        self::getInstance()->generatelayout( $v->children );
                    }

                    // end span
                    self::getInstance()->layout.='</'.$sematicSpan.'>'."\n";

                    // self::getInstance()->layout.= ' <!-- End Span --> ';
                }
            }

            // end row fluid
            self::getInstance()->layout.='</div>';

            if(self::getInstance()->has_container_class($value->class,'container')
                or
                self::getInstance()->has_container_class($value->class,'container-fluid'))
            {
                //  end container
                self::getInstance()->layout.='</div>';
            }

            // end row
            self::getInstance()->layout.='</'.$sematic.'>';
            // self::getInstance()->layout.="\n\n".'<!-- End Row: '.$index.' -->'."\n";
        }

        $css = self::getInstance()->inline_css;
        self::getInstance()->addInlineCSS( $css );
    }

    /**
     * Get layout from saved item or template dir or plugin dir
     *
     */
    private function get_layout(){
        $layoutInplugin = PLAZART_ADMIN_PATH.'/base/generate/default.json';
        $layout = $this->getParam('generate');
        if( empty($layout) )
        {
            if( file_exists($layoutInplugin) ) {
                $layout =  json_decode(file_get_contents($layoutInplugin));
            } else {
                die('Cann\'t found '.self::getInstance()->themeName().'.json'.
                    ' file in layout directory. Please goto template manager and save.');
            }
        } else {
            return $layout;
        }
        return $layout;
    }

    /**
     * Detact External URL
     *
     * @param string $url
     * @return boolean
     */
    public function isExternalURL($url)
    {
        $parseurl = parse_url($url);
        $urlHost = isset($parseurl['host'])?$parseurl['host']:false;
        $currentHost = $_SERVER['HTTP_HOST'];
        $currentRemoteAddr = $_SERVER['REMOTE_ADDR'];

        if(false==$urlHost) return false;

        if( $currentHost===$urlHost or $currentRemoteAddr===$urlHost ) return false;
        else return true;
    }


    /**
     * Layout output
     *
     */
    public static function layout()
    {
        $layout =  self::getInstance()->get_layout();
        self::getInstance()->generatelayout($layout);
        echo self::getInstance()->layout;
        return self::getInstance();
    }


    private static function getFeature($position, $beforemodule=false)
    {
        if( self::getInstance()->hasFeature($position) ){

            if( $beforemodule==true ){
                if( !empty(self::getInstance()->beforeModule[$position]) )
                    return implode("\n", self::getInstance()->beforeModule[$position]);
            } else {
                if( !empty(self::getInstance()->afterModule[$position]) )
                    return implode("\n", self::getInstance()->afterModule[$position]);
            }
        }
    }

    public static function countModules($position)
    {
        return (self::getInstance()->getDocument()->countModules($position) or self::getInstance()->hasFeature($position) );
    }

    /**
     * Has only module
     *
     * @param string $position
     */
    public static function hasModule($position)
    {
        return self::getInstance()->getDocument()->countModules($position);
    }

    /**
     * Has feature
     *
     * @param string $position
     */

    public static function hasFeature($position)
    {
        return ( isset(self::getInstance()->inPositions[$position]) ) ? true : false;
    }

    /**
     * Add Inline CSS
     *
     * @param mixed $code
     * @return self
     */
    public function addInlineCSS($code) {
        self::getInstance()->document->addStyleDeclaration($code);
        return self::getInstance();
    }

    /**
     * Set Direction
     *
     */
    public static function direction() {

        $name = self::getInstance()->theme() . '_direction';
        self::getInstance()->resetCookie($name);

        $require = JRequest::getVar('direction',  ''  , 'get');
        if( !empty( $require ) ){
            setcookie( $name, $require, time() + 3600, '/');
            $current = $require;
        }
        elseif( empty( $require ) and  isset( $_COOKIE[$name] )) {
            $current = $_COOKIE[$name];
        } else {
            $current = self::getInstance()->getDocument()->direction;
        }

        self::getInstance()->getDocument()->direction = $current;

        return $current;
    }

    /**
     * Detect frontpage
     *
     * @since    1.0
     */
    public static function isFrontPage(){
        $app = JFactory::getApplication();
        $menu = $app->getMenu();
        $lang = JFactory::getLanguage();
        if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     *
     *
     */
//    public static function selectivizr(){
//        if(self::getInstance()->isIE(8))
//            self::getInstance()->addJS('selectivizr-min.js');
//        return self::getInstance();
//    }
//
//    public static function respondJS(){
//        if(self::getInstance()->isIE(8))
//            self::getInstance()->addJS('respond.min.js');
//        return self::getInstance();
//    }

}
?>