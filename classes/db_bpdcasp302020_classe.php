<?
//MODULO: sicom
//CLASSE DA ENTIDADE bpdcasp302020
class cl_bpdcasp302020 { 
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
   var $si210_sequencial = 0; 
   var $si210_tiporegistro = 0; 
   var $si210_vlativofinanceiro = 0; 
   var $si210_vlativopermanente = 0; 
   var $si210_vltotalativofinanceiropermanente = 0; 
   var $si210_ano = 0;
   var $si210_periodo = 0;
   var $si210_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si210_sequencial = int4 = si210_sequencial 
                 si210_tiporegistro = int4 = si210_tiporegistro 
                 si210_vlativofinanceiro = float4 = si210_vlativofinanceiro 
                 si210_vlativopermanente = float4 = si210_vlativopermanente 
                 si210_vltotalativofinanceiropermanente = float4 = si210_vltotalativofinanceiropermanente 
                 ";
   //funcao construtor da classe 
   function cl_bpdcasp302020() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bpdcasp302020"); 
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
       $this->si210_sequencial = ($this->si210_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_sequencial"]:$this->si210_sequencial);
       $this->si210_tiporegistro = ($this->si210_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_tiporegistro"]:$this->si210_tiporegistro);
       $this->si210_vlativofinanceiro = ($this->si210_vlativofinanceiro == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_vlativofinanceiro"]:$this->si210_vlativofinanceiro);
       $this->si210_vlativopermanente = ($this->si210_vlativopermanente == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_vlativopermanente"]:$this->si210_vlativopermanente);
       $this->si210_vltotalativofinanceiropermanente = ($this->si210_vltotalativofinanceiropermanente == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_vltotalativofinanceiropermanente"]:$this->si210_vltotalativofinanceiropermanente);
       $this->si210_ano = ($this->si210_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_ano"]:$this->si210_ano);
       $this->si210_periodo = ($this->si210_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_periodo"]:$this->si210_periodo);
       $this->si210_institu = ($this->si210_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_institu"]:$this->si210_institu);
     }else{
       $this->si210_sequencial = ($this->si210_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si210_sequencial"]:$this->si210_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si210_sequencial){ 
      $this->atualizacampos();
     if($this->si210_tiporegistro == null ){
       $this->erro_sql = " Campo si210_tiporegistro não informado.";
       $this->erro_campo = "si210_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }     
     if($this->si210_vlativofinanceiro == null ){
       $this->si210_vlativofinanceiro = 0;
     }
     if($this->si210_vlativopermanente == null ){
       $this->si210_vlativopermanente = 0;
     }
     if($this->si210_vltotalativofinanceiropermanente == null ){
       $this->si210_vltotalativofinanceiropermanente = 0;
     }

     $sql = "insert into bpdcasp302020(
                                       si210_sequencial 
                                      ,si210_tiporegistro 
                                      ,si210_vlativofinanceiro 
                                      ,si210_vlativopermanente 
                                      ,si210_vltotalativofinanceiropermanente 
                                      ,si210_ano
                                      ,si210_periodo
                                      ,si210_institu
                       )
                values (
                                (select nextval('bpdcasp302020_si210_sequencial_seq'))
                               ,$this->si210_tiporegistro 
                               ,$this->si210_vlativofinanceiro 
                               ,$this->si210_vlativopermanente 
                               ,$this->si210_vltotalativofinanceiropermanente 
                               ,$this->si210_ano
                               ,$this->si210_periodo
                               ,$this->si210_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bpdcasp302020 ($this->si210_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bpdcasp302020 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bpdcasp302020 ($this->si210_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si210_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   } 
   // funcao para alteracao
   function alterar ($si210_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bpdcasp302020 set ";
     $virgula = "";
     if(trim($this->si210_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si210_sequencial"])){ 
       $sql  .= $virgula." si210_sequencial = $this->si210_sequencial ";
       $virgula = ",";
       if(trim($this->si210_sequencial) == null ){ 
         $this->erro_sql = " Campo si210_sequencial não informado.";
         $this->erro_campo = "si210_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si210_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si210_tiporegistro"])){ 
       $sql  .= $virgula." si210_tiporegistro = $this->si210_tiporegistro ";
       $virgula = ",";
       if(trim($this->si210_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si210_tiporegistro não informado.";
         $this->erro_campo = "si210_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si210_vlativofinanceiro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si210_vlativofinanceiro"])){ 
       $sql  .= $virgula." si210_vlativofinanceiro = $this->si210_vlativofinanceiro ";
       $virgula = ",";
       if(trim($this->si210_vlativofinanceiro) == null ){ 
         $this->erro_sql = " Campo si210_vlativofinanceiro não informado.";
         $this->erro_campo = "si210_vlativofinanceiro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si210_vlativopermanente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si210_vlativopermanente"])){ 
       $sql  .= $virgula." si210_vlativopermanente = $this->si210_vlativopermanente ";
       $virgula = ",";
       if(trim($this->si210_vlativopermanente) == null ){ 
         $this->erro_sql = " Campo si210_vlativopermanente não informado.";
         $this->erro_campo = "si210_vlativopermanente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si210_vltotalativofinanceiropermanente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si210_vltotalativofinanceiropermanente"])){ 
       $sql  .= $virgula." si210_vltotalativofinanceiropermanente = $this->si210_vltotalativofinanceiropermanente ";
       $virgula = ",";
       if(trim($this->si210_vltotalativofinanceiropermanente) == null ){ 
         $this->erro_sql = " Campo si210_vltotalativofinanceiropermanente não informado.";
         $this->erro_campo = "si210_vltotalativofinanceiropermanente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si210_sequencial!=null){
       $sql .= " si210_sequencial = $this->si210_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si210_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009414,'$this->si210_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si210_sequencial"]) || $this->si210_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010204,1009414,'".AddSlashes(pg_result($resaco,$conresaco,'si210_sequencial'))."','$this->si210_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si210_tiporegistro"]) || $this->si210_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010204,1009415,'".AddSlashes(pg_result($resaco,$conresaco,'si210_tiporegistro'))."','$this->si210_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si210_vlativofinanceiro"]) || $this->si210_vlativofinanceiro != "")
             $resac = db_query("insert into db_acount values($acount,1010204,1009417,'".AddSlashes(pg_result($resaco,$conresaco,'si210_vlativofinanceiro'))."','$this->si210_vlativofinanceiro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si210_vlativopermanente"]) || $this->si210_vlativopermanente != "")
             $resac = db_query("insert into db_acount values($acount,1010204,1009418,'".AddSlashes(pg_result($resaco,$conresaco,'si210_vlativopermanente'))."','$this->si210_vlativopermanente',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si210_vltotalativofinanceiropermanente"]) || $this->si210_vltotalativofinanceiropermanente != "")
             $resac = db_query("insert into db_acount values($acount,1010204,1009419,'".AddSlashes(pg_result($resaco,$conresaco,'si210_vltotalativofinanceiropermanente'))."','$this->si210_vltotalativofinanceiropermanente',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp302020 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si210_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp302020 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si210_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si210_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si210_sequencial=null,$dbwhere=null) {
     $sql = " delete from bpdcasp302020
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si210_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si210_sequencial = $si210_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp302020 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si210_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp302020 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si210_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si210_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bpdcasp302020";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si210_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp302020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si210_sequencial!=null ){
         $sql2 .= " where bpdcasp302020.si210_sequencial = $si210_sequencial "; 
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
   function sql_query_file ( $si210_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp302020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si210_sequencial!=null ){
         $sql2 .= " where bpdcasp302020.si210_sequencial = $si210_sequencial "; 
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
