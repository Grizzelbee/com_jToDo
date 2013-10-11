<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/controllers/jtodo.php                            //
// @implements  : jTODOControllerjToDo                                  //
// @description : Special-Frontend-Controller-File                      //
//                for the jToDo-Component                               //
// Version      : 1.0.0                                                 //
// *********************************************************************//
 
// No direct access.
defined('_JEXEC') or die;
 
// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');
 
class jTODOControllerjTODO extends JControllerForm
{
 
        public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
        {
                return parent::getModel($name, $prefix, array('ignore_request' => false));
        }
 
        public function submit()
        {
            // Check for request forgeries.
            //JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

            // Initialise variables.
            $app    = JFactory::getApplication();
            $model  = $this->getModel('jtodo');

            // Get the data from the form POST
            $itemId = JRequest::getVar('id');
 
            // Now update the loaded data to the database via a function in the model
            $upditem = $model->changeTodoStatus($itemId);
 
            // check if ok and display appropriate message.  This can also have a redirect if desired.
            if (!$upditem) {
                JError::raiseWarning(1000, JText::_( 'COM_JTODO_STATUS_NOT_UPDATED' ) );
            }
            
            // Reload Page with changed content.
            $this->display();
            return true;
        }
 
}
?>