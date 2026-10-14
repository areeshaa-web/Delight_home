<?php
$page_title = "Change Password - Delight Home";

require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check empty fields
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    }

    // Check new password length
    elseif (strlen($new_password) < 8) {
        $error = 'New password must be at least 8 characters long.';
    }

    // Check password confirmation
    elseif ($new_password !== $confirm_password) {
        $error = 'New password and confirm password do not match.';
    }

    else {

        $user_id = intval($_SESSION['user_id']);

        // Get current password
        $result = $conn->query("SELECT password FROM users WHERE id = $user_id");

        if ($result && $result->num_rows > 0) {

            $user = $result->fetch_assoc();
            $stored_password = $user['password'];

            // Verify current password
            if ($current_password === $stored_password || password_verify($current_password, $stored_password)) {

                // Hash new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed_password, $user_id);

                if ($stmt->execute()) {
                    $success = 'Password changed successfully!';
                } else {
                    $error = 'Unable to change password. Please try again.';
                }

                $stmt->close();

            } else {
                $error = 'Current password is incorrect.';
            }

        } else {
            $error = 'Admin account not found.';
        }
    }
}

include '../includes/header.php';
?>

<!-- Admin Page Header -->
<section style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 50px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.2rem; color: var(--brown); margin-bottom: 0.5rem;">
            <i class="fas fa-key"></i> Change Password
        </h1>
        <p style="color: var(--text-light);">
            Update your Admin Panel password
        </p>
    </div>
</section>

<!-- Change Password Form -->
<section class="section" style="padding: 40px 0 80px 0;">
    <div class="container">

        <div style="max-width: 450px; margin: 0 auto;">

            <div class="card" style="padding: 2.5rem; border-radius: 12px; box-shadow: var(--shadow-lg); background-color: #ffffff;">

                <?php if ($error): ?>
                    <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <!-- Current Password -->
                    <div class="form-group">
                        <label class="form-label">Current Password *</label>

                        <div style="position: relative;">
                            <input
                                type="password"
                                name="current_password"
                                id="current_password"
                                class="form-input"
                                required
                                placeholder="Enter current password"
                                style="padding-right: 45px;"
                            >

                            <i
                                class="fas fa-eye"
                                onclick="togglePassword('current_password', this)"
                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-light);"
                            ></i>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label class="form-label">New Password *</label>

                        <div style="position: relative;">
                            <input
                                type="password"
                                name="new_password"
                                id="new_password"
                                class="form-input"
                                required
                                minlength="8"
                                placeholder="Enter new password"
                                style="padding-right: 45px;"
                            >

                            <i
                                class="fas fa-eye"
                                onclick="togglePassword('new_password', this)"
                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-light);"
                            ></i>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group">
                        <label class="form-label">Confirm New Password *</label>

                        <div style="position: relative;">
                            <input
                                type="password"
                                name="confirm_password"
                                id="confirm_password"
                                class="form-input"
                                required
                                minlength="8"
                                placeholder="Confirm new password"
                                style="padding-right: 45px;"
                            >

                            <i
                                class="fas fa-eye"
                                onclick="togglePassword('confirm_password', this)"
                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-light);"
                            ></i>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="btn"
                        style="width: 100%; padding: 0.9rem; font-size: 1rem; margin-top: 0.5rem;"
                    >
                        <i class="fas fa-save"></i> Change Password
                    </button>

                </form>

                <div style="text-align: center; margin-top: 1.5rem;">
                    <a
                        href="dashboard.php"
                        style="color: var(--brown); font-weight: 600; font-size: 0.9rem; text-decoration: none;"
                    >
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
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

<?php include '../includes/footer.php'; ?>