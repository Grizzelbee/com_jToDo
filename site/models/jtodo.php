<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/models/jtodo.php                                 //
// @implements  : Class jTODOModeljTODO                                 //
// @description : Model for the DB-Manipulation of the jToDo-List       //
// Version      : 1.0.3                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' ); 

// Include dependancy of the main model
jimport('joomla.application.component.model');

class jTODOModeljTODO extends JModel 
{ 
    
    function getProjectById($ProjectId) 
    { 
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jtodo_projects');
        $query->where('published = 1');
        $query->where('id = '.(int)$ProjectId);        

        $db->setQuery( $query ); 
        $row = $db->loadObject(); 

        return $row; 
    } 

    function getCategories() 
    { 
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jtodo_categories');
        $query->where('published = 1');
        $query->order('ordering');

        $db->setQuery( $query ); 
        $rows = $db->loadObjectList(); 
        
        return $rows; 
    } 

    function getNonEmptyCategoriesByProject($ProjectId) 
    { 
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);

        $query->select('distinct cat.id, cat.name, cat.ordering');
        $query->from('#__jtodo_categories   AS cat');
        $query->join('', '#__jtodo_todos    AS todo ON (todo.fk_category=cat.id)');
        $query->join('', '#__jtodo_projects AS proj ON (todo.fk_project=proj.id)');
        $query->where('cat.published  = 1');
        $query->where('todo.published = 1');
        $query->where('proj.id = '.(int)$ProjectId);
        $query->order('cat.ordering');

        $db->setQuery( $query ); 
        $rows = $db->loadObjectList(); 
        
        return $rows; 
    } 



    function getTodos() 
    { 
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jtodo_todos');
        $query->where('published = 1');
        $query->order('fk_category');

        $db->setQuery( $query ); 
        $rows = $db->loadObjectList(); 

        return $rows; 
    } 

    function getTodosByProject($project) 
    { 
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jtodo_todos');
        $query->where('published = 1');
        $query->where('fk_project = '.(int)$project);
        $query->order('fk_category, targetdate');

        $db->setQuery( $query ); 
        $rows = $db->loadObjectList(); 

        return $rows; 
    } 

    function changeTodoStatus($itemId)
    {
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);

        $query->update('#__jtodo_todos');  
        $query->set('status = NOT status');  
        $query->WHERE('id = ' . $itemId);
        $db->setQuery($query);
        $data = $db->Query();
        
        if ( $db->getAffectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    function getLastUserVisitDate( $userid , $projectid) 
    { 
        $db = JFactory::getDBO(); 
        $query = $db->getQuery(true);
        //$query = "select * from #__jtodo_visits as visits where juserid = $userid"; 
        $query->select('*');
        $query->from('#__jtodo_visits');
        $query->where('juserid = '.(int)$userid);
        $query->where('fk_project = '.(int)$projectid);

        $db->setQuery( $query ); 
        $row = $db->loadObject(); 
        return $row; 
    } 

        
    function setLastUserVisitDate($isNewUser, $lastVisit) 
    { 
        $db = JFactory::getDBO(); 
        if ($isNewUser) {
            $db->insertObject('#__jtodo_visits', $lastVisit, 'id');
        } else {
            $db->updateObject('#__jtodo_visits', $lastVisit, 'id');
        };
    } 
} 
?>