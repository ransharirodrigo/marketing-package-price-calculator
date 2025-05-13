<!DOCTYPE html>
<html>

<head>
    <title>Proforma Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* margin: 10px; */
            color: #333;
            background-color: #f4f4f4;
            font-size: 0.9em;
        }

        .invoice-container {
            background-color: #fff;
            border-radius: 8px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            /* max-width: 800px; */
            /* margin: 0 auto; */
            height: 100%;
            width: 100% !important;
        }

        .header {
            background-color: #FF5F6D;
            color: #fff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
        }

        .logo {
            font-size: 1.4em;
            font-weight: bold;
            text-align: left;
        }

        .company-address {
            text-align: right;
            font-size: 1em;
        }

        .invoice-details-section {
            display: flex;
            justify-content: space-between;
            /* margin-top: 15px; */
            font-size: 0.8em;
            padding: 10px 15px 0;
        }

        .prepared-for {
            text-align: right;
            margin-top: 10px;
        }

        .prepared-for strong,
        .invoice-number-date strong,
        .account-details-section h3,
        .notes-section h3 {
            font-size: 14px;
        }

        .invoice-number-date {
            text-align: right;
        }

        .invoice-number-date strong,
        .prepared-for strong,
        .account-details-section h3,
        .notes-section h3 {
            color: #FF5F6D;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        .items-table th,
        .items-table td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 1px;
        }

        .items-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            padding: 6px;
        }

        .line-total {
            text-align: right;
        }

        .totals-section {
            text-align: right;
            /* margin-top: 15px; */
            font-size: 0.9em;
        }

        .totals-section p {
            /* margin-bottom: 3px; */
        }

        .totals-section strong {
            font-weight: bold;
        }

        .notes-section,
        .account-details-section,
        .terms-section {
            /* margin-top: 20px; */
            font-size: 0.8em;
            color: #555;
        }

        .section-title {
            color: #7B1FA2;
            font-weight: bold;
            /* margin-bottom: 8px; */
            font-size: 1em;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
           
            <div>
                @if($company_logo)
                <img src="{{  $company_logo }}" alt="Company Logo" style="max-width: 90px; height: auto;">
                @endif
            </div> 
            <div class="logo">{{ $company_name }}<br><small>{{ $company_contact }}</small></div>
            <div class="company-address">
               {{ $company_address }}
            </div>
        </div>

        <div class="invoice-details-section">
            <div class="prepared-for">
                <strong>Prepared For</strong><br>
                {{ $clientName }}<br>
                {{$clientAddress}}<br>
            </div><br>
            <div class="invoice-number-date">
                <strong>Proforma Invoice Number</strong><br>
                {{ $invoiceNumber }}<br><br>
                <strong> Date</strong><br>
                {{ date('d/m/Y') }}
            </div>
        </div>

        <table class="items-table">
            {!! $totalResultHtml !!}
        </table>

        <div class="totals-section">
            <p>Subtotal: <strong>LKR {{ number_format($total, 2) }}</strong></p>
            <p>Tax: <strong>LKR {{ number_format(0.00, 2) }}</strong></p>
            <p><strong>Estimate Total (LKR): LKR {{ number_format($total, 2) }}</strong></p>
        </div>

        <div class="account-details-section">
            <h3 class="section-title">Account Details:</h3>
            <p>ACCOUNT NAME : THE BUSINESS SOLUTIONS</p>
            <p>ACCOUNT NUMBER:1000683057</p>
            <p>BANK : COMMERCIAL BANK</p>
            <p>BRANCH : WATTALA</p>
        </div>

        @if (!empty($invoice_note))
            <div class="notes-section">
                        <h3 class="section-title">Note:</h3>
                        <p>{!! $invoice_note !!}</p>
                    </div>
            @endif
    </div>
</body>

</html>