<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa112016
class cl_dispensa112016 { 
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
   var $si75_sequencial = 0; 
   var $si75_tiporegistro = 0; 
   var $si75_codorgaoresp = null; 
   var $si75_codunidadesubresp = null; 
   var $si75_exercicioprocesso = 0; 
   var $si75_nroprocesso = null; 
   var $si75_tipoprocesso = 0; 
   var $si75_nrolote = 0; 
   var $si75_dsclote = null; 
   var $si75_mes = 0; 
   var $si75_reg10 = 0; 
   var $si75_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si75_sequencial = int8 = sequencial 
                 si75_tiporegistro = int8 = Tipo do  registro 
                 si75_codorgaoresp = varchar(2) = Código do órgão  responsável 
                 si75_codunidadesubresp = varchar(8) = Código da unidade 
                 si75_exercicioprocesso = int8 = Exercício em que   foi instaurado 
                 si75_nroprocesso = varchar(12) = Número sequencial do processo 
                 si75_tipoprocesso = int8 = Tipo de processo 
                 si75_nrolote = int8 = Número do Lote 
                 si75_dsclote = varchar(250) = Descrição do Lote 
                 si75_mes = int8 = Mês 
                 si75_reg10 = int8 = reg10 
                 si75_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_dispensa112016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dispensa112016"); 
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
       $this->si75_sequencial = ($this->si75_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_sequencial"]:$this->si75_sequencial);
       $this->si75_tiporegistro = ($this->si75_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_tiporegistro"]:$this->si75_tiporegistro);
       $this->si75_codorgaoresp = ($this->si75_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_codorgaoresp"]:$this->si75_codorgaoresp);
       $this->si75_codunidadesubresp = ($this->si75_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_codunidadesubresp"]:$this->si75_codunidadesubresp);
       $this->si75_exercicioprocesso = ($this->si75_exercicioprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_exercicioprocesso"]:$this->si75_exercicioprocesso);
       $this->si75_nroprocesso = ($this->si75_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_nroprocesso"]:$this->si75_nroprocesso);
       $this->si75_tipoprocesso = ($this->si75_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_tipoprocesso"]:$this->si75_tipoprocesso);
       $this->si75_nrolote = ($this->si75_nrolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_nrolote"]:$this->si75_nrolote);
       $this->si75_dsclote = ($this->si75_dsclote == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_dsclote"]:$this->si75_dsclote);
       $this->si75_mes = ($this->si75_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_mes"]:$this->si75_mes);
       $this->si75_reg10 = ($this->si75_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_reg10"]:$this->si75_reg10);
       $this->si75_instit = ($this->si75_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_instit"]:$this->si75_instit);
     }else{
       $this->si75_sequencial = ($this->si75_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si75_sequencial"]:$this->si75_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si75_sequencial){ 
      $this->atualizacampos();
     if($this->si75_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si75_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si75_exercicioprocesso == null ){ 
       $this->si75_exercicioprocesso = "0";
     }
     if($this->si75_tipoprocesso == null ){ 
       $this->si75_tipoprocesso = "0";
     }
     if($this->si75_nrolote == null ){ 
       $this->si75_nrolote = "0";
     }
     if($this->si75_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si75_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si75_reg10 == null ){ 
       $this->si75_reg10 = "0";
     }
     if($this->si75_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si75_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si75_sequencial == "" || $si75_sequencial == null ){
       $result = db_query("select nextval('dispensa112016_si75_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dispensa112016_si75_sequencial_seq do campo: si75_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si75_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dispensa112016_si75_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si75_sequencial)){
         $this->erro_sql = " Campo si75_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si75_sequencial = $si75_sequencial; 
       }
     }
     if(($this->si75_sequencial == null) || ($this->si75_sequencial == "") ){ 
       $this->erro_sql = " Campo si75_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dispensa112016(
                                       si75_sequencial 
                                      ,si75_tiporegistro 
                                      ,si75_codorgaoresp 
                                      ,si75_codunidadesubresp 
                                      ,si75_exercicioprocesso 
                                      ,si75_nroprocesso 
                                      ,si75_tipoprocesso 
                                      ,si75_nrolote 
                                      ,si75_dsclote 
                                      ,si75_mes 
                                      ,si75_reg10 
                                      ,si75_instit 
                       )
                values (
                                $this->si75_sequencial 
                               ,$this->si75_tiporegistro 
                               ,'$this->si75_codorgaoresp' 
                               ,'$this->si75_codunidadesubresp' 
                               ,$this->si75_exercicioprocesso 
                               ,'$this->si75_nroprocesso' 
                               ,$this->si75_tipoprocesso 
                               ,$this->si75_nrolote 
                               ,'$this->si75_dsclote' 
                               ,$this->si75_mes 
                               ,$this->si75_reg10 
                               ,$this->si75_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dispensa112016 ($this->si75_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dispensa112016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dispensa112016 ($this->si75_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si75_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si75_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010271,'$this->si75_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010304,2010271,'','".AddSlashes(pg_result($resaco,0,'si75_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010272,'','".AddSlashes(pg_result($resaco,0,'si75_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010273,'','".AddSlashes(pg_result($resaco,0,'si75_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010274,'','".AddSlashes(pg_result($resaco,0,'si75_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010275,'','".AddSlashes(pg_result($resaco,0,'si75_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010276,'','".AddSlashes(pg_result($resaco,0,'si75_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010277,'','".AddSlashes(pg_result($resaco,0,'si75_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010278,'','".AddSlashes(pg_result($resaco,0,'si75_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010279,'','".AddSlashes(pg_result($resaco,0,'si75_dsclote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010280,'','".AddSlashes(pg_result($resaco,0,'si75_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2010281,'','".AddSlashes(pg_result($resaco,0,'si75_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010304,2011587,'','".AddSlashes(pg_result($resaco,0,'si75_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si75_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dispensa112016 set ";
     $virgula = "";
     if(trim($this->si75_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_sequencial"])){ 
        if(trim($this->si75_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si75_sequencial"])){ 
           $this->si75_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si75_sequencial = $this->si75_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si75_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_tiporegistro"])){ 
       $sql  .= $virgula." si75_tiporegistro = $this->si75_tiporegistro ";
       $virgula = ",";
       if(trim($this->si75_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si75_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si75_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_codorgaoresp"])){ 
       $sql  .= $virgula." si75_codorgaoresp = '$this->si75_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si75_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_codunidadesubresp"])){ 
       $sql  .= $virgula." si75_codunidadesubresp = '$this->si75_codunidadesubresp' ";
       $virgula = ",";
     }
     if(trim($this->si75_exercicioprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_exercicioprocesso"])){ 
        if(trim($this->si75_exercicioprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si75_exercicioprocesso"])){ 
           $this->si75_exercicioprocesso = "0" ; 
        } 
       $sql  .= $virgula." si75_exercicioprocesso = $this->si75_exercicioprocesso ";
       $virgula = ",";
     }
     if(trim($this->si75_nroprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_nroprocesso"])){ 
       $sql  .= $virgula." si75_nroprocesso = '$this->si75_nroprocesso' ";
       $virgula = ",";
     }
     if(trim($this->si75_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_tipoprocesso"])){ 
        if(trim($this->si75_tipoprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si75_tipoprocesso"])){ 
           $this->si75_tipoprocesso = "0" ; 
        } 
       $sql  .= $virgula." si75_tipoprocesso = $this->si75_tipoprocesso ";
       $virgula = ",";
     }
     if(trim($this->si75_nrolote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_nrolote"])){ 
        if(trim($this->si75_nrolote)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si75_nrolote"])){ 
           $this->si75_nrolote = "0" ; 
        } 
       $sql  .= $virgula." si75_nrolote = $this->si75_nrolote ";
       $virgula = ",";
     }
     if(trim($this->si75_dsclote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_dsclote"])){ 
       $sql  .= $virgula." si75_dsclote = '$this->si75_dsclote' ";
       $virgula = ",";
     }
     if(trim($this->si75_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_mes"])){ 
       $sql  .= $virgula." si75_mes = $this->si75_mes ";
       $virgula = ",";
       if(trim($this->si75_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si75_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si75_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_reg10"])){ 
        if(trim($this->si75_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si75_reg10"])){ 
           $this->si75_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si75_reg10 = $this->si75_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si75_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si75_instit"])){ 
       $sql  .= $virgula." si75_instit = $this->si75_instit ";
       $virgula = ",";
       if(trim($this->si75_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si75_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si75_sequencial!=null){
       $sql .= " si75_sequencial = $this->si75_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si75_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010271,'$this->si75_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_sequencial"]) || $this->si75_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010271,'".AddSlashes(pg_result($resaco,$conresaco,'si75_sequencial'))."','$this->si75_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_tiporegistro"]) || $this->si75_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010272,'".AddSlashes(pg_result($resaco,$conresaco,'si75_tiporegistro'))."','$this->si75_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_codorgaoresp"]) || $this->si75_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010273,'".AddSlashes(pg_result($resaco,$conresaco,'si75_codorgaoresp'))."','$this->si75_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_codunidadesubresp"]) || $this->si75_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010274,'".AddSlashes(pg_result($resaco,$conresaco,'si75_codunidadesubresp'))."','$this->si75_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_exercicioprocesso"]) || $this->si75_exercicioprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010275,'".AddSlashes(pg_result($resaco,$conresaco,'si75_exercicioprocesso'))."','$this->si75_exercicioprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_nroprocesso"]) || $this->si75_nroprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010276,'".AddSlashes(pg_result($resaco,$conresaco,'si75_nroprocesso'))."','$this->si75_nroprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_tipoprocesso"]) || $this->si75_tipoprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010277,'".AddSlashes(pg_result($resaco,$conresaco,'si75_tipoprocesso'))."','$this->si75_tipoprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_nrolote"]) || $this->si75_nrolote != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010278,'".AddSlashes(pg_result($resaco,$conresaco,'si75_nrolote'))."','$this->si75_nrolote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_dsclote"]) || $this->si75_dsclote != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010279,'".AddSlashes(pg_result($resaco,$conresaco,'si75_dsclote'))."','$this->si75_dsclote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_mes"]) || $this->si75_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010280,'".AddSlashes(pg_result($resaco,$conresaco,'si75_mes'))."','$this->si75_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_reg10"]) || $this->si75_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2010281,'".AddSlashes(pg_result($resaco,$conresaco,'si75_reg10'))."','$this->si75_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si75_instit"]) || $this->si75_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010304,2011587,'".AddSlashes(pg_result($resaco,$conresaco,'si75_instit'))."','$this->si75_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dispensa112016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si75_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa112016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si75_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si75_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si75_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si75_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010271,'$si75_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010304,2010271,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010272,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010273,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010274,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010275,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010276,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010277,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010278,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010279,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_dsclote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010280,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2010281,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010304,2011587,'','".AddSlashes(pg_result($resaco,$iresaco,'si75_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dispensa112016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si75_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si75_sequencial = $si75_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dispensa112016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si75_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa112016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si75_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si75_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dispensa112016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si75_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa112016 ";
     $sql .= "      left  join dispensa102016  on  dispensa102016.si74_sequencial = dispensa112016.si75_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si75_sequencial!=null ){
         $sql2 .= " where dispensa112016.si75_sequencial = $si75_sequencial "; 
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
   function sql_query_file ( $si75_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa112016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si75_sequencial!=null ){
         $sql2 .= " where dispensa112016.si75_sequencial = $si75_sequencial "; 
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
