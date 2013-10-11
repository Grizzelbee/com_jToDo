<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/views/jtodo/view.html.php                        //
// @implements  : Class jTODOViewjTODO                                  //
// @description : Entry-File for the jToDo-Standard-View                //
// Version      : 1.0.2                                                 //
// *********************************************************************//

defined('_JEXEC') or die( 'Restricted Access' ); 
jimport('joomla.application.component.view'); 

class jTODOViewjTODO extends JView
{ 
    
    function display($tpl = null) 
    { 
        $app              = JFactory::getApplication();
        // Get the parameters
		$this->params     = $app->getParams();
        $model            = $this->getModel(); 
        $ProjectId        = JRequest::getInt('fk_project');
        $this->project    = $model->getProjectById($ProjectId);
        $this->categories = $model->getNonEmptyCategoriesByProject($ProjectId);   
        $this->todos      = $model->getTodosByProject($ProjectId); 
        
        parent::display($tpl); 
    } 
    
    function getStatusImage($todoStatus, $link)
    {
        if ($todoStatus) 
        {
            $imagePath = 'media/com_jtodo/images/done.png';
            $imageHint = "COM_JTODO_DONE";
        }else{
            $imagePath = 'media/com_jtodo/images/todo.png';
            $imageHint = "COM_JTODO_NOT_DONE";
        };
        
        $image = '<img src="'.$this->baseurl.'/'.$imagePath.'" alt="'.JTEXT::_($imageHint).'" title="'.JTEXT::_($imageHint).'"/>';
        $imageLink = '<a class="jgrid" href="'.$link.'")" title="'.JText::_($imageHint).'">'.$image. '</a>';
        
        return $imageLink;
    }
    
} 
?>