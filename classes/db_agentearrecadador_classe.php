<?
//MODULO: caixa
//CLASSE DA ENTIDADE agentearrecadador
class cl_agentearrecadador
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
    var $k174_sequencial = 0;
    var $k174_codigobanco = 0;
    var $k174_descricao = null;
    var $k174_idcontabancaria = 0;
    var $k174_instit = 0;
    var $k174_numcgm = 0;
    // cria propriedade com as variaveis do arquivo 
    var $campos = "
                 k174_sequencial = int4 = Sequencial 
                 k174_codigobanco = int4 = Código do Banco 
                 k174_descricao = text = Descrição do Banco 
                 k174_idcontabancaria = int8 = Conta Bancária 
                 k174_instit = int4 = Instituição
                 k174_numcgm = int4 = Número de CGM
                 ";
    //funcao construtor da classe 
    function cl_agentearrecadador()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("agentearrecadador");
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
            $this->k174_sequencial = ($this->k174_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["k174_sequencial"] : $this->k174_sequencial);
            $this->k174_codigobanco = ($this->k174_codigobanco == "" ? @$GLOBALS["HTTP_POST_VARS"]["k174_codigobanco"] : $this->k174_codigobanco);
            $this->k174_descricao = ($this->k174_descricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["k174_descricao"] : $this->k174_descricao);
            $this->k174_idcontabancaria = ($this->k174_idcontabancaria == "" ? @$GLOBALS["HTTP_POST_VARS"]["k174_idcontabancaria"] : $this->k174_idcontabancaria);
            $this->k174_instit = ($this->k174_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["k174_instit"] : $this->k174_instit);
        } else {
        }
    }
    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();

        if ($this->k174_codigobanco == null) {
            $this->erro_sql = " Campo Código do Banco nao Informado.";
            $this->erro_campo = "k174_codigobanco";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->k174_descricao == null) {
            $this->erro_sql = " Campo Descrição do Banco nao Informado.";
            $this->erro_campo = "k174_descricao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->k174_idcontabancaria == null) {
            $this->erro_sql = " Campo Conta Bancária nao Informado.";
            $this->erro_campo = "k174_idcontabancaria";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->k174_instit == null) {
            $this->erro_sql = " Campo Instituição nao Informado.";
            $this->erro_campo = "k174_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k174_numcgm == null) {
            $this->erro_sql = " Campo Número CGM nao Informado.";
            $this->erro_campo = "k174_numcgm";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $result = @pg_query("insert into agentearrecadador(
                                      k174_codigobanco 
                                      ,k174_descricao 
                                      ,k174_idcontabancaria 
                                      ,k174_instit
                                      ,k174_numcgm
                       )
                values (
                               $this->k174_codigobanco 
                               ,'$this->k174_descricao' 
                               ,$this->k174_idcontabancaria
                               ,$this->k174_instit
                               ,$this->k174_numcgm
                      )");
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Cadastro de Agentes Arrecadadores () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Cadastro de Agentes Arrecadadores já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Cadastro de Agentes Arrecadadores () nao Incluído. Inclusao Abortada.";
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
    function alterar($k174_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update agentearrecadador set ";
        $virgula = "";
        if (trim($this->k174_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k174_sequencial"])) {
            $sql  .= $virgula . " k174_sequencial = $this->k174_sequencial ";
            $virgula = ",";
            if (trim($this->k174_sequencial) == null) {
                $this->erro_sql = " Campo Sequencial nao Informado.";
                $this->erro_campo = "k174_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->k174_codigobanco) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k174_codigobanco"])) {
            if (trim($this->k174_codigobanco) == "" && isset($GLOBALS["HTTP_POST_VARS"]["k174_codigobanco"])) {
                $this->k174_codigobanco = "0";
            }
            $sql  .= $virgula . " k174_codigobanco = $this->k174_codigobanco ";
            $virgula = ",";
            if (trim($this->k174_codigobanco) == null) {
                $this->erro_sql = " Campo Código do Banco nao Informado.";
                $this->erro_campo = "k174_codigobanco";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->k174_descricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k174_descricao"])) {
            $sql  .= $virgula . " k174_descricao = '$this->k174_descricao' ";
            $virgula = ",";
            if (trim($this->k174_descricao) == null) {
                $this->erro_sql = " Campo Descrição do Banco nao Informado.";
                $this->erro_campo = "k174_descricao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->k174_idcontabancaria) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k174_idcontabancaria"])) {
            if (trim($this->k174_idcontabancaria) == "" && isset($GLOBALS["HTTP_POST_VARS"]["k174_idcontabancaria"])) {
                $this->k174_idcontabancaria = "0";
            }
            $sql  .= $virgula . " k174_idcontabancaria = $this->k174_idcontabancaria ";
            $virgula = ",";
            if (trim($this->k174_idcontabancaria) == null) {
                $this->erro_sql = " Campo Conta Bancária nao Informado.";
                $this->erro_campo = "k174_idcontabancaria";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->k174_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k174_instit"])) {
            if (trim($this->k174_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["k174_instit"])) {
                $this->k174_instit = "0";
            }
            $sql  .= $virgula . " k174_instit = $this->k174_instit ";
            $virgula = ",";
            if (trim($this->k174_instit) == null) {
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "k174_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->k174_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k174_numcgm"])) {
            if (trim($this->k174_numcgm) == "" && isset($GLOBALS["HTTP_POST_VARS"]["k174_numcgm"])) {
                $this->k174_numcgm = "0";
            }
            $sql  .= $virgula . " k174_numcgm = $this->k174_numcgm ";
            $virgula = ",";
            if (trim($this->k174_numcgm) == null) {
                $this->erro_sql = " Campo Número CGM nao Informado.";
                $this->erro_campo = "k174_numcgm";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where k174_sequencial = $k174_sequencial ";
        $result = @pg_exec($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Cadastro de Agentes Arrecadadores nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Cadastro de Agentes Arrecadadores nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($k174_sequencial = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from agentearrecadador
                    where ";
        $sql2 = "";
        $sql2 = "k174_sequencial = $k174_sequencial";
        $result = @pg_exec($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Cadastro de Agentes Arrecadadores nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Cadastro de Agentes Arrecadadores nao Encontrado. Exclusão não Efetuada.\\n";
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
    function sql_query($k174_sequencial = null, $campos = "agentearrecadador.k174_sequencial,*", $ordem = null, $dbwhere = "")
    {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = split("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from agentearrecadador ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($k174_sequencial != "" && $k174_sequencial != null) {
                $sql2 = " where agentearrecadador.k174_sequencial = $k174_sequencial";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = split("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
    // funcao do sql 
    function sql_query_file($k174_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = split("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from agentearrecadador ";
        $sql2 = "";
        if ($dbwhere == "") {
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = split("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
}
