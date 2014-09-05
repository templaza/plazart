<?php

// This is the code which will be placed in the head section

// No direct access.
defined('_JEXEC') or die;
?>
<?php if($this->browser->get('browser') == 'ie8' || $this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6') : ?>
<meta http-equiv="X-UA-Compatible" content="IE=9">
<?php endif; ?>
<?php if($this->getParam("chrome_frame_support", '0') == '1' && ($this->browser->get('browser') == 'ie8' || $this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6')) : ?>
<meta http-equiv="X-UA-Compatible" content="chrome=1"/>
<?php endif; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="HandheldFriendly" content="true" />
<meta name="apple-mobile-web-app-capable" content="YES" />
<?php
//
$doc = JFactory::getDocument();
// PLAZART BASE HEAD
$this->addHead();
// generate the max-width rules
$max_page_width =   $this->getParam('max_page_width', 0);

$theme  =   $this->getParam('theme', 'default');
$css_custom =   '';
if ($max_page_width) {

    $css_custom .=  ('.container-fluid { max-width: '.$this->getParam('max_page_width', '1200').$this->getParam('max_page_width_value', 'px').'!important; } .container { max-width: '.$this->getParam('max_page_width', '1200').$this->getParam('max_page_width_value', 'px').'!important; }');
}

// CSS override on two methods
if($this->getParam("css_override", '0')) {
	$this->addCSS('override', false);
}

$css_custom .=  ($this->getParam('css_custom', ''));
if (trim($css_custom)) $this->addExtraCSS($css_custom,'custom');

// load prefixer
if($this->getParam("css_prefixer", '0')) {
	$this->addScript(PLAZART_TEMPLATE_REL . '/libraries/js/prefixfree.js');
}

// load lazyload
if($this->getParam("js_lazyload", '0')) {
    $this->addScript(PLAZART_TEMPLATE_REL . '/libraries/js/jquery.lazyload.min.js');
}

$this->addScript(PLAZART_TEMPLATE_REL.'/js/page.js');
?>

<!--[if IE 9]>
<link rel="stylesheet" href="<?php echo PLAZART_TEMPLATE_REL.'/css/'.$theme; ?>/ie9.css" type="text/css" />
<![endif]-->

<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo PLAZART_TEMPLATE_REL.'/css/'.$theme; ?>/ie8.css" type="text/css" />
<![endif]-->

<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo PLAZART_TEMPLATE_REL.'/css/'.$theme; ?>/css/ie7.css" type="text/css" />
<script src="<?php echo PLAZART_TEMPLATE_REL.'/js/icon-font-ie7.js'; ?>"></script>
<![endif]-->

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- For IE6-8 support of media query -->
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo PLAZART_URL ?>/js/respond.min.js"></script>
<![endif]-->