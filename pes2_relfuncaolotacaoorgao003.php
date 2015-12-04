<?
require_once("libs/db_stdlib.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("fpdf151/pdf.php");
require_once("classes/db_selecao_classe.php");
//Incluir a classe excelwriter
include("libs/excelwriter.inc.php");

//Você pode colocar aqui o nome do arquivo que você deseja salvar.
$excel=new ExcelWriter("relfuncao.xls");

if($excel==false){
  echo $excel->error;
}

$clrotulo = new rotulocampo;
$clrotulo->label('r01_regist');
$clrotulo->label('z01_nome');
$clrotulo->label('r01_funcao');
$clrotulo->label('r37_descr');

$oRequest   = db_utils::postmemory($_REQUEST);
$iInstit    = db_getsession("DB_instit");
$sWhere     = '';
$sFiltro    = '';
$sIntervalo = '';
$iAnoUsu    = $ano;
$iMesUsu    = $mes;

/**
 * $tipo > l - Lotação
 *         o - Secretaria
 *         c - Cargo
 * 
 * $func > lista servidor 't' ou 'f'
 * 
 * $lShowRemuneracao > imprimir remuneração 't' ou 'f'
 * 
 * $lShowEndereco > mostrar endereço 't' ou 'f'
 */

if(isset($colunas) && $colunas != '') {
  $sWhere .= " and rh02_codreg in (".$colunas.") ";
}

if($tipo == 'c'){
  $head3 = "RELATÓRIO DE CARGOS";
  if($ordem == 'a'){

    $sCampos = " rh37_funcao as quebra2, rh37_descr as quebra1 , rh37_vagas, rh37_funcao||' - '|| rh37_descr as imprime ";
    $sOrder  = ' order by rh37_descr,z01_nome';
  }else{

    $sCampos = " rh37_funcao as quebra1, rh37_descr as quebra2 , rh37_vagas , rh37_funcao||' - '|| rh37_descr as imprime ";
    $sOrder  = ' order by rh37_funcao,z01_nome';
  }
 if(isset($cai) && trim($cai) != "" && isset($caf) && trim($caf) != "") {
    // Se for por intervalos e vier lotação inicial e final
    $sWhere     .= " and rh37_funcao between '".$cai."' and '".$caf."' ";
    $sIntervalo .= " DE ".$cai." A ".$caf;
  }else if(isset($cai) && trim($cai) != ""){
    // Se for por intervalos e vier somente lotação inicial
    $sWhere    .= " and rh37_funcao >= '".$cai."' ";
    $sIntervalo.= " SUPERIORES A ".$cai;
  }else if(isset($caf) && trim($caf) != ""){
    // Se for por intervalos e vier somente lotação final
    $sWhere    .= " and rh37_funcao <= '".$caf."' ";
    $sIntervalo.= " INFERIORES A ".$caf;
  }else if(isset($fca) && trim($fca) != ""){
    // Se for por selecionados
    $sWhere  .= " and rh37_funcao in ('".str_replace(",","','",$fca)."') ";
    $sFiltro .= " SELECIONADAS";
  }
} elseif($tipo == 'l') {

  $head3  = "RELATÓRIO DE LOTAÇÕES";
  if($ordem == 'a'){
    
    $sCampos = " r70_estrut as quebra2, r70_descr as quebra1 , r70_estrut||' - '||r70_descr as imprime ";
    $sOrder = ' order by r70_descr,z01_nome';
  }else{

    $sCampos = " r70_estrut as quebra1, r70_descr as quebra2 , r70_estrut||' - '||r70_descr as imprime ";
    $sOrder = ' order by r70_estrut,z01_nome';
  }
  if(isset($lti) && trim($lti) != "" && isset($ltf) && trim($ltf) != ""){
    // Se for por intervalos e vier local inicial e final
    $sWhere    .= " and r70_estrut between '".$lti."' and '".$ltf."' ";
    $sIntervalo.= " DE ".$lti." A ".$ltf;
  }else if(isset($lti) && trim($lti) != ""){
    // Se for por intervalos e vier somente local inicial
    $sWhere    .= " and r70_estrut >= '".$lti."' ";
    $sIntervalo.= " SUPERIORES A ".$lti;
  }else if(isset($ltf) && trim($ltf) != ""){
    // Se for por intervalos e vier somente local final
    $sWhere    .= " and r70_estrut <= '".$ltf."' ";
    $sIntervalo.= " INFERIORES A ".$ltf;
  }else if(isset($flt) && trim($flt) != ""){
    // Se for por selecionados
    $sWhere  .= " and r70_estrut in ('".str_replace(",","','",$flt)."') ";
    $sFiltro .= " SELECIONADOS";
  }

}else{
  $head3 = "RELATÓRIO DE SECRETARIAS";
  if($ordem == 'a'){
    $sCampos = " o40_descr as quebra1, o40_orgao as quebra2 , o40_orgao||' - '||o40_descr as imprime ";
    $sOrder = ' order by o40_descr,z01_nome';
  }else{
    $sCampos = " o40_descr as quebra2, o40_orgao as quebra1, o40_orgao||' - '||o40_descr as imprime ";
    $sOrder = ' order by o40_orgao,z01_nome';
  }
  if(isset($ori) && trim($ori) != "" && isset($orf) && trim($orf) != ""){
    // Se for por intervalos e vier órgão inicial e final
    $sWhere    .= " and o40_orgao between ".$ori." and ".$orf;
    $sIntervalo.= " DE ".$ori." A ".$orf;
  }else if(isset($ori) && trim($ori) != ""){
    // Se for por intervalos e vier somente órgão inicial
    $sWhere .= " and o40_orgao >= ".$ori;
    $head5.= " SUPERIORES A ".$ori;
  }else if(isset($orf) && trim($orf) != ""){
    // Se for por intervalos e vier somente órgão final
    $sWhere    .= " and o40_orgao <= ".$orf;
    $sIntervalo.= " INFERIORES A ".$orf;
  }else if(isset($for) && trim($for) != ""){
    // Se for por selecionados
    $sWhere  .= " and o40_orgao in (".$for.") ";
    $sFiltro .= " SELECIONADOS";
  }
}

/**
 * Busca Seleção
 */
$sWhereSelecao = '';
if( !empty( $oRequest->selecao ) ) {
  $oDaoSelecao   = new cl_selecao();
  $sWhereSelecao = $oDaoSelecao->getCondicaoSelecao($oRequest->selecao);
}

/**
 * Caso seja selecionada selação sera o unico criterio do where
 */
if( !empty( $sWhereSelecao ) ){
  $sWhere = ' and ' . $sWhereSelecao;
}else{
  $head3 .= $sFiltro;
  $head3 .= $sIntervalo;
}

/**
 * Buscamos a query do relatório
 */
$oDaoRhpessoalmov  = new cl_rhpessoalmov();
$sSqlRhpessoalmov  = $oDaoRhpessoalmov->sql_servidorCargoLotacaoSecretarias( $sCampos, $sWhere, $sOrder, $iInstit, $iAnoUsu, $iMesUsu );
$rsDAORhpessoalmov = db_query($sSqlRhpessoalmov);
if ( pg_numrows($rsDAORhpessoalmov) == 0 ){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem funcionários no período de '.$iMesUsu.' / '.$iAnoUsu);
}

$excel->writeCol('Matricula');
$excel->writeCol('Nome');
$excel->writeCol('C.Horaria');
$excel->writeCol('Cargo');
$excel->writeCol('Remuneracao');


for( $iRegistro = 0; $iRegistro < pg_numrows($rsDAORhpessoalmov); $iRegistro++ ){
  
  db_fieldsmemory( $rsDAORhpessoalmov, $iRegistro );
  $excel->writeRow();

  $excel->writeCol($r01_regist);
  $excel->writeCol($z01_nome);
  $excel->writeCol($rh02_hrsmen);
  $excel->writeCol($rh37_descr);
  //remuneração
  $excel->writeCol($r02_valor);

}




header("Location: relfuncao.xls");