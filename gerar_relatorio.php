<?php

// Array de dados
$registros = [
    [
        'Número' => 9804,
        'Portal' => 'Jira',
        'DataAberta' => '11/06/2025',
        'DataConclusao' => '12/06/2025',
        'DescriçãoCliente' => 'Disponibilid... (exemplo)',
        'Analista' => 'Luis Lima',
        'Departamento' => 'Gustavo T',
        'Status' => 'Concluído',
        'Categoria' => 'Limpeza',
        'Link' => 'https://...'
    ],
    [
        'Número' => 269928,
        'Portal' => 'Manager',
        'DataAberta' => '11/06/2025',
        'DataConclusao' => '12/06/2025',
        'DescriçãoCliente' => 'Problema... (exemplo)',
        'Analista' => 'Alana Soa',
        'Departamento' => 'Gustavo T',
        'Status' => 'Concluído',
        'Categoria' => 'Configuração',
        'Link' => 'https://...'
    ],
    // Adicione mais registros conforme necessário
];

// Exibir os dados
foreach ($registros as $registro) {
    echo "Número: " . $registro['Número'] . "\n";
    echo "Portal: " . $registro['Portal'] . "\n";
    echo "Data Aberta: " . $registro['DataAberta'] . "\n";
    echo "Data Conclusão: " . $registro['DataConclusao'] . "\n";
    echo "Descrição Cliente: " . $registro['DescriçãoCliente'] . "\n";
    echo "Analista: " . $registro['Analista'] . "\n";
    echo "Departamento: " . $registro['Departamento'] . "\n";
    echo "Status: " . $registro['Status'] . "\n";
    echo "Categoria: " . $registro['Categoria'] . "\n";
    echo "Link: " . $registro['Link'] . "\n";
    echo "-------------------\n";
}

?>