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



db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);


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


  <div class="container" style="width:690px !important; margin:0 auto;">
    <center>

      <form name="form1" method="post" action="">

        <fieldset>

          <Legend><strong>Rúbricas para tabela <?php echo $e990_descricao; ?></strong></Legend>


          <table border="0" >

          </table>




          <table>
           <tr>
            <td width="5%" align="right"><b>Buscar:</b></td>
            <td width="60%"><input type="text" id="buscabasesSelecionados" onkeyup="buscaMultiselect('basesSelecionados');" placeholder="Digite um nome"></td>
            <td width="5%" align="right"><b>Buscar:</b></td>
            <td width="60%"><input type="text" id="buscabases" onkeyup="buscaMultiselect('bases');" placeholder="Digite um nome"></td>

          </tr>
          <tr>
           <td colspan=4>

             <?php db_multiploselect('codigo','descricao', "basesSelecionados", "bases", $basesSelecionados, $bases,20,400,"Selecionados","Disponíveis",true,  "Verifica();"); ?>
           </td>
         </tr>
         <tr>
          <input type="hidden" name="e990_sequencial" value="<?php echo $e990_sequencial; ?>">
          <td align="center" colspan=4>
            <input type="hidden" name="salvar" id="salvar" value="Salvar">
            <input type="button" name="salvar" id="salvar" onclick="valida_multiselect();" value="Salvar">
          </td>
        </tr>
      </table>

      <script>
        var outros = '<?php echo $JSONaBasesEsocialOutras; ?>';
        function valida_multiselect(event){
          var i, basesSelecionados, options, baseVinculada = false;
          basesSelecionados = document.getElementById("basesSelecionados");
          options = basesSelecionados.getElementsByTagName('option');
          for(i=0;i<options.length;i++){
            options[i].selected = 'selected';
            if(outros.indexOf(options[i].value)!=-1 && options[i].value[0] != '2' && options[i].value[0] != '4'){
              baseVinculada = true;
             }
          }
          basesSelecionados = document.getElementById("bases");
          options = basesSelecionados.getElementsByTagName('option');
          for(i=0;i<options.length;i++){
            options[i].selected = 'selected';
          }
          if(baseVinculada == true){
            if(confirm("Você está vinculando à tabela uma RÚBRICA já vinculada, se confirmar, você estará trocando o vínculo.") == true){
              document.form1.submit();
            }else{
              event.preventDefault();
            }
          }else{

            document.form1.submit();
          }


        }
        function buscaMultiselect(combobox) {


          var input, filter, bases, options, i, texto;
          if(combobox == 'bases'){

            input = document.getElementById('buscabases');
            filter = input.value.toUpperCase();
            bases = document.getElementById("bases");

          }else{

            input = document.getElementById('buscabasesSelecionados');
            filter = input.value.toUpperCase();
            bases = document.getElementById("basesSelecionados");

          }
          options = bases.getElementsByTagName('option');
          for (i = 0; i < options.length; i++) {
            texto = options[i].innerHTML.toUpperCase();
            if (texto.indexOf(filter) > -1) {
              options[i].style.display = "";
            } else {
              options[i].style.display = "none";
            }
          }
        }
        function Verifica(){


          var select = document.getElementById("bases");
          document.getElementsByName("seltodosE")[0].addEventListener('click', Verifica);
          document.getElementsByName("seltodosD")[0].addEventListener('click', Verifica);
          document.getElementsByName("selecionE")[0].addEventListener('click', Verifica);
          document.getElementsByName("selecionD")[0].addEventListener('click', Verifica);
          select.addEventListener('dblclick', Verifica);

          for (var i = 0; i < select.options.length; i++) {
            if(i%2==0){
              select.options[i].style = "background-color: rgb(234, 234, 234); ";
            }else{
              select.options[i].style = "background-color: rgb(249, 249, 249); ";
            }
            if(outros.indexOf(select.options[i].value)!=-1){
              select.options[i].style = "background-color: rgb(248, 236, 7);} ";
            }
          }

          var select2 = document.getElementById("basesSelecionados");
          select2.addEventListener('dblclick', Verifica);

          for (var i = 0; i < select2.options.length; i++) {
            if(i%2==0){
              select2.options[i].style = "background-color: rgb(234, 234, 234); ";
            }else{
              select2.options[i].style = "background-color: rgb(249, 249, 249); ";
            }
            if(outros.indexOf(select2.options[i].value)!=-1){
              select2.options[i].style = "background-color: rgb(248, 236, 7);} ";
            }
          }

        }
        Verifica();
      </script>
    </center>
  </form>

</div>

</body>
</html>
  <!-- rgb(234, 234, 234)
  rgb(249, 249, 249) -->
