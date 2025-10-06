<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Data Barang Masuk</title>
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

    
    <h3>Data Barang Masuk</h3>

    <table>
        <thead>
            <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kode Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Keluar</th>
            <th>Keterangan</th> 
            </tr>
        </thead>
       <tbody>
            @foreach ($keluar as $i => $barangkeluar)
            <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $barangkeluar->pusat->nama }}</td>
            <td>{{ $barangkeluar->kode_barang }}</td>
            <td>{{ $barangkeluar->jumlah }}</td>
            <td>{{ $barangkeluar->tanggal_keluar }}</td>
            <td>{{ $barangkeluar->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>