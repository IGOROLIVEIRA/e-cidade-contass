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
include("classes/db_veictipoabast_classe.php");
include("classes/db_veiccentral_classe.php");
include("classes/db_tipoveiculos_classe.php");
include("classes/db_pcforne_classe.php");
include("classes/db_cgm_classe.php");
require_once ("classes/db_condataconf_classe.php");

db_postmemory($HTTP_POST_VARS);

$clveiculos      = new cl_veiculos;
$clveicresp      = new cl_veicresp;
$clveicpatri     = new cl_veicpatri;
$clveicparam     = new cl_veicparam;
$clveiculoscomb  = new cl_veiculoscomb;
$clveictipoabast = new cl_veictipoabast;
$clveiccentral   = new cl_veiccentral;
$cltipoveiculos  = new cl_tipoveiculos;
$clpcforne       = new cl_pcforne;

$db_opcao = 1;
$db_botao = true;

if(isset($incluir)){
    $clcondataconf = new cl_condataconf;

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
        }else{
            $sqlerro=false;
        }
    }

    db_inicio_transacao();

    if ($sqlerro == false){
        $clveiculos->ve01_ativo = 1;

        $rsResultado = $clveiculos->sql_record($clveiculos->sql_query_placa(null,"*",null,"ve01_placa = '$ve01_placa' AND ve01_instit <> ".db_getsession('DB_instit')));
        if($rsResultado){
          $resultado = db_utils::fieldsMemory($rsResultado, 0);
        }else $resultado = '';

        if(!$resultado){
          if ($si04_tipoveiculo == 3 && $ve01_placa != '') {
              $result = $clveiculos->sql_record($clveiculos->sql_query_file(null,"*",null,"ve01_placa = '$ve01_placa'"));
              if ($clveiculos->numrows > 0){
                  $sqlerro  = true;
                  $erro_msg = "Placa já cadastrada para outro veículo. Verifique.";
                  $clveiculos->erro_campo = "ve01_placa";
              }
          }

          if ($si04_tipoveiculo == 3 && $ve01_ranavam != '' ) {
              $result = $clveiculos->sql_record($clveiculos->sql_query_file(null,"*",null,"ve01_ranavam = $ve01_ranavam"));
              if ($clveiculos->numrows > 0){
                  $sqlerro  = true;
                  $erro_msg = "Renavam já cadastrado para outro veículo. Verifique.";
                  $clveiculos->erro_campo = "ve01_ranavam";
              }
          }

          if ($si04_tipoveiculo == 3 && $ve01_chassi != '') {
              $result = $clveiculos->sql_record($clveiculos->sql_query_file(null,"*",null,"ve01_chassi = '$ve01_chassi'"));
              if ($clveiculos->numrows > 0){
                  $sqlerro  = true;
                  $erro_msg = "Chassi já cadastrado para outro veículo. Verifique.";
                  $clveiculos->erro_campo = "ve01_chassi";
              }
          }
        }

        if($si04_especificacao == 0 || $si04_especificacao == ''){
          $sqlerro  = true;
          $erro_msg = "Especificação do veículo não informado. Verifique.";
          $clveiculos->erro_campo = "si04_especificacao";
        }

        if($si04_tipoveiculo == 0 || $si04_tipoveiculo == ''){
          $sqlerro  = true;
          $erro_msg = "Tipo do veículo não informado. Verifique.";
          $clveiculos->erro_campo = "si04_tipoveiculo";
        }

        if ($sqlerro==false){

            $clveiculos->incluir(null,$si04_tipoveiculo);
            $erro_msg=$clveiculos->erro_msg;
            if ($clveiculos->erro_status=="0"){
                $sqlerro=true;
            }

            if ($sqlerro == false){
                if ($cod_comb == '') {
                    $sqlerro  = true;
                    $erro_msg = "Nenhum combustível selecionado";
                    $clveiculos->erro_campo = "ve06_veiccadcomb";
                } else {
                    $ve01_codigo       = $clveiculos->ve01_codigo;
                    $vetor_comb        = split(",",$cod_comb);
                    $vetor_comb_padrao = split(",",$comb_padrao);

                    $inc_comb          = array(array("ve06_veiculos","ve06_veiccadcomb","ve06_padrao"));
                    $inc_contador      = 0;

                    for($x = 0; $x < count($vetor_comb); $x++){
                        $inc_comb["ve06_veiculos"][$inc_contador]    = $ve01_codigo;
                        $inc_comb["ve06_veiccadcomb"][$inc_contador] = $vetor_comb[$x];
                        for($xx = $x; $xx < count($vetor_comb_padrao); $xx++){
                            $inc_comb["ve06_padrao"][$inc_contador] = $vetor_comb_padrao[$xx];
                            break;
                        }

                        $inc_contador++;
                    }

                    for($x = 0; $x < $inc_contador; $x++){
                        $clveiculoscomb->ve06_veiculos    = $inc_comb["ve06_veiculos"][$x];
                        $clveiculoscomb->ve06_veiccadcomb = $inc_comb["ve06_veiccadcomb"][$x];

                        if ($inc_comb["ve06_padrao"][$x] == 1){
                            $padrao = "true";
                        } else {
                            $padrao = "false";
                        }

                        $clveiculoscomb->ve06_padrao = $padrao;
                        $clveiculoscomb->incluir(null);
                        if ($clveiculoscomb->erro_status == 0){
                            $sqlerro  = true;
                            $erro_msg = $clveiculoscomb->erro_msg;
                            break;
                        }
                    }
                }
            }

        }

        if ($sqlerro==false){

            if(!in_array($si04_tipoveiculo, array(1, 2, 4, 5, 99))){
                $clveicresp->ve02_veiculo=$clveiculos->ve01_codigo;
                $clveicresp->incluir(null);
                if ($clveicresp->erro_status=="0"){
                    $sqlerro=true;
                    $erro_msg=$clveicresp->erro_msg;
                }
            }
        }
        /*
            if ($sqlerro==false){
              $clveiccentral->ve40_veiculos       = $clveiculos->ve01_codigo;
              $clveiccentral->ve40_veiccadcentral = $ve40_veiccadcentral;

              $clveiccentral->incluir(null);
              if ($clveiccentral->erro_status=="0"){
                $sqlerro  = true;
                $erro_msg = $clveiccentral->erro_msg;
              }
            }
         */

        if ($sqlerro==false){
            if (isset($ve03_bem)&&$ve03_bem){
                $clveicpatri->ve03_veiculo=$clveiculos->ve01_codigo;
                $clveicpatri->incluir(null);
                if ($clveicresp->erro_status=="0"){
                    $sqlerro=true;
                    $erro_msg=$clveicresp->erro_msg;
                }
            }
        }
    }

    if ($sqlerro==false) {
        $cltipoveiculos->si04_veiculos=$clveiculos->ve01_codigo;
        $cltipoveiculos->si04_numcgm = $si04_numcgm;
        $cltipoveiculos->incluir(null);
        if ($cltipoveiculos->erro_status=="0") {
            $sqlerro=true;
            $erro_msg=$cltipoveiculos->erro_msg;
        }
    }

    if ($sqlerro == false){

        $rsResultado = db_query("
    select ve36_sequencial
      from veiccadcentral
        where ve36_coddepto = ".db_getsession("DB_coddepto")."
    ");

        $veiccent = db_utils::fieldsMemory($rsResultado, 0);
        $clveiccentral->ve40_veiccadcentral = $veiccent->ve36_sequencial;
        $clveiccentral->ve40_veiculos       = $clveiculos->ve01_codigo;
        $clveiccentral->incluir(null);
        if ($clveiccentral->erro_status == 0){
            $sqlerro = true;
            $erro_msg = $clveiccentral->erro_msg;
        }
    }


    db_fim_transacao($sqlerro);
}

if (isset($codveictipoabast) && trim($codveictipoabast)!=""){
    $result_veictipoabast = $clveictipoabast->sql_record($clveictipoabast->sql_query($codveictipoabast,"ve07_sigla"));
    if ($clveictipoabast->numrows > 0){
        db_fieldsmemory($result_veictipoabast,0);
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

    .tr__hidden-veiculos{
        display: none;
    }

    .div__anos{
        margin-left: -3px;
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
<script>
    js_tabulacaoforms("form1","ve01_placa",true,1,"ve01_placa",true);
    document.getElementById('si04_especificacao').value = "<?=$si04_especificacao?>";
    document.getElementById('ve06_veiccadcomb').value = "<?=$ve06_veiccadcomb?>";
</script>
<?
if(isset($incluir)){
    if($clveiculos->erro_status=="0"||$sqlerro==true){
        db_msgbox($erro_msg);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clveiculos->erro_campo!=""){
            echo "<script> document.form1.".$clveiculos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clveiculos->erro_campo.".focus();</script>";
        }
        unset($incluir);
    }else{
        db_msgbox($erro_msg);
        db_redireciona("vei1_veiculos005.php?chavepesquisa=$ve01_codigo&liberaaba=true");
    }
}
?>
