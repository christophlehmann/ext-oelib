<?php
namespace Stepin\PpwSiCommunity\Tests\Functional;

/*
 * This file is part of the ppw_si_community TYPO3 extension.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use OliverKlee\Phpunit\Traits\FunctionalTestCaseInterface;
use OliverKlee\Phpunit\Traits\FunctionalTestCaseTrait;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * This class serves as the base class for (relatively) light-weight functional tests that work on the same TYPO3
 * instance (unlike the functional tests of the TYPO3 Core).
 *
 * When using this class, make sure to always call parent::setUp and parent::tearDown if you have your own setUp or
 * tearDown.
 *
 * @author Oliver Klee <oliver.klee@ppw.de>
 */
abstract class FunctionalTestCase extends UnitTestCase implements FunctionalTestCaseInterface
{
    use FunctionalTestCaseTrait;

    /**
     * @var bool
     */
    protected $backupGlobals = false;

    protected function setUp()
    {
        $this->setUpFunctionalTestCase('tx_ppwsicommunity');
    }

    protected function tearDown()
    {
        $this->tearDownFunctionalTestCase();
    }
}
