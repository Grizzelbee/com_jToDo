<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todos/tmpl/default_batch.php              //
// @implements  :                                                       //
// @description : Template for the ToDos-List-View-ReDate-Popup         //
// Version      : 2.0.0                                                 //
// *********************************************************************//
defined('_JEXEC') or die;

$published = $this->state->get('filter.published');
?>
<div class="modal hide fade" id="collapseModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&#215;</button>
		<h3><?php echo JText::_('COM_JTODO_BATCH_OPTIONS'); ?></h3>
	</div>
	<div class="modal-body modal-batch">
		<p><?php echo JText::_('COM_JTODO_BATCH_TIP'); ?></p>
		<div class="row-fluid">
			<?php if ($published >= 0) : ?>
			<div class="controls">
				<div class="input-append">
				<?php echo JHtml::_('calendar', $value, 'new_targetdate', 'new_targetdate_calendar'); ?>	
				</div>			
			</div>			
			
			<?php endif; ?>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" type="button" onclick="document.id('batch-category-id').value='';document.id('batch-client-id').value='';document.id('batch-language-id').value=''" data-dismiss="modal">
			<?php echo JText::_('JCANCEL'); ?>
		</button>
		<button class="btn btn-primary" type="submit" onclick="if (document.adminForm.boxchecked.value==0){alert('<?php echo JTEXT::_('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST');?>');}else{ Joomla.submitbutton('todos.redate')}">
			<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
		</button>
	</div>
</div>
