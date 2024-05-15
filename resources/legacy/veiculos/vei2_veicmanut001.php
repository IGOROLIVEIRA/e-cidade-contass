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
include("dbforms/db_classesgenericas.php");
include("classes/db_veiculos_classe.php");
include("classes/db_veiccadcentral_classe.php");

include("classes/db_pcforne_classe.php");

require("libs/db_app.utils.php");
db_app::import("veiculos.*");

$clveiculos          = new cl_veiculos;
$clveicmanut         = new cl_veicmanut;
$clveicmanutoficina  = new cl_veicmanutoficina;
$clveicmanutretirada = new cl_veicmanutretirada;
$clveicretirada      = new cl_veicretirada;
$clveiccadcentral    = new cl_veiccadcentral();
$clveiculos          = new cl_veiculos;
$aux                 = new cl_arquivo_auxiliar;
$clpcforne           = new cl_pcforne;

db_postmemory($HTTP_POST_VARS);
$db_opcao = 1;
$db_botao = true;
$sqlerro  = false;
$clrotulo = new rotulocampo;
$clrotulo->label("ve20_descr");
$clrotulo->label("ve21_descr");
$clrotulo->label("ve22_descr");
$clrotulo->label("ve26_descr");
$clrotulo->label("ve75_destino");
$clveicmanut->rotulo->label();
$clpcforne->rotulo->label();

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

    <script>
        function js_emite(){
            var query = "";
            var obj   = document.form1;
            var lista_veic = "";
            var virgula    = "";

            if (obj.ve70_dataini.value != ""){
                query += "ve70_dataini=" +obj.ve70_dataini_ano.value+"-"+obj.ve70_dataini_mes.value+"-"+obj.ve70_dataini_dia.value;
            }

            if (obj.ve70_datafin.value != ""){
                query += "&ve70_datafin="+obj.ve70_datafin_ano.value+"-"+obj.ve70_datafin_mes.value+"-"+obj.ve70_datafin_dia.value;
            }

            // Funções nativas do JavaScript
            // slice:   retorna um novo Array a partir de elementos de um Array ou de um Array-like
            // call:    aplica um contexto para o `slice` ser executado, no caso, o contexto é `obj.veiculos`
            // map:     retorna um novo Array a partir do retorno da função aplicada em cada elemento do retorno de `.slice.call`
            // join:    retorna a transformação de um Array em String, juntando os elementos por `,`
            lista_veic = Array.prototype.slice
                .call(obj.veiculos)
                .map(function retornaValor(veiculo) {
                    return veiculo.value;
                })
                .join(',');

            if (query != ""){
                query += "&";
            }

            query += "ve01_codigo="+lista_veic;


            if (query != ""){
                query += "&";
            }

            var jan = window.open('vei2_veicmanut002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
            jan.moveTo(0,0);
        }


        function js_pesquisave01_veiccadmarca(mostra){
            if(mostra==true){
                js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_veiccadmarca','func_veiccadmarca.php?funcao_js=parent.js_mostraveiccadmarca1|ve21_codigo|ve21_descr','Pesquisa',true);
            }else{
                if(document.form1.ve01_veiccadmarca.value != ''){
                    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_veiccadmarca','func_veiccadmarca.php?pesquisa_chave='+document.form1.ve01_veiccadmarca.value+'&funcao_js=parent.js_mostraveiccadmarca','Pesquisa',false);
                }else{
                    document.form1.ve21_descr.value = '';
                }
            }
        }
        function js_mostraveiccadmarca(chave,erro){
            document.form1.ve21_descr.value = chave;
            if(erro==true){
                document.form1.ve01_veiccadmarca.focus();
                document.form1.ve01_veiccadmarca.value = '';
            }
        }
        function js_mostraveiccadmarca1(chave1,chave2){
            document.form1.ve01_veiccadmarca.value = chave1;
            document.form1.ve21_descr.value        = chave2;
            db_iframe_veiccadmarca.hide();
        }
        function js_pesquisave01_veiccadmodelo(mostra){
            if(mostra==true){
                js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_veiccadmodelo','func_veiccadmodelo.php?funcao_js=parent.js_mostraveiccadmodelo1|ve22_codigo|ve22_descr','Pesquisa',true);
            }else{
                if(document.form1.ve01_veiccadmodelo.value != ''){
                    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_veiccadmodelo','func_veiccadmodelo.php?pesquisa_chave='+document.form1.ve01_veiccadmodelo.value+'&funcao_js=parent.js_mostraveiccadmodelo','Pesquisa',false);
                }else{
                    document.form1.ve22_descr.value = '';
                }
            }
        }
        function js_mostraveiccadmodelo(chave,erro){
            document.form1.ve22_descr.value = chave;
            if(erro==true){
                document.form1.ve01_veiccadmodelo.focus();
                document.form1.ve01_veiccadmodelo.value = '';
            }
        }
        function js_mostraveiccadmodelo1(chave1,chave2){
            document.form1.ve01_veiccadmodelo.value = chave1;
            document.form1.ve22_descr.value         = chave2;
            db_iframe_veiccadmodelo.hide();
        }
    </script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
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

<table  align="center" border="0">
    <form name="form1" method="post" action="">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td nowrap align="right" title="Periodo"><b>Periodo:</b></td>
            <td>
                <?
                db_inputdata("ve70_dataini",@$ve70_dataini_dia,@$ve70_dataini_mes,@$ve70_dataini_ano,true,"text",4)
                ?>
                <b>&nbsp;a&nbsp;</b><?
                db_inputdata("ve70_datafin",@$ve70_datafin_dia,@$ve70_datafin_mes,@$ve70_datafin_ano,true,"text",4)
                ?>
            </td>
        </tr>

        <tr>
            <td colspan=2 >

                <?
                $aux->cabecalho      = "<strong>Veiculos</strong>";
                $aux->codigo         = "ve01_codigo";  //chave de retorno da func
                $aux->descr          = "ve01_placa";   //chave de retorno
                $aux->nomeobjeto     = 'veiculos';
                $aux->funcao_js      = 'js_mostraveiculos';//função javascript que será utilizada quando clicar na âncora
                $aux->funcao_js_hide = 'js_mostraveiculos1';//função javascript que será utilizada quando colocar um código e sair do campo
                $aux->sql_exec       = "";
                $aux->func_arquivo   = "func_veiculos.php";  //func a executar
                $aux->nomeiframe     = "db_iframe_veiculos";
                $aux->localjan       = "";
                $aux->onclick        = "";
                $aux->db_opcao       = 4;
                $aux->tipo           = 2;
                $aux->top            = 0;
                $aux->linhas         = 10;
                $aux->vwhidth        = 400;
                $aux->passar_query_string_para_func = "&tipoabast=1&central=";
                $aux->funcao_gera_formulario();
                ?>
            </td>
        </tr>
        <tr>
            <td height="50" colspan="2" align = "center">
                <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();">
            </td>
        </tr>
    </form>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>


<script>
    function js_mostraveiculos1(chave,chave1,chave2){
        if (chave==false){
            document.form1.ve01_placa.value  = "";
            document.form1.ve01_codigo.value = "";
            document.form1.ve01_placa.value  = chave2;
            document.form1.ve01_codigo.value = chave1;
            document.form1.db_lanca.onclick = js_insSelectveiculos;
        } else{
            document.form1.ve01_codigo.value = "";
            document.form1.ve01_placa.value  = "";
            alert("Código inexistente");
        }
    }

    function js_BuscaDadosArquivoveiculos(chave){
        document.form1.db_lanca.onclick = '';
        if(chave){
            js_OpenJanelaIframe('','db_iframe_veiculos','func_veiculos.php?funcao_js=parent.js_mostraveiculos|ve01_codigo|ve01_placa&tipoabast=1','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('','db_iframe_veiculos','func_veiculos.php?pesquisa_chave='+document.form1.ve01_codigo.value+'&funcao_js=parent.js_mostraveiculos1&tipoabast=1','Pesquisa',false);
        }
    }

    function js_pesquisave62_veiccadtiposervico(mostra){

        if(mostra==true){
            js_OpenJanelaIframe('','db_iframe_veiccadtiposervico','func_veiccadtiposervico.php?funcao_js=parent.js_mostraveiccadtiposervico1|ve28_codigo|ve28_descr','Pesquisa',true,'20','1');
        }else{
            if(document.form1.ve62_veiccadtiposervico.value != ''){
                js_OpenJanelaIframe('','db_iframe_veiccadtiposervico','func_veiccadtiposervico.php?pesquisa_chave='+document.form1.ve62_veiccadtiposervico.value+'&funcao_js=parent.js_mostraveiccadtiposervico','Pesquisa',false,'0','1','775','390');
            }else{
                document.form1.ve28_descr.value = '';
            }
        }
    }
    function js_mostraveiccadtiposervico(chave,erro){
        document.form1.ve28_descr.value = chave;
        if(erro==true){
            document.form1.ve62_veiccadtiposervico.focus();
            document.form1.ve62_veiccadtiposervico.value = '';
        }
    }
    function js_mostraveiccadtiposervico1(chave1,chave2){
        document.form1.ve62_veiccadtiposervico.value = chave1;
        document.form1.ve28_descr.value = chave2;
        db_iframe_veiccadtiposervico.hide();
    }

    function js_pesquisapc60_numcgm(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome|z01_cgccpf|z01_incest|z01_uf','Pesquisa',true,'20');
        }else{
            if(document.form1.pc60_numcgm.value != ''){
                js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?pesquisa_chave='+document.form1.pc60_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'20','1','775','390');
            }else{
                document.form1.z01_nome.value = '';
            }
        }
    }
    function js_mostracgm(erro,chave,cpf,incest,uf){
        document.form1.z01_nome.value = chave;
        document.form1.pc60_cnpjcpf.value = cpf;
        document.form1.pc60_inscriestadual.value = incest;
        document.form1.pc60_uf.value = uf;

        if(erro==true){
            document.form1.pc60_numcgm.focus();
            document.form1.pc60_numcgm.value = '';
            document.form1.pc60_cnpjcpf.value = '';
            document.form1.pc60_inscriestadual.value = '';
        }
    }
    function js_mostracgm1(chave1,chave2,cpf,incest, uf){
        document.form1.pc60_numcgm.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe_nomes.hide();
    }

</script>
