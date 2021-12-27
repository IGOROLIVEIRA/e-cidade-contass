<?php
return array(
  'ideCargo' => array(
      'properties' => array(
          'codCargo' => 'codCargo',
          'iniValid' => 'iniValid',
          'fimValid' => 'fimValid',
      )
  ),
  'dadosCargo' => array(
      'properties' => array (
          'nmCargo' => 'nmCargo',
          'codCBO' => 'codCBO'
      )
  ),
  'cargoPublico' => array (
      'properties' => array (
          'acumCargo' => array(
              'acumCargo' => 'acumCargo',
              'type' => 'int'
          ),
          'contagemEsp' => array(
              'contagemEsp' => 'contagemEsp',
              'type' => 'int'
          ),
          'dedicExcl' => 'dedicExcl'
      )
  ),
  'leiCargo' => array(
      'properties' => array(
          'nrLei' => 'nrLei',
          'dtLei' => 'dtLei',
          'sitCargo' => array(
              'sitCargo' => 'sitCargo',
              'type' => 'int'
          )
      )
  )
);
