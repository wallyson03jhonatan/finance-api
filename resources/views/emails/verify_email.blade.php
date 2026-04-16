<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; }
        .card { background: #fff; max-width: 480px; margin: 0 auto; padding: 32px; border-radius: 8px; }
        .code { font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #111; text-align: center; margin: 24px 0; }
        .footer { font-size: 12px; color: #999; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Confirme seu e-mail</h2>
        <p>Use o código abaixo para verificar seu e-mail. Ele expira em <strong>15 minutos</strong>.</p>
        <div class="code">{{ $code }}</div>
        <p>Se você não solicitou isso, ignore este e-mail.</p>
        <div class="footer">Finance App</div>
    </div>
</body>
</html>