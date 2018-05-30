<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldPlazarttypo extends JFormField
{
    public $type = 'Plazarttypo';

    protected function getInput() {
        $options_type = array(
            JHTML::_('select.option', '', 'Select an Option'),
            JHTML::_('select.option', 'standard', 'Standard'),
            JHTML::_('select.option', 'google', 'Google Fonts'),
            JHTML::_('select.option', 'squirrel', 'Squirrel')
        );

        $options_normal = array(
            JHTML::_('select.option', 'Verdana', 'Verdana'),
            JHTML::_('select.option', 'Georgia', 'Georgia'),
            JHTML::_('select.option', 'Arial', 'Arial'),
            JHTML::_('select.option', 'Impact', 'Impact'),
            JHTML::_('select.option', 'Tahoma', 'Tahoma'),
            JHTML::_('select.option', 'Trebuchet MS', 'Trebuchet MS'),
            JHTML::_('select.option', 'Arial Black', 'Arial Black'),
            JHTML::_('select.option', 'Times', 'Times'),
            JHTML::_('select.option', 'Palatino Linotype', 'Palatino Linotype'),
            JHTML::_('select.option', 'Lucida Sans Unicode', 'Lucida Sans Unicode'),
            JHTML::_('select.option', 'MS Serif', 'MS Serif'),
            JHTML::_('select.option', 'Comic Sans MS', 'Comic Sans MS'),
            JHTML::_('select.option', 'Courier New', 'Courier New'),
            JHTML::_('select.option', 'Lucida Console', 'Lucida Console')
        );

        $plugin_path   = \JPATH_PLUGINS . '/system/plazart/admin/js/webfonts.json';
        $json = \JFile::read( $plugin_path );

        $webfonts   = json_decode($json);
        $items      = $webfonts->items;
        $value      = json_decode($this->value);

        if (isset($value->fontFamily))
        {
            $font = self::filterArray($items, $value->fontFamily);
        }

        $customtag = (!empty($this->element['customtag'])) ? (string) $this->element['customtag'] : '';

        $fontWeights = array(
            '100'=>'Thin',
            '200'=>'Extra Light',
            '300'=>'Light',
            '400'=>'Normal',
            '500'=>'Medium',
            '600'=>'Semi Bold',
            '700'=>'Bold',
            '800'=>'Extra Bold',
            '900'=>'Black'
        );

        $fontStyles = array(
            'normal'=>'Normal',
            'italic'=>'Italic',
            'oblique'=>'Oblique'
        );

        $options_squirrel = array();
        // Get the path in which to search for file options.
        $path = (string) $this->element['directory'];

        if (!is_dir($path)) {
            $path = JPATH_ROOT.DIRECTORY_SEPARATOR.$path;
        }
        // Get a list of folders in the search path with the given filter.
        $folders = JFolder::folders($path, null);
        // Build the options list from the list of folders.
        if (is_array($folders)) {
            foreach($folders as $folder) {
                if (JFile::exists($path.$folder.'/stylesheet.css')) {
                    $filecontent    =   JFile::read($path.$folder.'/stylesheet.css');
                    preg_match_all('/font-family:\s*?\'(.*?)\';/i', $filecontent, $matches);
                    for ( $i = 0; $i< count($matches[0]); $i++ ) {
                        $match  =   $matches[1][$i];
                        $options_squirrel[] = JHtml::_('select.option', $folder.';'.$match, $match);
                    }
                }
            }
        }
        $fontType = $value->fontType;
        $fontFamily = $value->fontFamily;
        $displaynone    =   $fontType? '':' style="display: none;"';
        $html = '<div class="tztypography_form">';
        $html .= '<div class="plazart-type">';
        $html .= JHtml::_('select.genericlist', $options_type, 'name', '', 'value', 'text', $fontType, $this->name . '_type');
        $html .= '</div>';
        $html .= '<div class="plazart-container"'.$displaynone.'>';
        $html .= '<div class="plazart-raw">';
        $html .= '<div class="plazart-col-6">';
        $html .= '<label><small>'. \JText::_('PLAZART_TYPO_FONT_FAMILY') .'</small></label>';
        // Normal type
        $html .= JHtml::_('select.genericlist', $options_normal, 'name', '', 'value', 'text', $fontFamily, $this->name . '_normal');
        // Squirrel type
        if(count($options_squirrel)) {
            $html .= JHtml::_('select.genericlist', $options_squirrel, 'name', '', 'value', 'text', $fontFamily, $this->name . '_squirrel');
        } else {
            $html .= JHtml::_('select.genericlist', array(JHTML::_('select.option', 'Arial, Helvetica, sans-serif', '- - - ' . JText::_('PLAZART_NO_SQUIRREL') . ' - - -')), 'name', '', 'value', 'text', 'default', $this->name . '_squirrel');
        }

        //Google font
        $html .= '<select id="'.str_replace(array('[', ']'), '', $this->name).'_google_own_font">';
        foreach ($items as $item)
        {
            $html .= '<option '. ((isset($value->fontFamily) && $item->family == $value->fontFamily)?'selected="selected"':'') .' value="'. $item->family .'">'. $item->family .'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';

        //Font Weight
        $html .= '<div class="plazart-col-6">';
        $html .= '<label><small>'. \JText::_('PLAZART_FONT_WEIGHT') .'</small></label>';
        $html .= '<select id="'.str_replace(array('[', ']'), '', $this->name) . '_fontweight'.'" class="plazart-webfont-weight-list">';
        $html .= '<option value="">'. \JText::_('PLAZART_FONT_SELECT_OPTION') .'</option>';

        foreach($fontWeights as $key=>$fontWeight)
        {
            if(isset($value->fontWeight) && $value->fontWeight == $key)
            {
                $html .= '<option value="'. $key .'" selected>'. $fontWeight .'</option>';
            }
            else
            {
                $html .= '<option value="'. $key .'">'. $fontWeight .'</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="plazart-raw">';
        //Font Size
        $fontSize = (isset($value->fontSize))?$value->fontSize:'';
        $html .= '<div class="plazart-col-6">';
        $html .= '<label><small>'. \JText::_('PLAZART_FONT_SIZE') .'</small></label>';
        $html .= '<input id="'.str_replace(array('[', ']'), '', $this->name) . '_fontsize'.'" type="text" value="'. $fontSize .'" class="plazart-webfont-size-input" min="6">';
        $html .= '</div>';
        //Font Height
        $lineHeight = (isset($value->lineHeight))?$value->lineHeight:'';
        $html .= '<div class="plazart-col-6">';
        $html .= '<label><small>'. \JText::_('PLAZART_FONT_HEIGHT') .'</small></label>';
        $html .= '<input id="'.str_replace(array('[', ']'), '', $this->name) . '_lineheight'.'" type="text" value="'. $lineHeight .'" class="plazart-webfont-lineheight-input" min="6">';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="plazart-raw">';
        //Font Style
        $html .= '<div class="plazart-col-6">';
        $html .= '<label><small>'. \JText::_('PLAZART_FONT_STYLE') .'</small></label>';
        $html .= '<select id="'.str_replace(array('[', ']'), '', $this->name) . '_fontstyle'.'" class="plazart-webfont-style-list">';
        $html .= '<option value="">'. \JText::_('PLAZART_FONT_SELECT_OPTION') .'</option>';

        foreach($fontStyles as $key=>$fontStyle)
        {
            if(isset($value->fontStyle) && $value->fontStyle == $key)
            {
                $html .= '<option value="'. $key .'" selected>'. $fontStyle .'</option>';
            }
            else
            {
                $html .= '<option value="'. $key .'">'. $fontStyle .'</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';

        //Font Subsets
        $html .= '<div class="plazart-col-6">';
        $html .= '<label><small>'. \JText::_('PLAZART_FONT_SUBSET') .'</small></label>';
        $html .= '<select id="'.str_replace(array('[', ']'), '', $this->name) . '_subset'.'" class="plazart-webfont-subset-list">';
        $html .= '<option value="">'. \JText::_('PLAZART_FONT_SELECT_OPTION') .'</option>';

        if(isset($value->fontFamily) && $value->fontFamily)
        {
            if($value->fontType=='google')
            {
                $html .= $this->generateSelectOptions($font->subsets, $value->fontSubset);
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';

        if ($customtag) {
            $html .= '<label><small>'. \JText::_('PLAZART_FONT_CUSTOMTAG') .'</small></label>';
            $customtag = isset($value->customTag) && $value->customTag ? $value->customTag : $customtag;
            $html .= '<textarea id="'.str_replace(array('[', ']'), '', $this->name) . '_customtag'.'">'.$customtag.'</textarea>';
        }
        $html .= '</div>';

        // Data store
        $html .= '<input type="hidden" name="'.$this->name.'" id="'.$this->id.'" class="typoData" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" />';
        $html .= '</div>';


        return $html;
    }

    private function generateSelectOptions( $items = array(), $selected = '' )
    {
        $html = '';
        foreach ($items as $item)
        {
            $html .= '<option ' . (($selected !== 'no-selection' && $item == $selected) ? 'selected="selected"' : '') . ' value="'. $item .'">'. $item .'</option>';
        }
        return $html;
    }

    // Get current font
    private static function filterArray($items, $key)
    {
        foreach ($items as $item)
        {
            if ($item->family == $key) return $item;
        }
        return false;
    }
}