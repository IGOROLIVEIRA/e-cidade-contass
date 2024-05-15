<?
//MODULO: orcamento
//CLASSE DA ENTIDADE ppaleidadocomplementar
class cl_ppaleidadocomplementar { 
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
   var $o142_sequencial = 0; 
   var $o142_ppalei = 0; 
   var $o142_anoinicialppa = 0; 
   var $o142_anofinalppa = 0; 
   var $o142_numeroleippa = null; 
   var $o142_dataleippa_dia = null; 
   var $o142_dataleippa_mes = null; 
   var $o142_dataleippa_ano = null; 
   var $o142_dataleippa = null; 
   var $o142_datapublicacaoppa_dia = null; 
   var $o142_datapublicacaoppa_mes = null; 
   var $o142_datapublicacaoppa_ano = null; 
   var $o142_datapublicacaoppa = null; 
   var $o142_leialteracaoppa = null; 
   var $o142_leialteracaoppaano2 = null; 
   var $o142_leialteracaoppaano3 = null; 
   var $o142_leialteracaoppaano4 = null; 
   var $o142_dataalteracaoppa_dia = null; 
   var $o142_dataalteracaoppa_mes = null; 
   var $o142_dataalteracaoppa_ano = null; 
   var $o142_dataalteracaoppa = null; 
   var $o142_dataalteracaoppaano2_dia = null; 
   var $o142_dataalteracaoppaano2_mes = null; 
   var $o142_dataalteracaoppaano2_ano = null; 
   var $o142_dataalteracaoppaano2 = null; 
   var $o142_dataalteracaoppaano3_dia = null; 
   var $o142_dataalteracaoppaano3_mes = null; 
   var $o142_dataalteracaoppaano3_ano = null; 
   var $o142_dataalteracaoppaano3 = null; 
   var $o142_dataalteracaoppaano4_dia = null; 
   var $o142_dataalteracaoppaano4_mes = null; 
   var $o142_dataalteracaoppaano4_ano = null; 
   var $o142_dataalteracaoppaano4 = null; 
   var $o142_datapubalteracao_dia = null; 
   var $o142_datapubalteracao_mes = null; 
   var $o142_datapubalteracao_ano = null; 
   var $o142_datapubalteracao = null; 
   var $o142_datapubalteracaoano2_dia = null; 
   var $o142_datapubalteracaoano2_mes = null; 
   var $o142_datapubalteracaoano2_ano = null; 
   var $o142_datapubalteracaoano2 = null; 
   var $o142_datapubalteracaoano3_dia = null; 
   var $o142_datapubalteracaoano3_mes = null; 
   var $o142_datapubalteracaoano3_ano = null; 
   var $o142_datapubalteracaoano3 = null;
   var $o142_datapubalteracaoano4_dia = null; 
   var $o142_datapubalteracaoano4_mes = null; 
   var $o142_datapubalteracaoano4_ano = null; 
   var $o142_datapubalteracaoano4 = null;  
   var $o142_datapublicacaoldo_dia = null; 
   var $o142_datapublicacaoldo_mes = null; 
   var $o142_datapublicacaoldo_ano = null; 
   var $o142_datapublicacaoldo = null; 
   var $o142_datapublicacaoldoano2_dia = null; 
   var $o142_datapublicacaoldoano2_mes = null; 
   var $o142_datapublicacaoldoano2_ano = null; 
   var $o142_datapublicacaoldoano2 = null;
   var $o142_datapublicacaoldoano3_dia = null; 
   var $o142_datapublicacaoldoano3_mes = null; 
   var $o142_datapublicacaoldoano3_ano = null; 
   var $o142_datapublicacaoldoano3 = null;  
   var $o142_datapublicacaoldoano4_dia = null; 
   var $o142_datapublicacaoldoano4_mes = null; 
   var $o142_datapublicacaoldoano4_ano = null; 
   var $o142_datapublicacaoldoano4 = null; 
   var $o142_dataldo_dia = null; 
   var $o142_dataldo_mes = null; 
   var $o142_dataldo_ano = null; 
   var $o142_dataldo = null; 
   var $o142_numeroloa = null; 
   var $o142_numeroloaano2 = null; 
   var $o142_numeroloaano3 = null; 
   var $o142_numeroloaano4 = null; 
   var $o142_dataloa_dia = null; 
   var $o142_dataloa_mes = null; 
   var $o142_dataloa_ano = null; 
   var $o142_dataloa = null;
   var $o142_dataloaano2_dia = null; 
   var $o142_dataloaano2_mes = null; 
   var $o142_dataloaano2_ano = null; 
   var $o142_dataloaano2 = null;
   var $o142_dataloaano3_dia = null; 
   var $o142_dataloaano3_mes = null; 
   var $o142_dataloaano3_ano = null; 
   var $o142_dataloaano3 = null; 
   var $o142_dataloaano4_dia = null; 
   var $o142_dataloaano4_mes = null; 
   var $o142_dataloaano4_ano = null; 
   var $o142_dataloaano4 = null;  
   var $o142_dataldoano2_dia = null; 
   var $o142_dataldoano2_mes = null; 
   var $o142_dataldoano2_ano = null; 
   var $o142_dataldoano2 = null; 
   var $o142_dataldoano3_dia = null; 
   var $o142_dataldoano3_mes = null; 
   var $o142_dataldoano3_ano = null; 
   var $o142_dataldoano3 = null; 
   var $o142_dataldoano4_dia = null; 
   var $o142_dataldoano4_mes = null; 
   var $o142_dataldoano4_ano = null; 
   var $o142_dataldoano4 = null; 
   var $o142_datapubloa_dia = null; 
   var $o142_datapubloa_mes = null; 
   var $o142_datapubloa_ano = null; 
   var $o142_datapubloa = null;
   var $o142_datapubloaano2_dia = null; 
   var $o142_datapubloaano2_mes = null; 
   var $o142_datapubloaano2_ano = null; 
   var $o142_datapubloaano2 = null; 
   var $o142_datapubloaano3_dia = null; 
   var $o142_datapubloaano3_mes = null; 
   var $o142_datapubloaano3_ano = null; 
   var $o142_datapubloaano3 = null;  
   var $o142_datapubloaano4_dia = null; 
   var $o142_datapubloaano4_mes = null; 
   var $o142_datapubloaano4_ano = null; 
   var $o142_datapubloaano4 = null; 
   var $o142_percsuplementacao = 0; 
   var $o142_percsuplementacaoano2 = 0; 
   var $o142_percsuplementacaoano3 = 0; 
   var $o142_percsuplementacaoano4 = 0; 
   var $o142_percaro = 0;
   var $o142_percaroano2 = 0; 
   var $o142_percaroano3 = 0; 
   var $o142_percaroano4 = 0; 
   var $o142_percopercredito = 0; 
   var $o142_percopercreditoano2 = 0; 
   var $o142_percopercreditoano3 = 0; 
   var $o142_percopercreditoano4 = 0; 
   var $o142_orcmodalidadeaplic = null;
   var $o142_orcmodalidadeaplicano2 = null;
   var $o142_orcmodalidadeaplicano3 = null;
   var $o142_orcmodalidadeaplicano4 = null;
   var $o142_leialteracaoldo = null; 
   var $o142_leialteracaoldoano2 = null; 
   var $o142_leialteracaoldoano3 = null; 
   var $o142_leialteracaoldoano4 = null;
   var $o142_dataalteracaoldo_dia = null; 
   var $o142_dataalteracaoldo_mes = null; 
   var $o142_dataalteracaoldo_ano = null; 
   var $o142_dataalteracaoldo = null; 
   var $o142_dataalteracaoldoano2_dia = null; 
   var $o142_dataalteracaoldoano2_mes = null; 
   var $o142_dataalteracaoldoano2_ano = null; 
   var $o142_dataalteracaoldoano2 = null; 
   var $o142_dataalteracaoldoano3_dia = null; 
   var $o142_dataalteracaoldoano3_mes = null; 
   var $o142_dataalteracaoldoano3_ano = null; 
   var $o142_dataalteracaoldoano3 = null; 
   var $o142_dataalteracaoldoano4_dia = null; 
   var $o142_dataalteracaoldoano4_mes = null; 
   var $o142_dataalteracaoldoano4_ano = null; 
   var $o142_dataalteracaoldoano4 = null; 
   var $o142_datapubalteracaoldo_dia = null; 
   var $o142_datapubalteracaoldo_mes = null; 
   var $o142_datapubalteracaoldo_ano = null; 
   var $o142_datapubalteracaoldo = null; 
   var $o142_datapubalteracaoldoano2_dia = null; 
   var $o142_datapubalteracaoldoano2_mes = null; 
   var $o142_datapubalteracaoldoano2_ano = null; 
   var $o142_datapubalteracaoldoano2 = null; 
   var $o142_datapubalteracaoldoano3_dia = null; 
   var $o142_datapubalteracaoldoano3_mes = null; 
   var $o142_datapubalteracaoldoano3_ano = null; 
   var $o142_datapubalteracaoldoano3 = null;
   var $o142_datapubalteracaoldoano4_dia = null; 
   var $o142_datapubalteracaoldoano4_mes = null; 
   var $o142_datapubalteracaoldoano4_ano = null; 
   var $o142_datapubalteracaoldoano4 = null;  
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o142_sequencial = int8 = Codigo Sequencial 
                 o142_ppalei = int4 = Código da Lei do PPA 
                 o142_anoinicialppa = int4 = Ano Inicial 
                 o142_anofinalppa = int4 = Ano Final 
                 o142_numeroleippa = varchar(50) = Número da Lei 
                 o142_dataleippa = date = Data da Lei 
                 o142_datapublicacaoppa = date = Data de Publicação 
                 o142_leialteracaoppa = varchar(50) = Número da Lei de Alteração 
                 o142_leialteracaoppaano2 = varchar(50) = Número da Lei de Alteração 
                 o142_leialteracaoppaano3 = varchar(50) = Número da Lei de Alteração 
                 o142_leialteracaoppaano4 = varchar(50) = Número da Lei de Alteração 
                 o142_dataalteracaoppa = date = Data da Lei de Alteração 
                 o142_dataalteracaoppaano2 = date = Data da Lei de Alteração
                 o142_dataalteracaoppaano3 = date = Data da Lei de Alteração
                 o142_dataalteracaoppaano4 = date = Data da Lei de Alteração
                 o142_datapubalteracao = date = Data de Publicação da Lei de Alteração
                 o142_datapubalteracaoano2 = date = Data de Publicação da Lei de Alteração
                 o142_datapubalteracaoano3 = date = Data de Publicação da Lei de Alteração
                 o142_datapubalteracaoano4 = date = Data de Publicação da Lei de Alteração 
                 o142_datapublicacaoldo = date = Data de Publicação LDO
                 o142_datapublicacaoldoano2 = date = Data de Publicação LDO
                 o142_datapublicacaoldoano3 = date = Data de Publicação LDO 
                 o142_datapublicacaoldoano4 = date = Data de Publicação LDO 
                 o142_dataldo = date = Data LDO
                 o142_dataldoano2 = date = Data LDO 
                 o142_dataldoano3 = date = Data LDO 
                 o142_dataldoano4 = date = Data LDO  
                 o142_numeroloa = varchar(50) = Número da LOA 
                 o01_numeroleiano2 = varchar(50) = Número da LOA 
                 o01_numeroleiano3 = varchar(50) = Número da LOA 
                 o01_numeroleiano4 = varchar(50) = Número da LOA 
                 o142_dataloa = date = Data da LOA 
                 o142_dataloaano2 = date = Data da LOA 
                 o142_dataloaano3 = date = Data da LOA 
                 o142_dataloaano4 = date = Data da LOA 
                 o142_datapubloa = date = Data de Publicação da LOA 
                 o142_datapubloaano2 = date = Data de Publicação da LOA 
                 o142_datapubloaano3 = date = Data de Publicação da LOA
                 o142_datapubloaano4 = date = Data de Publicação da LOA
                 o142_percsuplementacao = numeric(10) = Percentual de Suplementação 
                 o142_percsuplementacaoano2 = numeric(10) = Percentual de Suplementação 
                 o142_percsuplementacaoano3 = numeric(10) = Percentual de Suplementação 
                 o142_percsuplementacaoano4 = numeric(10) = Percentual de Suplementação 
                 o142_percaro = numeric(10) = Percentual de ARO 
                 o142_percaroano2 = numeric(10) = Percentual de ARO
                 o142_percaroano3 = numeric(10) = Percentual de ARO
                 o142_percaroano4 = numeric(10) = Percentual de ARO
                 o142_percopercredito = numeric(10) = Operação de Crédito Interna 
                 o142_percopercreditoano2 = numeric(10) = Operação de Crédito Interna 
                 o142_percopercreditoano3 = numeric(10) = Operação de Crédito Interna 
                 o142_percopercreditoano4 = numeric(10) = Operação de Crédito Interna 
                 o142_orcmodalidadeaplic = bool = Orçamento por Modalidade de Aplicação
                 o142_orcmodalidadeaplicano2 = bool = Orçamento por Modalidade de Aplicação
                 o142_orcmodalidadeaplicano3 = bool = Orçamento por Modalidade de Aplicação
                 o142_orcmodalidadeaplicano4 = bool = Orçamento por Modalidade de Aplicação
                 o142_leialteracaoldo = varchar(50) = Número da Lei de Alteração 
                 o142_leialteracaoldoano2 = varchar(50) = Número da Lei de Alteração 
                 o142_leialteracaoldoano3 = varchar(50) = Número da Lei de Alteração 
                 o142_leialteracaoldoano4 = varchar(50) = Número da Lei de Alteração 
                 o142_dataalteracaoldo = date = Data da Lei de Alteração 
                 o142_dataalteracaoldoano2 = date = Data da Lei de Alteração
                 o142_dataalteracaoldoano3 = date = Data da Lei de Alteração
                 o142_dataalteracaoldoano4 = date = Data da Lei de Alteração
                 o142_datapubalteracaoldo = date = Data de Publicação da Lei de Alteração
                 o142_datapubalteracaoldoano2 = date = Data de Publicação da Lei de Alteração
                 o142_datapubalteracaoldoano3 = date = Data de Publicação da Lei de Alteração
                 o142_datapubalteracaoldoano4 = date = Data de Publicação da Lei de Alteração 
                 ";
   //funcao construtor da classe 
   function cl_ppaleidadocomplementar() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ppaleidadocomplementar"); 
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
       $this->o142_sequencial = ($this->o142_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_sequencial"]:$this->o142_sequencial);
       $this->o142_ppalei = ($this->o142_ppalei == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_ppalei"]:$this->o142_ppalei);
       $this->o142_anoinicialppa = ($this->o142_anoinicialppa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"]:$this->o142_anoinicialppa);
       $this->o142_anofinalppa = ($this->o142_anofinalppa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"]:$this->o142_anofinalppa);
       $this->o142_numeroleippa = ($this->o142_numeroleippa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_numeroleippa"]:$this->o142_numeroleippa);
       if($this->o142_dataleippa == ""){
         $this->o142_dataleippa_dia = ($this->o142_dataleippa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"]:$this->o142_dataleippa_dia);
         $this->o142_dataleippa_mes = ($this->o142_dataleippa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_mes"]:$this->o142_dataleippa_mes);
         $this->o142_dataleippa_ano = ($this->o142_dataleippa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_ano"]:$this->o142_dataleippa_ano);
         if($this->o142_dataleippa_dia != ""){
            $this->o142_dataleippa = $this->o142_dataleippa_ano."-".$this->o142_dataleippa_mes."-".$this->o142_dataleippa_dia;
         }
       }
       if($this->o142_datapublicacaoppa == ""){
         $this->o142_datapublicacaoppa_dia = ($this->o142_datapublicacaoppa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"]:$this->o142_datapublicacaoppa_dia);
         $this->o142_datapublicacaoppa_mes = ($this->o142_datapublicacaoppa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_mes"]:$this->o142_datapublicacaoppa_mes);
         $this->o142_datapublicacaoppa_ano = ($this->o142_datapublicacaoppa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_ano"]:$this->o142_datapublicacaoppa_ano);
         if($this->o142_datapublicacaoppa_dia != ""){
            $this->o142_datapublicacaoppa = $this->o142_datapublicacaoppa_ano."-".$this->o142_datapublicacaoppa_mes."-".$this->o142_datapublicacaoppa_dia;
         }
       }
       $this->o142_leialteracaoppa = ($this->o142_leialteracaoppa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppa"]:$this->o142_leialteracaoppa);
       $this->o142_leialteracaoppaano2 = ($this->o142_leialteracaoppaano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano2"]:$this->o142_leialteracaoppaano2);
       $this->o142_leialteracaoppaano3 = ($this->o142_leialteracaoppaano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano3"]:$this->o142_leialteracaoppaano3);
       $this->o142_leialteracaoppaano4 = ($this->o142_leialteracaoppaano4 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano4"]:$this->o142_leialteracaoppaano4);
       if($this->o142_dataalteracaoppa == ""){
         $this->o142_dataalteracaoppa_dia = ($this->o142_dataalteracaoppa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"]:$this->o142_dataalteracaoppa_dia);
         $this->o142_dataalteracaoppa_mes = ($this->o142_dataalteracaoppa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_mes"]:$this->o142_dataalteracaoppa_mes);
         $this->o142_dataalteracaoppa_ano = ($this->o142_dataalteracaoppa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_ano"]:$this->o142_dataalteracaoppa_ano);
         if($this->o142_dataalteracaoppa_dia != ""){
            $this->o142_dataalteracaoppa = $this->o142_dataalteracaoppa_ano."-".$this->o142_dataalteracaoppa_mes."-".$this->o142_dataalteracaoppa_dia;
         }
       }
       if($this->o142_dataalteracaoppaano2 == ""){
        $this->o142_dataalteracaoppaano2_dia = ($this->o142_dataalteracaoppaano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano2_dia"]:$this->o142_dataalteracaoppaano2_dia);
        $this->o142_dataalteracaoppaano2_mes = ($this->o142_dataalteracaoppaano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano2_mes"]:$this->o142_dataalteracaoppaano2_mes);
        $this->o142_dataalteracaoppaano2_ano = ($this->o142_dataalteracaoppaano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano2_ano"]:$this->o142_dataalteracaoppaano2_ano);
        if($this->o142_dataalteracaoppaano2_dia != ""){
           $this->o142_dataalteracaoppaano2 = $this->o142_dataalteracaoppaano2_ano."-".$this->o142_dataalteracaoppaano2_mes."-".$this->o142_dataalteracaoppaano2_dia;
        }
       }
       if($this->o142_dataalteracaoppaano3 == ""){
        $this->o142_dataalteracaoppaano3_dia = ($this->o142_dataalteracaoppaano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano3_dia"]:$this->o142_dataalteracaoppaano3_dia);
        $this->o142_dataalteracaoppaano3_mes = ($this->o142_dataalteracaoppaano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano3_mes"]:$this->o142_dataalteracaoppaano3_mes);
        $this->o142_dataalteracaoppaano3_ano = ($this->o142_dataalteracaoppaano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano3_ano"]:$this->o142_dataalteracaoppaano3_ano);
        if($this->o142_dataalteracaoppaano3_dia != ""){
           $this->o142_dataalteracaoppaano3 = $this->o142_dataalteracaoppaano3_ano."-".$this->o142_dataalteracaoppaano3_mes."-".$this->o142_dataalteracaoppaano3_dia;
        }
       }
       if($this->o142_dataalteracaoppaano4 == ""){
        $this->o142_dataalteracaoppaano4_dia = ($this->o142_dataalteracaoppaano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano4_dia"]:$this->o142_dataalteracaoppaano4_dia);
        $this->o142_dataalteracaoppaano4_mes = ($this->o142_dataalteracaoppaano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano4_mes"]:$this->o142_dataalteracaoppaano4_mes);
        $this->o142_dataalteracaoppaano4_ano = ($this->o142_dataalteracaoppaano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano4_ano"]:$this->o142_dataalteracaoppaano4_ano);
        if($this->o142_dataalteracaoppaano4_dia != ""){
           $this->o142_dataalteracaoppaano4 = $this->o142_dataalteracaoppaano4_ano."-".$this->o142_dataalteracaoppaano4_mes."-".$this->o142_dataalteracaoppaano4_dia;
        }
       }
       if($this->o142_datapubalteracao == ""){
         $this->o142_datapubalteracao_dia = ($this->o142_datapubalteracao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"]:$this->o142_datapubalteracao_dia);
         $this->o142_datapubalteracao_mes = ($this->o142_datapubalteracao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_mes"]:$this->o142_datapubalteracao_mes);
         $this->o142_datapubalteracao_ano = ($this->o142_datapubalteracao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_ano"]:$this->o142_datapubalteracao_ano);
         if($this->o142_datapubalteracao_dia != ""){
            $this->o142_datapubalteracao = $this->o142_datapubalteracao_ano."-".$this->o142_datapubalteracao_mes."-".$this->o142_datapubalteracao_dia;
         }
       }
       if($this->o142_datapubalteracaoano2 == ""){
        $this->o142_datapubalteracaoano2_dia = ($this->o142_datapubalteracaoano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano2_dia"]:$this->o142_datapubalteracaoano2_dia);
        $this->o142_datapubalteracaoano2_mes = ($this->o142_datapubalteracaoano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano2_mes"]:$this->o142_datapubalteracaoano2_mes);
        $this->o142_datapubalteracaoano2_ano = ($this->o142_datapubalteracaoano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano2_ano"]:$this->o142_datapubalteracaoano2_ano);
        if($this->o142_datapubalteracaoano2_dia != ""){
           $this->o142_datapubalteracaoano2 = $this->o142_datapubalteracaoano2_ano."-".$this->o142_datapubalteracaoano2_mes."-".$this->o142_datapubalteracaoano2_dia;
        }
      }
      if($this->o142_datapubalteracaoano3 == ""){
        $this->o142_datapubalteracaoano3_dia = ($this->o142_datapubalteracaoano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano3_dia"]:$this->o142_datapubalteracaoano3_dia);
        $this->o142_datapubalteracaoano3_mes = ($this->o142_datapubalteracaoano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano3_mes"]:$this->o142_datapubalteracaoano3_mes);
        $this->o142_datapubalteracaoano3_ano = ($this->o142_datapubalteracaoano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano3_ano"]:$this->o142_datapubalteracaoano3_ano);
        if($this->o142_datapubalteracaoano3_dia != ""){
           $this->o142_datapubalteracaoano3 = $this->o142_datapubalteracaoano3_ano."-".$this->o142_datapubalteracaoano3_mes."-".$this->o142_datapubalteracaoano3_dia;
        }
      }
      if($this->o142_datapubalteracaoano4 == ""){
        $this->o142_datapubalteracaoano4_dia = ($this->o142_datapubalteracaoano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano4_dia"]:$this->o142_datapubalteracaoano4_dia);
        $this->o142_datapubalteracaoano4_mes = ($this->o142_datapubalteracaoano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano4_mes"]:$this->o142_datapubalteracaoano4_mes);
        $this->o142_datapubalteracaoano4_ano = ($this->o142_datapubalteracaoano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano4_ano"]:$this->o142_datapubalteracaoano4_ano);
        if($this->o142_datapubalteracaoano4_dia != ""){
           $this->o142_datapubalteracaoano4 = $this->o142_datapubalteracaoano4_ano."-".$this->o142_datapubalteracaoano4_mes."-".$this->o142_datapubalteracaoano4_dia;
        }
      }
       if($this->o142_datapublicacaoldo == ""){
         $this->o142_datapublicacaoldo_dia = ($this->o142_datapublicacaoldo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"]:$this->o142_datapublicacaoldo_dia);
         $this->o142_datapublicacaoldo_mes = ($this->o142_datapublicacaoldo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_mes"]:$this->o142_datapublicacaoldo_mes);
         $this->o142_datapublicacaoldo_ano = ($this->o142_datapublicacaoldo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_ano"]:$this->o142_datapublicacaoldo_ano);
         if($this->o142_datapublicacaoldo_dia != ""){
            $this->o142_datapublicacaoldo = $this->o142_datapublicacaoldo_ano."-".$this->o142_datapublicacaoldo_mes."-".$this->o142_datapublicacaoldo_dia;
         }
       }
       if($this->o142_datapublicacaoldoano2 == ""){
        $this->o142_datapublicacaoldoano2_dia = ($this->o142_datapublicacaoldoano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano2_dia"]:$this->o142_datapublicacaoldoano2_dia);
        $this->o142_datapublicacaoldoano2_mes = ($this->o142_datapublicacaoldoano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano2_mes"]:$this->o142_datapublicacaoldoano2_mes);
        $this->o142_datapublicacaoldoano2_ano = ($this->o142_datapublicacaoldoano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano2_ano"]:$this->o142_datapublicacaoldoano2_ano);
        if($this->o142_datapublicacaoldoano2_dia != ""){
           $this->o142_datapublicacaoldoano2 = $this->o142_datapublicacaoldoano2_ano."-".$this->o142_datapublicacaoldoano2_mes."-".$this->o142_datapublicacaoldoano2_dia;
        }
       }
       if($this->o142_datapublicacaoldoano3 == ""){
        $this->o142_datapublicacaoldoano3_dia = ($this->o142_datapublicacaoldoano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano3_dia"]:$this->o142_datapublicacaoldoano3_dia);
        $this->o142_datapublicacaoldoano3_mes = ($this->o142_datapublicacaoldoano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano3_mes"]:$this->o142_datapublicacaoldoano3_mes);
        $this->o142_datapublicacaoldoano3_ano = ($this->o142_datapublicacaoldoano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano3_ano"]:$this->o142_datapublicacaoldoano3_ano);
        if($this->o142_datapublicacaoldoano3_dia != ""){
           $this->o142_datapublicacaoldoano3 = $this->o142_datapublicacaoldoano3_ano."-".$this->o142_datapublicacaoldoano3_mes."-".$this->o142_datapublicacaoldoano3_dia;
        }
       }
       if($this->o142_datapublicacaoldoano4 == ""){
        $this->o142_datapublicacaoldoano4_dia = ($this->o142_datapublicacaoldoano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano4_dia"]:$this->o142_datapublicacaoldoano4_dia);
        $this->o142_datapublicacaoldoano4_mes = ($this->o142_datapublicacaoldoano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano4_mes"]:$this->o142_datapublicacaoldoano4_mes);
        $this->o142_datapublicacaoldoano4_ano = ($this->o142_datapublicacaoldoano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano4_ano"]:$this->o142_datapublicacaoldoano4_ano);
        if($this->o142_datapublicacaoldoano4_dia != ""){
           $this->o142_datapublicacaoldoano4 = $this->o142_datapublicacaoldoano4_ano."-".$this->o142_datapublicacaoldoano4_mes."-".$this->o142_datapublicacaoldoano4_dia;
        }
       }
       if($this->o142_dataldo == ""){
         $this->o142_dataldo_dia = ($this->o142_dataldo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"]:$this->o142_dataldo_dia);
         $this->o142_dataldo_mes = ($this->o142_dataldo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldo_mes"]:$this->o142_dataldo_mes);
         $this->o142_dataldo_ano = ($this->o142_dataldo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldo_ano"]:$this->o142_dataldo_ano);
         if($this->o142_dataldo_dia != ""){
            $this->o142_dataldo = $this->o142_dataldo_ano."-".$this->o142_dataldo_mes."-".$this->o142_dataldo_dia;
         }
       }
       if($this->o142_dataldoano2 == ""){
        $this->o142_dataldoano2_dia = ($this->o142_dataldoano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano2_dia"]:$this->o142_dataldoano2_dia);
        $this->o142_dataldoano2_mes = ($this->o142_dataldoano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano2_mes"]:$this->o142_dataldoano2_mes);
        $this->o142_dataldoano2_ano = ($this->o142_dataldoano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano2_ano"]:$this->o142_dataldoano2_ano);
        if($this->o142_dataldoano2_dia != ""){
           $this->o142_dataldoano2 = $this->o142_dataldoano2_ano."-".$this->o142_dataldoano2_mes."-".$this->o142_dataldoano2_dia;
        }
       }
       if($this->o142_dataldoano3 == ""){
        $this->o142_dataldoano3_dia = ($this->o142_dataldoano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano3_dia"]:$this->o142_dataldoano3_dia);
        $this->o142_dataldoano3_mes = ($this->o142_dataldoano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano3_mes"]:$this->o142_dataldoano3_mes);
        $this->o142_dataldoano3_ano = ($this->o142_dataldoano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano3_ano"]:$this->o142_dataldoano3_ano);
        if($this->o142_dataldoano3_dia != ""){
           $this->o142_dataldoano3 = $this->o142_dataldoano3_ano."-".$this->o142_dataldoano3_mes."-".$this->o142_dataldoano3_dia;
        }
       }
       if($this->o142_dataldoano4 == ""){
        $this->o142_dataldoano4_dia = ($this->o142_dataldoano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano4_dia"]:$this->o142_dataldoano4_dia);
        $this->o142_dataldoano4_mes = ($this->o142_dataldoano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano4_mes"]:$this->o142_dataldoano4_mes);
        $this->o142_dataldoano4_ano = ($this->o142_dataldoano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldoano4_ano"]:$this->o142_dataldoano4_ano);
        if($this->o142_dataldoano4_dia != ""){
           $this->o142_dataldoano4 = $this->o142_dataldoano4_ano."-".$this->o142_dataldoano4_mes."-".$this->o142_dataldoano4_dia;
        }
      }
       $this->o142_numeroloa = ($this->o142_numeroloa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_numeroloa"]:$this->o142_numeroloa);
       $this->o142_numeroloaano2 = ($this->o142_numeroloaano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano2"]:$this->o142_numeroloaano2);
       $this->o142_numeroloaano3 = ($this->o142_numeroloaano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano3"]:$this->o142_numeroloaano3);
       $this->o142_numeroloaano4 = ($this->o142_numeroloaano4 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano4"]:$this->o142_numeroloaano4);
       if($this->o142_dataloa == ""){
         $this->o142_dataloa_dia = ($this->o142_dataloa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"]:$this->o142_dataloa_dia);
         $this->o142_dataloa_mes = ($this->o142_dataloa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloa_mes"]:$this->o142_dataloa_mes);
         $this->o142_dataloa_ano = ($this->o142_dataloa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloa_ano"]:$this->o142_dataloa_ano);
         if($this->o142_dataloa_dia != ""){
            $this->o142_dataloa = $this->o142_dataloa_ano."-".$this->o142_dataloa_mes."-".$this->o142_dataloa_dia;
         }
       }
       if($this->o142_dataloaano2 == ""){
        $this->o142_dataloaano2_dia = ($this->o142_dataloaano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano2_dia"]:$this->o142_dataloaano2_dia);
        $this->o142_dataloaano2_mes = ($this->o142_dataloaano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano2_mes"]:$this->o142_dataloaano2_mes);
        $this->o142_dataloaano2_ano = ($this->o142_dataloaano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano2_ano"]:$this->o142_dataloaano2_ano);
        if($this->o142_dataloaano2_dia != ""){
           $this->o142_dataloaano2 = $this->o142_dataloaano2_ano."-".$this->o142_dataloaano2_mes."-".$this->o142_dataloaano2_dia;
        }
       }
       if($this->o142_dataloaano3 == ""){
        $this->o142_dataloaano3_dia = ($this->o142_dataloaano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano3_dia"]:$this->o142_dataloaano3_dia);
        $this->o142_dataloaano3_mes = ($this->o142_dataloaano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano3_mes"]:$this->o142_dataloaano3_mes);
        $this->o142_dataloaano3_ano = ($this->o142_dataloaano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano3_ano"]:$this->o142_dataloaano3_ano);
        if($this->o142_dataloaano3_dia != ""){
           $this->o142_dataloaano3 = $this->o142_dataloaano3_ano."-".$this->o142_dataloaano3_mes."-".$this->o142_dataloaano3_dia;
        }
       }
       if($this->o142_dataloaano4 == ""){
        $this->o142_dataloaano4_dia = ($this->o142_dataloaano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano4_dia"]:$this->o142_dataloaano4_dia);
        $this->o142_dataloaano4_mes = ($this->o142_dataloaano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano4_mes"]:$this->o142_dataloaano4_mes);
        $this->o142_dataloaano4_ano = ($this->o142_dataloaano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloaano4_ano"]:$this->o142_dataloaano4_ano);
        if($this->o142_dataloaano4_dia != ""){
           $this->o142_dataloaano4 = $this->o142_dataloaano4_ano."-".$this->o142_dataloaano4_mes."-".$this->o142_dataloaano4_dia;
        }
       }
       if($this->o142_datapubloa == ""){
         $this->o142_datapubloa_dia = ($this->o142_datapubloa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"]:$this->o142_datapubloa_dia);
         $this->o142_datapubloa_mes = ($this->o142_datapubloa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_mes"]:$this->o142_datapubloa_mes);
         $this->o142_datapubloa_ano = ($this->o142_datapubloa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_ano"]:$this->o142_datapubloa_ano);
         if($this->o142_datapubloa_dia != ""){
            $this->o142_datapubloa = $this->o142_datapubloa_ano."-".$this->o142_datapubloa_mes."-".$this->o142_datapubloa_dia;
         }
       }
       if($this->o142_datapubloaano2 == ""){
        $this->o142_datapubloaano2_dia = ($this->o142_datapubloaano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano2_dia"]:$this->o142_datapubloaano2_dia);
        $this->o142_datapubloaano2_mes = ($this->o142_datapubloaano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano2_mes"]:$this->o142_datapubloaano2_mes);
        $this->o142_datapubloaano2_ano = ($this->o142_datapubloaano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano2_ano"]:$this->o142_datapubloaano2_ano);
        if($this->o142_datapubloaano2_dia != ""){
           $this->o142_datapubloaano2 = $this->o142_datapubloaano2_ano."-".$this->o142_datapubloaano2_mes."-".$this->o142_datapubloaano2_dia;
        }
       }
       if($this->o142_datapubloaano3 == ""){
        $this->o142_datapubloaano3_dia = ($this->o142_datapubloaano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano3_dia"]:$this->o142_datapubloaano3_dia);
        $this->o142_datapubloaano3_mes = ($this->o142_datapubloaano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano3_mes"]:$this->o142_datapubloaano3_mes);
        $this->o142_datapubloaano3_ano = ($this->o142_datapubloaano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano3_ano"]:$this->o142_datapubloaano3_ano);
        if($this->o142_datapubloaano3_dia != ""){
           $this->o142_datapubloaano3 = $this->o142_datapubloaano3_ano."-".$this->o142_datapubloaano3_mes."-".$this->o142_datapubloaano3_dia;
        }
       }
       if($this->o142_datapubloaano4 == ""){
        $this->o142_datapubloaano4_dia = ($this->o142_datapubloaano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano4_dia"]:$this->o142_datapubloaano4_dia);
        $this->o142_datapubloaano4_mes = ($this->o142_datapubloaano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano4_mes"]:$this->o142_datapubloaano4_mes);
        $this->o142_datapubloaano4_ano = ($this->o142_datapubloaano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano4_ano"]:$this->o142_datapubloaano4_ano);
        if($this->o142_datapubloaano4_dia != ""){
           $this->o142_datapubloaano4 = $this->o142_datapubloaano4_ano."-".$this->o142_datapubloaano4_mes."-".$this->o142_datapubloaano4_dia;
        }
       }
       $this->o142_percsuplementacao = ($this->o142_percsuplementacao == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacao"]:$this->o142_percsuplementacao);
       $this->o142_percsuplementacaoano2 = ($this->o142_percsuplementacaoano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano2"]:$this->o142_percsuplementacaoano2);
       $this->o142_percsuplementacaoano3 = ($this->o142_percsuplementacaoano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano3"]:$this->o142_percsuplementacaoano3);
       $this->o142_percsuplementacaoano4 = ($this->o142_percsuplementacaoano4 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano4"]:$this->o142_percsuplementacaoano4);
       $this->o142_percaro = ($this->o142_percaro == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percaro"]:$this->o142_percaro);
       $this->o142_percaroano2 = ($this->o142_percaroano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percaroano2"]:$this->o142_percaroano2);
       $this->o142_percaroano3 = ($this->o142_percaroano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percaroano3"]:$this->o142_percaroano4);
       $this->o142_percaroano4 = ($this->o142_percaroano4 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percaroano4"]:$this->o142_percaroano4);
       $this->o142_percopercredito = ($this->o142_percopercredito == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percopercredito"]:$this->o142_percopercredito);
       $this->o142_percopercreditoano2 = ($this->o142_percopercreditoano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano2"]:$this->o142_percopercreditoano2);
       $this->o142_percopercreditoano3 = ($this->o142_percopercreditoano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano3"]:$this->o142_percopercreditoano3);
       $this->o142_percopercreditoano4 = ($this->o142_percopercreditoano4 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano4"]:$this->o142_percopercreditoano4);
       $this->o142_orcmodalidadeaplic = ($this->o142_orcmodalidadeaplic == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplic"]:$this->o142_orcmodalidadeaplic);
       $this->o142_orcmodalidadeaplicano2 = ($this->o142_orcmodalidadeaplicano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano2"]:$this->o142_orcmodalidadeaplicano2);
       $this->o142_orcmodalidadeaplicano3 = ($this->o142_orcmodalidadeaplicano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano3"]:$this->o142_orcmodalidadeaplicano3);
       $this->o142_orcmodalidadeaplicano4 = ($this->o142_orcmodalidadeaplicano4 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano4"]:$this->o142_orcmodalidadeaplicano4);
       $this->o142_leialteracaoldo = ($this->o142_leialteracaoldo == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldo"]:$this->o142_leialteracaoldo);
       $this->o142_leialteracaoldoano2 = ($this->o142_leialteracaoldoano2 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano2"]:$this->o142_leialteracaoldoano2);
       $this->o142_leialteracaoldoano3 = ($this->o142_leialteracaoldoano3 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano3"]:$this->o142_leialteracaoldoano3);
       $this->o142_leialteracaoldoano4 = ($this->o142_leialteracaoldoano4 == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano4"]:$this->o142_leialteracaoldoano4);
       if($this->o142_dataalteracaoldo == ""){
        $this->o142_dataalteracaoldo_dia = ($this->o142_dataalteracaoldo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldo_dia"]:$this->o142_dataalteracaoldo_dia);
        $this->o142_dataalteracaoldo_mes = ($this->o142_dataalteracaoldo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldo_mes"]:$this->o142_dataalteracaoldo_mes);
        $this->o142_dataalteracaoldo_ano = ($this->o142_dataalteracaoldo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldo_ano"]:$this->o142_dataalteracaoldo_ano);
        if($this->o142_dataalteracaoldo_dia != ""){
           $this->o142_dataalteracaoldo = $this->o142_dataalteracaoldo_ano."-".$this->o142_dataalteracaoldo_mes."-".$this->o142_dataalteracaoldo_dia;
        }
      }
      if($this->o142_dataalteracaoldoano2 == ""){
       $this->o142_dataalteracaoldoano2_dia = ($this->o142_dataalteracaoldoano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano2_dia"]:$this->o142_dataalteracaoldoano2_dia);
       $this->o142_dataalteracaoldoano2_mes = ($this->o142_dataalteracaoldoano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano2_mes"]:$this->o142_dataalteracaoldoano2_mes);
       $this->o142_dataalteracaoldoano2_ano = ($this->o142_dataalteracaoldoano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano2_ano"]:$this->o142_dataalteracaoldoano2_ano);
       if($this->o142_dataalteracaoldoano2_dia != ""){
          $this->o142_dataalteracaoldoano2 = $this->o142_dataalteracaoldoano2_ano."-".$this->o142_dataalteracaoldoano2_mes."-".$this->o142_dataalteracaoldoano2_dia;
       }
      }
      if($this->o142_dataalteracaoldoano3 == ""){
       $this->o142_dataalteracaoldoano3_dia = ($this->o142_dataalteracaoldoano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano3_dia"]:$this->o142_dataalteracaoldoano3_dia);
       $this->o142_dataalteracaoldoano3_mes = ($this->o142_dataalteracaoldoano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano3_mes"]:$this->o142_dataalteracaoldoano3_mes);
       $this->o142_dataalteracaoldoano3_ano = ($this->o142_dataalteracaoldoano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano3_ano"]:$this->o142_dataalteracaoldoano3_ano);
       if($this->o142_dataalteracaoldoano3_dia != ""){
          $this->o142_dataalteracaoldoano3 = $this->o142_dataalteracaoldoano3_ano."-".$this->o142_dataalteracaoldoano3_mes."-".$this->o142_dataalteracaoldoano3_dia;
       }
      }
      if($this->o142_dataalteracaoldoano4 == ""){
       $this->o142_dataalteracaoldoano4_dia = ($this->o142_dataalteracaoldoano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano4_dia"]:$this->o142_dataalteracaoldoano4_dia);
       $this->o142_dataalteracaoldoano4_mes = ($this->o142_dataalteracaoldoano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano4_mes"]:$this->o142_dataalteracaoldoano4_mes);
       $this->o142_dataalteracaoldoano4_ano = ($this->o142_dataalteracaoldoano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano4_ano"]:$this->o142_dataalteracaoldoano4_ano);
       if($this->o142_dataalteracaoldoano4_dia != ""){
          $this->o142_dataalteracaoldoano4 = $this->o142_dataalteracaoldoano4_ano."-".$this->o142_dataalteracaoldoano4_mes."-".$this->o142_dataalteracaoldoano4_dia;
       }
      }
      if($this->o142_datapubalteracaoldo == ""){
        $this->o142_datapubalteracaoldo_dia = ($this->o142_datapubalteracaoldo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldo_dia"]:$this->o142_datapubalteracaoldo_dia);
        $this->o142_datapubalteracaoldo_mes = ($this->o142_datapubalteracaoldo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldo_mes"]:$this->o142_datapubalteracaoldo_mes);
        $this->o142_datapubalteracaoldo_ano = ($this->o142_datapubalteracaoldo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldo_ano"]:$this->o142_datapubalteracaoldo_ano);
        if($this->o142_datapubalteracaoldo_dia != ""){
           $this->o142_datapubalteracaoldo = $this->o142_datapubalteracaoldo_ano."-".$this->o142_datapubalteracaoldo_mes."-".$this->o142_datapubalteracaoldo_dia;
        }
      }
      if($this->o142_datapubalteracaoldoano2 == ""){
       $this->o142_datapubalteracaoldoano2_dia = ($this->o142_datapubalteracaoldoano2_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano2_dia"]:$this->o142_datapubalteracaoldoano2_dia);
       $this->o142_datapubalteracaoldoano2_mes = ($this->o142_datapubalteracaoldoano2_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano2_mes"]:$this->o142_datapubalteracaoldoano2_mes);
       $this->o142_datapubalteracaoldoano2_ano = ($this->o142_datapubalteracaoldoano2_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano2_ano"]:$this->o142_datapubalteracaoldoano2_ano);
       if($this->o142_datapubalteracaoldoano2_dia != ""){
          $this->o142_datapubalteracaoldoano2 = $this->o142_datapubalteracaoldoano2_ano."-".$this->o142_datapubalteracaoldoano2_mes."-".$this->o142_datapubalteracaoldoano2_dia;
       }
     }
     if($this->o142_datapubalteracaoldoano3 == ""){
       $this->o142_datapubalteracaoldoano3_dia = ($this->o142_datapubalteracaoldoano3_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano3_dia"]:$this->o142_datapubalteracaoldoano3_dia);
       $this->o142_datapubalteracaoldoano3_mes = ($this->o142_datapubalteracaoldoano3_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano3_mes"]:$this->o142_datapubalteracaoldoano3_mes);
       $this->o142_datapubalteracaoldoano3_ano = ($this->o142_datapubalteracaoldoano3_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano3_ano"]:$this->o142_datapubalteracaoldoano3_ano);
       if($this->o142_datapubalteracaoldoano3_dia != ""){
          $this->o142_datapubalteracaoldoano3 = $this->o142_datapubalteracaoldoano3_ano."-".$this->o142_datapubalteracaoldoano3_mes."-".$this->o142_datapubalteracaoldoano3_dia;
       }
     }
     if($this->o142_datapubalteracaoldoano4 == ""){
       $this->o142_datapubalteracaoldoano4_dia = ($this->o142_datapubalteracaoldoano4_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano4_dia"]:$this->o142_datapubalteracaoldoano4_dia);
       $this->o142_datapubalteracaoldoano4_mes = ($this->o142_datapubalteracaoldoano4_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano4_mes"]:$this->o142_datapubalteracaoldoano4_mes);
       $this->o142_datapubalteracaoldoano4_ano = ($this->o142_datapubalteracaoldoano4_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano4_ano"]:$this->o142_datapubalteracaoldoano4_ano);
       if($this->o142_datapubalteracaoldoano4_dia != ""){
          $this->o142_datapubalteracaoldoano4 = $this->o142_datapubalteracaoldoano4_ano."-".$this->o142_datapubalteracaoldoano4_mes."-".$this->o142_datapubalteracaoldoano4_dia;
       }
     }
      }else{
       $this->o142_sequencial = ($this->o142_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_sequencial"]:$this->o142_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($o142_sequencial){ 
      $this->atualizacampos();
     if($this->o142_ppalei == null ){ 
       $this->erro_sql = " Campo Código da Lei do PPA nao Informado.";
       $this->erro_campo = "o142_ppalei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o142_percsuplementacao == null ){ 
      $this->o142_percsuplementacao = "null";
     }
     if($this->o142_percsuplementacaoano2 == null ){ 
      $this->o142_percsuplementacaoano2 = "null";
     }
     if($this->o142_percsuplementacaoano3 == null ){ 
      $this->o142_percsuplementacaoano3 = "null";
     }
     if($this->o142_percsuplementacaoano4 == null ){ 
      $this->o142_percsuplementacaoano4 = "null";
     }
     if($this->o142_percaro == null ){ 
      $this->o142_percaro = "null";
     }
     if($this->o142_percaroano2 == null ){ 
      $this->o142_percaroano2 = "null";
     }
     if($this->o142_percaroano3 == null ){ 
      $this->o142_percaroano3 = "null";
     }
     if($this->o142_percaroano4 == null ){ 
      $this->o142_percaroano4 = "null";
     }
     if($this->o142_percopercredito == null ){ 
      $this->o142_percopercredito = "null";
     }
     if($this->o142_percopercreditoano2 == null ){ 
      $this->o142_percopercreditoano2 = "null";
     }
     if($this->o142_percopercreditoano3 == null ){ 
      $this->o142_percopercreditoano3 = "null";
     }
     if($this->o142_percopercreditoano4 == null ){ 
      $this->o142_percopercreditoano4 = "null";
     }
     if($this->o142_anoinicialppa == null ){ 
       $this->o142_anoinicialppa = "0";
     }
     if($this->o142_anofinalppa == null ){ 
       $this->o142_anofinalppa = "0";
     }
     if($this->o142_dataleippa == null ){ 
       $this->o142_dataleippa = "null";
     }
    if($this->o142_datapublicacaoppa == null ){ 
      $this->o142_datapublicacaoppa = "null";
     }
    if($this->o142_dataalteracaoppa == null ){ 
      $this->o142_dataalteracaoppa = "null";
    }
    if($this->o142_dataalteracaoppaano2 == null ){ 
      $this->o142_dataalteracaoppaano2 = "null";
    }
    if($this->o142_dataalteracaoppaano3 == null ){ 
      $this->o142_dataalteracaoppaano3 = "null";
    }
    if($this->o142_dataalteracaoppaano4 == null ){ 
      $this->o142_dataalteracaoppaano4 = "null";
    }
    if($this->o142_datapubalteracao == null ){ 
       $this->o142_datapubalteracao = "null";
    }
    if($this->o142_datapubalteracaoano2 == null ){ 
      $this->o142_datapubalteracaoano2 = "null";
    }
    if($this->o142_datapubalteracaoano3 == null ){ 
      $this->o142_datapubalteracaoano3 = "null";
    }
    if($this->o142_datapubalteracaoano4 == null ){ 
      $this->o142_datapubalteracaoano4 = "null";
    }
    if($this->o142_datapublicacaoldo == null ){ 
       $this->o142_datapublicacaoldo = "null";
    }
    if($this->o142_datapublicacaoldoano2 == null ){ 
      $this->o142_datapublicacaoldoano2 = "null";
    }
    if($this->o142_datapublicacaoldoano3 == null ){ 
      $this->o142_datapublicacaoldoano3 = "null";
    }
    if($this->o142_datapublicacaoldoano4 == null ){ 
      $this->o142_datapublicacaoldoano4 = "null";
    }
    if($this->o142_dataldo == null ){ 
       $this->o142_dataldo = "null";
    }
    if($this->o142_dataldoano2 == null ){ 
      $this->o142_dataldoano2 = "null";
    }
    if($this->o142_dataldoano3 == null ){ 
      $this->o142_dataldoano3 = "null";
    }
    if($this->o142_dataldoano4 == null ){ 
      $this->o142_dataldoano4 = "null";
    }
    if($this->o142_dataloa == null ){ 
       $this->o142_dataloa = "null";
    }
    if($this->o142_dataloaano2 == null ){ 
      $this->o142_dataloaano2 = "null";
    }
    if($this->o142_dataloaano3 == null ){ 
      $this->o142_dataloaano3 = "null";
    }
    if($this->o142_dataloaano4 == null ){ 
      $this->o142_dataloaano4 = "null";
    }
    if($this->o142_datapubloa == null ){ 
       $this->o142_datapubloa = "null";
    }
    if($this->o142_datapubloaano2 == null ){ 
      $this->o142_datapubloaano2 = "null";
    }
    if($this->o142_datapubloaano3 == null ){ 
      $this->o142_datapubloaano3 = "null";
    }
    if($this->o142_datapubloaano4 == null ){ 
      $this->o142_datapubloaano4 = "null";
    }
    if($this->o142_dataalteracaoldo == null ){ 
      $this->o142_dataalteracaoldo = "null";
    }
    if($this->o142_dataalteracaoldoano2 == null ){ 
     $this->o142_dataalteracaoldoano2 = "null";
    }
    if($this->o142_dataalteracaoldoano3 == null ){ 
     $this->o142_dataalteracaoldoano3 = "null";
    }
    if($this->o142_dataalteracaoldoano4 == null ){ 
     $this->o142_dataalteracaoldoano4 = "null";
    }
    if($this->o142_datapubalteracaoldo == null ){ 
      $this->o142_datapubalteracaoldo = "null";
    }
    if($this->o142_datapubalteracaoldoano2 == null ){ 
     $this->o142_datapubalteracaoldoano2 = "null";
   }
   if($this->o142_datapubalteracaoldoano3 == null ){ 
     $this->o142_datapubalteracaoldoano3 = "null";
   }
   if($this->o142_datapubalteracaoldoano4 == null ){ 
     $this->o142_datapubalteracaoldoano4 = "null";
   }
     if($this->o142_datapubalteracaoldo == null ){ 
       $this->o142_datapubalteracaoldo = "null";
     }
     if($this->o142_datapubalteracaoldoano2 == null ){ 
      $this->o142_datapubalteracaoldoano2 = "null";
    }
    if($this->o142_datapubalteracaoldoano3 == null ){ 
      $this->o142_datapubalteracaoldoano3 = "null";
    }
    if($this->o142_datapubalteracaoldoano4 == null ){ 
      $this->o142_datapubalteracaoldoano4 = "null";
    }
    if($o142_sequencial == "" || $o142_sequencial == null ){
       $result = db_query("select nextval('ppaleidadocomplementar_o142_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ppaleidadocomplementar_o142_sequencial_seq do campo: o142_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->o142_sequencial = pg_result($result,0,0); 
    }else{
       $result = db_query("select last_value from ppaleidadocomplementar_o142_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $o142_sequencial)){
         $this->erro_sql = " Campo o142_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->o142_sequencial = $o142_sequencial; 
       }
    }
    if(($this->o142_sequencial == null) || ($this->o142_sequencial == "") ){ 
       $this->erro_sql = " Campo o142_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }   
     $sql = "insert into ppaleidadocomplementar(
                                       o142_sequencial 
                                      ,o142_ppalei 
                                      ,o142_anoinicialppa 
                                      ,o142_anofinalppa 
                                      ,o142_numeroleippa 
                                      ,o142_dataleippa 
                                      ,o142_datapublicacaoppa 
                                      ,o142_leialteracaoppa 
                                      ,o142_leialteracaoppaano2
                                      ,o142_leialteracaoppaano3
                                      ,o142_leialteracaoppaano4
                                      ,o142_dataalteracaoppa 
                                      ,o142_dataalteracaoppaano2
                                      ,o142_dataalteracaoppaano3
                                      ,o142_dataalteracaoppaano4
                                      ,o142_datapubalteracao 
                                      ,o142_datapubalteracaoano2
                                      ,o142_datapubalteracaoano3
                                      ,o142_datapubalteracaoano4
                                      ,o142_datapublicacaoldo
                                      ,o142_datapublicacaoldoano2
                                      ,o142_datapublicacaoldoano3
                                      ,o142_datapublicacaoldoano4 
                                      ,o142_dataldo 
                                      ,o142_dataldoano2
                                      ,o142_dataldoano3
                                      ,o142_dataldoano4
                                      ,o142_numeroloa 
                                      ,o142_numeroloaano2
                                      ,o142_numeroloaano3
                                      ,o142_numeroloaano4
                                      ,o142_dataloa 
                                      ,o142_dataloaano2
                                      ,o142_dataloaano3
                                      ,o142_dataloaano4
                                      ,o142_datapubloa 
                                      ,o142_datapubloaano2
                                      ,o142_datapubloaano3
                                      ,o142_datapubloaano4
                                      ,o142_percsuplementacao 
                                      ,o142_percsuplementacaoano2
                                      ,o142_percsuplementacaoano3
                                      ,o142_percsuplementacaoano4
                                      ,o142_percaro 
                                      ,o142_percaroano2
                                      ,o142_percaroano3
                                      ,o142_percaroano4
                                      ,o142_percopercredito 
                                      ,o142_percopercreditoano2
                                      ,o142_percopercreditoano3
                                      ,o142_percopercreditoano4
                                      ,o142_orcmodalidadeaplic
                                      ,o142_orcmodalidadeaplicano2
                                      ,o142_orcmodalidadeaplicano3
                                      ,o142_orcmodalidadeaplicano4
                                      ,o142_leialteracaoldo 
                                      ,o142_leialteracaoldoano2
                                      ,o142_leialteracaoldoano3
                                      ,o142_leialteracaoldoano4
                                      ,o142_dataalteracaoldo 
                                      ,o142_dataalteracaoldoano2
                                      ,o142_dataalteracaoldoano3
                                      ,o142_dataalteracaoldoano4
                                      ,o142_datapubalteracaoldo 
                                      ,o142_datapubalteracaoldoano2
                                      ,o142_datapubalteracaoldoano3
                                      ,o142_datapubalteracaoldoano4
                       )
                values (
                                $this->o142_sequencial 
                               ,$this->o142_ppalei 
                               ,$this->o142_anoinicialppa 
                               ,$this->o142_anofinalppa 
                               ,'$this->o142_numeroleippa' 
                               ,".($this->o142_dataleippa == "null" || $this->o142_dataleippa == ""?"null":"'".$this->o142_dataleippa."'")." 
                               ,".($this->o142_datapublicacaoppa == "null" || $this->o142_datapublicacaoppa == ""?"null":"'".$this->o142_datapublicacaoppa."'")." 
                               ,'$this->o142_leialteracaoppa' 
                               ,'$this->o142_leialteracaoppaano2' 
                               ,'$this->o142_leialteracaoppaano3' 
                               ,'$this->o142_leialteracaoppaano4' 
                               ,".($this->o142_dataalteracaoppa == "null" || $this->o142_dataalteracaoppa == ""?"null":"'".$this->o142_dataalteracaoppa."'")." 
                               ,".($this->o142_dataalteracaoppaano2 == "null" || $this->o142_dataalteracaoppaano2 == ""?"null":"'".$this->o142_dataalteracaoppaano2."'")." 
                               ,".($this->o142_dataalteracaoppaano3 == "null" || $this->o142_dataalteracaoppaano3 == ""?"null":"'".$this->o142_dataalteracaoppaano3."'")." 
                               ,".($this->o142_dataalteracaoppaano4 == "null" || $this->o142_dataalteracaoppaano4 == ""?"null":"'".$this->o142_dataalteracaoppaano4."'")." 
                               ,".($this->o142_datapubalteracao == "null" || $this->o142_datapubalteracao == ""?"null":"'".$this->o142_datapubalteracao."'")." 
                               ,".($this->o142_datapubalteracaoano2 == "null" || $this->o142_datapubalteracaoano2 == ""?"null":"'".$this->o142_datapubalteracaoano2."'")." 
                               ,".($this->o142_datapubalteracaoano3 == "null" || $this->o142_datapubalteracaoano3 == ""?"null":"'".$this->o142_datapubalteracaoano3."'")." 
                               ,".($this->o142_datapubalteracaoano4 == "null" || $this->o142_datapubalteracaoano4 == ""?"null":"'".$this->o142_datapubalteracaoano4."'")." 
                               ,".($this->o142_datapublicacaoldo == "null" || $this->o142_datapublicacaoldo == ""?"null":"'".$this->o142_datapublicacaoldo."'")." 
                               ,".($this->o142_datapublicacaoldoano2 == "null" || $this->o142_datapublicacaoldoano2 == ""?"null":"'".$this->o142_datapublicacaoldoano2."'")." 
                               ,".($this->o142_datapublicacaoldoano3 == "null" || $this->o142_datapublicacaoldoano3 == ""?"null":"'".$this->o142_datapublicacaoldoano3."'")."
                               ,".($this->o142_datapublicacaoldoano4 == "null" || $this->o142_datapublicacaoldoano4 == ""?"null":"'".$this->o142_datapublicacaoldoano4."'")."  
                               ,".($this->o142_dataldo == "null" || $this->o142_dataldo == ""?"null":"'".$this->o142_dataldo."'")." 
                               ,".($this->o142_dataldoano2 == "null" || $this->o142_dataldoano2 == ""?"null":"'".$this->o142_dataldoano2."'")." 
                               ,".($this->o142_dataldoano3 == "null" || $this->o142_dataldoano3 == ""?"null":"'".$this->o142_dataldoano3."'")." 
                               ,".($this->o142_dataldoano4 == "null" || $this->o142_dataldoano4 == ""?"null":"'".$this->o142_dataldoano4."'")." 
                               ,'$this->o142_numeroloa' 
                               ,'$this->o142_numeroloaano2' 
                               ,'$this->o142_numeroloaano3' 
                               ,'$this->o142_numeroloaano4' 
                               ,".($this->o142_dataloa == "null" || $this->o142_dataloa == ""?"null":"'".$this->o142_dataloa."'")." 
                               ,".($this->o142_dataloaano2 == "null" || $this->o142_dataloaano2 == ""?"null":"'".$this->o142_dataloaano2."'")." 
                               ,".($this->o142_dataloaano3 == "null" || $this->o142_dataloaano3 == ""?"null":"'".$this->o142_dataloaano3."'")." 
                               ,".($this->o142_dataloaano4 == "null" || $this->o142_dataloaano4 == ""?"null":"'".$this->o142_dataloaano4."'")." 
                               ,".($this->o142_datapubloa == "null" || $this->o142_datapubloa == ""?"null":"'".$this->o142_datapubloa."'")." 
                               ,".($this->o142_datapubloaano2 == "null" || $this->o142_datapubloaano2 == ""?"null":"'".$this->o142_datapubloaano2."'")."
                               ,".($this->o142_datapubloaano3 == "null" || $this->o142_datapubloaano3 == ""?"null":"'".$this->o142_datapubloaano3."'")."
                               ,".($this->o142_datapubloaano4 == "null" || $this->o142_datapubloaano4 == ""?"null":"'".$this->o142_datapubloaano4."'")."
                               ,$this->o142_percsuplementacao
                               ,$this->o142_percsuplementacaoano2 
                               ,$this->o142_percsuplementacaoano3 
                               ,$this->o142_percsuplementacaoano4  
                               ,$this->o142_percaro
                               ,$this->o142_percaroano2
                               ,$this->o142_percaroano3
                               ,$this->o142_percaroano4
                               ,$this->o142_percopercredito 
                               ,$this->o142_percopercreditoano2
                               ,$this->o142_percopercreditoano3
                               ,$this->o142_percopercreditoano4
                               ,".($this->o142_orcmodalidadeaplic == "null" || $this->o142_orcmodalidadeaplic == ""? 'NULL' :"'".$this->o142_orcmodalidadeaplic."'")."
                               ,".($this->o142_orcmodalidadeaplicano2 == "null" || $this->o142_orcmodalidadeaplicano2 == ""? 'NULL' :"'".$this->o142_orcmodalidadeaplicano2."'")."
                               ,".($this->o142_orcmodalidadeaplicano3 == "null" || $this->o142_orcmodalidadeaplicano3 == ""? 'NULL' :"'".$this->o142_orcmodalidadeaplicano3."'")."
                               ,".($this->o142_orcmodalidadeaplicano4 == "null" || $this->o142_orcmodalidadeaplicano4 == ""? 'NULL' :"'".$this->o142_orcmodalidadeaplicano4."'")." 
                               ,'$this->o142_leialteracaoldo' 
                               ,'$this->o142_leialteracaoldoano2' 
                               ,'$this->o142_leialteracaoldoano3' 
                               ,'$this->o142_leialteracaoldoano4'
                               ,".($this->o142_dataalteracaoldo == "null" || $this->o142_dataalteracaoldo == ""?"null":"'".$this->o142_dataalteracaoldo."'")." 
                               ,".($this->o142_dataalteracaoldoano2 == "null" || $this->o142_dataalteracaoldoano2 == ""?"null":"'".$this->o142_dataalteracaoldoano2."'")." 
                               ,".($this->o142_dataalteracaoldoano3 == "null" || $this->o142_dataalteracaoldoano3 == ""?"null":"'".$this->o142_dataalteracaoldoano3."'")." 
                               ,".($this->o142_dataalteracaoldoano4 == "null" || $this->o142_dataalteracaoldoano4 == ""?"null":"'".$this->o142_dataalteracaoldoano4."'")." 
                               ,".($this->o142_datapubalteracaoldo == "null" || $this->o142_datapubalteracaoldo == ""?"null":"'".$this->o142_datapubalteracaoldo."'")." 
                               ,".($this->o142_datapubalteracaoldoano2 == "null" || $this->o142_datapubalteracaoldoano2 == ""?"null":"'".$this->o142_datapubalteracaoldoano2."'")." 
                               ,".($this->o142_datapubalteracaoldoano3 == "null" || $this->o142_datapubalteracaoldoano3 == ""?"null":"'".$this->o142_datapubalteracaoldoano3."'")." 
                               ,".($this->o142_datapubalteracaoldoano4 == "null" || $this->o142_datapubalteracaoldoano4 == ""?"null":"'".$this->o142_datapubalteracaoldoano4."'")." 
                            )";
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dados complementares do ppa ($this->o142_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dados complementares do ppa já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dados complementares do ppa ($this->o142_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->o142_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,18403,'$this->o142_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,3257,18403,'','".AddSlashes(pg_result($resaco,0,'o142_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18404,'','".AddSlashes(pg_result($resaco,0,'o142_ppalei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18405,'','".AddSlashes(pg_result($resaco,0,'o142_anoinicialppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18406,'','".AddSlashes(pg_result($resaco,0,'o142_anofinalppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18407,'','".AddSlashes(pg_result($resaco,0,'o142_numeroleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18408,'','".AddSlashes(pg_result($resaco,0,'o142_dataleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18409,'','".AddSlashes(pg_result($resaco,0,'o142_datapublicacaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18410,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18411,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18412,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18413,'','".AddSlashes(pg_result($resaco,0,'o142_datapublicacaoldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18414,'','".AddSlashes(pg_result($resaco,0,'o142_dataldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18415,'','".AddSlashes(pg_result($resaco,0,'o142_numeroloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18416,'','".AddSlashes(pg_result($resaco,0,'o142_dataloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18417,'','".AddSlashes(pg_result($resaco,0,'o142_datapubloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18418,'','".AddSlashes(pg_result($resaco,0,'o142_percsuplementacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18419,'','".AddSlashes(pg_result($resaco,0,'o142_percaro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18420,'','".AddSlashes(pg_result($resaco,0,'o142_percopercredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18421,'','".AddSlashes(pg_result($resaco,0,'o142_numeroloaano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18422,'','".AddSlashes(pg_result($resaco,0,'o142_numeroloaano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18423,'','".AddSlashes(pg_result($resaco,0,'o142_numeroloaano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18424,'','".AddSlashes(pg_result($resaco,0,'o142_dataldoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18425,'','".AddSlashes(pg_result($resaco,0,'o142_dataldoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18426,'','".AddSlashes(pg_result($resaco,0,'o142_dataldoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18427,'','".AddSlashes(pg_result($resaco,0,'o142_datapublicacaoldoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18428,'','".AddSlashes(pg_result($resaco,0,'o142_datapublicacaoldoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18429,'','".AddSlashes(pg_result($resaco,0,'o142_datapublicacaoldoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18430,'','".AddSlashes(pg_result($resaco,0,'o142_dataloaano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18431,'','".AddSlashes(pg_result($resaco,0,'o142_dataloaano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18432,'','".AddSlashes(pg_result($resaco,0,'o142_dataloaano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18433,'','".AddSlashes(pg_result($resaco,0,'o142_datapubloaano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18434,'','".AddSlashes(pg_result($resaco,0,'o142_datapubloaano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18435,'','".AddSlashes(pg_result($resaco,0,'o142_datapubloaano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18436,'','".AddSlashes(pg_result($resaco,0,'o142_percsuplementacaoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18437,'','".AddSlashes(pg_result($resaco,0,'o142_percsuplementacaoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18438,'','".AddSlashes(pg_result($resaco,0,'o142_percsuplementacaoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18439,'','".AddSlashes(pg_result($resaco,0,'o142_percaroano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18440,'','".AddSlashes(pg_result($resaco,0,'o142_percaroano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18441,'','".AddSlashes(pg_result($resaco,0,'o142_percaroano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18442,'','".AddSlashes(pg_result($resaco,0,'o142_percopercreditoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18443,'','".AddSlashes(pg_result($resaco,0,'o142_percopercreditoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18444,'','".AddSlashes(pg_result($resaco,0,'o142_percopercreditoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18445,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoppaano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18446,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoppaano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18447,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoppaano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18448,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoppaano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18449,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoppaano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18450,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoppaano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18451,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracaoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18452,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracaoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18453,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracaoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18454,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18455,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoldoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18456,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoldoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18457,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoldoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18458,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18459,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoldoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18460,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoldoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18461,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoldoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18462,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracaoldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18463,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracaoldoano2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18464,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracaoldoano3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18465,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracaoldoano4'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o142_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ppaleidadocomplementar set ";
     $virgula = "";
     if(trim($this->o142_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_sequencial"])){ 
       $sql  .= $virgula." o142_sequencial = $this->o142_sequencial ";
       $virgula = ",";
       if(trim($this->o142_sequencial) == null ){ 
         $this->erro_sql = " Campo Codigo Sequencial nao Informado.";
         $this->erro_campo = "o142_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o142_ppalei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_ppalei"])){ 
       $sql  .= $virgula." o142_ppalei = $this->o142_ppalei ";
       $virgula = ",";
       if(trim($this->o142_ppalei) == null ){ 
         $this->erro_sql = " Campo Código da Lei do PPA nao Informado.";
         $this->erro_campo = "o142_ppalei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o142_anoinicialppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"])){ 
        if(trim($this->o142_anoinicialppa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"])){ 
           $this->o142_anoinicialppa = "0" ; 
        } 
       $sql  .= $virgula." o142_anoinicialppa = $this->o142_anoinicialppa ";
       $virgula = ",";
     }
     if(trim($this->o142_anofinalppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"])){ 
        if(trim($this->o142_anofinalppa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"])){ 
           $this->o142_anofinalppa = "0" ; 
        } 
       $sql  .= $virgula." o142_anofinalppa = $this->o142_anofinalppa ";
       $virgula = ",";
     }
     if(trim($this->o142_numeroleippa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroleippa"])){ 
       $sql  .= $virgula." o142_numeroleippa = '$this->o142_numeroleippa' ";
       $virgula = ",";
     }
     if(trim($this->o142_dataleippa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataleippa = '$this->o142_dataleippa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"])){ 
         $sql  .= $virgula." o142_dataleippa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_datapublicacaoppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapublicacaoppa = '$this->o142_datapublicacaoppa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"])){ 
         $sql  .= $virgula." o142_datapublicacaoppa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_leialteracaoppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppa"])){ 
       $sql  .= $virgula." o142_leialteracaoppa = '$this->o142_leialteracaoppa' ";
       $virgula = ",";
     }
     if(trim($this->o142_leialteracaoppaano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano2"])){ 
      $sql  .= $virgula." o142_leialteracaoppaano2 = '$this->o142_leialteracaoppaano2' ";
      $virgula = ",";
    }
    if(trim($this->o142_leialteracaoppaano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano3"])){ 
      $sql  .= $virgula." o142_leialteracaoppaano3 = '$this->o142_leialteracaoppaano3' ";
      $virgula = ",";
    }
    if(trim($this->o142_leialteracaoppaano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano4"])){ 
      $sql  .= $virgula." o142_leialteracaoppaano4 = '$this->o142_leialteracaoppaano4' ";
      $virgula = ",";
    }
    if(trim($this->o142_dataalteracaoppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataalteracaoppa = '$this->o142_dataalteracaoppa' ";
       $virgula = ",";
    }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"])){ 
         $sql  .= $virgula." o142_dataalteracaoppa = null ";
         $virgula = ",";
       }
    }
    if(trim($this->o142_dataalteracaoppaano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataalteracaoppaano2 = '$this->o142_dataalteracaoppaano2' ";
      $virgula = ",";
    }
    if(trim($this->o142_dataalteracaoppaano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataalteracaoppaano3 = '$this->o142_dataalteracaoppaano3' ";
      $virgula = ",";
    }
    if(trim($this->o142_dataalteracaoppaano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataalteracaoppaano4 = '$this->o142_dataalteracaoppaano4' ";
      $virgula = ",";
    }
    if(trim($this->o142_datapubalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapubalteracao = '$this->o142_datapubalteracao' ";
       $virgula = ",";
    }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"])){ 
         $sql  .= $virgula." o142_datapubalteracao = null ";
         $virgula = ",";
       }
     }
    if(trim($this->o142_datapubalteracaoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubalteracaoano2 = '$this->o142_datapubalteracaoano2' ";
      $virgula = ",";
    }
    if(trim($this->o142_datapubalteracaoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubalteracaoano3 = '$this->o142_datapubalteracaoano3' ";
      $virgula = ",";
    }
    if(trim($this->o142_datapubalteracaoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubalteracaoano4 = '$this->o142_datapubalteracaoano4' ";
      $virgula = ",";
   }   
     if(trim($this->o142_datapublicacaoldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapublicacaoldo = '$this->o142_datapublicacaoldo' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"])){ 
         $sql  .= $virgula." o142_datapublicacaoldo = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_datapublicacaoldoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapublicacaoldoano2 = '$this->o142_datapublicacaoldoano2' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano2_dia"])){ 
        $sql  .= $virgula." o142_datapublicacaoldoano2 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_datapublicacaoldoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapublicacaoldoano3 = '$this->o142_datapublicacaoldoano3' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano3_dia"])){ 
        $sql  .= $virgula." o142_datapublicacaoldoano3 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_datapublicacaoldoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapublicacaoldoano4 = '$this->o142_datapublicacaoldoano4' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano4_dia"])){ 
        $sql  .= $virgula." o142_datapublicacaoldoano4 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_dataldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataldo = '$this->o142_dataldo' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"])){ 
         $sql  .= $virgula." o142_dataldo = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_dataldoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataldoano2 = '$this->o142_dataldoano2' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano2_dia"])){ 
        $sql  .= $virgula." o142_dataldoano2 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_dataldoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataldoano3 = '$this->o142_dataldoano3' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano3_dia"])){ 
        $sql  .= $virgula." o142_dataldoano3 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_dataldoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataldoano4 = '$this->o142_dataldoano4' ";
      $virgula = ",";
     }     else{ 
     if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano4_dia"])){ 
        $sql  .= $virgula." o142_dataldoano4 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_numeroloa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloa"])){ 
       $sql  .= $virgula." o142_numeroloa = '$this->o142_numeroloa' ";
       $virgula = ",";
     }
     if(trim($this->o142_numeroloaano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano2"])){ 
      $sql  .= $virgula." o142_numeroloaano2 = '$this->o142_numeroloaano2' ";
      $virgula = ",";
     }
     if(trim($this->o142_numeroloaano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano3"])){ 
      $sql  .= $virgula." o142_numeroloaano3 = '$this->o142_numeroloaano3' ";
      $virgula = ",";
     }
     if(trim($this->o142_numeroloaano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano4"])){ 
      $sql  .= $virgula." o142_numeroloaano4 = '$this->o142_numeroloaano4' ";
      $virgula = ",";
     }
     if(trim($this->o142_dataloa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataloa = '$this->o142_dataloa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"])){ 
         $sql  .= $virgula." o142_dataloa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_dataloaano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataloaano2 = '$this->o142_dataloaano2' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano2_dia"])){ 
        $sql  .= $virgula." o142_dataloaano2 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_dataloaano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataloaano3 = '$this->o142_dataloaano3' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano3_dia"])){ 
        $sql  .= $virgula." o142_dataloaano3 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_dataloaano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataloaano4 = '$this->o142_dataloaano4' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano4_dia"])){ 
        $sql  .= $virgula." o142_dataloaano4 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_datapubloa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapubloa = '$this->o142_datapubloa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"])){ 
         $sql  .= $virgula." o142_datapubloa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_datapubloaano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubloaano2 = '$this->o142_datapubloaano2' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano2_dia"])){ 
        $sql  .= $virgula." o142_datapubloaano2 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_datapubloaano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubloaano3 = '$this->o142_datapubloaano3' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano3_dia"])){ 
        $sql  .= $virgula." o142_datapubloaano3 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_datapubloaano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubloaano4 = '$this->o142_datapubloaano4' ";
      $virgula = ",";
     }     else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano4_dia"])){ 
        $sql  .= $virgula." o142_datapubloaano4 = null ";
        $virgula = ",";
      }
     }
     if(trim($this->o142_percsuplementacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacao"])){ 
       $sql  .= $virgula." o142_percsuplementacao = $this->o142_percsuplementacao ";
       $virgula = ",";
     }
     if(trim($this->o142_percsuplementacaoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano2"])){ 
      $sql  .= $virgula." o142_percsuplementacaoano2 = $this->o142_percsuplementacaoano2 ";
      $virgula = ",";
     }
     if(trim($this->o142_percsuplementacaoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano3"])){ 
      $sql  .= $virgula." o142_percsuplementacaoano3 = $this->o142_percsuplementacaoano3 ";
      $virgula = ",";
     }
     if(trim($this->o142_percsuplementacaoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano4"])){ 
      $sql  .= $virgula." o142_percsuplementacaoano4 = $this->o142_percsuplementacaoano4 ";
      $virgula = ",";
     }
     if(trim($this->o142_percaro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percaro"])){ 
       $sql  .= $virgula." o142_percaro = $this->o142_percaro ";
       $virgula = ",";
     }
     if(trim($this->o142_percaroano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percaroano2"])){ 
      $sql  .= $virgula." o142_percaroano2 = $this->o142_percaroano2 ";
      $virgula = ",";
     }
     if(trim($this->o142_percaroano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percaroano3"])){ 
      $sql  .= $virgula." o142_percaroano3 = $this->o142_percaroano3 ";
      $virgula = ",";
     }
     if(trim($this->o142_percaroano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percaroano4"])){ 
      $sql  .= $virgula." o142_percaroano4 = $this->o142_percaroano4 ";
      $virgula = ",";
    }
     if(trim($this->o142_percopercredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercredito"])){ 
       $sql  .= $virgula." o142_percopercredito = $this->o142_percopercredito ";
       $virgula = ",";
     }
     if(trim($this->o142_percopercreditoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano2"])){ 
      $sql  .= $virgula." o142_percopercreditoano2 = $this->o142_percopercreditoano2 ";
      $virgula = ",";
    }
    if(trim($this->o142_percopercreditoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano3"])){ 
      $sql  .= $virgula." o142_percopercreditoano3 = $this->o142_percopercreditoano3 ";
      $virgula = ",";
    }
    if(trim($this->o142_percopercreditoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano4"])){ 
      $sql  .= $virgula." o142_percopercreditoano4 = $this->o142_percopercreditoano4 ";
      $virgula = ",";
    }
    if(trim($this->o142_orcmodalidadeaplic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplic"])){ 
      $sql  .= $virgula." o142_orcmodalidadeaplic = '$this->o142_orcmodalidadeaplic' ";
      $virgula = ",";
    }else{ 
        if(isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplic"])){ 
          $sql  .= $virgula." o142_orcmodalidadeaplic = 'NULL' ";
          $virgula = ",";
        }
    }
    if(trim($this->o142_orcmodalidadeaplicano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano2"])){ 
      $sql  .= $virgula." o142_orcmodalidadeaplicano2 = '$this->o142_orcmodalidadeaplicano2' ";
      $virgula = ",";
    }else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano2"])){ 
        $sql  .= $virgula." o142_orcmodalidadeaplicano2 = 'NULL' ";
        $virgula = ",";
      }
   }
    if(trim($this->o142_orcmodalidadeaplicano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano3"])){ 
      $sql  .= $virgula." o142_orcmodalidadeaplicano3 = '$this->o142_orcmodalidadeaplicano3' ";
      $virgula = ",";
    }else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano3"])){ 
        $sql  .= $virgula." o142_orcmodalidadeaplicano3 = 'NULL' ";
        $virgula = ",";
      }
    }  
    if(trim($this->o142_orcmodalidadeaplicano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano4"])){ 
      $sql  .= $virgula." o142_orcmodalidadeaplicano4 = '$this->o142_orcmodalidadeaplicano4' ";
      $virgula = ",";
    }
    else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplicano4"])){ 
        $sql  .= $virgula." o142_orcmodalidadeaplicano4 = 'NULL' ";
        $virgula = ",";
      }
    }
    if(trim($this->o142_leialteracaoldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldo"])){ 
      $sql  .= $virgula." o142_leialteracaoldo = '$this->o142_leialteracaoldo' ";
      $virgula = ",";
    }
    if(trim($this->o142_leialteracaoldoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano2"])){ 
     $sql  .= $virgula." o142_leialteracaoldoano2 = '$this->o142_leialteracaoldoano2' ";
     $virgula = ",";
   }
   if(trim($this->o142_leialteracaoldoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano3"])){ 
     $sql  .= $virgula." o142_leialteracaoldoano3 = '$this->o142_leialteracaoldoano3' ";
     $virgula = ",";
   }
   if(trim($this->o142_leialteracaoldoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano4"])){ 
     $sql  .= $virgula." o142_leialteracaoldoano4 = '$this->o142_leialteracaoldoano4' ";
     $virgula = ",";
   }
   if(trim($this->o142_dataalteracaoldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldo_dia"] !="") ){ 
     $sql  .= $virgula." o142_dataalteracaoldo = '$this->o142_dataalteracaoldo' ";
     $virgula = ",";
   } else{ 
      if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldo_dia"])){ 
        $sql  .= $virgula." o142_dataalteracaoldo = null ";
        $virgula = ",";
      }
    }
    if(trim($this->o142_dataalteracaoldoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataalteracaoldoano2 = '$this->o142_dataalteracaoldoano2' ";
      $virgula = ",";
    }
    if(trim($this->o142_dataalteracaoldoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataalteracaoldoano3 = '$this->o142_dataalteracaoldoano3' ";
      $virgula = ",";
    }
    if(trim($this->o142_dataalteracaoldoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_dataalteracaoldoano4 = '$this->o142_dataalteracaoldoano4' ";
      $virgula = ",";
    }
    if(trim($this->o142_datapubalteracaoldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldo_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubalteracaoldo = '$this->o142_datapubalteracaoldo' ";
      $virgula = ",";
    }     else{ 
        if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldo_dia"])){ 
          $sql  .= $virgula." o142_datapubalteracaoldo = null ";
          $virgula = ",";
        }
      }
    if(trim($this->o142_datapubalteracaoldoano2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano2_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano2_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubalteracaoldoano2 = '$this->o142_datapubalteracaoldoano2' ";
      $virgula = ",";
    }
    if(trim($this->o142_datapubalteracaoldoano3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano3_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano3_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubalteracaoldoano3 = '$this->o142_datapubalteracaoldoano3' ";
      $virgula = ",";
    }
    if(trim($this->o142_datapubalteracaoldoano4)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano4_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano4_dia"] !="") ){ 
      $sql  .= $virgula." o142_datapubalteracaoldoano4 = '$this->o142_datapubalteracaoldoano4' ";
      $virgula = ",";
    }       
     $sql .= " where ";
     if($o142_sequencial!=null){
       $sql .= " o142_sequencial = $this->o142_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->o142_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,18403,'$this->o142_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_sequencial"]) || $this->o142_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,3257,18403,'".AddSlashes(pg_result($resaco,$conresaco,'o142_sequencial'))."','$this->o142_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_ppalei"]) || $this->o142_ppalei != "")
           $resac = db_query("insert into db_acount values($acount,3257,18404,'".AddSlashes(pg_result($resaco,$conresaco,'o142_ppalei'))."','$this->o142_ppalei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"]) || $this->o142_anoinicialppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18405,'".AddSlashes(pg_result($resaco,$conresaco,'o142_anoinicialppa'))."','$this->o142_anoinicialppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"]) || $this->o142_anofinalppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18406,'".AddSlashes(pg_result($resaco,$conresaco,'o142_anofinalppa'))."','$this->o142_anofinalppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroleippa"]) || $this->o142_numeroleippa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18407,'".AddSlashes(pg_result($resaco,$conresaco,'o142_numeroleippa'))."','$this->o142_numeroleippa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa"]) || $this->o142_dataleippa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18408,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataleippa'))."','$this->o142_dataleippa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa"]) || $this->o142_datapublicacaoppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18409,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapublicacaoppa'))."','$this->o142_datapublicacaoppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppa"]) || $this->o142_leialteracaoppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18410,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoppa'))."','$this->o142_leialteracaoppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa"]) || $this->o142_dataalteracaoppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18411,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoppa'))."','$this->o142_dataalteracaoppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao"]) || $this->o142_datapubalteracao != "")
           $resac = db_query("insert into db_acount values($acount,3257,18412,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracao'))."','$this->o142_datapubalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo"]) || $this->o142_datapublicacaoldo != "")
           $resac = db_query("insert into db_acount values($acount,3257,18413,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapublicacaoldo'))."','$this->o142_datapublicacaoldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldo"]) || $this->o142_dataldo != "")
           $resac = db_query("insert into db_acount values($acount,3257,18414,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataldo'))."','$this->o142_dataldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloa"]) || $this->o142_numeroloa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18415,'".AddSlashes(pg_result($resaco,$conresaco,'o142_numeroloa'))."','$this->o142_numeroloa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloa"]) || $this->o142_dataloa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18416,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataloa'))."','$this->o142_dataloa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa"]) || $this->o142_datapubloa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18417,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubloa'))."','$this->o142_datapubloa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacao"]) || $this->o142_percsuplementacao != "")
           $resac = db_query("insert into db_acount values($acount,3257,18418,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percsuplementacao'))."','$this->o142_percsuplementacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percaro"]) || $this->o142_percaro != "")
           $resac = db_query("insert into db_acount values($acount,3257,18419,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percaro'))."','$this->o142_percaro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercredito"]) || $this->o142_percopercredito != "")
           $resac = db_query("insert into db_acount values($acount,3257,18420,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percopercredito'))."','$this->o142_percopercredito',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano2"]) || $this->o142_numeroloaano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18421,'".AddSlashes(pg_result($resaco,$conresaco,'o142_numeroloaano2'))."','$this->o142_numeroloaano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano3"]) || $this->o142_numeroloaano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18422,'".AddSlashes(pg_result($resaco,$conresaco,'o142_numeroloaano3'))."','$this->o142_numeroloaano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloaano4"]) || $this->o142_numeroloaano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18423,'".AddSlashes(pg_result($resaco,$conresaco,'o142_numeroloaano4'))."','$this->o142_numeroloaano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano2"]) || $this->o142_dataldoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18424,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataldoano2'))."','$this->o142_dataldoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano3"]) || $this->o142_dataldoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18425,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataldoano3'))."','$this->o142_dataldoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldoano4"]) || $this->o142_dataldoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18426,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataldoano4'))."','$this->o142_dataldoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano2"]) || $this->o142_datapublicacaoldoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18427,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapublicacaoldoano2'))."','$this->o142_datapublicacaoldoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano3"]) || $this->o142_datapublicacaoldoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18428,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapublicacaoldoano3'))."','$this->o142_datapublicacaoldoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldoano4"]) || $this->o142_datapublicacaoldoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18429,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapublicacaoldoano4'))."','$this->o142_datapublicacaoldoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano2"]) || $this->o142_dataloaano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18430,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataloaano2'))."','$this->o142_dataloaano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano3"]) || $this->o142_dataloaano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18431,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataloaano3'))."','$this->o142_dataloaano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloaano4"]) || $this->o142_dataloaano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18432,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataloaano4'))."','$this->o142_dataloaano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano2"]) || $this->o142_datapubloaano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18433,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubloaano2'))."','$this->o142_datapubloaano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano3"]) || $this->o142_datapubloaano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18434,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubloaano3'))."','$this->o142_datapubloaano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloaano4"]) || $this->o142_datapubloaano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18435,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubloaano4'))."','$this->o142_datapubloaano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano2"]) || $this->o142_percsuplementacaoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18436,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percsuplementacaoano2'))."','$this->o142_percsuplementacaoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano3"]) || $this->o142_percsuplementacaoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18437,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percsuplementacaoano3'))."','$this->o142_percsuplementacaoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacaoano4"]) || $this->o142_percsuplementacaoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18438,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percsuplementacaoano4'))."','$this->o142_percsuplementacaoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percaroano2"]) || $this->o142_percaroano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18439,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percaroano2'))."','$this->o142_percaroano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percaroano3"]) || $this->o142_percaroano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18440,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percaroano3'))."','$this->o142_percaroano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percaroano4"]) || $this->o142_percaroano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18441,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percaroano4'))."','$this->o142_percaroano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano2"]) || $this->o142_percopercreditoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18442,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percopercreditoano2'))."','$this->o142_percopercreditoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano3"]) || $this->o142_percopercreditoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18443,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percopercreditoano3'))."','$this->o142_percopercreditoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercreditoano4"]) || $this->o142_percopercreditoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18444,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percopercreditoano4'))."','$this->o142_percopercreditoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano2"]) || $this->o142_leialteracaoppaano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18445,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoppaano2'))."','$this->o142_leialteracaoppaano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano3"]) || $this->o142_leialteracaoppaano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18446,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoppaano3'))."','$this->o142_leialteracaoppaano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppaano4"]) || $this->o142_leialteracaoppaano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18447,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoppaano4'))."','$this->o142_leialteracaoppaano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano2"]) || $this->o142_dataalteracaoppaano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18448,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoppaano2'))."','$this->o142_dataalteracaoppaano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano3"]) || $this->o142_dataalteracaoppaano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18449,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoppaano3'))."','$this->o142_dataalteracaoppaano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppaano4"]) || $this->o142_dataalteracaoppaano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18450,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoppaano4'))."','$this->o142_dataalteracaoppaano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano2"]) || $this->o142_datapubalteracaoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18451,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracaoano2'))."','$this->o142_datapubalteracaoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano3"]) || $this->o142_datapubalteracaoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18452,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracaoano3'))."','$this->o142_datapubalteracaoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoano4"]) || $this->o142_datapubalteracaoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18453,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracaoano4'))."','$this->o142_datapubalteracaoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldo"]) || $this->o142_leialteracaoldo != "")
           $resac = db_query("insert into db_acount values($acount,3257,18454,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoldo'))."','$this->o142_leialteracaoldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano2"]) || $this->o142_leialteracaoldoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18455,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoldoano2'))."','$this->o142_leialteracaoldoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano3"]) || $this->o142_leialteracaoldoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18456,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoldoano3'))."','$this->o142_leialteracaoldoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoldoano4"]) || $this->o142_leialteracaoldoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18457,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoldoano4'))."','$this->o142_leialteracaoldoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldo"]) || $this->o142_dataalteracaoldo != "")
           $resac = db_query("insert into db_acount values($acount,3257,18458,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoldo'))."','$this->o142_dataalteracaoldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano2"]) || $this->o142_dataalteracaoldoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18459,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoldoano2'))."','$this->o142_dataalteracaoldoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano3"]) || $this->o142_dataalteracaoldoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18460,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoldoano3'))."','$this->o142_dataalteracaoldoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoldoano4"]) || $this->o142_dataalteracaoldoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18461,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoldoano4'))."','$this->o142_dataalteracaoldoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldo"]) || $this->o142_datapubalteracaoldo != "")
           $resac = db_query("insert into db_acount values($acount,3257,18462,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracaoldo'))."','$this->o142_datapubalteracaoldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")"); 
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano2"]) || $this->o142_datapubalteracaoldoano2 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18463,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracaoldoano2'))."','$this->o142_datapubalteracaoldoano2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano3"]) || $this->o142_datapubalteracaoldoano3 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18464,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracaoldoano3'))."','$this->o142_datapubalteracaoldoano3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracaoldoano4"]) || $this->o142_datapubalteracaoldoano4 != "")
           $resac = db_query("insert into db_acount values($acount,3257,18465,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracaoldoano4'))."','$this->o142_datapubalteracaoldoano4',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       
          }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dados complementares do ppa nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dados complementares do ppa nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o142_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($o142_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,18403,'$o142_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,3257,18403,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18404,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_ppalei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18405,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_anoinicialppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18406,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_anofinalppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18407,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_numeroleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18408,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18409,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapublicacaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18410,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_leialteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18411,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataalteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18412,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapubalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18413,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapublicacaoldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18414,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18415,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_numeroloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18416,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18417,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapubloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18418,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_percsuplementacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18419,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_percaro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18420,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_percopercredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }
     }
     $sql = " delete from ppaleidadocomplementar
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($o142_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o142_sequencial = $o142_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dados complementares do ppa nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o142_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dados complementares do ppa nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o142_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ppaleidadocomplementar";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $o142_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ppaleidadocomplementar ";
     $sql .= "      inner join ppalei  on  ppalei.o01_sequencial = ppaleidadocomplementar.o142_ppalei";
     $sql .= "      inner join db_config  on  db_config.codigo = ppalei.o01_instit";
     $sql2 = "";
     if($dbwhere==""){
       if($o142_sequencial!=null ){
         $sql2 .= " where ppaleidadocomplementar.o142_sequencial = $o142_sequencial "; 
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
   function sql_query_file ( $o142_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ppaleidadocomplementar ";
     $sql2 = "";
     if($dbwhere==""){
       if($o142_sequencial!=null ){
         $sql2 .= " where ppaleidadocomplementar.o142_sequencial = $o142_sequencial "; 
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
