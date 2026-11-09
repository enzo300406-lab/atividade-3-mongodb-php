<?php
require_once 'config.php';
use MongoDB\BSON\ObjectId;
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $eid=new ObjectId($_POST['estudante_id']); $cid=new ObjectId($_POST['curso_id']);
    $existe=$matriculas->findOne(['estudante_id'=>$eid,'curso_id'=>$cid]);
    if(!$existe){$matriculas->insertOne(['estudante_id'=>$eid,'curso_id'=>$cid,'data_matricula'=>date('Y-m-d'),'status'=>'Ativa']);}
    header('Location: matriculas.php');exit;
}
if(isset($_GET['excluir'])){$matriculas->deleteOne(['_id'=>new ObjectId($_GET['excluir'])]);header('Location: matriculas.php');exit;}
$alunos=$estudantes->find([],['sort'=>['nome'=>1]])->toArray();$lista=$matriculas->find()->toArray();
?>
<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Matrículas</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="style.css" rel="stylesheet"></head><body><nav class="navbar navbar-dark bg-primary"><div class="container"><a class="navbar-brand" href="index.php">Portal Acadêmico</a></div></nav><main class="container py-4"><a href="index.php" class="text-decoration-none">← Início</a><h1 class="mt-3 mb-4">Matrículas</h1>
<div class="card mb-4"><div class="card-body"><h5>Nova matrícula</h5><?php if(!$alunos||!$cursos->countDocuments()): ?><div class="alert alert-warning">Cadastre pelo menos um estudante e um curso antes de matricular.</div><?php else: ?><form method="post" class="row g-3"><div class="col-md-5"><label class="form-label">Estudante</label><select class="form-select" name="estudante_id" required><?php foreach($alunos as $a): ?><option value="<?= h((string)$a['_id']) ?>"><?= h($a['nome']) ?></option><?php endforeach; ?></select></div><div class="col-md-5"><label class="form-label">Curso</label><select class="form-select" name="curso_id" required><?php foreach($cursos->find([],['sort'=>['nome'=>1]]) as $c): ?><option value="<?= h((string)$c['_id']) ?>"><?= h($c['nome']) ?></option><?php endforeach; ?></select></div><div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Matricular</button></div></form><?php endif; ?></div></div>
<div class="card"><div class="card-body"><h5>Matrículas realizadas</h5><div class="table-responsive"><table class="table"><thead><tr><th>Estudante</th><th>Curso</th><th>Data</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($lista as $m): $a=$estudantes->findOne(['_id'=>$m['estudante_id']]);$c=$cursos->findOne(['_id'=>$m['curso_id']]); ?><tr><td><?= h($a['nome']??'Estudante removido') ?></td><td><?= h($c['nome']??'Curso removido') ?></td><td><?= h($m['data_matricula']??'') ?></td><td><?= h($m['status']??'') ?></td><td><a class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancelar matrícula?')" href="?excluir=<?= h((string)$m['_id']) ?>">Cancelar</a></td></tr><?php endforeach; ?>
<?php if(!$lista): ?><tr><td colspan="5" class="text-secondary">Nenhuma matrícula cadastrada.</td></tr><?php endif; ?></tbody></table></div></div></div></main></body></html>
