<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
include ("classes/db_benstransfconf_classe.php");
include ("classes/db_benstransfcodigo_classe.php");
include ("classes/db_benstransfdes_classe.php");
include ("classes/db_histbemtrans_classe.php");
include ("classes/db_db_usuarios_classe.php");
include ("classes/db_histbem_classe.php");
include ("classes/db_bens_classe.php");
include ("classes/db_departdiv_classe.php");
include ("classes/db_histbemdiv_classe.php");
include ("classes/db_bensdiv_classe.php");
include ("classes/db_histbensocorrencia_classe.php");
include ("classes/db_benstransf_classe.php");
include ("classes/db_benstransfdiv_classe.php");

$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = json_decode(str_replace('\\', '',$_POST["json"]));

$cldb_usuarios = new cl_db_usuarios;
$clbenstransfconf = new cl_benstransfconf;
$clbenstransfcodigo = new cl_benstransfcodigo;
$clbenstransfdes = new cl_benstransfdes;
$clbenstransf = new cl_benstransf();
$clhistbemtrans = new cl_histbemtrans;
$clhistbem = new cl_histbem;
$clbens = new cl_bens;
$cldepartdiv = new cl_departdiv;
$clhistbemdiv = new cl_histbemdiv;
$clbensdiv = new cl_bensdiv;
$clhistbemocorrencia = new cl_histbensocorrencia;
$clbenstransfdiv = new cl_benstransfdiv;
$db_opcao = 1;
$db_botao = true;

$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';

try{
    db_fim_transacao ();

    switch($oParam->exec) {

        case 'Transferir':

            $resulttipo = $clbenstransf->sql_record($clbenstransf->sql_query($oParam->t96_codtran,"benstransf.*"));

            if($clbenstransf->numrows>0){
                db_fieldsmemory($resulttipo,0);
            }

            $sqlerro = false;
            db_inicio_transacao();

            if ($sqlerro == false) {
                $clbenstransfconf->t96_codtran = $oParam->t96_codtran;
                $clbenstransfconf->t96_id_usuario = $t93_id_usuario;
                $clbenstransfconf->t96_data = $t93_data;
                $clbenstransfconf->incluir($oParam->t96_codtran);
                if ($clbenstransfconf->erro_status == 0) {
                    $sqlerro = true;
                }
                $erro_msg = $clbenstransfconf->erro_msg;
            }

            if ($sqlerro == false) {

                //rotina que ira incluir na tabela histbem
                $result_dpto = $clbenstransfdes->sql_record($clbenstransfdes->sql_query_file($oParam->t96_codtran, "t94_depart"));

                $result = $clbenstransfcodigo->sql_record($clbenstransfcodigo->sql_query_file($oParam->t96_codtran));

                $numrows = $clbenstransfcodigo->numrows;

                if ($clbenstransfdes->numrows == 0) {
                    $erro_msg = _M("patrimonial.patrimonio.db_frmbenstransfconf.departamento_não_informado");
                    $sqlerro = true;
                } else
                    if ($clbenstransfcodigo->numrows == 0) {
                        $erro_msg = _M("patrimonial.patrimonio.db_frmbenstransfconf.nenhum_bem_informado");
                        $sqlerro = true;
                    } else {
                        db_fieldsmemory($result_dpto, 0);
                    }
                if ($sqlerro == false) {
                    for ($i = 0; $i < $numrows; $i ++) {
                        if ($sqlerro == false) {
                            db_fieldsmemory($result, $i);
                            $clhistbem->t56_codbem = $t95_codbem;
                            $clhistbem->t56_data   = $t93_data;
                            $clhistbem->t56_depart = $t94_depart;
                            $clhistbem->t56_situac = $t95_situac;
                            $clhistbem->t56_histor = $t95_histor;
                            $clhistbem->incluir(null);
                            $t97_histbem = $clhistbem->t56_histbem;
                            $erro_msg = $clhistbem->erro_msg;
                            if ($clhistbem->erro_status == 0) {
                                $sqlerro = true;
                                break;
                            }
                        }
                        //Inseri na tabela histbensocorrencia
                        if ($sqlerro == false) {
                            $sQueryOrigemDestino = "select dp1.descrdepto as origem, dp2.descrdepto as destino
																	from benstransf as bt1
																	inner join db_depart as dp1 on bt1.t93_depart = dp1.coddepto
																	inner join benstransfdes as btd1 on bt1.t93_codtran = btd1.t94_codtran
																	inner join db_depart as dp2 on dp2.coddepto = btd1.t94_depart
																	where bt1.t93_codtran = $oParam->t96_codtran";
                            $rsQueryOrigemDestino = db_query($sQueryOrigemDestino);
                            if (pg_num_rows($rsQueryOrigemDestino) == 1){
                                $rowQueryOrigemDestino = pg_fetch_object($rsQueryOrigemDestino);
                                $origem 	= $rowQueryOrigemDestino->origem;
                                $destino 	= $rowQueryOrigemDestino->destino;
                            }
                            //$t56_codbem
                            //$this->t69_sequencial 			= null;
                            $clhistbemocorrencia->t69_codbem 			=	$t95_codbem;
                            $clhistbemocorrencia->t69_ocorrenciasbens	=	1; // valor vem direto da tabela
                            $clhistbemocorrencia->t69_obs	 			=	substr("Bem transferido de $origem para $destino",0,50);
                            $clhistbemocorrencia->t69_dthist 			= date('Y-m-d',db_getsession('DB_datausu'));
                            $clhistbemocorrencia->t69_hora				= db_hora();
                            $clhistbemocorrencia->incluir(null);
                            if($clhistbemocorrencia->erro_status==0){
                                $sqlerro=true;
                                $erro_msg=$clhistbemocorrencia->erro_msg;
                            }
                        }

                        // altera na tabela bens
                        if ($sqlerro == false) {
                            $clbens->t52_bem = $t95_codbem;
                            $clbens->t52_depart = $t94_depart;
                            $clbens->alterar($t95_codbem);
                            $erro_msg = $clbens->erro_msg;
                            if ($clbens->erro_status == 0) {
                                $sqlerro = true;
                                break;
                            }
                        }

                        //incluir na tabela histbemtrans
                        if ($sqlerro == false) {
                            $clhistbemtrans->t97_histbem = $t97_histbem;
                            $clhistbemtrans->t97_codtran = $oParam->t96_codtran;
                            $clhistbemtrans->incluir($t97_histbem, $oParam->t96_codtran);
                            $erro_msg = $clhistbemtrans->erro_msg;
                            if ($clhistbemtrans->erro_status == 0) {
                                $sqlerro = true;
                                break;
                            }
                        }
                      $info = "t31_divisao_$t95_codbem";

                      if ($info!=""){

                        $result_clbenstransfdiv = $clbenstransfdiv->sql_record($clbenstransfdiv->sql_query_file(null,"t31_divisao",null,"t31_bem = $t95_codbem and t31_codtran = $oParam->t96_codtran"));
                        if($clbenstransfdiv->numrows>0){
                          db_fieldsmemory($result_clbenstransfdiv,0);
                        }

                        if($t31_divisao !=  null){
                          if ($sqlerro == false) {
                            $clhistbemdiv->t32_histbem=$t97_histbem;
                            $clhistbemdiv->t32_divisao=$t31_divisao;
                            $clhistbemdiv->incluir(null);
                            if ($clhistbemdiv->erro_status == 0) {
                              $sqlerro = true;
                              $erro_msg = $clhistbemdiv->erro_msg;
                              break;
                            }
                          }
                          if ($sqlerro == false) {
                            $result_bensdiv=$clbensdiv->sql_record($clbensdiv->sql_query_file($t95_codbem));
                            if ($clbensdiv->numrows>0){
                              $clbensdiv->excluir($t95_codbem);
                              if($clbensdiv->erro_status==0){
                                $sqlerro=true;
                                $erro_msg=$clbensdiv->erro_msg;
                              }
                            }
                            if ($sqlerro == false) {
                              $clbensdiv->t33_divisao=$t31_divisao;
                              $clbensdiv->incluir($t95_codbem);
                              if($clbensdiv->erro_status==0){
                                $sqlerro=true;
                                $erro_msg=$clbensdiv->erro_msg;
                              }
                            }
                          }
                        }
                        }else{
                            if ($sqlerro == false) {
                                $result_bensdiv=$clbensdiv->sql_record($clbensdiv->sql_query_file($t95_codbem));
                                if ($clbensdiv->numrows>0){
                                    $clbensdiv->excluir($t95_codbem);
                                    if($clbensdiv->erro_status==0){
                                        $sqlerro=true;
                                        $erro_msg=$clbensdiv->erro_msg;
                                    }
                                }
                            }
                        }
                      if($t31_divisao == null){
                          $clbensdiv->excluir($t95_codbem);
                      }
                    }
                }

                //fim
                db_fim_transacao($sqlerro);
            }

            break;
    }

    db_fim_transacao (true);

} catch (Exception $eErro) {
    $oRetorno->erro  = true;
    $oRetorno->status = 2;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);
