<?
//MODULO: sicom
//CLASSE DA ENTIDADE dipr502022
class cl_dipr502022
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
    var $si234_sequencial = 0;
    var $si234_tiporegistro = 0;
    var $si234_coddipr = 0;
    var $si234_segregacaomassa = 0;
    var $si234_benefcustesouro = 0;
    var $si234_atonormativo = 0;
    var $si234_exercicioato = 0;
    var $si234_mes = 0;
    var $si234_instit = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        si234_sequencial = Sequencial,
        si234_tiporegistro = Tipo de Registro
        si234_codorgao = Codigo do Orgao
        si234_coddipr = Codigo DIPR
        si234_tipobasecalculo = Tipo Base de Calculo
        si234_mescompetencia = Mes Competencia
        si234_exerciciocompetencia = Exercicio Mes Competencia
        si234_tipofundo = Tipo de Fundo
        si234_remuneracaobrutafolhapag = Remuneracao Bruta
        si234_tipobasecalculocontrprevidencia = Tipo de Base de Calculo Previdencia
        si234_tipobasecalculocontrseg = Tipo de Base de Calculo Seg
        si234_valorbasecalculocontr = Valor da Base de Calculo
        si234_tipocontribuicao = Tipo de Contribuicao
        si234_aliquota = Aliquota
        si234_valorcontribdevida = Valor da Contribuicao
        si234_mes = Mes
        si234_instit = Instituicao
    ";

    //funcao construtor da classe
    function cl_dipr502022()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("dipr502022");
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
            $this->si234_sequencial = ($this->si234_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_sequencial"] : $this->si234_sequencial);
            $this->si234_tiporegistro = ($this->si234_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_tiporegistro"] : $this->si234_tiporegistro);
            $this->si234_codorgao = ($this->si234_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_codorgao"] : $this->si234_codorgao);
            $this->si234_coddipr = ($this->si234_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_coddipr"] : $this->si234_coddipr);
            $this->si234_mescompetencia = ($this->si234_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_mescompetencia"] : $this->si234_mescompetencia);
            $this->si234_exerciciocompetencia = ($this->si234_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_exerciciocompetencia"] : $this->si234_exerciciocompetencia);
            $this->si234_tipofundo = ($this->si234_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_tipofundo"] : $this->si234_tipofundo);
            $this->si234_tipoaportetransf = ($this->si234_tipoaportetransf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_tipoaportetransf"] : $this->si234_tipoaportetransf);
            $this->si234_dscoutrosaportestransf = ($this->si234_dscoutrosaportestransf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_dscoutrosaportestransf"] : $this->si234_dscoutrosaportestransf);
            $this->si234_atonormativo = ($this->si234_atonormativo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_atonormativo"] : $this->si234_atonormativo);
            $this->si234_exercicioato = ($this->si234_exercicioato == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_exercicioato"] : $this->si234_exercicioato);
            $this->si234_valoraportetransf = ($this->si234_valoraportetransf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_valoraportetransf"] : $this->si234_valoraportetransf);
            $this->si234_mes = ($this->si234_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_mes"] : $this->si234_mes);
            $this->si234_instit = ($this->si234_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_instit"] : $this->si234_instit);
        } else {
            $this->si234_sequencial = ($this->si234_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si234_sequencial"] : $this->si234_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si234_sequencial)
    {
        $this->atualizacampos();

        if ($this->si234_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si234_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        if ($si234_sequencial == "" || $si234_sequencial == null) {
            $result = db_query("select nextval('dipr502022_si234_sequencial_seq');");
            if ($result == false) {
                $this->erro_banco = str_replace("", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: dipr502022_si234_sequencial_seq do campo: si234_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
            $this->si234_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from dipr502022_si234_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si234_sequencial)) {
                $this->erro_sql = " Campo si234_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            } else {
                $this->si234_sequencial = $si234_sequencial;
            }
        }
        if (($this->si234_sequencial == null) || ($this->si234_sequencial == "")) {
            $this->erro_sql = " Campo si234_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $sql = "insert into dipr502022(
                    si234_sequencial 
                    ,si234_tiporegistro
                    ,si234_codorgao
                    ,si234_coddipr 
                    ,si234_mescompetencia
                    ,si234_exerciciocompetencia
                    ,si234_tipofundo
                    ,si234_tipoaportetransf
                    ,si234_dscoutrosaportestransf
                    ,si234_atonormativo
                    ,si234_exercicioato
                    ,si234_valoraportetransf
                    ,si234_mes 
                    ,si234_instit )
                values (
                    $this->si234_sequencial 
                    ,$this->si234_tiporegistro
                    ,$this->si234_codorgao
                    ,$this->si234_coddipr 
                    ,$this->si234_mescompetencia
                    ,$this->si234_exerciciocompetencia
                    ,$this->si234_tipofundo
                    ,$this->si234_tipoaportetransf
                    ,'$this->si234_dscoutrosaportestransf'
                    ,$this->si234_atonormativo
                    ,$this->si234_exercicioato
                    ,$this->si234_valoraportetransf
                    ,$this->si234_mes 
                    ,$this->si234_instit )";
                 
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "dipr502022 ($this->si234_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "dipr502022 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "dipr502022 ($this->si234_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;

            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si234_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
     
        return true;
    }

    // funcao para exclusao
    function excluir($si234_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from dipr502022
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si234_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si234_sequencial = $si234_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);

        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "dipr502022 nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $si234_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "dipr502022 nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $si234_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $si234_sequencial;
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
            $this->erro_sql = "Record Vazio na Tabela:dipr502022";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        return $result;
    }

    // funcao do sql
    function sql_query($si234_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr502022 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si234_sequencial != null) {
                $sql2 .= " where dipr502022.si234_sequencial = $si234_sequencial ";
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
    function sql_query_file($si234_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from dipr502022 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si234_sequencial != null) {
                $sql2 .= " where dipr502022.si234_sequencial = $si234_sequencial ";
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
