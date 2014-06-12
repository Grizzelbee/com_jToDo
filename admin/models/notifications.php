<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/models/notifications.php                        //
// @implements  : Class jTODOModelNotification                          //
// @description : Model for the DB-Manipulation of the                  //
//                jToDo-Notifications-List                              //
// Version      : 2.1.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' );
jimport( 'joomla.application.component.modellist' );

class jTODOModelNotifications extends JModelList
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
            $config['filter_fields'] = array('id', 'name', 'category', 'published', 'ordering');
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
        $query->select('noti.id, fk_category, fk_juserid, joomla.name, joomla.username, joomla.email, cat.name as category, noti.published, noti.ordering');
        // From the Notifications table
        $query->from('#__jtodo_notifications  as noti');
        $query->join('', '#__jtodo_categories as cat    on (noti.fk_category = cat.id)');
        $query->join('', '#__users            as joomla on (noti.fk_juserid  = joomla.id)');

        //Search
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%'.$db->escape($search, true).'%', false);
            $query->where('(joomla.name LIKE '.$search.' or joomla.username LIKE '.$search.' or joomla.email LIKE '.$search.' or cat.name LIKE '.$search.')');
        }

        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('published = '.(int) $published);
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
            $orderCol  = 'ordering';
            $orderDirn = 'ASC';
        }
        $query->order($db->escape($orderCol.' '.$orderDirn));

        return $query;
	}


    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $state);

        $category = $this->getUserStateFromRequest($this->context.'.filter.category', 'filter_category');
        $this->setState('filter.category', $category);

        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published');
        $this->setState('filter.published', $published);

        // List state information.
        parent::populateState('ordering', 'ASC');
    }


}
?>