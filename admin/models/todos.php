<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/models/todos.php                                //
// @implements  : Class jTODOModelTodos                                 //
// @description : Model for the DB-Manipulation of the                  //
//                jToDo-ToDos-List                                      //
// Version      : 1.1.4                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' );
jimport( 'joomla.application.component.modellist' );

class jTODOModelTodos extends JModelList
{
    /**
     * Constructor.
     *
     * @param array	An optional associative array of configuration settings.
     * @see		JController
     * @since	1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array('id', 'name', 'project', 'category', 'targetdate', 'status', 'published', 'todos.ordering');
        }
        parent::__construct($config);
    }

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	protected function getListQuery()
	{
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields
        $query->select('todos.id, todos.name, todos.published, targetdate, pro.name as project, cat.name as category, status, fk_category, todos.ordering');
        // From the Todos table
        $query->from('#__jtodo_todos      as todos');
        // join the categories table
        $query->join('', '#__jtodo_categories as cat on (todos.fk_category = cat.id)');
        $query->join('', '#__jtodo_projects   as pro on (todos.fk_project  = pro.id)');


        //Search
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%'.$db->escape($search, true).'%', false);
            $query->where('(todos.name LIKE '.$search.')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('todos.published = '.(int)$published);
        }

        // Filter by status-Field
        $status = $this->getState('filter.status');
        if (is_numeric($status)) {
            $query->where('status = '.(int)$status);
        }

        // Filter by Project
        $project = $this->getState('filter.project');
        if (is_numeric($project)) {
            $query->where('fk_project = '.(int) $project);
        }

        // Filter by Category
        $category = $this->getState('filter.category');
        if (is_numeric($category)) {
            $query->where('fk_category = '.(int) $category);
        }

        //Add the list ordering clause.
        $orderCol  = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if (empty($orderCol)){
            $orderCol  = 'todos.ordering';
            $orderDirn = 'ASC';
        }
        $query->order($db->escape($orderCol.' '.$orderDirn));

        return $query;
	}


    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state');
        $this->setState('filter.state', $state);

        $status = $this->getUserStateFromRequest($this->context.'.filter.status', 'filter_status');
        $this->setState('filter.status', $status);

        $project = $this->getUserStateFromRequest($this->context.'.filter.project', 'filter_project');
        $this->setState('filter.project', $project);

        $category = $this->getUserStateFromRequest($this->context.'.filter.category', 'filter_category');
        $this->setState('filter.category', $category);

        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published');
        $this->setState('filter.published', $published);

        // List state information.
        parent::populateState('todos.ordering', 'ASC');
    }


}
?>