<?php
$page_title = "Manage Users - Admin";
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

include '../includes/header.php';
?>

<style>
.admin-container { display: grid; grid-template-columns: 200px 1fr; min-height: 100vh; }
.admin-sidebar { background-color: #2a2a2a; color: white; padding: 2rem 0; position: sticky; top: 0; }
.admin-sidebar h3 { padding: 0 1.5rem; margin-bottom: 2rem; }
.admin-sidebar a { display: block; padding: 1rem 1.5rem; color: #ddd; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; }
.admin-sidebar a:hover, .admin-sidebar a.active { background-color: var(--brown); border-left-color: white; color: white; }
.admin-main { padding: 2rem; background-color: var(--primary-bg); }
.admin-table { width: 100%; border-collapse: collapse; background-color: white; box-shadow: var(--shadow); border-radius: 8px; overflow: hidden; margin-top: 1.5rem; }
.admin-table th { background-color: var(--brown); color: white; padding: 1rem; text-align: left; font-weight: 600; }
.admin-table td { padding: 1rem; border-bottom: 1px solid var(--border-color); }
</style>

<div class="admin-container">
    <aside class="admin-sidebar">
        <h3><i class="fas fa-th-large"></i> Admin Panel</h3>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="products.php">Products</a>
            <a href="categories.php">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="users.php" class="active">Users</a>
            <a href="messages.php">Messages</a>
            <a href="../logout.php" onclick="showLogoutModal(event)" style="color: #ff6b6b;">Logout</a>
        </nav>
    </aside>
    
    <main class="admin-main">
        <h1 style="color: var(--brown); margin-top: 0;">Manage Users</h1>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = $conn->query("SELECT * FROM users WHERE is_admin = 0 ORDER BY created_at DESC");
                while ($user = $users->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['phone'] ?? '-'; ?></td>
                    <td><?php echo $user['city'] ?? '-'; ?></td>
                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" style="
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 9999;
">
    <div style="
        background: white;
        width: 90%;
        max-width: 400px;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    ">
        <h2 style="color: var(--brown); margin-top: 0;">
            Logout
        </h2>

        <p style="margin-bottom: 1.5rem; color: var(--text-dark);">
            Do you want to logout?
        </p>

        <div style="
            display: flex;
            justify-content: center;
            gap: 1rem;
        ">
            <button
                type="button"
                onclick="confirmLogout()"
                class="btn"
            >
                Yes
            </button>

            <button
                type="button"
                onclick="closeLogoutModal()"
                class="btn btn-secondary"
            >
                No
            </button>
        </div>
    </div>
</div>

<script>
function showLogoutModal(event) {
    event.preventDefault();
    document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}

function confirmLogout() {
    window.location.href = '../logout.php';
}
</script>

</body>
</html>
