<?php

// No direct access.
defined('_JEXEC') or die;

$logo_image = $this->getParam('logo_image', '');

if(($logo_image == '') || ($this->getParam('logo_type', '') == 'css')) {
     $logo_image = PLAZART_TEMPLATE_REL . '/images/logo.png';
} else {
     $logo_image = JURI::base() .'/' . $logo_image;
}

$config = new JConfig();

$logo_text = $this->getParam('logo_text', '') != '' ? $this->getParam('logo_text', '') : $config->sitename;
$logo_slogan = $this->getParam('logo_slogan', '');
?>

<?php if ($this->getParam('logo_type', 'image')!=='none'): ?>
     <?php if($this->getParam('logo_type', 'image') == 'css') : ?>
     <a href="./" id="tzlogo" class="pull-left css-logo">
     	<?php echo $logo_text . ' - ' . $logo_slogan; ?>
     </a>
     <?php elseif($this->getParam('logo_type', 'image')=='text') : ?>
     <a href="./" id="tzlogo" class="text-logo pull-left">
		<span><?php echo $logo_text; ?></span>
        <small class="tzlogo-slogan"><?php echo $logo_slogan; ?></small>
     </a>
     <?php elseif($this->getParam('logo_type', 'image')=='image') : ?>
     <a href="./" id="tzlogo">
        <img src="<?php echo $logo_image; ?>" alt="<?php echo $logo_text . ' - ' . $logo_slogan; ?>" />
     </a>
     <?php endif; ?>
<?php endif; ?>