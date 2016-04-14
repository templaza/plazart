<?php

// This is the code which will be placed in the head section

// No direct access.
defined('_JEXEC') or die;
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="HandheldFriendly" content="true" />
<meta name="apple-mobile-web-app-capable" content="YES" />
<?php
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
if (trim($css_custom)) {
    if (!$this->addExtraCSS($css_custom,'custom')) $this->addStyleDeclaration($css_custom);;
}

// load prefixer
if($this->getParam("css_prefixer", '0')) {
	$this->addScript(PLAZART_TEMPLATE_REL . '/js/prefixfree.js');
}

Plazart::addChildAddFile(PLAZART_TEMPLATE_REL.'/js/page.js','js');
?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->