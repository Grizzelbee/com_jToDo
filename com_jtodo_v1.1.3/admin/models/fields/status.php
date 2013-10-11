<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jTODO                                             //
// @file        : admin/models/fields/status.php                        //
// @implements  : Class JFormFieldStatus                                //
// @description : Field to select the DONE-Status in jToDo              //
// Version      : 1.0.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
 
JFormHelper::loadFieldClass('list');
 
/**
 * categories Field
 *
 * @since		1.6
 */
class JFormFieldStatus extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Status';
 
	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		$options = array('COM_JTODO_STATUS_NOT_DONE', 'COM_JTODO_STATUS_DONE');

		return $options;
	}
}
?>