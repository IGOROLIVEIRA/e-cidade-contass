<?php
//MODULO: empenho
//CLASSE DA ENTIDADE fornemensalemp
class cl_fornemensalemp
{
    // cria variaveis de erro
    public $rotulo = null;
    public $query_sql = null;
    public $numrows = 0;
    public $numrows_incluir = 0;
    public $numrows_alterar = 0;
    public $numrows_excluir = 0;
    public $erro_status = null;
    public $erro_sql = null;
    public $erro_banco = null;
    public $erro_msg = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    // cria variaveis do arquivo
    public $fm101_sequencial = 0;
    public $fm101_numcgm = 0;
    public $fm101_datafim_dia = null;
    public $fm101_datafim_mes = null;
    public $fm101_datafim_ano = null;
    public $fm101_datafim = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 fm101_sequencial = int4 = Seq. Fornecedores Mensais Empenhos
                 fm101_numcgm = int4 = Numcgm fornecedores mensais de empenhos
                 fm101_datafim = date = Data Final forn. mensais de empenhos
                 ";

    //funcao construtor da classe
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("fornemensalemp");
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

    function incluir()
    {
        $this->atualizacampos();
        if ($this->fm101_numcgm == null) {
            $this->erro_sql = " Campo Numcgm fornecedores mensais de empenhos não informado.";
            $this->erro_campo = "fm101_numcgm";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($fm101_sequencial == "" || $fm101_sequencial == null) {
            $result = db_query("select nextval('fornemensalemp_fm101_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: fornemensalemp_fm101_sequencial_seq do campo: fm101_sequencial";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->fm101_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from fornemensalemp_fm101_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $fm101_sequencial)) {
                $this->erro_sql = " Campo fm101_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->fm101_sequencial = $fm101_sequencial;
            }
        }

        $sql = "insert into fornemensalemp(
                                       fm101_sequencial
                                      ,fm101_numcgm
                                      ,fm101_datafim
                       )
                values (
                                $this->fm101_sequencial
                               ,$this->fm101_numcgm
                               ," . ($this->fm101_datafim == "null" || $this->fm101_datafim == "" ? "null" : "'" . $this->fm101_datafim . "'") . "
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "Fornecedores Mensais de Empenhos () nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Fornecedores Mensais de Empenhos já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql = "Fornecedores Mensais de Empenhos () nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg = "Usuário: \\n" . $this->erro_sql . " \\n";
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

        }
        return true;
    }

    // funcao para inclusao

    function atualizacampos($exclusao = false)
    {
        if ($exclusao == false) {
            $this->fm101_sequencial = ($this->fm101_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["fm101_sequencial"] : $this->fm101_sequencial);
            $this->fm101_numcgm = ($this->fm101_numcgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["fm101_numcgm"] : $this->fm101_numcgm);
            if ($this->fm101_datafim == "") {
                $this->fm101_datafim_dia = ($this->fm101_datafim_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["fm101_datafim_dia"] : $this->fm101_datafim_dia);
                $this->fm101_datafim_mes = ($this->fm101_datafim_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["fm101_datafim_mes"] : $this->fm101_datafim_mes);
                $this->fm101_datafim_ano = ($this->fm101_datafim_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["fm101_datafim_ano"] : $this->fm101_datafim_ano);
                if ($this->fm101_datafim_dia != "") {
                    $this->fm101_datafim = $this->fm101_datafim_ano . "-" . $this->fm101_datafim_mes . "-" . $this->fm101_datafim_dia;
                }
            }
        } else {
        }
    }

    // funcao para alteracao

    function alterar($where = null)
    {
        $this->atualizacampos();
        $sql = " update fornemensalemp set ";
        $virgula = "";
        if (trim($this->fm101_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["fm101_sequencial"])) {
            $sql .= $virgula . " fm101_sequencial = $this->fm101_sequencial ";
            $virgula = ",";
            if (trim($this->fm101_sequencial) == null) {
                $this->erro_sql = " Campo Seq. Fornecedores Mensais Empenhos não informado.";
                $this->erro_campo = "fm101_sequencial";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->fm101_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["fm101_numcgm"])) {
            $sql .= $virgula . " fm101_numcgm = $this->fm101_numcgm ";
            $virgula = ",";
            if (trim($this->fm101_numcgm) == null) {
                $this->erro_sql = " Campo Numcgm fornecedores mensais de empenhos não informado.";
                $this->erro_campo = "fm101_numcgm";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->fm101_datafim) != "" || isset($GLOBALS["HTTP_POST_VARS"]["fm101_datafim_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["fm101_datafim_dia"] != "")) {
            $sql .= $virgula . " fm101_datafim = '$this->fm101_datafim' ";
            $virgula = ",";
            // if (trim($this->fm101_datafim) == null) {
            //     $this->erro_sql = " Campo Data Final forn. mensais de empenhos não informado.";
            //     $this->erro_campo = "fm101_datafim_dia";
            //     $this->erro_banco = "";
            //     $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            //     $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            //     $this->erro_status = "0";
            //     return false;
            // }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["fm101_datafim_dia"])) {
                $sql .= $virgula . " fm101_datafim = null ";
                $virgula = ",";
                // if (trim($this->fm101_datafim) == null) {
                //     $this->erro_sql = " Campo Data Final forn. mensais de empenhos não informado.";
                //     $this->erro_campo = "fm101_datafim_dia";
                //     $this->erro_banco = "";
                //     $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                //     $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                //     $this->erro_status = "0";
                //     return false;
                // }
            }
        }
        $sql .= " where " . $where;
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Fornecedores Mensais de Empenhos nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Fornecedores Mensais de Empenhos nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($dbwhere = null)
    {

        $sql = " delete from fornemensalemp
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "oid = '$oid'";
        } else {
            $sql2 = $dbwhere;
        }
        
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Fornecedores Mensais nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Fornecedores Mensais nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
            $this->erro_sql = "Record Vazio na Tabela:fornemensalemp";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($fm101_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from fornemensalemp ";
        $sql .= " JOIN cgm ON z01_numcgm = fm101_numcgm";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($fm101_sequencial != "" && $fm101_sequencial != null) {
                $sql2 = " where fm101_sequencial = $fm101_sequencial";
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
        // echo $sql;exit;
        return $sql;
    }

    // funcao do sql
    function sql_query_file($campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from fornemensalemp ";
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

    function sqlNotasFiscais($numcgm = null, $campo = "", $order = null, $where = "", $tipo = null, $sCredoresSelecionados = null)
    {
        $sQueryNotas = "SELECT DISTINCT ";

        if ($campo == "" && $tipo == 1){
            $sQueryNotas .= "fm101_numcgm,fm101_sequencial,z01_nome,sum(e70_valor) as e70_valor";
        }
        if ($campo == "" && $tipo == 2){
            $sQueryNotas .= "
            e69_dtnota,
            e60_numemp,
            e60_emiss,
            fm101_numcgm,
            fm101_sequencial,
            z01_nome,
            e69_numero,
            e60_codemp,
            sum(e70_valor) as e70_valor";
        }
        if ($tipo == 1) {
            $sQueryNotas .= " FROM fornemensalemp
                        LEFT join empempenho on e60_numcgm = fm101_numcgm
                        LEFT join cgm on cgm.z01_numcgm = empempenho.e60_numcgm or cgm.z01_numcgm = fm101_numcgm
                        LEFT join empnota on empempenho.e60_numemp = empnota.e69_numemp
                        LEFT join empnotaele on e69_codnota = e70_codnota
                        LEFT join pagordemnota on e71_codnota = empnota.e69_codnota  and e71_anulado is false
                        LEFT join pagordem on e71_codord = e50_codord
                        LEFT join pagordemele on e53_codord = pagordemnota.e71_codord";    
        }
        if ($tipo == 2) {
            $sQueryNotas .= " FROM fornemensalemp
                          INNER JOIN  empempenho ON e60_numcgm = fm101_numcgm
                          INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
                          LEFT JOIN empnota ON empempenho.e60_numemp = empnota.e69_numemp
                          LEFT JOIN  empnotaele ON e69_codnota = e70_codnota
                          LEFT JOIN pagordemnota ON e71_codnota = empnota.e69_codnota AND e71_anulado IS FALSE
                          LEFT JOIN pagordem ON e71_codord = e50_codord
                          LEFT JOIN pagordemele ON e53_codord = pagordemnota.e71_codord ";
        }                  
        if($tipo == 1 && !$sCredoresSelecionados){
            $dataFinal = substr($where,44,10);
            $where.= " or (e60_numemp is null and fm101_datafim is null) or ( e70_valor is null and fm101_datafim >= '$dataFinal') ";
        }
        if ($where) {
            $sQueryNotas .= $where;
        }
        if ($sCredoresSelecionados) {
            $sQueryNotas .= " and fm101_numcgm in ($sCredoresSelecionados)";
        }
        if ($tipo == 1) {
            $sQueryNotas .= " GROUP BY 1,2,3 ";
            $sQueryNotas .= " order by z01_nome  ";
        }
        if ($tipo == 2) {
            $sQueryNotas .= " GROUP BY 1,2,3,4,5,6,7 ";
            $sQueryNotas .= " order by z01_nome,fm101_numcgm,e60_numemp  "; 
        }
        // echo $sQueryNotas;exit;
        return $sQueryNotas;
    }

    function validaDatas($dataInicial, $dataFinal)
    {
        if (isset($dataInicial) && empty($dataFinal)){
            $filtroData = " WHERE e69_dtnota >= '$dataInicial' ";
        }elseif (isset($dataFinal) && empty($dataInicial)){
            $filtroData = " WHERE e69_dtnota <= '$dataFinal' ";
        }else {
            $filtroData = " WHERE e69_dtnota BETWEEN '$dataInicial' AND '$dataFinal' and (fm101_datafim is null or fm101_datafim >= '$dataInicial') ";
        }

        return $filtroData;
    }
}
