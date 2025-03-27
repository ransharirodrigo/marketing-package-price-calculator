<!DOCTYPE html>
<html>
<head>
    <title>Price Calculation</title>
    <style>
        body { font-family: sans-serif; }
        h1, h2, h3, h4, h5, h6 { margin-bottom: 0.5em; }
        p { margin-bottom: 1em; }
        ul { margin-bottom: 1em; }
    </style>
</head>
<body>
    <h1>Price Calculation</h1>

    <p><strong>Client Name:</strong> {{ $clientName }}</p>
    <p><strong>Client Address:</strong> {{ $clientAddress }}</p>

    <div id="result">
        {!! $totalResultHtml !!}
    </div>
</body>
</html>