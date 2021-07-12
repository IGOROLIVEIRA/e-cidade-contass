<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf102019
class cl_dclrf102019 {
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
 	var $si157_sequencial = 0;
	var $si157_tiporegistro = 0;
	var $si157_codorgao = null;
	var $si157_passivosreconhecidos = 0;
	var $si157_vlsaldoatualconcgarantiainterna = 0;
	var $si157_vlsaldoatualconcgarantia = 0;
	var $si157_vlsaldoatualcontragarantiainterna = 0;
	var $si157_vlsaldoatualcontragarantiaexterna = 0;
	var $si157_medidascorretivas = null;
	var $si157_recalieninvpermanente = 0;
	var $si157_vldotatualizadaincentcontrib = 0;
	var $si157_vlempenhadoicentcontrib = 0;
	var $si157_vldotatualizadaincentinstfinanc = 0;
	var $si157_vlempenhadoincentinstfinanc = 0;
	var $si157_vlliqincentcontrib = 0;
	var $si157_vlliqincentinstfinanc = 0;
	var $si157_vlirpnpincentcontrib = 0;
	var $si157_vlirpnpincentinstfinanc = 0;
	var $si157_vlrecursosnaoaplicados = 0;
	var $si157_vlapropiacaodepositosjudiciais = 0;
	var $si157_vloutrosajustes = 0;
	var $si157_metarrecada = 0;
	var $si157_dscmedidasadotadas = null;
	var $si157_mes = 0;
	var $si157_instit = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si157_sequencial = int4 = Sequencial DCLRF
                 si157_codorgao = char(2) = Código do órgão
                 si157_passivosreconhecidos = double = Valores dos passivos  reconhecidos
                 si157_vlsaldoatualconcgarantiainterna = double = Saldo atual das concessões de garantia
                 si157_vlsaldoatualconcgarantia = double = Saldo atual das concessões de garantia
                 si157_vlsaldoatualcontragarantiainterna = double = Saldo atual das contragarantias
                 si157_vlsaldoatualcontragarantiaexterna = double = Saldo atual das contragarantias externas
                 si157_medidascorretivas = text = Medidas corretivas adotadas
                 si157_recalieninvpermanente = Double = cálculo apurado da receita de alienação
                 si157_vldotatualizadaincentcontrib = double = Valor da dotação atualizada de Incentivo
                 si157_vlempenhadoicentcontrib = Double = Valor empenhado de Incentivo
                 si157_vldotatualizadaincentinstfinanc = double = Valor da dotação atualizada de Incentivo
                 si157_vlempenhadoincentinstfinanc = double = Valor empenhado de Incentivo concedido
                 si157_vlliqincentcontrib = double = Valor Liquidado de Incentivo
                 si157_vlliqincentinstfinanc = double = Valor Liquidado de Incentivo
                 si157_vlirpnpincentcontrib = double = Restos a Pagar Não Processados
                 si157_vlirpnpincentinstfinanc = double = Restos a Pagar Não Processados de Incen
                 si157_vlrecursosnaoaplicados = double = Recursos do FUNDEB não aplicados
                 si157_vlapropiacaodepositosjudiciais = double = Saldo apurado da apropriação
                 si157_vloutrosajustes = double = Valores não considerados
                 si157_metarrecada = int4 = Atingimento da meta bimestral de arrec
                 si157_dscmedidasadotadas = text = Medidas adotadas e a adotar
                 si157_tiporegistro = int4 = Tipo registro
                 si157_mes = int2 = Mes de Referencia
                 si157_instit = int8 = Instituição
                 ";
   //funcao construtor da classe
   function cl_dclrf102019() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf102019");
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
     // print_r($this);
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
       $this->si157_sequencial = ($this->si157_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_sequencial"]:$this->si157_sequencial);
       $this->si157_codorgao = ($this->si157_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_codorgao"]:$this->si157_codorgao);
       $this->si157_passivosreconhecidos = ($this->si157_passivosreconhecidos == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_passivosreconhecidos"]:$this->si157_passivosreconhecidos);
       $this->si157_vlsaldoatualconcgarantiainterna = ($this->si157_vlsaldoatualconcgarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualconcgarantiainterna"]:$this->si157_vlsaldoatualconcgarantiainterna);
       $this->si157_vlsaldoatualconcgarantia = ($this->si157_vlsaldoatualconcgarantia == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualconcgarantia"]:$this->si157_vlsaldoatualconcgarantia);
       $this->si157_vlsaldoatualcontragarantiainterna = ($this->si157_vlsaldoatualcontragarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualcontragarantiainterna"]:$this->si157_vlsaldoatualcontragarantiainterna);
       $this->si157_vlsaldoatualcontragarantiaexterna = ($this->si157_vlsaldoatualcontragarantiaexterna == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualcontragarantiaexterna"]:$this->si157_vlsaldoatualcontragarantiaexterna);
       $this->si157_medidascorretivas = ($this->si157_medidascorretivas == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_medidascorretivas"]:$this->si157_medidascorretivas);
       $this->si157_recalieninvpermanente = ($this->si157_recalieninvpermanente == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_recalieninvpermanente"]:$this->si157_recalieninvpermanente);
       $this->si157_vldotatualizadaincentcontrib = ($this->si157_vldotatualizadaincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vldotatualizadaincentcontrib"]:$this->si157_vldotatualizadaincentcontrib);
       $this->si157_vlempenhadoicentcontrib = ($this->si157_vlempenhadoicentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlempenhadoicentcontrib"]:$this->si157_vlempenhadoicentcontrib);
       $this->si157_vldotatualizadaincentinstfinanc = ($this->si157_vldotatualizadaincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vldotatualizadaincentinstfinanc"]:$this->si157_vldotatualizadaincentinstfinanc);
       $this->si157_vlempenhadoincentinstfinanc = ($this->si157_vlempenhadoincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlempenhadoincentinstfinanc"]:$this->si157_vlempenhadoincentinstfinanc);
       $this->si157_vlliqincentcontrib = ($this->si157_vlliqincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlliqincentcontrib"]:$this->si157_vlliqincentcontrib);
       $this->si157_vlliqincentinstfinanc = ($this->si157_vlliqincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlliqincentinstfinanc"]:$this->si157_vlliqincentinstfinanc);
       $this->si157_vlirpnpincentcontrib = ($this->si157_vlirpnpincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlirpnpincentcontrib"]:$this->si157_vlirpnpincentcontrib);
       $this->si157_vlirpnpincentinstfinanc = ($this->si157_vlirpnpincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlirpnpincentinstfinanc"]:$this->si157_vlirpnpincentinstfinanc);
       $this->si157_vlrecursosnaoaplicados = ($this->si157_vlrecursosnaoaplicados == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlrecursosnaoaplicados"]:$this->si157_vlrecursosnaoaplicados);
       $this->si157_vlapropiacaodepositosjudiciais = ($this->si157_vlapropiacaodepositosjudiciais == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vlapropiacaodepositosjudiciais"]:$this->si157_vlapropiacaodepositosjudiciais);
       $this->si157_vloutrosajustes = ($this->si157_vloutrosajustes == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_vloutrosajustes"]:$this->si157_vloutrosajustes);
       $this->si157_metarrecada = ($this->si157_metarrecada == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_metarrecada"]:$this->si157_metarrecada);
       $this->si157_dscmedidasadotadas = ($this->si157_dscmedidasadotadas == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_dscmedidasadotadas"]:$this->si157_dscmedidasadotadas);
       $this->si157_tiporegistro = ($this->si157_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_tiporegistro"]:$this->si157_tiporegistro);
       $this->si157_mes = ($this->si157_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_mes"]:$this->si157_mes);
	   $this->si157_instit = ($this->si157_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si157_instit"]:$this->si157_instit);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();

     if($this->si157_codorgao == null ){
       $this->erro_sql = " Campo Código do órgão nao Informado.";
       $this->erro_campo = "si157_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_passivosreconhecidos == null ){
       $this->erro_sql = " Campo Valores dos passivos  reconhecidos nao Informado.";
       $this->erro_campo = "si157_passivosreconhecidos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlsaldoatualconcgarantiainterna == null ){
       $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
       $this->erro_campo = "si157_vlsaldoatualconcgarantiainterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlsaldoatualconcgarantia == null ){
       $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
       $this->erro_campo = "si157_vlsaldoatualconcgarantia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlsaldoatualcontragarantiainterna == null ){
       $this->erro_sql = " Campo Saldo atual das contragarantias nao Informado.";
       $this->erro_campo = "si157_vlsaldoatualcontragarantiainterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlsaldoatualcontragarantiaexterna == null ){
       $this->erro_sql = " Campo Saldo atual das contragarantias externas nao Informado.";
       $this->erro_campo = "si157_vlsaldoatualcontragarantiaexterna";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si157_recalieninvpermanente == null ){
       $this->erro_sql = " Campo cálculo apurado da receita de alienação nao Informado.";
       $this->erro_campo = "si157_recalieninvpermanente";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vldotatualizadaincentcontrib == null ){
       $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
       $this->erro_campo = "si157_vldotatualizadaincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlempenhadoicentcontrib == null ){
       $this->erro_sql = " Campo Valor empenhado de Incentivo nao Informado.";
       $this->erro_campo = "si157_vlempenhadoicentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vldotatualizadaincentinstfinanc == null ){
       $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
       $this->erro_campo = "si157_vldotatualizadaincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlempenhadoincentinstfinanc == null ){
       $this->erro_sql = " Campo Valor empenhado de Incentivo concedido nao Informado.";
       $this->erro_campo = "si157_vlempenhadoincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlliqincentcontrib == null ){
       $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
       $this->erro_campo = "si157_vlliqincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlliqincentinstfinanc == null ){
       $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
       $this->erro_campo = "si157_vlliqincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlirpnpincentcontrib == null ){
       $this->erro_sql = " Campo Restos a Pagar Não Processados nao Informado.";
       $this->erro_campo = "si157_vlirpnpincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlirpnpincentinstfinanc == null ){
       $this->erro_sql = " Campo Restos a Pagar Não Processados de Incen nao Informado.";
       $this->erro_campo = "si157_vlirpnpincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlrecursosnaoaplicados == null ){
       $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
       $this->erro_campo = "si157_vlrecursosnaoaplicados";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vlapropiacaodepositosjudiciais == null ){
       $this->erro_sql = " Campo Saldo apurado da apropriação nao Informado.";
       $this->erro_campo = "si157_vlapropiacaodepositosjudiciais";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_vloutrosajustes == null ){
       $this->erro_sql = " Campo Valores não considerados nao Informado.";
       $this->erro_campo = "si157_vloutrosajustes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_metarrecada == null ){
       $this->erro_sql = " Campo Atingimento da meta bimestral de arrec nao Informado.";
       $this->erro_campo = "si157_metarrecada";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si157_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo registro nao Informado.";
       $this->erro_campo = "si157_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_mes == null ){
       $this->erro_sql = " Campo Mes de Referencia nao Informado.";
       $this->erro_campo = "si157_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si157_mes == null ){
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si157_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si157_sequencial == "" || $si157_sequencial == null ){
       $result = @pg_query("select nextval('dclrf102019_si157_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dclrf102019_si157_sequencial_seq do campo: si157_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si157_sequencial = pg_result($result,0,0);
     }else{
       $result = @pg_query("select last_value from dclrf102019_si157_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si157_sequencial)){
         $this->erro_sql = " Campo si157_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si157_sequencial = $si157_sequencial;
       }
     }
       $sql = "insert into dclrf102019(
                                       si157_sequencial
                                      ,si157_codorgao
                                      ,si157_passivosreconhecidos
                                      ,si157_vlsaldoatualconcgarantiainterna
                                      ,si157_vlsaldoatualconcgarantia
                                      ,si157_vlsaldoatualcontragarantiainterna
                                      ,si157_vlsaldoatualcontragarantiaexterna
                                      ,si157_medidascorretivas
                                      ,si157_recalieninvpermanente
                                      ,si157_vldotatualizadaincentcontrib
                                      ,si157_vlempenhadoicentcontrib
                                      ,si157_vldotatualizadaincentinstfinanc
                                      ,si157_vlempenhadoincentinstfinanc
                                      ,si157_vlliqincentcontrib
                                      ,si157_vlliqincentinstfinanc
                                      ,si157_vlirpnpincentcontrib
                                      ,si157_vlirpnpincentinstfinanc
                                      ,si157_vlrecursosnaoaplicados
                                      ,si157_vlapropiacaodepositosjudiciais
                                      ,si157_vloutrosajustes
                                      ,si157_metarrecada
                                      ,si157_tiporegistro
                                      ,si157_mes
                                      ,si157_instit
                       )
                values (
                                $this->si157_sequencial
                               ,'$this->si157_codorgao'
                               ,$this->si157_passivosreconhecidos
                               ,$this->si157_vlsaldoatualconcgarantiainterna
                               ,$this->si157_vlsaldoatualconcgarantia
                               ,$this->si157_vlsaldoatualcontragarantiainterna
                               ,$this->si157_vlsaldoatualcontragarantiaexterna
                               ,'$this->si157_medidascorretivas'
                               ,$this->si157_recalieninvpermanente
                               ,$this->si157_vldotatualizadaincentcontrib
                               ,$this->si157_vlempenhadoicentcontrib
                               ,$this->si157_vldotatualizadaincentinstfinanc
                               ,$this->si157_vlempenhadoincentinstfinanc
                               ,$this->si157_vlliqincentcontrib
                               ,$this->si157_vlliqincentinstfinanc
                               ,$this->si157_vlirpnpincentcontrib
                               ,$this->si157_vlirpnpincentinstfinanc
                               ,$this->si157_vlrecursosnaoaplicados
                               ,$this->si157_vlapropiacaodepositosjudiciais
                               ,$this->si157_vloutrosajustes
                               ,$this->si157_metarrecada
                               ,$this->si157_tiporegistro
                               ,$this->si157_mes
                               ,$this->si157_instit
                      )";
//     die($sql);
       $result = db_query($sql);
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
   function alterar ( $si157_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update dclrf102019 set ";
     $virgula = "";
     if(trim($this->si157_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_sequencial"])){
        if(trim($this->si157_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si157_sequencial"])){
           $this->si157_sequencial = "0" ;
        }
       $sql  .= $virgula." si157_sequencial = $this->si157_sequencial ";
       $virgula = ",";
       if(trim($this->si157_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
         $this->erro_campo = "si157_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_codorgao"])){
       $sql  .= $virgula." si157_codorgao = '$this->si157_codorgao' ";
       $virgula = ",";
       if(trim($this->si157_codorgao) == null ){
         $this->erro_sql = " Campo Código do órgão nao Informado.";
         $this->erro_campo = "si157_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_passivosreconhecidos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_passivosreconhecidos"])){
       $sql  .= $virgula." si157_passivosreconhecidos = $this->si157_passivosreconhecidos ";
       $virgula = ",";
       if(trim($this->si157_passivosreconhecidos) == null ){
         $this->erro_sql = " Campo Valores dos passivos  reconhecidos nao Informado.";
         $this->erro_campo = "si157_passivosreconhecidos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlsaldoatualconcgarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualconcgarantiainterna"])){
       $sql  .= $virgula." si157_vlsaldoatualconcgarantiainterna = $this->si157_vlsaldoatualconcgarantiainterna ";
       $virgula = ",";
       if(trim($this->si157_vlsaldoatualconcgarantiainterna) == null ){
         $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
         $this->erro_campo = "si157_vlsaldoatualconcgarantiainterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlsaldoatualconcgarantia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualconcgarantia"])){
       $sql  .= $virgula." si157_vlsaldoatualconcgarantia = $this->si157_vlsaldoatualconcgarantia ";
       $virgula = ",";
       if(trim($this->si157_vlsaldoatualconcgarantia) == null ){
         $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
         $this->erro_campo = "si157_vlsaldoatualconcgarantia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlsaldoatualcontragarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualcontragarantiainterna"])){
       $sql  .= $virgula." si157_vlsaldoatualcontragarantiainterna = $this->si157_vlsaldoatualcontragarantiainterna ";
       $virgula = ",";
       if(trim($this->si157_vlsaldoatualcontragarantiainterna) == null ){
         $this->erro_sql = " Campo Saldo atual das contragarantias nao Informado.";
         $this->erro_campo = "si157_vlsaldoatualcontragarantiainterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlsaldoatualcontragarantiaexterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlsaldoatualcontragarantiaexterna"])){
       $sql  .= $virgula." si157_vlsaldoatualcontragarantiaexterna = $this->si157_vlsaldoatualcontragarantiaexterna ";
       $virgula = ",";
       if(trim($this->si157_vlsaldoatualcontragarantiaexterna) == null ){
         $this->erro_sql = " Campo Saldo atual das contragarantias externas nao Informado.";
         $this->erro_campo = "si157_vlsaldoatualcontragarantiaexterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_medidascorretivas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_medidascorretivas"])){
       $sql  .= $virgula." si157_medidascorretivas = '$this->si157_medidascorretivas' ";
       $virgula = ",";
       if(trim($this->si157_medidascorretivas) == null ){
         $this->erro_sql = " Campo Medidas corretivas adotadas nao Informado.";
         $this->erro_campo = "si157_medidascorretivas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_recalieninvpermanente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_recalieninvpermanente"])){
       $sql  .= $virgula." si157_recalieninvpermanente = $this->si157_recalieninvpermanente ";
       $virgula = ",";
       if(trim($this->si157_recalieninvpermanente) == null ){
         $this->erro_sql = " Campo cálculo apurado da receita de alienação nao Informado.";
         $this->erro_campo = "si157_recalieninvpermanente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vldotatualizadaincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vldotatualizadaincentcontrib"])){
       $sql  .= $virgula." si157_vldotatualizadaincentcontrib = $this->si157_vldotatualizadaincentcontrib ";
       $virgula = ",";
       if(trim($this->si157_vldotatualizadaincentcontrib) == null ){
         $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
         $this->erro_campo = "si157_vldotatualizadaincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlempenhadoicentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlempenhadoicentcontrib"])){
       $sql  .= $virgula." si157_vlempenhadoicentcontrib = $this->si157_vlempenhadoicentcontrib ";
       $virgula = ",";
       if(trim($this->si157_vlempenhadoicentcontrib) == null ){
         $this->erro_sql = " Campo Valor empenhado de Incentivo nao Informado.";
         $this->erro_campo = "si157_vlempenhadoicentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vldotatualizadaincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vldotatualizadaincentinstfinanc"])){
       $sql  .= $virgula." si157_vldotatualizadaincentinstfinanc = $this->si157_vldotatualizadaincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si157_vldotatualizadaincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
         $this->erro_campo = "si157_vldotatualizadaincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlempenhadoincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlempenhadoincentinstfinanc"])){
       $sql  .= $virgula." si157_vlempenhadoincentinstfinanc = $this->si157_vlempenhadoincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si157_vlempenhadoincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor empenhado de Incentivo concedido nao Informado.";
         $this->erro_campo = "si157_vlempenhadoincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlliqincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlliqincentcontrib"])){
       $sql  .= $virgula." si157_vlliqincentcontrib = $this->si157_vlliqincentcontrib ";
       $virgula = ",";
       if(trim($this->si157_vlliqincentcontrib) == null ){
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "si157_vlliqincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlliqincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlliqincentinstfinanc"])){
       $sql  .= $virgula." si157_vlliqincentinstfinanc = $this->si157_vlliqincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si157_vlliqincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "si157_vlliqincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlirpnpincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlirpnpincentcontrib"])){
       $sql  .= $virgula." si157_vlirpnpincentcontrib = $this->si157_vlirpnpincentcontrib ";
       $virgula = ",";
       if(trim($this->si157_vlirpnpincentcontrib) == null ){
         $this->erro_sql = " Campo Restos a Pagar Não Processados nao Informado.";
         $this->erro_campo = "si157_vlirpnpincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlirpnpincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlirpnpincentinstfinanc"])){
       $sql  .= $virgula." si157_vlirpnpincentinstfinanc = $this->si157_vlirpnpincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si157_vlirpnpincentinstfinanc) == null ){
         $this->erro_sql = " Campo Restos a Pagar Não Processados de Incen nao Informado.";
         $this->erro_campo = "si157_vlirpnpincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlrecursosnaoaplicados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlrecursosnaoaplicados"])){
       $sql  .= $virgula." si157_vlrecursosnaoaplicados = $this->si157_vlrecursosnaoaplicados ";
       $virgula = ",";
       if(trim($this->si157_vlrecursosnaoaplicados) == null ){
         $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
         $this->erro_campo = "si157_vlrecursosnaoaplicados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vlapropiacaodepositosjudiciais)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vlapropiacaodepositosjudiciais"])){
       $sql  .= $virgula." si157_vlapropiacaodepositosjudiciais = $this->si157_vlapropiacaodepositosjudiciais ";
       $virgula = ",";
       if(trim($this->si157_vlapropiacaodepositosjudiciais) == null ){
         $this->erro_sql = " Campo Saldo apurado da apropriação nao Informado.";
         $this->erro_campo = "si157_vlapropiacaodepositosjudiciais";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_vloutrosajustes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_vloutrosajustes"])){
       $sql  .= $virgula." si157_vloutrosajustes = $this->si157_vloutrosajustes ";
       $virgula = ",";
       if(trim($this->si157_vloutrosajustes) == null ){
         $this->erro_sql = " Campo Valores não considerados nao Informado.";
         $this->erro_campo = "si157_vloutrosajustes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_metarrecada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_metarrecada"])){
        if(trim($this->si157_metarrecada)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si157_metarrecada"])){
           $this->si157_metarrecada = "0" ;
        }
       $sql  .= $virgula." si157_metarrecada = $this->si157_metarrecada ";
       $virgula = ",";
       if(trim($this->si157_metarrecada) == null ){
         $this->erro_sql = " Campo Atingimento da meta bimestral de arrec nao Informado.";
         $this->erro_campo = "si157_metarrecada";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_tiporegistro"])){
        if(trim($this->si157_tiporegistro)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si157_tiporegistro"])){
           $this->si157_tiporegistro = "0" ;
        }
       $sql  .= $virgula." si157_tiporegistro = $this->si157_tiporegistro ";
       $virgula = ",";
       if(trim($this->si157_tiporegistro) == null ){
         $this->erro_sql = " Campo Tipo registro nao Informado.";
         $this->erro_campo = "si157_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_mes"])){
        if(trim($this->si157_mes)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si157_mes"])){
           $this->si157_mes = "0" ;
        }
       $sql  .= $virgula." si157_mes = $this->si157_mes ";
       $virgula = ",";
       if(trim($this->si157_mes) == null ){
         $this->erro_sql = " Campo Mes de Referencia nao Informado.";
         $this->erro_campo = "si157_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si157_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si157_instit"])){
        if(trim($this->si157_instit)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si157_instit"])){
           $this->si157_instit = "0" ;
        }
       $sql  .= $virgula." si157_instit = $this->si157_instit ";
       $virgula = ",";
       if(trim($this->si157_instit) == null ){
         $this->erro_sql = " Campo Mes de Referencia nao Informado.";
         $this->erro_campo = "si157_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where si157_sequencial = $si157_sequencial ";
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
   function excluir ( $si157_mes=null, $si157_codorgao=null ) {
     $this->atualizacampos(true);
     $sql = " delete from dclrf102019
                    where ";
     $sql2 = "";
     $sql2 = "si157_mes = $si157_mes AND si157_instit = '$si157_codorgao' ";
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
   function sql_query ( $si157_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf102019 ";
     $sql2 = "";
     if($dbwhere==""){
       if( $si157_sequencial != "" && $si157_sequencial != null){
          $sql2 = " where dclrf102019.si157_sequencial = $si157_sequencial";
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
   function sql_query_file ( $si157_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf102019 ";
     $sql2 = "";
     if($dbwhere==""){
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
