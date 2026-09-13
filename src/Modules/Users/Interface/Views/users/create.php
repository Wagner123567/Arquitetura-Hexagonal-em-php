<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Criar Usuário</title>
</head>
<body>
<h1>Criar Usuário</h1>
<form method="POST" action="/users">
    <label>Email: <input type="email" name="email" required></label><br><br>
    <label>Nome: <input type="text" name="name" required></label><br><br>
    <button type="submit">Salvar</button>
</form>
<p><a href="/users/view">Voltar para lista</a></p>
</body>
</html>
