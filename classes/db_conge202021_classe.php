<?php
//MODULO: sicom
//CLASSE DA ENTIDADE conge202021
class cl_conge202021 {
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
  public $si183_sequencial = 0;
  public $si183_tiporegistro = 0;
  public $si183_codorgao = null;
  public $si183_codunidadesub = null;
  public $si183_nroconvenioconge = null;
  public $si183_dataassinaturaconvoriginalconge_dia = null;
  public $si183_dataassinaturaconvoriginalconge_mes = null;
  public $si183_dataassinaturaconvoriginalconge_ano = null;
  public $si183_dataassinaturaconvoriginalconge = null;
  public $si183_nroseqtermoaditivoconge = 0;
  public $si183_dscalteracaoconge = null;
  public $si183_dataassinaturatermoaditivoconge_dia = null;
  public $si183_dataassinaturatermoaditivoconge_mes = null;
  public $si183_dataassinaturatermoaditivoconge_ano = null;
  public $si183_dataassinaturatermoaditivoconge = null;
  public $si183_datafinalvigenciaconge_dia = null;
  public $si183_datafinalvigenciaconge_mes = null;
  public $si183_datafinalvigenciaconge_ano = null;
  public $si183_datafinalvigenciaconge = null;
  public $si183_valoratualizadoconvenioconge = 0;
  public $si183_valoratualizadocontrapartidaconge = 0;
  public $si183_mes = 0;
  public $si183_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si183_sequencial = int8 = Sequencial
                 si183_tiporegistro = int8 = Tipo do Registro
                 si183_codorgao = varchar(2) = Código do órgão
                 si183_codunidadesub = varchar(8) = Código da unidade ou subunidade orçam
                 si183_nroconvenioconge = varchar(30) = Número do convênio original ou instr
                 si183_dataassinaturaconvoriginalconge = date = Data da assinatura do convênio original
                 si183_nroseqtermoaditivoconge = int8 = Número sequencial do Termo Aditivo
                 si183_dscalteracaoconge = varchar(500) = Descrição da alteração do convênio
                 si183_dataassinaturatermoaditivoconge = date = Data da assinatura do Termo Aditivo
                 si183_datafinalvigenciaconge = date = Data final da vigência do convênio
                 si183_valoratualizadoconvenioconge = float8 = Valor atualizado do convênio ou  instrum
                 si183_valoratualizadocontrapartidaconge = float8 = Valor atualizado da Contrapartida
                 si183_mes = int8 = Mês
                 si183_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conge202021");
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
       $this->si183_sequencial = ($this->si183_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_sequencial"]:$this->si183_sequencial);
       $this->si183_tiporegistro = ($this->si183_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_tiporegistro"]:$this->si183_tiporegistro);
       $this->si183_codorgao = ($this->si183_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_codorgao"]:$this->si183_codorgao);
       $this->si183_codunidadesub = ($this->si183_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_codunidadesub"]:$this->si183_codunidadesub);
       $this->si183_nroconvenioconge = ($this->si183_nroconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_nroconvenioconge"]:$this->si183_nroconvenioconge);
       if ($this->si183_dataassinaturaconvoriginalconge == "") {
         $this->si183_dataassinaturaconvoriginalconge_dia = ($this->si183_dataassinaturaconvoriginalconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturaconvoriginalconge_dia"]:$this->si183_dataassinaturaconvoriginalconge_dia);
         $this->si183_dataassinaturaconvoriginalconge_mes = ($this->si183_dataassinaturaconvoriginalconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturaconvoriginalconge_mes"]:$this->si183_dataassinaturaconvoriginalconge_mes);
         $this->si183_dataassinaturaconvoriginalconge_ano = ($this->si183_dataassinaturaconvoriginalconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturaconvoriginalconge_ano"]:$this->si183_dataassinaturaconvoriginalconge_ano);
         if ($this->si183_dataassinaturaconvoriginalconge_dia != "") {
            $this->si183_dataassinaturaconvoriginalconge = $this->si183_dataassinaturaconvoriginalconge_ano."-".$this->si183_dataassinaturaconvoriginalconge_mes."-".$this->si183_dataassinaturaconvoriginalconge_dia;
         }
       }
       $this->si183_nroseqtermoaditivoconge = ($this->si183_nroseqtermoaditivoconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_nroseqtermoaditivoconge"]:$this->si183_nroseqtermoaditivoconge);
       $this->si183_dscalteracaoconge = ($this->si183_dscalteracaoconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_dscalteracaoconge"]:$this->si183_dscalteracaoconge);
       if ($this->si183_dataassinaturatermoaditivoconge == "") {
         $this->si183_dataassinaturatermoaditivoconge_dia = ($this->si183_dataassinaturatermoaditivoconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturatermoaditivoconge_dia"]:$this->si183_dataassinaturatermoaditivoconge_dia);
         $this->si183_dataassinaturatermoaditivoconge_mes = ($this->si183_dataassinaturatermoaditivoconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturatermoaditivoconge_mes"]:$this->si183_dataassinaturatermoaditivoconge_mes);
         $this->si183_dataassinaturatermoaditivoconge_ano = ($this->si183_dataassinaturatermoaditivoconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturatermoaditivoconge_ano"]:$this->si183_dataassinaturatermoaditivoconge_ano);
         if ($this->si183_dataassinaturatermoaditivoconge_dia != "") {
            $this->si183_dataassinaturatermoaditivoconge = $this->si183_dataassinaturatermoaditivoconge_ano."-".$this->si183_dataassinaturatermoaditivoconge_mes."-".$this->si183_dataassinaturatermoaditivoconge_dia;
         }
       }
       if ($this->si183_datafinalvigenciaconge == "") {
         $this->si183_datafinalvigenciaconge_dia = ($this->si183_datafinalvigenciaconge_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_datafinalvigenciaconge_dia"]:$this->si183_datafinalvigenciaconge_dia);
         $this->si183_datafinalvigenciaconge_mes = ($this->si183_datafinalvigenciaconge_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_datafinalvigenciaconge_mes"]:$this->si183_datafinalvigenciaconge_mes);
         $this->si183_datafinalvigenciaconge_ano = ($this->si183_datafinalvigenciaconge_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_datafinalvigenciaconge_ano"]:$this->si183_datafinalvigenciaconge_ano);
         if ($this->si183_datafinalvigenciaconge_dia != "") {
            $this->si183_datafinalvigenciaconge = $this->si183_datafinalvigenciaconge_ano."-".$this->si183_datafinalvigenciaconge_mes."-".$this->si183_datafinalvigenciaconge_dia;
         }
       }
       $this->si183_valoratualizadoconvenioconge = ($this->si183_valoratualizadoconvenioconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_valoratualizadoconvenioconge"]:$this->si183_valoratualizadoconvenioconge);
       $this->si183_valoratualizadocontrapartidaconge = ($this->si183_valoratualizadocontrapartidaconge == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_valoratualizadocontrapartidaconge"]:$this->si183_valoratualizadocontrapartidaconge);
       $this->si183_mes = ($this->si183_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_mes"]:$this->si183_mes);
       $this->si183_instit = ($this->si183_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_instit"]:$this->si183_instit);
     } else {
       $this->si183_sequencial = ($this->si183_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si183_sequencial"]:$this->si183_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si183_sequencial) {
      $this->atualizacampos();
     if ($this->si183_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si183_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si183_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si183_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_nroconvenioconge == null ) {
       $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
       $this->erro_campo = "si183_nroconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_dataassinaturaconvoriginalconge == null ) {
       $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
       $this->erro_campo = "si183_dataassinaturaconvoriginalconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_nroseqtermoaditivoconge == null ) {
       $this->erro_sql = " Campo Número sequencial do Termo Aditivo não informado.";
       $this->erro_campo = "si183_nroseqtermoaditivoconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_dscalteracaoconge == null ) {
       $this->erro_sql = " Campo Descrição da alteração do convênio não informado.";
       $this->erro_campo = "si183_dscalteracaoconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_dataassinaturatermoaditivoconge == null ) {
       $this->erro_sql = " Campo Data da assinatura do Termo Aditivo não informado.";
       $this->erro_campo = "si183_dataassinaturatermoaditivoconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_datafinalvigenciaconge == null ) {
       $this->erro_sql = " Campo Data final da vigência do convênio não informado.";
       $this->erro_campo = "si183_datafinalvigenciaconge_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_valoratualizadoconvenioconge == null ) {
       $this->erro_sql = " Campo Valor atualizado do convênio ou  instrum não informado.";
       $this->erro_campo = "si183_valoratualizadoconvenioconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_valoratualizadocontrapartidaconge == null ) {
       $this->erro_sql = " Campo Valor atualizado da Contrapartida não informado.";
       $this->erro_campo = "si183_valoratualizadocontrapartidaconge";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si183_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si183_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si183_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si183_sequencial = $si183_sequencial;
     if (($this->si183_sequencial == null) || ($this->si183_sequencial == "") ) {
       $this->erro_sql = " Campo si183_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conge202021(
                                       si183_sequencial
                                      ,si183_tiporegistro
                                      ,si183_codorgao
                                      ,si183_codunidadesub
                                      ,si183_nroconvenioconge
                                      ,si183_dataassinaturaconvoriginalconge
                                      ,si183_nroseqtermoaditivoconge
                                      ,si183_dscalteracaoconge
                                      ,si183_dataassinaturatermoaditivoconge
                                      ,si183_datafinalvigenciaconge
                                      ,si183_valoratualizadoconvenioconge
                                      ,si183_valoratualizadocontrapartidaconge
                                      ,si183_mes
                                      ,si183_instit
                       )
                values (
                                $this->si183_sequencial
                               ,$this->si183_tiporegistro
                               ,'$this->si183_codorgao'
                               ,'$this->si183_codunidadesub'
                               ,'$this->si183_nroconvenioconge'
                               ,".($this->si183_dataassinaturaconvoriginalconge == "null" || $this->si183_dataassinaturaconvoriginalconge == ""?"null":"'".$this->si183_dataassinaturaconvoriginalconge."'")."
                               ,$this->si183_nroseqtermoaditivoconge
                               ,'$this->si183_dscalteracaoconge'
                               ,".($this->si183_dataassinaturatermoaditivoconge == "null" || $this->si183_dataassinaturatermoaditivoconge == ""?"null":"'".$this->si183_dataassinaturatermoaditivoconge."'")."
                               ,".($this->si183_datafinalvigenciaconge == "null" || $this->si183_datafinalvigenciaconge == ""?"null":"'".$this->si183_datafinalvigenciaconge."'")."
                               ,$this->si183_valoratualizadoconvenioconge
                               ,$this->si183_valoratualizadocontrapartidaconge
                               ,$this->si183_mes
                               ,$this->si183_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Detalhamento dos Termos ($this->si183_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Detalhamento dos Termos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Detalhamento dos Termos ($this->si183_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si183_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
   /*  if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si183_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011922,'$this->si183_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010196,2011922,'','".AddSlashes(pg_result($resaco,0,'si183_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011911,'','".AddSlashes(pg_result($resaco,0,'si183_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011912,'','".AddSlashes(pg_result($resaco,0,'si183_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011913,'','".AddSlashes(pg_result($resaco,0,'si183_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011914,'','".AddSlashes(pg_result($resaco,0,'si183_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011915,'','".AddSlashes(pg_result($resaco,0,'si183_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011916,'','".AddSlashes(pg_result($resaco,0,'si183_nroseqtermoaditivoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011917,'','".AddSlashes(pg_result($resaco,0,'si183_dscalteracaoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011918,'','".AddSlashes(pg_result($resaco,0,'si183_dataassinaturatermoaditivoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011919,'','".AddSlashes(pg_result($resaco,0,'si183_datafinalvigenciaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011920,'','".AddSlashes(pg_result($resaco,0,'si183_valoratualizadoconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011921,'','".AddSlashes(pg_result($resaco,0,'si183_valoratualizadocontrapartidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011923,'','".AddSlashes(pg_result($resaco,0,'si183_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010196,2011924,'','".AddSlashes(pg_result($resaco,0,'si183_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si183_sequencial=null) {
      $this->atualizacampos();
     $sql = " update conge202021 set ";
     $virgula = "";
     if (trim($this->si183_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_sequencial"])) {
       $sql  .= $virgula." si183_sequencial = $this->si183_sequencial ";
       $virgula = ",";
       if (trim($this->si183_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si183_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_tiporegistro"])) {
       $sql  .= $virgula." si183_tiporegistro = $this->si183_tiporegistro ";
       $virgula = ",";
       if (trim($this->si183_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si183_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_codorgao"])) {
       $sql  .= $virgula." si183_codorgao = '$this->si183_codorgao' ";
       $virgula = ",";
       if (trim($this->si183_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si183_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_codunidadesub"])) {
       $sql  .= $virgula." si183_codunidadesub = '$this->si183_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si183_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si183_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_nroconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_nroconvenioconge"])) {
       $sql  .= $virgula." si183_nroconvenioconge = '$this->si183_nroconvenioconge' ";
       $virgula = ",";
       if (trim($this->si183_nroconvenioconge) == null ) {
         $this->erro_sql = " Campo Número do convênio original ou instr não informado.";
         $this->erro_campo = "si183_nroconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_dataassinaturaconvoriginalconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturaconvoriginalconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturaconvoriginalconge_dia"] !="") ) {
       $sql  .= $virgula." si183_dataassinaturaconvoriginalconge = '$this->si183_dataassinaturaconvoriginalconge' ";
       $virgula = ",";
       if (trim($this->si183_dataassinaturaconvoriginalconge) == null ) {
         $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
         $this->erro_campo = "si183_dataassinaturaconvoriginalconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturaconvoriginalconge_dia"])) {
         $sql  .= $virgula." si183_dataassinaturaconvoriginalconge = null ";
         $virgula = ",";
         if (trim($this->si183_dataassinaturaconvoriginalconge) == null ) {
           $this->erro_sql = " Campo Data da assinatura do convênio original não informado.";
           $this->erro_campo = "si183_dataassinaturaconvoriginalconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si183_nroseqtermoaditivoconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_nroseqtermoaditivoconge"])) {
       $sql  .= $virgula." si183_nroseqtermoaditivoconge = $this->si183_nroseqtermoaditivoconge ";
       $virgula = ",";
       if (trim($this->si183_nroseqtermoaditivoconge) == null ) {
         $this->erro_sql = " Campo Número sequencial do Termo Aditivo não informado.";
         $this->erro_campo = "si183_nroseqtermoaditivoconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_dscalteracaoconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_dscalteracaoconge"])) {
       $sql  .= $virgula." si183_dscalteracaoconge = '$this->si183_dscalteracaoconge' ";
       $virgula = ",";
       if (trim($this->si183_dscalteracaoconge) == null ) {
         $this->erro_sql = " Campo Descrição da alteração do convênio não informado.";
         $this->erro_campo = "si183_dscalteracaoconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_dataassinaturatermoaditivoconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturatermoaditivoconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturatermoaditivoconge_dia"] !="") ) {
       $sql  .= $virgula." si183_dataassinaturatermoaditivoconge = '$this->si183_dataassinaturatermoaditivoconge' ";
       $virgula = ",";
       if (trim($this->si183_dataassinaturatermoaditivoconge) == null ) {
         $this->erro_sql = " Campo Data da assinatura do Termo Aditivo não informado.";
         $this->erro_campo = "si183_dataassinaturatermoaditivoconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturatermoaditivoconge_dia"])) {
         $sql  .= $virgula." si183_dataassinaturatermoaditivoconge = null ";
         $virgula = ",";
         if (trim($this->si183_dataassinaturatermoaditivoconge) == null ) {
           $this->erro_sql = " Campo Data da assinatura do Termo Aditivo não informado.";
           $this->erro_campo = "si183_dataassinaturatermoaditivoconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si183_datafinalvigenciaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_datafinalvigenciaconge_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si183_datafinalvigenciaconge_dia"] !="") ) {
       $sql  .= $virgula." si183_datafinalvigenciaconge = '$this->si183_datafinalvigenciaconge' ";
       $virgula = ",";
       if (trim($this->si183_datafinalvigenciaconge) == null ) {
         $this->erro_sql = " Campo Data final da vigência do convênio não informado.";
         $this->erro_campo = "si183_datafinalvigenciaconge_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si183_datafinalvigenciaconge_dia"])) {
         $sql  .= $virgula." si183_datafinalvigenciaconge = null ";
         $virgula = ",";
         if (trim($this->si183_datafinalvigenciaconge) == null ) {
           $this->erro_sql = " Campo Data final da vigência do convênio não informado.";
           $this->erro_campo = "si183_datafinalvigenciaconge_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si183_valoratualizadoconvenioconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_valoratualizadoconvenioconge"])) {
       $sql  .= $virgula." si183_valoratualizadoconvenioconge = $this->si183_valoratualizadoconvenioconge ";
       $virgula = ",";
       if (trim($this->si183_valoratualizadoconvenioconge) == null ) {
         $this->erro_sql = " Campo Valor atualizado do convênio ou  instrum não informado.";
         $this->erro_campo = "si183_valoratualizadoconvenioconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_valoratualizadocontrapartidaconge)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_valoratualizadocontrapartidaconge"])) {
       $sql  .= $virgula." si183_valoratualizadocontrapartidaconge = $this->si183_valoratualizadocontrapartidaconge ";
       $virgula = ",";
       if (trim($this->si183_valoratualizadocontrapartidaconge) == null ) {
         $this->erro_sql = " Campo Valor atualizado da Contrapartida não informado.";
         $this->erro_campo = "si183_valoratualizadocontrapartidaconge";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_mes"])) {
       $sql  .= $virgula." si183_mes = $this->si183_mes ";
       $virgula = ",";
       if (trim($this->si183_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si183_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si183_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si183_instit"])) {
       $sql  .= $virgula." si183_instit = $this->si183_instit ";
       $virgula = ",";
       if (trim($this->si183_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si183_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si183_sequencial!=null) {
       $sql .= " si183_sequencial = $this->si183_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si183_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011922,'$this->si183_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_sequencial"]) || $this->si183_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011922,'".AddSlashes(pg_result($resaco,$conresaco,'si183_sequencial'))."','$this->si183_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_tiporegistro"]) || $this->si183_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011911,'".AddSlashes(pg_result($resaco,$conresaco,'si183_tiporegistro'))."','$this->si183_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_codorgao"]) || $this->si183_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011912,'".AddSlashes(pg_result($resaco,$conresaco,'si183_codorgao'))."','$this->si183_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_codunidadesub"]) || $this->si183_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011913,'".AddSlashes(pg_result($resaco,$conresaco,'si183_codunidadesub'))."','$this->si183_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_nroconvenioconge"]) || $this->si183_nroconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011914,'".AddSlashes(pg_result($resaco,$conresaco,'si183_nroconvenioconge'))."','$this->si183_nroconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturaconvoriginalconge"]) || $this->si183_dataassinaturaconvoriginalconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011915,'".AddSlashes(pg_result($resaco,$conresaco,'si183_dataassinaturaconvoriginalconge'))."','$this->si183_dataassinaturaconvoriginalconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_nroseqtermoaditivoconge"]) || $this->si183_nroseqtermoaditivoconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011916,'".AddSlashes(pg_result($resaco,$conresaco,'si183_nroseqtermoaditivoconge'))."','$this->si183_nroseqtermoaditivoconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_dscalteracaoconge"]) || $this->si183_dscalteracaoconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011917,'".AddSlashes(pg_result($resaco,$conresaco,'si183_dscalteracaoconge'))."','$this->si183_dscalteracaoconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_dataassinaturatermoaditivoconge"]) || $this->si183_dataassinaturatermoaditivoconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011918,'".AddSlashes(pg_result($resaco,$conresaco,'si183_dataassinaturatermoaditivoconge'))."','$this->si183_dataassinaturatermoaditivoconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_datafinalvigenciaconge"]) || $this->si183_datafinalvigenciaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011919,'".AddSlashes(pg_result($resaco,$conresaco,'si183_datafinalvigenciaconge'))."','$this->si183_datafinalvigenciaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_valoratualizadoconvenioconge"]) || $this->si183_valoratualizadoconvenioconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011920,'".AddSlashes(pg_result($resaco,$conresaco,'si183_valoratualizadoconvenioconge'))."','$this->si183_valoratualizadoconvenioconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_valoratualizadocontrapartidaconge"]) || $this->si183_valoratualizadocontrapartidaconge != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011921,'".AddSlashes(pg_result($resaco,$conresaco,'si183_valoratualizadocontrapartidaconge'))."','$this->si183_valoratualizadocontrapartidaconge',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_mes"]) || $this->si183_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011923,'".AddSlashes(pg_result($resaco,$conresaco,'si183_mes'))."','$this->si183_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si183_instit"]) || $this->si183_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010196,2011924,'".AddSlashes(pg_result($resaco,$conresaco,'si183_instit'))."','$this->si183_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento dos Termos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si183_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento dos Termos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si183_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si183_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si183_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    /* if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si183_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011922,'$si183_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011922,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011911,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011912,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011913,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011914,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_nroconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011915,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_dataassinaturaconvoriginalconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011916,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_nroseqtermoaditivoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011917,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_dscalteracaoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011918,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_dataassinaturatermoaditivoconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011919,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_datafinalvigenciaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011920,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_valoratualizadoconvenioconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011921,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_valoratualizadocontrapartidaconge'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011923,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010196,2011924,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from conge202021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si183_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si183_sequencial = $si183_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento dos Termos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si183_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento dos Termos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si183_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si183_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:conge202021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si183_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge202021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si183_sequencial!=null ) {
         $sql2 .= " where conge202021.si183_sequencial = $si183_sequencial ";
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
  function sql_query_file ( $si183_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from conge202021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si183_sequencial!=null ) {
         $sql2 .= " where conge202021.si183_sequencial = $si183_sequencial ";
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
