<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #10b981;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #10b981;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section table {
            width: 100%;
        }
        .info-section td {
            padding: 5px;
            vertical-align: top;
        }
        .info-box {
            background: #f9fafb;
            padding: 10px;
            border-radius: 5px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #10b981;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th {
            background: #10b981;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .items-table tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin: 5px 0;
        }
        .total-label {
            width: 150px;
            font-weight: bold;
        }
        .total-value {
            width: 150px;
            text-align: right;
        }
        .grand-total {
            background: #10b981;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
        }
        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>Toko Alat Kesehatan</p>
        <p>Email: support@tokoalatkesehatan.com | Phone: (021) 1234-5678</p>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td width="50%">
                    <div class="info-box">
                        <h3>Informasi Invoice</h3>
                        <p><strong>No. Invoice:</strong> #{{ $order->id }}</p>
                        <p><strong>Tanggal Order:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
                        <p><strong>Tanggal Terkirim:</strong> {{ $order->delivered_at ? $order->delivered_at->format('d F Y, H:i') : '-' }}</p>
                        <p><strong>Status:</strong> <span class="status-badge status-delivered">DELIVERED</span></p>
                    </div>
                </td>
                <td width="50%">
                    <div class="info-box">
                        <h3>Informasi Pelanggan</h3>
                        <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Telepon:</strong> {{ $order->phone ?? '-' }}</p>
                        <p><strong>Alamat Pengiriman:</strong><br>{{ $order->shipping_address }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h3>Metode Pembayaran</h3>
            <p>
                @if($order->payment_method === 'cod')
                    <strong>COD (Cash on Delivery)</strong>
                @elseif($order->payment_method === 'midtrans')
                    <strong>Transfer Bank / E-Wallet</strong>
                @else
                    <strong>{{ strtoupper($order->payment_method) }}</strong>
                @endif
            </p>
            <p><strong>Status Pembayaran:</strong> 
                @if($order->payment_status === 'paid')
                    <span style="color: #10b981;">LUNAS</span>
                @else
                    {{ strtoupper($order->payment_status) }}
                @endif
            </p>
            @if($order->paid_at)
            <p><strong>Tanggal Pembayaran:</strong> {{ $order->paid_at->format('d F Y, H:i') }}</p>
            @endif
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Produk</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="20%" class="text-right">Harga Satuan</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->product ? $item->product->nama : 'Produk tidak tersedia' }}</strong>
                    @if($item->product && $item->product->store)
                    <br><small>Toko: {{ $item->product->store->name }}</small>
                    @endif
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table style="margin-left: auto; width: 300px;">
            <tr>
                <td class="total-label">Subtotal:</td>
                <td class="total-value">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="total-label">Ongkos Kirim:</td>
                <td class="total-value">Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="grand-total">
                        <div class="total-row">
                            <span class="total-label">TOTAL:</span>
                            <span class="total-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    @if($order->notes)
    <div class="info-section" style="margin-top: 30px;">
        <div class="info-box">
            <h3>Catatan</h3>
            <p>{{ $order->notes }}</p>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih atas pembelian Anda!</p>
        <p>Invoice ini dibuat secara otomatis dan sah tanpa tanda tangan.</p>
        <p>Jika ada pertanyaan, silakan hubungi customer service kami.</p>
        <p style="margin-top: 10px;">© {{ date('Y') }} Toko Alat Kesehatan. All rights reserved.</p>
    </div>
</body>
</html>
