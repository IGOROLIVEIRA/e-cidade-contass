<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE liccontrolepncp
class cl_liccontrolepncp
{
    // cria variaveis de erro 
    public $rotulo     = null;
    public $query_sql  = null;
    public $numrows    = 0;
    public $numrows_incluir = 0;
    public $numrows_alterar = 0;
    public $numrows_excluir = 0;
    public $erro_status = null;
    public $erro_sql   = null;
    public $erro_banco = null;
    public $erro_msg   = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    // cria variaveis do arquivo 
    public $l213_sequencial = 0;
    public $l213_licitacao = 0;
    public $l213_dtlancamento_dia = null;
    public $l213_dtlancamento_mes = null;
    public $l213_dtlancamento_ano = null;
    public $l213_dtlancamento = null;
    public $l213_usuario = 0;
    public $l213_numerocontrolepncp = null;
    public $l213_situacao = null;
    public $l213_numerocompra = null;
    public $l213_anousu = null;
    public $l213_instit = 0;
    public $l213_processodecompras = 0;
    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 l213_sequencial = int8 = l213_sequencial 
                 l213_licitacao = int8 = l213_licitacao 
                 l213_usuario = int8 = l213_usuario
                 l213_dtlancamento = date = l213_dtlancamento 
                 l213_numerocontrolepncp = text = numero de controle do portal pncp 
                 l213_situacao = int8 = situacao da licitacao pncp
                 l213_numerocompra = int8 = numero da compra no pncp
                 l213_anousu = int8 = ano da compra
                 l213_instit = int8 = l213_instit 
                 l213_processodecompras = int8 = numero de processo de compras
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("liccontrolepncp");
        $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
    }

    //funcao erro 
    function erro($mostra, $retorna)
    {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
            echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
            if ($retorna == true) {
                echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao = false)
    {
        if ($exclusao == false) {
            $this->l213_sequencial = ($this->l213_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_sequencial"] : $this->l213_sequencial);
            $this->l213_licitacao = ($this->l213_licitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_licitacao"] : $this->l213_licitacao);
            if ($this->l213_dtlancamento == "") {
                $this->l213_dtlancamento_dia = ($this->l213_dtlancamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_dtlancamento_dia"] : $this->l213_dtlancamento_dia);
                $this->l213_dtlancamento_mes = ($this->l213_dtlancamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_dtlancamento_mes"] : $this->l213_dtlancamento_mes);
                $this->l213_dtlancamento_ano = ($this->l213_dtlancamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_dtlancamento_ano"] : $this->l213_dtlancamento_ano);
                if ($this->l213_dtlancamento_dia != "") {
                    $this->l213_dtlancamento = $this->l213_dtlancamento_ano . "-" . $this->l213_dtlancamento_mes . "-" . $this->l213_dtlancamento_dia;
                }
            }
            $this->l213_usuario = ($this->l213_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_usuario"] : $this->l213_usuario);
            $this->l213_numerocontrolepncp = ($this->l213_numerocontrolepncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_numerocontrolepncp"] : $this->l213_numerocontrolepncp);
            $this->l213_situacao = ($this->l213_situacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_situacao"] : $this->l213_situacao);
            $this->l213_numerocompra = ($this->l213_numerocompra == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_numerocompra"] : $this->l213_numerocompra);
            $this->l213_anousu = ($this->l213_anousu == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_anousu"] : $this->l213_anousu);
            $this->l213_instit = ($this->l213_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_instit"] : $this->l213_instit);
            $this->l213_processodecompras = ($this->l213_processodecompras == "" ? @$GLOBALS["HTTP_POST_VARS"]["l213_processodecompras"] : $this->l213_processodecompras);
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();

        if ($this->l213_dtlancamento == null) {
            $this->erro_sql = " Campo l213_dtlancamento não informado.";
            $this->erro_campo = "l213_dtlancamento_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_usuario == null) {
            $this->erro_sql = " Campo l213_usuario não informado.";
            $this->erro_campo = "l213_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_numerocontrolepncp == null) {
            $this->erro_sql = " Campo l213_numerocontrolepncp não informado.";
            $this->erro_campo = "l213_numerocontrolepncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_instit == null) {
            $this->erro_sql = " Campo l213_instit não informado.";
            $this->erro_campo = "l213_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_situacao == null) {
            $this->erro_sql = " Campo l213_situacao não informado.";
            $this->erro_campo = "l213_situacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_numerocompra == null) {
            $this->erro_sql = " Campo l213_numerocompra não informado.";
            $this->erro_campo = "l213_numerocompra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_anousu == null) {
            $this->erro_sql = " Campo l213_anousu não informado.";
            $this->erro_campo = "l213_anousu";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_licitacao == null || $this->l213_licitacao == "") {
            $this->l213_licitacao = "NULL";
        }
        if ($this->l213_processodecompras == null) {
            $this->l213_processodecompras = "NULL";
        }
        if ($this->l213_sequencial == "" || $this->l213_sequencial == null) {
            $result = db_query("select nextval('liccontrolepncp_l213_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: liccontrolepncp_l213_sequencial_seq do campo: l213_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l213_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from liccontrolepncp_l213_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->l213_sequencial)) {
                $this->erro_sql = " Campo l213_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->l213_sequencial = $this->l213_sequencial;
            }
        }
        if (($this->l213_sequencial == null) || ($this->l213_sequencial == "")) {
            $this->erro_sql = " Campo l213_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into liccontrolepncp(
                                       l213_sequencial 
                                      ,l213_licitacao 
                                      ,l213_usuario 
                                      ,l213_dtlancamento 
                                      ,l213_numerocontrolepncp
                                      ,l213_situacao 
                                      ,l213_numerocompra 
                                      ,l213_anousu 
                                      ,l213_instit 
                                      ,l213_processodecompras
                       )
                values (
                                $this->l213_sequencial 
                               ,$this->l213_licitacao 
                               ,$this->l213_usuario 
                               ," . ($this->l213_dtlancamento == "null" || $this->l213_dtlancamento == "" ? "null" : "'" . $this->l213_dtlancamento . "'") . " 
                               ,'$this->l213_numerocontrolepncp'
                               ,$this->l213_situacao
                               ,$this->l213_numerocompra
                               ,$this->l213_anousu
                               ,$this->l213_instit 
                               ,$this->l213_processodecompras
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "liccontrolepncp () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "liccontrolepncp já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "liccontrolepncp () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {
        }
        return true;
    }

    // funcao para alteracao
    function alterar($l213_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update liccontrolepncp set ";
        $virgula = "";
        if (trim($this->l213_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l213_sequencial"])) {
            $sql  .= $virgula . " l213_sequencial = $this->l213_sequencial ";
            $virgula = ",";
            if (trim($this->l213_sequencial) == null) {
                $this->erro_sql = " Campo l213_sequencial não informado.";
                $this->erro_campo = "l213_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_licitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l213_licitacao"])) {
            $sql  .= $virgula . " l213_licitacao = $this->l213_licitacao ";
            $virgula = ",";
            if (trim($this->l213_licitacao) == null) {
                $this->erro_sql = " Campo l213_licitacao não informado.";
                $this->erro_campo = "l213_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l213_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l213_dtlancamento_dia"] != "")) {
            $sql  .= $virgula . " l213_dtlancamento = '$this->l213_dtlancamento' ";
            $virgula = ",";
            if (trim($this->l213_dtlancamento) == null) {
                $this->erro_sql = " Campo l213_dtlancamento não informado.";
                $this->erro_campo = "l213_dtlancamento_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["l213_dtlancamento_dia"])) {
                $sql  .= $virgula . " l213_dtlancamento = null ";
                $virgula = ",";
                if (trim($this->l213_dtlancamento) == null) {
                    $this->erro_sql = " Campo l213_dtlancamento não informado.";
                    $this->erro_campo = "l213_dtlancamento_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->l213_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l213_usuario"])) {
            $sql  .= $virgula . " l213_usuario = $this->l213_usuario ";
            $virgula = ",";
            if (trim($this->l213_usuario) == null) {
                $this->erro_sql = " Campo l213_usuario não informado.";
                $this->erro_campo = "l213_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_numerocontrolepncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l213_numerocontrolepncp"])) {
            $sql  .= $virgula . " l213_numerocontrolepncp = '$this->l213_numerocontrolepncp' ";
            $virgula = ",";
            if (trim($this->l213_numerocontrolepncp) == null) {
                $this->erro_sql = " Campo l213_numerocontrolepncp não informado.";
                $this->erro_campo = "l213_numerocontrolepncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l213_instit"])) {
            $sql  .= $virgula . " l213_instit = $this->l213_instit ";
            $virgula = ",";
            if (trim($this->l213_instit) == null) {
                $this->erro_sql = " Campo l213_instit não informado.";
                $this->erro_campo = "l213_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_processodecompras) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l213_processodecompras"])) {
            $sql  .= $virgula . " l213_processodecompras = $this->l213_processodecompras ";
            $virgula = ",";
            if (trim($this->l213_processodecompras) == null) {
                $this->erro_sql = " Campo l213_processodecompras não informado.";
                $this->erro_campo = "l213_processodecompras";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "l213_sequencial = '$l213_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "liccontrolepncp nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liccontrolepncp nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao 
    function excluir($l213_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from liccontrolepncp
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "l213_sequencial = $l213_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "liccontrolepncp nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liccontrolepncp nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao do recordset 
    function sql_record($sql)
    {
        $result = db_query($sql);
        if ($result == false) {
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:liccontrolepncp";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($l213_sequencial = null, $campos = "liccontrolepncp.l213_sequencial,*", $ordem = null, $dbwhere = "")
    {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from liccontrolepncp ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l213_sequencial != "" && $l213_sequencial != null) {
                $sql2 = " where liccontrolepncp.l213_sequencial = '$l213_sequencial'";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    // funcao do sql 
    function sql_query_file($l213_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from liccontrolepncp ";
        $sql2 = "";
        if ($dbwhere == "") {
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
}
