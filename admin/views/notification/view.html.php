<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/notification/view.html.php                //
// @implements  : Class jTODOViewNotification                           //
// @description : Main-entry for the single notification-View           //
// Version      : 2.1.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted Access!');
jimport( 'joomla.application.component.view' );

class jTODOViewNotification extends JViewLegacy
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
		JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_NOTIFICATIONS_MANAGER' ).': <small>[ ' . $text.' ]</small>' );
		JToolBarHelper::apply('notification.apply');
        JToolBarHelper::save2new('notification.save2new');
		JToolBarHelper::save('notification.save');
		JToolBarHelper::cancel('notification.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }


}
