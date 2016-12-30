<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp902017
class cl_dfcdcasp902017 { 
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
   var $si227_sequencial = 0; 
   var $si227_tiporegistro = 0; 
   var $si227_exercicio = 0; 
   var $si227_vlfluxocaixafinanciamento = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si227_sequencial = int4 = si227_sequencial 
                 si227_tiporegistro = int4 = si227_tiporegistro 
                 si227_exercicio = int4 = si227_exercicio 
                 si227_vlfluxocaixafinanciamento = float4 = si227_vlfluxocaixafinanciamento 
                 ";
   //funcao construtor da classe 
   function cl_dfcdcasp902017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp902017"); 
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
       $this->si227_sequencial = ($this->si227_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si227_sequencial"]:$this->si227_sequencial);
       $this->si227_tiporegistro = ($this->si227_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si227_tiporegistro"]:$this->si227_tiporegistro);
       $this->si227_exercicio = ($this->si227_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si227_exercicio"]:$this->si227_exercicio);
       $this->si227_vlfluxocaixafinanciamento = ($this->si227_vlfluxocaixafinanciamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si227_vlfluxocaixafinanciamento"]:$this->si227_vlfluxocaixafinanciamento);
     }else{
       $this->si227_sequencial = ($this->si227_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si227_sequencial"]:$this->si227_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si227_sequencial){ 
      $this->atualizacampos();
     if($this->si227_tiporegistro == null ){ 
       $this->erro_sql = " Campo si227_tiporegistro não informado.";
       $this->erro_campo = "si227_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si227_exercicio == null ){ 
       $this->erro_sql = " Campo si227_exercicio não informado.";
       $this->erro_campo = "si227_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si227_vlfluxocaixafinanciamento == null ){ 
       $this->erro_sql = " Campo si227_vlfluxocaixafinanciamento não informado.";
       $this->erro_campo = "si227_vlfluxocaixafinanciamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si227_sequencial = $si227_sequencial; 
     if(($this->si227_sequencial == null) || ($this->si227_sequencial == "") ){ 
       $this->erro_sql = " Campo si227_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dfcdcasp902017(
                                       si227_sequencial 
                                      ,si227_tiporegistro 
                                      ,si227_exercicio 
                                      ,si227_vlfluxocaixafinanciamento 
                       )
                values (
                                $this->si227_sequencial 
                               ,$this->si227_tiporegistro 
                               ,$this->si227_exercicio 
                               ,$this->si227_vlfluxocaixafinanciamento 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp902017 ($this->si227_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dfcdcasp902017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dfcdcasp902017 ($this->si227_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si227_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si227_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009529,'$this->si227_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010221,1009529,'','".AddSlashes(pg_result($resaco,0,'si227_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010221,1009530,'','".AddSlashes(pg_result($resaco,0,'si227_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010221,1009531,'','".AddSlashes(pg_result($resaco,0,'si227_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010221,1009532,'','".AddSlashes(pg_result($resaco,0,'si227_vlfluxocaixafinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si227_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dfcdcasp902017 set ";
     $virgula = "";
     if(trim($this->si227_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si227_sequencial"])){ 
       $sql  .= $virgula." si227_sequencial = $this->si227_sequencial ";
       $virgula = ",";
       if(trim($this->si227_sequencial) == null ){ 
         $this->erro_sql = " Campo si227_sequencial não informado.";
         $this->erro_campo = "si227_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si227_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si227_tiporegistro"])){ 
       $sql  .= $virgula." si227_tiporegistro = $this->si227_tiporegistro ";
       $virgula = ",";
       if(trim($this->si227_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si227_tiporegistro não informado.";
         $this->erro_campo = "si227_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si227_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si227_exercicio"])){ 
       $sql  .= $virgula." si227_exercicio = $this->si227_exercicio ";
       $virgula = ",";
       if(trim($this->si227_exercicio) == null ){ 
         $this->erro_sql = " Campo si227_exercicio não informado.";
         $this->erro_campo = "si227_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si227_vlfluxocaixafinanciamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si227_vlfluxocaixafinanciamento"])){ 
       $sql  .= $virgula." si227_vlfluxocaixafinanciamento = $this->si227_vlfluxocaixafinanciamento ";
       $virgula = ",";
       if(trim($this->si227_vlfluxocaixafinanciamento) == null ){ 
         $this->erro_sql = " Campo si227_vlfluxocaixafinanciamento não informado.";
         $this->erro_campo = "si227_vlfluxocaixafinanciamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si227_sequencial!=null){
       $sql .= " si227_sequencial = $this->si227_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si227_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009529,'$this->si227_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si227_sequencial"]) || $this->si227_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010221,1009529,'".AddSlashes(pg_result($resaco,$conresaco,'si227_sequencial'))."','$this->si227_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si227_tiporegistro"]) || $this->si227_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010221,1009530,'".AddSlashes(pg_result($resaco,$conresaco,'si227_tiporegistro'))."','$this->si227_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si227_exercicio"]) || $this->si227_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010221,1009531,'".AddSlashes(pg_result($resaco,$conresaco,'si227_exercicio'))."','$this->si227_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si227_vlfluxocaixafinanciamento"]) || $this->si227_vlfluxocaixafinanciamento != "")
             $resac = db_query("insert into db_acount values($acount,1010221,1009532,'".AddSlashes(pg_result($resaco,$conresaco,'si227_vlfluxocaixafinanciamento'))."','$this->si227_vlfluxocaixafinanciamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp902017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si227_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp902017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si227_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si227_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si227_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si227_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009529,'$si227_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010221,1009529,'','".AddSlashes(pg_result($resaco,$iresaco,'si227_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010221,1009530,'','".AddSlashes(pg_result($resaco,$iresaco,'si227_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010221,1009531,'','".AddSlashes(pg_result($resaco,$iresaco,'si227_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010221,1009532,'','".AddSlashes(pg_result($resaco,$iresaco,'si227_vlfluxocaixafinanciamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from dfcdcasp902017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si227_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si227_sequencial = $si227_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp902017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si227_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp902017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si227_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si227_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp902017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si227_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp902017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si227_sequencial!=null ){
         $sql2 .= " where dfcdcasp902017.si227_sequencial = $si227_sequencial "; 
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
   function sql_query_file ( $si227_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp902017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si227_sequencial!=null ){
         $sql2 .= " where dfcdcasp902017.si227_sequencial = $si227_sequencial "; 
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
