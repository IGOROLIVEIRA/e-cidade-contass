<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>

function js_emite(){
  var qry = "";

 
  qry = 'si06_sequencial='+document.form1.si06_sequencial.value;
  qry += '&si06_modalidade='+document.form1.si06_modalidade.value;
  qry += '&si06_anocadastro='+document.form1.si06_anocadastro.value;
  let sFornecedores = '';

    if(document.form1.lQuebraFornecedor.value == 't' && document.form1.fornecedor.options.length){
        vrg    = '';
    
        for (let count = 0; count < document.form1.fornecedor.options.length; count++) {
            sFornecedores += vrg + document.form1.fornecedor.options[count].value;
            vrg =',';
        }
    }

    qry += '&cgms='+sFornecedores;
  qry += '&fornecedor='+document.form1.fornecedor.value;


  jan  = window.open('com2_relatorioroldeadesao002.php?'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}

</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
#fornecedor{
    width: 336px;
}

#lQuebraFornecedor{
    width: 69px;
}

#status{
    width: 200px;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
  
              
<center>         
    
<fieldset style="width: 480px;margin-top: 30px">
      <legend><strong>Relatório de Recursos Orçamentarios</strong></legend>
  <table  align="center">
    <form name="form1" method="post" action="" >
    
    
    
        
            <tr>
                <td align="left" nowrap title="<?= $Te60_numcgm ?>">
                    <? db_ancora("Ata de Registro de Preço: ","js_pesquisaadesao(true);",1); ?>
                </td>
                <td align="left" nowrap>
                  <? db_input("si06_sequencial", 6, $Isi06_sequencial, true, "text", 4, "onchange='js_pesquisaadesao(false);'");
                    db_input("si06_objetoadesao", 40, "$Isi06_objetoadesao", true, "text", 3);
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                        <strong>Modalidade:</strong>
                </td>
                <td>
                    <?$iModalidade = array(
                      0=>"Selecione",
                      1=>"Concorrência",
                      2 =>"Pregão");
                      db_select("si06_modalidade",$iModalidade,true,1,"style='width: 312px;'");
                    ?>
                </td>
              </tr>
              <tr>
                <td style="font-weight: bolder;" >
                  Exercício:
                </td>
                <td>
                  <?
                  db_input("si06_anocadastro", 6, $Isi06_anocadastro,true,"text",4,'onkeyup="js_validaCaracteres(this);onchange=js_limitaExercicio(this);"');
                  ?>
                </td>
              </tr>
              <tr>
                <td>
                  <b>Filtrar por fornecedor:</b>
                </td>
                <td>
                    <select name="lQuebraFornecedor" id="lQuebraFornecedor" style="width: 60px;">
                        <option value="f" selected>NÃO</option>
                        <option value="t">SIM</option>
                    </select>
                </td>
              </tr>



              <tr id='area_fornecedor' class='tr__cgm'>
                  <td colspan="2">
                        <fieldset>
                            <legend>Fornecedores</legend>
                            <table align="center" border="0">
                                <tr>
                                    <td>
									                    <?php db_ancora('CGM',"js_pesquisa_fornelicitacao(true);",1); ?>
                                    </td>
                                    <td>
                                    <?php
                                      db_input('z01_numcgm',6,'',true,'text',4," onchange='js_pesquisa_fornelicitacao(false);'","");
                                      db_input('z01_nome',25, '', true, 'text', 3,"","");
                                    ?>
                                        <input type="button" value="Lançar" id="btn-lancar-fornecedor"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                          <select name="fornecedor[]" id="fornecedor" size="5" multiple></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2">
                                        <strong>Dois Cliques sobre o fornecedor o exclui.</strong>
                                    </td>
                                </tr>
                              </table>
                          </fieldset>
                      </td>
              </tr>
              
              
        
      
      <tr><td colspan="2">&nbsp;</td></tr>
      <tr>
        <td colspan="2" align = "center"> 
          <input  name="emite2" id="emite2" type="button" value="Gerar Relatorio" onclick="js_emite();" >
        </td>
      </tr>

      

  </form>
    </table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</fieldset>
        </center> 
</body>
</html>

<script>
  document.getElementsByClassName('tr__cgm')[0].style.display = 'none';

    function js_pesquisaadesao(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo', 'db_iframe_adesaoregprecos', 'func_adesaoregprecos.php?adesao=1&funcao_js=parent.js_preenchepesquisa|si06_sequencial|si06_objetoadesao', 'Pesquisa', true);
        }else{
            if(document.form1.pc80_codproc.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_pcproc','func_pcproc.php?pesquisa_chave='+document.form1.pc80_codproc.value+'&funcao_js=parent.js_mostrapcproc','Pesquisa',false);
            }else{
                document.form1.pc80_codproc.value = '';
            }
        }
    }
    function js_preenchepesquisa(chave, objetoadesao,) {
      document.getElementById('si06_sequencial').value=chave;
          document.getElementById('si06_objetoadesao').value=objetoadesao;
        
    db_iframe_adesaoregprecos.hide();
  }
    function js_mostrapcproc(chave,erro){
        if(erro==true){
            document.form1.pc80_codproc.focus();
            document.form1.pc80_codproc.value = '';
        }
    }
    function js_mostrapcproc1(chave1,x){
        document.form1.pc80_codproc.value = chave1;
        db_iframe_pcproc.hide();
    }
    function js_pesquisa_fornelicitacao(mostra){
    if (mostra) {
        js_OpenJanelaIframe('top.corpo','db_iframe_fornelicitacao','func_pcforne.php?&funcao_js=parent.js_mostrafornelicitacao|pc60_numcgm|z01_nome','Pesquisa',true);
    } else {
        if (document.form1.z01_numcgm.value != '') {
            js_OpenJanelaIframe('','db_iframe_fornelicitacao','func_pcforne.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_mostrafornelicitacao1','Pesquisa',false);
        } else {
            document.form1.z01_numcgm.value = '';
            document.form1.z01_nome.value = '';
        }
    }
}

function js_mostrafornelicitacao1(chave, erro) {

    if (erro) {
        document.form1.z01_numcgm.focus();
        document.form1.z01_numcgm.value = '';
        return;
    }

    document.getElementById('z01_nome').value = chave;
}

function js_mostrafornelicitacao(chave1,chave2) {
    document.form1.z01_numcgm.value = chave1;
    document.form1.z01_nome.value = chave2;
    db_iframe_fornelicitacao.hide();
}
if(document.getElementById('lQuebraFornecedor').value = 'f'){
    document.getElementById('area_fornecedor').style.display = 'none';
}
document.getElementById('lQuebraFornecedor').addEventListener('change', e => {
    let oElemento = document.getElementsByClassName('tr__cgm')[0];

    oElemento.style.display = e.target.value == 't' ? '' : 'none';

    let fornecedor = document.getElementById('fornecedor');
    if(fornecedor.options.length){
      for(let count = 0; count < fornecedor.options.length; count++){
          fornecedor.removeChild(fornecedor.childNodes[count]);
      }
    }

});
document.getElementById('btn-lancar-fornecedor').addEventListener('click', (e) => {
    addOption(document.form1.z01_numcgm.value, document.form1.z01_nome.value);
});

function addOption(codigo, descricao) {

    if (!codigo || !descricao) {
        alert('Fornecedor inválido!');
        limparCampos();
        return;
    }

    let aOptions = document.getElementById("fornecedor");
    let jaTem = Array.prototype.filter.call(aOptions.children, (o) => {
        return o.value == codigo;
    });


    if (jaTem.length > 0) {
        alert("Fornecedor já inserido.");
        limparCampos();
        return;
    }

    let option = document.createElement('option');
    option.value = codigo;
    option.innerHTML = codigo + ' - ' + descricao;
    aOptions.appendChild(option);

    limparCampos();

}

document.getElementById('fornecedor').addEventListener('dblclick', (e) => {
  document.getElementById('fornecedor').removeChild(e.target);
});

function limparCampos() {
    document.form1.z01_numcgm.value  = '';
    document.form1.z01_nome.value  = '';
}
function js_validaCaracteres(objeto){
    js_ValidaCamposText(objeto, 1);

    if(/[^0-9]/.test(objeto.value)){
        objeto.value = '';
    }
}
function js_limitaExercicio(objeto){
    if(objeto.value.length > 4 ){
        alert('Este campo deve conter apenas 4 caracteres');
        objeto.value = objeto.value.substr(0, 4);
    }
}
</script>