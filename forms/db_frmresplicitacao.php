<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

//MODULO: licitação
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clliclicita2   = new cl_liclicita;
$clliccomissaocgm->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("l30_codigo");
$clrotulo->label("z01_nome");
if(isset($db_opcaoal)){
   $db_opcao=33;
    $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else{
    $db_opcao = 1;
    $db_botao=true;
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
    	if (isset($novo)){
     $l31_codigo = "";
    	}
     $l31_numcgm = "";
   }
}
?>
<form name="form1" method="post" action="">
<center>
<table border="0">

<?

db_input('l31_codigo',10,$Il31_codigo,true,'hidden',3,"");

db_input('l31_licitacao',10,$Il31_licitacao,true,'hidden',3,"");

db_input('l20_codtipocom',10,$Il20_codtipocom,true,'hidden',3,"");

?>


  <tr>
    <td>
<?
db_input('l31_liccomissao',10,$Il31_liccomissao,true,'hidden',3," onchange='js_pesquisal31_liccomissao(false);'");
db_input('l31_codigo',10,$Il31_codigo,true,'hidden',3,"");
?>

    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl31_numcgm?>">
       <?
       db_ancora(@$Ll31_numcgm,"js_pesquisal31_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('l31_numcgm',10,$Il31_numcgm,true,'text',$db_opcao," onchange='js_pesquisal31_numcgm(false);'");
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl31_tipo?>">
       <?=@$Ll31_tipo?>
    </td>
    <td>
<?
$result_pres=$clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file(null,"*",null,"l31_licitacao=$l31_licitacao and l31_tipo='P'"));

$clliclicita2->sql_record($clliclicita->sql_query('', '*', '', "l20_codigo = $l31_licitacao and pc50_pctipocompratribunal in (100,101,102,103)"));
$sSql = $clliclicita2->sql_query('', 'l20_naturezaobjeto', '', "l20_codigo = $l31_licitacao limit 1");
$rsSql = $clliclicita2->sql_record($sSql);
$natureza_objeto = db_utils::fieldsMemory($rsSql, 0)->l20_naturezaobjeto;
$bDispenca = false;
if($clliclicita->numrows > 0) {

    $x = array('1' => 'Autorização para abertura do procedimento de dispensa ou inexigibilidade
	', '2' => 'Cotação de preços
	', '3' => 'Informação de existência de recursos orçamentários
	', '4' => 'Ratificação
	', '5' => 'Publicação em órgão oficial
	', '6' => 'Parecer Jurídico
	', '7' => 'Parecer (outros)');
    if($natureza_objeto == 1 || $natureza_objeto == 7){
        $x['10'] = 'Orçamento da obra ou serviço';
    }
    db_select('l31_tipo', $x, true, $db_opcao, "");
    $bDispenca = true;

}else {
    $clliclicita->sql_record($clliclicita->sql_query('', '*', '', "l20_codigo = $l31_licitacao and l20_naturezaobjeto = 6"));
    $bNaturezaobjeto = false;
    if ($clliclicita->numrows > 0) {

        $bNaturezaobjeto = true;

        $x = array('1' => 'Autorização para abertura do procedimento licitatório
	', '2' => 'Emissão do edital
	', '3' => 'Pesquisa de preços
	', '4' => 'Informação de existência de recursos orçamentários
	', '5' => 'Condução do procedimento licitatório
	', '6' => 'Homologação
	', '7' => 'Adjudicação
	', '8' => 'Publicação em órgão Oficial
	', '9' => 'Avaliação de Bens');
        db_select('l31_tipo', $x, true, $db_opcao, "");
    } else {
        $x = array('1' => 'Autorização para abertura do procedimento licitatório
	', '2' => 'Emissão do edital
	', '3' => 'Pesquisa de preços
	', '4' => 'Informação de existência de recursos orçamentários
	', '5' => 'Condução do procedimento licitatório
	', '6' => 'Homologação
	', '7' => 'Adjudicação
	', '8' => 'Publicação em órgão Oficial');
		if($natureza_objeto == 1 || $natureza_objeto == 7){
			$x['10'] = 'Orçamento da obra ou serviço';
		}
        db_select('l31_tipo', $x, true, $db_opcao, "");
    }
}
?>
    </td>
      <?
      db_input('l31_licitacao',40,$Il31_licitacao,true,'hidden',3,'')
      ?>
  </tr>
  <tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">
    <?
	 $chavepri= array("l31_codigo"=>@$l31_codigo,"l31_licitacao"=>@$l31_licitacao);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
     if ($bDispenca == true) {

         $cliframe_alterar_excluir->sql = $clliccomissaocgm->sql_query_file(null, "l31_codigo,l31_liccomissao,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm) as z01_nome ,
   case
   when l31_tipo::varchar = '1' then '01-Autorização para abertura do procedimento de dispensa ou inexigibilidade'
   when l31_tipo::varchar = '2' then '02-Cotação de preços'
   when l31_tipo::varchar = '3' then '03-Informação de existência de recursos orçamentários'
   when l31_tipo::varchar = '4' then '04-Ratificação'
   when l31_tipo::varchar = '5' then '05-Publicação em órgão oficial'
   when l31_tipo::varchar = '6' then '06-Parecer Jurídico'
   when l31_tipo::varchar = '7' then '07-Parecer (outros)'
   when l31_tipo::varchar = '10' then '10-Orçamento da obra ou serviço'
   end as l31_tipo
   ", null, "l31_licitacao=$l31_licitacao");

     }else{

         if ($bNaturezaobjeto == true) {

             $cliframe_alterar_excluir->sql = $clliccomissaocgm->sql_query_file(null, "l31_codigo,l31_liccomissao,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm) as z01_nome,
               case
               when l31_tipo::varchar = '1' then '01-Autorização para abertura do procedimento licitatório'
               when l31_tipo::varchar = '2' then '02-Emissão do edital'
               when l31_tipo::varchar = '3' then '03-Pesquisa de preços'
               when l31_tipo::varchar = '4' then '04-Informação de existência de recursos orçamentários'
               when l31_tipo::varchar = '5' then '05-Condução do procedimento licitatório'
               when l31_tipo::varchar = '6' then '06-Homologação'
               when l31_tipo::varchar = '7' then '07-Adjudicação'
               when l31_tipo::varchar = '8' then '08-Publicação em órgão Oficial'
               when l31_tipo::varchar = '9' then '09-Avaliação de Bens'
               when l31_tipo::varchar = '10' then '10-Orçamento da obra ou serviço'
               end as l31_tipo
               ", null, "l31_licitacao=$l31_licitacao");

         }else{

             $cliframe_alterar_excluir->sql = $clliccomissaocgm->sql_query_file(null, "l31_codigo,l31_liccomissao,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm) as z01_nome,
               case
               when l31_tipo::varchar = '1' then '01-Autorização para abertura do procedimento licitatório'
               when l31_tipo::varchar = '2' then '02-Emissão do edital'
               when l31_tipo::varchar = '3' then '03-Pesquisa de preços'
               when l31_tipo::varchar = '4' then '04-Informação de existência de recursos orçamentários'
               when l31_tipo::varchar = '5' then '05-Condução do procedimento licitatório'
               when l31_tipo::varchar = '6' then '06-Homologação'
               when l31_tipo::varchar = '7' then '07-Adjudicação'
               when l31_tipo::varchar = '8' then '08-Publicação em órgão Oficial'
               when l31_tipo::varchar = '10' then '10-Orçamento da obra ou serviço'
               end as l31_tipo
               ", null, "l31_licitacao=$l31_licitacao");

         }


     }

	 $cliframe_alterar_excluir->campos  ="l31_codigo,l31_numcgm, z01_nome,l31_tipo";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);




    ?>
    </td>
   </tr>
 </table>
  </center>
</form>
<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}
function js_pesquisal31_liccomissao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_resplicita','db_iframe_liccomissao','func_liccomissao.php?funcao_js=parent.js_mostraliccomissao1|l30_codigo|l30_codigo','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.l31_liccomissao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_resplicita','db_iframe_liccomissao','func_liccomissao.php?pesquisa_chave='+document.form1.l31_liccomissao.value+'&funcao_js=parent.js_mostraliccomissao','Pesquisa',false);
     }else{
       document.form1.l30_codigo.value = '';
     }
  }
}
function js_mostraliccomissao(chave,erro){
  document.form1.l30_codigo.value = chave;
  if(erro==true){
    document.form1.l31_liccomissao.focus();
    document.form1.l31_liccomissao.value = '';
  }
}
function js_mostraliccomissao1(chave1,chave2){
  document.form1.l31_liccomissao.value = chave1;
  document.form1.l30_codigo.value = chave2;
  db_iframe_liccomissao.hide();
}
function js_pesquisal31_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_resplicita','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome&filtro=1','Pesquisa',true,'0','1');
  }else{
     if(document.form1.l31_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_resplicita','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.l31_numcgm.value+'&funcao_js=parent.js_mostracgm&filtro=1','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.l31_numcgm.focus();
    document.form1.l31_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.l31_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
</script>
