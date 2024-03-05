<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE acocontratopncp
class cl_acocontratopncp
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
    public $ac213_sequencial = 0;
    public $ac213_contrato = 0;
    public $ac213_dtlancamento_dia = null;
    public $ac213_dtlancamento_mes = null;
    public $ac213_dtlancamento_ano = null;
    public $ac213_dtlancamento = null;
    public $ac213_usuario = 0;
    public $ac213_numerocontrolepncp = null;
    public $ac213_situacao = null;
    public $ac213_instit = 0;
    public $ac213_ano = 0;
    public $ac213_sequencialpncp = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 ac213_sequencial = int8 = ac213_sequencial
                 ac213_contrato= int8 = ac213_contrato
                 ac213_usuario = int8 = ac213_usuario
                 ac213_dtlancamento = date = ac213_dtlancamento
                 ac213_numerocontrolepncp = text = numero de controle do portal pncp
                 ac213_situacao = int8 = situacao da licitacao pncp
                 ac213_instit = int8 = ac213_instit
                 ac213_ano =  int8 = ac213_ano
                 ac213_sequencialpncp = int8 = ac213_sequencialpncp
                 ";

    //funcao construtor da classe
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("acocontratopncp");
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
            $this->ac213_sequencial = ($this->ac213_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_sequencial"] : $this->ac213_sequencial);
            $this->ac213_contrato = ($this->ac213_contrato == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_licitacao"] : $this->ac213_contrato);
            if ($this->ac213_dtlancamento == "") {
                $this->ac213_dtlancamento_dia = ($this->ac213_dtlancamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_dtlancamento_dia"] : $this->ac213_dtlancamento_dia);
                $this->ac213_dtlancamento_mes = ($this->ac213_dtlancamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_dtlancamento_mes"] : $this->ac213_dtlancamento_mes);
                $this->ac213_dtlancamento_ano = ($this->ac213_dtlancamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_dtlancamento_ano"] : $this->ac213_dtlancamento_ano);
                if ($this->ac213_dtlancamento_dia != "") {
                    $this->ac213_dtlancamento = $this->ac213_dtlancamento_ano . "-" . $this->ac213_dtlancamento_mes . "-" . $this->ac213_dtlancamento_dia;
                }
            }
            $this->ac213_usuario = ($this->ac213_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_usuario"] : $this->ac213_usuario);
            $this->ac213_numerocontrolepncp = ($this->ac213_numerocontrolepncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_numerocontrolepncp"] : $this->ac213_numerocontrolepncp);
            $this->ac213_situacao = ($this->ac213_situacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_situacao"] : $this->ac213_situacao);
            $this->ac213_instit = ($this->ac213_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_instit"] : $this->ac213_instit);
            $this->ac213_ano = ($this->ac213_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_ano"] : $this->ac213_ano);
            $this->ac213_sequencialpncp = ($this->ac213_sequencialpncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac213_sequencialpncp"] : $this->ac213_sequencialpncp);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();

        if ($this->ac213_contrato == null) {
            $this->erro_sql = " Campo ac213_contrato não informado.";
            $this->erro_campo = "ac213_contrato";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_ano == null) {
            $this->erro_sql = " Campo ac213_ano não informado.";
            $this->erro_campo = "ac213_ano";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_sequencialpncp == null) {
            $this->erro_sql = " Campo ac213_sequencialpncp não informado.";
            $this->erro_campo = "ac213_sequencialpncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_dtlancamento == null) {
            $this->erro_sql = " Campo ac213_dtlancamento não informado.";
            $this->erro_campo = "ac213_dtlancamento_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_usuario == null) {
            $this->erro_sql = " Campo ac213_usuario não informado.";
            $this->erro_campo = "ac213_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_numerocontrolepncp == null) {
            $this->erro_sql = " Campo ac213_numerocontrolepncp não informado.";
            $this->erro_campo = "ac213_numerocontrolepncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_instit == null) {
            $this->erro_sql = " Campo ac213_instit não informado.";
            $this->erro_campo = "ac213_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_situacao == null) {
            $this->erro_sql = " Campo ac213_situacao não informado.";
            $this->erro_campo = "ac213_situacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac213_sequencial == "" || $this->ac213_sequencial == null) {
            $result = db_query("select nextval('acocontratopncp_ac213_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: acocontratopncp_ac213_sequencial_seq do campo: ac213_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->ac213_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from acocontratopncp_ac213_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->ac213_sequencial)) {
                $this->erro_sql = " Campo ac213_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->ac213_sequencial = $this->ac213_sequencial;
            }
        }
        if (($this->ac213_sequencial == null) || ($this->ac213_sequencial == "")) {
            $this->erro_sql = " Campo ac213_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into acocontratopncp(
                                       ac213_sequencial
                                      ,ac213_contrato
                                      ,ac213_usuario
                                      ,ac213_dtlancamento
                                      ,ac213_numerocontrolepncp
                                      ,ac213_situacao
                                      ,ac213_instit
                                      ,ac213_ano
                                      ,ac213_sequencialpncp

                       )
                values (
                                $this->ac213_sequencial
                               ,$this->ac213_contrato
                               ,$this->ac213_usuario
                               ," . ($this->ac213_dtlancamento == "null" || $this->ac213_dtlancamento == "" ? "null" : "'" . $this->ac213_dtlancamento . "'") . "
                               ,'$this->ac213_numerocontrolepncp'
                               ,$this->ac213_situacao
                               ,$this->ac213_instit
                               ,$this->ac213_ano
                               ,$this->ac213_sequencialpncp

                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "acocontratopncp () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "acocontratopncp já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "acocontratopncp () nao Incluído. Inclusao Abortada.";
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
    function alterar($ac213_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update acocontratopncp set ";
        $virgula = "";
        if (trim($this->ac213_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_sequencial"])) {
            $sql  .= $virgula . " ac213_sequencial = $this->ac213_sequencial ";
            $virgula = ",";
            if (trim($this->ac213_sequencial) == null) {
                $this->erro_sql = " Campo ac213_sequencial não informado.";
                $this->erro_campo = "ac213_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->ac213_contrato) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_contrato"])) {
            $sql  .= $virgula . " ac213_contrato= $this->ac213_contrato";
            $virgula = ",";
            if (trim($this->ac213_licitacao) == null) {
                $this->erro_sql = " Campo ac213_contrato não informado.";
                $this->erro_campo = "ac213_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac213_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_ano"])) {
            $sql  .= $virgula . " ac213_ano= $this->ac213_ano";
            $virgula = ",";
            if (trim($this->ac213_ano) == null) {
                $this->erro_sql = " Campo ac213_ano não informado.";
                $this->erro_campo = "ac213_ano";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac213_sequencialpncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_sequencialpncp"])) {
            $sql  .= $virgula . " ac213_sequencialpncp= $this->ac213_sequencialpncp";
            $virgula = ",";
            if (trim($this->ac213_sequencialpncp) == null) {
                $this->erro_sql = " Campo ac213_sequencialpncp não informado.";
                $this->erro_campo = "ac213_sequencialpncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac213_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ac213_dtlancamento_dia"] != "")) {
            $sql  .= $virgula . " ac213_dtlancamento = '$this->ac213_dtlancamento' ";
            $virgula = ",";
            if (trim($this->ac213_dtlancamento) == null) {
                $this->erro_sql = " Campo ac213_dtlancamento não informado.";
                $this->erro_campo = "ac213_dtlancamento_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["ac213_dtlancamento_dia"])) {
                $sql  .= $virgula . " ac213_dtlancamento = null ";
                $virgula = ",";
                if (trim($this->ac213_dtlancamento) == null) {
                    $this->erro_sql = " Campo ac213_dtlancamento não informado.";
                    $this->erro_campo = "ac213_dtlancamento_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->ac213_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_usuario"])) {
            $sql  .= $virgula . " ac213_usuario = $this->ac213_usuario ";
            $virgula = ",";
            if (trim($this->ac213_usuario) == null) {
                $this->erro_sql = " Campo ac213_usuario não informado.";
                $this->erro_campo = "ac213_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac213_numerocontrolepncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_numerocontrolepncp"])) {
            $sql  .= $virgula . " ac213_numerocontrolepncp = '$this->ac213_numerocontrolepncp' ";
            $virgula = ",";
            if (trim($this->ac213_numerocontrolepncp) == null) {
                $this->erro_sql = " Campo ac213_numerocontrolepncp não informado.";
                $this->erro_campo = "ac213_numerocontrolepncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac213_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac213_instit"])) {
            $sql  .= $virgula . " ac213_instit = $this->ac213_instit ";
            $virgula = ",";
            if (trim($this->ac213_instit) == null) {
                $this->erro_sql = " Campo ac213_instit não informado.";
                $this->erro_campo = "ac213_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "ac213_sequencial = '$ac213_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "acocontratopncp nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "acocontratopncp nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($ac213_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from acocontratopncp
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "ac213_sequencial = $ac213_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "acocontratopncp nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "acocontratopncp nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:acocontratopncp";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($ac213_sequencial = null, $campos = "acocontratopncp.ac213_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from acocontratopncp ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($ac213_sequencial != "" && $ac213_sequencial != null) {
                $sql2 = " where acocontratopncp.ac213_sequencial = '$ac213_sequencial'";
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
        // die($sql);
        return $sql;
    }

    // funcao do sql
    function sql_query_file($ac213_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from acocontratopncp ";
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
