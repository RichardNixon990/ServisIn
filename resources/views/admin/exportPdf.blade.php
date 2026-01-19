<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Servis Bulanan</title>
    <link rel="stylesheet" href="{{ asset('css/admin/exportPdf.css') }}">
</head>

<body>

    <h1>Laporan Servis Bulanan</h1>
    <p class="period">Periode: <strong>{{ date('F Y') }}</strong> &nbsp; | &nbsp; Dicetak:
        <strong>{{ date('d M Y') }}</strong></p>

    
    <table style="width: 100%; border-spacing: 10px; margin-bottom: 25px; border-collapse: separate;">
        <tr>
            <td style="width: 24%; padding: 15px; background: #f1f5f9; border-radius: 6px; text-align: center; border: 1px solid #cbd5e1;">
                <strong style="display: block; font-size: 10pt; color: #475569; margin-bottom: 8px;">Total Pesanan</strong>
                <div style="font-size: 24pt; font-weight: bold; color: #1f2937;">{{$totalStatus}}</div>
            </td>
            <td style="width: 24%; padding: 15px; background: #d1fae5; border-radius: 6px; text-align: center; border: 1px solid #10b981;">
                <strong style="display: block; font-size: 10pt; color: #065f46; margin-bottom: 8px;">Selesai</strong>
                <div style="font-size: 24pt; font-weight: bold; color: #047857;">{{$statusStats['completed']}}</div>
            </td>
            <td style="width: 24%; padding: 15px; background: #fef3c7; border-radius: 6px; text-align: center; border: 1px solid #f59e0b;">
                <strong style="display: block; font-size: 10pt; color: #92400e; margin-bottom: 8px;">Sedang Dikerjakan</strong>
                <div style="font-size: 24pt; font-weight: bold; color: #b45309;">{{$statusStats['on_process']}}</div>
            </td>
            <td style="width: 24%; padding: 15px; background: #fee2e2; border-radius: 6px; text-align: center; border: 1px solid #ef4444;">
                <strong style="display: block; font-size: 10pt; color: #991b1b; margin-bottom: 8px;">Dibatalkan</strong>
                <div style="font-size: 24pt; font-weight: bold; color: #b91c1c;">{{$statusStats['cancelled']}}</div>
            </td>
        </tr>
    </table>

    <h2>Statistik Jenis Perangkat</h2>

    <table class="table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th>Jenis Perangkat</th>
                <th style="text-align: center; width: 150px;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no-col">1</td>
                <td>Smartphone/HP</td>
                <td style="text-align: center;"><strong>{{$deviceStats['hp']}}</strong></td>
            </tr>
            <tr>
                <td class="no-col">2</td>
                <td>Laptop</td>
                <td style="text-align: center;"><strong>{{$deviceStats['laptop']}}</strong></td>
            </tr>
            <tr>
                <td class="no-col">3</td>
                <td>Tablet</td>
                <td style="text-align: center;"><strong>{{$deviceStats['tablet']}}</strong></td>
            </tr>
            <tr style="background: #e2e8f0; font-weight: bold;">
                <td class="no-col">-</td>
                <td>TOTAL</td>
                <td style="text-align: center;">{{$totalOrders}}</td>
            </tr>
        </tbody>
    </table>

    <h2>Detail Pesanan</h2>

    <table class="table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Teknisi</th>
                <th>Perangkat</th>
                <th>Masalah</th>
                <th>Catatan Teknisi</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td class="no-col">{{ $order->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('j F Y') }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->technician->user->name ?? 'teknisi belum tersedia' }}</td>
                    <td>{{ $order->brand }}</td>
                    <td>{{ $order->issue_description}}</td>
                    <td>{{ $order->notes ?? '-' }}</td>
                    @if ($order->status === 'on_process')
                        <td style="text-align: center;">
                            <span class="status dikerjakan">Dikerjakan</span>
                        </td>
                    @elseif ($order->status === 'completed')
                        <td style="text-align: center;">
                            <span class="status selesai">Selesai</span>
                        </td>
                    @elseif ($order->status === 'pending')
                        <td style="text-align: center;">
                            <span class="status pending">pending</span>
                        </td>
                    @elseif ($order->status === 'cancelled')
                        <td style="text-align: center;">
                            <span class="status dibatalkan">dibatalkan</span>
                        </td>
                    @endif
                </tr>
                @endforeach
        </tbody>
    </table>

    <h2>Rekap Teknisi</h2>

    <table class="table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th>Teknisi</th>
                <th style="text-align: center;">Total Order</th>
                <th style="text-align: center;">Selesai</th>
                <th style="text-align: center;">Proses</th>
                <th style="text-align: center;">Rating</th>
            </tr>
        </thead>

       <tbody>
    @foreach ($technicians as $index => $technician)
    <tr>
        <td class="no-col">{{ $index + 1 }}</td>
        <td>{{ $technician->user->name }}</td>
        <td style="text-align: center;"><strong>{{ $technician->total_orders }}</strong></td>
        <td style="text-align: center;">{{ $technician->completed_orders }}</td>
        <td style="text-align: center;">{{ $technician->active_orders }}</td>
        <td style="text-align: center;"><strong>{{ number_format($technician->average_rating, 1) }}</strong></td>
    </tr>
    @endforeach
</tbody>

    </table>
    <div class="footer">
        <p>© 2025 ServisIn - Laporan dibuat otomatis oleh sistem</p>
    </div>

</body>

</html>

