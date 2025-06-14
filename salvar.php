<?php
// Ativa exibição de erros para debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Arquivo CSV
$arquivoCSV = 'chamados.csv';

// Dados do POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        $_POST['numero'] ?? '',
        $_POST['portal'] ?? '',
        $_POST['dt_abertura'] ?? '',
        $_POST['dt_conclusao'] ?? '',
        $_POST['descricao'] ?? '',
        $_POST['cliente'] ?? '',
        $_POST['analista'] ?? '',
        $_POST['departamento'] ?? '',
        $_POST['status'] ?? '',
        $_POST['categoria'] ?? '',
        $_POST['link'] ?? '',
        $_POST['resolucao'] ?? ''
    ];

    // Verifica se o arquivo já existe (para evitar sobrescrever header)
    $arquivoExiste = file_exists($arquivoCSV);

    // Abre o CSV com codificação UTF-8 e separador ';'
    if (($arquivo = fopen($arquivoCSV, 'a')) !== FALSE) {
        // Se o arquivo não existe, escreve o cabeçalho
        if (!$arquivoExiste) {
            fputcsv($arquivo, [
                'Número', 'Portal', 'Data Abertura', 'Data Conclusão',
                'Descrição', 'Cliente', 'Analista', 'Departamento',
                'Status', 'Categoria', 'Link', 'Resolução'
            ], ';');
        }

        // Insere os dados no CSV com separador ';'
        fputcsv($arquivo, $dados, ';');
        fclose($arquivo);

        // Mostra popup com JavaScript
        echo "<script>
                alert('✅ Chamado salvo com sucesso.');
                window.location.href = '/chamados/index.html?sucesso=1';
              </script>";
        exit;
    } else {
        echo "<script>alert('❌ Erro ao abrir o arquivo CSV.');</script>";
    }
} else {
    echo "<script>alert('❌ Requisição inválida.');</script>";
}
