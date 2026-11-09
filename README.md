# Atividade 3 — MongoDB e PHP

Sistema acadêmico com cadastro de estudantes, cursos e matrículas.

## Funcionalidades
- Cadastro, listagem, edição e exclusão de estudantes.
- Estudante com dados pessoais e endereço estruturado (rua, número, bairro, cidade, estado e CEP).
- Cadastro, listagem, edição e exclusão de cursos.
- Matrícula de vários estudantes em cursos diferentes (relacionamento muitos-para-muitos).
- Exclusão de matrícula.
- Interface com Bootstrap.

## Estrutura do banco
- `estudantes`: dados pessoais e endereço embutido no documento do estudante.
- `cursos`: dados dos cursos.
- `matriculas`: coleção separada que relaciona `estudante_id` e `curso_id`.

O endereço é um subdocumento do estudante; a relação entre estudantes e cursos é feita na coleção `matriculas`, não por documentos embutidos.

## Requisitos
- PHP 8.1 ou superior.
- Composer.
- MongoDB local ou MongoDB Atlas.
- Extensão `mongodb` habilitada no PHP.

## Configuração
1. Instale a extensão MongoDB para PHP e o Composer.
2. Na pasta do projeto, execute:
   ```bash
   composer install
   ```
3. Configure a variável de ambiente `MONGODB_URI` com a conexão do seu MongoDB Atlas ou deixe o padrão local (`mongodb://127.0.0.1:27017`).
4. Inicie o servidor:
   ```bash
   php -S localhost:8000
   ```
5. Acesse `http://localhost:8000`.

## MongoDB Atlas
Crie um cluster gratuito, um usuário de banco e libere seu IP em Network Access. Copie a connection string e configure `MONGODB_URI`. Não publique sua senha ou string privada no GitHub.

## Autor
Enzo Zanelato
