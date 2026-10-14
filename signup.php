<?php
include 'includes/db.php';
$page_title = "Sign Up - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';

$redirect = sanitize($_GET['redirect'] ?? $_POST['redirect'] ?? '');

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
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required';
    } elseif (!isValidEmail($email)) {
        $error = 'Please enter a valid email address';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Check if email already exists
        $email_escaped = $conn->real_escape_string($email);
        $check = $conn->query("SELECT id FROM users WHERE email = '$email_escaped'");
        
        if ($check->num_rows > 0) {
            $error = 'Email already registered. Please login or use a different email.';
        } else {
            $name_escaped = $conn->real_escape_string($name);
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $conn->query("INSERT INTO users (name, email, password) VALUES ('$name_escaped', '$email_escaped', '$hashed_password')");
            $user_id = $conn->insert_id;
            
            $_SESSION['user_id'] = $user_id;
            $_SESSION['is_admin'] = 0;
            
            // Migrate guest cart items to newly registered user
            $sid = session_id();
            $conn->query("UPDATE cart SET user_id = $user_id, session_id = NULL WHERE session_id = '$sid'");
            
            if ($redirect === 'checkout.php') {
                header('Location: checkout.php');
            } else {
                header('Location: index.php');
            }
            exit;
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Page Header -->
<section style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 60px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;">Create Account</h1>
    </div>
</section>

<!-- Signup Form -->
<section class="section">
    <div class="container">
        <div style="max-width: 400px; margin: 0 auto;">
            <div class="card" style="padding: 2rem;">
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <?php if ($redirect): ?>
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" required>
                        <small style="color: var(--text-lighter);">At least 6 characters</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-input" required>
                    </div>
                    
                    <button type="submit" class="btn" style="width: 100%;">Create Account</button>
                </form>
                
                <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border-color);">
                
                <p style="text-align: center;">
                    Already have an account? <a href="login.php<?php echo $redirect ? '?redirect=' . urlencode($redirect) : ''; ?>" style="color: var(--brown); font-weight: 600;">Login here</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
