<div style="width: 70%; margin-left: 15%;">
    <form name="form1" method="post">
        <input type="hidden" name="empenho" value="<?= $empenho ?>">
        <table border="0">
            <tr>
                <td nowrap title="<?=@$Te60_codemp?>">
                    <?=@$Le60_codemp?>
                </td>
                <td>
                    <?
                    db_input('e60_codemp',10,$empenho,true,'text',3);
                    db_input('e60_numemp',10,'',true,'hidden',3);
                    ?>
                </td>

                <td nowrap title="<?=@$Te50_codord?>">
                    <?=@$Le50_codord?>
                </td>
                <td>
                    <?
                    db_input('e60_numemp',10,'',true,'hidden',3);
                    db_input('e50_codord',10,$empenho,true,'text',3);
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top">
                    <?

                    $whereage = "";
                    $dbwhere  =" e60_instit = ".db_getsession("DB_instit")." and e60_codemp = '".$empenho."'";
                    $campos   = "pagordem.e50_codord,
                                   e60_numemp,
                                   e60_codemp,
                                   pagordem.e50_data,
                                   pagordem.e50_obs,
                                   e53_valor,
                                   e53_vlranu,
                                   e53_vlrpag,
                                   cgm.z01_cgccpf";

                    if (isset($campos)==false) {

                        if (file_exists("funcoes/db_func_pagordem.php")==true) {
                            include("funcoes/db_func_pagordem.php");
                        } else {
                            $campos = "pagordem.*,cgm.z01_cgccpf";
                        }

                    }

                    if (isset($filtroquery)) {
//                        die('0');
//                        if (strlen($whereage) > 0){
//                            die('1');
                            $sql = $clpagordem->sql_query_pagordemagenda("",$campos,"e50_codord","$dbwhere and $whereage");
//                        }
                    } else {
//                        die('2');
                        $sql = $clpagordem->sql_query_pagordemele("",$campos,"e50_codord","$dbwhere");
                    }
//                    die('asdf');
//                    echo $sql;
                    if (isset($sql)) {
                        db_lovrot($sql,8,"()","",$funcao_js);
                    }
                    ?>
                </td>
            </tr>
        </table>
    </form>
</div>