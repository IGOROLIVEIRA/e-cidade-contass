<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE protconfigdepartaut
class cl_protconfigdepartaut {
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
  public $p109_sequencial = 0;
  public $p109_coddeptoorigem = 0;
  public $p109_coddeptodestino = 0;
  public $p109_instit = 0;
  public $p109_id_usuario = 0;
  public $p109_dt_config_dia = null;
  public $p109_dt_config_mes = null;
  public $p109_dt_config_ano = null;
  public $p109_dt_config = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 p109_sequencial = int4 = p109_sequencial
                 p109_coddeptoorigem = int4 = Dept. Origem
                 p109_coddeptodestino = int4 = Dept. Destino
                 p109_instit = int4 = Instituicao
                 p109_id_usuario = int4 = Usuario
                 p109_dt_config = date = Data Configuracao
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("protconfigdepartaut");
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
       $this->p109_sequencial = ($this->p109_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_sequencial"]:$this->p109_sequencial);
       $this->p109_coddeptoorigem = ($this->p109_coddeptoorigem == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_coddeptoorigem"]:$this->p109_coddeptoorigem);
       $this->p109_coddeptodestino = ($this->p109_coddeptodestino == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_coddeptodestino"]:$this->p109_coddeptodestino);
       $this->p109_instit = ($this->p109_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_instit"]:$this->p109_instit);
       $this->p109_id_usuario = ($this->p109_id_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_id_usuario"]:$this->p109_id_usuario);
       if ($this->p109_dt_config == "") {
         $this->p109_dt_config_dia = ($this->p109_dt_config_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_dt_config_dia"]:$this->p109_dt_config_dia);
         $this->p109_dt_config_mes = ($this->p109_dt_config_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_dt_config_mes"]:$this->p109_dt_config_mes);
         $this->p109_dt_config_ano = ($this->p109_dt_config_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_dt_config_ano"]:$this->p109_dt_config_ano);
         if ($this->p109_dt_config_dia != "") {
            $this->p109_dt_config = $this->p109_dt_config_ano."-".$this->p109_dt_config_mes."-".$this->p109_dt_config_dia;
         }
       }
     } else {
       $this->p109_sequencial = ($this->p109_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p109_sequencial"]:$this->p109_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($p109_sequencial) {
      $this->atualizacampos();
     if ($this->p109_coddeptoorigem == null ) {
       $this->erro_sql = " Campo Dept. Origem não informado.";
       $this->erro_campo = "p109_coddeptoorigem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p109_coddeptodestino == null ) {
       $this->erro_sql = " Campo Dept. Destino não informado.";
       $this->erro_campo = "p109_coddeptodestino";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p109_instit == null ) {
       $this->erro_sql = " Campo Instituicao não informado.";
       $this->erro_campo = "p109_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p109_id_usuario == null ) {
       $this->erro_sql = " Campo Usuario não informado.";
       $this->erro_campo = "p109_id_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p109_dt_config == null ) {
       $this->erro_sql = " Campo Data Configuracao não informado.";
       $this->erro_campo = "p109_dt_config_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($p109_sequencial == "" || $p109_sequencial == null ) {
       $result = db_query("select nextval('protconfigdepartaut_p109_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: protconfigdepartaut_p109_sequencial_seq do campo: p109_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->p109_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from protconfigdepartaut_p109_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $p109_sequencial)) {
         $this->erro_sql = " Campo p109_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->p109_sequencial = $p109_sequencial;
       }
     }
     if (($this->p109_sequencial == null) || ($this->p109_sequencial == "") ) {
       $this->erro_sql = " Campo p109_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into protconfigdepartaut(
                                       p109_sequencial
                                      ,p109_coddeptoorigem
                                      ,p109_coddeptodestino
                                      ,p109_instit
                                      ,p109_id_usuario
                                      ,p109_dt_config
                       )
                values (
                                $this->p109_sequencial
                               ,$this->p109_coddeptoorigem
                               ,$this->p109_coddeptodestino
                               ,$this->p109_instit
                               ,$this->p109_id_usuario
                               ,".($this->p109_dt_config == "null" || $this->p109_dt_config == ""?"null":"'".$this->p109_dt_config."'")."
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "protconfigdepartaut ($this->p109_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "protconfigdepartaut já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "protconfigdepartaut ($this->p109_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p109_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p109_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->p109_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'p109_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,0,'p109_coddeptoorigem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,0,'p109_coddeptodestino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,0,'p109_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,0,'p109_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,0,'p109_dt_config'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($p109_sequencial=null) {
      $this->atualizacampos();
     $sql = " update protconfigdepartaut set ";
     $virgula = "";
     if (trim($this->p109_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p109_sequencial"])) {
       $sql  .= $virgula." p109_sequencial = $this->p109_sequencial ";
       $virgula = ",";
       if (trim($this->p109_sequencial) == null ) {
         $this->erro_sql = " Campo p109_sequencial não informado.";
         $this->erro_campo = "p109_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p109_coddeptoorigem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p109_coddeptoorigem"])) {
       $sql  .= $virgula." p109_coddeptoorigem = $this->p109_coddeptoorigem ";
       $virgula = ",";
       if (trim($this->p109_coddeptoorigem) == null ) {
         $this->erro_sql = " Campo Dept. Origem não informado.";
         $this->erro_campo = "p109_coddeptoorigem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p109_coddeptodestino)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p109_coddeptodestino"])) {
       $sql  .= $virgula." p109_coddeptodestino = $this->p109_coddeptodestino ";
       $virgula = ",";
       if (trim($this->p109_coddeptodestino) == null ) {
         $this->erro_sql = " Campo Dept. Destino não informado.";
         $this->erro_campo = "p109_coddeptodestino";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p109_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p109_instit"])) {
       $sql  .= $virgula." p109_instit = $this->p109_instit ";
       $virgula = ",";
       if (trim($this->p109_instit) == null ) {
         $this->erro_sql = " Campo Instituicao não informado.";
         $this->erro_campo = "p109_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p109_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p109_id_usuario"])) {
       $sql  .= $virgula." p109_id_usuario = $this->p109_id_usuario ";
       $virgula = ",";
       if (trim($this->p109_id_usuario) == null ) {
         $this->erro_sql = " Campo Usuario não informado.";
         $this->erro_campo = "p109_id_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p109_dt_config)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p109_dt_config_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p109_dt_config_dia"] !="") ) {
       $sql  .= $virgula." p109_dt_config = '$this->p109_dt_config' ";
       $virgula = ",";
       if (trim($this->p109_dt_config) == null ) {
         $this->erro_sql = " Campo Data Configuracao não informado.";
         $this->erro_campo = "p109_dt_config_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["p109_dt_config_dia"])) {
         $sql  .= $virgula." p109_dt_config = null ";
         $virgula = ",";
         if (trim($this->p109_dt_config) == null ) {
           $this->erro_sql = " Campo Data Configuracao não informado.";
           $this->erro_campo = "p109_dt_config_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if ($p109_sequencial!=null) {
       $sql .= " p109_sequencial = $this->p109_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p109_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->p109_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p109_sequencial"]) || $this->p109_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'p109_sequencial'))."','$this->p109_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p109_coddeptoorigem"]) || $this->p109_coddeptoorigem != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'p109_coddeptoorigem'))."','$this->p109_coddeptoorigem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p109_coddeptodestino"]) || $this->p109_coddeptodestino != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'p109_coddeptodestino'))."','$this->p109_coddeptodestino',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p109_instit"]) || $this->p109_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'p109_instit'))."','$this->p109_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p109_id_usuario"]) || $this->p109_id_usuario != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'p109_id_usuario'))."','$this->p109_id_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p109_dt_config"]) || $this->p109_dt_config != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'p109_dt_config'))."','$this->p109_dt_config',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protconfigdepartaut nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->p109_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protconfigdepartaut nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->p109_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p109_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($p109_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($p109_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009245,'$p109_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'p109_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'p109_coddeptoorigem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'p109_coddeptodestino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'p109_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'p109_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'p109_dt_config'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from protconfigdepartaut
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($p109_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " p109_sequencial = $p109_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protconfigdepartaut nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$p109_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protconfigdepartaut nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$p109_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$p109_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:protconfigdepartaut";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $p109_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protconfigdepartaut ";
     $sql .= "      inner join db_config  on  db_config.codigo = protconfigdepartaut.p109_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protconfigdepartaut.p109_id_usuario";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = protconfigdepartaut.p109_coddeptoorigem and  db_depart.coddepto = protconfigdepartaut.p109_coddeptodestino";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = db_config.numcgm";
     $sql .= "      inner join db_tipoinstit  on  db_tipoinstit.db21_codtipo = db_config.db21_tipoinstit";
     $sql .= "      inner join db_config  on  db_config.codigo = db_depart.instit";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p109_sequencial!=null ) {
         $sql2 .= " where protconfigdepartaut.p109_sequencial = $p109_sequencial ";
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
  function sql_query_file ( $p109_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protconfigdepartaut ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p109_sequencial!=null ) {
         $sql2 .= " where protconfigdepartaut.p109_sequencial = $p109_sequencial ";
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
