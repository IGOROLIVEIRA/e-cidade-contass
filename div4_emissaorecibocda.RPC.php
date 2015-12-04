<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2015  DBSeller Servicos de Informatica
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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("dbforms/db_funcoes.php");
require_once ("libs/JSON.php");
require_once ("fpdf151/PDFDocument.php");
require_once ("fpdf151/fpdf.php");
require_once ("fpdf151/PDFTable.php");

$oJson                      = new services_json();
$oParametros                = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno                   = new stdClass();
$oRetorno->erro             = false;
$oRetorno->aInconsistencias = array();
$oRetorno->aRecibosEmissao  = array();

$oDataVencimento            = new DBDate( $oParametros->dataVencimento );

define("MENSAGENS", "tributario.divida.div4_emissaorecibocda.");

try {


  switch ($oParametros->sExecucao) {

    case "validarReciboCDA":

      db_inicio_transacao();


      $oCartorio = new Cartorio($oParametros->cartorio);
      $oDataUsu  = new DBDate( date("Y-m-d", db_getsession("DB_datausu") ) );

      $aCertidoesInexistentes = array();

      if ( $oParametros->certidaoInicial > $oParametros->certidaoFinal ) {

        $iCertidaoAuxiliar            = $oParametros->certidaoFinal;
        $oParametros->certidaoFinal   = $oParametros->certidaoInicial;
        $oParametros->certidaoInicial = $iCertidaoAuxiliar;
      }

      for ( $i = $oParametros->certidaoInicial; $i <= $oParametros->certidaoFinal; $i++ ) {

        $oCertidao = new Certidao($i);

        if ( is_null( $oCertidao->getSequencial() ) ) {

          $oRetorno->aInconsistencias[] = array(
            "iCertidao"       => $i,
            "sInconsistencia" => urlencode( _M( MENSAGENS . "certidao_inexistente" ) ),
            "lIsErro"         => true
          );

          continue;
        }

        $aCertidaoArrecad = $oCertidao->getArrecad("certid.v13_certid");

        if (empty($aCertidaoArrecad)) {

          $oRetorno->aInconsistencias[] = array(
            "iCertidao"       => $i,
            "sInconsistencia" => urlencode(_M( MENSAGENS . "certidao_fechada" ) ),
            "lIsErro"         => true
          );

          continue;
        }

        $iCertidaoInicial = $oCertidao->getInicial();

        if ( !empty($iCertidaoInicial) ) {

          $oRetorno->aInconsistencias[] = array(
            "iCertidao"       => $i,
            "sInconsistencia" => urlencode(_M( MENSAGENS . "certidao_com_inicial" ) ),
            "lIsErro"         => true
          );

          continue;
        }

        $oCertidaoCartorio = new CertidCartorio( null , $oCertidao->getSequencial() );

        $oCertidaoCartorioRecibo     = "";
        $iCertidaoCartorioSequencial = $oCertidaoCartorio->getSequencial();

        if ( !empty($iCertidaoCartorioSequencial) ) {
          $oCertidaoCartorioRecibo = $oCertidaoCartorio->buscaRecibo();
        }

        if ( !empty($oCertidaoCartorioRecibo) ) {

          if ( $oCartorio->getSequencial() != $oCertidaoCartorio->getCartorio()->getSequencial() ) {

            $oRetorno->aInconsistencias[] = array(
              "iCertidao"       => $i,
              "sInconsistencia" => urlencode( _M( MENSAGENS . "erro_cartorio_diferente"  ) ),
              "lIsErro"         => true
            );

            continue;
          }

          $aAbatimentosCertidao = $oCertidao->getAbatimento();

          if ( !empty($aAbatimentosCertidao) ) {

            $oRetorno->aInconsistencias[] = array(
              "iCertidao"       => $i,
              "sInconsistencia" => urlencode( _M( MENSAGENS . "pagamento_parcial"  ) ),
              "lIsErro"         => false
            );

            $oRetorno->aRecibosEmissao[] = (string) $i;
            continue;
          }

          $oDataRecibo = new DBDate( $oCertidaoCartorioRecibo->k00_dtpaga );

          if ( DBDate::calculaIntervaloEntreDatas( $oDataUsu, $oDataRecibo, 'd' ) < 0 ) {

            $oRetorno->aInconsistencias[] = array(
              "iCertidao"       => $i,
              "sInconsistencia" => urlencode( _M( MENSAGENS . "recibo_valido" ) ),
              "lIsErro"         => false
            );
          }
        }

        $oRetorno->aRecibosEmissao[] = (string) $i;
      }

      break;

    case "emiteReciboCDA":

      $oInstituicao      = new Instituicao(db_getsession('DB_instit'));
      $oCartorio         = new Cartorio($oParametros->iCartorio);
      $lPrimeiraIteracao = true;
      $aDadosRelatorio   = array();

      foreach ($oParametros->aCertidoes as $iCertidao) {

        try {

          db_inicio_transacao();

          $oCertidao = new Certidao($iCertidao);

          /**
           * Verificamos se é a primeira vez que passa no loop para gerar um arquivo pdf novo
           */
          if( $lPrimeiraIteracao ){

            $lNovoPdf    = true;
            $oPdfArquivo = null;
          }

          try {

            $oRegraEmissao  = new regraEmissao(19,
                                               2,
                                               $oInstituicao->getSequencial(),
                                               date("Y-m-d",db_getsession("DB_datausu")),
                                               db_getsession('DB_ip'),
                                               $lPrimeiraIteracao,
                                               $oPdfArquivo);
          } catch (Exception $oErro) {
            throw new BusinessException( _M( MENSAGENS . "erro_regra_emissao" ) );
          }

          $aNumpresNumpar = $oCertidao->getNumpreNumpar();

          try {

            $oRecibo = new Recibo(2, null, 1);

            foreach ($aNumpresNumpar as $aNumpresNumpar) {

              $oRecibo->addNumpre($aNumpresNumpar->numpre, $aNumpresNumpar->numpar);
              $oIdentificacao = CgmFactory::getInstanceByCgm($aNumpresNumpar->numcgm);
            }

            $oDataEmissao    = new DBDate( date("Y-m-d",db_getsession("DB_datausu")) );

            $oRecibo->setNumBco($oRegraEmissao->getCodConvenioCobranca());
            $oRecibo->setDataRecibo( $oDataEmissao->getDate() );
            $oRecibo->setDataVencimentoRecibo($oDataVencimento->getDate());
            $oRecibo->setExercicioRecibo(db_getsession("DB_anousu"));

            $oRecibo->emiteRecibo();

            $iNumnov = $oRecibo->getNumpreRecibo();
          } catch(Exception $oErro) {

            $oStdMensagemErro                  = new stdClass();
            $oStdMensagemErro->codigo_certidao = $iCertidao;
            throw new BusinessException( _M( MENSAGENS . "erro_emite_recibo", $oStdMensagemErro ) );
          }

          $iAnousu = db_getsession("DB_anousu");

          $sSqlValoresPorReceita  = "   select r.k00_numcgm,                                                                 ";
          $sSqlValoresPorReceita .= "          r.k00_dtvenc,                                                                 ";
          $sSqlValoresPorReceita .= "          r.k00_receit,                                                                 ";
          $sSqlValoresPorReceita .= "          upper(t.k02_descr)  as k02_descr,                                             ";
          $sSqlValoresPorReceita .= "          upper(t.k02_drecei) as k02_drecei,                                            ";
          $sSqlValoresPorReceita .= "          r.k00_dtoper as k00_dtoper,                                                   ";
          $sSqlValoresPorReceita .= "          coalesce(upper(k07_descr),' ') as k07_descr,                                  ";
          $sSqlValoresPorReceita .= "          sum(r.k00_valor) as valor,                                                    ";

          $sSqlValoresPorReceita .= "          case                                                                          ";
          $sSqlValoresPorReceita .= "            when taborc.k02_codigo is null                                              ";
          $sSqlValoresPorReceita .= "              then tabplan.k02_reduz                                                    ";
          $sSqlValoresPorReceita .= "            else                                                                        ";
          $sSqlValoresPorReceita .= "              taborc.k02_codrec                                                         ";
          $sSqlValoresPorReceita .= "          end as codreduz,                                                              ";

          $sSqlValoresPorReceita .= "          k00_hist,                                                                     ";
          $sSqlValoresPorReceita .= "          (select (select k02_codigo                                                    ";
          $sSqlValoresPorReceita .= "                     from tabrec                                                        ";
          $sSqlValoresPorReceita .= "                    where k02_recjur = k00_receit                                       ";
          $sSqlValoresPorReceita .= "                       or k02_recmul = k00_receit limit 1                               ";
          $sSqlValoresPorReceita .= "                   ) is not null                                                        ";
          $sSqlValoresPorReceita .= "          ) as codtipo                                                                  ";

          $sSqlValoresPorReceita .= "     from recibopaga r                                                                  ";
          $sSqlValoresPorReceita .= "          inner join tabrec t on t.k02_codigo       = r.k00_receit                      ";
          $sSqlValoresPorReceita .= "          inner join tabrecjm on tabrecjm.k02_codjm = t.k02_codjm                       ";
          $sSqlValoresPorReceita .= "          left join tabdesc   on k07_codigo         = t.k02_codigo                      ";
          $sSqlValoresPorReceita .= "                             and k07_instit         = {$oInstituicao->getSequencial()}  ";
          $sSqlValoresPorReceita .= "          left join taborc    on t.k02_codigo       = taborc.k02_codigo                 ";
          $sSqlValoresPorReceita .= "                             and taborc.k02_anousu  = {$iAnousu}                        ";
          $sSqlValoresPorReceita .= "          left join tabplan   on t.k02_codigo       = tabplan.k02_codigo                ";
          $sSqlValoresPorReceita .= "                             and tabplan.k02_anousu = {$iAnousu}                        ";
          $sSqlValoresPorReceita .= "    where r.k00_numnov = {$iNumnov}                                                     ";
          $sSqlValoresPorReceita .= " group by r.k00_dtoper,                                                                 ";
          $sSqlValoresPorReceita .= "          r.k00_dtvenc,                                                                 ";
          $sSqlValoresPorReceita .= "          r.k00_receit,                                                                 ";
          $sSqlValoresPorReceita .= "          t.k02_descr,                                                                  ";
          $sSqlValoresPorReceita .= "          t.k02_drecei,                                                                 ";
          $sSqlValoresPorReceita .= "          r.k00_numcgm,                                                                 ";
          $sSqlValoresPorReceita .= "          k07_descr,                                                                    ";
          $sSqlValoresPorReceita .= "          codreduz,                                                                     ";
          $sSqlValoresPorReceita .= "          r.k00_hist                                                                    ";

          $rsValoresPorReceita = db_query($sSqlValoresPorReceita);

          $iNumnovFormatado = db_sqlformatar($iNumnov,8,'0');
          $iNumnovFormatado = $iNumnovFormatado.db_CalculaDV($iNumnovFormatado);

          $iValorBarra = db_formatar(str_replace('.', '', str_pad(number_format($oRecibo->getTotalRecibo(), 2, "", "."), 11, "0", STR_PAD_LEFT)), 's', '0', 11, 'e');

          $iTerceiroDigito = 6;

          $oConvenio = new convenio($oRegraEmissao->getConvenio(), $iNumnov, 0, $oRecibo->getTotalRecibo(), $iValorBarra, $oDataVencimento->getDate(), $iTerceiroDigito);

          $oPdf                  = $oRegraEmissao->getObjPdf();
          $oPdf->linha_digitavel = $oConvenio->getLinhaDigitavel();
          $oPdf->codigobarras    = $oConvenio->getCodigoBarra();

          // Identificação Prefeitura
          $oPdf->logo            = $oInstituicao->getImagemLogo();
          $oPdf->prefeitura      = $oInstituicao->getDescricao();
          $oPdf->tipo_convenio   = $oConvenio->getTipoConvenio();
          $oPdf->uf_config       = $oInstituicao->getUf();
          $oPdf->enderpref       = $oInstituicao->getLogradouro();
          $oPdf->municpref       = $oInstituicao->getMunicipio();
          $oPdf->telefpref       = $oInstituicao->getTelefone();
          $oPdf->emailpref       = $oInstituicao->getEmail();
          $oPdf->cgcpref         = $oInstituicao->getCNPJ();

          // Indentificação contribuinte
          $sLogradouro  = $oIdentificacao->getLogradouro();
          $sNome        = $oIdentificacao->getNome();
          $sComplemento = $oIdentificacao->getComplemento();
          $sNumCgm      = $oIdentificacao->getCodigo();
          $sMunicipio   = $oIdentificacao->getMunicipio();
          $iNumero      = $oIdentificacao->getNumero();
          $sBairro      = $oIdentificacao->getBairro();
          $sCep         = $oIdentificacao->getCep();

          if( $oIdentificacao->isFisico() ){
            $sCnpjCpf   = $oIdentificacao->getCpf();
          }
          if( $oIdentificacao->isJuridico() ){
            $sCnpjCpf   = $oIdentificacao->getCnpj();
          }

          /**
           * Quadro Identificação
           */
          $oPdf->descr11_1          = $oPdf->nome  = $sNome;
          $oPdf->descr11_2          = $oPdf->ender = $sLogradouro;
          $oPdf->munic              = $sMunicipio;
          $oPdf->bairrocontri       = $sBairro;
          $oPdf->cep                = $sCep;
          $oPdf->cgccpf             = $sCnpjCpf;

          /**
           * Quadro Direito
           */
          $oPdf->tipoinscr          = "Numcgm :";
          $oPdf->nrinscr            = "$sNumCgm";
          $oPdf->tipolograd         = "Logradouro : {$sLogradouro}";
          $oPdf->nomepriimo         = $sLogradouro;
          $oPdf->tipocompl          = 'N' . chr(176) . "/Compl :";
          $oPdf->complpri           = $sComplemento;
          $oPdf->nrpri              = $iNumero;
          $oPdf->tipobairro         = "Bairro :";
          $oPdf->bairropri          = $sBairro;

          $oPdf->datacalc           = date('d/m/Y', db_getsession('DB_datausu')) . " ";
          $oPdf->predatacalc        = date('d/m/Y', db_getsession('DB_datausu')) . " ";

          /**
           * Valores por Receita
           */
          $iTotalReceitas = pg_num_rows($rsValoresPorReceita);

          /**
           * Verifica limite de receitas para o modelo especifico
           */
          if ($iTotalReceitas >= 50 ){

            $oStdMensagemErro                  = new stdClass();
            $oStdMensagemErro->codigo_certidao = $iCertidao;
            throw new BusinessException( _M( MENSAGENS . "limite_receitas", $oStdMensagemErro ) );
          }
          for ($iIndice = 0; $iIndice < $iTotalReceitas; $iIndice++) {

            $oLinhaReceita = db_utils::fieldsMemory($rsValoresPorReceita, $iIndice);
            $oPdf->arraycodtipo[$iIndice]       = $oLinhaReceita->codtipo;
            $oPdf->arraycodhist[$iIndice]       = $oLinhaReceita->k00_hist;
            $oPdf->arraycodreceitas[$iIndice]   = $oLinhaReceita->k00_receit;
            $oPdf->arrayreduzreceitas[$iIndice] = $oLinhaReceita->codreduz;
            $oPdf->arraydescrreceitas[$iIndice] = $oLinhaReceita->k02_drecei;
            $oPdf->arrayvalreceitas[$iIndice]   = $oLinhaReceita->valor;
          }

          $oPdf->descr12_1          = $oPdf->historico  = "Certidão do Foro";
          $oPdf->histparcel         = "Histórico das parcelas";
          $oPdf->dtparapag          = $oPdf->dtvenc     = $oDataVencimento->getDate(DBDate::DATA_PTBR);

          /**
           * Ficha de Compensação
           */
          $oPdf->descr9             = db_numpre($iNumnovFormatado, 0) . db_formatar(0, 's', "0", 3, "e");
          $oPdf->predescr9          = db_numpre($iNumnovFormatado, 0) . db_formatar(0, 's', "0", 3, "e");

          $oDadoDBBancos            = new cl_db_bancos;
          $rsConsultaBanco          = $oDadoDBBancos->sql_record($oDadoDBBancos->sql_query_file($oConvenio->getCodBanco()));
          $oBanco                   = db_utils::fieldsMemory($rsConsultaBanco,0);
          $oPdf->numbanco           = $oBanco->db90_codban."-".$oBanco->db90_digban;
          $oPdf->banco              = $oBanco->db90_abrev;
          $oPdf->imagemlogo         = $oConvenio->getImagemBanco();

          $oPdf->sMensagemCaixa     = '';

          /**
           * Parcela
           */
          $oPdf->descr10            = '1/1';

          $oPdf->valtotal           = db_formatar($oRecibo->getTotalRecibo(),'f');
          $oPdf->linhadigitavel     = $oConvenio->getLinhaDigitavel();
          $oPdf->codigo_barras      = $oPdf->codigobarras  = $oConvenio->getCodigoBarra();

          $oPdf->data_processamento = date('d/m/Y'); // Data do servidor
          $oPdf->agencia_cedente    = $oConvenio->getAgenciaCedente();
          $oPdf->carteira           = $oConvenio->getCarteira();
          $oPdf->nosso_numero       = $oConvenio->getNossoNumero();
          $oPdf->especie            = 'R$';
          $oPdf->tipo_exerc         = '19 / ' . $iAnousu; //Fixo Certidão de Divida Ativa
          $oPdf->imprime();

          $aDadosRelatorio[]  = array(
            'iCertidao'    => $iCertidao,
            'sNome'        => $sNome,
            'iArrecadacao' => $oPdf->descr9,
            'iValor'       => db_formatar($oRecibo->getTotalRecibo(),'f')
          );

          try{

            $oCertidaoCartorio = new CertidCartorio( null, $oCertidao->getSequencial(), $oCartorio->getSequencial() );

            if ( is_null($oCertidaoCartorio->getSequencial()) ) {

              $oCertidaoCartorio->setCartorio($oCartorio);
              $oCertidaoCartorio->setCertidao($oCertidao);
              $oCertidaoCartorio->incluir(null);
            }
          } catch (Exception $oErro) {
            throw new BusinessException( _M( MENSAGENS . "erro_incluir_certidcartorio" ) );
          }

          try {

            $oCertidCartorioReciboPaga = new CertidCartorioReciboPaga();
            $oCertidCartorioReciboPaga->setCertidCartorio($oCertidaoCartorio);
            $oCertidCartorioReciboPaga->setNumnov($iNumnov);
            $oCertidCartorioReciboPaga->incluir(null);
          } catch (Exception $oErro) {
            throw new BusinessException( _M( MENSAGENS . "erro_incluir_certidcartoriorecibopaga" ) );
          }

          try {

            $oCertidMovimentacao = new CertidMovimentacao();
            $oCertidMovimentacao->setCertidCartorio( $oCertidaoCartorio );
            $oCertidMovimentacao->setDataMovimentacao( $oDataEmissao );
            $oCertidMovimentacao->setTipo( CertidMovimentacao::TIPO_MOVIMENTACAO_ENVIADO );
            $oCertidMovimentacao->incluir( null );
          } catch (Exception $oErro) {
            throw new BusinessException( _M( MENSAGENS . "erro_incluir_certidmovimentacao" ) );
          }

          $oPdfArquivo              = $oPdf->objpdf;
          $lPrimeiraIteracao        = false;

        } catch (BusinessException $oErro) {

          throw new Exception( $oErro->getMessage() );
        }
      }

      /**
       * Iniciamos geração do relatório
       */
      $oPdfRelatorio = new PDFTable();
      $oPdfRelatorio->setPercentWidth(true);
      $oPdfRelatorio->setHeaders( array( "Código da Certidão", "Identificação", "Código de Arrecadação", "Valor" ) );
      $oPdfRelatorio->setColumnsAlign( array( PDFDocument::ALIGN_CENTER,
                                              PDFDocument::ALIGN_LEFT,
                                              PDFDocument::ALIGN_CENTER,
                                              PDFDocument::ALIGN_CENTER ) );
      $oPdfRelatorio->setColumnsWidth(array( "15", "55", "15", "15"));

      foreach ($aDadosRelatorio as $aDadoCdaRecibo) {

        $aLinha = array( $aDadoCdaRecibo['iCertidao'],
                         $aDadoCdaRecibo['sNome'],
                         $aDadoCdaRecibo['iArrecadacao'],
                         trim( $aDadoCdaRecibo['iValor'] ) );
        $oPdfRelatorio->addLineInformation( $aLinha );
      }

      $oPdfDocument = new PDFDocument(PDFDocument::PRINT_PORTRAIT);
      $oPdfDocument->addHeaderDescription("Relatório de Recibos por CDA");
      $oPdfDocument->addHeaderDescription("");
      $oPdfDocument->addHeaderDescription("Cartório: {$oCartorio->getDescricao()}");
      $oPdfDocument->addHeaderDescription("Data de Vencimento dos Recibos: {$oDataVencimento->getDate( DBDate::DATA_PTBR )}");
      $oPdfDocument->SetFillColor(235);
      $oPdfDocument->open();

      $oPdfRelatorio->printOut($oPdfDocument,  false);

      $sNomeArquivoRelatorio = "relatorio_recibo_cda_" . time();
      $sNomeArquivoRelatorio = $oPdfDocument->savePDF($sNomeArquivoRelatorio);

      /**
       * Retorna arquivos gerados
       */
      $sNomeArquivo  = "tmp/recibo_certidao_extrajudicial_" . time() . ".pdf";
      $oPdf->objpdf->Output($sNomeArquivo, false, true);

      $oRetorno->sNomeArquivoRecibos   = $sNomeArquivo;
      $oRetorno->sNomeArquivoRelatorio = $sNomeArquivoRelatorio;

      $oRetorno->sMensagem = urlencode( _M( MENSAGENS . 'emissao_sucesso' ) );

      break;
  }

  db_fim_transacao(false);

} catch (Exception $eErro){

  db_fim_transacao(true);
  $oRetorno->erro      = true;
  $oRetorno->sMensagem = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);