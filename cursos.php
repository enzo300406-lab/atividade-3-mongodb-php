<?php
require_once 'config.php';
use MongoDB\BSON\ObjectId;
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = ['nome'=>trim($_POST['nome'] ?? ''),'codigo'=>trim($_POST['codigo'] ?? ''),'descricao'=>trim($_POST['descricao'] ?? ''),'carga_horaria'=>(int)($_POST['carga_horaria'] ?? 0),' modalidade'=>trim($_POST['modalidade'] ?? ''),'nivel'=>trim($_POST['nivel'] ?? '')];
    unset($dados[' modalidade']);
    $dados['modalidade'] = trim($_POST['modalidade'] ?? '');
    if (!empty($_POST['id'])) $cursos->updateOne(['_id'=>new ObjectId($_POST['id'])], ['$set'=>$dados]);
    else $cursos->insertOne($dados);
    header('Location: cursos.php'); exit;
}
if(isset($_GET['excluir'])) { $id=new ObjectId($_GET['excluir']); $cursos->deleteOne(['_id'=>$id]); $matriculas->deleteMany(['curso_id'=>$id]); header('Location: cursos.php'); exit; }
$editar=isset($_GET['editar'])?$cursos->findOne(['_id'=>new ObjectId($_GET['editar'])]):null;
$lista=$cursos->find([],['sort'=>['nome'=>1]])->toArray();
?>
<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Cursos</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="style.css" rel="stylesheet"></head><body><nav class="navbar navbar-dark bg-primary"><div class="container"><a class="navbar-brand" href="index.php">Portal Acadêmico</a></div></nav><main class="container py-4"><a href="index.php" class="text-decoration-none">← Início</a><h1 class="mt-3 mb-4">Cursos</h1>
<div class="card mb-4"><div class="card-body"><h5><?= $editar?'Editar curso':'Novo curso' ?></h5><form method="post" class="row g-3"><input type="hidden" name="id" value="<?= $editar?h((string)$editar['_id']):'' ?>">
<div class="col-md-6"><label class="form-label">Nome *</label><input class="form-control" name="nome" required value="<?= h($editar['nome']??'') ?>"></div><div class="col-md-3"><label class="form-label">Código</label><input class="form-control" name="codigo" value="<?= h($editar['codigo']??'') ?>"></div><div class="col-md-3"><label class="form-label">Carga horária</label><input type="number" class="form-control" name="carga_horaria" value="<?= h($editar['carga_horaria']??'') ?>"></div>
<div class="col-md-4"><label class="form-label">Modalidade</label><select class="form-select" name="modalidade"><option>Presencial</option><option <?= (($editar['modalidade']??'')==='EAD')?'selected':'' ?>>EAD</option><option <?= (($editar['modalidade']??'')==='Híbrido')?'selected':'' ?>>Híbrido</option></select></div><div class="col-md-4"><label class="form-label">Nível</label><input class="form-control" name="nivel" value="<?= h($editar['nivel']??'') ?>"></div><div class="col-12"><label class="form-label">Descrição</label><textarea class="form-control" name="descricao"><?= h($editar['descricao']??'') ?></textarea></div><div class="col-12"><button class="btn btn-primary">Salvar curso</button><?php if($editar): ?> <a class="btn btn-outline-secondary" href="cursos.php">Cancelar</a><?php endif; ?></div></form></div></div>
<div class="card"><div class="card-body"><h5>Cursos cadastrados</h5><div class="table-responsive"><table class="table"><thead><tr><th>Nome</th><th>Código</th><th>Modalidade</th><th>Carga horária</th><th>Ações</th></tr></thead><tbody><?php foreach($lista as $c): ?><tr><td><?= h($c['nome']??'') ?></td><td><?= h($c['codigo']??'') ?></td><td><?= h($c['modalidade']??'') ?></td><td><?= h($c['carga_horaria']??'') ?>h</td><td><a class="btn btn-sm btn-outline-primary" href="?editar=<?= h((string)$c['_id']) ?>">Editar</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este curso?')" href="?excluir=<?= h((string)$c['_id']) ?>">Excluir</a></td></tr><?php endforeach; ?><?php if(!$lista): ?><tr><td colspan="5" class="text-secondary">Nenhum curso cadastrado.</td></tr><?php endif; ?></tbody></table></div></div></div></main></body></html>
