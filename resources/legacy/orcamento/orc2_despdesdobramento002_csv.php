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
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");

include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");

$cldesdobramento = new cl_desdobramento();

//db_postmemory($HTTP_POST_VARS,2);exit;
//db_postmemory($HTTP_POST_VARS);
//echo "<pre>";print_r($_POST);exit;
$dtini = implode("-",array_reverse(explode("/",$DBtxt21)));
$dtfim = implode("-",array_reverse(explode("/",$DBtxt22)));

//---------------------------------------------------------------  
$clselorcdotacao = new cl_selorcdotacao();

$clselorcdotacao->setDados($filtra_despesa); // passa os parametros vindos da func_selorcdotacao_abas.php
// $instits = $clselorcdotacao->getInstit();

$instits = ' ('.str_replace('-',', ',$db_selinstit).') ';

$w_elemento = $clselorcdotacao->getElemento();
//@ recupera as informações fornecidas para gerar os dados
//---------------------------------------------------------------  

$resultinst = db_query("select codigo,nomeinstabrev from db_config where codigo in $instits");
$descr_inst = '';
$xvirg = '';
for($xins = 0; $xins < pg_numrows($resultinst); $xins++){
  db_fieldsmemory($resultinst,$xins);
  $descr_inst .= $xvirg.$nomeinstabrev ; 
  $xvirg = ', ';
}

/////////////////////////////////////////////////////////

$anousu = db_getsession("DB_anousu");
$sele_work = $clselorcdotacao->getDados(false,true)." and o58_instit in $instits and  o58_anousu=$anousu  ";
if ($w_elemento !=""){
    $w_elemento = " and o58_codele in  ({$w_elemento}) ";
}
//echo $cldesdobramento->sql($sele_work,$dtini,$dtfim,$instits);    
    
$result = db_query($cldesdobramento->sql($sele_work,$dtini,$dtfim,$instits));
$rows = pg_numrows($result);
  //db_criatabela($result);exit;
 /*
 if (pg_numrows($result)>0){
   // monta relatorio
 } else {
   // db_redireciona("con2_estruturarel.php?relatorio=4");
   echo "erro";
 }    
 */

$tg_empenhado = 0;
$tg_liquidado = 0;
$tg_pago=0;

$estrut_elemento ="";

$fp = fopen("tmp/despdesdobramento.csv","w");
fputs($fp,"Elemento;Descrição;Empenhado;Liquidado;Pago\n");
for ($x = 0; $x < pg_num_rows($result); $x++){
   db_fieldsmemory($result,$x);

   fputs($fp,$o56_elemento.";".$o56_descr.";".
             db_formatar($empenhado - $empenhado_estornado,'f').";".db_formatar($liquidado - $liquidado_estornado,'f').";".
	     db_formatar($pagamento - $pagamento_estornado,'f')."\n"
	     );
   
   $tg_empenhado += ($empenhado - $empenhado_estornado); 
   $tg_liquidado += ($liquidado - $liquidado_estornado); 
   $tg_pago      += ($pagamento - $pagamento_estornado);
   
}

// imprime total geral   

fputs($fp,"".";"."Total Geral".";".
             db_formatar($tg_empenhado,'f').";".db_formatar($tg_liquidado,'f').";".
	     db_formatar($tg_pago,'f')."\n"
	     );

echo "<html><body bgcolor='#cccccc'><center><a href='tmp/despdesdobramento.csv'>Baixar o arquivo <b>despdesdobramento.csv</b></a></body></html>";
fclose($fp);