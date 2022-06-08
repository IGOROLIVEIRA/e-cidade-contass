<?php
return array(
  'ideHorContratual' => array(
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
          'durJornada' => array (
              'durJornada' => 'durJornada',
              'type' => 'int'
          ),
          'perHorFlexivel' => 'perHorFlexivel'
      )
  ),
  'horarioIntervalo' => array (
      'properties' => array(
          'tpInterv' => array (
              'tpInterv' => 'tpInterv',
              'type' => 'int'
          ),
          'durInterv' => array (
              'durInterv' => 'durInterv',
              'type' => 'int'
          ),
          'iniInterv' => 'iniInterv',
          'termInterv' => 'termInterv'
      )
  )
);