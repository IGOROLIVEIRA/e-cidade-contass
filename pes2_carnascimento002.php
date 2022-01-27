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

include("fpdf151/pdf.php");
include("libs/db_sql.php");
require_once("libs/JSON.php");
$clrotulo = new rotulocampo;
$clrotulo->label('rh61_regist');
$clrotulo->label('z01_nome');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$oJson        = new services_json();
$oParametros  = $oJson->decode(str_replace("\\","",$json));

/**
 * constantes para o Relatorio
 */
define( "TIPO_RELATORIO_GERAL"              , "0" );
define( "TIPO_RELATORIO_ORGAO"              , "1" );
define( "TIPO_RELATORIO_LOTACAO"            , "2" );
define( "TIPO_RELATORIO_MATRICULA"          , "3" );
define( "TIPO_RELATORIO_LOCAIS_TRABALHO"    , "4" );
define( "TIPO_RELATORIO_CARGO"              , "5" );
define( "TIPO_RELATORIO_RECURSO"            , "6" );

define( "TIPO_FILTRO_GERAL"                 , 0 );
define( "TIPO_FILTRO_INTERVALO"             , 1 );
define( "TIPO_FILTRO_SELECIONADOS"          , 2 );
$orderby = " z01_nome ";
$ordenacao = "Alfabética";
if($ordem == "n"){
  $ordenacao = "Numérico";
  $orderby = " rh01_regist ";
}else if($ordem == "d"){ 
  $ordenacao = "Por Data";
  $orderby = " rh01_nasc ";
}

switch ( $oParametros->iTipoRelatorio ) {

  default:

    $sCampoCondicaoTipoRelatorio   = 1;
    $sCampoDescricaoTipoRelatorio  = "";

  break;

  case TIPO_RELATORIO_CARGO:

    $sCampoCondicaoTipoRelatorio   = "rh37_funcao";
    $sCampoDescricaoTipoRelatorio  = "rh37_descr";
    $sNomeAgrupa = "CARGO";

  break;

  case TIPO_RELATORIO_LOTACAO:

    $sCampoCondicaoTipoRelatorio     = "r70_codigo";
    $sCampoDescricaoTipoRelatorio    = "r70_descr";
    $sNomeAgrupa = "LOTAÇÃO";

  break;

  case TIPO_RELATORIO_ORGAO:

    $sCampoCondicaoTipoRelatorio  = "rh26_orgao";
    $sCampoDescricaoTipoRelatorio = "o40_descr";
    $sNomeAgrupa = "ORGÃO";

  break;

  case TIPO_RELATORIO_LOCAIS_TRABALHO:

    $sCampoCondicaoTipoRelatorio  = "rh55_codigo";
    $sCampoDescricaoTipoRelatorio = "rh55_descr";
    $sNomeAgrupa = "LOCAL DE TRABALHO";

  break;

  case TIPO_RELATORIO_MATRICULA:

    $sCampoCondicaoTipoRelatorio  = "rh02_regist";
    $sCampoDescricaoTipoRelatorio = "z01_nome";

  break;

  case TIPO_RELATORIO_RECURSO:

    $sCampoCondicaoTipoRelatorio  = "o15_codigo";
    $sCampoDescricaoTipoRelatorio = "o15_descr";

  break;
}

if ( $oParametros->iTipoRelatorio <> TIPO_RELATORIO_GERAL ) {

  switch ( $oParametros->iTipoFiltro ) {

    case TIPO_FILTRO_GERAL:
      //Sem Filtros
    break;
    case TIPO_FILTRO_INTERVALO:
      $sWhere = " and {$sCampoCondicaoTipoRelatorio} between $oParametros->iIntervaloInicial and $oParametros->iIntervaloFinal";
    break;
    case TIPO_FILTRO_SELECIONADOS:
      $sWhere = " and {$sCampoCondicaoTipoRelatorio} in (" . implode(", ", $oParametros->iRegistros) . ")";
    break;
  }
}

$where = "";

if (($data != "--") && ($data1 != "--")) {
	$where = $where." and rh01_nasc  between '$data' and '$data1'  ";
	$data = db_formatar($data, "d");
	$data1 = db_formatar($data1, "d");
	$info = "De $data até $data1.";
} else if ($data != "--") {
	$where = $where." and rh01_nasc >= '$data'  ";
	$data = db_formatar($data, "d");
	$info = "Apartir de $data.";
} else if ($data1 != "--") {
	$where = $where."and rh01_nasc <= '$data1'   ";
	$data1 = db_formatar($data1, "d");
	$info = "Até $data1.";
}
$where .= $sWhere;

//// Variáveis do cabeçalho
//// $head1 = linha 1
//// $head2 = linha 2
///  ...
//// $head9 = linha 9

$head3 = "DATA DE NASCIMENTO DOS FUNCIONÁRIOS";
$head4 = "ORDEM: ".$ordenacao;
$head5 = @$info;
////////////////////////////////////////////////

//// Cria a variável $sql com o sql criado
$sql = "select rh01_regist,
               z01_nome,
               rh01_nasc
               ".(empty($sCampoDescricaoTipoRelatorio) ? '' : ",{$sCampoDescricaoTipoRelatorio} as agrupa_descricao" )."
        from rhpessoal
             inner join cgm          on z01_numcgm  = rh01_numcgm
             inner join rhpessoalmov on rh01_regist = rh02_regist
                                    and rh02_anousu = $ano
             										 	  and rh02_mesusu = $mes
                                    and rh02_instit = ".db_getsession("DB_instit")."
             left join rhpesrescisao on rh02_seqpes = rh05_seqpes
             left  join rhfuncao on rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao 
             and rhfuncao.rh37_instit          = rhpessoalmov.rh02_instit
             left  join rhlota on rhlota.r70_codigo = rhpessoalmov.rh02_lota
             and rhlota.r70_instit = rhpessoalmov.rh02_instit
             left  join rhlotaexe on rh26_codigo = r70_codigo
             and rh26_anousu = rh02_anousu
             left  join orcorgao on o40_orgao = rh26_orgao 
             and o40_anousu = rhpessoalmov.rh02_anousu
             and o40_instit = rhpessoalmov.rh02_instit
             left  join rhlotavinc           on rh25_codigo                   = r70_codigo
             and rh25_anousu                   = rhpessoalmov.rh02_anousu
             left  join orctiporec on o15_codigo = rh25_recurso
             left  join rhpeslocaltrab on rhpeslocaltrab.rh56_seqpes = rhpessoalmov.rh02_seqpes
             and rhpeslocaltrab.rh56_princ = 't'
             left  join rhlocaltrab on rhpeslocaltrab.rh56_localtrab = rhlocaltrab.rh55_codigo
        where rh05_recis is  null $where
				order by ".(empty($sCampoDescricaoTipoRelatorio) ? '' : "{$sCampoDescricaoTipoRelatorio},")."{$orderby}";
//// pg_exec - executa $sql no banco e gera um RECORDSET criado na variável $resultado_sql com os dados da execução
//// da variável $sql no banco
$resultado_sql = pg_exec($sql);
//// pg_numrows - verifica quantas linhas vieram no RECORDSET e coloca o resultado na variávei $qtd_linhas_sql
$qtd_linhas_sql = pg_numrows($resultado_sql);
if($qtd_linhas_sql == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem funcionários cadastrados no período.');
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$imprime_cabecalho = true;
$alt = 4;
$agrupa = 'NULL';
for($x=0; $x<$qtd_linhas_sql; $x++){

  db_fieldsmemory($resultado_sql, $x);

  if ($pdf->gety() > $pdf->h - 30 || $imprime_cabecalho == true || (!empty($sCampoDescricaoTipoRelatorio) && $agrupa != $agrupa_descricao)){
     $pdf->addpage();
     $pdf->setfont('arial','b',8);

     $pdf->cell(170,$alt,"{$sNomeAgrupa}: $agrupa_descricao",1,1,"L",1);
     $pdf->cell(20,$alt,'MATRICULA',1,0,"C",1);
     $pdf->cell(90,$alt,'NOME DO FUNCIONÁRIO',1,0,"C",1);
     $pdf->cell(40,$alt,'DATA DE NASCIMENTO',1,0,"C",1);
     $pdf->cell(20,$alt,'IDADE',1,1,"C",1);
     $pre = 1;

     $imprime_cabecalho = false;
     $agrupa = $agrupa_descricao;
  }
  if ($pre == 1)
    $pre = 0;
  else
    $pre = 1;
  $pdf->setfont('arial','',7);
  $pdf->cell(20,$alt,$rh01_regist,1,0,"C",$pre);
  $pdf->cell(90,$alt,$z01_nome,1,0,"L",$pre);
  if($rh01_nasc != ""){
     $pdf->cell(40,$alt,db_formatar($rh01_nasc,'d'),1,0,"L",$pre);
     $result_idade = pg_exec("select fc_idade('$rh01_nasc','".date("Y-m-d",db_getsession("DB_datausu"))."')as idade");
     db_fieldsmemory($result_idade,0);
     $pdf->cell(20,$alt,$idade,1,1,"C",$pre);
  }
}

$pdf->setfont('arial','b',8);
$pdf->cell(170,$alt,'TOTAL DE REGISTROS  : '.$qtd_linhas_sql,"T",1,"R",0);
$pdf->Output();
?>