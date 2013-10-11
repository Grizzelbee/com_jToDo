<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/views/jtodo/view.html.php                        //
// @implements  : Class jTODOViewjTODO                                  //
// @description : Entry-File for the jToDo-Standard-View                //
// Version      : 1.1.3                                                 //
// *********************************************************************//

defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view'); 

class jTODOViewjTODO extends JViewLegacy
{ 
    
    function display($tpl = null) 
    { 
        $app              = JFactory::getApplication();
        // Get the parameters
		$this->params     = $app->getParams();
        $this->model      = $this->getModel(); 
        $ProjectId        = JRequest::getInt('fk_project');
        $this->project    = $this->model->getProjectById($ProjectId);
        $this->categories = $this->model->getNonEmptyCategoriesByProject($ProjectId);   
        $this->todos      = $this->model->getTodosByProject($ProjectId); 
        $this->menu       = $app->getMenu();

        parent::display($tpl); 
    } 
    
    function getStatusImage($todoStatus, $link, $isGuest=false)
    {
        if ($todoStatus) 
        {
            $imagePath = $this->baseurl . '/media/com_jtodo/images/stateindicators/' . $this->params->get('tick_image');
            $imageHint = "COM_JTODO_DONE";
        }else{
            $imagePath = $this->baseurl . '/media/com_jtodo/images/stateindicators/' . $this->params->get('cross_image');
            $imageHint = "COM_JTODO_NOT_DONE";
        };
        
        
        if ($isGuest)
        {
            $image = '<img src="'.$imagePath.'" alt="" title=""/>';
            
            return $image;
        } else {
            $image     = '<img src="'.$imagePath.'" alt="'.JTEXT::_($imageHint).'" title="'.JTEXT::_($imageHint).'"/>';
            $imageLink = '<a class="jgrid" href="'.$link.'")" title="'.JText::_($imageHint).'">'.$image. '</a>';
            
            return $imageLink; 
        }
    }
    
    function setLastVisitTimestamp($aUser, $aDate)
    {
        // LastVisit Timestamp für den übergebenen User in die Datenbank schreiben
        $visits = null;
        // letzten Besuch der Seite ermitteln
        $visits = $this->model->getLastUserVisitDate($aUser->id, $this->project->id);
        if (isset($visits->id)) {
            // User war schon mal hier
            $user_lastvisit = $visits->lastvisitdate; 
            $visits->lastvisitdate = $aDate;
            $this->model->setLastUserVisitDate(false, $visits);
        }else {
            // User war noch nie hier
            $user_lastvisit = $aDate;
            $visits = (object) array("id"=>null, "juserid"=>$aUser->id, "lastVisitDate"=>$aDate, "fk_project"=>$this->project->id);
            $this->model->setLastUserVisitDate(True, $visits);    
        };
    }
    
} 
?>