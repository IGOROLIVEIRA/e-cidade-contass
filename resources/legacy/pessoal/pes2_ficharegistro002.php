<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libpessoal.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pessoal_classe.php");
require_once("classes/db_rhpessoal_classe.php");
require_once("classes/db_rhpessoalmov_classe.php");
require_once("classes/db_rhinstrucao_classe.php");
require_once("classes/db_rhestcivil_classe.php");
require_once("classes/db_rhpesfgts_classe.php");
require_once("classes/db_rhpesbanco_classe.php");
require_once("classes/db_cadferia_classe.php");
require_once("classes/db_rhdepend_classe.php");
require_once("classes/db_rhtipoapos_classe.php");
require_once("classes/db_vtfdias_classe.php");
require_once("classes/db_afasta_classe.php");
require_once("classes/db_rhpeslocaltrab_classe.php");

$clpessoal        = new cl_pessoal;
$clrhpessoal      = new cl_rhpessoal;
$clrhpessoalmov   = new cl_rhpessoalmov;
$clrhtipoapos     = new cl_rhtipoapos;
$clrhinstrucao    = new cl_rhinstrucao;
$clrhestcivil     = new cl_rhestcivil;
$clrhpesfgts      = new cl_rhpesfgts;
$clrhpesbanco     = new cl_rhpesbanco;
$clcadferia       = new cl_cadferia;
$clrhdepend       = new cl_rhdepend;
$clvtfdias        = new cl_vtfdias;
$clafasta         = new cl_afasta;
$clrhpeslocaltrab = new cl_rhpeslocaltrab;

$clpessoal->rotulo->label();
$clrhpessoal->rotulo->label();
$clrhpessoalmov->rotulo->label();
$clrhpesfgts->rotulo->label();
$clrhpesbanco->rotulo->label();
$clrhtipoapos->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label('z01_nome');
$clrotulo->label('z01_ender');
$clrotulo->label('z01_munic');
$clrotulo->label('z01_numcgm');
$clrotulo->label('z01_cgccpf');

$clrotulo->label('h13_tpcont');
$clrotulo->label('h13_descr');

$clrotulo->label('r13_descr');
$clrotulo->label('r37_descr');

$clrotulo->label('rh03_padrao');
$clrotulo->label('rh37_cbo');
$clrotulo->label('rh37_descr');
$clrotulo->label('r02_descr');
$clrotulo->label('r70_descr');
$clrotulo->label('r70_estrut');
$clrotulo->label('rh30_regime');
$clrotulo->label('rh30_descr');
$clrotulo->label('rh30_vinculo');
$clrotulo->label('r33_nome');
$clrotulo->label('rh05_recis');
$clrotulo->label('db90_descr');

$clrotulo->label('rh44_codban');
$clrotulo->label('rh44_agencia');
$clrotulo->label('rh44_dvagencia');
$clrotulo->label('rh44_conta');
$clrotulo->label('rh44_dvconta');
//db_postmemory($HTTP_SERVER_VARS,2);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);



if(!isset($ano)){
  $ano = db_anofolha();
}
if(!isset($mes)){
  $mes = db_mesfolha();
}
$dataDia = date("Y-m-d", db_getsession("DB_datausu"));



/*
$sql = $clrhpessoal->sql_query_pesquisa(
                                        null,
                                        "
                                         *,
                                         case rh30_regime
                                              when 1 then 'Estatutário'
                                              when 2 then 'Celetista'
                                              when 3 then 'Extra-Quadro'
                                         end as descr_regime,
                                         case rh30_vinculo
                                              when 'A' then 'Ativo'
                                              when 'I' then 'Inativo'
                                              when 'P' then 'Pensionista'
                                         end as descr_vinculo,
                                         rh37_cbo as cbo,
                                         case rh02_vincrais
                                              when 10 then 'CLT'
                                              when 30 then 'Servidor Público'
                                              when 35 then 'Servidor Público Não Efetivo'
                                              when 40 then 'Trabalhador Avulso'
                                              when 90 then 'Contrato'
                                         end as descr_vinculorais,
                                         h13_descr as descr_contrato
                                        ",
                                        "",
                                        "
                                             rh02_anousu = $ano
                                         and rh02_mesusu = $mes
                                         and rh01_regist in (".$regist.")
                                         and rh02_instit = ".db_getsession("DB_instit"),
                                         $ano,
                                         $mes
                                       );


$result = $clrhpessoal->sql_record($sql);

if($clrhpessoal->numrows == 0){
  echo "
        <script>
          alert('Matrícula Não Cadastrada ou sem Movimentação.');
          CurrentWindow.corpo.location.href='pes2_ficharegistro001.php';
        </script>
       ";
}

db_fieldsmemory($result,0);

$result_rhpesfgts = $clrhpesfgts->sql_record($clrhpesfgts->sql_query_banco($rh01_regist,"rh15_data,rh15_banco,rh15_agencia,rh15_agencia_d,rh15_contac,rh15_contac_d,db90_descr"));
if($clrhpesfgts->numrows > 0){
  db_fieldsmemory($result_rhpesfgts,0);
}

$result_rhpesbanco = $clrhpesbanco->sql_record($clrhpesbanco->sql_query($rh02_seqpes,"*"));
if($clrhpesbanco->numrows > 0){
  db_fieldsmemory($result_rhpesbanco,0);
}

if ( !empty($rh02_rhtipoapos) ) {

	$rsRhTipoApos = $clrhtipoapos->sql_record($clrhtipoapos->sql_query($rh02_rhtipoapos));
	if ($clrhtipoapos->numrows > 0) {
	  db_fieldsmemory($rsRhTipoApos,0);
	}
}*/
//include ('pes2_ficharegistro_impressao.php');

?>

<?
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_cadferia_classe.php");
require_once("classes/db_pessoal_classe.php");
require_once("classes/db_cgm_classe.php");
require_once("classes/db_rhdepend_classe.php");
require_once("classes/db_rhtipoapos_classe.php");
require_once("classes/db_rhpessoalmov_classe.php");
require_once("classes/db_afasta_classe.php");



/*$sqlSeq = " SELECT setval('pes_ficharegistro_sequencial_seq', (select max(last_value)+1 from pes_ficharegistro_sequencial_seq));
			select *,last_value as sequenciarelatorio from pes_ficharegistro_sequencial_seq;";

$resultSeq = pg_exec($sqlSeq);
db_fieldsmemory($resultSeq,0);*/

function extenso($valor=0, $maiusculas=false)
{
    // verifica se tem virgula decimal
    if (strpos($valor,",") > 0)
    {
      // retira o ponto de milhar, se tiver
      $valor = str_replace(".","",$valor);

      // troca a virgula decimal por ponto decimal
      $valor = str_replace(",",".",$valor);
    }
$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
"quatrilhões");

$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
$u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
"sete", "oito", "nove");

        $z=0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
		$cont=count($inteiro);
		        for($i=0;$i<$cont;$i++)
                for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
                $inteiro[$i] = "0".$inteiro[$i];

        $fim = $cont - ($inteiro[$cont-1] > 0 ? 1 : 2);
        for ($i=0;$i<$cont;$i++) {
                $valor = $inteiro[$i];
                $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
                $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
                $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

                $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
                $t = $cont-1-$i;
                $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")$z++; elseif ($z > 0) $z--;
                if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
                if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

         if(!$maiusculas)
		 {
          return($rt ? $rt : "zero");
         } elseif($maiusculas == "2") {
          return (strtoupper($rt) ? strtoupper($rt) : "Zero");
         } else {
         return (ucwords($rt) ? ucwords($rt) : "Zero");
         }

}

$clpessoal = new cl_pessoal;
$clpessoal->rotulo->label();

$clcadferia = new cl_cadferia;
$clcadferia->rotulo->label();

$clcgm = new cl_cgm;
$clcgm->rotulo->label();

$cldepend = new cl_rhdepend;
$cldepend->rotulo->label();

$clafasta = new cl_afasta;
$clafasta->rotulo->label();

$clrhtipoapos = new cl_rhtipoapos;
$clrhtipoapos->rotulo->label();

$clrhpessoalmov = new cl_rhpessoalmov;
$clrhpessoalmov->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label('z01_nome');
$clrotulo->label('z01_ender');
$clrotulo->label('z01_munic');
$clrotulo->label('z01_numcgm');
$clrotulo->label('z01_cgccpf');
$clrotulo->label('r13_descr');
$clrotulo->label('r37_descr');
$clrotulo->label('rh55_descr');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

if(isset($consulta)){
  if(isset($locali) && trim($locali) != "" && isset($localf) && trim($localf) != ""){
    $head5 = "INTERVALO: ".$locali." até ".$localf;
    $where = " and rh55_estrut between '$locali'  and '$localf'";
  }else if(isset($locali) && trim($locali) != ""){
    $head5 = "LOCAIS MAIORES OU IGUAL A ".$locali;
    $where = " and rh55_estrut >= '$locali'";
  }else if(isset($localf) && trim($localf) != ""){
    $head5 = "LOCAIS MENORES OU IGUAL A ".$localf;
    $where = " and rh55_estrut <= '$localf'";
  }else if(isset($selloc) && trim($selloc) != ""){
    $head5 = "LOCAIS: ".$selloc;
    $where = " and rh55_estrut in ('".str_replace(",","','",$selloc)."')";
  }

  if(isset($atinpen)){
    if($atinpen == "a"){
      $where = " and rh30_vinculo = 'A' ";
    }else if($atinpen == "i"){
      $where = " and rh30_vinculo = 'I' ";
    }else if($atinpen == "p"){
      $where = " and rh30_vinculo = 'P' ";
    }else if($atinpen == "ip"){
      $where = " and rh30_vinculo <> 'A' ";
    }
  }

  if(trim($anofolha) == "" || trim($mesfolha) == ""){
    $ano = db_anofolha();
    $mes = db_mesfolha();
  }else{
    $ano = $anofolha;
    $mes = $mesfolha;
  }
}else{
	if (!empty($regist)) {
  		$where .= " and rh01_regist in (".$regist.")";
	}
	if (!empty($cod_ini) && !empty($cod_fim)){
		$where .= " and rh01_regist BETWEEN ". $cod_ini ." AND ". $cod_fim;
	}
	if (!empty($selecao)){
		$where .= " and r44_selec = ". $selecao;
	}
	if (!empty($lotacao)) {
  		$where .= " and r70_codigo in (".$lotacao.")";
	}
	if (!empty($cod_iniL) && !empty($cod_fimL)){
		$where .= " and r70_codigo BETWEEN ". $cod_iniL ." AND ". $cod_fimL;
	}
	if (!empty($selecao)){
		$where .= " and r44_selec = ". $selecao;
	}
}

$where = "where 1 = 1 ".$where;

$head3 = "CADASTRO DO FUNCIONÁRIO";
$head5 = "PERÍODO : ".$mes." / ".$ano;

$sql = "
	select *,
	         case rh30_regime
	              when 1 then 'Estatutário'
	              when 2 then 'Celetista'
	              when 3 then 'Extra-Quadro'
		 end as descr_regime,
	         case rh30_vinculo
	              when 'A' then 'Ativo'
	              when 'I' then 'Inativo'
	              when 'P' then 'Pensionista'
		 end as descr_vinculo,
	   rh37_cbo as cbo,
	         case rh02_vincrais
	              when 10 then 'CLT'
	              when 30 then 'Servidor Público'
	              when 35 then 'Servidor Público Não Efetivo'
	              when 40 then 'Trabalhador Avulso'
	              when 90 then 'Contrato'
		 end as descr_vinculorais,
     h13_descr as descr_contrato,
     rh01_observacao as observacao,
		 rh01_regist as regist

	from rhpessoal
	  inner join rhpessoalmov   on rh02_anousu     = $ano
		                         and rh02_mesusu     = $mes
		              	         and rh02_regist     = rh01_regist
										 			   and rh02_instit     = ".db_getsession("DB_instit")."
    inner join rhregime       on rh30_codreg     = rh02_codreg
                             and rh30_instit     = rh02_instit
	  left  join rhpeslocaltrab on rh56_seqpes     = rh02_seqpes
		left  join rhlocaltrab    on rh55_codigo     = rh56_localtrab
		                         and rh56_princ      = 't'
		left  join rhtipoapos     on rh88_sequencial = rh02_rhtipoapos
 		inner join cgm            on z01_numcgm      = rh01_numcgm
   	left join rhfuncao        on rh37_funcao     = rh01_funcao
                             and rh37_instit     = rh02_instit
	  left join rhlota          on r70_codigo      = rh02_lota
                             and r70_instit      = rh02_instit
		left join rhpescargo      on rh20_seqpes     = rh02_seqpes
    left join rhcargo         on rh20_cargo      = rh04_codigo
                             and rh04_instit     = rh02_instit
    left join rhpesbanco      on rh44_seqpes     = rh02_seqpes
    left join rhpespadrao     on rh02_seqpes     = rh03_seqpes
    left  join padroes        on  r02_anousu     = rh02_anousu
                             and  r02_mesusu     = rh02_mesusu
                             and  r02_regime     = rh30_regime
                             and  r02_codigo     = rh03_padrao
                             and  r02_instit     = rh02_instit
    left join rhpesfgts       on rh01_regist     = rh15_regist
    left join rhpesdoc        on rh01_regist     = rh16_regist
    left join rhpesrescisao   on rh02_seqpes     = rh05_seqpes
    left join tpcontra        on h13_codigo      = rh02_tpcont
                             and h13_regime      = rh30_regime
        left join db_config  on rh02_instit = codigo";
        if(!empty($selecao)){
		  $sql .= " left join selecao    on r44_instit = rh02_instit";
        }
		$sql .= " left outer join (select distinct r33_codtab,r33_nome
		                 from inssirf
				             where r33_anousu = $ano
				               and r33_mesusu = $mes
					             and r33_instit = ".db_getsession("DB_instit")."
                    ) as x on r33_codtab = rh02_tbprev+2
        $where
       ";

// 3791
// die($sql);
//echo $sql;exit;
$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if($xxnum == 0 || $xxnum==false){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Códigos cadastrados no período de '.$mes.' / '.$ano);
}
$alt="5";
$pdf = new FPDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',10);
$pdf->ln();
$fonte01="arial";
$tam01="7";
$b01="b";
$fonte02="times";
$tam02="7";
$b02="";

for($index=0; $index<$xxnum; $index ++){
  $conjuge = "";
  $pdf->AddPage();
  db_fieldsmemory($result,$index);
  $pdf->Line(1,1,208,1);
  $pdf->Line(1,280,1,1);
  $pdf->Line(208,280,208,1);
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(58);
  $pdf->cell(0,0,"FICHA DE REGISTRO DOS EMPREGADOS",0,0,"L",0);
  $pdf->cell(-58);
  $pdf->cell(-40,0,"Nº ",0,0,"L",0);
  $pdf->cell(44);
  //$pdf->cell(180,0,$sequenciarelatorio,0,0,"L",0);
  $pdf->Ln(5);
  //MATRICULA
  /*$pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_regist.":",0,0,"R",0);
  $pdf->setfont($fonte02,'',$tam02);
  $pdf->cell(60,$alt,$rh01_regist,0,0,"L",0);*/

  //DA FIRMA
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"Da Firma:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$nomeinst,0,0,"L",0);

  $pdf->ln();

  //ENDEREÇO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(30,$alt,$RLz01_ender.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$ender.' Nº: '.$numero.' BAIRRO: '.$bairro.' CEP: '.$cep.' UF: '.$uf ,0,0,"L",0);

  //CNPJ
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(64,$alt,"CNPJ/CEI:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$cgc,0,0,"L",0);

  //LINHA
  $pdf->Line(1,25,208,25);
  $pdf->Ln();
  $pdf->cell(140,$alt," ",0,0,"L",0);
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"VISTO DA FISCALIZAÇÃO",0,0,"R",0);
  $pdf->ln(50);

  //Quadro para visto
  $pdf->Rect(85,28,40,40);


  //LINHA
  $pdf->Line(1,70,208,70);
  //CGM
  /*$pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLz01_numcgm.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$z01_numcgm,0,0,"L",0);*/

  //NOME
  $pdf->cell(-20);
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLz01_nome.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$z01_nome,0,0,"L",0);

  //DATA NASCIMENTO
  /*$pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_nasc.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,db_formatar($rh01_nasc,'d'),0,0,"L",0);*/

  //PORTADOR DA CTPS (CARTEIRA DE TRABALHO)
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"Portador da C.T.P.S. n.:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(40,$alt,$rh16_ctps_n.'-'.$rh16_ctps_s,0,0,"L",0);

  //REG CONSELHO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(0,$alt,"Reg. Conselho.:",0,0,"L",0);
  $pdf->cell(-15);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(0,$alt,"",0,0,"L",0);

  $pdf->ln();

  //CPF
  $pdf->cell(-18);
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"C.P.F n:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(20, $alt, $z01_cgccpf, 0, 0, "L", 0);

  //Titulo de Eleitor
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"Título de Eleitor n:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(25,$alt,"$rh16_titele/$rh16_zonael/$rh16_secaoe",0,0,"L",0);

  //IDENTIDADE
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(37,$alt,$RLz01_ident.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(5,$alt,$z01_ident,0,0,"L",0);

  //ORGÃO EMISSOR
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"Órgão Emissor:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(1,$alt,$z01_identorgao,0,0,"L",0);

  //Data
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(20,$alt,"Data:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(5,$alt,"",0,0,"L",0);

  $pdf->ln();

  //Data Admissão
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(30,$alt,"foi admitido em:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(25,$alt,implode('/',array_reverse(explode('-',$rh01_admiss))),0,0,"L",0);

  //LOTAÇÃO
  /*$pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_lotac.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$r70_estrut.'-'.substr($r70_descr,0,25),0,0,"L",0);
  $pdf->cell(1,$alt,"  ",0,0,"C",0);
  */
  //REGIME
  /*
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_regime.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$rh30_regime.'-'.$descr_regime,0,0,"L",0);
  */

  //Tab.Prev
  /*
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_tbprev.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"$rh02_tbprev-$r33_nome",0,0,"L",0);
  $pdf->cell(1,$alt,"  ",0,0,"C",0);
  */
  //Tipo de Vinculo
  /*
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_tpvinc.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"$rh30_vinculo-$descr_vinculo",0,0,"L",0);
  */

  //Vínculo
  /*
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_vincul.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"$rh02_vincrais-$descr_vinculorais",0,0,"L",0);
  $pdf->cell(1,$alt,"  ",0,0,"C",0);
  */

  //FUNÇÃO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"para exercer a função de:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(35,$alt,"$rh01_funcao-$rh37_descr",0,0,"L",0);

  //CBO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_cbo.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(5,$alt,$rh37_cbo,0,0,"L",0);

  //PADRÃO
  /*
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_padrao.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$rh03_padrao.'-'.$r02_descr,0,0,"L",0);
  */

  $pdf->ln();

  if (!empty($rh02_salari)) {
	  //SALÁRIO
	  $pdf->setfont($fonte01,$b01,$tam01);
	  $pdf->cell(31,$alt,"com o salário de:",0,0,"R",0);
	  $pdf->setfont($fonte02,$b02,$tam02);
	  $pdf->cell(60,$alt,$rh02_salari ." (".extenso($rh02_salari).")",0,0,"L",0);
  }else{
  	  //SALÁRIO
	  $pdf->setfont($fonte01,$b01,$tam01);
	  $pdf->cell(31,$alt,"com o salário de:",0,0,"R",0);
	  $pdf->setfont($fonte02,$b02,$tam02);
	  $pdf->cell(60,$alt,$rh02_salari ." (".extenso($r02_valor).")",0,0,"L",0);
  }
  $pdf->ln();

  //TIPO SALÁRIO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(12,$alt,"Por:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  if($rh02_tipsal == 'M'){
    $pdf->cell(60,$alt,"Mês",0,0,"L",0);
  }

  //HORÁRIO DE TRABALHO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(12,$alt,"no seguinte horário de trabalho:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt," ",0,0,"L",0);

  $pdf->ln(10);

  /*$pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_hrssem.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(2,$alt,$rh02_hrssem,0,0,"L",0);
  $pdf->cell(1,$alt,"  ",0,0,"C",0);
  $pdf->setfont($fonte01,$b01,$tam02);
  $pdf->cell(35,$alt,$RLr01_hrsmen.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$rh02_hrsmen,0,0,"L",0);
  */

  //LINHA
  $pdf->Line(1,100,208,100);
  $pdf->cell(40);
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(0,0,"SITUAÇÃO PERANTE O FUNDO DE GARANTIA DO TEMPO DE SERVIÇO",0,0,"L",0);

  $pdf->ln(4);

  //OPÇÃO FGTS
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(31,$alt,"É optante?",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(20,$alt,(!empty($rh15_data)?"sim":"não"),0,0,"L",0);

  //DATA DA OPÇÃO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(31,$alt,"Data da opção:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(20,$alt,$rh15_data,0,0,"L",0);

  //DATA DA RETRATAÇÃO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(31,$alt,"Data da retratação:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(10,$alt," ",0,0,"L",0);

  //BANCO DEPOSITÁRIO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"Banco depositário:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  //$pdf->cell(60,$alt,(!empty($rh15_data)?trim($rh44_codban)."/".trim($rh44_agencia)."-".trim($rh44_dvagencia):" "),0,0,"L",0);

  $pdf->Line(1,117,208,117);

  $pdf->ln(10);

  $pdf->Line(72,117,72,194);

  $pdf->Line(140,117,140,194);

  ########################################################################$######################################
  $sql = "
	  select *,
		   case rh02_folha
			when 'M' then 'Mensal'
			when 'Q' then 'Quinzenal'
			when 'S' then 'Semanal'
		   end as descr_folha,
		   case rh02_tipsal
			when 'M' then 'Mensal'
			when 'Q' then 'Quinzenal'
			when 'S' then 'Semanal'
			when 'D' then 'Diário'
			when 'H' then 'Horista'
			when 'E' then 'Extra'
		   end as descr_tipsal,
		   case rh01_instru
			when 1 then 'Analfabeto'
			when 2 then 'Até 4a. Série Incompleta'
			when 3 then '4a. Série Completa'
			when 4 then 'Até 8a. Série Incompleta'
			when 5 then 'Primeiro Grau Completo'
			when 6 then 'Segundo Grau Incompleto'
			when 7 then 'Segundo Grau Completo'
			when 8 then 'Superior Incompleto'
			when 9 then 'Superior Completo'
			when 10 then 'Mestrado Completo'
			when 11 then 'Doutorado Completo'
		   end as descr_instru,
		   case rh01_estciv
			when 1 then 'Solteiro'
			when 2 then 'Casado'
			when 3 then 'Viúvo'
			when 4 then 'Separado Consensual'
			when 5 then 'Divorciado'
			when 6 then 'Outros'
		   end as descr_estciv,
		   case rh01_sexo
			when 'M' then 'Masculino'
			else 'Feminino'
		   end as descr_sexo,
		   case rh01_nacion
			when 10 then 'Brasileiro'
			when 20 then 'Naturalizado'
			when 21 then 'Argentino'
			else 'Outros'
		   end as descr_nacion

	  from rhpessoal
      inner join rhpessoalmov   on rh02_anousu = $ano
                               and rh02_mesusu = $mes
                               and rh02_regist = rh01_regist
                               and rh02_instit = ".db_getsession("DB_instit")."
		  inner join cgm            on z01_numcgm  = rh01_numcgm
		  inner join rhfuncao       on rh37_funcao = rh01_funcao
		  inner join rhlota         on r70_codigo  = rh02_lota
                               and r70_instit  = rh02_instit
	    left  join rhpeslocaltrab on rh56_seqpes = rh02_seqpes
		  left  join rhlocaltrab    on rh55_codigo = rh56_localtrab
		                           and rh56_princ  = 't'
		  left join rhpescargo      on rh20_seqpes = rh02_seqpes
      left join rhcargo         on rh20_cargo  = rh04_codigo
                               and rh04_instit = rh02_instit
    left join rhpespadrao       on rh02_seqpes = rh03_seqpes
    left join rhpesrescisao     on rh02_seqpes = rh05_seqpes
    left join rhpesfgts         on rh01_regist = rh15_regist
    left join rhpesdoc          on rh01_regist = rh16_regist
		  where rh02_regist = $regist ;
	   ";
//echo $sql;exit;
    $result1 = pg_exec($sql);
    db_fieldsmemory($result1,0);

  //NACIONALIDADE
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(25,$alt,$RLr01_nacion.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(56,$alt,@$descr_nacion,0,0,"L",0);

  //QUANDO ESTRANGEIRO
  $pdf->setfont($fonte01,$b01,"7");
  $pdf->cell(35,$alt,"Quando estrangeiro",0,0,"R",0);

  $pdf->setfont($fonte01,$b01,"7");
  $pdf->cell(81,$alt,"PROGRAMA DE INTEGRAÇÃO SOCIAL (PIS)",0,0,"R",0);

  $pdf->ln();

  //FILHO DE E DE
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(6,$alt,"filho de:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(51,$alt,$z01_pai,0,0,"L",0);



  $pdf->ln();

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(11,$alt,"e de:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60, $alt, $z01_mae, 0, 0, "L", 0);

   //Carteira modelo 19 n.º
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"Carteira modelo 19 n.º :",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(29,$alt,"",0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"Cadastrando em",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"",0,0,"L",0);

  $pdf->ln();

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(21,$alt,"Nascido em:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$rh01_natura,0,0,"L",0);

  $pdf->cell(35);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"sob n.º",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$rh16_pis,0,0,"L",0);

  $pdf->ln();

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(6,$alt,"a:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,implode('/',array_reverse(explode('-',$rh01_nasc))),0,0,"L",0);

  //n.º Registro Geral
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(26,$alt,"n.º Registro Geral:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(35,$alt,"",0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"dep. no Banco ",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"",0,0,"L",0);

  $pdf->ln();

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(22,$alt,$RLr01_estciv.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"$rh01_estciv-".@$descr_estciv,0,0,"L",0);

  $pdf->ln();

  ########################################################################################################################
    $sql = "
	  select rh31_nome,
		  rh31_dtnasc,
		  rh31_gparen,
		  case rh31_gparen
			  when 'C' then 'Cônjuge'
			  when 'F' then 'Filho(a)'
			  when 'P' then 'Pai'
			  when 'M' then 'Mãe'
			  when 'A' then 'Avô(ó)'
			  when 'O' then 'Outros'
		  end as rh31_gparen,
		  case rh31_depend
			  when 'C' then 'Cálculo'
			  when 'S' then 'Sempre'
			  when 'N' then 'Não'
		  end as rh31_depend,
		  case rh31_irf
			  when '0' then 'Não Dependente'
			  when '1' then 'Cônjuge/Companheiro(a)'
                          when '2' then 'Filho(a)/Enteado(a), ate 21 anos de idade'
			  when '3' then 'Filho(a) ou enteado(a),  24 anos de idade cursando ensino superior'
			  when '4' then 'Irmao(a), neto(a) ou bisneto(a),  ate 21 anos'
			  when '5' then 'Irmao(a), neto(a) ou bisneto(a), de 21 a 24 anos c/ensino superior'
			  when '6' then 'Pais, avos e bisavos'
			  when '7' then 'Menor pobre ate 21 anos, com a guarda judicial'
                          when '8' then 'Pessoa absolutamente incapaz'
		  end as rh31_irf
	  from rhdepend
	  where rh31_regist=$regist
    ";
    //echo $sql;exit;
  	$pdf->setfont($fonte01,$b01,$tam01);
	$pdf->cell(33,$alt,"Nome do Cônjugue:",0,0,"R",0);
	$result3 = pg_exec($sql);
	$pdf->ln();
	$z = 0;
    for ($i = 0;$i < pg_numrows($result3);$i++){
      db_fieldsmemory($result3,$i);
    	if ($rh31_gparen == "C" && !empty($rh31_nome)) {
	  		$z = 1;
	  		$pdf->setfont($fonte02,$b02,$tam02);
	  		$pdf->cell(60,$alt,$rh31_nome,0,0,"L",0);
    	}
    }

  //Casado(a) c/ bras.?
  $pdf->setfont($fonte01,$b01,$tam01);
  if($z == 1){
    $pdf->cell(32,$alt,"Casado(a) c/ bras?",0,0,"R",0);
  }else{
  	$pdf->cell(92,$alt,"Casado(a) c/ bras?",0,0,"R",0);
  }
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(27,$alt,"",0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"Endereço",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"",0,0,"L",0);

  $pdf->ln();
  //GRAU DE INSTRUÇÃO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(22,$alt,"Grau de Instrução:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(39,$alt,$descr_instru,0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(33,$alt,"Nome do Cônjugue:",0,0,"R",0);

  $pdf->ln();
  //RESIDÊNCIA
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(12,$alt,"Residência:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(45,$alt,$z01_ender,0,0,"L",0);

  //nome conjugue
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$conjuge,0,0,"L",0);

  $pdf->ln();

  //numero
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(1,$alt,"Nº:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(8,$alt,$z01_numero,0,0,"L",0);

   //CEP
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(8,$alt,"Cep:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(18,$alt,$z01_cep,0,0,"L",0);

  $pdf->ln();

  //bairro
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(5,$alt,"Bairro:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(17,$alt,$z01_bairro,0,0,"L",0);

  $pdf->ln();

  //CIDADE
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(6,$alt,"Cidade:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(16,$alt,$rh01_natura,0,0,"L",0);

  //UF
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(18,$alt,"UF:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(16,$alt,$z01_uf,0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(43,$alt,"Tem filhos brasileiros?",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"",0,0,"L",0);

  $pdf->ln();

  $pdf->cell(45);
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"Quantos?",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(48,$alt,"",0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"Codigo Banco:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"",0,0,"L",0);

  $pdf->ln();
  //Habilitação
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(32,$alt,"Cart. Nac. Habilitação n.º:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt," ",0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(15,$alt,"Data de chegada ao Brasil?",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(24,$alt,"",0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(29,$alt,"Codigo Agência:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"",0,0,"L",0);

  $pdf->ln();
  //Habilitação
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(22,$alt,"Cert. Militar n.º:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(40,$alt," ",0,0,"L",0);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(22,$alt,"Naturalizado",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,"",0,0,"L",0);

  $pdf->ln();

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $pdf->Line(1,199,208,199);

  $pdf->ln(3);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(22,$alt,"Beneficiários:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(40,$alt," ",0,0,"L",0);

  $pdf->Line(10,207,194,207);
  $pdf->Line(10,212,194,212);
  $pdf->Line(10,217,194,217);
  $pdf->Line(10,222,194,222);

  //linha penultima
  $pdf->Line(1,230,208,230);

  $pdf->ln(35);

  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(22,$alt,"Data Registro:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(40,$alt,implode('/',array_reverse(explode('-',$rh01_admiss))),0,0,"L",0);

  $pdf->Line(20,265,100,265);
  $pdf->ln(31);
  $pdf->cell(67,$alt,"Assinatura do Empregado",0,0,"R",0);

  //linha final
  $pdf->Line(1,280,208,280);

  $pdf->ln();

  $pdf->AddPage();

  $pdf->cell(58);
  $pdf->cell(0,0,"FICHA DE REGISTRO DOS EMPREGADOS",0,0,"L",0);
  $pdf->cell(-58);
  $pdf->cell(-40,0,"Nº ",0,0,"L",0);
  $pdf->cell(44);
  $pdf->cell(180,0,$sequenciarelatorio,0,0,"L",0);
  $pdf->Ln(5);
  //MATRICULA
  /*$pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,$RLr01_regist.":",0,0,"R",0);
  $pdf->setfont($fonte02,'',$tam02);
  $pdf->cell(60,$alt,$rh01_regist,0,0,"L",0);*/

  //DA FIRMA
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(35,$alt,"Da Firma:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$nomeinst,0,0,"L",0);

  $pdf->ln();

  //ENDEREÇO
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(30,$alt,$RLz01_ender.":",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$ender.' Nº: '.$numero.' CEP: '.$cep.' BAIRRO: '.$bairro.' UF: '.$uf ,0,0,"L",0);

  //CNPJ
  $pdf->setfont($fonte01,$b01,$tam01);
  $pdf->cell(64,$alt,"CNPJ/CEI:",0,0,"R",0);
  $pdf->setfont($fonte02,$b02,$tam02);
  $pdf->cell(60,$alt,$cgc,0,0,"L",0);

  $pdf->Image("imagens/RelatorioPagina2.png", 0, 24, 220);

  $pdf->Line(10,220,194,220);
  $pdf->Line(10,225,194,225);
  $pdf->Line(10,230,194,230);
  $pdf->Line(10,235,194,235);

  $pdf->Line(34,257,180,257);

}

$pdf->Output();
?>


