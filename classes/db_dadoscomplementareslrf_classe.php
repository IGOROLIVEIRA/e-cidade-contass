<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE \d dadoscomplementareslrf
class cl_dadoscomplementareslrf {
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
   var $c218_sequencial = 0;
   var $c218_codorgao = null;
   var $c218_passivosreconhecidos = 0;
   var $c218_vlsaldoatualconcgarantiainterna = 0;
   var $c218_vlsaldoatualconcgarantia = 0;
   var $c218_vlsaldoatualcontragarantiainterna = 0;
   var $c218_vlsaldoatualcontragarantiaexterna = 0;
   var $c218_medidascorretivas = null;
   var $c218_recalieninvpermanente = 0;
   var $c218_vldotatualizadaincentcontrib = 0;
   var $c218_vlempenhadoicentcontrib = 0;
   var $c218_vldotatualizadaincentinstfinanc = 0;
   var $c218_vlempenhadoincentinstfinanc = 0;
   var $c218_vlliqincentcontrib = 0;
   var $c218_vlliqincentinstfinanc = 0;
   var $c218_vlirpnpincentcontrib = 0;
   var $c218_vlirpnpincentinstfinanc = 0;
   var $c218_vlrecursosnaoaplicados = 0;
   var $c218_vlapropiacaodepositosjudiciais = 0;
   var $c218_vloutrosajustes = 0;
   var $c218_metarrecada = 0;
   var $c218_dscmedidasadotadas = null;

   var $c218_vldotinicialincentivocontrib = 0;
   var $c218_vldotincentconcedinstfinanc = 0;
   var $c218_vlajustesrelativosrpps = 0;

   var $c218_anousu = null;
   var $c218_mesusu = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 c218_sequencial = int4 = Sequencial DCLRF
                 c218_codorgao = char(2) = Código do órgão
                 c218_passivosreconhecidos = double = Valores dos passivos  reconhecidos
                 c218_vlsaldoatualconcgarantiainterna = double = Saldo atual das concessões de garantia
                 c218_vlsaldoatualconcgarantia = double = Saldo atual das concessões de garantia
                 c218_vlsaldoatualcontragarantiainterna = double = Saldo atual das contragarantias
                 c218_vlsaldoatualcontragarantiaexterna = double = Saldo atual das contragarantias externas
                 c218_medidascorretivas = text = Medidas corretivas adotadas
                 c218_recalieninvpermanente = Double = cálculo apurado da receita de alienação
                 c218_vldotatualizadaincentcontrib = double = Valor da dotação atualizada de Incentivo
                 c218_vlempenhadoicentcontrib = Double = Valor empenhado de Incentivo
                 c218_vldotatualizadaincentinstfinanc = double = Valor da dotação atualizada de Incentivo
                 c218_vlempenhadoincentinstfinanc = double = Valor empenhado de Incentivo concedido
                 c218_vlliqincentcontrib = double = Valor Liquidado de Incentivo
                 c218_vlliqincentinstfinanc = double = Valor Liquidado de Incentivo
                 c218_vlirpnpincentcontrib = double = Restos a Pagar Não Processados
                 c218_vlirpnpincentinstfinanc = double = Restos a Pagar Não Processados de Incen
                 c218_vlrecursosnaoaplicados = double = Recursos do FUNDEB não aplicados
                 c218_vlapropiacaodepositosjudiciais = double = Saldo apurado da apropriação
                 c218_vloutrosajustes = double = Valores não considerados
                 c218_metarrecada = int4 = A meta bimestral de arrecadação foi cumprida
                 c218_dscmedidasadotadas = text = Medidas adotadas e a adotar
                 
                 c218_vldotinicialincentivocontrib = double = valor dotação inicial de incentivo  a contribuinte
                 c218_vldotinicialincentivocontrib = double = valor dotação de incentivo concedido por instituição financeira
                 c218_vldotinicialincentivocontrib = double = valor de ajustes relativos ao rpps
                 
                 c218_anousu = int4 = Ano de referencia
                 c218_mesusu = int2 = Mês de referencia
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
       $this->c218_sequencial = ($this->c218_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_sequencial"]:$this->c218_sequencial);
       $this->c218_codorgao = ($this->c218_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_codorgao"]:$this->c218_codorgao);
       $this->c218_passivosreconhecidos = ($this->c218_passivosreconhecidos == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_passivosreconhecidos"]:$this->c218_passivosreconhecidos);
       $this->c218_vlsaldoatualconcgarantiainterna = ($this->c218_vlsaldoatualconcgarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualconcgarantiainterna"]:$this->c218_vlsaldoatualconcgarantiainterna);
       $this->c218_vlsaldoatualconcgarantia = ($this->c218_vlsaldoatualconcgarantia == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualconcgarantia"]:$this->c218_vlsaldoatualconcgarantia);
       $this->c218_vlsaldoatualcontragarantiainterna = ($this->c218_vlsaldoatualcontragarantiainterna == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualcontragarantiainterna"]:$this->c218_vlsaldoatualcontragarantiainterna);
       $this->c218_vlsaldoatualcontragarantiaexterna = ($this->c218_vlsaldoatualcontragarantiaexterna == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualcontragarantiaexterna"]:$this->c218_vlsaldoatualcontragarantiaexterna);
       $this->c218_medidascorretivas = ($this->c218_medidascorretivas == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_medidascorretivas"]:$this->c218_medidascorretivas);
       $this->c218_recalieninvpermanente = ($this->c218_recalieninvpermanente == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_recalieninvpermanente"]:$this->c218_recalieninvpermanente);
       $this->c218_vldotatualizadaincentcontrib = ($this->c218_vldotatualizadaincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vldotatualizadaincentcontrib"]:$this->c218_vldotatualizadaincentcontrib);
       $this->c218_vlempenhadoicentcontrib = ($this->c218_vlempenhadoicentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlempenhadoicentcontrib"]:$this->c218_vlempenhadoicentcontrib);
       $this->c218_vldotatualizadaincentinstfinanc = ($this->c218_vldotatualizadaincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vldotatualizadaincentinstfinanc"]:$this->c218_vldotatualizadaincentinstfinanc);
       $this->c218_vlempenhadoincentinstfinanc = ($this->c218_vlempenhadoincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlempenhadoincentinstfinanc"]:$this->c218_vlempenhadoincentinstfinanc);
       $this->c218_vlliqincentcontrib = ($this->c218_vlliqincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlliqincentcontrib"]:$this->c218_vlliqincentcontrib);
       $this->c218_vlliqincentinstfinanc = ($this->c218_vlliqincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlliqincentinstfinanc"]:$this->c218_vlliqincentinstfinanc);
       $this->c218_vlirpnpincentcontrib = ($this->c218_vlirpnpincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlirpnpincentcontrib"]:$this->c218_vlirpnpincentcontrib);
       $this->c218_vlirpnpincentinstfinanc = ($this->c218_vlirpnpincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlirpnpincentinstfinanc"]:$this->c218_vlirpnpincentinstfinanc);
       $this->c218_vlrecursosnaoaplicados = ($this->c218_vlrecursosnaoaplicados == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlrecursosnaoaplicados"]:$this->c218_vlrecursosnaoaplicados);
       $this->c218_vlapropiacaodepositosjudiciais = ($this->c218_vlapropiacaodepositosjudiciais == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlapropiacaodepositosjudiciais"]:$this->c218_vlapropiacaodepositosjudiciais);
       $this->c218_vloutrosajustes = ($this->c218_vloutrosajustes == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vloutrosajustes"]:$this->c218_vloutrosajustes);
       $this->c218_metarrecada = ($this->c218_metarrecada == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_metarrecada"]:$this->c218_metarrecada);
       $this->c218_dscmedidasadotadas = ($this->c218_dscmedidasadotadas == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_dscmedidasadotadas"]:$this->c218_dscmedidasadotadas);

       $this->c218_vldotinicialincentivocontrib = ($this->c218_vldotinicialincentivocontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vldotinicialincentivocontrib"]:$this->c218_vldotinicialincentivocontrib);
       $this->c218_vldotincentconcedinstfinanc = ($this->c218_vldotincentconcedinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vldotincentconcedinstfinanc"]:$this->c218_vldotincentconcedinstfinanc);
       $this->c218_vlajustesrelativosrpps = ($this->c218_vlajustesrelativosrpps == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_vlajustesrelativosrpps"]:$this->c218_vlajustesrelativosrpps);

       $this->c218_anousu = ($this->c218_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_anousu"]:$this->c218_anousu);
       $this->c218_mesusu = ($this->c218_mesusu == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_mesusu"]:$this->c218_mesusu);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();

     if($this->c218_codorgao == null ){
       $this->erro_sql = " Campo Código do órgão nao Informado.";
       $this->erro_campo = "c218_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c218_passivosreconhecidos == null ){
       $this->c218_passivosreconhecidos = 0;
     }
     if($this->c218_vlsaldoatualconcgarantiainterna == null ){
       $this->c218_vlsaldoatualconcgarantiainterna = 0;
     }
     if($this->c218_vlsaldoatualconcgarantia == null ){
       $this->c218_vlsaldoatualconcgarantia = 0;
     }
     if($this->c218_vlsaldoatualcontragarantiainterna == null ){
      $this->c218_vlsaldoatualcontragarantiainterna = 0;
     }
     if($this->c218_vlsaldoatualcontragarantiaexterna == null ){
      $this->c218_vlsaldoatualcontragarantiaexterna=0;
     }
     if($this->c218_recalieninvpermanente == null ){
       $this->c218_recalieninvpermanente =0;
     }
     if($this->c218_vldotatualizadaincentcontrib == null ){
       $this->c218_vldotatualizadaincentcontrib =0;
     }
     if($this->c218_vlempenhadoicentcontrib == null ){
       $this->c218_vlempenhadoicentcontrib =0;
     }
     if($this->c218_vldotatualizadaincentinstfinanc == null ){
       $this->c218_vldotatualizadaincentinstfinanc =0;
     }
     if($this->c218_vlempenhadoincentinstfinanc == null ){
       $this->c218_vlempenhadoincentinstfinanc =0;
     }
     if($this->c218_vlliqincentcontrib == null ){
       $this->c218_vlliqincentcontrib =0;
     }
     if($this->c218_vlliqincentinstfinanc == null ){
       $this->c218_vlliqincentinstfinanc =0;
     }
     if($this->c218_vlirpnpincentcontrib == null ){
       $this->c218_vlirpnpincentcontrib =0;
     }
     if($this->c218_vlirpnpincentinstfinanc == null ){
       $this->c218_vlirpnpincentinstfinanc =0;
     }
     if($this->c218_vlrecursosnaoaplicados == null ){
       $this->c218_vlrecursosnaoaplicados =0;
     }
     if($this->c218_vlapropiacaodepositosjudiciais == null ){
       $this->c218_vlapropiacaodepositosjudiciais =0;
     }
     if($this->c218_vloutrosajustes == null ){
       $this->c218_vloutrosajustes =0;
     }
       if($this->c218_vldotinicialincentivocontrib == null ){
           $this->c218_vldotinicialincentivocontrib =0;
       }
       if($this->c218_vldotincentconcedinstfinanc == null ){
           $this->c218_vldotincentconcedinstfinanc =0;
       }
       if($this->c218_vlajustesrelativosrpps == null ){
           $this->c218_vlajustesrelativosrpps =0;
       }
     if($this->c218_metarrecada == null ){
       $this->erro_sql = " Campo A meta bimestral de arrecadação foi cumprida nao Informado.";
       $this->erro_campo = "c218_metarrecada";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->c218_anousu == null ){
       $this->erro_sql = " Campo Ano de referencia nao Informado.";
       $this->erro_campo = "c218_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c218_mesusu == null ){
       $this->erro_sql = " Campo Mes de referencia nao Informado.";
       $this->erro_campo = "c218_mesusu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c218_sequencial == "" || $this->c218_sequencial == null ){
       $result = @pg_query("select nextval('dadoscomplementareslrf_c218_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dadoscomplementareslrf_c218_sequencial_seq do campo: c218_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c218_sequencial = pg_result($result,0,0);
     }else{
       $result = @pg_query("select last_value from dadoscomplementareslrf_c218_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c218_sequencial)){
         $this->erro_sql = " Campo c218_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c218_sequencial = $c218_sequencial;
       }
     }
     $sql = "insert into dadoscomplementareslrf(
                                       c218_sequencial
                                      ,c218_codorgao
                                      ,c218_passivosreconhecidos
                                      ,c218_vlsaldoatualconcgarantiainterna
                                      ,c218_vlsaldoatualconcgarantia
                                      ,c218_vlsaldoatualcontragarantiainterna
                                      ,c218_vlsaldoatualcontragarantiaexterna
                                      ,c218_medidascorretivas
                                      ,c218_recalieninvpermanente
                                      ,c218_vldotatualizadaincentcontrib
                                      ,c218_vlempenhadoicentcontrib
                                      ,c218_vldotatualizadaincentinstfinanc
                                      ,c218_vlempenhadoincentinstfinanc
                                      ,c218_vlliqincentcontrib
                                      ,c218_vlliqincentinstfinanc
                                      ,c218_vlirpnpincentcontrib
                                      ,c218_vlirpnpincentinstfinanc
                                      ,c218_vlrecursosnaoaplicados
                                      ,c218_vlapropiacaodepositosjudiciais
                                      ,c218_vloutrosajustes
                                      ,c218_metarrecada
                                      ,c218_dscmedidasadotadas
                                      ,c218_vldotinicialincentivocontrib
                                      ,c218_vldotincentconcedinstfinanc
                                      ,c218_vlajustesrelativosrpps
                                      ,c218_anousu
                                      ,c218_mesusu
                       )
                values (
                                $this->c218_sequencial
                               ,'$this->c218_codorgao'
                               ,$this->c218_passivosreconhecidos
                               ,$this->c218_vlsaldoatualconcgarantiainterna
                               ,$this->c218_vlsaldoatualconcgarantia
                               ,$this->c218_vlsaldoatualcontragarantiainterna
                               ,$this->c218_vlsaldoatualcontragarantiaexterna
                               ,'$this->c218_medidascorretivas'
                               ,$this->c218_recalieninvpermanente
                               ,$this->c218_vldotatualizadaincentcontrib
                               ,$this->c218_vlempenhadoicentcontrib
                               ,$this->c218_vldotatualizadaincentinstfinanc
                               ,$this->c218_vlempenhadoincentinstfinanc
                               ,$this->c218_vlliqincentcontrib
                               ,$this->c218_vlliqincentinstfinanc
                               ,$this->c218_vlirpnpincentcontrib
                               ,$this->c218_vlirpnpincentinstfinanc
                               ,$this->c218_vlrecursosnaoaplicados
                               ,$this->c218_vlapropiacaodepositosjudiciais
                               ,$this->c218_vloutrosajustes
                               ,$this->c218_metarrecada
                               ,'$this->c218_dscmedidasadotadas'
                               ,$this->c218_vldotinicialincentivocontrib
                               ,$this->c218_vldotincentconcedinstfinanc
                               ,$this->c218_vlajustesrelativosrpps
                               ,'$this->c218_anousu'
                               ,'$this->c218_mesusu'
                      )";
//     echo $sql;exit;
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
   function alterar ( $c218_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update dadoscomplementareslrf set ";
     $virgula = "";
     if(trim($this->c218_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_sequencial"])){
        if(trim($this->c218_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c218_sequencial"])){
           $this->c218_sequencial = "0" ;
        }
       $sql  .= $virgula." c218_sequencial = $this->c218_sequencial ";
       $virgula = ",";
       if(trim($this->c218_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
         $this->erro_campo = "c218_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_codorgao"])){
       $sql  .= $virgula." c218_codorgao = '$this->c218_codorgao' ";
       $virgula = ",";
       if(trim($this->c218_codorgao) == null ){
         $this->erro_sql = " Campo Código do órgão nao Informado.";
         $this->erro_campo = "c218_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_passivosreconhecidos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_passivosreconhecidos"])){
       $sql  .= $virgula." c218_passivosreconhecidos = $this->c218_passivosreconhecidos ";
       $virgula = ",";
       if(trim($this->c218_passivosreconhecidos) == null ){
         $this->erro_sql = " Campo Valores dos passivos  reconhecidos nao Informado.";
         $this->erro_campo = "c218_passivosreconhecidos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlsaldoatualconcgarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualconcgarantiainterna"])){
       $sql  .= $virgula." c218_vlsaldoatualconcgarantiainterna = $this->c218_vlsaldoatualconcgarantiainterna ";
       $virgula = ",";
       if(trim($this->c218_vlsaldoatualconcgarantiainterna) == null ){
         $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
         $this->erro_campo = "c218_vlsaldoatualconcgarantiainterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlsaldoatualconcgarantia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualconcgarantia"])){
       $sql  .= $virgula." c218_vlsaldoatualconcgarantia = $this->c218_vlsaldoatualconcgarantia ";
       $virgula = ",";
       if(trim($this->c218_vlsaldoatualconcgarantia) == null ){
         $this->erro_sql = " Campo Saldo atual das concessões de garantia nao Informado.";
         $this->erro_campo = "c218_vlsaldoatualconcgarantia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlsaldoatualcontragarantiainterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualcontragarantiainterna"])){
       $sql  .= $virgula." c218_vlsaldoatualcontragarantiainterna = $this->c218_vlsaldoatualcontragarantiainterna ";
       $virgula = ",";
       if(trim($this->c218_vlsaldoatualcontragarantiainterna) == null ){
         $this->erro_sql = " Campo Saldo atual das contragarantias nao Informado.";
         $this->erro_campo = "c218_vlsaldoatualcontragarantiainterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlsaldoatualcontragarantiaexterna)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlsaldoatualcontragarantiaexterna"])){
       $sql  .= $virgula." c218_vlsaldoatualcontragarantiaexterna = $this->c218_vlsaldoatualcontragarantiaexterna ";
       $virgula = ",";
       if(trim($this->c218_vlsaldoatualcontragarantiaexterna) == null ){
         $this->erro_sql = " Campo Saldo atual das contragarantias externas nao Informado.";
         $this->erro_campo = "c218_vlsaldoatualcontragarantiaexterna";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql  .= $virgula." c218_medidascorretivas = '$this->c218_medidascorretivas' ";
       $virgula = ",";
     if(trim($this->c218_recalieninvpermanente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_recalieninvpermanente"])){
       $sql  .= $virgula." c218_recalieninvpermanente = $this->c218_recalieninvpermanente ";
       $virgula = ",";
       if(trim($this->c218_recalieninvpermanente) == null ){
         $this->erro_sql = " Campo cálculo apurado da receita de alienação nao Informado.";
         $this->erro_campo = "c218_recalieninvpermanente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vldotatualizadaincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vldotatualizadaincentcontrib"])){
       $sql  .= $virgula." c218_vldotatualizadaincentcontrib = $this->c218_vldotatualizadaincentcontrib ";
       $virgula = ",";
       if(trim($this->c218_vldotatualizadaincentcontrib) == null ){
         $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
         $this->erro_campo = "c218_vldotatualizadaincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlempenhadoicentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlempenhadoicentcontrib"])){
       $sql  .= $virgula." c218_vlempenhadoicentcontrib = $this->c218_vlempenhadoicentcontrib ";
       $virgula = ",";
       if(trim($this->c218_vlempenhadoicentcontrib) == null ){
         $this->erro_sql = " Campo Valor empenhado de Incentivo nao Informado.";
         $this->erro_campo = "c218_vlempenhadoicentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vldotatualizadaincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vldotatualizadaincentinstfinanc"])){
       $sql  .= $virgula." c218_vldotatualizadaincentinstfinanc = $this->c218_vldotatualizadaincentinstfinanc ";
       $virgula = ",";
       if(trim($this->c218_vldotatualizadaincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor da dotação atualizada de Incentivo nao Informado.";
         $this->erro_campo = "c218_vldotatualizadaincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlempenhadoincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlempenhadoincentinstfinanc"])){
       $sql  .= $virgula." c218_vlempenhadoincentinstfinanc = $this->c218_vlempenhadoincentinstfinanc ";
       $virgula = ",";
       if(trim($this->c218_vlempenhadoincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor empenhado de Incentivo concedido nao Informado.";
         $this->erro_campo = "c218_vlempenhadoincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlliqincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlliqincentcontrib"])){
       $sql  .= $virgula." c218_vlliqincentcontrib = $this->c218_vlliqincentcontrib ";
       $virgula = ",";
       if(trim($this->c218_vlliqincentcontrib) == null ){
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "c218_vlliqincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlliqincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlliqincentinstfinanc"])){
       $sql  .= $virgula." c218_vlliqincentinstfinanc = $this->c218_vlliqincentinstfinanc ";
       $virgula = ",";
       if(trim($this->c218_vlliqincentinstfinanc) == null ){
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "c218_vlliqincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlirpnpincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlirpnpincentcontrib"])){
       $sql  .= $virgula." c218_vlirpnpincentcontrib = $this->c218_vlirpnpincentcontrib ";
       $virgula = ",";
       if(trim($this->c218_vlirpnpincentcontrib) == null ){
         $this->erro_sql = " Campo Restos a Pagar Não Processados nao Informado.";
         $this->erro_campo = "c218_vlirpnpincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlirpnpincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlirpnpincentinstfinanc"])){
       $sql  .= $virgula." c218_vlirpnpincentinstfinanc = $this->c218_vlirpnpincentinstfinanc ";
       $virgula = ",";
       if(trim($this->c218_vlirpnpincentinstfinanc) == null ){
         $this->erro_sql = " Campo Restos a Pagar Não Processados de Incen nao Informado.";
         $this->erro_campo = "c218_vlirpnpincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlrecursosnaoaplicados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlrecursosnaoaplicados"])){
       $sql  .= $virgula." c218_vlrecursosnaoaplicados = $this->c218_vlrecursosnaoaplicados ";
       $virgula = ",";
       if(trim($this->c218_vlrecursosnaoaplicados) == null ){
         $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
         $this->erro_campo = "c218_vlrecursosnaoaplicados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vlapropiacaodepositosjudiciais)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlapropiacaodepositosjudiciais"])){
       $sql  .= $virgula." c218_vlapropiacaodepositosjudiciais = $this->c218_vlapropiacaodepositosjudiciais ";
       $virgula = ",";
       if(trim($this->c218_vlapropiacaodepositosjudiciais) == null ){
         $this->erro_sql = " Campo Saldo apurado da apropriação nao Informado.";
         $this->erro_campo = "c218_vlapropiacaodepositosjudiciais";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_vloutrosajustes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vloutrosajustes"])){
       $sql  .= $virgula." c218_vloutrosajustes = $this->c218_vloutrosajustes ";
       $virgula = ",";
       if(trim($this->c218_vloutrosajustes) == null ){
         $this->erro_sql = " Campo Valores não considerados nao Informado.";
         $this->erro_campo = "c218_vloutrosajustes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }

       if(trim($this->c218_vldotinicialincentivocontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vldotinicialincentivocontrib"])){
           $sql  .= $virgula." c218_vldotinicialincentivocontrib = $this->c218_vldotinicialincentivocontrib ";
           $virgula = ",";
           if(trim($this->c218_vldotinicialincentivocontrib) == null ){
               $this->erro_sql = " Campo valor dotação inicial de incentivo  a contribuinte nao Informado.";
               $this->erro_campo = "c218_vldotinicialincentivocontrib";
               $this->erro_banco = "";
               $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
               $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
               $this->erro_status = "0";
               return false;
           }
       }

       if(trim($this->c218_vldotincentconcedinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vldotincentconcedinstfinanc"])){
           $sql  .= $virgula." c218_vldotincentconcedinstfinanc = $this->c218_vldotincentconcedinstfinanc ";
           $virgula = ",";
           if(trim($this->c218_vldotinicialincentivocontrib) == null ){
               $this->erro_sql = " Campo valor dotação de incentivo concedido por instituição financeira nao Informado.";
               $this->erro_campo = "c218_vldotincentconcedinstfinanc";
               $this->erro_banco = "";
               $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
               $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
               $this->erro_status = "0";
               return false;
           }
       }

       if(trim($this->c218_vlajustesrelativosrpps)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_vlajustesrelativosrpps"])){
           $sql  .= $virgula." c218_vlajustesrelativosrpps = $this->c218_vlajustesrelativosrpps ";
           $virgula = ",";
           if(trim($this->c218_vlajustesrelativosrpps) == null ){
               $this->erro_sql = " Campo valor de ajustes relativos ao rpps nao Informado.";
               $this->erro_campo = "c218_vlajustesrelativosrpps";
               $this->erro_banco = "";
               $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
               $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
               $this->erro_status = "0";
               return false;
           }
       }

     if(trim($this->c218_metarrecada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_metarrecada"])){
        if(trim($this->c218_metarrecada)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c218_metarrecada"])){
           $this->c218_metarrecada = "0" ;
        }
       $sql  .= $virgula." c218_metarrecada = $this->c218_metarrecada ";
       $virgula = ",";
     }
       $sql  .= $virgula." c218_dscmedidasadotadas = '$this->c218_dscmedidasadotadas' ";
       $virgula = ",";
     if(trim($this->c218_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_anousu"])){
       $sql  .= $virgula." c218_anousu = '$this->c218_anousu' ";
       $virgula = ",";
       if(trim($this->c218_anousu) == null ){
         $this->erro_sql = " Campo Ano nao Informado.";
         $this->erro_campo = "c218_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c218_mesusu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_mesusu"])){
       $sql  .= $virgula." c218_mesusu = '$this->c218_mesusu' ";
       $virgula = ",";
       if(trim($this->c218_mesusu) == null ){
         $this->erro_sql = " Campo Mes nao Informado.";
         $this->erro_campo = "c218_mesusu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where c218_sequencial = $c218_sequencial ";
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
   function excluir ( $c218_sequencial=null ) {
     $this->atualizacampos(true);
     $sql = " delete from dadoscomplementareslrf
                    where ";
     $sql2 = "";
     $sql2 = "c218_sequencial = $c218_sequencial";

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
   function sql_query ( $c218_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dadoscomplementareslrf ";

     $sql .= " left join publicacaoeperiodicidaderreo on c218_sequencial = c220_dadoscomplementareslrf ";
     $sql .= " left join publicacaoeperiodicidadergf on c218_sequencial = c221_dadoscomplementareslrf ";
     $sql .= " left join operacoesdecreditolrf on c218_sequencial = c219_dadoscomplementareslrf ";

     if($dbwhere==""){
       if( $c218_sequencial != "" && $c218_sequencial != null){
          $sql2 = " where dadoscomplementareslrf.c218_sequencial = $c218_sequencial";
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
   function sql_query_file ( $c218_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dadoscomplementareslrf ";
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
