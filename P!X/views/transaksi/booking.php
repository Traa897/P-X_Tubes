<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                <path d="M20 7h-3a2 2 0 0 1-2-2V2"/>
                <rect x="3" y="2" width="14" height="20" rx="2"/>
                <path d="M7 10h6M7 14h6M7 18h3"/>
            </svg>
            Booking Tiket
        </h1>
        <a href="index.php?module=transaksi&action=pilihJadwal&id_film=<?php echo $this->jadwal->id_film; ?>" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>

    <?php
    $today = date('Y-m-d');
    $tanggalTayang = $this->jadwal->tanggal_tayang;
    $selisihHari = floor((strtotime($tanggalTayang) - strtotime($today)) / 86400);
    
    $isToday = ($selisihHari == 0);
    $isRegular = ($selisihHari >= 1 && $selisihHari < 7);
    $isPresale = ($selisihHari >= 7);
    ?>

    <?php if($isPresale): ?>
    <div style="background: #FFE8AD; padding: 25px; border-radius: 10px; margin-bottom: 25px; color: #333; box-shadow: 0 4px 16px rgba(255, 232, 173, 0.4);">
        <div style="display: flex; align-items: center; gap: 20px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
            </svg>
            <div style="flex: 1;">
                <h3 style="margin: 0 0 8px 0; font-size: 22px; color: #333;">Pre-Sale Booking</h3>
                <p style="margin: 0; font-size: 15px; color: #555;">
                    Anda sedang melakukan pre-sale booking untuk penayangan <strong><?php echo date('l, d F Y', strtotime($tanggalTayang)); ?></strong>. 
                    Film akan tayang dalam <strong><?php echo $selisihHari; ?> hari</strong>. Tiket dapat digunakan pada tanggal tersebut.
                </p>
            </div>
            <div style="background: rgba(0,0,0,0.1); padding: 15px 25px; border-radius: 20px; text-align: center; min-width: 100px; border: 2px solid rgba(0,0,0,0.15);">
                <div style="font-size: 32px; font-weight: 700; color: #333;">
                    <?php echo $selisihHari; ?>
                </div>
                <div style="font-size: 12px; color: #555;">HARI LAGI</div>
            </div>
        </div>
    </div>
    <?php elseif($isRegular): ?>
    <div style="background: #D1E8FF; padding: 25px; border-radius: 10px; margin-bottom: 25px; color: #1e40af; box-shadow: 0 4px 16px rgba(209, 232, 255, 0.4);">
        <div style="display: flex; align-items: center; gap: 20px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <div style="flex: 1;">
                <h3 style="margin: 0 0 8px 0; font-size: 22px;">Booking Reguler</h3>
                <p style="margin: 0; font-size: 15px;">
                    Film akan tayang pada <strong><?php echo date('l, d F Y', strtotime($tanggalTayang)); ?></strong> 
                    (<?php echo $selisihHari; ?> hari lagi).
                </p>
            </div>
        </div>
    </div>
    <?php elseif($isToday): ?>
    <div style="background: #0281AA; padding: 25px; border-radius: 10px; margin-bottom: 25px; color: white; box-shadow: 0 4px 16px rgba(2, 129, 170, 0.4);">
        <div style="display: flex; align-items: center; gap: 20px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M13.73 21a2 2 0 01-3.46 0"/>
                <path d="M18.63 13A17.888 17.888 0 0118 8"/>
                <path d="M6 26.35V4a2 2 0 012-2h8a2 2 0 012 2v21.35"/>
                <path d="M6 17h12"/>
            </svg>
            <div style="flex: 1;">
                <h3 style="margin: 0 0 8px 0; font-size: 22px;">Tayang Hari Ini!</h3>
                <p style="margin: 0; opacity: 0.95; font-size: 15px;">
                    Film ini tayang hari ini pada jam <?php echo date('H:i', strtotime($this->jadwal->jam_mulai)); ?> WIB. 
                    Segera booking sebelum tiket habis!
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="detail-container" style="grid-template-columns: 2fr 1fr;">
        <div>
            <div style="background: #f8f9fa; padding: 25px; border-radius: 10px; margin-bottom: 25px;">
                <h3 style="margin: 0 0 15px 0; color: #032541;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                        <line x1="7" y1="2" x2="7" y2="22"/>
                        <line x1="17" y1="2" x2="17" y2="22"/>
                        <line x1="2" y1="12" x2="22" y2="12"/>
                    </svg>
                    Informasi Film
                </h3>
                <p style="margin: 5px 0;"><strong>Film:</strong> <?php echo htmlspecialchars($this->jadwal->judul_film); ?></p>
                <p style="margin: 5px 0;"><strong>Bioskop:</strong> <?php echo htmlspecialchars($this->jadwal->nama_bioskop); ?></p>
                <p style="margin: 5px 0;"><strong>Lokasi:</strong> <?php echo htmlspecialchars($this->jadwal->kota); ?></p>
                <p style="margin: 5px 0;"><strong>Tanggal:</strong> 
                    <?php 
                    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    echo $hari[date('w', strtotime($this->jadwal->tanggal_tayang))]; 
                    ?>, <?php echo date('d F Y', strtotime($this->jadwal->tanggal_tayang)); ?>
                </p>
                <p style="margin: 5px 0;"><strong>Jam:</strong> <?php echo date('H:i', strtotime($this->jadwal->jam_mulai)); ?> - <?php echo date('H:i', strtotime($this->jadwal->jam_selesai)); ?> WIB</p>
                <p style="margin: 5px 0;"><strong>Harga per Tiket:</strong> <span style="color: #01b4e4; font-weight: 700;">Rp <?php echo number_format($this->jadwal->harga_tiket, 0, ',', '.'); ?></span></p>
            </div>

            <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 20px 0; color: #032541;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M5 9c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2H5z"/>
                        <path d="M5 9V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v3"/>
                    </svg>
                    Pilih Jumlah Tiket
                </h3>
                
                <!-- UPDATED: Submit to payment page -->
               <form method="POST" action="index.php?module=transaksi&action=konfirmasiPembayaran" id="bookingForm">
                <input type="hidden" name="id_jadwal" value="<?php echo $this->jadwal->id_tayang; ?>">
                
                <div class="form-group">
                    <label>Jumlah Tiket *</label>
                    <input type="number" id="jumlah_tiket" name="jumlah_tiket" min="1" max="10" value="1" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 16px;">
                    <small style="color: #666;">Kursi akan dipilih secara otomatis (Random)</small>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <label style="display: block; margin-bottom: 12px; font-weight: 600; color: #032541;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                        Pilih Metode Pembayaran *
                    </label>
                    
                    <div style="display: grid; gap: 12px;">
                        <!-- Transfer Bank -->
                        <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="payment-method" onclick="selectPayment(this)">
                            <input type="radio" name="metode_pembayaran" value="transfer" required style="margin-right: 12px; width: 18px; height: 18px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 12px;">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                            <div>
                                <strong style="display: block; color: #032541;">Transfer Bank</strong>
                                <small style="color: #666;">BCA, Mandiri, BNI, BRI</small>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="payment-method" onclick="selectPayment(this)">
                            <input type="radio" name="metode_pembayaran" value="e-wallet" required style="margin-right: 12px; width: 18px; height: 18px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 12px;">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                                <line x1="12" y1="18" x2="12.01" y2="18"/>
                            </svg>
                            <div>
                                <strong style="display: block; color: #032541;">E-Wallet</strong>
                                <small style="color: #666;">GoPay, OVO, Dana, ShopeePay</small>
                            </div>
                        </label>

                        <!-- E-Money -->
                        <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="payment-method" onclick="selectPayment(this)">
                            <input type="radio" name="metode_pembayaran" value="e-money" required style="margin-right: 12px; width: 18px; height: 18px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 12px;">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                                <circle cx="12" cy="13" r="2"/>
                            </svg>
                            <div>
                                <strong style="display: block; color: #032541;">E-Money</strong>
                                <small style="color: #666;">Flazz BCA, e-Money Mandiri, Brizzi</small>
                            </div>
                        </label>

                        <!-- M-Banking -->
                        <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="payment-method" onclick="selectPayment(this)">
                            <input type="radio" name="metode_pembayaran" value="m-banking" required style="margin-right: 12px; width: 18px; height: 18px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 12px;">
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                                <path d="M12 6h.01M9 11h6M9 15h6"/>
                            </svg>
                            <div>
                                <strong style="display: block; color: #032541;">M-Banking</strong>
                                <small style="color: #666;">BCA Mobile, Livin' by Mandiri, BRImo</small>
                            </div>
                        </label>

                        <!-- Kartu Kredit -->
                        <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="payment-method" onclick="selectPayment(this)">
                            <input type="radio" name="metode_pembayaran" value="kartu_kredit" required style="margin-right: 12px; width: 18px; height: 18px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 12px;">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                            <div>
                                <strong style="display: block; color: #032541;">Kartu Kredit</strong>
                                <small style="color: #666;">Visa, Mastercard, JCB</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div style="background: #fff3cd; border: 2px solid #ffc107; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                    <strong style="color: #856404;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Informasi Kursi:
                    </strong>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #856404;">
                        <li>Kursi akan dipilih secara RANDOM oleh sistem</li>
                        <li>Sistem akan memilih kursi terbaik yang tersedia</li>
                        <li>Kursi yang sudah terpesan: <?php echo count($kursiTerpesan); ?> kursi</li>
                        <li>Kursi tersedia: <?php echo (100 - count($kursiTerpesan)); ?> kursi</li>
                    </ul>
                </div>

                <?php if(!empty($kursiTerpesan)): ?>
                <div style="margin-bottom: 20px;">
                    <strong style="color: #dc3545;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="15" y1="9" x2="9" y2="15"/>
                            <line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                        Kursi Sudah Terpesan:
                    </strong>
                    <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px; max-height: 150px; overflow-y: auto; padding: 10px; background: #f8f9fa; border-radius: 5px;">
                        <?php foreach($kursiTerpesan as $kursi): ?>
                            <span style="padding: 5px 10px; background: #dc3545; color: white; border-radius: 5px; font-size: 12px;">
                                <?php echo htmlspecialchars($kursi); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 18px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                        Konfirmasi Pembayaran
                    </button>
                </div>
            </form>

            <script>
            function selectPayment(label) {
                // Remove selected class from all
                document.querySelectorAll('.payment-method').forEach(el => {
                    el.style.borderColor = '#e0e0e0';
                    el.style.background = 'white';
                });
                
                // Add to selected
                label.style.borderColor = '#01b4e4';
                label.style.background = '#f0f9ff';
            }
            </script>


            


<?php require_once 'views/layouts/footer.php'; ?>