<?
//MODULO: sicom
//CLASSE DA ENTIDADE iuoc2014
class cl_iuoc2014 { 
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
   var $si164_sequencial = 0; 
   var $si164_codorgao = null; 
   var $si164_codunidadesub = null; 
   var $si164_idfundo = null; 
   var $si164_descunidadesub = null; 
   var $si164_esubunidade = 0; 
   var $si164_mes = 0; 
   var $si164_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si164_sequencial = int8 = sequencial 
                 si164_codorgao = varchar(2) = Código do órgão 
                 si164_codunidadesub = varchar(8) = Código da unidade 
                 si164_idfundo = varchar(2) = Identificador do tipo  de fundo 
                 si164_descunidadesub = varchar(50) = Descrição da  Unidade 
                 si164_esubunidade = int8 = Identifica o registro 
                 si164_mes = int8 = Mês 
                 si164_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_iuoc2014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("iuoc2014"); 
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
       $this->si164_sequencial = ($this->si164_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_sequencial"]:$this->si164_sequencial);
       $this->si164_codorgao = ($this->si164_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_codorgao"]:$this->si164_codorgao);
       $this->si164_codunidadesub = ($this->si164_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_codunidadesub"]:$this->si164_codunidadesub);
       $this->si164_idfundo = ($this->si164_idfundo == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_idfundo"]:$this->si164_idfundo);
       $this->si164_descunidadesub = ($this->si164_descunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_descunidadesub"]:$this->si164_descunidadesub);
       $this->si164_esubunidade = ($this->si164_esubunidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_esubunidade"]:$this->si164_esubunidade);
       $this->si164_mes = ($this->si164_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_mes"]:$this->si164_mes);
       $this->si164_instit = ($this->si164_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_instit"]:$this->si164_instit);
     }else{
       $this->si164_sequencial = ($this->si164_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si164_sequencial"]:$this->si164_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si164_sequencial){ 
      $this->atualizacampos();
     if($this->si164_esubunidade == null ){ 
       $this->si164_esubunidade = "0";
     }
     if($this->si164_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si164_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si164_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si164_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si164_sequencial == "" || $si164_sequencial == null ){
       $result = db_query("select nextval('iuoc2014_si164_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: iuoc2014_si164_sequencial_seq do campo: si164_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si164_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from iuoc2014_si164_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si164_sequencial)){
         $this->erro_sql = " Campo si164_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si164_sequencial = $si164_sequencial; 
       }
     }
     if(($this->si164_sequencial == null) || ($this->si164_sequencial == "") ){ 
       $this->erro_sql = " Campo si164_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into iuoc2014(
                                       si164_sequencial 
                                      ,si164_codorgao 
                                      ,si164_codunidadesub 
                                      ,si164_idfundo 
                                      ,si164_descunidadesub 
                                      ,si164_esubunidade 
                                      ,si164_mes 
                                      ,si164_instit 
                       )
                values (
                                $this->si164_sequencial 
                               ,'$this->si164_codorgao' 
                               ,'$this->si164_codunidadesub' 
                               ,'$this->si164_idfundo' 
                               ,'$this->si164_descunidadesub' 
                               ,$this->si164_esubunidade 
                               ,$this->si164_mes 
                               ,$this->si164_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "iuoc2014 ($this->si164_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "iuoc2014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "iuoc2014 ($this->si164_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si164_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si164_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011274,'$this->si164_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010393,2011274,'','".AddSlashes(pg_result($resaco,0,'si164_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010393,2011275,'','".AddSlashes(pg_result($resaco,0,'si164_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010393,2011276,'','".AddSlashes(pg_result($resaco,0,'si164_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010393,2011277,'','".AddSlashes(pg_result($resaco,0,'si164_idfundo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010393,2011278,'','".AddSlashes(pg_result($resaco,0,'si164_descunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010393,2011279,'','".AddSlashes(pg_result($resaco,0,'si164_esubunidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010393,2011280,'','".AddSlashes(pg_result($resaco,0,'si164_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010393,2011677,'','".AddSlashes(pg_result($resaco,0,'si164_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si164_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update iuoc2014 set ";
     $virgula = "";
     if(trim($this->si164_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_sequencial"])){ 
        if(trim($this->si164_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si164_sequencial"])){ 
           $this->si164_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si164_sequencial = $this->si164_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si164_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_codorgao"])){ 
       $sql  .= $virgula." si164_codorgao = '$this->si164_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si164_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_codunidadesub"])){ 
       $sql  .= $virgula." si164_codunidadesub = '$this->si164_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si164_idfundo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_idfundo"])){ 
       $sql  .= $virgula." si164_idfundo = '$this->si164_idfundo' ";
       $virgula = ",";
     }
     if(trim($this->si164_descunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_descunidadesub"])){ 
       $sql  .= $virgula." si164_descunidadesub = '$this->si164_descunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si164_esubunidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_esubunidade"])){ 
        if(trim($this->si164_esubunidade)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si164_esubunidade"])){ 
           $this->si164_esubunidade = "0" ; 
        } 
       $sql  .= $virgula." si164_esubunidade = $this->si164_esubunidade ";
       $virgula = ",";
     }
     if(trim($this->si164_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_mes"])){ 
       $sql  .= $virgula." si164_mes = $this->si164_mes ";
       $virgula = ",";
       if(trim($this->si164_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si164_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si164_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si164_instit"])){ 
       $sql  .= $virgula." si164_instit = $this->si164_instit ";
       $virgula = ",";
       if(trim($this->si164_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si164_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si164_sequencial!=null){
       $sql .= " si164_sequencial = $this->si164_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si164_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011274,'$this->si164_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_sequencial"]) || $this->si164_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011274,'".AddSlashes(pg_result($resaco,$conresaco,'si164_sequencial'))."','$this->si164_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_codorgao"]) || $this->si164_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011275,'".AddSlashes(pg_result($resaco,$conresaco,'si164_codorgao'))."','$this->si164_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_codunidadesub"]) || $this->si164_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011276,'".AddSlashes(pg_result($resaco,$conresaco,'si164_codunidadesub'))."','$this->si164_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_idfundo"]) || $this->si164_idfundo != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011277,'".AddSlashes(pg_result($resaco,$conresaco,'si164_idfundo'))."','$this->si164_idfundo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_descunidadesub"]) || $this->si164_descunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011278,'".AddSlashes(pg_result($resaco,$conresaco,'si164_descunidadesub'))."','$this->si164_descunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_esubunidade"]) || $this->si164_esubunidade != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011279,'".AddSlashes(pg_result($resaco,$conresaco,'si164_esubunidade'))."','$this->si164_esubunidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_mes"]) || $this->si164_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011280,'".AddSlashes(pg_result($resaco,$conresaco,'si164_mes'))."','$this->si164_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si164_instit"]) || $this->si164_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010393,2011677,'".AddSlashes(pg_result($resaco,$conresaco,'si164_instit'))."','$this->si164_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "iuoc2014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si164_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "iuoc2014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si164_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si164_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si164_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si164_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011274,'$si164_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010393,2011274,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010393,2011275,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010393,2011276,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010393,2011277,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_idfundo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010393,2011278,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_descunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010393,2011279,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_esubunidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010393,2011280,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010393,2011677,'','".AddSlashes(pg_result($resaco,$iresaco,'si164_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from iuoc2014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si164_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si164_sequencial = $si164_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "iuoc2014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si164_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "iuoc2014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si164_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si164_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:iuoc2014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si164_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from iuoc2014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si164_sequencial!=null ){
         $sql2 .= " where iuoc2014.si164_sequencial = $si164_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $si164_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from iuoc2014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si164_sequencial!=null ){
         $sql2 .= " where iuoc2014.si164_sequencial = $si164_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
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
