<?php
/**
 *
 * Plazart framework layout
 *
 * @version             1.0.0
 * @package             Plazart Framework
 * @copyright			Copyright (C) 2012 - 2013 TemPlaza. All rights reserved.
 *
 */
 
// no direct access
defined('_JEXEC') or die;
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<?php $this->loadBlock('head'); ?>
</head>

<body class="<?php echo $this->bodyClass() ?>">
    <?php
    if ($this->getParam('layout_enable',1)) {
        $this->layout();
    } else {
        $this->loadBlock('body');
    }
    if ($this->getParam('framework_logo',1)) $this->loadBlock('framework');
?>
</body>
</html>