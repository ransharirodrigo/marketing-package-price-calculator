<!DOCTYPE html>
<html>
<head>
    <title>Price Calculation</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            color: #343A40; 
        }
        .header {
            background-color: #FF5F6D; 
            color: white;
            padding: 20px;
            text-align: left;
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #ff4b5a;
            margin-bottom: 10px;
        }
        .content ul {
            list-style-type: none;
            padding: 0;
        }
        .content li {
            margin-bottom: 5px;
        }
        .content strong {
            color: #2c3e50; 
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content th, .content td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .content th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>THE BUSINESS SOLUTIONS</h1>
        <p>ABC ROAD COLOMBO, Sri Lanka</p> 
        <p>12345678</p>
    </div>

    <div class="content">
        <h2>Price Calculation</h2>

        <p><strong>Client Name:</strong> {{ $clientName }}</p>
        <p><strong>Client Address:</strong> {{ $clientAddress }}</p>

        <div id="result">
            {!! $totalResultHtml !!} 
        </div>
    </div>
</body>
</html>