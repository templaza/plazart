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
jimport('joomla.filesystem.file');
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
//print_r($layout); die;
	?>
	<!-- Main Rows -->
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
				<a href="" title="Move this row" class="fas fa-arrows-alt rowmove"></a>
				<a href="#rowloadbox" title="Add a section" class="fas fa-cloud-upload-alt rowload" rel="rowpopover"></a>
				<a href="#rowsavebox" title="Save this section" class="fas fa-save rowsave" rel="rowpopover"></a>
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
							<a href="" title="Move column" class="fas fa-arrows-alt columnmove"></a>
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
											<a href="" title="Move this row" class="fas fa-arrows-alt row-move-in-column"></a>
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
																<a href="" title="Move column" class="fas fa-arrows-alt columnmove"></a>
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
																		<a href="" title="Move this row" class="fas fa-arrows-alt rowmove"></a>
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
																							<a href="" title="Move column" class="fas fa-arrows-alt columnmove"></a>
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
																									<a href="" title="Move this row" class="fas fa-arrows-alt rowmove"></a>
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
																														<a href="" title="Move column" class="fas fa-arrows-alt columnmove"></a>
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
	<!-- End Main Rows -->
