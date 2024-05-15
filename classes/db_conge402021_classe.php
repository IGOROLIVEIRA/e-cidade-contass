<?php
//MODULO: sicom
//CLASSE DA ENTIDADE conge402021
class cl_conge402021 {
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
  public $si185_sequencial = 0;
  public $si185_tiporegistro = 0;
  public $si185_codorgao = null;
  public $si185_codunidadesub = null;
  public $si185_nroconvenioconge = null;
  public $si185_dataassinaturaconvoriginalconge_dia = null;
  public $si185_dataassinaturaconvoriginalconge_mes = null;
  public $si185_dataassinaturaconvoriginalconge_ano = null;
  public $si185_dataassinaturaconvoriginalconge = null;
  public $si185_numeroparcela = 0;
  public $si185_datarepasseconge_dia = null;
  public $si185_datarepasseconge_mes = null;
  public $si185_datarepasseconge_ano = null;
  public $si185_datarepasseconge = null;
  public $si185_prestacaocontasparcela = 0;
  public $si185_dataprestacontasparcela_dia = null;
  public $si185_dataprestacontasparcela_mes = null;
  public $si185_dataprestacontasparcela_ano = null;
  public $si185_dataprestacontasparcela = null;
  public $si185_prestacaocontas = 0;
  public $si185_datacienfatos_dia = null;
  public $si185_datacienfatos_mes = null;
  public $si185_datacienfatos_ano = null;
  public $si185_datacienfatos = null;
  public $si185_prorrogprazo = 0;
  public $si185_dataprorrogprazo_dia = null;
  public $si185_dataprorrogprazo_mes = null;
  public $si185_dataprorrogprazo_ano = null;
  public $si185_dataprorrogprazo = null;
  public $si185_nrocpfrespprestconge = null;
  public $si185_dsccargorespprestconge = null;
  public $si185_mes = 0;
  public $si185_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si185_sequencial = int8 = Sequencial
                 si185_tiporegistro = int8 = Tipo do Registro
                 si185_codorgao = varchar(2) = Código do órgão
                 si185_codunidadesub = varchar(8) = Código da unidade ou subunidade orçam
                 si185_nroconvenioconge = varchar(30) = Número do convênio original ou instr
                 si185_dataassinaturaconvoriginalconge = date = Data da assinatura do convênio original
                 si185_numeroparcela = int8 = Número da parcela
                 si185_datarepasseconge = date = Data do repasse
                 si185_prestacaocontasparcela = int8 = Informar se houve prestação de contas
                 si185_dataprestacontasparcela = date = Data da efetiva prestação de contas
                 si185_prestacaocontas = int8 = Resultado da análise da prestação de con
                 si185_datacienfatos = date = Data da ciência dos fatos
                 si185_prorrogprazo = int8 = Informar se houve prorrogação de prazo
                 si185_dataprorrogprazo = date = Nova data final para prestação de contas
                 si185_nrocpfrespprestconge = varchar(11) = Número do CPF do responsável pela aprova
                 si185_dsccargorespprestconge = varchar(50) = Cargo do responsável pela aprovação
                 si185_mes = int8 = Mês
                 si185_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conge402021");
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
       $this->si185_sequencial = ($this->si185_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_sequencial"]:$this->si185_sequencial);
       $this->si185_tiporegistro = ($this->si185_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"]:$this->si185_tiporegistro);
       $this->si185_codorgao = ($this->si185_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_codorgao"]:$this->si185_codorgao);
       $this->si185_codunidadesub = ($this->si185_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_codunidadesub"]:$this->si185_codunidadesub);
       $this->si185_nroconvenioconge = ($this->si185_nroconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_nroconvenioconge"]:$this->si185_nroconvenioconge);
       if ($this->si185_dataassinaturaconvoriginalconge == "") {
         $this->si185_dataassinaturaconvoriginalconge_dia = ($this->si185_dataassinaturaconvoriginalconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataassinaturaconvoriginalconge_dia"]:$this->si185_dataassinaturaconvoriginalconge_dia);
         $this->si185_dataassinaturaconvoriginalconge_mes = ($this->si185_dataassinaturaconvoriginalconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataassinaturaconvoriginalconge_mes"]:$this->si185_dataassinaturaconvoriginalconge_mes);
         $this->si185_dataassinaturaconvoriginalconge_ano = ($this->si185_dataassinaturaconvoriginalconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataassinaturaconvoriginalconge_ano"]:$this->si185_dataassinaturaconvoriginalconge_ano);
         if ($this->si185_dataassinaturaconvoriginalconge_dia != "") {
            $this->si185_dataassinaturaconvoriginalconge = $this->si185_dataassinaturaconvoriginalconge_ano."-".$this->si185_dataassinaturaconvoriginalconge_mes."-".$this->si185_dataassinaturaconvoriginalconge_dia;
         }
       }
       $this->si185_numeroparcela = ($this->si185_numeroparcela == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_numeroparcela"]:$this->si185_numeroparcela);
       if ($this->si185_datarepasseconge == "") {
         $this->si185_datarepasseconge_dia = ($this->si185_datarepasseconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_datarepasseconge_dia"]:$this->si185_datarepasseconge_dia);
         $this->si185_datarepasseconge_mes = ($this->si185_datarepasseconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_datarepasseconge_mes"]:$this->si185_datarepasseconge_mes);
         $this->si185_datarepasseconge_ano = ($this->si185_datarepasseconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_datarepasseconge_ano"]:$this->si185_datarepasseconge_ano);
         if ($this->si185_datarepasseconge_dia != "") {
            $this->si185_datarepasseconge = $this->si185_datarepasseconge_ano."-".$this->si185_datarepasseconge_mes."-".$this->si185_datarepasseconge_dia;
         }
       }
       $this->si185_prestacaocontasparcela = ($this->si185_prestacaocontasparcela == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_prestacaocontasparcela"]:$this->si185_prestacaocontasparcela);
       if ($this->si185_dataprestacontasparcela == "") {
         $this->si185_dataprestacontasparcela_dia = ($this->si185_dataprestacontasparcela_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataprestacontasparcela_dia"]:$this->si185_dataprestacontasparcela_dia);
         $this->si185_dataprestacontasparcela_mes = ($this->si185_dataprestacontasparcela_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataprestacontasparcela_mes"]:$this->si185_dataprestacontasparcela_mes);
         $this->si185_dataprestacontasparcela_ano = ($this->si185_dataprestacontasparcela_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataprestacontasparcela_ano"]:$this->si185_dataprestacontasparcela_ano);
         if ($this->si185_dataprestacontasparcela_dia != "") {
            $this->si185_dataprestacontasparcela = $this->si185_dataprestacontasparcela_ano."-".$this->si185_dataprestacontasparcela_mes."-".$this->si185_dataprestacontasparcela_dia;
         }
       }
       $this->si185_prestacaocontas = ($this->si185_prestacaocontas == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_prestacaocontas"]:$this->si185_prestacaocontas);
       if ($this->si185_datacienfatos == "") {
         $this->si185_datacienfatos_dia = ($this->si185_datacienfatos_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_datacienfatos_dia"]:$this->si185_datacienfatos_dia);
         $this->si185_datacienfatos_mes = ($this->si185_datacienfatos_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_datacienfatos_mes"]:$this->si185_datacienfatos_mes);
         $this->si185_datacienfatos_ano = ($this->si185_datacienfatos_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_datacienfatos_ano"]:$this->si185_datacienfatos_ano);
         if ($this->si185_datacienfatos_dia != "") {
            $this->si185_datacienfatos = $this->si185_datacienfatos_ano."-".$this->si185_datacienfatos_mes."-".$this->si185_datacienfatos_dia;
         }
       }
       $this->si185_prorrogprazo = ($this->si185_prorrogprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_prorrogprazo"]:$this->si185_prorrogprazo);
       if ($this->si185_dataprorrogprazo == "") {
         $this->si185_dataprorrogprazo_dia = ($this->si185_dataprorrogprazo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataprorrogprazo_dia"]:$this->si185_dataprorrogprazo_dia);
         $this->si185_dataprorrogprazo_mes = ($this->si185_dataprorrogprazo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataprorrogprazo_mes"]:$this->si185_dataprorrogprazo_mes);
         $this->si185_dataprorrogprazo_ano = ($this->si185_dataprorrogprazo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dataprorrogprazo_ano"]:$this->si185_dataprorrogprazo_ano);
         if ($this->si185_dataprorrogprazo_dia != "") {
            $this->si185_dataprorrogprazo = $this->si185_dataprorrogprazo_ano."-".$this->si185_dataprorrogprazo_mes."-".$this->si185_dataprorrogprazo_dia;
         }
       }
       $this->si185_nrocpfrespprestconge = ($this->si185_nrocpfrespprestconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_nrocpfrespprestconge"]:$this->si185_nrocpfrespprestconge);
       $this->si185_dsccargorespprestconge = ($this->si185_dsccargorespprestconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_dsccargorespprestconge"]:$this->si185_dsccargorespprestconge);
       $this->si185_mes = ($this->si185_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_mes"]:$this->si185_mes);
       $this->si185_instit = ($this->si185_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_instit"]:$this->si185_instit);
     } else {
       $this->si185_sequencial = ($this->si185_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_sequencial"]:$this->si185_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si185_sequencial) {
      $this->atualizacampos();
     if ($this->si185_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si185_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si185_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si185_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_nroconvenioconge == null ) {
       $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
       $this->erro_campo = "si185_nroconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_dataassinaturaconvoriginalconge == null ) {
       $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
       $this->erro_campo = "si185_dataassinaturaconvoriginalconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_numeroparcela == null ) {
       $this->erro_sql = " Campo Número da parcela não informado.";
       $this->erro_campo = "si185_numeroparcela";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_datarepasseconge == null ) {
       $this->erro_sql = " Campo Data do repasse não informado.";
       $this->erro_campo = "si185_datarepasseconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_prestacaocontasparcela == null ) {
       $this->erro_sql = " Campo Informar se houve prestação de contas não informado.";
       $this->erro_campo = "si185_prestacaocontasparcela";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_dataprestacontasparcela == null ) {
       $this->erro_sql = " Campo Data da efetiva prestação de contas não informado.";
       $this->erro_campo = "si185_dataprestacontasparcela_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_prestacaocontas == null ) {
       $this->erro_sql = " Campo Resultado da análise da prestação de con não informado.";
       $this->erro_campo = "si185_prestacaocontas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_datacienfatos == null ) {
       $this->erro_sql = " Campo Data da ciência dos fatos não informado.";
       $this->erro_campo = "si185_datacienfatos_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_prorrogprazo == null ) {
       $this->erro_sql = " Campo Informar se houve prorrogação de prazo não informado.";
       $this->erro_campo = "si185_prorrogprazo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_dataprorrogprazo == null ) {
       $this->erro_sql = " Campo Nova data final para prestação de contas não informado.";
       $this->erro_campo = "si185_dataprorrogprazo_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_nrocpfrespprestconge == null ) {
       $this->erro_sql = " Campo Número do CPF do responsável pela aprova não informado.";
       $this->erro_campo = "si185_nrocpfrespprestconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_dsccargorespprestconge == null ) {
       $this->erro_sql = " Campo Cargo do responsável pela aprovação não informado.";
       $this->erro_campo = "si185_dsccargorespprestconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si185_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si185_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si185_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si185_sequencial = $si185_sequencial;
     if (($this->si185_sequencial == null) || ($this->si185_sequencial == "") ) {
       $this->erro_sql = " Campo si185_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conge402021(
                                       si185_sequencial
                                      ,si185_tiporegistro
                                      ,si185_codorgao
                                      ,si185_codunidadesub
                                      ,si185_nroconvenioconge
                                      ,si185_dataassinaturaconvoriginalconge
                                      ,si185_numeroparcela
                                      ,si185_datarepasseconge
                                      ,si185_prestacaocontasparcela
                                      ,si185_dataprestacontasparcela
                                      ,si185_prestacaocontas
                                      ,si185_datacienfatos
                                      ,si185_prorrogprazo
                                      ,si185_dataprorrogprazo
                                      ,si185_nrocpfrespprestconge
                                      ,si185_dsccargorespprestconge
                                      ,si185_mes
                                      ,si185_instit
                       )
                values (
                                $this->si185_sequencial
                               ,$this->si185_tiporegistro
                               ,'$this->si185_codorgao'
                               ,'$this->si185_codunidadesub'
                               ,'$this->si185_nroconvenioconge'
                               ,".($this->si185_dataassinaturaconvoriginalconge == "null" || $this->si185_dataassinaturaconvoriginalconge == ""?"null":"'".$this->si185_dataassinaturaconvoriginalconge."'")."
                               ,$this->si185_numeroparcela
                               ,".($this->si185_datarepasseconge == "null" || $this->si185_datarepasseconge == ""?"null":"'".$this->si185_datarepasseconge."'")."
                               ,$this->si185_prestacaocontasparcela
                               ,".($this->si185_dataprestacontasparcela == "null" || $this->si185_dataprestacontasparcela == ""?"null":"'".$this->si185_dataprestacontasparcela."'")."
                               ,$this->si185_prestacaocontas
                               ,".($this->si185_datacienfatos == "null" || $this->si185_datacienfatos == ""?"null":"'".$this->si185_datacienfatos."'")."
                               ,$this->si185_prorrogprazo
                               ,".($this->si185_dataprorrogprazo == "null" || $this->si185_dataprorrogprazo == ""?"null":"'".$this->si185_dataprorrogprazo."'")."
                               ,'$this->si185_nrocpfrespprestconge'
                               ,'$this->si185_dsccargorespprestconge'
                               ,$this->si185_mes
                               ,$this->si185_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Detalhamento da Prestação de Contas  ($this->si185_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Detalhamento da Prestação de Contas  já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Detalhamento da Prestação de Contas  ($this->si185_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    /* if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si185_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011945,'$this->si185_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010198,2011945,'','".AddSlashes(pg_result($resaco,0,'si185_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011944,'','".AddSlashes(pg_result($resaco,0,'si185_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011948,'','".AddSlashes(pg_result($resaco,0,'si185_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011949,'','".AddSlashes(pg_result($resaco,0,'si185_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011950,'','".AddSlashes(pg_result($resaco,0,'si185_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011951,'','".AddSlashes(pg_result($resaco,0,'si185_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011952,'','".AddSlashes(pg_result($resaco,0,'si185_numeroparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011953,'','".AddSlashes(pg_result($resaco,0,'si185_datarepasseconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011954,'','".AddSlashes(pg_result($resaco,0,'si185_prestacaocontasparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011955,'','".AddSlashes(pg_result($resaco,0,'si185_dataprestacontasparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011956,'','".AddSlashes(pg_result($resaco,0,'si185_prestacaocontas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011957,'','".AddSlashes(pg_result($resaco,0,'si185_datacienfatos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011958,'','".AddSlashes(pg_result($resaco,0,'si185_prorrogprazo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011959,'','".AddSlashes(pg_result($resaco,0,'si185_dataprorrogprazo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011960,'','".AddSlashes(pg_result($resaco,0,'si185_nrocpfrespprestconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011961,'','".AddSlashes(pg_result($resaco,0,'si185_dsccargorespprestconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011946,'','".AddSlashes(pg_result($resaco,0,'si185_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010198,2011947,'','".AddSlashes(pg_result($resaco,0,'si185_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si185_sequencial=null) {
      $this->atualizacampos();
     $sql = " update conge402021 set ";
     $virgula = "";
     if (trim($this->si185_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_sequencial"])) {
       $sql  .= $virgula." si185_sequencial = $this->si185_sequencial ";
       $virgula = ",";
       if (trim($this->si185_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si185_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"])) {
       $sql  .= $virgula." si185_tiporegistro = $this->si185_tiporegistro ";
       $virgula = ",";
       if (trim($this->si185_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si185_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_codorgao"])) {
       $sql  .= $virgula." si185_codorgao = '$this->si185_codorgao' ";
       $virgula = ",";
       if (trim($this->si185_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si185_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_codunidadesub"])) {
       $sql  .= $virgula." si185_codunidadesub = '$this->si185_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si185_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si185_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_nroconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_nroconvenioconge"])) {
       $sql  .= $virgula." si185_nroconvenioconge = '$this->si185_nroconvenioconge' ";
       $virgula = ",";
       if (trim($this->si185_nroconvenioconge) == null ) {
         $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
         $this->erro_campo = "si185_nroconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_dataassinaturaconvoriginalconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_dataassinaturaconvoriginalconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si185_dataassinaturaconvoriginalconge_dia"] !="") ) {
       $sql  .= $virgula." si185_dataassinaturaconvoriginalconge = '$this->si185_dataassinaturaconvoriginalconge' ";
       $virgula = ",";
       if (trim($this->si185_dataassinaturaconvoriginalconge) == null ) {
         $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
         $this->erro_campo = "si185_dataassinaturaconvoriginalconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si185_dataassinaturaconvoriginalconge_dia"])) {
         $sql  .= $virgula." si185_dataassinaturaconvoriginalconge = null ";
         $virgula = ",";
         if (trim($this->si185_dataassinaturaconvoriginalconge) == null ) {
           $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
           $this->erro_campo = "si185_dataassinaturaconvoriginalconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si185_numeroparcela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_numeroparcela"])) {
       $sql  .= $virgula." si185_numeroparcela = $this->si185_numeroparcela ";
       $virgula = ",";
       if (trim($this->si185_numeroparcela) == null ) {
         $this->erro_sql = " Campo Número da parcela não informado.";
         $this->erro_campo = "si185_numeroparcela";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_datarepasseconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_datarepasseconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si185_datarepasseconge_dia"] !="") ) {
       $sql  .= $virgula." si185_datarepasseconge = '$this->si185_datarepasseconge' ";
       $virgula = ",";
       if (trim($this->si185_datarepasseconge) == null ) {
         $this->erro_sql = " Campo Data do repasse não informado.";
         $this->erro_campo = "si185_datarepasseconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si185_datarepasseconge_dia"])) {
         $sql  .= $virgula." si185_datarepasseconge = null ";
         $virgula = ",";
         if (trim($this->si185_datarepasseconge) == null ) {
           $this->erro_sql = " Campo Data do repasse não informado.";
           $this->erro_campo = "si185_datarepasseconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si185_prestacaocontasparcela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_prestacaocontasparcela"])) {
       $sql  .= $virgula." si185_prestacaocontasparcela = $this->si185_prestacaocontasparcela ";
       $virgula = ",";
       if (trim($this->si185_prestacaocontasparcela) == null ) {
         $this->erro_sql = " Campo Informar se houve prestação de contas não informado.";
         $this->erro_campo = "si185_prestacaocontasparcela";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_dataprestacontasparcela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_dataprestacontasparcela_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si185_dataprestacontasparcela_dia"] !="") ) {
       $sql  .= $virgula." si185_dataprestacontasparcela = '$this->si185_dataprestacontasparcela' ";
       $virgula = ",";
       if (trim($this->si185_dataprestacontasparcela) == null ) {
         $this->erro_sql = " Campo Data da efetiva prestação de contas não informado.";
         $this->erro_campo = "si185_dataprestacontasparcela_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si185_dataprestacontasparcela_dia"])) {
         $sql  .= $virgula." si185_dataprestacontasparcela = null ";
         $virgula = ",";
         if (trim($this->si185_dataprestacontasparcela) == null ) {
           $this->erro_sql = " Campo Data da efetiva prestação de contas não informado.";
           $this->erro_campo = "si185_dataprestacontasparcela_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si185_prestacaocontas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_prestacaocontas"])) {
       $sql  .= $virgula." si185_prestacaocontas = $this->si185_prestacaocontas ";
       $virgula = ",";
       if (trim($this->si185_prestacaocontas) == null ) {
         $this->erro_sql = " Campo Resultado da análise da prestação de con não informado.";
         $this->erro_campo = "si185_prestacaocontas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_datacienfatos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_datacienfatos_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si185_datacienfatos_dia"] !="") ) {
       $sql  .= $virgula." si185_datacienfatos = '$this->si185_datacienfatos' ";
       $virgula = ",";
       if (trim($this->si185_datacienfatos) == null ) {
         $this->erro_sql = " Campo Data da ciência dos fatos não informado.";
         $this->erro_campo = "si185_datacienfatos_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si185_datacienfatos_dia"])) {
         $sql  .= $virgula." si185_datacienfatos = null ";
         $virgula = ",";
         if (trim($this->si185_datacienfatos) == null ) {
           $this->erro_sql = " Campo Data da ciência dos fatos não informado.";
           $this->erro_campo = "si185_datacienfatos_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si185_prorrogprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_prorrogprazo"])) {
       $sql  .= $virgula." si185_prorrogprazo = $this->si185_prorrogprazo ";
       $virgula = ",";
       if (trim($this->si185_prorrogprazo) == null ) {
         $this->erro_sql = " Campo Informar se houve prorrogação de prazo não informado.";
         $this->erro_campo = "si185_prorrogprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_dataprorrogprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_dataprorrogprazo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si185_dataprorrogprazo_dia"] !="") ) {
       $sql  .= $virgula." si185_dataprorrogprazo = '$this->si185_dataprorrogprazo' ";
       $virgula = ",";
       if (trim($this->si185_dataprorrogprazo) == null ) {
         $this->erro_sql = " Campo Nova data final para prestação de contas não informado.";
         $this->erro_campo = "si185_dataprorrogprazo_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si185_dataprorrogprazo_dia"])) {
         $sql  .= $virgula." si185_dataprorrogprazo = null ";
         $virgula = ",";
         if (trim($this->si185_dataprorrogprazo) == null ) {
           $this->erro_sql = " Campo Nova data final para prestação de contas não informado.";
           $this->erro_campo = "si185_dataprorrogprazo_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si185_nrocpfrespprestconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_nrocpfrespprestconge"])) {
       $sql  .= $virgula." si185_nrocpfrespprestconge = '$this->si185_nrocpfrespprestconge' ";
       $virgula = ",";
       if (trim($this->si185_nrocpfrespprestconge) == null ) {
         $this->erro_sql = " Campo Número do CPF do responsável pela aprova não informado.";
         $this->erro_campo = "si185_nrocpfrespprestconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_dsccargorespprestconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_dsccargorespprestconge"])) {
       $sql  .= $virgula." si185_dsccargorespprestconge = '$this->si185_dsccargorespprestconge' ";
       $virgula = ",";
       if (trim($this->si185_dsccargorespprestconge) == null ) {
         $this->erro_sql = " Campo Cargo do responsável pela aprovação não informado.";
         $this->erro_campo = "si185_dsccargorespprestconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_mes"])) {
       $sql  .= $virgula." si185_mes = $this->si185_mes ";
       $virgula = ",";
       if (trim($this->si185_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si185_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si185_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_instit"])) {
       $sql  .= $virgula." si185_instit = $this->si185_instit ";
       $virgula = ",";
       if (trim($this->si185_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si185_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si185_sequencial!=null) {
       $sql .= " si185_sequencial = $this->si185_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si185_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011945,'$this->si185_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_sequencial"]) || $this->si185_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011945,'".AddSlashes(pg_result($resaco,$conresaco,'si185_sequencial'))."','$this->si185_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"]) || $this->si185_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011944,'".AddSlashes(pg_result($resaco,$conresaco,'si185_tiporegistro'))."','$this->si185_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_codorgao"]) || $this->si185_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011948,'".AddSlashes(pg_result($resaco,$conresaco,'si185_codorgao'))."','$this->si185_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_codunidadesub"]) || $this->si185_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011949,'".AddSlashes(pg_result($resaco,$conresaco,'si185_codunidadesub'))."','$this->si185_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_nroconvenioconge"]) || $this->si185_nroconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011950,'".AddSlashes(pg_result($resaco,$conresaco,'si185_nroconvenioconge'))."','$this->si185_nroconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_dataassinaturaconvoriginalconge"]) || $this->si185_dataassinaturaconvoriginalconge != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011951,'".AddSlashes(pg_result($resaco,$conresaco,'si185_dataassinaturaconvoriginalconge'))."','$this->si185_dataassinaturaconvoriginalconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_numeroparcela"]) || $this->si185_numeroparcela != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011952,'".AddSlashes(pg_result($resaco,$conresaco,'si185_numeroparcela'))."','$this->si185_numeroparcela',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_datarepasseconge"]) || $this->si185_datarepasseconge != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011953,'".AddSlashes(pg_result($resaco,$conresaco,'si185_datarepasseconge'))."','$this->si185_datarepasseconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_prestacaocontasparcela"]) || $this->si185_prestacaocontasparcela != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011954,'".AddSlashes(pg_result($resaco,$conresaco,'si185_prestacaocontasparcela'))."','$this->si185_prestacaocontasparcela',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_dataprestacontasparcela"]) || $this->si185_dataprestacontasparcela != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011955,'".AddSlashes(pg_result($resaco,$conresaco,'si185_dataprestacontasparcela'))."','$this->si185_dataprestacontasparcela',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_prestacaocontas"]) || $this->si185_prestacaocontas != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011956,'".AddSlashes(pg_result($resaco,$conresaco,'si185_prestacaocontas'))."','$this->si185_prestacaocontas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_datacienfatos"]) || $this->si185_datacienfatos != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011957,'".AddSlashes(pg_result($resaco,$conresaco,'si185_datacienfatos'))."','$this->si185_datacienfatos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_prorrogprazo"]) || $this->si185_prorrogprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011958,'".AddSlashes(pg_result($resaco,$conresaco,'si185_prorrogprazo'))."','$this->si185_prorrogprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_dataprorrogprazo"]) || $this->si185_dataprorrogprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011959,'".AddSlashes(pg_result($resaco,$conresaco,'si185_dataprorrogprazo'))."','$this->si185_dataprorrogprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_nrocpfrespprestconge"]) || $this->si185_nrocpfrespprestconge != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011960,'".AddSlashes(pg_result($resaco,$conresaco,'si185_nrocpfrespprestconge'))."','$this->si185_nrocpfrespprestconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_dsccargorespprestconge"]) || $this->si185_dsccargorespprestconge != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011961,'".AddSlashes(pg_result($resaco,$conresaco,'si185_dsccargorespprestconge'))."','$this->si185_dsccargorespprestconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_mes"]) || $this->si185_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011946,'".AddSlashes(pg_result($resaco,$conresaco,'si185_mes'))."','$this->si185_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si185_instit"]) || $this->si185_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010198,2011947,'".AddSlashes(pg_result($resaco,$conresaco,'si185_instit'))."','$this->si185_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento da Prestação de Contas  nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento da Prestação de Contas  nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si185_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si185_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011945,'$si185_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011945,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011944,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011948,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011949,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011950,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011951,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011952,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_numeroparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011953,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_datarepasseconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011954,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_prestacaocontasparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011955,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_dataprestacontasparcela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011956,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_prestacaocontas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011957,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_datacienfatos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011958,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_prorrogprazo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011959,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_dataprorrogprazo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011960,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_nrocpfrespprestconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011961,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_dsccargorespprestconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011946,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010198,2011947,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from conge402021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si185_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si185_sequencial = $si185_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento da Prestação de Contas  nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si185_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento da Prestação de Contas  nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si185_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si185_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:conge402021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si185_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge402021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si185_sequencial!=null ) {
         $sql2 .= " where conge402021.si185_sequencial = $si185_sequencial ";
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
  function sql_query_file ( $si185_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge402021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si185_sequencial!=null ) {
         $sql2 .= " where conge402021.si185_sequencial = $si185_sequencial ";
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
