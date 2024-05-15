<?php
//MODULO: patrimonio
//CLASSE DA ENTIDADE benscontrolerfid
class cl_benscontrolerfid
{
  // cria variaveis de erro 
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status = null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo 
  public $t214_sequencial = 0;
  public $t214_codigobem = 0;
  public $t214_placabem = 0;
  public $t214_descbem = null;
  public $t214_placa_impressa = null;
  public $t214_usuario = 0;
  public $t214_dtlancamento_dia = null;
  public $t214_dtlancamento_mes = null;
  public $t214_dtlancamento_ano = null;
  public $t214_dtlancamento = null;
  public $t214_instit = 0;
  public $t214_data_da_aquisicao_dia = null;
  public $t214_data_da_aquisicao_mes = null;
  public $t214_data_da_aquisicao_ano = null;
  public $t214_data_da_aquisicao = null;
  public $t214_classificacao = null;
  public $t214_fornecedor = null;
  public $t214_descricao_aquisicao = null;
  public $t214_departamento = null;
  public $t214_divisao = null;
  public $t214_convenio = null;
  public $t214_situacao_bem = null;
  public $t214_valor_aquisicao = 0;
  public $t214_valor_residual = 0;
  public $t214_valor_depreciavel = 0;
  public $t214_tipo_depreciacao = null;
  public $t214_valor_atual = 0;
  public $t214_vida_util = 0;
  public $t214_medida = null;
  public $t214_modelo = null;
  public $t214_marca = null;
  public $t214_codigo_item_nota = null;
  public $t214_contabilizado = null;
  public $t214_observacoes = null;
  public $t214_codigo_lote = 0;
  public $t214_quant_lote = 0;
  public $t214_descricao_lote = null;
  public $t214_itbql = 0;
  public $t214_observacoesimovel = null;
  public $t214_cod_notafiscal = 0;
  public $t214_empenho = 0;
  public $t214_cod_ordemdecompra = 0;
  public $t214_garantia = null;
  public $t214_empenhosistema = 0;
  public $t214_controlerfid = 0;

  public $campos = "
                   t214_sequencial = int8 = Sequencial 
                   t214_codigobem = int8 = Codigo do Bem 
                   t214_placabem = int8 = Placa do Bem 
                   t214_descbem = varchar(250) = Descrição do bem 
                   t214_placa_impressa = varchar(250) = Placa impressa 
                   t214_usuario = int8 = Usuario 
                   t214_dtlancamento = date = Data 
                   t214_instit = int8 = Instituição 
                   t214_data_da_aquisicao = date = Data aquisição 
                   t214_classificacao = varchar(250) = Classificação 
                   t214_fornecedor = varchar(250) = Fornecedor 
                   t214_descricao_aquisicao = varchar(250) = Descrição
                   t214_departamento = varchar(250) = Departamento 
                   t214_divisao = varchar(250) = Divisão 
                   t214_convenio = varchar(250) = Convênio 
                   t214_situacao_bem = varchar(30) = Situação do bem 
                   t214_valor_aquisicao = float8 = Valor
                   t214_valor_residual = float8 = Valor residual 
                   t214_valor_depreciavel = float8 = Valor depreciável 
                   t214_tipo_depreciacao = varchar(250) = Tipo depreciação 
                   t214_valor_atual = float8 = Valor atual 
                   t214_vida_util = int8 = Vida útil 
                   t214_medida = varchar(250) = Medida 
                   t214_modelo = varchar(250) = Modelo 
                   t214_marca = varchar(250) = Marca 
                   t214_codigo_item_nota = varchar(250) = Código item nota 
                   t214_contabilizado = varchar(250) = Contabilizado 
                   t214_observacoes = varchar(250) = Observações 
                   t214_codigo_lote = int8 = Código lote 
                   t214_quant_lote = int8 = Quantidade lote 
                   t214_descricao_lote = varchar(250) = Descrição lote 
                   t214_itbql = int8 = Itbql 
                   t214_observacoesimovel = varchar(250) = Observações imóvel 
                   t214_cod_notafiscal = int8 = Código nota fiscal 
                   t214_empenho = int8 = Empenho 
                   t214_cod_ordemdecompra = int8 = Código ordem de compra 
                   t214_garantia = varchar(10) = Garantia 
                   t214_empenhosistema = int8 = Empenho sistema 
                   t214_controlerfid = int8 = Controle rfid 
                   ";

  //funcao construtor da classe 
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("benscontrolerfid");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro 
  function erro($mostra, $retorna)
  {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
      echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
      if ($retorna == true) {
        echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao = false)
  {
    if ($exclusao == false) {
      $this->t214_sequencial = ($this->t214_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_sequencial"] : $this->t214_sequencial);
      $this->t214_codigobem = ($this->t214_codigobem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_codigobem"] : $this->t214_codigobem);
      $this->t214_placabem = ($this->t214_placabem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_placabem"] : $this->t214_placabem);
      $this->t214_descbem = ($this->t214_descbem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_descbem"] : $this->t214_descbem);
      $this->t214_placa_impressa = ($this->t214_placa_impressa == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_placa_impressa"] : $this->t214_placa_impressa);
      $this->t214_usuario = ($this->t214_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_usuario"] : $this->t214_usuario);
      if ($this->t214_dtlancamento == "") {
        $this->t214_dtlancamento_dia = ($this->t214_dtlancamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_dtlancamento_dia"] : $this->t214_dtlancamento_dia);
        $this->t214_dtlancamento_mes = ($this->t214_dtlancamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_dtlancamento_mes"] : $this->t214_dtlancamento_mes);
        $this->t214_dtlancamento_ano = ($this->t214_dtlancamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_dtlancamento_ano"] : $this->t214_dtlancamento_ano);
        if ($this->t214_dtlancamento_dia != "") {
          $this->t214_dtlancamento = $this->t214_dtlancamento_ano . "-" . $this->t214_dtlancamento_mes . "-" . $this->t214_dtlancamento_dia;
        }
      }
      $this->t214_instit = ($this->t214_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_instit"] : $this->t214_instit);
      if ($this->t214_data_da_aquisicao == "") {
        $this->t214_data_da_aquisicao_dia = ($this->t214_data_da_aquisicao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_data_da_aquisicao_dia"] : $this->t214_data_da_aquisicao_dia);
        $this->t214_data_da_aquisicao_mes = ($this->t214_data_da_aquisicao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_data_da_aquisicao_mes"] : $this->t214_data_da_aquisicao_mes);
        $this->t214_data_da_aquisicao_ano = ($this->t214_data_da_aquisicao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_data_da_aquisicao_ano"] : $this->t214_data_da_aquisicao_ano);
        if ($this->t214_data_da_aquisicao_dia != "") {
          $this->t214_data_da_aquisicao = $this->t214_data_da_aquisicao_ano . "-" . $this->t214_data_da_aquisicao_mes . "-" . $this->t214_data_da_aquisicao_dia;
        }
      }
      $this->t214_classificacao = ($this->t214_classificacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_classificacao"] : $this->t214_classificacao);
      $this->t214_fornecedor = ($this->t214_fornecedor == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_fornecedor"] : $this->t214_fornecedor);
      $this->t214_descricao_aquisicao = ($this->t214_descricao_aquisicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_descricao_aquisicao"] : $this->t214_descricao_aquisicao);
      $this->t214_departamento = ($this->t214_departamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_departamento"] : $this->t214_departamento);
      $this->t214_divisao = ($this->t214_divisao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_divisao"] : $this->t214_divisao);
      $this->t214_convenio = ($this->t214_convenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_convenio"] : $this->t214_convenio);
      $this->t214_situacao_bem = ($this->t214_situacao_bem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_situacao_bem"] : $this->t214_situacao_bem);
      $this->t214_valor_aquisicao = ($this->t214_valor_aquisicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_valor_aquisicao"] : $this->t214_valor_aquisicao);
      $this->t214_valor_residual = ($this->t214_valor_residual == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_valor_residual"] : $this->t214_valor_residual);
      $this->t214_valor_depreciavel = ($this->t214_valor_depreciavel == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_valor_depreciavel"] : $this->t214_valor_depreciavel);
      $this->t214_tipo_depreciacao = ($this->t214_tipo_depreciacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_tipo_depreciacao"] : $this->t214_tipo_depreciacao);
      $this->t214_valor_atual = ($this->t214_valor_atual == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_valor_atual"] : $this->t214_valor_atual);
      $this->t214_vida_util = ($this->t214_vida_util == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_vida_util"] : $this->t214_vida_util);
      $this->t214_medida = ($this->t214_medida == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_medida"] : $this->t214_medida);
      $this->t214_modelo = ($this->t214_modelo == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_modelo"] : $this->t214_modelo);
      $this->t214_marca = ($this->t214_marca == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_marca"] : $this->t214_marca);
      $this->t214_codigo_item_nota = ($this->t214_codigo_item_nota == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_codigo_item_nota"] : $this->t214_codigo_item_nota);
      $this->t214_contabilizado = ($this->t214_contabilizado == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_contabilizado"] : $this->t214_contabilizado);
      $this->t214_observacoes = ($this->t214_observacoes == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_observacoes"] : $this->t214_observacoes);
      $this->t214_codigo_lote = ($this->t214_codigo_lote == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_codigo_lote"] : $this->t214_codigo_lote);
      $this->t214_quant_lote = ($this->t214_quant_lote == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_quant_lote"] : $this->t214_quant_lote);
      $this->t214_descricao_lote = ($this->t214_descricao_lote == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_descricao_lote"] : $this->t214_descricao_lote);
      $this->t214_itbql = ($this->t214_itbql == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_itbql"] : $this->t214_itbql);
      $this->t214_observacoesimovel = ($this->t214_observacoesimovel == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_observacoesimovel"] : $this->t214_observacoesimovel);
      $this->t214_cod_notafiscal = ($this->t214_cod_notafiscal == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_cod_notafiscal"] : $this->t214_cod_notafiscal);
      $this->t214_empenho = ($this->t214_empenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_empenho"] : $this->t214_empenho);
      $this->t214_cod_ordemdecompra = ($this->t214_cod_ordemdecompra == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_cod_ordemdecompra"] : $this->t214_cod_ordemdecompra);
      $this->t214_garantia = ($this->t214_garantia == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_garantia"] : $this->t214_garantia);
      $this->t214_empenhosistema = ($this->t214_empenhosistema == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_empenhosistema"] : $this->t214_empenhosistema);
      $this->t214_controlerfid = ($this->t214_controlerfid == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_controlerfid"] : $this->t214_controlerfid);
    } else {
      $this->t214_sequencial = ($this->t214_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["t214_sequencial"] : $this->t214_sequencial);
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if ($this->t214_sequencial == "" || $this->t214_sequencial == null) {
      $result = db_query("select nextval('benscontrolerfid_t214_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: benscontrolerfid_t214_sequencial_seq: t214_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->t214_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from benscontrolerfid_t214_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $this->t214_sequencial)) {
        $this->erro_sql = " Campo t214_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->t214_sequencial = $this->t214_sequencial;
      }
    }
    if (($this->t214_sequencial == null) || ($this->t214_sequencial == "")) {
      $this->erro_sql = " Campo t214_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->t214_placabem == null) {
      $this->erro_sql = " Campo Placa do Bem não informado.";
      $this->erro_campo = "t214_placabem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->t214_codigobem == "" || $this->t214_codigobem == null) {
      $this->erro_sql = " Campo Código do Bem não informado.";
      $this->erro_campo = "t214_codigobem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->t214_descbem == null) {
      $this->erro_sql = " Campo Descrição do bem não informado.";
      $this->erro_campo = "t214_descbem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->t214_placa_impressa == null) {
      $this->t214_placa_impressa = 0;
    }
    if ($this->t214_usuario == null) {
      $this->erro_sql = " Campo Usuario não informado.";
      $this->erro_campo = "t214_usuario";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->t214_dtlancamento == null) {
      $this->erro_sql = " Campo Data não informado.";
      $this->erro_campo = "t214_dtlancamento_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->t214_instit == null) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "t214_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->t214_data_da_aquisicao == null) {
      $this->t214_data_da_aquisicao == null;
    }
    if ($this->t214_classificacao == null) {
      $this->t214_classificacao = 0;
    }
    if ($this->t214_fornecedor == null) {
      $this->t214_fornecedor = 0;
    }
    if ($this->t214_descricao_aquisicao == null) {
      $this->t214_descricao_aquisicao = 0;
    }
    if ($this->t214_departamento == null) {
      $this->t214_departamento = 0;
    }
    if ($this->t214_divisao == null) {
      $this->t214_divisao = 0;
    }
    if ($this->t214_convenio == null) {
      $this->t214_convenio = 0;
    }
    if ($this->t214_situacao_bem == null) {
      $this->t214_situacao_bem = 0;
    }
    if ($this->t214_valor_aquisicao == null) {
      $this->t214_valor_aquisicao = 0;
    }
    if ($this->t214_valor_residual == null) {
      $this->t214_valor_residual = 0;
    }
    if ($this->t214_valor_depreciavel == null) {
      $this->t214_valor_depreciavel = 0;
    }
    if ($this->t214_tipo_depreciacao == null) {
      $this->t214_tipo_depreciacao = 0;
    }
    if ($this->t214_valor_atual == null) {
      $this->t214_valor_atual = 0;
    }
    if ($this->t214_vida_util == null) {
      $this->t214_vida_util = 0;
    }
    if ($this->t214_medida == null) {
      $this->t214_medida = 0;
    }
    if ($this->t214_modelo == null) {
      $this->t214_modelo = 0;
    }
    if ($this->t214_marca == null) {
      $this->t214_marca = 0;
    }
    if ($this->t214_codigo_item_nota == null) {
      $this->t214_codigo_item_nota = 0;
    }
    if ($this->t214_contabilizado == null) {
      $this->t214_contabilizado = 0;
    }
    if ($this->t214_observacoes == null) {
      $this->t214_observacoes = 0;
    }
    if ($this->t214_codigo_lote == null) {
      $this->t214_codigo_lote = 0;
    }
    if ($this->t214_quant_lote == null) {
      $this->t214_quant_lote = 0;
    }
    if ($this->t214_descricao_lote == null) {
      $this->t214_descricao_lote = 0;
    }
    if ($this->t214_itbql == null) {
      $this->t214_itbql = 0;
    }
    if ($this->t214_observacoesimovel == null) {
      $this->t214_observacoesimovel = 0;
    }
    if ($this->t214_cod_notafiscal == null) {
      $this->t214_cod_notafiscal = 0;
    }
    if ($this->t214_empenho == null) {
      $this->t214_empenho = 0;
    }
    if ($this->t214_cod_ordemdecompra == null) {
      $this->t214_cod_ordemdecompra = 0;
    }
    if ($this->t214_garantia == null) {
      $this->t214_garantia = 0;
    }
    if ($this->t214_empenhosistema == null) {
      $this->t214_empenhosistema = 0;
    }
    if ($this->t214_controlerfid == null) {
      $this->erro_sql = " Campo Controle rfid não informado.";
      $this->erro_campo = "t214_controlerfid";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    $sql = "insert into benscontrolerfid(
              t214_sequencial 
              ,t214_codigobem 
              ,t214_placabem 
              ,t214_descbem 
              ,t214_placa_impressa 
              ,t214_usuario 
              ,t214_dtlancamento 
              ,t214_instit 
              ,t214_data_da_aquisicao 
              ,t214_classificacao 
              ,t214_fornecedor 
              ,t214_descricao_aquisicao 
              ,t214_departamento 
              ,t214_divisao 
              ,t214_convenio 
              ,t214_situacao_bem 
              ,t214_valor_aquisicao 
              ,t214_valor_residual 
              ,t214_valor_depreciavel 
              ,t214_tipo_depreciacao 
              ,t214_valor_atual 
              ,t214_vida_util 
              ,t214_medida 
              ,t214_modelo 
              ,t214_marca 
              ,t214_codigo_item_nota 
              ,t214_contabilizado 
              ,t214_observacoes 
              ,t214_codigo_lote 
              ,t214_quant_lote 
              ,t214_descricao_lote 
              ,t214_itbql 
              ,t214_observacoesimovel 
              ,t214_cod_notafiscal 
              ,t214_empenho 
              ,t214_cod_ordemdecompra 
              ,t214_garantia 
              ,t214_empenhosistema 
              ,t214_controlerfid 
          )
          values (
              $this->t214_sequencial 
              ,'$this->t214_codigobem' 
              ,$this->t214_placabem 
              ,'$this->t214_descbem' 
              ,'$this->t214_placa_impressa' 
              ,$this->t214_usuario 
              ," . ($this->t214_dtlancamento == "null" || $this->t214_dtlancamento == "" ? "null" : "'" . $this->t214_dtlancamento . "'") . " 
              ,$this->t214_instit 
              ," . ($this->t214_data_da_aquisicao == "null" || $this->t214_data_da_aquisicao == "" ? "null" : "'" . $this->t214_data_da_aquisicao . "'") . " 
              ,'$this->t214_classificacao' 
              ,'$this->t214_fornecedor' 
              ,'$this->t214_descricao_aquisicao' 
              ,'$this->t214_departamento' 
              ,'$this->t214_divisao' 
              ,'$this->t214_convenio' 
              ,'$this->t214_situacao_bem' 
              ,$this->t214_valor_aquisicao 
              ,$this->t214_valor_residual 
              ,$this->t214_valor_depreciavel 
              ,'$this->t214_tipo_depreciacao' 
              ,$this->t214_valor_atual 
              ,$this->t214_vida_util 
              ,'$this->t214_medida' 
              ,'$this->t214_modelo' 
              ,'$this->t214_marca' 
              ,'$this->t214_codigo_item_nota' 
              ,'$this->t214_contabilizado' 
              ,'$this->t214_observacoes' 
              ,$this->t214_codigo_lote 
              ,$this->t214_quant_lote 
              ,'$this->t214_descricao_lote' 
              ,$this->t214_itbql 
              ,'$this->t214_observacoesimovel' 
              ,$this->t214_cod_notafiscal 
              ,$this->t214_empenho 
              ,$this->t214_cod_ordemdecompra 
              ,'$this->t214_garantia' 
              ,$this->t214_empenhosistema 
              ,$this->t214_controlerfid 
          )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "Controle rfid () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "Controle rfid já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "Controle rfid () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
      && ($lSessaoDesativarAccount === false))) {
    }
    return true;
  }

  // funcao para alteracao
  function alterar($t214_codigobem = null)
  {
    $this->atualizacampos();
    $sql = " update benscontrolerfid set ";
    $virgula = "";
    if (trim($this->t214_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_sequencial"])) {
      $sql  .= $virgula . " t214_sequencial = $this->t214_sequencial ";
      $virgula = ",";
      if (trim($this->t214_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "t214_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_codigobem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_codigobem"])) {
      $sql  .= $virgula . " t214_codigobem = $this->t214_codigobem ";
      $virgula = ",";
      if (trim($this->t214_codigobem) == null) {
        $this->erro_sql = " Campo Código do Bem não informado.";
        $this->erro_campo = "t214_codigobem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_placabem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_placabem"])) {
      $sql  .= $virgula . " t214_placabem = $this->t214_placabem ";
      $virgula = ",";
      if (trim($this->t214_placabem) == null) {
        $this->erro_sql = " Campo Placa do Bem não informado.";
        $this->erro_campo = "t214_placabem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_descbem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_descbem"])) {
      $sql  .= $virgula . " t214_descbem = '$this->t214_descbem' ";
      $virgula = ",";
      if (trim($this->t214_descbem) == null) {
        $this->erro_sql = " Campo Descrição do bem não informado.";
        $this->erro_campo = "t214_descbem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_placa_impressa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_placa_impressa"])) {
      $sql  .= $virgula . " t214_placa_impressa = '$this->t214_placa_impressa' ";
      $virgula = ",";
      if (trim($this->t214_placa_impressa) == null) {
        $this->erro_sql = " Campo Placa impressa não informado.";
        $this->erro_campo = "t214_placa_impressa";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_usuario"])) {
      $sql  .= $virgula . " t214_usuario = $this->t214_usuario ";
      $virgula = ",";
      if (trim($this->t214_usuario) == null) {
        $this->erro_sql = " Campo Usuario não informado.";
        $this->erro_campo = "t214_usuario";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["t214_dtlancamento_dia"] != "")) {
      $sql  .= $virgula . " t214_dtlancamento = '$this->t214_dtlancamento' ";
      $virgula = ",";
      if (trim($this->t214_dtlancamento) == null) {
        $this->erro_sql = " Campo Data não informado.";
        $this->erro_campo = "t214_dtlancamento_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["t214_dtlancamento_dia"])) {
        $sql  .= $virgula . " t214_dtlancamento = null ";
        $virgula = ",";
        if (trim($this->t214_dtlancamento) == null) {
          $this->erro_sql = " Campo Data Lançamento não informado.";
          $this->erro_campo = "t214_dtlancamento_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->t214_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_instit"])) {
      $sql  .= $virgula . " t214_instit = $this->t214_instit ";
      $virgula = ",";
      if (trim($this->t214_instit) == null) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "t214_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_data_da_aquisicao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_data_da_aquisicao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["t214_data_da_aquisicao_dia"] != "")) {
      $sql  .= $virgula . " t214_data_da_aquisicao = '$this->t214_data_da_aquisicao' ";
      $virgula = ",";
      if (trim($this->t214_data_da_aquisicao) == null) {
        $this->erro_sql = " Campo Data da aquisição não informado.";
        $this->erro_campo = "t214_data_da_aquisicao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["t214_data_da_aquisicao_dia"])) {
        $sql  .= $virgula . " t214_data_da_aquisicao = null ";
        $virgula = ",";
        if (trim($this->t214_data_da_aquisicao) == null) {
          $this->erro_sql = " Campo Data aquisição não informado.";
          $this->erro_campo = "t214_data_da_aquisicao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->t214_classificacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_classificacao"])) {
      $sql  .= $virgula . " t214_classificacao = '$this->t214_classificacao' ";
      $virgula = ",";
      if (trim($this->t214_classificacao) == null) {
        $this->erro_sql = " Campo çãonformado.";
        $this->erro_campo = "t214_classificacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_fornecedor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_fornecedor"])) {
      $sql  .= $virgula . " t214_fornecedor = '$this->t214_fornecedor' ";
      $virgula = ",";
      if (trim($this->t214_fornecedor) == null) {
        $this->erro_sql = " Campo Fornecedor não informado.";
        $this->erro_campo = "t214_fornecedor";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_descricao_aquisicao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_descricao_aquisicao"])) {
      $sql  .= $virgula . " t214_descricao_aquisicao = '$this->t214_descricao_aquisicao' ";
      $virgula = ",";
      if (trim($this->t214_descricao_aquisicao) == null) {
        $this->erro_sql = " Campo Descrição aquisição não informado.";
        $this->erro_campo = "t214_descricao_aquisicao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_departamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_departamento"])) {
      $sql  .= $virgula . " t214_departamento = '$this->t214_departamento' ";
      $virgula = ",";
      if (trim($this->t214_departamento) == null) {
        $this->erro_sql = " Campo Departamento não informado.";
        $this->erro_campo = "t214_departamento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_divisao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_divisao"])) {
      $sql  .= $virgula . " t214_divisao = '$this->t214_divisao' ";
      $virgula = ",";
      if (trim($this->t214_divisao) == null) {
        $this->erro_sql = " Campã não informado.";
        $this->erro_campo = "t214_divisao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_convenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_convenio"])) {
      $sql  .= $virgula . " t214_convenio = '$this->t214_convenio' ";
      $virgula = ",";
      if (trim($this->t214_convenio) == null) {
        $this->erro_sql = " Campo Convênio não informado.";
        $this->erro_campo = "t214_convenio";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_situacao_bem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_situacao_bem"])) {
      $sql  .= $virgula . " t214_situacao_bem = '$this->t214_situacao_bem' ";
      $virgula = ",";
      if (trim($this->t214_situacao_bem) == null) {
        $this->erro_sql = " Campo Situação do bem não informado.";
        $this->erro_campo = "t214_situacao_bem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_valor_aquisicao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_valor_aquisicao"])) {
      $sql  .= $virgula . " t214_valor_aquisicao = $this->t214_valor_aquisicao ";
      $virgula = ",";
      if (trim($this->t214_valor_aquisicao) == null) {
        $this->erro_sql = " Campo Valor aquisição não informado.";
        $this->erro_campo = "t214_valor_aquisicao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_valor_residual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_valor_residual"])) {
      $sql  .= $virgula . " t214_valor_residual = $this->t214_valor_residual ";
      $virgula = ",";
      if (trim($this->t214_valor_residual) == null) {
        $this->erro_sql = " Campo Valor residual não informado.";
        $this->erro_campo = "t214_valor_residual";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_valor_depreciavel) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_valor_depreciavel"])) {
      $sql  .= $virgula . " t214_valor_depreciavel = $this->t214_valor_depreciavel ";
      $virgula = ",";
      if (trim($this->t214_valor_depreciavel) == null) {
        $this->erro_sql = " Campo Valor depreciavel não informado.";
        $this->erro_campo = "t214_valor_depreciavel";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_tipo_depreciacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_tipo_depreciacao"])) {
      $sql  .= $virgula . " t214_tipo_depreciacao = '$this->t214_tipo_depreciacao' ";
      $virgula = ",";
      if (trim($this->t214_tipo_depreciacao) == null) {
        $this->erro_sql = " Campo t214_tipo_depreciacao não informado.";
        $this->erro_campo = "t214_tipo_depreciacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_valor_atual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_valor_atual"])) {
      $sql  .= $virgula . " t214_valor_atual = $this->t214_valor_atual ";
      $virgula = ",";
      if (trim($this->t214_valor_atual) == null) {
        $this->erro_sql = " Campo Valor atual não informado.";
        $this->erro_campo = "t214_valor_atual";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_vida_util) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_vida_util"])) {
      $sql  .= $virgula . " t214_vida_util = $this->t214_vida_util ";
      $virgula = ",";
      if (trim($this->t214_vida_util) == null) {
        $this->erro_sql = " Campo Vida util não informado.";
        $this->erro_campo = "t214_vida_util";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_medida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_medida"])) {
      $sql  .= $virgula . " t214_medida = '$this->t214_medida' ";
      $virgula = ",";
      if (trim($this->t214_medida) == null) {
        $this->erro_sql = " Campo Medida não informado.";
        $this->erro_campo = "t214_medida";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_modelo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_modelo"])) {
      $sql  .= $virgula . " t214_modelo = '$this->t214_modelo' ";
      $virgula = ",";
      if (trim($this->t214_modelo) == null) {
        $this->erro_sql = " Campo Modelo não informado.";
        $this->erro_campo = "t214_modelo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_marca) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_marca"])) {
      $sql  .= $virgula . " t214_marca = '$this->t214_marca' ";
      $virgula = ",";
      if (trim($this->t214_marca) == null) {
        $this->erro_sql = " Campo Marca não informado.";
        $this->erro_campo = "t214_marca";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_codigo_item_nota) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_codigo_item_nota"])) {
      $sql  .= $virgula . " t214_codigo_item_nota = '$this->t214_codigo_item_nota' ";
      $virgula = ",";
      if (trim($this->t214_codigo_item_nota) == null) {
        $this->erro_sql = " Campo Codigo item nota não informado.";
        $this->erro_campo = "t214_codigo_item_nota";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_contabilizado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_contabilizado"])) {
      $sql  .= $virgula . " t214_contabilizado = '$this->t214_contabilizado' ";
      $virgula = ",";
      if (trim($this->t214_contabilizado) == null) {
        $this->erro_sql = " Campo Contabilizado não informado.";
        $this->erro_campo = "t214_contabilizado";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_observacoes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_observacoes"])) {
      $sql  .= $virgula . " t214_observacoes = '$this->t214_observacoes' ";
      $virgula = ",";
      if (trim($this->t214_observacoes) == null) {
        $this->erro_sql = " Campo Observacoes não informado.";
        $this->erro_campo = "t214_observacoes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_codigo_lote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_codigo_lote"])) {
      $sql  .= $virgula . " t214_codigo_lote = $this->t214_codigo_lote ";
      $virgula = ",";
      if (trim($this->t214_codigo_lote) == null) {
        $this->erro_sql = " Campo Codigo lote não informado.";
        $this->erro_campo = "t214_codigo_lote";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_quant_lote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_quant_lote"])) {
      $sql  .= $virgula . " t214_quant_lote = $this->t214_quant_lote ";
      $virgula = ",";
      if (trim($this->t214_quant_lote) == null) {
        $this->erro_sql = " Campo Quantidade lote não informado.";
        $this->erro_campo = "t214_quant_lote";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_descricao_lote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_descricao_lote"])) {
      $sql  .= $virgula . " t214_descricao_lote = '$this->t214_descricao_lote' ";
      $virgula = ",";
      if (trim($this->t214_descricao_lote) == null) {
        $this->erro_sql = " Campo Descricao lote não informado.";
        $this->erro_campo = "t214_descricao_lote";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_itbql) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_itbql"])) {
      $sql  .= $virgula . " t214_itbql = $this->t214_itbql ";
      $virgula = ",";
      if (trim($this->t214_itbql) == null) {
        $this->erro_sql = " Campo Itbql não informado.";
        $this->erro_campo = "t214_itbql";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_observacoesimovel) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_observacoesimovel"])) {
      $sql  .= $virgula . " t214_observacoesimovel = '$this->t214_observacoesimovel' ";
      $virgula = ",";
      if (trim($this->t214_observacoesimovel) == null) {
        $this->erro_sql = " Campo Observacoes imovel não informado.";
        $this->erro_campo = "t214_observacoesimovel";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_cod_notafiscal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_cod_notafiscal"])) {
      $sql  .= $virgula . " t214_cod_notafiscal = $this->t214_cod_notafiscal ";
      $virgula = ",";
      if (trim($this->t214_cod_notafiscal) == null) {
        $this->erro_sql = " Campo Codigo nota fiscal não informado.";
        $this->erro_campo = "t214_cod_notafiscal";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_empenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_empenho"])) {
      $sql  .= $virgula . " t214_empenho = $this->t214_empenho ";
      $virgula = ",";
      if (trim($this->t214_empenho) == null) {
        $this->erro_sql = " Campo Empenho não informado.";
        $this->erro_campo = "t214_empenho";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_cod_ordemdecompra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_cod_ordemdecompra"])) {
      $sql  .= $virgula . " t214_cod_ordemdecompra = $this->t214_cod_ordemdecompra ";
      $virgula = ",";
      if (trim($this->t214_cod_ordemdecompra) == null) {
        $this->erro_sql = " Campo Codigo ordem de compra não informado.";
        $this->erro_campo = "t214_cod_ordemdecompra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_garantia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_garantia"])) {
      $sql  .= $virgula . " t214_garantia = '$this->t214_garantia' ";
      $virgula = ",";
      if (trim($this->t214_garantia) == null) {
        $this->erro_sql = " Campo Garantia não informado.";
        $this->erro_campo = "t214_garantia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_empenhosistema) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_empenhosistema"])) {
      $sql  .= $virgula . " t214_empenhosistema = $this->t214_empenhosistema ";
      $virgula = ",";
      if (trim($this->t214_empenhosistema) == null) {
        $this->erro_sql = " Campo Empenho sistema não informado.";
        $this->erro_campo = "t214_empenhosistema";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t214_controlerfid) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t214_controlerfid"])) {
      $sql  .= $virgula . " t214_controlerfid = $this->t214_controlerfid ";
      $virgula = ",";
      if (trim($this->t214_controlerfid) == null) {
        $this->erro_sql = " Campo Controle rfid não informado.";
        $this->erro_campo = "t214_controlerfid";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "t214_codigobem = '$t214_codigobem'";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Controle rfid nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Controle rfid nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir($oid = null, $dbwhere = null)
  {
    $sql = " delete from benscontrolerfid
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "oid = '$oid'";
    } else {
      $sql2 = $dbwhere;
    }

    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Controle rfid nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Controle rfid nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao do recordset 
  function sql_record($sql)
  {
    $result = db_query($sql);
    if ($result == false) {
      $this->numrows    = 0;
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql   = "Record Vazio na Tabela:benscontrolerfid";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql 
  function sql_query($oid = null, $campos = "benscontrolerfid.oid,*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from benscontrolerfid ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where benscontrolerfid.oid = '$oid'";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }

  // funcao do sql 
  function sql_query_file($oid = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from benscontrolerfid ";
    $sql2 = "";
    if ($dbwhere == "") {
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql 
  function sql_query_file_sequencial($campos = "*")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }

    return $sql;
  }
}
