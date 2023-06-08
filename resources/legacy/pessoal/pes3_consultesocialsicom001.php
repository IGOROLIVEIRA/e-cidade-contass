<fieldset style='height: 120px'>
    <legend><strong>eSocial/Sicom</strong></legend>
    <?php
    $aPontos           = array();
    $iAnoUsu           = db_getsession('DB_anousu');
    $iMesusu           = DBPessoal::getMesFolha();

    $oCompetenciaFolha = new DBCompetencia(DBPessoal::getAnoFolha(), $iMesusu);
    $lFolhaAberta      = true;

    if ( @$temsalario ) {
    
        if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {  
            $lFolhaAberta                  = FolhaPagamentoSalario::hasFolhaAberta($oCompetenciaFolha);
        }

        $lPermiteManutecao             = (db_permissaomenu( $iAnoUsu, 952, 4506 ) == "true" && $lFolhaAberta) ;
        $aPontos['salario']            = array("sLabel" => "SALÁRIO", "lPermiteManutencao" => $lPermiteManutecao);
    }
  
    if (isset($lTemSuplementar)) {
    
        $lFolhaAberta           = FolhaPagamentoSuplementar::hasFolhaAberta($oCompetenciaFolha);
        $lPermiteManutecao      = (db_permissaomenu( $iAnoUsu, 952, 4506 ) == "true" && $lFolhaAberta) ;
        $aPontos['suplementar'] = array("sLabel" => "SUPLEMENTAR", "lPermiteManutencao" => $lPermiteManutecao);
    }
    
    if ( @$temrescisao ) {
    
        if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
            $lFolhaAberta = FolhaPagamentoRescisao::hasFolhaAberta($oCompetenciaFolha);
        }     
        $lPermiteManutecao   = db_permissaomenu( $iAnoUsu, 952, 4510 ) == "true" && $lFolhaAberta;
        $aPontos['rescisao'] = array("sLabel" => "RESCISÃO", "lPermiteManutencao" => $lPermiteManutecao);
    }
  
    if ( @$temferias ) {

        if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
            if ( !FolhaPagamentoSalario::hasFolhaAberta($oCompetenciaFolha)
              || !FolhaPagamentoComplementar::hasFolhaAberta($oCompetenciaFolha) ) {

                $aPontos['ferias'] = array("sLabel" => "FÉRIAS", "lPermiteManutencao" => false);
            } else {

                $lPermiteManutecao = db_permissaomenu( $iAnoUsu, 952, 4509) == "true";
                $aPontos['ferias'] = array("sLabel" => "FÉRIAS", "lPermiteManutencao" => $lPermiteManutecao);
            }
        } else {

            $lPermiteManutecao = db_permissaomenu( $iAnoUsu, 952, 4509) == "true";
            $aPontos['ferias'] = array("sLabel" => "FÉRIAS", "lPermiteManutencao" => $lPermiteManutecao);
        }
    }
      
    if ( @$tem13salario ) {
      
        if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
            $lFolhaAberta = FolhaPagamento13o::hasFolhaAberta($oCompetenciaFolha);
        }
        $lPermiteManutecao    = db_permissaomenu( $iAnoUsu, 952, 4511 ) == "true" && $lFolhaAberta;
        $aPontos['13salario'] = array("sLabel" => "13º SALÁRIO", "lPermiteManutencao" => $lPermiteManutecao);
    }
      
    if ( @$temadiantamento ) {
        
        if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
            $lFolhaAberta = FolhaPagamentoAdiantamento::hasFolhaAberta($oCompetenciaFolha);
        }
        $lPermiteManutecao       = db_permissaomenu( $iAnoUsu, 952, 4508 ) == "true" && $lFolhaAberta;
        $aPontos['adiantamento'] = array("sLabel" => "ADIANTAMENTO", "lPermiteManutencao" => $lPermiteManutecao);
    }
      
    if ( @$temcomplementar ) {

        if (DBPessoal::verificarUtilizacaoEstruturaSuplementar()) {
            $lFolhaAberta = FolhaPagamentoComplementar::hasFolhaAberta($oCompetenciaFolha);
        }
        
        $lPermiteManutecao        = db_permissaomenu( $iAnoUsu, 952, 4512 ) == "true" && $lFolhaAberta;
        $aPontos['complementar2'] = array("sLabel" => "COMPLEMENTAR", "lPermiteManutencao" => $lPermiteManutecao);
    }
      
    if ( @$tempontofixo ) {

        $lPermiteManutecao = db_permissaomenu( $iAnoUsu, 952, 4507 ) == "true";
        $aPontos['fixo']   = array("sLabel" => "PONTO FIXO", "lPermiteManutencao" => $lPermiteManutecao);
    }

    if ( @$temgerfprovfer ) {

        $lPermiteManutecao  = null;
        $aPontos['provfer'] = array("sLabel" => "PROV. DE FÉRIAS", "lPermiteManutencao" => $lPermiteManutecao);
    }

    if ( @$temgerfprovs13 ) {

        $lPermiteManutecao  = null;
        $aPontos['provs13'] = array("sLabel" => "PROV. DE 13º", "lPermiteManutencao" => $lPermiteManutecao);
    }

    echo "<div class='box-pontos'>";

    foreach ($aPontos as $sTipoPonto => $aDados ) {

        $oDados = (object) $aDados;
        $sFuncao = "js_link_esocialsicom(\"{$sTipoPonto}\"); js_MudaLink( this.parentNode );";
        echo "<div class='tem{$sTipoPonto}2'> ";
        echo "  <a href='#' class='links2' onclick='{$sFuncao}'> " . $oDados->sLabel ." </a>";
        echo "</div>";
    }
    ?>
</fieldset>

<script>
    function js_link_esocialsicom(ponto) {

          var sBases = '';
          if ( document.formatu.bases ) {
              sBases = document.formatu.bases.value;
          }

          debitos.location.href = 'pes3_consesocialsicom021.php?opcao='+ponto+'&numcgm='+$F('z01_numcgm')+'&matricula='+document.formatu.matricula.value+'&ano=<?=@$ano?>&mes=<?=@$mes?>&tbprev=<?=@$r01_tbprev?>&bases='+sBases+'&rub_bases='+document.formatu.rub_bases.value+'&rub_cond='+document.formatu.rub_cond.value+'&rub_formula='+document.formatu.rub_formula.value;
    }
</script>