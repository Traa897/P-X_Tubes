<?php 
require_once 'views/layouts/header.php'; ?>

<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <a href="index.php?module=film" class="btn btn-secondary" style="margin-bottom: 20px;">⬅️ Kembali</a>
    
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
            <div style="display: inline-block; padding: 8px 20px; background: #0281AA; color: white; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                🔥 SEDANG TAYANG
            </div>
            <?php elseif($isPresale): ?>
            <div style="display: inline-block; padding: 8px 20px; background: #f59e0b; color: white; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                ⚡ PRE-SALE
            </div>
            <?php elseif($isRegular): ?>
            <div style="display: inline-block; padding: 8px 20px; background: #3b82f6; color: white; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                📅 AKAN TAYANG
            </div>
            <?php endif; ?>
            
            <div class="info-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px;">
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <strong style="color: #666; font-size: 12px; display: block;">🎭 Genre</strong>
                    <span style="color: #032541; font-size: 16px;"><?php echo htmlspecialchars($filmData['nama_genre']); ?></span>
                </div>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <strong style="color: #666; font-size: 12px; display: block;">📅 Tahun Rilis</strong>
                    <span style="color: #032541; font-size: 16px;"><?php echo $filmData['tahun_rilis']; ?></span>
                </div>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <strong style="color: #666; font-size: 12px; display: block;">⏱️ Durasi</strong>
                    <span style="color: #032541; font-size: 16px;"><?php echo $filmData['durasi_menit']; ?> menit</span>
                </div>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <strong style="color: #666; font-size: 12px; display: block;">⭐ Rating</strong>
                    <span style="color: #032541; font-size: 16px;"><?php echo $filmData['rating']; ?> / 10</span>
                </div>
            </div>
            
            <div style="margin-bottom: 25px;">
                <h3 style="color: #032541; margin: 0 0 10px 0;">📖 Sinopsis</h3>
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
                       class="btn btn-primary" style="padding: 15px 30px; font-size: 16px;">
                        <?php 
                        if($isPresale) {
                            echo '⚡ Pre-Sale Booking';
                        } elseif($isToday) {
                            echo '🔥 Booking Hari Ini';
                        } else {
                            echo '🎫 Booking Tiket';
                        }
                        ?>
                    </a>
                <?php elseif(!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']) && ($isToday || $isRegular || $isPresale)): ?>
                    <a href="index.php?module=auth&action=index" 
                       class="btn btn-primary" style="padding: 15px 30px; font-size: 16px;">
                        🔐 Login untuk <?php echo $isPresale ? 'Pre-Sale' : 'Booking'; ?>
                    </a>
                <?php elseif($filmStatus == 'tidak_ada_jadwal'): ?>
                    <div style="padding: 15px 30px; background: #f8d7da; color: #721c24; border-radius: 5px; font-weight: 600;">
                        ⚠️ Belum ada jadwal tayang
                    </div>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['admin_id'])): ?>
                    <a href="index.php?module=admin&action=editFilm&id=<?php echo $filmData['id_film']; ?>" 
                       class="btn btn-warning" style="padding: 15px 20px;">✏️ Edit</a>
                    <a href="index.php?module=admin&action=deleteFilm&id=<?php echo $filmData['id_film']; ?>" 
                       class="btn btn-danger" style="padding: 15px 20px;"
                       onclick="return confirm('Yakin hapus film ini?')">🗑️ Hapus</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>