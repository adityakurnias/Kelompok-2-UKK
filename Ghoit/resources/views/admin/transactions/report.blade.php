<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan ATK Store</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 20px; color: #333; font-size: 12px; }
        .report-header { text-align: center; margin-bottom: 30px; }
        .report-header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .report-header p { margin: 5px 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        table th { background-color: #f8f9fa; font-weight: bold; text-transform: uppercase; font-size: 11px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .print-btn { background: #111827; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-bottom: 20px; display: inline-block; }
        @media print { 
            @page { size: landscape; }
            .no-print { display: none !important; } 
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    @if(!request()->has('pdf'))
    <div class="no-print" style="text-align: center;">
        <button class="print-btn" onclick="window.print()">Cetak Laporan Sekarang</button>
    </div>
    @endif

    <div class="report-header">
        <h1>Laporan Penjualan ATK Ghoits</h1>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelanggan</th>
                <th width="25%">Barang Pembelian</th>
                <th width="15%">Metode</th>
                <th width="10%">Status</th>
                <th width="10%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($transactions as $transaction)
            <tr>
                <td class="text-center">#{{ $transaction->id }}</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <strong>{{ $transaction->shipping_name }}</strong><br>
                    {{ $transaction->shipping_phone }}
                </td>
                <td>
                    <ul style="margin:0; padding-left:15px;">
                        @foreach($transaction->items as $item)
                        <li>{{ $item->product->name ?? 'Produk Terhapus' }} ({{ $item->quantity }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $transaction->payment_method ?? 'Transfer' }}</td>
                <td>{{ $transaction->status }}</td>
                <td class="text-right">{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            </tr>
            @php 
                if($transaction->status == 'Selesai') {
                    $grandTotal += $transaction->total_price; 
                }
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">Total Pendapatan (Hanya Status Selesai):</th>
                <th class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>
