<?php
$arquivoCSV = 'chamados\\teste.php';  // coloque o caminho correto

$handle = fopen($arquivoCSV, 'r');
if (!$handle) {
    die("Erro ao abrir o arquivo CSV.");
}

$cabecalho = fgetcsv($handle, 0, ';');
if (!$cabecalho) {
    die("Erro ao ler o cabeçalho do CSV.");
}

$cabecalho = array_map('trim', $cabecalho);

echo '<pre>Colunas lidas no CSV:' . PHP_EOL;
print_r($cabecalho);
echo '</pre>';
exit;
?>
