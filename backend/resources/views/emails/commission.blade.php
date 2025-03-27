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
    <h1>📊 Olá {{ $name }},</h1>
    <p>Segue abaixo o seu relatório diário de vendas:</p>
    <p><strong>📅 Data:</strong> {{ $today }}</p>
    <p><strong>🛒 Total de vendas:</strong> {{ $totalSales }}</p>
    <p><strong>💰 Valor total em vendas realizadas hoje:</strong> <strong>R$ {{ number_format($valueTotalSales, 2, ',', '.') }}</strong></p>
    <p><strong>🤑 Comissão a receber:</strong> <strong>R$ {{ number_format($commission, 2, ',', '.') }}</strong></p>
    <div class="footer">
        <p>Atenciosamente,</p>
        <p><strong>Equipe Sistema de Vendas</strong> 🚀</p>
        <p>📧 Caso tenha dúvidas, entre em contato conosco!</p>
    </div>
</body>
</html>
