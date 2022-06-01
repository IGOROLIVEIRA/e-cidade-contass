<?php

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">

<head>
    <title>Extrato de Contrato</title>
    <meta http-equiv="Content-Type" content="text/html;  charset=ISO-8859-1">
</head>

<body>
    <h2>Extrato de Contrato</h2>

    <h4><strong>Num. Contrato:</strong></h4>
    <h4><strong>Departamento:</strong></h4>
    <h4><strong>Data Assinatura:</strong></h4>
    <h4><strong>Contratado:</strong></h4>
    <h4><strong>Vigencia:</strong></h4>
    <h4><strong>Valor do Contrato:</strong></h4>
    <h4><strong>Objeto:</strong></h4>
</body>

</html>

<?php

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=ExtratoContrato.doc");

?>