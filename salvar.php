<?php
$dataSelecionada = $_GET['data'];

if (!$dataSelecionada) {
  echo "❌ Data não fornecida.";
  exit;
}

$arquivo = fopen("chamados.csv", "r");
if (!$arquivo) {
  echo "❌ Erro ao abrir o arquivo de chamados.";
  exit;
}

$registros = [];
while (($linha = fgetcsv($arquivo, 1000, ",")) !== FALSE) {
  list($numero, $portal, $dt_inicio, $dt_conclusao, $descricao, $cliente, $analista, $departamento, $categoria, $link, $resolucao) = $linha;
  
  if ($dt_conclusao === $dataSelecionada) {
    $registros[] = [
      'numero' => $numero,
      'portal' => $portal,
      'descricao' => $descricao,
      'link' => $link,
      'resolucao' => $resolucao
    ];
  }
}
fclose($arquivo);

// Agrupar por portal
$portais = [];
foreach ($registros as $r) {
  $portal = ucfirst(trim($r['portal'])) ?: 'Outros';
  $portais[$portal][] = $r;
}

// Gerar texto do relatório
$dt_formatada = date('d/m/Y', strtotime($dataSelecionada));
$diaSeguinte = date('d/m/Y', strtotime($dataSelecionada . ' +1 day'));

echo "<pre>";
echo "PLANTÃO NOC - Noturno ($dt_formatada - $diaSeguinte) Sistemas Gustavo Tiano\n\n";
echo "Chamados Encerrados:\n\n";

foreach ($portais as $portal => $chamados) {
  echo "$portal:\n\n";
  foreach ($chamados as $c) {
    $link = $c['link'] ? $c['link'] : "(sem link)";
    echo "$link – {$c['descricao']}{$c['resolucao']}\n\n";
  }
}
echo "</pre>";
?>