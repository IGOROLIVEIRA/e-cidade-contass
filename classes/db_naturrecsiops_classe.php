<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE naturrecsiops/
class cl_naturrecsiops {
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
    public $c230_natrececidade = null;
    public $c230_natrecsiops = null;
    public $c230_anousu = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 c230_natrececidade = varchar(14) = E-Cidade
                 c230_natrecsiops   = varchar(14) = Siops
                 c230_anousu = int4 = Ano
                 ";


    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("naturrecsiops");
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
            $this->c230_natrececidade = ($this->c230_natrececidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c230_natrececidade"]:$this->c230_natrececidade);
            $this->c230_natrecsiops = ($this->c230_natrecsiops == ""?@$GLOBALS["HTTP_POST_VARS"]["c230_natrecsiops"]:$this->c230_natrecsiops);
            $this->c230_anousu = ($this->c230_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c230_anousu"]:$this->c230_anousu);
        } else {
            $this->c230_natrececidade = ($this->c230_natrececidade == ""?@$GLOBALS["HTTP_POST_VARS"]["c230_natrececidade"]:$this->c230_natrececidade);
            $this->c230_natrecsiops = ($this->c230_natrecsiops == ""?@$GLOBALS["HTTP_POST_VARS"]["c230_natrecsiops"]:$this->c230_natrecsiops);
            $this->c230_anousu = ($this->c230_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c230_anousu"]:$this->c230_anousu);
        }
    }

    // funcao para inclusao
    function incluir ($c230_natrececidade,$c230_natrecsiops, $c230_anousu) {
        $this->atualizacampos();
        $this->c230_natrececidade = $c230_natrececidade;
        $this->c230_natrecsiops = $c230_natrecsiops;
        if (($this->c230_natrececidade == null) || ($this->c230_natrececidade == "") ) {
            $this->erro_sql = " Campo c230_natrececidade nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if (($this->c230_natrecsiops == null) || ($this->c230_natrecsiops == "") ) {
            $this->erro_sql = " Campo c230_natrecsiops nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into naturrecsiops(
                                       c230_natrececidade
                                      ,c230_natrecsiops
                                      ,c230_anousu
                       )
                values (
                                '$this->c230_natrececidade'
                               ,'$this->c230_natrecsiops'
                               ,'$this->c230_anousu'
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "Natureza da receita Siops ($this->c230_natrececidade."-".$this->c230_natrecsiops) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Natureza da receita Siops já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "Natureza da receita Siops ($this->c230_natrececidade."-".$this->c230_natrecsiops) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->c230_natrececidade."-".$this->c230_natrecsiops;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        return true;
    }

    // funcao para alteracao
    function alterar ($c230_natrececidade=null,$c230_natrecsiops=null) {
        $this->atualizacampos();
        $sql = " update naturrecsiops set ";
        $virgula = "";
        if (trim($this->c230_natrececidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c230_natrececidade"])) {
            $sql  .= $virgula." c230_natrececidade = '$this->c230_natrececidade' ";
            $virgula = ",";
            if (trim($this->c230_natrececidade) == null ) {
                $this->erro_sql = " Campo Natureza receita E-cidade não informado.";
                $this->erro_campo = "c230_natrececidade";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c230_natrecsiops)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c230_natrecsiops"])) {
            $sql  .= $virgula." c230_natrecsiops = '$this->c230_natrecsiops' ";
            $virgula = ",";
            if (trim($this->c230_natrecsiops) == null ) {
                $this->erro_sql = " Campo Natureza receita Siope não informado.";
                $this->erro_campo = "c230_natrecsiops";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " c230_anousu = ".$this->c230_anousu." ";
        $sql .= " where ";
        if ($c230_natrececidade!=null) {
            $sql .= " c230_natrececidade = '$this->c230_natrececidade'";
        }
        if ($c230_natrecsiops!=null) {
            $sql .= " and  c230_natrecsiops = '$this->c230_natrecsiops'";
        }

        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Natureza da receita Siops nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->c230_natrececidade."-".$this->c230_natrecsiops;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Natureza da receita Siops nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->c230_natrececidade."-".$this->c230_natrecsiops;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->c230_natrececidade."-".$this->c230_natrecsiops;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($c230_natrececidade=null,$c230_natrecsiops=null,$dbwhere=null) {

        $sql = " delete from naturrecsiops
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($c230_natrececidade != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c230_natrececidade = '$c230_natrececidade' ";
            }
            if ($c230_natrecsiops != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c230_natrecsiops = '$c230_natrecsiops' ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Natureza da receita Siops nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$c230_natrececidade."-".$c230_natrecsiops;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Natureza da receita Siops nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$c230_natrececidade."-".$c230_natrecsiops;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$c230_natrececidade."-".$c230_natrecsiops;
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
            $this->erro_sql   = "Record Vazio na Tabela:naturrecsiops";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $c230_natrececidade=null,$c230_natrecsiops=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturrecsiops ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c230_natrececidade!=null ) {
                $sql2 .= " where naturrecsiops.c230_natrececidade = '$c230_natrececidade' ";
            }
            if ($c230_natrecsiops!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturrecsiops.c230_natrecsiops = '$c230_natrecsiops' ";
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
    function sql_query_file ( $c230_natrececidade=null,$c230_natrecsiops=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from naturrecsiops ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c230_natrececidade!=null ) {
                $sql2 .= " where naturrecsiops.c230_natrececidade = '$c230_natrececidade' ";
            }
            if ($c230_natrecsiops!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturrecsiops.c230_natrecsiops = '$c230_natrecsiops' ";
            }
            if ($c230_anousu!=null) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturrecsiops.c230_anousu = '$c230_anousu' ";
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

    function sql_query_siops ( $c230_natrececidade=null, $c230_natrecsiops="", $c230_anousu="",$campos="*",$ordem=null,$dbwhere="") {

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
        $sql .= " from naturrecsiops ";

        if ($c230_anousu >= 2021) {
            
            if(substr($c230_natrececidade, 0, 1) == '9') {
                $sql .= ' inner join elerecsiops on substr(c230_natrecsiops,3,8) = c231_elerecsiops AND c230_anousu = c231_anousu';
            } else {
                $sql .= ' inner join elerecsiops on substr(c230_natrecsiops,1,8) = c231_elerecsiops AND c230_anousu = c231_anousu';
            }
            
        } else {
            $sql .= ' inner join elerecsiops on elerecsiops.c231_elerecsiops = substr(naturrecsiops.c230_natrecsiops, 1, 10) and naturrecsiops.c230_anousu = elerecsiops.c231_anousu ';
        }

        $sql2 = "";
        if ($dbwhere=="") {
            if ($c230_natrececidade!=null ) {
                $sql2 .= " where naturrecsiops.c230_natrececidade = '$c230_natrececidade' ";
            }
            if ($c230_natrecsiops!=null ) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturrecsiops.c230_natrecsiops = '$c230_natrecsiops' ";
            }
            if ($c230_anousu!=null) {
                if ($sql2!="") {
                    $sql2 .= " and ";
                } else {
                    $sql2 .= " where ";
                }
                $sql2 .= " naturrecsiops.c230_anousu = '$c230_anousu' ";
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
