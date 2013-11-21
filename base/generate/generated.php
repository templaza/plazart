<?php
/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2013 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
if( !function_exists('get_value') ){

    function get_value($item, $method){
        return isset($item->$method) ? $item->$method : '';
    }
}

if( !function_exists('get_color') ){

    function get_color($item, $method){
        return isset($item->$method) ? $item->$method : 'rgba(255, 255, 255, 0)';
    }
}

?>

<div class="container-fluid" id="plazart_layout_builder">

    <!-- Column setting popbox -->
    <div id="columnsettingbox" style="display: none;">
        <ul class="nav nav-tab" id="columnsettings">
            <li class="active"><a  href="#basic" data-toggle="tab">Basic</a></li>
            <li><a href="#responsive" data-toggle="tab">Responsive</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="basic">
                <div id="includetypes">
                    <label>Type: </label>
                    <select class="includetypes">
                        <option value="modules">Modules</option>
                        <option value="message">Message</option> 
                        <option value="component">Component</option>
                        <option value="megamenu">Megamenu</option>
                    </select>
                </div>

                <div id="positions">
                    <label> Position: </label>
                    <select class="positions">
                        <option value=""> (none) </option>
                        <?php
                            foreach((array) $positions as $value) echo '<option value="'.$value.'">'.$value.'</option>';
                        ?>
                    </select>
                </div>

                <div id="spanwidth">
                    <label>Width: </label>
                    <select class="possiblewidths">
                        <option value="1">span1</option> 
                        <option value="2">span2</option> 
                        <option value="3">span3</option> 
                        <option value="4">span4</option> 
                        <option value="5">span5</option> 
                        <option value="6">span6</option> 
                        <option value="7">span7</option> 
                        <option value="8">span8</option> 
                        <option value="9">span9</option> 
                        <option value="10">span10</option>
                        <option value="11">span11</option>
                        <option value="12">span12</option>
                    </select>
                </div>

                <div id="spanoffset">
                    <label>Offset: </label>
                    <select class="possibleoffsets">
                        <option value="0">(none)</option>
                        <option value="1">offset1</option> 
                        <option value="2">offset2</option> 
                        <option value="3">offset3</option> 
                        <option value="4">offset4</option> 
                        <option value="5">offset5</option> 
                        <option value="6">offset6</option> 
                        <option value="7">offset7</option> 
                        <option value="8">offset8</option> 
                        <option value="9">offset9</option> 
                        <option value="10">offset10</option>
                    </select>
                </div>

                <div id="modchrome">
                    <label>Style: </label>
                    <select class="modchrome">
                        <?php foreach($modChromes as $style): ?>
                            <option value="<?php echo $style ?>"><?php echo $style ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>

                <div id="customclass">
                    <label>Custom Class: </label>
                    <input type="text" class="customclass" id="inputcustomclass">
                </div>
            </div>

            <div class="tab-pane" id="responsive">
                <label class="checkbox"> <input type="checkbox" value="visible-phone">Visible Phone</label>
                <label class="checkbox"> <input type="checkbox" value="visible-tablet">Visible Tablet</label>
                <label class="checkbox"> <input type="checkbox" value="visible-desktop">Visible Desktop</label>
                <label class="checkbox"> <input type="checkbox" value="hidden-phone">Hidden Phone</label>
                <label class="checkbox"> <input type="checkbox" value="hidden-tablet">Hidden Tablet</label>
                <label class="checkbox"> <input type="checkbox" value="hidden-desktop">Hidden Desktop</label>
            </div>
        </div>
    </div>

    <!-- Row setting popbox -->
    <div id="rowsettingbox" style="display: none;">
		<h3 class="row-header">Row Settings</h3>
	
        <div>
			<div class="row-fluid">


				<div class="span6 rownameOuter">
					<label>Name: </label>
					<input type="text" class="rowname" id="">
				</div>
				
				<div class="span6 rowclassOuter">
					<label>Custom Class: </label>
					<input type="text" class="rowcustomclass" id="">
				</div>

			</div>	

            <div class="row-fluid">
                <div class="span6 rowcolorOuter">
                    <label>Background: </label>
                    <input type="text" class="rowbackgroundcolor" id="">
                </div>
                
                <div class="span6 rowcolorOuter">
                    <label>Text: </label>
                    <input type="text" class="rowtextcolor" id="">
                </div>
            </div>

            <div class="row-fluid">
                <div class="span6 rowcolorOuter">
                    <label>Link: </label>
                    <input type="text" class="rowlinkcolor" id="">
                </div>
                
                <div class="span6 rowcolorOuter">
                    <label>Link hover: </label>
                    <input type="text" class="rowlinkhovercolor" id="">
                </div>
            </div>

            <div class="row-fluid">
                <div class="span6 rownameOuter">
                    <label>Margin: </label>
                    <input type="text" class="rowmargin" id="">
                </div>
                
                <div class="span6 rowclassOuter">
                    <label>Padding: </label>
                    <input type="text" class="rowpadding" id="">
                </div>
            </div>

			<div id="rowresponsiveinputs" class="row-fluid">
				<div class="span6">
					<label class="checkbox"> <input type="checkbox" value="visible-phone">Visible Phone</label>
					<label class="checkbox"> <input type="checkbox" value="visible-tablet">Visible Tablet</label>
					<label class="checkbox"> <input type="checkbox" value="visible-desktop">Visible Desktop</label>
				</div>
				<div class="span6">
					<label class="checkbox"> <input type="checkbox" value="hidden-phone">Hidden Phone</label>
					<label class="checkbox"> <input type="checkbox" value="hidden-tablet">Hidden Tablet</label>
					<label class="checkbox"> <input type="checkbox" value="hidden-desktop">Hidden Desktop</label>
				</div>
			</div>
			
        </div>
    </div>


    <!--Start Generator -->
    <div class="generator">
        <?php
            //print_r($layout); die;
            foreach($layout as $items )
            {
            ?>
            <!-- Main Rows -->
            <div class="row-fluid layoutmainrow">
                <div class="span12">

                    <div class="rowpropperties pull-left"> 
                        <span class="rowname"><?php echo $items->name ?></span>
                        <span class="rowdocs">
                            <input type="hidden" class="rownameinput" name="" value="<?php echo $items->name ?>">
                            <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo $items->class ?>">
                            <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo $items->responsive ?>">

                            <input type="hidden" class="rowbackgroundcolorinput" name="" value="<?php echo get_color($items,'backgroundcolor') ?>">
                            <input type="hidden" class="rowtextcolorinput" name="" value="<?php echo get_color($items,'textcolor') ?>">
                            <input type="hidden" class="rowlinkcolorinput" name="" value="<?php echo get_color($items,'linkcolor') ?>">
                            <input type="hidden" class="rowlinkhovercolorinput" name="" value="<?php echo get_color($items,'linkhovercolor') ?>">
                            <input type="hidden" class="rowmargininput" name="" value="<?php echo get_value($items,'margin') ?>">
                            <input type="hidden" class="rowpaddinginput" name="" value="<?php echo get_value($items,'padding') ?>">
                        </span>
                    </div>
                    <div class="pull-right row-tools">
                        <a href="" title="Move this row" class="fa fa-arrows rowmove"></a>
                        <a href="#rowsettingbox" title="Row settings" class="fa fa-cog rowsetting" rel="rowpopover"></a>
                        <a href="" title="Add new row" class="fa fa-bars add-row"></a>
                        <a href="" title="Add new column" class="fa fa-columns add-column"></a>
                        <a href="" title="Delete row" class="fa fa-times rowdelete"></a>
                    </div>

                    <div class="hr clr"></div>

                    <div class="row-fluid show-grid">

                        <!-- Columns -->
                        <?php
                            foreach( $items->children as $item )
                            {
                            ?>
                            <div class="<?php echo ($item->type=='component' or $item->type=='message') ? 'type-'.$item->type:'' ?>  span<?php echo $item->span ?> column <?php echo ( empty($item->offset)?'':'offset'.$item->offset )?>"> 

                                <span class="position-name"><?php

                                        if($item->type=='component' || $item->type=='message' || $item->type=='megamenu') echo strtoupper($item->type);
                                        elseif(empty($item->position)) echo '(none)';
                                        else echo $item->position;

                                ?></span>
                                <div class="columntools">
                                    <a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
                                    <a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
                                    <a href="" title="Remove column" class="fa fa-times columndelete"></a>
                                    <a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                </div> 

                                <input type="hidden" class="widthinput" name="" value="<?php echo $item->span ?>"> 
                                <input type="hidden" class="offsetinput" name="" value="<?php echo $item->offset ?>"> 
                                <input type="hidden" class="typeinput" name="" value="<?php echo $item->type ?>"> 
                                <input type="hidden" class="positioninput" name="" value="<?php echo $item->position ?>"> 
                                <input type="hidden" class="styleinput" name="" value="<?php echo $item->style ?>"> 
                                <input type="hidden" class="customclassinput" name="" value="<?php echo $item->customclass ?>"> 
                                <input type="hidden" class="responsiveclassinput" name="" value="<?php echo $item->responsiveclass ?>"> 

                                <!-- Row in Columns -->
                                <?php
                                    if( !empty($item->children) and is_array($item->children) )
                                    {
                                        foreach( $item->children as $children )
                                        {
                                        ?>
                                        <div class="row-fluid child-row">
                                            <div class="span12">

                                                <div class="rowpropperties pull-left"> 
                                                    <span class="rowname"><?php echo $children->name ?></span>
                                                    <span class="rowdocs">
                                                        <input type="hidden" class="rownameinput" name="" value="<?php echo $children->name ?>">
                                                        <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo $children->class ?>">
                                                        <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo $children->responsive ?>">

                                                        

                                                        <input type="hidden" class="rowbackgroundcolorinput" name="" value="<?php echo get_color($children,'backgroundcolor') ?>">
                                                        <input type="hidden" class="rowtextcolorinput" name="" value="<?php echo get_color($children,'textcolor') ?>">
                                                        <input type="hidden" class="rowlinkcolorinput" name="" value="<?php echo get_color($children,'linkcolor') ?>">
                                                        <input type="hidden" class="rowlinkhovercolorinput" name="" value="<?php echo get_color($children,'linkhovercolor') ?>">
                                                        <input type="hidden" class="rowmargininput" name="" value="<?php echo get_value($children,'margin') ?>">
                                                        <input type="hidden" class="rowpaddinginput" name="" value="<?php echo get_value($children,'padding') ?>">

                                                    </span>
                                                </div>

                                                <div class="pull-right row-tools">
                                                    <a href="" title="Move this row" class="fa fa-arrows row-move-in-column"></a>
                                                    <a href="" title="Add new row" class="fa fa-bars add-row"></a>
                                                    <a href="" title="Add new column" class="fa fa-columns add-column"></a>
                                                    <a href="#rowsettingbox" title="Row settings" class="fa fa-cog rowsetting" rel="rowpopover"></a>
                                                    <a href="" title="Delete row" class="fa fa-times rowdelete"></a>
                                                </div>

                                                <div class="clearfix"></div>

                                                <div class="row-fluid show-grid">

                                                    <?php
                                                        foreach($children->children as $children)
                                                        {
                                                        ?>

                                                        <div class="<?php echo ($children->type=='component' or $children->type=='message') ? 'type-'.$children->type:'' ?>  span<?php echo $children->span ?> column <?php echo ( empty($children->offset)?'':'offset'.$children->offset )?>"> 

                                                            <span class="position-name"><?php

                                                                    if($children->type=='component' or $children->type=='message') echo strtoupper($children->type);
                                                                    elseif(empty($children->position)) echo '(none)';
                                                                    else echo $children->position;

                                                            ?></span>

                                                            <span class="columntools">
                                                                <a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
																<a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
																<a href="" title="Remove column" class="fa fa-times columndelete"></a>
																<a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                                            </span> 

                                                            <input type="hidden" class="widthinput" name="" value="<?php echo $children->span ?>"> 
                                                            <input type="hidden" class="offsetinput" name="" value="<?php echo $children->offset ?>"> 
                                                            <input type="hidden" class="typeinput" name="" value="<?php echo $children->type ?>"> 
                                                            <input type="hidden" class="positioninput" name="" value="<?php echo $children->position ?>"> 
                                                            <input type="hidden" class="styleinput" name="" value="<?php echo $children->style ?>"> 
                                                            <input type="hidden" class="customclassinput" name="" value="<?php echo $children->customclass ?>"> 
                                                            <input type="hidden" class="responsiveclassinput" name="" value="<?php echo $children->responsiveclass ?>">

                                                            <!--3-->



                                                            <?php

                                                                if( !empty($children->children) and is_array($children->children) )
                                                                {

                                                                    foreach( $children->children as $children )
                                                                    {



                                                                    ?>


                                                                    <div class="row-fluid child-row">
                                                                        <div class="span12">
                                                                            <div class="rowpropperties pull-left"> 
                                                                                <span class="rowname"><?php echo $children->name ?></span>
                                                                                <span class="rowdocs">
                                                                                    <input type="hidden" class="rownameinput" name="" value="<?php echo $children->name ?>">
                                                                                    <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo $children->class ?>">
                                                                                    <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo $children->responsive ?>">


                                                                                    <input type="hidden" class="rowbackgroundcolorinput" name="" value="<?php echo get_color($children,'backgroundcolor') ?>">
                                                        <input type="hidden" class="rowtextcolorinput" name="" value="<?php echo get_color($children,'textcolor') ?>">
                                                        <input type="hidden" class="rowlinkcolorinput" name="" value="<?php echo get_color($children,'linkcolor') ?>">
                                                        <input type="hidden" class="rowlinkhovercolorinput" name="" value="<?php echo get_color($children,'linkhovercolor') ?>">
                                                        <input type="hidden" class="rowmargininput" name="" value="<?php echo get_value($children,'margin') ?>">
                                                        <input type="hidden" class="rowpaddinginput" name="" value="<?php echo get_value($children,'padding') ?>">
                                                                                </span>
                                                                            </div>


                                                                            <div class="pull-right row-tools">
                                                                                <a href="" title="Move this row" class="fa fa-arrows rowmove"></a>
                                                                                <a href="" title="Add new row" class="fa fa-bars add-row"></a>
                                                                                <a href="" title="Add new column" class="fa fa-columns add-column"></a>
                                                                                <a href="#rowsettingbox" title="Row settings" class="fa fa-cog rowsetting" rel="rowpopover"></a>
                                                                                <a href="" title="Delete row" class="fa fa-times rowdelete"></a>
                                                                            </div>

                                                                            <div class="clearfix"></div>

                                                                            <div class="row-fluid show-grid">

                                                                                <?php
                                                                                    foreach($children->children as $children)
                                                                                    {
                                                                                    ?>

                                                                                    <div class="<?php echo ($children->type=='component' or $children->type=='message') ? 'type-'.$children->type:'' ?>  span<?php echo $children->span ?> column <?php echo ( empty($children->offset)?'':'offset'.$children->offset )?>"> 

                                                                                        <span class="position-name"><?php

                                                                                                if($children->type=='component' or $children->type=='message') echo strtoupper($children->type);
                                                                                                elseif(empty($children->position)) echo '(none)';
                                                                                                else echo $children->position;

                                                                                        ?></span>
                                                                                        <span class="columntools">
																							<a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
																							<a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
																							<a href="" title="Remove column" class="fa fa-times columndelete"></a>
																							<a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                                                                        </span> 

                                                                                        <input type="hidden" class="widthinput" name="" value="<?php echo $children->span ?>"> 
                                                                                        <input type="hidden" class="offsetinput" name="" value="<?php echo $children->offset ?>"> 
                                                                                        <input type="hidden" class="typeinput" name="" value="<?php echo $children->type ?>"> 
                                                                                        <input type="hidden" class="positioninput" name="" value="<?php echo $children->position ?>"> 
                                                                                        <input type="hidden" class="styleinput" name="" value="<?php echo $children->style ?>"> 
                                                                                        <input type="hidden" class="customclassinput" name="" value="<?php echo $children->customclass ?>"> 
                                                                                        <input type="hidden" class="responsiveclassinput" name="" value="<?php echo $children->responsiveclass ?>">


                                                                                        <!-- 4-->


                                                                                        <?php

                                                                                            if( !empty($children->children) and is_array($children->children) )
                                                                                            {
                                                                                                foreach( $children->children as $children )
                                                                                                {

                                                                                                ?>
                                                                                                <div class="row-fluid child-row">
                                                                                                    <div class="span12">
                                                                                                        <div class="rowpropperties pull-left"> 
                                                                                                            <span class="rowname"><?php echo $children->name ?></span>
                                                                                                            <span class="rowdocs">
                                                                                                                <input type="hidden" class="rownameinput" name="" value="<?php echo $children->name ?>">
                                                                                                                <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo $children->class ?>">
                                                                                                                <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo $children->responsive ?>">



                                                                                                                <input type="hidden" class="rowbackgroundcolorinput" name="" value="<?php echo get_color($children,'backgroundcolor') ?>">
                                                        <input type="hidden" class="rowtextcolorinput" name="" value="<?php echo get_color($children,'textcolor') ?>">
                                                        <input type="hidden" class="rowlinkcolorinput" name="" value="<?php echo get_color($children,'linkcolor') ?>">
                                                        <input type="hidden" class="rowlinkhovercolorinput" name="" value="<?php echo get_color($children,'linkhovercolor') ?>">
                                                        <input type="hidden" class="rowmargininput" name="" value="<?php echo get_value($children,'margin') ?>">
                                                        <input type="hidden" class="rowpaddinginput" name="" value="<?php echo get_value($children,'padding') ?>">
                                                                                                            </span>
                                                                                                        </div>
                                                                                                        <div class="pull-right row-tools">
                                                                                                            <a href="" title="Move this row" class="fa fa-arrows rowmove"></a>
                                                                                                            <a href="" title="Add new row" class="fa fa-bars add-row"></a>
                                                                                                            <a href="" title="Add new column" class="fa fa-columns add-column"></a>
                                                                                                            <a href="#rowsettingbox" title="Row settings" class="fa fa-cog rowsetting" rel="rowpopover"></a>
                                                                                                            <a href="" title="Delete row" class="fa fa-times rowdelete"></a>
                                                                                                        </div>

                                                                                                        <div class="clearfix"></div>

                                                                                                        <div class="row-fluid show-grid">

                                                                                                            <?php
                                                                                                                foreach($children->children as $children)
                                                                                                                {
                                                                                                                ?>

                                                                                                                <div class="<?php echo ($children->type=='component' or $children->type=='message') ? 'type-'.$children->type:'' ?>  span<?php echo $children->span ?> column <?php echo ( empty($children->offset)?'':'offset'.$children->offset )?>"> 

                                                                                                                    <span class="position-name"><?php

                                                                                                                            if($children->type=='component' or $children->type=='message') echo strtoupper($children->type);
                                                                                                                            elseif(empty($children->position)) echo '(none)';
                                                                                                                            else echo $children->position;

                                                                                                                    ?></span>
                                                                                                                    <span class="columntools">
																														<a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
																														<a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
																														<a href="" title="Remove column" class="fa fa-times columndelete"></a>
																														<a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                                                                                                    </span> 

                                                                                                                    <input type="hidden" class="widthinput" name="" value="<?php echo $children->span ?>"> 
                                                                                                                    <input type="hidden" class="offsetinput" name="" value="<?php echo $children->offset ?>"> 
                                                                                                                    <input type="hidden" class="typeinput" name="" value="<?php echo $children->type ?>"> 
                                                                                                                    <input type="hidden" class="positioninput" name="" value="<?php echo $children->position ?>"> 
                                                                                                                    <input type="hidden" class="styleinput" name="" value="<?php echo $children->style ?>"> 
                                                                                                                    <input type="hidden" class="customclassinput" name="" value="<?php echo $children->customclass ?>"> 
                                                                                                                    <input type="hidden" class="responsiveclassinput" name="" value="<?php echo $children->responsiveclass ?>">

                                                                                                                </div>


                                                                                                                <?php 
                                                                                                            } ?>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>


                                                                                                <?php

                                                                                                }
                                                                                            }

                                                                                        ?>

                                                                                        <!-- 4-->


                                                                                    </div>


                                                                                    <?php 
                                                                                } ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <?php

                                                                    }
                                                                }

                                                            ?>


                                                            <!--3-->




                                                        </div>


                                                        <?php 
                                                    } ?>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                ?>
                                <!--  End Row in Columns -->
                            </div>

                            <?php
                            }
                        ?>
                        <!-- Columns -->

                    </div>

                </div>
            </div>
            <!-- End Main Rows -->
            <?php
            }
        ?>

    </div>
    <div class="clearfix"></div>
 </div>
