<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todos/tmpl/default_batch.php              //
// @implements  :                                                       //
// @description : Template for the ToDos-List-View-ReDate-Popup         //
// Version      : 2.1.2                                                 //
// *********************************************************************//
defined('_JEXEC') or die;

$published = $this->state->get('filter.published');
?>
<div class="modal hide fade" id="collapseModal">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&#215;</button>
      <h3><?php echo JText::_('COM_JTODO_BATCH_OPTIONS'); ?></h3>
   </div>
   <div class="modal-body">
      <p><?php echo JText::_('COM_JTODO_BATCH_TIP'); ?></p>
      <div class="control-group">
          <div class="controls">
              <?php echo JText::_('COM_JTODO_SET_NEW_CATEGORY'); ?><br/>
              <select name="new_category" class="inputbox" onchange="">
                  <option value="-99" selected><?php echo JText::_('COM_JTODO_DONT_CHANGE_CATEGORY');?></option>
                  <?php echo JHtml::_('select.options', JFormFieldCategories::getOptions(), 'value', 'text', -99 , true); ?>
              </select>
          </div>
      </div>
      <div class="control-group">
          <div class="controls">
              <?php echo JText::_('COM_JTODO_SET_NEW_DONE_STATE'); ?><br/>
              <select name="new_done_state" class="inputbox" onchange="">
                  <option value="-99" selected><?php echo JText::_('COM_JTODO_DONT_CHANGE_STATE');?></option>
                  <?php echo JHtml::_('select.options', JFormFieldStatus::getOptions(), 'value', 'text', -99 , true); ?>
              </select>
          </div>
      </div>
      <div class="control-group">
           <div class="controls">
                <?php echo JText::_('COM_JTODO_SET_NEW_PUBLISHED_STATE'); ?><br/>
                <select name="new_published_state" class="inputbox" onchange="">
                    <option value="-99" selected ><?php echo JText::_('COM_JTODO_DONT_CHANGE_STATE');?></option>
                    <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', -99, true); ?>
                </select>
            </div>
       </div>
      <div class="control-group">
         <div class="controls">
                <?php echo JText::_('COM_JTODO_SET_NEW_TARGETDATE'); ?><br/>
                <?php echo JHtml::_('calendar', '', 'new_targetdate', 'new_targetdate_calendar'); ?>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button class="btn" type="button" onclick="document.id('batch-category-id').value='';document.id('batch-client-id').value='';document.id('batch-language-id').value=''" data-dismiss="modal">
         <?php echo JText::_('JCANCEL'); ?>
      </button>
      <button class="btn btn-primary" type="submit" onclick="if (document.adminForm.boxchecked.value==0){alert('<?php echo JTEXT::_('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST');?>');}else{ Joomla.submitbutton('todos.batch')}">
         <?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
      </button>
   </div>
</div>
