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

require("libs/db_stdlib.php");
require("libs/db_app.utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
?>
<html lang="">

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<div style="margin: 2% 40%;">
    <form name="form1" method="post" action="">
        <fieldset>
            <legend>
                <b>Relatorio de Itens Licitados</b>
            </legend>
            <table>
                <tr>
                    <td colspan="2">
                        <?
                        $aux = new cl_arquivo_auxiliar;
                        $aux->cabecalho = "<strong>Processo Licitatorio</strong>";
                        $aux->codigo = "l20_codigo";
                        $aux->descr  = "l20_objeto";
                        $aux->nomeobjeto = 'listadelicitacoes';
                        $aux->funcao_js = 'js_mostra';
                        $aux->funcao_js_hide = 'js_mostra1';
                        $aux->sql_exec  = "";
                        $aux->func_arquivo = "func_relatorioitenslicitados.php";
                        $aux->nomeiframe = "db_iframe_liclicita";
                        $aux->localjan = "";
                        $aux->onclick = "";
                        $aux->db_opcao = 2;
                        $aux->tipo = 2;
                        $aux->top = 1;
                        $aux->linhas = 10;
                        $aux->vwhidth = 444;
                        $aux->funcao_gera_formulario();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Exercício:</strong>
                    </td>
                    <td>
                        <?php
                        db_input("exercicio",8, $exercicio, true, "text", 1,'onkeyup="js_validaCaracteres();onchange=js_limitaExercicio();"');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Opção de Seleção:</strong>
                    </td>
                    <td>
                        <?php
                            $opselect = array("0"=>"Selecione","1"=>"Somente Selecionados","2"=>"Menos os Selecionados");
                            db_select("opselect",$opselect,true,2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Ordem de Seleção:</strong>
                    </td>
                    <td>
                        <?php
                        $orderselect = array("0"=>"Selecione","1"=>"Data de Homologação","2"=>"Alfabetica","3"=>"Fornecedor e Código");
                        db_select("orderselect",$orderselect,true,2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Imprimir com:</strong>
                    </td>
                    <td>
                        <input type="checkbox" value="Fornecedor" id="forne"/>
                        <label for="">Fornecedor</label>

                        <input type="checkbox" value="Processo" id="proc"/>
                        <label for="">Processo</label>

                        <input type="checkbox" value="Contrato" id="aco"/>
                        <label for="">Contrato</label>

                        <input type="checkbox" value="ValorUnit" id="vlrunt"/>
                        <label for="">Valor Unitáro</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input  name="emite2" id="emite2" type="button" value="Relatório" onclick="js_emite();" >
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>
 <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>

<script type="text/javascript">

    function js_emite() {

        let vir="";
        let procselect="";
        let opselect = document.form1.opselect.value;
        let orderselect = document.form1.orderselect.value;
        let impforne = document.form1.forne.checked;
        let impproc = document.form1.proc.checked;
        let impaco = document.form1.aco.checked;
        let impvlrunit = document.form1.vlrunt.checked;

        let query = "";

        for(let x=0; x <document.form1.listadelicitacoes.length; x++){
            procselect+=vir+document.form1.listadelicitacoes.options[x].value;
            vir=",";
        }

        if(document.form1.exercicio.value){
            query = '&exercicio='+document.form1.exercicio.value;
        }

        if(procselect){
            query += '&procselect='+procselect;
        }

        if(opselect){
            query += '&opselect='+opselect;
        }

        if(orderselect){
            query += '&orderselect='+orderselect;
        }

        if(impforne === true){
            query += '&impforne=true';
        }

        if(impproc === true){
            query += '&impproc=true';
        }
        if(impaco === true){
            query += '&impaco=true';
        }
        if(impvlrunit === true){
            query += '&impvlrunit=true';
        }

        if(impforne === true || impproc === true || impvlrunit === true || impaco === true){
            if(procselect === ''){
                alert('É necessário selecionar pelo menos um processo licitatório!');
                return false;
            }
        }

        jan = window.open('lic1_itenslicitados002.php?'+query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
        jan.moveTo(0, 0);

    }

    function js_validaCaracteres(){
    js_ValidaCamposText(document.form1.exercicio, 1);

    if(/[^0-9]/.test(document.form1.exercicio.value)){
        document.form1.exercicio.value = '';
    }
}

    function js_limitaExercicio(){
    if(document.form1.exercicio.value.length > 4 ){
        alert('Este campo deve conter apenas 4 caracteres');
        document.form1.exercicio.value = document.form1.exercicio.value.substr(0, 4);
    }
}

</script>
