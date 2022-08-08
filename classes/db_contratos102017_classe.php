<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos102017
class cl_contratos102017 { 
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
   var $si83_sequencial = 0; 
   var $si83_tiporegistro = 0; 
   var $si83_codcontrato = 0; 
   var $si83_codorgao = null; 
   var $si83_codunidadesub = null; 
   var $si83_nrocontrato = 0; 
   var $si83_exerciciocontrato = 0; 
   var $si83_dataassinatura_dia = null; 
   var $si83_dataassinatura_mes = null; 
   var $si83_dataassinatura_ano = null; 
   var $si83_dataassinatura = null; 
   var $si83_contdeclicitacao = 0; 
   var $si83_codorgaoresp = null; 
   var $si83_codunidadesubresp = null; 
   var $si83_nroprocesso = null; 
   var $si83_exercicioprocesso = 0; 
   var $si83_tipoprocesso = 0; 
   var $si83_naturezaobjeto = 0; 
   var $si83_objetocontrato = null; 
   var $si83_tipoinstrumento = 0; 
   var $si83_datainiciovigencia_dia = null; 
   var $si83_datainiciovigencia_mes = null; 
   var $si83_datainiciovigencia_ano = null; 
   var $si83_datainiciovigencia = null; 
   var $si83_datafinalvigencia_dia = null; 
   var $si83_datafinalvigencia_mes = null; 
   var $si83_datafinalvigencia_ano = null; 
   var $si83_datafinalvigencia = null; 
   var $si83_vlcontrato = 0; 
   var $si83_formafornecimento = null; 
   var $si83_formapagamento = null; 
   var $si83_prazoexecucao = null; 
   var $si83_multarescisoria = null; 
   var $si83_multainadimplemento = null; 
   var $si83_garantia = 0; 
   var $si83_cpfsignatariocontratante = null; 
   var $si83_datapublicacao_dia = null; 
   var $si83_datapublicacao_mes = null; 
   var $si83_datapublicacao_ano = null; 
   var $si83_datapublicacao = null; 
   var $si83_veiculodivulgacao = null; 
   var $si83_mes = 0; 
   var $si83_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si83_sequencial = int8 = sequencial 
                 si83_tiporegistro = int8 = Tipo do registro 
                 si83_codcontrato = int8 = Código do contrato 
                 si83_codorgao = varchar(2) = Código do órgão 
                 si83_codunidadesub = varchar(8) = Código da unidade 
                 si83_nrocontrato = int8 = Número do  Contrato 
                 si83_exerciciocontrato = int8 = Exercício do  Contrato 
                 si83_dataassinatura = date = Data da assinatura  do Contrato 
                 si83_contdeclicitacao = int8 = Contrato decorrente de Licitação 
                 si83_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si83_codunidadesubresp = varchar(8) = Código da unidade 
                 si83_nroprocesso = varchar(12) = Número do  processo 
                 si83_exercicioprocesso = int8 = Exercício do  processo 
                 si83_tipoprocesso = int8 = Tipo de processo 
                 si83_naturezaobjeto = int8 = Natureza do objeto 
                 si83_objetocontrato = varchar(500) = Objeto do contrato 
                 si83_tipoinstrumento = int8 = Tipo de  Instrumento 
                 si83_datainiciovigencia = date = Data inicial da  vigência 
                 si83_datafinalvigencia = date = Data final da  vigência 
                 si83_vlcontrato = float8 = Valor do contrato 
                 si83_formafornecimento = varchar(50) = Forma de  fornecimento 
                 si83_formapagamento = varchar(100) = Forma de  pagamento 
                 si83_prazoexecucao = varchar(100) = Prazo de Execução 
                 si83_multarescisoria = varchar(100) = Multa Rescisória 
                 si83_multainadimplemento = varchar(100) = Multa  inadimplemento 
                 si83_garantia = int8 = Tipo de garantia  contratual 
                 si83_cpfsignatariocontratante = varchar(11) = Número do CPF do  signatário 
                 si83_datapublicacao = date = Data da publicação  do contrato 
                 si83_veiculodivulgacao = varchar(50) = Veículo de  Divulgação 
                 si83_mes = int8 = Mês 
                 si83_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_contratos102017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos102017"); 
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
       $this->si83_sequencial = ($this->si83_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_sequencial"]:$this->si83_sequencial);
       $this->si83_tiporegistro = ($this->si83_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_tiporegistro"]:$this->si83_tiporegistro);
       $this->si83_codcontrato = ($this->si83_codcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_codcontrato"]:$this->si83_codcontrato);
       $this->si83_codorgao = ($this->si83_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_codorgao"]:$this->si83_codorgao);
       $this->si83_codunidadesub = ($this->si83_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_codunidadesub"]:$this->si83_codunidadesub);
       $this->si83_nrocontrato = ($this->si83_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_nrocontrato"]:$this->si83_nrocontrato);
       $this->si83_exerciciocontrato = ($this->si83_exerciciocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_exerciciocontrato"]:$this->si83_exerciciocontrato);
       if($this->si83_dataassinatura == ""){
         $this->si83_dataassinatura_dia = ($this->si83_dataassinatura_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_dataassinatura_dia"]:$this->si83_dataassinatura_dia);
         $this->si83_dataassinatura_mes = ($this->si83_dataassinatura_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_dataassinatura_mes"]:$this->si83_dataassinatura_mes);
         $this->si83_dataassinatura_ano = ($this->si83_dataassinatura_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_dataassinatura_ano"]:$this->si83_dataassinatura_ano);
         if($this->si83_dataassinatura_dia != ""){
            $this->si83_dataassinatura = $this->si83_dataassinatura_ano."-".$this->si83_dataassinatura_mes."-".$this->si83_dataassinatura_dia;
         }
       }
       $this->si83_contdeclicitacao = ($this->si83_contdeclicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_contdeclicitacao"]:$this->si83_contdeclicitacao);
       $this->si83_codorgaoresp = ($this->si83_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_codorgaoresp"]:$this->si83_codorgaoresp);
       $this->si83_codunidadesubresp = ($this->si83_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_codunidadesubresp"]:$this->si83_codunidadesubresp);
       $this->si83_nroprocesso = ($this->si83_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_nroprocesso"]:$this->si83_nroprocesso);
       $this->si83_exercicioprocesso = ($this->si83_exercicioprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_exercicioprocesso"]:$this->si83_exercicioprocesso);
       $this->si83_tipoprocesso = ($this->si83_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_tipoprocesso"]:$this->si83_tipoprocesso);
       $this->si83_naturezaobjeto = ($this->si83_naturezaobjeto == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_naturezaobjeto"]:$this->si83_naturezaobjeto);
       $this->si83_objetocontrato = ($this->si83_objetocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_objetocontrato"]:$this->si83_objetocontrato);
       $this->si83_tipoinstrumento = ($this->si83_tipoinstrumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_tipoinstrumento"]:$this->si83_tipoinstrumento);
       if($this->si83_datainiciovigencia == ""){
         $this->si83_datainiciovigencia_dia = ($this->si83_datainiciovigencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datainiciovigencia_dia"]:$this->si83_datainiciovigencia_dia);
         $this->si83_datainiciovigencia_mes = ($this->si83_datainiciovigencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datainiciovigencia_mes"]:$this->si83_datainiciovigencia_mes);
         $this->si83_datainiciovigencia_ano = ($this->si83_datainiciovigencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datainiciovigencia_ano"]:$this->si83_datainiciovigencia_ano);
         if($this->si83_datainiciovigencia_dia != ""){
            $this->si83_datainiciovigencia = $this->si83_datainiciovigencia_ano."-".$this->si83_datainiciovigencia_mes."-".$this->si83_datainiciovigencia_dia;
         }
       }
       if($this->si83_datafinalvigencia == ""){
         $this->si83_datafinalvigencia_dia = ($this->si83_datafinalvigencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datafinalvigencia_dia"]:$this->si83_datafinalvigencia_dia);
         $this->si83_datafinalvigencia_mes = ($this->si83_datafinalvigencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datafinalvigencia_mes"]:$this->si83_datafinalvigencia_mes);
         $this->si83_datafinalvigencia_ano = ($this->si83_datafinalvigencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datafinalvigencia_ano"]:$this->si83_datafinalvigencia_ano);
         if($this->si83_datafinalvigencia_dia != ""){
            $this->si83_datafinalvigencia = $this->si83_datafinalvigencia_ano."-".$this->si83_datafinalvigencia_mes."-".$this->si83_datafinalvigencia_dia;
         }
       }
       $this->si83_vlcontrato = ($this->si83_vlcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_vlcontrato"]:$this->si83_vlcontrato);
       $this->si83_formafornecimento = ($this->si83_formafornecimento == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_formafornecimento"]:$this->si83_formafornecimento);
       $this->si83_formapagamento = ($this->si83_formapagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_formapagamento"]:$this->si83_formapagamento);
       $this->si83_prazoexecucao = ($this->si83_prazoexecucao == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_prazoexecucao"]:$this->si83_prazoexecucao);
       $this->si83_multarescisoria = ($this->si83_multarescisoria == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_multarescisoria"]:$this->si83_multarescisoria);
       $this->si83_multainadimplemento = ($this->si83_multainadimplemento == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_multainadimplemento"]:$this->si83_multainadimplemento);
       $this->si83_garantia = ($this->si83_garantia == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_garantia"]:$this->si83_garantia);
       $this->si83_cpfsignatariocontratante = ($this->si83_cpfsignatariocontratante == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_cpfsignatariocontratante"]:$this->si83_cpfsignatariocontratante);
       if($this->si83_datapublicacao == ""){
         $this->si83_datapublicacao_dia = ($this->si83_datapublicacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datapublicacao_dia"]:$this->si83_datapublicacao_dia);
         $this->si83_datapublicacao_mes = ($this->si83_datapublicacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datapublicacao_mes"]:$this->si83_datapublicacao_mes);
         $this->si83_datapublicacao_ano = ($this->si83_datapublicacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_datapublicacao_ano"]:$this->si83_datapublicacao_ano);
         if($this->si83_datapublicacao_dia != ""){
            $this->si83_datapublicacao = $this->si83_datapublicacao_ano."-".$this->si83_datapublicacao_mes."-".$this->si83_datapublicacao_dia;
         }
       }
       $this->si83_veiculodivulgacao = ($this->si83_veiculodivulgacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_veiculodivulgacao"]:$this->si83_veiculodivulgacao);
       $this->si83_mes = ($this->si83_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_mes"]:$this->si83_mes);
       $this->si83_instit = ($this->si83_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_instit"]:$this->si83_instit);
     }else{
       $this->si83_sequencial = ($this->si83_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si83_sequencial"]:$this->si83_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si83_sequencial){ 
      $this->atualizacampos();
     if($this->si83_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si83_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si83_codcontrato == null ){ 
       $this->si83_codcontrato = "0";
     }
     if($this->si83_nrocontrato == null ){ 
       $this->si83_nrocontrato = "0";
     }
     if($this->si83_exerciciocontrato == null ){ 
       $this->si83_exerciciocontrato = "0";
     }
     if($this->si83_dataassinatura == null ){ 
       $this->si83_dataassinatura = "null";
     }
     if($this->si83_contdeclicitacao == null ){ 
       $this->si83_contdeclicitacao = "0";
     }

     if($this->si83_exercicioprocesso == null || $this->si83_exercicioprocesso == ' '){
       $this->si83_exercicioprocesso = 0;
     }
     if($this->si83_tipoprocesso == null ){ 
       $this->si83_tipoprocesso = "0";
     }
     if($this->si83_naturezaobjeto == null ){ 
       $this->si83_naturezaobjeto = "0";
     }
     if($this->si83_tipoinstrumento == null ){ 
       $this->si83_tipoinstrumento = "0";
     }
     if($this->si83_datainiciovigencia == null ){ 
       $this->si83_datainiciovigencia = "null";
     }
     if($this->si83_datafinalvigencia == null ){ 
       $this->si83_datafinalvigencia = "null";
     }
     if($this->si83_vlcontrato == null ){ 
       $this->si83_vlcontrato = "0";
     }
     if($this->si83_garantia == null ){ 
       $this->si83_garantia = "0";
     }
     if($this->si83_datapublicacao == null ){ 
       $this->si83_datapublicacao = "null";
     }
     if($this->si83_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si83_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si83_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si83_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si83_sequencial == "" || $si83_sequencial == null ){
       $result = db_query("select nextval('contratos102017_si83_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos102017_si83_sequencial_seq do campo: si83_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si83_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from contratos102017_si83_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si83_sequencial)){
         $this->erro_sql = " Campo si83_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si83_sequencial = $si83_sequencial; 
       }
     }
     if(($this->si83_sequencial == null) || ($this->si83_sequencial == "") ){ 
       $this->erro_sql = " Campo si83_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos102017(
                                       si83_sequencial 
                                      ,si83_tiporegistro 
                                      ,si83_codcontrato 
                                      ,si83_codorgao 
                                      ,si83_codunidadesub 
                                      ,si83_nrocontrato 
                                      ,si83_exerciciocontrato 
                                      ,si83_dataassinatura 
                                      ,si83_contdeclicitacao 
                                      ,si83_codorgaoresp 
                                      ,si83_codunidadesubresp 
                                      ,si83_nroprocesso 
                                      ,si83_exercicioprocesso 
                                      ,si83_tipoprocesso 
                                      ,si83_naturezaobjeto 
                                      ,si83_objetocontrato 
                                      ,si83_tipoinstrumento 
                                      ,si83_datainiciovigencia 
                                      ,si83_datafinalvigencia 
                                      ,si83_vlcontrato 
                                      ,si83_formafornecimento 
                                      ,si83_formapagamento 
                                      ,si83_prazoexecucao 
                                      ,si83_multarescisoria 
                                      ,si83_multainadimplemento 
                                      ,si83_garantia 
                                      ,si83_cpfsignatariocontratante 
                                      ,si83_datapublicacao 
                                      ,si83_veiculodivulgacao 
                                      ,si83_mes 
                                      ,si83_instit 
                       )
                values (
                                $this->si83_sequencial 
                               ,$this->si83_tiporegistro 
                               ,$this->si83_codcontrato 
                               ,'$this->si83_codorgao' 
                               ,'$this->si83_codunidadesub' 
                               ,$this->si83_nrocontrato 
                               ,$this->si83_exerciciocontrato 
                               ,".($this->si83_dataassinatura == "null" || $this->si83_dataassinatura == ""?"null":"'".$this->si83_dataassinatura."'")." 
                               ,$this->si83_contdeclicitacao 
                               ,'$this->si83_codorgaoresp' 
                               ,'$this->si83_codunidadesubresp' 
                               ,'$this->si83_nroprocesso' 
                               ,$this->si83_exercicioprocesso 
                               ,$this->si83_tipoprocesso 
                               ,$this->si83_naturezaobjeto 
                               ,'$this->si83_objetocontrato' 
                               ,$this->si83_tipoinstrumento 
                               ,".($this->si83_datainiciovigencia == "null" || $this->si83_datainiciovigencia == ""?"null":"'".$this->si83_datainiciovigencia."'")." 
                               ,".($this->si83_datafinalvigencia == "null" || $this->si83_datafinalvigencia == ""?"null":"'".$this->si83_datafinalvigencia."'")." 
                               ,$this->si83_vlcontrato 
                               ,'$this->si83_formafornecimento' 
                               ,'$this->si83_formapagamento' 
                               ,'$this->si83_prazoexecucao' 
                               ,'$this->si83_multarescisoria' 
                               ,'$this->si83_multainadimplemento' 
                               ,$this->si83_garantia 
                               ,'$this->si83_cpfsignatariocontratante' 
                               ,".($this->si83_datapublicacao == "null" || $this->si83_datapublicacao == ""?"null":"'".$this->si83_datapublicacao."'")." 
                               ,'$this->si83_veiculodivulgacao' 
                               ,$this->si83_mes 
                               ,$this->si83_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos102017 ($this->si83_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "contratos102017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "contratos102017 ($this->si83_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si83_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si83_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010399,'$this->si83_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010312,2010399,'','".AddSlashes(pg_result($resaco,0,'si83_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010400,'','".AddSlashes(pg_result($resaco,0,'si83_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010401,'','".AddSlashes(pg_result($resaco,0,'si83_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010402,'','".AddSlashes(pg_result($resaco,0,'si83_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010403,'','".AddSlashes(pg_result($resaco,0,'si83_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010404,'','".AddSlashes(pg_result($resaco,0,'si83_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2011317,'','".AddSlashes(pg_result($resaco,0,'si83_exerciciocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010405,'','".AddSlashes(pg_result($resaco,0,'si83_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010406,'','".AddSlashes(pg_result($resaco,0,'si83_contdeclicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010407,'','".AddSlashes(pg_result($resaco,0,'si83_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010408,'','".AddSlashes(pg_result($resaco,0,'si83_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010409,'','".AddSlashes(pg_result($resaco,0,'si83_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010410,'','".AddSlashes(pg_result($resaco,0,'si83_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2011318,'','".AddSlashes(pg_result($resaco,0,'si83_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010411,'','".AddSlashes(pg_result($resaco,0,'si83_naturezaobjeto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010412,'','".AddSlashes(pg_result($resaco,0,'si83_objetocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010413,'','".AddSlashes(pg_result($resaco,0,'si83_tipoinstrumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010414,'','".AddSlashes(pg_result($resaco,0,'si83_datainiciovigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010415,'','".AddSlashes(pg_result($resaco,0,'si83_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010416,'','".AddSlashes(pg_result($resaco,0,'si83_vlcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010417,'','".AddSlashes(pg_result($resaco,0,'si83_formafornecimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010418,'','".AddSlashes(pg_result($resaco,0,'si83_formapagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010419,'','".AddSlashes(pg_result($resaco,0,'si83_prazoexecucao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010420,'','".AddSlashes(pg_result($resaco,0,'si83_multarescisoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010421,'','".AddSlashes(pg_result($resaco,0,'si83_multainadimplemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010422,'','".AddSlashes(pg_result($resaco,0,'si83_garantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010423,'','".AddSlashes(pg_result($resaco,0,'si83_cpfsignatariocontratante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010424,'','".AddSlashes(pg_result($resaco,0,'si83_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010425,'','".AddSlashes(pg_result($resaco,0,'si83_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2010426,'','".AddSlashes(pg_result($resaco,0,'si83_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010312,2011596,'','".AddSlashes(pg_result($resaco,0,'si83_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si83_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update contratos102017 set ";
     $virgula = "";
     if(trim($this->si83_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_sequencial"])){ 
        if(trim($this->si83_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_sequencial"])){ 
           $this->si83_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si83_sequencial = $this->si83_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si83_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_tiporegistro"])){ 
       $sql  .= $virgula." si83_tiporegistro = $this->si83_tiporegistro ";
       $virgula = ",";
       if(trim($this->si83_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si83_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si83_codcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_codcontrato"])){ 
        if(trim($this->si83_codcontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_codcontrato"])){ 
           $this->si83_codcontrato = "0" ; 
        } 
       $sql  .= $virgula." si83_codcontrato = $this->si83_codcontrato ";
       $virgula = ",";
     }
     if(trim($this->si83_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_codorgao"])){ 
       $sql  .= $virgula." si83_codorgao = '$this->si83_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si83_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_codunidadesub"])){ 
       $sql  .= $virgula." si83_codunidadesub = '$this->si83_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si83_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_nrocontrato"])){ 
        if(trim($this->si83_nrocontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_nrocontrato"])){ 
           $this->si83_nrocontrato = "0" ; 
        } 
       $sql  .= $virgula." si83_nrocontrato = $this->si83_nrocontrato ";
       $virgula = ",";
     }
     if(trim($this->si83_exerciciocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_exerciciocontrato"])){ 
        if(trim($this->si83_exerciciocontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_exerciciocontrato"])){ 
           $this->si83_exerciciocontrato = "0" ; 
        } 
       $sql  .= $virgula." si83_exerciciocontrato = $this->si83_exerciciocontrato ";
       $virgula = ",";
     }
     if(trim($this->si83_dataassinatura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_dataassinatura_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si83_dataassinatura_dia"] !="") ){ 
       $sql  .= $virgula." si83_dataassinatura = '$this->si83_dataassinatura' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si83_dataassinatura_dia"])){ 
         $sql  .= $virgula." si83_dataassinatura = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si83_contdeclicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_contdeclicitacao"])){ 
        if(trim($this->si83_contdeclicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_contdeclicitacao"])){ 
           $this->si83_contdeclicitacao = "0" ; 
        } 
       $sql  .= $virgula." si83_contdeclicitacao = $this->si83_contdeclicitacao ";
       $virgula = ",";
     }
     if(trim($this->si83_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_codorgaoresp"])){ 
       $sql  .= $virgula." si83_codorgaoresp = '$this->si83_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si83_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_codunidadesubresp"])){ 
       $sql  .= $virgula." si83_codunidadesubresp = '$this->si83_codunidadesubresp' ";
       $virgula = ",";
     }
     if(trim($this->si83_nroprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_nroprocesso"])){ 
       $sql  .= $virgula." si83_nroprocesso = '$this->si83_nroprocesso' ";
       $virgula = ",";
     }
     if(trim($this->si83_exercicioprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_exercicioprocesso"])){ 
        if(trim($this->si83_exercicioprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_exercicioprocesso"])){ 
           $this->si83_exercicioprocesso = "0" ; 
        } 
       $sql  .= $virgula." si83_exercicioprocesso = $this->si83_exercicioprocesso ";
       $virgula = ",";
     }
     if(trim($this->si83_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_tipoprocesso"])){ 
        if(trim($this->si83_tipoprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_tipoprocesso"])){ 
           $this->si83_tipoprocesso = "0" ; 
        } 
       $sql  .= $virgula." si83_tipoprocesso = $this->si83_tipoprocesso ";
       $virgula = ",";
     }
     if(trim($this->si83_naturezaobjeto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_naturezaobjeto"])){ 
        if(trim($this->si83_naturezaobjeto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_naturezaobjeto"])){ 
           $this->si83_naturezaobjeto = "0" ; 
        } 
       $sql  .= $virgula." si83_naturezaobjeto = $this->si83_naturezaobjeto ";
       $virgula = ",";
     }
     if(trim($this->si83_objetocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_objetocontrato"])){ 
       $sql  .= $virgula." si83_objetocontrato = '$this->si83_objetocontrato' ";
       $virgula = ",";
     }
     if(trim($this->si83_tipoinstrumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_tipoinstrumento"])){ 
        if(trim($this->si83_tipoinstrumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_tipoinstrumento"])){ 
           $this->si83_tipoinstrumento = "0" ; 
        } 
       $sql  .= $virgula." si83_tipoinstrumento = $this->si83_tipoinstrumento ";
       $virgula = ",";
     }
     if(trim($this->si83_datainiciovigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_datainiciovigencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si83_datainiciovigencia_dia"] !="") ){ 
       $sql  .= $virgula." si83_datainiciovigencia = '$this->si83_datainiciovigencia' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si83_datainiciovigencia_dia"])){ 
         $sql  .= $virgula." si83_datainiciovigencia = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si83_datafinalvigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_datafinalvigencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si83_datafinalvigencia_dia"] !="") ){ 
       $sql  .= $virgula." si83_datafinalvigencia = '$this->si83_datafinalvigencia' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si83_datafinalvigencia_dia"])){ 
         $sql  .= $virgula." si83_datafinalvigencia = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si83_vlcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_vlcontrato"])){ 
        if(trim($this->si83_vlcontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_vlcontrato"])){ 
           $this->si83_vlcontrato = "0" ; 
        } 
       $sql  .= $virgula." si83_vlcontrato = $this->si83_vlcontrato ";
       $virgula = ",";
     }
     if(trim($this->si83_formafornecimento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_formafornecimento"])){ 
       $sql  .= $virgula." si83_formafornecimento = '$this->si83_formafornecimento' ";
       $virgula = ",";
     }
     if(trim($this->si83_formapagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_formapagamento"])){ 
       $sql  .= $virgula." si83_formapagamento = '$this->si83_formapagamento' ";
       $virgula = ",";
     }
     if(trim($this->si83_prazoexecucao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_prazoexecucao"])){ 
       $sql  .= $virgula." si83_prazoexecucao = '$this->si83_prazoexecucao' ";
       $virgula = ",";
     }
     if(trim($this->si83_multarescisoria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_multarescisoria"])){ 
       $sql  .= $virgula." si83_multarescisoria = '$this->si83_multarescisoria' ";
       $virgula = ",";
     }
     if(trim($this->si83_multainadimplemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_multainadimplemento"])){ 
       $sql  .= $virgula." si83_multainadimplemento = '$this->si83_multainadimplemento' ";
       $virgula = ",";
     }
     if(trim($this->si83_garantia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_garantia"])){ 
        if(trim($this->si83_garantia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si83_garantia"])){ 
           $this->si83_garantia = "0" ; 
        } 
       $sql  .= $virgula." si83_garantia = $this->si83_garantia ";
       $virgula = ",";
     }
     if(trim($this->si83_cpfsignatariocontratante)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_cpfsignatariocontratante"])){ 
       $sql  .= $virgula." si83_cpfsignatariocontratante = '$this->si83_cpfsignatariocontratante' ";
       $virgula = ",";
     }
     if(trim($this->si83_datapublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_datapublicacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si83_datapublicacao_dia"] !="") ){ 
       $sql  .= $virgula." si83_datapublicacao = '$this->si83_datapublicacao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si83_datapublicacao_dia"])){ 
         $sql  .= $virgula." si83_datapublicacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si83_veiculodivulgacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_veiculodivulgacao"])){ 
       $sql  .= $virgula." si83_veiculodivulgacao = '$this->si83_veiculodivulgacao' ";
       $virgula = ",";
     }
     if(trim($this->si83_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_mes"])){ 
       $sql  .= $virgula." si83_mes = $this->si83_mes ";
       $virgula = ",";
       if(trim($this->si83_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si83_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si83_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si83_instit"])){ 
       $sql  .= $virgula." si83_instit = $this->si83_instit ";
       $virgula = ",";
       if(trim($this->si83_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si83_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si83_sequencial!=null){
       $sql .= " si83_sequencial = $this->si83_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si83_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010399,'$this->si83_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_sequencial"]) || $this->si83_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010399,'".AddSlashes(pg_result($resaco,$conresaco,'si83_sequencial'))."','$this->si83_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_tiporegistro"]) || $this->si83_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010400,'".AddSlashes(pg_result($resaco,$conresaco,'si83_tiporegistro'))."','$this->si83_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_codcontrato"]) || $this->si83_codcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010401,'".AddSlashes(pg_result($resaco,$conresaco,'si83_codcontrato'))."','$this->si83_codcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_codorgao"]) || $this->si83_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010402,'".AddSlashes(pg_result($resaco,$conresaco,'si83_codorgao'))."','$this->si83_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_codunidadesub"]) || $this->si83_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010403,'".AddSlashes(pg_result($resaco,$conresaco,'si83_codunidadesub'))."','$this->si83_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_nrocontrato"]) || $this->si83_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010404,'".AddSlashes(pg_result($resaco,$conresaco,'si83_nrocontrato'))."','$this->si83_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_exerciciocontrato"]) || $this->si83_exerciciocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2011317,'".AddSlashes(pg_result($resaco,$conresaco,'si83_exerciciocontrato'))."','$this->si83_exerciciocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_dataassinatura"]) || $this->si83_dataassinatura != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010405,'".AddSlashes(pg_result($resaco,$conresaco,'si83_dataassinatura'))."','$this->si83_dataassinatura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_contdeclicitacao"]) || $this->si83_contdeclicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010406,'".AddSlashes(pg_result($resaco,$conresaco,'si83_contdeclicitacao'))."','$this->si83_contdeclicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_codorgaoresp"]) || $this->si83_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010407,'".AddSlashes(pg_result($resaco,$conresaco,'si83_codorgaoresp'))."','$this->si83_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_codunidadesubresp"]) || $this->si83_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010408,'".AddSlashes(pg_result($resaco,$conresaco,'si83_codunidadesubresp'))."','$this->si83_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_nroprocesso"]) || $this->si83_nroprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010409,'".AddSlashes(pg_result($resaco,$conresaco,'si83_nroprocesso'))."','$this->si83_nroprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_exercicioprocesso"]) || $this->si83_exercicioprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010410,'".AddSlashes(pg_result($resaco,$conresaco,'si83_exercicioprocesso'))."','$this->si83_exercicioprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_tipoprocesso"]) || $this->si83_tipoprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2011318,'".AddSlashes(pg_result($resaco,$conresaco,'si83_tipoprocesso'))."','$this->si83_tipoprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_naturezaobjeto"]) || $this->si83_naturezaobjeto != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010411,'".AddSlashes(pg_result($resaco,$conresaco,'si83_naturezaobjeto'))."','$this->si83_naturezaobjeto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_objetocontrato"]) || $this->si83_objetocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010412,'".AddSlashes(pg_result($resaco,$conresaco,'si83_objetocontrato'))."','$this->si83_objetocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_tipoinstrumento"]) || $this->si83_tipoinstrumento != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010413,'".AddSlashes(pg_result($resaco,$conresaco,'si83_tipoinstrumento'))."','$this->si83_tipoinstrumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_datainiciovigencia"]) || $this->si83_datainiciovigencia != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010414,'".AddSlashes(pg_result($resaco,$conresaco,'si83_datainiciovigencia'))."','$this->si83_datainiciovigencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_datafinalvigencia"]) || $this->si83_datafinalvigencia != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010415,'".AddSlashes(pg_result($resaco,$conresaco,'si83_datafinalvigencia'))."','$this->si83_datafinalvigencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_vlcontrato"]) || $this->si83_vlcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010416,'".AddSlashes(pg_result($resaco,$conresaco,'si83_vlcontrato'))."','$this->si83_vlcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_formafornecimento"]) || $this->si83_formafornecimento != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010417,'".AddSlashes(pg_result($resaco,$conresaco,'si83_formafornecimento'))."','$this->si83_formafornecimento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_formapagamento"]) || $this->si83_formapagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010418,'".AddSlashes(pg_result($resaco,$conresaco,'si83_formapagamento'))."','$this->si83_formapagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_prazoexecucao"]) || $this->si83_prazoexecucao != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010419,'".AddSlashes(pg_result($resaco,$conresaco,'si83_prazoexecucao'))."','$this->si83_prazoexecucao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_multarescisoria"]) || $this->si83_multarescisoria != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010420,'".AddSlashes(pg_result($resaco,$conresaco,'si83_multarescisoria'))."','$this->si83_multarescisoria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_multainadimplemento"]) || $this->si83_multainadimplemento != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010421,'".AddSlashes(pg_result($resaco,$conresaco,'si83_multainadimplemento'))."','$this->si83_multainadimplemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_garantia"]) || $this->si83_garantia != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010422,'".AddSlashes(pg_result($resaco,$conresaco,'si83_garantia'))."','$this->si83_garantia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_cpfsignatariocontratante"]) || $this->si83_cpfsignatariocontratante != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010423,'".AddSlashes(pg_result($resaco,$conresaco,'si83_cpfsignatariocontratante'))."','$this->si83_cpfsignatariocontratante',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_datapublicacao"]) || $this->si83_datapublicacao != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010424,'".AddSlashes(pg_result($resaco,$conresaco,'si83_datapublicacao'))."','$this->si83_datapublicacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_veiculodivulgacao"]) || $this->si83_veiculodivulgacao != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010425,'".AddSlashes(pg_result($resaco,$conresaco,'si83_veiculodivulgacao'))."','$this->si83_veiculodivulgacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_mes"]) || $this->si83_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2010426,'".AddSlashes(pg_result($resaco,$conresaco,'si83_mes'))."','$this->si83_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si83_instit"]) || $this->si83_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010312,2011596,'".AddSlashes(pg_result($resaco,$conresaco,'si83_instit'))."','$this->si83_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos102017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si83_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos102017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si83_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si83_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si83_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si83_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010399,'$si83_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010312,2010399,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010400,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010401,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010402,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010403,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010404,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2011317,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_exerciciocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010405,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010406,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_contdeclicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010407,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010408,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010409,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010410,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2011318,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010411,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_naturezaobjeto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010412,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_objetocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010413,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_tipoinstrumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010414,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_datainiciovigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010415,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010416,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_vlcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010417,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_formafornecimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010418,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_formapagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010419,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_prazoexecucao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010420,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_multarescisoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010421,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_multainadimplemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010422,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_garantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010423,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_cpfsignatariocontratante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010424,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010425,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2010426,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010312,2011596,'','".AddSlashes(pg_result($resaco,$iresaco,'si83_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos102017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si83_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si83_sequencial = $si83_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos102017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si83_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos102017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si83_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si83_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:contratos102017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si83_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos102017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si83_sequencial!=null ){
         $sql2 .= " where contratos102017.si83_sequencial = $si83_sequencial "; 
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
   function sql_query_file ( $si83_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos102017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si83_sequencial!=null ){
         $sql2 .= " where contratos102017.si83_sequencial = $si83_sequencial "; 
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
