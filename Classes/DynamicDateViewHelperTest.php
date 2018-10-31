<?php
namespace Stepin\PpwSiCommunity\Tests\Unit\ViewHelpers\Format;

/*
 * This file is part of the TYPO3 CMS project.
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
use Stepin\PpwSiCommunity\ViewHelpers\Format\DynamicDateViewHelper;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Test case.
 *
 * @author Oliver Klee <oliver.klee@ppw.de>
 */
class DynamicDateViewHelperTest extends UnitTestCase
{
    /**
     * @var bool
     */
    protected $backupGlobals = false;

    /**
     * @var DynamicDateViewHelper|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface
     */
    protected $subject = null;

    /**
     * @var RenderingContext|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $renderingContext = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getAccessibleMock(DynamicDateViewHelper::class, ['renderChildren']);
        /** @var RenderingContext $renderingContext */
        $this->renderingContext = $this->getMock(RenderingContext::class);
        $this->subject->_set('renderingContext', $this->renderingContext);
    }

    /**
     * @test
     */
    public function classIsViewHelper()
    {
        self::assertInstanceOf(AbstractViewHelper::class, $this->subject);
    }

    /**
     * @test
     */
    public function classIsCompilable()
    {
        self::assertInstanceOf(CompilableInterface::class, $this->subject);
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderForNullChildrenThrowsException()
    {
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue(null));

        $this->subject->render();
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderForEmptyStringChildrenThrowsException()
    {
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue(''));

        $this->subject->render();
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderForDateStringChildrenThrowsException()
    {
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue('1975-04-02'));

        $this->subject->render();
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderForIntegerTimestampChildrenThrowsException()
    {
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue(1459513954));

        $this->subject->render();
    }

    /**
     * @test
     */
    public function renderByDefaultUsesGermanDateAndTimeFormat()
    {
        $date = new \DateTime('1980-12-07 14:37');
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue($date));

        $result = $this->subject->render();

        self::assertContains('07.12.1980 14:37', $result);
    }

    /**
     * @test
     */
    public function renderUsesProvidedDateAndTimeFormatForVisibleDate()
    {
        $date = new \DateTime('1980-12-07 14:37');
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue($date));

        $result = $this->subject->render('Y-m-d g:ia');

        self::assertContains('1980-12-07 2:37pm', $result);
    }

    /**
     * @test
     */
    public function renderAddsTimeAgoCssClass()
    {
        $date = new \DateTime('1980-12-07 14:37');
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue($date));

        $result = $this->subject->render('Y-m-d g:ia');

        self::assertContains('class="js-time-ago"', $result);
    }

    /**
     * @test
     */
    public function renderUsesProvidedDateAndTimeFormatForTimeElementDate()
    {
        $date = new \DateTime('1980-12-07 14:37');
        $this->subject->expects(self::once())->method('renderChildren')->will(self::returnValue($date));

        $result = $this->subject->render('Y-m-d g:ia');

        self::assertContains('<time datetime="1980-12-07T14:37"', $result);
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderStaticForNullChildrenThrowsException()
    {
        $renderChildrenClosure = function () {
            return null;
        };

        DynamicDateViewHelper::renderStatic([], $renderChildrenClosure, $this->renderingContext);
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderStaticForEmptyStringChildrenThrowsException()
    {
        $renderChildrenClosure = function () {
            return '';
        };

        DynamicDateViewHelper::renderStatic([], $renderChildrenClosure, $this->renderingContext);
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderStaticForDateStringChildrenThrowsException()
    {
        $renderChildrenClosure = function () {
            return '1975-04-02';
        };

        DynamicDateViewHelper::renderStatic([], $renderChildrenClosure, $this->renderingContext);
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function renderStaticForIntegerTimestampChildrenThrowsException()
    {
        $renderChildrenClosure = function () {
            return 1459513954;
        };

        DynamicDateViewHelper::renderStatic([], $renderChildrenClosure, $this->renderingContext);
    }

    /**
     * @test
     */
    public function renderStaticByDefaultUsesGermanDateAndTimeFormat()
    {
        $renderChildrenClosure = function () {
            return new \DateTime('1980-12-07 14:37');
        };

        $result = DynamicDateViewHelper::renderStatic([], $renderChildrenClosure, $this->renderingContext);

        self::assertContains('07.12.1980 14:37', $result);
    }

    /**
     * @test
     */
    public function renderStaticUsesProvidedDateAndTimeFormat()
    {
        $renderChildrenClosure = function () {
            return new \DateTime('1980-12-07 14:37');
        };

        $result = DynamicDateViewHelper::renderStatic(
            ['format' => 'Y-m-d g:ia'],
            $renderChildrenClosure,
            $this->renderingContext
        );

        self::assertContains('1980-12-07 2:37pm', $result);
    }
}
