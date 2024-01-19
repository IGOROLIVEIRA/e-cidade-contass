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

            case "conplano":

                $error = ajustaContasPcasp($anoOrigem, $anoDestino);
                if ($error){
                    throw new Exception($error);
                }
                break;

            case "conplanocontacorrente":


                $error = ajustaPcaspContaCorrente($anoOrigem, $anoDestino);
                if ($error){
                    throw new Exception($error);
                }
                break;

            case "conplanoconta":

                $error = ajustaVinculoPcaspCtaBanco($anoOrigem, $anoDestino);
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

function ajustaContasPcasp($anoOrigem, $anoDestino): ?string
{
    $result = db_query("CREATE TEMP TABLE tempconplano ON COMMIT DROP AS
                        SELECT * FROM conplano
                        WHERE c60_anousu={$anoOrigem};
                        
                        UPDATE tempconplano
                        SET c60_anousu={$anoDestino};
                        
                        DELETE FROM tempconplano
                        WHERE c60_estrut IN
                                (SELECT c60_estrut FROM conplano
                                 WHERE c60_anousu={$anoDestino})
                            OR c60_codcon IN
                                (SELECT c60_codcon FROM conplano
                                 WHERE c60_anousu={$anoDestino});
                        
                        INSERT INTO conplano
                            (SELECT * FROM tempconplano);
                        
                        CREATE TEMP TABLE tempconplanoreduz ON COMMIT DROP AS
                        SELECT * FROM conplanoreduz
                        WHERE c61_anousu = {$anoOrigem};
                        
                        UPDATE tempconplanoreduz SET c61_anousu={$anoDestino};
                        
                        DELETE FROM tempconplanoreduz
                        WHERE c61_reduz IN
                                (SELECT c61_reduz FROM conplanoreduz
                                 WHERE c61_anousu={$anoDestino});
                        
                        INSERT INTO conplanoreduz
                            (SELECT tempconplanoreduz.* FROM tempconplanoreduz
                             JOIN conplano ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu));
                        
                        INSERT INTO conplanoexe
                        SELECT {$anoDestino} as c62_anousu,
                               c62_reduz,
                               c62_codrec,
                               c62_vlrcre,
                               c62_vlrdeb
                         FROM conplanoexe
                         WHERE c62_reduz IN
                              (SELECT c61_reduz FROM tempconplanoreduz)
                         AND c62_reduz NOT IN (SELECT c62_reduz FROM conplanoexe WHERE c62_anousu = {$anoDestino})
                         AND c62_anousu = {$anoOrigem}");

    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar as Contas do PCASP!<br>";
        return $error;
    }

    return null;
}

function ajustaPcaspContaCorrente($anoOrigem, $anoDestino): ?string
{
    $result = db_query("INSERT INTO conplanocontacorrente
                        SELECT nextval('conplanocontacorrente_c18_sequencial_seq') AS c18_sequencial,
                               c18_codcon,
                               c60_anousu,
                               c18_contacorrente
                        FROM conplanocontacorrente
                        JOIN conplano ON (c60_codcon, c60_anousu) = (c18_codcon, {$anoDestino})
                        WHERE c18_anousu = {$anoOrigem}
                        AND c18_codcon NOT IN (SELECT c18_codcon FROM conplanocontacorrente WHERE c18_anousu = {$anoDestino})");

    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "<br>Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar os Vinculos do PCASP com Conta Corrente!<br>";
        return $error;
    }

    return null;
}

function ajustaVinculoPcaspCtaBanco($anoOrigem, $anoDestino): ?string
{
    $result = db_query("INSERT INTO conplanoconta
                        SELECT c63_codcon,
                               {$anoDestino} AS c63_anousu,
                               c63_banco,
                               c63_agencia,
                               c63_conta,
                               c63_dvconta,
                               c63_dvagencia,
                               c63_identificador,
                               c63_codigooperacao,
                               c63_tipoconta
                        FROM conplanoconta
                        WHERE c63_anousu = {$anoOrigem}
                            AND c63_codcon IN
                                (SELECT c61_codcon FROM conplanoreduz
                                 WHERE c61_anousu = {$anoDestino})
                            AND c63_codcon NOT IN
                                (SELECT c63_codcon FROM conplanoconta
                                 WHERE c63_anousu = {$anoDestino});                        
                        
                        INSERT INTO conplanocontabancaria
                        SELECT nextval('conplanocontabancaria_c56_sequencial_seq') AS c56_sequencial,
                               c56_contabancaria,
                               c56_codcon,
                               {$anoDestino} AS c56_anousu
                        FROM conplanocontabancaria
                        WHERE c56_anousu = {$anoOrigem}
                            AND c56_codcon NOT IN
                                (SELECT c56_codcon FROM conplanocontabancaria
                                 WHERE c56_anousu = {$anoDestino})
                            AND c56_codcon IN
                                (SELECT c61_codcon FROM conplanoreduz
                                 WHERE c61_anousu = {$anoDestino})");

    if (!$result) {
        $user = db_getsession('DB_id_usuario');
        $error = "<br>Usuário: {$user}!<br>";
        $error .= "Erro ao processar rotina!<br>";
        $error .= "Não foi possível reajustar os Vinculos do PCASP com as Contas Bancárias!<br>";
        return $error;
    }

    return null;
}

echo $oJson->encode($oRetorno);
