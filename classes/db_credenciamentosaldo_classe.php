<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE credenciamentosaldo
class cl_credenciamentosaldo {
    // cria variaveis de erro
    public $rotulo     = null;
    public $query_sql  = null;
    public $numrows    = 0;
    public $numrows_incluir = 0;
    public $numrows_alterar = 0;
    public $numrows_excluir = 0;
    public $erro_status= null;
    public $erro_sql   = null;
    public $erro_banco = null;
    public $erro_msg   = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    // cria variaveis do arquivo
    public $l213_sequencial = 0;
    public $l213_licitacao = 0;
    public $l213_item = 0;
    public $l213_itemlicitacao = 0;
    public $l213_qtdlicitada = 0;
    public $l213_qtdcontratada = 0;
    public $l213_contratado = 0;
    public $l213_acordo = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 l213_sequencial = int4 = Sequencial 
                 l213_licitacao = int4 = Licitação 
                 l213_item = int8 = Item 
                 l213_itemlicitacao = int8 - Cod Item na Licitacao
                 l213_qtdlicitada = float8 = Qtd. Licitada 
                 l213_qtdcontratada = float8 = Qtd. Contratada
                 l213_contratado    = int4 = contratado
                 l213_acordo = int4 = acordo 
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("credenciamentosaldo");
        $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
    }

    //funcao erro
    function erro($mostra,$retorna) {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )) {
            echo "<script>alert(\"".$this->erro_msg."\");</script>";
            if ($retorna==true) {
                echo "<script>location.href='".$this->pagina_retorno."'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao=false) {
        if ($exclusao==false) {
            $this->l213_sequencial = ($this->l213_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_sequencial"]:$this->l213_sequencial);
            $this->l213_licitacao = ($this->l213_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_licitacao"]:$this->l213_licitacao);
            $this->l213_item = ($this->l213_item == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_item"]:$this->l213_item);
            $this->l213_itemlicitacao = ($this->l213_itemlicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_itemlicitacao"]:$this->l213_itemlicitacao);
            $this->l213_qtdlicitada = ($this->l213_qtdlicitada == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_qtdlicitada"]:$this->l213_qtdlicitada);
            $this->l213_qtdcontratada = ($this->l213_qtdcontratada == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_qtdcontratada"]:$this->l213_qtdcontratada);
            $this->l213_contratado = ($this->l213_contratado == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_contratado"]:$this->l213_contratado);
            $this->l213_acordo = ($this->l213_acordo == ""?@$GLOBALS["HTTP_POST_VARS"]["l213_acordo"]:$this->l213_acordo);
        }
    }

    // funcao para inclusao
    function incluir () {

        $this->atualizacampos();
        if($this->l213_sequencial == "" || $this->l213_sequencial == null ){
            $result = db_query("select nextval('credenciamentosaldo_l213_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: credenciamentosaldo_l213_sequencial_seq do campo: l213_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l213_sequencial = pg_result($result,0,0);
        }

        if ($this->l213_licitacao == null ) {
            $this->erro_sql = " Campo Licitação não informado.";
            $this->erro_campo = "l213_licitacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_item == null ) {
            $this->erro_sql = " Campo Item não informado.";
            $this->erro_campo = "l213_item";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_itemlicitacao == null ) {
            $this->erro_sql = " Campo Item da licitacao não informado.";
            $this->erro_campo = "l213_itemlicitacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_qtdlicitada == null ) {
            $this->erro_sql = " Campo Qtd. Licitada não informado.";
            $this->erro_campo = "l213_qtdlicitada";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l213_qtdcontratada == null ) {
            $this->erro_sql = " Campo Qtd. Contratada não informado.";
            $this->erro_campo = "l213_qtdcontratada";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l213_contratado == null ) {
            $this->erro_sql = " Campo Contratado não informado.";
            $this->erro_campo = "l213_contratado";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l213_acordo == null ) {
            $this->l213_acordo = "null";
        }

        $sql = "insert into credenciamentosaldo(
                                       l213_sequencial 
                                      ,l213_licitacao 
                                      ,l213_item 
                                      ,l213_itemlicitacao 
                                      ,l213_qtdlicitada 
                                      ,l213_qtdcontratada
                                      ,l213_contratado 
                                      ,l213_acordo
                                       
                       )
                values (
                                $this->l213_sequencial 
                               ,$this->l213_licitacao 
                               ,$this->l213_item 
                               ,$this->l213_itemlicitacao 
                               ,$this->l213_qtdlicitada 
                               ,$this->l213_qtdcontratada
                               ,$this->l213_contratado 
                               ,$this->l213_acordo 
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "credenciamentosaldo () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "credenciamentosaldo já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "credenciamentosaldo () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

        }
        return true;
    }

    // funcao para alteracao
    function alterar ( $l213_sequencial=null ) {
        $this->atualizacampos();
        $sql = " update credenciamentosaldo set ";
        $virgula = "";
        if (trim($this->l213_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l213_sequencial"])) {
            $sql  .= $virgula." l213_sequencial = $this->l213_sequencial ";
            $virgula = ",";
            if (trim($this->l213_sequencial) == null ) {
                $this->erro_sql = " Campo Sequencial não informado.";
                $this->erro_campo = "l213_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l213_licitacao"])) {
            $sql  .= $virgula." l213_licitacao = $this->l213_licitacao ";
            $virgula = ",";
            if (trim($this->l213_licitacao) == null ) {
                $this->erro_sql = " Campo Licitação não informado.";
                $this->erro_campo = "l213_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_item)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l213_item"])) {
            $sql  .= $virgula." l213_item = $this->l213_item ";
            $virgula = ",";
            if (trim($this->l213_item) == null ) {
                $this->erro_sql = " Campo Item não informado.";
                $this->erro_campo = "l213_item";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_qtdlicitada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l213_qtdlicitada"])) {
            $sql  .= $virgula." l213_qtdlicitada = $this->l213_qtdlicitada ";
            $virgula = ",";
            if (trim($this->l213_qtdlicitada) == null ) {
                $this->erro_sql = " Campo Qtd. Licitada não informado.";
                $this->erro_campo = "l213_qtdlicitada";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l213_qtdcontratada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l213_qtdcontratada"])) {
            $sql  .= $virgula." l213_qtdcontratada = $this->l213_qtdcontratada ";
            $virgula = ",";
            if (trim($this->l213_qtdcontratada) == null ) {
                $this->erro_sql = " Campo Qtd. Contratada não informado.";
                $this->erro_campo = "l213_qtdcontratada";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "l213_sequencial = $l213_sequencial";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "credenciamentosaldo nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "credenciamentosaldo nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ( $l213_sequencial=null ,$dbwhere=null) {

        $sql = " delete from credenciamentosaldo
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            $sql2 = "l213_sequencial = $l213_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "credenciamentosaldo nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "credenciamentosaldo nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao do recordset
    function sql_record($sql) {
        $result = db_query($sql);
        if ($result==false) {
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows==0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:credenciamentosaldo";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $oid = null,$campos="credenciamentosaldo.oid,*",$ordem=null,$dbwhere="") {
        $sql = "select ";
        if ($campos != "*" ) {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from credenciamentosaldo ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $oid != "" && $oid != null) {
                $sql2 = " where credenciamentosaldo.oid = '$oid'";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null ) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    // funcao do sql
    function sql_query_file ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
        $sql = "select ";
        if ($campos != "*" ) {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from credenciamentosaldo ";
        $sql2 = "";
        if ($dbwhere=="") {
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null ) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
}
?>
