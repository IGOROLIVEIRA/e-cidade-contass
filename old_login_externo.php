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
	  var sUrl  = '../e-cidade/abrir.php?estenaoserveparanada=1&DB_login='+sLogin+'&DB_senha='+sSenha+sQuery;
	  var jan   = window.open(sUrl,wname,'width=1,height=1');
	  
	}
</script>
<body>	
<?php
$host    = 'localhost:5433';
$banco   = $_POST['cliente'];
$usuario = 'dbportal';
$senha   = '';
    $oPdo = new PDO("pgsql:host=$host;dbname=$banco",$usuario,$senha);
		$oPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$oStatement = $oPdo->query("SELECT login,md5(senha) FROM configuracoes.db_usuarios WHERE login = '{$_POST['login_externo']}' AND usuarioativo = 1");
		$rsResult   = $oStatement->fetchAll();
		//echo "<script language=\"JavaScript\">calcMD5($senha_md5))</script><br>";
		//print_r($rsResult);
		//exit(md5(~$_POST['senha_externo'])."<br>".$rsResult['0']['md5']);
		if(!$rsResult) {
			echo "<script language=\"JavaScript\"> alert('login n�o existe!'); window.location = 'http://intranetcontass.no-ip.org/$banco/'; </script>";
		}else {
			if (md5(~$_POST['senha_externo']) != $rsResult['0']['md5']) {
				echo "<script language=\"JavaScript\"> alert('a senha n�o confere!'); window.location = 'http://intranetcontass.no-ip.org/$banco/'; </script>";
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
					Ol�!
				</div>
				<div style="width:650px; text-align: justify; margin-top:10px;">
					O senhor(a) esta entrando numa �rea restrita. Todas as informa��es aqui digitadas ser�o 
					informadas ao TCE-MG atrav�s do sistema SICOM. Esteja ciente que tudo que for realizado
					com sua Senha e Usu�rio poder� ser rastreado futuramente.
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
