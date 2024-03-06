<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfr2010
class cl_efdreinfr2010
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
    public $efd05_sequencial         = 0;
    public $efd05_cnpjprestador      = 0;
    public $efd05_estabelecimento    = null;
    public $efd05_optantecprb        = 0;
    public $efd05_dataenvio          = 0;
    public $efd05_valorretidocp      = 0;
    public $efd05_valorbruto         = 0;
    public $efd05_valorbase          = 0;
    public $efd05_mescompetencia     = 0;
    public $efd05_anocompetencia     = 0;
    public $efd05_ambiente           = null;
    public $efd05_instit             = 0;
    public $efd05_protocolo          = 0;
    public $efd05_indprestservico    = 0;
    public $efd05_status             = 0;
    public $efd05_descResposta       = 0;
    public $efd05_dscResp            = 0;

    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd05_sequencial       = int8 = sequencial 
                 efd05_mescompetencia   = int8 = mes competencia
                 efd05_cnpjprestador    = int8 = cnpj prestador
                 efd05_estabelecimento  = text = tipo de estabelecimento  
                 efd05_ambiente         = int8 = tipo de ambiente 
                 efd05_instit           = int8 = instittuicao 
                 efd05_anocompetencia   = int8 = ano competencia 
                 efd05_optantecprb      = int8 = optante cprb 
                 efd05_valorbruto       = float8 = valor bruto
                 efd05_valorbase        = float8 = valor base
                 efd05_dataenvio        = date = data 
                 efd05_protocolo        = text = protocolo 
                 efd05_valorretidocp    = float8 = valor retido cp 
                 efd05_indprestservico  = text = mao de obra   
                 efd05_status           = int8 = Status
                 efd05_descResposta     = text = descResposta 
                 efd05_dscResp          = text = Protocolo 
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfr2010");
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
            $this->efd05_sequencial = ($this->efd05_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_sequencial"] : $this->efd05_sequencial);
            $this->efd05_mescompetencia = ($this->efd05_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_licitacao"] : $this->efd05_mescompetencia);
            $this->efd05_cnpjprestador    = ($this->efd05_cnpjprestador    == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_cnpjprestador   "] : $this->efd05_cnpjprestador);
            $this->efd05_estabelecimento = ($this->efd05_estabelecimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_estabelecimento"] : $this->efd05_estabelecimento);
            $this->efd05_ambiente = ($this->efd05_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_ambiente"] : $this->efd05_ambiente);
            $this->efd05_instit = ($this->efd05_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_instit"] : $this->efd05_instit);
            $this->efd05_anocompetencia = ($this->efd05_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_anocompetencia"] : $this->efd05_anocompetencia);
            $this->efd05_optantecprb        = ($this->efd05_optantecprb        == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_optantecprb       "] : $this->efd05_optantecprb);
            $this->efd05_valorbruto = ($this->efd05_valorbruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_valorbruto"] : $this->efd05_valorbruto);
            $this->efd05_valorbase = ($this->efd05_valorbase == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_valorbase"] : $this->efd05_valorbase);
            $this->efd05_dataenvio = ($this->efd05_dataenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_dataenvio"] : $this->efd05_dataenvio);
            $this->efd05_protocolo = ($this->efd05_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_protocolo"] : $this->efd05_protocolo);
            $this->efd05_valorretidocp = ($this->efd05_valorretidocp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_valorretidocp"] : $this->efd05_valorretidocp);
            $this->efd05_indprestservico = ($this->efd05_indprestservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_indprestservico"] : $this->efd05_indprestservico);
            $this->efd05_status = ($this->efd05_status == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_status"] : $this->efd05_status);
            $this->efd05_descResposta = ($this->efd05_descResposta == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_descResposta"] : $this->efd05_descResposta);
            $this->efd05_dscResp = ($this->efd05_dscResp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd05_dscResp"] : $this->efd05_dscResp);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();

        if ($this->efd05_mescompetencia == null) {
            $this->erro_sql = " Campo efd05_mescompetencia não informado.";
            $this->erro_campo = "efd05_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_anocompetencia == null) {
            $this->erro_sql = " Campo efd05_anocompetencia não informado.";
            $this->erro_campo = "efd05_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_cnpjprestador    == null) {
            $this->erro_sql = " Campo efd05_cnpjprestador    não informado.";
            $this->erro_campo = "efd05_cnpjprestador   ";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_estabelecimento == null) {
            $this->erro_sql = " Campo efd05_estabelecimento não informado.";
            $this->erro_campo = "efd05_estabelecimento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_instit == null) {
            $this->erro_sql = " Campo efd05_instit não informado.";
            $this->erro_campo = "efd05_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_ambiente == null) {
            $this->erro_sql = " Campo efd05_ambiente não informado.";
            $this->erro_campo = "efd05_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_optantecprb        == null) {
            $this->erro_sql = " Campo efd05_optantecprb        não informado.";
            $this->erro_campo = "efd05_optantecprb       ";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_valorbruto == null) {
            $this->efd05_valorbruto = 0;
        }
        if ($this->efd05_valorbase == null) {
            $this->efd05_valorbase = 0;
        }
        if ($this->efd05_valorretidocp == null) {
            $this->erro_sql = " Campo efd05_valorretidocp informado.";
            $this->erro_campo = "efd05_valorretidocp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_indprestservico == null) {
            $this->erro_sql = " Campo efd05_indprestservico não informado.";
            $this->erro_campo = "efd05_indprestservico";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd05_status == null) {
            $this->efd05_status = 'null';
        }
        if ($this->efd05_sequencial == "" || $this->efd05_sequencial == null) {
            $result = db_query("select nextval('efdreinfr2010_efd05_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfr2010_efd05_sequencial_seq do campo: efd05_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd05_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfr2010_efd05_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd05_sequencial)) {
                $this->erro_sql = " Campo efd05_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd05_sequencial = $this->efd05_sequencial;
            }
        }
        if (($this->efd05_sequencial == null) || ($this->efd05_sequencial == "")) {
            $this->erro_sql = " Campo efd05_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfr2010(
                                       efd05_sequencial 
                                      ,efd05_mescompetencia
                                      ,efd05_anocompetencia
                                      ,efd05_cnpjprestador    
                                      ,efd05_estabelecimento
                                      ,efd05_ambiente 
                                      ,efd05_instit 
                                      ,efd05_optantecprb       
                                      ,efd05_valorbruto
                                      ,efd05_valorbase
                                      ,efd05_dataenvio
                                      ,efd05_protocolo
                                      ,efd05_valorretidocp                                   
                                      ,efd05_indprestservico                              
                                      ,efd05_status
                                      ,efd05_descResposta
                                      ,efd05_dscResp
                       )
                values (
                                $this->efd05_sequencial 
                               ,'$this->efd05_mescompetencia'
                               ,'$this->efd05_anocompetencia '
                               ,'$this->efd05_cnpjprestador   ' 
                               ,'$this->efd05_estabelecimento'
                               ,$this->efd05_ambiente
                               ,$this->efd05_instit
                               ,$this->efd05_optantecprb       
                               ,$this->efd05_valorbruto
                               ,$this->efd05_valorbase
                               ,'$this->efd05_dataenvio'
                               ,'$this->efd05_protocolo'
                               ,$this->efd05_valorretidocp                             
                               ,'$this->efd05_indprestservico'                       
                               ,$this->efd05_status
                               ,'$this->efd05_descResposta'
                               ,'$this->efd05_dscResp'
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfr2010 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfr2010 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfr2010 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd05_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfr2010 set ";
        $virgula = "";
        if (trim($this->efd05_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_sequencial"])) {
            $sql  .= $virgula . " efd05_sequencial = $this->efd05_sequencial ";
            $virgula = ",";
            if (trim($this->efd05_sequencial) == null) {
                $this->erro_sql = " Campo efd05_sequencial não informado.";
                $this->erro_campo = "efd05_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_mescompetencia"])) {
            $sql  .= $virgula . " efd05_mescompetencia= $this->efd05_mescompetencia";
            $virgula = ",";
            if (trim($this->efd05_mescompetencia) == null) {
                $this->erro_sql = " Campo efd05_mescompetencia não informado.";
                $this->erro_campo = "efd02_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_anocompetencia"])) {
            $sql  .= $virgula . " efd05_anocompetencia= $this->efd05_anocompetencia";
            $virgula = ",";
            if (trim($this->efd05_anocompetencia) == null) {
                $this->erro_sql = " Campo efd05_anocompetencia não informado.";
                $this->erro_campo = "efd05_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_cnpjprestador) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_cnpjprestador   "])) {
            $sql  .= $virgula . " efd05_cnpjprestador    = $this->efd05_cnpjprestador    ";
            $virgula = ",";
            if (trim($this->efd05_cnpjprestador) == null) {
                $this->erro_sql = " Campo efd05_cnpjprestador    não informado.";
                $this->erro_campo = "efd05_cnpjprestador   ";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_estabelecimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_estabelecimento"])) {
            $sql  .= $virgula . " efd05_estabelecimento = '$this->efd05_estabelecimento' ";
            $virgula = ",";
            if (trim($this->efd05_estabelecimento) == null) {
                $this->erro_sql = " Campo efd05_estabelecimento não informado.";
                $this->erro_campo = "efd05_estabelecimento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_instit"])) {
            $sql  .= $virgula . " efd05_instit = $this->efd05_instit ";
            $virgula = ",";
            if (trim($this->efd05_instit) == null) {
                $this->erro_sql = " Campo efd05_instit não informado.";
                $this->erro_campo = "efd05_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_optantecprb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_optantecprb       "])) {
            $sql  .= $virgula . " efd05_optantecprb        = $this->efd05_optantecprb        ";
            $virgula = ",";
            if (trim($this->efd05_optantecprb) == null) {
                $this->erro_sql = " Campo efd05_optantecprb        não informado.";
                $this->erro_campo = "efd05_optantecprb       ";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_valorbruto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_valorbruto"])) {
            $this->efd05_valorbruto = 0;
            $sql  .= $virgula . " efd05_valorbruto = $this->efd05_valorbruto ";
            $virgula = ",";
        }
        if (trim($this->efd05_valorbase) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_valorbase"])) {
            $this->efd05_valorbase = 0;
            $sql  .= $virgula . " efd05_valorbase = $this->efd05_valorbase ";
            $virgula = ",";
        }
        if (trim($this->efd05_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_dataenvio"])) {
            $sql  .= $virgula . " efd05_dataenvio = $this->efd05_dataenvio ";
            $virgula = ",";
            if (trim($this->efd05_dataenvio) == null) {
                $this->erro_sql = " Campo efd05_dataenvio não informado.";
                $this->erro_campo = "efd05_dataenvio";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_protocolo"])) {
            $sql  .= $virgula . " efd05_protocolo = $this->efd05_protocolo ";
            $virgula = ",";
            if (trim($this->efd05_protocolo) == null) {
                $this->erro_sql = " Campo efd05_protocolo não informado.";
                $this->erro_campo = "efd05_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_valorretidocp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_valorretidocp"])) {
            $sql  .= $virgula . " efd05_valorretidocp this = $this->efd05_valorretidocp ";
            $virgula = ",";
            if (trim($this->efd05_valorretidocp) == null) {
                $this->erro_sql = " Campo efd05_valorretidocp não informado.";
                $this->erro_campo = "efd05_valorretidocp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_indprestservico) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_indprestservico"])) {
            $sql  .= $virgula . " efd05_indprestservico = $this->efd05_indprestservico ";
            $virgula = ",";
            if (trim($this->efd05_indprestservico) == null) {
                $this->erro_sql = " Campo efd05_indprestservico não informado.";
                $this->erro_campo = "efd05_indprestservico";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_status) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_status"])) {
            $sql  .= $virgula . " efd05_status = $this->efd05_status ";
            $virgula = ",";
            if (trim($this->efd05_status) == null) {
                $this->erro_sql = " Campo efd05_status não informado.";
                $this->erro_campo = "efd05_status";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd05_descResposta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd05_descResposta"])) {
            $sql  .= $virgula . " efd05_descResposta = $this->efd05_descResposta ";
            $virgula = ",";
            if (trim($this->efd05_descResposta) == null) {
                $this->erro_sql = " Campo efd05_descResposta não informado.";
                $this->erro_campo = "efd05_descResposta";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        $sql .= "efd05_sequencial = '$efd05_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr2010 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr2010 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd05_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfr2010
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd05_sequencial = $efd05_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr2010 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr2010 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfr2010";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd05_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr2010 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd05_sequencial != "" && $efd05_sequencial != null) {
                $sql2 = " where efdreinfr2010.efd05_sequencial = '$efd05_sequencial'";
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
    function sql_query_file($efd05_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr2010 ";
        $sql .= " join efdreinfnotasr2010 on (efd06_cnpjprestador,efd06_protocolo) = (efd05_cnpjprestador,efd05_protocolo)";
        $sql .= " join pagordem on e50_codord = efd06_numeroop::int ";
        $sql .= " join empempenho on e50_numemp = e60_numemp ";
        $sql .= " join empefdreinf on efd60_numemp = e60_numemp ";
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
