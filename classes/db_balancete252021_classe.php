<?php
//MODULO: sicom
//CLASSE DA ENTIDADE balancete252021
class cl_balancete252021 {
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
  public $si195_sequencial = 0;
  public $si195_tiporegistro = 0;
  public $si195_contacontabil = 0;
  public $si195_codfundo = null;
  public $si195_atributosf = null;
  public $si195_naturezareceita = 0;
  public $si195_saldoinicialnrsf = 0;
  public $si195_naturezasaldoinicialnrsf = null;
  public $si195_totaldebitosnrsf = 0;
  public $si195_totalcreditosnrsf = 0;
  public $si195_saldofinalnrsf = 0;
  public $si195_naturezasaldofinalnrsf = null;
  public $si195_mes = 0;
  public $si195_instit = 0;
  public $si195_reg10 = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si195_sequencial = int8 = si195_sequencial
                 si195_tiporegistro = int8 = si195_tiporegistro
                 si195_contacontabil = int8 = si195_contacontabil
                 si195_codfundo = varchar(8) = si195_codfundo
                 si195_atributosf = varchar(1) = si195_atributosf
                 si195_naturezareceita = int8 = si195_naturezareceita
                 si195_saldoinicialnrsf = float8 = si195_saldoinicialnrsf
                 si195_naturezasaldoinicialnrsf = varchar(1) = si195_naturezasaldoinicialnrsf
                 si195_totaldebitosnrsf = float8 = si195_totaldebitosnrsf
                 si195_totalcreditosnrsf = float8 = si195_totalcreditosnrsf
                 si195_saldofinalnrsf = float8 = si195_saldofinalnrsf
                 si195_naturezasaldofinalnrsf = varchar(1) = si195_naturezasaldofinalnrsf
                 si195_mes = int8 = si195_mes
                 si195_instit = int8 = si195_instit
                 si195_reg10 = int8 = si195_reg10
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete252021");
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
       $this->si195_sequencial = ($this->si195_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_sequencial"]:$this->si195_sequencial);
       $this->si195_tiporegistro = ($this->si195_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"]:$this->si195_tiporegistro);
       $this->si195_contacontabil = ($this->si195_contacontabil == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_contacontabil"]:$this->si195_contacontabil);
       $this->si195_codfundo = ($this->si195_codfundo == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_codfundo"]:$this->si195_codfundo);
       $this->si195_atributosf = ($this->si195_atributosf == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_atributosf"]:$this->si195_atributosf);
       $this->si195_naturezareceita = ($this->si195_naturezareceita == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_naturezareceita"]:$this->si195_naturezareceita);
       $this->si195_saldoinicialnrsf = ($this->si195_saldoinicialnrsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_saldoinicialnrsf"]:$this->si195_saldoinicialnrsf);
       $this->si195_naturezasaldoinicialnrsf = ($this->si195_naturezasaldoinicialnrsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_naturezasaldoinicialnrsf"]:$this->si195_naturezasaldoinicialnrsf);
       $this->si195_totaldebitosnrsf = ($this->si195_totaldebitosnrsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_totaldebitosnrsf"]:$this->si195_totaldebitosnrsf);
       $this->si195_totalcreditosnrsf = ($this->si195_totalcreditosnrsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_totalcreditosnrsf"]:$this->si195_totalcreditosnrsf);
       $this->si195_saldofinalnrsf = ($this->si195_saldofinalnrsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_saldofinalnrsf"]:$this->si195_saldofinalnrsf);
       $this->si195_naturezasaldofinalnrsf = ($this->si195_naturezasaldofinalnrsf == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_naturezasaldofinalnrsf"]:$this->si195_naturezasaldofinalnrsf);
       $this->si195_mes = ($this->si195_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_mes"]:$this->si195_mes);
       $this->si195_instit = ($this->si195_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_instit"]:$this->si195_instit);
       $this->si195_reg10 = ($this->si195_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_reg10"]:$this->si195_reg10);
     } else {
       $this->si195_sequencial = ($this->si195_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_sequencial"]:$this->si195_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si195_sequencial) {
      $this->atualizacampos();
     if ($this->si195_tiporegistro == null ) {
       $this->erro_sql = " Campo si195_tiporegistro não informado.";
       $this->erro_campo = "si195_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_contacontabil == null ) {
       $this->erro_sql = " Campo si195_contacontabil não informado.";
       $this->erro_campo = "si195_contacontabil";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_codfundo == null ) {
       $this->erro_sql = " Campo si195_codfundo não informado.";
       $this->erro_campo = "si195_codfundo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_atributosf == null ) {
       $this->erro_sql = " Campo si195_atributosf não informado.";
       $this->erro_campo = "si195_atributosf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_naturezareceita == null ) {
       $this->erro_sql = " Campo si195_naturezareceita não informado.";
       $this->erro_campo = "si195_naturezareceita";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
    // if ($this->si195_saldoinicialnrsf == null ) {
    //   $this->erro_sql = " Campo si195_saldoinicialnrsf não informado.";
    //   $this->erro_campo = "si195_saldoinicialnrsf";
    //   $this->erro_banco = "";
    //   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    //   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    //   $this->erro_status = "0";
    //   return false;
    // }
     if ($this->si195_naturezasaldoinicialnrsf == null ) {
       $this->erro_sql = " Campo si195_naturezasaldoinicialnrsf não informado.";
       $this->erro_campo = "si195_naturezasaldoinicialnrsf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
//     if ($this->si195_totaldebitosnrsf == null ) {
//       $this->erro_sql = " Campo si195_totaldebitosnrsf não informado.";
//       $this->erro_campo = "si195_totaldebitosnrsf";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
//     if ($this->si195_totalcreditosnrsf == null ) {
//       $this->erro_sql = " Campo si195_totalcreditosnrsf não informado.";
//       $this->erro_campo = "si195_totalcreditosnrsf";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->si195_saldofinalnrsf == null ) {
       $this->erro_sql = " Campo si195_saldofinalnrsf não informado.";
       $this->erro_campo = "si195_saldofinalnrsf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_naturezasaldofinalnrsf == null ) {
       $this->erro_sql = " Campo si195_naturezasaldofinalnrsf não informado.";
       $this->erro_campo = "si195_naturezasaldofinalnrsf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_mes == null ) {
       $this->erro_sql = " Campo si195_mes não informado.";
       $this->erro_campo = "si195_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_instit == null ) {
       $this->erro_sql = " Campo si195_instit não informado.";
       $this->erro_campo = "si195_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si195_reg10 == null ) {
       $this->erro_sql = " Campo si195_reg10 não informado.";
       $this->erro_campo = "si195_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

    if ($si195_sequencial == "" || $si195_sequencial == null) {
      $result = db_query("select nextval('balancete252021_si195_sequencial_seq')");

      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete252021_si195_sequencial_seq do campo: si195_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si195_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete252021_si195_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si195_sequencial)) {
        $this->erro_sql = " Campo si195_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si195_sequencial = $si195_sequencial;
      }
    }
    if (($this->si195_sequencial == null) || ($this->si195_sequencial == "")) {
      $this->erro_sql = " Campo si195_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

     $sql = "insert into balancete252021(
                                       si195_sequencial
                                      ,si195_tiporegistro
                                      ,si195_contacontabil
                                      ,si195_codfundo
                                      ,si195_atributosf
                                      ,si195_naturezareceita
                                      ,si195_saldoinicialnrsf
                                      ,si195_naturezasaldoinicialnrsf
                                      ,si195_totaldebitosnrsf
                                      ,si195_totalcreditosnrsf
                                      ,si195_saldofinalnrsf
                                      ,si195_naturezasaldofinalnrsf
                                      ,si195_mes
                                      ,si195_instit
                                      ,si195_reg10
                       )
                values (
                                $this->si195_sequencial
                               ,$this->si195_tiporegistro
                               ,$this->si195_contacontabil
                               ,'$this->si195_codfundo'
                               ,'$this->si195_atributosf'
                               ,$this->si195_naturezareceita
                               ,".($this->si195_saldoinicialnrsf == "null" || $this->si195_saldoinicialnrsf == "" ? 0 : $this->si195_saldoinicialnrsf)."
                               ,'$this->si195_naturezasaldoinicialnrsf'
                               ,$this->si195_totaldebitosnrsf
                               ,".($this->si195_totalcreditosnrsf == "null" || $this->si195_totalcreditosnrsf == "" ? 0 : $this->si195_totalcreditosnrsf)."
                               ,".($this->si195_saldofinalnrsf == "null" || $this->si195_saldofinalnrsf == "" ? 0 : $this->si195_saldofinalnrsf)."
                               ,'$this->si195_naturezasaldofinalnrsf'
                               ,$this->si195_mes
                               ,$this->si195_instit
                               ,$this->si195_reg10
                      )";

     $result = db_query($sql);

     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "balancete252021 ($this->si195_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "balancete252021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "balancete252021 ($this->si195_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si195_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si195_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009251,'$this->si195_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,0,'si195_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,0,'si195_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,0,'si195_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,0,'si195_codfundo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,0,'si195_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,0,'si195_naturezareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,0,'si195_saldoinicialnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'si195_naturezasaldoinicialnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,0,'si195_totaldebitosnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,0,'si195_totalcreditosnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,0,'si195_saldofinalnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,0,'si195_naturezasaldofinalnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,0,'si195_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,0,'si195_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,0,'si195_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si195_sequencial=null) {
      $this->atualizacampos();
     $sql = " update balancete252021 set ";
     $virgula = "";
     if (trim($this->si195_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_sequencial"])) {
       $sql  .= $virgula." si195_sequencial = $this->si195_sequencial ";
       $virgula = ",";
       if (trim($this->si195_sequencial) == null ) {
         $this->erro_sql = " Campo si195_sequencial não informado.";
         $this->erro_campo = "si195_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"])) {
       $sql  .= $virgula." si195_tiporegistro = $this->si195_tiporegistro ";
       $virgula = ",";
       if (trim($this->si195_tiporegistro) == null ) {
         $this->erro_sql = " Campo si195_tiporegistro não informado.";
         $this->erro_campo = "si195_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_contacontabil)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_contacontabil"])) {
       $sql  .= $virgula." si195_contacontabil = $this->si195_contacontabil ";
       $virgula = ",";
       if (trim($this->si195_contacontabil) == null ) {
         $this->erro_sql = " Campo si195_contacontabil não informado.";
         $this->erro_campo = "si195_contacontabil";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_codfundo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_codfundo"])) {
       $sql  .= $virgula." si195_codfundo = '$this->si195_codfundo' ";
       $virgula = ",";
       if (trim($this->si195_codfundo) == null ) {
         $this->erro_sql = " Campo si195_codfundo não informado.";
         $this->erro_campo = "si195_codfundo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_atributosf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_atributosf"])) {
       $sql  .= $virgula." si195_atributosf = '$this->si195_atributosf' ";
       $virgula = ",";
       if (trim($this->si195_atributosf) == null ) {
         $this->erro_sql = " Campo si195_atributosf não informado.";
         $this->erro_campo = "si195_atributosf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_naturezareceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_naturezareceita"])) {
       $sql  .= $virgula." si195_naturezareceita = $this->si195_naturezareceita ";
       $virgula = ",";
       if (trim($this->si195_naturezareceita) == null ) {
         $this->erro_sql = " Campo si195_naturezareceita não informado.";
         $this->erro_campo = "si195_naturezareceita";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_saldoinicialnrsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_saldoinicialnrsf"])) {
       $sql  .= $virgula." si195_saldoinicialnrsf = $this->si195_saldoinicialnrsf ";
       $virgula = ",";
       if (trim($this->si195_saldoinicialnrsf) == null ) {
         $this->erro_sql = " Campo si195_saldoinicialnrsf não informado.";
         $this->erro_campo = "si195_saldoinicialnrsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_naturezasaldoinicialnrsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_naturezasaldoinicialnrsf"])) {
       $sql  .= $virgula." si195_naturezasaldoinicialnrsf = '$this->si195_naturezasaldoinicialnrsf' ";
       $virgula = ",";
       if (trim($this->si195_naturezasaldoinicialnrsf) == null ) {
         $this->erro_sql = " Campo si195_naturezasaldoinicialnrsf não informado.";
         $this->erro_campo = "si195_naturezasaldoinicialnrsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_totaldebitosnrsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_totaldebitosnrsf"])) {
       $sql  .= $virgula." si195_totaldebitosnrsf = $this->si195_totaldebitosnrsf ";
       $virgula = ",";
       if (trim($this->si195_totaldebitosnrsf) == null ) {
         $this->erro_sql = " Campo si195_totaldebitosnrsf não informado.";
         $this->erro_campo = "si195_totaldebitosnrsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_totalcreditosnrsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_totalcreditosnrsf"])) {
       $sql  .= $virgula." si195_totalcreditosnrsf = $this->si195_totalcreditosnrsf ";
       $virgula = ",";
       if (trim($this->si195_totalcreditosnrsf) == null ) {
         $this->erro_sql = " Campo si195_totalcreditosnrsf não informado.";
         $this->erro_campo = "si195_totalcreditosnrsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_saldofinalnrsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_saldofinalnrsf"])) {
       $sql  .= $virgula." si195_saldofinalnrsf = $this->si195_saldofinalnrsf ";
       $virgula = ",";
       if (trim($this->si195_saldofinalnrsf) == null ) {
         $this->erro_sql = " Campo si195_saldofinalnrsf não informado.";
         $this->erro_campo = "si195_saldofinalnrsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_naturezasaldofinalnrsf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_naturezasaldofinalnrsf"])) {
       $sql  .= $virgula." si195_naturezasaldofinalnrsf = '$this->si195_naturezasaldofinalnrsf' ";
       $virgula = ",";
       if (trim($this->si195_naturezasaldofinalnrsf) == null ) {
         $this->erro_sql = " Campo si195_naturezasaldofinalnrsf não informado.";
         $this->erro_campo = "si195_naturezasaldofinalnrsf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_mes"])) {
       $sql  .= $virgula." si195_mes = $this->si195_mes ";
       $virgula = ",";
       if (trim($this->si195_mes) == null ) {
         $this->erro_sql = " Campo si195_mes não informado.";
         $this->erro_campo = "si195_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_instit"])) {
       $sql  .= $virgula." si195_instit = $this->si195_instit ";
       $virgula = ",";
       if (trim($this->si195_instit) == null ) {
         $this->erro_sql = " Campo si195_instit não informado.";
         $this->erro_campo = "si195_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si195_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_reg10"])) {
       $sql  .= $virgula." si195_reg10 = $this->si195_reg10 ";
       $virgula = ",";
       if (trim($this->si195_reg10) == null ) {
         $this->erro_sql = " Campo si195_reg10 não informado.";
         $this->erro_campo = "si195_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si195_sequencial!=null) {
       $sql .= " si195_sequencial = $this->si195_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    /* if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si195_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009251,'$this->si195_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_sequencial"]) || $this->si195_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'si195_sequencial'))."','$this->si195_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"]) || $this->si195_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'si195_tiporegistro'))."','$this->si195_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_contacontabil"]) || $this->si195_contacontabil != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'si195_contacontabil'))."','$this->si195_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_codfundo"]) || $this->si195_codfundo != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'si195_codfundo'))."','$this->si195_codfundo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_atributosf"]) || $this->si195_atributosf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'si195_atributosf'))."','$this->si195_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_naturezareceita"]) || $this->si195_naturezareceita != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'si195_naturezareceita'))."','$this->si195_naturezareceita',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_saldoinicialnrsf"]) || $this->si195_saldoinicialnrsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'si195_saldoinicialnrsf'))."','$this->si195_saldoinicialnrsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_naturezasaldoinicialnrsf"]) || $this->si195_naturezasaldoinicialnrsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'si195_naturezasaldoinicialnrsf'))."','$this->si195_naturezasaldoinicialnrsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_totaldebitosnrsf"]) || $this->si195_totaldebitosnrsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'si195_totaldebitosnrsf'))."','$this->si195_totaldebitosnrsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_totalcreditosnrsf"]) || $this->si195_totalcreditosnrsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009260,'".AddSlashes(pg_result($resaco,$conresaco,'si195_totalcreditosnrsf'))."','$this->si195_totalcreditosnrsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_saldofinalnrsf"]) || $this->si195_saldofinalnrsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009261,'".AddSlashes(pg_result($resaco,$conresaco,'si195_saldofinalnrsf'))."','$this->si195_saldofinalnrsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_naturezasaldofinalnrsf"]) || $this->si195_naturezasaldofinalnrsf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009262,'".AddSlashes(pg_result($resaco,$conresaco,'si195_naturezasaldofinalnrsf'))."','$this->si195_naturezasaldofinalnrsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_mes"]) || $this->si195_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009263,'".AddSlashes(pg_result($resaco,$conresaco,'si195_mes'))."','$this->si195_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_instit"]) || $this->si195_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'si195_instit'))."','$this->si195_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si195_reg10"]) || $this->si195_reg10 != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009265,'".AddSlashes(pg_result($resaco,$conresaco,'si195_reg10'))."','$this->si195_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "balancete252021 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si195_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "balancete252021 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si195_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si195_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si195_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si195_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
/*       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009251,'$si195_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_codfundo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_naturezareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_saldoinicialnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_naturezasaldoinicialnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_totaldebitosnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_totalcreditosnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_saldofinalnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_naturezasaldofinalnrsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }*/
     }
     $sql = " delete from balancete252021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si195_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si195_sequencial = $si195_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "balancete252021 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si195_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "balancete252021 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si195_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si195_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:balancete252021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si195_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from balancete252021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si195_sequencial!=null ) {
         $sql2 .= " where balancete252021.si195_sequencial = $si195_sequencial ";
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
  function sql_query_file ( $si195_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from balancete252021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si195_sequencial!=null ) {
         $sql2 .= " where balancete252021.si195_sequencial = $si195_sequencial ";
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
