<?php
//MODULO: efdreinf
//CLASSE DA ENTIDADE efdreinfnotasr2010
class cl_efdreinfnotasr2010
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
    public $efd06_sequencial       = 0;
    public $efd06_mescompetencia   = 0;
    public $efd06_anocompetencia   = 0;
    public $efd06_cnpjprestador    = 0;
    public $efd06_tipoServico      = null;
    public $efd06_ambiente         = null;
    public $efd06_instit           = 0;
    public $efd06_protocolo        = 0;
    public $efd06_serie            = 0;
    public $efd06_numDocto         = 0;
    public $efd06_numeroop         = 0;
    public $efd06_dtEmissaoNF      = 0;
    public $efd06_vlrBruto         = 0;
    public $efd06_vlrBase          = 0;
    public $efd06_vlrRetido        = 0;

    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 efd06_sequencial     = int8 = efd06_sequencial 
                 efd06_mescompetencia = int8 = efd06_mescompetencia
                 efd06_cnpjprestador  = text = efd06_cnpjprestador
                 efd06_tipoServico    = text = efd06_tipoServico 
                 efd06_ambiente       = int8 = tipo de ambiente
                 efd06_instit         = int8 = efd06_instit 
                 efd06_anocompetencia = int8 = efd06_anocompetencia 
                 efd06_protocolo      = text = Protocolo 
                 efd06_serie          = int8 = Status
                 efd06_numDocto       = text = efd06_numDocto 
                 efd06_numeroop       = text = efd06_numeroop 
                 efd06_dtEmissaoNF    = text = efd06_dtEmissaoNF
                 efd06_vlrBruto       = float8 = Cefd06_vlrBruto 
                 efd06_vlrBase        = float8 = efd06_vlrBase
                 efd06_vlrRetido      = float8 = efd06_vlrRetido
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("efdreinfnotasr2010");
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
            $this->efd06_sequencial = ($this->efd06_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_sequencial"] : $this->efd06_sequencial);
            $this->efd06_mescompetencia = ($this->efd06_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd04_licitacao"] : $this->efd06_mescompetencia);
            $this->efd06_cnpjprestador = ($this->efd06_cnpjprestador == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_cnpjprestador"] : $this->efd06_cnpjprestador);
            $this->efd06_tipoServico = ($this->efd06_tipoServico == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_tipoServico"] : $this->efd06_tipoServico);
            $this->efd06_ambiente = ($this->efd06_ambiente == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_ambiente"] : $this->efd06_ambiente);
            $this->efd06_instit = ($this->efd06_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_instit"] : $this->efd06_instit);
            $this->efd06_anocompetencia = ($this->efd06_anocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_anocompetencia"] : $this->efd06_anocompetencia);
            $this->efd06_protocolo = ($this->efd06_protocolo == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_protocolo"] : $this->efd06_protocolo);
            $this->efd06_serie = ($this->efd06_serie == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_serie"] : $this->efd06_serie);
            $this->efd06_numDocto = ($this->efd06_numDocto == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_numDocto"] : $this->efd06_numDocto);
            $this->efd06_numeroop = ($this->efd06_numeroop == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_numeroop"] : $this->efd06_numeroop);
            $this->efd06_dtEmissaoNF = ($this->efd06_dtEmissaoNF == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_dtEmissaoNF"] : $this->efd06_dtEmissaoNF);
            $this->efd06_vlrBruto = ($this->efd06_vlrBruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_vlrBruto"] : $this->efd06_vlrBruto);
            $this->efd06_vlrBase = ($this->efd06_vlrBase == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_vlrBase"] : $this->efd06_vlrBase);
            $this->efd06_vlrRetido = ($this->efd06_vlrRetido == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd06_vlrRetido"] : $this->efd06_vlrRetido);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {

        $this->atualizacampos();

        if ($this->efd06_mescompetencia == null) {
            $this->erro_sql = " Campo efd06_mescompetencia não informado.";
            $this->erro_campo = "efd06_mescompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd06_anocompetencia == null) {
            $this->erro_sql = " Campo efd06_anocompetencia não informado.";
            $this->erro_campo = "efd06_anocompetencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd06_cnpjprestador == null) {
            $this->erro_sql = " Campo efd06_cnpjprestador não informado.";
            $this->erro_campo = "efd06_cnpjprestador";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd06_tipoServico == null) {
            $this->erro_sql = " Campo efd06_tipoServico não informado.";
            $this->erro_campo = "efd06_tipoServico";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd06_instit == null) {
            $this->erro_sql = " Campo efd06_instit não informado.";
            $this->erro_campo = "efd06_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd06_ambiente == null) {
            $this->erro_sql = " Campo efd06_ambiente não informado.";
            $this->erro_campo = "efd06_ambiente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd06_vlrBruto == null) {
            $this->efd06_vlrBruto = 'null';
        }
        if ($this->efd06_vlrBase == null) {
            $this->efd06_vlrBase = 'null';
        }
        if ($this->efd06_vlrRetido == null) {
            $this->efd06_vlrRetido = 'null';
        }

        if ($this->efd06_sequencial == "" || $this->efd06_sequencial == null) {
            $result = db_query("select nextval('efdreinfnotasr2010_efd06_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: efdreinfnotasr2010_efd06_sequencial_seq do campo: efd06_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->efd06_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from efdreinfnotasr2010_efd06_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->efd06_sequencial)) {
                $this->erro_sql = " Campo efd06_sequencial maior que ultimo número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->efd06_sequencial = $this->efd06_sequencial;
            }
        }
        if (($this->efd06_sequencial == null) || ($this->efd06_sequencial == "")) {
            $this->erro_sql = " Campo efd06_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into efdreinfnotasr2010(
                                       efd06_sequencial 
                                      ,efd06_mescompetencia
                                      ,efd06_anocompetencia
                                      ,efd06_cnpjprestador 
                                      ,efd06_tipoServico
                                      ,efd06_ambiente 
                                      ,efd06_instit 
                                      ,efd06_protocolo
                                      ,efd06_serie
                                      ,efd06_numDocto
                                      ,efd06_numeroop
                                      ,efd06_dtEmissaoNF
                                      ,efd06_vlrBruto
                                      ,efd06_vlrBase
                                      ,efd06_vlrRetido
                       )
                values (
                                $this->efd06_sequencial 
                               ,'$this->efd06_mescompetencia'
                               ,'$this->efd06_anocompetencia' 
                               ,'$this->efd06_cnpjprestador' 
                               ,'$this->efd06_tipoServico'
                               ,$this->efd06_ambiente
                               ,$this->efd06_instit
                               ,'$this->efd06_protocolo'
                               ,'$this->efd06_serie'
                               ,'$this->efd06_numDocto'
                               ,'$this->efd06_numeroop'
                               ,'$this->efd06_dtEmissaoNF'
                               ,$this->efd06_vlrBruto
                               ,$this->efd06_vlrBase
                               ,$this->efd06_vlrRetido
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "efdreinfnotasr2010 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "efdreinfnotasr2010 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "efdreinfnotasr2010 () nao Incluído. Inclusao Abortada.";
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
    function alterar($efd06_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update efdreinfnotasr2010 set ";
        $virgula = "";
        if (trim($this->efd06_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_sequencial"])) {
            $sql  .= $virgula . " efd06_sequencial = $this->efd06_sequencial ";
            $virgula = ",";
            if (trim($this->efd06_sequencial) == null) {
                $this->erro_sql = " Campo efd06_sequencial não informado.";
                $this->erro_campo = "efd06_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->efd06_mescompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_mescompetencia"])) {
            $sql  .= $virgula . " efd06_mescompetencia= $this->efd06_mescompetencia";
            $virgula = ",";
            if (trim($this->efd06_mescompetencia) == null) {
                $this->erro_sql = " Campo efd06_mescompetencia não informado.";
                $this->erro_campo = "efd04_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_anocompetencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_anocompetencia"])) {
            $sql  .= $virgula . " efd06_anocompetencia= $this->efd06_anocompetencia";
            $virgula = ",";
            if (trim($this->efd06_anocompetencia) == null) {
                $this->erro_sql = " Campo efd06_anocompetencia não informado.";
                $this->erro_campo = "efd06_anocompetencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->efd06_cnpjprestador) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_cnpjprestador"])) {
            $sql  .= $virgula . " efd06_cnpjprestador = '$this->efd06_cnpjprestador'";
            $virgula = ",";
            if (trim($this->efd06_cnpjprestador) == null) {
                $this->erro_sql = " Campo efd06_cnpjprestador não informado.";
                $this->erro_campo = "efd06_cnpjprestador";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_tipoServico) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_tipoServico"])) {
            $sql  .= $virgula . " efd06_tipoServico = '$this->efd06_tipoServico' ";
            $virgula = ",";
            if (trim($this->efd06_tipoServico) == null) {
                $this->erro_sql = " Campo efd06_tipoServico não informado.";
                $this->erro_campo = "efd06_tipoServico";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_instit"])) {
            $sql  .= $virgula . " efd06_instit = $this->efd06_instit ";
            $virgula = ",";
            if (trim($this->efd06_instit) == null) {
                $this->erro_sql = " Campo efd06_instit não informado.";
                $this->erro_campo = "efd06_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_protocolo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_protocolo"])) {
            $sql  .= $virgula . " efd06_protocolo = $this->efd06_protocolo ";
            $virgula = ",";
            if (trim($this->efd06_protocolo) == null) {
                $this->erro_sql = " Campo efd06_protocolo não informado.";
                $this->erro_campo = "efd06_protocolo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_serie) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_serie"])) {
            $sql  .= $virgula . " efd06_serie = $this->efd06_serie ";
            $virgula = ",";
            if (trim($this->efd06_serie) == null) {
                $this->erro_sql = " Campo efd06_serie não informado.";
                $this->erro_campo = "efd06_serie";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_vlrBruto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_vlrBruto"])) {
            $sql  .= $virgula . " efd06_vlrBruto = $this->efd06_vlrBruto ";
            $virgula = ",";
            if (trim($this->efd06_vlrBruto) == null) {
                $this->erro_sql = " Campo efd06_vlrBruto não informado.";
                $this->erro_campo = "efd06_vlrBruto";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_vlrBase) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_vlrBase"])) {
            $sql  .= $virgula . " efd06_vlrBase = $this->efd06_vlrBase ";
            $virgula = ",";
            if (trim($this->efd06_vlrBase) == null) {
                $this->erro_sql = " Campo efd06_vlrBase não informado.";
                $this->erro_campo = "efd06_vlrBase";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_vlrRetido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_vlrRetido"])) {
            $sql  .= $virgula . " efd06_vlrRetido = $this->efd06_vlrRetido ";
            $virgula = ",";
            if (trim($this->efd06_vlrRetido) == null) {
                $this->erro_sql = " Campo efd06_vlrRetido não informado.";
                $this->erro_campo = "efd06_vlrRetido";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_numDocto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_numDocto"])) {
            $sql  .= $virgula . " efd06_numDocto = $this->efd06_numDocto ";
            $virgula = ",";
            if (trim($this->efd06_numDocto) == null) {
                $this->erro_sql = " Campo efd06_numDocto não informado.";
                $this->erro_campo = "efd06_numDocto";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->efd06_numeroop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_numeroop"])) {
            $this->efd06_numeroop = "";
            $sql  .= $virgula . " efd06_numeroop = $this->efd06_numeroop ";
            $virgula = ",";
        }
        if (trim($this->efd06_dtEmissaoNF) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd06_dtEmissaoNF"])) {
            $sql  .= $virgula . " efd06_dtEmissaoNF = $this->efd06_dtEmissaoNF ";
            $virgula = ",";
            if (trim($this->efd06_dtEmissaoNF) == null) {
                $this->erro_sql = " Campo efd06_dtEmissaoNF não informado.";
                $this->erro_campo = "efd06_dtEmissaoNF";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "efd06_sequencial = '$efd06_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfnotasr2010 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfnotasr2010 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($efd06_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from efdreinfnotasr2010
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "efd06_sequencial = $efd06_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "efdreinfnotasr2010 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "efdreinfnotasr2010 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:efdreinfnotasr2010";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($efd06_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfnotasr2010 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd06_sequencial != "" && $efd06_sequencial != null) {
                $sql2 = " where efdreinfnotasr2010.efd06_sequencial = '$efd06_sequencial'";
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
    function sql_query_file($efd06_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from efdreinfnotasr2010 ";
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
