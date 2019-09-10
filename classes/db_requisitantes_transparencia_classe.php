<?php
//MODULO: configuracoes
//CLASSE DA ENTIDADE requisitantes_transparencia
class cl_requisitantes_transparencia { 
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
  public $db149_sequencial = 0; 
  public $db149_matricula = 0; 
  public $db149_cpf = null; 
  public $db149_nome = null; 
  public $db149_data_dia = null; 
  public $db149_data_mes = null; 
  public $db149_data_ano = null; 
  public $db149_data = null; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 db149_sequencial = int8 = Código Sequencial 
                 db149_matricula = int4 = Matricula Consultada 
                 db149_cpf = varchar(11) = Cpf do Requisitante 
                 db149_nome = varchar(200) = Nome do Requisitante 
                 db149_data = date = Data da Consulta 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("requisitantes_transparencia"); 
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
       $this->db149_sequencial = ($this->db149_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_sequencial"]:$this->db149_sequencial);
       $this->db149_matricula = ($this->db149_matricula == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_matricula"]:$this->db149_matricula);
       $this->db149_cpf = ($this->db149_cpf == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_cpf"]:$this->db149_cpf);
       $this->db149_nome = ($this->db149_nome == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_nome"]:$this->db149_nome);
       if ($this->db149_data == "") {
         $this->db149_data_dia = ($this->db149_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_data_dia"]:$this->db149_data_dia);
         $this->db149_data_mes = ($this->db149_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_data_mes"]:$this->db149_data_mes);
         $this->db149_data_ano = ($this->db149_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_data_ano"]:$this->db149_data_ano);
         if ($this->db149_data_dia != "") {
            $this->db149_data = $this->db149_data_ano."-".$this->db149_data_mes."-".$this->db149_data_dia;
         }
       }
     } else {
       $this->db149_sequencial = ($this->db149_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["db149_sequencial"]:$this->db149_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($db149_sequencial) { 
      $this->atualizacampos();
     if ($this->db149_matricula == null ) { 
       $this->erro_sql = " Campo Matricula Consultada não informado.";
       $this->erro_campo = "db149_matricula";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->db149_cpf == null ) { 
       $this->erro_sql = " Campo Cpf do Requisitante não informado.";
       $this->erro_campo = "db149_cpf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->db149_nome == null ) { 
       $this->erro_sql = " Campo Nome do Requisitante não informado.";
       $this->erro_campo = "db149_nome";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->db149_data == null ) { 
       $this->erro_sql = " Campo Data da Consulta não informado.";
       $this->erro_campo = "db149_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into requisitantes_transparencia(
                                       db149_matricula 
                                      ,db149_cpf 
                                      ,db149_nome 
                                      ,db149_data 
                       )
                values (
                               $this->db149_matricula 
                               ,'$this->db149_cpf' 
                               ,'$this->db149_nome' 
                               ,".($this->db149_data == "null" || $this->db149_data == ""?"null":"'".$this->db149_data."'")." 
                      )";
     $result = db_query($sql); die($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Requisitantes Folha Transparência ($this->db149_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Requisitantes Folha Transparência já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Requisitantes Folha Transparência ($this->db149_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->db149_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->db149_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009258,'$this->db149_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010195,1009258,'','".AddSlashes(pg_result($resaco,0,'db149_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,1009259,'','".AddSlashes(pg_result($resaco,0,'db149_matricula'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,1009260,'','".AddSlashes(pg_result($resaco,0,'db149_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,1009261,'','".AddSlashes(pg_result($resaco,0,'db149_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,1009262,'','".AddSlashes(pg_result($resaco,0,'db149_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($db149_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update requisitantes_transparencia set ";
     $virgula = "";
     if (trim($this->db149_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db149_sequencial"])) { 
       $sql  .= $virgula." db149_sequencial = $this->db149_sequencial ";
       $virgula = ",";
       if (trim($this->db149_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "db149_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->db149_matricula)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db149_matricula"])) { 
       $sql  .= $virgula." db149_matricula = $this->db149_matricula ";
       $virgula = ",";
       if (trim($this->db149_matricula) == null ) { 
         $this->erro_sql = " Campo Matricula Consultada não informado.";
         $this->erro_campo = "db149_matricula";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->db149_cpf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db149_cpf"])) { 
       $sql  .= $virgula." db149_cpf = '$this->db149_cpf' ";
       $virgula = ",";
       if (trim($this->db149_cpf) == null ) { 
         $this->erro_sql = " Campo Cpf do Requisitante não informado.";
         $this->erro_campo = "db149_cpf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->db149_nome)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db149_nome"])) { 
       $sql  .= $virgula." db149_nome = '$this->db149_nome' ";
       $virgula = ",";
       if (trim($this->db149_nome) == null ) { 
         $this->erro_sql = " Campo Nome do Requisitante não informado.";
         $this->erro_campo = "db149_nome";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->db149_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db149_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["db149_data_dia"] !="") ) { 
       $sql  .= $virgula." db149_data = '$this->db149_data' ";
       $virgula = ",";
       if (trim($this->db149_data) == null ) { 
         $this->erro_sql = " Campo Data da Consulta não informado.";
         $this->erro_campo = "db149_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["db149_data_dia"])) { 
         $sql  .= $virgula." db149_data = null ";
         $virgula = ",";
         if (trim($this->db149_data) == null ) { 
           $this->erro_sql = " Campo Data da Consulta não informado.";
           $this->erro_campo = "db149_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if ($db149_sequencial!=null) {
       $sql .= " db149_sequencial = $this->db149_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->db149_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009258,'$this->db149_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["db149_sequencial"]) || $this->db149_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'db149_sequencial'))."','$this->db149_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["db149_matricula"]) || $this->db149_matricula != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'db149_matricula'))."','$this->db149_matricula',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["db149_cpf"]) || $this->db149_cpf != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009260,'".AddSlashes(pg_result($resaco,$conresaco,'db149_cpf'))."','$this->db149_cpf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["db149_nome"]) || $this->db149_nome != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009261,'".AddSlashes(pg_result($resaco,$conresaco,'db149_nome'))."','$this->db149_nome',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["db149_data"]) || $this->db149_data != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009262,'".AddSlashes(pg_result($resaco,$conresaco,'db149_data'))."','$this->db149_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Requisitantes Folha Transparência nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->db149_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Requisitantes Folha Transparência nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->db149_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->db149_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($db149_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($db149_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009258,'$db149_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'db149_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'db149_matricula'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009260,'','".AddSlashes(pg_result($resaco,$iresaco,'db149_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009261,'','".AddSlashes(pg_result($resaco,$iresaco,'db149_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009262,'','".AddSlashes(pg_result($resaco,$iresaco,'db149_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from requisitantes_transparencia
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($db149_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " db149_sequencial = $db149_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Requisitantes Folha Transparência nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$db149_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Requisitantes Folha Transparência nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$db149_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$db149_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:requisitantes_transparencia";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $db149_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from requisitantes_transparencia ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($db149_sequencial!=null ) {
         $sql2 .= " where requisitantes_transparencia.db149_sequencial = $db149_sequencial "; 
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
  function sql_query_file ( $db149_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from requisitantes_transparencia ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($db149_sequencial!=null ) {
         $sql2 .= " where requisitantes_transparencia.db149_sequencial = $db149_sequencial "; 
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
