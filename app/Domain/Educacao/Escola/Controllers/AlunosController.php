<?php

namespace App\Domain\Educacao\Escola\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlunosController extends Controller
{
    public function getHistoricosAlunosByEscola(Request $request)
    {
        $escola = $request->get('escola');
        $ano = $request->get('ano');
        $curso = $request->get('curso');
        $whereCurso = is_null($curso) ? "1 = 1" :"ed61_i_curso = {$curso}";
        $sqlEsola = $request->get('tipoVinculo') == 1
            ? "(historicomps.ed62_i_escola = {$escola} or alunocurso.ed56_i_escola = {$escola})"
            : "ed56_i_escola is null";

        $sqlAno = is_null($ano) ? "1 = 1" :
            "(SELECT  ed62_i_anoref AS ano
                FROM historico
            LEFT JOIN historicomps
                ON historicomps.ed62_i_historico = historico.ed61_i_codigo
            LEFT JOIN historicompsfora
                ON historicompsfora.ed99_i_historico = ed61_i_codigo
            WHERE ed61_i_aluno = ed47_i_codigo
            AND ed62_i_anoref IS NOT NULL
                UNION
            SELECT  ed99_i_anoref AS anoHis
                FROM historico
            LEFT JOIN historicomps
                ON historicomps.ed62_i_historico = historico.ed61_i_codigo
            LEFT JOIN historicompsfora
                ON historicompsfora.ed99_i_historico = ed61_i_codigo
            WHERE ed61_i_aluno = ed47_i_codigo
            AND ed99_i_anoref IS NOT NULL
            ORDER BY 1 DESC
            LIMIT 1) = {$ano}";

            $alunosHistoricos = DB::table('historico')
                ->selectRaw('distinct ed47_i_codigo, trim(aluno.ed47_v_nome) AS ed47_v_nome, ed56_i_escola')
                ->join('aluno', 'aluno.ed47_i_codigo', '=', 'historico.ed61_i_aluno')
                ->leftJoin('alunocurso', 'alunocurso.ed56_i_aluno', '=', 'aluno.ed47_i_codigo')
                ->leftJoin('calendario', 'calendario.ed52_i_codigo', '=', 'alunocurso.ed56_i_calendario')
                ->leftJoin('historicomps', 'historicomps.ed62_i_historico', '=', 'historico.ed61_i_codigo')
                ->leftJoin('historicompsfora', 'historicompsfora.ed99_i_historico', '=', 'historico.ed61_i_codigo')
                ->whereRaw($sqlEsola)
                ->whereRaw($sqlAno)
                ->whereRaw($whereCurso)
                ->orderBy('ed47_v_nome')->get();

        return new DBJsonResponse($alunosHistoricos);
    }

    public function getHistoricosAlunosTransferidosFora(Request $request)
    {
        $escola = $request->get('escola');
        $ano = $request->get('ano');
        $curso = $request->get('curso');
        $whereAno = is_null($ano) ? "1 = 1" : "ed52_i_ano = {$ano}";
        $whereCurso = is_null($curso) ? "1 = 1" :
            "exists(select 1
                from base
            where base.ed31_i_codigo = turma.ed57_i_base
                and base.ed31_i_curso = {$curso})";


        $alunosHistoricos = DB::table('transfescolarede')
            ->selectRaw('distinct ed47_i_codigo, trim(aluno.ed47_v_nome) AS ed47_v_nome, escola.ed18_i_codigo')
            ->join('escola', 'escola.ed18_i_codigo', '=', 'transfescolarede.ed103_i_escolaorigem')
            ->join('matricula', 'matricula.ed60_i_codigo', '=', 'transfescolarede.ed103_i_matricula')
            ->join('turma', 'turma.ed57_i_codigo', '=', 'matricula.ed60_i_turma')
            ->join('matriculaserie', 'matriculaserie.ed221_i_matricula', '=', 'matricula.ed60_i_codigo')
            ->join('atestvaga', 'atestvaga.ed102_i_codigo', '=', 'transfescolarede.ed103_i_atestvaga')
            ->join('aluno', 'aluno.ed47_i_codigo', '=', 'matricula.ed60_i_aluno')
            ->join('historico', 'historico.ed61_i_aluno', '=', 'aluno.ed47_i_codigo')
            ->join('calendario', 'calendario.ed52_i_codigo', '=', 'atestvaga.ed102_i_calendario')
            ->join('base', 'base.ed31_i_codigo', '=', 'atestvaga.ed102_i_base')
            ->whereRaw("matricula.ed60_c_situacao = 'TRANSFERIDO REDE'")
            ->whereRaw("transfescolarede.ed103_i_escolaorigem = {$escola}")
            ->whereRaw($whereAno)
            ->whereRaw($whereCurso)
            ->orderBy('ed47_v_nome')->get();
        return new DBJsonResponse($alunosHistoricos);
    }
}
