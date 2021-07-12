<?
//MODULO: sicom
//CLASSE DA ENTIDADE bodcasp202018
class cl_bodcasp202018 {
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
   var $si202_anousu    = 0;
   var $si202_periodo   = 0;
   var $si202_instit    = 0;
   var $si202_sequencial = 0;
   var $si202_tiporegistro = 0;
   var $si202_faserecorcamentaria = 0;
   var $si202_vlsaldoexeantsupfin = 0;
   var $si202_vlsaldoexeantrecredad = 0;
   var $si202_vltotalsaldoexeant = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si202_anousu = int4 = si202_anousu
                 si202_periodo = int4 = si202_periodo
                 si202_instit = int4 = si202_instit
                 si202_sequencial = int4 = si202_sequencial
                 si202_tiporegistro = int4 = si202_tiporegistro
                 si202_faserecorcamentaria = int4 = si202_faserecorcamentaria
                 si202_vlsaldoexeantsupfin = float4 = si202_vlsaldoexeantsupfin
                 si202_vlsaldoexeantrecredad = float4 = si202_vlsaldoexeantrecredad
                 si202_vltotalsaldoexeant = float4 = si202_vltotalsaldoexeant
                 ";
   //funcao construtor da classe
   function cl_bodcasp202018() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bodcasp202018");
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
       $this->si202_anousu = ($this->si202_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_anousu"]:$this->si202_anousu);
       $this->si202_periodo = ($this->si202_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_periodo"]:$this->si202_periodo);
       $this->si202_instit = ($this->si202_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_instit"]:$this->si202_instit);
       $this->si202_sequencial = ($this->si202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_sequencial"]:$this->si202_sequencial);
       $this->si202_tiporegistro = ($this->si202_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"]:$this->si202_tiporegistro);
       $this->si202_faserecorcamentaria = ($this->si202_faserecorcamentaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_faserecorcamentaria"]:$this->si202_faserecorcamentaria);
       $this->si202_vlsaldoexeantsupfin = ($this->si202_vlsaldoexeantsupfin == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantsupfin"]:$this->si202_vlsaldoexeantsupfin);
       $this->si202_vlsaldoexeantrecredad = ($this->si202_vlsaldoexeantrecredad == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantrecredad"]:$this->si202_vlsaldoexeantrecredad);
       $this->si202_vltotalsaldoexeant = ($this->si202_vltotalsaldoexeant == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_vltotalsaldoexeant"]:$this->si202_vltotalsaldoexeant);
     }else{
       $this->si202_sequencial = ($this->si202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si202_sequencial"]:$this->si202_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si202_sequencial){
      $this->atualizacampos();
     if ($this->si202_anousu == null ) {
       $this->si202_anousu = intval(date('Y'));
     }
     if ($this->si202_periodo == null ) {
       $this->si202_periodo = intval(date('m') + 16);
     }
     if ($this->si202_instit == null ) {
       $this->si202_instit = db_getsession("DB_instit");
     }
     if (empty($this->si202_tiporegistro)) {
       $this->si202_tiporegistro = 20;
     }
     if (empty($this->si202_faserecorcamentaria)) {
        $this->si202_faserecorcamentaria = 0;
     }
     if (empty($this->si202_vlsaldoexeantsupfin)) {
        $this->si202_vlsaldoexeantsupfin = 0;
     }
     if (empty($this->si202_vlsaldoexeantrecredad)) {
        $this->si202_vlsaldoexeantrecredad = 0;
     }
     if (empty($this->si202_vltotalsaldoexeant)) {
        $this->si202_vltotalsaldoexeant = 0;
     }


     if($si202_sequencial == "" || $si202_sequencial == null ){
       $result = db_query("select nextval('bodcasp202018_si202_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: bodcasp202018_si202_sequencial_seq do campo: si202_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si202_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from bodcasp202018_si202_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si202_sequencial)){
         $this->erro_sql = " Campo si202_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si202_sequencial = $si202_sequencial;
       }
     }


     $sql = "insert into bodcasp202018(
                                       si202_anousu
                                      ,si202_periodo
                                      ,si202_instit
                                      ,si202_sequencial
                                      ,si202_tiporegistro
                                      ,si202_faserecorcamentaria
                                      ,si202_vlsaldoexeantsupfin
                                      ,si202_vlsaldoexeantrecredad
                                      ,si202_vltotalsaldoexeant
                       )
                values (
                                {$this->si202_anousu}
                               ,{$this->si202_periodo}
                               ,{$this->si202_instit}
                               ,$this->si202_sequencial
                               ,$this->si202_tiporegistro
                               ,$this->si202_faserecorcamentaria
                               ,$this->si202_vlsaldoexeantsupfin
                               ,$this->si202_vlsaldoexeantrecredad
                               ,$this->si202_vltotalsaldoexeant
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bodcasp202018 ($this->si202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bodcasp202018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bodcasp202018 ($this->si202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si202_sequencial=null) {
      $this->atualizacampos();
     $sql = " update bodcasp202018 set ";
     $virgula = "";
     if(trim($this->si202_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_sequencial"])){
       $sql  .= $virgula." si202_sequencial = $this->si202_sequencial ";
       $virgula = ",";
       if(trim($this->si202_sequencial) == null ){
         $this->erro_sql = " Campo si202_sequencial não informado.";
         $this->erro_campo = "si202_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_tiporegistro"])){
       $sql  .= $virgula." si202_tiporegistro = $this->si202_tiporegistro ";
       $virgula = ",";
       if(trim($this->si202_tiporegistro) == null ){
         $this->erro_sql = " Campo si202_tiporegistro não informado.";
         $this->erro_campo = "si202_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_faserecorcamentaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_faserecorcamentaria"])){
       $sql  .= $virgula." si202_faserecorcamentaria = $this->si202_faserecorcamentaria ";
       $virgula = ",";
       if(trim($this->si202_faserecorcamentaria) == null ){
         $this->erro_sql = " Campo si202_faserecorcamentaria não informado.";
         $this->erro_campo = "si202_faserecorcamentaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_vlsaldoexeantsupfin)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantsupfin"])){
       $sql  .= $virgula." si202_vlsaldoexeantsupfin = $this->si202_vlsaldoexeantsupfin ";
       $virgula = ",";
       if(trim($this->si202_vlsaldoexeantsupfin) == null ){
         $this->erro_sql = " Campo si202_vlsaldoexeantsupfin não informado.";
         $this->erro_campo = "si202_vlsaldoexeantsupfin";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_vlsaldoexeantrecredad)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_vlsaldoexeantrecredad"])){
       $sql  .= $virgula." si202_vlsaldoexeantrecredad = $this->si202_vlsaldoexeantrecredad ";
       $virgula = ",";
       if(trim($this->si202_vlsaldoexeantrecredad) == null ){
         $this->erro_sql = " Campo si202_vlsaldoexeantrecredad não informado.";
         $this->erro_campo = "si202_vlsaldoexeantrecredad";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si202_vltotalsaldoexeant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si202_vltotalsaldoexeant"])){
       $sql  .= $virgula." si202_vltotalsaldoexeant = $this->si202_vltotalsaldoexeant ";
       $virgula = ",";
       if(trim($this->si202_vltotalsaldoexeant) == null ){
         $this->erro_sql = " Campo si202_vltotalsaldoexeant não informado.";
         $this->erro_campo = "si202_vltotalsaldoexeant";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si202_sequencial!=null){
       $sql .= " si202_sequencial = $this->si202_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp202018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp202018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si202_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si202_sequencial=null,$dbwhere=null) {

     $sql = " delete from bodcasp202018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si202_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si202_sequencial = $si202_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp202018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si202_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp202018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si202_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si202_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bodcasp202018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp202018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si202_sequencial!=null ){
         $sql2 .= " where bodcasp202018.si202_sequencial = $si202_sequencial ";
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
   function sql_query_file ( $si202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp202018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si202_sequencial!=null ){
         $sql2 .= " where bodcasp202018.si202_sequencial = $si202_sequencial ";
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
