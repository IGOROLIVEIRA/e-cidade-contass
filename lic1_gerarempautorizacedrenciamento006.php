<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_empautpresta_classe.php");
require_once("classes/db_empprestatip_classe.php");
require_once("classes/db_empautoriza_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_orcreserva_classe.php");
require_once("classes/db_orcreservaaut_classe.php");
require_once("classes/db_empauthist_classe.php");
require_once("classes/db_emphist_classe.php");
require_once("classes/db_emptipo_classe.php");
require_once("classes/db_cflicita_classe.php");
require_once("classes/db_db_depusu_classe.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_concarpeculiar_classe.php");
require_once("model/CgmFactory.model.php");
require_once("model/fornecedor.model.php");
require_once("classes/db_empautorizaprocesso_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clempautpresta                   = new cl_empautpresta;
$clempprestatip                   = new cl_empprestatip;
$clpctipocompra                   = new cl_pctipocompra;
$clempautoriza                    = new cl_empautoriza;
$clempautitem                     = new cl_empautitem;
$clempauthist                     = new cl_empauthist;
$clorcreserva                     = new cl_orcreserva;
$clorcreservaaut                  = new cl_orcreservaaut;
$clemphist                        = new cl_emphist;
$clemptipo                        = new cl_emptipo;
$clcflicita                       = new cl_cflicita;
$cldb_depusu                      = new cl_db_depusu;
$clpcprocitem                     = new cl_pcprocitem;
$clempparametro                   = new cl_empparametro;
$clpcparam                        = new cl_pcparam;
$clconcarpeculiar                 = new cl_concarpeculiar;
$oDaoEmpenhoProcessoAdminitrativo = new cl_empautorizaprocesso;

$sUrlEmpenho      = "emp1_empempenho001.php";
$rsemparam = $clempparametro->sql_record($clempparametro->sql_query(db_getsession("DB_anousu")));

if ($clempparametro->numrows > 0) {
    db_fieldsmemory($rsemparam, 0);
    if ($e30_notaliquidacao != '') {
        $sUrlEmpenho      = "emp4_empempenho001.php";
    }
}

$anulacao=false;//padrao
$sqlerro =false;

if ( isset($excluir) ) {

    try {
        $oFornecedor = new fornecedor($e54_numcgm);
        $oFornecedor->verificaBloqueioAutorizacaoEmpenho(null);
        $iStatusBloqueio = $oFornecedor->getStatusBloqueio();
    } catch (Exception $eException) {
        $sqlerro  = true;
        $erro_msg = $eException->getMessage();
    }

    if ( !$sqlerro ) {

        if($iStatusBloqueio == 2){
            db_msgbox("\\nusuário:\\n\\n Fornecedor com débito na prefeitura !\\n\\n\\n\\n");
        }
    }
}

if(isset($excluir) && !$sqlerro ) {

    $db_opcao = 3;
    $db_botao = true;

    db_query("delete from orcreservaaut where o83_autori = ".$e54_autori);
    db_query("delete from empautorizaprocesso where e150_empautoriza = ".$e54_autori);
    db_query("delete from empautidot where e56_autori = ".$e54_autori);
    db_query("delete from empautitempcprocitem where e73_autori = ".$e54_autori);
    db_query("delete from empautitem where e55_autori = ".$e54_autori);
    db_query("delete from empempaut where e61_autori = ".$e54_autori);
    db_query("delete from empauthist where e57_autori = ".$e54_autori);
    db_query("delete from empautoriza where e54_autori = ".$e54_autori);

    if(pg_last_error() == true){
        db_msgbox('ERRO: Autorização não foi excluida '.pg_last_error());
    }else{
        db_msgbox('Autorização excluida com sucesso');
        db_redireciona("emp1_empautorizataxatabela006.php");
    }

} else if(isset($chavepesquisa)) {

    $result = $clempautoriza->sql_record($clempautoriza->sql_query($chavepesquisa));
    db_fieldsmemory($result,0);
    if($e54_login != db_getsession("DB_id_usuario")) {

        $result = $cldb_depusu->sql_record($cldb_depusu->sql_query_file(db_getsession("DB_id_usuario"),$e54_depto,'coddepto as cod02'));

        if ($cldb_depusu->numrows == 0) {
            $erro_msg="Usuário sem permissão de alterar!";
        }
    }
    $result = $clempautpresta->sql_record($clempautpresta->sql_query_file(null,"*","e58_autori","e58_autori=$e54_autori"));
    if ($clempautpresta->numrows>0) {

        db_fieldsmemory($result,0);
        $e44_tipo = $e58_tipo;
    }
    if (empty($erro_msg)) {

        if ($e54_anulad != "") {

            $anulacao=true;
            $db_opcao = 33;
            $db_botao = false;
        } else {

            $anulacao=false;
            $db_opcao = 3;
            $db_botao = true;
        }

        $result=$clempauthist->sql_record($clempauthist->sql_query_file($e54_autori));
        if($clempauthist->numrows>0){
            db_fieldsmemory($result,0);
        }

        /**
         * Busca os Dados do Processo administrativo
         */
        $sWhereProcessoAdministrativo = " e150_empautoriza = {$e54_autori}";
        $sSqlProcessoAdministrativo   = $oDaoEmpenhoProcessoAdminitrativo->sql_query_file(null,
            "e150_numeroprocesso",
            null,
            $sWhereProcessoAdministrativo);
        $rsProcessoAdministrativo     = $oDaoEmpenhoProcessoAdminitrativo->sql_record($sSqlProcessoAdministrativo);

        if ($oDaoEmpenhoProcessoAdminitrativo->numrows > 0) {
            $e150_numeroprocesso = db_utils::fieldsMemory($rsProcessoAdministrativo, 0)->e150_numeroprocesso;
        }
    }

}

$db_opcao = 3;
$db_botao = true;

if(isset($e54_autori)){
    $emprocesso = false;
    $result_autoriza_de_pc = $clpcprocitem->sql_record($clpcprocitem->sql_query_itememautoriza(null,"e55_sequen",""," e55_autori=$e54_autori and e54_anulad is null "));
    if ($clpcprocitem->numrows > 0) {

        $db_botao = true;
        $emprocesso = true;
    }
    /**
     * Verifica se autorizacao é de contrato
     */
    $oDaoAutorizaContrato = db_utils::getDao("acordoitemexecutadoempautitem");
    $sSqlAutoriza         = $oDaoAutorizaContrato->sql_query(null,"ac20_acordoposicao",
        null, "e54_autori={$e54_autori}"
    );
    $rsDadosContrato      = $oDaoAutorizaContrato->sql_record($sSqlAutoriza);
    if ($oDaoAutorizaContrato->numrows > 0) {
        $emprocesso = true;
    }
}

$pctipocompras  = db_query("
                      select pc50_codcom, pc50_descr from pctipocompra order by pc50_codcom
                  ");
$aPctipocompras = db_utils::getCollectionByRecord($pctipocompras);

$emptipos  = db_query("
                      select e41_codtipo, e41_descr from emptipo order by e41_codtipo
                  ");
$aEmptipos = db_utils::getCollectionByRecord($emptipos);

$cflicitas  = db_query("
                    select l03_codigo, l03_descr, l03_tipo from cflicita order by l03_codigo
                  ");
$aCflicitas = db_utils::getCollectionByRecord($cflicitas);
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js, strings.js, widgets/dbtextField.widget.js,
                 dbViewNotificaFornecedor.js, dbmessageBoard.widget.js, dbautocomplete.widget.js,
                 dbcomboBox.widget.js,datagrid.widget.js,widgets/dbtextFieldData.widget.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
    <div style="margin-top: 25px; width: 600px;">
        <?
        include("forms/db_frmempautorizataxatabela.php");
        ?>
    </div>
</center>
</body>
</html>
<?
if(isset($erro_msg)){
    db_msgbox($erro_msg);
    //db_redireciona("emp1_empautoriza005.php");
}
//////////////////////////////////////////////////

if(isset($chavepesquisa)){
    if($anulacao==false && $emprocesso==false){
        echo "
          <script>
           function js_libera(recar){
            parent.document.formaba.empautitem.disabled=false;\n
            parent.document.formaba.empautidot.disabled=false;\n
            top.corpo.iframe_empautitem.location.href='emp1_empautitemtaxatabela001.php?db_opcaoal=33&criterioadjudicacao=true&e55_autori=$e54_autori&z01_numcgm=$e54_numcgm';\n
            top.corpo.iframe_empautidot.location.href='emp1_empautidottaxatabela001.php?db_opcaoal=33&criterioadjudicacao=true&e56_autori=$e54_autori&z01_numcgm=$e54_numcgm';\n
           }
           js_libera();
          </script>
           ";
    }else{
        if($anulacao == true){
            echo "
              <script>
                function js_bloqueia(recar){
                  parent.document.formaba.empautitem.disabled=false;\n
                  parent.document.formaba.empautidot.disabled=false;\n
                  top.corpo.iframe_empautitem.location.href='emp1_empautitemtaxatabela001.php?db_opcaoal=33&criterioadjudicacao=true&e55_autori=$e54_autori&z01_numcgm=$e54_numcgm';\n
                  top.corpo.iframe_empautidot.location.href='emp1_empautidottaxatabela001.php?db_opcaoal=33&criterioadjudicacao=true&e56_autori=$e54_autori&z01_numcgm=$e54_numcgm';\n
                }
                js_bloqueia();
              </script>
             ";
        } else {
            echo "
              <script>
                function js_bloqueia(recar){
                  parent.document.formaba.empautitem.disabled=false;\n
                  parent.document.formaba.empautidot.disabled=false;\n
                  top.corpo.iframe_empautitem.location.href='emp1_empautitemtaxatabela001.php?db_opcaoal=33&criterioadjudicacao=true&e55_autori=$e54_autori&z01_numcgm=$e54_numcgm';\n
                  top.corpo.iframe_empautidot.location.href='emp1_empautidottaxatabela001.php?db_opcaoal=33&criterioadjudicacao=true&e56_autori=$e54_autori&z01_numcgm=$e54_numcgm';\n
                }
                js_bloqueia();
              </script>
             ";
        }
    }
} else {
    echo "<script>document.form1.pesquisar.click();</script>";
}


/////////////////////////////////////////////
if(isset($alterar)){
    if($sqlerro == true){
        //    $clempautoriza->erro(true,false);
        $db_botao=true;
        if($clempautoriza->erro_campo!=""){
            echo "<script> document.form1.".$clempautoriza->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clempautoriza->erro_campo.".focus();</script>";
        }
    }else{
        $clempautoriza->erro(true,false);
    }
}
?>
