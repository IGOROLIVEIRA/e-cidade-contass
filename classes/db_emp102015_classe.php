<?
//MODULO: sicom
//CLASSE DA ENTIDADE emp102015
class cl_emp102015 { 
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
   var $si106_sequencial = 0; 
   var $si106_tiporegistro = 0; 
   var $si106_codorgao = null; 
   var $si106_codunidadesub = null; 
   var $si106_codfuncao = null; 
   var $si106_codsubfuncao = null; 
   var $si106_codprograma = null; 
   var $si106_idacao = null; 
   var $si106_idsubacao = null; 
   var $si106_naturezadespesa = 0; 
   var $si106_subelemento = null; 
   var $si106_nroempenho = 0; 
   var $si106_dtempenho_dia = null; 
   var $si106_dtempenho_mes = null; 
   var $si106_dtempenho_ano = null; 
   var $si106_dtempenho = null; 
   var $si106_modalidadeempenho = 0; 
   var $si106_tpempenho = null; 
   var $si106_vlbruto = 0; 
   var $si106_especificacaoempenho = null; 
   var $si106_despdeccontrato = 0; 
   var $si106_codorgaorespcontrato = null; 
   var $si106_codunidadesubrespcontrato = null; 
   var $si106_nrocontrato = 0; 
   var $si106_dtassinaturacontrato_dia = null; 
   var $si106_dtassinaturacontrato_mes = null; 
   var $si106_dtassinaturacontrato_ano = null; 
   var $si106_dtassinaturacontrato = null; 
   var $si106_nrosequencialtermoaditivo = null; 
   var $si106_despdecconvenio = 0; 
   var $si106_nroconvenio = null; 
   var $si106_dataassinaturaconvenio_dia = null; 
   var $si106_dataassinaturaconvenio_mes = null; 
   var $si106_dataassinaturaconvenio_ano = null; 
   var $si106_dataassinaturaconvenio = null; 
   var $si106_despdeclicitacao = 0; 
   var $si106_codorgaoresplicit = null; 
   var $si106_codunidadesubresplicit = null; 
   var $si106_nroprocessolicitatorio = null; 
   var $si106_exercicioprocessolicitatorio = 0; 
   var $si106_tipoprocesso = 0; 
   var $si106_cpfordenador = null; 
   var $si106_mes = 0; 
   var $si106_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si106_sequencial = int8 = sequencial 
                 si106_tiporegistro = int8 = Tipo do  registro 
                 si106_codorgao = varchar(2) = Código do órgão 
                 si106_codunidadesub = varchar(8) = Código da unidade 
                 si106_codfuncao = varchar(2) = Código da função 
                 si106_codsubfuncao = varchar(3) = Código da  Subfunção 
                 si106_codprograma = varchar(4) = Código do  programa 
                 si106_idacao = varchar(4) = Código que  identifica a Ação 
                 si106_idsubacao = varchar(4) = Código que  identifica SubAção 
                 si106_naturezadespesa = int8 = Código da   natureza da despesa 
                 si106_subelemento = varchar(2) = Subelemento da  despesa 
                 si106_nroempenho = int8 = Número do  empenho 
                 si106_dtempenho = date = Data do empenho 
                 si106_modalidadeempenho = int8 = Modalidade do  empenho 
                 si106_tpempenho = varchar(2) = Tipo do empenho 
                 si106_vlbruto = float8 = Valor Bruto  Empenhado 
                 si106_especificacaoempenho = varchar(200) = Especificação do  empenho 
                 si106_despdeccontrato = int8 = Despesa  decorrente de  contrato 
                 si106_codorgaorespcontrato = varchar(2) = Código do Órgão que firmou contrato 
                 si106_codunidadesubrespcontrato = varchar(8) = Código da unidade 
                 si106_nrocontrato = int8 = Número do  Contrato 
                 si106_dtassinaturacontrato = date = Data da assinatura  do Contrato 
                 si106_nrosequencialtermoaditivo = varchar(2) = Número sequencial do Termo Aditivo 
                 si106_despdecconvenio = int8 = Despesa  decorrente de convênio 
                 si106_nroconvenio = varchar(30) = Número do  Convênio 
                 si106_dataassinaturaconvenio = date = Data da assinatura do Convênio 
                 si106_despdeclicitacao = int8 = Despesa decorrente de Licitação 
                 si106_codorgaoresplicit = varchar(2) = Código do órgão  responsável 
                 si106_codunidadesubresplicit = varchar(8) = Código da unidade 
                 si106_nroprocessolicitatorio = varchar(12) = Número do  processo  licitatório 
                 si106_exercicioprocessolicitatorio = int8 = Exercício do  processo  licitatório 
                 si106_tipoprocesso = int8 = Tipo de processo 
                 si106_cpfordenador = varchar(11) = Número do CPF 
                 si106_mes = int8 = Mês 
                 si106_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_emp102015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("emp102015"); 
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
       $this->si106_sequencial = ($this->si106_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_sequencial"]:$this->si106_sequencial);
       $this->si106_tiporegistro = ($this->si106_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_tiporegistro"]:$this->si106_tiporegistro);
       $this->si106_codorgao = ($this->si106_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codorgao"]:$this->si106_codorgao);
       $this->si106_codunidadesub = ($this->si106_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codunidadesub"]:$this->si106_codunidadesub);
       $this->si106_codfuncao = ($this->si106_codfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codfuncao"]:$this->si106_codfuncao);
       $this->si106_codsubfuncao = ($this->si106_codsubfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codsubfuncao"]:$this->si106_codsubfuncao);
       $this->si106_codprograma = ($this->si106_codprograma == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codprograma"]:$this->si106_codprograma);
       $this->si106_idacao = ($this->si106_idacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_idacao"]:$this->si106_idacao);
       $this->si106_idsubacao = ($this->si106_idsubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_idsubacao"]:$this->si106_idsubacao);
       $this->si106_naturezadespesa = ($this->si106_naturezadespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_naturezadespesa"]:$this->si106_naturezadespesa);
       $this->si106_subelemento = ($this->si106_subelemento == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_subelemento"]:$this->si106_subelemento);
       $this->si106_nroempenho = ($this->si106_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_nroempenho"]:$this->si106_nroempenho);
       if($this->si106_dtempenho == ""){
         $this->si106_dtempenho_dia = ($this->si106_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dtempenho_dia"]:$this->si106_dtempenho_dia);
         $this->si106_dtempenho_mes = ($this->si106_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dtempenho_mes"]:$this->si106_dtempenho_mes);
         $this->si106_dtempenho_ano = ($this->si106_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dtempenho_ano"]:$this->si106_dtempenho_ano);
         if($this->si106_dtempenho_dia != ""){
            $this->si106_dtempenho = $this->si106_dtempenho_ano."-".$this->si106_dtempenho_mes."-".$this->si106_dtempenho_dia;
         }
       }
       $this->si106_modalidadeempenho = ($this->si106_modalidadeempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_modalidadeempenho"]:$this->si106_modalidadeempenho);
       $this->si106_tpempenho = ($this->si106_tpempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_tpempenho"]:$this->si106_tpempenho);
       $this->si106_vlbruto = ($this->si106_vlbruto == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_vlbruto"]:$this->si106_vlbruto);
       $this->si106_especificacaoempenho = ($this->si106_especificacaoempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_especificacaoempenho"]:$this->si106_especificacaoempenho);
       $this->si106_despdeccontrato = ($this->si106_despdeccontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_despdeccontrato"]:$this->si106_despdeccontrato);
       $this->si106_codorgaorespcontrato = ($this->si106_codorgaorespcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codorgaorespcontrato"]:$this->si106_codorgaorespcontrato);
       $this->si106_codunidadesubrespcontrato = ($this->si106_codunidadesubrespcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codunidadesubrespcontrato"]:$this->si106_codunidadesubrespcontrato);
       $this->si106_nrocontrato = ($this->si106_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_nrocontrato"]:$this->si106_nrocontrato);
       if($this->si106_dtassinaturacontrato == ""){
         $this->si106_dtassinaturacontrato_dia = ($this->si106_dtassinaturacontrato_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dtassinaturacontrato_dia"]:$this->si106_dtassinaturacontrato_dia);
         $this->si106_dtassinaturacontrato_mes = ($this->si106_dtassinaturacontrato_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dtassinaturacontrato_mes"]:$this->si106_dtassinaturacontrato_mes);
         $this->si106_dtassinaturacontrato_ano = ($this->si106_dtassinaturacontrato_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dtassinaturacontrato_ano"]:$this->si106_dtassinaturacontrato_ano);
         if($this->si106_dtassinaturacontrato_dia != ""){
            $this->si106_dtassinaturacontrato = $this->si106_dtassinaturacontrato_ano."-".$this->si106_dtassinaturacontrato_mes."-".$this->si106_dtassinaturacontrato_dia;
         }
       }
       $this->si106_nrosequencialtermoaditivo = ($this->si106_nrosequencialtermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_nrosequencialtermoaditivo"]:$this->si106_nrosequencialtermoaditivo);
       $this->si106_despdecconvenio = ($this->si106_despdecconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_despdecconvenio"]:$this->si106_despdecconvenio);
       $this->si106_nroconvenio = ($this->si106_nroconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_nroconvenio"]:$this->si106_nroconvenio);
       if($this->si106_dataassinaturaconvenio == ""){
         $this->si106_dataassinaturaconvenio_dia = ($this->si106_dataassinaturaconvenio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dataassinaturaconvenio_dia"]:$this->si106_dataassinaturaconvenio_dia);
         $this->si106_dataassinaturaconvenio_mes = ($this->si106_dataassinaturaconvenio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dataassinaturaconvenio_mes"]:$this->si106_dataassinaturaconvenio_mes);
         $this->si106_dataassinaturaconvenio_ano = ($this->si106_dataassinaturaconvenio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_dataassinaturaconvenio_ano"]:$this->si106_dataassinaturaconvenio_ano);
         if($this->si106_dataassinaturaconvenio_dia != ""){
            $this->si106_dataassinaturaconvenio = $this->si106_dataassinaturaconvenio_ano."-".$this->si106_dataassinaturaconvenio_mes."-".$this->si106_dataassinaturaconvenio_dia;
         }
       }
       $this->si106_despdeclicitacao = ($this->si106_despdeclicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_despdeclicitacao"]:$this->si106_despdeclicitacao);
       $this->si106_codorgaoresplicit = ($this->si106_codorgaoresplicit == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codorgaoresplicit"]:$this->si106_codorgaoresplicit);
       $this->si106_codunidadesubresplicit = ($this->si106_codunidadesubresplicit == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_codunidadesubresplicit"]:$this->si106_codunidadesubresplicit);
       $this->si106_nroprocessolicitatorio = ($this->si106_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_nroprocessolicitatorio"]:$this->si106_nroprocessolicitatorio);
       $this->si106_exercicioprocessolicitatorio = ($this->si106_exercicioprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_exercicioprocessolicitatorio"]:$this->si106_exercicioprocessolicitatorio);
       $this->si106_tipoprocesso = ($this->si106_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_tipoprocesso"]:$this->si106_tipoprocesso);
       $this->si106_cpfordenador = ($this->si106_cpfordenador == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_cpfordenador"]:$this->si106_cpfordenador);
       $this->si106_mes = ($this->si106_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_mes"]:$this->si106_mes);
       $this->si106_instit = ($this->si106_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_instit"]:$this->si106_instit);
     }else{
       $this->si106_sequencial = ($this->si106_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si106_sequencial"]:$this->si106_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si106_sequencial){ 
      $this->atualizacampos();
     if($this->si106_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si106_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si106_naturezadespesa == null ){ 
       $this->si106_naturezadespesa = "0";
     }
     if($this->si106_nroempenho == null ){ 
       $this->si106_nroempenho = "0";
     }
     if($this->si106_dtempenho == null ){ 
       $this->si106_dtempenho = "null";
     }
     if($this->si106_modalidadeempenho == null ){ 
       $this->si106_modalidadeempenho = "0";
     }
     if($this->si106_vlbruto == null ){ 
       $this->si106_vlbruto = "0";
     }
     if($this->si106_despdeccontrato == null ){ 
       $this->si106_despdeccontrato = "0";
     }
     if($this->si106_nrocontrato == null ){ 
       $this->si106_nrocontrato = "0";
     }
     if($this->si106_dtassinaturacontrato == null ){ 
       $this->si106_dtassinaturacontrato = "null";
     }
     if($this->si106_despdecconvenio == null ){ 
       $this->si106_despdecconvenio = "0";
     }
     if($this->si106_dataassinaturaconvenio == null ){ 
       $this->si106_dataassinaturaconvenio = "null";
     }
     if($this->si106_despdeclicitacao == null ){ 
       $this->si106_despdeclicitacao = "0";
     }
     if($this->si106_exercicioprocessolicitatorio == null ){ 
       $this->si106_exercicioprocessolicitatorio = "0";
     }
     if($this->si106_tipoprocesso == null ){ 
       $this->si106_tipoprocesso = "0";
     }
     if($this->si106_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si106_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si106_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si106_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si106_sequencial == "" || $si106_sequencial == null ){
       $result = db_query("select nextval('emp102015_si106_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: emp102015_si106_sequencial_seq do campo: si106_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si106_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from emp102015_si106_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si106_sequencial)){
         $this->erro_sql = " Campo si106_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si106_sequencial = $si106_sequencial; 
       }
     }
     if(($this->si106_sequencial == null) || ($this->si106_sequencial == "") ){ 
       $this->erro_sql = " Campo si106_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into emp102015(
                                       si106_sequencial 
                                      ,si106_tiporegistro 
                                      ,si106_codorgao 
                                      ,si106_codunidadesub 
                                      ,si106_codfuncao 
                                      ,si106_codsubfuncao 
                                      ,si106_codprograma 
                                      ,si106_idacao 
                                      ,si106_idsubacao 
                                      ,si106_naturezadespesa 
                                      ,si106_subelemento 
                                      ,si106_nroempenho 
                                      ,si106_dtempenho 
                                      ,si106_modalidadeempenho 
                                      ,si106_tpempenho 
                                      ,si106_vlbruto 
                                      ,si106_especificacaoempenho 
                                      ,si106_despdeccontrato 
                                      ,si106_codorgaorespcontrato 
                                      ,si106_codunidadesubrespcontrato 
                                      ,si106_nrocontrato 
                                      ,si106_dtassinaturacontrato 
                                      ,si106_nrosequencialtermoaditivo 
                                      ,si106_despdecconvenio 
                                      ,si106_nroconvenio 
                                      ,si106_dataassinaturaconvenio 
                                      ,si106_despdeclicitacao 
                                      ,si106_codorgaoresplicit 
                                      ,si106_codunidadesubresplicit 
                                      ,si106_nroprocessolicitatorio 
                                      ,si106_exercicioprocessolicitatorio 
                                      ,si106_tipoprocesso 
                                      ,si106_cpfordenador 
                                      ,si106_mes 
                                      ,si106_instit 
                       )
                values (
                                $this->si106_sequencial 
                               ,$this->si106_tiporegistro 
                               ,'$this->si106_codorgao' 
                               ,'$this->si106_codunidadesub' 
                               ,'$this->si106_codfuncao' 
                               ,'$this->si106_codsubfuncao' 
                               ,'$this->si106_codprograma' 
                               ,'$this->si106_idacao' 
                               ,'$this->si106_idsubacao' 
                               ,$this->si106_naturezadespesa 
                               ,'$this->si106_subelemento' 
                               ,$this->si106_nroempenho 
                               ,".($this->si106_dtempenho == "null" || $this->si106_dtempenho == ""?"null":"'".$this->si106_dtempenho."'")." 
                               ,$this->si106_modalidadeempenho 
                               ,'$this->si106_tpempenho' 
                               ,$this->si106_vlbruto 
                               ,'$this->si106_especificacaoempenho' 
                               ,$this->si106_despdeccontrato 
                               ,'$this->si106_codorgaorespcontrato' 
                               ,'$this->si106_codunidadesubrespcontrato' 
                               ,$this->si106_nrocontrato 
                               ,".($this->si106_dtassinaturacontrato == "null" || $this->si106_dtassinaturacontrato == ""?"null":"'".$this->si106_dtassinaturacontrato."'")." 
                               ,'$this->si106_nrosequencialtermoaditivo' 
                               ,$this->si106_despdecconvenio 
                               ,'$this->si106_nroconvenio' 
                               ,".($this->si106_dataassinaturaconvenio == "null" || $this->si106_dataassinaturaconvenio == ""?"null":"'".$this->si106_dataassinaturaconvenio."'")." 
                               ,$this->si106_despdeclicitacao 
                               ,'$this->si106_codorgaoresplicit' 
                               ,'$this->si106_codunidadesubresplicit' 
                               ,'$this->si106_nroprocessolicitatorio' 
                               ,$this->si106_exercicioprocessolicitatorio 
                               ,$this->si106_tipoprocesso 
                               ,'$this->si106_cpfordenador' 
                               ,$this->si106_mes 
                               ,$this->si106_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "emp102015 ($this->si106_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "emp102015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "emp102015 ($this->si106_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si106_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si106_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010641,'$this->si106_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010335,2010641,'','".AddSlashes(pg_result($resaco,0,'si106_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010642,'','".AddSlashes(pg_result($resaco,0,'si106_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010643,'','".AddSlashes(pg_result($resaco,0,'si106_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010644,'','".AddSlashes(pg_result($resaco,0,'si106_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010645,'','".AddSlashes(pg_result($resaco,0,'si106_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010646,'','".AddSlashes(pg_result($resaco,0,'si106_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010647,'','".AddSlashes(pg_result($resaco,0,'si106_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010648,'','".AddSlashes(pg_result($resaco,0,'si106_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010649,'','".AddSlashes(pg_result($resaco,0,'si106_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010650,'','".AddSlashes(pg_result($resaco,0,'si106_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010651,'','".AddSlashes(pg_result($resaco,0,'si106_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010652,'','".AddSlashes(pg_result($resaco,0,'si106_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010653,'','".AddSlashes(pg_result($resaco,0,'si106_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010654,'','".AddSlashes(pg_result($resaco,0,'si106_modalidadeempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010655,'','".AddSlashes(pg_result($resaco,0,'si106_tpempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010656,'','".AddSlashes(pg_result($resaco,0,'si106_vlbruto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010657,'','".AddSlashes(pg_result($resaco,0,'si106_especificacaoempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010658,'','".AddSlashes(pg_result($resaco,0,'si106_despdeccontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010659,'','".AddSlashes(pg_result($resaco,0,'si106_codorgaorespcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010660,'','".AddSlashes(pg_result($resaco,0,'si106_codunidadesubrespcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010661,'','".AddSlashes(pg_result($resaco,0,'si106_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010662,'','".AddSlashes(pg_result($resaco,0,'si106_dtassinaturacontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010663,'','".AddSlashes(pg_result($resaco,0,'si106_nrosequencialtermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010664,'','".AddSlashes(pg_result($resaco,0,'si106_despdecconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010665,'','".AddSlashes(pg_result($resaco,0,'si106_nroconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010666,'','".AddSlashes(pg_result($resaco,0,'si106_dataassinaturaconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010667,'','".AddSlashes(pg_result($resaco,0,'si106_despdeclicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010668,'','".AddSlashes(pg_result($resaco,0,'si106_codorgaoresplicit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010669,'','".AddSlashes(pg_result($resaco,0,'si106_codunidadesubresplicit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010670,'','".AddSlashes(pg_result($resaco,0,'si106_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010671,'','".AddSlashes(pg_result($resaco,0,'si106_exercicioprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2011328,'','".AddSlashes(pg_result($resaco,0,'si106_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010672,'','".AddSlashes(pg_result($resaco,0,'si106_cpfordenador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2010673,'','".AddSlashes(pg_result($resaco,0,'si106_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010335,2011619,'','".AddSlashes(pg_result($resaco,0,'si106_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si106_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update emp102015 set ";
     $virgula = "";
     if(trim($this->si106_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_sequencial"])){ 
        if(trim($this->si106_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_sequencial"])){ 
           $this->si106_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si106_sequencial = $this->si106_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si106_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_tiporegistro"])){ 
       $sql  .= $virgula." si106_tiporegistro = $this->si106_tiporegistro ";
       $virgula = ",";
       if(trim($this->si106_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si106_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si106_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codorgao"])){ 
       $sql  .= $virgula." si106_codorgao = '$this->si106_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si106_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codunidadesub"])){ 
       $sql  .= $virgula." si106_codunidadesub = '$this->si106_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si106_codfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codfuncao"])){ 
       $sql  .= $virgula." si106_codfuncao = '$this->si106_codfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si106_codsubfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codsubfuncao"])){ 
       $sql  .= $virgula." si106_codsubfuncao = '$this->si106_codsubfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si106_codprograma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codprograma"])){ 
       $sql  .= $virgula." si106_codprograma = '$this->si106_codprograma' ";
       $virgula = ",";
     }
     if(trim($this->si106_idacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_idacao"])){ 
       $sql  .= $virgula." si106_idacao = '$this->si106_idacao' ";
       $virgula = ",";
     }
     if(trim($this->si106_idsubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_idsubacao"])){ 
       $sql  .= $virgula." si106_idsubacao = '$this->si106_idsubacao' ";
       $virgula = ",";
     }
     if(trim($this->si106_naturezadespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_naturezadespesa"])){ 
        if(trim($this->si106_naturezadespesa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_naturezadespesa"])){ 
           $this->si106_naturezadespesa = "0" ; 
        } 
       $sql  .= $virgula." si106_naturezadespesa = $this->si106_naturezadespesa ";
       $virgula = ",";
     }
     if(trim($this->si106_subelemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_subelemento"])){ 
       $sql  .= $virgula." si106_subelemento = '$this->si106_subelemento' ";
       $virgula = ",";
     }
     if(trim($this->si106_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_nroempenho"])){ 
        if(trim($this->si106_nroempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_nroempenho"])){ 
           $this->si106_nroempenho = "0" ; 
        } 
       $sql  .= $virgula." si106_nroempenho = $this->si106_nroempenho ";
       $virgula = ",";
     }
     if(trim($this->si106_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si106_dtempenho_dia"] !="") ){ 
       $sql  .= $virgula." si106_dtempenho = '$this->si106_dtempenho' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si106_dtempenho_dia"])){ 
         $sql  .= $virgula." si106_dtempenho = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si106_modalidadeempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_modalidadeempenho"])){ 
        if(trim($this->si106_modalidadeempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_modalidadeempenho"])){ 
           $this->si106_modalidadeempenho = "0" ; 
        } 
       $sql  .= $virgula." si106_modalidadeempenho = $this->si106_modalidadeempenho ";
       $virgula = ",";
     }
     if(trim($this->si106_tpempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_tpempenho"])){ 
       $sql  .= $virgula." si106_tpempenho = '$this->si106_tpempenho' ";
       $virgula = ",";
     }
     if(trim($this->si106_vlbruto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_vlbruto"])){ 
        if(trim($this->si106_vlbruto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_vlbruto"])){ 
           $this->si106_vlbruto = "0" ; 
        } 
       $sql  .= $virgula." si106_vlbruto = $this->si106_vlbruto ";
       $virgula = ",";
     }
     if(trim($this->si106_especificacaoempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_especificacaoempenho"])){ 
       $sql  .= $virgula." si106_especificacaoempenho = '$this->si106_especificacaoempenho' ";
       $virgula = ",";
     }
     if(trim($this->si106_despdeccontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_despdeccontrato"])){ 
        if(trim($this->si106_despdeccontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_despdeccontrato"])){ 
           $this->si106_despdeccontrato = "0" ; 
        } 
       $sql  .= $virgula." si106_despdeccontrato = $this->si106_despdeccontrato ";
       $virgula = ",";
     }
     if(trim($this->si106_codorgaorespcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codorgaorespcontrato"])){ 
       $sql  .= $virgula." si106_codorgaorespcontrato = '$this->si106_codorgaorespcontrato' ";
       $virgula = ",";
     }
     if(trim($this->si106_codunidadesubrespcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codunidadesubrespcontrato"])){ 
       $sql  .= $virgula." si106_codunidadesubrespcontrato = '$this->si106_codunidadesubrespcontrato' ";
       $virgula = ",";
     }
     if(trim($this->si106_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_nrocontrato"])){ 
        if(trim($this->si106_nrocontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_nrocontrato"])){ 
           $this->si106_nrocontrato = "0" ; 
        } 
       $sql  .= $virgula." si106_nrocontrato = $this->si106_nrocontrato ";
       $virgula = ",";
     }
     if(trim($this->si106_dtassinaturacontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_dtassinaturacontrato_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si106_dtassinaturacontrato_dia"] !="") ){ 
       $sql  .= $virgula." si106_dtassinaturacontrato = '$this->si106_dtassinaturacontrato' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si106_dtassinaturacontrato_dia"])){ 
         $sql  .= $virgula." si106_dtassinaturacontrato = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si106_nrosequencialtermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_nrosequencialtermoaditivo"])){ 
       $sql  .= $virgula." si106_nrosequencialtermoaditivo = '$this->si106_nrosequencialtermoaditivo' ";
       $virgula = ",";
     }
     if(trim($this->si106_despdecconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_despdecconvenio"])){ 
        if(trim($this->si106_despdecconvenio)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_despdecconvenio"])){ 
           $this->si106_despdecconvenio = "0" ; 
        } 
       $sql  .= $virgula." si106_despdecconvenio = $this->si106_despdecconvenio ";
       $virgula = ",";
     }
     if(trim($this->si106_nroconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_nroconvenio"])){ 
       $sql  .= $virgula." si106_nroconvenio = '$this->si106_nroconvenio' ";
       $virgula = ",";
     }
     if(trim($this->si106_dataassinaturaconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_dataassinaturaconvenio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si106_dataassinaturaconvenio_dia"] !="") ){ 
       $sql  .= $virgula." si106_dataassinaturaconvenio = '$this->si106_dataassinaturaconvenio' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si106_dataassinaturaconvenio_dia"])){ 
         $sql  .= $virgula." si106_dataassinaturaconvenio = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si106_despdeclicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_despdeclicitacao"])){ 
        if(trim($this->si106_despdeclicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_despdeclicitacao"])){ 
           $this->si106_despdeclicitacao = "0" ; 
        } 
       $sql  .= $virgula." si106_despdeclicitacao = $this->si106_despdeclicitacao ";
       $virgula = ",";
     }
     if(trim($this->si106_codorgaoresplicit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codorgaoresplicit"])){ 
       $sql  .= $virgula." si106_codorgaoresplicit = '$this->si106_codorgaoresplicit' ";
       $virgula = ",";
     }
     if(trim($this->si106_codunidadesubresplicit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_codunidadesubresplicit"])){ 
       $sql  .= $virgula." si106_codunidadesubresplicit = '$this->si106_codunidadesubresplicit' ";
       $virgula = ",";
     }
     if(trim($this->si106_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_nroprocessolicitatorio"])){ 
       $sql  .= $virgula." si106_nroprocessolicitatorio = '$this->si106_nroprocessolicitatorio' ";
       $virgula = ",";
     }
     if(trim($this->si106_exercicioprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_exercicioprocessolicitatorio"])){ 
        if(trim($this->si106_exercicioprocessolicitatorio)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_exercicioprocessolicitatorio"])){ 
           $this->si106_exercicioprocessolicitatorio = "0" ; 
        } 
       $sql  .= $virgula." si106_exercicioprocessolicitatorio = $this->si106_exercicioprocessolicitatorio ";
       $virgula = ",";
     }
     if(trim($this->si106_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_tipoprocesso"])){ 
        if(trim($this->si106_tipoprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si106_tipoprocesso"])){ 
           $this->si106_tipoprocesso = "0" ; 
        } 
       $sql  .= $virgula." si106_tipoprocesso = $this->si106_tipoprocesso ";
       $virgula = ",";
     }
     if(trim($this->si106_cpfordenador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_cpfordenador"])){ 
       $sql  .= $virgula." si106_cpfordenador = '$this->si106_cpfordenador' ";
       $virgula = ",";
     }
     if(trim($this->si106_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_mes"])){ 
       $sql  .= $virgula." si106_mes = $this->si106_mes ";
       $virgula = ",";
       if(trim($this->si106_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si106_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si106_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si106_instit"])){ 
       $sql  .= $virgula." si106_instit = $this->si106_instit ";
       $virgula = ",";
       if(trim($this->si106_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si106_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si106_sequencial!=null){
       $sql .= " si106_sequencial = $this->si106_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si106_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010641,'$this->si106_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_sequencial"]) || $this->si106_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010641,'".AddSlashes(pg_result($resaco,$conresaco,'si106_sequencial'))."','$this->si106_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_tiporegistro"]) || $this->si106_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010642,'".AddSlashes(pg_result($resaco,$conresaco,'si106_tiporegistro'))."','$this->si106_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codorgao"]) || $this->si106_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010643,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codorgao'))."','$this->si106_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codunidadesub"]) || $this->si106_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010644,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codunidadesub'))."','$this->si106_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codfuncao"]) || $this->si106_codfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010645,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codfuncao'))."','$this->si106_codfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codsubfuncao"]) || $this->si106_codsubfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010646,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codsubfuncao'))."','$this->si106_codsubfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codprograma"]) || $this->si106_codprograma != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010647,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codprograma'))."','$this->si106_codprograma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_idacao"]) || $this->si106_idacao != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010648,'".AddSlashes(pg_result($resaco,$conresaco,'si106_idacao'))."','$this->si106_idacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_idsubacao"]) || $this->si106_idsubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010649,'".AddSlashes(pg_result($resaco,$conresaco,'si106_idsubacao'))."','$this->si106_idsubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_naturezadespesa"]) || $this->si106_naturezadespesa != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010650,'".AddSlashes(pg_result($resaco,$conresaco,'si106_naturezadespesa'))."','$this->si106_naturezadespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_subelemento"]) || $this->si106_subelemento != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010651,'".AddSlashes(pg_result($resaco,$conresaco,'si106_subelemento'))."','$this->si106_subelemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_nroempenho"]) || $this->si106_nroempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010652,'".AddSlashes(pg_result($resaco,$conresaco,'si106_nroempenho'))."','$this->si106_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_dtempenho"]) || $this->si106_dtempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010653,'".AddSlashes(pg_result($resaco,$conresaco,'si106_dtempenho'))."','$this->si106_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_modalidadeempenho"]) || $this->si106_modalidadeempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010654,'".AddSlashes(pg_result($resaco,$conresaco,'si106_modalidadeempenho'))."','$this->si106_modalidadeempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_tpempenho"]) || $this->si106_tpempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010655,'".AddSlashes(pg_result($resaco,$conresaco,'si106_tpempenho'))."','$this->si106_tpempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_vlbruto"]) || $this->si106_vlbruto != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010656,'".AddSlashes(pg_result($resaco,$conresaco,'si106_vlbruto'))."','$this->si106_vlbruto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_especificacaoempenho"]) || $this->si106_especificacaoempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010657,'".AddSlashes(pg_result($resaco,$conresaco,'si106_especificacaoempenho'))."','$this->si106_especificacaoempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_despdeccontrato"]) || $this->si106_despdeccontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010658,'".AddSlashes(pg_result($resaco,$conresaco,'si106_despdeccontrato'))."','$this->si106_despdeccontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codorgaorespcontrato"]) || $this->si106_codorgaorespcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010659,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codorgaorespcontrato'))."','$this->si106_codorgaorespcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codunidadesubrespcontrato"]) || $this->si106_codunidadesubrespcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010660,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codunidadesubrespcontrato'))."','$this->si106_codunidadesubrespcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_nrocontrato"]) || $this->si106_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010661,'".AddSlashes(pg_result($resaco,$conresaco,'si106_nrocontrato'))."','$this->si106_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_dtassinaturacontrato"]) || $this->si106_dtassinaturacontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010662,'".AddSlashes(pg_result($resaco,$conresaco,'si106_dtassinaturacontrato'))."','$this->si106_dtassinaturacontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_nrosequencialtermoaditivo"]) || $this->si106_nrosequencialtermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010663,'".AddSlashes(pg_result($resaco,$conresaco,'si106_nrosequencialtermoaditivo'))."','$this->si106_nrosequencialtermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_despdecconvenio"]) || $this->si106_despdecconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010664,'".AddSlashes(pg_result($resaco,$conresaco,'si106_despdecconvenio'))."','$this->si106_despdecconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_nroconvenio"]) || $this->si106_nroconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010665,'".AddSlashes(pg_result($resaco,$conresaco,'si106_nroconvenio'))."','$this->si106_nroconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_dataassinaturaconvenio"]) || $this->si106_dataassinaturaconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010666,'".AddSlashes(pg_result($resaco,$conresaco,'si106_dataassinaturaconvenio'))."','$this->si106_dataassinaturaconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_despdeclicitacao"]) || $this->si106_despdeclicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010667,'".AddSlashes(pg_result($resaco,$conresaco,'si106_despdeclicitacao'))."','$this->si106_despdeclicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codorgaoresplicit"]) || $this->si106_codorgaoresplicit != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010668,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codorgaoresplicit'))."','$this->si106_codorgaoresplicit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_codunidadesubresplicit"]) || $this->si106_codunidadesubresplicit != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010669,'".AddSlashes(pg_result($resaco,$conresaco,'si106_codunidadesubresplicit'))."','$this->si106_codunidadesubresplicit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_nroprocessolicitatorio"]) || $this->si106_nroprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010670,'".AddSlashes(pg_result($resaco,$conresaco,'si106_nroprocessolicitatorio'))."','$this->si106_nroprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_exercicioprocessolicitatorio"]) || $this->si106_exercicioprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010671,'".AddSlashes(pg_result($resaco,$conresaco,'si106_exercicioprocessolicitatorio'))."','$this->si106_exercicioprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_tipoprocesso"]) || $this->si106_tipoprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2011328,'".AddSlashes(pg_result($resaco,$conresaco,'si106_tipoprocesso'))."','$this->si106_tipoprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_cpfordenador"]) || $this->si106_cpfordenador != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010672,'".AddSlashes(pg_result($resaco,$conresaco,'si106_cpfordenador'))."','$this->si106_cpfordenador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_mes"]) || $this->si106_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2010673,'".AddSlashes(pg_result($resaco,$conresaco,'si106_mes'))."','$this->si106_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si106_instit"]) || $this->si106_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010335,2011619,'".AddSlashes(pg_result($resaco,$conresaco,'si106_instit'))."','$this->si106_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "emp102015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si106_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "emp102015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si106_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si106_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si106_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si106_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010641,'$si106_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010335,2010641,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010642,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010643,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010644,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010645,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010646,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010647,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010648,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010649,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010650,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010651,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010652,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010653,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010654,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_modalidadeempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010655,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_tpempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010656,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_vlbruto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010657,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_especificacaoempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010658,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_despdeccontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010659,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codorgaorespcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010660,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codunidadesubrespcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010661,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010662,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_dtassinaturacontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010663,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_nrosequencialtermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010664,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_despdecconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010665,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_nroconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010666,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_dataassinaturaconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010667,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_despdeclicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010668,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codorgaoresplicit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010669,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_codunidadesubresplicit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010670,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010671,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_exercicioprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2011328,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010672,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_cpfordenador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2010673,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010335,2011619,'','".AddSlashes(pg_result($resaco,$iresaco,'si106_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from emp102015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si106_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si106_sequencial = $si106_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "emp102015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si106_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "emp102015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si106_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si106_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:emp102015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si106_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from emp102015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si106_sequencial!=null ){
         $sql2 .= " where emp102015.si106_sequencial = $si106_sequencial "; 
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
   function sql_query_file ( $si106_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from emp102015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si106_sequencial!=null ){
         $sql2 .= " where emp102015.si106_sequencial = $si106_sequencial "; 
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
