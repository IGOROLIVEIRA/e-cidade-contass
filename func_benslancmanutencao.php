<?

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_bens_classe.php");
include("classes/db_cfpatri_classe.php");
include("classes/db_clabens_classe.php");
include("classes/db_db_depusu_classe.php");
include("classes/db_db_depart_classe.php");
$cldb_depart = new cl_db_depart;
$clbens      = new cl_bens;
$clcfpatri   = new cl_cfpatri;
$clclabens   = new cl_clabens;
$cldb_depusu = new cl_db_depusu;
$cldb_estrut = new cl_db_estrut;

$clbens->rotulo->label("t52_bem");
$clbens->rotulo->label("t52_ident");
$clbens->rotulo->label("t52_descr");
$clclabens->rotulo->label("t64_class");
$cldb_depart->rotulo->label("descrdepto");

db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
//echo $HTTP_SERVER_VARS["QUERY_STRING"];

$result_t06_codcla = $clcfpatri->sql_record($clcfpatri->sql_query_file(null, "t06_codcla"));
if ($clcfpatri->numrows > 0) {
  db_fieldsmemory($result_t06_codcla, 0);
}

?> <html>

<head>
  <meta http-equiv="Content-Type" content="text/html;
charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table height="100%" width="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
          <form name="form2" method="post" action="">
            <tr>
              <td width="4%" align="left" nowrap title="<?= $Tt52_ident ?>">
                <?= $Lt52_ident ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("chave_t52_ident", 20, $It52_ident, true, "text", 4, "", "chave_t52_ident");
                ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap title="<?= $Tt52_bem ?>">
                <?= $Lt52_bem ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("t52_bem", 8, $It52_bem, true, "text", 4, "", "chave_t52_bem");
                ?>
              </td>
            </tr>
            <?
            $cldb_estrut->autocompletar = true;
            $cldb_estrut->funcao_onchange = 'js_troca(this.value)';
            $cldb_estrut->nomeform = 'form2';
            $cldb_estrut->mascara = false;
            $cldb_estrut->reload  = false;
            $cldb_estrut->input   = false;
            $cldb_estrut->size    = 10;
            $cldb_estrut->nome    = "t64_class";
            $cldb_estrut->db_opcao = 1;
            $cldb_estrut->db_mascara(@$t06_codcla);
            ?>
            <tr>
              <td width="4%" align="left" nowrap title="<?= $Tt52_descr ?>">
                <?= $Lt52_descr ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("t52_descr", 40, $It52_descr, true, "text", 4, "", "chave_t52_descr");
                ?>&nbsp;&nbsp;
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap title="<?= $Tdescrdepto ?>">
                <?= $Ldescrdepto ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("descrdepto", 40, $Idescrdepto, true, "text", 4, "");
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="button" id="limpar" value="Limpar" onClick="js_limpar();">
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_bens.hide();">
              </td>
            </tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <?
        $where_instit  = " and t52_instit = " . db_getsession("DB_instit");
        $where_baixado = " and not exists ( select 1 from bensbaix where bensbaix.t55_codbem = t52_bem )";
        if (isset($opcao) && $opcao == "todos") {
          $where_baixado = "";
        } else if (isset($opcao) && $opcao == "baixados") {
          $where_baixado = " and exists ( select 1 from bensbaix where bensbaix.t55_codbem = t52_bem )";
        }

        if (isset($campos) == false) {
          if (file_exists("funcoes/db_func_bens.php") == true) {
            include("funcoes/db_func_bens.php");
          } else {
            $campos = "bens.*";
          }
        }

        $campos = "distinct $campos";
        if (!isset($pesquisa_chave)) {


          $where = "";


          if (isset($t64_class) && trim($t64_class) != "") {
            //rotina q retira os pontos do estrutural da classe e busca o código do estrutural na tabela clabens
            $t64_class = str_replace(".", "", $t64_class);
            $where = " and t64_class = '$t64_class'";
          }

          if (isset($chave_t52_bem) && trim($chave_t52_bem)) {
            $where .= " and t52_bem = '$chave_t52_bem'";
          }

          if (isset($chave_t52_descr) && trim($chave_t52_descr)) {
            $where .= " and t52_descr like '$chave_t52_descr%'";
          }

          if (isset($descrdepto) && trim($descrdepto) != "") {
            $where .= " and descrdepto like '$descrdepto%'";
          }

          if (isset($chave_t52_ident) && trim($chave_t52_ident) != "") {
            $where .= " and t52_ident =  '$chave_t52_ident'";
          }


          $sql = "select
          distinct bens.t52_bem,
          bens.t52_valaqu,
          bens.t52_dtaqu,
          bens.t52_ident,
          bens.t52_descr,
          bens.t52_obs,
          db_depart.descrdepto,
          bens.t52_bensmarca,
          bens.t52_bensmedida,
          bens.t52_bensmodelo,
          t52_depart,
          t44_valoratual + t44_valorresidual as t44_valoratual,
          case
            when exists
        (
            select
              1
            from
              bensbaix
            where
              bensbaix.t55_codbem = t52_bem) then 'Baixado'::varchar
            else 'Ativo'::varchar
          end as dl_Situação
        from
          bens
        inner join db_depart on
          db_depart.coddepto = bens.t52_depart
        inner join bensmarca on
          bensmarca.t65_sequencial = bens.t52_bensmarca
        inner join bensmodelo on
          bensmodelo.t66_sequencial = bens.t52_bensmodelo
        inner join bensmedida on
          bensmedida.t67_sequencial = bens.t52_bensmedida
        inner join bensdepreciacao on
          t52_bem = t44_bens
        left join bensbaix on
          t52_bem = t55_codbem 
        where t55_codbem is null and
          t52_instit =  " . db_getsession("DB_instit") . $where . "
        order by
          t52_descr";

          db_lovrot($sql, 15, "()", "", $funcao_js);
        } else {
          if ($pesquisa_chave != null && $pesquisa_chave != "") {


            $sql = "select
            distinct bens.t52_bem,
            bens.t52_valaqu,
            bens.t52_dtaqu,
            bens.t52_ident,
            bens.t52_descr,
            bens.t52_obs,
            db_depart.descrdepto,
            bens.t52_bensmarca,
            bens.t52_bensmedida,
            bens.t52_bensmodelo,
            t52_depart,
            t44_valoratual + t44_valorresidual as t44_valoratual,
            case
              when exists
          (
              select
                1
              from
                bensbaix
              where
                bensbaix.t55_codbem = t52_bem) then 'Baixado'::varchar
              else 'Ativo'::varchar
            end as dl_Situação
          from
            bens
          inner join db_depart on
            db_depart.coddepto = bens.t52_depart
          inner join bensmarca on
            bensmarca.t65_sequencial = bens.t52_bensmarca
          inner join bensmodelo on
            bensmodelo.t66_sequencial = bens.t52_bensmodelo
          inner join bensmedida on
            bensmedida.t67_sequencial = bens.t52_bensmedida
          inner join bensdepreciacao on
            t52_bem = t44_bens
          left join bensbaix on
            t52_bem = t55_codbem 
          where t55_codbem is null and
            t52_instit = " .  db_getsession("DB_instit") . " and t52_bem =
            $pesquisa_chave
          order by
            t52_descr";

            $rsBem = db_query($sql);

            if (pg_num_rows($rsBem) != 0) {
              db_fieldsmemory($rsBem, 0);
              echo "<script>" . $funcao_js . "('$t52_descr','$t44_valoratual','$t52_depart','$descrdepto','$t52_valaqu','$t52_ident',false);</script>";
            } else {
              echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrada','','','','','',true);</script>";
            }
          } else {
            echo "<script>" . $funcao_js . "('',false);</script>";
          }
        }
        ?>
      </td>
    </tr>
  </table>
</body>

</html>
<script>
  document.getElementsByClassName('DBLovrotTdCabecalho').item(10).style.display = 'none';
  document.getElementsByClassName('DBLovrotTdCabecalho').item(11).style.display = 'none'

  for (i = 0; i < 15; i++) {
    document.getElementById('I' + i + '10').style.display = 'none';
    document.getElementById('I' + i + '11').style.display = 'none';
  }

  function js_troca(obj) {
    js_mascara02_t64_class();
  }

  function js_limpar() {
    document.form2.t64_class.value = "";
    document.form2.chave_t52_bem.value = "";
    document.form2.chave_t52_descr.value = "";
    document.form2.descrdepto.value = "";
  }
</script>
<?
if (!isset($pesquisa_chave)) {
?>
  <script>
  </script>
<?
}
?>