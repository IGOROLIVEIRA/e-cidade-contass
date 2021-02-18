<?
//MODULO: sicom
//CLASSE DA ENTIDADE bodcasp402021
class cl_bodcasp402021 {
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
   var $si204_ano      = 0;
   var $si204_periodo  = 0;
   var $si204_institu  = 0;
   var $si204_sequencial = 0;
   var $si204_tiporegistro = 0;
   var $si204_faserestospagarnaoproc = 0;
   var $si204_vlrspnaoprocpessoalencarsociais = 0;
   var $si204_vlrspnaoprocjurosencardividas = 0;
   var $si204_vlrspnaoprocoutrasdespcorrentes = 0;
   var $si204_vlrspnaoprocinvestimentos = 0;
   var $si204_vlrspnaoprocinverfinanceira = 0;
   var $si204_vlrspnaoprocamortizadivida = 0;
   var $si204_vltotalexecurspnaoprocessado = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si204_ano = int4 = si204_ano
                 si204_periodo = int4 = si204_periodo
                 si204_institu = int4 = si204_institu
                 si204_sequencial = int4 = si204_sequencial
                 si204_tiporegistro = int4 = si204_tiporegistro
                 si204_faserestospagarnaoproc = int4 = si204_faserestospagarnaoproc
                 si204_vlrspnaoprocpessoalencarsociais = float4 = si204_vlrspnaoprocpessoalencarsociais
                 si204_vlrspnaoprocjurosencardividas = float4 = si204_vlrspnaoprocjurosencardividas
                 si204_vlrspnaoprocoutrasdespcorrentes = float4 = si204_vlrspnaoprocoutrasdespcorrentes
                 si204_vlrspnaoprocinvestimentos = float4 = si204_vlrspnaoprocinvestimentos
                 si204_vlrspnaoprocinverfinanceira = float4 = si204_vlrspnaoprocinverfinanceira
                 si204_vlrspnaoprocamortizadivida = float4 = si204_vlrspnaoprocamortizadivida
                 si204_vltotalexecurspnaoprocessado = float4 = si204_vltotalexecurspnaoprocessado
                 ";
   //funcao construtor da classe
   function cl_bodcasp402021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bodcasp402021");
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
       $this->si204_ano = ($this->si204_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_ano"]:$this->si204_ano);
       $this->si204_periodo = ($this->si204_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_periodo"]:$this->si204_periodo);
       $this->si204_institu = ($this->si204_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_institu"]:$this->si204_institu);
       $this->si204_sequencial = ($this->si204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_sequencial"]:$this->si204_sequencial);
       $this->si204_tiporegistro = ($this->si204_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_tiporegistro"]:$this->si204_tiporegistro);
       $this->si204_faserestospagarnaoproc = ($this->si204_faserestospagarnaoproc == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_faserestospagarnaoproc"]:$this->si204_faserestospagarnaoproc);
       $this->si204_vlrspnaoprocpessoalencarsociais = ($this->si204_vlrspnaoprocpessoalencarsociais == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocpessoalencarsociais"]:$this->si204_vlrspnaoprocpessoalencarsociais);
       $this->si204_vlrspnaoprocjurosencardividas = ($this->si204_vlrspnaoprocjurosencardividas == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocjurosencardividas"]:$this->si204_vlrspnaoprocjurosencardividas);
       $this->si204_vlrspnaoprocoutrasdespcorrentes = ($this->si204_vlrspnaoprocoutrasdespcorrentes == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocoutrasdespcorrentes"]:$this->si204_vlrspnaoprocoutrasdespcorrentes);
       $this->si204_vlrspnaoprocinvestimentos = ($this->si204_vlrspnaoprocinvestimentos == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocinvestimentos"]:$this->si204_vlrspnaoprocinvestimentos);
       $this->si204_vlrspnaoprocinverfinanceira = ($this->si204_vlrspnaoprocinverfinanceira == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocinverfinanceira"]:$this->si204_vlrspnaoprocinverfinanceira);
       $this->si204_vlrspnaoprocamortizadivida = ($this->si204_vlrspnaoprocamortizadivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocamortizadivida"]:$this->si204_vlrspnaoprocamortizadivida);
       $this->si204_vltotalexecurspnaoprocessado = ($this->si204_vltotalexecurspnaoprocessado == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_vltotalexecurspnaoprocessado"]:$this->si204_vltotalexecurspnaoprocessado);
     }else{
       $this->si204_sequencial = ($this->si204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_sequencial"]:$this->si204_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si204_sequencial){
      $this->atualizacampos();
     if ($this->si204_ano == null ) {
       $this->si204_ano = intval(date('Y'));
     }
     if ($this->si204_periodo == null ) {
       $this->si204_periodo = intval(date('m') + 16);
     }
     if ($this->si204_institu == null ) {
       $this->si204_institu = db_getsession("DB_instit");
     }
     if (empty($this->si204_tiporegistro)) {
       $this->si204_tiporegistro = 40;
     }
     if (empty($this->si204_faserestospagarnaoproc)) {
       $this->si204_faserestospagarnaoproc = 0;
     }
     if (empty($this->si204_vlrspnaoprocpessoalencarsociais)) {
       $this->si204_vlrspnaoprocpessoalencarsociais = 0;
     }
     if (empty($this->si204_vlrspnaoprocjurosencardividas)) {
       $this->si204_vlrspnaoprocjurosencardividas = 0;
     }
     if (empty($this->si204_vlrspnaoprocoutrasdespcorrentes)) {
       $this->si204_vlrspnaoprocoutrasdespcorrentes = 0;
     }
     if (empty($this->si204_vlrspnaoprocinvestimentos)) {
       $this->si204_vlrspnaoprocinvestimentos = 0;
     }
     if (empty($this->si204_vlrspnaoprocinverfinanceira)) {
       $this->si204_vlrspnaoprocinverfinanceira = 0;
     }
     if (empty($this->si204_vlrspnaoprocamortizadivida)) {
       $this->si204_vlrspnaoprocamortizadivida = 0;
     }
     if (empty($this->si204_vltotalexecurspnaoprocessado)) {
       $this->si204_vltotalexecurspnaoprocessado = 0;
     }

     if($si204_sequencial == "" || $si204_sequencial == null ){
       $result = db_query("select nextval('bodcasp402021_si204_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: bodcasp402021_si204_sequencial_seq do campo: si204_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si204_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from bodcasp402021_si204_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si204_sequencial)){
         $this->erro_sql = " Campo si204_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si204_sequencial = $si204_sequencial;
       }
     }

     $sql = "insert into bodcasp402021(
                                       si204_ano
                                      ,si204_periodo
                                      ,si204_institu
                                      ,si204_sequencial
                                      ,si204_tiporegistro
                                      ,si204_faserestospagarnaoproc
                                      ,si204_vlrspnaoprocpessoalencarsociais
                                      ,si204_vlrspnaoprocjurosencardividas
                                      ,si204_vlrspnaoprocoutrasdespcorrentes
                                      ,si204_vlrspnaoprocinvestimentos
                                      ,si204_vlrspnaoprocinverfinanceira
                                      ,si204_vlrspnaoprocamortizadivida
                                      ,si204_vltotalexecurspnaoprocessado
                       )
                values (
                                {$this->si204_ano}
                               ,{$this->si204_periodo}
                               ,{$this->si204_institu}
                               ,{$this->si204_sequencial}
                               ,{$this->si204_tiporegistro}
                               ,{$this->si204_faserestospagarnaoproc}
                               ,{$this->si204_vlrspnaoprocpessoalencarsociais}
                               ,{$this->si204_vlrspnaoprocjurosencardividas}
                               ,{$this->si204_vlrspnaoprocoutrasdespcorrentes}
                               ,{$this->si204_vlrspnaoprocinvestimentos}
                               ,{$this->si204_vlrspnaoprocinverfinanceira}
                               ,{$this->si204_vlrspnaoprocamortizadivida}
                               ,{$this->si204_vltotalexecurspnaoprocessado}
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bodcasp402021 ($this->si204_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bodcasp402021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bodcasp402021 ($this->si204_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si204_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si204_sequencial=null) {
      $this->atualizacampos();
     $sql = " update bodcasp402021 set ";
     $virgula = "";
     if(trim($this->si204_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_sequencial"])){
       $sql  .= $virgula." si204_sequencial = $this->si204_sequencial ";
       $virgula = ",";
       if(trim($this->si204_sequencial) == null ){
         $this->erro_sql = " Campo si204_sequencial não informado.";
         $this->erro_campo = "si204_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_tiporegistro"])){
       $sql  .= $virgula." si204_tiporegistro = $this->si204_tiporegistro ";
       $virgula = ",";
       if(trim($this->si204_tiporegistro) == null ){
         $this->erro_sql = " Campo si204_tiporegistro não informado.";
         $this->erro_campo = "si204_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_faserestospagarnaoproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_faserestospagarnaoproc"])){
       $sql  .= $virgula." si204_faserestospagarnaoproc = $this->si204_faserestospagarnaoproc ";
       $virgula = ",";
       if(trim($this->si204_faserestospagarnaoproc) == null ){
         $this->erro_sql = " Campo si204_faserestospagarnaoproc não informado.";
         $this->erro_campo = "si204_faserestospagarnaoproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_vlrspnaoprocpessoalencarsociais)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocpessoalencarsociais"])){
       $sql  .= $virgula." si204_vlrspnaoprocpessoalencarsociais = $this->si204_vlrspnaoprocpessoalencarsociais ";
       $virgula = ",";
       if(trim($this->si204_vlrspnaoprocpessoalencarsociais) == null ){
         $this->erro_sql = " Campo si204_vlrspnaoprocpessoalencarsociais não informado.";
         $this->erro_campo = "si204_vlrspnaoprocpessoalencarsociais";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_vlrspnaoprocjurosencardividas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocjurosencardividas"])){
       $sql  .= $virgula." si204_vlrspnaoprocjurosencardividas = $this->si204_vlrspnaoprocjurosencardividas ";
       $virgula = ",";
       if(trim($this->si204_vlrspnaoprocjurosencardividas) == null ){
         $this->erro_sql = " Campo si204_vlrspnaoprocjurosencardividas não informado.";
         $this->erro_campo = "si204_vlrspnaoprocjurosencardividas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_vlrspnaoprocoutrasdespcorrentes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocoutrasdespcorrentes"])){
       $sql  .= $virgula." si204_vlrspnaoprocoutrasdespcorrentes = $this->si204_vlrspnaoprocoutrasdespcorrentes ";
       $virgula = ",";
       if(trim($this->si204_vlrspnaoprocoutrasdespcorrentes) == null ){
         $this->erro_sql = " Campo si204_vlrspnaoprocoutrasdespcorrentes não informado.";
         $this->erro_campo = "si204_vlrspnaoprocoutrasdespcorrentes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_vlrspnaoprocinvestimentos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocinvestimentos"])){
       $sql  .= $virgula." si204_vlrspnaoprocinvestimentos = $this->si204_vlrspnaoprocinvestimentos ";
       $virgula = ",";
       if(trim($this->si204_vlrspnaoprocinvestimentos) == null ){
         $this->erro_sql = " Campo si204_vlrspnaoprocinvestimentos não informado.";
         $this->erro_campo = "si204_vlrspnaoprocinvestimentos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_vlrspnaoprocinverfinanceira)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocinverfinanceira"])){
       $sql  .= $virgula." si204_vlrspnaoprocinverfinanceira = $this->si204_vlrspnaoprocinverfinanceira ";
       $virgula = ",";
       if(trim($this->si204_vlrspnaoprocinverfinanceira) == null ){
         $this->erro_sql = " Campo si204_vlrspnaoprocinverfinanceira não informado.";
         $this->erro_campo = "si204_vlrspnaoprocinverfinanceira";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_vlrspnaoprocamortizadivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_vlrspnaoprocamortizadivida"])){
       $sql  .= $virgula." si204_vlrspnaoprocamortizadivida = $this->si204_vlrspnaoprocamortizadivida ";
       $virgula = ",";
       if(trim($this->si204_vlrspnaoprocamortizadivida) == null ){
         $this->erro_sql = " Campo si204_vlrspnaoprocamortizadivida não informado.";
         $this->erro_campo = "si204_vlrspnaoprocamortizadivida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si204_vltotalexecurspnaoprocessado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_vltotalexecurspnaoprocessado"])){
       $sql  .= $virgula." si204_vltotalexecurspnaoprocessado = $this->si204_vltotalexecurspnaoprocessado ";
       $virgula = ",";
       if(trim($this->si204_vltotalexecurspnaoprocessado) == null ){
         $this->erro_sql = " Campo si204_vltotalexecurspnaoprocessado não informado.";
         $this->erro_campo = "si204_vltotalexecurspnaoprocessado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si204_sequencial!=null){
       $sql .= " si204_sequencial = $this->si204_sequencial";
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp402021 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si204_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp402021 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si204_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si204_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si204_sequencial=null,$dbwhere=null) {

     $sql = " delete from bodcasp402021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si204_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si204_sequencial = $si204_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp402021 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si204_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp402021 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si204_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si204_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bodcasp402021";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp402021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si204_sequencial!=null ){
         $sql2 .= " where bodcasp402021.si204_sequencial = $si204_sequencial ";
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
   function sql_query_file ( $si204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp402021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si204_sequencial!=null ){
         $sql2 .= " where bodcasp402021.si204_sequencial = $si204_sequencial ";
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
