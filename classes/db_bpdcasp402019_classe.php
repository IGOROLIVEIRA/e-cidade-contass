<?
//MODULO: sicom
//CLASSE DA ENTIDADE bpdcasp402019
class cl_bpdcasp402019 { 
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
   var $si211_sequencial = 0; 
   var $si211_tiporegistro = 0; 
   var $si211_vlpassivofinanceiro = 0; 
   var $si211_vlpassivopermanente = 0; 
   var $si211_vltotalpassivofinanceiropermanente = 0; 
   var $si211_ano = 0;
   var $si211_periodo = 0;
   var $si211_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si211_sequencial = int4 = si211_sequencial 
                 si211_tiporegistro = int4 = si211_tiporegistro 
                 si211_vlpassivofinanceiro = float4 = si211_vlpassivofinanceiro 
                 si211_vlpassivopermanente = float4 = si211_vlpassivopermanente 
                 si211_vltotalpassivofinanceiropermanente = float4 = si211_vltotalpassivofinanceiropermanente 
                 si211_ano = float4 = si211_vltotalpassivofinanceiropermanente
                 si211_periodo = float4 = si211_vltotalpassivofinanceiropermanente
                 si211_institu = float4 = si211_vltotalpassivofinanceiropermanente
                 ";
   //funcao construtor da classe 
   function cl_bpdcasp402019() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bpdcasp402019"); 
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
       $this->si211_sequencial = ($this->si211_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_sequencial"]:$this->si211_sequencial);
       $this->si211_tiporegistro = ($this->si211_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_tiporegistro"]:$this->si211_tiporegistro);
       $this->si211_vlpassivofinanceiro = ($this->si211_vlpassivofinanceiro == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_vlpassivofinanceiro"]:$this->si211_vlpassivofinanceiro);
       $this->si211_vlpassivopermanente = ($this->si211_vlpassivopermanente == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_vlpassivopermanente"]:$this->si211_vlpassivopermanente);
       $this->si211_vltotalpassivofinanceiropermanente = ($this->si211_vltotalpassivofinanceiropermanente == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_vltotalpassivofinanceiropermanente"]:$this->si211_vltotalpassivofinanceiropermanente);
       $this->si211_ano = ($this->si211_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_ano"]:$this->si211_ano);
       $this->si211_periodo = ($this->si211_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_periodo"]:$this->si211_periodo);
       $this->si211_institu = ($this->si211_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_institu"]:$this->si211_institu);
     }else{
       $this->si211_sequencial = ($this->si211_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si211_sequencial"]:$this->si211_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si211_sequencial){ 
      $this->atualizacampos();
     if($this->si211_tiporegistro == null ){
       $this->erro_sql = " Campo si211_tiporegistro não informado.";
       $this->erro_campo = "si211_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si211_vlpassivofinanceiro == null ){
       $this->si211_vlpassivofinanceiro = 0;
     }
     if($this->si211_vlpassivopermanente == null ){
       $this->si211_vlpassivopermanente = 0;
     }
     if($this->si211_vltotalpassivofinanceiropermanente == null ){
       $this->si211_vltotalpassivofinanceiropermanente = 0;
     }

     $sql = "insert into bpdcasp402019(
                                       si211_sequencial 
                                      ,si211_tiporegistro 
                                      ,si211_vlpassivofinanceiro 
                                      ,si211_vlpassivopermanente 
                                      ,si211_vltotalpassivofinanceiropermanente 
                                      ,si211_ano
                                      ,si211_periodo
                                      ,si211_institu
                       )
                values (
                                (select nextval('bpdcasp402019_si211_sequencial_seq'))
                               ,$this->si211_tiporegistro 
                               ,$this->si211_vlpassivofinanceiro 
                               ,$this->si211_vlpassivopermanente 
                               ,$this->si211_vltotalpassivofinanceiropermanente 
                               ,$this->si211_ano
                               ,$this->si211_periodo
                               ,$this->si211_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bpdcasp402019 ($this->si211_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bpdcasp402019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bpdcasp402019 ($this->si211_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si211_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si211_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bpdcasp402019 set ";
     $virgula = "";
     if(trim($this->si211_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si211_sequencial"])){ 
       $sql  .= $virgula." si211_sequencial = $this->si211_sequencial ";
       $virgula = ",";
       if(trim($this->si211_sequencial) == null ){ 
         $this->erro_sql = " Campo si211_sequencial não informado.";
         $this->erro_campo = "si211_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si211_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si211_tiporegistro"])){ 
       $sql  .= $virgula." si211_tiporegistro = $this->si211_tiporegistro ";
       $virgula = ",";
       if(trim($this->si211_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si211_tiporegistro não informado.";
         $this->erro_campo = "si211_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si211_vlpassivofinanceiro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si211_vlpassivofinanceiro"])){ 
       $sql  .= $virgula." si211_vlpassivofinanceiro = $this->si211_vlpassivofinanceiro ";
       $virgula = ",";
       if(trim($this->si211_vlpassivofinanceiro) == null ){ 
         $this->erro_sql = " Campo si211_vlpassivofinanceiro não informado.";
         $this->erro_campo = "si211_vlpassivofinanceiro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si211_vlpassivopermanente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si211_vlpassivopermanente"])){ 
       $sql  .= $virgula." si211_vlpassivopermanente = $this->si211_vlpassivopermanente ";
       $virgula = ",";
       if(trim($this->si211_vlpassivopermanente) == null ){ 
         $this->erro_sql = " Campo si211_vlpassivopermanente não informado.";
         $this->erro_campo = "si211_vlpassivopermanente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si211_vltotalpassivofinanceiropermanente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si211_vltotalpassivofinanceiropermanente"])){ 
       $sql  .= $virgula." si211_vltotalpassivofinanceiropermanente = $this->si211_vltotalpassivofinanceiropermanente ";
       $virgula = ",";
       if(trim($this->si211_vltotalpassivofinanceiropermanente) == null ){ 
         $this->erro_sql = " Campo si211_vltotalpassivofinanceiropermanente não informado.";
         $this->erro_campo = "si211_vltotalpassivofinanceiropermanente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si211_sequencial!=null){
       $sql .= " si211_sequencial = $this->si211_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si211_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009420,'$this->si211_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si211_sequencial"]) || $this->si211_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010205,1009420,'".AddSlashes(pg_result($resaco,$conresaco,'si211_sequencial'))."','$this->si211_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si211_tiporegistro"]) || $this->si211_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010205,1009421,'".AddSlashes(pg_result($resaco,$conresaco,'si211_tiporegistro'))."','$this->si211_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si211_vlpassivofinanceiro"]) || $this->si211_vlpassivofinanceiro != "")
             $resac = db_query("insert into db_acount values($acount,1010205,1009423,'".AddSlashes(pg_result($resaco,$conresaco,'si211_vlpassivofinanceiro'))."','$this->si211_vlpassivofinanceiro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si211_vlpassivopermanente"]) || $this->si211_vlpassivopermanente != "")
             $resac = db_query("insert into db_acount values($acount,1010205,1009424,'".AddSlashes(pg_result($resaco,$conresaco,'si211_vlpassivopermanente'))."','$this->si211_vlpassivopermanente',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si211_vltotalpassivofinanceiropermanente"]) || $this->si211_vltotalpassivofinanceiropermanente != "")
             $resac = db_query("insert into db_acount values($acount,1010205,1009425,'".AddSlashes(pg_result($resaco,$conresaco,'si211_vltotalpassivofinanceiropermanente'))."','$this->si211_vltotalpassivofinanceiropermanente',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp402019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si211_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp402019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si211_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si211_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si211_sequencial=null,$dbwhere=null) { 

     $sql = " delete from bpdcasp402019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si211_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si211_sequencial = $si211_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp402019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si211_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp402019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si211_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si211_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bpdcasp402019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si211_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp402019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si211_sequencial!=null ){
         $sql2 .= " where bpdcasp402019.si211_sequencial = $si211_sequencial "; 
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
   function sql_query_file ( $si211_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp402019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si211_sequencial!=null ){
         $sql2 .= " where bpdcasp402019.si211_sequencial = $si211_sequencial "; 
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
