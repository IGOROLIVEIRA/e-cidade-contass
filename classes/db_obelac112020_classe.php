<?
//MODULO: sicom
//CLASSE DA ENTIDADE obelac112020
class cl_obelac112020 { 
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
   var $si140_sequencial = 0; 
   var $si140_tiporegistro = 0; 
   var $si140_codreduzido = 0; 
   var $si140_codfontrecursos = 0; 
   var $si140_valorfonte = 0; 
   var $si140_mes = 0; 
   var $si140_reg10 = 0; 
   var $si140_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si140_sequencial = int8 = sequencial 
                 si140_tiporegistro = int8 = Tipo do  registro 
                 si140_codreduzido = int8 = Código Identificador do registro 
                 si140_codfontrecursos = int8 = Código da fonte de  recursos 
                 si140_valorfonte = float8 = Valor do  Lançamento 
                 si140_mes = int8 = Mês 
                 si140_reg10 = int8 = reg10 
                 si140_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_obelac112020() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("obelac112020"); 
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
       $this->si140_sequencial = ($this->si140_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_sequencial"]:$this->si140_sequencial);
       $this->si140_tiporegistro = ($this->si140_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_tiporegistro"]:$this->si140_tiporegistro);
       $this->si140_codreduzido = ($this->si140_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_codreduzido"]:$this->si140_codreduzido);
       $this->si140_codfontrecursos = ($this->si140_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_codfontrecursos"]:$this->si140_codfontrecursos);
       $this->si140_valorfonte = ($this->si140_valorfonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_valorfonte"]:$this->si140_valorfonte);
       $this->si140_mes = ($this->si140_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_mes"]:$this->si140_mes);
       $this->si140_reg10 = ($this->si140_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_reg10"]:$this->si140_reg10);
       $this->si140_instit = ($this->si140_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_instit"]:$this->si140_instit);
     }else{
       $this->si140_sequencial = ($this->si140_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si140_sequencial"]:$this->si140_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si140_sequencial){ 
      $this->atualizacampos();
     if($this->si140_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si140_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si140_codreduzido == null ){ 
       $this->si140_codreduzido = "0";
     }
     if($this->si140_codfontrecursos == null ){ 
       $this->si140_codfontrecursos = "0";
     }
     if($this->si140_valorfonte == null ){ 
       $this->si140_valorfonte = "0";
     }
     if($this->si140_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si140_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si140_reg10 == null ){ 
       $this->si140_reg10 = "0";
     }
     if($this->si140_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si140_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si140_sequencial == "" || $si140_sequencial == null ){
       $result = db_query("select nextval('obelac112020_si140_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: obelac112020_si140_sequencial_seq do campo: si140_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si140_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from obelac112020_si140_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si140_sequencial)){
         $this->erro_sql = " Campo si140_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si140_sequencial = $si140_sequencial; 
       }
     }
     if(($this->si140_sequencial == null) || ($this->si140_sequencial == "") ){ 
       $this->erro_sql = " Campo si140_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into obelac112020(
                                       si140_sequencial 
                                      ,si140_tiporegistro 
                                      ,si140_codreduzido 
                                      ,si140_codfontrecursos 
                                      ,si140_valorfonte 
                                      ,si140_mes 
                                      ,si140_reg10 
                                      ,si140_instit 
                       )
                values (
                                $this->si140_sequencial 
                               ,$this->si140_tiporegistro 
                               ,$this->si140_codreduzido 
                               ,$this->si140_codfontrecursos 
                               ,$this->si140_valorfonte 
                               ,$this->si140_mes 
                               ,$this->si140_reg10 
                               ,$this->si140_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "obelac112020 ($this->si140_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "obelac112020 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "obelac112020 ($this->si140_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si140_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si140_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011023,'$this->si140_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010369,2011023,'','".AddSlashes(pg_result($resaco,0,'si140_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010369,2011024,'','".AddSlashes(pg_result($resaco,0,'si140_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010369,2011025,'','".AddSlashes(pg_result($resaco,0,'si140_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010369,2011026,'','".AddSlashes(pg_result($resaco,0,'si140_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010369,2011027,'','".AddSlashes(pg_result($resaco,0,'si140_valorfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010369,2011028,'','".AddSlashes(pg_result($resaco,0,'si140_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010369,2011029,'','".AddSlashes(pg_result($resaco,0,'si140_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010369,2011653,'','".AddSlashes(pg_result($resaco,0,'si140_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si140_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update obelac112020 set ";
     $virgula = "";
     if(trim($this->si140_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_sequencial"])){ 
        if(trim($this->si140_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si140_sequencial"])){ 
           $this->si140_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si140_sequencial = $this->si140_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si140_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_tiporegistro"])){ 
       $sql  .= $virgula." si140_tiporegistro = $this->si140_tiporegistro ";
       $virgula = ",";
       if(trim($this->si140_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si140_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si140_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_codreduzido"])){ 
        if(trim($this->si140_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si140_codreduzido"])){ 
           $this->si140_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si140_codreduzido = $this->si140_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si140_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_codfontrecursos"])){ 
        if(trim($this->si140_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si140_codfontrecursos"])){ 
           $this->si140_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si140_codfontrecursos = $this->si140_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si140_valorfonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_valorfonte"])){ 
        if(trim($this->si140_valorfonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si140_valorfonte"])){ 
           $this->si140_valorfonte = "0" ; 
        } 
       $sql  .= $virgula." si140_valorfonte = $this->si140_valorfonte ";
       $virgula = ",";
     }
     if(trim($this->si140_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_mes"])){ 
       $sql  .= $virgula." si140_mes = $this->si140_mes ";
       $virgula = ",";
       if(trim($this->si140_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si140_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si140_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_reg10"])){ 
        if(trim($this->si140_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si140_reg10"])){ 
           $this->si140_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si140_reg10 = $this->si140_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si140_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si140_instit"])){ 
       $sql  .= $virgula." si140_instit = $this->si140_instit ";
       $virgula = ",";
       if(trim($this->si140_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si140_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si140_sequencial!=null){
       $sql .= " si140_sequencial = $this->si140_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si140_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011023,'$this->si140_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_sequencial"]) || $this->si140_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011023,'".AddSlashes(pg_result($resaco,$conresaco,'si140_sequencial'))."','$this->si140_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_tiporegistro"]) || $this->si140_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011024,'".AddSlashes(pg_result($resaco,$conresaco,'si140_tiporegistro'))."','$this->si140_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_codreduzido"]) || $this->si140_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011025,'".AddSlashes(pg_result($resaco,$conresaco,'si140_codreduzido'))."','$this->si140_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_codfontrecursos"]) || $this->si140_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011026,'".AddSlashes(pg_result($resaco,$conresaco,'si140_codfontrecursos'))."','$this->si140_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_valorfonte"]) || $this->si140_valorfonte != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011027,'".AddSlashes(pg_result($resaco,$conresaco,'si140_valorfonte'))."','$this->si140_valorfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_mes"]) || $this->si140_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011028,'".AddSlashes(pg_result($resaco,$conresaco,'si140_mes'))."','$this->si140_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_reg10"]) || $this->si140_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011029,'".AddSlashes(pg_result($resaco,$conresaco,'si140_reg10'))."','$this->si140_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si140_instit"]) || $this->si140_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010369,2011653,'".AddSlashes(pg_result($resaco,$conresaco,'si140_instit'))."','$this->si140_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "obelac112020 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si140_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "obelac112020 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si140_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si140_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si140_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si140_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011023,'$si140_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010369,2011023,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010369,2011024,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010369,2011025,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010369,2011026,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010369,2011027,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_valorfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010369,2011028,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010369,2011029,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010369,2011653,'','".AddSlashes(pg_result($resaco,$iresaco,'si140_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from obelac112020
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si140_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si140_sequencial = $si140_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "obelac112020 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si140_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "obelac112020 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si140_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si140_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:obelac112020";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si140_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from obelac112020 ";
     $sql .= "      left  join lqd122014  on  lqd122014.si120_sequencial = obelac112020.si140_reg10";
     $sql .= "      left  join lqd102014  on  lqd102014.si118_sequencial = lqd122014.si120_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si140_sequencial!=null ){
         $sql2 .= " where obelac112020.si140_sequencial = $si140_sequencial "; 
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
   function sql_query_file ( $si140_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from obelac112020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si140_sequencial!=null ){
         $sql2 .= " where obelac112020.si140_sequencial = $si140_sequencial "; 
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
