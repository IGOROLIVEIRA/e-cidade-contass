<?php

/**
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
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_rhpesbanco_classe.php");
require_once("classes/db_contabancaria_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);


$clrotulo = new rotulocampo;
$clrhpessoalmov    = new cl_rhpessoalmov;

$clrhpesbanco      = new cl_rhpesbanco;
$clrhpespadrao     = new cl_rhpespadrao;
$clrhpessoal       = new cl_rhpessoal;
$clcontabancaria   = new cl_contabancaria;

$clrhpessoalmov->rotulo->label();



$clrhpessoal->rotulo->label();
$clrotulo->label("rh02_regist");
$clrotulo->label("z01_nome");
if(isset($salvar)){
 $erro = false;
/*
procedimentos

1 - faz uma consulta para verificar quantas contas bancárias existem para aquele sujeito, pegue a quantidade maxima de registros e salve
2 - salva a quantidade de contas
3 - realiza o update na tabela rhpesbanco
4 - verifica se foi criado uma novo registro na tabela de contas bancarias e [pege o max(id) e compare com a quantidade de registros de antes, se for maior, verifique se esse ultimo registro tem a mesma db83_descricao do penultimo ]
  4.1 - se foi criado, atualiza esse registro com os dados restantes
  4.2 - se não foi criado, verifica se os dados da nova submissao são diferentes dos existentes, caso seja, atualize
  */
  $sContasCadastradas = "SELECT DISTINCT rh138_contabancaria
  FROM rhpesbanco
  RIGHT JOIN rhpessoalmov ON rh02_seqpes = rh44_seqpes
  JOIN contabancaria ON  rh44_conta = db83_conta
  JOIN rhpessoalmovcontabancaria ON db83_sequencial = rh138_contabancaria and rh138_rhpessoalmov = rh02_seqpes
  WHERE rh02_anousu = {$rh02_anousu} AND rh02_mesusu = {$rh02_mesusu} AND rh02_regist = {$rh02_regist} ";

  $rsContasAntesUpdate = db_query($sContasCadastradas);
  $iContasAntesUpdate = pg_num_rows($rsContasAntesUpdate);


  /*VALIDACOES NECESSÁRIAS*/
  $rsNumSequenciaMes = db_query("SELECT rh02_seqpes AS rh44_seqpes
    FROM rhpesbanco
    RIGHT JOIN rhpessoalmov ON rh02_seqpes = rh44_seqpes
    WHERE rh02_anousu = '$rh02_anousu'
    AND rh02_mesusu = '$rh02_mesusu'
    AND rh02_regist = '$rh02_regist' ");

  $iNumSequenciaMes = db_utils::fieldsMemory($rsNumSequenciaMes);

  $clrhpesbanco->rh44_seqpes = $iNumSequenciaMes->rh44_seqpes;
  $clrhpesbanco->rh44_codban = $HinputCodigoBanco;
  $clrhpesbanco->rh44_agencia = $HinputNumeroAgencia;
  $clrhpesbanco->rh44_dvagencia = $HinputDvAgencia;
  $clrhpesbanco->rh44_conta = $HinputNumeroConta;
  $clrhpesbanco->rh44_dvconta = $HinputDvConta;
  if($iContasAntesUpdate == 0){
    $clrhpesbanco->excluir($iNumSequenciaMes->rh44_seqpes);
    $clrhpesbanco->incluir($iNumSequenciaMes->rh44_seqpes);
  }else{
    $clrhpesbanco->alterar($iNumSequenciaMes->rh44_seqpes);

  }
  $erro_msg = $clrhpesbanco->erro_msg;
  echo "<script>";
  echo "alert('$erro_msg')";
  echo "</script>";

  $rsContasDepoisUpdate = db_query($sContasCadastradas);
  $iContasDepoisUpdate = pg_num_rows($rsContasDepoisUpdate);

    db_query($sUpdate);
    $sAtualizaRhmov = "UPDATE rhpessoalmov SET rh02_fpagto = {$rh02_fpagto}  WHERE rh02_regist = {$rh02_regist} AND rh02_anousu = {$rh02_anousu} AND rh02_mesusu = {$rh02_mesusu} ";

    db_query($sAtualizaRhmov);


  }
if(isset($rh02_regist)){
$sConsultaMov = "SELECT * FROM rhpessoalmov WHERE rh02_mesusu = {$rh02_mesusu}
AND rh02_anousu = {$rh02_anousu} AND
rh02_regist = {$rh02_regist} ";

$sConsultaMov = db_query($sConsultaMov);

if(pg_num_rows($sConsultaMov) == 0){

  echo "<script>";
  echo "alert('Não forão encontrado movimentações para a data especificada.');";
  echo " window.location.href='pes4_contabancaria001.php';";
  echo "</script>";
}
$result_nome = db_query("SELECT z01_nome, rh02_fpagto
  FROM rhpessoal
  INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
  AND rh02_mesusu = ".$rh02_mesusu."
  AND rh02_anousu = ".$rh02_anousu."
  AND rh02_instit = ".db_getsession("DB_instit")."
  INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
  WHERE rhpessoal.rh01_regist = ".$rh02_regist."");

db_fieldsmemory($result_nome,0);

$sConta = "SELECT max(db83_sequencial) as rh138_contabancaria
FROM rhpesbanco
RIGHT JOIN rhpessoalmov ON rh02_seqpes = rh44_seqpes
JOIN contabancaria ON  rh44_conta = db83_conta
WHERE rh02_anousu = '$rh02_anousu'
AND rh02_mesusu = '$rh02_mesusu'
AND rh02_regist = '$rh02_regist' ";

$rsConta = db_query($sConta);
if(pg_num_rows($rsConta) == 0){

  echo "<script>";
  echo "alert('Não foram encontradas contas bancárias para a data especificada.');";
  echo " window.location.href='pes4_contabancaria001.php';";
  echo "</script>";
}
$rsConta = db_utils::fieldsMemory($rsConta);

}



?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <?
  db_app::load("scripts.js");
  db_app::load("prototype.js");
  db_app::load("strings.js");
  db_app::load("dbautocomplete.widget.js");
  db_app::load("DBViewContaBancariaServidor.js");
  db_app::load("estilos.css");
  db_app::load("grid.style.css");
  db_app::load("dbtextField.widget.js");
  db_app::load("dbmessageBoard.widget.js");
  db_app::load("dbcomboBox.widget.js");
  db_app::load("prototype.maskedinput.js");
  ?>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <?php db_menu(); ?>
  <br>
  <br>
  <br>
  <table width="70%" align="center" border="0" cellspacing="0" cellpadding="0">
    <form accept-charset="utf-8" name="form1" method="post" action="">
      <tr>
        <td align="center"><b>Ano / Mes : </b> <?php db_input('rh02_anousu',4,null,null,'text', '','onchange="mudadata()";'); ?> / <?php db_input('rh02_mesusu',2,null,null,'text', '','onchange="mudadata()";'); ?></td>
      </tr>
      <tr>
        <tr>
          <td align="center" nowrap title="<?=@$Trh02_regist?>">
            <?
            db_ancora("Código do Funcionário: ","js_pesquisarh02_regist(true);",1);
            ?>

            <?
            db_input('rh02_regist',6,$Irh02_regist,true,'text',1,"onchange='js_pesquisarh02_regist(false);'", '');

            db_input('z01_nome',34,$Iz01_nome,true,'text',3,'');

            ?>
          </td>

        </tr>
        <td align="left" valign="top" bgcolor="#CCCCCC">
          <center>

            <tr>
             <td nowrap title="<?=@$Trh02_fpagto?>" align="center">
              <?=@$Lrh02_fpagto?>


              <?
              $arr_fpagto = array('3' => 'Crédito em conta',
                '1' => 'Dinheiro',
                '2' => 'Cheque',
                '4' => 'Cheque/Pagamento Administrativo'
                );
              db_select("rh02_fpagto",$arr_fpagto,true,$db_opcao);
              ?>
            </td>
          </tr>
          <tr>
            <td align="center" width="100%">
              <div id="ctnContaBancariaServidor"></div>
            </td>
          </tr>
        </center>
      </td>
      <tr>
        <td align="center">
          <input type="submit" name="salvar" value="Salvar" onclick="valida();">
        </td>
      </tr>
    </tr>
  </table>
  <input type="hidden" id="HinputCodigoBanco" name="HinputCodigoBanco" value="">
  <input type="hidden" id="HinputDvConta" name="HinputDvConta" value="">
  <input type="hidden" id="HinputDvAgencia" name="HinputDvAgencia" value="">
  <input type="hidden" id="HinputNumeroAgencia" name="HinputNumeroAgencia" value="">
  <input type="hidden" id="HinputOperacao" name="HinputOperacao" value="">
  <input type="hidden" id="HinputNumeroConta" name="HinputNumeroConta" value="">
  <input type="hidden" id="HcboTipoConta" name="HcboTipoConta" value="">

</form>


<script>

  var sMensagem = 'recursoshumanos.pessoal.db_frmrhpessoalmov.';

/**
 * Instancia componente de dados da conta bancária
 */
 var oContaBancariaServidor = new DBViewContaBancariaServidor(<?php if(isset($rsConta->rh138_contabancaria)&&$rsConta->rh138_contabancaria!="") echo $rsConta->rh138_contabancaria; else echo '0'; ?>, 'oContaBancariaServidor', false);

 oContaBancariaServidor.show('ctnContaBancariaServidor');

 oContaBancariaServidor.getDados(<?php if(isset($rsConta->rh138_contabancaria)) echo $rsConta->rh138_contabancaria; else echo '0'; ?>);

/**
 * valida antes de colar no campo valor
 */

 $('inputCodigoBanco').onpaste = function(event) {
  return /^[0-9|.]+$/.test(event.clipboardData.getData('text/plain'));
}

$('inputDvConta').onpaste = function(event) {
  return /^[0-9|.xX]+$/.test(event.clipboardData.getData('text/plain'));
}

$('inputDvAgencia').onpaste = function(event) {
  return /^[0-9|.xX]+$/.test(event.clipboardData.getData('text/plain'));
}
$('inputNumeroAgencia').onpaste = function(event) {
  return /^[0-9|.]+$/.test(event.clipboardData.getData('text/plain'));
}

$('inputOperacao').onpaste = function(event) {
  return /^[0-9|.]+$/.test(event.clipboardData.getData('text/plain'));
}

$('inputNumeroConta').onpaste = function(event) {
  return /^[0-9|.]+$/.test(event.clipboardData.getData('text/plain'));
}
/*
$('inputOperacao').onkeyup = function(event) {
  return js_ValidaCampos(this, 1, 'Código da Operação', false, false, event);
}
*/
function js_pesquisarh02_regist(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhpessoal','func_rhpessoal.php?funcao_js=parent.js_mostrarhpessoal1|rh01_regist|rh01_numcgm','Pesquisa',true,'20',0);
  }else{
    if(document.form1.rh02_regist.value != ''){
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhpessoal','func_rhpessoal.php?pesquisa_chave='+document.form1.rh02_regist.value+'&funcao_js=parent.js_mostrarhpessoal','Pesquisa',false,20,0);
    }else{
          //document.form1.rh01_numcgm.value = '';
        }
      }
    }

    function js_mostrarhpessoal(chave,erro){
      if(document.form1.rh02_anousu.value == "" || document.form1.rh02_mesusu.value == ""){
        alert("Preencha os campos Ano / Mês");
      }else{

        location.href="pes4_contabancaria001.php?rh02_regist="+document.form1.rh02_regist.value+"&rh02_anousu="+document.form1.rh02_anousu.value+"&rh02_mesusu="+document.form1.rh02_mesusu.value;
      }
    }

    function js_mostrarhpessoal1(chave1,chave2){
      if(document.form1.rh02_anousu.value == "" || document.form1.rh02_mesusu.value == ""){
        alert("Preencha os campos Ano / Mês");
      }else{
        location.href="pes4_contabancaria001.php?rh02_regist="+chave1+"&rh02_anousu="+document.form1.rh02_anousu.value+"&rh02_mesusu="+document.form1.rh02_mesusu.value;
      }
    }
    function mudadata(){
      if(document.form1.rh02_regist.value != ""){
        location.href="pes4_contabancaria001.php?rh02_regist="+document.form1.rh02_regist.value+"&rh02_anousu="+document.form1.rh02_anousu.value+"&rh02_mesusu="+document.form1.rh02_mesusu.value;
      }
    }
    function valida(){
      document.form1.HinputCodigoBanco.value = $F('inputCodigoBanco');
      document.form1.HinputDvConta.value = $F('inputDvConta');
      document.form1.HinputDvAgencia.value = $F('inputDvAgencia');
      document.form1.HinputNumeroAgencia.value = $F('inputNumeroAgencia');
      document.form1.HinputOperacao.value = $F('inputOperacao');
      document.form1.HinputNumeroConta.value = $F('inputNumeroConta');
      document.form1.HcboTipoConta.value = $F('cboTipoConta');



        if (document.form1.HinputCodigoBanco.value == "") {

          alert('Insira um Banco');
          document.form1.HinputCodigoBanco.focus();
          location.reload();
          return false;

        }
        if (document.form1.HinputDvConta.value == "") {

          alert('Insira o DV da Conta');
          document.form1.HinputDvConta.focus();
          location.reload();
          return false;

        }
        if (document.form1.HinputDvAgencia.value == "") {

          alert('Insira o DV da Agencia');
          document.form1.HinputDvAgencia.focus();
          location.reload();
          return false;

        }
        if (document.form1.HinputNumeroAgencia.value == "") {

          alert('Insira o Número da Agencia');
          document.form1.HinputNumeroAgencia.focus();
          location.reload();
          return false;

        }
        if (document.form1.HinputNumeroConta.value == "") {

          alert('Insira o Número da Conta');
          document.form1.HinputNumeroConta.focus();
          location.reload();
          return false;

        }
        if (document.form1.HcboTipoConta.value == "") {

          alert('Insira o Tipo da Conta');
          document.form1.HcboTipoConta.focus();
          location.reload();
          return false;

        }

      document.form1.submit();

    }
  </script>
</body>
</html>

