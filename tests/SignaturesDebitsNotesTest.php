<?php

namespace Stenfrank\Tests;

use DOMDocument;
use Stenfrank\UBL21dian\XAdES\SignDebitNote;

/**
 * Signatures Notes Credits.
 */
class SignaturesDebitsNotesTest extends TestCase
{


    /**
     * Dom de archivo de la nota sin firmar
     * @var
     */
    private $domDebiNoteUnsigned;

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->domDebiNoteUnsigned = new DOMDocument();
        $this->domDebiNoteUnsigned->load(__DIR__."/resources/debitnotes/debitnote_unsigned_dian_v2.xml");
    }

    /**
     * @return mixedÇ
     */
    private function getStringDebitnoteUnsigned()
    {
        return $this->domDebiNoteUnsigned->saveXML();
    }

    /** @test */
    public function it_generates_signature_XAdES_sha1()
    {

        $signCreditNote = new SignDebitNote($this->pathCert, $this->passwordCert, $this->getStringDebitnoteUnsigned(), SignDebitNote::ALGO_SHA1);

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha1"', $signCreditNote->xml);

        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_sha256()
    {

        $signCreditNote = new SignDebitNote($this->pathCert, $this->passwordCert, $this->getStringDebitnoteUnsigned());

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"', $signCreditNote->xml);

        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_sha512()
    {


        $signCreditNote = new SignDebitNote($this->pathCert, $this->passwordCert, $this->getStringDebitnoteUnsigned(), SignDebitNote::ALGO_SHA512);

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha512"', $signCreditNote->xml);

        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_and_software_security_code()
    {


        $signCreditNote = new SignDebitNote($this->pathCert, $this->passwordCert);

        // Software security code
        $signCreditNote->softwareID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $signCreditNote->pin = '12345';

        // Sign
        $signCreditNote->sign($this->getStringDebitnoteUnsigned());

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('31e48a81d2d90d1cd81d386d9c4fc5c0030ef582b401b3825bcd0d1d17e1d6441b5b7b95e10d11d5c65861daa2bada67', $signCreditNote->xml);
        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_and_calculate_cude()
    {

        $signCreditNote = new SignDebitNote($this->pathCert, $this->passwordCert);

        // CUDE
        $signCreditNote->pin = 'xxxxx';

        // Sign
        $signCreditNote->sign($this->getStringDebitnoteUnsigned());

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('17ef520059982ca6443c543a7f3b2af2c836af88bf7479e2eb4cf538ef1b2957ce77a3ba3bff80df3c8aef4dabebdfed', $signCreditNote->xml);
        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }
}