<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoMetasArrecadacaoReceita extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 145;
  
  protected $sNomeArquivo = 'MTBIARREC';
  
  protected $iCodigoPespectiva;
  
  public function __construct()
  {
    
  }
  
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {
    
    $aElementos = array(
      "metaArrec1Bim",
      "metaArrec2Bim",
      "metaArrec3Bim",
      "metaArrec4Bim",
      "metaArrec5Bim",
      "metaArrec6Bim"
    );
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    
    /**
     * CARREGA O VALOR ORCADO PARA O ANO DE ENVIO DO SICOM
     */
    $anualOrcado = 0;
    
    $sSqlReceitaOrcada = "SELECT sum(o70_valor) as valororcado FROM orcfontes f ";
    $sSqlReceitaOrcada .= "JOIN orcreceita r ON f.o57_codfon = r.o70_codfon ";
    $sSqlReceitaOrcada .= "AND f.o57_anousu = o70_anousu ";
    $sSqlReceitaOrcada .= "JOIN orctiporec t ";
    $sSqlReceitaOrcada .= "ON r.o70_codigo = t.o15_codigo ";
    $sSqlReceitaOrcada .= "WHERE f.o57_anousu = " . db_getsession("DB_anousu");
    
    
    $rsReceitaOrcada = db_query($sSqlReceitaOrcada);
    
    $anualOrcado = db_utils::fieldsMemory($rsReceitaOrcada, 0)->valororcado;
    
    
    /**
     * CARREGA O VALOR ARRECADADO NO ANO ANTERIOR AO ANO DE ENVIO DO SICOM COMO BASE PARA PROJECAO
     */
    
    $sSqlRecArrecadAnt = "select sum(case when c71_coddoc = 101 then  c70_valor * -1 else c70_valor end) as  valorarrecad ";
    $sSqlRecArrecadAnt .= " from contabilidade.conlancamrec";
    $sSqlRecArrecadAnt .= " join contabilidade.conlancam on c70_codlan = c74_codlan";
    $sSqlRecArrecadAnt .= " join contabilidade.conlancamdoc on c71_codlan = c74_codlan and c71_coddoc in (100,101)";
    $sSqlRecArrecadAnt .= " where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-01-01-' and '" . (db_getsession("DB_anousu") - 1) . "-12-31'";
    
    $rsRecArrecadAnt = db_query($sSqlRecArrecadAnt);
    
    $anualArrecadAnt = db_utils::fieldsMemory($rsRecArrecadAnt, 0)->valorarrecad;
    
    
    $aBimestralPercent = array();
    
    $aBimestralProjecao = array();
    
    
    for ($i = 0; $i < 6; $i++) {
      
      /*
       * SQL VERIFICA SE EXISTE LANCAMENTO DE RECEITA PARA O EXERCICIO ANTERIOR.
      */
      
      $sSqlRecArrecadAnt = "select sum(case when c71_coddoc = 101 then  c70_valor * -1 else c70_valor end) as  valorarrecad ";
      $sSqlRecArrecadAnt .= " from contabilidade.conlancamrec";
      $sSqlRecArrecadAnt .= " join contabilidade.conlancam on c70_codlan = c74_codlan";
      $sSqlRecArrecadAnt .= " join contabilidade.conlancamdoc on c71_codlan = c74_codlan and c71_coddoc in (100,101)";
      $sSqlRecArrecadAnt .= "where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-01-01-' and '" . (db_getsession("DB_anousu") - 1) . "-12-31'";
      
      $rsRecArrecadAntVerif = db_query($sSqlRecArrecadAnt);
      
      
      if (pg_num_rows($rsRecArrecadAntVerif) != 0) {
        
        if ($i == 0) {
          $where = " where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-01-01-' and '" . (db_getsession("DB_anousu") - 1) . "-02-28'";
        } else {
          if ($i == 1) {
            $where = " where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-03-01-' and '" . (db_getsession("DB_anousu") - 1) . "-04-30'";
          } else {
            if ($i == 2) {
              $where = " where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-05-01-' and '" . (db_getsession("DB_anousu") - 1) . "-06-30'";
            } else {
              if ($i == 3) {
                $where = " where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-07-01-' and '" . (db_getsession("DB_anousu") - 1) . "-08-31'";
              } else {
                if ($i == 4) {
                  $where = " where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-09-01-' and '" . (db_getsession("DB_anousu") - 1) . "-10-31'";
                } else {
                  if ($i == 5) {
                    $where = " where c70_data between '" . (db_getsession("DB_anousu") - 1) . "-10-01-' and '" . (db_getsession("DB_anousu") - 1) . "-12-31'";
                  }
                }
              }
            }
          }
        }
        
        $sSqlRecArrecadAnt = "select sum(case when c71_coddoc = 101 then  c70_valor * -1 else c70_valor end) as  valorarrecad ";
        $sSqlRecArrecadAnt .= " from contabilidade.conlancamrec";
        $sSqlRecArrecadAnt .= " join contabilidade.conlancam on c70_codlan = c74_codlan";
        $sSqlRecArrecadAnt .= " join contabilidade.conlancamdoc on c71_codlan = c74_codlan and c71_coddoc in (100,101)";
        $sSqlRecArrecadAnt .= $where;
        
        $rsRecArrecadAnt = db_query($sSqlRecArrecadAnt);
        
        $aBimestralPercent[$i] = db_utils::fieldsMemory($rsRecArrecadAnt, 0)->valorarrecad / $anualArrecadAnt;
        $aBimestralProjecao[$i] = $aBimestralPercent[$i] * $anualOrcado;
      } else {
        $aBimestralProjecao[0] = $anualOrcado / 6;
        $aBimestralProjecao[1] = $anualOrcado / 6;
        $aBimestralProjecao[2] = $anualOrcado / 6;
        $aBimestralProjecao[3] = $anualOrcado / 6;
        $aBimestralProjecao[4] = $anualOrcado / 6;
        $aBimestralProjecao[5] = $anualOrcado / 6;
        break;
      }
      
    }
    
    $aBimestralProjecao[0] = number_format($aBimestralProjecao[0], 2, ",", "");
    $aBimestralProjecao[1] = number_format($aBimestralProjecao[1], 2, ",", "");
    $aBimestralProjecao[2] = number_format($aBimestralProjecao[2], 2, ",", "");
    $aBimestralProjecao[3] = number_format($aBimestralProjecao[3], 2, ",", "");
    $aBimestralProjecao[4] = number_format($aBimestralProjecao[4], 2, ",", "");
    $aBimestralProjecao[5] = number_format($aBimestralProjecao[5], 2, ",", "");
    $totalprojecao = number_format($totalprojecao, 2, ",", "");
    $anualOrcado = number_format($anualOrcado, 2, ",", "");
    
    $totalprojecao = $aBimestralProjecao[0] + $aBimestralProjecao[1] + $aBimestralProjecao[2] + $aBimestralProjecao[3] + $aBimestralProjecao[4] + $aBimestralProjecao[5];
    
    if ($totalprojecao != $anualOrcado) {
      $aBimestralProjecao[5] = $anualOrcado - ($aBimestralProjecao[0] + $aBimestralProjecao[1] + $aBimestralProjecao[2] + $aBimestralProjecao[3] + $aBimestralProjecao[4]);
    }
    
    
    $oDadosMTBIARREC = new stdClass();
    
    $oDadosMTBIARREC->metaArrec1Bim = number_format($aBimestralProjecao[0], 2, ",", "");
    $oDadosMTBIARREC->metaArrec2Bim = number_format($aBimestralProjecao[1], 2, ",", "");
    $oDadosMTBIARREC->metaArrec3Bim = number_format($aBimestralProjecao[2], 2, ",", "");
    $oDadosMTBIARREC->metaArrec4Bim = number_format($aBimestralProjecao[3], 2, ",", "");
    $oDadosMTBIARREC->metaArrec5Bim = number_format($aBimestralProjecao[4], 2, ",", "");
    $oDadosMTBIARREC->metaArrec6Bim = number_format($aBimestralProjecao[5], 2, ",", "");
    
    $this->aDados[] = $oDadosMTBIARREC;
    
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva)
  {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva()
  {
    return $this->iCodigoPespectiva;
  }
}
