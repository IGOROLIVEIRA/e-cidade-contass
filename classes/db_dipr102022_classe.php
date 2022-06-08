<?
//MODULO: sicom
//CLASSE DA ENTIDADE dipr102022
class cl_dipr102022
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
    var $si230_sequencial = 0;
    var $si230_tiporegistro = 0;
    var $si230_coddipr = 0;
    var $si230_segregacaomassa = 0;
    var $si230_benefcustesouro = 0;
    var $si230_atonormativo = 0;
    var $si230_exercicioato = 0;
    var $si230_mes = 0;
    var $si230_instit = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 si230_sequencial = int8 = sequencial 
                 si230_tiporegistro = int8 = Tipo do  registro 
                 si230_coddipr = int8 = Código DIPR
                 si230_segregacaomassa = int8 = Segregação da massa
                 si230_benefcustesouro = int8 = Possui beneficio custeados com recurso do tesouro
                 si230_atonormativo = int8 = Ato normativo
                 si230_exercicioato = int8 = Exercicio ato normativo
                 si230_mes = int8 = Mês 
                 si230_instit = int8 = Instituição 
                 ";

    //funcao construtor da classe
    function cl_dipr102022()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("dipr102022");
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
            $this->si230_sequencial = ($this->si230_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_sequencial"] : $this->si230_sequencial);
            $this->si230_tiporegistro = ($this->si230_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_tiporegistro"] : $this->si230_tiporegistro);
            $this->si230_coddipr = ($this->si230_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_coddipr"] : $this->si230_coddipr);
            $this->si230_segregacaomassa = ($this->si230_segregacaomassa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_segregacaomassa"] : $this->si230_segregacaomassa);
            $this->si230_benefcustesouro = ($this->si230_benefcustesouro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_benefcustesouro"] : $this->si230_benefcustesouro);
            $this->si230_atonormativo = ($this->si230_atonormativo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_atonormativo"] : $this->si230_atonormativo);
            $this->si230_exercicioato = ($this->si230_exercicioato == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_exercicioato"] : $this->si230_exercicioato);
            $this->si230_mes = ($this->si230_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_mes"] : $this->si230_mes);
            $this->si230_instit = ($this->si230_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_instit"] : $this->si230_instit);
        } else {
            $this->si230_sequencial = ($this->si230_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si230_sequencial"] : $this->si230_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si230_sequencial)
    {
        $this->atualizacampos();
        if ($this->si230_atonormativo == null) {
            $this->si230_atonormativo = "0";
        }

        if ($this->si230_exercicioato == null) {
            $this->si230_exercicioato = "0";
        }

        if ($this->si230_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si230_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        if ($si230_sequencial == "" || $si230_sequencial == null) {
            $result = db_query("select nextval('dipr102022_si230_sequencial_seq');");
            if ($result == false) {
                $this->erro_banco = str_replace("", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: dipr102022_si230_sequencial_seq do campo: si230_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
            $this->si230_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from dipr102022_si230_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si230_sequencial)) {
                $this->erro_sql = " Campo si230_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            } else {
                $this->si230_sequencial = $si230_sequencial;
            }
        }
        if (($this->si230_sequencial == null) || ($this->si230_sequencial == "")) {
            $this->erro_sql = " Campo si230_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $sql = "insert into dipr102022(
                    si230_sequencial 
                    ,si230_tiporegistro
                    ,si230_coddipr 
                    ,si230_segregacaomassa 
                    ,si230_benefcustesouro
                    ,si230_atonormativo
                    ,si230_exercicioato
                    ,si230_mes 
                    ,si230_instit )
                values (
                    $this->si230_sequencial 
                    ,$this->si230_tiporegistro 
                    ,$this->si230_coddipr
                    ,$this->si230_segregacaomassa
                    ,$this->si230_benefcustesouro
                    ,$this->si230_atonormativo
                    ,$this->si230_exercicioato
                    ,$this->si230_mes 
                    ,$this->si230_instit )";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "dipr102022 ($this->si230_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "dipr102022 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "dipr102022 ($this->si230_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;

            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si230_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $resaco = $this->sql_record($this->sql_query_file($this->si230_sequencial));
        if (($resaco != false) || ($this->numrows != 0)) {
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac, 0, 0);
            $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
            $resac = db_query("insert into db_acountkey values($acount,2011145,'$this->si230_sequencial','I')");
            $resac = db_query("insert into db_acount values($acount,2010379,2011145,'','" . AddSlashes(pg_result($resaco, 0, 'si230_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010379,2011146,'','" . AddSlashes(pg_result($resaco, 0, 'si230_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010379,2011147,'','" . AddSlashes(pg_result($resaco, 0, 'si230_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010379,2011148,'','" . AddSlashes(pg_result($resaco, 0, 'si230_nroleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010379,2011363,'','" . AddSlashes(pg_result($resaco, 0, 'si230_dtleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010379,2011149,'','" . AddSlashes(pg_result($resaco, 0, 'si230_dtpublicacaoleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010379,2011150,'','" . AddSlashes(pg_result($resaco, 0, 'si230_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010379,2011663,'','" . AddSlashes(pg_result($resaco, 0, 'si230_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }

        return true;
    }

    // funcao para exclusao
    function excluir($si230_sequencial = null, $dbwhere = null)
    {
        if ($dbwhere == null || $dbwhere == "") {
            $resaco = $this->sql_record($this->sql_query_file($si230_sequencial));
        } else {
            $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
        }
  
        $sql = " delete from dipr102022
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si230_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si230_sequencial = $si230_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }

        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "dipr102022 nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $si230_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "dipr102022 nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $si230_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $si230_sequencial;
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
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "Erro ao selecionar os registros.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql = "Record Vazio na Tabela:dipr102022";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        return $result;
    }

    // funcao do sql
    function sql_query($si230_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr102022 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si230_sequencial != null) {
                $sql2 .= " where dipr102022.si230_sequencial = $si230_sequencial ";
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
    function sql_query_file($si230_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr102022 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si230_sequencial != null) {
                $sql2 .= " where dipr102022.si230_sequencial = $si230_sequencial ";
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
}
