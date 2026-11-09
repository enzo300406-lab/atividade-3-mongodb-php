<?php
require_once 'config.php';

$totalEstudantes = $estudantes->countDocuments();
$totalCursos = $cursos->countDocuments();
$totalMatriculas = $matriculas->countDocuments();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Acadêmico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container"><a class="navbar-brand fw-semibold" href="index.php">Portal Acadêmico</a></div>
</nav>
<main class="container py-5">
  <div class="mb-4">
    <h1 class="fw-bold">Sistema acadêmico</h1>
    <p class="text-secondary">Gerencie estudantes, cursos e matrículas.</p>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card stat-card"><div class="card-body"><span class="text-secondary">Estudantes</span><h2><?= $totalEstudantes ?></h2></div></div></div>
    <div class="col-md-4"><div class="card stat-card"><div class="card-body"><span class="text-secondary">Cursos</span><h2><?= $totalCursos ?></h2></div></div></div>
    <div class="col-md-4"><div class="card stat-card"><div class="card-body"><span class="text-secondary">Matrículas</span><h2><?= $totalMatriculas ?></h2></div></div></div>
  </div>
  <div class="row g-3">
    <div class="col-md-4"><a class="menu-card" href="estudantes.php"><h4>Estudantes</h4><p>Cadastrar, editar e consultar estudantes.</p><span>Acessar →</span></a></div>
    <div class="col-md-4"><a class="menu-card" href="cursos.php"><h4>Cursos</h4><p>Gerenciar cursos disponíveis.</p><span>Acessar →</span></a></div>
    <div class="col-md-4"><a class="menu-card" href="matriculas.php"><h4>Matrículas</h4><p>Vincular estudantes aos cursos.</p><span>Acessar →</span></a></div>
  </div>
</main>
<footer class="text-center text-secondary py-4">Atividade 3 — MongoDB e PHP</footer>
</body>
</html>
