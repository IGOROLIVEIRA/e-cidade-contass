<?php
//MODULO: sicom
//CLASSE DA ENTIDADE tce102021
class cl_tce102021 {
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
  public $si187_sequencial = 0;
  public $si187_tiporegistro = 0;
  public $si187_numprocessotce = null;
  public $si187_datainstauracaotce_dia = null;
  public $si187_datainstauracaotce_mes = null;
  public $si187_datainstauracaotce_ano = null;
  public $si187_datainstauracaotce = null;
  public $si187_codunidadesub = null;
  public $si187_nroconvenioconge = null;
  public $si187_dataassinaturaconvoriginalconge_dia = null;
  public $si187_dataassinaturaconvoriginalconge_mes = null;
  public $si187_dataassinaturaconvoriginalconge_ano = null;
  public $si187_dataassinaturaconvoriginalconge = null;
  public $si187_dscinstrumelegaltce = null;
  public $si187_nrocpfautoridadeinstauratce = null;
  public $si187_dsccargoresptce = null;
  public $si187_vloriginaldano = 0;
  public $si187_vlatualizadodano = 0;
  public $si187_dataatualizacao_dia = null;
  public $si187_dataatualizacao_mes = null;
  public $si187_dataatualizacao_ano = null;
  public $si187_dataatualizacao = null;
  public $si187_indice = null;
  public $si187_ocorrehipotese = 0;
  public $si187_identiresponsavel = 0;
  public $si187_mes = 0;
  public $si187_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si187_sequencial = int8 = Sequencial
                 si187_tiporegistro = int8 = Tipo do Registro
                 si187_numprocessotce = varchar(12) = Número do processo da tomada de contas
                 si187_datainstauracaotce = date = Data da instauração da tomada de contas
                 si187_codunidadesub = varchar(8) = Código da unidade ou subunidade orçam
                 si187_nroconvenioconge = varchar(30) = Número do convênio original ou instr
                 si187_dataassinaturaconvoriginalconge = date = Data da assinatura do convênio original
                 si187_dscinstrumelegaltce = varchar(50) = Instrumento Legal de Instauração da TCE
                 si187_nrocpfautoridadeinstauratce = varchar(11) = Número do CPF do responsável
                 si187_dsccargoresptce = varchar(50) = Cargo do responsável pela instauração
                 si187_vloriginaldano = float8 = Valor original do dano
                 si187_vlatualizadodano = float8 = Valor atualizado do dano
                 si187_dataatualizacao = date = Data da atualização do valor do dano
                 si187_indice = varchar(20) = Índice utilizado
                 si187_ocorrehipotese = int8 = Ocorrência das hipóteses previstas
                 si187_identiresponsavel = int8 = Identificação dos responsáveis com estab
                 si187_mes = int8 = Mês
                 si187_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("tce102021");
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
       $this->si187_sequencial = ($this->si187_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_sequencial"]:$this->si187_sequencial);
       $this->si187_tiporegistro = ($this->si187_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_tiporegistro"]:$this->si187_tiporegistro);
       $this->si187_numprocessotce = ($this->si187_numprocessotce == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_numprocessotce"]:$this->si187_numprocessotce);
       if ($this->si187_datainstauracaotce == "") {
         $this->si187_datainstauracaotce_dia = ($this->si187_datainstauracaotce_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_datainstauracaotce_dia"]:$this->si187_datainstauracaotce_dia);
         $this->si187_datainstauracaotce_mes = ($this->si187_datainstauracaotce_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_datainstauracaotce_mes"]:$this->si187_datainstauracaotce_mes);
         $this->si187_datainstauracaotce_ano = ($this->si187_datainstauracaotce_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_datainstauracaotce_ano"]:$this->si187_datainstauracaotce_ano);
         if ($this->si187_datainstauracaotce_dia != "") {
            $this->si187_datainstauracaotce = $this->si187_datainstauracaotce_ano."-".$this->si187_datainstauracaotce_mes."-".$this->si187_datainstauracaotce_dia;
         }
       }
       $this->si187_codunidadesub = ($this->si187_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_codunidadesub"]:$this->si187_codunidadesub);
       $this->si187_nroconvenioconge = ($this->si187_nroconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_nroconvenioconge"]:$this->si187_nroconvenioconge);
       if ($this->si187_dataassinaturaconvoriginalconge == "") {
         $this->si187_dataassinaturaconvoriginalconge_dia = ($this->si187_dataassinaturaconvoriginalconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dataassinaturaconvoriginalconge_dia"]:$this->si187_dataassinaturaconvoriginalconge_dia);
         $this->si187_dataassinaturaconvoriginalconge_mes = ($this->si187_dataassinaturaconvoriginalconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dataassinaturaconvoriginalconge_mes"]:$this->si187_dataassinaturaconvoriginalconge_mes);
         $this->si187_dataassinaturaconvoriginalconge_ano = ($this->si187_dataassinaturaconvoriginalconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dataassinaturaconvoriginalconge_ano"]:$this->si187_dataassinaturaconvoriginalconge_ano);
         if ($this->si187_dataassinaturaconvoriginalconge_dia != "") {
            $this->si187_dataassinaturaconvoriginalconge = $this->si187_dataassinaturaconvoriginalconge_ano."-".$this->si187_dataassinaturaconvoriginalconge_mes."-".$this->si187_dataassinaturaconvoriginalconge_dia;
         }
       }
       $this->si187_dscinstrumelegaltce = ($this->si187_dscinstrumelegaltce == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dscinstrumelegaltce"]:$this->si187_dscinstrumelegaltce);
       $this->si187_nrocpfautoridadeinstauratce = ($this->si187_nrocpfautoridadeinstauratce == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_nrocpfautoridadeinstauratce"]:$this->si187_nrocpfautoridadeinstauratce);
       $this->si187_dsccargoresptce = ($this->si187_dsccargoresptce == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dsccargoresptce"]:$this->si187_dsccargoresptce);
       $this->si187_vloriginaldano = ($this->si187_vloriginaldano == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_vloriginaldano"]:$this->si187_vloriginaldano);
       $this->si187_vlatualizadodano = ($this->si187_vlatualizadodano == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_vlatualizadodano"]:$this->si187_vlatualizadodano);
       if ($this->si187_dataatualizacao == "") {
         $this->si187_dataatualizacao_dia = ($this->si187_dataatualizacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dataatualizacao_dia"]:$this->si187_dataatualizacao_dia);
         $this->si187_dataatualizacao_mes = ($this->si187_dataatualizacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dataatualizacao_mes"]:$this->si187_dataatualizacao_mes);
         $this->si187_dataatualizacao_ano = ($this->si187_dataatualizacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_dataatualizacao_ano"]:$this->si187_dataatualizacao_ano);
         if ($this->si187_dataatualizacao_dia != "") {
            $this->si187_dataatualizacao = $this->si187_dataatualizacao_ano."-".$this->si187_dataatualizacao_mes."-".$this->si187_dataatualizacao_dia;
         }
       }
       $this->si187_indice = ($this->si187_indice == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_indice"]:$this->si187_indice);
       $this->si187_ocorrehipotese = ($this->si187_ocorrehipotese == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_ocorrehipotese"]:$this->si187_ocorrehipotese);
       $this->si187_identiresponsavel = ($this->si187_identiresponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_identiresponsavel"]:$this->si187_identiresponsavel);
       $this->si187_mes = ($this->si187_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_mes"]:$this->si187_mes);
       $this->si187_instit = ($this->si187_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_instit"]:$this->si187_instit);
     } else {
       $this->si187_sequencial = ($this->si187_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si187_sequencial"]:$this->si187_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si187_sequencial) {
      $this->atualizacampos();
     if ($this->si187_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si187_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_numprocessotce == null ) {
       $this->erro_sql = " Campo Número do processo da tomada de contas não informado.";
       $this->erro_campo = "si187_numprocessotce";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_datainstauracaotce == null ) {
       $this->erro_sql = " Campo Data da instauração da tomada de contas não informado.";
       $this->erro_campo = "si187_datainstauracaotce_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si187_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_nroconvenioconge == null ) {
       $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
       $this->erro_campo = "si187_nroconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_dataassinaturaconvoriginalconge == null ) {
       $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
       $this->erro_campo = "si187_dataassinaturaconvoriginalconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_dscinstrumelegaltce == null ) {
       $this->erro_sql = " Campo Instrumento Legal de Instauração da TCE não informado.";
       $this->erro_campo = "si187_dscinstrumelegaltce";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_nrocpfautoridadeinstauratce == null ) {
       $this->erro_sql = " Campo Número do CPF do responsável não informado.";
       $this->erro_campo = "si187_nrocpfautoridadeinstauratce";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_dsccargoresptce == null ) {
       $this->erro_sql = " Campo Cargo do responsável pela instauração não informado.";
       $this->erro_campo = "si187_dsccargoresptce";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_vloriginaldano == null ) {
       $this->erro_sql = " Campo Valor original do dano não informado.";
       $this->erro_campo = "si187_vloriginaldano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_vlatualizadodano == null ) {
       $this->erro_sql = " Campo Valor atualizado do dano não informado.";
       $this->erro_campo = "si187_vlatualizadodano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_dataatualizacao == null ) {
       $this->erro_sql = " Campo Data da atualização do valor do dano não informado.";
       $this->erro_campo = "si187_dataatualizacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_indice == null ) {
       $this->erro_sql = " Campo Índice utilizado não informado.";
       $this->erro_campo = "si187_indice";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_ocorrehipotese == null ) {
       $this->erro_sql = " Campo Ocorrência das hipóteses previstas não informado.";
       $this->erro_campo = "si187_ocorrehipotese";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_identiresponsavel == null ) {
       $this->erro_sql = " Campo Identificação dos responsáveis com estab não informado.";
       $this->erro_campo = "si187_identiresponsavel";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si187_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si187_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si187_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si187_sequencial = $si187_sequencial;
     if (($this->si187_sequencial == null) || ($this->si187_sequencial == "") ) {
       $this->erro_sql = " Campo si187_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into tce102021(
                                       si187_sequencial
                                      ,si187_tiporegistro
                                      ,si187_numprocessotce
                                      ,si187_datainstauracaotce
                                      ,si187_codunidadesub
                                      ,si187_nroconvenioconge
                                      ,si187_dataassinaturaconvoriginalconge
                                      ,si187_dscinstrumelegaltce
                                      ,si187_nrocpfautoridadeinstauratce
                                      ,si187_dsccargoresptce
                                      ,si187_vloriginaldano
                                      ,si187_vlatualizadodano
                                      ,si187_dataatualizacao
                                      ,si187_indice
                                      ,si187_ocorrehipotese
                                      ,si187_identiresponsavel
                                      ,si187_mes
                                      ,si187_instit
                       )
                values (
                                $this->si187_sequencial
                               ,$this->si187_tiporegistro
                               ,'$this->si187_numprocessotce'
                               ,".($this->si187_datainstauracaotce == "null" || $this->si187_datainstauracaotce == ""?"null":"'".$this->si187_datainstauracaotce."'")."
                               ,'$this->si187_codunidadesub'
                               ,'$this->si187_nroconvenioconge'
                               ,".($this->si187_dataassinaturaconvoriginalconge == "null" || $this->si187_dataassinaturaconvoriginalconge == ""?"null":"'".$this->si187_dataassinaturaconvoriginalconge."'")."
                               ,'$this->si187_dscinstrumelegaltce'
                               ,'$this->si187_nrocpfautoridadeinstauratce'
                               ,'$this->si187_dsccargoresptce'
                               ,$this->si187_vloriginaldano
                               ,$this->si187_vlatualizadodano
                               ,".($this->si187_dataatualizacao == "null" || $this->si187_dataatualizacao == ""?"null":"'".$this->si187_dataatualizacao."'")."
                               ,'$this->si187_indice'
                               ,$this->si187_ocorrehipotese
                               ,$this->si187_identiresponsavel
                               ,$this->si187_mes
                               ,$this->si187_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Cadastro das Tomadas de Contas Especiais ($this->si187_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro das Tomadas de Contas Especiais já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Cadastro das Tomadas de Contas Especiais ($this->si187_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si187_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si187_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011991,'$this->si187_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010200,2011991,'','".AddSlashes(pg_result($resaco,0,'si187_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011976,'','".AddSlashes(pg_result($resaco,0,'si187_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011977,'','".AddSlashes(pg_result($resaco,0,'si187_numprocessotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011978,'','".AddSlashes(pg_result($resaco,0,'si187_datainstauracaotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011979,'','".AddSlashes(pg_result($resaco,0,'si187_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011980,'','".AddSlashes(pg_result($resaco,0,'si187_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011981,'','".AddSlashes(pg_result($resaco,0,'si187_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011982,'','".AddSlashes(pg_result($resaco,0,'si187_dscinstrumelegaltce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011983,'','".AddSlashes(pg_result($resaco,0,'si187_nrocpfautoridadeinstauratce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011984,'','".AddSlashes(pg_result($resaco,0,'si187_dsccargoresptce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011985,'','".AddSlashes(pg_result($resaco,0,'si187_vloriginaldano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011986,'','".AddSlashes(pg_result($resaco,0,'si187_vlatualizadodano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011987,'','".AddSlashes(pg_result($resaco,0,'si187_dataatualizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011988,'','".AddSlashes(pg_result($resaco,0,'si187_indice'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011989,'','".AddSlashes(pg_result($resaco,0,'si187_ocorrehipotese'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011990,'','".AddSlashes(pg_result($resaco,0,'si187_identiresponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011992,'','".AddSlashes(pg_result($resaco,0,'si187_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,2011993,'','".AddSlashes(pg_result($resaco,0,'si187_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si187_sequencial=null) {
      $this->atualizacampos();
     $sql = " update tce102021 set ";
     $virgula = "";
     if (trim($this->si187_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_sequencial"])) {
       $sql  .= $virgula." si187_sequencial = $this->si187_sequencial ";
       $virgula = ",";
       if (trim($this->si187_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si187_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_tiporegistro"])) {
       $sql  .= $virgula." si187_tiporegistro = $this->si187_tiporegistro ";
       $virgula = ",";
       if (trim($this->si187_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si187_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_numprocessotce)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_numprocessotce"])) {
       $sql  .= $virgula." si187_numprocessotce = '$this->si187_numprocessotce' ";
       $virgula = ",";
       if (trim($this->si187_numprocessotce) == null ) {
         $this->erro_sql = " Campo Número do processo da tomada de contas não informado.";
         $this->erro_campo = "si187_numprocessotce";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_datainstauracaotce)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_datainstauracaotce_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si187_datainstauracaotce_dia"] !="") ) {
       $sql  .= $virgula." si187_datainstauracaotce = '$this->si187_datainstauracaotce' ";
       $virgula = ",";
       if (trim($this->si187_datainstauracaotce) == null ) {
         $this->erro_sql = " Campo Data da instauração da tomada de contas não informado.";
         $this->erro_campo = "si187_datainstauracaotce_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si187_datainstauracaotce_dia"])) {
         $sql  .= $virgula." si187_datainstauracaotce = null ";
         $virgula = ",";
         if (trim($this->si187_datainstauracaotce) == null ) {
           $this->erro_sql = " Campo Data da instauração da tomada de contas não informado.";
           $this->erro_campo = "si187_datainstauracaotce_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si187_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_codunidadesub"])) {
       $sql  .= $virgula." si187_codunidadesub = '$this->si187_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si187_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si187_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_nroconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_nroconvenioconge"])) {
       $sql  .= $virgula." si187_nroconvenioconge = '$this->si187_nroconvenioconge' ";
       $virgula = ",";
       if (trim($this->si187_nroconvenioconge) == null ) {
         $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
         $this->erro_campo = "si187_nroconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_dataassinaturaconvoriginalconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_dataassinaturaconvoriginalconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si187_dataassinaturaconvoriginalconge_dia"] !="") ) {
       $sql  .= $virgula." si187_dataassinaturaconvoriginalconge = '$this->si187_dataassinaturaconvoriginalconge' ";
       $virgula = ",";
       if (trim($this->si187_dataassinaturaconvoriginalconge) == null ) {
         $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
         $this->erro_campo = "si187_dataassinaturaconvoriginalconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si187_dataassinaturaconvoriginalconge_dia"])) {
         $sql  .= $virgula." si187_dataassinaturaconvoriginalconge = null ";
         $virgula = ",";
         if (trim($this->si187_dataassinaturaconvoriginalconge) == null ) {
           $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
           $this->erro_campo = "si187_dataassinaturaconvoriginalconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si187_dscinstrumelegaltce)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_dscinstrumelegaltce"])) {
       $sql  .= $virgula." si187_dscinstrumelegaltce = '$this->si187_dscinstrumelegaltce' ";
       $virgula = ",";
       if (trim($this->si187_dscinstrumelegaltce) == null ) {
         $this->erro_sql = " Campo Instrumento Legal de Instauração da TCE não informado.";
         $this->erro_campo = "si187_dscinstrumelegaltce";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_nrocpfautoridadeinstauratce)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_nrocpfautoridadeinstauratce"])) {
       $sql  .= $virgula." si187_nrocpfautoridadeinstauratce = '$this->si187_nrocpfautoridadeinstauratce' ";
       $virgula = ",";
       if (trim($this->si187_nrocpfautoridadeinstauratce) == null ) {
         $this->erro_sql = " Campo Número do CPF do responsável não informado.";
         $this->erro_campo = "si187_nrocpfautoridadeinstauratce";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_dsccargoresptce)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_dsccargoresptce"])) {
       $sql  .= $virgula." si187_dsccargoresptce = '$this->si187_dsccargoresptce' ";
       $virgula = ",";
       if (trim($this->si187_dsccargoresptce) == null ) {
         $this->erro_sql = " Campo Cargo do responsável pela instauração não informado.";
         $this->erro_campo = "si187_dsccargoresptce";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_vloriginaldano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_vloriginaldano"])) {
       $sql  .= $virgula." si187_vloriginaldano = $this->si187_vloriginaldano ";
       $virgula = ",";
       if (trim($this->si187_vloriginaldano) == null ) {
         $this->erro_sql = " Campo Valor original do dano não informado.";
         $this->erro_campo = "si187_vloriginaldano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_vlatualizadodano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_vlatualizadodano"])) {
       $sql  .= $virgula." si187_vlatualizadodano = $this->si187_vlatualizadodano ";
       $virgula = ",";
       if (trim($this->si187_vlatualizadodano) == null ) {
         $this->erro_sql = " Campo Valor atualizado do dano não informado.";
         $this->erro_campo = "si187_vlatualizadodano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_dataatualizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_dataatualizacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si187_dataatualizacao_dia"] !="") ) {
       $sql  .= $virgula." si187_dataatualizacao = '$this->si187_dataatualizacao' ";
       $virgula = ",";
       if (trim($this->si187_dataatualizacao) == null ) {
         $this->erro_sql = " Campo Data da atualização do valor do dano não informado.";
         $this->erro_campo = "si187_dataatualizacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si187_dataatualizacao_dia"])) {
         $sql  .= $virgula." si187_dataatualizacao = null ";
         $virgula = ",";
         if (trim($this->si187_dataatualizacao) == null ) {
           $this->erro_sql = " Campo Data da atualização do valor do dano não informado.";
           $this->erro_campo = "si187_dataatualizacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si187_indice)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_indice"])) {
       $sql  .= $virgula." si187_indice = '$this->si187_indice' ";
       $virgula = ",";
       if (trim($this->si187_indice) == null ) {
         $this->erro_sql = " Campo Índice utilizado não informado.";
         $this->erro_campo = "si187_indice";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_ocorrehipotese)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_ocorrehipotese"])) {
       $sql  .= $virgula." si187_ocorrehipotese = $this->si187_ocorrehipotese ";
       $virgula = ",";
       if (trim($this->si187_ocorrehipotese) == null ) {
         $this->erro_sql = " Campo Ocorrência das hipóteses previstas não informado.";
         $this->erro_campo = "si187_ocorrehipotese";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_identiresponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_identiresponsavel"])) {
       $sql  .= $virgula." si187_identiresponsavel = $this->si187_identiresponsavel ";
       $virgula = ",";
       if (trim($this->si187_identiresponsavel) == null ) {
         $this->erro_sql = " Campo Identificação dos responsáveis com estab não informado.";
         $this->erro_campo = "si187_identiresponsavel";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_mes"])) {
       $sql  .= $virgula." si187_mes = $this->si187_mes ";
       $virgula = ",";
       if (trim($this->si187_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si187_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si187_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si187_instit"])) {
       $sql  .= $virgula." si187_instit = $this->si187_instit ";
       $virgula = ",";
       if (trim($this->si187_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si187_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si187_sequencial!=null) {
       $sql .= " si187_sequencial = $this->si187_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
   /*  if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si187_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011991,'$this->si187_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_sequencial"]) || $this->si187_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011991,'".AddSlashes(pg_result($resaco,$conresaco,'si187_sequencial'))."','$this->si187_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_tiporegistro"]) || $this->si187_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011976,'".AddSlashes(pg_result($resaco,$conresaco,'si187_tiporegistro'))."','$this->si187_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_numprocessotce"]) || $this->si187_numprocessotce != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011977,'".AddSlashes(pg_result($resaco,$conresaco,'si187_numprocessotce'))."','$this->si187_numprocessotce',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_datainstauracaotce"]) || $this->si187_datainstauracaotce != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011978,'".AddSlashes(pg_result($resaco,$conresaco,'si187_datainstauracaotce'))."','$this->si187_datainstauracaotce',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_codunidadesub"]) || $this->si187_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011979,'".AddSlashes(pg_result($resaco,$conresaco,'si187_codunidadesub'))."','$this->si187_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_nroconvenioconge"]) || $this->si187_nroconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011980,'".AddSlashes(pg_result($resaco,$conresaco,'si187_nroconvenioconge'))."','$this->si187_nroconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_dataassinaturaconvoriginalconge"]) || $this->si187_dataassinaturaconvoriginalconge != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011981,'".AddSlashes(pg_result($resaco,$conresaco,'si187_dataassinaturaconvoriginalconge'))."','$this->si187_dataassinaturaconvoriginalconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_dscinstrumelegaltce"]) || $this->si187_dscinstrumelegaltce != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011982,'".AddSlashes(pg_result($resaco,$conresaco,'si187_dscinstrumelegaltce'))."','$this->si187_dscinstrumelegaltce',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_nrocpfautoridadeinstauratce"]) || $this->si187_nrocpfautoridadeinstauratce != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011983,'".AddSlashes(pg_result($resaco,$conresaco,'si187_nrocpfautoridadeinstauratce'))."','$this->si187_nrocpfautoridadeinstauratce',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_dsccargoresptce"]) || $this->si187_dsccargoresptce != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011984,'".AddSlashes(pg_result($resaco,$conresaco,'si187_dsccargoresptce'))."','$this->si187_dsccargoresptce',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_vloriginaldano"]) || $this->si187_vloriginaldano != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011985,'".AddSlashes(pg_result($resaco,$conresaco,'si187_vloriginaldano'))."','$this->si187_vloriginaldano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_vlatualizadodano"]) || $this->si187_vlatualizadodano != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011986,'".AddSlashes(pg_result($resaco,$conresaco,'si187_vlatualizadodano'))."','$this->si187_vlatualizadodano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_dataatualizacao"]) || $this->si187_dataatualizacao != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011987,'".AddSlashes(pg_result($resaco,$conresaco,'si187_dataatualizacao'))."','$this->si187_dataatualizacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_indice"]) || $this->si187_indice != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011988,'".AddSlashes(pg_result($resaco,$conresaco,'si187_indice'))."','$this->si187_indice',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_ocorrehipotese"]) || $this->si187_ocorrehipotese != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011989,'".AddSlashes(pg_result($resaco,$conresaco,'si187_ocorrehipotese'))."','$this->si187_ocorrehipotese',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_identiresponsavel"]) || $this->si187_identiresponsavel != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011990,'".AddSlashes(pg_result($resaco,$conresaco,'si187_identiresponsavel'))."','$this->si187_identiresponsavel',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_mes"]) || $this->si187_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011992,'".AddSlashes(pg_result($resaco,$conresaco,'si187_mes'))."','$this->si187_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si187_instit"]) || $this->si187_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010200,2011993,'".AddSlashes(pg_result($resaco,$conresaco,'si187_instit'))."','$this->si187_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro das Tomadas de Contas Especiais nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si187_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro das Tomadas de Contas Especiais nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si187_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si187_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si187_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si187_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011991,'$si187_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011991,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011976,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011977,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_numprocessotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011978,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_datainstauracaotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011979,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011980,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011981,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011982,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_dscinstrumelegaltce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011983,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_nrocpfautoridadeinstauratce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011984,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_dsccargoresptce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011985,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_vloriginaldano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011986,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_vlatualizadodano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011987,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_dataatualizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011988,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_indice'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011989,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_ocorrehipotese'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011990,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_identiresponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011992,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,2011993,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from tce102021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si187_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si187_sequencial = $si187_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro das Tomadas de Contas Especiais nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si187_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro das Tomadas de Contas Especiais nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si187_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si187_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:tce102021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si187_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from tce102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si187_sequencial!=null ) {
         $sql2 .= " where tce102021.si187_sequencial = $si187_sequencial ";
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
  function sql_query_file ( $si187_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from tce102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si187_sequencial!=null ) {
         $sql2 .= " where tce102021.si187_sequencial = $si187_sequencial ";
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
