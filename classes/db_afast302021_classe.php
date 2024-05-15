<?php
//MODULO: sicom
//CLASSE DA ENTIDADE afast302021
class cl_afast302021 { 
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
  public $si201_sequencial = 0; 
  public $si201_tiporegistro = 0; 
  public $si201_codvinculopessoa = 0;
  public $si201_codafastamento = 0;
  public $si201_dtretornoafastamento_dia = null;
  public $si201_dtretornoafastamento_mes = null;
  public $si201_dtretornoafastamento_ano = null;
  public $si201_dtretornoafastamento = null;
  public $si201_mes = 0; 
  public $si201_inst = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 si201_sequencial = int4 = si201_sequencial 
                 si201_tiporegistro = int4 = Tipo do Registro 
                 si201_codvinculopessoa = int4 = Código do Vínculo do Agente Público
                 si201_codafastamento = int4 = Código do Afastamento para o vínculo 
                 si201_dtretornoafastamento = date = Data Prevista de retorno do Afastamento 
                 si201_mes = int4 = si201_mes 
                 si201_inst = int4 = si201_inst 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("afast302021"); 
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
       $this->si201_sequencial = ($this->si201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_sequencial"]:$this->si201_sequencial);
       $this->si201_tiporegistro = ($this->si201_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"]:$this->si201_tiporegistro);
       $this->si201_codvinculopessoa = ($this->si201_codvinculopessoa == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_codvinculopessoa"]:$this->si201_codvinculopessoa);
       $this->si201_codafastamento = ($this->si201_codafastamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_codafastamento"]:$this->si201_codafastamento);
       if ($this->si201_dtretornoafastamento == "") {
         $this->si201_dtretornoafastamento_dia = ($this->si201_dtretornoafastamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtretornoafastamento_dia"]:$this->si201_dtretornoafastamento_dia);
         $this->si201_dtretornoafastamento_mes = ($this->si201_dtretornoafastamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtretornoafastamento_mes"]:$this->si201_dtretornoafastamento_mes);
         $this->si201_dtretornoafastamento_ano = ($this->si201_dtretornoafastamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtretornoafastamento_ano"]:$this->si201_dtretornoafastamento_ano);
         if ($this->si201_dtretornoafastamento_dia != "") {
            $this->si201_dtretornoafastamento = $this->si201_dtretornoafastamento_ano."-".$this->si201_dtretornoafastamento_mes."-".$this->si201_dtretornoafastamento_dia;
         }
       }
       $this->si201_mes = ($this->si201_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_mes"]:$this->si201_mes);
       $this->si201_inst = ($this->si201_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_inst"]:$this->si201_inst);
     } else {
       $this->si201_sequencial = ($this->si201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_sequencial"]:$this->si201_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si201_sequencial) { 
      $this->atualizacampos();
     if ($this->si201_tiporegistro == null ) { 
       $this->erro_sql = " Campo si201_tiporegistro não informado.";
       $this->erro_campo = "si201_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si201_codvinculopessoa == null ) { 
       $this->erro_sql = " Campo si201_codvinculopessoa não informado.";
       $this->erro_campo = "si201_codvinculopessoa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si201_codafastamento == null ) {
         $this->erro_sql = " Campo si201_codafastamento não informado.";
         $this->erro_campo = "si201_codafastamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
     }
     if ($this->si201_dtretornoafastamento == null ) { 
       $this->erro_sql = " Campo si201_dtretornoafastamento não informado.";
       $this->erro_campo = "si201_dtretornoafastamento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si201_mes == null ) { 
       $this->erro_sql = " Campo si201_mes não informado.";
       $this->erro_campo = "si201_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si201_inst == null ) { 
       $this->erro_sql = " Campo si201_inst não informado.";
       $this->erro_campo = "si201_inst";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
      if($si201_sequencial == "" || $si201_sequencial == null ){
          $result = db_query("select nextval('afast302021_si201_sequencial_seq')");
          if($result==false){
              $this->erro_banco = str_replace("\n","",@pg_last_error());
              $this->erro_sql   = "Verifique o cadastro da sequencia: afast302021_si201_sequencial_seq do campo: si201_sequencial";
              $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
              $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
              $this->erro_status = "0";
              return false;
          }
          $this->si201_sequencial = pg_result($result,0,0);
      }else{
          $result = db_query("select last_value from afast302021_si201_sequencial_seq");
          if(($result != false) && (pg_result($result,0,0) < $si201_sequencial)){
              $this->erro_sql = " Campo si201_sequencial maior que último número da sequencia.";
              $this->erro_banco = "Sequencia menor que este número.";
              $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
              $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
              $this->erro_status = "0";
              return false;
          }else{
              $this->si201_sequencial = $si201_sequencial;
          }
      }
      if (($this->si201_sequencial == null) || ($this->si201_sequencial == "") ) {
          $this->erro_sql = " Campo si201_sequencial nao declarado.";
          $this->erro_banco = "Chave Primaria zerada.";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
      }
     $sql = "insert into afast302021(
                                       si201_sequencial 
                                      ,si201_tiporegistro 
                                      ,si201_codvinculopessoa 
                                      ,si201_codafastamento
                                      ,si201_dtretornoafastamento 
                                      ,si201_mes 
                                      ,si201_inst 
                       )
                values (
                                $this->si201_sequencial 
                               ,$this->si201_tiporegistro 
                               ,$this->si201_codvinculopessoa
                               ,$this->si201_codafastamento 
                               ,".($this->si201_dtretornoafastamento == "null" || $this->si201_dtretornoafastamento == ""?"null":"'".$this->si201_dtretornoafastamento."'")." 
                               ,$this->si201_mes 
                               ,$this->si201_inst 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "afast302021 ($this->si201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "afast302021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "afast302021 ($this->si201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       /*$resaco = $this->sql_record($this->sql_query_file($this->si201_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009294,'$this->si201_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010200,1009294,'','".AddSlashes(pg_result($resaco,0,'si201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009295,'','".AddSlashes(pg_result($resaco,0,'si201_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009296,'','".AddSlashes(pg_result($resaco,0,'si201_codvinculopessoa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009297,'','".AddSlashes(pg_result($resaco,0,'si201_dtretornoafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009298,'','".AddSlashes(pg_result($resaco,0,'si201_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009299,'','".AddSlashes(pg_result($resaco,0,'si201_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }*/
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($si201_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update afast302021 set ";
     $virgula = "";
     if (trim($this->si201_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_sequencial"])) { 
       $sql  .= $virgula." si201_sequencial = $this->si201_sequencial ";
       $virgula = ",";
       if (trim($this->si201_sequencial) == null ) { 
         $this->erro_sql = " Campo si201_sequencial não informado.";
         $this->erro_campo = "si201_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si201_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"])) { 
       $sql  .= $virgula." si201_tiporegistro = $this->si201_tiporegistro ";
       $virgula = ",";
       if (trim($this->si201_tiporegistro) == null ) { 
         $this->erro_sql = " Campo si201_tiporegistro não informado.";
         $this->erro_campo = "si201_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si201_codvinculopessoa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_codvinculopessoa"])) { 
       $sql  .= $virgula." si201_codvinculopessoa = $this->si201_codvinculopessoa ";
       $virgula = ",";
       if (trim($this->si201_codvinculopessoa) == null ) { 
         $this->erro_sql = " Campo si201_codvinculopessoa não informado.";
         $this->erro_campo = "si201_codvinculopessoa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si201_codafastamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_codafastamento"])) {
         $sql  .= $virgula." si201_codafastamento = $this->si201_codafastamento ";
         $virgula = ",";
         if (trim($this->si201_codvinculopessoa) == null ) {
             $this->erro_sql = " Campo si201_codafastamento não informado.";
             $this->erro_campo = "si201_codafastamento";
             $this->erro_banco = "";
             $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
             $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
             $this->erro_status = "0";
             return false;
         }
     }
     if (trim($this->si201_dtretornoafastamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_dtretornoafastamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si201_dtretornoafastamento_dia"] !="") ) { 
       $sql  .= $virgula." si201_dtretornoafastamento = '$this->si201_dtretornoafastamento' ";
       $virgula = ",";
       if (trim($this->si201_dtretornoafastamento) == null ) { 
         $this->erro_sql = " Campo si201_dtretornoafastamento não informado.";
         $this->erro_campo = "si201_dtretornoafastamento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["si201_dtretornoafastamento_dia"])) { 
         $sql  .= $virgula." si201_dtretornoafastamento = null ";
         $virgula = ",";
         if (trim($this->si201_dtretornoafastamento) == null ) { 
           $this->erro_sql = " Campo si201_dtretornoafastamento não informado.";
           $this->erro_campo = "si201_dtretornoafastamento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si201_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_mes"])) { 
       $sql  .= $virgula." si201_mes = $this->si201_mes ";
       $virgula = ",";
       if (trim($this->si201_mes) == null ) { 
         $this->erro_sql = " Campo si201_mes não informado.";
         $this->erro_campo = "si201_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si201_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_inst"])) { 
       $sql  .= $virgula." si201_inst = $this->si201_inst ";
       $virgula = ",";
       if (trim($this->si201_inst) == null ) { 
         $this->erro_sql = " Campo si201_inst não informado.";
         $this->erro_campo = "si201_inst";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si201_sequencial!=null) {
       $sql .= " si201_sequencial = $this->si201_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si201_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009294,'$this->si201_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si201_sequencial"]) || $this->si201_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009294,'".AddSlashes(pg_result($resaco,$conresaco,'si201_sequencial'))."','$this->si201_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"]) || $this->si201_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009295,'".AddSlashes(pg_result($resaco,$conresaco,'si201_tiporegistro'))."','$this->si201_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si201_codvinculopessoa"]) || $this->si201_codvinculopessoa != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009296,'".AddSlashes(pg_result($resaco,$conresaco,'si201_codvinculopessoa'))."','$this->si201_codvinculopessoa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si201_dtretornoafastamento"]) || $this->si201_dtretornoafastamento != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009297,'".AddSlashes(pg_result($resaco,$conresaco,'si201_dtretornoafastamento'))."','$this->si201_dtretornoafastamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si201_mes"]) || $this->si201_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009298,'".AddSlashes(pg_result($resaco,$conresaco,'si201_mes'))."','$this->si201_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si201_inst"]) || $this->si201_inst != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009299,'".AddSlashes(pg_result($resaco,$conresaco,'si201_inst'))."','$this->si201_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "afast302021 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "afast302021 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($si201_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si201_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009294,'$si201_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009294,'','".AddSlashes(pg_result($resaco,$iresaco,'si201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009295,'','".AddSlashes(pg_result($resaco,$iresaco,'si201_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009296,'','".AddSlashes(pg_result($resaco,$iresaco,'si201_codvinculopessoa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009297,'','".AddSlashes(pg_result($resaco,$iresaco,'si201_dtretornoafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009298,'','".AddSlashes(pg_result($resaco,$iresaco,'si201_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009299,'','".AddSlashes(pg_result($resaco,$iresaco,'si201_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
         }
       }
     }
     $sql = " delete from afast302021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si201_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si201_sequencial = $si201_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "afast302021 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "afast302021 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si201_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:afast302021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $si201_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from afast302021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si201_sequencial!=null ) {
         $sql2 .= " where afast302021.si201_sequencial = $si201_sequencial "; 
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
  function sql_query_file ( $si201_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from afast302021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si201_sequencial!=null ) {
         $sql2 .= " where afast302021.si201_sequencial = $si201_sequencial "; 
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
