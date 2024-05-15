<?
//MODULO: caixa
//CLASSE DA ENTIDADE concmanupendecaixa
class cl_concmanupendecaixa { 
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
   var $k201_autenticacao = 0; 
   var $k201_datapendencia_dia = null; 
   var $k201_datapendencia_mes = null; 
   var $k201_datapendencia_ano = null; 
   var $k201_datapendencia = null; 
   var $k201_conciliacao = 0; 
   var $k201_sequencial = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k201_autenticacao = int8 =  
                 k201_datapendencia = date = data pendencia 
                 k201_conciliacao = int8 =  
                 k201_sequencial = int8 = Código  sequencial 
                 ";
   //funcao construtor da classe 
   function cl_concmanupendecaixa() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("concmanupendecaixa"); 
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
       $this->k201_autenticacao = ($this->k201_autenticacao == ""?@$GLOBALS["HTTP_POST_VARS"]["k201_autenticacao"]:$this->k201_autenticacao);
       if($this->k201_datapendencia == ""){
         $this->k201_datapendencia_dia = ($this->k201_datapendencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k201_datapendencia_dia"]:$this->k201_datapendencia_dia);
         $this->k201_datapendencia_mes = ($this->k201_datapendencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k201_datapendencia_mes"]:$this->k201_datapendencia_mes);
         $this->k201_datapendencia_ano = ($this->k201_datapendencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k201_datapendencia_ano"]:$this->k201_datapendencia_ano);
         if($this->k201_datapendencia_dia != ""){
            $this->k201_datapendencia = $this->k201_datapendencia_ano."-".$this->k201_datapendencia_mes."-".$this->k201_datapendencia_dia;
         }
       }
       $this->k201_conciliacao = ($this->k201_conciliacao == ""?@$GLOBALS["HTTP_POST_VARS"]["k201_conciliacao"]:$this->k201_conciliacao);
       $this->k201_sequencial = ($this->k201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k201_sequencial"]:$this->k201_sequencial);
     }else{
       $this->k201_sequencial = ($this->k201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k201_sequencial"]:$this->k201_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($k201_sequencial){ 
      $this->atualizacampos();
     if($this->k201_autenticacao == null ){ 
       $this->erro_sql = " Campo  nao Informado.";
       $this->erro_campo = "k201_autenticacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k201_datapendencia == null ){ 
       $this->erro_sql = " Campo data pendencia nao Informado.";
       $this->erro_campo = "k201_datapendencia_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k201_conciliacao == null ){ 
       $this->erro_sql = " Campo  nao Informado.";
       $this->erro_campo = "k201_conciliacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->k201_sequencial = $k201_sequencial; 
     if(($this->k201_sequencial == null) || ($this->k201_sequencial == "") ){ 
       $this->erro_sql = " Campo k201_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into concmanupendecaixa(
                                       k201_autenticacao 
                                      ,k201_datapendencia 
                                      ,k201_conciliacao 
                                      ,k201_sequencial 
                       )
                values (
                                $this->k201_autenticacao 
                               ,".($this->k201_datapendencia == "null" || $this->k201_datapendencia == ""?"null":"'".$this->k201_datapendencia."'")." 
                               ,$this->k201_conciliacao 
                               ,$this->k201_sequencial 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->k201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->k201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k201_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->k201_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,1009255,'$this->k201_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010210,2009350,'','".AddSlashes(pg_result($resaco,0,'k201_autenticacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010210,2009352,'','".AddSlashes(pg_result($resaco,0,'k201_datapendencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010210,2009351,'','".AddSlashes(pg_result($resaco,0,'k201_conciliacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010210,2009353,'','".AddSlashes(pg_result($resaco,0,'k201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($k201_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update concmanupendecaixa set ";
     $virgula = "";
     if(trim($this->k201_autenticacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k201_autenticacao"])){ 
       $sql  .= $virgula." k201_autenticacao = $this->k201_autenticacao ";
       $virgula = ",";
       if(trim($this->k201_autenticacao) == null ){ 
         $this->erro_sql = " Campo  nao Informado.";
         $this->erro_campo = "k201_autenticacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k201_datapendencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k201_datapendencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k201_datapendencia_dia"] !="") ){ 
       $sql  .= $virgula." k201_datapendencia = '$this->k201_datapendencia' ";
       $virgula = ",";
       if(trim($this->k201_datapendencia) == null ){ 
         $this->erro_sql = " Campo data pendencia nao Informado.";
         $this->erro_campo = "k201_datapendencia_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["k201_datapendencia_dia"])){ 
         $sql  .= $virgula." k201_datapendencia = null ";
         $virgula = ",";
         if(trim($this->k201_datapendencia) == null ){ 
           $this->erro_sql = " Campo data pendencia nao Informado.";
           $this->erro_campo = "k201_datapendencia_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->k201_conciliacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k201_conciliacao"])){ 
       $sql  .= $virgula." k201_conciliacao = $this->k201_conciliacao ";
       $virgula = ",";
       if(trim($this->k201_conciliacao) == null ){ 
         $this->erro_sql = " Campo  nao Informado.";
         $this->erro_campo = "k201_conciliacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k201_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k201_sequencial"])){ 
       $sql  .= $virgula." k201_sequencial = $this->k201_sequencial ";
       $virgula = ",";
       if(trim($this->k201_sequencial) == null ){ 
         $this->erro_sql = " Campo Código  sequencial nao Informado.";
         $this->erro_campo = "k201_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($k201_sequencial!=null){
       $sql .= " k201_sequencial = $this->k201_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->k201_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009255,'$this->k201_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k201_autenticacao"]) || $this->k201_autenticacao != "")
           $resac = db_query("insert into db_acount values($acount,2010210,2009350,'".AddSlashes(pg_result($resaco,$conresaco,'k201_autenticacao'))."','$this->k201_autenticacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k201_datapendencia"]) || $this->k201_datapendencia != "")
           $resac = db_query("insert into db_acount values($acount,2010210,2009352,'".AddSlashes(pg_result($resaco,$conresaco,'k201_datapendencia'))."','$this->k201_datapendencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k201_conciliacao"]) || $this->k201_conciliacao != "")
           $resac = db_query("insert into db_acount values($acount,2010210,2009351,'".AddSlashes(pg_result($resaco,$conresaco,'k201_conciliacao'))."','$this->k201_conciliacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k201_sequencial"]) || $this->k201_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010210,2009353,'".AddSlashes(pg_result($resaco,$conresaco,'k201_sequencial'))."','$this->k201_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k201_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($k201_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009255,'$k201_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010210,2009350,'','".AddSlashes(pg_result($resaco,$iresaco,'k201_autenticacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010210,2009352,'','".AddSlashes(pg_result($resaco,$iresaco,'k201_datapendencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010210,2009351,'','".AddSlashes(pg_result($resaco,$iresaco,'k201_conciliacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010210,2009353,'','".AddSlashes(pg_result($resaco,$iresaco,'k201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from concmanupendecaixa
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k201_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k201_sequencial = $k201_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k201_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:concmanupendecaixa";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $k201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from concmanupendecaixa ";
     $sql .= "      inner join conciliacao  on  conciliacao.k199_sequencial = concmanupendecaixa.k201_conciliacao";
     $sql .= "      inner join contabancaria  on  contabancaria.db83_sequencial = conciliacao.k199_codconta";
     $sql2 = "";
     if($dbwhere==""){
       if($k201_sequencial!=null ){
         $sql2 .= " where concmanupendecaixa.k201_sequencial = $k201_sequencial "; 
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
   function sql_query_file ( $k201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from concmanupendecaixa ";
     $sql2 = "";
     if($dbwhere==""){
       if($k201_sequencial!=null ){
         $sql2 .= " where concmanupendecaixa.k201_sequencial = $k201_sequencial "; 
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
