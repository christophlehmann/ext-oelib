<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2013 Oliver Klee (typo3-coding@oliverklee.de)
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
 * Test case.
 *
 * @package TYPO3
 * @subpackage oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_ListTest extends Tx_Phpunit_TestCase {
	/**
	 * @var tx_oelib_List
	 */
	private $fixture;

	/**
	 * @var array models that need to be cleaned up during tearDown.
	 */
	private $modelStorage = array();

	/**
	 * @var boolean
	 */
	private $deprecationLogEnabledBackup = FALSE;

	public function setUp() {
		$this->deprecationLogEnabledBackup = $GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'];

		$this->fixture = new tx_oelib_List();
	}

	public function tearDown() {
		$this->fixture->__destruct();
		foreach($this->modelStorage as $key => $model ) {
			$model->__destruct();
			unset($this->modelStorage[$key]);
		}

		unset($this->fixture, $this->modelStorage);

		$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = $this->deprecationLogEnabledBackup;
	}


	///////////////////////
	// Utility functions
	///////////////////////

	/**
	 * @param Tx_Oelib_Tests_Unit_Fixtures_TestingModel $firstModel
	 * @param Tx_Oelib_Tests_Unit_Fixtures_TestingModel $secondModel
	 *
	 * @return integer
	 */
	public function sortByTitleAscending(
		Tx_Oelib_Tests_Unit_Fixtures_TestingModel $firstModel,
		Tx_Oelib_Tests_Unit_Fixtures_TestingModel $secondModel
	) {
		return strcmp($firstModel->getTitle(), $secondModel->getTitle());
	}

	/**
	 * @param Tx_Oelib_Tests_Unit_Fixtures_TestingModel $firstModel
	 * @param Tx_Oelib_Tests_Unit_Fixtures_TestingModel $secondModel
	 *
	 * @return integer
	 */
	public function sortByTitleDescending(
		Tx_Oelib_Tests_Unit_Fixtures_TestingModel $firstModel,
		Tx_Oelib_Tests_Unit_Fixtures_TestingModel $secondModel
	) {
		return strcmp($secondModel->getTitle(), $firstModel->getTitle());
	}

	/**
	 * Adds models with the given titles to the fixture, one for each title
	 * given in $titles.
	 *
	 * @param array<string> $titles
	 *        the titles for the models, must not be empty
	 *
	 * @return void
	 */
	private function addModelsToFixture(array $titles = array('')) {
		foreach ($titles as $title) {
			$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
			$model->setTitle($title);
			$this->fixture->add($model);

			$this->modelStorage[] = $model;
		}
	}


	///////////////////////////////////////////
	// Tests concerning the utility functions
	///////////////////////////////////////////

	//////////////////////////////////////////
	// Tests concerning sortByTitleAscending
	//////////////////////////////////////////

	/**
	 * @test
	 */
	public function sortByTitleAscendingForFirstModelTitleAlphaAndSecondModelTitleBetaReturnsMinusOne() {
		$firstModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$firstModel->setTitle('alpha');
		$secondModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$secondModel->setTitle('beta');

		$this->assertSame(
			-1,
			$this->sortByTitleAscending($firstModel, $secondModel)
		);

		$firstModel->__destruct();
		$secondModel->__destruct();
	}

	/**
	 * @test
	 */
	public function sortByTitleAscendingForFirstModelTitleBetaAndSecondModelTitleAlphaReturnsOne() {
		$firstModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$firstModel->setTitle('beta');
		$secondModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$secondModel->setTitle('alpha');

		$this->assertSame(
			1,
			$this->sortByTitleAscending($firstModel, $secondModel)
		);

		$firstModel->__destruct();
		$secondModel->__destruct();
	}

	/**
	 * @test
	 */
	public function sortByTitleAscendingForFirstAndSecondModelTitleSameReturnsZero() {
		$firstModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$firstModel->setTitle('alpha');
		$secondModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$secondModel->setTitle('alpha');

		$this->assertSame(
			0,
			$this->sortByTitleAscending($firstModel, $secondModel)
		);

		$firstModel->__destruct();
		$secondModel->__destruct();
	}


	///////////////////////////////////////////
	// Tests concerning sortByTitleDescending
	///////////////////////////////////////////

	/**
	 * @test
	 */
	public function sortByTitleDescendingForFirstModelTitleAlphaAndSecondModelTitleBetaReturnsOne() {
		$firstModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$firstModel->setTitle('alpha');
		$secondModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$secondModel->setTitle('beta');

		$this->assertSame(
			1,
			$this->sortByTitleDescending($firstModel, $secondModel)
		);

		$firstModel->__destruct();
		$secondModel->__destruct();
	}

	/**
	 * @test
	 */
	public function sortByTitleDescendingForFirstModelTitleBetaAndSecondModelTitleAlphaReturnsMinusOne() {
		$firstModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$firstModel->setTitle('beta');
		$secondModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$secondModel->setTitle('alpha');

		$this->assertSame(
			-1,
			$this->sortByTitleDescending($firstModel, $secondModel)
		);

		$firstModel->__destruct();
		$secondModel->__destruct();
	}

	/**
	 * @test
	 */
	public function sortByTitleDescendingForFirstAndSecondModelTitleSameReturnsZero() {
		$firstModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$firstModel->setTitle('alpha');
		$secondModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$secondModel->setTitle('alpha');

		$this->assertSame(
			0,
			$this->sortByTitleDescending($firstModel, $secondModel)
		);

		$firstModel->__destruct();
		$secondModel->__destruct();
	}


	////////////////////////////////////////
	// Tests concerning addModelsToFixture
	////////////////////////////////////////

	/**
	 * @test
	 */
	public function addModelsToFixtureForOneGivenTitleAddsOneModelToFixture() {
		$this->addModelsToFixture(array('foo'));

		$this->assertSame(
			1,
			$this->fixture->count()
		);
	}

	/**
	 * @test
	 */
	public function addModelsToFixtureForOneGivenTitleAddsModelWithTitleGiven() {
		$this->addModelsToFixture(array('foo'));

		$this->assertSame(
			'foo',
			$this->fixture->first()->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function addModelsToFixtureForTwoGivenTitlesAddsTwoModelsToFixture() {
		$this->addModelsToFixture(array('foo', 'bar'));

		$this->assertSame(
			2,
			$this->fixture->count()
		);
	}

	/**
	 * @test
	 */
	public function addModelsToFixtureForTwoGivenTitlesAddsFirstTitleToFirstModelFixture() {
		$this->addModelsToFixture(array('bar', 'foo'));

		$this->assertSame(
			'bar',
			$this->fixture->first()->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function addModelsToFixtureForThreeGivenTitlesAddsThreeModelsToFixture() {
		$this->addModelsToFixture(array('foo', 'bar','fooBar'));

		$this->assertSame(
			3,
			$this->fixture->count()
		);
	}


	/////////////////////////////
	// Tests concerning isEmpty
	/////////////////////////////

	/**
	 * @test
	 */
	public function isEmptyForEmptyListReturnsTrue() {
		$this->assertTrue(
			$this->fixture->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function isEmptyAfterAddingModelReturnsFalse() {
		$this->addModelsToFixture();

		$this->assertFalse(
			$this->fixture->isEmpty()
		);
	}


	///////////////////////////
	// Tests concerning count
	///////////////////////////

	/**
	 * @test
	 */
	public function countForEmptyListReturnsZero() {
		$this->assertSame(
			0,
			$this->fixture->count()
		);
	}

	/**
	 * @test
	 */
	public function countWithOneModelWithoutUidReturnsOne() {
		$this->addModelsToFixture();

		$this->assertSame(
			1,
			$this->fixture->count()
		);
	}

	/**
	 * @test
	 */
	public function countWithOneModelWithUidReturnsOne() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model->setUid(1);
		$this->fixture->add($model);

		$this->assertSame(
			1,
			$this->fixture->count()
		);

		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function countWithTwoDifferentModelsReturnsTwo() {
		$this->addModelsToFixture(array('',''));

		$this->assertSame(
			2,
			$this->fixture->count()
		);
	}

	/**
	 * @test
	 */
	public function countAfterAddingTheSameModelTwiceReturnsOne() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);
		$this->fixture->add($model);

		$this->assertSame(
			1,
			$this->fixture->count()
		);

		$model->__destruct();
	}


	/////////////////////////////
	// Tests concerning current
	/////////////////////////////

	/**
	 * @test
	 */
	public function currentForEmptyListReturnsNull() {
		$this->assertNull(
			$this->fixture->current()
		);
	}

	/**
	 * @test
	 */
	public function currentWithOneItemReturnsThatItem() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$this->assertSame(
			$model,
			$this->fixture->current()
		);

		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function currentWithTwoItemsInitiallyReturnsTheFirstItem() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model2);

		$this->assertSame(
			$model1,
			$this->fixture->current()
		);

		$model1->__destruct();
		$model2->__destruct();
	}


	//////////////////////////////////
	// Tests concerning key and next
	//////////////////////////////////

	/**
	 * @test
	 */
	public function keyInitiallyReturnsZero() {
		$this->assertSame(
			0,
			$this->fixture->key()
		);
	}

	/**
	 * @test
	 */
	public function keyAfterNextInListWithOneElementReturnsOne() {
		$this->addModelsToFixture();
		$this->fixture->next();

		$this->assertSame(
			1,
			$this->fixture->key()
		);
	}

	/**
	 * @test
	 */
	public function currentWithOneItemAfterNextReturnsNull() {
		$this->addModelsToFixture();

		$this->fixture->next();

		$this->assertNull(
			$this->fixture->current()
		);
	}

	/**
	 * @test
	 */
	public function currentWithTwoItemsAfterNextReturnsTheSecondItem() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model2);

		$this->fixture->next();

		$this->assertSame(
			$model2,
			$this->fixture->current()
		);

		$model1->__destruct();
		$model2->__destruct();
	}


	////////////////////////////
	// Tests concerning rewind
	////////////////////////////

	/**
	 * @test
	 */
	public function rewindAfterNextResetsKeyToZero() {
		$this->fixture->next();
		$this->fixture->rewind();

		$this->assertSame(
			0,
			$this->fixture->key()
		);
	}

	/**
	 * @test
	 */
	public function rewindAfterNextForOneItemsResetsCurrentToTheOnlyItem() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$this->fixture->next();
		$this->fixture->rewind();

		$this->assertSame(
			$model,
			$this->fixture->current()
		);

		$model->__destruct();
	}


	///////////////////////////
	// Tests concerning first
	///////////////////////////

	/**
	 * @test
	 */
	public function firstForEmptyListReturnsNull() {
		$this->assertNull(
			$this->fixture->first()
		);
	}

	/**
	 * @test
	 */
	public function firstForListWithOneItemReturnsThatItem() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$this->assertSame(
			$model,
			$this->fixture->first()
		);

		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function firstWithTwoItemsReturnsTheFirstItem() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model2);

		$this->assertSame(
			$model1,
			$this->fixture->first()
		);

		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function firstWithTwoItemsAfterNextReturnsTheFirstItem() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model2);

		$this->fixture->next();

		$this->assertSame(
			$model1,
			$this->fixture->first()
		);

		$model1->__destruct();
		$model2->__destruct();
	}


	///////////////////////////
	// Tests concerning valid
	///////////////////////////

	/**
	 * @test
	 */
	public function validForEmptyListReturnsFalse() {
		$this->assertFalse(
			$this->fixture->valid()
		);
	}

	/**
	 * @test
	 */
	public function validForOneElementInitiallyReturnsTrue() {
		$this->addModelsToFixture();

		$this->assertTrue(
			$this->fixture->valid()
		);
	}

	/**
	 * @test
	 */
	public function validForOneElementAfterNextReturnsFalse() {
		$this->addModelsToFixture();

		$this->fixture->next();

		$this->assertFalse(
			$this->fixture->valid()
		);
	}

	/**
	 * @test
	 */
	public function validForOneElementAfterNextAndRewindReturnsTrue() {
		$this->addModelsToFixture();

		$this->fixture->next();
		$this->fixture->rewind();

		$this->assertTrue(
			$this->fixture->valid()
		);
	}


	///////////////////////////////////////////
	// Tests concerning the Iterator property
	///////////////////////////////////////////

	/**
	 * @test
	 */
	public function isIterator() {
		$this->assertTrue(
			$this->fixture instanceof Iterator
		);
	}

	/**
	 * @test
	 */
	public function iteratingOverOneItemDoesNotFail() {
		$this->addModelsToFixture();

		$this->fixture->next();
		$this->fixture->rewind();

		foreach ($this->fixture as $value);
	}


	/////////////////////////////
	// Tests concerning getUids
	/////////////////////////////

	/**
	 * @test
	 */
	public function getUidsForEmptyListReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getUids()
		);
	}

	/**
	 * @test
	 */
	public function getUidsForOneItemsWithoutUidReturnsEmptyString() {
		$this->addModelsToFixture();

		$this->assertSame(
			'',
			$this->fixture->getUids()
		);
	}

	/**
	 * @test
	 */
	public function getUidsForOneItemsWithUidReturnsThatUid() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model->setUid(1);
		$this->fixture->add($model);

		$this->assertSame(
			'1',
			$this->fixture->getUids()
		);

		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function getUidsForTwoItemsWithUidReturnsCommaSeparatedItems() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model1->setUid(1);
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model2->setUid(42);
		$this->fixture->add($model2);

		$this->assertSame(
			'1,42',
			$this->fixture->getUids()
		);

		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function getUidsForTwoItemsWithDecreasingUidReturnsItemsInOrdnerOfInsertion() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model1->setUid(42);
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model2->setUid(1);
		$this->fixture->add($model2);

		$this->assertSame(
			'42,1',
			$this->fixture->getUids()
		);

		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function getUidsForDuplicateUidsReturnsUidsInOrdnerOfFirstInsertion() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model1->setUid(1);
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model2->setUid(2);
		$this->fixture->add($model2);

		$this->fixture->add($model1);

		$this->assertSame(
			'1,2',
			$this->fixture->getUids()
		);

		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function getUidsForElementThatGotItsUidAfterAddingItReturnsItsUid() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);
		$model->setUid(42);

		$this->assertSame(
			'42',
			$this->fixture->getUids()
		);

		$model->__destruct();
	}


	////////////////////////////
	// Tests concerning hasUid
	////////////////////////////

	/**
	 * @test
	 */
	public function hasUidForInexistentUidReturnsFalse() {
		$this->assertFalse(
			$this->fixture->hasUid(42)
		);
	}

	/**
	 * @test
	 */
	public function hasUidForExistingUidReturnsTrue() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model->setUid(42);
		$this->fixture->add($model);

		$this->assertTrue(
			$this->fixture->hasUid(42)
		);

		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function hasUidForElementThatGotItsUidAfterAddingItReturnsTrue() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);
		$model->setUid(42);

		$this->assertTrue(
			$this->fixture->hasUid(42)
		);

		$model->__destruct();
	}


	//////////////////////////
	// Tests concerning sort
	//////////////////////////

	/**
	 * @test
	 */
	public function sortWithTwoModelsAndSortByTitleAscendingFunctionSortsModelsByTitleAscending() {
		$this->addModelsToFixture(array('Beta', 'Alpha'));
		$this->fixture->sort(array($this, 'sortByTitleAscending'));

		$this->assertSame(
			'Alpha',
			$this->fixture->first()->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function sortWithThreeModelsAndSortByTitleAscendingFunctionSortsModelsByTitleAscending() {
		$this->addModelsToFixture(array('Zeta', 'Beta', 'Alpha'));
		$this->fixture->sort(array($this, 'sortByTitleAscending'));

		$this->assertSame(
			'Alpha',
			$this->fixture->first()->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function sortWithTwoModelsAndSortByTitleDescendingFunctionSortsModelsByTitleDescending() {
		$this->addModelsToFixture(array('Alpha', 'Beta'));
		$this->fixture->sort(array($this, 'sortByTitleDescending'));

		$this->assertSame(
			'Beta',
			$this->fixture->first()->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function sortMakesListDirty() {
		$fixture = $this->getMock('tx_oelib_List', array('markAsDirty'));
		$fixture->expects($this->once())->method('markAsDirty');

		$fixture->sort(array($this, 'sortByTitleAscending'));
	}


	////////////////////////////
	// Tests concerning append
	////////////////////////////

	/**
	 * @test
	 */
	public function appendEmptyListToEmptyListMakesEmptyList() {
		$otherList = new tx_oelib_List();
		$this->fixture->append($otherList);

		$this->assertTrue(
			$this->fixture->isEmpty()
		);

		$otherList->__destruct();
	}

	/**
	 * @test
	 */
	public function appendTwoItemListToEmptyListMakesTwoItemList() {
		$otherList = new tx_oelib_List();
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model2);

		$this->fixture->append($otherList);

		$this->assertSame(
			2,
			$this->fixture->count()
		);

		$otherList->__destruct();
		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function appendEmptyListToTwoItemListMakesTwoItemList() {
		$this->addModelsToFixture(array('First', 'Second'));

		$otherList = new tx_oelib_List();
		$this->fixture->append($otherList);

		$this->assertSame(
			2,
			$this->fixture->count()
		);

		$otherList->__destruct();
	}

	/**
	 * @test
	 */
	public function appendOneItemListToOneItemListWithTheSameItemMakesOneItemList() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model->setUid(42);
		$this->fixture->add($model);

		$otherList = new tx_oelib_List();
		$otherList->add($model);

		$this->fixture->append($otherList);

		$this->assertSame(
			1,
			$this->fixture->count()
		);

		$otherList->__destruct();
		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function appendTwoItemListKeepsOrderOfAppendedItems() {
		$otherList = new tx_oelib_List();
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model2);

		$this->fixture->append($otherList);

		$this->assertSame(
			$model1,
			$this->fixture->first()
		);

		$otherList->__destruct();
		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function appendAppendsItemAfterExistingItems() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$otherList = new tx_oelib_List();
		$otherModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($otherModel);

		$this->fixture->append($otherList);

		$this->assertSame(
			$model,
			$this->fixture->first()
		);

		$otherList->__destruct();
		$model->__destruct();
		$otherModel->__destruct();
	}


	//////////////////////////////////
	// Tests concerning appendUnique
	//////////////////////////////////

	/**
	 * @test
	 */
	public function appendUniqueForEmptyListToEmptyListMakesEmptyList() {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = FALSE;

		$otherList = new tx_oelib_List();
		$this->fixture->appendUnique($otherList);

		$this->assertTrue(
			$this->fixture->isEmpty()
		);

		$otherList->__destruct();
	}

	/**
	 * @test
	 */
	public function appendUniqueForTwoItemListToEmptyListMakesTwoItemList() {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = FALSE;

		$otherList = new tx_oelib_List();
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model2);

		$this->fixture->appendUnique($otherList);

		$this->assertSame(
			2,
			$this->fixture->count()
		);

		$otherList->__destruct();
		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function appendUniqueForEmptyListToTwoItemListMakesTwoItemList() {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = FALSE;

		$this->addModelsToFixture(array('First', 'Second'));

		$otherList = new tx_oelib_List();
		$this->fixture->appendUnique($otherList);

		$this->assertSame(
			2,
			$this->fixture->count()
		);

		$otherList->__destruct();
	}

	/**
	 * @test
	 */
	public function appendUniqueForOneItemListToOneItemListWithTheSameItemMakesOneItemList() {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = FALSE;

		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model->setUid(42);
		$this->fixture->add($model);

		$otherList = new tx_oelib_List();
		$otherList->add($model);

		$this->fixture->appendUnique($otherList);

		$this->assertSame(
			1,
			$this->fixture->count()
		);

		$otherList->__destruct();
		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function appendUniqueForTwoItemListKeepsOrderOfAppendedItems() {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = FALSE;

		$otherList = new tx_oelib_List();
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($model2);

		$this->fixture->appendUnique($otherList);

		$this->assertSame(
			$model1,
			$this->fixture->first()
		);

		$otherList->__destruct();
		$model1->__destruct();
		$model2->__destruct();
	}

	/**
	 * @test
	 */
	public function appendUniqueAppendsItemAfterExistingItems() {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = FALSE;

		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$otherList = new tx_oelib_List();
		$otherModel = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$otherList->add($otherModel);

		$this->fixture->appendUnique($otherList);

		$this->assertSame(
			$model,
			$this->fixture->first()
		);

		$otherList->__destruct();
		$model->__destruct();
		$otherModel->__destruct();
	}


	//////////////////////////////////
	// Tests concerning purgeCurrent
	//////////////////////////////////

	/**
	 * @test
	 */
	public function purgeCurrentWithEmptyListDoesNotFail() {
		$this->fixture->purgeCurrent();
	}

	/**
	 * @test
	 */
	public function purgeCurrentWithRewoundOneElementListMakesListEmpty() {
		$this->addModelsToFixture();

		$this->fixture->rewind();
		$this->fixture->purgeCurrent();

		$this->assertTrue(
			$this->fixture->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function purgeCurrentWithRewoundOneElementListMakesPointerInvalid() {
		$this->addModelsToFixture();

		$this->fixture->rewind();
		$this->fixture->purgeCurrent();

		$this->assertFalse(
			$this->fixture->valid()
		);
	}

	/**
	 * @test
	 */
	public function purgeCurrentWithOneElementListAndPointerAfterLastItemLeavesListUntouched() {
		$this->addModelsToFixture();

		$this->fixture->rewind();
		$this->fixture->next();
		$this->fixture->purgeCurrent();

		$this->assertFalse(
			$this->fixture->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function purgeCurrentForFirstOfTwoElementsMakesOneItemList() {
		$this->addModelsToFixture(array('', ''));

		$this->fixture->rewind();
		$this->fixture->purgeCurrent();

		$this->assertSame(
			1,
			$this->fixture->count()
		);
	}

	/**
	 * @test
	 */
	public function purgeCurrentForSecondOfTwoElementsMakesOneItemList() {
		$this->addModelsToFixture(array('', ''));

		$this->fixture->rewind();
		$this->fixture->next();
		$this->fixture->purgeCurrent();

		$this->assertSame(
			1,
			$this->fixture->count()
		);
	}

	/**
	 * @test
	 */
	public function purgeCurrentForFirstOfTwoElementsSetsPointerToFormerSecondElement() {
		$this->addModelsToFixture();

		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$this->fixture->rewind();
		$this->fixture->purgeCurrent();

		$this->assertSame(
			$model,
			$this->fixture->current()
		);

		$model->__destruct();
	}

	/**
	 * @test
	 */
	public function purgeCurrentForSecondOfTwoElementsInForeachLoopDoesNotChangeNumberOfIterations() {
		$this->addModelsToFixture(array('', ''));

		$completedIterations = 0;

		foreach ($this->fixture as $model) {
			if ($completedIterations == 1) {
				$this->fixture->purgeCurrent();
			}

			$completedIterations++;
		}

		$this->assertSame(
			2,
			$completedIterations
		);
	}

	/**
	 * @test
	 */
	public function purgeCurrentForSecondOfTwoElementsInWhileLoopDoesNotChangeNumberOfIterations() {
		$this->addModelsToFixture(array('', ''));

		$completedIterations = 0;

		while ($this->fixture->valid()) {
			if ($completedIterations == 1) {
				$this->fixture->purgeCurrent();
			}

			$completedIterations++;
			$this->fixture->next();
		}

		$this->assertSame(
			2,
			$completedIterations
		);
	}

	/**
	 * @test
	 */
	public function purgeCurrentForModelWithUidRemovesModelFromGetUids() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model->setUid(1);
		$this->fixture->add($model);
		$this->modelStorage[] = $model;

		$this->fixture->rewind();
		$this->fixture->purgeCurrent();

		$this->assertSame(
			'',
			$this->fixture->getUids()
		);
	}


	//////////////////////////////////
	// Tests concerning cloned lists
	//////////////////////////////////

	/**
	 * @test
	 */
	public function cloneDoesNotCrash() {
		if (floatval(PHP_VERSION) < 5.3) {
			$this->markTestSkipped(
				'Cloning SplObjectStorage instances would crash in PHP < 5.3.0.'
			);
		}

		clone $this->fixture;
	}

	/**
	 * @test
	 */
	public function purgeCurrentForClonedListNotRemovesItemFromOriginalList() {
		if (floatval(PHP_VERSION) < 5.3) {
			$this->markTestSkipped(
				'Cloning SplObjectStorage instances would crash in PHP < 5.3.0.'
			);
		}

		$this->addModelsToFixture();

		$clonedList = clone($this->fixture);
		$clonedList->rewind();
		$clonedList->purgeCurrent();

		$this->assertSame(
			1,
			$this->fixture->count()
		);

		$clonedList->__destruct();
	}

	/**
	 * @test
	 */
	public function purgeCurrentForClonedListNotRemovesUidFromOriginalList() {
		if (floatval(PHP_VERSION) < 5.3) {
			$this->markTestSkipped(
				'Cloning SplObjectStorage instances would crash in PHP < 5.3.0.'
			);
		}

		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$model->setUid(1);
		$this->fixture->add($model);
		$this->modelStorage[] = $model;

		$clonedList = clone($this->fixture);
		$clonedList->rewind();
		$clonedList->purgeCurrent();

		$this->assertSame(
			'1',
			$this->fixture->getUids()
		);

		$clonedList->__destruct();
	}


	///////////////////////////////////
	// Tests concerning sortBySorting
	///////////////////////////////////

	/**
	 * @test
	 */
	public function sortBySortingMovesItemWithHigherSortingValueAfterItemWithLowerSortingValue() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingChildModel();
		$model1->setSorting(2);
		$this->fixture->add($model1);

		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingChildModel();
		$model2->setSorting(1);
		$this->fixture->add($model2);

		$this->fixture->sortBySorting();

		$this->assertSame(
			$model2,
			$this->fixture->first()
		);
	}


	////////////////////////
	// Tests concerning at
	////////////////////////

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function atForNegativePositionThrowsException() {
		$this->fixture->at(-1);
	}

	/**
	 * @test
	 */
	public function atForPositionZeroWithEmptyListReturnsNull() {
		$this->assertNull(
			$this->fixture->at(0)
		);
	}

	/**
	 * @test
	 */
	public function atForPositionOneWithEmptyListReturnsNull() {
		$this->assertNull(
			$this->fixture->at(1)
		);
	}

	/**
	 * @test
	 */
	public function atForPositionZeroWithOneItemListReturnsItem() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$this->assertSame(
			$model,
			$this->fixture->at(0)
		);
	}

	/**
	 * @test
	 */
	public function atForPositionOneWithOneItemListReturnsNull() {
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());

		$this->assertNull(
			$this->fixture->at(1)
		);
	}

	/**
	 * @test
	 */
	public function atForPositionZeroWithTwoItemListReturnsFirstItem() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model1);
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());

		$this->assertSame(
			$model1,
			$this->fixture->at(0)
		);
	}

	/**
	 * @test
	 */
	public function atForPositionOneWithTwoItemListReturnsSecondItem() {
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model2);

		$this->assertSame(
			$model2,
			$this->fixture->at(1)
		);
	}

	/**
	 * @test
	 */
	public function atForPositionTwoWithTwoItemListReturnsNull() {
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());

		$this->assertNull(
			$this->fixture->at(2)
		);
	}


	/////////////////////////////
	// Tests concerning inRange
	/////////////////////////////

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function inRangeWithNegativeStartThrowsException() {
		$this->fixture->inRange(-1, 1);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function inRangeWithNegativeLengthThrowsException() {
		$this->fixture->inRange(1, -1);
	}

	/**
	 * @test
	 */
	public function inRangeWithZeroLengthReturnsEmptyList() {
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());

		$this->assertTrue(
			$this->fixture->inRange(1, 0)->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function inRangeCanReturnOneElementFromStartOfList() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());

		$result = $this->fixture->inRange(0, 1);
		$this->assertSame(
			1,
			$result->count()
		);
		$this->assertSame(
			$model,
			$result->first()
		);
	}

	/**
	 * @test
	 */
	public function inRangeCanReturnOneElementAfterStartOfList() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());
		$this->fixture->add($model);

		$result = $this->fixture->inRange(1, 1);
		$this->assertSame(
			1,
			$result->count()
		);
		$this->assertSame(
			$model,
			$result->first()
		);
	}

	/**
	 * @test
	 */
	public function inRangeCanReturnTwoElementsFromStartOfList() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model2);

		$this->assertSame(
			2,
			$this->fixture->inRange(0, 2)->count()
		);
	}

	/**
	 * @test
	 */
	public function inRangeWithStartAfterListEndReturnsEmptyList() {
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());

		$this->assertTrue(
			$this->fixture->inRange(1, 1)->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function inRangeWithRangeCrossingListEndReturnsElementUpToListEnd() {
		$this->fixture->add(new Tx_Oelib_Tests_Unit_Fixtures_TestingModel());
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$result = $this->fixture->inRange(1, 2);

		$this->assertSame(
			1,
			$result->count()
		);
		$this->assertSame(
			$model,
			$result->first()
		);
	}


	/*
	/* Tests concerning toArray
	 */

	/**
	 * @test
	 */
	public function toArrayForNoElementsReturnsEmptyArray() {
		$this->assertSame(
			array(),
			$this->fixture->toArray()
		);
	}

	/**
	 * @test
	 */
	public function toArrayWithOneElementReturnsArrayWithElement() {
		$model = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model);

		$this->assertSame(
			array($model),
			$this->fixture->toArray()
		);
	}

	/**
	 * @test
	 */
	public function toArrayWithTwoElementsReturnsArrayWithBothElementsInAddingOrder() {
		$model1 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model1);
		$model2 = new Tx_Oelib_Tests_Unit_Fixtures_TestingModel();
		$this->fixture->add($model2);

		$this->assertSame(
			array($model1, $model2),
			$this->fixture->toArray()
		);
	}
}
?>