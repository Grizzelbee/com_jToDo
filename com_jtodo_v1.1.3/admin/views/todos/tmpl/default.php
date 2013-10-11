<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todos/tmpl/default.php                    //
// @implements  :                                                       //
// @description : Template for the ToDos-List-View                      //
// Version      : 1.1.3                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC')or die('Restricted access'); 
JHTML::_('behavior.tooltip'); 
JHTML::_('behavior.multiselect'); 
require(JPATH_COMPONENT.DS.'views'.DS.'navigation.inc.php');
?> 
<form action="<?php echo JRoute::_('index.php?option=com_jtodo&view=todos'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
    <div id="filter-bar" class="btn-toolbar">
		<div class="filter-search fltlft btn-group">
			<label class="filter-search-lbl pull-left" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_JTODO_ITEMS_SEARCH_FILTER'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
        <div class="filter-select fltrt btn-group">
            <select name="filter_project" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_JTODO_CHOOSE_PROJECT');?></option>
                <?php echo JHtml::_('select.options', JFormFieldProjects::getOptions(), 'value', 'text', $this->state->get('filter.projects'));?>
            </select>
            <select name="filter_category" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_JTODO_CHOOSE_CATEGORY');?></option>
                <?php echo JHtml::_('select.options', JFormFieldCategories::getOptions(), 'value', 'text', $this->state->get('filter.category'));?>
            </select>
            <select name="filter_state" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
                <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true); ?>
            </select>
            <select name="filter_status" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_JTODO_CHOOSE_STATUS');?></option>
                <?php echo JHtml::_('select.options', JFormFieldStatus::getOptions(), 'value', 'text', $this->state->get('filter.status'), true);?>
            </select>
        </div>
    </div>
    </fieldset>
    <div class="clr"> </div>
    
    <table class="adminlist">
        <thead>
            <tr>
                <th width="5">
                    <?php echo JText::_( '#' ); ?>
                </th>
                <th width="20">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
                </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_TODO', 'name', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="10%" align="center">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_TARGETDATE', 'targetdate', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="5%" align="center">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_PUBLISHED', 'published', $this->listDirn, $this->listOrder); ?>
               </th>
                <th width="5%" align="center">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_STATUS', 'status', $this->listDirn, $this->listOrder); ?>
               </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_PROJECT', 'project', $this->listDirn, $this->listOrder); ?>
                </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_CATEGORY', 'category', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="5">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_ID', 'id', $this->listDirn, $this->listOrder); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php  
                foreach($this->items as $i => $item) : 
                $link           = JRoute::_( 'index.php?option=com_jtodo&task=todo.edit&cid[]='.(int)$item->id );
                $singleItemLink = JRoute::_( 'index.php?option=com_jtodo&task=todo.edit&id='.(int)$item->id );
                ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td><?php echo sprintf('%02d', $this->pagination->limitstart+$i+1); ?></td>
                        <td><?php echo JHTML::_('grid.id', $i, $item->id); ?></td>
                        <td><a href="<?php echo $singleItemLink; ?>"><?php echo $item->name; ?></a></td>
                        <td align="center"><?php echo JHTML::_('date', $item->targetdate,   JText::_('DATE_FORMAT1'), 'UTC');?></td>
                        <td align="center"><?php echo JHTML::_('jgrid.published', $item->published, $i, 'todos.' ); ?></td>
                        <td align="center"><?php echo JHTML::_('jgrid.published', $item->status, $i, 'todos.setStatus_'); ?></td>
                        <td align="center"><?php echo $item->project;?></td>
                        <td align="center"><?php echo $item->category;?></td>
                        <td><?php echo $item->id; ?></td>
                    </tr>
                <?php 
                endforeach; 
            ?>
        <tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    <?php echo $this->pagination->getListFooter() 
                               .'<br>'
                               . $this->pagination->getResultsCounter(); 
                    ?>
                    <p>
                    <center>jToDo  v<?php echo _jTODO_VERSION; ?></center>
                    <center>Copyright &copy; 2012-<?php echo date('Y', time() )?> by Hanjo Hingsen, Webmaster of  <a href="http://www.treu-zu-kaarst.de">http://www.treu-zu-kaarst.de</a>, All Rights reserved</center>
                </td>
            </tr>
        </tfoot>            
    </table> 
    <div>
        <input type="hidden" name="task"             value = "" />
        <input type="hidden" name="boxchecked"       value = "0" />
        <input type="hidden" name="filter_order"     value = "<?php echo $this->listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value = "<?php echo $this->listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>