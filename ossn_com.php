<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   SOFTLAB24 LIMITED, COMMERCIAL LICENSE v1.0 https://www.softlab24.com/license/commercial-license-v1
 * @link      https://www.softlab24.com
 */

define('PasswordValidation', ossn_route()->com . 'PasswordValidation/');
define('PasswordValidationLength', 8); //must be at least 6 as core requires at least 6 (for Ossn < v5)

require_once(PasswordValidation . 'classes/PasswordValidation.php');

/**
 * Password validation initialize
 *
 * @return void
 */
function password_validation_init() {
		ossn_extend_view('css/ossn.default', 'PasswordValidation/css');
		ossn_extend_view('js/opensource.socialnetwork', 'PasswordValidation/js');
		
		ossn_new_external_js('underscore-min.js', 'components/PasswordValidation/vendors/underscore-min.js');
		ossn_load_external_js('underscore-min.js');
		
		ossn_register_callback('action', 'load', 'password_length_check');
		ossn_add_hook('user', 'password:minimum:length', 'password_validation_set_length'); //for Ossn v5
}
/**
 * Set pasword minmium length
 * 
 * @access private
 * @return integer
 */
function password_validation_set_length() {
		return PasswordValidationLength;
}
/**
 * Validate the password
 *
 * @param string $callback  The callback type
 * @param string $type      The callback type
 * @param array  $params    The option values
 * 
 * @access private
 * @return string
 */
function password_length_check($callback, $type, $params) {
		$password = input('password');
		$validate = new PasswordValidation($password);
		if (isset($params['action']) && !$validate->isValid()) {
				if ($params['action'] == 'user/register') {
						header('Content-Type: application/json');
						echo json_encode(array(
								'dataerr' => ossn_print('passwordvalidation:error')
						));
						exit;
				}
		}
}
ossn_register_callback('ossn', 'init', 'password_validation_init');