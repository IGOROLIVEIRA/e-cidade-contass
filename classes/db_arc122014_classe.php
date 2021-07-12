<?
//MODULO: sicom
//CLASSE DA ENTIDADE arc122014
class cl_arc122014 { 
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
   var $si30_sequencial = 0; 
   var $si30_tiporegistro = 0; 
   var $si30_codcorrecao = 0; 
   var $si30_codfonteacrescida = 0; 
   var $si30_vlacrescidofonte = 0; 
   var $si30_reg10 = 0; 
   var $si30_mes = 0; 
   var $si30_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si30_sequencial = int8 = sequencial 
                 si30_tiporegistro = int8 = Tipo do  registro 
                 si30_codcorrecao = int8 = Código que  identifica 
                 si30_codfonteacrescida = int8 = Código da fonte 
                 si30_vlacrescidofonte = float8 = Valor acrescido 
                 si30_reg10 = int8 = reg10 
                 si30_mes = int8 = Mês 
                 si30_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_arc122014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("arc122014"); 
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
       $this->si30_sequencial = ($this->si30_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_sequencial"]:$this->si30_sequencial);
       $this->si30_tiporegistro = ($this->si30_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_tiporegistro"]:$this->si30_tiporegistro);
       $this->si30_codcorrecao = ($this->si30_codcorrecao == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_codcorrecao"]:$this->si30_codcorrecao);
       $this->si30_codfonteacrescida = ($this->si30_codfonteacrescida == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_codfonteacrescida"]:$this->si30_codfonteacrescida);
       $this->si30_vlacrescidofonte = ($this->si30_vlacrescidofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_vlacrescidofonte"]:$this->si30_vlacrescidofonte);
       $this->si30_reg10 = ($this->si30_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_reg10"]:$this->si30_reg10);
       $this->si30_mes = ($this->si30_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_mes"]:$this->si30_mes);
       $this->si30_instit = ($this->si30_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_instit"]:$this->si30_instit);
     }else{
       $this->si30_sequencial = ($this->si30_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si30_sequencial"]:$this->si30_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si30_sequencial){ 
      $this->atualizacampos();
     if($this->si30_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si30_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si30_codcorrecao == null ){ 
       $this->si30_codcorrecao = "0";
     }
     if($this->si30_codfonteacrescida == null ){ 
       $this->si30_codfonteacrescida = "0";
     }
     if($this->si30_vlacrescidofonte == null ){ 
       $this->si30_vlacrescidofonte = "0";
     }
     if($this->si30_reg10 == null ){ 
       $this->si30_reg10 = "0";
     }
     if($this->si30_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si30_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si30_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si30_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si30_sequencial = $si30_sequencial; 
     if(($this->si30_sequencial == null) || ($this->si30_sequencial == "") ){ 
       $this->erro_sql = " Campo si30_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into arc122014(
                                       si30_sequencial 
                                      ,si30_tiporegistro 
                                      ,si30_codcorrecao 
                                      ,si30_codfonteacrescida 
                                      ,si30_vlacrescidofonte 
                                      ,si30_reg10 
                                      ,si30_mes 
                                      ,si30_instit 
                       )
                values (
                                $this->si30_sequencial 
                               ,$this->si30_tiporegistro 
                               ,$this->si30_codcorrecao 
                               ,$this->si30_codfonteacrescida 
                               ,$this->si30_vlacrescidofonte 
                               ,$this->si30_reg10 
                               ,$this->si30_mes 
                               ,$this->si30_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "arc122014 ($this->si30_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "arc122014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "arc122014 ($this->si30_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si30_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si30_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009709,'$this->si30_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010258,2009709,'','".AddSlashes(pg_result($resaco,0,'si30_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010258,2009710,'','".AddSlashes(pg_result($resaco,0,'si30_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010258,2009711,'','".AddSlashes(pg_result($resaco,0,'si30_codcorrecao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010258,2009712,'','".AddSlashes(pg_result($resaco,0,'si30_codfonteacrescida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010258,2009713,'','".AddSlashes(pg_result($resaco,0,'si30_vlacrescidofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010258,2009714,'','".AddSlashes(pg_result($resaco,0,'si30_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010258,2009747,'','".AddSlashes(pg_result($resaco,0,'si30_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010258,2011545,'','".AddSlashes(pg_result($resaco,0,'si30_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si30_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update arc122014 set ";
     $virgula = "";
     if(trim($this->si30_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_sequencial"])){ 
        if(trim($this->si30_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si30_sequencial"])){ 
           $this->si30_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si30_sequencial = $this->si30_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si30_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_tiporegistro"])){ 
       $sql  .= $virgula." si30_tiporegistro = $this->si30_tiporegistro ";
       $virgula = ",";
       if(trim($this->si30_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si30_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si30_codcorrecao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_codcorrecao"])){ 
        if(trim($this->si30_codcorrecao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si30_codcorrecao"])){ 
           $this->si30_codcorrecao = "0" ; 
        } 
       $sql  .= $virgula." si30_codcorrecao = $this->si30_codcorrecao ";
       $virgula = ",";
     }
     if(trim($this->si30_codfonteacrescida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_codfonteacrescida"])){ 
        if(trim($this->si30_codfonteacrescida)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si30_codfonteacrescida"])){ 
           $this->si30_codfonteacrescida = "0" ; 
        } 
       $sql  .= $virgula." si30_codfonteacrescida = $this->si30_codfonteacrescida ";
       $virgula = ",";
     }
     if(trim($this->si30_vlacrescidofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_vlacrescidofonte"])){ 
        if(trim($this->si30_vlacrescidofonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si30_vlacrescidofonte"])){ 
           $this->si30_vlacrescidofonte = "0" ; 
        } 
       $sql  .= $virgula." si30_vlacrescidofonte = $this->si30_vlacrescidofonte ";
       $virgula = ",";
     }
     if(trim($this->si30_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_reg10"])){ 
        if(trim($this->si30_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si30_reg10"])){ 
           $this->si30_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si30_reg10 = $this->si30_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si30_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_mes"])){ 
       $sql  .= $virgula." si30_mes = $this->si30_mes ";
       $virgula = ",";
       if(trim($this->si30_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si30_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si30_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si30_instit"])){ 
       $sql  .= $virgula." si30_instit = $this->si30_instit ";
       $virgula = ",";
       if(trim($this->si30_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si30_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si30_sequencial!=null){
       $sql .= " si30_sequencial = $this->si30_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si30_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009709,'$this->si30_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_sequencial"]) || $this->si30_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2009709,'".AddSlashes(pg_result($resaco,$conresaco,'si30_sequencial'))."','$this->si30_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_tiporegistro"]) || $this->si30_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2009710,'".AddSlashes(pg_result($resaco,$conresaco,'si30_tiporegistro'))."','$this->si30_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_codcorrecao"]) || $this->si30_codcorrecao != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2009711,'".AddSlashes(pg_result($resaco,$conresaco,'si30_codcorrecao'))."','$this->si30_codcorrecao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_codfonteacrescida"]) || $this->si30_codfonteacrescida != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2009712,'".AddSlashes(pg_result($resaco,$conresaco,'si30_codfonteacrescida'))."','$this->si30_codfonteacrescida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_vlacrescidofonte"]) || $this->si30_vlacrescidofonte != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2009713,'".AddSlashes(pg_result($resaco,$conresaco,'si30_vlacrescidofonte'))."','$this->si30_vlacrescidofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_reg10"]) || $this->si30_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2009714,'".AddSlashes(pg_result($resaco,$conresaco,'si30_reg10'))."','$this->si30_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_mes"]) || $this->si30_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2009747,'".AddSlashes(pg_result($resaco,$conresaco,'si30_mes'))."','$this->si30_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si30_instit"]) || $this->si30_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010258,2011545,'".AddSlashes(pg_result($resaco,$conresaco,'si30_instit'))."','$this->si30_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "arc122014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si30_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "arc122014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si30_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si30_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si30_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si30_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009709,'$si30_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010258,2009709,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010258,2009710,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010258,2009711,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_codcorrecao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010258,2009712,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_codfonteacrescida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010258,2009713,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_vlacrescidofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010258,2009714,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010258,2009747,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010258,2011545,'','".AddSlashes(pg_result($resaco,$iresaco,'si30_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from arc122014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si30_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si30_sequencial = $si30_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "arc122014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si30_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "arc122014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si30_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si30_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:arc122014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si30_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arc122014 ";
     $sql .= "      left  join arc102014  on  arc102014.si28_sequencial = arc122014.si30_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si30_sequencial!=null ){
         $sql2 .= " where arc122014.si30_sequencial = $si30_sequencial "; 
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
   function sql_query_file ( $si30_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arc122014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si30_sequencial!=null ){
         $sql2 .= " where arc122014.si30_sequencial = $si30_sequencial "; 
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
