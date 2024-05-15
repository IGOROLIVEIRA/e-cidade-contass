<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa142014
class cl_dispensa142014 { 
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
   var $si78_sequencial = 0; 
   var $si78_tiporegistro = 0; 
   var $si78_codorgaoresp = null; 
   var $si78_codunidadesubres = null; 
   var $si78_exercicioprocesso = 0; 
   var $si78_nroprocesso = null; 
   var $si78_tipoprocesso = 0; 
   var $si78_tiporesp = 0; 
   var $si78_nrocpfresp = null; 
   var $si78_mes = 0; 
   var $si78_reg10 = 0; 
   var $si78_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si78_sequencial = int8 = sequencial 
                 si78_tiporegistro = int8 = Tipo do  registro 
                 si78_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si78_codunidadesubres = varchar(8) = Código da unidade 
                 si78_exercicioprocesso = int8 = Exercício em que   foi instaurado 
                 si78_nroprocesso = varchar(12) = Número sequencial  do processo 
                 si78_tipoprocesso = int8 = Tipo de processo 
                 si78_tiporesp = int8 = Tipo de  responsabilidade 
                 si78_nrocpfresp = varchar(11) = Número do CPF 
                 si78_mes = int8 = Mês 
                 si78_reg10 = int8 = reg10 
                 si78_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_dispensa142014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dispensa142014"); 
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
       $this->si78_sequencial = ($this->si78_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_sequencial"]:$this->si78_sequencial);
       $this->si78_tiporegistro = ($this->si78_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_tiporegistro"]:$this->si78_tiporegistro);
       $this->si78_codorgaoresp = ($this->si78_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_codorgaoresp"]:$this->si78_codorgaoresp);
       $this->si78_codunidadesubres = ($this->si78_codunidadesubres == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_codunidadesubres"]:$this->si78_codunidadesubres);
       $this->si78_exercicioprocesso = ($this->si78_exercicioprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_exercicioprocesso"]:$this->si78_exercicioprocesso);
       $this->si78_nroprocesso = ($this->si78_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_nroprocesso"]:$this->si78_nroprocesso);
       $this->si78_tipoprocesso = ($this->si78_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_tipoprocesso"]:$this->si78_tipoprocesso);
       $this->si78_tiporesp = ($this->si78_tiporesp == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_tiporesp"]:$this->si78_tiporesp);
       $this->si78_nrocpfresp = ($this->si78_nrocpfresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_nrocpfresp"]:$this->si78_nrocpfresp);
       $this->si78_mes = ($this->si78_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_mes"]:$this->si78_mes);
       $this->si78_reg10 = ($this->si78_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_reg10"]:$this->si78_reg10);
       $this->si78_instit = ($this->si78_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_instit"]:$this->si78_instit);
     }else{
       $this->si78_sequencial = ($this->si78_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si78_sequencial"]:$this->si78_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si78_sequencial){ 
      $this->atualizacampos();
     if($this->si78_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si78_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si78_exercicioprocesso == null ){ 
       $this->si78_exercicioprocesso = "0";
     }
     if($this->si78_tipoprocesso == null ){ 
       $this->si78_tipoprocesso = "0";
     }
     if($this->si78_tiporesp == null ){ 
       $this->si78_tiporesp = "0";
     }
     if($this->si78_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si78_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si78_reg10 == null ){ 
       $this->si78_reg10 = "0";
     }
     if($this->si78_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si78_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si78_sequencial == "" || $si78_sequencial == null ){
       $result = db_query("select nextval('dispensa142014_si78_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dispensa142014_si78_sequencial_seq do campo: si78_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si78_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dispensa142014_si78_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si78_sequencial)){
         $this->erro_sql = " Campo si78_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si78_sequencial = $si78_sequencial; 
       }
     }
     if(($this->si78_sequencial == null) || ($this->si78_sequencial == "") ){ 
       $this->erro_sql = " Campo si78_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dispensa142014(
                                       si78_sequencial 
                                      ,si78_tiporegistro 
                                      ,si78_codorgaoresp 
                                      ,si78_codunidadesubres 
                                      ,si78_exercicioprocesso 
                                      ,si78_nroprocesso 
                                      ,si78_tipoprocesso 
                                      ,si78_tiporesp 
                                      ,si78_nrocpfresp 
                                      ,si78_mes 
                                      ,si78_reg10 
                                      ,si78_instit 
                       )
                values (
                                $this->si78_sequencial 
                               ,$this->si78_tiporegistro 
                               ,'$this->si78_codorgaoresp' 
                               ,'$this->si78_codunidadesubres' 
                               ,$this->si78_exercicioprocesso 
                               ,'$this->si78_nroprocesso' 
                               ,$this->si78_tipoprocesso 
                               ,$this->si78_tiporesp 
                               ,'$this->si78_nrocpfresp' 
                               ,$this->si78_mes 
                               ,$this->si78_reg10 
                               ,$this->si78_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dispensa142014 ($this->si78_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dispensa142014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dispensa142014 ($this->si78_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si78_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si78_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010304,'$this->si78_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010307,2010304,'','".AddSlashes(pg_result($resaco,0,'si78_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010305,'','".AddSlashes(pg_result($resaco,0,'si78_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010306,'','".AddSlashes(pg_result($resaco,0,'si78_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010307,'','".AddSlashes(pg_result($resaco,0,'si78_codunidadesubres'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010308,'','".AddSlashes(pg_result($resaco,0,'si78_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010309,'','".AddSlashes(pg_result($resaco,0,'si78_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010310,'','".AddSlashes(pg_result($resaco,0,'si78_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010311,'','".AddSlashes(pg_result($resaco,0,'si78_tiporesp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010312,'','".AddSlashes(pg_result($resaco,0,'si78_nrocpfresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010313,'','".AddSlashes(pg_result($resaco,0,'si78_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2010314,'','".AddSlashes(pg_result($resaco,0,'si78_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010307,2011591,'','".AddSlashes(pg_result($resaco,0,'si78_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si78_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dispensa142014 set ";
     $virgula = "";
     if(trim($this->si78_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_sequencial"])){ 
        if(trim($this->si78_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si78_sequencial"])){ 
           $this->si78_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si78_sequencial = $this->si78_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si78_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_tiporegistro"])){ 
       $sql  .= $virgula." si78_tiporegistro = $this->si78_tiporegistro ";
       $virgula = ",";
       if(trim($this->si78_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si78_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si78_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_codorgaoresp"])){ 
       $sql  .= $virgula." si78_codorgaoresp = '$this->si78_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si78_codunidadesubres)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_codunidadesubres"])){ 
       $sql  .= $virgula." si78_codunidadesubres = '$this->si78_codunidadesubres' ";
       $virgula = ",";
     }
     if(trim($this->si78_exercicioprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_exercicioprocesso"])){ 
        if(trim($this->si78_exercicioprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si78_exercicioprocesso"])){ 
           $this->si78_exercicioprocesso = "0" ; 
        } 
       $sql  .= $virgula." si78_exercicioprocesso = $this->si78_exercicioprocesso ";
       $virgula = ",";
     }
     if(trim($this->si78_nroprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_nroprocesso"])){ 
       $sql  .= $virgula." si78_nroprocesso = '$this->si78_nroprocesso' ";
       $virgula = ",";
     }
     if(trim($this->si78_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_tipoprocesso"])){ 
        if(trim($this->si78_tipoprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si78_tipoprocesso"])){ 
           $this->si78_tipoprocesso = "0" ; 
        } 
       $sql  .= $virgula." si78_tipoprocesso = $this->si78_tipoprocesso ";
       $virgula = ",";
     }
     if(trim($this->si78_tiporesp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_tiporesp"])){ 
        if(trim($this->si78_tiporesp)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si78_tiporesp"])){ 
           $this->si78_tiporesp = "0" ; 
        } 
       $sql  .= $virgula." si78_tiporesp = $this->si78_tiporesp ";
       $virgula = ",";
     }
     if(trim($this->si78_nrocpfresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_nrocpfresp"])){ 
       $sql  .= $virgula." si78_nrocpfresp = '$this->si78_nrocpfresp' ";
       $virgula = ",";
     }
     if(trim($this->si78_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_mes"])){ 
       $sql  .= $virgula." si78_mes = $this->si78_mes ";
       $virgula = ",";
       if(trim($this->si78_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si78_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si78_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_reg10"])){ 
        if(trim($this->si78_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si78_reg10"])){ 
           $this->si78_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si78_reg10 = $this->si78_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si78_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si78_instit"])){ 
       $sql  .= $virgula." si78_instit = $this->si78_instit ";
       $virgula = ",";
       if(trim($this->si78_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si78_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si78_sequencial!=null){
       $sql .= " si78_sequencial = $this->si78_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si78_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010304,'$this->si78_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_sequencial"]) || $this->si78_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010304,'".AddSlashes(pg_result($resaco,$conresaco,'si78_sequencial'))."','$this->si78_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_tiporegistro"]) || $this->si78_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010305,'".AddSlashes(pg_result($resaco,$conresaco,'si78_tiporegistro'))."','$this->si78_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_codorgaoresp"]) || $this->si78_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010306,'".AddSlashes(pg_result($resaco,$conresaco,'si78_codorgaoresp'))."','$this->si78_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_codunidadesubres"]) || $this->si78_codunidadesubres != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010307,'".AddSlashes(pg_result($resaco,$conresaco,'si78_codunidadesubres'))."','$this->si78_codunidadesubres',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_exercicioprocesso"]) || $this->si78_exercicioprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010308,'".AddSlashes(pg_result($resaco,$conresaco,'si78_exercicioprocesso'))."','$this->si78_exercicioprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_nroprocesso"]) || $this->si78_nroprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010309,'".AddSlashes(pg_result($resaco,$conresaco,'si78_nroprocesso'))."','$this->si78_nroprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_tipoprocesso"]) || $this->si78_tipoprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010310,'".AddSlashes(pg_result($resaco,$conresaco,'si78_tipoprocesso'))."','$this->si78_tipoprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_tiporesp"]) || $this->si78_tiporesp != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010311,'".AddSlashes(pg_result($resaco,$conresaco,'si78_tiporesp'))."','$this->si78_tiporesp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_nrocpfresp"]) || $this->si78_nrocpfresp != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010312,'".AddSlashes(pg_result($resaco,$conresaco,'si78_nrocpfresp'))."','$this->si78_nrocpfresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_mes"]) || $this->si78_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010313,'".AddSlashes(pg_result($resaco,$conresaco,'si78_mes'))."','$this->si78_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_reg10"]) || $this->si78_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2010314,'".AddSlashes(pg_result($resaco,$conresaco,'si78_reg10'))."','$this->si78_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si78_instit"]) || $this->si78_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010307,2011591,'".AddSlashes(pg_result($resaco,$conresaco,'si78_instit'))."','$this->si78_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dispensa142014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si78_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa142014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si78_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si78_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si78_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si78_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010304,'$si78_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010307,2010304,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010305,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010306,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010307,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_codunidadesubres'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010308,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010309,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010310,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010311,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_tiporesp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010312,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_nrocpfresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010313,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2010314,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010307,2011591,'','".AddSlashes(pg_result($resaco,$iresaco,'si78_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dispensa142014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si78_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si78_sequencial = $si78_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dispensa142014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si78_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa142014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si78_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si78_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dispensa142014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si78_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa142014 ";
     $sql .= "      left  join dispensa102014  on  dispensa102014.si74_sequencial = dispensa142014.si78_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si78_sequencial!=null ){
         $sql2 .= " where dispensa142014.si78_sequencial = $si78_sequencial "; 
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
   function sql_query_file ( $si78_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa142014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si78_sequencial!=null ){
         $sql2 .= " where dispensa142014.si78_sequencial = $si78_sequencial "; 
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
