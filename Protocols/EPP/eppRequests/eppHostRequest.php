<?php
namespace Metaregistrar\EPP;

class eppHostRequest extends eppRequest {

    /**
     * HostObject object to add namespaces to
     * @var \DomElement
     */
    public $checkobject = null;
    public $hostobject = null;
    public $extentionobject = null;

    function __construct($type, $subProduct = 'dotCOM') {
        parent::__construct();
        $this->checkobject = $this->createElement($type);
        $this->hostobject = $this->createElement('host:'.$type);
        if (!$this->rootNamespaces()) {
            $this->hostobject->setAttribute('xmlns:host','urn:ietf:params:xml:ns:host-1.0');
        }
        $this->checkobject->appendChild($this->hostobject);
        $this->getCommand()->appendChild($this->checkobject);

        //Extention
        if($type == 'check'){
            $this->extentionobject = $this->createElement('extension');
            $namestoreExt = $this->createElement('namestoreExt:namestoreExt');
            $namestoreExt->setAttribute('xmlns:namestoreExt','http://www.verisign-grs.com/epp/namestoreExt-1.1');
            //$namestoreExt->setAttribute('xsi:schemaLocation','http://www.verisign-grs.com/epp/namestoreExt-1.1 namestoreExt-1.1.xsd');
            $namestoreExt->appendChild($this->createElement('namestoreExt:subProduct', $subProduct));
            $this->extentionobject->appendChild($namestoreExt);
            $this->getCommand()->appendChild($this->extentionobject);
        }
    }
}
