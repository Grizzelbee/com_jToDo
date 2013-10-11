<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/views/jtodo/tmpl/default.php                     //
// @implements  :                                                       //
// @description : Entry-File for the jToDo-Standard-View                //
// Version      : 1.1.2                                                 //
// *********************************************************************//

//Aufruf nur durch Joomla! zulassen
defined('_JEXEC')or die('Restricted access'); 
// get document to add scripts or StyleSheets
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jtodo/assets/css/jtodo.css');
$menu       = &JSite::getMenu();
$activeitem = $menu->getActive();
$parentitem = $menu->getItem($activeitem->tree[0]);
if ($parentitem == $activeitem)
{
    $componentheading_title = $activeitem->title;
} else {
   $componentheading_title = $parentitem->title .' :: '.$activeitem->title;
}
?> 
<div class="componentheading"><b><?php echo $componentheading_title; ?></b></div>
<div style="float: left; width:100%; vertical-align:middle; padding:0.3em;">
    <?php
    if ( $this->params->get('show_logo') == 1) 
    {
    ?>
        <img style="float:right;" src="<?php echo $this->params->get('logo_image'); ?>" alt="" title=""/>
    <?php
    }
    if ( $this->params->get('show_page_heading') == 1) 
    {
    ?>
        <h1 style="padding:2em;"><?php echo $this->params->get('page_heading'); ?></h1>
    <?php
    }    
    ?>
</div>
<p style="clear:both;"></p>
<p><?php echo $this->project->preamble; ?></p>
<div class="page_body"> 
<?php  
    $user    = JFactory::getUser(); 
  	$isGuest = $user->guest;
    $language = $user->getParam('language', 'de-DE');
	$now = date('Y-m-d', time() );
    
    // Nur Besuche von registrierten Usern merken - von Gästen ergibt das keinen Sinn
    if (!$isGuest){
        $lastUserVisit = $this->model->getLastUserVisitDate($user->id, $this->project->id)->lastvisitdate;
        $this->setLastVisitTimestamp($user, $now);
    };
 ?>    
    
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="siteForm">

    <?php
    foreach($this->categories as $i => $category) : 
        echo "<h2 align=\"left\">$category->name</h2>"
    ?>
        <table class="adminlist">
            <thead>
                <tr>
                    <th width="5%" align="left">
                        <?php // echo JText::_('COM_JTODO_STATUS'); ?>
                   </th>
                    <th  width="90%" align="left">
                        <?php echo JText::_( 'COM_JTODO_TODO' ); ?>
                    </th>
                    <th width="5%" align="center">
                        <?php echo JText::_('COM_JTODO_TARGETDATE'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php  
                foreach($this->todos as $i => $item) : 
                if ($category->id == $item->fk_category) {
                    $link = JRoute::_( 'index.php?option=com_jtodo&task=jtodo.submit&id='.(int)$item->id.'&uid='.(int)$user->id );
                    $updateID = '';
                    if (!$isGuest) 
                    {   
                        if ($lastUserVisit <= $item->inserted)
                        {
                            $updateID = 'new';
                        } else {
                            if ($lastUserVisit <= $item->updated) {
                                $updateID = 'update';
                            }
                        }
                    }
                    ?>
                        <tr  class="HiliteMe_future">
                            <td align="left"><?php echo $this->getStatusImage( $item->status, $link, $isGuest ); ?></td>
                            <td id="<?php echo $updateID; ?>" ><?php echo $item->name; ?></td>
                            <td align="center"><?php echo JHTML::_('date', $item->targetdate,   JText::_('COM_JTODO_DATE_FORMAT_1'), 'UTC');?></td>
                        </tr>
                    <?php 
                }
                endforeach; 
                ?>
            <tbody>
        </table> 
    <?php 
    endforeach; 
    ?>
    <div>
        <input type="hidden" name="task"             value = "" />
        <input type="hidden" name="boxchecked"       value = "0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>

<br><br>        
<center>jToDo (ToDo-List for Joomla) v<?php echo _JTODO_VERSION; ?></center>
<center>Copyright &copy; <?php echo date('Y', time() )?> by Hanjo Hingsen, Webmaster of  <a href="http://www.treu-zu-kaarst.de">http://www.treu-zu-kaarst.de</a>, All Rights reserved</center>
</div>