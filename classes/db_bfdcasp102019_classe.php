<?
//MODULO: sicom
//CLASSE DA ENTIDADE bfdcasp102019
class cl_bfdcasp102019 {
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
   var $si206_sequencial = 0;
   var $si206_tiporegistro = 0;
   var $si206_vlrecorcamenrecurord = 0;
   var $si206_vlrecorcamenrecinceduc = 0;
   var $si206_vlrecorcamenrecurvincusaude = 0;
   var $si206_vlrecorcamenrecurvincurpps = 0;
   var $si206_vlrecorcamenrecurvincuassistsoc = 0;
   var $si206_vlrecorcamenoutrasdestrecursos = 0;
   var $si206_vltransfinanexecuorcamentaria = 0;
   var $si206_vltransfinanindepenexecuorc = 0;
   var $si206_vltransfinanreceaportesrpps = 0;
   var $si206_vlincrirspnaoprocessado = 0;
   var $si206_vlincrirspprocessado = 0;
   var $si206_vldeporestituvinculados = 0;
   var $si206_vloutrosrecextraorcamentario = 0;
   var $si206_vlsaldoexeranteriorcaixaequicaixa = 0;
   var $si206_vlsaldoexerantdeporestvinc = 0;
   var $si206_vltotalingresso = 0;
   var $si206_ano     = 0;
   var $si206_periodo = 0;
   var $si206_institu = 0;

   // cria propriedade com as variaveis do arquivo
   var $campos = "
                si206_ano      = int4 = si206_ano;
                si206_periodo  = int4 = si206_periodo;
                si206_institu  = int4 = si206_institu;
                 si206_sequencial = int4 = si206_sequencial
                 si206_tiporegistro = int4 = si206_tiporegistro
                 si206_vlrecorcamenrecurord = float8 = si206_vlrecorcamenrecurord
                 si206_vlrecorcamenrecinceduc = float8 = si206_vlrecorcamenrecinceduc
                 si206_vlrecorcamenrecurvincusaude = float8 = si206_vlrecorcamenrecurvincusaude
                 si206_vlrecorcamenrecurvincurpps = float8 = si206_vlrecorcamenrecurvincurpps
                 si206_vlrecorcamenrecurvincuassistsoc = float8 = si206_vlrecorcamenrecurvincuassistsoc
                 si206_vlrecorcamenoutrasdestrecursos = float8 = si206_vlrecorcamenoutrasdestrecursos
                 si206_vltransfinanexecuorcamentaria = float8 = si206_vltransfinanexecuorcamentaria
                 si206_vltransfinanindepenexecuorc = float8 = si206_vltransfinanindepenexecuorc
                 si206_vltransfinanreceaportesrpps = float8 = si206_vltransfinanreceaportesrpps
                 si206_vlincrirspnaoprocessado = float8 = si206_vlincrirspnaoprocessado
                 si206_vlincrirspprocessado = float8 = si206_vlincrirspprocessado
                 si206_vldeporestituvinculados = float8 = si206_vldeporestituvinculados
                 si206_vloutrosrecextraorcamentario = float8 = si206_vloutrosrecextraorcamentario
                 si206_vlsaldoexeranteriorcaixaequicaixa = float8 = si206_vlsaldoexeranteriorcaixaequicaixa
                 si206_vlsaldoexerantdeporestvinc = float8 = si206_vlsaldoexerantdeporestvinc
                 si206_vltotalingresso = float8 = si206_vltotalingresso
                 ";
   //funcao construtor da classe
   function cl_bfdcasp102019() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bfdcasp102019");
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
       $this->si206_ano = ($this->si206_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_ano"]:$this->si206_ano);
       $this->si206_periodo = ($this->si206_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_periodo"]:$this->si206_periodo);
       $this->si206_institu = ($this->si206_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_institu"]:$this->si206_institu);
       $this->si206_sequencial = ($this->si206_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_sequencial"]:$this->si206_sequencial);
       $this->si206_tiporegistro = ($this->si206_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_tiporegistro"]:$this->si206_tiporegistro);
       $this->si206_vlrecorcamenrecurord = ($this->si206_vlrecorcamenrecurord == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurord"]:$this->si206_vlrecorcamenrecurord);
       $this->si206_vlrecorcamenrecinceduc = ($this->si206_vlrecorcamenrecinceduc == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecinceduc"]:$this->si206_vlrecorcamenrecinceduc);
       $this->si206_vlrecorcamenrecurvincusaude = ($this->si206_vlrecorcamenrecurvincusaude == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurvincusaude"]:$this->si206_vlrecorcamenrecurvincusaude);
       $this->si206_vlrecorcamenrecurvincurpps = ($this->si206_vlrecorcamenrecurvincurpps == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurvincurpps"]:$this->si206_vlrecorcamenrecurvincurpps);
       $this->si206_vlrecorcamenrecurvincuassistsoc = ($this->si206_vlrecorcamenrecurvincuassistsoc == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurvincuassistsoc"]:$this->si206_vlrecorcamenrecurvincuassistsoc);
       $this->si206_vlrecorcamenoutrasdestrecursos = ($this->si206_vlrecorcamenoutrasdestrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenoutrasdestrecursos"]:$this->si206_vlrecorcamenoutrasdestrecursos);
       $this->si206_vltransfinanexecuorcamentaria = ($this->si206_vltransfinanexecuorcamentaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vltransfinanexecuorcamentaria"]:$this->si206_vltransfinanexecuorcamentaria);
       $this->si206_vltransfinanindepenexecuorc = ($this->si206_vltransfinanindepenexecuorc == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vltransfinanindepenexecuorc"]:$this->si206_vltransfinanindepenexecuorc);
       $this->si206_vltransfinanreceaportesrpps = ($this->si206_vltransfinanreceaportesrpps == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vltransfinanreceaportesrpps"]:$this->si206_vltransfinanreceaportesrpps);
       $this->si206_vlincrirspnaoprocessado = ($this->si206_vlincrirspnaoprocessado == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlincrirspnaoprocessado"]:$this->si206_vlincrirspnaoprocessado);
       $this->si206_vlincrirspprocessado = ($this->si206_vlincrirspprocessado == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlincrirspprocessado"]:$this->si206_vlincrirspprocessado);
       $this->si206_vldeporestituvinculados = ($this->si206_vldeporestituvinculados == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vldeporestituvinculados"]:$this->si206_vldeporestituvinculados);
       $this->si206_vloutrosrecextraorcamentario = ($this->si206_vloutrosrecextraorcamentario == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vloutrosrecextraorcamentario"]:$this->si206_vloutrosrecextraorcamentario);
       $this->si206_vlsaldoexeranteriorcaixaequicaixa = ($this->si206_vlsaldoexeranteriorcaixaequicaixa == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlsaldoexeranteriorcaixaequicaixa"]:$this->si206_vlsaldoexeranteriorcaixaequicaixa);
       $this->si206_vlsaldoexerantdeporestvinc = ($this->si206_vlsaldoexerantdeporestvinc == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vlsaldoexerantdeporestvinc"]:$this->si206_vlsaldoexerantdeporestvinc);
       $this->si206_vltotalingresso = ($this->si206_vltotalingresso == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_vltotalingresso"]:$this->si206_vltotalingresso);
     }else{
       $this->si206_sequencial = ($this->si206_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si206_sequencial"]:$this->si206_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si206_sequencial){
      $this->atualizacampos();
     if ($this->si206_ano == null ) {
       $this->si206_ano = intval(date('Y'));
     }
     if ($this->si206_periodo == null ) {
       $this->si206_periodo = intval(date('m') + 16);
     }
     if ($this->si206_institu == null ) {
       $this->si206_institu = db_getsession("DB_instit");
     }

     if($this->si206_tiporegistro == null ){
        $this->si206_tiporegistro = 10;
     }
     if($this->si206_vlrecorcamenrecurord == null ){
        $this->si206_vlrecorcamenrecurord = 0;
     }
     if($this->si206_vlrecorcamenrecinceduc == null ){
        $this->si206_vlrecorcamenrecinceduc = 0;
     }
     if($this->si206_vlrecorcamenrecurvincusaude == null ){
        $this->si206_vlrecorcamenrecurvincusaude = 0;
     }
     if($this->si206_vlrecorcamenrecurvincurpps == null ){
        $this->si206_vlrecorcamenrecurvincurpps = 0;
     }
     if($this->si206_vlrecorcamenrecurvincuassistsoc == null ){
        $this->si206_vlrecorcamenrecurvincuassistsoc = 0;
     }
     if($this->si206_vlrecorcamenoutrasdestrecursos == null ){
        $this->si206_vlrecorcamenoutrasdestrecursos = 0;
     }
     if($this->si206_vltransfinanexecuorcamentaria == null ){
        $this->si206_vltransfinanexecuorcamentaria = 0;
     }
     if($this->si206_vltransfinanindepenexecuorc == null ){
        $this->si206_vltransfinanindepenexecuorc = 0;
     }
     if($this->si206_vltransfinanreceaportesrpps == null ){
        $this->si206_vltransfinanreceaportesrpps = 0;
     }
     if($this->si206_vlincrirspnaoprocessado == null ){
        $this->si206_vlincrirspnaoprocessado = 0;
     }
     if($this->si206_vlincrirspprocessado == null ){
        $this->si206_vlincrirspprocessado = 0;
     }
     if($this->si206_vldeporestituvinculados == null ){
        $this->si206_vldeporestituvinculados = 0;
     }
     if($this->si206_vloutrosrecextraorcamentario == null ){
        $this->si206_vloutrosrecextraorcamentario = 0;
     }
     if($this->si206_vlsaldoexeranteriorcaixaequicaixa == null ){
        $this->si206_vlsaldoexeranteriorcaixaequicaixa = 0;
     }
     if($this->si206_vlsaldoexerantdeporestvinc == null ){
        $this->si206_vlsaldoexerantdeporestvinc = 0;
     }
     if($this->si206_vltotalingresso == null ){
        $this->si206_vltotalingresso = 0;
     }

     if($si206_sequencial == "" || $si206_sequencial == null ){
       $result = db_query("select nextval('bfdcasp102019_si206_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: bfdcasp102019_si206_sequencial_seq do campo: si206_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si206_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from bfdcasp102019_si206_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si206_sequencial)){
         $this->erro_sql = " Campo si206_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si206_sequencial = $si206_sequencial;
       }
     }

     if(($this->si206_sequencial == null) || ($this->si206_sequencial == "") ){
       $this->erro_sql = " Campo si206_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into bfdcasp102019(
                                       si206_sequencial
                                      ,si206_tiporegistro
                                      ,si206_vlrecorcamenrecurord
                                      ,si206_vlrecorcamenrecinceduc
                                      ,si206_vlrecorcamenrecurvincusaude
                                      ,si206_vlrecorcamenrecurvincurpps
                                      ,si206_vlrecorcamenrecurvincuassistsoc
                                      ,si206_vlrecorcamenoutrasdestrecursos
                                      ,si206_vltransfinanexecuorcamentaria
                                      ,si206_vltransfinanindepenexecuorc
                                      ,si206_vltransfinanreceaportesrpps
                                      ,si206_vlincrirspnaoprocessado
                                      ,si206_vlincrirspprocessado
                                      ,si206_vldeporestituvinculados
                                      ,si206_vloutrosrecextraorcamentario
                                      ,si206_vlsaldoexeranteriorcaixaequicaixa
                                      ,si206_vlsaldoexerantdeporestvinc
                                      ,si206_vltotalingresso
                                        ,si206_ano
                                        ,si206_periodo
                                        ,si206_institu

                       )
                values (
                                $this->si206_sequencial
                               ,$this->si206_tiporegistro
                               ,$this->si206_vlrecorcamenrecurord
                               ,$this->si206_vlrecorcamenrecinceduc
                               ,$this->si206_vlrecorcamenrecurvincusaude
                               ,$this->si206_vlrecorcamenrecurvincurpps
                               ,$this->si206_vlrecorcamenrecurvincuassistsoc
                               ,$this->si206_vlrecorcamenoutrasdestrecursos
                               ,$this->si206_vltransfinanexecuorcamentaria
                               ,$this->si206_vltransfinanindepenexecuorc
                               ,$this->si206_vltransfinanreceaportesrpps
                               ,$this->si206_vlincrirspnaoprocessado
                               ,$this->si206_vlincrirspprocessado
                               ,$this->si206_vldeporestituvinculados
                               ,$this->si206_vloutrosrecextraorcamentario
                               ,$this->si206_vlsaldoexeranteriorcaixaequicaixa
                               ,$this->si206_vlsaldoexerantdeporestvinc
                               ,$this->si206_vltotalingresso
                                ,{$this->si206_ano}
                                ,{$this->si206_periodo}
                                ,{$this->si206_institu}
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bfdcasp102019 ($this->si206_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bfdcasp102019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bfdcasp102019 ($this->si206_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si206_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si206_sequencial=null) {
      $this->atualizacampos();
     $sql = " update bfdcasp102019 set ";
     $virgula = "";
     if(trim($this->si206_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_sequencial"])){
       $sql  .= $virgula." si206_sequencial = $this->si206_sequencial ";
       $virgula = ",";
       if(trim($this->si206_sequencial) == null ){
         $this->erro_sql = " Campo si206_sequencial não informado.";
         $this->erro_campo = "si206_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_tiporegistro"])){
       $sql  .= $virgula." si206_tiporegistro = $this->si206_tiporegistro ";
       $virgula = ",";
       if(trim($this->si206_tiporegistro) == null ){
         $this->erro_sql = " Campo si206_tiporegistro não informado.";
         $this->erro_campo = "si206_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlrecorcamenrecurord)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurord"])){
       $sql  .= $virgula." si206_vlrecorcamenrecurord = $this->si206_vlrecorcamenrecurord ";
       $virgula = ",";
       if(trim($this->si206_vlrecorcamenrecurord) == null ){
         $this->erro_sql = " Campo si206_vlrecorcamenrecurord não informado.";
         $this->erro_campo = "si206_vlrecorcamenrecurord";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlrecorcamenrecinceduc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecinceduc"])){
       $sql  .= $virgula." si206_vlrecorcamenrecinceduc = $this->si206_vlrecorcamenrecinceduc ";
       $virgula = ",";
       if(trim($this->si206_vlrecorcamenrecinceduc) == null ){
         $this->erro_sql = " Campo si206_vlrecorcamenrecinceduc não informado.";
         $this->erro_campo = "si206_vlrecorcamenrecinceduc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlrecorcamenrecurvincusaude)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurvincusaude"])){
       $sql  .= $virgula." si206_vlrecorcamenrecurvincusaude = $this->si206_vlrecorcamenrecurvincusaude ";
       $virgula = ",";
       if(trim($this->si206_vlrecorcamenrecurvincusaude) == null ){
         $this->erro_sql = " Campo si206_vlrecorcamenrecurvincusaude não informado.";
         $this->erro_campo = "si206_vlrecorcamenrecurvincusaude";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlrecorcamenrecurvincurpps)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurvincurpps"])){
       $sql  .= $virgula." si206_vlrecorcamenrecurvincurpps = $this->si206_vlrecorcamenrecurvincurpps ";
       $virgula = ",";
       if(trim($this->si206_vlrecorcamenrecurvincurpps) == null ){
         $this->erro_sql = " Campo si206_vlrecorcamenrecurvincurpps não informado.";
         $this->erro_campo = "si206_vlrecorcamenrecurvincurpps";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlrecorcamenrecurvincuassistsoc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenrecurvincuassistsoc"])){
       $sql  .= $virgula." si206_vlrecorcamenrecurvincuassistsoc = $this->si206_vlrecorcamenrecurvincuassistsoc ";
       $virgula = ",";
       if(trim($this->si206_vlrecorcamenrecurvincuassistsoc) == null ){
         $this->erro_sql = " Campo si206_vlrecorcamenrecurvincuassistsoc não informado.";
         $this->erro_campo = "si206_vlrecorcamenrecurvincuassistsoc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlrecorcamenoutrasdestrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlrecorcamenoutrasdestrecursos"])){
       $sql  .= $virgula." si206_vlrecorcamenoutrasdestrecursos = $this->si206_vlrecorcamenoutrasdestrecursos ";
       $virgula = ",";
       if(trim($this->si206_vlrecorcamenoutrasdestrecursos) == null ){
         $this->erro_sql = " Campo si206_vlrecorcamenoutrasdestrecursos não informado.";
         $this->erro_campo = "si206_vlrecorcamenoutrasdestrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vltransfinanexecuorcamentaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vltransfinanexecuorcamentaria"])){
       $sql  .= $virgula." si206_vltransfinanexecuorcamentaria = $this->si206_vltransfinanexecuorcamentaria ";
       $virgula = ",";
       if(trim($this->si206_vltransfinanexecuorcamentaria) == null ){
         $this->erro_sql = " Campo si206_vltransfinanexecuorcamentaria não informado.";
         $this->erro_campo = "si206_vltransfinanexecuorcamentaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vltransfinanindepenexecuorc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vltransfinanindepenexecuorc"])){
       $sql  .= $virgula." si206_vltransfinanindepenexecuorc = $this->si206_vltransfinanindepenexecuorc ";
       $virgula = ",";
       if(trim($this->si206_vltransfinanindepenexecuorc) == null ){
         $this->erro_sql = " Campo si206_vltransfinanindepenexecuorc não informado.";
         $this->erro_campo = "si206_vltransfinanindepenexecuorc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vltransfinanreceaportesrpps)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vltransfinanreceaportesrpps"])){
       $sql  .= $virgula." si206_vltransfinanreceaportesrpps = $this->si206_vltransfinanreceaportesrpps ";
       $virgula = ",";
       if(trim($this->si206_vltransfinanreceaportesrpps) == null ){
         $this->erro_sql = " Campo si206_vltransfinanreceaportesrpps não informado.";
         $this->erro_campo = "si206_vltransfinanreceaportesrpps";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlincrirspnaoprocessado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlincrirspnaoprocessado"])){
       $sql  .= $virgula." si206_vlincrirspnaoprocessado = $this->si206_vlincrirspnaoprocessado ";
       $virgula = ",";
       if(trim($this->si206_vlincrirspnaoprocessado) == null ){
         $this->erro_sql = " Campo si206_vlincrirspnaoprocessado não informado.";
         $this->erro_campo = "si206_vlincrirspnaoprocessado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlincrirspprocessado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlincrirspprocessado"])){
       $sql  .= $virgula." si206_vlincrirspprocessado = $this->si206_vlincrirspprocessado ";
       $virgula = ",";
       if(trim($this->si206_vlincrirspprocessado) == null ){
         $this->erro_sql = " Campo si206_vlincrirspprocessado não informado.";
         $this->erro_campo = "si206_vlincrirspprocessado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vldeporestituvinculados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vldeporestituvinculados"])){
       $sql  .= $virgula." si206_vldeporestituvinculados = $this->si206_vldeporestituvinculados ";
       $virgula = ",";
       if(trim($this->si206_vldeporestituvinculados) == null ){
         $this->erro_sql = " Campo si206_vldeporestituvinculados não informado.";
         $this->erro_campo = "si206_vldeporestituvinculados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vloutrosrecextraorcamentario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vloutrosrecextraorcamentario"])){
       $sql  .= $virgula." si206_vloutrosrecextraorcamentario = $this->si206_vloutrosrecextraorcamentario ";
       $virgula = ",";
       if(trim($this->si206_vloutrosrecextraorcamentario) == null ){
         $this->erro_sql = " Campo si206_vloutrosrecextraorcamentario não informado.";
         $this->erro_campo = "si206_vloutrosrecextraorcamentario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlsaldoexeranteriorcaixaequicaixa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlsaldoexeranteriorcaixaequicaixa"])){
       $sql  .= $virgula." si206_vlsaldoexeranteriorcaixaequicaixa = $this->si206_vlsaldoexeranteriorcaixaequicaixa ";
       $virgula = ",";
       if(trim($this->si206_vlsaldoexeranteriorcaixaequicaixa) == null ){
         $this->erro_sql = " Campo si206_vlsaldoexeranteriorcaixaequicaixa não informado.";
         $this->erro_campo = "si206_vlsaldoexeranteriorcaixaequicaixa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vlsaldoexerantdeporestvinc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vlsaldoexerantdeporestvinc"])){
       $sql  .= $virgula." si206_vlsaldoexerantdeporestvinc = $this->si206_vlsaldoexerantdeporestvinc ";
       $virgula = ",";
       if(trim($this->si206_vlsaldoexerantdeporestvinc) == null ){
         $this->erro_sql = " Campo si206_vlsaldoexerantdeporestvinc não informado.";
         $this->erro_campo = "si206_vlsaldoexerantdeporestvinc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_vltotalingresso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_vltotalingresso"])){
       $sql  .= $virgula." si206_vltotalingresso = $this->si206_vltotalingresso ";
       $virgula = ",";
       if(trim($this->si206_vltotalingresso) == null ){
         $this->erro_sql = " Campo si206_vltotalingresso não informado.";
         $this->erro_campo = "si206_vltotalingresso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_ano"])){
       $sql  .= $virgula." si206_ano = $this->si206_ano ";
       $virgula = ",";
       if(trim($this->si206_ano) == null ){
         $this->erro_sql = " Campo si206_ano não informado.";
         $this->erro_campo = "si206_ano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_periodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_periodo"])){
       $sql  .= $virgula." si206_periodo = $this->si206_periodo ";
       $virgula = ",";
       if(trim($this->si206_periodo) == null ){
         $this->erro_sql = " Campo si206_periodo não informado.";
         $this->erro_campo = "si206_periodo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si206_institu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si206_institu"])){
       $sql  .= $virgula." si206_institu = $this->si206_institu ";
       $virgula = ",";
       if(trim($this->si206_institu) == null ){
         $this->erro_sql = " Campo si206_institu não informado.";
         $this->erro_campo = "si206_institu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si206_sequencial!=null){
       $sql .= " si206_sequencial = $this->si206_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bfdcasp102019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si206_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bfdcasp102019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si206_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si206_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si206_sequencial=null,$dbwhere=null) {

     $sql = " delete from bfdcasp102019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si206_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si206_sequencial = $si206_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bfdcasp102019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si206_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bfdcasp102019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si206_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si206_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bfdcasp102019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si206_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bfdcasp102019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si206_sequencial!=null ){
         $sql2 .= " where bfdcasp102019.si206_sequencial = $si206_sequencial ";
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
   function sql_query_file ( $si206_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bfdcasp102019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si206_sequencial!=null ){
         $sql2 .= " where bfdcasp102019.si206_sequencial = $si206_sequencial ";
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
