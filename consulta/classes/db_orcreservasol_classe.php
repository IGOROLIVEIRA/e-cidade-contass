<?
//MODULO: orcamento
//CLASSE DA ENTIDADE orcreservasol
class cl_orcreservasol { 
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
   var $o82_codres = 0; 
   var $o82_solicitem = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o82_codres = int8 = Código 
                 o82_solicitem = int4 = Item da solicitação 
                 ";
   //funcao construtor da classe 
   function cl_orcreservasol() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orcreservasol"); 
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
       $this->o82_codres = ($this->o82_codres == ""?@$GLOBALS["HTTP_POST_VARS"]["o82_codres"]:$this->o82_codres);
       $this->o82_solicitem = ($this->o82_solicitem == ""?@$GLOBALS["HTTP_POST_VARS"]["o82_solicitem"]:$this->o82_solicitem);
     }else{
       $this->o82_codres = ($this->o82_codres == ""?@$GLOBALS["HTTP_POST_VARS"]["o82_codres"]:$this->o82_codres);
       $this->o82_solicitem = ($this->o82_solicitem == ""?@$GLOBALS["HTTP_POST_VARS"]["o82_solicitem"]:$this->o82_solicitem);
     }
   }
   // funcao para inclusao
   function incluir ($o82_codres,$o82_solicitem){ 
      $this->atualizacampos();
       $this->o82_codres = $o82_codres; 
       $this->o82_solicitem = $o82_solicitem; 
     if(($this->o82_codres == null) || ($this->o82_codres == "") ){ 
       $this->erro_sql = " Campo o82_codres nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->o82_solicitem == null) || ($this->o82_solicitem == "") ){ 
       $this->erro_sql = " Campo o82_solicitem nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orcreservasol(
                                       o82_codres 
                                      ,o82_solicitem 
                       )
                values (
                                $this->o82_codres 
                               ,$this->o82_solicitem 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Reservas de Solicitação ($this->o82_codres."-".$this->o82_solicitem) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Reservas de Solicitação já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Reservas de Solicitação ($this->o82_codres."-".$this->o82_solicitem) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o82_codres."-".$this->o82_solicitem;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->o82_codres,$this->o82_solicitem));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5368,'$this->o82_codres','I')");
       $resac = pg_query("insert into db_acountkey values($acount,5369,'$this->o82_solicitem','I')");
       $resac = pg_query("insert into db_acount values($acount,781,5368,'','".AddSlashes(pg_result($resaco,0,'o82_codres'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,781,5369,'','".AddSlashes(pg_result($resaco,0,'o82_solicitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o82_codres=null,$o82_solicitem=null) { 
      $this->atualizacampos();
     $sql = " update orcreservasol set ";
     $virgula = "";
     if(trim($this->o82_codres)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o82_codres"])){ 
       $sql  .= $virgula." o82_codres = $this->o82_codres ";
       $virgula = ",";
       if(trim($this->o82_codres) == null ){ 
         $this->erro_sql = " Campo Código nao Informado.";
         $this->erro_campo = "o82_codres";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o82_solicitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o82_solicitem"])){ 
       $sql  .= $virgula." o82_solicitem = $this->o82_solicitem ";
       $virgula = ",";
       if(trim($this->o82_solicitem) == null ){ 
         $this->erro_sql = " Campo Item da solicitação nao Informado.";
         $this->erro_campo = "o82_solicitem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($o82_codres!=null){
       $sql .= " o82_codres = $this->o82_codres";
     }
     if($o82_solicitem!=null){
       $sql .= " and  o82_solicitem = $this->o82_solicitem";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->o82_codres,$this->o82_solicitem));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5368,'$this->o82_codres','A')");
         $resac = pg_query("insert into db_acountkey values($acount,5369,'$this->o82_solicitem','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o82_codres"]))
           $resac = pg_query("insert into db_acount values($acount,781,5368,'".AddSlashes(pg_result($resaco,$conresaco,'o82_codres'))."','$this->o82_codres',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o82_solicitem"]))
           $resac = pg_query("insert into db_acount values($acount,781,5369,'".AddSlashes(pg_result($resaco,$conresaco,'o82_solicitem'))."','$this->o82_solicitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Reservas de Solicitação nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o82_codres."-".$this->o82_solicitem;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Reservas de Solicitação nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o82_codres."-".$this->o82_solicitem;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o82_codres."-".$this->o82_solicitem;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o82_codres=null,$o82_solicitem=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($o82_codres,$o82_solicitem));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5368,'$this->o82_codres','E')");
         $resac = pg_query("insert into db_acountkey values($acount,5369,'$this->o82_solicitem','E')");
         $resac = pg_query("insert into db_acount values($acount,781,5368,'','".AddSlashes(pg_result($resaco,$iresaco,'o82_codres'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,781,5369,'','".AddSlashes(pg_result($resaco,$iresaco,'o82_solicitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orcreservasol
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($o82_codres != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o82_codres = $o82_codres ";
        }
        if($o82_solicitem != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o82_solicitem = $o82_solicitem ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Reservas de Solicitação nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o82_codres."-".$o82_solicitem;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Reservas de Solicitação nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o82_codres."-".$o82_solicitem;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o82_codres."-".$o82_solicitem;
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
        $this->erro_sql   = "Record Vazio na Tabela:orcreservasol";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query_orcreserva ($o82_codres=null,$o82_solicitem=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcreservasol ";
     $sql .= "      inner join orcreserva  on  orcreserva.o80_codres = orcreservasol.o82_codres";
     $sql2 = "";
     if($dbwhere==""){
       if($o82_codres!=null ){
         $sql2 .= " where orcreservasol.o82_codres = $o82_codres "; 
       } 
       if($o82_solicitem!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcreservasol.o82_solicitem = $o82_solicitem "; 
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
   function sql_query ( $o82_codres=null,$o82_solicitem=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcreservasol ";
     $sql .= "      inner join orcreserva  on  orcreserva.o80_codres = orcreservasol.o82_codres";
     $sql .= "      inner join solicitem  on  solicitem.pc11_codigo = orcreservasol.o82_solicitem";
     $sql .= "      inner join orcdotacao  on  orcdotacao.o58_anousu = orcreserva.o80_anousu and  orcdotacao.o58_coddot = orcreserva.o80_coddot";
     $sql .= "      inner join solicita  on  solicita.pc10_numero = solicitem.pc11_numero";
     $sql2 = "";
     if($dbwhere==""){
       if($o82_codres!=null ){
         $sql2 .= " where orcreservasol.o82_codres = $o82_codres "; 
       } 
       if($o82_solicitem!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcreservasol.o82_solicitem = $o82_solicitem "; 
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
   function sql_query_file ( $o82_codres=null,$o82_solicitem=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcreservasol ";
     $sql2 = "";
     if($dbwhere==""){
       if($o82_codres!=null ){
         $sql2 .= " where orcreservasol.o82_codres = $o82_codres "; 
       } 
       if($o82_solicitem!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcreservasol.o82_solicitem = $o82_solicitem "; 
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
