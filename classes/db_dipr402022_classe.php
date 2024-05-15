<?
//MODULO: sicom
//CLASSE DA ENTIDADE dipr402022
class cl_dipr402022
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
    var $si233_sequencial = 0;
    var $si233_tiporegistro = 0;
    var $si233_coddipr = 0;
    var $si233_segregacaomassa = 0;
    var $si233_benefcustesouro = 0;
    var $si233_atonormativo = 0;
    var $si233_exercicioato = 0;
    var $si233_mes = 0;
    var $si233_instit = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        si233_sequencial = Sequencial,
        si233_tiporegistro = Tipo de Registro
        si233_codorgao = Codigo do Orgao
        si233_coddipr = Codigo DIPR
        si233_tipobasecalculo = Tipo Base de Calculo
        si233_mescompetencia = Mes Competencia
        si233_exerciciocompetencia = Exercicio Mes Competencia
        si233_tipofundo = Tipo de Fundo
        si233_remuneracaobrutafolhapag = Remuneracao Bruta
        si233_tipobasecalculocontrprevidencia = Tipo de Base de Calculo Previdencia
        si233_tipobasecalculocontrseg = Tipo de Base de Calculo Seg
        si233_valorbasecalculocontr = Valor da Base de Calculo
        si233_tipocontribuicao = Tipo de Contribuicao
        si233_aliquota = Aliquota
        si233_valorcontribdevida = Valor da Contribuicao
        si233_mes = Mes
        si233_instit = Instituicao
    ";

    //funcao construtor da classe
    function cl_dipr402022()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("dipr402022");
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
            $this->si233_sequencial = ($this->si233_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_sequencial"] : $this->si233_sequencial);
            $this->si233_tiporegistro = ($this->si233_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_tiporegistro"] : $this->si233_tiporegistro);
            $this->si233_codorgao = ($this->si233_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_codorgao"] : $this->si233_codorgao);
            $this->si233_coddipr = ($this->si233_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_coddipr"] : $this->si233_coddipr);
            $this->si233_mescompetencia = ($this->si233_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_mescompetencia"] : $this->si233_mescompetencia);
            $this->si233_exerciciocompetencia = ($this->si233_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_exerciciocompetencia"] : $this->si233_exerciciocompetencia);
            $this->si233_tipofundo = ($this->si233_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_tipofundo"] : $this->si233_tipofundo);
            $this->si233_tiporepasse = ($this->si233_tiporepasse == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_tiporepasse"] : $this->si233_tiporepasse);
            $this->si233_tipocontripatronal = ($this->si233_tipocontripatronal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_tipocontripatronal"] : $this->si233_tipocontripatronal);
            $this->si233_tipocontrisegurado = ($this->si233_tipocontrisegurado == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_tipocontrisegurado"] : $this->si233_tipocontrisegurado);
            $this->si233_tipocontribuicao = ($this->si233_tipocontribuicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_tipocontribuicao"] : $this->si233_tipocontribuicao);
            $this->si233_tipodeducao = ($this->si233_tipodeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_tipodeducao"] : $this->si233_tipodeducao);$this->si233_dsctiposdeducoes = ($this->si233_dsctiposdeducoes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_dsctiposdeducoes"] : $this->si233_dsctiposdeducoes);
            $this->si233_valordeducao = ($this->si233_valordeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_valordeducao"] : $this->si233_valordeducao);
            $this->si233_mes = ($this->si233_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_mes"] : $this->si233_mes);
            $this->si233_instit = ($this->si233_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_instit"] : $this->si233_instit);
        } else {
            $this->si233_sequencial = ($this->si233_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si233_sequencial"] : $this->si233_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si233_sequencial)
    {
        $this->atualizacampos();

        if ($this->si233_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si233_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        if ($si233_sequencial == "" || $si233_sequencial == null) {
            $result = db_query("select nextval('dipr402022_si233_sequencial_seq');");
            if ($result == false) {
                $this->erro_banco = str_replace("", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: dipr402022_si233_sequencial_seq do campo: si233_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
            $this->si233_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from dipr402022_si233_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si233_sequencial)) {
                $this->erro_sql = " Campo si233_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            } else {
                $this->si233_sequencial = $si233_sequencial;
            }
        }
        if (($this->si233_sequencial == null) || ($this->si233_sequencial == "")) {
            $this->erro_sql = " Campo si233_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $sql = "insert into dipr402022(
                    si233_sequencial 
                    ,si233_tiporegistro
                    ,si233_codorgao
                    ,si233_coddipr 
                    ,si233_mescompetencia
                    ,si233_exerciciocompetencia
                    ,si233_tipofundo
                    ,si233_tiporepasse
                    ,si233_tipocontripatronal
                    ,si233_tipocontrisegurado
                    ,si233_tipocontribuicao
                    ,si233_tipodeducao
                    ,si233_dsctiposdeducoes
                    ,si233_valordeducao
                    ,si233_mes 
                    ,si233_instit )
                values (
                    $this->si233_sequencial 
                    ,$this->si233_tiporegistro
                    ,$this->si233_codorgao
                    ,$this->si233_coddipr 
                    ,$this->si233_mescompetencia
                    ,$this->si233_exerciciocompetencia
                    ,$this->si233_tipofundo
                    ,$this->si233_tiporepasse
                    ,$this->si233_tipocontripatronal
                    ,$this->si233_tipocontrisegurado
                    ,$this->si233_tipocontribuicao
                    ,$this->si233_tipodeducao
                    ,'$this->si233_dsctiposdeducoes'
                    ,$this->si233_valordeducao
                    ,$this->si233_mes 
                    ,$this->si233_instit )";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "dipr402022 ($this->si233_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "dipr402022 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "dipr402022 ($this->si233_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;

            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si233_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
     
        return true;
    }

    // funcao para exclusao
    function excluir($si233_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from dipr402022
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si233_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si233_sequencial = $si233_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);

        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "dipr402022 nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $si233_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "dipr402022 nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $si233_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $si233_sequencial;
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
            $this->erro_sql = "Record Vazio na Tabela:dipr402022";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        return $result;
    }

    // funcao do sql
    function sql_query($si233_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr402022 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si233_sequencial != null) {
                $sql2 .= " where dipr402022.si233_sequencial = $si233_sequencial ";
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
    function sql_query_file($si233_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr402022 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si233_sequencial != null) {
                $sql2 .= " where dipr402022.si233_sequencial = $si233_sequencial ";
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
