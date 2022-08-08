<?
include ("libs/db_sql.php");
require_once ("libs/db_utils.php");
include ("classes/db_pcorcamforne_classe.php");
include ("classes/db_pcorcamitem_classe.php");
include ("classes/db_pcorcamval_classe.php");

//MODULO: sicom
//CLASSE DA ENTIDADE contratos
class cl_contratos { 
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
   var $si172_sequencial = 0; 
   var $si172_nrocontrato = 0; 
   var $si172_exerciciocontrato = 0; 
   var $si172_licitacao = 0; 
   var $si172_dataassinatura_dia = null; 
   var $si172_dataassinatura_mes = null; 
   var $si172_dataassinatura_ano = null; 
   var $si172_dataassinatura = null; 
   var $si172_fornecedor = 0; 
   var $si172_contdeclicitacao = 0; 
   var $si172_codunidadesubresp = null; 
   var $si172_nroprocesso = null; 
   var $si172_exercicioprocesso = 0; 
   var $si172_tipoprocesso = 0; 
   var $si172_naturezaobjeto = 0; 
   var $si172_objetocontrato = null; 
   var $si172_tipoinstrumento = 0; 
   var $si172_datainiciovigencia_dia = null; 
   var $si172_datainiciovigencia_mes = null; 
   var $si172_datainiciovigencia_ano = null; 
   var $si172_datainiciovigencia = null; 
   var $si172_datafinalvigencia_dia = null; 
   var $si172_datafinalvigencia_mes = null; 
   var $si172_datafinalvigencia_ano = null; 
   var $si172_datafinalvigencia = null; 
   var $si172_vlcontrato = 0; 
   var $si172_formafornecimento = null; 
   var $si172_formapagamento = null; 
   var $si172_prazoexecucao = null; 
   var $si172_multarescisoria = null; 
   var $si172_multainadimplemento = null; 
   var $si172_garantia = 0; 
   var $si172_cpfsignatariocontratante = null; 
   var $si172_datapublicacao_dia = null; 
   var $si172_datapublicacao_mes = null; 
   var $si172_datapublicacao_ano = null; 
   var $si172_datapublicacao = null; 
   var $si172_veiculodivulgacao = null; 
   var $si172_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si172_sequencial = int8 = sequencial 
                 si172_nrocontrato = int8 = Número do  Contrato 
                 si172_exerciciocontrato = int8 = Exercício do Contrato 
                 si172_licitacao = int4 = Licitação 
                 si172_dataassinatura = date = Data da assinatura do Contrato 
                 si172_fornecedor = int8 = Fornecedor 
                 si172_contdeclicitacao = int8 = Contrato decorrente de Licitação 
                 si172_codunidadesubresp = varchar(8) = Departamento 
                 si172_nroprocesso = varchar(12) = Número do processo cadastrado 
                 si172_exercicioprocesso = int8 = Exercício do  processo 
                 si172_tipoprocesso = int8 = Tipo de processo 
                 si172_naturezaobjeto = int8 = Natureza do objeto 
                 si172_objetocontrato = text = Objeto do contrato 
                 si172_tipoinstrumento = int8 = Tipo de Instrumento 
                 si172_datainiciovigencia = date = Data inicial da vigência 
                 si172_datafinalvigencia = date = Data final da vigência 
                 si172_vlcontrato = float8 = Valor do contrato 
                 si172_formafornecimento = varchar(50) = Forma de fornecimento 
                 si172_formapagamento = varchar(100) = Forma de pagamento 
                 si172_prazoexecucao = varchar(100) = Prazo de Execução 
                 si172_multarescisoria = varchar(100) = Multa Rescisória 
                 si172_multainadimplemento = varchar(100) = Multa  inadimplemento 
                 si172_garantia = int8 = Tipo de garantia contratual 
                 si172_cpfsignatariocontratante = varchar(11) = Número do CPF do signatário 
                 si172_datapublicacao = date = Data da publicação do contrato 
                 si172_veiculodivulgacao = varchar(50) = Veículo de Divulgação 
                 si172_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_contratos() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos"); 
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
       $this->si172_sequencial = ($this->si172_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_sequencial"]:$this->si172_sequencial);
       $this->si172_nrocontrato = ($this->si172_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_nrocontrato"]:$this->si172_nrocontrato);
       $this->si172_exerciciocontrato = ($this->si172_exerciciocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_exerciciocontrato"]:$this->si172_exerciciocontrato);
       $this->si172_licitacao = ($this->si172_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_licitacao"]:$this->si172_licitacao);
       if($this->si172_dataassinatura == ""){
         $this->si172_dataassinatura_dia = ($this->si172_dataassinatura_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_dataassinatura_dia"]:$this->si172_dataassinatura_dia);
         $this->si172_dataassinatura_mes = ($this->si172_dataassinatura_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_dataassinatura_mes"]:$this->si172_dataassinatura_mes);
         $this->si172_dataassinatura_ano = ($this->si172_dataassinatura_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_dataassinatura_ano"]:$this->si172_dataassinatura_ano);
         if($this->si172_dataassinatura_dia != ""){
            $this->si172_dataassinatura = $this->si172_dataassinatura_ano."-".$this->si172_dataassinatura_mes."-".$this->si172_dataassinatura_dia;
         }
       }
       $this->si172_fornecedor = ($this->si172_fornecedor == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_fornecedor"]:$this->si172_fornecedor);
       $this->si172_contdeclicitacao = ($this->si172_contdeclicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_contdeclicitacao"]:$this->si172_contdeclicitacao);
       $this->si172_codunidadesubresp = ($this->si172_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_codunidadesubresp"]:$this->si172_codunidadesubresp);
       $this->si172_nroprocesso = ($this->si172_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_nroprocesso"]:$this->si172_nroprocesso);
       $this->si172_exercicioprocesso = ($this->si172_exercicioprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_exercicioprocesso"]:$this->si172_exercicioprocesso);
       $this->si172_tipoprocesso = ($this->si172_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_tipoprocesso"]:$this->si172_tipoprocesso);
       $this->si172_naturezaobjeto = ($this->si172_naturezaobjeto == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_naturezaobjeto"]:$this->si172_naturezaobjeto);
       $this->si172_objetocontrato = ($this->si172_objetocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_objetocontrato"]:$this->si172_objetocontrato);
       $this->si172_tipoinstrumento = ($this->si172_tipoinstrumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_tipoinstrumento"]:$this->si172_tipoinstrumento);
       if($this->si172_datainiciovigencia == ""){
         $this->si172_datainiciovigencia_dia = ($this->si172_datainiciovigencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datainiciovigencia_dia"]:$this->si172_datainiciovigencia_dia);
         $this->si172_datainiciovigencia_mes = ($this->si172_datainiciovigencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datainiciovigencia_mes"]:$this->si172_datainiciovigencia_mes);
         $this->si172_datainiciovigencia_ano = ($this->si172_datainiciovigencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datainiciovigencia_ano"]:$this->si172_datainiciovigencia_ano);
         if($this->si172_datainiciovigencia_dia != ""){
            $this->si172_datainiciovigencia = $this->si172_datainiciovigencia_ano."-".$this->si172_datainiciovigencia_mes."-".$this->si172_datainiciovigencia_dia;
         }
       }
       if($this->si172_datafinalvigencia == ""){
         $this->si172_datafinalvigencia_dia = ($this->si172_datafinalvigencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datafinalvigencia_dia"]:$this->si172_datafinalvigencia_dia);
         $this->si172_datafinalvigencia_mes = ($this->si172_datafinalvigencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datafinalvigencia_mes"]:$this->si172_datafinalvigencia_mes);
         $this->si172_datafinalvigencia_ano = ($this->si172_datafinalvigencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datafinalvigencia_ano"]:$this->si172_datafinalvigencia_ano);
         if($this->si172_datafinalvigencia_dia != ""){
            $this->si172_datafinalvigencia = $this->si172_datafinalvigencia_ano."-".$this->si172_datafinalvigencia_mes."-".$this->si172_datafinalvigencia_dia;
         }
       }
       $this->si172_vlcontrato = ($this->si172_vlcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_vlcontrato"]:$this->si172_vlcontrato);
       $this->si172_formafornecimento = ($this->si172_formafornecimento == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_formafornecimento"]:$this->si172_formafornecimento);
       $this->si172_formapagamento = ($this->si172_formapagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_formapagamento"]:$this->si172_formapagamento);
       $this->si172_prazoexecucao = ($this->si172_prazoexecucao == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_prazoexecucao"]:$this->si172_prazoexecucao);
       $this->si172_multarescisoria = ($this->si172_multarescisoria == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_multarescisoria"]:$this->si172_multarescisoria);
       $this->si172_multainadimplemento = ($this->si172_multainadimplemento == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_multainadimplemento"]:$this->si172_multainadimplemento);
       $this->si172_garantia = ($this->si172_garantia == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_garantia"]:$this->si172_garantia);
       $this->si172_cpfsignatariocontratante = ($this->si172_cpfsignatariocontratante == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_cpfsignatariocontratante"]:$this->si172_cpfsignatariocontratante);
       if($this->si172_datapublicacao == ""){
         $this->si172_datapublicacao_dia = ($this->si172_datapublicacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datapublicacao_dia"]:$this->si172_datapublicacao_dia);
         $this->si172_datapublicacao_mes = ($this->si172_datapublicacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datapublicacao_mes"]:$this->si172_datapublicacao_mes);
         $this->si172_datapublicacao_ano = ($this->si172_datapublicacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_datapublicacao_ano"]:$this->si172_datapublicacao_ano);
         if($this->si172_datapublicacao_dia != ""){
            $this->si172_datapublicacao = $this->si172_datapublicacao_ano."-".$this->si172_datapublicacao_mes."-".$this->si172_datapublicacao_dia;
         }
       }
       $this->si172_veiculodivulgacao = ($this->si172_veiculodivulgacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_veiculodivulgacao"]:$this->si172_veiculodivulgacao);
       $this->si172_instit = ($this->si172_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_instit"]:$this->si172_instit);
     }else{
       $this->si172_sequencial = ($this->si172_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si172_sequencial"]:$this->si172_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si172_sequencial){ 

      $this->atualizacampos();
     if($this->si172_nrocontrato == null ){ 
       $this->erro_sql = " Campo Número do  Contrato nao Informado.";
       $this->erro_campo = "si172_nrocontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si172_exerciciocontrato == null ){ 
       $this->erro_sql = " Campo Exercício do Contrato nao Informado.";
       $this->erro_campo = "si172_exerciciocontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     /*if($this->si172_licitacao == null ){ 
       $this->si172_licitacao = "0";
     }*/
     
     if($this->si172_dataassinatura == null ){ 
       $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
       $this->erro_campo = "si172_dataassinatura_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     /*if($this->si172_fornecedor == null ){ 
       $this->si172_fornecedor = "0";
     }*/
     if($this->si172_contdeclicitacao == null ){ 
       $this->erro_sql = " Campo Contrato decorrente de Licitação nao Informado.";
       $this->erro_campo = "si172_contdeclicitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     //echo $this->si172_nroprocesso;exit;
     if($this->si172_codunidadesubresp == null ){ 
       $this->erro_sql = " Campo Departamento nao Informado.";
       $this->erro_campo = "si172_codunidadesubresp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si172_nroprocesso == null ){
         if($this->si172_licitacao != "" && $this->si172_licitacao != null && $this->si172_licitacao != 0) {
           $this->erro_sql = " Campo Número do processo cadastrado nao Informado.";
           $this->erro_campo = "si172_nroprocesso";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
     }

       /*if($this->si172_exercicioprocesso == null ){
         $this->erro_sql = " Campo Exercício do  processo nao Informado.";
         $this->erro_campo = "si172_exercicioprocesso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }*/
     /*
     if($this->si172_nroprocesso == null ){ 
        $this->si172_nroprocesso = "0";
     }
     */
     if($this->si172_exercicioprocesso == null ){ 
        $this->si172_nroprocesso = "0";
     }
     
     if($this->si172_tipoprocesso == null ){ 
       $this->si172_tipoprocesso = "0";
     }

     if($this->si172_naturezaobjeto == null ){ 
       $this->erro_sql = " Campo Natureza do objeto nao Informado.";
       $this->erro_campo = "si172_naturezaobjeto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_objetocontrato == null ){ 
       $this->erro_sql = " Campo Objeto do contrato nao Informado.";
       $this->erro_campo = "si172_objetocontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_tipoinstrumento == null ){ 
       $this->erro_sql = " Campo Tipo de Instrumento nao Informado.";
       $this->erro_campo = "si172_tipoinstrumento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si172_datainiciovigencia == null ){ 
       $this->erro_sql = " Campo Data inicial da vigência nao Informado.";
       $this->erro_campo = "si172_datainiciovigencia_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_datafinalvigencia == null ){ 
       $this->erro_sql = " Campo Data final da vigência nao Informado.";
       $this->erro_campo = "si172_datafinalvigencia_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_vlcontrato == null ){ 
       $this->erro_sql = " Campo Valor do contrato nao Informado.";
       $this->erro_campo = "si172_vlcontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_garantia == null ){ 
       $this->si172_garantia = "0";
     }
     if($this->si172_cpfsignatariocontratante == null ){ 
       $this->erro_sql = " Campo Número do CPF do signatário nao Informado.";
       $this->erro_campo = "si172_cpfsignatariocontratante";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_datapublicacao == null ){ 
       $this->erro_sql = " Campo Data da publicação do contrato nao Informado.";
       $this->erro_campo = "si172_datapublicacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_veiculodivulgacao == null ){ 
       $this->erro_sql = " Campo Veículo de Divulgação nao Informado.";
       $this->erro_campo = "si172_veiculodivulgacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si172_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_formafornecimento == null && ($this->si172_naturezaobjeto != 4 || $this->si172_naturezaobjeto != 5)){ 
       $this->erro_sql = " Campo Forma de fornecimento nao Informado.";
       $this->erro_campo = "si172_formafornecimento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_formapagamento == null && ($this->si172_naturezaobjeto != 4 || $this->si172_naturezaobjeto != 5)){ 
       $this->erro_sql = " Campo Forma de pagamento nao Informado.";
       $this->erro_campo = "si172_formapagamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_prazoexecucao == null && ($this->si172_naturezaobjeto != 4 || $this->si172_naturezaobjeto != 5)){ 
       $this->erro_sql = " Campo Prazo de Execução nao Informado.";
       $this->erro_campo = "si172_prazoexecucao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_multarescisoria == null && ($this->si172_naturezaobjeto != 4 || $this->si172_naturezaobjeto != 5)){ 
       $this->erro_sql = " Campo Multa Rescisória nao Informado.";
       $this->erro_campo = "si172_multarescisoria";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si172_multainadimplemento == null && ($this->si172_naturezaobjeto != 4 || $this->si172_naturezaobjeto != 5)){ 
       $this->erro_sql = " Campo Multa inadimplemento nao Informado.";
       $this->erro_campo = "si172_multainadimplemento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si172_sequencial == "" || $si172_sequencial == null ){
       $result = db_query("select nextval('contratos_si172_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos_si172_sequencial_seq do campo: si172_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si172_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from contratos_si172_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si172_sequencial)){
         $this->erro_sql = " Campo si172_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si172_sequencial = $si172_sequencial; 
       }
     }
     if(($this->si172_sequencial == null) || ($this->si172_sequencial == "") ){ 
       $this->erro_sql = " Campo si172_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos(
                                       si172_sequencial 
                                      ,si172_nrocontrato 
                                      ,si172_exerciciocontrato 
                                      ,si172_licitacao 
                                      ,si172_dataassinatura 
                                      ,si172_fornecedor 
                                      ,si172_contdeclicitacao 
                                      ,si172_codunidadesubresp 
                                      ,si172_nroprocesso 
                                      ,si172_exercicioprocesso 
                                      ,si172_tipoprocesso 
                                      ,si172_naturezaobjeto 
                                      ,si172_objetocontrato 
                                      ,si172_tipoinstrumento 
                                      ,si172_datainiciovigencia 
                                      ,si172_datafinalvigencia 
                                      ,si172_vlcontrato 
                                      ,si172_formafornecimento 
                                      ,si172_formapagamento 
                                      ,si172_prazoexecucao 
                                      ,si172_multarescisoria 
                                      ,si172_multainadimplemento 
                                      ,si172_garantia 
                                      ,si172_cpfsignatariocontratante 
                                      ,si172_datapublicacao 
                                      ,si172_veiculodivulgacao 
                                      ,si172_instit 
                       )
                values (
                                $this->si172_sequencial 
                               ,$this->si172_nrocontrato 
                               ,$this->si172_exerciciocontrato 
                               ,".($this->si172_licitacao == "null" || $this->si172_licitacao == ""?"null":"'".$this->si172_licitacao."'")." 
                               ,".($this->si172_dataassinatura == "null" || $this->si172_dataassinatura == ""?"null":"'".$this->si172_dataassinatura."'")." 
                               ,".($this->si172_fornecedor == "null" || $this->si172_fornecedor == ""?"null":"'".$this->si172_fornecedor."'")." 
                               ,$this->si172_contdeclicitacao 
                               ,'$this->si172_codunidadesubresp' 
                               ,".($this->si172_nroprocesso == "null" || $this->si172_nroprocesso == ""?"null":"'".$this->si172_nroprocesso."'")." 
                               ,".($this->si172_exercicioprocesso == "null" || $this->si172_exercicioprocesso == ""?"null":"'".$this->si172_exercicioprocesso."'")." 
                               ,$this->si172_tipoprocesso 
                               ,$this->si172_naturezaobjeto 
                               ,'$this->si172_objetocontrato' 
                               ,$this->si172_tipoinstrumento 
                               ,".($this->si172_datainiciovigencia == "null" || $this->si172_datainiciovigencia == ""?"null":"'".$this->si172_datainiciovigencia."'")." 
                               ,".($this->si172_datafinalvigencia == "null" || $this->si172_datafinalvigencia == ""?"null":"'".$this->si172_datafinalvigencia."'")." 
                               ,$this->si172_vlcontrato 
                               ,'$this->si172_formafornecimento' 
                               ,'$this->si172_formapagamento' 
                               ,'$this->si172_prazoexecucao' 
                               ,'$this->si172_multarescisoria' 
                               ,'$this->si172_multainadimplemento' 
                               ,$this->si172_garantia 
                               ,'$this->si172_cpfsignatariocontratante' 
                               ,".($this->si172_datapublicacao == "null" || $this->si172_datapublicacao == ""?"null":"'".$this->si172_datapublicacao."'")." 
                               ,'$this->si172_veiculodivulgacao' 
                               ,$this->si172_instit 
                      )";
     
     $result = db_query($sql);
    
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos ($this->si172_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "contratos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "contratos ($this->si172_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si172_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si172_sequencial));
     
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011461,'$this->si172_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010406,2011461,'','".AddSlashes(pg_result($resaco,0,'si172_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011462,'','".AddSlashes(pg_result($resaco,0,'si172_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011463,'','".AddSlashes(pg_result($resaco,0,'si172_exerciciocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011487,'','".AddSlashes(pg_result($resaco,0,'si172_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011464,'','".AddSlashes(pg_result($resaco,0,'si172_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011465,'','".AddSlashes(pg_result($resaco,0,'si172_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011466,'','".AddSlashes(pg_result($resaco,0,'si172_contdeclicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011467,'','".AddSlashes(pg_result($resaco,0,'si172_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011468,'','".AddSlashes(pg_result($resaco,0,'si172_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011470,'','".AddSlashes(pg_result($resaco,0,'si172_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011471,'','".AddSlashes(pg_result($resaco,0,'si172_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011472,'','".AddSlashes(pg_result($resaco,0,'si172_naturezaobjeto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011473,'','".AddSlashes(pg_result($resaco,0,'si172_objetocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011474,'','".AddSlashes(pg_result($resaco,0,'si172_tipoinstrumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011475,'','".AddSlashes(pg_result($resaco,0,'si172_datainiciovigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011476,'','".AddSlashes(pg_result($resaco,0,'si172_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011477,'','".AddSlashes(pg_result($resaco,0,'si172_vlcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011478,'','".AddSlashes(pg_result($resaco,0,'si172_formafornecimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011479,'','".AddSlashes(pg_result($resaco,0,'si172_formapagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011480,'','".AddSlashes(pg_result($resaco,0,'si172_prazoexecucao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011481,'','".AddSlashes(pg_result($resaco,0,'si172_multarescisoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011482,'','".AddSlashes(pg_result($resaco,0,'si172_multainadimplemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011483,'','".AddSlashes(pg_result($resaco,0,'si172_garantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011484,'','".AddSlashes(pg_result($resaco,0,'si172_cpfsignatariocontratante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011485,'','".AddSlashes(pg_result($resaco,0,'si172_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011486,'','".AddSlashes(pg_result($resaco,0,'si172_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010406,2011488,'','".AddSlashes(pg_result($resaco,0,'si172_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si172_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update contratos set ";
     $virgula = "";
     if(trim($this->si172_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_sequencial"])){ 
       $sql  .= $virgula." si172_sequencial = $this->si172_sequencial ";
       $virgula = ",";
       if(trim($this->si172_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si172_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_nrocontrato"])){ 
       $sql  .= $virgula." si172_nrocontrato = $this->si172_nrocontrato ";
       $virgula = ",";
       if(trim($this->si172_nrocontrato) == null ){ 
         $this->erro_sql = " Campo Número do  Contrato nao Informado.";
         $this->erro_campo = "si172_nrocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_exerciciocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_exerciciocontrato"])){ 
       $sql  .= $virgula." si172_exerciciocontrato = $this->si172_exerciciocontrato ";
       $virgula = ",";
       if(trim($this->si172_exerciciocontrato) == null ){ 
         $this->erro_sql = " Campo Exercício do Contrato nao Informado.";
         $this->erro_campo = "si172_exerciciocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_licitacao"])){ 
        if(trim($this->si172_licitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si172_licitacao"])){ 
           $this->si172_licitacao = 0 ;
        } 
       $sql  .= $virgula." si172_licitacao = $this->si172_licitacao ";
       $virgula = ",";
     }
     if(trim($this->si172_dataassinatura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_dataassinatura_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si172_dataassinatura_dia"] !="") ){ 
       $sql  .= $virgula." si172_dataassinatura = '$this->si172_dataassinatura' ";
       $virgula = ",";
       if(trim($this->si172_dataassinatura) == null ){ 
         $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
         $this->erro_campo = "si172_dataassinatura_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si172_dataassinatura_dia"])){ 
         $sql  .= $virgula." si172_dataassinatura = null ";
         $virgula = ",";
         if(trim($this->si172_dataassinatura) == null ){ 
           $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
           $this->erro_campo = "si172_dataassinatura_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si172_fornecedor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_fornecedor"])){ 
       $sql  .= $virgula." si172_fornecedor = $this->si172_fornecedor ";
       $virgula = ",";
       if(trim($this->si172_fornecedor) == null ){ 
         $this->erro_sql = " Campo Fornecedor nao Informado.";
         $this->erro_campo = "si172_fornecedor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_contdeclicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_contdeclicitacao"])){ 
       $sql  .= $virgula." si172_contdeclicitacao = $this->si172_contdeclicitacao ";
       $virgula = ",";
       if(trim($this->si172_contdeclicitacao) == null ){ 
         $this->erro_sql = " Campo Contrato decorrente de Licitação nao Informado.";
         $this->erro_campo = "si172_contdeclicitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_codunidadesubresp"])){ 
       $sql  .= $virgula." si172_codunidadesubresp = '$this->si172_codunidadesubresp' ";
       $virgula = ",";
       if(trim($this->si172_codunidadesubresp) == null ){ 
         $this->erro_sql = " Campo Departamento nao Informado.";
         $this->erro_campo = "si172_codunidadesubresp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_nroprocesso)!="" && isset($GLOBALS["HTTP_POST_VARS"]["si172_nroprocesso"])){
       $sql  .= $virgula." si172_nroprocesso = '$this->si172_nroprocesso' ";
       $virgula = ",";
         if($this->si172_licitacao != "" && $this->si172_licitacao != null && $this->si172_licitacao != 0) {
             if (trim($this->si172_nroprocesso) == null) {
                 $this->erro_sql = " Campo Número do processo cadastrado nao Informado. Valor: ";
                 $this->erro_campo = "si172_nroprocesso";
                 $this->erro_banco = "";
                 $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                 $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                 $this->erro_status = "0";
                 return false;
             }
         }
     }

     if(trim($this->si172_exercicioprocesso)!="" && isset($GLOBALS["HTTP_POST_VARS"]["si172_exercicioprocesso"])){
       $sql  .= $virgula." si172_exercicioprocesso = $this->si172_exercicioprocesso ";
       $virgula = ",";
         if($this->si172_licitacao != "" && $this->si172_licitacao != null && $this->si172_licitacao != 0) {
             if (trim($this->si172_exercicioprocesso) == null) {
                 $this->erro_sql = " Campo Exercício do  processo nao Informado.";
                 $this->erro_campo = "si172_exercicioprocesso";
                 $this->erro_banco = "";
                 $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                 $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                 $this->erro_status = "0";
                 return false;
             }
         }

     }
     if(trim($this->si172_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_tipoprocesso"])){ 
        if(trim($this->si172_tipoprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si172_tipoprocesso"])){ 
           $this->si172_tipoprocesso = "0" ; 
        } 
       $sql  .= $virgula." si172_tipoprocesso = $this->si172_tipoprocesso ";
       $virgula = ",";
     }
     if(trim($this->si172_naturezaobjeto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_naturezaobjeto"])){ 
       $sql  .= $virgula." si172_naturezaobjeto = $this->si172_naturezaobjeto ";
       $virgula = ",";
       if(trim($this->si172_naturezaobjeto) == null ){ 
         $this->erro_sql = " Campo Natureza do objeto nao Informado.";
         $this->erro_campo = "si172_naturezaobjeto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_objetocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_objetocontrato"])){ 
       $sql  .= $virgula." si172_objetocontrato = '$this->si172_objetocontrato' ";
       $virgula = ",";
       if(trim($this->si172_objetocontrato) == null ){ 
         $this->erro_sql = " Campo Objeto do contrato nao Informado.";
         $this->erro_campo = "si172_objetocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_tipoinstrumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_tipoinstrumento"])){ 
       $sql  .= $virgula." si172_tipoinstrumento = $this->si172_tipoinstrumento ";
       $virgula = ",";
       if(trim($this->si172_tipoinstrumento) == null ){ 
         $this->erro_sql = " Campo Tipo de Instrumento nao Informado.";
         $this->erro_campo = "si172_tipoinstrumento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_datainiciovigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_datainiciovigencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si172_datainiciovigencia_dia"] !="") ){ 
       $sql  .= $virgula." si172_datainiciovigencia = '$this->si172_datainiciovigencia' ";
       $virgula = ",";
       if(trim($this->si172_datainiciovigencia) == null ){ 
         $this->erro_sql = " Campo Data inicial da vigência nao Informado.";
         $this->erro_campo = "si172_datainiciovigencia_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si172_datainiciovigencia_dia"])){ 
         $sql  .= $virgula." si172_datainiciovigencia = null ";
         $virgula = ",";
         if(trim($this->si172_datainiciovigencia) == null ){ 
           $this->erro_sql = " Campo Data inicial da vigência nao Informado.";
           $this->erro_campo = "si172_datainiciovigencia_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si172_datafinalvigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_datafinalvigencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si172_datafinalvigencia_dia"] !="") ){ 
       $sql  .= $virgula." si172_datafinalvigencia = '$this->si172_datafinalvigencia' ";
       $virgula = ",";
       if(trim($this->si172_datafinalvigencia) == null ){ 
         $this->erro_sql = " Campo Data final da vigência nao Informado.";
         $this->erro_campo = "si172_datafinalvigencia_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si172_datafinalvigencia_dia"])){ 
         $sql  .= $virgula." si172_datafinalvigencia = null ";
         $virgula = ",";
         if(trim($this->si172_datafinalvigencia) == null ){ 
           $this->erro_sql = " Campo Data final da vigência nao Informado.";
           $this->erro_campo = "si172_datafinalvigencia_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si172_vlcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_vlcontrato"])){ 
       $sql  .= $virgula." si172_vlcontrato = $this->si172_vlcontrato ";
       $virgula = ",";
       if(trim($this->si172_vlcontrato) == null ){ 
         $this->erro_sql = " Campo Valor do contrato nao Informado.";
         $this->erro_campo = "si172_vlcontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_formafornecimento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_formafornecimento"])){ 
       $sql  .= $virgula." si172_formafornecimento = '$this->si172_formafornecimento' ";
       $virgula = ",";
     }
     if(trim($this->si172_formapagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_formapagamento"])){ 
       $sql  .= $virgula." si172_formapagamento = '$this->si172_formapagamento' ";
       $virgula = ",";
     }
     if(trim($this->si172_prazoexecucao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_prazoexecucao"])){ 
       $sql  .= $virgula." si172_prazoexecucao = '$this->si172_prazoexecucao' ";
       $virgula = ",";
     }
     if(trim($this->si172_multarescisoria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_multarescisoria"])){ 
       $sql  .= $virgula." si172_multarescisoria = '$this->si172_multarescisoria' ";
       $virgula = ",";
     }
     if(trim($this->si172_multainadimplemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_multainadimplemento"])){ 
       $sql  .= $virgula." si172_multainadimplemento = '$this->si172_multainadimplemento' ";
       $virgula = ",";
     }
     if(trim($this->si172_garantia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_garantia"])){ 
        if(trim($this->si172_garantia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si172_garantia"])){ 
           $this->si172_garantia = "0" ; 
        } 
       $sql  .= $virgula." si172_garantia = $this->si172_garantia ";
       $virgula = ",";
     }
     if(trim($this->si172_cpfsignatariocontratante)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_cpfsignatariocontratante"])){ 
       $sql  .= $virgula." si172_cpfsignatariocontratante = '$this->si172_cpfsignatariocontratante' ";
       $virgula = ",";
       if(trim($this->si172_cpfsignatariocontratante) == null ){ 
         $this->erro_sql = " Campo Número do CPF do signatário nao Informado.";
         $this->erro_campo = "si172_cpfsignatariocontratante";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_datapublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_datapublicacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si172_datapublicacao_dia"] !="") ){ 
       $sql  .= $virgula." si172_datapublicacao = '$this->si172_datapublicacao' ";
       $virgula = ",";
       if(trim($this->si172_datapublicacao) == null ){ 
         $this->erro_sql = " Campo Data da publicação do contrato nao Informado.";
         $this->erro_campo = "si172_datapublicacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si172_datapublicacao_dia"])){ 
         $sql  .= $virgula." si172_datapublicacao = null ";
         $virgula = ",";
         if(trim($this->si172_datapublicacao) == null ){ 
           $this->erro_sql = " Campo Data da publicação do contrato nao Informado.";
           $this->erro_campo = "si172_datapublicacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si172_veiculodivulgacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_veiculodivulgacao"])){ 
       $sql  .= $virgula." si172_veiculodivulgacao = '$this->si172_veiculodivulgacao' ";
       $virgula = ",";
       if(trim($this->si172_veiculodivulgacao) == null ){ 
         $this->erro_sql = " Campo Veículo de Divulgação nao Informado.";
         $this->erro_campo = "si172_veiculodivulgacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si172_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si172_instit"])){ 
       $sql  .= $virgula." si172_instit = $this->si172_instit ";
       $virgula = ",";
       if(trim($this->si172_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si172_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si172_sequencial!=null){
       $sql .= " si172_sequencial = $this->si172_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si172_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011461,'$this->si172_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_sequencial"]) || $this->si172_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011461,'".AddSlashes(pg_result($resaco,$conresaco,'si172_sequencial'))."','$this->si172_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_nrocontrato"]) || $this->si172_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011462,'".AddSlashes(pg_result($resaco,$conresaco,'si172_nrocontrato'))."','$this->si172_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_exerciciocontrato"]) || $this->si172_exerciciocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011463,'".AddSlashes(pg_result($resaco,$conresaco,'si172_exerciciocontrato'))."','$this->si172_exerciciocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_licitacao"]) || $this->si172_licitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011487,'".AddSlashes(pg_result($resaco,$conresaco,'si172_licitacao'))."','$this->si172_licitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_dataassinatura"]) || $this->si172_dataassinatura != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011464,'".AddSlashes(pg_result($resaco,$conresaco,'si172_dataassinatura'))."','$this->si172_dataassinatura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_fornecedor"]) || $this->si172_fornecedor != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011465,'".AddSlashes(pg_result($resaco,$conresaco,'si172_fornecedor'))."','$this->si172_fornecedor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_contdeclicitacao"]) || $this->si172_contdeclicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011466,'".AddSlashes(pg_result($resaco,$conresaco,'si172_contdeclicitacao'))."','$this->si172_contdeclicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_codunidadesubresp"]) || $this->si172_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011467,'".AddSlashes(pg_result($resaco,$conresaco,'si172_codunidadesubresp'))."','$this->si172_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_nroprocesso"]) || $this->si172_nroprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011468,'".AddSlashes(pg_result($resaco,$conresaco,'si172_nroprocesso'))."','$this->si172_nroprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_exercicioprocesso"]) || $this->si172_exercicioprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011470,'".AddSlashes(pg_result($resaco,$conresaco,'si172_exercicioprocesso'))."','$this->si172_exercicioprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_tipoprocesso"]) || $this->si172_tipoprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011471,'".AddSlashes(pg_result($resaco,$conresaco,'si172_tipoprocesso'))."','$this->si172_tipoprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_naturezaobjeto"]) || $this->si172_naturezaobjeto != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011472,'".AddSlashes(pg_result($resaco,$conresaco,'si172_naturezaobjeto'))."','$this->si172_naturezaobjeto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_objetocontrato"]) || $this->si172_objetocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011473,'".AddSlashes(pg_result($resaco,$conresaco,'si172_objetocontrato'))."','$this->si172_objetocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_tipoinstrumento"]) || $this->si172_tipoinstrumento != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011474,'".AddSlashes(pg_result($resaco,$conresaco,'si172_tipoinstrumento'))."','$this->si172_tipoinstrumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_datainiciovigencia"]) || $this->si172_datainiciovigencia != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011475,'".AddSlashes(pg_result($resaco,$conresaco,'si172_datainiciovigencia'))."','$this->si172_datainiciovigencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_datafinalvigencia"]) || $this->si172_datafinalvigencia != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011476,'".AddSlashes(pg_result($resaco,$conresaco,'si172_datafinalvigencia'))."','$this->si172_datafinalvigencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_vlcontrato"]) || $this->si172_vlcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011477,'".AddSlashes(pg_result($resaco,$conresaco,'si172_vlcontrato'))."','$this->si172_vlcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_formafornecimento"]) || $this->si172_formafornecimento != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011478,'".AddSlashes(pg_result($resaco,$conresaco,'si172_formafornecimento'))."','$this->si172_formafornecimento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_formapagamento"]) || $this->si172_formapagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011479,'".AddSlashes(pg_result($resaco,$conresaco,'si172_formapagamento'))."','$this->si172_formapagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_prazoexecucao"]) || $this->si172_prazoexecucao != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011480,'".AddSlashes(pg_result($resaco,$conresaco,'si172_prazoexecucao'))."','$this->si172_prazoexecucao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_multarescisoria"]) || $this->si172_multarescisoria != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011481,'".AddSlashes(pg_result($resaco,$conresaco,'si172_multarescisoria'))."','$this->si172_multarescisoria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_multainadimplemento"]) || $this->si172_multainadimplemento != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011482,'".AddSlashes(pg_result($resaco,$conresaco,'si172_multainadimplemento'))."','$this->si172_multainadimplemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_garantia"]) || $this->si172_garantia != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011483,'".AddSlashes(pg_result($resaco,$conresaco,'si172_garantia'))."','$this->si172_garantia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_cpfsignatariocontratante"]) || $this->si172_cpfsignatariocontratante != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011484,'".AddSlashes(pg_result($resaco,$conresaco,'si172_cpfsignatariocontratante'))."','$this->si172_cpfsignatariocontratante',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_datapublicacao"]) || $this->si172_datapublicacao != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011485,'".AddSlashes(pg_result($resaco,$conresaco,'si172_datapublicacao'))."','$this->si172_datapublicacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_veiculodivulgacao"]) || $this->si172_veiculodivulgacao != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011486,'".AddSlashes(pg_result($resaco,$conresaco,'si172_veiculodivulgacao'))."','$this->si172_veiculodivulgacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si172_instit"]) || $this->si172_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010406,2011488,'".AddSlashes(pg_result($resaco,$conresaco,'si172_instit'))."','$this->si172_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si172_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si172_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si172_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si172_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si172_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011461,'$si172_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010406,2011461,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011462,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011463,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_exerciciocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011487,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011464,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011465,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011466,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_contdeclicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011467,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011468,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011470,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011471,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011472,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_naturezaobjeto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011473,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_objetocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011474,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_tipoinstrumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011475,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_datainiciovigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011476,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011477,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_vlcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011478,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_formafornecimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011479,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_formapagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011480,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_prazoexecucao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011481,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_multarescisoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011482,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_multainadimplemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011483,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_garantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011484,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_cpfsignatariocontratante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011485,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011486,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010406,2011488,'','".AddSlashes(pg_result($resaco,$iresaco,'si172_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si172_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si172_sequencial = $si172_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si172_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si172_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si172_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:contratos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si172_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from contratos ";
     $sql .= "      left join pcorcamforne  on  pcorcamforne.pc21_orcamforne = contratos.si172_fornecedor";
     $sql .= "      left  join liclicita  on  liclicita.l20_codigo = contratos.si172_licitacao";
     $sql .= "      left join cgm  on  cgm.z01_numcgm = pcorcamforne.pc21_numcgm";
     $sql .= "      left join pcorcam  on  pcorcam.pc20_codorc = pcorcamforne.pc21_codorc";
     $sql .= "      left join db_config  on  db_config.codigo = liclicita.l20_instit";
     $sql .= "      left join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
     $sql .= "      left join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
     $sql .= "      left join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
     $sql .= "      left join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
     $sql .= "      left join licsituacao  on  licsituacao.l08_sequencial = liclicita.l20_licsituacao";
    
     $sql2 = "";

     if($dbwhere==""){
       if($si172_sequencial!=null ){
         $sql2 .= " where contratos.si172_sequencial = $si172_sequencial "; 
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
   function sql_query_file ( $si172_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos ";
     $sql2 = "";
     if($dbwhere==""){
       if($si172_sequencial!=null ){
         $sql2 .= " where contratos.si172_sequencial = $si172_sequencial "; 
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
   function sql_query_novo ( $si172_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = contratos.si172_fornecedor";
     $sql2 = "";
     if($dbwhere==""){
       if($si172_sequencial!=null ){
         $sql2 .= " where contratos.si172_sequencial = $si172_sequencial "; 
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
   /**
   * query para chegar até o vinculo de contratos 
   */
  function sql_queryContratos ( $l20_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from liclicita ";
    $sql .= "      inner join db_config             on db_config.codigo            = liclicita.l20_instit";
    $sql .= "      inner join db_usuarios           on db_usuarios.id_usuario      = liclicita.l20_id_usucria";
    $sql .= "      inner join cflicita              on cflicita.l03_codigo         = liclicita.l20_codtipocom";
    $sql .= "      inner join liclocal              on liclocal.l26_codigo         = liclicita.l20_liclocal";
    $sql .= "      inner join liccomissao           on liccomissao.l30_codigo      = liclicita.l20_liccomissao";
    $sql .= "      inner join licsituacao           on licsituacao.l08_sequencial  = liclicita.l20_licsituacao";
    $sql .= "      inner join cgm                   on cgm.z01_numcgm              = db_config.numcgm";
    $sql .= "      inner join db_config as dbconfig on dbconfig.codigo             = cflicita.l03_instit";
    $sql .= "      inner join pctipocompra          on pctipocompra.pc50_codcom    = cflicita.l03_codcom";
    $sql .= "      inner join bairro                on bairro.j13_codi             = liclocal.l26_bairro";
    $sql .= "      inner join ruas                  on ruas.j14_codigo             = liclocal.l26_lograd";
    $sql .= "       left join liclicitaproc         on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
    $sql .= "       left join protprocesso          on protprocesso.p58_codproc    = liclicitaproc.l34_protprocesso";
    $sql .= "       left join liclicitem            on liclicita.l20_codigo        = l21_codliclicita ";
    $sql .= "       left join acordoliclicitem      on liclicitem.l21_codigo       = acordoliclicitem.ac24_liclicitem ";
    $sql .= "       left join pctipocompratribunal  on l44_sequencial              = cflicita.l03_pctipocompratribunal ";
    
    $sql2 = "";
    if($dbwhere==""){
      if($l20_codigo!=null ){
        $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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
      //      echo $sql;
      return $sql;
  }
  /**
  * Fornecedores para o contrato
  */
  function sql_fornContratos ($l20_codigo=null){
      
      $clpcorcamforne = new cl_pcorcamforne();
      $clpcorcamitem = new cl_pcorcamitem();

      $result_info = $clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null, "distinct l21_codliclicita,pc22_codorc,l20_tipojulg", null, "l21_codliclicita=$l20_codigo and l20_instit = " . db_getsession("DB_instit")));
      $pc22_codorc = db_utils::fieldsMemory($result_info, 0)->pc22_codorc;

      $sql = $clpcorcamforne->sql_query(null, "pc21_numcgm,z01_nome", null, "pc21_codorc=$pc22_codorc");
      
      return $sql;
  }

    /**
  * Fornecedores para o contrato orcamforne
  */
  function sql_orcamforn ($l20_codigo=null){
      
      $clpcorcamforne = new cl_pcorcamforne();
      $clpcorcamitem = new cl_pcorcamitem();

      $result_info = $clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null, "distinct l21_codliclicita,pc22_codorc,l20_tipojulg", null, "l21_codliclicita=$l20_codigo and l20_instit = " . db_getsession("DB_instit")));
      $pc22_codorc = db_utils::fieldsMemory($result_info, 0)->pc22_codorc;

      $sql = $clpcorcamforne->sql_query(null, "pc21_orcamforne", null, "pc21_codorc=$pc22_codorc");
      
      return $sql;
  }

  /**
  * Valor do contrato
  */
  function sql_valorContratos ($pc21_orcamforne){
      
      $clpcorcamval = new cl_pcorcamval();

      $result_valor = $clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null, null, "sum(pc23_valor)", null, "pc21_orcamforne=$pc21_orcamforne 
                                                                     and pc24_pontuacao=1"));
      
      $pc23_valor = db_utils::fieldsMemory($result_valor, 0)->sum;
      
      
      return $pc23_valor;
  }

  // funcao do sql 
   function sql_contrato ( $si172_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos ";
     if($dbwhere==""){
       if($si172_sequencial!=null ){
         $sql2 .= " where contratos.si172_sequencial = $si172_sequencial "; 
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

  function sql_itens ( $l21_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from liclicitem ";
     $sql .= "      inner join pcprocitem           on liclicitem.l21_codpcprocitem        = pcprocitem.pc81_codprocitem";
     $sql .= "      inner join pcproc               on pcproc.pc80_codproc                 = pcprocitem.pc81_codproc";
     $sql .= "      inner join solicitem            on solicitem.pc11_codigo               = pcprocitem.pc81_solicitem";
     $sql .= "      inner join solicita             on solicita.pc10_numero                = solicitem.pc11_numero";
     $sql .= "      inner join db_depart            on db_depart.coddepto                  = solicita.pc10_depto";
     $sql .= "      left  join liclicita            on liclicita.l20_codigo                = liclicitem.l21_codliclicita";
     $sql .= "      left  join cflicita             on cflicita.l03_codigo                 = liclicita.l20_codtipocom";
     $sql .= "      left  join pctipocompra         on pctipocompra.pc50_codcom            = cflicita.l03_codcom";
     $sql .= "      left  join solicitemunid        on solicitemunid.pc17_codigo           = solicitem.pc11_codigo";
     $sql .= "      left  join matunid              on matunid.m61_codmatunid              = solicitemunid.pc17_unid";
     $sql .= "      left  join pcorcamitemlic       on l21_codigo                          = pc26_liclicitem ";
     $sql .= "      left  join pcorcamval           on pc26_orcamitem                      = pc23_orcamitem ";     
     $sql .= "      left  join db_usuarios          on pcproc.pc80_usuario                 = db_usuarios.id_usuario";
     $sql .= "      left  join solicitempcmater     on solicitempcmater.pc16_solicitem     = solicitem.pc11_codigo";
     $sql .= "      left  join pcmater              on pcmater.pc01_codmater               = solicitempcmater.pc16_codmater";
     $sql .= "      left  join pcsubgrupo           on pcsubgrupo.pc04_codsubgrupo         = pcmater.pc01_codsubgrupo";
     $sql .= "      left  join pctipo               on pctipo.pc05_codtipo                 = pcsubgrupo.pc04_codtipo";
     $sql .= "      left  join solicitemele         on solicitemele.pc18_solicitem         = solicitem.pc11_codigo";
     $sql .= "      left  join orcelemento          on orcelemento.o56_codele              = solicitemele.pc18_codele";
     $sql .= "                                     and orcelemento.o56_anousu              = ".db_getsession("DB_anousu");
     $sql .= "      left  join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem";    
     $sql .= "      left  join empautitem           on empautitem.e55_autori               = empautitempcprocitem.e73_autori";
     $sql .= "                                     and empautitem.e55_sequen               = empautitempcprocitem.e73_sequen";
     $sql .= "      left  join empautoriza          on empautoriza.e54_autori              = empautitem.e55_autori ";
     $sql .= "      left  join empempaut            on empempaut.e61_autori                = empautitem.e55_autori ";     
     $sql .= "      left  join empempenho           on empempenho.e60_numemp               = empempaut.e61_numemp ";
     $sql .= "      left  join pcdotac              on solicitem.pc11_codigo               = pcdotac.pc13_codigo ";
     $sql2 = "";
     if($dbwhere==""){
       if($l21_codigo!=null ){
         $sql2 .= " where liclicitem.l21_codigo = $l21_codigo "; 
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
