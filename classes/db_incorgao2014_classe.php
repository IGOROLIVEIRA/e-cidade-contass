<?
//MODULO: sicom
//CLASSE DA ENTIDADE incorgao2014
class cl_incorgao2014 { 
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
   var $si163_sequencial = 0; 
   var $si163_codorgao = null; 
   var $si163_cpfgestor = null; 
   var $si163_tipoorgao = null; 
   var $si163_mes = 0; 
   var $si163_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si163_sequencial = int8 = sequencial 
                 si163_codorgao = varchar(2) = Código do órgão 
                 si163_cpfgestor = varchar(11) = Número do CPF do  gestor 
                 si163_tipoorgao = varchar(2) = Tipo do órgão 
                 si163_mes = int8 = Mês 
                 si163_instit = int4 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_incorgao2014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("incorgao2014"); 
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
       $this->si163_sequencial = ($this->si163_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si163_sequencial"]:$this->si163_sequencial);
       $this->si163_codorgao = ($this->si163_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si163_codorgao"]:$this->si163_codorgao);
       $this->si163_cpfgestor = ($this->si163_cpfgestor == ""?@$GLOBALS["HTTP_POST_VARS"]["si163_cpfgestor"]:$this->si163_cpfgestor);
       $this->si163_tipoorgao = ($this->si163_tipoorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si163_tipoorgao"]:$this->si163_tipoorgao);
       $this->si163_mes = ($this->si163_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si163_mes"]:$this->si163_mes);
       $this->si163_instit = ($this->si163_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si163_instit"]:$this->si163_instit);
     }else{
       $this->si163_sequencial = ($this->si163_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si163_sequencial"]:$this->si163_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si163_sequencial){ 
      $this->atualizacampos();
     if($this->si163_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si163_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si163_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si163_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si163_sequencial = $si163_sequencial; 
     if(($this->si163_sequencial == null) || ($this->si163_sequencial == "") ){ 
       $this->erro_sql = " Campo si163_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into incorgao2014(
                                       si163_sequencial 
                                      ,si163_codorgao 
                                      ,si163_cpfgestor 
                                      ,si163_tipoorgao 
                                      ,si163_mes 
                                      ,si163_instit 
                       )
                values (
                                $this->si163_sequencial 
                               ,'$this->si163_codorgao' 
                               ,'$this->si163_cpfgestor' 
                               ,'$this->si163_tipoorgao' 
                               ,$this->si163_mes 
                               ,$this->si163_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "incorgao2014 ($this->si163_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "incorgao2014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "incorgao2014 ($this->si163_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si163_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si163_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011273,'$this->si163_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010392,2011273,'','".AddSlashes(pg_result($resaco,0,'si163_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010392,2011269,'','".AddSlashes(pg_result($resaco,0,'si163_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010392,2011270,'','".AddSlashes(pg_result($resaco,0,'si163_cpfgestor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010392,2011271,'','".AddSlashes(pg_result($resaco,0,'si163_tipoorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010392,2011272,'','".AddSlashes(pg_result($resaco,0,'si163_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010392,2011676,'','".AddSlashes(pg_result($resaco,0,'si163_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si163_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update incorgao2014 set ";
     $virgula = "";
     if(trim($this->si163_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si163_sequencial"])){ 
        if(trim($this->si163_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si163_sequencial"])){ 
           $this->si163_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si163_sequencial = $this->si163_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si163_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si163_codorgao"])){ 
       $sql  .= $virgula." si163_codorgao = '$this->si163_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si163_cpfgestor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si163_cpfgestor"])){ 
       $sql  .= $virgula." si163_cpfgestor = '$this->si163_cpfgestor' ";
       $virgula = ",";
     }
     if(trim($this->si163_tipoorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si163_tipoorgao"])){ 
       $sql  .= $virgula." si163_tipoorgao = '$this->si163_tipoorgao' ";
       $virgula = ",";
     }
     if(trim($this->si163_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si163_mes"])){ 
       $sql  .= $virgula." si163_mes = $this->si163_mes ";
       $virgula = ",";
       if(trim($this->si163_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si163_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si163_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si163_instit"])){ 
       $sql  .= $virgula." si163_instit = $this->si163_instit ";
       $virgula = ",";
       if(trim($this->si163_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si163_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si163_sequencial!=null){
       $sql .= " si163_sequencial = $this->si163_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si163_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011273,'$this->si163_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si163_sequencial"]) || $this->si163_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010392,2011273,'".AddSlashes(pg_result($resaco,$conresaco,'si163_sequencial'))."','$this->si163_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si163_codorgao"]) || $this->si163_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010392,2011269,'".AddSlashes(pg_result($resaco,$conresaco,'si163_codorgao'))."','$this->si163_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si163_cpfgestor"]) || $this->si163_cpfgestor != "")
           $resac = db_query("insert into db_acount values($acount,2010392,2011270,'".AddSlashes(pg_result($resaco,$conresaco,'si163_cpfgestor'))."','$this->si163_cpfgestor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si163_tipoorgao"]) || $this->si163_tipoorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010392,2011271,'".AddSlashes(pg_result($resaco,$conresaco,'si163_tipoorgao'))."','$this->si163_tipoorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si163_mes"]) || $this->si163_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010392,2011272,'".AddSlashes(pg_result($resaco,$conresaco,'si163_mes'))."','$this->si163_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si163_instit"]) || $this->si163_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010392,2011676,'".AddSlashes(pg_result($resaco,$conresaco,'si163_instit'))."','$this->si163_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incorgao2014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si163_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incorgao2014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si163_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si163_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si163_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si163_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011273,'$si163_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010392,2011273,'','".AddSlashes(pg_result($resaco,$iresaco,'si163_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010392,2011269,'','".AddSlashes(pg_result($resaco,$iresaco,'si163_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010392,2011270,'','".AddSlashes(pg_result($resaco,$iresaco,'si163_cpfgestor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010392,2011271,'','".AddSlashes(pg_result($resaco,$iresaco,'si163_tipoorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010392,2011272,'','".AddSlashes(pg_result($resaco,$iresaco,'si163_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010392,2011676,'','".AddSlashes(pg_result($resaco,$iresaco,'si163_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from incorgao2014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si163_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si163_sequencial = $si163_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incorgao2014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si163_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incorgao2014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si163_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si163_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:incorgao2014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si163_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incorgao2014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si163_sequencial!=null ){
         $sql2 .= " where incorgao2014.si163_sequencial = $si163_sequencial "; 
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
   function sql_query_file ( $si163_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incorgao2014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si163_sequencial!=null ){
         $sql2 .= " where incorgao2014.si163_sequencial = $si163_sequencial "; 
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
