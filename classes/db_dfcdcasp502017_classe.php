<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp502017
class cl_dfcdcasp502017 { 
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
   var $si223_sequencial = 0; 
   var $si223_tiporegistro = 0; 
   var $si223_exercicio = 0; 
   var $si223_vlaquisicaoativonaocirculante = 0; 
   var $si223_vlconcessaoempresfinanciamento = 0; 
   var $si223_vloutrosdesembolsos = 0; 
   var $si223_vltotaldesembolsoatividainvestimen = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si223_sequencial = int4 = si223_sequencial 
                 si223_tiporegistro = int4 = si223_tiporegistro 
                 si223_exercicio = int4 = si223_exercicio 
                 si223_vlaquisicaoativonaocirculante = float4 = si223_vlaquisicaoativonaocirculante 
                 si223_vlconcessaoempresfinanciamento = float4 = si223_vlconcessaoempresfinanciamento 
                 si223_vloutrosdesembolsos = float4 = si223_vloutrosdesembolsos 
                 si223_vltotaldesembolsoatividainvestimen = float4 = si223_vltotaldesembolsoatividainvestimen 
                 ";
   //funcao construtor da classe 
   function cl_dfcdcasp502017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp502017"); 
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
       $this->si223_sequencial = ($this->si223_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_sequencial"]:$this->si223_sequencial);
       $this->si223_tiporegistro = ($this->si223_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_tiporegistro"]:$this->si223_tiporegistro);
       $this->si223_exercicio = ($this->si223_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_exercicio"]:$this->si223_exercicio);
       $this->si223_vlaquisicaoativonaocirculante = ($this->si223_vlaquisicaoativonaocirculante == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_vlaquisicaoativonaocirculante"]:$this->si223_vlaquisicaoativonaocirculante);
       $this->si223_vlconcessaoempresfinanciamento = ($this->si223_vlconcessaoempresfinanciamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_vlconcessaoempresfinanciamento"]:$this->si223_vlconcessaoempresfinanciamento);
       $this->si223_vloutrosdesembolsos = ($this->si223_vloutrosdesembolsos == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_vloutrosdesembolsos"]:$this->si223_vloutrosdesembolsos);
       $this->si223_vltotaldesembolsoatividainvestimen = ($this->si223_vltotaldesembolsoatividainvestimen == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_vltotaldesembolsoatividainvestimen"]:$this->si223_vltotaldesembolsoatividainvestimen);
     }else{
       $this->si223_sequencial = ($this->si223_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si223_sequencial"]:$this->si223_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si223_sequencial){ 
      $this->atualizacampos();
     if($this->si223_tiporegistro == null ){ 
       $this->erro_sql = " Campo si223_tiporegistro não informado.";
       $this->erro_campo = "si223_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si223_exercicio == null ){ 
       $this->erro_sql = " Campo si223_exercicio não informado.";
       $this->erro_campo = "si223_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si223_vlaquisicaoativonaocirculante == null ){ 
       $this->erro_sql = " Campo si223_vlaquisicaoativonaocirculante não informado.";
       $this->erro_campo = "si223_vlaquisicaoativonaocirculante";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si223_vlconcessaoempresfinanciamento == null ){ 
       $this->erro_sql = " Campo si223_vlconcessaoempresfinanciamento não informado.";
       $this->erro_campo = "si223_vlconcessaoempresfinanciamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si223_vloutrosdesembolsos == null ){ 
       $this->erro_sql = " Campo si223_vloutrosdesembolsos não informado.";
       $this->erro_campo = "si223_vloutrosdesembolsos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si223_vltotaldesembolsoatividainvestimen == null ){ 
       $this->erro_sql = " Campo si223_vltotaldesembolsoatividainvestimen não informado.";
       $this->erro_campo = "si223_vltotaldesembolsoatividainvestimen";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si223_sequencial = $si223_sequencial; 
     if(($this->si223_sequencial == null) || ($this->si223_sequencial == "") ){ 
       $this->erro_sql = " Campo si223_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dfcdcasp502017(
                                       si223_sequencial 
                                      ,si223_tiporegistro 
                                      ,si223_exercicio 
                                      ,si223_vlaquisicaoativonaocirculante 
                                      ,si223_vlconcessaoempresfinanciamento 
                                      ,si223_vloutrosdesembolsos 
                                      ,si223_vltotaldesembolsoatividainvestimen 
                       )
                values (
                                $this->si223_sequencial 
                               ,$this->si223_tiporegistro 
                               ,$this->si223_exercicio 
                               ,$this->si223_vlaquisicaoativonaocirculante 
                               ,$this->si223_vlconcessaoempresfinanciamento 
                               ,$this->si223_vloutrosdesembolsos 
                               ,$this->si223_vltotaldesembolsoatividainvestimen 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp502017 ($this->si223_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dfcdcasp502017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dfcdcasp502017 ($this->si223_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si223_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si223_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009504,'$this->si223_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010217,1009504,'','".AddSlashes(pg_result($resaco,0,'si223_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010217,1009505,'','".AddSlashes(pg_result($resaco,0,'si223_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010217,1009506,'','".AddSlashes(pg_result($resaco,0,'si223_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010217,1009507,'','".AddSlashes(pg_result($resaco,0,'si223_vlaquisicaoativonaocirculante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010217,1009508,'','".AddSlashes(pg_result($resaco,0,'si223_vlconcessaoempresfinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010217,1009509,'','".AddSlashes(pg_result($resaco,0,'si223_vloutrosdesembolsos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010217,1009510,'','".AddSlashes(pg_result($resaco,0,'si223_vltotaldesembolsoatividainvestimen'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si223_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dfcdcasp502017 set ";
     $virgula = "";
     if(trim($this->si223_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si223_sequencial"])){ 
       $sql  .= $virgula." si223_sequencial = $this->si223_sequencial ";
       $virgula = ",";
       if(trim($this->si223_sequencial) == null ){ 
         $this->erro_sql = " Campo si223_sequencial não informado.";
         $this->erro_campo = "si223_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si223_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si223_tiporegistro"])){ 
       $sql  .= $virgula." si223_tiporegistro = $this->si223_tiporegistro ";
       $virgula = ",";
       if(trim($this->si223_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si223_tiporegistro não informado.";
         $this->erro_campo = "si223_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si223_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si223_exercicio"])){ 
       $sql  .= $virgula." si223_exercicio = $this->si223_exercicio ";
       $virgula = ",";
       if(trim($this->si223_exercicio) == null ){ 
         $this->erro_sql = " Campo si223_exercicio não informado.";
         $this->erro_campo = "si223_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si223_vlaquisicaoativonaocirculante)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si223_vlaquisicaoativonaocirculante"])){ 
       $sql  .= $virgula." si223_vlaquisicaoativonaocirculante = $this->si223_vlaquisicaoativonaocirculante ";
       $virgula = ",";
       if(trim($this->si223_vlaquisicaoativonaocirculante) == null ){ 
         $this->erro_sql = " Campo si223_vlaquisicaoativonaocirculante não informado.";
         $this->erro_campo = "si223_vlaquisicaoativonaocirculante";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si223_vlconcessaoempresfinanciamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si223_vlconcessaoempresfinanciamento"])){ 
       $sql  .= $virgula." si223_vlconcessaoempresfinanciamento = $this->si223_vlconcessaoempresfinanciamento ";
       $virgula = ",";
       if(trim($this->si223_vlconcessaoempresfinanciamento) == null ){ 
         $this->erro_sql = " Campo si223_vlconcessaoempresfinanciamento não informado.";
         $this->erro_campo = "si223_vlconcessaoempresfinanciamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si223_vloutrosdesembolsos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si223_vloutrosdesembolsos"])){ 
       $sql  .= $virgula." si223_vloutrosdesembolsos = $this->si223_vloutrosdesembolsos ";
       $virgula = ",";
       if(trim($this->si223_vloutrosdesembolsos) == null ){ 
         $this->erro_sql = " Campo si223_vloutrosdesembolsos não informado.";
         $this->erro_campo = "si223_vloutrosdesembolsos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si223_vltotaldesembolsoatividainvestimen)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si223_vltotaldesembolsoatividainvestimen"])){ 
       $sql  .= $virgula." si223_vltotaldesembolsoatividainvestimen = $this->si223_vltotaldesembolsoatividainvestimen ";
       $virgula = ",";
       if(trim($this->si223_vltotaldesembolsoatividainvestimen) == null ){ 
         $this->erro_sql = " Campo si223_vltotaldesembolsoatividainvestimen não informado.";
         $this->erro_campo = "si223_vltotaldesembolsoatividainvestimen";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si223_sequencial!=null){
       $sql .= " si223_sequencial = $this->si223_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si223_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009504,'$this->si223_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si223_sequencial"]) || $this->si223_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010217,1009504,'".AddSlashes(pg_result($resaco,$conresaco,'si223_sequencial'))."','$this->si223_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si223_tiporegistro"]) || $this->si223_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010217,1009505,'".AddSlashes(pg_result($resaco,$conresaco,'si223_tiporegistro'))."','$this->si223_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si223_exercicio"]) || $this->si223_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010217,1009506,'".AddSlashes(pg_result($resaco,$conresaco,'si223_exercicio'))."','$this->si223_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si223_vlaquisicaoativonaocirculante"]) || $this->si223_vlaquisicaoativonaocirculante != "")
             $resac = db_query("insert into db_acount values($acount,1010217,1009507,'".AddSlashes(pg_result($resaco,$conresaco,'si223_vlaquisicaoativonaocirculante'))."','$this->si223_vlaquisicaoativonaocirculante',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si223_vlconcessaoempresfinanciamento"]) || $this->si223_vlconcessaoempresfinanciamento != "")
             $resac = db_query("insert into db_acount values($acount,1010217,1009508,'".AddSlashes(pg_result($resaco,$conresaco,'si223_vlconcessaoempresfinanciamento'))."','$this->si223_vlconcessaoempresfinanciamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si223_vloutrosdesembolsos"]) || $this->si223_vloutrosdesembolsos != "")
             $resac = db_query("insert into db_acount values($acount,1010217,1009509,'".AddSlashes(pg_result($resaco,$conresaco,'si223_vloutrosdesembolsos'))."','$this->si223_vloutrosdesembolsos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si223_vltotaldesembolsoatividainvestimen"]) || $this->si223_vltotaldesembolsoatividainvestimen != "")
             $resac = db_query("insert into db_acount values($acount,1010217,1009510,'".AddSlashes(pg_result($resaco,$conresaco,'si223_vltotaldesembolsoatividainvestimen'))."','$this->si223_vltotaldesembolsoatividainvestimen',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp502017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si223_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp502017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si223_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si223_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si223_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si223_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009504,'$si223_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010217,1009504,'','".AddSlashes(pg_result($resaco,$iresaco,'si223_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010217,1009505,'','".AddSlashes(pg_result($resaco,$iresaco,'si223_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010217,1009506,'','".AddSlashes(pg_result($resaco,$iresaco,'si223_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010217,1009507,'','".AddSlashes(pg_result($resaco,$iresaco,'si223_vlaquisicaoativonaocirculante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010217,1009508,'','".AddSlashes(pg_result($resaco,$iresaco,'si223_vlconcessaoempresfinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010217,1009509,'','".AddSlashes(pg_result($resaco,$iresaco,'si223_vloutrosdesembolsos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010217,1009510,'','".AddSlashes(pg_result($resaco,$iresaco,'si223_vltotaldesembolsoatividainvestimen'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from dfcdcasp502017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si223_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si223_sequencial = $si223_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp502017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si223_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp502017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si223_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si223_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp502017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si223_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp502017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si223_sequencial!=null ){
         $sql2 .= " where dfcdcasp502017.si223_sequencial = $si223_sequencial "; 
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
   function sql_query_file ( $si223_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp502017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si223_sequencial!=null ){
         $sql2 .= " where dfcdcasp502017.si223_sequencial = $si223_sequencial "; 
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
