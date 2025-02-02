<?php
namespace Stenfrank\UBL21dian\HTTP\DOM\Request;
use Stenfrank\UBL21dian\HTTP\DOM\Response\SendBillAsyncResponseDOM;

/**
 * Class SendBillAsyncRequestDOM
 * @package Stenfrank\UBL21dian\HTTP\DOM\Request
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class SendBillAsyncRequestDOM extends BasicRequestDOM
{

    /**
     * Action.
     *
     * @var string
     */
    public $Action = 'http://wcf.dian.colombia/IWcfDianCustomerServices/SendBillAsync';

    /**
     * Required properties.
     *
     * @var array
     */
    protected $requiredProperties = [
        'fileName',
        'contentFile',
    ];


    /**
     *  Se encarga de llenar el XML con los datos
     */
    protected function build()
    {
        $elementFile = $this->domTemplate->getElementsByTagName("fileName")->item(0);
        $elementFile->nodeValue = $this->fileName;
        $this->domTemplate->getElementsByTagName("contentFile")->item(0)->nodeValue = $this->contentFile;
    }

    /**
     * Devuelve la clase response que va a tener el request
     * @return mixed
     */
    public function getClassResponse()
    {
        return SendBillAsyncResponseDOM::class;
    }


    /**
     * Devuelve el nombre de la plantilla XML
     * @return String
     */
    public function getNameTemplate(): string
    {
        return "SendBillAsync";
    }
}