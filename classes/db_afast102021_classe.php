<?php
//MODULO: sicom
//CLASSE DA ENTIDADE afast102021
class cl_afast102021 {

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
  public $si199_sequencial = 0; 
  public $si199_tiporegistro = 0; 
  public $si199_codvinculopessoa = 0; 
  public $si199_codafastamento = 0; 
  public $si199_dtinicioafastamento_dia = null; 
  public $si199_dtinicioafastamento_mes = null; 
  public $si199_dtinicioafastamento_ano = null; 
  public $si199_dtinicioafastamento = null; 
  public $si199_dtretornoafastamento_dia = null; 
  public $si199_dtretornoafastamento_mes = null; 
  public $si199_dtretornoafastamento_ano = null; 
  public $si199_dtretornoafastamento = null; 
  public $si199_tipoafastamento = 0; 
  public $si199_dscoutrosafastamentos = null; 
  public $si199_mes = 0; 
  public $si199_inst = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 si199_sequencial = int4 = si199_sequencial 
                 si199_tiporegistro = int4 = si199_tiporegistro 
                 si199_codvinculopessoa = int4 = si199_codvinculopessoa 
                 si199_codafastamento = int4 = si199_codafastamento 
                 si199_dtinicioafastamento = date = si199_dtinicioafastamento 
                 si199_dtretornoafastamento = date = si199_dtretornoafastamento 
                 si199_tipoafastamento = int4 = si199_tipoafastamento 
                 si199_dscoutrosafastamentos = varchar(500) = si199_dscoutrosafastamentos 
                 si199_mes = int4 = si199_mes 
                 si199_inst = int4 = si199_inst 
                 ";

  //funcao construtor da classe 
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("afast102021"); 
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
       $this->si199_sequencial = ($this->si199_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_sequencial"]:$this->si199_sequencial);
       $this->si199_tiporegistro = ($this->si199_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"]:$this->si199_tiporegistro);
       $this->si199_codvinculopessoa = ($this->si199_codvinculopessoa == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_codvinculopessoa"]:$this->si199_codvinculopessoa);
       $this->si199_codafastamento = ($this->si199_codafastamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_codafastamento"]:$this->si199_codafastamento);
       if ($this->si199_dtinicioafastamento == "") {
         $this->si199_dtinicioafastamento_dia = ($this->si199_dtinicioafastamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtinicioafastamento_dia"]:$this->si199_dtinicioafastamento_dia);
         $this->si199_dtinicioafastamento_mes = ($this->si199_dtinicioafastamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtinicioafastamento_mes"]:$this->si199_dtinicioafastamento_mes);
         $this->si199_dtinicioafastamento_ano = ($this->si199_dtinicioafastamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtinicioafastamento_ano"]:$this->si199_dtinicioafastamento_ano);
         if ($this->si199_dtinicioafastamento_dia != "") {
            $this->si199_dtinicioafastamento = $this->si199_dtinicioafastamento_ano."-".$this->si199_dtinicioafastamento_mes."-".$this->si199_dtinicioafastamento_dia;
         }
       }
       if ($this->si199_dtretornoafastamento == "") {
         $this->si199_dtretornoafastamento_dia = ($this->si199_dtretornoafastamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtretornoafastamento_dia"]:$this->si199_dtretornoafastamento_dia);
         $this->si199_dtretornoafastamento_mes = ($this->si199_dtretornoafastamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtretornoafastamento_mes"]:$this->si199_dtretornoafastamento_mes);
         $this->si199_dtretornoafastamento_ano = ($this->si199_dtretornoafastamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtretornoafastamento_ano"]:$this->si199_dtretornoafastamento_ano);
         if ($this->si199_dtretornoafastamento_dia != "") {
            $this->si199_dtretornoafastamento = $this->si199_dtretornoafastamento_ano."-".$this->si199_dtretornoafastamento_mes."-".$this->si199_dtretornoafastamento_dia;
         }
       }
       $this->si199_tipoafastamento = ($this->si199_tipoafastamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_tipoafastamento"]:$this->si199_tipoafastamento);
       $this->si199_dscoutrosafastamentos = ($this->si199_dscoutrosafastamentos == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dscoutrosafastamentos"]:$this->si199_dscoutrosafastamentos);
       $this->si199_mes = ($this->si199_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_mes"]:$this->si199_mes);
       $this->si199_inst = ($this->si199_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_inst"]:$this->si199_inst);
     } else {
       $this->si199_sequencial = ($this->si199_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_sequencial"]:$this->si199_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si199_sequencial) { 
      $this->atualizacampos();
     if ($this->si199_tiporegistro == null ) { 
       $this->erro_sql = " Campo si199_tiporegistro não informado.";
       $this->erro_campo = "si199_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si199_codvinculopessoa == null ) { 
       $this->erro_sql = " Campo si199_codvinculopessoa não informado.";
       $this->erro_campo = "si199_codvinculopessoa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si199_codafastamento == null ) { 
       $this->erro_sql = " Campo si199_codafastamento não informado.";
       $this->erro_campo = "si199_codafastamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si199_dtinicioafastamento == null ) { 
       $this->erro_sql = " Campo si199_dtinicioafastamento não informado.";
       $this->erro_campo = "si199_dtinicioafastamento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si199_dtretornoafastamento == null ) { 
       $this->erro_sql = " Campo si199_dtretornoafastamento não informado.";
       $this->erro_campo = "si199_dtretornoafastamento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si199_tipoafastamento == null ) { 
       $this->erro_sql = " Campo si199_tipoafastamento não informado.";
       $this->erro_campo = "si199_tipoafastamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si199_mes == null ) { 
       $this->erro_sql = " Campo si199_mes não informado.";
       $this->erro_campo = "si199_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si199_inst == null ) { 
       $this->erro_sql = " Campo si199_inst não informado.";
       $this->erro_campo = "si199_inst";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
      if($si199_sequencial == "" || $si199_sequencial == null ){
          $result = db_query("select nextval('afast102021_si199_sequencial_seq')");
          if($result==false){
              $this->erro_banco = str_replace("\n","",@pg_last_error());
              $this->erro_sql   = "Verifique o cadastro da sequencia: afast102021_si199_sequencial_seq do campo: si199_sequencial";
              $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
              $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
              $this->erro_status = "0";
              return false;
          }
          $this->si199_sequencial = pg_result($result,0,0);
      }else{
          $result = db_query("select last_value from afast102021_si199_sequencial_seq");
          if(($result != false) && (pg_result($result,0,0) < $si199_sequencial)){
              $this->erro_sql = " Campo si199_sequencial maior que último número da sequencia.";
              $this->erro_banco = "Sequencia menor que este número.";
              $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
              $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
              $this->erro_status = "0";
              return false;
          }else{
              $this->si199_sequencial = $si199_sequencial;
          }
      }
     if (($this->si199_sequencial == null) || ($this->si199_sequencial == "") ) { 
       $this->erro_sql = " Campo si199_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into afast102021(
                                       si199_sequencial 
                                      ,si199_tiporegistro 
                                      ,si199_codvinculopessoa 
                                      ,si199_codafastamento 
                                      ,si199_dtinicioafastamento 
                                      ,si199_dtretornoafastamento 
                                      ,si199_tipoafastamento 
                                      ,si199_dscoutrosafastamentos 
                                      ,si199_mes 
                                      ,si199_inst 
                       )
                values (
                                $this->si199_sequencial 
                               ,$this->si199_tiporegistro 
                               ,$this->si199_codvinculopessoa 
                               ,$this->si199_codafastamento 
                               ,".($this->si199_dtinicioafastamento == "null" || $this->si199_dtinicioafastamento == ""?"null":"'".$this->si199_dtinicioafastamento."'")." 
                               ,".($this->si199_dtretornoafastamento == "null" || $this->si199_dtretornoafastamento == ""?"null":"'".$this->si199_dtretornoafastamento."'")." 
                               ,$this->si199_tipoafastamento 
                               ,".($this->si199_dscoutrosafastamentos == "null" || $this->si199_dtretornoafastamento == ""?"":"'".$this->si199_dscoutrosafastamentos."'")." 
                               ,$this->si199_mes 
                               ,$this->si199_inst 
                      )";

     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "afast102021 ($this->si199_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "afast102021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "afast102021 ($this->si199_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si199_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si199_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009285,'$this->si199_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010199,1009285,'','".AddSlashes(pg_result($resaco,0,'si199_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009286,'','".AddSlashes(pg_result($resaco,0,'si199_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009287,'','".AddSlashes(pg_result($resaco,0,'si199_codvinculopessoa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009318,'','".AddSlashes(pg_result($resaco,0,'si199_codafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009288,'','".AddSlashes(pg_result($resaco,0,'si199_dtinicioafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009289,'','".AddSlashes(pg_result($resaco,0,'si199_dtretornoafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009290,'','".AddSlashes(pg_result($resaco,0,'si199_tipoafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009291,'','".AddSlashes(pg_result($resaco,0,'si199_dscoutrosafastamentos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009292,'','".AddSlashes(pg_result($resaco,0,'si199_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,1009293,'','".AddSlashes(pg_result($resaco,0,'si199_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($si199_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update afast102021 set ";
     $virgula = "";
     if (trim($this->si199_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_sequencial"])) { 
       $sql  .= $virgula." si199_sequencial = $this->si199_sequencial ";
       $virgula = ",";
       if (trim($this->si199_sequencial) == null ) { 
         $this->erro_sql = " Campo si199_sequencial não informado.";
         $this->erro_campo = "si199_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si199_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"])) { 
       $sql  .= $virgula." si199_tiporegistro = $this->si199_tiporegistro ";
       $virgula = ",";
       if (trim($this->si199_tiporegistro) == null ) { 
         $this->erro_sql = " Campo si199_tiporegistro não informado.";
         $this->erro_campo = "si199_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si199_codvinculopessoa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_codvinculopessoa"])) { 
       $sql  .= $virgula." si199_codvinculopessoa = $this->si199_codvinculopessoa ";
       $virgula = ",";
       if (trim($this->si199_codvinculopessoa) == null ) { 
         $this->erro_sql = " Campo si199_codvinculopessoa não informado.";
         $this->erro_campo = "si199_codvinculopessoa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si199_codafastamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_codafastamento"])) { 
       $sql  .= $virgula." si199_codafastamento = $this->si199_codafastamento ";
       $virgula = ",";
       if (trim($this->si199_codafastamento) == null ) { 
         $this->erro_sql = " Campo si199_codafastamento não informado.";
         $this->erro_campo = "si199_codafastamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si199_dtinicioafastamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_dtinicioafastamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si199_dtinicioafastamento_dia"] !="") ) { 
       $sql  .= $virgula." si199_dtinicioafastamento = '$this->si199_dtinicioafastamento' ";
       $virgula = ",";
       if (trim($this->si199_dtinicioafastamento) == null ) { 
         $this->erro_sql = " Campo si199_dtinicioafastamento não informado.";
         $this->erro_campo = "si199_dtinicioafastamento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["si199_dtinicioafastamento_dia"])) { 
         $sql  .= $virgula." si199_dtinicioafastamento = null ";
         $virgula = ",";
         if (trim($this->si199_dtinicioafastamento) == null ) { 
           $this->erro_sql = " Campo si199_dtinicioafastamento não informado.";
           $this->erro_campo = "si199_dtinicioafastamento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si199_dtretornoafastamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_dtretornoafastamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si199_dtretornoafastamento_dia"] !="") ) { 
       $sql  .= $virgula." si199_dtretornoafastamento = '$this->si199_dtretornoafastamento' ";
       $virgula = ",";
       if (trim($this->si199_dtretornoafastamento) == null ) { 
         $this->erro_sql = " Campo si199_dtretornoafastamento não informado.";
         $this->erro_campo = "si199_dtretornoafastamento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["si199_dtretornoafastamento_dia"])) { 
         $sql  .= $virgula." si199_dtretornoafastamento = null ";
         $virgula = ",";
         if (trim($this->si199_dtretornoafastamento) == null ) { 
           $this->erro_sql = " Campo si199_dtretornoafastamento não informado.";
           $this->erro_campo = "si199_dtretornoafastamento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si199_tipoafastamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_tipoafastamento"])) { 
       $sql  .= $virgula." si199_tipoafastamento = $this->si199_tipoafastamento ";
       $virgula = ",";
       if (trim($this->si199_tipoafastamento) == null ) { 
         $this->erro_sql = " Campo si199_tipoafastamento não informado.";
         $this->erro_campo = "si199_tipoafastamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si199_dscoutrosafastamentos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_dscoutrosafastamentos"])) { 
       $sql  .= $virgula." si199_dscoutrosafastamentos = '$this->si199_dscoutrosafastamentos' ";
       $virgula = ",";
       if (trim($this->si199_dscoutrosafastamentos) == null ) { 
         $this->erro_sql = " Campo si199_dscoutrosafastamentos não informado.";
         $this->erro_campo = "si199_dscoutrosafastamentos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si199_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_mes"])) { 
       $sql  .= $virgula." si199_mes = $this->si199_mes ";
       $virgula = ",";
       if (trim($this->si199_mes) == null ) { 
         $this->erro_sql = " Campo si199_mes não informado.";
         $this->erro_campo = "si199_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si199_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_inst"])) { 
       $sql  .= $virgula." si199_inst = $this->si199_inst ";
       $virgula = ",";
       if (trim($this->si199_inst) == null ) { 
         $this->erro_sql = " Campo si199_inst não informado.";
         $this->erro_campo = "si199_inst";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si199_sequencial!=null) {
       $sql .= " si199_sequencial = $this->si199_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si199_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009285,'$this->si199_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_sequencial"]) || $this->si199_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009285,'".AddSlashes(pg_result($resaco,$conresaco,'si199_sequencial'))."','$this->si199_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"]) || $this->si199_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009286,'".AddSlashes(pg_result($resaco,$conresaco,'si199_tiporegistro'))."','$this->si199_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_codvinculopessoa"]) || $this->si199_codvinculopessoa != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009287,'".AddSlashes(pg_result($resaco,$conresaco,'si199_codvinculopessoa'))."','$this->si199_codvinculopessoa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_codafastamento"]) || $this->si199_codafastamento != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009318,'".AddSlashes(pg_result($resaco,$conresaco,'si199_codafastamento'))."','$this->si199_codafastamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_dtinicioafastamento"]) || $this->si199_dtinicioafastamento != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009288,'".AddSlashes(pg_result($resaco,$conresaco,'si199_dtinicioafastamento'))."','$this->si199_dtinicioafastamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_dtretornoafastamento"]) || $this->si199_dtretornoafastamento != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009289,'".AddSlashes(pg_result($resaco,$conresaco,'si199_dtretornoafastamento'))."','$this->si199_dtretornoafastamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_tipoafastamento"]) || $this->si199_tipoafastamento != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009290,'".AddSlashes(pg_result($resaco,$conresaco,'si199_tipoafastamento'))."','$this->si199_tipoafastamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_dscoutrosafastamentos"]) || $this->si199_dscoutrosafastamentos != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009291,'".AddSlashes(pg_result($resaco,$conresaco,'si199_dscoutrosafastamentos'))."','$this->si199_dscoutrosafastamentos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_mes"]) || $this->si199_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009292,'".AddSlashes(pg_result($resaco,$conresaco,'si199_mes'))."','$this->si199_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si199_inst"]) || $this->si199_inst != "")
             $resac = db_query("insert into db_acount values($acount,1010199,1009293,'".AddSlashes(pg_result($resaco,$conresaco,'si199_inst'))."','$this->si199_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "afast102021 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si199_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "afast102021 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si199_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si199_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($si199_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si199_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         /*for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009285,'$si199_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009285,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009286,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009287,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_codvinculopessoa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009318,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_codafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009288,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_dtinicioafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009289,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_dtretornoafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009290,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_tipoafastamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009291,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_dscoutrosafastamentos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009292,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,1009293,'','".AddSlashes(pg_result($resaco,$iresaco,'si199_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }*/
       }
     }
     $sql = " delete from afast102021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si199_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si199_sequencial = $si199_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "afast102021 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si199_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "afast102021 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si199_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si199_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:afast102021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $si199_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from afast102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si199_sequencial!=null ) {
         $sql2 .= " where afast102021.si199_sequencial = $si199_sequencial "; 
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
  function sql_query_file ( $si199_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from afast102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si199_sequencial!=null ) {
         $sql2 .= " where afast102021.si199_sequencial = $si199_sequencial "; 
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
