<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel por montar as informaes do Envio de Avisos de Licitacao - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class AvisoLicitacaoPNCP extends ModeloBasePNCP
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados = null)
    {
        parent::__construct($dados);
    }

    public function montarDados()
    {
        //ini_set('display_errors', 'on');
        $aDadosAPI = array();

        $oDado = $this->dados;

        $oDadosAPI                                  = new \stdClass;
        $oDadosAPI->codigoUnidadeCompradora         = '01001'; //$oDado->codigounidadecompradora;
        $oDadosAPI->tipoInstrumentoConvocatorioId   = $oDado->tipoinstrumentoconvocatorioid;
        $oDadosAPI->modalidadeId                    = $oDado->modalidadeid;
        if($oDado->modalidadeid == "8" || $oDado->modalidadeid == "9"){
            if($oDado->tipoinstrumentoconvocatorioid == "2"){
                $oDadosAPI->modoDisputaId                   = 4;
            }else{
                $oDadosAPI->modoDisputaId                   = 5;
            }
        }else{
            $oDadosAPI->modoDisputaId                   = $oDado->mododisputaid;
        }
        $oDadosAPI->numeroCompra                    = $oDado->numerocompra;
        $oDadosAPI->anoCompra                       = $oDado->anocompra;
        $oDadosAPI->numeroProcesso                  = $oDado->numeroprocesso;
        $oDadosAPI->objetoCompra                    = utf8_encode($oDado->objetocompra);
        $oDadosAPI->informacaoComplementar          = $oDado->informacaocomplementar;
        $oDadosAPI->srp                             = $oDado->srp == 'f' ? 'false' : 'true';
        $oDadosAPI->justificativaPresencial         = utf8_encode($oDado->justificativapresencial);
        $oDadosAPI->dataAberturaProposta            = $this->formatDate($oDado->dataaberturaproposta);
        $oDadosAPI->dataEncerramentoProposta        = $this->formatDate($oDado->dataencerramentoproposta);
        $oDadosAPI->amparoLegalId                   = $oDado->amparolegalid;
        $oDadosAPI->linkSistemaOrigem               = $oDado->linksistemaorigem;
        //ITENS
        $vlrtotal = 0;
        foreach ($oDado->itensCompra as $key => $item) {
            $vlrtotal = $item->pc11_quant * $item->valorunitarioestimado;

            $oDadosAPI->itensCompra[$key]->numeroItem                  = $item->numeroitem;
            $oDadosAPI->itensCompra[$key]->materialOuServico           = $item->materialouservico;
            $oDadosAPI->itensCompra[$key]->tipoBeneficioId             = $item->tipobeneficioid;
            $oDadosAPI->itensCompra[$key]->incentivoProdutivoBasico    = $item->incentivoprodutivobasico == 'f' ? 'false' : 'true';
            $oDadosAPI->itensCompra[$key]->descricao                   = utf8_encode($item->descricao);
            $oDadosAPI->itensCompra[$key]->quantidade                  = $item->pc11_quant;
            $oDadosAPI->itensCompra[$key]->unidadeMedida               = utf8_encode($item->unidademedida);
            $oDadosAPI->itensCompra[$key]->orcamentoSigiloso           = $item->l21_sigilo == 'f' ? 'false' : 'true';
            $oDadosAPI->itensCompra[$key]->valorUnitarioEstimado       = $item->valorunitarioestimado;
            $oDadosAPI->itensCompra[$key]->valorTotal                  = $vlrtotal;
            //DISPENSA E INEXIGIBILIDADE
            if($oDado->modalidadeid == "8" || $oDado->modalidadeid == "9"){
                $oDadosAPI->itensCompra[$key]->criterioJulgamentoId    = 7;
            }else{
                $oDadosAPI->itensCompra[$key]->criterioJulgamentoId    = $item->criteriojulgamentoid;
            }
            //CONCURSO
            if($oDado->modalidadeid == "3"){
                $oDadosAPI->itensCompra[$key]->criterioJulgamentoId    = 8;
            }
            $oDadosAPI->itensCompra[$key]->itemCategoriaId             = 3;
            //$oDadosAPI->itensCompra[$key]->itemCategoriaId             = $item->itemcategoriaid;
            //$oDadosAPI->itensCompra[$key]->codigoRegistroImobiliario   = utf8_encode($item->codigoregistroimobiliario);
        }

        $aDadosAPI = $oDadosAPI;

        $name = 'Compra' . $oDado->numerocompra . '.json';
        $arquivo = 'model/licitacao/PNCP/arquivos/' . $name;
        if (file_exists($arquivo)) {
            unlink($arquivo);
        }
        file_put_contents($arquivo, json_encode($aDadosAPI));

        /*
        * Anexos da licitacao
        */
        /*$filename = 'model/licitacao/PNCP/arquivos/Compra' . $oDado->numerocompra . '.zip';
        $zip = new ZipArchive();
        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            exit("cannot open <$filename>\n");
        }
        foreach ($oDado->anexos as $key => $anexo) {
            $zip->addFile("model/licitacao/PNCP/anexoslicitacao/" . $anexo->l216_nomedocumento, $anexo->l216_nomedocumento);
        }
        $zip->close();*/
    }

    public function montarRetificacao()
    {
        //ini_set('display_errors', 'on');
        $aDadosAPI = array();

        $oDado = $this->dados;

        $oDadosAPI                                  = new \stdClass;
        //$oDadosAPI->codigoUnidadeCompradora         = '01001';
        $oDadosAPI->tipoInstrumentoConvocatorioId   = $oDado->tipoinstrumentoconvocatorioid;
        $oDadosAPI->modalidadeId                    = $oDado->modalidadeid;
        if($oDado->modalidadeid == "8" || $oDado->modalidadeid == "9"){
            if($oDado->tipoinstrumentoconvocatorioid == "2"){
                $oDadosAPI->modoDisputaId                   = 4;
            }else{
                $oDadosAPI->modoDisputaId                   = 5;
            }
        }else{
            $oDadosAPI->modoDisputaId                   = $oDado->mododisputaid;
        }
        $oDadosAPI->numeroCompra                    = $oDado->numerocompra;
        $oDadosAPI->numeroProcesso                  = $oDado->numeroprocesso;
        $oDadosAPI->situacaoCompraId                = $oDado->situacaocompraid;
        $oDadosAPI->objetoCompra                    = utf8_encode($oDado->objetocompra);
        $oDadosAPI->informacaoComplementar          = $oDado->informacaocomplementar;
        //$oDadosAPI->cnpjOrgaoSubRogado            = $oDado->cnpjOrgaoSubRogado;
        //$oDadosAPI->codigoUnidadeSubRogada        = $oDado->codigoUnidadeSubRogada;
        $oDadosAPI->srp                             = $oDado->srp == 'f' ? 'false' : 'true';
        $oDadosAPI->dataAberturaProposta            = $this->formatDate($oDado->dataaberturaproposta);
        $oDadosAPI->dataEncerramentoProposta        = $this->formatDate($oDado->dataencerramentoproposta);
        $oDadosAPI->amparoLegalId                   = $oDado->amparolegalid;
        $oDadosAPI->linkSistemaOrigem               = $oDado->linksistemaorigem;
        //$oDadosAPI->justificativa                   = $oDado->justificativa;
        $oDadosAPI->justificativaPresencial         = utf8_encode($oDado->justificativapresencial);

        $aDadosAPI = json_encode($oDadosAPI);

        return $aDadosAPI;
    }

    /**
     * Realiza o requisicao na api do PNCP
     *
     * @param \int $tipoDocumento
     * 1  - Aviso de Contratao Direta
     * 2  - Edital
     * 11 - Ata de Registro de Preo
     */

    public function enviarAviso($processo, $anexo)
    {
        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras";

        $method = 'POST';

        $file = 'model/licitacao/PNCP/arquivos/Compra' . $processo . '.json';
        $filezip = curl_file_create('model/licitacao/PNCP/anexoslicitacao/' . $anexo[0]->l216_nomedocumento);

        $cfile = new \CURLFile($file, 'application/json', 'compra');
        //$cfilezip = new \CURLFile($filezip, 'application/zip', 'documento');
        $post_data =  array(
            'compra' => $cfile,
            'documento' => $filezip
        );

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: multipart/form-data',
            'Authorization: ' . $token,
            'Titulo-Documento: ' . utf8_decode($anexo[0]->l213_descricao),
            'Tipo-Documento-Id:' . $anexo[0]->l213_sequencial
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => false,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => $post_data,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        /*$err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;*/
        $retorno = json_decode($contentpncp);

        //enviado de api
        if ($retorno->status) {
            return array(422, $retorno->message);
        }
        //enviado de cadastro
        if($retorno->erros){
            return array(422, $retorno->erros[0]->mensagem);
        }
        //enviado com sucesso
        if($retorno->compraUri){
            return array(201, $retorno->compraUri);
        }
    }

    public function enviarRetificacao($oDados, $sCodigoControlePNCP, $iAnoCompra)
    {
        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP";

        $method = 'PATCH';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => false,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => $oDados,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        /*$err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;*/

        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        return $retorno;
    }

    public function excluirAviso($sCodigoControlePNCP, $iAnoCompra)
    {

        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP";

        $method = 'DELETE';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => false,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            //CURLOPT_POSTFIELDS     => $oDados,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);

        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        return $retorno;
    }

    public function enviarAnexos($iTipoAnexo, $sDescricao, $sAnexo, $iAnoCompra, $iCodigocompra)
    {

        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/" . $iAnoCompra . "/" . $iCodigocompra . "/arquivos";

        $method = 'POST';

        //$file = 'model/licitacao/PNCP/arquivos/Compra' . $processo . '.json';
        //arquivo para envio
        $filezip = curl_file_create('model/licitacao/PNCP/anexoslicitacao/' . $sAnexo);

        $post_data =  array(
            'arquivo' => $filezip
        );

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: multipart/form-data',
            'Authorization: ' . $token,
            'Titulo-Documento: ' . $sDescricao,
            'Tipo-Documento-Id: ' . $iTipoAnexo
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => true,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => $post_data,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );

        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        curl_close($chpncp);

        $retorno = explode(':', $contentpncp);

        if ($retorno[5] == ' https') {
            return array(201, $retorno[6]);
        } else {
            return array(422, "Erro ao enviar anexo");
        }
    }

    public function excluirAnexos($iAnoCompra, $iCodigocompra, $iSeqAnexosPNCP)
    {

        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/$iAnoCompra/$iCodigocompra/arquivos/$iSeqAnexosPNCP";

        $method = 'DELETE';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => false,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            //CURLOPT_POSTFIELDS     => $oDados,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        /*$err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;*/

        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        if ($retorno->status) {
            return array(422, $retorno->message);
        } else {
            return array(201, "Excluido com Sucesso !");
        }
        return $retorno;
    }
}
