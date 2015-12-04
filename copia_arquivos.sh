#!/bin/sh

$ip = "192.168.0.11"
$usuario = "contass"
$diretorio = "e-cidade_2_3_19"

scp db_empcontrat* db_rescisao* db_apostilamento* db_contrato*  db_itensaditi* db_aditi*  $usuario@$ip:/var/www/$diretorio/classes
scp func_contrat* func_aditi* func_rescisaocontra* func_apostila*  $usuario@$ip:/var/www/$diretorio
scp sic1_contrat* sic1_empcontrat* sic1_aditi* sic1_rescisaocontra* sic_apostila*  $usuario@$ip:/var/www/$diretorio
scp db_frmapostilamento* db_frmrescisaocontra* db_frmaditi* db_frmitensaditi* db_frmcontrat* db_frmempcontrat*  $usuario@$ip:/var/www/$diretorio/forms

