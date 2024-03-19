<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfr4099
class cl_efdreinfr4099
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
    public $efd01_sequencial       = 0;
    public $efd01_mescompetencia   = 0;
    public $efd01_anocompetencia   = 0;
    public $efd01_cgm              = 0;
    public $efd01_tipo             = null;
    public $efd01_ambiente         = null;
    public $efd01_instit           = 0;
    public $efd01_protocolo        = 0;
    public $efd01_status           = 0;
    public $efd01_descResposta     = 0;
    public $efd01_dscResp          = 0;
    public $efd01_dataenvio        = 0;

    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd01_sequencial     = int8 = efd01_sequencial 
                 efd01_mescompetencia = int8 = efd01_mescompetencia
                 efd01_cgm            = int8 = efd01_cgm
                 efd01_tipo           = text = tipo de ambiente 
                 efd01_ambiente       = int8 = situacao da licitacao pncp
                 efd01_instit         = int8 = efd01_instit 
                 efd01_anocompetencia = int8 = efd01_anocompetencia 
                 efd01_protocolo      = text = Protocolo 
                 efd01_status         = int8 = Status
                 efd01_descResposta   = text = descResposta 
                 efd01_dscResp        = text = Protocolo 
                 efd01_dataenvio      = text = data envio
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfr4099");
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
            $this->efd01_sequencial = ($this->efd01_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_sequencial"] : $this->efd01_sequencial);
            $this->efd01_mescompetencia = ($this->efd01_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_licitacao"] : $this->efd01_mescompetencia);

            $this->efd01_cgm = ($this->efd01_cgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_cgm"] : $this->efd01_cgm);
            $this->efd01_tipo = ($this->efd01_tipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_tipo"] : $this->efd01_tipo);
            $this->efd01_ambiente = ($this->efd01_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_ambiente"] : $this->efd01_ambiente);
            $this->efd01_instit = ($this->efd01_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_instit"] : $this->efd01_instit);
            $this->efd01_anocompetencia = ($this->efd01_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_anocompetencia"] : $this->efd01_anocompetencia);
            $this->efd01_protocolo = ($this->efd01_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_protocolo"] : $this->efd01_protocolo);
            $this->efd01_status = ($this->efd01_status == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_status"] : $this->efd01_status);
            $this->efd01_descResposta = ($this->efd01_descResposta == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_descResposta"] : $this->efd01_descResposta);
            $this->efd01_dscResp = ($this->efd01_dscResp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_dscResp"] : $this->efd01_dscResp);
            $this->efd01_dataenvio = ($this->efd01_dataenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd01_dataenvio"] : $this->efd01_dataenvio);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();

        if ($this->efd01_mescompetencia == null) {
            $this->erro_sql = " Campo efd01_mescompetencia não informado.";
            $this->erro_campo = "efd01_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd01_anocompetencia == null) {
            $this->erro_sql = " Campo efd01_anocompetencia não informado.";
            $this->erro_campo = "efd01_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }


        if ($this->efd01_cgm == null) {
            $this->erro_sql = " Campo efd01_cgm não informado.";
            $this->erro_campo = "efd01_cgm";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd01_tipo == null) {
            $this->erro_sql = " Campo efd01_tipo não informado.";
            $this->erro_campo = "efd01_tipo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd01_instit == null) {
            $this->erro_sql = " Campo efd01_instit não informado.";
            $this->erro_campo = "efd01_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd01_ambiente == null) {
            $this->erro_sql = " Campo efd01_ambiente não informado.";
            $this->erro_campo = "efd01_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd01_status == null) {
            $this->efd01_status = 'null';
        }
        if ($this->efd01_dscResp == null) {
            $this->efd01_dscResp = "";
        }
        if ($this->efd01_sequencial == "" || $this->efd01_sequencial == null) {
            $result = db_query("select nextval('efdreinfr4099_efd01_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfr4099_efd01_sequencial_seq do campo: efd01_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd01_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfr4099_efd01_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd01_sequencial)) {
                $this->erro_sql = " Campo efd01_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd01_sequencial = $this->efd01_sequencial;
            }
        }
        if (($this->efd01_sequencial == null) || ($this->efd01_sequencial == "")) {
            $this->erro_sql = " Campo efd01_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfr4099(
                                       efd01_sequencial 
                                      ,efd01_mescompetencia
                                      ,efd01_anocompetencia
                                      ,efd01_cgm 
                                      ,efd01_tipo
                                      ,efd01_ambiente 
                                      ,efd01_instit 
                                      ,efd01_protocolo
                                      ,efd01_status
                                      ,efd01_descResposta
                                      ,efd01_dscResp
                                      ,efd01_dataenvio
                       )
                values (
                                $this->efd01_sequencial 
                               ,'$this->efd01_mescompetencia'
                               ,'$this->efd01_anocompetencia' 
                               ,$this->efd01_cgm 
                               ,$this->efd01_tipo
                               ,$this->efd01_ambiente
                               ,$this->efd01_instit
                               ,'$this->efd01_protocolo'
                               ,$this->efd01_status
                               ,'$this->efd01_descResposta'
                               ,'$this->efd01_dscResp'
                               ,'$this->efd01_dataenvio'
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfr4099 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfr4099 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfr4099 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd01_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfr4099 set ";
        $virgula = "";
        if (trim($this->efd01_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_sequencial"])) {
            $sql  .= $virgula . " efd01_sequencial = $this->efd01_sequencial ";
            $virgula = ",";
            if (trim($this->efd01_sequencial) == null) {
                $this->erro_sql = " Campo efd01_sequencial não informado.";
                $this->erro_campo = "efd01_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->efd01_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_mescompetencia"])) {
            $sql  .= $virgula . " efd01_mescompetencia= $this->efd01_mescompetencia";
            $virgula = ",";
            if (trim($this->efd01_mescompetencia) == null) {
                $this->erro_sql = " Campo efd01_mescompetencia não informado.";
                $this->erro_campo = "efd01_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd01_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_anocompetencia"])) {
            $sql  .= $virgula . " efd01_anocompetencia= $this->efd01_anocompetencia";
            $virgula = ",";
            if (trim($this->efd01_anocompetencia) == null) {
                $this->erro_sql = " Campo efd01_anocompetencia não informado.";
                $this->erro_campo = "efd01_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->efd01_cgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_cgm"])) {
            $sql  .= $virgula . " efd01_cgm = $this->efd01_cgm ";
            $virgula = ",";
            if (trim($this->efd01_cgm) == null) {
                $this->erro_sql = " Campo efd01_cgm não informado.";
                $this->erro_campo = "efd01_cgm";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd01_tipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_tipo"])) {
            $sql  .= $virgula . " efd01_tipo = '$this->efd01_tipo' ";
            $virgula = ",";
            if (trim($this->efd01_tipo) == null) {
                $this->erro_sql = " Campo efd01_tipo não informado.";
                $this->erro_campo = "efd01_tipo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd01_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_instit"])) {
            $sql  .= $virgula . " efd01_instit = $this->efd01_instit ";
            $virgula = ",";
            if (trim($this->efd01_instit) == null) {
                $this->erro_sql = " Campo efd01_instit não informado.";
                $this->erro_campo = "efd01_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd01_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_protocolo"])) {
            $sql  .= $virgula . " efd01_protocolo = $this->efd01_protocolo ";
            $virgula = ",";
            if (trim($this->efd01_protocolo) == null) {
                $this->erro_sql = " Campo efd01_protocolo não informado.";
                $this->erro_campo = "efd01_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd01_status) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_status"])) {
            $sql  .= $virgula . " efd01_status = $this->efd01_status ";
            $virgula = ",";
            if (trim($this->efd01_status) == null) {
                $this->erro_sql = " Campo efd01_status não informado.";
                $this->erro_campo = "efd01_status";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd01_descResposta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_descResposta"])) {
            $sql  .= $virgula . " efd01_descResposta = $this->efd01_descResposta ";
            $virgula = ",";
            if (trim($this->efd01_descResposta) == null) {
                $this->erro_sql = " Campo efd01_descResposta não informado.";
                $this->erro_campo = "efd01_descResposta";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd01_dscResp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_dscResp"])) {
            $this->efd01_dscResp = "";
            $sql  .= $virgula . " efd01_dscResp = $this->efd01_dscResp ";
            $virgula = ",";
        }
        if (trim($this->efd01_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd01_dataenvio"])) {
            $sql  .= $virgula . " efd01_dataenvio = $this->efd01_dataenvio ";
            $virgula = ",";
            if (trim($this->efd01_dataenvio) == null) {
                $this->erro_sql = " Campo efd01_dataenvio não informado.";
                $this->erro_campo = "efd01_dataenvio";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "efd01_sequencial = '$efd01_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr4099 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr4099 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd01_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfr4099
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd01_sequencial = $efd01_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr4099 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr4099 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfr4099";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd01_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr4099 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd01_sequencial != "" && $efd01_sequencial != null) {
                $sql2 = " where efdreinfr4099.efd01_sequencial = '$efd01_sequencial'";
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
    function sql_query_file($efd01_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr4099 ";
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
