<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf102018
class cl_dclrf102018 {
   // cria variaveis de erro
   var $rotulo     = null;
   var $query_sql  = null;
   var $numrows    = 0;
   var $erro_status= null;
   var $erro_sql   = null;
   var $erro_banco = null;
   var $erro_msg   = null;
   var $erro_campo = null;
   var $pagina_retorno = null;
   // cria variaveis do arquivo
   var $si190_sequencial = 0;
   var $si190_codorgao = null;
   var $si190_passivosreconhecidos = 0;
   var $si190_vlsaldoatualconcgarantiainterna = 0;
   var $si190_vlsaldoatualconcgarantia = 0;
   var $si190_vlsaldoatualcontragarantiainterna = 0;
   var $si190_vlsaldoatualcontragarantiaexterna = 0;
   var $si190_medidascorretivas = null;
   var $si190_recalieninvpermanente = 0;
   var $si190_vldotatualizadaincentcontrib = 0;
   var $si190_vlempenhadoicentcontrib = 0;
   var $si190_vldotatualizadaincentinstfinanc = 0;
   var $si190_vlempenhadoincentinstfinanc = 0;
   var $si190_vlliqincentcontrib = 0;
   var $si190_vlliqincentinstfinanc = 0;
   var $si190_vlirpnpincentcontrib = 0;
   var $si190_vlirpnpincentinstfinanc = 0;
   var $si190_vlrecursosnaoaplicados = 0;
   var $si190_vlapropiacaodepositosjudiciais = 0;
   var $si190_vloutrosajustes = 0;
   var $si190_metarrecada = 0;
   var $si190_dscmedidasadotadas = null;
   var $si190_tiporegistro = 0;
   var $si190_mes = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si190_sequencial = int4 = Sequencial DCLRF
                 si190_codorgao = char(2) = Código do órgão
                 si190_passivosreconhecidos = double = Valores dos passivos  reconhecidos
                 si190_vlsaldoatualconcgarantiainterna = double = Saldo atual das concessões de garantia
                 si190_vlsaldoatualconcgarantia = double = Saldo atual das concessões de garantia
                 si190_vlsaldoatualcontragarantiainterna = double = Saldo atual das contragarantias
                 si190_vlsaldoatualcontragarantiaexterna = double = Saldo atual das contragarantias externas
                 si190_medidascorretivas = text = Medidas corretivas adotadas
                 si190_recalieninvpermanente = Double = cálculo apurado da receita de alienação
                 si190_vldotatualizadaincentcontrib = double = Valor da dotação atualizada de Incentivo
                 si190_vlempenhadoicentcontrib = Double = Valor empenhado de Incentivo
                 si190_vldotatualizadaincentinstfinanc = double = Valor da dotação atualizada de Incentivo
                 si190_vlempenhadoincentinstfinanc = double = Valor empenhado de Incentivo concedido
                 si190_vlliqincentcontrib = double = Valor Liquidado de Incentivo
                 si190_vlliqincentinstfinanc = double = Valor Liquidado de Incentivo
                 si190_vlirpnpincentcontrib = double = Restos a Pagar Não Processados
                 si190_vlirpnpincentinstfinanc = double = Restos a Pagar Não Processados de Incen
                 si190_vlrecursosnaoaplicados = double = Recursos do FUNDEB não aplicados
                 si190_vlapropiacaodepositosjudiciais = double = Saldo apurado da apropriação
                 si190_vloutrosajustes = double = Valores não considerados
                 si190_metarrecada = int4 = Atingimento da meta bimestral de arrec
                 si190_dscmedidasadotadas = text = Medidas adotadas e a adotar
                 si190_tiporegistro = int4 = Tipo registro
                 si190_mes = int2 = Mes de Referencia
                 ";
   //funcao construtor da classe
   function cl_dclrf102018() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf102018");
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
       $this->si190_sequencial = ($this->si190_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_sequencial"]:$this->si190_sequencial);
       $this->si190_codorgao = ($this->si190_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_codorgao"]:$this->si190_codorgao);
       $this->si190_passivosreconhecidos = ($this->si190_passivosreconhecidos == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_passivosreconhecidos"]:$this->si190_passivosreconhecidos);
       $this->si190_vlsaldoatualconcgarantiainterna = ($this->si190_vlsaldoatualconcgarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualconcgarantiainterna"]:$this->si190_vlsaldoatualconcgarantiainterna);
       $this->si190_vlsaldoatualconcgarantia = ($this->si190_vlsaldoatualconcgarantia == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualconcgarantia"]:$this->si190_vlsaldoatualconcgarantia);
       $this->si190_vlsaldoatualcontragarantiainterna = ($this->si190_vlsaldoatualcontragarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualcontragarantiainterna"]:$this->si190_vlsaldoatualcontragarantiainterna);
       $this->si190_vlsaldoatualcontragarantiaexterna = ($this->si190_vlsaldoatualcontragarantiaexterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualcontragarantiaexterna"]:$this->si190_vlsaldoatualcontragarantiaexterna);
       $this->si190_medidascorretivas = ($this->si190_medidascorretivas == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_medidascorretivas"]:$this->si190_medidascorretivas);
       $this->si190_recalieninvpermanente = ($this->si190_recalieninvpermanente == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_recalieninvpermanente"]:$this->si190_recalieninvpermanente);
       $this->si190_vldotatualizadaincentcontrib = ($this->si190_vldotatualizadaincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vldotatualizadaincentcontrib"]:$this->si190_vldotatualizadaincentcontrib);
       $this->si190_vlempenhadoicentcontrib = ($this->si190_vlempenhadoicentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlempenhadoicentcontrib"]:$this->si190_vlempenhadoicentcontrib);
       $this->si190_vldotatualizadaincentinstfinanc = ($this->si190_vldotatualizadaincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vldotatualizadaincentinstfinanc"]:$this->si190_vldotatualizadaincentinstfinanc);
       $this->si190_vlempenhadoincentinstfinanc = ($this->si190_vlempenhadoincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlempenhadoincentinstfinanc"]:$this->si190_vlempenhadoincentinstfinanc);
       $this->si190_vlliqincentcontrib = ($this->si190_vlliqincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlliqincentcontrib"]:$this->si190_vlliqincentcontrib);
       $this->si190_vlliqincentinstfinanc = ($this->si190_vlliqincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlliqincentinstfinanc"]:$this->si190_vlliqincentinstfinanc);
       $this->si190_vlirpnpincentcontrib = ($this->si190_vlirpnpincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlirpnpincentcontrib"]:$this->si190_vlirpnpincentcontrib);
       $this->si190_vlirpnpincentinstfinanc = ($this->si190_vlirpnpincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlirpnpincentinstfinanc"]:$this->si190_vlirpnpincentinstfinanc);
       $this->si190_vlrecursosnaoaplicados = ($this->si190_vlrecursosnaoaplicados == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlrecursosnaoaplicados"]:$this->si190_vlrecursosnaoaplicados);
       $this->si190_vlapropiacaodepositosjudiciais = ($this->si190_vlapropiacaodepositosjudiciais == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlapropiacaodepositosjudiciais"]:$this->si190_vlapropiacaodepositosjudiciais);
       $this->si190_vloutrosajustes = ($this->si190_vloutrosajustes == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vloutrosajustes"]:$this->si190_vloutrosajustes);
       $this->si190_metarrecada = ($this->si190_metarrecada == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_metarrecada"]:$this->si190_metarrecada);
       $this->si190_dscmedidasadotadas = ($this->si190_dscmedidasadotadas == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_dscmedidasadotadas"]:$this->si190_dscmedidasadotadas);
       $this->si190_tiporegistro = ($this->si190_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"]:$this->si190_tiporegistro);
       $this->si190_mes = ($this->si190_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_mes"]:$this->si190_mes);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();

     if($this->si190_codorgao == null ){
       $this->erro_sql = " Campo Código do órgão nao Informado.";
       $this->erro_campo = "si190_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_passivosreconhecidos == null ){
       $this->erro_sql = " Campo Valores dos passivos  reconhecidos nao Informado.";
       $this->erro_campo = "si190_passivosreconhecidos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlsaldoatualconcgarantiainterna == null ){
       $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
       $this->erro_campo = "si190_vlsaldoatualconcgarantiainterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlsaldoatualconcgarantia == null ){
       $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
       $this->erro_campo = "si190_vlsaldoatualconcgarantia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlsaldoatualcontragarantiainterna == null ){
       $this->erro_sql = " Campo Saldo atual das contragarantias nao Informado.";
       $this->erro_campo = "si190_vlsaldoatualcontragarantiainterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlsaldoatualcontragarantiaexterna == null ){
       $this->erro_sql = " Campo Saldo atual das contragarantias externas nao Informado.";
       $this->erro_campo = "si190_vlsaldoatualcontragarantiaexterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si190_recalieninvpermanente == null ){
       $this->erro_sql = " Campo cálculo apurado da receita de alienação nao Informado.";
       $this->erro_campo = "si190_recalieninvpermanente";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vldotatualizadaincentcontrib == null ){
       $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
       $this->erro_campo = "si190_vldotatualizadaincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlempenhadoicentcontrib == null ){
       $this->erro_sql = " Campo Valor empenhado de Incentivo nao Informado.";
       $this->erro_campo = "si190_vlempenhadoicentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vldotatualizadaincentinstfinanc == null ){
       $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
       $this->erro_campo = "si190_vldotatualizadaincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlempenhadoincentinstfinanc == null ){
       $this->erro_sql = " Campo Valor empenhado de Incentivo concedido nao Informado.";
       $this->erro_campo = "si190_vlempenhadoincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlliqincentcontrib == null ){
       $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
       $this->erro_campo = "si190_vlliqincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlliqincentinstfinanc == null ){
       $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
       $this->erro_campo = "si190_vlliqincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlirpnpincentcontrib == null ){
       $this->erro_sql = " Campo Restos a Pagar Não Processados nao Informado.";
       $this->erro_campo = "si190_vlirpnpincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlirpnpincentinstfinanc == null ){
       $this->erro_sql = " Campo Restos a Pagar Não Processados de Incen nao Informado.";
       $this->erro_campo = "si190_vlirpnpincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlrecursosnaoaplicados == null ){
       $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
       $this->erro_campo = "si190_vlrecursosnaoaplicados";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vlapropiacaodepositosjudiciais == null ){
       $this->erro_sql = " Campo Saldo apurado da apropriação nao Informado.";
       $this->erro_campo = "si190_vlapropiacaodepositosjudiciais";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_vloutrosajustes == null ){
       $this->erro_sql = " Campo Valores não considerados nao Informado.";
       $this->erro_campo = "si190_vloutrosajustes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_metarrecada == null ){
       $this->erro_sql = " Campo Atingimento da meta bimestral de arrec nao Informado.";
       $this->erro_campo = "si190_metarrecada";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si190_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo registro nao Informado.";
       $this->erro_campo = "si190_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si190_mes == null ){
       $this->erro_sql = " Campo Mes de Referencia nao Informado.";
       $this->erro_campo = "si190_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si190_sequencial == "" || $si190_sequencial == null ){
       $result = @pg_query("select nextval('dclrf102018_si190_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dclrf102018_si190_sequencial_seq do campo: si190_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si190_sequencial = pg_result($result,0,0);
     }else{
       $result = @pg_query("select last_value from dclrf102018_si190_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si190_sequencial)){
         $this->erro_sql = " Campo si190_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si190_sequencial = $si190_sequencial;
       }
     }
     $result = @pg_query("insert into dclrf102018(
                                       si190_sequencial
                                      ,si190_codorgao
                                      ,si190_passivosreconhecidos
                                      ,si190_vlsaldoatualconcgarantiainterna
                                      ,si190_vlsaldoatualconcgarantia
                                      ,si190_vlsaldoatualcontragarantiainterna
                                      ,si190_vlsaldoatualcontragarantiaexterna
                                      ,si190_medidascorretivas
                                      ,si190_recalieninvpermanente
                                      ,si190_vldotatualizadaincentcontrib
                                      ,si190_vlempenhadoicentcontrib
                                      ,si190_vldotatualizadaincentinstfinanc
                                      ,si190_vlempenhadoincentinstfinanc
                                      ,si190_vlliqincentcontrib
                                      ,si190_vlliqincentinstfinanc
                                      ,si190_vlirpnpincentcontrib
                                      ,si190_vlirpnpincentinstfinanc
                                      ,si190_vlrecursosnaoaplicados
                                      ,si190_vlapropiacaodepositosjudiciais
                                      ,si190_vloutrosajustes
                                      ,si190_metarrecada
                                      ,si190_dscmedidasadotadas
                                      ,si190_tiporegistro
                                      ,si190_mes
                       )
                values (
                                $this->si190_sequencial
                               ,'$this->si190_codorgao'
                               ,$this->si190_passivosreconhecidos
                               ,$this->si190_vlsaldoatualconcgarantiainterna
                               ,$this->si190_vlsaldoatualconcgarantia
                               ,$this->si190_vlsaldoatualcontragarantiainterna
                               ,$this->si190_vlsaldoatualcontragarantiaexterna
                               ,'$this->si190_medidascorretivas'
                               ,$this->si190_recalieninvpermanente
                               ,$this->si190_vldotatualizadaincentcontrib
                               ,$this->si190_vlempenhadoicentcontrib
                               ,$this->si190_vldotatualizadaincentinstfinanc
                               ,$this->si190_vlempenhadoincentinstfinanc
                               ,$this->si190_vlliqincentcontrib
                               ,$this->si190_vlliqincentinstfinanc
                               ,$this->si190_vlirpnpincentcontrib
                               ,$this->si190_vlirpnpincentinstfinanc
                               ,$this->si190_vlrecursosnaoaplicados
                               ,$this->si190_vlapropiacaodepositosjudiciais
                               ,$this->si190_vloutrosajustes
                               ,$this->si190_metarrecada
                               ,'$this->si190_dscmedidasadotadas'
                               ,$this->si190_tiporegistro
                               ,$this->si190_mes
                      )");
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Dados Complementares à LRF () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Dados Complementares à LRF já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Dados Complementares à LRF () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   }
   // funcao para alteracao
   function alterar ( $si190_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update dclrf102018 set ";
     $virgula = "";
     if(trim($this->si190_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_sequencial"])){
        if(trim($this->si190_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si190_sequencial"])){
           $this->si190_sequencial = "0" ;
        }
       $sql  .= $virgula." si190_sequencial = $this->si190_sequencial ";
       $virgula = ",";
       if(trim($this->si190_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
         $this->erro_campo = "si190_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_codorgao"])){
       $sql  .= $virgula." si190_codorgao = '$this->si190_codorgao' ";
       $virgula = ",";
       if(trim($this->si190_codorgao) == null ){
         $this->erro_sql = " Campo Código do órgão nao Informado.";
         $this->erro_campo = "si190_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_passivosreconhecidos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_passivosreconhecidos"])){
       $sql  .= $virgula." si190_passivosreconhecidos = $this->si190_passivosreconhecidos ";
       $virgula = ",";
       if(trim($this->si190_passivosreconhecidos) == null ){
         $this->erro_sql = " Campo Valores dos passivos  reconhecidos nao Informado.";
         $this->erro_campo = "si190_passivosreconhecidos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlsaldoatualconcgarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualconcgarantiainterna"])){
       $sql  .= $virgula." si190_vlsaldoatualconcgarantiainterna = $this->si190_vlsaldoatualconcgarantiainterna ";
       $virgula = ",";
       if(trim($this->si190_vlsaldoatualconcgarantiainterna) == null ){
         $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
         $this->erro_campo = "si190_vlsaldoatualconcgarantiainterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlsaldoatualconcgarantia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualconcgarantia"])){
       $sql  .= $virgula." si190_vlsaldoatualconcgarantia = $this->si190_vlsaldoatualconcgarantia ";
       $virgula = ",";
       if(trim($this->si190_vlsaldoatualconcgarantia) == null ){
         $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
         $this->erro_campo = "si190_vlsaldoatualconcgarantia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlsaldoatualcontragarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualcontragarantiainterna"])){
       $sql  .= $virgula." si190_vlsaldoatualcontragarantiainterna = $this->si190_vlsaldoatualcontragarantiainterna ";
       $virgula = ",";
       if(trim($this->si190_vlsaldoatualcontragarantiainterna) == null ){
         $this->erro_sql = " Campo Saldo atual das contragarantias nao Informado.";
         $this->erro_campo = "si190_vlsaldoatualcontragarantiainterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlsaldoatualcontragarantiaexterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlsaldoatualcontragarantiaexterna"])){
       $sql  .= $virgula." si190_vlsaldoatualcontragarantiaexterna = $this->si190_vlsaldoatualcontragarantiaexterna ";
       $virgula = ",";
       if(trim($this->si190_vlsaldoatualcontragarantiaexterna) == null ){
         $this->erro_sql = " Campo Saldo atual das contragarantias externas nao Informado.";
         $this->erro_campo = "si190_vlsaldoatualcontragarantiaexterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_medidascorretivas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_medidascorretivas"])){
       $sql  .= $virgula." si190_medidascorretivas = '$this->si190_medidascorretivas' ";
       $virgula = ",";
       if(trim($this->si190_medidascorretivas) == null ){
         $this->erro_sql = " Campo Medidas corretivas adotadas nao Informado.";
         $this->erro_campo = "si190_medidascorretivas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_recalieninvpermanente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_recalieninvpermanente"])){
       $sql  .= $virgula." si190_recalieninvpermanente = $this->si190_recalieninvpermanente ";
       $virgula = ",";
       if(trim($this->si190_recalieninvpermanente) == null ){
         $this->erro_sql = " Campo cálculo apurado da receita de alienação nao Informado.";
         $this->erro_campo = "si190_recalieninvpermanente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vldotatualizadaincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vldotatualizadaincentcontrib"])){
       $sql  .= $virgula." si190_vldotatualizadaincentcontrib = $this->si190_vldotatualizadaincentcontrib ";
       $virgula = ",";
       if(trim($this->si190_vldotatualizadaincentcontrib) == null ){
         $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
         $this->erro_campo = "si190_vldotatualizadaincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlempenhadoicentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlempenhadoicentcontrib"])){
       $sql  .= $virgula." si190_vlempenhadoicentcontrib = $this->si190_vlempenhadoicentcontrib ";
       $virgula = ",";
       if(trim($this->si190_vlempenhadoicentcontrib) == null ){
         $this->erro_sql = " Campo Valor empenhado de Incentivo nao Informado.";
         $this->erro_campo = "si190_vlempenhadoicentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vldotatualizadaincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vldotatualizadaincentinstfinanc"])){
       $sql  .= $virgula." si190_vldotatualizadaincentinstfinanc = $this->si190_vldotatualizadaincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si190_vldotatualizadaincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
         $this->erro_campo = "si190_vldotatualizadaincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlempenhadoincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlempenhadoincentinstfinanc"])){
       $sql  .= $virgula." si190_vlempenhadoincentinstfinanc = $this->si190_vlempenhadoincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si190_vlempenhadoincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor empenhado de Incentivo concedido nao Informado.";
         $this->erro_campo = "si190_vlempenhadoincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlliqincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlliqincentcontrib"])){
       $sql  .= $virgula." si190_vlliqincentcontrib = $this->si190_vlliqincentcontrib ";
       $virgula = ",";
       if(trim($this->si190_vlliqincentcontrib) == null ){
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "si190_vlliqincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlliqincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlliqincentinstfinanc"])){
       $sql  .= $virgula." si190_vlliqincentinstfinanc = $this->si190_vlliqincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si190_vlliqincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "si190_vlliqincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlirpnpincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlirpnpincentcontrib"])){
       $sql  .= $virgula." si190_vlirpnpincentcontrib = $this->si190_vlirpnpincentcontrib ";
       $virgula = ",";
       if(trim($this->si190_vlirpnpincentcontrib) == null ){
         $this->erro_sql = " Campo Restos a Pagar Não Processados nao Informado.";
         $this->erro_campo = "si190_vlirpnpincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlirpnpincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlirpnpincentinstfinanc"])){
       $sql  .= $virgula." si190_vlirpnpincentinstfinanc = $this->si190_vlirpnpincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si190_vlirpnpincentinstfinanc) == null ){
         $this->erro_sql = " Campo Restos a Pagar Não Processados de Incen nao Informado.";
         $this->erro_campo = "si190_vlirpnpincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlrecursosnaoaplicados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlrecursosnaoaplicados"])){
       $sql  .= $virgula." si190_vlrecursosnaoaplicados = $this->si190_vlrecursosnaoaplicados ";
       $virgula = ",";
       if(trim($this->si190_vlrecursosnaoaplicados) == null ){
         $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
         $this->erro_campo = "si190_vlrecursosnaoaplicados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vlapropiacaodepositosjudiciais)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlapropiacaodepositosjudiciais"])){
       $sql  .= $virgula." si190_vlapropiacaodepositosjudiciais = $this->si190_vlapropiacaodepositosjudiciais ";
       $virgula = ",";
       if(trim($this->si190_vlapropiacaodepositosjudiciais) == null ){
         $this->erro_sql = " Campo Saldo apurado da apropriação nao Informado.";
         $this->erro_campo = "si190_vlapropiacaodepositosjudiciais";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_vloutrosajustes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vloutrosajustes"])){
       $sql  .= $virgula." si190_vloutrosajustes = $this->si190_vloutrosajustes ";
       $virgula = ",";
       if(trim($this->si190_vloutrosajustes) == null ){
         $this->erro_sql = " Campo Valores não considerados nao Informado.";
         $this->erro_campo = "si190_vloutrosajustes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_metarrecada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_metarrecada"])){
        if(trim($this->si190_metarrecada)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si190_metarrecada"])){
           $this->si190_metarrecada = "0" ;
        }
       $sql  .= $virgula." si190_metarrecada = $this->si190_metarrecada ";
       $virgula = ",";
       if(trim($this->si190_metarrecada) == null ){
         $this->erro_sql = " Campo Atingimento da meta bimestral de arrec nao Informado.";
         $this->erro_campo = "si190_metarrecada";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_dscmedidasadotadas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_dscmedidasadotadas"])){
       $sql  .= $virgula." si190_dscmedidasadotadas = '$this->si190_dscmedidasadotadas' ";
       $virgula = ",";
       if(trim($this->si190_dscmedidasadotadas) == null ){
         $this->erro_sql = " Campo Medidas adotadas e a adotar nao Informado.";
         $this->erro_campo = "si190_dscmedidasadotadas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"])){
        if(trim($this->si190_tiporegistro)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"])){
           $this->si190_tiporegistro = "0" ;
        }
       $sql  .= $virgula." si190_tiporegistro = $this->si190_tiporegistro ";
       $virgula = ",";
       if(trim($this->si190_tiporegistro) == null ){
         $this->erro_sql = " Campo Tipo registro nao Informado.";
         $this->erro_campo = "si190_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si190_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_mes"])){
        if(trim($this->si190_mes)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si190_mes"])){
           $this->si190_mes = "0" ;
        }
       $sql  .= $virgula." si190_mes = $this->si190_mes ";
       $virgula = ",";
       if(trim($this->si190_mes) == null ){
         $this->erro_sql = " Campo Mes de Referencia nao Informado.";
         $this->erro_campo = "si190_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where si190_sequencial = $si190_sequencial ";
     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados Complementares à LRF nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados Complementares à LRF nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ( $si190_mes=null, $si190_codorgao=null ) {
     $this->atualizacampos(true);
     $sql = " delete from dclrf102018
                    where ";
     $sql2 = "";
     $sql2 = "si190_mes = $si190_mes AND si190_codorgao = '$si190_codorgao' ";
     $result = @pg_exec($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados Complementares à LRF nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados Complementares à LRF nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }
     }
   }
   // funcao do recordset
   function sql_record($sql) {
     $result = @pg_query($sql);
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
        $this->erro_sql   = "Dados do Grupo nao Encontrado";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si190_sequencial = null,$campos="dclrf102018.si190_sequencial,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf102018 ";
     $sql2 = "";
     if($dbwhere==""){
       if( $si190_sequencial != "" && $si190_sequencial != null){
          $sql2 = " where dclrf102018.si190_sequencial = $si190_sequencial";
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
   function sql_query_file ( $si190_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf102018 ";
     $sql2 = "";
     if($dbwhere==""){
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
