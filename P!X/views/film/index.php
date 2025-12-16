<?php 
require_once 'views/layouts/header.php'; ?>

<div class="hero-section">
    <div class="hero-content">
        <h1>Daftar Film</h1>
        <p>Selamat datang, Jangan Lupa Nonton </p>
        
        <form method="GET" action="index.php" class="hero-search">
            <input type="hidden" name="module" value="film">
            <input type="text" name="search" placeholder="Cari film berdasarkan judul..." 
                   value="<?php echo htmlspecialchars($search ?? ''); ?>">
            <button type="submit" class="btn-search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<div class="container">
    
    <div style="margin-bottom: 30px;">
        <h2 style="font-size: 28px; color: #032541; margin: 0;">
            <?php 
            if($status_filter == 'akan_tayang') {
                echo 'Film Akan Tayang';
            } elseif($status_filter == 'sedang_tayang') {
                echo 'Film Sedang Tayang';
          
            } 
            ?> 
           
        </h2>
    </div>

    <div style="margin-bottom: 40px;">
    
        <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: thin;">
            <a href="index.php?module=film" 
               style="flex-shrink: 0; padding: 12px 24px; background: <?php echo empty($genre_filter) ? 'linear-gradient(135deg, #0d7377, #14a1a6)' : '#6c757d'; ?>; color: white; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s; white-space: nowrap;">
                Semua Genre
            </a>
            <?php foreach($genres as $genre): ?>
                <a href="index.php?module=film&genre=<?php echo $genre['id_genre']; ?>" 
                   style="flex-shrink: 0; padding: 12px 24px; background: <?php echo ($genre_filter == $genre['id_genre']) ? 'linear-gradient(135deg, #0d7377, #14a1a6)' : '#6c757d'; ?>; color: white; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s; white-space: nowrap;">
                    <?php echo htmlspecialchars($genre['nama_genre']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if(empty($films)): ?>
        <div style="text-align: center; padding: 80px 20px; background: #f8f9fa; border-radius: 15px;">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" style="margin-bottom: 20px;">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <h3 style="font-size: 24px; color: #6c757d; margin: 0 0 10px 0;">Tidak ada film ditemukan</h3>
            <p style="color: #999; margin: 0 0 20px 0;">
                <?php if($status_filter != ''): ?>
                    Belum ada film dengan status ini. Coba filter lain atau lihat semua film.
                <?php else: ?>
                    Coba ubah filter atau kata kunci pencarian
                <?php endif; ?>
            </p>
            <a href="index.php?module=film" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #0d7377, #14a1a6); color: white; text-decoration: none; border-radius: 25px; font-weight: 600;">
                Reset Filter
            </a>
        </div>
    <?php else: ?>
        <div style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px; scrollbar-width: thin;">
            <?php foreach($films as $film): ?>
               <?php
                // PERBAIKAN: Cek status film dengan logika yang BENAR
                $today = date('Y-m-d');
                $query = "SELECT MIN(tanggal_tayang) as nearest_date 
                         FROM Jadwal_Tayang 
                         WHERE id_film = :id_film 
                         AND CONCAT(tanggal_tayang, ' ', jam_selesai) >= NOW()";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_film', $film['id_film']);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $isPresale = false;
                $isRegular = false;
                $isToday = false;
                $statusBadge = '';
                $statusColor = '';
                
                if($result && $result['nearest_date']) {
                    $selisihHari = floor((strtotime($result['nearest_date']) - strtotime($today)) / 86400);
                    
                    // PERBAIKAN: Logika yang BENAR
                    // 0 hari = Hari Ini
                    // 1-6 hari = Reguler (AKAN TAYANG)
                    // 7+ hari = Presale
                    
                    if($selisihHari == 0) {
                        $isToday = true;
                        $statusBadge = 'HARI INI';
                        $statusColor = 'linear-gradient(135deg, #0281AA, #0d72bbff)';
                    } elseif($selisihHari >= 1 && $selisihHari < 7) {
                        $isRegular = true;
                        $statusBadge = 'AKAN TAYANG';
                        $statusColor = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                    } elseif($selisihHari >= 7) {
                        $isPresale = true;
                        $statusBadge = 'PRE-SALE';
                        $statusColor = 'linear-gradient(135deg, #f59e0b, #d97706)';
                    }
                }
                ?>
                <div style="flex-shrink: 0; width: 180px; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="position: relative;">
                        <img src="<?php echo htmlspecialchars($film['poster_url'] ?? 'https://via.placeholder.com/200x300'); ?>" 
                             alt="<?php echo htmlspecialchars($film['judul_film']); ?>"
                             style="width: 100%; height: 260px; object-fit: cover; display: block;">
                        
                        <?php if($statusBadge): ?>
                        <div style="position: absolute; top: 8px; left: 8px; background: <?php echo $statusColor; ?>; color: white; padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.3); text-transform: uppercase; letter-spacing: 0.5px;">
                            <?php if($isPresale): ?>
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 2px;">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                            </svg>
                            <?php elseif($isToday): ?>
                            🔥
                            <?php else: ?>
                            📅
                            <?php endif; ?>
                            <?php echo $statusBadge; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div style="position: absolute; bottom: -18px; left: 10px; width: 40px; height: 40px; background: #032541; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid #21d07a; box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
                            <span style="color: white; font-weight: bold; font-size: 12px;"><?php echo number_format($film['rating'] * 10, 0); ?>%</span>
                        </div>
                    </div>
                    
                    <div style="padding: 25px 12px 12px 12px;">
                        <h3 style="margin: 0 0 5px 0; font-size: 14px; color: #032541; font-weight: 700; line-height: 1.3; height: 36px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?php echo htmlspecialchars($film['judul_film']); ?>
                        </h3>
                        <p style="margin: 0 0 10px 0; color: #999; font-size: 12px;">
                            <?php echo $film['tahun_rilis']; ?>
                        </p>
                        
                        <a href="index.php?module=film&action=show&id=<?php echo $film['id_film']; ?>" 
                           style="display: block; text-align: center; padding: 8px; background: linear-gradient(135deg, #0d7377, #14a1a6); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 13px; transition: all 0.3s;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'views/layouts/footer.php'; ?>