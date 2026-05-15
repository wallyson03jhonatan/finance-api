<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; }
        .card { background: #fff; max-width: 480px; margin: 0 auto; padding: 32px; border-radius: 8px; }
        .btn { display: inline-block; margin-top: 24px; padding: 12px 24px; background: #111; color: #fff; text-decoration: none; border-radius: 6px; }
        .footer { font-size: 12px; color: #999; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Redefinição de senha</h2>
        <p>Clique no botão abaixo para redefinir sua senha. O link expira em <strong>15 minutos</strong>.</p>
        <a href="{{ $resetUrl }}" class="btn">Redefinir senha</a>
        <p style="margin-top: 24px;">Se você não solicitou isso, ignore este e-mail.</p>
        <div class="footer">Finance App</div>
    </div>
</body>
</html>
