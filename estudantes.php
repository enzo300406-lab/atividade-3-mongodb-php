<?php
require_once 'config.php';
use MongoDB\BSON\ObjectId;

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => trim($_POST['nome'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telefone' => trim($_POST['telefone'] ?? ''),
        'cpf' => trim($_POST['cpf'] ?? ''),
        'data_nascimento' => trim($_POST['data_nascimento'] ?? ''),
        'endereco' => [
            'rua' => trim($_POST['rua'] ?? ''),
            'numero' => trim($_POST['numero'] ?? ''),
            'bairro' => trim($_POST['bairro'] ?? ''),
            'cidade' => trim($_POST['cidade'] ?? ''),
            'estado' => trim($_POST['estado'] ?? ''),
            'cep' => trim($_POST['cep'] ?? '')
        ]
    ];
    if ($dados['nome'] === '' || $dados['email'] === '') {
        $erro = 'Nome e e-mail são obrigatórios.';
    } else {
        if (!empty($_POST['id'])) {
            $estudantes->updateOne(['_id' => new ObjectId($_POST['id'])], ['$set' => $dados]);
        } else {
            $estudantes->insertOne($dados);
        }
        header('Location: estudantes.php'); exit;
    }
}
if (isset($_GET['excluir'])) {
    $id = new ObjectId($_GET['excluir']);
    $estudantes->deleteOne(['_id' => $id]);
    $matriculas->deleteMany(['estudante_id' => $id]);
    header('Location: estudantes.php'); exit;
}
$editar = isset($_GET['editar']) ? $estudantes->findOne(['_id' => new ObjectId($_GET['editar'])]) : null;
$lista = $estudantes->find([], ['sort' => ['nome' => 1]])->toArray();
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Estudantes</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="style.css" rel="stylesheet"></head><body>
<nav class="navbar navbar-dark bg-primary"><div class="container"><a class="navbar-brand" href="index.php">Portal Acadêmico</a></div></nav>
<main class="container py-4"><a href="index.php" class="text-decoration-none">← Início</a><h1 class="mt-3 mb-4">Estudantes</h1>
<div class="card mb-4"><div class="card-body"><h5><?= $editar ? 'Editar estudante' : 'Novo estudante' ?></h5>
<?php if ($erro): ?><div class="alert alert-danger"><?= h($erro) ?></div><?php endif; ?>
<form method="post" class="row g-3">
<input type="hidden" name="id" value="<?= $editar ? h((string)$editar['_id']) : '' ?>">
<div class="col-md-6"><label class="form-label">Nome *</label><input class="form-control" name="nome" required value="<?= h($editar['nome'] ?? '') ?>"></div>
<div class="col-md-6"><label class="form-label">E-mail *</label><input type="email" class="form-control" name="email" required value="<?= h($editar['email'] ?? '') ?>"></div>
<div class="col-md-4"><label class="form-label">Telefone</label><input class="form-control" name="telefone" value="<?= h($editar['telefone'] ?? '') ?>"></div>
<div class="col-md-4"><label class="form-label">CPF</label><input class="form-control" name="cpf" value="<?= h($editar['cpf'] ?? '') ?>"></div>
<div class="col-md-4"><label class="form-label">Data de nascimento</label><input type="date" class="form-control" name="data_nascimento" value="<?= h($editar['data_nascimento'] ?? '') ?>"></div>
<div class="col-12"><hr><strong>Endereço</strong></div>
<div class="col-md-6"><label class="form-label">Rua</label><input class="form-control" name="rua" value="<?= h($editar['endereco']['rua'] ?? '') ?>"></div>
<div class="col-md-2"><label class="form-label">Número</label><input class="form-control" name="numero" value="<?= h($editar['endereco']['numero'] ?? '') ?>"></div>
<div class="col-md-4"><label class="form-label">Bairro</label><input class="form-control" name="bairro" value="<?= h($editar['endereco']['bairro'] ?? '') ?>"></div>
<div class="col-md-5"><label class="form-label">Cidade</label><input class="form-control" name="cidade" value="<?= h($editar['endereco']['cidade'] ?? '') ?>"></div>
<div class="col-md-3"><label class="form-label">Estado</label><input class="form-control" maxlength="2" name="estado" value="<?= h($editar['endereco']['estado'] ?? '') ?>"></div>
<div class="col-md-4"><label class="form-label">CEP</label><input class="form-control" name="cep" value="<?= h($editar['endereco']['cep'] ?? '') ?>"></div>
<div class="col-12"><button class="btn btn-primary">Salvar estudante</button><?php if($editar): ?> <a class="btn btn-outline-secondary" href="estudantes.php">Cancelar</a><?php endif; ?></div>
</form></div></div>
<div class="card"><div class="card-body"><h5>Estudantes cadastrados</h5><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Nome</th><th>E-mail</th><th>Cidade</th><th>Ações</th></tr></thead><tbody>
<?php foreach($lista as $e): ?><tr><td><?= h($e['nome'] ?? '') ?></td><td><?= h($e['email'] ?? '') ?></td><td><?= h($e['endereco']['cidade'] ?? '') ?></td><td><a class="btn btn-sm btn-outline-primary" href="?editar=<?= h((string)$e['_id']) ?>">Editar</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este estudante?')" href="?excluir=<?= h((string)$e['_id']) ?>">Excluir</a></td></tr><?php endforeach; ?>
<?php if(!$lista): ?><tr><td colspan="4" class="text-secondary">Nenhum estudante cadastrado.</td></tr><?php endif; ?>
</tbody></table></div></div></div></main></body></html>
