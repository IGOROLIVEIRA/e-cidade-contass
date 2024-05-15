<?
//MODULO: sicom
//CLASSE DA ENTIDADE conv212020
class cl_conv212020
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
    var $si232_sequencial = 0;
    var $si232_tiporegistro = 0;
    var $si232_codconvaditivo = null;
    var $si232_tipotermoaditivo = null;
    var $si232_dsctipotermoaditivo = null;
    var $si232_mes = 0;
    var $si232_instint = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 si232_sequencial = int8 = Sequencial
                 si232_tiporegistro = int8 = Tipo do Registro
                 si232_codconvaditivo = varchar(20) = Código Convênio Aditivo
                 si232_tipotermoaditivo = varchar(2) = Tipo do Termo Aditivo
                 si232_dsctipotermoaditivo = varchar(250) = Descrição do Tipo do Termo Aditivo
                 si232_mes = int8 = Mês
                 si232_instint = int8 = Instituição
                 ";

    //funcao construtor da classe
    function cl_conv212020()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("conv212020");
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
            $this->si232_sequencial = ($this->si232_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_sequencial"] : $this->si232_sequencial);
            $this->si232_tiporegistro = ($this->si232_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_tiporegistro"] : $this->si232_tiporegistro);
            $this->si232_codconvaditivo = ($this->si232_codconvaditivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_codconvaditivo"] : $this->si232_codconvaditivo);
            $this->si232_tipotermoaditivo = ($this->si232_tipotermoaditivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_tipotermoaditivo"] : $this->si232_tipotermoaditivo);

            $this->si232_dsctipotermoaditivo = ($this->si232_dsctipotermoaditivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_dsctipotermoaditivo"] : $this->si232_dsctipotermoaditivo);
            $this->si232_mes = ($this->si232_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_mes"] : $this->si232_mes);
            $this->si232_instint = ($this->si232_instint == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_instint"] : $this->si232_instint);
        } else {
            $this->si232_sequencial = ($this->si232_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si232_sequencial"] : $this->si232_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si232_sequencial)
    {
        $this->atualizacampos();
        if ($this->si232_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si232_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($this->si232_mes == null) {
            $this->erro_sql = " Campo Mês nao Informado.";
            $this->erro_campo = "si232_mes";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($this->si232_instint == null) {
            $this->erro_sql = " Campo Instituição nao Informado.";
            $this->erro_campo = "si232_instint";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($si232_sequencial == "" || $si232_sequencial == null) {
            $result = db_query("select nextval('conv212020_si232_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("
", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: conv212020_si232_sequencial_seq do campo: si232_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
            $this->si232_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from conv212020_si232_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si232_sequencial)) {
                $this->erro_sql = " Campo si232_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            } else {
                $this->si232_sequencial = $si232_sequencial;
            }
        }
        if (($this->si232_sequencial == null) || ($this->si232_sequencial == "")) {
            $this->erro_sql = " Campo si232_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $sql = "insert into conv212020(
                                       si232_sequencial
                                      ,si232_tiporegistro
                                      ,si232_codconvaditivo
                                      ,si232_tipotermoaditivo
                                      ,si232_dsctipotermoaditivo
                                      ,si232_mes
                                      ,si232_instint
                       )
                values (
                                $this->si232_sequencial
                               ,$this->si232_tiporegistro
                               ,'$this->si232_codconvaditivo'
                               ,'$this->si232_tipotermoaditivo'
                               ,'$this->si232_dsctipotermoaditivo'
                               ,$this->si232_mes
                               ,$this->si232_instint
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("
", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "conv212020 ($this->si232_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "conv212020 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "conv212020 ($this->si232_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;

            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si232_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    // funcao para alteracao
    function alterar($si232_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update conv212020 set ";
        $virgula = "";
        if (trim($this->si232_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si232_sequencial"])) {
            if (trim($this->si232_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si232_sequencial"])) {
                $this->si232_sequencial = "0";
            }
            $sql .= $virgula . " si232_sequencial = $this->si232_sequencial ";
            $virgula = ",";
        }
        if (trim($this->si232_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si232_tiporegistro"])) {
            $sql .= $virgula . " si232_tiporegistro = $this->si232_tiporegistro ";
            $virgula = ",";
            if (trim($this->si232_tiporegistro) == null) {
                $this->erro_sql = " Campo Tipo do  registro nao Informado.";
                $this->erro_campo = "si232_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        if (trim($this->si232_codconvaditivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si232_codconvaditivo"])) {
            $sql .= $virgula . " si232_codconvaditivo = '$this->si232_codconvaditivo' ";
            $virgula = ",";
        }
        if (trim($this->si232_tipotermoaditivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si232_tipotermoaditivo"])) {
            $sql .= $virgula . " si232_tipotermoaditivo = '$this->si232_tipotermoaditivo' ";
            $virgula = ",";
        }
        if (trim($this->si232_dsctipotermoaditivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si232_dsctipotermoaditivo"])) {
            $sql .= $virgula . " si232_dsctipotermoaditivo = '$this->si232_dsctipotermoaditivo' ";
            $virgula = ",";
        }
        if (trim($this->si232_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si232_mes"])) {
            $sql .= $virgula . " si232_mes = $this->si232_mes ";
            $virgula = ",";
            if (trim($this->si232_mes) == null) {
                $this->erro_sql = " Campo Mês nao Informado.";
                $this->erro_campo = "si232_mes";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        if (trim($this->si232_instint) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si232_instint"])) {
            $sql .= $virgula . " si232_instint = $this->si232_instint ";
            $virgula = ",";
            if (trim($this->si232_instint) == null) {
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "si232_instint";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        $sql .= " where ";
        if ($si232_sequencial != null) {
            $sql .= " si232_sequencial = $this->si232_sequencial";
        }
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("
", "", @pg_last_error());
            $this->erro_sql = "conv212020 nao Alterado. Alteracao Abortada.\n";
            $this->erro_sql .= "Valores : " . $this->si232_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "conv212020 nao foi Alterado. Alteracao Executada.\n";
                $this->erro_sql .= "Valores : " . $this->si232_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $this->si232_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);

                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($si232_sequencial = null, $dbwhere = null)
    {
        $sql = " delete from conv212020
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si232_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si232_sequencial = $si232_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("
", "", @pg_last_error());
            $this->erro_sql = "conv212020 nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $si232_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "conv212020 nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $si232_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $si232_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
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
            $this->erro_banco = str_replace("
", "", @pg_last_error());
            $this->erro_sql = "Erro ao selecionar os registros.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql = "Record Vazio na Tabela:conv212020";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        return $result;
    }

    // funcao do sql
    function sql_query($si232_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from conv212020 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si232_sequencial != null) {
                $sql2 .= " where conv212020.si232_sequencial = $si232_sequencial ";
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
    function sql_query_file($si232_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from conv212020 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si232_sequencial != null) {
                $sql2 .= " where conv212020.si232_sequencial = $si232_sequencial ";
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
}

?>
