<?php

namespace Stenfrank\Tests;

use DOMDocument;
use Stenfrank\UBL21dian\XAdES\SignCreditNote;

/**
 * Signatures Notes Credits.
 */
class SignaturesNotesCreditsTest extends TestCase
{

    /**
     * @var
     */
    private $domCreditNoteUnsigned;

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->domCreditNoteUnsigned = new DOMDocument();
        $this->domCreditNoteUnsigned->load(__DIR__. "/resources/creditnotes/creditnote_unsigned_dian_v2.xml");

    }

    /**
     * @return mixed
     */
    public function getStringNotecreditUnsigned()
    {
        return $this->domCreditNoteUnsigned->saveXML();
    }


    /** @test */
    public function it_generates_signature_XAdES_sha1()
    {


        $signCreditNote = new SignCreditNote($this->pathCert, $this->passwordCert, $this->getStringNotecreditUnsigned(), SignCreditNote::ALGO_SHA1);

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha1"', $signCreditNote->xml);

        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_sha256()
    {


        $signCreditNote = new SignCreditNote($this->pathCert, $this->passwordCert, $this->getStringNotecreditUnsigned());

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"', $signCreditNote->xml);

        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_sha512()
    {

        $signCreditNote = new SignCreditNote($this->pathCert, $this->passwordCert, $this->getStringNotecreditUnsigned(), SignCreditNote::ALGO_SHA512);

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha512"', $signCreditNote->xml);

        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_and_software_security_code()
    {

        $signCreditNote = new SignCreditNote($this->pathCert, $this->passwordCert);

        // Software security code
        $signCreditNote->softwareID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $signCreditNote->pin = '12345';

        // Sign
        $signCreditNote->sign($this->getStringNotecreditUnsigned());

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('eb7ff57a48c4bc5840e846382346e2a5546a3903c150fdf34bec4e7e8fb29c6437ef9c99575f0f78f80f7dfcc97d3e02', $signCreditNote->xml);
        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }

    /** @test */
    public function it_generates_signature_XAdES_and_calculate_cude()
    {


        $signCreditNote = new SignCreditNote($this->pathCert, $this->passwordCert);

        // CUDE
        $signCreditNote->pin = 'xxxxx';

        // Sign
        $signCreditNote->sign($this->getStringNotecreditUnsigned());

        $domDocumentValidate = new DOMDocument();
        $domDocumentValidate->validateOnParse = true;

        $this->assertContains('60a024139af65a986830609895271ad17f4d5d51effc4d8ad9db09096bce5786bba43003fd47211d72417866bc61642c', $signCreditNote->xml);
        $this->assertSame(true, $domDocumentValidate->loadXML($signCreditNote->xml));
    }
}
