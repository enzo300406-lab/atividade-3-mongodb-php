<?php
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

$mongoUri = getenv('MONGODB_URI') ?: 'mongodb://127.0.0.1:27017';
$client = new Client($mongoUri);
$db = $client->selectDatabase('atividade3');

$estudantes = $db->estudantes;
$cursos = $db->cursos;
$matriculas = $db->matriculas;
