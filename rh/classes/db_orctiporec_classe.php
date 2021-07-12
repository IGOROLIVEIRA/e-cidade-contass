<?
//MODULO: orcamento
//CLASSE DA ENTIDADE orctiporec
class cl_orctiporec { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $o15_codigo = 0; 
   var $o15_descr = null; 
   var $o15_codtri = null; 
   var $o15_finali = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o15_codigo = int4 = Codigo do Tipo de Recurso 
                 o15_descr = char(30) = Descricao do Tipo de Recurso 
                 o15_codtri = char(10) = Código Tribunal 
                 o15_finali = char(   160) = Finalidade do Recurso 
                 ";
   //funcao construtor da classe 
   function cl_orctiporec() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orctiporec"); 
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
       $this->o15_codigo = ($this->o15_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["o15_codigo"]:$this->o15_codigo);
       $this->o15_descr = ($this->o15_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["o15_descr"]:$this->o15_descr);
       $this->o15_codtri = ($this->o15_codtri == ""?@$GLOBALS["HTTP_POST_VARS"]["o15_codtri"]:$this->o15_codtri);
       $this->o15_finali = ($this->o15_finali == ""?@$GLOBALS["HTTP_POST_VARS"]["o15_finali"]:$this->o15_finali);
     }else{
       $this->o15_codigo = ($this->o15_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["o15_codigo"]:$this->o15_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($o15_codigo){ 
      $this->atualizacampos();
     if($this->o15_descr == null ){ 
       $this->erro_sql = " Campo Descricao do Tipo de Recurso nao Informado.";
       $this->erro_campo = "o15_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o15_codtri == null ){ 
       $this->erro_sql = " Campo Código Tribunal nao Informado.";
       $this->erro_campo = "o15_codtri";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o15_finali == null ){ 
       $this->erro_sql = " Campo Finalidade do Recurso nao Informado.";
       $this->erro_campo = "o15_finali";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->o15_codigo = $o15_codigo; 
     if(($this->o15_codigo == null) || ($this->o15_codigo == "") ){ 
       $this->erro_sql = " Campo o15_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orctiporec(
                                       o15_codigo 
                                      ,o15_descr 
                                      ,o15_codtri 
                                      ,o15_finali 
                       )
                values (
                                $this->o15_codigo 
                               ,'$this->o15_descr' 
                               ,'$this->o15_codtri' 
                               ,'$this->o15_finali' 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Tipos de Recursos ($this->o15_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Tipos de Recursos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Tipos de Recursos ($this->o15_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o15_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->o15_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,3347,'$this->o15_codigo','I')");
       $resac = pg_query("insert into db_acount values($acount,749,3347,'','".AddSlashes(pg_result($resaco,0,'o15_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,749,3348,'','".AddSlashes(pg_result($resaco,0,'o15_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,749,3350,'','".AddSlashes(pg_result($resaco,0,'o15_codtri'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,749,3351,'','".AddSlashes(pg_result($resaco,0,'o15_finali'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o15_codigo=null) { 
      $this->atualizacampos();
     $sql = " update orctiporec set ";
     $virgula = "";
     if(trim($this->o15_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o15_codigo"])){ 
       $sql  .= $virgula." o15_codigo = $this->o15_codigo ";
       $virgula = ",";
       if(trim($this->o15_codigo) == null ){ 
         $this->erro_sql = " Campo Codigo do Tipo de Recurso nao Informado.";
         $this->erro_campo = "o15_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o15_descr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o15_descr"])){ 
       $sql  .= $virgula." o15_descr = '$this->o15_descr' ";
       $virgula = ",";
       if(trim($this->o15_descr) == null ){ 
         $this->erro_sql = " Campo Descricao do Tipo de Recurso nao Informado.";
         $this->erro_campo = "o15_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o15_codtri)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o15_codtri"])){ 
       $sql  .= $virgula." o15_codtri = '$this->o15_codtri' ";
       $virgula = ",";
       if(trim($this->o15_codtri) == null ){ 
         $this->erro_sql = " Campo Código Tribunal nao Informado.";
         $this->erro_campo = "o15_codtri";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o15_finali)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o15_finali"])){ 
       $sql  .= $virgula." o15_finali = '$this->o15_finali' ";
       $virgula = ",";
       if(trim($this->o15_finali) == null ){ 
         $this->erro_sql = " Campo Finalidade do Recurso nao Informado.";
         $this->erro_campo = "o15_finali";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  o15_codigo = $this->o15_codigo
";
     $resaco = $this->sql_record($this->sql_query_file($this->o15_codigo));
     if($this->numrows>0){       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,3347,'$this->o15_codigo','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o15_codigo"]))
         $resac = pg_query("insert into db_acount values($acount,749,3347,'".AddSlashes(pg_result($resaco,0,'o15_codigo'))."','$this->o15_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o15_descr"]))
         $resac = pg_query("insert into db_acount values($acount,749,3348,'".AddSlashes(pg_result($resaco,0,'o15_descr'))."','$this->o15_descr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o15_codtri"]))
         $resac = pg_query("insert into db_acount values($acount,749,3350,'".AddSlashes(pg_result($resaco,0,'o15_codtri'))."','$this->o15_codtri',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o15_finali"]))
         $resac = pg_query("insert into db_acount values($acount,749,3351,'".AddSlashes(pg_result($resaco,0,'o15_finali'))."','$this->o15_finali',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipos de Recursos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o15_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Tipos de Recursos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o15_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o15_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o15_codigo=null) { 
     $resaco = $this->sql_record($this->sql_query_file($o15_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,3347,'$this->o15_codigo','E')");
         $resac = pg_query("insert into db_acount values($acount,749,3347,'','".AddSlashes(pg_result($resaco,$iresaco,'o15_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,749,3348,'','".AddSlashes(pg_result($resaco,$iresaco,'o15_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,749,3350,'','".AddSlashes(pg_result($resaco,$iresaco,'o15_codtri'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,749,3351,'','".AddSlashes(pg_result($resaco,$iresaco,'o15_finali'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orctiporec
                    where ";
     $sql2 = "";
      if($o15_codigo != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " o15_codigo = $o15_codigo ";
}
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipos de Recursos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o15_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Tipos de Recursos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o15_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o15_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = @pg_query($sql);
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
        $this->erro_sql   = "Record Vazio na Tabela:orctiporec";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $o15_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orctiporec ";
     $sql2 = "";
     if($dbwhere==""){
       if($o15_codigo!=null ){
         $sql2 .= " where orctiporec.o15_codigo = $o15_codigo "; 
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
   function sql_query_file ( $o15_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orctiporec ";
     $sql2 = "";
     if($dbwhere==""){
       if($o15_codigo!=null ){
         $sql2 .= " where orctiporec.o15_codigo = $o15_codigo "; 
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
   /*  */
   function sql_query_emp( $o15_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orctiporec ";
     $sql .= "   inner join orcdotacao on o58_codigo = o15_codigo ";
     $sql .= "   inner join empempenho on e60_coddot = o58_coddot and e60_anousu=o58_anousu";
     $sql2 = "";
     if($dbwhere==""){
       if($o15_codigo!=null ){
         $sql2 .= " where orctiporec.o15_codigo = $o15_codigo "; 
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
