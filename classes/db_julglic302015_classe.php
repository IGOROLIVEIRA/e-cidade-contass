<?
//MODULO: sicom
//CLASSE DA ENTIDADE julglic302015
class cl_julglic302015 { 
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
   var $si62_sequencial = 0; 
   var $si62_tiporegistro = 0; 
   var $si62_codorgao = null; 
   var $si62_codunidadesub = null; 
   var $si62_exerciciolicitacao = 0; 
   var $si62_nroprocessolicitatorio = null; 
   var $si62_dtjulgamento_dia = null; 
   var $si62_dtjulgamento_mes = null; 
   var $si62_dtjulgamento_ano = null; 
   var $si62_dtjulgamento = null; 
   var $si62_presencalicitantes = 0; 
   var $si62_renunciarecurso = 0; 
   var $si62_mes = 0; 
   var $si62_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si62_sequencial = int8 = sequencial 
                 si62_tiporegistro = int8 = Tipo do registro 
                 si62_codorgao = varchar(2) = Código do órgão 
                 si62_codunidadesub = varchar(8) = Código da unidade 
                 si62_exerciciolicitacao = int8 = Exercício em que foi instaurado 
                 si62_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si62_dtjulgamento = date = Data do julgamento 
                 si62_presencalicitantes = int8 = Presenca Licitantes 
                 si62_renunciarecurso = int8 = Renuncia Recurso 
                 si62_mes = int8 = Mês 
                 si62_instit = int4 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_julglic302015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("julglic302015"); 
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
       $this->si62_sequencial = ($this->si62_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_sequencial"]:$this->si62_sequencial);
       $this->si62_tiporegistro = ($this->si62_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_tiporegistro"]:$this->si62_tiporegistro);
       $this->si62_codorgao = ($this->si62_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_codorgao"]:$this->si62_codorgao);
       $this->si62_codunidadesub = ($this->si62_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_codunidadesub"]:$this->si62_codunidadesub);
       $this->si62_exerciciolicitacao = ($this->si62_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_exerciciolicitacao"]:$this->si62_exerciciolicitacao);
       $this->si62_nroprocessolicitatorio = ($this->si62_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_nroprocessolicitatorio"]:$this->si62_nroprocessolicitatorio);
       if($this->si62_dtjulgamento == ""){
         $this->si62_dtjulgamento_dia = ($this->si62_dtjulgamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_dtjulgamento_dia"]:$this->si62_dtjulgamento_dia);
         $this->si62_dtjulgamento_mes = ($this->si62_dtjulgamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_dtjulgamento_mes"]:$this->si62_dtjulgamento_mes);
         $this->si62_dtjulgamento_ano = ($this->si62_dtjulgamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_dtjulgamento_ano"]:$this->si62_dtjulgamento_ano);
         if($this->si62_dtjulgamento_dia != ""){
            $this->si62_dtjulgamento = $this->si62_dtjulgamento_ano."-".$this->si62_dtjulgamento_mes."-".$this->si62_dtjulgamento_dia;
         }
       }
       $this->si62_presencalicitantes = ($this->si62_presencalicitantes == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_presencalicitantes"]:$this->si62_presencalicitantes);
       $this->si62_renunciarecurso = ($this->si62_renunciarecurso == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_renunciarecurso"]:$this->si62_renunciarecurso);
       $this->si62_mes = ($this->si62_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_mes"]:$this->si62_mes);
       $this->si62_instit = ($this->si62_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_instit"]:$this->si62_instit);
     }else{
       $this->si62_sequencial = ($this->si62_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si62_sequencial"]:$this->si62_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si62_sequencial){ 
      $this->atualizacampos();
     if($this->si62_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si62_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si62_exerciciolicitacao == null ){ 
       $this->si62_exerciciolicitacao = "0";
     }
     if($this->si62_dtjulgamento == null ){ 
       $this->si62_dtjulgamento = "null";
     }
     if($this->si62_presencalicitantes == null ){ 
       $this->si62_presencalicitantes = "0";
     }
     if($this->si62_renunciarecurso == null ){ 
       $this->si62_renunciarecurso = "0";
     }
     if($this->si62_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si62_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si62_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si62_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si62_sequencial == "" || $si62_sequencial == null ){
       $result = db_query("select nextval('julglic302015_si62_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: julglic302015_si62_sequencial_seq do campo: si62_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si62_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from julglic302015_si62_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si62_sequencial)){
         $this->erro_sql = " Campo si62_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si62_sequencial = $si62_sequencial; 
       }
     }
     if(($this->si62_sequencial == null) || ($this->si62_sequencial == "") ){ 
       $this->erro_sql = " Campo si62_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into julglic302015(
                                       si62_sequencial 
                                      ,si62_tiporegistro 
                                      ,si62_codorgao 
                                      ,si62_codunidadesub 
                                      ,si62_exerciciolicitacao 
                                      ,si62_nroprocessolicitatorio 
                                      ,si62_dtjulgamento 
                                      ,si62_presencalicitantes 
                                      ,si62_renunciarecurso 
                                      ,si62_mes 
                                      ,si62_instit 
                       )
                values (
                                $this->si62_sequencial 
                               ,$this->si62_tiporegistro 
                               ,'$this->si62_codorgao' 
                               ,'$this->si62_codunidadesub' 
                               ,$this->si62_exerciciolicitacao 
                               ,'$this->si62_nroprocessolicitatorio' 
                               ,".($this->si62_dtjulgamento == "null" || $this->si62_dtjulgamento == ""?"null":"'".$this->si62_dtjulgamento."'")." 
                               ,$this->si62_presencalicitantes 
                               ,$this->si62_renunciarecurso 
                               ,$this->si62_mes 
                               ,$this->si62_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "julglic302015 ($this->si62_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "julglic302015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "julglic302015 ($this->si62_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si62_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si62_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010109,'$this->si62_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010291,2010109,'','".AddSlashes(pg_result($resaco,0,'si62_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010110,'','".AddSlashes(pg_result($resaco,0,'si62_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010111,'','".AddSlashes(pg_result($resaco,0,'si62_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010112,'','".AddSlashes(pg_result($resaco,0,'si62_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010113,'','".AddSlashes(pg_result($resaco,0,'si62_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010114,'','".AddSlashes(pg_result($resaco,0,'si62_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010115,'','".AddSlashes(pg_result($resaco,0,'si62_dtjulgamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010116,'','".AddSlashes(pg_result($resaco,0,'si62_presencalicitantes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010117,'','".AddSlashes(pg_result($resaco,0,'si62_renunciarecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2010118,'','".AddSlashes(pg_result($resaco,0,'si62_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010291,2011574,'','".AddSlashes(pg_result($resaco,0,'si62_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si62_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update julglic302015 set ";
     $virgula = "";
     if(trim($this->si62_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_sequencial"])){ 
        if(trim($this->si62_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si62_sequencial"])){ 
           $this->si62_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si62_sequencial = $this->si62_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si62_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_tiporegistro"])){ 
       $sql  .= $virgula." si62_tiporegistro = $this->si62_tiporegistro ";
       $virgula = ",";
       if(trim($this->si62_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si62_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si62_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_codorgao"])){ 
       $sql  .= $virgula." si62_codorgao = '$this->si62_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si62_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_codunidadesub"])){ 
       $sql  .= $virgula." si62_codunidadesub = '$this->si62_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si62_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_exerciciolicitacao"])){ 
        if(trim($this->si62_exerciciolicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si62_exerciciolicitacao"])){ 
           $this->si62_exerciciolicitacao = "0" ; 
        } 
       $sql  .= $virgula." si62_exerciciolicitacao = $this->si62_exerciciolicitacao ";
       $virgula = ",";
     }
     if(trim($this->si62_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_nroprocessolicitatorio"])){ 
       $sql  .= $virgula." si62_nroprocessolicitatorio = '$this->si62_nroprocessolicitatorio' ";
       $virgula = ",";
     }
     if(trim($this->si62_dtjulgamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_dtjulgamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si62_dtjulgamento_dia"] !="") ){ 
       $sql  .= $virgula." si62_dtjulgamento = '$this->si62_dtjulgamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si62_dtjulgamento_dia"])){ 
         $sql  .= $virgula." si62_dtjulgamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si62_presencalicitantes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_presencalicitantes"])){ 
        if(trim($this->si62_presencalicitantes)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si62_presencalicitantes"])){ 
           $this->si62_presencalicitantes = "0" ; 
        } 
       $sql  .= $virgula." si62_presencalicitantes = $this->si62_presencalicitantes ";
       $virgula = ",";
     }
     if(trim($this->si62_renunciarecurso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_renunciarecurso"])){ 
        if(trim($this->si62_renunciarecurso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si62_renunciarecurso"])){ 
           $this->si62_renunciarecurso = "0" ; 
        } 
       $sql  .= $virgula." si62_renunciarecurso = $this->si62_renunciarecurso ";
       $virgula = ",";
     }
     if(trim($this->si62_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_mes"])){ 
       $sql  .= $virgula." si62_mes = $this->si62_mes ";
       $virgula = ",";
       if(trim($this->si62_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si62_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si62_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si62_instit"])){ 
       $sql  .= $virgula." si62_instit = $this->si62_instit ";
       $virgula = ",";
       if(trim($this->si62_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si62_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si62_sequencial!=null){
       $sql .= " si62_sequencial = $this->si62_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si62_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010109,'$this->si62_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_sequencial"]) || $this->si62_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010109,'".AddSlashes(pg_result($resaco,$conresaco,'si62_sequencial'))."','$this->si62_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_tiporegistro"]) || $this->si62_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010110,'".AddSlashes(pg_result($resaco,$conresaco,'si62_tiporegistro'))."','$this->si62_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_codorgao"]) || $this->si62_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010111,'".AddSlashes(pg_result($resaco,$conresaco,'si62_codorgao'))."','$this->si62_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_codunidadesub"]) || $this->si62_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010112,'".AddSlashes(pg_result($resaco,$conresaco,'si62_codunidadesub'))."','$this->si62_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_exerciciolicitacao"]) || $this->si62_exerciciolicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010113,'".AddSlashes(pg_result($resaco,$conresaco,'si62_exerciciolicitacao'))."','$this->si62_exerciciolicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_nroprocessolicitatorio"]) || $this->si62_nroprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010114,'".AddSlashes(pg_result($resaco,$conresaco,'si62_nroprocessolicitatorio'))."','$this->si62_nroprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_dtjulgamento"]) || $this->si62_dtjulgamento != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010115,'".AddSlashes(pg_result($resaco,$conresaco,'si62_dtjulgamento'))."','$this->si62_dtjulgamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_presencalicitantes"]) || $this->si62_presencalicitantes != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010116,'".AddSlashes(pg_result($resaco,$conresaco,'si62_presencalicitantes'))."','$this->si62_presencalicitantes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_renunciarecurso"]) || $this->si62_renunciarecurso != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010117,'".AddSlashes(pg_result($resaco,$conresaco,'si62_renunciarecurso'))."','$this->si62_renunciarecurso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_mes"]) || $this->si62_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2010118,'".AddSlashes(pg_result($resaco,$conresaco,'si62_mes'))."','$this->si62_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si62_instit"]) || $this->si62_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010291,2011574,'".AddSlashes(pg_result($resaco,$conresaco,'si62_instit'))."','$this->si62_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "julglic302015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si62_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "julglic302015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si62_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si62_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si62_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si62_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010109,'$si62_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010291,2010109,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010110,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010111,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010112,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010113,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010114,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010115,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_dtjulgamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010116,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_presencalicitantes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010117,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_renunciarecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2010118,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010291,2011574,'','".AddSlashes(pg_result($resaco,$iresaco,'si62_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from julglic302015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si62_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si62_sequencial = $si62_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "julglic302015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si62_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "julglic302015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si62_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si62_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:julglic302015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si62_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from julglic302015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si62_sequencial!=null ){
         $sql2 .= " where julglic302015.si62_sequencial = $si62_sequencial "; 
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
   function sql_query_file ( $si62_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from julglic302015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si62_sequencial!=null ){
         $sql2 .= " where julglic302015.si62_sequencial = $si62_sequencial "; 
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
