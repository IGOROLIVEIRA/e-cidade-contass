<?php
//MODULO: compras
//CLASSE DA ENTIDADE comanexopncpdocumento
class cl_comanexopncpdocumento
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
    public $l217_sequencial = 0;
    public $l217_licanexospncp = 0;
    public $l217_documento = null;
    public $l217_nomedocumento = null;
    public $l217_tipoanexo = 0;
    // cria propriedade com as variaveis do arquivo 
    public $campos = "
                 l217_sequencial = int8 = l217_sequencial 
                 l217_licanexospncp = int8 = l217_licanexospncp 
                 l217_documento = varchar(255) = l217_documento 
                 l217_nomedocumento = varchar(255) = l217_nomedocumento 
                 l217_tipoanexo = varchar(255) = l217_tipoanexo
                 ";

    //funcao construtor da classe 
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("comanexopncpdocumento");
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
            $this->l217_sequencial = ($this->l217_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_sequencial"] : $this->l217_sequencial);
            $this->l217_licanexospncp = ($this->l217_licanexospncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_licanexospncp"] : $this->l217_licanexospncp);
            $this->l217_documento = ($this->l217_documento == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_documento"] : $this->l217_documento);
            $this->l217_nomedocumento = ($this->l217_nomedocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_nomedocumento"] : $this->l217_nomedocumento);
            $this->l217_tipoanexo = ($this->l217_tipoanexo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_tipoanexo"] : $this->l217_tipoanexo);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->l217_licanexospncp == null) {
            $this->erro_sql = " Campo l217_licanexospncp não informado.";
            $this->erro_campo = "l217_licanexospncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_documento == null) {
            $this->erro_sql = " Campo l217_documento não informado.";
            $this->erro_campo = "l217_documento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_nomedocumento == null) {
            $this->erro_sql = " Campo l217_nomedocumento não informado.";
            $this->erro_campo = "l217_nomedocumento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_tipoanexo == null) {
            $this->erro_sql = " Campo l217_tipoanexo não informado.";
            $this->erro_campo = "l217_tipoanexo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_sequencial == "" || $this->l217_sequencial == null) {
            $result = db_query("select nextval('comanexopncpdocumento_l217_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: comanexopncpdocumento_l217_sequencial_seq do campo: l217_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l217_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from comanexopncpdocumento_l217_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->l217_sequencial)) {
                $this->erro_sql = " Campo l217_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->l217_sequencial = $this->l217_sequencial;
            }
        }
        if (($this->l217_sequencial == null) || ($this->l217_sequencial == "")) {
            $this->erro_sql = " Campo l217_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into comanexopncpdocumento(
                                       l217_sequencial 
                                      ,l217_licanexospncp 
                                      ,l217_documento 
                                      ,l217_nomedocumento
                                      ,l217_tipoanexo
                       )
                values (
                                $this->l217_sequencial 
                               ,$this->l217_licanexospncp 
                               ,'$this->l217_documento' 
                               ,'$this->l217_nomedocumento' 
                               ,$this->l217_tipoanexo
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "comanexopncpdocumento () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "comanexopncpdocumento já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "comanexopncpdocumento () nao Incluído. Inclusao Abortada.";
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
    function alterar($l217_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update comanexopncpdocumento set ";
        $virgula = "";
        if (trim($this->l217_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencial"])) {
            $sql  .= $virgula . " l217_sequencial = $this->l217_sequencial ";
            $virgula = ",";
            if (trim($this->l217_sequencial) == null) {
                $this->erro_sql = " Campo l217_sequencial não informado.";
                $this->erro_campo = "l217_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_licanexospncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_licanexospncp"])) {
            $sql  .= $virgula . " l217_licanexospncp = $this->l217_licanexospncp ";
            $virgula = ",";
            if (trim($this->l217_licanexospncp) == null) {
                $this->erro_sql = " Campo l217_licanexospncp não informado.";
                $this->erro_campo = "l217_licanexospncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_documento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_documento"])) {
            $sql  .= $virgula . " l217_documento = '$this->l217_documento' ";
            $virgula = ",";
            if (trim($this->l217_documento) == null) {
                $this->erro_sql = " Campo l217_documento não informado.";
                $this->erro_campo = "l217_documento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_nomedocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_nomedocumento"])) {
            $sql  .= $virgula . " l217_nomedocumento = '$this->l217_nomedocumento' ";
            $virgula = ",";
            if (trim($this->l217_nomedocumento) == null) {
                $this->erro_sql = " Campo l217_nomedocumento não informado.";
                $this->erro_campo = "l217_nomedocumento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_tipoanexo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_tipoanexo"])) {
            $sql  .= $virgula . " l217_tipoanexo = '$this->l217_tipoanexo' ";
            $virgula = ",";
            if (trim($this->l217_tipoanexo) == null) {
                $this->erro_sql = " Campo l217_tipoanexo não informado.";
                $this->erro_campo = "l217_tipoanexo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "l217_sequencial = '$l217_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "comanexopncpdocumento nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "comanexopncpdocumento nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($l217_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from comanexopncpdocumento
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "l217_sequencial = $l217_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "comanexopncpdocumento nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "comanexopncpdocumento nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:comanexopncpdocumento";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql 
    function sql_query($oid = null, $campos = "comanexopncpdocumento.oid,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from comanexopncpdocumento ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($oid != "" && $oid != null) {
                $sql2 = " where comanexopncpdocumento.oid = '$oid'";
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
        $sql .= " from comanexopncpdocumento ";
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

    function verificalic($licicitacao)
    {
        $sql = "select * from comanexopncpdocumento 
    inner join licanexopncp on
      licanexopncp.l215_sequencial  = comanexopncpdocumento.l217_licanexospncp
    where 
      l215_liclicita = $licicitacao";

        return $sql;
    }
}
