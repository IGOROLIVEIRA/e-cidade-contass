<?php
//MODULO: sicom
//CLASSE DA ENTIDADE balancete252018
class cl_balancete252018 { 
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
  public $si194_sequencial = 0; 
  public $si194_tiporegistro = 0; 
  public $si194_contacontabil = 0; 
  public $si194_codfundo = null; 
  public $si194_atributosf = null; 
  public $si194_naturezareceita = 0; 
  public $si194_saldoinicialsf = 0; 
  public $si194_naturezasaldoinicialsf = null; 
  public $si194_totaldebitossf = 0; 
  public $si194_totalcreditossf = 0; 
  public $si194_saldofinalsf = 0; 
  public $si194_naturezasaldofinalsf = null; 
  public $si194_mes = 0; 
  public $si194_instit = 0; 
  public $si194_reg10 = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 si194_sequencial = int8 = si194_sequencial 
                 si194_tiporegistro = int8 = si194_tiporegistro 
                 si194_contacontabil = int8 = si194_contacontabil 
                 si194_codfundo = varchar(8) = si194_codfundo 
                 si194_atributosf = varchar(1) = si194_atributosf 
                 si194_naturezareceita = int8 = si194_naturezareceita 
                 si194_saldoinicialsf = float8 = si194_saldoinicialsf 
                 si194_naturezasaldoinicialsf = varchar(1) = si194_naturezasaldoinicialsf 
                 si194_totaldebitossf = float8 = si194_totaldebitossf 
                 si194_totalcreditossf = float8 = si194_totalcreditossf 
                 si194_saldofinalsf = float8 = si194_saldofinalsf 
                 si194_naturezasaldofinalsf = varchar(1) = si194_naturezasaldofinalsf 
                 si194_mes = int8 = si194_mes 
                 si194_instit = int8 = si194_instit 
                 si194_reg10 = int8 = si194_reg10 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete252018"); 
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
       $this->si194_sequencial = ($this->si194_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]:$this->si194_sequencial);
       $this->si194_tiporegistro = ($this->si194_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"]:$this->si194_tiporegistro);
       $this->si194_contacontabil = ($this->si194_contacontabil == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_contacontabil"]:$this->si194_contacontabil);
       $this->si194_codfundo = ($this->si194_codfundo == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_codfundo"]:$this->si194_codfundo);
       $this->si194_atributosf = ($this->si194_atributosf == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_atributosf"]:$this->si194_atributosf);
       $this->si194_naturezareceita = ($this->si194_naturezareceita == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_naturezareceita"]:$this->si194_naturezareceita);
       $this->si194_saldoinicialsf = ($this->si194_saldoinicialsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_saldoinicialsf"]:$this->si194_saldoinicialsf);
       $this->si194_naturezasaldoinicialsf = ($this->si194_naturezasaldoinicialsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_naturezasaldoinicialsf"]:$this->si194_naturezasaldoinicialsf);
       $this->si194_totaldebitossf = ($this->si194_totaldebitossf == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_totaldebitossf"]:$this->si194_totaldebitossf);
       $this->si194_totalcreditossf = ($this->si194_totalcreditossf == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_totalcreditossf"]:$this->si194_totalcreditossf);
       $this->si194_saldofinalsf = ($this->si194_saldofinalsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_saldofinalsf"]:$this->si194_saldofinalsf);
       $this->si194_naturezasaldofinalsf = ($this->si194_naturezasaldofinalsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_naturezasaldofinalsf"]:$this->si194_naturezasaldofinalsf);
       $this->si194_mes = ($this->si194_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_mes"]:$this->si194_mes);
       $this->si194_instit = ($this->si194_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_instit"]:$this->si194_instit);
       $this->si194_reg10 = ($this->si194_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_reg10"]:$this->si194_reg10);
     } else {
       $this->si194_sequencial = ($this->si194_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]:$this->si194_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si194_sequencial) { 
      $this->atualizacampos();
     if ($this->si194_tiporegistro == null ) { 
       $this->erro_sql = " Campo si194_tiporegistro não informado.";
       $this->erro_campo = "si194_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_contacontabil == null ) { 
       $this->erro_sql = " Campo si194_contacontabil não informado.";
       $this->erro_campo = "si194_contacontabil";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_codfundo == null ) { 
       $this->erro_sql = " Campo si194_codfundo não informado.";
       $this->erro_campo = "si194_codfundo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_atributosf == null ) { 
       $this->erro_sql = " Campo si194_atributosf não informado.";
       $this->erro_campo = "si194_atributosf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_naturezareceita == null ) { 
       $this->erro_sql = " Campo si194_naturezareceita não informado.";
       $this->erro_campo = "si194_naturezareceita";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
//     if ($this->si194_saldoinicialsf == null ) {
//       $this->erro_sql = " Campo si194_saldoinicialsf não informado.";
//       $this->erro_campo = "si194_saldoinicialsf";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->si194_naturezasaldoinicialsf == null ) {
       $this->erro_sql = " Campo si194_naturezasaldoinicialsf não informado.";
       $this->erro_campo = "si194_naturezasaldoinicialsf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
//     if ($this->si194_totaldebitossf == null ) {
//       $this->erro_sql = " Campo si194_totaldebitossf não informado.";
//       $this->erro_campo = "si194_totaldebitossf";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
//     if ($this->si194_totalcreditossf == null ) {
//       $this->erro_sql = " Campo si194_totalcreditossf não informado.";
//       $this->erro_campo = "si194_totalcreditossf";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->si194_saldofinalsf == null ) { 
       $this->erro_sql = " Campo si194_saldofinalsf não informado.";
       $this->erro_campo = "si194_saldofinalsf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_naturezasaldofinalsf == null ) { 
       $this->erro_sql = " Campo si194_naturezasaldofinalsf não informado.";
       $this->erro_campo = "si194_naturezasaldofinalsf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_mes == null ) { 
       $this->erro_sql = " Campo si194_mes não informado.";
       $this->erro_campo = "si194_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_instit == null ) { 
       $this->erro_sql = " Campo si194_instit não informado.";
       $this->erro_campo = "si194_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si194_reg10 == null ) { 
       $this->erro_sql = " Campo si194_reg10 não informado.";
       $this->erro_campo = "si194_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

    if ($si194_sequencial == "" || $si194_sequencial == null) {
      $result = db_query("select nextval('balancete252018_si194_sequencial_seq')");
      
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete252018_si194_sequencial_seq do campo: si194_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si194_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete252018_si194_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si194_sequencial)) {
        $this->erro_sql = " Campo si194_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si194_sequencial = $si194_sequencial;
      }
    }
    if (($this->si194_sequencial == null) || ($this->si194_sequencial == "")) {
      $this->erro_sql = " Campo si194_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }

     $sql = "insert into balancete252018(
                                       si194_sequencial 
                                      ,si194_tiporegistro 
                                      ,si194_contacontabil 
                                      ,si194_codfundo 
                                      ,si194_atributosf 
                                      ,si194_naturezareceita 
                                      ,si194_saldoinicialsf 
                                      ,si194_naturezasaldoinicialsf 
                                      ,si194_totaldebitossf 
                                      ,si194_totalcreditossf 
                                      ,si194_saldofinalsf 
                                      ,si194_naturezasaldofinalsf 
                                      ,si194_mes 
                                      ,si194_instit 
                                      ,si194_reg10 
                       )
                values (
                                $this->si194_sequencial 
                               ,$this->si194_tiporegistro 
                               ,$this->si194_contacontabil 
                               ,'$this->si194_codfundo' 
                               ,'$this->si194_atributosf' 
                               ,$this->si194_naturezareceita
                               ,".($this->si194_saldoinicialsf == "null" || $this->si194_saldoinicialsf == "" ? 0 : $this->si194_saldoinicialsf)."
                               ,'$this->si194_naturezasaldoinicialsf' 
                               ,$this->si194_totaldebitossf 
                               ,".($this->si194_totalcreditossf == "null" || $this->si194_totalcreditossf == "" ? 0 : $this->si194_totalcreditossf)."
                               ,".($this->si194_saldofinalsf == "null" || $this->si194_saldofinalsf == "" ? 0 : $this->si194_saldofinalsf)."
                               ,'$this->si194_naturezasaldofinalsf' 
                               ,$this->si194_mes 
                               ,$this->si194_instit 
                               ,$this->si194_reg10 
                      )";
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "balancete252018 ($this->si194_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "balancete252018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "balancete252018 ($this->si194_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si194_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si194_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009251,'$this->si194_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,0,'si194_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,0,'si194_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,0,'si194_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,0,'si194_codfundo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,0,'si194_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,0,'si194_naturezareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,0,'si194_saldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'si194_naturezasaldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,0,'si194_totaldebitossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,0,'si194_totalcreditossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,0,'si194_saldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,0,'si194_naturezasaldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,0,'si194_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,0,'si194_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,0,'si194_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si194_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update balancete252018 set ";
     $virgula = "";
     if (trim($this->si194_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"])) { 
       $sql  .= $virgula." si194_sequencial = $this->si194_sequencial ";
       $virgula = ",";
       if (trim($this->si194_sequencial) == null ) { 
         $this->erro_sql = " Campo si194_sequencial não informado.";
         $this->erro_campo = "si194_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"])) { 
       $sql  .= $virgula." si194_tiporegistro = $this->si194_tiporegistro ";
       $virgula = ",";
       if (trim($this->si194_tiporegistro) == null ) { 
         $this->erro_sql = " Campo si194_tiporegistro não informado.";
         $this->erro_campo = "si194_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_contacontabil)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_contacontabil"])) { 
       $sql  .= $virgula." si194_contacontabil = $this->si194_contacontabil ";
       $virgula = ",";
       if (trim($this->si194_contacontabil) == null ) { 
         $this->erro_sql = " Campo si194_contacontabil não informado.";
         $this->erro_campo = "si194_contacontabil";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_codfundo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codfundo"])) { 
       $sql  .= $virgula." si194_codfundo = '$this->si194_codfundo' ";
       $virgula = ",";
       if (trim($this->si194_codfundo) == null ) { 
         $this->erro_sql = " Campo si194_codfundo não informado.";
         $this->erro_campo = "si194_codfundo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_atributosf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_atributosf"])) { 
       $sql  .= $virgula." si194_atributosf = '$this->si194_atributosf' ";
       $virgula = ",";
       if (trim($this->si194_atributosf) == null ) { 
         $this->erro_sql = " Campo si194_atributosf não informado.";
         $this->erro_campo = "si194_atributosf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_naturezareceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezareceita"])) { 
       $sql  .= $virgula." si194_naturezareceita = $this->si194_naturezareceita ";
       $virgula = ",";
       if (trim($this->si194_naturezareceita) == null ) { 
         $this->erro_sql = " Campo si194_naturezareceita não informado.";
         $this->erro_campo = "si194_naturezareceita";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_saldoinicialsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_saldoinicialsf"])) { 
       $sql  .= $virgula." si194_saldoinicialsf = $this->si194_saldoinicialsf ";
       $virgula = ",";
       if (trim($this->si194_saldoinicialsf) == null ) { 
         $this->erro_sql = " Campo si194_saldoinicialsf não informado.";
         $this->erro_campo = "si194_saldoinicialsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_naturezasaldoinicialsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezasaldoinicialsf"])) { 
       $sql  .= $virgula." si194_naturezasaldoinicialsf = '$this->si194_naturezasaldoinicialsf' ";
       $virgula = ",";
       if (trim($this->si194_naturezasaldoinicialsf) == null ) { 
         $this->erro_sql = " Campo si194_naturezasaldoinicialsf não informado.";
         $this->erro_campo = "si194_naturezasaldoinicialsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_totaldebitossf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_totaldebitossf"])) { 
       $sql  .= $virgula." si194_totaldebitossf = $this->si194_totaldebitossf ";
       $virgula = ",";
       if (trim($this->si194_totaldebitossf) == null ) { 
         $this->erro_sql = " Campo si194_totaldebitossf não informado.";
         $this->erro_campo = "si194_totaldebitossf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_totalcreditossf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_totalcreditossf"])) { 
       $sql  .= $virgula." si194_totalcreditossf = $this->si194_totalcreditossf ";
       $virgula = ",";
       if (trim($this->si194_totalcreditossf) == null ) { 
         $this->erro_sql = " Campo si194_totalcreditossf não informado.";
         $this->erro_campo = "si194_totalcreditossf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_saldofinalsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_saldofinalsf"])) { 
       $sql  .= $virgula." si194_saldofinalsf = $this->si194_saldofinalsf ";
       $virgula = ",";
       if (trim($this->si194_saldofinalsf) == null ) { 
         $this->erro_sql = " Campo si194_saldofinalsf não informado.";
         $this->erro_campo = "si194_saldofinalsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_naturezasaldofinalsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezasaldofinalsf"])) { 
       $sql  .= $virgula." si194_naturezasaldofinalsf = '$this->si194_naturezasaldofinalsf' ";
       $virgula = ",";
       if (trim($this->si194_naturezasaldofinalsf) == null ) { 
         $this->erro_sql = " Campo si194_naturezasaldofinalsf não informado.";
         $this->erro_campo = "si194_naturezasaldofinalsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_mes"])) { 
       $sql  .= $virgula." si194_mes = $this->si194_mes ";
       $virgula = ",";
       if (trim($this->si194_mes) == null ) { 
         $this->erro_sql = " Campo si194_mes não informado.";
         $this->erro_campo = "si194_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_instit"])) { 
       $sql  .= $virgula." si194_instit = $this->si194_instit ";
       $virgula = ",";
       if (trim($this->si194_instit) == null ) { 
         $this->erro_sql = " Campo si194_instit não informado.";
         $this->erro_campo = "si194_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si194_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_reg10"])) { 
       $sql  .= $virgula." si194_reg10 = $this->si194_reg10 ";
       $virgula = ",";
       if (trim($this->si194_reg10) == null ) { 
         $this->erro_sql = " Campo si194_reg10 não informado.";
         $this->erro_campo = "si194_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si194_sequencial!=null) {
       $sql .= " si194_sequencial = $this->si194_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    /* if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si194_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009251,'$this->si194_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]) || $this->si194_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'si194_sequencial'))."','$this->si194_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"]) || $this->si194_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'si194_tiporegistro'))."','$this->si194_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_contacontabil"]) || $this->si194_contacontabil != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'si194_contacontabil'))."','$this->si194_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codfundo"]) || $this->si194_codfundo != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'si194_codfundo'))."','$this->si194_codfundo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_atributosf"]) || $this->si194_atributosf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'si194_atributosf'))."','$this->si194_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezareceita"]) || $this->si194_naturezareceita != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'si194_naturezareceita'))."','$this->si194_naturezareceita',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_saldoinicialsf"]) || $this->si194_saldoinicialsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'si194_saldoinicialsf'))."','$this->si194_saldoinicialsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezasaldoinicialsf"]) || $this->si194_naturezasaldoinicialsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'si194_naturezasaldoinicialsf'))."','$this->si194_naturezasaldoinicialsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_totaldebitossf"]) || $this->si194_totaldebitossf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'si194_totaldebitossf'))."','$this->si194_totaldebitossf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_totalcreditossf"]) || $this->si194_totalcreditossf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009260,'".AddSlashes(pg_result($resaco,$conresaco,'si194_totalcreditossf'))."','$this->si194_totalcreditossf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_saldofinalsf"]) || $this->si194_saldofinalsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009261,'".AddSlashes(pg_result($resaco,$conresaco,'si194_saldofinalsf'))."','$this->si194_saldofinalsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezasaldofinalsf"]) || $this->si194_naturezasaldofinalsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009262,'".AddSlashes(pg_result($resaco,$conresaco,'si194_naturezasaldofinalsf'))."','$this->si194_naturezasaldofinalsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_mes"]) || $this->si194_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009263,'".AddSlashes(pg_result($resaco,$conresaco,'si194_mes'))."','$this->si194_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_instit"]) || $this->si194_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'si194_instit'))."','$this->si194_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si194_reg10"]) || $this->si194_reg10 != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009265,'".AddSlashes(pg_result($resaco,$conresaco,'si194_reg10'))."','$this->si194_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "balancete252018 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si194_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "balancete252018 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si194_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si194_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($si194_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si194_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
/*       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009251,'$si194_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_codfundo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_naturezareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_saldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_naturezasaldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_totaldebitossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_totalcreditossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_saldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_naturezasaldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }*/
     }
     $sql = " delete from balancete252018
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si194_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si194_sequencial = $si194_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "balancete252018 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si194_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "balancete252018 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si194_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si194_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:balancete252018";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $si194_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from balancete252018 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si194_sequencial!=null ) {
         $sql2 .= " where balancete252018.si194_sequencial = $si194_sequencial "; 
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
  function sql_query_file ( $si194_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from balancete252018 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si194_sequencial!=null ) {
         $sql2 .= " where balancete252018.si194_sequencial = $si194_sequencial "; 
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
