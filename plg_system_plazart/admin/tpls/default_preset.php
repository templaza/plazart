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
?>
<div class="plazart-admin-preset">

<legend class="plazart-admin-form-legend"><?php echo JText::_('PLAZART_PRESET_TPL_INFO')?></legend>
<div id="plazart-admin-template-home" class="section">
    <div class="row-fluid">

        <div class="controls-row">
            <div class="control-group plazart-control-group preset-group">

                <div class="control-label plazart-control-label">
                    <label id="tz-profiles-list-lbl" for="config_manager_load_filename" class="hasTip" title="<?php echo JText::_('TZ_SELECT_PROFILE_DESC'); ?>"><?php echo JText::_('TZ_SELECT_PROFILE_LABEL'); ?></label>
                </div>
                <div class="controls plazart-controls">
                    <?php
                    for ($i=0; $i<count($profiles); $i++ ) {
                        echo '<div class="preset active"><label>'.$profiles[$i]->text.'</label></div>';
                    }
                    echo '<input type="hidden" name="config_manager_load_filename" value="" />';
                    ?>
                    <div style="clear: both"></div>
                    <?php // echo JHTML::_('select.genericlist', $profiles, 'config_manager_load_filename', 'autocomplete="off"', 'value', 'text','default'); ?>
                    <button id="config_manager_load" class="btn"><i class="icon-download"></i><?php echo JText::_('TPL_TZ_LANG_CONFIG_LOAD_BTN'); ?></button>
                    <button id="config_manager_delete" class="btn"><i class="icon-remove"></i><?php echo JText::_('TPL_TZ_LANG_CONFIG_DELETE_BTN'); ?></button>
                </div>

            </div>

        </div>

    </div>
</div>
</div>