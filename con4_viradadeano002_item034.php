<?php
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

// Para garantir que nao houve erros em outros itens
if($sqlerro==false) {
    $iTotPassos = 2;
    db_atutermometro(0, $iTotPassos, 'termometroitem', 1, $sMensagemTermometroItem);

    //De/Para Vinculo Pcasp MSC
    $sqlVinculoPcaspMscorigem = "select * from vinculopcaspmsc where c210_anousu = $anoorigem limit 1";
    $resultVinculoPcaspMscorigem = db_query($sqlVinculoPcaspMscorigem);
    $linhasVinculoPcaspMscorigem = pg_num_rows($resultVinculoPcaspMscorigem);

    $sqlVinculoPcaspMscdestino = "select * from vinculopcaspmsc where c210_anousu = $anodestino limit 1";
    $resultVinculoPcaspMscdestino = db_query($sqlVinculoPcaspMscdestino);
    $linhasVinculoPcaspMscdestino = pg_num_rows($resultVinculoPcaspMscdestino);

    if (($linhasVinculoPcaspMscorigem > 0) && ($linhasVinculoPcaspMscdestino == 0 )) {

        $sqlVinculoPcaspMsc = "select fc_duplica_exercicio('vinculopcaspmsc', 'c210_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultVinculoPcaspMsc = db_query($sqlVinculoPcaspMsc);
        if ($resultVinculoPcaspMsc==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultVinculoPcaspMsc);
        }

    } else {
        if ($linhasVinculoPcaspMscorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem vínculos para ano de origem $anoorigem";
        } else if ($linhasVinculoPcaspMscdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem vínculos para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010454;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Elemento Despesa MSC
    $sqlElemDespMscorigem = "select * from elemdespmsc where c211_anousu = $anoorigem limit 1";
    $resultElemDespMscorigem = db_query($sqlElemDespMscorigem);
    $linhasElemDespMscorigem = pg_num_rows($resultElemDespMscorigem);

    $sqlElemDespMscdestino = "select * from elemdespmsc where c211_anousu = $anodestino limit 1";
    $resultElemDespMscdestino = db_query($sqlElemDespMscdestino);
    $linhasElemDespMscdestino = pg_num_rows($resultElemDespMscdestino);

    if (($linhasElemDespMscorigem > 0) && ($linhasElemDespMscdestino == 0 )) {

        $sqlElemDespMsc = "select fc_duplica_exercicio('elemdespmsc', 'c211_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultElemDespMsc = db_query($sqlElemDespMsc);
        if ($resultElemDespMsc==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultElemDespMsc);
        }

    } else {
        if ($linhasElemDespMscorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem elementos para ano de origem $anoorigem";
        } else if ($linhasElemDespMscdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem elementos para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010455;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Natureza Despesa MSC
    $sqlNatDespMscorigem = "select * from natdespmsc where c212_anousu = $anoorigem limit 1";
    $resultNatDespMscorigem = db_query($sqlNatDespMscorigem);
    $linhasNatDespMscorigem = pg_num_rows($resultNatDespMscorigem);

    $sqlNatDespMscdestino = "select * from natdespmsc where c212_anousu = $anodestino limit 1";
    $resultNatDespMscdestino = db_query($sqlNatDespMscdestino);
    $linhasNatDespMscdestino = pg_num_rows($resultNatDespMscdestino);

    if (($linhasNatDespMscorigem > 0) && ($linhasNatDespMscdestino == 0 )) {

        $sqlNatDespMsc = "select fc_duplica_exercicio('natdespmsc', 'c212_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultNatDespMsc = db_query($sqlNatDespMsc);
        if ($resultNatDespMsc==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultNatDespMsc);
        }

    } else {
        if ($linhasNatDespMscorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem naturezas para ano de origem $anoorigem";
        } else if ($linhasNatDespMscdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem naturezas para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010456;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Natureza Despesa Siope
    $sqlNatDespSiopeorigem = "select * from naturdessiope where c222_anousu = $anoorigem limit 1";
    $resultNatDespSiopeorigem = db_query($sqlNatDespSiopeorigem);
    $linhasNatDespSiopeorigem = pg_num_rows($resultNatDespSiopeorigem);

    $sqlNatDespSiopedestino = "select * from naturdessiope where c222_anousu = $anodestino limit 1";
    $resultNatDespSiopedestino = db_query($sqlNatDespSiopedestino);
    $linhasNatDespSiopedestino = pg_num_rows($resultNatDespSiopedestino);

    if (($linhasNatDespSiopeorigem > 0) && ($linhasNatDespSiopedestino == 0 )) {

        $sqlNatDespSiope = "select fc_duplica_exercicio('naturdessiope', 'c222_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultNatDespSiope = db_query($sqlNatDespSiope);
        if ($resultNatDespSiope==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultNatDespSiope);
        }

    } else {
        if ($linhasNatDespSiopeorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem naturezas para ano de origem $anoorigem";
        } else if ($linhasNatDespSiopedestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem naturezas para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010459;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Elemento Despesa Siope
    $sqlElemDespSiopeorigem = "select * from eledessiope where c223_anousu = $anoorigem limit 1";
    $resultElemDespSiopeorigem = db_query($sqlElemDespSiopeorigem);
    $linhasElemDespSiopeorigem = pg_num_rows($resultElemDespSiopeorigem);

    $sqlElemDespSiopedestino = "select * from eledessiope where c223_anousu = $anodestino limit 1";
    $resultElemDespSiopedestino = db_query($sqlElemDespSiopedestino);
    $linhasElemDespSiopedestino = pg_num_rows($resultElemDespSiopedestino);

    if (($linhasElemDespSiopeorigem > 0) && ($linhasElemDespSiopedestino == 0 )) {

        $sqlElemDespSiope = "select fc_duplica_exercicio('eledessiope', 'c223_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultElemDespSiope = db_query($sqlElemDespSiope);
        if ($resultElemDespSiope==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultElemDespSiope);
        }

    } else {
        if ($linhasElemDespSiopeorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem elementos para ano de origem $anoorigem";
        } else if ($linhasElemDespSiopedestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem elementos para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010460;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Natureza Receita Siope
    $sqlNatRecSiopeorigem = "select * from naturrecsiope where c224_anousu = $anoorigem limit 1";
    $resultNatRecSiopeorigem = db_query($sqlNatRecSiopeorigem);
    $linhasNatRecSiopeorigem = pg_num_rows($resultNatRecSiopeorigem);

    $sqlNatRecSiopedestino = "select * from naturrecsiope where c224_anousu = $anodestino limit 1";
    $resultNatRecSiopedestino = db_query($sqlNatRecSiopedestino);
    $linhasNatRecSiopedestino = pg_num_rows($resultNatRecSiopedestino);

    if (($linhasNatRecSiopeorigem > 0) && ($linhasNatRecSiopedestino == 0 )) {

        $sqlNatRecSiope = "select fc_duplica_exercicio('naturrecsiope', 'c224_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultNatRecSiope = db_query($sqlNatRecSiope);
        if ($resultNatRecSiope==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultNatRecSiope);
        }

    } else {
        if ($linhasNatRecSiopeorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem naturezas para ano de origem $anoorigem";
        } else if ($linhasNatRecSiopedestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem naturezas para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010459;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Elemento Receita Siope
    $sqlElemRecSiopeorigem = "select * from elerecsiope where c225_anousu = $anoorigem limit 1";
    $resultElemRecSiopeorigem = db_query($sqlElemRecSiopeorigem);
    $linhasElemRecSiopeorigem = pg_num_rows($resultElemRecSiopeorigem);

    $sqlElemRecSiopedestino = "select * from elerecsiope where c225_anousu = $anodestino limit 1";
    $resultElemRecSiopedestino = db_query($sqlElemRecSiopedestino);
    $linhasElemRecSiopedestino = pg_num_rows($resultElemRecSiopedestino);

    if (($linhasElemRecSiopeorigem > 0) && ($linhasElemRecSiopedestino == 0 )) {

        $sqlElemRecSiope = "select fc_duplica_exercicio('elerecsiope', 'c225_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultElemRecSiope = db_query($sqlElemRecSiope);
        if ($resultElemRecSiope==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultElemRecSiope);
        }

    } else {
        if ($linhasElemRecSiopeorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem elementos para ano de origem $anoorigem";
        } else if ($linhasElemRecSiopedestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem elementos para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010462;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Natureza Despesa Siops
    $sqlNatDespSiopsorigem = "select * from naturdessiops where c226_anousu = $anoorigem limit 1";
    $resultNatDespSiopsorigem = db_query($sqlNatDespSiopsorigem);
    $linhasNatDespSiopsorigem = pg_num_rows($resultNatDespSiopsorigem);

    $sqlNatDespSiopsdestino = "select * from naturdessiops where c226_anousu = $anodestino limit 1";
    $resultNatDespSiopsdestino = db_query($sqlNatDespSiopsdestino);
    $linhasNatDespSiopsdestino = pg_num_rows($resultNatDespSiopsdestino);

    if (($linhasNatDespSiopsorigem > 0) && ($linhasNatDespSiopsdestino == 0 )) {

        $sqlNatDespSiops = "select fc_duplica_exercicio('naturdessiops', 'c226_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultNatDespSiops = db_query($sqlNatDespSiops);
        if ($resultNatDespSiops==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultNatDespSiops);
        }

    } else {
        if ($linhasNatDespSiopsorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem naturezas para ano de origem $anoorigem";
        } else if ($linhasNatDespSiopsdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem naturezas para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010463;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Elemento Despesa Siops
    $sqlElemDespSiopsorigem = "select * from eledessiops where c227_anousu = $anoorigem limit 1";
    $resultElemDespSiopsorigem = db_query($sqlElemDespSiopsorigem);
    $linhasElemDespSiopsorigem = pg_num_rows($resultElemDespSiopsorigem);

    $sqlElemDespSiopsdestino = "select * from eledessiops where c227_anousu = $anodestino limit 1";
    $resultElemDespSiopsdestino = db_query($sqlElemDespSiopsdestino);
    $linhasElemDespSiopsdestino = pg_num_rows($resultElemDespSiopsdestino);

    if (($linhasElemDespSiopsorigem > 0) && ($linhasElemDespSiopsdestino == 0 )) {

        $sqlElemDespSiops = "select fc_duplica_exercicio('eledessiops', 'c227_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultElemDespSiops = db_query($sqlElemDespSiops);
        if ($resultElemDespSiops==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultElemDespSiops);
        }

    } else {
        if ($linhasElemDespSiopsorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem elementos para ano de origem $anoorigem";
        } else if ($linhasElemDespSiopsdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem elementos para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010464;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Nome Arquivo Despesa Siops
    $sqlElemNomeArqDespSiopsorigem = "select * from nomearqdessiops where c228_anousu = $anoorigem limit 1";
    $resultElemNomeArqDespSiopsorigem = db_query($sqlElemNomeArqDespSiopsorigem);
    $linhasElemNomeArqDespSiopsorigem = pg_num_rows($resultElemNomeArqDespSiopsorigem);

    $sqlElemNomeArqDespSiopsdestino = "select * from nomearqdessiops where c228_anousu = $anodestino limit 1";
    $resultElemNomeArqDespSiopsdestino = db_query($sqlElemNomeArqDespSiopsdestino);
    $linhasElemNomeArqDespSiopsdestino = pg_num_rows($resultElemNomeArqDespSiopsdestino);

    if (($linhasElemNomeArqDespSiopsorigem > 0) && ($linhasElemNomeArqDespSiopsdestino == 0 )) {

        $sqlElemNomeArqDespSiops = "select fc_duplica_exercicio('nomearqdessiops', 'c228_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultElemNomeArqDespSiops = db_query($sqlElemNomeArqDespSiops);
        if ($resultElemNomeArqDespSiops==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultElemNomeArqDespSiops);
        }

    } else {
        if ($linhasElemNomeArqDespSiopsorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem nomes dos arquivos despesa siops para ano de origem $anoorigem";
        } else if ($linhasElemNomeArqDespSiopsdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem nomes dos arquivos despesa siops para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010465;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Natureza Receita Siops
    $sqlNatRecSiopsorigem = "select * from naturrecsiops where c230_anousu = $anoorigem limit 1";
    $resultNatRecSiopsorigem = db_query($sqlNatRecSiopsorigem);
    $linhasNatRecSiopsorigem = pg_num_rows($resultNatRecSiopsorigem);

    $sqlNatRecSiopsdestino = "select * from naturrecsiops where c230_anousu = $anodestino limit 1";
    $resultNatRecSiopsdestino = db_query($sqlNatRecSiopsdestino);
    $linhasNatRecSiopsdestino = pg_num_rows($resultNatRecSiopsdestino);

    if (($linhasNatRecSiopsorigem > 0) && ($linhasNatRecSiopsdestino == 0 )) {

        $sqlNatRecSiops = "select fc_duplica_exercicio('naturrecsiops', 'c230_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultNatRecSiops = db_query($sqlNatRecSiops);
        if ($resultNatRecSiops==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultNatRecSiops);
        }

    } else {
        if ($linhasNatRecSiopsorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem naturezas para ano de origem $anoorigem";
        } else if ($linhasNatRecSiopsdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem naturezas para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010470;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    //De/Para Elemento Receita Siops
    $sqlElemRecSiopsorigem = "select * from elerecsiops where c231_anousu = $anoorigem limit 1";
    $resultElemRecSiopsorigem = db_query($sqlElemRecSiopsorigem);
    $linhasElemRecSiopsorigem = pg_num_rows($resultElemRecSiopsorigem);

    $sqlElemRecSiopsdestino = "select * from elerecsiops where c231_anousu = $anodestino limit 1";
    $resultElemRecSiopsdestino = db_query($sqlElemRecSiopsdestino);
    $linhasElemRecSiopsdestino = pg_num_rows($resultElemRecSiopsdestino);

    if (($linhasElemRecSiopsorigem > 0) && ($linhasElemRecSiopsdestino == 0 )) {

        $sqlElemRecSiops = "select fc_duplica_exercicio('elerecsiops', 'c231_anousu', ".$anoorigem.",".$anodestino.",null);";
        $resultElemRecSiops = db_query($sqlElemRecSiops);
        if ($resultElemRecSiops==true) {
            $sqlerro = false;
        } else {
            $sqlerro = true;
            $erro_msg = pg_last_error($resultElemRecSiops);
        }

    } else {
        if ($linhasElemRecSiopsorigem == 0) {
            $cldb_viradaitemlog->c35_log = "Não existem elementos para ano de origem $anoorigem";
        } else if ($linhasElemRecSiopsdestino>0) {
            $cldb_viradaitemlog->c35_log = "Ja existem elementos para ano de destino $anodestino";
        }
        $cldb_viradaitemlog->c35_codarq        = 2010471;
        $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
        $cldb_viradaitemlog->c35_data          = date("Y-m-d");
        $cldb_viradaitemlog->c35_hora          = date("H:i");
        $cldb_viradaitemlog->incluir(null);
        if ($cldb_viradaitemlog->erro_status==0) {
            $sqlerro = true;
            $erro_msg = $cldb_viradaitemlog->erro_msg;
        }

    }

    db_atutermometro(1, $iTotPassos, 'termometroitem', 1, $sMensagemTermometroItem);
}

?>