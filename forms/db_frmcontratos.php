<?
require("libs/db_app.utils.php");
include("classes/db_pcforne_classe.php");
include("classes/db_pcfornecon_classe.php");
include("classes/db_pcfornemov_classe.php");
include("classes/db_pcfornecert_classe.php");
$clpcforne = new cl_pcforne;

$clpcforne->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");

$clcgm = new cl_cgm();
$rsCgm = db_query($clcgm->sql_query_file(NULL,"z01_cgccpf as pc60_cnpjcpf, z01_incest as pc60_inscriestadual", NULL, "z01_numcgm = $pc60_numcgm"));
db_fieldsmemory($rsCgm, 0);

//MODULO: sicom
$clcontratos->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc21_codorc");
$clrotulo->label("l20_codigo");
      if($db_opcao==1){
     $db_action="sic1_contratos004.php";
      }else if($db_opcao==2||$db_opcao==22){
     $db_action="sic1_contratos005.php";
      }else if($db_opcao==3||$db_opcao==33){
     $db_action="sic1_contratos006.php";
      }
?>
<form name="form1" method="post" action="<?=$db_action?>" onsubmit="return verificatipo()">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi172_sequencial?>">
       <?=@$Lsi172_sequencial?>
    </td>
    <td>
<?
db_input('si172_sequencial',10,$Isi172_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_nrocontrato?>">
       <?=@$Lsi172_nrocontrato?>
    </td>
    <td>
<?
db_input('si172_nrocontrato',14,$Isi172_nrocontrato,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_exerciciocontrato?>">
       <?=@$Lsi172_exerciciocontrato?>
    </td>
    <td>
<?
if (empty($si172_exerciciocontrato)) {
  $si172_exerciciocontrato = db_getsession("DB_anousu");
}
db_input('si172_exerciciocontrato',4,$Isi172_exerciciocontrato,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td id="campolicitacao" nowrap title="<?=@$Tsi172_licitacao?>">
       <?
       db_ancora(@$Lsi172_licitacao,"js_pesquisasi172_licitacao(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('si172_licitacao',10,$Isi172_licitacao,true,'text',3," onchange='js_pesquisasi172_licitacao(false);'")
?>
       <?
db_input('l20_codigo',40,$Il20_codigo,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_dataassinatura?>">
       <?=@$Lsi172_dataassinatura?>
    </td>
    <td>
<?
db_inputdata('si172_dataassinatura',@$si172_dataassinatura_dia,@$si172_dataassinatura_mes,@$si172_dataassinatura_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

   <tr>
    <td nowrap title="<?=@$Tpc60_numcgm?>">
       <?
       db_ancora(@$Lpc60_numcgm,"js_pesquisapc60_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td>
      <?
        db_input('si172_fornecedor',8,$Ipc60_numcgm,true,'text',$db_opcao," onchange='js_pesquisapc60_numcgm(false);'")
      ?>
       <?
        db_input('z01_nome', 50, $Iz01_nome, true, 'text', 3, '')
       ?>
    </td>
  </tr>


  <tr>
    <td nowrap title="<?=@$Tsi172_contdeclicitacao?>">
       <?=@$Lsi172_contdeclicitacao?>
    </td>
    <td>
<?
$x = array("1"=>"Não ou dispensa por valor","2"=>"Licitação","3"=>"Dispensa ou Inexigibilidade","4"=>"Adesão à ata de registro de preços","5"=>"Licitação realizada por outro órgão ou entidade","6"=>"Dispensa ou Inexigibilidade realizada por outro órgão",
  "7"=>"Licitação - Regime Diferenciado de Contratações Públicas","8"=>"Licitação - Regime Diferenciado de Contratações Públicas");
db_select('si172_contdeclicitacao',$x,true,$db_opcao,"");
//db_input('si172_contdeclicitacao',1,$Isi172_contdeclicitacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_codunidadesubresp?>">
       <?=@$Lsi172_codunidadesubresp?>
    </td>
    <td>
<?

$sql = "select distinct d.coddepto,d.descrdepto,u.db17_ordem
            from db_depusu u
                 inner join db_depart d on u.coddepto = d.coddepto
           where instit = ".db_getsession("DB_instit")."
             and u.id_usuario = ".db_getsession("DB_id_usuario") . "
           and (d.limite is null or d.limite >= '" . date("Y-m-d",db_getsession("DB_datausu")) . "')

           order by u.db17_ordem ";

    $result = db_query($sql) or die($sql);
    db_selectrecord('si172_codunidadesubresp',$result,true,2,'','','','','');

//db_input('si172_codunidadesubresp',8,$Isi172_codunidadesubresp,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_nroprocesso?>">
       <?=@$Lsi172_nroprocesso?>
    </td>
    <td>
<?
db_input('si172_nroprocesso',12,$Isi172_nroprocesso,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_exercicioprocesso?>">
       <?=@$Lsi172_exercicioprocesso?>
    </td>
    <td>
<?
db_input('si172_exercicioprocesso',4,$Isi172_exercicioprocesso,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td id="campotipoprocesso" nowrap title="<?=@$Tsi172_tipoprocesso?>">
       <?=@$Lsi172_tipoprocesso?>
    </td>
    <td>
<?
$x = array("0"=>"","1"=>"Dispensa","2"=>"Inexigibilidade","3"=>"Inexigibilidade por credenciamento/chamada pública","4"=>"Dispensa por chamada publica");
db_select('si172_tipoprocesso',$x,true,$db_opcao,"");
//db_input('si172_tipoprocesso',1,$Isi172_tipoprocesso,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_naturezaobjeto?>">
       <?=@$Lsi172_naturezaobjeto?>
    </td>
    <td>
<?
$x = array("1"=>"Obras e Serviços de Engenharia","2"=>"Compras e serviços","3"=>"Locação","4"=>"Concessão","5"=>"Permissão");
db_select('si172_naturezaobjeto',$x,true,$db_opcao,"onchange='changeNaturezaObjeto()'");
//db_input('si172_naturezaobjeto',1,$Isi172_naturezaobjeto,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_objetocontrato?>">
       <?=@$Lsi172_objetocontrato?>
    </td>
    <td>
<?
db_textarea('si172_objetocontrato',8,40,$Isi172_objetocontrato,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_tipoinstrumento?>">
       <?=@$Lsi172_tipoinstrumento?>
    </td>
    <td>
<?
$x = array("1"=>"Contrato","2"=>"Termos de parceria/OSCIP","3"=>"Contratos de gestão","4"=>"Outros termos de parceria");
db_select('si172_tipoinstrumento',$x,true,$db_opcao,"");
//db_input('si172_tipoinstrumento',1,$Isi172_tipoinstrumento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_datainiciovigencia?>">
       <?=@$Lsi172_datainiciovigencia?>
    </td>
    <td>
<?
db_inputdata('si172_datainiciovigencia',@$si172_datainiciovigencia_dia,@$si172_datainiciovigencia_mes,@$si172_datainiciovigencia_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_datafinalvigencia?>">
       <?=@$Lsi172_datafinalvigencia?>
    </td>
    <td>
<?
db_inputdata('si172_datafinalvigencia',@$si172_datafinalvigencia_dia,@$si172_datafinalvigencia_mes,@$si172_datafinalvigencia_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_vlcontrato?>">
       <?=@$Lsi172_vlcontrato?>
    </td>
    <td>
<?
//$si172_vlcontrato = $clcontratos->sql_valorContratos($si172_fornecedor);

db_input('si172_vlcontrato',14,$Isi172_vlcontrato,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_formafornecimento?>">
       <?=@$Lsi172_formafornecimento?>
    </td>
    <td>
<?
db_input('si172_formafornecimento',50,$Isi172_formafornecimento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_formapagamento?>">
       <?=@$Lsi172_formapagamento?>
    </td>
    <td>
<?
db_input('si172_formapagamento',100,$Isi172_formapagamento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_prazoexecucao?>">
       <?=@$Lsi172_prazoexecucao?>
    </td>
    <td>
<?
db_input('si172_prazoexecucao',100,$Isi172_prazoexecucao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_multarescisoria?>">
       <?=@$Lsi172_multarescisoria?>
    </td>
    <td>
<?
db_input('si172_multarescisoria',100,$Isi172_multarescisoria,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_multainadimplemento?>">
       <?=@$Lsi172_multainadimplemento?>
    </td>
    <td>
<?
db_input('si172_multainadimplemento',100,$Isi172_multainadimplemento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_garantia?>">
       <?=@$Lsi172_garantia?>
    </td>
    <td>
<?
$x = array("1"=>"Caução em dinheiro","2"=>"Título da dívida pública","3"=>"Seguro garantia","4"=>"Fiança bancária","5"=>"Sem garantia");
db_select('si172_garantia',$x,true,$db_opcao,"");
//db_input('si172_garantia',1,$Isi172_garantia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_cpfsignatariocontratante?>">
       <?=@$Lsi172_cpfsignatariocontratante?>
    </td>
    <td>
<?
db_input('si172_cpfsignatariocontratante',11,$Isi172_cpfsignatariocontratante,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_datapublicacao?>">
       <?=@$Lsi172_datapublicacao?>
    </td>
    <td>
<?
db_inputdata('si172_datapublicacao',@$si172_datapublicacao_dia,@$si172_datapublicacao_mes,@$si172_datapublicacao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi172_veiculodivulgacao?>">
       <?=@$Lsi172_veiculodivulgacao?>
    </td>
    <td>
<?
db_input('si172_veiculodivulgacao',50,$Isi172_veiculodivulgacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

<?
$si172_instit = db_getsession("DB_instit");
db_input('si172_instit',10,$Isi172_instit,true,'hidden',$db_opcao,"")
?>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<input name="novo" type="button" id="novo" value="Novo" onclick="location.href='sic1_contratos004.php'" >
</form>
<script>
function js_pesquisapc60_numcgm(mostra){

  if(mostra==true){
	  if (document.form1.si172_licitacao.value != '') {
		  js_OpenJanelaIframe('','db_iframe_forneliccontrato','func_forneliccontrato.php?l20_codigo='+document.form1.si172_licitacao.value+'&funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0');
	  } else {
      js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0');
	  }
  }else{
     if(document.form1.si172_fornecedor.value != ''){
    	 if (document.form1.si172_licitacao.value != '') {
    		 js_OpenJanelaIframe('','db_iframe_nomes','func_forneliccontrato.php?l20_codigo='+document.form1.si172_licitacao.value+'&pesquisa_chave='+document.form1.si172_fornecedor.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1','775','390');
    	 } else {
         js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?pesquisa_chave='+document.form1.si172_fornecedor.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1','775','390');
    	 }
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(erro,chave,cpf,incest){
  document.form1.z01_nome.value = chave;

  if(erro==true){
    document.form1.si172_fornecedor.focus();
    document.form1.si172_fornecedor.value = '';
  }
}
function js_mostracgm1(chave1,chave2,cpf,incest){
  document.form1.si172_fornecedor.value = chave1;
  document.form1.z01_nome.value = chave2;

  if (document.form1.si172_licitacao.value != '') {
	  db_iframe_forneliccontrato.hide();
  } else {
    db_iframe_nomes.hide();
  }

}

function verificatipo(){
  if(document.form1.si172_contdeclicitacao.value == 3 || document.form1.si172_contdeclicitacao.value == 6 ){
    if(document.form1.si172_tipoprocesso.value == 0){
      alert('Campo Tiprocesso é obrigatório');
      return false;
    }
  }
}


function js_pesquisasi172_fornecedor(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_contratos','db_iframe_pcorcamforne','func_licitaforne.php?pesquisa_chave='+document.form1.si172_licitacao.value+'&funcao_js=parent.js_mostrapcorcamforne1|z01_numcgm|z01_nome','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.si172_fornecedor.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_contratos','db_iframe_pcorcamforne','func_licitaforne.php?pesquisa_chave='+document.form1.si172_fornecedor.value+'&funcao_js=parent.js_mostrapcorcamforne','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.pc21_codorc.value = '';
     }
  }
}
function js_mostrapcorcamforne(chave,erro){
  document.form1.pc21_codorc.value = chave;
  if(erro==true){
    document.form1.si172_fornecedor.focus();
    document.form1.si172_fornecedor.value = '';
  }
}
function js_mostrapcorcamforne1(chave1,chave2){
  document.form1.si172_fornecedor.value = chave1;
  document.form1.pc21_codorc.value = chave2;
  db_iframe_pcorcamforne.hide();
}
function js_pesquisasi172_licitacao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_contratos','db_iframe_liclicita','func_liclicitacontrato.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|pc50_descr|l20_anousu|l20_edital|l20_naturezaobjeto|l20_objeto|l20_tipoprocesso','Pesquisa',true,'0','1','1300','550');
  }else{
     if(document.form1.si172_licitacao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_contratos','db_iframe_liclicita','func_liclicitacontrato.php?pesquisa_chave='+document.form1.si172_licitacao.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false,'0','1','1300','550');
     }else{
       document.form1.l20_codigo.value = '';
     }
  }
}
function js_mostraliclicita(chave,erro){
  document.form1.l20_codigo.value = chave;
  if(erro==true){
    document.form1.si172_licitacao.focus();
    document.form1.si172_licitacao.value = '';
  }
}
function js_mostraliclicita1(l20_codigo,pc50_descr,l20_anousu,l20_edital,l20_naturezaobjeto,l20_objeto,l20_tipoprocesso){

  document.form1.si172_licitacao.value = l20_codigo;
  document.form1.l20_codigo.value = pc50_descr;
  document.form1.si172_exercicioprocesso.value = l20_anousu;
  document.form1.si172_nroprocesso.value = l20_edital;
  document.form1.si172_naturezaobjeto.value = l20_naturezaobjeto;
  document.form1.si172_objetocontrato.value = l20_objeto;

  document.form1.si172_fornecedor.value = '';
  document.form1.z01_nome.value = '';
  if( l20_tipoprocesso == '0'){
	    document.form1.si172_tipoprocesso.style.display= 'inline';
	    document.form1.si172_tipoprocesso.value = 0;
	    document.form1.si172_tipoprocesso.disabled= true;
	    document.getElementById("campotipoprocesso").style.display = 'inline';

	    document.getElementById("si172_contdeclicitacao").value = 2;
  }else if( l20_tipoprocesso == '1'){
    document.form1.si172_tipoprocesso.style.display= 'inline';
    document.form1.si172_tipoprocesso.value = 1;
    document.form1.si172_tipoprocesso.disabled= true;
    document.getElementById("campotipoprocesso").style.display = 'inline';

    document.getElementById("si172_contdeclicitacao").value = 3;
  }else if(l20_tipoprocesso == '2'){
    document.form1.si172_tipoprocesso.style.display= 'inline';
    document.form1.si172_tipoprocesso.value = 2;
    document.form1.si172_tipoprocesso.disabled= true;
    document.getElementById("campotipoprocesso").style.display = 'inline';

    document.getElementById("si172_contdeclicitacao").value = 3;
  }else if(l20_tipoprocesso == '3'){
    document.form1.si172_tipoprocesso.style.display= 'inline';
    document.form1.si172_tipoprocesso.value = 3;
    document.form1.si172_tipoprocesso.disabled= true;
    document.getElementById("campotipoprocesso").style.display = 'inline';

    document.getElementById("si172_contdeclicitacao").value = 3;
  }else if(l20_tipoprocesso == '4'){
    document.form1.si172_tipoprocesso.style.display= 'inline';
    document.form1.si172_tipoprocesso.value = 4;
    document.form1.si172_tipoprocesso.disabled= true;
    document.getElementById("campotipoprocesso").style.display = 'inline';

    document.getElementById("si172_contdeclicitacao").value = 3;
  }
  changeNaturezaObjeto();
  db_iframe_liclicita.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_contratos','db_iframe_contratos','func_contratos.php?funcao_js=parent.js_preenchepesquisa|si172_sequencial','Pesquisa',true,'0','1','1300','550');
}
function js_preenchepesquisa(chave){
  db_iframe_contratos.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}


function changeNaturezaObjeto(){

    if(document.form1.si172_naturezaobjeto.value == 5 || document.form1.si172_naturezaobjeto.value == 4){

      document.form1.si172_formafornecimento.readOnly = true;
      document.form1.si172_formafornecimento.style.background = '#DEB887';
      document.form1.si172_formafornecimento.value = '';

      document.form1.si172_formapagamento.readOnly = true;
      document.form1.si172_formapagamento.style.background = '#DEB887';
      document.form1.si172_formapagamento.value = '';

      document.form1.si172_prazoexecucao.readOnly = true;
      document.form1.si172_prazoexecucao.style.background = '#DEB887';
      document.form1.si172_prazoexecucao.value = '';

      document.form1.si172_multarescisoria.readOnly = true;
      document.form1.si172_multarescisoria.style.background = '#DEB887';
      document.form1.si172_multarescisoria.value = '';

      document.form1.si172_multainadimplemento.readOnly = true;
      document.form1.si172_multainadimplemento.style.background = '#DEB887';
      document.form1.si172_multainadimplemento.value = '';
    }else{

    	document.form1.si172_formafornecimento.readOnly = false;
      document.form1.si172_formafornecimento.style.background = '#fff';

      document.form1.si172_formapagamento.readOnly = false;
      document.form1.si172_formapagamento.style.background = '#fff';

      document.form1.si172_prazoexecucao.readOnly = false;
      document.form1.si172_prazoexecucao.style.background = '#fff';

      document.form1.si172_multarescisoria.readOnly = false;
      document.form1.si172_multarescisoria.style.background = '#fff';

      document.form1.si172_multainadimplemento.readOnly = false;
      document.form1.si172_multainadimplemento.style.background = '#fff';
    }
  }
changeNaturezaObjeto();
</script>

