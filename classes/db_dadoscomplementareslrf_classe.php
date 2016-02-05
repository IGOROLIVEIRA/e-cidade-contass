<?
//MODULO: sicom
//CLASSE DA ENTIDADE dadoscomplementareslrf
class cl_dadoscomplementareslrf { 
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
   var $si170_sequencial = 0; 
   var $si170_vlsaldoatualconcgarantia = 0; 
   var $si170_recprivatizacao = 0; 
   var $si170_vlliqincentcontrib = 0; 
   var $si170_vlliqincentinstfinanc = 0; 
   var $si170_vlirpnpincentcontrib = 0; 
   var $si170_vllrpnpincentinstfinanc = 0; 
   var $si170_vlcompromissado = 0; 
   var $si170_vlrecursosnaoaplicados = 0; 
   var $si170_mesreferencia = 0; 
   var $si170_instit = 0;
   var $si170_vlsaldoatualconcgarantiainterna = 0;
   var $si170_vlsaldoatualcontragarantiainterna = 0;
   var $si170_vlsaldoatualcontragarantiaexterna = 0;
   var $si170_medidascorretivas = null;
   var $si170_publiclrf = NULL;
   var $si170_dtpublicacaorelatoriolrf = null;
   var $si170_tpbimestre = null;
   var $si170_metarrecada = null;
   var $si170_dscmedidasadotadas = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si170_sequencial = int8 = sequencial 
                 si170_vlsaldoatualconcgarantia = float8 = Saldo atual das concessões 
                 si170_recprivatizacao = float8 = Receita de  Privatização 
                 si170_vlliqincentcontrib = float8 = Valor Liquidado de Incentivo 
                 si170_vlliqincentinstfinanc = float8 = Valor concedido por Instituição 
                 si170_vlirpnpincentcontrib = float8 = Valor Inscrito em RP Não Processados 
                 si170_vllrpnpincentinstfinanc = float8 = Valor Inscrito em RP Não Processados IF 
                 si170_vlcompromissado = float8 = Total dos valores compromissados 
                 si170_vlrecursosnaoaplicados = float8 = Recursos do FUNDEB não aplicados 
                 si170_mesreferencia = int8 = Mês de referência 
                 si170_instit = int8 = Instituição 
                 si170_vlsaldoatualconcgarantiainterna = float8 = Valor
                 si170_vlsaldoatualcontragarantiainterna = float8 = Valor
                 si170_vlsaldoatualcontragarantiaexterna = float8 = Valor
                 si170_medidascorretivas = text = Descrição
                 si170_publiclrf = int8 = Publicação
                 si170_dtpublicacaorelatoriolrf = date = data 
                 si170_tpbimestre = int8 = Bimestre
                 si170_metarrecada = int8 = Meta
                 si170_dscmedidasadotadas = text = Descrição
                 ";
   //funcao construtor da classe 
   function cl_dadoscomplementareslrf() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dadoscomplementareslrf"); 
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
       $this->si170_sequencial = ($this->si170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]:$this->si170_sequencial);
       $this->si170_vlsaldoatualconcgarantia = ($this->si170_vlsaldoatualconcgarantia == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantia"]:$this->si170_vlsaldoatualconcgarantia);
       $this->si170_recprivatizacao = ($this->si170_recprivatizacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_recprivatizacao"]:$this->si170_recprivatizacao);
       $this->si170_vlliqincentcontrib = ($this->si170_vlliqincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentcontrib"]:$this->si170_vlliqincentcontrib);
       $this->si170_vlliqincentinstfinanc = ($this->si170_vlliqincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentinstfinanc"]:$this->si170_vlliqincentinstfinanc);
       $this->si170_vlirpnpincentcontrib = ($this->si170_vlirpnpincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlirpnpincentcontrib"]:$this->si170_vlirpnpincentcontrib);
       $this->si170_vllrpnpincentinstfinanc = ($this->si170_vllrpnpincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vllrpnpincentinstfinanc"]:$this->si170_vllrpnpincentinstfinanc);
       $this->si170_vlcompromissado = ($this->si170_vlcompromissado == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlcompromissado"]:$this->si170_vlcompromissado);
       $this->si170_vlrecursosnaoaplicados = ($this->si170_vlrecursosnaoaplicados == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlrecursosnaoaplicados"]:$this->si170_vlrecursosnaoaplicados);
       $this->si170_mesreferencia = ($this->si170_mesreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_mesreferencia"]:$this->si170_mesreferencia);
       $this->si170_instit = ($this->si170_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_instit"]:$this->si170_instit);
       $this->si170_vlsaldoatualconcgarantiainterna = ($this->si170_vlsaldoatualconcgarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantiainterna"]:$this->si170_vlsaldoatualconcgarantiainterna);
       $this->si170_vlsaldoatualcontragarantiainterna = ($this->si170_vlsaldoatualcontragarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualcontragarantiainterna"]:$this->si170_vlsaldoatualcontragarantiainterna);
       $this->si170_vlsaldoatualcontragarantiaexterna = ($this->si170_vlsaldoatualcontragarantiaexterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualcontragarantiaexterna"]:$this->si170_vlsaldoatualcontragarantiaexterna);
       $this->si170_medidascorretivas = ($this->si170_medidascorretivas == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_medidascorretivas"]:$this->si170_medidascorretivas);
       $this->si170_publiclrf = ($this->si170_publiclrf == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_publiclrf"]:$this->si170_publiclrf);
       $this->si170_dtpublicacaorelatoriolrf = ($this->si170_dtpublicacaorelatoriolrf == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_dtpublicacaorelatoriolrf"]:$this->si170_dtpublicacaorelatoriolrf);
       if($this->si170_dtpublicacaorelatoriolrf == ""){
         $this->si170_dtpublicacaorelatoriolrf_dia = ($this->si170_dtpublicacaorelatoriolrf_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_dtpublicacaorelatoriolrf_dia"]:$this->si170_dtpublicacaorelatoriolrf_dia);
         $this->si170_dtpublicacaorelatoriolrf_mes = ($this->si170_dtpublicacaorelatoriolrf_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_dtpublicacaorelatoriolrf_mes"]:$this->si170_dtpublicacaorelatoriolrf_mes);
         $this->si170_dtpublicacaorelatoriolrf_ano = ($this->si170_dtpublicacaorelatoriolrf_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_dtpublicacaorelatoriolrf_ano"]:$this->si170_dtpublicacaorelatoriolrf_ano);
         if($this->si170_dtpublicacaorelatoriolrf_dia != ""){
            $this->si170_dtpublicacaorelatoriolrf = $this->si170_dtpublicacaorelatoriolrf_ano."-".$this->si170_dtpublicacaorelatoriolrf_mes."-".$this->si170_dtpublicacaorelatoriolrf_dia;
         }
       }
       $this->si170_tpbimestre = ($this->si170_tpbimestre == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_tpbimestre"]:$this->si170_tpbimestre);
       $this->si170_metarrecada = ($this->si170_metarrecada == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_metarrecada"]:$this->si170_metarrecada);
       $this->si170_dscmedidasadotadas = ($this->si170_dscmedidasadotadas == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_dscmedidasadotadas"]:$this->si170_dscmedidasadotadas);
     }else{
       $this->si170_sequencial = ($this->si170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]:$this->si170_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si170_sequencial){ 
      $this->atualizacampos();
     if($this->si170_vlsaldoatualconcgarantia == null ){ 
       $this->erro_sql = " Campo Saldo atual das concessões nao Informado.";
       $this->erro_campo = "si170_vlsaldoatualconcgarantia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_recprivatizacao == null ){ 
       $this->erro_sql = " Campo Receita de  Privatização nao Informado.";
       $this->erro_campo = "si170_recprivatizacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlliqincentcontrib == null ){ 
       $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
       $this->erro_campo = "si170_vlliqincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlliqincentinstfinanc == null ){ 
       $this->erro_sql = " Campo Valor concedido por Instituição nao Informado.";
       $this->erro_campo = "si170_vlliqincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlirpnpincentcontrib == null ){ 
       $this->erro_sql = " Campo Valor Inscrito em RP Não Processados nao Informado.";
       $this->erro_campo = "si170_vlirpnpincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vllrpnpincentinstfinanc == null ){ 
       $this->erro_sql = " Campo Valor Inscrito em RP Não Processados IF nao Informado.";
       $this->erro_campo = "si170_vllrpnpincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlcompromissado == null ){ 
       $this->erro_sql = " Campo Total dos valores compromissados nao Informado.";
       $this->erro_campo = "si170_vlcompromissado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlrecursosnaoaplicados == null ){ 
       $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
       $this->erro_campo = "si170_vlrecursosnaoaplicados";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_mesreferencia == null ){ 
       $this->erro_sql = " Campo Mês de referência nao Informado.";
       $this->erro_campo = "si170_mesreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si170_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si170_sequencial == "" || $si170_sequencial == null ){
       $result = db_query("select nextval('dadoscomplementareslrf_si170_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dadoscomplementareslrf_si170_sequencial_seq do campo: si170_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si170_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dadoscomplementareslrf_si170_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si170_sequencial)){
         $this->erro_sql = " Campo si170_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si170_sequencial = $si170_sequencial; 
       }
     }
     if(($this->si170_sequencial == null) || ($this->si170_sequencial == "") ){ 
       $this->erro_sql = " Campo si170_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     $result = db_query("select si09_tipoinstit from infocomplementaresinstit where si09_instit = ".db_getsession("DB_instit"));
     $tipoinstit = pg_result($result,0,0);
     if($this->si170_vlsaldoatualconcgarantiainterna == null ){ 
       $this->erro_sql = " Campo Saldo atual das concessões de garantia interna nao Informado.";
       $this->erro_campo = "si170_vlsaldoatualconcgarantiainterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlsaldoatualcontragarantiainterna == null ){ 
       $this->erro_sql = " Campo Saldo atual das contragarantias interna recebidas nao Informado.";
       $this->erro_campo = "si170_vlsaldoatualcontragarantiainterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlsaldoatualcontragarantiaexterna == null ){ 
       $this->erro_sql = " Campo Saldo atual das contragarantias externa recebidas nao Informado.";
       $this->erro_campo = "si170_vlsaldoatualcontragarantiaexterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->si170_publiclrf == 0 || $this->si170_publiclrf == null) && ($tipoinstit == 1 || $tipoinstit == 2)){ 
       $this->erro_sql = " Campo Publicação dos relatórios da LRF nao Informado.";
       $this->erro_campo = "si170_publiclrf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_dtpublicacaorelatoriolrf == null && $this->si170_publiclrf == 1){ 
       $this->erro_sql = " Campo Data de publicação dos relatórios da LRF nao Informado.";
       $this->erro_campo = "si170_dtpublicacaorelatoriolrf_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_tpbimestre == 0 && $this->si170_dtpublicacaorelatoriolrf != null){ 
       $this->erro_sql = " Campo Periodo a que se refere a data de publicação da LRF nao Informado.";
       $this->erro_campo = "si170_tpbimestre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_metarrecada != 0 && $tipoinstit != 2){ 
       $this->erro_sql = " Campo Atingimento da meta bimestral de arrecadação só deve ser informado pela instituição Prefeitura.";
       $this->erro_campo = "si170_metarrecada";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_dscmedidasadotadas == null && $this->si170_metarrecada == 2){ 
       $this->erro_sql = " Campo Medidas adotadas e a adotar nao Informado.";
       $this->erro_campo = "si170_dscmedidasadotadas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     $sql = "insert into dadoscomplementareslrf(
                                       si170_sequencial 
                                      ,si170_vlsaldoatualconcgarantia 
                                      ,si170_recprivatizacao 
                                      ,si170_vlliqincentcontrib 
                                      ,si170_vlliqincentinstfinanc 
                                      ,si170_vlirpnpincentcontrib 
                                      ,si170_vllrpnpincentinstfinanc 
                                      ,si170_vlcompromissado 
                                      ,si170_vlrecursosnaoaplicados 
                                      ,si170_mesreferencia 
                                      ,si170_instit 
                                      ,si170_vlsaldoatualconcgarantiainterna
                                      ,si170_vlsaldoatualcontragarantiainterna
                                      ,si170_vlsaldoatualcontragarantiaexterna
                                      ,si170_medidascorretivas
                                      ,si170_publiclrf
                                      ,si170_dtpublicacaorelatoriolrf
                                      ,si170_tpbimestre
                                      ,si170_metarrecada
                                      ,si170_dscmedidasadotadas
                       )
                values (
                                $this->si170_sequencial 
                               ,$this->si170_vlsaldoatualconcgarantia 
                               ,$this->si170_recprivatizacao 
                               ,$this->si170_vlliqincentcontrib 
                               ,$this->si170_vlliqincentinstfinanc 
                               ,$this->si170_vlirpnpincentcontrib 
                               ,$this->si170_vllrpnpincentinstfinanc 
                               ,$this->si170_vlcompromissado 
                               ,$this->si170_vlrecursosnaoaplicados 
                               ,$this->si170_mesreferencia 
                               ,$this->si170_instit 
                               ,$this->si170_vlsaldoatualconcgarantiainterna
                               ,$this->si170_vlsaldoatualcontragarantiainterna
                               ,$this->si170_vlsaldoatualcontragarantiaexterna
                               ,'$this->si170_medidascorretivas'
                               ,$this->si170_publiclrf
                               ,".($this->si170_dtpublicacaorelatoriolrf == "null" || $this->si170_dtpublicacaorelatoriolrf == ""?"null":"'".$this->si170_dtpublicacaorelatoriolrf."'")."
                               ,$this->si170_tpbimestre
                               ,$this->si170_metarrecada
                               ,'$this->si170_dscmedidasadotadas'
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dadoscomplementareslrf ($this->si170_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dadoscomplementareslrf já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dadoscomplementareslrf ($this->si170_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si170_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011446,'$this->si170_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010404,2011446,'','".AddSlashes(pg_result($resaco,0,'si170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011447,'','".AddSlashes(pg_result($resaco,0,'si170_vlsaldoatualconcgarantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011448,'','".AddSlashes(pg_result($resaco,0,'si170_recprivatizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011450,'','".AddSlashes(pg_result($resaco,0,'si170_vlliqincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011451,'','".AddSlashes(pg_result($resaco,0,'si170_vlliqincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011452,'','".AddSlashes(pg_result($resaco,0,'si170_vlirpnpincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011453,'','".AddSlashes(pg_result($resaco,0,'si170_vllrpnpincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011454,'','".AddSlashes(pg_result($resaco,0,'si170_vlcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011455,'','".AddSlashes(pg_result($resaco,0,'si170_vlrecursosnaoaplicados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011456,'','".AddSlashes(pg_result($resaco,0,'si170_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011687,'','".AddSlashes(pg_result($resaco,0,'si170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si170_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dadoscomplementareslrf set ";
     $virgula = "";
     if(trim($this->si170_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_sequencial"])){ 
       $sql  .= $virgula." si170_sequencial = $this->si170_sequencial ";
       $virgula = ",";
       if(trim($this->si170_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si170_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlsaldoatualconcgarantia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantia"])){ 
       $sql  .= $virgula." si170_vlsaldoatualconcgarantia = $this->si170_vlsaldoatualconcgarantia ";
       $virgula = ",";
       if(trim($this->si170_vlsaldoatualconcgarantia) == null ){ 
         $this->erro_sql = " Campo Saldo atual das concessões nao Informado.";
         $this->erro_campo = "si170_vlsaldoatualconcgarantia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_recprivatizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_recprivatizacao"])){ 
       $sql  .= $virgula." si170_recprivatizacao = $this->si170_recprivatizacao ";
       $virgula = ",";
       if(trim($this->si170_recprivatizacao) == null ){ 
         $this->erro_sql = " Campo Receita de  Privatização nao Informado.";
         $this->erro_campo = "si170_recprivatizacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlliqincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentcontrib"])){ 
       $sql  .= $virgula." si170_vlliqincentcontrib = $this->si170_vlliqincentcontrib ";
       $virgula = ",";
       if(trim($this->si170_vlliqincentcontrib) == null ){ 
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "si170_vlliqincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlliqincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentinstfinanc"])){ 
       $sql  .= $virgula." si170_vlliqincentinstfinanc = $this->si170_vlliqincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si170_vlliqincentinstfinanc) == null ){ 
         $this->erro_sql = " Campo Valor concedido por Instituição nao Informado.";
         $this->erro_campo = "si170_vlliqincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlirpnpincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlirpnpincentcontrib"])){ 
       $sql  .= $virgula." si170_vlirpnpincentcontrib = $this->si170_vlirpnpincentcontrib ";
       $virgula = ",";
       if(trim($this->si170_vlirpnpincentcontrib) == null ){ 
         $this->erro_sql = " Campo Valor Inscrito em RP Não Processados nao Informado.";
         $this->erro_campo = "si170_vlirpnpincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vllrpnpincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vllrpnpincentinstfinanc"])){ 
       $sql  .= $virgula." si170_vllrpnpincentinstfinanc = $this->si170_vllrpnpincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si170_vllrpnpincentinstfinanc) == null ){ 
         $this->erro_sql = " Campo Valor Inscrito em RP Não Processados IF nao Informado.";
         $this->erro_campo = "si170_vllrpnpincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlcompromissado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlcompromissado"])){ 
       $sql  .= $virgula." si170_vlcompromissado = $this->si170_vlcompromissado ";
       $virgula = ",";
       if(trim($this->si170_vlcompromissado) == null ){ 
         $this->erro_sql = " Campo Total dos valores compromissados nao Informado.";
         $this->erro_campo = "si170_vlcompromissado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlrecursosnaoaplicados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlrecursosnaoaplicados"])){ 
       $sql  .= $virgula." si170_vlrecursosnaoaplicados = $this->si170_vlrecursosnaoaplicados ";
       $virgula = ",";
       if(trim($this->si170_vlrecursosnaoaplicados) == null ){ 
         $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
         $this->erro_campo = "si170_vlrecursosnaoaplicados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_mesreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_mesreferencia"])){ 
       $sql  .= $virgula." si170_mesreferencia = $this->si170_mesreferencia ";
       $virgula = ",";
       if(trim($this->si170_mesreferencia) == null ){ 
         $this->erro_sql = " Campo Mês de referência nao Informado.";
         $this->erro_campo = "si170_mesreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_instit"])){ 
       $sql  .= $virgula." si170_instit = $this->si170_instit ";
       $virgula = ",";
       if(trim($this->si170_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si170_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
     $result = db_query("select si09_tipoinstit from infocomplementaresinstit where si09_instit = ".db_getsession("DB_instit"));
     $tipoinstit = pg_result($result,0,0);
     if(trim($this->si170_vlsaldoatualconcgarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantiainterna"])){ 
       $sql  .= $virgula." si170_vlsaldoatualconcgarantiainterna = $this->si170_vlsaldoatualconcgarantiainterna ";
       $virgula = ",";
	     if($this->si170_vlsaldoatualconcgarantiainterna == null ){ 
	       $this->erro_sql = " Campo Saldo atual das concessões de garantia interna nao Informado.";
	       $this->erro_campo = "si170_vlsaldoatualconcgarantiainterna";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_vlsaldoatualcontragarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualcontragarantiainterna"])){ 
       $sql  .= $virgula." si170_vlsaldoatualcontragarantiainterna = $this->si170_vlsaldoatualcontragarantiainterna ";
       $virgula = ",";
	     if($this->si170_vlsaldoatualcontragarantiainterna == null ){ 
	       $this->erro_sql = " Campo Saldo atual das contragarantias interna recebidas nao Informado.";
	       $this->erro_campo = "si170_vlsaldoatualcontragarantiainterna";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_vlsaldoatualcontragarantiaexterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualcontragarantiaexterna"])){ 
       $sql  .= $virgula." si170_vlsaldoatualcontragarantiaexterna = $this->si170_vlsaldoatualcontragarantiaexterna ";
       $virgula = ",";
	     if($this->si170_vlsaldoatualcontragarantiaexterna == null ){ 
	       $this->erro_sql = " Campo Saldo atual das contragarantias externa recebidas nao Informado.";
	       $this->erro_campo = "si170_vlsaldoatualcontragarantiaexterna";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_publiclrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_publiclrf"])){ 
       $sql  .= $virgula." si170_publiclrf = $this->si170_publiclrf ";
       $virgula = ",";
	     if(($this->si170_publiclrf == 0 || $this->si170_publiclrf == null) && ($tipoinstit == 1 || $tipoinstit == 2)){ 
	       $this->erro_sql = " Campo Publicação dos relatórios da LRF nao Informado.";
	       $this->erro_campo = "si170_publiclrf";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_dtpublicacaorelatoriolrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_dtpublicacaorelatoriolrf"])){ 
       $sql  .= $virgula." si170_dtpublicacaorelatoriolrf = ".($this->si170_dtpublicacaorelatoriolrf == "null" || $this->si170_dtpublicacaorelatoriolrf == ""?"null":"'".$this->si170_dtpublicacaorelatoriolrf."'");
       $virgula = ",";
	     if($this->si170_dtpublicacaorelatoriolrf == null && $this->si170_publiclrf == 1){ 
	       $this->erro_sql = " Campo Data de publicação dos relatórios da LRF nao Informado.";
	       $this->erro_campo = "si170_dtpublicacaorelatoriolrf_dia";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_tpbimestre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_tpbimestre"])){ 
       $sql  .= $virgula." si170_tpbimestre = $this->si170_tpbimestre ";
       $virgula = ",";
	     if($this->si170_tpbimestre == 0 && $this->si170_dtpublicacaorelatoriolrf != null){ 
	       $this->erro_sql = " Campo Periodo a que se refere a data de publicação da LRF nao Informado.";
	       $this->erro_campo = "si170_tpbimestre";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_metarrecada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_metarrecada"])){ 
       $sql  .= $virgula." si170_metarrecada = $this->si170_metarrecada ";
       $virgula = ",";
	     if($this->si170_metarrecada != 0 && $tipoinstit != 2){ 
	       $this->erro_sql = " Campo Atingimento da meta bimestral de arrecadação só deve ser informado pela instituição Prefeitura.";
	       $this->erro_campo = "si170_metarrecada";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_dscmedidasadotadas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_dscmedidasadotadas"])){ 
       $sql  .= $virgula." si170_dscmedidasadotadas = '$this->si170_dscmedidasadotadas' ";
       $virgula = ",";
	     if($this->si170_dscmedidasadotadas == null && $this->si170_metarrecada == 2){ 
	       $this->erro_sql = " Campo Medidas adotadas e a adotar nao Informado.";
	       $this->erro_campo = "si170_dscmedidasadotadas";
	       $this->erro_banco = "";
	       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	       $this->erro_status = "0";
	       return false;
	     }
     }
     if(trim($this->si170_medidascorretivas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_medidascorretivas"])){ 
       $sql  .= $virgula." si170_medidascorretivas = '$this->si170_medidascorretivas' ";
       $virgula = ",";
     }
     
     $sql .= " where ";
     if($si170_sequencial!=null){
       $sql .= " si170_sequencial = $this->si170_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si170_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011446,'$this->si170_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]) || $this->si170_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011446,'".AddSlashes(pg_result($resaco,$conresaco,'si170_sequencial'))."','$this->si170_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantia"]) || $this->si170_vlsaldoatualconcgarantia != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011447,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlsaldoatualconcgarantia'))."','$this->si170_vlsaldoatualconcgarantia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_recprivatizacao"]) || $this->si170_recprivatizacao != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011448,'".AddSlashes(pg_result($resaco,$conresaco,'si170_recprivatizacao'))."','$this->si170_recprivatizacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentcontrib"]) || $this->si170_vlliqincentcontrib != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011450,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlliqincentcontrib'))."','$this->si170_vlliqincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentinstfinanc"]) || $this->si170_vlliqincentinstfinanc != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011451,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlliqincentinstfinanc'))."','$this->si170_vlliqincentinstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlirpnpincentcontrib"]) || $this->si170_vlirpnpincentcontrib != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011452,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlirpnpincentcontrib'))."','$this->si170_vlirpnpincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vllrpnpincentinstfinanc"]) || $this->si170_vllrpnpincentinstfinanc != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011453,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vllrpnpincentinstfinanc'))."','$this->si170_vllrpnpincentinstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlcompromissado"]) || $this->si170_vlcompromissado != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011454,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlcompromissado'))."','$this->si170_vlcompromissado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlrecursosnaoaplicados"]) || $this->si170_vlrecursosnaoaplicados != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011455,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlrecursosnaoaplicados'))."','$this->si170_vlrecursosnaoaplicados',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_mesreferencia"]) || $this->si170_mesreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011456,'".AddSlashes(pg_result($resaco,$conresaco,'si170_mesreferencia'))."','$this->si170_mesreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_instit"]) || $this->si170_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011687,'".AddSlashes(pg_result($resaco,$conresaco,'si170_instit'))."','$this->si170_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dadoscomplementareslrf nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dadoscomplementareslrf nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si170_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si170_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011446,'$si170_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010404,2011446,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011447,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlsaldoatualconcgarantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011448,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_recprivatizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011450,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlliqincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011451,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlliqincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011452,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlirpnpincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011453,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vllrpnpincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011454,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011455,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlrecursosnaoaplicados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011456,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011687,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dadoscomplementareslrf
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si170_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si170_sequencial = $si170_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dadoscomplementareslrf nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si170_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dadoscomplementareslrf nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si170_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dadoscomplementareslrf";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si170_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dadoscomplementareslrf ";
     $sql2 = "";
     if($dbwhere==""){
       if($si170_sequencial!=null ){
         $sql2 .= " where dadoscomplementareslrf.si170_sequencial = $si170_sequencial "; 
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
   function sql_query_file ( $si170_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dadoscomplementareslrf ";
     $sql2 = "";
     if($dbwhere==""){
       if($si170_sequencial!=null ){
         $sql2 .= " where dadoscomplementareslrf.si170_sequencial = $si170_sequencial "; 
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
