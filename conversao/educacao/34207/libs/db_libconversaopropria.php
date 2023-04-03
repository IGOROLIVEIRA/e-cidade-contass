<?

function Sys_Busca_Ultima_Parcela($iNumpre, $pConexao, $empresa_conversao, $sArquivoLog) {

  if ($empresa_conversao == 4) {

    $sUltima = "select max(to_number( case when trim(mov_parc) is null or trim(mov_parc) = '' then '0' else trim(mov_parc) end,'99999')) as ultima from arq07 where mov_rec = $iNumpre";
    $sUltima = "SELECT ultima from arq07_numtot where mov_rec = $iNumpre";
    $rsUltima = db_query($pConexao, $sUltima, $sArquivoLog);
    if (db_numrows($rsUltima, $sArquivoLog) == 0) {
      $iUltima = 1;
    } else {
      $oUltima = db_utils::fieldsmemory($rsUltima, 0);
      $iUltima = $oUltima->ultima;

      if ($iUltima == 0) {
        $iUltima = 1;
      }

    }

  } elseif ($empresa_conversao == 6) {
  
    $sBusca  = "select count(*) as total_parcelas from pessoas.tr_financeiro where id_seqsubstr = '{$iNumpre}'";
    $rsBusca = db_query($pConexao, $sBusca, $sArquivoLog);
    $oParcel = db_utils::fieldsmemory($rsBusca, 0);
    $iUltima = $oParcel->total_parcelas;
 
  }

  return $iUltima;

}

function Sys_Busca_CGM($pConexao, $iCgm, $sOrigem, $sArquivoLog) {

  $sSql = "select numcgm as z01_numcgm from w_cgm_conf where tabela = '$sOrigem' and codigo = $iCgm";
//  echo "\n\n\n $sSql \n\n\n";
  $rsCGM = db_query($pConexao, $sSql, $sArquivoLog);
//  echo "numrows: " . db_numrows($rsCGM, $sArquivoLog) . "\n";
  if (db_numrows($rsCGM, $sArquivoLog) == 0) {
    $iNovoCGM = 0;
  } else {
    $oCGM = db_utils::fieldsmemory($rsCGM, 0);
    $iNovoCGM = $oCGM->z01_numcgm;
  }

  return $iNovoCGM;

}

function Incluir($conexao1, $conexao2, $_tabela, $_numpre, $_numpar, $_numcgm, $_dtoper, $_receit, $_receitori, $_operac, $_valor, $_dtvenc, $_numtot, $_arretipo, $_certid=null, $_contapag, $_dtpago, $_dtcanc, $sArquivoLog, $nComposHistorico, $nComposCorrecao, $nComposJuros, $nComposMulta, $_institprefa, $empresa_conversao) {

//  if ($_tabela == "arrecad" or 1==1) {
//    echo "\n      $_tabela - numpre: $_numpre - parc: $_numpar - $_institprefa - $_arretipo\n";
//  }

  $sTabRec = "select * from caixa.tabrec where k02_codigo = $_receit";
  $rsTabrec = db_query( $conexao1, $sTabRec, $sArquivoLog);

  if (db_numrows($rsTabrec, $sArquivoLog) == 0) {
    $sInsert = "insert into tabrec (k02_codigo, k02_tipo, k02_descr, k02_drecei, k02_codjm, k02_recjur, k02_recmul) values ($_receit,'O','MIGRACAO-AUTO','MIGRACAO NAO ENCONTROU E CRIOU-$_tabela',1,1,1)";
    $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);
  }

  $sBusca = "select * from caixa.arreinstit where k00_numpre = $_numpre";
  $rsBusca = db_query( $conexao1, $sBusca, $sArquivoLog);
  if (db_numrows($rsBusca, $sArquivoLog) == 0) {
    $sInsert = "insert into caixa.arreinstit (k00_numpre, k00_instit) values ($_numpre, $_institprefa)";
    $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);
  }

  if ($_tabela == "arrecad" or $_tabela == "arreold") {

    $sInsert = "insert into caixa.$_tabela
                (k00_numpre,k00_numpar,k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numtot,k00_numdig,k00_tipo,k00_tipojm)
                values 
                ($_numpre,$_numpar,$_numcgm,$_dtoper,$_receit,$_operac,$_valor,$_dtvenc,$_numtot,1,$_arretipo,0)";
    //            die("\n\n\n $sInsert \n\n\n");
    $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);
  } elseif ($_tabela == "arreforo") {
    $sInsert = "insert into caixa.arreforo
                (k00_numpre,k00_numpar,k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numtot,k00_numdig,k00_tipo,k00_tipojm,k00_certidao)
                values 
                ($_numpre,$_numpar,$_numcgm,$_dtoper,$_receit,$_operac,$_valor,$_dtvenc,$_numtot,1,$_arretipo,0,$_certid)";
    $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);
  } elseif ($_tabela == "arrecant") {

    if ($empresa_conversao == 4) {

       $sBusca50 = "select * from arq50 where est_rec = $_numpre and est_parc = $_numpar order by to_number(est_reg,'99999') desc limit 1";
       $rsBusca50 = db_query( $conexao2, $sBusca50, $sArquivoLog);
       if (db_numrows($rsBusca50, $sArquivoLog) > 0) {
	 $oBusca50 = db_utils::fieldsmemory($rsBusca50, 0);

	 $sObs        = trim($oBusca50->obs1 . $oBusca50->obs2);
	 if ($sObs != "") {
	   $sObsCompara = $sObs . $oBusca->est_rec;
	 } else {
	   $sObsCompara = "Cancelamento do numpre: " . $oBusca->est_rec;
	 }
	 $dDataCanc   = $oBusca50->est_data;

	 $sBuscaCanc = "select * from caixa.cancdebitos where k20_descr = '$sObsCompara'";
	 $rsBuscaCanc = db_query( $conexao1, $sBuscaCanc, $sArquivoLog);
	 if (db_numrows($rsBuscaCanc, $sArquivoLog) == 0) {

	   $sNext    = "select nextval('cancdebitos_k20_codigo_seq') as codigo";
	   $rsNext   = db_query( $conexao1, $sNext, $sArquivoLog);
	   $oNext    = db_utils::fieldsmemory($rsNext, 0);
	   $iCanc    = $oNext->codigo;

	   $sInsert  = " insert into caixa.cancdebitos 
			  (k20_codigo, k20_descr, k20_hora, k20_data, k20_usuario, k20_instit, k20_cancdebitostipo) 
			 values 
			 ($iCanc,'$sObs','00:00','$dDataCanc',1,$_institprefa,1)
			 ";
	   $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

	   $sInsert  = " insert into caixa.cancdebitosproc 
			  (k23_codigo, k23_data, k23_hora, k23_usuario, k23_obs, k23_cancdebitostipo) 
			 values 
			 ($iCanc,'$dDataCanc','00:00',1, '$sObs',1)
			 ";
	   $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

	 } else {
	   $oBuscaCanc = db_utils::fieldsmemory($rsBuscaCanc, 0);
	   $iCanc = $oBuscaCanc->k20_codigo;
	 }

	 $sNext           = "select nextval('cancdebitosreg_k21_sequencia_seq') as codigo";
	 $rsNext          = db_query( $conexao1, $sNext, $sArquivoLog);
	 $oNext           = db_utils::fieldsmemory($rsNext, 0);
	 $iCancDebitosReg = $oNext->codigo;

	 $sTesta = "select * from caixa.cancdebitosreg where k21_numpre = $_numpre and k21_numpar = $_numpar and k21_receit = $_receit";
	 $rsTesta = db_query( $conexao1, $sTesta, $sArquivoLog);
	 if (db_numrows($rsTesta, $sArquivoLog) == 0) {
	   $sInsert  = " insert into caixa.cancdebitosreg
			  (k21_sequencia, k21_codigo, k21_numpre, k21_numpar, k21_receit, k21_data, k21_hora, k21_obs)
			 values 
			 ($iCancDebitosReg,$iCanc,$_numpre,$_numpar,$_receit,'$dDataCanc','00:00','')
			 ";
	   $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

	   $sBusca51 = " select * from arq51 where tes_rec = $_numpre and tes_parc = $_numpar and tes_trib = $_receitori
			 order by to_number(tes_reg,'99999') desc limit 1";
	   $rsBusca51 = db_query( $conexao2, $sBusca51, $sArquivoLog);
	   if (db_numrows($rsBusca51, $sArquivoLog) > 0) {
	     $oBusca51  = db_utils::fieldsmemory($rsBusca51, 0);
	     $nVlrHis   = $rsBusca51->tes_vlest + 0;
	     $nVlrCor   = $rsBusca51->tes_vlest + 0;
	     $nJuros    = 0;
	     $nMulta    = 0;
	     $nDesconto = 0;
	   } else {
	     $nVlrHis   = 0;
	     $nVlrCor   = 0;
	     $nJuros    = 0;
	     $nMulta    = 0;
	     $nDesconto = 0;
	   }

	   $sInsert  = " insert into caixa.cancdebitosprocreg
			  (k24_sequencia, k24_codigo, k24_cancdebitosreg, k24_vlrhis, k24_vlrcor, k24_juros, k24_multa, k24_desconto)
			 values 
			 (nextval('cancdebitosprocreg_sequencia'),$iCanc,$iCancDebitosReg,$nVlrHis,$nVlrCor,$nJuros,$nMulta,$nDesconto)
			 ";
	   $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

	 }

       }

    } elseif ($empresa_conversao == 6) {

      $sNext     = "select nextval('cancdebitos_k20_codigo_seq') as codigo";
      $rsNext    = db_query( $conexao1, $sNext, $sArquivoLog);
      $oNext     = db_utils::fieldsmemory($rsNext, 0);
      $iCanc     = $oNext->codigo;
      $sObs      = 'Migracao Infotec';
      $dDataCanc = $_dtcanc;

      $sInsert  = " insert into caixa.cancdebitos 
		     (k20_codigo, k20_descr, k20_hora, k20_data, k20_usuario, k20_instit, k20_cancdebitostipo) 
		    values 
		    ($iCanc,'$sObs','00:00','$dDataCanc',1,$_institprefa,1)
		    ";
      $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

      $sInsert  = " insert into caixa.cancdebitosproc 
		     (k23_codigo, k23_data, k23_hora, k23_usuario, k23_obs, k23_cancdebitostipo) 
		    values 
		    ($iCanc,'$dDataCanc','00:00',1, '$sObs',1)
		    ";
      $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

      $sNext           = "select nextval('cancdebitosreg_k21_sequencia_seq') as codigo";
      $rsNext          = db_query( $conexao1, $sNext, $sArquivoLog);
      $oNext           = db_utils::fieldsmemory($rsNext, 0);
      $iCancDebitosReg = $oNext->codigo;

      $sInsert  = " insert into caixa.cancdebitosreg
		     (k21_sequencia, k21_codigo, k21_numpre, k21_numpar, k21_receit, k21_data, k21_hora, k21_obs)
		    values 
		    ($iCancDebitosReg,$iCanc,$_numpre,$_numpar,$_receit,'$dDataCanc','00:00','')
		    ";
      $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

      $nVlrHis   = $nComposHistorico;
      $nVlrCor   = 0;
      $nJuros    = 0;
      $nMulta    = 0;
      $nDesconto = 0;
      $sInsert  = " insert into caixa.cancdebitosprocreg
		     (k24_sequencia, k24_codigo, k24_cancdebitosreg, k24_vlrhis, k24_vlrcor, k24_juros, k24_multa, k24_desconto)
		    values 
		    (nextval('cancdebitosprocreg_sequencia'),$iCanc,$iCancDebitosReg,$nVlrHis,$nVlrCor,$nJuros,$nMulta,$nDesconto)
		    ";
      $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);



    }

    $sInsert = "insert into caixa.arrecant
                (k00_numpre,k00_numpar,k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numtot,k00_numdig,k00_tipo,k00_tipojm)
                values 
                ($_numpre,$_numpar,$_numcgm,$_dtoper,$_receit,$_operac,$_valor,$_dtvenc,$_numtot,1,$_arretipo,0)";
    $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

  } elseif ($_tabela == "arrepaga") {
    if( $empresa_conversao == 6) {
       $_contapag = Localiza_Reduzido( $_contapag, $conexao2, $conexao1, $sArquivoLog);
    }

    $sInsert = "insert into caixa.arrecant
                (k00_numpre,k00_numpar,k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numtot,k00_numdig,k00_tipo,k00_tipojm)
                values 
                ($_numpre,$_numpar,$_numcgm,$_dtoper,$_receit,$_operac,$_valor,$_dtvenc,$_numtot,1,$_arretipo,0)";
    $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

    $sInsert = "insert into caixa.arrepaga
                (k00_numpre,k00_numpar,k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numtot,k00_numdig,k00_conta,k00_dtpaga)
                values 
                ($_numpre,$_numpar,$_numcgm,$_dtoper,$_receit,$_operac,$_valor,$_dtvenc,$_numtot,1,$_contapag,$_dtpago)";
    $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);
  }

  if ($empresa_conversao == 4) {

     if ($nComposHistorico > 0 or $nComposCorrecao > 0 or $nComposJuros > 0 or $nComposMulta > 0) {

       $sKey = "select * from caixa.arreckey where k00_numpre = $_numpre and k00_numpar = $_numpar and k00_receit = $_receit and k00_hist = $_operac";
       $rsKey = db_query( $conexao1, $sKey, $sArquivoLog);
       if (db_numrows($rsKey, $sArquivoLog) == 0) {

	 $sNext = "select nextval('caixa.arreckey_k00_sequencial_seq') as codigo";
	 $rsNext = db_query($conexao1, $sNext, $sArquivoLog);
	 $oNext = db_utils::fieldsmemory($rsNext, 0);
	 $iKey = $oNext->codigo;

	 $sInsert  = "insert into caixa.arreckey values ($iKey, $_numpre, $_numpar, $_receit, $_operac)";
	 $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);

       } else {
	 $oKey = db_utils::fieldsmemory($rsKey, 0);
	 $iKey = $oKey->k00_sequencial;
       }

       $sCompos = "select * from caixa.arrecadcompos where k00_arreckey = $iKey";
       $rsCompos = db_query( $conexao1, $sCompos, $sArquivoLog);
       if (db_numrows($rsCompos, $sArquivoLog) == 0) {
	 $sInsert  = "insert into caixa.arrecadcompos values (nextval('caixa.arrecadcompos_k00_sequencial_seq'), $iKey, $nComposHistorico, $nComposCorrecao, $nComposJuros, $nComposMulta)";
	 $rsInsert = db_query($conexao1, $sInsert, $sArquivoLog);
       } else {
	 $sUpdate  = "update caixa.arrecadcompos set k00_historico = $nComposHistorico, k00_correcao = $nComposCorrecao, k00_juros = $nComposJuros, k00_multa = $nComposMulta where k00_arreckey = $iKey";
	 $rsUpdate = db_query($conexao1, $sUpdate, $sArquivoLog);
       }

     }

  }

//echo "\n xxx \n";

}

function IncluiArres($conexao, $_numpre, $_matric, $_inscr, $iMostrar, $sArquivoLog, $_numcgm=0) {

  if ($iMostrar == 1) {
    echo "     numpre: $_numpre - matric: - $_matric - inscr: $_inscr - CGM: $_numcgm \n";
  }

  // arrematric
  if ($_matric > 0) {

    if ($iMostrar == 1) {
      echo "     entrou em matricula\n";
    }

    $sBusca = "select * from caixa.arrematric where k00_numpre = $_numpre and k00_matric = $_matric";
    $rsBusca = db_query( $conexao, $sBusca, $sArquivoLog);

    if (db_numrows($rsBusca, $sArquivoLog) == 0) {

      if ($iMostrar == 1) {
        echo "     inserindo em arrematric... $_numpre - $_matric\n";
      }

      $sInsert = "insert into arrematric (k00_numpre, k00_matric, k00_perc) values ($_numpre, $_matric, 100)";
      $rsInsert = db_query($conexao, $sInsert, $sArquivoLog);
    
    } else {
      if ($iMostrar == 1) {
        echo "     ja existe em arrematric... $_numpre - $_matric\n";
      }
    }

  }

  // arreinscr
  if ($_inscr > 0) {

    $sBusca = "select * from caixa.arreinscr where k00_numpre = $_numpre and k00_inscr = $_inscr";
    $rsBusca = db_query( $conexao, $sBusca, $sArquivoLog);

    if (db_numrows($rsBusca, $sArquivoLog) == 0) {

      if ($iMostrar == 1) {
        echo "     inserindo em arreinscr...\n";
      }

      $sInsert = "insert into caixa.arreinscr (k00_numpre, k00_inscr, k00_perc) values ($_numpre, $_inscr, 100)";
      $rsInsert = db_query($conexao, $sInsert, $sArquivoLog);

    }

  }

  // arrenumcgm
  if ($_numcgm > 0) {

    $sBusca = "select * from caixa.arrenumcgm where k00_numpre = $_numpre and k00_numcgm = $_numcgm";
    $rsBusca = db_query( $conexao, $sBusca, $sArquivoLog);

    if (db_numrows($rsBusca, $sArquivoLog) == 0) {

      if ($iMostrar == 1) {
        echo "     inserindo em arrenumcgm...\n";
      }

      $sInsert = "insert into caixa.arrenumcgm (k00_numpre, k00_numcgm) values ($_numpre, $_numcgm)";
      $rsInsert = db_query($conexao, $sInsert, $sArquivoLog);

    }

  }




}

/*
 * Abrvia nome > 40
 */
function nome40($nome) {
        global $arqLog;
        $p = 2;
        while ( strlen ( $nome ) > 40 ) {
                $mtz_nome = explode ( " ", $nome );
                $nome40 = $nome;
                $nome = "";
                $mtz_nome [count ( $mtz_nome ) - $p] = substr ( $mtz_nome [count ( $mtz_nome ) - $p], 0, 1 );
                for($x = 0; $x < count ( $mtz_nome ); $x ++) {
                        if ($mtz_nome [$x] != "") {
                                $nome .= $mtz_nome [$x] . " ";
                        }
                }
                $nome = trim ( $nome );
                
                $p = $p + 1;
                if ($p > count ( $mtz_nome )) {
                        $nome = substr ( $nome, 0, 40 );
                }
        }
        $nome = str_replace ( "'", "", $nome );
        return $nome;
}

// infotec

function Localiza_Parcel( $iSequencia, $dDtCanc, $sTipo, $iOrigem, $pConexaoDestino1, $pConexaoOrigem1, $sArquivoLog ) {
   $iRetorno = 0;

   $sOrigem = "SELECT distinct substr( id_sequencia,1,12) as v07_parcel, data_parcelamento 
               from pessoas.tr_financeiro 
               where data_parcelamento is not null and fk_matricula = $iOrigem";
   $rsOrigem  = db_query($pConexaoOrigem1, $sOrigem, $sArquivoLog);
   if( db_numrows( $rsOrigem, $sArquivoLog) != 1 ) {
//     die("\n\n\n (1) nao achou parcelamento na base de origem... quant_achou: " . db_numrows( $rsOrigem, $sArquivoLog) . " - seq: $iSequencia\n\n\n $sOrigem \n\n\n");
     return 0;
   }
   $oOrigem = db_utils::fieldsmemory($rsOrigem, 0);
   $iParcel   = $oOrigem->v07_parcel;
   $dDtParcel = $oOrigem->data_parcelamento;

   //echo "\n\n\n parcel (1): $iParcel - dDtCanc: $dDtCanc \n\n\n";

   $sSql     = "select * from divida.termo where v07_hist = '$iParcel'";
   if ($dDtCanc != "") {
     $sSql .= " and v07_dtlanc = '$dDtCanc'";
   }
   //die("\n\n\n $sSql \n\n\n");
   $rsTermo  = db_query($pConexaoDestino1, $sSql, $sArquivoLog);
   if( db_numrows( $rsTermo, $sArquivoLog) != 0 ) {
      $oTermo    = db_utils::fieldsmemory($rsTermo, 0);
      if( $sTipo == "P" ){
        $iRetorno = $oTermo->v07_parcel;
      }else{
        $iRetorno = $oTermo->v07_numpre;
      }
   } else {
     if( $sTipo == "P" ){
       die("\n\n\n (2) nao achou parcelamento na base de origem ($iOrigem)... \n\n\n sql: $sSql\n\n\n");
     } else {
       $iRetorno = 0;
     }
   }
   return $iRetorno;
}

function MatriculaAntiga($conexao1, $iMatric, $sArquivoLog) {

  $sMatricAntiga = "select * from cadastro.iptuant where j40_refant = '$iMatric'";
  $rsMatricAntiga = db_query( $conexao1, $sMatricAntiga, $sArquivoLog);
  $iLinhasMatricAntiga = db_numrows($rsMatricAntiga, $sArquivoLog);
  if ( $iLinhasMatricAntiga > 0 ) {
    $oMatricAntiga = db_utils::fieldsmemory($rsMatricAntiga, 0);
    $iMatric = $oMatricAntiga->j40_matric;
  } else {
    $iMatric = 0;
  }

  return $iMatric;

}

function Localiza_Totalparcelas( $iSeq, $pConexaoOrigem1, $sArquivoLog){
  $sBusca  = "select count(*) as total_parcelas from pessoas.tr_financeiro where id_seqsubstr = '{$iSeq}'";
  $rsBusca = db_query($pConexaoOrigem1, $sBusca, $sArquivoLog);
  $oParcel = db_utils::fieldsmemory($rsBusca, 0);
  return $oParcel->total_parcelas;
 
}

function Localiza_Proced( $iCadastro, $iNatureza, $iTipo_issqn, $sTaxa, $pConexaoOrigem1, $sArquivoLog ){ 
   $iProced = 0;

  $sBusca  = "select * from pessoas.tr_dividas_taxas ";
  $sBusca .= " where cod_cadastro = $iCadastro ";
  $sBusca .= "   and cod_natureza = $iNatureza ";

  $rsBusca = db_query($pConexaoOrigem1, $sBusca, $sArquivoLog); 
  if ( db_numrows($rsBusca, $sArquivoLog) > 0 ){
    $oTaxas =  db_utils::fieldsmemory($rsBusca, 0);
    if( (int)$sTaxa == 1 || (int)$sTaxa == 9 ){ //Taxa_01 
       $iProced = (int)$oTaxas->tributo_01;
    }else if( (int)$sTaxa == 2 ){ //Taxa 02
       $iProced = (int)$oTaxas->tributo_02;
    }else if( (int)$sTaxa == 7 ){ //Taxa 07
       $iProced = $oTaxas->tributo_07;
    }
  }
/*
  if( $iCadastro == 1 ){
    if( (int)$sTaxa == 1 ){ //IPTU
      if( $iNatureza == 1 ){ //Territorial
        $iProced = 2;
      }else if( $iNatureza == 2 ){ //Predial
        $iProced = 1;
      }else if( $iNatureza == 5 ){ // Obra de Pavimentacao - Contribuicoes de Melhoria.
         $iProced = 5;
      }else if( $iNatureza == 11 ){ //
      }
    }else if( (int)$sTaxa == 2 ){ //Coleta Lixo
      $iProced = 3;
    }else if( (int)$sTaxa == 7 ){ //Tx Expediente
      $iProced = 7;
    }

  }else if( $iCadastro == 2 ){ //ISSQN
    if( (int)$sTaxa == 1 ){
      if( $iNatureza == 3 ){ //Fixo
        $iProced = 11;
      }else if( $iNatureza == 4 ){ //Mensal
        $iProced = 12;
      }else if( $iNatureza == 7 ) { //Tx Fisc.
        $iProced = 13;
      }else if( $iNatureza == 9 ){ ///Tx Loc.
        $iProced = 14;
      }
    }else if( (int)$sTaxa == 7 ){ // Tx Fisc.
      $iProced = 7;
    }
  }else if( $iCadastro == 4 ){
    if( $iNatureza == 4 ){ //Sindicancia
      $iProced = 31;
    }else if( $iNatureza == 12 ){ //Habitacao Popular
      $iProced = 6;
    }else{ //Parcelamento Sindicancia
      $iProced = 36;
    }
  }

/*
 cod_cadastro | cod_natureza |               |(rec)  Tx 01      |(rec)  Tx 07         
--------------+--------------+---------------+------------------+--------------+
            2 |            3 | ISS Fixo      |(11) ISS Fixo     |(7) Tx Expediente
            2 |            4 | ISS Mensal    |(12) ISS MEnsal   |(7) Tx Expediente
            2 |            7 | Tx Fisc.      |(13) Tx Fisca     |(7) Tx Expediente
            2 |            9 | Tx Loc.       |(13) Tx Fisca     |(7) Tx Expediente
            2 |           10 | Parc. D. Atv  |     Parc. D. Atv |(7) Tx Expediente
            2 |           11 | Parc. Ant.    |     Parc. Ant.   |(7) Tx Expeidente
*/

   return $iProced;
}


/**
 * Retorna reduzida da conta pagadora de 2009 de Dom Feliciano
 */
function Localiza_Reduzido( $iBanco, $pConexaoOrigem1, $pConexaoDestino1, $sArquivoLog){

  $iReduzido = 0;

  $sBusca  = "select * from pessoas.tr_bv_bancos ";
  $sBusca .= " where cod_banco = $iBanco ";
  $sBusca .= "   and ano = 2009 ";

  $rsBusca = db_query($pConexaoOrigem1, $sBusca, $sArquivoLog); 
  if ( db_numrows($rsBusca, $sArquivoLog) > 0 ){
    $oEstrutural =  db_utils::fieldsmemory($rsBusca, 0);
    $sReduzido   = "SELECT c61_reduz, c61_instit, c61_codigo ";
    $sReduzido  .= "  from contabilidade.conplano ";
    $sReduzido  .= " inner join contabilidade.conplanoreduz on c61_anousu = c60_anousu and c61_codcon = c60_codcon ";
    $sReduzido  .= " where c60_anousu = 2009 ";
    $sReduzido  .= "   and c60_estrut = '{$oEstrutural->class_contabil}' ";
    $sReduzido  .= "   and c61_codigo = 1;";

    $rsReduzido = db_query($pConexaoDestino1, $sReduzido, $sArquivoLog);
    if ( db_numrows($rsReduzido, $sArquivoLog) > 0 ){
      $oReduzido =  db_utils::fieldsmemory($rsReduzido, 0);
      $iReduzido = $oReduzido->c61_reduz;
    }
  }

  return $iReduzido;
}

?>
