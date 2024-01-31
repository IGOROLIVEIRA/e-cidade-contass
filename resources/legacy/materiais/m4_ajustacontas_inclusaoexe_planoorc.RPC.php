<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("libs/JSON.php");

db_postmemory($_POST);

$oJson = new services_json();
$oParam = json_decode(str_replace('\\', '', $_POST["json"]));

$tiposSelecionados = $oParam->tipo;
$anoOrigem = $oParam->anoOrigem;
$anoDestino = $oParam->anoDestino;

$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->erro = '';

foreach ($tiposSelecionados as $tipo) {

    try {

        switch ($tipo) {

            case "conplanoorcamento":

                $error = ajustaPlanoOrc($anoOrigem, $anoDestino);
                if ($error){
                    throw new Exception($error);
                }
                break;

            case "conplanoconplanoorcamento":

                $error = ajustaVinculoPcasp($anoOrigem, $anoDestino);
                if ($error){
                    throw new Exception($error);
                }
                break;

            case "conplanoorcamentogrupo":

                $error = ajustaGrupoPlanoOrc($anoOrigem, $anoDestino);
                if ($error){
                    throw new Exception($error);
                }
                break;

            case "orcelemento":

                $error = ajustaOrcelemento($anoDestino);
                if ($error){
                    throw new Exception($error);
                }
                break;

            case "orcfontes":

                $error = ajustaOrcfontes($anoOrigem, $anoDestino);
                if ($error){
                    throw new Exception($error);
                }
                break;
        }

    } catch (Exception $e) {
        $oRetorno->erro = urlencode($e->getMessage());
        $oRetorno->status = 2;
    }
}

function ajustaPlanoOrc($anoOrigem, $anoDestino): ?string
{
    $result = db_query("CREATE TEMP TABLE tempconplanoorcamento ON COMMIT DROP AS
                        SELECT * FROM conplanoorcamento
                        WHERE c60_anousu={$anoOrigem};
                        
                        UPDATE tempconplanoorcamento
                        SET c60_anousu={$anoDestino};
                        
                        DELETE FROM tempconplanoorcamento
                        WHERE c60_estrut IN
                                (SELECT c60_estrut FROM conplanoorcamento
                                 WHERE c60_anousu={$anoDestino})
                            OR c60_codcon IN
                                (SELECT c60_codcon FROM conplanoorcamento
                                 WHERE c60_anousu={$anoDestino})
                            OR substr(c60_estrut,1,1) NOT IN ('3', '4');
                        
                        INSERT INTO conplanoorcamento
                            (SELECT * FROM tempconplanoorcamento);
                        
                        CREATE TEMP TABLE tempconplanoorcamentoanalitica ON COMMIT DROP AS
                        SELECT * FROM conplanoorcamentoanalitica
                        WHERE c61_anousu = {$anoOrigem};
                        
                        UPDATE tempconplanoorcamentoanalitica SET c61_anousu={$anoDestino};
                        
                        DELETE FROM tempconplanoorcamentoanalitica
                        WHERE c61_reduz IN
                                (SELECT c61_reduz FROM conplanoorcamentoanalitica
                                 WHERE c61_anousu={$anoDestino});
                        
                        INSERT INTO conplanoorcamentoanalitica
                            (SELECT tempconplanoorcamentoanalitica.* FROM tempconplanoorcamentoanalitica
                             JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu))");

    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar as Contas do Plano Orçamentário!<br>";
        return $error;
    }
    return null;
}

function ajustaVinculoPcasp($anoOrigem, $anoDestino): ?string
{
    $result = db_query("CREATE TEMP TABLE vinculos ON COMMIT DROP AS
                        SELECT conplanoconplanoorcamento.* FROM conplanoconplanoorcamento
                        JOIN conplanoorcamento ON (c72_conplanoorcamento, conplanoorcamento.c60_anousu) = (conplanoorcamento.c60_codcon, {$anoDestino})
                        JOIN conplano ON (c72_conplano, conplano.c60_anousu) = (conplano.c60_codcon, {$anoDestino})
                        WHERE c72_anousu = {$anoOrigem};
                        
                        UPDATE vinculos SET c72_anousu = {$anoDestino};
                        
                        DELETE FROM vinculos
                        WHERE c72_conplanoorcamento IN
                                (SELECT c72_conplanoorcamento FROM conplanoconplanoorcamento
                                 WHERE c72_anousu = {$anoDestino});
                        
                        INSERT INTO conplanoconplanoorcamento
                          SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') as c72_sequencial,
                                c72_conplano,
                                c72_conplanoorcamento,
                                c72_anousu
                           FROM vinculos");

    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "<br>Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar vinculo do Plano Orçamentário com o PCASP!<br>";
        return $error;
    }
    return null;
}

function ajustaGrupoPlanoOrc($anoOrigem, $anoDestino): ?string
{
    $result = db_query("CREATE TEMP TABLE grupos ON COMMIT DROP AS
                        SELECT conplanoorcamentogrupo.* FROM conplanoorcamentogrupo
                        JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c21_codcon, {$anoDestino})
                        WHERE c21_anousu = {$anoOrigem};
                        
                        UPDATE grupos SET c21_anousu = {$anoDestino};
                        
                        DELETE FROM grupos
                        WHERE (c21_codcon, c21_instit) IN
                                (SELECT c21_codcon, c21_instit FROM conplanoorcamentogrupo
                                 WHERE c21_anousu = {$anoDestino});
                        
                        
                        INSERT INTO conplanoorcamentogrupo
                        SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq') AS c21_sequencial,
                               c21_anousu,
                               c21_codcon,
                               c21_congrupo,
                               c21_instit
                        FROM grupos");

    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "<br>Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar os Grupos do Plano Orçamentário!<br>";
        return $error;
    }
    return null;
}

function ajustaOrcelemento($anoDestino): ?string
{
    $result = db_query("INSERT INTO orcelemento
                        SELECT c60_codcon,
                               c60_anousu,
                               substr(c60_estrut,1,13),
                               c60_descr,
                               c60_finali,
                               't' AS o56_orcado
                        FROM conplanoorcamento
                        WHERE c60_anousu = {$anoDestino}
                            AND substr(c60_estrut,1,1) = '3'
                            AND (c60_codcon, substr(c60_estrut,1,13)) NOT IN
                                (SELECT o56_codele, o56_elemento FROM orcelemento
                                 WHERE o56_anousu = c60_anousu) ");
    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "<br>Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar as Contas do Plano Orçamentário para as Despesas!<br>";
        return $error;
    }
    return null;
}


function ajustaOrcfontes($anoOrigem, $anoDestino): ?string
{
    $result = db_query("INSERT INTO orcfontes
                        SELECT c60_codcon,
                               c60_anousu,
                               c60_estrut,
                               c60_descr,
                               c60_finali
                        FROM conplanoorcamento
                        WHERE c60_anousu = {$anoDestino}
                            AND substr(c60_estrut,1,1) = '4'
                            AND c60_codcon NOT IN
                                (SELECT o57_codfon FROM orcfontes
                                 WHERE o57_anousu = c60_anousu);

                        INSERT INTO orcfontesdes
                        SELECT t2.o57_codfon,
                               t2.o57_anousu,
                               o60_perc
                        FROM orcfontesdes
                        JOIN orcfontes t1 ON (t1.o57_codfon, t1.o57_anousu) = (o60_codfon, o60_anousu)
                        JOIN orcfontes t2 ON (t2.o57_fonte, t2.o57_anousu) = (t1.o57_fonte, {$anoDestino})
                        WHERE o60_anousu = {$anoOrigem}
                          AND t2.o57_codfon NOT IN (SELECT o60_codfon FROM orcfontesdes WHERE o60_anousu = {$anoDestino})");

    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "<br>Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar as Contas do Plano Orçamentário para as Receitas!<br>";
        return $error;
    }
    return null;
}

echo $oJson->encode($oRetorno);
