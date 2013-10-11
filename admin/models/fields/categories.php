<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jTODO                                             //
// @file        : admin/models/fields/categories.php                    //
// @implements  : Class JFormFieldCategories                            //
// @description : Field to select one of the categories in jToDo        //
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
class JFormFieldCategories extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Categories';
 
	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		$options = array();

        $db		= JFactory::getDbo();
        $query	= $db->getQuery(true);

        $query->select('id AS value, name AS text');
        $query->from('#__jtodo_categories');
        $query->order('name ASC');
     
        // Get the options.
        $db->setQuery($query);
     
        $options = $db->loadObjectList();

		return $options;
	}
}