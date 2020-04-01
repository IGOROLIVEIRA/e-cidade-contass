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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("model/patrimonio/Bem.model.php");

$oGet = db_utils::postMemory($_GET);

$oBem = new Bem($oGet->bem);
$mostrarimagem = "func_mostrarimagem.php?oid=".$oBem->getFotoPrincipal();
$href = "<img src='".$mostrarimagem."' id='fotobem'>";
$fotos = $oBem->getFotos();

$sizeFotos = count($fotos);
$mostra_fotos = count($sizeFotos) == 1 ? true : false;

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"> <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
</head>
<style>
   #cabecalho p:first-child {
       padding: 18px;
       background: #fff;
       margin: 0px;
   }

    #rodape, #conteudo{
        text-align: center;
    }

    #rodape{
      margin-top: 5px;
    }

    #conteudo{
       text-align: -moz-center;
    }

    #container_image{
        margin-top: 10%;
        height: 300px;
        vertical-align: middle;
        text-align: center;
        display: table-cell;
    }

    #img_atual{
        max-height: 358px;
        display: block;
        margin: 10% auto auto auto;;
    }

    #contador{
        width: 4%;
        display: flex;
        margin-left: 568px;
        margin-top: 6px;
        border: 1px solid #999797;
    }
    #contImagem {
        text-align: right;
    }
    #contImagem, #totalImagem{
        width: 50%;
    }
    #contador span{
        padding: 2px;
    }

</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> <table height="100%" width="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
    <div id="cabecalho">
        <p><b>Imagens do Bem</b></p>
    </div>
    <div id="conteudo">
        <div id="container_image">
            <img src="" id="img_atual">
        </div>
    </div>
    <div id="contador">
        <span id="contImagem"></span>
        <span>/</span>
        <span id="totalImagem"></span>
    </div>
    <div id="rodape">
        <input type='button' id="inicio" value='Início' onclick="acaoFoto('inicio')">
        <input type='button' id="anterior" value='Anterior' onclick="acaoFoto('anterior')">
        <input type='button' id="proximo" value='Próximo' onclick="acaoFoto('proximo');">
        <input type='button' id="ultimo" value='Último' onclick="acaoFoto('ultimo')">
    </div>

</body>
</html>
<script>
    let sUrl = 'pat1_bensnovo.RPC.php';
    let indice_atual = '';
    js_buscaFotos();

    function js_buscaFotos(){
        var oParam = new Object();
        oParam.iBem = "<?= $oBem->getCodigoBem();?>";
        oParam.exec = "getFotos";
        var oAjax        = new Ajax.Request(
            sUrl,
            { parameters: 'json='+Object.toJSON(oParam),
                method: 'post',
                onComplete : js_retornoFotos
            });
    }
    function js_retornoFotos(oAjax){
        let response = eval('('+oAjax.responseText+')');
        fotos = response.itens;

        document.getElementById('totalImagem').innerText = fotos.length;
        if(response.length == 1){
            document.getElementById('inicio').disabled = true;
            document.getElementById('anterior').disabled = true;
            document.getElementById('proximo').disabled = true;
            document.getElementById('ultimo').disabled = true;
        }

        fotos.forEach((foto, index) => {
            if(foto.principal){
                let caminho = "<?="func_mostrarimagem.php?oid="?>"+foto.oid;
                let img = document.getElementById('img_atual');
                img.src = caminho;
                indice_atual = index;
                document.getElementById('contImagem').innerText = indice_atual+1;
            }
        });
        js_controlabotoes();
    }

    function acaoFoto(opcao){

        switch (opcao){
            case 'inicio':
                indice_atual = 0;
                break;
            case 'anterior':
                if(indice_atual){
                    indice_atual -= 1;
                }
                break;
            case 'proximo':
                if(indice_atual < fotos.length){
                    indice_atual += 1;
                }
                break;
            case 'ultimo':
                indice_atual = fotos.length - 1;
                break;
            default:
                indice_atual = 0;
                break;
        }
        document.getElementById('contImagem').innerText = indice_atual+1;
        let caminho = "<?="func_mostrarimagem.php?oid="?>"+fotos[indice_atual].oid;
        let img = document.getElementById('img_atual');
        img.src = caminho;

        js_controlabotoes();

    }

    function js_controlabotoes(){
        if(indice_atual == 0){
            document.getElementById('inicio').disabled = true;
            document.getElementById('anterior').disabled = true;
            if(fotos.length > 1){
                document.getElementById('proximo').disabled = false;
                document.getElementById('ultimo').disabled = false;
            }else{
                document.getElementById('proximo').disabled = true;
                document.getElementById('ultimo').disabled = true;
            }
        }else if(indice_atual == fotos.length - 1){
            document.getElementById('inicio').disabled = false;
            document.getElementById('anterior').disabled = false;
            document.getElementById('proximo').disabled = true;
            document.getElementById('ultimo').disabled = true;
        }else{
            document.getElementById('inicio').disabled = false;
            document.getElementById('anterior').disabled = false;
            document.getElementById('proximo').disabled = false;
            document.getElementById('ultimo').disabled = false;
        }
    }

</script>
