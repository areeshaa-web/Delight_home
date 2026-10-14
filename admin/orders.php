<?php
$page_title = "Manage Orders - Admin";
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Get order ID
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $order_id) {
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE orders SET status = '$status' WHERE id = $order_id");
    $message = 'Order status updated';
}

include '../includes/header.php';
?>

<style>
.admin-container {
    display: grid;
    grid-template-columns: 200px 1fr;
    min-height: 100vh;
}

.admin-sidebar {
    background-color: #2a2a2a;
    color: white;
    padding: 2rem 0;
    position: sticky;
    top: 0;
}

.admin-sidebar h3 {
    padding: 0 1.5rem;
    margin-bottom: 2rem;
}

.admin-sidebar a {
    display: block;
    padding: 1rem 1.5rem;
    color: #ddd;
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.admin-sidebar a:hover,
.admin-sidebar a.active {
    background-color: var(--brown);
    border-left-color: white;
    color: white;
}

.admin-main {
    padding: 2rem;
    background-color: var(--primary-bg);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: var(--shadow);
    border-radius: 8px;
    overflow: hidden;
    margin-top: 1.5rem;
}

.admin-table th {
    background-color: var(--brown);
    color: white;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.status-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-pending { background-color: #fff3cd; color: #856404; }
.status-processing { background-color: #cfe2ff; color: #084298; }
.status-shipped { background-color: #cfe2ff; color: #084298; }
.status-delivered { background-color: #d1e7dd; color: #0f5132; }
.status-cancelled { background-color: #f8d7da; color: #842029; }
</style>

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <h3><i class="fas fa-th-large"></i> Admin Panel</h3>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="products.php">Products</a>
            <a href="categories.php">Categories</a>
            <a href="orders.php" class="active">Orders</a>
            <a href="users.php">Users</a>
            <a href="messages.php">Messages</a>
            <a href="../logout.php" onclick="showLogoutModal(event)" style="color: #ff6b6b;">Logout</a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <h1 style="color: var(--brown); margin-top: 0;">Manage Orders</h1>
        
        <?php if ($order_id): ?>
            <!-- Order Details -->
            <?php
            $order = getOrder($order_id);
            $order_items = getOrderItems($order_id);
            $customer = $conn->query("SELECT * FROM users WHERE id = " . $order['user_id'])->fetch_assoc();
            ?>
            
            <div class="card" style="padding: 2rem;">
                <h2 style="margin-top: 0; color: var(--brown);">Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <h4>Customer Information</h4>
                        <p><strong><?php echo $customer['name']; ?></strong></p>
                        <p>Email: <?php echo $customer['email']; ?></p>
                        <p>Phone: <?php echo $customer['phone']; ?></p>
                        <p>Address: <?php echo $customer['address']; ?>, <?php echo $customer['city']; ?></p>
                    </div>
                    <div>
                        <h4>Order Status</h4>
                        <form method="POST">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?php echo $order['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </form>
                    </div>
                </div>
                
                <h4>Order Items</h4>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo formatPrice($item['price']); ?></td>
                            <td><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div style="margin-top: 2rem; text-align: right;">
                    <h4 style="font-size: 1.5rem; color: var(--brown);">Total: <?php echo formatPrice($order['total_amount']); ?></h4>
                </div>
                
                <a href="orders.php" class="btn" style="margin-top: 2rem;">Back to Orders</a>
            </div>
            
        <?php else: ?>
            <!-- Orders List -->
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
                    while ($order = $orders->fetch_assoc()):
                        $customer = $conn->query("SELECT name FROM users WHERE id = " . $order['user_id'])->fetch_assoc();
                        $status_class = 'status-' . strtolower($order['status']);
                    ?>
                    <tr>
                        <td>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo $customer['name'] ?? 'Unknown'; ?></td>
                        <td><?php echo formatPrice($order['total_amount']); ?></td>
                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $order['status']; ?></span></td>
                        <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                        <td><a href="orders.php?id=<?php echo $order['id']; ?>" class="btn btn-small" style="padding: 0.4rem 0.8rem;">View</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
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

        <h2 style="
            color: var(--brown);
            margin-top: 0;
            margin-bottom: 0.75rem;
        ">
            Logout
        </h2>

        <p style="
            margin-bottom: 1.5rem;
            color: var(--text-dark);
        ">
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
