<?php
// *********************************************************************//
// Project      : jToDo for Joomla                                      //
// @package     : com_jToDo                                             //
// @file        : admin/jtodo.php (Joomla-Entry-File)                   //
// @implements  :                                                       //
// @description : Main-Backend-Entry-File for the jToDo-Component       //
// Version      : 1.0.9                                                 //
// *********************************************************************//

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
define('_jTODO_VERSION','1.0.9');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by Games
$controller = JController::getInstance('jTODO');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
?>