<?php
$page_title = "Admin Login - Delight Home";
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Redirect if already logged in as admin
if (isAdmin()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

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
            
            if ($user['is_admin'] == 1) {
                if ($password === $user['password'] || password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['is_admin'] = 1;
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = 'Invalid admin email or password';
                }
            } else {
                $error = 'Access denied. Account is not authorized for Admin access.';
            }
        } else {
            $error = 'Invalid admin email or password';
        }
    }
}

include '../includes/header.php';
?>

<!-- Admin Page Header -->
<section style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 50px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.2rem; color: var(--brown); margin-bottom: 0.5rem;">
            <i class="fas fa-user-shield"></i> Admin Portal
        </h1>
        <p style="color: var(--text-light);">Management Portal Access for Delight Home Administrators</p>
    </div>
</section>

<!-- Admin Login Form -->
<section class="section" style="padding: 40px 0 80px 0;">
    <div class="container">
        <div style="max-width: 420px; margin: 0 auto;">
            <div class="card" style="padding: 2.5rem; border-radius: 12px; box-shadow: var(--shadow-lg); background-color: #ffffff;">
                
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <span style="display: inline-block; background-color: var(--secondary-bg); width: 60px; height: 60px; line-height: 60px; border-radius: 50%; color: var(--brown); font-size: 1.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-lock"></i>
                    </span>
                    <h2 style="font-size: 1.4rem; color: var(--brown); margin: 0;">Admin Sign In</h2>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">Admin Email Address *</label>
                        <input
                            type="email"
                            name="email"
                            class="form-input"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                            required
                            placeholder="admin@delighthome.com"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password *</label>

                        <div style="position: relative;">
                            <input
                                type="password"
                                name="password"
                                id="admin_password"
                                class="form-input"
                                required
                                placeholder="••••••••"
                                style="padding-right: 45px;"
                            >

                            <i
                                class="fas fa-eye"
                                onclick="togglePassword('admin_password', this)"
                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-light);"
                            ></i>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="width: 100%; padding: 0.9rem; font-size: 1rem; margin-top: 0.5rem;">
                        <i class="fas fa-sign-in-alt"></i> Login to Admin Panel
                    </button>
                </form>

                <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">

                <div style="background-color: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 1rem; border-radius: 8px; font-size: 0.88rem;">
                    <strong><i class="fas fa-info-circle"></i> Demo Admin Credentials:</strong><br>
                    Email: <strong>admin@delighthome.com</strong><br>
                    Password: <strong>admin123</strong>
                </div>

                <div style="text-align: center; margin-top: 1.5rem;">
                    <a href="../index.php" style="color: var(--brown); font-weight: 600; font-size: 0.9rem; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Return to Storefront
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

<?php // include '../includes/footer.php'; ?>