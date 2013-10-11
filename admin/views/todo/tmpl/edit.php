<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todo/tmpl/edit.php                        //
// @implements  :                                                       //
// @description : Template for the single Todo Edit-View                //
// Version      : 1.0.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access'); 

JHtml::_('behavior.tooltip'); 
$url = 'index.php?option=com_jtodo&layout=edit&id='; 
?> 
<form action="<?php echo JRoute::_($url.(int) $this->item->id); ?>"  	  
      method="post" name="adminForm" id="todo-form">      
    <fieldset class="adminform">  
        <legend><?php echo JText::_('COM_JTODO_DETAILS'); ?></legend>         
        <ul class="adminformlist"> 			
            <?php foreach($this->form->getFieldset() as $field): ?>             
            <li><?php echo $field->label;echo $field->input;?></li> 			
            <?php endforeach; ?>         
        </ul>     
    </fieldset>
    <div>         
        <input type="hidden" name="task" value="jtodo.todo" />         
        <?php echo JHtml::_('form.token'); ?>     
    </div> 
</form>