<?php
//MODULO: Controle Interno
//CLASSE DA ENTIDADE lancamverifaudit
class cl_lancamverifaudit { 
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
  public $ci05_codlan = 0; 
  public $ci05_codproc = 0; 
  public $ci05_codquestao = 0; 
  public $ci05_inianalise_dia = null; 
  public $ci05_inianalise_mes = null; 
  public $ci05_inianalise_ano = null; 
  public $ci05_inianalise = null; 
  public $ci05_atendquestaudit = 0; 
  public $ci05_achados = null; 
  public $ci05_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 ci05_codlan = int4 = Código 
                 ci05_codproc = int4 = Código do Processo de Auditoria 
                 ci05_codquestao = int4 = Código do Processo da Questão 
                 ci05_inianalise = date = Início Análise 
                 ci05_atendquestaudit = bool = Atende à questão de auditoria 
                 ci05_achados = varchar(500) = Achados 
                 ci05_instit = int4 = Instituição 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("lancamverifaudit"); 
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
       $this->ci05_codlan = ($this->ci05_codlan == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_codlan"]:$this->ci05_codlan);
       $this->ci05_codproc = ($this->ci05_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_codproc"]:$this->ci05_codproc);
       $this->ci05_codquestao = ($this->ci05_codquestao == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_codquestao"]:$this->ci05_codquestao);
       if ($this->ci05_inianalise == "") {
         $this->ci05_inianalise_dia = ($this->ci05_inianalise_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_inianalise_dia"]:$this->ci05_inianalise_dia);
         $this->ci05_inianalise_mes = ($this->ci05_inianalise_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_inianalise_mes"]:$this->ci05_inianalise_mes);
         $this->ci05_inianalise_ano = ($this->ci05_inianalise_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_inianalise_ano"]:$this->ci05_inianalise_ano);
         if ($this->ci05_inianalise_dia != "") {
            $this->ci05_inianalise = $this->ci05_inianalise_ano."-".$this->ci05_inianalise_mes."-".$this->ci05_inianalise_dia;
         }
       }
       $this->ci05_atendquestaudit = ($this->ci05_atendquestaudit == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_atendquestaudit"]:$this->ci05_atendquestaudit);
       $this->ci05_achados = ($this->ci05_achados == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_achados"]:$this->ci05_achados);
       $this->ci05_instit = ($this->ci05_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["ci05_instit"]:$this->ci05_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir ($ci05_codlan=null) { 
      $this->atualizacampos();

      if($ci05_codlan == null || $ci05_codlan == ""){ 
        $result = db_query("select nextval('contint_ci05_codlan_seq')");
        if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contint_ci05_codlan_seq do campo: ci05_codlan"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->ci05_codlan = pg_result($result,0,0); 
      }else{
       $result = db_query("select last_value from contint_ci05_codlan_seq");
       if(($result != false) && (pg_result($result,0,0) < $ci05_codlan)){
         $this->erro_sql = " Campo ci05_codlan maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ci05_codlan = $ci05_codlan; 
       }
     }
     if ($this->ci05_codproc == null ) { 
       $this->erro_sql = " Campo Código do Processo de Auditoria não informado.";
       $this->erro_campo = "ci05_codproc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci05_codquestao == null ) { 
       $this->erro_sql = " Campo Código do Processo da Questão não informado.";
       $this->erro_campo = "ci05_codquestao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci05_inianalise == null ) { 
       $this->erro_sql = " Campo Início Análise não informado.";
       $this->erro_campo = "ci05_inianalise_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci05_atendquestaudit == null ) { 
       $this->erro_sql = " Campo Atende à questão de auditoria não informado.";
       $this->erro_campo = "ci05_atendquestaudit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci05_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "ci05_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into lancamverifaudit(
                                       ci05_codlan 
                                      ,ci05_codproc 
                                      ,ci05_codquestao 
                                      ,ci05_inianalise 
                                      ,ci05_atendquestaudit 
                                      ,ci05_achados 
                                      ,ci05_instit 
                       )
                values (
                                $this->ci05_codlan 
                               ,$this->ci05_codproc 
                               ,$this->ci05_codquestao 
                               ,".($this->ci05_inianalise == "null" || $this->ci05_inianalise == ""?"null":"'".$this->ci05_inianalise."'")." 
                               ,'$this->ci05_atendquestaudit' 
                               ,'$this->ci05_achados' 
                               ,$this->ci05_instit 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Tipo da Auditoria () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Tipo da Auditoria já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Tipo da Auditoria () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $ci05_codlan=null ) { 
      $this->atualizacampos();
     $sql = " update lancamverifaudit set ";
     $virgula = "";
     if (trim($this->ci05_codlan)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci05_codlan"])) { 
       $sql  .= $virgula." ci05_codlan = $this->ci05_codlan ";
       $virgula = ",";
       if (trim($this->ci05_codlan) == null ) { 
         $this->erro_sql = " Campo Código não informado.";
         $this->erro_campo = "ci05_codlan";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci05_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci05_codproc"])) { 
       $sql  .= $virgula." ci05_codproc = $this->ci05_codproc ";
       $virgula = ",";
       if (trim($this->ci05_codproc) == null ) { 
         $this->erro_sql = " Campo Código do Processo de Auditoria não informado.";
         $this->erro_campo = "ci05_codproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci05_codquestao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci05_codquestao"])) { 
       $sql  .= $virgula." ci05_codquestao = $this->ci05_codquestao ";
       $virgula = ",";
       if (trim($this->ci05_codquestao) == null ) { 
         $this->erro_sql = " Campo Código do Processo da Questão não informado.";
         $this->erro_campo = "ci05_codquestao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci05_inianalise)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci05_inianalise_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ci05_inianalise_dia"] !="") ) { 
       $sql  .= $virgula." ci05_inianalise = '$this->ci05_inianalise' ";
       $virgula = ",";
       if (trim($this->ci05_inianalise) == null ) { 
         $this->erro_sql = " Campo Início Análise não informado.";
         $this->erro_campo = "ci05_inianalise_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["ci05_inianalise_dia"])) { 
         $sql  .= $virgula." ci05_inianalise = null ";
         $virgula = ",";
         if (trim($this->ci05_inianalise) == null ) { 
           $this->erro_sql = " Campo Início Análise não informado.";
           $this->erro_campo = "ci05_inianalise_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->ci05_atendquestaudit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci05_atendquestaudit"])) { 
       $sql  .= $virgula." ci05_atendquestaudit = '$this->ci05_atendquestaudit' ";
       $virgula = ",";
       if (trim($this->ci05_atendquestaudit) == null ) { 
         $this->erro_sql = " Campo Atende à questão de auditoria não informado.";
         $this->erro_campo = "ci05_atendquestaudit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci05_achados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci05_achados"])) { 
       $sql  .= $virgula." ci05_achados = '$this->ci05_achados' ";
       $virgula = ",";
     }
     if (trim($this->ci05_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci05_instit"])) { 
       $sql  .= $virgula." ci05_instit = $this->ci05_instit ";
       $virgula = ",";
       if (trim($this->ci05_instit) == null ) { 
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "ci05_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "ci05_codlan = '$ci05_codlan'";     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipo da Auditoria nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Tipo da Auditoria nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $ci05_codlan=null ,$dbwhere=null) { 

     $sql = " delete from lancamverifaudit
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "ci05_codlan = '$ci05_codlan'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipo da Auditoria nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Tipo da Auditoria nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:lancamverifaudit";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $ci05_codlan = null,$campos="lancamverifaudit.ci05_codlan,*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from lancamverifaudit ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $ci05_codlan != "" && $ci05_codlan != null) {
          $sql2 = " where lancamverifaudit.ci05_codlan = '$ci05_codlan'";
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
  function sql_query_file ( $ci05_codlan = null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from lancamverifaudit ";
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
