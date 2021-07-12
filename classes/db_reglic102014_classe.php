<?
//MODULO: sicom
//CLASSE DA ENTIDADE reglic102014
class cl_reglic102014 { 
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
   var $si44_sequencial = 0; 
   var $si44_tiporegistro = 0; 
   var $si44_codorgao = null; 
   var $si44_tipodecreto = 0; 
   var $si44_nrodecretomunicipal = 0; 
   var $si44_datadecretomunicipal_dia = null; 
   var $si44_datadecretomunicipal_mes = null; 
   var $si44_datadecretomunicipal_ano = null; 
   var $si44_datadecretomunicipal = null; 
   var $si44_datapublicacaodecretomunicipal_dia = null; 
   var $si44_datapublicacaodecretomunicipal_mes = null; 
   var $si44_datapublicacaodecretomunicipal_ano = null; 
   var $si44_datapublicacaodecretomunicipal = null; 
   var $si44_mes = 0; 
   var $si44_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si44_sequencial = int8 = sequencial 
                 si44_tiporegistro = int8 = Tipo do registro 
                 si44_codorgao = varchar(2) = Código do órgão 
                 si44_tipodecreto = int8 = Tipo de decreto 
                 si44_nrodecretomunicipal = int8 = Número do Decreto 
                 si44_datadecretomunicipal = date = Data do Decreto 
                 si44_datapublicacaodecretomunicipal = date = Data da Publicação 
                 si44_mes = int8 = Mês 
                 si44_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_reglic102014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("reglic102014"); 
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
       $this->si44_sequencial = ($this->si44_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_sequencial"]:$this->si44_sequencial);
       $this->si44_tiporegistro = ($this->si44_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_tiporegistro"]:$this->si44_tiporegistro);
       $this->si44_codorgao = ($this->si44_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_codorgao"]:$this->si44_codorgao);
       $this->si44_tipodecreto = ($this->si44_tipodecreto == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_tipodecreto"]:$this->si44_tipodecreto);
       $this->si44_nrodecretomunicipal = ($this->si44_nrodecretomunicipal == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_nrodecretomunicipal"]:$this->si44_nrodecretomunicipal);
       if($this->si44_datadecretomunicipal == ""){
         $this->si44_datadecretomunicipal_dia = ($this->si44_datadecretomunicipal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_datadecretomunicipal_dia"]:$this->si44_datadecretomunicipal_dia);
         $this->si44_datadecretomunicipal_mes = ($this->si44_datadecretomunicipal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_datadecretomunicipal_mes"]:$this->si44_datadecretomunicipal_mes);
         $this->si44_datadecretomunicipal_ano = ($this->si44_datadecretomunicipal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_datadecretomunicipal_ano"]:$this->si44_datadecretomunicipal_ano);
         if($this->si44_datadecretomunicipal_dia != ""){
            $this->si44_datadecretomunicipal = $this->si44_datadecretomunicipal_ano."-".$this->si44_datadecretomunicipal_mes."-".$this->si44_datadecretomunicipal_dia;
         }
       }
       if($this->si44_datapublicacaodecretomunicipal == ""){
         $this->si44_datapublicacaodecretomunicipal_dia = ($this->si44_datapublicacaodecretomunicipal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_datapublicacaodecretomunicipal_dia"]:$this->si44_datapublicacaodecretomunicipal_dia);
         $this->si44_datapublicacaodecretomunicipal_mes = ($this->si44_datapublicacaodecretomunicipal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_datapublicacaodecretomunicipal_mes"]:$this->si44_datapublicacaodecretomunicipal_mes);
         $this->si44_datapublicacaodecretomunicipal_ano = ($this->si44_datapublicacaodecretomunicipal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_datapublicacaodecretomunicipal_ano"]:$this->si44_datapublicacaodecretomunicipal_ano);
         if($this->si44_datapublicacaodecretomunicipal_dia != ""){
            $this->si44_datapublicacaodecretomunicipal = $this->si44_datapublicacaodecretomunicipal_ano."-".$this->si44_datapublicacaodecretomunicipal_mes."-".$this->si44_datapublicacaodecretomunicipal_dia;
         }
       }
       $this->si44_mes = ($this->si44_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_mes"]:$this->si44_mes);
       $this->si44_instit = ($this->si44_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_instit"]:$this->si44_instit);
     }else{
       $this->si44_sequencial = ($this->si44_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si44_sequencial"]:$this->si44_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si44_sequencial){ 
      $this->atualizacampos();
     if($this->si44_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si44_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si44_tipodecreto == null ){ 
       $this->si44_tipodecreto = "0";
     }
     if($this->si44_nrodecretomunicipal == null ){ 
       $this->si44_nrodecretomunicipal = "0";
     }
     if($this->si44_datadecretomunicipal == null ){ 
       $this->si44_datadecretomunicipal = "null";
     }
     if($this->si44_datapublicacaodecretomunicipal == null ){ 
       $this->si44_datapublicacaodecretomunicipal = "null";
     }
     if($this->si44_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si44_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si44_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si44_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si44_sequencial == "" || $si44_sequencial == null ){
       $result = db_query("select nextval('reglic102014_si44_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: reglic102014_si44_sequencial_seq do campo: si44_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si44_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from reglic102014_si44_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si44_sequencial)){
         $this->erro_sql = " Campo si44_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si44_sequencial = $si44_sequencial; 
       }
     }
     if(($this->si44_sequencial == null) || ($this->si44_sequencial == "") ){ 
       $this->erro_sql = " Campo si44_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into reglic102014(
                                       si44_sequencial 
                                      ,si44_tiporegistro 
                                      ,si44_codorgao 
                                      ,si44_tipodecreto 
                                      ,si44_nrodecretomunicipal 
                                      ,si44_datadecretomunicipal 
                                      ,si44_datapublicacaodecretomunicipal 
                                      ,si44_mes 
                                      ,si44_instit 
                       )
                values (
                                $this->si44_sequencial 
                               ,$this->si44_tiporegistro 
                               ,'$this->si44_codorgao' 
                               ,$this->si44_tipodecreto 
                               ,$this->si44_nrodecretomunicipal 
                               ,".($this->si44_datadecretomunicipal == "null" || $this->si44_datadecretomunicipal == ""?"null":"'".$this->si44_datadecretomunicipal."'")." 
                               ,".($this->si44_datapublicacaodecretomunicipal == "null" || $this->si44_datapublicacaodecretomunicipal == ""?"null":"'".$this->si44_datapublicacaodecretomunicipal."'")." 
                               ,$this->si44_mes 
                               ,$this->si44_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "reglic102014 ($this->si44_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "reglic102014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "reglic102014 ($this->si44_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si44_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si44_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009832,'$this->si44_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010273,2009832,'','".AddSlashes(pg_result($resaco,0,'si44_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2009833,'','".AddSlashes(pg_result($resaco,0,'si44_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2009834,'','".AddSlashes(pg_result($resaco,0,'si44_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2009835,'','".AddSlashes(pg_result($resaco,0,'si44_tipodecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2009836,'','".AddSlashes(pg_result($resaco,0,'si44_nrodecretomunicipal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2009837,'','".AddSlashes(pg_result($resaco,0,'si44_datadecretomunicipal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2009838,'','".AddSlashes(pg_result($resaco,0,'si44_datapublicacaodecretomunicipal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2009839,'','".AddSlashes(pg_result($resaco,0,'si44_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010273,2011558,'','".AddSlashes(pg_result($resaco,0,'si44_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si44_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update reglic102014 set ";
     $virgula = "";
     if(trim($this->si44_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_sequencial"])){ 
        if(trim($this->si44_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si44_sequencial"])){ 
           $this->si44_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si44_sequencial = $this->si44_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si44_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_tiporegistro"])){ 
       $sql  .= $virgula." si44_tiporegistro = $this->si44_tiporegistro ";
       $virgula = ",";
       if(trim($this->si44_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si44_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si44_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_codorgao"])){ 
       $sql  .= $virgula." si44_codorgao = '$this->si44_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si44_tipodecreto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_tipodecreto"])){ 
        if(trim($this->si44_tipodecreto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si44_tipodecreto"])){ 
           $this->si44_tipodecreto = "0" ; 
        } 
       $sql  .= $virgula." si44_tipodecreto = $this->si44_tipodecreto ";
       $virgula = ",";
     }
     if(trim($this->si44_nrodecretomunicipal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_nrodecretomunicipal"])){ 
        if(trim($this->si44_nrodecretomunicipal)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si44_nrodecretomunicipal"])){ 
           $this->si44_nrodecretomunicipal = "0" ; 
        } 
       $sql  .= $virgula." si44_nrodecretomunicipal = $this->si44_nrodecretomunicipal ";
       $virgula = ",";
     }
     if(trim($this->si44_datadecretomunicipal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_datadecretomunicipal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si44_datadecretomunicipal_dia"] !="") ){ 
       $sql  .= $virgula." si44_datadecretomunicipal = '$this->si44_datadecretomunicipal' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si44_datadecretomunicipal_dia"])){ 
         $sql  .= $virgula." si44_datadecretomunicipal = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si44_datapublicacaodecretomunicipal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_datapublicacaodecretomunicipal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si44_datapublicacaodecretomunicipal_dia"] !="") ){ 
       $sql  .= $virgula." si44_datapublicacaodecretomunicipal = '$this->si44_datapublicacaodecretomunicipal' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si44_datapublicacaodecretomunicipal_dia"])){ 
         $sql  .= $virgula." si44_datapublicacaodecretomunicipal = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si44_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_mes"])){ 
       $sql  .= $virgula." si44_mes = $this->si44_mes ";
       $virgula = ",";
       if(trim($this->si44_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si44_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si44_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si44_instit"])){ 
       $sql  .= $virgula." si44_instit = $this->si44_instit ";
       $virgula = ",";
       if(trim($this->si44_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si44_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si44_sequencial!=null){
       $sql .= " si44_sequencial = $this->si44_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si44_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009832,'$this->si44_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_sequencial"]) || $this->si44_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009832,'".AddSlashes(pg_result($resaco,$conresaco,'si44_sequencial'))."','$this->si44_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_tiporegistro"]) || $this->si44_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009833,'".AddSlashes(pg_result($resaco,$conresaco,'si44_tiporegistro'))."','$this->si44_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_codorgao"]) || $this->si44_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009834,'".AddSlashes(pg_result($resaco,$conresaco,'si44_codorgao'))."','$this->si44_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_tipodecreto"]) || $this->si44_tipodecreto != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009835,'".AddSlashes(pg_result($resaco,$conresaco,'si44_tipodecreto'))."','$this->si44_tipodecreto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_nrodecretomunicipal"]) || $this->si44_nrodecretomunicipal != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009836,'".AddSlashes(pg_result($resaco,$conresaco,'si44_nrodecretomunicipal'))."','$this->si44_nrodecretomunicipal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_datadecretomunicipal"]) || $this->si44_datadecretomunicipal != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009837,'".AddSlashes(pg_result($resaco,$conresaco,'si44_datadecretomunicipal'))."','$this->si44_datadecretomunicipal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_datapublicacaodecretomunicipal"]) || $this->si44_datapublicacaodecretomunicipal != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009838,'".AddSlashes(pg_result($resaco,$conresaco,'si44_datapublicacaodecretomunicipal'))."','$this->si44_datapublicacaodecretomunicipal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_mes"]) || $this->si44_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2009839,'".AddSlashes(pg_result($resaco,$conresaco,'si44_mes'))."','$this->si44_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si44_instit"]) || $this->si44_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010273,2011558,'".AddSlashes(pg_result($resaco,$conresaco,'si44_instit'))."','$this->si44_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "reglic102014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si44_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "reglic102014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si44_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si44_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si44_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si44_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009832,'$si44_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010273,2009832,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2009833,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2009834,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2009835,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_tipodecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2009836,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_nrodecretomunicipal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2009837,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_datadecretomunicipal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2009838,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_datapublicacaodecretomunicipal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2009839,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010273,2011558,'','".AddSlashes(pg_result($resaco,$iresaco,'si44_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from reglic102014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si44_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si44_sequencial = $si44_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "reglic102014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si44_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "reglic102014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si44_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si44_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:reglic102014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si44_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from reglic102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si44_sequencial!=null ){
         $sql2 .= " where reglic102014.si44_sequencial = $si44_sequencial "; 
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
   function sql_query_file ( $si44_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from reglic102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si44_sequencial!=null ){
         $sql2 .= " where reglic102014.si44_sequencial = $si44_sequencial "; 
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
