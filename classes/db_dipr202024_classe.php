<?
//MODULO: sicom
//CLASSE DA ENTIDADE dipr202024
class cl_dipr202024
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
    var $si231_sequencial = 0;
    var $si231_tiporegistro = 0;
    var $si231_segregacaomassa = 0;
    var $si231_benefcustesouro = 0;
    var $si231_atonormativo = 0;
    var $si231_exercicioato = 0;
    var $si231_mes = 0;
    var $si231_instit = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        si231_sequencial = Sequencial,
        si231_tiporegistro = Tipo de Registro
        si231_codorgao = Codigo do Orgao
        si231_tipobasecalculo = Tipo Base de Calculo
        si231_mescompetencia = Mes Competencia
        si231_exerciciocompetencia = Exercicio Mes Competencia
        si231_tipofundo = Tipo de Fundo
        si231_remuneracaobrutafolhapag = Remuneracao Bruta
        si231_tipobasecalculocontrprevidencia = Tipo de Base de Calculo Previdencia
        si231_tipobasecalculocontrseg = Tipo de Base de Calculo Seg
        si231_valorbasecalculocontr = Valor da Base de Calculo
        si231_tipocontribuicao = Tipo de Contribuicao
        si231_aliquota = Aliquota
        si231_valorcontribdevida = Valor da Contribuicao
        si231_mes = Mes
        si231_instit = Instituicao
    ";

    //funcao construtor da classe
    function cl_dipr202024()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("dipr202024");
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
            $this->si231_sequencial = ($this->si231_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_sequencial"] : $this->si231_sequencial);
            $this->si231_tiporegistro = ($this->si231_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_tiporegistro"] : $this->si231_tiporegistro);
            $this->si231_codorgao = ($this->si231_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_codorgao"] : $this->si231_codorgao);
            $this->si231_tipobasecalculo = ($this->si231_tipobasecalculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_tipobasecalculo"] : $this->si231_tipobasecalculo);
            $this->si231_mescompetencia = ($this->si231_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_mescompetencia"] : $this->si231_mescompetencia);
            $this->si231_exerciciocompetencia = ($this->si231_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_exerciciocompetencia"] : $this->si231_exerciciocompetencia);
            $this->si231_tipofundo = ($this->si231_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_tipofundo"] : $this->si231_tipofundo);
            $this->si231_remuneracaobrutafolhapag = ($this->si231_remuneracaobrutafolhapag == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_remuneracaobrutafolhapag"] : $this->si231_remuneracaobrutafolhapag);
            $this->si231_tipobasecalculocontrprevidencia = ($this->si231_tipobasecalculocontrprevidencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_tipobasecalculocontrprevidencia"] : $this->si231_tipobasecalculocontrprevidencia);
            $this->si231_tipobasecalculocontrseg = ($this->si231_tipobasecalculocontrseg == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_tipobasecalculocontrseg"] : $this->si231_tipobasecalculocontrseg);
            $this->si231_valorbasecalculocontr = ($this->si231_valorbasecalculocontr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_valorbasecalculocontr"] : $this->si231_valorbasecalculocontr);
            $this->si231_tipocontribuicao = ($this->si231_tipocontribuicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_tipocontribuicao"] : $this->si231_tipocontribuicao);
            $this->si231_aliquota = ($this->si231_aliquota == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_aliquota"] : $this->si231_aliquota);
            $this->si231_valorcontribdevida = ($this->si231_valorcontribdevida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_valorcontribdevida"] : $this->si231_valorcontribdevida);
            $this->si231_mes = ($this->si231_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_mes"] : $this->si231_mes);
            $this->si231_instit = ($this->si231_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_instit"] : $this->si231_instit);
        } else {
            $this->si231_sequencial = ($this->si231_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si231_sequencial"] : $this->si231_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si231_sequencial)
    {
        $this->atualizacampos();

        if ($this->si231_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si231_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        if ($si231_sequencial == "" || $si231_sequencial == null) {
            $result = db_query("select nextval('dipr202024_si231_sequencial_seq');");
            if ($result == false) {
                $this->erro_banco = str_replace("", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: dipr202024_si231_sequencial_seq do campo: si231_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
            $this->si231_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from dipr202024_si231_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si231_sequencial)) {
                $this->erro_sql = " Campo si231_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            } else {
                $this->si231_sequencial = $si231_sequencial;
            }
        }
        if (($this->si231_sequencial == null) || ($this->si231_sequencial == "")) {
            $this->erro_sql = " Campo si231_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $sql = "insert into dipr202024(
                    si231_sequencial
                    ,si231_tiporegistro
                    ,si231_codorgao
                    ,si231_tipobasecalculo
                    ,si231_mescompetencia
                    ,si231_exerciciocompetencia
                    ,si231_tipofundo
                    ,si231_remuneracaobrutafolhapag
                    ,si231_tipobasecalculocontrprevidencia
                    ,si231_tipobasecalculocontrseg
                    ,si231_valorbasecalculocontr
                    ,si231_tipocontribuicao
                    ,si231_aliquota
                    ,si231_valorcontribdevida
                    ,si231_mes
                    ,si231_instit )
                values (
                    $this->si231_sequencial
                    ,$this->si231_tiporegistro
                    ,$this->si231_codorgao
                    ,$this->si231_tipobasecalculo
                    ,$this->si231_mescompetencia
                    ,$this->si231_exerciciocompetencia
                    ,$this->si231_tipofundo
                    ,$this->si231_remuneracaobrutafolhapag
                    ,$this->si231_tipobasecalculocontrprevidencia
                    ,$this->si231_tipobasecalculocontrseg
                    ,$this->si231_valorbasecalculocontr
                    ,$this->si231_tipocontribuicao
                    ,$this->si231_aliquota
                    ,$this->si231_valorcontribdevida
                    ,$this->si231_mes
                    ,$this->si231_instit )";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "dipr202024 ($this->si231_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "dipr202024 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "dipr202024 ($this->si231_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;

            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si231_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);

        return true;
    }

    // funcao para exclusao
    function excluir($si231_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from dipr202024
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si231_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si231_sequencial = $si231_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);

        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "dipr202024 nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $si231_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "dipr202024 nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $si231_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $si231_sequencial;
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
            $this->erro_sql = "Record Vazio na Tabela:dipr202024";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        return $result;
    }

    // funcao do sql
    function sql_query($si231_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr202024 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si231_sequencial != null) {
                $sql2 .= " where dipr202024.si231_sequencial = $si231_sequencial ";
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
    function sql_query_file($si231_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr202024 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si231_sequencial != null) {
                $sql2 .= " where dipr202024.si231_sequencial = $si231_sequencial ";
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
