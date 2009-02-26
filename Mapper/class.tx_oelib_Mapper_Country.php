<?php
/***************************************************************
* Copyright notice
*
* (c) 2009 Niels Pardon (mail@niels-pardon.de)
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
 * Class 'tx_oelib_Mapper_Country' for the 'oelib' extension.
 *
 * This class represents a mapper for countries.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class tx_oelib_Mapper_Country extends tx_oelib_DataMapper {
	/**
	 * @var string the name of the database table for this mapper
	 */
	protected $tableName = 'static_countries';

	/**
	 * @var string the model class name for this mapper, must not be empty
	 */
	protected $modelClassName = 'tx_oelib_Model_Country';

	/**
	 * Finds a country by it's ISO 3166-1 alpha-2 code.
	 *
	 * @param string the ISO 3166-1 alpha-2 code to find, must not be empty
	 *
	 * @return tx_oelib_Model_Country the country, null if there was no country
	 *                                found
	 */
	public function findByIsoAlpha2Code($isoAlpha2Code) {
		if ($isoAlpha2Code == '') {
			throw new Exception('The parameter $isoAlpha2Code must not be empty.');
		}

		return $this->findSingleByWhereClause(
			'cn_iso_2 = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr(
				$isoAlpha2Code, $this->tableName
			));
	}

	/**
	 * Finds a country by it's ISO 3166-1 alpha-3 code.
	 *
	 * @param string the ISO 3166-1 alpha-3 code to find, must not be empty
	 *
	 * @return tx_oelib_Model_Country the country, null if there was no country
	 *                                found
	 */
	public function findByIsoAlpha3Code($isoAlpha3Code) {
		if ($isoAlpha3Code == '') {
			throw new Exception('The parameter $isoAlpha3Code must not be empty.');
		}

		return $this->findSingleByWhereClause(
			'cn_iso_3 = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr(
				$isoAlpha3Code, $this->tableName
			));
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/Mapper/class.tx_oelib_Mapper_Country.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/Mapper/class.tx_oelib_Mapper_Country.php']);
}
?>