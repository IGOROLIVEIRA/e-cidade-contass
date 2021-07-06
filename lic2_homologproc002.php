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
$campos = "l20_codigo,l20_edital,l20_anousu,l20_numero,l20_datacria,l20_objeto,cgmrepresentante.z01_nome AS nome,cgmrepresentante.z01_cgccpf AS cpf,l44_descricao";
$rsLicitacao   = $clliclicita->sql_record( $clliclicita->sql_query_equipepregao(null,$campos,"l20_codigo","l20_codigo=$l20_codigo and l31_tipo = '6' and l20_instit = $dbinstit"));

if ($clliclicita->numrows == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado, ou licitação não julgada, ou licitação revogada');
  exit;
}
db_fieldsmemory($rsLicitacao,0);
  $head3 = "HOMOLOGAÇÃO DO PROCESSO ";
  $head4 = strtoupper($l44_descricao)." : $l20_edital/".substr($l20_anousu,0,4);
  $head5 = "SEQUENCIAL: $l20_codigo";
  $oPDF->addpage();
  $oPDF->setfont('arial','b',12);
  $oPDF->ln();
  $oPDF->cell(0,5,"HOMOLOGAÇÃO DE PROCESSO",0,1,"C",0);
  $oPDF->setfont('arial','b',10);
  $oPDF->cell(0,5,"PROCESSO LICITATÓRIO Nº : $l20_edital/".substr($l20_anousu,0,4),0,1,"C",0);
  $oPDF->cell(0,5,strtoupper($l44_descricao)." Nº : $l20_numero/".substr($l20_anousu,0,4),0,1,"C",0);
  $oPDF->setfont('arial','',8);
  $oPDF->ln(2);
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
$oLibDocumento->l20_anousu    = $olicitacao->l20_anousu;
$oLibDocumento->l44_descricao = strtoupper($olicitacao->l44_descricao);
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
$oPDF->ln();
$result_orc=$clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo,"pc22_codorc as orcamento"));

if ($clliclicita->numrows == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Não existem registros de valores lancados!");
    exit;
}
db_fieldsmemory($result_orc,0);
$result_forne=$clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"*",null,"pc21_codorc=$orcamento"));
//db_criatabela($result_forne);exit;
$numrows_forne=$clpcorcamforne->numrows;

$oPDF->SetFillColor(235);
$cor=0;

for($x = 0; $x < $numrows_forne;$x++){
    db_fieldsmemory($result_forne,$x);
    $result_itens=$clpcorcamitem->sql_record($clpcorcamitem->sql_query_homologados(null,"distinct l21_ordem,pc22_orcamitem,pc11_resum,pc01_descrmater","l21_ordem","pc22_codorc=$orcamento"));
    $numrows_itens=$clpcorcamitem->numrows;

    /**
     * Verifica se existe em algum item a descriçãi da Marca ou OBS
     */
        for($w=0;$w<$numrows_itens;$w++){
            db_fieldsmemory($result_itens,$w);
            $result_valor=$clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null,null,"pc23_valor,pc23_quant,pc23_obs,pc23_vlrun,pc24_pontuacao",null,"pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem and pc24_pontuacao=1"));
            if ($clpcorcamval->numrows>0){
    
                $op = 1;
                if($clpcorcamval->numrows>0){
                    
                    for($i=0;$i<$clpcorcamval->numrows;$i++){
                        $result2 = db_utils::fieldsMemory($result_valor,$i);
    
                        if($result2->pc23_obs != ""){
                            $op = 2;
                        }
                    }
                }
            }
        }

    if ($oPDF->gety() > $oPDF->h - 30){
        $oPDF->ln(2);
        $oPDF->addpage();
    }
    for($w=0;$w<$numrows_itens;$w++){
        db_fieldsmemory($result_itens,$w);
        $result_valor=$clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null,null,"pc23_valor,pc23_quant,pc23_obs,pc23_vlrun,pc24_pontuacao",null,"pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem and pc24_pontuacao=1"));
        if ($clpcorcamval->numrows>0){
            db_fieldsmemory($result_valor,0);

            if ($oPDF->gety() > $oPDF->h - 30){
                $oPDF->ln(2);
                $oPDF->addpage();
            }
            if ($z01_nome!=$z01_nomeant){
                if ($quant_forne!=0){
                    $oPDF->cell(120,$alt,"VALOR TOTAL HOMOLOGADO:","T",0,"R",0);
                    $oPDF->cell(60,$alt,"R$".db_formatar($val_forne, "f"),"T",1,"R",0);
                    $oPDF->ln();
                    $quant_forne = 0;
                    $val_forne = 0;
                }
                if($op==2){
                    $oPDF->setfont("arial","b",9);
                    $z01_nomeant = $z01_nome;
                    $oPDF->cell(80,$alt,substr($z01_nome,0,40)." - ".$z01_cgccpf,0,1,"L",0);
                    $oPDF->cell(25,$alt,"Quantidade",0,0,"R",0);
                    $oPDF->cell(35,$alt,"Marca",0,0,"C",0);
                    $oPDF->cell(45,$alt,"Valor Unitário",0,0,"R",0);
                    $oPDF->cell(80,$alt,"Valor Total",0,1,"R",0);
                    $oPDF->ln();
                    $oPDF->setfont("arial","",8);
                }else if($op==1){
                    $oPDF->setfont("arial","b",9);
                    $z01_nomeant = $z01_nome;
                    $oPDF->cell(80,$alt,substr($z01_nome,0,40)." - ".$z01_cgccpf,0,1,"L",0);
                    $oPDF->cell(25,$alt,"Quantidade",0,0,"R",0);
                    $oPDF->cell(35,$alt,"Valor Unitário",0,0,"R",0);
                    $oPDF->cell(120,$alt,"Valor Total",0,1,"R",0);
                    $oPDF->ln();
                    $oPDF->setfont("arial","",8);
                }
                
            }
            if ($cor == 0) {
                $cor = 1;
            } else {
                $cor = 0;
            }
            if($op==2){

                $oPDF->multicell(180,$alt,"Item ".$l21_ordem." - ".$pc01_descrmater . " - " . $pc11_resum,0,"J",$cor);
                $oPDF->cell(15,$alt,$pc23_quant,0,0,"R",$cor);
                $oPDF->cell(55,$alt,$pc23_obs,0,0,"C",$cor);
                $oPDF->cell(20,$alt,$pc23_vlrun,0,0,"R",$cor);
                $oPDF->cell(90,$alt,"R$".db_formatar(@$pc23_valor,"f"),0,1,"R",$cor);
                $quant_tot += $pc23_quant;
                $val_tot += $pc23_valor;
                $quant_forne += $pc23_quant;
                $val_forne += $pc23_valor;
            }else if($op==1){

                $oPDF->multicell(180,$alt,"Item ".$l21_ordem." - ".$pc01_descrmater . " - " . $pc11_resum,0,"J",$cor);
                $oPDF->cell(15,$alt,$pc23_quant,0,0,"R",$cor);
                $oPDF->cell(35,$alt,$pc23_vlrun,0,0,"R",$cor);
                $oPDF->cell(130,$alt,"R$".db_formatar(@$pc23_valor,"f"),0,1,"R",$cor);
                $quant_tot += $pc23_quant;
                $val_tot += $pc23_valor;
                $quant_forne += $pc23_quant;
                $val_forne += $pc23_valor;
            }
            
            if ($oPDF->gety() > $oPDF->h - 30){
                $oPDF->addpage();
            }
        }
    }

    if ($oPDF->gety() > $oPDF->h - 30){
        $oPDF->ln(2);
        $oPDF->addpage();
    }
}
if ($val_forne > 0){
    $oPDF->cell(120,$alt,"VALOR TOTAL HOMOLOGADO:","T",0,"R",0);
    $oPDF->cell(60,$alt,"R$".db_formatar($val_forne, "f"),"T",1,"R",0);
    $oPDF->ln();
}

$oPDF->ln();
$oPDF->cell(120,$alt,"TOTAL:","T",0,"R",0);
$oPDF->cell(60,$alt,"R$".db_formatar($val_tot, "f"),"T",1,"R",0);
$oPDF->ln();

$oPDF->setfont('arial','',9);
$dia=date('d',db_getsession("DB_datausu"));
$mes=date('m',db_getsession("DB_datausu"));
$ano=date('Y',db_getsession("DB_datausu"));
$mes=db_mes($mes);
$oPDF->ln();
$oPDF->ln();
$oPDF->cell(90,$alt,"",0,0,"R",0);
$oPDF->cell(90,$alt,"$munic, $dia $mes de $ano.",0,1,"C",0);
$oPDF->ln(15);

$sqlparag = "select db02_texto
       from db_documento
        inner join db_docparag on db03_docum = db04_docum
            inner join db_tipodoc on db08_codigo  = db03_tipodoc
          inner join db_paragrafo on db04_idparag = db02_idparag
      where db03_tipodoc = 1000 and db03_instit = $dbinstit order by db04_ordem ";

$resparag = @pg_query($sqlparag);
$numrows  = 0;
$numrows  = @pg_numrows($resparag);

for($i = 0; $i < $numrows; $i++){
    db_fieldsmemory($resparag,$i);

    $oPDF->cell(90,0.5,"",0,0,"R",0);
    $oPDF->cell(90,$alt,$db02_texto,0,1,"C",0);
    $oPDF->cell(90,0.5,"",0,1,"R",0);
}

if ($numrows == 0){
    $oPDF->cell(90,$alt,"",0,0,"R",0);
    $oPDF->cell(90,$alt,"ASSINATURA",0,1,"C",0);
}
$oPDF->Output();

?>
