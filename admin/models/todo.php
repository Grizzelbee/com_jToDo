<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/models/todo.php                                 //
// @implements  : Class jTODOModelTodo                                  //
// @description : Model for the DB-Manipulation of a single             //
//                jTODO-ToDo; not for the list                          //
// Version      : 2.0.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' );
jimport( 'joomla.application.component.modeladmin' );

class jTODOModelTodo extends JModelAdmin
{
    /**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
    public function getTable($type = 'todo', $prefix = 'jTODOTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
        $form = $this->loadForm(
                'com_jtodo.todo',
                'todo',
                 array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }

        return $form;
	}


    /**
     * Method to get the data that should be injected in the form.
     *
     * @return      mixed   The data for the form.
     * @since       1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_jtodo.edit.todo.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
            if ($data->id == 0)
            {
                $data->inserted = date('Y-m-d', time());
            }
            $data->updated  = date('Y-m-d', time());
        }
        return $data;
    }


	function getCategories()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_categories ))
		{
			$query = 'SELECT id, name, FROM #__jtodo_categories where published = 1';
			$this->_categories = $this->_getList( $query );
		}
		return $this->_categories;
	}

    public function setItemDoneStatus($cid, $newStatus)
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->update('#__jtodo_todos');
        $query->set('status = '.(int)$newStatus);
        $query->set('updated = NULL');
        $query->set('done_at = NULL');
        $query->set('done_by_juserid = NULL');
        $query->WHERE('id in ('.implode(',', $cid).');');

        $db->setQuery($query);
        $data = $db->Query();

        if ( $db->getAffectedRows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function ReDateToDos($cid, $newDate)
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->update('#__jtodo_todos');
        $query->set('targetdate = \''.JFactory::getDate($newDate, 'UTC')->toSQL().'\'');
        $query->set('updated = CURRENT_DATE');
        $query->WHERE('id in ('.implode(',', $cid).');');

        $db->setQuery($query);
        $data = $db->Query();

        if ( $db->getAffectedRows() >= 1) {
            return true;
        } else {
            return false;
        }
    }



}
?>