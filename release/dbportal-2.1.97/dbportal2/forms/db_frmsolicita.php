<?
$clsolicita->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("descrdepto");
$clrotulo->label("pc50_descr");
$clrotulo->label("pc12_vlrap");
$clrotulo->label("pc12_tipo");
//MODULO: compras
   $result_tipo = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_seltipo,pc30_tipoemiss"));
   if($clpcparam->numrows>0){
       db_fieldsmemory($result_tipo,0);
   }
?>
<BR><BR>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tpc10_numero?>">
       <?=@$Lpc10_numero?>
    </td>
    <td>
<?
db_input('pc10_numero',8,$Ipc10_numero,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc10_data?>">
       <?=@$Lpc10_data?>
    </td>
    <td>
<?
$recebedata = db_getsession("DB_datausu");
$recebedata = date("Y-m-d",$recebedata);
if(isset($pc10_data) && trim($pc10_data) != ""){
  $recebedata = $pc10_data;
}
$arr_data = split("-",$recebedata);
@$pc10_datadia = $arr_data[2];
@$pc10_datames = $arr_data[1];
@$pc10_dataano = $arr_data[0];
db_inputdata('pc10_data',$pc10_datadia,$pc10_datames,$pc10_dataano,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc10_resumo?>">
       <?=@$Lpc10_resumo?>
    </td>
    <td>
<?
@$pc10_resumo = stripslashes($pc10_resumo);
db_textarea('pc10_resumo',15,80,$Ipc10_resumo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc10_depto?>">
       <?=@$Lpc10_depto?>
    </td>
    <td>
<?
db_input("param",10,"",false,"hidden",3);

$GLOBALS["pc10_depto"] = db_getsession("DB_coddepto");
db_input('pc10_depto',8,"",true,'text',3);
$result_depart=$cldb_depart->sql_record($cldb_depart->sql_query_file($pc10_depto,"descrdepto"));
if($cldb_depart->numrows > 0){
  db_fieldsmemory($result_depart,0);
}
db_input('descrdepto',40,"",true,'text',3);
?>
    </td>
  </tr>
  <?
   $parampesquisa = true;
   if(isset($pc30_seltipo) && $pc30_seltipo=="t"){
  ?>
  <tr>
    <td nowrap title="<?=@$Tpc12_tipo?>">
       <?=@$Lpc12_tipo?>
    </td>
    <td>
    <?
    if(isset($pc12_tipo) && $pc12_tipo=='' || !isset($pc12_tipo)){
      $somadata = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"),"pc30_tipcom as pc12_tipo"));
      if($clpcparam->numrows>0){
	db_fieldsmemory($somadata,0);
      }else if(!isset($chavepesquisa) || !isset($pc10_numero)){
	db_msgbox("Usuário: \\n\\nParâmetros de solicitação não configurados. \\n\\nAdministrador:");
	$db_opcao=3;
	$db_botao=false;
	$parampesquisa = false;
      }
    }
    $result_tipocompra=$clpctipocompra->sql_record($clpctipocompra->sql_query_file(null,"pc50_codcom as pc12_tipo,pc50_descr"));
    db_selectrecord("pc12_tipo",$result_tipocompra,true,$db_opcao);
    ?>
    </td>
  </tr>
  <?
   }

   if (isset($param) && trim($param) != ""){
        if (isset($codliclicita) && trim($codliclicita) != ""){
	     $flag_liclicita = true;
	} else {
	     $flag_liclicita = false;
	}

        if (isset($codproc) && trim($codproc) != ""){
	     $dbwhere      = "pc80_codproc = $codproc and";
	     $flag_codproc = true;
	} else {
	     $dbwhere      = "";
	     $flag_codproc = false;
	}

        if (isset($chavepesquisa) && trim($chavepesquisa) != "" &&
	     $param == "alterar"   && @$param_ant == ""){
	     $dbwhere = "pc11_numero = $chavepesquisa and ";
	}

	$clpcproc->rotulo->label();
        $result_pcproc = $clpcproc->sql_record($clpcproc->sql_query_autitem(null,
	                                                                    "distinct pc80_codproc as codproc3",
									    null,
									    "$dbwhere pc80_depto = ".db_getsession("DB_coddepto")));
        if (strlen(trim(@$campo)) > 0){
        $result_liclicitem = $clliclicitem->sql_record($clliclicitem->sql_query_inf(null,
	                                                                            "distinct l21_codliclicita as codliclicita3$campo",
									            null,
									            "$dbwhere"));
        }
/*
        if (isset($chavepesquisa) && trim($chavepesquisa) != "" && $liberaaba == "false"){
	     if ($result_liclicitem->numrows > 0){
	          for(
	          db_fieldsmemory($result_liclicitem,0);
   	     } else {
                  if ($clpcproc->numrows > 0){
	               db_fieldsmemory($result_pcproc,0);
	               $codproc      = $codproc3;
	               $flag_codproc = true;
	          }
	     }
        }
*/
	if ($flag_liclicita == false){
	     if ($param == "incluir"){
	          $pc     = 1;
		  $tranca = $pc;

	     } else {
	          $pc     = 3;
		  $tranca = $pc + 2;
	     }
  ?>
     <tr>
        <td nowrap title="<?=$Tpc80_codproc?>">
	<?
	   db_ancora($Lpc80_codproc,"js_pesquisapc80_codproc(true);",$tranca);
	?>
	</td>
	<td nowrap>
        <?
           db_input('codproc',10,$Ipc80_codproc,true,"text",$pc,"OnChange='js_pesquisapc80_codproc(false);'");
        ?>
	</td>
     </tr>
  <?
        }

        if (isset($codliclicita) && trim($codliclicita) != ""){
	     $dbwhere = "l21_codliclicita = $codliclicita and";
	} else {
	     $dbwhere = "";
	     $campo   = "";
	}

        if (isset($chavepesquisa) && trim($chavepesquisa) != "" &&
	    $param == "alterar"   && @$param_ant == ""){
	       $dbwhere    = "pc11_numero = $chavepesquisa and ";
	       $campo      = ",pc11_numero as codsol";
	       $flag_achou = false;
	}

        if (strlen(trim(@$campo)) > 0){
             $result_liclicitem = $clliclicitem->sql_record($clliclicitem->sql_query_inf(null,
	                                                                                       "distinct l21_codliclicita as codliclicita3$campo",
									                                                                       null,
                                                             								             "$dbwhere"));
        }
/*
        echo($clliclicitem->sql_query_inf(null,
	                                  "distinct l21_codliclicita as codliclicita3$campo",
	                                  null,
				          "$dbwhere (e55_sequen is null or (e55_sequen is not null and e54_anulad is null))"
				         ));
*/
	if ($flag_codproc == false){
  ?>
     <tr>
        <td nowrap title="Licitação">
	<b>
	<?
	   db_ancora("Licitação:","js_pesquisal21_codliclicita(true);",$tranca);
	?>
	</b>
	</td>
	<td nowrap>
        <?
           db_input('codliclicita',10,"",true,"text",3,"onChange='js_pesquisal21_codliclicita(false);'");
        ?>
	</td>
     </tr>
  <?
           }
   }
  ?>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" <?=($parampesquisa==false?"disabled":"")?> >
<?
if(isset($pc10_numero) || isset($chavepesquisa)){
  if(isset($chavepesquisa)){
    $pc10_numero=$chavepesquisa;
  }
  $result_itens = $clsolicitem->sql_record($clsolicitem->sql_query_file(null,"pc11_codigo",""," pc11_numero=$pc10_numero "));
  if($clsolicitem->numrows>0){
    echo "<input name='gera' type='submit' id='gera' value='Gerar relatório' onclick='js_gerarel();'>";
  }
}
if(isset($departusu) && trim($departusu)!=""){
  echo '<input name="importar" type="button" id="importar" value="Importar Solicitação" onclick="js_importa();">';
}
db_input('opselec',40,"",true,'hidden',3);
?>
</form>
<script>
function js_gerarel(){
  obj = document.form1;
  query='';
  query += "&ini="+obj.pc10_numero.value;
  query += "&fim="+obj.pc10_numero.value;
  query += "&departamento=<?=db_getsession("DB_coddepto")?>";
  <?
  if(isset($pc30_tipoemiss) && trim($pc30_tipoemiss)!=""){
//      echo "alert('$pc30_tipoemiss');";
    if($pc30_tipoemiss=="t"){
      echo "jan = window.open('com2_emitesolicita002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');";
    }else{
      echo "jan = window.open('com2_emitesolicita003.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');";
    }
    echo "jan.moveTo(0,0);";
  }else{
    echo "alert('Usuário:\\n\\nParâmetros do módulo compras não configurados.\\n\\nAdministrador:');";
  }
  ?>
  /*
  ini = document.form1.pc10_numero.value;
  jan = window.open('com2_emitesolicita002.php?ini='+ini+'&fim='+ini,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
  */
}
function js_importa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_solicita','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_preencheimporta|pc10_numero&nada=true','Pesquisa',true,'0');
}
function js_preencheimporta(chave){
  db_iframe_solicita.hide();
  <?
  if($db_opcao==1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?importar='+chave";
  }
  ?>
}

function js_pesquisa(){
<?
   if (isset($param) && $param != ""){
        if (strlen(trim(@$codproc)) > 0 || strlen(trim(@$codliclicita)) > 0){
             $parametro = "&param=".$param."&codproc=".$codproc."&codliclicita=".$codliclicita;
        } else {
             $parametro = "&param=".$param;
        }
   } else {
        $parametro = "";
   }
?>
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_solicita','db_iframe_solicita','func_solicita.php?proc=true&funcao_js=parent.js_preenchepesquisa|pc10_numero&departamento=<?=db_getsession("DB_coddepto")?><?=$parametro?>','Pesquisa',true,'0');
}
function js_preenchepesquisa(chave){
  db_iframe_solicita.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&liberaaba=false$parametro'";
  }
  ?>
}
<?
   if (isset($param) && trim($param) != ""){
        $parametro2 = "&param=".$param;
   } else {
        $parametro2 = "";
   }
?>
function js_pesquisapc80_codproc(mostra){
   if (mostra == true){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_solicita','db_iframe_pcproc','func_excautitem.php?funcao_js=parent.js_mostrapcproc1|pc80_codproc<?=$parametro2?>','Processos',true);
   } else {
        if (document.form1.codproc.value != ""){
             js_OpenJanelaIframe('CurrentWindow.corpo.iframe_solicita','db_iframe_pcproc','func_excautitem.php?pesquisa_chave='+document.form1.codproc.value+'&funcao_js=parent.js_mostrapcproc<?=$parametro2?>','Processos',false);
	}
   }
}
function js_pesquisal21_codliclicita(mostra){
   if(mostra == true){
       js_OpenJanelaIframe('CurrentWindow.corpo.iframe_solicita','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo<?=$parametro2?>','Licitações',true);
   } else {
       if(document.form1.codliclicita.value != ''){
           js_OpenJanelaIframe('CurrentWindow.corpo.iframe_solicita','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.codliclicita.value+'&funcao_js=parent.js_mostraliclicita<?=$parametro2?>','Licitações',false);
       }
   }
}
function js_mostrapcproc1(chave1){
   document.form1.codproc.value = chave1;
   db_iframe_pcproc.hide();
}
function js_mostrapcproc(chave,erro){
   if(erro==true){
       document.form1.codproc.focus();
       document.form1.codproc.value = '';
       alert("Processo de compras já autorizado a empenho!");
   }
}
function js_mostraliclicita(chave,erro){
  if(erro==true){
      document.form1.codliclicita.value = '';
      document.form1.codliclicita.focus();
      alert("Licitação já autorizada a empenho!");
  }
}
function js_mostraliclicita1(chave1){
   document.form1.codliclicita.value = chave1;
   db_iframe_liclicita.hide();
}
</script>
