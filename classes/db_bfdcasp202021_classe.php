<?
//MODULO: sicom
//CLASSE DA ENTIDADE bfdcasp202120
class cl_bfdcasp202120 {
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
   var $si207_sequencial = 0;
   var $si207_tiporegistro = 0;
   var $si207_vldesporcamenrecurordinarios = 0;
   var $si207_vldesporcamenrecurvincueducacao = 0;
   var $si207_vldesporcamenrecurvincusaude = 0;
   var $si207_vldesporcamenrecurvincurpps = 0;
   var $si207_vldesporcamenrecurvincuassistsoc = 0;
   var $si207_vloutrasdesporcamendestrecursos = 0;
   var $si207_vltransfinanconcexecorcamentaria = 0;
   var $si207_vltransfinanconcindepenexecorc = 0;
   var $si207_vltransfinanconcaportesrecurpps = 0;
   var $si207_vlpagrspnaoprocessado = 0;
   var $si207_vlpagrspprocessado = 0;
   var $si207_vldeposrestvinculados = 0;
   var $si207_vloutrospagextraorcamentarios = 0;
   var $si207_vlsaldoexeratualcaixaequicaixa = 0;
   var $si207_vlsaldoexeratualdeporestvinc = 0;
   var $si207_vltotaldispendios = 0;
   var $si207_ano     = 0;
   var $si207_periodo = 0;
   var $si207_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                si207_ano      = int4 = si207_ano;
                si207_periodo  = int4 = si207_periodo;
                si207_institu  = int4 = si207_institu;
                 si207_sequencial = int4 = si207_sequencial
                 si207_tiporegistro = int4 = si207_tiporegistro
                 si207_vldesporcamenrecurordinarios = float8 = si207_vldesporcamenrecurordinarios
                 si207_vldesporcamenrecurvincueducacao = float8 = si207_vldesporcamenrecurvincueducacao
                 si207_vldesporcamenrecurvincusaude = float8 = si207_vldesporcamenrecurvincusaude
                 si207_vldesporcamenrecurvincurpps = float8 = si207_vldesporcamenrecurvincurpps
                 si207_vldesporcamenrecurvincuassistsoc = float8 = si207_vldesporcamenrecurvincuassistsoc
                 si207_vloutrasdesporcamendestrecursos = float8 = si207_vloutrasdesporcamendestrecursos
                 si207_vltransfinanconcexecorcamentaria = float8 = si207_vltransfinanconcexecorcamentaria
                 si207_vltransfinanconcindepenexecorc = float8 = si207_vltransfinanconcindepenexecorc
                 si207_vltransfinanconcaportesrecurpps = float8 = si207_vltransfinanconcaportesrecurpps
                 si207_vlpagrspnaoprocessado = float8 = si207_vlpagrspnaoprocessado
                 si207_vlpagrspprocessado = float8 = si207_vlpagrspprocessado
                 si207_vldeposrestvinculados = float8 = si207_vldeposrestvinculados
                 si207_vloutrospagextraorcamentarios = float8 = si207_vloutrospagextraorcamentarios
                 si207_vlsaldoexeratualcaixaequicaixa = float8 = si207_vlsaldoexeratualcaixaequicaixa
                 si207_vlsaldoexeratualdeporestvinc = float8 = si207_vlsaldoexeratualdeporestvinc
                 si207_vltotaldispendios = float8 = si207_vltotaldispendios
                 ";
   //funcao construtor da classe
   function cl_bfdcasp202120() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bfdcasp202120");
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
       $this->si207_ano = ($this->si207_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_ano"]:$this->si207_ano);
       $this->si207_periodo = ($this->si207_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_periodo"]:$this->si207_periodo);
       $this->si207_institu = ($this->si207_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_institu"]:$this->si207_institu);
       $this->si207_sequencial = ($this->si207_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_sequencial"]:$this->si207_sequencial);
       $this->si207_tiporegistro = ($this->si207_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_tiporegistro"]:$this->si207_tiporegistro);
       $this->si207_vldesporcamenrecurordinarios = ($this->si207_vldesporcamenrecurordinarios == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurordinarios"]:$this->si207_vldesporcamenrecurordinarios);
       $this->si207_vldesporcamenrecurvincueducacao = ($this->si207_vldesporcamenrecurvincueducacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincueducacao"]:$this->si207_vldesporcamenrecurvincueducacao);
       $this->si207_vldesporcamenrecurvincusaude = ($this->si207_vldesporcamenrecurvincusaude == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincusaude"]:$this->si207_vldesporcamenrecurvincusaude);
       $this->si207_vldesporcamenrecurvincurpps = ($this->si207_vldesporcamenrecurvincurpps == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincurpps"]:$this->si207_vldesporcamenrecurvincurpps);
       $this->si207_vldesporcamenrecurvincuassistsoc = ($this->si207_vldesporcamenrecurvincuassistsoc == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincuassistsoc"]:$this->si207_vldesporcamenrecurvincuassistsoc);
       $this->si207_vloutrasdesporcamendestrecursos = ($this->si207_vloutrasdesporcamendestrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vloutrasdesporcamendestrecursos"]:$this->si207_vloutrasdesporcamendestrecursos);
       $this->si207_vltransfinanconcexecorcamentaria = ($this->si207_vltransfinanconcexecorcamentaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcexecorcamentaria"]:$this->si207_vltransfinanconcexecorcamentaria);
       $this->si207_vltransfinanconcindepenexecorc = ($this->si207_vltransfinanconcindepenexecorc == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcindepenexecorc"]:$this->si207_vltransfinanconcindepenexecorc);
       $this->si207_vltransfinanconcaportesrecurpps = ($this->si207_vltransfinanconcaportesrecurpps == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcaportesrecurpps"]:$this->si207_vltransfinanconcaportesrecurpps);
       $this->si207_vlpagrspnaoprocessado = ($this->si207_vlpagrspnaoprocessado == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vlpagrspnaoprocessado"]:$this->si207_vlpagrspnaoprocessado);
       $this->si207_vlpagrspprocessado = ($this->si207_vlpagrspprocessado == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vlpagrspprocessado"]:$this->si207_vlpagrspprocessado);
       $this->si207_vldeposrestvinculados = ($this->si207_vldeposrestvinculados == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vldeposrestvinculados"]:$this->si207_vldeposrestvinculados);
       $this->si207_vloutrospagextraorcamentarios = ($this->si207_vloutrospagextraorcamentarios == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vloutrospagextraorcamentarios"]:$this->si207_vloutrospagextraorcamentarios);
       $this->si207_vlsaldoexeratualcaixaequicaixa = ($this->si207_vlsaldoexeratualcaixaequicaixa == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vlsaldoexeratualcaixaequicaixa"]:$this->si207_vlsaldoexeratualcaixaequicaixa);
       $this->si207_vlsaldoexeratualdeporestvinc = ($this->si207_vlsaldoexeratualdeporestvinc == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vlsaldoexeratualdeporestvinc"]:$this->si207_vlsaldoexeratualdeporestvinc);
       $this->si207_vltotaldispendios = ($this->si207_vltotaldispendios == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_vltotaldispendios"]:$this->si207_vltotaldispendios);
     }else{
       $this->si207_sequencial = ($this->si207_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_sequencial"]:$this->si207_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si207_sequencial){
      $this->atualizacampos();
     if($this->si207_tiporegistro == null ){
        $this->si207_tiporegistro = 20;
     }
     if($this->si207_vldesporcamenrecurordinarios == null ){
        $this->si207_vldesporcamenrecurordinarios = 0;
     }
     if($this->si207_vldesporcamenrecurvincueducacao == null ){
        $this->si207_vldesporcamenrecurvincueducacao = 0;
     }
     if($this->si207_vldesporcamenrecurvincusaude == null ){
        $this->si207_vldesporcamenrecurvincusaude = 0;
     }
     if($this->si207_vldesporcamenrecurvincurpps == null ){
        $this->si207_vldesporcamenrecurvincurpps = 0;
     }
     if($this->si207_vldesporcamenrecurvincuassistsoc == null ){
        $this->si207_vldesporcamenrecurvincuassistsoc = 0;
     }
     if($this->si207_vloutrasdesporcamendestrecursos == null ){
        $this->si207_vloutrasdesporcamendestrecursos = 0;
     }
     if($this->si207_vltransfinanconcexecorcamentaria == null ){
        $this->si207_vltransfinanconcexecorcamentaria = 0;
     }
     if($this->si207_vltransfinanconcindepenexecorc == null ){
        $this->si207_vltransfinanconcindepenexecorc = 0;
     }
     if($this->si207_vltransfinanconcaportesrecurpps == null ){
        $this->si207_vltransfinanconcaportesrecurpps = 0;
     }
     if($this->si207_vlpagrspnaoprocessado == null ){
        $this->si207_vlpagrspnaoprocessado = 0;
     }
     if($this->si207_vlpagrspprocessado == null ){
        $this->si207_vlpagrspprocessado = 0;
     }
     if($this->si207_vldeposrestvinculados == null ){
        $this->si207_vldeposrestvinculados = 0;
     }
     if($this->si207_vloutrospagextraorcamentarios == null ){
        $this->si207_vloutrospagextraorcamentarios = 0;
     }
     if($this->si207_vlsaldoexeratualcaixaequicaixa == null ){
        $this->si207_vlsaldoexeratualcaixaequicaixa = 0;
     }
     if($this->si207_vlsaldoexeratualdeporestvinc == null ){
        $this->si207_vlsaldoexeratualdeporestvinc = 0;
     }
     if($this->si207_vltotaldispendios == null ){
        $this->si207_vltotaldispendios = 0;
     }


     if($si207_sequencial == "" || $si207_sequencial == null ){
       $result = db_query("select nextval('bfdcasp202120_si207_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: bfdcasp202120_si207_sequencial_seq do campo: si207_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si207_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from bfdcasp202120_si207_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si207_sequencial)){
         $this->erro_sql = " Campo si207_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si207_sequencial = $si207_sequencial;
       }
     }

     if(($this->si207_sequencial == null) || ($this->si207_sequencial == "") ){
       $this->erro_sql = " Campo si207_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }

     $sql = "insert into bfdcasp202120(
                                       si207_sequencial
                                      ,si207_tiporegistro
                                      ,si207_vldesporcamenrecurordinarios
                                      ,si207_vldesporcamenrecurvincueducacao
                                      ,si207_vldesporcamenrecurvincusaude
                                      ,si207_vldesporcamenrecurvincurpps
                                      ,si207_vldesporcamenrecurvincuassistsoc
                                      ,si207_vloutrasdesporcamendestrecursos
                                      ,si207_vltransfinanconcexecorcamentaria
                                      ,si207_vltransfinanconcindepenexecorc
                                      ,si207_vltransfinanconcaportesrecurpps
                                      ,si207_vlpagrspnaoprocessado
                                      ,si207_vlpagrspprocessado
                                      ,si207_vldeposrestvinculados
                                      ,si207_vloutrospagextraorcamentarios
                                      ,si207_vlsaldoexeratualcaixaequicaixa
                                      ,si207_vlsaldoexeratualdeporestvinc
                                      ,si207_vltotaldispendios
                                        ,si207_ano
                                        ,si207_periodo
                                        ,si207_institu
                       )
                values (
                                $this->si207_sequencial
                               ,$this->si207_tiporegistro
                               ,$this->si207_vldesporcamenrecurordinarios
                               ,$this->si207_vldesporcamenrecurvincueducacao
                               ,$this->si207_vldesporcamenrecurvincusaude
                               ,$this->si207_vldesporcamenrecurvincurpps
                               ,$this->si207_vldesporcamenrecurvincuassistsoc
                               ,$this->si207_vloutrasdesporcamendestrecursos
                               ,$this->si207_vltransfinanconcexecorcamentaria
                               ,$this->si207_vltransfinanconcindepenexecorc
                               ,$this->si207_vltransfinanconcaportesrecurpps
                               ,$this->si207_vlpagrspnaoprocessado
                               ,$this->si207_vlpagrspprocessado
                               ,$this->si207_vldeposrestvinculados
                               ,$this->si207_vloutrospagextraorcamentarios
                               ,$this->si207_vlsaldoexeratualcaixaequicaixa
                               ,$this->si207_vlsaldoexeratualdeporestvinc
                               ,$this->si207_vltotaldispendios
                                ,{$this->si207_ano}
                                ,{$this->si207_periodo}
                                ,{$this->si207_institu}
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bfdcasp202120 ($this->si207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bfdcasp202120 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bfdcasp202120 ($this->si207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si207_sequencial=null) {
      $this->atualizacampos();
     $sql = " update bfdcasp202120 set ";
     $virgula = "";
     if(trim($this->si207_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_sequencial"])){
       $sql  .= $virgula." si207_sequencial = $this->si207_sequencial ";
       $virgula = ",";
       if(trim($this->si207_sequencial) == null ){
         $this->erro_sql = " Campo si207_sequencial não informado.";
         $this->erro_campo = "si207_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_tiporegistro"])){
       $sql  .= $virgula." si207_tiporegistro = $this->si207_tiporegistro ";
       $virgula = ",";
       if(trim($this->si207_tiporegistro) == null ){
         $this->erro_sql = " Campo si207_tiporegistro não informado.";
         $this->erro_campo = "si207_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vldesporcamenrecurordinarios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurordinarios"])){
       $sql  .= $virgula." si207_vldesporcamenrecurordinarios = $this->si207_vldesporcamenrecurordinarios ";
       $virgula = ",";
       if(trim($this->si207_vldesporcamenrecurordinarios) == null ){
         $this->erro_sql = " Campo si207_vldesporcamenrecurordinarios não informado.";
         $this->erro_campo = "si207_vldesporcamenrecurordinarios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vldesporcamenrecurvincueducacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincueducacao"])){
       $sql  .= $virgula." si207_vldesporcamenrecurvincueducacao = $this->si207_vldesporcamenrecurvincueducacao ";
       $virgula = ",";
       if(trim($this->si207_vldesporcamenrecurvincueducacao) == null ){
         $this->erro_sql = " Campo si207_vldesporcamenrecurvincueducacao não informado.";
         $this->erro_campo = "si207_vldesporcamenrecurvincueducacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vldesporcamenrecurvincusaude)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincusaude"])){
       $sql  .= $virgula." si207_vldesporcamenrecurvincusaude = $this->si207_vldesporcamenrecurvincusaude ";
       $virgula = ",";
       if(trim($this->si207_vldesporcamenrecurvincusaude) == null ){
         $this->erro_sql = " Campo si207_vldesporcamenrecurvincusaude não informado.";
         $this->erro_campo = "si207_vldesporcamenrecurvincusaude";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vldesporcamenrecurvincurpps)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincurpps"])){
       $sql  .= $virgula." si207_vldesporcamenrecurvincurpps = $this->si207_vldesporcamenrecurvincurpps ";
       $virgula = ",";
       if(trim($this->si207_vldesporcamenrecurvincurpps) == null ){
         $this->erro_sql = " Campo si207_vldesporcamenrecurvincurpps não informado.";
         $this->erro_campo = "si207_vldesporcamenrecurvincurpps";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vldesporcamenrecurvincuassistsoc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincuassistsoc"])){
       $sql  .= $virgula." si207_vldesporcamenrecurvincuassistsoc = $this->si207_vldesporcamenrecurvincuassistsoc ";
       $virgula = ",";
       if(trim($this->si207_vldesporcamenrecurvincuassistsoc) == null ){
         $this->erro_sql = " Campo si207_vldesporcamenrecurvincuassistsoc não informado.";
         $this->erro_campo = "si207_vldesporcamenrecurvincuassistsoc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vloutrasdesporcamendestrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vloutrasdesporcamendestrecursos"])){
       $sql  .= $virgula." si207_vloutrasdesporcamendestrecursos = $this->si207_vloutrasdesporcamendestrecursos ";
       $virgula = ",";
       if(trim($this->si207_vloutrasdesporcamendestrecursos) == null ){
         $this->erro_sql = " Campo si207_vloutrasdesporcamendestrecursos não informado.";
         $this->erro_campo = "si207_vloutrasdesporcamendestrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vltransfinanconcexecorcamentaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcexecorcamentaria"])){
       $sql  .= $virgula." si207_vltransfinanconcexecorcamentaria = $this->si207_vltransfinanconcexecorcamentaria ";
       $virgula = ",";
       if(trim($this->si207_vltransfinanconcexecorcamentaria) == null ){
         $this->erro_sql = " Campo si207_vltransfinanconcexecorcamentaria não informado.";
         $this->erro_campo = "si207_vltransfinanconcexecorcamentaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vltransfinanconcindepenexecorc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcindepenexecorc"])){
       $sql  .= $virgula." si207_vltransfinanconcindepenexecorc = $this->si207_vltransfinanconcindepenexecorc ";
       $virgula = ",";
       if(trim($this->si207_vltransfinanconcindepenexecorc) == null ){
         $this->erro_sql = " Campo si207_vltransfinanconcindepenexecorc não informado.";
         $this->erro_campo = "si207_vltransfinanconcindepenexecorc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vltransfinanconcaportesrecurpps)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcaportesrecurpps"])){
       $sql  .= $virgula." si207_vltransfinanconcaportesrecurpps = $this->si207_vltransfinanconcaportesrecurpps ";
       $virgula = ",";
       if(trim($this->si207_vltransfinanconcaportesrecurpps) == null ){
         $this->erro_sql = " Campo si207_vltransfinanconcaportesrecurpps não informado.";
         $this->erro_campo = "si207_vltransfinanconcaportesrecurpps";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vlpagrspnaoprocessado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vlpagrspnaoprocessado"])){
       $sql  .= $virgula." si207_vlpagrspnaoprocessado = $this->si207_vlpagrspnaoprocessado ";
       $virgula = ",";
       if(trim($this->si207_vlpagrspnaoprocessado) == null ){
         $this->erro_sql = " Campo si207_vlpagrspnaoprocessado não informado.";
         $this->erro_campo = "si207_vlpagrspnaoprocessado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vlpagrspprocessado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vlpagrspprocessado"])){
       $sql  .= $virgula." si207_vlpagrspprocessado = $this->si207_vlpagrspprocessado ";
       $virgula = ",";
       if(trim($this->si207_vlpagrspprocessado) == null ){
         $this->erro_sql = " Campo si207_vlpagrspprocessado não informado.";
         $this->erro_campo = "si207_vlpagrspprocessado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vldeposrestvinculados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vldeposrestvinculados"])){
       $sql  .= $virgula." si207_vldeposrestvinculados = $this->si207_vldeposrestvinculados ";
       $virgula = ",";
       if(trim($this->si207_vldeposrestvinculados) == null ){
         $this->erro_sql = " Campo si207_vldeposrestvinculados não informado.";
         $this->erro_campo = "si207_vldeposrestvinculados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vloutrospagextraorcamentarios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vloutrospagextraorcamentarios"])){
       $sql  .= $virgula." si207_vloutrospagextraorcamentarios = $this->si207_vloutrospagextraorcamentarios ";
       $virgula = ",";
       if(trim($this->si207_vloutrospagextraorcamentarios) == null ){
         $this->erro_sql = " Campo si207_vloutrospagextraorcamentarios não informado.";
         $this->erro_campo = "si207_vloutrospagextraorcamentarios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vlsaldoexeratualcaixaequicaixa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vlsaldoexeratualcaixaequicaixa"])){
       $sql  .= $virgula." si207_vlsaldoexeratualcaixaequicaixa = $this->si207_vlsaldoexeratualcaixaequicaixa ";
       $virgula = ",";
       if(trim($this->si207_vlsaldoexeratualcaixaequicaixa) == null ){
         $this->erro_sql = " Campo si207_vlsaldoexeratualcaixaequicaixa não informado.";
         $this->erro_campo = "si207_vlsaldoexeratualcaixaequicaixa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vlsaldoexeratualdeporestvinc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vlsaldoexeratualdeporestvinc"])){
       $sql  .= $virgula." si207_vlsaldoexeratualdeporestvinc = $this->si207_vlsaldoexeratualdeporestvinc ";
       $virgula = ",";
       if(trim($this->si207_vlsaldoexeratualdeporestvinc) == null ){
         $this->erro_sql = " Campo si207_vlsaldoexeratualdeporestvinc não informado.";
         $this->erro_campo = "si207_vlsaldoexeratualdeporestvinc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_vltotaldispendios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_vltotaldispendios"])){
       $sql  .= $virgula." si207_vltotaldispendios = $this->si207_vltotaldispendios ";
       $virgula = ",";
       if(trim($this->si207_vltotaldispendios) == null ){
         $this->erro_sql = " Campo si207_vltotaldispendios não informado.";
         $this->erro_campo = "si207_vltotaldispendios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }

     if(trim($this->si207_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_ano"])){
       $sql  .= $virgula." si207_ano = $this->si207_ano ";
       $virgula = ",";
       if(trim($this->si207_ano) == null ){
         $this->erro_sql = " Campo si207_ano não informado.";
         $this->erro_campo = "si207_ano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_periodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_periodo"])){
       $sql  .= $virgula." si207_periodo = $this->si207_periodo ";
       $virgula = ",";
       if(trim($this->si207_periodo) == null ){
         $this->erro_sql = " Campo si207_periodo não informado.";
         $this->erro_campo = "si207_periodo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_institu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_institu"])){
       $sql  .= $virgula." si207_institu = $this->si207_institu ";
       $virgula = ",";
       if(trim($this->si207_institu) == null ){
         $this->erro_sql = " Campo si207_institu não informado.";
         $this->erro_campo = "si207_institu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }

     $sql .= " where ";
     if($si207_sequencial!=null){
       $sql .= " si207_sequencial = $this->si207_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bfdcasp202120 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bfdcasp202120 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si207_sequencial=null,$dbwhere=null) {

     $sql = " delete from bfdcasp202120
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si207_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si207_sequencial = $si207_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bfdcasp202120 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si207_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bfdcasp202120 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si207_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si207_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bfdcasp202120";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bfdcasp202120 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si207_sequencial!=null ){
         $sql2 .= " where bfdcasp202120.si207_sequencial = $si207_sequencial ";
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
   function sql_query_file ( $si207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bfdcasp202120 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si207_sequencial!=null ){
         $sql2 .= " where bfdcasp202120.si207_sequencial = $si207_sequencial ";
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
