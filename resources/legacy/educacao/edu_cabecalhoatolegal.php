<?php


$oDepartamento = new DBDepartamento(db_getsession("DB_coddepto"));
$iDepartamento = $oDepartamento->getCodigo();


$result = db_query("select ed05_t_texto,ed05_d_publicado,ed05_i_aparecerelatorio,ed05_i_ano,ed05_i_codigo, ed05_c_numero, ed05_c_finalidade, ed83_c_descr as dl_tipo,
case when ed05_c_competencia='F' then 'FEDERAL' when ed05_c_competencia='E' then 'ESTADUAL' else 'MUNICIPAL'
end as ed05_c_competencia, ed05_i_ano from atolegal inner join tipoato on tipoato.ed83_i_codigo
= atolegal.ed05_i_tipoato inner join atoescola on atoescola.ed19_i_ato = atolegal.ed05_i_codigo
where ed19_i_escola = $iDepartamento and ed05_i_aparecerelatorio = true order by ed05_i_codigo ;");

$atolegal = db_utils::fieldsMemory($result, 0);

if ($atolegal->ed05_c_finalidade == "") {
    $atolegalcabecalho = "";
} else {
    $atolegalcabecalho = $atolegal->ed05_c_finalidade . "/" . $atolegal->dl_tipo . " nº: " .  $atolegal->ed05_c_numero . " DE " . implode("/", array_reverse(explode("-", $atolegal->ed05_d_publicado))) . ", " . $atolegal->ed05_t_texto;
}
