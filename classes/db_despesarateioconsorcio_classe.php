<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE despesarateioconsorcio
class cl_despesarateioconsorcio {
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
  public $c217_sequencial = 0;
  public $c217_enteconsorciado = 0;
  public $c217_funcao = 0;
  public $c217_subfuncao = 0;
  public $c217_natureza = null;
  public $c217_subelemento = null;
  public $c217_fonte = 0;
  public $c217_mes = 0;
  public $c217_anousu = 0;
  public $c217_valorempenhado = 0;
  public $c217_valorempenhadoanulado = 0;
  public $c217_valorliquidado = 0;
  public $c217_valorliquidadoanulado = 0;
  public $c217_valorpago = 0;
  public $c217_valorpagoanulado = 0;
  public $c217_percentualrateio = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 c217_sequencial = int4 =
                 c217_enteconsorciado = int4 = Ente consorciado
                 c217_funcao = int4 = Funcao
                 c217_subfuncao = int4 = Subfuncao
                 c217_natureza = varchar(6) = Natureza
                 c217_subelemento = varchar(2) = Subelemento
                 c217_fonte = int4 = Fonte
                 c217_mes = int4 = Mês
                 c217_anousu = int4 = Ano usu
                 c217_valorempenhado = float4 = Valor empenhado
                 c217_valorempenhadoanulado = float4 = Valor empenhado anulado
                 c217_valorliquidado = float4 = Valor liquidado
                 c217_valorliquidadoanulado = float4 = Valor liquidado anulado
                 c217_valorpago = float4 = Valor pago
                 c217_valorpagoanulado = float4 = Valor pago anulado
                 c217_percentualrateio = float4 = Percentual Rateio
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("despesarateioconsorcio");
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
       $this->c217_sequencial = ($this->c217_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_sequencial"]:$this->c217_sequencial);
       $this->c217_enteconsorciado = ($this->c217_enteconsorciado == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_enteconsorciado"]:$this->c217_enteconsorciado);
       $this->c217_funcao = ($this->c217_funcao == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_funcao"]:$this->c217_funcao);
       $this->c217_subfuncao = ($this->c217_subfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_subfuncao"]:$this->c217_subfuncao);
       $this->c217_natureza = ($this->c217_natureza == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_natureza"]:$this->c217_natureza);
       $this->c217_subelemento = ($this->c217_subelemento == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_subelemento"]:$this->c217_subelemento);
       $this->c217_fonte = ($this->c217_fonte == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_fonte"]:$this->c217_fonte);
       $this->c217_mes = ($this->c217_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_mes"]:$this->c217_mes);
       $this->c217_anousu = ($this->c217_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_anousu"]:$this->c217_anousu);
       $this->c217_valorempenhado = ($this->c217_valorempenhado == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_valorempenhado"]:$this->c217_valorempenhado);
       $this->c217_valorempenhadoanulado = ($this->c217_valorempenhadoanulado == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_valorempenhadoanulado"]:$this->c217_valorempenhadoanulado);
       $this->c217_valorliquidado = ($this->c217_valorliquidado == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_valorliquidado"]:$this->c217_valorliquidado);
       $this->c217_valorliquidadoanulado = ($this->c217_valorliquidadoanulado == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_valorliquidadoanulado"]:$this->c217_valorliquidadoanulado);
       $this->c217_valorpago = ($this->c217_valorpago == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_valorpago"]:$this->c217_valorpago);
       $this->c217_valorpagoanulado = ($this->c217_valorpagoanulado == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_valorpagoanulado"]:$this->c217_valorpagoanulado);
       $this->c217_percentualrateio = ($this->c217_percentualrateio == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_percentualrateio"]:$this->c217_percentualrateio);
     } else {
       $this->c217_sequencial = ($this->c217_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c217_sequencial"]:$this->c217_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($c217_sequencial=null) {
      $this->atualizacampos();
     if ($this->c217_enteconsorciado == null ) {
       $this->erro_sql = " Campo Ente consorciado não informado.";
       $this->erro_campo = "c217_enteconsorciado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_funcao == null ) {
       $this->erro_sql = " Campo Funcao não informado.";
       $this->erro_campo = "c217_funcao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_subfuncao == null ) {
       $this->erro_sql = " Campo Subfuncao não informado.";
       $this->erro_campo = "c217_subfuncao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_natureza == null ) {
       $this->erro_sql = " Campo Natureza não informado.";
       $this->erro_campo = "c217_natureza";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_subelemento == null ) {
       $this->erro_sql = " Campo Subelemento não informado.";
       $this->erro_campo = "c217_subelemento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_fonte == null ) {
       $this->erro_sql = " Campo Fonte não informado.";
       $this->erro_campo = "c217_fonte";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "c217_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_anousu == null ) {
       $this->erro_sql = " Campo Ano usu não informado.";
       $this->erro_campo = "c217_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c217_valorempenhado == null ) {
        $this->c217_valorempenhado = 0;
     }
     if ($this->c217_valorempenhadoanulado == null ) {
        $this->c217_valorempenhadoanulado = 0;
     }
     if ($this->c217_valorliquidado == null ) {
        $this->c217_valorliquidado = 0;
     }
     if ($this->c217_valorliquidadoanulado == null ) {
        $this->c217_valorliquidadoanulado = 0;
     }
     if ($this->c217_valorpago == null ) {
        $this->c217_valorpago = 0;
     }
     if ($this->c217_valorpagoanulado == null ) {
        $this->c217_valorpagoanulado = 0;
     }
     if ($this->c217_percentualrateio == null ) {
        $this->c217_percentualrateio = 0;
     }
     if ($c217_sequencial == "" || $c217_sequencial == null ) {
       $result = db_query("select nextval('despesarateioconsorcio_c217_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: despesarateioconsorcio_c217_sequencial_seq do campo: c217_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c217_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from despesarateioconsorcio_c217_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $c217_sequencial)) {
         $this->erro_sql = " Campo c217_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->c217_sequencial = $c217_sequencial;
       }
     }
     if (($this->c217_sequencial == null) || ($this->c217_sequencial == "") ) {
       $this->erro_sql = " Campo c217_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into despesarateioconsorcio(
                                       c217_sequencial
                                      ,c217_enteconsorciado
                                      ,c217_funcao
                                      ,c217_subfuncao
                                      ,c217_natureza
                                      ,c217_subelemento
                                      ,c217_fonte
                                      ,c217_mes
                                      ,c217_anousu
                                      ,c217_valorempenhado
                                      ,c217_valorempenhadoanulado
                                      ,c217_valorliquidado
                                      ,c217_valorliquidadoanulado
                                      ,c217_valorpago
                                      ,c217_valorpagoanulado
                                      ,c217_percentualrateio
                       )
                values (
                                $this->c217_sequencial
                               ,$this->c217_enteconsorciado
                               ,$this->c217_funcao
                               ,$this->c217_subfuncao
                               ,'$this->c217_natureza'
                               ,'$this->c217_subelemento'
                               ,$this->c217_fonte
                               ,$this->c217_mes
                               ,$this->c217_anousu
                               ,$this->c217_valorempenhado
                               ,$this->c217_valorempenhadoanulado
                               ,$this->c217_valorliquidado
                               ,$this->c217_valorliquidadoanulado
                               ,$this->c217_valorpago
                               ,$this->c217_valorpagoanulado
                               ,$this->c217_percentualrateio
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "despesa rateio consórcio ($this->c217_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "despesa rateio consórcio já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "despesa rateio consórcio ($this->c217_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c217_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

    return true;
  }

  // funcao para alteracao
  function alterar ($c217_sequencial=null) {
      $this->atualizacampos();
     $sql = " update despesarateioconsorcio set ";
     $virgula = "";
     if (trim($this->c217_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_sequencial"])) {
       $sql  .= $virgula." c217_sequencial = $this->c217_sequencial ";
       $virgula = ",";
       if (trim($this->c217_sequencial) == null ) {
         $this->erro_sql = " Campo  não informado.";
         $this->erro_campo = "c217_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_enteconsorciado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_enteconsorciado"])) {
       $sql  .= $virgula." c217_enteconsorciado = $this->c217_enteconsorciado ";
       $virgula = ",";
       if (trim($this->c217_enteconsorciado) == null ) {
         $this->erro_sql = " Campo Ente consorciado não informado.";
         $this->erro_campo = "c217_enteconsorciado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_funcao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_funcao"])) {
       $sql  .= $virgula." c217_funcao = $this->c217_funcao ";
       $virgula = ",";
       if (trim($this->c217_funcao) == null ) {
         $this->erro_sql = " Campo Funcao não informado.";
         $this->erro_campo = "c217_funcao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_subfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_subfuncao"])) {
       $sql  .= $virgula." c217_subfuncao = $this->c217_subfuncao ";
       $virgula = ",";
       if (trim($this->c217_subfuncao) == null ) {
         $this->erro_sql = " Campo Subfuncao não informado.";
         $this->erro_campo = "c217_subfuncao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_natureza)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_natureza"])) {
       $sql  .= $virgula." c217_natureza = '$this->c217_natureza' ";
       $virgula = ",";
       if (trim($this->c217_natureza) == null ) {
         $this->erro_sql = " Campo Natureza não informado.";
         $this->erro_campo = "c217_natureza";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_subelemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_subelemento"])) {
       $sql  .= $virgula." c217_subelemento = '$this->c217_subelemento' ";
       $virgula = ",";
       if (trim($this->c217_subelemento) == null ) {
         $this->erro_sql = " Campo Subelemento não informado.";
         $this->erro_campo = "c217_subelemento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_fonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_fonte"])) {
       $sql  .= $virgula." c217_fonte = $this->c217_fonte ";
       $virgula = ",";
       if (trim($this->c217_fonte) == null ) {
         $this->erro_sql = " Campo Fonte não informado.";
         $this->erro_campo = "c217_fonte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_mes"])) {
       $sql  .= $virgula." c217_mes = $this->c217_mes ";
       $virgula = ",";
       if (trim($this->c217_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "c217_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_anousu"])) {
       $sql  .= $virgula." c217_anousu = $this->c217_anousu ";
       $virgula = ",";
       if (trim($this->c217_anousu) == null ) {
         $this->erro_sql = " Campo Ano usu não informado.";
         $this->erro_campo = "c217_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_valorempenhado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_valorempenhado"])) {
       $sql  .= $virgula." c217_valorempenhado = $this->c217_valorempenhado ";
       $virgula = ",";
       if (trim($this->c217_valorempenhado) == null ) {
         $this->erro_sql = " Campo Valor empenhado não informado.";
         $this->erro_campo = "c217_valorempenhado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_valorempenhadoanulado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_valorempenhadoanulado"])) {
       $sql  .= $virgula." c217_valorempenhadoanulado = $this->c217_valorempenhadoanulado ";
       $virgula = ",";
       if (trim($this->c217_valorempenhadoanulado) == null ) {
         $this->erro_sql = " Campo Valor empenhado anulado não informado.";
         $this->erro_campo = "c217_valorempenhadoanulado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_valorliquidado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_valorliquidado"])) {
       $sql  .= $virgula." c217_valorliquidado = $this->c217_valorliquidado ";
       $virgula = ",";
       if (trim($this->c217_valorliquidado) == null ) {
         $this->erro_sql = " Campo Valor liquidado não informado.";
         $this->erro_campo = "c217_valorliquidado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_valorliquidadoanulado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_valorliquidadoanulado"])) {
       $sql  .= $virgula." c217_valorliquidadoanulado = $this->c217_valorliquidadoanulado ";
       $virgula = ",";
       if (trim($this->c217_valorliquidadoanulado) == null ) {
         $this->erro_sql = " Campo Valor liquidado anulado não informado.";
         $this->erro_campo = "c217_valorliquidadoanulado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_valorpago)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_valorpago"])) {
       $sql  .= $virgula." c217_valorpago = $this->c217_valorpago ";
       $virgula = ",";
       if (trim($this->c217_valorpago) == null ) {
         $this->erro_sql = " Campo Valor pago não informado.";
         $this->erro_campo = "c217_valorpago";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_valorpagoanulado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_valorpagoanulado"])) {
       $sql  .= $virgula." c217_valorpagoanulado = $this->c217_valorpagoanulado ";
       $virgula = ",";
       if (trim($this->c217_valorpagoanulado) == null ) {
         $this->erro_sql = " Campo Valor pago anulado não informado.";
         $this->erro_campo = "c217_valorpagoanulado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c217_percentualrateio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c217_percentualrateio"])) {
       $sql  .= $virgula." c217_percentualrateio = $this->c217_percentualrateio ";
       $virgula = ",";
       if (trim($this->c217_percentualrateio) == null ) {
         $this->erro_sql = " Campo Percentual Rateio não informado.";
         $this->erro_campo = "c217_percentualrateio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($c217_sequencial!=null) {
       $sql .= " c217_sequencial = $this->c217_sequencial";
     }

     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "despesa rateio consórcio nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c217_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "despesa rateio consórcio nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c217_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c217_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($c217_sequencial=null,$dbwhere=null) {

     $sql = " delete from despesarateioconsorcio
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($c217_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c217_sequencial = $c217_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }

     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "despesa rateio consórcio nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c217_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "despesa rateio consórcio nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c217_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c217_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:despesarateioconsorcio";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $c217_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from despesarateioconsorcio ";
     $sql .= "      inner join entesconsorciados  on  entesconsorciados.c215_sequencial = despesarateioconsorcio.c217_enteconsorciado";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = entesconsorciados.c215_cgm";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c217_sequencial!=null ) {
         $sql2 .= " where despesarateioconsorcio.c217_sequencial = $c217_sequencial ";
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
  function sql_query_file ( $c217_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from despesarateioconsorcio ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c217_sequencial!=null ) {
         $sql2 .= " where despesarateioconsorcio.c217_sequencial = $c217_sequencial ";
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
