<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liccontrolepncp_classe.php");

db_postmemory($HTTP_POST_VARS);

$clliccontrolepncp = new cl_liccontrolepncp();
try {
    if ($salvar){

        //verifica se ja nao existe um codigo de controle para a licitacao informada
        $rsResultadosPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null,"*",null,"l213_licitacao = {$l20_codigo}"));

        if(pg_num_rows($rsResultadosPNCP)){
            throw new Exception("Já existe uma Numero de Controle cadastrado para a licitacao codigo :  {$l20_codigo}");
        }

        $clliccontrolepncp->l213_licitacao = $l20_codigo;
        $clliccontrolepncp->l213_usuario = db_getsession('DB_id_usuario');
        $clliccontrolepncp->l213_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
        $clliccontrolepncp->l213_numerocontrolepncp = $l213_numerocontrolepncp;
        $clliccontrolepncp->l213_situacao = 1;
        $clliccontrolepncp->l213_numerocompra = $l213_numerocompra;
        $clliccontrolepncp->l213_anousu = $l213_anousu;
        $clliccontrolepncp->l213_instit = db_getsession('DB_instit');
        $clliccontrolepncp->incluir();

        if ($clliccontrolepncp->erro_status == 0) {
            throw new Exception($clliccontrolepncp->erro_msg);
        }else{
            db_msgbox("Numero de Controle Salvo com Sucesso!");
            db_redireciona("lic1_obterdadospncp.php");
        }
    }
    if($excluir){
        //verifica se ja nao existe um codigo de controle para a licitacao informada
        $rsResultadosPNCP = $clliccontrolepncp->sql_record($clliccontrolepncp->sql_query(null,"*",null,"l213_licitacao = {$l20_codigo}"));
        db_fieldsmemory($rsResultadosPNCP, 0);
        
        if(!pg_num_rows($rsResultadosPNCP)){
            throw new Exception("Numero de Controle não encontrado para a licitacao codigo :  {$l20_codigo}");
        }

        $clliccontrolepncp->excluir($l213_sequencial);

        if ($clliccontrolepncp->erro_status == 0) {
            throw new Exception($clliccontrolepncp->erro_msg);
        }else{
            db_msgbox("Numero de Controle Excluido com Sucesso!");
            db_redireciona("lic1_obterdadospncp.php");
        }
    }
}catch (Exception $eErro) {
    db_msgbox($eErro->getMessage());
}
?>
<head>
    <title>Contass Contabilidade Ltda - Página Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<html>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
    <center>
        <fieldset style="margin-top: 30px;">
            <legend>Obter dados PNCP</legend>
            <form name="form1" method="post" action="">
                <table border="0">
                    <tr>
                        <td>
                            <?php
                            db_ancora('Licitação:', "js_pesquisal20_codigo(true);", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?php
                            db_input('l20_codigo', 10, $Il20_codigo, true, 'text', 3, "");
                            db_input('l20_objeto', 80, $Il20_objeto, true, 'text', 3, '');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Numero de controle PNCP:</strong>
                        </td>
                        <td>
                            <?php
                                db_input('l213_numerocontrolepncp', 96, null, true, 'text', 1, 'onchange=js_extrairnumeropncp(this.value);');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Numero Compra:</strong>
                        </td>
                        <td>
                            <?php
                                db_input('l213_numerocompra', 10, null, true, 'text', 3, '');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Ano Compra:</strong>
                        </td>
                        <td>
                            <?php
                                db_input('l213_anousu', 10, null, true, 'text', 3, '');
                            ?>
                        </td>
                    </tr>
                </table>
                </br>
                <input type="submit" name="salvar" value="Salvar" />
                <input type="submit" name="excluir" value="Excluir" />
                </br>
            </form>
        </fieldset>
    </center>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>
    function js_pesquisal20_codigo(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_liclicita', 'func_obterdadospncp.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|l213_numerocontrolepncp|l213_numerocompra|l213_anousu', 'Pesquisa', true);
        }
    }

    function js_mostraliclicita1(l20_codigo, l20_objeto,l213_numerocontrolepncp,l213_numerocompra,l213_anousu) {
        document.form1.l20_codigo.value = l20_codigo;
        document.form1.l20_objeto.value = l20_objeto;
        document.form1.l213_numerocontrolepncp.value = l213_numerocontrolepncp;
        document.form1.l213_numerocompra.value = l213_numerocompra;
        document.form1.l213_anousu.value = l213_anousu;
        db_iframe_liclicita.hide();
    }

    function js_extrairnumeropncp(numerocontrole){
        let l213_numerocompra = Number(numerocontrole.slice(17,23));
        let l213_anousu = Number(numerocontrole.slice(24,28));
        
        if(l213_anousu == 0){
            alert("Numero de controle Invalido");
            document.getElementById('l213_numerocontrolepncp').value= '';
            document.getElementById('l213_numerocompra').value= '';
            document.getElementById('l213_anousu').value= '';
        }else{
            document.getElementById('l213_numerocompra').value=l213_numerocompra;
            document.getElementById('l213_anousu').value=l213_anousu;
        }

    }
</script>