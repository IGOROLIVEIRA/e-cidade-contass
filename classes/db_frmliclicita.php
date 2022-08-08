<?
include("classes/db_db_depart_classe.php");
$cldb_depart = new cl_db_depart;

$clliclicita->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc50_descr");
$clrotulo->label("l34_protprocesso");
$clrotulo->label("nome");
$clrotulo->label("l03_usaregistropreco");
$clrotulo->label("p58_numero");
$clrotulo->label("l20_naturezaobjeto");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
if ($db_opcao == 1) {

	/*
	 * verifica na tabela licitaparam se deve utilizar processo do sistema
	 */
  $oParamLicicita = db_stdClass::getParametro('licitaparam', array(db_getsession("DB_instit")));

  if(isset($oParamLicicita[0]->l12_escolheprotocolo) && $oParamLicicita[0]->l12_escolheprotocolo == 't'){
  	$lprocsis = 's';
  }else{
  	$lprocsis = 'n';
  }

  /*
   * verifica se existe apenas 1 cl_liclocal
   */
  $oLicLocal = new cl_liclocal();
  $rsLicLocal = $oLicLocal->sql_record($oLicLocal->sql_query_file());
  if( $oLicLocal->numrows == 1 ) {
  	db_fieldsmemory($rsLicLocal,0);
  	$l20_liclocal = $l26_codigo;
  }

  /*
   * verifica se existe apenas 1 cl_liccomissao
   */
  $oLicComissao = new cl_liccomissao();
  $rsLicComissao = db_query($oLicComissao->sql_query_file());
  if( pg_num_rows($rsLicComissao) == 1 ){
  	db_fieldsmemory($rsLicComissao,0);
  	$l20_liccomissao = $l30_codigo;
  }

}


  $l20_codepartamento=db_getsession("DB_coddepto");
  $result_depto=$cldb_depart->sql_record($cldb_depart->sql_query_file($l20_codepartamento,'descrdepto'));
  if ($cldb_depart->numrows!=0){
    db_fieldsmemory($result_depto,0);
  }
  $l20_descricaodep=$descrdepto;


?>

<style type="text/css">
.fieldsetinterno {
		border:0px;
		border-top:2px groove white;
		margin-top:10px;

}
fieldset table tr > td {
		width: 180px;
		white-space: nowrap
 }
</style>
<form name="form1" method="post" action="" onsubmit="js_ativaregistro()">
<center>

<table align=center style="margin-top:25px;">
<tr><td>

<fieldset>
<legend><strong>Licitação</strong></legend>

<fieldset style="border:0px;">

<table border="0">
 <tr>
   <td nowrap title="sequencial">
    <b>Sequencial</b>
   </td>
   <td>
     <?
       db_input('l20_codigo',10,$Il20_codigo,true,'text',3,"");
       if ($db_opcao == 1 || $db_opcao == 11){
          $l20_correto = 'f';
       }
       db_input("l20_correto",1,"",true,"hidden",3);
       if ($db_botao == false && @$l20_correto == 't'){
     ?>
    &nbsp;&nbsp;<font color="#FF0000"><b>Licitação já julgada</b></font>
     <?
       }
     ?>
   </td>
 </tr>
 <tr>
   <td nowrap title="<?=@$Tl20_edital?>">
     <b>Licitação:</b>
   </td>
   <td>
     <?
       db_input('l20_edital',10,$Il20_edital,true,'text',3,"");
     ?>
   </td>
 </tr>
 <tr>
    <td nowrap title="<?=@$Tl20_codtipocom?>">
      <b>
       <?
         db_ancora("Modalidade :","js_pesquisal20_codtipocom(true);",3);
       ?>
      </b>
    </td>
    <td>
      <?
        $result_tipo=$clcflicita->sql_record($clcflicita->sql_query_numeracao(null,"l03_codigo,l03_descr", null, "l03_instit = " . db_getsession("DB_instit")));
        if ($clcflicita->numrows==0){
		      db_msgbox("Nenhuma Modalidade cadastrada!!");
		      $result_tipo="";
		      $db_opcao=3;
		      $db_botao = false;
		      db_input("l20_codtipocom",10,"",true,"text");
		      db_input("l20_codtipocom",40,"",true,"text");
        }else{
          db_selectrecord("l20_codtipocom",@$result_tipo,true,$db_opcao,"js_mostraRegistroPreco()");
          if (isset($l20_codtipocom)&&$l20_codtipocom!=""){
            echo "<script>document.form1.l20_codtipocom.selected=$l20_codtipocom;</script>";
          }
        }
      ?><input	type="hidden" id="descricao" name="descricao" value=""   onchange="js_convite()">

    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl20_numero?>">
        <?=@$Ll20_numero?>
    </td>
    <td>
        <?
          db_input('l20_numero',10,$Il20_numero,true,'text',3,"");
        ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_id_usucria?>">
       <?
       db_ancora(@$Ll20_id_usucria,"js_pesquisal20_id_usucria(true);",3);
       ?>
    </td>
    <td>
      <?
        $usuario=db_getsession("DB_id_usuario");
        $result_usuario=$cldb_usuarios->sql_record($cldb_usuarios->sql_query_file($usuario));
        if ($cldb_usuarios->numrows>0){
          	db_fieldsmemory($result_usuario,0);
        }
        $l20_id_usucria=$id_usuario;
        db_input('l20_id_usucria',10,$Il20_id_usucria,true,'text',3,"onchange='js_pesquisal20_id_usucria(false);'")
      ?>
      <?
       db_input('nome',45,$Inome,true,'text',3,'')
      ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_codepartamento?>">
       <?=@$Ll20_codepartamento?>
    </td>
    <td>
      <?
      db_input('l20_codepartamento',10,$Inome,true,'text',3,'');
      db_input('l20_descricaodep',45,$Inome,true,'text',3,'');
      ?>
   </td>
 </tr>




 <tr>
    <td nowrap title="<?=@$Tl20_tipliticacao?>">
       <?=@$Ll20_tipliticacao?>
    </td>
    <td>
      <?
       $arr_tipo = array("1"=>"1- Menor Preço","2"=>"2- Melhor Técnica","3"=>"3- Técnica e Preço","4"=>"4- Maior Lance ou Oferta");
        db_select("l20_tipliticacao",$arr_tipo,true,$db_opcao);
      ?>
   </td>
 </tr>


 <tr>
    <td nowrap title="<?=@$Tl20_tipnaturezaproced?>">
       <?=@$Ll20_tipnaturezaproced?>
    </td>
    <td>
      <?
       $al20_tipnaturezaproced =array("1"=>"1-Licitação Normal","2"=>"2-Registro de Preço","3"=>"3-Credenciamento/Chamada");
        db_select("l20_tipnaturezaproced",$al20_tipnaturezaproced,true,$db_opcao,"onchange='js_naturezaprocedimento(this.value);'");
      ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_naturezaobjeto?>">
       <?=@$Ll20_naturezaobjeto?>
    </td>
    <td>
      <?
       $al20_naturezaobjeto = array("1"=>"1- Obras e Serviços de Engenharia","2"=>"2- Compras e outros serviços","3"=>"3- Técnica e Preço","4"=>"4- Maior Lance ou Oferta");
        db_select("l20_naturezaobjeto",$al20_naturezaobjeto,true,$db_opcao,"onchange='js_regime(this.value);'");
      ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_regimexecucao?>">
       <?=@$Ll20_regimexecucao?>
    </td>
    <td>
      <?
       $al20_regimexecucao = array("0"=>"","1"=>"1- Empreitada por Preço Global","2"=>"2- Empreitada por Preço Unitário","3"=>"3- Empreitada Integral","4"=>"4- Tarefa","5"=>"5-Execução Direta");
        db_select("l20_regimexecucao",$al20_regimexecucao,true,$db_opcao);
      ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_descontotab?>">
       <?=@$Ll20_descontotab?>
    </td>
    <td>
      <?
       $al20_descontotab = array("1"=>"1- Sim","2"=>"2- Não");
        db_select("l20_descontotab",$al20_descontotab,true,$db_opcao);
      ?>
   </td>
 </tr>



  <tr>
    <td nowrap title="<?=@$Tl20_numeroconvidado?>">
       <?=@$Ll20_numeroconvidado?>
    </td>
    <td>
      <?
       db_input('l20_numeroconvidado',3,$Il20_numeroconvidado,true,'text',$db_opcao,"","","#E6E4F1")
      ?>
   </td>
 </tr>


  <tr>
    <td nowrap title="<?=@$Tl20_execucaoentrega?>">
       <?=@$Ll20_execucaoentrega?>
    </td>
    <td>
      <? $al20_diames = array("1"=>"Dias","2"=>"Mes");
         db_select("l20_diames",$al20_diames,true,$db_opcao);
         db_input('l20_execucaoentrega',3,$Il20_execucaoentrega,true,'text',$db_opcao,"");
      ?>
   </td>
 </tr>



</table>
</fieldset>

<fieldset class="fieldsetinterno">
<legend><strong>Datas</strong></legend>
<table>

 <tr>
    <td nowrap title="<?=@$Tl20_dataaber?>">
       <?=@$Ll20_dataaber?>
    </td>
    <td>
      <?
        db_inputdata("l20_dataaber",@$l20_dataaber_dia,@$l20_dataaber_mes,@$l20_dataaber_ano,true,'text',$db_opcao);
      ?>
      <?=@$Ll20_horaaber?>
       <? $l20_horaaber= db_hora();
       // db_input('l20_horaaber',5,$Il20_horaaber,true,'text',$db_opcao,"OnKeyUp='mascara_hora(this.value)'");echo "hh:mm";
       db_input('l20_horaaber', 5, $Il20_horaaber, true, 'text', $db_opcao, "onchange='js_verifica_hora(this.value,this.name)';onkeypress='return js_mask(event, \"0-9|:|0-9\"); '");echo "hh:mm";
       ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_datacria?>">
       <?=@$Ll20_datacria?>
    </td>
    <td>
       <?
         if(!isset($l20_datacria)) {
           $l20_datacria_dia=date('d',db_getsession("DB_datausu"));
           $l20_datacria_mes=date('m',db_getsession("DB_datausu"));
           $l20_datacria_ano=date('Y',db_getsession("DB_datausu"));
         }
         db_inputdata("l20_datacria",@$l20_datacria_dia,@$l20_datacria_mes,@$l20_datacria_ano,true,'text',$db_opcao);
       ?>
       <?=@$Ll20_horacria?>
       <?
         if ($db_opcao == 1 || $db_opcao == 11){
             $l20_horacria=db_hora();
         }
       echo "&nbsp;";db_input('l20_horacria',5,$Il20_horacria,true,'text',3,"");echo "hh:mm";
       ?>
    </td>
 </tr>

  <tr>
    <td nowrap title="<?=@$Tl20_dtpublic?>">
       <?=@$Ll20_dtpublic?>
    </td>
    <td>
       <?
         db_inputdata('l20_dtpublic',@$l20_dtpublic_dia,@$l20_dtpublic_mes,@$l20_dtpublic_ano,true,'text',$db_opcao,"");
       ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_recdocumentacao?>">
       <?=@$Ll20_recdocumentacao?>
    </td>
    <td>
       <?
         db_inputdata('l20_recdocumentacao',@$l20_recdocumentacao_dia,@$l20_recdocumentacao_mes,@$l20_recdocumentacao_ano,true,'text',$db_opcao,"");
       ?>
   </td>
 </tr>



 <tr>
    <td nowrap title="<?=@$Tl20_datapublicacao1?>">
       <?=@$Ll20_datapublicacao1?>
    </td>
    <td>
       <?
         db_inputdata('l20_datapublicacao1',@$l20_datapublicacao1_dia,@$l20_datapublicacao1_mes,@$l20_datapublicacao1_ano,true,'text',$db_opcao,"");
       ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_nomeveiculo1?>">
       <?=@$Ll20_nomeveiculo1?>
    </td>
    <td>
       <?
         db_input('l20_nomeveiculo1',50,$Il20_nomeveiculo1,true,'text',$db_opcao,"");
       ?>
   </td>
 </tr>



<tr>
    <td nowrap title="<?=@$Tl20_datapublicacao2?>">
       <?=@$Ll20_datapublicacao2?>
    </td>
    <td>
       <?
         db_inputdata('l20_datapublicacao2',@$l20_datapublicacao2_dia,@$l20_datapublicacao2_mes,@$l20_datapublicacao2_ano,true,'text',$db_opcao,"");
       ?>
   </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_nomeveiculo2?>">
       <?=@$Ll20_nomeveiculo2?>
    </td>
    <td>
       <?
         db_input('l20_nomeveiculo2',50,$Il20_nomeveiculo2,true,'text',$db_opcao,"");
       ?>
   </td>
 </tr>

</table>

</fieldset>


<fieldset>
<legend><strong>Dados Adicionais	</strong></legend>
<table>
 <tr>
    <td nowrap title="<?=@$Tl20_critdesempate?>">
       <?=@$Ll20_critdesempate?>
    </td>
    <td>
       <?
        $al20_critdesempate = array("1"=>"Sim","2"=>"Não");
        db_select("l20_critdesempate",$al20_critdesempate,true,$db_opcao);
       ?>
       <td>
       <?=@$Ll20_subcontratacao?>
       </td>
       <td>
       <?$al20_subcontratacao = array("1"=>"Sim","2"=>"Não");
        db_select("l20_subcontratacao",$al20_subcontratacao,true,$db_opcao);
       ?>
       </td>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_destexclusiva?>">
       <?=@$Ll20_destexclusiva?>
    </td>
    <td>
       <?
        $al20_destexclusiva = array("1"=>"Sim","2"=>"Não");
        db_select("l20_destexclusiva",$al20_destexclusiva,true,$db_opcao);
       ?>
       <td>
       <?=@$Ll20_limitecontratacao?>
       </td>
       <td>
       <?$al20_limitcontratacao = array("1"=>"Sim","2"=>"Não");
        db_select("l20_limitcontratacao",$al20_limitcontratacao,true,$db_opcao);
       ?>
       </td>
    </td>
 </tr>

</table>
</fieldset>

<fieldset>
<legend><strong>Informações Adicionais	</strong></legend>
<table>
 <tr>
    <td nowrap title="<?=@$Tl20_tipojulg?>">
       <?=@$Ll20_tipojulg?>
    </td>
    <td>
       <?
        $arr_tipo = array("1"=>"Por item","2"=>"Global","3"=>"Por lote");
        db_select("l20_tipojulg",$arr_tipo,true,$db_opcao);
        db_input("tipojulg",1,"",true,"hidden",3,"");
        db_input("confirmado",1,"",true,"hidden",3,"");
       ?>
       <?=@$Ll20_procadmin?>
       <? db_input('l20_procadmin',21,$Il20_procadmin,true,'text',$db_opcao,"")?>

    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_liclocal?>">
       <?
       db_ancora(@$Ll20_liclocal,"js_pesquisal20_liclocal(true);",$db_opcao);
       ?>
    </td>
    <td>
       <?
        db_input('l20_liclocal',10,$Il20_liclocal,true,'text',$db_opcao," onchange='js_pesquisal20_liclocal(false);'")
       ?>
       <?=@$Ll03_usaregistropreco?>
       <?
       if (!isset($l20_usaregistropreco)) {
        $l20_usaregistropreco = "f";
       }
       db_select("l20_usaregistropreco",array("t"=>"Sim", "f"=>"Não"),true,$db_opcao,"onchange='js_registropreco(this.value);'");
    ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_liccomissao?>">
       <?
        db_ancora(@$Ll20_liccomissao,"js_pesquisal20_liccomissao(true);",$db_opcao);
       ?>
    </td>
    <td>
       <?
        db_input('l20_liccomissao',10,$Il20_liccomissao,true,'text',$db_opcao," onchange='js_pesquisal20_liccomissao(false);'")
       ?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tl20_equipepregao?>">
       <?
        db_ancora(@$Ll20_equipepregao,"js_pesquisal20_equipepregao(true);",$db_opcao);
       ?>
    </td>
    <td>
       <?
        db_input('l20_equipepregao',10,$Il20_equipepregao,true,'text',$db_opcao," onchange='js_pesquisal20_equipepregao(false);'");
       ?>
    </td>
  </tr>

  <tr>
    <td>
      <b>Processo do Sistema:</b>
    </td>
    <td>
      <?
         $aProcSistema = array("s"=>"Sim",
                               "n"=>"Não");
         db_select('lprocsis',$aProcSistema,true,$db_opcao,"onChange='js_mudaProc(this.value);'");
      ?>
    </td>
  </tr>

  <tr id="procSis">
    <td nowrap title="<?=@$Tl34_protprocesso?>">
       <?
         db_ancora($Ll34_protprocesso,"js_pesquisal34_protprocesso(true);",$db_opcao);
       ?>
    </td>
    <td>
       <?
         db_input('p58_numero', 15, $Ip58_numero, true, 'text', $db_opcao,"onChange='js_pesquisal34_protprocesso(false);'");
         db_input('l34_protprocesso', 15, $Il34_protprocesso, true, 'hidden', $db_opcao);
         db_input('l34_protprocessodescr',45,"",  true,'text',3,"");
       ?>
    </td>
  </tr>

</table>
</fieldset>

<fieldset class="fieldsetinterno">
<legend><b>Outras Informações</b></legend>

<table>
 <tr>
    <td nowrap title="<?=@$Tl20_local?>">
       <?=@$Ll20_local?>
    </td>
    <td>
       <?
        db_textarea('l20_local',0,57,$Il20_local,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>

    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_objeto?>">
       <?=@$Ll20_objeto?>
    </td>
    <td>
       <?
        db_textarea('l20_objeto',0,57,$Il20_objeto,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_localentrega?>">
       <?=@$Ll20_localentrega?>
    </td>
    <td>
       <?
        db_textarea('l20_localentrega',0,57,$Il20_localentrega,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>
 <tr>
    <td nowrap title="<?=@$Tl20_prazoentrega?>">
       <?=@$Ll20_prazoentrega?>
    </td>
    <td>
       <?
        db_textarea('l20_prazoentrega',0,57,$Il20_prazoentrega,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>
  <tr>
    <td nowrap title="<?=@$Tl20_condicoespag?>">
       <?=@$Ll20_condicoespag?>
    </td>
    <td>
       <?
        db_textarea('l20_condicoespag',0,57,$Il20_condicoespag,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_validadeproposta?>">
       <?=@$Ll20_validadeproposta?>
    </td>
    <td>
       <?
        db_textarea('l20_validadeproposta',0,57,$Il20_validadeproposta,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>


 <tr>
    <td nowrap title="<?=@$Tl20_clausulapro?>">
       <?=@$Ll20_clausulapro?>
    </td>
    <td>
       <?
        db_textarea('l20_clausulapro',0,57,$Il20_clausulapro,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>


 <tr>
    <td nowrap title="<?=@$Tl20_aceitabilidade?>">
       <b>Critério de Aceitabilidade:</b>
    </td>
    <td>
       <?
        db_textarea('l20_aceitabilidade',0,57,$Il20_aceitabilidade,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>

   </table>
  </fieldset>

  <fieldset>
<legend><b>Dispensa/Inexigibilidade</b></legend>

<table>


  <tr>
    <td nowrap title="<?=@$Tl20_tipoprocesso?>">
       <?=@$Ll20_tipoprocesso?>
    </td>
    <td>
       <?
         $al20_tipoprocesso = array("0"=>"","1"=>"1-Dispensa","2"=>"2-Inexigibilidade","3"=>"3-Inexigibilidade por credenciamento/chamada pública","4"=>"4-Dispensa por chamada publica");
        db_select("l20_tipoprocesso",$al20_tipoprocesso,true,$db_opcao);
       ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_dtpubratificacao?>">
       <b>Data Publicação Termo Ratificação:</b>
    </td>
    <td>
       <?//echo $l20_dtpubratificacao;exit;
        db_inputdata('l20_dtpubratificacao',@$l20_dtpubratificacao_dia,@$l20_dtpubratificacao_mes,@$l20_dtpubratificacao_ano,true,'text',55,"");
       ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_veicdivulgacao?>">
       <b>Veiculo de Divulgação:</b>
    </td>
    <td>
       <?
        db_textarea('l20_veicdivulgacao',0,53,$Il20_veicdivulgacao,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_justificativa?>">
       <?=@$Ll20_justificativa?>
    </td>
    <td>
       <?
        db_textarea('l20_justificativa',0,53,$Il20_justificativa,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>

 <tr>
    <td nowrap title="<?=@$Tl20_razao?>">
       <?=@$Ll20_razao?>
    </td>
    <td>
       <?
        db_textarea('l20_razao',0,53,$Il20_razao,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
       ?>
    </td>
 </tr>

   </table>
  </fieldset>



</fieldset>

</td></tr>
</table>

  </center>

<input name="<?=($db_opcao==1?'incluir':($db_opcao==2||$db_opcao==22?'alterar':'excluir'))?>" type="submit" id="db_opcao"
       value="<?=($db_opcao==1?'Incluir':($db_opcao==2||$db_opcao==22?'Alterar':'Excluir'))?>"
       <?=($db_botao==false?'disabled':'') ?>  onClick="return js_confirmadatas()">
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
js_busca();


function js_registropreco(campo){
	if(campo==1){
		$('l20_tipnaturezaproced').value='2';
	}
}


// alterando a função padrao para verificar  as opçoes de convite e de INEXIGIBILIDADE
function js_ProcCod_l20_codtipocom(proc,res) {

    var sel1 = document.forms[0].elements[proc];
    var sel2 = document.forms[0].elements[res];
    for(var i = 0;i < sel1.options.length;i++) {
	 if(sel1.options[sel1.selectedIndex].value == sel2.options[i].value)
	   sel2.options[i].selected = true;
	 }
// ajax para fazer consulta sql, retornando o codigo do tribunal
    var codigocompra = document.getElementById("l20_codtipocom").options[document.getElementById("l20_codtipocom").selectedIndex].text;
    var oParam                = new Object();
    oParam.codigo =  codigocompra;
    var url       = 'lic1_liclicita_consulta.php';
    var oAjax                 = new Ajax.Request(url,
                                                    {method:'post',
                                                     parameters:'json='+Object.toJSON(oParam),
                                                     onComplete:js_retornolicitacao
                                                    }
                                                   );

 }


 function js_retornolicitacao(oAjax){


	 var oRetorno = eval("("+oAjax.responseText+")");
	 var campo  = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;

	     // verifica se e do tipo convite
		if(oRetorno.tribunal==30){
			document.form1.l20_numeroconvidado.style.backgroundColor='#FFFFFF';
			document.getElementById("l20_numeroconvidado").readOnly=false;
		}else{
				document.form1.l20_numeroconvidado.style.backgroundColor='#E6E4F1';
				$("l20_numeroconvidado").value="";
				document.getElementById("l20_numeroconvidado").readOnly=true;

			  }
		if(oRetorno.tribunal==100 || oRetorno.tribunal==101 || oRetorno.tribunal==102){


			document.form1.l20_justificativa.style.backgroundColor='#FFFFFF ';
			document.form1.l20_dtpubratificacao.style.backgroundColor='#FFFFFF ';
			document.form1.l20_veicdivulgacao.style.backgroundColor='#FFFFFF ';
			document.form1.l20_justificativa.style.backgroundColor='#FFFFFF ';
			document.form1.l20_razao.style.backgroundColor='#FFFFFF ';

			document.getElementById("l20_veicdivulgacao").disabled=false;
			document.getElementById("l20_dtpubratificacao").disabled=false;
			document.getElementById("l20_justificativa").disabled=false;
			document.getElementById("l20_razao").disabled=false;
			document.getElementById("l20_tipoprocesso").disabled=false;
			//document.getElementById("l20_dtpubratificacao").value='';

		}else{

			document.getElementById("l20_veicdivulgacao").disabled=true;
			document.getElementById("l20_dtpubratificacao").disabled=true;
			document.getElementById("l20_justificativa").disabled=true;
			document.getElementById("l20_razao").disabled=true;
			document.getElementById("l20_tipoprocesso").disabled=true;
			//document.getElementById("l20_dtpubratificacao").value='';

			 /*document.form1.l20_dtpubratificacao.style.backgroundColor='#E6E4F1';)*/
			  }
	}
	/*adequando os campos para evitar  o preenchimento pelo usuario caso nao seja um tipo de  INEXIGIBILIDADE*/
	document.getElementById("l20_veicdivulgacao").disabled=true;
	document.getElementById("l20_dtpubratificacao").disabled=true;
	document.getElementById("l20_justificativa").disabled=true;
	document.getElementById("l20_razao").disabled=true;
	document.getElementById("l20_tipoprocesso").disabled=true;
	//document.getElementById("l20_dtpubratificacao").value='';

	/*para habiliatar o campo caso seja inex*/

	 var campo  = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;
	    campo=campo.replace(" ", "");
	    if(oRetorno.tribunal==100 || oRetorno.tribunal==101 || oRetorno.tribunal==102){
		    document.getElementById("l20_veicdivulgacao").disabled=false;
			document.getElementById("l20_dtpubratificacao").disabled=false;
			document.getElementById("l20_justificativa").disabled=false;
			document.getElementById("l20_razao").disabled=false;
			document.getElementById("l20_tipoprocesso").disabled=false;
			document.getElementById("l20_dtpubratificacao").value='';

			document.form1.l20_justificativa.style.backgroundColor='#FFFFFF ';
			document.form1.l20_dtpubratificacao.style.backgroundColor='#FFFFFF ';
			document.form1.l20_veicdivulgacao.style.backgroundColor='#FFFFFF ';
			document.form1.l20_justificativa.style.backgroundColor='#FFFFFF ';
			document.form1.l20_razao.style.backgroundColor='#FFFFFF ';

 }

function js_busca(){

	    var codigocompra = document.getElementById("l20_codtipocom").options[document.getElementById("l20_codtipocom").selectedIndex].text;
	    var oParam                = new Object();
	    oParam.codigo =  codigocompra;
	    var url       = 'lic1_liclicita_consulta.php';
	    var oAjax                 = new Ajax.Request(url,
	                                                    {method:'post',
	                                                     parameters:'json='+Object.toJSON(oParam),
	                                                     onComplete:js_retornolicitacao
	                                                    }
	                                                   );
}



function js_naturezaprocedimento(valor){
	if(valor==2){
		$('l20_usaregistropreco').value='t';
		$('l20_usaregistropreco').disabled="disabled";

	}
}

function js_ativaregistro(){

	var campo=$(l20_tipnaturezaproced).value;
	$('l20_usaregistropreco').disabled="";
	var campo         = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;
	var convite       =document.getElementById('l20_numeroconvidado').value;

	document.getElementById('descricao').value=campo;
	document.form1.submit();

}



function js_verifica_hora(valor,campo) {
	  erro= 0;
	  ms  = "";
	  hs  = "";

	  tam = "";
	  pos = "";
	  tam = valor.length;
	  pos = valor.indexOf(":");
	  if (pos!=-1) {
	    if (pos==0 || pos>2) {
	      erro++;
	    } else {
	      if (pos==1) {
	        hs = "0"+valor.substr(0,1);
	        ms = valor.substr(pos+1,2);
	      } else if (pos==2) {
	        hs = valor.substr(0,2);
	        ms = valor.substr(pos+1,2);
	      }
	      if (ms=="") {
	        ms = "00";
	      }
	    }
	  } else {
	    if (tam>=4) {
	      hs = valor.substr(0,2);
	      ms = valor.substr(2,2);
	    } else if (tam==3) {
	      hs = "0"+valor.substr(0,1);
	      ms = valor.substr(1,2);
	    } else if (tam==2) {
	      hs = valor;
	      ms = "00";
	    } else if (tam==1) {
	      hs = "0"+valor;
	      ms = "00";
	    }
	  }
	  if (ms!="" && hs!="") {
	    if (hs>24 || hs<0 || ms>60 || ms<0) {
	      erro++
	    } else {
	      if (ms==60) {
	        ms = "59";
	      }
	      if (hs==24) {
	        hs = "00";
	      }
	      hora = hs;
	      minu = ms;
	    }
	  }

	  if (erro>0) {
	    alert("Informe uma hora válida.");
	  }
	  if (valor!="") {
	    eval("document.form1."+campo+".focus();");
	    eval("document.form1."+campo+".value='"+hora+":"+minu+"';");
	  }
	}





function js_mudaProc(sTipoProc){

  if ( sTipoProc == 's') {
    $('procSis').style.display = '';
    $('procAdm').style.display = 'none';
  } else {
    $('procSis').style.display = 'none';
    $('procAdm').style.display = '';
  }

}

function js_pesquisal20_codtipocom(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_pctipocompra','func_pctipocompra.php?funcao_js=parent.js_mostrapctipocompra1|pc50_codcom|pc50_descr','Pesquisa',true,0);
  }else{
     if(document.form1.l20_codtipocom.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pctipocompra','func_pctipocompra.php?pesquisa_chave='+document.form1.l20_codtipocom.value+'&funcao_js=parent.js_mostrapctipocompra','Pesquisa',false);
     }else{
       document.form1.pc50_descr.value = '';
     }
  }
}
function js_mostrapctipocompra(chave,erro){
  document.form1.pc50_descr.value = chave;
  if(erro==true){
    document.form1.l20_codtipocom.focus();
    document.form1.l20_codtipocom.value = '';
  }
}
function js_mostrapctipocompra1(chave1,chave2){
  document.form1.l20_codtipocom.value = chave1;
  document.form1.pc50_descr.value = chave2;
  db_iframe_pctipocompra.hide();
}
function js_pesquisal20_id_usucria(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_db_usuarios','func_db_usuarios.php?funcao_js=parent.js_mostradb_usuarios1|id_usuario|nome','Pesquisa',true,0);
  }else{
     if(document.form1.l20_id_usucria.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_usuarios','func_db_usuarios.php?pesquisa_chave='+document.form1.l20_id_usucria.value+'&funcao_js=parent.js_mostradb_usuarios','Pesquisa',false);
     }else{
       document.form1.nome.value = '';
     }
  }
}
function js_mostradb_usuarios(chave,erro){
  document.form1.nome.value = chave;
  if(erro==true){
    document.form1.l20_id_usucria.focus();
    document.form1.l20_id_usucria.value = '';
  }
}
function js_mostradb_usuarios1(chave1,chave2){
  document.form1.l20_id_usucria.value = chave1;
  document.form1.nome.value = chave2;
  db_iframe_db_usuarios.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?tipo=1&funcao_js=parent.js_preenchepesquisa|l20_codigo','Pesquisa',true,"0");
}
function js_preenchepesquisa(chave){
	//chave);
  db_iframe_liclicita.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
    ?>
   parent.iframe_liclicitem.location.href='lic1_liclicitemalt001.php?licitacao='+chave;
   <?
  }
  ?>
}

function js_pesquisal20_liclocal(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_local','func_liclocal.php?funcao_js=parent.js_mostralocal1|l26_codigo','Pesquisa',true,"0");
  }else{
         if(document.form1.l20_liclocal.value != ''){
              js_OpenJanelaIframe('','db_iframe_local','func_liclocal.php?pesquisa_chave='+document.form1.l20_liclocal.value+'&funcao_js=parent.js_mostralocal&sCampoRetorno=l20_liclocal','Pesquisa',false);
            } else {
              document.form1.nome.value = '';
            }
  }
}

function js_mostralocal(chave,erro){
  if(erro==true){
    document.form1.l20_liclocal.focus();
    document.form1.l20_liclocal.value = '';
  }
}
function js_mostralocal1(chave1){
  document.form1.l20_liclocal.value = chave1;
  db_iframe_local.hide();
}
function js_pesquisal20_liccomissao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_comissao','func_liccomissao.php?funcao_js=parent.js_mostracomissao1|l30_codigo','Pesquisa',true,"0");
  }else{

        if(document.form1.l20_liccomissao.value != ''){
              js_OpenJanelaIframe('','db_iframe_proc','func_liccomissao.php?pesquisa_chave='+document.form1.l20_liccomissao.value+'&funcao_js=parent.js_mostracomissao&sCampoRetorno=l20_liccomissao','Pesquisa',false);
            } else {
              document.form1.l20_liccomissao.value = '';
            }



  }
}
function js_mostracomissao(chave,erro){
  if(erro==true){
    document.form1.l20_liccomissao.focus();
    document.form1.l20_liccomissao.value = '' ;
  }
}
function js_mostracomissao1(chave1){
  document.form1.l20_liccomissao.value = chave1;
  db_iframe_comissao.hide();
}

function js_pesquisal34_protprocesso(mostra){

  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_proc','func_protprocesso_protocolo.php?funcao_js=parent.js_mostraprocesso1|p58_numero|dl_código_processo|dl_nome_ou_razão_social','Pesquisa',true,"0");
  } else {

    if(document.form1.p58_numero.value != ''){
      js_OpenJanelaIframe('','db_iframe_proc','func_protprocesso_protocolo.php?pesquisa_chave='+document.form1.p58_numero.value+'&funcao_js=parent.js_mostraprocesso&sCampoRetorno=p58_codproc','Pesquisa',false);
    } else {
      document.form1.l34_protprocessodescr.value = '';
    }
  }
}

function js_mostraprocesso(iCodigoProcesso, sNome, lErro){

  document.form1.l34_protprocessodescr.value = sNome;

  if (lErro ){

    document.form1.p58_numero.focus();
    document.form1.p58_numero.value = '';
    document.form1.l34_protprocesso.value = '';
    return false;
  }

  document.form1.l34_protprocesso.value = iCodigoProcesso;

  db_iframe_proc.hide();
}

function js_mostraprocesso1(iNumeroProcesso, iCodigoProcesso, sNome) {

  document.form1.p58_numero.value            = iNumeroProcesso;
  document.form1.l34_protprocesso.value      = iCodigoProcesso;
  document.form1.l34_protprocessodescr.value = sNome;
  db_iframe_proc.hide();
}


// aqui
function js_pesquisal20_equipepregao(mostra){

  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_proc','func_licpregao.php?funcao_js=parent.js_pregao|l45_sequencial','Pesquisa',true,"0");
  } else {

    if(document.form1.l20_equipepregao.value != ''){
      js_OpenJanelaIframe('','db_iframe_proc','func_licpregao.php?pesquisa_chave='+document.form1.l20_equipepregao.value+'&funcao_js=parent.js_pregao&sCampoRetorno=l20_equipepregao','Pesquisa',false);
    } else {
      document.form1.nome.value = '';
    }
  }
}

//aqui
function js_pregao(iCodigoProcesso, sNome, lErro){

	  document.form1.l20_equipepregao.value = iCodigoProcesso;
	  db_iframe_proc.hide();
	}








var sUrl = "lic4_licitacao.RPC.php";
function js_mostraRegistroPreco(){

  js_divCarregando("Aguarde, pesquisando parametros","msgBox");
  var oParam            = new Object();
  oParam.exec           = "verificaParametros";
  oParam.itipoLicitacao = $F('l20_codtipocom');
  db_iframe_estimativaregistropreco.hide();
  var oAjax           = new Ajax.Request(sUrlRC,
                                         {
                                         method: "post",
                                         parameters:'json='+Object.toJSON(oParam),
                                         onComplete: js_retornoRegistroPreco
                                        });

}
function js_retornoRegistroPreco(oAjax) {

  js_removeObj("msgBox");
  var oRetorno = eval("("+oAjax.responseText+")");
  if (oRetorno.status == 1) {
    //$()
  }
}

function js_confirmadatas() {

  var dataCriacao    = $F('l20_datacria');
  var dataPublicacao = $F('l20_dtpublic');
  var dataAbertura   = $F('l20_dataaber');

  if( js_CompararDatas(dataCriacao, dataPublicacao, '<=') ) {
    if( js_CompararDatas(dataPublicacao, dataAbertura, '<=') ) {
      <?
        if($db_opcao==2 || $db_opcao==22) {
        	echo 'return js_confirmar();';
        } else {
        	echo 'return true;';
        }
      ?>
    } else {

      /*alert("A Data Edital/Convite deve ser maior ou igual a Data de Publicação.");
      document.form1.l20_dataaber.style.backgroundColor='#99A9AE';
       document.form1.l20_dataaber.focus();
      return false;*/
    }
  } else {
    /*alert("A Data de Publicação deve ser maior ou igual a Data de Criação.");
    return false;*/
  }

}

function js_CompararDatas(data1,data2,comparar){

  if (data1.indexOf('/') != -1){
    datepart = data1.split('/');
    pYear    = datepart[2];
    pMonth   = datepart[1];
    pDay     = datepart[0];
  }
    data1 = pYear+pMonth+pDay;

  if (data2.indexOf('/') != -1){
    datepart = data2.split('/');
    pYear    = datepart[2];
    pMonth   = datepart[1];
    pDay     = datepart[0];
  }
    data2 = pYear+pMonth+pDay;
    if (eval(data1+" "+comparar+" "+data2)) {

       return true;

     }else{
      return false;
     }
}


/*Para desabilitar o combo 	Usa Registro de Preço */
var campo=$(l20_tipnaturezaproced).value;
if(campo=='2'){
	$('l20_usaregistropreco').value='t';
	$('l20_usaregistropreco').disabled="disabled";
}

/*
 *devido a maioria dos usuarios do sistema possuirem  os dados adicionais como não , automaticamente o sistema seta como nao
 */
 document.getElementById('l20_critdesempate').value = 2;
 document.getElementById('l20_destexclusiva').value = 2;
 document.getElementById('l20_subcontratacao').value = 2;
 document.getElementById('l20_limitcontratacao').value = 2;
 document.getElementById('l20_naturezaobjeto').value = 2;

 $('l20_descontotab').value='2';


 document.form1.l20_dtpubratificacao.style.backgroundColor='#E6E4F1';
 document.form1.l20_veicdivulgacao.style.backgroundColor='#E6E4F1';
 document.form1.l20_justificativa.style.backgroundColor='#E6E4F1';
 document.form1.l20_razao.style.backgroundColor='#E6E4F1';
 document.getElementById("l20_numeroconvidado").readOnly=true;

 var campo  = document.getElementById("l20_codtipocomdescr").options[document.getElementById("l20_codtipocomdescr").selectedIndex].text;
 if(campo=="CONVITE"){
  alert('teste');
		document.getElementById("l20_numeroconvidado").readOnly=false;
 }



/*Função para limitar texaarea*/
 //"onkeyup='limitaTextarea(this.value);'");
 function limitaTextarea(valor){
	 var qnt = valor.value;
		quantidade = 80;
		total = qnt.length;

		if(total <= quantidade) {
			resto = quantidade- total;
			document.getElementById('contador').innerHTML = resto;
		} else {
			document.getElementById(valor.name).value = qnt.substr(0, quantidade);
			alert("Olá. Para atender  as normas do TCE MG / SICOM, este campo é  limitado. * LIMITE ALCANÇADO * !");
		}
	}



<?
  if($db_opcao == 1) {
  	echo "js_mudaProc('{$lprocsis}');";
  } else {
    if ( (isset($l34_protprocesso) && trim($l34_protprocesso) != '') ) {
      echo "js_mudaProc('s');";
    }
  }
?>


</script>
<?
if ( empty($l34_liclicita)) {
  echo "<script>
         document.form1.lprocsis.value = 'n';
         $('procSis').style.display = 'none';
         $('procAdm').style.display = '';
        </script>";
}
?>
