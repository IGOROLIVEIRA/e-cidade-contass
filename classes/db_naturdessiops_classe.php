<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE naturdessiops/
class cl_naturdessiops {
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
    public $c226_natdespecidade = null;
    public $c226_natdespsiops = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 c226_natdespecidade = varchar(10) = E-Cidade
                 c226_natdespsiops = varchar(10) = Siops
                 c226_anousu = int4 = Ano
                 ";


    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("naturdessiops");
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
            $this->c226_natdespecidade = ($this->c226_natdespecidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c226_natdespecidade"]:$this->c226_natdespecidade);
            $this->c226_natdespsiops = ($this->c226_natdespsiops == ""?@$GLOBALS["HTTP_POST_VARS"]["c226_natdespsiops"]:$this->c226_natdespsiops);
            $this->c226_anousu = ($this->c226_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c226_anousu"]:$this->c226_anousu);
        } else {
            $this->c226_natdespecidade = ($this->c226_natdespecidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c226_natdespecidade"]:$this->c226_natdespecidade);
            $this->c226_natdespsiops = ($this->c226_natdespsiops == ""?@$GLOBALS["HTTP_POST_VARS"]["c226_natdespsiops"]:$this->c226_natdespsiops);
            $this->c226_anousu = ($this->c226_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c226_anousu"]:$this->c226_anousu);
        }
    }

    // funcao para inclusao
    function incluir ($c226_natdespecidade,$c226_natdespsiops, $c226_anousu) {
        $this->atualizacampos();
        $this->c226_natdespecidade = $c226_natdespecidade;
        $this->c226_natdespsiops = $c226_natdespsiops;
        if (($this->c226_natdespecidade == null) || ($this->c226_natdespecidade == "") ) {
            $this->erro_sql = " Campo c226_natdespecidade nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if (($this->c226_natdespsiops == null) || ($this->c226_natdespsiops == "") ) {
            $this->erro_sql = " Campo c226_natdespsiops nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into naturdessiops(
                                       c226_natdespecidade
                                      ,c226_natdespsiops
                                      ,c226_anousu
                       )
                values (
                                '$this->c226_natdespecidade'
                               ,'$this->c226_natdespsiops'
                               ,'$this->c226_anousu'
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "Natureza da despesa Siops ($this->c226_natdespecidade."-".$this->c226_natdespsiops) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Natureza da despesa Siops já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "Natureza da despesa Siops ($this->c226_natdespecidade."-".$this->c226_natdespsiops) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->c226_natdespecidade."-".$this->c226_natdespsiops;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        return true;
    }

    // funcao para alteracao
    function alterar ($c226_natdespecidade=null,$c226_natdespsiops=null) {
        $this->atualizacampos();
        $sql = " update naturdessiops set ";
        $virgula = "";
        if (trim($this->c226_natdespecidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c226_natdespecidade"])) {
            $sql  .= $virgula." c226_natdespecidade = '$this->c226_natdespecidade' ";
            $virgula = ",";
            if (trim($this->c226_natdespecidade) == null ) {
                $this->erro_sql = " Campo Natureza despesa E-cidade não informado.";
                $this->erro_campo = "c226_natdespecidade";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c226_natdespsiops)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c226_natdespsiops"])) {
            $sql  .= $virgula." c226_natdespsiops = '$this->c226_natdespsiops' ";
            $virgula = ",";
            if (trim($this->c226_natdespsiops) == null ) {
                $this->erro_sql = " Campo Natureza despesa Siope não informado.";
                $this->erro_campo = "c226_natdespsiops";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " c226_anousu = ".$this->c226_anousu." ";
        $sql .= " where ";
        if ($c226_natdespecidade!=null) {
            $sql .= " c226_natdespecidade = '$this->c226_natdespecidade'";
        }
        if ($c226_natdespsiops!=null) {
            $sql .= " and  c226_natdespsiops = '$this->c226_natdespsiops'";
        }

        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Natureza da despesa Siops nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->c226_natdespecidade."-".$this->c226_natdespsiops;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Natureza da despesa Siops nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->c226_natdespecidade."-".$this->c226_natdespsiops;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->c226_natdespecidade."-".$this->c226_natdespsiops;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($c226_natdespecidade=null,$c226_natdespsiops=null,$dbwhere=null) {

        $sql = " delete from naturdessiops
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($c226_natdespecidade != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c226_natdespecidade = '$c226_natdespecidade' ";
            }
            if ($c226_natdespsiops != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c226_natdespsiops = '$c226_natdespsiops' ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Natureza da despesa Siops nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$c226_natdespecidade."-".$c226_natdespsiops;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Natureza da despesa Siops nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$c226_natdespecidade."-".$c226_natdespsiops;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$c226_natdespecidade."-".$c226_natdespsiops;
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
            $this->erro_sql   = "Record Vazio na Tabela:naturdessiops";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $c226_natdespecidade=null,$c226_natdespsiops=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturdessiops ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c226_natdespecidade!=null ) {
                $sql2 .= " where naturdessiops.c226_natdespecidade = '$c226_natdespecidade' ";
            }
            if ($c226_natdespsiops!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiops.c226_natdespsiops = '$c226_natdespsiops' ";
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
    function sql_query_file ( $c226_natdespecidade=null,$c226_natdespsiops=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturdessiops ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c226_natdespecidade!=null ) {
                $sql2 .= " where naturdessiops.c226_natdespecidade = '$c226_natdespecidade' ";
            }
            if ($c226_natdespsiops!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiops.c226_natdespsiops = '$c226_natdespsiops' ";
            }
            if ($c226_anousu!=null) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiops.c226_anousu = '$c226_anousu' ";
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

    function sql_query_siops ( $c226_natdespecidade=null, $c226_natdespsiops="", $c226_anousu="",$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturdessiops ";
        $sql .= ' inner join eledessiops on eledessiops.c227_eledespsiops = naturdessiops.c226_natdespsiops and naturdessiops.c226_anousu = eledessiops.c227_anousu ';
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c226_natdespecidade!=null ) {
                $sql2 .= " where naturdessiops.c226_natdespecidade = '$c226_natdespecidade' ";
            }
            if ($c226_natdespsiops!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiops.c226_natdespsiops = '$c226_natdespsiops' ";
            }
            if ($c226_anousu!=null) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturdessiops.c226_anousu = '$c226_anousu' ";
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
