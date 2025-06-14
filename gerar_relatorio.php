<?php
// Configurações
$arquivoCSV = 'chamados.csv';
$arquivoRelatorio = 'relatorio.txt';

// Abre CSV para leitura
if (!file_exists($arquivoCSV)) {
    die("Arquivo CSV não encontrado.");
}

$handle = fopen($arquivoCSV, 'r');
if (!$handle) {
    die("Erro ao abrir o arquivo CSV.");
}

// Lê o cabeçalho
$cabecalho = fgetcsv($handle, 0, ';');
if (!$cabecalho) {
    die("Erro ao ler o cabeçalho do CSV.");
}

// Remove espaços antes/depois e normaliza para minúsculas (ou não)
$cabecalho = array_map(function($col) {
    return trim($col);
}, $cabecalho);

// Confere se as colunas esperadas existem
$colunasEsperadas = ['Número', 'Portal', 'Data Abertura', 'Data Conclusão', 'Descrição', 'Cliente', 'Analista', 'Departamento', 'Status', 'Categoria', 'Link', 'Resolução'];
foreach ($colunasEsperadas as $col) {
    if (!isset($index[$col])) {
        die("Coluna '$col' não encontrada no CSV.");
    }
}

// Lê todas as linhas
$linhas = [];
while (($linha = fgetcsv($handle, 0, ';')) !== false) {
    // Garante que o número de colunas bate com o cabeçalho (pode ignorar linhas mal formatadas)
    if (count($linha) == count($cabecalho)) {
        $linhas[] = array_map('trim', $linha);
    }
}
fclose($handle);

if (empty($linhas)) {
    die("Nenhum dado encontrado no CSV.");
}

// Busca a última data de conclusão válida (maior data)
$datasConclusao = [];
foreach ($linhas as $linha) {
    $data = $linha[$index['Data Conclusão']];
    if ($data !== '' && strtotime($data) !== false) {
        $datasConclusao[] = $data;
    }
}
if (empty($datasConclusao)) {
    die("Nenhuma data de conclusão válida encontrada.");
}
rsort($datasConclusao);
$dataFiltro = $datasConclusao[0]; // última data de conclusão

// Filtra linhas que têm essa data de conclusão
$linhasFiltradas = array_filter($linhas, function($linha) use ($index, $dataFiltro) {
    return trim($linha[$index['Data Conclusão']]) === $dataFiltro;
});

// Se não achou linhas, avisa e encerra
if (count($linhasFiltradas) == 0) {
    die("Nenhum chamado encontrado para a data $dataFiltro.");
}

// Separa chamados encerrados e pendentes (status)
$encerradosStatus = ['Concluído', 'Encerrado por falta de retorno'];
$encerrados = [];
$pendentes = [];
foreach ($linhasFiltradas as $linha) {
    $status = $linha[$index['Status']];
    if (in_array($status, $encerradosStatus)) {
        $encerrados[] = $linha;
    } else {
        $pendentes[] = $linha;
    }
}

// Monta texto do relatório
$relatorio = "RELATÓRIO DE CHAMADOS - Data de Conclusão: $dataFiltro\n";
$relatorio .= "==================================================\n\n";

$relatorio .= "Chamados Encerrados (" . count($encerrados) . "):\n";
foreach ($encerrados as $c) {
    $relatorio .= "- Nº: {$c[$index['Número']]} | Cliente: {$c[$index['Cliente']]} | Descrição: {$c[$index['Descrição']]} | Analista: {$c[$index['Analista']]} | Status: {$c[$index['Status']]}\n";
}
$relatorio .= "\n";

$relatorio .= "Chamados Pendentes (" . count($pendentes) . "):\n";
foreach ($pendentes as $p) {
    $relatorio .= "- Nº: {$p[$index['Número']]} | Cliente: {$p[$index['Cliente']]} | Descrição: {$p[$index['Descrição']]} | Analista: {$p[$index['Analista']]} | Status: {$p[$index['Status']]}\n";
}

// Salva o arquivo relatorio.txt, sobrescrevendo
file_put_contents($arquivoRelatorio, $relatorio);

// Mensagem simples para o usuário
echo "Relatório gerado com sucesso! <br>";
echo "<pre>" . htmlspecialchars($relatorio) . "</pre>";
echo "<a href='$arquivoRelatorio' download>Download do relatório</a>";