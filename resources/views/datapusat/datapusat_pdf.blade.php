<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Data Pusat Barang</title>
    <style>
        /* Font DejaVu Sans supaya support UTF-8 */
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 20px;
        }

        h3 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        thead tr {
            background-color: #3498db;
            color: white;
            text-align: center;
            font-weight: 600;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 12px;
        }

        tbody tr:nth-child(even) {
            background-color: #f7f9fc;
        }

        tbody tr:hover {
            background-color: #d6e9fb;
        }

        td {
            text-align: center;
        }
    </style>
</head>
<body>

    
    <h3>Data Pusat Barang</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tool</th>
                <th>Nama Tool</th>
                <th>Deskripsi</th>
                <th>Stok</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $barang)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $barang->kode_tool }}</td>
                <td>{{ $barang->nama_tool }}</td>
                <td>{{ $barang->deskripsi }}</td>
                <td>{{ $barang->stok }}</td>
                <td>{{ $barang->lokasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
    </div>
</body>
</html>