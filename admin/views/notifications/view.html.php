<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/notifications/view.html.php               //
// @implements  : Class jTODOViewNotifications                          //
// @description : Main-entry for the notifications-Listview             //
// Version      : 2.1.0                                                 //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die( 'Restricted Access' );
jimport('joomla.application.component.view');

class jTODOViewNotifications extends JViewLegacy
{
    function display($tpl = null)
    {
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

		// Preprocess the list of items to find ordering divisions.
		foreach ($this->items as &$item)
		{
			$item->order_up = true;
			$item->order_dn = true;
		}

        // Add Toolbat to View
		jToDoHelper::addSubmenu('notifications');
		$this-> addToolbar();
		$this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    function addToolbar()
    {
        // Set Headline
        JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_NOTIFICATIONS_MANAGER' ) );
        // Toolbar-Buttons
        JToolBarHelper::addNew('notification.add');
        JToolBarHelper::editList('notification.edit');
        JToolBarHelper::deleteList('COM_JTODO_DELETE_QUESTION', 'notifications.delete');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('notifications.publish');
        JToolBarHelper::unpublishList('notifications.unpublish');

		JHtmlSidebar::setAction('index.php?option=com_jtodo');

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);

		JHtmlSidebar::addFilter(
			JText::_('COM_JTODO_CHOOSE_CATEGORY'),
			'filter_category',
			JHtml::_('select.options', JFormFieldCategories::getOptions(), 'value', 'text', $this->state->get('filter.category'), true)
		);


    }

		protected function getSortFields()
	{
		return array(
			'noti.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'category' => JText::_('COM_JTODO_CATEGORY'),
			'name' => JText::_('COM_JTODO_REALNAME'),
   			'username' => JText::_('COM_JTODO_JNAME'),
			'email' => JText::_('COM_JTODO_EMAIL'),
			'noti.published' => JText::_('JSTATUS'),
			'noti.id' => JText::_('JGRID_HEADING_ID')
		);
	}

}
?>