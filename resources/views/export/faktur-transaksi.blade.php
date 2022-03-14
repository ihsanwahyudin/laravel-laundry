<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Faktur Pembayaran</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        .content-header tr,
        .content-header td {
            margin: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        thead {
            /* background: #202020; */
            border: 1px solid #202020;
            color: #202020;
            text-align: left;
        }

        tfoot tr td {
            /* font-weight: bold; */
            font-size: x-small;
        }

        .gray {
            background-color: lightgray;
        }

        h3 {
            text-transform: uppercase;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .mp-0 {
            margin: 0;
            padding: 0;
        }

        .px-1 {
            padding-right: .5rem !important;
            padding-left: .5rem !important;
        }

    </style>
</head>

<body>
    <h3 align="center">Faktur Pembayaran</h3>
    <br />
    <table class="content-header" width="100%" cellpadding="5" cellspacing="0">
        <tr>
            <td width="50%">
                <table class="content-header" cellpadding="5" cellspacing="0">
                    <tr>
                        <td>Status Transaksi</td>
                        <td class="px-1">:</td>
                        <td>{{ $data['status_transaksi'] }}</td>
                    </tr>
                    <tr>
                        <td>Status Pembayaran</td>
                        <td class="px-1">:</td>
                        <td>{{ $data['status_pembayaran'] }}</td>
                    </tr>
                    <tr>
                        <td>Metode Pembayaran</td>
                        <td class="px-1">:</td>
                        <td>{{ $data['metode_pembayaran'] }}</td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table class="content-header" cellpadding="5" cellspacing="0">
                    <tr>
                        <td>No Invoice</td>
                        <td class="px-1">:</td>
                        <td>{{ $data['kode_invoice'] }}</td>
                    </tr>
                    <tr>
                        <td>Nama Member</td>
                        <td class="px-1">:</td>
                        <td>{{ $data['member']['nama'] }}</td>
                    </tr>
                    <tr>
                        <td>No Telepon</td>
                        <td class="px-1">:</td>
                        <td>{{ $data['member']['tlp'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br />
    <div style="width: 100%; border: 1px solid #202020; padding-top: .5rem; padding-bottom: .5rem; text-align: center;">
        <small style="display: block">Tanggal Bayar - Tanggal Selesai</small>
        <small><strong class="mp-0">{{ $data['tgl_bayar'] }} sd {{ $data['batas_waktu'] }}</strong></small>
    </div>
    <br />
    <h5 class="text-uppercase" style="margin: 0" align="left">Data Paket</h5>
    <table width="100%" cellpadding="5" cellspacing="0" class="mp-0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Paket</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>QTY</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            @foreach ($data['detailTransaksi'] as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['paket']['nama_paket'] }}</td>
                    <td>{{ $item['paket']['jenis'] }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>{{ $item['qty'] }}x</td>
                    <td align="left">Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            @if ($data['status_pembayaran'] === 'lunas')
                <tr>
                    <td colspan="5" align="right">Biaya Tambahan</td>
                    <td align="left">Rp {{ number_format($data['pembayaran']['biaya_tambahan'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Diskon</td>
                    <td align="left">{{ $data['pembayaran']['diskon'] }}%</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Pajak</td>
                    <td align="left">{{ $data['pembayaran']['pajak'] }}%</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Total Pembayaran</td>
                    <td align="left">Rp {{ number_format($data['pembayaran']['total_pembayaran'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Total Bayar</td>
                    <td align="left">Rp {{ number_format($data['pembayaran']['total_bayar'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Kembalian</td>
                    <td align="left">Rp {{ number_format(abs((int)$data['pembayaran']['total_pembayaran'] - (int)$data['pembayaran']['total_bayar']), 0, ',', '.') }}</td>
                </tr>
            @else
                <tr>
                    <th colspan="6" align="center">Pembayaran Belum Lunas</th>
                </tr>
            @endif
        </tfoot>
    </table>
</body>

</html>
