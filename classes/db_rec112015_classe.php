<?
//MODULO: sicom
//CLASSE DA ENTIDADE rec112015
class cl_rec112015 { 
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
   var $si26_sequencial = 0; 
   var $si26_tiporegistro = 0; 
   var $si26_codreceita = 0; 
   var $si26_codfontrecursos = 0; 
   var $si26_vlarrecadadofonte = 0; 
   var $si26_reg10 = 0; 
   var $si26_mes = 0; 
   var $si26_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si26_sequencial = int8 = sequencial 
                 si26_tiporegistro = int8 = Tipo do  registro 
                 si26_codreceita = int8 = Código identificador 
                 si26_codfontrecursos = int8 = Código da fonte de  recursos 
                 si26_vlarrecadadofonte = float8 = Valor arrecadado 
                 si26_reg10 = int8 = reg10 
                 si26_mes = int8 = Mês 
                 si26_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_rec112015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rec112015"); 
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
       $this->si26_sequencial = ($this->si26_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_sequencial"]:$this->si26_sequencial);
       $this->si26_tiporegistro = ($this->si26_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_tiporegistro"]:$this->si26_tiporegistro);
       $this->si26_codreceita = ($this->si26_codreceita == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_codreceita"]:$this->si26_codreceita);
       $this->si26_codfontrecursos = ($this->si26_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_codfontrecursos"]:$this->si26_codfontrecursos);
       $this->si26_vlarrecadadofonte = ($this->si26_vlarrecadadofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_vlarrecadadofonte"]:$this->si26_vlarrecadadofonte);
       $this->si26_reg10 = ($this->si26_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_reg10"]:$this->si26_reg10);
       $this->si26_mes = ($this->si26_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_mes"]:$this->si26_mes);
       $this->si26_instit = ($this->si26_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_instit"]:$this->si26_instit);
     }else{
       $this->si26_sequencial = ($this->si26_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si26_sequencial"]:$this->si26_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si26_sequencial){ 
      $this->atualizacampos();
     if($this->si26_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si26_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si26_codreceita == null ){ 
       $this->si26_codreceita = "0";
     }
     if($this->si26_codfontrecursos == null ){ 
       $this->si26_codfontrecursos = "0";
     }
     if($this->si26_vlarrecadadofonte == null ){ 
       $this->si26_vlarrecadadofonte = "0";
     }
     if($this->si26_reg10 == null ){ 
       $this->si26_reg10 = "0";
     }
     if($this->si26_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si26_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si26_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si26_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si26_sequencial == "" || $si26_sequencial == null ){
       $result = db_query("select nextval('rec112015_si26_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rec112015_si26_sequencial_seq do campo: si26_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si26_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from rec112015_si26_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si26_sequencial)){
         $this->erro_sql = " Campo si26_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si26_sequencial = $si26_sequencial; 
       }
     }
     if(($this->si26_sequencial == null) || ($this->si26_sequencial == "") ){ 
       $this->erro_sql = " Campo si26_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rec112015(
                                       si26_sequencial 
                                      ,si26_tiporegistro 
                                      ,si26_codreceita 
                                      ,si26_codfontrecursos 
                                      ,si26_vlarrecadadofonte 
                                      ,si26_reg10 
                                      ,si26_mes 
                                      ,si26_instit 
                       )
                values (
                                $this->si26_sequencial 
                               ,$this->si26_tiporegistro 
                               ,$this->si26_codreceita 
                               ,$this->si26_codfontrecursos 
                               ,$this->si26_vlarrecadadofonte 
                               ,$this->si26_reg10 
                               ,$this->si26_mes 
                               ,$this->si26_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "rec112015 ($this->si26_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "rec112015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "rec112015 ($this->si26_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si26_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si26_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009682,'$this->si26_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010254,2009682,'','".AddSlashes(pg_result($resaco,0,'si26_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010254,2009683,'','".AddSlashes(pg_result($resaco,0,'si26_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010254,2009684,'','".AddSlashes(pg_result($resaco,0,'si26_codreceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010254,2009685,'','".AddSlashes(pg_result($resaco,0,'si26_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010254,2009686,'','".AddSlashes(pg_result($resaco,0,'si26_vlarrecadadofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010254,2009687,'','".AddSlashes(pg_result($resaco,0,'si26_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010254,2009744,'','".AddSlashes(pg_result($resaco,0,'si26_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010254,2011542,'','".AddSlashes(pg_result($resaco,0,'si26_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si26_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rec112015 set ";
     $virgula = "";
     if(trim($this->si26_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_sequencial"])){ 
        if(trim($this->si26_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si26_sequencial"])){ 
           $this->si26_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si26_sequencial = $this->si26_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si26_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_tiporegistro"])){ 
       $sql  .= $virgula." si26_tiporegistro = $this->si26_tiporegistro ";
       $virgula = ",";
       if(trim($this->si26_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si26_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si26_codreceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_codreceita"])){ 
        if(trim($this->si26_codreceita)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si26_codreceita"])){ 
           $this->si26_codreceita = "0" ; 
        } 
       $sql  .= $virgula." si26_codreceita = $this->si26_codreceita ";
       $virgula = ",";
     }
     if(trim($this->si26_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_codfontrecursos"])){ 
        if(trim($this->si26_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si26_codfontrecursos"])){ 
           $this->si26_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si26_codfontrecursos = $this->si26_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si26_vlarrecadadofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_vlarrecadadofonte"])){ 
        if(trim($this->si26_vlarrecadadofonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si26_vlarrecadadofonte"])){ 
           $this->si26_vlarrecadadofonte = "0" ; 
        } 
       $sql  .= $virgula." si26_vlarrecadadofonte = $this->si26_vlarrecadadofonte ";
       $virgula = ",";
     }
     if(trim($this->si26_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_reg10"])){ 
        if(trim($this->si26_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si26_reg10"])){ 
           $this->si26_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si26_reg10 = $this->si26_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si26_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_mes"])){ 
       $sql  .= $virgula." si26_mes = $this->si26_mes ";
       $virgula = ",";
       if(trim($this->si26_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si26_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si26_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si26_instit"])){ 
       $sql  .= $virgula." si26_instit = $this->si26_instit ";
       $virgula = ",";
       if(trim($this->si26_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si26_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si26_sequencial!=null){
       $sql .= " si26_sequencial = $this->si26_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si26_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009682,'$this->si26_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_sequencial"]) || $this->si26_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2009682,'".AddSlashes(pg_result($resaco,$conresaco,'si26_sequencial'))."','$this->si26_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_tiporegistro"]) || $this->si26_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2009683,'".AddSlashes(pg_result($resaco,$conresaco,'si26_tiporegistro'))."','$this->si26_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_codreceita"]) || $this->si26_codreceita != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2009684,'".AddSlashes(pg_result($resaco,$conresaco,'si26_codreceita'))."','$this->si26_codreceita',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_codfontrecursos"]) || $this->si26_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2009685,'".AddSlashes(pg_result($resaco,$conresaco,'si26_codfontrecursos'))."','$this->si26_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_vlarrecadadofonte"]) || $this->si26_vlarrecadadofonte != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2009686,'".AddSlashes(pg_result($resaco,$conresaco,'si26_vlarrecadadofonte'))."','$this->si26_vlarrecadadofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_reg10"]) || $this->si26_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2009687,'".AddSlashes(pg_result($resaco,$conresaco,'si26_reg10'))."','$this->si26_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_mes"]) || $this->si26_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2009744,'".AddSlashes(pg_result($resaco,$conresaco,'si26_mes'))."','$this->si26_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si26_instit"]) || $this->si26_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010254,2011542,'".AddSlashes(pg_result($resaco,$conresaco,'si26_instit'))."','$this->si26_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rec112015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si26_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rec112015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si26_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si26_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si26_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si26_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009682,'$si26_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010254,2009682,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010254,2009683,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010254,2009684,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_codreceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010254,2009685,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010254,2009686,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_vlarrecadadofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010254,2009687,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010254,2009744,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010254,2011542,'','".AddSlashes(pg_result($resaco,$iresaco,'si26_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from rec112015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si26_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si26_sequencial = $si26_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rec112015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si26_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rec112015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si26_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si26_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rec112015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si26_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rec112015 ";
     $sql .= "      left  join rec102015  on  rec102015.si25_sequencial = rec112015.si26_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si26_sequencial!=null ){
         $sql2 .= " where rec112015.si26_sequencial = $si26_sequencial "; 
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
   function sql_query_file ( $si26_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rec112015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si26_sequencial!=null ){
         $sql2 .= " where rec112015.si26_sequencial = $si26_sequencial "; 
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
