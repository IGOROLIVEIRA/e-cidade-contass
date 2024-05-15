<?php
//MODULO: contratos
//CLASSE DA ENTIDADE licanexoataspncp
class cl_licanexoataspncp {
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
    public $l216_sequencial = 0;
    public $l216_codigoata = 0;
    public $l216_oid = 0;
    public $l216_tipoanexo = 0;
    public $l216_instit = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 l216_sequencial = int8 = Cód. Sequencial
                 l216_codigoata = int8 = codigo do termo na tabela de controle
                 l216_oid = oid = anexo
                 l216_tipoanexo = Varchar = tipo de anexo
                 l216_instit = int8 = instituicao
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("licanexoataspncp");
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
            $this->l216_sequencial = ($this->l216_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l216_sequencial"]:$this->l216_sequencial);
            $this->l216_codigoata = ($this->l216_codigoata == ""?@$GLOBALS["HTTP_POST_VARS"]["l216_codigoata"]:$this->l216_codigoata);
            $this->l216_oid = ($this->l216_oid == ""?@$GLOBALS["HTTP_POST_VARS"]["l216_oid"]:$this->l216_oid);
            $this->l216_tipoanexo = ($this->l216_tipoanexo == ""?@$GLOBALS["HTTP_POST_VARS"]["l216_tipoanexo"]:$this->l216_tipoanexo);
            $this->l216_instit = ($this->l216_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["l216_instit"]:$this->l216_instit);
        }

    }

    // funcao para inclusao
    function incluir () {
        $this->atualizacampos();
        if ($this->l216_sequencial == null ) {
            $result = db_query("select nextval('licanexoataspncp_l216_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: licanexoataspncp_l216_sequencial_seq do campo: obr02_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l216_sequencial = pg_result($result,0,0);
        }
        if ($this->l216_codigoata == null ) {
            $this->erro_sql = " codigo de controle do termo nao informado.";
            $this->erro_campo = "l216_codigoata";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l216_oid == null ) {
            $this->erro_sql = " anexo nao encontrado.";
            $this->erro_campo = "l216_oid";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l216_tipoanexo == null ) {
            $this->erro_sql = " tipo de anexo não informado.";
            $this->erro_campo = "l216_tipoanexo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into licanexoataspncp(
                                       l216_sequencial
                                      ,l216_codigoata
                                      ,l216_tipoanexo
                                      ,l216_oid
                                      ,l216_instit
                       )
                values (
                                $this->l216_sequencial
                               ,$this->l216_codigoata
                               ,'$this->l216_tipoanexo'
                               ,$this->l216_oid
                               ,$this->l216_instit
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "cadastro de anexos de termos () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "cadastro de anexos de termos já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "cadastro de anexos de termos () nao Incluído. Inclusao Abortada.";
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
    function alterar ( $l216_sequencial=null ) {
        $this->atualizacampos();
        $sql = " update licanexoataspncp set ";
        $virgula = "";
        if (trim($this->l216_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l216_sequencial"])) {
            $sql  .= $virgula." l216_sequencial = $this->l216_sequencial ";
            $virgula = ",";
            if (trim($this->l216_sequencial) == null ) {
                $this->erro_sql = " Campo Cód. Sequencial não informado.";
                $this->erro_campo = "l216_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l216_codigoata)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l216_codigoata"])) {
            $sql  .= $virgula." l216_codigoata = $this->l216_codigoata ";
            $virgula = ",";
        }
        if (trim($this->l216_oid)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l216_oid"])) {
            $sql  .= $virgula." l216_oid = $this->l216_oid ";
            $virgula = ",";
        }
        if (trim($this->l216_tipoanexo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l216_tipoanexo"])) {
            $sql  .= $virgula." l216_tipoanexo = '$this->l216_tipoanexo' ";
            $virgula = ",";
        }
        $sql .= " where ";
        $sql .= "l216_sequencial = $l216_sequencial";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cadastro de anexos de termos nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "cadastro de anexos de termos nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir ( $l216_sequencial=null ,$dbwhere=null) {

        $sql = " delete from licanexoataspncp
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            $sql2 = "l216_sequencial = $l216_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cadastro de anexos de termos nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "cadastro de anexos de termos nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:licanexoataspncp";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $l216_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from licanexoataspncp ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $l216_sequencial != "" && $l216_sequencial != null) {
                $sql2 = " where l216_sequencial = $l216_sequencial";
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
    function sql_query_file ( $l216_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from licanexoataspncp ";
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
<?php
