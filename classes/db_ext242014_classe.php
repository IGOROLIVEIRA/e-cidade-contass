<?
//MODULO: sicom
//CLASSE DA ENTIDADE ext242014
class cl_ext242014 { 
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
   var $si128_sequencial = 0; 
   var $si128_tiporegistro = 0; 
   var $si128_codreduzidoop = 0; 
   var $si128_tiporetencao = null; 
   var $si128_descricaoretencao = null; 
   var $si128_vlretencao = 0; 
   var $si128_mes = 0; 
   var $si128_reg20 = 0; 
   var $si128_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si128_sequencial = int8 = sequencial 
                 si128_tiporegistro = int8 = Tipo do  registro 
                 si128_codreduzidoop = int8 = Código  Identificador da  Ordem 
                 si128_tiporetencao = varchar(4) = Tipo de Retenção 
                 si128_descricaoretencao = varchar(50) = Descrição da  Retenção 
                 si128_vlretencao = float8 = Valor da retenção 
                 si128_mes = int8 = Mês 
                 si128_reg20 = int8 = reg20 
                 si128_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ext242014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ext242014"); 
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
       $this->si128_sequencial = ($this->si128_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_sequencial"]:$this->si128_sequencial);
       $this->si128_tiporegistro = ($this->si128_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_tiporegistro"]:$this->si128_tiporegistro);
       $this->si128_codreduzidoop = ($this->si128_codreduzidoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_codreduzidoop"]:$this->si128_codreduzidoop);
       $this->si128_tiporetencao = ($this->si128_tiporetencao == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_tiporetencao"]:$this->si128_tiporetencao);
       $this->si128_descricaoretencao = ($this->si128_descricaoretencao == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_descricaoretencao"]:$this->si128_descricaoretencao);
       $this->si128_vlretencao = ($this->si128_vlretencao == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_vlretencao"]:$this->si128_vlretencao);
       $this->si128_mes = ($this->si128_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_mes"]:$this->si128_mes);
       $this->si128_reg20 = ($this->si128_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_reg20"]:$this->si128_reg20);
       $this->si128_instit = ($this->si128_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_instit"]:$this->si128_instit);
     }else{
       $this->si128_sequencial = ($this->si128_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si128_sequencial"]:$this->si128_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si128_sequencial){ 
      $this->atualizacampos();
     if($this->si128_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si128_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si128_codreduzidoop == null ){ 
       $this->si128_codreduzidoop = "0";
     }
     if($this->si128_vlretencao == null ){ 
       $this->si128_vlretencao = "0";
     }
     if($this->si128_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si128_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si128_reg20 == null ){ 
       $this->si128_reg20 = "0";
     }
     if($this->si128_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si128_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si128_sequencial == "" || $si128_sequencial == null ){
       $result = db_query("select nextval('ext242014_si128_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ext242014_si128_sequencial_seq do campo: si128_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si128_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ext242014_si128_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si128_sequencial)){
         $this->erro_sql = " Campo si128_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si128_sequencial = $si128_sequencial; 
       }
     }
     if(($this->si128_sequencial == null) || ($this->si128_sequencial == "") ){ 
       $this->erro_sql = " Campo si128_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ext242014(
                                       si128_sequencial 
                                      ,si128_tiporegistro 
                                      ,si128_codreduzidoop 
                                      ,si128_tiporetencao 
                                      ,si128_descricaoretencao 
                                      ,si128_vlretencao 
                                      ,si128_mes 
                                      ,si128_reg20 
                                      ,si128_instit 
                       )
                values (
                                $this->si128_sequencial 
                               ,$this->si128_tiporegistro 
                               ,$this->si128_codreduzidoop 
                               ,'$this->si128_tiporetencao' 
                               ,'$this->si128_descricaoretencao' 
                               ,$this->si128_vlretencao 
                               ,$this->si128_mes 
                               ,$this->si128_reg20 
                               ,$this->si128_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ext242014 ($this->si128_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ext242014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ext242014 ($this->si128_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si128_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si128_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010888,'$this->si128_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010357,2010888,'','".AddSlashes(pg_result($resaco,0,'si128_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2010889,'','".AddSlashes(pg_result($resaco,0,'si128_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2010890,'','".AddSlashes(pg_result($resaco,0,'si128_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2010891,'','".AddSlashes(pg_result($resaco,0,'si128_tiporetencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2010892,'','".AddSlashes(pg_result($resaco,0,'si128_descricaoretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2010893,'','".AddSlashes(pg_result($resaco,0,'si128_vlretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2010894,'','".AddSlashes(pg_result($resaco,0,'si128_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2010895,'','".AddSlashes(pg_result($resaco,0,'si128_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010357,2011641,'','".AddSlashes(pg_result($resaco,0,'si128_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si128_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ext242014 set ";
     $virgula = "";
     if(trim($this->si128_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_sequencial"])){ 
        if(trim($this->si128_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si128_sequencial"])){ 
           $this->si128_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si128_sequencial = $this->si128_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si128_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_tiporegistro"])){ 
       $sql  .= $virgula." si128_tiporegistro = $this->si128_tiporegistro ";
       $virgula = ",";
       if(trim($this->si128_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si128_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si128_codreduzidoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_codreduzidoop"])){ 
        if(trim($this->si128_codreduzidoop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si128_codreduzidoop"])){ 
           $this->si128_codreduzidoop = "0" ; 
        } 
       $sql  .= $virgula." si128_codreduzidoop = $this->si128_codreduzidoop ";
       $virgula = ",";
     }
     if(trim($this->si128_tiporetencao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_tiporetencao"])){ 
       $sql  .= $virgula." si128_tiporetencao = '$this->si128_tiporetencao' ";
       $virgula = ",";
     }
     if(trim($this->si128_descricaoretencao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_descricaoretencao"])){ 
       $sql  .= $virgula." si128_descricaoretencao = '$this->si128_descricaoretencao' ";
       $virgula = ",";
     }
     if(trim($this->si128_vlretencao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_vlretencao"])){ 
        if(trim($this->si128_vlretencao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si128_vlretencao"])){ 
           $this->si128_vlretencao = "0" ; 
        } 
       $sql  .= $virgula." si128_vlretencao = $this->si128_vlretencao ";
       $virgula = ",";
     }
     if(trim($this->si128_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_mes"])){ 
       $sql  .= $virgula." si128_mes = $this->si128_mes ";
       $virgula = ",";
       if(trim($this->si128_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si128_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si128_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_reg20"])){ 
        if(trim($this->si128_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si128_reg20"])){ 
           $this->si128_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si128_reg20 = $this->si128_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si128_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si128_instit"])){ 
       $sql  .= $virgula." si128_instit = $this->si128_instit ";
       $virgula = ",";
       if(trim($this->si128_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si128_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si128_sequencial!=null){
       $sql .= " si128_sequencial = $this->si128_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si128_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010888,'$this->si128_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_sequencial"]) || $this->si128_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010888,'".AddSlashes(pg_result($resaco,$conresaco,'si128_sequencial'))."','$this->si128_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_tiporegistro"]) || $this->si128_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010889,'".AddSlashes(pg_result($resaco,$conresaco,'si128_tiporegistro'))."','$this->si128_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_codreduzidoop"]) || $this->si128_codreduzidoop != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010890,'".AddSlashes(pg_result($resaco,$conresaco,'si128_codreduzidoop'))."','$this->si128_codreduzidoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_tiporetencao"]) || $this->si128_tiporetencao != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010891,'".AddSlashes(pg_result($resaco,$conresaco,'si128_tiporetencao'))."','$this->si128_tiporetencao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_descricaoretencao"]) || $this->si128_descricaoretencao != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010892,'".AddSlashes(pg_result($resaco,$conresaco,'si128_descricaoretencao'))."','$this->si128_descricaoretencao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_vlretencao"]) || $this->si128_vlretencao != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010893,'".AddSlashes(pg_result($resaco,$conresaco,'si128_vlretencao'))."','$this->si128_vlretencao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_mes"]) || $this->si128_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010894,'".AddSlashes(pg_result($resaco,$conresaco,'si128_mes'))."','$this->si128_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_reg20"]) || $this->si128_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2010895,'".AddSlashes(pg_result($resaco,$conresaco,'si128_reg20'))."','$this->si128_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si128_instit"]) || $this->si128_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010357,2011641,'".AddSlashes(pg_result($resaco,$conresaco,'si128_instit'))."','$this->si128_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ext242014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si128_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ext242014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si128_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si128_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si128_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si128_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010888,'$si128_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010357,2010888,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2010889,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2010890,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2010891,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_tiporetencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2010892,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_descricaoretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2010893,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_vlretencao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2010894,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2010895,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010357,2011641,'','".AddSlashes(pg_result($resaco,$iresaco,'si128_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ext242014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si128_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si128_sequencial = $si128_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ext242014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si128_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ext242014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si128_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si128_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ext242014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si128_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ext242014 ";
     $sql .= "      left  join ext202014  on  ext202014.si165_sequencial = ext242014.si128_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si128_sequencial!=null ){
         $sql2 .= " where ext242014.si128_sequencial = $si128_sequencial "; 
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
   function sql_query_file ( $si128_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ext242014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si128_sequencial!=null ){
         $sql2 .= " where ext242014.si128_sequencial = $si128_sequencial "; 
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
