<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaStore - Início</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <h1>MangaStore</h1>
        <p>Seu universo de mangás em um só lugar!</p>
    </header>

    <nav>
        <a href="index.php">Início</a>
        <a href="pages/mangas.html">Mangás</a>
        <a href="PHP/contato.php">Contato</a>
        <button id="theme-toggle" class="theme-toggle-btn">Modo Escuro</button>
    </nav>

    <main>
        <section class="hero" style="text-align: center; margin-bottom: 30px;">
            <h2>Bem-vindo à MangaStore</h2>
            <p>Os melhores mangás, lançamentos e clássicos entregues na sua casa!</p>
        </section>

        <section>
            <h2>Destaques da Semana</h2>
        </section>

        <section class="catalogo">
            <div class="card">
                <img src="img/onepiece.webp" alt="Capa do mangá One Piece">
                <h3>One Piece</h3>
                <p><strong>Autor:</strong> Eiichiro Oda</p>
                <strong>R$ 29,90</strong>
                <a href="pages/one-piece.html" class="btn-comprar-card">Comprar</a>
            </div>
            <div class="card">
                <img src="img/naruto.webp" alt="Capa do mangá Naruto">
                <h3>Naruto</h3>
                <p><strong>Autor:</strong> Masashi Kishimoto</p>
                <strong>R$ 27,90</strong>
                <a href="pages/naruto.html" class="btn-comprar-card">Comprar</a>
            </div>
            <div class="card">
                <img src="img/jujutsukaisen.webp" alt="Capa do mangá Jujutsu Kaisen">
                <h3>Jujutsu Kaisen</h3>
                <p><strong>Autor:</strong> Gege Akutami</p>
                <strong>R$ 32,90</strong>
                <a href="pages/jujutsu-kaisen.html" class="btn-comprar-card">Comprar</a>
            </div>
        </section>
    </main>

    <footer style="text-align: center; padding: 20px; margin-top: 40px; color: #666;">
        <p>&copy; <?= date('Y') ?> MangaStore. Todos os direitos reservados.</p>
    </footer>

    <script src="JS/script.js"></script>
</body>
</html>