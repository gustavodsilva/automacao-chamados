<?php
$arquivo = __DIR__ . '/chamados.csv';

if (!file_exists($arquivo)) {
    die("❌ Nenhum chamado registrado ainda.");
}

$linhas = array_map('str_getcsv', file($arquivo));
$chamados = [];
$dataLimite = new DateTime('-12 hours');

// Remove cabeçalho se houver (opcional)
if (count($linhas) > 0 && strtolower($linhas[0][0]) === 'numero') {
    array_shift($linhas);
}

foreach ($linhas as $linha) {
    // [2] = dt_inicio
    $dt_inicio = DateTime::createFromFormat('Y-m-d', $linha[2]);

    if ($dt_inicio && $dt_inicio >= $dataLimite) {
        $chamados[] = $linha;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Últimos Chamados (12h)</title>
  <link rel="stylesheet" href="style.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    th {
      background: #eee;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Chamados das Últimas 12 Horas</h1>

    <?php if (empty($chamados)): ?>
      <p>📭 Nenhum chamado registrado nas últimas 12 horas.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Número</th>
            <th>Portal</th>
            <th>Início</th>
            <th>Descrição</th>
            <th>Cliente</th>
            <th>Analista</th>
            <th>Departamento</th>
            <th>Categoria</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($chamados as $linha): ?>
            <tr>
              <td><?= htmlspecialchars($linha[0]) ?></td>
              <td><?= htmlspecialchars($linha[1]) ?></td>
              <td><?= htmlspecialchars($linha[2]) ?></td>
              <td><?= htmlspecialchars($linha[4]) ?></td>
              <td><?= htmlspecialchars($linha[5]) ?></td>
              <td><?= htmlspecialchars($linha[6]) ?></td>
              <td><?= htmlspecialchars($linha[7]) ?></td>
              <td><?= htmlspecialchars($linha[8]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <p><a href="index.html">🔙 Voltar ao formulário</a></p>
  </div>
</body>
</html>