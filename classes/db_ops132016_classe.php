<?
//MODULO: sicom
//CLASSE DA ENTIDADE ops132016
class cl_ops132016 { 
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
   var $si135_sequencial = 0; 
   var $si135_tiporegistro = 0; 
   var $si135_codreduzidoop = 0; 
   var $si135_tiporetencao = null; 
   var $si135_descricaoretencao = null; 
   var $si135_vlretencao = 0; 
   var $si135_mes = 0; 
   var $si135_reg10 = 0; 
   var $si135_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si135_sequencial = int8 = sequencial 
                 si135_tiporegistro = int8 = Tipo do registro 
                 si135_codreduzidoop = int8 = Código Identificador da Ordem 
                 si135_tiporetencao = varchar(4) = Tipo de Retenção 
                 si135_descricaoretencao = varchar(50) = Descrição da  Retenção 
                 si135_vlretencao = float8 = Valor da retenção 
                 si135_mes = int8 = Mês 
                 si135_reg10 = int8 = reg10 
                 si135_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ops132016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ops132016"); 
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
       $this->si135_sequencial = ($this->si135_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_sequencial"]:$this->si135_sequencial);
       $this->si135_tiporegistro = ($this->si135_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_tiporegistro"]:$this->si135_tiporegistro);
       $this->si135_codreduzidoop = ($this->si135_codreduzidoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_codreduzidoop"]:$this->si135_codreduzidoop);
       $this->si135_tiporetencao = ($this->si135_tiporetencao == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_tiporetencao"]:$this->si135_tiporetencao);
       $this->si135_descricaoretencao = ($this->si135_descricaoretencao == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_descricaoretencao"]:$this->si135_descricaoretencao);
       $this->si135_vlretencao = ($this->si135_vlretencao == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_vlretencao"]:$this->si135_vlretencao);
       $this->si135_mes = ($this->si135_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_mes"]:$this->si135_mes);
       $this->si135_reg10 = ($this->si135_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_reg10"]:$this->si135_reg10);
       $this->si135_instit = ($this->si135_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_instit"]:$this->si135_instit);
     }else{
       $this->si135_sequencial = ($this->si135_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si135_sequencial"]:$this->si135_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si135_sequencial){ 
      $this->atualizacampos();
     if($this->si135_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si135_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si135_codreduzidoop == null ){ 
       $this->si135_codreduzidoop = "0";
     }
     if($this->si135_vlretencao == null ){ 
       $this->si135_vlretencao = "0";
     }
     if($this->si135_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si135_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si135_reg10 == null ){ 
       $this->si135_reg10 = "0";
     }
     if($this->si135_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si135_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si135_sequencial == "" || $si135_sequencial == null ){
       $result = db_query("select nextval('ops132016_si135_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ops132016_si135_sequencial_seq do campo: si135_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si135_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ops132016_si135_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si135_sequencial)){
         $this->erro_sql = " Campo si135_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si135_sequencial = $si135_sequencial; 
       }
     }
     if(($this->si135_sequencial == null) || ($this->si135_sequencial == "") ){ 
       $this->erro_sql = " Campo si135_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ops132016(
                                       si135_sequencial 
                                      ,si135_tiporegistro 
                                      ,si135_codreduzidoop 
                                      ,si135_tiporetencao 
                                      ,si135_descricaoretencao 
                                      ,si135_vlretencao 
                                      ,si135_mes 
                                      ,si135_reg10 
                                      ,si135_instit 
                       )
                values (
                                $this->si135_sequencial 
                               ,$this->si135_tiporegistro 
                               ,$this->si135_codreduzidoop 
                               ,'$this->si135_tiporetencao' 
                               ,'$this->si135_descricaoretencao' 
                               ,$this->si135_vlretencao 
                               ,$this->si135_mes 
                               ,$this->si135_reg10 
                               ,$this->si135_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ops132016 ($this->si135_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ops132016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ops132016 ($this->si135_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si135_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si135_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010966,'$this->si135_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010364,2010966,'','".AddSlashes(pg_result($resaco,0,'si135_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2010967,'','".AddSlashes(pg_result($resaco,0,'si135_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2010968,'','".AddSlashes(pg_result($resaco,0,'si135_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2010969,'','".AddSlashes(pg_result($resaco,0,'si135_tiporetencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2010970,'','".AddSlashes(pg_result($resaco,0,'si135_descricaoretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2010971,'','".AddSlashes(pg_result($resaco,0,'si135_vlretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2010972,'','".AddSlashes(pg_result($resaco,0,'si135_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2010973,'','".AddSlashes(pg_result($resaco,0,'si135_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010364,2011648,'','".AddSlashes(pg_result($resaco,0,'si135_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si135_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ops132016 set ";
     $virgula = "";
     if(trim($this->si135_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_sequencial"])){ 
        if(trim($this->si135_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si135_sequencial"])){ 
           $this->si135_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si135_sequencial = $this->si135_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si135_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_tiporegistro"])){ 
       $sql  .= $virgula." si135_tiporegistro = $this->si135_tiporegistro ";
       $virgula = ",";
       if(trim($this->si135_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si135_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si135_codreduzidoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_codreduzidoop"])){ 
        if(trim($this->si135_codreduzidoop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si135_codreduzidoop"])){ 
           $this->si135_codreduzidoop = "0" ; 
        } 
       $sql  .= $virgula." si135_codreduzidoop = $this->si135_codreduzidoop ";
       $virgula = ",";
     }
     if(trim($this->si135_tiporetencao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_tiporetencao"])){ 
       $sql  .= $virgula." si135_tiporetencao = '$this->si135_tiporetencao' ";
       $virgula = ",";
     }
     if(trim($this->si135_descricaoretencao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_descricaoretencao"])){ 
       $sql  .= $virgula." si135_descricaoretencao = '$this->si135_descricaoretencao' ";
       $virgula = ",";
     }
     if(trim($this->si135_vlretencao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_vlretencao"])){ 
        if(trim($this->si135_vlretencao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si135_vlretencao"])){ 
           $this->si135_vlretencao = "0" ; 
        } 
       $sql  .= $virgula." si135_vlretencao = $this->si135_vlretencao ";
       $virgula = ",";
     }
     if(trim($this->si135_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_mes"])){ 
       $sql  .= $virgula." si135_mes = $this->si135_mes ";
       $virgula = ",";
       if(trim($this->si135_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si135_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si135_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_reg10"])){ 
        if(trim($this->si135_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si135_reg10"])){ 
           $this->si135_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si135_reg10 = $this->si135_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si135_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si135_instit"])){ 
       $sql  .= $virgula." si135_instit = $this->si135_instit ";
       $virgula = ",";
       if(trim($this->si135_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si135_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si135_sequencial!=null){
       $sql .= " si135_sequencial = $this->si135_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si135_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010966,'$this->si135_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_sequencial"]) || $this->si135_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010966,'".AddSlashes(pg_result($resaco,$conresaco,'si135_sequencial'))."','$this->si135_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_tiporegistro"]) || $this->si135_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010967,'".AddSlashes(pg_result($resaco,$conresaco,'si135_tiporegistro'))."','$this->si135_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_codreduzidoop"]) || $this->si135_codreduzidoop != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010968,'".AddSlashes(pg_result($resaco,$conresaco,'si135_codreduzidoop'))."','$this->si135_codreduzidoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_tiporetencao"]) || $this->si135_tiporetencao != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010969,'".AddSlashes(pg_result($resaco,$conresaco,'si135_tiporetencao'))."','$this->si135_tiporetencao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_descricaoretencao"]) || $this->si135_descricaoretencao != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010970,'".AddSlashes(pg_result($resaco,$conresaco,'si135_descricaoretencao'))."','$this->si135_descricaoretencao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_vlretencao"]) || $this->si135_vlretencao != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010971,'".AddSlashes(pg_result($resaco,$conresaco,'si135_vlretencao'))."','$this->si135_vlretencao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_mes"]) || $this->si135_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010972,'".AddSlashes(pg_result($resaco,$conresaco,'si135_mes'))."','$this->si135_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_reg10"]) || $this->si135_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2010973,'".AddSlashes(pg_result($resaco,$conresaco,'si135_reg10'))."','$this->si135_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si135_instit"]) || $this->si135_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010364,2011648,'".AddSlashes(pg_result($resaco,$conresaco,'si135_instit'))."','$this->si135_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ops132016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si135_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ops132016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si135_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si135_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si135_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si135_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010966,'$si135_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010364,2010966,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2010967,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2010968,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2010969,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_tiporetencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2010970,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_descricaoretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2010971,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_vlretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2010972,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2010973,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010364,2011648,'','".AddSlashes(pg_result($resaco,$iresaco,'si135_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ops132016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si135_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si135_sequencial = $si135_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ops132016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si135_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ops132016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si135_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si135_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ops132016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si135_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ops132016 ";
     $sql .= "      left  join ops102016  on  ops102016.si132_sequencial = ops132016.si135_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si135_sequencial!=null ){
         $sql2 .= " where ops132016.si135_sequencial = $si135_sequencial "; 
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
   function sql_query_file ( $si135_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ops132016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si135_sequencial!=null ){
         $sql2 .= " where ops132016.si135_sequencial = $si135_sequencial "; 
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
