<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/categories/view.html.php                  //
// @implements  : Class jTODOViewCategories                             //
// @description : Main-entry for the categories-Listview                //
// Version      : 1.1.4                                                 //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die( 'Restricted Access' );
jimport('joomla.application.component.view');

class jTODOViewCategories extends JViewLegacy
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
		jToDoHelper::addSubmenu('categories');
		$this-> addToolbar();
		$this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    function addToolbar()
    {
        // Set Headline
        JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_CATEGORIES_MANAGER' ) );
        // Toolbar-Buttons
        JToolBarHelper::addNew('category.add');
        JToolBarHelper::editList('category.edit');
        JToolBarHelper::deleteList('COM_JTODO_DELETE_QUESTION', 'categories.delete');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('categories.publish');
        JToolBarHelper::unpublishList('categories.unpublish');

		JHtmlSidebar::setAction('index.php?option=com_jtodo');

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);

    }

		protected function getSortFields()
	{
		return array(
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

}
?>