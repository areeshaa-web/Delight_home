<?php
$page_title = "Manage Products - Admin";
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Get action
$action = $_GET['action'] ?? 'list';
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle form submissions
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $conn->real_escape_string($_POST['name'] ?? '');

    $description = $conn->real_escape_string($_POST['description'] ?? '');

    $price = floatval($_POST['price'] ?? 0);

    $discount_price = !empty($_POST['discount_price'])
        ? floatval($_POST['discount_price'])
        : null;

    $category_id = intval($_POST['category_id'] ?? 1);

    $featured = isset($_POST['featured']) ? 1 : 0;

    // Image Upload Handling
    $image_url_val = null;
    $image_url_update = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        if (in_array($ext, $allowed)) {

            $upload_dir = '../images/products/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $new_filename = 'product_' . time() . '_' . rand(100, 999) . '.' . $ext;

            $destination = $upload_dir . $new_filename;

            if (move_uploaded_file($file_tmp, $destination)) {

                $image_url_val = 'images/products/' . $new_filename;

                $image_url_update = ", image_url = '$image_url_val'";
            }
        }
    }

    // ADD PRODUCT
    if ($action == 'add') {

        $img_col = $image_url_val ? ", image_url" : "";
        $img_val = $image_url_val ? ", '$image_url_val'" : "";

        $query = "INSERT INTO products 
            (category_id, name, description, price, discount_price, featured $img_col)
            VALUES 
            ($category_id, '$name', '$description', $price, " .
            ($discount_price !== null ? $discount_price : 'NULL') .
            ", $featured $img_val)";

        if ($conn->query($query)) {
            $message = 'Product added successfully';
        } else {
            $error = 'Error adding product: ' . $conn->error;
        }

        $action = 'list';

    // EDIT PRODUCT
    } elseif ($action == 'edit') {

        $query = "UPDATE products SET
            category_id = $category_id,
            name = '$name',
            description = '$description',
            price = $price,
            discount_price = " .
            ($discount_price !== null ? $discount_price : 'NULL') .
            ",
            featured = $featured
            $image_url_update
            WHERE id = $product_id";

        if ($conn->query($query)) {
            $message = 'Product updated successfully';
        } else {
            $error = 'Error updating product: ' . $conn->error;
        }

        $action = 'list';

    // DELETE PRODUCT
    } elseif ($action == 'delete') {

        if ($conn->query("DELETE FROM products WHERE id = $product_id")) {
            $message = 'Product deleted successfully';
        } else {
            $error = 'Error deleting product: ' . $conn->error;
        }

        $action = 'list';

    // CLEAR ALL PRODUCTS
    } elseif ($action == 'clear_all') {

        $conn->query("DELETE FROM cart");
        $conn->query("DELETE FROM wishlist");
        $conn->query("DELETE FROM order_items");
        $conn->query("DELETE FROM products");

        $message = 'All products removed successfully! You can now add your new products.';

        $action = 'list';
    }
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

.admin-table tr:hover {
    background-color: var(--secondary-bg);
}
</style>

<div class="admin-container">

    <!-- Sidebar -->
    <aside class="admin-sidebar">

        <h3>
            <i class="fas fa-th-large"></i> Admin Panel
        </h3>

        <nav>

            <a href="dashboard.php">Dashboard</a>

            <a href="products.php" class="active">Products</a>

            <a href="categories.php">Categories</a>

            <a href="orders.php">Orders</a>

            <a href="users.php">Users</a>

            <a href="messages.php">Messages</a>

            <a href="../logout.php" onclick="showLogoutModal(event)" style="color: #ff6b6b;">
                Logout
            </a>

        </nav>

    </aside>

    <!-- Main Content -->
    <main class="admin-main">

        <h1 style="color: var(--brown); margin-top: 0;">
            Manage Products
        </h1>

        <?php if ($message): ?>

            <div class="alert alert-success">

                <i class="fas fa-check-circle"></i>

                <span>
                    <?php echo $message; ?>
                </span>

            </div>

        <?php endif; ?>

        <?php if ($error): ?>

            <div class="alert alert-error">

                <i class="fas fa-exclamation-circle"></i>

                <span>
                    <?php echo $error; ?>
                </span>

            </div>

        <?php endif; ?>


        <?php if ($action == 'list'): ?>

            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">

                <a href="products.php?action=add" class="btn">

                    <i class="fas fa-plus"></i>
                    Add New Product

                </a>

                <a
                    href="products.php?action=clear_all"
                    class="btn btn-secondary"
                    onclick="return confirm('Are you sure you want to delete all current products?');"
                    style="background-color: #89343dff; color: #fff;"
                >

                    <i class="fas fa-trash"></i>
                    Remove Current Products

                </a>

            </div>


            <table class="admin-table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Image</th>

                        <th>Product Name</th>

                        <th>Category</th>

                        <th>Price</th>

                        <th>Featured</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    $products = $conn->query(
                        "SELECT * FROM products ORDER BY created_at DESC"
                    );

                    while ($product = $products->fetch_assoc()):

                        $category = getCategory($product['category_id']);

                        $img_src = getProductImageUrl($product, true);

                    ?>

                        <tr>

                            <td>
                                <?php echo $product['id']; ?>
                            </td>

                            <td>

                                <img
                                    src="<?php echo $img_src; ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                                    style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;"
                                    onerror="this.onerror=null; this.src='../images/placeholder.jpg'"
                                >

                            </td>

                            <td>
                                <?php echo htmlspecialchars($product['name']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($category['name'] ?? 'Unknown'); ?>
                            </td>

                            <td>
                                <?php echo formatPrice($product['price']); ?>
                            </td>

                            <td>

                                <?php if ($product['featured']): ?>

                                    <span style="color: green;">
                                        <i class="fas fa-check"></i>
                                    </span>

                                <?php else: ?>

                                    <span style="color: var(--text-lighter);">
                                        <i class="fas fa-times"></i>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="products.php?action=edit&id=<?php echo $product['id']; ?>"
                                    class="btn btn-small"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.85rem;"
                                >
                                    Edit
                                </a>

                                <a
                                    href="products.php?action=delete&id=<?php echo $product['id']; ?>"
                                    class="btn btn-small"
                                    onclick="return confirm('Delete this product?');"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.85rem; background-color: #dc3545;"
                                >
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>


        <?php elseif ($action == 'add' || $action == 'edit'): ?>

            <?php

            $product = [];

            if ($action == 'edit' && $product_id) {

                $product = getProduct($product_id) ?? [];

            }

            ?>


            <div class="card" style="padding: 2rem; max-width: 600px;">

                <h2 style="margin-top: 0; color: var(--brown);">

                    <?php echo $action == 'add'
                        ? 'Add New Product'
                        : 'Edit Product'; ?>

                </h2>


                <form method="POST" enctype="multipart/form-data">

                    <div class="form-group">

                        <label class="form-label">
                            Product Name *
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-input"
                            value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Category *
                        </label>

                        <select
                            name="category_id"
                            class="form-select"
                            required
                        >

                            <?php

                            $categories = getCategories();

                            foreach ($categories as $cat):

                            ?>

                                <option
                                    value="<?php echo $cat['id']; ?>"
                                    <?php echo ($product['category_id'] ?? 0) == $cat['id']
                                        ? 'selected'
                                        : ''; ?>
                                >

                                    <?php echo htmlspecialchars($cat['name']); ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Description *
                        </label>

                        <textarea
                            name="description"
                            class="form-textarea"
                            required
                        ><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            Product Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-input"
                            accept="image/*"
                        >

                        <?php if (!empty($product['image_url'])): ?>

                            <div style="margin-top: 0.5rem;">

                                <span style="font-size: 0.85rem; color: var(--text-light);">
                                    Current image:
                                </span>

                                <br>

                                <img
                                    src="<?php echo getProductImageUrl($product, true); ?>"
                                    alt="Preview"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; margin-top: 0.25rem;"
                                >

                            </div>

                        <?php endif; ?>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                Price *
                            </label>

                            <input
                                type="number"
                                name="price"
                                class="form-input"
                                step="0.01"
                                value="<?php echo $product['price'] ?? ''; ?>"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Discount Price
                            </label>

                            <input
                                type="number"
                                name="discount_price"
                                class="form-input"
                                step="0.01"
                                value="<?php echo $product['discount_price'] ?? ''; ?>"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <input
                            type="checkbox"
                            name="featured"
                            id="featured"
                            <?php echo ($product['featured'] ?? 0) ? 'checked' : ''; ?>
                        >

                        <label
                            for="featured"
                            style="margin: 0; display: inline;"
                        >
                            Featured Product
                        </label>

                    </div>


                    <div style="display: flex; gap: 1rem;">

                        <button type="submit" class="btn">

                            <?php echo $action == 'add'
                                ? 'Add Product'
                                : 'Update Product'; ?>

                        </button>

                        <a href="products.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>


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
        <h2 style="color: var(--brown); margin-top: 0;">Logout</h2>

        <p style="margin-bottom: 1.5rem; color: var(--text-dark);">
            Do you want to logout?
        </p>

        <div style="display: flex; justify-content: center; gap: 1rem;">
            <button type="button" onclick="confirmLogout()" class="btn">
                Yes
            </button>

            <button type="button" onclick="closeLogoutModal()" class="btn btn-secondary">
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