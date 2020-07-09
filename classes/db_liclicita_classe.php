<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

//MODULO: licitacao
//CLASSE DA ENTIDADE liclicita
class cl_liclicita
{
    // cria variaveis de erro
    var $rotulo = null;
    var $query_sql = null;
    var $numrows = 0;
    var $numrows_incluir = 0;
    var $numrows_alterar = 0;
    var $numrows_excluir = 0;
    var $erro_status = null;
    var $erro_sql = null;
    var $erro_banco = null;
    var $erro_msg = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $l20_codigo = 0;
    var $l20_codtipocom = 0;
    var $l20_numero = 0;
    var $l20_id_usucria = 0;
    var $l20_datacria_dia = null;
    var $l20_datacria_mes = null;
    var $l20_datacria_ano = null;
    var $l20_datacria = null;
    var $l20_horacria = null;
    var $l20_dataaber_dia = null;
    var $l20_dataaber_mes = null;
    var $l20_dataaber_ano = null;
    var $l20_dataaber = null;
    var $l20_dtpublic_dia = null;
    var $l20_dtpublic_mes = null;
    var $l20_dtpublic_ano = null;
    var $l20_dtpublic = null;
    var $l20_horaaber = null;
    var $l20_local = null;
    var $l20_objeto = null;
    var $l20_tipojulg = null;
    var $l20_liccomissao = null;
    var $l20_liclocal = null;
    var $l20_procadmin = null;
    var $l20_correto = 'f';
    var $l20_instit = null;
    var $l20_licsituacao = null;
    var $l20_edital = null;
    var $l20_anousu = null;
    var $l20_usaregistropreco = 'f';
    var $l20_localentrega = null;
    var $l20_prazoentrega = null;
    var $l20_condicoespag = null;
    var $l20_validadeproposta = null;
    var $l20_razao = null;
    var $l20_formacontroleregistropreco = 0;
    var $l20_justificativa = null;
    var $l20_aceitabilidade = null;
    var $l20_equipepregao = null;
    var $l20_nomeveiculo2 = null;
    var $l20_datapublicacao2_dia = null;
    var $l20_datapublicacao2_mes = null;
    var $l20_datapublicacao2_ano = null;
    var $l20_datapublicacao2 = null;
    var $l20_nomeveiculo1 = null;
    var $l20_datapublicacao1_dia = null;
    var $l20_datapublicacao1_mes = null;
    var $l20_datapublicacao1_ano = null;
    var $l20_datapublicacao1 = null;
    var $l20_datadiario_dia = null;
    var $l20_datadiario_mes = null;
    var $l20_datadiario_ano = null;
    var $l20_datadiario = null;
    var $l20_recdocumentacao_dia = null;
    var $l20_recdocumentacao_mes = null;
    var $l20_recdocumentacao_ano = null;
    var $l20_recdocumentacao = null;
    var $l20_numeroconvidado = null;
    var $l20_descontotab = null;
    var $l20_regimexecucao = null;
    var $l20_naturezaobjeto = null;
    var $l20_tipliticacao = null;
    var $l20_tipnaturezaproced = null;
    var $l20_dtpubratificacao_dia = null;
    var $l20_dtpubratificacao_mes = null;
    var $l20_dtpubratificacao_ano = null;
    var $l20_dtpubratificacao = null;
    var $l20_dtlimitecredenciamento = null;
    var $l20_critdesempate = null;
    var $l20_destexclusiva = null;
    var $l20_subcontratacao = null;
    var $l20_limitcontratacao = null;
    var $l20_tipoprocesso = null;
    var $l20_regata = null;
    var $l20_interporrecurso = null;
    var $l20_descrinterporrecurso = null;
    var $l20_veicdivulgacao = null;
    var $l20_clausulapro = null;
    var $l20_codepartamento = null;
    var $l20_diames = null;
    var $l20_execucaoentrega = null;
    var $l20_criterioadjudicacao = null;
    var $l20_nroedital = null;
    var $l20_exercicioedital = null;
    /* Valor 1 para cadastro inicial da Licitação - demanda para atender o SICOM 2020 */
    var $l20_cadinicial = null;


    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 l20_codigo = int8 = Sequencial
                 l20_codtipocom = int4 = Código do tipo de compra
                 l20_numero = int8 = Numeração
                 l20_id_usucria = int4 = Cod. Usuário
                 l20_datacria = date = Data Criação
                 l20_horacria = char(5) = Hora Criação
                 l20_dataaber = date = Data Edital/Convite
                 l20_dtpublic = date = Data Publicação
                 l20_horaaber = char(5) = Hora Abertura
                 l20_local = text = Local da Licitação
                 l20_objeto = text = Objeto
                 l20_tipojulg = int4 = Tipo de Julgamento
                 l20_liccomissao = int4 = Código da Comissão
                 l20_liclocal = int4 = Código do Local da Licitação
                 l20_procadmin = varchar(50) = Processo Administrativo
                 l20_correto = bool = Correto
                 l20_instit = int4 = Instituição
                 l20_licsituacao = int4 = Situação da Licitação
                 l20_edital = int8 = Licitacao
                 l20_anousu = int4 = Exercício
                 l20_usaregistropreco = bool = Registro Preço
                 l20_localentrega = text = Local de Entrega
                 l20_prazoentrega = text = Prazo Entrega
                 l20_condicoespag = text = Forma  de Pagamento
                 l20_validadeproposta = text = Validade da Proposta
                 l20_razao = text = Razão
                 l20_formacontroleregistropreco = int4 = Forma de Controle RP
                 l20_justificativa = int8 = Justificativa
                 l20_aceitabilidade = text = Citério de Aceitabilidade
                 l20_equipepregao = int8 = Equipe Pregão
                 l20_nomeveiculo2 = varchar(50) = Nome Veículo Divulgação 2
                 l20_datapublicacao2 = date = Data Publicação Edital Veiculo 2
                 l20_nomeveiculo1 = varchar(50) = Nome Veículo Divulgação 1
                 l20_datapublicacao1 = date = Data Publicação Edital Veiculo 1
                 l20_datadiario = date = Data de Publicação em Diário Oficial
                 l20_recdocumentacao = date = Recebimento Documentação
                 l20_numeroconvidado = int8 = Número de convidados
                 l20_descontotab = int8 = Desconto Tabela
                 l20_regimexecucao = int8 = Regime da Execução
                 l20_naturezaobjeto = int8 = Natureza do Objeto
                 l20_tipliticacao = int8 = Tipo da Licitação
                 l20_tipnaturezaproced = int8 = Natureza do Procedimento
                 l20_dtpubratificacao = date= Data Publicação Termo Ratificação
                 l20_dtlimitecredenciamento = date = Data limite para credenciamento
                 l20_critdesempate = int8= Critério de Desempate
                 l20_destexclusiva = int8= Destinação Exclusiva
                 l20_subcontratacao = int8= Sub. Contratação
                 l20_limitcontratacao = int8= Limite Contratação
                 l20_tipoprocesso = int8= Tipo  de processo
                 l20_regata = int8 = Registrado Presença em Ata
                 l20_interporrecurso = Interpor Recurso
                 l20_descrinterporrecurso = Descrição
                 l20_veicdivulgacao= Veiculo de Divulgaçao
                 l20_clausulapro= text = Prorrogacao
                 l20_codepartamento=int8= Codigo departamento
                 l20_diames=int8= Dia mes
                 l20_execucaoentrega=int8= Execucao da entrega
                 l20_criterioadjudicacao = int4 = Criterio de adjudicacao
                 l20_nroedital = int8 = Número Edital Licitação
                 l20_cadinicial = int8 = Identificador cadastro inicial
                 l20_exercicioedital = int8 = Exercício do Edital
                 ";

    //funcao construtor da classe
    function cl_liclicita()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("liclicita");
        $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
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
            $this->l20_codigo = ($this->l20_codigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_codigo"] : $this->l20_codigo);
            $this->l20_codtipocom = ($this->l20_codtipocom == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_codtipocom"] : $this->l20_codtipocom);
            $this->l20_numero = ($this->l20_numero == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_numero"] : $this->l20_numero);
            $this->l20_id_usucria = ($this->l20_id_usucria == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_id_usucria"] : $this->l20_id_usucria);
            if ($this->l20_datacria == "") {
                $this->l20_datacria_dia = ($this->l20_datacria_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datacria_dia"] : $this->l20_datacria_dia);
                $this->l20_datacria_mes = ($this->l20_datacria_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datacria_mes"] : $this->l20_datacria_mes);
                $this->l20_datacria_ano = ($this->l20_datacria_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datacria_ano"] : $this->l20_datacria_ano);
                if ($this->l20_datacria_dia != "") {
                    $this->l20_datacria = $this->l20_datacria_ano . "-" . $this->l20_datacria_mes . "-" . $this->l20_datacria_dia;
                }
            }
            $this->l20_horacria = ($this->l20_horacria == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_horacria"] : $this->l20_horacria);
            if ($this->l20_dataaber == "") {
                $this->l20_dataaber_dia = ($this->l20_dataaber_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dataaber_dia"] : $this->l20_dataaber_dia);
                $this->l20_dataaber_mes = ($this->l20_dataaber_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dataaber_mes"] : $this->l20_dataaber_mes);
                $this->l20_dataaber_ano = ($this->l20_dataaber_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dataaber_ano"] : $this->l20_dataaber_ano);
                if ($this->l20_dataaber_dia != "") {
                    $this->l20_dataaber = $this->l20_dataaber_ano . "-" . $this->l20_dataaber_mes . "-" . $this->l20_dataaber_dia;
                }
            }
            if ($this->l20_dtpublic == "") {
                $this->l20_dtpublic_dia = ($this->l20_dtpublic_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dtpublic_dia"] : $this->l20_dtpublic_dia);
                $this->l20_dtpublic_mes = ($this->l20_dtpublic_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dtpublic_mes"] : $this->l20_dtpublic_mes);
                $this->l20_dtpublic_ano = ($this->l20_dtpublic_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dtpublic_ano"] : $this->l20_dtpublic_ano);
                if ($this->l20_dtpublic_dia != "") {
                    $this->l20_dtpublic = $this->l20_dtpublic_ano . "-" . $this->l20_dtpublic_mes . "-" . $this->l20_dtpublic_dia;
                }
            }

            if ($this->l20_dtpubratificacao == "") {
                $this->l20_dtpubratificacao_dia = ($this->l20_dtpubratificacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dtpubratificacao_dia"] : $this->l20_dtpubratificacao_dia);
                $this->l20_dtpubratificacao_mes = ($this->l20_dtpubratificacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dtpubratificacao_mes"] : $this->l20_dtpubratificacao_mes);
                $this->l20_dtpubratificacao_ano = ($this->l20_dtpubratificacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_dtpubratificacao_ano"] : $this->l20_dtpubratificacao_ano);
                if ($this->l20_dtpubratificacao_dia != "") {
                    $this->l20_dtpubratificacao = $this->l20_dtpubratificacao_ano . "-" . $this->l20_dtpubratificacao_mes . "-" . $this->l20_dtpubratificacao_dia;
                }
            }


            $this->l20_horaaber = ($this->l20_horaaber == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_horaaber"] : $this->l20_horaaber);
            $this->l20_local = ($this->l20_local == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_local"] : $this->l20_local);
            $this->l20_objeto = ($this->l20_objeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_objeto"] : $this->l20_objeto);
            $this->l20_tipojulg = ($this->l20_tipojulg == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_tipojulg"] : $this->l20_tipojulg);
            $this->l20_liccomissao = ($this->l20_liccomissao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_liccomissao"] : $this->l20_liccomissao);
            $this->l20_liclocal = ($this->l20_liclocal == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_liclocal"] : $this->l20_liclocal);
            $this->l20_procadmin = ($this->l20_procadmin == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_procadmin"] : $this->l20_procadmin);
            $this->l20_correto = ($this->l20_correto == "f" ? @$GLOBALS["HTTP_POST_VARS"]["l20_correto"] : $this->l20_correto);
            $this->l20_instit = ($this->l20_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_instit"] : $this->l20_instit);
            $this->l20_licsituacao = ($this->l20_licsituacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_licsituacao"] : $this->l20_licsituacao);
            $this->l20_edital = ($this->l20_edital == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_edital"] : $this->l20_edital);
            $this->l20_anousu = ($this->l20_anousu == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_anousu"] : $this->l20_anousu);
            $this->l20_usaregistropreco = ($this->l20_usaregistropreco == "f" ? @$GLOBALS["HTTP_POST_VARS"]["l20_usaregistropreco"] : $this->l20_usaregistropreco);
            $this->l20_localentrega = ($this->l20_localentrega == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_localentrega"] : $this->l20_localentrega);
            $this->l20_prazoentrega = ($this->l20_prazoentrega == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_prazoentrega"] : $this->l20_prazoentrega);
            $this->l20_condicoespag = ($this->l20_condicoespag == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_condicoespag"] : $this->l20_condicoespag);
            $this->l20_validadeproposta = ($this->l20_validadeproposta == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_validadeproposta"] : $this->l20_validadeproposta);
            $this->l20_razao = ($this->l20_razao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_razao"] : $this->l20_razao);
            $this->l20_formacontroleregistropreco = ($this->l20_formacontroleregistropreco == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_formacontroleregistropreco"] : $this->l20_formacontroleregistropreco);
            $this->l20_justificativa = ($this->l20_justificativa == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_justificativa"] : $this->l20_justificativa);
            $this->l20_aceitabilidade = ($this->l20_aceitabilidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_aceitabilidade"] : $this->l20_aceitabilidade);
            $this->l20_equipepregao = ($this->l20_equipepregao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_equipepregao"] : $this->l20_equipepregao);
            $this->l20_nomeveiculo2 = ($this->l20_nomeveiculo2 == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_nomeveiculo2"] : $this->l20_nomeveiculo2);
            if ($this->l20_datapublicacao2 == "") {
                $this->l20_datapublicacao2_dia = ($this->l20_datapublicacao2_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao2_dia"] : $this->l20_datapublicacao2_dia);
                $this->l20_datapublicacao2_mes = ($this->l20_datapublicacao2_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao2_mes"] : $this->l20_datapublicacao2_mes);
                $this->l20_datapublicacao2_ano = ($this->l20_datapublicacao2_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao2_ano"] : $this->l20_datapublicacao2_ano);
                if ($this->l20_datapublicacao2_dia != "") {
                    $this->l20_datapublicacao2 = $this->l20_datapublicacao2_ano . "-" . $this->l20_datapublicacao2_mes . "-" . $this->l20_datapublicacao2_dia;
                }
            }
            $this->l20_nomeveiculo1 = ($this->l20_nomeveiculo1 == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_nomeveiculo1"] : $this->l20_nomeveiculo1);
            if ($this->l20_datapublicacao1 == "") {
                $this->l20_datapublicacao1_dia = ($this->l20_datapublicacao1_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao1_dia"] : $this->l20_datapublicacao1_dia);
                $this->l20_datapublicacao1_mes = ($this->l20_datapublicacao1_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao1_mes"] : $this->l20_datapublicacao1_mes);
                $this->l20_datapublicacao1_ano = ($this->l20_datapublicacao1_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao1_ano"] : $this->l20_datapublicacao1_ano);
                if ($this->l20_datapublicacao1_dia != "") {
                    $this->l20_datapublicacao1 = $this->l20_datapublicacao1_ano . "-" . $this->l20_datapublicacao1_mes . "-" . $this->l20_datapublicacao1_dia;
                }
            }
            if ($this->l20_datadiario == "") {
                $this->l20_datadiario_dia = ($this->l20_datadiario_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datadiario_dia"] : $this->l20_datadiario_dia);
                $this->l20_datadiario_mes = ($this->l20_datadiario_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datadiario_mes"] : $this->l20_datadiario_mes);
                $this->l20_datadiario_ano = ($this->l20_datadiario_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_datadiario_ano"] : $this->l20_datadiario_ano);
                if ($this->l20_datadiario_dia != "") {
                    $this->l20_datadiario = $this->l20_datadiario_ano . "-" . $this->l20_datadiario_mes . "-" . $this->l20_datadiario_dia;
                }
            }
            if ($this->l20_recdocumentacao == "") {
                $this->l20_recdocumentacao_dia = ($this->l20_recdocumentacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_recdocumentacao_dia"] : $this->l20_recdocumentacao_dia);
                $this->l20_recdocumentacao_mes = ($this->l20_recdocumentacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_recdocumentacao_mes"] : $this->l20_recdocumentacao_mes);
                $this->l20_recdocumentacao_ano = ($this->l20_recdocumentacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_recdocumentacao_ano"] : $this->l20_recdocumentacao_ano);
                if ($this->l20_recdocumentacao_dia != "") {
                    $this->l20_recdocumentacao = $this->l20_recdocumentacao_ano . "-" . $this->l20_recdocumentacao_mes . "-" . $this->l20_recdocumentacao_dia;
                }
            }

            $this->l20_numeroconvidado = ($this->l20_numeroconvidado == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_numeroconvidado"] : $this->l20_numeroconvidado);
            $this->l20_descontotab = ($this->l20_descontotab == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_descontotab"] : $this->l20_descontotab);
            $this->l20_regimexecucao = ($this->l20_regimexecucao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_regimexecucao"] : $this->l20_regimexecucao);
            $this->l20_naturezaobjeto = ($this->l20_naturezaobjeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_naturezaobjeto"] : $this->l20_naturezaobjeto);
            $this->l20_tipliticacao = ($this->l20_tipliticacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_tipliticacao"] : $this->l20_tipliticacao);
            $this->l20_tipnaturezaproced = ($this->l20_tipnaturezaproced == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_tipnaturezaproced"] : $this->l20_tipnaturezaproced);

            $this->l20_critdesempate = ($this->l20_critdesempate == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_critdesempate"] : $this->l20_critdesempate);
            $this->l20_destexclusiva = ($this->l20_destexclusiva == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_destexclusiva"] : $this->l20_destexclusiva);
            $this->l20_subcontratacao = ($this->l20_subcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_subcontratacao"] : $this->l20_subcontratacao);
            $this->l20_limitcontratacao = ($this->l20_limitcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_limitcontratacao"] : $this->l20_limitcontratacao);
            $this->l20_tipoprocesso = ($this->l20_tipoprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_tipoprocesso"] : $this->l20_tipoprocesso);
            $this->l20_regata = ($this->l20_regata == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_regata"] : $this->l20_regata);
            $this->l20_interporrecurso = ($this->l20_interporrecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_interporrecurso"] : $this->l20_interporrecurso);
            $this->l20_descrinterporrecurso = ($this->l20_descrinterporrecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_descrinterporrecurso"] : $this->l20_descrinterporrecurso);
            $this->l20_veicdivulgacao = ($this->l20_veicdivulgacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_veicdivulgacao"] : $this->l20_veicdivulgacao);

            $this->l20_clausulapro = ($this->l20_clausulapro == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_clausulapro"] : $this->l20_clausulapro);
            $this->l20_codepartamento = ($this->l20_codepartamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_codepartamento"] : $this->l20_codepartamento);
            $this->l20_diames = ($this->l20_diames == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_diames"] : $this->l20_diames);
            $this->l20_execucaoentrega = ($this->l20_execucaoentrega == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_execucaoentrega"] : $this->l20_execucaoentrega);
            $this->l20_nroedital = ($this->l20_nroedital == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_nroedital"] : $this->l20_nroedital);
            $this->l20_cadinicial = ($this->l20_cadinicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_cadinicial"] : $this->l20_cadinicial);
            $this->l20_exercicioedital = ($this->l20_exercicioedital == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_exercicioedital"] : $this->l20_exercicioedital);

        } else {
            $this->l20_codigo = ($this->l20_codigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l20_codigo"] : $this->l20_codigo);
        }
    }

    // funcao para inclusao aqui
    function incluir($l20_codigo, $convite)
    {
        $this->atualizacampos();

        $tribunal = $this->buscartribunal($this->l20_codtipocom);

        if ($tribunal == 48 && ($this->l20_numeroconvidado == "" || $this->l20_numeroconvidado == null)) {
            $this->erro_sql = "Você informou o tipo de modalidade  CONVITE. Para esta modalidade é \\n\\n obrigatorio preencher o campo Numero Convidado";
            $this->erro_campo = "l20_numeroconvidado";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

//        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
//            if ($this->l20_dtpubratificacao == null) {
//                $this->erro_sql = "Você informou um tipo de 'INEXIGIBILIDADE ou Dispensa de Licitacao'. Para este tipo é  \\n\\n obrigatorio preencher a  Data Publicação Termo Ratificação";
//                $this->erro_campo = "l20_dtpubratificacao";
//                $this->erro_banco = "";
//                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
//                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
//                $this->erro_status = "0";
//                return false;
//            }
//        }


        if ($this->l20_condicoespag == null || $this->l20_condicoespag == "") {
            $this->erro_sql = " Campo condicoes de pagamento nao Informado.";
            $this->erro_campo = "l20_condicoespag";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }


        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
            if ($this->l20_razao == null || $this->l20_razao == "") {
                $this->erro_sql = " Você marcou  um tipo de modalidade  que obriga o preenchimento dos dados: Tipo de Processo,Justificativa e Razão";
                $this->erro_campo = "l20_razao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

//        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
//            if ($this->l20_dtpubratificacao == null || $this->l20_dtpubratificacao == "") {
//                $this->erro_sql = " Você marcou  um tipo de modalidade  que obriga o preenchimento dos dados: Tipo de Processo,Justificativa e Razão";
//                $this->erro_campo = "l20_dtpubratificacao";
//                $this->erro_banco = "";
//                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
//                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
//                $this->erro_status = "0";
//                return false;
//            }
//        }

        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
            if ($this->l20_tipoprocesso == null || $this->l20_tipoprocesso == "" || $this->l20_tipoprocesso == 0) {
                $this->erro_sql = " Você marcou  um tipo de modalidade  que obriga o preenchimento dos dados: Tipo de Processo";
                $this->erro_campo = "l20_tipoprocesso";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            $this->l20_tipoprocesso = 0;
        }

//        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
//            if (trim($this->l20_veicdivulgacao) == null || (strlen($this->l20_veicdivulgacao) < 5 || strlen($this->l20_veicdivulgacao) > 50)) {
//                $this->erro_sql = "Usuário: \\n\\n O campo veiculo de divulgação deve ter no mínimo 5 caracteres e no máximo 50 \\n\\n";
//                $this->erro_campo = "l20_veicdivulgacao";
//                $this->erro_banco = "";
//                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
//                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
//                $this->erro_status = "0";
//                return false;
//            }
//        }

        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {

            if (strlen($this->l20_justificativa) < 10 || strlen($this->l20_justificativa) > 250) {
                $this->erro_msg = "Usuário: \\n\\n O campo Justificativa deve ter no mínimo 10 caracteres e no máximo 250 \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }

            if (trim($this->l20_justificativa) == null) {
                $this->erro_sql = "Você informou um tipo de 'INEXIGIBILIDADE'. Para este tipo é  \\n\\n obrigatorio preencher os campos: Justificativa";
                $this->erro_campo = "l20_justificativa";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {

            if (trim($this->l20_razao) == null || (strlen($this->l20_razao) < 10 || strlen($this->l20_razao) > 250)) {
                $this->erro_sql = "Usuário: \\n\\n O campo Razão deve ter no mínimo 10 caracteres e no máximo 250 \\n\\n";
                $this->erro_campo = "l20_razao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if ($this->l20_numero == null) {
            $this->erro_sql = " Campo Numeração nao Informado.";
            $this->erro_campo = "l20_numero";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_id_usucria == null) {
            $this->erro_sql = " Campo Cod. Usuário nao Informado.";
            $this->erro_campo = "l20_id_usucria";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_datacria == null) {
            $this->erro_sql = " Campo Data Criação nao Informado.";
            $this->erro_campo = "l20_datacria";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_horacria == null) {
            $this->erro_sql = " Campo Hora Criação nao Informado.";
            $this->erro_campo = "l20_horacria";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_horaaber == null) {
            $this->l20_horaaber = $this->l20_horacria;
        }
        // validacao sicom
        if ($this->l20_dtpublic != null) {
            // aqui
            if ($this->l20_dtpublic < $this->l20_datacria) {
                //  A data da publicacao em diario oficial nao deve ser superior  ou igual a data de criacao.
                $this->erro_sql = " A Data da Publicação em Edital Veiculo 1 deve ser anterior a Data de Recebimento da Documentação";
                $this->erro_campo = "l20_datapublicacao1";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if ($this->l20_datapublicacao2 != null) {
            if ($this->l20_datapublicacao2 > $this->l20_recdocumentacao) {
                //  A data da publicacao em diario oficial nao deve ser superior  ou igual a data de criacao.
                $this->erro_sql = " A Data da Publicação em Edital Veiculo 2 deve ser anterior a Data de Recebimento da Documentação";
                $this->erro_campo = "l20_datapublicacao2";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if ($this->l20_datapublicacao1 != null) {
            if ($this->l20_datacria > $this->l20_datapublicacao1) {

                $this->erro_sql = " A data da publicação em Edital Veiculo 1 deve ser superior  ou igual a data de criação.";
                $this->erro_campo = "l20_datapublicacao1";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if ($this->l20_datapublicacao2 != null) {
            if ($this->l20_datacria > $this->l20_datapublicacao2) {

                $this->erro_sql = " A data da publicação em Edital Veiculo 2 deve ser superior ou igual a data de criação.";
                $this->erro_campo = "l20_datapublicacao2";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        //alterado
        if ($this->l20_recdocumentacao != null) {
            if ($tribunal != 50) {
                if ($this->l20_recdocumentacao < $this->l20_dataaber && $this->l20_codtipocom != 16) {

                    $this->erro_sql = " A data informada no campo  Recebimento Documentação deve ser  superior a   Data Edital/Convite.";
                    $this->erro_campo = "l20_recdocumentacao";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        if ($this->l20_datacria != null && $this->l20_dataaber != null) {
            if ($this->l20_datacria > $this->l20_dataaber) {
                $this->erro_sql = "A data inserida no campo 'Data Emis/Alt Edital/Convite' deverá ser maior ou igual a data inserida no campo 'Data Abertura Proc. Adm.'.";
                $this->erro_campo = "l20_dataaber";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if ($this->l20_dataaber == null and $tribunal != 100 and $tribunal != 101 and $tribunal != 102 and $tribunal != 103) {
            $this->erro_sql = " Campo Data Edital/Convite não Informado.";
            $this->erro_campo = "l20_dataaber";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_objeto == null) {
            $this->erro_sql = " Campo Objeto não Informado.";
            $this->erro_campo = "l20_objeto";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {

            if (strlen($this->l20_objeto) < 15 and strlen($this->l20_objeto) > 500) {
                $this->erro_msg = "Usuário: \\n\\n O campo Objeto deve ter no mínimo 15 caracteres e no máximo 500 \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }

        }
        if ($this->l20_tipojulg == null) {
            $this->erro_sql = " Campo Tipo de Julgamento não Informado.";
            $this->erro_campo = "l20_tipojulg";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_liclocal == null) {
            $this->erro_sql = " Campo Código do Local da Licitação não Informado.";
            $this->erro_campo = "l20_liclocal";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_procadmin == null) {
            $this->l20_procadmin = "";
        }
        if ($this->l20_correto == null) {
            $this->erro_sql = " Campo Correto não Informado.";
            $this->erro_campo = "l20_correto";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_instit == null) {
            $this->erro_sql = " Campo Instituição não Informado.";
            $this->erro_campo = "l20_instit";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_licsituacao == null) {
            $this->erro_sql = " Campo Situação da Licitação não Informado.";
            $this->erro_campo = "l20_licsituacao";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_edital == null) {
            $this->erro_sql = " Campo Licitacao não Informado.";
            $this->erro_campo = "l20_edital";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_nroedital == null) {
            if (in_array($tribunal, array(48, 49, 50, 52, 53, 54)) && db_getsession('DB_anousu') >= 2020) {
                $this->erro_sql = " Campo Numero Edital não Informado.";
                $this->erro_campo = "l20_nroedital";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->l20_nroedital = 'null';
            }
        }
        if ($this->l20_anousu == null) {
            $this->erro_sql = " Campo Exercício não Informado.";
            $this->erro_campo = "l20_anousu";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_usaregistropreco == null) {
            $this->erro_sql = " Campo Registro Preço não Informado.";
            $this->erro_campo = "l20_usaregistropreco";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($tribunal != 100 and $tribunal != 101 and $tribunal != 102 and $tribunal != 103) {
            if ($this->l20_equipepregao == null) {
                $this->erro_sql = " Campo Comissão de Licitação não Informado!";
                $this->erro_campo = "l20_equipepregao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if ($this->l20_numeroconvidado == null) {
            $this->l20_numeroconvidado = 'null';
        }

        if ($this->l20_datapublicacao1 == null) {
            $this->l20_datapublicacao1 = 'null';
        } else {
            $this->l20_datapublicacao1 = "'$this->l20_datapublicacao1'";
        }
        if ($this->l20_datapublicacao2 == null) {
            $this->l20_datapublicacao2 = 'null';
        } else {
            $this->l20_datapublicacao2 = "'$this->l20_datapublicacao2'";
        }
        if ($this->l20_dtpublic == null and $tribunal != 100 and $tribunal != 101 and $tribunal != 102 and $tribunal != 103) {
            $this->erro_sql = " Campo Data de Publicação em Diário Oficial não Informado.";
            $this->erro_campo = "l20_dtpublic";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_recdocumentacao == null and $tribunal != 100 and $tribunal != 101 and $tribunal != 102 and $tribunal != 103) {
            $this->erro_sql = " Campo Recebimento Documentação não Informado.";
            $this->erro_campo = "l20_recdocumentacao";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_numeroconvidado == null) {
            $this->l20_numeroconvidado = 'null';
        }
        /*if ($this->l20_descontotab == null) {
            $this->erro_sql = " Campo Desconto Tabela não Informado.";
            $this->erro_campo = "l20_descontotab";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }*/

        if ($this->l20_naturezaobjeto == null) {
            $this->erro_sql = " Campo Natureza do Objeto não Informado.";
            $this->erro_campo = "l20_naturezaobjeto";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_naturezaobjeto == '1' || $this->l20_naturezaobjeto == 1) {
            if ($this->l20_regimexecucao == 0 || $this->l20_regimexecucao == "0") {
                $this->erro_sql = " Campo Regime da Execução não Informado.";
                $this->erro_campo = "l20_regimexecucao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            $this->l20_regimexecucao = 'NULL';// aqui
        }

        if ($this->l20_prazoentrega == null) {
            $this->erro_sql = " Campo Prazo de entrega não Informado.";
            $this->erro_campo = "l20_prazoentrega";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_tipnaturezaproced == null) {
            $this->erro_sql = " Campo Tipo da Natureza do Procedimento não foi informada.";
            $this->erro_campo = "l20_tipnaturezaproced";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        /*valida combos */
        if ($this->l20_critdesempate == null) {
            $this->erro_sql = " Campo  Critério de desempate não foi informado.";
            $this->erro_campo = "l20_critdesempate";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_destexclusiva == null) {
            $this->erro_sql = " Campo Destinação Exclusiva não foi informada.";
            $this->erro_campo = "l20_destexclusiva";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_subcontratacao == null) {
            $this->erro_sql = " Campo Sub. Contratação  não foi informada.";
            $this->erro_campo = "l20_subcontratacao ";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l20_limitcontratacao == null) {
            $this->erro_sql = " Campo Limite Contratação não foi informada.";
            $this->erro_campo = "l20_limitcontratacao";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }


        if ($this->l20_execucaoentrega == null) {
            $this->erro_sql = " Campo execucao entrega não foi informado.";
            $this->erro_campo = "l20_execucaoentrega";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_codepartamento == null) {
            $this->erro_sql = " Campo codigo departamento não foi informado.";
            $this->erro_campo = "l20_codepartamento";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_diames == null) {
            $this->erro_sql = " Campo Unid.Execucao/Entrega entrega não foi informado.";
            $this->erro_campo = "l20_diames";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->l20_criterioadjudicacao == null) {
            $this->l20_criterioadjudicacao = "3";
        }

        if ($l20_codigo == "" || $l20_codigo == null) {
            $result = db_query("select nextval('liclicita_l20_codigo_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: liclicita_l20_codigo_seq do campo: l20_codigo";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l20_codigo = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from liclicita_l20_codigo_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $l20_codigo)) {
                $this->erro_sql = " Campo l20_codigo maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->l20_codigo = $l20_codigo;
            }
        }
        if (($this->l20_codigo == null) || ($this->l20_codigo == "")) {
            $this->erro_sql = " Campo l20_codigo nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }


        if ($convite != "" || $convite != null) {
            $sql = "select  l45_data from  licpregao  inner join liclicita on liclicita.l20_equipepregao=licpregao.l45_sequencial where l20_codigo= $this->l20_codigo";

            $result = db_query($sql);
            $l45_data = pg_result($result, 0, 0);
            if ($l45_data > $this->l20_datacria) {
                $this->erro_sql = " A data da equipe de pregão  não deve ser superior a data da criação .";
                $this->erro_campo = "l20_equipepregao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if(db_getsession('DB_anousu') >= 2020){
            if (!$this->l20_cadinicial) {
                $this->l20_cadinicial = 1;
            };

            if (!$this->l20_exercicioedital) {
                $this->l20_exercicioedital = db_getsession('DB_anousu');
            };
        }else{
            $this->l20_cadinicial = 'null';
            $this->l20_exercicioedital = 'null';
        }

        $sql = "insert into liclicita(
                                 l20_codigo
                ,l20_edital
                ,l20_codtipocom
                ,l20_numero
                ,l20_id_usucria
                ,l20_tipliticacao
                ,l20_naturezaobjeto
                ,l20_regimexecucao
                ,l20_numeroconvidado
                ,l20_dataaber
                ,l20_horaaber
                ,l20_datacria
                ,l20_horacria
                ,l20_dtpublic
                ,l20_recdocumentacao
                ,l20_datapublicacao1
                ,l20_nomeveiculo1
                ,l20_datapublicacao2
                ,l20_nomeveiculo2
                ,l20_tipojulg
                ,l20_procadmin
                ,l20_usaregistropreco
                ,l20_liclocal
                ,l20_liccomissao
                ,l20_equipepregao
                ,l20_local
                ,l20_objeto
                ,l20_localentrega
                ,l20_prazoentrega
                ,l20_condicoespag
                ,l20_validadeproposta
                ,l20_aceitabilidade
                ,l20_justificativa
                ,l20_razao
                ,l20_instit
                ,l20_tipnaturezaproced
                ,l20_tipoprocesso
                ,l20_critdesempate
                ,l20_destexclusiva
                ,l20_subcontratacao
                ,l20_limitcontratacao
                ,l20_veicdivulgacao
                ,l20_clausulapro
                ,l20_codepartamento
                ,l20_diames
                ,l20_execucaoentrega
                ,l20_anousu
                ,l20_dtpubratificacao
                ,l20_formacontroleregistropreco
                ,l20_criterioadjudicacao
                ,l20_dtlimitecredenciamento
                ,l20_nroedital
                ,l20_cadinicial
                ,l20_exercicioedital
                       )
                values (


                         $this->l20_codigo
                ,$this->l20_edital
                ,$this->l20_codtipocom
                ,$this->l20_numero
                ,$this->l20_id_usucria
                ,$this->l20_tipliticacao
                ,$this->l20_naturezaobjeto
                ,$this->l20_regimexecucao
                ,$this->l20_numeroconvidado
                ," . ($this->l20_dataaber == "null" || $this->l20_dataaber == "" ? "null" : "'" . $this->l20_dataaber . "'") . "
                ,'$this->l20_horaaber'
                ," . ($this->l20_datacria == "null" || $this->l20_datacria == "" ? "null" : "'" . $this->l20_datacria . "'") . "
                ,'$this->l20_horacria'
                ," . ($this->l20_dtpublic == "null" || $this->l20_dtpublic == "" ? "null" : "'" . $this->l20_dtpublic . "'") . "
                ," . ($this->l20_recdocumentacao == "null" || $this->l20_recdocumentacao == "" ? "null" : "'" . $this->l20_recdocumentacao . "'") . "
                ,$this->l20_datapublicacao1
                ,'$this->l20_nomeveiculo1'
                ,$this->l20_datapublicacao2
                ,'$this->l20_nomeveiculo2'
                ,$this->l20_tipojulg
                ,'$this->l20_procadmin'
                ,'$this->l20_usaregistropreco'
                ,'$this->l20_liclocal'
                ," . ($this->l20_liccomissao == "null" || $this->l20_liccomissao == "" ? "0" : "'" . $this->l20_liccomissao . "'") . "
                ," . ($this->l20_equipepregao == "null" || $this->l20_equipepregao == "" ? "0" : "'" . $this->l20_equipepregao . "'") . "
                ,'$this->l20_local'
                ,'$this->l20_objeto'
                ,'$this->l20_localentrega'
                ,'$this->l20_prazoentrega'
                ,'$this->l20_condicoespag'
                ,'$this->l20_validadeproposta'
                ,'$this->l20_aceitabilidade'
                ,'$this->l20_justificativa'
                ,'$this->l20_razao'
                ,$this->l20_instit
                ,$this->l20_tipnaturezaproced
                ,$this->l20_tipoprocesso
                ,$this->l20_critdesempate
                ,$this->l20_destexclusiva
                ,$this->l20_subcontratacao
                ,$this->l20_limitcontratacao
                ,'$this->l20_veicdivulgacao'
                ,'$this->l20_clausulapro'
                ,$this->l20_codepartamento
                ,$this->l20_diames
                ,$this->l20_execucaoentrega
                ,$this->l20_anousu
                ," . ($this->l20_dtpubratificacao == "null" || $this->l20_dtpubratificacao == "" ? "null" : "'" . $this->l20_dtpubratificacao . "'") . "
                ,$this->l20_formacontroleregistropreco
                ,$this->l20_criterioadjudicacao
                ," . ($this->l20_dtlimitecredenciamento == "null" || $this->l20_dtlimitecredenciamento == "" ? "null" : "'" . $this->l20_dtlimitecredenciamento . "'") . "
                ,$this->l20_nroedital
                ,$this->l20_cadinicial
                ,$this->l20_exercicioedital
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "liclicita ($this->l20_codigo) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "liclicita já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql = "liclicita ($this->l20_codigo) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->l20_codigo;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))
        ) {
            $resaco = $this->sql_record($this->sql_query_file($this->l20_codigo));
            if (($resaco != false) || ($this->numrows != 0)) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac, 0, 0);
                $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
                $resac = db_query("insert into db_acountkey values($acount,7589,'$this->l20_codigo','I')");
                $resac = db_query("insert into db_acount values($acount,1260,7589,'','" . AddSlashes(pg_result($resaco, 0, 'l20_codigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7590,'','" . AddSlashes(pg_result($resaco, 0, 'l20_codtipocom')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7594,'','" . AddSlashes(pg_result($resaco, 0, 'l20_numero')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7592,'','" . AddSlashes(pg_result($resaco, 0, 'l20_id_usucria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7591,'','" . AddSlashes(pg_result($resaco, 0, 'l20_datacria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7593,'','" . AddSlashes(pg_result($resaco, 0, 'l20_horacria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7595,'','" . AddSlashes(pg_result($resaco, 0, 'l20_dataaber')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7596,'','" . AddSlashes(pg_result($resaco, 0, 'l20_dtpublic')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7597,'','" . AddSlashes(pg_result($resaco, 0, 'l20_horaaber')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7598,'','" . AddSlashes(pg_result($resaco, 0, 'l20_local')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7599,'','" . AddSlashes(pg_result($resaco, 0, 'l20_objeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7782,'','" . AddSlashes(pg_result($resaco, 0, 'l20_tipojulg')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7909,'','" . AddSlashes(pg_result($resaco, 0, 'l20_liccomissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,7908,'','" . AddSlashes(pg_result($resaco, 0, 'l20_liclocal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,8986,'','" . AddSlashes(pg_result($resaco, 0, 'l20_procadmin')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,10010,'','" . AddSlashes(pg_result($resaco, 0, 'l20_correto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,10103,'','" . AddSlashes(pg_result($resaco, 0, 'l20_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,10287,'','" . AddSlashes(pg_result($resaco, 0, 'l20_licsituacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,12605,'','" . AddSlashes(pg_result($resaco, 0, 'l20_edital')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,12606,'','" . AddSlashes(pg_result($resaco, 0, 'l20_anousu')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,15270,'','" . AddSlashes(pg_result($resaco, 0, 'l20_usaregistropreco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,15424,'','" . AddSlashes(pg_result($resaco, 0, 'l20_localentrega')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,15425,'','" . AddSlashes(pg_result($resaco, 0, 'l20_prazoentrega')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,15426,'','" . AddSlashes(pg_result($resaco, 0, 'l20_condicoespag')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,15427,'','" . AddSlashes(pg_result($resaco, 0, 'l20_validadeproposta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009528,'','" . AddSlashes(pg_result($resaco, 0, 'l20_razao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009527,'','" . AddSlashes(pg_result($resaco, 0, 'l20_justificativa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009526,'','" . AddSlashes(pg_result($resaco, 0, 'l20_aceitabilidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009525,'','" . AddSlashes(pg_result($resaco, 0, 'l20_equipepregao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009524,'','" . AddSlashes(pg_result($resaco, 0, 'l20_nomeveiculo2')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009522,'','" . AddSlashes(pg_result($resaco, 0, 'l20_datapublicacao2')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009520,'','" . AddSlashes(pg_result($resaco, 0, 'l20_nomeveiculo1')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009519,'','" . AddSlashes(pg_result($resaco, 0, 'l20_datapublicacao1')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009518,'','" . AddSlashes(pg_result($resaco, 0, 'l20_datadiario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009517,'','" . AddSlashes(pg_result($resaco, 0, 'l20_recdocumentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009515,'','" . AddSlashes(pg_result($resaco, 0, 'l20_numeroconvidado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009514,'','" . AddSlashes(pg_result($resaco, 0, 'l20_descontotab')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009513,'','" . AddSlashes(pg_result($resaco, 0, 'l20_regimexecucao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009512,'','" . AddSlashes(pg_result($resaco, 0, 'l20_naturezaobjeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1260,2009511,'','" . AddSlashes(pg_result($resaco, 0, 'l20_tipliticacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar($l20_codigo = null, $convite, $ibuscartribunal = null)
    {


        if (empty($this->l20_naturezaobjeto)) {
            $this->l20_naturezaobjeto = 0;
        }

        $this->atualizacampos();
        $convite = trim(strtoupper($convite));


        if ($ibuscartribunal == null) {
            $tribunal = $this->buscartribunal($this->l20_codtipocom);
        }

        $sql = " update liclicita set ";
        $virgula = "";

        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
            $sql .= $virgula . " l20_local = null ";
            $virgula = ",";
        } else {
            if (trim($this->l20_local != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_local"]))) {

                $sql .= $virgula . " l20_local = '$this->l20_local' ";
                $virgula = ",";
            } else {
                $sql .= $virgula . " l20_local = ''";
                $virgula = ",";
            }
        }
        if (trim($this->l20_localentrega != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_localentrega"]))) {

            $sql .= $virgula . " l20_localentrega = '$this->l20_localentrega' ";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_localentrega = ''";
            $virgula = ",";
        }

        //alteração do campo l20_tipliticacao e l20_naturezaobjeto

        if (trim($this->l20_tipliticacao != 0 || isset($GLOBALS["HTTP_POST_VARS"]["l20_tipliticacao"]))) {
            $sql .= $virgula . " l20_tipliticacao = '$this->l20_tipliticacao' ";
            $virgula = ",";
        }

        if (trim($this->l20_naturezaobjeto != 0 || isset($GLOBALS["HTTP_POST_VARS"]["l20_naturezaobjeto"]))) {
            $sql .= $virgula . " l20_naturezaobjeto = '$this->l20_naturezaobjeto' ";
            $virgula = ",";
        }

        if (trim($this->l20_validadeproposta != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_validadeproposta"]))) {
            $sql .= $virgula . " l20_validadeproposta = '$this->l20_validadeproposta' ";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_validadeproposta = ''";
            $virgula = ",";
        }

        if (trim($this->l20_aceitabilidade != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_aceitabilidade"]))) {
            $sql .= $virgula . " l20_aceitabilidade = '$this->l20_aceitabilidade' ";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_aceitabilidade = ''";
            $virgula = ",";
        }

        if (trim($this->l20_nomeveiculo1 != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_nomeveiculo1"]))) {
            $sql .= $virgula . " l20_nomeveiculo1 = '$this->l20_nomeveiculo1' ";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_nomeveiculo1 = ''";
            $virgula = ",";
        }

        if (trim($this->l20_nomeveiculo2 != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_nomeveiculo2"]))) {
            $sql .= $virgula . " l20_nomeveiculo2 = '$this->l20_nomeveiculo2' ";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_nomeveiculo2 = ''";
            $virgula = ",";
        }


        if (trim($this->l20_numeroconvidado != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_numeroconvidado"]))) {
            if (trim($this->l20_numeroconvidado == null)) {
                $this->l20_numeroconvidado = 'null';
            }
            $sql .= $virgula . " l20_numeroconvidado = $this->l20_numeroconvidado ";
            $virgula = ",";
            if ($this->l20_numeroconvidado == null && $tribunal == 30) {
                $this->erro_sql = "Você informou o tipo de modalidade  CONVITE. Para esta modalidade é \\n\\n obrigatorio preencher o campo Numero Convidado";
                $this->erro_campo = "l20_numeroconvidado";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_dtpubratificacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_dtpubratificacao"])) && ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103)) {
            $sql .= $virgula . " l20_dtpubratificacao = '$this->l20_dtpubratificacao '";
            $virgula = ",";
            if (trim($this->l20_dtpubratificacao) == null) {
                $this->erro_sql = "Você informou um tipo de 'INEXIGIBILIDADE'. Para este tipo é  \\n\\n obrigatorio preencher os campos: Tipo de Processo, \\n\\n Data Publicação Termo Ratificação, Veiculo de Divulgação,Justificativa,Razão";
                $this->erro_campo = "l20_dtpubratificacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_dtlimitecredenciamento != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_dtlimitecredenciamento"])) && ($tribunal == 102 || $tribunal == 103)) {
            $sql .= $virgula . " l20_dtlimitecredenciamento = '$this->l20_dtlimitecredenciamento '";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_dtlimitecredenciamento = null";
            $virgula = ",";
        }

        if (trim($this->l20_tipoprocesso == 0 || isset($GLOBALS["HTTP_POST_VARS"]["l20_tipoprocesso"])) && ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103)) {
            $sql .= $virgula . " l20_tipoprocesso = $this->l20_tipoprocesso ";
            $virgula = ",";
//            if (trim($this->l20_tipoprocesso) == null || trim($this->l20_tipoprocesso) == 0) {
//                $this->erro_sql = "obrigatorio preencher os campos: Tipo de Processo";
//                $this->erro_campo = "l20_tipoprocesso";
//                $this->erro_banco = "";
//                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
//                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
//                $this->erro_status = "0";
//                return false;
//            }
        }

        if (trim($this->l20_veicdivulgacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_veicdivulgacao"])) && ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103)) {

            $sql .= $virgula . " l20_veicdivulgacao = '$this->l20_veicdivulgacao'";
            $virgula = ",";
        }

        if (trim($this->l20_justificativa != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_justificativa"])) && ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103)) {
            $sql .= $virgula . " l20_justificativa = '$this->l20_justificativa' ";
            $virgula = ",";
        }

        if (trim($this->l20_razao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_razao"])) && ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103)) {
            $sql .= $virgula . " l20_razao = '$this->l20_razao' ";
            $virgula = ",";
        }

        if (trim($this->l20_condicoespag != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_condicoespag"]))) {
            $sql .= $virgula . " l20_condicoespag = '$this->l20_condicoespag' ";
            $virgula = ",";
            if ($this->l20_condicoespag == null) {
                $this->erro_sql = " Campo condicoes de pagamento nao Informado.";
                $this->erro_campo = "l20_condicoespag";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_numero != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_numero"]))) {
            $sql .= $virgula . " l20_numero = $this->l20_numero ";
            $virgula = ",";
            if ($this->l20_numero == null) {
                $this->erro_sql = " Campo Numeração nao Informado.";
                $this->erro_campo = "l20_numero";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->l20_id_usucria != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_id_usucria"]))) {
            $sql .= $virgula . " l20_id_usucria = $this->l20_id_usucria ";
            $virgula = ",";
            if ($this->l20_id_usucria == null) {
                $this->erro_sql = " Campo Cod. Usuário nao Informado.";
                $this->erro_campo = "l20_id_usucria";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->l20_datacria != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_datacria"]))) {
            $sql .= $virgula . " l20_datacria = '$this->l20_datacria '";
            $virgula = ",";

            if ($this->l20_datacria == null) {
                $this->erro_sql = " Campo Data Criação nao Informado.";
                $this->erro_campo = "l20_datacria";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->l20_horacria != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_horacria"]))) {
//            if($this->l20_codtipocom == && $this->l20_datacria > $this->l20_dataaber){
//                $this->erro_sql = "Data Abertura Proc. Adm deve ser menor que Data Emis/Alt Edital/Convite.";
//                $this->erro_campo = "l20_datacria";
//                $this->erro_banco = "";
//                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
//                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
//                $this->erro_status = "0";
//                return false;
//            }
            $sql .= $virgula . " l20_horacria = '$this->l20_horacria' ";
            $virgula = ",";
            if ($this->l20_horacria == null) {
                $this->erro_sql = " Campo Hora Criação nao Informado.";
                $this->erro_campo = "l20_horacria";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if ($this->l20_horaaber == null) {

            $this->l20_horaaber = '$this->l20_horacria';
            $sql .= $virgula . " l20_horaaber = '$this->l20_horacria'";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_horaaber = '$this->l20_horaaber'";
            $virgula = ",";
        }

        if ($tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
            $sql .= $virgula . " l20_dtpublic = null ";
            $virgula = ",";
        } else {
            if (trim($this->l20_dtpublic != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_dtpublic"]))) {
                if ($this->l20_dtpublic == "" || $this->l20_dtpublic == null) {
                    $sql .= $virgula . " l20_dtpublic =null ";
                    $virgula = ",";
                } else {
                    if ($this->l20_dtpublic < $this->l20_datacria) {
                        $this->erro_sql = " A data da publicacao em diario oficial  deve ser superior  ou igual a data de criacao.";
                        $this->erro_campo = "l20_dtpublic";
                        $this->erro_banco = "";
                        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                        $this->erro_status = "0";
                        return false;
                    } else {
                        $sql .= $virgula . " l20_dtpublic ='$this->l20_dtpublic' ";
                        $virgula = ",";
                    }
                }
            }
        }

        if (trim($this->l20_datapublicacao1 != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao1"]))) {
            if ($this->l20_datapublicacao1 == "" || $this->l20_datapublicacao1 == null) {
                $sql .= $virgula . " l20_datapublicacao1 =null ";
                $virgula = ",";
            } else {
                $sql .= $virgula . " l20_datapublicacao1 ='$this->l20_datapublicacao1' ";
                $virgula = ",";
                if ($this->l20_datapublicacao1 != "" && ($this->l20_datacria > $this->l20_datapublicacao1)) {
                    $this->erro_sql = " A data da publicacao em Edital Veiculo 1  deve ser superior  ou igual a data de criacao.";
                    $this->erro_campo = "l20_datapublicacao1";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                } else if ($this->l20_datapublicacao1 > $this->l20_recdocumentacao) {
                    //  A data da publicacao em diario oficial nao deve ser superior  ou igual a data de criacao.
                    $this->erro_sql = " A Data da Publicação em Edital Veiculo 1 deve ser anterior a Data de Recebimento da Documentação";
                    $this->erro_campo = "l20_datapublicacao1";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        if (trim($this->l20_datapublicacao2 != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_datapublicacao2"]))) {
            if ($this->l20_datapublicacao2 == "" || $this->l20_datapublicacao2 == null) {
                $sql .= $virgula . " l20_datapublicacao2 =null ";
                $virgula = ",";
            } else {
                $sql .= $virgula . " l20_datapublicacao2 ='$this->l20_datapublicacao2' ";
                $virgula = ",";
                if ($this->l20_datapublicacao2 != "" && ($this->l20_datacria > $this->l20_datapublicacao2)) {
                    $this->erro_sql = " A data da publicacao em Edital Veiculo 2  deve ser superior  ou igual a data de criacao.";
                    $this->erro_campo = "l20_datapublicacao2";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                } else if ($this->l20_datapublicacao2 > $this->l20_recdocumentacao) {
                    //  A data da publicacao em diario oficial nao deve ser superior  ou igual a data de criacao.
                    $this->erro_sql = " A Data da Publicação em Edital Veiculo 2 deve ser anterior a Data de Recebimento da Documentação";
                    $this->erro_campo = "l20_datapublicacao2";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        if (trim($this->l20_recdocumentacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_recdocumentacao"]))) {
            if ($tribunal != 50) {
                if ($this->l20_recdocumentacao == null || $this->l20_recdocumentacao == "" and $tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
                    $sql .= $virgula . " l20_recdocumentacao = null ";
                    $virgula = ",";
                } else if ($this->l20_recdocumentacao < $this->l20_dataaber && $this->l20_codtipocom != 16) {
                    $this->erro_sql = " A data informada no campo  Recebimento Documentação deve ser  superior a   Data Edital/Convite.";
                    $this->erro_campo = "l20_recdocumentacao";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                } else {
                    $sql .= $virgula . " l20_recdocumentacao = ' $this->l20_recdocumentacao '";
                    $virgula = ",";
                }
            }
        }

        if (trim($this->l20_dataaber != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_dataaber"]))) {

            if (trim($this->l20_dataaber) == null and $tribunal != 100 and $tribunal != 101 and $tribunal != 102 and $tribunal != 103) {
                $this->erro_sql = " Campo Data Edital/Convite nao Informado.";
                $this->erro_campo = "l20_dataaber";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else if (trim($this->l20_dataaber) == null and $tribunal == 100 || $tribunal == 101 || $tribunal == 102 || $tribunal == 103) {
                $sql .= $virgula . " l20_dataaber = null ";
                $virgula = ",";
            } else {
                $sql .= $virgula . " l20_dataaber ='$this->l20_dataaber' ";
                $virgula = ",";
            }
        }

        if (($this->l20_datacria != null || isset($GLOBALS["HTTP_POST_VARS"]["l20_datacria"])) && ($this->l20_dataaber != null || isset($GLOBALS["HTTP_POST_VARS"]["l20_dataaber"]))) {
            if ($this->l20_datacria > $this->l20_dataaber and $tribunal != 100 and $tribunal != 101 and $tribunal != 102 and $tribunal != 103) {
                $this->erro_sql = "A data inserida no campo 'Data Emis/Alt Edital/Convite' deverá ser maior ou igual a data inserida no campo 'Data Abertura Proc. Adm.'.";
                $this->erro_campo = "l20_dataaber";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_objeto != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_objeto"]))) {
            $sql .= $virgula . " l20_objeto =' $this->l20_objeto' ";
            $virgula = ",";
            if (trim($this->l20_objeto) == null) {
                $this->erro_sql = " Campo Objeto nao Informado.";
                $this->erro_campo = "l20_objeto";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                if (strlen($this->l20_objeto) < 15 and strlen($this->l20_objeto) > 500) {
                    $this->erro_msg = "Usuário: \\n\\n O campo Objeto deve ter no mínimo 15 caracteres e no máximo 500 \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        if (trim($this->l20_tipojulg != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_tipojulg"]))) {
            $sql .= $virgula . " l20_tipojulg = $this->l20_tipojulg ";
            $virgula = ",";
            if (trim($this->l20_tipojulg) == null) {
                $this->erro_sql = " Campo Tipo de Julgamento nao Informado.";
                $this->erro_campo = "l20_tipojulg";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_liccomissao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_liccomissao"]))) {
            $sql .= $virgula . " l20_liccomissao = $this->l20_liccomissao ";
            $virgula = ",";
            if (trim($this->l20_liccomissao) == null) {
                $this->erro_sql = " Campo Código da Comissão nao Informado.";
                $this->erro_campo = "l20_liccomissao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if ($convite != "" || $convite != null) {
                $sql = "select l30_data  from liccomissao where l30_codigo=$this->l20_liccomissao";
                $result = db_query($sql);
                $l30_data = pg_result($result, 0, 0);
                if ($l30_data > $this->l20_datacria) {
                    $this->erro_sql = " A data da comissão nao deve ser superior a data da criacao .";
                    $this->erro_campo = "l20_liccomissao";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        if (trim($this->l20_liclocal != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_liclocal"]))) {
            $sql .= $virgula . " l20_liclocal = $this->l20_liclocal ";
            $virgula = ",";
            if (trim($this->l20_liclocal) == null) {
                $this->erro_sql = " Campo Código do Local da Licitação nao Informado.";
                $this->erro_campo = "l20_liclocal";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_procadmin) == null || trim($this->l20_procadmin) == "") {
            $sql .= $virgula . " l20_procadmin =null ";
            $virgula = ",";
        } else {
            $sql .= $virgula . " l20_procadmin = '$this->l20_procadmin' ";
            $virgula = ",";
        }

        //echo
        if (trim($this->l20_correto != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_correto"]))) {
            $sql .= $virgula . " l20_correto = '$this->l20_correto' ";
            $virgula = ",";
            if (trim($this->l20_correto) == null) {
                $this->erro_sql = " Campo Correto nao Informado.";
                $this->erro_campo = "l20_correto";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_instit != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_instit"]))) {
            $sql .= $virgula . " l20_instit = $this->l20_instit ";
            $virgula = ",";
            if (trim($this->l20_instit) == null) {
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "l20_instit";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_licsituacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_licsituacao"]))) {
            $sql .= $virgula . " l20_licsituacao = $this->l20_licsituacao ";
            $virgula = ",";
            if (trim($this->l20_licsituacao) == null) {
                $this->erro_sql = " Campo Situação da Licitação nao Informado.";
                $this->erro_campo = "l20_licsituacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_edital != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_edital"]))) {
            $sql .= $virgula . " l20_edital = $this->l20_edital ";
            $virgula = ",";
            if (trim($this->l20_edital) == null) {
                $this->erro_sql = " Campo Licitacao nao Informado.";
                $this->erro_campo = "l20_edital";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_nroedital != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_nroedital"]))) {
            if (trim($this->l20_nroedital) != null) {
                $sql .= $virgula . " l20_nroedital = $this->l20_nroedital ";
                $virgula = ",";
            } else if (trim($this->l20_nroedital) == null && in_array($tribunal, array(48, 49, 50, 52, 53, 54)) && $this->l20_anousu >= 2020) {
                $this->erro_sql = " Campo Número Edital nao Informado.";
                $this->erro_campo = "l20_nroedital";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_cadinicial != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_cadinicial"]))) {
            $sql .= $virgula . " l20_cadinicial = $this->l20_cadinicial ";
            $virgula = ",";
        }

        if (trim($this->l20_exercicioedital != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_exercicioedital"]))) {
            $sql .= $virgula . " l20_exercicioedital = '$this->l20_exercicioedital' ";
            $virgula = ",";
        }


        if (trim($this->l20_anousu != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_anousu"]))) {
            $sql .= $virgula . " l20_anousu = $this->l20_anousu ";
            $virgula = ",";
            if (trim($this->l20_anousu) == null) {
                $this->erro_sql = " Campo Exercício nao Informado.";
                $this->erro_campo = "l20_anousu";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_usaregistropreco != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_usaregistropreco"]))) {
            $sql .= $virgula . " l20_usaregistropreco = '$this->l20_usaregistropreco' ";
            $virgula = ",";
            if (trim($this->l20_usaregistropreco) == null) {
                $this->erro_sql = " Campo Registro Preço nao Informado.";
                $this->erro_campo = "l20_usaregistropreco";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l20_formacontroleregistropreco != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_formacontroleregistropreco"]))) {
            $sql .= $virgula . " l20_formacontroleregistropreco = '$this->l20_formacontroleregistropreco' ";
            $virgula = ",";
            if (trim($this->l20_formacontroleregistropreco) == null) {
                $this->erro_sql = " Campo Registro Preço nao Informado.";
                $this->erro_campo = "l20_formacontroleregistropreco";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        //if($tribunal==52){
        if (trim($this->l20_equipepregao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_equipepregao"])) {
            $sql .= $virgula . " l20_equipepregao = $this->l20_equipepregao";
            $virgula = ",";
            if (trim($this->l20_equipepregao) == null and $tribunal != 100 and $tribunal != 101 and $tribunal != 102 and $tribunal != 103) {
                $this->erro_sql = " Campo Comissão de Licitação não Informado.";
                $this->erro_campo = "l20_equipepregao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if ($convite != "" || $convite != null) {
            //$sql=  "select l45_data from licpregao where l45_sequencial=$this->l20_equipepregao";  $sql .= " l20_codigo = $this->l20_codigo";
            $comissao = "select  l45_data from  licpregao  inner join liclicita on liclicita.l20_equipepregao=licpregao.l45_sequencial where l20_codigo= $this->l20_codigo";
            //echo $sql;exit;
            $result = db_query($comissao);
            if (pg_num_rows($result) > 1) {
                $l45_data = pg_result($result, 0, 0);
                if ($l45_data > $this->l20_datacria) {
                    $this->erro_sql = " A data da equipe de pregao  nao deve ser superior a data da criacao .";
                    $this->erro_campo = "l20_equipepregao";
                    $this->erro_banco = "";
                    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }


        if (trim($this->l20_descontotab != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_descontotab"]))) {
            $sql .= $virgula . " l20_descontotab = $this->l20_descontotab ";
            $virgula = ",";
            if ($this->l20_descontotab == null) {
                $this->erro_sql = " Campo Desconto Tabela nao Informado.";
                $this->erro_campo = "l20_descontotab";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_regimexecucao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_regimexecucao"]))) {
            $sql .= $virgula . " l20_regimexecucao = $this->l20_regimexecucao ";
            $virgula = ",";
        }

        if (trim($this->l20_prazoentrega != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_prazoentrega"]))) {
            $sql .= $virgula . " l20_prazoentrega =' $this->l20_prazoentrega' ";
            $virgula = ",";
            if ($this->l20_prazoentrega == null) {
                $this->erro_sql = " Campo Prazo de entrega nao Informado.";
                $this->erro_campo = "l20_prazoentrega";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_tipnaturezaproced != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_tipnaturezaproced"]))) {
            $sql .= $virgula . " l20_tipnaturezaproced = $this->l20_tipnaturezaproced ";
            $virgula = ",";
            if ($this->l20_tipnaturezaproced == null) {
                $this->erro_sql = " Campo Tipo da Natureza do Procedimento nao foi informada.";
                $this->erro_campo = "l20_tipnaturezaproced";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->l20_critdesempate != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_critdesempate"]))) {
            $sql .= $virgula . " l20_critdesempate = $this->l20_critdesempate ";
            $virgula = ",";
            if ($this->l20_critdesempate == null) {
                $this->erro_sql = " Campo  Critério de desempate nao foi informado.";
                $this->erro_campo = "l20_critdesempate";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_destexclusiva != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_destexclusiva"]))) {
            $sql .= $virgula . " l20_destexclusiva = $this->l20_destexclusiva ";
            $virgula = ",";
            if ($this->l20_destexclusiva == null) {
                $this->erro_sql = " Campo Destinação Exclusiva  nao foi informada.";
                $this->erro_campo = "l20_destexclusiva";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_subcontratacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_subcontratacao"]))) {
            $sql .= $virgula . " l20_subcontratacao = $this->l20_subcontratacao ";
            $virgula = ",";
            if ($this->l20_subcontratacao == null) {
                $this->erro_sql = " Campo Sub. Contratação  nao foi informada.";
                $this->erro_campo = "l20_subcontratacao ";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_limitcontratacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_limitcontratacao"]))) {
            $sql .= $virgula . " l20_limitcontratacao = $this->l20_limitcontratacao ";
            $virgula = ",";
            if ($this->l20_subcontratacao == null) {
                $this->erro_sql = " Campo Limite Contratação nao foi informada.";
                $this->erro_campo = "l20_limitcontratacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->l20_regata) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_regata"])) {
            $sql .= $virgula . " l20_regata = $this->l20_regata ";
            $virgula = ",";
        }

        if (trim($this->l20_interporrecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_interporrecurso"])) {
            $sql .= $virgula . " l20_interporrecurso = $this->l20_interporrecurso ";
            $virgula = ",";
        }

        if (trim($this->l20_descrinterporrecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_descrinterporrecurso"])) {
            $sql .= $virgula . " l20_descrinterporrecurso = '$this->l20_descrinterporrecurso' ";
            $virgula = ",";
            if (trim($this->l20_descrinterporrecurso) == null && $this->l20_interporrecurso == 1) {
                $this->erro_sql = " Campo Descrição nao foi informado.";
                $this->erro_campo = "l20_descrinterporrecurso";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        /**
         * Estes Dois blocos estão duplicados para o campo l20_descrinterporrecurso. Verificar a versão anterior deste arquivo.
         */
        if (trim($this->l20_descrinterporrecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_descrinterporrecurso"])) {
            $sql .= $virgula . " l20_descrinterporrecurso = '$this->l20_descrinterporrecurso' ";
            $virgula = ",";
            if (trim($this->l20_descrinterporrecurso) == null && $this->l20_interporrecurso == 1) {
                $this->erro_sql = " Campo Descrição nao foi informado.";
                $this->erro_campo = "l20_descrinterporrecurso";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_descrinterporrecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_descrinterporrecurso"])) {
            $sql .= $virgula . " l20_descrinterporrecurso = '$this->l20_descrinterporrecurso' ";
            $virgula = ",";
            if (trim($this->l20_descrinterporrecurso) == null && $this->l20_interporrecurso == 1) {
                $this->erro_sql = " Campo Descrição nao foi informado.";
                $this->erro_campo = "l20_descrinterporrecurso";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_clausulapro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_clausulapro"])) {
            $sql .= $virgula . " l20_clausulapro =' $this->l20_clausulapro' ";
            $virgula = ",";
        }

        if (trim($this->l20_criterioadjudicacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_criterioadjudicacao"])) {
            $sql .= $virgula . " l20_criterioadjudicacao =' $this->l20_criterioadjudicacao' ";
            $virgula = ",";
        }


        if (trim($this->l20_codepartamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_codepartamento"])) {
            $sql .= $virgula . " l20_codepartamento = $this->l20_codepartamento ";
            $virgula = ",";
            if (trim($this->l20_codepartamento) == null) {
                $this->erro_sql = " Campo codigo departamento nao Informado.";
                $this->erro_campo = "l20_codepartamento";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->l20_diames) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_diames"])) {
            $sql .= $virgula . " l20_diames = $this->l20_diames ";
            $virgula = ",";
            if (trim($this->l20_diames) == null) {
                $this->erro_sql = " Campo dia/mes nao Informado.";
                $this->erro_campo = "l20_diames";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        if (trim($this->l20_execucaoentrega) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_execucaoentrega"])) {
            $sql .= $virgula . " l20_execucaoentrega = $this->l20_execucaoentrega ";
            $virgula = ",";
            if (trim($this->l20_execucaoentrega) == null) {
                $this->erro_sql = " Campo execucao entrega nao Informado.";
                $this->erro_campo = "l20_execucaoentrega";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_codtipocom) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_codtipocom"])) {
            $sql .= $virgula . " l20_codtipocom = $this->l20_codtipocom ";
            $virgula = ",";
            if (trim($this->l20_codtipocom) == null) {
                $this->erro_sql = " Campo Código do tipo de compra nao Informado.";
                $this->erro_campo = "l20_codtipocom";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }


        $sql .= " where ";
        if ($l20_codigo != null) {
            $sql .= " l20_codigo = $this->l20_codigo";
        }
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))
        ) {
            // $resaco = $this->sql_record($this->sql_query_file($this->l20_codigo));
            // if ($this->numrows > 0) {
            //     for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
            //         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            //         $acount = pg_result($resac, 0, 0);
            //         $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
            //         $resac = db_query("insert into db_acountkey values($acount,7589,'$this->l20_codigo','A')");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_codigo"]) || $this->l20_codigo != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7589,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_codigo')) . "','$this->l20_codigo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_codtipocom"]) || $this->l20_codtipocom != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7590,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_codtipocom')) . "','$this->l20_codtipocom'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_numero"]) || $this->l20_numero != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7594,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_numero')) . "','$this->l20_numero'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_id_usucria"]) || $this->l20_id_usucria != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7592,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_id_usucria')) . "','$this->l20_id_usucria'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_datacria"]) || $this->l20_datacria != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7591,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_datacria')) . "','$this->l20_datacria'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_horacria"]) || $this->l20_horacria != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7593,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_horacria')) . "','$this->l20_horacria'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_dataaber"]) || $this->l20_dataaber != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7595,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_dataaber')) . "','$this->l20_dataaber'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_dtpublic"]) || $this->l20_dtpublic != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7596,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_dtpublic')) . "','$this->l20_dtpublic'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_horaaber"]) || $this->l20_horaaber != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7597,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_horaaber')) . "','$this->l20_horaaber'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_local"]) || $this->l20_local != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7598,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_local')) . "','$this->l20_local'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_objeto"]) || $this->l20_objeto != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7599,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_objeto')) . "','$this->l20_objeto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_tipojulg"]) || $this->l20_tipojulg != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7782,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_tipojulg')) . "','$this->l20_tipojulg'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_liccomissao"]) || $this->l20_liccomissao != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7909,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_liccomissao')) . "','$this->l20_liccomissao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_liclocal"]) || $this->l20_liclocal != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,7908,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_liclocal')) . "','$this->l20_liclocal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_procadmin"]) || $this->l20_procadmin != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,8986,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_procadmin')) . "','$this->l20_procadmin'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_correto"]) || $this->l20_correto != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,10010,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_correto')) . "','$this->l20_correto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_instit"]) || $this->l20_instit != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,10103,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_instit')) . "','$this->l20_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_licsituacao"]) || $this->l20_licsituacao != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,10287,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_licsituacao')) . "','$this->l20_licsituacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_edital"]) || $this->l20_edital != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,12605,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_edital')) . "','$this->l20_edital'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_anousu"]) || $this->l20_anousu != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,12606,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_anousu')) . "','$this->l20_anousu'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_usaregistropreco"]) || $this->l20_usaregistropreco != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,15270,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_usaregistropreco')) . "','$this->l20_usaregistropreco'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_localentrega"]) || $this->l20_localentrega != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,15424,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_localentrega')) . "','$this->l20_localentrega'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_prazoentrega"]) || $this->l20_prazoentrega != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,15425,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_prazoentrega')) . "','$this->l20_prazoentrega'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_condicoespag"]) || $this->l20_condicoespag != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,15426,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_condicoespag')) . "','$this->l20_condicoespag'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_validadeproposta"]) || $this->l20_validadeproposta != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,15427,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_validadeproposta')) . "','$this->l20_validadeproposta'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //         if (isset($GLOBALS["HTTP_POST_VARS"]["l20_formacontroleregistropreco"]) || $this->l20_formacontroleregistropreco != "")
            //             $resac = db_query("insert into db_acount values($acount,1260,20854,'" . AddSlashes(pg_result($resaco, $conresaco, 'l20_formacontroleregistropreco')) . "','$this->l20_formacontroleregistropreco'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            //     }
            // }
        }
        $result = db_query($sql);

        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "liclicita nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->l20_codigo;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liclicita nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    public function excluir($l20_codigo = null, $dbwhere = null)
    {

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))
        ) {
            if ($dbwhere == null || $dbwhere == "") {
                $resaco = $this->sql_record($this->sql_query_file($l20_codigo));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
            }
            if (($resaco != false) || ($this->numrows != 0)) {
                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac, 0, 0);
                    $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
                    $resac = db_query("insert into db_acountkey values($acount,7589,'$l20_codigo','E')");
                    $resac = db_query("insert into db_acount values($acount,1260,7589,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_codigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7590,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_codtipocom')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7594,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_numero')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7592,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_id_usucria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7591,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_datacria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7593,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_horacria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7595,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_dataaber')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7596,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_dtpublic')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7597,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_horaaber')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7598,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_local')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7599,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_objeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7782,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_tipojulg')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7909,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_liccomissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,7908,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_liclocal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,8986,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_procadmin')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,10010,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_correto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,10103,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,10287,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_licsituacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,12605,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_edital')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,12606,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_anousu')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,15270,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_usaregistropreco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,15424,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_localentrega')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,15425,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_prazoentrega')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,15426,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_condicoespag')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,15427,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_validadeproposta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009528,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_razao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009527,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_justificativa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009526,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_aceitabilidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009525,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_equipepregao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009524,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_nomeveiculo2')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009522,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_datapublicacao2')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009520,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_nomeveiculo1')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009519,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_datapublicacao1')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009518,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_datadiario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009517,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_recdocumentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");

                    $resac = db_query("insert into db_acount values($acount,1260,2009515,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_numeroconvidado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009514,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_descontotab')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009513,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_regimexecucao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009512,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_naturezaobjeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,2009511,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_tipliticacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount,1260,20854,'','" . AddSlashes(pg_result($resaco, $iresaco, 'l20_formacontroleregistropreco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                }
            }
        }
        $sql = " delete from liclicita
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($l20_codigo != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " l20_codigo = $l20_codigo ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "liclicita nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $l20_codigo;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liclicita nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao do recordset
    public function sql_record($sql)
    {
        $result = db_query($sql);
        if ($result == false) {
            $this->numrows = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Erro ao selecionar os registros.";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql = "Record Vazio na Tabela:liclicita";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql

    function sql_query($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "", $groupby = null)
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_config         on db_config.codigo = liclicita.l20_instit";
        $sql .= "      inner join db_usuarios       on db_usuarios.id_usuario = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita          on cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join pctipocompratribunal on pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal";
        $sql .= "      inner join liclocal          on liclocal.l26_codigo = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao       on liccomissao.l30_codigo = liclicita.l20_liccomissao";
        $sql .= "      inner join licsituacao       on licsituacao.l08_sequencial = liclicita.l20_licsituacao";
        $sql .= "      inner join cgm               on  cgm.z01_numcgm = db_config.numcgm";
        $sql .= "      inner join db_config as dbconfig on  dbconfig.codigo = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra      on pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      inner join bairro            on bairro.j13_codi = liclocal.l26_bairro";
        $sql .= "      inner join ruas              on ruas.j14_codigo = liclocal.l26_lograd";
        $sql .= "      left join homologacaoadjudica on l202_licitacao = l20_codigo";
        $sql .= "      left join liclicitaproc     on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
        $sql .= "      left join protprocesso      on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso";
        $sql .= "      left join habilitacaoforn   on l206_licitacao = l20_codigo";
        $sql .= "      left join cgm as cgmfornecedor on cgmfornecedor.z01_numcgm = l206_fornecedor";
        $sql .= "      left join liclicitem on l21_codliclicita = l20_codigo";
        $sql .= "       left join pcorcamitemlic on pc26_liclicitem=l21_codigo";
        $sql .= "       left join pcorcamitem on pc22_orcamitem=pc26_orcamitem";
        $sql .= "       left join pcorcamjulg on pc24_orcamitem=pc22_orcamitem and pc24_pontuacao = 1";
        $sql .= "       left join pcorcamforne on pc21_orcamforne=pc24_orcamforne";
        $sql .= "       left join pcorcamval on pc23_orcamitem = pc22_orcamitem and pc23_orcamforne = pc21_orcamforne";
        $sql .= "       left join pcorcam on pc20_codorc = pc22_codorc";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($groupby != null) {
            $sql .= " group by ";
            $campos_sql = split("#", $groupby);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $groupby;
        }
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

  function sql_query_relatorio($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "", $groupby = null)
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
    $sql .= " from liclicita ";
    $sql .= "      inner join db_config         on db_config.codigo = liclicita.l20_instit";
    $sql .= "      inner join db_usuarios       on db_usuarios.id_usuario = liclicita.l20_id_usucria";
    $sql .= "      inner join cflicita          on cflicita.l03_codigo = liclicita.l20_codtipocom";
    $sql .= "      inner join pctipocompratribunal on pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal";
    $sql .= "      inner join liclocal          on liclocal.l26_codigo = liclicita.l20_liclocal";
    $sql .= "      inner join liccomissao       on liccomissao.l30_codigo = liclicita.l20_liccomissao";
    $sql .= "      inner join licsituacao       on licsituacao.l08_sequencial = liclicita.l20_licsituacao";
    $sql .= "      inner join cgm               on  cgm.z01_numcgm = db_config.numcgm";
    $sql .= "      inner join db_config as dbconfig on  dbconfig.codigo = cflicita.l03_instit";
    $sql .= "      inner join pctipocompra      on pctipocompra.pc50_codcom = cflicita.l03_codcom";
    $sql .= "      inner join bairro            on bairro.j13_codi = liclocal.l26_bairro";
    $sql .= "      inner join ruas              on ruas.j14_codigo = liclocal.l26_lograd";
//    $sql .= "      left join homologacaoadjudica on l202_licitacao = l20_codigo";
//    $sql .= "      left join liclicitaproc     on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
//    $sql .= "      left join protprocesso      on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso";
//    $sql .= "      left join habilitacaoforn   on l206_licitacao = l20_codigo";
//    $sql .= "      left join cgm as cgmfornecedor on cgmfornecedor.z01_numcgm = l206_fornecedor";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($l20_codigo != null) {
        $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($groupby != null) {
      $sql .= " group by ";
      $campos_sql = split("#", $groupby);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $groupby;
    }
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

    function sql_query_edital($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "", $groupby = null)
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_config         on db_config.codigo = liclicita.l20_instit";
        $sql .= "      inner join db_usuarios       on db_usuarios.id_usuario = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita          on cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join pctipocompratribunal on pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal";
        $sql .= "      inner join liclocal          on liclocal.l26_codigo = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao       on liccomissao.l30_codigo = liclicita.l20_liccomissao";
        $sql .= "      inner join licsituacao       on licsituacao.l08_sequencial = liclicita.l20_licsituacao";
        $sql .= "      inner join cgm               on  cgm.z01_numcgm = db_config.numcgm";
        $sql .= "      inner join db_config as dbconfig on  dbconfig.codigo = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra      on pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      inner join bairro            on bairro.j13_codi = liclocal.l26_bairro";
        $sql .= "      inner join ruas              on ruas.j14_codigo = liclocal.l26_lograd";
        $sql .= "      left join homologacaoadjudica on l202_licitacao = l20_codigo";
        $sql .= "      left join liclicitaproc     on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
        $sql .= "      left join protprocesso      on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso";
        $sql .= "      left join habilitacaoforn   on l206_licitacao = l20_codigo";
        $sql .= "      left join cgm as cgmfornecedor on cgmfornecedor.z01_numcgm = l206_fornecedor";
        $sql .= "      left join liclicitem on l21_codliclicita = l20_codigo";
        $sql .= "       left join pcorcamitemlic on pc26_liclicitem=l21_codigo";
        $sql .= "       left join pcorcamitem on pc22_orcamitem=pc26_orcamitem";
        $sql .= "       left join pcorcamjulg on pc24_orcamitem=pc22_orcamitem and pc24_pontuacao = 1";
        $sql .= "       left join pcorcamforne on pc21_orcamforne=pc24_orcamforne";
        $sql .= "       left join pcorcamval on pc23_orcamitem = pc22_orcamitem and pc23_orcamforne = pc21_orcamforne";
        $sql .= "       left join pcorcam on pc20_codorc = pc22_codorc";
        $sql .= "       left join liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($groupby != null) {
            $sql .= " group by ";
            $campos_sql = split("#", $groupby);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $groupby;
        }
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

    //função sql equipregao - relatorio homologaprocesso

    function sql_query_equipepregao($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "", $groupby = null)
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_config         on db_config.codigo = liclicita.l20_instit";
        $sql .= "      inner join db_usuarios       on db_usuarios.id_usuario = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita          on cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join pctipocompratribunal on pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal";
        $sql .= "      inner join liclocal          on liclocal.l26_codigo = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao       on liccomissao.l30_codigo = liclicita.l20_liccomissao";
        $sql .= "      inner join licsituacao       on licsituacao.l08_sequencial = liclicita.l20_licsituacao";
        $sql .= "      inner join cgm               on  cgm.z01_numcgm = db_config.numcgm";
        $sql .= "      inner join db_config as dbconfig on  dbconfig.codigo = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra      on pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      inner join bairro            on bairro.j13_codi = liclocal.l26_bairro";
        $sql .= "      inner join ruas              on ruas.j14_codigo = liclocal.l26_lograd";
        $sql .= "      left join homologacaoadjudica on l202_licitacao = l20_codigo";
        $sql .= "      left join liclicitaproc     on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
        $sql .= "      left join protprocesso      on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso";
        $sql .= "      left join habilitacaoforn   on l206_licitacao = l20_codigo";
        $sql .= "      left join cgm as cgmfornecedor on cgmfornecedor.z01_numcgm = l206_fornecedor";
        $sql .= "      left join liclicitem on l21_codliclicita = l20_codigo";
        $sql .= "       left join pcorcamitemlic on pc26_liclicitem=l21_codigo";
        $sql .= "       left join pcorcamitem on pc22_orcamitem=pc26_orcamitem";
        $sql .= "       left join pcorcamjulg on pc24_orcamitem=pc22_orcamitem and pc24_pontuacao = 1";
        $sql .= "       left join pcorcamforne on pc21_orcamforne=pc24_orcamforne";
        $sql .= "       left join pcorcamval on pc23_orcamitem = pc22_orcamitem and pc23_orcamforne = pc21_orcamforne";
        $sql .= "       left join pcorcam on pc20_codorc = pc22_codorc";
        $sql .= "       inner join licpregao on l45_sequencial = l20_equipepregao";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($groupby != null) {
            $sql .= " group by ";
            $campos_sql = split("#", $groupby);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $groupby;
        }
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


    // funcao do sql
    function sql_query_file($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    /**
     * query para chegar até o vinculo de contratos
     */
    function sql_queryContratos($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_config             on db_config.codigo            = liclicita.l20_instit";
        $sql .= "      inner join db_usuarios           on db_usuarios.id_usuario      = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita              on cflicita.l03_codigo         = liclicita.l20_codtipocom";
        $sql .= "      inner join liclocal              on liclocal.l26_codigo         = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao           on liccomissao.l30_codigo      = liclicita.l20_liccomissao";
        $sql .= "      inner join licsituacao           on licsituacao.l08_sequencial  = liclicita.l20_licsituacao";
        $sql .= "      inner join cgm                   on cgm.z01_numcgm              = db_config.numcgm";
        $sql .= "      inner join db_config as dbconfig on dbconfig.codigo             = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra          on pctipocompra.pc50_codcom    = cflicita.l03_codcom";
        $sql .= "      inner join bairro                on bairro.j13_codi             = liclocal.l26_bairro";
        $sql .= "      inner join ruas                  on ruas.j14_codigo             = liclocal.l26_lograd";
        $sql .= "       left join liclicitaproc         on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
        $sql .= "       left join protprocesso          on protprocesso.p58_codproc    = liclicitaproc.l34_protprocesso";
        $sql .= "       left join liclicitem            on liclicita.l20_codigo        = l21_codliclicita ";
        $sql .= "       left join acordoliclicitem      on liclicitem.l21_codigo       = acordoliclicitem.ac24_liclicitem ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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
        //      echo $sql;
        return $sql;
    }

    function sql_queryContratosContass($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_config             on db_config.codigo            = liclicita.l20_instit";
        $sql .= "      inner join db_usuarios           on db_usuarios.id_usuario      = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita              on cflicita.l03_codigo         = liclicita.l20_codtipocom";
        $sql .= "      inner join liclocal              on liclocal.l26_codigo         = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao           on liccomissao.l30_codigo      = liclicita.l20_liccomissao";
        $sql .= "      inner join licsituacao           on licsituacao.l08_sequencial  = liclicita.l20_licsituacao";
        $sql .= "      inner join cgm                   on cgm.z01_numcgm              = db_config.numcgm";
        $sql .= "      inner join db_config as dbconfig on dbconfig.codigo             = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra          on pctipocompra.pc50_codcom    = cflicita.l03_codcom";
        $sql .= "      inner join bairro                on bairro.j13_codi             = liclocal.l26_bairro";
        $sql .= "      inner join ruas                  on ruas.j14_codigo             = liclocal.l26_lograd";
        $sql .= "       left join liclicitaproc         on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
        $sql .= "       left join protprocesso          on protprocesso.p58_codproc    = liclicitaproc.l34_protprocesso";
        $sql .= "       left join liclicitem            on liclicita.l20_codigo        = l21_codliclicita ";
        $sql .= "       left join acordoliclicitem      on liclicitem.l21_codigo       = acordoliclicitem.ac24_liclicitem ";
        $sql .= "      inner join parecerlicitacao     on parecerlicitacao.l200_licitacao     = liclicita.l20_codigo ";
        $sql .= "      inner join liclicitasituacao     on liclicitasituacao.l11_liclicita     = liclicita.l20_codigo ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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
        //      echo $sql;
        return $sql;
    }

    function sql_query_modelos($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join cflicitatemplate     on cflicitatemplate.l35_cflicita        = liclicita.l20_codtipocom                 ";
        $sql .= "      inner join db_documentotemplate on db_documentotemplate.db82_sequencial = cflicitatemplate.l35_db_documentotemplate";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_modelosatas($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join cflicitatemplateata  on cflicitatemplateata.l37_cflicita     = liclicita.l20_codtipocom                     ";
        $sql .= "      inner join db_documentotemplate on db_documentotemplate.db82_sequencial = cflicitatemplateata.l37_db_documentotemplate ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_pco($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join db_config  on  db_config.codigo = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra  on  pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      inner join liclicitem on liclicitem.l21_codliclicita = liclicita.l20_codigo";
        $sql .= "      inner join pcorcamitemlic on pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo";
        $sql .= "      inner join pcorcamitem on pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem";
        $sql .= "      inner join pcorcam on pcorcam.pc20_codorc = pcorcamitem.pc22_codorc";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_baixa($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
        $sql .= "      inner join db_config  on  db_config.codigo = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra  on  pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      inner join bairro  on  bairro.j13_codi = liclocal.l26_bairro";
        $sql .= "      inner join ruas  on  ruas.j14_codigo = liclocal.l26_lograd";
        $sql .= "    inner join licbaixa on l20_codigo=l28_liclicita";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_lib($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
        $sql .= "      inner join db_config  on  db_config.codigo = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra  on  pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      inner join bairro  on  bairro.j13_codi = liclocal.l26_bairro";
        $sql .= "      inner join ruas  on  ruas.j14_codigo = liclocal.l26_lograd";
        $sql .= "    left join liclicitaweb on l20_codigo=l29_liclicita";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_modelosminutas($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join cflicitatemplateminuta on cflicitatemplateminuta.l41_cflicita  = liclicita.l20_codtipocom                     ";
        $sql .= "      inner join db_documentotemplate   on db_documentotemplate.db82_sequencial = cflicitatemplateminuta.l41_db_documentotemplate ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_pcodireta($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from pcorcam";
        $sql .= "      left join pcorcamitem on pcorcamitem.pc22_codorc = pc20_codorc";
        $sql .= "      left join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem";
        $sql .= "      left join pcprocitem on pcorcamitemproc.pc31_pcprocitem = pc81_codprocitem";
        $sql .= "      left join pcorcamval on pc23_orcamitem = pc22_orcamitem";
        $sql .= "      left join pcorcamitemlic on pcorcamitemlic.pc26_orcamitem = pcorcamitemproc.pc31_orcamitem";
        $sql .= "      left join liclicitem on liclicitem.l21_codigo= pcorcamitemlic.pc26_liclicitem";
        $sql .= "      left join liclicita on liclicitem.l21_codliclicita= l20_codigo";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_julgamento_licitacao($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from liclicita ";
        $sql .= "      inner join liclicitem               on liclicitem.l21_codliclicita         = liclicita.l20_codigo              ";
        $sql .= "      inner join pcprocitem               on pcprocitem.pc81_codprocitem         = liclicitem.l21_codpcprocitem      ";
        $sql .= "      inner join pcproc                   on pcproc.pc80_codproc                 = pcprocitem.pc81_codproc           ";
        $sql .= "      inner join solicitem                on solicitem.pc11_codigo               = pcprocitem.pc81_solicitem         ";
        $sql .= "      inner join solicita                 on solicita.pc10_numero                = solicitem.pc11_numero             ";
        $sql .= "      inner join solicitempcmater         on solicitempcmater.pc16_solicitem     = solicitem.pc11_codigo             ";
        $sql .= "      inner join pcmater                  on pcmater.pc01_codmater               = solicitempcmater.pc16_codmater    ";
        $sql .= "      inner join pcorcamitemlic           on pcorcamitemlic.pc26_liclicitem      = liclicitem.l21_codigo             ";
        $sql .= "      inner join pcorcamval               on pcorcamval.pc23_orcamitem           = pcorcamitemlic.pc26_orcamitem     ";
        $sql .= "      inner join pcorcamforne             on pcorcamforne.pc21_orcamforne        = pcorcamval.pc23_orcamforne        ";
        $sql .= "      inner join pcorcamjulgamentologitem on pcorcamjulgamentologitem.pc93_pcorcamitem  = pcorcamval.pc23_orcamitem  ";
        $sql .= "                                         and pcorcamjulgamentologitem.pc93_pcorcamforne = pcorcamval.pc23_orcamforne ";
        $sql .= "      inner join pcorcamjulgamentolog     on pcorcamjulgamentolog.pc92_sequencial       = pcorcamjulgamentologitem.pc93_pcorcamjulgamentolog ";
        $sql .= "      inner join db_usuarios              on db_usuarios.id_usuario = pcorcamjulgamentolog.pc92_usuario   ";
        $sql .= "      inner join cgm as fornecedor        on fornecedor.z01_numcgm  = pcorcamforne.pc21_numcgm            ";

        $sql2 = "";
        if ($dbwhere == "") {

            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function sql_query_dados_licitacao($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "", $sSituacao = '')
    {


        $sCampo = "";

        if ($sSituacao != '') {

            $sSituacao = "and l11_licsituacao = {$sSituacao}";
            $sCampo = ",liclicitasituacao.l11_obs";
            //echo "teste: ".$sCampo;
        }

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

        $sql .= $sCampo;

        $sql .= " from liclicita ";
        $sql .= "      inner join db_config     on db_config.codigo = liclicita.l20_instit";
        $sql .= "      inner join db_usuarios   on db_usuarios.id_usuario = liclicita.l20_id_usucria";
        $sql .= "      inner join cflicita      on cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join liclocal      on liclocal.l26_codigo = liclicita.l20_liclocal";
        $sql .= "      inner join liccomissao   on liccomissao.l30_codigo = liclicita.l20_liccomissao";
        $sql .= "      inner join licsituacao   on licsituacao.l08_sequencial = liclicita.l20_licsituacao";
        $sql .= "      inner join cgm           on  cgm.z01_numcgm = db_config.numcgm";
        $sql .= "      inner join db_config as dbconfig on  dbconfig.codigo = cflicita.l03_instit";
        $sql .= "      inner join pctipocompra  on pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      inner join bairro        on bairro.j13_codi = liclocal.l26_bairro";
        $sql .= "      inner join ruas          on ruas.j14_codigo = liclocal.l26_lograd";
        $sql .= "      left  join liclicitaproc on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
        $sql .= "      left  join protprocesso  on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso";
        $sql .= "      inner join liclicitasituacao on liclicitasituacao.l11_liclicita = liclicita.l20_codigo $sSituacao";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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


    function alterar_liclicitajulgamento($l20_codigo)
    {

        $sql = " update liclicita set ";
        $virgula = "";

        if (trim($this->l20_regata) != "") {
            $sql .= $virgula . " l20_regata = $this->l20_regata ";
            $virgula = ",";
        }

        if (trim($this->l20_interporrecurso) != "") {
            $sql .= $virgula . " l20_interporrecurso = $this->l20_interporrecurso ";
            $virgula = ",";
        }

        if (trim($this->l20_descrinterporrecurso) != "") {
            $sql .= $virgula . " l20_descrinterporrecurso = '$this->l20_descrinterporrecurso' ";
            $virgula = ",";
            if (trim($this->l20_descrinterporrecurso) == null && $this->l20_interporrecurso == 1) {
                $this->erro_sql = " Campo Descrição nao foi informado.";
                $this->erro_campo = "l20_descrinterporrecurso";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->l20_licsituacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_licsituacao"]))) {
            $sql .= $virgula . " l20_licsituacao = $this->l20_licsituacao ";
            $virgula = ",";
            if (trim($this->l20_licsituacao) == null) {
                $this->erro_sql = " Campo Situação da Licitação nao Informado.";
                $this->erro_campo = "l20_licsituacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        if ($l20_codigo != null) {
            $sql .= " l20_codigo = $l20_codigo";
        }//die($sql);
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "liclicita nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->l20_codigo;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liclicita nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                //$this->erro_sql .= "Valores : ".$this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }

    }

    function alterarSituacaoCredenciamento($l20_codigo, $l20_licsituacao)
    {
        $sql = "update liclicita set l20_licsituacao = $l20_licsituacao where l20_codigo = $l20_codigo";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "liclicita nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->l20_codigo;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }
    }

    function getTipocomTribunal($l20_codigo)
    {
        $sqltipocom = "SELECT l03_pctipocompratribunal FROM liclicita
                       INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
                       WHERE l20_codigo = $l20_codigo";
        return $sqltipocom;
    }

    function buscartribunal($l20_codtipocom)
    {


        $sSql = "SELECT a.l44_sequencial
      FROM cflicita
      INNER JOIN db_config ON db_config.codigo = cflicita.l03_instit
      INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
      INNER JOIN pctipocompratribunal ON pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal
      INNER JOIN cgm ON cgm.z01_numcgm = db_config.numcgm
      INNER JOIN db_tipoinstit ON db_tipoinstit.db21_codtipo = db_config.db21_tipoinstit
      INNER JOIN pctipocompratribunal AS a ON a.l44_sequencial = pctipocompra.pc50_pctipocompratribunal
      WHERE cflicita.l03_codigo = $l20_codtipocom";
        $result = db_query($sSql);
        $tribunal = pg_result($result, 0, 0);

        /* Chave identica para todos os clientes , este é o codigo do tribunal
		CONVITE=30
		INEXIGIBILIDADE=29
		Dispensa de Licitacao=101
		Inexigibilidade Por Credenciamento=102
	  */
        return $tribunal;
    }


    function alterar_situacao($l20_codigo)
    {

        $sql = " update liclicita set ";
        $virgula = "";

        if (trim($this->l20_licsituacao != "" || isset($GLOBALS["HTTP_POST_VARS"]["l20_licsituacao"]))) {
            $sql .= $virgula . " l20_licsituacao = $this->l20_licsituacao ";
            $virgula = ",";
            if (trim($this->l20_licsituacao) == null) {
                $this->erro_sql = " Campo Situação da Licitação nao Informado.";
                $this->erro_campo = "l20_licsituacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        if ($l20_codigo != null) {
            $sql .= " l20_codigo = $l20_codigo";
        }//die($sql);
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "liclicita nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->l20_codigo;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "liclicita nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                //$this->erro_sql .= "Valores : ".$this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }

    }


    function sql_query_licitacao_transparencia($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "", $sSituacao = '')
    {


        $sCampo = "";

        if ($sSituacao != '') {

            $sSituacao = "and l11_licsituacao = {$sSituacao}";
            $sCampo = ",liclicitasituacao.l11_obs";
            echo "teste: " . $sCampo;
        }

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

        $sql .= $sCampo;

        $sql .= " from liclicita ";
        $sql .= "      left join db_config     on db_config.codigo = liclicita.l20_instit";
        $sql .= "      left join cflicita      on cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      left join liclocal      on liclocal.l26_codigo = liclicita.l20_liclocal";
        $sql .= "      left join liccomissao   on liccomissao.l30_codigo = liclicita.l20_liccomissao";
        $sql .= "      left join licsituacao   on licsituacao.l08_sequencial = liclicita.l20_licsituacao";
        $sql .= "      left join cgm           on  cgm.z01_numcgm = db_config.numcgm";
        $sql .= "      left join pctipocompra  on pctipocompra.pc50_codcom = cflicita.l03_codcom";
        $sql .= "      left join bairro        on bairro.j13_codi = liclocal.l26_bairro";
        $sql .= "      left join ruas          on ruas.j14_codigo = liclocal.l26_lograd";
        $sql .= "      left  join liclicitaproc on liclicitaproc.l34_liclicita = liclicita.l20_codigo";
        $sql .= "      left  join protprocesso  on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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


    function sql_query_comissao_pregao($l20_codigo = null, $campos = "*", $ordem = null, $dbwhere = "")
    {


        $sCampo = "";

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

        $sql .= $sCampo;

        $sql .= " from liclicita ";
        $sql .= "      inner join db_config on l20_instit = codigo";
        $sql .= "      inner join cflicita      on cflicita.l03_codigo = liclicita.l20_codtipocom";
        $sql .= "      inner join licpregao on l45_sequencial = l20_equipepregao";
        $sql .= "      inner join licpregaocgm on l46_licpregao = l45_sequencial";
        $sql .= "      inner join cgm on z01_numcgm = l46_numcgm";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($l20_codigo != null) {
                $sql2 .= " where liclicita.l20_codigo = $l20_codigo ";
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

    function verificaMembrosModalidade($modalidade, $equipepregao)
    {

        $sSQL = "";
        switch ($modalidade) {

            case 'pregao':

                $sSQL .= "

                  SELECT mapoio.l46_tipo, pregoeiro.l46_tipo FROM

                    (SELECT l46_licpregao, l46_tipo
                      FROM licpregaocgm
                        INNER JOIN cgm ON cgm.z01_numcgm = licpregaocgm.l46_numcgm
                        INNER JOIN licpregao ON licpregao.l45_sequencial = licpregaocgm.l46_licpregao
                          WHERE l46_tipo = 2) AS mapoio

                    INNER JOIN

                    (SELECT l46_licpregao, l46_tipo
                      FROM licpregaocgm
                        INNER JOIN cgm ON cgm.z01_numcgm = licpregaocgm.l46_numcgm
                        INNER JOIN licpregao ON licpregao.l45_sequencial = licpregaocgm.l46_licpregao
                          WHERE l46_tipo = 6) AS pregoeiro

                      ON pregoeiro.l46_licpregao = mapoio.l46_licpregao

                        WHERE pregoeiro.l46_licpregao = {$equipepregao} LIMIT 1

                  ";

                $rsResult = db_query($sSQL);

                if (pg_num_rows($rsResult) > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }

                break;

            case 'outros':

                $sSQL .= "

                  SELECT mapoio.l46_tipo, presidente.l46_tipo, secretario.l46_tipo FROM

                    (SELECT l46_licpregao, l46_tipo
                      FROM licpregaocgm
                        INNER JOIN cgm ON cgm.z01_numcgm = licpregaocgm.l46_numcgm
                        INNER JOIN licpregao ON licpregao.l45_sequencial = licpregaocgm.l46_licpregao
                          WHERE l46_tipo = 2) AS mapoio

                    INNER JOIN

                    (SELECT l46_licpregao, l46_tipo
                      FROM licpregaocgm
                        INNER JOIN cgm ON cgm.z01_numcgm = licpregaocgm.l46_numcgm
                        INNER JOIN licpregao ON licpregao.l45_sequencial = licpregaocgm.l46_licpregao
                          WHERE l46_tipo = 3) AS presidente ON presidente.l46_licpregao = mapoio.l46_licpregao

                    INNER JOIN

                    (SELECT l46_licpregao, l46_tipo
                      FROM licpregaocgm
                        INNER JOIN cgm ON cgm.z01_numcgm = licpregaocgm.l46_numcgm
                        INNER JOIN licpregao ON licpregao.l45_sequencial = licpregaocgm.l46_licpregao
                          WHERE l46_tipo = 4) AS secretario

                      ON secretario.l46_licpregao = presidente.l46_licpregao

                        WHERE secretario.l46_licpregao = {$equipepregao} LIMIT 1

                  ";

                $rsResult = db_query($sSQL);

                if (pg_num_rows($rsResult) > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }

                break;

        }

    }

    function excluirpublicacaocredenciamento($l20_codigo)
    {
        $sql = "Update liclicita set l20_dtpubratificacao = null,l20_dtlimitecredenciamento = null
        where l20_codigo = $l20_codigo";
        $result = db_query($sql);

        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Publicação nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->l20_codigo;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Publicação nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                //$this->erro_sql .= "Valores : ".$this->l20_codigo;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }


    function getPcmaterObras($liclicita)
    {
        $sql = "
            select pc16_codmater from liclicitem
                  inner join pcprocitem on pc81_codprocitem = l21_codpcprocitem
                  inner join solicitem on pc11_codigo = pc81_solicitem
                  inner join solicitempcmater on pc16_solicitem = pc11_codigo
                  inner join pcmater on pc01_codmater = pc16_codmater
                  where l21_codliclicita = $liclicita and pc01_obras = 't'";
        $rsResult = db_query($sql);
        $aItensPcmater = array();
        for ($icont = 0; $icont < pg_num_rows($rsResult); $icont++) {
            $aItensPcmater[] = db_utils::fieldsMemory($rsResult, $icont);
        }
        return $aItensPcmater;
    }
}
?>
