<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao302024
class cl_regadesao302024
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
    var $si74_sequencial = 0;
    var $si74_tiporegistro = 0;
    var $si74_codorgao = null;
    var $si74_codunidadesub = null;
    var $si74_nroprocadesao = null;
    var $si74_exercicioadesao = 0;
    var $si74_nrolote = 0;
    var $si74_coditem = 0;
    var $si74_percdesconto = 0;
    var $si74_tipodocumento = 0;
    var $si74_nrodocumento = null;
    var $si74_mes = 0;
    var $si74_instit = 0;
    var $si74_reg10 = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 si74_sequencial = int8 = sequencial
                 si74_tiporegistro = int8 = Tipo do  registro
                 si74_codorgao = varchar(2) = Código do órgão
                 si74_codunidadesub = varchar(8) = Código da unidade
                 si74_nroprocadesao = varchar(12) = Número do  processo de  adesão
                 si74_exercicioadesao = int8 = Exercício do  processo de  adesão
                 si74_nrolote = int8 = Número do Lote
                 si74_coditem = int8 = Código do item
                 si74_percdesconto = float8 = Percentual do  desconto
                 si74_tipodocumento = int8 = Tipo do  documento
                 si74_nrodocumento = varchar(14) = Número do  documento
                 si74_mes = int8 = Mês
                 si74_instit = int8 = Instituição
                 si74_reg10 = int = reg10
                 ";

    //funcao construtor da classe
    function cl_regadesao()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("regadesao302024");
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
            $this->si74_sequencial = ($this->si74_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_sequencial"] : $this->si74_sequencial);
            $this->si74_tiporegistro = ($this->si74_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_tiporegistro"] : $this->si74_tiporegistro);
            $this->si74_codorgao = ($this->si74_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_codorgao"] : $this->si74_codorgao);
            $this->si74_codunidadesub = ($this->si74_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_codunidadesub"] : $this->si74_codunidadesub);
            $this->si74_nroprocadesao = ($this->si74_nroprocadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_nroprocadesao"] : $this->si74_nroprocadesao);
            $this->si74_exercicioadesao = ($this->si74_exercicioadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_exercicioadesao"] : $this->si74_exercicioadesao);
            $this->si74_nrolote = ($this->si74_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_nrolote"] : $this->si74_nrolote);
            $this->si74_coditem = ($this->si74_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_coditem"] : $this->si74_coditem);
            $this->si74_percdesconto = ($this->si74_percdesconto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_percdesconto"] : $this->si74_percdesconto);
            $this->si74_tipodocumento = ($this->si74_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_tipodocumento"] : $this->si74_tipodocumento);
            $this->si74_nrodocumento = ($this->si74_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_nrodocumento"] : $this->si74_nrodocumento);
            $this->si74_mes = ($this->si74_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_mes"] : $this->si74_mes);
            $this->si74_instit = ($this->si74_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_instit"] : $this->si74_instit);
            $this->si74_reg10 = ($this->si74_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_reg10"] : $this->si74_reg10);
        } else {
            $this->si74_sequencial = ($this->si74_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_sequencial"] : $this->si74_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si74_sequencial)
    {
        $this->atualizacampos();
        if ($this->si74_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do  registro nao Informado.";
            $this->erro_campo = "si74_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si74_exercicioadesao == null) {
            $this->si74_exercicioadesao = "0";
        }
        if ($this->si74_nrolote == null) {
            $this->si74_nrolote = "0";
        }
        if ($this->si74_coditem == null) {
            $this->si74_coditem = "0";
        }
        if ($this->si74_percdesconto == null) {
            $this->si74_percdesconto = "0";
        }
        if ($this->si74_tipodocumento == null) {
            $this->si74_tipodocumento = "0";
        }
        if ($this->si74_mes == null) {
            $this->erro_sql = " Campo Mês nao Informado.";
            $this->erro_campo = "si74_mes";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si74_instit == null) {
            $this->erro_sql = " Campo Instituição nao Informado.";
            $this->erro_campo = "si74_instit";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si74_reg10 == null) {
            $this->si74_reg10 = "0";
        }
        if ($si74_sequencial == "" || $si74_sequencial == null) {
            $result = db_query("select nextval('regadesao302024_si74_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: regadesao302024_si74_sequencial_seq do campo: si74_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";
                return false;
            }
            $this->si74_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from regadesao302024_si74_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si74_sequencial)) {
                $this->erro_sql = " Campo si74_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->si74_sequencial = $si74_sequencial;
            }
        }
        if (($this->si74_sequencial == null) || ($this->si74_sequencial == "")) {
            $this->erro_sql = " Campo si74_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into regadesao302024(
                                       si74_sequencial
                                      ,si74_tiporegistro
                                      ,si74_codorgao
                                      ,si74_codunidadesub
                                      ,si74_nroprocadesao
                                      ,si74_exercicioadesao
                                      ,si74_nrolote
                                      ,si74_coditem
                                      ,si74_percdesconto
                                      ,si74_tipodocumento
                                      ,si74_nrodocumento
                                      ,si74_mes
                                      ,si74_instit
                                      ,si74_reg10
                       )
                values (
                                $this->si74_sequencial
                               ,$this->si74_tiporegistro
                               ,'$this->si74_codorgao'
                               ,'$this->si74_codunidadesub'
                               ,'$this->si74_nroprocadesao'
                               ,$this->si74_exercicioadesao
                               ,$this->si74_nrolote
                               ,$this->si74_coditem
                               ,$this->si74_percdesconto
                               ,$this->si74_tipodocumento
                               ,'$this->si74_nrodocumento'
                               ,$this->si74_mes
                               ,$this->si74_instit
                               ,$this->si74_reg10
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "regadesao302024 ($this->si74_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "regadesao302024 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "regadesao302024 ($this->si74_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si74_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    // funcao para alteracao
    function alterar($si74_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update regadesao302024 set ";
        $virgula = "";
        if (trim($this->si74_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_sequencial"])) {
            if (trim($this->si74_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_sequencial"])) {
                $this->si74_sequencial = "0";
            }
            $sql .= $virgula . " si74_sequencial = $this->si74_sequencial ";
            $virgula = ",";
        }
        if (trim($this->si74_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_tiporegistro"])) {
            $sql .= $virgula . " si74_tiporegistro = $this->si74_tiporegistro ";
            $virgula = ",";
            if (trim($this->si74_tiporegistro) == null) {
                $this->erro_sql = " Campo Tipo do  registro nao Informado.";
                $this->erro_campo = "si74_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si74_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_codorgao"])) {
            $sql .= $virgula . " si74_codorgao = '$this->si74_codorgao' ";
            $virgula = ",";
        }
        if (trim($this->si74_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_codunidadesub"])) {
            $sql .= $virgula . " si74_codunidadesub = '$this->si74_codunidadesub' ";
            $virgula = ",";
        }
        if (trim($this->si74_nroprocadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_nroprocadesao"])) {
            $sql .= $virgula . " si74_nroprocadesao = '$this->si74_nroprocadesao' ";
            $virgula = ",";
        }
        if (trim($this->si74_exercicioadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_exercicioadesao"])) {
            if (trim($this->si74_exercicioadesao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_exercicioadesao"])) {
                $this->si74_exercicioadesao = "0";
            }
            $sql .= $virgula . " si74_exercicioadesao = $this->si74_exercicioadesao ";
            $virgula = ",";
        }
        if (trim($this->si74_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_nrolote"])) {
            if (trim($this->si74_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_nrolote"])) {
                $this->si74_nrolote = "0";
            }
            $sql .= $virgula . " si74_nrolote = $this->si74_nrolote ";
            $virgula = ",";
        }
        if (trim($this->si74_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_coditem"])) {
            if (trim($this->si74_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_coditem"])) {
                $this->si74_coditem = "0";
            }
            $sql .= $virgula . " si74_coditem = $this->si74_coditem ";
            $virgula = ",";
        }
        if (trim($this->si74_percdesconto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_percdesconto"])) {
            if (trim($this->si74_percdesconto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_percdesconto"])) {
                $this->si74_percdesconto = "0";
            }
            $sql .= $virgula . " si74_percdesconto = $this->si74_percdesconto ";
            $virgula = ",";
        }
        if (trim($this->si74_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_tipodocumento"])) {
            if (trim($this->si74_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_tipodocumento"])) {
                $this->si74_tipodocumento = "0";
            }
            $sql .= $virgula . " si74_tipodocumento = $this->si74_tipodocumento ";
            $virgula = ",";
        }
        if (trim($this->si74_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_nrodocumento"])) {
            $sql .= $virgula . " si74_nrodocumento = '$this->si74_nrodocumento' ";
            $virgula = ",";
        }
        if (trim($this->si74_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_mes"])) {
            $sql .= $virgula . " si74_mes = $this->si74_mes ";
            $virgula = ",";
            if (trim($this->si74_mes) == null) {
                $this->erro_sql = " Campo Mês nao Informado.";
                $this->erro_campo = "si74_mes";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si74_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_instit"])) {
            $sql .= $virgula . " si74_instit = $this->si74_instit ";
            $virgula = ",";
            if (trim($this->si74_instit) == null) {
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "si74_instit";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if ($si74_sequencial != null) {
            $sql .= " si74_sequencial = $this->si74_sequencial";
        }
        $resaco = $this->sql_record($this->sql_query_file($this->si74_sequencial));

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "regadesao302024 nao Alterado. Alteracao Abortada.\n";
            $this->erro_sql .= "Valores : " . $this->si74_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "regadesao302024 nao foi Alterado. Alteracao Executada.\n";
                $this->erro_sql .= "Valores : " . $this->si74_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $this->si74_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($si74_sequencial = null, $dbwhere = null)
    {
        if ($dbwhere == null || $dbwhere == "") {
            $resaco = $this->sql_record($this->sql_query_file($si74_sequencial));
        } else {
            $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
        }
        $sql = " delete from regadesao302024
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si74_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si74_sequencial = $si74_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "regadesao302024 nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $si74_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "regadesao302024 nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $si74_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $si74_sequencial;
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
            $this->erro_sql = "Record Vazio na Tabela:regadesao302024";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($si74_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from regadesao302024 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si74_sequencial != null) {
                $sql2 .= " where regadesao302024.si74_sequencial = $si74_sequencial ";
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
    function sql_query_file($si74_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from regadesao302024 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si74_sequencial != null) {
                $sql2 .= " where regadesao302024.si74_sequencial = $si74_sequencial ";
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
