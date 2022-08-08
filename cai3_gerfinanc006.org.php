<?


if(!isset($HTTP_POST_VARS["tipo"])) {

  //============================================================================================================
	require('fpdf151/pdf1.php');
	db_postmemory($HTTP_POST_VARS);
	$historico = $textarea;
	$sql = "select nomeinst,ender,munic,uf,telef,email,url,logo from db_config where codigo = ".@$GLOBALS["DB_instit"];
	$result = pg_query($sql);
	db_fieldsmemory($result,0);
	if($tipo==1){
		// certidao positiva
		$tipocer = "CERTIDÃO POSITIVA DE DÉBITO";
		if(isset($matric)){
			$codtipo = 26;
			$sql = "select * from proprietario where j01_matric = $matric";
			$result = pg_query($sql);
         	db_fieldsmemory($result,0);
         	/////// TEXTOS E ASSINATURAS
         	$instit = db_getsession("DB_instit");
         	$sqltexto = "select * from db_textos
							where id_instit = $instit and (descrtexto like 'positiva%' or descrtexto like 'ass%')";
         	$resulttexto = pg_exec($sqltexto);
         	for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
            	db_fieldsmemory($resulttexto,$xx);
            	$text  = $descrtexto;
            	$$text = db_geratexto($conteudotexto);
         	}
         	////////
         	$texto1  = $positiva_mat1;
         	$texto2  = $positiva_mat2;
         	$texto3  = $positiva_mat3;
         	$texto4  = '';
         	//$texto1  = '                    CERTIFICAMOS a requerimento, que não existe cadastro em nome de '.$z01_nome.', e que nada deve à Fazenda Municipal até a presente data.'."\n".'                    Fica ressalvado o direito do Município de Sapiranga de apurar e cobrar eventuais débitos de responsabilidade do contribuinte supra identificado.'."\n".'                    E para que produza os efeitos a que se destina, emite a presente certidão que é válida por 60 (sessenta) dias a contar da data de sua expedição.';
    	}else if(isset($numcgm)){
       		$codtipo = 27;
       		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'positiva%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto);
       		}
       		////////
       		$texto1  = $positiva_cgm1;
       		$texto2  = $positiva_cgm2;
       		$texto3  = $positiva_cgm3;
       		$texto4  = '';
    	}else if(isset($inscr)){
       		$codtipo = 28;
       		$sql = "select * from empresa where q02_inscr = $inscr";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'positiva%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto);
       		}
       		////////
       		$texto1 = $positiva_ins1;
       		$texto2 = $positiva_ins2;
       		$texto3 = $positiva_ins3;
       		$texto4  = '';
		}
	}else if($tipo==2){
    	// certidao negativa
    	$tipocer = "CERTIDÃO NEGATIVA" ;
    	if(isset($matric)){
    		$codtipo = 29;
    		$sql = "select * from proprietario where j01_matric = $matric";
    		$result = pg_query($sql);
    		db_fieldsmemory($result,0);
    		/////// TEXTOS E ASSINATURAS
    		$instit = db_getsession("DB_instit");
    		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'negativa%' or descrtexto like 'ass%')";
			$resulttexto = pg_exec($sqltexto);
    		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
       			db_fieldsmemory($resulttexto,$xx);
       			$text  = $descrtexto;
       			$$text = db_geratexto($conteudotexto);
    		}
    		////////
    		$texto1 = $negativa_mat1;
    		$texto2 = $negativa_mat2;
    		$texto3 = $negativa_mat3;
    		$texto4  = '';
    	}else if(isset($numcgm)){
       		$codtipo = 30;
       		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
       		$result = pg_query($sql);
       		//die($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'negativa%' or descrtexto like 'ass%')";
       		//die($sqltexto);
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
       			db_fieldsmemory($resulttexto,$xx);
        		$text  = $descrtexto;
        		$$text = db_geratexto($conteudotexto);
       		}
       		////////
       		$texto1  = $negativa_cgm1;
       		$texto2  = $negativa_cgm2;
       		$texto3  = $negativa_cgm3;
       		$texto4  = '';
     	}else if(isset($inscr)){
       		$codtipo = 31;
       		$sql = "select * from empresa where q02_inscr = $inscr";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'negativa%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
				db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto);
       		}
       		////////
       		$texto1 = $negativa_ins1;
       		$texto2 = $negativa_ins2;
       		$texto3 = $negativa_ins3;
       		$texto4  = '';
     	}
  	}else{
    	// certidao regular
     	$tipocer = "CERTIDÃO POSITIVA COM EFEITOS NEGATIVOS" ;
     	if(isset($matric)){
       		$codtipo = 32;
       		$sql = "select * from proprietario where j01_matric = $matric";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'regular%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto);
       		}
       		////////
       		$texto1 = $regular_mat1;
       		$texto2 = $regular_mat2;
       		$texto3 = $regular_mat3;
       		$texto4  = '';
     	}else if(isset($numcgm)){
       		$codtipo = 33;
       		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'regular%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto);
       		}
       		////////
       		$texto1  = $regular_cgm1;
       		$texto2  = $regular_cgm2;
       		$texto3  = $regular_cgm3;
       		$texto4  = '';
     	}else if(isset($inscr)){
       		$codtipo = 34;
       		$sql = "select * from empresa where q02_inscr = $inscr";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos
							where id_instit = $instit and ( descrtexto like 'regular%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto);
       		}
       		////////
       		$texto1 = $regular_ins1;
       		$texto2 = $regular_ins2;
       		$texto3 = $regular_ins3;
       		$texto4  = '';
     	}
  	}


 	//echo $codproc;
  	$head1 = "DEPARTAMENTO DE FAZENDA";

  	//$head4 = "CERTIDÃO No. ".$codproc;
  	//$head6 = $tipocer;
  	$pdf = new PDF1(); 		// abre a classe
  	$pdf->Open(); 			// abre o relatorio
  	$pdf->AliasNbPages(); 	// gera alias para as paginas
  	$pdf->setautopagebreak(true,10);
  	$pdf->AddPage(); 		// adiciona uma pagina
  	$pdf->SetTextColor(0,0,0);
  	$pdf->SetFillColor(235);
  	$Letra = 'Times';
	$TamLetra = 10;
  	$pdf->MultiCell(0,4,$tipocer.' N'.chr(176).' '.$codproc,0,"C",0);
  	$pdf->SetFont($Letra,'',$TamLetra);
  	$pdf->Ln(10);
  	$pdf->Cell(3,1,"",0,0,"L",0).$pdf->MultiCell(0,6,$texto1,0,"J",0,30);
  	$pdf->Cell(3,1,"",0,0,"L",0).$pdf->MultiCell(0,6,$texto2,0,"J",0,30);
  	$pdf->Cell(3,1,"",0,0,"L",0).$pdf->MultiCell(0,6,$texto3,0,"J",0,30);
  	$pdf->Cell(3,1,"",0,0,"L",0).$pdf->MultiCell(0,6,$texto4,0,"J",0,30);
  	$pdf->Cell(10,4,"",0,1,"L",0);
  	$pdf->MultiCell(0,8,$munic.', '.date('d')." de ".db_mes(date('m'))." de ".date('Y').'.',0,0,"R",0);
//  	$pdf->Cell(10,20,"",0,1,"L",1);
  	$pdf->SetY(150);
  	$pdf->Ln(30);
  	$y = $pdf->GetY();
	$x = $pdf->GetX();
  	$resultnomelogin = pg_exec("select nome from db_usuarios where id_usuario = " . db_getsession("DB_id_usuario"));
  	$pdf->MultiCell(90,5,"_________________________________"."\n".pg_result($resultnomelogin,0,0),0,"C",0);
//  	$pdf->SetXY($x,$y);
  	$pdf->MultiCell(90,5,'_________________________________',0,"C",0);

/************************************   R O D A P E   D A   C N D  *******************************************************/

    //$mostrarecibo => parametro q define se mostra ou naun mostra o recibo no rodape da cnd...
    if(isset($cadrecibo) && $cadrecibo == 't'){
		for ($i=0;$i<2;$i++){
			$y = $pdf->GetY();
			$x = $pdf->GetX();
			$pdf->SetXY($x,$y);
			$pdf->RoundedRect(10,$y+15,190,35,0,'','1234');
			$b=1;
			$pdf->Ln(17);
			$TamLetra = 8;
			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(40,5,"DESTINATÁRIO: ",$b,0,"L",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(100,5,@$z01_nome,$b,1,"L",0);

			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(40,5,"ENDEREÇO: ",$b,0,"L",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(50,5,trim(@$z01_ender).", ".trim(@$z01_numero)."  ".trim(@$z01_compl),$b,1,"L",0);

			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(40,5,(@$z01_bairro == ""?"":"BAIRRO: "),$b,0,"L",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(20,5,@$z01_bairro,$b,1,"L",0);

			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(40,5,"MUNICIPIO:",$b,0,"L",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(50,5,@$z01_munic ."/".@$z01_uf . " - " . substr(@$z01_cep,0,5)."-".substr(@$z01_cep,5,3),$b,1,"L",0);

			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(40,5,"NOTIFICAÇÃO: ",$b,0,"L",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(30,5,db_formatar(@$notifica,'s','0',5,'e'),$b,0,"L",0);

			$pdf->SetFont('Arial','',$TamLetra);
			if (@$xcodigo == "numcgm") {
				$pdf->cell(30,5,"CGM:",0,0,"L",0);
				$pdf->SetFont('Arial','B',$TamLetra);
				$pdf->cell(20,5,@$$xcodigo1,0,1,"L",0);
			} elseif (@$xcodigo == "matric") {
				$pdf->cell(30,5,"MATRÍCULA:",0,0,"L",0);
				$pdf->SetFont('Arial','B',$TamLetra);
				$pdf->cell(20,5,@$$xcodigo1,0,1,"L",0);
			} elseif (@$xcodigo == "inscr") {
				$pdf->cell(30,5,"INSCRIÇÃO:",0,0,"L",0);
				$pdf->SetFont('Arial','B',$TamLetra);
				$pdf->cell(20,5,@$$xcodigo1,0,1,"L",0);
			}
		}
	}

/*************************************************************************************************************************/

  	$pdf->Output();
	//===============================================================================================================
}else{

  	/******* modo normal ****************/
  	// select k00_numpre,k00_numpar,k00_receit from arrecad where k00_numpre = 11111454;
  	require("libs/db_stdlib.php");
  	require("libs/db_conecta.php");
  	include("libs/db_sessoes.php");
  	include("libs/db_sql.php");
  	parse_str(base64_decode($HTTP_SERVER_VARS['QUERY_STRING']));
  	if($tipo_cert==1){
  		$tipo = "Positiva";
  	}else if($tipo_cert==0){
    	$tipo = "Regular";
  	}else{
    	$tipo = "Negativa";
  	}

	$rsNumpref = pg_query("select * from numpref where k03_anousu = ".db_getsession("DB_anousu"));
	$numrows = pg_numrows($rsNumpref);
	if ($numrows>0){
	   db_fieldsmemory($rsNumpref,0);
//	   db_msgbox($k03_reccnd);
       if(isset($k03_reccnd) && $k03_reccnd == 't'){
			echo "<script>document.form1.cadrecibo.value = '".$k03_reccnd."'</script>";
//			echo "<script>alert(document.form1.cadrecibo.value);</script>";
	   }
	}

?>
<html>
	<head>
    	<title>Documento sem t&iacute;tulo</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    	<script language="JavaScript" src="scripts/scripts.js"></script>
    	<script>
      		function js_certidao() {
        		if(document.form1.naolibera){
          			alert('Certidão nao Disponível para este tipo de consulta.');
	      			return false;
        		}else{
          			if(confirm('Emite Certidão ' + document.form1.tipo.value)==true){
					    if(document.form1.cadrecibo.value == 't'){
						    js_recibo();
						}else{
							jan=window.open('','certreg','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
							jan.moveTo(0,0);
							setTimeout("document.form1.submit()",1000);
						}
          			}
        		}
      		}
    	</script>
  	</head>
  	<body bgcolor=#CCCCCC bgcolor="#CCCCCC" leftmargin="0" onload="parent.document.getElementById('processando').style.visibility = 'hidden';document.form1.codproc.focus()" topmargin="0" marginwidth="0" marginheight="0">
		<center>
			<form method="post" name="form1" target="certreg">
				<input type="hidden" name="tipo" value="<?=$tipo_cert?>">
    			<input type="hidden" name="cadrecibo" value="">
				<?
					if(isset($matric)){
		  		?>
	  			<input type="hidden" name="matric" value="<?=$matric?>">
	  	  		<?
					}else if(isset($numcgm)){
			  	?>
				<input type="hidden" name="numcgm" value="<?=$numcgm?>">
			  	<?
					}else if(isset($inscr)){
			  	?>
				<input type="hidden" name="inscr" value="<?=$inscr?>">
			  	<?
					}else{
			  	?>
				<input type="hidden" name="naolibera" value="naolibera">
			  	<?
					}
				?>
				<table width="100%">
					<tr>
				    	<td align="center"><font face="Arial, Helvetica, sans-serif"><strong>Certid&atilde;o
		    		  		<?=$tipo?> de D&eacute;bitos</strong></font></td>
		  	  		</tr>
		  			<tr>
		    			<td>
		      				<table width="100%">
		        				<tr>
		          					<td width="14%" align="right"><font face="Arial, Helvetica, sans-serif">Processo:</font></td>
		          					<td width="86%"><input name="codproc" type="text" id="codproc" size="15" maxlength="12"></td>
		        				</tr>
		        				<tr>
		          					<td align="right" valign="top"><font face="Arial, Helvetica, sans-serif">Hist&oacute;rico:</font></td>
		          					<td><textarea name="textarea" cols="60" rows="5"></textarea></td>
		        				</tr>
		      				</table>
		    			</td>
		  			</tr>
		  			<tr>
		    			<td align="center"><input name="certidao" type="button" id="certidao" value="Emite Certid&atilde;o" onClick="js_certidao()"></td>
		  			</tr>
				</table>
			</form>
		</center>
  	</body>
</html>
<script>
function js_recibo(){

    js_OpenJanelaIframe('CurrentWindow.corpo','db_recibo','cai4_recibo001.php?mostramenu=t','Cadastro de recibo',true);
}

</script>
<?
	}// fim do else do if($HTTP_POST_VARS["tipo"])
?>

