<?php

include("assinatura.php");

/**
 * Classe para impressão de modelos pdf
 *
 *
 *
 *
 *
 *
 * +=======================================================================================+
 * |      ALTERAÇÕES NA CLASSE impcarne                                                    |
 * |                                                                                       |
 * | 1 - OS NOVOS MODELO INCLUIDOS NAO DEVERRÃO SER DESENVOLVIDOS DIRETAMENTE NA CLASSE    |
 * | 2 - APENAS SERA INCLUIDO UM ARQUIVO EXTERNO POR MEIO DE include_once                  |
 * | 3 - OS MODELOS NOVOS E ANTIGOS VÃO FICAR NA PASTA fpdf151/impmodelos/                 |
 * | 4 - COLABORE, ORGANIZE O CODIGO, SIGA O PADRÃO                                        |
 * |                                                                                       |
 * +=======================================================================================+
 * |DIRETORIO DOS MODELOS        ===>>> 	fpdf151/impmodelos/                              |
 * |PADRÃO PARA NOME DOS MODELOS ===>>>  mod_imprime<xx>.php ex: mod_imprime1.php          |
 * +=======================================================================================+
 *
 *  MODELO 1   - CARNES DE PARCELAMENTO
 *  MODELO 2   - RECIBO DE PAGAMENTO ( 2 VIAS )
 *  MODELO 3   - ALVARA NÃO DEFINIDO
 *  MODELO 4   - FICHA DE COMPENSACAO
 *  MODELO 5   - AUTORIZAÇÃO DE EMPENHO
 *  MODELO 81   - AUTORIZAÇÃO DE EMPENHO COMPLEMENTO ITEM
 *  MODELO 6   - NOTA DE EMPENHO
 *  MODELO 7   - ORDEM DE PAGAMENTO
 *  MODELO 8   - FICHA DE TRANSFERENCIA DE BENS
 *  MODELO 9   - ALVARÁ DE LOCALIZAÇÃO METADE A4
 *  MODELO 10  - ORDEM DE COMPRA
 *  MODELO 11  - SOLICITAÇÃO DE COMPRA  Itens/Dotaïções
 *  MODELO 12  - ANULAÇÃO DE EMPENHO
 *  MODELO 13  - SOLICITAÇÃO DE ORÇAMENTO
 *  MODELO 14  - AIDOF
 *  MODELO 15  - ESTORNO DE PAGAMENTO
 *  MODELO 16  - CONTRA-CHEQUE 1
 *  MODELO 17  - SOLICITAï¿½ï¿½O DE COMPRA  Dotaï¿½ï¿½es/Itens
 *  MODELO 18  - REQUISIï¿½ï¿½O DE SAï¿½DA DE MATERIAIS
 *  MODELO 19  - EXTRATO DO RPPS
 *  MODELO 20  - ALVARA SANITARIO A4
 *  MODELO 21  - ALVARA SANITARIO METADE A4
 *  MODELO 22  - RECIBO DE PAGAMENTO ( 1 VIAS )
 *  MODELO 23  - ALVARA DE LICENÇA TAMANHO A5
 *  MODELO 24  - ALVARA DE LICENÇA TAMANHO A4
 *  MODELO 25  - GUIA RECOLHIMENTO PREVIDENCIA
 *  MODELO 26  - ALVARA PRE IMPRESSO (BAGE)
 *  MODELO 27  - TERMO DE TRANSFERï¿½NCIA DE MATERIAIS(ALMOXARIFADO)
 *  MODELO 28  - Carne de IPTU parcela unica
 *  MODELO 29  - Certidï¿½o de isenï¿½ï¿½o
 *  MODELO 30  - CARNES DE PARCELAMENTO MODELO DETALHADO
 *  MODELO 31  - CARNES PARA DAEB
 *  MODELO 32  - CARNES PARA guaiba ainda naun liberado (TARCISIO
 *  MODELO 33  - S PRE-IMPRESSO MODELO DE BAGE
 *  MODELO 34  - TERMO DE RESCISAO
 *  MODELO 35  - ALVARA DE LICENCA GRANDE (modelo alternativo para carazino)(A4 com fontes menores)
 *  MODELO 36  - SLIP ANTIGO - 2 PARTES
 *  MODELO 37  - SLIP NOVO - 1 PARTE - COM ASSINATURAS
 *  MODELO 38  - SLIP NOVO MODELO 2 DE OSORIO - SEMELHANTE AO SISTEMA ANTIGO DELES - 1 PARTE - COM ASSINATURAS
 *  MODELO 381 - SLIP - IGUAL AO MODELO 2, POREM IMPRIME OS RECURSOS
 *  MODELO 39  - NOTA DE LIQUIDAÇÃO DE EMPENHO
 *  MODELO 40  - CAPA DO PROCESSO DE PROTOCOLO MODELO PADRÃO
 *  MODELO 41  - CAPA DO PROCESSO DE PROTOCOLO MODELO 1 - ALEGRETE
 *  MODELO 42  - CAPA DO PROCESSO DE PROTOCOLO MODELO 2 - OSORIO
 *  MODELO 43  - ANULAR DE DESPESA (ESTORNO DE PAGAMENTO)
 *  MODELO 44  - ANULAR DE RECEITA (ESTORNO DE RECEITA)
 *  MODELO 45  - RECIBO DE ITBI MODELO PADRAO
 *  MODELO 46  - COMPROVANTE DE RENDIMENTOS
 *  MODELO 47  - GUIA ITBI COM FICHA DE COMPENSAÇÃO
 *  MODELO 48  - FICHA DE COMPENSAÇÃO
 *  MODELO 49  - NOTA FISCAL AVULSA
 *  MODELO 50  - ALVARA PRE-IMPRESSO TAMANHO A4
 *  MODELO 51  -
 *  MODELO 52  -
 *  MODELO 53  -
 *  MODELO 54  -
 *  MODELO 55  -
 *  MODELO 56  - CAPA DO CARNE DE IPTU OU ISSQN
 *  MODELO 57  -
 *  MODELO 58  -
 *  MODELO 59  - ALVARA PRE-IMPRESSO TAMANHO A4 (codigo cnae ao inves de atividades secundarias)
 *  MODELO 60  -
 *  MODELO 61  -
 *  MODELO 62  -
 *  MODELO 63  -ALVARA DE LICENÇA TAMANHO A4 FRENTE/VERSO
 *  MODELO 64  -ALVARA DE LICENÇA TAMANHO A4 PROCESSO/AREA
 *  MODELO 65  -
 *  MODELO 66  - FICHA COMPENS. MARICÁ
 *  MODELO 666 - FICHA COMPENS. MARICÁ
 *  MODELO 67  -
 *  MODELO 68  -
 *  MODELO 69  -
 *  MODELO 70  -
 *  MODELO 71  -
 *  MODELO 72  -
 *  MODELO 73  -
 *  MODELO 74  -
 *  MODELO 75  -
 *  MODELO 76  -
 *  MODELO 77  -
 *  MODELO 78  - EMPENHOS FOLHA
 *  MODELO 99  - ALVARÁ DE LICENÇA, LOCALIZAÇÃO E FUNCIONAMENTO (A4 COM NUMERAÇÃO)
 *  MODELO 100 - MODELO DE RECIBO DE IPTU
 *  MODELO 102 - MODELO DE RECIBO DE IPTU
 *
 */
class db_impcarne extends cl_assinatura
{

    /////   VARIÁVEIS PARA EMISSAO DE CARNES DE PARCELAMENTO - MODELO 1
    public $imprimecapa = null;
    public $mod_rodape = 1;
    public $modelo = 1;
    public $qtdcarne = null;
    public $dtparapag = null;
    public $confirmdtpag = 'f';

    public $tipodebito = 'TIPO DE DÉBITO';
    public $tipoinscr1 = null;
    public $prefeitura = 'PREFEITURA DBSELLER';
    public $secretaria = 'SECRETARIA DE FAZENDA';
    public $debito = null;
    public $logo = null;
    public $motivo = null;
    public $parcela = null;
    public $titulo1 = '';
    public $descr1 = null;
    public $titulo2 = 'Cód de Arrecadação';
    public $descr2 = null;
    public $titulo3 = 'Contribuinte/Endereço';
    public $descr3_1 = null;
    public $descr3_2 = null;
    public $titulo4 = 'Instruções';
    public $descr4_1 = null;
    public $descr4_2 = null;
    public $titulo5 = 'Parcela';
    public $descr5 = null;
    public $titulo6 = 'Vencimento';
    public $descr6 = null;
    public $titulo7 = 'Valor';
    public $descr7 = null;
    public $titulo8 = '';
    public $descr8 = null;
    public $titulo9 = 'Cód. de Arrecadação';
    public $descr9 = null;
    public $titulo10 = 'Parcela';
    public $descr10 = null;
    public $titulo11 = 'Contribuinte/Endereço';
    public $descr11_1 = null;
    public $descr11_2 = null;
    public $titulo12 = 'Instruções';
    public $descr12_1 = null;
    public $descr12_2 = null;
    public $titulo13 = '';
    public $descr13 = null;
    public $titulo14 = 'Vencimento';
    public $descr14 = null;
    public $texto = null;
    public $titulo15 = 'Valor';
    public $descr15 = null;
    public $descr16_1 = null;
    public $descr16_2 = null;
    public $descr16_3 = null;

    public $titulo17 = null;
    public $titulo18 = null;
    public $descr17 = null;
    public $descr18 = null;

    public $linha_digitavel = null;
    public $codigo_barras = null;
    public $objpdf = null;
    public $impmodelo = null;
    public $linhadigitavel = null;

    public $arraycodreceitas = null;
    public $arrayreduzreceitas = null;
    public $arraydescrreceitas = null;
    public $arrayvalreceitas = null;
    public $arraycodhist = null;
    public $arraycodtipo = null;

    public $tipo_convenio = null;

    public $atualizaquant = true;

    // MODELO 56  - CAPA DO CARNE DE IPTU OU ISSQN
    public $cepcapa = null;
    public $dados1 = null;
    public $dados2 = null;
    public $dados3 = null;
    public $dados4 = null;
    public $dados5 = null;
    public $dados6 = null;
    public $dados7 = null;
    public $dados8 = null;
    public $dados9 = null;
    public $dados10 = null;
    public $dados11 = null;
    public $dados12 = null;
    public $dados13 = null;

    //////  VARIï¿½VEIS PARA EMISSAO DE CONTRA-CHEQUES

    public $lotacao = null;
    public $descr_lota = null;
    public $funcao = null;
    public $descr_funcao = null;
    public $mensagem = null;
    public $recordenvelope = 0;
    public $linhasenvelope = 0;
    public $quantidade = null;
    public $valor = null;
    public $tipo = null;
    public $rubrica = null;
    public $descr_rub = null;

    //////  VARIÁVEIS PARA EMISSAO DE RECIBO DE PAGAMENTO - MODELO 2
    public $cgccpf = null;
    public $identifica_dados = "";
    public $enderpref = null;
    public $cgcpref = null;
    public $tipocompl = null;
    public $tipolograd = null;
    public $tipobairro = null;
    public $municpref = null;
    public $telefpref = null;
    public $faxpref = null;
    public $emailpref = null;
    public $nome = null;
    public $ender = null;
    public $compl = null;
    public $munic = null;
    public $uf = null;
    public $fax = null;
    public $contato = null;
    public $cep = null;
    public $tipoinscr = 'Matr/Inscr';
    public $nrinscr = null;
    public $nome_fantasia = null;
    public $nrinscr1 = null;
    public $ip = null;
    public $nomepri = '';
    public $nomepriimo = '';
    public $nrpri = '';
    public $complpri = '';
    public $bairropri = null;
    public $datacalc = null;
    public $taxabanc = 0;
    public $rowspagto = 0;
    public $receita = null;
    public $receitared = null;
    public $dreceita = null;
    public $ddreceita = null;
    public $historico = null;
    public $histparcel = null;
    public $recorddadospagto = 0;
    public $linhasdadospagto = 0;
    public $dtvenc = null;
    public $numpre = null;
    public $valtotal = null;

    // VARIAVEIS PARA EMISSAO PRECO REFERENCIA

    public $inscricaoestadualinstituicao = 0;
    public $codpreco = 0;
    public $precoreferencia = 0;
    public $datacotacao = 0;
    public $pc80_tipoprocesso = 0;
    public $pc80_criterioadjudicacao = 0;
    public $impjust = 0;
    public $tipoprecoreferencia = 0;
    public $rsLotes = null;
    public $sqlitens = null;
    public $quant_casas = 0;
    public $quantLinhas = 0;


    //////  VARIÁVEIS PARA EMISSAO DE ALVARÁ

    public $cabecalhoDet = null;
    public $tipoalvara = null;
    public $obs = null;
    public $ativ = null;
    public $numbloco = null;
    public $descrativ = null;
    public $outrasativs = null;
    public $aCodigosCnae = null;
    public $iAtivPrincCnae = null;
    public $q02_memo = null;
    public $numero = null;
    public $q02_obs = null;
    public $q03_atmemo = null; // obs das atividades
    public $obsativ = null; // obs da atividade principal
    public $processo = null;
    public $datainc = null;
    public $datafim = null;
    public $dtiniativ = null; // data de inicio das atividades
    public $dtfimativ = null; // data de fim das atividades
    public $impdatas = null; // se imprime as datas de inicio e fim das atividades
    public $impobsativ = null; // se imprime a observasï¿½o das atividades
    public $impcodativ = null; // se imprime o codigo das atividades
    public $impobslanc = null; // se imprime a observaï¿½ï¿½o do lanï¿½amento
    public $permanente = null; // se permanente ou provisorio
    public $cnpjcpf = null;
    public $assalvara = null; // assinatura do alvara
    public $lancobs = null; // observaï¿½ï¿½o do lanï¿½amento do alvara de sanitario


    //////  FICHA DE COMPENSACAO

    public $numbanco = '';
    public $bairrocontri = '';
    public $localpagamento = '';
    public $cedente = '';
    public $agencia_cedente = '';
    public $data_documento = '';
    public $numero_documento = '';
    public $especie_doc = '';
    public $aceite = '';
    public $data_processamento = '';
    public $nosso_numero = '';
    public $codigo_cedente = '';
    public $codigo_rua = '';
    public $carteira = '';
    public $especie = '';
    public $valor_documento = '';
    public $instrucoes1 = '';
    public $instrucoes2 = '';
    public $instrucoes3 = '';
    public $totaldesc = 0;
    public $totalrec = 0;
    public $totalacres = 0;
    public $instrucoes4 = '';
    public $instrucoes5 = '';
    public $desconto_abatimento = '';
    public $outras_deducoes = '';
    public $mora_multa = '';
    public $outros_acrecimos = '';
    public $valor_cobrado = '';
    public $sacado1 = '';
    public $sacado2 = '';
    public $sacado3 = '';
    //var $dtparapag        = '';
    //var $descr10          = '';
    public $uf_config = '';

    //// vairaveis para o orcamento
    public $orccodigo = '';
    public $orcdtlim = '';
    public $orchrlim = '';
    public $faxforne = '';
    public $imagemlogo = '';


    //// variaveis para a solicitaï¿½ï¿½o de compras
    public $secfaz = null;  //Nome do secretï¿½rio da fazenda
    public $nompre = null;  //Nome do prefeiro

    public $fonedepto = null;
    public $faxdepto = null;
    public $ramaldepto = null;
    public $emaildepto = null;

    // solicita
    public $Snumero = null;  //número da solicitaï¿½ï¿½o
    public $Snumero_ant = null;  //número da solicitaï¿½ï¿½o
    public $Sdata = null;  //data da solicitaï¿½ï¿½o
    public $Svalor = null;  //valor aproximado da solicitaï¿½ï¿½o
    public $Sorgao = null;  //orgï¿½o
    public $Sunidade = null;  //unidade
    public $sabrevunidade = null;  //unidade abreviada
    public $Sresumo = '';    //resumo da solicitaï¿½ï¿½o
    public $Stipcom = '';    //tipo de compra da solicitaï¿½ï¿½o
    public $Sdepart = '';    //departamento da solicitaï¿½ï¿½o
    public $Srespdepart = '';    //responsï¿½vel pelo departamento
    public $Susuarioger = '';    //Usuário que gerou a solicitaï¿½ï¿½o

    public $cod_concarpeculiar = null;  // Codigo da caracteristica peculiar
    public $descr_concarpeculiar = null;  // Descricao da caracteristica peculiar

    public $Scoddepto = '';    //responsï¿½vel pelo departamento
    public $Sdescrdepto = '';    //responsï¿½vel pelo departamento
    public $Snumdepart = '';    //responsï¿½vel pelo departamento
    public $linhasdosdepart = '';    //responsï¿½vel pelo departamento
    public $resultdosdepart = '';    //responsï¿½vel pelo departamento

    // solicitem
    public $scodpcmater = null;  //codigo do pcmater (quando for informado)
    public $scodunid = null;  //codigo da unidade do item
    public $squantunid = null;  //quantidade de cada unidade (caixa com 10 unidades)
    public $sprazo = '';    //prazo de entrega do item
    public $spgto = '';    //condiï¿½ï¿½es de pagamento do item
    public $sresum = '';    //resumo do item
    public $sjust = '';    //justificativa para a compra do item
    public $sunidade = '';    //unidade (caixa,unitï¿½rio, etc...)
    public $sservico = '';    //se ï¿½ serviï¿½o ou material
    public $svalortot = '';    //valor total (quantidade * valor)
    public $susaquant = '';    //se usa a quantidade ex. caixa (usa quant),unitï¿½rio(não usa)
    public $selemento = '';    //elemento do item da solicitaï¿½ï¿½o
    public $sdelemento = '';    //descriï¿½aï¿½ do elemento do item da solicitaï¿½ï¿½o

    // pcdotac
    public $dcodigo = null;  //código da dotação
    public $dcoddot = null;  //código da dotação
    public $danousu = null;  //ano da dotação
    public $dquant = null;  //quantidade do item na dotação
    public $dvalor = null;  //valor da dotação
    public $delemento = '';    //elemento da dotação
    public $dvalortot = '';    //valor total (quantidade * valor)
    public $dreserva = '';    //se o valor da dotação foi reservado
    public $resultdasdotac = null;  // recordset com dados dos fornecedores
    public $linhasdasdotac = null;  // numero de linhas retornadas no recordsert
    public $dcprojativ = '';
    public $dctiporec = '';
    public $dprojativ = '';
    public $dtiporec = '';
    public $ddescrest = '';

    //pcsugforn
    public $cgmforn = null;       // cgm do fornecedor
    public $nomeforn = '';         // nome do fornecedor
    public $enderforn = '';         // endereco do fornecedor
    public $municforn = '';         // municipio do fornecedor
    public $foneforn = '';         // telefone do fornecedor
    public $numforn = '';         // numforn
    public $resultdosfornec = null;       // recordset com dados dos fornecedores
    public $linhasdosfornec = null;       // numero de linhas retornadas no recordsert

    //labels dos itens do processo do orï¿½amento do processo de compras e orï¿½amento de solicitaï¿½ï¿½o
    public $labtitulo = '';         // se ï¿½ orï¿½amento de solicitaï¿½ï¿½o ou PC
    public $labdados = '';         // se ï¿½ orï¿½amento de solicitaï¿½ï¿½o ou PC
    public $labsolproc = '';         // código do orï¿½amento ou solicitaï¿½ï¿½o
    public $labtipo = '';         // se for solicitaï¿½ï¿½o, label do tipo
    public $declaracao = "";         // Usado para imprimir declaracao no orï¿½amento (OSORIO)

    //// variaveis para a autorizaï¿½ï¿½o de empenho E ORDEM DE COMPRA
    public $assinatura1 = 'VISTO';

    public $assinatura2 = 'TÉCNICO CONTÁBIL';
    public $assinatura3 = 'SECRETÁRIO(A) DA FAZENDA';
    public $assinatura4 = 'SECRETÁRIO DA FAZENDA';
    public $assinaturaprefeito = 'PREFEITO MUNICIPAL';

    public $usa_sub = false;  // a prefeitura utiliza o orcamento no subelemento
    public $telefone = null;    // telefone
    public $nvias = 1;    // ano
    public $ano = null;    // ano
    public $numaut = null;    // numero do empenho
    public $numsol = null;    // numero do empenho
    public $numemp = null;    // numero do empenho
    /*OC4401*/
    public $usuario = null; // Usuário emissor do empenho
    /*FIM - OC4401*/
    public $codemp = null;    // numero do empenho do ano
    public $emissao = null;    // data da emissao
    public $orgao = null;    // data da emissao
    public $descr_orgao = null;    // data da emissao
    public $unidade = null;    // data da emissao
    public $descr_unidade = null;    // data da emissao
    public $subfuncao = null;     // codigo da subfuncao
    public $descr_subfuncao = null;   // descricao da subfuncao
    public $programa = null;     // codigo do programa
    public $descr_programa = null;   // descricao do programa
    public $projativ = null;    // data da emissao
    public $descr_projativ = null;    // data da emissao
    public $sintetico = null;    // data da emissao
    public $descr_sintetico = null;    // data da emissao
    public $recurso = null;    // data da emissao
    public $descr_recurso = null;    // data da emissao
    public $orcado = null;    // data da emissao
    public $saldo_ant = null;    // data da emissao
    public $empenhado = null;    // data da emissao
    public $numcgm = null;    // cgm do fornecedor
    public $banco = null;    // banco
    public $agencia = null;    // agencia
    public $agenciadv = null;    // agencia
    public $conta = null;    // conta
    public $contadv = null;    // conta
    public $dotacao = null;    // dotacao orcamentaria (orgao,unidade,funcao,subfuncao,programa,projativ,elemento,recurso)
    public $descrdotacao = null;    // descricao da dotacao
    public $coddot = null;    // codigo reduzido da despesa
    public $destino = null;    // destino do material ou serviï¿½o
    public $resumo = null;    // destino do material ou serviï¿½o
    public $licitacao = null;    // tipo de licitação
    public $num_licitacao = null;    // numero da licitação
    public $descr_licitacao = null;    // descriï¿½ï¿½o do tipo de licitação
    public $descr_tipocompra = null;    // descriï¿½ï¿½o do tipo de compra
    public $prazo_ent = null;    // prazo de entrega
    //  var $obs		= null;		// observaï¿½ï¿½es
    public $cond_pag = null;    // condiï¿½ï¿½es de pagamento
    public $out_cond = null;    // outras condiï¿½ï¿½es de pagamento
    public $telef_cont = null;    // telefone do contato
    public $recorddositens = null;    // record set dos itens
    public $linhasdositens = null;    // numero de itens da autorizacao
    public $item = null;    // codigo do item
    public $unidadeitem = null;
    public $quantitem = null;    // quantidade do item
    public $valoritem = null;    // valor unitï¿½rio do item
    public $empempenho = null;         // cod empenho para emissï¿½o de ordem de compra
    public $dataordem = null;         // data da geraï¿½ï¿½o da ordem de compra
    public $observacaoitem = null;
    public $descricaoitem = null;
    public $ordpag = null;    // numero da ordem de pagamento
    public $elemento = null;    // elemento da despesa
    public $descr_elemento = null;    // descriï¿½ï¿½o do elemento da despesa
    public $elementoitem = null;    // elemento do item da ordem de pagamento
    public $descr_elementoitem = null;  // descriï¿½ï¿½o do elemento do item da ordem de pagamento
    public $outrasordens = null;    // saldo das outras ordens de pagamento do empenho
    public $vlrrec = null;    // valor das receitas de retenï¿½oes
    public $cnpj = null;         // cpf ou cnpj do credor
    public $anulado = null;         // valor anulado
    public $vlr_anul = null;         // valor anulado
    public $data_est = null;         // data estorno
    public $descr_anu = null;         // descriï¿½ï¿½o da anulaï¿½ï¿½o
    public $Scodemp = null;         // descriï¿½ï¿½o da anulaï¿½ï¿½o
    public $resumo_item = null;         // resumo de item de SC em aut. de licitação
    public $informa_adic = null;         // informaï¿½ï¿½es adicionais de autorizaï¿½ï¿½o: PC - aut. de processo de compras
    public $unid = null; // unidade do item
    public $servico = null; // tipo servico
    public $servicoquantidade = null; // forma de controle do item
    public $autori = null; // Numero da autorizacao
    public $e60_emiss = null; // data da emissao do empenho
    public $pc01_complmater = null; //Descricao do complimento do item
    //                                        AU - somente autorizaï¿½ï¿½o
    public $obs_ordcom_orcamval = null;      // Observacao de ordem de compra lanï¿½a valores

    // Variï¿½veis necessï¿½rias para requisiï¿½ï¿½o de saï¿½da de materiais
    public $Rnumero = null;
    public $Ratendrequi = null;
    public $Rdata = null;
    public $Rdepart = null;
    public $Rhora = null;
    public $Rresumo = null;
    public $Rnomeus = null;

    public $rcodmaterial = null;
    public $rdescmaterial = null;
    public $runidadesaida = null;
    public $rquantdeitens = null;
    public $robsdositens = null;
    public $casadec = null;

    // VARIAVEIS PARA EMISSï¿½O DO CARNE DE IPTU PARCELA UNICA guaiba

    public $iptj23_anousu = '';
    public $iptz01_nome = '';
    public $iptz01_numcgm = '';
    public $iptz01_cgccpf = '';
    public $iptz01_munic = '';
    public $iptz01_cidade = '';
    public $iptz01_bairro = '';
    public $iptbairroimo = '';
    public $iptz01_cep = '';
    public $iptz01_ender = '';
    public $iptj01_matric = '';
    public $iptj23_vlrter = '';
    public $iptj23_aliq = '';
    public $iptk00_percdes = '';
    public $iptj43_cep = '';
    public $iptdtvencunic = '';
    public $iptuvlrcor = '';
    public $ipttotal = '';
    public $iptnomepri = '';
    public $iptcodpri = '';
    public $iptproprietario = '';
    public $iptuvlrdesconto = '';
    public $iptbql = '';
    public $iptcodigo_barras = '';
    public $iptlinha_digitavel = '';
    public $iptdataemis = '';
    public $iptprefeitura = '';
    public $iptdebant = '';
    public $iptsubtitulo = '';

    // VARIAVEIS PARA EMISSï¿½O DA CERTIDï¿½O DE ISENï¿½ï¿½O

    public $isenmatric = '';
    public $isennome = '';
    public $isencgc = '';
    public $isenender = '';
    public $isenbairro = '';
    public $isendtini = '';
    public $isendtfim = '';
    public $isenproc = '';
    public $isenmsg1 = '';
    public $isenmsg2 = '';
    public $isenmsg3 = '';
    public $isenassinatura = '';
    public $isenassinatura2 = '';
    public $isenprefeitura = '';
    public $isensetor = '';
    public $isenquadra = '';
    public $isenlote = '';
    public $cabec_sec = '';

    // VARIAVEIS PARA EMISSAO DE CARNE PRE-IMPRESSO MODELO DE BAGE

    public $predescr3_1 = "";  // contribuinte
    public $predescr3_2 = "";  // endereco
    public $premunic = "";  // municipio
    public $precep = "";  // cep
    public $precgccpf = "";  // cgccpf
    public $predatacalc = "";  // data do recibo
    public $pretitulo8 = "";  // titulo matricula ou inscricao
    public $predescr8 = "";  // descr matricula ou inscricao
    public $pretipolograd = "";  // titulo do logradouro
    public $prenomepri = "";  // nome do logradouro
    public $prenrpri = "";
    public $precomplpri = "";  // numero e complemento
    public $prebairropri = "";  // nome do bairro
    public $pretipobairro = "";  //
    public $pretipocompl = "";
    public $pretipodebito = "";
    public $prehistoricoparcela = "";
    public $predescr4_2 = "";
    public $predescr16_1 = "";
    public $predescr16_2 = "";
    public $predescr16_3 = "";
    public $premsgunica = "";
    public $predescr6 = "";  // Data de Vencimento
    public $predescr7 = "";  // qtd de URM ou valor
    public $predescr9 = "";


    public $loteamento = "";

    // 	VARIAVEIS PARA GUIA ITBI
    public $z01_nome = "";
    public $logoitbi = "";
    public $nomeinst = "";
    public $tipoitbi = "";
    public $datavencimento = "";
    public $it04_descr = "";
    public $numpreitbi = "";
    //var $ano                = "";
    public $itbi = "";
    public $nomecompprinc = "";
    public $outroscompradores = "";
    public $z01_cgccpf = "";
    public $cgccpfcomprador = "";
    public $z01_ender = "";
    public $z01_bairro = "";
    public $enderecocomprador = "";
    public $numerocomprador = "";
    public $complcomprador = "";
    public $z01_munic = "";
    public $z01_uf = "";
    public $z01_cep = "";
    public $municipiocomprador = "";
    public $ufcomprador = "";
    public $cepcomprador = "";
    public $bairrocomprador = "";
    public $it06_matric = "";
    public $j39_numero = "";
    public $j34_setor = "";
    public $j34_quadra = "";
    public $matriz = "";
    public $j34_lote = "";
    public $j13_descr = "";
    public $j14_tipo = "";
    public $j14_nome = "";
    public $it07_descr = "";
    public $it05_frente = "";
    public $it05_fundos = "";
    public $it05_esquerdo = "";
    public $it05_direito = "";
    public $it18_frente = "";
    public $it18_fundos = "";
    public $it18_prof = "";
    public $areaterreno = "";
    public $areatran = "";
    public $areaterrenomat = "";
    //var $areatotal= "";
    public $areaedificadamat = "";
    public $areatotal = "";
    //var $areaedificadamat= "";
    public $areatrans = "";
    public $arrayj13_descr = "";
    public $arrayj13_valor = "";
    public $linhasresultcons = "";
    public $arrayit09_codigo = "";
    public $arrayit10_codigo = "";
    public $arrayit08_area = "";
    public $arrayit08_areatrans = "";
    public $arrayit08_ano = "";
    public $tx_banc = "";
    public $propri = "";
    public $proprietarios = "";
    public $it14_valoravalter = "";
    public $it14_valoravalconstr = "";
    public $it14_valoraval = "";
    public $it14_valoravalterfinanc = "";
    public $it14_valoravalconstrfinanc = "";
    public $it14_valoravalfinanc = "";
    public $it01_valortransacao = "";
    public $it04_aliquotafinanc = "";
    public $it04_aliquota = "";
    public $it14_desc = "";
    public $it14_valorpaga = "";
    //var $arrayj13_descr     = "";
    public $arrayit19_valor = "";
    public $it01_data = "";
    public $linhasitbiruralcaract = "";
    public $outrostransmitentes = "";
    public $it01_obs = "";

    // VARIAVEIS DA CAPA DE PROCESSO
    public $result_vars;


    public $lUtilizaModeloDefault = true;

    /**
     * Variáveis de controle da marca d'agua
     */
    private $lWaterMark = false;
    private $aWaterMark = array();

    public $hasQrCode = false;
    public $qrcode = "";

    /**
     * Limpa os dados da marca d'agua
     */
    public function clearWaterMark()
    {

        $this->lWaterMark = false;
        $this->aWaterMark = array();
    }

    /**
     * Seta uma marca d'agua
     *
     * @param integer $x - Posição inicial
     * @param integer $y - Posição inicial
     * @param string $sTexto - Texto a ser impresso
     * @param float $nDirection - Ângulo de inclinação do texto
     * @param integer $iFontSize - Tamanho da fonte
     * @param integer $iFillColor - Cor de preenchimento
     */
    public function setWaterMark($x, $y, $sTexto, $nDirection, $iFontSize = 150, $iFillColor = 178)
    {

        $this->lWaterMark = true;
        $this->aWaterMark = array(
            'x' => $x,
            'y' => $y,
            'text' => $sTexto,
            'direction' => $nDirection,
            'font' => $iFontSize,
            'fillcolor' => $iFillColor
        );
    }

    /**
     * Imprime a marca d'agua na página atual
     */
    public function printWaterMark()
    {

        if (!$this->lWaterMark) {
            return false;
        }

        $this->objpdf->SetFont('Arial', 'B', $this->aWaterMark['font']);
        $this->objpdf->SetFillColor($this->aWaterMark['fillcolor']);
        $this->objpdf->TextWithRotation($this->aWaterMark['x'], $this->aWaterMark['y'], $this->aWaterMark['text'], $this->aWaterMark['direction']);
    }

    //************************************************************//

    // variaveis para a nota de empenho
    /**
     * Construtor da classe
     * @param object $objpdf - Instancia da classe FPDF
     * @param integer $impmodelo - Numero do Modelo a ser utilizado.
     */
    public function db_impcarne($objpdf, $impmodelo)
    {
        $this->objpdf = $objpdf;
        $this->impmodelo = $impmodelo;
    }

    public function muda_pag($pagina, $xlin, $xcol, $fornec = "false", &$contapagina, $mais = 1, $mod = 1)
    {
        global $resparag, $resparagpadrao, $db61_texto, $db02_texto, $maislin, $xtotal, $flag_rodape;

        $x = false;

        $valor_da_posicao_atual = $this->objpdf->gety();
        $valor_da_posicao_atual += ($mais * 5);
        $valor_da_posicao_atual = (int)$valor_da_posicao_atual;


        $valor_do_tamanho_pagin = $this->objpdf->h;
        $valor_do_tamanho_pagin -= 58;
        $valor_do_tamanho_pagin = (int)$valor_do_tamanho_pagin;

        $valor_do_tamanho_mpagi = $this->objpdf->h;
        $valor_do_tamanho_mpagi -= 30;
        $valor_do_tamanho_mpagi = (int)$valor_do_tamanho_mpagi;

        //    echo "$valor_da_posicao_atual > $valor_do_tamanho_pagin <br>";
        $valor_do_tamanho_pagin = $valor_do_tamanho_pagin - 20;
        if ((($valor_da_posicao_atual > $valor_do_tamanho_pagin) && $contapagina == 1) || (($valor_da_posicao_atual > $valor_do_tamanho_mpagi) && $contapagina != 1)) {
            if ($contapagina == 1) {
                $this->objpdf->Setfont('Arial', '', 9);
                $this->objpdf->text(111.2, $xlin + 224, 'Continua na Página ' . ($contapagina + 1));
                $this->objpdf->setfillcolor(0, 0, 0);

                $this->objpdf->SetFont('Arial', '', 4);
                $this->objpdf->TextWithDirection(1.5, $xlin + 60, $this->texto, 'U'); // texto no canhoto do carne
                $this->objpdf->setfont('Arial', '', 11);
            } else {
                $this->objpdf->Setfont('Arial', '', 9);
                $this->objpdf->text(112.5, $xlin + 271, 'Continua na Página ' . ($contapagina + 1));
            }

            if ($contapagina == 1) {
                $this->objpdf->Setfont('Arial', 'B', 7);
                $sqlparag = "select db02_texto
	                   from db_documento
                 	   	    inner join db_docparag on db03_docum = db04_docum
                    	    inner join db_tipodoc on db08_codigo  = db03_tipodoc
                	        inner join db_paragrafo on db04_idparag = db02_idparag
               	     where db03_tipodoc = 1400 and db03_instit = cast(" . db_getsession("DB_instit") . " as integer) order by db04_ordem ";

                $resparag = @db_query($sqlparag);

                if (@pg_numrows($resparag) > 0) {
                    db_fieldsmemory($resparag, 0);

                    eval($db02_texto);
                    $flag_rodape = true;
                } else {
                    $sqlparagpadrao = "select db61_texto
	                             from db_documentopadrao
                  	   	            inner join db_docparagpadrao  on db62_coddoc   = db60_coddoc
                     	              inner join db_tipodoc         on db08_codigo   = db60_tipodoc
                 	                  inner join db_paragrafopadrao on db61_codparag = db62_codparag
               	               where db60_tipodoc = 1400 and db60_instit = cast(" . db_getsession("DB_instit") . " as integer) order by db62_ordem";

                    $resparagpadrao = @db_query($sqlparagpadrao);

                    if (@pg_numrows($resparagpadrao) > 0) {
                        db_fieldsmemory($resparagpadrao, 0);

                        eval($db61_texto);
                        $flag_rodape = true;
                    }
                }
            }
            $contapagina += 1;
            $this->objpdf->addpage();
            $pagina += 1;
            $muda_pag = true;

            if ($this->lWaterMark) {
                $this->printWaterMark();
            }

            $this->objpdf->settopmargin(1);
            $xlin = 20;
            $xcol = 4;


            $getlogo = db_getnomelogo();
            $logo = ($getlogo == false ? '' : $getlogo);

            // Imprime cabeï¿½alho com dados sobre a prefeitura se mudar de pï¿½gina
            $this->objpdf->setfillcolor(245);
            $this->objpdf->rect($xcol - 2, $xlin - 18, 206, 292, 2, 'DF', '1234');
            $this->objpdf->setfillcolor(255, 255, 255);
            $this->objpdf->Setfont('Arial', 'B', 9);

            $lImprimeTipo = false;

            if (!empty($this->StipoSolicitacao)) {

                $sDescricaoTipo = 'SOLICITAÇÃO DE COMPRA N';
                $iLicitacaoTipo = substr($this->StipoSolicitacao, 0, 1);

                switch ($iLicitacaoTipo) {

                    case '3':
                    case '4':
                    case '6':

                        $sDescricaoTipo = substr($this->StipoSolicitacao, 1, 40);
                        $sDescricaoTipo = mb_convert_case(str_replace('ã', 'Ã', $sDescricaoTipo), MB_CASE_UPPER, "ISO-8859-1");
                        $sDescricaoTipo = mb_convert_case(str_replace('ç', 'Ç', $sDescricaoTipo), MB_CASE_UPPER, "ISO-8859-1");
                        $sRodapeCabecalho = 'SOLICITAÇÃO DE COMPRA N' . CHR(176);
                        $lImprimeTipo = true;
                        break;

                    default:
                        break;
                }

                if ($lImprimeTipo) {
                    $this->objpdf->text(130, $xlin - 13, $sDescricaoTipo);
                } else {

                    $this->objpdf->text(130, $xlin - 13, 'SOLICITAÇÃO DE COMPRA N' . CHR(176));
                    $this->objpdf->text(185, $xlin - 13, db_formatar($this->Snumero, 's', '0', 6, 'e'));
                }
            }

            $this->objpdf->Setfont('Arial', 'B', 7);
            $this->objpdf->text(130, $xlin - 9, 'ORGAO');
            $this->objpdf->text(142, $xlin - 9, ': ' . substr($this->Sorgao, 0, 35));
            $this->objpdf->text(130, $xlin - 5, 'UNIDADE');
            $this->objpdf->text(142, $xlin - 5, ': ' . substr($this->Sunidade, 0, 35));

            if ($lImprimeTipo) {

                $this->objpdf->text(130, $xlin - 2, 'SOLICITAÇÃO DE COMPRA N' . CHR(176));
                $this->objpdf->text(185, $xlin - 2, db_formatar($this->Snumero, 's', '0', 6, 'e'));
            }

            $this->objpdf->Setfont('Arial', 'B', 9);
            $this->objpdf->Image('imagens/files/' . $logo, 15, $xlin - 17, 12);
            $this->objpdf->Setfont('Arial', 'B', 9);
            $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
            $this->objpdf->Setfont('Arial', '', 9);
            $this->objpdf->text(40, $xlin - 11, $this->enderpref);
            $this->objpdf->text(40, $xlin - 8, $this->municpref);
            $this->objpdf->text(40, $xlin - 5, $this->telefpref);
            $this->objpdf->text(40, $xlin - 2, $this->emailpref);
            $this->objpdf->text(40, $xlin + 1, db_formatar($this->cgcpref, 'cnpj'));
            //      $this->objpdf->text(40,$xlin+2,'Continuaï¿½ï¿½o da Pï¿½gina '.($contapagina-1));
            $this->objpdf->text(130, $xlin + 2, 'Página ' . $contapagina);

            $xlin = 0;
            if ((isset($fornec) && $fornec == "false") || !isset($fornec)) {
                $this->objpdf->Setfont('Arial', 'B', 8);

                if ($mod == 1) {

                    // Caixas dos label's
                    $this->objpdf->rect($xcol, $xlin + 24, 10, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 10, $xlin + 24, 12, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 22, $xlin + 24, 22, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 44, $xlin + 24, 98, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 142, $xlin + 24, 30, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 172, $xlin + 24, 30, 6, 2, 'DF', '12');


                    // Caixa dos itens
                    $this->objpdf->rect($xcol, $xlin + 30, 10, 262, 2, 'DF', '34');
                    // Caixa da quantidade
                    $this->objpdf->rect($xcol + 10, $xlin + 30, 12, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 22, $xlin + 30, 22, 262, 2, 'DF', '34');
                    // Caixa dos materiais ou servicos
                    $this->objpdf->rect($xcol + 44, $xlin + 30, 98, 262, 2, 'DF', '34');
                    // Caixa dos valores unitario
                    $this->objpdf->rect($xcol + 142, $xlin + 30, 30, 262, 2, 'DF', '');
                    // Caixa dos valores totais dos iten
                    $this->objpdf->rect($xcol + 172, $xlin + 30, 30, 262, 2, 'DF', '34');

                    $this->objpdf->sety($xlin + 66);
                    $alt = 4;

                    $this->objpdf->Setfont('Arial', 'B', 8);
                    $this->objpdf->text($xcol + 2, $xlin + 28, 'ITEM');
                    $this->objpdf->text($xcol + 11, $xlin + 28, 'QUANT');
                    $this->objpdf->text($xcol + 30, $xlin + 28, 'REF');
                    $this->objpdf->text($xcol + 70, $xlin + 28, 'MATERIAL OU SERVIÇO');
                    $this->objpdf->text($xcol + 145, $xlin + 28, 'VALOR UNITÁRIO');
                    $this->objpdf->text($xcol + 176, $xlin + 28, 'VALOR TOTAL');

                    $maiscol = 0;
                    $xlin = 20;
                    // Seta altura nova para impressão dos dados
                    $this->objpdf->sety($xlin + 11);
                    $this->objpdf->setleftmargin(3);
                    $x = true;
                    $this->objpdf->Setfont('Arial', '', 7);
                } else {

                    // Caixas dos label's
                    $this->objpdf->rect($xcol, $xlin + 32, 10, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 10, $xlin + 32, 30, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 40, $xlin + 32, 25, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 65, $xlin + 32, 107, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 172, $xlin + 32, 30, 6, 2, 'DF', '12');

                    $menos = 0;
                    $getdoy = 32;

                    $this->objpdf->rect($xcol, $xlin + 32, 10, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 10, $xlin + 32, 30, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 40, $xlin + 32, 25, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 65, $xlin + 32, 107, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 172, $xlin + 32, 30, 262, 2, 'DF', '34');

                    $this->objpdf->sety($xlin + 28);

                    // Label das colunas
                    $this->objpdf->Setfont('Arial', 'B', 8);
                    $this->objpdf->text($xcol + 2, $xlin + $getdoy + 4, 'ITEM');
                    $this->objpdf->text($xcol + 14, $xlin + $getdoy + 4, 'QUANTIDADES');
                    $this->objpdf->text($xcol + 50, $xlin + $getdoy + 4, 'REF');
                    $this->objpdf->text($xcol + 105, $xlin + $getdoy + 4, 'MATERIAL OU SERVIÇO');
                    $this->objpdf->text($xcol + 176, $xlin + $getdoy + 4, 'VALOR TOTAL');

                    $maiscol = 0;
                    $xlin = 20;
                    // Seta altura nova para impressão dos dados
                    $this->objpdf->sety($xlin + 20);
                    $this->objpdf->setleftmargin(3);
                    $x = true;
                    $this->objpdf->Setfont('Arial', '', 7);
                }
            } else if (isset($fornec) && $fornec == "true") {
            }
        }
        return $x;
    }

    public function muda_pag2($pagina, $xlin, $xcol, &$contapagina, $mais = 1, $linha)
    {
        global $resparag, $resparagpadrao, $db61_texto, $db02_texto, $maislin, $xtotal, $flag_rodape;

        $x = false;

        $valor_da_posicao_atual = $this->objpdf->gety();
        $valor_da_posicao_atual += ($mais);
        $valor_da_posicao_atual = (int)$valor_da_posicao_atual;


        $valor_do_tamanho_pagin = $this->objpdf->h;
        $valor_do_tamanho_pagin -= 60;
        $valor_do_tamanho_pagin = (int)$valor_do_tamanho_pagin;

        $valor_do_tamanho_mpagi = $this->objpdf->h;
        $valor_do_tamanho_mpagi -= 30;
        $valor_do_tamanho_mpagi = (int)$valor_do_tamanho_mpagi;


        if ((($valor_da_posicao_atual > $valor_do_tamanho_pagin) && $contapagina == 1) || (($valor_da_posicao_atual > $valor_do_tamanho_mpagi) && $contapagina != 1)) {

            $this->objpdf->text(111.2, $xlin + 240, 'Continua na Página ' . ($contapagina + 1));

            if ($contapagina == 1) {
                $this->objpdf->Setfont('Arial', 'B', 7);
                $sqlparag = "select db02_texto
                     from db_documento
                          inner join db_docparag on db03_docum = db04_docum
                          inner join db_tipodoc on db08_codigo  = db03_tipodoc
                          inner join db_paragrafo on db04_idparag = db02_idparag
                     where db03_tipodoc = 1202 and db03_instit = cast(" . db_getsession("DB_instit") . " as integer) order by db04_ordem ";

                $resparag = @db_query($sqlparag);

                if (@pg_numrows($resparag) > 0) {
                    db_fieldsmemory($resparag, 0);

                    eval($db02_texto);
                    $flag_rodape = true;
                } else {
                    $sqlparagpadrao = "select db61_texto
                               from db_documentopadrao
                                    inner join db_docparagpadrao  on db62_coddoc   = db60_coddoc
                                    inner join db_tipodoc         on db08_codigo   = db60_tipodoc
                                    inner join db_paragrafopadrao on db61_codparag = db62_codparag
                               where-30 db60_tipodoc = 1202 and db60_instit = cast(" . db_getsession("DB_instit") . " as integer) order by db62_ordem";

                    $resparagpadrao = @db_query($sqlparagpadrao);

                    if (@pg_numrows($resparagpadrao) > 0) {
                        db_fieldsmemory($resparagpadrao, 0);

                        eval($db61_texto);
                        $flag_rodape = true;
                    }
                }
            }
            $pagina += 1;
            $this->objpdf->addpage();

            $muda_pagina = true;
            $contapagina++;
            $this->objpdf->settopmargin(1);
            $this->objpdf->setleftmargin(4);
            $this->objpdf->sety(16);

            $xlin = 20;
            $xcol = 4;
            $dif = 0;

            $this->objpdf->setfillcolor(245);
            $this->objpdf->rect($xcol - 2, $xlin - 18, 206, 292, 2, 'DF', '1234');

            $getlogo = db_getnomelogo();
            $logo = ($getlogo == false ? '' : $getlogo);

            // Imprime cabeï¿½alho com dados sobre a prefeitura se mudar de pï¿½gina
            $this->objpdf->setfillcolor(255, 255, 255);
            $this->objpdf->Setfont('Arial', 'B', 9);
            $this->objpdf->Image('imagens/files/' . $this->logo, 15, $xlin - 17, 12);
            $this->objpdf->text(130, $xlin - 15, "ORÇAMENTO N" . CHR(176));
            $this->objpdf->text(185, $xlin - 15, db_formatar($this->orccodigo, 's', '0', 6, 'e'));
            $this->objpdf->text(130, $xlin - 11, $this->labdados . CHR(176));
            $this->objpdf->text(185, $xlin - 11, db_formatar($this->Snumero, 's', '0', 6, 'e'));
            $this->objpdf->Setfont('Arial', '', 7);
            $this->objpdf->text(130, $xlin - 8, "Departamento");
            $this->objpdf->text(130, $xlin - 5, "Fone / Ramal");
            $this->objpdf->text(130, $xlin - 2, "Fax");
            $this->objpdf->text(146, $xlin - 8, ":" . $this->coddepto);
            $this->objpdf->text(151, $xlin - 8, "-" . $this->Sdepart);
            $this->objpdf->text(146, $xlin - 5, ": " . $this->fonedepto . " / " . $this->ramaldepto);
            $this->objpdf->text(146, $xlin - 2, ": " . $this->faxdepto);
            $this->objpdf->text(130, $xlin + 1, $this->emaildepto);
            $this->objpdf->text(195, $xlin + 1, "Página " . $this->objpdf->PageNo());
            $this->objpdf->Setfont('Arial', 'B', 9);
            $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
            $this->objpdf->Setfont('Arial', '', 7);
            $this->objpdf->text(40, $xlin - 11, $this->enderpref);
            $this->objpdf->text(40, $xlin - 7, $this->municpref);
            $this->objpdf->text(40, $xlin - 3, $this->emailpref);
            $this->objpdf->text(40, $xlin + 1, "CNPJ:" . db_formatar($this->cgcpref, 'cnpj'));

            $this->objpdf->Setfont('Arial', 'B', 8);
            $dif = 10;

            // Caixas dos label's
            $this->objpdf->rect($xcol, 22, 12, 6, 2, 'DF', '12');
            $this->objpdf->rect($xcol + 12, 22, 15, 6, 2, 'DF', '12');
            $this->objpdf->rect($xcol + 27, 22, 113, 6, 2, 'DF', '12');
            $this->objpdf->rect($xcol + 140, 22, 24, 6, 2, 'DF', '12');
            $this->objpdf->rect($xcol + 164, 22, 19, 6, 2, 'DF', '12');
            $this->objpdf->rect($xcol + 183, 22, 19, 6, 2, 'DF', '12');

            $this->objpdf->rect($xcol, 22, 12, $linha - $dif, 2, 'DF', '34');
            $this->objpdf->rect($xcol + 12, 22, 15, $linha - $dif, 2, 'DF', '34');
            $this->objpdf->rect($xcol + 27, 22, 113, $linha - $dif, 2, 'DF', '34');
            $this->objpdf->rect($xcol + 140, 22, 24, $linha - $dif, 2, 'DF', '34');
            $this->objpdf->rect($xcol + 164, 22, 19, $linha - $dif, 2, 'DF', '34');
            $this->objpdf->rect($xcol + 183, 22, 19, $linha - $dif, 2, 'DF', '34');

            $this->objpdf->text($xcol + 2, $xlin + 6, 'SEQ');
            $this->objpdf->text($xcol + 13, $xlin + 6, 'QUANT');
            $this->objpdf->text($xcol + 56, $xlin + 6, 'MATERIAL OU SERVIÇO');
            $this->objpdf->text($xcol + 145, $xlin + 6, 'MARCA');
            $this->objpdf->text($xcol + 165, $xlin + 6, 'VLR UNIT.');
            $this->objpdf->text($xcol + 184, $xlin + 6, 'VLR TOT.');

            // Seta altura nova para impressão dos dados
            $this->objpdf->sety($xlin + 8);
            $this->objpdf->setleftmargin(3);
            $x = true;
            $this->objpdf->Setfont('Arial', '', 8);

            return $x;
        }
    }

    public function muda_pag3($pagina, $xlin, $xcol, $fornec = "false", &$contapagina, $mais = 1, $mod = 1)
    {
        global $resparag, $resparagpadrao, $db61_texto, $db02_texto, $maislin, $xtotal, $flag_rodape;

        $x = false;

        $valor_da_posicao_atual = $this->objpdf->gety();
        $valor_da_posicao_atual += ($mais * 5);
        $valor_da_posicao_atual = (int)$valor_da_posicao_atual;


        $valor_do_tamanho_pagin = $this->objpdf->h;
        $valor_do_tamanho_pagin -= 58;
        $valor_do_tamanho_pagin = (int)$valor_do_tamanho_pagin;

        $valor_do_tamanho_mpagi = $this->objpdf->h;
        $valor_do_tamanho_mpagi -= 30;
        $valor_do_tamanho_mpagi = (int)$valor_do_tamanho_mpagi;


        if ((($valor_da_posicao_atual > $valor_do_tamanho_pagin) && $contapagina == 1) || (($valor_da_posicao_atual > $valor_do_tamanho_mpagi) && $contapagina != 1)) {
            if ($contapagina == 1) {
                $this->objpdf->Setfont('Arial', '', 9);
                $this->objpdf->text(111.2, $xlin + 224, 'Continua na Página ' . ($contapagina + 1));
                $this->objpdf->setfillcolor(0, 0, 0);

                $this->objpdf->SetFont('Arial', '', 4);
                $this->objpdf->TextWithDirection(1.5, $xlin + 60, $this->texto, 'U'); // texto no canhoto do carne
                $this->objpdf->setfont('Arial', '', 11);
            } else {
                $this->objpdf->Setfont('Arial', '', 9);
                $this->objpdf->text(112.5, $xlin + 271, 'Continua na Página ' . ($contapagina + 1));
            }

            if ($contapagina == 1) {
                $this->objpdf->Setfont('Arial', 'B', 7);
                $sqlparag = "select db02_texto
 	                   from db_documento
                  	   	    inner join db_docparag on db03_docum = db04_docum
                     	    inner join db_tipodoc on db08_codigo  = db03_tipodoc
                 	        inner join db_paragrafo on db04_idparag = db02_idparag
                	     where db03_tipodoc = 1400 and db03_instit = cast(" . db_getsession("DB_instit") . " as integer) order by db04_ordem ";

                $resparag = @db_query($sqlparag);

                if (@pg_numrows($resparag) > 0) {
                    db_fieldsmemory($resparag, 0);

                    eval($db02_texto);
                    $flag_rodape = true;
                } else {
                    $sqlparagpadrao = "select db61_texto
 	                             from db_documentopadrao
                   	   	            inner join db_docparagpadrao  on db62_coddoc   = db60_coddoc
                      	              inner join db_tipodoc         on db08_codigo   = db60_tipodoc
                  	                  inner join db_paragrafopadrao on db61_codparag = db62_codparag
                	               where db60_tipodoc = 1400 and db60_instit = cast(" . db_getsession("DB_instit") . " as integer) order by db62_ordem";

                    $resparagpadrao = @db_query($sqlparagpadrao);

                    if (@pg_numrows($resparagpadrao) > 0) {
                        db_fieldsmemory($resparagpadrao, 0);

                        eval($db61_texto);
                        $flag_rodape = true;
                    }
                }
            }
            $contapagina += 1;
            $this->objpdf->addpage();
            $pagina += 1;
            $muda_pag = true;

            $this->objpdf->settopmargin(1);
            $xlin = 20;
            $xcol = 4;


            $getlogo = db_getnomelogo();
            $logo = ($getlogo == false ? '' : $getlogo);

            // Imprime cabeï¿½alho com dados sobre a prefeitura se mudar de pï¿½gina
            $this->objpdf->setfillcolor(245);
            $this->objpdf->rect($xcol - 2, $xlin - 18, 206, 289, 2, 'DF', '1234');
            $this->objpdf->setfillcolor(255, 255, 255);
            $this->objpdf->Setfont('Arial', 'B', 9);
            $this->objpdf->text(130, $xlin - 13, 'PROCESSO DE COMPRA N' . CHR(176));
            $this->objpdf->text(185, $xlin - 13, db_formatar($this->Snumero, 's', '0', 6, 'e'));
            $this->objpdf->Setfont('Arial', 'B', 7);
            $this->objpdf->text(130, $xlin - 9, 'ORGAO');
            $this->objpdf->text(142, $xlin - 9, ': ' . substr($this->Sorgao, 0, 35));
            $this->objpdf->text(130, $xlin - 5, 'UNIDADE');
            $this->objpdf->text(142, $xlin - 5, ': ' . substr($this->Sunidade, 0, 35));
            $this->objpdf->Setfont('Arial', 'B', 9);
            $this->objpdf->Image('imagens/files/' . $logo, 15, $xlin - 17, 12);
            $this->objpdf->Setfont('Arial', 'B', 9);
            $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
            $this->objpdf->Setfont('Arial', '', 9);
            $this->objpdf->text(40, $xlin - 11, $this->enderpref);
            $this->objpdf->text(40, $xlin - 8, $this->municpref);
            $this->objpdf->text(40, $xlin - 5, $this->telefpref);
            $this->objpdf->text(40, $xlin - 2, $this->emailpref);
            $this->objpdf->text(40, $xlin + 1, db_formatar($this->cgcpref, 'cnpj'));
            //      $this->objpdf->text(40,$xlin+2,'Continuaï¿½ï¿½o da Pï¿½gina '.($contapagina-1));
            $this->objpdf->text(130, $xlin + 2, 'Página ' . $contapagina);

            $xlin = 0;
            if ((isset($fornec) && $fornec == "false") || !isset($fornec)) {
                $this->objpdf->Setfont('Arial', 'B', 8);

                if ($mod == 1) {

                    // Caixas dos label's
                    $this->objpdf->rect($xcol, $xlin + 24, 10, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 10, $xlin + 24, 12, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 22, $xlin + 24, 22, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 44, $xlin + 24, 158, 6, 2, 'DF', '12');
                    //$this->objpdf->rect($xcol + 142, $xlin + 24, 30, 6, 2, 'DF', '12');
                    //$this->objpdf->rect($xcol + 172, $xlin + 24, 30, 6, 2, 'DF', '12');


                    // Caixa dos itens
                    $this->objpdf->rect($xcol, $xlin + 30, 10, 233, 2, 'DF', '34');
                    // Caixa da quantidade
                    $this->objpdf->rect($xcol + 10, $xlin + 30, 12, 233, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 22, $xlin + 30, 22, 233, 2, 'DF', '34');
                    // Caixa dos materiais ou servicos
                    $this->objpdf->rect($xcol + 44, $xlin + 30, 158, 233, 2, 'DF', '34');
                    // Caixa dos valores unitario
                    //$this->objpdf->rect($xcol + 142, $xlin + 30, 30, 262, 2, 'DF', '');
                    // Caixa dos valores totais dos iten
                    //$this->objpdf->rect($xcol + 172, $xlin + 30, 30, 262, 2, 'DF', '34');

                    $this->objpdf->sety($xlin + 66);
                    $alt = 4;

                    $this->objpdf->Setfont('Arial', 'B', 8);
                    $this->objpdf->text($xcol + 2, $xlin + 28, 'ITEM');
                    $this->objpdf->text($xcol + 11, $xlin + 28, 'QUANT');
                    $this->objpdf->text($xcol + 26, $xlin + 28, 'UNIDADE');
                    $this->objpdf->text($xcol + 70, $xlin + 28, 'MATERIAL OU SERVIÇO');
                    //$this->objpdf->text($xcol + 145, $xlin + 28, 'VALOR UNITÁRIO');
                    //$this->objpdf->text($xcol + 176, $xlin + 28, 'VALOR TOTAL');

                    $maiscol = 0;
                    $xlin = 20;
                    // Seta altura nova para impressão dos dados
                    $this->objpdf->sety($xlin + 11);
                    $this->objpdf->setleftmargin(3);
                    $x = true;
                    $this->objpdf->Setfont('Arial', '', 7);
                } else {

                    // Caixas dos label's
                    $this->objpdf->rect($xcol, $xlin + 32, 10, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 10, $xlin + 32, 30, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 40, $xlin + 32, 25, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 65, $xlin + 32, 107, 6, 2, 'DF', '12');
                    $this->objpdf->rect($xcol + 172, $xlin + 32, 30, 6, 2, 'DF', '12');

                    $menos = 0;
                    $getdoy = 32;

                    $this->objpdf->rect($xcol, $xlin + 32, 10, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 10, $xlin + 32, 30, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 40, $xlin + 32, 25, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 65, $xlin + 32, 107, 262, 2, 'DF', '34');
                    $this->objpdf->rect($xcol + 172, $xlin + 32, 30, 262, 2, 'DF', '34');

                    $this->objpdf->sety($xlin + 28);

                    // Label das colunas
                    $this->objpdf->Setfont('Arial', 'B', 8);
                    $this->objpdf->text($xcol + 2, $xlin + $getdoy + 4, 'ITEM');
                    $this->objpdf->text($xcol + 14, $xlin + $getdoy + 4, 'QUANTIDADES');
                    $this->objpdf->text($xcol + 50, $xlin + $getdoy + 4, 'REF');
                    $this->objpdf->text($xcol + 105, $xlin + $getdoy + 4, 'MATERIAL OU SERVIÇO');
                    $this->objpdf->text($xcol + 176, $xlin + $getdoy + 4, 'VALOR TOTAL');

                    $maiscol = 0;
                    $xlin = 20;
                    // Seta altura nova para impressão dos dados
                    $this->objpdf->sety($xlin + 20);
                    $this->objpdf->setleftmargin(3);
                    $x = true;
                    $this->objpdf->Setfont('Arial', '', 7);
                }
            } else if (isset($fornec) && $fornec == "true") {
            }
        }
        return $x;
    }

    public function imprime()
    {

        $sSqlConfig = "select db21_codcli from db_config where codigo =" . db_getsession("DB_instit");
        $rsSqlConfig = db_query($sSqlConfig);
        $sCodCliente = pg_fetch_object($rsSqlConfig, 0);
        $sCodCliente = $sCodCliente->db21_codcli;
        $sCodCliente = str_pad($sCodCliente, 6, 0, STR_PAD_LEFT);
        $sInstit = str_pad(db_getsession("DB_instit"), 2, 0, STR_PAD_LEFT);

        /** Extensao : Inicio [guia-itbi-recibo-mensagem-modelo-codcli15] */
        /** Extensao : Fim [guia-itbi-recibo-mensagem-modelo-codcli15] */


        /**
         * Valida se existe modelo especifico
         */
        if (file_exists("fpdf151/impmodelos/especificos/mod_imprime_especifico_{$this->impmodelo}_{$sCodCliente}{$sInstit}.php")) {
            $this->lUtilizaModeloDefault = false;
            include(Modification::getFile("fpdf151/impmodelos/especificos/mod_imprime_especifico_{$this->impmodelo}_{$sCodCliente}{$sInstit}.php"));
        }

        /**
         * Valida se utiliza modelo default junto com especifico
         */
        if ($this->lUtilizaModeloDefault) {
            include(Modification::getFile("fpdf151/impmodelos/mod_imprime" . $this->impmodelo . ".php"));
        }
    }
}
