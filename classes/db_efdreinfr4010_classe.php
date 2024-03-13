<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfr4010
class cl_efdreinfr4010
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
    public $efd03_sequencial         = 0;
    public $efd03_cpfbeneficiario   = 0;
    public $efd03_identificadorop    = null;
    public $efd03_naturezarendimento = 0;
    public $efd03_datafg             = 0;
    public $efd03_datafg_dia         = 0;
    public $efd03_datafg_mes         = 0;
    public $efd03_datafg_ano         = 0;
    public $efd03_dataenvio          = 0;
    public $efd03_valorbruto         = 0;
    public $efd03_valorbase          = 0;
    public $efd03_valorirrf          = 0;
    public $efd03_mescompetencia     = 0;
    public $efd03_anocompetencia     = 0;
    public $efd03_ambiente           = null;
    public $efd03_instit             = 0;
    public $efd03_protocolo          = 0;
    public $efd03_numcgm             = 0;
    public $efd03_status             = 0;
    public $efd03_descResposta       = 0;
    public $efd03_dscResp            = 0;

    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd03_sequencial       = int8 = sequencial 
                 efd03_mescompetencia   = int8 = mes competencia
                 efd03_cpfbeneficiario = int8 = cpf beneficiario
                 efd03_identificadorop  = int8 = tipo de ambiente 
                 efd03_ambiente         = int8 = tipo de ambiente 
                 efd03_instit           = int8 = instittuicao 
                 efd03_anocompetencia   = int8 = ano competencia 
                 efd03_naturezarendimento = int8 = natureza rendimento 
                 efd03_valorbruto         = float8 = valor bruto
                 efd03_valorbase        = float8 = valor base
                 efd03_valorirrf        = float8 = valor irrf 
                 efd03_datafg           = date = data 
                 efd03_protocolo        = text = protocolo 
                 efd03_dataenvio        = text = Data de Envio
                 efd03_numcgm           = int8 = numcgm    
                 efd03_status           = int8 = Status
                 efd03_descResposta     = text = descResposta 
                 efd03_dscResp          = text = Protocolo 
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfr4010");
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
            $this->efd03_sequencial = ($this->efd03_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_sequencial"] : $this->efd03_sequencial);
            $this->efd03_mescompetencia = ($this->efd03_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_licitacao"] : $this->efd03_mescompetencia);
            $this->efd03_cpfbeneficiario = ($this->efd03_cpfbeneficiario == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_cpfbeneficiario"] : $this->efd03_cpfbeneficiario);
            $this->efd03_identificadorop = ($this->efd03_identificadorop == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_identificadorop"] : $this->efd03_identificadorop);
            $this->efd03_ambiente = ($this->efd03_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_ambiente"] : $this->efd03_ambiente);
            $this->efd03_instit = ($this->efd03_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_instit"] : $this->efd03_instit);
            $this->efd03_anocompetencia = ($this->efd03_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_anocompetencia"] : $this->efd03_anocompetencia);
            $this->efd03_naturezarendimento = ($this->efd03_naturezarendimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_naturezarendimento"] : $this->efd03_naturezarendimento);
            $this->efd03_valorbruto = ($this->efd03_valorbruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_valorbruto"] : $this->efd03_valorbruto);
            $this->efd03_valorbase = ($this->efd03_valorbase == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_valorbase"] : $this->efd03_valorbase);
            $this->efd03_valorirrf = ($this->efd03_valorirrf == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_valorirrf"] : $this->efd03_valorirrf);
            if ($this->efd03_datafg == "") {
                $this->efd03_datafg_dia = ($this->efd03_datafg_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_datafg_dia"] : $this->efd03_datafg_dia);
                $this->efd03_datafg_mes = ($this->efd03_datafg_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_datafg_mes"] : $this->efd03_datafg_mes);
                $this->efd03_datafg_ano = ($this->efd03_datafg_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_datafg_ano"] : $this->efd03_datafg_ano);
                if ($this->efd03_datafg_dia != "") {
                    $this->efd03_datafg = $this->efd03_datafg_ano . "-" . $this->efd03_datafg_mes . "-" . $this->efd03_datafg_dia;
                }
            }
            $this->efd03_protocolo = ($this->efd03_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_protocolo"] : $this->efd03_protocolo);
            $this->efd03_dataenvio = ($this->efd03_dataenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_dataenvio"] : $this->efd03_dataenvio);
            $this->efd03_numcgm = ($this->efd03_numcgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_numcgm"] : $this->efd03_numcgm);
            $this->efd03_status = ($this->efd03_status == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_status"] : $this->efd03_status);
            $this->efd03_descResposta = ($this->efd03_descResposta == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_descResposta"] : $this->efd03_descResposta);
            $this->efd03_dscResp = ($this->efd03_dscResp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd03_dscResp"] : $this->efd03_dscResp);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();

        if ($this->efd03_mescompetencia == null) {
            $this->erro_sql = " Campo efd03_mescompetencia não informado.";
            $this->erro_campo = "efd03_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_anocompetencia == null) {
            $this->erro_sql = " Campo efd03_anocompetencia não informado.";
            $this->erro_campo = "efd03_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_cpfbeneficiario == null) {
            $this->erro_sql = " Campo efd03_cpfbeneficiario não informado.";
            $this->erro_campo = "efd03_cpfbeneficiario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_identificadorop == null) {
            $this->erro_sql = " Campo efd03_identificadorop não informado.";
            $this->erro_campo = "efd03_identificadorop";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_instit == null) {
            $this->erro_sql = " Campo efd03_instit não informado.";
            $this->erro_campo = "efd03_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_ambiente == null) {
            $this->erro_sql = " Campo efd03_ambiente não informado.";
            $this->erro_campo = "efd03_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_naturezarendimento == null) {
            $this->erro_sql = " Campo efd03_naturezarendimento não informado.";
            $this->erro_campo = "efd03_naturezarendimento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_valorbruto == null) {
            $this->efd03_valorbruto = 0;
        }
        if ($this->efd03_valorbase == null) {
            $this->efd03_valorbase = 0;
        }
        if ($this->efd03_valorirrf == null) {
            $this->efd03_valorirrf = 0;
        }
        if ($this->efd03_datafg == null) {
            $this->erro_sql = " Campo efd03_datafg não informado.";
            $this->erro_campo = "efd03_datafg";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_numcgm == null) {
            $this->erro_sql = " Campo efd03_numcgm não informado.";
            $this->erro_campo = "efd03_numcgm";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd03_status == null) {
            $this->efd03_status = 'null';
        }
        if ($this->efd03_sequencial == "" || $this->efd03_sequencial == null) {
            $result = db_query("select nextval('efdreinfr4010_efd03_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfr4010_efd03_sequencial_seq do campo: efd03_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd03_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfr4010_efd03_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd03_sequencial)) {
                $this->erro_sql = " Campo efd03_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd03_sequencial = $this->efd03_sequencial;
            }
        }
        if (($this->efd03_sequencial == null) || ($this->efd03_sequencial == "")) {
            $this->erro_sql = " Campo efd03_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfr4010(
                                       efd03_sequencial 
                                      ,efd03_mescompetencia
                                      ,efd03_anocompetencia
                                      ,efd03_cpfbeneficiario 
                                      ,efd03_identificadorop
                                      ,efd03_ambiente 
                                      ,efd03_instit 
                                      ,efd03_naturezarendimento
                                      ,efd03_valorbruto
                                      ,efd03_valorbase
                                      ,efd03_valorirrf
                                      ,efd03_datafg
                                      ,efd03_protocolo
                                      ,efd03_dataenvio
                                      ,efd03_numcgm
                                      ,efd03_status
                                      ,efd03_descResposta
                                      ,efd03_dscResp
                       )
                values (
                                $this->efd03_sequencial 
                               ,'$this->efd03_mescompetencia'
                               ,'$this->efd03_anocompetencia '
                               ,'$this->efd03_cpfbeneficiario' 
                               ,$this->efd03_identificadorop
                               ,$this->efd03_ambiente
                               ,$this->efd03_instit
                               ,$this->efd03_naturezarendimento
                               ,$this->efd03_valorbruto
                               ,$this->efd03_valorbase
                               ,$this->efd03_valorirrf
                               ,'$this->efd03_datafg'
                               ,'$this->efd03_protocolo'
                               ,'$this->efd03_dataenvio'
                               ,$this->efd03_numcgm
                               ,$this->efd03_status
                               ,'$this->efd03_descResposta'
                               ,'$this->efd03_dscResp'
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfr4010 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfr4010 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfr4010 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd03_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfr4010 set ";
        $virgula = "";
        if (trim($this->efd03_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_sequencial"])) {
            $sql  .= $virgula . " efd03_sequencial = $this->efd03_sequencial ";
            $virgula = ",";
            if (trim($this->efd03_sequencial) == null) {
                $this->erro_sql = " Campo efd03_sequencial não informado.";
                $this->erro_campo = "efd03_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_mescompetencia"])) {
            $sql  .= $virgula . " efd03_mescompetencia= $this->efd03_mescompetencia";
            $virgula = ",";
            if (trim($this->efd03_mescompetencia) == null) {
                $this->erro_sql = " Campo efd03_mescompetencia não informado.";
                $this->erro_campo = "efd03_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_anocompetencia"])) {
            $sql  .= $virgula . " efd03_anocompetencia= $this->efd03_anocompetencia";
            $virgula = ",";
            if (trim($this->efd03_anocompetencia) == null) {
                $this->erro_sql = " Campo efd03_anocompetencia não informado.";
                $this->erro_campo = "efd03_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_cpfbeneficiario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_cpfbeneficiario"])) {
            $sql  .= $virgula . " efd03_cpfbeneficiario = $this->efd03_cpfbeneficiario ";
            $virgula = ",";
            if (trim($this->efd03_cpfbeneficiario) == null) {
                $this->erro_sql = " Campo efd03_cpfbeneficiario não informado.";
                $this->erro_campo = "efd03_cpfbeneficiario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_identificadorop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_identificadorop"])) {
            $sql  .= $virgula . " efd03_identificadorop = '$this->efd03_identificadorop' ";
            $virgula = ",";
            if (trim($this->efd03_identificadorop) == null) {
                $this->erro_sql = " Campo efd03_identificadorop não informado.";
                $this->erro_campo = "efd03_identificadorop";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_instit"])) {
            $sql  .= $virgula . " efd03_instit = $this->efd03_instit ";
            $virgula = ",";
            if (trim($this->efd03_instit) == null) {
                $this->erro_sql = " Campo efd03_instit não informado.";
                $this->erro_campo = "efd03_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_naturezarendimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_naturezarendimento"])) {
            $sql  .= $virgula . " efd03_naturezarendimento = $this->efd03_naturezarendimento ";
            $virgula = ",";
            if (trim($this->efd03_naturezarendimento) == null) {
                $this->erro_sql = " Campo efd03_naturezarendimento não informado.";
                $this->erro_campo = "efd03_naturezarendimento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_valorbruto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_valorbruto"])) {
            $sql  .= $virgula . " efd03_valorbruto = $this->efd03_valorbruto ";
            $virgula = ",";
            if (trim($this->efd03_valorbruto) == null) {
                $this->erro_sql = " Campo efd03_valorbruto não informado.";
                $this->erro_campo = "efd03_valorbruto";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_valorbase) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_valorbase"])) {
            $sql  .= $virgula . " efd03_valorbase = $this->efd03_valorbase ";
            $virgula = ",";
            if (trim($this->efd03_valorbase) == null) {
                $this->erro_sql = " Campo efd03_valorbase não informado.";
                $this->erro_campo = "efd03_valorbase";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_valorirrf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_valorirrf"])) {
            $sql  .= $virgula . " efd03_valorirrf = $this->efd03_valorirrf ";
            $virgula = ",";
            if (trim($this->efd03_valorirrf) == null) {
                $this->erro_sql = " Campo efd03_valorirrf não informado.";
                $this->erro_campo = "efd03_valorirrf";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_datafg) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_datafg"])) {
            $sql  .= $virgula . " efd03_datafg = $this->efd03_datafg ";
            $virgula = ",";
            if (trim($this->efd03_datafg) == null) {
                $this->erro_sql = " Campo efd03_datafg não informado.";
                $this->erro_campo = "efd03_datafg";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_protocolo"])) {
            $sql  .= $virgula . " efd03_protocolo = $this->efd03_protocolo ";
            $virgula = ",";
            if (trim($this->efd03_protocolo) == null) {
                $this->erro_sql = " Campo efd03_protocolo não informado.";
                $this->erro_campo = "efd03_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_dataenvio"])) {
            $sql  .= $virgula . " efd03_dataenvio = $this->efd03_dataenvio ";
            $virgula = ",";
            if (trim($this->efd03_dataenvio) == null) {
                $this->erro_sql = " Campo efd03_dataenvio não informado.";
                $this->erro_campo = "efd03_dataenvio";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_numcgm"])) {
            $sql  .= $virgula . " efd03_numcgm = $this->efd03_numcgm ";
            $virgula = ",";
            if (trim($this->efd03_numcgm) == null) {
                $this->erro_sql = " Campo efd03_numcgm não informado.";
                $this->erro_campo = "efd03_numcgm";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_status) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_status"])) {
            $sql  .= $virgula . " efd03_status = $this->efd03_status ";
            $virgula = ",";
            if (trim($this->efd03_status) == null) {
                $this->erro_sql = " Campo efd03_status não informado.";
                $this->erro_campo = "efd03_status";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd03_descResposta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd03_descResposta"])) {
            $sql  .= $virgula . " efd03_descResposta = $this->efd03_descResposta ";
            $virgula = ",";
            if (trim($this->efd03_descResposta) == null) {
                $this->erro_sql = " Campo efd03_descResposta não informado.";
                $this->erro_campo = "efd03_descResposta";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "efd03_sequencial = '$efd03_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr4010 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr4010 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd03_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfr4010
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd03_sequencial = $efd03_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr4010 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr4010 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfr4010";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd03_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr4010 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd03_sequencial != "" && $efd03_sequencial != null) {
                $sql2 = " where efdreinfr4010.efd03_sequencial = '$efd03_sequencial'";
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
    function sql_query_file($efd03_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr4010 ";
        $sql .= " join cgm on efd03_numcgm = cgm.z01_numcgm";
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
    function sql_DadosEFDReinf($tipo = null, $sDataInicial, $sDataFinal, $instituicao)
    {
        $sql = "
        SELECT * FROM
        (SELECT DISTINCT e60_codemp||'/'||e60_anousu AS empenho,
                         e50_codord AS op,
                         e69_numero AS nro_nota,
                         e69_dtnota AS data_nota,
                         c69_data AS data_pgto,
     
                         CASE
                             WHEN e102_vlrbruto > 0 THEN coalesce(e102_vlrbruto, 0)
                             ELSE coalesce(e70_valor, 0)
                         END AS valor_bruto,
                            
                         CASE
                             WHEN e102_vlrbruto > 0 THEN coalesce(e102_vlrbase, 0)
                             ELSE coalesce(e23_valorbase, 0)
                         END AS valor_base,
                            
                         CASE
                             WHEN e102_vlrbruto > 0 THEN coalesce(e102_vlrir, 0)
                             ELSE CASE
                                      WHEN e21_retencaotipocalc IN (1, 2) THEN coalesce(retencaoreceitas.e23_valorretencao, 0)
                                      ELSE 0
                                  END
                         END AS valor_irrf,
                            
                         e50_naturezabemservico AS natureza_rendimento,
                            
                          CASE
                              WHEN e102_vlrbase > 0 THEN 't'
                              ELSE 'f'
                          END AS reten_terceiros,
                            
                          CASE
                              WHEN e102_codord is null THEN e60_numcgm||' - '||cgm.z01_nome
                              ELSE cgm_pagordemreinf.z01_numcgm||' - '||cgm_pagordemreinf.z01_nome
                          END AS beneficiario,
     
                          e60_numcgm||' - '||cgm.z01_nome AS credor_emp,
                          coalesce(e70_valor, 0) AS valor_op,
                          e60_numemp,
                          CASE
                          WHEN e102_codord is null THEN cgm.z01_cgccpf
                          ELSE cgm_pagordemreinf.z01_cgccpf
                      END as cpf
         FROM contacorrentedetalhe
         JOIN contacorrentedetalheconlancamval ON c28_contacorrentedetalhe = c19_sequencial
         JOIN conlancamval ON c69_sequen = c28_conlancamval
         JOIN conlancamemp ON c75_codlan = c69_codlan
         JOIN conlancamdoc ON c71_codlan = c75_codlan
         JOIN conhistdoc ON c71_coddoc = c53_coddoc
         JOIN empempenho ON e60_numemp = c75_numemp
         JOIN empelemento ON e64_numemp = e60_numemp
         JOIN orcelemento ON (o56_codele, o56_anousu) = (e64_codele, e60_anousu)
         JOIN cgm AS cgm ON e60_numcgm = cgm.z01_numcgm
         JOIN conlancamord ON c80_codlan = c75_codlan
         JOIN pagordem ON e50_codord = c80_codord
         JOIN pagordemele ON e53_codord = c80_codord
         JOIN pagordemnota ON e71_codord = c80_codord
         JOIN empnota ON (e69_numemp, e69_codnota) = (e60_numemp, e71_codnota) 
         JOIN empnotaele ON e69_codnota = e70_codnota
     
         LEFT JOIN pagordemreinf ON e102_codord = e50_codord
         LEFT JOIN cgm AS empresa ON empresa.z01_numcgm = e50_empresadesconto
     
         LEFT JOIN cgm AS cgm_pagordemreinf ON cgm_pagordemreinf.z01_numcgm = e102_numcgm
     
         LEFT JOIN retencaopagordem ON pagordem.e50_codord = retencaopagordem.e20_pagordem
         LEFT JOIN retencaoreceitas ON retencaoreceitas.e23_retencaopagordem = retencaopagordem.e20_sequencial AND e23_ativo = 't'
     
         LEFT JOIN retencaotiporec ON retencaotiporec.e21_sequencial = retencaoreceitas.e23_retencaotiporec
     
         JOIN coremp c1 ON (c80_codord, c80_data) = (k12_codord, c1.k12_data)
         JOIN corrente c2 ON (c1.k12_id, c1.k12_data, c1.k12_autent) = (c2.k12_id, c2.k12_data, c2.k12_autent)
         JOIN corempagemov c3 ON (c3.k12_id, c3.k12_data, c3.k12_autent) = (c2.k12_id, c2.k12_data, c2.k12_autent)
         JOIN empord ON (e82_codord, e82_codmov) = (c80_codord, k12_codmov)
     
         WHERE e50_cattrabalhador IS NULL
         AND o56_elemento NOT LIKE '331%'
         AND e60_numcgm NOT IN (SELECT numcgm FROM db_config)
         AND c53_tipo = 30
         AND e53_vlrpag > 0
         AND e60_instit = {$instituicao}
         AND (
            (e102_codord IS NULL AND LENGTH(cgm.z01_cgccpf) = $tipo)
            OR (e102_codord IS NOT NULL AND LENGTH(cgm_pagordemreinf.z01_cgccpf) = $tipo)
          )
         AND (e21_retencaotipocalc IN (1, 2) OR o56_elemento LIKE '333903614%' OR e50_retencaoir = 't')    
         AND c69_data BETWEEN  '$sDataInicial' AND '$sDataFinal') AS x
         ORDER BY credor_emp, beneficiario, e60_numemp, 2, 5 , valor_irrf  ";

        return $sql;
    }
}
