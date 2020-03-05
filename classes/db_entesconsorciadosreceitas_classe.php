<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE entesconsorciadosreceitas
class cl_entesconsorciadosreceitas {
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
  public $c216_sequencial = null;
  public $c216_enteconsorciado = 0;
  public $c216_tiporeceita = 0;
  public $c216_receita = 0;
  public $c216_saldo3112 = 0;
  public $c216_anousu = null;
  public $c216_percentual = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 c216_sequencial = int4 =
                 c216_enteconsorciado = int4 = Ente consorciado
                 c216_tiporeceita = int4 = Tipo receita
                 c216_receita = int4 = Receita
                 c216_saldo3112 = float4 = Saldo3112
                 c216_anousu = int4 = AnoUso
                 c216_percentual = float4 = Percentual
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("entesconsorciadosreceitas");
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
       $this->c216_sequencial = ($this->c216_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_sequencial"]:$this->c216_sequencial);
       $this->c216_enteconsorciado = ($this->c216_enteconsorciado == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_enteconsorciado"]:$this->c216_enteconsorciado);
       $this->c216_tiporeceita = ($this->c216_tiporeceita == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_tiporeceita"]:$this->c216_tiporeceita);
       $this->c216_receita = ($this->c216_receita == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_receita"]:$this->c216_receita);
       $this->c216_saldo3112 = ($this->c216_saldo3112 == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_saldo3112"]:$this->c216_saldo3112);
       $this->c216_percentual = ($this->c216_percentual == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_percentual"]:$this->c216_percentual);
       $this->c216_anousu = ($this->c216_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_anousu"]:$this->c216_anousu);
     } else {
       $this->c216_sequencial = ($this->c216_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c216_sequencial"]:$this->c216_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($c216_sequencial) {
      $this->atualizacampos();
     if ($this->c216_enteconsorciado == null ) {
       $this->erro_sql = " Campo Ente consorciado não informado.";
       $this->erro_campo = "c216_enteconsorciado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c216_tiporeceita == null ) {
       $this->erro_sql = " Campo Tipo receita não informado.";
       $this->erro_campo = "c216_tiporeceita";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c216_receita == null ) {
       $this->erro_sql = " Campo Receita não informado.";
       $this->erro_campo = "c216_receita";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c216_saldo3112 == null ) {
       $this->erro_sql = " Campo Saldo3112 não informado.";
       $this->erro_campo = "c216_saldo3112";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c216_anousu == null ) {
       $this->c216_anousu = 'null';
     }
     if ($c216_sequencial == "" || $c216_sequencial == null ) {
       $result = db_query("select nextval('entesconsorciadosreceitas_c216_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: entesconsorciadosreceitas_c216_sequencial_seq do campo: c216_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c216_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from entesconsorciadosreceitas_c216_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $c216_sequencial)) {
         $this->erro_sql = " Campo c216_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->c216_sequencial = $c216_sequencial;
       }
     }
     if (($this->c216_sequencial == null) || ($this->c216_sequencial == "") ) {
       $this->erro_sql = " Campo c216_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into entesconsorciadosreceitas(
                                       c216_sequencial
                                      ,c216_enteconsorciado
                                      ,c216_tiporeceita
                                      ,c216_receita
                                      ,c216_saldo3112
                                      ,c216_anousu
                                      ,c216_percentual
                       )
                values (
                                $this->c216_sequencial
                               ,$this->c216_enteconsorciado
                               ,$this->c216_tiporeceita
                               ,$this->c216_receita
                               ,$this->c216_saldo3112
                               ,$this->c216_anousu
                               ,$this->c216_percentual
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "entes consorciados receitas ($this->c216_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "entes consorciados receitas já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "entes consorciados receitas ($this->c216_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c216_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

    return true;
  }

  // funcao para alteracao
  function alterar ($c216_sequencial=null) {
      $this->atualizacampos();
     $sql = " update entesconsorciadosreceitas set ";
     $virgula = "";
     if (trim($this->c216_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c216_sequencial"])) {
       $sql  .= $virgula." c216_sequencial = $this->c216_sequencial ";
       $virgula = ",";
       if (trim($this->c216_sequencial) == null ) {
         $this->erro_sql = " Campo  não informado.";
         $this->erro_campo = "c216_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c216_enteconsorciado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c216_enteconsorciado"])) {
       $sql  .= $virgula." c216_enteconsorciado = $this->c216_enteconsorciado ";
       $virgula = ",";
       if (trim($this->c216_enteconsorciado) == null ) {
         $this->erro_sql = " Campo Ente consorciado não informado.";
         $this->erro_campo = "c216_enteconsorciado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c216_tiporeceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c216_tiporeceita"])) {
       $sql  .= $virgula." c216_tiporeceita = $this->c216_tiporeceita ";
       $virgula = ",";
       if (trim($this->c216_tiporeceita) == null ) {
         $this->erro_sql = " Campo Tipo receita não informado.";
         $this->erro_campo = "c216_tiporeceita";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c216_receita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c216_receita"])) {
       $sql  .= $virgula." c216_receita = $this->c216_receita ";
       $virgula = ",";
       if (trim($this->c216_receita) == null ) {
         $this->erro_sql = " Campo Receita não informado.";
         $this->erro_campo = "c216_receita";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c216_saldo3112)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c216_saldo3112"])) {
       $sql  .= $virgula." c216_saldo3112 = $this->c216_saldo3112 ";
       $virgula = ",";
       if (trim($this->c216_saldo3112) == null ) {
         $this->erro_sql = " Campo Saldo3112 não informado.";
         $this->erro_campo = "c216_saldo3112";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }

     if (trim($this->c216_percentual)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c216_percentual"])) {
       $sql  .= $virgula." c216_percentual = $this->c216_percentual ";
       $virgula = ",";
       if (trim($this->c216_percentual) == null ) {
         $this->erro_sql = " Campo percentual não informado.";
         $this->erro_campo = "c216_percentual";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c216_anousu) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c216_anousu"])) {
       $sql  .= $virgula." c216_anousu = {$this->c216_anousu} ";
       $virgula = ",";
     }
     $sql .= " where ";
     if ($c216_sequencial!=null) {
       $sql .= " c216_sequencial = $this->c216_sequencial";
     }

     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "entes consorciados receitas nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c216_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "entes consorciados receitas nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c216_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c216_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($c216_sequencial=null,$dbwhere=null) {

     $sql = " delete from entesconsorciadosreceitas
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($c216_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c216_sequencial = $c216_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "entes consorciados receitas nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c216_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "entes consorciados receitas nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c216_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c216_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:entesconsorciadosreceitas";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $c216_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from entesconsorciadosreceitas ";
     $sql .= "      inner join orcfontes  on  orcfontes.o57_codfon = entesconsorciadosreceitas.c216_receita and orcfontes.o57_anousu=c216_anousu";
     $sql .= "      inner join entesconsorciados  on  entesconsorciados.c215_sequencial = entesconsorciadosreceitas.c216_enteconsorciado";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = entesconsorciados.c215_cgm";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c216_sequencial!=null ) {
         $sql2 .= " where entesconsorciadosreceitas.c216_sequencial = $c216_sequencial ";
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
  function sql_query_file ( $c216_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from entesconsorciadosreceitas ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c216_sequencial!=null ) {
         $sql2 .= " where entesconsorciadosreceitas.c216_sequencial = $c216_sequencial ";
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
