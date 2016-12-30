<?
//MODULO: sicom
//CLASSE DA ENTIDADE bfdcasp202017
class cl_bfdcasp202017 { 
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
   var $si207_exercicio = 0; 
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
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si207_sequencial = int4 = si207_sequencial 
                 si207_tiporegistro = int4 = si207_tiporegistro 
                 si207_exercicio = int4 = si207_exercicio 
                 si207_vldesporcamenrecurordinarios = float4 = si207_vldesporcamenrecurordinarios 
                 si207_vldesporcamenrecurvincueducacao = float4 = si207_vldesporcamenrecurvincueducacao 
                 si207_vldesporcamenrecurvincusaude = float4 = si207_vldesporcamenrecurvincusaude 
                 si207_vldesporcamenrecurvincurpps = float4 = si207_vldesporcamenrecurvincurpps 
                 si207_vldesporcamenrecurvincuassistsoc = float4 = si207_vldesporcamenrecurvincuassistsoc 
                 si207_vloutrasdesporcamendestrecursos = float4 = si207_vloutrasdesporcamendestrecursos 
                 si207_vltransfinanconcexecorcamentaria = float4 = si207_vltransfinanconcexecorcamentaria 
                 si207_vltransfinanconcindepenexecorc = float4 = si207_vltransfinanconcindepenexecorc 
                 si207_vltransfinanconcaportesrecurpps = float4 = si207_vltransfinanconcaportesrecurpps 
                 si207_vlpagrspnaoprocessado = float4 = si207_vlpagrspnaoprocessado 
                 si207_vlpagrspprocessado = float4 = si207_vlpagrspprocessado 
                 si207_vldeposrestvinculados = float4 = si207_vldeposrestvinculados 
                 si207_vloutrospagextraorcamentarios = float4 = si207_vloutrospagextraorcamentarios 
                 si207_vlsaldoexeratualcaixaequicaixa = float4 = si207_vlsaldoexeratualcaixaequicaixa 
                 si207_vlsaldoexeratualdeporestvinc = float4 = si207_vlsaldoexeratualdeporestvinc 
                 si207_vltotaldispendios = float4 = si207_vltotaldispendios 
                 ";
   //funcao construtor da classe 
   function cl_bfdcasp202017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bfdcasp202017"); 
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
       $this->si207_sequencial = ($this->si207_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_sequencial"]:$this->si207_sequencial);
       $this->si207_tiporegistro = ($this->si207_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_tiporegistro"]:$this->si207_tiporegistro);
       $this->si207_exercicio = ($this->si207_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si207_exercicio"]:$this->si207_exercicio);
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
       $this->erro_sql = " Campo si207_tiporegistro não informado.";
       $this->erro_campo = "si207_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_exercicio == null ){ 
       $this->erro_sql = " Campo si207_exercicio não informado.";
       $this->erro_campo = "si207_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vldesporcamenrecurordinarios == null ){ 
       $this->erro_sql = " Campo si207_vldesporcamenrecurordinarios não informado.";
       $this->erro_campo = "si207_vldesporcamenrecurordinarios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vldesporcamenrecurvincueducacao == null ){ 
       $this->erro_sql = " Campo si207_vldesporcamenrecurvincueducacao não informado.";
       $this->erro_campo = "si207_vldesporcamenrecurvincueducacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vldesporcamenrecurvincusaude == null ){ 
       $this->erro_sql = " Campo si207_vldesporcamenrecurvincusaude não informado.";
       $this->erro_campo = "si207_vldesporcamenrecurvincusaude";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vldesporcamenrecurvincurpps == null ){ 
       $this->erro_sql = " Campo si207_vldesporcamenrecurvincurpps não informado.";
       $this->erro_campo = "si207_vldesporcamenrecurvincurpps";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vldesporcamenrecurvincuassistsoc == null ){ 
       $this->erro_sql = " Campo si207_vldesporcamenrecurvincuassistsoc não informado.";
       $this->erro_campo = "si207_vldesporcamenrecurvincuassistsoc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vloutrasdesporcamendestrecursos == null ){ 
       $this->erro_sql = " Campo si207_vloutrasdesporcamendestrecursos não informado.";
       $this->erro_campo = "si207_vloutrasdesporcamendestrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vltransfinanconcexecorcamentaria == null ){ 
       $this->erro_sql = " Campo si207_vltransfinanconcexecorcamentaria não informado.";
       $this->erro_campo = "si207_vltransfinanconcexecorcamentaria";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vltransfinanconcindepenexecorc == null ){ 
       $this->erro_sql = " Campo si207_vltransfinanconcindepenexecorc não informado.";
       $this->erro_campo = "si207_vltransfinanconcindepenexecorc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vltransfinanconcaportesrecurpps == null ){ 
       $this->erro_sql = " Campo si207_vltransfinanconcaportesrecurpps não informado.";
       $this->erro_campo = "si207_vltransfinanconcaportesrecurpps";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vlpagrspnaoprocessado == null ){ 
       $this->erro_sql = " Campo si207_vlpagrspnaoprocessado não informado.";
       $this->erro_campo = "si207_vlpagrspnaoprocessado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vlpagrspprocessado == null ){ 
       $this->erro_sql = " Campo si207_vlpagrspprocessado não informado.";
       $this->erro_campo = "si207_vlpagrspprocessado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vldeposrestvinculados == null ){ 
       $this->erro_sql = " Campo si207_vldeposrestvinculados não informado.";
       $this->erro_campo = "si207_vldeposrestvinculados";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vloutrospagextraorcamentarios == null ){ 
       $this->erro_sql = " Campo si207_vloutrospagextraorcamentarios não informado.";
       $this->erro_campo = "si207_vloutrospagextraorcamentarios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vlsaldoexeratualcaixaequicaixa == null ){ 
       $this->erro_sql = " Campo si207_vlsaldoexeratualcaixaequicaixa não informado.";
       $this->erro_campo = "si207_vlsaldoexeratualcaixaequicaixa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vlsaldoexeratualdeporestvinc == null ){ 
       $this->erro_sql = " Campo si207_vlsaldoexeratualdeporestvinc não informado.";
       $this->erro_campo = "si207_vlsaldoexeratualdeporestvinc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si207_vltotaldispendios == null ){ 
       $this->erro_sql = " Campo si207_vltotaldispendios não informado.";
       $this->erro_campo = "si207_vltotaldispendios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si207_sequencial = $si207_sequencial; 
     if(($this->si207_sequencial == null) || ($this->si207_sequencial == "") ){ 
       $this->erro_sql = " Campo si207_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into bfdcasp202017(
                                       si207_sequencial 
                                      ,si207_tiporegistro 
                                      ,si207_exercicio 
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
                       )
                values (
                                $this->si207_sequencial 
                               ,$this->si207_tiporegistro 
                               ,$this->si207_exercicio 
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
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bfdcasp202017 ($this->si207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "bfdcasp202017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "bfdcasp202017 ($this->si207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si207_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009349,'$this->si207_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010201,1009349,'','".AddSlashes(pg_result($resaco,0,'si207_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009350,'','".AddSlashes(pg_result($resaco,0,'si207_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009351,'','".AddSlashes(pg_result($resaco,0,'si207_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009352,'','".AddSlashes(pg_result($resaco,0,'si207_vldesporcamenrecurordinarios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009353,'','".AddSlashes(pg_result($resaco,0,'si207_vldesporcamenrecurvincueducacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009354,'','".AddSlashes(pg_result($resaco,0,'si207_vldesporcamenrecurvincusaude'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009355,'','".AddSlashes(pg_result($resaco,0,'si207_vldesporcamenrecurvincurpps'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009356,'','".AddSlashes(pg_result($resaco,0,'si207_vldesporcamenrecurvincuassistsoc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009357,'','".AddSlashes(pg_result($resaco,0,'si207_vloutrasdesporcamendestrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009358,'','".AddSlashes(pg_result($resaco,0,'si207_vltransfinanconcexecorcamentaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009359,'','".AddSlashes(pg_result($resaco,0,'si207_vltransfinanconcindepenexecorc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009360,'','".AddSlashes(pg_result($resaco,0,'si207_vltransfinanconcaportesrecurpps'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009361,'','".AddSlashes(pg_result($resaco,0,'si207_vlpagrspnaoprocessado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009362,'','".AddSlashes(pg_result($resaco,0,'si207_vlpagrspprocessado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009363,'','".AddSlashes(pg_result($resaco,0,'si207_vldeposrestvinculados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009364,'','".AddSlashes(pg_result($resaco,0,'si207_vloutrospagextraorcamentarios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009365,'','".AddSlashes(pg_result($resaco,0,'si207_vlsaldoexeratualcaixaequicaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009366,'','".AddSlashes(pg_result($resaco,0,'si207_vlsaldoexeratualdeporestvinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,1009367,'','".AddSlashes(pg_result($resaco,0,'si207_vltotaldispendios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si207_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bfdcasp202017 set ";
     $virgula = "";
     if(trim($this->si207_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_sequencial"])){ 
       $sql  .= $virgula." si207_sequencial = $this->si207_sequencial ";
       $virgula = ",";
       if(trim($this->si207_sequencial) == null ){ 
         $this->erro_sql = " Campo si207_sequencial não informado.";
         $this->erro_campo = "si207_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si207_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si207_exercicio"])){ 
       $sql  .= $virgula." si207_exercicio = $this->si207_exercicio ";
       $virgula = ",";
       if(trim($this->si207_exercicio) == null ){ 
         $this->erro_sql = " Campo si207_exercicio não informado.";
         $this->erro_campo = "si207_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si207_sequencial!=null){
       $sql .= " si207_sequencial = $this->si207_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si207_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009349,'$this->si207_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_sequencial"]) || $this->si207_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009349,'".AddSlashes(pg_result($resaco,$conresaco,'si207_sequencial'))."','$this->si207_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_tiporegistro"]) || $this->si207_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009350,'".AddSlashes(pg_result($resaco,$conresaco,'si207_tiporegistro'))."','$this->si207_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_exercicio"]) || $this->si207_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009351,'".AddSlashes(pg_result($resaco,$conresaco,'si207_exercicio'))."','$this->si207_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurordinarios"]) || $this->si207_vldesporcamenrecurordinarios != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009352,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vldesporcamenrecurordinarios'))."','$this->si207_vldesporcamenrecurordinarios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincueducacao"]) || $this->si207_vldesporcamenrecurvincueducacao != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009353,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vldesporcamenrecurvincueducacao'))."','$this->si207_vldesporcamenrecurvincueducacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincusaude"]) || $this->si207_vldesporcamenrecurvincusaude != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009354,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vldesporcamenrecurvincusaude'))."','$this->si207_vldesporcamenrecurvincusaude',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincurpps"]) || $this->si207_vldesporcamenrecurvincurpps != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009355,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vldesporcamenrecurvincurpps'))."','$this->si207_vldesporcamenrecurvincurpps',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vldesporcamenrecurvincuassistsoc"]) || $this->si207_vldesporcamenrecurvincuassistsoc != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009356,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vldesporcamenrecurvincuassistsoc'))."','$this->si207_vldesporcamenrecurvincuassistsoc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vloutrasdesporcamendestrecursos"]) || $this->si207_vloutrasdesporcamendestrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009357,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vloutrasdesporcamendestrecursos'))."','$this->si207_vloutrasdesporcamendestrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcexecorcamentaria"]) || $this->si207_vltransfinanconcexecorcamentaria != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009358,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vltransfinanconcexecorcamentaria'))."','$this->si207_vltransfinanconcexecorcamentaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcindepenexecorc"]) || $this->si207_vltransfinanconcindepenexecorc != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009359,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vltransfinanconcindepenexecorc'))."','$this->si207_vltransfinanconcindepenexecorc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vltransfinanconcaportesrecurpps"]) || $this->si207_vltransfinanconcaportesrecurpps != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009360,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vltransfinanconcaportesrecurpps'))."','$this->si207_vltransfinanconcaportesrecurpps',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vlpagrspnaoprocessado"]) || $this->si207_vlpagrspnaoprocessado != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009361,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vlpagrspnaoprocessado'))."','$this->si207_vlpagrspnaoprocessado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vlpagrspprocessado"]) || $this->si207_vlpagrspprocessado != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009362,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vlpagrspprocessado'))."','$this->si207_vlpagrspprocessado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vldeposrestvinculados"]) || $this->si207_vldeposrestvinculados != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009363,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vldeposrestvinculados'))."','$this->si207_vldeposrestvinculados',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vloutrospagextraorcamentarios"]) || $this->si207_vloutrospagextraorcamentarios != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009364,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vloutrospagextraorcamentarios'))."','$this->si207_vloutrospagextraorcamentarios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vlsaldoexeratualcaixaequicaixa"]) || $this->si207_vlsaldoexeratualcaixaequicaixa != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009365,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vlsaldoexeratualcaixaequicaixa'))."','$this->si207_vlsaldoexeratualcaixaequicaixa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vlsaldoexeratualdeporestvinc"]) || $this->si207_vlsaldoexeratualdeporestvinc != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009366,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vlsaldoexeratualdeporestvinc'))."','$this->si207_vlsaldoexeratualdeporestvinc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si207_vltotaldispendios"]) || $this->si207_vltotaldispendios != "")
             $resac = db_query("insert into db_acount values($acount,1010201,1009367,'".AddSlashes(pg_result($resaco,$conresaco,'si207_vltotaldispendios'))."','$this->si207_vltotaldispendios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bfdcasp202017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bfdcasp202017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si207_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si207_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009349,'$si207_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009349,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009350,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009351,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009352,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vldesporcamenrecurordinarios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009353,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vldesporcamenrecurvincueducacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009354,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vldesporcamenrecurvincusaude'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009355,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vldesporcamenrecurvincurpps'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009356,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vldesporcamenrecurvincuassistsoc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009357,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vloutrasdesporcamendestrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009358,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vltransfinanconcexecorcamentaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009359,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vltransfinanconcindepenexecorc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009360,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vltransfinanconcaportesrecurpps'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009361,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vlpagrspnaoprocessado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009362,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vlpagrspprocessado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009363,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vldeposrestvinculados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009364,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vloutrospagextraorcamentarios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009365,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vlsaldoexeratualcaixaequicaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009366,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vlsaldoexeratualdeporestvinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,1009367,'','".AddSlashes(pg_result($resaco,$iresaco,'si207_vltotaldispendios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from bfdcasp202017
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
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bfdcasp202017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si207_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bfdcasp202017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:bfdcasp202017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bfdcasp202017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si207_sequencial!=null ){
         $sql2 .= " where bfdcasp202017.si207_sequencial = $si207_sequencial "; 
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
   function sql_query_file ( $si207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bfdcasp202017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si207_sequencial!=null ){
         $sql2 .= " where bfdcasp202017.si207_sequencial = $si207_sequencial "; 
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
