<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 2/22/2016
 * Time: 5:01 PM
 */
class PlazartChildOverride {

    public $_name_tpl   = '';
    public $_id_tpl     = '';
    public $_params     = '';
    public $_sub_file   = 'plz_child_';
    public $_path       = '';

    public static function display () {

    }

    public function getPathTPL($id) {

        // Get path template for id mysql
        if(isset($id)) {

            $db         = JFactory::getDBO();
            $query      = $db->getQuery(true);
            $query
                ->select('*')
                ->from('#__template_styles')
                ->where('id = ' . $id);

            $db->setQuery($query);

            $tpl        = $db->loadObject();

            $this->_params  = new JRegistry;
            $this->_params->loadString($tpl->params);
            $this->_sub_file = $this->_params->get('ov_clr_file','');
            return $tpl;

        }
    }

    public function getDirectoryTreeOverride($dir) {

        $dir      = JPath::clean($dir);
        $result = array();
        $scan_folder = scandir($dir);

        foreach ($scan_folder AS $key => $value) {

            if (!in_array($value, array(".", ".."))) {
                if (is_dir($dir . $value)) {

                    // check folder

                    // if is folder call back getDirectoryTreeOverride
                    $result['/' . $value] = $this -> getDirectoryTreeOverride($dir.$value.'/');

                }else {

                    // Check file type
//                    $ext = pathinfo($dir . $value, PATHINFO_EXTENSION);
                    $info                   = new stdClass;
                    $info->name             = $value;
                    $info->id               = $dir.$value;
                    $info->short_path       = str_replace($this->_path, '', $dir . $value);
                    $result[$info->name]    = $info;
                }
            }
        }

        return $result;

    }

    public function getTPLOverride ($over) {

        $result         = array();
        $app            = JFactory::getApplication();
        $tInput         = $app->input;
        $idtpl          = $tInput->getInt('id');
        $this->_id_tpl  = $idtpl;
        $tpl_path       = $this -> getPathTPL($idtpl);
        $tpl_path_name  = $tpl_path->template;

        if($over == 'edit') {
//            $tpl_path_name = $tpl_path_name.'_child';
        }

        $this->_name_tpl = $tpl_path_name;

        $tpl_path_root  = JPath::clean(JPATH_SITE . '/templates/'.$tpl_path_name.'/');
        $this->_path    = $tpl_path_root;
        $list_folder    = $this -> getDirectoryTreeOverride($tpl_path_root);

        if(empty($result)) {
            $result     = $list_folder;
        }

        return $result;

    }

    public function getFolder($value,$over) {

        foreach($value as $k => $v) {

            if(is_array($v)) {
                echo '<li class="folder">';
                $exfolder   = explode('/', $k);
                echo '<a class="plz-ov-child folder-url nowrap"><i class="icon-folder-open">&nbsp;</i><span>'.end($exfolder).'</span></a>';
                echo '<ul class="li-n-fd">';
                $this -> getFolder($v,$over);
                echo '</ul>'; // end li of folder
                echo '</li>';
            }
            if(is_object($v) && $over != 'edit') {
                $arrayFile  = array("php","PHP","html","HTML","css","CSS","js","JS");
                $fileExt    = JFile::getExt($v->id);
                if(in_array($fileExt,$arrayFile)) {
                    echo $this -> getFile($v);
                }
            }
            if(is_object($v) && $over == 'edit') {
                echo $this -> getFileEdit($v);
            }
        }
//        return $html;
    }

    public function getFile($value) {

        $html       = '';
        $checkFile  = false;
        if($this->_sub_file == '') {
            $this->_sub_file = 'plz_child_';
        }

        $checkFile  = strpos($value->name,$this->_sub_file);

        if($checkFile === false) {
            // Check file in new folder
            $ck_new_file    = str_replace($value->name,$this->_sub_file.$value->name,$value->id);
            $ck_new_file    = JPath::clean($ck_new_file);

            // $bsValue => json encode => value input
            $bsValue = json_encode($value);
            $bsValue    = str_replace('\\\\','\\\\\\\\',$bsValue);
            $htmlBtnEdit    = '';
            if(is_file($ck_new_file)) {
                $ds_delete_file = '';
                $clFileDelete   = ' btn-delete';

                $htmlBtnEdit    = '<button class="btn ov-file btn-file-edit hasTooltip" title="'.JHtml::tooltipText("TPL_OVERRIDDEN_FILE").'">' .
                                    '<i class="fa fa-pencil">&nbsp;</i>' .JText::_('TPL_EDIT_FILE_TO_OVERRIDE').
                                    '</button>';
                $bsValue        = str_replace($value->name,$this->_sub_file.$value->name,$bsValue);

            }else {
                $ds_delete_file = ' disabled="disabled"';
                $clFileDelete   = '';

                $htmlBtnEdit    = '<button class="btn ov-file btn-file-create hasTooltip" title="'.JHtml::tooltipText("TPL_COPY_FILE_TO_OVERRIDE").'">' .
                                    '<i class="icon-copy">&nbsp;</i>' .JText::_('TPL_OVERRIDDEN_FILE').
                                    '</button>';
            }

            $html .= '<li class="file-name">';
            $html .= '<div class="file-name">';
            $html  .= '<i class="icon-file"></i>'.$value->name;
            $html .= '</div>';
            $html .= '<div class="control">' .
                '<input type="checkbox" name="override_delete[]" class="input-file-delete disabled" style="display: none;" value="'.htmlspecialchars($bsValue).'" />' .
                '<div class="btn-group">'.$htmlBtnEdit.
                '<button class="btn btn-file-delete hasTooltip '.$clFileDelete.'" '.$ds_delete_file.' title="'.JHtml::tooltipText("TPL_DELETE_FILE_TO_OVERRIDE").'">' .
                '<i class="icon-copy">&nbsp;</i>' .JText::_('TPL_DELETE_OVERRIDDEN_FILE').
                '</button>'.
                '</div>'.
                '<input type="checkbox" name="override_create[]" class="input-file-create disabled" style="display: none;" value="'.htmlspecialchars($bsValue).'" />'.
                '</div>';
            $html .= '</li>';
        }

        return $html;
    }

    public function getFileEdit($value) {

        $html       = '';

        $checkFile  = strpos($value->name,$this->_sub_file);
        if($checkFile !== false) {
            $base_file  = base64_encode($value->short_path);
            $link = JRoute::_('index.php?option=com_templates&view=style&layout=edit&id='.$this->_id_tpl.'&file='.$base_file.'#override-config');
            $html = '<li class="file-name">';
            $html .= '<div class="file-name">' .
                '<a href="'.$link.'">' .
                '<i class="icon-file"></i>' . $value->name .
                '</a>' .
                '</div>';
            $html .= '</li>';
        }

        return $html;

    }

}
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        var url_base    = "<?php echo JUri::root();?>";
        var result      = '';
        ovChildAjax(url_base,result);
    });
</script>

