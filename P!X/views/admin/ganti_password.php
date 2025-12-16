<?php require_once 'views/layouts/header.php'; ?>

<style>
    .password-container {
        max-width: 480px;
        margin: 2rem auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e8e8e8;
        overflow: hidden;
    }
    
    .password-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #317CA3 0%, #2a6c8f 100%);
        color: white;
        text-align: center;
    }
    
    .password-header h1 {
        margin: 0 0 0.5rem 0;
        font-size: 1.6rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .password-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    
    .password-form {
        padding: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s;
        background-color: #f9fafb;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #317CA3;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(49, 124, 163, 0.1);
    }
    
    .input-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #8c95a6;
    }
    
    .input-wrapper {
        position: relative;
    }
    
    .required-star {
        color: #ef4444;
    }
    
    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f0f2f5;
    }
    
    .btn-primary {
        flex: 1;
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, #317CA3 0%, #2a6c8f 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(49, 124, 163, 0.3);
    }
    
    .btn-secondary {
        flex: 1;
        padding: 0.75rem 1.25rem;
        background: white;
        color: #4b5563;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
        text-align: center;
    }
    
    .btn-secondary:hover {
        background-color: #f9fafb;
        border-color: #317CA3;
        color: #317CA3;
    }
    
    .alert-error {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: #fef2f2;
        border-radius: 8px;
        color: #dc2626;
        margin: 1rem 1.5rem;
        border-left: 4px solid #dc2626;
    }
</style>

<div class="password-container">
    <div class="password-header">
        <h1>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Ganti Password Admin
        </h1>
        <p>Kelola keamanan akun administrator</p>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="password-form">
        <form method="POST" action="index.php?module=auth&action=gantiPasswordAdmin">
            <div class="form-group">
                <label for="password_lama" class="form-label">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 11-7.778 7.778 5.5 5.5 0 017.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
                    </svg>
                    Password Lama
                    <span class="required-star">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="password" id="password_lama" name="password_lama" required 
                           placeholder="Masukkan password lama" class="form-input">
                    <div class="input-icon">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password_baru" class="form-label">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Password Baru
                    <span class="required-star">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="password" id="password_baru" name="password_baru" required 
                           minlength="6" placeholder="Minimal 6 karakter" class="form-input">
                    <div class="input-icon">
                    
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="konfirmasi_password" class="form-label">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Konfirmasi Password Baru
                    <span class="required-star">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" required 
                           minlength="6" placeholder="Ulangi password baru" class="form-input">
                    <div class="input-icon">
                        
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <path d="M17 21v-8H7v8M7 3v5h8"/>
                    </svg>
                    Ubah Password
                </button>
                <a href="index.php?module=admin&action=dashboard" class="btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>