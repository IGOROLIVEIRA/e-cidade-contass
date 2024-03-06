<?
//MODULO: sicom
//CLASSE DA ENTIDADE rsp222016
class cl_rsp222016 { 
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
   var $si117_sequencial = 0; 
   var $si117_tiporegistro = 0; 
   var $si117_codreduzidomov = 0; 
   var $si117_tipodocumento = 0; 
   var $si117_nrodocumento = null; 
   var $si117_mes = 0; 
   var $si117_reg20 = 0; 
   var $si117_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si117_sequencial = int8 = sequencial 
                 si117_tiporegistro = int8 = Tipo do  registro 
                 si117_codreduzidomov = int8 = Código Identificador da Movimentação 
                 si117_tipodocumento = int8 = Tipo de  Documento 
                 si117_nrodocumento = varchar(14) = Número do  documento 
                 si117_mes = int8 = Mês 
                 si117_reg20 = int8 = reg20 
                 si117_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_rsp222016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rsp222016"); 
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
       $this->si117_sequencial = ($this->si117_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_sequencial"]:$this->si117_sequencial);
       $this->si117_tiporegistro = ($this->si117_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_tiporegistro"]:$this->si117_tiporegistro);
       $this->si117_codreduzidomov = ($this->si117_codreduzidomov == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_codreduzidomov"]:$this->si117_codreduzidomov);
       $this->si117_tipodocumento = ($this->si117_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_tipodocumento"]:$this->si117_tipodocumento);
       $this->si117_nrodocumento = ($this->si117_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_nrodocumento"]:$this->si117_nrodocumento);
       $this->si117_mes = ($this->si117_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_mes"]:$this->si117_mes);
       $this->si117_reg20 = ($this->si117_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_reg20"]:$this->si117_reg20);
       $this->si117_instit = ($this->si117_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_instit"]:$this->si117_instit);
     }else{
       $this->si117_sequencial = ($this->si117_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si117_sequencial"]:$this->si117_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si117_sequencial){ 
      $this->atualizacampos();
     if($this->si117_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si117_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si117_codreduzidomov == null ){ 
       $this->si117_codreduzidomov = "0";
     }
     if($this->si117_tipodocumento == null ){ 
       $this->si117_tipodocumento = "0";
     }
     if($this->si117_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si117_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si117_reg20 == null ){ 
       $this->si117_reg20 = "0";
     }
     if($this->si117_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si117_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si117_sequencial == "" || $si117_sequencial == null ){
       $result = db_query("select nextval('rsp222016_si117_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rsp222016_si117_sequencial_seq do campo: si117_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si117_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from rsp222016_si117_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si117_sequencial)){
         $this->erro_sql = " Campo si117_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si117_sequencial = $si117_sequencial; 
       }
     }
     if(($this->si117_sequencial == null) || ($this->si117_sequencial == "") ){ 
       $this->erro_sql = " Campo si117_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rsp222016(
                                       si117_sequencial 
                                      ,si117_tiporegistro 
                                      ,si117_codreduzidomov 
                                      ,si117_tipodocumento 
                                      ,si117_nrodocumento 
                                      ,si117_mes 
                                      ,si117_reg20 
                                      ,si117_instit 
                       )
                values (
                                $this->si117_sequencial 
                               ,$this->si117_tiporegistro 
                               ,$this->si117_codreduzidomov 
                               ,$this->si117_tipodocumento 
                               ,'$this->si117_nrodocumento' 
                               ,$this->si117_mes 
                               ,$this->si117_reg20 
                               ,$this->si117_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "rsp222016 ($this->si117_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "rsp222016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "rsp222016 ($this->si117_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si117_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si117_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010779,'$this->si117_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010346,2010779,'','".AddSlashes(pg_result($resaco,0,'si117_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010346,2010780,'','".AddSlashes(pg_result($resaco,0,'si117_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010346,2010781,'','".AddSlashes(pg_result($resaco,0,'si117_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010346,2010782,'','".AddSlashes(pg_result($resaco,0,'si117_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010346,2010783,'','".AddSlashes(pg_result($resaco,0,'si117_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010346,2010784,'','".AddSlashes(pg_result($resaco,0,'si117_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010346,2010785,'','".AddSlashes(pg_result($resaco,0,'si117_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010346,2011630,'','".AddSlashes(pg_result($resaco,0,'si117_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si117_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rsp222016 set ";
     $virgula = "";
     if(trim($this->si117_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_sequencial"])){ 
        if(trim($this->si117_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si117_sequencial"])){ 
           $this->si117_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si117_sequencial = $this->si117_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si117_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_tiporegistro"])){ 
       $sql  .= $virgula." si117_tiporegistro = $this->si117_tiporegistro ";
       $virgula = ",";
       if(trim($this->si117_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si117_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si117_codreduzidomov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_codreduzidomov"])){ 
        if(trim($this->si117_codreduzidomov)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si117_codreduzidomov"])){ 
           $this->si117_codreduzidomov = "0" ; 
        } 
       $sql  .= $virgula." si117_codreduzidomov = $this->si117_codreduzidomov ";
       $virgula = ",";
     }
     if(trim($this->si117_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_tipodocumento"])){ 
        if(trim($this->si117_tipodocumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si117_tipodocumento"])){ 
           $this->si117_tipodocumento = "0" ; 
        } 
       $sql  .= $virgula." si117_tipodocumento = $this->si117_tipodocumento ";
       $virgula = ",";
     }
     if(trim($this->si117_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_nrodocumento"])){ 
       $sql  .= $virgula." si117_nrodocumento = '$this->si117_nrodocumento' ";
       $virgula = ",";
     }
     if(trim($this->si117_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_mes"])){ 
       $sql  .= $virgula." si117_mes = $this->si117_mes ";
       $virgula = ",";
       if(trim($this->si117_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si117_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si117_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_reg20"])){ 
        if(trim($this->si117_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si117_reg20"])){ 
           $this->si117_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si117_reg20 = $this->si117_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si117_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si117_instit"])){ 
       $sql  .= $virgula." si117_instit = $this->si117_instit ";
       $virgula = ",";
       if(trim($this->si117_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si117_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si117_sequencial!=null){
       $sql .= " si117_sequencial = $this->si117_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si117_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010779,'$this->si117_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_sequencial"]) || $this->si117_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2010779,'".AddSlashes(pg_result($resaco,$conresaco,'si117_sequencial'))."','$this->si117_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_tiporegistro"]) || $this->si117_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2010780,'".AddSlashes(pg_result($resaco,$conresaco,'si117_tiporegistro'))."','$this->si117_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_codreduzidomov"]) || $this->si117_codreduzidomov != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2010781,'".AddSlashes(pg_result($resaco,$conresaco,'si117_codreduzidomov'))."','$this->si117_codreduzidomov',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_tipodocumento"]) || $this->si117_tipodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2010782,'".AddSlashes(pg_result($resaco,$conresaco,'si117_tipodocumento'))."','$this->si117_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_nrodocumento"]) || $this->si117_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2010783,'".AddSlashes(pg_result($resaco,$conresaco,'si117_nrodocumento'))."','$this->si117_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_mes"]) || $this->si117_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2010784,'".AddSlashes(pg_result($resaco,$conresaco,'si117_mes'))."','$this->si117_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_reg20"]) || $this->si117_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2010785,'".AddSlashes(pg_result($resaco,$conresaco,'si117_reg20'))."','$this->si117_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si117_instit"]) || $this->si117_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010346,2011630,'".AddSlashes(pg_result($resaco,$conresaco,'si117_instit'))."','$this->si117_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rsp222016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si117_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rsp222016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si117_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si117_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si117_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si117_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010779,'$si117_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010346,2010779,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010346,2010780,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010346,2010781,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010346,2010782,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010346,2010783,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010346,2010784,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010346,2010785,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010346,2011630,'','".AddSlashes(pg_result($resaco,$iresaco,'si117_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from rsp222016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si117_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si117_sequencial = $si117_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rsp222016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si117_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rsp222016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si117_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si117_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rsp222016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si117_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rsp222016 ";
     $sql .= "      left  join rsp202016  on  rsp202016.si115_sequencial = rsp222016.si117_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si117_sequencial!=null ){
         $sql2 .= " where rsp222016.si117_sequencial = $si117_sequencial "; 
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
   function sql_query_file ( $si117_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rsp222016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si117_sequencial!=null ){
         $sql2 .= " where rsp222016.si117_sequencial = $si117_sequencial "; 
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
