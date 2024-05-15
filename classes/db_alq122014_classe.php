<?
//MODULO: sicom
//CLASSE DA ENTIDADE alq122014
class cl_alq122014 { 
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
   var $si123_sequencial = 0; 
   var $si123_tiporegistro = 0; 
   var $si123_codreduzido = 0; 
   var $si123_mescompetencia = null; 
   var $si123_exerciciocompetencia = 0; 
   var $si123_vlanuladodspexerant = 0; 
   var $si123_mes = 0; 
   var $si123_reg10 = 0; 
   var $si123_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si123_sequencial = int8 = sequencial 
                 si123_tiporegistro = int8 = Tipo do  registro 
                 si123_codreduzido = int8 = Código Identificador do registro 
                 si123_mescompetencia = varchar(2) = Mês de  competência 
                 si123_exerciciocompetencia = int8 = Exercício de competência 
                 si123_vlanuladodspexerant = float8 = Valor da anulação  despesa 
                 si123_mes = int8 = Mês 
                 si123_reg10 = int8 = reg10 
                 si123_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_alq122014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("alq122014"); 
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
       $this->si123_sequencial = ($this->si123_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_sequencial"]:$this->si123_sequencial);
       $this->si123_tiporegistro = ($this->si123_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_tiporegistro"]:$this->si123_tiporegistro);
       $this->si123_codreduzido = ($this->si123_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_codreduzido"]:$this->si123_codreduzido);
       $this->si123_mescompetencia = ($this->si123_mescompetencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_mescompetencia"]:$this->si123_mescompetencia);
       $this->si123_exerciciocompetencia = ($this->si123_exerciciocompetencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_exerciciocompetencia"]:$this->si123_exerciciocompetencia);
       $this->si123_vlanuladodspexerant = ($this->si123_vlanuladodspexerant == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_vlanuladodspexerant"]:$this->si123_vlanuladodspexerant);
       $this->si123_mes = ($this->si123_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_mes"]:$this->si123_mes);
       $this->si123_reg10 = ($this->si123_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_reg10"]:$this->si123_reg10);
       $this->si123_instit = ($this->si123_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_instit"]:$this->si123_instit);
     }else{
       $this->si123_sequencial = ($this->si123_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si123_sequencial"]:$this->si123_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si123_sequencial){ 
      $this->atualizacampos();
     if($this->si123_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si123_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si123_codreduzido == null ){ 
       $this->si123_codreduzido = "0";
     }
     if($this->si123_exerciciocompetencia == null ){ 
       $this->si123_exerciciocompetencia = "0";
     }
     if($this->si123_vlanuladodspexerant == null ){ 
       $this->si123_vlanuladodspexerant = "0";
     }
     if($this->si123_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si123_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si123_reg10 == null ){ 
       $this->si123_reg10 = "0";
     }
     if($this->si123_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si123_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si123_sequencial == "" || $si123_sequencial == null ){
       $result = db_query("select nextval('alq122014_si123_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: alq122014_si123_sequencial_seq do campo: si123_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si123_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from alq122014_si123_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si123_sequencial)){
         $this->erro_sql = " Campo si123_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si123_sequencial = $si123_sequencial; 
       }
     }
     if(($this->si123_sequencial == null) || ($this->si123_sequencial == "") ){ 
       $this->erro_sql = " Campo si123_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into alq122014(
                                       si123_sequencial 
                                      ,si123_tiporegistro 
                                      ,si123_codreduzido 
                                      ,si123_mescompetencia 
                                      ,si123_exerciciocompetencia 
                                      ,si123_vlanuladodspexerant 
                                      ,si123_mes 
                                      ,si123_reg10 
                                      ,si123_instit 
                       )
                values (
                                $this->si123_sequencial 
                               ,$this->si123_tiporegistro 
                               ,$this->si123_codreduzido 
                               ,'$this->si123_mescompetencia' 
                               ,$this->si123_exerciciocompetencia 
                               ,$this->si123_vlanuladodspexerant 
                               ,$this->si123_mes 
                               ,$this->si123_reg10 
                               ,$this->si123_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "alq122014 ($this->si123_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "alq122014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "alq122014 ($this->si123_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si123_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si123_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010837,'$this->si123_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010352,2010837,'','".AddSlashes(pg_result($resaco,0,'si123_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2010838,'','".AddSlashes(pg_result($resaco,0,'si123_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2010839,'','".AddSlashes(pg_result($resaco,0,'si123_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2010840,'','".AddSlashes(pg_result($resaco,0,'si123_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2010841,'','".AddSlashes(pg_result($resaco,0,'si123_exerciciocompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2010842,'','".AddSlashes(pg_result($resaco,0,'si123_vlanuladodspexerant'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2010843,'','".AddSlashes(pg_result($resaco,0,'si123_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2010844,'','".AddSlashes(pg_result($resaco,0,'si123_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010352,2011636,'','".AddSlashes(pg_result($resaco,0,'si123_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si123_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update alq122014 set ";
     $virgula = "";
     if(trim($this->si123_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_sequencial"])){ 
        if(trim($this->si123_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si123_sequencial"])){ 
           $this->si123_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si123_sequencial = $this->si123_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si123_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_tiporegistro"])){ 
       $sql  .= $virgula." si123_tiporegistro = $this->si123_tiporegistro ";
       $virgula = ",";
       if(trim($this->si123_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si123_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si123_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_codreduzido"])){ 
        if(trim($this->si123_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si123_codreduzido"])){ 
           $this->si123_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si123_codreduzido = $this->si123_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si123_mescompetencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_mescompetencia"])){ 
       $sql  .= $virgula." si123_mescompetencia = '$this->si123_mescompetencia' ";
       $virgula = ",";
     }
     if(trim($this->si123_exerciciocompetencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_exerciciocompetencia"])){ 
        if(trim($this->si123_exerciciocompetencia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si123_exerciciocompetencia"])){ 
           $this->si123_exerciciocompetencia = "0" ; 
        } 
       $sql  .= $virgula." si123_exerciciocompetencia = $this->si123_exerciciocompetencia ";
       $virgula = ",";
     }
     if(trim($this->si123_vlanuladodspexerant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_vlanuladodspexerant"])){ 
        if(trim($this->si123_vlanuladodspexerant)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si123_vlanuladodspexerant"])){ 
           $this->si123_vlanuladodspexerant = "0" ; 
        } 
       $sql  .= $virgula." si123_vlanuladodspexerant = $this->si123_vlanuladodspexerant ";
       $virgula = ",";
     }
     if(trim($this->si123_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_mes"])){ 
       $sql  .= $virgula." si123_mes = $this->si123_mes ";
       $virgula = ",";
       if(trim($this->si123_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si123_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si123_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_reg10"])){ 
        if(trim($this->si123_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si123_reg10"])){ 
           $this->si123_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si123_reg10 = $this->si123_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si123_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si123_instit"])){ 
       $sql  .= $virgula." si123_instit = $this->si123_instit ";
       $virgula = ",";
       if(trim($this->si123_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si123_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si123_sequencial!=null){
       $sql .= " si123_sequencial = $this->si123_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si123_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010837,'$this->si123_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_sequencial"]) || $this->si123_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010837,'".AddSlashes(pg_result($resaco,$conresaco,'si123_sequencial'))."','$this->si123_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_tiporegistro"]) || $this->si123_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010838,'".AddSlashes(pg_result($resaco,$conresaco,'si123_tiporegistro'))."','$this->si123_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_codreduzido"]) || $this->si123_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010839,'".AddSlashes(pg_result($resaco,$conresaco,'si123_codreduzido'))."','$this->si123_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_mescompetencia"]) || $this->si123_mescompetencia != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010840,'".AddSlashes(pg_result($resaco,$conresaco,'si123_mescompetencia'))."','$this->si123_mescompetencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_exerciciocompetencia"]) || $this->si123_exerciciocompetencia != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010841,'".AddSlashes(pg_result($resaco,$conresaco,'si123_exerciciocompetencia'))."','$this->si123_exerciciocompetencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_vlanuladodspexerant"]) || $this->si123_vlanuladodspexerant != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010842,'".AddSlashes(pg_result($resaco,$conresaco,'si123_vlanuladodspexerant'))."','$this->si123_vlanuladodspexerant',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_mes"]) || $this->si123_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010843,'".AddSlashes(pg_result($resaco,$conresaco,'si123_mes'))."','$this->si123_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_reg10"]) || $this->si123_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2010844,'".AddSlashes(pg_result($resaco,$conresaco,'si123_reg10'))."','$this->si123_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si123_instit"]) || $this->si123_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010352,2011636,'".AddSlashes(pg_result($resaco,$conresaco,'si123_instit'))."','$this->si123_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "alq122014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si123_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "alq122014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si123_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si123_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si123_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si123_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010837,'$si123_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010352,2010837,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2010838,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2010839,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2010840,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2010841,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_exerciciocompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2010842,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_vlanuladodspexerant'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2010843,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2010844,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010352,2011636,'','".AddSlashes(pg_result($resaco,$iresaco,'si123_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from alq122014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si123_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si123_sequencial = $si123_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "alq122014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si123_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "alq122014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si123_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si123_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:alq122014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si123_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = explode("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from alq122014 ";
     $sql .= "      left  join alq102014  on  alq102014.si121_sequencial = alq122014.si123_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si123_sequencial!=null ){
         $sql2 .= " where alq122014.si123_sequencial = $si123_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = explode("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $si123_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = explode("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from alq122014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si123_sequencial!=null ){
         $sql2 .= " where alq122014.si123_sequencial = $si123_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = explode("#",$ordem);
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
