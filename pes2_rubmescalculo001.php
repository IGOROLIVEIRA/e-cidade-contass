<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once ("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
$clrotulo->label('rh27_descr');
$clrotulo->label('r44_des');

//db_postmemory($HTTP_POST_VARS);
$oPost = db_utils::postMemory($_POST);
$geraform = new cl_formulario_rel_pes;
?>

<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <style>
      select {
        width: 315px;
      }
      fieldset{
        width: 500px;
        margin: 25px auto 10px;
      }
    </style>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body bgcolor=#CCCCCC>
    <form name="form1" method="post" action="" onSubmit="return js_verifica();" id="formularioRelatorio">
      <fieldset>
        <table  align="center">
          <legend><strong>Relatório por código</strong></legend>

            <tr>
              <td nowrap title="Ano / Mes de competência" >
              <strong>Ano / Mês :&nbsp;&nbsp;</strong>
              </td>
              <td>
                <?
                 $DBtxt23 = db_anofolha();
                 db_input('DBtxt23',4,$IDBtxt23,true,'text',2,'')
                ?>
                &nbsp;/&nbsp;
                <?
                 $DBtxt25 = db_mesfolha();
                 db_input('DBtxt25',2,$IDBtxt25,true,'text',2,'')
                ?>
              </td>
            </tr>
            
            <?
            $geraform->usarubr = true;
            $geraform->ru1nome = "rubrica1";
            $geraform->ru2nome = "rubrica2";
            $geraform->ru3nome = "selrubri";
            $geraform->campo_auxilio_rubr = "faixa_rubrica";
            $geraform->manomes = false;
      

            $geraform->resumopadrao = "r";
            $geraform->filtropadrao = "i";
            $geraform->strngtipores = "r";
            $geraform->tipofol = true;
            $geraform->onchpad = true;
            $geraform->arr_tipofil = Array("i"=>"Intervalo","s"=>"Selecionados");
            $geraform->gera_form(db_anofolha(), db_mesfolha());
            ?>
            
            <tr title="Seleção">
              <td>
                <?php
                  db_ancora("Seleção", "js_pesquisaSelecao(true)", 1);
                ?>
              </td>
              <td>
                <?php
                  db_input('r44_selec', 8,  1, true, 'text', "", "onchange='js_pesquisaSelecao(false)'");
                  db_input('r44_des',   30, "", true, 'text', 3);
                ?>
              </td>
            </tr>

            <tr title="Tipo de folha">
              <td><b>Ponto :&nbsp;&nbsp;</b></td>
              <td>
               <?php
                 $aTipos = array("s"=>"Salário",
                                 "c"=>"Complementar",
                                 "d"=>"13o. Salário",
                                 "r"=>"Rescisão",
                                 "a"=>"Adiantamento",
                                 "t" => "Todos");
                 
                 if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
                   $aTipos["u"] = "Suplementar";
                 }

                 db_select('ponto', $aTipos, true, 4, "");
               ?>
              </td>
            </tr>

            <tr  title="Ordem">
              <td><b>Ordem :&nbsp;&nbsp;</b></td>
              <td>
               <?
                 $x = array("a"=>"Alfabética","n"=>"Numérica","r"=>"Recurso","l"=>"Lotação","v"=>"Valor","q"=>"Quantidade");
                 db_select('ordem',$x,true,4,"");
               ?>
              </td>
            </tr>

            <tr  title="Tipo de Ordem">
              <td><b>Tipo de Ordem :&nbsp;&nbsp;</b></td>
              <td>
               <?
                 $x = array("asc"=>"Ascendente","desc"=>"Descendente");
                 db_select('tipoordem',$x,true,4,"");
               ?>
              </td>
            </tr>

            <tr title="Caso Analítico mostra servidores da rubrica selecionada, Sintético mostra somente o número.">
              <td><b>Totalização :&nbsp;&nbsp;</b></td>
              <td>
               <?
                 $x = array("a"=>"Analítico","s"=>"Sintético");
                 db_select('total',$x,true,4,"");
               ?>
              </td>
            </tr>

            <tr  title="Tipo de Relatório">
              <td><b>Tipo :&nbsp;&nbsp;</b></td>
              <td>
               <?
                 $x = array("r"=>"Relatório","a"=>"Arquivo","p"=>"Planilha");
                 db_select('tipo',$x,true,4,"");
               ?>
              </td>
            </tr>

            <tr  title="Modelo da Página">
              <td><b>Página :&nbsp;&nbsp;</b></td>
              <td>
               <?
                 $xy = array("p"=>"Paisagem","r"=>"Retrato");
                 db_select('pagina',$xy,true,4,"");
               ?>
              </td>
            </tr>

            <tr  title="Dados Cadastrais atual ou por período">
              <td><b>Dados Cadastrais :&nbsp;&nbsp;</b></td>
              <td >
               <?
                 $xcad = array("a"=>"Atual","p"=>"Período");
                 db_select('mes_dados',$xcad,true,4,"");
               ?>
              </td>
            </tr>
            <tr>
              <td><b>Quebrar por página:</b></td>
              <td>
              <?
                $options = array('sim'=>"Sim",'nao'=>"Não");
                db_select('opcao', array_reverse($options),true, 4,"");
              ?>
              </td>
            </tr>
        </table>
      </fieldset>
      <center>
        <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
      </center>
    </form>
    <?
      db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
    ?>
  </body>
  <script>

    /**
    * Realiza a busca de seleções retornando o código e descrição da rubrica escolhida;
    */
    function js_pesquisaSelecao(lMostra) {

    	if ( lMostra ) {
    	  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_selecao','func_selecao.php?funcao_js=parent.js_geraform_mostraselecao1|r44_selec|r44_descr&instit=<?=db_getsession("DB_instit")?>','Pesquisa',true);
    	} else {
    	  if ( $F(r44_selec) != "" ) {
    	    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_selecao','func_selecao.php?pesquisa_chave=' + $F(r44_selec) + '&funcao_js=parent.js_geraform_mostraselecao&instit=<?=db_getsession("DB_instit")?>','Pesquisa',false);
    	  } else {
    	    $(r44_des).setValue("");
    	  }
    	}
    }

    /**
    * Trata o retorno da função js_pesquisaSelecao().
    */
    function js_geraform_mostraselecao(sDescricao, lErro) {

    	if ( lErro ) {

    	  $(r44_selec).setValue('');
    	  $(r44_selec).focus();
    	}

    	$(r44_des).setValue(sDescricao);
    }

    /**
    * Trata o retorno da função js_pesquisaSelecao();
    */
    function js_geraform_mostraselecao1(sChave1, sChave2) {

      $(r44_selec).setValue(sChave1);

      if( $(r44_des) ) {
        $(r44_des).setValue(sChave2);
      }

      db_iframe_selecao.hide();
    }

    /**
    * Emite o Relatorio a partir dos dados enviados
    */
    function js_emite(){

      var lEmite = true;
      var rubrica = new Object();
      if (document.form1.selrubri && document.form1.selrubri.length > 0) {
          rubrica.faixarub = js_campo_recebe_valores();
      } else if (document.form1.rubrica1 && document.form1.rubrica1.value.length > 0) {
        rubrica.rubini = document.form1.rubrica1.value;
        rubrica.rubfim = document.form1.rubrica2.value;
        if (document.form1.rubrica2.value.length == 0) {
          alert("Selecione uma rubrica para o final do intervalo.");
        }
      }

      if (!rubrica.rubini && !rubrica.faixarub ) {
        if (!confirm("Confirma impressão do relatório sem filtro por rubrica?")) {
          lEmite = false;
        }
      }

      if ( lEmite ) {

        /**
        * Monta um objeto com os dados do formulario, para ser enviado para a geração do relatório
        */
        var oDados = new Object();

        oDados.sTotalizacao     = $F(total);
        oDados.sTipoOrdem       = $F(tipoordem);
        oDados.sOrdem           = $F(ordem);
        oDados.sTipo            = $F(tipo);
        oDados.sPonto           = $F(ponto);
        oDados.sPagina          = $F(pagina);
        oDados.iSelecao         = $F(r44_selec);
        oDados.iAno             = $F(DBtxt23);
        oDados.iMes             = $F(DBtxt25);
        oDados.sDadosCadastrais = $F(mes_dados);
        oDados.sQuebra          = $F(opcao);
        if (rubrica.faixarub) {
          oDados.faixarub = rubrica.faixarub;
        } else if (rubrica.rubini) {
          oDados.rubini = rubrica.rubini;
          oDados.rubfim = rubrica.rubfim;
        }

        if ( $F(tipo) == 'a' || $F(tipo) == 'p' ) {
          js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_bbrubmescalculo','pes2_rubmescalculo002.php?sParametros='+Object.toJSON(oDados),'Gerando Arquivo',false);
        } else {

          jan = window.open('pes2_rubmescalculo002.php?sParametros='+Object.toJSON(oDados),'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
          jan.moveTo(0,0);
        }
      }
    }

    /**
    * Realiza a abertura do arquivo quando for do tipo TXT.
    */
    function js_detectaarquivo(sArquivo){

    	var sListagem = sArquivo + "#Download arquivo TXT ";
      CurrentWindow.corpo.db_iframe_bbrubmescalculo.hide();
      js_montarlista(sListagem,"form1");
    }

    /**
    * Realiza a abertura do arquivo quando for do tipo CSV.
    */
    function js_detectaarquivo1(sArquivo){

    	var sListagem = sArquivo + "#Download arquivo CSV ";
    	CurrentWindow.corpo.db_iframe_bbrubmescalculo.hide();
      js_montarlista(sListagem,"form1");
    }
  </script>
</html>
