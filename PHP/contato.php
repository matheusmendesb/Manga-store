```php
<?php
require_once '../Config/conexao.php';

$mensagem_sucesso = '';
$mensagem_erro = '';

$id_edicao = null;
$nome_edicao = '';
$email_edicao = '';
$assunto_edicao = '';
$mensagem_edicao = '';

if (isset($_GET['acao']) && $_GET['acao'] === 'deletar' && !empty($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM contatos WHERE id = :id");
        $stmt->execute([':id' => $_GET['id']]);

        $mensagem_sucesso = "Mensagem excluída com sucesso!";
    } catch (PDOException $e) {
        $mensagem_erro = "Erro ao excluir mensagem.";
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'editar' && !empty($_GET['id'])) {
    $id_edicao = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM contatos WHERE id = :id");
        $stmt->execute([':id' => $id_edicao]);

        $contato = $stmt->fetch();

        if ($contato) {
            $nome_edicao = $contato['nome'];
            $email_edicao = $contato['email'];
            $assunto_edicao = $contato['assunto'];
            $mensagem_edicao = $contato['mensagem'];
        }
    } catch (PDOException $e) {
        $mensagem_erro = "Erro ao carregar mensagem.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $assunto = trim($_POST['assunto'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if (!empty($nome) && !empty($email) && !empty($assunto) && !empty($mensagem)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                if ($id) {
                    $sql = "UPDATE contatos
                            SET nome = :nome,
                                email = :email,
                                assunto = :assunto,
                                mensagem = :mensagem
                            WHERE id = :id";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':nome' => $nome,
                        ':email' => $email,
                        ':assunto' => $assunto,
                        ':mensagem' => $mensagem,
                        ':id' => $id
                    ]);

                    $mensagem_sucesso = "Mensagem atualizada com sucesso!";
                } else {
                    $sql = "INSERT INTO contatos (nome, email, assunto, mensagem)
                            VALUES (:nome, :email, :assunto, :mensagem)";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':nome' => $nome,
                        ':email' => $email,
                        ':assunto' => $assunto,
                        ':mensagem' => $mensagem
                    ]);

                    $mensagem_sucesso = "Mensagem enviada com sucesso! Obrigado pelo contato.";
                }
            } catch (PDOException $e) {
                $mensagem_erro = "Erro ao processar a mensagem no banco de dados.";
            }
        } else {
            $mensagem_erro = "Por favor, informe um e-mail válido.";
        }
    } else {
        $mensagem_erro = "Preencha todos os campos do formulário.";
    }
}

$stmt_listar = $pdo->query("SELECT * FROM contatos ORDER BY created_at DESC LIMIT 5");
$mensagens_enviadas = $stmt_listar->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaStore - Contato</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <header>
        <h1>MangaStore</h1>
        <p>Seu universo de mangás em um só lugar!</p>
    </header>

    <nav>
        <a href="../index.php">Início</a>
        <a href="../pages/mangas.html">Mangás</a>
        <a href="contato.php">Contato</a>
        <button id="theme-toggle" class="theme-toggle-btn">Modo Escuro</button>
    </nav>

    <main>
        <section class="produto-detalhe" style="grid-template-columns: 1fr; max-width: 650px; margin: 0 auto;">
            <div class="produto-info">

                <h2><?= $id_edicao ? 'Editar Mensagem' : 'Fale Conosco' ?></h2>

                <p class="produto-autor">
                    <?= $id_edicao
                        ? 'Altere os campos abaixo para atualizar a mensagem.'
                        : 'Tem alguma dúvida ou sugestão? Envie uma mensagem!' ?>
                </p>

                <?php if ($mensagem_sucesso): ?>
                    <p style="color: #2e7d32; background-color: #e8f5e9; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                        <?= htmlspecialchars($mensagem_sucesso) ?>
                    </p>
                <?php endif; ?>

                <?php if ($mensagem_erro): ?>
                    <p style="color: #c62828; background-color: #ffebee; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                        <?= htmlspecialchars($mensagem_erro) ?>
                    </p>
                <?php endif; ?>

                <form action="contato.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">

                    <?php if ($id_edicao): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($id_edicao) ?>">
                    <?php endif; ?>

                    <div>
                        <label for="nome" style="display: block; margin-bottom: 5px;">Nome:</label>
                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            value="<?= htmlspecialchars($nome_edicao) ?>"
                            required
                            style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;"
                        >
                    </div>

                    <div>
                        <label for="email" style="display: block; margin-bottom: 5px;">E-mail:</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($email_edicao) ?>"
                            required
                            style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;"
                        >
                    </div>

                    <div>
                        <label for="assunto" style="display: block; margin-bottom: 5px;">Assunto:</label>
                        <input
                            type="text"
                            id="assunto"
                            name="assunto"
                            value="<?= htmlspecialchars($assunto_edicao) ?>"
                            required
                            style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;"
                        >
                    </div>

                    <div>
                        <label for="mensagem" style="display: block; margin-bottom: 5px;">Mensagem:</label>
                        <textarea
                            id="mensagem"
                            name="mensagem"
                            rows="4"
                            required
                            style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;"
                        ><?= htmlspecialchars($mensagem_edicao) ?></textarea>
                    </div>

                    <div class="produto-botoes" style="display: flex; gap: 10px;">

                        <button
                            type="submit"
                            class="btn-comprar"
                            style="width: 100%; border: none; cursor: pointer;"
                        >
                            <?= $id_edicao ? 'Salvar Alterações' : 'Enviar Mensagem' ?>
                        </button>

                        <?php if ($id_edicao): ?>
                            <a
                                href="contato.php"
                                style="padding: 12px; background-color: #757575; color: white; text-decoration: none; border-radius: 6px; text-align: center;"
                            >
                                Cancelar
                            </a>
                        <?php endif; ?>

                    </div>
                </form>

                <div class="produto-sinopse" style="margin-top: 30px;">
                    <h3>Últimas Mensagens Recebidas</h3>

                    <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 15px;">

                        <?php if (count($mensagens_enviadas) > 0): ?>

                            <?php foreach ($mensagens_enviadas as $msg): ?>

                                <div style="padding: 12px; border-radius: 8px; border: 1px solid #ddd;">

                                    <strong><?= htmlspecialchars($msg['nome']) ?></strong>

                                    <small style="color: #666;">
                                        (<?= htmlspecialchars($msg['email']) ?>)
                                    </small>

                                    <p style="margin: 5px 0 0 0; font-weight: bold;">
                                        <?= htmlspecialchars($msg['assunto']) ?>
                                    </p>

                                    <p style="margin-top: 5px;">
                                        <?= nl2br(htmlspecialchars($msg['mensagem'])) ?>
                                    </p>

                                    <div style="margin-top: 10px; display: flex; gap: 10px;">

                                        <a
                                            href="contato.php?acao=editar&id=<?= $msg['id'] ?>"
                                            style="color: #1976d2; font-weight: bold; text-decoration: none;"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="contato.php?acao=deletar&id=<?= $msg['id'] ?>"
                                            onclick="return confirm('Tem certeza que deseja excluir esta mensagem?');"
                                            style="color: #d32f2f; font-weight: bold; text-decoration: none;"
                                        >
                                            Excluir
                                        </a>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>
                            <p>Nenhuma mensagem enviada ainda.</p>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </section>
    </main>

    <script src="../JS/script.js"></script>
</body>
</html>
```
