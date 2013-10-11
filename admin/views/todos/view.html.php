<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todos/view.html.php                       //
// @implements  : Class jToDoViewTodos                                  //
// @description : Main-entry for the Todos-ListView                     //
// Version      : 1.0.6                                                 //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view'); 

class jTODOViewTodos extends JView 
{ 
    function display($tpl = null) 
    {
        // Add Toolbat to View
        $this->addToolbar();
        
        // Get data from the model
        $this->pagination = $this->get( 'Pagination' );
        $this->items	  = $this->get( 'Items' );
        $this->state      = $this->get( 'State' );

        // Get order state
        $this->listOrder = $this->escape($this->state->get( 'list.ordering'  ));
        $this->listDirn  = $this->escape($this->state->get( 'list.direction' ));
        
        // include custom fields
        require_once JPATH_COMPONENT .'/models/fields/projects.php';
        require_once JPATH_COMPONENT .'/models/fields/categories.php';
        require_once JPATH_COMPONENT .'/models/fields/status.php';
        
        parent::display($tpl); 
    } 

    function addToolbar()
    {
        // Set Headline
        JHtml::stylesheet('com_jtodo/views.css', array(), true, false, false);
        JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_TODOS_MANAGER' ), 'todo' );
        // Toolbar-Buttons
        JToolBarHelper::addNewX('todo.add');
        JToolBarHelper::editListX('todo.edit');
        JToolBarHelper::deleteList('COM_JTODO_DELETE_QUESTION', 'todos.delete');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('todos.publish');
        JToolBarHelper::unpublishList('todos.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::Preferences('COM_JTODO');    
    }
    
    function getStatusImage($StatusField, $positiveAction, $negativeAction, $rowID) 
    {
        $app      = JFactory::getApplication();
        $baseuri  = JURI::base();
        $template = $baseuri . 'templates/' . $app->getTemplate();
        
        $ausgabe = '<a class="jgrid" href="javascript:void(0);" onclick="return listItemTask(';
        if ($StatusField) { 
            $ausgabe = $ausgabe . ' \'cb'.$rowID.'\', \''.$negativeAction.'\')" title="'.JText::_('COM_JTODO_TAG_NOT_DONE').'"><img src="' . $template . '/images/admin/tick.png"';
        } else {
            $ausgabe = $ausgabe . ' \'cb'.$rowID.'\',\''.$positiveAction.'\')" title="'.JText::_('COM_JTODO_TAG_DONE').'"><img src="' . $template . '/images/admin/publish_x.png"';
        };
        $ausgabe = $ausgabe . 'border="0" alt="" /></a>';
        
        return $ausgabe;
    }

} 
?>