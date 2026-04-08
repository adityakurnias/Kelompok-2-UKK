<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $transaction->id }} - ATK Store</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 35px; line-height: 45px; color: #333; font-weight: bold; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:last-child { border-top: 2px solid #eee; font-weight: bold; }
        .text-right { text-align: right; }
        .print-btn { background: #2563eb; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-bottom: 20px; display: inline-block; }
        @media print { 
            .invoice-box { box-shadow: none; border: none; padding: 0; margin: 0; max-width: 100%; } 
            .no-print { display: none !important; } 
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-box">
        <div class="no-print" style="text-align: center;">
            <button class="print-btn" onclick="window.print()">Cetak Invoice Sekarang</button>
        </div>

        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                ATK Store
                            </td>
                            <td class="text-right">
                                Invoice #: {{ $transaction->id }}<br>
                                Tanggal: {{ $transaction->created_at->format('d M Y H:i') }}<br>
                                Status: {{ $transaction->status }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Info Pengiriman:</strong><br>
                                {{ $transaction->shipping_name }}<br>
                                {{ $transaction->shipping_phone }}<br>
                                {{ $transaction->shipping_email }}<br>
                                {{ $transaction->shipping_address }}
                            </td>
                            <td class="text-right">
                                <strong>Metode Pembayaran:</strong><br>
                                {{ $transaction->payment_method ?? 'Transfer Bank' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Produk & Kuantitas</td>
                <td class="text-right">Subtotal</td>
            </tr>

            @foreach($transaction->items as $item)
            <tr class="item {{ $loop->last ? 'last' : '' }}">
                <td>{{ $item->product->name ?? 'Produk Terhapus' }} (x{{ $item->quantity }})</td>
                <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td class="text-right">
                   Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </table>
        
        <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #777;">
            Terima kasih telah berbelanja di ATK Store.
        </div>
    </div>
</body>
</html>
