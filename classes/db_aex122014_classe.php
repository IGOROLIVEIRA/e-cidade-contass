<?
//MODULO: sicom
//CLASSE DA ENTIDADE aex122014
class cl_aex122014 { 
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
   var $si131_sequencial = 0; 
   var $si131_tiporegistro = 0; 
   var $si131_codreduzidoeo = 0; 
   var $si131_nroop = 0; 
   var $si131_dtpagamento_dia = null; 
   var $si131_dtpagamento_mes = null; 
   var $si131_dtpagamento_ano = null; 
   var $si131_dtpagamento = null; 
   var $si131_nroanulacaoop = 0; 
   var $si131_dtanulacaoop_dia = null; 
   var $si131_dtanulacaoop_mes = null; 
   var $si131_dtanulacaoop_ano = null; 
   var $si131_dtanulacaoop = null; 
   var $si131_vlanulacaoop = 0; 
   var $si131_mes = 0; 
   var $si131_reg10 = 0; 
   var $si131_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si131_sequencial = int8 = sequencial 
                 si131_tiporegistro = int8 = Tipo do  registro 
                 si131_codreduzidoeo = int8 = Código identificador da anulação 
                 si131_nroop = int8 = Número da  Ordem de  Pagamento 
                 si131_dtpagamento = date = Data de  pagamento da  OP 
                 si131_nroanulacaoop = int8 = Número da  anulação da OP 
                 si131_dtanulacaoop = date = Data da anulação  da OP 
                 si131_vlanulacaoop = float8 = Valor da  Anulação da OP 
                 si131_mes = int8 = Mês 
                 si131_reg10 = int8 = reg10 
                 si131_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aex122014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aex122014"); 
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
       $this->si131_sequencial = ($this->si131_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_sequencial"]:$this->si131_sequencial);
       $this->si131_tiporegistro = ($this->si131_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_tiporegistro"]:$this->si131_tiporegistro);
       $this->si131_codreduzidoeo = ($this->si131_codreduzidoeo == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_codreduzidoeo"]:$this->si131_codreduzidoeo);
       $this->si131_nroop = ($this->si131_nroop == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_nroop"]:$this->si131_nroop);
       if($this->si131_dtpagamento == ""){
         $this->si131_dtpagamento_dia = ($this->si131_dtpagamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_dtpagamento_dia"]:$this->si131_dtpagamento_dia);
         $this->si131_dtpagamento_mes = ($this->si131_dtpagamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_dtpagamento_mes"]:$this->si131_dtpagamento_mes);
         $this->si131_dtpagamento_ano = ($this->si131_dtpagamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_dtpagamento_ano"]:$this->si131_dtpagamento_ano);
         if($this->si131_dtpagamento_dia != ""){
            $this->si131_dtpagamento = $this->si131_dtpagamento_ano."-".$this->si131_dtpagamento_mes."-".$this->si131_dtpagamento_dia;
         }
       }
       $this->si131_nroanulacaoop = ($this->si131_nroanulacaoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_nroanulacaoop"]:$this->si131_nroanulacaoop);
       if($this->si131_dtanulacaoop == ""){
         $this->si131_dtanulacaoop_dia = ($this->si131_dtanulacaoop_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_dtanulacaoop_dia"]:$this->si131_dtanulacaoop_dia);
         $this->si131_dtanulacaoop_mes = ($this->si131_dtanulacaoop_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_dtanulacaoop_mes"]:$this->si131_dtanulacaoop_mes);
         $this->si131_dtanulacaoop_ano = ($this->si131_dtanulacaoop_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_dtanulacaoop_ano"]:$this->si131_dtanulacaoop_ano);
         if($this->si131_dtanulacaoop_dia != ""){
            $this->si131_dtanulacaoop = $this->si131_dtanulacaoop_ano."-".$this->si131_dtanulacaoop_mes."-".$this->si131_dtanulacaoop_dia;
         }
       }
       $this->si131_vlanulacaoop = ($this->si131_vlanulacaoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_vlanulacaoop"]:$this->si131_vlanulacaoop);
       $this->si131_mes = ($this->si131_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_mes"]:$this->si131_mes);
       $this->si131_reg10 = ($this->si131_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_reg10"]:$this->si131_reg10);
       $this->si131_instit = ($this->si131_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_instit"]:$this->si131_instit);
     }else{
       $this->si131_sequencial = ($this->si131_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si131_sequencial"]:$this->si131_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si131_sequencial){ 
      $this->atualizacampos();
     if($this->si131_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si131_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si131_codreduzidoeo == null ){ 
       $this->si131_codreduzidoeo = "0";
     }
     if($this->si131_nroop == null ){ 
       $this->si131_nroop = "0";
     }
     if($this->si131_dtpagamento == null ){ 
       $this->si131_dtpagamento = "null";
     }
     if($this->si131_nroanulacaoop == null ){ 
       $this->si131_nroanulacaoop = "0";
     }
     if($this->si131_dtanulacaoop == null ){ 
       $this->si131_dtanulacaoop = "null";
     }
     if($this->si131_vlanulacaoop == null ){ 
       $this->si131_vlanulacaoop = "0";
     }
     if($this->si131_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si131_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si131_reg10 == null ){ 
       $this->si131_reg10 = "0";
     }
     if($this->si131_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si131_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si131_sequencial == "" || $si131_sequencial == null ){
       $result = db_query("select nextval('aex122014_si131_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aex122014_si131_sequencial_seq do campo: si131_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si131_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aex122014_si131_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si131_sequencial)){
         $this->erro_sql = " Campo si131_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si131_sequencial = $si131_sequencial; 
       }
     }
     if(($this->si131_sequencial == null) || ($this->si131_sequencial == "") ){ 
       $this->erro_sql = " Campo si131_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aex122014(
                                       si131_sequencial 
                                      ,si131_tiporegistro 
                                      ,si131_codreduzidoeo 
                                      ,si131_nroop 
                                      ,si131_dtpagamento 
                                      ,si131_nroanulacaoop 
                                      ,si131_dtanulacaoop 
                                      ,si131_vlanulacaoop 
                                      ,si131_mes 
                                      ,si131_reg10 
                                      ,si131_instit 
                       )
                values (
                                $this->si131_sequencial 
                               ,$this->si131_tiporegistro 
                               ,$this->si131_codreduzidoeo 
                               ,$this->si131_nroop 
                               ,".($this->si131_dtpagamento == "null" || $this->si131_dtpagamento == ""?"null":"'".$this->si131_dtpagamento."'")." 
                               ,$this->si131_nroanulacaoop 
                               ,".($this->si131_dtanulacaoop == "null" || $this->si131_dtanulacaoop == ""?"null":"'".$this->si131_dtanulacaoop."'")." 
                               ,$this->si131_vlanulacaoop 
                               ,$this->si131_mes 
                               ,$this->si131_reg10 
                               ,$this->si131_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aex122014 ($this->si131_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aex122014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aex122014 ($this->si131_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si131_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si131_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010917,'$this->si131_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010360,2010917,'','".AddSlashes(pg_result($resaco,0,'si131_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010918,'','".AddSlashes(pg_result($resaco,0,'si131_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010919,'','".AddSlashes(pg_result($resaco,0,'si131_codreduzidoeo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010920,'','".AddSlashes(pg_result($resaco,0,'si131_nroop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010921,'','".AddSlashes(pg_result($resaco,0,'si131_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010922,'','".AddSlashes(pg_result($resaco,0,'si131_nroanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010923,'','".AddSlashes(pg_result($resaco,0,'si131_dtanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010924,'','".AddSlashes(pg_result($resaco,0,'si131_vlanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010925,'','".AddSlashes(pg_result($resaco,0,'si131_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2010926,'','".AddSlashes(pg_result($resaco,0,'si131_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010360,2011644,'','".AddSlashes(pg_result($resaco,0,'si131_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si131_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aex122014 set ";
     $virgula = "";
     if(trim($this->si131_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_sequencial"])){ 
        if(trim($this->si131_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si131_sequencial"])){ 
           $this->si131_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si131_sequencial = $this->si131_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si131_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_tiporegistro"])){ 
       $sql  .= $virgula." si131_tiporegistro = $this->si131_tiporegistro ";
       $virgula = ",";
       if(trim($this->si131_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si131_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si131_codreduzidoeo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_codreduzidoeo"])){ 
        if(trim($this->si131_codreduzidoeo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si131_codreduzidoeo"])){ 
           $this->si131_codreduzidoeo = "0" ; 
        } 
       $sql  .= $virgula." si131_codreduzidoeo = $this->si131_codreduzidoeo ";
       $virgula = ",";
     }
     if(trim($this->si131_nroop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_nroop"])){ 
        if(trim($this->si131_nroop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si131_nroop"])){ 
           $this->si131_nroop = "0" ; 
        } 
       $sql  .= $virgula." si131_nroop = $this->si131_nroop ";
       $virgula = ",";
     }
     if(trim($this->si131_dtpagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_dtpagamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si131_dtpagamento_dia"] !="") ){ 
       $sql  .= $virgula." si131_dtpagamento = '$this->si131_dtpagamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si131_dtpagamento_dia"])){ 
         $sql  .= $virgula." si131_dtpagamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si131_nroanulacaoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_nroanulacaoop"])){ 
        if(trim($this->si131_nroanulacaoop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si131_nroanulacaoop"])){ 
           $this->si131_nroanulacaoop = "0" ; 
        } 
       $sql  .= $virgula." si131_nroanulacaoop = $this->si131_nroanulacaoop ";
       $virgula = ",";
     }
     if(trim($this->si131_dtanulacaoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_dtanulacaoop_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si131_dtanulacaoop_dia"] !="") ){ 
       $sql  .= $virgula." si131_dtanulacaoop = '$this->si131_dtanulacaoop' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si131_dtanulacaoop_dia"])){ 
         $sql  .= $virgula." si131_dtanulacaoop = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si131_vlanulacaoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_vlanulacaoop"])){ 
        if(trim($this->si131_vlanulacaoop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si131_vlanulacaoop"])){ 
           $this->si131_vlanulacaoop = "0" ; 
        } 
       $sql  .= $virgula." si131_vlanulacaoop = $this->si131_vlanulacaoop ";
       $virgula = ",";
     }
     if(trim($this->si131_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_mes"])){ 
       $sql  .= $virgula." si131_mes = $this->si131_mes ";
       $virgula = ",";
       if(trim($this->si131_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si131_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si131_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_reg10"])){ 
        if(trim($this->si131_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si131_reg10"])){ 
           $this->si131_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si131_reg10 = $this->si131_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si131_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si131_instit"])){ 
       $sql  .= $virgula." si131_instit = $this->si131_instit ";
       $virgula = ",";
       if(trim($this->si131_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si131_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si131_sequencial!=null){
       $sql .= " si131_sequencial = $this->si131_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si131_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010917,'$this->si131_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_sequencial"]) || $this->si131_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010917,'".AddSlashes(pg_result($resaco,$conresaco,'si131_sequencial'))."','$this->si131_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_tiporegistro"]) || $this->si131_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010918,'".AddSlashes(pg_result($resaco,$conresaco,'si131_tiporegistro'))."','$this->si131_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_codreduzidoeo"]) || $this->si131_codreduzidoeo != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010919,'".AddSlashes(pg_result($resaco,$conresaco,'si131_codreduzidoeo'))."','$this->si131_codreduzidoeo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_nroop"]) || $this->si131_nroop != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010920,'".AddSlashes(pg_result($resaco,$conresaco,'si131_nroop'))."','$this->si131_nroop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_dtpagamento"]) || $this->si131_dtpagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010921,'".AddSlashes(pg_result($resaco,$conresaco,'si131_dtpagamento'))."','$this->si131_dtpagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_nroanulacaoop"]) || $this->si131_nroanulacaoop != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010922,'".AddSlashes(pg_result($resaco,$conresaco,'si131_nroanulacaoop'))."','$this->si131_nroanulacaoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_dtanulacaoop"]) || $this->si131_dtanulacaoop != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010923,'".AddSlashes(pg_result($resaco,$conresaco,'si131_dtanulacaoop'))."','$this->si131_dtanulacaoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_vlanulacaoop"]) || $this->si131_vlanulacaoop != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010924,'".AddSlashes(pg_result($resaco,$conresaco,'si131_vlanulacaoop'))."','$this->si131_vlanulacaoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_mes"]) || $this->si131_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010925,'".AddSlashes(pg_result($resaco,$conresaco,'si131_mes'))."','$this->si131_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_reg10"]) || $this->si131_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2010926,'".AddSlashes(pg_result($resaco,$conresaco,'si131_reg10'))."','$this->si131_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si131_instit"]) || $this->si131_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010360,2011644,'".AddSlashes(pg_result($resaco,$conresaco,'si131_instit'))."','$this->si131_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aex122014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si131_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aex122014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si131_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si131_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si131_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si131_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010917,'$si131_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010360,2010917,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010918,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010919,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_codreduzidoeo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010920,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_nroop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010921,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010922,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_nroanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010923,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_dtanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010924,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_vlanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010925,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2010926,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010360,2011644,'','".AddSlashes(pg_result($resaco,$iresaco,'si131_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aex122014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si131_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si131_sequencial = $si131_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aex122014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si131_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aex122014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si131_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si131_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aex122014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si131_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aex122014 ";
     $sql .= "      left  join aex102014  on  aex102014.si129_sequencial = aex122014.si131_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si131_sequencial!=null ){
         $sql2 .= " where aex122014.si131_sequencial = $si131_sequencial "; 
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
   function sql_query_file ( $si131_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aex122014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si131_sequencial!=null ){
         $sql2 .= " where aex122014.si131_sequencial = $si131_sequencial "; 
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
