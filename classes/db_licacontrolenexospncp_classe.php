<?
//MODULO: acordos
//CLASSE DA ENTIDADE liccontroleanexopncp
class cl_liccontroleanexopncp
{
    // cria variaveis de erro 
    var $rotulo     = null;
    var $query_sql  = null;
    var $numrows    = 0;
    var $erro_status = null;
    var $erro_sql   = null;
    var $erro_banco = null;
    var $erro_msg   = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo 
    var $l218_sequencial = 0;
    var $l218_licitacao = 0;
    var $l218_usuario = 0;
    var $l218_dtlancamento_dia = null;
    var $l218_dtlancamento_mes = null;
    var $l218_dtlancamento_ano = null;
    var $l218_dtlancamento = null;
    var $l218_numerocontrolepncp = null;
    var $l218_tipoanexo = null;
    var $l218_instit = 0;
    var $l218_ano = 0;
    var $l218_sequencialpncp = 0;
    var $l218_sequencialarquivo = 0;
    var $l218_processodecompras = 0;
    // cria propriedade com as variaveis do arquivo 
    var $campos = "
                 l218_sequencial = int8 = Sequencial Anexos 
                 l218_licitacao = int8 = Código da licitacao 
                 l218_usuario = int8 = Código do Usuário 
                 l218_dtlancamento = date = Data Lançamento 
                 l218_numerocontrolepncp = varchar(250) = Número de Controle Anexo PNCP 
                 l218_tipoanexo = varchar(30) = Tipo de Anexo 
                 l218_instit = int8 = Tipo de Instituição 
                 l218_ano = int8 = Ano Empenho PNCP 
                 l218_sequencialpncp = int8 = Sequencial PNCP 
                 l218_sequencialarquivo = int8 = Sequencial Anexos PNCP 
                 l218_processodecompras = int8 = codigo de processo de compras
                 ";
    //funcao construtor da classe 
    function cl_liccontroleanexopncp()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("liccontroleanexopncp");
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
            $this->l218_sequencial = ($this->l218_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_sequencial"] : $this->l218_sequencial);
            $this->l218_licitacao = ($this->l218_licitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_licitacao"] : $this->l218_licitacao);
            $this->l218_processodecompras = ($this->l218_processodecompras == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_processodecompras"] : $this->l218_processodecompras);
            $this->l218_usuario = ($this->l218_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_usuario"] : $this->l218_usuario);
            if ($this->l218_dtlancamento == "") {
                $this->l218_dtlancamento_dia = @$GLOBALS["HTTP_POST_VARS"]["l218_dtlancamento_dia"];
                $this->l218_dtlancamento_mes = @$GLOBALS["HTTP_POST_VARS"]["l218_dtlancamento_mes"];
                $this->l218_dtlancamento_ano = @$GLOBALS["HTTP_POST_VARS"]["l218_dtlancamento_ano"];
                if ($this->l218_dtlancamento_dia != "") {
                    $this->l218_dtlancamento = $this->l218_dtlancamento_ano . "-" . $this->l218_dtlancamento_mes . "-" . $this->l218_dtlancamento_dia;
                }
            }
            $this->l218_numerocontrolepncp = ($this->l218_numerocontrolepncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_numerocontrolepncp"] : $this->l218_numerocontrolepncp);
            $this->l218_tipoanexo = ($this->l218_tipoanexo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_tipoanexo"] : $this->l218_tipoanexo);
            $this->l218_instit = ($this->l218_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_instit"] : $this->l218_instit);
            $this->l218_ano = ($this->l218_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_ano"] : $this->l218_ano);
            $this->l218_sequencialpncp = ($this->l218_sequencialpncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_sequencialpncp"] : $this->l218_sequencialpncp);
            $this->l218_sequencialarquivo = ($this->l218_sequencialarquivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_sequencialarquivo"] : $this->l218_sequencialarquivo);
        } else {
        }
    }
    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->l218_licitacao == null) {
            $this->l218_licitacao = "NULL";
        }

        if ($this->l218_processodecompras == null) {
            $this->l218_processodecompras = "NULL";
        }

        if ($this->l218_usuario == null) {
            $this->erro_sql = " Campo Código do Usuário nao Informado.";
            $this->erro_campo = "l218_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_dtlancamento == null) {
            $this->erro_sql = " Campo Data Lançamento nao Informado.";
            $this->erro_campo = "l218_dtlancamento_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_numerocontrolepncp == null) {
            $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
            $this->erro_campo = "l218_numerocontrolepncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_tipoanexo == null) {
            $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
            $this->erro_campo = "l218_tipoanexo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_instit == null) {
            $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
            $this->erro_campo = "l218_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_ano == null) {
            $this->erro_sql = " Campo Ano Empenho PNCP nao Informado.";
            $this->erro_campo = "l218_ano";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_sequencialpncp == null) {
            $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
            $this->erro_campo = "l218_sequencialpncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_sequencialarquivo == null) {
            $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
            $this->erro_campo = "l218_sequencialarquivo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l218_sequencial == "" || $this->l218_sequencial == null) {
            $result = db_query("select nextval('liccontroleanexopncp_l218_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: liccontroleanexopncp_l218_sequencial_seq do campo: l218_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l218_sequencial = pg_result($result, 0, 0);
        }

        $sql = "insert into liccontroleanexopncp(
                                       l218_sequencial 
                                      ,l218_licitacao 
                                      ,l218_usuario 
                                      ,l218_dtlancamento 
                                      ,l218_numerocontrolepncp 
                                      ,l218_tipoanexo 
                                      ,l218_instit 
                                      ,l218_ano 
                                      ,l218_sequencialpncp 
                                      ,l218_sequencialarquivo 
                                      ,l218_processodecompras
                       )
                values (
                                $this->l218_sequencial 
                               ,$this->l218_licitacao 
                               ,$this->l218_usuario 
                               ," . ($this->l218_dtlancamento == "null" || $this->l218_dtlancamento == "" ? "null" : "'" . $this->l218_dtlancamento . "'") . " 
                               ,'$this->l218_numerocontrolepncp' 
                               ,'$this->l218_tipoanexo' 
                               ,$this->l218_instit 
                               ,$this->l218_ano 
                               ,$this->l218_sequencialpncp 
                               ,$this->l218_sequencialarquivo 
                               ,$this->l218_processodecompras
                               )";
        $result = db_query($sql);

        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = " () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = " já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = " () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
    }
    // funcao para alteracao
    function alterar($l218_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update liccontroleanexopncp set ";
        $virgula = "";
        if (trim($this->l218_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_sequencial"])) {
            if (trim($this->l218_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l218_sequencial"])) {
                $this->l218_sequencial = "0";
            }
            $sql  .= $virgula . " l218_sequencial = $this->l218_sequencial ";
            $virgula = ",";
            if (trim($this->l218_sequencial) == null) {
                $this->erro_sql = " Campo Sequencial Anexos nao Informado.";
                $this->erro_campo = "l218_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_licitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_licitacao"])) {
            if (trim($this->l218_licitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l218_licitacao"])) {
                $this->l218_licitacao = "0";
            }
            $sql  .= $virgula . " l218_licitacao = $this->l218_licitacao ";
            $virgula = ",";
            if (trim($this->l218_licitacao) == null) {
                $this->erro_sql = " Campo Código do Acordo nao Informado.";
                $this->erro_campo = "l218_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_usuario"])) {
            if (trim($this->l218_usuario) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l218_usuario"])) {
                $this->l218_usuario = "0";
            }
            $sql  .= $virgula . " l218_usuario = $this->l218_usuario ";
            $virgula = ",";
            if (trim($this->l218_usuario) == null) {
                $this->erro_sql = " Campo Código do Usuário nao Informado.";
                $this->erro_campo = "l218_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l218_dtlancamento_dia"] != "")) {
            $sql  .= $virgula . " l218_dtlancamento = '$this->l218_dtlancamento' ";
            $virgula = ",";
            if (trim($this->l218_dtlancamento) == null) {
                $this->erro_sql = " Campo Data Lançamento nao Informado.";
                $this->erro_campo = "l218_dtlancamento_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["l218_dtlancamento_dia"])) {
                $sql  .= $virgula . " l218_dtlancamento = null ";
                $virgula = ",";
                if (trim($this->l218_dtlancamento) == null) {
                    $this->erro_sql = " Campo Data Lançamento nao Informado.";
                    $this->erro_campo = "l218_dtlancamento_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->l218_numerocontrolepncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_numerocontrolepncp"])) {
            $sql  .= $virgula . " l218_numerocontrolepncp = '$this->l218_numerocontrolepncp' ";
            $virgula = ",";
            if (trim($this->l218_numerocontrolepncp) == null) {
                $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
                $this->erro_campo = "l218_numerocontrolepncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_tipoanexo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_tipoanexo"])) {
            $sql  .= $virgula . " l218_tipoanexo = '$this->l218_tipoanexo' ";
            $virgula = ",";
            if (trim($this->l218_tipoanexo) == null) {
                $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
                $this->erro_campo = "l218_tipoanexo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_instit"])) {
            if (trim($this->l218_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l218_instit"])) {
                $this->l218_instit = "0";
            }
            $sql  .= $virgula . " l218_instit = $this->l218_instit ";
            $virgula = ",";
            if (trim($this->l218_instit) == null) {
                $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
                $this->erro_campo = "l218_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_ano"])) {
            if (trim($this->l218_ano) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l218_ano"])) {
                $this->l218_ano = "0";
            }
            $sql  .= $virgula . " l218_ano = $this->l218_ano ";
            $virgula = ",";
            if (trim($this->l218_ano) == null) {
                $this->erro_sql = " Campo Ano Empenho PNCP nao Informado.";
                $this->erro_campo = "l218_ano";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_sequencialpncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_sequencialpncp"])) {
            if (trim($this->l218_sequencialpncp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l218_sequencialpncp"])) {
                $this->l218_sequencialpncp = "0";
            }
            $sql  .= $virgula . " l218_sequencialpncp = $this->l218_sequencialpncp ";
            $virgula = ",";
            if (trim($this->l218_sequencialpncp) == null) {
                $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
                $this->erro_campo = "l218_sequencialpncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l218_sequencialarquivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_sequencialarquivo"])) {
            if (trim($this->l218_sequencialarquivo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l218_sequencialarquivo"])) {
                $this->l218_sequencialarquivo = "0";
            }
            $sql  .= $virgula . " l218_sequencialarquivo = $this->l218_sequencialarquivo ";
            $virgula = ",";
            if (trim($this->l218_sequencialarquivo) == null) {
                $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
                $this->erro_campo = "l218_sequencialarquivo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where l218_sequencial = $l218_sequencial ";
        $result = @pg_exec($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }
    // funcao para exclusao 
    function excluir($l218_sequencial = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from liccontroleanexopncp
                    where ";
        $sql2 = "";
        $sql2 = "l218_sequencial = $l218_sequencial";
        //  echo $sql.$sql2;
        $result = @pg_exec($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }
    // funcao para exclusao 
    function excluir_licitacao($l218_licitacao = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from liccontroleanexopncp
                    where ";
        $sql2 = "";
        $sql2 = "l218_licitacao = $l218_licitacao";
        //  echo $sql.$sql2;
        $result = @pg_exec($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }

    // funcao para exclusao 
    function excluir_processocompra($l218_processodecompras = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from liccontroleanexopncp
                        where ";
        $sql2 = "";
        $sql2 = "l218_processodecompras = $l218_processodecompras";
        //  echo $sql.$sql2;
        $result = @pg_exec($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }
    // funcao do recordset 
    function sql_record($sql)
    {
        $result = @pg_query($sql);
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
            $this->erro_sql   = "Dados do Grupo nao Encontrado";
            $this->erro_msg   = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql 
    function sql_query($l218_sequencial = null, $campos = "liccontroleanexopncp.l218_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liccontroleanexopncp ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l218_sequencial != "" && $l218_sequencial != null) {
                $sql2 = " where liccontroleanexopncp.l218_sequencial = $l218_sequencial";
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
    function sql_query_file($l218_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liccontroleanexopncp ";
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
