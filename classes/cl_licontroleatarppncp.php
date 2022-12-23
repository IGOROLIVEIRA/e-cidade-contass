<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE licontroleatarppncp
class cl_licontroleatarppncp
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
    public $l215_sequencial = 0;
    public $l215_licitacao = 0;
    public $l215_dtlancamento_dia = null;
    public $l215_dtlancamento_mes = null;
    public $l215_dtlancamento_ano = null;
    public $l215_dtlancamento = null;
    public $l215_usuario = 0;
    public $l215_numerocontrolepncp = null;
    public $l215_situacao = null;
    public $l215_ata = null;
    public $l215_anousu = null;
    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 l215_sequencial = int8 = l215_sequencial 
                 l215_licitacao = int8 = l215_licitacao 
                 l215_usuario = int8 = l215_usuario
                 l215_dtlancamento = date = l215_dtlancamento 
                 l215_numerocontrolepncp = text = numero de controle do portal pncp 
                 l215_situacao = int8 = situacao da licitacao pncp
                 l215_ata = int8 = numero da compra no pncp
                 l215_anousu = int8 = ano da compra
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("licontroleatarppncp");
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
            $this->l215_sequencial = ($this->l215_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_sequencial"] : $this->l215_sequencial);
            $this->l215_licitacao = ($this->l215_licitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_licitacao"] : $this->l215_licitacao);
            if ($this->l215_dtlancamento == "") {
                $this->l215_dtlancamento_dia = ($this->l215_dtlancamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_dtlancamento_dia"] : $this->l215_dtlancamento_dia);
                $this->l215_dtlancamento_mes = ($this->l215_dtlancamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_dtlancamento_mes"] : $this->l215_dtlancamento_mes);
                $this->l215_dtlancamento_ano = ($this->l215_dtlancamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_dtlancamento_ano"] : $this->l215_dtlancamento_ano);
                if ($this->l215_dtlancamento_dia != "") {
                    $this->l215_dtlancamento = $this->l215_dtlancamento_ano . "-" . $this->l215_dtlancamento_mes . "-" . $this->l215_dtlancamento_dia;
                }
            }
            $this->l215_usuario = ($this->l215_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_usuario"] : $this->l215_usuario);
            $this->l215_numerocontrolepncp = ($this->l215_numerocontrolepncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_numerocontrolepncp"] : $this->l215_numerocontrolepncp);
            $this->l215_situacao = ($this->l215_situacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_situacao"] : $this->l215_situacao);
            $this->l215_ata = ($this->l215_ata == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_ata"] : $this->l215_ata);
            $this->l215_anousu = ($this->l215_anousu == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_anousu"] : $this->l215_anousu);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();

        if ($this->l215_licitacao == null) {
            $this->erro_sql = " Campo l215_licitacao não informado.";
            $this->erro_campo = "l215_licitacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l215_dtlancamento == null) {
            $this->erro_sql = " Campo l215_dtlancamento não informado.";
            $this->erro_campo = "l215_dtlancamento_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l215_usuario == null) {
            $this->erro_sql = " Campo l215_usuario não informado.";
            $this->erro_campo = "l215_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l215_numerocontrolepncp == null) {
            $this->erro_sql = " Campo l215_numerocontrolepncp não informado.";
            $this->erro_campo = "l215_numerocontrolepncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l215_situacao == null) {
            $this->erro_sql = " Campo l215_situacao não informado.";
            $this->erro_campo = "l215_situacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l215_ata == null) {
            $this->erro_sql = " Campo l215_ata não informado.";
            $this->erro_campo = "l215_ata";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l215_anousu == null) {
            $this->erro_sql = " Campo l215_anousu não informado.";
            $this->erro_campo = "l215_anousu";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l215_sequencial == "" || $this->l215_sequencial == null) {
            $result = db_query("select nextval('licontroleatarppncp_l215_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: licontroleatarppncp_l215_sequencial_seq do campo: l215_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l215_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from licontroleatarppncp_l215_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->l215_sequencial)) {
                $this->erro_sql = " Campo l215_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->l215_sequencial = $this->l215_sequencial;
            }
        }
        if (($this->l215_sequencial == null) || ($this->l215_sequencial == "")) {
            $this->erro_sql = " Campo l215_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into licontroleatarppncp(
                                       l215_sequencial 
                                      ,l215_licitacao 
                                      ,l215_usuario 
                                      ,l215_dtlancamento 
                                      ,l215_numerocontrolepncp
                                      ,l215_situacao 
                                      ,l215_ata 
                                      ,l215_anousu  
                       )
                values (
                                $this->l215_sequencial 
                               ,$this->l215_licitacao 
                               ,$this->l215_usuario 
                               ," . ($this->l215_dtlancamento == "null" || $this->l215_dtlancamento == "" ? "null" : "'" . $this->l215_dtlancamento . "'") . " 
                               ,'$this->l215_numerocontrolepncp'
                               ,$this->l215_situacao
                               ,$this->l215_ata
                               ,$this->l215_anousu
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "licontroleatarppncp () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "licontroleatarppncp já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "licontroleatarppncp () nao Incluído. Inclusao Abortada.";
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
    function alterar($l215_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update licontroleatarppncp set ";
        $virgula = "";
        if (trim($this->l215_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_sequencial"])) {
            $sql  .= $virgula . " l215_sequencial = $this->l215_sequencial ";
            $virgula = ",";
            if (trim($this->l215_sequencial) == null) {
                $this->erro_sql = " Campo l215_sequencial não informado.";
                $this->erro_campo = "l215_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l215_licitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_licitacao"])) {
            $sql  .= $virgula . " l215_licitacao = $this->l215_licitacao ";
            $virgula = ",";
            if (trim($this->l215_licitacao) == null) {
                $this->erro_sql = " Campo l215_licitacao não informado.";
                $this->erro_campo = "l215_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l215_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l215_dtlancamento_dia"] != "")) {
            $sql  .= $virgula . " l215_dtlancamento = '$this->l215_dtlancamento' ";
            $virgula = ",";
            if (trim($this->l215_dtlancamento) == null) {
                $this->erro_sql = " Campo l215_dtlancamento não informado.";
                $this->erro_campo = "l215_dtlancamento_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["l215_dtlancamento_dia"])) {
                $sql  .= $virgula . " l215_dtlancamento = null ";
                $virgula = ",";
                if (trim($this->l215_dtlancamento) == null) {
                    $this->erro_sql = " Campo l215_dtlancamento não informado.";
                    $this->erro_campo = "l215_dtlancamento_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->l215_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_usuario"])) {
            $sql  .= $virgula . " l215_usuario = $this->l215_usuario ";
            $virgula = ",";
            if (trim($this->l215_usuario) == null) {
                $this->erro_sql = " Campo l215_usuario não informado.";
                $this->erro_campo = "l215_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l215_numerocontrolepncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_numerocontrolepncp"])) {
            $sql  .= $virgula . " l215_numerocontrolepncp = '$this->l215_numerocontrolepncp' ";
            $virgula = ",";
            if (trim($this->l215_numerocontrolepncp) == null) {
                $this->erro_sql = " Campo l215_numerocontrolepncp não informado.";
                $this->erro_campo = "l215_numerocontrolepncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "l215_sequencial = '$l215_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "licontroleatarppncp nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "licontroleatarppncp nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($l215_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from licontroleatarppncp
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "l215_sequencial = $l215_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "licontroleatarppncp nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "licontroleatarppncp nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:licontroleatarppncp";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($l215_sequencial = null, $campos = "licontroleatarppncp.l215_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from licontroleatarppncp ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l215_sequencial != "" && $l215_sequencial != null) {
                $sql2 = " where licontroleatarppncp.l215_sequencial = '$l215_sequencial'";
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
    function sql_query_file($l215_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from licontroleatarppncp ";
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
