<?
//MODULO: sicom
//CLASSE DA ENTIDADE lqd122016
class cl_lqd122016 { 
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
   var $si120_sequencial = 0; 
   var $si120_tiporegistro = 0; 
   var $si120_codreduzido = 0; 
   var $si120_mescompetencia = null; 
   var $si120_exerciciocompetencia = 0; 
   var $si120_vldspexerant = 0; 
   var $si120_mes = 0; 
   var $si120_reg10 = 0; 
   var $si120_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si120_sequencial = int8 = sequencial 
                 si120_tiporegistro = int8 = Tipo do registro 
                 si120_codreduzido = int8 = Código Identificador do registro 
                 si120_mescompetencia = varchar(2) = Mês de  competência 
                 si120_exerciciocompetencia = int8 = Exercício de competência 
                 si120_vldspexerant = float8 = Valor da despesa  de exercícios 
                 si120_mes = int8 = Mês 
                 si120_reg10 = int8 = reg10 
                 si120_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_lqd122016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("lqd122016"); 
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
       $this->si120_sequencial = ($this->si120_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_sequencial"]:$this->si120_sequencial);
       $this->si120_tiporegistro = ($this->si120_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_tiporegistro"]:$this->si120_tiporegistro);
       $this->si120_codreduzido = ($this->si120_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_codreduzido"]:$this->si120_codreduzido);
       $this->si120_mescompetencia = ($this->si120_mescompetencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_mescompetencia"]:$this->si120_mescompetencia);
       $this->si120_exerciciocompetencia = ($this->si120_exerciciocompetencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_exerciciocompetencia"]:$this->si120_exerciciocompetencia);
       $this->si120_vldspexerant = ($this->si120_vldspexerant == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_vldspexerant"]:$this->si120_vldspexerant);
       $this->si120_mes = ($this->si120_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_mes"]:$this->si120_mes);
       $this->si120_reg10 = ($this->si120_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_reg10"]:$this->si120_reg10);
       $this->si120_instit = ($this->si120_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_instit"]:$this->si120_instit);
     }else{
       $this->si120_sequencial = ($this->si120_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si120_sequencial"]:$this->si120_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si120_sequencial){ 
      $this->atualizacampos();
     if($this->si120_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si120_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si120_codreduzido == null ){ 
       $this->si120_codreduzido = "0";
     }
     if($this->si120_exerciciocompetencia == null ){ 
       $this->si120_exerciciocompetencia = "0";
     }
     if($this->si120_vldspexerant == null ){ 
       $this->si120_vldspexerant = "0";
     }
     if($this->si120_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si120_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si120_reg10 == null ){ 
       $this->si120_reg10 = "0";
     }
     if($this->si120_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si120_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si120_sequencial == "" || $si120_sequencial == null ){
       $result = db_query("select nextval('lqd122016_si120_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: lqd122016_si120_sequencial_seq do campo: si120_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si120_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from lqd122016_si120_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si120_sequencial)){
         $this->erro_sql = " Campo si120_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si120_sequencial = $si120_sequencial; 
       }
     }
     if(($this->si120_sequencial == null) || ($this->si120_sequencial == "") ){ 
       $this->erro_sql = " Campo si120_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into lqd122016(
                                       si120_sequencial 
                                      ,si120_tiporegistro 
                                      ,si120_codreduzido 
                                      ,si120_mescompetencia 
                                      ,si120_exerciciocompetencia 
                                      ,si120_vldspexerant 
                                      ,si120_mes 
                                      ,si120_reg10 
                                      ,si120_instit 
                       )
                values (
                                $this->si120_sequencial 
                               ,$this->si120_tiporegistro 
                               ,$this->si120_codreduzido 
                               ,'$this->si120_mescompetencia' 
                               ,$this->si120_exerciciocompetencia 
                               ,$this->si120_vldspexerant 
                               ,$this->si120_mes 
                               ,$this->si120_reg10 
                               ,$this->si120_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "lqd122016 ($this->si120_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "lqd122016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "lqd122016 ($this->si120_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si120_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si120_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010806,'$this->si120_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010349,2010806,'','".AddSlashes(pg_result($resaco,0,'si120_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2010807,'','".AddSlashes(pg_result($resaco,0,'si120_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2010808,'','".AddSlashes(pg_result($resaco,0,'si120_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2010809,'','".AddSlashes(pg_result($resaco,0,'si120_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2010810,'','".AddSlashes(pg_result($resaco,0,'si120_exerciciocompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2010811,'','".AddSlashes(pg_result($resaco,0,'si120_vldspexerant'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2010812,'','".AddSlashes(pg_result($resaco,0,'si120_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2010813,'','".AddSlashes(pg_result($resaco,0,'si120_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010349,2011633,'','".AddSlashes(pg_result($resaco,0,'si120_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si120_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update lqd122016 set ";
     $virgula = "";
     if(trim($this->si120_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_sequencial"])){ 
        if(trim($this->si120_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si120_sequencial"])){ 
           $this->si120_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si120_sequencial = $this->si120_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si120_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_tiporegistro"])){ 
       $sql  .= $virgula." si120_tiporegistro = $this->si120_tiporegistro ";
       $virgula = ",";
       if(trim($this->si120_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si120_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si120_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_codreduzido"])){ 
        if(trim($this->si120_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si120_codreduzido"])){ 
           $this->si120_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si120_codreduzido = $this->si120_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si120_mescompetencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_mescompetencia"])){ 
       $sql  .= $virgula." si120_mescompetencia = '$this->si120_mescompetencia' ";
       $virgula = ",";
     }
     if(trim($this->si120_exerciciocompetencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_exerciciocompetencia"])){ 
        if(trim($this->si120_exerciciocompetencia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si120_exerciciocompetencia"])){ 
           $this->si120_exerciciocompetencia = "0" ; 
        } 
       $sql  .= $virgula." si120_exerciciocompetencia = $this->si120_exerciciocompetencia ";
       $virgula = ",";
     }
     if(trim($this->si120_vldspexerant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_vldspexerant"])){ 
        if(trim($this->si120_vldspexerant)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si120_vldspexerant"])){ 
           $this->si120_vldspexerant = "0" ; 
        } 
       $sql  .= $virgula." si120_vldspexerant = $this->si120_vldspexerant ";
       $virgula = ",";
     }
     if(trim($this->si120_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_mes"])){ 
       $sql  .= $virgula." si120_mes = $this->si120_mes ";
       $virgula = ",";
       if(trim($this->si120_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si120_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si120_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_reg10"])){ 
        if(trim($this->si120_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si120_reg10"])){ 
           $this->si120_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si120_reg10 = $this->si120_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si120_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si120_instit"])){ 
       $sql  .= $virgula." si120_instit = $this->si120_instit ";
       $virgula = ",";
       if(trim($this->si120_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si120_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si120_sequencial!=null){
       $sql .= " si120_sequencial = $this->si120_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si120_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010806,'$this->si120_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_sequencial"]) || $this->si120_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010806,'".AddSlashes(pg_result($resaco,$conresaco,'si120_sequencial'))."','$this->si120_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_tiporegistro"]) || $this->si120_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010807,'".AddSlashes(pg_result($resaco,$conresaco,'si120_tiporegistro'))."','$this->si120_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_codreduzido"]) || $this->si120_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010808,'".AddSlashes(pg_result($resaco,$conresaco,'si120_codreduzido'))."','$this->si120_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_mescompetencia"]) || $this->si120_mescompetencia != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010809,'".AddSlashes(pg_result($resaco,$conresaco,'si120_mescompetencia'))."','$this->si120_mescompetencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_exerciciocompetencia"]) || $this->si120_exerciciocompetencia != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010810,'".AddSlashes(pg_result($resaco,$conresaco,'si120_exerciciocompetencia'))."','$this->si120_exerciciocompetencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_vldspexerant"]) || $this->si120_vldspexerant != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010811,'".AddSlashes(pg_result($resaco,$conresaco,'si120_vldspexerant'))."','$this->si120_vldspexerant',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_mes"]) || $this->si120_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010812,'".AddSlashes(pg_result($resaco,$conresaco,'si120_mes'))."','$this->si120_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_reg10"]) || $this->si120_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2010813,'".AddSlashes(pg_result($resaco,$conresaco,'si120_reg10'))."','$this->si120_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si120_instit"]) || $this->si120_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010349,2011633,'".AddSlashes(pg_result($resaco,$conresaco,'si120_instit'))."','$this->si120_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "lqd122016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si120_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "lqd122016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si120_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si120_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si120_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si120_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010806,'$si120_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010349,2010806,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2010807,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2010808,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2010809,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2010810,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_exerciciocompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2010811,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_vldspexerant'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2010812,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2010813,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010349,2011633,'','".AddSlashes(pg_result($resaco,$iresaco,'si120_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from lqd122016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si120_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si120_sequencial = $si120_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "lqd122016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si120_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "lqd122016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si120_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si120_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:lqd122016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si120_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lqd122016 ";
     $sql .= "      left  join lqd102016  on  lqd102016.si118_sequencial = lqd122016.si120_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si120_sequencial!=null ){
         $sql2 .= " where lqd122016.si120_sequencial = $si120_sequencial "; 
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
   function sql_query_file ( $si120_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lqd122016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si120_sequencial!=null ){
         $sql2 .= " where lqd122016.si120_sequencial = $si120_sequencial "; 
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
