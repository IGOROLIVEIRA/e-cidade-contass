<?php
//MODULO: Obras
//CLASSE DA ENTIDADE licobrasmedicao
class cl_licobrasmedicao {
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
  public $obr03_sequencial = 0;
  public $obr03_seqobra = 0;
  public $obr03_dtlancamento_dia = null;
  public $obr03_dtlancamento_mes = null;
  public $obr03_dtlancamento_ano = null;
  public $obr03_dtlancamento = null;
  public $obr03_nummedicao = 0;
  public $obr03_tipomedicao = 0;
  public $obr03_dtiniciomedicao_dia = null;
  public $obr03_dtiniciomedicao_mes = null;
  public $obr03_dtiniciomedicao_ano = null;
  public $obr03_dtiniciomedicao = null;
  public $obr03_outrostiposmedicao = null;
  public $obr03_descmedicao = null;
  public $obr03_dtfimmedicao_dia = null;
  public $obr03_dtfimmedicao_mes = null;
  public $obr03_dtfimmedicao_ano = null;
  public $obr03_dtfimmedicao = null;
  public $obr03_dtentregamedicao_dia = null;
  public $obr03_dtentregamedicao_mes = null;
  public $obr03_dtentregamedicao_ano = null;
  public $obr03_dtentregamedicao = null;
  public $obr03_vlrmedicao = 0;
  public $obr03_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 obr03_sequencial = int8 = Cód. Sequencial
                 obr03_seqobra = int8 = Nº Obra
                 obr03_dtlancamento = date = Data Lançamento
                 obr03_nummedicao = int8 = Nº Medição
                 obr03_tipomedicao = int8 = Tipo de Medição
                 obr03_dtiniciomedicao = date = Início da Medição
                 obr03_outrostiposmedicao = text = Outros tipos de Medição
                 obr03_descmedicao = text = Desc. Medição
                 obr03_dtfimmedicao = date = Fim da Medição
                 obr03_dtentregamedicao = date = Entrega da Medição
                 obr03_vlrmedicao = float8 = Valor Medição
                 obr03_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licobrasmedicao");
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
       $this->obr03_sequencial = ($this->obr03_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_sequencial"]:$this->obr03_sequencial);
       $this->obr03_seqobra = ($this->obr03_seqobra == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_seqobra"]:$this->obr03_seqobra);
       if ($this->obr03_dtlancamento == "") {
         $this->obr03_dtlancamento_dia = ($this->obr03_dtlancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtlancamento_dia"]:$this->obr03_dtlancamento_dia);
         $this->obr03_dtlancamento_mes = ($this->obr03_dtlancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtlancamento_mes"]:$this->obr03_dtlancamento_mes);
         $this->obr03_dtlancamento_ano = ($this->obr03_dtlancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtlancamento_ano"]:$this->obr03_dtlancamento_ano);
         if ($this->obr03_dtlancamento_dia != "") {
            $this->obr03_dtlancamento = $this->obr03_dtlancamento_ano."-".$this->obr03_dtlancamento_mes."-".$this->obr03_dtlancamento_dia;
         }
       }
       $this->obr03_nummedicao = ($this->obr03_nummedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_nummedicao"]:$this->obr03_nummedicao);
       $this->obr03_tipomedicao = ($this->obr03_tipomedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_tipomedicao"]:$this->obr03_tipomedicao);
       if ($this->obr03_dtiniciomedicao == "") {
         $this->obr03_dtiniciomedicao_dia = ($this->obr03_dtiniciomedicao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtiniciomedicao_dia"]:$this->obr03_dtiniciomedicao_dia);
         $this->obr03_dtiniciomedicao_mes = ($this->obr03_dtiniciomedicao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtiniciomedicao_mes"]:$this->obr03_dtiniciomedicao_mes);
         $this->obr03_dtiniciomedicao_ano = ($this->obr03_dtiniciomedicao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtiniciomedicao_ano"]:$this->obr03_dtiniciomedicao_ano);
         if ($this->obr03_dtiniciomedicao_dia != "") {
            $this->obr03_dtiniciomedicao = $this->obr03_dtiniciomedicao_ano."-".$this->obr03_dtiniciomedicao_mes."-".$this->obr03_dtiniciomedicao_dia;
         }
       }
       $this->obr03_outrostiposmedicao = ($this->obr03_outrostiposmedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_outrostiposmedicao"]:$this->obr03_outrostiposmedicao);
       $this->obr03_descmedicao = ($this->obr03_descmedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_descmedicao"]:$this->obr03_descmedicao);
       if ($this->obr03_dtfimmedicao == "") {
         $this->obr03_dtfimmedicao_dia = ($this->obr03_dtfimmedicao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtfimmedicao_dia"]:$this->obr03_dtfimmedicao_dia);
         $this->obr03_dtfimmedicao_mes = ($this->obr03_dtfimmedicao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtfimmedicao_mes"]:$this->obr03_dtfimmedicao_mes);
         $this->obr03_dtfimmedicao_ano = ($this->obr03_dtfimmedicao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtfimmedicao_ano"]:$this->obr03_dtfimmedicao_ano);
         if ($this->obr03_dtfimmedicao_dia != "") {
            $this->obr03_dtfimmedicao = $this->obr03_dtfimmedicao_ano."-".$this->obr03_dtfimmedicao_mes."-".$this->obr03_dtfimmedicao_dia;
         }
       }
       if ($this->obr03_dtentregamedicao == "") {
         $this->obr03_dtentregamedicao_dia = ($this->obr03_dtentregamedicao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtentregamedicao_dia"]:$this->obr03_dtentregamedicao_dia);
         $this->obr03_dtentregamedicao_mes = ($this->obr03_dtentregamedicao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtentregamedicao_mes"]:$this->obr03_dtentregamedicao_mes);
         $this->obr03_dtentregamedicao_ano = ($this->obr03_dtentregamedicao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_dtentregamedicao_ano"]:$this->obr03_dtentregamedicao_ano);
         if ($this->obr03_dtentregamedicao_dia != "") {
            $this->obr03_dtentregamedicao = $this->obr03_dtentregamedicao_ano."-".$this->obr03_dtentregamedicao_mes."-".$this->obr03_dtentregamedicao_dia;
         }
       }
       $this->obr03_vlrmedicao = ($this->obr03_vlrmedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_vlrmedicao"]:$this->obr03_vlrmedicao);
       $this->obr03_instit = ($this->obr03_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["obr03_instit"]:$this->obr03_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () {
      $this->atualizacampos();
     if ($this->obr03_sequencial == null ) {
       $result = db_query("select nextval('licobrasmedicao_obr03_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: licobrasmedicao_obr03_sequencial_seq do campo: obr02_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->obr03_sequencial = pg_result($result,0,0);
     }
     if ($this->obr03_seqobra == null ) {
       $this->erro_sql = " Campo Nº Obra não informado.";
       $this->erro_campo = "obr03_seqobra";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr03_dtlancamento == null ) {
       $this->erro_sql = " Campo Data Lançamento não informado.";
       $this->erro_campo = "obr03_dtlancamento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr03_nummedicao == null ) {
       $this->erro_sql = " Campo Nº Medição não informado.";
       $this->erro_campo = "obr03_nummedicao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr03_tipomedicao == "0" ) {
       $this->erro_sql = " Campo Tipo de Medição não informado.";
       $this->erro_campo = "obr03_tipomedicao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr03_dtiniciomedicao == null ) {
       $this->erro_sql = " Campo Início da Medição não informado.";
       $this->erro_campo = "obr03_dtiniciomedicao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->obr03_tipomedicao == "9"){
       if ($this->obr03_outrostiposmedicao == null ) {
         $this->erro_sql = " Campo Outros tipos de Medição não informado.";
         $this->erro_campo = "obr03_outrostiposmedicao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
//     if ($this->obr03_descmedicao == null ) {
//       $this->erro_sql = " Campo Desc. Medição não informado.";
//       $this->erro_campo = "obr03_descmedicao";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->obr03_dtfimmedicao == null ) {
       $this->erro_sql = " Campo Fim da Medição não informado.";
       $this->erro_campo = "obr03_dtfimmedicao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr03_dtentregamedicao == null ) {
       $this->erro_sql = " Campo Entrega da Medição não informado.";
       $this->erro_campo = "obr03_dtentregamedicao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr03_vlrmedicao == null ) {
       $this->erro_sql = " Campo Valor Medição não informado.";
       $this->erro_campo = "obr03_vlrmedicao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr03_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "obr03_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into licobrasmedicao(
                                       obr03_sequencial
                                      ,obr03_seqobra
                                      ,obr03_dtlancamento
                                      ,obr03_nummedicao
                                      ,obr03_tipomedicao
                                      ,obr03_dtiniciomedicao
                                      ,obr03_outrostiposmedicao
                                      ,obr03_descmedicao
                                      ,obr03_dtfimmedicao
                                      ,obr03_dtentregamedicao
                                      ,obr03_vlrmedicao
                                      ,obr03_instit
                       )
                values (
                                $this->obr03_sequencial
                               ,$this->obr03_seqobra
                               ,".($this->obr03_dtlancamento == "null" || $this->obr03_dtlancamento == ""?"null":"'".$this->obr03_dtlancamento."'")."
                               ,$this->obr03_nummedicao
                               ,$this->obr03_tipomedicao
                               ,".($this->obr03_dtiniciomedicao == "null" || $this->obr03_dtiniciomedicao == ""?"null":"'".$this->obr03_dtiniciomedicao."'")."
                               ,'$this->obr03_outrostiposmedicao'
                               ,'$this->obr03_descmedicao'
                               ,".($this->obr03_dtfimmedicao == "null" || $this->obr03_dtfimmedicao == ""?"null":"'".$this->obr03_dtfimmedicao."'")."
                               ,".($this->obr03_dtentregamedicao == "null" || $this->obr03_dtentregamedicao == ""?"null":"'".$this->obr03_dtentregamedicao."'")."
                               ,$this->obr03_vlrmedicao
                               ,$this->obr03_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "cadastro medicao de obras () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "cadastro medicao de obras já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "cadastro medicao de obras () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

    }
    return true;
  }

  // funcao para alteracao
  function alterar ( $obr03_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update licobrasmedicao set ";
     $virgula = "";
     if (trim($this->obr03_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_sequencial"])) {
       $sql  .= $virgula." obr03_sequencial = $this->obr03_sequencial ";
       $virgula = ",";
       if (trim($this->obr03_sequencial) == null ) {
         $this->erro_sql = " Campo Cód. Sequencial não informado.";
         $this->erro_campo = "obr03_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr03_seqobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_seqobra"])) {
       $sql  .= $virgula." obr03_seqobra = $this->obr03_seqobra ";
       $virgula = ",";
       if (trim($this->obr03_seqobra) == null ) {
         $this->erro_sql = " Campo Nº Obra não informado.";
         $this->erro_campo = "obr03_seqobra";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr03_dtlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr03_dtlancamento_dia"] !="") ) {
       $sql  .= $virgula." obr03_dtlancamento = '$this->obr03_dtlancamento' ";
       $virgula = ",";
       if (trim($this->obr03_dtlancamento) == null ) {
         $this->erro_sql = " Campo Data Lançamento não informado.";
         $this->erro_campo = "obr03_dtlancamento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtlancamento_dia"])) {
         $sql  .= $virgula." obr03_dtlancamento = null ";
         $virgula = ",";
         if (trim($this->obr03_dtlancamento) == null ) {
           $this->erro_sql = " Campo Data Lançamento não informado.";
           $this->erro_campo = "obr03_dtlancamento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->obr03_nummedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_nummedicao"])) {
       $sql  .= $virgula." obr03_nummedicao = $this->obr03_nummedicao ";
       $virgula = ",";
       if (trim($this->obr03_nummedicao) == null ) {
         $this->erro_sql = " Campo Nº Medição não informado.";
         $this->erro_campo = "obr03_nummedicao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr03_tipomedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_tipomedicao"])) {
       $sql  .= $virgula." obr03_tipomedicao = $this->obr03_tipomedicao ";
       $virgula = ",";
       if (trim($this->obr03_tipomedicao) == null ) {
         $this->erro_sql = " Campo Tipo de Medição não informado.";
         $this->erro_campo = "obr03_tipomedicao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr03_dtiniciomedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtiniciomedicao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr03_dtiniciomedicao_dia"] !="") ) {
       $sql  .= $virgula." obr03_dtiniciomedicao = '$this->obr03_dtiniciomedicao' ";
       $virgula = ",";
       if (trim($this->obr03_dtiniciomedicao) == null ) {
         $this->erro_sql = " Campo Início da Medição não informado.";
         $this->erro_campo = "obr03_dtiniciomedicao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtiniciomedicao_dia"])) {
         $sql  .= $virgula." obr03_dtiniciomedicao = null ";
         $virgula = ",";
         if (trim($this->obr03_dtiniciomedicao) == null ) {
           $this->erro_sql = " Campo Início da Medição não informado.";
           $this->erro_campo = "obr03_dtiniciomedicao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->obr03_outrostiposmedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_outrostiposmedicao"])) {
       $sql  .= $virgula." obr03_outrostiposmedicao = '$this->obr03_outrostiposmedicao' ";
       $virgula = ",";
       if (trim($this->obr03_outrostiposmedicao) == null ) {
         $this->erro_sql = " Campo Outros tipos de Medição não informado.";
         $this->erro_campo = "obr03_outrostiposmedicao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr03_descmedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_descmedicao"])) {
       $sql  .= $virgula." obr03_descmedicao = '$this->obr03_descmedicao' ";
       $virgula = ",";
       if (trim($this->obr03_descmedicao) == null ) {
         $this->erro_sql = " Campo Desc. Medição não informado.";
         $this->erro_campo = "obr03_descmedicao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr03_dtfimmedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtfimmedicao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr03_dtfimmedicao_dia"] !="") ) {
       $sql  .= $virgula." obr03_dtfimmedicao = '$this->obr03_dtfimmedicao' ";
       $virgula = ",";
       if (trim($this->obr03_dtfimmedicao) == null ) {
         $this->erro_sql = " Campo Fim da Medição não informado.";
         $this->erro_campo = "obr03_dtfimmedicao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtfimmedicao_dia"])) {
         $sql  .= $virgula." obr03_dtfimmedicao = null ";
         $virgula = ",";
         if (trim($this->obr03_dtfimmedicao) == null ) {
           $this->erro_sql = " Campo Fim da Medição não informado.";
           $this->erro_campo = "obr03_dtfimmedicao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->obr03_dtentregamedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtentregamedicao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr03_dtentregamedicao_dia"] !="") ) {
       $sql  .= $virgula." obr03_dtentregamedicao = '$this->obr03_dtentregamedicao' ";
       $virgula = ",";
       if (trim($this->obr03_dtentregamedicao) == null ) {
         $this->erro_sql = " Campo Entrega da Medição não informado.";
         $this->erro_campo = "obr03_dtentregamedicao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["obr03_dtentregamedicao_dia"])) {
         $sql  .= $virgula." obr03_dtentregamedicao = null ";
         $virgula = ",";
         if (trim($this->obr03_dtentregamedicao) == null ) {
           $this->erro_sql = " Campo Entrega da Medição não informado.";
           $this->erro_campo = "obr03_dtentregamedicao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->obr03_vlrmedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_vlrmedicao"])) {
       $sql  .= $virgula." obr03_vlrmedicao = $this->obr03_vlrmedicao ";
       $virgula = ",";
       if (trim($this->obr03_vlrmedicao) == null ) {
         $this->erro_sql = " Campo Valor Medição não informado.";
         $this->erro_campo = "obr03_vlrmedicao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr03_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr03_instit"])) {
       $sql  .= $virgula." obr03_instit = $this->obr03_instit ";
       $virgula = ",";
       if (trim($this->obr03_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "obr03_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "obr03_sequencial = '$obr03_sequencial'";     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "cadastro medicao de obras nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "cadastro medicao de obras nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ( $obr03_sequencial=null ,$dbwhere=null) {

     $sql = " delete from licobrasmedicao
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "obr03_sequencial = $obr03_sequencial";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "cadastro medicao de obras nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "cadastro medicao de obras nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:licobrasmedicao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $obr03_sequencial = null,$campos="licobrasmedicao.obr03_sequencial,*",$ordem=null,$dbwhere="") {
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
     $sql .= " from licobrasmedicao ";
     $sql .= " inner join licobras on licobras.obr01_sequencial = licobrasmedicao.obr03_seqobra";
     $sql .= " inner join liclicita on liclicita.l20_codigo = licobras.obr01_licitacao ";
     $sql .= " inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom  ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $obr03_sequencial != "" && $obr03_sequencial != null) {
          $sql2 = " where licobrasmedicao.obr03_sequencial = '$obr03_sequencial'";
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
  function sql_query_file ( $obr03_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from licobrasmedicao ";
     $sql2 = "";
     if ($dbwhere=="") {
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
