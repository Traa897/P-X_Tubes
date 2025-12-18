<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="max-width: 600px; margin-top: 50px;">
    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 30px;">Daftar Akun Baru</h2>

        <?php if(isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?module=auth&action=register" class="movie-form">
            <div class="form-group">
                <label>Username *</label>
                <input type="text" name="username" required placeholder="Pilih username unik">
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" minlength="6">
            </div>

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" required placeholder="Nama lengkap Anda">
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input type="tel" name="no_telpon" placeholder="08xx-xxxx-xxxx">
            </div>

           <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" max="<?php echo date('Y-m-d'); ?>">
            <small style="color: #666; display: block; margin-top: 5px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                Tanggal lahir tidak boleh melebihi hari ini
            </small>
        </div>

        <script>
        document.getElementById('tanggal_lahir').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if(selectedDate > today) {
                alert('❌ Tanggal lahir tidak boleh melebihi hari ini!');
                this.value = '';
            }
        });
        </script>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="2" placeholder="Alamat lengkap (opsional)"></textarea>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">✅ Daftar Sekarang</button>
            </div>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Sudah punya akun? <a href="index.php?module=auth&action=index" style="color: #01b4e4; font-weight: 600;">Login di sini</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>