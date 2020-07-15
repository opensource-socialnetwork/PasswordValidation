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
class PasswordValidation extends OssnBase {
		/**
		 * Initilize the validation class
		 *
		 * @return void
		 */
		public function __construct($password = '') {
				$this->password = $password;
		}
		/**
		 * Make sure the password is valid or not
		 *
		 * @return boolean
		 */
		public function isValid() {
				if ($this->haveUpper() && $this->haveLower() && $this->haveNumber() && strlen($this->password) >= PasswordValidationLength) {
						return true;
				}
				return false;
		}
		/**
		 * Make sure the password have upper case letter
		 *
		 * @return boolean
		 */
		public function haveUpper() {
				return preg_match('/[A-Z]/', $this->password);
		}
		/**
		 * Make sure the password have lower case letter
		 *
		 * @return boolean
		 */
		public function haveLower() {
				return preg_match('/[a-z]/', $this->password);
		}
		/**
		 * Make sure the password have number
		 *
		 * @return boolean
		 */
		
		public function haveNumber() {
				return preg_match('/[0-9]/', $this->password);
		}
}