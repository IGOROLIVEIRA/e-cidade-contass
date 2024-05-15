<?php
//MODULO: recursoshumanos
//CLASSE DA ENTIDADE rhgrrf
class cl_rhgrrf { 
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
  public $rh168_sequencial = 0; 
  public $rh168_anousu = 0; 
  public $rh168_mesusu = 0; 
  public $rh168_arquivo = 0; 
  public $rh168_id_usuario = 0; 
  public $rh168_datagera_dia = null; 
  public $rh168_datagera_mes = null; 
  public $rh168_datagera_ano = null; 
  public $rh168_datagera = null; 
  public $rh168_horagera = null; 
  public $rh168_ativa = 'f'; 
  public $rh168_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh168_sequencial = int8 = Código Sequencial 
                 rh168_anousu = int8 = Exercício 
                 rh168_mesusu = int8 = Mês 
                 rh168_arquivo = oid = Arquivo GRRF 
                 rh168_id_usuario = int8 = Usuário 
                 rh168_datagera = date = Data Geração 
                 rh168_horagera = char(5) = Hora Geração 
                 rh168_ativa = bool = Ativa 
                 rh168_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rhgrrf"); 
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
       $this->rh168_sequencial = ($this->rh168_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_sequencial"]:$this->rh168_sequencial);
       $this->rh168_anousu = ($this->rh168_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_anousu"]:$this->rh168_anousu);
       $this->rh168_mesusu = ($this->rh168_mesusu == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_mesusu"]:$this->rh168_mesusu);
       $this->rh168_arquivo = ($this->rh168_arquivo == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_arquivo"]:$this->rh168_arquivo);
       $this->rh168_id_usuario = ($this->rh168_id_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_id_usuario"]:$this->rh168_id_usuario);
       if ($this->rh168_datagera == "") {
         $this->rh168_datagera_dia = ($this->rh168_datagera_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_datagera_dia"]:$this->rh168_datagera_dia);
         $this->rh168_datagera_mes = ($this->rh168_datagera_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_datagera_mes"]:$this->rh168_datagera_mes);
         $this->rh168_datagera_ano = ($this->rh168_datagera_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_datagera_ano"]:$this->rh168_datagera_ano);
         if ($this->rh168_datagera_dia != "") {
            $this->rh168_datagera = $this->rh168_datagera_ano."-".$this->rh168_datagera_mes."-".$this->rh168_datagera_dia;
         }
       }
       $this->rh168_horagera = ($this->rh168_horagera == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_horagera"]:$this->rh168_horagera);
       $this->rh168_ativa = ($this->rh168_ativa == "f"?@$GLOBALS["HTTP_POST_VARS"]["rh168_ativa"]:$this->rh168_ativa);
       $this->rh168_instit = ($this->rh168_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_instit"]:$this->rh168_instit);
     } else {
       $this->rh168_sequencial = ($this->rh168_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh168_sequencial"]:$this->rh168_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh168_sequencial) { 
      $this->atualizacampos();
     if ($this->rh168_anousu == null ) { 
       $this->erro_sql = " Campo Exercício não informado.";
       $this->erro_campo = "rh168_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh168_mesusu == null ) { 
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "rh168_mesusu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh168_arquivo == null ) { 
       $this->erro_sql = " Campo Arquivo GRRF não informado.";
       $this->erro_campo = "rh168_arquivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh168_id_usuario == null ) { 
       $this->erro_sql = " Campo Usuário não informado.";
       $this->erro_campo = "rh168_id_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh168_datagera == null ) { 
       $this->erro_sql = " Campo Data Geração não informado.";
       $this->erro_campo = "rh168_datagera_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh168_horagera == null ) { 
       $this->erro_sql = " Campo Hora Geração não informado.";
       $this->erro_campo = "rh168_horagera";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh168_ativa == null ) { 
       $this->erro_sql = " Campo Ativa não informado.";
       $this->erro_campo = "rh168_ativa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh168_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "rh168_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh168_sequencial == "" || $rh168_sequencial == null ) {
       $result = db_query("select nextval('rhgrrf_rh168_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rhgrrf_rh168_sequencial_seq do campo: rh168_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh168_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from rhgrrf_rh168_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh168_sequencial)) {
         $this->erro_sql = " Campo rh168_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh168_sequencial = $rh168_sequencial; 
       }
     }
     if (($this->rh168_sequencial == null) || ($this->rh168_sequencial == "") ) { 
       $this->erro_sql = " Campo rh168_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rhgrrf(
                                       rh168_sequencial 
                                      ,rh168_anousu 
                                      ,rh168_mesusu 
                                      ,rh168_arquivo 
                                      ,rh168_id_usuario 
                                      ,rh168_datagera 
                                      ,rh168_horagera 
                                      ,rh168_ativa 
                                      ,rh168_instit 
                       )
                values (
                                $this->rh168_sequencial 
                               ,$this->rh168_anousu 
                               ,$this->rh168_mesusu 
                               ,$this->rh168_arquivo 
                               ,$this->rh168_id_usuario 
                               ,".($this->rh168_datagera == "null" || $this->rh168_datagera == ""?"null":"'".$this->rh168_datagera."'")." 
                               ,'$this->rh168_horagera' 
                               ,'$this->rh168_ativa' 
                               ,$this->rh168_instit 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Geração da GRRF ($this->rh168_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Geração da GRRF já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Geração da GRRF ($this->rh168_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh168_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh168_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->rh168_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'rh168_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'rh168_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,0,'rh168_mesusu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,0,'rh168_arquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,0,'rh168_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,0,'rh168_datagera'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,0,'rh168_horagera'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,0,'rh168_ativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,0,'rh168_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($rh168_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rhgrrf set ";
     $virgula = "";
     if (trim($this->rh168_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_sequencial"])) { 
       $sql  .= $virgula." rh168_sequencial = $this->rh168_sequencial ";
       $virgula = ",";
       if (trim($this->rh168_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "rh168_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh168_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_anousu"])) { 
       $sql  .= $virgula." rh168_anousu = $this->rh168_anousu ";
       $virgula = ",";
       if (trim($this->rh168_anousu) == null ) { 
         $this->erro_sql = " Campo Exercício não informado.";
         $this->erro_campo = "rh168_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh168_mesusu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_mesusu"])) { 
       $sql  .= $virgula." rh168_mesusu = $this->rh168_mesusu ";
       $virgula = ",";
       if (trim($this->rh168_mesusu) == null ) { 
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "rh168_mesusu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh168_arquivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_arquivo"])) { 
       $sql  .= $virgula." rh168_arquivo = $this->rh168_arquivo ";
       $virgula = ",";
       if (trim($this->rh168_arquivo) == null ) { 
         $this->erro_sql = " Campo Arquivo GRRF não informado.";
         $this->erro_campo = "rh168_arquivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh168_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_id_usuario"])) { 
       $sql  .= $virgula." rh168_id_usuario = $this->rh168_id_usuario ";
       $virgula = ",";
       if (trim($this->rh168_id_usuario) == null ) { 
         $this->erro_sql = " Campo Usuário não informado.";
         $this->erro_campo = "rh168_id_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh168_datagera)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_datagera_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["rh168_datagera_dia"] !="") ) { 
       $sql  .= $virgula." rh168_datagera = '$this->rh168_datagera' ";
       $virgula = ",";
       if (trim($this->rh168_datagera) == null ) { 
         $this->erro_sql = " Campo Data Geração não informado.";
         $this->erro_campo = "rh168_datagera_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_datagera_dia"])) { 
         $sql  .= $virgula." rh168_datagera = null ";
         $virgula = ",";
         if (trim($this->rh168_datagera) == null ) { 
           $this->erro_sql = " Campo Data Geração não informado.";
           $this->erro_campo = "rh168_datagera_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->rh168_horagera)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_horagera"])) { 
       $sql  .= $virgula." rh168_horagera = '$this->rh168_horagera' ";
       $virgula = ",";
       if (trim($this->rh168_horagera) == null ) { 
         $this->erro_sql = " Campo Hora Geração não informado.";
         $this->erro_campo = "rh168_horagera";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh168_ativa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_ativa"])) { 
       $sql  .= $virgula." rh168_ativa = '$this->rh168_ativa' ";
       $virgula = ",";
       if (trim($this->rh168_ativa) == null ) { 
         $this->erro_sql = " Campo Ativa não informado.";
         $this->erro_campo = "rh168_ativa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh168_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh168_instit"])) { 
       $sql  .= $virgula." rh168_instit = $this->rh168_instit ";
       $virgula = ",";
       if (trim($this->rh168_instit) == null ) { 
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "rh168_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($rh168_sequencial!=null) {
       $sql .= " rh168_sequencial = $this->rh168_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh168_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->rh168_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_sequencial"]) || $this->rh168_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_sequencial'))."','$this->rh168_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_anousu"]) || $this->rh168_anousu != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_anousu'))."','$this->rh168_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_mesusu"]) || $this->rh168_mesusu != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_mesusu'))."','$this->rh168_mesusu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_arquivo"]) || $this->rh168_arquivo != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009246,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_arquivo'))."','$this->rh168_arquivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_id_usuario"]) || $this->rh168_id_usuario != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_id_usuario'))."','$this->rh168_id_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_datagera"]) || $this->rh168_datagera != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_datagera'))."','$this->rh168_datagera',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_horagera"]) || $this->rh168_horagera != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_horagera'))."','$this->rh168_horagera',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_ativa"]) || $this->rh168_ativa != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_ativa'))."','$this->rh168_ativa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh168_instit"]) || $this->rh168_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'rh168_instit'))."','$this->rh168_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Geração da GRRF nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh168_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Geração da GRRF nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh168_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh168_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($rh168_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($rh168_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009244,'$rh168_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_mesusu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_arquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_datagera'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_horagera'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_ativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'rh168_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from rhgrrf
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($rh168_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " rh168_sequencial = $rh168_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Geração da GRRF nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh168_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Geração da GRRF nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh168_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh168_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rhgrrf";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh168_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhgrrf ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh168_sequencial!=null ) {
         $sql2 .= " where rhgrrf.rh168_sequencial = $rh168_sequencial "; 
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
  function sql_query_file ( $rh168_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhgrrf ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh168_sequencial!=null ) {
         $sql2 .= " where rhgrrf.rh168_sequencial = $rh168_sequencial "; 
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
