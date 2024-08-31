<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Service</title>
    <style>
        /* Tambahkan gaya untuk format nota di sini */
        @media print {
        @page {
            margin: 0;
        }
        body {
            margin: 1cm;
        }   
        }
    </style>
</head>
<body style="display: flex; flex-direction: column; justify-content: center; align-items: start; padding-top: 2rem" onload="window.print();">
    <img src="{{asset('images/brand.png')}}" style="width: 4rem" alt="">
    <div style="border: 1px solid black; width: 100%; height: 1px; margin-top: 1rem" ></div>
    <h2>Nota untuk Task #{{ $task->code }}</h2>
    <p>Nama Klien: {{ $task->client_name }}</p>
    <p>Nomor Telepon: {{ $task->client_phone }}</p>
    <p>Barang : {{ $task->title }}</p>
    <p>Service : {{ $task->description }}</p>
    <p>Kode service : {{ $task->code }}</p>
    <p>Tanggal Antar : {{ $task->created_at->format('d F Y') }}</p>
    <div style="border: 1px solid black; width: 100%; height: 1px;" ></div>
    <p>Cek servicean anda pada : <a href="https://it-support-service.vercel.app/{{$task->code}}">https://it-support-service.vercel.app/{{$task->code}}</a>  </p>
    <div style="border: 1px solid black; width: 100%; height: 1px; margin: 1rem 0" ></div>
    <div style="display: flex; width: 100%; flex-direction: row; align-items: center; justify-content: space-between">
        <div>
            <p>Client</p>
            <p style="margin-top: 4rem">_ _ _ _ _ _ _ _ _ _ _ _</p>
        </div>
        <div>
            <p>Pihak Toko</p>
            <p style="margin-top: 4rem">_ _ _ _ _ _ _ _ _ _ _ _</p>
        </div>
    </div>



    <!-- Tambahkan informasi lain yang dibutuhkan -->
</body>
</html>
