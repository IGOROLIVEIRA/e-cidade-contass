BEGIN;

INSERT INTO cms.menus
SELECT DISTINCT 7, 'Licitações', true, true, NULL, NULL, NULL, '', false, '', '<div id="consulta_dados">     <fieldset><legend><a href="{{url_base}}/licitacoes">Licitações</a>     </legend><div><p>Define-se como Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito      público para o funcionamento dos serviços públicos. Nesse sentido, a despesa é parte do orçamento, ou seja,      aquela em que se encontram classificadas todas as autorizações para gastos com as várias atribuições e funções      governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e emprego das receitas      para custeio de diferentes setores da administração.</p></div></fieldset></div>', 13, 14
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 7);

INSERT INTO cms.menus
SELECT DISTINCT 1, 'Página Principal', true, true, '', 'MainController', 'loadMenu', 'pagina_principal', false, '', '<div id="consulta_dados">
   <p><br> </p>
   <p>   </p>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas">Despesas</a></legend>
      <div>
         <p>Define-se como Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito público para o funcionamento dos serviços públicos. Nesse sentido, a despesa é parte do orçamento, ou seja, aquela em que se encontram classificadas todas as autorizações para gastos com as várias atribuições e funções governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e emprego das receitas para custeio de diferentes setores da administração.</p>
         <p></p>
         <p></p>
      </div>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/receitas">Receitas</a></legend>
      <p></p>
      <p>Receita Pública é a soma de ingressos, impostos, taxas, contribuições e outras fontes de recursos, arrecadados para atender às despesas públicas.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas/loadDiarias">Diárias</a></legend>
      <p></p>
      <p>Define-se como Diária a indenização que faz jus o servidor ou agente político que se deslocar, temporariamente, da respectiva localidade onde tem exercício, a serviço ou para participar de evento de interesse da administração pública, prévia e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimentação, hospedagem e locomoção urbana (realizada por qualquer meio de transporte de cunho local).</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/main/outras_informacoes">Outras Informações</a></legend>
      <p></p>
      <p>Espaço destinado a publicações da Entidade relacionadas a gestão da transparência.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend>
      <p></p>
      <p>Espaço destinado a apresentação dos dados funcionais e salariais dos servidores (efetivos, cargo em comissão, cargos temporários, aposentados e pensionistas)</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/licitacoes">Licitacões</a></legend>
      <p></p>
      <p><div><p>Define-se c
omo Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito      público para o funcionamento dos serviços públ
icos. Nesse sentido, a despesa é parte do orçamento, ou seja,      aquela em que se encontram classificadas todas as autorizações para gasto
s com as várias atribuições e funções      governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e 
emprego das receitas      para custeio de diferentes setores da administração.</p></div></p>
      <p></p>
   </fieldset>
   <br>
</div>', 1, 2
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 1);

INSERT INTO cms.menus
SELECT DISTINCT 6, 'Glossário', true, false, '', 'MainController', 'loadMenu', 'glossario', false, '', '', 11, 12
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 6);

INSERT INTO cms.menus
SELECT DISTINCT 2, 'O que é o Portal', true, true, '', '', '', '', false, '', '<h1>O que é o Portal</h1> <br> <p>A divulgação, de forma transparente, das Ações Governamentais, contribui com o processo democrático, permitindo aos cidadãos acompanharem os gastos e receitas executados pela Administração Pública.</p> <br> <p>O Portal da Transparência é um canal onde qualquer cidadão possa, de forma facilitada, efetuar consultas relativo aos gastos e receitas realizadas pelo poder público - administração direta, autarquias, fundações, legislativo, etc.</p>     ', 3, 4
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 2);
INSERT INTO cms.menus
SELECT DISTINCT 3, 'Como Consultar', true, true, '', '', '', '', false, '', '<h1>Como Consultar</h1> <br> <p>A navegação no portal segue um padrão básico para todos os níveis de detalhamento da consulta onde, a partir da seleção da forma de pesquisa - despesas por instituição / órgão ou despesas por elemento e receitas por natureza ou receitas por fonte de recursos - é possível acessar mais detalhes podendo-se por exemplo, chegar até a nível de detalhamento do favorecido (credor) e visualizar o(s) item(s) adquirido ou serviço contratado ou no caso da receita, chegar até ao nível de detalhamento por exemplo do tributo arrecadado pela instituição.</p> <br> <p>Para navegar no portal entrando nos níveis mais detalhados, basta clicar sobre a linha onde está o item que deseja visualizar, dessa forma será apresentada uma nova tela com mais informações sobre o item selecionado, para mais detalhes de um item dessa nova tela apresentada, clique sobre a linha e assim sucessivamente em cada nova tela apresentada.</p> <br> <p>Em relação a despesa, os valores informados são os respectivamente empenhado, anulado, liquidado e pago aos credores.</p> <br> <p>Em relação a receita, os valores informados são os respectivamente arrecadados.</p> <br> <p>O Portal da Transparência dispõe de dois tipos de consultas: Despesas e Receitas.</p>', 5, 6
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 3);
INSERT INTO cms.menus
SELECT DISTINCT 4, 'Origem dos Dados', true, true, '', '', '', '', false, '', '<h1>Origem dos Dados</h1> <br> <p>Cada instituição que compõe a Administração Pública na esfera municipal, é responsável pela gestão das ações ligadas a sua área de atuação, portanto os dados apresentados dentro de cada uma, são individualizados.</p> <br> <p>A atualização das informações no portal é feita diariamente, logo os dados consultados correspondem a posição das receita e despesas efetivadas até o dia imediatamente anterior ao da consulta.</p> <br> <p>No portal há a possibilidade de efetuar consultas relativo a despesas e receitas do exercício corrente, nesse caso os valores apresentados correspondem ao montante gasto e ao montante arrecadado de 1º de janeiro até o dia imediatamente anterior ao da consulta. Na consulta de dados selecionando um exercício anterior, os valores apresentados correspondem ao montante gasto e ao montante arrecadado de 1º de janeiro a 31 de dezembro do exercício da consulta.</p> <br> <p>Na consulta da despesa, os valores apresentados restringe-se ao empenhado, anulado, liquidado e pago com movimentações ocorridas dentro do exercício da consulta. Não são apresentados nesse caso, os valores relativos a movimentações realizadas dos Restos a Pagar.</p>', 7, 8
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 4);

INSERT INTO cms.menus
SELECT DISTINCT 5, 'Consulta Dados', false, true, '', 'MainController', 'consulta_dados', '', false, '', '  <div id="consulta_dados">     <fieldset><legend><a href="{{url_base}}/despesas">Despesas</a>     </legend><div><p>Define-se como Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito      público para o funcionamento dos serviços públicos. Nesse sentido, a despesa é parte do orçamento, ou seja,      aquela em que se encontram classificadas todas as autorizações para gastos com as várias atribuições e funções      governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e emprego das receitas      para custeio de diferentes setores da administração.</p></div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/receitas">Receitas</a></legend><div><p>Receita Pública é a soma de ingressos,      impostos, taxas, contribuições e outras fontes de recursos, arrecadados para atender às despesas públicas.</p>     </div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/despesas/loadDiarias">Diárias</a></legend><div><p>Define-se como Diária a indenização que faz jus o servidor ou agente político que se deslocar, temporariamente, da respectiva localidade onde tem exercício, a serviço ou para participar de evento de interesse da administração pública, prévia e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimentação, hospedagem e locomoção urbana (realizada por qualquer meio de transporte de cunho local).</p></div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/main/outras_informacoes">Outras Informações</a></legend><div><p>Espaço destinado a publicações da Entidade relacionadas a gestão da transparência.</p></div></fieldset><br /><fieldset><legend>     <a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend><div><p>Espaço destinado a apresentação dos dados funcionais e salariais dos servidores (efetivos, cargo em comissão, cargos temporários, aposentados e pensionistas)</p></div></fieldset><br /></div>   ', 9, 10
FROM cms.menus cm LEFT JOIN cms.menus m ON cm.id = m.id
WHERE NOT EXISTS (SELECT * FROM cms.menus c
              WHERE c.id = 5);

update cms.menus set content = '<div id="consulta_dados">
   <p><br> </p>
   <p>   </p>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas">Despesas</a></legend>
      <div>
         <p>Define-se como Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito público para o funcionamento dos serviços públicos. Nesse sentido, a despesa é parte do orçamento, ou seja, aquela em que se encontram classificadas todas as autorizações para gastos com as várias atribuições e funções governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e emprego das receitas para custeio de diferentes setores da administração.</p>
         <p></p>
         <p></p>
      </div>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/receitas">Receitas</a></legend>
      <p></p>
      <p>Receita Pública é a soma de ingressos, impostos, taxas, contribuições e outras fontes de recursos, arrecadados para atender às despesas públicas.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas/loadDiarias">Diárias</a></legend>
      <p></p>
      <p>Define-se como Diária a indenização que faz jus o servidor ou agente político que se deslocar, temporariamente, da respectiva localidade onde tem exercício, a serviço ou para participar de evento de interesse da administração pública, prévia e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimentação, hospedagem e locomoção urbana (realizada por qualquer meio de transporte de cunho local).</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/main/outras_informacoes">Outras Informações</a></legend>
      <p></p>
      <p>Espaço destinado a publicações da Entidade relacionadas a gestão da transparência.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend>
      <p></p>
      <p>Espaço destinado a apresentação dos dados funcionais e salariais dos servidores (efetivos, cargo em comissão, cargos temporários, aposentados e pensionistas)</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/licitacoes">Licitacões</a></legend>
      <p></p>
      <p><div><p>Define-se c
omo Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito      público para o funcionamento dos serviços públ
icos. Nesse sentido, a despesa é parte do orçamento, ou seja,      aquela em que se encontram classificadas todas as autorizações para gasto
s com as várias atribuições e funções      governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e
emprego das receitas      para custeio de diferentes setores da administração.</p></div></p>
      <p></p>
   </fieldset>
   <br>
</div>' where id = 1;


COMMIT;