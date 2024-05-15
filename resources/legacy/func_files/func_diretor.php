<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

db_postmemory($_POST);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$oDaoRecHumano = new cl_rechumano();
$oDaoRotulo    = new rotulocampo();
$oDaoRotulo->label("ed20_i_codigo");
$oDaoRotulo->label("z01_numcgm");
$oDaoRotulo->label("z01_nome");
?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC>
  <div class="container">
    <form class="form-container" name="form" method="post">
      <fieldset>
        <legend>Filtros</legend>
        <table>
          <tr>
            <td>
              <label class="bold">
                Recurso Humano:
              </label>
            </td>
            <td>
              <?php
              db_input('ed20_i_codigo', 10, $Ied20_i_codigo, true, "text", 1, "", "chave_ed20_i_codigo");
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <label class="bold">
                CGM:
              </label>
            </td>
            <td>
              <?php
              db_input('z01_numcgm', 10, $Iz01_numcgm, true, "text", 1, "", "chave_z01_numcgm");
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <label class="bold">
                Nome:
              </label>
            </td>
            <td>
              <?php
              db_input('z01_nome', 40, $Iz01_nome, true, "text", 1, "", "chave_z01_nome");
              ?>
            </td>
          </tr>
        </table>
      </fieldset>
      <input id="btnPesquisar" name="btnPesquisar" type="submit" value="Pesquisar" />
      <input id="btnFechar" name="btnFechar" type="button" value="Fechar" onClick="parent.db_iframe_diretor.hide();">
    </form>
  </div>
  <div class="container">
    <?

    $iEscola = db_getsession("DB_coddepto");

    if ($chave_ed20_i_codigo == "" && $chave_z01_numcgm == "" && $chave_z01_nome == "") {

      $aRepassa = array();

      $instit = db_getsession("DB_instit");
      $ano = db_anofolha();
      $mes = db_mesfolha();
      $escola = db_getsession("DB_coddepto");
      $orderby = " ORDER BY z01_nome,ed01_c_descr";
      $sql = "SELECT ed20_i_codigo,
                     case when ed20_i_tiposervidor = 1 then cgmrh.z01_nome else cgmcgm.z01_nome end as z01_nome,
                     ed01_c_exigeato,
                     case when ed20_i_tiposervidor = 1 then rechumanopessoal.ed284_i_rhpessoal else rechumanocgm.ed285_i_cgm end as identificacao,
                     case when ed20_i_tiposervidor = 1 then cgmrh.z01_cgccpf else cgmcgm.z01_cgccpf end as z01_cgccpf,
                     ed01_c_descr 
              FROM rechumano
               inner join rechumanoescola on ed75_i_rechumano = ed20_i_codigo
               left join rechumanoativ on ed22_i_rechumanoescola = ed75_i_codigo
               left join atividaderh on ed01_i_codigo = ed22_i_atividade
               left join rechumanopessoal  on  rechumanopessoal.ed284_i_rechumano = rechumano.ed20_i_codigo
               left join rhpessoal  on  rhpessoal.rh01_regist = rechumanopessoal.ed284_i_rhpessoal
               left join rhpessoalmov on rhpessoalmov.rh02_anousu  = $ano
                                          and rhpessoalmov.rh02_mesusu  = $mes
                                          and rhpessoalmov.rh02_regist  = rhpessoal.rh01_regist
                                          and rhpessoalmov.rh02_instit  = $instit
               left join rhregime as regimerh on  regimerh.rh30_codreg = rhpessoalmov.rh02_codreg
               left join cgm as cgmrh on  cgmrh.z01_numcgm = rhpessoal.rh01_numcgm
               left join rechumanocgm  on  rechumanocgm.ed285_i_rechumano = rechumano.ed20_i_codigo
               left join cgm as cgmcgm on  cgmcgm.z01_numcgm = rechumanocgm.ed285_i_cgm
               left join rhregime as regimecgm on  regimecgm.rh30_codreg = rechumano.ed20_i_rhregime
              WHERE ed75_i_escola = $escola AND ed01_i_codigo = 5
              $orderby
             ";
      echo "<script>" . $funcao_js . "('123', '123', '123', '123', '123', false);</script>";

      db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $aRepassa);
    } else {

      if ($chave_ed20_i_codigo != "" || $chave_z01_numcgm != "" || $chave_z01_nome != "") {


        if ($chave_ed20_i_codigo != "") {
          $where = " AND ed20_i_codigo = {$chave_ed20_i_codigo}";
        }

        if ($chave_z01_numcgm != "") {
          $where = " AND z01_numcgm = {$chave_z01_numcgm}";
        }

        if ($chave_z01_nome != "") {
          $where = " AND cgmrh.z01_nome ilike '$chave_z01_nome%'";
        }

        $instit = db_getsession("DB_instit");
        $ano = db_anofolha();
        $mes = db_mesfolha();
        $escola = db_getsession("DB_coddepto");
        $orderby = " ORDER BY z01_nome,ed01_c_descr";
        $sql = "SELECT ed20_i_codigo,
                     case when ed20_i_tiposervidor = 1 then cgmrh.z01_nome else cgmcgm.z01_nome end as z01_nome,
                     ed01_c_exigeato,
                     case when ed20_i_tiposervidor = 1 then rechumanopessoal.ed284_i_rhpessoal else rechumanocgm.ed285_i_cgm end as identificacao,
                     case when ed20_i_tiposervidor = 1 then cgmrh.z01_cgccpf else cgmcgm.z01_cgccpf end as z01_cgccpf,
                     ed01_c_descr 
              FROM rechumano
               inner join rechumanoescola on ed75_i_rechumano = ed20_i_codigo
               left join rechumanoativ on ed22_i_rechumanoescola = ed75_i_codigo
               left join atividaderh on ed01_i_codigo = ed22_i_atividade
               left join rechumanopessoal  on  rechumanopessoal.ed284_i_rechumano = rechumano.ed20_i_codigo
               left join rhpessoal  on  rhpessoal.rh01_regist = rechumanopessoal.ed284_i_rhpessoal
               left join rhpessoalmov on rhpessoalmov.rh02_anousu  = $ano
                                          and rhpessoalmov.rh02_mesusu  = $mes
                                          and rhpessoalmov.rh02_regist  = rhpessoal.rh01_regist
                                          and rhpessoalmov.rh02_instit  = $instit
               left join rhregime as regimerh on  regimerh.rh30_codreg = rhpessoalmov.rh02_codreg
               left join cgm as cgmrh on  cgmrh.z01_numcgm = rhpessoal.rh01_numcgm
               left join rechumanocgm  on  rechumanocgm.ed285_i_rechumano = rechumano.ed20_i_codigo
               left join cgm as cgmcgm on  cgmcgm.z01_numcgm = rechumanocgm.ed285_i_cgm
               left join rhregime as regimecgm on  regimecgm.rh30_codreg = rechumano.ed20_i_rhregime
              WHERE ed75_i_escola = $escola AND ed01_i_codigo = 5
              $where
              $orderby
             ";
        $result = db_query($sql);
        db_fieldsmemory($result, 0);
        if (pg_numrows($result) != 0) {
          echo "<script>" . "parent.js_mostrarechumano1('$ed20_i_codigo', '$z01_nome', '$ed01_c_exigeato', '$identificacao', '$z01_cgccpf', '$ed01_c_descr');</script>";
        }
      } else {
        echo "<script>" . $funcao_js . "('',false);</script>";
      }
    }
    ?>
  </div>
</body>

</html>
<script>
  js_tabulacaoforms("form", "chave_ed20_i_codigo", true, 1, "chave_ed20_i_codigo", true);
</script>