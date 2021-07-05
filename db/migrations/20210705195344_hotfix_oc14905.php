<?php

use Phinx\Migration\AbstractMigration;

class HotfixOc14905 extends AbstractMigration
{
  public function up()
  {

    $sSql = <<<SQL

    BEGIN;

    delete from public.relatorios;

    INSERT INTO public.relatorios (rel_sequencial, rel_descricao, rel_arquivo, rel_corpo) VALUES(2, 'AUTUAÇÃO', 1260, '<p>&nbsp;</p>
<p dir="ltr" style="line-height: 1.3800000000000001; text-align: center; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 18pt;"><strong><span style="font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">AUTUA&Ccedil;&Atilde;O</span></strong></span></p>
<p dir="ltr" style="line-height: 1.3800000000000001; text-align: center; margin-top: 0pt; margin-bottom: 10pt;">&nbsp;</p>
<p dir="ltr" style="line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"> Tendo em vista a autoriza&ccedil;&atilde;o da autoridade competente para realiza&ccedil;&atilde;o de Licita&ccedil;&atilde;o para </span><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$l20_objeto#, o setor de licita&ccedil;&atilde;o da </span><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$sInstit#, declara que foi autuada a presente licita&ccedil;&atilde;o conforme a seguir:</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>PROCESSO</strong>: </span>#$l20_numero#</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>N&ordm; MODALIDADE</strong>:</span>#$l20_edital#</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>MODALIDADE</strong>: </span></span><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;">#$l03_descr#</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>DATA DE AUTUA&Ccedil;&Atilde;O</strong>: </span>#$datasistema#</span></p>
<p dir="ltr" style="line-height: 1.8; margin-top: 0pt; margin-bottom: 10pt; text-align: right;"><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$sMunicipio#, </span><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$dSistema#.</span></p>
<p>&nbsp;</p>
<p dir="ltr" style="line-height: 1.7999999999999998; margin-left: 36pt; text-align: center; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 12pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">______________________________</span></p>
<p dir="ltr" style="line-height: 1.7999999999999998; margin-left: 36pt; text-align: center; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 12pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Prefeito Municipal.</span></p>');
INSERT INTO public.relatorios (rel_sequencial, rel_descricao, rel_arquivo, rel_corpo) VALUES(1, 'AUTORIZAÇÃO', 1260, '<p dir="ltr">&nbsp;</p>
<p dir="ltr">&nbsp;</p>
<p id="docs-internal-guid-9a4297e9-7fff-d8da-5ab6-b60b3b08e9f8" dir="ltr" style="text-align: center;"><span style="font-size: 18pt; font-family: ''times new roman'', times, serif;"><strong>AUTORIZA&Ccedil;&Atilde;O</strong></span></p>
<p style="text-align: justify;"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"> Estando cumpridas as formalidades previstas na Lei n&deg; 8.666/93, AUTORIZO a abertura do Procedimento Licitat&oacute;rio do tipo #$l03_descr#, para #$l20_objeto# , conforme Parecer Jur&iacute;dico e pre&ccedil;o m&eacute;dio em anexo, solicito de V.Sa. que seja autorizada nos moldes previstos no art. 37, inciso XXI da CF/88, disp&otilde;e sobre a obrigatoriedade de formalizar processo licitat&oacute;rio pr&eacute;vio &agrave; aquisi&ccedil;&atilde;o, nos moldes da Lei 8666/93 e suas altera&ccedil;&otilde;es.</span></p>
<p style="text-align: justify;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;">Em atendimento ao disposto no inciso II do art. 16 da Lei Complementar n.&ordm; 101, de 05 de maio de 2000, declaro que a despesa tem adequa&ccedil;&atilde;o or&ccedil;ament&aacute;ria e financeira com a lei or&ccedil;ament&aacute;ria anual, compatibilidade com o plano plurianual e com a lei de diretrizes or&ccedil;ament&aacute;rias.&nbsp;</span></p>
<p style="text-align: justify;">&nbsp;</p>
<p>&nbsp;</p>
<p dir="ltr" style="text-align: right;"><span style="font-size: 14pt; font-family: ''times new roman'', times, serif;">#$sMunicipio#, #$dSistema#</span></p>
<p dir="ltr">&nbsp;</p>
<p dir="ltr">&nbsp;</p>
<p dir="ltr" style="text-align: center;">______________________________</p>
<p dir="ltr" style="text-align: center;"><span style="font-family: ''times new roman'', times, serif;">Prefeito Municipal.</span></p>');


SQL;

    $this->execute($sSql);
  }

  public function down()
  {
  }
}
