<?

/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

//MODULO: patrim
//CLASSE DA ENTIDADE bensimoveis
class cl_bensimoveis
{
  // cria variaveis de erro 
  var $rotulo     = null;
  var $query_sql  = null;
  var $numrows    = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status = null;
  var $erro_sql   = null;
  var $erro_banco = null;
  var $erro_msg   = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo 
  var $t54_codbem = 0;
  var $t54_idbql = 0;
  var $t54_obs = null;
  var $t54_endereco = null;
  var $t54_valor_terreno = null;
  var $t54_valor_area = null;
  var $t54_valor_total = null;
  var $t54_limites_confrontacoes = null;
  var $t54_aplicacao = null;
  var $t54_prop_anterior = null;
  var $t54_cpfcnpj = null;
  var $t54_cartorio_tc = null;
  var $t54_comarca_tc = null;
  var $t54_registro_tc = null;
  var $t54_livro_tc = null;
  var $t54_folha_tc = null;
  var $t54_data_tc_dia = null;
  var $t54_data_tc_mes = null;
  var $t54_data_tc_ano = null;
  var $t54_data_tc = null;
  var $t54_cartorio_tp = null;
  var $t54_tabeliao_tp = null;
  var $t54_livro_tp = null;
  var $t54_folha_tp = null;
  var $t54_data_tp_dia = null;
  var $t54_data_tp_mes = null;
  var $t54_data_tp_ano = null;
  var $t54_data_tp = null;
  var $t54_escritura_tp = null;
  var $t54_carta_tp = null;



  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 t54_codbem = int8 = Código do bem 
                 t54_idbql = int4 = Codigo Lote 
                 t54_obs = text = Observações
                 t54_endereco = text = Endereço
                 t54_valor_terreno = double = Valor do Terreno
                 t54_valor_area = double = Valor Área Construída
                 t54_valor_total = double = Valor total
                 t54_limites_confrontacoes = text = Limites e Confrontações
                 t54_aplicacao = text = Aplicação;
                 t54_prop_anterior = text = Proprietário Anterior
                 t54_cpfcnpj = int14 = Campo numérico
                 t54_cartorio_tc = text = Cartório - Transcrição no Cartório
                 t54_comarca_tc = text = Comarca - Transcrição no Cartório
                 t54_registro_tc = int14 = N° Registro
                 t54_livro_tc = text = Livro - Transcrição no Cartório
                 t54_folha_tc = int14 = Folha - Transcrição no Cartório
                 t54_data_tc = date = Data - Transcrição no cartório
                 t54_cartorio_tp = text = Cartório - Título de Propriedade
                 t54_tabeliao_tp = text
                 t54_livro_tp = text = Livro - Título de Propriedade
                 t54_folha_tp = int14 = Folha - Título de Propriedade
                 t54_data_tp = date = Data - Título de Propriedade
                 t54_escritura_tp = text = Escritura
                 t54_carta_tp = text = Carta de sentença 
                 ";
  //funcao construtor da classe 
  function cl_bensimoveis()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("bensimoveis");
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
      $this->t54_codbem = ($this->t54_codbem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_codbem"] : $this->t54_codbem);
      $this->t54_idbql = ($this->t54_idbql == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_idbql"] : $this->t54_idbql);
      $this->t54_obs = ($this->t54_obs == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_obs"] : $this->t54_obs);
      $this->t54_endereco = ($this->t54_endereco == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_endereco"] : $this->t54_endereco);
      $this->t54_valor_terreno = ($this->t54_valor_terreno == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_valor_terreno"] : $this->t54_valor_terreno);
      $this->t54_valor_area = ($this->t54_valor_area == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_valor_area"] : $this->t54_valor_area);
      $this->t54_valor_total = ($this->t54_valor_total == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_valor_total"] : $this->t54_valor_total);
      $this->t54_limites_confrontacoes = ($this->t54_limites_confrontacoes == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_limites_confrontacoes"] : $this->t54_limites_confrontacoes);
      $this->t54_aplicacao = ($this->t54_aplicacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_aplicacao"] : $this->t54_aplicacao);
      $this->t54_prop_anterior = ($this->t54_prop_anterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_prop_anterior"] : $this->t54_obs);
      $this->t54_cpfcnpj = ($this->t54_cpfcnpj == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_cpfcnpj"] : $this->t54_cpfcnpj);
      $this->t54_cartorio_tc = ($this->t54_cartorio_tc == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_cartorio_tc"] : $this->t54_cartorio_tc);
      $this->t54_comarca_tc = ($this->t54_comarca_tc == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_comarca_tc"] : $this->t54_comarca_tc);
      $this->t54_registro_tc = ($this->t54_registro_tc == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_registro_tc"] : $this->t54_registro_tc);
      $this->t54_livro_tc = ($this->t54_livro_tc == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_livro_tc"] : $this->t54_livro_tc);
      $this->t54_folha_tc = ($this->t54_folha_tc == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_folha_tc"] : $this->t54_folha_tc);
      $this->t54_cartorio_tp = ($this->t54_cartorio_tp == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_cartorio_tp"] : $this->t54_cartorio_tp);
      $this->t54_tabeliao_tp = ($this->t54_tabeliao_tp == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_tabeliao_tp"] : $this->t54_tabeliao_tp);
      $this->t54_livro_tp = ($this->t54_livro_tp == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_livro_tp"] : $this->t54_livro_tp);
      $this->t54_folha_tp = ($this->t54_folha_tp == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_folha_tp"] : $this->t54_folha_tp);
      $this->t54_escritura_tp = ($this->t54_escritura_tp == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_escritura_tp"] : $this->t54_escritura_tp);
      $this->t54_carta_tp = ($this->t54_carta_tp == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_carta_tp"] : $this->t54_carta_tp);

      if ($this->t54_data_tc == "") {
        $this->t54_data_tc_dia = ($this->t54_data_tc_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_data_tc_dia"] : $this->t54_data_tc_dia);
        $this->t54_data_tc_mes = ($this->t54_data_tc_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_data_tc_mes"] : $this->t54_data_tc_mes);
        $this->t54_data_tc_ano = ($this->t54_data_tc_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_data_tc_ano"] : $this->t54_data_tc_ano);
        if ($this->t54_data_tc_dia != "") {
          $this->t54_data_tc = $this->t54_data_tc_ano . "-" . $this->t54_data_tc_mes . "-" . $this->t54_data_tc_dia;
        }
      }

      if ($this->t54_data_tp == "") {
        $this->t54_data_tp_dia = ($this->t54_data_tp_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_data_tp_dia"] : $this->t54_data_tp_dia);
        $this->t54_data_tp_mes = ($this->t54_data_tp_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_data_tp_mes"] : $this->t54_data_tp_mes);
        $this->t54_data_tp_ano = ($this->t54_data_tp_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_data_tp_ano"] : $this->t54_data_tp_ano);
        if ($this->t54_data_tp_dia != "") {
          $this->t54_data_tp = $this->t54_data_tp_ano . "-" . $this->t54_data_tp_mes . "-" . $this->t54_data_tp_dia;
        }
      }
    } else {
      $this->t54_codbem = ($this->t54_codbem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_codbem"] : $this->t54_codbem);
      $this->t54_idbql = ($this->t54_idbql == "" ? @$GLOBALS["HTTP_POST_VARS"]["t54_idbql"] : $this->t54_idbql);
    }
  }
  // funcao para inclusao
  function incluir($t54_codbem, $t54_idbql)
  {
    $this->atualizacampos();
    $this->t54_codbem = $t54_codbem;
    $this->t54_idbql = $t54_idbql;
    if (($this->t54_codbem == null) || ($this->t54_codbem == "")) {
      $this->erro_sql = " Campo t54_codbem nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if (($this->t54_endereco == null) || ($this->t54_endereco == "")) {
      $this->erro_sql = " Campo t54_endereco nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if (($this->t54_valor_terreno == null) || ($this->t54_valor_terreno == "")) {
      $this->erro_sql = " Campo t54_valor_terreno nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->t54_valor_area == null) || ($this->t54_valor_area == "")) {
      $this->erro_sql = " Campo t54_valor_area nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->t54_valor_total == null) || ($this->t54_valor_total == "")) {
      $this->erro_sql = " Campo t54_valor_total nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->t54_limites_confrontacoes == null) || ($this->t54_limites_confrontacoes == "")) {
      $this->erro_sql = " Campo t54_limites_confrontacoes nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->t54_aplicacao == null) || ($this->t54_aplicacao == "")) {
      $this->erro_sql = " Campo t54_aplicacao nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t54_idbql == "") {
      $this->t54_idbql = 'null';
    }

    if ($this->t54_cpfcnpj == "") {
      $this->t54_cpfcnpj = 'null';
    }

    if ($this->t54_registro_tc == "") {
      $this->t54_registro_tc = 'null';
    }

    if ($this->t54_folha_tc == "") {
      $this->t54_folha_tc = 'null';
    }

    if ($this->t54_folha_tp == "") {
      $this->t54_folha_tp = 'null';
    }

    if ($this->t54_data_tp == "") {
      $this->t54_data_tp = "null";
    } else {
      $this->t54_data_tp = "'" . $this->t54_data_tp . "'";
    }

    if ($this->t54_data_tc == "") {
      $this->t54_data_tc = "null";
    } else {
      $this->t54_data_tc = "'" . $this->t54_data_tc . "'";
    }



    $sql = "insert into bensimoveis(
                                       t54_codbem 
                                      ,t54_idbql 
                                      ,t54_obs
                                      ,t54_endereco
                                      ,t54_valor_terreno
                                      ,t54_valor_area
                                      ,t54_valor_total
                                      ,t54_limites_confrontacoes
                                      ,t54_aplicacao
                                      ,t54_prop_anterior
                                      ,t54_cpfcnpj
                                      ,t54_cartorio_tc
                                      ,t54_comarca_tc
                                      ,t54_registro_tc
                                      ,t54_livro_tc
                                      ,t54_folha_tc
                                      ,t54_data_tc
                                      ,t54_cartorio_tp
                                      ,t54_tabeliao_tp
                                      ,t54_livro_tp
                                      ,t54_folha_tp
                                      ,t54_data_tp
                                      ,t54_escritura_tp
                                      ,t54_carta_tp 
                       )
                values (
                                $this->t54_codbem 
                               ,$this->t54_idbql 
                               ,'$this->t54_obs'
                               ,'$this->t54_endereco'
                               ,$this->t54_valor_terreno
                               ,$this->t54_valor_area
                               ,$this->t54_valor_total
                               ,'$this->t54_limites_confrontacoes'
                               ,'$this->t54_aplicacao'
                               ,'$this->prop_anterior'
                               ,$this->t54_cpfcnpj
                               ,'$this->t54_cartorio_tc'
                               ,'$this->t54_comarca_tc'
                               ,$this->t54_registro_tc
                               ,'$this->t54_livro_tc'
                               ,$this->t54_folha_tc
                               ,$this->t54_data_tc
                               ,'$this->t54_cartorio_tp'
                               ,'$this->t54_tabeliao_tp'
                               ,'$this->t54_livro_tp'
                               ,$this->t54_folha_tp
                               ,$this->t54_data_tp
                               ,'$this->t54_escritura_tp'
                               ,'$this->t54_carta_tp' 

                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "Bens imóveis ($this->t54_codbem) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "Bens imóveis já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "Bens imóveis ($this->t54_codbem) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->t54_codbem;
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->t54_codbem, $this->t54_idbql));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,5781,'$this->t54_codbem','I')");
      $resac = db_query("insert into db_acountkey values($acount,5782,'$this->t54_idbql','I')");
      $resac = db_query("insert into db_acount values($acount,916,5781,'','" . AddSlashes(pg_result($resaco, 0, 't54_codbem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,916,5782,'','" . AddSlashes(pg_result($resaco, 0, 't54_idbql')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,916,5783,'','" . AddSlashes(pg_result($resaco, 0, 't54_obs')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  // funcao para alteracao
  function alterar($t54_codbem = null, $t54_idbql = null)
  {
    $this->atualizacampos();
    $sql = " update bensimoveis set ";
    $virgula = "";
    if (trim($this->t54_codbem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t54_codbem"])) {
      $sql  .= $virgula . " t54_codbem = $this->t54_codbem ";
      $virgula = ",";
      if (trim($this->t54_codbem) == null) {
        $this->erro_sql = " Campo Código do bem nao Informado.";
        $this->erro_campo = "t54_codbem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }


    if (trim($this->t54_endereco) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t54_endereco"])) {
      $sql  .= $virgula . " t54_endereco = '$this->t54_endereco' ";
      $virgula = ",";
      if (trim($this->t54_endereco) == null) {
        $this->erro_sql = " Campo Endereço nao Informado.";
        $this->erro_campo = "t54_endereco";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t54_valor_total) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t54_valor_total"])) {
      $sql  .= $virgula . " t54_valor_total = $this->t54_valor_total ";
      $virgula = ",";
      if (trim($this->t54_valor_total) == null) {
        $this->erro_sql = " Campo valor total nao Informado.";
        $this->erro_campo = "t54_valor_total";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t54_valor_area) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t54_valor_area"])) {
      $sql  .= $virgula . " t54_valor_area = $this->t54_valor_area ";
      $virgula = ",";
      if (trim($this->t54_valor_area) == null) {
        $this->erro_sql = " Campo valor área nao Informado.";
        $this->erro_campo = "t54_valor_area";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t54_valor_terreno) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t54_valor_terreno"])) {
      $sql  .= $virgula . " t54_valor_terreno = $this->t54_valor_terreno ";
      $virgula = ",";
      if (trim($this->t54_valor_terreno) == null) {
        $this->erro_sql = " Campo valor terreno nao Informado.";
        $this->erro_campo = "t54_valor_terreno";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t54_aplicacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t54_aplicacao"])) {
      $sql  .= $virgula . " t54_aplicacao = '$this->t54_aplicacao' ";
      $virgula = ",";
      if (trim($this->t54_aplicacao) == null) {
        $this->erro_sql = " Campo aplicação nao Informado.";
        $this->erro_campo = "t54_aplicacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t54_limites_confrontacoes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t54_limites_confrontacoes"])) {
      $sql  .= $virgula . " t54_limites_confrontacoes = '$this->t54_limites_confrontacoes' ";
      $virgula = ",";
      if (trim($this->t54_limites_confrontacoes) == null) {
        $this->erro_sql = " Campo Limites e Confrontações nao Informado.";
        $this->erro_campo = "t54_limites_confrontacoes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t54_obs) == "") {
      $this->t54_obs = 'null';
      $sql  .= $virgula . " t54_obs = $this->t54_obs ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_obs = '$this->t54_obs' ";
      $virgula = ",";
    }

    if (trim($this->t54_prop_anterior) == "") {
      $this->t54_prop_anterior = 'null';
      $sql  .= $virgula . " t54_prop_anterior = $this->t54_prop_anterior ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_prop_anterior = '$this->t54_prop_anterior' ";
      $virgula = ",";
    }


    if (trim($this->t54_cpfcnpj) == "") {
      $this->t54_cpfcnpj = 'null';
      $sql  .= $virgula . " t54_cpfcnpj = $this->t54_cpfcnpj ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_cpfcnpj = $this->t54_cpfcnpj ";
      $virgula = ",";
    }

    if (trim($this->t54_cartorio_tc) == "") {
      $this->t54_cartorio_tc = 'null';
      $sql  .= $virgula . " t54_cartorio_tc = $this->t54_cartorio_tc ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_cartorio_tc = '$this->t54_cartorio_tc' ";
      $virgula = ",";
    }


    if (trim($this->t54_comarca_tc) == "") {
      $this->t54_comarca_tc = 'null';
      $sql  .= $virgula . " t54_comarca_tc = $this->t54_comarca_tc ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_comarca_tc = '$this->t54_comarca_tc' ";
      $virgula = ",";
    }


    if (trim($this->t54_registro_tc) == "") {
      $this->t54_registro_tc = 'null';
      $sql  .= $virgula . " t54_registro_tc = $this->t54_registro_tc ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_registro_tc = $this->t54_registro_tc ";
      $virgula = ",";
    }


    if (trim($this->t54_livro_tc) == "") {
      $this->t54_livro_tc = 'null';
      $sql  .= $virgula . " t54_livro_tc = $this->t54_livro_tc ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_livro_tc = '$this->t54_livro_tc' ";
      $virgula = ",";
    }

    if (trim($this->t54_data_tc) == "") {
      $this->t54_data_tc = 'null';
      $sql  .= $virgula . " t54_data_tc = $this->t54_data_tc ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_data_tc = '$this->t54_data_tc' ";
      $virgula = ",";
    }

    if (trim($this->t54_cartorio_tp) == "") {
      $this->t54_cartorio_tp = 'null';
      $sql  .= $virgula . " t54_cartorio_tp = $this->t54_cartorio_tp ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_cartorio_tp = '$this->t54_cartorio_tp' ";
      $virgula = ",";
    }

    if (trim($this->t54_tabeliao_tp) == "") {
      $this->t54_tabeliao_tp = 'null';
      $sql  .= $virgula . " t54_tabeliao_tp = $this->t54_tabeliao_tp ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_tabeliao_tp = '$this->t54_tabeliao_tp' ";
      $virgula = ",";
    }

    if (trim($this->t54_livro_tp) == "") {
      $this->t54_livro_tp = 'null';
      $sql  .= $virgula . " t54_livro_tp = $this->t54_livro_tp ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_livro_tp = '$this->t54_livro_tp' ";
      $virgula = ",";
    }


    if (trim($this->t54_idbql) == "") {
      $this->t54_idbql = 'null';
      $sql  .= $virgula . " t54_idbql = $this->t54_idbql ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_idbql = $this->t54_idbql ";
      $virgula = ",";
    }


    if (trim($this->t54_folha_tp) == "") {
      $this->t54_folha_tp = 'null';
      $sql  .= $virgula . " t54_folha_tp = $this->t54_folha_tp ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_folha_tp = $this->t54_folha_tp ";
      $virgula = ",";
    }

    if (trim($this->t54_data_tp) == "") {
      $this->t54_data_tp = 'null';
      $sql  .= $virgula . " t54_data_tp = $this->t54_data_tp ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_data_tp = '$this->t54_data_tp' ";
      $virgula = ",";
    }

    if (trim($this->t54_escritura_tp) == "") {
      $this->t54_escritura_tp = 'null';
      $sql  .= $virgula . " t54_escritura_tp = $this->t54_escritura_tp ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_escritura_tp = '$this->t54_escritura_tp' ";
      $virgula = ",";
    }

    if (trim($this->t54_carta_tp) == "") {
      $this->t54_carta_tp = 'null';
      $sql  .= $virgula . " t54_carta_tp = $this->t54_carta_tp ";
      $virgula = ",";
    } else {
      $sql  .= $virgula . " t54_carta_tp = '$this->t54_carta_tp' ";
      $virgula = ",";
    }



    $sql .= " where ";
    if ($t54_codbem != null) {
      $sql .= " t54_codbem = $this->t54_codbem";
    }
    /*
    if ($t54_idbql != null) {
      $sql .= " and  t54_idbql = $this->t54_idbql";
    }
    */
    $resaco = $this->sql_record($this->sql_query_file($this->t54_codbem, $this->t54_idbql));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,5781,'$this->t54_codbem','A')");
        $resac = db_query("insert into db_acountkey values($acount,5782,'$this->t54_idbql','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["t54_codbem"]))
          $resac = db_query("insert into db_acount values($acount,916,5781,'" . AddSlashes(pg_result($resaco, $conresaco, 't54_codbem')) . "','$this->t54_codbem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["t54_idbql"]))
          $resac = db_query("insert into db_acount values($acount,916,5782,'" . AddSlashes(pg_result($resaco, $conresaco, 't54_idbql')) . "','$this->t54_idbql'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["t54_obs"]))
          $resac = db_query("insert into db_acount values($acount,916,5783,'" . AddSlashes(pg_result($resaco, $conresaco, 't54_obs')) . "','$this->t54_obs'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Bens imóveis nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->t54_codbem . "-" . $this->t54_idbql;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Bens imóveis nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->t54_codbem;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->t54_codbem;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir($t54_codbem = null, $t54_idbql = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($t54_codbem, $t54_idbql));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,5781,'$t54_codbem','E')");
        $resac = db_query("insert into db_acountkey values($acount,5782,'$t54_idbql','E')");
        $resac = db_query("insert into db_acount values($acount,916,5781,'','" . AddSlashes(pg_result($resaco, $iresaco, 't54_codbem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,916,5782,'','" . AddSlashes(pg_result($resaco, $iresaco, 't54_idbql')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,916,5783,'','" . AddSlashes(pg_result($resaco, $iresaco, 't54_obs')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from bensimoveis
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($t54_codbem != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " t54_codbem = $t54_codbem ";
      }
      if ($t54_idbql != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " t54_idbql = $t54_idbql ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Bens imóveis nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $t54_codbem . "-" . $t54_idbql;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Bens imóveis nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $t54_codbem . "-" . $t54_idbql;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $t54_codbem . "-" . $t54_idbql;
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
      $this->erro_sql   = "Record Vazio na Tabela:bensimoveis";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  function sql_query($t54_codbem = null, $t54_idbql = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from bensimoveis ";
    $sql .= "      inner join lote  on  lote.j34_idbql = bensimoveis.t54_idbql";
    $sql .= "      inner join bens  on  bens.t52_bem = bensimoveis.t54_codbem";
    $sql .= "      inner join bairro  on  bairro.j13_codi = lote.j34_bairro";
    $sql .= "      inner join setor  on  setor.j30_codi = lote.j34_setor";
    $sql .= "      inner join cgm  on  cgm.z01_numcgm = bens.t52_numcgm";
    $sql .= "      inner join db_depart  on  db_depart.coddepto = bens.t52_depart";
    $sql .= "      inner join clabens  on  clabens.t64_codcla = bens.t52_codcla";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($t54_codbem != null) {
        $sql2 .= " where bensimoveis.t54_codbem = $t54_codbem ";
      }
      if ($t54_idbql != null) {
        if ($sql2 != "") {
          $sql2 .= " and ";
        } else {
          $sql2 .= " where ";
        }
        $sql2 .= " bensimoveis.t54_idbql = $t54_idbql ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }
  function sql_query_file($t54_codbem = null, $t54_idbql = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from bensimoveis ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($t54_codbem != null) {
        $sql2 .= " where bensimoveis.t54_codbem = $t54_codbem ";
      }
      /*
      if ($t54_idbql != null) {
        if ($sql2 != "") {
          $sql2 .= " and ";
        } else {
          $sql2 .= " where ";
        }
        $sql2 .= " bensimoveis.t54_idbql = $t54_idbql ";
      }
      */
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }
}
