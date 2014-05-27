<?php 
// *************************************************************************//
// Project      : jTODO for Joomla                                          //
// @package     : com_jtodo                                                 //
// @file        : /admin/controllers/todo.php                               //
// @implements  : Class jTODOControllerToDo                                 //
// @description : Controller for editing a single ToDo                      //
// Version      : 1.1.4                                                     //
// *************************************************************************//

// No direct access to this file 
defined('_JEXEC') or die('Restricted access');  
 
// import Joomla controllerform library 
jimport('joomla.application.component.controllerform');  
 
// Event Controller  
class jTODOControllerToDo extends JControllerForm 
{  

	public function batch()
	{
		// echo 'Controller: ToDo -> Stapelverarbeitung';
		// die;
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model	= $this->getModel('todo', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_jtodo&view=todos', false));

		return parent::batch($model);		
	}	

} 
?>