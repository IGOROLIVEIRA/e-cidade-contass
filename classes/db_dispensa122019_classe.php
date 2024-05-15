<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa122019
class cl_dispensa122019 { 
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
   var $si76_sequencial = 0; 
   var $si76_tiporegistro = 0; 
   var $si76_codorgaoresp = null; 
   var $si76_codunidadesubresp = null; 
   var $si76_exercicioprocesso = 0; 
   var $si76_nroprocesso = null; 
   var $si76_tipoprocesso = 0; 
   var $si76_coditem = 0; 
   var $si76_nroitem = 0; 
   var $si76_mes = 0; 
   var $si76_reg10 = 0; 
   var $si76_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si76_sequencial = int8 = sequencial 
                 si76_tiporegistro = int8 = Tipo do  registro 
                 si76_codorgaoresp = varchar(2) = Código do órgão  responsável 
                 si76_codunidadesubresp = varchar(8) = Código da unidade 
                 si76_exercicioprocesso = int8 = Exercício em que  foi instaurado 
                 si76_nroprocesso = varchar(12) = Número sequencial  do processo 
                 si76_tipoprocesso = int8 = Tipo de processo 
                 si76_coditem = int8 = Código do Item 
                 si76_nroitem = int8 = Número do Item 
                 si76_mes = int8 = Mês 
                 si76_reg10 = int8 = reg10 
                 si76_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_dispensa122019() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dispensa122019"); 
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
       $this->si76_sequencial = ($this->si76_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_sequencial"]:$this->si76_sequencial);
       $this->si76_tiporegistro = ($this->si76_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_tiporegistro"]:$this->si76_tiporegistro);
       $this->si76_codorgaoresp = ($this->si76_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_codorgaoresp"]:$this->si76_codorgaoresp);
       $this->si76_codunidadesubresp = ($this->si76_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_codunidadesubresp"]:$this->si76_codunidadesubresp);
       $this->si76_exercicioprocesso = ($this->si76_exercicioprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_exercicioprocesso"]:$this->si76_exercicioprocesso);
       $this->si76_nroprocesso = ($this->si76_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_nroprocesso"]:$this->si76_nroprocesso);
       $this->si76_tipoprocesso = ($this->si76_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_tipoprocesso"]:$this->si76_tipoprocesso);
       $this->si76_coditem = ($this->si76_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_coditem"]:$this->si76_coditem);
       $this->si76_nroitem = ($this->si76_nroitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_nroitem"]:$this->si76_nroitem);
       $this->si76_mes = ($this->si76_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_mes"]:$this->si76_mes);
       $this->si76_reg10 = ($this->si76_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_reg10"]:$this->si76_reg10);
       $this->si76_instit = ($this->si76_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_instit"]:$this->si76_instit);
     }else{
       $this->si76_sequencial = ($this->si76_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si76_sequencial"]:$this->si76_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si76_sequencial){ 
      $this->atualizacampos();
     if($this->si76_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si76_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si76_exercicioprocesso == null ){ 
       $this->si76_exercicioprocesso = "0";
     }
     if($this->si76_tipoprocesso == null ){ 
       $this->si76_tipoprocesso = "0";
     }
     if($this->si76_coditem == null ){ 
       $this->si76_coditem = "0";
     }
     if($this->si76_nroitem == null ){ 
       $this->si76_nroitem = "0";
     }
     if($this->si76_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si76_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si76_reg10 == null ){ 
       $this->si76_reg10 = "0";
     }
     if($this->si76_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si76_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si76_sequencial == "" || $si76_sequencial == null ){
       $result = db_query("select nextval('dispensa122019_si76_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dispensa122019_si76_sequencial_seq do campo: si76_sequencial"; 
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si76_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dispensa122019_si76_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si76_sequencial)){
         $this->erro_sql = " Campo si76_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si76_sequencial = $si76_sequencial; 
       }
     }
     if(($this->si76_sequencial == null) || ($this->si76_sequencial == "") ){ 
       $this->erro_sql = " Campo si76_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dispensa122019(
                                       si76_sequencial 
                                      ,si76_tiporegistro 
                                      ,si76_codorgaoresp 
                                      ,si76_codunidadesubresp 
                                      ,si76_exercicioprocesso 
                                      ,si76_nroprocesso 
                                      ,si76_tipoprocesso 
                                      ,si76_coditem 
                                      ,si76_nroitem 
                                      ,si76_mes 
                                      ,si76_reg10 
                                      ,si76_instit 
                       )
                values (
                                $this->si76_sequencial 
                               ,$this->si76_tiporegistro 
                               ,'$this->si76_codorgaoresp' 
                               ,'$this->si76_codunidadesubresp' 
                               ,$this->si76_exercicioprocesso 
                               ,'$this->si76_nroprocesso' 
                               ,$this->si76_tipoprocesso 
                               ,$this->si76_coditem 
                               ,$this->si76_nroitem 
                               ,$this->si76_mes 
                               ,$this->si76_reg10 
                               ,$this->si76_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dispensa122019 ($this->si76_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dispensa122019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dispensa122019 ($this->si76_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si76_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si76_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010282,'$this->si76_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010305,2010282,'','".AddSlashes(pg_result($resaco,0,'si76_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010283,'','".AddSlashes(pg_result($resaco,0,'si76_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010284,'','".AddSlashes(pg_result($resaco,0,'si76_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010285,'','".AddSlashes(pg_result($resaco,0,'si76_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010286,'','".AddSlashes(pg_result($resaco,0,'si76_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010287,'','".AddSlashes(pg_result($resaco,0,'si76_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010288,'','".AddSlashes(pg_result($resaco,0,'si76_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010289,'','".AddSlashes(pg_result($resaco,0,'si76_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010290,'','".AddSlashes(pg_result($resaco,0,'si76_nroitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010291,'','".AddSlashes(pg_result($resaco,0,'si76_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2010292,'','".AddSlashes(pg_result($resaco,0,'si76_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010305,2011588,'','".AddSlashes(pg_result($resaco,0,'si76_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si76_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dispensa122019 set ";
     $virgula = "";
     if(trim($this->si76_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_sequencial"])){ 
        if(trim($this->si76_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si76_sequencial"])){ 
           $this->si76_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si76_sequencial = $this->si76_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si76_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_tiporegistro"])){ 
       $sql  .= $virgula." si76_tiporegistro = $this->si76_tiporegistro ";
       $virgula = ",";
       if(trim($this->si76_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si76_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si76_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_codorgaoresp"])){ 
       $sql  .= $virgula." si76_codorgaoresp = '$this->si76_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si76_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_codunidadesubresp"])){ 
       $sql  .= $virgula." si76_codunidadesubresp = '$this->si76_codunidadesubresp' ";
       $virgula = ",";
     }
     if(trim($this->si76_exercicioprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_exercicioprocesso"])){ 
        if(trim($this->si76_exercicioprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si76_exercicioprocesso"])){ 
           $this->si76_exercicioprocesso = "0" ; 
        } 
       $sql  .= $virgula." si76_exercicioprocesso = $this->si76_exercicioprocesso ";
       $virgula = ",";
     }
     if(trim($this->si76_nroprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_nroprocesso"])){ 
       $sql  .= $virgula." si76_nroprocesso = '$this->si76_nroprocesso' ";
       $virgula = ",";
     }
     if(trim($this->si76_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_tipoprocesso"])){ 
        if(trim($this->si76_tipoprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si76_tipoprocesso"])){ 
           $this->si76_tipoprocesso = "0" ; 
        } 
       $sql  .= $virgula." si76_tipoprocesso = $this->si76_tipoprocesso ";
       $virgula = ",";
     }
     if(trim($this->si76_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_coditem"])){ 
        if(trim($this->si76_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si76_coditem"])){ 
           $this->si76_coditem = "0" ; 
        } 
       $sql  .= $virgula." si76_coditem = $this->si76_coditem ";
       $virgula = ",";
     }
     if(trim($this->si76_nroitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_nroitem"])){ 
        if(trim($this->si76_nroitem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si76_nroitem"])){ 
           $this->si76_nroitem = "0" ; 
        } 
       $sql  .= $virgula." si76_nroitem = $this->si76_nroitem ";
       $virgula = ",";
     }
     if(trim($this->si76_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_mes"])){ 
       $sql  .= $virgula." si76_mes = $this->si76_mes ";
       $virgula = ",";
       if(trim($this->si76_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si76_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si76_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_reg10"])){ 
        if(trim($this->si76_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si76_reg10"])){ 
           $this->si76_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si76_reg10 = $this->si76_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si76_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si76_instit"])){ 
       $sql  .= $virgula." si76_instit = $this->si76_instit ";
       $virgula = ",";
       if(trim($this->si76_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si76_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si76_sequencial!=null){
       $sql .= " si76_sequencial = $this->si76_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si76_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010282,'$this->si76_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_sequencial"]) || $this->si76_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010282,'".AddSlashes(pg_result($resaco,$conresaco,'si76_sequencial'))."','$this->si76_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_tiporegistro"]) || $this->si76_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010283,'".AddSlashes(pg_result($resaco,$conresaco,'si76_tiporegistro'))."','$this->si76_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_codorgaoresp"]) || $this->si76_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010284,'".AddSlashes(pg_result($resaco,$conresaco,'si76_codorgaoresp'))."','$this->si76_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_codunidadesubresp"]) || $this->si76_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010285,'".AddSlashes(pg_result($resaco,$conresaco,'si76_codunidadesubresp'))."','$this->si76_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_exercicioprocesso"]) || $this->si76_exercicioprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010286,'".AddSlashes(pg_result($resaco,$conresaco,'si76_exercicioprocesso'))."','$this->si76_exercicioprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_nroprocesso"]) || $this->si76_nroprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010287,'".AddSlashes(pg_result($resaco,$conresaco,'si76_nroprocesso'))."','$this->si76_nroprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_tipoprocesso"]) || $this->si76_tipoprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010288,'".AddSlashes(pg_result($resaco,$conresaco,'si76_tipoprocesso'))."','$this->si76_tipoprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_coditem"]) || $this->si76_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010289,'".AddSlashes(pg_result($resaco,$conresaco,'si76_coditem'))."','$this->si76_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_nroitem"]) || $this->si76_nroitem != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010290,'".AddSlashes(pg_result($resaco,$conresaco,'si76_nroitem'))."','$this->si76_nroitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_mes"]) || $this->si76_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010291,'".AddSlashes(pg_result($resaco,$conresaco,'si76_mes'))."','$this->si76_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_reg10"]) || $this->si76_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2010292,'".AddSlashes(pg_result($resaco,$conresaco,'si76_reg10'))."','$this->si76_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si76_instit"]) || $this->si76_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010305,2011588,'".AddSlashes(pg_result($resaco,$conresaco,'si76_instit'))."','$this->si76_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dispensa122019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si76_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa122019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si76_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si76_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si76_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si76_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010282,'$si76_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010305,2010282,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010283,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010284,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010285,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010286,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010287,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010288,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010289,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010290,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_nroitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010291,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2010292,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010305,2011588,'','".AddSlashes(pg_result($resaco,$iresaco,'si76_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dispensa122019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si76_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si76_sequencial = $si76_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dispensa122019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si76_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa122019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si76_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si76_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dispensa122019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si76_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa122019 ";
     $sql .= "      left  join dispensa102019  on  dispensa102019.si74_sequencial = dispensa122019.si76_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si76_sequencial!=null ){
         $sql2 .= " where dispensa122019.si76_sequencial = $si76_sequencial "; 
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
   function sql_query_file ( $si76_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa122019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si76_sequencial!=null ){
         $sql2 .= " where dispensa122019.si76_sequencial = $si76_sequencial "; 
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
