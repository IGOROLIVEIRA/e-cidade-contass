<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos132021
class cl_contratos132021 {
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
   var $si86_sequencial = 0; 
   var $si86_tiporegistro = 0; 
   var $si86_codcontrato = 0; 
   var $si86_tipodocumento = 0; 
   var $si86_nrodocumento = null; 
   var $si86_tipodocrepresentante = 0;
   var $si86_nrodocrepresentantelegal = null;
   var $si86_mes = 0;
   var $si86_reg10 = 0; 
   var $si86_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si86_sequencial = int8 = sequencial 
                 si86_tiporegistro = int8 = Tipo do  registro 
                 si86_codcontrato = int8 = Código do contrato 
                 si86_tipodocumento = int8 = Tipo do documento 
                 si86_nrodocumento = varchar(14) = Número do  documento
                 si86_tipodocrepresentante = int8 = Tipo do documento do representante 
                 si86_nrodocrepresentantelegal = varchar(14) = Número do Documento do  Representante 
                 si86_mes = int8 = Mês 
                 si86_reg10 = int8 = reg10 
                 si86_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_contratos132021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos132021");
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
       $this->si86_sequencial = ($this->si86_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_sequencial"]:$this->si86_sequencial);
       $this->si86_tiporegistro = ($this->si86_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_tiporegistro"]:$this->si86_tiporegistro);
       $this->si86_codcontrato = ($this->si86_codcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_codcontrato"]:$this->si86_codcontrato);
       $this->si86_tipodocumento = ($this->si86_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_tipodocumento"]:$this->si86_tipodocumento);
       $this->si86_nrodocumento = ($this->si86_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_nrodocumento"]:$this->si86_nrodocumento);
       $this->si86_tipodocrepresentante = ($this->si86_tipodocrepresentante == ""?@$GLOBALS["HTTP_POST_VARS"]["$this->si86_tipodocrepresentante"]:$this->si86_tipodocrepresentante);
       $this->si86_nrodocrepresentantelegal = ($this->si86_nrodocrepresentantelegal == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_nrodocrepresentantelegal"]:$this->si86_nrodocrepresentantelegal);
       $this->si86_mes = ($this->si86_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_mes"]:$this->si86_mes);
       $this->si86_reg10 = ($this->si86_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_reg10"]:$this->si86_reg10);
       $this->si86_instit = ($this->si86_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_instit"]:$this->si86_instit);
     }else{
       $this->si86_sequencial = ($this->si86_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si86_sequencial"]:$this->si86_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si86_sequencial){ 
      $this->atualizacampos();
     if($this->si86_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si86_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si86_codcontrato == null ){ 
       $this->si86_codcontrato = "0";
     }
     if($this->si86_tipodocumento == null ){ 
       $this->si86_tipodocumento = "0";
     }
     if($this->si86_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si86_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si86_reg10 == null ){ 
       $this->si86_reg10 = "0";
     }
     if($this->si86_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si86_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si86_tipodocrepresentante == null ){
       $this->erro_sql = " Campo Tipo do Documento do Representante nao Informado.";
       $this->erro_campo = "si86_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si86_sequencial == "" || $si86_sequencial == null ){
       $result = db_query("select nextval('contratos132021_si86_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos132021_si86_sequencial_seq do campo: si86_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si86_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from contratos132021_si86_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si86_sequencial)){
         $this->erro_sql = " Campo si86_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si86_sequencial = $si86_sequencial; 
       }
     }
     if(($this->si86_sequencial == null) || ($this->si86_sequencial == "") ){ 
       $this->erro_sql = " Campo si86_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos132021(
                                       si86_sequencial 
                                      ,si86_tiporegistro 
                                      ,si86_codcontrato 
                                      ,si86_tipodocumento 
                                      ,si86_nrodocumento
                                      ,si86_tipodocrepresentante 
                                      ,si86_nrodocrepresentantelegal 
                                      ,si86_mes 
                                      ,si86_reg10 
                                      ,si86_instit 
                       )
                values (
                                $this->si86_sequencial 
                               ,$this->si86_tiporegistro 
                               ,$this->si86_codcontrato 
                               ,$this->si86_tipodocumento 
                               ,'$this->si86_nrodocumento'
                               ,$this->si86_tipodocrepresentante
                               ,'$this->si86_nrodocrepresentantelegal' 
                               ,$this->si86_mes 
                               ,$this->si86_reg10 
                               ,$this->si86_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos132021 ($this->si86_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "contratos132021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "contratos132021 ($this->si86_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si86_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si86_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010450,'$this->si86_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010315,2010450,'','".AddSlashes(pg_result($resaco,0,'si86_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2010451,'','".AddSlashes(pg_result($resaco,0,'si86_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2010452,'','".AddSlashes(pg_result($resaco,0,'si86_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2010453,'','".AddSlashes(pg_result($resaco,0,'si86_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2010454,'','".AddSlashes(pg_result($resaco,0,'si86_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2010455,'','".AddSlashes(pg_result($resaco,0,'si86_nrodocrepresentantelegal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2010456,'','".AddSlashes(pg_result($resaco,0,'si86_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2010457,'','".AddSlashes(pg_result($resaco,0,'si86_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010315,2011599,'','".AddSlashes(pg_result($resaco,0,'si86_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si86_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update contratos132021 set ";
     $virgula = "";
     if(trim($this->si86_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_sequencial"])){ 
        if(trim($this->si86_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si86_sequencial"])){ 
           $this->si86_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si86_sequencial = $this->si86_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si86_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_tiporegistro"])){ 
       $sql  .= $virgula." si86_tiporegistro = $this->si86_tiporegistro ";
       $virgula = ",";
       if(trim($this->si86_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si86_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si86_codcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_codcontrato"])){ 
        if(trim($this->si86_codcontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si86_codcontrato"])){ 
           $this->si86_codcontrato = "0" ; 
        } 
       $sql  .= $virgula." si86_codcontrato = $this->si86_codcontrato ";
       $virgula = ",";
     }
     if(trim($this->si86_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_tipodocumento"])){ 
        if(trim($this->si86_tipodocumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si86_tipodocumento"])){ 
           $this->si86_tipodocumento = "0" ; 
        } 
       $sql  .= $virgula." si86_tipodocumento = $this->si86_tipodocumento ";
       $virgula = ",";
     }
     if(trim($this->si86_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_nrodocumento"])){ 
       $sql  .= $virgula." si86_nrodocumento = '$this->si86_nrodocumento' ";
       $virgula = ",";
     }
     if(trim($this->si86_tipodocrepresentante)!="" || isset($GLOBALS["HTTP_POST_VARS"]["$this->si86_tipodocrepresentante"])){
       $sql  .= $virgula." $this->si86_tipodocrepresentante = $this->si86_tipodocrepresentante ";
       $virgula = ",";
     }
     if(trim($this->si86_nrodocrepresentantelegal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_nrodocrepresentantelegal"])){
       $sql  .= $virgula." si86_nrodocrepresentantelegal = '$this->si86_nrodocrepresentantelegal' ";
       $virgula = ",";
     }
     if(trim($this->si86_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_mes"])){ 
       $sql  .= $virgula." si86_mes = $this->si86_mes ";
       $virgula = ",";
       if(trim($this->si86_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si86_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si86_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_reg10"])){ 
        if(trim($this->si86_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si86_reg10"])){ 
           $this->si86_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si86_reg10 = $this->si86_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si86_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si86_instit"])){ 
       $sql  .= $virgula." si86_instit = $this->si86_instit ";
       $virgula = ",";
       if(trim($this->si86_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si86_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si86_sequencial!=null){
       $sql .= " si86_sequencial = $this->si86_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si86_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010450,'$this->si86_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_sequencial"]) || $this->si86_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010450,'".AddSlashes(pg_result($resaco,$conresaco,'si86_sequencial'))."','$this->si86_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_tiporegistro"]) || $this->si86_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010451,'".AddSlashes(pg_result($resaco,$conresaco,'si86_tiporegistro'))."','$this->si86_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_codcontrato"]) || $this->si86_codcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010452,'".AddSlashes(pg_result($resaco,$conresaco,'si86_codcontrato'))."','$this->si86_codcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_tipodocumento"]) || $this->si86_tipodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010453,'".AddSlashes(pg_result($resaco,$conresaco,'si86_tipodocumento'))."','$this->si86_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_nrodocumento"]) || $this->si86_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010454,'".AddSlashes(pg_result($resaco,$conresaco,'si86_nrodocumento'))."','$this->si86_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_nrodocrepresentantelegal"]) || $this->si86_nrodocrepresentantelegal != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010455,'".AddSlashes(pg_result($resaco,$conresaco,'si86_nrodocrepresentantelegal'))."','$this->si86_nrodocrepresentantelegal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_mes"]) || $this->si86_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010456,'".AddSlashes(pg_result($resaco,$conresaco,'si86_mes'))."','$this->si86_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_reg10"]) || $this->si86_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2010457,'".AddSlashes(pg_result($resaco,$conresaco,'si86_reg10'))."','$this->si86_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si86_instit"]) || $this->si86_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010315,2011599,'".AddSlashes(pg_result($resaco,$conresaco,'si86_instit'))."','$this->si86_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos132021 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si86_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos132021 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si86_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si86_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si86_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si86_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010450,'$si86_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010315,2010450,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2010451,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2010452,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2010453,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2010454,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2010455,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_nrodocrepresentantelegal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2010456,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2010457,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010315,2011599,'','".AddSlashes(pg_result($resaco,$iresaco,'si86_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos132021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si86_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si86_sequencial = $si86_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos132021 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si86_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos132021 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si86_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si86_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
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
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:contratos132021";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si86_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos132021 ";
     $sql .= "      left  join contratos102021  on  contratos102021.si83_sequencial = contratos132021.si86_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si86_sequencial!=null ){
         $sql2 .= " where contratos132021.si86_sequencial = $si86_sequencial ";
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
   function sql_query_file ( $si86_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos132021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si86_sequencial!=null ){
         $sql2 .= " where contratos132021.si86_sequencial = $si86_sequencial ";
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
