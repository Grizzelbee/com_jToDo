<?php 
// *********************************************************************//
// Project      : jToDo for Joomla                                      //
// @package     : com_jToDo                                             //
// @file        : admin/views/navigation.inc.php                        //
// @implements  :                                                       //
// @description : Code-Snippet for the Menu-Toolbar which is used in    //
//                in the List-Views                                     //
// Version      : 1.0.8                                                //
// *********************************************************************//
// get document to add scripts or StyleSheets
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'media/com_jtodo/css/views.css');
$viewName = $this->getName();
?>
<div id="navcontainer">
    <ul id="navlist">
        <li <?php if ($viewName == 'projects') echo ' id="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_jtodo&view=projects'); ?>"><?php echo JText::_( 'COM_JTODO_PROJECTS' ); ?></a></li>
        <li <?php if ($viewName == 'categories') echo ' id="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_jtodo&view=categories'); ?>"><?php echo JText::_( 'COM_JTODO_CATEGORIES' ); ?></a></li>
        <li<?php if ($viewName == 'todos') echo ' id="active"';?>><a href="<?php echo JRoute::_('index.php?option=com_jtodo&view=todos'); ?>"><?php echo JText::_( 'COM_JTODO_TODOS' ); ?></a></li>
    </ul>
</div>