<?php
//MODULO: orcamento
//CLASSE DA ENTIDADE mtfis_ldo
class cl_mtfis_ldo {
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
  public $mtfis_sequencial = 0;
  public $mtfis_anoinicialldo = 0;
  public $mtfis_pibano1 = 0;
  public $mtfis_pibano2 = 0;
  public $mtfis_pibano3 = 0;
  public $mtfis_rclano1 = 0;
  public $mtfis_rclano2 = 0;
  public $mtfis_rclano3 = 0;
  public $mtfis_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 mtfis_sequencial = int4 = Sequencial
                 mtfis_anoinicialldo = int4 = ANO INICIAL LDO
                 mtfis_pibano1 = float4 = PIB DO ANO 1
                 mtfis_pibano2 = float4 = PIB DO ANO 2
                 mtfis_pibano3 = float4 = PIB DO ANO 3
                 mtfis_rclano1 = float4 = RCL DO ANO 1
                 mtfis_rclano2 = float4 = RCL DO ANO 2
                 mtfis_rclano3 = float4 = RCL DO ANO 3
                 mtfis_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("mtfis_ldo");
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
       $this->mtfis_sequencial = ($this->mtfis_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_sequencial"]:$this->mtfis_sequencial);
       $this->mtfis_anoinicialldo = ($this->mtfis_anoinicialldo == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_anoinicialldo"]:$this->mtfis_anoinicialldo);
       $this->mtfis_pibano1 = ($this->mtfis_pibano1 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_pibano1"]:$this->mtfis_pibano1);
       $this->mtfis_pibano2 = ($this->mtfis_pibano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_pibano2"]:$this->mtfis_pibano2);
       $this->mtfis_pibano3 = ($this->mtfis_pibano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_pibano3"]:$this->mtfis_pibano3);
       $this->mtfis_rclano1 = ($this->mtfis_rclano1 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_rclano1"]:$this->mtfis_rclano1);
       $this->mtfis_rclano2 = ($this->mtfis_rclano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_rclano2"]:$this->mtfis_rclano2);
       $this->mtfis_rclano3 = ($this->mtfis_rclano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_rclano3"]:$this->mtfis_rclano3);
       $this->mtfis_instit = ($this->mtfis_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_instit"]:$this->mtfis_instit);
     } else {
       $this->mtfis_sequencial = ($this->mtfis_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfis_sequencial"]:$this->mtfis_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($mtfis_sequencial) {
      $this->atualizacampos();
     if ($this->mtfis_anoinicialldo == null ) {
       $this->erro_sql = " Campo ANO INICIAL LDO não informado.";
       $this->erro_campo = "mtfis_anoinicialldo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfis_pibano1 == null ) {
       $this->erro_sql = " Campo PIB DO ANO 1 não informado.";
       $this->erro_campo = "mtfis_pibano1";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfis_pibano2 == null ) {
       $this->erro_sql = " Campo PIB DO ANO 2 não informado.";
       $this->erro_campo = "mtfis_pibano2";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfis_pibano3 == null ) {
       $this->erro_sql = " Campo PIB DO ANO 3 não informado.";
       $this->erro_campo = "mtfis_pibano3";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfis_rclano1 == null ) {
       $this->erro_sql = " Campo RCL DO ANO 1 não informado.";
       $this->erro_campo = "mtfis_rclano1";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfis_rclano2 == null ) {
       $this->erro_sql = " Campo RCL DO ANO 2 não informado.";
       $this->erro_campo = "mtfis_rclano2";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfis_rclano3 == null ) {
       $this->erro_sql = " Campo RCL DO ANO 3 não informado.";
       $this->erro_campo = "mtfis_rclano3";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfis_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "mtfis_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($mtfis_sequencial == "" || $mtfis_sequencial == null ) {
       $result = db_query("select nextval('mtfis_ldo_mtfis_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: mtfis_ldo_mtfis_sequencial_seq do campo: mtfis_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->mtfis_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from mtfis_ldo_mtfis_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $mtfis_sequencial)) {
         $this->erro_sql = " Campo mtfis_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->mtfis_sequencial = $mtfis_sequencial;
       }
     }
     if (($this->mtfis_sequencial == null) || ($this->mtfis_sequencial == "") ) {
       $this->erro_sql = " Campo mtfis_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into mtfis_ldo(
                                       mtfis_sequencial
                                      ,mtfis_anoinicialldo
                                      ,mtfis_pibano1
                                      ,mtfis_pibano2
                                      ,mtfis_pibano3
                                      ,mtfis_rclano1
                                      ,mtfis_rclano2
                                      ,mtfis_rclano3
                                      ,mtfis_instit
                       )
                values (
                                $this->mtfis_sequencial
                               ,$this->mtfis_anoinicialldo
                               ,$this->mtfis_pibano1
                               ,$this->mtfis_pibano2
                               ,$this->mtfis_pibano3
                               ,$this->mtfis_rclano1
                               ,$this->mtfis_rclano2
                               ,$this->mtfis_rclano3
                               ,$this->mtfis_instit
                      )";

     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "mtfis_ldo ($this->mtfis_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "mtfis_ldo já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "mtfis_ldo ($this->mtfis_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->mtfis_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
//     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
//       && ($lSessaoDesativarAccount === false))) {
//
//       $resaco = $this->sql_record($this->sql_query_file($this->mtfis_sequencial  ));
//       if (($resaco!=false)||($this->numrows!=0)) {
//
//         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//         $acount = pg_result($resac,0,0);
//         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//         $resac = db_query("insert into db_acountkey values($acount,2012478,'$this->mtfis_sequencial','I')");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012478,'','".AddSlashes(pg_result($resaco,0,'mtfis_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012479,'','".AddSlashes(pg_result($resaco,0,'mtfis_anoinicialldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012480,'','".AddSlashes(pg_result($resaco,0,'mtfis_pibano1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012481,'','".AddSlashes(pg_result($resaco,0,'mtfis_pibano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012482,'','".AddSlashes(pg_result($resaco,0,'mtfis_pibano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012483,'','".AddSlashes(pg_result($resaco,0,'mtfis_rclano1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012484,'','".AddSlashes(pg_result($resaco,0,'mtfis_rclano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012485,'','".AddSlashes(pg_result($resaco,0,'mtfis_rclano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010193,2012486,'','".AddSlashes(pg_result($resaco,0,'mtfis_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       }
//    }
    return true;
  }

  // funcao para alteracao
  function alterar ($mtfis_sequencial=null) {
      $this->atualizacampos();
     $sql = " update mtfis_ldo set ";
     $virgula = "";
     if (trim($this->mtfis_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_sequencial"])) {
       $sql  .= $virgula." mtfis_sequencial = $this->mtfis_sequencial ";
       $virgula = ",";
       if (trim($this->mtfis_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "mtfis_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_anoinicialldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_anoinicialldo"])) {
       $sql  .= $virgula." mtfis_anoinicialldo = $this->mtfis_anoinicialldo ";
       $virgula = ",";
       if (trim($this->mtfis_anoinicialldo) == null ) {
         $this->erro_sql = " Campo ANO INICIAL LDO não informado.";
         $this->erro_campo = "mtfis_anoinicialldo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_pibano1)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_pibano1"])) {
       $sql  .= $virgula." mtfis_pibano1 = $this->mtfis_pibano1 ";
       $virgula = ",";
       if (trim($this->mtfis_pibano1) == null ) {
         $this->erro_sql = " Campo PIB DO ANO 1 não informado.";
         $this->erro_campo = "mtfis_pibano1";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_pibano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_pibano2"])) {
       $sql  .= $virgula." mtfis_pibano2 = $this->mtfis_pibano2 ";
       $virgula = ",";
       if (trim($this->mtfis_pibano2) == null ) {
         $this->erro_sql = " Campo PIB DO ANO 2 não informado.";
         $this->erro_campo = "mtfis_pibano2";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_pibano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_pibano3"])) {
       $sql  .= $virgula." mtfis_pibano3 = $this->mtfis_pibano3 ";
       $virgula = ",";
       if (trim($this->mtfis_pibano3) == null ) {
         $this->erro_sql = " Campo PIB DO ANO 3 não informado.";
         $this->erro_campo = "mtfis_pibano3";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_rclano1)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_rclano1"])) {
       $sql  .= $virgula." mtfis_rclano1 = $this->mtfis_rclano1 ";
       $virgula = ",";
       if (trim($this->mtfis_rclano1) == null ) {
         $this->erro_sql = " Campo RCL DO ANO 1 não informado.";
         $this->erro_campo = "mtfis_rclano1";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_rclano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_rclano2"])) {
       $sql  .= $virgula." mtfis_rclano2 = $this->mtfis_rclano2 ";
       $virgula = ",";
       if (trim($this->mtfis_rclano2) == null ) {
         $this->erro_sql = " Campo RCL DO ANO 2 não informado.";
         $this->erro_campo = "mtfis_rclano2";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_rclano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_rclano3"])) {
       $sql  .= $virgula." mtfis_rclano3 = $this->mtfis_rclano3 ";
       $virgula = ",";
       if (trim($this->mtfis_rclano3) == null ) {
         $this->erro_sql = " Campo RCL DO ANO 3 não informado.";
         $this->erro_campo = "mtfis_rclano3";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfis_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfis_instit"])) {
       $sql  .= $virgula." mtfis_instit = $this->mtfis_instit ";
       $virgula = ",";
       if (trim($this->mtfis_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "mtfis_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($mtfis_sequencial!=null) {
       $sql .= " mtfis_sequencial = $this->mtfis_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
//     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
//       && ($lSessaoDesativarAccount === false))) {
//
//       $resaco = $this->sql_record($this->sql_query_file($this->mtfis_sequencial));
//       if ($this->numrows>0) {
//
//         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {
//
//           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//           $acount = pg_result($resac,0,0);
//           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//           $resac = db_query("insert into db_acountkey values($acount,2012478,'$this->mtfis_sequencial','A')");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_sequencial"]) || $this->mtfis_sequencial != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012478,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_sequencial'))."','$this->mtfis_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_anoinicialldo"]) || $this->mtfis_anoinicialldo != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012479,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_anoinicialldo'))."','$this->mtfis_anoinicialldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_pibano1"]) || $this->mtfis_pibano1 != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012480,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_pibano1'))."','$this->mtfis_pibano1',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_pibano2"]) || $this->mtfis_pibano2 != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012481,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_pibano2'))."','$this->mtfis_pibano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_pibano3"]) || $this->mtfis_pibano3 != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012482,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_pibano3'))."','$this->mtfis_pibano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_rclano1"]) || $this->mtfis_rclano1 != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012483,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_rclano1'))."','$this->mtfis_rclano1',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_rclano2"]) || $this->mtfis_rclano2 != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012484,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_rclano2'))."','$this->mtfis_rclano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_rclano3"]) || $this->mtfis_rclano3 != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012485,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_rclano3'))."','$this->mtfis_rclano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfis_instit"]) || $this->mtfis_instit != "")
//             $resac = db_query("insert into db_acount values($acount,1010193,2012486,'".AddSlashes(pg_result($resaco,$conresaco,'mtfis_instit'))."','$this->mtfis_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         }
//       }
//     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "mtfis_ldo nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->mtfis_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "mtfis_ldo nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->mtfis_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->mtfis_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($mtfis_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($mtfis_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2012478,'$mtfis_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012478,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012479,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_anoinicialldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012480,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_pibano1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012481,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_pibano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012482,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_pibano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012483,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_rclano1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012484,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_rclano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012485,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_rclano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2012486,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfis_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from mtfis_ldo
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($mtfis_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " mtfis_sequencial = $mtfis_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "mtfis_ldo nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$mtfis_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "mtfis_ldo nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$mtfis_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$mtfis_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:mtfis_ldo";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $mtfis_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from mtfis_ldo ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($mtfis_sequencial!=null ) {
         $sql2 .= " where mtfis_ldo.mtfis_sequencial = $mtfis_sequencial ";
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
  function sql_query_file ( $mtfis_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from mtfis_ldo ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($mtfis_sequencial!=null ) {
         $sql2 .= " where mtfis_ldo.mtfis_sequencial = $mtfis_sequencial ";
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
