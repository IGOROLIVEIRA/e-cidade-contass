<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp702021
class cl_dfcdcasp702021 {
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
   var $si225_anousu  = 0;
   var $si225_periodo = 0;
   var $si225_instit  = 0;
   var $si225_sequencial = 0;
   var $si225_tiporegistro = 0;
   var $si225_vloperacoescredito = 0;
   var $si225_vlintegralizacaodependentes = 0;
   var $si225_vltranscapitalrecebida = 0;
   var $si225_vloutrosingressosfinanciamento = 0;
   var $si225_vltotalingressoatividafinanciament = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si225_anousu = int4 = si225_anousu
                 si225_periodo = int4 = si225_periodo
                 si225_instit = int4 = si225_instit
                 si225_sequencial = int4 = si225_sequencial
                 si225_tiporegistro = int4 = si225_tiporegistro
                 si225_vloperacoescredito = float8 = si225_vloperacoescredito
                 si225_vlintegralizacaodependentes = float8 = si225_vlintegralizacaodependentes
                 si225_vltranscapitalrecebida = float8 = si225_vltranscapitalrecebida
                 si225_vloutrosingressosfinanciamento = float8 = si225_vloutrosingressosfinanciamento
                 si225_vltotalingressoatividafinanciament = float8 = si225_vltotalingressoatividafinanciament
                 ";
   //funcao construtor da classe
   function cl_dfcdcasp702021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp702021");
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
       $this->si225_anousu = ($this->si225_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_anousu"]:$this->si225_anousu);
       $this->si225_periodo = ($this->si225_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_periodo"]:$this->si225_periodo);
       $this->si225_instit = ($this->si225_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_instit"]:$this->si225_instit);
       $this->si225_sequencial = ($this->si225_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_sequencial"]:$this->si225_sequencial);
       $this->si225_tiporegistro = ($this->si225_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_tiporegistro"]:$this->si225_tiporegistro);
       $this->si225_vloperacoescredito = ($this->si225_vloperacoescredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_vloperacoescredito"]:$this->si225_vloperacoescredito);
       $this->si225_vlintegralizacaodependentes = ($this->si225_vlintegralizacaodependentes == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_vlintegralizacaodependentes"]:$this->si225_vlintegralizacaodependentes);
       $this->si225_vltranscapitalrecebida = ($this->si225_vltranscapitalrecebida == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_vltranscapitalrecebida"]:$this->si225_vltranscapitalrecebida);
       $this->si225_vloutrosingressosfinanciamento = ($this->si225_vloutrosingressosfinanciamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_vloutrosingressosfinanciamento"]:$this->si225_vloutrosingressosfinanciamento);
       $this->si225_vltotalingressoatividafinanciament = ($this->si225_vltotalingressoatividafinanciament == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_vltotalingressoatividafinanciament"]:$this->si225_vltotalingressoatividafinanciament);
     }else{
       $this->si225_sequencial = ($this->si225_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si225_sequencial"]:$this->si225_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si225_sequencial){
      $this->atualizacampos();
     if (empty($this->si225_anousu)) {
       $this->si225_anousu = db_getsession("DB_anousu");
     }
     if (empty($this->si225_periodo)) {
       $this->si225_periodo = 28;
     }
     if (empty($this->si225_instit)) {
       $this->si225_instit = db_getsession("DB_instit");
     }
     if ( empty($this->si225_tiporegistro) ) {
        $this->si225_tiporegistro = 70;
     }
     if ( empty($this->si225_vloperacoescredito) ) {
        $this->si225_vloperacoescredito = 0;
     }
     if ( empty($this->si225_vlintegralizacaodependentes) ) {
        $this->si225_vlintegralizacaodependentes = 0;
     }
     if ( empty($this->si225_vltranscapitalrecebida) ) {
        $this->si225_vltranscapitalrecebida = 0;
     }
     if ( empty($this->si225_vloutrosingressosfinanciamento) ) {
        $this->si225_vloutrosingressosfinanciamento = 0;
     }
     if ( empty($this->si225_vltotalingressoatividafinanciament) ) {
        $this->si225_vltotalingressoatividafinanciament = 0;
     }


     if(empty($si225_sequencial)){
       $result = db_query("select nextval('dfcdcasp702021_si225_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dfcdcasp702021_si225_sequencial_seq do campo: si225_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si225_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dfcdcasp702021_si225_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si225_sequencial)){
         $this->erro_sql = " Campo si225_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si225_sequencial = $si225_sequencial;
       }
     }


     $sql = "insert into dfcdcasp702021(
                                       si225_anousu
                                      ,si225_periodo
                                      ,si225_instit
                                      ,si225_sequencial
                                      ,si225_tiporegistro
                                      ,si225_vloperacoescredito
                                      ,si225_vlintegralizacaodependentes
                                      ,si225_vltranscapitalrecebida
                                      ,si225_vloutrosingressosfinanciamento
                                      ,si225_vltotalingressoatividafinanciament
                       )
                values (
                                {$this->si225_anousu}
                               ,{$this->si225_periodo}
                               ,{$this->si225_instit}
                               ,$this->si225_sequencial
                               ,$this->si225_tiporegistro
                               ,$this->si225_vloperacoescredito
                               ,$this->si225_vlintegralizacaodependentes
                               ,$this->si225_vltranscapitalrecebida
                               ,$this->si225_vloutrosingressosfinanciamento
                               ,$this->si225_vltotalingressoatividafinanciament
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp702021 ($this->si225_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dfcdcasp702021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dfcdcasp702021 ($this->si225_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si225_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si225_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dfcdcasp702021 set ";
     $virgula = "";
     if(trim($this->si225_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si225_sequencial"])){
       $sql  .= $virgula." si225_sequencial = $this->si225_sequencial ";
       $virgula = ",";
       if(trim($this->si225_sequencial) == null ){
         $this->erro_sql = " Campo si225_sequencial não informado.";
         $this->erro_campo = "si225_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si225_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si225_tiporegistro"])){
       $sql  .= $virgula." si225_tiporegistro = $this->si225_tiporegistro ";
       $virgula = ",";
       if(trim($this->si225_tiporegistro) == null ){
         $this->erro_sql = " Campo si225_tiporegistro não informado.";
         $this->erro_campo = "si225_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si225_vloperacoescredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si225_vloperacoescredito"])){
       $sql  .= $virgula." si225_vloperacoescredito = $this->si225_vloperacoescredito ";
       $virgula = ",";
       if(trim($this->si225_vloperacoescredito) == null ){
         $this->erro_sql = " Campo si225_vloperacoescredito não informado.";
         $this->erro_campo = "si225_vloperacoescredito";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si225_vlintegralizacaodependentes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si225_vlintegralizacaodependentes"])){
       $sql  .= $virgula." si225_vlintegralizacaodependentes = $this->si225_vlintegralizacaodependentes ";
       $virgula = ",";
       if(trim($this->si225_vlintegralizacaodependentes) == null ){
         $this->erro_sql = " Campo si225_vlintegralizacaodependentes não informado.";
         $this->erro_campo = "si225_vlintegralizacaodependentes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si225_vltranscapitalrecebida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si225_vltranscapitalrecebida"])){
       $sql  .= $virgula." si225_vltranscapitalrecebida = $this->si225_vltranscapitalrecebida ";
       $virgula = ",";
       if(trim($this->si225_vltranscapitalrecebida) == null ){
         $this->erro_sql = " Campo si225_vltranscapitalrecebida não informado.";
         $this->erro_campo = "si225_vltranscapitalrecebida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si225_vloutrosingressosfinanciamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si225_vloutrosingressosfinanciamento"])){
       $sql  .= $virgula." si225_vloutrosingressosfinanciamento = $this->si225_vloutrosingressosfinanciamento ";
       $virgula = ",";
       if(trim($this->si225_vloutrosingressosfinanciamento) == null ){
         $this->erro_sql = " Campo si225_vloutrosingressosfinanciamento não informado.";
         $this->erro_campo = "si225_vloutrosingressosfinanciamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si225_vltotalingressoatividafinanciament)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si225_vltotalingressoatividafinanciament"])){
       $sql  .= $virgula." si225_vltotalingressoatividafinanciament = $this->si225_vltotalingressoatividafinanciament ";
       $virgula = ",";
       if(trim($this->si225_vltotalingressoatividafinanciament) == null ){
         $this->erro_sql = " Campo si225_vltotalingressoatividafinanciament não informado.";
         $this->erro_campo = "si225_vltotalingressoatividafinanciament";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si225_sequencial!=null){
       $sql .= " si225_sequencial = $this->si225_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp702021 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si225_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp702021 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si225_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si225_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si225_sequencial=null,$dbwhere=null) {

     $sql = " delete from dfcdcasp702021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si225_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si225_sequencial = $si225_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp702021 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si225_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp702021 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si225_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si225_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp702021";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si225_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp702021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si225_sequencial!=null ){
         $sql2 .= " where dfcdcasp702021.si225_sequencial = $si225_sequencial ";
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
   function sql_query_file ( $si225_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp702021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si225_sequencial!=null ){
         $sql2 .= " where dfcdcasp702021.si225_sequencial = $si225_sequencial ";
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
