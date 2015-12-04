<?
//MODULO: sicom
//CLASSE DA ENTIDADE ops142014
class cl_ops142014 { 
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
   var $si136_sequencial = 0; 
   var $si136_tiporegistro = 0; 
   var $si136_codreduzidoop = 0; 
   var $si136_tipovlantecipado = null; 
   var $si136_descricaovlantecipado = null; 
   var $si136_vlantecipado = 0; 
   var $si136_mes = 0; 
   var $si136_reg10 = 0; 
   var $si136_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si136_sequencial = int8 = sequencial 
                 si136_tiporegistro = int8 = Tipo do registro 
                 si136_codreduzidoop = int8 = Código  Identificador da  Ordem 
                 si136_tipovlantecipado = varchar(2) = Tipo de valor  extraorçamentário 
                 si136_descricaovlantecipado = varchar(50) = Descrição do  valor extraorçamentário 
                 si136_vlantecipado = float8 = Valor extraorçamentário antecipado 
                 si136_mes = int8 = Mês 
                 si136_reg10 = int8 = reg10 
                 si136_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ops142014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ops142014"); 
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
       $this->si136_sequencial = ($this->si136_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_sequencial"]:$this->si136_sequencial);
       $this->si136_tiporegistro = ($this->si136_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_tiporegistro"]:$this->si136_tiporegistro);
       $this->si136_codreduzidoop = ($this->si136_codreduzidoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_codreduzidoop"]:$this->si136_codreduzidoop);
       $this->si136_tipovlantecipado = ($this->si136_tipovlantecipado == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_tipovlantecipado"]:$this->si136_tipovlantecipado);
       $this->si136_descricaovlantecipado = ($this->si136_descricaovlantecipado == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_descricaovlantecipado"]:$this->si136_descricaovlantecipado);
       $this->si136_vlantecipado = ($this->si136_vlantecipado == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_vlantecipado"]:$this->si136_vlantecipado);
       $this->si136_mes = ($this->si136_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_mes"]:$this->si136_mes);
       $this->si136_reg10 = ($this->si136_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_reg10"]:$this->si136_reg10);
       $this->si136_instit = ($this->si136_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_instit"]:$this->si136_instit);
     }else{
       $this->si136_sequencial = ($this->si136_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si136_sequencial"]:$this->si136_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si136_sequencial){ 
      $this->atualizacampos();
     if($this->si136_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si136_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si136_codreduzidoop == null ){ 
       $this->si136_codreduzidoop = "0";
     }
     if($this->si136_vlantecipado == null ){ 
       $this->si136_vlantecipado = "0";
     }
     if($this->si136_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si136_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si136_reg10 == null ){ 
       $this->si136_reg10 = "0";
     }
     if($this->si136_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si136_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si136_sequencial == "" || $si136_sequencial == null ){
       $result = db_query("select nextval('ops142014_si136_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ops142014_si136_sequencial_seq do campo: si136_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si136_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ops142014_si136_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si136_sequencial)){
         $this->erro_sql = " Campo si136_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si136_sequencial = $si136_sequencial; 
       }
     }
     if(($this->si136_sequencial == null) || ($this->si136_sequencial == "") ){ 
       $this->erro_sql = " Campo si136_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ops142014(
                                       si136_sequencial 
                                      ,si136_tiporegistro 
                                      ,si136_codreduzidoop 
                                      ,si136_tipovlantecipado 
                                      ,si136_descricaovlantecipado 
                                      ,si136_vlantecipado 
                                      ,si136_mes 
                                      ,si136_reg10 
                                      ,si136_instit 
                       )
                values (
                                $this->si136_sequencial 
                               ,$this->si136_tiporegistro 
                               ,$this->si136_codreduzidoop 
                               ,'$this->si136_tipovlantecipado' 
                               ,'$this->si136_descricaovlantecipado' 
                               ,$this->si136_vlantecipado 
                               ,$this->si136_mes 
                               ,$this->si136_reg10 
                               ,$this->si136_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ops142014 ($this->si136_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ops142014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ops142014 ($this->si136_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si136_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si136_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010974,'$this->si136_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010365,2010974,'','".AddSlashes(pg_result($resaco,0,'si136_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2010975,'','".AddSlashes(pg_result($resaco,0,'si136_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2010976,'','".AddSlashes(pg_result($resaco,0,'si136_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2010977,'','".AddSlashes(pg_result($resaco,0,'si136_tipovlantecipado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2010978,'','".AddSlashes(pg_result($resaco,0,'si136_descricaovlantecipado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2010979,'','".AddSlashes(pg_result($resaco,0,'si136_vlantecipado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2010980,'','".AddSlashes(pg_result($resaco,0,'si136_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2010981,'','".AddSlashes(pg_result($resaco,0,'si136_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010365,2011649,'','".AddSlashes(pg_result($resaco,0,'si136_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si136_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ops142014 set ";
     $virgula = "";
     if(trim($this->si136_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_sequencial"])){ 
        if(trim($this->si136_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si136_sequencial"])){ 
           $this->si136_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si136_sequencial = $this->si136_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si136_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_tiporegistro"])){ 
       $sql  .= $virgula." si136_tiporegistro = $this->si136_tiporegistro ";
       $virgula = ",";
       if(trim($this->si136_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si136_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si136_codreduzidoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_codreduzidoop"])){ 
        if(trim($this->si136_codreduzidoop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si136_codreduzidoop"])){ 
           $this->si136_codreduzidoop = "0" ; 
        } 
       $sql  .= $virgula." si136_codreduzidoop = $this->si136_codreduzidoop ";
       $virgula = ",";
     }
     if(trim($this->si136_tipovlantecipado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_tipovlantecipado"])){ 
       $sql  .= $virgula." si136_tipovlantecipado = '$this->si136_tipovlantecipado' ";
       $virgula = ",";
     }
     if(trim($this->si136_descricaovlantecipado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_descricaovlantecipado"])){ 
       $sql  .= $virgula." si136_descricaovlantecipado = '$this->si136_descricaovlantecipado' ";
       $virgula = ",";
     }
     if(trim($this->si136_vlantecipado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_vlantecipado"])){ 
        if(trim($this->si136_vlantecipado)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si136_vlantecipado"])){ 
           $this->si136_vlantecipado = "0" ; 
        } 
       $sql  .= $virgula." si136_vlantecipado = $this->si136_vlantecipado ";
       $virgula = ",";
     }
     if(trim($this->si136_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_mes"])){ 
       $sql  .= $virgula." si136_mes = $this->si136_mes ";
       $virgula = ",";
       if(trim($this->si136_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si136_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si136_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_reg10"])){ 
        if(trim($this->si136_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si136_reg10"])){ 
           $this->si136_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si136_reg10 = $this->si136_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si136_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si136_instit"])){ 
       $sql  .= $virgula." si136_instit = $this->si136_instit ";
       $virgula = ",";
       if(trim($this->si136_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si136_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si136_sequencial!=null){
       $sql .= " si136_sequencial = $this->si136_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si136_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010974,'$this->si136_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_sequencial"]) || $this->si136_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010974,'".AddSlashes(pg_result($resaco,$conresaco,'si136_sequencial'))."','$this->si136_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_tiporegistro"]) || $this->si136_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010975,'".AddSlashes(pg_result($resaco,$conresaco,'si136_tiporegistro'))."','$this->si136_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_codreduzidoop"]) || $this->si136_codreduzidoop != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010976,'".AddSlashes(pg_result($resaco,$conresaco,'si136_codreduzidoop'))."','$this->si136_codreduzidoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_tipovlantecipado"]) || $this->si136_tipovlantecipado != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010977,'".AddSlashes(pg_result($resaco,$conresaco,'si136_tipovlantecipado'))."','$this->si136_tipovlantecipado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_descricaovlantecipado"]) || $this->si136_descricaovlantecipado != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010978,'".AddSlashes(pg_result($resaco,$conresaco,'si136_descricaovlantecipado'))."','$this->si136_descricaovlantecipado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_vlantecipado"]) || $this->si136_vlantecipado != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010979,'".AddSlashes(pg_result($resaco,$conresaco,'si136_vlantecipado'))."','$this->si136_vlantecipado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_mes"]) || $this->si136_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010980,'".AddSlashes(pg_result($resaco,$conresaco,'si136_mes'))."','$this->si136_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_reg10"]) || $this->si136_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2010981,'".AddSlashes(pg_result($resaco,$conresaco,'si136_reg10'))."','$this->si136_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si136_instit"]) || $this->si136_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010365,2011649,'".AddSlashes(pg_result($resaco,$conresaco,'si136_instit'))."','$this->si136_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ops142014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si136_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ops142014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si136_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si136_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si136_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si136_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010974,'$si136_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010365,2010974,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2010975,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2010976,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2010977,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_tipovlantecipado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2010978,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_descricaovlantecipado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2010979,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_vlantecipado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2010980,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2010981,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010365,2011649,'','".AddSlashes(pg_result($resaco,$iresaco,'si136_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ops142014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si136_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si136_sequencial = $si136_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ops142014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si136_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ops142014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si136_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si136_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ops142014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si136_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ops142014 ";
     $sql .= "      left  join ops102014  on  ops102014.si132_sequencial = ops142014.si136_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si136_sequencial!=null ){
         $sql2 .= " where ops142014.si136_sequencial = $si136_sequencial "; 
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
   function sql_query_file ( $si136_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ops142014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si136_sequencial!=null ){
         $sql2 .= " where ops142014.si136_sequencial = $si136_sequencial "; 
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
