<?php
//MODULO: pessoal
//CLASSE DA ENTIDADE relempenhospatronais
class cl_relempenhospatronais { 
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
  public $rh170_sequencial = 0; 
  public $rh170_tipo = null; 
  public $rh170_rubric = null; 
  public $rh170_instit = 0; 
  public $rh170_usuario = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh170_sequencial = int8 = Código Sequencial 
                 rh170_tipo = varchar(100) = Tipo de rúbrica 
                 rh170_rubric = varchar(4) = Rúbrica 
                 rh170_instit = int8 = Instituição 
                 rh170_usuario = int8 = Usuário 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("relempenhospatronais"); 
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
       $this->rh170_sequencial = ($this->rh170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh170_sequencial"]:$this->rh170_sequencial);
       $this->rh170_tipo = ($this->rh170_tipo == ""?@$GLOBALS["HTTP_POST_VARS"]["rh170_tipo"]:$this->rh170_tipo);
       $this->rh170_rubric = ($this->rh170_rubric == ""?@$GLOBALS["HTTP_POST_VARS"]["rh170_rubric"]:$this->rh170_rubric);
       $this->rh170_instit = ($this->rh170_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["rh170_instit"]:$this->rh170_instit);
       $this->rh170_usuario = ($this->rh170_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["rh170_usuario"]:$this->rh170_usuario);
     } else {
       $this->rh170_sequencial = ($this->rh170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh170_sequencial"]:$this->rh170_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh170_sequencial = null) { 
      $this->atualizacampos();
     if ($this->rh170_tipo == null ) { 
       $this->erro_sql = " Campo Tipo de rúbrica não informado.";
       $this->erro_campo = "rh170_tipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh170_rubric == null ) { 
       $this->erro_sql = " Campo Rúbrica não informado.";
       $this->erro_campo = "rh170_rubric";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh170_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "rh170_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh170_usuario == null ) { 
       $this->erro_sql = " Campo Usuário não informado.";
       $this->erro_campo = "rh170_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh170_sequencial == "" || $rh170_sequencial == null ) {
       $result = db_query("select nextval('relempenhospatronais_rh170_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: relempenhospatronais_rh170_sequencial_seq do campo: rh170_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh170_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from relempenhospatronais_rh170_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh170_sequencial)) {
         $this->erro_sql = " Campo rh170_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh170_sequencial = $rh170_sequencial; 
       }
     }
     if (($this->rh170_sequencial == null) || ($this->rh170_sequencial == "") ) { 
       $this->erro_sql = " Campo rh170_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into relempenhospatronais(
                                       rh170_sequencial 
                                      ,rh170_tipo 
                                      ,rh170_rubric 
                                      ,rh170_instit 
                                      ,rh170_usuario 
                       )
                values (
                                $this->rh170_sequencial 
                               ,'$this->rh170_tipo' 
                               ,'$this->rh170_rubric' 
                               ,$this->rh170_instit 
                               ,$this->rh170_usuario 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Cadastro Tipo/Rúbricas Obrigações Patronais ($this->rh170_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro Tipo/Rúbricas Obrigações Patronais já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Cadastro Tipo/Rúbricas Obrigações Patronais ($this->rh170_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh170_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh170_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2012394,'$this->rh170_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,2012394,'','".AddSlashes(pg_result($resaco,0,'rh170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2012395,'','".AddSlashes(pg_result($resaco,0,'rh170_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2012396,'','".AddSlashes(pg_result($resaco,0,'rh170_rubric'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2012397,'','".AddSlashes(pg_result($resaco,0,'rh170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2012398,'','".AddSlashes(pg_result($resaco,0,'rh170_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($rh170_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update relempenhospatronais set ";
     $virgula = "";
     if (trim($this->rh170_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh170_sequencial"])) { 
       $sql  .= $virgula." rh170_sequencial = $this->rh170_sequencial ";
       $virgula = ",";
       if (trim($this->rh170_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "rh170_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh170_tipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh170_tipo"])) { 
       $sql  .= $virgula." rh170_tipo = '$this->rh170_tipo' ";
       $virgula = ",";
       if (trim($this->rh170_tipo) == null ) { 
         $this->erro_sql = " Campo Tipo de rúbrica não informado.";
         $this->erro_campo = "rh170_tipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh170_rubric)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh170_rubric"])) { 
       $sql  .= $virgula." rh170_rubric = '$this->rh170_rubric' ";
       $virgula = ",";
       if (trim($this->rh170_rubric) == null ) { 
         $this->erro_sql = " Campo Rúbrica não informado.";
         $this->erro_campo = "rh170_rubric";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh170_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh170_instit"])) { 
       $sql  .= $virgula." rh170_instit = $this->rh170_instit ";
       $virgula = ",";
       if (trim($this->rh170_instit) == null ) { 
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "rh170_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh170_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh170_usuario"])) { 
       $sql  .= $virgula." rh170_usuario = $this->rh170_usuario ";
       $virgula = ",";
       if (trim($this->rh170_usuario) == null ) { 
         $this->erro_sql = " Campo Usuário não informado.";
         $this->erro_campo = "rh170_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($rh170_sequencial!=null) {
       $sql .= " rh170_sequencial = $this->rh170_sequencial";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh170_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2012394,'$this->rh170_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh170_sequencial"]) || $this->rh170_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2012394,'".AddSlashes(pg_result($resaco,$conresaco,'rh170_sequencial'))."','$this->rh170_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh170_tipo"]) || $this->rh170_tipo != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2012395,'".AddSlashes(pg_result($resaco,$conresaco,'rh170_tipo'))."','$this->rh170_tipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh170_rubric"]) || $this->rh170_rubric != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2012396,'".AddSlashes(pg_result($resaco,$conresaco,'rh170_rubric'))."','$this->rh170_rubric',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh170_instit"]) || $this->rh170_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2012397,'".AddSlashes(pg_result($resaco,$conresaco,'rh170_instit'))."','$this->rh170_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh170_usuario"]) || $this->rh170_usuario != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2012398,'".AddSlashes(pg_result($resaco,$conresaco,'rh170_usuario'))."','$this->rh170_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro Tipo/Rúbricas Obrigações Patronais nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh170_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro Tipo/Rúbricas Obrigações Patronais nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh170_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($rh170_sequencial=null,$dbwhere=null) { 

     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($rh170_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2012394,'$rh170_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,2012394,'','".AddSlashes(pg_result($resaco,$iresaco,'rh170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2012395,'','".AddSlashes(pg_result($resaco,$iresaco,'rh170_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2012396,'','".AddSlashes(pg_result($resaco,$iresaco,'rh170_rubric'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2012397,'','".AddSlashes(pg_result($resaco,$iresaco,'rh170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2012398,'','".AddSlashes(pg_result($resaco,$iresaco,'rh170_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from relempenhospatronais
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($rh170_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " rh170_sequencial = $rh170_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro Tipo/Rúbricas Obrigações Patronais nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh170_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro Tipo/Rúbricas Obrigações Patronais nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh170_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:relempenhospatronais";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh170_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from relempenhospatronais ";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = relempenhospatronais.rh170_usuario";
     $sql .= "      inner join rhrubricas  on  rhrubricas.rh27_rubric = relempenhospatronais.rh170_rubric and  rhrubricas.rh27_instit = relempenhospatronais.rh170_instit";
     $sql .= "      inner join db_config  on  db_config.codigo = rhrubricas.rh27_instit";
     $sql .= "      inner join rhtipomedia  on  rhtipomedia.rh29_tipo = rhrubricas.rh27_calc1";
     $sql .= "      left  join rhfundamentacaolegal  on  rhfundamentacaolegal.rh137_sequencial = rhrubricas.rh27_rhfundamentacaolegal";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh170_sequencial!=null ) {
         $sql2 .= " where relempenhospatronais.rh170_sequencial = $rh170_sequencial "; 
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
  function sql_query_file ( $rh170_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from relempenhospatronais ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh170_sequencial!=null ) {
         $sql2 .= " where relempenhospatronais.rh170_sequencial = $rh170_sequencial "; 
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
