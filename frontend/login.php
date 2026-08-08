<?php
$erroMensagem = '';

if (isset($_GET['erro'])) {
    $mensagensDeErro = [
        'campo_vazio' => 'Preencha todos os campos.',
        'credenciais_invalidas' => 'E-mail/nome ou senha incorretos.',
    ];

    $erroMensagem = $mensagensDeErro[$_GET['erro']] ?? 'Ocorreu um erro. Tente novamente.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">

    <title>Stanza</title>
</head>
<body>

<div class="wblock">

<h1>Conectar</h1>

<?php if (!empty($erroMensagem)): ?>
    <div class="erro">
        <?= htmlspecialchars($erroMensagem) ?>
    </div>
<?php endif; ?>


<form action="/stanza/backend-basico/login.php" method="POST">
  
    <label for="username">E-mail/Nome</label>
   
    <input type="text" id="usernameoremail" name="usernameoremail">
   
    <label for="password">Senha</label>
   
    <input type="password" id="password" name="password">
   
   <button type="submit">Entrar</button>

</form> 

<a href="forgottt">Esqueci meu acesso</a>




</div>




</body>
</html>