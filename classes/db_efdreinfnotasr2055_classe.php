<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfnotasr2055
class cl_efdreinfnotasr2055
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
    public $efd08_sequencial       = 0;
    public $efd08_mescompetencia   = 0;
    public $efd08_anocompetencia   = 0;
    public $efd08_cpfcnpjprodutor = 0;
    public $efd08_indaquisicao     = null;
    public $efd08_ambiente         = null;
    public $efd08_instit           = 0;
    public $efd08_protocolo        = 0;
    public $efd08_serie            = 0;
    public $efd08_numnotafiscal    = 0;
    public $efd08_numeroop         = 0;
    public $efd08_numemp           = 0;
    public $efd08_dtEmissaoNF      = 0;
    public $efd08_vlrBruto         = 0;
    public $efd08_vlrCP            = 0;
    public $efd08_vlrGilrat        = 0;
    public $efd08_vlrSenar        = 0;

    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd08_sequencial     = int8 = efd08_sequencial 
                 efd08_mescompetencia = int8 = efd08_mescompetencia
                 efd08_cpfcnpjprodutor = text = efd08_cpfcnpjprodutor               
                 efd08_indaquisicao   = text = efd08_indaquisicao 
                 efd08_ambiente       = int8 = tipo de ambiente
                 efd08_instit         = int8 = efd08_instit 
                 efd08_anocompetencia = int8 = efd08_anocompetencia 
                 efd08_protocolo      = text = Protocolo 
                 efd08_serie          = int8 = Status
                 efd08_numnotafiscal  = text = efd08_numnotafiscal 
                 efd08_numeroop       = text = efd08_numeroop 
                 efd08_numemp         = text = efd08_numemp  
                 efd08_dtEmissaoNF    = text = efd08_dtEmissaoNF
                 efd08_vlrBruto       = float8 = Cefd08_vlrBruto 
                 efd08_vlrCP          = float8 = efd08_vlrCP
                 efd08_vlrGilrat      = float8 = efd08_vlrGilrat
                 efd08_vlrSenar       = float8 = efd08_vlrSenar
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfnotasr2055");
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
            $this->efd08_sequencial = ($this->efd08_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_sequencial"] : $this->efd08_sequencial);
            $this->efd08_mescompetencia = ($this->efd08_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_licitacao"] : $this->efd08_mescompetencia);
            $this->efd08_cpfcnpjprodutor = ($this->efd08_cpfcnpjprodutor == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_cpfcnpjprodutor"] : $this->efd08_cpfcnpjprodutor);
            $this->efd08_indaquisicao = ($this->efd08_indaquisicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_indaquisicao"] : $this->efd08_indaquisicao);
            $this->efd08_ambiente = ($this->efd08_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_ambiente"] : $this->efd08_ambiente);
            $this->efd08_instit = ($this->efd08_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_instit"] : $this->efd08_instit);
            $this->efd08_anocompetencia = ($this->efd08_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_anocompetencia"] : $this->efd08_anocompetencia);
            $this->efd08_protocolo = ($this->efd08_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_protocolo"] : $this->efd08_protocolo);
            $this->efd08_serie = ($this->efd08_serie == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_serie"] : $this->efd08_serie);
            $this->efd08_numnotafiscal = ($this->efd08_numnotafiscal == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_numnotafiscal"] : $this->efd08_numnotafiscal);
            $this->efd08_numeroop = ($this->efd08_numeroop == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_numeroop"] : $this->efd08_numeroop);
            $this->efd08_numemp = ($this->efd08_numemp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_numemp"] : $this->efd08_numemp);
            $this->efd08_dtEmissaoNF = ($this->efd08_dtEmissaoNF == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_dtEmissaoNF"] : $this->efd08_dtEmissaoNF);
            $this->efd08_vlrBruto = ($this->efd08_vlrBruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_vlrBruto"] : $this->efd08_vlrBruto);
            $this->efd08_vlrCP = ($this->efd08_vlrCP == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_vlrCP"] : $this->efd08_vlrCP);
            $this->efd08_vlrGilrat = ($this->efd08_vlrGilrat == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_vlrGilrat"] : $this->efd08_vlrGilrat);
            $this->efd08_vlrSenar = ($this->efd08_vlrSenar == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd08_vlrSenar"] : $this->efd08_vlrSenar);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();
        if ($this->efd08_mescompetencia == null) {
            $this->erro_sql = " Campo efd08_mescompetencia não informado.";
            $this->erro_campo = "efd08_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd08_anocompetencia == null) {
            $this->erro_sql = " Campo efd08_anocompetencia não informado.";
            $this->erro_campo = "efd08_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd08_cpfcnpjprodutor == null) {
            $this->erro_sql = " Campo efd08_cpfcnpjprodutoro informado.";
            $this->erro_campo = "efd08_cpfcnpjprodutor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd08_indaquisicao == null) {
            $this->erro_sql = " Campo efd08_indaquisicao não informado.";
            $this->erro_campo = "efd08_indaquisicao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd08_instit == null) {
            $this->erro_sql = " Campo efd08_instit não informado.";
            $this->erro_campo = "efd08_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd08_ambiente == null) {
            $this->erro_sql = " Campo efd08_ambiente não informado.";
            $this->erro_campo = "efd08_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd08_vlrBruto == null) {
            $this->efd08_vlrBruto = 'null';
        }
        if ($this->efd08_vlrCP == null) {
            $this->efd08_vlrCP = 'null';
        }
        if ($this->efd08_vlrGilrat == null) {
            $this->efd08_vlrGilrat = 'null';
        }
        if ($this->efd08_vlrSenar == null) {
            $this->efd08_vlrSenar = 'null';
        }
        if ($this->efd08_numeroop == null) {
            $this->efd08_numeroop = "";
        }
        if ($this->efd08_numemp == null) {
            $this->efd08_numemp = "";
        }
        if ($this->efd08_dtEmissaoNF == null) {
            $this->erro_sql = " Campo efd08_dtEmissaoNF não informado.";
            $this->erro_campo = "efd08_dtEmissaoNF";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd08_sequencial == "" || $this->efd08_sequencial == null) {
            $result = db_query("select nextval('efdreinfnotasr2055_efd08_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfnotasr2055_efd08_sequencial_seq do campo: efd08_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd08_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfnotasr2055_efd08_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd08_sequencial)) {
                $this->erro_sql = " Campo efd08_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd08_sequencial = $this->efd08_sequencial;
            }
        }
        if (($this->efd08_sequencial == null) || ($this->efd08_sequencial == "")) {
            $this->erro_sql = " Campo efd08_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfnotasr2055(
                                       efd08_sequencial 
                                      ,efd08_mescompetencia
                                      ,efd08_anocompetencia
                                      ,efd08_cpfcnpjprodutor                                     
                                      ,efd08_indaquisicao
                                      ,efd08_ambiente 
                                      ,efd08_instit 
                                      ,efd08_protocolo
                                      ,efd08_serie
                                      ,efd08_numnotafiscal
                                      ,efd08_numeroop
                                      ,efd08_numemp
                                      ,efd08_dtEmissaoNF
                                      ,efd08_vlrBruto
                                      ,efd08_vlrCP
                                      ,efd08_vlrGilrat
                                      ,efd08_vlrSenar
                       )
                values (
                                $this->efd08_sequencial 
                               ,'$this->efd08_mescompetencia'
                               ,'$this->efd08_anocompetencia' 
                               ,'$this->efd08_cpfcnpjprodutor'                               
                               ,'$this->efd08_indaquisicao'
                               ,$this->efd08_ambiente
                               ,$this->efd08_instit
                               ,'$this->efd08_protocolo'
                               ,'$this->efd08_serie'
                               ,'$this->efd08_numnotafiscal'
                               ,'$this->efd08_numeroop'
                               ,'$this->efd08_numemp'
                               ,'$this->efd08_dtEmissaoNF'
                               ,$this->efd08_vlrBruto
                               ,$this->efd08_vlrCP
                               ,$this->efd08_vlrGilrat
                               ,$this->efd08_vlrSenar
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfnotasr2055 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfnotasr2055 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfnotasr2055 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd08_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfnotasr2055 set ";
        $virgula = "";
        if (trim($this->efd08_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_sequencial"])) {
            $sql  .= $virgula . " efd08_sequencial = $this->efd08_sequencial ";
            $virgula = ",";
            if (trim($this->efd08_sequencial) == null) {
                $this->erro_sql = " Campo efd08_sequencial não informado.";
                $this->erro_campo = "efd08_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->efd08_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_mescompetencia"])) {
            $sql  .= $virgula . " efd08_mescompetencia= $this->efd08_mescompetencia";
            $virgula = ",";
            if (trim($this->efd08_mescompetencia) == null) {
                $this->erro_sql = " Campo efd08_mescompetencia não informado.";
                $this->erro_campo = "efd04_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_anocompetencia"])) {
            $sql  .= $virgula . " efd08_anocompetencia= $this->efd08_anocompetencia";
            $virgula = ",";
            if (trim($this->efd08_anocompetencia) == null) {
                $this->erro_sql = " Campo efd08_anocompetencia não informado.";
                $this->erro_campo = "efd08_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->efd08_cpfcnpjprodutor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_cpfcnpjprodutor"])) {
            $sql  .= $virgula . " efd08_cpfcnpjprodutor = '$this->efd08_cpfcnpjprodutor' ";
            $virgula = ",";
            if (trim($this->efd08_cpfcnpjprodutor) == null) {
                $this->erro_sql = " Campo efd08_cpfcnpjprodutoro informado.";
                $this->erro_campo = "efd08_cpfcnpjprodutor";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_indaquisicao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_indaquisicao"])) {
            $sql  .= $virgula . " efd08_indaquisicao = '$this->efd08_indaquisicao' ";
            $virgula = ",";
            if (trim($this->efd08_indaquisicao) == null) {
                $this->erro_sql = " Campo efd08_indaquisicao não informado.";
                $this->erro_campo = "efd08_indaquisicao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_instit"])) {
            $sql  .= $virgula . " efd08_instit = $this->efd08_instit ";
            $virgula = ",";
            if (trim($this->efd08_instit) == null) {
                $this->erro_sql = " Campo efd08_instit não informado.";
                $this->erro_campo = "efd08_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_protocolo"])) {
            $sql  .= $virgula . " efd08_protocolo = $this->efd08_protocolo ";
            $virgula = ",";
            if (trim($this->efd08_protocolo) == null) {
                $this->erro_sql = " Campo efd08_protocolo não informado.";
                $this->erro_campo = "efd08_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_serie) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_serie"])) {
            $sql  .= $virgula . " efd08_serie = $this->efd08_serie ";
            $virgula = ",";
            if (trim($this->efd08_serie) == null) {
                $this->erro_sql = " Campo efd08_serie não informado.";
                $this->erro_campo = "efd08_serie";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_vlrBruto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_vlrBruto"])) {
            $sql  .= $virgula . " efd08_vlrBruto = $this->efd08_vlrBruto ";
            $virgula = ",";
            if (trim($this->efd08_vlrBruto) == null) {
                $this->erro_sql = " Campo efd08_vlrBruto não informado.";
                $this->erro_campo = "efd08_vlrBruto";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_vlrCP) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_vlrCP"])) {
            $sql  .= $virgula . " efd08_vlrCP = $this->efd08_vlrCP ";
            $virgula = ",";
            if (trim($this->efd08_vlrCP) == null) {
                $this->erro_sql = " Campo efd08_vlrCP não informado.";
                $this->erro_campo = "efd08_vlrCP";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_vlrSenar) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_vlrSenar"])) {
            $sql  .= $virgula . " efd08_vlrSenar = $this->efd08_vlrSenar ";
            $virgula = ",";
            if (trim($this->efd08_vlrSenar) == null) {
                $this->erro_sql = " Campo efd08_vlrSenar não informado.";
                $this->erro_campo = "efd08_vlrSenar";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_vlrGilrat) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_vlrGilrat"])) {
            $sql  .= $virgula . " efd08_vlrGilrat = $this->efd08_vlrGilrat ";
            $virgula = ",";
            if (trim($this->efd08_vlrGilrat) == null) {
                $this->erro_sql = " Campo efd08_vlrGilrat não informado.";
                $this->erro_campo = "efd08_vlrGilrat";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_numnotafiscal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_numnotafiscal"])) {
            $sql  .= $virgula . " efd08_numnotafiscal = $this->efd08_numnotafiscal ";
            $virgula = ",";
            if (trim($this->efd08_numnotafiscal) == null) {
                $this->erro_sql = " Campo efd08_numnotafiscal não informado.";
                $this->erro_campo = "efd08_numnotafiscal";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd08_numeroop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_numeroop"])) {
            $this->efd08_numeroop = "";
            $sql  .= $virgula . " efd08_numeroop = $this->efd08_numeroop ";
            $virgula = ",";
        }
        if (trim($this->efd08_numemp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_numemp"])) {
            $this->efd08_numemp = "";
            $sql  .= $virgula . " efd08_numemp = $this->efd08_numemp ";
            $virgula = ",";
        }
        if (trim($this->efd08_dtEmissaoNF) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd08_dtEmissaoNF"])) {
            $sql  .= $virgula . " efd08_dtEmissaoNF = $this->efd08_dtEmissaoNF ";
            $virgula = ",";
            if (trim($this->efd08_dtEmissaoNF) == null) {
                $this->erro_sql = " Campo efd08_dtEmissaoNF não informado.";
                $this->erro_campo = "efd08_dtEmissaoNF";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "efd08_sequencial = '$efd08_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfnotasr2055 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfnotasr2055 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd08_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfnotasr2055
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd08_sequencial = $efd08_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfnotasr2055 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfnotasr2055 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfnotasr2055";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd08_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfnotasr2055 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd08_sequencial != "" && $efd08_sequencial != null) {
                $sql2 = " where efdreinfnotasr2055.efd08_sequencial = '$efd08_sequencial'";
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
    function sql_query_file($efd08_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfnotasr2055 ";
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
