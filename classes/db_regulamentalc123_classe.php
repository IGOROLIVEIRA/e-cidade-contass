<?
//MODULO: licitacao
//CLASSE DA ENTIDADE regulamentalc123
class cl_regulamentalc123
{
    // cria variaveis de erro
    var $rotulo = null;
    var $query_sql = null;
    var $numrows = 0;
    var $numrows_incluir = 0;
    var $numrows_alterar = 0;
    var $numrows_excluir = 0;
    var $erro_status = null;
    var $erro_sql = null;
    var $erro_banco = null;
    var $erro_msg = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $l210_sequencial = 0;
    var $l210_regulamentart47 = 0;
    var $l210_nronormareg = null;
    var $l210_datanormareg_dia = null;
    var $l210_datanormareg_mes = null;
    var $l210_datanormareg_ano = null;
    var $l210_datanormareg = null;
    var $l210_datapubnormareg_dia = null;
    var $l210_datapubnormareg_mes = null;
    var $l210_datapubnormareg_ano = null;
    var $l210_datapubnormareg = null;
    var $l210_regexclusiva = 0;
    var $l210_artigoregexclusiva = null;
    var $l210_valorlimiteregexclusiva = 0;
    var $l210_procsubcontratacao = 0;
    var $l210_artigoprocsubcontratacao = null;
    var $l210_percentualsubcontratacao = 0;
    var $l210_criteriosempenhopagamento = 0;
    var $l210_artigoempenhopagamento = null;
    var $l210_estabeleceuperccontratacao = 0;
    var $l210_artigoperccontratacao = null;
    var $l210_percentualcontratacao = 0;
    var $l210_instit = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 l210_sequencial = int4 = Código 
                 l210_regulamentart47 = int8 = Possui regulamentação do art. 47: 
                 l210_nronormareg = varchar(6) = Numero norma: 
                 l210_datanormareg = date = Data norma: 
                 l210_datapubnormareg = date = Data publicação norma: 
                 l210_regexclusiva = int4 = Número da norma: 
                 l210_artigoregexclusiva = varchar(6) = Artigo da regulamentação exclusiva: 
                 l210_valorlimiteregexclusiva = float8 = Valor Limite da reg exclusiva: 
                 l210_procsubcontratacao = int4 = Procedimentos Subcontratacao: 
                 l210_artigoprocsubcontratacao = varchar(6) = Artigo proc subcontratação: 
                 l210_percentualsubcontratacao = float8 = Percent Subcontratacao: 
                 l210_criteriosempenhopagamento = int4 = Criterios Empenho Pagamento: 
                 l210_artigoempenhopagamento = varchar(6) = Artigo Empenho Pagamento: 
                 l210_estabeleceuperccontratacao = int4 = Estabeleceu Percent Contratacao? 
                 l210_artigoperccontratacao = varchar(6) = Artigo Percent. Contracação: 
                 l210_percentualcontratacao = float8 = Percentual contratado: 
                 l210_instit = int4 = Instituição 
                 ";

    //funcao construtor da classe
    function cl_regulamentalc123()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("regulamentalc123");
        $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
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
            $this->l210_sequencial = ($this->l210_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_sequencial"] : $this->l210_sequencial);
            $this->l210_regulamentart47 = ($this->l210_regulamentart47 == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_regulamentart47"] : $this->l210_regulamentart47);
            $this->l210_nronormareg = ($this->l210_nronormareg == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_nronormareg"] : $this->l210_nronormareg);
            if ($this->l210_datanormareg == "") {
                $this->l210_datanormareg_dia = ($this->l210_datanormareg_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_datanormareg_dia"] : $this->l210_datanormareg_dia);
                $this->l210_datanormareg_mes = ($this->l210_datanormareg_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_datanormareg_mes"] : $this->l210_datanormareg_mes);
                $this->l210_datanormareg_ano = ($this->l210_datanormareg_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_datanormareg_ano"] : $this->l210_datanormareg_ano);
                if ($this->l210_datanormareg_dia != "") {
                    $this->l210_datanormareg = $this->l210_datanormareg_ano . "-" . $this->l210_datanormareg_mes . "-" . $this->l210_datanormareg_dia;
                }
            }
            if ($this->l210_datapubnormareg == "") {
                $this->l210_datapubnormareg_dia = ($this->l210_datapubnormareg_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_datapubnormareg_dia"] : $this->l210_datapubnormareg_dia);
                $this->l210_datapubnormareg_mes = ($this->l210_datapubnormareg_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_datapubnormareg_mes"] : $this->l210_datapubnormareg_mes);
                $this->l210_datapubnormareg_ano = ($this->l210_datapubnormareg_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_datapubnormareg_ano"] : $this->l210_datapubnormareg_ano);
                if ($this->l210_datapubnormareg_dia != "") {
                    $this->l210_datapubnormareg = $this->l210_datapubnormareg_ano . "-" . $this->l210_datapubnormareg_mes . "-" . $this->l210_datapubnormareg_dia;
                }
            }
            $this->l210_regexclusiva = ($this->l210_regexclusiva == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_regexclusiva"] : $this->l210_regexclusiva);
            $this->l210_artigoregexclusiva = ($this->l210_artigoregexclusiva == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_artigoregexclusiva"] : $this->l210_artigoregexclusiva);
            $this->l210_valorlimiteregexclusiva = ($this->l210_valorlimiteregexclusiva == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_valorlimiteregexclusiva"] : $this->l210_valorlimiteregexclusiva);
            $this->l210_procsubcontratacao = ($this->l210_procsubcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_procsubcontratacao"] : $this->l210_procsubcontratacao);
            $this->l210_artigoprocsubcontratacao = ($this->l210_artigoprocsubcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_artigoprocsubcontratacao"] : $this->l210_artigoprocsubcontratacao);
            $this->l210_percentualsubcontratacao = ($this->l210_percentualsubcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_percentualsubcontratacao"] : $this->l210_percentualsubcontratacao);
            $this->l210_criteriosempenhopagamento = ($this->l210_criteriosempenhopagamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_criteriosempenhopagamento"] : $this->l210_criteriosempenhopagamento);
            $this->l210_artigoempenhopagamento = ($this->l210_artigoempenhopagamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_artigoempenhopagamento"] : $this->l210_artigoempenhopagamento);
            $this->l210_estabeleceuperccontratacao = ($this->l210_estabeleceuperccontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_estabeleceuperccontratacao"] : $this->l210_estabeleceuperccontratacao);
            $this->l210_artigoperccontratacao = ($this->l210_artigoperccontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_artigoperccontratacao"] : $this->l210_artigoperccontratacao);
            $this->l210_percentualcontratacao = ($this->l210_percentualcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_percentualcontratacao"] : $this->l210_percentualcontratacao);
            $this->l210_instit = ($this->l210_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l210_instit"] : $this->l210_instit);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();

        if ($this->l210_regulamentart47 == null) {
            $this->erro_sql = " Campo Possui regulamentação do art. 47: não informado.";
            $this->erro_campo = "l210_regulamentart47";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l210_regulamentart47 == 1) {
            if ($this->l210_nronormareg == null) {
                $this->erro_sql = " Campo Numero norma: não informado.";
                $this->erro_campo = "l210_nronormareg";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }

            if ($this->l210_datanormareg == null) {
                $this->erro_sql = " Campo Data norma: não informado.";
                $this->erro_campo = "l210_datanormareg";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }

            if ($this->l210_datapubnormareg == null) {
                $this->erro_sql = " Campo Data publicação norma: não informado.";
                $this->erro_campo = "l210_datapubnormareg";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            $this->l210_datanormareg = null;
            $this->l210_datapubnormareg = null;
            $this->l210_nronormareg = null;
        }
        if ($this->l210_regexclusiva == 1) {
            if ($this->l210_artigoregexclusiva == null) {
                $this->erro_sql = " Campo Artigo da regulamentação exclusiva: não informado.";
                $this->erro_campo = "l210_artigoregexclusiva";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }

            if ($this->l210_valorlimiteregexclusiva == null) {
                $this->erro_sql = " Campo Valor Limite da reg exclusiva: não informado.";
                $this->erro_campo = "l210_valorlimiteregexclusiva";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }

        } else {
            $this->l210_artigoregexclusiva = null;
            $this->l210_valorlimiteregexclusiva = 0;
        }
        if ($this->l210_procsubcontratacao == 1) {
            if ($this->l210_artigoprocsubcontratacao == null) {
                $this->erro_sql = " Campo Artigo proc subcontratação: não informado.";
                $this->erro_campo = "l210_artigoprocsubcontratacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            if ($this->l210_percentualsubcontratacao == null) {
                $this->erro_sql = " Campo Percent Subcontratacao: não informado.";
                $this->erro_campo = "l210_percentualsubcontratacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            $this->l210_artigoprocsubcontratacao = null;
            $this->l210_percentualsubcontratacao = 0;
        }

        if ($this->l210_criteriosempenhopagamento == 1) {
            if ($this->l210_artigoempenhopagamento == null) {
                $this->erro_sql = " Campo Artigo Empenho Pagamento: não informado.";
                $this->erro_campo = "l210_artigoempenhopagamento";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            $this->l210_artigoempenhopagamento = null;
        }

        if ($this->l210_estabeleceuperccontratacao == 1) {

            if ($this->l210_artigoperccontratacao == null) {
                $this->erro_sql = " Campo Artigo Percent. Contracação: não informado.";
                $this->erro_campo = "l210_artigoperccontratacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            if ($this->l210_percentualcontratacao == null) {
                $this->erro_sql = " Campo Percentual contratado: não informado.";
                $this->erro_campo = "l210_percentualcontratacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }else{
            $this->l210_artigoperccontratacao = null;
            $this->l210_percentualcontratacao = 0;
        }
        $sql = "insert into regulamentalc123(
                                       l210_sequencial 
                                      ,l210_regulamentart47 
                                      ,l210_nronormareg 
                                      ,l210_datanormareg 
                                      ,l210_datapubnormareg 
                                      ,l210_regexclusiva 
                                      ,l210_artigoregexclusiva 
                                      ,l210_valorlimiteregexclusiva 
                                      ,l210_procsubcontratacao 
                                      ,l210_artigoprocsubcontratacao 
                                      ,l210_percentualsubcontratacao 
                                      ,l210_criteriosempenhopagamento 
                                      ,l210_artigoempenhopagamento 
                                      ,l210_estabeleceuperccontratacao 
                                      ,l210_artigoperccontratacao 
                                      ,l210_percentualcontratacao 
                                      ,l210_instit 
                       )
                values (
                                (select nextval('licitacao.regulamentalc123_l210_sequencial_seq'))
                               ,$this->l210_regulamentart47 
                               ,'$this->l210_nronormareg' 
                               ," . ($this->l210_datanormareg == "null" || $this->l210_datanormareg == "" ? "null" : "'" . $this->l210_datanormareg . "'") . "
                               ," . ($this->l210_datapubnormareg == "null" || $this->l210_datapubnormareg == "" ? "null" : "'" . $this->l210_datapubnormareg . "'") . "
                               ,$this->l210_regexclusiva 
                               ,'$this->l210_artigoregexclusiva' 
                               ,$this->l210_valorlimiteregexclusiva 
                               ,$this->l210_procsubcontratacao 
                               ,'$this->l210_artigoprocsubcontratacao' 
                               ,$this->l210_percentualsubcontratacao 
                               ,$this->l210_criteriosempenhopagamento 
                               ,'$this->l210_artigoempenhopagamento' 
                               ,$this->l210_estabeleceuperccontratacao 
                               ,'$this->l210_artigoperccontratacao' 
                               ,$this->l210_percentualcontratacao 
                               ," . db_getsession('DB_instit') . "
                      )";
        $result = db_query($sql) or die($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "regulamentalc123 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "regulamentalc123 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql = "regulamentalc123 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))
        ) {

        }
        return true;
    }

    // funcao para alteracao
    function alterar($oid = null)
    {
        $this->atualizacampos();
        $sql = " update regulamentalc123 set ";
        $virgula = "";
        if (trim($this->l210_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_sequencial"])) {
            $sql .= $virgula . " l210_sequencial = $this->l210_sequencial ";
            $virgula = ",";
            if (trim($this->l210_sequencial) == null) {
                $this->erro_sql = " Campo Código não informado.";
                $this->erro_campo = "l210_sequencial";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l210_regulamentart47) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_regulamentart47"])) {
            $sql .= $virgula . " l210_regulamentart47 = $this->l210_regulamentart47 ";
            $virgula = ",";
            if (trim($this->l210_regulamentart47) == null) {
                $this->erro_sql = " Campo Possui regulamentação do art. 47: não informado.";
                $this->erro_campo = "l210_regulamentart47";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l210_nronormareg) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_nronormareg"])) {
            $sql .= $virgula . " l210_nronormareg = '$this->l210_nronormareg' ";
            $virgula = ",";
        }
        if (trim($this->l210_datanormareg) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_datanormareg_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["l210_datanormareg_dia"] != "")) {
            $sql .= $virgula . " l210_datanormareg = '$this->l210_datanormareg' ";
            $virgula = ",";
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["l210_datanormareg_dia"])) {
                $sql .= $virgula . " l210_datanormareg = null ";
                $virgula = ",";
            }
        }
        if (trim($this->l210_datapubnormareg) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_datapubnormareg_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["l210_datapubnormareg_dia"] != "")) {
            $sql .= $virgula . " l210_datapubnormareg = '$this->l210_datapubnormareg' ";
            $virgula = ",";
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["l210_datapubnormareg_dia"])) {
                $sql .= $virgula . " l210_datapubnormareg = null ";
                $virgula = ",";
            }
        }
        if (trim($this->l210_regexclusiva) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_regexclusiva"])) {
            if (trim($this->l210_regexclusiva) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l210_regexclusiva"])) {
                $this->l210_regexclusiva = "0";
            }
            $sql .= $virgula . " l210_regexclusiva = $this->l210_regexclusiva ";
            $virgula = ",";
        }
        if (trim($this->l210_artigoregexclusiva) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_artigoregexclusiva"])) {
            $sql .= $virgula . " l210_artigoregexclusiva = '$this->l210_artigoregexclusiva' ";
            $virgula = ",";
        }
        if (trim($this->l210_valorlimiteregexclusiva) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_valorlimiteregexclusiva"])) {
            $sql .= $virgula . " l210_valorlimiteregexclusiva = $this->l210_valorlimiteregexclusiva ";
            $virgula = ",";
            if (trim($this->l210_valorlimiteregexclusiva) == null) {
                $this->erro_sql = " Campo Valor Limite da reg exclusiva: não informado.";
                $this->erro_campo = "l210_valorlimiteregexclusiva";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l210_procsubcontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_procsubcontratacao"])) {
            if (trim($this->l210_procsubcontratacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l210_procsubcontratacao"])) {
                $this->l210_procsubcontratacao = "0";
            }
            $sql .= $virgula . " l210_procsubcontratacao = $this->l210_procsubcontratacao ";
            $virgula = ",";
        }
        if (trim($this->l210_artigoprocsubcontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_artigoprocsubcontratacao"])) {
            $sql .= $virgula . " l210_artigoprocsubcontratacao = '$this->l210_artigoprocsubcontratacao' ";
            $virgula = ",";
        }
        if (trim($this->l210_percentualsubcontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_percentualsubcontratacao"])) {
            $sql .= $virgula . " l210_percentualsubcontratacao = $this->l210_percentualsubcontratacao ";
            $virgula = ",";
            if (trim($this->l210_percentualsubcontratacao) == null) {
                $this->erro_sql = " Campo Percent Subcontratacao: não informado.";
                $this->erro_campo = "l210_percentualsubcontratacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l210_criteriosempenhopagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_criteriosempenhopagamento"])) {
            if (trim($this->l210_criteriosempenhopagamento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l210_criteriosempenhopagamento"])) {
                $this->l210_criteriosempenhopagamento = "0";
            }
            $sql .= $virgula . " l210_criteriosempenhopagamento = $this->l210_criteriosempenhopagamento ";
            $virgula = ",";
        }
        if (trim($this->l210_artigoempenhopagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_artigoempenhopagamento"])) {
            $sql .= $virgula . " l210_artigoempenhopagamento = '$this->l210_artigoempenhopagamento' ";
            $virgula = ",";
        }
        if (trim($this->l210_estabeleceuperccontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_estabeleceuperccontratacao"])) {
            if (trim($this->l210_estabeleceuperccontratacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l210_estabeleceuperccontratacao"])) {
                $this->l210_estabeleceuperccontratacao = "0";
            }
            $sql .= $virgula . " l210_estabeleceuperccontratacao = $this->l210_estabeleceuperccontratacao ";
            $virgula = ",";
        }
        if (trim($this->l210_artigoperccontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_artigoperccontratacao"])) {
            $sql .= $virgula . " l210_artigoperccontratacao = '$this->l210_artigoperccontratacao' ";
            $virgula = ",";
        }
        if (trim($this->l210_percentualcontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_percentualcontratacao"])) {
            $sql .= $virgula . " l210_percentualcontratacao = $this->l210_percentualcontratacao ";
            $virgula = ",";
            if (trim($this->l210_percentualcontratacao) == null) {
                $this->erro_sql = " Campo Percentual contratado: não informado.";
                $this->erro_campo = "l210_percentualcontratacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l210_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l210_instit"])) {
            if (trim($this->l210_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l210_instit"])) {
                $this->l210_instit = "0";
            }
            $sql .= $virgula . " l210_instit = $this->l210_instit ";
            $virgula = ",";
        }
        $sql .= " where ";
        $sql .= "oid = '$oid'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "regulamentalc123 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "regulamentalc123 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($oid = null, $dbwhere = null)
    {

        $sql = " delete from regulamentalc123
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "oid = '$oid'";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "regulamentalc123 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "regulamentalc123 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
            $this->numrows = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Erro ao selecionar os registros.";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql = "Record Vazio na Tabela:regulamentalc123";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($oid = null, $campos = "regulamentalc123.oid,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from regulamentalc123 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($oid != "" && $oid != null) {
                $sql2 = " where regulamentalc123.oid = '$oid'";
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
    function sql_query_file($oid = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from regulamentalc123 ";
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

?>
