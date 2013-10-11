<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todo/view.html.php                        //
// @implements  : Class jToDoViewToDo                                   //
// @description : Main-entry for the single ToDo-View                   //
// Version      : 1.1.3                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted Access!');
jimport( 'joomla.application.component.view' );

class jTODOViewToDo extends JViewLegacy
{
	/**
	 * display method of ToDo view
	 * @return void
	 **/
	function display($tpl = null)
	{
		$this->form = $this->get('Form');
        $this->item = $this->get('Item');
		$isNew	    = ($this->item->id == 0);

        $this->AddToolBar($isNew);
        
		parent::display($tpl);
	}
    
    protected function AddToolBar($isNew)
    {
		$text = $isNew ? JText::_( 'COM_JTODO_NEW' ) : JText::_( 'COM_JTODO_EDIT' );
        JHtml::stylesheet('com_jtodo/views.css', array(), true, false, false);
		JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_TODO_MANAGER' ).': <small>[ ' . $text.' ]</small>' , 'todo');
		JToolBarHelper::apply('todo.apply');
        JToolBarHelper::save2new('todo.save2new');
		JToolBarHelper::save('todo.save');
		JToolBarHelper::cancel('todo.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
    
    
}
