<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/controller.php (General-Controller-File)        //
// @implements  : Class jTODO-Controller                                //
// @description : General (Main-)Controller for the jTODO-Component     //
// Version      : 1.1.3                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// import Joomla controller library
jimport( 'joomla.application.component.controller' );

class jTODOController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'todos'));
 
		// call parent behavior
		parent::display($cachable);	}

}
