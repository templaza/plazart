<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 2/22/2016
 * Time: 3:52 PM
 */
defined('_JEXEC') or die;

Plazart::import('child/override');
$PlazartChildOverride   = new PlazartChildOverride();

$ovListAll      = $PlazartChildOverride->getTPLOverride('over');
$tpl_path_root  = $PlazartChildOverride->_path;

?>

<fieldset>

    <div class="plazart-admin clearfix">
        <div class="plazart-admin-tabcontent tab-content clearfix">
            <div id="root_folder_ovrride" class="tab-pane active">
                <div id="ovChildMess-success" class="ovChildMess"></div>
                <div id="ovChildMess-error" class="ovChildMess"></div>
                <?php
                $j = 0;
                foreach ($fieldSets as $name => $fieldSet) :
                    if(in_array($name,array('child_override'))): ?>

                        <div class="tab-pane<?php if($j == 0) {echo ' active';}?>"
                             id="<?php echo preg_replace('/\s+/', ' ', $name); ?>">
                            <?php

                            if (isset($fieldSet->description) && trim($fieldSet->description)) :
                                echo '<div class="plazart-admin-fieldset-desc">' . (JText::_($fieldSet->description)) . '</div>';
                            endif;

                            foreach ($form->getFieldset($name) as $field) :
                                $hide = ($field->type === 'PlazartDepend' && $form->getFieldAttribute($field->fieldname, 'function', '', $field->group) == '@group');
                                if ($field->type == 'Text') {
                                    // add placeholder to Text input
                                    $textinput = str_replace('/>', ' placeholder="' . $form->getFieldAttribute($field->fieldname, 'default', '', $field->group) . '"/>', $field->input);
                                }
                                ?>
                                <?php if ($field->hidden || ($field->type == 'PlazartDepend' && !$field->label)) : ?>
                                <?php echo $field->input; ?>
                            <?php else : ?>
                                <div class="control-group plazart-control-group<?php echo $hide ? ' hide' : '' ?>">
                                    <div class="control-label plazart-control-label">
                                        <?php echo $field->label; ?>
                                    </div>
                                    <div class="controls plazart-controls">
                                        <?php echo $field->type == 'Text' ? $textinput : $field->input ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                    <?php
                    endif; // end if check params

                endforeach; ?>
                <?php
                if (is_array($ovListAll) && !empty($ovListAll)) {
                ?>
                <ul class="nav nav-list directory-tree">
                    <?php
                    foreach($ovListAll as $key => $value) {
                        if(is_array($value)) {
                            // Check is folder
                            $folderPath = JPath::clean($tpl_path_root . $key);

                            if (JFolder::exists($folderPath)) {
                                $folderExisted = true;
                            }else {
                                $folderExisted = false;
                            }

                            if($folderExisted) {
                                echo '<li class="folder-1 plz-folder">';
                                $exfolder = explode('/', $key);
                                echo '<a class="plz-ov-child folder-url nowrap"><i class="icon-folder-open">&nbsp;</i><span>'.end($exfolder).'</span></a>';
                                echo '<ul class="folder-2">';
                            }

                            echo $PlazartChildOverride -> getFolder($value,'over');

                            if($folderExisted) {
                                echo '</ul>';
                                echo '</li>';
                            }
                        }else {
                            $arrayFile  = array("php","PHP","html","HTML","css","CSS","js","JS");
                            $fileExt    = JFile::getExt($value->id);
                            $nameFile   = JFile::getName($value->id);
                            if(in_array($fileExt,$arrayFile) && $nameFile != 'index.php' && $nameFile != 'templateInfo.php') {
                                echo $PlazartChildOverride -> getFile($value);
                            }
                        }
                    }
                    echo '</ul>';
                    }
//                ?>

                <?php //Editor File ?>

                <div class="ovEditFile">
                    <div class="content">
                        <div class="control-head">
                            <div class="fileNameEdit"><h2>Edit file: <span></span></h2></div>
                            <div class="sl-file-edit">
                                <p><?php echo JText::_('PLAZART_OV_SELECT_FILE_EDIT');?></p>
                            </div>
                            <div class="control-button">
                                <button class="btnFileSave"><i class="fa fa-floppy-o"></i> Save</button>
                                <button class="btnFileCancel"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                <input type="hidden" class="inputFileSave" id="inputFileSave" name="inputFileSave" />
                            </div>
                            <div class="mess"></div>
                        </div>
                        <textarea id="child_file_edit2" name="child_file_edit2"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</fieldset>









