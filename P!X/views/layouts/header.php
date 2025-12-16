<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P!X - Sistem Bioskop</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Dropdown Menu Styles - WORKING VERSION */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .nav-dropdown-btn {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border: none;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .nav-dropdown-btn:hover {
            background: rgba(255,255,255,0.25);
        }
        
        .nav-dropdown.show .nav-dropdown-btn {
            background: rgba(255,255,255,0.25);
        }
        
        .dropdown-arrow {
            transition: transform 0.3s;
            display: inline-block;
        }
        
        .nav-dropdown.show .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        .nav-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            background: white;
            min-width: 250px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border-radius: 10px;
            overflow: hidden;
            z-index: 99999;
        }
        
        .nav-dropdown.show .nav-dropdown-menu {
            display: block;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-menu-header {
            background: linear-gradient(135deg, #032541 0%, #01b4e4 100%);
            color: white;
            padding: 20px;
        }
        
        .dropdown-menu-header h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .dropdown-menu-header p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }
        
        .dropdown-menu-item {
            display: block;
            padding: 15px 20px;
            color: #032541;
            text-decoration: none;
            transition: all 0.2s;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            font-weight: 500;
        }
        
        .dropdown-menu-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-menu-item:hover {
            background: #f8f9fa;
            padding-left: 25px;
            color: #01b4e4;
        }
        
        .dropdown-menu-item.logout {
            color: #dc3545;
            font-weight: 600;
        }
        
        .dropdown-menu-item.logout:hover {
            background: #fff5f5;
            color: #c82333;
        }
        
        .dropdown-menu-item svg {
            vertical-align: middle;
            margin-right: 10px;
        }
        
        /* Overlay */
        .dropdown-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 99998;
            background: transparent;
        }
        
        .dropdown-overlay.show {
            display: block;
        }
    </style>
</head>
<body>
<!-- Overlay -->
<div class="dropdown-overlay" id="dropdownOverlay"></div>

<!-- Navbar -->
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php?module=film" class="nav-brand">P!X</a>
        <div class="nav-actions">
            <div class="nav-menu">
                <?php
                if(session_status() == PHP_SESSION_NONE) session_start();
                
                if(isset($_SESSION['admin_id'])):
                ?>
                    <a href="index.php?module=film">🎬 Film</a>
                    <a href="index.php?module=bioskop">🏢 Bioskop</a>
                    <a href="index.php?module=jadwal">📅 Jadwal</a>
                <?php 
                elseif(isset($_SESSION['user_id'])):
                ?>
                    <a href="index.php?module=film">🎬 Film</a>
                <?php 
                else:
                ?>
                    <a href="index.php?module=film">🎬 Film</a>
                <?php endif; ?>
            </div>
            
            <div class="nav-right">
            <?php if(isset($_SESSION['admin_id'])): ?>
                <!-- Admin Dropdown -->
                <div class="nav-dropdown" id="adminDropdown">
                    <button class="nav-dropdown-btn" type="button" onclick="toggleDropdown('adminDropdown')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>Admin</span>
                        <span class="dropdown-arrow">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </span>
                    </button>
                    <div class="nav-dropdown-menu">
                        <div class="dropdown-menu-header">
                            <h4><?php echo htmlspecialchars($_SESSION['admin_name'] ?? $_SESSION['admin_username']); ?></h4>
                            <p>Administrator</p>
                        </div>
                        <a href="index.php?module=admin&action=dashboard" class="dropdown-menu-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="index.php?module=auth&action=gantiPasswordAdmin" class="dropdown-menu-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Ganti Password
                        </a>
                        <a href="index.php?module=auth&action=logout" class="dropdown-menu-item logout" onclick="return confirm('Yakin ingin logout?')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            <?php elseif(isset($_SESSION['user_id'])): ?>
                <!-- User Dropdown -->
                <div class="nav-dropdown" id="userDropdown">
                    <button class="nav-dropdown-btn" type="button" onclick="toggleDropdown('userDropdown')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span><?php echo htmlspecialchars($_SESSION['user_username']); ?></span>
                        <span class="dropdown-arrow">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </span>
                    </button>
                    <div class="nav-dropdown-menu">
                        <div class="dropdown-menu-header">
                            <h4><?php echo htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['user_username']); ?></h4>
                            <p>Member</p>
                        </div>
                        <a href="index.php?module=user&action=dashboard" class="dropdown-menu-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="index.php?module=user&action=riwayat" class="dropdown-menu-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                            Riwayat Tiket
                        </a>
                        <a href="index.php?module=auth&action=gantiPasswordUser" class="dropdown-menu-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Ganti Password
                        </a>
                        <a href="index.php?module=auth&action=logout" class="dropdown-menu-item logout" onclick="return confirm('Yakin ingin logout?')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="index.php?module=auth&action=index" class="btn-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Login
                </a>
                <a href="index.php?module=auth&action=register" class="btn-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Daftar
                </a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
    
<?php
// Toast notification
if(isset($_SESSION['flash'])) {
    $msg = htmlspecialchars($_SESSION['flash']);
    echo "<div class=\"toast toast-success\" id=\"toast\">";
    echo "<div class=\"toast-body\">$msg</div>";
    echo "<button class=\"toast-close\" aria-label=\"Tutup\">&times;</button>";
    echo "</div>";
    unset($_SESSION['flash']);
}
if(isset($_GET['error'])) {
    $err = htmlspecialchars($_GET['error']);
    echo "<div class=\"toast toast-error\" id=\"toast\">";
    echo "<div class=\"toast-body\">$err</div>";
    echo "<button class=\"toast-close\" aria-label=\"Tutup\">&times;</button>";
    echo "</div>";
}
?>

<script>
// Toast notification
(function(){
    var t = document.getElementById('toast');
    if(!t) return;
    function hideToast(){ t.classList.remove('show'); setTimeout(function(){ t.remove(); }, 400); }
    setTimeout(hideToast, 3500);
    var btn = t.querySelector('.toast-close');
    if(btn) btn.addEventListener('click', hideToast);
    setTimeout(function(){ t.classList.add('show'); }, 50);
})();

// Dropdown Toggle - SIMPLE & WORKING
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const overlay = document.getElementById('dropdownOverlay');
    const allDropdowns = document.querySelectorAll('.nav-dropdown');
    
    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== id) {
            d.classList.remove('show');
        }
    });
    
    // Toggle current dropdown
    if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        overlay.classList.remove('show');
    } else {
        dropdown.classList.add('show');
        overlay.classList.add('show');
    }
}

// Close dropdown when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('dropdownOverlay');
    
    overlay.addEventListener('click', function() {
        document.querySelectorAll('.nav-dropdown').forEach(d => {
            d.classList.remove('show');
        });
        overlay.classList.remove('show');
    });
    
    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.nav-dropdown').forEach(d => {
                d.classList.remove('show');
            });
            overlay.classList.remove('show');
        }
    });
});
</script>
</body>
</html>