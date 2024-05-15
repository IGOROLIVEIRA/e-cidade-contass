<?php
return array(
  'infoHorContratual' => array(
      'properties' => array(
          'codHorContrat' => 'codHorContrat',
          'iniValid' => 'iniValid',
          'fimValid' => 'fimValid'
      )
  ),
  'dadosHorContratual' => array(
      'properties' => array(
          'hrEntr' => 'hrEntr',
          'hrSaida' => 'hrSaida',
          'durJornada' => 'durJornada',
          'perHorFlexivel' => 'perHorFlexivel'
      )
  ),
  'horarioIntervalo' => array (
      'properties' => array(
          'tpInterv' => array (
              'tpInterv' => 'tpInterv',
              'type' => 'int'
          ),
          'durInterv' => 'durInterv',
          'iniInterv' => 'iniInterv',
          'termInterv' => 'termInterv'
      )
  )
);