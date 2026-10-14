<?php
$page_title = "Customer Login - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';

$redirect = sanitize($_GET['redirect'] ?? $_POST['redirect'] ?? '');
$msg = $_GET['msg'] ?? '';

// Redirect if already logged in
if (isLoggedIn()) {
    if ($redirect === 'checkout.php') {
        header('Location: checkout.php');
    } else {
        header('Location: index.php');
    }
    exit;
}

$error = '';
if ($msg === 'login_required') {
    $error = 'Please login or create an account to place an order.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        $email_escaped = $conn->real_escape_string($email);
        $result = $conn->query("SELECT id, password, is_admin FROM users WHERE email = '$email_escaped'");
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['password'] || password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                // Migrate guest cart items to logged-in user
                $sid = session_id();
                $conn->query("UPDATE cart SET user_id = {$user['id']}, session_id = NULL WHERE session_id = '$sid'");
                
                if ($redirect === 'checkout.php') {
                    header('Location: checkout.php');
                } else {
                    header('Location: index.php');
                }
                exit;
            } else {
                $error = 'Invalid email or password';
            }
        } else {
            $error = 'Invalid email or password';
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Page Header -->
<section style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 50px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.2rem; color: var(--brown); margin-bottom: 0.5rem;">Welcome Back</h1>
        <p style="color: var(--text-light);">Log in to manage your orders, wishlist, and profile</p>
    </div>
</section>

<!-- Customer Login Form -->
<section class="section">
    <div class="container">
        <div style="max-width: 420px; margin: 0 auto;">
            <div class="card" style="padding: 2.5rem; border-radius: 12px; box-shadow: var(--shadow-lg);">
                <?php if ($error): ?>
                    <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <?php if ($redirect): ?>
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-input" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required placeholder="you@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-input" required placeholder="••••••••">
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin: 0; cursor: pointer;">
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                    </div>
                    
                    <button type="submit" class="btn" style="width: 100%; padding: 0.9rem; font-size: 1rem;">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
                
                <p style="text-align: center; margin: 0; font-size: 0.95rem;">
                    Don't have an account? 
                    <a href="signup.php<?php echo $redirect ? '?redirect=' . urlencode($redirect) : ''; ?>" style="color: var(--brown); font-weight: 600;">
                        Create Account
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
