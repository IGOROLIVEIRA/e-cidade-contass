<?php
//MODULO: orcamento
//CLASSE DA ENTIDADE orcmetasarrecadacaoreceita
class cl_metasarrecadacaoreceita {
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
  public $o203_sequencial = 0;
  public $o203_exercicio = 0;
  public $o203_bimestre01 = 0;
  public $o203_bimestre02 = 0;
  public $o203_bimestre03 = 0;
  public $o203_bimestre04 = 0;
  public $o203_bimestre05 = 0;
  public $o203_bimestre06 = 0;
  public $o203_instit = 0;
  public $o203_totalbimestres = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 o203_sequencial = int8   =  Sequencial
                 o203_exercicio  = int8   =  Exercício
                 o203_bimestre01 = float8 =  1º Bimestre 
                 o203_bimestre02 = float8 =  2º Bimestre 
                 o203_bimestre03 = float8 =  3º Bimestre 
                 o203_bimestre04 = float8 =  4º Bimestre 
                 o203_bimestre05 = float8 =  5º Bimestre 
                 o203_bimestre06 = float8 =  6º Bimestre 
                 o203_instit     = int8   = Instituição
                 o203_totalbimestres = float8 =  Total Bimestres
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("orcmetasarrecadacaoreceita");
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
       $this->o203_sequencial = ($this->o203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_sequencial"]:$this->o203_sequencial);
       $this->o203_exercicio = ($this->o203_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_exercicio"]:$this->o203_exercicio);
       $this->o203_bimestre01 = ($this->o203_bimestre01 == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_bimestre01"]:$this->o203_bimestre01);
       $this->o203_bimestre02 = ($this->o203_bimestre02 == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_bimestre02"]:$this->o203_bimestre02);
       $this->o203_bimestre03 = ($this->o203_bimestre03 == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_bimestre03"]:$this->o203_bimestre03);
       $this->o203_bimestre04 = ($this->o203_bimestre04 == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_bimestre04"]:$this->o203_bimestre04);
       $this->o203_bimestre05 = ($this->o203_bimestre05 == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_bimestre05"]:$this->o203_bimestre05);
       $this->o203_bimestre06 = ($this->o203_bimestre06 == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_bimestre06"]:$this->o203_bimestre06);
       $this->o203_instit = ($this->o203_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_instit"]:$this->o203_instit);
       $this->o203_totalbimestres = ($this->o203_totalbimestres == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_totalbimestres"]:$this->o203_totalbimestres);
     } else {
       $this->o203_sequencial = ($this->o203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o203_sequencial"]:$this->o203_sequencial);
     }
   }

  // funcao para inclusao
  function incluir () {
      $this->atualizacampos();
     if ($this->o203_exercicio == null ) {
       $this->erro_sql = " Campo ANO INICIAL LDO não informado.";
       $this->erro_campo = "o203_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_bimestre01 == null ) {
       $this->erro_sql = " Campo 1º Bimestre: não informado.";
       $this->erro_campo = "o203_bimestre01";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_bimestre02 == null ) {
       $this->erro_sql = " Campo 2º Bimestre: não informado.";
       $this->erro_campo = "o203_bimestre02";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_bimestre03 == null ) {
       $this->erro_sql = " Campo 3º Bimestre: não informado.";
       $this->erro_campo = "o203_bimestre03";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_bimestre04 == null ) {
       $this->erro_sql = " Campo 4º Bimestre: não informado.";
       $this->erro_campo = "o203_bimestre04";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_bimestre05 == null ) {
       $this->erro_sql = " Campo 5º Bimestre: não informado.";
       $this->erro_campo = "o203_bimestre05";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_bimestre06 == null ) {
       $this->erro_sql = " Campo 6º Bimestre: não informado.";
       $this->erro_campo = "o203_bimestre06";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "o203_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o203_totalbimestres == null ) {
      $this->erro_sql = " Campo Total Bimestres não informado.";
      $this->erro_campo = "o203_totalbimestres";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->o203_sequencial == "" || $this->o203_sequencial == null ) {
       $result = db_query("select nextval('orcmetasarrecadacaoreceita_o203_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: orcmetasarrecadacaoreceita_o203_sequencial_seq do campo: o203_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->o203_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from orcmetasarrecadacaoreceita_o203_sequencial_seq");
     }
     if (($this->o203_sequencial == null) || ($this->o203_sequencial == "") ) {
       $this->erro_sql = " Campo o203_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orcmetasarrecadacaoreceita(
                                       o203_sequencial
                                      ,o203_exercicio
                                      ,o203_bimestre01
                                      ,o203_bimestre02
                                      ,o203_bimestre03
                                      ,o203_bimestre04
                                      ,o203_bimestre05
                                      ,o203_bimestre06
                                      ,o203_instit   
                                      ,o203_totalbimestres     
                       )
                values (
                                $this->o203_sequencial
                               ,$this->o203_exercicio
                               ,$this->o203_bimestre01
                               ,$this->o203_bimestre02
                               ,$this->o203_bimestre03
                               ,$this->o203_bimestre04
                               ,$this->o203_bimestre05
                               ,$this->o203_bimestre06
                               ,$this->o203_instit
                               ,$this->o203_totalbimestres
                      )";

     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "orcmetasarrecadacaoreceita ($this->o203_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "orcmetasarrecadacaoreceita já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "orcmetasarrecadacaoreceita ($this->o203_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o203_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
    return true;
  }

  // funcao para alteracao
  function alterar ($o203_sequencial) {
     $this->o203_sequencial = $o203_sequencial;
     $this->atualizacampos();
     $sql = " update orcmetasarrecadacaoreceita set ";
     $virgula = "";
     if (trim($this->o203_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_sequencial"])) {
       $sql  .= $virgula." o203_sequencial = $this->o203_sequencial ";
       $virgula = ",";
       if (trim($this->o203_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "o203_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_exercicio"])) {
       $sql  .= $virgula." o203_exercicio = $this->o203_exercicio ";
       $virgula = ",";
       if (trim($this->o203_exercicio) == null ) {
         $this->erro_sql = " Campo ANO INICIAL LDO não informado.";
         $this->erro_campo = "o203_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_bimestre01)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_bimestre01"])) {
       $sql  .= $virgula." o203_bimestre01 = $this->o203_bimestre01 ";
       $virgula = ",";
       if (trim($this->o203_bimestre01) == null ) {
         $this->erro_sql = " Campo PIB DO ANO 1 não informado.";
         $this->erro_campo = "o203_bimestre01";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_bimestre02)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_bimestre02"])) {
       $sql  .= $virgula." o203_bimestre02 = $this->o203_bimestre02 ";
       $virgula = ",";
       if (trim($this->o203_bimestre02) == null ) {
         $this->erro_sql = " Campo PIB DO ANO 2 não informado.";
         $this->erro_campo = "o203_bimestre02";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_bimestre03)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_bimestre03"])) {
       $sql  .= $virgula." o203_bimestre03 = $this->o203_bimestre03 ";
       $virgula = ",";
       if (trim($this->o203_bimestre03) == null ) {
         $this->erro_sql = " Campo PIB DO ANO 3 não informado.";
         $this->erro_campo = "o203_bimestre03";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_bimestre04)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_bimestre04"])) {
       $sql  .= $virgula." o203_bimestre04 = $this->o203_bimestre04 ";
       $virgula = ",";
       if (trim($this->o203_bimestre04) == null ) {
         $this->erro_sql = " Campo RCL DO ANO 1 não informado.";
         $this->erro_campo = "o203_bimestre04";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_bimestre05)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_bimestre05"])) {
       $sql  .= $virgula." o203_bimestre05 = $this->o203_bimestre05 ";
       $virgula = ",";
       if (trim($this->o203_bimestre05) == null ) {
         $this->erro_sql = " Campo RCL DO ANO 2 não informado.";
         $this->erro_campo = "o203_bimestre05";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_bimestre06)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_bimestre06"])) {
       $sql  .= $virgula." o203_bimestre06 = $this->o203_bimestre06 ";
       $virgula = ",";
       if (trim($this->o203_bimestre06) == null ) {
         $this->erro_sql = " Campo RCL DO ANO 3 não informado.";
         $this->erro_campo = "o203_bimestre06";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_instit"])) {
       $sql  .= $virgula." o203_instit = $this->o203_instit ";
       $virgula = ",";
       if (trim($this->o203_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "o203_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o203_totalbimestres)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o203_totalbimestres"])) {
      $sql  .= $virgula." o203_totalbimestres = $this->o203_totalbimestres ";
      $virgula = ",";
      if (trim($this->o203_totalbimestres) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "o203_totalbimestres";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     $sql .= " where ";
     if ($o203_sequencial!=null) {
       $sql .= " o203_sequencial = $this->o203_sequencial";
     } 
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "orcmetasarrecadacaoreceita nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o203_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "orcmetasarrecadacaoreceita nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o203_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o203_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($o203_sequencial=null,$dbwhere=null) {

     $sql = " delete from orcmetasarrecadacaoreceita
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($o203_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " o203_sequencial = $o203_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "orcmetasarrecadacaoreceita nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o203_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "orcmetasarrecadacaoreceita nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o203_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o203_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:orcmetasarrecadacaoreceita";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $o203_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from orcmetasarrecadacaoreceita ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($o203_sequencial!=null ) {
         $sql2 .= " where orcmetasarrecadacaoreceita.o203_sequencial = $o203_sequencial ";
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
  function sql_query_file ( $o203_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from orcmetasarrecadacaoreceita ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($o203_sequencial!=null ) {
         $sql2 .= " where orcmetasarrecadacaoreceita.o203_sequencial = $o203_sequencial ";
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
