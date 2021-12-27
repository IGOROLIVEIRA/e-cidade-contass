<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: compras
$clpcforne->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
if($db_opcao==1){
 $db_action="com1_pcforne004.php";
}else if($db_opcao==2||$db_opcao==22){
 $db_action="com1_pcforne005.php";
}else if($db_opcao==3||$db_opcao==33){
 $db_action="com1_pcforne006.php";
}

$clcgm = new cl_cgm();
$rsCgm = db_query($clcgm->sql_query_file(NULL,"z01_cgccpf as pc60_cnpjcpf, z01_incest as pc60_inscriestadual", NULL, "z01_numcgm = $pc60_numcgm"));
db_fieldsmemory($rsCgm, 0);
?>
<form name="form1" method="post" action="<?=$db_action?>">
  <center>
    <table border="0">
      <tr>
        <td nowrap title="<?=@$Tpc60_numcgm?>">
         <?
         db_ancora(@$Lpc60_numcgm,"js_pesquisapc60_numcgm(true);",($db_opcao==1?$db_opcao:3));
         ?>
       </td>
       <td>
        <?
        db_input('pc60_numcgm',8,$Ipc60_numcgm,true,'text',($db_opcao==1?$db_opcao:3)," onchange='js_pesquisapc60_numcgm(false);'")
        ?>
        <?
        db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
        ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tpc60_dtlanc?>">
       <?=@$Lpc60_dtlanc?>
     </td>
     <td>
      <?
      db_inputdata('pc60_dtlanc',date("d",db_getsession("DB_datausu")),date("m",db_getsession("DB_datausu")),date("Y",db_getsession("DB_datausu")),true,'text',3,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc60_obs?>">
     <?=@$Lpc60_obs?>
   </td>
   <td>
    <?
    db_textarea('pc60_obs',2,80,$Ipc60_obs,true,'text',$db_opcao,"",'','#FFFFFF')
    ?>
  </td>
</tr>
<tr>
  <td nowrap title="<?=@$Tpc60_bloqueado?>">
   <?=@$Lpc60_bloqueado?>
 </td>
 <td>
  <?
  $x = array("f"=>"NAO","t"=>"SIM");
  db_select('pc60_bloqueado',$x,true,$db_opcao,"onchange='js_verificabloqueio();'");
  ?>
</td>
</tr>

  <tr id="databloqueado">
      <td nowrap title="Data de Bloqueio">
       <b>Per�odo de bloqueio</b>

     </td>
     <td>
      <?php
        db_inputdata('pc60_databloqueio_ini',$pc60_databloqueio_ini_dia,$pc60_databloqueio_ini_mes,$pc60_databloqueio_ini_ano,true,'text',1,"");
      ?> a
      <?php
        db_inputdata('pc60_databloqueio_fim',$pc60_databloqueio_fim_dia,$pc60_databloqueio_fim_mes,$pc60_databloqueio_fim_ano,true,'text',1,"");
      ?>
    </td>
  </tr>

  <tr id="motivobloqueado">
      <td nowrap title="Motivo de bloqueio">
       <b>Motivo de bloqueio</b>
     </td>
     <td>
      <?php db_textarea('pc60_motivobloqueio',2,80,null,true,'text',1,"",'','#FFFFFF') ?>
    </td>
  </tr>

<tr>
  <td nowrap title="<?=@$Tpc60_orgaoreg?>">
   <?=@$Lpc60_orgaoreg?>
 </td>
 <td>
  <?
//db_input('pc60_orgaoreg',10,$Ipc60_orgaoreg,true,'text',$db_opcao,"")
  $x = array("0"=>"Selecione",
             "1"=>"Cart�rio de Registro Civil de Pessoas Jur�dicas",
             "2"=>"Junta Comercial",
             "3"=>"Ordem dos Advogados do Brasil-OAB",
             "4"=>"Portal do Empreendedor (MEI)");
  db_select("pc60_orgaoreg",$x,true,$db_opcao,"onchange = 'js_verificaorgaoreg()';");

  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tpc60_dtreg?>">
   <strong>Data do Registro no Org�o: </strong>
 </td>
 <td>
  <?
  db_inputdata('pc60_dtreg',@$pc60_dtreg_dia,@$pc60_dtreg_mes,@$pc60_dtreg_ano,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tpc60_numeroregistro?>">
   <strong>N�mero Registro no Org�o: </strong>
 </td>
 <td>
  <?
  db_input('pc60_numeroregistro',20,$Ipc60_numeroregistro,true,'text',$db_opcao,"",'','#FFFFFF')
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tpc60_cnpjcpf?>">
   <?=@$Lpc60_cnpjcpf?>
 </td>
 <td>
  <?
  db_input('pc60_cnpjcpf',14,$Ipc60_cnpjcpf,true,'text',3,"",'','#FFFFFF')
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tpc60_dtreg_cvm?>">
   <strong>Data do Registro CVM: </strong>
 </td>
 <td>
  <?
  db_inputdata('pc60_dtreg_cvm',@$pc60_dtreg_cvm_dia,@$pc60_dtreg_cvm_mes,@$pc60_dtreg_cvm_ano,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
    <td nowrap title="<?=@$Tz01_email?>">
      <strong>Email:</strong>
    </td>
    <td>
      <?
      db_input('z01_email',40,$Iz01_email,true,'text',$db_opcao,'');
      ?>
    </td>
  </tr>
<tr>
<tr>
    <td nowrap title="<?=@$Tz01_telef?>">
      <strong>Telefone:</strong>
    </td>
    <td>
      <?
      db_input('z01_telef',40,$Iz01_telef,true,'text',$db_opcao,'');
      ?>
    </td>
  </tr>
<tr>
  <td nowrap title="<?=@$Tpc60_numerocvm?>">
   <?=@$Lpc60_numerocvm?>
 </td>
 <td>
  <?
  db_input('pc60_numerocvm',20,$Ipc60_numerocvm,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tpc60_inscriestadual?>">
   <?=@$Lpc60_inscriestadual?>
 </td>
 <td>
  <?
  db_input('pc60_inscriestadual',50,$Ipc60_inscriestadual,true,'text',3,"")
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?=@$Tpc60_uf?>">
   <?=@$Lpc60_uf?>
 </td>
 <td>
  <?
  $x = array(""=>"Selecione...","AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amap�","BA"=>"Bahia","CE"=>"Cear�","DF"=>"Distrito Federal","ES"=>"Esp�rito Santo","GO"=>"Goi�s","MA"=>"Maranh�o","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Par�","PB"=>"Para�ba","PR"=>"Paran�","PE"=>"Pernambuco","PI"=>"Piau�","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rond�nia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"S�o Paulo","TO"=>"Tocantins");
  db_select('pc60_uf',$x,true,$db_opcao,"",'','#FFFFFF');
//db_input('pc60_uf',2,$Ipc60_uf,true,'text',$db_opcao,"",'','#FFFFFF')
  ?>
</td>
<td>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>"  type="hidden"  value="">
</td>
</tr>

</table>
</center>
<input type="button" onclick="js_submit()" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
  js_verificabloqueio();

  function js_verificabloqueio(){

    if(document.form1.pc60_bloqueado.value=='f'){
      document.getElementById('databloqueado').style.display='none';
      document.getElementById('motivobloqueado').style.display='none';
    }else{
      document.getElementById('databloqueado').style.display='';
      document.getElementById('motivobloqueado').style.display='';
    }
    return true;
  }
  function js_submit() {
    if(document.form1.pc60_bloqueado.value == 't'){
      if(document.form1.pc60_databloqueio_ini.value == ""){
        alert("Preencha o per�odo inicial do bloqueio.");
        return false;
      }
      if(document.form1.pc60_databloqueio_fim.value == ""){
        alert("Preencha o per�odo final do bloqueio.");
        return false;
      }
      if(document.form1.pc60_motivobloqueio.value==""){
        alert("Preencha o motivo do bloqueio.") ;
        return false;
      }
    }
    document.form1.submit();
  }
  function js_pesquisapc60_numcgm(mostra){
    if(mostra==true){
      js_OpenJanelaIframe('top.corpo.iframe_pcforne','db_iframe_nomes','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome|z01_cgccpf|z01_incest|z01_uf|z01_email|z01_telef','Pesquisa',true,'0');
    }else{
     if(document.form1.pc60_numcgm.value != ''){
      js_OpenJanelaIframe('top.corpo.iframe_pcforne','db_iframe_nomes','func_nome.php?filtro=4&pesquisa_chave='+document.form1.pc60_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1','775','390');
    }else{
     document.form1.z01_nome.value = '';
   }
 }
}
function js_mostracgm(erro,chave,cpf,incest,uf,email,telefone){
  document.form1.z01_nome.value = chave;
  document.form1.pc60_cnpjcpf.value = cpf;
  document.form1.pc60_inscriestadual.value = incest;
  document.form1.pc60_uf.value = uf;
  document.form1.z01_email.value = email;
  document.form1.z01_telef.value = telefone;

  if(erro==true){
    document.form1.pc60_numcgm.focus();
    document.form1.pc60_numcgm.value = '';
    document.form1.pc60_cnpjcpf.value = '';
    document.form1.pc60_inscriestadual.value = '';
  }
}
function js_mostracgm1(chave1,chave2,cpf,incest, uf,email,telefone){
  document.form1.pc60_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  document.form1.pc60_cnpjcpf.value = cpf;
  document.form1.pc60_inscriestadual.value = incest
  document.form1.pc60_uf.value = uf;
  document.form1.z01_email.value = email;
  document.form1.z01_telef.value = telefone;

  if(document.form1.pc60_cnpjcpf.value.length == 11) {
    document.form1.pc60_obs.style.background = '#e6e4f1';
  }else{
    document.form1.pc60_obs.style.background = '#ffffff';
  }

  db_iframe_nomes.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_pcforne','db_iframe_pcforne','func_pcforne.php?funcao_js=parent.js_preenchepesquisa|pc60_numcgm','Pesquisa',true,'0','1');
}
function js_preenchepesquisa(chave){
  db_iframe_pcforne.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
function js_verificaorgaoreg() {
   let orgreg = document.form1.pc60_orgaoreg.value;

   if(orgreg == 4){
       document.form1.pc60_numeroregistro.style.background = '#DEB887';
       document.form1.pc60_numeroregistro.disabled = true;
   }else{
       document.form1.pc60_numeroregistro.disabled = false;
       document.form1.pc60_numeroregistro.style.background = '#ffffff';

   }
}
  js_verificaorgaoreg();
</script>
