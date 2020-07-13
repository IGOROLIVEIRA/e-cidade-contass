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

require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_pcorcamforne_classe.php");
require_once("classes/db_pcorcamitemlic_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("classes/db_db_config_classe.php");
require_once("libs/db_libdocumento.php");
require_once("classes/db_pcorcamitem_classe.php");
require_once("classes/db_pcorcamval_classe.php");

$clpcorcamval      = new cl_pcorcamval();
$clpcorcamitem     = new cl_pcorcamitem;
$clliclicita       = new cl_liclicita;
$clliclicitem      = new cl_liclicitem;
$clpcorcamforne    = new cl_pcorcamforne;
$clpcorcamitemlic  = new cl_pcorcamitemlic;
$clpcorcamjulg     = new cl_pcorcamjulg;
$clrotulo          = new rotulocampo;
$cldbconfig        = new cl_db_config;
$clrotulo->label('');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);

$oPDF = new PDF();
$oPDF->Open(); 
$oPDF->AliasNbPages(); 
$total = 0;
$oPDF->setfillcolor(235);
$oPDF->setfont('arial','b',8);
$oPDF->setfillcolor(235);
$troca    = 1;
$alt      = 4;
$total    = 0;
$p        = 0;
$valortot = 0;
$cor      = 0;
$dbinstit = db_getsession("DB_instit");

$oLibDocumento = new libdocumento(1703,null);
if ( $oLibDocumento->lErro ){
   die($oLibDocumento->sMsgErro);
}
$campos = "l20_codigo,l20_edital,l20_anousu,l20_numero,l20_datacria,l20_objeto,cgmrepresentante.z01_nome AS nome,cgmrepresentante.z01_cgccpf AS cpf";
$rsLicitacao   = $clliclicita->sql_record( $clliclicita->sql_query_equipepregao(null,$campos,"l20_codigo","l20_codigo=$l20_codigo and l31_tipo = '6' and l20_instit = $dbinstit"));

if ($clliclicita->numrows == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado, ou licitação não julgada, ou licitação revogada');
  exit;
}
db_fieldsmemory($rsLicitacao,0);
  $head3 = "HOMOLOGAÇÃO DO PROCESSO ";
  $head4 = "PROCESSO LICITATORIO : $l20_edital/".substr($l20_anousu,0,4);
  $head5 = "SEQUENCIAL: $l20_codigo";
  $oPDF->addpage();
  $oPDF->setfont('arial','b',12);
  $oPDF->ln();
  $oPDF->cell(0,8,"HOMOLOGAÇAO DE PROCESSO",0,1,"C",0);
  $oPDF->setfont('arial','b',10);
  $oPDF->cell(0,8,"PROCESSO LICITATORIO Nº : $l20_edital",0,1,"C",0);
  $oPDF->cell(0,8,"PREGÃO PRESENCIAL Nº : $l20_numero",0,1,"C",0);
  $oPDF->setfont('arial','',8);

$olicitacao = db_utils::fieldsMemory($rsLicitacao,0);

$result_orc=$clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo,"pc22_codorc as orcamento"));
db_fieldsmemory($result_orc,0);
$result_forne=$clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"*",null,"pc21_codorc=$orcamento"));
$numrows_forne=$clpcorcamforne->numrows;

for($x = 0; $x < $numrows_forne;$x++){
    db_fieldsmemory($result_forne,$x);
    $result_itens=$clpcorcamitem->sql_record($clpcorcamitem->sql_query_homologados(null,"distinct l21_ordem,pc22_orcamitem,pc11_resum,pc01_descrmater","l21_ordem","pc22_codorc=$orcamento"));
    $numrows_itens=$clpcorcamitem->numrows;
    for($w=0;$w<$numrows_itens;$w++){
        db_fieldsmemory($result_itens,$w);
        $result_valor=$clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null,null,"pc23_valor,pc23_quant,pc23_vlrun,pc24_pontuacao",null,"pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem and pc24_pontuacao=1"));
        if ($clpcorcamval->numrows>0){
            db_fieldsmemory($result_valor,0);
            $totallicitacao += $pc23_valor;
        }
    }
}

$oLibDocumento->l20_edital    = $olicitacao->l20_edital;
$oLibDocumento->l20_numero    = $olicitacao->l20_numero;
$oLibDocumento->l20_datacria  = substr($olicitacao->l20_anousu,0,4);
$oLibDocumento->l20_codigo    = $olicitacao->l20_codigo;
$oLibDocumento->l20_objeto    = $olicitacao->l20_objeto;
$oLibDocumento->z01_cgccpf    = $olicitacao->cpf;
$oLibDocumento->z01_nome      = $olicitacao->nome;
$oLibDocumento->totallicitacao= db_formatar($totallicitacao,"f");

$sSqlDbConfig = $cldbconfig->sql_query(null, "*", null, "codigo = {$dbinstit}");
$result_munic = $cldbconfig->sql_record($sSqlDbConfig);
db_fieldsmemory($result_munic,0);

$aParagrafos = $oLibDocumento->getDocParagrafos();

// for percorrendo os paragrafos do documento 
foreach ($aParagrafos as $oParag) {
  if ($oParag->oParag->db02_tipo == "3" ){
    eval($oParag->oParag->db02_texto);
  }else{
    $oParag->writeText( $oPDF );
  }

}
$oPDF->Output();

?>
