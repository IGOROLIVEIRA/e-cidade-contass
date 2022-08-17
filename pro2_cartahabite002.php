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

include("libs/db_sql.php");
include("fpdf151/pdf4.php");
include("libs/db_utils.php");
include("libs/db_libdocumento.php");
include("classes/db_obrashabite_classe.php");
include("classes/db_obrasender_classe.php");
include("classes/db_obraspropri_classe.php");
include("classes/db_obras_classe.php");
include("classes/db_obrastecnicos_classe.php");
include("classes/db_obrasalvara_classe.php");
include("classes/db_obraslote_classe.php");
include("classes/db_obraslotei_classe.php");
include("classes/db_obrashabiteprot_classe.php");

$clobrashabite    = new cl_obrashabite;
$clobrasender     = new cl_obrasender;
$clobraspropri    = new cl_obraspropri;
$clobras          = new cl_obras;
$clobrastecnicos  = new cl_obrastecnicos;
$clobrasalvara    = new cl_obrasalvara;
$clobraslote      = new cl_obraslote;
$clobraslotei     = new cl_obraslotei;
$clobrashabiteprot= new cl_obrashabiteprot;
$cldb_usuarios    = new cl_db_usuarios;

$oLibDocumento    = new libdocumento(1021);

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);

if(!isset($codigo) || $codigo==''){
  
  $sMsg = _M('tributario.projetos.pro2_cartahabite002.carta_nao_encontrada');
  db_redireciona("db_erros.php?fechar=true&db_erro={$sMsg}");
}else{
  $cod_hab=$codigo;
}
$borda   = 1; 
$bordat  = 1;
$preenc  = 0;
$TPagina = 57;
$xnumpre = '';

// funcao q busca todos os dados da instituicao(da sessao) e cria as variaveis em memoria mais informacoes libs/db_stdlib.php

db_sel_instit();

/***************************************************************************************************************************/

$sCamposHabite  = " obrashabite.*,                                                                                                ";
$sCamposHabite .= " obrasconstr.*,                                                                                                ";
$sCamposHabite .= " trim(ob09_logradcorresp)||','||ob09_numcorresp||','||ob09_compl||','||trim(ob09_bairrocorresp) as endcorresp, ";
$sCamposHabite .= " trim(z01_ender)||','||z01_numero||','||z01_compl||','||trim(z01_bairro)||','||trim(z01_munic)  as endcgm,     ";
$sCamposHabite .= " z01_nome,                                                                                                     ";
$sCamposHabite .= " (z01_numcgm)prop_cgm, (z01_nome)prop_nome, (z01_cgccpf)prop_cgccpf, (z01_ender)prop_ender,                    ";
$sCamposHabite .= " (z01_numero)prop_ender_numero, (z01_compl)prop_compl, (z01_bairro)prop_bairro, (z01_munic)prop_cidade,        ";
$sCamposHabite .= " (z01_uf)prop_uf, (z01_cep)prop_cep,(caracter.j31_descr)caracteriscadesc,                                      ";  
$sCamposHabite .= " ob01_codobra,                                                                                                 ";
$sCamposHabite .= " case                                                                                                          ";
$sCamposHabite .= "    when ob19_codproc is not null then ob19_codproc                                                            ";
$sCamposHabite .= "    when ob22_codproc is not null then ob22_codproc                                                            ";
$sCamposHabite .= " end as codproc,                                                                                               ";
$sCamposHabite .= " case                                                                                                          ";
$sCamposHabite .= "    when p58_dtproc is not null then p58_dtproc                                                                ";
$sCamposHabite .= "    when ob22_data  is not null then ob22_data                                                                 ";
$sCamposHabite .= " end as dtproc                                                                                                 ";

$result_obrashabite = $clobrashabite->sql_record($clobrashabite->sql_query($cod_hab,$sCamposHabite));

if($clobrashabite->numrows == 0){
  
  $oParms          = new stdClass();
  $oParms->iCodigo = $codigo;
  $sMsg = _M('tributario.projetos.pro2_cartahabite002.carta_codigo_nao_encontrada', $oParms);
  db_redireciona("db_erros.php?fechar=true&db_erro={$sMsg}");
  exit; 
}

db_fieldsmemory($result_obrashabite,0);

$result_obrasender=$clobrasender->sql_record($clobrasender->sql_query_constr($ob08_codconstr,"ob07_numero,j13_descr,j14_nome,j31_descr"));
if($clobrasender->numrows>0){
  db_fieldsmemory($result_obrasender,0);
}

//técnico
$rsTecnico = $clobrastecnicos->sql_record($clobrastecnicos->sql_query(null,"z01_nome as tec, ob15_crea as tec_crea","","ob20_codobra = $ob01_codobra"));
if($clobrastecnicos->numrows>0){
  db_fieldsmemory($rsTecnico,0);
}

//eng. prefeitura
$rsEngPrefeitura = $clobrashabite->sql_record($clobrashabite->sql_query_engpref(null,"z01_nome as engpref, ob15_crea as engpref_crea",null," ob15_sequencial =$ob09_engprefeitura"));
if($clobrashabite->numrows > 0){
  db_fieldsmemory($rsEngPrefeitura,0);
}

//Alvará de Habite-se
$rsAlvaraHabiteSe = $clobrasalvara->sql_record($clobrasalvara->sql_query($ob01_codobra));
if ($clobrasalvara->numrows > 0){
  db_fieldsmemory($rsAlvaraHabiteSe, 0);
}

//Local da Obra
$rsLocalObra = $clobrasender->sql_record($clobrasender->sql_query($ob09_codconstr));
if ($clobrasender->numrows > 0){
  db_fieldsmemory($rsLocalObra, 0);
}

//Nome de Usuário
$rsNomeUsu = $cldb_usuarios->sql_record($cldb_usuarios->sql_query(db_getsession('DB_id_usuario')));
$oNomeUsu  	 = db_utils::fieldsMemory($rsNomeUsu,0);
$idUsuario = $oNomeUsu->id_usuario;
$nomeUsu 	 = $oNomeUsu->nome;

if ($cldb_usuarios->numrows > 0){
  db_fieldsmemory($rsNomeUsu, 0);
}

$result_obraslote=$clobraslote->sql_record($clobraslote->sql_query($ob01_codobra,"j34_lote as lote,j34_quadra as quadra,j34_setor as setor"));
if($clobraslote->numrows>0){
  db_fieldsmemory($result_obraslote,0);
}else{
  $result_obraslotei=$clobraslotei->sql_record($clobraslotei->sql_query($ob01_codobra,"ob06_quadra as quadra,ob06_lote as lote, ob06_setor as setor"));
  if($clobraslotei->numrows>0){
    db_fieldsmemory($result_obraslotei,0);
  }
}
$ob24_iptubase = "";

$sSql = " select *,                                                                            ";
$sSql.= "        case when ob01_regular is true then j34_setor  else ob06_setor  end as setor ,";
$sSql.= "        case when ob01_regular is true then j34_quadra else ob06_quadra end as quadra,";
$sSql.= "        case when ob01_regular is true then j34_lote   else ob06_lote   end as lote  ,";
$sSql.= "        j06_setorloc  as setorloc ,                                                   ";
$sSql.= "        j06_quadraloc as quadraloc,                                                   ";
$sSql.= "        j06_lote      as loteloc                                                      ";
$sSql.= "   from obras                                                                         ";
$sSql.= "        left join obrasiptubase on obrasiptubase.ob24_obras    = obras.ob01_codobra   ";
$sSql.= "        left join iptubase      on obrasiptubase.ob24_iptubase = iptubase.j01_matric  ";
$sSql.= "        left join lote          on lote.j34_idbql              = iptubase.j01_idbql   ";
$sSql.= "        left join obraslotei    on obraslotei.ob06_codobra     = obras.ob01_codobra   ";
$sSql.= "        left join loteloc       on loteloc.j06_idbql           = iptubase.j01_matric  ";
$sSql.= "  where obras.ob01_codobra = {$ob01_codobra} limit 1                                  ";

$rsSql = db_query($sSql);
$ob19_codproc = "";

$rsObrasHabiteProt = $clobrashabiteprot->sql_record($clobrashabiteprot->sql_query(null,"*",null,"ob19_codhab = $cod_hab"));

if($clobrastecnicos->numrows > 0 && $clobrashabiteprot->numrows > 0){
  db_fieldsmemory($rsObrasHabiteProt, 0);
}
db_fieldsmemory($rsSql, 0);

$data = date("Y-m-d",DB_getsession("DB_datausu"));
$dia  = date("d");
$mes  = date("m");
$ano  = date("Y");
$mes_extenso  = array("01"=>"janeiro","02"=>"fevereiro","03"=>"março","04"=>"abril","05"=>"maio","06"=>"junho","07"=>"julho","08"=>"agosto","09"=>"setembro","10"=>"outubro","11"=>"novembro","12"=>"dezembro");
$data_extenso = $munic.", ".$dia." de ".$mes_extenso[$mes]." de ".$ano.".";

/*============================================================  O DOCUMENTO PDF  ==============================================================================================*/ 

$pdf = new PDF4();             // abre a classe
$pdf->Open();                  // abre o relatorio
$pdf->AliasNbPages();          // gera alias para as paginas
$pdf->AddPage();               // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
////// TEXTOS E ASSINATURAS

$sqlparag = "select *
               from db_documento
               inner join db_docparag  on db03_docum   = db04_docum
               inner join db_tipodoc   on db08_codigo  = db03_tipodoc
               inner join db_paragrafo on db04_idparag = db02_idparag
         where db03_tipodoc = 1021 
           and db03_instit  = " . db_getsession("DB_instit")." order by db04_ordem ";


$resparag = db_query($sqlparag);
$numrows  = pg_numrows($resparag);

if($numrows == 0 ){
  
  $sMsg = _M('tributario.projetos.pro2_cartahabite002.configure_documento');
  db_redireciona("db_erros.php?fechar=true&db_erro={$sMsg}");
}else{
  db_fieldsmemory( $resparag,0);
}
$tpHabiteSe = 'PARCIAL';
if ($ob09_parcial == 'f'){
  $tpHabiteSe = 'TOTAL';
}

$pdf->SetXY(10, 20);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0, 6,'Departamento de Cadastro Imobiliário',0,1,"C",0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,'Habite-se Nº '.$cod_hab.' / '.$ob09_habite,0,1, "C", 0);
$pdf->ln(5);
$alt=4;

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Dados do Proprietário',1,1,"C",1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"CGM: ","LT",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$prop_cgm,"TR",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Nome do proprietário: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$prop_nome,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"CPF/CNPJ: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
if(strlen(trim($prop_cgccpf))==11){
  $prop_cgccpf=db_formatar($prop_cgccpf,"cpf");
}else {
  $prop_cgccpf=db_formatar($prop_cgccpf,"cnpj");
}
$pdf->Cell(0,$alt,$prop_cgccpf,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Matricula do Imóvel: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob24_iptubase,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Endereço: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$prop_ender,0,0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(22,$alt,"Número: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(63,$alt,$prop_ender_numero,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Bairro: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$prop_bairro,0,0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(22,$alt,"Complemento: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(63,$alt,$prop_compl,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Município: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$prop_cidade,0,0,"L",0);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(22,$alt,"Estado: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,$alt,$prop_uf,0,0,"L",0);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(10,$alt,"Cep: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,db_formatar($prop_cep,'cep'),"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,$alt,"Setor: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,$alt,$j34_setor,0,0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,$alt,"Quadra: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,$alt,$j34_quadra,0,0,"L",0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,$alt,"Lote: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$j34_lote,"R",1,"L",0);

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

$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Dados do Habite-se',1,1,"C",1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Código do Habite-se: ","LT",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob09_habite,"TR",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Engenheiro responsável: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(110,$alt,$tec,0,0,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,$alt,"CREA: ",0,0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$tec_crea,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Data do Habite-se: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,db_formatar($ob09_data,'d'),"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Sequencial do Habite-se: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$cod_hab,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Área Total da Construção: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob08_area,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Área Liberada: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob08_area,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Alvará de Construção: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob04_alvara,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Protocolo: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$ob19_codproc,"R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,$alt,"Data Protocolo: ","LB",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,db_formatar($dtproc,'d'),"RB",1,"L",0);

$pdf->ln();

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
$pdf->Cell(22,$alt,"Complemento:","B",0,"LB",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(63,$alt,$ob07_compl,"RB",1,"L",0);

$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Responsável pela Emissão',1,1,"C",1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Matricula: ","L",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,"$idUsuario","R",1,"L",0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Nome: ","LB",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,$alt,$nomeUsu,0,0,"LB",0);

$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Características da Obra',1,1,"C",1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,$alt,"Ocupação: ","LB",0,"L",0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,"$ob08_ocupacao - $caracteriscadesc","RB",1,"L",0);
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6,'Tipo de Habite-se',1,1,"C",1);

$pdf->SetFont('Arial','',8);
$pdf->Cell(0,$alt,$tpHabiteSe,"LRB",1,"C",0);

$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,"Observações: ",1,1,"C",1);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,$alt,$ob09_obs,"LRB",1,"L",0);

$pdf->sety(264);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"________________________________________",0,1,"C",0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'Funcionário Responsável',0,1,"C",0);

$pdf->Output();

// $oLibDocumento->codhab                  = @$cod_hab;//igo;
// $oLibDocumento->numero                  = @$ob07_numero;
// $oLibDocumento->nome                    = ucwords(strtolower($z01_nome));
// $oLibDocumento->rua                     = ucwords(strtolower(@$j14_nome));
// $oLibDocumento->tipoconstr              = @$j31_descr;
// $oLibDocumento->codproc                 = $codproc;
// $oLibDocumento->datavist                = db_dataextenso(db_strtotime($ob09_data),"");
// $oLibDocumento->areaconstr              = $ob08_area;
// $oLibDocumento->codh                    = $ob09_habite;
// $oLibDocumento->setor                   = @$setor;
// $oLibDocumento->quadra                  = @$quadra;
// $oLibDocumento->lote                    = @$lote;
// $oLibDocumento->dataproc                = db_formatar($dtproc,'d');
// $oLibDocumento->endercgm                = $endcgm;
// $oLibDocumento->endercorresp            = $endcorresp;
// $oLibDocumento->processo                = $codproc;
// $oLibDocumento->dataprot                = $dtproc;
// $oLibDocumento->ocupacao                = $ob08_ocupacao;
// $oLibDocumento->tipolanc                = $ob08_tipoconstr;
// $oLibDocumento->areatotarea             = $ob08_area;
// $oLibDocumento->arealiberada            = $ob09_area;
// $oLibDocumento->datahabit               = $ob09_data;
// $oLibDocumento->obs                     = $ob09_obs;
// $oLibDocumento->obsinss                 = $ob09_obsinss;
// $oLibDocumento->tipo                    = $ob09_parcial;
// $oLibDocumento->tecproj                 = $tec;
// $oLibDocumento->creaproj                = $tec_crea;
// $oLibDocumento->data_extenso            = $data_extenso;
// $oLibDocumento->data_protocolo_extenso  = db_dataextenso(db_strtotime($dtproc)   , "");
// $oLibDocumento->data_vistoria_extenso   = db_dataextenso(db_strtotime($ob09_data), "");
// $oLibDocumento->nome_eng_pref           = $engpref;
// $oLibDocumento->crea_eng_pref           = $engpref_crea;
// $oLibDocumento->ano_habite              = $ob09_anousu;
// $oLibDocumento->setorloc                = $setorloc;
// $oLibDocumento->quadraloc               = $quadraloc;
// $oLibDocumento->loteloc                 = $loteloc;
// $oLibDocumento->processoHabite          = $ob19_codproc;
// $oLibDocumento->observacoesHabite       = $ob09_obs;
// $oLibDocumento->matricula               = $ob24_iptubase;  

//$aParagrafo = $oLibDocumento->getDocParagrafos();

// foreach($aParagrafo as $oParag){
//     $oParag->writeText( $pdf );
//     $pdf->ln(5);
// }
?>