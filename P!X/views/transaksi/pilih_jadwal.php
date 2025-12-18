<?php require_once 'views/layouts/header.php'; ?>

<div class="hero-section">
    <div class="hero-content">
        <h1>Pilih Jadwal Tayang</h1>
        <p>Pilih waktu yang sesuai untuk menonton</p>
    </div>
</div>

<div class="container">
    <div class="header-section">
        <h1>
           
            <?php echo htmlspecialchars($filmData->judul_film ?? 'Film'); ?>
        </h1>
        <a href="index.php?module=film&action=show&id=<?php echo $id_film; ?>" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>

    <?php if($filmData): ?>
    <div style="background: linear-gradient(135deg, #3296ddff 0%, #59bff6ff 100%); padding: 30px; border-radius: 10px; margin-bottom: 30px; color: white;">
        <div style="display: flex; align-items: center; gap: 25px;">
            <img src="<?php echo htmlspecialchars($filmData->poster_url ?? 'https://via.placeholder.com/150x225'); ?>" 
                 alt="<?php echo htmlspecialchars($filmData->judul_film); ?>"
                 style="width: 120px; height: 180px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
            <div style="flex: 1;">
                <h2 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($filmData->judul_film); ?></h2>
                <p style="margin: 0; opacity: 0.9; font-size: 16px; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <?php echo $filmData->tahun_rilis; ?>
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <?php echo $filmData->durasi_menit; ?> menit
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        Rating: <?php echo $filmData->rating; ?>/10
                    </span>
                </p>
                <?php if($filmData->sipnosis): ?>
                <p style="margin: 15px 0 0 0; opacity: 0.9; font-size: 14px; line-height: 1.5;">
                    <?php echo substr(htmlspecialchars($filmData->sipnosis), 0, 200); ?><?php echo strlen($filmData->sipnosis) > 200 ? '...' : ''; ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(empty($jadwals)): ?>
        <div class="empty-state">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" style="margin-bottom: 20px;">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <p>Tidak ada jadwal tayang tersedia untuk film ini</p>
            <a href="index.php?module=film" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Kembali ke Film
            </a>
        </div>
    <?php else: ?>
        <?php
        // Group jadwal by date
        $jadwalByDate = [];
        foreach($jadwals as $jadwal) {
            $date = $jadwal['tanggal_tayang'];
            if(!isset($jadwalByDate[$date])) {
                $jadwalByDate[$date] = [];
            }
            $jadwalByDate[$date][] = $jadwal;
        }
        
        // Get today's date for comparison
        $today = date('Y-m-d');
        ?>

        <?php foreach($jadwalByDate as $date => $jadwalsOnDate): ?>
            <?php
            // Logika status
            $selisihHari = floor((strtotime($date) - strtotime($today)) / 86400);
            
            $isToday = ($selisihHari == 0);
            $isRegular = ($selisihHari >= 1 && $selisihHari < 7);
            $isPresale = ($selisihHari >= 7);
            ?>

            <div style="margin-bottom: 40px;">
                <!-- Date Header with Status Badge -->
                <div style="background: <?php 
                    echo $isPresale ? '#FFE8AD' : 
                        ($isToday ? '#0281AA' : '#D1E8FF');
                ?>; padding: 20px 30px; border-radius: 10px; margin-bottom: 20px; color: <?php echo $isPresale ? '#333' : ($isToday ? 'white' : '#032541'); ?>; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                    <div style="display: flex; align-items: center; gap: 15px;">
                       
                        <div>
                            <h3 style="margin: 0 0 5px 0; font-size: 24px;">
                                <?php 
                                $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                echo $hari[date('w', strtotime($date))]; 
                                ?>, <?php echo date('d F Y', strtotime($date)); ?>
                            </h3>
                            <?php if($isToday): ?>
                                <p style="margin: 0; opacity: 0.9; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                                        <path d="M18.63 13A17.888 17.888 0 0118 8"/>
                                        <path d="M6 26.35V4a2 2 0 012-2h8a2 2 0 012 2v21.35"/>
                                    </svg>
                                    Tayang Hari Ini
                                </p>
                            <?php elseif($isRegular): ?>
                                <p style="margin: 0; opacity: 0.9; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    Akan Tayang - <?php echo $selisihHari; ?> hari lagi
                                </p>
                            <?php elseif($isPresale): ?>
                                <p style="margin: 0; opacity: 0.9; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                                    </svg>
                                    Pre-Sale - <?php echo $selisihHari; ?> hari lagi
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if($isPresale): ?>
                        <div style="background: rgba(0,0,0,0.1); padding: 12px 25px; border-radius: 30px; border: 2px solid rgba(0,0,0,0.15);">
                            <div style="font-size: 24px; font-weight: 700; text-align: center; color: #333;"><?php echo $selisihHari; ?></div>
                            <div style="font-size: 11px; text-align: center; color: #555;">HARI LAGI</div>
                        </div>
                    <?php elseif($isToday): ?>
                        <div style="background: rgba(255,255,255,0.25); padding: 10px 20px; border-radius: 25px; backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.4); display: flex; align-items: center; gap: 8px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13.73 21a2 2 0 01-3.46 0"/>
                                <path d="M18.63 13A17.888 17.888 0 0118 8"/>
                            </svg>
                            <span style="font-size: 16px; font-weight: 700;">TAYANG HARI INI</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Info Banner -->
                <?php if($isPresale): ?>
                <div style="background: #FFE8AD; border: 3px solid #d97706; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(255, 232, 173, 0.3);">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                        </svg>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 8px 0; color: #856404; font-size: 20px;">
                                Tiket Pre-Sale Tersedia!
                            </h4>
                            <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.6;">
                                Dapatkan tiket lebih awal untuk penayangan <strong><?php echo date('d F Y', strtotime($date)); ?></strong>! 
                                Film akan tayang dalam <strong><?php echo $selisihHari; ?> hari</strong>. Pesan sekarang sebelum tiket habis.
                            </p>
                        </div>
                    </div>
                </div>
                <?php elseif($isRegular): ?>
                <div style="background: #D1E8FF; border: 3px solid #3b82f6; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(209, 232, 255, 0.3);">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 8px 0; color: #1e40af; font-size: 20px;">
                                Booking Reguler Tersedia
                            </h4>
                            <p style="margin: 0; color: #1e40af; font-size: 14px; line-height: 1.6;">
                                Film akan tayang <strong><?php echo date('d F Y', strtotime($date)); ?></strong> 
                                (<?php echo $selisihHari; ?> hari lagi). Booking tiket Anda sekarang!
                            </p>
                        </div>
                    </div>
                </div>
                <?php elseif($isToday): ?>
                <div style="background: #0281AA; border: 3px solid #026a8d; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(2, 129, 170, 0.3); color: white;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M13.73 21a2 2 0 01-3.46 0"/>
                            <path d="M18.63 13A17.888 17.888 0 0118 8"/>
                            <path d="M6 26.35V4a2 2 0 012-2h8a2 2 0 012 2v21.35"/>
                        </svg>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 8px 0; font-size: 20px;">
                                Tayang Hari Ini!
                            </h4>
                            <p style="margin: 0; opacity: 0.95; font-size: 14px; line-height: 1.6;">
                                Film ini tayang hari ini! Segera booking sebelum tiket habis!
                            </p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Jadwal Cards - TANPA BADGE -->
                <div style="display: grid; gap: 15px;">
                    <?php foreach($jadwalsOnDate as $jadwal): ?>
                        <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: grid; grid-template-columns: auto 1fr auto; gap: 25px; align-items: center;">
                            
                            <!-- Time -->
                            <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px; min-width: 80px;">
                                <div style="font-size: 28px; font-weight: 700; color: #032541; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <?php echo date('H:i', strtotime($jadwal['jam_mulai'])); ?>
                                </div>
                                <div style="font-size: 11px; color: #666; margin-top: 5px;">
                                    s/d <?php echo date('H:i', strtotime($jadwal['jam_selesai'])); ?>
                                </div>
                            </div>

                            <!-- Info -->
                            <div>
                                <h3 style="margin: 0 0 10px 0; font-size: 20px; color: #032541; display: flex; align-items: center; gap: 8px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                        <polyline points="9 22 9 12 15 12 15 22"/>
                                    </svg>
                                    <?php echo htmlspecialchars($jadwal['nama_bioskop']); ?>
                                </h3>
                                <p style="margin: 5px 0; color: #666; font-size: 15px; display: flex; align-items: center; gap: 6px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    <?php echo htmlspecialchars($jadwal['kota']); ?>
                                </p>
                                <?php if(!empty($jadwal['nama_tayang'])): ?>
                                    <p style="margin: 5px 0; color: #01b4e4; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 7h-3a2 2 0 0 1-2-2V2"/>
                                            <rect x="3" y="2" width="14" height="20" rx="2"/>
                                            <path d="M7 10h6M7 14h6M7 18h3"/>
                                        </svg>
                                        <?php echo htmlspecialchars($jadwal['nama_tayang']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Price & Button -->
                            <div style="text-align: right;">
                                <div style="color: #01b4e4; font-weight: 700; font-size: 22px; margin-bottom: 15px; display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="1" x2="12" y2="23"/>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                    </svg>
                                    Rp <?php echo number_format($jadwal['harga_tiket'], 0, ',', '.'); ?>
                                </div>
                                <?php if($isPresale): ?>
                                    <a href="index.php?module=transaksi&action=booking&id_jadwal=<?php echo $jadwal['id_tayang']; ?>" 
                                       class="btn btn-primary" style="padding: 12px 25px; font-size: 15px; background: linear-gradient(135deg, #be9e34ff 0%, #d5a514ff 100%); border: none; display: inline-flex; align-items: center; gap: 6px;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                                        </svg>
                                        Pre-Sale Booking
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?module=transaksi&action=booking&id_jadwal=<?php echo $jadwal['id_tayang']; ?>" 
                                       class="btn btn-primary" style="padding: 12px 25px; font-size: 15px; display: inline-flex; align-items: center; gap: 6px;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 7h-3a2 2 0 0 1-2-2V2"/>
                                            <rect x="3" y="2" width="14" height="20" rx="2"/>
                                            <path d="M7 10h6M7 14h6M7 18h3"/>
                                        </svg>
                                        Booking Sekarang
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once 'views/layouts/footer.php'; ?>