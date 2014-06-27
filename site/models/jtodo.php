<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/models/jtodo.php                                 //
// @implements  : Class jTODOModeljTODO                                 //
// @description : Model for the DB-Manipulation of the jToDo-List       //
// Version      : 2.1.3                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted Access' );

// Include dependancy of the main model
jimport('joomla.application.component.model');

class jTODOModeljTODO extends JModelLegacy
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

    function changeTodoStatus($itemId, $userID)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->update('#__jtodo_todos');
        $query->set('status = NOT status');
        $query->set('updated = CURRENT_DATE');
        $query->set('done_at = CURRENT_DATE');
        $query->set('done_by_juserid = '.(int)$userID);
        $query->WHERE('id = ' . (int)$itemId);
        $db->setQuery($query);
        $data = $db->Query();

        if ( $db->getAffectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function getNotifyData($itemId)
    {
    	$db    = JFactory::getDBO();
    	$query = $db->getQuery(true);
    	$query->select('joomla.username, joomla.email, cat.name as category, todo.status, todo.name as todoname, pro.name as project');
    	$query->from('#__jtodo_todos             as todo   ');
    	$query->join('', '#__jtodo_categories    as cat     on (todo.fk_category = cat.id)');
    	$query->join('', '#__jtodo_projects      as pro     on (todo.fk_project  = pro.id)');
    	$query->join('', '#__jtodo_notifications as noti    on (noti.fk_category = cat.id)');
    	$query->join('', '#__users               as joomla  on (noti.fk_juserid  = joomla.id)');
    	$query->WHERE('noti.published=1');
    	$query->WHERE('todo.id = ' . (int)$itemId . ';');

    	$db->setQuery($query);
    	$data = $db->loadObjectList();

    	return $data;
    }

    public function sendMailNotification($receipients)
    {
    	$mailer      = JFactory::getMailer();
    	$config      = JFactory::getConfig();
    	$sender      = array( $config->get( 'mailfrom', 'Name@Example.com' ), $config->get( 'fromname' , 'ExampleName') );
    	$mailer->setSender($sender);
    	$mailer->isHTML(True);
    	$mailer->Encoding = 'base64';
    	$mailer->setSubject(JText::_('COM_JTODO_MAIL_SUBJECT'));

    	$textmarken = array("[TODO]", "[PROJECT]", "[DONE_STATE]", "[SENDER]", "[HOMEPAGE]");
    	$daten      = array($receipients[0]->todoname, $receipients[0]->project, $receipients[0]->status=0?JText::_('COM_JTODO_NOT_DONE'):JText::_('COM_JTODO_DONE'), $config->get( 'fromname', 'ExampleName' ), '<a href="'.JURI::current().'">Homepage</a>');
    	$body = str_replace( $textmarken, $daten, JText::_('COM_JTODO_MAILBODY_EDITED') ) ;

    	foreach($receipients as $receipient):
	    	if ($receipient->email == '' )
	    	{
	    	   continue;
	    	}
	    	$successful = 0;
    		$mailer->ClearAllRecipients();
    		$mailer->addRecipient( $receipient->email );

	    	$mailbody = str_replace('[NAME]', $receipient->username, $body);
    		$mailer->setBody($mailbody);

       	    $mailer->Send();
    	endforeach;
	}

    public function notifyUsers($itemId)
    {
    	$data  = $this->getNotifyData($itemId);
    	$this->sendMailNotification($data);
    }


    function getLastUserVisitDate( $userid , $projectid)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__jtodo_visits');
        $query->where('juserid = '.(int)$userid);
        $query->where('fk_project = '.(int)$projectid);

        $db->setQuery( $query );
        $lastVisitDate = $db->loadObject();

        if (empty($lastVisitDate))
        {
            $lastVisitDate = (object)array('id' => 0, 'lastvisitdate' => '2000-01-01');
        }

        return $lastVisitDate;
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