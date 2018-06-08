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
include("classes/db_liclicita_classe.php");
include("classes/db_liclicitem_classe.php");
include("classes/db_pcorcamforne_classe.php");
include("classes/db_pcorcamitem_classe.php");
include("classes/db_pcorcamval_classe.php");
require_once("libs/db_libdocumento.php");
require_once("libs/db_utils.php");
$clliclicita = new cl_liclicita;
$clliclicitem = new cl_liclicitem;
$clpcorcamforne = new cl_pcorcamforne;
$clpcorcamitem = new cl_pcorcamitem;
$clpcorcamval = new cl_pcorcamval;
$clrotulo = new rotulocampo;
$clrotulo->label('');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);

$dbinstit=db_getsession("DB_instit");

$rsLicitacao=$clliclicita->sql_record($clliclicita->sql_query(null,"*","l20_codigo","l20_codigo=$l20_codigo and l20_instit = $dbinstit and l20_licsituacao in (1,10)"));

if ($clliclicita->numrows == 0){
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado, ou licitação não Julgada, ou licitação revogada');
    exit;
}

$oPDF = new PDF();
$oPDF->Open();
$oPDF->AliasNbPages();
$total = 0;
$oPDF->setfillcolor(235);
$oPDF->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$total = 0;
$p=0;
$quant_forne = 0;
$val_forne = 0;
$quant_tot = 0;
$val_tot = 0;
$valortot=0;
$z01_nomeant="";

$oLibDocumento = new libdocumento(1704,null);
if ( $oLibDocumento->lErro ){
    die($oLibDocumento->sMsgErro);
}

db_fieldsmemory($rsLicitacao,0);

/*pega a equipe de pregao*/

$sSqlequipe = "SELECT l45_numatonomeacao,
                      z01_nome as pregoeiro
               FROM licpregao
               INNER JOIN licpregaocgm ON l46_licpregao = l45_sequencial
               INNER JOIN cgm ON z01_numcgm = l46_numcgm
               WHERE l45_sequencial = {$l20_equipepregao}
               AND l46_tipo = 6";
$rsDadosEquipe = db_query($sSqlequipe);

db_fieldsmemory($rsDadosEquipe,0);

$l20_datacria=substr($l20_datacria,0,4);

$head3 = "ADJUDICAÇÃO DE PROCESSO ";
$head4 = "SEQUENCIAL: $l20_codigo";
$head5 = "PROCESSO LICITATORIO : $l20_edital/$l20_datacria";
$oPDF->addpage();
$oPDF->ln();
$oPDF->setfont('arial','b',14);
$oPDF->cell(0,8,"ADJUDICAÇÃO DE PROCESSO",0,1,"C",0);
$oPDF->cell(0,8,"PROCESSO LICITATORIO : $l20_edital/$l20_datacria",0,1,"C",0);
$oPDF->cell(0,8,"$l03_descr Nº $l20_numero/$l20_datacria",0,1,"C",0);
$oPDF->setfont('arial','',8);
$oPDF->ln();
$oPDF->MultiCell(0,4,"O Sr.(a), ".$pregoeiro." no uso de suas atribuições legais Adjudica o julgamento proferido pela comissão de Licitação, do Processo Licitatorio Nº".$l20_edital."/".$l20_datacria." modalidade ".$l20_numero."/".$l20_datacria." OBJETO: ".$l20_objeto." dando providências. Fica adjudicado o julgamento pela Comissão de licitação, nomeada pela portaria Nº ".$l30_portaria.". Os itens relacionados para os fornecedores abaixo:",0,"J",0,0);
$result_munic=pg_exec("select * from db_config where codigo=$dbinstit");
db_fieldsmemory($result_munic,0);

$oPDF->ln();
$result_orc=$clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo,"pc22_codorc as orcamento"));
if ($clliclicita->numrows == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros de valores lancados!');
    exit;
}
db_fieldsmemory($result_orc,0);
$result_forne=$clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"*",null,"pc21_codorc=$orcamento"));
$numrows_forne=$clpcorcamforne->numrows;

$oPDF->SetFillColor(235);
$cor=0;

for($x = 0; $x < $numrows_forne;$x++){
    db_fieldsmemory($result_forne,$x);
    $result_itens=$clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null,"distinct l21_ordem,pc22_orcamitem,pc11_resum,pc01_descrmater","l21_ordem","pc22_codorc=$orcamento"));
    $numrows_itens=$clpcorcamitem->numrows;

    for($w=0;$w<$numrows_itens;$w++){
        db_fieldsmemory($result_itens,$w);
        $result_valor=$clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null,null,"pc23_valor,pc23_quant,pc24_pontuacao",null,"pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem and pc24_pontuacao=1"));
        if ($clpcorcamval->numrows>0){
            db_fieldsmemory($result_valor,0);
            if ($oPDF->gety() > $oPDF->h - 30){
                $oPDF->addpage();
            }
            if ($z01_nome!=$z01_nomeant){
                if ($quant_forne!=0){
                    $oPDF->cell(80,$alt,"VALOR TOTAL ADJUDICADO:","T",0,"R",0);
                    $oPDF->cell(30,$alt,"R$".db_formatar($val_forne, 'f'),"T",1,"R",0);
                    $oPDF->ln();
                    $quant_forne = 0;
                    $val_forne = 0;
                }
                $oPDF->setfont('arial','b',9);
                $z01_nomeant = $z01_nome;
                $oPDF->cell(80,$alt,substr($z01_nome,0,40),0,1,"L",0);
                $oPDF->cell(30,$alt,"Quant. Adjud.",0,0,"R",0);
                $oPDF->cell(30,$alt,"Valor Adjud.",0,1,"R",0);
                $oPDF->ln();
                $oPDF->setfont('arial','',8);
            }

            if ($cor == 0) {
                $cor = 1;
            } else {
                $cor = 0;
            }
            $oPDF->multicell(180,$alt,"Item ".$l21_ordem." - ".$pc01_descrmater . " - " . $pc11_resum,0,"J",$cor);
            $oPDF->cell(30,$alt,$pc23_quant,0,0,"C",$cor);
            $oPDF->cell(30,$alt,"R$".db_formatar(@$pc23_valor,'f'),0,1,"C",$cor);
            $quant_tot += $pc23_quant;
            $val_tot += $pc23_valor;
            $quant_forne += $pc23_quant;
            $val_forne += $pc23_valor;
            }
        }
    }


$oPDF->cell(80,$alt,"VALOR TOTAL ADJUDICADO:",'T',0,"R",0);
$oPDF->cell(30,$alt,"R$".db_formatar($val_tot, 'f'),'T',1,"R",0);

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$hoje = date("Y-m-d",db_getsession("DB_datausu"));
$dataformatada = strftime('%d de %B de %Y',strtotime($hoje));

$oPDF->ln();
$oPDF->cell(90,0.5," ",0,0,"R",0);
$oPDF->cell(135,$alt,$munic.", ".$dataformatada.".",0,1,"C",0);
$oPDF->ln();
$oPDF->ln();
$oPDF->cell(185,$alt,"__________________________________",0,1,"R",0);
$oPDF->cell(180,$alt,$pregoeiro,0,0,"R",0);

/**
 *comentado por mario junior pois as linhas seram criadas de forma manual no relatorio.
 * a formataçao do texto ainda sera feita pelo documento padrao.
 *
 */

//  $aParagrafos = $oLibDocumento->getDocParagrafos();
//  //
//  // for percorrendo os paragrafos do documento
//  //
////echo "<pre>";
////  var_dump($aParagrafos);exit;
//  foreach ($aParagrafos as $oParag) {
//      if ($oParag->oParag->db02_tipo == "3" ){
//            eval($oParag->oParag->db02_texto);
//          }else{
//            $oParag->writeText( $oPDF );
//         }
//
//  }


$oPDF->Output();


?>