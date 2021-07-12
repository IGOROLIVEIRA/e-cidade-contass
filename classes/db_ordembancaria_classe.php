<?
//MODULO: caixa
//CLASSE DA ENTIDADE ordembancaria
class cl_ordembancaria { 
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
   var $k00_codigo = 0; 
   var $k00_ctpagadora = 0; 
   var $k00_dtpagamento_dia = null; 
   var $k00_dtpagamento_mes = null; 
   var $k00_dtpagamento_ano = null; 
   var $k00_dtpagamento = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k00_codigo = int8 = codigo sequencial 
                 k00_ctpagadora = int8 = Conta Pagadora 
                 k00_dtpagamento = date = Data Pagamento 
                 ";
   //funcao construtor da classe 
   function cl_ordembancaria() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ordembancaria"); 
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
       $this->k00_codigo = ($this->k00_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_codigo"]:$this->k00_codigo);
       $this->k00_ctpagadora = ($this->k00_ctpagadora == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_ctpagadora"]:$this->k00_ctpagadora);
       if($this->k00_dtpagamento == ""){
         $this->k00_dtpagamento_dia = ($this->k00_dtpagamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_dtpagamento_dia"]:$this->k00_dtpagamento_dia);
         $this->k00_dtpagamento_mes = ($this->k00_dtpagamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_dtpagamento_mes"]:$this->k00_dtpagamento_mes);
         $this->k00_dtpagamento_ano = ($this->k00_dtpagamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_dtpagamento_ano"]:$this->k00_dtpagamento_ano);
         if($this->k00_dtpagamento_dia != ""){
            $this->k00_dtpagamento = $this->k00_dtpagamento_ano."-".$this->k00_dtpagamento_mes."-".$this->k00_dtpagamento_dia;
         }
       }
     }else{
       $this->k00_codigo = ($this->k00_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_codigo"]:$this->k00_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($k00_codigo){ 
      $this->atualizacampos();
     if($this->k00_ctpagadora == null ){ 
       $this->erro_sql = " Campo Conta Pagadora nao Informado.";
       $this->erro_campo = "k00_ctpagadora";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k00_dtpagamento == null ){ 
       $this->erro_sql = " Campo Data Pagamento nao Informado.";
       $this->erro_campo = "k00_dtpagamento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->k00_codigo = $k00_codigo; 
     if(($this->k00_codigo == null) || ($this->k00_codigo == "") ){ 
       $this->erro_sql = " Campo k00_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ordembancaria(
                                       k00_codigo 
                                      ,k00_ctpagadora 
                                      ,k00_dtpagamento 
                       )
                values (
                                $this->k00_codigo 
                               ,$this->k00_ctpagadora 
                               ,".($this->k00_dtpagamento == "null" || $this->k00_dtpagamento == ""?"null":"'".$this->k00_dtpagamento."'")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Ordem Bancaria ($this->k00_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Ordem Bancaria já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Ordem Bancaria ($this->k00_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->k00_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009324,'$this->k00_codigo','I')");
       $resac = db_query("insert into db_acount values($acount,2010207,2009324,'','".AddSlashes(pg_result($resaco,0,'k00_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010207,2009325,'','".AddSlashes(pg_result($resaco,0,'k00_ctpagadora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010207,2009326,'','".AddSlashes(pg_result($resaco,0,'k00_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($k00_codigo=null) { 
      $this->atualizacampos();
     $sql = " update ordembancaria set ";
     $virgula = "";
     if(trim($this->k00_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_codigo"])){ 
       $sql  .= $virgula." k00_codigo = $this->k00_codigo ";
       $virgula = ",";
       if(trim($this->k00_codigo) == null ){ 
         $this->erro_sql = " Campo codigo sequencial nao Informado.";
         $this->erro_campo = "k00_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_ctpagadora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_ctpagadora"])){ 
       $sql  .= $virgula." k00_ctpagadora = $this->k00_ctpagadora ";
       $virgula = ",";
       if(trim($this->k00_ctpagadora) == null ){ 
         $this->erro_sql = " Campo Conta Pagadora nao Informado.";
         $this->erro_campo = "k00_ctpagadora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_dtpagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_dtpagamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k00_dtpagamento_dia"] !="") ){ 
       $sql  .= $virgula." k00_dtpagamento = '$this->k00_dtpagamento' ";
       $virgula = ",";
       if(trim($this->k00_dtpagamento) == null ){ 
         $this->erro_sql = " Campo Data Pagamento nao Informado.";
         $this->erro_campo = "k00_dtpagamento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["k00_dtpagamento_dia"])){ 
         $sql  .= $virgula." k00_dtpagamento = null ";
         $virgula = ",";
         if(trim($this->k00_dtpagamento) == null ){ 
           $this->erro_sql = " Campo Data Pagamento nao Informado.";
           $this->erro_campo = "k00_dtpagamento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if($k00_codigo!=null){
       $sql .= " k00_codigo = $this->k00_codigo";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->k00_codigo));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009324,'$this->k00_codigo','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_codigo"]) || $this->k00_codigo != "")
           $resac = db_query("insert into db_acount values($acount,2010207,2009324,'".AddSlashes(pg_result($resaco,$conresaco,'k00_codigo'))."','$this->k00_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_ctpagadora"]) || $this->k00_ctpagadora != "")
           $resac = db_query("insert into db_acount values($acount,2010207,2009325,'".AddSlashes(pg_result($resaco,$conresaco,'k00_ctpagadora'))."','$this->k00_ctpagadora',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_dtpagamento"]) || $this->k00_dtpagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010207,2009326,'".AddSlashes(pg_result($resaco,$conresaco,'k00_dtpagamento'))."','$this->k00_dtpagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Ordem Bancaria nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Ordem Bancaria nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k00_codigo=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($k00_codigo));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009324,'$k00_codigo','E')");
         $resac = db_query("insert into db_acount values($acount,2010207,2009324,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010207,2009325,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_ctpagadora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010207,2009326,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ordembancaria
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k00_codigo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k00_codigo = $k00_codigo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Ordem Bancaria nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k00_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Ordem Bancaria nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k00_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k00_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:ordembancaria";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $k00_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ordembancaria ";
     $sql2 = "";
     if($dbwhere==""){
       if($k00_codigo!=null ){
         $sql2 .= " where ordembancaria.k00_codigo = $k00_codigo "; 
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
   function sql_query_file ( $k00_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ordembancaria ";
     $sql2 = "";
     if($dbwhere==""){
       if($k00_codigo!=null ){
         $sql2 .= " where ordembancaria.k00_codigo = $k00_codigo "; 
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
