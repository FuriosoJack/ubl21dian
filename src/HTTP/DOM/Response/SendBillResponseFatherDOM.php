<?php


namespace Stenfrank\UBL21dian\HTTP\DOM\Response;

/**
 * Class SendBillResponseFather
 * @package Stenfrank\UBL21dian\HTTP\DOM\Response
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class SendBillResponseFatherDOM extends BasicResponseDOM
{

    /**
     * @return mixed
     * @throws \Stenfrank\UBL21dian\Exceptions\QueryNotFountException
     */
    public function getDocumentKey()
    {
        return $this->getQuery("//b:ErrorMessageList/c:XmlParamsResponseTrackId/c:DocumentKey")->nodeValue;
    }

    /**
     * @return mixed
     * @throws \Stenfrank\UBL21dian\Exceptions\QueryNotFountException
     */
    public function getProcessedMessage()
    {
        return $this->getQuery("//b:ErrorMessageList/c:XmlParamsResponseTrackId/c:ProcessedMessage")->nodeValue;
    }

    /**
     * @return bool
     * @throws \Stenfrank\UBL21dian\Exceptions\QueryNotFountException
     */
    public function getSuccess()
    {

        $nodeValue = $this->getQuery("//b:ErrorMessageList/c:XmlParamsResponseTrackId/c:Success")->nodeValue;

        if($nodeValue == "false"){
            return false;
        }
        return true;

    }

    /**
     * @return mixed
     * @throws \Stenfrank\UBL21dian\Exceptions\QueryNotFountException
     */
    public function getXmlFileName()
    {
        return $this->getQuery("//b:ErrorMessageList/c:XmlParamsResponseTrackId/c:XmlFileName")->nodeValue;
    }

    /**
     * @return mixed
     * @throws \Stenfrank\UBL21dian\Exceptions\QueryNotFountException
     */
    public function getZipKey()
    {
        return $this->getQuery("//b:ZipKey")->nodeValue;
    }

    protected function registerNS($namespacese = array())
    {

        $namespaces = [
            "b" => "http://schemas.datacontract.org/2004/07/UploadDocumentResponse",
            "c" => "http://schemas.datacontract.org/2004/07/XmlParamsResponseTrackId",
            "i" => "http://www.w3.org/2001/XMLSchema-instance"
        ];
        parent::registerNS($namespaces); // TODO: Change the autogenerated stub

    }

}