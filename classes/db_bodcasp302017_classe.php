<?
//MODULO: sicom
//CLASSE DA ENTIDADE bodcasp302017
class cl_bodcasp302017 { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $numrows_incluir = 0; 
   var $numrows_alterar = 0; 
   var $numrows_excluir = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $si203_sequencial = 0; 
   var $si203_tiporegistro = 0; 
   var $si203_fasedespesaorca = 0; 
   var $si203_vlpessoalencarsoci = 0; 
   var $si203_vljurosencardividas = 0; 
   var $si203_vloutrasdespcorren = 0; 
   var $si203_vlinvestimentos = 0; 
   var $si203_vlinverfinanceira = 0; 
   var $si203_vlamortizadivida = 0; 
   var $si203_vlreservacontingen = 0; 
   var $si203_vlreservarpps = 0; 
   var $si203_vlamortizadiviintermob = 0; 
   var $si203_vlamortizaoutrasdivinter = 0; 
   var $si203_vlamortizadivextmob = 0; 
   var $si203_vlamortizaoutrasdivext = 0; 
   var $si203_vlsuperavit = 0; 
   var $si203_vltotalquadrodespesa = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si203_sequencial = int4 = si203_sequencial 
                 si203_tiporegistro = int4 = si203_tiporegistro 
                 si203_fasedespesaorca = int4 = si203_fasedespesaorca 
                 si203_vlpessoalencarsoci = float4 = si203_vlpessoalencarsoci 
                 si203_vljurosencardividas = float4 = si203_vljurosencardividas 
                 si203_vloutrasdespcorren = float4 = si203_vloutrasdespcorren 
                 si203_vlinvestimentos = float4 = si203_vlinvestimentos 
                 si203_vlinverfinanceira = float4 = si203_vlinverfinanceira 
                 si203_vlamortizadivida = float4 = si203_vlamortizadivida 
                 si203_vlreservacontingen = float4 = si203_vlreservacontingen 
                 si203_vlreservarpps = float4 = si203_vlreservarpps 
                 si203_vlamortizadiviintermob = float4 = si203_vlamortizadiviintermob 
                 si203_vlamortizaoutrasdivinter = float4 = si203_vlamortizaoutrasdivinter 
                 si203_vlamortizadivextmob = float4 = si203_vlamortizadivextmob 
                 si203_vlamortizaoutrasdivext = float4 = si203_vlamortizaoutrasdivext 
                 si203_vlsuperavit = float4 = si203_vlsuperavit 
                 si203_vltotalquadrodespesa = float4 = si203_vltotalquadrodespesa 
                 ";
   //funcao construtor da classe 
   function cl_bodcasp302017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bodcasp302017"); 
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->si203_sequencial = ($this->si203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_sequencial"]:$this->si203_sequencial);
       $this->si203_tiporegistro = ($this->si203_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"]:$this->si203_tiporegistro);
       $this->si203_fasedespesaorca = ($this->si203_fasedespesaorca == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_fasedespesaorca"]:$this->si203_fasedespesaorca);
       $this->si203_vlpessoalencarsoci = ($this->si203_vlpessoalencarsoci == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlpessoalencarsoci"]:$this->si203_vlpessoalencarsoci);
       $this->si203_vljurosencardividas = ($this->si203_vljurosencardividas == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vljurosencardividas"]:$this->si203_vljurosencardividas);
       $this->si203_vloutrasdespcorren = ($this->si203_vloutrasdespcorren == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vloutrasdespcorren"]:$this->si203_vloutrasdespcorren);
       $this->si203_vlinvestimentos = ($this->si203_vlinvestimentos == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlinvestimentos"]:$this->si203_vlinvestimentos);
       $this->si203_vlinverfinanceira = ($this->si203_vlinverfinanceira == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlinverfinanceira"]:$this->si203_vlinverfinanceira);
       $this->si203_vlamortizadivida = ($this->si203_vlamortizadivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadivida"]:$this->si203_vlamortizadivida);
       $this->si203_vlreservacontingen = ($this->si203_vlreservacontingen == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlreservacontingen"]:$this->si203_vlreservacontingen);
       $this->si203_vlreservarpps = ($this->si203_vlreservarpps == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlreservarpps"]:$this->si203_vlreservarpps);
       $this->si203_vlamortizadiviintermob = ($this->si203_vlamortizadiviintermob == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadiviintermob"]:$this->si203_vlamortizadiviintermob);
       $this->si203_vlamortizaoutrasdivinter = ($this->si203_vlamortizaoutrasdivinter == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlamortizaoutrasdivinter"]:$this->si203_vlamortizaoutrasdivinter);
       $this->si203_vlamortizadivextmob = ($this->si203_vlamortizadivextmob == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadivextmob"]:$this->si203_vlamortizadivextmob);
       $this->si203_vlamortizaoutrasdivext = ($this->si203_vlamortizaoutrasdivext == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlamortizaoutrasdivext"]:$this->si203_vlamortizaoutrasdivext);
       $this->si203_vlsuperavit = ($this->si203_vlsuperavit == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vlsuperavit"]:$this->si203_vlsuperavit);
       $this->si203_vltotalquadrodespesa = ($this->si203_vltotalquadrodespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_vltotalquadrodespesa"]:$this->si203_vltotalquadrodespesa);
     }else{
       $this->si203_sequencial = ($this->si203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_sequencial"]:$this->si203_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si203_sequencial){ 
      $this->atualizacampos();
     if($this->si203_tiporegistro == null ){ 
       $this->erro_sql = " Campo si203_tiporegistro não informado.";
       $this->erro_campo = "si203_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_fasedespesaorca == null ){ 
       $this->erro_sql = " Campo si203_fasedespesaorca não informado.";
       $this->erro_campo = "si203_fasedespesaorca";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlpessoalencarsoci == null ){ 
       $this->erro_sql = " Campo si203_vlpessoalencarsoci não informado.";
       $this->erro_campo = "si203_vlpessoalencarsoci";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vljurosencardividas == null ){ 
       $this->erro_sql = " Campo si203_vljurosencardividas não informado.";
       $this->erro_campo = "si203_vljurosencardividas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vloutrasdespcorren == null ){ 
       $this->erro_sql = " Campo si203_vloutrasdespcorren não informado.";
       $this->erro_campo = "si203_vloutrasdespcorren";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlinvestimentos == null ){ 
       $this->erro_sql = " Campo si203_vlinvestimentos não informado.";
       $this->erro_campo = "si203_vlinvestimentos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlinverfinanceira == null ){ 
       $this->erro_sql = " Campo si203_vlinverfinanceira não informado.";
       $this->erro_campo = "si203_vlinverfinanceira";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlamortizadivida == null ){ 
       $this->erro_sql = " Campo si203_vlamortizadivida não informado.";
       $this->erro_campo = "si203_vlamortizadivida";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlreservacontingen == null ){ 
       $this->erro_sql = " Campo si203_vlreservacontingen não informado.";
       $this->erro_campo = "si203_vlreservacontingen";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlreservarpps == null ){ 
       $this->erro_sql = " Campo si203_vlreservarpps não informado.";
       $this->erro_campo = "si203_vlreservarpps";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlamortizadiviintermob == null ){ 
       $this->erro_sql = " Campo si203_vlamortizadiviintermob não informado.";
       $this->erro_campo = "si203_vlamortizadiviintermob";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlamortizaoutrasdivinter == null ){ 
       $this->erro_sql = " Campo si203_vlamortizaoutrasdivinter não informado.";
       $this->erro_campo = "si203_vlamortizaoutrasdivinter";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlamortizadivextmob == null ){ 
       $this->erro_sql = " Campo si203_vlamortizadivextmob não informado.";
       $this->erro_campo = "si203_vlamortizadivextmob";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlamortizaoutrasdivext == null ){ 
       $this->erro_sql = " Campo si203_vlamortizaoutrasdivext não informado.";
       $this->erro_campo = "si203_vlamortizaoutrasdivext";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vlsuperavit == null ){ 
       $this->erro_sql = " Campo si203_vlsuperavit não informado.";
       $this->erro_campo = "si203_vlsuperavit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si203_vltotalquadrodespesa == null ){ 
       $this->erro_sql = " Campo si203_vltotalquadrodespesa não informado.";
       $this->erro_campo = "si203_vltotalquadrodespesa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si203_sequencial = $si203_sequencial; 
     if(($this->si203_sequencial == null) || ($this->si203_sequencial == "") ){ 
       $this->erro_sql = " Campo si203_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into bodcasp302017(
                                       si203_sequencial 
                                      ,si203_tiporegistro 
                                      ,si203_fasedespesaorca 
                                      ,si203_vlpessoalencarsoci 
                                      ,si203_vljurosencardividas 
                                      ,si203_vloutrasdespcorren 
                                      ,si203_vlinvestimentos 
                                      ,si203_vlinverfinanceira 
                                      ,si203_vlamortizadivida 
                                      ,si203_vlreservacontingen 
                                      ,si203_vlreservarpps 
                                      ,si203_vlamortizadiviintermob 
                                      ,si203_vlamortizaoutrasdivinter 
                                      ,si203_vlamortizadivextmob 
                                      ,si203_vlamortizaoutrasdivext 
                                      ,si203_vlsuperavit 
                                      ,si203_vltotalquadrodespesa 
                       )
                values (
                                $this->si203_sequencial 
                               ,$this->si203_tiporegistro 
                               ,$this->si203_fasedespesaorca 
                               ,$this->si203_vlpessoalencarsoci 
                               ,$this->si203_vljurosencardividas 
                               ,$this->si203_vloutrasdespcorren 
                               ,$this->si203_vlinvestimentos 
                               ,$this->si203_vlinverfinanceira 
                               ,$this->si203_vlamortizadivida 
                               ,$this->si203_vlreservacontingen 
                               ,$this->si203_vlreservarpps 
                               ,$this->si203_vlamortizadiviintermob 
                               ,$this->si203_vlamortizaoutrasdivinter 
                               ,$this->si203_vlamortizadivextmob 
                               ,$this->si203_vlamortizaoutrasdivext 
                               ,$this->si203_vlsuperavit 
                               ,$this->si203_vltotalquadrodespesa 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bodcasp302017 ($this->si203_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "bodcasp302017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "bodcasp302017 ($this->si203_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si203_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si203_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009286,'$this->si203_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010197,1009286,'','".AddSlashes(pg_result($resaco,0,'si203_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009287,'','".AddSlashes(pg_result($resaco,0,'si203_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009288,'','".AddSlashes(pg_result($resaco,0,'si203_fasedespesaorca'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009289,'','".AddSlashes(pg_result($resaco,0,'si203_vlpessoalencarsoci'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009290,'','".AddSlashes(pg_result($resaco,0,'si203_vljurosencardividas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009291,'','".AddSlashes(pg_result($resaco,0,'si203_vloutrasdespcorren'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009292,'','".AddSlashes(pg_result($resaco,0,'si203_vlinvestimentos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009293,'','".AddSlashes(pg_result($resaco,0,'si203_vlinverfinanceira'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009294,'','".AddSlashes(pg_result($resaco,0,'si203_vlamortizadivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009295,'','".AddSlashes(pg_result($resaco,0,'si203_vlreservacontingen'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009296,'','".AddSlashes(pg_result($resaco,0,'si203_vlreservarpps'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009297,'','".AddSlashes(pg_result($resaco,0,'si203_vlamortizadiviintermob'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009298,'','".AddSlashes(pg_result($resaco,0,'si203_vlamortizaoutrasdivinter'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009299,'','".AddSlashes(pg_result($resaco,0,'si203_vlamortizadivextmob'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009300,'','".AddSlashes(pg_result($resaco,0,'si203_vlamortizaoutrasdivext'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009301,'','".AddSlashes(pg_result($resaco,0,'si203_vlsuperavit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009302,'','".AddSlashes(pg_result($resaco,0,'si203_vltotalquadrodespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si203_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bodcasp302017 set ";
     $virgula = "";
     if(trim($this->si203_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_sequencial"])){ 
       $sql  .= $virgula." si203_sequencial = $this->si203_sequencial ";
       $virgula = ",";
       if(trim($this->si203_sequencial) == null ){ 
         $this->erro_sql = " Campo si203_sequencial não informado.";
         $this->erro_campo = "si203_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"])){ 
       $sql  .= $virgula." si203_tiporegistro = $this->si203_tiporegistro ";
       $virgula = ",";
       if(trim($this->si203_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si203_tiporegistro não informado.";
         $this->erro_campo = "si203_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_fasedespesaorca)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_fasedespesaorca"])){ 
       $sql  .= $virgula." si203_fasedespesaorca = $this->si203_fasedespesaorca ";
       $virgula = ",";
       if(trim($this->si203_fasedespesaorca) == null ){ 
         $this->erro_sql = " Campo si203_fasedespesaorca não informado.";
         $this->erro_campo = "si203_fasedespesaorca";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlpessoalencarsoci)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlpessoalencarsoci"])){ 
       $sql  .= $virgula." si203_vlpessoalencarsoci = $this->si203_vlpessoalencarsoci ";
       $virgula = ",";
       if(trim($this->si203_vlpessoalencarsoci) == null ){ 
         $this->erro_sql = " Campo si203_vlpessoalencarsoci não informado.";
         $this->erro_campo = "si203_vlpessoalencarsoci";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vljurosencardividas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vljurosencardividas"])){ 
       $sql  .= $virgula." si203_vljurosencardividas = $this->si203_vljurosencardividas ";
       $virgula = ",";
       if(trim($this->si203_vljurosencardividas) == null ){ 
         $this->erro_sql = " Campo si203_vljurosencardividas não informado.";
         $this->erro_campo = "si203_vljurosencardividas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vloutrasdespcorren)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vloutrasdespcorren"])){ 
       $sql  .= $virgula." si203_vloutrasdespcorren = $this->si203_vloutrasdespcorren ";
       $virgula = ",";
       if(trim($this->si203_vloutrasdespcorren) == null ){ 
         $this->erro_sql = " Campo si203_vloutrasdespcorren não informado.";
         $this->erro_campo = "si203_vloutrasdespcorren";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlinvestimentos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlinvestimentos"])){ 
       $sql  .= $virgula." si203_vlinvestimentos = $this->si203_vlinvestimentos ";
       $virgula = ",";
       if(trim($this->si203_vlinvestimentos) == null ){ 
         $this->erro_sql = " Campo si203_vlinvestimentos não informado.";
         $this->erro_campo = "si203_vlinvestimentos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlinverfinanceira)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlinverfinanceira"])){ 
       $sql  .= $virgula." si203_vlinverfinanceira = $this->si203_vlinverfinanceira ";
       $virgula = ",";
       if(trim($this->si203_vlinverfinanceira) == null ){ 
         $this->erro_sql = " Campo si203_vlinverfinanceira não informado.";
         $this->erro_campo = "si203_vlinverfinanceira";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlamortizadivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadivida"])){ 
       $sql  .= $virgula." si203_vlamortizadivida = $this->si203_vlamortizadivida ";
       $virgula = ",";
       if(trim($this->si203_vlamortizadivida) == null ){ 
         $this->erro_sql = " Campo si203_vlamortizadivida não informado.";
         $this->erro_campo = "si203_vlamortizadivida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlreservacontingen)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlreservacontingen"])){ 
       $sql  .= $virgula." si203_vlreservacontingen = $this->si203_vlreservacontingen ";
       $virgula = ",";
       if(trim($this->si203_vlreservacontingen) == null ){ 
         $this->erro_sql = " Campo si203_vlreservacontingen não informado.";
         $this->erro_campo = "si203_vlreservacontingen";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlreservarpps)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlreservarpps"])){ 
       $sql  .= $virgula." si203_vlreservarpps = $this->si203_vlreservarpps ";
       $virgula = ",";
       if(trim($this->si203_vlreservarpps) == null ){ 
         $this->erro_sql = " Campo si203_vlreservarpps não informado.";
         $this->erro_campo = "si203_vlreservarpps";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlamortizadiviintermob)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadiviintermob"])){ 
       $sql  .= $virgula." si203_vlamortizadiviintermob = $this->si203_vlamortizadiviintermob ";
       $virgula = ",";
       if(trim($this->si203_vlamortizadiviintermob) == null ){ 
         $this->erro_sql = " Campo si203_vlamortizadiviintermob não informado.";
         $this->erro_campo = "si203_vlamortizadiviintermob";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlamortizaoutrasdivinter)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizaoutrasdivinter"])){ 
       $sql  .= $virgula." si203_vlamortizaoutrasdivinter = $this->si203_vlamortizaoutrasdivinter ";
       $virgula = ",";
       if(trim($this->si203_vlamortizaoutrasdivinter) == null ){ 
         $this->erro_sql = " Campo si203_vlamortizaoutrasdivinter não informado.";
         $this->erro_campo = "si203_vlamortizaoutrasdivinter";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlamortizadivextmob)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadivextmob"])){ 
       $sql  .= $virgula." si203_vlamortizadivextmob = $this->si203_vlamortizadivextmob ";
       $virgula = ",";
       if(trim($this->si203_vlamortizadivextmob) == null ){ 
         $this->erro_sql = " Campo si203_vlamortizadivextmob não informado.";
         $this->erro_campo = "si203_vlamortizadivextmob";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlamortizaoutrasdivext)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizaoutrasdivext"])){ 
       $sql  .= $virgula." si203_vlamortizaoutrasdivext = $this->si203_vlamortizaoutrasdivext ";
       $virgula = ",";
       if(trim($this->si203_vlamortizaoutrasdivext) == null ){ 
         $this->erro_sql = " Campo si203_vlamortizaoutrasdivext não informado.";
         $this->erro_campo = "si203_vlamortizaoutrasdivext";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vlsuperavit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlsuperavit"])){ 
       $sql  .= $virgula." si203_vlsuperavit = $this->si203_vlsuperavit ";
       $virgula = ",";
       if(trim($this->si203_vlsuperavit) == null ){ 
         $this->erro_sql = " Campo si203_vlsuperavit não informado.";
         $this->erro_campo = "si203_vlsuperavit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si203_vltotalquadrodespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vltotalquadrodespesa"])){ 
       $sql  .= $virgula." si203_vltotalquadrodespesa = $this->si203_vltotalquadrodespesa ";
       $virgula = ",";
       if(trim($this->si203_vltotalquadrodespesa) == null ){ 
         $this->erro_sql = " Campo si203_vltotalquadrodespesa não informado.";
         $this->erro_campo = "si203_vltotalquadrodespesa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si203_sequencial!=null){
       $sql .= " si203_sequencial = $this->si203_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si203_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009286,'$this->si203_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_sequencial"]) || $this->si203_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009286,'".AddSlashes(pg_result($resaco,$conresaco,'si203_sequencial'))."','$this->si203_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"]) || $this->si203_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009287,'".AddSlashes(pg_result($resaco,$conresaco,'si203_tiporegistro'))."','$this->si203_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_fasedespesaorca"]) || $this->si203_fasedespesaorca != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009288,'".AddSlashes(pg_result($resaco,$conresaco,'si203_fasedespesaorca'))."','$this->si203_fasedespesaorca',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlpessoalencarsoci"]) || $this->si203_vlpessoalencarsoci != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009289,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlpessoalencarsoci'))."','$this->si203_vlpessoalencarsoci',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vljurosencardividas"]) || $this->si203_vljurosencardividas != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009290,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vljurosencardividas'))."','$this->si203_vljurosencardividas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vloutrasdespcorren"]) || $this->si203_vloutrasdespcorren != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009291,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vloutrasdespcorren'))."','$this->si203_vloutrasdespcorren',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlinvestimentos"]) || $this->si203_vlinvestimentos != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009292,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlinvestimentos'))."','$this->si203_vlinvestimentos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlinverfinanceira"]) || $this->si203_vlinverfinanceira != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009293,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlinverfinanceira'))."','$this->si203_vlinverfinanceira',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadivida"]) || $this->si203_vlamortizadivida != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009294,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlamortizadivida'))."','$this->si203_vlamortizadivida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlreservacontingen"]) || $this->si203_vlreservacontingen != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009295,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlreservacontingen'))."','$this->si203_vlreservacontingen',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlreservarpps"]) || $this->si203_vlreservarpps != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009296,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlreservarpps'))."','$this->si203_vlreservarpps',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadiviintermob"]) || $this->si203_vlamortizadiviintermob != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009297,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlamortizadiviintermob'))."','$this->si203_vlamortizadiviintermob',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizaoutrasdivinter"]) || $this->si203_vlamortizaoutrasdivinter != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009298,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlamortizaoutrasdivinter'))."','$this->si203_vlamortizaoutrasdivinter',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizadivextmob"]) || $this->si203_vlamortizadivextmob != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009299,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlamortizadivextmob'))."','$this->si203_vlamortizadivextmob',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlamortizaoutrasdivext"]) || $this->si203_vlamortizaoutrasdivext != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009300,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlamortizaoutrasdivext'))."','$this->si203_vlamortizaoutrasdivext',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vlsuperavit"]) || $this->si203_vlsuperavit != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009301,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vlsuperavit'))."','$this->si203_vlsuperavit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si203_vltotalquadrodespesa"]) || $this->si203_vltotalquadrodespesa != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009302,'".AddSlashes(pg_result($resaco,$conresaco,'si203_vltotalquadrodespesa'))."','$this->si203_vltotalquadrodespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bodcasp302017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si203_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp302017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si203_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si203_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si203_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si203_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009286,'$si203_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009286,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009287,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009288,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_fasedespesaorca'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009289,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlpessoalencarsoci'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009290,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vljurosencardividas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009291,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vloutrasdespcorren'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009292,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlinvestimentos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009293,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlinverfinanceira'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009294,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlamortizadivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009295,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlreservacontingen'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009296,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlreservarpps'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009297,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlamortizadiviintermob'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009298,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlamortizaoutrasdivinter'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009299,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlamortizadivextmob'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009300,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlamortizaoutrasdivext'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009301,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vlsuperavit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009302,'','".AddSlashes(pg_result($resaco,$iresaco,'si203_vltotalquadrodespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from bodcasp302017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si203_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si203_sequencial = $si203_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bodcasp302017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si203_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp302017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si203_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si203_sequencial;
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
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:bodcasp302017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si203_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from bodcasp302017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si203_sequencial!=null ){
         $sql2 .= " where bodcasp302017.si203_sequencial = $si203_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $si203_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from bodcasp302017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si203_sequencial!=null ){
         $sql2 .= " where bodcasp302017.si203_sequencial = $si203_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
}
?>
