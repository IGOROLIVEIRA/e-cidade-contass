<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

//MODULO: veiculos
include_once("classes/db_cgm_classe.php");
include("classes/db_veiccadproced_classe.php");
include("classes/db_db_usuarios_classe.php");
include("classes/db_veiccadcateg_classe.php");
include("classes/db_veiccadcomb_classe.php");
include("classes/db_veiccadcategcnh_classe.php");
include("classes/db_veiccadpotencia_classe.php");
include("classes/db_veiccadtipo_classe.php");
include("classes/db_veiccadmarca_classe.php");
include("classes/db_veiccadcor_classe.php");
include("classes/db_veiccadtipocapacidade_classe.php");
include("classes/db_db_config_classe.php");
include("classes/db_ceplocalidades_classe.php");
include_once("classes/db_veictipoabast_classe.php");
include_once("classes/db_veiculoscomb_classe.php");
include_once("classes/db_tipoveiculos_classe.php");

$clcgm                   = new cl_cgm;
$clveiccadproced         = new cl_veiccadproced;
$clveiccadcateg          = new cl_veiccadcateg;
$clveiccadcomb           = new cl_veiccadcomb;
$clveiccadcategcnh       = new cl_veiccadcategcnh;
$clveiccadpotencia       = new cl_veiccadpotencia;
$clveiccadtipocapacidade = new cl_veiccadtipocapacidade;
$clveiccadtipo           = new cl_veiccadtipo;
$clveiccadmarca          = new cl_veiccadmarca;
$clveiccadcor            = new cl_veiccadcor;
$cldb_config             = new cl_db_config;
$clceplocalidades        = new cl_ceplocalidades;
$clveiculoscomb          = new cl_veiculoscomb;
$clveictipoabast         = new cl_veictipoabast;
$cltipoveiculos          = new cl_tipoveiculos;
$clusuarios              = new cl_db_usuarios();

$clveiculos->rotulo->label();
$clpcforne->rotulo->label();

$clrotulo = new rotulocampo;

$clrotulo->label("ve32_descr");
$clrotulo->label("ve31_descr");
$clrotulo->label("ve24_descr");
$clrotulo->label("cp05_localidades");
$clrotulo->label("ve20_descr");
$clrotulo->label("ve21_descr");
$clrotulo->label("ve22_descr");
$clrotulo->label("ve23_descr");
$clrotulo->label("ve25_descr");
$clrotulo->label("ve26_descr");
$clrotulo->label("ve30_descr");
$clrotulo->label("ve02_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("ve03_bem");
$clrotulo->label("t52_descr");
$clrotulo->label("ve06_veiccadcomb");
$clrotulo->label("ve07_sigla");
$clrotulo->label("ve40_veiccadcentral");
$clrotulo->label("descrdepto");
$clrotulo->label("z01_nomecgm");

/**
 * TABELA TIPO VEICULOS PARA MODULO SICOM
 */
$cltipoveiculos->rotulo->label();
 
$result_param=$clveicparam->sql_record($clveicparam->sql_query_file(null,"*",null," ve50_instit=".db_getsession("DB_instit")));
if ($clveicparam->numrows>0){
    db_fieldsmemory($result_param,0);
}

$usuario = db_getsession('DB_id_usuario');
$result_usuariosadm = $clusuarios->sql_record($clusuarios->sql_query_file(null,"id_usuario",null,"administrador = 1"));
if($clusuarios > 0 ){
    $aUsuAdm = array();
    for($iConUsu = 0; $iConUsu < pg_num_rows($result_usuariosadm); $iConUsu++){
        $aUsuAdm[] = db_utils::fieldsMemory($result_usuariosadm, $iConUsu)->id_usuario;
    }
}
?>
<form name="form1" id="form1" method="post" action="">
    <center>
        <table border="0">
            <tr>
                <?
                $ve01_instit = db_getsession("DB_instit");
                db_input('ve01_instit',10,$Ive01_instit,true,'hidden',3,"");
                ?>
                <td nowrap title="<?=@$Tve01_codigo?>">
                    <?=@$Lve01_codigo?>
                </td>
                <td>
                    <?
                    db_input('ve01_codigo',10,$Ive01_codigo,true,'text',3,"");
                    ?>
                    <? if(in_array($usuario,$aUsuAdm)): ?>

                        <b>Código Anterior: </b>
                        <?
                        db_input('ve01_codigoant',10,1,true,'text',$db_opcao,"");
                        ?>

                        <b>Código da Unidade: </b>
                        <?
                        db_input('ve01_codunidadesub',10,1,true,'text',$db_opcao,"","","","",8);
                        ?>
                    <?endif;?>
                </td>
            </tr>

            <tr>
                <td> <?=@$Lsi04_tipoveiculo?> </td>
                <td nowrap title="<?=@$Tsi04_tipoveiculo?>">
                    <?
                    $x = array(
                        0 =>'Selecione',
                        3 =>'Veículos',
                        1 =>'Aeronaves',
                        2 =>'Embarcações',
                        4 =>'Maquinário',
                        5 =>'Equipamentos',
                        99=>'Outros');
                    db_select('si04_tipoveiculo',$x,true,$db_opcao,
                        " onchange='js_verifica_select(this.value);js_tipodeveiculo(this.value)'");
                    ?>
                </td>
            </tr>
            <tr>
                <td> <?=@$Lsi04_especificacao?> </td>
                <td nowrap title="<?=@$Tsi04_especificacao?>">
                    <?
                    //$x = array('1'=>'Aeronaves');
                    $x = array('0'=> 'Selecione', '3' => 'Veículo de Passeio','4'=>'Utilitário (Camionete)','5' => 'Ônibus','6'=>'Caminho','7'=>'Motocicleta','8'=>'Van');
                    db_select('si04_especificacao', $x,true,$db_opcao,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td> <?=@$Lsi04_situacao?> </td>
                <td nowrap title="<?=@$Tsi04_situacao?>">
                    <?
                    $x = array('1'=>'Compõe o patrimônio do municipio (veiculo próprio)','2'=>'Terceirizado ou contratado','3'=>'Cedido, empréstimo de outro ente, convênio, acordo ou ajuste');
                    db_select('si04_situacao',$x,true,$db_opcao,"onchange='js_situacao();'");
                    ?>
                </td>
            </tr>

            <tr id="titulonumcgm" >
                <td nowrap title="<?=@$Tpc60_numcgm?>">
                    <?
                    db_ancora('Cgm',"js_pesquisapc60_numcgm(true);",($db_opcao==1||$db_opcao==2?$db_opcao:3));
                    ?>
                </td>
                <td>
                    <?
                    db_input('si04_numcgm',8,$Isi04_numcgm,true,'text',($db_opcao==1?$db_opcao:3)," onchange='js_pesquisapc60_numcgm(false);'",'','#C0C0C0')
                    ?>
                    <?
                    db_input('z01_nomecgm',40,$Iz01_nomecgm,true,'text',3,'')
                    ?>
                </td>
            </tr>

            <tr>
                <td> <b>Descrição:<b> </td>
                <td nowrap title="<?=@$Tsi04_descricao?>">
                    <?
                    db_textarea('si04_descricao',8,70,$Isi04_descricao,true,'text',$db_opcao,"","","",100);
                    ?>
                </td>
            </tr>

            <tr class="tr__hidden">
                <td nowrap title="<?=@$Tve01_placa?>">
                    <?=@$Lve01_placa?>
                </td>
                <td>
                    <?
                    db_input('ve01_placa',10,$Ive01_placa,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr class="tr__numcgm">
                <td nowrap title="<?=@$Tve02_numcgm?>"><?=@$Lve02_numcgm?></td>
                <td>
                    <?
                    $result_motora=$clcgm->sql_record($clcgm->sql_query_veic(null,"distinct z01_numcgm,z01_nome", "z01_nome","ve05_numcgm is not null"));
                    db_selectrecord("ve02_numcgm",$result_motora,true,$db_opcao,"","","", "0-Nenhum");
                    ?>
                </td>
            </tr>
            <tr class="tr__hidden tr__hidden-veiculos">
                <td nowrap title="<?=@$Tve01_veiccadtipo?>"><?=@$Lve01_veiccadtipo?></td>
                <td>
                    <?
                    /*if ($db_opcao == 1) {
                        $ve01_veiccadtipo = $ve50_veiccadtipo;
                    }*/
                    $result_tipo=$clveiccadtipo->sql_record($clveiccadtipo->sql_query(null, "*", "ve20_descr"));
                    db_selectrecord("ve01_veiccadtipo",$result_tipo,true,$db_opcao,"","","", "0-Nenhum");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tve01_veiccadmarca?>"><?=@$Lve01_veiccadmarca?></td>
                <td>
                    <?
                    $result_marca=$clveiccadmarca->sql_record($clveiccadmarca->sql_query(null, "*", "ve21_descr"));
                    db_selectrecord("ve01_veiccadmarca",$result_marca,true,$db_opcao,"","","", "0-Selecione");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tve01_veiccadmodelo?>">
                    <?
                    db_ancora(@$Lve01_veiccadmodelo,"js_pesquisave01_veiccadmodelo(true);",$db_opcao);
                    ?>
                </td>
                <td>
                    <?
                    db_input('ve01_veiccadmodelo',10,$Ive01_veiccadmodelo,true,'text',$db_opcao," onchange='js_pesquisave01_veiccadmodelo(false);'")
                    ?>
                    <?
                    db_input('ve22_descr',42,$Ive22_descr,true,'text',3,'')
                    ?>
                </td>
            </tr>
            <tr class="tr__hidden">
                <td nowrap title="<?=@$Tve01_veiccadcor?>"><?=@$Lve01_veiccadcor?></td>
                <td>
                    <?
                    $result_cor=$clveiccadcor->sql_record($clveiccadcor->sql_query(null, "*", "ve23_descr"));
                    db_selectrecord("ve01_veiccadcor",$result_cor,true,$db_opcao,"","","", "0-Selecione");
                    ?>
                </td>
            </tr>
            <tr class="tr__hidden tr__hidden-veiculos">
                <td nowrap title="<?=@$Tve01_veiccadproced?>"><?=@$Lve01_veiccadproced?></td>
                <td>
                    <?
                    $result_proced=$clveiccadproced->sql_record($clveiccadproced->sql_query());
                    db_selectrecord("ve01_veiccadproced",$result_proced,true,$db_opcao,"","","","0-Nenhum");
                    ?>
                </td>
            </tr>
            <tr class="tr__hidden tr__hidden-veiculos">
                <td nowrap title="<?=@$Tve01_veiccadcateg?>"><?=@$Lve01_veiccadcateg?></td>
                <td>
                    <?
                    $result_categ=$clveiccadcateg->sql_record($clveiccadcateg->sql_query());
                    db_selectrecord("ve01_veiccadcateg",$result_categ,true,$db_opcao,"","","","0-Nenhum");
                    ?>
                </td>
            </tr>
            <tr id="trchassi" class="tr__hidden" style="display: ;">
                <td nowrap title="<?=@$Tve01_chassi?>">
                    <?=@$Lve01_chassi?>
                </td>
                <td>
                    <?
                    db_input('ve01_chassi',24,$Ive01_chassi,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr id="trrenavam" class="tr__hidden" style="display: ;">
                <td nowrap title="<?=@$Tve01_ranavam?>">
                    <?=@$Lve01_ranavam?>
                </td>
                <td>
                    <?
                    db_input('ve01_ranavam',24,$Ive01_ranavam,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr class="tr__hidden tr__hidden-veiculos">
                <td nowrap title="<?=@$Tve01_placanum?>">
                    <?=@$Lve01_placanum?>
                </td>
                <td>
                    <?
                    db_input('ve01_placanum', 24,$Ive01_placanum,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>

            <tr id="trnumserie" class='tr__hidden' style="display: ;">
                <td nowrap title="<?=@$Tve01_nroserie?>">
                    <?=@$Lve01_nroserie?>
                </td>
                <td>
                    <?
                    db_input('ve01_nroserie',24,$Ive01_nroserie,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>

            <tr id="trnumcertificado" class='tr__hidden' style="display: ;">
                <td nowrap title="<?=@$Tve01_certif?>">
                    <?=@$Lve01_certif?>
                </td>
                <td>
                    <?
                    db_input('ve01_certif',24,$Ive01_certif,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr class="tr__hidden-veiculos">
                <td nowrap title="<?=@$Tve01_quantpotencia?>"><?=@$Lve01_quantpotencia?></td>
                <td>
                    <?
                    db_input('ve01_quantpotencia',10,$Ive01_quantpotencia,true,'text',$db_opcao,"");
                    $result_potencia=$clveiccadpotencia->sql_record($clveiccadpotencia->sql_query());
                    db_selectrecord("ve01_veiccadpotencia",$result_potencia,true,$db_opcao,"","","","0-Nenhum");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=$Tve01_veictipoabast?>"><?=$Lve01_veictipoabast?></td>
                <td>
                    <?
                    $result_veictipoabast = $clveictipoabast->sql_record($clveictipoabast->sql_query(null,"ve07_sequencial,ve07_descr"));
                    db_selectrecord("ve01_veictipoabast",$result_veictipoabast,true,$db_opcao,"","",""," 0-Selecione","js_mostramedida();");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tve01_medidaini?>">
                    <?=@$Lve01_medidaini?>
                </td>
                <td>
                    <?
                    db_input('ve01_medidaini',10,$Ive01_medidaini,true,'text',$db_opcao,"");
                    if (isset($ve07_sigla) && trim($ve07_sigla) != ""){
                        echo " ".db_input("ve07_sigla",3,0,true,"text",3);
                    }
                    ?>
                </td>
            </tr>
            <tr class="tr__hidden tr__hidden-veiculos">
                <td nowrap title="<?=@$Tve01_quantcapacidad?>"><?=@$Lve01_quantcapacidad?></td>
                <td>
                    <?
                    db_input('ve01_quantcapacidad',10,$Ive01_quantcapacidad,true,'text',$db_opcao,"");
                    $result_tipocapacidade=$clveiccadtipocapacidade->sql_record($clveiccadtipocapacidade->sql_query());
                    db_selectrecord("ve01_veiccadtipocapacidade",$result_tipocapacidade,true,$db_opcao,"","","","0-Nenhum");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="Data de Cadastro">
                    <strong>Data de Cadastro:</strong>
                </td>
                <td>
                    <?
                    db_inputdata('ve01_dtaquis',@$ve01_dtaquis_dia,@$ve01_dtaquis_mes,@$ve01_dtaquis_ano,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr class='tr__combustivel'>
                <td nowrap title="<?=@$Tve06_veiccadcomb?>">
                    <?
                    db_ancora(@$Lve06_veiccadcomb,"js_veiculoscomb($db_opcao);",$db_opcao);
                    ?>
                </td>
                <td><b>
                        <?
                        db_input("cod_comb",   10,"",true,"hidden",3);
                        db_input("comb_padrao",10,"",true,"hidden",3);

                        if ($db_opcao != 1 && isset($ve01_codigo)){
                            $res_veiculoscomb = $clveiculoscomb->sql_record($clveiculoscomb->sql_query_comb(null,"ve26_descr,ve06_padrao",null,"ve06_veiculos=$ve01_codigo"));

                            if ($clveiculoscomb->numrows > 0){
                                $virgula   = "";
                                $vet_comb  = array(array("descr","padrao"));
                                $cont_comb = 0;
                                for($x = 0; $x < $clveiculoscomb->numrows; $x++){
                                    db_fieldsmemory($res_veiculoscomb,$x);

                                    $vet_comb["descr"][$cont_comb] = $ve26_descr;

                                    if ($ve06_padrao == "t"){
                                        $padrao = 1;
                                    } else {
                                        $padrao = 0;
                                    }

                                    $vet_comb["padrao"][$cont_comb] = $padrao;
                                    $cont_comb++;
                                }

                                $valor = "";
                                for($x = 0; $x < $cont_comb; $x++){
                                    if ($vet_comb["padrao"][$x] == 1){
                                        $valor = $vet_comb["descr"][$x];
                                        break;
                                    }
                                }

                                $virgula = ", ";
                                for($x = 0; $x < $cont_comb; $x++){
                                    if ($vet_comb["padrao"][$x] == 0 && $vet_comb["descr"][$x] != ""){
                                        $valor .= $virgula.$vet_comb["descr"][$x];
                                    }

                                    $virgula = ", ";
                                }

                                ?>
                                <input title=" Combustível Campo:ve06_veiccadcomb " name="ve06_veiccadcomb" type="text" id="ve06_veiccadcomb" value="<?=$valor?>" size="60" readonly style="background-color:#DEB887;" autocomplete="off">
                                <?
                            } else {
                                $valor = "Nenhum combustível cadastrado.";
                                ?>
                                <input title=" Combustível Campo:ve06_veiccadcomb " name="ve06_veiccadcomb" type="text" id="ve06_veiccadcomb" value="<?=$valor?>" size="60" readonly style="background-color:#DEB887;" autocomplete="off">
                                <?
                            }
                        } else {
                            $valor = "Nenhum combustível cadastrado.";
                            ?>
                            <input title=" Combustível Campo:ve06_veiccadcomb " name="ve06_veiccadcomb" type="text" id="ve06_veiccadcomb" value="<?=$valor?>" size="60" readonly style="background-color:#DEB887;" autocomplete="off">
                            <?
                        }
                        ?>
                    </b></td>
            </tr>
            <tr class='tr__categoriacnh'>
                <td nowrap title="<?=@$Tve01_veiccadcategcnh?>"><?=@$Lve01_veiccadcategcnh?></td>
                <td>
                    <?
                    /*if ($db_opcao == 1) {
                        $ve01_veiccadcategcnh = $ve50_veiccadcategcnh;
                    }*/
                    $result_categcnh=$clveiccadcategcnh->sql_record($clveiccadcategcnh->sql_query());
                    db_selectrecord("ve01_veiccadcategcnh",$result_categcnh,true,$db_opcao,"","","","0-Selecione");
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="div__anos">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td nowrap title="<?=@$Tve01_anofab?>" style="width:133px;">
                                    <?=@$Lve01_anofab?>
                                </td>
                                <td style="width:83px;padding-left:3px;">
                                    <?
                                    db_input('ve01_anofab', 10,$Ive01_anofab,true,'text',$db_opcao,"")
                                    ?>
                                </td>

                                <td nowrap title="<?=@$Tve01_anomod?>" style="width:18%">
                                    <?=@$Lve01_anomod?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve01_anomod',10,$Ive01_anomod,true,'text',$db_opcao,"")
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tve01_ceplocalidades?>">
                    <?
                    db_ancora(@$Lve01_ceplocalidades,"js_pesquisave01_ceplocalidades(true);",$db_opcao);
                    ?>
                </td>
                <td>
                    <?
                    if (!isset($ve01_ceplocalidades)){
                        $result_munic=$cldb_config->sql_record($cldb_config->sql_query_file(db_getsession("DB_instit"),"munic"));
                        if ($cldb_config->numrows>0){
                            db_fieldsmemory($result_munic,0);
                            $result_localidade=$clceplocalidades->sql_record($clceplocalidades->sql_query_file(null,"cp05_codlocalidades as ve01_ceplocalidades,cp05_localidades",null,"cp05_localidades='$munic'"));
                            if ($clceplocalidades->numrows>0){
                                db_fieldsmemory($result_localidade,0);
                            }
                        }
                    }
                    db_input('ve01_ceplocalidades',10,$Ive01_ceplocalidades,true,'text',$db_opcao," onchange='js_pesquisave01_ceplocalidades(false);'")
                    ?>
                    <?
                    db_input('cp05_localidades',42,$Icp05_localidades,true,'text',3,'')
                    ?>
                </td>
            </tr>
            <!--
  <tr>
    <td nowrap title="<?=@$Tve01_ativo?>">
       <?=@$Lve01_ativo?>
    </td>
    <td>
<?
            $x = array('1'=>'Sim','0'=>'Não');
            db_select('ve01_ativo',$x,true,$db_opcao,"");
            ?>
    </td>
  </tr>
  -->
            <?
            if(isset($ve50_integrapatri)&&$ve50_integrapatri==1){
                ?>
                <tr>
                    <td nowrap title="<?=@$Tve03_bem?>">
                        <?
                        db_ancora(@$Lve03_bem,"js_pesquisave03_bem(true);",$db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('ve03_bem',10,$Ive03_bem,true,'text',$db_opcao," onchange='js_pesquisave03_bem(false);'")
                        ?>
                        <?
                        db_input('t52_descr', 42,$It52_descr,true,'text',3,'')
                        ?>
                    </td>
                </tr>
                <?
            }
            ?>
        </table>
    </center>
    <input type="hidden" name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>">
    <input onclick="js_submit()" type="button" id="db_opcao"  name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="button" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>

    tipoveiculo = "<?=$si04_tipoveiculo?>";

    if(tipoveiculo && tipoveiculo != '0'){
        js_verifica_select(tipoveiculo);
    }

    function js_submit() {
        if(document.form1.si04_situacao.value == 2 || document.form1.si04_situacao.value == 3){
            if(document.form1.si04_numcgm.value == null || document.form1.si04_numcgm.value == "" ){
                alert('CGM  obrigatório');
                document.form1.si04_numcgm.focus();
                return false;
            }
        }
        document.form1.submit();
    }
    function js_situacao(){
        if(document.getElementById("si04_situacao").value == 1){
            document.form1.z01_nomecgm.value = "";
            document.form1.si04_numcgm.value = "";
            document.getElementById("titulonumcgm").style.display = "none";
            document.getElementById("si04_numcgm").style.background = "#C0C0C0";
            document.getElementsByClassName('tr__numcgm')[0].style.display = 'none';
        }else{
            document.getElementById("titulonumcgm").style.display = "table-row";
            document.getElementById("si04_numcgm").style.background = "#FFFFFF";
            document.getElementsByClassName('tr__numcgm')[0].style.display = '';
        }
    }

    function js_pesquisapc60_numcgm(mostra){
        if(mostra==true){
            if(document.form1.si04_situacao.value == 2 || document.form1.si04_situacao.value == 3){
                js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0');
            }else{
                alert('CGM deve ser selecionado quando a situação for \n Terceirizado/contratado ou \n Compõe o patrimônio do municipio (veiculo próprio)');
                return false;
            }
        }else{
            if(document.form1.si04_numcgm.value != ''){
                if(document.form1.si04_situacao.value == 2 || document.form1.si04_situacao.value == 3){
                    js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?pesquisa_chave='+document.form1.si04_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1','775','390');
                }else{
                    alert('CGM deve ser selecionado quando a situação for \n Terceirizado/contratado ou \n Compõe o patrimônio do municipio (veiculo próprio)');
                    document.form1.si04_numcgm.value = "";
                    return false;
                }
            }else{
                document.form1.z01_nomecgm.value = '';
            }
        }
    }
    function js_mostracgm(erro,chave,cpf,incest){
        document.form1.z01_nomecgm.value = chave;

        if(erro==true){
            document.form1.si04_numcgm.focus();
            document.form1.si04_numcgm.value = '';
        }
    }
    function js_mostracgm1(chave1,chave2){
        document.form1.si04_numcgm.value = chave1;
        document.form1.z01_nomecgm.value = chave2;

        db_iframe_nomes.hide();
    }
    function js_verifica_select(valor){
        let combo = '';
        if(valor == '0'){
            combo = document.getElementById('si04_especificacao');
            removeAllOptions(combo);
            combo.options[0] = new Option ("Selecione", "0");
        }
        if(valor == '1'){
            combo = document.getElementById('si04_especificacao');
            removeAllOptions(combo);
            combo.options[0] = new Option ("Aeronaves", "1");
        }
        if(valor == '2'){
            combo = document.getElementById('si04_especificacao');
            removeAllOptions(combo);
            combo.options[0] = new Option ("Embarcações", "2");
        }
        if(valor == '3'){
            combo = document.getElementById('si04_especificacao');
            removeAllOptions(combo);
            combo.options[0] = new Option ("Selecione", "0");
            combo.options[1] = new Option ("Veículo de passeio", "3");
            combo.options[2] = new Option ("Utilitário (Camionete)", "4");
            combo.options[3] = new Option ("Ônibus", "5");
            combo.options[4] = new Option ("Caminho", "6");
            combo.options[5] = new Option ("Motocicleta", "7");
            combo.options[6] = new Option ("Van", "8");
        }
        if(valor == '4'){
            combo = document.getElementById('si04_especificacao');
            removeAllOptions(combo);
            combo.options[0] = new Option ("Selecione", "0");
            combo.options[1] = new Option ("Trator de Esteira", "9");
            combo.options[2] = new Option ("Trator de Pneu", "10");
            combo.options[3] = new Option ("Moto niveladora", "11");
            combo.options[4] = new Option ("Pá-Carregadeira", "12");
            combo.options[5] = new Option ("Retro Escavadeira", "13");
            combo.options[6] = new Option ("Mini Carregadeira", "14");
            combo.options[7] = new Option ("Escavadeira", "15");
            combo.options[8] = new Option ("Empilhadeira", "16");
            combo.options[9] = new Option ("Compactador", "17");
        }
        if(valor == '5'){
            combo = document.getElementById('si04_especificacao');
            removeAllOptions(combo);
            combo.options[0] = new Option ("Selecione", "0");
            combo.options[1] = new Option ("Gerador", "18");
            combo.options[2] = new Option ("Moto bomba", "19");
            combo.options[3] = new Option ("Roadeira", "20");
            combo.options[4] = new Option ("Motoserra", "21");
            combo.options[5] = new Option ("Pulverizador", "22");
            combo.options[6] = new Option ("Compactador de Mo", "23");
            combo.options[7] = new Option ("Oficina", "24");
            combo.options[8] = new Option ("Motor de Popa", "25");
        }
        if(valor == '99'){
            combo = document.getElementById('si04_especificacao');
            removeAllOptions(combo);
            combo.options[0] = new Option ("Outros", "99");
        }

        js_hideElements(valor);
        js_tipodeveiculo(valor);

    }

    function js_hideElements(valor){
        let aClasses = document.getElementsByClassName('tr__hidden');

        if([1, 2, 4, 5, 99].includes(Number(valor))){
            document.getElementsByClassName('tr__numcgm')[0].style.display = 'none';
        }else{
            document.getElementsByClassName('tr__numcgm')[0].style.display = '';
        }

        for (let count=0; count < aClasses.length; count++){
            if([1, 2, 4, 5, 99].includes(Number(valor))){
                aClasses[count].style.display = 'none';
            }else{
                aClasses[count].style.display = '';
            }
        }
    }

    function removeAllOptions(selectbox)
    {
        var i;
        for(i=selectbox.options.length-1;i>=0;i--)
        {
            selectbox.remove(i);
        }
    }

    function js_veiculoscomb(opcao){
        <?
        $query = "db_opcao=".$db_opcao;
        if ($db_opcao!=1 && isset($ve01_codigo)){
            $query .= "&ve06_veiculos=".$ve01_codigo;
        }
        ?>
        js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiculoscomb','vei2_veiculoscomb001.php?<?=$query?>','Combustíveis',true);
    }
    function js_pesquisave01_veiccadmodelo(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiccadmodelo','func_veiccadmodelo.php?funcao_js=parent.js_mostraveiccadmodelo1|ve22_codigo|ve22_descr','Pesquisa',true);
        }else{
            if(document.form1.ve01_veiccadmodelo.value != ''){
                js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiccadmodelo','func_veiccadmodelo.php?pesquisa_chave='+document.form1.ve01_veiccadmodelo.value+'&funcao_js=parent.js_mostraveiccadmodelo','Pesquisa',false);
            }else{
                document.form1.ve22_descr.value = '';
            }
        }
    }
    function js_mostraveiccadmodelo(chave,erro){
        document.form1.ve22_descr.value = chave;
        if(erro==true){
            document.form1.ve01_veiccadmodelo.focus();
            document.form1.ve01_veiccadmodelo.value = '';
        }
    }
    function js_mostraveiccadmodelo1(chave1,chave2){
        document.form1.ve01_veiccadmodelo.value = chave1;
        document.form1.ve22_descr.value = chave2;
        db_iframe_veiccadmodelo.hide();
    }
    function js_pesquisave06_veiccadcomb(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiccadcomb','func_veiccadcomb.php?funcao_js=parent.js_mostraveiccadcomb1|ve26_codigo|ve26_descr','Pesquisa',true);
        }else{
            if(document.form1.ve06_veiccadcomb.value != ''){
                js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiccadcomb','func_veiccadcomb.php?pesquisa_chave='+document.form1.ve06_veiccadcomb.value+'&funcao_js=parent.js_mostraveiccadcomb','Pesquisa',false);
            }else{
                document.form1.ve26_descr.value = '';
            }
        }
    }
    function js_mostraveiccadcomb(chave,erro){
        document.form1.ve26_descr.value = chave;
        if(erro==true){
            document.form1.ve06_veiccadcomb.focus();
            document.form1.ve06_veiccadcomb.value = '';
        }
    }
    function js_mostraveiccadcomb1(chave1,chave2){
        document.form1.ve06_veiccadcomb.value = chave1;
        document.form1.ve26_descr.value = chave2;
        db_iframe_veiccadcomb.hide();
    }
    function js_pesquisave01_ceplocalidades(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_ceplocalidades','func_ceplocalidades.php?funcao_js=parent.js_mostraceplocalidades1|cp05_codlocalidades|cp05_localidades','Pesquisa',true);
        }else{
            if(document.form1.ve01_ceplocalidades.value != ''){
                js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_ceplocalidades','func_ceplocalidades.php?pesquisa_chave='+document.form1.ve01_ceplocalidades.value+'&funcao_js=parent.js_mostraceplocalidades','Pesquisa',false);
            }else{
                document.form1.cp05_localidades.value = '';
            }
        }
    }
    function js_mostraceplocalidades(chave,erro){
        document.form1.cp05_localidades.value = chave;
        if(erro==true){
            document.form1.ve01_ceplocalidades.focus();
            document.form1.ve01_ceplocalidades.value = '';
        }
    }
    function js_mostraceplocalidades1(chave1,chave2){
        document.form1.ve01_ceplocalidades.value = chave1;
        document.form1.cp05_localidades.value = chave2;
        db_iframe_ceplocalidades.hide();
    }
    function js_pesquisave40_veiccadcentral(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiccadcentral','func_veiccadcentral.php?funcao_js=parent.js_mostraveiccadcentral1|ve36_sequencial|descrdepto','Pesquisa',true);
        }else{
            if(document.form1.ve40_veiccadcentral.value != ''){
                js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiccadcentral','func_veiccadcentral.php?pesquisa_chave='+document.form1.ve40_veiccadcentral.value+'&funcao_js=parent.js_mostraveiccadcentral','Pesquisa',false);
            }else{
                document.form1.descrdepto.value = '';
            }
        }
    }
    function js_mostraveiccadcentral(chave1,erro,chave2){
        document.form1.descrdepto.value = chave2;
        if(erro==true){
            document.form1.ve40_veiccadcentral.focus();
            document.form1.ve40_veiccadcentral.value = '';
        }
    }
    function js_mostraveiccadcentral1(chave1,chave2){
        document.form1.ve40_veiccadcentral.value = chave1;
        document.form1.descrdepto.value          = chave2;
        db_iframe_veiccadcentral.hide();
    }
    function js_pesquisave03_bem(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_bens','func_bens.php?funcao_js=parent.js_mostrabens1|t52_bem|t52_descr','Pesquisa',true);
        }else{
            if(document.form1.ve03_bem.value != ''){
                js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_bens','func_bens.php?pesquisa_chave='+document.form1.ve03_bem.value+'&funcao_js=parent.js_mostrabens','Pesquisa',false);
            }else{
                document.form1.t52_descr.value = '';
            }
        }
    }
    function js_mostrabens(chave,erro){
        document.form1.t52_descr.value = chave;
        if(erro==true){
            document.form1.ve03_bem.focus();
            document.form1.ve03_bem.value = '';
        }
    }
    function js_mostrabens1(chave1,chave2){
        document.form1.ve03_bem.value = chave1;
        document.form1.t52_descr.value = chave2;
        db_iframe_bens.hide();
    }
    function js_pesquisa(){
        js_OpenJanelaIframe('top.corpo.iframe_veiculos','db_iframe_veiculos','func_veiculos.php?funcao_js=parent.js_preenchepesquisa|ve01_codigo&instit=true','Pesquisa',true,'0');
    }
    function js_preenchepesquisa(chave){
        db_iframe_veiculos.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }

    function js_tipodeveiculo(value){
        if (value == 3) {
            document.getElementById("trchassi").style.display = "";
            document.getElementById("trrenavam").style.display = "";
            document.getElementById("trnumserie").style.display = "";
            document.getElementById("trnumcertificado").style.display = "";
        } else {
            document.getElementById("trchassi").style.display  = "none";
            document.getElementById("trrenavam").style.display = "none";
            document.getElementById("trnumserie").style.display = "none";
            document.getElementById("trnumcertificado").style.display = "none";
        }

        if(value == 5){
            document.getElementsByClassName('tr__combustivel')[0].style.display = 'none';
            document.getElementsByClassName('tr__categoriacnh')[0].style.display = 'none';
        }else{
            document.getElementsByClassName('tr__combustivel')[0].style.display = '';
            document.getElementsByClassName('tr__categoriacnh')[0].style.display = '';
        }
    }

    function js_mostramedida(){
        var sel1  = document.form1.elements["ve01_veictipoabast"];
        var valor = sel1.options[sel1.selectedIndex].value;

        obj = document.createElement('input');
        obj.setAttribute('name','codveictipoabast');
        obj.setAttribute('type','hidden');
        obj.setAttribute('value',valor);
        document.form1.appendChild(obj);

    }
    js_situacao();


    // document.getElementById('si04_especificacao').addEventListener('change', (event) => {
    //     let aTrs = document.getElementsByClassName('tr__hidden-veiculos');
    //
    //     for (let count = 0; count < aTrs.length; count++){
    //         if(['3', '4', '5', '6', '7', '8'].includes(event.target.value)){
    //             aTrs[count].style.display = 'none';
    //         }else{
    //             aTrs[count].style.display = '';
    //         }
    //     }
    // })

</script>
<?
if ($db_opcao == 1) {
    echo "<script>js_pesquisa_depart(false)</script>";
}
if ($db_opcao==2 || $db_opcao==22) {
    echo
    "<script>
		js_verifica_select($si04_tipoveiculo);
		let combo = document.getElementById('si04_especificacao');
		for (var i=0; i < combo.options.length ; i++){
		  if(combo.options[i].value == $si04_especificacao){
			combo.options[i].setAttribute('selected', 'selected');
		  }
		}
		</script>";
}elseif( $db_opcao == 3 ){
    echo "<script>
	var input = document.getElementById('si04_especificacao_select_descr');

	if ($si04_especificacao == 1) {
		input.value = 'Aeronaves';
	}
	if ($si04_especificacao == 2) {
		input.value = 'Embarcaes';
	}
	if ($si04_especificacao == 3) {
		input.value = 'Veiculo de passeio';
	}
	if ($si04_especificacao == 4) {
		input.value = 'Utilitrio (Camionete)';
	}
	if ($si04_especificacao == 5) {
		input.value = 'nibus';
	}
	if ($si04_especificacao == 6) {
		input.value = 'Caminho';
	}
	if ($si04_especificacao == 7) {
		input.value = 'Motocicleta';
	}
	if ($si04_especificacao == 8) {
		input.value = 'Van';
	}
	if ($si04_especificacao == 9) {
		input.value = 'Trator de Esteira';
	}
	if ($si04_especificacao == 10) {
		input.value = 'Trator de Pneu';
	}
	if ($si04_especificacao == 11) {
		input.value = 'Moto niveladora';
	}
	if ($si04_especificacao == 12) {
		input.value = 'P-Carregadeira';
	}
	if ($si04_especificacao == 13) {
		input.value = 'Retro Escavadeira';
	}
	if ($si04_especificacao == 14) {
		input.value = 'Mini Carregadeira';
	}
	if ($si04_especificacao == 15) {
		input.value = 'Escavadeira';
	}
	if ($si04_especificacao == 16) {
		input.value = 'Empilhadeira';
	}

	if ($si04_especificacao == 17) {
		input.value = 'Compactador';
	}
	if ($si04_especificacao == 18) {
		input.value = 'Gerador';
	}
	if ($si04_especificacao == 19) {
		input.value = 'Moto bomba';
	}
	if ($si04_especificacao == 20) {
		input.value = 'Roadeira';
	}
	if ($si04_especificacao == 21) {
		input.value = 'Motoserra';
	}
	if ($si04_especificacao == 22) {
		input.value = 'Pulverizador';
	}
	if ($si04_especificacao == 23) {
		input.value = 'Compactador de Mo';
	}
	if ($si04_especificacao == 24) {
		input.value = 'Oficina';
	}
	if ($si04_especificacao == 25) {
		input.value = 'Motor de Popa';
	}
	</script>";
}
?>
