<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE naturdessiope/
class cl_naturdessiope {
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
    public $c222_natdespecidade = null;
    public $c222_natdespsiope = null;
    public $c222_previdencia = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 c222_natdespecidade = varchar(11) = E-Cidade
                 c222_natdespsiope = varchar(11) = Siope
                 c222_anousu = int4 = Ano
                 c222_previdencia = bool = Previdência
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("naturdessiope");
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
            $this->c222_natdespecidade = ($this->c222_natdespecidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_natdespecidade"]:$this->c222_natdespecidade);
            $this->c222_natdespsiope = ($this->c222_natdespsiope == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_natdespsiope"]:$this->c222_natdespsiope);
            $this->c222_anousu = ($this->c222_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_anousu"]:$this->c222_anousu);
            $this->c222_previdencia = ($this->c222_previdencia == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_previdencia"]:$this->c222_previdencia);
        } else {
            $this->c222_natdespecidade = ($this->c222_natdespecidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_natdespecidade"]:$this->c222_natdespecidade);
            $this->c222_natdespsiope = ($this->c222_natdespsiope == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_natdespsiope"]:$this->c222_natdespsiope);
            $this->c222_anousu = ($this->c222_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_anousu"]:$this->c222_anousu);
            $this->c222_previdencia = ($this->c222_previdencia == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_previdencia"]:$this->c222_previdencia);
        }
    }

    // funcao para inclusao
    function incluir ($c222_natdespecidade,$c222_natdespsiope, $c222_anousu, $c222_previdencia) {
        $this->atualizacampos();
        $this->c222_natdespecidade = $c222_natdespecidade;
        $this->c222_natdespsiope = $c222_natdespsiope;
        if (($this->c222_natdespecidade == null) || ($this->c222_natdespecidade == "") ) {
            $this->erro_sql = " Campo c222_natdespecidade nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if (($this->c222_natdespsiope == null) || ($this->c222_natdespsiope == "") ) {
            $this->erro_sql = " Campo c222_natdespsiope nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into naturdessiope(
                                       c222_natdespecidade
                                      ,c222_natdespsiope
                                      ,c222_anousu
                                      ,c222_previdencia
                       )
                values (
                                '$this->c222_natdespecidade'
                               ,'$this->c222_natdespsiope'
                               ,'$this->c222_anousu'
                               ,'$this->c222_previdencia'
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "Natureza da despesa Siope ($this->c222_natdespecidade."-".$this->c222_natdespsiope) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Natureza da despesa Siope já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "Natureza da despesa Siope ($this->c222_natdespecidade."-".$this->c222_natdespsiope) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->c222_natdespecidade."-".$this->c222_natdespsiope;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        return true;
    }

    // funcao para alteracao
    function alterar ($c222_natdespecidade=null,$c222_natdespsiope=null,$c222_previdencia) {
        $this->atualizacampos();
        $sql = " update naturdessiope set ";
        $virgula = "";
        if (trim($this->c222_natdespecidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_natdespecidade"])) {
            $sql  .= $virgula." c222_natdespecidade = '$this->c222_natdespecidade' ";
            $virgula = ",";
            if (trim($this->c222_natdespecidade) == null ) {
                $this->erro_sql = " Campo Natureza despesa E-cidade não informado.";
                $this->erro_campo = "c222_natdespecidade";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c222_natdespsiope)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_natdespsiope"])) {
            $sql  .= $virgula." c222_natdespsiope = '$this->c222_natdespsiope' ";
            $virgula = ",";
            if (trim($this->c222_natdespsiope) == null ) {
                $this->erro_sql = " Campo Natureza despesa Siope não informado.";
                $this->erro_campo = "c222_natdespsiope";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c222_previdencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_previdencia"])) {
            $sql  .= $virgula." c222_previdencia = '$this->c222_previdencia' ";
            $virgula = ",";
            if (trim($this->c222_previdencia) == null ) {
                $this->erro_sql = " Campo Previdência não informado.";
                $this->erro_campo = "c222_previdencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " , c222_anousu = ".$this->c222_anousu." ";
        $sql .= " where ";
        if ($c222_natdespecidade!=null) {
            $sql .= " c222_natdespecidade = '$this->c222_natdespecidade'";
        }
        if ($c222_natdespsiope!=null) {
            $sql .= " and  c222_natdespsiope = '$this->c222_natdespsiope'";
        }

        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Natureza da despesa Siope nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->c222_natdespecidade."-".$this->c222_natdespsiope;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Natureza da despesa Siope nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->c222_natdespecidade."-".$this->c222_natdespsiope;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->c222_natdespecidade."-".$this->c222_natdespsiope;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($c222_natdespecidade=null,$c222_natdespsiope=null,$dbwhere=null) {

        $sql = " delete from naturdessiope
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($c222_natdespecidade != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c222_natdespecidade = '$c222_natdespecidade' ";
            }
            if ($c222_natdespsiope != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c222_natdespsiope = '$c222_natdespsiope' ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Natureza da despesa Siope nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$c222_natdespecidade."-".$c222_natdespsiope;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Natureza da despesa Siope nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$c222_natdespecidade."-".$c222_natdespsiope;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$c222_natdespecidade."-".$c222_natdespsiope;
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
            $this->erro_sql   = "Record Vazio na Tabela:naturdessiope";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $c222_natdespecidade=null,$c222_natdespsiope=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturdessiope ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c222_natdespecidade!=null ) {
                $sql2 .= " where naturdessiope.c222_natdespecidade = '$c222_natdespecidade' ";
            }
            if ($c222_natdespsiope!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiope.c222_natdespsiope = '$c222_natdespsiope' ";
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
    function sql_query_file ( $c222_natdespecidade=null,$c222_natdespsiope=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturdessiope ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c222_natdespecidade!=null ) {
                $sql2 .= " where naturdessiope.c222_natdespecidade = '$c222_natdespecidade' ";
            }
            if ($c222_natdespsiope!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiope.c222_natdespsiope = '$c222_natdespsiope' ";
            }
            if ($c222_anousu!=null) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiope.c222_anousu = '$c222_anousu' ";
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

    function sql_query_siope ( $c222_natdespecidade=null, $c222_natdespsiope="", $c222_anousu="", $c222_previdencia="",$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturdessiope ";
        $sql .= ' inner join eledessiope on eledessiope.c223_eledespsiope = naturdessiope.c222_natdespsiope and naturdessiope.c222_anousu = eledessiope.c223_anousu ';
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c222_natdespecidade!=null ) {
                $sql2 .= " where naturdessiope.c222_natdespecidade = '$c222_natdespecidade' ";
            }
            if ($c222_natdespsiope!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiope.c222_natdespsiope = '$c222_natdespsiope' ";
            }
            if ($c222_anousu!=null) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiope.c222_anousu = '$c222_anousu' ";
            }
            if ($c222_previdencia!=null) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiope.c222_previdencia = '$c222_previdencia' ";
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
