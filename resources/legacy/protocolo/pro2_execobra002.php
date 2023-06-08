<?
/*
 *     E-cidade Software Público para Gestão Municipal                
 *  Copyright (C) 2014  DBseller Serviços de Informática             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa é software livre; você pode redistribuí-lo e/ou     
 *  modificá-lo sob os termos da Licença Pública Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versão 2 da      
 *  Licença como (a seu critério) qualquer versão mais nova.          
 *                                                                    
 *  Este programa e distribuído na expectativa de ser útil, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implícita de              
 *  COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM           
 *  PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Você deve ter recebido uma cópia da Licença Pública Geral GNU     
 *  junto com este programa; se não, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Cópia da licença no diretório licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require_once("libs/db_sql.php");
require_once("fpdf151/pdf4.php");
require_once("classes/db_obrasalvara_classe.php");
require_once("classes/db_obrasender_classe.php");
require_once("classes/db_obraslote_classe.php");
require_once("classes/db_obraslotei_classe.php");
require_once("classes/db_obras_classe.php");
require_once("classes/db_obrastec_classe.php");
require_once("classes/db_obrastecnicos_classe.php");
require_once("classes/db_obrasconstr_classe.php");

$clobrasalvara   = new cl_obrasalvara;
$clobrasender	   = new cl_obrasender;
$clobraslote	   = new cl_obraslote;
$clobraslotei    = new cl_obraslotei;
$clobras			   = new cl_obras;
$clobrastec      = new cl_obrastec;
$clobrastecnicos = new cl_obrastecnicos;
$clobrasconstr   = new cl_obrasconstr;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

if(!isset($codigo) || $codigo==''){
  
  $sMsg = _M('tributario.projetos.pro2_execobra002.obra_nao_encontrada');
  db_redireciona("db_erros.php?fechar=true&db_erro={$sMsg}");
}

db_sel_instit(null, "db21_usadistritounidade");

$borda   = 1; 
$bordat  = 1;
$preenc  = 0;
$TPagina = 57;
$xnumpre = '';

$sCampos  = "cgm.z01_numcgm,                        ";
$sCampos .= "cgm.z01_nome,                          ";
$sCampos .= "cgm.z01_cgccpf,                        ";
$sCampos .= "cgm.z01_ender,                         ";
$sCampos .= "cgm.z01_numero,                        ";
$sCampos .= "cgm.z01_compl,                         ";
$sCampos .= "cgm.z01_bairro,                        ";
$sCampos .= "cgm.z01_munic,                         ";
$sCampos .= "cgm.z01_uf,                            ";
$sCampos .= "cgm.z01_cep,                           ";
$sCampos .= "p58_codigo,                            ";
$sCampos .= "obrasalvara.*,                         ";
$sCampos .= "obrasiptubase.ob24_iptubase,           ";
$sCampos .= "(setorloc.j05_codigoproprio||'-'||     ";
$sCampos .= "setorloc.j05_descr) as setorloc,       ";
$sCampos .= "(loteloc.j06_quadraloc) as quadraloc,  ";
$sCampos .= "(loteloc.j06_lote) as loteloc,		      ";
$sCampos .= "obrasconstr.ob08_codconstr             ";

$clobrasalvara->sql_query_cartaAlvara($sCampos, $codigo);
$rsObrasAlvara = $clobrasalvara->sql_record($clobrasalvara->sql_query_cartaAlvara($sCampos, $codigo));

if($clobrasalvara->numrows == 0){
  
  $oParms = new stdClass();
  $oParms->iCodigo = $codigo;
  $sMsg = _M('tributario.projetos.pro2_execobra002.obra_codigo_nao_encontrada', $oParms);
  db_redireciona("db_erros.php?fechar=true&db_erro={$sMsg}");
  exit; 
}

db_fieldsmemory($rsObrasAlvara,0,true);

//Local da Obra
$result_obrasender=$clobrasender->sql_record($clobrasender->sql_query(null,"*",""," ob07_codobra=$codigo"));
if($clobrasender->numrows>0){
  db_fieldsmemory($result_obrasender,0);
}

//Lote da Obra
$result_obraslote=$clobraslote->sql_record($clobraslote->sql_query($codigo,"j34_lote as lote,j34_quadra as quadra,j34_setor as setor"));
if($clobraslote->numrows>0){
  db_fieldsmemory($result_obraslote,0);
}else{
  $result_obraslotei=$clobraslotei->sql_record($clobraslotei->sql_query($codigo,"ob06_quadra as quadra,ob06_lote as lote,ob06_setor as setor"));
  if($clobraslotei->numrows>0){
    db_fieldsmemory($result_obraslotei,0);
  }
}

//Técnicos da Obra
$rsObrasTecnicos = $clobrastecnicos->sql_record($clobrastecnicos->sql_query_file(null,"ob20_obrastec",null,"ob20_codobra = $codigo"));

if($clobrastecnicos->numrows>0){
  db_fieldsmemory($rsObrasTecnicos,0);
  
	$result_obrastec=$clobrastec->sql_record($clobrastec->sql_query($ob20_obrastec,"z01_nome as eng,ob15_crea"));
  
	if($clobrastec->numrows>0){
    db_fieldsmemory($result_obrastec,0);
  }
}

//Dados da Construção
$dados_obrasconstr=$clobrasconstr->sql_record($clobrasconstr->sql_query_file($ob08_codobra=$codigo));
if($clobrasconstr->numrows>0){
  db_fieldsmemory($dados_obrasconstr,0);
}

//Area Total Construida
$result_obrasconstr=$clobrasconstr->sql_record($clobrasconstr->sql_query_file(null,"sum(ob08_area) as areatotal","",
" ob08_codobra=$codigo"));
if($clobrasconstr->numrows>0){
  db_fieldsmemory($result_obrasconstr,0);
}

//Existe cadastro na IptuBase?
if ($ob24_iptubase != null){
  $sql = "SELECT j34_distrito,j34_setor,j34_quadra,j34_lote,j01_unidade 
          FROM iptubase 
          INNER JOIN lote ON j01_idbql = j34_idbql
          WHERE j01_matric = ".$ob24_iptubase;
}

//Dados das Características da Obra.
$dados_caractericas=$clobrasconstr->sql_record($clobrasconstr->sql_query_caracteristicasConstrucao($codigo));
if($clobrasconstr->numrows>0){
  db_fieldsmemory($dados_caractericas,0);
}

if($numMatriculaLote > 0){
  db_fieldsmemory($matriculaLote,0);  
}

$dia = date("d");
$mes = date("m");
$ano = date("Y");
$mes_extenso = array("01"=>"janeiro","02"=>"fevereiro","03"=>"março","04"=>"abril","05"=>"maio","06"=>"junho","07"=>"julho","08"=>"agosto","09"=>"setembro","10"=>"outubro","11"=>"novembro","12"=>"dezembro");
$data="Guaíba, ".$dia." de ".$mes_extenso[$mes]." de ".$ano.".";

$pdf = new PDF4(); // abre a classe
$pdf->Open(); // abre o relatorio
$pdf->AliasNbPages(); // gera alias para as paginas
$pdf->AddPage(); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
/////// TEXTOS E ASSINATURAS

$instit = db_getsession("DB_instit");
$sqltexto = "select * from db_textos where id_instit = $instit and ( descrtexto like 'alvara%' or descrtexto like 'ass_alvara%')";

$resulttexto = db_query($sqltexto);

if (pg_num_rows($resulttexto) == 0 || $resulttexto == false) {
  $sMsg = _M('tributario.projetos.pro2_execobra002.configure_parametros');
  db_redireciona("db_erros.php?fechar=true&db_erro={$sMsg}");
  exit;
}


for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
  db_fieldsmemory($resulttexto,$xx);
  $text  = $descrtexto;
  $$text = db_geratexto($conteudotexto);
}

////////relatorio
//$pdf->MultiCell(0,4,$alvara_tit,0,"C",0,0);
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10, 20);
$pdf->Cell(0, 6,'Departamento de Cadastro Imobiliário',0,1,"C",0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'ALVARÁ DE LICENÇA PARA CONSTRUÇÃO',0,1,"C",0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,"ALVARÁ N°: $ob04_alvara",0,1,"C",0);
$pdf->SetFont('Arial','',9);
//$pdf->Cell(0,6,"Validade: 0 Dias/Meses/Anos",0,1,"C",0);
$pdf->Cell(0,6,"Válido de "."$ob04_data á $ob04_dtvalidade",0,1,"C",0);
$pdf->Cell(0,6,"Data de Expedição: $ob04_dataexpedicao",0,1,"C",0);
$pdf->Ln(1);
$alt=4;

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Dados do Proprietário',1,1,"C",1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"CGM: ","LT",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$z01_numcgm,"TR",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Nome do proprietário: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$z01_nome,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"CPF/CNPJ: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
if(strlen(trim($z01_cgccpf))==11){
  $z01_cgccpf=db_formatar($z01_cgccpf,"cpf");
}else if(strlen(trim($z01_cgccpf))==14){
  $z01_cgccpf=db_formatar($z01_cgccpf,"cnpj");
}
$pdf->Cell(0,$alt,$z01_cgccpf,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Endereço: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$z01_ender,0,0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(22,$alt,"Número: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(63,$alt,$z01_numero,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Bairro: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$z01_bairro,0,0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(22,$alt,"Complemento: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(63,$alt,$z01_compl,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Município: ","LB",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$z01_munic,"B",0,"L",0);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(22,$alt,"Estado: ","B",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,$alt,$z01_uf,"B",0,"L",0);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(10,$alt,"Cep: ","B",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,db_formatar($z01_cep,'cep'),"RB",1,"L",0);

$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Dados da Obra',1,1,"C",1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Engenheiro responsável: ","LT",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(110,$alt,$eng,"T",0,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,$alt,"CREA: ","T",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob15_crea,"RT",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Código da Obra: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob04_codobra,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Sequencial do Alvará: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob04_alvara,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Área Total da Construção: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$areatotal,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Área Total Atual Construída: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob07_areaatual,"R",1,"L",0);

// $pdf->SetFont('Arial','B',8);
// $pdf->Cell(40,$alt,"Validade: ","L",0,"L",0);
// $pdf->SetFont('Arial','',8);
// $pdf->Cell(0,$alt,"Dias/Mês/Anos","R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Válido de ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,"$ob04_data á $ob04_dtvalidade","R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Unidade: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob07_unidades,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Pavimentos: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob07_pavimentos,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Protocolo: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob04_processo,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Data do Protocolo: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob04_dtprocesso,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Data da Aprovação: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob04_dataexpedicao,"R",1,"L",0);

if($db21_usadistritounidade == 't'){
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(15,$alt,"Distrito: ","L",0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(20,$alt,$j34_distrito,0,0,"L",0);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(15,$alt,"Setor: ",0,0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(20,$alt,$j34_setor,0,0,"L",0);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(15,$alt,"Quadra: ",0,0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(20,$alt,$j34_quadra,0,0,"L",0);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(10,$alt,"Lote: ",0,0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(20,$alt,$j34_lote,0,0,"L",0);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(15,$alt,"Unidade: ",0,0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(0,$alt,$j01_unidade,"R",1,"R",0);
}else{
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(15,$alt,"Setor: ","L",0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(20,$alt,$setor,0,0,"L",0);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(15,$alt,"Quadra: ",0,0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(20,$alt,$quadra,0,0,"L",0);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(10,$alt,"Lote: ",0,0,"L",0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(20,$alt,$lote,"R",1,"R",0);
}

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,$alt,"Localização","LR",1,"C",1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,$alt,"Planta: ","LB",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,$alt,$setorloc,"B",0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,$alt,"Quadra: ","B",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,$alt,$quadraloc,"B",0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,$alt,"Lote: ","B",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$loteloc,"RB",1,"L",0);

$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Local da Obra',1,1,"C",1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Endereço: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,"$j88_sigla $j14_nome",0,0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(22,$alt,"Número: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(63,$alt,$ob07_numero,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Bairro: ","LB",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$j13_descr,"B",0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(22,$alt,"Complemento: ","B",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(63,$alt,$ob07_compl,"RB",1,"L",0);

$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Características da Obra',1,1,"C",1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Ocupação: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ocupacao,"R",1,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Tipo de Construção: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$construcao,"R",1,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Tipo de Lançamento: ","LB",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$tipo_lancamento,"RB",1,"L",0);

$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,"Observações: ",1,1,"C",1);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,$alt,$ob04_obsprocesso,"LRB",1,"L",0);

$pdf->sety(264);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"________________________________________",0,1,"C",0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'Funcionário Responsável',0,1,"C",0);

$pdf->Output();
?>