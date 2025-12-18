<?php
// controllers/UserController.php - WITH DATE VALIDATION

require_once 'config/database.php';
require_once 'models/BaseModel.php';
require_once 'models/User.php';
require_once 'models/Transaksi.php';

class UserController {
    private $db;
    private $user;
    private $transaksi;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
        $this->transaksi = new Transaksi($this->db);
    }

    public function dashboard() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?module=auth&action=index");
            exit();
        }

        $this->user->id_user = $_SESSION['user_id'];
        $this->user->readOne();
        
        $stmt = $this->transaksi->readByUser($_SESSION['user_id']);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/user/dashboard.php';
    }

    public function profile() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?module=auth&action=index");
            exit();
        }

        $this->user->id_user = $_SESSION['user_id'];
        $this->user->readOne();
        
        require_once 'views/user/profile.php';
    }

    public function updateProfile() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: index.php?module=user&action=dashboard");
            exit();
        }

        $this->user->id_user = $_SESSION['user_id'];
        $this->user->username = trim($_POST['username']);
        $this->user->email = trim($_POST['email']);
        $this->user->nama_lengkap = trim($_POST['nama_lengkap']);
        $this->user->no_telpon = trim($_POST['no_telpon']);
        $this->user->tanggal_lahir = $_POST['tanggal_lahir'];
        $this->user->alamat = $_POST['alamat'];

        // VALIDASI BASIC
        if(empty($this->user->username) || empty($this->user->email) || empty($this->user->nama_lengkap)) {
            $_SESSION['flash'] = 'Username, email, dan nama lengkap wajib diisi!';
            header("Location: index.php?module=user&action=profile");
            exit();
        }

        // VALIDASI TANGGAL LAHIR
        if(!empty($this->user->tanggal_lahir)) {
            $today = date('Y-m-d');
            $inputDate = $this->user->tanggal_lahir;
            
            // CEK TIDAK BOLEH MELEBIHI HARI INI
            if($inputDate > $today) {
                $_SESSION['flash'] = 'Tanggal lahir tidak boleh melebihi hari ini!';
                header("Location: index.php?module=user&action=profile");
                exit();
            }
            
            // VALIDASI UMUR MINIMAL (Opsional - minimal 13 tahun)
            $birthDate = new DateTime($this->user->tanggal_lahir);
            $todayDate = new DateTime($today);
            $age = $todayDate->diff($birthDate)->y;
            
            if($age < 13) {
                $_SESSION['flash'] = 'Anda harus berusia minimal 13 tahun!';
                header("Location: index.php?module=user&action=profile");
                exit();
            }
        }

        // Check uniqueness
        if($this->user->usernameExists($_POST['username'], $_SESSION['user_id'])) {
            $_SESSION['flash'] = 'Username sudah digunakan!';
            header("Location: index.php?module=user&action=profile");
            exit();
        }

        if($this->user->emailExists($_POST['email'], $_SESSION['user_id'])) {
            $_SESSION['flash'] = 'Email sudah digunakan!';
            header("Location: index.php?module=user&action=profile");
            exit();
        }

        if($this->user->update()) {
            $_SESSION['user_name'] = $_POST['nama_lengkap'];
            $_SESSION['flash'] = 'Profile berhasil diupdate!';
            
            header("Location: index.php?module=user&action=dashboard");
            exit();
        } else {
            $_SESSION['flash'] = 'Gagal update profile!';
            header("Location: index.php?module=user&action=profile");
            exit();
        }
    }

    public function riwayat() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?module=auth&action=index");
            exit();
        }

        $stmt = $this->transaksi->readByUser($_SESSION['user_id']);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/user/riwayat.php';
    }

    public function detailTiket() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            header("Location: index.php?module=user&action=dashboard");
            exit();
        }

        $this->transaksi->id_transaksi = $_GET['id'];
        $transaksi = $this->transaksi->readOne();
        
        if(!$transaksi || $transaksi['id_user'] != $_SESSION['user_id']) {
            header("Location: index.php?module=user&action=dashboard");
            exit();
        }

        $detailTransaksi = $this->transaksi->getDetailWithTickets($_GET['id']);
        
        require_once 'views/user/detail_tiket.php';
    }
    
    public function gantiPassword() {
        header('Location: index.php?module=auth&action=gantiPasswordUser');
        exit();
    }
}
?>