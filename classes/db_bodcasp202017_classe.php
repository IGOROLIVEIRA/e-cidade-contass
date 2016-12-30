<?
//MODULO: sicom
//CLASSE DA ENTIDADE bodcasp202017
class cl_bodcasp202017 { 
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
   var $si202_sequencial = 0; 
   var $si202_tiporegistro = 0; 
   var $si202_faserecorcamentaria = 0; 
   var $si202_vlsaldoexeantsupfin = 0; 
   var $si202_vlsaldoexeantrecredad = 0; 
   var $si202_vltotalsaldoexeant = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si202_sequencial = int4 = si202_sequencial 
                 si202_tiporegistro = int4 = si202_tiporegistro 
                 si202_faserecorcamentaria = int4 = si202_faserecorcamentaria 
                 si202_vlsaldoexeantsupfin = float4 = si202_vlsaldoexeantsupfin 
                 si202_vlsaldoexeantrecredad = float4 = si202_vlsaldoexeantrecredad 
                 si202_vltotalsaldoexeant = float4 = si202_vltotalsaldoexeant 
                 ";
   //funcao construtor da classe 
   function cl_bodcasp202017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bodcasp202017"); 
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
       $this->si202_sequencial = ($this->si202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_sequencial"]:$this->si202_sequencial);
       $this->si202_tiporegistro = ($this->si202_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"]:$this->si202_tiporegistro);
       $this->si202_faserecorcamentaria = ($this->si202_faserecorcamentaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_faserecorcamentaria"]:$this->si202_faserecorcamentaria);
       $this->si202_vlsaldoexeantsupfin = ($this->si202_vlsaldoexeantsupfin == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantsupfin"]:$this->si202_vlsaldoexeantsupfin);
       $this->si202_vlsaldoexeantrecredad = ($this->si202_vlsaldoexeantrecredad == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantrecredad"]:$this->si202_vlsaldoexeantrecredad);
       $this->si202_vltotalsaldoexeant = ($this->si202_vltotalsaldoexeant == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_vltotalsaldoexeant"]:$this->si202_vltotalsaldoexeant);
     }else{
       $this->si202_sequencial = ($this->si202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_sequencial"]:$this->si202_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si202_sequencial){ 
      $this->atualizacampos();
     if($this->si202_tiporegistro == null ){ 
       $this->erro_sql = " Campo si202_tiporegistro não informado.";
       $this->erro_campo = "si202_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si202_faserecorcamentaria == null ){ 
       $this->erro_sql = " Campo si202_faserecorcamentaria não informado.";
       $this->erro_campo = "si202_faserecorcamentaria";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si202_vlsaldoexeantsupfin == null ){ 
       $this->erro_sql = " Campo si202_vlsaldoexeantsupfin não informado.";
       $this->erro_campo = "si202_vlsaldoexeantsupfin";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si202_vlsaldoexeantrecredad == null ){ 
       $this->erro_sql = " Campo si202_vlsaldoexeantrecredad não informado.";
       $this->erro_campo = "si202_vlsaldoexeantrecredad";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si202_vltotalsaldoexeant == null ){ 
       $this->erro_sql = " Campo si202_vltotalsaldoexeant não informado.";
       $this->erro_campo = "si202_vltotalsaldoexeant";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si202_sequencial = $si202_sequencial; 
     if(($this->si202_sequencial == null) || ($this->si202_sequencial == "") ){ 
       $this->erro_sql = " Campo si202_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into bodcasp202017(
                                       si202_sequencial 
                                      ,si202_tiporegistro 
                                      ,si202_faserecorcamentaria 
                                      ,si202_vlsaldoexeantsupfin 
                                      ,si202_vlsaldoexeantrecredad 
                                      ,si202_vltotalsaldoexeant 
                       )
                values (
                                $this->si202_sequencial 
                               ,$this->si202_tiporegistro 
                               ,$this->si202_faserecorcamentaria 
                               ,$this->si202_vlsaldoexeantsupfin 
                               ,$this->si202_vlsaldoexeantrecredad 
                               ,$this->si202_vltotalsaldoexeant 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bodcasp202017 ($this->si202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "bodcasp202017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "bodcasp202017 ($this->si202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si202_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009280,'$this->si202_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010196,1009280,'','".AddSlashes(pg_result($resaco,0,'si202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,1009281,'','".AddSlashes(pg_result($resaco,0,'si202_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,1009282,'','".AddSlashes(pg_result($resaco,0,'si202_faserecorcamentaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,1009283,'','".AddSlashes(pg_result($resaco,0,'si202_vlsaldoexeantsupfin'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,1009284,'','".AddSlashes(pg_result($resaco,0,'si202_vlsaldoexeantrecredad'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,1009285,'','".AddSlashes(pg_result($resaco,0,'si202_vltotalsaldoexeant'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si202_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bodcasp202017 set ";
     $virgula = "";
     if(trim($this->si202_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_sequencial"])){ 
       $sql  .= $virgula." si202_sequencial = $this->si202_sequencial ";
       $virgula = ",";
       if(trim($this->si202_sequencial) == null ){ 
         $this->erro_sql = " Campo si202_sequencial não informado.";
         $this->erro_campo = "si202_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"])){ 
       $sql  .= $virgula." si202_tiporegistro = $this->si202_tiporegistro ";
       $virgula = ",";
       if(trim($this->si202_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si202_tiporegistro não informado.";
         $this->erro_campo = "si202_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_faserecorcamentaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_faserecorcamentaria"])){ 
       $sql  .= $virgula." si202_faserecorcamentaria = $this->si202_faserecorcamentaria ";
       $virgula = ",";
       if(trim($this->si202_faserecorcamentaria) == null ){ 
         $this->erro_sql = " Campo si202_faserecorcamentaria não informado.";
         $this->erro_campo = "si202_faserecorcamentaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_vlsaldoexeantsupfin)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantsupfin"])){ 
       $sql  .= $virgula." si202_vlsaldoexeantsupfin = $this->si202_vlsaldoexeantsupfin ";
       $virgula = ",";
       if(trim($this->si202_vlsaldoexeantsupfin) == null ){ 
         $this->erro_sql = " Campo si202_vlsaldoexeantsupfin não informado.";
         $this->erro_campo = "si202_vlsaldoexeantsupfin";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_vlsaldoexeantrecredad)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantrecredad"])){ 
       $sql  .= $virgula." si202_vlsaldoexeantrecredad = $this->si202_vlsaldoexeantrecredad ";
       $virgula = ",";
       if(trim($this->si202_vlsaldoexeantrecredad) == null ){ 
         $this->erro_sql = " Campo si202_vlsaldoexeantrecredad não informado.";
         $this->erro_campo = "si202_vlsaldoexeantrecredad";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_vltotalsaldoexeant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_vltotalsaldoexeant"])){ 
       $sql  .= $virgula." si202_vltotalsaldoexeant = $this->si202_vltotalsaldoexeant ";
       $virgula = ",";
       if(trim($this->si202_vltotalsaldoexeant) == null ){ 
         $this->erro_sql = " Campo si202_vltotalsaldoexeant não informado.";
         $this->erro_campo = "si202_vltotalsaldoexeant";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si202_sequencial!=null){
       $sql .= " si202_sequencial = $this->si202_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si202_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009280,'$this->si202_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si202_sequencial"]) || $this->si202_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010196,1009280,'".AddSlashes(pg_result($resaco,$conresaco,'si202_sequencial'))."','$this->si202_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"]) || $this->si202_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010196,1009281,'".AddSlashes(pg_result($resaco,$conresaco,'si202_tiporegistro'))."','$this->si202_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si202_faserecorcamentaria"]) || $this->si202_faserecorcamentaria != "")
             $resac = db_query("insert into db_acount values($acount,1010196,1009282,'".AddSlashes(pg_result($resaco,$conresaco,'si202_faserecorcamentaria'))."','$this->si202_faserecorcamentaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantsupfin"]) || $this->si202_vlsaldoexeantsupfin != "")
             $resac = db_query("insert into db_acount values($acount,1010196,1009283,'".AddSlashes(pg_result($resaco,$conresaco,'si202_vlsaldoexeantsupfin'))."','$this->si202_vlsaldoexeantsupfin',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantrecredad"]) || $this->si202_vlsaldoexeantrecredad != "")
             $resac = db_query("insert into db_acount values($acount,1010196,1009284,'".AddSlashes(pg_result($resaco,$conresaco,'si202_vlsaldoexeantrecredad'))."','$this->si202_vlsaldoexeantrecredad',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si202_vltotalsaldoexeant"]) || $this->si202_vltotalsaldoexeant != "")
             $resac = db_query("insert into db_acount values($acount,1010196,1009285,'".AddSlashes(pg_result($resaco,$conresaco,'si202_vltotalsaldoexeant'))."','$this->si202_vltotalsaldoexeant',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bodcasp202017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp202017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si202_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si202_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009280,'$si202_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010196,1009280,'','".AddSlashes(pg_result($resaco,$iresaco,'si202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,1009281,'','".AddSlashes(pg_result($resaco,$iresaco,'si202_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,1009282,'','".AddSlashes(pg_result($resaco,$iresaco,'si202_faserecorcamentaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,1009283,'','".AddSlashes(pg_result($resaco,$iresaco,'si202_vlsaldoexeantsupfin'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,1009284,'','".AddSlashes(pg_result($resaco,$iresaco,'si202_vlsaldoexeantrecredad'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,1009285,'','".AddSlashes(pg_result($resaco,$iresaco,'si202_vltotalsaldoexeant'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from bodcasp202017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si202_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si202_sequencial = $si202_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bodcasp202017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp202017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si202_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bodcasp202017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bodcasp202017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si202_sequencial!=null ){
         $sql2 .= " where bodcasp202017.si202_sequencial = $si202_sequencial "; 
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
   function sql_query_file ( $si202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bodcasp202017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si202_sequencial!=null ){
         $sql2 .= " where bodcasp202017.si202_sequencial = $si202_sequencial "; 
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
