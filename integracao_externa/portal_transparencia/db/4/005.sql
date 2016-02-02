BEGIN;

INSERT INTO cms.menus
SELECT DISTINCT 7, 'Licita��es', true, true, NULL, NULL, NULL, '', false, '', '<div id="consulta_dados">     <fieldset><legend><a href="{{url_base}}/licitacoes">Licita��es</a>     </legend><div><p>Define-se como Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito      p�blico para o funcionamento dos servi�os p�blicos. Nesse sentido, a despesa � parte do or�amento, ou seja,      aquela em que se encontram classificadas todas as autoriza��es para gastos com as v�rias atribui��es e fun��es      governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e emprego das receitas      para custeio de diferentes setores da administra��o.</p></div></fieldset></div>', 13, 14
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 7);

INSERT INTO cms.menus
SELECT DISTINCT 1, 'P�gina Principal', true, true, '', 'MainController', 'loadMenu', 'pagina_principal', false, '', '<div id="consulta_dados">
   <p><br> </p>
   <p>   </p>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas">Despesas</a></legend>
      <div>
         <p>Define-se como Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito p�blico para o funcionamento dos servi�os p�blicos. Nesse sentido, a despesa � parte do or�amento, ou seja, aquela em que se encontram classificadas todas as autoriza��es para gastos com as v�rias atribui��es e fun��es governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e emprego das receitas para custeio de diferentes setores da administra��o.</p>
         <p></p>
         <p></p>
      </div>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/receitas">Receitas</a></legend>
      <p></p>
      <p>Receita P�blica � a soma de ingressos, impostos, taxas, contribui��es e outras fontes de recursos, arrecadados para atender �s despesas p�blicas.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas/loadDiarias">Di�rias</a></legend>
      <p></p>
      <p>Define-se como Di�ria a indeniza��o que faz jus o servidor ou agente pol�tico que se deslocar, temporariamente, da respectiva localidade onde tem exerc�cio, a servi�o ou para participar de evento de interesse da administra��o p�blica, pr�via e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimenta��o, hospedagem e locomo��o urbana (realizada por qualquer meio de transporte de cunho local).</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/main/outras_informacoes">Outras Informa��es</a></legend>
      <p></p>
      <p>Espa�o destinado a publica��es da Entidade relacionadas a gest�o da transpar�ncia.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend>
      <p></p>
      <p>Espa�o destinado a apresenta��o dos dados funcionais e salariais dos servidores (efetivos, cargo em comiss�o, cargos tempor�rios, aposentados e pensionistas)</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/licitacoes">Licitac�es</a></legend>
      <p></p>
      <p><div><p>Define-se c
omo Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito      p�blico para o funcionamento dos servi�os p�bl
icos. Nesse sentido, a despesa � parte do or�amento, ou seja,      aquela em que se encontram classificadas todas as autoriza��es para gasto
s com as v�rias atribui��es e fun��es      governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e 
emprego das receitas      para custeio de diferentes setores da administra��o.</p></div></p>
      <p></p>
   </fieldset>
   <br>
</div>', 1, 2
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 1);

INSERT INTO cms.menus
SELECT DISTINCT 6, 'Gloss�rio', true, false, '', 'MainController', 'loadMenu', 'glossario', false, '', '', 11, 12
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 6);

INSERT INTO cms.menus
SELECT DISTINCT 2, 'O que � o Portal', true, true, '', '', '', '', false, '', '<h1>O que � o Portal</h1> <br> <p>A divulga��o, de forma transparente, das A��es Governamentais, contribui com o processo democr�tico, permitindo aos cidad�os acompanharem os gastos e receitas executados pela Administra��o P�blica.</p> <br> <p>O Portal da Transpar�ncia � um canal onde qualquer cidad�o possa, de forma facilitada, efetuar consultas relativo aos gastos e receitas realizadas pelo poder p�blico - administra��o direta, autarquias, funda��es, legislativo, etc.</p>     ', 3, 4
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 2);
INSERT INTO cms.menus
SELECT DISTINCT 3, 'Como Consultar', true, true, '', '', '', '', false, '', '<h1>Como Consultar</h1> <br> <p>A navega��o no portal segue um padr�o b�sico para todos os n�veis de detalhamento da consulta onde, a partir da sele��o da forma de pesquisa - despesas por institui��o / �rg�o ou despesas por elemento e receitas por natureza ou receitas por fonte de recursos - � poss�vel acessar mais detalhes podendo-se por exemplo, chegar at� a n�vel de detalhamento do favorecido (credor) e visualizar o(s) item(s) adquirido ou servi�o contratado ou no caso da receita, chegar at� ao n�vel de detalhamento por exemplo do tributo arrecadado pela institui��o.</p> <br> <p>Para navegar no portal entrando nos n�veis mais detalhados, basta clicar sobre a linha onde est� o item que deseja visualizar, dessa forma ser� apresentada uma nova tela com mais informa��es sobre o item selecionado, para mais detalhes de um item dessa nova tela apresentada, clique sobre a linha e assim sucessivamente em cada nova tela apresentada.</p> <br> <p>Em rela��o a despesa, os valores informados s�o os respectivamente empenhado, anulado, liquidado e pago aos credores.</p> <br> <p>Em rela��o a receita, os valores informados s�o os respectivamente arrecadados.</p> <br> <p>O Portal da Transpar�ncia disp�e de dois tipos de consultas: Despesas e Receitas.</p>', 5, 6
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 3);
INSERT INTO cms.menus
SELECT DISTINCT 4, 'Origem dos Dados', true, true, '', '', '', '', false, '', '<h1>Origem dos Dados</h1> <br> <p>Cada institui��o que comp�e a Administra��o P�blica na esfera municipal, � respons�vel pela gest�o das a��es ligadas a sua �rea de atua��o, portanto os dados apresentados dentro de cada uma, s�o individualizados.</p> <br> <p>A atualiza��o das informa��es no portal � feita diariamente, logo os dados consultados correspondem a posi��o das receita e despesas efetivadas at� o dia imediatamente anterior ao da consulta.</p> <br> <p>No portal h� a possibilidade de efetuar consultas relativo a despesas e receitas do exerc�cio corrente, nesse caso os valores apresentados correspondem ao montante gasto e ao montante arrecadado de 1� de janeiro at� o dia imediatamente anterior ao da consulta. Na consulta de dados selecionando um exerc�cio anterior, os valores apresentados correspondem ao montante gasto e ao montante arrecadado de 1� de janeiro a 31 de dezembro do exerc�cio da consulta.</p> <br> <p>Na consulta da despesa, os valores apresentados restringe-se ao empenhado, anulado, liquidado e pago com movimenta��es ocorridas dentro do exerc�cio da consulta. N�o s�o apresentados nesse caso, os valores relativos a movimenta��es realizadas dos Restos a Pagar.</p>', 7, 8
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 4);

INSERT INTO cms.menus
SELECT DISTINCT 5, 'Consulta Dados', false, true, '', 'MainController', 'consulta_dados', '', false, '', '  <div id="consulta_dados">     <fieldset><legend><a href="{{url_base}}/despesas">Despesas</a>     </legend><div><p>Define-se como Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito      p�blico para o funcionamento dos servi�os p�blicos. Nesse sentido, a despesa � parte do or�amento, ou seja,      aquela em que se encontram classificadas todas as autoriza��es para gastos com as v�rias atribui��es e fun��es      governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e emprego das receitas      para custeio de diferentes setores da administra��o.</p></div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/receitas">Receitas</a></legend><div><p>Receita P�blica � a soma de ingressos,      impostos, taxas, contribui��es e outras fontes de recursos, arrecadados para atender �s despesas p�blicas.</p>     </div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/despesas/loadDiarias">Di�rias</a></legend><div><p>Define-se como Di�ria a indeniza��o que faz jus o servidor ou agente pol�tico que se deslocar, temporariamente, da respectiva localidade onde tem exerc�cio, a servi�o ou para participar de evento de interesse da administra��o p�blica, pr�via e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimenta��o, hospedagem e locomo��o urbana (realizada por qualquer meio de transporte de cunho local).</p></div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/main/outras_informacoes">Outras Informa��es</a></legend><div><p>Espa�o destinado a publica��es da Entidade relacionadas a gest�o da transpar�ncia.</p></div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend><div><p>Espa�o destinado a apresenta��o dos dados funcionais e salariais dos servidores (efetivos, cargo em comiss�o, cargos tempor�rios, aposentados e pensionistas)</p></div></fieldset><br /></div>   ', 9, 10
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 5);

update cms.menus set content = '<div id="consulta_dados">
   <p><br> </p>
   <p>   </p>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas">Despesas</a></legend>
      <div>
         <p>Define-se como Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito p�blico para o funcionamento dos servi�os p�blicos. Nesse sentido, a despesa � parte do or�amento, ou seja, aquela em que se encontram classificadas todas as autoriza��es para gastos com as v�rias atribui��es e fun��es governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e emprego das receitas para custeio de diferentes setores da administra��o.</p>
         <p></p>
         <p></p>
      </div>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/receitas">Receitas</a></legend>
      <p></p>
      <p>Receita P�blica � a soma de ingressos, impostos, taxas, contribui��es e outras fontes de recursos, arrecadados para atender �s despesas p�blicas.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas/loadDiarias">Di�rias</a></legend>
      <p></p>
      <p>Define-se como Di�ria a indeniza��o que faz jus o servidor ou agente pol�tico que se deslocar, temporariamente, da respectiva localidade onde tem exerc�cio, a servi�o ou para participar de evento de interesse da administra��o p�blica, pr�via e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimenta��o, hospedagem e locomo��o urbana (realizada por qualquer meio de transporte de cunho local).</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/main/outras_informacoes">Outras Informa��es</a></legend>
      <p></p>
      <p>Espa�o destinado a publica��es da Entidade relacionadas a gest�o da transpar�ncia.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend>
      <p></p>
      <p>Espa�o destinado a apresenta��o dos dados funcionais e salariais dos servidores (efetivos, cargo em comiss�o, cargos tempor�rios, aposentados e pensionistas)</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/licitacoes">Licitac�es</a></legend>
      <p></p>
      <p><div><p>Define-se c
omo Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito      p�blico para o funcionamento dos servi�os p�bl
icos. Nesse sentido, a despesa � parte do or�amento, ou seja,      aquela em que se encontram classificadas todas as autoriza��es para gasto
s com as v�rias atribui��es e fun��es      governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e
emprego das receitas      para custeio de diferentes setores da administra��o.</p></div></p>
      <p></p>
   </fieldset>
   <br>
</div>' where id = 1;


COMMIT;