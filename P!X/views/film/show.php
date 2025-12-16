<?php 
require_once 'views/layouts/header.php'; ?>

<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <a href="index.php?module=film" class="btn btn-secondary" style="margin-bottom: 20px; display: inline-flex; align-items: center; gap: 5px; padding: 8px 16px; text-decoration: none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali
    </a>
    
    <div class="film-detail" style="display: grid; grid-template-columns: 300px 1fr; gap: 40px; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
        <!-- Poster -->
        <div style="position: relative;">
            <img src="<?php echo htmlspecialchars($filmData['poster_url'] ?? 'https://via.placeholder.com/300x450'); ?>" 
                 alt="<?php echo htmlspecialchars($filmData['judul_film']); ?>"
                 style="width: 100%; height: auto; display: block;">
            
            <!-- Rating Circle -->
            <div style="position: absolute; bottom: 20px; left: 20px; width: 60px; height: 60px; background: #032541; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid #21d07a;">
                <span style="color: white; font-weight: bold; font-size: 18px;"><?php echo number_format($filmData['rating'] * 10, 0); ?>%</span>
            </div>
        </div>
        
        <!-- Info -->
        <div style="padding: 30px;">
            <h1 style="margin: 0 0 10px 0; color: #032541; font-size: 32px;">
                <?php echo htmlspecialchars($filmData['judul_film']); ?>
            </h1>
            
            <?php 
            // PERBAIKAN: Cek status film dengan logika yang BENAR
            $query = "SELECT COUNT(*) as count FROM Jadwal_Tayang WHERE id_film = :id_film";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_film', $filmData['id_film']);
            $stmt->execute();
            $jadwalCount = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $filmStatus = 'tidak_ada_jadwal';
            $isPresale = false;
            $isRegular = false;
            $isToday = false;
            
            if($jadwalCount['count'] > 0) {
                // Cek jadwal terdekat
                $query_nearest = "SELECT MIN(tanggal_tayang) as nearest_date 
                                 FROM Jadwal_Tayang 
                                 WHERE id_film = :id_film 
                                 AND CONCAT(tanggal_tayang, ' ', jam_selesai) >= NOW()";
                $stmt_nearest = $this->db->prepare($query_nearest);
                $stmt_nearest->bindParam(':id_film', $filmData['id_film']);
                $stmt_nearest->execute();
                $result_nearest = $stmt_nearest->fetch(PDO::FETCH_ASSOC);
                
                if($result_nearest && $result_nearest['nearest_date']) {
                    $today = date('Y-m-d');
                    $nearestDate = $result_nearest['nearest_date'];
                    $selisihHari = floor((strtotime($nearestDate) - strtotime($today)) / 86400);
                    
                    // Logika yang BENAR:
                    // 0 hari = Hari Ini
                    // 1-6 hari = Reguler
                    // 7+ hari = Presale
                    
                    if($selisihHari == 0) {
                        $filmStatus = 'sedang_tayang';
                        $isToday = true;
                    } elseif($selisihHari >= 1 && $selisihHari < 7) {
                        $filmStatus = 'akan_tayang';
                        $isRegular = true;
                    } elseif($selisihHari >= 7) {
                        $filmStatus = 'pre_sale';
                        $isPresale = true;
                    }
                }
            }
            ?>
            
            <!-- Status Badge -->
            <?php if($isToday): ?>
            <div style="display: inline-flex; align-items: center; gap: 5px; padding: 8px 20px; background: #0281AA; color: white; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13.73 21a2 2 0 01-3.46 0"/>
                    <path d="M18.63 13A17.888 17.888 0 0118 8"/>
                    <path d="M6 26.35V4a2 2 0 012-2h8a2 2 0 012 2v21.35"/>
                    <path d="M6 17h12"/>
                </svg>
                SEDANG TAYANG
            </div>
            <?php elseif($isPresale): ?>
            <div style="display: inline-flex; align-items: center; gap: 5px; padding: 8px 20px; background: #f59e0b; color: white; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
                PRE-SALE
            </div>
            <?php elseif($isRegular): ?>
            <div style="display: inline-flex; align-items: center; gap: 5px; padding: 8px 20px; background: #3b82f6; color: white; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                AKAN TAYANG
            </div>
            <?php endif; ?>
            
            <div class="info-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px;">
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <div style="color: #666; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                        Genre
                    </div>
                    <span style="color: #032541; font-size: 16px;"><?php echo htmlspecialchars($filmData['nama_genre']); ?></span>
                </div>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <div style="color: #666; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Tahun Rilis
                    </div>
                    <span style="color: #032541; font-size: 16px;"><?php echo $filmData['tahun_rilis']; ?></span>
                </div>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <div style="color: #666; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Durasi
                    </div>
                    <span style="color: #032541; font-size: 16px;"><?php echo $filmData['durasi_menit']; ?> menit</span>
                </div>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <div style="color: #666; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        Rating
                    </div>
                    <span style="color: #032541; font-size: 16px;"><?php echo $filmData['rating']; ?> / 10</span>
                </div>
            </div>
            
            <div style="margin-bottom: 25px;">
                <h3 style="color: #032541; margin: 0 0 10px 0; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    Sinopsis
                </h3>
                <p style="color: #666; line-height: 1.8; margin: 0;">
                    <?php echo nl2br(htmlspecialchars($filmData['sipnosis'] ?? 'Tidak ada sinopsis')); ?>
                </p>
            </div>
            
            <!-- Tombol Booking -->
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <?php 
                if(session_status() == PHP_SESSION_NONE) session_start();
                
                // Booking tersedia untuk SEDANG TAYANG, REGULER, dan PRESALE
                if(isset($_SESSION['user_id']) && ($isToday || $isRegular || $isPresale)): ?>
                    <a href="index.php?module=transaksi&action=pilihJadwal&id_film=<?php echo $filmData['id_film']; ?>" 
                       class="btn btn-primary" style="padding: 15px 30px; font-size: 16px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                        <?php 
                        if($isPresale) {
                            echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                            </svg> Pre-Sale Booking';
                        } elseif($isToday) {
                            echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13.73 21a2 2 0 01-3.46 0"/>
                                <path d="M18.63 13A17.888 17.888 0 0118 8"/>
                                <path d="M6 26.35V4a2 2 0 012-2h8a2 2 0 012 2v21.35"/>
                                <path d="M6 17h12"/>
                            </svg> Booking Hari Ini';
                        } else {
                            echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg> Booking Tiket';
                        }
                        ?>
                    </a>
                <?php elseif(!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && ($isToday || $isRegular || $isPresale)): ?>
                    <a href="index.php?module=auth&action=index" 
                       class="btn btn-primary" style="padding: 15px 30px; font-size: 16px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Login untuk <?php echo $isPresale ? 'Pre-Sale' : 'Booking'; ?>
                    </a>
                <?php elseif($filmStatus == 'tidak_ada_jadwal'): ?>
                    <div style="display: inline-flex; align-items: center; gap: 8px; padding: 15px 30px; background: #f8d7da; color: #721c24; border-radius: 5px; font-weight: 600;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        Belum ada jadwal tayang
                    </div>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['admin_id'])): ?>
                    <a href="index.php?module=admin&action=editFilm&id=<?php echo $filmData['id_film']; ?>" 
                       class="btn btn-warning" style="padding: 15px 20px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit
                    </a>
                    <a href="index.php?module=admin&action=deleteFilm&id=<?php echo $filmData['id_film']; ?>" 
                       class="btn btn-danger" style="padding: 15px 20px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;"
                       onclick="return confirm('Yakin hapus film ini?')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18"/>
                            <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                        </svg>
                        Hapus
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>