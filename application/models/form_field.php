<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for Form Fields
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Form Field Model  
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Form_Field_Model extends ORM {
	
	/**
	 * Many-to-one relationship definition
	 * @var array
	 */
	protected $belongs_to = array('form');
	
	/**
	 * One-to-many relationship definition
	 * @var array
	 */
	protected $has_many = array('form_response', 'form_field_options');
	
	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'form_field';
	
	/**
	 * Validates and optionally saves a form field record from an array
	 *
	 * @param array $array Values to check
	 * @param bool $save Save the record when validation suceeds
	 * @return bool
	 */
	public function validate(array & $array, $save = FALSE)
	{
		// Setup validation
		$array = Validation::factory($array)
					->pre_filter('trim', TRUE)
					->add_rules('form_id','required', 'numeric', array('Form_Model', 'is_valid_form'))
					->add_rules('field_type','required', 'numeric')
					->add_rules('field_name','required', 'length[1,1000]')
					->add_rules('field_default', 'length[1,10000]')
					->add_rules('field_required','required', 'between[0,1]')
					->add_rules('field_width', 'between[0,300]')
					->add_rules('field_height', 'between[0,50]')
					->add_rules('field_isdate', 'between[0,1]')
					->add_rules('field_ispublic_visible','required', 'numeric')
					->add_rules('field_ispublic_submit','required', 'numeric');
				
		// Rrturn
		return parent::validate($array, $save);
	}
	
	/**
	 * Given the database id, checks if a form field record exists in the datbase
	 *
	 * @param int $field_id Database id of the form field record
	 * @return bool
	 */
	public static function is_valid_form_field($field_id)
	{
		return (intval($field_id) > 0)? ORM::factory('form_field', $field_id)->loaded : FALSE;
	}
}
