<?php

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$sNomeArquivo = key($_FILES);
$extensao = strtolower(end(explode('.', $_FILES["$sNomeArquivo"]['name'])));
if ($extensao != "csv" && $extensao != "xml") {
	echo "<div style=\"color: red;\">Envie arquivos somente com extensão .csv ou .xml</div>";
}

switch ($extensao) {

  case 'csv':
    $row = 1;
    if (($handle = fopen($_FILES["$sNomeArquivo"]['name'], 'r')) !== FALSE) {echo "<pre>";
      while (($data = fgetcsv($handle, 2000, ";")) !== FALSE) {
        $num = count($data);
        echo "<p> $num campos na linha $row: <br></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br>";
        }
      }
      fclose($handle);
    }

  break;

  case 'xml':

    $xbrl = "xbrli:xbrl";
    $accountingEntries = "gl-cor:accountingEntries";
    $entryHeader       = "gl-cor:entryHeader";
    $entryDetail       = "gl-cor:entryDetail";
    //$xml = simplexml_load_file($_FILES["$sNomeArquivo"]['name']);//->{$accountingEntries}->{$entryHeader}->{$entryDetail}; //carrega o arquivo XML e retornando um Array 
    
    /*$xmldoc = new DOMDocument();
    $xmldoc->load($_FILES["$sNomeArquivo"]['name']);
    $xpath = new DOMXPath($xmldoc);
    $xpath->registerNamespace("xbrli", "http://www.xbrl.org/2003/instance");
    //$nodelist = $xpath->query("/xbrli:xbrl/xbrli:context[@id='C1']"); //("/xbrli:xbrl/xbrli:context[@id='D2010Q1']/xbrli:period")
    $nodelist = $xpath->query("/xbrli:xbrl/gl-cor:accountingEntries");
    
    echo "<pre>"; var_dump($nodelist->item(0)->nodeValue);die;*/

    $reader = new XMLReader();
    $reader->open($_FILES["$sNomeArquivo"]['name']);var_dump($reader);die;
    while ($reader->read()) {
      if ($reader->nodeType == XMLReader::END_ELEMENT) {
        continue; //skips the rest of the code in this iteration
      }
      //do something with desired node type
      if($reader->name == 'gl-cor:accountingEntries') {
        print_r($reader->item(0)->nodeValue);"<br>";
      }
    }
    
  break;

}

/*
 <xbrli:context id="I2010_ForwardContractsMember">
 <xbrli:entity>
  <xbrli:identifier scheme="http://www.sec.gov/CIK">0000027419</xbrli:identifier>
  <xbrli:segment>
    <xbrldi:explicitMember dimension="us-gaap:DerivativeByNatureAxis">us-gaap:ForwardContractsMember</xbrldi:explicitMember>
  </xbrli:segment>
</xbrli:entity>
<xbrli:period>
  <xbrli:instant>2011-01-29</xbrli:instant>
</xbrli:period>
 </xbrli:context>
<xbrli:context id="D2010Q1">
  <xbrli:entity>
  <xbrli:identifier scheme="http://www.sec.gov/CIK">0000027419</xbrli:identifier>
  </xbrli:entity>
 <xbrli:period>
    <xbrli:startDate>2010-01-31</xbrli:startDate>
    <xbrli:endDate>2010-05-01</xbrli:endDate>
  </xbrli:period>
 </xbrli:context>

 $xmldoc = new DOMDocument();
$xmldoc->load("http://www.sec.gov/Archives/edgar/data/27419/000110465911031717/tgt-20110430.xml");
$xpath = new DOMXPath($xmldoc);
$xpath->registerNamespace("xbrli", "http://www.xbrl.org/2003/instance");
$nodelist = $xpath->query("/xbrli:xbrl/xbrli:context[@id='D2010Q1']/xbrli:period"); // much faster than //xbrli:context and //xbrli:startDate
if($nodelist->length === 1)
{
    $period = $nodelist->item(0);
    $nodelist = $xpath->query("xbrli:startDate", $period);
    $startDate = $nodelist->length === 1 ? $nodelist->item(0)->nodeValue : null;
    $nodelist = $xpath->query("xbrli:endDate", $period);
    $endDate = $nodelist->length === 1 ? $nodelist->item(0)->nodeValue : null;
    printf("%s<br>%s", $startDate, $endDate);
}
*/
?>