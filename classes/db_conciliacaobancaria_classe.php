<?
// MODULO: Caixa
// CLASSE DA ENTIDADE conciliacaobancaria
class cl_conciliacaobancaria
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
    var $k171_conta = 0;
    var $k171_saldo = 0;
    var $k171_data = null;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        k171_conta = int8 = Numero da Conta
        k171_saldo = float8 = Saldo Conciliado
        k171_data = date = Data do Periodo Final
        k171_dataconciliacao = date = Data da Conciliacao";

    // funcao erro
    function erro($mostra, $retorna) {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
            echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
            if ($retorna == true) {
                echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao = false) {
        if ($exclusao == false) {
            $this->k171_conta = ($this->k171_conta == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_conta"]:$this->k171_conta);
            $this->k171_saldo = ($this->k171_saldo == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_saldo"]:$this->k171_saldo);
            if ($this->k171_data == "") {
                $this->k171_data_dia = ($this->k171_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_data_dia"]:$this->k171_data_dia);
                $this->k171_data_mes = ($this->k171_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_data_mes"]:$this->k171_data_mes);
                $this->k171_data_ano = ($this->k171_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_data_ano"]:$this->k171_data_ano);
                if ($this->k171_data_dia != "") {
                    $this->k171_data = $this->k171_data_ano."-".$this->k171_data_mes."-".$this->k171_data_dia;
                }
            }
            if ($this->k171_dataconciliacao == "") {
                $this->k171_dataconciliacao_dia = ($this->k171_dataconciliacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_dataconciliacao_dia"]:$this->k171_dataconciliacao_dia);
                $this->k171_dataconciliacao_mes = ($this->k171_dataconciliacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_dataconciliacao_mes"]:$this->k171_dataconciliacao_mes);
                $this->k171_dataconciliacao_ano = ($this->k171_dataconciliacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_dataconciliacao_ano"]:$this->k171_dataconciliacao_ano);
                if ($this->k171_dataconciliacao_dia != "") {
                    $this->k171_dataconciliacao = $this->k171_dataconciliacao_ano."-".$this->k171_dataconciliacao_mes."-".$this->k171_dataconciliacao_dia;
                }
            }
        } else {
            $this->k171_conta = ($this->k171_conta == ""?@$GLOBALS["HTTP_POST_VARS"]["k171_conta"]:$this->k171_conta);
        }
    }

    // funcao para inclusao
    function incluir() {
        $this->atualizacampos();
        if ($this->k171_saldo == null) {
            $this->erro_sql = " Campo Saldo nao Informado.";
            $this->erro_campo = "k171_saldo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k171_data == null) {
            $this->erro_sql = " Campo Data não Informado.";
            $this->erro_campo = "k171_data_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k171_dataconciliacao == null) {
            $this->erro_sql = " Campo Data da Conciliação não Informado.";
            $this->erro_campo = "k171_dataconciliacao_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if (($this->k171_conta == null) || ($this->k171_conta == "")) {
            $this->erro_sql = " Campo k171_conta não declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into conciliacaobancaria (k171_conta, k171_saldo, k171_data, k171_dataconciliacao) values ($this->k171_conta, $this->k171_saldo, " . ($this->k171_data == "null" || $this->k171_data == "" ? "null" : "'" . $this->k171_data . "'") . ", " . ($this->k171_dataconciliacao == "null" || $this->k171_dataconciliacao == "" ? "null" : "'" . $this->k171_dataconciliacao . "'") . ")";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Conciliacao Bancaria para o Lancamento da conta ({$this->k171_conta}) nao Incluido. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Documento Automático Lançamento já Cadastrado";
                $this->erro_msg  .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Conciliacao Bancaria para o Lancamento da conta ({$this->k171_conta}) nao Incluido. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg  .=  str_replace('"', "",str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_msg  = $sql;
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql  = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->k171_conta;
        $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            $resaco = $this->sql_record($this->sql_query_file($this->k171_conta));
            if (($resaco != false) || ($this->numrows != 0)) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount, " . db_getsession("DB_acessado"). ")");
                $resac = db_query("insert into db_acountkey values($acount, 5213, '$this->k171_conta', 'I')");
                $resac = db_query("insert into db_acount values($acount, 764, 5213, '', '" . AddSlashes(pg_result($resaco, 0, 'k171_conta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5214, '', '" . AddSlashes(pg_result($resaco, 0, 'k171_saldo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k171_data')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar() {
        $this->atualizacampos();
        $sql = " update conciliacaobancaria set ";
        $virgula = "";
        if (trim($this->k171_conta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k171_conta"])) {
            $sql .= $virgula . " k171_conta = $this->k171_conta ";
            $virgula = ",";
            if (trim($this->k171_conta) == null) {
                $this->erro_sql = " Campo Código Lançamento não Informado.";
                $this->erro_campo = "k171_conta";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k171_saldo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k171_saldo"])) {
            $sql .= $virgula." k171_saldo = $this->k171_saldo ";
            $virgula = ",";
            if (trim($this->k171_saldo) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k171_saldo";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k171_data) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k171_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k171_data_dia"] != "")) {
            $sql .= $virgula." k171_data = '$this->k171_data' ";
            $virgula = ",";
            if (trim($this->k171_data) == null) {
                $this->erro_sql = " Campo Data não Informado.";
                $this->erro_campo = "k171_data_dia";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["k171_data_dia"])) {
                $sql .= $virgula . " k171_data = null ";
                $virgula = ",";
                if (trim($this->k171_data) == null) {
                    $this->erro_sql = " Campo Data não Informado.";
                    $this->erro_campo = "k171_data_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->k171_dataconciliacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k171_dataconciliacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k171_dataconciliacao_dia"] != "")) {
            $sql .= $virgula." k171_dataconciliacao = '$this->k171_dataconciliacao' ";
            $virgula = ",";
            if (trim($this->k171_dataconciliacao) == null) {
                $this->erro_sql = " Campo Data não Informado.";
                $this->erro_campo = "k171_dataconciliacao_dia";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["k171_dataconciliacao_dia"])) {
                $sql .= $virgula . " k171_dataconciliacao = null ";
                $virgula = ",";
                if (trim($this->k171_dataconciliacao) == null) {
                    $this->erro_sql = " Campo Data não Informado.";
                    $this->erro_campo = "k171_dataconciliacao_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        $sql .= " where ";
        if ($this->k171_conta != null) {
            $sql .= " k171_conta = $this->k171_conta ";
        }
        if ($this->k171_data != null) {
            $sql .= " AND k171_data = '$this->k171_data' ";
        }

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            $resaco = $this->sql_record($this->sql_query_file($this->k171_conta));
            if ($this->numrows > 0) {
                for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac, 0, 0);
                    $resac = db_query("insert into db_acountacesso values($acount, " . db_getsession("DB_acessado") . ")");
                    $resac = db_query("insert into db_acountkey values($acount, 5213, '$this->k171_conta', 'A')");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k171_conta"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5213, '" . AddSlashes(pg_result($resaco, $conresaco, 'k171_conta')) . "', '$this->k171_conta', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k171_saldo"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5214, '" . AddSlashes(pg_result($resaco, $conresaco, 'k171_saldo')) . "', '$this->k171_saldo', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k171_data"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5898, '" . AddSlashes(pg_result($resaco, $conresaco, 'k171_data')) . "', '$this->k171_data', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                }
            }
        }
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Documento Automático Lançamento nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->k171_conta;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            // $this->erro_msg .= "$sql\\n";
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Documento Automático Lançamento nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->k171_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteracao efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->k171_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($k171_conta = null, $dbwhere = null) {
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            if ($dbwhere == null || $dbwhere == "") {
                $resaco = $this->sql_record($this->sql_query_file($k171_conta));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
            }

            if (($resaco != false) || ($this->numrows != 0)) {
                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac, 0, 0);
                    $resac = db_query("insert into db_acountacesso values($acount, ". db_getsession("DB_acessado") . ")");
                    $resac = db_query("insert into db_acountkey values($acount, 5213, '$k171_conta', 'E')");
                    $resac = db_query("insert into db_acount values($acount, 764, 5213, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k171_conta')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount, 764, 5214, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k171_saldo')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k171_data')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                }
            }
        }
        $sql = " delete from conciliacaobancaria where ";
        $sql2 = "";
        if  ($dbwhere == null || $dbwhere == "") {
            if ($this->k171_conta != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k171_conta = $this->k171_conta ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql = "Documento Automático Lançamento nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $k171_conta;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Documento Automático Lançamento nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $k171_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $k171_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao do recordset
    function sql_record($sql) {
        $result = db_query($sql);
        if  ($result == false) {
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
            $this->erro_sql = "Record Vazio na Tabela:conciliacaobancaria";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    function sql_query($k171_conta = null, $campos = "*", $ordem = null, $dbwhere = "") {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = split("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from conciliacaobancaria ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($k171_conta != null) {
                $sql2 .= " where conciliacaobancaria.k171_conta = $k171_conta ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere ";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = split("#",$ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function sql_query_file($k171_conta = null, $campos = "*", $ordem = null, $dbwhere = "") {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = split("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
          }
        } else {
            $sql .= $campos;
        }
        $sql .= " from conciliacaobancaria ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($k171_conta != null) {
                $sql2 .= " where conciliacaobancaria.k171_conta = $k171_conta ";
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
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
}
