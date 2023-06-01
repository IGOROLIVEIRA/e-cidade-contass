<?


require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bensplaca_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clbensplaca = new cl_bensplaca;
$clbensplaca->rotulo->label("t41_codigo");
$clbensplaca->rotulo->label("t41_codigo");
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
              <td width="4%" align="right" nowrap title="<?= $Tt41_codigo ?>">
                <b>Placa: </b>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("t52_ident", 6, $It41_codigo, true, "text", 4, "", "t52_ident");
                ?>
              </td>
            </tr>

            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="reset" id="limpar" value="Limpar">
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_bensplaca.hide();">
              </td>
            </tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <?

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

          if (isset($t52_ident) && trim($t52_ident) != "") {

            $where = " and t52_ident = '$t52_ident'";
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
             t52_instit =  " . db_getsession("DB_instit") . " and t52_ident = '$pesquisa_chave'
          order by
            t52_descr";


            $rsBem = db_query($sql);

            if (pg_num_rows($rsBem) != 0) {
              db_fieldsmemory($rsBem, 0);
              echo "<script>" . $funcao_js . "('$t52_bem','$t52_descr','$t44_valoratual','$t52_depart','$descrdepto','$t52_valaqu','$t52_ident',false);</script>";
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

  function js_limpar() {
    document.form2.t52_ident.value = "";
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