<?php require_once 'views/layouts/header.php'; ?>

<style>
    .stat-card-enhanced {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: 1px solid #e8e8e8;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card-enhanced:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    
    .stat-card-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #3A8DB6 0%, #2a6c8f 100%);
    }
    
    .stat-icon-enhanced {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #3A8DB6 0%, #2a6c8f 100%);
    }
    
    .stat-info-enhanced h5 {
        margin: 0 0 5px 0;
        font-size: 28px;
        font-weight: 700;
        color: #032541;
        line-height: 1.2;
    }
    
    .stat-info-enhanced h4 {
        margin: 0 0 5px 0;
        font-size: 24px;
        font-weight: 600;
        color: #032541;
        line-height: 1.2;
    }
    
    .stat-info-enhanced p {
        margin: 0;
        color: #3A8DB6;
        font-size: 14px;
        font-weight: 600;
    }
</style>

<div class="container">
    <div class="header-section">
        <h1>Profile </h1>
        <p style="margin: 10px 0 0 0; color: #666;">
            Selamat datang, <strong><?php echo htmlspecialchars($this->user->nama_lengkap); ?></strong>!
        </p>
    </div>

    <!-- User Profile Card -->
    <div style="background: #3A8DB6; padding: 30px; border-radius: 10px; margin-bottom: 30px; color: white;">
        <div style="display: flex; align-items: center; gap: 25px;">
            <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div style="flex: 1;">
                <h2 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($this->user->nama_lengkap); ?></h2>
                <p style="margin: 5px 0; opacity: 0.9; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <?php echo htmlspecialchars($this->user->email); ?>
                </p>
                <p style="margin: 5px 0; opacity: 0.9; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <?php echo htmlspecialchars($this->user->username); ?>
                </p>
                <?php if($this->user->no_telpon): ?>
                    <p style="margin: 5px 0; opacity: 0.9; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <?php echo htmlspecialchars($this->user->no_telpon); ?>
                    </p>
                <?php endif; ?>
            </div>
            <a href="index.php?module=user&action=profile" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); border: 2px solid white; display: flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit 
            </a>
        </div>
    </div>

    <!-- User Statistics - ENHANCED with #3A8DB6 color -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 40px;">
        <!-- Transaksi Berhasil -->
        <div class="stat-card-enhanced">
            <div class="stat-icon-enhanced">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-info-enhanced">
                <h5><?php 
                    $successCount = 0;
                    foreach($transactions as $t) {
                        if($t['status_pembayaran'] == 'berhasil') $successCount++;
                    }
                    echo $successCount;
                ?></h5>
                <p>Transaksi Berhasil</p>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="stat-card-enhanced">
            <div class="stat-icon-enhanced">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <div class="stat-info-enhanced">
                <h5>Rp <?php 
                    $totalSpent = 0;
                    foreach($transactions as $t) {
                        if($t['status_pembayaran'] == 'berhasil') {
                            $totalSpent += $t['total_harga'];
                        }
                    }
                    echo number_format($totalSpent, 0, ',', '.');
                ?></h5>
                <p>Total Pengeluaran</p>
            </div>
        </div>

        <!-- Bergabung Sejak -->
        <div class="stat-card-enhanced">
            <div class="stat-icon-enhanced">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="stat-info-enhanced">
                <h4><?php echo date('d M Y', strtotime($this->user->tanggal_daftar)); ?></h4>
                <p>Bergabung Sejak</p>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="section-header">
        <h2>Transaksi Terakhir</h2>
        <a href="index.php?module=user&action=riwayat" class="btn btn-secondary">Lihat Semua</a>
    </div>

    <?php if(empty($transactions)): ?>
        <div class="empty-state">
            <p>Belum ada transaksi</p>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 15px;">
            <?php 
            $recentTransactions = array_slice($transactions, 0, 5);
            foreach($recentTransactions as $trans): 
            ?>
                <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: center;">
                    <div style="width: 60px; height: 60px; background: <?php 
                        echo $trans['status_pembayaran'] === 'berhasil' ? 'linear-gradient(135deg, #21d07a, #21d07a)' : 
                            ($trans['status_pembayaran'] === 'pending' ? 'linear-gradient(135deg, #ffc107, #ff9800)' : 
                            'linear-gradient(135deg, #dc3545, #c82333)'); 
                    ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        <?php 
                        echo $trans['status_pembayaran'] === 'berhasil' ? '✓' : 
                            ($trans['status_pembayaran'] === 'pending' ? '⏳' : '✗'); 
                        ?>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #032541; font-size: 18px;">
                            <?php echo htmlspecialchars($trans['kode_booking']); ?>
                        </h4>
                        <p style="margin: 3px 0; color: #666; font-size: 14px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <?php echo date('d/m/Y H:i', strtotime($trans['tanggal_transaksi'])); ?>
                        </p>
                        <p style="margin: 3px 0; color: #666; font-size: 14px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                                <path d="M20 7h-3a2 2 0 0 1-2-2V2"/>
                                <rect x="3" y="2" width="14" height="20" rx="2"/>
                                <path d="M7 10h6M7 14h6M7 18h3"/>
                            </svg>
                            <?php echo $trans['jumlah_tiket']; ?> tiket • 
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-left: 4px; margin-right: 4px;">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                            <?php 
                            $metode = [
                                'transfer' => 'Transfer',
                                'e-wallet' => 'E-Wallet',
                                'kartu_kredit' => 'Kartu Kredit',
                                'tunai' => 'Tunai'
                            ];
                            echo $metode[$trans['metode_pembayaran']] ?? $trans['metode_pembayaran'];
                            ?>
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <div style="color: #21d07a; font-weight: 700; font-size: 18px; margin-bottom: 8px;">
                            Rp <?php echo number_format($trans['total_harga'], 0, ',', '.'); ?>
                        </div>
                        <span style="padding: 5px 12px; background: <?php 
                            echo $trans['status_pembayaran'] === 'berhasil' ? '#21d07a' : 
                                ($trans['status_pembayaran'] === 'pending' ? '#ffc107' : '#dc3545'); 
                        ?>; color: white; border-radius: 15px; font-size: 12px; font-weight: 600;">
                            <?php echo strtoupper($trans['status_pembayaran']); ?>
                        </span>
                        <br>
                        <a href="index.php?module=user&action=detailTiket&id=<?php echo $trans['id_transaksi']; ?>" 
                           class="btn btn-info btn-sm" style="margin-top: 10px; background: #249bd2ff; border-color: #21d07a;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'views/layouts/footer.php'; ?>


