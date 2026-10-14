<?php
$page_title = "Manage Messages - Admin";
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Handle message actions
$action = $_GET['action'] ?? '';
$message_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($action == 'mark_read' && $message_id) {
    $conn->query("UPDATE contact_messages SET status = 'Read' WHERE id = $message_id");
    header('Location: messages.php');
    exit;
} elseif ($action == 'delete' && $message_id) {
    $conn->query("DELETE FROM contact_messages WHERE id = $message_id");
    header('Location: messages.php');
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
.message-status { display: inline-block; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600; }
.status-new { background-color: #cfe2ff; color: #084298; }
.status-read { background-color: #e2e3e5; color: #383d41; }
</style>

<div class="admin-container">
    <aside class="admin-sidebar">
        <h3><i class="fas fa-th-large"></i> Admin Panel</h3>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="products.php">Products</a>
            <a href="categories.php">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="users.php">Users</a>
            <a href="messages.php" class="active">Messages</a>
            <a href="../logout.php" onclick="showLogoutModal(event)" style="color: #ff6b6b;">Logout</a>
        </nav>
    </aside>

    <main class="admin-main">
        <h1 style="color: var(--brown); margin-top: 0;">Contact Messages</h1>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
                while ($msg = $messages->fetch_assoc()):
                    $status_class = 'status-' . strtolower($msg['status']);
                ?>
                <tr>
                    <td><?php echo $msg['id']; ?></td>
                    <td><?php echo $msg['name']; ?></td>
                    <td><?php echo $msg['email']; ?></td>
                    <td><?php echo substr($msg['subject'], 0, 40); ?></td>
                    <td><span class="message-status <?php echo $status_class; ?>"><?php echo $msg['status']; ?></span></td>
                    <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                    <td>
                        <a href="#" onclick="viewMessage(<?php echo htmlspecialchars(json_encode($msg)); ?>)" class="btn btn-small" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">View</a>
                        <a href="messages.php?action=delete&id=<?php echo $msg['id']; ?>" class="btn btn-small" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; background-color: #dc3545;" onclick="return confirm('Delete this message?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</div>

<div id="messageModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 0 30px rgba(0,0,0,0.2); z-index: 1000; max-width: 600px; max-height: 80vh; overflow-y: auto;">
    <button onclick="closeMessage()" style="float: right; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
    <div id="messageContent"></div>
</div>
<div id="messageOverlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;" onclick="closeMessage()"></div>

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
        <h2 style="color: var(--brown); margin-top: 0;">Logout</h2>
        <p style="margin-bottom: 1.5rem; color: var(--text-dark);">
            Do you want to logout?
        </p>
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <button type="button" onclick="confirmLogout()" class="btn">Yes</button>
            <button type="button" onclick="closeLogoutModal()" class="btn btn-secondary">No</button>
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

function viewMessage(message) {
    const modal = document.getElementById('messageModal');
    const overlay = document.getElementById('messageOverlay');
    const content = document.getElementById('messageContent');

    content.innerHTML = `
        <h2 style="color: var(--brown); margin-top: 0;">${message.subject}</h2>
        <p><strong>From:</strong> ${message.name}</p>
        <p><strong>Email:</strong> ${message.email}</p>
        <p><strong>Phone:</strong> ${message.phone}</p>
        <p><strong>Date:</strong> ${new Date(message.created_at).toLocaleDateString()}</p>
        <hr>
        <p><strong>Message:</strong></p>
        <p style="line-height: 1.8; white-space: pre-wrap;">${message.message}</p>
    `;

    modal.style.display = 'block';
    overlay.style.display = 'block';
}

function closeMessage() {
    document.getElementById('messageModal').style.display = 'none';
    document.getElementById('messageOverlay').style.display = 'none';
}
</script>

</body>
</html>
