<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp802017
class cl_dfcdcasp802017 { 
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
   var $si226_sequencial = 0; 
   var $si226_tiporegistro = 0; 
   var $si226_exercicio = 0; 
   var $si226_vlamortizacaorefinanciamento = 0; 
   var $si226_vloutrosdesembolsosfinanciamento = 0; 
   var $si226_vltotaldesembolsoatividafinanciame = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si226_sequencial = int4 = si226_sequencial 
                 si226_tiporegistro = int4 = si226_tiporegistro 
                 si226_exercicio = int4 = si226_exercicio 
                 si226_vlamortizacaorefinanciamento = float4 = si226_vlamortizacaorefinanciamento 
                 si226_vloutrosdesembolsosfinanciamento = float4 = si226_vloutrosdesembolsosfinanciamento 
                 si226_vltotaldesembolsoatividafinanciame = float4 = si226_vltotaldesembolsoatividafinanciame 
                 ";
   //funcao construtor da classe 
   function cl_dfcdcasp802017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp802017"); 
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
       $this->si226_sequencial = ($this->si226_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_sequencial"]:$this->si226_sequencial);
       $this->si226_tiporegistro = ($this->si226_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_tiporegistro"]:$this->si226_tiporegistro);
       $this->si226_exercicio = ($this->si226_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_exercicio"]:$this->si226_exercicio);
       $this->si226_vlamortizacaorefinanciamento = ($this->si226_vlamortizacaorefinanciamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_vlamortizacaorefinanciamento"]:$this->si226_vlamortizacaorefinanciamento);
       $this->si226_vloutrosdesembolsosfinanciamento = ($this->si226_vloutrosdesembolsosfinanciamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_vloutrosdesembolsosfinanciamento"]:$this->si226_vloutrosdesembolsosfinanciamento);
       $this->si226_vltotaldesembolsoatividafinanciame = ($this->si226_vltotaldesembolsoatividafinanciame == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_vltotaldesembolsoatividafinanciame"]:$this->si226_vltotaldesembolsoatividafinanciame);
     }else{
       $this->si226_sequencial = ($this->si226_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_sequencial"]:$this->si226_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si226_sequencial){ 
      $this->atualizacampos();
     if($this->si226_tiporegistro == null ){ 
       $this->erro_sql = " Campo si226_tiporegistro não informado.";
       $this->erro_campo = "si226_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si226_exercicio == null ){ 
       $this->erro_sql = " Campo si226_exercicio não informado.";
       $this->erro_campo = "si226_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si226_vlamortizacaorefinanciamento == null ){ 
       $this->erro_sql = " Campo si226_vlamortizacaorefinanciamento não informado.";
       $this->erro_campo = "si226_vlamortizacaorefinanciamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si226_vloutrosdesembolsosfinanciamento == null ){ 
       $this->erro_sql = " Campo si226_vloutrosdesembolsosfinanciamento não informado.";
       $this->erro_campo = "si226_vloutrosdesembolsosfinanciamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si226_vltotaldesembolsoatividafinanciame == null ){ 
       $this->erro_sql = " Campo si226_vltotaldesembolsoatividafinanciame não informado.";
       $this->erro_campo = "si226_vltotaldesembolsoatividafinanciame";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si226_sequencial = $si226_sequencial; 
     if(($this->si226_sequencial == null) || ($this->si226_sequencial == "") ){ 
       $this->erro_sql = " Campo si226_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dfcdcasp802017(
                                       si226_sequencial 
                                      ,si226_tiporegistro 
                                      ,si226_exercicio 
                                      ,si226_vlamortizacaorefinanciamento 
                                      ,si226_vloutrosdesembolsosfinanciamento 
                                      ,si226_vltotaldesembolsoatividafinanciame 
                       )
                values (
                                $this->si226_sequencial 
                               ,$this->si226_tiporegistro 
                               ,$this->si226_exercicio 
                               ,$this->si226_vlamortizacaorefinanciamento 
                               ,$this->si226_vloutrosdesembolsosfinanciamento 
                               ,$this->si226_vltotaldesembolsoatividafinanciame 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp802017 ($this->si226_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dfcdcasp802017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dfcdcasp802017 ($this->si226_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si226_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009523,'$this->si226_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010220,1009523,'','".AddSlashes(pg_result($resaco,0,'si226_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010220,1009524,'','".AddSlashes(pg_result($resaco,0,'si226_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010220,1009525,'','".AddSlashes(pg_result($resaco,0,'si226_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010220,1009526,'','".AddSlashes(pg_result($resaco,0,'si226_vlamortizacaorefinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010220,1009527,'','".AddSlashes(pg_result($resaco,0,'si226_vloutrosdesembolsosfinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010220,1009528,'','".AddSlashes(pg_result($resaco,0,'si226_vltotaldesembolsoatividafinanciame'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si226_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dfcdcasp802017 set ";
     $virgula = "";
     if(trim($this->si226_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_sequencial"])){ 
       $sql  .= $virgula." si226_sequencial = $this->si226_sequencial ";
       $virgula = ",";
       if(trim($this->si226_sequencial) == null ){ 
         $this->erro_sql = " Campo si226_sequencial não informado.";
         $this->erro_campo = "si226_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_tiporegistro"])){ 
       $sql  .= $virgula." si226_tiporegistro = $this->si226_tiporegistro ";
       $virgula = ",";
       if(trim($this->si226_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si226_tiporegistro não informado.";
         $this->erro_campo = "si226_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_exercicio"])){ 
       $sql  .= $virgula." si226_exercicio = $this->si226_exercicio ";
       $virgula = ",";
       if(trim($this->si226_exercicio) == null ){ 
         $this->erro_sql = " Campo si226_exercicio não informado.";
         $this->erro_campo = "si226_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_vlamortizacaorefinanciamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_vlamortizacaorefinanciamento"])){ 
       $sql  .= $virgula." si226_vlamortizacaorefinanciamento = $this->si226_vlamortizacaorefinanciamento ";
       $virgula = ",";
       if(trim($this->si226_vlamortizacaorefinanciamento) == null ){ 
         $this->erro_sql = " Campo si226_vlamortizacaorefinanciamento não informado.";
         $this->erro_campo = "si226_vlamortizacaorefinanciamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_vloutrosdesembolsosfinanciamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_vloutrosdesembolsosfinanciamento"])){ 
       $sql  .= $virgula." si226_vloutrosdesembolsosfinanciamento = $this->si226_vloutrosdesembolsosfinanciamento ";
       $virgula = ",";
       if(trim($this->si226_vloutrosdesembolsosfinanciamento) == null ){ 
         $this->erro_sql = " Campo si226_vloutrosdesembolsosfinanciamento não informado.";
         $this->erro_campo = "si226_vloutrosdesembolsosfinanciamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_vltotaldesembolsoatividafinanciame)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_vltotaldesembolsoatividafinanciame"])){ 
       $sql  .= $virgula." si226_vltotaldesembolsoatividafinanciame = $this->si226_vltotaldesembolsoatividafinanciame ";
       $virgula = ",";
       if(trim($this->si226_vltotaldesembolsoatividafinanciame) == null ){ 
         $this->erro_sql = " Campo si226_vltotaldesembolsoatividafinanciame não informado.";
         $this->erro_campo = "si226_vltotaldesembolsoatividafinanciame";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si226_sequencial!=null){
       $sql .= " si226_sequencial = $this->si226_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si226_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009523,'$this->si226_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si226_sequencial"]) || $this->si226_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010220,1009523,'".AddSlashes(pg_result($resaco,$conresaco,'si226_sequencial'))."','$this->si226_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si226_tiporegistro"]) || $this->si226_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010220,1009524,'".AddSlashes(pg_result($resaco,$conresaco,'si226_tiporegistro'))."','$this->si226_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si226_exercicio"]) || $this->si226_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010220,1009525,'".AddSlashes(pg_result($resaco,$conresaco,'si226_exercicio'))."','$this->si226_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si226_vlamortizacaorefinanciamento"]) || $this->si226_vlamortizacaorefinanciamento != "")
             $resac = db_query("insert into db_acount values($acount,1010220,1009526,'".AddSlashes(pg_result($resaco,$conresaco,'si226_vlamortizacaorefinanciamento'))."','$this->si226_vlamortizacaorefinanciamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si226_vloutrosdesembolsosfinanciamento"]) || $this->si226_vloutrosdesembolsosfinanciamento != "")
             $resac = db_query("insert into db_acount values($acount,1010220,1009527,'".AddSlashes(pg_result($resaco,$conresaco,'si226_vloutrosdesembolsosfinanciamento'))."','$this->si226_vloutrosdesembolsosfinanciamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si226_vltotaldesembolsoatividafinanciame"]) || $this->si226_vltotaldesembolsoatividafinanciame != "")
             $resac = db_query("insert into db_acount values($acount,1010220,1009528,'".AddSlashes(pg_result($resaco,$conresaco,'si226_vltotaldesembolsoatividafinanciame'))."','$this->si226_vltotaldesembolsoatividafinanciame',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp802017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp802017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si226_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si226_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009523,'$si226_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010220,1009523,'','".AddSlashes(pg_result($resaco,$iresaco,'si226_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010220,1009524,'','".AddSlashes(pg_result($resaco,$iresaco,'si226_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010220,1009525,'','".AddSlashes(pg_result($resaco,$iresaco,'si226_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010220,1009526,'','".AddSlashes(pg_result($resaco,$iresaco,'si226_vlamortizacaorefinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010220,1009527,'','".AddSlashes(pg_result($resaco,$iresaco,'si226_vloutrosdesembolsosfinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010220,1009528,'','".AddSlashes(pg_result($resaco,$iresaco,'si226_vltotaldesembolsoatividafinanciame'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from dfcdcasp802017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si226_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si226_sequencial = $si226_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp802017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si226_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp802017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si226_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si226_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp802017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si226_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp802017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si226_sequencial!=null ){
         $sql2 .= " where dfcdcasp802017.si226_sequencial = $si226_sequencial "; 
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
   function sql_query_file ( $si226_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp802017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si226_sequencial!=null ){
         $sql2 .= " where dfcdcasp802017.si226_sequencial = $si226_sequencial "; 
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
