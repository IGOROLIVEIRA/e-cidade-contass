<?
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

include("fpdf151/pdf.php");
include("libs/db_sql.php");
require_once("classes/db_liclicita_classe.php");

function buscarFornecedoresGanhadores(int $codigoLicitacao): array
{
    $fornecedores = [];
    $sqlFornecedores = (new  cl_liclicita)->queryFornecedoresGanhadores($codigoLicitacao);

    $result = db_query($sqlFornecedores);
    $countResult  = pg_num_rows(db_query($sqlFornecedores));
    for($i = 0; $i < $countResult; $i++) {
       $fornecedor = db_utils::fieldsmemory($result, $i);
        $fornecedores[] =[
            'cgm' => $fornecedor->z01_numcgm,
            'nome' => $fornecedor->z01_nome,
            'documento' => $fornecedor->z01_cgccpf
        ];
    }

    return $fornecedores;
}

function insereFornecedores(PDF $pdf, int $alt, int $l20_codigo): void
{
    $fornecedores = buscarFornecedoresGanhadores($l20_codigo);

    if (empty($fornecedores)) {
        $pdf->setfont('arial', '', 6);
        $pdf->cell(42, $alt, "", 1, 0, "C", 0);
        $pdf->cell(42, $alt, "", 1, 0, "C", 0);
        $pdf->multicell(195, $alt, "", 1, "J");
    } else {
        foreach ($fornecedores as $fornecedor) {
            $pdf->setfont('arial', '', 6);
            $pdf->cell(42, $alt, $fornecedor['cgm'], 1, 0, "C", 0);
            $pdf->cell(42, $alt, $fornecedor['documento'], 1, 0, "C", 0);
            $pdf->multicell(195, $alt, $fornecedor['nome'], 1, "J");
        }
    }
}


/*
 * query que busca os dados para retorno do relatório
 */
$sql = "SELECT DISTINCT l20_numero || '/' || l20_anousu AS licitacao,
                        pc10_numero AS compilacao,
                        pc10_resumo AS objeto,
                        coddepto || '-' || descrdepto AS departamento,
                        to_char(pc54_datainicio,'dd / mm / yyyy') AS inicio,
                        to_char(pc54_datatermino,'dd / mm / yyyy') AS fim,
                        pc54_datatermino,
                        pc54_datainicio,
                        l20_edital || '/' || l20_anousu AS processoLicitatorio,
                        l20_codigo
        FROM liclicitem
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
            AND pc10_solicitacaotipo = 6
        INNER JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
        INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        INNER JOIN db_usuarios ON db_usuarios.id_usuario = liclicita.l20_id_usucria
        INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
        INNER JOIN liclocal ON liclocal.l26_codigo = liclicita.l20_liclocal
        INNER JOIN liccomissao ON liccomissao.l30_codigo = liclicita.l20_liccomissao
        LEFT JOIN solicitatipo ON solicitatipo.pc12_numero = solicitem.pc11_numero
        LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = solicitatipo.pc12_tipo
        WHERE l20_licsituacao = 10 ";

if (!empty($anousu)) {
   $sql .= " AND date_part ('year',pc54_datatermino) = $anousu ";
}

if (!empty($periodoInicio)) {
    $periodoInicio =  DateTimeImmutable::createFromFormat('d/m/Y', $periodoInicio);
    $sql .= "AND pc54_datainicio >= '{$periodoInicio->format('Y-m-d')}'::date ";
}

if (!empty($periodoFim)) {
    $periodoFim =  DateTimeImmutable::createFromFormat('d/m/Y', $periodoFim);
    $sql .= " AND pc54_datatermino <= '{$periodoFim->format('Y-m-d')}'::date ";
}

$sql .= " AND l20_instit = ". db_getsession('DB_instit') .
" ORDER BY pc54_datainicio";

$resultVigencia = db_query($sql);

if (pg_num_rows(db_query($sql)) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum Registro Encontrado!');
}

/*
 * busca dados da instituição atual
 */
$sqlInst = "SELECT codigo inst,
                   nomeinst nome
            FROM db_config
            WHERE codigo = " .db_getsession('DB_instit');

$resultInst = db_query($sqlInst);

db_fieldsmemory($resultInst,0);

/*
 * construção do relatório
 */
$head1 = "Vigência Registro Preço";
$head3 = $inst ." - ". $nome;

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$alt = 4;
$total = 0;
$pdf->setfillcolor(235);
$pdf->addpage("L");
$pdf->setfont('arial', 'b', 8);

for($i = 0; $i < pg_num_rows($resultVigencia); $i++){

    db_fieldsmemory($resultVigencia,$i);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(42, $alt, "Compilação", 1, 0, "C",1);
    $pdf->cell(42, $alt, "Modalidade", 1, 0, "C",1);
    $pdf->cell(42, $alt, "Processo Licitatório", 1, 0, "C",1);
    $pdf->cell(77, $alt, "Departamento", 1, 0, "C",1);
    $pdf->cell(38, $alt, "Inicio", 1, 0, "C",1);
    $pdf->cell(38, $alt, "Fim", 1, 1, "C",1);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(42, $alt, $compilacao, 1, 0, "C",0);
    $pdf->cell(42, $alt, $licitacao, 1, 0, "C",0);
    $pdf->cell(42, $alt, $processolicitatorio, 1, 0, "C",0);
    $pdf->cell(77, $alt, $departamento, 1, 0, "L",0);
    $pdf->cell(38, $alt, $inicio, 1, 0, "C",0);
    $pdf->cell(38, $alt, $fim, 1, 1, "C",0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(279, $alt, "Objeto", 1, 1, "C",1);
    $pdf->setfont('arial', '', 6);
    $pdf->multicell(279, $alt, $objeto, 1, "J");

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(42, $alt, "Cgm", 1, 0, "C", 1);
    $pdf->cell(42, $alt, "CNPJ/CPF", 1, 0, "C", 1);
    $pdf->cell(119, $alt, "Fornecedor", 1, 0, "C", 1);
    $pdf->cell(38, $alt, "", 1, 0, "C",1);
    $pdf->cell(38, $alt, "", 1, 1, "C",1);

    insereFornecedores($pdf, $alt, (int)$l20_codigo);

    $pdf->cell(279, $alt, "", 0, 1, "C");
}

$pdf->Output();
