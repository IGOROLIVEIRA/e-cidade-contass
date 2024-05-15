<?php

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
          $dbwhere= " e60_instit = " . db_getsession("DB_instit");
          //$dbwhere .=" AND e60_emiss <= c99_data ";
          $dbwhere .= "AND e60_vlremp = e60_vlranu ";
          $dbwhere .= "AND e60_anousu = ".db_getsession("DB_anousu");

          $sql = $clempempenho->sql_manut_dados(null,$campos,null,$dbwhere);
           //echo $sql;
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
