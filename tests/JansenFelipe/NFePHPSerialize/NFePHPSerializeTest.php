<?php
namespace JansenFelipe\NFePHPSerialize;

use JansenFelipe\NFePHPSerialize\NfeProc\NFe\InfNFe\Det\Det;
use JansenFelipe\NFePHPSerialize\NfeProc\NFe\InfNFe\Det\Imposto\Imposto;
use JansenFelipe\NFePHPSerialize\NfeProc\NFe\InfNFe\Det\Prod;
use JansenFelipe\NFePHPSerialize\NfeProc\NFe\InfNFe\InfNFe;
use JansenFelipe\NFePHPSerialize\NfeProc\NFe\NFe;
use JansenFelipe\NFePHPSerialize\NfeProc\NFe\Signature;
use JansenFelipe\NFePHPSerialize\NfeProc\NfeProc;
use JansenFelipe\NFePHPSerialize\NfeProc\ProtNFe\InfProt;
use JansenFelipe\NFePHPSerialize\NfeProc\ProtNFe\ProtNFe;
use PHPUnit_Framework_TestCase;

class NFePHPSerializeTest extends PHPUnit_Framework_TestCase {

    public function testXml2Object() {

        $xml = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'nfe.xml');

        /*
         * NfeProc
         */
        $nfeProc = new NfeProc();
        $nfeProc = NFePHPSerialize::xml2Object($xml);

        $this->assertEquals($nfeProc->versao, "2.00");

        /*
         * NFe
         */
        $NFe = new NFe();
        $NFe = $nfeProc->NFe;

        /*
         * InfNFe
         */
        $infNFe = new InfNFe();
        $infNFe = $NFe->infNFe;

        $this->assertEquals($infNFe->Id, "NFe31141019592641000372550020009458071111021102");
        $this->assertEquals($infNFe->versao, "2.00");
        $this->assertEquals(count($infNFe->dets), 10);

        /*
         * Det (Só o primeiro)
         */
        $det = new Det();
        $det = $infNFe->dets[0];

        $this->assertEquals($det->nItem, "1");

        /*
         * Prod
         */
        $prod = new Prod();
        $prod = $det->prod;

        $this->assertEquals($prod->cProd, "220030");
        $this->assertEquals($prod->cEAN, "7896036096697");
        $this->assertEquals($prod->xProd, "EXTRATO DE TOMATE ELEFANTE TP 1,1KG");
        $this->assertEquals($prod->NCM, "20029090");
        $this->assertEquals($prod->CFOP, "5405");
        $this->assertEquals($prod->uCom, "UN");
        $this->assertEquals($prod->qCom, "10.0000");
        $this->assertEquals($prod->vUnCom, "8.0000000000");
        $this->assertEquals($prod->vProd, "80.00");
        $this->assertEquals($prod->cEANTrib, "7896036096697");
        $this->assertEquals($prod->uTrib, "UN");
        $this->assertEquals($prod->qTrib, "10.0000");
        $this->assertEquals($prod->vUnTrib, "8.0000000000");
        $this->assertEquals($prod->indTot, "1");
        $this->assertEquals($prod->xPed, "54001166");
        $this->assertEquals($prod->nItemPed, "1");

        /*
         * Imposto
         */
        $imposto = new Imposto();
        $imposto = $det->imposto;

        /*
         * Signature
         */
        $signature = new Signature();
        $signature = $NFe->Signature;

        $this->assertEquals($signature->SignatureValue, "NnMpo3MId9+7XolRsA1KbkiJJEG7jO3g6jAHeysY/+ZZYIesfxjd5O8QHgOB2itLiZN0cId+9BZkqqtFwRYg6KHNbitPkQywjzFVESTr+NXZ5w58g34yBgX1D5WVwheovhcogfKKBDvuh07IByzV2YRtTVww9narZguYNDLZnL4mVLIRIkxuFm7GedyOh7pk+cpgYnbjli5mEBJbkOR5Gvco1IrdO85oYm9eQ6y2il1+v8gCi755nIEe0E/VEu0gJ6W907lpfcMF9X4265eVTixTLwO85ycogJdl2IvRq6KMOKgMDrgKbZ0VJd/pwIcCJv11S9g5el1wP3G+BLJdrQ==");


        /*
         * ProtNFe
         */
        $protNFe = new ProtNFe();
        $protNFe = $nfeProc->protNFe;

        $this->assertEquals($protNFe->versao, "2.00");

        /*
         * InfProt
         */
        $infProt = new InfProt();
        $infProt = $protNFe->infProt;

        $this->assertEquals($infProt->tpAmb, '1');
        $this->assertEquals($infProt->verAplic, '13_2_35');
        $this->assertEquals($infProt->chNFe, '31141019592641000372550020009458071111021102');
        $this->assertEquals($infProt->dhRecbto, '2014-10-21T03:25:58');
        $this->assertEquals($infProt->nProt, '131141576063340');
        $this->assertEquals($infProt->digVal, 'LZpkzcmNJoKBSZQnglLI8qAm148=');
        $this->assertEquals($infProt->cStat, '100');
        $this->assertEquals($infProt->xMotivo, 'Autorizado o uso da NF-e');
    }

}
