<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/models/categories.php                           //
// @implements  : Class jTODOModelCategories                            //
// @description : Model for the DB-Manipulation of the                  //
//                jToDo-Categories-List                                 //
// Version      : 1.0.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' ); 
jimport( 'joomla.application.component.modellist' );

class jTODOModelCategories extends JModelList
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
            $config['filter_fields'] = array('id', 'name', 'published', 'ordering');
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
        $query->select('id, name, published, ordering');
        // From the Categories table
        $query->from('#__jtodo_categories');

        //Search
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%'.$db->getEscaped($search, true).'%', false);
            $query->where('(name LIKE '.$search.')');
        }

        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('published = '.(int) $published);
        } else if ($published == '') {
            $query->where('(published IN (0, 1))');
        }

        //Add the list ordering clause.
        $orderCol  = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if (empty($orderCol)){
            $orderCol  = 'ordering';
            $orderDirn = 'asc';
        }
        $query->order($db->getEscaped($orderCol.' '.$orderDirn));
        
        return $query;
	}
   

    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);
     
        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $state);

        // List state information.
        parent::populateState('ordering', 'asc');
    }

    
}
?>