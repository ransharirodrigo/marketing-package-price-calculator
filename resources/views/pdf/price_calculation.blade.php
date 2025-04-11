<!DOCTYPE html>
<html>

<head>
    <title>INVOICE</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 30px;
            color: #333;
            background-color: #f4f4f4;
        }

        .invoice-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background-color: #7B1FA2;
            color: #fff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .company-address {
            text-align: right;
            font-size: 0.9em;
        }

        .invoice-details-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .prepared-for {
            text-align: left;
        }

        .invoice-number-date {
            text-align: right;
        }

        .invoice-number-date strong {
            color: #7B1FA2;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .items-table th,
        .items-table td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .items-table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .line-total {
            text-align: right;
        }

        .totals-section {
            text-align: right;
            margin-top: 20px;
        }

        .totals-section p {
            margin-bottom: 5px;
        }

        .totals-section strong {
            font-weight: bold;
        }

        .notes-section,
        .account-details-section,
        .terms-section {
            margin-top: 30px;
            font-size: 0.9em;
            color: #555;
        }

        .section-title {
            color: #7B1FA2;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div class="logo">AK Events And Production<br><small>(77) 788 6859</small></div>
            <div class="company-address">
                4A, Kuda Edanda Road,<br>
                Wattala 11300
            </div>
        </div>

        <div class="invoice-details-section">
            <div class="prepared-for">
                <strong>Prepared For</strong><br>
                The Accountants<br>
                Lanka Hospitals<br>
                578 Elvitigala Mawatha,<br>
                Colombo 00500
            </div>
            <div class="invoice-number-date">
                <strong>Invoice Number</strong><br>
                {{ $invoiceNumber }}<br><br>
                <strong>Invoice Date</strong><br>
                {{ date('d/m/Y') }}
            </div>
        </div>

        <table class="items-table">
                {!! $totalResultHtml !!}
        </table>

        <div class="totals-section">
            <p>Subtotal: <strong>LKR {{ number_format(160000.00, 2) }}</strong></p>
            <p>Tax: <strong>LKR {{ number_format(0.00, 2) }}</strong></p>
            <p><strong>Estimate Total (LKR): LKR {{ number_format(160000.00, 2) }}</strong></p>
        </div>

        <div class="notes-section">
            <h3 class="section-title">Notes</h3>
            <p>150th Heart Surgery Celebration- Senthil Kumaran's Relief fund</p>
            <p>Price and terms are negotiable upon confirmation.</p>
        </div>

        <div class="account-details-section">
            <h3 class="section-title">Account Details:</h3>
            <p>ACCOUNT NAME : K. Arulnathan</p>
            <p>ACCOUNT NUMBER: 87355135</p>
            <p>Bank : BANK OF CEYLON</p>
            <p>Branch : KOTAHENA</p>
        </div>

        <div class="terms-section">
            <h3 class="section-title">Terms</h3>
            <p>60% Advance with order confirmation</p>
        </div>
    </div>
</body>

</html>