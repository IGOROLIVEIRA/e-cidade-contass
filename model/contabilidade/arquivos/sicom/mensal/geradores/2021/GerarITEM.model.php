<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarITEM extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "ITEM";
    $this->abreArquivo();

    $sSql = "select * from item102020 where si43_mes = " . $this->iMes . " and si43_instit = " . db_getsession("DB_instit");
    $rsITEM10 = db_query($sSql);//db_criatabela($rsITEM10);

    if (pg_num_rows($rsITEM10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
      
    } else {

      for ($iCont = 0; $iCont < pg_num_rows($rsITEM10); $iCont++) {

        $aITEM10 = pg_fetch_array($rsITEM10, $iCont);

        $aCSVITEM10['si43_tiporegistro']            = $this->padLeftZero($aITEM10['si43_tiporegistro'], 2);
        $aCSVITEM10['si43_coditem']                 = substr($aITEM10['si43_coditem'], 0, 15);
        $aCSVITEM10['si43_dscitem']                 = substr($aITEM10['si43_dscitem'], 0, 1000);
        $aCSVITEM10['si43_unidademedida']           = substr($aITEM10['si43_unidademedida'], 0, 50);
        $aCSVITEM10['si43_tipocadastro']            = $this->padLeftZero($aITEM10['si43_tipocadastro'], 1);
        $aCSVITEM10['si43_justificativaalteracao']  = substr($aITEM10['si43_justificativaalteracao'], 0, 100);
        
        $this->sLinha = $aCSVITEM10;
        $this->adicionaLinha();

      }

    }
    $this->fechaArquivo();
  }

} 
