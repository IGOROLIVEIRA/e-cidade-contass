<?
//MODULO: sicom
//CLASSE DA ENTIDADE bpdcasp702021
class cl_bpdcasp702021 { 
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
   var $si214_sequencial = 0; 
   var $si214_tiporegistro = 0; 
   var $si214_vltotalsupdef = 0; 
   var $si214_ano = 0;
   var $si214_periodo = 0;
   var $si214_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si214_sequencial = int4 = si214_sequencial 
                 si214_tiporegistro = int4 = si214_tiporegistro 
                 si214_vltotalsupdef = float4 = si214_vltotalsupdef 
                 ";
   //funcao construtor da classe 
   function cl_bpdcasp702021() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bpdcasp702021"); 
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
       $this->si214_sequencial = ($this->si214_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si214_sequencial"]:$this->si214_sequencial);
       $this->si214_tiporegistro = ($this->si214_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si214_tiporegistro"]:$this->si214_tiporegistro);
       $this->si214_vltotalsupdef = ($this->si214_vltotalsupdef == ""?@$GLOBALS["HTTP_POST_VARS"]["si214_vltotalsupdef"]:$this->si214_vltotalsupdef);
       $this->si214_ano = ($this->si214_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si214_ano"]:$this->si214_ano);
       $this->si214_periodo = ($this->si214_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si214_periodo"]:$this->si214_periodo);
       $this->si214_institu = ($this->si214_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si214_institu"]:$this->si214_institu);
     }else{
       $this->si214_sequencial = ($this->si214_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si214_sequencial"]:$this->si214_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si214_sequencial){ 
      $this->atualizacampos();
     if($this->si214_tiporegistro == null ){
       $this->erro_sql = " Campo si214_tiporegistro não informado.";
       $this->erro_campo = "si214_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si214_vltotalsupdef == null ){
       $this->si214_vltotalsupdef = 0;
     }

     $sql = "insert into bpdcasp702021(
                                       si214_sequencial 
                                      ,si214_tiporegistro 
                                      ,si214_vltotalsupdef 
                                      ,si214_ano
                                      ,si214_periodo
                                      ,si214_institu
                       )
                values (
                                (select nextval('bpdcasp702021_si214_sequencial_seq'))
                               ,$this->si214_tiporegistro 
                               ,$this->si214_vltotalsupdef 
                               ,$this->si214_ano
                               ,$this->si214_periodo
                               ,$this->si214_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bpdcasp702021 ($this->si214_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bpdcasp702021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bpdcasp702021 ($this->si214_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si214_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si214_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bpdcasp702021 set ";
     $virgula = "";
     if(trim($this->si214_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si214_sequencial"])){ 
       $sql  .= $virgula." si214_sequencial = $this->si214_sequencial ";
       $virgula = ",";
       if(trim($this->si214_sequencial) == null ){ 
         $this->erro_sql = " Campo si214_sequencial não informado.";
         $this->erro_campo = "si214_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si214_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si214_tiporegistro"])){ 
       $sql  .= $virgula." si214_tiporegistro = $this->si214_tiporegistro ";
       $virgula = ",";
       if(trim($this->si214_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si214_tiporegistro não informado.";
         $this->erro_campo = "si214_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si214_vltotalsupdef)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si214_vltotalsupdef"])){ 
       $sql  .= $virgula." si214_vltotalsupdef = $this->si214_vltotalsupdef ";
       $virgula = ",";
       if(trim($this->si214_vltotalsupdef) == null ){ 
         $this->erro_sql = " Campo si214_vltotalsupdef não informado.";
         $this->erro_campo = "si214_vltotalsupdef";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si214_sequencial!=null){
       $sql .= " si214_sequencial = $this->si214_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si214_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009441,'$this->si214_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si214_sequencial"]) || $this->si214_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010208,1009441,'".AddSlashes(pg_result($resaco,$conresaco,'si214_sequencial'))."','$this->si214_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si214_tiporegistro"]) || $this->si214_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010208,1009442,'".AddSlashes(pg_result($resaco,$conresaco,'si214_tiporegistro'))."','$this->si214_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si214_vltotalsupdef"]) || $this->si214_vltotalsupdef != "")
             $resac = db_query("insert into db_acount values($acount,1010208,1009444,'".AddSlashes(pg_result($resaco,$conresaco,'si214_vltotalsupdef'))."','$this->si214_vltotalsupdef',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp702021 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si214_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp702021 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si214_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si214_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si214_sequencial=null,$dbwhere=null) { 

     $sql = " delete from bpdcasp702021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si214_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si214_sequencial = $si214_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp702021 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si214_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp702021 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si214_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si214_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
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
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:bpdcasp702021";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si214_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp702021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si214_sequencial!=null ){
         $sql2 .= " where bpdcasp702021.si214_sequencial = $si214_sequencial "; 
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
   function sql_query_file ( $si214_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp702021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si214_sequencial!=null ){
         $sql2 .= " where bpdcasp702021.si214_sequencial = $si214_sequencial "; 
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
