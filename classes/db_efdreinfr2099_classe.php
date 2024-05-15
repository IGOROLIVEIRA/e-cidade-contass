<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfr2099
class cl_efdreinfr2099
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
    public $efd04_sequencial       = 0;
    public $efd04_mescompetencia   = 0;
    public $efd04_anocompetencia   = 0;
    public $efd04_cgm              = 0;
    public $efd04_tipo             = null;
    public $efd04_ambiente         = null;
    public $efd04_instit           = 0;
    public $efd04_protocolo        = 0;
    public $efd04_status           = 0;
    public $efd04_descResposta     = 0;
    public $efd04_dscResp          = 0;
    public $efd04_dataenvio        = 0;
    public $efd04_servicoprev      = 0;
    public $efd04_producaorural    = 0;


    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd04_sequencial     = int8 = efd04_sequencial 
                 efd04_mescompetencia = int8 = efd04_mescompetencia
                 efd04_cgm            = int8 = efd04_cgm
                 efd04_tipo           = text = tipo de ambiente 
                 efd04_ambiente       = int8 = situacao da licitacao pncp
                 efd04_instit         = int8 = efd04_instit 
                 efd04_anocompetencia = int8 = efd04_anocompetencia 
                 efd04_protocolo      = text = Protocolo 
                 efd04_status         = int8 = Status
                 efd04_descResposta   = text = descResposta 
                 efd04_dscResp        = text = Protocolo 
                 efd04_dataenvio      = text = data envio
                 efd04_servicoprev    = int8 = Contratou serviços sujeitos à retenção de contribuição previdenciária
                 efd04_producaorural  = int8 = Possui informações sobre aquisição de produção rural?
             
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfr2099");
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
            $this->efd04_sequencial = ($this->efd04_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_sequencial"] : $this->efd04_sequencial);
            $this->efd04_mescompetencia = ($this->efd04_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_licitacao"] : $this->efd04_mescompetencia);

            $this->efd04_cgm = ($this->efd04_cgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_cgm"] : $this->efd04_cgm);
            $this->efd04_tipo = ($this->efd04_tipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_tipo"] : $this->efd04_tipo);
            $this->efd04_ambiente = ($this->efd04_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_ambiente"] : $this->efd04_ambiente);
            $this->efd04_instit = ($this->efd04_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_instit"] : $this->efd04_instit);
            $this->efd04_anocompetencia = ($this->efd04_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_anocompetencia"] : $this->efd04_anocompetencia);
            $this->efd04_protocolo = ($this->efd04_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_protocolo"] : $this->efd04_protocolo);
            $this->efd04_status = ($this->efd04_status == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_status"] : $this->efd04_status);
            $this->efd04_descResposta = ($this->efd04_descResposta == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_descResposta"] : $this->efd04_descResposta);
            $this->efd04_dscResp = ($this->efd04_dscResp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_dscResp"] : $this->efd04_dscResp);
            $this->efd04_dataenvio = ($this->efd04_dataenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_dataenvio"] : $this->efd04_dataenvio);
            $this->efd04_servicoprev = ($this->efd04_servicoprev == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_servicoprev"] : $this->efd04_servicoprev);
            $this->efd04_producaorural = ($this->efd04_producaorural == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_producaorural"] : $this->efd04_producaorural);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();

        if ($this->efd04_mescompetencia == null) {
            $this->erro_sql = " Campo efd04_mescompetencia não informado.";
            $this->erro_campo = "efd04_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd04_anocompetencia == null) {
            $this->erro_sql = " Campo efd04_anocompetencia não informado.";
            $this->erro_campo = "efd04_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }


        if ($this->efd04_cgm == null) {
            $this->erro_sql = " Campo efd04_cgm não informado.";
            $this->erro_campo = "efd04_cgm";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd04_tipo == null) {
            $this->erro_sql = " Campo efd04_tipo não informado.";
            $this->erro_campo = "efd04_tipo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd04_instit == null) {
            $this->erro_sql = " Campo efd04_instit não informado.";
            $this->erro_campo = "efd04_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd04_ambiente == null) {
            $this->erro_sql = " Campo efd04_ambiente não informado.";
            $this->erro_campo = "efd04_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd04_status == null) {
            $this->efd04_status = 'null';
        }
        if ($this->efd04_servicoprev == null) {
            $this->erro_sql = " Campo efd04_servicoprev não informado.";
            $this->erro_campo = "efd04_servicoprev";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd04_producaorural == null) {
            $this->erro_sql = " Campo efd04_producaorural não informado.";
            $this->erro_campo = "efd04_producaorural";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd04_dscResp == null) {
            $this->efd04_dscResp = "";
        }
        if ($this->efd04_sequencial == "" || $this->efd04_sequencial == null) {
            $result = db_query("select nextval('efdreinfr2099_efd04_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfr2099_efd04_sequencial_seq do campo: efd04_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd04_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfr2099_efd04_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd04_sequencial)) {
                $this->erro_sql = " Campo efd04_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd04_sequencial = $this->efd04_sequencial;
            }
        }
        if (($this->efd04_sequencial == null) || ($this->efd04_sequencial == "")) {
            $this->erro_sql = " Campo efd04_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfr2099(
                                       efd04_sequencial 
                                      ,efd04_mescompetencia
                                      ,efd04_anocompetencia
                                      ,efd04_cgm 
                                      ,efd04_tipo
                                      ,efd04_ambiente 
                                      ,efd04_instit 
                                      ,efd04_protocolo
                                      ,efd04_status
                                      ,efd04_descResposta
                                      ,efd04_dscResp
                                      ,efd04_dataenvio
                                      ,efd04_servicoprev
                                      ,efd04_producaorural
                       )
                values (
                                $this->efd04_sequencial 
                               ,'$this->efd04_mescompetencia'
                               ,'$this->efd04_anocompetencia' 
                               ,$this->efd04_cgm 
                               ,$this->efd04_tipo
                               ,$this->efd04_ambiente
                               ,$this->efd04_instit
                               ,'$this->efd04_protocolo'
                               ,$this->efd04_status
                               ,'$this->efd04_descResposta'
                               ,'$this->efd04_dscResp'
                               ,'$this->efd04_dataenvio'
                               ,$this->efd04_servicoprev
                               ,$this->efd04_producaorural
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfr2099 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfr2099 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfr2099 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd04_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfr2099 set ";
        $virgula = "";
        if (trim($this->efd04_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_sequencial"])) {
            $sql  .= $virgula . " efd04_sequencial = $this->efd04_sequencial ";
            $virgula = ",";
            if (trim($this->efd04_sequencial) == null) {
                $this->erro_sql = " Campo efd04_sequencial não informado.";
                $this->erro_campo = "efd04_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->efd04_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_mescompetencia"])) {
            $sql  .= $virgula . " efd04_mescompetencia= $this->efd04_mescompetencia";
            $virgula = ",";
            if (trim($this->efd04_mescompetencia) == null) {
                $this->erro_sql = " Campo efd04_mescompetencia não informado.";
                $this->erro_campo = "efd04_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_anocompetencia"])) {
            $sql  .= $virgula . " efd04_anocompetencia= $this->efd04_anocompetencia";
            $virgula = ",";
            if (trim($this->efd04_anocompetencia) == null) {
                $this->erro_sql = " Campo efd04_anocompetencia não informado.";
                $this->erro_campo = "efd04_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->efd04_cgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_cgm"])) {
            $sql  .= $virgula . " efd04_cgm = $this->efd04_cgm ";
            $virgula = ",";
            if (trim($this->efd04_cgm) == null) {
                $this->erro_sql = " Campo efd04_cgm não informado.";
                $this->erro_campo = "efd04_cgm";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_tipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_tipo"])) {
            $sql  .= $virgula . " efd04_tipo = '$this->efd04_tipo' ";
            $virgula = ",";
            if (trim($this->efd04_tipo) == null) {
                $this->erro_sql = " Campo efd04_tipo não informado.";
                $this->erro_campo = "efd04_tipo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_instit"])) {
            $sql  .= $virgula . " efd04_instit = $this->efd04_instit ";
            $virgula = ",";
            if (trim($this->efd04_instit) == null) {
                $this->erro_sql = " Campo efd04_instit não informado.";
                $this->erro_campo = "efd04_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_protocolo"])) {
            $sql  .= $virgula . " efd04_protocolo = $this->efd04_protocolo ";
            $virgula = ",";
            if (trim($this->efd04_protocolo) == null) {
                $this->erro_sql = " Campo efd04_protocolo não informado.";
                $this->erro_campo = "efd04_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_status) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_status"])) {
            $sql  .= $virgula . " efd04_status = $this->efd04_status ";
            $virgula = ",";
            if (trim($this->efd04_status) == null) {
                $this->erro_sql = " Campo efd04_status não informado.";
                $this->erro_campo = "efd04_status";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_servicoprev) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_servicoprev"])) {
            $sql  .= $virgula . " efd04_servicoprev = $this->efd04_servicoprev ";
            $virgula = ",";
            if (trim($this->efd04_servicoprev) == null) {
                $this->erro_sql = " Campo efd04_servicoprev não informado.";
                $this->erro_campo = "efd04_servicoprev";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_producaorural) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_producaorural"])) {
            $sql  .= $virgula . " efd04_producaorural = $this->efd04_producaorural ";
            $virgula = ",";
            if (trim($this->efd04_producaorural) == null) {
                $this->erro_sql = " Campo efd04_producaorural não informado.";
                $this->erro_campo = "efd04_producaorural";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_descResposta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_descResposta"])) {
            $sql  .= $virgula . " efd04_descResposta = $this->efd04_descResposta ";
            $virgula = ",";
            if (trim($this->efd04_descResposta) == null) {
                $this->erro_sql = " Campo efd04_descResposta não informado.";
                $this->erro_campo = "efd04_descResposta";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd04_dscResp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_dscResp"])) {
            $this->efd04_dscResp = "";
            $sql  .= $virgula . " efd04_dscResp = $this->efd04_dscResp ";
            $virgula = ",";
        }
        if (trim($this->efd04_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd04_dataenvio"])) {
            $sql  .= $virgula . " efd04_dataenvio = $this->efd04_dataenvio ";
            $virgula = ",";
            if (trim($this->efd04_dataenvio) == null) {
                $this->erro_sql = " Campo efd04_dataenvio não informado.";
                $this->erro_campo = "efd04_dataenvio";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "efd04_sequencial = '$efd04_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr2099 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr2099 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd04_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfr2099
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd04_sequencial = $efd04_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr2099 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr2099 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfr2099";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd04_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr2099 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd04_sequencial != "" && $efd04_sequencial != null) {
                $sql2 = " where efdreinfr2099.efd04_sequencial = '$efd04_sequencial'";
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
    function sql_query_file($efd04_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr2099 ";
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
