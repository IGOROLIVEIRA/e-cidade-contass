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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_rhpessoalmov_classe.php");
include("classes/db_rhlota_classe.php");


include("classes/db_orcorgao_classe.php");
include("classes/db_orcunidade_classe.php");
;
include("classes/db_rhlotaexe_classe.php");
include("classes/db_rhlotacalend_classe.php");



$clrotulo = new rotulocampo;
$cl_rhpessoalmov = new cl_rhpessoalmov;
$clrhlota = new cl_rhlota;

$clrotulo->label("rh02_anousu");
$clrotulo->label("rh02_mesusu");
$clrotulo->label("r70_descr");
$clrotulo->label("r70_descr_2");
$clrotulo->label("r70_codigo");
$clrotulo->label("r70_codigo_2");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);
if(isset($salvar)){
  if($r70_descr_2 != null){
    if($funcionariosSelecionados!=null){

      foreach ($funcionariosSelecionados as $func) {

        db_query("UPDATE rhpessoalmov SET rh02_lota = '".$r70_codigo_2."' WHERE rh02_seqpes = '".$func."' AND rh02_lota = '".$r70_codigo."' ");
      }
    }

  }
  if($r70_descr != null){
    if($funcionarios!=null){

      foreach ($funcionarios as $func) {

        db_query("UPDATE rhpessoalmov SET rh02_lota = '".$r70_codigo."' WHERE rh02_seqpes = '".$func."' AND rh02_lota = '".$r70_codigo_2."'");
      }
    }

  }
  else{
    echo "<script>";
    echo "alert('Não foi possível realizar a alteração de lotação, por gentileza, verifique se os campos forão preenchidos corretamente.')";
    echo "</script>";
  }

}

if(isset($rh02_anousu) && isset($rh02_mesusu) && isset($r70_descr) && isset($r70_codigo) && isset($r70_descr_2) && isset($r70_codigo_2)){


  $sSqlAselecionar = "SELECT DISTINCT rh02_seqpes ,z01_nome, rh02_regist
  FROM rhpessoalmov
  LEFT JOIN rhpesrescisao ON rh05_seqpes = rh02_seqpes
  JOIN rhpessoal ON rh02_regist = rh01_regist
  JOIN CGM ON rh01_numcgm = z01_numcgm
  WHERE rh02_anousu = '".$rh02_anousu."'
  AND rh02_mesusu = '".$rh02_mesusu."'
  AND rh02_lota = '".$r70_codigo."'
  AND ((EXTRACT(MONTH FROM rh05_recis) =  '".$rh02_mesusu."' AND EXTRACT(YEAR FROM rh05_recis) =  '".$rh02_anousu."')
  OR rh05_recis is NULL)";
//echo $sSqlAselecionar."<br>";
  $rAselecionar = db_utils::getColectionByRecord(db_query($sSqlAselecionar));
  $selecionados = array();

  foreach ($rAselecionar as $sel) {
    $selecionados[$sel->rh02_seqpes]=$sel->rh02_regist.' - '.$sel->z01_nome;
  }
  $sSqlAselecionar2 = "SELECT DISTINCT rh02_seqpes ,z01_nome, rh02_regist
  FROM rhpessoalmov
  LEFT JOIN rhpesrescisao ON rh05_seqpes = rh02_seqpes
  JOIN rhpessoal ON rh02_regist = rh01_regist
  JOIN CGM ON rh01_numcgm = z01_numcgm
  WHERE rh02_anousu = '".$rh02_anousu."'
  AND rh02_mesusu = '".$rh02_mesusu."'
  AND rh02_lota = '".$r70_codigo_2."'
  AND ((EXTRACT(MONTH FROM rh05_recis)  = '".$rh02_mesusu."' AND EXTRACT(YEAR FROM rh05_recis)  = '".$rh02_anousu."')
  OR rh05_recis is NULL)";
//echo $sSqlAselecionar2;
  $rAselecionar2 = db_utils::getColectionByRecord(db_query($sSqlAselecionar2));
  $selecionados2 = array();
  foreach ($rAselecionar2 as $sel) {
    $selecionados2[$sel->rh02_seqpes]=$sel->rh02_regist.' - '.$sel->z01_nome;
  }
}

?>

<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc">

  <div class="container" style="width:690px !important;">

    <form name="form1" method="post" action="">

      <fieldset>

        <Legend><strong>Servidores por Lotação</strong></Legend>


        <table border="0" >

          <tr>
            <td nowrap title="Ano / Mês">
             Ano / Mês :
           </td>
           <td><?php db_input('rh02_anousu',8,"",true,'text',1,"onchange='js_recarrega();'"); ?> /
            <?php db_input('rh02_mesusu',8,"",true,'text',1,"onchange='js_recarrega();'"); ?></td>
          </tr>

        </table>

        <fieldset class="separator">

         <Legend><strong>Selecione os Departamentos</strong></Legend>
         <table>

          <tr>
           <td  width="10%" nowrap title="<?=@$Lr70_descr?>">
            <?php db_ancora(@$Lr70_codigo,"js_pesquisa(true);","1"); ?>
          </td>

          <td width="20%" >
           <?php db_input('r70_codigo',2,"","true","text","1","onchange='js_pesquisa(false);'", "r70_codigo"); ?>

           <?php db_input('r70_descr',20,"","true","text",3,"r70_descr"); ?>
         </td>

         <td width="10%"  nowrap title="<?=@$Lr70_descr?>">
          <?php db_ancora(@$Lr70_codigo,"js_pesquisa2(true);","1"); ?>
        </td>
        <td width="20%" >
         <?php db_input('r70_codigo',2,"","true","text","1","onchange='js_pesquisa2(false);'","r70_codigo_2"); ?>
         <?php db_input('r70_descr',20,"","true","text",3,"","r70_descr_2"); ?>
       </td>
     </tr>




     <tr>
       <td colspan=4>
         <?php db_multiploselect('rh02_seqpes','z01_nome', "funcionarios", "funcionariosSelecionados", $selecionados, $selecionados2); ?>
       </td>
     </tr>
     <tr>
      <td width="5%" align="right"><b>Buscar:</b></td>
      <td width="60%"><input type="text" id="buscaFuncionarios" onkeyup="buscaMultiselect('funcionarios');" placeholder="Digite um nome"></td>
      <td width="5%" align="right"><b>Buscar:</b></td>
      <td width="60%"><input type="text" id="buscaFuncionariosSelecionados" onkeyup="buscaMultiselect('funcionariosSelecionados');" placeholder="Digite um nome"></td>

    </tr>
    <tr>
      <td align="center" colspan=4>
        <input type="submit" name="salvar" id="salvar" onclick="valida_multiselect();" value="Salvar">
      </td>
    </tr>
  </table>
</fieldset>
<script>
  function valida_multiselect(){
    var i, funcioariosSelecionados, options;
    funcioariosSelecionados = document.getElementById("funcionariosSelecionados");
    options = funcioariosSelecionados.getElementsByTagName('option');
    for(i=0;i<options.length;i++){
      options[i].selected = 'selected';
    }
    funcioariosSelecionados = document.getElementById("funcionarios");
    options = funcioariosSelecionados.getElementsByTagName('option');
    for(i=0;i<options.length;i++){
      options[i].selected = 'selected';
    }
  }
  function buscaMultiselect(combobox) {


    var input, filter, funcionarios, options, i, texto;
    if(combobox == 'funcionarios'){

      input = document.getElementById('buscaFuncionarios');
      filter = input.value.toUpperCase();
      funcionarios = document.getElementById("funcionarios");

    }else{

      input = document.getElementById('buscaFuncionariosSelecionados');
      filter = input.value.toUpperCase();
      funcionarios = document.getElementById("funcionariosSelecionados");

    }
    options = funcionarios.getElementsByTagName('option');
    for (i = 0; i < options.length; i++) {
      texto = options[i].innerHTML.toUpperCase();
      if (texto.indexOf(filter) > -1) {
        options[i].style.display = "";
      } else {
        options[i].style.display = "none";
      }
    }
  }
</script>
</form>

</div>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>

<script type="text/javascript">
  function js_recarrega(){
    if(document.form1.r70_codigo.value != "" && document.form1.r70_codigo_2.value != ""){
      document.form1.salvar.disabled = "true";
      location.href="pes4_servidorlotacao001.php?rh02_anousu="+document.form1.rh02_anousu.value+"&rh02_mesusu="+document.form1.rh02_mesusu.value+"&r70_descr="+document.form1.r70_descr.value+"&r70_descr_2="+document.form1.r70_descr_2.value+"&r70_codigo="+document.form1.r70_codigo.value+"&r70_codigo_2="+document.form1.r70_codigo_2.value+"";
    }
  }
  function js_pesquisa(mostra = true){
    if(document.form1.rh02_mesusu.value == "" || document.form1.rh02_anousu.value == ""){
      alert("Por favor, preencha os campos Ano / Mês");
      return false;
    }
    if(mostra == false){

      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhlota','func_rhlota.php?pesquisa_chave='+document.form1.r70_codigo.value+'&funcao_js=parent.js_preenchepesquisa','Pesquisa',false);

    }else{
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhlota','func_rhlota.php?funcao_js=parent.js_preenchepesquisa|r70_codigo|r70_descr&instit=<?=(db_getsession("DB_instit"))?>','Pesquisa',true,20,0);
    }
  }
  function js_preenchepesquisa(chave, r70_descr){


    if(r70_descr != false && r70_descr != true){

      document.form1.r70_codigo.value = chave;
      document.form1.r70_descr.value = r70_descr;
      db_iframe_rhlota.hide();

    }else{
      if(r70_descr == true){
        document.form1.r70_descr.value = r70_descr;
      }
      document.form1.r70_descr.value = chave;
    }
    if(document.form1.r70_codigo.value != "" && document.form1.r70_codigo_2.value != ""){
      document.form1.salvar.disabled = "true";
      location.href="pes4_servidorlotacao001.php?rh02_anousu="+document.form1.rh02_anousu.value+"&rh02_mesusu="+document.form1.rh02_mesusu.value+"&r70_descr="+document.form1.r70_descr.value+"&r70_descr_2="+document.form1.r70_descr_2.value+"&r70_codigo="+document.form1.r70_codigo.value+"&r70_codigo_2="+document.form1.r70_codigo_2.value+"";
    }
  }
  function js_pesquisa2(mostra = true){
    if(document.form1.rh02_mesusu.value == "" || document.form1.rh02_anousu.value == ""){
      alert("Por favor, preencha os campos Ano / Mês");
      return false;
    }
    if(mostra == false){

      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhlota','func_rhlota.php?pesquisa_chave='+document.form1.r70_codigo_2.value+'&funcao_js=parent.js_preenchepesquisa2','Pesquisa',false);

    }else{
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhlota','func_rhlota.php?funcao_js=parent.js_preenchepesquisa2|r70_codigo|r70_descr&instit=<?=(db_getsession("DB_instit"))?>','Pesquisa',true,20,0);
    }
  }
  function js_preenchepesquisa2(chave, r70_descr){


    if(r70_descr != false && r70_descr != true){

      document.form1.r70_codigo_2.value = chave;
      document.form1.r70_descr_2.value = r70_descr;
      db_iframe_rhlota.hide();

    }else{
      if(r70_descr == true){
        document.form1.r70_descr_2.value = r70_descr;
      }
      document.form1.r70_descr_2.value = chave;
    }
    if(document.form1.r70_codigo.value != "" && document.form1.r70_codigo_2.value != ""){
      document.form1.salvar.disabled = "true";
      location.href="pes4_servidorlotacao001.php?rh02_anousu="+document.form1.rh02_anousu.value+"&rh02_mesusu="+document.form1.rh02_mesusu.value+"&r70_descr="+document.form1.r70_descr.value+"&r70_descr_2="+document.form1.r70_descr_2.value+"&r70_codigo="+document.form1.r70_codigo.value+"&r70_codigo_2="+document.form1.r70_codigo_2.value+"";
    }
  }

</script>
</body>
</html>
