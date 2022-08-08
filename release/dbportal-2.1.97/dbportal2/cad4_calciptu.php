<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_iptubase_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_iptunump_classe.php");

(int)$parcelaini = 0;
(int)$parcelas   = 0;
(int)$mesini     = 0;
(float)$percentualdesconto = 0;
$diavenc         = '';

db_postmemory($HTTP_POST_VARS);
$cliptubase = new cl_iptubase;
$cliptubase->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('z01_nome');
$clrotulo->label('z01_numcgm');
$clrotulo->label('k00_histtxt');
if(isset($calcular)){

  if(isset($HTTP_POST_VARS['j01_matric'])){

    $sqlnextval = "select nextval('iptucalclog_j27_codigo_seq') as j27_codigo";
    $resultnextval = pg_exec($sqlnextval) or die($sqlnextval);
    if ($resultnextval == false) {
      echo "<script>alert('Erro ao gerar sequencia!');</script>";
    } else {
      db_fieldsmemory($resultnextval,0);

      $insert = "insert into iptucalclog values ($j27_codigo,$anousu,'".date('Y-m-d',db_getsession("DB_datausu"))."','".db_hora()."',".db_getsession('DB_id_usuario').",true,1)";
      $resultinsert = pg_exec($insert) or die($insert);
      if ($resultinsert == false) {
        echo "<script>alert('Erro do gerar lancamento na tabela iptucalclog!');</script>";
      } else {
				$result=pg_query("select distinct j18_anousu, j18_permvenc from cfiptu order by j18_anousu desc");
				$j18_permvenc = 1;
				if(pg_numrows($result) > 0){
					db_fieldsmemory($result,0);
				}
				if ($j18_permvenc == 0) {
					$j18_permvenc = 1;
				}

				if ($j18_permvenc == 1) {
          // esta variavel e uma string no formato de um array plpgsql, nao altere seu conteudo se voce nao tem certeza do que esta fazendo
          $arraypl = "array['".(int)$parcelas."','".(int)$diavenc."','".(int)$mesini."']";
				} elseif ($j18_permvenc == 2) {
          // esta variavel e uma string no formato de um array plpgsql, nao altere seu conteudo se voce nao tem certeza do que esta fazendo
          $arraypl = "array['".(int)$parcelaini."','".(int)$parcelafinal."']";
				}

     		$sql = "select fc_calculoiptu($j01_matric,$anousu,true,false,false,false,false,".$arraypl.")";

				$result = db_query($sql) or die($sql);
				if(($result!=false) && (pg_numrows($result) != 0)){
					$retorno_result = pg_result($result,0,0);
					$retorno = substr($retorno_result,0,2);
					if($retorno!='01'){
						$cliptubase->erro_msg = "Erro: ".$retorno_result;
						$cliptubase->erro_status = '0';
					}else{
						$cliptubase->erro_msg = "Cálculo Efetuado.";
						$cliptubase->erro_status = '0';
					}
					$insert = "insert into iptucalclogmat values ($j27_codigo,$j01_matric,$retorno,'".trim(substr($retorno_result,2))."')";
					$resultinsert = pg_exec($insert) or die($insert);
				}else{
					$cliptubase->erro_msg = pg_last_error();
					$cliptubase->erro_status = '0';
				}

				if ((int) $percentualdesconto > 0) {

					$cliptunump = new cl_iptunump;
					$result = $cliptunump->sql_record($cliptunump->sql_query_file($anousu,$j01_matric,'j20_matric#j20_numpre'));
					if(!($result==false || $cliptunump->numrows == 0 )){
						$sqlunica = pg_query("BEGIN");
						for($i=0;$i<$cliptunump->numrows;$i++){
							db_fieldsmemory($result,$i);
							$sqlunica = pg_query("select k00_dtvenc,k00_percdes
							from recibounica
							where k00_numpre = $j20_numpre and k00_dtvenc = '$anousu-$mesini-$diavenc'");
							$erro = true;
							$perc = 0;
							if(pg_numrows($sqlunica)!=0){
								$perc = pg_result($sqlunica,0,'k00_percdes');
								$sqlresultunica = "delete from recibounica where k00_numpre = $j20_numpre and k00_dtvenc = '$anousu-$mesini-$diavenc'";
								$resultunica = pg_query($sqlresultunica );
								$descricao_erro = "Vencimento Excluído.";
							}
							if(($perc!=$percentualdesconto) || (pg_numrows($sqlunica)==0)){
								$sqlresultunica = "insert into recibounica values($j20_numpre,'$anousu-$mesini-$diavenc','" . date("Y-m-d",db_getsession("DB_datausu")) . "',$percentualdesconto)";
								$resultunica = pg_query($sqlresultunica );
								if($resultunica==false){
									$descricao_erro = "Erro ao incluir no arquivo recibounica";
								}else{
									$descricao_erro = "Vencimento Incluído.";
								}
							}

							$histd  = "Data: ".date("Y-m-d",db_getsession("DB_datausu"));
							$histd .= " Perc: ".$percentualdesconto." Usuário: ".db_getsession("DB_login");
							$histd .= $k00_histtxt;

							$sqlresultunica = "insert into arrehist(k00_numpre,
							k00_numpar,
							k00_hist,
							k00_dtoper,
							k00_hora,
							k00_id_usuario,
							k00_histtxt,
							k00_idhist)
							values ($j20_numpre,
							0,
							890,
							'".date("Y-m-d",db_getsession("DB_datausu"))."',
							'".date("G:i")."',
							".db_getsession("DB_id_usuario").",
							'$histd',
							nextval('arrehist_k00_idhist_seq'))";
							$resultunica = pg_query($sqlresultunica );
							if($resultunica==false){
								$descricao_erro = "Erro ao incluir no arquivo historicos";
							}
						}
						$sqlunica = pg_query("COMMIT");
					}

				}

			}

	  }

  }else{
    $cliptubase->erro_msg = 'Matricula não informada.';
    $cliptubase->erro_status = '0';
  }
}

if(isset($demonstrativo)){

  if(isset($HTTP_POST_VARS['j01_matric'])){

    $result=pg_query("select distinct j18_anousu, j18_permvenc from cfiptu order by j18_anousu desc");
    if(pg_numrows($result) > 0){
      db_fieldsmemory($result,0);
    } else {
      $j18_permvenc = 0;
    }

		if ($j18_permvenc == 1) {
      // esta variavel e uma string no formato de um array plpgsql, nao altere seu conteudo se voce nao tem certeza do que esta fazendo
      $arraypl = "array['".(int)$parcelas."','".(int)$diavenc."','".(int)$mesini."']";
		} elseif ($j18_permvenc == 2) {
      // esta variavel e uma string no formato de um array plpgsql, nao altere seu conteudo se voce nao tem certeza do que esta fazendo
      $arraypl = "array['".(int)$parcelaini."','".(int)$parcelafinal."']";
		}else{
      $arraypl = "array['".(int)$parcelas."','".(int)$diavenc."','".(int)$mesini."']";
    }

    $sql = "select fc_calculoiptu($j01_matric,$anousu,true,false,false,false,true,".$arraypl.")";

  	$result = pg_query($sql) or die($sql);

    if (($result!=false) && (pg_numrows($result) != 0)){
      $retorno_result = @pg_result($result,0,0);
      $retorno = substr($retorno_result,0,2);
      if($retorno!='01' and $retorno!=' '){
        $cliptubase->erro_msg = "Erro: ".$retorno_result;
        $cliptubase->erro_status = '0';
      }else{
        $cliptubase->erro_msg = "Demonstrativo efetuado!";
        $cliptubase->erro_status = '0';
      }
    }else{
      $cliptubase->erro_msg = pg_last_error();
      $cliptubase->erro_status = '0';
    }
  }else{
    $cliptubase->erro_msg = 'Matricula não informada.';
    $cliptubase->erro_status = '0';
  }
}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>
function js_verificacalculo(){
  if(document.form1.j01_matric.value == ""){
    alert('Informe uma Matrícula.');
    return false;
  }
  return true;
}

</script>
<style>
textarea {
  font-family:Courier, Arial, Helvetica, sans-serif;
  font-size: 11px;
  color: #000000;
  background-color: #FFFFFF;
  border: 1px ;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.form1.j01_matric.focus();" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
<tr>
<td width="360" height="18">&nbsp;</td>
<td width="263">&nbsp;</td>
<td width="25">&nbsp;</td>
<td width="140">&nbsp;</td>
</tr>
</table>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="100%" align="center" valign="top" bgcolor="#CCCCCC">
<form name="form1" action="" method="post" onSubmit="return js_verificacalculo();">
<table width="387" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="27" height="25" title="<?=$Tz01_nunmcgm?>">
<?
db_ancora('<strong>Matricula:</strong>','js_mostranomes(true);',4)
?>
</td>
<td width="360" height="25">
<?
db_input("j01_matric",8,$Ij01_matric,true,'text',4," onchange='js_mostranomes(false);' ")
?>
</td>
</tr>
<tr>
<td height="25">
<?
db_ancora('<strong>Nome:</strong>','js_mostranomes(true);',4)
?>
</td>
<td height="25">
<?
db_input("z01_nome",40,$Iz01_nome,true,'text',3)
?>
</td>
</tr>
<tr>
<td height="25">
<strong>Ano:</strong>
</td>
<td height="25">
<?
$result=pg_query("select distinct j18_anousu from cfiptu order by j18_anousu desc");
if(pg_numrows($result) > 0){
  ?>
  <select name="anousu">
  <?
  for($i=0;$i<pg_numrows($result);$i++){
    db_fieldsmemory($result,$i);
    ?>
    <option value='<?=$j18_anousu?>'><?=$j18_anousu?></option>
    <?
  }
  ?>
  </select>
  <?
} else {
  $j18_permvenc = 0;
}
?>
</td>
</tr>

<?

$rsPar = pg_query("select j18_permvenc from cfiptu where j18_anousu = ".db_getsession('DB_anousu')." ");
if(pg_num_rows($rsPar) > 0){
  db_fieldsmemory($rsPar,0);
}

if ($j18_permvenc == 1) {
  ?>

  <tr>
  <td width="27" height="25">
  <b>Dia para vencimento:</b>
  </td>
  <td width="360" height="25">
  <?
  db_input("diavenc",8,"",true,'text',4,"")
  ?>
  </td>
  </tr>


  <tr>
  <td width="27" height="25">
  <b>Parcelas:</b>
  </td>
  <td width="360" height="25">
  <?
  db_input("parcelas",8,"",true,'text',4,"")
  ?>
  </td>
  </tr>


  <tr>
  <td width="27" height="25">
  <b>Mes inicial:</b>
  </td>
  <td width="360" height="25">
  <?
  db_input("mesini",8,"",true,'text',4,"")
  ?>
  </td>
  </tr>


  <tr>
  <td width="27" height="25">
  <b>Percentual desconto da parcela unica:</b>
  </td>
  <td width="360" height="25">
  <?
  db_input("percentualdesconto",8,"",true,'text',4,"")
  ?>
  </td>
  </tr>


  <tr>
  <td height="25"><b>Hist&oacute;rico:</b></td>
  <td height="25">
  <?
  $k00_histtxt = trim(@$k00_histtxt);
  db_textarea('k00_histtxt',5,30,$Ik00_histtxt,true,'text',4);
  ?>
  </td>
  </tr>


  <?
} elseif ($j18_permvenc == 2) {
  ?>





  <tr>
  <td width="27" height="25">
  <b>Parcela inicial:</b>
  </td>
  <td width="360" height="25">
  <?
  db_input("parcelaini",8,"",true,'text',4,"")
  ?>
  </td>
  </tr>


  <tr>
  <td width="27" height="25">
  <b>Parcela final:</b>
  </td>
  <td width="360" height="25">
  <?
  db_input("parcelafinal",8,"",true,'text',4,"")
  ?>
  </td>
  </tr>



  <tr>
  <td width="27" height="25">
  <b>Percentual desconto da parcela unica:</b>
  </td>
  <td width="360" height="25">
  <?
  db_input("percentualdesconto",8,"",true,'text',4,"")
  ?>
  </td>
  </tr>


  <tr>
  <td height="25"><b>Hist&oacute;rico:</b></td>
  <td height="25">
  <?
  $k00_histtxt = trim(@$k00_histtxt);
  db_textarea('k00_histtxt',5,30,$Ik00_histtxt,true,'text',4);
  ?>
  </td>
  </tr>













  <?
}
?>


<tr>
<td height="25">&nbsp;</td>
<td height="25">
<input name="calcular"  type="submit" id="calcular" value="Calcular" onClick="return js_verificaParametros();">
<input name="demonstrativo"  type="submit" id="demonstrativo" value="Demonstrativo">
<?
if(isset($calcular)){
  ?>
  <input name="Limpar"  type="button" id="limpr" value="Limpar" onClick="document.form1.j01_matric.value='';document.form1.z01_nome.value=''">
  <input name="ultimo"  type="button" id="ultimo" value="&Uacute;ltimo C&aacute;lculo" onClick="func_nome.show();  func_nome.focus();">
  <?
}
?>
</td>
</tr>





<tr>
<td colspan=3>
<textarea id="text_demo" name="text_demo" rows=20 cols=95 style="visibility:hidden" disabled><?=$retorno_result?></textarea>
</td>
<tr>
</table>
</form>
</td>
</tr>
<tr>
</table>
</body>
</html>

<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>

function js_verificaParametros(){

  var oMesini   = document.form1.mesini;
  var oParcelas = document.form1.parcelas;
  var oDiaVenc  = document.form1.diavenc;

  if (!oMesini && !oParcelas && !oDiaVenc) {
    return true;
  }

  var iMesIni   = new Number(oMesini.value);
  var iParcelas = new Number(oParcelas.value);
  if ( (iMesIni+iParcelas) > 13 ) {
    alert('Não é permitido vencimento no ano posterior ao do calculo. ')
    return false;
  }

  return true;

}

function js_mostranomes(mostra){
  if(mostra==true){
    func_nome.jan.location.href = 'func_iptubase.php?funcao_js=parent.js_preenche|j01_matric|z01_nome';
    func_nome.mostraMsg();
    func_nome.show();
    func_nome.focus();
  }else{
    func_nome.jan.location.href = 'func_iptubase.php?pesquisa_chave='+document.form1.j01_matric.value+'&funcao_js=parent.js_preenche1';
  }
}
function js_preenche(chave,chave1){
  document.form1.j01_matric.value = chave;
  document.form1.z01_nome.value = chave1;
  func_nome.hide();
}
function js_preenche1(chave,chave1){
  document.form1.z01_nome.value = chave;
  if(chave1==false){
    document.form1.j01_matric.select();
    document.form1.j01_matric.focus();
  }
  func_nome.hide();
}

</script>
<?
$func_nome = new janela('func_nome','');
$func_nome ->posX=1;
$func_nome ->posY=20;
$func_nome ->largura=770;
$func_nome ->altura=430;
$func_nome ->titulo="Pesquisa";
$func_nome ->iniciarVisivel = false;
$func_nome ->mostrar();

$cliptubase->erro(true,false);

if(isset($calcular)){
  ?>
  <script>
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_funcnome','cad3_conscadastro_002_detalhes.php?solicitacao=Calculo&parametro=<?=$HTTP_POST_VARS['j01_matric']?>','Pesquisa',true);
  </script>
  <?
}
else if(isset($demonstrativo)){
  ?>
  <script>
  document.form1.text_demo.style.disabled   = true;
  document.form1.text_demo.style.visibility = "visible";
  </script>
  <?
}
?>

