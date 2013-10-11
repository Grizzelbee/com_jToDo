<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jTODO                                             //
// @file        : admin/tables/todo.php                                 //
// @implements  : Class jTODOTableToDo                                  //
// @description : Table-Structure-Class of the ToDo-Table               //
// Version      : 1.0.0                                                 //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die('Restricted access');

class jTODOTableToDo extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(& $_db) {
		parent::__construct('#__jtodo_todos', 'id', $_db);
	}
}

?>
   