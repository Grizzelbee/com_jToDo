<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/categories/view.html.php                  //
// @implements  : Class jTODOViewCategories                             //
// @description : Main-entry for the categories-Listview                //
// Version      : 1.0.0                                                 //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view'); 

class jTODOViewCategories extends JView 
{ 
    function display($tpl = null) 
    {
        // Add Toolbat to View
        $this-> addToolbar();
        
        // Get data from the model
        $this->pagination = $this->get( 'Pagination' );
        $this->items	  = $this->get( 'Items' );
        $this->state      = $this->get( 'State' );

        // Get order state
        $this->listOrder = $this->escape($this->state->get( 'list.ordering'  ));
        $this->listDirn  = $this->escape($this->state->get( 'list.direction' ));
        $this->saveorder = $this->listOrder == 'ordering';
        
        // include custom fields
        require_once JPATH_COMPONENT .'/models/fields/categories.php';
        
        parent::display($tpl); 
    } 

    function addToolbar()
    {
        // Set Headline
        JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_CATEGORIES_MANAGER' ) );
        // Toolbar-Buttons
        JToolBarHelper::addNewX('category.add');
        JToolBarHelper::editListX('category.edit');
        JToolBarHelper::deleteList('COM_JTODO_DELETE_QUESTION', 'categories.delete');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('categories.publish');
        JToolBarHelper::unpublishList('categories.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::Preferences('COM_JTODO');    

    }
} 
?>