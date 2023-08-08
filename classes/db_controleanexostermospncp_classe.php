<?
//MODULO: acordos
//CLASSE DA ENTIDADE controleanexostermospncp
class cl_controleanexostermospncp
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
    var $ac57_sequencial = 0;
    var $ac57_acordo = 0;
    var $ac57_usuario = 0;
    var $ac57_dataenvio_dia = null;
    var $ac57_dataenvio_mes = null;
    var $ac57_dataenvio_ano = null;
    var $ac57_dataenvio = null;
    var $ac57_sequencialtermo = null;
    var $ac57_tipoanexo = null;
    var $ac57_instit = 0;
    var $ac57_ano = 0;
    var $ac57_sequencialpncp = 0;
    var $ac57_sequencialarquivo = 0;

    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 ac57_sequencial = int8 = Sequencial Anexos
                 ac57_acordo = int8 = Código da licitacao
                 ac57_usuario = int8 = Código do Usuário
                 ac57_dataenvio = date = Data Lançamento
                 ac57_sequencialtermo = varchar(250) = Número de Controle Anexo PNCP
                 ac57_tipoanexo = varchar(30) = Tipo de Anexo
                 ac57_instit = int8 = Tipo de Instituição
                 ac57_ano = int8 = Ano Empenho PNCP
                 ac57_sequencialpncp = int8 = Sequencial PNCP
                 ac57_sequencialarquivo = int8 = Sequencial Anexos PNCP
                 ";
    //funcao construtor da classe
    function cl_controleanexostermospncp()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("controleanexostermospncp");
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
            $this->ac57_sequencial = ($this->ac57_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_sequencial"] : $this->ac57_sequencial);
            $this->ac57_acordo = ($this->ac57_acordo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_acordo"] : $this->ac57_acordo);
            $this->ac57_usuario = ($this->ac57_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_usuario"] : $this->ac57_usuario);
            if ($this->ac57_dataenvio == "") {
                $this->ac57_dataenvio_dia = @$GLOBALS["HTTP_POST_VARS"]["ac57_dataenvio_dia"];
                $this->ac57_dataenvio_mes = @$GLOBALS["HTTP_POST_VARS"]["ac57_dataenvio_mes"];
                $this->ac57_dataenvio_ano = @$GLOBALS["HTTP_POST_VARS"]["ac57_dataenvio_ano"];
                if ($this->ac57_dataenvio_dia != "") {
                    $this->ac57_dataenvio = $this->ac57_dataenvio_ano . "-" . $this->ac57_dataenvio_mes . "-" . $this->ac57_dataenvio_dia;
                }
            }
            $this->ac57_sequencialtermo = ($this->ac57_sequencialtermo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_sequencialtermo"] : $this->ac57_sequencialtermo);
            $this->ac57_tipoanexo = ($this->ac57_tipoanexo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_tipoanexo"] : $this->ac57_tipoanexo);
            $this->ac57_instit = ($this->ac57_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_instit"] : $this->ac57_instit);
            $this->ac57_ano = ($this->ac57_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_ano"] : $this->ac57_ano);
            $this->ac57_sequencialpncp = ($this->ac57_sequencialpncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_sequencialpncp"] : $this->ac57_sequencialpncp);
            $this->ac57_sequencialarquivo = ($this->ac57_sequencialarquivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac57_sequencialarquivo"] : $this->ac57_sequencialarquivo);
        }
    }
    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->ac57_acordo == null) {
            $this->ac57_acordo = "NULL";
        }

        if ($this->ac57_usuario == null) {
            $this->erro_sql = " Campo Código do Usuário nao Informado.";
            $this->erro_campo = "ac57_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_dataenvio == null) {
            $this->erro_sql = " Campo Data Lançamento nao Informado.";
            $this->erro_campo = "ac57_dataenvio_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_sequencialtermo == null) {
            $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
            $this->erro_campo = "ac57_sequencialtermo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_tipoanexo == null) {
            $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
            $this->erro_campo = "ac57_tipoanexo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_instit == null) {
            $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
            $this->erro_campo = "ac57_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_ano == null) {
            $this->erro_sql = " Campo Ano PNCP nao Informado.";
            $this->erro_campo = "ac57_ano";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_sequencialpncp == null) {
            $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
            $this->erro_campo = "ac57_sequencialpncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_sequencialarquivo == null) {
            $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
            $this->erro_campo = "ac57_sequencialarquivo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ac57_sequencial == "" || $this->ac57_sequencial == null) {
            $result = db_query("select nextval('controleanexostermospncp_ac57_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: controleanexostermospncp_ac57_sequencial_seq do campo: ac57_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->ac57_sequencial = pg_result($result, 0, 0);
        }

        $sql = "insert into controleanexostermospncp(
                                       ac57_sequencial
                                      ,ac57_acordo
                                      ,ac57_usuario
                                      ,ac57_dataenvio
                                      ,ac57_sequencialtermo
                                      ,ac57_tipoanexo
                                      ,ac57_instit
                                      ,ac57_ano
                                      ,ac57_sequencialpncp
                                      ,ac57_sequencialarquivo
                       )
                values (
                                $this->ac57_sequencial
                               ,$this->ac57_acordo
                               ,$this->ac57_usuario
                               ," . ($this->ac57_dataenvio == "null" || $this->ac57_dataenvio == "" ? "null" : "'" . $this->ac57_dataenvio . "'") . "
                               ,$this->ac57_sequencialtermo
                               ,$this->ac57_tipoanexo
                               ,$this->ac57_instit
                               ,$this->ac57_ano
                               ,$this->ac57_sequencialpncp
                               ,$this->ac57_sequencialarquivo
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
    function alterar($ac57_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update controleanexostermospncp set ";
        $virgula = "";
        if (trim($this->ac57_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_sequencial"])) {
            if (trim($this->ac57_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac57_sequencial"])) {
                $this->ac57_sequencial = "0";
            }
            $sql  .= $virgula . " ac57_sequencial = $this->ac57_sequencial ";
            $virgula = ",";
            if (trim($this->ac57_sequencial) == null) {
                $this->erro_sql = " Campo Sequencial Anexos nao Informado.";
                $this->erro_campo = "ac57_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_acordo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_acordo"])) {
            if (trim($this->ac57_acordo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac57_acordo"])) {
                $this->ac57_acordo = "0";
            }
            $sql  .= $virgula . " ac57_acordo = $this->ac57_acordo ";
            $virgula = ",";
            if (trim($this->ac57_acordo) == null) {
                $this->erro_sql = " Campo Código do Acordo nao Informado.";
                $this->erro_campo = "ac57_acordo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_usuario"])) {
            if (trim($this->ac57_usuario) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac57_usuario"])) {
                $this->ac57_usuario = "0";
            }
            $sql  .= $virgula . " ac57_usuario = $this->ac57_usuario ";
            $virgula = ",";
            if (trim($this->ac57_usuario) == null) {
                $this->erro_sql = " Campo Código do Usuário nao Informado.";
                $this->erro_campo = "ac57_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_dataenvio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ac57_dataenvio_dia"] != "")) {
            $sql  .= $virgula . " ac57_dataenvio = '$this->ac57_dataenvio' ";
            $virgula = ",";
            if (trim($this->ac57_dataenvio) == null) {
                $this->erro_sql = " Campo Data Lançamento nao Informado.";
                $this->erro_campo = "ac57_dataenvio_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["ac57_dataenvio_dia"])) {
                $sql  .= $virgula . " ac57_dataenvio = null ";
                $virgula = ",";
                if (trim($this->ac57_dataenvio) == null) {
                    $this->erro_sql = " Campo Data Lançamento nao Informado.";
                    $this->erro_campo = "ac57_dataenvio_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->ac57_sequencialtermo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_sequencialtermo"])) {
            $sql  .= $virgula . " ac57_sequencialtermo = '$this->ac57_sequencialtermo' ";
            $virgula = ",";
            if (trim($this->ac57_sequencialtermo) == null) {
                $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
                $this->erro_campo = "ac57_sequencialtermo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_tipoanexo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_tipoanexo"])) {
            $sql  .= $virgula . " ac57_tipoanexo = '$this->ac57_tipoanexo' ";
            $virgula = ",";
            if (trim($this->ac57_tipoanexo) == null) {
                $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
                $this->erro_campo = "ac57_tipoanexo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_instit"])) {
            if (trim($this->ac57_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac57_instit"])) {
                $this->ac57_instit = "0";
            }
            $sql  .= $virgula . " ac57_instit = $this->ac57_instit ";
            $virgula = ",";
            if (trim($this->ac57_instit) == null) {
                $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
                $this->erro_campo = "ac57_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_ano"])) {
            if (trim($this->ac57_ano) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac57_ano"])) {
                $this->ac57_ano = "0";
            }
            $sql  .= $virgula . " ac57_ano = $this->ac57_ano ";
            $virgula = ",";
            if (trim($this->ac57_ano) == null) {
                $this->erro_sql = " Campo Ano Empenho PNCP nao Informado.";
                $this->erro_campo = "ac57_ano";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_sequencialpncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_sequencialpncp"])) {
            if (trim($this->ac57_sequencialpncp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac57_sequencialpncp"])) {
                $this->ac57_sequencialpncp = "0";
            }
            $sql  .= $virgula . " ac57_sequencialpncp = $this->ac57_sequencialpncp ";
            $virgula = ",";
            if (trim($this->ac57_sequencialpncp) == null) {
                $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
                $this->erro_campo = "ac57_sequencialpncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ac57_sequencialarquivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac57_sequencialarquivo"])) {
            if (trim($this->ac57_sequencialarquivo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac57_sequencialarquivo"])) {
                $this->ac57_sequencialarquivo = "0";
            }
            $sql  .= $virgula . " ac57_sequencialarquivo = $this->ac57_sequencialarquivo ";
            $virgula = ",";
            if (trim($this->ac57_sequencialarquivo) == null) {
                $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
                $this->erro_campo = "ac57_sequencialarquivo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ac57_sequencial = $ac57_sequencial ";
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
    function excluir($ac57_sequencial = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from controleanexostermospncp
                    where ";
        $sql2 = "";
        $sql2 = "ac57_sequencial = $ac57_sequencial";
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
    function excluir_licitacao($ac57_acordo = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from controleanexostermospncp
                    where ";
        $sql2 = "";
        $sql2 = "ac57_acordo = $ac57_acordo";
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
    function sql_query($ac57_sequencial = null, $campos = "controleanexostermospncp.ac57_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from controleanexostermospncp ";
        $sql .= " left join acocontroletermospncp on l214_acordo = ac57_acordo ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($ac57_sequencial != "" && $ac57_sequencial != null) {
                $sql2 = " where controleanexostermospncp.ac57_sequencial = $ac57_sequencial";
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
    function sql_query_file($ac57_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from controleanexostermospncp ";
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
