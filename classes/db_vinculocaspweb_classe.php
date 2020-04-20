<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE vinculocaspweb/
class cl_vinculocaspweb {
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
    public $c232_estrutecidade = null;
    public $c232_estrutcaspweb = null;
    public $c232_anousu = null;

    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 c232_estrutecidade = varchar(9) = Estrutural E-Cidade
                 c232_estrutcaspweb = varchar(9) = Estrutural Caspweb
                 c232_anousu = int4 = Ano
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("vinculocaspweb");
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
            $this->c232_estrutecidade = ($this->c232_estrutecidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c232_estrutecidade"]:$this->c232_estrutecidade);
            $this->c232_estrutcaspweb = ($this->c232_estrutcaspweb == ""?@$GLOBALS["HTTP_POST_VARS"]["c232_estrutcaspweb"]:$this->c232_estrutcaspweb);
            $this->c232_anousu = ($this->c232_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c232_anousu"]:$this->c232_anousu);
        } else {
            $this->c232_estrutecidade = ($this->c232_estrutecidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c232_estrutecidade"]:$this->c232_estrutecidade);
            $this->c232_estrutcaspweb = ($this->c232_estrutcaspweb == ""?@$GLOBALS["HTTP_POST_VARS"]["c232_estrutcaspweb"]:$this->c232_estrutcaspweb);
            $this->c232_anousu = ($this->c232_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c232_anousu"]:$this->c232_anousu);
        }
    }

    // funcao para inclusao
    function incluir ($c232_estrutecidade,$c232_estrutcaspweb,$c232_anousu) {
        $this->atualizacampos();
        $this->c232_estrutecidade = $c232_estrutecidade;
        $this->c232_estrutcaspweb = $c232_estrutcaspweb;
        if (($this->c232_estrutecidade == null) || ($this->c232_estrutecidade == "") ) {
            $this->erro_sql = " Campo c232_estrutecidade nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if (($this->c232_estrutcaspweb == null) || ($this->c232_estrutcaspweb == "") ) {
            $this->erro_sql = " Campo c232_estrutcaspweb nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into vinculocaspweb(
                                       c232_estrutecidade
                                      ,c232_estrutcaspweb
                                      ,c232_anousu
                       )
                values (
                                '$this->c232_estrutecidade'
                               ,'$this->c232_estrutcaspweb'
                               ,'$this->c232_anousu'
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "Vínculo Caspweb ($this->c232_estrutecidade."-".$this->c232_estrutcaspweb) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Vínculo Caspweb já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "Vínculo Caspweb ($this->c232_estrutecidade."-".$this->c232_estrutcaspweb) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->c232_estrutecidade."-".$this->c232_estrutcaspweb;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        return true;
    }

    // funcao para alteracao
    function alterar ($c232_estrutecidade=null,$c232_estrutcaspweb=null,$c232_estrutecidadeant=null,$c232_estrutcaspwebant=null,$c232_anousu=null) {
        $this->atualizacampos();
        $sql = " update vinculocaspweb set ";
        $virgula = "";
        if (trim($this->c232_estrutecidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c232_estrutecidade"])) {
            $sql  .= $virgula." c232_estrutecidade = '$this->c232_estrutecidade' ";
            $virgula = ",";
            if (trim($this->c232_estrutecidade) == null ) {
                $this->erro_sql = " Campo Estrutural E-Cidade não informado.";
                $this->erro_campo = "c232_estrutecidade";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["c232_estrutecidadeant"])) {
            $this->c232_estrutecidadeant = "'$this->c232_estrutecidadeant'";
        }
        if (trim($this->c232_estrutcaspweb)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c232_estrutcaspweb"])) {
            $sql  .= $virgula." c232_estrutcaspweb = '$this->c232_estrutcaspweb' ";
            $virgula = ",";
            if (trim($this->c232_estrutcaspweb) == null ) {
                $this->erro_sql = " Campo Estrutural Caspweb não informado.";
                $this->erro_campo = "c232_estrutcaspweb";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["c232_estrutcaspwebant"])) {
            $this->c232_estrutcaspwebant = "'$this->c232_estrutcaspwebant'";
        }
        $sql .= " where ";
        if ($c232_estrutecidade!=null) {
            $sql .= " c232_estrutecidade = '$c232_estrutecidadeant'";
        }
        if ($c232_estrutcaspweb!=null) {
            $sql .= " and  c232_estrutcaspweb = '$c232_estrutcaspwebant'";
        }
        if ($c232_anousu!=null) {
            $sql .= " and  c232_anousu = '$c232_anousu'";
        }
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Vínculo Caspweb nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->c232_estrutecidade."-".$this->c232_estrutcaspweb;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Vínculo Caspweb nao foi Alterado. Alteracao Abortada.\\n$sql";
                $this->erro_sql .= "Valores : ".$this->c232_estrutecidade."-".$this->c232_estrutcaspweb;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->c232_estrutecidade."-".$this->c232_estrutcaspweb;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($c232_estrutecidade=null,$c232_estrutcaspweb=null,$c232_anousu=null,$dbwhere=null) {

        $sql = " delete from vinculocaspweb
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($c232_estrutecidade != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c232_estrutecidade = '$c232_estrutecidade' ";
            }
            if ($c232_estrutcaspweb != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c232_estrutcaspweb = '$c232_estrutcaspweb' ";
            }
            if ($c232_anousu != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c232_anousu = '$c232_anousu' ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Vínculo Caspweb nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$c232_estrutecidade."-".$c232_estrutcaspweb."-".$c232_anousu;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Vínculo Caspweb nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$c232_estrutecidade."-".$c232_estrutcaspweb;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$c232_estrutecidade."-".$c232_estrutcaspweb;
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
            $this->erro_sql   = "Record Vazio na Tabela:vinculocaspweb";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $c232_estrutecidade=null,$c232_estrutcaspweb=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from vinculocaspweb ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c232_estrutecidade!=null ) {
                $sql2 .= " where vinculocaspweb.c232_estrutecidade = '$c232_estrutecidade' ";
            }
            if ($c232_estrutcaspweb!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " vinculocaspweb.c232_estrutcaspweb = '$c232_estrutcaspweb' ";
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
    function sql_query_file ( $c232_estrutecidade=null,$c232_estrutcaspweb=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from vinculocaspweb ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c232_estrutecidade!=null ) {
                $sql2 .= " where vinculocaspweb.c232_estrutecidade = '$c232_estrutecidade' ";
            }
            if ($c232_estrutcaspweb!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " vinculocaspweb.c232_estrutcaspweb = '$c232_estrutcaspweb' ";
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
}
?>
