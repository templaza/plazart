<?php
/**
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2012-2015 TemPlaza.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       TemPlaza
 * @Link:         http://templaza.com
 *------------------------------------------------------------------------------
 */
/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2013 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
// No direct access
defined('_JEXEC') or die();
if( !function_exists('get_value') ){

    function get_value($item, $method){
        if (!isset($item[$method])) {
            if (preg_match('/offset/', $method)) {
                return isset($item['offset']) ? $item['offset'] : '';
            }
            if (preg_match('/col/', $method)) {
                return isset($item['span']) ? $item['span'] : '12';
            }
        }
        return isset($item[$method]) ? $item[$method] : '';
    }
}

if( !function_exists('get_color') ){

    function get_color($item, $method){
        return isset($item[$method]) ? $item[$method] : 'rgba(255, 255, 255, 0)';
    }
}
?>

<div class="container-fluid" id="plazart_layout_builder">

<!-- Column setting popbox -->
<div id="columnsettingbox" style="display: none;">
    <ul class="nav nav-tab" id="columnsettings">
        <li class="active"><a  href="#basic" data-toggle="tab">Basic</a></li>
        <li><a href="#responsive" data-toggle="tab">Responsive</a></li>
        <li><a href="#animation" data-toggle="tab">Animation</a></li>
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
                    <option value="logo">Logo</option>
                    <option value="custom_html">Custom HTML</option>
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
            <div id="customhtml">
                <label>Custom Title: </label>
                <input type="text" class="customtitle" id="inputcustomtitle">

                <label>Custom HTML: </label>
                <textarea class="customhtml" id="inputcustomhtml"></textarea>
            </div>
        </div>

        <div class="tab-pane" id="responsive">
            <label class="checkbox"> <input type="checkbox" value="visible-lg">Visible Large devices</label>
            <label class="checkbox"> <input type="checkbox" value="visible-md">Visible Medium devices</label>
            <label class="checkbox"> <input type="checkbox" value="visible-sm">Visible Small devices</label>
            <label class="checkbox"> <input type="checkbox" value="visible-xs">Visible Extra small devices</label>
            <label class="checkbox"> <input type="checkbox" value="hidden-xs">Hidden Extra small devices</label>
            <label class="checkbox"> <input type="checkbox" value="hidden-sm">Hidden Small devices</label>
            <label class="checkbox"> <input type="checkbox" value="hidden-md">Hidden Medium devices</label>
            <label class="checkbox"> <input type="checkbox" value="hidden-lg">Hidden Large devices</label>
        </div>
        <div class="tab-pane" id="animation">
            <h4>Choose Type of Animation:</h4>
            <select class="animationType">
                <option value="none" selected>None</option>
                <option value="fade-in">Fade-In</option>
                <option value="fade-out">Fade-Out</option>
                <option value="slide-down-from-top">Slide-Down-From-Top</option>
                <option value="slide-in-from-right">Slide-In-From-Right</option>
                <option value="slide-up-from-bottom">Slide-Up-From-Bottom</option>
                <option value="slide-in-from-left">Slide-In-From-Left</option>
                <option value="scale-up">Scale Up</option>
                <option value="scale-down">Scale Down</option>
                <option value="rotate">Rotate</option>
                <option value="flip-y-axis">Flip-Y-Axis</option>
                <option value="flip-x-axis">Flip-X-Axis</option>
            </select>
            <br/>
            <h4>Animation Speed in Milliseconds:</h4>
            <input type="text" class="animationSpeed"> <br/><p>eg. (1000 = 1 second)</p>
            <h4>Animation Delay in Milliseconds:</h4>
            <input type="text" class="animationDelay">
            <br/>
            <h4>Animation Offset Percentage(Trigger Point):</h4>
            <input type="text" class="animationOffset"> <br/><p>eg. (value of 0 = top of viewport, value of 100 = bottom of viewport)</p>
            <h4>Animation Easing:</h4>
            <select class="animationEasing">
                <option value="ease" selected>ease</option>
                <option value="in">in</option>
                <option value="out">out</option>
                <option value="in-out">in-out</option>
                <option value="snap">snap</option>
                <option value="easeOutCubic">easeOutCubic</option>
                <option value="easeInOutCubic">easeInOutCubic</option>
                <option value="easeOutCirc">easeOutCirc</option>
                <option value="easeInOutCirc">easeInOutCirc</option>
                <option value="easeInExpo">easeInExpo</option>
                <option value="easeOutExpo">easeOutExpo</option>
                <option value="easeInOutExpo">easeInOutExpo</option>
                <option value="easeInQuad">easeInQuad</option>
                <option value="easeOutQuad">easeOutQuad</option>
                <option value="easeInOutQuad">easeInOutQuad</option>
                <option value="easeInQuart">easeInQuart</option>
                <option value="easeOutQuart">easeOutQuart</option>
                <option value="easeInOutQuart">easeInOutQuart</option>
                <option value="easeInQuint">easeInQuint</option>
                <option value="easeOutQuint">easeOutQuint</option>
                <option value="easeInOutQuint">easeInOutQuint</option>
                <option value="easeInSine">easeInSine</option>
                <option value="easeOutSine">easeOutSine</option>
                <option value="easeInOutSine">easeInOutSine</option>
                <option value="easeInBack">easeInBack</option>
                <option value="easeOutBack">easeOutBack</option>
                <option value="easeInOutBack">easeInOutBack</option>
            </select>
            <br/>
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
                <label>Background Image: </label>
                <div class="input-prepend input-append">
                    <div class="media-preview add-on">
                        <span title="" class="hasTipPreview"><span class="icon-eye"></span></span>
                    </div>
                    <input type="text" class="rowbackgroundimage" readonly="readonly"
                           title="<?php echo htmlspecialchars('<span class="TipImgpath"></span>', ENT_COMPAT, 'UTF-8');?>"
                           aria-invalid="false"
                           value="">
                    <a rel="{handler: 'iframe', size: {x: 800, y: 500}}" title="<?php echo JText::_('JSELECT');?>"
                       class="modal btn btn-info"><span class="icon-folder"></span></a>
                    <a href="javascript: void(0)" title="<?php echo JText::_('JCLEAR');?>"
                       class="btn btn-danger tz_btn-clear-image hasTooltip">
                        <span class="icon-remove"></span></a>
                </div>
            </div>
            <div class="span6 rowcolorOuter">
                <label>Background Overlay Color: </label>
                <input type="text" class="rowbackgroundoverlaycolor" id="">
            </div>
        </div>

        <div class="row-fluid">
            <div class="span6 rowcolorOuter">
                <label>Background Repeat: </label>
                <select class="rowbackgroundrepeat">
                    <option value="no-repeat">No Repeat</option>
                    <option value="repeat">Repeat All</option>
                    <option value="repeat-x">Repeat Horizontally</option>
                    <option value="repeat-y">Repeat Vertically</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
            <div class="span6 rowcolorOuter">
                <label>Background Size: </label>
                <select class="rowbackgroundsize">
                    <option value="cover">Cover</option>
                    <option value="contain">Contain</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span6 rowcolorOuter">
                <label>Background Attachment: </label>
                <select class="rowbackgroundattachment">
                    <option value="fixed">Fixed</option>
                    <option value="scroll">Scroll</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
            <div class="span6 rowcolorOuter">
                <label>Background Position: </label>
                <select class="rowbackgroundposition">
                    <option value="0 0">Left Top</option>
                    <option value="0 50%">Left Center</option>
                    <option value="0 100%">Left Bottom</option>
                    <option value="50% 0">Center Top</option>
                    <option value="50% 50%">Center Center</option>
                    <option value="50% 100%">Center Bottom</option>
                    <option value="100% 0">Right Top</option>
                    <option value="100% 50%">Right Center</option>
                    <option value="100% 100%">Right Bottom</option>
                </select>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span6 rowcolorOuter">
                <label>Background Color: </label>
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
                <label class="checkbox"> <input type="checkbox" value="visible-xs">Visible Extra small</label>
                <label class="checkbox"> <input type="checkbox" value="visible-sm">Visible Small</label>
                <label class="checkbox"> <input type="checkbox" value="visible-md">Visible Medium</label>
                <label class="checkbox"> <input type="checkbox" value="visible-lg">Visible Large</label>
            </div>
            <div class="span6">
                <label class="checkbox"> <input type="checkbox" value="hidden-xs">Hidden Extra small</label>
                <label class="checkbox"> <input type="checkbox" value="hidden-sm">Hidden Small</label>
                <label class="checkbox"> <input type="checkbox" value="hidden-md">Hidden Medium</label>
                <label class="checkbox"> <input type="checkbox" value="hidden-lg">Hidden Large</label>
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
        <span class="rowname"><?php echo $items["name"] ?></span>
                        <span class="rowdocs">
                            <input type="hidden" class="rownameinput" name="" value="<?php echo get_value($items,"name"); ?>">
                            <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo get_value($items,"class") ?>">
                            <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo get_value($items,"responsive") ?>">

                            <input type="hidden" class="rowbackgroundimageinput" name="" value="<?php echo get_value($items,'backgroundimage') ?>">
                            <input type="hidden" class="rowbackgroundoverlaycolorinput" name="" value="<?php echo get_color($items,'backgroundoverlaycolor') ?>">
                            <input type="hidden" class="rowbackgroundrepeatinput" name="" value="<?php echo get_value($items,'backgroundrepeat') ?>">
                            <input type="hidden" class="rowbackgroundsizeinput" name="" value="<?php echo get_value($items,'backgroundsize') ?>">
                            <input type="hidden" class="rowbackgroundattachmentinput" name="" value="<?php echo get_value($items,'backgroundattachment') ?>">
                            <input type="hidden" class="rowbackgroundpositioninput" name="" value="<?php echo get_value($items,'backgroundposition') ?>">

                            <input type="hidden" class="rowbackgroundcolorinput" name="" value="<?php echo get_color($items,'backgroundcolor') ?>">
                            <input type="hidden" class="rowtextcolorinput" name="" value="<?php echo get_color($items,'textcolor') ?>">
                            <input type="hidden" class="rowlinkcolorinput" name="" value="<?php echo get_color($items,'linkcolor') ?>">
                            <input type="hidden" class="rowlinkhovercolorinput" name="" value="<?php echo get_color($items,'linkhovercolor') ?>">
                            <input type="hidden" class="rowmargininput" name="" value="<?php echo get_value($items,'margin') ?>">
                            <input type="hidden" class="rowpaddinginput" name="" value="<?php echo get_value($items,'padding') ?>">
                        </span>
    </div>
    <div class="pull-right row-tools row-container">
        <select name="" class="containertype">
            <option value="container"<?php echo (isset($items["containertype"]) && $items["containertype"]=='container') ? ' selected': ''; ?>>Fixed Width</option>
            <option value="container-fluid"<?php echo (isset($items["containertype"]) && $items["containertype"]=='container-fluid') ? ' selected': ''; ?>>Full Width</option>
        </select>
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
    foreach( $items["children"] as $item )
    {
        ?>
        <div class="<?php echo (get_value($item,"type")=='component' or get_value($item,"type")=='message') ? 'type-'.get_value($item,"type"):'' ?>  span<?php echo get_value($item,"col-lg"); ?> column <?php echo ( empty($item["col-lg-offset"])?'':'offset'.$item["col-lg-offset"] )?>">

                                <span class="position-name"><?php

                                    if(get_value($item,"type")=='component' || get_value($item,"type")=='message' || get_value($item,"type")=='megamenu' || get_value($item,"type")=='logo') { echo strtoupper(get_value($item,"type")); }
                                        elseif (get_value($item,"type")=='custom_html') {
                                            if (trim(get_value($item,"customtitle")) != '') echo trim(get_value($item,"customtitle")). ' - Custom HTML'; else echo 'Custom HTML';
                                        }
                                    elseif(empty($item["position"])) echo '(none)';
                                    else echo get_value($item,"position");

                                    ?></span>
                                <div class="columntools">
                                    <a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
                                    <a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
                                    <a href="" title="Remove column" class="fa fa-times columndelete"></a>
                                    <a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                </div>

                                <input type="hidden" class="widthinput-xs" name="" value="<?php echo get_value($item,"col-xs") ?>">
                                <input type="hidden" class="widthinput-sm" name="" value="<?php echo get_value($item,"col-sm") ?>">
                                <input type="hidden" class="widthinput-md" name="" value="<?php echo get_value($item,"col-md") ?>">
                                <input type="hidden" class="widthinput-lg" name="" value="<?php echo get_value($item,"col-lg") ?>">
                                <input type="hidden" class="offsetinput-xs" name="" value="<?php echo get_value($item,"col-xs-offset") ?>">
                                <input type="hidden" class="offsetinput-sm" name="" value="<?php echo get_value($item,"col-sm-offset") ?>">
                                <input type="hidden" class="offsetinput-md" name="" value="<?php echo get_value($item,"col-md-offset") ?>">
                                <input type="hidden" class="offsetinput-lg" name="" value="<?php echo get_value($item,"col-lg-offset") ?>">
                                <input type="hidden" class="typeinput" name="" value="<?php echo get_value($item,"type") ?>">
                                <input type="hidden" class="positioninput" name="" value="<?php echo get_value($item,"position") ?>">
                                <input type="hidden" class="styleinput" name="" value="<?php echo get_value($item,"style") ?>">
                                <input type="hidden" class="customclassinput" name="" value="<?php echo get_value($item,"customclass") ?>">
                                <input type="hidden" class="customtitleinput" name="" value="<?php echo get_value($item,"customtitle") ?>">
                                <input type="hidden" class="customhtmlinput" name="" value="<?php echo htmlspecialchars(get_value($item,"customhtml")) ?>">
                                <input type="hidden" class="responsiveclassinput" name="" value="<?php echo get_value($item,"responsiveclass") ?>">
                                <input type="hidden" class="animationType" name="" value="<?php echo get_value($item,"animationType") ?>">
                                <input type="hidden" class="animationSpeed" name="" value="<?php echo get_value($item,"animationSpeed") ?>">
                                <input type="hidden" class="animationDelay" name="" value="<?php echo get_value($item,"animationDelay") ?>">
                                <input type="hidden" class="animationOffset" name="" value="<?php echo get_value($item,"animationOffset") ?>">
                                <input type="hidden" class="animationEasing" name="" value="<?php echo get_value($item,"animationEasing") ?>">
                                <!-- Row in Columns -->
                                <?php
                                if( !empty($item["children"]) and is_array($item["children"]) )
                                {
                                    foreach( $item["children"] as $children )
                                    {
                                        ?>
                                        <div class="row-fluid child-row">
                                        <div class="span12">

                                        <div class="rowpropperties pull-left">
                                            <span class="rowname"><?php echo $children["name"] ?></span>
                                                    <span class="rowdocs">
                                                        <input type="hidden" class="rownameinput" name="" value="<?php echo get_value($children,"name") ?>">
                                                        <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo get_value($children,"class") ?>">
                                                        <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo get_value($children,"responsive") ?>">

                                                        

                                                        <input type="hidden" class="rowbackgroundimageinput" name="" value="<?php echo get_value($children,'backgroundimage') ?>">
                                                        <input type="hidden" class="rowbackgroundoverlaycolorinput" name="" value="<?php echo get_color($children,'backgroundoverlaycolor') ?>">
                                                        <input type="hidden" class="rowbackgroundrepeatinput" name="" value="<?php echo get_value($children,'backgroundrepeat') ?>">
                                                        <input type="hidden" class="rowbackgroundsizeinput" name="" value="<?php echo get_value($children,'backgroundsize') ?>">
                                                        <input type="hidden" class="rowbackgroundattachmentinput" name="" value="<?php echo get_value($children,'backgroundattachment') ?>">
                                                        <input type="hidden" class="rowbackgroundpositioninput" name="" value="<?php echo get_value($children,'backgroundposition') ?>">
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
                                        foreach($children["children"] as $children)
                                        {
                                            ?>

                                            <div class="<?php echo (get_value($children,"type")=='component' or get_value($children,"type")=='message') ? 'type-'.get_value($children,"type"):'' ?>  span<?php echo get_value($children,"col-lg"); ?> column <?php echo ( empty($children["col-lg-offset"])?'':'offset'.$children["col-lg-offset"] )?>">

                                                            <span class="position-name"><?php

                                                                if(get_value($children,"type")=='component' || get_value($children,"type")=='message' || get_value($children,"type")=='megamenu' || get_value($children,"type")=='logo') echo strtoupper($children["type"]);
                                                                elseif (get_value($children,"type")=='custom_html') {
                                                                    if (trim(get_value($children,"customtitle")) != '') echo trim(get_value($children,"customtitle")). ' - Custom HTML'; else echo 'Custom HTML';
                                                                }
                                                                elseif(empty($children["position"])) echo '(none)';
                                                                else echo get_value($children,"position");

                                                                ?></span>

                                                            <span class="columntools">
                                                                <a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
																<a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
																<a href="" title="Remove column" class="fa fa-times columndelete"></a>
																<a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                                            </span>

                                                            <input type="hidden" class="widthinput-xs" name="" value="<?php echo get_value($children,"col-xs") ?>">
                                                            <input type="hidden" class="widthinput-sm" name="" value="<?php echo get_value($children,"col-sm") ?>">
                                                            <input type="hidden" class="widthinput-md" name="" value="<?php echo get_value($children,"col-md") ?>">
                                                            <input type="hidden" class="widthinput-lg" name="" value="<?php echo get_value($children,"col-lg") ?>">
                                                            <input type="hidden" class="offsetinput-xs" name="" value="<?php echo get_value($children,"col-xs-offset") ?>">
                                                            <input type="hidden" class="offsetinput-sm" name="" value="<?php echo get_value($children,"col-sm-offset") ?>">
                                                            <input type="hidden" class="offsetinput-md" name="" value="<?php echo get_value($children,"col-md-offset") ?>">
                                                            <input type="hidden" class="offsetinput-lg" name="" value="<?php echo get_value($children,"col-lg-offset") ?>">
                                                            <input type="hidden" class="typeinput" name="" value="<?php echo get_value($children,"type") ?>">
                                                            <input type="hidden" class="positioninput" name="" value="<?php echo get_value($children,"position") ?>">
                                                            <input type="hidden" class="styleinput" name="" value="<?php echo get_value($children,"style") ?>">
                                                            <input type="hidden" class="customclassinput" name="" value="<?php echo get_value($children,"customclass") ?>">
                                                            <input type="hidden" class="customtitleinput" name="" value="<?php echo get_value($children,"customtitle") ?>">
                                                            <input type="hidden" class="customhtmlinput" name="" value="<?php echo htmlspecialchars(get_value($children,"customhtml")) ?>">
                                                            <input type="hidden" class="responsiveclassinput" name="" value="<?php echo get_value($children,"responsiveclass") ?>">
                                                            <input type="hidden" class="animationType" name="" value="<?php echo get_value($children,"animationType") ?>">
                                                            <input type="hidden" class="animationSpeed" name="" value="<?php echo get_value($children,"animationSpeed") ?>">
                                                            <input type="hidden" class="animationDelay" name="" value="<?php echo get_value($children,"animationDelay") ?>">
                                                            <input type="hidden" class="animationOffset" name="" value="<?php echo get_value($children,"animationOffset") ?>">
                                                            <input type="hidden" class="animationEasing" name="" value="<?php echo get_value($children,"animationEasing") ?>">

                                                            <!--3-->



                                                            <?php

                                                            if( !empty($children["children"]) and is_array($children["children"]) )
                                                            {

                                                                foreach( $children["children"] as $children )
                                                                {



                                                                    ?>


                                                                    <div class="row-fluid child-row">
                                                                        <div class="span12">
                                                                            <div class="rowpropperties pull-left">
                                                                                <span class="rowname"><?php echo get_value($children,"name") ?></span>
                                                                                <span class="rowdocs">
                                                                                    <input type="hidden" class="rownameinput" name="" value="<?php echo get_value($children,"name") ?>">
                                                                                    <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo get_value($children,"class") ?>">
                                                                                    <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo get_value($children,"responsive") ?>">


                                                                                    <input type="hidden" class="rowbackgroundimageinput" name="" value="<?php echo get_value($children,'backgroundimage') ?>">
                                                                                    <input type="hidden" class="rowbackgroundoverlaycolorinput" name="" value="<?php echo get_value($children,'backgroundoverlaycolor') ?>">
                                                                                    <input type="hidden" class="rowbackgroundrepeatinput" name="" value="<?php echo get_value($children,'backgroundrepeat') ?>">
                                                                                    <input type="hidden" class="rowbackgroundsizeinput" name="" value="<?php echo get_value($children,'backgroundsize') ?>">
                                                                                    <input type="hidden" class="rowbackgroundattachmentinput" name="" value="<?php echo get_value($children,'backgroundattachment') ?>">
                                                                                    <input type="hidden" class="rowbackgroundpositioninput" name="" value="<?php echo get_value($children,'backgroundposition') ?>">

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
                                                                                foreach($children["children"] as $children) {
                                                                                    ?>
                                                                                    <div class="<?php echo (get_value($children,"type")=='component' or get_value($children,"type")=='message') ? 'type-'.get_value($children,"type"):'' ?>  span<?php echo get_value($children,"col-lg"); ?> column <?php echo ( empty($children["col-lg-offset"])?'':'offset'.$children["col-lg-offset"] )?>">
                                                                                        <span class="position-name"><?php
                                                                                            if(get_value($children,"type")=='component' || get_value($children,"type")=='message' || get_value($children,"type")=='megamenu' || get_value($children,"type")=='logo') echo strtoupper($children["type"]);
                                                                                            elseif (get_value($children,"type")=='custom_html') {
                                                                                                if (trim(get_value($children,"customtitle")) != '') echo trim(get_value($children,"customtitle")). ' - Custom HTML'; else echo 'Custom HTML';
                                                                                            }
                                                                                            elseif(empty($children["position"])) echo '(none)';
                                                                                            else echo get_value($children,"position");
                                                                                            ?></span>
                                                                                        <span class="columntools">
																							<a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
																							<a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
																							<a href="" title="Remove column" class="fa fa-times columndelete"></a>
																							<a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                                                                        </span>
                                                                                        <input type="hidden" class="widthinput-xs" name="" value="<?php echo get_value($children,"col-xs") ?>">
                                                                                        <input type="hidden" class="widthinput-sm" name="" value="<?php echo get_value($children,"col-sm") ?>">
                                                                                        <input type="hidden" class="widthinput-md" name="" value="<?php echo get_value($children,"col-md") ?>">
                                                                                        <input type="hidden" class="widthinput-lg" name="" value="<?php echo get_value($children,"col-lg") ?>">
                                                                                        <input type="hidden" class="offsetinput-xs" name="" value="<?php echo get_value($children,"col-xs-offset") ?>">
                                                                                        <input type="hidden" class="offsetinput-sm" name="" value="<?php echo get_value($children,"col-sm-offset") ?>">
                                                                                        <input type="hidden" class="offsetinput-md" name="" value="<?php echo get_value($children,"col-md-offset") ?>">
                                                                                        <input type="hidden" class="offsetinput-lg" name="" value="<?php echo get_value($children,"col-lg-offset") ?>">
                                                                                        <input type="hidden" class="typeinput" name="" value="<?php echo get_value($children,"type") ?>">
                                                                                        <input type="hidden" class="positioninput" name="" value="<?php echo get_value($children,"position") ?>">
                                                                                        <input type="hidden" class="styleinput" name="" value="<?php echo get_value($children,"style") ?>">
                                                                                        <input type="hidden" class="customclassinput" name="" value="<?php echo get_value($children,"customclass") ?>">
                                                                                        <input type="hidden" class="customtitleinput" name="" value="<?php echo get_value($children,"customtitle") ?>">
                                                                                        <input type="hidden" class="customhtmlinput" name="" value="<?php echo htmlspecialchars(get_value($children,"customhtml")) ?>">
                                                                                        <input type="hidden" class="responsiveclassinput" name="" value="<?php echo get_value($children,"responsiveclass") ?>">
                                                                                        <input type="hidden" class="animationType" name="" value="<?php echo get_value($children,"animationType") ?>">
                                                                                        <input type="hidden" class="animationSpeed" name="" value="<?php echo get_value($children,"animationSpeed") ?>">
                                                                                        <input type="hidden" class="animationDelay" name="" value="<?php echo get_value($children,"animationDelay") ?>">
                                                                                        <input type="hidden" class="animationOffset" name="" value="<?php echo get_value($children,"animationOffset") ?>">
                                                                                        <input type="hidden" class="animationEasing" name="" value="<?php echo get_value($children,"animationEasing") ?>">
                                                                                        <!-- 4-->
                                                                                        <?php
                                                                                        if( !empty($children["children"]) and is_array($children["children"]) ) {
                                                                                            foreach( $children["children"] as $children )
                                                                                            {
                                                                                                ?>
                                                                                                <div class="row-fluid child-row">
                                                                                                    <div class="span12">
                                                                                                        <div class="rowpropperties pull-left">
                                                                                                            <span class="rowname"><?php echo $children["name"] ?></span>
                                                                                                            <span class="rowdocs">
                                                                                                                <input type="hidden" class="rownameinput" name="" value="<?php echo get_value($children,"name") ?>">
                                                                                                                <input type="hidden" class="rowcustomclassinput" name="" value="<?php echo get_value($children,"class") ?>">
                                                                                                                <input type="hidden" class="rowresponsiveinput" name="" value="<?php echo get_value($children,"responsive") ?>">

                                                                                                                <input type="hidden" class="rowbackgroundimageinput" name="" value="<?php echo get_value($children,'backgroundimage') ?>">
                                                                                                                <input type="hidden" class="rowbackgroundoverlaycolorinput" name="" value="<?php echo get_value($children,'backgroundoverlaycolor') ?>">
                                                                                                                <input type="hidden" class="rowbackgroundrepeatinput" name="" value="<?php echo get_value($children,'backgroundrepeat') ?>">
                                                                                                                <input type="hidden" class="rowbackgroundsizeinput" name="" value="<?php echo get_value($children,'backgroundsize') ?>">
                                                                                                                <input type="hidden" class="rowbackgroundattachmentinput" name="" value="<?php echo get_value($children,'backgroundattachment') ?>">
                                                                                                                <input type="hidden" class="rowbackgroundpositioninput" name="" value="<?php echo get_value($children,'backgroundposition') ?>">

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
                                                                                                            foreach($children["children"] as $children)
                                                                                                            {
                                                                                                                ?>

                                                                                                                <div class="<?php echo (get_value($children,"type")=='component' or get_value($children,"type")=='message') ? 'type-'.get_value($children,"type"):'' ?>  span<?php echo get_value($children,"col-lg"); ?> column <?php echo ( empty($children["col-lg-offset"])?'':'offset'.$children["col-lg-offset"] )?>">

                                                                                                                    <span class="position-name"><?php

                                                                                                                        if(get_value($children,"type")=='component' || get_value($children,"type")=='message' || get_value($children,"type")=='megamenu' || get_value($children,"type")=='logo') echo strtoupper($children["type"]);
                                                                                                                        elseif (get_value($children,"type")=='custom_html') {
                                                                                                                            if (trim(get_value($children,"customtitle")) != '') echo trim(get_value($children,"customtitle")). ' - Custom HTML'; else echo 'Custom HTML';
                                                                                                                        }
                                                                                                                        elseif(empty($children["position"])) echo '(none)';
                                                                                                                        else echo get_value($children,"position");

                                                                                                                        ?></span>
                                                                                                                    <span class="columntools">
																														<a href="#columnsettingbox" rel="popover" data-placement="bottom" title="Column settings" class="fa fa-cog rowcolumnspop"></a>
																														<a href="" title="Add new row" class="fa fa-bars add-rowin-column"></a>
																														<a href="" title="Remove column" class="fa fa-times columndelete"></a>
																														<a href="" title="Move column" class="fa fa-arrows columnmove"></a>
                                                                                                                    </span>

                                                                                                                    <input type="hidden" class="widthinput-xs" name="" value="<?php echo get_value($children,"col-xs") ?>">
                                                                                                                    <input type="hidden" class="widthinput-sm" name="" value="<?php echo get_value($children,"col-sm") ?>">
                                                                                                                    <input type="hidden" class="widthinput-md" name="" value="<?php echo get_value($children,"col-md") ?>">
                                                                                                                    <input type="hidden" class="widthinput-lg" name="" value="<?php echo get_value($children,"col-lg") ?>">
                                                                                                                    <input type="hidden" class="offsetinput-xs" name="" value="<?php echo get_value($children,"col-xs-offset") ?>">
                                                                                                                    <input type="hidden" class="offsetinput-sm" name="" value="<?php echo get_value($children,"col-sm-offset") ?>">
                                                                                                                    <input type="hidden" class="offsetinput-md" name="" value="<?php echo get_value($children,"col-md-offset") ?>">
                                                                                                                    <input type="hidden" class="offsetinput-lg" name="" value="<?php echo get_value($children,"col-lg-offset") ?>">
                                                                                                                    <input type="hidden" class="typeinput" name="" value="<?php echo get_value($children,"type") ?>">
                                                                                                                    <input type="hidden" class="positioninput" name="" value="<?php echo get_value($children,"position") ?>">
                                                                                                                    <input type="hidden" class="styleinput" name="" value="<?php echo get_value($children,"style") ?>">
                                                                                                                    <input type="hidden" class="customclassinput" name="" value="<?php echo get_value($children,"customclass") ?>">
                                                                                                                    <input type="hidden" class="customtitleinput" name="" value="<?php echo get_value($children,"customtitle") ?>">
                                                                                                                    <input type="hidden" class="customhtmlinput" name="" value="<?php echo htmlspecialchars(get_value($children,"customhtml")) ?>">
                                                                                                                    <input type="hidden" class="responsiveclassinput" name="" value="<?php echo get_value($children,"responsiveclass") ?>">
                                                                                                                    <input type="hidden" class="animationType" name="" value="<?php echo get_value($children,"animationType") ?>">
                                                                                                                    <input type="hidden" class="animationSpeed" name="" value="<?php echo get_value($children,"animationSpeed") ?>">
                                                                                                                    <input type="hidden" class="animationDelay" name="" value="<?php echo get_value($children,"animationDelay") ?>">
                                                                                                                    <input type="hidden" class="animationOffset" name="" value="<?php echo get_value($children,"animationOffset") ?>">
                                                                                                                    <input type="hidden" class="animationEasing" name="" value="<?php echo get_value($children,"animationEasing") ?>">
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
