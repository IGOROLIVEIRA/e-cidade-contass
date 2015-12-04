<?
session_start();
parse_str(base64_decode($HTTP_SERVER_VARS['QUERY_STRING']));

if(!session_is_registered("DB_instit")) {
  session_destroy();
  echo "<script>location.href='index.php'</script>";
  exit;
}
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
require("dbforms/db_funcoes.php");
if(!session_is_registered("DB_modulo")){
  session_register("DB_modulo");
}

if(!session_is_registered("DB_nome_modulo"))
  session_register("DB_nome_modulo");
if(!session_is_registered("DB_anousu"))
  session_register("DB_anousu");
if(!session_is_registered("DB_datausu")) {
  session_register("DB_datausu");
  db_putsession("DB_datausu",time());
}
//if(session_is_registered("DB_coddepto")) {
//  session_unregister("DB_coddepto");
//}

if(!isset($HTTP_POST_VARS["formAnousu"]) && !isset($retorno)) {
    db_putsession("DB_modulo",$modulo);
    db_putsession("DB_nome_modulo",$nomemod);
    db_putsession("DB_anousu",$anousu);
} else if(isset($HTTP_POST_VARS["formAnousu"]) && $HTTP_POST_VARS["formAnousu"] != ""){
    db_putsession("DB_anousu",$HTTP_POST_VARS["formAnousu"]);
  //============================================================
  //descomentar esta linha para colocar as data em 2005
  //   db_putsession("DB_datausu",mktime(0, 0, 0, 1, 2, 2005)); 

}

$sql = "select * from db_datausuarios where id_usuario = ".db_getsession("DB_id_usuario");

$resusu = pg_exec($sql);
if(pg_numrows($resusu)>0){
  //db_criatabela($resusu);exit;
  if ( date("Y-m-d",db_getsession("DB_datausu")) != pg_result($resusu,0,'data') ){
    if ( db_permissaomenu(db_getsession("DB_anousu"), 1, 3896) == true ) {
  	  db_redireciona("con4_trocadata.php");
    }else{
      $sql = "delete from db_datausuarios where id_usuario = ".db_getsession("DB_id_usuario");
      $resusu = pg_exec($sql);
    }
  }

}

// se o exercicio nao for selecionado no modulo, esta acessando o módulo
if( !isset($HTTP_POST_VARS["formAnousu"])) {

  // se o ano da data do exercicio for diferente  do anousu registrado, o sistema utiliza como padrao o anousu da data
 
  if( db_getsession("DB_anousu") != date("Y",db_getsession("DB_datausu")) ){
    db_putsession("DB_anousu" , date("Y",db_getsession("DB_datausu")) );
  }

}
  $nomemod = db_getsession("DB_nome_modulo");
  pg_exec("update db_usuariosonline set 
           uol_arquivo = '', 
		   uol_modulo = '".$nomemod."',
		   uol_inativo = ".time()."
           where uol_id = ".db_getsession("DB_id_usuario")."
		   and uol_ip = '".(isset($_SERVER["HTTP_X_FORWARDED_FOR"])?$_SERVER["HTTP_X_FORWARDED_FOR"]:$HTTP_SERVER_VARS['REMOTE_ADDR'])."' 
		   and uol_hora = ".db_getsession("DB_uol_hora")) or die("Erro(26) atualizando db_usuariosonline");

$result = pg_exec("select id_item from db_usumod 
         where id_usuario = ".db_getsession("DB_id_usuario")." and id_item = ".db_getsession("DB_modulo"));
if(pg_numrows($result) == 0) {
  pg_exec("insert into db_usumod values(".db_getsession("DB_modulo").",".db_getsession("DB_anousu").",".db_getsession("DB_id_usuario").")") or die("Erro(40) inserindo em db_usumod: ".pg_errormessage());
} else {
  pg_exec("update db_usumod set id_item = ".db_getsession("DB_modulo").",
                                anousu = ".db_getsession("DB_anousu")."
		where id_usuario = ".db_getsession("DB_id_usuario")." and id_item = ".db_getsession("DB_modulo"));
}
?>
<html><!-- InstanceBegin template="/Templates/corpo.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" --> 
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<!-- InstanceEndEditable --> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>
function js_mostramodulo(chave1,chave2){
  location.href="modulos.php?coddepto="+chave1+"&retorno=true&nomedepto="+chave2;
}
</script>
<!-- InstanceBeginEditable name="head" -->
<link href="estilos.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
 <!-- InstanceParam name="leftmargin" type="text" value="0" --> 
<!-- InstanceParam name="onload" type="text" value="a=1" -->
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<form name="form1" method="post">

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td valign="top" ><!-- InstanceBeginEditable name="corpo" -->
	<!--AAAAAAAAAAAAAAAAAAAAAAAaaa-->
	<?
	if (db_getsession("DB_id_usuario") == 1) {
	  $sql = 	"select id_usuario,anousu 
			     from db_permissao 
					     where id_usuario = ".db_getsession("DB_id_usuario")." 
					     group by id_usuario,anousu";
	} else {
	  $sql = 	" select distinct on (anousu) anousu,id_usuario from 
	                     (select id_usuario,anousu 
			     from db_permissao 
					     where id_usuario = ".db_getsession("DB_id_usuario")." 
					     group by id_usuario,anousu"
			     . " union all 
			     select db_permissao.id_usuario,anousu 
			     from db_permissao 
				     inner join db_permherda h on h.id_perfil = db_permissao.id_usuario
				     inner join db_usuarios u on u.id_usuario = h.id_perfil and u.usuarioativo = '1'
			     where h.id_usuario = ".db_getsession("DB_id_usuario")." 
			       group by db_permissao.id_usuario,anousu 
			     ) as x  
		             order by anousu desc";
	}
	$result = pg_exec($sql);
	if(pg_numrows($result) == 0) {
	  echo "Voce não tem permissão de acesso para exercício ".db_getsession("DB_anousu").". <br>
	  Contate o administrador para maiores informações ou selecione outro exercicio.\n";
	}
        
//	$result = pg_exec("select id_usuario,anousu from db_permissao where id_usuario = ".db_getsession("DB_id_usuario")." group by id_usuario,anousu order by anousu desc"); 	
	
	  $u = pg_exec("select nome_modulo,descr_modulo from db_modulos where id_item = ".db_getsession("DB_modulo"));
	  $mod = pg_result($u,0,0);
	  $des = pg_result($u,0,1);
	  $u = pg_exec("select login,nome from db_usuarios where id_usuario = ".db_getsession("DB_id_usuario"));
	  $log = pg_result($u,0,0);
	  $nom = pg_result($u,0,1);
	?>
	<br><br>
          <table border="0" cellspacing="0" cellpadding="10">
            <tr> 
              <td>Módulo:</td>
              <td nowrap> 
                <?=$mod?>
                &nbsp;&nbsp;<font style="font-size:10px">( 
                <?=$des?>
                )</font></td>
            </tr>
            <tr> 
              <td>Usuário:</td>
              <td nowrap> 
                <?=$log?>
                &nbsp;&nbsp;<font style="font-size:10px">( 
                <?=$nom?>
                )</font></td>
            </tr>
            <tr> 
              <td>Exercício:</td>
              <td> 
                <?
		if(db_getsession("DB_anousu")!= date("Y",db_getsession("DB_datausu"))){
		   echo "<font size='5'>".db_getsession("DB_anousu")."</font>";
		}else{
		   echo db_getsession("DB_anousu");
		}
		?>
              </td>
            </tr>
	    
              <tr> 
              <td>Alternar exercício:</td>
              <td> 
	        <select name="formAnousu" size="1" onChange="document.form1.submit()">
                <option value="">&nbsp;</option>
                <?
                  for($i = 0;$i < pg_numrows($result);$i++) {
	             echo "<option value=\"".pg_result($result,$i,"anousu")."\">".pg_result($result,$i,"anousu")."</option>\n";
	          }
	        ?>
                </select> 
	      </td>
         </tr>    
    </table>
    <table border="0" cellspacing="0" cellpadding="10">
	<tr>
	<Td >
	<?
        //if(!isset($retorno)){
	       $mostra_menu = false;
	  	  // sql abaixo desativado 	  	  
          $sql = "select distinct d.coddepto,d.descrdepto 
	                     from db_depusu u 
                                  inner join db_depart d on u.coddepto = d.coddepto
                                  inner join db_departorg o on u.coddepto = o.db01_


				                  inner join orcdotacao on o.db01_anousu = o58_anousu and
				                           o.db01_orgao  = o58_orgao  and
							   o.db01_unidade = o58_unidade
			     where u.id_usuario = ".db_getsession("DB_id_usuario") . " and 
                           o.db01_anousu = ".db_getsession("DB_anousu")." and 
                           o58_instit = ".db_getsession("DB_instit")." order by d.descrdepto";
                           
          $sql = "select distinct d.coddepto,d.descrdepto
                  from db_depusu u
                        inner join db_depart d on u.coddepto = d.coddepto
                        left join db_departorg o on u.coddepto = o.db01_coddepto
                        left join orcdotacao on o58_anousu  = ".db_getsession("DB_anousu")." and
				                                o.db01_orgao   = o58_orgao  and
                                                o.db01_unidade = o58_unidade
                 where u.id_usuario = ".db_getsession("DB_id_usuario") . "  and
                       o58_instit = ".db_getsession("DB_instit")."
		       and o58_anousu = ".db_getsession("DB_anousu")."
                 order by d.descrdepto ";                           
 
           /* se o usuario tiver departamento, aparecem os departamentos
	      se não tiver, aparecem todos e monta os menus que tiver permissao*/ 
           $sql = "select distinct d.coddepto,d.descrdepto
                  from db_depusu u
                        inner join db_depart d on u.coddepto = d.coddepto
                 where instit = ".db_getsession("DB_instit")." and u.id_usuario = ".db_getsession("DB_id_usuario") . "  		 
                 order by d.descrdepto ";                           
                           
          $result = pg_exec($sql);
	  if(pg_numrows($result) == 0){
	    echo "<hr>";
	    echo "Usuário sem Departamento para Acesso Cadastrado.";
	  }else{
            if(isset($coddepto)){
              db_putsession("DB_coddepto",$coddepto); 
     	      $result = pg_query("select descrdepto from ($sql) as x where coddepto = $coddepto");
     	      $nomedepto = pg_result($result,0,0);
              db_putsession("DB_nomedepto",$nomedepto); 

            }else if(session_is_registered("DB_coddepto")){
              global $coddepto;
              $coddepto = db_getsession("DB_coddepto");             	
            }
            echo "Departamento:&nbsp;&nbsp;</td><td>";
     	    $mostra_menu = true;
     	    $result = pg_query($sql);
     	    db_selectrecord('coddepto',$result,true,2,'','','','','js_mostramodulo(document.form1.coddepto.value,document.form1.coddeptodescr.options.text)');

            if(!session_is_registered("DB_coddepto")){
              db_putsession("DB_coddepto",pg_result($result,0,0)); 
              db_putsession("DB_nomedepto",pg_result($result,0,1)); 
            }
	  }
      if(db_getsession("DB_modulo")==1){
	    $mostra_menu = true;
      }
      ?>
	</Td>
	</tr>
	</table>
	<?
	if($mostra_menu == true){
          //db_logsmanual('Acesso Módulo',db_getsession('DB_modulo'),db_getsession('DB_modulo'),0,0);
	}
	?>
	<!--BBBBBBBBBBBBBBBBBBBBBBBBBBB-->
	<!-- InstanceEndEditable -->
    </td>
    <td width="390"valign="top">
       <?
       if($mostra_menu==true){
         ?>
         <table>
         <tr bgcolor="#CCCC00">
         <td align="center"> Últimos acessos ao Módulo
         </td>
         </tr>
       <? 
	 $sql = "select * from (
	 		select 	distinct on (descricao) descricao,
				data,
				hora,
				id_item,
				help,
				funcao from (
		 				select 	d.descricao, 
							x.data,
							x.hora,
							x.id_item,
							help,
							case when m.id_item is null then d.funcao else null end as funcao
		 				from (
							select * from db_logsacessa a
		 				where 	a.id_modulo = ".db_getsession("DB_modulo")." and
		       					a.id_usuario = ".db_getsession("DB_id_usuario")."
		  				order by a.data desc, a.hora desc limit 40 offset 1 
						      ) as x 
		      				      inner join db_itensmenu d on x.id_item = d.id_item
		      				      left outer join db_modulos m on m.id_item = d.id_item
					   ) as x 
				) as x 
				order by data desc ,hora desc";
	 $result = pg_exec($sql);
	 if($result>0){
	   $cor='';
	   for($i=0;$i<pg_numrows($result);$i++){
	     db_fieldsmemory($result,$i,true);
	     if($cor=="#CCCC66")
	       $cor="#CCCC99";
	     else
	       $cor="#CCCC66";
	     ?>  
	     <tr>
	     <td bgcolor="<?=$cor?>">
		<table cellspacing="0" cellpadding="0">
		<tr>
		<td width="70%" title="<?=$help?>">
		<?
		if($funcao==""){
		  echo "<a href=\"\" >$descricao</a>";
		}else{
		  echo "<a href=\"$funcao\" onclick=\"return js_verifica_objeto('DBmenu_$id_item');\">$descricao</a>";
		}
		?>
		</td>
		<td align="center" width="10%">
		<?=$data?> 
		</td>
		<td align="center" width="20%">
		<?=$hora?> 
		</td>
		</tr>
		</table>
	     </td>
	     </tr>
	     <?
	   }
	 }
        echo "</table>";
       }
       ?>
    </td>
  </tr>
</table>
	</form>

	<?
	if(isset($mostra_menu) && $mostra_menu == true){
  	  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
	}
	?>
</body>
<!-- InstanceEnd --></html>
<script>
parent.bstatus.document.getElementById('dtatual').innerHTML = '<?=date("d/m/Y",db_getsession("DB_datausu"))?>' ;   
parent.bstatus.document.getElementById('dtanousu').innerHTML = '<?=(db_getsession("DB_modulo")!=952?db_getsession("DB_anousu"):db_anofolha()."/".db_mesfolha())?>' ;   
<?
if(db_getsession("DB_anousu")!= date("Y",db_getsession("DB_datausu"))){
  echo "alert('Exercício diferente do exercício da data. Verifique!');";
}
?>
</script>

