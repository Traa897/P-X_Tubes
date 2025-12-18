<?php require_once 'views/layouts/header.php'; ?>

<div class="container" style="max-width: 600px;">
    <?php
    $jadwalData = $jadwal;
    $jumlah_tiket = $_POST['jumlah_tiket'] ?? 1;
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? '';
    $total_harga = $jumlah_tiket * $jadwalData->harga_tiket;
    
    // Nama metode yang user-friendly
    $metode_names = [
        'transfer' => 'Transfer Bank',
        'e-wallet' => 'E-Wallet',
        'e-money' => 'E-Money',
        'm-banking' => 'M-Banking',
        'kartu_kredit' => 'Kartu Kredit'
    ];
    $metode_display = $metode_names[$metode_pembayaran] ?? $metode_pembayaran;
    ?>

    <div style="text-align: center; margin: 30px 0;">
        <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #ffc107, #ff9800); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
        </div>
        <h1 style="margin: 0 0 10px 0; color: #032541; font-size: 28px;">Konfirmasi Pembayaran</h1>
        <p style="margin: 0; color: #666; font-size: 16px;">Mohon periksa kembali detail pesanan Anda</p>
    </div>

    <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin: 0 0 15px 0; color: #032541; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                <line x1="7" y1="2" x2="7" y2="22"/>
                <line x1="17" y1="2" x2="17" y2="22"/>
                <line x1="2" y1="12" x2="22" y2="12"/>
            </svg>
            Detail Pesanan
        </h3>
        
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 12px 0; color: #666;">Film:</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 600; color: #032541;">
                    <?php echo htmlspecialchars($jadwalData->judul_film); ?>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 12px 0; color: #666;">Bioskop:</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 600; color: #032541;">
                    <?php echo htmlspecialchars($jadwalData->nama_bioskop); ?>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 12px 0; color: #666;">Tanggal:</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 600; color: #032541;">
                    <?php echo date('d F Y', strtotime($jadwalData->tanggal_tayang)); ?>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 12px 0; color: #666;">Jam:</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 600; color: #032541;">
                    <?php echo date('H:i', strtotime($jadwalData->jam_mulai)); ?> - <?php echo date('H:i', strtotime($jadwalData->jam_selesai)); ?>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 12px 0; color: #666;">Jumlah Tiket:</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 600; color: #032541;">
                    <?php echo $jumlah_tiket; ?> tiket
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 12px 0; color: #666;">Harga per Tiket:</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 600; color: #032541;">
                    Rp <?php echo number_format($jadwalData->harga_tiket, 0, ',', '.'); ?>
                </td>
            </tr>
            <tr style="border-bottom: 2px solid #032541;">
                <td style="padding: 12px 0; color: #666;">Metode Pembayaran:</td>
                <td style="padding: 12px 0; text-align: right; font-weight: 600; color: #01b4e4;">
                    <?php echo $metode_display; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 15px 0; font-size: 18px; font-weight: 700; color: #032541;">TOTAL:</td>
                <td style="padding: 15px 0; text-align: right; font-size: 22px; font-weight: 700; color: #01b4e4;">
                    Rp <?php echo number_format($total_harga, 0, ',', '.'); ?>
                </td>
            </tr>
        </table>
    </div>

    <div style="background: #fff3cd; border: 2px solid #ffc107; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
        <strong style="color: #856404; display: block; margin-bottom: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            Penting:
        </strong>
        <ul style="margin: 0; padding-left: 20px; color: #856404; font-size: 14px;">
            <li>Kursi akan dipilih secara otomatis oleh sistem</li>
            <li>Setelah konfirmasi, pesanan tidak dapat dibatalkan</li>
            <li>Pastikan data sudah benar sebelum melanjutkan</li>
        </ul>
    </div>

    <form method="POST" action="index.php?module=transaksi&action=prosesBooking">
        <input type="hidden" name="id_jadwal" value="<?php echo $_POST['id_jadwal']; ?>">
        <input type="hidden" name="jumlah_tiket" value="<?php echo $jumlah_tiket; ?>">
        <input type="hidden" name="metode_pembayaran" value="<?php echo htmlspecialchars($metode_pembayaran); ?>">
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 15px; font-size: 16px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Ya, Bayar Sekarang
            </button>
            <a href="index.php?module=transaksi&action=booking&id_jadwal=<?php echo $_POST['id_jadwal']; ?>" 
               class="btn btn-secondary" style="padding: 15px 30px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </form>
</div>

<?php require_once 'views/layouts/footer.php'; ?>