<!DOCTYPE html>
<html>

<head>
    <title>Pesan Baru dari Formulir Kontak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .header {
            background: #f4f4f4;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .footer {
            background: #f4f4f4;
            padding: 10px 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Pesan Baru dari Formulir Kontak Website GKS Jemaat Reda Pada</h2>
        </div>
        <div class="content">
            <p>Anda menerima pesan baru dari formulir kontak website gereja. Berikut adalah detailnya:</p>
            <p><strong>Nama:</strong> {{ $userName }}</p>
            <p><strong>Email:</strong> {{ $userEmail }}</p>
            <p><strong>Pesan:</strong></p>
            <p style="white-space: pre-wrap; background: #eef; padding: 10px; border-left: 3px solid #ccc;">
                {{ $userMessage }}</p>
        </div>
        <div class="footer">
            <p>Pesan ini dikirim secara otomatis dari website GKS Jemaat Reda Pada.</p>
        </div>
    </div>
</body>

</html>
