<!DOCTYPE html>
<html>

<head>
    <title>INVOICE</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            color: #333;
            background-color: white;
        }

        .invoice-container {
            /* max-width: 800px;
            margin: 30px auto;
            background-color: #fff; */
            /* border: 1px solid #ddd; */
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            /* padding: 30px; */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 2em;
            color: #FF5F6D;
            font-weight: bold;
        }

        .company-info {
            text-align: right;
            font-size: 0.9em;
            color: #555;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #555;
        }

        .client-info {
            text-align: left;
        }

        .invoice-number-date {
            text-align: right;
        }

        .invoice-number-date strong {
            color: #333;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .items-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            color: #333;
        }

        .total {
            text-align: right;
            font-size: 1.1em;
            margin-top: 20px;
        }

        .total strong {
            color: #FF5F6D;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.8em;
        }

        .accent-color {
            color: #FF5F6D;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div class="logo">THE <span class="accent-color">BUSINESS</span> SOLUTIONS</div>
            <div class="company-info">
                <p>ABC ROAD</p>
                <p>COLOMBO, Sri Lanka</p>
                <p>Tel: 12345678</p>
            </div>
        </div>

        <div class="invoice-details">
            <div class="client-info">
                <strong>Bill To:</strong>
                <p>{{ $clientName }}</p>
                <p>{{ $clientAddress }}</p>
            </div>
            <div class="invoice-number-date">
                <strong>Invoice #:</strong> {{ $invoiceNumber }}<br> <strong>Date:</strong> {{ date('Y-m-d') }}
            </div>
        </div>

        {!! $totalResultHtml !!}

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>&copy; 2025 THE BUSINESS SOLUTIONS</p>
        </div>
    </div>
</body>

</html>