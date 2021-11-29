<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_credenciamentotermo_classe.php");
include("classes/db_credenciamento_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clcredenciamentotermo = new cl_credenciamentotermo;
$clcredenciamento = new cl_credenciamento;
$db_opcao = 1;
$db_botao = true;
$sqlerro = false;
if(isset($incluir)){

    try {

        $resultNumeroTermo = $clcredenciamentotermo->sql_record($clcredenciamentotermo->sql_query(null,"l212_numerotermo","l212_numerotermo desc limit 1","l212_numerotermo = $l212_numerotermo"));

        if(pg_num_rows($resultNumeroTermo) > 0){
            throw new Exception("Usuário: Numero do Termo ja utilizado !");
            $sqlerro = true;
        }

        $rstermocredencialemnto = $clcredenciamentotermo->sql_record($clcredenciamentotermo->sql_query(null,"*",null,"l212_fornecedor = $l212_fornecedor and l212_licitacao = $l212_licitacao"));

        if(pg_num_rows($rstermocredencialemnto) > 0){
            throw new Exception("Usuário: Já existe termo cadastrado para esse fornecedor!");
            $sqlerro = true;
        }

        $rsdtCredenciamento = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"l205_datacred",null,"l205_licitacao = $l212_licitacao and l205_fornecedor = $l212_fornecedor"));

        db_fieldsmemory($rsdtCredenciamento,0);
        $data = (implode("/",(array_reverse(explode("-",$l205_datacred)))));

        $datacred = DateTime::createFromFormat('d/m/Y', $data);
        $dtiniciotermo = DateTime::createFromFormat('d/m/Y', $l212_dtinicio);

        if($dtiniciotermo < $datacred){
            throw new Exception("Usuário: Data de incio do termo menor que data de credenciamento.");
            $sqlerro = true;
        }

        if($sqlerro == false){
            db_inicio_transacao();
            $clcredenciamentotermo->l212_licitacao    = $l212_licitacao;
            $clcredenciamentotermo->l212_numerotermo  = $l212_numerotermo;
            $clcredenciamentotermo->l212_fornecedor   = $l212_fornecedor;
            $clcredenciamentotermo->l212_dtinicio     = $l212_dtinicio;
            $clcredenciamentotermo->l212_dtpublicacao = $l212_dtpublicacao;
            $clcredenciamentotermo->l212_anousu       = db_getsession('DB_anousu');
            $clcredenciamentotermo->l212_veiculodepublicacao = $l212_veiculodepublicacao;
            $clcredenciamentotermo->l212_observacao   = $l212_observacao;
            $clcredenciamentotermo->l212_instit       = db_getsession('DB_instit');
            $clcredenciamentotermo->incluir();
            db_fim_transacao();
    
            if($clcredenciamentotermo->erro_status == 0){
                $erro = $clcredenciamentotermo->erro_msg;
                $sqlerro = true;
            }
            db_fim_transacao();
            if($sqlerro == false){
                db_redireciona("lic1_credenciamentotermo002.php?&chavepesquisa=$clcredenciamentotermo->l212_sequencial");
            }
        }
        
    }catch (Exception $eErro){
        db_msgbox($eErro->getMessage());
    }

}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />
    <script type="text/javascript" src="scripts/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <?
    db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js, DBHint.widget.js");
    db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js,dbtextFieldData.widget.js");
    db_app::load("time.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
    <?
    include("forms/db_frmcredenciamentotermo.php");
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
    ?>
</body>
</html>
<script>
    js_tabulacaoforms("form1","l212_licitacao",true,1,"l212_licitacao",true);
</script>
