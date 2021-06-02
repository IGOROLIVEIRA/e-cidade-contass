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

set_time_limit(0);

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_sql.php");
require_once 'libs/db_libpessoal.php';
require_once("classes/db_iptubase_classe.php");
require_once("classes/db_issbase_classe.php");
require_once("classes/db_propri_classe.php");
require_once("classes/db_promitente_classe.php");
require_once("classes/db_rubricasesocial_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$xtipo = "'x'";
$clrubricasesocial = new cl_rubricasesocial;

switch ($opcao) {
  case 'salario':

    if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
      require_once 'pes3_gerfinanc018_salario.php';
      exit;
    }
    $sigla          = 'r14_';
    $arquivo        = 'gerfsal';
    $sTituloCalculo = 'Salário';
    break;

  case 'complementar':
    if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
      require_once("pes3_gerfinanc018_auxiliar.php");
      exit;
    }

    $sigla          = 'r48_';
    $arquivo        = 'gerfcom';
    $sTituloCalculo = 'Complementar';
    break;

  case 'ferias':
    $sigla          = 'r31_';
    $arquivo        = 'gerffer';
    $xtipo          = ' r31_tpp ';
    $sTituloCalculo = 'Férias';
    break;

  case 'rescisao':
    $sigla          = 'r20_';
    $arquivo        = 'gerfres';
    $xtipo          = ' r20_tpp ';
    $sTituloCalculo = 'Rescisão';
    break;

  case 'adiantamento':
    $sigla          = 'r22_';
    $arquivo        = 'gerfadi';
    $sTituloCalculo = 'Adiantamento';
    break;

  case '13salario':
    $sigla          = 'r35_';
    $arquivo        = 'gerfs13';
    $sTituloCalculo = '13º Salário';
    break;

  case 'fixo':
    $sigla          = 'r53_';
    $arquivo        = 'gerffx';
    $sTituloCalculo = 'Calculo Fixo';
    break;

  case 'previden':
    $sigla          = 'r60_';
    $arquivo        = 'previden';
    $sTituloCalculo = 'Previdência';
    break;

  case 'irf':
    $sigla          = 'r61_';
    $arquivo        = 'ajusteir';
    $sTituloCalculo = 'IRF';
    break;

  case 'gerfprovfer':
    $sigla          = 'r93_';
    $arquivo        = 'gerfprovfer';
    $sTituloCalculo = 'Proventos de Férias';
    break;

  case 'gerfprovs13':
    $sigla          = 'r94_';
    $arquivo        = 'gerfprovs13';
    $sTituloCalculo = 'Proventos de 13º salário';
    break;

  default:
    echo "SEM CALCULO NO MÊS";
    $sTituloCalculo = 'Sem Calculo';
    $opcao = "";
    break;
}

if ($opcao) {
  
    $sql = "  select '1' as ordem ,
                   {$sigla}rubric as rubrica,
                   case 
                     when rh27_pd = 3 then 0 
                     else case 
                            when {$sigla}pd = 1 then {$sigla}valor 
                            else 0 
                          end 
                   end as Provento,
                   case 
                     when rh27_pd = 3 then 0 
                     else case 
                            when {$sigla}pd = 2 then {$sigla}valor 
                            else 0 
                          end 
                   end as Desconto,
                   {$sigla}quant as quant, 
                   rh27_descr, 
                   {$xtipo} as tipo , 
                   case 
                     when rh27_pd = 3 then 'Base' 
                     else case 
                            when {$sigla}pd = 1 then 'Provento' 
                            else 'Desconto' 
                          end 
                   end as provdesc
              from {$arquivo} 
                   inner join rhrubricas on rh27_rubric = {$sigla}rubric 
                                        and rh27_instit = ".db_getsession("DB_instit")."
              ".bb_condicaosubpesproc($sigla,$ano."/".$mes)." 
               and {$sigla}regist = $matricula 
               and {$sigla}pd != 3 
               order by {$sigla}pd,{$sigla}rubric";
}
$result = db_query($sql);

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<link rel="stylesheet" type="text/css" href="estilos.css">
<style type="text/css">
  html, body, table {
    overflow: hidden;
  }

  #tabela-esocialsicom, #tabela-esocialsicom tr, #tabela-esocialsicom td, #tabela-esocialsicom th {
    border: 1px solid #bbb;
  }


  #tabela-esocialsicom tr:nth-child(odd) {
    background-color: #EEEEEE !important;
  }

  #tabela-esocialsicom tr:nth-child(even) {
    background-color: #FFFFFF !important;
  }

  #tabela-esocialsicom tr:first-child {
    border-right:1px outset #D3D3D3;
    padding:0;
    margin:0;
    white-space:nowrap;
    overflow: hidden;
  }

  #tabela-esocialsicom tr:nth-child(even) {
    background: #F0F0F0;
  }

  #tabela-esocialsicom tr:nth-child(odd) {
    background: #FFF;
  }
</style>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script>
function js_mostracgm(cgm){
  parent.func_nome.jan.location.href = 'prot3_conscgm002.php?fechar=func_nome&numcgm='+cgm;
  parent.func_nome.mostraMsg();
  parent.func_nome.show();
  parent.func_nome.focus();
}
function js_mostrabic_matricula(matricula){
  parent.func_nome.jan.location.href = 'cad3_conscadastro_002.php?cod_matricula='+matricula;
  parent.func_nome.mostraMsg();
  parent.func_nome.show();
  parent.func_nome.focus();
}
// esta funcao é utilizada quando clicar na inscricao após pesquisar
// a mesma
function js_mostrabic_inscricao(inscricao){
  parent.func_nome.jan.location.href = 'iss3_consinscr003.php?numeroDaInscricao='+inscricao;
  parent.func_nome.mostraMsg();
  parent.func_nome.show();
  parent.func_nome.focus();
}


function js_relatorio(){
  jan = window.open('pes3_gerfinanc017.php?opcao=<?=$opcao?>&numcgm='+document.form1.numcgm.value+'&matricula='+document.form1.matricula.value+'&ano=<?=$ano?>&mes=<?=$mes?>&tbprev=<?=$tbprev?>','sdjklsdklsdf','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
	  
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);


</script>
</head>
<body onload="js_alteraTamanho();">
<center>

<form name="form1" method="post">

<table width="100%" id="tabela-esocialsicom" cellspacing="0">

<tr>
  <th class="borda" width="80" nowrap>Código</th>
  <th class="borda" nowrap>Descrição</th>
  <th class="borda" width="80" nowrap>Proventos</th>
  <th class="borda" width="80" nowrap>Descontos</th>
</tr>
<?

$aDados = array();
for ($x=0;$x<pg_numrows($result);$x++) {

  db_fieldsmemory($result,$x,true);

  /**
   * Rúricas especiais do eSocial na rescisão
   */
  if ($opcao == 'rescisao') {

    $rsRubEspeciais = db_query($clrubricasesocial->sql_query(null, "e990_sequencial,e990_descricao", null, "baserubricasesocial.e991_rubricas = '{$rubrica}' AND e990_sequencial IN ('1000','5001','1020')"));
    if (pg_num_rows($rsRubEspeciais) > 0) {
      $oRubEspeciais = db_utils::fieldsMemory($rsRubEspeciais);
      switch ($oRubEspeciais->e990_sequencial) {
        case '1000':
          $rubrica = '9000';
          $rh27_descr = 'Saldo de Salário na Rescisão';
          break;
        case '5001':
          $rubrica = '9001';
          $rh27_descr = '13º Salário na Rescisão';
          break;
        case '1020' && $tipo == 'P':
          $rubrica = '9002';
          $rh27_descr = 'Férias Proporcional na Rescisão';
          break;
        case '1020' && $tipo == 'V':
          $rubrica = '9003';
          $rh27_descr = 'Férias Vencidas na Rescisão';
          break;
        
        default:
          break;
      }
    }
  }
  
  if (!isset($aDados[$rubrica])) {
    $oDados = new stdClass();
    $oDados->rubrica = $rubrica;
    $oDados->rh27_descr = $rh27_descr;
    $oDados->provento = $provento;
    $oDados->desconto = $desconto;
    $aDados[$rubrica] = $oDados;
  } else {
    $aDados[$rubrica]->provento += $provento;
    $aDados[$rubrica]->desconto += $desconto;
  }
}    
$nTotalProventos = 0;
$nTotalDescontos = 0;

foreach ($aDados as $oDados) {
  $nTotalProventos += $oDados->provento;
  $nTotalDescontos += $oDados->desconto;
?>
  <tr>
    <td align="center" style="font-size:12px" nowrap >&nbsp;<?=$oDados->rubrica?>&nbsp;</td>
    <td align="left" style="font-size:12px" nowrap >&nbsp;<?=strtoupper(db_translate($oDados->rh27_descr))?>&nbsp;</td>
    <td align="right" style="font-size:12px" nowrap >&nbsp;<?=db_formatar($oDados->provento,'f')?>&nbsp;</td>
    <td align="right" style="font-size:12px" nowrap >&nbsp;<?=db_formatar($oDados->desconto,'f')?>&nbsp;</td>
  </tr>
<?
}
?>
 <tr>
   <td align="center" colspan="2" style="font-size:12px" nowrap  bgcolor="#ddd">&nbsp;<strong>TOTAL<strong></td>
   <td align="right" style="font-size:12px" nowrap  bgcolor="#ddd">&nbsp;<strong><?=db_formatar($nTotalProventos,'f')?></strong></td>
   <td align="right" style="font-size:12px" nowrap  bgcolor="#ddd">&nbsp;<strong><?=db_formatar($nTotalDescontos,'f')?></strong></td>
 </tr>
 <tr>
   <td align="center" colspan="2" style="font-size:12px" nowrap  bgcolor="#ddd">&nbsp;<strong>LÍQUIDO<strong></td>
   <td colspan="2" align="right" style="font-size:12px" nowrap  bgcolor="#ddd">&nbsp;<strong><?=db_formatar($nTotalProventos-$nTotalDescontos,'f')?></strong></td>
 </tr>
<?php 
if (count($aRubricasSemBase) > 0) {
?>
 <tr>
  <td align="center" colspan="4" style="font-size:12px;color: #df1616" nowrap  bgcolor="#F0F0F0" >&nbsp;<strong><?=$aviso ?><strong></td>
 </tr>
<?php 
}
?>
</table>

<input type="hidden" name="matricula" value="<?=@$matricula?>">
<input type="hidden" name="numcgm" value="<?=@$numcgm?>">

</form>
</center>
</body>
</html>
<script>
  /**
   * Altera o Titulo da Folha.
   */
   parent.document.getElementById('tituloFolha').innerHTML = "<?=$sTituloCalculo?>";

   function js_alteraTamanho() {      
      
      var body = document.body,
          html = document.documentElement;
      parent.document.getElementById('calculoFolha').style.height = html.scrollHeight + 'px';
      parent.iframeLoaded();
   }

</script>