<?
//MODULO: sicom
//CLASSE DA ENTIDADE cvc502024
class cl_cvc502024
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
    var $si149_sequencial = 0;
    var $si149_tiporegistro = 0;
    var $si149_codorgao = null;
    var $si149_codveiculo = null;
    var $si149_situacaoveiculoequip = null;
    var $si149_tipobaixa = null;
    var $si149_descbaixa = null;
    var $si149_dtbaixa_dia = null;
    var $si149_dtbaixa_mes = null;
    var $si149_dtbaixa_ano = null;
    var $si149_dtbaixa = null;
    var $si149_mes = 0;
    var $si149_instit = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 si149_sequencial = int8 = sequencial
                 si149_tiporegistro = int8 = Tipo do registro
                 si149_codorgao = varchar(2) = Código do órgão
                 si149_codveiculo = varchar(10) = Código do veículo
                 si149_situacaoveiculoequip = int8 = sistuacao veiculo equip
                 si149_tipobaixa = varchar(2) = Tipo de baixa
                 si149_descbaixa = varchar(50) = Descrição do tipo  de baixa
                 si149_dtbaixa = date = Data de baixa do  veículo
                 si149_mes = int8 = Mês
                 si149_instit = int8 = Instituição
                 ";

    //funcao construtor da classe
    function cl_cvc502024()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("cvc502024");
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
            $this->si149_sequencial = ($this->si149_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_sequencial"] : $this->si149_sequencial);
            $this->si149_tiporegistro = ($this->si149_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_tiporegistro"] : $this->si149_tiporegistro);
            $this->si149_codorgao = ($this->si149_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_codorgao"] : $this->si149_codorgao);
            $this->si149_codveiculo = ($this->si149_codveiculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_codveiculo"] : $this->si149_codveiculo);
            $this->si149_situacaoveiculoequip = ($this->si149_situacaoveiculoequip == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_situacaoveiculoequip"] : $this->si149_situacaoveiculoequip);
            $this->si149_tipobaixa = ($this->si149_tipobaixa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_tipobaixa"] : $this->si149_tipobaixa);
            $this->si149_descbaixa = ($this->si149_descbaixa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_descbaixa"] : $this->si149_descbaixa);
            if ($this->si149_dtbaixa == "") {
                $this->si149_dtbaixa_dia = ($this->si149_dtbaixa_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_dia"] : $this->si149_dtbaixa_dia);
                $this->si149_dtbaixa_mes = ($this->si149_dtbaixa_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_mes"] : $this->si149_dtbaixa_mes);
                $this->si149_dtbaixa_ano = ($this->si149_dtbaixa_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_ano"] : $this->si149_dtbaixa_ano);
                if ($this->si149_dtbaixa_dia != "") {
                    $this->si149_dtbaixa = $this->si149_dtbaixa_ano . "-" . $this->si149_dtbaixa_mes . "-" . $this->si149_dtbaixa_dia;
                }
            }
            $this->si149_mes = ($this->si149_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_mes"] : $this->si149_mes);
            $this->si149_instit = ($this->si149_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_instit"] : $this->si149_instit);
        } else {
            $this->si149_sequencial = ($this->si149_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si149_sequencial"] : $this->si149_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si149_sequencial)
    {
        $this->atualizacampos();
        if ($this->si149_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si149_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($this->si149_dtbaixa == null) {
            $this->si149_dtbaixa = "null";
        }
        if ($this->si149_mes == null) {
            $this->erro_sql = " Campo Mês nao Informado.";
            $this->erro_campo = "si149_mes";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($this->si149_instit == null) {
            $this->erro_sql = " Campo Instituição nao Informado.";
            $this->erro_campo = "si149_instit";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($si149_sequencial == "" || $si149_sequencial == null) {
            $result = db_query("select nextval('cvc502024_si149_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: cvc502024_si149_sequencial_seq do campo: si149_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
            $this->si149_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from cvc502024_si149_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si149_sequencial)) {
                $this->erro_sql = " Campo si149_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            } else {
                $this->si149_sequencial = $si149_sequencial;
            }
        }
        if (($this->si149_sequencial == null) || ($this->si149_sequencial == "")) {
            $this->erro_sql = " Campo si149_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $sql = "insert into cvc502024(
                                       si149_sequencial
                                      ,si149_tiporegistro
                                      ,si149_codorgao
                                      ,si149_codveiculo
                                      ,si149_situacaoveiculoequip
                                      ,si149_tipobaixa
                                      ,si149_descbaixa
                                      ,si149_dtbaixa
                                      ,si149_mes
                                      ,si149_instit
                       )
                values (
                                $this->si149_sequencial
                               ,$this->si149_tiporegistro
                               ,'$this->si149_codorgao'
                               ,'$this->si149_codveiculo'
                               ,$this->si149_situacaoveiculoequip
                               ,'$this->si149_tipobaixa'
                               ,'$this->si149_descbaixa'
                               ," . ($this->si149_dtbaixa == "null" || $this->si149_dtbaixa == "" ? "null" : "'" . $this->si149_dtbaixa . "'") . "
                               ,$this->si149_mes
                               ,$this->si149_instit
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "cvc502024 ($this->si149_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "cvc502024 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "cvc502024 ($this->si149_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;

            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si149_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    // funcao para alteracao
    function alterar($si149_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update cvc502024 set ";
        $virgula = "";
        if (trim($this->si149_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_sequencial"])) {
            if (trim($this->si149_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si149_sequencial"])) {
                $this->si149_sequencial = "0";
            }
            $sql .= $virgula . " si149_sequencial = $this->si149_sequencial ";
            $virgula = ",";
        }
        if (trim($this->si149_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_tiporegistro"])) {
            $sql .= $virgula . " si149_tiporegistro = $this->si149_tiporegistro ";
            $virgula = ",";
            if (trim($this->si149_tiporegistro) == null) {
                $this->erro_sql = " Campo Tipo do registro nao Informado.";
                $this->erro_campo = "si149_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        if (trim($this->si149_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_codorgao"])) {
            $sql .= $virgula . " si149_codorgao = '$this->si149_codorgao' ";
            $virgula = ",";
        }
        if (trim($this->si149_codveiculo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_codveiculo"])) {
            $sql .= $virgula . " si149_codveiculo = '$this->si149_codveiculo' ";
            $virgula = ",";
        }
        if (trim($this->si149_tipobaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_tipobaixa"])) {
            $sql .= $virgula . " si149_tipobaixa = '$this->si149_tipobaixa' ";
            $virgula = ",";
        }
        if (trim($this->si149_descbaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_descbaixa"])) {
            $sql .= $virgula . " si149_descbaixa = '$this->si149_descbaixa' ";
            $virgula = ",";
        }
        if (trim($this->si149_dtbaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_dia"] != "")) {
            $sql .= $virgula . " si149_dtbaixa = '$this->si149_dtbaixa' ";
            $virgula = ",";
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_dia"])) {
                $sql .= $virgula . " si149_dtbaixa = null ";
                $virgula = ",";
            }
        }
        if (trim($this->si149_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_mes"])) {
            $sql .= $virgula . " si149_mes = $this->si149_mes ";
            $virgula = ",";
            if (trim($this->si149_mes) == null) {
                $this->erro_sql = " Campo Mês nao Informado.";
                $this->erro_campo = "si149_mes";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        if (trim($this->si149_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_instit"])) {
            $sql .= $virgula . " si149_instit = $this->si149_instit ";
            $virgula = ",";
            if (trim($this->si149_instit) == null) {
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "si149_instit";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        $sql .= " where ";
        if ($si149_sequencial != null) {
            $sql .= " si149_sequencial = $this->si149_sequencial";
        }

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("
", "", @pg_last_error());
            $this->erro_sql = "cvc502024 nao Alterado. Alteracao Abortada.\n";
            $this->erro_sql .= "Valores : " . $this->si149_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "cvc502024 nao foi Alterado. Alteracao Executada.\n";
                $this->erro_sql .= "Valores : " . $this->si149_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $this->si149_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);

                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($si149_sequencial = null, $dbwhere = null)
    {
        $sql = " delete from cvc502024
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si149_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si149_sequencial = $si149_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("
", "", @pg_last_error());
            $this->erro_sql = "cvc502024 nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $si149_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "cvc502024 nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $si149_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $si149_sequencial;
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
            $this->erro_sql = "Record Vazio na Tabela:cvc502024";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        return $result;
    }

    // funcao do sql
    function sql_query($si149_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from cvc502024 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si149_sequencial != null) {
                $sql2 .= " where cvc502024.si149_sequencial = $si149_sequencial ";
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
    function sql_query_file($si149_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from cvc502024 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si149_sequencial != null) {
                $sql2 .= " where cvc502024.si149_sequencial = $si149_sequencial ";
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
