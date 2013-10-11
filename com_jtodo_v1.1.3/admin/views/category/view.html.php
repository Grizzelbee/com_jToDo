<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/category/view.html.php                    //
// @implements  : Class jTODOViewCATEGORY                               //
// @description : Main-entry for the single category-View               //
// Version      : 1.1.3                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted Access!');
jimport( 'joomla.application.component.view' );

class jTODOViewCategory extends JViewLegacy
{
	/**
	 * display method of Hello view
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
		JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_CATEGORIES_MANAGER' ).': <small>[ ' . $text.' ]</small>' );
		JToolBarHelper::apply('category.apply');
        JToolBarHelper::save2new('category.save2new');
		JToolBarHelper::save('category.save');
		JToolBarHelper::cancel('category.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
    
    
}
