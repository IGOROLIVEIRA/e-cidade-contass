<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE liccontrolepncpitens
class cl_liccontrolepncpitens
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
    public $l214_sequencial = 0;
    public $l214_licitacao = 0;
    public $l214_pcproc = 0;
    public $l214_numeroresultado = null;
    public $l214_numerocompra = null;
    public $l214_anousu = null;
    public $l214_ordem = 0;

    public $l214_fornecedor = null;

    public $l214_sequencialresultado = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 l214_sequencial = int8 = l214_sequencial
                 l214_licitacao = int8 = l214_licitacao
                 l214_numeroresultado = int8 = situacao da licitacao pncp
                 l214_numerocompra = int8 = numero da compra no pncp
                 l214_anousu = int8 = ano da compra
                 l214_pcproc = int8 = numero do processo de compras
                 l214_ordem = int8 = l214_ordem
                 l214_fornecedor = int8 = fornecedor
                 l214_sequencialresultado = int8 = sequencial do resultado no pncp
                 ";

    //funcao construtor da classe
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("liccontrolepncpitens");
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
            $this->l214_sequencial = ($this->l214_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_sequencial"] : $this->l214_sequencial);
            $this->l214_licitacao = ($this->l214_licitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_licitacao"] : $this->l214_licitacao);
            $this->l214_pcproc = ($this->l214_pcproc == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_pcproc"] : $this->l214_pcproc);
            $this->l214_numeroresultado = ($this->l214_numeroresultado == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_numeroresultado"] : $this->l214_numeroresultado);
            $this->l214_numerocompra = ($this->l214_numerocompra == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_numerocompra"] : $this->l214_numerocompra);
            $this->l214_anousu = ($this->l214_anousu == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_anousu"] : $this->l214_anousu);
            $this->l214_ordem = ($this->l214_ordem == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_ordem"] : $this->l214_ordem);
            $this->l214_fornecedor = ($this->l214_fornecedor == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_fornecedor"] : $this->l214_fornecedor);
            $this->l214_sequencialresultado = ($this->l214_sequencialresultado == "" ? @$GLOBALS["HTTP_POST_VARS"]["l214_sequencialresultado"] : $this->l214_sequencialresultado);
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();

        if ($this->l214_licitacao == null || $this->l214_licitacao == "") {
            $this->l214_licitacao = "NULL";
        }

        if ($this->l214_pcproc == null || $this->l214_pcproc == "") {
            $this->l214_pcproc = "NULL";
        }

        if ($this->l214_fornecedor == null || $this->l214_fornecedor == "") {
            $this->l214_fornecedor = "NULL";
        }

        if ($this->l214_sequencialresultado == null || $this->l214_sequencialresultado == "") {
            $this->l214_sequencialresultado = "NULL";
        }

        if ($this->l214_ordem == null) {
            $this->erro_sql = " Campo l214_ordem não informado.";
            $this->erro_campo = "l214_ordem";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l214_numeroresultado == null) {
            $this->erro_sql = " Campo l214_numeroresultado não informado.";
            $this->erro_campo = "l214_numeroresultado";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l214_numerocompra == null) {
            $this->erro_sql = " Campo l214_numerocompra não informado.";
            $this->erro_campo = "l214_numerocompra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l214_anousu == null) {
            $this->erro_sql = " Campo l214_anousu não informado.";
            $this->erro_campo = "l214_anousu";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l214_sequencial == "" || $this->l214_sequencial == null) {
            $result = db_query("select nextval('liccontrolepncpitens_l214_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: liccontrolepncpitens_l214_sequencial_seq do campo: l214_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l214_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from liccontrolepncpitens_l214_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $this->l214_sequencial)) {
                $this->erro_sql = " Campo l214_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->l214_sequencial = $this->l214_sequencial;
            }
        }
        if (($this->l214_sequencial == null) || ($this->l214_sequencial == "")) {
            $this->erro_sql = " Campo l214_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into liccontrolepncpitens(
                                       l214_sequencial
                                      ,l214_licitacao
                                      ,l214_numeroresultado
                                      ,l214_numerocompra
                                      ,l214_anousu
                                      ,l214_ordem
                                      ,l214_pcproc
                                      ,l214_fornecedor
                                      ,l214_sequencialresultado
                       )
                values (
                                $this->l214_sequencial
                               ,$this->l214_licitacao
                               ,$this->l214_numeroresultado
                               ,$this->l214_numerocompra
                               ,$this->l214_anousu
                               ,$this->l214_ordem
                               ,$this->l214_pcproc
                               ,$this->l214_fornecedor
                               ,$this->l214_sequencialresultado
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "liccontrolepncpitens () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "liccontrolepncpitens já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "liccontrolepncpitens () nao Incluído. Inclusao Abortada.";
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
    function alterar($l214_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update liccontrolepncpitens set ";
        $virgula = "";
        if (trim($this->l214_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l214_sequencial"])) {
            $sql  .= $virgula . " l214_sequencial = $this->l214_sequencial ";
            $virgula = ",";
            if (trim($this->l214_sequencial) == null) {
                $this->erro_sql = " Campo l214_sequencial não informado.";
                $this->erro_campo = "l214_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l214_licitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l214_licitacao"])) {
            $sql  .= $virgula . " l214_licitacao = $this->l214_licitacao ";
            $virgula = ",";
            if (trim($this->l214_licitacao) == null) {
                $this->erro_sql = " Campo l214_licitacao não informado.";
                $this->erro_campo = "l214_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l214_ordem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l214_ordem"])) {
            $sql  .= $virgula . " l214_ordem = $this->l214_ordem ";
            $virgula = ",";
            if (trim($this->l214_ordem) == null) {
                $this->erro_sql = " Campo l214_ordem não informado.";
                $this->erro_campo = "l214_ordem";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "l214_sequencial = '$l214_sequencial'";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "liccontrolepncpitens nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liccontrolepncpitens nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($l214_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from liccontrolepncpitens
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "l214_sequencial = $l214_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "liccontrolepncpitens nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liccontrolepncpitens nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:liccontrolepncpitens";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($l214_sequencial = null, $campos = "liccontrolepncpitens.l214_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liccontrolepncpitens ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l214_sequencial != "" && $l214_sequencial != null) {
                $sql2 = " where liccontrolepncpitens.l214_sequencial = '$l214_sequencial'";
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
    function sql_query_file($l214_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liccontrolepncpitens ";
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
}
