<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/Project/view.html.php                     //
// @implements  : Class jTODOViewProject                                //
// @description : Main-entry for the single Project-View                //
// Version      : 1.1.3                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted Access!');
jimport( 'joomla.application.component.view' );

class jTODOViewProject extends JViewLegacy
{
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
		JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_PROJECTS_MANAGER' ).': <small>[ ' . $text.' ]</small>' );
		JToolBarHelper::apply('Project.apply');
        JToolBarHelper::save2new('Project.save2new');
		JToolBarHelper::save('Project.save');
		JToolBarHelper::cancel('Project.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
    
    
}
