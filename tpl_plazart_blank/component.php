<?php
/**
 * Plazart Framework
 * Author: Sonle
 * Version: 1.1
 * @copyright   Copyright (C) 2012 - 2013 TemPlaza.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;

// getting document object
$doc = JFactory::getDocument();

// Check for the print page
$print      = JRequest::getCmd('print');
// Check for the mail page
$mailto     = JRequest::getCmd('option') == 'com_mailto';
$config     = new JConfig();

$app        = JFactory::getApplication();
$template   = $app -> getTemplate(true);
$tplparams  = $template -> params;
$theme      =   $tplparams->get('theme', 'default');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>

    <jdoc:include type="head" />
<!--    --><?php //$this->loadBlock ('head') ?>

    <?php if($mailto == true) : ?>
	<?php $this->addStyleSheet(PLAZART_TEMPLATE_REL.'/css/mail.css'); ?>
	<?php endif; ?>
	
	<?php if($print == 1) : ?>     
	<link rel="stylesheet" href="<?php echo PLAZART_TEMPLATE_REL.'/css/print.css'; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo PLAZART_TEMPLATE_REL.'/css/print.css'; ?>" type="text/css" media="print" />
	<?php endif; ?>

    <?php $this->addStyleSheet(PLAZART_URL . '/bootstrap/css/bootstrap.css'); ?>

    <?php
    $doc -> addScript(PLAZART_TEMPLATE_REL.'/js/tz_aragon.js');
    $uri    = JUri::getInstance();
    $doc -> addScriptDeclaration('
        jQuery(document).ready(function(){
            var $tzbase = \''.JUri::base(true).'/'.PLAZART_TEMPLATE_REL.'\',
                $path   = \'/\',
                $domain = \''.$uri ->root().'\',
                $secure = \''.$uri -> getScheme().'\';

            if(readCookie(\'tz_aragon_theme_panel_tpl\')){
                if(!jQuery(\'#tz-link-theme-panel\').length){
                    jQuery(\'head\').append(\'<link rel="stylesheet" type="text/css" id="tz-link-theme-panel"\' +
                        \' rel="stylesheet" href="\'+$tzbase+\'/css/themes/\'+
                        readCookie(\'tz_aragon_theme_panel_tpl\')+\'/template.css"/> \');
                }
                else{
                    jQuery(\'#tz-link-theme-panel\').attr(\'href\',$tzbase+\'/css/themes/\'+
                        readCookie(\'tz_aragon_theme_panel_tpl\')+\'/template.css\');
                }
            }

            jQuery(\'.tz-theme-panel\').find(\'.color-link a\').click(function(){
                var $link   = jQuery(\'head link\'),
                    $bool    = false,
                    $name    = jQuery(this).attr(\'data-profile\'),
                    $match   = \'/.*?css\\/themes\\/\'+($name)+\'\\/template\\.css.*?/i\';
                createCookie(\'tz_aragon_theme_panel_tpl\',$name);
                if(!jQuery(\'#tz-link-theme-panel\').length){
                    jQuery(\'head\').append(\'<link rel="stylesheet" type="text/css" id="tz-link-theme-panel"\' +
                        \' rel="stylesheet" href="\'+$tzbase+\'/css/themes/\'+
                        $name+\'/template.css"/> \');
                }
                else{
                    jQuery(\'#tz-link-theme-panel\').attr(\'href\',$tzbase+\'/css/themes/\'+
                        $name+\'/template.css\');
                }
           });
        });
    ');
    ?>

    <?php $this -> addStyleSheet(PLAZART_TEMPLATE_REL.'/css/themes/'.$theme.'/template.css');?>
</head>
<body class="contentpane">
	<?php 
		if($print == 1) : 
			$params = JFactory::getApplication()->getTemplate(true)->params;
			$logo_text = $params->get('logo_text', '') != '' ? $params->get('logo_text', '') : $config->sitename;
			$logo_slogan = $params->get('logo_slogan', '');
	?>    
	<div id="tz-print-top">
		<img src="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/images/logo_print.png" alt="<?php echo $logo_text . ' - ' . $logo_slogan; ?>" />
	</div>
	<?php endif; ?>
	
	<jdoc:include type="message" />
	<jdoc:include type="component" />
	
	<?php 
	
		if($print == 1) : 
		
		function TZParserEmbed() {
			$body = JResponse::getBody();
			$body = preg_replace('/<plazart:fblogin(.*?)plazart:fblogin>/mis', '', $body);
			$body = preg_replace('/<plazart:social><fb:like(.*?)fb:like><\/plazart:social>/mi', '', $body);
			$body = preg_replace('/<plazart:social><g:plusone(.*?)g:plusone><\/plazart:social>/mi', '', $body);
			$body = preg_replace('/<plazart:social><a href="http:\/\/twitter.com\/share"(.*?)\/a><\/plazart:social>/mi', '', $body);
			$body = preg_replace('/<plazart:social><a href="http:\/\/pinterest.com\/pin\/create\/button\/(.*?)\/a><\/plazart:social>/mi', '', $body);
			$body = preg_replace('/<plazart:social>/mi', '', $body);
			$body = preg_replace('/<\/plazart:social>/mi', '', $body);
			$body = preg_replace('/<plazart:socialAPI>/mi', '', $body);
			$body = preg_replace('/<\/plazart:socialAPI>/mi', '', $body);
			
			JResponse::setBody($body);
		}
		
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->register('onAfterRender', 'TZParserEmbed');
		
	?>    
	<div id="tz-print-bottom">
		<?php if($params->get('copyrights', '') == '') : ?>
			&copy; Blank Plazart - <a href="http://www.templaza.com" title="Free Joomla! 3.0 Template">Free Joomla! 3.0 Template</a> <?php echo date('Y');?>
		<?php else : ?>
			<?php echo $params->get('copyrights', ''); ?>
		<?php endif; ?> 
	</div>
	<?php endif; ?>
</body>
</html>