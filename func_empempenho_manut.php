<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require "libs/db_stdlib.php";
require "libs/db_conecta.php";
include "libs/db_sessoes.php";
include "libs/db_usuariosonline.php";
include "dbforms/db_funcoes.php";
include "classes/db_empempenho_classe.php";

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clempempenho = new cl_empempenho();
$clempempenho->rotulo->label("e60_numemp");
$clempempenho->rotulo->label("e60_codemp");

$rotulo = new rotulocampo();
$rotulo->label("z01_nome");
$rotulo->label("z01_cgccpf");

?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script>
    function js_mascara(evt)
    {
      var evt;

      if (!evt) {
        if (window.event) {
          evt = window.event;
        } else {
          evt = ""
        };
      };

      if ((evt.charCode > 46 && evt.charCode < 58) || evt.charCode == 0) {
        return true;
      } else {
        return false;
      }
    }
  </script>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="a=1">
  <form name="form2" class="container" method="post" action="">
    <fieldset>
      <legend>Pesquisa de Empenhos</legend>
      <table border="0" class="form-container">
        <tr>
          <td>
            <label for="chave_e60_codemp">
              <?= $Le60_codemp; ?>
            </label>
          </td>
          <td>
            <?php db_input("e60_codemp", 14, $Ie60_codemp, true, "text", 4, "onKeyPress='return js_mascara(event);'", "chave_e60_codemp"); ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="chave_e60_numemp">
              <?= $Le60_numemp; ?>
            </label>
          </td>
          <td>
            <?php db_input("e60_numemp", 14, $Ie60_numemp, true, "text", 4, "", "chave_e60_numemp"); ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="chave_z01_nome">
              <?= $Lz01_nome; ?>
            </label>
          </td>
          <td>
            <?php db_input("z01_nome", 45, "", true, "text", 4, "", "chave_z01_nome"); ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="">
              <?= $Lz01_cgccpf; ?>
            </label>
          </td>
          <td>
            <?php db_input("z01_cgccpf", 14, "", true, "text", 4, "", "chave_z01_cgccpf"); ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <table style="margin: 0 auto;">
      <tr>
        <td align="center">
          <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
          <input name="limpar" type="reset" id="limpar" value="Limpar" >
          <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_empempenho.hide();">
        </td>
      </tr>
    </table>
  </form>
  <table class="container">
    <tr>
      <td align="center" valign="top">
        <?php
        $campos="e60_numemp, e60_codemp, z01_nome,si172_nrocontrato,
        si172_datafinalvigencia,
        si174_novadatatermino
        ";

        $filtroempelemento = "";
        if (!isset($pesquisa_chave)) {
          $campos = "empempenho.e60_numemp,
          empempenho.e60_codemp,
          empempenho.e60_anousu,
          case when ac16_numeroacordo is null then si172_nrocontrato::varchar else (ac16_numeroacordo || '/' || ac16_anousu)::varchar end as si172_nrocontrato,
          case when (select ac18_datafim from acordovigencia where ac18_acordoposicao in (select min(ac26_sequencial) from acordoposicao where ac26_acordo = acordo.ac16_sequencial) and ac18_ativo  = true) is null then si172_datafinalvigencia else (select ac18_datafim from acordovigencia where ac18_acordoposicao in (select min(ac26_sequencial) from acordoposicao where ac26_acordo = acordo.ac16_sequencial) and ac18_ativo  = true) end as si172_datafinalvigencia,
          case when ac16_datafim is null then si174_novadatatermino else ac16_datafim end as si174_novadatatermino,
          empempenho.e60_emiss as DB_e60_emiss,
          cgm.z01_nome,
          cgm.z01_cgccpf,
          empempenho.e60_coddot,
          e60_vlremp,
          e60_vlrliq,
          e60_vlrpag,
          e60_vlranu,
          RPAD(SUBSTR(convconvenios.c206_objetoconvenio,0,47),50,'...') AS c206_objetoconvenio
          ";
          $campos = " distinct " . $campos;
          $dbwhere=" e60_instit = " . db_getsession("DB_instit") . " AND e60_emiss < c99_data";

          if (isset($anul) && $anul == false) {
            $dbwhere .= " and e60_vlranu<e60_vlremp ";
          }
                /**
                 * Filtro $filtroabast
                 * Busca pelo elemento do empenho para abastecimento
                 * @see ocorrência contass 1011
                 *
                 */
                if ($filtroabast == 1) {
                  $dbwhere .= " and elementoempenho.o56_elemento in ('3339030010000','3390330100000','3390339900000','3339033990000','3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000') ";
                  //removido por meio da solicitacao da oc 6848
                  //$dbwhere .= " and empempenho.e60_emiss <= '$ve70_abast'";
                  //adicionado nova validadacao OC 6848
                  $dbwhere .= "AND ((date_part('year', empempenho.e60_emiss) < date_part('year', date '".$ve70_abast."') AND date_part('month', empempenho.e60_emiss) <= 12)
                               OR (date_part('year', empempenho.e60_emiss) = date_part('year', date '".$ve70_abast."') AND date_part('month', empempenho.e60_emiss) <= date_part('month', date '".$ve70_abast."')))";
                  $filtroempelemento = 1;
                }
                /**
                 * Filtro $filtromanut
                 * Busca pelo elemento do empenho para manutencao
                 * @see ocorrências contass 2079, 20105
                 *
                 */
                if ($filtromanut == 1) {
                  $dbwhere .= " and elementoempenho.o56_elemento in ('3339039990400','3339039990000','3339039170000','3339039160000','3339039150000','3339039050000','3339036990000','3339036170000','3339036160000','3339036060000','3339030010000','3339030250000','3339030370000','3339030990000','3339030020000','3339030030000','3339092000000') ";
                  $dbwhere .= " and empempenho.e60_emiss <= '$ve62_dtmanut'";
                  $dbwhere .= " and date_part('year', empempenho.e60_emiss) <= date_part('year', date'".$ve62_dtmanut."')";
                  $filtroempelemento = 1;
                }

                /**
                 * Filtro $emperro
                 * Busca pelos empenhos anulados por erro na emissão, validando período contábil
                 * @see ocorrência contass 3414
                 *
                 */
                if (isset($emperro) && $emperro == true) {
                  $dbwhere .= " AND e60_vlremp = e60_vlranu
                  AND e60_vlrliq = 0
                  AND e60_numemp NOT IN
                  (SELECT m52_numemp FROM matordemitem
                  UNION
                  SELECT e69_numemp FROM empnota)";

                }

                if (isset($chave_e60_numemp) && !empty($chave_e60_numemp)) {
                  $sql = $clempempenho->sql_manut_dados($chave_e60_numemp,$campos,"e60_numemp","$dbwhere and e60_numemp=$chave_e60_numemp ",$filtroempelemento);
                } elseif (isset($chave_e60_codemp) && !empty($chave_e60_codemp)) {
                  $arr = split("/",$chave_e60_codemp);
                  if (count($arr) == 2  && isset($arr[1]) && $arr[1] != '' ) {
                    $dbwhere_ano = " and e60_anousu = ".$arr[1];
                  } elseif (count($arr) == 1) {
                    $dbwhere_ano = " and e60_anousu = ".db_getsession("DB_anousu");
                  } else {
                    $dbwhere_ano = "";
                  }
                  $sql = $clempempenho->sql_manut_dados("",$campos,"e60_numemp","$dbwhere and e60_codemp='".$arr[0]."'$dbwhere_ano",$filtroempelemento);
                } elseif (isset($chave_z01_nome) && !empty($chave_z01_nome)) {
                  $sql = $clempempenho->sql_manut_dados("",$campos,"e60_numemp","$dbwhere and z01_nome like '$chave_z01_nome%'",$filtroempelemento);
                } elseif (isset($chave_z01_cgccpf) && !empty($chave_z01_cgccpf)) {
                  $sql = $clempempenho->sql_manut_dados("",$campos,"e60_numemp","$dbwhere and z01_cgccpf like '$chave_z01_cgccpf%'",$filtroempelemento);
                } else {
                  $sql = $clempempenho->sql_manut_dados("",$campos,"e60_numemp","{$dbwhere}",$filtroempelemento);
                }

                $repassa = array(
                  "chave_z01_nome" => @$chave_z01_nome
                );
                if(isset($relordemcompra) && $relordemcompra==true){
                  $campos.=",z01_numcgm";
                  $whereRelCompra = ' e60_instit='.db_getsession('DB_instit');
                  if(isset($periodoini) && $periodoini != ""){

                    $data = explode("/",$periodoini);
                    $periodoini = $data[2].'-'.$data[1].'-'.$data[0];

                    $whereRelCompra .= " AND e60_emiss >= '$periodoini'";
                  }
                  if(isset($periodofim) && $periodofim != ""){
                    $data = explode("/",$periodofim);
                    $periodofim = $data[2].'-'.$data[1].'-'.$data[0];

                    $whereRelCompra .= " AND e60_emiss <= '$periodofim'";
                  }
                  if(isset($fornecedor) && $fornecedor!=""){
                    $whereRelCompra .= " AND z01_numcgm = $fornecedor";
                  }
                  if(isset($chave_e60_codemp) && $chave_e60_codemp!=""){
                   $whereRelCompra .= " AND e60_codemp = '$chave_e60_codemp'";
                 }
                 if(isset($chave_z01_cgccpf) && $chave_z01_cgccpf!=""){
                   $whereRelCompra .= " AND z01_cgccpf = '$chave_z01_cgccpf'";
                 }
                 if(isset($chave_z01_nome) && $chave_z01_nome!=""){
                   $whereRelCompra .= " AND z01_nome LIKE '%$chave_z01_nome%'";
                 }



                 $sql = $clempempenho->sql_manut_dados(null,$campos,null,$whereRelCompra);

               }

               $result = $clempempenho->sql_record($sql);

               ?>

               <fieldset>
                <legend><strong>Resultado da Pesquisa</strong></legend>
                <?php db_lovrot($sql, 15, "()", "%", $funcao_js, "", "NoMe", $repassa, false); ?>
              </fieldset>
              <?php
        } else {

              if ($pesquisa_chave != null && $pesquisa_chave != "") {

                if (isset($lPesquisaPorCodigoEmpenho)) {

                  if (!empty($iAnoEmpenho)) {
                    $sWherePesquisaPorCodigoEmpenho = " e60_anousu = " . $iAnoEmpenho;
                  } else {
                    $sWherePesquisaPorCodigoEmpenho = " e60_anousu = ". db_getsession("DB_anousu");
                  }

                        /**
                         * Filtro $filtroabast
                         * Busca pelo elemento do empenho para abastecimento
                         * @see ocorrência contass 1011
                         *
                         */
                        if ($filtroabast == 1) {
                              $sWherePesquisaPorCodigoEmpenho .= " and elementoempenho.o56_elemento in ('3339030990000','339033010000','339033990000','3339033990000'.'3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000') ";
                           //comentado por solicitação da OC 8035
                          $dbwhere .= " and empempenho.e60_emiss <= '$ve70_abast'";
                            $dbwhere .= " and date_part('month', empempenho.e60_emiss) <= date_part('month', date '".$ve70_abast."')";
                            $dbwhere .= " and date_part('year', empempenho.e60_emiss) <= date_part('year', date '".$ve70_abast."')";
                            $filtroempelemento = 1;
                        }

                        /**
                         * Filtro $filtromanut
                         * Busca pelo elemento do empenho para manutencao
                         * @see ocorrência contass 2079
                         *
                         */
                        if ($filtromanut == 1) {
                          $dbwhere .= " and elementoempenho.o56_elemento in ('3339039990400','3339039990000','3339039170000','3339039160000','3339039150000','3339039050000','3339036990000','3339036170000','3339036160000','3339036060000','3339030010000','3339030250000','3339030370000','3339030990000','3339030020000','3339030030000','3339092000000') ";
                          $dbwhere .= " and empempenho.e60_emiss <= '$ve62_dtmanut'";
                          $dbwhere .= " and date_part('year', empempenho.e60_emiss) <= date_part('year', date'".$ve62_dtmanut."')";
                          $filtroempelemento = 1;
                        }

                        $aCodEmp  = explode("/",$pesquisa_chave);
                        $sWherePesquisaPorCodigoEmpenho .= " and e60_codemp = '".$aCodEmp[0]."'";

                        $sSql = $clempempenho->sql_manut_dados(null, $campos, null, $sWherePesquisaPorCodigoEmpenho,$filtroempelemento);

                      }

                      if (isset($protocolo)) {
                        $campos = " z01_nome,e60_numemp,e60_emiss,e60_vlremp,e60_codemp ";
                        if ($protocolo == 2) {
                          $where = " e60_codemp = '{$pesquisa_chave}' and e60_anousu = ".db_getsession("DB_anousu")." and e60_instit = ".db_getsession("DB_instit");
                          $sSql = $clempempenho->sql_manut_dados(null, $campos, null, $where, $filtroempelemento);
                        } else {
                          $sSql = $clempempenho->sql_manut_dados($pesquisa_chave, $campos, null,"", $filtroempelemento);
                        }
                      }

                      else {
                        $sSql = $clempempenho->sql_manut_dados($pesquisa_chave,$campos,null,"",$filtroempelemento);
                      }

                      $result = $clempempenho->sql_record($sSql);

                      if ($clempempenho->numrows != 0) {

                        db_fieldsmemory($result, 0);

                        if (isset($lNovoDetalhe) && $lNovoDetalhe == 1) {
                          echo "<script>" . $funcao_js . "('{$e60_codemp} / {$e60_anousu}', false);</script>";
                        } elseif (isset($lPesquisaPorCodigoEmpenho)) {
                          echo "<script>" . $funcao_js . "('{$e60_numemp}', '" . str_replace("'", "\'", $z01_nome) . "', '{$si172_nrocontrato}','{$si172_datafinalvigencia}','{$si174_novadatatermino}',false);</script>";
                        } else {
                          if ($funcao_js == 'parent.js_mostraempempenhotesta') {
                            echo "<script>" . $funcao_js . "('{$e60_codemp} / {$e60_anousu}', false);</script>";
                          }
                          if (isset($protocolo)) {
                            echo "<script>" . $funcao_js . "('" . str_replace("'", "\'", $z01_nome) . "', '{$e60_numemp}','{$e60_emiss}','{$e60_vlremp}','{$e60_codemp}',false);</script>";
                          }
                          else {
                            echo "<script>" . $funcao_js . "('" . str_replace("'", "\'", $z01_nome) . "', '{$si172_nrocontrato}','{$si172_datafinalvigencia}','{$si174_novadatatermino}',false);</script>";
                          }
                        }

                      } else { echo '5'; exit;
                      echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado', true);</script>";
                    }
                  } else {

                    echo "<script>" . $funcao_js . "('', false);</script>";
                  }
                }
                ?>
              </td>
            </tr>
          </table>
        </body>
        </html>
        <script>
          document.getElementById("chave_e60_codemp").focus();
        </script>
