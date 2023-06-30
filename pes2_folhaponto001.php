<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_gerfcom_classe.php");
$clgerfcom = new cl_gerfcom;
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<form name="form1">
<center>
<fieldset style="margin-top: 15px; width: 600px;">
    <legend>Folha de Ponto</legend>
<table>
  <?
  if(!isset($tipo)){
    $tipo = "l";
  }
  if(!isset($filtro)){
    $filtro = "i";
  }
  if(!isset($anofolha) || (isset($anofolha) && trim($anofolha) == "")){
    $anofolha = db_anofolha();
  }
  if(!isset($mesfolha) || (isset($mesfolha) && trim($mesfolha) == "")){
    $mesfolha = db_mesfolha();
  }
  include("dbforms/db_classesgenericas.php");
  $geraform = new cl_formulario_rel_pes;

  echo '
    <input type="hidden" id="anof" value="'.$anofolha.'">
    <input type="hidden" id="mesf" value="'.$mesfolha.'">
  ';



  $geraform->usaregi = true;                      // PERMITIR SELEÇÃO DE MATRÍCULAS
  $geraform->usalota = true;                      // PERMITIR SELEÇÃO DE LOTAÇÕES
  $geraform->usaorga = true;                      // PERMITIR SELEÇÃO DE ÓRGÃO
  $geraform->usaloca = true;                      // PERMITIR SELEÇÃO DE LOCAL DE TRABALHO
  $geraform->usarecu = true;                      // PERMITIR SELEÇÃO DE RECURSO

  $geraform->re1nome = "regisi";                  // NOME DO CAMPO DA MATRÍCULA INICIAL
  $geraform->re2nome = "regisf";                  // NOME DO CAMPO DA MATRÍCULA FINAL
  $geraform->re3nome = "selreg";                  // NOME DO CAMPO DE SELEÇÃO DE MATRÍCULAS

  $geraform->lo1nome = "lotai";                  // NOME DO CAMPO DA LOTAÇÃO INICIAL
  $geraform->lo2nome = "lotaf";                  // NOME DO CAMPO DA LOTAÇÃO FINAL
  $geraform->lo3nome = "sellot";                  // NOME DO CAMPO DE SELEÇÃO DE LOTAÇÕES

  $geraform->or1nome = "orgaoi";                  // NOME DO CAMPO DO ÓRGÃO INICIAL
  $geraform->or2nome = "orgaof";                  // NOME DO CAMPO DO ÓRGÃO FINAL
  $geraform->or3nome = "selorg";                  // NOME DO CAMPO DE SELEÇÃO DE ÓRGÃOS

  $geraform->rc1nome = "recuri";                  // NOME DO CAMPO DO RECURSO INICIAL
  $geraform->rc2nome = "recurf";                  // NOME DO CAMPO DO RECURSO FINAL
  $geraform->rc3nome = "selrec";                  // NOME DO CAMPO DE SELEÇÃO DE RECURSOS

  $geraform->tr1nome = "locali";                  // NOME DO CAMPO DO LOCAL INICIAL
  $geraform->tr2nome = "localf";                  // NOME DO CAMPO DO LOCAL FINAL
  $geraform->tr3nome = "selloc";                  // NOME DO CAMPO DE SELEÇÃO DE LOCAIS

  $geraform->trenome = "tipo";                    // NOME DO CAMPO TIPO DE RESUMO
  $geraform->tfinome = "filtro";                  // NOME DO CAMPO TIPO DE FILTRO

  $geraform->resumopadrao = "g";                  // TIPO DE RESUMO PADRAO

  $geraform->strngtipores = "glomts";              // OPÇÕES PARA MOSTRAR NO TIPO DE RESUMO g - geral,
                                                  //                                       l - lotação,
                                                  //                                       o - órgão,
                                                  //                                       t - local de trabalho
                                                  //                                       s - recurso


  $geraform->complementar = "r48";                // VALUE DA COMPLEMENTAR PARA BUSCAR SEMEST

  $geraform->campo_auxilio_regi = "faixa_regis";  // NOME DO DAS MATRÍCULAS SELECIONADAS
  $geraform->campo_auxilio_lota = "faixa_lotac";  // NOME DO DAS LOTAÇÕES SELECIONADAS
  $geraform->campo_auxilio_orga = "faixa_orgao";  // NOME DO DOS ÓRGÃOS SELECIONADOS
  $geraform->campo_auxilio_recu = "faixa_recu";  // NOME DO DOS RECURSOS SELECIONADOS
  $geraform->campo_auxilio_loca = "faixa_local";  // NOME DO DOS LOCAIS SELECIONADOS


  $geraform->mostord = true;                    // CAMPO PARA ESCOLHA DE ORDEM
  $geraform->selecao = true;                    // CAMPO PARA ESCOLHA DA SELEÇÃO

  $geraform->onchpad = true;                    // MUDAR AS OPÇÕES AO SELECIONAR OS TIPOS DE FILTRO OU RESUMO
  $geraform->gera_form();
  echo '<tr>';
    echo '<td>';
      echo '<strong>Horários:&nbsp;</strong>';
    echo '</td>';
    echo '<td>';
      echo '
        <input class="quantidadeHoras" id="qh1" size="5" maxlength="5" onkeypress="mascaraData( this, event )">
        &nbsp;à&nbsp;
        <input class="quantidadeHoras" id="qh2" size="5" maxlength="5" onkeypress="mascaraData( this, event )">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      ';
      echo '
        <input class="quantidadeHoras" id="qh3" size="5" maxlength="5" onkeypress="mascaraData( this, event )">
        &nbsp;à&nbsp;
        <input class="quantidadeHoras" id="qh4" size="5" maxlength="5" onkeypress="mascaraData( this, event )">
      ';
    echo '</td>';
  echo '</tr>';

  ?>
  <tr>
    <td><b>Período:</b></td>
    <td>
      <?
        $datagera_dia = date('d',strtotime($anofolha."-".$mesfolha."-01"));
        db_inputdata('periodo1',$datagera_dia,$mesfolha,$anofolha,true,'text',1,"");
        db_inputdata('periodo2',$datagera_dia,$mesfolha,$anofolha,true,'text',1,"");
      ?>
    </td>
    <td>
      <?

      ?>
    </td>
  </tr>
  <tr>
    <td>
      <strong>Mostrar Jornada:</strong>
    </td>
    <td>
      <input type="checkbox" name="mostrarJornada" />
    </td>
  </tr>
  <tr>
    <td>
      <strong>Mostrar Lotação:</strong>
    </td>
    <td>
      <input type="checkbox" name="mostrarLotacao" />
    </td>
  </tr>
  <tr>
    <td colspan="2" align = "center">
      <input style="margin-top: 15px;"  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
    </td>
  </tr>
</table>
</fieldset>
</center>
</form>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

function mascaraData( campo, e ) {
  var kC = (document.all) ? event.keyCode : e.keyCode;
  var hora = campo.value;

  if( kC!=8 && kC!=46 )
  {
    if( hora.length==2 )
    {
      campo.value = hora += ':';
    }
    else
      campo.value = hora;
  }
}


document.getElementById('anomes').style.display = "none";
$('previdencia').value  = 0;
$('previdencia').change = js_ProcCod_previdencia('previdencia','previdenciadescr');

function js_emite(){

  var hora1 = validaHora(document.form1.qh1.value);
  var hora2 = validaHora(document.form1.qh2.value);
  var hora3 = validaHora(document.form1.qh3.value);
  var hora4 = validaHora(document.form1.qh4.value);

  var periodo1 = document.form1.periodo1.value.split("/");
  var periodo2 = document.form1.periodo2.value.split("/");

  var dia1 = periodo1[0];
  var mes1 = periodo1[1];
  var ano1 = periodo1[2];

  var dia2 = periodo2[0];
  var mes2 = periodo2[1];
  var ano2 = periodo2[2];

  if (document.form1.qh1.value != '' || document.form1.qh2.value != '' || document.form1.qh3.value != '' || document.form1.qh4.value != '') {
    if (hora1 == false) {
      alert("Hora 1 inválida!");
      return;
    }

    if (hora2 == false) {
      alert("Hora 2 inválida!");
      return;
    }

    if (hora3 == false) {
      alert("Hora 3 inválida!");
      return;
    }

    if (hora4 == false) {
      alert("Hora 4 inválida!");
      return;
    }
  }


  if (mes1 > mes2 && ano2 == ano1) {
    alert("Mês inicial não pode ser menor que o final!");
    return;
  }


  qry   = "?tipo="+document.form1.tipo.value;
  qry+= "&periodo1="+dia1+"/"+mes1+"/"+ano1;
  qry+= "&periodo2="+dia2+"/"+mes2+"/"+ano2;
  qry+= "&sel="+document.form1.selecao.value;
  qry+= "&hora1="+document.form1.qh1.value;
  qry+= "&hora2="+document.form1.qh2.value;
  qry+= "&hora3="+document.form1.qh3.value;
  qry+= "&hora4="+document.form1.qh4.value;
  qry+= "&anof="+document.form1.anof.value;
  qry+= "&mesf="+document.form1.mesf.value;
  qry+= "&mostrarJornada="+document.form1.mostrarJornada.checked;
  qry+= "&mostrarLotacao="+document.form1.mostrarLotacao.checked;

  if(document.form1.complementar){
    qry+= "&semest="+document.form1.complementar.value;
  }

  if (document.form1.selreg) {
    if (document.form1.selreg.length > 0) {
      faixareg = js_campo_recebe_valores();
      qry+= "&fre="+faixareg;
    }
  }
  else if (document.form1.regisi) {
    regini = document.form1.regisi.value;
    regfim = document.form1.regisf.value;
    qry+= "&rei="+regini;
    qry+= "&ref="+regfim;
  }

  if (document.form1.sellot) {
    if (document.form1.sellot.length > 0) {
      faixalot = js_campo_recebe_valores();
      qry+= "&flt="+faixalot;
    }
  } else if (document.form1.lotai) {
    lotini = document.form1.lotai.value;
    lotfim = document.form1.lotaf.value;
    qry+= "&lti="+lotini;
    qry+= "&ltf="+lotfim;
  }

  if (document.form1.selloc) {
    if (document.form1.selloc.length > 0) {
      faixaloc = js_campo_recebe_valores();
      qry+= "&flc="+faixaloc;
    }
  } else if (document.form1.locali) {
    locini = document.form1.locali.value;
    locfim = document.form1.localf.value;
    qry+= "&lci="+locini;
    qry+= "&lcf="+locfim;
  }

  if (document.form1.selorg) {
    if (document.form1.selorg.length > 0) {
      faixaorg = js_campo_recebe_valores();
      qry+= "&for="+faixaorg;
    }
  } else if (document.form1.orgaoi) {
    orgini = document.form1.orgaoi.value;
    orgfim = document.form1.orgaof.value;
    qry+= "&ori="+orgini;
    qry+= "&orf="+orgfim;
  }
  if (document.form1.selrec) {
    if (document.form1.selrec.length > 0) {
      faixarec = js_campo_recebe_valores();
      qry+= "&frc="+faixarec;
    }
  } else if (document.form1.recuri) {
    recini = document.form1.recuri.value;
    recfim = document.form1.recurf.value;
    qry+= "&rci="+recini;
    qry+= "&rcf="+recfim;
  }
  jan = window.open('pes2_folhaponto002.php'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);

}

function validaHora(hora) {

  var horaMinuto = hora.split(':');

  var hora   = horaMinuto[0];
  var minuto = horaMinuto[1];


  if ((hora < 0 || hora > 23) || (minuto < 0 || minuto > 59)) {
    return false;
  }

  if (isNaN(hora) == true) {
    return false;
  }

  if (isNaN(minuto) == true) {
    return false;
  }

  return true;
}
</script>


