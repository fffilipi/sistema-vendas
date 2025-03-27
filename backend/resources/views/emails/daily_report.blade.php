<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Diário de Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        p {
            margin: 10px 0;
        }
        .highlight {
            font-weight: bold;
            color: #4CAF50;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>📊 Olá Administrador,</h1>
    <p>Segue abaixo o seu relatório diário de vendas:</p>
    <p><strong>📅 Data:</strong> {{ $today }}</p>
    <p>
        @if ($totalSales == 0)
            🚫 <span class="highlight">Sua loja não teve vendas hoje.</span>
        @else
            ✅ <span class="highlight">Sua loja teve {{ $totalSales }} vendas.</span><br>
            💰 Valor total vendido foi de <strong>R$ {{ number_format($valueTotalSales, 2, ',', '.') }}</strong>
        @endif
    </p>
    <div class="footer">
        <p>Atenciosamente,</p>
        <p><strong>Equipe Sistema de Vendas</strong> 🚀</p>
        <p>📧 Caso tenha dúvidas, entre em contato conosco!</p>
    </div>
</body>
</html>
