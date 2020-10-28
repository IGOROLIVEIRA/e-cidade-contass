<?
//MODULO: Controle Interno
//CLASSE DA ENTIDADE matrizachadosaudit
class cl_matrizachadosaudit { 
  // cria variaveis de erro 
  var $rotulo     = null; 
  var $query_sql  = null; 
  var $numrows    = 0; 
  var $numrows_incluir = 0; 
  var $numrows_alterar = 0; 
  var $numrows_excluir = 0; 
  var $erro_status= null; 
  var $erro_sql   = null; 
  var $erro_banco = null;  
  var $erro_msg   = null;  
  var $erro_campo = null;  
  var $pagina_retorno = null; 
  // cria variaveis do arquivo 
  var $ci06_seq = 0; 
  var $ci06_codproc = 0; 
  var $ci06_codquestao = 0; 
  var $ci06_situencont = null; 
  var $ci06_objetos = null; 
  var $ci06_criterio = null; 
  var $ci06_evidencia = null; 
  var $ci06_causa = null; 
  var $ci06_efeito = null; 
  var $ci06_recomendacoes = null; 
  var $ci06_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 ci06_seq = int4 = Sequencial 
                 ci06_codproc = int4 = Código do Processo de Auditoria 
                 ci06_codquestao = int4 = Código da Questão 
                 ci06_situencont = varchar(500) = Situação Encontrada 
                 ci06_objetos = varchar(500) = Objetos 
                 ci06_criterio = varchar(500) = Critério 
                 ci06_evidencia = varchar(500) = Evidência 
                 ci06_causa = varchar(500) = Causa 
                 ci06_efeito = varchar(500) = Efeito 
                 ci06_recomendacoes = varchar(500) = Recomendações 
                 ci06_instit = int4 = Instituição 
                 ";

  //funcao construtor da classe 
  function cl_matrizachadosaudit() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("matrizachadosaudit"); 
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
       $this->ci06_seq = ($this->ci06_seq == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_seq"]:$this->ci06_seq);
       $this->ci06_codproc = ($this->ci06_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_codproc"]:$this->ci06_codproc);
       $this->ci06_codquestao = ($this->ci06_codquestao == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_codquestao"]:$this->ci06_codquestao);
       $this->ci06_situencont = ($this->ci06_situencont == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_situencont"]:$this->ci06_situencont);
       $this->ci06_objetos = ($this->ci06_objetos == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_objetos"]:$this->ci06_objetos);
       $this->ci06_criterio = ($this->ci06_criterio == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_criterio"]:$this->ci06_criterio);
       $this->ci06_evidencia = ($this->ci06_evidencia == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_evidencia"]:$this->ci06_evidencia);
       $this->ci06_causa = ($this->ci06_causa == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_causa"]:$this->ci06_causa);
       $this->ci06_efeito = ($this->ci06_efeito == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_efeito"]:$this->ci06_efeito);
       $this->ci06_recomendacoes = ($this->ci06_recomendacoes == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_recomendacoes"]:$this->ci06_recomendacoes);
       $this->ci06_instit = ($this->ci06_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["ci06_instit"]:$this->ci06_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir ($ci06_seq) { 
      $this->atualizacampos();
      if($ci06_seq == null || $ci06_seq == ""){ 
        $result = db_query("select nextval('contint_ci06_seq_seq')");
        if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contint_ci06_seq_seq do campo: ci06_seq"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->ci06_seq = pg_result($result,0,0); 
      }else{
       $result = db_query("select last_value from contint_ci06_seq_seq");
       if(($result != false) && (pg_result($result,0,0) < $ci06_seq)){
         $this->erro_sql = " Campo ci06_seq maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ci06_seq = $ci06_seq; 
       }
     }
     if($this->ci06_situencont == null ){ 
      $this->erro_sql = " Campo Situação Encontrada nao Informado.";
      $this->erro_campo = "ci06_situencont";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     if ($this->ci06_codproc == null ) { 
       $this->erro_sql = " Campo Código do Processo de Auditoria não informado.";
       $this->erro_campo = "ci06_codproc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci06_codquestao == null ) { 
       $this->erro_sql = " Campo Código da Questão não informado.";
       $this->erro_campo = "ci06_codquestao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci06_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "ci06_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into matrizachadosaudit(
                                       ci06_seq 
                                      ,ci06_codproc 
                                      ,ci06_codquestao 
                                      ,ci06_situencont 
                                      ,ci06_objetos 
                                      ,ci06_criterio 
                                      ,ci06_evidencia 
                                      ,ci06_causa 
                                      ,ci06_efeito 
                                      ,ci06_recomendacoes 
                                      ,ci06_instit 
                       )
                values (
                                $this->ci06_seq 
                               ,$this->ci06_codproc 
                               ,$this->ci06_codquestao 
                               ,'$this->ci06_situencont' 
                               ,'$this->ci06_objetos' 
                               ,'$this->ci06_criterio' 
                               ,'$this->ci06_evidencia' 
                               ,'$this->ci06_causa' 
                               ,'$this->ci06_efeito' 
                               ,'$this->ci06_recomendacoes' 
                               ,$this->ci06_instit 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Matriz de Achados () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Matriz de Achados já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Matriz de Achados () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $ci06_seq=null ) { 
      $this->atualizacampos();
     $sql = " update matrizachadosaudit set ";
     $virgula = "";
     if (trim($this->ci06_seq)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_seq"])) { 
       $sql  .= $virgula." ci06_seq = $this->ci06_seq ";
       $virgula = ",";
       if (trim($this->ci06_seq) == null ) { 
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "ci06_seq";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci06_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_codproc"])) { 
       $sql  .= $virgula." ci06_codproc = $this->ci06_codproc ";
       $virgula = ",";
       if (trim($this->ci06_codproc) == null ) { 
         $this->erro_sql = " Campo Código do Processo de Auditoria não informado.";
         $this->erro_campo = "ci06_codproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci06_codquestao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_codquestao"])) { 
       $sql  .= $virgula." ci06_codquestao = $this->ci06_codquestao ";
       $virgula = ",";
       if (trim($this->ci06_codquestao) == null ) { 
         $this->erro_sql = " Campo Código da Questão não informado.";
         $this->erro_campo = "ci06_codquestao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ci06_situencont)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_situencont"])){ 
      $sql  .= $virgula." ci06_situencont = '$this->ci06_situencont' ";
      $virgula = ",";
      if(trim($this->ci06_situencont) == null ){ 
        $this->erro_sql = " Campo Situação Encontrada nao Informado.";
        $this->erro_campo = "ci06_situencont";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     if (trim($this->ci06_objetos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_objetos"])) { 
       $sql  .= $virgula." ci06_objetos = '$this->ci06_objetos' ";
       $virgula = ",";
     }
     if (trim($this->ci06_criterio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_criterio"])) { 
       $sql  .= $virgula." ci06_criterio = '$this->ci06_criterio' ";
       $virgula = ",";
     }
     if (trim($this->ci06_evidencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_evidencia"])) { 
       $sql  .= $virgula." ci06_evidencia = '$this->ci06_evidencia' ";
       $virgula = ",";
     }
     if (trim($this->ci06_causa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_causa"])) { 
       $sql  .= $virgula." ci06_causa = '$this->ci06_causa' ";
       $virgula = ",";
     }
     if (trim($this->ci06_efeito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_efeito"])) { 
       $sql  .= $virgula." ci06_efeito = '$this->ci06_efeito' ";
       $virgula = ",";
     }
     if (trim($this->ci06_recomendacoes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_recomendacoes"])) { 
       $sql  .= $virgula." ci06_recomendacoes = '$this->ci06_recomendacoes' ";
       $virgula = ",";
     }
     if (trim($this->ci06_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci06_instit"])) { 
       $sql  .= $virgula." ci06_instit = $this->ci06_instit ";
       $virgula = ",";
       if (trim($this->ci06_instit) == null ) { 
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "ci06_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     $sql .= "ci06_seq = '$ci06_seq'";     
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Matriz de Achados nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Matriz de Achados nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $ci06_seq=null ,$dbwhere=null) { 

     $sql = " delete from matrizachadosaudit
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "ci06_seq = '$ci06_seq'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Matriz de Achados nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Matriz de Achados nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:matrizachadosaudit";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $ci06_seq = null,$campos="matrizachadosaudit.ci06_seq,*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from matrizachadosaudit ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $ci06_seq != "" && $ci06_seq != null) {
          $sql2 = " where matrizachadosaudit.ci06_seq = '$ci06_seq'";
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
  function sql_query_file ( $ci06_seq = null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from matrizachadosaudit ";
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
