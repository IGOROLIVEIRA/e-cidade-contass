<?
$clinfla->rotulo->label();

?>
<style type="text/css">
.tabela {border:1px solid black; top:25px; left:150}
.input_novo {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        height: 17px;
        border: 0px solid #999999;
}
</style>

<script language="JavaScript" type="text/JavaScript">

function mo_camada(camada,mostra){
   alvo = document.getElementById(camada);
   divs  = document.getElementsByTagName("DIV");
   for (var j = 0; j < divs.length; j++){
      if(mostra){
	    if(alvo.id == divs[j].id)
          divs[j].style.visibility = "visible";
	    else
		  if(divs[j].className == 'tabela'){
            divs[j].style.visibility = "hidden";
          }
	  }else{	 
	    if(alvo.id == divs[j].id)
          divs[j].style.visibility = "hidden";
	  }
   }
}


</script>
	<table border="0" cellpadding="0" cellspacing="0">
	  <tr>
	  <td>
	    <a  href="" title=""  onclick="mo_camada('Layer1',true);return false">Janeiro</a>
	    <a  href="" title=""  onclick="mo_camada('Layer2',true);return false">Fevereiro</a>
	    <a  href="" title=""  onclick="mo_camada('Layer3',true);return false">Março</a>
	    <a  href="" title=""  onclick="mo_camada('Layer4',true);return false">Abril</a>
	    <a  href="" title=""  onclick="mo_camada('Layer5',true);return false">Maio</a>
	    <a  href="" title=""  onclick="mo_camada('Layer6',true);return false">Junho</a>
	    <a  href="" title=""  onclick="mo_camada('Layer7',true);return false">Julho</a>
	    <a  href="" title=""  onclick="mo_camada('Layer8',true);return false">Agosto</a>
	    <a  href="" title=""  onclick="mo_camada('Layer9',true);return false">Setembro</a>
	    <a  href="" title=""  onclick="mo_camada('Layer10',true);return false">Outubro</a>
	    <a  href="" title=""  onclick="mo_camada('Layer11',true);return false">Novembro</a>
	    <a  href="" title=""  onclick="mo_camada('Layer12',true);return false">Dezembro</a>

	  </td>
	  </tr>
	</table>
        <?
        for($qm=1;$qm<13;$qm++){
        ?>	
	<div class="tabela" id="Layer<?=$qm?>" style="position:absolute; left:3px; top:80px; width:760px; height:300px; z-index:1; visibility: <?=($qm==1?'visible':'hidden')?>;">
        <center>
        <table>
          <?
          $mes = db_formatar($qm,'s','0',2);
          $result = $clinfla->sql_record($clinfla->sql_query_file('','','*','i02_data'," i02_codigo = '$i01_codigo' and substr(i02_data,1,7) = '".$exercicio."-"."$mes'"));
          if($clinfla->numrows>0){
            if($tipodm==0){
              $dias_mes = 1;
            }else{
              $dias_mes = date('t',mktime(0,0,0,$mes,1,$exercicio));
            }
          $matriz = array();
          for($im=1;$im<=($dias_mes);$im++){
            db_fieldsmemory($result,$im-1);
            $matriz[$im] = '$i02_valor';
            $vartemp = "i02_valor_".$qm."_".$im;
            $$vartemp = $i02_valor;
         }

          for($im=1;$im<12;$im++){
            ?>
            <tr>
            <td width="5%"> 
            <?
            if(isset($matriz[$im]) && $im < 11)
               echo $im;
            ?>
	    </td>
            <td width="25%"> 
	    <?
            if(isset($matriz[$im]) && $im < 11)
              db_input("i02_valor",15,$Ii02_valor,true,'text',$opcao,"","i02_valor_".$qm."_".$im);
            ?>
 	    </td>
            <?
            // 10 a 19
            ?>
            <td width="5%"> 
            <?

            if(isset($matriz[$im+10]) && $im < 11)
              echo $im+10;
            ?>
	    </td>
            <td width="25%"> 
	    <?
            if(isset($matriz[$im+10]) && $im < 11)
              db_input("i02_valor",15,$Ii02_valor,true,'text',$opcao,"","i02_valor_".$qm."_".($im+10));
            ?>
 	    </td>
            <?
            // 21 a 31
            ?>
            <td width="5%"> 
            <?
            if(isset($matriz[$im+20]))
              echo $im+20;
            ?>
	    </td>
            <td width="25%"> 
	    <?
            if(isset($matriz[$im+20]))
              db_input("i02_valor",15,$Ii02_valor,true,'text',$opcao,"","i02_valor_".$qm."_".($im+20));
            ?>
 	    </td>
            </tr>
            <?
            }
          }
        ?>
	</table>
        </center>	
        </div>

       <?
       }
       ?>










