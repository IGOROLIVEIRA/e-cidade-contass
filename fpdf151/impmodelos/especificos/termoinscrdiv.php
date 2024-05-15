<?php

class pdftermoinscr extends pdf3
{

    public $cgmorigem;
    public $lTotaliza;
    public $oDocumento;

    CONST COD_DOCUMENTO = 48;
    CONST COD_TIPO_DOCUMENTO = 1008;

    public function __construct()
    {
        parent::__construct();
        $this->getInstaceLibDocumento();
        $this->oDocumento->getParagrafos();
    }

    /**
     * Verifica se é necessário fazer a quebra de pagina
     * @return void
     */
    private function _addPage()
    {
        if ($this->gety() > $this->h - 66) {

            $this->addPage();
        }
    }

    /**
     * override do metodo
     */
    public function Header()
    {

        $sql = "select nomeinst,
                bairro,
                cgc,
                trim(ender)||','||trim(cast(numero as text)) as ender,
                upper(munic) as munic,
                uf,
                telef,
                email,
                url,
                logo,
                db12_extenso
                from db_config
                inner join db_uf on db12_uf = uf
                where codigo = " . db_getsession("DB_instit");

        $result = db_query($sql);

        global $nomeinst;
        global $db12_extenso;
        global $logo;
        global $lImpFolha;

        db_fieldsmemory($result, 0);
        $db12_extenso = pg_result($result, 0, "db12_extenso");

        // seta a margem esquerda que veio do relatorio
        $S = $this->lMargin;
        $this->SetLeftMargin(10);
        $Letra = 'Times';
        $posini = 20;

        $this->Image('imagens/files/' . $logo, $posini - 10, 8, 24);
        $this->Ln(5);
        $this->SetFont($Letra, '', 10);
        $this->MultiCell(0, 4, $db12_extenso, 0, "C", 0);
        $this->SetFont($Letra, 'B', 10);
        $this->MultiCell(0, 6, $nomeinst, 0, "C", 0);
        $this->SetFont($Letra, 'B', 12);
        $this->MultiCell(0, 4, @$GLOBALS["head1"], 0, "C", 0);
        $this->SetLeftMargin($S);
        $this->Ln(1);

        $this->SetY(35);
        $this->setfont('arial', 'b', 11);
        $this->multicell(0, 4, "TERMO DE INSCRIÇÃO EM DIVIDA ATIVA ", 0, "C", 0, 0);
        $this->setfont('arial', '', 11);
        $this->ln(3);
    }

    /**
     * Desenha o quadro dos devedores
     * @return Void
     */
    public function drawDevedores()
    {

        $this->setfont('arial', 'B', 10);

        $this->cell(190, 5, 'DEVEDOR', 0, 1, "C", 0);
        $this->cell(190, 0.7, '', "TB", 1, "L", 0);
        $this->Ln(5);

        $this->setfont('arial', 'B', 10);

        $this->cell(30, 5, 'TIPO', "TB", 0, "L", 0);
        $this->cell(110, 5, 'NOME', 1, 0, "L", 0);
        $this->cell(20, 5, 'CGM ', 1, 0, "L", 0);
        $this->cell(30, 5, 'CPF/CNPJ', "TB", 1, "L", 0);

        $this->setfont('arial', '', 10);

        $aDadosDevedor = $this->getDevedoresEnvolvidos();

        foreach ($aDadosDevedor->aDevedores as $oDevedor) {

            $this->setfont('arial', '', 8);
            $this->cell(30, 3, substr($oDevedor->tipo, 0, 15), 0, 0, "L", 0);
            $this->Cell(110, 3, $oDevedor->nome, 0, 0, "L", 0);
            $this->Cell(20, 3, $oDevedor->numcgm, 0, 0, "L", 0);
            $this->Cell(30, 3, $oDevedor->cgcCpf, 0, 1, "L", 0);

            $this->setfont('arial', '', 8);
            $this->MultiCell(190, 3, $oDevedor->endereco . " Fone: " . $oDevedor->telefone, "B", "L", 0);
            $this->setfont('arial', '', 10);
        }
    }

    public function getOrigensDebito()
    {
        return $this->getOrigemDebitoDivida();
    }

    /**
     *
     */
    protected function getOrigemDebitoDivida()
    {
        if(empty($this->cgmorigem)){
            db_redireciona('db_erros.php?fechar=true&db_erro=CGM não informado.');
        }
        $sqlOrigemMatric = "  select v01_numpre as numpre,                                                ";
        $sqlOrigemMatric .= "         v01_numpar as numpar,                                                ";
        $sqlOrigemMatric .= "         coalesce(arrematric.k00_matric,0) as matric,                         ";
        $sqlOrigemMatric .= "         coalesce(arreinscr.k00_inscr,0) as inscr,                            ";
        $sqlOrigemMatric .= "               k00_numcgm as numcgm                                           ";
        $sqlOrigemMatric .= "    from divida                                                               ";
        $sqlOrigemMatric .= "         left join arrematric  on arrematric.k00_numpre = divida.v01_numpre   ";
        $sqlOrigemMatric .= "         left join arreinscr   on arreinscr.k00_numpre  =  divida.v01_numpre  ";
        $sqlOrigemMatric .= "         left join arrenumcgm  on arrenumcgm.k00_numpre  =  divida.v01_numpre ";
        $sqlOrigemMatric .= "   where v01_numcgm = {$this->cgmorigem}                                      ";
        $sqlOrigemMatric .= "                          and v01_instit = " . db_getsession('DB_instit') . "     ";
        $sqlOrigemMatric .= "   order by v01_numpre,v01_numpar                                             ";

        $rsOrigemDebitos = db_query($sqlOrigemMatric);
        $aOrigem = array();
        $aOrigem = db_utils::getCollectionByRecord($rsOrigemDebitos);
        if(empty($aOrigem)){
            db_redireciona('db_erros.php?fechar=true&db_erro=O contribuinte informado não possui Dívida ativa.');
        }
        return $aOrigem;
    }

    public function getDevedoresEnvolvidos($sTipoEndereco = 'o')
    {
        $aParams = db_stdClass::getParametro("pardiv", array(db_getsession("DB_instit")));

        if (count($aParams) == 0) {
            throw new Exception("Sem parametros para o módulo dívida configurados");
        }

        $oPardiv = $aParams[0];

        $sExpressaoFalecimento = "";
        if ($oPardiv->v04_confexpfalec != 2) {
            $sExpressaoFalecimento = $oPardiv->v04_expfalecimentocda;
        }

        if ($oPardiv->v04_envolprinciptu == "f") {
            $lRegra = "false";
        } else {
            $lRegra = "true";
        }

        $aMatric = array();
        $aInscr = array();
        $aCgm = array();
        $aImoveisEnvolvidos = array();
        $aEmpresasEnvolvidos = array();
        $aDevedoresEnvolvidos = array();
        $aOrigens = $this->getOrigensDebito();

        foreach ($aOrigens as $oOrigens) {

            if ($oOrigens->matric > 0 && in_array($oOrigens->matric, $aMatric)) {
                continue;
            } else {

                if ($oOrigens->matric > 0) {

                    /**
                     * Procuramos o texto para o possuidor da matricula
                     */
                    $sqlPossuidor = " select j18_textoprom                           ";
                    $sqlPossuidor .= "   from cfiptu                                  ";
                    $sqlPossuidor .= "  where j18_anousu= " . db_getsession("DB_anousu");
                    $resultPossuidor = db_query($sqlPossuidor);
                    $linhasPossuidor = pg_num_rows($resultPossuidor);
                    $possuidor = "POSSUIDOR";
                    if ($linhasPossuidor > 0) {

                        $oTextoPossuido = db_utils::fieldsmemory($resultPossuidor, 0);
                        if (trim($oTextoPossuido->j18_textoprom) != "") {
                            $possuidor = $oTextoPossuido->j18_textoprom;
                        }
                    }

                    /**
                     * Buscamos as matriculas da divida
                     */
                    $sSqlEnvol = " select * from fc_busca_envolvidos({$lRegra},{$oPardiv->v04_envolcdaiptu},'M',{$oOrigens->matric})";
                    $rsEnvol = db_query($sSqlEnvol) or die($sSqlEnvol);
                    $iLinhasEnvol = pg_num_rows($rsEnvol);
                    if ($oPardiv->v04_envolcdaiptu == 2 && $iLinhasEnvol == 0) {

                        $sSqlEnvol = " select j01_numcgm as rinumcgm,   ";
                        $sSqlEnvol .= "        1          as ritipoenvol ";
                        $sSqlEnvol .= "   from iptubase                  ";
                        $sSqlEnvol .= "  where j01_matric = {$oOrigens->matric}    ";
                        $rsEnvol = db_query($sSqlEnvol) or die($sSqlEnvol);
                        $iLinhasEnvol = pg_num_rows($rsEnvol);

                    }

                    for ($i = 0; $i < $iLinhasEnvol; $i++) {

                        $oDevedor = new stdClass();
                        $oEnvol = db_utils::fieldsMemory($rsEnvol, $i);

                        $sSqlDadosEnvol = " select z01_numcgm,                     ";
                        $sSqlDadosEnvol .= "        z01_nome,                       ";
                        $sSqlDadosEnvol .= "        z01_cgccpf,                     ";
                        $sSqlDadosEnvol .= "        z01_telef,                      ";
                        $sSqlDadosEnvol .= "        z01_ender,                      ";
                        $sSqlDadosEnvol .= "        z01_numero,                     ";
                        $sSqlDadosEnvol .= "        z01_compl,                      ";
                        $sSqlDadosEnvol .= "        z01_bairro,                     ";
                        $sSqlDadosEnvol .= "        z01_munic,                      ";
                        $sSqlDadosEnvol .= "        z01_cep,                        ";
                        $sSqlDadosEnvol .= "        z01_uf,                         ";
                        $sSqlDadosEnvol .= "        z01_dtfalecimento               ";
                        $sSqlDadosEnvol .= "   from cgm                             ";
                        $sSqlDadosEnvol .= "  where z01_numcgm = {$oEnvol->rinumcgm}";
                        $rsDadosEnvol = db_query($sSqlDadosEnvol) or die($sSqlDadosEnvol);
                        $iLinhasDadosEnvol = pg_num_rows($rsDadosEnvol);
                        if ($iLinhasDadosEnvol > 0) {

                            $oDadosEnvol = db_utils::fieldsMemory($rsDadosEnvol, 0);
                            if (trim($oDadosEnvol->z01_dtfalecimento) != '' && strlen($oDadosEnvol->z01_cgccpf) == 11
                                && $oDadosEnvol != '00000000000'
                            ) {
                                $oDevedor->nome = $sExpressaoFalecimento . " " . $oDadosEnvol->z01_nome;
                            } else {
                                $oDevedor->nome = $oDadosEnvol->z01_nome;
                            }
                            $oDevedor->numcgm = $oDadosEnvol->z01_numcgm;
                            $oDevedor->telefone = $oDadosEnvol->z01_telef;
                            $oDevedor->endereco = "";
                            $oDevedor->endereco = $oDadosEnvol->z01_ender;
                            if (trim($oDadosEnvol->z01_numero) != "0" and trim($oDadosEnvol->z01_numero) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->z01_numero} ";
                            }
                            if (trim($oDadosEnvol->z01_compl) != "0" and trim($oDadosEnvol->z01_compl) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->z01_compl} ";
                            }
                            if (trim($oDadosEnvol->z01_bairro) != "0" and trim($oDadosEnvol->z01_bairro) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->z01_bairro} ";
                            }
                            if (trim($oDadosEnvol->z01_munic) != "0" and trim($oDadosEnvol->z01_munic) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->z01_munic}/{$oDadosEnvol->z01_uf} ";
                            }
                            if (trim($oDadosEnvol->z01_cep) != "0" and trim($oDadosEnvol->z01_cep) != "") {
                                $oDevedor->endereco .= "- CEP {$oDadosEnvol->z01_cep} .";
                            }

                            /**
                             * Verifica o tipo do Devedor
                             */
                            if ($oEnvol->ritipoenvol == "1" || $oEnvol->ritipoenvol == "2") {
                                $oDevedor->tipo = "PROPRIETÁRIO";
                            } else {
                                $oDevedor->tipo = $possuidor;
                            }

                            if (strlen($oDadosEnvol->z01_cgccpf) == 14) {
                                $oDevedor->cgcCpf = db_formatar($oDadosEnvol->z01_cgccpf, "cnpj");
                            } else {
                                $oDevedor->cgcCpf = db_formatar($oDadosEnvol->z01_cgccpf, "cpf");
                            }
                            $aDevedoresEnvolvidos[] = $oDevedor;
                        }
                    }

                    /**
                     * Retornamos os dados do imovel
                     */
                    $sSqlProprietario = " select *                    ";
                    $sSqlProprietario .= "   from proprietario         ";
                    $sSqlProprietario .= "  where j01_matric = $oOrigens->matric ";
                    $rsProprietario = db_query($sSqlProprietario) or die($sSqlProprietario);
                    $oProprietario = db_utils::fieldsMemory($rsProprietario, 0);
                    $oImovel = new stdClass();

                    /**
                     * quando solicitado  o endereço de origem
                     */
                    if ($sTipoEndereco == "o") {

                        $oImovel->endereco = $oProprietario->nomepri . (isset($oProprietario->j39_numero) ? ", " . $oProprietario->j39_numero : "")
                            . (isset($oProprietario->j39_compl) ? ", " . $oProprietario->j39_compl : "");
                        $oImovel->bairro = $oProprietario->j13_descr;

                        $sqlcidade = "select munic, uf, cep from db_config where codigo = " . db_getsession('DB_instit');
                        $resultcidade = db_query($sqlcidade);
                        $oCidade = db_utils::fieldsmemory($resultcidade, 0);
                        $oImovel->cidade = $oCidade->munic . ' / ' . $oCidade->uf;
                        $oImovel->cep = $oCidade->cep;

                    } elseif ($sTipoEndereco == "c") {

                        $oImovel->endereco = $oProprietario->z01_ender .
                            ($oProprietario->z01_numero != "" ? ', ' . $oProprietario->z01_numero : "") .
                            ($oProprietario->z01_compl != "" ? "/" . $oProprietario->z01_compl : "");
                        $oImovel->bairro = $oProprietario->z01_bairro;
                        $oImovel->cidade = $oProprietario->z01_munic . ' / ' . $oProprietario->z01_uf;
                        $oImovel->cep = $oProprietario->z01_cep;

                    }

                    $oImovel->setor = $oProprietario->j34_setor;
                    $oImovel->quadra = $oProprietario->j34_quadra;
                    $oImovel->lote = $oProprietario->j34_lote;
                    $oImovel->matricula = $oOrigens->matric;
                    $oImovel->refanterior = $oProprietario->j40_refant;

                    $oImovel->setorloc = $oProprietario->pql_localizacao;

                    $aImoveisEnvolvidos[] = $oImovel;
                    $aMatric[] = $oOrigens->matric;
                }
            }

            /**
             * Verificando as inscrições
             */
            if ($oOrigens->inscr > 0 && in_array($oOrigens->inscr, $aInscr)) {
                continue;
            } else {

                if ($oOrigens->inscr > 0) {

                    $sSqlEnvol = " select * from fc_busca_envolvidos({$lRegra},{$oPardiv->v04_envolcdaiss},'I',{$oOrigens->inscr})";
                    $rsEnvol = db_query($sSqlEnvol) or die($sSqlEnvol);
                    $iLinhasEnvol = pg_num_rows($rsEnvol);
                    for ($i = 0; $i < $iLinhasEnvol; $i++) {

                        $oDevedor = new stdClass();
                        $oEnvol = db_utils::fieldsMemory($rsEnvol, $i);
                        if (empty($oEnvol->rinumcgm)) {
                            continue;
                        }
                        $sSqlDadosEnvol = " select z01_numcgm,                     ";
                        $sSqlDadosEnvol .= "        z01_nome,                       ";
                        $sSqlDadosEnvol .= "        z01_cgccpf,                     ";
                        $sSqlDadosEnvol .= "        z01_telef,                      ";
                        $sSqlDadosEnvol .= "        z01_numero,                     ";
                        $sSqlDadosEnvol .= "        z01_ender  as ender,            ";
                        $sSqlDadosEnvol .= "        z01_numero as numero,           ";
                        $sSqlDadosEnvol .= "        z01_compl  as compl,            ";
                        $sSqlDadosEnvol .= "        z01_bairro as bairro,           ";
                        $sSqlDadosEnvol .= "        z01_munic  as munic,            ";
                        $sSqlDadosEnvol .= "        z01_cep    as cep,              ";
                        $sSqlDadosEnvol .= "        z01_uf     as uf,               ";
                        $sSqlDadosEnvol .= "        z01_dtfalecimento               ";
                        $sSqlDadosEnvol .= "   from cgm                             ";
                        $sSqlDadosEnvol .= "  where z01_numcgm = {$oEnvol->rinumcgm}";
                        $rsDadosEnvol = db_query($sSqlDadosEnvol);
                        $iLinhasDadosEnvol = pg_num_rows($rsDadosEnvol);
                        if ($iLinhasDadosEnvol > 0) {

                            $oDadosEnvol = db_utils::fieldsMemory($rsDadosEnvol, 0);


                            if (trim($oDadosEnvol->z01_dtfalecimento) != '' && strlen($oDadosEnvol->z01_cgccpf) == 11) {
                                $oDevedor->nome = $sExpressaoFalecimento . " " . $oDadosEnvol->z01_nome;
                            } else {
                                $oDevedor->nome = $oDadosEnvol->z01_nome;
                            }

                            $oDevedor->numcgm = $oDadosEnvol->z01_numcgm;
                            $oDevedor->telefone = $oDadosEnvol->z01_telef;
                            $oDevedor->endereco = "";
                            $oDevedor->endereco = $oDadosEnvol->ender;
                            if (trim($oDadosEnvol->numero) != "0" and trim($oDadosEnvol->numero) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->numero} ";
                            }
                            if (trim($oDadosEnvol->compl) != "0" and trim($oDadosEnvol->compl) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->compl} ";
                            }
                            if (trim($oDadosEnvol->bairro) != "0" and trim($oDadosEnvol->bairro) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->bairro} ";
                            }
                            if (trim($oDadosEnvol->munic) != "0" and trim($oDadosEnvol->munic) != "") {
                                $oDevedor->endereco .= ",{$oDadosEnvol->munic}/{$oDadosEnvol->uf}";
                            }
                            if (trim($oDadosEnvol->cep) != "0" and trim($oDadosEnvol->cep) != "") {
                                $oDevedor->endereco .= "- CEP {$oDadosEnvol->cep} .";
                            }

                            if (strlen($oDadosEnvol->z01_cgccpf) > 11) {
                                if ($oEnvol->ritipoenvol == "4") {
                                    $oDevedor->tipo = "EMPRESA";
                                } else if ($oEnvol->ritipoenvol == "5") {
                                    $oDevedor->tipo = "SÓCIO";
                                }
                            } else {
                                $oDevedor->tipo = "CONTRIBUINTE";
                            }

                            if (strlen($oDadosEnvol->z01_cgccpf) > 11) {
                                $oDevedor->cgcCpf = db_formatar($oDadosEnvol->z01_cgccpf, "cnpj");
                            } else {
                                $oDevedor->cgcCpf = db_formatar($oDadosEnvol->z01_cgccpf, "cpf");
                            }

                        }
                        $aDevedoresEnvolvidos[] = $oDevedor;
                    }

                    /**
                     * Retorna os dados da Inscrição
                     */
                    $sSqlEmpresa = " select *                  ";
                    $sSqlEmpresa .= "   from empresa            ";
                    $sSqlEmpresa .= "  where q02_inscr = $oOrigens->inscr ";
                    $rsEmpresa = db_query($sSqlEmpresa) or die($sSqlEmpresa);
                    $oEmpresa = db_utils::fieldsMemory($rsEmpresa, 0);
                    $oEmpresa->inscricao = $oOrigens->inscr;
                    $oEmpresa->endereco = $oEmpresa->j14_tipo . ' ' . $oEmpresa->z01_ender . ', ' . $oEmpresa->z01_numero . '  ' .
                        $oEmpresa->z01_compl;
                    $oEmpresa->bairro = $oEmpresa->z01_bairro;
                    $oEmpresa->cidade = $oEmpresa->z01_munic . ' / ' . $oEmpresa->z01_uf;
                    $oEmpresa->cep = $oEmpresa->z01_cep;
                    $aInscr[] = $oOrigens->inscr;
                    $aEmpresasEnvolvidos[] = $oEmpresa;
                }
            }

            /**
             * Verificamos o CGM
             */
            if (in_array($oOrigens->numcgm, $aCgm)) {
                continue;
            } else {

                if ($oOrigens->matric == 0 && $oOrigens->inscr == 0) {

                    $sSqlCgm = " select *                             ";
                    $sSqlCgm .= "   from cgm                           ";
                    $sSqlCgm .= "  where z01_numcgm = $oOrigens->numcgm";
                    $rsCgm = db_query($sSqlCgm) or die($sSqlCgm);
                    $oCgm = db_utils::fieldsMemory($rsCgm, 0);
                    $oDevedor = new stdClass();
                    $oDevedor->endereco = $oCgm->z01_ender;

                    if (trim($oCgm->z01_numero) != "0" and trim($oCgm->z01_numero) != "") {
                        $oDevedor->endereco .= ",{$oCgm->z01_numero} ";
                    }
                    if (trim($oCgm->z01_compl) != "0" and trim($oCgm->z01_compl) != "") {
                        $oDevedor->endereco .= ",{$oCgm->z01_compl} ";
                    }
                    if (trim($oCgm->z01_bairro) != "0" and trim($oCgm->z01_bairro) != "") {
                        $oDevedor->endereco .= ",{$oCgm->z01_bairro} ";
                    }
                    if (trim($oCgm->z01_munic) != "0" and trim($oCgm->z01_munic) != "") {
                        $oDevedor->endereco .= ",{$oCgm->z01_munic}/{$oCgm->z01_uf} ";
                    }

                    if (trim($oCgm->z01_cep) != "0" and trim($oCgm->z01_cep) != "") {
                        $oDevedor->endereco .= "- CEP {$oCgm->z01_cep} .";
                    }

                    $oDevedor->numcgm = $oCgm->z01_numcgm;
                    $oDevedor->telefone = $oCgm->z01_telef;
                    $oDevedor->nome = $oCgm->z01_nome;
                    if (strlen($oCgm->z01_cgccpf) > 11) {
                        $oDevedor->cgcCpf = db_formatar($oCgm->z01_cgccpf, 'cnpj');
                    } else {
                        $oDevedor->cgcCpf = db_formatar($oCgm->z01_cgccpf, 'cpf');
                    }
                    $oDevedor->tipo = "";
                    $aCgm[] = $oOrigens->numcgm;
                    $aDevedoresEnvolvidos[] = $oDevedor;

                }
            }
        }
        $oRetorno = new stdClass();
        $oRetorno->aDevedores = array_map("unserialize", array_unique(array_map("serialize", $aDevedoresEnvolvidos)));
        $oRetorno->aImoveis = $aImoveisEnvolvidos;
        $oRetorno->aEmpresas = $aEmpresasEnvolvidos;
        return $oRetorno;
    }

    /**
     * Busca os debidos da divida
     * @throws Exception
     * @return Array
     */
    protected function getDebitosDivida()
    {
        $sqlDadosDivida = "select divida.*,  ";
        $sqlDadosDivida .= "       lote.*,    ";
        $sqlDadosDivida .= "       coalesce(arrematric.k00_matric,0) as matric, ";
        $sqlDadosDivida .= "       coalesce(arreinscr.k00_inscr,0) as inscr, ";
        $sqlDadosDivida .= "       v03_descr, ";
        $sqlDadosDivida .= "       v24_procedagrupa, ";
        $sqlDadosDivida .= "       v03_tributaria ";
        $sqlDadosDivida .= "  from divida  ";
        $sqlDadosDivida .= "       left join arrematric        on arrematric.k00_numpre  = divida.v01_numpre ";
        $sqlDadosDivida .= "       left join iptubase a        on arrematric.k00_matric  = a.j01_matric ";
        $sqlDadosDivida .= "       left join lote              on lote.j34_idbql         = a.j01_idbql ";
        $sqlDadosDivida .= "       left join arreinscr         on arreinscr.k00_numpre   =  divida.v01_numpre ";
        $sqlDadosDivida .= "       left join proced            on proced.v03_codigo      = divida.v01_proced ";
        $sqlDadosDivida .= "                                  and proced.v03_instit      = " . db_getsession('DB_instit');
        $sqlDadosDivida .= "       left join procedenciaagrupa on   v03_codigo           = v24_proced ";
        $sqlDadosDivida .= " where v01_numcgm = {$this->cgmorigem} ";
        $sqlDadosDivida .= "                                  and v01_instit             = " . db_getsession('DB_instit');
        $sqlDadosDivida .= " order by v03_tributaria,v01_exerc, v01_proced,v01_numpre,v01_numpar,v24_procedagrupa ";


        $rsDadosDivida = db_query($sqlDadosDivida);
        $aDebitos = array();

        if (pg_num_rows($rsDadosDivida) > 0) {

            for ($i = 0; $i < pg_num_rows($rsDadosDivida); $i++) {

                $oDivida = db_utils::fieldsmemory($rsDadosDivida, $i);

                $dataemis = db_getsession("DB_datausu");
                $anoemis = db_getsession("DB_anousu");
                $xmes = date('m');
                $xdia = date('d');
                $xano = date('Y');

                $sSqlVerificaArrecad = "select * from arrecad where k00_numpre = {$oDivida->v01_numpre}";
                $rsArrecad = db_query($sSqlVerificaArrecad) or die($sSqlVerificaArrecad);
                if (pg_num_rows($rsArrecad) > 0) {
                    $rsArrecad = debitos_numpre($oDivida->v01_numpre, 0, 0,
                        $dataemis,
                        $anoemis, $oDivida->v01_numpar,
                        "",
                        "",
                        " and y.k00_hist <> 918");
                } else {

                    $sSqlVerificaArrecad = "select * from arreold where k00_numpre = $oDivida->v01_numpre";
                    $rsArrecad = db_query($sSqlVerificaArrecad) or die($sSqlVerificaArrecad);
                    if (pg_num_rows($rsArrecad) > 0) {

                        $rsArrecad = debitos_numpre_old($oDivida->v01_numpre, 0, 0,
                            $dataemis,
                            $anoemis,
                            $oDivida->v01_numpar, '', ''
                        );
                    }
                }

                if ($rsArrecad) {
                    $iNumRowsArrecad = pg_num_rows($rsArrecad);
                } else {
                    $iNumRowsArrecad = 0;
                }

                /**
                 * percorremos os debitos da arrecad
                 */
                for ($iArrecad = 0; $iArrecad < $iNumRowsArrecad; $iArrecad++) {

                    $oDadosDebitoAtualizado = db_utils::fieldsmemory($rsArrecad, $iArrecad);
                    $oDividaCda = new stdClass();
                    $oDividaCda->exercicio = $oDivida->v01_exerc;
                    $oDividaCda->livro = $oDivida->v01_livro;
                    $oDividaCda->codigodivida = $oDivida->v01_coddiv;
                    $oDividaCda->folha = $oDivida->v01_folha;
                    $oDividaCda->certidmassa = "";
                    $oDividaCda->observacao = $oDivida->v01_obs . "\nProcesso:" . $oDivida->v01_processo . " Data:" . db_formatar($oDivida->v01_dtprocesso, 'd');
                    $oDividaCda->procedenciaagrupar = $oDivida->v24_procedagrupa;

                    if ($oDivida->v03_tributaria == "t" || $oDivida->v03_tributaria == 1) {
                        $oDividaCda->procedenciatributaria = true;
                    } else {
                        $oDividaCda->procedenciatributaria = false;
                    }

                    if ($oDivida->matric != 0) {

                        $oDividaCda->origem = "mat";
                        $oDividaCda->codigoorigem = $oDivida->matric;

                        if (isset($oDivida->j34_setor) && $oDivida->j34_setor != "" && isset($oDivida->j34_quadra)
                            && $oDivida->j34_quadra != "" && isset($oDivida->j34_lote) && $oDivida->j34_lote != ""
                        ) {
                            $oDividaCda->origemdebito = $oDivida->j34_setor . "/" . $oDivida->j34_quadra . "/" . $oDivida->j34_lote;
                        } else {
                            $oDividaCda->origemdebito = $oDivida->j34_lote;
                        }

                    } elseif ($oDivida->inscr != 0) {

                        $oDividaCda->origem = "inscr";
                        $oDividaCda->codigoorigem = $oDivida->inscr;
                        $oDividaCda->origemdebito = ucfirst($oDividaCda->origem) . " - " . $oDivida->inscr;

                    } else {

                        $oDividaCda->origem = "cgm";
                        $oDividaCda->codigoorigem = $oDivida->v01_numcgm;
                        $oDividaCda->origemdebito = ucfirst($oDividaCda->origem) . " - " . $oDivida->v01_numcgm;

                    }

                    $oDividaCda->procedencia = $oDivida->v03_descr;
                    $oDividaCda->codigoprocedencia = $oDivida->v01_proced;

                    $dDataLancamento = $this->getDataLancamentoDebito($oDadosDebitoAtualizado->k00_numpre, $oDadosDebitoAtualizado->k00_numpar);
                    if ($dDataLancamento == '') {
                        $dDataLancamento = $oDadosDebitoAtualizado->k00_dtoper;
                    }

                    $oDividaCda->datalancamento = $dDataLancamento;
                    $oDividaCda->datainscricao = $oDivida->v01_dtinsc;
                    $oDividaCda->datavencimento = $oDadosDebitoAtualizado->k00_dtvenc;
                    $oDividaCda->dataoperacao = $oDadosDebitoAtualizado->k00_dtoper;
                    $oDividaCda->numpre = $oDadosDebitoAtualizado->k00_numpre;
                    $oDividaCda->numpar = $oDadosDebitoAtualizado->k00_numpar;
                    $oDividaCda->valorcorrecao = $oDadosDebitoAtualizado->vlrcor - $oDadosDebitoAtualizado->vlrhis;
                    $oDividaCda->valorhistorico = $oDadosDebitoAtualizado->vlrhis;
                    $oDividaCda->valorcorrigido = $oDadosDebitoAtualizado->vlrcor;
                    $oDividaCda->valormulta = $oDadosDebitoAtualizado->vlrmulta;
                    $oDividaCda->valorjuros = $oDadosDebitoAtualizado->vlrjuros;
                    $oDividaCda->valortotal = $oDadosDebitoAtualizado->vlrjuros +
                        $oDadosDebitoAtualizado->vlrmulta +
                        $oDadosDebitoAtualizado->vlrcor;
                    $aDebitos[] = $oDividaCda;
                }
            }
        }

        return $aDebitos;
    }

    /**
     * Escreve o quadro de Divida
     * @param bool $lTotaliza
     */
    public function drawDebitos($lTotaliza = false)
    {
        $aDebitos = $this->getDebitosDivida();

        $aDebitosOrdenado = array();
        $aTotaisAno = array();
        $oTotalGeral = array();

        foreach ($aDebitos as $oDebito) {

            $aDebitosOrdenado[$oDebito->procedenciatributaria][] = $oDebito;
            if (!isset($aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio])) {

                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrhis = $oDebito->valorhistorico;
                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrcor = $oDebito->valorcorrigido;
                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrmul = $oDebito->valormulta;
                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrjur = $oDebito->valorjuros;
                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrtot = $oDebito->valortotal;
                if ($oDebito->certidmassa != 0) {
                    $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrtot = $oDebito->valorcorrigido;
                }

            } else {

                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrhis += $oDebito->valorhistorico;
                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrcor += $oDebito->valorcorrigido;
                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrmul += $oDebito->valormulta;
                $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrjur += $oDebito->valorjuros;

                if ($oDebito->certidmassa != 0) {
                    $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrtot += $oDebito->valorcorrigido;
                } else {
                    $aTotaisAno[$oDebito->procedenciatributaria][$oDebito->exercicio]->vlrtot += $oDebito->valortotal;
                }
            }
            if (!isset($oTotalGeral[$oDebito->procedenciatributaria])) {

                $oTotalGeral[$oDebito->procedenciatributaria]->valorhistorico = $oDebito->valorhistorico;
                $oTotalGeral[$oDebito->procedenciatributaria]->valorcorrigido = $oDebito->valorcorrigido;
                $oTotalGeral[$oDebito->procedenciatributaria]->valormulta = $oDebito->valormulta;
                $oTotalGeral[$oDebito->procedenciatributaria]->valorjuros = $oDebito->valorjuros;
                $oTotalGeral[$oDebito->procedenciatributaria]->valortotal = $oDebito->valortotal;
                if ($oDebito->certidmassa != 0) {
                    $oTotalGeral[$oDebito->procedenciatributaria]->valortotal = $oDebito->valorcorrigido;
                }
            } else {

                $oTotalGeral[$oDebito->procedenciatributaria]->valorhistorico += $oDebito->valorhistorico;
                $oTotalGeral[$oDebito->procedenciatributaria]->valorcorrigido += $oDebito->valorcorrigido;
                $oTotalGeral[$oDebito->procedenciatributaria]->valormulta += $oDebito->valormulta;
                $oTotalGeral[$oDebito->procedenciatributaria]->valorjuros += $oDebito->valorjuros;
                if ($oDebito->certidmassa != 0) {
                    $oTotalGeral[$oDebito->procedenciatributaria]->valortotal += $oDebito->valorcorrigido;
                } else {
                    $oTotalGeral[$oDebito->procedenciatributaria]->valortotal += $oDebito->valortotal;

                }
            }
        }

        /**
         * Escrevemos o quadro dos creditos ;
         */
        foreach ($aDebitosOrdenado as $iTipo => $aTipo) {

            $this->ln(3);
            if ($iTipo == 1) {
                $this->MultiCell(0, 5, 'C R É D I T O    T R I B U T Á R I O ', 0, "C", 0);
            } else {
                $this->setfont('', 'B', 9);
                $this->MultiCell(0, 5, 'C R É D I T O  N Ã O  T R I B U T Á R I O ', 0, "C", 0);
            }
            $this->SetFont('', 'B', 6);
            $this->Cell(10, 5, "1 EXERC.", 1, 0, "C", 1);
            $this->Cell(10, 5, "PARC", 1, 0, "C", 1);
            $this->Cell(10, 5, "LIV/FOL", 1, 0, "C", 1);
            $this->Cell(15, 5, "ORIG.", 1, 0, "C", 1);
            $this->Cell(30, 5, "PROCEDÊNCIA", 1, 0, "C", 1);
            $this->Cell(18, 5, "ORIGEM DÉBITO", 1, 0, "C", 1);
            $this->Cell(18, 5, "DATA INSCR.", 1, 0, "C", 1);
            $this->Cell(18, 5, "DATA VENC.", 1, 0, "C", 1);
            $this->Cell(15, 5, "VLR HIST.", 1, 0, "C", 1);
            $this->Cell(15, 5, "CORRIGIDO", 1, 0, "C", 1);
            $this->Cell(10, 5, "MULTA", 1, 0, "C", 1);
            $this->Cell(10, 5, "JUROS", 1, 0, "C", 1);
            $this->Cell(15, 5, "TOTAL", 1, 1, "C", 1);
            $lEscreveTotal = false;
            $iExercicioAnterior = null;
            $pagina = 0;
            $iY = 0;
            foreach ($aTipo as $oDebito) {

                if ($oDebito->exercicio != $iExercicioAnterior && $lEscreveTotal && $lTotaliza) {

                    $this->SetFont('', 'B', 6);
                    $this->Cell(129, 5, "TOTAL EXERCICIO - {$iExercicioAnterior}", 1, 0, "C", 0);
                    $this->Cell(15, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrhis, 'f'), 1, 0, "R", 0);
                    $this->Cell(15, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrcor, 'f'), 1, 0, "R", 0);
                    $this->Cell(10, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrmul, 'f'), 1, 0, "R", 0);
                    $this->Cell(10, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrjur, 'f'), 1, 0, "R", 0);
                    $this->Cell(15, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrtot, 'f'), 1, 1, "R", 0);
                    $this->setfont('', 'B', 9);

                }
                $lEscreveTotal = true;
                if ($iY > 272) {

                    $this->AddPage();

                    $this->SetFont('', 'B', 6);
                    $this->Cell(10, 5, "2 EXERC.", 1, 0, "C", 1);
                    $this->Cell(10, 5, "PARC", 1, 0, "C", 1);
                    $this->Cell(10, 5, "LIV/FOL", 1, 0, "C", 1);
                    $this->Cell(15, 5, "ORIG.", 1, 0, "C", 1);
                    $this->Cell(30, 5, "PROCEDÊNCIA", 1, 0, "C", 1);
                    $this->Cell(18, 5, "ORIGEM DÉBITO", 1, 0, "C", 1);
                    $this->Cell(18, 5, "DATA INSCR.", 1, 0, "C", 1);
                    $this->Cell(18, 5, "DATA VENC.", 1, 0, "C", 1);
                    $this->Cell(15, 5, "VLR HIST.", 1, 0, "C", 1);
                    $this->Cell(15, 5, "CORRIGIDO", 1, 0, "C", 1);
                    $this->Cell(10, 5, "MULTA", 1, 0, "C", 1);
                    $this->Cell(10, 5, "JUROS", 1, 0, "C", 1);
                    $this->Cell(15, 5, "TOTAL", 1, 1, "C", 1);
                    $pagina = $this->PageNo();

                }

                $this->SetFont('', '', 6);
                $this->Cell(10, 5, $oDebito->exercicio, 1, 0, "C", 0);
                $this->Cell(10, 5, $oDebito->numpar, 1, 0, "C", 0);
                $this->Cell(10, 5, $oDebito->livro . "/" . $oDebito->folha, 1, 0, "C", 0);
                $this->Cell(15, 5, ucfirst($oDebito->origem) . "/{$oDebito->codigoorigem}", 1, 0, "C", 0);
                $this->Cell(30, 5, $oDebito->procedencia, 1, 0, "L", 0);
                $this->Cell(18, 5, $oDebito->origemdebito, 1, 0, "C", 0);
                $this->Cell(18, 5, db_formatar($oDebito->datainscricao, 'd'), 1, 0, "C", 0);
                $this->Cell(18, 5, db_formatar($oDebito->datavencimento, 'd'), 1, 0, "C", 0);
                $this->Cell(15, 5, db_formatar($oDebito->valorhistorico, 'f'), 1, 0, "R", 0);
                $this->Cell(15, 5, db_formatar($oDebito->valorcorrigido, 'f'), 1, 0, "R", 0);
                if ($oDebito->certidmassa == 0) {

                    $this->Cell(10, 5, db_formatar($oDebito->valormulta, 'f'), 1, 0, "R", 0);
                    $this->Cell(10, 5, db_formatar($oDebito->valorjuros, 'f'), 1, 0, "R", 0);
                    $this->Cell(15, 5, db_formatar($oDebito->valortotal, 'f'), 1, 1, "R", 0);

                } else {

                    $this->Cell(10, 5, db_formatar(0, 'f'), 1, 0, "R", 0);
                    $this->Cell(10, 5, db_formatar(0, 'f'), 1, 0, "R", 0);
                    $this->Cell(15, 5, db_formatar($oDebito->valorcorrigido, 'f'), 1, 1, "R", 0);

                }

                $iExercicioAnterior = $oDebito->exercicio;
                $iY = $this->GetY();

            }

            /**
             * Escreve o total do ultimo ano
             */
            if (($lEscreveTotal && $lTotaliza)) {

                $this->SetFont('', 'B', 6);
                $this->Cell(129, 5, "TOTAL EXERCICIO - {$iExercicioAnterior}", 1, 0, "C", 0);
                $this->Cell(15, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrhis, 'f'), 1, 0, "R", 0);
                $this->Cell(15, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrcor, 'f'), 1, 0, "R", 0);
                $this->Cell(10, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrmul, 'f'), 1, 0, "R", 0);
                $this->Cell(10, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrjur, 'f'), 1, 0, "R", 0);
                $this->Cell(15, 5, db_formatar($aTotaisAno[$iTipo][$iExercicioAnterior]->vlrtot, 'f'), 1, 1, "R", 0);
                $this->setfont('', 'B', 9);

            }
            $this->SetFont('', 'B', 6);
            $this->Cell(129, 5, "TOTAL", 1, 0, "C", 0);
            $this->Cell(15, 5, db_formatar($oTotalGeral[$iTipo]->valorhistorico, 'f'), 1, 0, "R", 0);
            $this->Cell(15, 5, db_formatar($oTotalGeral[$iTipo]->valorcorrigido, 'f'), 1, 0, "R", 0);
            $this->Cell(10, 5, db_formatar($oTotalGeral[$iTipo]->valormulta, 'f'), 1, 0, "R", 0);
            $this->Cell(10, 5, db_formatar($oTotalGeral[$iTipo]->valorjuros, 'f'), 1, 0, "R", 0);
            $this->Cell(15, 5, db_formatar($oTotalGeral[$iTipo]->valortotal, 'f'), 1, 1, "R", 0);
            $this->setfont('', 'B', 9);

            $this->Ln(5);
        }
    }

    /**
     * Busca a data de lançamento do debito
     * @param int $iNumpre
     * @param int $iNumpar
     * @return string
     */
    protected function getDataLancamentoDebito($iNumpre, $iNumpar)
    {
        $oDaoInformacaoDebito = db_utils::getDao('informacaodebito');
        $sSqlInformacaoDebito = $oDaoInformacaoDebito->sql_query_retorna_dados_origem("*", $iNumpre, $iNumpar);
        $rsInformacaoDebito = $oDaoInformacaoDebito->sql_record($sSqlInformacaoDebito);
        $dDataLancamento = null;

        if ($oDaoInformacaoDebito->numrows > 0) {
            $dDataLancamento = db_utils::fieldsMemory($rsInformacaoDebito, 0)->k163_data;
        }

        return $dDataLancamento;
    }

    /**
     * Exibe os textos dos paragrafos
     */
    public function drawTextoPadrao()
    {
        $this->getParagrafos();
    }

    /**
     * Busca os paragrafos para a geracao os textos do documento
     */
    public function getParagrafos()
    {
        $this->_drawTextoPadrao($this->oDocumento->aParagrafos[3]->db02_texto);
    }

    /**
     * Drown default text
     * @param string $sText
     */
    private function _drawTextoPadrao($sText)
    {
        $this->setfont('', 'B', 9);
        $this->Ln(5);
        $this->MultiCell(0, 5, $sText, 0, "J", 0);
    }

    /**
     * Instancia o objeto dos paragrafos para os textos do documento
     * @return libdocumento
     */
    public function getInstaceLibDocumento()
    {
        $this->oDocumento = new libdocumento(self::COD_TIPO_DOCUMENTO, self::COD_DOCUMENTO);
    }

    public function getAssinaturas()
    {

    }

    /**
     * Imprime as assinaturas
     */
    public function drawAssinaturas()
    {

        $this->_drawAssinaturas($this->oDocumento->aParagrafos);
    }

    /**
     * Imprime as assinaturas
     * @param array $aAssinaturas
     */
    private function _drawAssinaturas($aAssinaturas)
    {
        $asssec = null;
        $asscoord = null;

        $this->_addPage();

        foreach ($aAssinaturas as $oAssinaturas) {

            if ($oAssinaturas->db02_descr == "ASSINATURAS_CODIGOPHP") {
                $assinaturas_php = trim($oAssinaturas->db02_texto);
            }
            if ($oAssinaturas->db04_ordem == '4') {
                $asssec = $oAssinaturas->db02_texto;
            }
            if ($oAssinaturas->db04_ordem == '5') {
                $asscoord = $oAssinaturas->db02_texto;
            }
        }

        $this->setfont('', '', 1);
        $this->MultiCell(0, 2, "", 0, "R", 0);
        $this->setfont('', '', 10);

        if (!empty($asssec)) {
            $sec = "______________________________" . "\n" . $asssec;
        } else {
            $sec = "";
        }
        if (!empty($asscoord)) {
            $coor = "______________________________" . "\n" . $asscoord;
        } else {
            $coor = "";
        }

        $this->SetFont('', 'B', 10);

        $largura = ($this->w) / 2;
        $posy = $this->gety();
        $alt = 5;
        $dbinstit = db_getsession('DB_instit');

        if (isset($assinaturas_php) && $assinaturas_php != "") {

            eval($assinaturas_php);
        } else {

            if ($coor != "") {
                $this->multicell($largura - 20, 4, $coor, 0, "C", 0, 0);
            } else {
                $this->Cell(1, 3, "", 0, 0, "C", 0);
            }

            if ($sec != "") {

                $this->Cell($largura - 10, 3, "", 0, 0, "C", 0);
                $this->multicell($largura, 4, $sec, 0, "C", 0, 0);
            } else {
                $this->Cell(100, 3, "", 0, 0, "C", 0);
            }
        }
    }

    /**
     * Exibe o texto certifico
     */
    public function drawCertifico()
    {
        $this->_drawTextoPadrao($this->oDocumento->aParagrafos[1]->db02_texto);
    }
}