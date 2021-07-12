<?
//MODULO: sicom
//CLASSE DA ENTIDADE bpdcasp502019
class cl_bpdcasp502019 { 
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
   var $si212_sequencial = 0; 
   var $si212_tiporegistro = 0; 
   var $si212_vlsaldopatrimonial = 0; 
   var $si212_ano = 0;
   var $si212_periodo = 0;
   var $si212_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si212_sequencial = int4 = si212_sequencial 
                 si212_tiporegistro = int4 = si212_tiporegistro 
                 si212_vlsaldopatrimonial = float4 = si212_vlsaldopatrimonial 
                 ";
   //funcao construtor da classe 
   function cl_bpdcasp502019() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bpdcasp502019"); 
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
       $this->si212_sequencial = ($this->si212_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si212_sequencial"]:$this->si212_sequencial);
       $this->si212_tiporegistro = ($this->si212_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si212_tiporegistro"]:$this->si212_tiporegistro);
       $this->si212_vlsaldopatrimonial = ($this->si212_vlsaldopatrimonial == ""?@$GLOBALS["HTTP_POST_VARS"]["si212_vlsaldopatrimonial"]:$this->si212_vlsaldopatrimonial);
       $this->si212_ano = ($this->si212_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si212_ano"]:$this->si212_ano);
       $this->si212_periodo = ($this->si212_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si212_periodo"]:$this->si212_periodo);
       $this->si212_institu = ($this->si212_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si212_institu"]:$this->si212_institu);
     }else{
       $this->si212_sequencial = ($this->si212_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si212_sequencial"]:$this->si212_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si212_sequencial){ 
      $this->atualizacampos();
     if($this->si212_tiporegistro == null ){
       $this->erro_sql = " Campo si212_tiporegistro não informado.";
       $this->erro_campo = "si212_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si212_vlsaldopatrimonial == null ){
       $this->si212_vlsaldopatrimonial = 0;
     }

     $sql = "insert into bpdcasp502019(
                                       si212_sequencial 
                                      ,si212_tiporegistro 
                                      ,si212_vlsaldopatrimonial 
                                      ,si212_ano
                                      ,si212_periodo
                                      ,si212_institu
                       )
                values (
                                (select nextval('bpdcasp502019_si212_sequencial_seq'))
                               ,$this->si212_tiporegistro 
                               ,$this->si212_vlsaldopatrimonial 
                               ,$this->si212_ano
                               ,$this->si212_periodo
                               ,$this->si212_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bpdcasp502019 ($this->si212_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bpdcasp502019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bpdcasp502019 ($this->si212_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si212_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si212_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bpdcasp502019 set ";
     $virgula = "";
     if(trim($this->si212_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si212_sequencial"])){ 
       $sql  .= $virgula." si212_sequencial = $this->si212_sequencial ";
       $virgula = ",";
       if(trim($this->si212_sequencial) == null ){ 
         $this->erro_sql = " Campo si212_sequencial não informado.";
         $this->erro_campo = "si212_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si212_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si212_tiporegistro"])){ 
       $sql  .= $virgula." si212_tiporegistro = $this->si212_tiporegistro ";
       $virgula = ",";
       if(trim($this->si212_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si212_tiporegistro não informado.";
         $this->erro_campo = "si212_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si212_vlsaldopatrimonial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si212_vlsaldopatrimonial"])){ 
       $sql  .= $virgula." si212_vlsaldopatrimonial = $this->si212_vlsaldopatrimonial ";
       $virgula = ",";
       if(trim($this->si212_vlsaldopatrimonial) == null ){ 
         $this->erro_sql = " Campo si212_vlsaldopatrimonial não informado.";
         $this->erro_campo = "si212_vlsaldopatrimonial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si212_sequencial!=null){
       $sql .= " si212_sequencial = $this->si212_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si212_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009426,'$this->si212_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si212_sequencial"]) || $this->si212_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010206,1009426,'".AddSlashes(pg_result($resaco,$conresaco,'si212_sequencial'))."','$this->si212_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si212_tiporegistro"]) || $this->si212_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010206,1009427,'".AddSlashes(pg_result($resaco,$conresaco,'si212_tiporegistro'))."','$this->si212_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si212_vlsaldopatrimonial"]) || $this->si212_vlsaldopatrimonial != "")
             $resac = db_query("insert into db_acount values($acount,1010206,1009429,'".AddSlashes(pg_result($resaco,$conresaco,'si212_vlsaldopatrimonial'))."','$this->si212_vlsaldopatrimonial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp502019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si212_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp502019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si212_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si212_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si212_sequencial=null,$dbwhere=null) { 

     $sql = " delete from bpdcasp502019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si212_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si212_sequencial = $si212_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp502019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si212_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp502019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si212_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si212_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bpdcasp502019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si212_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp502019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si212_sequencial!=null ){
         $sql2 .= " where bpdcasp502019.si212_sequencial = $si212_sequencial "; 
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
   function sql_query_file ( $si212_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp502019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si212_sequencial!=null ){
         $sql2 .= " where bpdcasp502019.si212_sequencial = $si212_sequencial "; 
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
