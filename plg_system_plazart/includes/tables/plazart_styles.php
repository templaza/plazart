<?php
// no direct access
defined('_JEXEC') or die( 'Restricted access' );
class JTablePlazart_Styles extends JTable
{
    /** @var int Primary key */
    var $id 				= null;
    /** @var int */
    var $template     		= null;
    /** @var int */
    var $style_id     		= 0;
    /** @var string */
    var $style_type			= null;
    /** @var string */
    var $style_content  	= null;

    /**
     * @param database A database connector object
     */
    function __construct(&$db)
    {
        parent::__construct( '#__plazart_styles', 'id', $db );
    }
}