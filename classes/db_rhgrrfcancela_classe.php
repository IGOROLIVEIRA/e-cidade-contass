<?php
//MODULO: recursoshumanos
//CLASSE DA ENTIDADE rhgrrfcancela
class cl_rhgrrfcancela { 
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
  public $rh169_sequencial = 0; 
  public $rh169_rhgrrf = 0; 
  public $rh169_id_usuario = 0; 
  public $rh169_data_dia = null; 
  public $rh169_data_mes = null; 
  public $rh169_data_ano = null; 
  public $rh169_data = null; 
  public $rh169_hora = null; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh169_sequencial = int8 = Código Sequencial 
                 rh169_rhgrrf = int8 = Código GRRF 
                 rh169_id_usuario = int8 = Usuário 
                 rh169_data = date = Data Cancelamento 
                 rh169_hora = char(5) = Hora Cancelamento 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rhgrrfcancela"); 
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
       $this->rh169_sequencial = ($this->rh169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"]:$this->rh169_sequencial);
       $this->rh169_rhgrrf = ($this->rh169_rhgrrf == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_rhgrrf"]:$this->rh169_rhgrrf);
       $this->rh169_id_usuario = ($this->rh169_id_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_id_usuario"]:$this->rh169_id_usuario);
       if ($this->rh169_data == "") {
         $this->rh169_data_dia = ($this->rh169_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_data_dia"]:$this->rh169_data_dia);
         $this->rh169_data_mes = ($this->rh169_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_data_mes"]:$this->rh169_data_mes);
         $this->rh169_data_ano = ($this->rh169_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_data_ano"]:$this->rh169_data_ano);
         if ($this->rh169_data_dia != "") {
            $this->rh169_data = $this->rh169_data_ano."-".$this->rh169_data_mes."-".$this->rh169_data_dia;
         }
       }
       $this->rh169_hora = ($this->rh169_hora == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_hora"]:$this->rh169_hora);
     } else {
       $this->rh169_sequencial = ($this->rh169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"]:$this->rh169_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh169_sequencial) { 
      $this->atualizacampos();
     if ($this->rh169_rhgrrf == null ) { 
       $this->erro_sql = " Campo Código GRRF não informado.";
       $this->erro_campo = "rh169_rhgrrf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh169_id_usuario == null ) { 
       $this->erro_sql = " Campo Usuário não informado.";
       $this->erro_campo = "rh169_id_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh169_data == null ) { 
       $this->erro_sql = " Campo Data Cancelamento não informado.";
       $this->erro_campo = "rh169_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh169_hora == null ) { 
       $this->erro_sql = " Campo Hora Cancelamento não informado.";
       $this->erro_campo = "rh169_hora";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh169_sequencial == "" || $rh169_sequencial == null ) {
       $result = db_query("select nextval('rhgrrfcancela_rh169_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rhgrrfcancela_rh169_sequencial_seq do campo: rh169_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh169_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from rhgrrfcancela_rh169_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh169_sequencial)) {
         $this->erro_sql = " Campo rh169_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh169_sequencial = $rh169_sequencial; 
       }
     }
     if (($this->rh169_sequencial == null) || ($this->rh169_sequencial == "") ) { 
       $this->erro_sql = " Campo rh169_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rhgrrfcancela(
                                       rh169_sequencial 
                                      ,rh169_rhgrrf 
                                      ,rh169_id_usuario 
                                      ,rh169_data 
                                      ,rh169_hora 
                       )
                values (
                                $this->rh169_sequencial 
                               ,$this->rh169_rhgrrf 
                               ,$this->rh169_id_usuario 
                               ,".($this->rh169_data == "null" || $this->rh169_data == ""?"null":"'".$this->rh169_data."'")." 
                               ,'$this->rh169_hora' 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "rhgrrfcancela ($this->rh169_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "rhgrrfcancela já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "rhgrrfcancela ($this->rh169_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh169_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009254,'$this->rh169_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,0,'rh169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,0,'rh169_rhgrrf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,0,'rh169_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,0,'rh169_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'rh169_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($rh169_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rhgrrfcancela set ";
     $virgula = "";
     if (trim($this->rh169_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"])) { 
       $sql  .= $virgula." rh169_sequencial = $this->rh169_sequencial ";
       $virgula = ",";
       if (trim($this->rh169_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "rh169_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh169_rhgrrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_rhgrrf"])) { 
       $sql  .= $virgula." rh169_rhgrrf = $this->rh169_rhgrrf ";
       $virgula = ",";
       if (trim($this->rh169_rhgrrf) == null ) { 
         $this->erro_sql = " Campo Código GRRF não informado.";
         $this->erro_campo = "rh169_rhgrrf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh169_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_id_usuario"])) { 
       $sql  .= $virgula." rh169_id_usuario = $this->rh169_id_usuario ";
       $virgula = ",";
       if (trim($this->rh169_id_usuario) == null ) { 
         $this->erro_sql = " Campo Usuário não informado.";
         $this->erro_campo = "rh169_id_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh169_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["rh169_data_dia"] !="") ) { 
       $sql  .= $virgula." rh169_data = '$this->rh169_data' ";
       $virgula = ",";
       if (trim($this->rh169_data) == null ) { 
         $this->erro_sql = " Campo Data Cancelamento não informado.";
         $this->erro_campo = "rh169_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_data_dia"])) { 
         $sql  .= $virgula." rh169_data = null ";
         $virgula = ",";
         if (trim($this->rh169_data) == null ) { 
           $this->erro_sql = " Campo Data Cancelamento não informado.";
           $this->erro_campo = "rh169_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->rh169_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_hora"])) { 
       $sql  .= $virgula." rh169_hora = '$this->rh169_hora' ";
       $virgula = ",";
       if (trim($this->rh169_hora) == null ) { 
         $this->erro_sql = " Campo Hora Cancelamento não informado.";
         $this->erro_campo = "rh169_hora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($rh169_sequencial!=null) {
       $sql .= " rh169_sequencial = $this->rh169_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh169_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009254,'$this->rh169_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"]) || $this->rh169_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_sequencial'))."','$this->rh169_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_rhgrrf"]) || $this->rh169_rhgrrf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_rhgrrf'))."','$this->rh169_rhgrrf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_id_usuario"]) || $this->rh169_id_usuario != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_id_usuario'))."','$this->rh169_id_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_data"]) || $this->rh169_data != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_data'))."','$this->rh169_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_hora"]) || $this->rh169_hora != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_hora'))."','$this->rh169_hora',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rhgrrfcancela nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "rhgrrfcancela nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($rh169_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($rh169_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009254,'$rh169_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_rhgrrf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from rhgrrfcancela
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($rh169_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " rh169_sequencial = $rh169_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rhgrrfcancela nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh169_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "rhgrrfcancela nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh169_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh169_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rhgrrfcancela";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh169_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhgrrfcancela ";
     $sql .= "      inner join rhgrrf  on  rhgrrf.rh168_sequencial = rhgrrfcancela.rh169_rhgrrf";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh169_sequencial!=null ) {
         $sql2 .= " where rhgrrfcancela.rh169_sequencial = $rh169_sequencial "; 
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
  function sql_query_file ( $rh169_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhgrrfcancela ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh169_sequencial!=null ) {
         $sql2 .= " where rhgrrfcancela.rh169_sequencial = $rh169_sequencial "; 
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
