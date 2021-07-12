<?
//MODULO: sicom
//CLASSE DA ENTIDADE ddc122014
class cl_ddc122014 { 
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
   var $si152_sequencial = 0; 
   var $si152_tiporegistro = 0; 
   var $si152_codcontrato = 0; 
   var $si152_tipodocumento = 0; 
   var $si152_nrodocumento = null; 
   var $si152_mes = 0; 
   var $si152_reg10 = 0; 
   var $si152_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si152_sequencial = int8 = sequencial 
                 si152_tiporegistro = int8 = Tipo do  registro 
                 si152_codcontrato = int8 = Código do  Contrato 
                 si152_tipodocumento = int8 = Tipo de  Documento do credor 
                 si152_nrodocumento = varchar(14) = Número do  documento do  Credor 
                 si152_mes = int8 = Mês 
                 si152_reg10 = int8 = reg10 
                 si152_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ddc122014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ddc122014"); 
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
       $this->si152_sequencial = ($this->si152_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_sequencial"]:$this->si152_sequencial);
       $this->si152_tiporegistro = ($this->si152_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_tiporegistro"]:$this->si152_tiporegistro);
       $this->si152_codcontrato = ($this->si152_codcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_codcontrato"]:$this->si152_codcontrato);
       $this->si152_tipodocumento = ($this->si152_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_tipodocumento"]:$this->si152_tipodocumento);
       $this->si152_nrodocumento = ($this->si152_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_nrodocumento"]:$this->si152_nrodocumento);
       $this->si152_mes = ($this->si152_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_mes"]:$this->si152_mes);
       $this->si152_reg10 = ($this->si152_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_reg10"]:$this->si152_reg10);
       $this->si152_instit = ($this->si152_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_instit"]:$this->si152_instit);
     }else{
       $this->si152_sequencial = ($this->si152_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si152_sequencial"]:$this->si152_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si152_sequencial){ 
      $this->atualizacampos();
     if($this->si152_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si152_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si152_codcontrato == null ){ 
       $this->si152_codcontrato = "0";
     }
     if($this->si152_tipodocumento == null ){ 
       $this->si152_tipodocumento = "0";
     }
     if($this->si152_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si152_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si152_reg10 == null ){ 
       $this->si152_reg10 = "0";
     }
     if($this->si152_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si152_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si152_sequencial == "" || $si152_sequencial == null ){
       $result = db_query("select nextval('ddc122014_si152_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ddc122014_si152_sequencial_seq do campo: si152_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si152_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ddc122014_si152_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si152_sequencial)){
         $this->erro_sql = " Campo si152_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si152_sequencial = $si152_sequencial; 
       }
     }
     if(($this->si152_sequencial == null) || ($this->si152_sequencial == "") ){ 
       $this->erro_sql = " Campo si152_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ddc122014(
                                       si152_sequencial 
                                      ,si152_tiporegistro 
                                      ,si152_codcontrato 
                                      ,si152_tipodocumento 
                                      ,si152_nrodocumento 
                                      ,si152_mes 
                                      ,si152_reg10 
                                      ,si152_instit 
                       )
                values (
                                $this->si152_sequencial 
                               ,$this->si152_tiporegistro 
                               ,$this->si152_codcontrato 
                               ,$this->si152_tipodocumento 
                               ,'$this->si152_nrodocumento' 
                               ,$this->si152_mes 
                               ,$this->si152_reg10 
                               ,$this->si152_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ddc122014 ($this->si152_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ddc122014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ddc122014 ($this->si152_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si152_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si152_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011161,'$this->si152_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010381,2011161,'','".AddSlashes(pg_result($resaco,0,'si152_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010381,2011162,'','".AddSlashes(pg_result($resaco,0,'si152_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010381,2011163,'','".AddSlashes(pg_result($resaco,0,'si152_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010381,2011164,'','".AddSlashes(pg_result($resaco,0,'si152_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010381,2011165,'','".AddSlashes(pg_result($resaco,0,'si152_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010381,2011166,'','".AddSlashes(pg_result($resaco,0,'si152_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010381,2011167,'','".AddSlashes(pg_result($resaco,0,'si152_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010381,2011665,'','".AddSlashes(pg_result($resaco,0,'si152_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si152_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ddc122014 set ";
     $virgula = "";
     if(trim($this->si152_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_sequencial"])){ 
        if(trim($this->si152_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si152_sequencial"])){ 
           $this->si152_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si152_sequencial = $this->si152_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si152_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_tiporegistro"])){ 
       $sql  .= $virgula." si152_tiporegistro = $this->si152_tiporegistro ";
       $virgula = ",";
       if(trim($this->si152_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si152_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si152_codcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_codcontrato"])){ 
        if(trim($this->si152_codcontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si152_codcontrato"])){ 
           $this->si152_codcontrato = "0" ; 
        } 
       $sql  .= $virgula." si152_codcontrato = $this->si152_codcontrato ";
       $virgula = ",";
     }
     if(trim($this->si152_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_tipodocumento"])){ 
        if(trim($this->si152_tipodocumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si152_tipodocumento"])){ 
           $this->si152_tipodocumento = "0" ; 
        } 
       $sql  .= $virgula." si152_tipodocumento = $this->si152_tipodocumento ";
       $virgula = ",";
     }
     if(trim($this->si152_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_nrodocumento"])){ 
       $sql  .= $virgula." si152_nrodocumento = '$this->si152_nrodocumento' ";
       $virgula = ",";
     }
     if(trim($this->si152_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_mes"])){ 
       $sql  .= $virgula." si152_mes = $this->si152_mes ";
       $virgula = ",";
       if(trim($this->si152_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si152_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si152_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_reg10"])){ 
        if(trim($this->si152_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si152_reg10"])){ 
           $this->si152_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si152_reg10 = $this->si152_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si152_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si152_instit"])){ 
       $sql  .= $virgula." si152_instit = $this->si152_instit ";
       $virgula = ",";
       if(trim($this->si152_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si152_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si152_sequencial!=null){
       $sql .= " si152_sequencial = $this->si152_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si152_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011161,'$this->si152_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_sequencial"]) || $this->si152_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011161,'".AddSlashes(pg_result($resaco,$conresaco,'si152_sequencial'))."','$this->si152_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_tiporegistro"]) || $this->si152_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011162,'".AddSlashes(pg_result($resaco,$conresaco,'si152_tiporegistro'))."','$this->si152_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_codcontrato"]) || $this->si152_codcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011163,'".AddSlashes(pg_result($resaco,$conresaco,'si152_codcontrato'))."','$this->si152_codcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_tipodocumento"]) || $this->si152_tipodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011164,'".AddSlashes(pg_result($resaco,$conresaco,'si152_tipodocumento'))."','$this->si152_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_nrodocumento"]) || $this->si152_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011165,'".AddSlashes(pg_result($resaco,$conresaco,'si152_nrodocumento'))."','$this->si152_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_mes"]) || $this->si152_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011166,'".AddSlashes(pg_result($resaco,$conresaco,'si152_mes'))."','$this->si152_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_reg10"]) || $this->si152_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011167,'".AddSlashes(pg_result($resaco,$conresaco,'si152_reg10'))."','$this->si152_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si152_instit"]) || $this->si152_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010381,2011665,'".AddSlashes(pg_result($resaco,$conresaco,'si152_instit'))."','$this->si152_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ddc122014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si152_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ddc122014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si152_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si152_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si152_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si152_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011161,'$si152_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010381,2011161,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010381,2011162,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010381,2011163,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010381,2011164,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010381,2011165,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010381,2011166,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010381,2011167,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010381,2011665,'','".AddSlashes(pg_result($resaco,$iresaco,'si152_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ddc122014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si152_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si152_sequencial = $si152_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ddc122014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si152_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ddc122014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si152_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si152_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ddc122014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si152_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ddc122014 ";
     $sql .= "      left  join ddc102014  on  ddc102014.si150_sequencial = ddc122014.si152_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si152_sequencial!=null ){
         $sql2 .= " where ddc122014.si152_sequencial = $si152_sequencial "; 
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
   function sql_query_file ( $si152_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ddc122014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si152_sequencial!=null ){
         $sql2 .= " where ddc122014.si152_sequencial = $si152_sequencial "; 
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
