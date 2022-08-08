<?
//MODULO: sicom
//CLASSE DA ENTIDADE bodcasp102018
class cl_bodcasp102018 {
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
   var $si201_ano      = 0;
   var $si201_periodo  = 0;
   var $si201_institu  = 0;
   var $si201_sequencial = 0;
   var $si201_tiporegistro = 0;
   var $si201_faserecorcamentaria = 0;
   var $si201_vlrectributaria = 0;
   var $si201_vlreccontribuicoes = 0;
   var $si201_vlrecpatrimonial = 0;
   var $si201_vlrecagropecuaria = 0;
   var $si201_vlrecindustrial = 0;
   var $si201_vlrecservicos = 0;
   var $si201_vltransfcorrentes = 0;
   var $si201_vloutrasreccorrentes = 0;
   var $si201_vloperacoescredito = 0;
   var $si201_vlalienacaobens = 0;
   var $si201_vlamortemprestimo = 0;
   var $si201_vltransfcapital = 0;
   var $si201_vloutrasreccapital = 0;
   var $si201_vlrecarrecadaxeant = 0;
   var $si201_vlopcredrefintermob = 0;
   var $si201_vlopcredrefintcontrat = 0;
   var $si201_vlopcredrefextmob = 0;
   var $si201_vlopcredrefextcontrat = 0;
   var $si201_vldeficit = 0;
   var $si201_vltotalquadroreceita = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si201_ano = int4 = si201_ano
                 si201_periodo = int4 = si201_periodo
                 si201_institu = int4 = si201_institu
                 si201_sequencial = int4 = si201_sequencial
                 si201_tiporegistro = int4 = si201_tiporegistro
                 si201_faserecorcamentaria = int4 = si201_faserecorcamentaria
                 si201_vlrectributaria = float4 = si201_vlrectributaria
                 si201_vlreccontribuicoes = float4 = si201_vlreccontribuicoes
                 si201_vlrecpatrimonial = float4 = si201_vlrecpatrimonial
                 si201_vlrecagropecuaria = float4 = si201_vlrecagropecuaria
                 si201_vlrecindustrial = float4 = si201_vlrecindustrial
                 si201_vlrecservicos = float4 = si201_vlrecservicos
                 si201_vltransfcorrentes = float4 = si201_vltransfcorrentes
                 si201_vloutrasreccorrentes = float4 = si201_vloutrasreccorrentes
                 si201_vloperacoescredito = float4 = si201_vloperacoescredito
                 si201_vlalienacaobens = float4 = si201_vlalienacaobens
                 si201_vlamortemprestimo = float4 = si201_vlamortemprestimo
                 si201_vltransfcapital = float4 = si201_vltransfcapital
                 si201_vloutrasreccapital = float4 = si201_vloutrasreccapital
                 si201_vlrecarrecadaxeant = float4 = si201_vlrecarrecadaxeant
                 si201_vlopcredrefintermob = float4 = si201_vlopcredrefintermob
                 si201_vlopcredrefintcontrat = float4 = si201_vlopcredrefintcontrat
                 si201_vlopcredrefextmob = float4 = si201_vlopcredrefextmob
                 si201_vlopcredrefextcontrat = float4 = si201_vlopcredrefextcontrat
                 si201_vldeficit = float4 = si201_vldeficit
                 si201_vltotalquadroreceita = float4 = si201_vltotalquadroreceita
                 ";
   //funcao construtor da classe
   function cl_bodcasp102018() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bodcasp102018");
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
       $this->si201_ano = ($this->si201_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_ano"]:$this->si201_ano);
       $this->si201_periodo = ($this->si201_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_periodo"]:$this->si201_periodo);
       $this->si201_institu = ($this->si201_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_institu"]:$this->si201_institu);
       $this->si201_sequencial = ($this->si201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_sequencial"]:$this->si201_sequencial);
       $this->si201_tiporegistro = ($this->si201_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"]:$this->si201_tiporegistro);
       $this->si201_faserecorcamentaria = ($this->si201_faserecorcamentaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_faserecorcamentaria"]:$this->si201_faserecorcamentaria);
       $this->si201_vlrectributaria = ($this->si201_vlrectributaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlrectributaria"]:$this->si201_vlrectributaria);
       $this->si201_vlreccontribuicoes = ($this->si201_vlreccontribuicoes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlreccontribuicoes"]:$this->si201_vlreccontribuicoes);
       $this->si201_vlrecpatrimonial = ($this->si201_vlrecpatrimonial == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlrecpatrimonial"]:$this->si201_vlrecpatrimonial);
       $this->si201_vlrecagropecuaria = ($this->si201_vlrecagropecuaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlrecagropecuaria"]:$this->si201_vlrecagropecuaria);
       $this->si201_vlrecindustrial = ($this->si201_vlrecindustrial == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlrecindustrial"]:$this->si201_vlrecindustrial);
       $this->si201_vlrecservicos = ($this->si201_vlrecservicos == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlrecservicos"]:$this->si201_vlrecservicos);
       $this->si201_vltransfcorrentes = ($this->si201_vltransfcorrentes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vltransfcorrentes"]:$this->si201_vltransfcorrentes);
       $this->si201_vloutrasreccorrentes = ($this->si201_vloutrasreccorrentes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vloutrasreccorrentes"]:$this->si201_vloutrasreccorrentes);
       $this->si201_vloperacoescredito = ($this->si201_vloperacoescredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vloperacoescredito"]:$this->si201_vloperacoescredito);
       $this->si201_vlalienacaobens = ($this->si201_vlalienacaobens == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlalienacaobens"]:$this->si201_vlalienacaobens);
       $this->si201_vlamortemprestimo = ($this->si201_vlamortemprestimo == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlamortemprestimo"]:$this->si201_vlamortemprestimo);
       $this->si201_vltransfcapital = ($this->si201_vltransfcapital == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vltransfcapital"]:$this->si201_vltransfcapital);
       $this->si201_vloutrasreccapital = ($this->si201_vloutrasreccapital == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vloutrasreccapital"]:$this->si201_vloutrasreccapital);
       $this->si201_vlrecarrecadaxeant = ($this->si201_vlrecarrecadaxeant == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlrecarrecadaxeant"]:$this->si201_vlrecarrecadaxeant);
       $this->si201_vlopcredrefintermob = ($this->si201_vlopcredrefintermob == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefintermob"]:$this->si201_vlopcredrefintermob);
       $this->si201_vlopcredrefintcontrat = ($this->si201_vlopcredrefintcontrat == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefintcontrat"]:$this->si201_vlopcredrefintcontrat);
       $this->si201_vlopcredrefextmob = ($this->si201_vlopcredrefextmob == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefextmob"]:$this->si201_vlopcredrefextmob);
       $this->si201_vlopcredrefextcontrat = ($this->si201_vlopcredrefextcontrat == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefextcontrat"]:$this->si201_vlopcredrefextcontrat);
       $this->si201_vldeficit = ($this->si201_vldeficit == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vldeficit"]:$this->si201_vldeficit);
       $this->si201_vltotalquadroreceita = ($this->si201_vltotalquadroreceita == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_vltotalquadroreceita"]:$this->si201_vltotalquadroreceita);
     }else{
       $this->si201_sequencial = ($this->si201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_sequencial"]:$this->si201_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si201_sequencial){
      $this->atualizacampos();
     if ($this->si201_ano == null ) {
       $this->si201_ano = intval(date('Y'));
     }
     if ($this->si201_periodo == null ) {
       $this->si201_periodo = intval(date('m') + 16);
     }
     if ($this->si201_institu == null ) {
       $this->si201_institu = db_getsession("DB_instit");
     }
     if (empty($this->si201_tiporegistro)) {
      $this->si201_tiporegistro = 10;
     }
     if (empty($this->si201_faserecorcamentaria)) {
      $this->si201_faserecorcamentaria = 0;
     }
     if (empty($this->si201_vlrectributaria)) {
      $this->si201_vlrectributaria = 0;
     }
     if (empty($this->si201_vlreccontribuicoes)) {
      $this->si201_vlreccontribuicoes = 0;
     }
     if (empty($this->si201_vlrecpatrimonial)) {
      $this->si201_vlrecpatrimonial = 0;
     }
     if (empty($this->si201_vlrecagropecuaria)) {
      $this->si201_vlrecagropecuaria = 0;
     }
     if (empty($this->si201_vlrecindustrial)) {
      $this->si201_vlrecindustrial = 0;
     }
     if (empty($this->si201_vlrecservicos)) {
      $this->si201_vlrecservicos = 0;
     }
     if (empty($this->si201_vltransfcorrentes)) {
      $this->si201_vltransfcorrentes = 0;
     }
     if (empty($this->si201_vloutrasreccorrentes)) {
      $this->si201_vloutrasreccorrentes = 0;
     }
     if (empty($this->si201_vloperacoescredito)) {
      $this->si201_vloperacoescredito = 0;
     }
     if (empty($this->si201_vlalienacaobens)) {
      $this->si201_vlalienacaobens = 0;
     }
     if (empty($this->si201_vlamortemprestimo)) {
      $this->si201_vlamortemprestimo = 0;
     }
     if (empty($this->si201_vltransfcapital)) {
      $this->si201_vltransfcapital = 0;
     }
     if (empty($this->si201_vloutrasreccapital)) {
      $this->si201_vloutrasreccapital = 0;
     }
     if (empty($this->si201_vlrecarrecadaxeant)) {
      $this->si201_vlrecarrecadaxeant = 0;
     }
     if (empty($this->si201_vlopcredrefintermob)) {
      $this->si201_vlopcredrefintermob = 0;
     }
     if (empty($this->si201_vlopcredrefintcontrat)) {
      $this->si201_vlopcredrefintcontrat = 0;
     }
     if (empty($this->si201_vlopcredrefextmob)) {
      $this->si201_vlopcredrefextmob = 0;
     }
     if (empty($this->si201_vlopcredrefextcontrat)) {
      $this->si201_vlopcredrefextcontrat = 0;
     }
     if (empty($this->si201_vldeficit)) {
      $this->si201_vldeficit = 0;
     }
     if (empty($this->si201_vltotalquadroreceita)) {
      $this->si201_vltotalquadroreceita = 0;
     }

     if($si201_sequencial == "" || $si201_sequencial == null ){
       $result = db_query("select nextval('bodcasp102018_si201_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: bodcasp102018_si201_sequencial_seq do campo: si201_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si201_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from bodcasp102018_si201_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si201_sequencial)){
         $this->erro_sql = " Campo si201_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si201_sequencial = $si201_sequencial;
       }
     }

     if(($this->si201_sequencial == null) || ($this->si201_sequencial == "") ){
       $this->erro_sql = " Campo si201_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }

     $sql = "insert into bodcasp102018(
                                       si201_ano
                                      ,si201_periodo
                                      ,si201_institu
                                      ,si201_sequencial
                                      ,si201_tiporegistro
                                      ,si201_faserecorcamentaria
                                      ,si201_vlrectributaria
                                      ,si201_vlreccontribuicoes
                                      ,si201_vlrecpatrimonial
                                      ,si201_vlrecagropecuaria
                                      ,si201_vlrecindustrial
                                      ,si201_vlrecservicos
                                      ,si201_vltransfcorrentes
                                      ,si201_vloutrasreccorrentes
                                      ,si201_vloperacoescredito
                                      ,si201_vlalienacaobens
                                      ,si201_vlamortemprestimo
                                      ,si201_vltransfcapital
                                      ,si201_vloutrasreccapital
                                      ,si201_vlrecarrecadaxeant
                                      ,si201_vlopcredrefintermob
                                      ,si201_vlopcredrefintcontrat
                                      ,si201_vlopcredrefextmob
                                      ,si201_vlopcredrefextcontrat
                                      ,si201_vldeficit
                                      ,si201_vltotalquadroreceita
                       )
                values (
                                {$this->si201_ano}
                               ,{$this->si201_periodo}
                               ,{$this->si201_institu}
                               ,{$this->si201_sequencial}
                               ,{$this->si201_tiporegistro}
                               ,{$this->si201_faserecorcamentaria}
                               ,{$this->si201_vlrectributaria}
                               ,{$this->si201_vlreccontribuicoes}
                               ,{$this->si201_vlrecpatrimonial}
                               ,{$this->si201_vlrecagropecuaria}
                               ,{$this->si201_vlrecindustrial}
                               ,{$this->si201_vlrecservicos}
                               ,{$this->si201_vltransfcorrentes}
                               ,{$this->si201_vloutrasreccorrentes}
                               ,{$this->si201_vloperacoescredito}
                               ,{$this->si201_vlalienacaobens}
                               ,{$this->si201_vlamortemprestimo}
                               ,{$this->si201_vltransfcapital}
                               ,{$this->si201_vloutrasreccapital}
                               ,{$this->si201_vlrecarrecadaxeant}
                               ,{$this->si201_vlopcredrefintermob}
                               ,{$this->si201_vlopcredrefintcontrat}
                               ,{$this->si201_vlopcredrefextmob}
                               ,{$this->si201_vlopcredrefextcontrat}
                               ,{$this->si201_vldeficit}
                               ,{$this->si201_vltotalquadroreceita}
                      )";

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bodcasp102018 ($this->si201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bodcasp102018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bodcasp102018 ($this->si201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si201_sequencial=null) {
      $this->atualizacampos();
     $sql = " update bodcasp102018 set ";
     $virgula = "";
     if(trim($this->si201_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_sequencial"])){
       $sql  .= $virgula." si201_sequencial = $this->si201_sequencial ";
       $virgula = ",";
       if(trim($this->si201_sequencial) == null ){
         $this->erro_sql = " Campo si201_sequencial não informado.";
         $this->erro_campo = "si201_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"])){
       $sql  .= $virgula." si201_tiporegistro = $this->si201_tiporegistro ";
       $virgula = ",";
       if(trim($this->si201_tiporegistro) == null ){
         $this->erro_sql = " Campo si201_tiporegistro não informado.";
         $this->erro_campo = "si201_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_faserecorcamentaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_faserecorcamentaria"])){
       $sql  .= $virgula." si201_faserecorcamentaria = $this->si201_faserecorcamentaria ";
       $virgula = ",";
       if(trim($this->si201_faserecorcamentaria) == null ){
         $this->erro_sql = " Campo si201_faserecorcamentaria não informado.";
         $this->erro_campo = "si201_faserecorcamentaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlrectributaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlrectributaria"])){
       $sql  .= $virgula." si201_vlrectributaria = $this->si201_vlrectributaria ";
       $virgula = ",";
       if(trim($this->si201_vlrectributaria) == null ){
         $this->erro_sql = " Campo si201_vlrectributaria não informado.";
         $this->erro_campo = "si201_vlrectributaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlreccontribuicoes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlreccontribuicoes"])){
       $sql  .= $virgula." si201_vlreccontribuicoes = $this->si201_vlreccontribuicoes ";
       $virgula = ",";
       if(trim($this->si201_vlreccontribuicoes) == null ){
         $this->erro_sql = " Campo si201_vlreccontribuicoes não informado.";
         $this->erro_campo = "si201_vlreccontribuicoes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlrecpatrimonial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlrecpatrimonial"])){
       $sql  .= $virgula." si201_vlrecpatrimonial = $this->si201_vlrecpatrimonial ";
       $virgula = ",";
       if(trim($this->si201_vlrecpatrimonial) == null ){
         $this->erro_sql = " Campo si201_vlrecpatrimonial não informado.";
         $this->erro_campo = "si201_vlrecpatrimonial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlrecagropecuaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlrecagropecuaria"])){
       $sql  .= $virgula." si201_vlrecagropecuaria = $this->si201_vlrecagropecuaria ";
       $virgula = ",";
       if(trim($this->si201_vlrecagropecuaria) == null ){
         $this->erro_sql = " Campo si201_vlrecagropecuaria não informado.";
         $this->erro_campo = "si201_vlrecagropecuaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlrecindustrial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlrecindustrial"])){
       $sql  .= $virgula." si201_vlrecindustrial = $this->si201_vlrecindustrial ";
       $virgula = ",";
       if(trim($this->si201_vlrecindustrial) == null ){
         $this->erro_sql = " Campo si201_vlrecindustrial não informado.";
         $this->erro_campo = "si201_vlrecindustrial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlrecservicos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlrecservicos"])){
       $sql  .= $virgula." si201_vlrecservicos = $this->si201_vlrecservicos ";
       $virgula = ",";
       if(trim($this->si201_vlrecservicos) == null ){
         $this->erro_sql = " Campo si201_vlrecservicos não informado.";
         $this->erro_campo = "si201_vlrecservicos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vltransfcorrentes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vltransfcorrentes"])){
       $sql  .= $virgula." si201_vltransfcorrentes = $this->si201_vltransfcorrentes ";
       $virgula = ",";
       if(trim($this->si201_vltransfcorrentes) == null ){
         $this->erro_sql = " Campo si201_vltransfcorrentes não informado.";
         $this->erro_campo = "si201_vltransfcorrentes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vloutrasreccorrentes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vloutrasreccorrentes"])){
       $sql  .= $virgula." si201_vloutrasreccorrentes = $this->si201_vloutrasreccorrentes ";
       $virgula = ",";
       if(trim($this->si201_vloutrasreccorrentes) == null ){
         $this->erro_sql = " Campo si201_vloutrasreccorrentes não informado.";
         $this->erro_campo = "si201_vloutrasreccorrentes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vloperacoescredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vloperacoescredito"])){
       $sql  .= $virgula." si201_vloperacoescredito = $this->si201_vloperacoescredito ";
       $virgula = ",";
       if(trim($this->si201_vloperacoescredito) == null ){
         $this->erro_sql = " Campo si201_vloperacoescredito não informado.";
         $this->erro_campo = "si201_vloperacoescredito";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlalienacaobens)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlalienacaobens"])){
       $sql  .= $virgula." si201_vlalienacaobens = $this->si201_vlalienacaobens ";
       $virgula = ",";
       if(trim($this->si201_vlalienacaobens) == null ){
         $this->erro_sql = " Campo si201_vlalienacaobens não informado.";
         $this->erro_campo = "si201_vlalienacaobens";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlamortemprestimo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlamortemprestimo"])){
       $sql  .= $virgula." si201_vlamortemprestimo = $this->si201_vlamortemprestimo ";
       $virgula = ",";
       if(trim($this->si201_vlamortemprestimo) == null ){
         $this->erro_sql = " Campo si201_vlamortemprestimo não informado.";
         $this->erro_campo = "si201_vlamortemprestimo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vltransfcapital)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vltransfcapital"])){
       $sql  .= $virgula." si201_vltransfcapital = $this->si201_vltransfcapital ";
       $virgula = ",";
       if(trim($this->si201_vltransfcapital) == null ){
         $this->erro_sql = " Campo si201_vltransfcapital não informado.";
         $this->erro_campo = "si201_vltransfcapital";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vloutrasreccapital)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vloutrasreccapital"])){
       $sql  .= $virgula." si201_vloutrasreccapital = $this->si201_vloutrasreccapital ";
       $virgula = ",";
       if(trim($this->si201_vloutrasreccapital) == null ){
         $this->erro_sql = " Campo si201_vloutrasreccapital não informado.";
         $this->erro_campo = "si201_vloutrasreccapital";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlrecarrecadaxeant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlrecarrecadaxeant"])){
       $sql  .= $virgula." si201_vlrecarrecadaxeant = $this->si201_vlrecarrecadaxeant ";
       $virgula = ",";
       if(trim($this->si201_vlrecarrecadaxeant) == null ){
         $this->erro_sql = " Campo si201_vlrecarrecadaxeant não informado.";
         $this->erro_campo = "si201_vlrecarrecadaxeant";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlopcredrefintermob)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefintermob"])){
       $sql  .= $virgula." si201_vlopcredrefintermob = $this->si201_vlopcredrefintermob ";
       $virgula = ",";
       if(trim($this->si201_vlopcredrefintermob) == null ){
         $this->erro_sql = " Campo si201_vlopcredrefintermob não informado.";
         $this->erro_campo = "si201_vlopcredrefintermob";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlopcredrefintcontrat)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefintcontrat"])){
       $sql  .= $virgula." si201_vlopcredrefintcontrat = $this->si201_vlopcredrefintcontrat ";
       $virgula = ",";
       if(trim($this->si201_vlopcredrefintcontrat) == null ){
         $this->erro_sql = " Campo si201_vlopcredrefintcontrat não informado.";
         $this->erro_campo = "si201_vlopcredrefintcontrat";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlopcredrefextmob)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefextmob"])){
       $sql  .= $virgula." si201_vlopcredrefextmob = $this->si201_vlopcredrefextmob ";
       $virgula = ",";
       if(trim($this->si201_vlopcredrefextmob) == null ){
         $this->erro_sql = " Campo si201_vlopcredrefextmob não informado.";
         $this->erro_campo = "si201_vlopcredrefextmob";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vlopcredrefextcontrat)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vlopcredrefextcontrat"])){
       $sql  .= $virgula." si201_vlopcredrefextcontrat = $this->si201_vlopcredrefextcontrat ";
       $virgula = ",";
       if(trim($this->si201_vlopcredrefextcontrat) == null ){
         $this->erro_sql = " Campo si201_vlopcredrefextcontrat não informado.";
         $this->erro_campo = "si201_vlopcredrefextcontrat";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vldeficit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vldeficit"])){
       $sql  .= $virgula." si201_vldeficit = $this->si201_vldeficit ";
       $virgula = ",";
       if(trim($this->si201_vldeficit) == null ){
         $this->erro_sql = " Campo si201_vldeficit não informado.";
         $this->erro_campo = "si201_vldeficit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si201_vltotalquadroreceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_vltotalquadroreceita"])){
       $sql  .= $virgula." si201_vltotalquadroreceita = $this->si201_vltotalquadroreceita ";
       $virgula = ",";
       if(trim($this->si201_vltotalquadroreceita) == null ){
         $this->erro_sql = " Campo si201_vltotalquadroreceita não informado.";
         $this->erro_campo = "si201_vltotalquadroreceita";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si201_sequencial!=null){
       $sql .= " si201_sequencial = $this->si201_sequencial";
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp102018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp102018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si201_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si201_sequencial=null,$dbwhere=null) {

     $sql = " delete from bodcasp102018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si201_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si201_sequencial = $si201_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp102018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si201_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp102018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si201_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si201_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bodcasp102018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp102018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si201_sequencial!=null ){
         $sql2 .= " where bodcasp102018.si201_sequencial = $si201_sequencial ";
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
   function sql_query_file ( $si201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp102018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si201_sequencial!=null ){
         $sql2 .= " where bodcasp102018.si201_sequencial = $si201_sequencial ";
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
