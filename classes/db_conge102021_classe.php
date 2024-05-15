<?php
//MODULO: sicom
//CLASSE DA ENTIDADE conge102021
class cl_conge102021 {
  // cria variaveis de erro
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status= null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo
  public $si182_sequencial = 0;
  public $si182_tiporegistro = 0;
  public $si182_codconvenioconge = 0;
  public $si182_codorgao = null;
  public $si182_codunidadesub = null;
  public $si182_nroconvenioconge = null;
  public $si182_dscinstrumento = null;
  public $si182_dataassinaturaconge_dia = null;
  public $si182_dataassinaturaconge_mes = null;
  public $si182_dataassinaturaconge_ano = null;
  public $si182_dataassinaturaconge = null;
  public $si182_datapublicconge_dia = null;
  public $si182_datapublicconge_mes = null;
  public $si182_datapublicconge_ano = null;
  public $si182_datapublicconge = null;
  public $si182_nrocpfrespconge = null;
  public $si182_dsccargorespconge = null;
  public $si182_objetoconvenioconge = null;
  public $si182_datainiciovigenciaconge = null;
  public $si182_datafinalvigenciaconge_dia = null;
  public $si182_datafinalvigenciaconge_mes = null;
  public $si182_datafinalvigenciaconge_ano = null;
  public $si182_datafinalvigenciaconge = null;
  public $si182_formarepasse = 0;
  public $ai182_tipodocumentoincentivador = 0;
  public $si182_nrodocumentoincentivador = null;
  public $si182_quantparcelas = 0;
  public $si182_vltotalconvenioconge = 0;
  public $si182_vlcontrapartidaconge = 0;
  public $si182_tipodocumentobeneficiario = 0;
  public $si182_nrodocumentobeneficiario = null;
  public $si182_mes = 0;
  public $si182_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si182_sequencial = int8 = Sequencial
                 si182_tiporegistro = int8 = Tipo do registro
                 si182_codconvenioconge = int8 = Código do convênio
                 si182_codorgao = varchar(2) = Código do órgão
                 si182_codunidadesub = varchar(8) = Código da unidade ou subunidade orçament
                 si182_nroconvenioconge = varchar(30) = Número do convênio ou instrumento congên
                 si182_dscinstrumento = varchar(50) = Descrição do instrumento de repasse
                 si182_dataassinaturaconge = date = Data da assinatura do convênio ou instr
                 si182_datapublicconge = date = Data da publicação do convênio ou instr
                 si182_nrocpfrespconge = varchar(11) = Número do CPF do responsável pela assin
                 si182_dsccargorespconge = varchar(50) = Cargo do responsável pela assinatura
                 si182_objetoconvenioconge = varchar(500) = Objeto do convênio ou instrumento congên
                 si182_datainiciovigenciaconge = varchar(8) = Data inicial da vigência do convênio
                 si182_datafinalvigenciaconge = date = Data final da vigência do convênio
                 si182_formarepasse = int8 = Forma pela qual os recursos serão repass
                 ai182_tipodocumentoincentivador = int8 = Tipo do documento do incentivador
                 si182_nrodocumentoincentivador = varchar(14) = Número do  Documento do incentivador
                 si182_quantparcelas = int8 = Quantidade de parcelas
                 si182_vltotalconvenioconge = float8 = Valor total do convênio ou instrumento
                 si182_vlcontrapartidaconge = float8 = Valor da contrapartida, se houver
                 si182_tipodocumentobeneficiario = int8 = Tipo do documento do beneficiário do rec
                 si182_nrodocumentobeneficiario = varchar(14) = Número do  Documento do beneficiário
                 si182_mes = int8 = Mês
                 si182_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conge102021");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro
  function erro($mostra,$retorna) {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )) {
      echo "<script>alert(\"".$this->erro_msg."\");</script>";
      if ($retorna==true) {
        echo "<script>location.href='".$this->pagina_retorno."'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao=false) {
    if ($exclusao==false) {
       $this->si182_sequencial = ($this->si182_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_sequencial"]:$this->si182_sequencial);
       $this->si182_tiporegistro = ($this->si182_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"]:$this->si182_tiporegistro);
       $this->si182_codconvenioconge = ($this->si182_codconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_codconvenioconge"]:$this->si182_codconvenioconge);
       $this->si182_codorgao = ($this->si182_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_codorgao"]:$this->si182_codorgao);
       $this->si182_codunidadesub = ($this->si182_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_codunidadesub"]:$this->si182_codunidadesub);
       $this->si182_nroconvenioconge = ($this->si182_nroconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_nroconvenioconge"]:$this->si182_nroconvenioconge);
       $this->si182_dscinstrumento = ($this->si182_dscinstrumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_dscinstrumento"]:$this->si182_dscinstrumento);
       if ($this->si182_dataassinaturaconge == "") {
         $this->si182_dataassinaturaconge_dia = ($this->si182_dataassinaturaconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_dataassinaturaconge_dia"]:$this->si182_dataassinaturaconge_dia);
         $this->si182_dataassinaturaconge_mes = ($this->si182_dataassinaturaconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_dataassinaturaconge_mes"]:$this->si182_dataassinaturaconge_mes);
         $this->si182_dataassinaturaconge_ano = ($this->si182_dataassinaturaconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_dataassinaturaconge_ano"]:$this->si182_dataassinaturaconge_ano);
         if ($this->si182_dataassinaturaconge_dia != "") {
            $this->si182_dataassinaturaconge = $this->si182_dataassinaturaconge_ano."-".$this->si182_dataassinaturaconge_mes."-".$this->si182_dataassinaturaconge_dia;
         }
       }
       if ($this->si182_datapublicconge == "") {
         $this->si182_datapublicconge_dia = ($this->si182_datapublicconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_datapublicconge_dia"]:$this->si182_datapublicconge_dia);
         $this->si182_datapublicconge_mes = ($this->si182_datapublicconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_datapublicconge_mes"]:$this->si182_datapublicconge_mes);
         $this->si182_datapublicconge_ano = ($this->si182_datapublicconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_datapublicconge_ano"]:$this->si182_datapublicconge_ano);
         if ($this->si182_datapublicconge_dia != "") {
            $this->si182_datapublicconge = $this->si182_datapublicconge_ano."-".$this->si182_datapublicconge_mes."-".$this->si182_datapublicconge_dia;
         }
       }
       $this->si182_nrocpfrespconge = ($this->si182_nrocpfrespconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_nrocpfrespconge"]:$this->si182_nrocpfrespconge);
       $this->si182_dsccargorespconge = ($this->si182_dsccargorespconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_dsccargorespconge"]:$this->si182_dsccargorespconge);
       $this->si182_objetoconvenioconge = ($this->si182_objetoconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_objetoconvenioconge"]:$this->si182_objetoconvenioconge);
       $this->si182_datainiciovigenciaconge = ($this->si182_datainiciovigenciaconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_datainiciovigenciaconge"]:$this->si182_datainiciovigenciaconge);
       if ($this->si182_datafinalvigenciaconge == "") {
         $this->si182_datafinalvigenciaconge_dia = ($this->si182_datafinalvigenciaconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_datafinalvigenciaconge_dia"]:$this->si182_datafinalvigenciaconge_dia);
         $this->si182_datafinalvigenciaconge_mes = ($this->si182_datafinalvigenciaconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_datafinalvigenciaconge_mes"]:$this->si182_datafinalvigenciaconge_mes);
         $this->si182_datafinalvigenciaconge_ano = ($this->si182_datafinalvigenciaconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_datafinalvigenciaconge_ano"]:$this->si182_datafinalvigenciaconge_ano);
         if ($this->si182_datafinalvigenciaconge_dia != "") {
            $this->si182_datafinalvigenciaconge = $this->si182_datafinalvigenciaconge_ano."-".$this->si182_datafinalvigenciaconge_mes."-".$this->si182_datafinalvigenciaconge_dia;
         }
       }
       $this->si182_formarepasse = ($this->si182_formarepasse == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_formarepasse"]:$this->si182_formarepasse);
       $this->ai182_tipodocumentoincentivador = ($this->ai182_tipodocumentoincentivador == ""?@$GLOBALS["HTTP_POST_VARS"]["ai182_tipodocumentoincentivador"]:$this->ai182_tipodocumentoincentivador);
       $this->si182_nrodocumentoincentivador = ($this->si182_nrodocumentoincentivador == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_nrodocumentoincentivador"]:$this->si182_nrodocumentoincentivador);
       $this->si182_quantparcelas = ($this->si182_quantparcelas == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_quantparcelas"]:$this->si182_quantparcelas);
       $this->si182_vltotalconvenioconge = ($this->si182_vltotalconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_vltotalconvenioconge"]:$this->si182_vltotalconvenioconge);
       $this->si182_vlcontrapartidaconge = ($this->si182_vlcontrapartidaconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_vlcontrapartidaconge"]:$this->si182_vlcontrapartidaconge);
       $this->si182_tipodocumentobeneficiario = ($this->si182_tipodocumentobeneficiario == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_tipodocumentobeneficiario"]:$this->si182_tipodocumentobeneficiario);
       $this->si182_nrodocumentobeneficiario = ($this->si182_nrodocumentobeneficiario == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_nrodocumentobeneficiario"]:$this->si182_nrodocumentobeneficiario);
       $this->si182_mes = ($this->si182_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_mes"]:$this->si182_mes);
       $this->si182_instit = ($this->si182_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_instit"]:$this->si182_instit);
     } else {
       $this->si182_sequencial = ($this->si182_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si182_sequencial"]:$this->si182_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si182_sequencial) {
      $this->atualizacampos();
     if ($this->si182_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do registro não informado.";
       $this->erro_campo = "si182_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_codconvenioconge == null ) {
       $this->erro_sql = " Campo Código do convênio não informado.";
       $this->erro_campo = "si182_codconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si182_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçament não informado.";
       $this->erro_campo = "si182_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_nroconvenioconge == null ) {
       $this->erro_sql = " Campo Número do convênio ou instrumento congên não informado.";
       $this->erro_campo = "si182_nroconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_dscinstrumento == null ) {
       $this->erro_sql = " Campo Descrição do instrumento de repasse não informado.";
       $this->erro_campo = "si182_dscinstrumento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_dataassinaturaconge == null ) {
       $this->erro_sql = " Campo Data da assinatura do convênio ou instr não informado.";
       $this->erro_campo = "si182_dataassinaturaconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_datapublicconge == null ) {
       $this->erro_sql = " Campo Data da publicação do convênio ou instr não informado.";
       $this->erro_campo = "si182_datapublicconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_nrocpfrespconge == null ) {
       $this->erro_sql = " Campo Número do CPF do responsável pela assin não informado.";
       $this->erro_campo = "si182_nrocpfrespconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_dsccargorespconge == null ) {
       $this->erro_sql = " Campo Cargo do responsável pela assinatura não informado.";
       $this->erro_campo = "si182_dsccargorespconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_objetoconvenioconge == null ) {
       $this->erro_sql = " Campo Objeto do convênio ou instrumento congên não informado.";
       $this->erro_campo = "si182_objetoconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_datainiciovigenciaconge == null ) {
       $this->erro_sql = " Campo Data inicial da vigência do convênio não informado.";
       $this->erro_campo = "si182_datainiciovigenciaconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_datafinalvigenciaconge == null ) {
       $this->erro_sql = " Campo Data final da vigência do convênio não informado.";
       $this->erro_campo = "si182_datafinalvigenciaconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_formarepasse == null ) {
       $this->erro_sql = " Campo Forma pela qual os recursos serão repass não informado.";
       $this->erro_campo = "si182_formarepasse";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ai182_tipodocumentoincentivador == null ) {
       $this->erro_sql = " Campo Tipo do documento do incentivador não informado.";
       $this->erro_campo = "ai182_tipodocumentoincentivador";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_nrodocumentoincentivador == null ) {
       $this->erro_sql = " Campo Número do  Documento do incentivador não informado.";
       $this->erro_campo = "si182_nrodocumentoincentivador";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_quantparcelas == null ) {
       $this->erro_sql = " Campo Quantidade de parcelas não informado.";
       $this->erro_campo = "si182_quantparcelas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_vltotalconvenioconge == null ) {
       $this->erro_sql = " Campo Valor total do convênio ou instrumento não informado.";
       $this->erro_campo = "si182_vltotalconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_vlcontrapartidaconge == null ) {
       $this->erro_sql = " Campo Valor da contrapartida, se houver não informado.";
       $this->erro_campo = "si182_vlcontrapartidaconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_tipodocumentobeneficiario == null ) {
       $this->erro_sql = " Campo Tipo do documento do beneficiário do rec não informado.";
       $this->erro_campo = "si182_tipodocumentobeneficiario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_nrodocumentobeneficiario == null ) {
       $this->erro_sql = " Campo Número do  Documento do beneficiário não informado.";
       $this->erro_campo = "si182_nrodocumentobeneficiario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si182_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si182_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si182_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si182_sequencial = $si182_sequencial;
     if (($this->si182_sequencial == null) || ($this->si182_sequencial == "") ) {
       $this->erro_sql = " Campo si182_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conge102021(
                                       si182_sequencial
                                      ,si182_tiporegistro
                                      ,si182_codconvenioconge
                                      ,si182_codorgao
                                      ,si182_codunidadesub
                                      ,si182_nroconvenioconge
                                      ,si182_dscinstrumento
                                      ,si182_dataassinaturaconge
                                      ,si182_datapublicconge
                                      ,si182_nrocpfrespconge
                                      ,si182_dsccargorespconge
                                      ,si182_objetoconvenioconge
                                      ,si182_datainiciovigenciaconge
                                      ,si182_datafinalvigenciaconge
                                      ,si182_formarepasse
                                      ,ai182_tipodocumentoincentivador
                                      ,si182_nrodocumentoincentivador
                                      ,si182_quantparcelas
                                      ,si182_vltotalconvenioconge
                                      ,si182_vlcontrapartidaconge
                                      ,si182_tipodocumentobeneficiario
                                      ,si182_nrodocumentobeneficiario
                                      ,si182_mes
                                      ,si182_instit
                       )
                values (
                                $this->si182_sequencial
                               ,$this->si182_tiporegistro
                               ,$this->si182_codconvenioconge
                               ,'$this->si182_codorgao'
                               ,'$this->si182_codunidadesub'
                               ,'$this->si182_nroconvenioconge'
                               ,'$this->si182_dscinstrumento'
                               ,".($this->si182_dataassinaturaconge == "null" || $this->si182_dataassinaturaconge == ""?"null":"'".$this->si182_dataassinaturaconge."'")."
                               ,".($this->si182_datapublicconge == "null" || $this->si182_datapublicconge == ""?"null":"'".$this->si182_datapublicconge."'")."
                               ,'$this->si182_nrocpfrespconge'
                               ,'$this->si182_dsccargorespconge'
                               ,'$this->si182_objetoconvenioconge'
                               ,'$this->si182_datainiciovigenciaconge'
                               ,".($this->si182_datafinalvigenciaconge == "null" || $this->si182_datafinalvigenciaconge == ""?"null":"'".$this->si182_datafinalvigenciaconge."'")."
                               ,$this->si182_formarepasse
                               ,$this->ai182_tipodocumentoincentivador
                               ,'$this->si182_nrodocumentoincentivador'
                               ,$this->si182_quantparcelas
                               ,$this->si182_vltotalconvenioconge
                               ,$this->si182_vlcontrapartidaconge
                               ,$this->si182_tipodocumentobeneficiario
                               ,'$this->si182_nrodocumentobeneficiario'
                               ,$this->si182_mes
                               ,$this->si182_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Cadastro dos Convênios e Instrumentos ($this->si182_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro dos Convênios e Instrumentos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Cadastro dos Convênios e Instrumentos ($this->si182_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si182_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si182_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011900,'$this->si182_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010195,2011900,'','".AddSlashes(pg_result($resaco,0,'si182_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011873,'','".AddSlashes(pg_result($resaco,0,'si182_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011874,'','".AddSlashes(pg_result($resaco,0,'si182_codconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011875,'','".AddSlashes(pg_result($resaco,0,'si182_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011876,'','".AddSlashes(pg_result($resaco,0,'si182_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011877,'','".AddSlashes(pg_result($resaco,0,'si182_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011878,'','".AddSlashes(pg_result($resaco,0,'si182_dscinstrumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011880,'','".AddSlashes(pg_result($resaco,0,'si182_dataassinaturaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011882,'','".AddSlashes(pg_result($resaco,0,'si182_datapublicconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011884,'','".AddSlashes(pg_result($resaco,0,'si182_nrocpfrespconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011885,'','".AddSlashes(pg_result($resaco,0,'si182_dsccargorespconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011886,'','".AddSlashes(pg_result($resaco,0,'si182_objetoconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011887,'','".AddSlashes(pg_result($resaco,0,'si182_datainiciovigenciaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011888,'','".AddSlashes(pg_result($resaco,0,'si182_datafinalvigenciaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011889,'','".AddSlashes(pg_result($resaco,0,'si182_formarepasse'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011890,'','".AddSlashes(pg_result($resaco,0,'ai182_tipodocumentoincentivador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011891,'','".AddSlashes(pg_result($resaco,0,'si182_nrodocumentoincentivador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011892,'','".AddSlashes(pg_result($resaco,0,'si182_quantparcelas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011893,'','".AddSlashes(pg_result($resaco,0,'si182_vltotalconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011894,'','".AddSlashes(pg_result($resaco,0,'si182_vlcontrapartidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011895,'','".AddSlashes(pg_result($resaco,0,'si182_tipodocumentobeneficiario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011896,'','".AddSlashes(pg_result($resaco,0,'si182_nrodocumentobeneficiario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011904,'','".AddSlashes(pg_result($resaco,0,'si182_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,2011908,'','".AddSlashes(pg_result($resaco,0,'si182_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si182_sequencial=null) {
      $this->atualizacampos();
     $sql = " update conge102021 set ";
     $virgula = "";
     if (trim($this->si182_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_sequencial"])) {
       $sql  .= $virgula." si182_sequencial = $this->si182_sequencial ";
       $virgula = ",";
       if (trim($this->si182_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si182_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"])) {
       $sql  .= $virgula." si182_tiporegistro = $this->si182_tiporegistro ";
       $virgula = ",";
       if (trim($this->si182_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do registro não informado.";
         $this->erro_campo = "si182_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_codconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_codconvenioconge"])) {
       $sql  .= $virgula." si182_codconvenioconge = $this->si182_codconvenioconge ";
       $virgula = ",";
       if (trim($this->si182_codconvenioconge) == null ) {
         $this->erro_sql = " Campo Código do convênio não informado.";
         $this->erro_campo = "si182_codconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_codorgao"])) {
       $sql  .= $virgula." si182_codorgao = '$this->si182_codorgao' ";
       $virgula = ",";
       if (trim($this->si182_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si182_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_codunidadesub"])) {
       $sql  .= $virgula." si182_codunidadesub = '$this->si182_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si182_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçament não informado.";
         $this->erro_campo = "si182_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_nroconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_nroconvenioconge"])) {
       $sql  .= $virgula." si182_nroconvenioconge = '$this->si182_nroconvenioconge' ";
       $virgula = ",";
       if (trim($this->si182_nroconvenioconge) == null ) {
         $this->erro_sql = " Campo Número do convênio ou instrumento congên não informado.";
         $this->erro_campo = "si182_nroconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_dscinstrumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_dscinstrumento"])) {
       $sql  .= $virgula." si182_dscinstrumento = '$this->si182_dscinstrumento' ";
       $virgula = ",";
       if (trim($this->si182_dscinstrumento) == null ) {
         $this->erro_sql = " Campo Descrição do instrumento de repasse não informado.";
         $this->erro_campo = "si182_dscinstrumento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_dataassinaturaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_dataassinaturaconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si182_dataassinaturaconge_dia"] !="") ) {
       $sql  .= $virgula." si182_dataassinaturaconge = '$this->si182_dataassinaturaconge' ";
       $virgula = ",";
       if (trim($this->si182_dataassinaturaconge) == null ) {
         $this->erro_sql = " Campo Data da assinatura do convênio ou instr não informado.";
         $this->erro_campo = "si182_dataassinaturaconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si182_dataassinaturaconge_dia"])) {
         $sql  .= $virgula." si182_dataassinaturaconge = null ";
         $virgula = ",";
         if (trim($this->si182_dataassinaturaconge) == null ) {
           $this->erro_sql = " Campo Data da assinatura do convênio ou instr não informado.";
           $this->erro_campo = "si182_dataassinaturaconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si182_datapublicconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_datapublicconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si182_datapublicconge_dia"] !="") ) {
       $sql  .= $virgula." si182_datapublicconge = '$this->si182_datapublicconge' ";
       $virgula = ",";
       if (trim($this->si182_datapublicconge) == null ) {
         $this->erro_sql = " Campo Data da publicação do convênio ou instr não informado.";
         $this->erro_campo = "si182_datapublicconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si182_datapublicconge_dia"])) {
         $sql  .= $virgula." si182_datapublicconge = null ";
         $virgula = ",";
         if (trim($this->si182_datapublicconge) == null ) {
           $this->erro_sql = " Campo Data da publicação do convênio ou instr não informado.";
           $this->erro_campo = "si182_datapublicconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si182_nrocpfrespconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_nrocpfrespconge"])) {
       $sql  .= $virgula." si182_nrocpfrespconge = '$this->si182_nrocpfrespconge' ";
       $virgula = ",";
       if (trim($this->si182_nrocpfrespconge) == null ) {
         $this->erro_sql = " Campo Número do CPF do responsável pela assin não informado.";
         $this->erro_campo = "si182_nrocpfrespconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_dsccargorespconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_dsccargorespconge"])) {
       $sql  .= $virgula." si182_dsccargorespconge = '$this->si182_dsccargorespconge' ";
       $virgula = ",";
       if (trim($this->si182_dsccargorespconge) == null ) {
         $this->erro_sql = " Campo Cargo do responsável pela assinatura não informado.";
         $this->erro_campo = "si182_dsccargorespconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_objetoconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_objetoconvenioconge"])) {
       $sql  .= $virgula." si182_objetoconvenioconge = '$this->si182_objetoconvenioconge' ";
       $virgula = ",";
       if (trim($this->si182_objetoconvenioconge) == null ) {
         $this->erro_sql = " Campo Objeto do convênio ou instrumento congên não informado.";
         $this->erro_campo = "si182_objetoconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_datainiciovigenciaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_datainiciovigenciaconge"])) {
       $sql  .= $virgula." si182_datainiciovigenciaconge = '$this->si182_datainiciovigenciaconge' ";
       $virgula = ",";
       if (trim($this->si182_datainiciovigenciaconge) == null ) {
         $this->erro_sql = " Campo Data inicial da vigência do convênio não informado.";
         $this->erro_campo = "si182_datainiciovigenciaconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_datafinalvigenciaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_datafinalvigenciaconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si182_datafinalvigenciaconge_dia"] !="") ) {
       $sql  .= $virgula." si182_datafinalvigenciaconge = '$this->si182_datafinalvigenciaconge' ";
       $virgula = ",";
       if (trim($this->si182_datafinalvigenciaconge) == null ) {
         $this->erro_sql = " Campo Data final da vigência do convênio não informado.";
         $this->erro_campo = "si182_datafinalvigenciaconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si182_datafinalvigenciaconge_dia"])) {
         $sql  .= $virgula." si182_datafinalvigenciaconge = null ";
         $virgula = ",";
         if (trim($this->si182_datafinalvigenciaconge) == null ) {
           $this->erro_sql = " Campo Data final da vigência do convênio não informado.";
           $this->erro_campo = "si182_datafinalvigenciaconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si182_formarepasse)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_formarepasse"])) {
       $sql  .= $virgula." si182_formarepasse = $this->si182_formarepasse ";
       $virgula = ",";
       if (trim($this->si182_formarepasse) == null ) {
         $this->erro_sql = " Campo Forma pela qual os recursos serão repass não informado.";
         $this->erro_campo = "si182_formarepasse";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ai182_tipodocumentoincentivador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ai182_tipodocumentoincentivador"])) {
       $sql  .= $virgula." ai182_tipodocumentoincentivador = $this->ai182_tipodocumentoincentivador ";
       $virgula = ",";
       if (trim($this->ai182_tipodocumentoincentivador) == null ) {
         $this->erro_sql = " Campo Tipo do documento do incentivador não informado.";
         $this->erro_campo = "ai182_tipodocumentoincentivador";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_nrodocumentoincentivador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_nrodocumentoincentivador"])) {
       $sql  .= $virgula." si182_nrodocumentoincentivador = '$this->si182_nrodocumentoincentivador' ";
       $virgula = ",";
       if (trim($this->si182_nrodocumentoincentivador) == null ) {
         $this->erro_sql = " Campo Número do  Documento do incentivador não informado.";
         $this->erro_campo = "si182_nrodocumentoincentivador";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_quantparcelas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_quantparcelas"])) {
       $sql  .= $virgula." si182_quantparcelas = $this->si182_quantparcelas ";
       $virgula = ",";
       if (trim($this->si182_quantparcelas) == null ) {
         $this->erro_sql = " Campo Quantidade de parcelas não informado.";
         $this->erro_campo = "si182_quantparcelas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_vltotalconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_vltotalconvenioconge"])) {
       $sql  .= $virgula." si182_vltotalconvenioconge = $this->si182_vltotalconvenioconge ";
       $virgula = ",";
       if (trim($this->si182_vltotalconvenioconge) == null ) {
         $this->erro_sql = " Campo Valor total do convênio ou instrumento não informado.";
         $this->erro_campo = "si182_vltotalconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_vlcontrapartidaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_vlcontrapartidaconge"])) {
       $sql  .= $virgula." si182_vlcontrapartidaconge = $this->si182_vlcontrapartidaconge ";
       $virgula = ",";
       if (trim($this->si182_vlcontrapartidaconge) == null ) {
         $this->erro_sql = " Campo Valor da contrapartida, se houver não informado.";
         $this->erro_campo = "si182_vlcontrapartidaconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_tipodocumentobeneficiario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_tipodocumentobeneficiario"])) {
       $sql  .= $virgula." si182_tipodocumentobeneficiario = $this->si182_tipodocumentobeneficiario ";
       $virgula = ",";
       if (trim($this->si182_tipodocumentobeneficiario) == null ) {
         $this->erro_sql = " Campo Tipo do documento do beneficiário do rec não informado.";
         $this->erro_campo = "si182_tipodocumentobeneficiario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_nrodocumentobeneficiario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_nrodocumentobeneficiario"])) {
       $sql  .= $virgula." si182_nrodocumentobeneficiario = '$this->si182_nrodocumentobeneficiario' ";
       $virgula = ",";
       if (trim($this->si182_nrodocumentobeneficiario) == null ) {
         $this->erro_sql = " Campo Número do  Documento do beneficiário não informado.";
         $this->erro_campo = "si182_nrodocumentobeneficiario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_mes"])) {
       $sql  .= $virgula." si182_mes = $this->si182_mes ";
       $virgula = ",";
       if (trim($this->si182_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si182_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si182_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si182_instit"])) {
       $sql  .= $virgula." si182_instit = $this->si182_instit ";
       $virgula = ",";
       if (trim($this->si182_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si182_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si182_sequencial!=null) {
       $sql .= " si182_sequencial = $this->si182_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si182_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011900,'$this->si182_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_sequencial"]) || $this->si182_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011900,'".AddSlashes(pg_result($resaco,$conresaco,'si182_sequencial'))."','$this->si182_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"]) || $this->si182_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011873,'".AddSlashes(pg_result($resaco,$conresaco,'si182_tiporegistro'))."','$this->si182_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_codconvenioconge"]) || $this->si182_codconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011874,'".AddSlashes(pg_result($resaco,$conresaco,'si182_codconvenioconge'))."','$this->si182_codconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_codorgao"]) || $this->si182_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011875,'".AddSlashes(pg_result($resaco,$conresaco,'si182_codorgao'))."','$this->si182_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_codunidadesub"]) || $this->si182_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011876,'".AddSlashes(pg_result($resaco,$conresaco,'si182_codunidadesub'))."','$this->si182_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_nroconvenioconge"]) || $this->si182_nroconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011877,'".AddSlashes(pg_result($resaco,$conresaco,'si182_nroconvenioconge'))."','$this->si182_nroconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_dscinstrumento"]) || $this->si182_dscinstrumento != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011878,'".AddSlashes(pg_result($resaco,$conresaco,'si182_dscinstrumento'))."','$this->si182_dscinstrumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_dataassinaturaconge"]) || $this->si182_dataassinaturaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011880,'".AddSlashes(pg_result($resaco,$conresaco,'si182_dataassinaturaconge'))."','$this->si182_dataassinaturaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_datapublicconge"]) || $this->si182_datapublicconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011882,'".AddSlashes(pg_result($resaco,$conresaco,'si182_datapublicconge'))."','$this->si182_datapublicconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_nrocpfrespconge"]) || $this->si182_nrocpfrespconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011884,'".AddSlashes(pg_result($resaco,$conresaco,'si182_nrocpfrespconge'))."','$this->si182_nrocpfrespconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_dsccargorespconge"]) || $this->si182_dsccargorespconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011885,'".AddSlashes(pg_result($resaco,$conresaco,'si182_dsccargorespconge'))."','$this->si182_dsccargorespconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_objetoconvenioconge"]) || $this->si182_objetoconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011886,'".AddSlashes(pg_result($resaco,$conresaco,'si182_objetoconvenioconge'))."','$this->si182_objetoconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_datainiciovigenciaconge"]) || $this->si182_datainiciovigenciaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011887,'".AddSlashes(pg_result($resaco,$conresaco,'si182_datainiciovigenciaconge'))."','$this->si182_datainiciovigenciaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_datafinalvigenciaconge"]) || $this->si182_datafinalvigenciaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011888,'".AddSlashes(pg_result($resaco,$conresaco,'si182_datafinalvigenciaconge'))."','$this->si182_datafinalvigenciaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_formarepasse"]) || $this->si182_formarepasse != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011889,'".AddSlashes(pg_result($resaco,$conresaco,'si182_formarepasse'))."','$this->si182_formarepasse',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["ai182_tipodocumentoincentivador"]) || $this->ai182_tipodocumentoincentivador != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011890,'".AddSlashes(pg_result($resaco,$conresaco,'ai182_tipodocumentoincentivador'))."','$this->ai182_tipodocumentoincentivador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_nrodocumentoincentivador"]) || $this->si182_nrodocumentoincentivador != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011891,'".AddSlashes(pg_result($resaco,$conresaco,'si182_nrodocumentoincentivador'))."','$this->si182_nrodocumentoincentivador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_quantparcelas"]) || $this->si182_quantparcelas != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011892,'".AddSlashes(pg_result($resaco,$conresaco,'si182_quantparcelas'))."','$this->si182_quantparcelas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_vltotalconvenioconge"]) || $this->si182_vltotalconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011893,'".AddSlashes(pg_result($resaco,$conresaco,'si182_vltotalconvenioconge'))."','$this->si182_vltotalconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_vlcontrapartidaconge"]) || $this->si182_vlcontrapartidaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011894,'".AddSlashes(pg_result($resaco,$conresaco,'si182_vlcontrapartidaconge'))."','$this->si182_vlcontrapartidaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_tipodocumentobeneficiario"]) || $this->si182_tipodocumentobeneficiario != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011895,'".AddSlashes(pg_result($resaco,$conresaco,'si182_tipodocumentobeneficiario'))."','$this->si182_tipodocumentobeneficiario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_nrodocumentobeneficiario"]) || $this->si182_nrodocumentobeneficiario != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011896,'".AddSlashes(pg_result($resaco,$conresaco,'si182_nrodocumentobeneficiario'))."','$this->si182_nrodocumentobeneficiario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_mes"]) || $this->si182_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011904,'".AddSlashes(pg_result($resaco,$conresaco,'si182_mes'))."','$this->si182_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si182_instit"]) || $this->si182_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010195,2011908,'".AddSlashes(pg_result($resaco,$conresaco,'si182_instit'))."','$this->si182_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro dos Convênios e Instrumentos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si182_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro dos Convênios e Instrumentos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si182_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si182_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si182_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si182_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011900,'$si182_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011900,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011873,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011874,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_codconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011875,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011876,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011877,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011878,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_dscinstrumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011880,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_dataassinaturaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011882,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_datapublicconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011884,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_nrocpfrespconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011885,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_dsccargorespconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011886,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_objetoconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011887,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_datainiciovigenciaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011888,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_datafinalvigenciaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011889,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_formarepasse'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011890,'','".AddSlashes(pg_result($resaco,$iresaco,'ai182_tipodocumentoincentivador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011891,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_nrodocumentoincentivador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011892,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_quantparcelas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011893,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_vltotalconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011894,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_vlcontrapartidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011895,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_tipodocumentobeneficiario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011896,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_nrodocumentobeneficiario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011904,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,2011908,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from conge102021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si182_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si182_sequencial = $si182_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro dos Convênios e Instrumentos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si182_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro dos Convênios e Instrumentos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si182_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si182_sequencial;
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
     if ($result==false) {
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if ($this->numrows==0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:conge102021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si182_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from conge102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si182_sequencial!=null ) {
         $sql2 .= " where conge102021.si182_sequencial = $si182_sequencial ";
       }
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }

  // funcao do sql
  function sql_query_file ( $si182_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from conge102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si182_sequencial!=null ) {
         $sql2 .= " where conge102021.si182_sequencial = $si182_sequencial ";
       }
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }
}
?>
