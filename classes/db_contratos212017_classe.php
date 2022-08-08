<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos212017
class cl_contratos212017 { 
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
   var $si88_sequencial = 0;
   var $si88_tiporegistro = 0;
   var $si88_codaditivo = 0;
   var $si88_coditem = 0;
   var $si88_tipoalteracaoitem = 0;
   var $si88_quantacrescdecresc = 0;
   var $si88_valorunitarioitem = 0;
   var $si88_mes = 0;
   var $si88_reg20 = 0;
   var $si88_instit = 0;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si88_sequencial = int8 = sequencial 
                 si88_tiporegistro = int8 = Tipo do  registro 
                 si88_codaditivo = int8 = Código do Termo  Aditivo 
                 si88_coditem = int8 = Código do Item 
                 si88_tipoalteracaoitem = int8 = Tipo de alteração  sofrida pelo item 
                 si88_quantacrescdecresc = float8 = Quantidade acrescida 
                 si88_valorunitarioitem = float8 = Valor unitário do  item 
                 si88_mes = int8 = Mês 
                 si88_reg20 = int8 = reg20 
                 si88_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_contratos212017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos212017"); 
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
       $this->si88_sequencial = ($this->si88_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_sequencial"]:$this->si88_sequencial);
       $this->si88_tiporegistro = ($this->si88_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_tiporegistro"]:$this->si88_tiporegistro);
       $this->si88_codaditivo = ($this->si88_codaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_codaditivo"]:$this->si88_codaditivo);
       $this->si88_coditem = ($this->si88_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_coditem"]:$this->si88_coditem);
       $this->si88_tipoalteracaoitem = ($this->si88_tipoalteracaoitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_tipoalteracaoitem"]:$this->si88_tipoalteracaoitem);
       $this->si88_quantacrescdecresc = ($this->si88_quantacrescdecresc == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_quantacrescdecresc"]:$this->si88_quantacrescdecresc);
       $this->si88_valorunitarioitem = ($this->si88_valorunitarioitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_valorunitarioitem"]:$this->si88_valorunitarioitem);
       $this->si88_mes = ($this->si88_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_mes"]:$this->si88_mes);
       $this->si88_reg20 = ($this->si88_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_reg20"]:$this->si88_reg20);
       $this->si88_instit = ($this->si88_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_instit"]:$this->si88_instit);
     }else{
       $this->si88_sequencial = ($this->si88_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si88_sequencial"]:$this->si88_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si88_sequencial){ 
      $this->atualizacampos();
     if($this->si88_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si88_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si88_codaditivo == null ){ 
       $this->si88_codaditivo = "0";
     }
     if($this->si88_coditem == null ){ 
       $this->si88_coditem = "0";
     }
     if($this->si88_tipoalteracaoitem == null ){ 
       $this->si88_tipoalteracaoitem = "0";
     }
     if($this->si88_quantacrescdecresc == null ){ 
       $this->si88_quantacrescdecresc = "0";
     }
     if($this->si88_valorunitarioitem == null ){ 
       $this->si88_valorunitarioitem = "0";
     }
     if($this->si88_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si88_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si88_reg20 == null ){ 
       $this->si88_reg20 = "0";
     }
     if($this->si88_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si88_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si88_sequencial == "" || $si88_sequencial == null ){
       $result = db_query("select nextval('contratos212017_si88_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos212017_si88_sequencial_seq do campo: si88_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si88_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from contratos212017_si88_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si88_sequencial)){
         $this->erro_sql = " Campo si88_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si88_sequencial = $si88_sequencial; 
       }
     }
     if(($this->si88_sequencial == null) || ($this->si88_sequencial == "") ){ 
       $this->erro_sql = " Campo si88_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos212017(
                                       si88_sequencial 
                                      ,si88_tiporegistro 
                                      ,si88_codaditivo 
                                      ,si88_coditem 
                                      ,si88_tipoalteracaoitem 
                                      ,si88_quantacrescdecresc 
                                      ,si88_valorunitarioitem 
                                      ,si88_mes 
                                      ,si88_reg20 
                                      ,si88_instit 
                       )
                values (
                                $this->si88_sequencial 
                               ,$this->si88_tiporegistro 
                               ,$this->si88_codaditivo 
                               ,$this->si88_coditem 
                               ,$this->si88_tipoalteracaoitem 
                               ,$this->si88_quantacrescdecresc 
                               ,$this->si88_valorunitarioitem 
                               ,$this->si88_mes 
                               ,$this->si88_reg20 
                               ,$this->si88_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos212017 ($this->si88_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "contratos212017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "contratos212017 ($this->si88_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si88_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si88_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010476,'$this->si88_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010317,2010476,'','".AddSlashes(pg_result($resaco,0,'si88_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010477,'','".AddSlashes(pg_result($resaco,0,'si88_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010478,'','".AddSlashes(pg_result($resaco,0,'si88_codaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010479,'','".AddSlashes(pg_result($resaco,0,'si88_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010480,'','".AddSlashes(pg_result($resaco,0,'si88_tipoalteracaoitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010481,'','".AddSlashes(pg_result($resaco,0,'si88_quantacrescdecresc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010482,'','".AddSlashes(pg_result($resaco,0,'si88_valorunitarioitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010483,'','".AddSlashes(pg_result($resaco,0,'si88_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2010484,'','".AddSlashes(pg_result($resaco,0,'si88_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010317,2011601,'','".AddSlashes(pg_result($resaco,0,'si88_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si88_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update contratos212017 set ";
     $virgula = "";
     if(trim($this->si88_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_sequencial"])){ 
        if(trim($this->si88_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si88_sequencial"])){ 
           $this->si88_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si88_sequencial = $this->si88_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si88_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_tiporegistro"])){ 
       $sql  .= $virgula." si88_tiporegistro = $this->si88_tiporegistro ";
       $virgula = ",";
       if(trim($this->si88_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si88_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si88_codaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_codaditivo"])){ 
        if(trim($this->si88_codaditivo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si88_codaditivo"])){ 
           $this->si88_codaditivo = "0" ; 
        } 
       $sql  .= $virgula." si88_codaditivo = $this->si88_codaditivo ";
       $virgula = ",";
     }
     if(trim($this->si88_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_coditem"])){ 
        if(trim($this->si88_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si88_coditem"])){ 
           $this->si88_coditem = "0" ; 
        } 
       $sql  .= $virgula." si88_coditem = $this->si88_coditem ";
       $virgula = ",";
     }
     if(trim($this->si88_tipoalteracaoitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_tipoalteracaoitem"])){ 
        if(trim($this->si88_tipoalteracaoitem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si88_tipoalteracaoitem"])){ 
           $this->si88_tipoalteracaoitem = "0" ; 
        } 
       $sql  .= $virgula." si88_tipoalteracaoitem = $this->si88_tipoalteracaoitem ";
       $virgula = ",";
     }
     if(trim($this->si88_quantacrescdecresc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_quantacrescdecresc"])){ 
        if(trim($this->si88_quantacrescdecresc)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si88_quantacrescdecresc"])){ 
           $this->si88_quantacrescdecresc = "0" ; 
        } 
       $sql  .= $virgula." si88_quantacrescdecresc = $this->si88_quantacrescdecresc ";
       $virgula = ",";
     }
     if(trim($this->si88_valorunitarioitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_valorunitarioitem"])){ 
        if(trim($this->si88_valorunitarioitem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si88_valorunitarioitem"])){ 
           $this->si88_valorunitarioitem = "0" ; 
        } 
       $sql  .= $virgula." si88_valorunitarioitem = $this->si88_valorunitarioitem ";
       $virgula = ",";
     }
     if(trim($this->si88_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_mes"])){ 
       $sql  .= $virgula." si88_mes = $this->si88_mes ";
       $virgula = ",";
       if(trim($this->si88_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si88_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si88_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_reg20"])){ 
        if(trim($this->si88_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si88_reg20"])){ 
           $this->si88_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si88_reg20 = $this->si88_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si88_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si88_instit"])){ 
       $sql  .= $virgula." si88_instit = $this->si88_instit ";
       $virgula = ",";
       if(trim($this->si88_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si88_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si88_sequencial!=null){
       $sql .= " si88_sequencial = $this->si88_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si88_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010476,'$this->si88_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_sequencial"]) || $this->si88_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010476,'".AddSlashes(pg_result($resaco,$conresaco,'si88_sequencial'))."','$this->si88_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_tiporegistro"]) || $this->si88_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010477,'".AddSlashes(pg_result($resaco,$conresaco,'si88_tiporegistro'))."','$this->si88_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_codaditivo"]) || $this->si88_codaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010478,'".AddSlashes(pg_result($resaco,$conresaco,'si88_codaditivo'))."','$this->si88_codaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_coditem"]) || $this->si88_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010479,'".AddSlashes(pg_result($resaco,$conresaco,'si88_coditem'))."','$this->si88_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_tipoalteracaoitem"]) || $this->si88_tipoalteracaoitem != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010480,'".AddSlashes(pg_result($resaco,$conresaco,'si88_tipoalteracaoitem'))."','$this->si88_tipoalteracaoitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_quantacrescdecresc"]) || $this->si88_quantacrescdecresc != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010481,'".AddSlashes(pg_result($resaco,$conresaco,'si88_quantacrescdecresc'))."','$this->si88_quantacrescdecresc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_valorunitarioitem"]) || $this->si88_valorunitarioitem != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010482,'".AddSlashes(pg_result($resaco,$conresaco,'si88_valorunitarioitem'))."','$this->si88_valorunitarioitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_mes"]) || $this->si88_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010483,'".AddSlashes(pg_result($resaco,$conresaco,'si88_mes'))."','$this->si88_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_reg20"]) || $this->si88_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2010484,'".AddSlashes(pg_result($resaco,$conresaco,'si88_reg20'))."','$this->si88_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si88_instit"]) || $this->si88_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010317,2011601,'".AddSlashes(pg_result($resaco,$conresaco,'si88_instit'))."','$this->si88_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos212017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si88_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos212017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si88_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si88_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si88_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si88_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010476,'$si88_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010317,2010476,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010477,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010478,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_codaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010479,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010480,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_tipoalteracaoitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010481,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_quantacrescdecresc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010482,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_valorunitarioitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010483,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2010484,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010317,2011601,'','".AddSlashes(pg_result($resaco,$iresaco,'si88_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos212017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si88_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si88_sequencial = $si88_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos212017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si88_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos212017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si88_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si88_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:contratos212017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si88_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos212017 ";
     $sql .= "      left  join contratos202017  on  contratos202017.si87_sequencial = contratos212017.si88_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si88_sequencial!=null ){
         $sql2 .= " where contratos212017.si88_sequencial = $si88_sequencial "; 
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
   function sql_query_file ( $si88_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos212017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si88_sequencial!=null ){
         $sql2 .= " where contratos212017.si88_sequencial = $si88_sequencial "; 
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
