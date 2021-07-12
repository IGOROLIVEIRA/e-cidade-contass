<?
//MODULO: sicom
//CLASSE DA ENTIDADE arc212015
class cl_arc212015 { 
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
   var $si32_sequencial = 0; 
   var $si32_tiporegistro = 0; 
   var $si32_codestorno = 0; 
   var $si32_codfonteestornada = 0; 
   var $si32_vlestornadofonte = 0; 
   var $si32_reg20 = 0; 
   var $si32_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si32_sequencial = int8 = sequencial 
                 si32_tiporegistro = int8 = Tipo do  registro 
                 si32_codestorno = int8 = Código identificador 
                 si32_codfonteestornada = int8 = Código da fonte 
                 si32_vlestornadofonte = float8 = Valor estornado 
                 si32_reg20 = int8 = reg20 
                 si32_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_arc212015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("arc212015"); 
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
       $this->si32_sequencial = ($this->si32_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_sequencial"]:$this->si32_sequencial);
       $this->si32_tiporegistro = ($this->si32_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_tiporegistro"]:$this->si32_tiporegistro);
       $this->si32_codestorno = ($this->si32_codestorno == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_codestorno"]:$this->si32_codestorno);
       $this->si32_codfonteestornada = ($this->si32_codfonteestornada == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_codfonteestornada"]:$this->si32_codfonteestornada);
       $this->si32_vlestornadofonte = ($this->si32_vlestornadofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_vlestornadofonte"]:$this->si32_vlestornadofonte);
       $this->si32_reg20 = ($this->si32_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_reg20"]:$this->si32_reg20);
       $this->si32_instit = ($this->si32_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_instit"]:$this->si32_instit);
     }else{
       $this->si32_sequencial = ($this->si32_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si32_sequencial"]:$this->si32_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si32_sequencial){ 
      $this->atualizacampos();
     if($this->si32_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si32_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si32_codestorno == null ){ 
       $this->si32_codestorno = "0";
     }
     if($this->si32_codfonteestornada == null ){ 
       $this->si32_codfonteestornada = "0";
     }
     if($this->si32_vlestornadofonte == null ){ 
       $this->si32_vlestornadofonte = "0";
     }
     if($this->si32_reg20 == null ){ 
       $this->si32_reg20 = "0";
     }
     if($this->si32_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si32_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si32_sequencial == "" || $si32_sequencial == null ){
       $result = db_query("select nextval('arc212015_si32_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: arc212015_si32_sequencial_seq do campo: si32_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si32_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from arc212015_si32_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si32_sequencial)){
         $this->erro_sql = " Campo si32_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si32_sequencial = $si32_sequencial; 
       }
     }
     if(($this->si32_sequencial == null) || ($this->si32_sequencial == "") ){ 
       $this->erro_sql = " Campo si32_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into arc212015(
                                       si32_sequencial 
                                      ,si32_tiporegistro 
                                      ,si32_codestorno 
                                      ,si32_codfonteestornada 
                                      ,si32_vlestornadofonte 
                                      ,si32_reg20 
                                      ,si32_instit 
                       )
                values (
                                $this->si32_sequencial 
                               ,$this->si32_tiporegistro 
                               ,$this->si32_codestorno 
                               ,$this->si32_codfonteestornada 
                               ,$this->si32_vlestornadofonte 
                               ,$this->si32_reg20 
                               ,$this->si32_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "arc212015 ($this->si32_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "arc212015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "arc212015 ($this->si32_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si32_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si32_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009724,'$this->si32_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010260,2009724,'','".AddSlashes(pg_result($resaco,0,'si32_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010260,2009725,'','".AddSlashes(pg_result($resaco,0,'si32_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010260,2009726,'','".AddSlashes(pg_result($resaco,0,'si32_codestorno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010260,2009727,'','".AddSlashes(pg_result($resaco,0,'si32_codfonteestornada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010260,2009728,'','".AddSlashes(pg_result($resaco,0,'si32_vlestornadofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010260,2009729,'','".AddSlashes(pg_result($resaco,0,'si32_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010260,2011547,'','".AddSlashes(pg_result($resaco,0,'si32_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si32_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update arc212015 set ";
     $virgula = "";
     if(trim($this->si32_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si32_sequencial"])){ 
        if(trim($this->si32_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si32_sequencial"])){ 
           $this->si32_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si32_sequencial = $this->si32_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si32_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si32_tiporegistro"])){ 
       $sql  .= $virgula." si32_tiporegistro = $this->si32_tiporegistro ";
       $virgula = ",";
       if(trim($this->si32_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si32_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si32_codestorno)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si32_codestorno"])){ 
        if(trim($this->si32_codestorno)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si32_codestorno"])){ 
           $this->si32_codestorno = "0" ; 
        } 
       $sql  .= $virgula." si32_codestorno = $this->si32_codestorno ";
       $virgula = ",";
     }
     if(trim($this->si32_codfonteestornada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si32_codfonteestornada"])){ 
        if(trim($this->si32_codfonteestornada)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si32_codfonteestornada"])){ 
           $this->si32_codfonteestornada = "0" ; 
        } 
       $sql  .= $virgula." si32_codfonteestornada = $this->si32_codfonteestornada ";
       $virgula = ",";
     }
     if(trim($this->si32_vlestornadofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si32_vlestornadofonte"])){ 
        if(trim($this->si32_vlestornadofonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si32_vlestornadofonte"])){ 
           $this->si32_vlestornadofonte = "0" ; 
        } 
       $sql  .= $virgula." si32_vlestornadofonte = $this->si32_vlestornadofonte ";
       $virgula = ",";
     }
     if(trim($this->si32_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si32_reg20"])){ 
        if(trim($this->si32_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si32_reg20"])){ 
           $this->si32_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si32_reg20 = $this->si32_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si32_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si32_instit"])){ 
       $sql  .= $virgula." si32_instit = $this->si32_instit ";
       $virgula = ",";
       if(trim($this->si32_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si32_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si32_sequencial!=null){
       $sql .= " si32_sequencial = $this->si32_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si32_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009724,'$this->si32_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si32_sequencial"]) || $this->si32_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010260,2009724,'".AddSlashes(pg_result($resaco,$conresaco,'si32_sequencial'))."','$this->si32_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si32_tiporegistro"]) || $this->si32_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010260,2009725,'".AddSlashes(pg_result($resaco,$conresaco,'si32_tiporegistro'))."','$this->si32_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si32_codestorno"]) || $this->si32_codestorno != "")
           $resac = db_query("insert into db_acount values($acount,2010260,2009726,'".AddSlashes(pg_result($resaco,$conresaco,'si32_codestorno'))."','$this->si32_codestorno',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si32_codfonteestornada"]) || $this->si32_codfonteestornada != "")
           $resac = db_query("insert into db_acount values($acount,2010260,2009727,'".AddSlashes(pg_result($resaco,$conresaco,'si32_codfonteestornada'))."','$this->si32_codfonteestornada',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si32_vlestornadofonte"]) || $this->si32_vlestornadofonte != "")
           $resac = db_query("insert into db_acount values($acount,2010260,2009728,'".AddSlashes(pg_result($resaco,$conresaco,'si32_vlestornadofonte'))."','$this->si32_vlestornadofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si32_reg20"]) || $this->si32_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010260,2009729,'".AddSlashes(pg_result($resaco,$conresaco,'si32_reg20'))."','$this->si32_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si32_instit"]) || $this->si32_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010260,2011547,'".AddSlashes(pg_result($resaco,$conresaco,'si32_instit'))."','$this->si32_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "arc212015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si32_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "arc212015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si32_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si32_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si32_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si32_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009724,'$si32_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010260,2009724,'','".AddSlashes(pg_result($resaco,$iresaco,'si32_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010260,2009725,'','".AddSlashes(pg_result($resaco,$iresaco,'si32_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010260,2009726,'','".AddSlashes(pg_result($resaco,$iresaco,'si32_codestorno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010260,2009727,'','".AddSlashes(pg_result($resaco,$iresaco,'si32_codfonteestornada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010260,2009728,'','".AddSlashes(pg_result($resaco,$iresaco,'si32_vlestornadofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010260,2009729,'','".AddSlashes(pg_result($resaco,$iresaco,'si32_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010260,2011547,'','".AddSlashes(pg_result($resaco,$iresaco,'si32_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from arc212015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si32_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si32_sequencial = $si32_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "arc212015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si32_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "arc212015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si32_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si32_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:arc212015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si32_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arc212015 ";
     $sql .= "      left  join arc202015  on  arc202015.si31_sequencial = arc212015.si32_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si32_sequencial!=null ){
         $sql2 .= " where arc212015.si32_sequencial = $si32_sequencial "; 
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
   function sql_query_file ( $si32_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arc212015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si32_sequencial!=null ){
         $sql2 .= " where arc212015.si32_sequencial = $si32_sequencial "; 
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
