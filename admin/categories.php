<?php
$page_title = "Manage Categories - Admin";
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Auto-migrate: Ensure image_url column exists in categories table
$check_col = $conn->query("SHOW COLUMNS FROM categories LIKE 'image_url'");
if ($check_col && $check_col->num_rows === 0) {
    $conn->query("ALTER TABLE categories ADD COLUMN image_url VARCHAR(255) DEFAULT NULL");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $id = intval($_POST['id'] ?? 0);
    
    // Handle image upload if provided
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../images/categories/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($file_ext, $allowed_ext)) {
            $filename = 'cat_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
            $target_path = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_url = 'images/categories/' . $filename;
            }
        }
    }
    
    if ($action === 'add') {
        if ($image_url) {
            $conn->query("INSERT INTO categories (name, description, image_url) VALUES ('$name', '$description', '$image_url')");
        } else {
            $conn->query("INSERT INTO categories (name, description) VALUES ('$name', '$description')");
        }
        $message = 'Category added successfully';
    } elseif ($action === 'edit' && $id > 0) {
        if ($image_url) {
            $conn->query("UPDATE categories SET name = '$name', description = '$description', image_url = '$image_url' WHERE id = $id");
        } else {
            $conn->query("UPDATE categories SET name = '$name', description = '$description' WHERE id = $id");
        }
        $message = 'Category updated successfully';
    } elseif ($action === 'delete' && $id > 0) {
        $conn->query("DELETE FROM categories WHERE id = $id");
        $message = 'Category deleted successfully';
    }
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
.admin-table td { padding: 1rem; border-bottom: 1px solid var(--border-color); vertical-align: middle; }

/* Modal Box Styling */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 999;
    align-items: center;
    justify-content: center;
}
.modal-overlay.active { display: flex; }
.modal-box {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    position: relative;
    animation: fadeIn 0.2s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}
.modal-title { font-size: 1.4rem; color: var(--brown); font-weight: 700; margin: 0; }
.modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-light); }
.modal-close:hover { color: var(--brown); }
</style>

<div class="admin-container">
    <aside class="admin-sidebar">
        <h3><i class="fas fa-th-large"></i> Admin Panel</h3>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="products.php">Products</a>
            <a href="categories.php" class="active">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="users.php">Users</a>
            <a href="messages.php">Messages</a>
            <a href="../logout.php" onclick="showLogoutModal(event)" style="color: #ff6b6b;">Logout</a>
        </nav>
    </aside>
    
    <main class="admin-main">
        <h1 style="color: var(--brown); margin-top: 0;">Manage Categories</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $message; ?></span>
            </div>
        <?php endif; ?>
        
        <!-- Add Category Form -->
        <div class="card" style="padding: 2rem; margin-bottom: 2rem; max-width: 550px;">
            <h3 style="margin-top: 0; color: var(--brown);"><i class="fas fa-plus-circle"></i> Add New Category</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label class="form-label">Category Name *</label>
                    <input type="text" name="name" class="form-input" required placeholder="e.g. Living Room">
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Brief description of category..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Category Image</label>
                    <input type="file" name="image" class="form-input" accept="image/*">
                    <small style="color: var(--text-light); display: block; margin-top: 0.3rem;">Saved to images/categories/</small>
                </div>
                <button type="submit" class="btn"><i class="fas fa-save"></i> Add Category</button>
            </form>
        </div>
        
        <h3 style="color: var(--brown);">All Categories</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $categories = getCategories();
                foreach ($categories as $cat):
                    $cat_img = getCategoryImageUrl($cat, true);
                ?>
                <tr>
                    <td><?php echo $cat['id']; ?></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($cat_img); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;" onerror="this.onerror=null; this.src='../images/placeholder.jpg';">
                    </td>
                    <td><strong><?php echo htmlspecialchars($cat['name']); ?></strong></td>
                    <td><?php echo htmlspecialchars(substr($cat['description'] ?? '', 0, 60)); ?></td>
                    <td>
                        <button type="button" class="btn btn-small" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;" onclick='openEditModal(<?php echo json_encode([
                            "id" => $cat["id"],
                            "name" => $cat["name"],
                            "description" => $cat["description"] ?? "",
                            "image_url" => $cat_img
                        ]); ?>)'>
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                            <button type="submit" class="btn btn-small" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; background-color: #dc3545;" onclick="return confirm('Delete this category?');">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>

<!-- Proper Edit Category Modal Box -->
<div id="editCategoryModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit"></i> Edit Category</h3>
            <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_cat_id">
            
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" id="edit_cat_name" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" id="edit_cat_description" class="form-textarea" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Current Image</label>
                <div style="margin-bottom: 0.5rem;">
                    <img id="edit_cat_preview" src="" style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px;" onerror="this.onerror=null; this.src='../images/placeholder.jpg';">
                </div>
                <label class="form-label">Change Image (Optional)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 0.8rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(category) {
    document.getElementById('edit_cat_id').value = category.id;
    document.getElementById('edit_cat_name').value = category.name;
    document.getElementById('edit_cat_description').value = category.description || '';
    document.getElementById('edit_cat_preview').src = category.image_url || '../images/placeholder.jpg';
    document.getElementById('editCategoryModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editCategoryModal').classList.remove('active');
}

// Close modal when clicking outside box
window.addEventListener('click', function(e) {
    const modal = document.getElementById('editCategoryModal');
    if (e.target === modal) {
        closeEditModal();
    }
});
</script>


<!-- ==================== LOGOUT CONFIRMATION MODAL ==================== -->
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
