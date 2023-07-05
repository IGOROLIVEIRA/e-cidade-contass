<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE anexocomprapncp
class cl_anexocomprapncp
{
    // cria variaveis de erro 
    public $rotulo     = null;
    public $query_sql  = null;
    public $numrows    = 0;
    public $numrows_incluir = 0;
    public $numrows_alterar = 0;
    public $numrows_excluir = 0;
    public $erro_status = null;
    public $erro_sql   = null;
    public $erro_banco = null;
    public $erro_msg   = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    // cria variaveis do arquivo 
    public $l216_sequencial = 0;
    public $l216_codproc = 0;
    public $l216_dataanexo_dia = null;
    public $l216_dataanexo_mes = null;
    public $l216_dataanexo_ano = null;
    public $l216_dataanexo = null;
    public $l216_id_usuario = 0;
    public $l216_hora = null;
    public $l216_instit = 0;
    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 l216_sequencial = int8 = l216_sequencial 
                 l216_codproc = int8 = l216_codproc 
                 l216_dataanexo = date = l216_dataanexo 
                 l216_id_usuario = int8 = l216_id_usuario 
                 l216_hora = varchar(5) = l216_hora 
                 l216_instit = int8 = l216_instit 
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("anexocomprapncp");
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
            $this->l216_sequencial = ($this->l216_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_sequencial"] : $this->l216_sequencial);
            $this->l216_codproc = ($this->l216_codproc == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_codproc"] : $this->l216_codproc);
            if ($this->l216_dataanexo == "") {
                $this->l216_dataanexo_dia = ($this->l216_dataanexo_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_dataanexo_dia"] : $this->l216_dataanexo_dia);
                $this->l216_dataanexo_mes = ($this->l216_dataanexo_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_dataanexo_mes"] : $this->l216_dataanexo_mes);
                $this->l216_dataanexo_ano = ($this->l216_dataanexo_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_dataanexo_ano"] : $this->l216_dataanexo_ano);
                if ($this->l216_dataanexo_dia != "") {
                    $this->l216_dataanexo = $this->l216_dataanexo_ano . "-" . $this->l216_dataanexo_mes . "-" . $this->l216_dataanexo_dia;
                }
            }
            $this->l216_id_usuario = ($this->l216_id_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_id_usuario"] : $this->l216_id_usuario);
            $this->l216_hora = ($this->l216_hora == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_hora"] : $this->l216_hora);
            $this->l216_instit = ($this->l216_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l216_instit"] : $this->l216_instit);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();

        if ($this->l216_codproc == null) {
            $this->erro_sql = " Campo l216_codproc não informado.";
            $this->erro_campo = "l216_codproc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l216_dataanexo == null) {
            $this->erro_sql = " Campo l216_dataanexo não informado.";
            $this->erro_campo = "l216_dataanexo_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l216_id_usuario == null) {
            $this->erro_sql = " Campo l216_id_usuario não informado.";
            $this->erro_campo = "l216_id_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l216_hora == null) {
            $this->erro_sql = " Campo l216_hora não informado.";
            $this->erro_campo = "l216_hora";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l216_instit == null) {
            $this->erro_sql = " Campo l216_instit não informado.";
            $this->erro_campo = "l216_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l216_sequencial == "" || $this->l216_sequencial == null) {
            $result = db_query("select nextval('anexocomprapncp_l216_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: anexocomprapncp_l216_sequencial_seq do campo: l216_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l216_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from anexocomprapncp_l216_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->l216_sequencial)) {
                $this->erro_sql = " Campo l216_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->l216_sequencial = $this->l216_sequencial;
            }
        }
        if (($this->l216_sequencial == null) || ($this->l216_sequencial == "")) {
            $this->erro_sql = " Campo l216_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into anexocomprapncp(
                                       l216_sequencial 
                                      ,l216_codproc 
                                      ,l216_dataanexo 
                                      ,l216_id_usuario 
                                      ,l216_hora 
                                      ,l216_instit 
                       )
                values (
                                $this->l216_sequencial 
                               ,$this->l216_codproc 
                               ," . ($this->l216_dataanexo == "null" || $this->l216_dataanexo == "" ? "null" : "'" . $this->l216_dataanexo . "'") . " 
                               ,$this->l216_id_usuario 
                               ,'$this->l216_hora' 
                               ,$this->l216_instit 
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "anexocomprapncp () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "anexocomprapncp já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "anexocomprapncp () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {
        }
        return true;
    }

    // funcao para alteracao
    function alterar($oid = null)
    {
        $this->atualizacampos();
        $sql = " update anexocomprapncp set ";
        $virgula = "";
        if (trim($this->l216_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l216_sequencial"])) {
            $sql  .= $virgula . " l216_sequencial = $this->l216_sequencial ";
            $virgula = ",";
            if (trim($this->l216_sequencial) == null) {
                $this->erro_sql = " Campo l216_sequencial não informado.";
                $this->erro_campo = "l216_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l216_codproc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l216_codproc"])) {
            $sql  .= $virgula . " l216_codproc = $this->l216_codproc ";
            $virgula = ",";
            if (trim($this->l216_codproc) == null) {
                $this->erro_sql = " Campo l216_codproc não informado.";
                $this->erro_campo = "l216_codproc";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l216_dataanexo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l216_dataanexo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l216_dataanexo_dia"] != "")) {
            $sql  .= $virgula . " l216_dataanexo = '$this->l216_dataanexo' ";
            $virgula = ",";
            if (trim($this->l216_dataanexo) == null) {
                $this->erro_sql = " Campo l216_dataanexo não informado.";
                $this->erro_campo = "l216_dataanexo_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["l216_dataanexo_dia"])) {
                $sql  .= $virgula . " l216_dataanexo = null ";
                $virgula = ",";
                if (trim($this->l216_dataanexo) == null) {
                    $this->erro_sql = " Campo l216_dataanexo não informado.";
                    $this->erro_campo = "l216_dataanexo_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->l216_id_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l216_id_usuario"])) {
            $sql  .= $virgula . " l216_id_usuario = $this->l216_id_usuario ";
            $virgula = ",";
            if (trim($this->l216_id_usuario) == null) {
                $this->erro_sql = " Campo l216_id_usuario não informado.";
                $this->erro_campo = "l216_id_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l216_hora) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l216_hora"])) {
            $sql  .= $virgula . " l216_hora = '$this->l216_hora' ";
            $virgula = ",";
            if (trim($this->l216_hora) == null) {
                $this->erro_sql = " Campo l216_hora não informado.";
                $this->erro_campo = "l216_hora";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l216_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l216_instit"])) {
            $sql  .= $virgula . " l216_instit = $this->l216_instit ";
            $virgula = ",";
            if (trim($this->l216_instit) == null) {
                $this->erro_sql = " Campo l216_instit não informado.";
                $this->erro_campo = "l216_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "oid = '$oid'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "anexocomprapncp nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "anexocomprapncp nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao 
    function excluir($oid = null, $dbwhere = null)
    {

        $sql = " delete from anexocomprapncp
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
            $this->erro_sql   = "anexocomprapncp nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "anexocomprapncp nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
            $this->erro_sql   = "Record Vazio na Tabela:anexocomprapncp";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($oid = null, $campos = "anexocomprapncp.oid,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from anexocomprapncp ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($oid != "" && $oid != null) {
                $sql2 = " where anexocomprapncp.oid = '$oid'";
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
    function sql_query_file($oid = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from anexocomprapncp ";
        $sql .= " inner join comanexopncpdocumento on l217_licanexospncp=l216_sequencial ";
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

    public function sql_anexos_licitacao_compra($pc80_codproc)
    {
        $sql = "
        SELECT  l217_nomedocumento AS l216_nomedocumento,
                l213_sequencial,
                l213_descricao,
                l217_sequencial
            FROM anexocomprapncp
            INNER JOIN comanexopncpdocumento ON l217_licanexospncp = l216_sequencial
            INNER JOIN tipoanexo ON l213_sequencial = l217_tipoanexo
            WHERE l216_codproc = $pc80_codproc
            ORDER BY l213_sequencial limit 1";
        return $sql;
    }

    public function sql_anexos_licitacao_aviso_todos($pc80_codproc)
    {
        $sql = "
        SELECT  l217_nomedocumento AS l216_nomedocumento,
                l213_sequencial,
                l213_descricao,
                l217_sequencial
            FROM anexocomprapncp
            INNER JOIN comanexopncpdocumento ON l217_licanexospncp = l216_sequencial
            INNER JOIN tipoanexo ON l213_sequencial = l217_tipoanexo
            WHERE l216_codproc = $pc80_codproc
            ORDER BY l213_sequencial OFFSET  1";
        return $sql;
    }

    public function sql_anexos_licitacao($pc80_codproc, $l217_sequencial)
    {
        $sql = "
      SELECT    l217_nomedocumento AS l216_nomedocumento,
                l217_tipoanexo as l216_tipoanexo,
                l213_descricao
        FROM anexocomprapncp
        INNER JOIN comanexopncpdocumento ON l217_licanexospncp = l216_sequencial
        INNER JOIN tipoanexo ON l213_sequencial = l217_tipoanexo
        WHERE l216_codproc = $pc80_codproc and l217_sequencial = $l217_sequencial
      ";
        return $sql;
    }
}
