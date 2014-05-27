<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/helpers/jtodo.php (General-Helper-Class)        //
// @implements  : Class jToDoHelper                                     //
// @description : General HelperClass for the jTODO-Component           //
// Version      : 2.0.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

class jToDoHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string	The name of the active view.
	 *
	 * @return  void
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_JTODO_SUBMENU_PROJECTS'),
			'index.php?option=com_jtodo&view=projects',
			$vName == 'projects'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_JTODO_SUBMENU_CATEGORIES'),
			'index.php?option=com_jtodo&view=categories',
			$vName == 'categories'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_JTODO_SUBMENU_todos'),
			'index.php?option=com_jtodo&view=todos',
			$vName == 'todos'
		);
	}
}    