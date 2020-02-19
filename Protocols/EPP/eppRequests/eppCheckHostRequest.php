<?php
namespace Metaregistrar\EPP;

/*
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <command>
    <check>
      <host:check xmlns:host="urn:ietf:params:xml:ns:host-1.0">
        <host:name>ns1.example.com</host:name>
        <host:name>ns2.example.com</host:name>
        <host:name>ns3.example.com</host:name>
      </host:check>
    </check>
	<extension>
		<namestoreExt:namestoreExt xmlns:namestoreExt="http://www.verisign-grs.com/epp/namestoreExt-1.1" xsi:schemaLocation="http://www.verisign-grs.com/epp/namestoreExt-1.1 namestoreExt-1.1.xsd">
			<namestoreExt:subProduct>dotCOM</namestoreExt:subProduct>
		</namestoreExt:namestoreExt>
	</extension>
    <clTRID>ABC-12345</clTRID>
  </command>
</epp>
*/


class eppCheckHostRequest extends eppHostRequest {

    function __construct($checkrequest, $namespacesinroot = true, $subProduct = 'dotCOM') {
        $this->setNamespacesinroot($namespacesinroot);
        parent::__construct(eppRequest::TYPE_CHECK, $subProduct);

        if ($checkrequest instanceof eppHost) {
            $this->setHosts(array($checkrequest));
        } else {
            if (is_array($checkrequest)) {
                //if ($checkrequest[0] instanceof eppHost) { WHY DID I PUT THIS IN?
                $this->setHosts($checkrequest);
                //}
            }
        }
        $this->addSessionId();
    }

    function __destruct() {
        parent::__destruct();
    }

    public function setHosts($hosts) {
        #
        # Domain check structure
        #
        foreach ($hosts as $host) {
            if ($host instanceof eppHost) {
                if (strlen($host->getHostname()) > 0) {
                    $this->hostobject->appendChild($this->createElement('host:name', $host->getHostname()));
                } else {
                    throw new eppException("Empty hostobject on checkRequest creation");
                }
            } else {
                if (strlen($host) > 0) {
                    $this->hostobject->appendChild($this->createElement('host:name', $host));
                } else {
                    throw new eppException("Empty hostname on checkRequest creation");
                }
            }
        }
    }
}
