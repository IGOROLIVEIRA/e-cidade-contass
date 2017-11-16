#!/bin/bash

output=''

buscar() {
  MODEL=../model/contabilidade/arquivos/sicom
  CLASSES=../classes
  output=$(find ${MODEL} -type d -name "*${1}")
  if test ! -z "$output" ; then
    echo $output
  fi

  output=$(find ${CLASSES} -type f -name "*${1}*")
  if test ! -z "$output" ; then
    echo $output
  fi
}

if test $# -lt 2 ; then
  echo "\nForma de usar: \nsh $0 (ano base) (novo ano)\n";
  exit 1;
fi

ANOA=$1
ANOB=$2
resultado=$(buscar $ANOB | wc -l)

if test $resultado -gt 0 ; then
  echo "Erro: arquivos/diretórios do sicom ${ANOB} já existem. Abortando operação."
  exit 2;
fi

#> Cria cópias dos arquivos/diretórios relativos ao ano anterior
for _path in $(buscar $ANOA) ; do
  _novo=$(echo "$_path" | sed "s/$ANOA/$ANOB/")

  if test -d $_path ; then

    cp -a $_path $_novo
    for _file in $(find $_novo -type f) ; do
      conteudo=$(cat $_file | sed "s/$ANOA/$ANOB/g")
      echo "$conteudo" > $_file
    done

  else

    conteudo=$(cat $_path | sed "s/$ANOA/$ANOB/g")
    echo "$conteudo" > $_novo

  fi
done


