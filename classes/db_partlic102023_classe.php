<?php
//MODULO: sicom
//CLASSE DA ENTIDADE partlic102023
class cl_partlic102023 { 
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
  public $si203_sequencial = 0; 
  public $si203_tiporegistro = 0; 
  public $si203_codorgao = 0; 
  public $si203_codunidadesub = null; 
  public $si203_exerciciolicitacao = 0; 
  public $si203_nroprocessolicitatorio = 0; 
  public $si203_tipodocumento = 0; 
  public $si203_nrodocumento = null; 
  var $si203_mes = 0;
  var $si203_instit = 0;
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 si203_sequencial = int8 = si203_sequencial 
                 si203_tiporegistro = int8 = si203_tiporegistro 
                 si203_codorgao = int8 = si203_codorgao 
                 si203_codunidadesub = varchar(8) = si203_codunidadesub 
                 si203_exerciciolicitacao = int8 = si203_exerciciolicitacao 
                 si203_nroprocessolicitatorio = int8 = si203_nroprocessolicitatorio 
                 si203_tipodocumento = int8 = si203_tipodocumento 
                 si203_nrodocumento = varchar(14) = si203_nrodocumento 
                 si203_mes = int8 = Mês
                 si203_instit = int8 = Instituição
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("partlic102023"); 
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
       $this->si203_sequencial = ($this->si203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_sequencial"]:$this->si203_sequencial);
       $this->si203_tiporegistro = ($this->si203_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"]:$this->si203_tiporegistro);
       $this->si203_codorgao = ($this->si203_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_codorgao"]:$this->si203_codorgao);
       $this->si203_codunidadesub = ($this->si203_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_codunidadesub"]:$this->si203_codunidadesub);
       $this->si203_exerciciolicitacao = ($this->si203_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_exerciciolicitacao"]:$this->si203_exerciciolicitacao);
       $this->si203_nroprocessolicitatorio = ($this->si203_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_nroprocessolicitatorio"]:$this->si203_nroprocessolicitatorio);
       $this->si203_tipodocumento = ($this->si203_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_tipodocumento"]:$this->si203_tipodocumento);
       $this->si203_nrodocumento = ($this->si203_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_nrodocumento"]:$this->si203_nrodocumento);
       $this->si203_mes = ($this->si203_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_mes"] : $this->si203_mes);
       $this->si203_instit = ($this->si203_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_instit"] : $this->si203_instit);
      } else {
     }
   }

  // funcao para inclusao
  function incluir ($si203_sequencial) { 
      $this->atualizacampos();
     if ($this->si203_sequencial == null ) { 
      $result = db_query("select nextval('partlic102023_si203_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: partlic102023_si203_sequencial_seq do campo: si203_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si203_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from partlic102023_si203_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si203_sequencial)) {
        $this->erro_sql = " Campo si203_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si203_sequencial = $si203_sequencial;
      }
     }
     if ($this->si203_tiporegistro == null ) { 
       $this->erro_sql = " Campo si203_tiporegistro não informado.";
       $this->erro_campo = "si203_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si203_codorgao == null ) { 
       $this->erro_sql = " Campo si203_codorgao não informado.";
       $this->erro_campo = "si203_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si203_codunidadesub == null ) { 
       $this->erro_sql = " Campo si203_codunidadesub não informado.";
       $this->erro_campo = "si203_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si203_exerciciolicitacao == null ) { 
       $this->erro_sql = " Campo si203_exerciciolicitacao não informado.";
       $this->erro_campo = "si203_exerciciolicitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si203_nroprocessolicitatorio == null ) { 
       $this->erro_sql = " Campo si203_nroprocessolicitatorio não informado.";
       $this->erro_campo = "si203_nroprocessolicitatorio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si203_tipodocumento == null ) { 
       $this->erro_sql = " Campo si203_tipodocumento não informado.";
       $this->erro_campo = "si203_tipodocumento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si203_nrodocumento == null ) { 
       $this->erro_sql = " Campo si203_nrodocumento não informado.";
       $this->erro_campo = "si203_nrodocumento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si203_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si203_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si203_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si203_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
     $sql = "insert into partlic102023(
                                       si203_sequencial 
                                      ,si203_tiporegistro 
                                      ,si203_codorgao 
                                      ,si203_codunidadesub 
                                      ,si203_exerciciolicitacao 
                                      ,si203_nroprocessolicitatorio 
                                      ,si203_tipodocumento 
                                      ,si203_nrodocumento 
                                      ,si203_mes
                                      ,si203_instit
                       )
                values (
                                $this->si203_sequencial 
                               ,$this->si203_tiporegistro 
                               ,$this->si203_codorgao 
                               ,'$this->si203_codunidadesub' 
                               ,$this->si203_exerciciolicitacao 
                               ,$this->si203_nroprocessolicitatorio 
                               ,$this->si203_tipodocumento 
                               ,'$this->si203_nrodocumento' 
                               ,$this->si203_mes
                               ,$this->si203_instit
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "partlic102023 () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "partlic102023 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "partlic102023 () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $oid=null ) { 
      $this->atualizacampos();
     $sql = " update partlic102023 set ";
     $virgula = "";
     if (trim($this->si203_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_sequencial"])) { 
       $sql  .= $virgula." si203_sequencial = $this->si203_sequencial ";
       $virgula = ",";
       if (trim($this->si203_sequencial) == null ) { 
         $this->erro_sql = " Campo si203_sequencial não informado.";
         $this->erro_campo = "si203_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"])) { 
       $sql  .= $virgula." si203_tiporegistro = $this->si203_tiporegistro ";
       $virgula = ",";
       if (trim($this->si203_tiporegistro) == null ) { 
         $this->erro_sql = " Campo si203_tiporegistro não informado.";
         $this->erro_campo = "si203_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codorgao"])) { 
       $sql  .= $virgula." si203_codorgao = $this->si203_codorgao ";
       $virgula = ",";
       if (trim($this->si203_codorgao) == null ) { 
         $this->erro_sql = " Campo si203_codorgao não informado.";
         $this->erro_campo = "si203_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codunidadesub"])) { 
       $sql  .= $virgula." si203_codunidadesub = '$this->si203_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si203_codunidadesub) == null ) { 
         $this->erro_sql = " Campo si203_codunidadesub não informado.";
         $this->erro_campo = "si203_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_exerciciolicitacao"])) { 
       $sql  .= $virgula." si203_exerciciolicitacao = $this->si203_exerciciolicitacao ";
       $virgula = ",";
       if (trim($this->si203_exerciciolicitacao) == null ) { 
         $this->erro_sql = " Campo si203_exerciciolicitacao não informado.";
         $this->erro_campo = "si203_exerciciolicitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_nroprocessolicitatorio"])) { 
       $sql  .= $virgula." si203_nroprocessolicitatorio = $this->si203_nroprocessolicitatorio ";
       $virgula = ",";
       if (trim($this->si203_nroprocessolicitatorio) == null ) { 
         $this->erro_sql = " Campo si203_nroprocessolicitatorio não informado.";
         $this->erro_campo = "si203_nroprocessolicitatorio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_tipodocumento"])) { 
       $sql  .= $virgula." si203_tipodocumento = $this->si203_tipodocumento ";
       $virgula = ",";
       if (trim($this->si203_tipodocumento) == null ) { 
         $this->erro_sql = " Campo si203_tipodocumento não informado.";
         $this->erro_campo = "si203_tipodocumento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_nrodocumento"])) { 
       $sql  .= $virgula." si203_nrodocumento = '$this->si203_nrodocumento' ";
       $virgula = ",";
       if (trim($this->si203_nrodocumento) == null ) { 
         $this->erro_sql = " Campo si203_nrodocumento não informado.";
         $this->erro_campo = "si203_nrodocumento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si203_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_mes"])) {
      $sql .= $virgula . " si203_mes = $this->si203_mes ";
      $virgula = ",";
      if (trim($this->si203_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si203_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si203_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_instit"])) {
      $sql .= $virgula . " si203_instit = $this->si203_instit ";
      $virgula = ",";
      if (trim($this->si203_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si203_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "partlic102023 nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "partlic102023 nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $oid=null ,$dbwhere=null) { 

     $sql = " delete from partlic102023
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "oid = '$oid'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "partlic102023 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "partlic102023 nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:partlic102023";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $oid = null,$campos="partlic102023.oid,*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from partlic102023 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where partlic102023.oid = '$oid'";
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
     $sql .= " from partlic102023 ";
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
