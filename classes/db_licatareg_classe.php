<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE licatareg
class cl_licatareg {
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
  public $l221_sequencial = 0;
  public $l221_licitacao = 0;
  public $l221_numata = null;
  public $l221_exercicio = null;
  public $l221_fornecedor = 0;
  public $l221_dataini_dia = null;
  public $l221_dataini_mes = null;
  public $l221_dataini_ano = null;
  public $l221_dataini = null;
  public $l221_datafinal_dia = null;
  public $l221_datafinal_mes = null;
  public $l221_datafinal_ano = null;
  public $l221_datafinal = null;
  public $l221_datapublica_dia = null;
  public $l221_datapublica_mes = null;
  public $l221_datapublica_ano = null;
  public $l221_datapublica = null;
  public $l221_veiculopublica = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 l221_sequencial = int8 = l221_sequencial
                 l221_licitacao = int8 = l221_licitacao
                 l221_numata = varchar(15) = l221_numata
                 l221_exercicio = varchar(4) = l221_exercicio
                 l221_fornecedor = int8 = l221_fornecedor
                 l221_dataini = date = l221_dataini
                 l221_datafinal = date = l221_datafinal
                 l221_datapublica = date = l221_datapublica
                 l221_veiculopublica = varchar(255) = l221_veiculopublica
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licatareg");
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
       $this->l221_sequencial = ($this->l221_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_sequencial"]:$this->l221_sequencial);
       $this->l221_licitacao = ($this->l221_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_licitacao"]:$this->l221_licitacao);
       $this->l221_numata = ($this->l221_numata == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_numata"]:$this->l221_numata);
       $this->l221_exercicio = ($this->l221_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_exercicio"]:$this->l221_exercicio);
       $this->l221_fornecedor = ($this->l221_fornecedor == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_fornecedor"]:$this->l221_fornecedor);
       if ($this->l221_dataini == "") {
         $this->l221_dataini_dia = ($this->l221_dataini_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_dataini_dia"]:$this->l221_dataini_dia);
         $this->l221_dataini_mes = ($this->l221_dataini_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_dataini_mes"]:$this->l221_dataini_mes);
         $this->l221_dataini_ano = ($this->l221_dataini_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_dataini_ano"]:$this->l221_dataini_ano);
         if ($this->l221_dataini_dia != "") {
            $this->l221_dataini = $this->l221_dataini_ano."-".$this->l221_dataini_mes."-".$this->l221_dataini_dia;
         }
       }
       if ($this->l221_datafinal == "") {
         $this->l221_datafinal_dia = ($this->l221_datafinal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_datafinal_dia"]:$this->l221_datafinal_dia);
         $this->l221_datafinal_mes = ($this->l221_datafinal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_datafinal_mes"]:$this->l221_datafinal_mes);
         $this->l221_datafinal_ano = ($this->l221_datafinal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_datafinal_ano"]:$this->l221_datafinal_ano);
         if ($this->l221_datafinal_dia != "") {
            $this->l221_datafinal = $this->l221_datafinal_ano."-".$this->l221_datafinal_mes."-".$this->l221_datafinal_dia;
         }
       }
       if ($this->l221_datapublica == "") {
         $this->l221_datapublica_dia = ($this->l221_datapublica_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_datapublica_dia"]:$this->l221_datapublica_dia);
         $this->l221_datapublica_mes = ($this->l221_datapublica_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_datapublica_mes"]:$this->l221_datapublica_mes);
         $this->l221_datapublica_ano = ($this->l221_datapublica_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_datapublica_ano"]:$this->l221_datapublica_ano);
         if ($this->l221_datapublica_dia != "") {
            $this->l221_datapublica = $this->l221_datapublica_ano."-".$this->l221_datapublica_mes."-".$this->l221_datapublica_dia;
         }
       }
       $this->l221_veiculopublica = ($this->l221_veiculopublica == ""?@$GLOBALS["HTTP_POST_VARS"]["l221_veiculopublica"]:$this->l221_veiculopublica);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () {
      $this->atualizacampos();
      if ($this->l221_sequencial == "" || $this->l221_sequencial == null) {
        $result = db_query("select nextval('licatareg_l221_sequencial_seq')");
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Verifique o cadastro da sequencia: liclicita_l20_codigo_seq do campo: l221_sequencial";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->l221_sequencial = pg_result($result, 0, 0);
    } else {
        $result = db_query("select last_value from licatareg_l221_sequencial_seq");
        if (($result != false) && (pg_result($result, 0, 0) < $this->l221_sequencial)) {
            $this->erro_sql = " Campo l221_sequencial maior que último número da sequencia.";
            $this->erro_banco = "Sequencia menor que este número.";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            $this->l221_sequencial = pg_result($result, 0, 0);
        }
    }
    if (($this->l221_sequencial == null) || ($this->l221_sequencial == "")) {
        $this->erro_sql = " Campo l221_sequencial nao declarado.";
        $this->erro_banco = "Chave Primaria zerada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
    }
     if ($this->l221_licitacao == null ) {
       $this->erro_sql = " Campo l221_licitacao não informado.";
       $this->erro_campo = "l221_licitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l221_numata == null ) {
       $this->erro_sql = " Campo l221_numata não informado.";
       $this->erro_campo = "l221_numata";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l221_exercicio == null ) {
       $this->erro_sql = " Campo l221_exercicio não informado.";
       $this->erro_campo = "l221_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l221_fornecedor == null ) {
       $this->erro_sql = " Campo l221_fornecedor não informado.";
       $this->erro_campo = "l221_fornecedor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l221_dataini == null ) {
       $this->erro_sql = " Campo l221_dataini não informado.";
       $this->erro_campo = "l221_dataini_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l221_datafinal == null ) {
       $this->erro_sql = " Campo l221_datafinal não informado.";
       $this->erro_campo = "l221_datafinal_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     $sql = "insert into licatareg(
                                       l221_sequencial
                                      ,l221_licitacao
                                      ,l221_numata
                                      ,l221_exercicio
                                      ,l221_fornecedor
                                      ,l221_dataini
                                      ,l221_datafinal
                                      ,l221_datapublica
                                      ,l221_veiculopublica
                       )
                values (
                                $this->l221_sequencial
                               ,$this->l221_licitacao
                               ,'$this->l221_numata'
                               ,'$this->l221_exercicio'
                               ,$this->l221_fornecedor
                               ,".($this->l221_dataini == "null" || $this->l221_dataini == ""?"null":"'".$this->l221_dataini."'")."
                               ,".($this->l221_datafinal == "null" || $this->l221_datafinal == ""?"null":"'".$this->l221_datafinal."'")."
                               ,".($this->l221_datapublica == "null" || $this->l221_datapublica == ""?"null":"'".$this->l221_datapublica."'")."
                               ,'$this->l221_veiculopublica'
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "licatareg () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "licatareg já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "licatareg () nao Incluído. Inclusao Abortada.";
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
     $sql = " update licatareg set ";
     $virgula = "";
     if (trim($this->l221_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l221_sequencial"])) {
       $sql  .= $virgula." l221_sequencial = $this->l221_sequencial ";
       $virgula = ",";
       if (trim($this->l221_sequencial) == null ) {
         $this->erro_sql = " Campo l221_sequencial não informado.";
         $this->erro_campo = "l221_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l221_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l221_licitacao"])) {
       $sql  .= $virgula." l221_licitacao = $this->l221_licitacao ";
       $virgula = ",";
       if (trim($this->l221_licitacao) == null ) {
         $this->erro_sql = " Campo l221_licitacao não informado.";
         $this->erro_campo = "l221_licitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l221_numata)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l221_numata"])) {
       $sql  .= $virgula." l221_numata = '$this->l221_numata' ";
       $virgula = ",";
       if (trim($this->l221_numata) == null ) {
         $this->erro_sql = " Campo l221_numata não informado.";
         $this->erro_campo = "l221_numata";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l221_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l221_exercicio"])) {
       $sql  .= $virgula." l221_exercicio = '$this->l221_exercicio' ";
       $virgula = ",";
       if (trim($this->l221_exercicio) == null ) {
         $this->erro_sql = " Campo l221_exercicio não informado.";
         $this->erro_campo = "l221_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l221_fornecedor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l221_fornecedor"])) {
       $sql  .= $virgula." l221_fornecedor = $this->l221_fornecedor ";
       $virgula = ",";
       if (trim($this->l221_fornecedor) == null ) {
         $this->erro_sql = " Campo l221_fornecedor não informado.";
         $this->erro_campo = "l221_fornecedor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l221_dataini)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l221_dataini_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l221_dataini_dia"] !="") ) {
       $sql  .= $virgula." l221_dataini = '$this->l221_dataini' ";
       $virgula = ",";
       if (trim($this->l221_dataini) == null ) {
         $this->erro_sql = " Campo l221_dataini não informado.";
         $this->erro_campo = "l221_dataini_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["l221_dataini_dia"])) {
         $sql  .= $virgula." l221_dataini = null ";
         $virgula = ",";
         if (trim($this->l221_dataini) == null ) {
           $this->erro_sql = " Campo l221_dataini não informado.";
           $this->erro_campo = "l221_dataini_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->l221_datafinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l221_datafinal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l221_datafinal_dia"] !="") ) {
       $sql  .= $virgula." l221_datafinal = '$this->l221_datafinal' ";
       $virgula = ",";
       if (trim($this->l221_datafinal) == null ) {
         $this->erro_sql = " Campo l221_datafinal não informado.";
         $this->erro_campo = "l221_datafinal_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["l221_datafinal_dia"])) {
         $sql  .= $virgula." l221_datafinal = null ";
         $virgula = ",";
         if (trim($this->l221_datafinal) == null ) {
           $this->erro_sql = " Campo l221_datafinal não informado.";
           $this->erro_campo = "l221_datafinal_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }

     $sql .= " where ";
$sql .= "l221_sequencial = '$oid'";     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licatareg nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "licatareg nao foi Alterado. Alteracao Executada.\\n";
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

     $sql = " delete from licatareg
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "l221_sequencial = $oid";
     } else {
       $sql2 = $dbwhere;
     }

     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licatareg nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "licatareg nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:licatareg";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from licatareg ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where licatareg.oid = '$oid'";
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
     $sql .= " from licatareg ";
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

  function sql_query_for ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from licatareg inner join cgm on
    cgm.z01_numcgm = licatareg.l221_fornecedor ";
    $sql .= " inner join liclicita on l20_codigo = l221_licitacao ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $oid != "" && $oid != null) {
         $sql2 = " where licatareg.oid = '$oid'";
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
