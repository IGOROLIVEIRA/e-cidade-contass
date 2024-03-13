<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfr4020
class cl_efdreinfr4020
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
    public $efd02_sequencial         = 0;
    public $efd02_cnpjbeneficiario   = 0;
    public $efd02_identificadorop    = null;
    public $efd02_naturezarendimento = 0;
    public $efd02_datafg             = 0;
    public $efd02_datafg_dia         = 0;
    public $efd02_datafg_mes         = 0;
    public $efd02_datafg_ano         = 0;
    public $efd02_dataenvio          = 0;
    public $efd02_valorbruto         = 0;
    public $efd02_valorbase          = 0;
    public $efd02_valorirrf          = 0;
    public $efd02_mescompetencia     = 0;
    public $efd02_anocompetencia     = 0;
    public $efd02_ambiente           = null;
    public $efd02_instit             = 0;
    public $efd02_protocolo          = 0;
    public $efd02_numcgm             = 0;
    public $efd02_status             = 0;
    public $efd02_descResposta       = 0;
    public $efd02_dscResp            = 0;

    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd02_sequencial       = int8 = sequencial 
                 efd02_mescompetencia   = int8 = mes competencia
                 efd02_cnpjbeneficiario = int8 = cnpj beneficiario
                 efd02_identificadorop  = int8 = tipo de ambiente 
                 efd02_ambiente         = int8 = tipo de ambiente 
                 efd02_instit           = int8 = instittuicao 
                 efd02_anocompetencia   = int8 = ano competencia 
                 efd02_naturezarendimento = int8 = natureza rendimento 
                 efd02_valorbruto         = float8 = valor bruto
                 efd02_valorbase        = float8 = valor base
                 efd02_valorirrf        = float8 = valor irrf 
                 efd02_datafg           = date = data 
                 efd02_protocolo        = text = protocolo 
                 efd02_dataenvio        = text = Data de Envio
                 efd02_numcgm           = int8 = numcgm    
                 efd02_status           = int8 = Status
                 efd02_descResposta     = text = descResposta 
                 efd02_dscResp          = text = Protocolo 
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfr4020");
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
            $this->efd02_sequencial = ($this->efd02_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_sequencial"] : $this->efd02_sequencial);
            $this->efd02_mescompetencia = ($this->efd02_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_licitacao"] : $this->efd02_mescompetencia);
            $this->efd02_cnpjbeneficiario = ($this->efd02_cnpjbeneficiario == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_cnpjbeneficiario"] : $this->efd02_cnpjbeneficiario);
            $this->efd02_identificadorop = ($this->efd02_identificadorop == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_identificadorop"] : $this->efd02_identificadorop);
            $this->efd02_ambiente = ($this->efd02_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_ambiente"] : $this->efd02_ambiente);
            $this->efd02_instit = ($this->efd02_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_instit"] : $this->efd02_instit);
            $this->efd02_anocompetencia = ($this->efd02_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_anocompetencia"] : $this->efd02_anocompetencia);
            $this->efd02_naturezarendimento = ($this->efd02_naturezarendimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_naturezarendimento"] : $this->efd02_naturezarendimento);
            $this->efd02_valorbruto = ($this->efd02_valorbruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_valorbruto"] : $this->efd02_valorbruto);
            $this->efd02_valorbase = ($this->efd02_valorbase == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_valorbase"] : $this->efd02_valorbase);
            $this->efd02_valorirrf = ($this->efd02_valorirrf == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_valorirrf"] : $this->efd02_valorirrf);
            if ($this->efd02_datafg == "") {
                $this->efd02_datafg_dia = ($this->efd02_datafg_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_datafg_dia"] : $this->efd02_datafg_dia);
                $this->efd02_datafg_mes = ($this->efd02_datafg_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_datafg_mes"] : $this->efd02_datafg_mes);
                $this->efd02_datafg_ano = ($this->efd02_datafg_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_datafg_ano"] : $this->efd02_datafg_ano);
                if ($this->efd02_datafg_dia != "") {
                    $this->efd02_datafg = $this->efd02_datafg_ano . "-" . $this->efd02_datafg_mes . "-" . $this->efd02_datafg_dia;
                }
            }
            $this->efd02_protocolo = ($this->efd02_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_protocolo"] : $this->efd02_protocolo);
            $this->efd02_dataenvio = ($this->efd02_dataenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_dataenvio"] : $this->efd02_dataenvio);
            $this->efd02_numcgm = ($this->efd02_numcgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_numcgm"] : $this->efd02_numcgm);
            $this->efd02_status = ($this->efd02_status == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_status"] : $this->efd02_status);
            $this->efd02_descResposta = ($this->efd02_descResposta == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_descResposta"] : $this->efd02_descResposta);
            $this->efd02_dscResp = ($this->efd02_dscResp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_dscResp"] : $this->efd02_dscResp);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();

        if ($this->efd02_mescompetencia == null) {
            $this->erro_sql = " Campo efd02_mescompetencia não informado.";
            $this->erro_campo = "efd02_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_anocompetencia == null) {
            $this->erro_sql = " Campo efd02_anocompetencia não informado.";
            $this->erro_campo = "efd02_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_cnpjbeneficiario == null) {
            $this->erro_sql = " Campo efd02_cnpjbeneficiario não informado.";
            $this->erro_campo = "efd02_cnpjbeneficiario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_identificadorop == null) {
            $this->erro_sql = " Campo efd02_identificadorop não informado.";
            $this->erro_campo = "efd02_identificadorop";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_instit == null) {
            $this->erro_sql = " Campo efd02_instit não informado.";
            $this->erro_campo = "efd02_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_ambiente == null) {
            $this->erro_sql = " Campo efd02_ambiente não informado.";
            $this->erro_campo = "efd02_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_naturezarendimento == null) {
            $this->erro_sql = " Campo efd02_naturezarendimento não informado.";
            $this->erro_campo = "efd02_naturezarendimento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_valorbruto == null) {
            $this->efd02_valorbruto = 0;
        }
        if ($this->efd02_valorbase == null) {
            $this->efd02_valorbase = 0;
        }
        if ($this->efd02_valorirrf == null) {
            $this->efd02_valorirrf = 0;
        }
        if ($this->efd02_datafg == null) {
            $this->erro_sql = " Campo efd02_datafg não informado.";
            $this->erro_campo = "efd02_datafg";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_numcgm == null) {
            $this->erro_sql = " Campo efd02_numcgm não informado.";
            $this->erro_campo = "efd02_numcgm";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd02_status == null) {
            $this->efd02_status == 'null';
        }
        if ($this->efd02_sequencial == "" || $this->efd02_sequencial == null) {
            $result = db_query("select nextval('efdreinfr4020_efd02_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfr4020_efd02_sequencial_seq do campo: efd02_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd02_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfr4020_efd02_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd02_sequencial)) {
                $this->erro_sql = " Campo efd02_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd02_sequencial = $this->efd02_sequencial;
            }
        }
        if (($this->efd02_sequencial == null) || ($this->efd02_sequencial == "")) {
            $this->erro_sql = " Campo efd02_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfr4020(
                                       efd02_sequencial 
                                      ,efd02_mescompetencia
                                      ,efd02_anocompetencia
                                      ,efd02_cnpjbeneficiario 
                                      ,efd02_identificadorop
                                      ,efd02_ambiente 
                                      ,efd02_instit 
                                      ,efd02_naturezarendimento
                                      ,efd02_valorbruto
                                      ,efd02_valorbase
                                      ,efd02_valorirrf
                                      ,efd02_datafg
                                      ,efd02_protocolo
                                      ,efd02_dataenvio
                                      ,efd02_numcgm
                                      ,efd02_status
                                      ,efd02_descResposta
                                      ,efd02_dscResp
                       )
                values (
                                $this->efd02_sequencial 
                               ,'$this->efd02_mescompetencia'
                               ,'$this->efd02_anocompetencia '
                               ,'$this->efd02_cnpjbeneficiario' 
                               ,$this->efd02_identificadorop
                               ,$this->efd02_ambiente
                               ,$this->efd02_instit
                               ,$this->efd02_naturezarendimento
                               ,$this->efd02_valorbruto
                               ,$this->efd02_valorbase
                               ,$this->efd02_valorirrf
                               ,'$this->efd02_datafg'
                               ,'$this->efd02_protocolo'
                               ,'$this->efd02_dataenvio'
                               ,$this->efd02_numcgm
                               ,$this->efd02_status
                               ,'$this->efd02_descResposta'
                               ,'$this->efd02_dscResp'
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfr4020 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfr4020 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfr4020 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd02_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfr4020 set ";
        $virgula = "";
        if (trim($this->efd02_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_sequencial"])) {
            $sql  .= $virgula . " efd02_sequencial = $this->efd02_sequencial ";
            $virgula = ",";
            if (trim($this->efd02_sequencial) == null) {
                $this->erro_sql = " Campo efd02_sequencial não informado.";
                $this->erro_campo = "efd02_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_mescompetencia"])) {
            $sql  .= $virgula . " efd02_mescompetencia= $this->efd02_mescompetencia";
            $virgula = ",";
            if (trim($this->efd02_mescompetencia) == null) {
                $this->erro_sql = " Campo efd02_mescompetencia não informado.";
                $this->erro_campo = "efd02_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_anocompetencia"])) {
            $sql  .= $virgula . " efd02_anocompetencia= $this->efd02_anocompetencia";
            $virgula = ",";
            if (trim($this->efd02_anocompetencia) == null) {
                $this->erro_sql = " Campo efd02_anocompetencia não informado.";
                $this->erro_campo = "efd02_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_cnpjbeneficiario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_cnpjbeneficiario"])) {
            $sql  .= $virgula . " efd02_cnpjbeneficiario = $this->efd02_cnpjbeneficiario ";
            $virgula = ",";
            if (trim($this->efd02_cnpjbeneficiario) == null) {
                $this->erro_sql = " Campo efd02_cnpjbeneficiario não informado.";
                $this->erro_campo = "efd02_cnpjbeneficiario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_identificadorop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_identificadorop"])) {
            $sql  .= $virgula . " efd02_identificadorop = '$this->efd02_identificadorop' ";
            $virgula = ",";
            if (trim($this->efd02_identificadorop) == null) {
                $this->erro_sql = " Campo efd02_identificadorop não informado.";
                $this->erro_campo = "efd02_identificadorop";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_instit"])) {
            $sql  .= $virgula . " efd02_instit = $this->efd02_instit ";
            $virgula = ",";
            if (trim($this->efd02_instit) == null) {
                $this->erro_sql = " Campo efd02_instit não informado.";
                $this->erro_campo = "efd02_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_naturezarendimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_naturezarendimento"])) {
            $sql  .= $virgula . " efd02_naturezarendimento = $this->efd02_naturezarendimento ";
            $virgula = ",";
            if (trim($this->efd02_naturezarendimento) == null) {
                $this->erro_sql = " Campo efd02_naturezarendimento não informado.";
                $this->erro_campo = "efd02_naturezarendimento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_valorbruto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_valorbruto"])) {
            $this->efd02_valorbruto = 0;
            $sql  .= $virgula . " efd02_valorbruto = $this->efd02_valorbruto ";
            $virgula = ",";
        }
        if (trim($this->efd02_valorbase) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_valorbase"])) {
            $this->efd02_valorbase = 0;
            $sql  .= $virgula . " efd02_valorbase = $this->efd02_valorbase ";
            $virgula = ",";
        }
        if (trim($this->efd02_valorirrf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_valorirrf"])) {
            $this->efd02_valorirrf = 0;
            $sql  .= $virgula . " efd02_valorirrf = $this->efd02_valorirrf ";
            $virgula = ",";
        }
        if (trim($this->efd02_datafg) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_datafg"])) {
            $sql  .= $virgula . " efd02_datafg = $this->efd02_datafg ";
            $virgula = ",";
            if (trim($this->efd02_datafg) == null) {
                $this->erro_sql = " Campo efd02_datafg não informado.";
                $this->erro_campo = "efd02_datafg";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_protocolo"])) {
            $sql  .= $virgula . " efd02_protocolo = $this->efd02_protocolo ";
            $virgula = ",";
            if (trim($this->efd02_protocolo) == null) {
                $this->erro_sql = " Campo efd02_protocolo não informado.";
                $this->erro_campo = "efd02_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_dataenvio"])) {
            $sql  .= $virgula . " efd02_dataenvio = $this->efd02_dataenvio ";
            $virgula = ",";
            if (trim($this->efd02_dataenvio) == null) {
                $this->erro_sql = " Campo efd02_dataenvio não informado.";
                $this->erro_campo = "efd02_dataenvio";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_numcgm"])) {
            $sql  .= $virgula . " efd02_numcgm = $this->efd02_numcgm ";
            $virgula = ",";
            if (trim($this->efd02_numcgm) == null) {
                $this->erro_sql = " Campo efd02_numcgm não informado.";
                $this->erro_campo = "efd02_numcgm";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_status) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_status"])) {
            $sql  .= $virgula . " efd02_status = $this->efd02_status ";
            $virgula = ",";
            if (trim($this->efd02_status) == null) {
                $this->erro_sql = " Campo efd02_status não informado.";
                $this->erro_campo = "efd02_status";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd02_descResposta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_descResposta"])) {
            $sql  .= $virgula . " efd02_descResposta = $this->efd02_descResposta ";
            $virgula = ",";
            if (trim($this->efd02_descResposta) == null) {
                $this->erro_sql = " Campo efd02_descResposta não informado.";
                $this->erro_campo = "efd02_descResposta";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        // if (trim($this->efd02_dscResp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd02_dscResp"])) {
        //     $sql  .= $virgula . " efd02_dscResp = $this->efd02_dscResp ";
        //     $virgula = ",";
        //     if (trim($this->efd02_dscResp) == null) {
        //         $this->erro_sql = " Campo efd02_dscResp não informado.";
        //         $this->erro_campo = "efd02_dscResp";
        //         $this->erro_banco = "";
        //         $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        //         $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        //         $this->erro_status = "0";
        //         return false;
        //     }
        // }       
        $sql .= " where ";
        $sql .= "efd02_sequencial = '$efd02_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr4020 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr4020 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd02_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfr4020
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd02_sequencial = $efd02_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr4020 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr4020 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfr4020";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd02_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr4020 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd02_sequencial != "" && $efd02_sequencial != null) {
                $sql2 = " where efdreinfr4020.efd02_sequencial = '$efd02_sequencial'";
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
    function sql_query_file($efd02_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr4020 ";
        $sql .= " join cgm on efd02_numcgm = cgm.z01_numcgm";
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
                      END as cnpj
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
         ORDER BY credor_emp, beneficiario, e60_numemp, 2, 5 , valor_irrf ";

        return $sql;
    }
}
