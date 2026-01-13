<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>KTA {{ $player->name }}</title>

<style>
@page {
    size: 105mm 148mm;
    margin: 0;
}

body {
    width: 105mm;
    height: 148mm;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f8fafc;
}

.kta {
    width: 100%;
    height: 100%;
    padding: 10mm;
    box-sizing: border-box;
    border: 3px solid #0f4fa8;
    position: relative;
}

/* Header */
.header {
    text-align: center;
}

.header img {
    height: 35px;
}

.header h1 {
    font-size: 14px;
    margin: 4px 0 0;
    color: #0f4fa8;
}

.header .posisi {
    font-size: 11px;
    font-weight: bold;
}

/* Foto */
.photo {
    margin: 8mm auto 5mm;
    width: 30mm;
    height: 40mm;
    border: 2px solid #0f4fa8;
    overflow: hidden;
}

.photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Data */
.data {
    font-size: 11px;
}

.data .row {
    margin-bottom: 4px;
}

.data .label {
    font-weight: bold;
}

/* Footer */
.footer {
    position: absolute;
    bottom: 8mm;
    width: calc(100% - 20mm);
    text-align: center;
    font-size: 10px;
    color: #555;
}
</style>
</head>
<body>

@php
$posisiMap = [
   'GK' => 'Goal Keeper',
   'DF' => 'Defender',
   'MF' => 'Midfielder',
   'FW' => 'Forward',
];
@endphp

<div class="kta">
    <div class="header">
        <img src="{{ public_path('assets/logo-assbi.png') }}">
        <h1>ASSBI Kab. Kebumen</h1>
        <div class="posisi">{{ $posisiMap[$player->position] ?? $player->position }}</div>
    </div>

    <div class="photo">
        @if($player->photo)
            <img src="{{ public_path('storage/'.$player->photo) }}">
        @endif
    </div>

    <div class="data">
        <div class="row">
            <span class="label">Nama:</span> {{ $player->name }}
        </div>
        <div class="row">
            <span class="label">TTL:</span>
            {{ $player->birth_place }},
            {{ \Carbon\Carbon::parse($player->birth_date)->format('d M Y') }}
        </div>
        <div class="row">
            <span class="label">SSB:</span> {{ $player->club->name }}
        </div>
        <div class="row" style="font-size:10px; color:#444;">
            No. KTA: {{ $player->kta_number }}
        </div>
    </div>

    <div class="footer">
        www.assbi-kebumen.id
    </div>
</div>

</body>
</html>
