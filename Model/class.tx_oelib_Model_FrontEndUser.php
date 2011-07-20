<?php
/***************************************************************
* Copyright notice
*
* (c) 2008-2010 Oliver Klee <typo3-coding@oliverklee.de>
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Class tx_oelib_Model_FrontEndUser for the "oelib" extension.
 *
 * This class represents a front-end user.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_oelib_Model_FrontEndUser extends tx_oelib_Model implements
	tx_oelib_Interface_MailRole, tx_oelib_Interface_Address
{
	/**
	 * @var integer represents the male gender for this user
	 */
	const GENDER_MALE = 0;

	/**
	 * @var integer represents the female gender for this user
	 */
	const GENDER_FEMALE = 1;

	/**
	 * @var integer represents an unknown gender for this user
	 */
	const GENDER_UNKNOWN = 2;

	/**
	 * Gets this user's user name (login name).
	 *
	 * @return string this user's user name, will not be empty for valid users
	 */
	public function getUserName() {
		return $this->getAsString('username');
	}

	/**
	 * Sets this user's user name (login name).
	 *
	 * @param string $userName the user name to set, must not be empty
	 *
	 * @return void
	 */
	public function setUserName($userName) {
		if ($userName == '') {
			throw new InvalidArgumentException('$userName must not be empty.');
		}

		$this->setAsString('username', $userName);
	}

	/**
	 * Gets the password.
	 *
	 * @return string the password, might be empty
	 */
	public function getPassword() {
		return $this->getAsString('password');
	}

	/**
	 * Sets the password.
	 *
	 * @param string $password the password to set, must not be empty
	 *
	 * @return void
	 */
	public function setPassword($password) {
		if ($password == '') {
			throw new InvalidArgumentException('$password must not be empty.');
		}

		$this->setAsString('password', $password);
	}

	/**
	 * Gets this user's real name.
	 *
	 * First, the "name" field is checked. If that is empty, the fields
	 * "first_name" and "last_name" are checked. If those are empty as well,
	 * the user name is returned as a fallback value.
	 *
	 * @return string the user's real name, will not be empty for valid records
	 */
	public function getName() {
		if ($this->hasString('name')) {
			$result = $this->getAsString('name');
		} elseif ($this->hasFirstName() || $this->hasLastName()) {
			$result = trim($this->getFirstName() . ' ' . $this->getLastName());
		} else {
			$result = $this->getUserName();
		}

		return $result;
	}

	/**
	 * Checks whether this user has a non-empty name.
	 *
	 * @return boolean TRUE if this user has a non-empty name, FALSE otherwise
	 */
	public function hasName() {
		return ($this->hasString('name') || $this->hasFirstName()
			|| $this->hasLastName());
	}

	/**
	 * Sets the full name.
	 *
	 * @param string $name the name to set, may be empty
	 *
	 * @return void
	 */
	public function setname($name) {
		$this->setAsString('name', $name);
	}

	/**
	 * Gets this user's company.
	 *
	 * @return string this user's company, may be empty
	 */
	public function getCompany() {
		return $this->getAsString('company');
	}

	/**
	 * Checks whether this user has a non-empty company set.
	 *
	 * @return boolean TRUE if this user has a company set, FALSE otherwise
	 */
	public function hasCompany() {
		return $this->hasString('company');
	}

	/**
	 * Gets this user's street.
	 *
	 * @return string this user's street, may be multi-line, may be empty
	 */
	public function getStreet() {
		return $this->getAsString('address');
	}

	/**
	 * Checks whether this user has a non-empty street set.
	 *
	 * @return boolean TRUE if this user has a street set, FALSE otherwise
	 */
	public function hasStreet() {
		return $this->hasString('address');
	}

	/**
	 * Gets this user's ZIP code.
	 *
	 * @return string this user's ZIP code, may be empty
	 */
	public function getZip() {
		return $this->getAsString('zip');
	}

	/**
	 * Checks whether this user has a non-empty ZIP code set.
	 *
	 * @return boolean TRUE if this user has a ZIP code set, FALSE otherwise
	 */
	public function hasZip() {
		return $this->hasString('zip');
	}

	/**
	 * Gets this user's city.
	 *
	 * @return string this user's city, may be empty
	 */
	public function getCity() {
		return $this->getAsString('city');
	}

	/**
	 * Checks whether this user has a non-empty city set.
	 *
	 * @return boolean TRUE if this user has a city set, FALSE otherwise
	 */
	public function hasCity() {
		return $this->hasString('city');
	}

	/**
	 * Gets this user's ZIP code and city, separated by a space.
	 *
	 * @return string this user's ZIP code city, will be empty if the user has
	 *                no city set
	 */
	public function getZipAndCity() {
		if (!$this->hasCity()) {
			return '';
		}

		return trim($this->getZip() . ' ' . $this->getCity());
	}

	/**
	 * Gets this user's phone number.
	 *
	 * @return string this user's phone number, may be empty
	 */
	public function getPhoneNumber() {
		return $this->getAsString('telephone');
	}

	/**
	 * Checks whether this user has a non-empty phone number set.
	 *
	 * @return boolean TRUE if this user has a phone number set, FALSE otherwise
	 */
	public function hasPhoneNumber() {
		return $this->hasString('telephone');
	}

	/**
	 * Gets this user's e-mail address.
	 *
	 * @return string this user's e-mail address, may be empty
	 */
	public function getEMailAddress() {
		return $this->getAsString('email');
	}

	/**
	 * Checks whether this user has a non-empty e-mail address set.
	 *
	 * @return boolean TRUE if this user has an e-mail address set, FALSE
	 *                 otherwise
	 */
	public function hasEMailAddress() {
		return $this->hasString('email');
	}

	/**
	 * Sets the e-mail address.
	 *
	 * @param string $eMailAddress the e-mail address to set, may be empty
	 *
	 * @return void
	 */
	public function setEMailAddress($eMailAddress) {
		$this->setAsString('email', $eMailAddress);
	}

	/**
	 * Gets this user's homepage URL (not linked yet).
	 *
	 * @return string this user's homepage URL, may be empty
	 */
	public function getHomepage() {
		return $this->getAsString('www');
	}

	/**
	 * Checks whether this user has a non-empty homepage set.
	 *
	 * @return boolean TRUE if this user has a homepage set, FALSE otherwise
	 */
	public function hasHomepage() {
		return $this->hasString('www');
	}

	/**
	 * Gets this user's image path (relative to the global upload directory).
	 *
	 * @return string this user's image path, may be empty
	 */
	public function getImage() {
		return $this->getAsString('image');
	}

	/**
	 * Checks whether this user has an image set.
	 *
	 * @return boolean TRUE if this user has an image set, FALSE otherwise
	 */
	public function hasImage() {
		return $this->hasString('image');
	}

	/**
	 * Checks whether this user has agreed to receive HTML e-mails.
	 *
	 * @return boolean TRUE if the user agreed to receive HTML e-mails, FALSE
	 *                 otherwise
	 */
	public function wantsHtmlEMail() {
		return $this->getAsBoolean('module_sys_dmail_html');
	}

	/**
	 * Gets this user's user groups.
	 *
	 * @return tx_oelib_List this user's FE user groups, will not be empty if
	 *                       the user data is valid
	 */
	public function getUserGroups() {
		return $this->getAsList('usergroup');
	}

	/**
	 * Sets this user's direct user groups.
	 *
	 * @param tx_oelib_List $userGroups the user groups to set, may be empty
	 *
	 * @return void
	 */
	public function setUserGroups(tx_oelib_List $userGroups) {
		$this->set('usergroup', $userGroups);
	}

	/**
	 * Checks whether this user is a member of at least one of the user groups
	 * provided as comma-separated UID list.
	 *
	 * @param string comma-separated list of user group UIDs, can also consist
	 *               of only one UID but must not be empty
	 *
	 * @return boolean TRUE if the user is member of at least one of the user
	 *                 groups provided, FALSE otherwise
	 */
	public function hasGroupMembership($uidList) {
		if ($uidList == '') {
			throw new Exception('$uidList must not be empty.');
		}

		$isMember = FALSE;

		foreach (t3lib_div::trimExplode(',', $uidList, TRUE) as $uid) {
			if ($this->getUserGroups()->hasUid($uid)) {
				$isMember = TRUE;
				break;
			}
		}

		return $isMember;
	}

	/**
	 * Gets this user's gender.
	 *
	 * Will return "unknown gender" if sr_feuser_register is not installed.
	 *
	 * @return integer the gender of the user, will be
	 *                 tx_oelib_Model_FrontEndUser::GENDER_FEMALE,
	 *                 tx_oelib_Model_FrontEndUser::GENDER_MALE or
	 *                 tx_oelib_Model_FrontEndUser::GENDER_UNKNOWN
	 */
	public function getGender() {
		if (!t3lib_extMgm::isLoaded('sr_feuser_register')) {
			return self::GENDER_UNKNOWN;
		}

		return $this->getAsInteger('gender');
	}

	/**
	 * Checks whether this user has a first name.
	 *
	 * @return boolean TRUE if the user has a first name, FALSE otherwise
	 */
	public function hasFirstName() {
		return $this->hasString('first_name');
	}

	/**
	 * Gets this user's first name
	 *
	 * @return string the first name of this user, will be empty if no first
	 *                name is set
	 */
	public function getFirstName() {
		return $this->getAsString('first_name');
	}

	/**
	 * Sets the first name.
	 *
	 * @param string $firstName the first name to set, may be empty
	 *
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->setAsString('first_name', $firstName);
	}

	/**
	 * Checks whether this user has a last name.
	 *
	 * @return boolean TRUE if the user has a last name, FALSE otherwise
	 */
	public function hasLastName() {
		return $this->hasString('last_name');
	}

	/**
	 * Gets this user's last name
	 *
	 * @return string the last name of this user, will be empty if no last name
	 *                is set
	 */
	public function getLastName() {
		return $this->getAsString('last_name');
	}

	/**
	 * Sets the last name.
	 *
	 * @param string $lastName the last name to set, may be empty
	 *
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->setAsString('last_name', $lastName);
	}

	/**
	 * Gets this user's first name; if the user does not have a first name the
	 * full name is returned instead.
	 *
	 * @return string the first name of this user if it exists, will return the
	 *                user's full name otherwise
	 */
	public function getFirstOrFullName() {
		return ($this->hasFirstName())
			? $this->getFirstName()
			: $this->getName();
	}

	/**
	 * Gets this user's last name; if the user does not have a last name the
	 * full name is returned instead.
	 *
	 * @return string the last name of this user if it exists, will return the
	 *                user's full name otherwise
	 */
	public function getLastOrFullName() {
		return ($this->hasLastName())
			? $this->getLastName()
			: $this->getName();
	}

	/**
	 * Gets this user's date of birth as a UNIX timestamp.
	 *
	 * @return integer the user's date of birth, will be zero if no date has
	 *                 been set
	 */
	public function getDateOfBirth() {
		return $this->getAsInteger('date_of_birth');
	}

	/**
	 * Checks whether this user has a date of birth set.
	 *
	 * @return boolean TRUE if this user has a non-zero date of birth, FALSE
	 *                 otherwise
	 */
	public function hasDateOfBirth() {
		return $this->hasInteger('date_of_birth');
	}

	/**
	 * Returns this user's age in years.
	 *
	 * Note: This function only works correctly for users that were born after
	 * 1970-01-01 and that were not born in the future.
	 *
	 * @integer this user's age in years, will be 0 if this user has no birth
	 *          date set
	 */
	public function getAge() {
		if (!$this->hasDateOfBirth()) {
			return 0;
		}

		$currentTimestamp = $GLOBALS['EXEC_TIME'];
		$birthTimestmap = $this->getDateOfBirth();

		$currentYear = intval(strftime('%Y', $currentTimestamp));
		$currentMonth = intval(strftime('%m', $currentTimestamp));
		$currentDay = intval(strftime('%d', $currentTimestamp));
		$birthYear = intval(strftime('%Y', $birthTimestmap));
		$birthMonth = intval(strftime('%m', $birthTimestmap));
		$birthDay = intval(strftime('%d', $birthTimestmap));

		$age = $currentYear - $birthYear;

		if ($currentMonth < $birthMonth) {
			$age--;
		} elseif ($currentMonth == $birthMonth) {
			if ($currentDay < $birthDay) {
				$age--;
			}
		}

		return $age;
	}

	/**
	 * Gets this user's last login date and time as a UNIX timestamp.
	 *
	 * @return integer the user's last login date and time, will be zero if the
	 *                 user has never logged in
	 */
	public function getLastLoginAsUnixTimestamp() {
		return $this->getAsInteger('lastlogin');
	}

	/**
	 * Checks whether this user has a last login date set.
	 *
	 * @return boolean TRUE if this user has a non-zero last login date, FALSE
	 *                 otherwise
	 */
	public function hasLastLogin() {
		return $this->hasInteger('lastlogin');
	}

	/**
	 * Returns the country of this user as tx_oelib_Model_Country.
	 *
	 * Note: This function uses the "country code" field, not the free-text
	 * country field.
	 *
	 * @return tx_oelib_Model_Country the country of this user, will be null
	 *                                if no valid country has been set
	 */
	public function getCountry() {
		$countryCode = $this->getAsString('static_info_country');
		if ($countryCode == '') {
			return null;
		}

		try {
			$country = tx_oelib_MapperRegistry::get('tx_oelib_Mapper_Country')
				->findByIsoAlpha3Code($countryCode);
		} catch (tx_oelib_Exception_NotFound $exception) {
			$country = null;
		}

		return $country;
	}

	/**
	 * Sets the country of this user.
	 *
	 * @param tx_oelib_Model_Country $country
	 *        the country to set for this place, can be null for "no country"
	 */
	public function setCountry(tx_oelib_Model_Country $country = null) {
		$countryCode = ($country !== null) ? $country->getIsoAlpha3Code() : '';

		$this->setAsString('static_info_country', $countryCode);
	}

	/**
	 * Returns whether this user has a country.
	 *
	 * @return boolean TRUE if this user has a country, FALSE otherwise
	 */
	public function hasCountry() {
		return ($this->getCountry() instanceof tx_oelib_Model_Country);
	}

	/**
	 * Gets this user's job title.
	 *
	 * @return string this user's job title, may be empty
	 */
	public function getJobTitle() {
		return $this->getAsString('title');
	}

	/**
	 * Checks whether this user has a non-empty job title set.
	 *
	 * @return boolean TRUE if this user has an job title set, FALSE otherwise
	 */
	public function hasJobTitle() {
		return $this->hasString('title');
	}

	/**
	 * Sets this user's job title.
	 *
	 * @param string $jobTitle the job title to set, may be empty
	 *
	 * @return void
	 */
	public function setJobTitle($jobTitle) {
		$this->setAsString('title', $jobTitle);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/Model/class.tx_oelib_Model_FrontEndUser.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/Model/class.tx_oelib_Model_FrontEndUser.php']);
}
?>