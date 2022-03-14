<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<title>Laporan Transaksi</title>

	<style type="text/css">
		* {
			font-family: Verdana, Arial, sans-serif;
		}

		table {
			font-size: x-small;
		}

		thead {
			/* background: #202020; */
			border: 1px solid #202020;
			color: #202020;
			text-align: left;
		}

		tfoot tr td {
			font-weight: bold;
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

	</style>
</head>

<body>
	<h3 align="center">Laporan Transaksi</h3>

	<br />
	<br />
	<h5 class="text-uppercase" style="margin: 0" align="left">Data Laporan</h5>
	<table width="100%" cellpadding="5" cellspacing="0">
		<thead>
            <tr>
                <th>No</th>
                <th align="left">Kode Invoice</th>
                <th align="left">Nama Member</th>
                <th align="left">Tanggal Transaksi</th>
                <th align="left">Status Pembayaran</th>
                <th align="left">Pemasukan</th>
            </tr>
        </thead>
		<tbody>
        @php
            $totalPemasukan = 0;
        @endphp
        @foreach($data as $key => $item)
            @php
                $totalPemasukan += $item->status_pembayaran === 'lunas' ? $item->pembayaran->total_pembayaran : 0;
            @endphp
            <tr>
                <td align="center">{{ $key + 1 }}</td>
                <td>{{ $item->kode_invoice }}</td>
                <td>{{ $item->member->nama }}</td>
                <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                <td>{{ $item->status_pembayaran }}</td>
                <td>Rp {{ ($item->status_pembayaran === 'lunas' ? number_format($item->pembayaran->total_pembayaran, 0, ',', '.') : 0) }}</td>
            </tr>
        @endforeach
        </tbody>
        @php
            $totalPemasukan = number_format($totalPemasukan, 0, ',', '.');
        @endphp
		<tfoot style="border-top: 1px solid black">
            <tr>
                <th colspan="5">Total Pemasukan</th>
                <th align="left">{{ $totalPemasukan }}</th>
            </tr>
		</tfoot>
	</table>
</body>

</html>
