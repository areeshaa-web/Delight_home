<?php
$page_title = "Admin Dashboard - Delight Home";
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check if admin
if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Get dashboard stats
$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_users = $conn->query("SELECT COUNT(*) as count FROM users WHERE is_admin = 0")->fetch_assoc()['count'];
$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$total_sales = $conn->query("SELECT SUM(total_amount) as total FROM orders")->fetch_assoc()['total'] ?? 0;
$pending_messages = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'New'")->fetch_assoc()['count'];

// Recent orders
$recent_orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

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
    max-height: 100vh;
    overflow-y: auto;
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

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    background-color: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: var(--shadow);
}

.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background-color: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: var(--shadow);
    border-left: 4px solid var(--brown);
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--brown);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-light);
    font-size: 0.9rem;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: var(--shadow);
    border-radius: 8px;
    overflow: hidden;
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

.admin-table tr:hover {
    background-color: var(--secondary-bg);
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

        <h3>
            <i class="fas fa-th-large"></i> Admin Panel
        </h3>

        <nav>

            <a href="dashboard.php" class="active">
                Dashboard
            </a>

            <a href="products.php">
                Products
            </a>

            <a href="categories.php">
                Categories
            </a>

            <a href="orders.php">
                Orders
            </a>

            <a href="users.php">
                Users
            </a>

            <a href="messages.php">
                Messages
            </a>

            <!-- Logout -->
            <a
                href="../logout.php"
                onclick="showLogoutModal(event)"
                style="color: #ff6b6b;"
            >
                Logout
            </a>

        </nav>

    </aside>


    <!-- Main Content -->
    <main class="admin-main">

        <div class="admin-header">

            <h1 style="font-size: 2rem; color: var(--brown);">
                Dashboard
            </h1>

            <div style="text-align: right;">

                <p style="
                    margin: 0;
                    color: var(--text-light);
                    font-size: 0.9rem;
                ">
                    Welcome, Admin
                </p>

                <p style="
                    margin: 0;
                    font-weight: 600;
                ">
                    <?php echo date('F d, Y'); ?>
                </p>

            </div>

        </div>


        <!-- Stats -->
        <div class="admin-stats">

            <div class="stat-card">

                <i
                    class="fas fa-box"
                    style="
                        font-size: 1.5rem;
                        color: var(--brown);
                        margin-right: 0.5rem;
                    "
                ></i>

                <div class="stat-value">
                    <?php echo $total_products; ?>
                </div>

                <div class="stat-label">
                    Total Products
                </div>

            </div>


            <div class="stat-card">

                <i
                    class="fas fa-users"
                    style="
                        font-size: 1.5rem;
                        color: var(--brown);
                        margin-right: 0.5rem;
                    "
                ></i>

                <div class="stat-value">
                    <?php echo $total_users; ?>
                </div>

                <div class="stat-label">
                    Total Users
                </div>

            </div>


            <div class="stat-card">

                <i
                    class="fas fa-shopping-bag"
                    style="
                        font-size: 1.5rem;
                        color: var(--brown);
                        margin-right: 0.5rem;
                    "
                ></i>

                <div class="stat-value">
                    <?php echo $total_orders; ?>
                </div>

                <div class="stat-label">
                    Total Orders
                </div>

            </div>


            <div class="stat-card">

                <i
                    class="fas fa-dollar-sign"
                    style="
                        font-size: 1.5rem;
                        color: var(--brown);
                        margin-right: 0.5rem;
                    "
                ></i>

                <div class="stat-value">
                    <?php echo formatPrice($total_sales); ?>
                </div>

                <div class="stat-label">
                    Total Sales
                </div>

            </div>

        </div>


        <!-- Recent Orders -->
        <div style="
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
        ">

            <h3 style="
                margin-top: 0;
                margin-bottom: 1.5rem;
                color: var(--brown);
            ">
                Recent Orders
            </h3>


            <?php if (count($recent_orders) > 0): ?>

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

                        <?php foreach ($recent_orders as $order): ?>

                            <?php
                            $user = $conn->query(
                                "SELECT name FROM users WHERE id = " . $order['user_id']
                            )->fetch_assoc();

                            $status_class = 'status-' . strtolower($order['status']);
                            ?>

                            <tr>

                                <td>
                                    #<?php echo str_pad(
                                        $order['id'],
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    ); ?>
                                </td>

                                <td>
                                    <?php echo $user['name'] ?? 'Unknown'; ?>
                                </td>

                                <td>
                                    <?php echo formatPrice($order['total_amount']); ?>
                                </td>

                                <td>
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php echo date(
                                        'M d, Y',
                                        strtotime($order['created_at'])
                                    ); ?>
                                </td>

                                <td>
                                    <a
                                        href="orders.php?id=<?php echo $order['id']; ?>"
                                        class="btn btn-small"
                                        style="padding: 0.5rem 1rem;"
                                    >
                                        View
                                    </a>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <p style="
                    color: var(--text-light);
                    text-align: center;
                ">
                    No orders yet
                </p>

            <?php endif; ?>

        </div>


        <!-- Quick Actions -->
        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        ">

            <a
                href="products.php?action=add"
                class="btn"
                style="
                    text-align: center;
                    padding: 1rem;
                "
            >
                <i class="fas fa-plus"></i>
                Add Product
            </a>


            <a
                href="categories.php"
                class="btn"
                style="
                    text-align: center;
                    padding: 1rem;
                "
            >
                <i class="fas fa-folder"></i>
                Manage Categories
            </a>


            <a
                href="orders.php"
                class="btn"
                style="
                    text-align: center;
                    padding: 1rem;
                "
            >
                <i class="fas fa-shopping-bag"></i>
                View All Orders
            </a>


            <a
                href="messages.php"
                class="btn"
                style="
                    text-align: center;
                    padding: 1rem;
                "
            >
                <i class="fas fa-envelope"></i>
                Messages (<?php echo $pending_messages; ?>)
            </a>


            <a
                href="change-password.php"
                class="btn"
                style="
                    text-align: center;
                    padding: 1rem;
                "
            >
                <i class="fas fa-key"></i>
                Change Password
            </a>

        </div>

    </main>

</div>


<!-- ==================== LOGOUT MODAL ==================== -->

<div
    id="logoutModal"
    style="
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
    "
>

    <div
        style="
            background: white;
            width: 90%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        "
    >

        <h2 style="
            color: var(--brown);
            margin-top: 0;
            margin-bottom: 1rem;
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
                style="min-width: 100px;"
            >
                Yes
            </button>


            <button
                type="button"
                onclick="closeLogoutModal()"
                class="btn btn-secondary"
                style="min-width: 100px;"
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


document.getElementById('logoutModal').addEventListener('click', function (event) {

    if (event.target === this) {

        closeLogoutModal();

    }

});

</script>


</body>
</html>