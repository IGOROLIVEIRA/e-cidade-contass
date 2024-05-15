<?
//MODULO: sicom
//CLASSE DA ENTIDADE dvpdcasp302018
class cl_dvpdcasp302018 { 
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
   var $si218_sequencial = 0; 
   var $si218_tiporegistro = 0; 
   var $si218_vlresultadopatrimonialperiodo = 0; 
   var $si218_ano = 0;
   var $si218_periodo = 0;
   var $si218_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si218_sequencial = int4 = si218_sequencial 
                 si218_tiporegistro = int4 = si218_tiporegistro 
                 si218_vlresultadopatrimonialperiodo = float4 = si218_vlresultadopatrimonialperiodo 
                 ";
   //funcao construtor da classe 
   function cl_dvpdcasp302018() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dvpdcasp302018"); 
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
       $this->si218_sequencial = ($this->si218_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si218_sequencial"]:$this->si218_sequencial);
       $this->si218_tiporegistro = ($this->si218_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si218_tiporegistro"]:$this->si218_tiporegistro);
       $this->si218_vlresultadopatrimonialperiodo = ($this->si218_vlresultadopatrimonialperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si218_vlresultadopatrimonialperiodo"]:$this->si218_vlresultadopatrimonialperiodo);
       $this->si218_ano = ($this->si218_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si218_ano"]:$this->si218_ano);
       $this->si218_periodo = ($this->si218_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si218_periodo"]:$this->si218_periodo);
       $this->si218_institu = ($this->si218_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si218_institu"]:$this->si218_institu);
     }else{
       $this->si218_sequencial = ($this->si218_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si218_sequencial"]:$this->si218_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si218_sequencial){ 
      $this->atualizacampos();
     if($this->si218_tiporegistro == null ){ 
       $this->erro_sql = " Campo si218_tiporegistro não informado.";
       $this->erro_campo = "si218_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si218_vlresultadopatrimonialperiodo == null ){
       $this->si218_vlresultadopatrimonialperiodo = 0;
     }

     $sql = "insert into dvpdcasp302018(
                                       si218_sequencial 
                                      ,si218_tiporegistro 
                                      ,si218_vlresultadopatrimonialperiodo 
                                      ,si218_ano
                                      ,si218_periodo
                                      ,si218_institu
                       )
                values (
                                (select nextval('dvpdcasp302018_si218_sequencial_seq'))
                               ,$this->si218_tiporegistro 
                               ,$this->si218_vlresultadopatrimonialperiodo 
                               ,$this->si218_ano
                               ,$this->si218_periodo
                               ,$this->si218_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dvpdcasp302018 ($this->si218_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dvpdcasp302018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dvpdcasp302018 ($this->si218_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si218_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si218_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dvpdcasp302018 set ";
     $virgula = "";
     if(trim($this->si218_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si218_sequencial"])){ 
       $sql  .= $virgula." si218_sequencial = $this->si218_sequencial ";
       $virgula = ",";
       if(trim($this->si218_sequencial) == null ){ 
         $this->erro_sql = " Campo si218_sequencial não informado.";
         $this->erro_campo = "si218_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si218_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si218_tiporegistro"])){ 
       $sql  .= $virgula." si218_tiporegistro = $this->si218_tiporegistro ";
       $virgula = ",";
       if(trim($this->si218_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si218_tiporegistro não informado.";
         $this->erro_campo = "si218_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si218_vlresultadopatrimonialperiodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si218_vlresultadopatrimonialperiodo"])){ 
       $sql  .= $virgula." si218_vlresultadopatrimonialperiodo = $this->si218_vlresultadopatrimonialperiodo ";
       $virgula = ",";
       if(trim($this->si218_vlresultadopatrimonialperiodo) == null ){ 
         $this->erro_sql = " Campo si218_vlresultadopatrimonialperiodo não informado.";
         $this->erro_campo = "si218_vlresultadopatrimonialperiodo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si218_sequencial!=null){
       $sql .= " si218_sequencial = $this->si218_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si218_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009474,'$this->si218_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si218_sequencial"]) || $this->si218_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010212,1009474,'".AddSlashes(pg_result($resaco,$conresaco,'si218_sequencial'))."','$this->si218_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si218_tiporegistro"]) || $this->si218_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010212,1009475,'".AddSlashes(pg_result($resaco,$conresaco,'si218_tiporegistro'))."','$this->si218_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si218_vlresultadopatrimonialperiodo"]) || $this->si218_vlresultadopatrimonialperiodo != "")
             $resac = db_query("insert into db_acount values($acount,1010212,1009477,'".AddSlashes(pg_result($resaco,$conresaco,'si218_vlresultadopatrimonialperiodo'))."','$this->si218_vlresultadopatrimonialperiodo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dvpdcasp302018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si218_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dvpdcasp302018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si218_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si218_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si218_sequencial=null,$dbwhere=null) { 

     $sql = " delete from dvpdcasp302018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si218_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si218_sequencial = $si218_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dvpdcasp302018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si218_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dvpdcasp302018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si218_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si218_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dvpdcasp302018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si218_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dvpdcasp302018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si218_sequencial!=null ){
         $sql2 .= " where dvpdcasp302018.si218_sequencial = $si218_sequencial "; 
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
   function sql_query_file ( $si218_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dvpdcasp302018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si218_sequencial!=null ){
         $sql2 .= " where dvpdcasp302018.si218_sequencial = $si218_sequencial "; 
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
