<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Telur Berkurang</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            color: #555;
        }

        .aktivasi {
            display: block;
            width: 250px;
            max-width: 100%;
            background: #0A7EF3;
            font-weight: bold;
            font-size: 16px;

            outline: 0px;
            text-decoration: none;
            border-radius: 50px;
            margin: 30px auto;
            text-align: center;
            padding: 15px;
            text-transform: capitalize;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h3 align="center">Laporan Telur</h3>
        <hr>
        <table width="100%">
            <tr>
            </tr>
            <tr>
                <td>
                    <center><a style="color: #fff;"
                            href="https://agrilaras.putrirembulan.com/export/telur?tgl1={{ $tgl1 }}&tgl2={{ $tgl2 }}"
                            class="aktivasi">Cek Data!</a></center>
                </td>
            </tr>
            <hr>
            <tr>
                <td>
                    <p align="center">Email dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini.</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
