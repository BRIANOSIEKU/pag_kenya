<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial; font-size: 13px; }
        .header { text-align:center; margin-bottom:20px; }
    </style>
</head>
<body>

<div class="header">
    <h2>PASTORAL TRANSFER LETTER</h2>
</div>

<p><strong>Pastor:</strong> {{ $transfer->pastor->name ?? '' }}</p>

<p><strong>From:</strong>
    {{ $transfer->fromDistrict->name ?? '' }} /
    {{ $transfer->fromAssembly->name ?? '' }}
</p>

<p><strong>To:</strong>
    {{ $transfer->toDistrict->name ?? '' }} /
    {{ $transfer->toAssembly->name ?? '' }}
</p>

</body>
</html>