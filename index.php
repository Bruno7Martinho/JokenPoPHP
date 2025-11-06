<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo do Jokempô</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="container">
        <h1>Joken Po</h1>
        <p class="subtitle">Seja bem-vindo, escolha pedra papel ou tesoura e venha se divertir com esse projeto</p>

        <?php
        // Definir as opções do jogo (movido para o início)
        $opcoes = [
            'pedra' => [
                'nome' => 'Pedra',
                'imagem' => 'assets/img/pedra.png'
            ],
            'papel' => [
                'nome' => 'Papel',
                'imagem' => 'assets/img/papel.png'
            ],
            'tesoura' => [
                'nome' => 'Tesoura',
                'imagem' => 'assets/img/tesoura.png'
            ]
        ];

        // Inicializar variáveis
        $player_choice_key = '';
        $computer_choice_key = '';
        $player_choice = [];
        $computer_choice = [];

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_choice'])) {
            $player_choice_key = $_POST['player_choice'];
            $player_choice = $opcoes[$player_choice_key];

            
            $computer_choice_key = array_rand($opcoes);
            $computer_choice = $opcoes[$computer_choice_key];
        }
        ?>

        <form method="POST" action="">
            <div class="game-area">
                <div class="player">
                    <h2>Sua Escolha</h2>
                    <div class="choices">
                        <div class="choice" data-value="pedra">
                            <img src="assets/img/pedra.png" alt="Pedra">
                        </div>
                        <div class="choice" data-value="papel">
                            <img src="assets/img/papel.png" alt="Papel">
                        </div>
                        <div class="choice" data-value="tesoura">
                            <img src="assets/img/tesoura.png" alt="Tesoura">
                        </div>
                    </div>
                    <input type="hidden" name="player_choice" id="player_choice" value="">
                </div>

                <div class="vs">VS</div>

                <div class="computer">
                    <h2>Computador</h2>
                    <div class="selection-display">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_choice'])) {
                           
                            echo '<img src="' . $computer_choice['imagem'] . '" alt="' . $computer_choice['nome'] . '" class="computer-choice">';
                        } else {
                            echo '<p>Escolha uma opção para começar</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="play-btn">Jogar!</button>
        </form>

        <?php
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_choice'])) {
            
            $resultado = '';
            if ($player_choice_key === $computer_choice_key) {
                $resultado = 'Empate!';
                $cor_resultado = '#FFA500';
            } elseif (
                ($player_choice_key === 'pedra' && $computer_choice_key === 'tesoura') ||
                ($player_choice_key === 'papel' && $computer_choice_key === 'pedra') ||
                ($player_choice_key === 'tesoura' && $computer_choice_key === 'papel')
            ) {
                $resultado = 'Você venceu!';
                $cor_resultado = '#4CAF50';
            } else {
                $resultado = 'Computador venceu!';
                $cor_resultado = '#F44336';
            }

           
            echo '<div class="result">';
            echo '<h3>Resultado</h3>';
            echo '<p><strong>Sua escolha:</strong> ' . $player_choice['nome'] . '</p>';
            echo '<p><strong>Escolha do computador:</strong> ' . $computer_choice['nome'] . '</p>';
            echo '<p class="winner" style="color: ' . $cor_resultado . '">' . $resultado . '</p>';
            echo '</div>';
        }
        ?>

        <div class="rules">
            <h3>Regras do Jogo</h3>
            <ul>
                <li><strong>Pedra</strong> quebra <strong>Tesoura</strong></li>
                <li><strong>Tesoura</strong> corta <strong>Papel</strong></li>
                <li><strong>Papel</strong> cobre <strong>Pedra</strong></li>
                <li>Escolhas iguais resultam em <strong>Empate</strong></li>
            </ul>
        </div>
    </div>

    <script>
        // Adicionar interatividade às escolhas
        document.addEventListener('DOMContentLoaded', function() {
            const choices = document.querySelectorAll('.choice');
            const playerChoiceInput = document.getElementById('player_choice');

            choices.forEach(choice => {
                choice.addEventListener('click', function() {
                    // Remover a classe 'selected' de todas as opções
                    choices.forEach(c => c.classList.remove('selected'));

                    // Adicionar a classe 'selected' à opção clicada
                    this.classList.add('selected');

                    // Definir o valor do input hidden
                    playerChoiceInput.value = this.getAttribute('data-value');
                });
            });

            // Se o formulário foi enviado, marcar a escolha do jogador
            <?php if (isset($player_choice_key) && !empty($player_choice_key)): ?>
                const selectedChoice = document.querySelector(`.choice[data-value="<?php echo $player_choice_key; ?>"]`);
                if (selectedChoice) {
                    selectedChoice.classList.add('selected');
                }
            <?php endif; ?>
        });
    </script>
</body>

</html>