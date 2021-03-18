<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_veiculos_classe.php");
include("classes/db_veicresp_classe.php");
include("classes/db_veicpatri_classe.php");
include("classes/db_veicparam_classe.php");
include("classes/db_veiculoscomb_classe.php");
include("classes/db_veicitensobrig_classe.php");
include("classes/db_veicutilizacao_classe.php");
include("classes/db_veicutilizacaobem_classe.php");
include("classes/db_veicutilizacaoconvenio_classe.php");
include("classes/db_veiccentral_classe.php");
include("classes/db_tipoveiculos_classe.php");
include("classes/db_pcforne_classe.php");
include("classes/db_cgm_classe.php");
require_once ("classes/db_condataconf_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clveiculos               = new cl_veiculos;
$clveicresp               = new cl_veicresp;
$clveicpatri              = new cl_veicpatri;
$clveicparam              = new cl_veicparam;
$clveiculoscomb           = new cl_veiculoscomb;
$clveicitensobrig         = new cl_veicitensobrig;
$clveicutilizacao         = new cl_veicutilizacao;
$clveicutilizacaobem      = new cl_veicutilizacaobem;
$clveicutilizacaoconvenio = new cl_veicutilizacaoconvenio;
$clveiccentral            = new cl_veiccentral;
$cltipoveiculos           = new cl_tipoveiculos;
$clpcforne = new cl_pcforne;
$clcgm = new cl_cgm;

$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){

    $clcondataconf = new cl_condataconf;

    $sqlerro = false;

    if($sqlerro==false){

        // $result = db_query($clcondataconf->sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit')));
        // $c99_datapat = db_utils::fieldsMemory($result, 0)->c99_datapat;
        // $datecadastro = implode("-",array_reverse(explode("/",$ve01_dtaquis)));
        $anousu = db_getsession('DB_anousu');

        $sSQL = "select to_char(c99_datapat,'YYYY') c99_datapat
                  from condataconf
                    where c99_instit = ".db_getsession('DB_instit')."
                      order by c99_anousu desc limit 1";

        $rsResult       = db_query($sSQL);
        $maxC99_datapat = db_utils::fieldsMemory($rsResult, 0)->c99_datapat;

        $sNSQL = "";
        if ($anousu > $maxC99_datapat) {
          $sNSQL = $clcondataconf->sql_query_file($maxC99_datapat,db_getsession('DB_instit'),'c99_datapat');

        } else {
            $sNSQL = $clcondataconf->sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit'),'c99_datapat');
        }

        $result = db_query($sNSQL);
        $c99_datapat = db_utils::fieldsMemory($result, 0)->c99_datapat;
        $datecadastro = implode("-",array_reverse(explode("/",$ve01_dtaquis)));

        if($c99_datapat != "" && $datecadastro <= $c99_datapat){
            $sqlerro = true;
            $erro_msg = "O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.";
            unset($excluir);
            db_msgbox($erro_msg);
        }else{
            $sqlerro=false;
        }
    }
    db_inicio_transacao();
    $db_opcao = 3;

    if ($sqlerro==false){
        $res_veicpatri = $clveicpatri->sql_record($clveicpatri->sql_query(null,"ve03_codigo",null,"ve03_veiculo=$ve01_codigo"));
        if ($clveicpatri->numrows > 0){
            for($x = 0; $x < $clveicpatri->numrows; $x++){
                db_fieldsmemory($res_veicpatri,$x);

                $clveicpatri->ve03_codigo = $ve03_codigo;
                $clveicpatri->excluir($ve03_codigo);
                $erro_msg=$clveicpatri->erro_msg;
                if ($clveicpatri->erro_status=="0"){
                    $sqlerro=true;
//       		 $erro_msg=$clveicpatri->erro_msg;
                    break;
                }
            }
        }
    }

//  db_msgbox("1 ".$erro_msg);
    if ($sqlerro==false){
        $clveicresp->excluir(null," ve02_veiculo=$ve01_codigo");
        $erro_msg=$clveicresp->erro_msg;
        if($clveicresp->erro_status=="0"){
            $sqlerro=true;
//  		$erro_msg=$clveicresp->erro_msg;
        }
    }

//  db_msgbox("2 ".$erro_msg);
    if ($sqlerro==false){
        $res_veiculoscomb = $clveiculoscomb->sql_record($clveiculoscomb->sql_query_file(null,"ve06_sequencial",null,"ve06_veiculos = $ve01_codigo"));
        if ($clveiculoscomb->numrows > 0){
            for($x = 0; $x < $clveiculoscomb->numrows; $x++){
                db_fieldsmemory($res_veiculoscomb,$x);

                $oDaoCombustivel = db_utils::getDao('veiculoscomb');
                $oDaoCombustivel->excluir($ve06_sequencial);

                $erro_msg = $oDaoCombustivel->erro_msg;
                if ($oDaoCombustivel->erro_status == "0"){
                    $sqlerro = true;
                    $erro_msg = $oDaoCombustivel->erro_msg;
                    break;
                }
            }
        }
    }

//  db_msgbox("3 ".$erro_msg);
    if ($sqlerro==false){
        $res_veicitensobrig = $clveicitensobrig->sql_record($clveicitensobrig->sql_query(null,"ve09_sequencial",null,"ve09_veiculos=$ve01_codigo"));
        if ($clveicitensobrig->numrows > 0){
            for($x = 0; $x < $clveicitensobrig->numrows; $x++){
                db_fieldsmemory($res_veicitensobrig,$x);
                $oDaoItem = db_utils::getDao('veicitensobrig');
                $oDaoItem->excluir($ve09_sequencial);

                if ($oDaoItem->erro_status == "0"){
                    $erro_msg = $oDaoItem->erro_msg;
                    $sqlerro  = true;
                    break;
                }
            }
        }
    }


//  db_msgbox("4 ".$erro_msg);
    if ($sqlerro==false){
        $res_veicutilizacao = $clveicutilizacao->sql_record($clveicutilizacao->sql_query(null,"ve15_sequencial as seq",null,"ve15_veiculos=$ve01_codigo"));
        if ($clveicutilizacao->numrows > 0){
            for($x = 0; $x < $clveicutilizacao->numrows; $x++){
                db_fieldsmemory($res_veicutilizacao,$x);

                $res_veicutilizacaobem = $clveicutilizacaobem->sql_record($clveicutilizacaobem->sql_query(null,"ve16_sequencial",null,"ve16_veicutilizacao=$seq"));
                if ($clveicutilizacaobem->numrows > 0){
                    db_fieldsmemory($res_veicutilizacaobem,0);

                    $clveicutilizacaobem->ve16_sequencial = $ve16_sequencial;
                    $clveicutilizacaobem->excluir($ve16_sequencial);
                    if ($clveicutilizacaobem->erro_status == "0"){
                        $sqlerro  = true;
                        $erro_msg = $clveicutilizacaobem->erro_msg;
                        break;
                    }
                }

                $res_veicutilizacaoconvenio = $clveicutilizacaoconvenio->sql_record($clveicutilizacaoconvenio->sql_query(null,"ve19_sequencial",null,"ve19_veicutilizacao=$seq"));
                if ($clveicutilizacaoconvenio->numrows > 0){
                    db_fieldsmemory($res_veicutilizacaoconvenio,0);

                    $clveicutilizacaoconvenio->ve19_sequencial = $ve19_sequencial;
                    $clveicutilizacaoconvenio->excluir($ve19_sequencial);
                    if ($clveicutilizacaoconvenio->erro_status == "0"){
                        $sqlerro  = true;
                        $erro_msg = $clveicutilizacaoconvenio->erro_msg;
                        break;
                    }
                }
            }

            if ($sqlerro == false){
                $res_veicutilizacao = $clveicutilizacao->sql_record($clveicutilizacao->sql_query(null,"ve15_sequencial",null,"ve15_veiculos=$ve01_codigo"));
                for($x = 0; $x < $clveicutilizacao->numrows; $x++){
                    db_fieldsmemory($res_veicutilizacao,$x);

                    $clveicutilizacao->ve15_sequencial = $ve15_sequencial;
                    $clveicutilizacao->excluir($ve15_sequencial);
                    if ($clveicutilizacao->erro_status == "0"){
                        $sqlerro  = true;
                        $erro_msg = $clveicutilizacao->erro_msg;
                        break;
                    }
                }
            }
        }
    }

    if ($sqlerro==false){
        $clveiccentral->ve40_veiculos = $ve01_codigo;

        $clveiccentral->excluir(null,"ve40_veiculos = $ve01_codigo");
        if ($clveiccentral->erro_status=="0"){
            $sqlerro  = true;
            $erro_msg = $clveiccentral->erro_msg;
        }
    }

    /*
     * Exclui Tipo Veiculo
     */
    if ($sqlerro==false){
        $cltipoveiculos->excluir(null,"si04_veiculos = $ve01_codigo");
        $erro_msg=$cltipoveiculos->erro_msg;
        if($cltipoveiculos->erro_status=="0"){
            $sqlerro=true;
        }
    }

    //db_msgbox("5 ".$erro_msg);
    if ($sqlerro==false){
        $clveiculos->excluir($ve01_codigo);
        $erro_msg=$clveiculos->erro_msg;
        if($clveiculos->erro_status=="0"){
            $sqlerro=true;
        }
    }
    //db_msgbox("6 ".$erro_msg);
    db_fim_transacao($sqlerro);
}else if(isset($chavepesquisa)){
    $db_opcao = 3;
    $result = $clveiculos->sql_record($clveiculos->sql_query($chavepesquisa));
    db_fieldsmemory($result,0);
    $db_botao = true;
    $result_resp = $clveicresp->sql_record($clveicresp->sql_query(null,"*",null," ve02_veiculo = $chavepesquisa "));
    if ($clveicresp->numrows>0){
        db_fieldsmemory($result_resp,0);
    }
    $result_patri = $clveicpatri->sql_record($clveicpatri->sql_query(null,"*",null," ve03_veiculo = $chavepesquisa "));
    if ($clveicpatri->numrows>0){
        db_fieldsmemory($result_patri,0);
    }

    /*
     * Result para modulo sicom
     */
    $result_tipoveiculos = $cltipoveiculos->sql_record($cltipoveiculos->sql_query(null,"*",null," si04_veiculos = $chavepesquisa"));
    if ($cltipoveiculos->numrows > 0){
        db_fieldsmemory($result_tipoveiculos,0);
        $rsCGM = $clcgm->sql_record($clcgm->sql_query(null,"z01_nome as z01_nomecgm",null," z01_numcgm = $si04_numcgm"));
        db_fieldsmemory($rsCGM,0);
    }
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>

    #ve01_veiccadcor, #ve01_veiccadmarca, #ve01_veiccadcategcnh, #ve01_veictipoabast{
        display: none;
    }

    #ve01_veiccadpotencia, #ve01_veiccadtipocapacidade{
        width: 93px;
    }

    #ve01_veiccadpotenciadescr, #ve01_veiccadtipocapacidadedescr{
        width: 212px;
    }

    #si04_tipoveiculo, #si04_especificacao{
        width: 184px;
    }

    #si04_situacao, #ve01_veiccadmarcadescr{
        width: 395px;
    }

    #ve02_numcgm, #ve01_veiccadtipo{
        width: 84px;
    }

    #ve06_veiccadcomb{
        width: 394px;
    }

    #ve01_veiccadcategdescr,
    #ve01_veiccadproceddescr{
        width: 133px;
    }

    #ve01_veiccadtipodescr{
        width: 307px;
    }

    #ve01_veiccadcordescr{
        width: 182px;
    }

    #ve01_veictipoabastdescr, #ve01_veiccadcategcnhdescr{
        width: 180px;
    }

    .div__anos{
        margin-left: -3px;
    }

    .tr__hidden-veiculos{
        display: none;
    }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
                <?
                include("forms/db_frmveiculos.php");
                ?>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
<?
if(isset($excluir)){
    if($clveiculos->erro_status=="0"&&$sqlerro==true){
        db_msgbox($erro_msg);
        //$clveiculos->erro(true,false);
    }else{
        $clveiculos->erro(true,true);
    }
}
if($db_opcao==33){
    echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
    js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
