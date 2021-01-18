<?php
//MODULO: sicom
//CLASSE DA ENTIDADE conge302021
class cl_conge302021 {
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
  public $si184_sequencial = 0;
  public $si184_tiporegistro = 0;
  public $si184_codorgao = null;
  public $si184_codunidadesub = null;
  public $si184_nroconvenioconge = null;
  public $si184_dataassinaturaconvoriginalconge_dia = null;
  public $si184_dataassinaturaconvoriginalconge_mes = null;
  public $si184_dataassinaturaconvoriginalconge_ano = null;
  public $si184_dataassinaturaconvoriginalconge = null;
  public $si184_numeroparcela = 0;
  public $si184_datarepasseconge_dia = null;
  public $si184_datarepasseconge_mes = null;
  public $si184_datarepasseconge_ano = null;
  public $si184_datarepasseconge = null;
  public $si184_vlrepassadoconge = 0;
  public $si184_banco = 0;
  public $si184_agencia = null;
  public $si184_digitoverificadoragencia = null;
  public $si184_contabancaria = 0;
  public $si184_digitoverificadorcontabancaria = null;
  public $si184_tipodocumentotitularconta = 0;
  public $si184_nrodocumentotitularconta = null;
  public $si184_prazoprestacontas_dia = null;
  public $si184_prazoprestacontas_mes = null;
  public $si184_prazoprestacontas_ano = null;
  public $si184_prazoprestacontas = null;
  public $si184_mes = 0;
  public $si184_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si184_sequencial = int8 = Sequencial
                 si184_tiporegistro = int8 = Tipo do Registro
                 si184_codorgao = varchar(2) = Código do órgão
                 si184_codunidadesub = varchar(8) = Código da unidade ou subunidade orçam
                 si184_nroconvenioconge = varchar(30) = Número do convênio original ou instrum
                 si184_dataassinaturaconvoriginalconge = date = Data da assinatura do convênio original
                 si184_numeroparcela = int8 = Número da parcela
                 si184_datarepasseconge = date = Data do repasse
                 si184_vlrepassadoconge = float8 = Valor repassado da parcela
                 si184_banco = int8 = Número do banco  para o qual foi repass
                 si184_agencia = varchar(6) = Número da agência bancária
                 si184_digitoverificadoragencia = varchar(2) = Digito verificador Agência
                 si184_contabancaria = int8 = Número da conta bancária
                 si184_digitoverificadorcontabancaria = varchar(2) = Dígito verificador da conta bancária
                 si184_tipodocumentotitularconta = int8 = Tipo do documento do titular da conta
                 si184_nrodocumentotitularconta = varchar(14) = Número do  documento do titular da conta
                 si184_prazoprestacontas = date = Data final para prestação de contas
                 si184_mes = int8 = Mês
                 si184_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conge302021");
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
       $this->si184_sequencial = ($this->si184_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_sequencial"]:$this->si184_sequencial);
       $this->si184_tiporegistro = ($this->si184_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"]:$this->si184_tiporegistro);
       $this->si184_codorgao = ($this->si184_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_codorgao"]:$this->si184_codorgao);
       $this->si184_codunidadesub = ($this->si184_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_codunidadesub"]:$this->si184_codunidadesub);
       $this->si184_nroconvenioconge = ($this->si184_nroconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_nroconvenioconge"]:$this->si184_nroconvenioconge);
       if ($this->si184_dataassinaturaconvoriginalconge == "") {
         $this->si184_dataassinaturaconvoriginalconge_dia = ($this->si184_dataassinaturaconvoriginalconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_dataassinaturaconvoriginalconge_dia"]:$this->si184_dataassinaturaconvoriginalconge_dia);
         $this->si184_dataassinaturaconvoriginalconge_mes = ($this->si184_dataassinaturaconvoriginalconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_dataassinaturaconvoriginalconge_mes"]:$this->si184_dataassinaturaconvoriginalconge_mes);
         $this->si184_dataassinaturaconvoriginalconge_ano = ($this->si184_dataassinaturaconvoriginalconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_dataassinaturaconvoriginalconge_ano"]:$this->si184_dataassinaturaconvoriginalconge_ano);
         if ($this->si184_dataassinaturaconvoriginalconge_dia != "") {
            $this->si184_dataassinaturaconvoriginalconge = $this->si184_dataassinaturaconvoriginalconge_ano."-".$this->si184_dataassinaturaconvoriginalconge_mes."-".$this->si184_dataassinaturaconvoriginalconge_dia;
         }
       }
       $this->si184_numeroparcela = ($this->si184_numeroparcela == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_numeroparcela"]:$this->si184_numeroparcela);
       if ($this->si184_datarepasseconge == "") {
         $this->si184_datarepasseconge_dia = ($this->si184_datarepasseconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_datarepasseconge_dia"]:$this->si184_datarepasseconge_dia);
         $this->si184_datarepasseconge_mes = ($this->si184_datarepasseconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_datarepasseconge_mes"]:$this->si184_datarepasseconge_mes);
         $this->si184_datarepasseconge_ano = ($this->si184_datarepasseconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_datarepasseconge_ano"]:$this->si184_datarepasseconge_ano);
         if ($this->si184_datarepasseconge_dia != "") {
            $this->si184_datarepasseconge = $this->si184_datarepasseconge_ano."-".$this->si184_datarepasseconge_mes."-".$this->si184_datarepasseconge_dia;
         }
       }
       $this->si184_vlrepassadoconge = ($this->si184_vlrepassadoconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_vlrepassadoconge"]:$this->si184_vlrepassadoconge);
       $this->si184_banco = ($this->si184_banco == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_banco"]:$this->si184_banco);
       $this->si184_agencia = ($this->si184_agencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_agencia"]:$this->si184_agencia);
       $this->si184_digitoverificadoragencia = ($this->si184_digitoverificadoragencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_digitoverificadoragencia"]:$this->si184_digitoverificadoragencia);
       $this->si184_contabancaria = ($this->si184_contabancaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_contabancaria"]:$this->si184_contabancaria);
       $this->si184_digitoverificadorcontabancaria = ($this->si184_digitoverificadorcontabancaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_digitoverificadorcontabancaria"]:$this->si184_digitoverificadorcontabancaria);
       $this->si184_tipodocumentotitularconta = ($this->si184_tipodocumentotitularconta == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_tipodocumentotitularconta"]:$this->si184_tipodocumentotitularconta);
       $this->si184_nrodocumentotitularconta = ($this->si184_nrodocumentotitularconta == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_nrodocumentotitularconta"]:$this->si184_nrodocumentotitularconta);
       if ($this->si184_prazoprestacontas == "") {
         $this->si184_prazoprestacontas_dia = ($this->si184_prazoprestacontas_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_prazoprestacontas_dia"]:$this->si184_prazoprestacontas_dia);
         $this->si184_prazoprestacontas_mes = ($this->si184_prazoprestacontas_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_prazoprestacontas_mes"]:$this->si184_prazoprestacontas_mes);
         $this->si184_prazoprestacontas_ano = ($this->si184_prazoprestacontas_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_prazoprestacontas_ano"]:$this->si184_prazoprestacontas_ano);
         if ($this->si184_prazoprestacontas_dia != "") {
            $this->si184_prazoprestacontas = $this->si184_prazoprestacontas_ano."-".$this->si184_prazoprestacontas_mes."-".$this->si184_prazoprestacontas_dia;
         }
       }
       $this->si184_mes = ($this->si184_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_mes"]:$this->si184_mes);
       $this->si184_instit = ($this->si184_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_instit"]:$this->si184_instit);
     } else {
       $this->si184_sequencial = ($this->si184_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si184_sequencial"]:$this->si184_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si184_sequencial) {
      $this->atualizacampos();
     if ($this->si184_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si184_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si184_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si184_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_nroconvenioconge == null ) {
       $this->erro_sql = " Campo Número do convênio original ou instrum não informado.";
       $this->erro_campo = "si184_nroconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_dataassinaturaconvoriginalconge == null ) {
       $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
       $this->erro_campo = "si184_dataassinaturaconvoriginalconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_numeroparcela == null ) {
       $this->erro_sql = " Campo Número da parcela não informado.";
       $this->erro_campo = "si184_numeroparcela";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_datarepasseconge == null ) {
       $this->erro_sql = " Campo Data do repasse não informado.";
       $this->erro_campo = "si184_datarepasseconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_vlrepassadoconge == null ) {
       $this->erro_sql = " Campo Valor repassado da parcela não informado.";
       $this->erro_campo = "si184_vlrepassadoconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_banco == null ) {
       $this->erro_sql = " Campo Número do banco  para o qual foi repass não informado.";
       $this->erro_campo = "si184_banco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_agencia == null ) {
       $this->erro_sql = " Campo Número da agência bancária não informado.";
       $this->erro_campo = "si184_agencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_digitoverificadoragencia == null ) {
       $this->erro_sql = " Campo Digito verificador Agência não informado.";
       $this->erro_campo = "si184_digitoverificadoragencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_contabancaria == null ) {
       $this->erro_sql = " Campo Número da conta bancária não informado.";
       $this->erro_campo = "si184_contabancaria";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_digitoverificadorcontabancaria == null ) {
       $this->erro_sql = " Campo Dígito verificador da conta bancária não informado.";
       $this->erro_campo = "si184_digitoverificadorcontabancaria";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_tipodocumentotitularconta == null ) {
       $this->erro_sql = " Campo Tipo do documento do titular da conta não informado.";
       $this->erro_campo = "si184_tipodocumentotitularconta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_nrodocumentotitularconta == null ) {
       $this->erro_sql = " Campo Número do  documento do titular da conta não informado.";
       $this->erro_campo = "si184_nrodocumentotitularconta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_prazoprestacontas == null ) {
       $this->erro_sql = " Campo Data final para prestação de contas não informado.";
       $this->erro_campo = "si184_prazoprestacontas_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si184_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si184_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si184_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si184_sequencial = $si184_sequencial;
     if (($this->si184_sequencial == null) || ($this->si184_sequencial == "") ) {
       $this->erro_sql = " Campo si184_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conge302021(
                                       si184_sequencial
                                      ,si184_tiporegistro
                                      ,si184_codorgao
                                      ,si184_codunidadesub
                                      ,si184_nroconvenioconge
                                      ,si184_dataassinaturaconvoriginalconge
                                      ,si184_numeroparcela
                                      ,si184_datarepasseconge
                                      ,si184_vlrepassadoconge
                                      ,si184_banco
                                      ,si184_agencia
                                      ,si184_digitoverificadoragencia
                                      ,si184_contabancaria
                                      ,si184_digitoverificadorcontabancaria
                                      ,si184_tipodocumentotitularconta
                                      ,si184_nrodocumentotitularconta
                                      ,si184_prazoprestacontas
                                      ,si184_mes
                                      ,si184_instit
                       )
                values (
                                $this->si184_sequencial
                               ,$this->si184_tiporegistro
                               ,'$this->si184_codorgao'
                               ,'$this->si184_codunidadesub'
                               ,'$this->si184_nroconvenioconge'
                               ,".($this->si184_dataassinaturaconvoriginalconge == "null" || $this->si184_dataassinaturaconvoriginalconge == ""?"null":"'".$this->si184_dataassinaturaconvoriginalconge."'")."
                               ,$this->si184_numeroparcela
                               ,".($this->si184_datarepasseconge == "null" || $this->si184_datarepasseconge == ""?"null":"'".$this->si184_datarepasseconge."'")."
                               ,$this->si184_vlrepassadoconge
                               ,$this->si184_banco
                               ,'$this->si184_agencia'
                               ,'$this->si184_digitoverificadoragencia'
                               ,$this->si184_contabancaria
                               ,'$this->si184_digitoverificadorcontabancaria'
                               ,$this->si184_tipodocumentotitularconta
                               ,'$this->si184_nrodocumentotitularconta'
                               ,".($this->si184_prazoprestacontas == "null" || $this->si184_prazoprestacontas == ""?"null":"'".$this->si184_prazoprestacontas."'")."
                               ,$this->si184_mes
                               ,$this->si184_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Repasses Realizados por meio de Convên ($this->si184_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Repasses Realizados por meio de Convên já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Repasses Realizados por meio de Convên ($this->si184_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si184_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
   /*  if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si184_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011941,'$this->si184_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010197,2011941,'','".AddSlashes(pg_result($resaco,0,'si184_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011925,'','".AddSlashes(pg_result($resaco,0,'si184_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011926,'','".AddSlashes(pg_result($resaco,0,'si184_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011927,'','".AddSlashes(pg_result($resaco,0,'si184_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011928,'','".AddSlashes(pg_result($resaco,0,'si184_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011929,'','".AddSlashes(pg_result($resaco,0,'si184_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011930,'','".AddSlashes(pg_result($resaco,0,'si184_numeroparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011931,'','".AddSlashes(pg_result($resaco,0,'si184_datarepasseconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011932,'','".AddSlashes(pg_result($resaco,0,'si184_vlrepassadoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011933,'','".AddSlashes(pg_result($resaco,0,'si184_banco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011934,'','".AddSlashes(pg_result($resaco,0,'si184_agencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011935,'','".AddSlashes(pg_result($resaco,0,'si184_digitoverificadoragencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011936,'','".AddSlashes(pg_result($resaco,0,'si184_contabancaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011937,'','".AddSlashes(pg_result($resaco,0,'si184_digitoverificadorcontabancaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011938,'','".AddSlashes(pg_result($resaco,0,'si184_tipodocumentotitularconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011939,'','".AddSlashes(pg_result($resaco,0,'si184_nrodocumentotitularconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011940,'','".AddSlashes(pg_result($resaco,0,'si184_prazoprestacontas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011942,'','".AddSlashes(pg_result($resaco,0,'si184_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,2011943,'','".AddSlashes(pg_result($resaco,0,'si184_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si184_sequencial=null) {
      $this->atualizacampos();
     $sql = " update conge302021 set ";
     $virgula = "";
     if (trim($this->si184_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_sequencial"])) {
       $sql  .= $virgula." si184_sequencial = $this->si184_sequencial ";
       $virgula = ",";
       if (trim($this->si184_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si184_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"])) {
       $sql  .= $virgula." si184_tiporegistro = $this->si184_tiporegistro ";
       $virgula = ",";
       if (trim($this->si184_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si184_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_codorgao"])) {
       $sql  .= $virgula." si184_codorgao = '$this->si184_codorgao' ";
       $virgula = ",";
       if (trim($this->si184_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si184_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_codunidadesub"])) {
       $sql  .= $virgula." si184_codunidadesub = '$this->si184_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si184_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si184_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_nroconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_nroconvenioconge"])) {
       $sql  .= $virgula." si184_nroconvenioconge = '$this->si184_nroconvenioconge' ";
       $virgula = ",";
       if (trim($this->si184_nroconvenioconge) == null ) {
         $this->erro_sql = " Campo Número do convênio original ou instrum não informado.";
         $this->erro_campo = "si184_nroconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_dataassinaturaconvoriginalconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_dataassinaturaconvoriginalconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si184_dataassinaturaconvoriginalconge_dia"] !="") ) {
       $sql  .= $virgula." si184_dataassinaturaconvoriginalconge = '$this->si184_dataassinaturaconvoriginalconge' ";
       $virgula = ",";
       if (trim($this->si184_dataassinaturaconvoriginalconge) == null ) {
         $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
         $this->erro_campo = "si184_dataassinaturaconvoriginalconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si184_dataassinaturaconvoriginalconge_dia"])) {
         $sql  .= $virgula." si184_dataassinaturaconvoriginalconge = null ";
         $virgula = ",";
         if (trim($this->si184_dataassinaturaconvoriginalconge) == null ) {
           $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
           $this->erro_campo = "si184_dataassinaturaconvoriginalconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si184_numeroparcela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_numeroparcela"])) {
       $sql  .= $virgula." si184_numeroparcela = $this->si184_numeroparcela ";
       $virgula = ",";
       if (trim($this->si184_numeroparcela) == null ) {
         $this->erro_sql = " Campo Número da parcela não informado.";
         $this->erro_campo = "si184_numeroparcela";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_datarepasseconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_datarepasseconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si184_datarepasseconge_dia"] !="") ) {
       $sql  .= $virgula." si184_datarepasseconge = '$this->si184_datarepasseconge' ";
       $virgula = ",";
       if (trim($this->si184_datarepasseconge) == null ) {
         $this->erro_sql = " Campo Data do repasse não informado.";
         $this->erro_campo = "si184_datarepasseconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si184_datarepasseconge_dia"])) {
         $sql  .= $virgula." si184_datarepasseconge = null ";
         $virgula = ",";
         if (trim($this->si184_datarepasseconge) == null ) {
           $this->erro_sql = " Campo Data do repasse não informado.";
           $this->erro_campo = "si184_datarepasseconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si184_vlrepassadoconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_vlrepassadoconge"])) {
       $sql  .= $virgula." si184_vlrepassadoconge = $this->si184_vlrepassadoconge ";
       $virgula = ",";
       if (trim($this->si184_vlrepassadoconge) == null ) {
         $this->erro_sql = " Campo Valor repassado da parcela não informado.";
         $this->erro_campo = "si184_vlrepassadoconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_banco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_banco"])) {
       $sql  .= $virgula." si184_banco = $this->si184_banco ";
       $virgula = ",";
       if (trim($this->si184_banco) == null ) {
         $this->erro_sql = " Campo Número do banco  para o qual foi repass não informado.";
         $this->erro_campo = "si184_banco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_agencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_agencia"])) {
       $sql  .= $virgula." si184_agencia = '$this->si184_agencia' ";
       $virgula = ",";
       if (trim($this->si184_agencia) == null ) {
         $this->erro_sql = " Campo Número da agência bancária não informado.";
         $this->erro_campo = "si184_agencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_digitoverificadoragencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_digitoverificadoragencia"])) {
       $sql  .= $virgula." si184_digitoverificadoragencia = '$this->si184_digitoverificadoragencia' ";
       $virgula = ",";
       if (trim($this->si184_digitoverificadoragencia) == null ) {
         $this->erro_sql = " Campo Digito verificador Agência não informado.";
         $this->erro_campo = "si184_digitoverificadoragencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_contabancaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_contabancaria"])) {
       $sql  .= $virgula." si184_contabancaria = $this->si184_contabancaria ";
       $virgula = ",";
       if (trim($this->si184_contabancaria) == null ) {
         $this->erro_sql = " Campo Número da conta bancária não informado.";
         $this->erro_campo = "si184_contabancaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_digitoverificadorcontabancaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_digitoverificadorcontabancaria"])) {
       $sql  .= $virgula." si184_digitoverificadorcontabancaria = '$this->si184_digitoverificadorcontabancaria' ";
       $virgula = ",";
       if (trim($this->si184_digitoverificadorcontabancaria) == null ) {
         $this->erro_sql = " Campo Dígito verificador da conta bancária não informado.";
         $this->erro_campo = "si184_digitoverificadorcontabancaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_tipodocumentotitularconta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_tipodocumentotitularconta"])) {
       $sql  .= $virgula." si184_tipodocumentotitularconta = $this->si184_tipodocumentotitularconta ";
       $virgula = ",";
       if (trim($this->si184_tipodocumentotitularconta) == null ) {
         $this->erro_sql = " Campo Tipo do documento do titular da conta não informado.";
         $this->erro_campo = "si184_tipodocumentotitularconta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_nrodocumentotitularconta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_nrodocumentotitularconta"])) {
       $sql  .= $virgula." si184_nrodocumentotitularconta = '$this->si184_nrodocumentotitularconta' ";
       $virgula = ",";
       if (trim($this->si184_nrodocumentotitularconta) == null ) {
         $this->erro_sql = " Campo Número do  documento do titular da conta não informado.";
         $this->erro_campo = "si184_nrodocumentotitularconta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_prazoprestacontas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_prazoprestacontas_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si184_prazoprestacontas_dia"] !="") ) {
       $sql  .= $virgula." si184_prazoprestacontas = '$this->si184_prazoprestacontas' ";
       $virgula = ",";
       if (trim($this->si184_prazoprestacontas) == null ) {
         $this->erro_sql = " Campo Data final para prestação de contas não informado.";
         $this->erro_campo = "si184_prazoprestacontas_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si184_prazoprestacontas_dia"])) {
         $sql  .= $virgula." si184_prazoprestacontas = null ";
         $virgula = ",";
         if (trim($this->si184_prazoprestacontas) == null ) {
           $this->erro_sql = " Campo Data final para prestação de contas não informado.";
           $this->erro_campo = "si184_prazoprestacontas_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si184_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_mes"])) {
       $sql  .= $virgula." si184_mes = $this->si184_mes ";
       $virgula = ",";
       if (trim($this->si184_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si184_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si184_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si184_instit"])) {
       $sql  .= $virgula." si184_instit = $this->si184_instit ";
       $virgula = ",";
       if (trim($this->si184_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si184_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si184_sequencial!=null) {
       $sql .= " si184_sequencial = $this->si184_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si184_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011941,'$this->si184_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_sequencial"]) || $this->si184_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011941,'".AddSlashes(pg_result($resaco,$conresaco,'si184_sequencial'))."','$this->si184_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"]) || $this->si184_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011925,'".AddSlashes(pg_result($resaco,$conresaco,'si184_tiporegistro'))."','$this->si184_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_codorgao"]) || $this->si184_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011926,'".AddSlashes(pg_result($resaco,$conresaco,'si184_codorgao'))."','$this->si184_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_codunidadesub"]) || $this->si184_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011927,'".AddSlashes(pg_result($resaco,$conresaco,'si184_codunidadesub'))."','$this->si184_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_nroconvenioconge"]) || $this->si184_nroconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011928,'".AddSlashes(pg_result($resaco,$conresaco,'si184_nroconvenioconge'))."','$this->si184_nroconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_dataassinaturaconvoriginalconge"]) || $this->si184_dataassinaturaconvoriginalconge != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011929,'".AddSlashes(pg_result($resaco,$conresaco,'si184_dataassinaturaconvoriginalconge'))."','$this->si184_dataassinaturaconvoriginalconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_numeroparcela"]) || $this->si184_numeroparcela != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011930,'".AddSlashes(pg_result($resaco,$conresaco,'si184_numeroparcela'))."','$this->si184_numeroparcela',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_datarepasseconge"]) || $this->si184_datarepasseconge != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011931,'".AddSlashes(pg_result($resaco,$conresaco,'si184_datarepasseconge'))."','$this->si184_datarepasseconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_vlrepassadoconge"]) || $this->si184_vlrepassadoconge != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011932,'".AddSlashes(pg_result($resaco,$conresaco,'si184_vlrepassadoconge'))."','$this->si184_vlrepassadoconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_banco"]) || $this->si184_banco != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011933,'".AddSlashes(pg_result($resaco,$conresaco,'si184_banco'))."','$this->si184_banco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_agencia"]) || $this->si184_agencia != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011934,'".AddSlashes(pg_result($resaco,$conresaco,'si184_agencia'))."','$this->si184_agencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_digitoverificadoragencia"]) || $this->si184_digitoverificadoragencia != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011935,'".AddSlashes(pg_result($resaco,$conresaco,'si184_digitoverificadoragencia'))."','$this->si184_digitoverificadoragencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_contabancaria"]) || $this->si184_contabancaria != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011936,'".AddSlashes(pg_result($resaco,$conresaco,'si184_contabancaria'))."','$this->si184_contabancaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_digitoverificadorcontabancaria"]) || $this->si184_digitoverificadorcontabancaria != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011937,'".AddSlashes(pg_result($resaco,$conresaco,'si184_digitoverificadorcontabancaria'))."','$this->si184_digitoverificadorcontabancaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_tipodocumentotitularconta"]) || $this->si184_tipodocumentotitularconta != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011938,'".AddSlashes(pg_result($resaco,$conresaco,'si184_tipodocumentotitularconta'))."','$this->si184_tipodocumentotitularconta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_nrodocumentotitularconta"]) || $this->si184_nrodocumentotitularconta != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011939,'".AddSlashes(pg_result($resaco,$conresaco,'si184_nrodocumentotitularconta'))."','$this->si184_nrodocumentotitularconta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_prazoprestacontas"]) || $this->si184_prazoprestacontas != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011940,'".AddSlashes(pg_result($resaco,$conresaco,'si184_prazoprestacontas'))."','$this->si184_prazoprestacontas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_mes"]) || $this->si184_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011942,'".AddSlashes(pg_result($resaco,$conresaco,'si184_mes'))."','$this->si184_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si184_instit"]) || $this->si184_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010197,2011943,'".AddSlashes(pg_result($resaco,$conresaco,'si184_instit'))."','$this->si184_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Repasses Realizados por meio de Convên nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si184_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Repasses Realizados por meio de Convên nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si184_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si184_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si184_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si184_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011941,'$si184_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011941,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011925,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011926,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011927,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011928,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011929,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011930,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_numeroparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011931,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_datarepasseconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011932,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_vlrepassadoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011933,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_banco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011934,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_agencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011935,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_digitoverificadoragencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011936,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_contabancaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011937,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_digitoverificadorcontabancaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011938,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_tipodocumentotitularconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011939,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_nrodocumentotitularconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011940,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_prazoprestacontas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011942,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,2011943,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from conge302021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si184_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si184_sequencial = $si184_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Repasses Realizados por meio de Convên nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si184_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Repasses Realizados por meio de Convên nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si184_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si184_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:conge302021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si184_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge302021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si184_sequencial!=null ) {
         $sql2 .= " where conge302021.si184_sequencial = $si184_sequencial ";
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
  function sql_query_file ( $si184_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge302021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si184_sequencial!=null ) {
         $sql2 .= " where conge302021.si184_sequencial = $si184_sequencial ";
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
