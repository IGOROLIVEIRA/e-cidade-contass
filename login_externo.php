<?php
require("model/configuracao/Encriptacao.model.php");
?>
<html>
<head>
<title>Tela de acesso para DBPortal</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/md5.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<script>
function js_acesso() {

	  //$('testaLogin').innerHTML = '';

	  var sLogin                = $F('login_externo');
	  var sSenha                = calcMD5($F('senha_externo'));
	  var wname                 = 'wname' + Math.floor(Math.random() * 10000);
	  var sQuery                = "";
	  
	  $('senha_externo').value      = "";
	  $('login_externo').value      = "";

	  
	    sQuery += "&servidor=localhost";
	    sQuery += "&base="+$F('baseDados');
	    sQuery += "&user=dbportal";
	    sQuery += "&port=5433";
	    sQuery += "&senha=";

          window.location = '../'+$F('baseDados');
	  var sUrl  = '../e-cidade_2_3_19/abrir.php?estenaoserveparanada=1&DB_login='+sLogin+'&DB_senha='+sSenha+sQuery;
	  var jan   = window.open(sUrl,wname,'width=1,height=1');
	  
	}
</script>
<body>	
<?php
$host    = 'localhost';
$banco   = $_POST['cliente'];
$usuario = 'dbportal';
$senha   = '';
    /*$oPdo = new PDO("pgsql:host=$host;dbname=$banco",$usuario,$senha);
		$oPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$oStatement = $oPdo->query("SELECT login,md5(senha) FROM configuracoes.db_usuarios WHERE login = '{$_POST['login_externo']}' AND usuarioativo = 1");
		$rsResult   = $oStatement->fetchAll();*/

$conexao_postgre = pg_connect("host=localhost port=5433 dbname={$banco} user=dbportal password=") or die("Não foi possí­vel conectar ao Banco de dados.");

$rsResult = pg_query("SELECT login,md5(senha),senha FROM configuracoes.db_usuarios WHERE login = '{$_POST['login_externo']}' AND usuarioativo = 1");
$dados = pg_fetch_array($rsResult);
		//echo "<script language=\"JavaScript\">calcMD5($senha_md5))</script><br>";
		//print_r($rsResult);
		//exit(md5(~$_POST['senha_externo'])."<br>".$rsResult['0']['md5']);
		if(!$rsResult) {
			echo "<script language=\"JavaScript\"> alert('login não existe!'); window.location = 'http://e-cidade.contassconsultoria.com.br/$banco/'; </script>";
		}else {
			//if (md5(~$_POST['senha_externo']) != $dados['md5']) {
                         $DB_senha = md5($_POST['senha_externo']);
                        if( $DB_senha  != MD5( ~$dados['senha'] )&& Encriptacao::hash( $DB_senha ) != $dados['senha'] ) {
				echo "<script language=\"JavaScript\"> alert('a senha não confere!'); window.location = 'http://e-cidade.contassconsultoria.com.br/$banco/'; </script>";
			}
		}
?>
	<div style="text-align: center; width: 650px ; margin: auto; margin-top:150px;">
		<div style="width:650px; height: 61px;">
			<div style="background-image: url(imagens/logo.png); width:182px; height: 61px; float: left;">
			</div>
			<div style="width:460px; height: 61px; font-size: 25px; color: #CD0000;">
				Aviso
			</div>
		</div>
		<div style="width:650px; display: table; clear: both">
			<div>
				<div style="margin-top:20px; text-align: left;" >
					Olá!
				</div>
				<div style="width:650px; text-align: justify; margin-top:10px;">
					O senhor(a) esta entrando numa área restrita. Todas as informações aqui digitadas serão 
					informadas ao TCE-MG através do sistema SICOM. Esteja ciente que tudo que for realizado
					com sua Senha e Usuário poderá ser rastreado futuramente.
				</div>
				<div style="margin-top:10px; text-align: left;">
					Bom Trabalho.
				</div>
			</div>
			<div style="float: left; margin-top:10px; align: center;">
					<input type="hidden" id="login_externo" name="login_externo" value="<?=$_POST['login_externo'] ?>"/>
					<input type="hidden" id="senha_externo" name="senha_externo" value="<?=$_POST['senha_externo'] ?>"/>
					<input type="hidden" id="baseDados" name="baseDados" value="<?=$_POST['cliente'] ?>"/>
					<input type="button" value="Aceito" onclick="js_acesso()" width="500" height="500"/>
			</div>
			<div style="margin-top:10px; align: center;">
					<a href="../<?=$_POST['cliente'] ?>/">
<input type="button" value="Cancelar" width="500" height="500"/>
</a>
			</div>
		</div>
	</div>		
</body>
</html>
