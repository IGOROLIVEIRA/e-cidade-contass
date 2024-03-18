<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfr2055
class cl_efdreinfr2055
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
    public $efd07_sequencial         = 0;
    public $efd07_mescompetencia     = 0;
    public $efd07_cpfcnpjprodutor   = 0;
    public $efd07_ambiente           = null;
    public $efd07_instit             = 0;
    public $efd07_anocompetencia     = 0;
    public $efd07_valorbruto         = 0;
    public $efd07_valorcp            = 0;
    public $efd07_valorgilrat        = 0;
    public $efd07_valorsenar         = 0;
    public $efd07_dataenvio          = 0;
    public $efd07_protocolo          = 0;
    public $efd07_status             = 0;
    public $efd07_descResposta       = 0;
    public $efd07_dscResp            = 0;

    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd07_sequencial       = int8 = sequencial 
                 efd07_mescompetencia   = int8 = mes competencia
                 efd07_cpfcnpjprodutor = int8 = cpf e cnpj prestador    
                 efd07_ambiente         = int8 = tipo de ambiente 
                 efd07_instit           = int8 = instittuicao 
                 efd07_anocompetencia   = int8 = ano competencia 
                 efd07_numeroop         = texte = numero op
                 efd07_valorsenar       = float8 = valor senar
                 efd07_valorbruto       = float8 = valor bruto
                 efd07_valorcp          = float8 = valor cp
                 efd07_dataenvio        = date = data 
                 efd07_protocolo        = text = protocolo 
                 efd07_valorgilrat      = float8 = valor gilrat  
                 efd07_status           = int8 = Status
                 efd07_descResposta     = text = descResposta 
                 efd07_dscResp          = text = Protocolo 
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfr2055");
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
            $this->efd07_sequencial = ($this->efd07_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_sequencial"] : $this->efd07_sequencial);
            $this->efd07_mescompetencia = ($this->efd07_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd02_licitacao"] : $this->efd07_mescompetencia);
            $this->efd07_cpfcnpjprodutor    = ($this->efd07_cpfcnpjprodutor    == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_cpfcnpjprodutor   "] : $this->efd07_cpfcnpjprodutor);
            $this->efd07_ambiente = ($this->efd07_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_ambiente"] : $this->efd07_ambiente);
            $this->efd07_instit = ($this->efd07_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_instit"] : $this->efd07_instit);
            $this->efd07_anocompetencia = ($this->efd07_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_anocompetencia"] : $this->efd07_anocompetencia);
            $this->efd07_valorsenar         = ($this->efd07_valorsenar         == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_valorsenar        "] : $this->efd07_valorsenar);
            $this->efd07_valorbruto = ($this->efd07_valorbruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_valorbruto"] : $this->efd07_valorbruto);
            $this->efd07_valorcp   = ($this->efd07_valorcp   == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_valorcp  "] : $this->efd07_valorcp);
            $this->efd07_dataenvio = ($this->efd07_dataenvio == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_dataenvio"] : $this->efd07_dataenvio);
            $this->efd07_protocolo = ($this->efd07_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_protocolo"] : $this->efd07_protocolo);
            $this->efd07_valorgilrat  = ($this->efd07_valorgilrat  == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_valorgilrat "] : $this->efd07_valorgilrat);
            $this->efd07_status = ($this->efd07_status == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_status"] : $this->efd07_status);
            $this->efd07_descResposta = ($this->efd07_descResposta == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_descResposta"] : $this->efd07_descResposta);
            $this->efd07_dscResp = ($this->efd07_dscResp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd07_dscResp"] : $this->efd07_dscResp);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();

        if ($this->efd07_mescompetencia == null) {
            $this->erro_sql = " Campo efd07_mescompetencia não informado.";
            $this->erro_campo = "efd07_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd07_anocompetencia == null) {
            $this->erro_sql = " Campo efd07_anocompetencia não informado.";
            $this->erro_campo = "efd07_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd07_cpfcnpjprodutor    == null) {
            $this->erro_sql = " Campo efd07_cpfcnpjprodutor    não informado.";
            $this->erro_campo = "efd07_cpfcnpjprodutor   ";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd07_instit == null) {
            $this->erro_sql = " Campo efd07_instit não informado.";
            $this->erro_campo = "efd07_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd07_ambiente == null) {
            $this->erro_sql = " Campo efd07_ambiente não informado.";
            $this->erro_campo = "efd07_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd07_valorsenar         == null) {
            $this->erro_sql = " Campo efd07_valorsenar         não informado.";
            $this->erro_campo = "efd07_valorsenar        ";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd07_valorbruto == null) {
            $this->efd07_valorbruto = 0;
        }
        if ($this->efd07_valorcp   == null) {
            $this->efd07_valorcp   = 0;
        }
        if ($this->efd07_valorgilrat  == null) {
            $this->erro_sql = " Campo efd07_valorgilrat  informado.";
            $this->erro_campo = "efd07_valorgilrat ";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd07_status == null) {
            $this->efd07_status = 'null';
        }
        if ($this->efd07_sequencial == "" || $this->efd07_sequencial == null) {
            $result = db_query("select nextval('efdreinfr2055_efd07_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfr2055_efd07_sequencial_seq do campo: efd07_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd07_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfr2055_efd07_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd07_sequencial)) {
                $this->erro_sql = " Campo efd07_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd07_sequencial = $this->efd07_sequencial;
            }
        }
        if (($this->efd07_sequencial == null) || ($this->efd07_sequencial == "")) {
            $this->erro_sql = " Campo efd07_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfr2055(
                                       efd07_sequencial 
                                      ,efd07_mescompetencia
                                      ,efd07_anocompetencia
                                      ,efd07_cpfcnpjprodutor    
                                      ,efd07_ambiente 
                                      ,efd07_instit 
                                      ,efd07_valorsenar        
                                      ,efd07_valorbruto
                                      ,efd07_valorcp  
                                      ,efd07_dataenvio
                                      ,efd07_protocolo
                                      ,efd07_valorgilrat                                                            
                                      ,efd07_status
                                      ,efd07_descResposta
                                      ,efd07_dscResp
                       )
                values (
                                $this->efd07_sequencial 
                               ,'$this->efd07_mescompetencia'
                               ,'$this->efd07_anocompetencia '
                               ,'$this->efd07_cpfcnpjprodutor' 
                               ,$this->efd07_ambiente
                               ,$this->efd07_instit
                               ,$this->efd07_valorsenar        
                               ,$this->efd07_valorbruto
                               ,$this->efd07_valorcp  
                               ,'$this->efd07_dataenvio'
                               ,'$this->efd07_protocolo'
                               ,$this->efd07_valorgilrat                                                   
                               ,$this->efd07_status
                               ,'$this->efd07_descResposta'
                               ,'$this->efd07_dscResp'
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfr2055 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfr2055 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfr2055 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd07_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfr2055 set ";
        $virgula = "";
        if (trim($this->efd07_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_sequencial"])) {
            $sql  .= $virgula . " efd07_sequencial = $this->efd07_sequencial ";
            $virgula = ",";
            if (trim($this->efd07_sequencial) == null) {
                $this->erro_sql = " Campo efd07_sequencial não informado.";
                $this->erro_campo = "efd07_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_mescompetencia"])) {
            $sql  .= $virgula . " efd07_mescompetencia= $this->efd07_mescompetencia";
            $virgula = ",";
            if (trim($this->efd07_mescompetencia) == null) {
                $this->erro_sql = " Campo efd07_mescompetencia não informado.";
                $this->erro_campo = "efd02_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_anocompetencia"])) {
            $sql  .= $virgula . " efd07_anocompetencia= $this->efd07_anocompetencia";
            $virgula = ",";
            if (trim($this->efd07_anocompetencia) == null) {
                $this->erro_sql = " Campo efd07_anocompetencia não informado.";
                $this->erro_campo = "efd07_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_cpfcnpjprodutor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_cpfcnpjprodutor   "])) {
            $sql  .= $virgula . " efd07_cpfcnpjprodutor    = $this->efd07_cpfcnpjprodutor    ";
            $virgula = ",";
            if (trim($this->efd07_cpfcnpjprodutor) == null) {
                $this->erro_sql = " Campo efd07_cpfcnpjprodutor    não informado.";
                $this->erro_campo = "efd07_cpfcnpjprodutor   ";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_instit"])) {
            $sql  .= $virgula . " efd07_instit = $this->efd07_instit ";
            $virgula = ",";
            if (trim($this->efd07_instit) == null) {
                $this->erro_sql = " Campo efd07_instit não informado.";
                $this->erro_campo = "efd07_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_valorsenar) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_valorsenar        "])) {
            $sql  .= $virgula . " efd07_valorsenar         = $this->efd07_valorsenar         ";
            $virgula = ",";
        }
        if (trim($this->efd07_valorbruto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_valorbruto"])) {
            $this->efd07_valorbruto = 0;
            $sql  .= $virgula . " efd07_valorbruto = $this->efd07_valorbruto ";
            $virgula = ",";
        }
        if (trim($this->efd07_valorcp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_valorcp  "])) {
            $this->efd07_valorcp   = 0;
            $sql  .= $virgula . " efd07_valorcp   = $this->efd07_valorcp   ";
            $virgula = ",";
        }
        if (trim($this->efd07_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_dataenvio"])) {
            $sql  .= $virgula . " efd07_dataenvio = $this->efd07_dataenvio ";
            $virgula = ",";
            if (trim($this->efd07_dataenvio) == null) {
                $this->erro_sql = " Campo efd07_dataenvio não informado.";
                $this->erro_campo = "efd07_dataenvio";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_protocolo"])) {
            $sql  .= $virgula . " efd07_protocolo = $this->efd07_protocolo ";
            $virgula = ",";
            if (trim($this->efd07_protocolo) == null) {
                $this->erro_sql = " Campo efd07_protocolo não informado.";
                $this->erro_campo = "efd07_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_valorgilrat) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_valorgilrat "])) {
            $sql  .= $virgula . " efd07_valorgilrat this = $this->efd07_valorgilrat  ";
            $virgula = ",";
            if (trim($this->efd07_valorgilrat) == null) {
                $this->erro_sql = " Campo efd07_valorgilrat  informado.";
                $this->erro_campo = "efd07_valorgilrat ";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_status) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_status"])) {
            $sql  .= $virgula . " efd07_status = $this->efd07_status ";
            $virgula = ",";
            if (trim($this->efd07_status) == null) {
                $this->erro_sql = " Campo efd07_status não informado.";
                $this->erro_campo = "efd07_status";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd07_descResposta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd07_descResposta"])) {
            $sql  .= $virgula . " efd07_descResposta = $this->efd07_descResposta ";
            $virgula = ",";
            if (trim($this->efd07_descResposta) == null) {
                $this->erro_sql = " Campo efd07_descResposta não informado.";
                $this->erro_campo = "efd07_descResposta";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        $sql .= "efd07_sequencial = '$efd07_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr2055 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr2055 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd07_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfr2055
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd07_sequencial = $efd07_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfr2055 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfr2055 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfr2055";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd07_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr2055 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd07_sequencial != "" && $efd07_sequencial != null) {
                $sql2 = " where efdreinfr2055.efd07_sequencial = '$efd07_sequencial'";
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
    function sql_query_file($efd07_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfr2055 ";
        $sql .= " join efdreinfnotasr2055 on (efd08_cpfcnpjprodutor,efd08_protocolo) = (efd07_cpfcnpjprodutor,efd07_protocolo)";
        $sql .= " join pagordem on e50_codord = efd08_numeroop::int ";
        $sql .= " join empempenho on e50_numemp = e60_numemp ";
        $sql .= " join empefdreinf on efd60_numemp = e60_numemp ";
        $sql .= " join cgm on z01_cgccpf = efd07_cpfcnpjprodutor and z01_numcgm = e60_numcgm";
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
