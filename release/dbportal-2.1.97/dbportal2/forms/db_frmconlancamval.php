<?
//MODULO: contabilidade
$clconlancamcompl->rotulo->label();
$clconlancamval->rotulo->label();
$clconlancam->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("c50_descr");
$clrotulo->label("c70_anousu");
$clrotulo->label("c69_valor");
$clrotulo->label("c79_codsup");
$clrotulo->label("c73_coddot");
$clrotulo->label("c75_numemp");
$clrotulo->label("c74_codrec");
$clrotulo->label("c78_chave");
$clrotulo->label("c80_codord");
$clrotulo->label("c82_reduz");
?>
<script>

  function critica_form(){
      obj = document.form1;
      if ( obj.c69_debito.value =="" ) {
	alert('Preencha Conta Débito  ');
        obj.c69_debito.focus();
      } else if (obj.c69_credito.value=="") {
	alert('Preencha Conta Credito  ');
        obj.c69_credito.focus();
      } else if (obj.c69_valor.value=="" ) {
	alert('Preencha campo Valor  ');
        obj.c69_valor.focus();
      } else if (obj.c69_codhist.value==""){
        alert('Preencha historico  ');
        obj.c69_codhist.focus();
      } else {
	   // cria imput com dados do botão 'inclui,altera,exclui
           var opcao= document.createElement("input");
	       opcao.setAttribute("type","hidden");
	       opcao.setAttribute("name","db_opcao");
	       opcao.setAttribute("value",document.form1.db_opcao.value);
 	       document.form1.appendChild(opcao);
           document.form1.submit();
      }
  }

 function atualiza() {
    document.form1.submit();
  }

</script>

<?
$alt=false;
$desabilitafunc=false;
if (isset($c70_codlan)  && $c70_codlan!="" ){

$sql1="select c71_codlan from conlancamdoc where c71_codlan=$c70_codlan";
$result1=pg_query($sql1);
$linhas1=pg_numrows($result1);

if ($linhas1 > 0){

     $sql2="select c71_coddoc from conlancamdoc inner join conhistdoc on c71_coddoc=c53_coddoc where c71_codlan=$c70_codlan";
     $result2=pg_query($sql2);
     $linhas2=pg_numrows($result2);
     if ($linhas2>0){
         $tipodoc=@pg_result($result2,0);
           if ($tipodoc==1000 or $tipodoc==2000){
               $alt=true;
               }
           else{
                $alt=false;
                $desabilitafunc=true;
                db_msgbox('Não é permitido alterar ou excluir lançamentos contábeis automáticos.');
               }
     }
     else{
          $alt=false;
          $desabilitafunc=true;
          db_msgbox('Não é permitido alterar ou excluir lançamentos contábeis automáticos.');
         }
}
else{
      $alt=true;
}
if ($alt==false ){
   if ($db_opcao==2){
       $db_opcao=22;
       $db_botao=false;
      }
   if ($db_opcao==3){
       $db_botao=false;
   }
 }
}
?>


<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc70_codlan ?>"> <?=@$Lc70_codlan ?> </td>
    <td><? db_input('c70_codlan',8,$Ic70_codlan,true,'text',3 );
           db_input('c69_sequen',8,$Ic69_sequen,true,'text',3 );
         ?>
    </td>
  </tr>

  <tr>
  <td nowrap title="<?=@$Tc70_data ?>"> <?=@$Lc70_data ?>  </td>
      <td><?

	if( $db_opcao=="1" and (!isset($c70_data_dia))){
            $c70_data_dia = date("d",db_getsession("DB_datausu"));
            $c70_data_mes = date("m",db_getsession("DB_datausu"));
            $c70_data_ano = db_getsession('DB_anousu');
	}
        if (isset($HTTP_SESSION_VARS["ldia"]) && $db_opcao==1){
           $c70_data_dia = db_getsession("ldia");
           $c70_data_mes = db_getsession("lmes");
           $c70_data_ano = db_getsession("DB_anousu");
        }
        @$dt1 = "$c70_data_ano-$c70_data_mes-$c70_data_dia";
        db_inputdata('c70_data',@$c70_data_dia,@$c70_data_mes,@$c70_data_ano,true,'text',$db_opcao,"onchange='';");  ?>
      </td>
  </tr>

  <tr>
   <td nowrap title="<?=$Tc78_chave?>" ><strong> <?=$Lc78_chave?> </strong> </td>
   <td><?
         if (isset($HTTP_SESSION_VARS["llote"]) && $db_opcao==1){
            $c78_chave  = db_getsession("llote");
         }
         db_input("c78_chave",30,"",true,'text',$db_opcao,"");

	?>
   </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tc69_debito ?>"><? db_ancora(@$Lc69_debito,"js_pesquisac69_debito(true);",$db_opcao); ?> </td>
    <td><? db_input('c69_debito',10,$Ic69_debito,true,'text',$db_opcao," onchange='js_pesquisac69_debito(false);'");
           if (isset($c69_debito)) {
                 $r=$clconplano->sql_record(
	              	   $clconplano->sql_query_file("",null,"c60_descr as debito_descr","",
	               											 		" c60_anousu=".db_getsession("DB_anousu")." and   c60_codcon in (
                                                                     select c61_codcon from conplanoreduz
                                                                     where c61_anousu=".db_getsession("DB_anousu")."   and c61_reduz='$c69_debito')" ));
	   }
	   if ($clconplano->numrows > 0 ){
              db_fieldsmemory($r,0);
	   }
           db_input('debito_descr',50,"",true,'text',3,'');
           db_input('debito_saldo',15,$Ic69_debito,true,'text',3,"");
           db_input('debito_sinal',3,$Ic69_debito,true,'text',3,"");
         ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc69_credito?>"><? db_ancora(@$Lc69_credito,"js_pesquisac69_credito(true);",$db_opcao); ?> </td>
    <td><? db_input('c69_credito',10,$Ic69_credito,true,'text',$db_opcao," onchange='js_pesquisac69_credito(false);'");
           if (isset($c69_credito)) {
                $r=$clconplano->sql_record(
	              $clconplano->sql_query_file("",null,"c60_descr as credito_descr","",
	                             " c60_anousu=".db_getsession("DB_anousu")." and c60_codcon in (
                                   select c61_codcon from conplanoreduz where c61_anousu=".db_getsession("DB_anousu")." and
                                   c61_reduz='$c69_credito')" ));
	   }
	   if ($clconplano->numrows > 0 ){
              db_fieldsmemory($r,0);
	   }
           db_input('credito_descr',50,"",true,'text',3,'');
           db_input('credito_saldo',15,$Ic69_debito,true,'text',3,"");
           db_input('credito_sinal',3,$Ic69_debito,true,'text',3,"");

         ?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tc69_valor?>"> <?=@$Lc69_valor ?> </td>
    <td><? db_input('c69_valor',15,$Ic69_valor,true,'text',$db_opcao ); ?></td>
  </tr>

  </tr>
  <tr>
   <td nowrap title="<?=@$Tc69_codhist?>"><? db_ancora(@$Lc69_codhist,"js_pesquisac69_codhist(true);",$db_opcao); ?> </td>
   <td><? db_input('c69_codhist',4,$Ic69_codhist,true,'text',$db_opcao," onchange='js_pesquisac69_codhist(false);'"); ?>
       <? db_input('c50_descr',40,$Ic50_descr,true,'text',3,'');    ?>
    </td>
  </tr>
  <tr>
   <td nowrap title="Tipo de Lançamento">
   <strong>Tipo de Lançamento:</strong> </td>
   <td>
    <?
    $matarr = array('0'=>'Execução','2000'=>'Abertura','1000'=>'Fechamento');
    db_select('c71_coddoc',$matarr,true,2);
    ?>
    </td>
  </tr>

  <tr>
   <td nowrap title="<?=@$Tc72_complem?>"><?=@$Lc72_complem ?> </td>
   <td><?
         if (isset($c70_codlan) and ($c70_codlan!="")) {
         $r=$clconlancamcompl->sql_record($clconlancamcompl->sql_query_file($c70_codlan,"*","",""));
	   if ($clconlancamcompl->numrows > 0 ){
    	       db_fieldsmemory($r,0);
	   }
	 }
         db_textarea("c72_complem",4,80,"",true,'text',$db_opcao); ?>
    </td>
  </tr>
  <tr>
   <td colspan="2" align="center">
 <?

 if (!isset($consulta)){
     if ($db_opcao != "33"){     ?>
       <input name="db_opcao" type="button" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>"           <?=($db_botao==false?"disabled":"")?>   onclick="critica_form(); ">
       <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
     <?  } else {  ?>
       <input name="db_opcao" type="button" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>"           <?=($db_botao==false?"disabled":"")?>   onclick="critica_form(); ">
       <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >

      <input name="fechar" type="button"  value="Fechar" onclick="parent.db_conlancamval.hide();" > <?  }
      echo "</td></tr>";
  } else {
     // consulta é setada na | contabilidade| consulta Lançamentos
        $sql001 =  "select c70_codlan,c79_codsup,c73_coddot,c75_numemp,c74_codrec,c73_anousu,c74_anousu,c80_codord,c82_reduz
	         from conlancam
		      left outer join conlancamsup   on c79_codlan=c70_codlan
		      left outer join conlancamdot   on c73_codlan=c70_codlan
		      left outer join conlancamemp   on c75_codlan=c70_codlan
		      left outer join conlancamrec   on c74_codlan=c70_codlan
		      left outer join conlancamord   on c80_codlan=c70_codlan
		      left outer join conlancamdoc   on c71_codlan=c70_codlan
		      left outer join conlancampag   on c82_codlan=c70_codlan
		      left outer join conlancambol   on c77_codlan=c70_codlan
		 where
		      c70_codlan =$c70_codlan    ";

        $r2=$clconlancamdig->sql_record($sql001);
	if ($clconlancamdig->numrows > 0 ){
	      db_fieldsmemory($r2,0);
	}

       if ($c79_codsup !=""){   ?>
	    <tr>
               <td nowrap title="<?=@$Tc79_codsup ?>"><? db_ancora($Lc79_codsup,'abre_sup()',1) ?></td>
               <td><? db_input('c79_codsup',8,"",true,'text',$db_opcao );?></td>
             </tr>
       <? }
          if ($c73_coddot !="") {  ?>
            <tr>
                <td nowrap title="<?=@$Tc73_coddot ?>"> <? db_ancora($Lc73_coddot,'abre_dot()',1) ?></td>
                <td><? db_input('c73_coddot',8,"",true,'text',$db_opcao );?></td>
            </tr>
       <? }
          if ($c75_numemp) {   ?>
             <tr>
                <td nowrap title="<?=@$Tc75_numemp ?>"> <? db_ancora($Lc75_numemp,'abre_empenho()',1) ?></td>
                <td><?	db_input('c75_numemp',8,"",true,'text',$db_opcao );?></td>
             </tr>
       <? }
          if (!empty($c74_codrec)){ ?>
            <tr>
               <td nowrap title="<?=@$Tc74_codrec ?>"> <? db_ancora($Lc74_codrec,'abre_rec()',1) ?></td>
               <td><? db_input('c74_codrec',8,"",true,'text',$db_opcao );?></td>
            </tr>
       <? }
          if (!empty($c80_codord)){ ?>
            <tr>
               <td nowrap title="<?=@$Tc80_codord ?>"> <? db_ancora($Lc80_codord,'abre_empenho()',1) ?></td>
               <td><? db_input('c80_codord',8,"",true,'text',$db_opcao );?></td>
            </tr>
       <? }
          if (!empty($c82_reduz)){ ?>
            <tr>
               <td nowrap title="<?=@$Tc82_reduz ?>"> <?=$Lc82_reduz ?></td>
               <td><? db_input('c82_reduz',8,"",true,'text',$db_opcao );?></td>
            </tr>
       <? }


   }
 ?>

   </table>
  </center>

</form>
<script>

 function abre_sup(){
   //   js_JanelaAutomatica('empempenho','<?=@$c75_numemp ?>');
 }
 function abre_empenho(){
    js_JanelaAutomatica('empempenho','<?=@$c75_numemp?>');
 }
 function abre_dot(){
    js_JanelaAutomatica('orcdotacao','<?=@$c73_coddot?>','<?=@$c73_anousu?>');
 }
 function abre_rec(){
    js_JanelaAutomatica('orcreceita','<?=@$c74_codrec?>','<?=@$c74_anousu?>');
 }



 function js_pesquisac69_codhist(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conhist','func_conhist.php?funcao_js=parent.js_mostraconhist1|c50_codhist|c50_descr','Pesquisa',true);
  }else{
     if(document.form1.c69_codhist.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conhist','func_conhist.php?pesquisa_chave='+document.form1.c69_codhist.value+'&funcao_js=parent.js_mostraconhist','Pesquisa',false);
     }else{
       document.form1.c50_descr.value = '';
     }
  }
}
function js_mostraconhist(chave,erro){
  document.form1.c50_descr.value = chave;
  if(erro==true){
    document.form1.c69_codhist.focus();
    document.form1.c69_codhist.value = '';
  }
}
function js_mostraconhist1(chave1,chave2){
  document.form1.c69_codhist.value = chave1;
  document.form1.c50_descr.value = chave2;
  db_iframe_conhist.hide();
}

// conta debito
function js_pesquisac69_debito(mostra){
  if(mostra==true){
     js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conplanoexe','func_conplanoexelanc.php?dataret='+document.form1.c70_data_ano.value+'-'+document.form1.c70_data_mes.value+'-'+document.form1.c70_data_dia.value+'&funcao_js=parent.js_mostra_debito|c62_reduz|c60_descr','Pesquisa',true);
  }else{
     if(document.form1.c69_debito.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conplanoexe','func_conplanoexelanc.php?dataret='+document.form1.c70_data_ano.value+'-'+document.form1.c70_data_mes.value+'-'+document.form1.c70_data_dia.value+'&pesquisa_chave='+document.form1.c69_debito.value+'&funcao_js=parent.js_mostra_debito2','Pesquisa',false);
     }else{
       document.form1.c69_debito.value = '';
     }
  }
}
function js_mostra_debito(chave1,chave2,chave3,chave4){
  document.form1.c69_debito.value = chave1;
  document.form1.debito_descr.value= chave2;
  document.form1.debito_saldo.value= chave3;
  document.form1.debito_sinal.value= chave4;
  db_iframe_conplanoexe.hide();
}
function js_mostra_debito2(chave1,erro,chave2,chave3){
   document.form1.debito_descr.value = chave1;
   document.form1.debito_saldo.value = chave2;
   document.form1.debito_sinal.value = chave3;
   if(erro==true){
      document.form1.c69_debito.focus();
      document.form1.c69_debito.value = '';
   }
}
// fim conta debito
// inicio credito
function js_pesquisac69_credito(mostra){
  if(mostra==true){
     js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conplanoexe','func_conplanoexelanc.php?dataret='+document.form1.c70_data_ano.value+'-'+document.form1.c70_data_mes.value+'-'+document.form1.c70_data_dia.value+'&funcao_js=parent.js_mostra_credito|c62_reduz|c60_descr','Pesquisa',true);
  }else{
     if(document.form1.c69_credito.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conplanoexe','func_conplanoexelanc.php?dataret='+document.form1.c70_data_ano.value+'-'+document.form1.c70_data_mes.value+'-'+document.form1.c70_data_dia.value+'&pesquisa_chave='+document.form1.c69_credito.value+'&funcao_js=parent.js_mostra_credito2','Pesquisa',false);
     }else{
       document.form1.c69_credito.value = '';
     }
  }
}
function js_mostra_credito(chave1,chave2,chave3,chave4){
    document.form1.c69_credito.value = chave1;
    document.form1.credito_descr.value= chave2;
    document.form1.credito_saldo.value= chave3;
    document.form1.credito_sinal.value= chave4;
    db_iframe_conplanoexe.hide();
}
function js_mostra_credito2(chave1,erro,chave2,chave3){
    document.form1.credito_descr.value = chave1;
    document.form1.credito_saldo.value = chave2;
    document.form1.credito_sinal.value = chave3;
    if(erro==true){
         document.form1.c69_credito.focus();
         document.form1.c69_credito.value = '';
    }
}
// fim credito

function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conlancamval','func_conlancamval.php?funcao_js=parent.js_preenchepesquisa|c69_sequen','Pesquisa',true);
}

function js_preenchepesquisa(chave){
  db_iframe_conlancamval.hide();
  <?

  if($db_opcao!=1 ){

    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

</script>
