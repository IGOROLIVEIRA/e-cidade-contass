<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

  require("libs/db_stdlib.php");
  require("libs/db_conecta.php");
  include("libs/db_sessoes.php");
  include("libs/db_usuariosonline.php");
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <center>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center">
            <?
              $funcao_js = "parent.mostraDadosInscricao|0";
              $sql = " select DISTINCT issbase.q02_inscr,
	                       CASE
	                         WHEN trim(cgm.z01_nomefanta) = '' THEN 'Sem nome fantasia cadastrado'
	                         ELSE cgm.z01_nomefanta
	                          END as z01_nomefanta,
		                                    z01_nome  ,z01_cgccpf, db98_descricao as dl_Tipo_Empresa,j14_nome, q02_numero     , q02_compl ,
		                                    q02_cxpost, j13_descr, issruas.z01_cep, q02_dtinic,
		                                    q02_dtbaix, q140_datainicio as dl_Data_da_Paralizacao, q140_datafim as dl_Data_Fim_Paralizacao
		                     from issbase
                    INNER JOIN cgm ON issbase.q02_numcgm = z01_numcgm
                    LEFT JOIN cgmtipoempresa ON z03_numcgm = z01_numcgm
                    LEFT JOIN tipoempresa ON z03_tipoempresa = db98_sequencial
                    LEFT JOIN issbaseparalisacao ON q02_inscr = q140_issbase
                    LEFT JOIN issruas ON issruas.q02_inscr = issbase.q02_inscr
                    LEFT JOIN ruas ON ruas.j14_codigo = issruas.j14_codigo
                    LEFT JOIN issbairro ON issbairro.q13_inscr = issbase.q02_inscr
                    LEFT JOIN bairro ON bairro.j13_codi = issbairro.q13_bairro ";

              if (isset($pesquisaPorNome)) {
              	// a variavel $pesquisaPorNome retorna com o numro do cgm do registro selecionado
                $sql .= " where issbase.q02_numcgm = $pesquisaPorNome ";
                db_lovrot($sql,15,"()",$pesquisaPorNome,$funcao_js);

              } else if (isset($pesquisaEscritorio)) {
                $sql .= "  inner join escrito on q10_inscr = issbase.q02_inscr where q10_numcgm = $pesquisaEscritorio	";
                db_lovrot($sql,15,"()",$pesquisaEscritorio,$funcao_js);

              }else if (isset($pesquisaRua)) {
                $numero = "";
                if (isset($pesqnum) && $pesqnum != "") {
                  $numero = " and q02_numero = $pesqnum";
                }

                $sql .= " where issruas.j14_codigo = $pesquisaRua $numero	order by q02_numero, q02_compl ";
	 	            echo "
							 	<form name='form1' method='post' action=''>
							 	  Número:
							 	  <input type='text' name='pesqnum' size='4' value='".@$pesqnum."'>
							 	  <input type='hidden' name='pesquisaRua' value='".@$pesquisaRua."'>
							 	  <input type='submit' name='pesquisar' value='Pesquisar'>
							 	</form> 			";
						    db_lovrot($sql,15,"()",$pesquisaRua,$funcao_js);

              } else if (isset($pesquisaAtividade)) {
                $sql .= " inner join tabativ on q07_inscr = issbase.q02_inscr where q07_ativ = $pesquisaAtividade	";
                db_lovrot($sql, 15, "()", $pesquisaAtividade, $funcao_js);

              } else if (isset($pesquisaSocios)) {
                $sql .= " inner join socios on q95_cgmpri = q02_numcgm where q95_tipo = 1 and q95_numcgm = $pesquisaSocios ";
                db_lovrot($sql, 15, "()", $pesquisaSocios, $funcao_js);

              } else if (isset($pesquisaBairro)) {
                $sql .= " inner join issbairro on q13_inscr = issbase.q02_inscr where q13_bairro = $pesquisaBairro";
                db_lovrot($sql, 15, "()", $pesquisaBairro, $funcao_js);

              } else if (isset($pesquisaMatriculaImovel)) {
                $sql .= " inner join issmatric on q05_inscr = issbase.q02_inscr where q05_matric = $pesquisaMatriculaImovel";
                db_lovrot($sql, 15, "()", $pesquisaMatriculaImovel, $funcao_js);

              } else if (isset($pesquisaCgcCpf)) {
                $sql .= " where cgm.z01_cgccpf = '$pesquisaCgcCpf' ";
                db_lovrot($sql,15,"()",$pesquisaCgcCpf,$funcao_js);
              }

            ?>
          </td>
        </tr>
      </table>
    </center>
  </body>
</html>
