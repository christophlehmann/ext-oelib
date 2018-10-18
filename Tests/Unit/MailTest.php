<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Test case.
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_Tests_Unit_MailTest extends \Tx_Phpunit_TestCase
{
    /**
     * @var \Tx_Oelib_Mail
     */
    private $subject = null;

    protected function setUp()
    {
        $this->subject = new \Tx_Oelib_Mail();
    }

    /*
     * Tests regarding setting and getting the sender.
     */

    /**
     * @test
     */
    public function getSenderInitiallyReturnsNull()
    {
        self::assertNull(
            $this->subject->getSender()
        );
    }

    /**
     * @test
     */
    public function getSenderForNonEmptySenderReturnsSender()
    {
        $sender = new \Tx_Oelib_Tests_Unit_Fixtures_TestingMailRole(
            'John Doe',
            'foo@bar.com'
        );

        $this->subject->setSender($sender);

        self::assertSame(
            $sender,
            $this->subject->getSender()
        );
    }

    /**
     * @test
     */
    public function hasSenderInitiallyReturnsFalse()
    {
        self::assertFalse(
            $this->subject->hasSender()
        );
    }

    /**
     * @test
     */
    public function hasSenderWithSenderReturnsTrue()
    {
        $sender = new \Tx_Oelib_Tests_Unit_Fixtures_TestingMailRole(
            'John Doe',
            'foo@bar.com'
        );

        $this->subject->setSender($sender);

        self::assertTrue(
            $this->subject->hasSender()
        );
    }

    /**
     * @test
     */
    public function getReplyToInitiallyReturnsNull()
    {
        self::assertNull($this->subject->getReplyTo());
    }

    /**
     * @test
     */
    public function getReplyToForNonEmptyReplyToReturnsReplyTo()
    {
        $sender = new \Tx_Oelib_Tests_Unit_Fixtures_TestingMailRole(
            'John Doe',
            'foo@bar.com'
        );

        $this->subject->setReplyTo($sender);

        self::assertSame($sender, $this->subject->getReplyTo());
    }

    /**
     * @test
     */
    public function hasReplyToInitiallyReturnsFalse()
    {
        self::assertFalse($this->subject->hasReplyTo());
    }

    /**
     * @test
     */
    public function hasReplyToWithReplyToReturnsTrue()
    {
        $sender = new \Tx_Oelib_Tests_Unit_Fixtures_TestingMailRole(
            'John Doe',
            'foo@bar.com'
        );

        $this->subject->setReplyTo($sender);

        self::assertTrue($this->subject->hasReplyTo());
    }

    /*
     * Tests regarding adding and getting the recipients.
     */

    /**
     * @test
     */
    public function getRecipientsInitiallyReturnsEmptyArray()
    {
        self::assertSame(
            [],
            $this->subject->getRecipients()
        );
    }

    /**
     * @test
     */
    public function getRecipientsWithOneRecipientReturnsOneRecipient()
    {
        $recipient = new \Tx_Oelib_Tests_Unit_Fixtures_TestingMailRole(
            'John Doe',
            'foo@bar.com'
        );
        $this->subject->addRecipient($recipient);

        self::assertSame(
            [$recipient],
            $this->subject->getRecipients()
        );
    }

    /**
     * @test
     */
    public function getRecipientsWithTwoRecipientsReturnsTwoRecipients()
    {
        $recipient1 = new \Tx_Oelib_Tests_Unit_Fixtures_TestingMailRole(
            'John Doe',
            'foo@bar.com'
        );
        $recipient2 = new \Tx_Oelib_Tests_Unit_Fixtures_TestingMailRole(
            'John Doe',
            'foo@bar.com'
        );
        $this->subject->addRecipient($recipient1);
        $this->subject->addRecipient($recipient2);

        self::assertSame(
            [$recipient1, $recipient2],
            $this->subject->getRecipients()
        );
    }

    /*
     * Tests regarding setting and getting the subject.
     */

    /**
     * @test
     */
    public function getSubjectInitiallyReturnsEmptyString()
    {
        self::assertSame(
            '',
            $this->subject->getSubject()
        );
    }

    /**
     * @test
     */
    public function getSubjectWithNonEmptySubjectReturnsSubject()
    {
        $this->subject->setSubject('test subject');

        self::assertSame(
            'test subject',
            $this->subject->getSubject()
        );
    }

    /**
     * @test
     */
    public function setSubjectWithEmptySubjectThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$subject must not be empty.'
        );

        $this->subject->setSubject('');
    }

    /**
     * @test
     */
    public function setSubjectWithSubjectContainingCarriageReturnThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$subject must not contain any line breaks or carriage returns.'
        );

        $this->subject->setSubject('test ' . CR . ' subject');
    }

    /**
     * @test
     */
    public function setSubjectWithSubjectContainingLinefeedThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$subject must not contain any line breaks or carriage returns.'
        );

        $this->subject->setSubject('test ' . LF . ' subject');
    }

    /**
     * @test
     */
    public function setSubjectWithSubjectContainingCarriageReturnLinefeedThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$subject must not contain any line breaks or carriage returns.'
        );

        $this->subject->setSubject('test ' . CRLF . ' subject');
    }

    /*
     * Tests regarding setting and getting the message.
     */

    /**
     * @test
     */
    public function getMessageInitiallyReturnsEmptyString()
    {
        self::assertSame(
            '',
            $this->subject->getMessage()
        );
    }

    /**
     * @test
     */
    public function getMessageWithNonEmptyMessageReturnsMessage()
    {
        $this->subject->setMessage('test message');

        self::assertSame(
            'test message',
            $this->subject->getMessage()
        );
    }

    /**
     * @test
     */
    public function setMessageWithEmptyMessageThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$message must not be empty.'
        );

        $this->subject->setMessage('');
    }

    /**
     * @test
     */
    public function hasMessageInitiallyReturnsFalse()
    {
        self::assertFalse(
            $this->subject->hasMessage()
        );
    }

    /**
     * @test
     */
    public function hasMessageWithMessageReturnsTrue()
    {
        $this->subject->setMessage('test');

        self::assertTrue(
            $this->subject->hasMessage()
        );
    }

    /*
     * Tests regarding setting and getting the HTML message.
     */

    /**
     * @test
     */
    public function getHTMLMessageInitiallyReturnsEmptyString()
    {
        self::assertSame(
            '',
            $this->subject->getHTMLMessage()
        );
    }

    /**
     * @test
     */
    public function getHTMLMessageWithNonEmptyMessageReturnsMessage()
    {
        $this->subject->setHTMLMessage('test message');

        self::assertSame(
            'test message',
            $this->subject->getHTMLMessage()
        );
    }

    /**
     * @test
     */
    public function setHTMLMessageWithEmptyMessageThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$message must not be empty.'
        );

        $this->subject->setHTMLMessage('');
    }

    /**
     * @test
     */
    public function hasHTMLMessageInitiallyReturnsFalse()
    {
        self::assertFalse(
            $this->subject->hasHTMLMessage()
        );
    }

    /**
     * @test
     */
    public function hasHTMLMessageWithHTMLMessageReturnsTrue()
    {
        $this->subject->setHTMLMessage('<p>test</p>');

        self::assertTrue(
            $this->subject->hasHTMLMessage()
        );
    }

    /*
     * Tests regarding adding and getting attachments.
     */

    /**
     * @test
     */
    public function getAttachmentsInitiallyReturnsEmptyArray()
    {
        self::assertSame(
            [],
            $this->subject->getAttachments()
        );
    }

    /**
     * @test
     */
    public function getAttachmentsWithOneAttachmentReturnsOneAttachment()
    {
        $attachment = new \Tx_Oelib_Attachment();
        $attachment->setFileName('test.txt');
        $attachment->setContentType('text/plain');
        $attachment->setContent('Test');
        $this->subject->addAttachment($attachment);

        self::assertSame(
            [$attachment],
            $this->subject->getAttachments()
        );
    }

    /**
     * @test
     */
    public function getAttachmentsWithTwoAttachmentsReturnsTwoAttachments()
    {
        $attachment = new \Tx_Oelib_Attachment();
        $attachment->setFileName('test.txt');
        $attachment->setContentType('text/plain');
        $attachment->setContent('Test');
        $this->subject->addAttachment($attachment);

        $otherAttachment = new \Tx_Oelib_Attachment();
        $otherAttachment->setFileName('second_test.txt');
        $otherAttachment->setContentType('text/plain');
        $otherAttachment->setContent('Second Test');
        $this->subject->addAttachment($otherAttachment);

        self::assertSame(
            [$attachment, $otherAttachment],
            $this->subject->getAttachments()
        );
    }

    /*
     * Tests regarding setting and getting the CSS file.
     */

    /**
     * @test
     */
    public function setCssFileForNoCssFileGivenDoesNotSetCssFile()
    {
        $this->subject->setCssFile('');

        self::assertFalse(
            $this->subject->hasCssFile()
        );
    }

    /**
     * @test
     */
    public function setCssFileForStringGivenWhichIsNoFileDoesNotSetCssFile()
    {
        $this->subject->setCssFile('foo');

        self::assertFalse(
            $this->subject->hasCssFile()
        );
    }

    /**
     * @test
     */
    public function setCssFileForGivenCssFileWithAbsolutePathSetsCssFile()
    {
        $this->subject->setCssFile(ExtensionManagementUtility::extPath('oelib') . 'Tests/Unit/Fixtures/test.css');

        self::assertTrue(
            $this->subject->hasCssFile()
        );
    }

    /**
     * @test
     */
    public function setCssFileForGivenCssFileWithAbsoluteExtPathSetsCssFile()
    {
        $this->subject->setCssFile('EXT:oelib/Tests/Unit/Fixtures/test.css');

        self::assertTrue(
            $this->subject->hasCssFile()
        );
    }

    /**
     * @test
     */
    public function setCssFileForGivenCssFileStoresContentsOfCssFile()
    {
        $this->subject->setCssFile('EXT:oelib/Tests/Unit/Fixtures/test.css');

        self::assertContains(
            'h3',
            $this->subject->getCssFile()
        );
    }

    /**
     * @test
     */
    public function setCssFileForSetCssFileAndThenGivenEmptyStringClearsStoredCssFileData()
    {
        $this->subject->setCssFile('EXT:oelib/Tests/Unit/Fixtures/test.css');
        $this->subject->setCssFile('');

        self::assertFalse(
            $this->subject->hasCssFile()
        );
    }

    /**
     * @test
     */
    public function setCssFileForSetCssFileAndThenGivenNewCssFileRemovesOldCssDataFromStorage()
    {
        $this->subject->setCssFile('EXT:oelib/Tests/Unit/Fixtures/test.css');
        $this->subject->setCssFile('EXT:oelib/Tests/Unit/Fixtures/test_2.css');

        self::assertNotContains(
            'h3',
            $this->subject->getCssFile()
        );
    }

    /**
     * @test
     */
    public function setCssFileForSetCssFileAndThenGivenNewCssFileStoresNewCssData()
    {
        $this->subject->setCssFile('EXT:oelib/Tests/Unit/Fixtures/test.css');
        $this->subject->setCssFile('EXT:oelib/Tests/Unit/Fixtures/test_2.css');

        self::assertContains(
            'h4',
            $this->subject->getCssFile()
        );
    }

    /*
     * Tests concerning the mogrification of the HTML Messages and the CSS file
     */

    /**
     * @test
     */
    public function setHtmlMessageWithNoCssFileStoredOnlyStoresTheHtmlMessage()
    {
        $htmlMessage =
            '<html>' .
            '<head><title>foo</title></head>' .
            '<body><h3>Bar</h3></body>' .
            '</html>';
        $this->subject->setHTMLMessage($htmlMessage);

        self::assertSame(
            $htmlMessage,
            $this->subject->getHTMLMessage()
        );
    }

    /**
     * @test
     */
    public function setHtmlMessageWithCssFileStoredStoresAttributesFromCssInHtmlMessage()
    {
        $this->subject->setCssFile(ExtensionManagementUtility::extPath('oelib') . 'Tests/Unit/Fixtures/test.css');
        $this->subject->setHTMLMessage(
            '<!DOCTYPE html>' . LF .
            '<html>' .
            '<head><title>foo</title></head>' . LF .
            '<body><h3>Bar</h3></body>' .
            '</html>'
        );

        self::assertContains(
            '<h3 style="font-weight: bold;">Bar</h3>',
            $this->subject->getHTMLMessage()
        );
    }

    /*
     * Tests concerning the return path
     */

    /**
     * @test
     */
    public function getReturnPathInitiallyReturnsAnEmptyString()
    {
        self::assertSame(
            '',
            $this->subject->getReturnPath()
        );
    }

    /**
     * @test
     */
    public function setReturnPathSetsMemberVariableReturnPath()
    {
        $this->subject->setReturnPath('foo@bar.com');

        self::assertSame(
            'foo@bar.com',
            $this->subject->getReturnPath()
        );
    }
}
