<?php
//MODULO: sicom
//CLASSE DA ENTIDADE conge502021
class cl_conge502021 {
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
  public $si186_sequencial = 0;
  public $si186_tiporegistro = 0;
  public $si186_codorgao = null;
  public $si186_codunidadesub = null;
  public $si186_nroconvenioconge = null;
  public $si186_dataassinaturaconvoriginalconge_dia = null;
  public $si186_dataassinaturaconvoriginalconge_mes = null;
  public $si186_dataassinaturaconvoriginalconge_ano = null;
  public $si186_dataassinaturaconvoriginalconge = null;
  public $si186_dscmedidaadministrativa = null;
  public $si186_datainiciomedida_dia = null;
  public $si186_datainiciomedida_mes = null;
  public $si186_datainiciomedida_ano = null;
  public $si186_datainiciomedida = null;
  public $si186_datafinalmedida_dia = null;
  public $si186_datafinalmedida_mes = null;
  public $si186_datafinalmedida_ano = null;
  public $si186_datafinalmedida = null;
  public $si186_adocaomedidasadmin = 0;
  public $si186_nrocpfrespmedidaconge = null;
  public $si186_dsccargorespmedidaconge = null;
  public $si186_mes = 0;
  public $si186_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si186_sequencial = int8 = Sequencial
                 si186_tiporegistro = int8 = Tipo do Registro
                 si186_codorgao = varchar(2) = Código do órgão
                 si186_codunidadesub = varchar(8) = Código da unidade ou subunidade orçam
                 si186_nroconvenioconge = varchar(30) = Número do convênio original ou instr
                 si186_dataassinaturaconvoriginalconge = date = Data da assinatura do convênio original
                 si186_dscmedidaadministrativa = varchar(500) = Descrição das medidas administrativas
                 si186_datainiciomedida = date = Data inicial das medidas administrativas
                 si186_datafinalmedida = date = Data final das medidas administrativas
                 si186_adocaomedidasadmin = int8 = Adoção das medidas administrativas
                 si186_nrocpfrespmedidaconge = varchar(11) = Número do CPF do responsável pelas medid
                 si186_dsccargorespmedidaconge = varchar(50) = Cargo do responsável pelas medidas adm
                 si186_mes = int8 = Mês
                 si186_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conge502021");
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
       $this->si186_sequencial = ($this->si186_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_sequencial"]:$this->si186_sequencial);
       $this->si186_tiporegistro = ($this->si186_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_tiporegistro"]:$this->si186_tiporegistro);
       $this->si186_codorgao = ($this->si186_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_codorgao"]:$this->si186_codorgao);
       $this->si186_codunidadesub = ($this->si186_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_codunidadesub"]:$this->si186_codunidadesub);
       $this->si186_nroconvenioconge = ($this->si186_nroconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_nroconvenioconge"]:$this->si186_nroconvenioconge);
       if ($this->si186_dataassinaturaconvoriginalconge == "") {
         $this->si186_dataassinaturaconvoriginalconge_dia = ($this->si186_dataassinaturaconvoriginalconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_dataassinaturaconvoriginalconge_dia"]:$this->si186_dataassinaturaconvoriginalconge_dia);
         $this->si186_dataassinaturaconvoriginalconge_mes = ($this->si186_dataassinaturaconvoriginalconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_dataassinaturaconvoriginalconge_mes"]:$this->si186_dataassinaturaconvoriginalconge_mes);
         $this->si186_dataassinaturaconvoriginalconge_ano = ($this->si186_dataassinaturaconvoriginalconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_dataassinaturaconvoriginalconge_ano"]:$this->si186_dataassinaturaconvoriginalconge_ano);
         if ($this->si186_dataassinaturaconvoriginalconge_dia != "") {
            $this->si186_dataassinaturaconvoriginalconge = $this->si186_dataassinaturaconvoriginalconge_ano."-".$this->si186_dataassinaturaconvoriginalconge_mes."-".$this->si186_dataassinaturaconvoriginalconge_dia;
         }
       }
       $this->si186_dscmedidaadministrativa = ($this->si186_dscmedidaadministrativa == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_dscmedidaadministrativa"]:$this->si186_dscmedidaadministrativa);
       if ($this->si186_datainiciomedida == "") {
         $this->si186_datainiciomedida_dia = ($this->si186_datainiciomedida_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_datainiciomedida_dia"]:$this->si186_datainiciomedida_dia);
         $this->si186_datainiciomedida_mes = ($this->si186_datainiciomedida_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_datainiciomedida_mes"]:$this->si186_datainiciomedida_mes);
         $this->si186_datainiciomedida_ano = ($this->si186_datainiciomedida_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_datainiciomedida_ano"]:$this->si186_datainiciomedida_ano);
         if ($this->si186_datainiciomedida_dia != "") {
            $this->si186_datainiciomedida = $this->si186_datainiciomedida_ano."-".$this->si186_datainiciomedida_mes."-".$this->si186_datainiciomedida_dia;
         }
       }
       if ($this->si186_datafinalmedida == "") {
         $this->si186_datafinalmedida_dia = ($this->si186_datafinalmedida_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_datafinalmedida_dia"]:$this->si186_datafinalmedida_dia);
         $this->si186_datafinalmedida_mes = ($this->si186_datafinalmedida_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_datafinalmedida_mes"]:$this->si186_datafinalmedida_mes);
         $this->si186_datafinalmedida_ano = ($this->si186_datafinalmedida_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_datafinalmedida_ano"]:$this->si186_datafinalmedida_ano);
         if ($this->si186_datafinalmedida_dia != "") {
            $this->si186_datafinalmedida = $this->si186_datafinalmedida_ano."-".$this->si186_datafinalmedida_mes."-".$this->si186_datafinalmedida_dia;
         }
       }
       $this->si186_adocaomedidasadmin = ($this->si186_adocaomedidasadmin == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_adocaomedidasadmin"]:$this->si186_adocaomedidasadmin);
       $this->si186_nrocpfrespmedidaconge = ($this->si186_nrocpfrespmedidaconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_nrocpfrespmedidaconge"]:$this->si186_nrocpfrespmedidaconge);
       $this->si186_dsccargorespmedidaconge = ($this->si186_dsccargorespmedidaconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_dsccargorespmedidaconge"]:$this->si186_dsccargorespmedidaconge);
       $this->si186_mes = ($this->si186_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_mes"]:$this->si186_mes);
       $this->si186_instit = ($this->si186_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_instit"]:$this->si186_instit);
     } else {
       $this->si186_sequencial = ($this->si186_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si186_sequencial"]:$this->si186_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si186_sequencial) {
      $this->atualizacampos();
     if ($this->si186_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si186_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si186_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si186_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_nroconvenioconge == null ) {
       $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
       $this->erro_campo = "si186_nroconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_dataassinaturaconvoriginalconge == null ) {
       $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
       $this->erro_campo = "si186_dataassinaturaconvoriginalconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_dscmedidaadministrativa == null ) {
       $this->erro_sql = " Campo Descrição das medidas administrativas não informado.";
       $this->erro_campo = "si186_dscmedidaadministrativa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_datainiciomedida == null ) {
       $this->erro_sql = " Campo Data inicial das medidas administrativas não informado.";
       $this->erro_campo = "si186_datainiciomedida_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_datafinalmedida == null ) {
       $this->erro_sql = " Campo Data final das medidas administrativas não informado.";
       $this->erro_campo = "si186_datafinalmedida_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_adocaomedidasadmin == null ) {
       $this->erro_sql = " Campo Adoção das medidas administrativas não informado.";
       $this->erro_campo = "si186_adocaomedidasadmin";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_nrocpfrespmedidaconge == null ) {
       $this->erro_sql = " Campo Número do CPF do responsável pelas medid não informado.";
       $this->erro_campo = "si186_nrocpfrespmedidaconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_dsccargorespmedidaconge == null ) {
       $this->erro_sql = " Campo Cargo do responsável pelas medidas adm não informado.";
       $this->erro_campo = "si186_dsccargorespmedidaconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si186_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si186_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si186_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si186_sequencial = $si186_sequencial;
     if (($this->si186_sequencial == null) || ($this->si186_sequencial == "") ) {
       $this->erro_sql = " Campo si186_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conge502021(
                                       si186_sequencial
                                      ,si186_tiporegistro
                                      ,si186_codorgao
                                      ,si186_codunidadesub
                                      ,si186_nroconvenioconge
                                      ,si186_dataassinaturaconvoriginalconge
                                      ,si186_dscmedidaadministrativa
                                      ,si186_datainiciomedida
                                      ,si186_datafinalmedida
                                      ,si186_adocaomedidasadmin
                                      ,si186_nrocpfrespmedidaconge
                                      ,si186_dsccargorespmedidaconge
                                      ,si186_mes
                                      ,si186_instit
                       )
                values (
                                $this->si186_sequencial
                               ,$this->si186_tiporegistro
                               ,'$this->si186_codorgao'
                               ,'$this->si186_codunidadesub'
                               ,'$this->si186_nroconvenioconge'
                               ,".($this->si186_dataassinaturaconvoriginalconge == "null" || $this->si186_dataassinaturaconvoriginalconge == ""?"null":"'".$this->si186_dataassinaturaconvoriginalconge."'")."
                               ,'$this->si186_dscmedidaadministrativa'
                               ,".($this->si186_datainiciomedida == "null" || $this->si186_datainiciomedida == ""?"null":"'".$this->si186_datainiciomedida."'")."
                               ,".($this->si186_datafinalmedida == "null" || $this->si186_datafinalmedida == ""?"null":"'".$this->si186_datafinalmedida."'")."
                               ,$this->si186_adocaomedidasadmin
                               ,'$this->si186_nrocpfrespmedidaconge'
                               ,'$this->si186_dsccargorespmedidaconge'
                               ,$this->si186_mes
                               ,$this->si186_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Detalhamento das Medidas Administrativas ($this->si186_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Detalhamento das Medidas Administrativas já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Detalhamento das Medidas Administrativas ($this->si186_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si186_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    /* if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si186_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011962,'$this->si186_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010199,2011962,'','".AddSlashes(pg_result($resaco,0,'si186_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011965,'','".AddSlashes(pg_result($resaco,0,'si186_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011966,'','".AddSlashes(pg_result($resaco,0,'si186_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011967,'','".AddSlashes(pg_result($resaco,0,'si186_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011968,'','".AddSlashes(pg_result($resaco,0,'si186_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011969,'','".AddSlashes(pg_result($resaco,0,'si186_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011970,'','".AddSlashes(pg_result($resaco,0,'si186_dscmedidaadministrativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011971,'','".AddSlashes(pg_result($resaco,0,'si186_datainiciomedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011972,'','".AddSlashes(pg_result($resaco,0,'si186_datafinalmedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011973,'','".AddSlashes(pg_result($resaco,0,'si186_adocaomedidasadmin'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011974,'','".AddSlashes(pg_result($resaco,0,'si186_nrocpfrespmedidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011975,'','".AddSlashes(pg_result($resaco,0,'si186_dsccargorespmedidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011963,'','".AddSlashes(pg_result($resaco,0,'si186_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010199,2011964,'','".AddSlashes(pg_result($resaco,0,'si186_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si186_sequencial=null) {
      $this->atualizacampos();
     $sql = " update conge502021 set ";
     $virgula = "";
     if (trim($this->si186_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_sequencial"])) {
       $sql  .= $virgula." si186_sequencial = $this->si186_sequencial ";
       $virgula = ",";
       if (trim($this->si186_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si186_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_tiporegistro"])) {
       $sql  .= $virgula." si186_tiporegistro = $this->si186_tiporegistro ";
       $virgula = ",";
       if (trim($this->si186_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si186_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_codorgao"])) {
       $sql  .= $virgula." si186_codorgao = '$this->si186_codorgao' ";
       $virgula = ",";
       if (trim($this->si186_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si186_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_codunidadesub"])) {
       $sql  .= $virgula." si186_codunidadesub = '$this->si186_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si186_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si186_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_nroconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_nroconvenioconge"])) {
       $sql  .= $virgula." si186_nroconvenioconge = '$this->si186_nroconvenioconge' ";
       $virgula = ",";
       if (trim($this->si186_nroconvenioconge) == null ) {
         $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
         $this->erro_campo = "si186_nroconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_dataassinaturaconvoriginalconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_dataassinaturaconvoriginalconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si186_dataassinaturaconvoriginalconge_dia"] !="") ) {
       $sql  .= $virgula." si186_dataassinaturaconvoriginalconge = '$this->si186_dataassinaturaconvoriginalconge' ";
       $virgula = ",";
       if (trim($this->si186_dataassinaturaconvoriginalconge) == null ) {
         $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
         $this->erro_campo = "si186_dataassinaturaconvoriginalconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si186_dataassinaturaconvoriginalconge_dia"])) {
         $sql  .= $virgula." si186_dataassinaturaconvoriginalconge = null ";
         $virgula = ",";
         if (trim($this->si186_dataassinaturaconvoriginalconge) == null ) {
           $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
           $this->erro_campo = "si186_dataassinaturaconvoriginalconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si186_dscmedidaadministrativa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_dscmedidaadministrativa"])) {
       $sql  .= $virgula." si186_dscmedidaadministrativa = '$this->si186_dscmedidaadministrativa' ";
       $virgula = ",";
       if (trim($this->si186_dscmedidaadministrativa) == null ) {
         $this->erro_sql = " Campo Descrição das medidas administrativas não informado.";
         $this->erro_campo = "si186_dscmedidaadministrativa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_datainiciomedida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_datainiciomedida_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si186_datainiciomedida_dia"] !="") ) {
       $sql  .= $virgula." si186_datainiciomedida = '$this->si186_datainiciomedida' ";
       $virgula = ",";
       if (trim($this->si186_datainiciomedida) == null ) {
         $this->erro_sql = " Campo Data inicial das medidas administrativas não informado.";
         $this->erro_campo = "si186_datainiciomedida_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si186_datainiciomedida_dia"])) {
         $sql  .= $virgula." si186_datainiciomedida = null ";
         $virgula = ",";
         if (trim($this->si186_datainiciomedida) == null ) {
           $this->erro_sql = " Campo Data inicial das medidas administrativas não informado.";
           $this->erro_campo = "si186_datainiciomedida_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si186_datafinalmedida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_datafinalmedida_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si186_datafinalmedida_dia"] !="") ) {
       $sql  .= $virgula." si186_datafinalmedida = '$this->si186_datafinalmedida' ";
       $virgula = ",";
       if (trim($this->si186_datafinalmedida) == null ) {
         $this->erro_sql = " Campo Data final das medidas administrativas não informado.";
         $this->erro_campo = "si186_datafinalmedida_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si186_datafinalmedida_dia"])) {
         $sql  .= $virgula." si186_datafinalmedida = null ";
         $virgula = ",";
         if (trim($this->si186_datafinalmedida) == null ) {
           $this->erro_sql = " Campo Data final das medidas administrativas não informado.";
           $this->erro_campo = "si186_datafinalmedida_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si186_adocaomedidasadmin)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_adocaomedidasadmin"])) {
       $sql  .= $virgula." si186_adocaomedidasadmin = $this->si186_adocaomedidasadmin ";
       $virgula = ",";
       if (trim($this->si186_adocaomedidasadmin) == null ) {
         $this->erro_sql = " Campo Adoção das medidas administrativas não informado.";
         $this->erro_campo = "si186_adocaomedidasadmin";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_nrocpfrespmedidaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_nrocpfrespmedidaconge"])) {
       $sql  .= $virgula." si186_nrocpfrespmedidaconge = '$this->si186_nrocpfrespmedidaconge' ";
       $virgula = ",";
       if (trim($this->si186_nrocpfrespmedidaconge) == null ) {
         $this->erro_sql = " Campo Número do CPF do responsável pelas medid não informado.";
         $this->erro_campo = "si186_nrocpfrespmedidaconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_dsccargorespmedidaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_dsccargorespmedidaconge"])) {
       $sql  .= $virgula." si186_dsccargorespmedidaconge = '$this->si186_dsccargorespmedidaconge' ";
       $virgula = ",";
       if (trim($this->si186_dsccargorespmedidaconge) == null ) {
         $this->erro_sql = " Campo Cargo do responsável pelas medidas adm não informado.";
         $this->erro_campo = "si186_dsccargorespmedidaconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_mes"])) {
       $sql  .= $virgula." si186_mes = $this->si186_mes ";
       $virgula = ",";
       if (trim($this->si186_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si186_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si186_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si186_instit"])) {
       $sql  .= $virgula." si186_instit = $this->si186_instit ";
       $virgula = ",";
       if (trim($this->si186_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si186_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si186_sequencial!=null) {
       $sql .= " si186_sequencial = $this->si186_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si186_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011962,'$this->si186_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_sequencial"]) || $this->si186_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011962,'".AddSlashes(pg_result($resaco,$conresaco,'si186_sequencial'))."','$this->si186_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_tiporegistro"]) || $this->si186_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011965,'".AddSlashes(pg_result($resaco,$conresaco,'si186_tiporegistro'))."','$this->si186_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_codorgao"]) || $this->si186_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011966,'".AddSlashes(pg_result($resaco,$conresaco,'si186_codorgao'))."','$this->si186_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_codunidadesub"]) || $this->si186_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011967,'".AddSlashes(pg_result($resaco,$conresaco,'si186_codunidadesub'))."','$this->si186_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_nroconvenioconge"]) || $this->si186_nroconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011968,'".AddSlashes(pg_result($resaco,$conresaco,'si186_nroconvenioconge'))."','$this->si186_nroconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_dataassinaturaconvoriginalconge"]) || $this->si186_dataassinaturaconvoriginalconge != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011969,'".AddSlashes(pg_result($resaco,$conresaco,'si186_dataassinaturaconvoriginalconge'))."','$this->si186_dataassinaturaconvoriginalconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_dscmedidaadministrativa"]) || $this->si186_dscmedidaadministrativa != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011970,'".AddSlashes(pg_result($resaco,$conresaco,'si186_dscmedidaadministrativa'))."','$this->si186_dscmedidaadministrativa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_datainiciomedida"]) || $this->si186_datainiciomedida != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011971,'".AddSlashes(pg_result($resaco,$conresaco,'si186_datainiciomedida'))."','$this->si186_datainiciomedida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_datafinalmedida"]) || $this->si186_datafinalmedida != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011972,'".AddSlashes(pg_result($resaco,$conresaco,'si186_datafinalmedida'))."','$this->si186_datafinalmedida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_adocaomedidasadmin"]) || $this->si186_adocaomedidasadmin != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011973,'".AddSlashes(pg_result($resaco,$conresaco,'si186_adocaomedidasadmin'))."','$this->si186_adocaomedidasadmin',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_nrocpfrespmedidaconge"]) || $this->si186_nrocpfrespmedidaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011974,'".AddSlashes(pg_result($resaco,$conresaco,'si186_nrocpfrespmedidaconge'))."','$this->si186_nrocpfrespmedidaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_dsccargorespmedidaconge"]) || $this->si186_dsccargorespmedidaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011975,'".AddSlashes(pg_result($resaco,$conresaco,'si186_dsccargorespmedidaconge'))."','$this->si186_dsccargorespmedidaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_mes"]) || $this->si186_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011963,'".AddSlashes(pg_result($resaco,$conresaco,'si186_mes'))."','$this->si186_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si186_instit"]) || $this->si186_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010199,2011964,'".AddSlashes(pg_result($resaco,$conresaco,'si186_instit'))."','$this->si186_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento das Medidas Administrativas nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si186_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento das Medidas Administrativas nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si186_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si186_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si186_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si186_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011962,'$si186_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011962,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011965,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011966,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011967,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011968,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011969,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011970,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_dscmedidaadministrativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011971,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_datainiciomedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011972,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_datafinalmedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011973,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_adocaomedidasadmin'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011974,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_nrocpfrespmedidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011975,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_dsccargorespmedidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011963,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010199,2011964,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from conge502021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si186_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si186_sequencial = $si186_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento das Medidas Administrativas nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si186_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento das Medidas Administrativas nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si186_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si186_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:conge502021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si186_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge502021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si186_sequencial!=null ) {
         $sql2 .= " where conge502021.si186_sequencial = $si186_sequencial ";
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
  function sql_query_file ( $si186_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge502021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si186_sequencial!=null ) {
         $sql2 .= " where conge502021.si186_sequencial = $si186_sequencial ";
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
