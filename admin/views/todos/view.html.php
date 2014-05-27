<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todos/view.html.php                       //
// @implements  : Class jToDoViewTodos                                  //
// @description : Main-entry for the Todos-ListView                     //
// Version      : 1.1.4                                                 //
// *********************************************************************//

// no direct access to this file
defined('_JEXEC') or die( 'Restricted Access' );
jimport('joomla.application.component.view');

class jTODOViewTodos extends JViewLegacy
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

        // include custom fields
        require_once JPATH_COMPONENT .'/models/fields/projects.php';
        require_once JPATH_COMPONENT .'/models/fields/categories.php';
        require_once JPATH_COMPONENT .'/models/fields/status.php';

        // Add Toolbat to View
		jToDoHelper::addSubmenu('todos');
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    function addToolbar()
    {
        // Set Headline
        JHtml::stylesheet('com_jtodo/views.css', array(), true, false, false);
        JToolBarHelper::title(   JText::_( 'COM_JTODO_HEAD_TODOS_MANAGER' ), 'todo' );
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
        // Toolbar-Buttons
        JToolBarHelper::addNew('todo.add');
        JToolBarHelper::editList('todo.edit');
        JToolBarHelper::deleteList('COM_JTODO_DELETE_QUESTION', 'todos.delete');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('todos.publish');
        JToolBarHelper::unpublishList('todos.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::custom('todos.setStatus_publish'  , 'publish',   'publish'  , 'COM_JTODO_SETDONE');
        JToolBarHelper::custom('todos.setStatus_unpublish', 'unpublish', 'unpublish', 'COM_JTODO_SETUNDONE');

        // Add a batch button
      	JHtml::_('bootstrap.modal', 'collapseModal');
       	$title = JText::_('JTOOLBAR_BATCH');

       	// Instantiate a new JLayoutFile instance and render the batch button
       	$layout = new JLayoutFile('joomla.toolbar.batch');

       	$dhtml = $layout->render(array('title' => $title));
       	$bar->appendButton('Custom', $dhtml, 'batch');


        JHtmlSidebar::setAction('index.php?option=com_jtodo');

        JHtmlSidebar::addFilter(
        JText::_('JOPTION_SELECT_PUBLISHED'),
        'filter_published',
        JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
        );

		JHtmlSidebar::addFilter(
			JText::_('COM_JTODO_CHOOSE_PROJECT'),
			'filter_project',
			JHtml::_('select.options', JFormFieldProjects::getOptions(), 'value', 'text', $this->state->get('filter.project'), true)
		);

		JHtmlSidebar::addFilter(
			JText::_('COM_JTODO_CHOOSE_CATEGORY'),
			'filter_category',
			JHtml::_('select.options', JFormFieldCategories::getOptions(), 'value', 'text', $this->state->get('filter.category'), true)
		);

		JHtmlSidebar::addFilter(
			JText::_('COM_JTODO_CHOOSE_STATUS'),
			'filter_status',
			JHtml::_('select.options', JFormFieldStatus::getOptions(), 'value', 'text', $this->state->get('filter.status'), true)
		);

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

    protected function getSortFields()
    {
    	return array(
    			'ordering' => JText::_('JGRID_HEADING_ORDERING'),
    			'category' => JText::_('COM_JTODO_CATEGORY'),
    			'project' => JText::_('COM_JTODO_PROJECT'),
    			'published' => JText::_('COM_JTODO_PUBLISHED'),
    			'status' => JText::_('COM_JTODO_STATUS'),
    			'targetdate' => JText::_('COM_JTODO_TARGETDATE')
    	);
    }


}
?>