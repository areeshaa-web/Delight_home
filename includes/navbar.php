<?php
// Navigation Bar
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar">
    <div class="nav-container">

        <!-- Logo -->
        <div class="nav-brand">
            <a href="index.php" class="logo">
                <span class="dh-brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 48 48" focusable="false">
                        <path d="M7 22.5 24 8l17 14.5M12 20v20h24V20M20 40V27h8v13" />
                        <path d="M34 14c.2-4.2 3.5-6.5 7-6-1.1 3.9-3.5 6.1-7 6Zm0 0c-2.8-2.3-3.4-4.8-2.6-7.2 2.6 1.4 3.4 3.8 2.6 7.2Z" />
                    </svg>
                </span>
                <span class="dh-brand-copy">
                    <span class="dh-brand-name">Delight Home</span>
                    <span class="dh-brand-tagline">PREMIUM HOME &amp; KITCHENWARE</span>
                </span>
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="nav-toggle" id="navToggle" type="button" aria-label="Open navigation" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Navigation Links -->
        <ul class="nav-menu" id="navMenu">

            <li>
                <a href="index.php"
                   class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    Home
                </a>
            </li>

            <li>
                <a href="about.php"
                   class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                    About
                </a>
            </li>

            <li>
                <a href="products.php"
                   class="nav-link <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>">
                    Products
                </a>
            </li>

            <li>
                <a href="categories.php"
                   class="nav-link <?php echo ($current_page == 'categories.php') ? 'active' : ''; ?>">
                    Categories
                </a>
            </li>

            <li>
                <a href="faq.php"
                   class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>">
                    FAQs
                </a>
            </li>

            <li>
                <a href="contact.php"
                   class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                    Contact
                </a>
            </li>

        </ul>

        <!-- Right Side Icons -->
        <div class="nav-actions">

            <a href="wishlist.php" class="nav-icon nav-action-icon" aria-label="Wishlist" title="Wishlist">
                <i class="far fa-heart" aria-hidden="true"></i>
                <span class="nav-icon-tooltip" role="tooltip">Wishlist</span>
            </a>

            <!-- Cart -->
            <a href="cart.php"
               class="nav-icon cart-icon nav-action-icon"
               aria-label="Shopping cart"
               title="Shopping cart">

                <i class="fas fa-shopping-cart"></i>

                <span class="cart-count">
                    <?php echo getCartCount(); ?>
                </span>
                <span class="nav-icon-tooltip" role="tooltip">Cart</span>

            </a>

            <!-- User Dropdown -->
            <?php if (isLoggedIn()): ?>

                <?php $user = getCurrentUser(); ?>

                <div class="nav-dropdown" id="userNavDropdown" style="position: relative;">

                    <button
                        type="button"
                        class="nav-icon user-btn"
                        id="userMenuBtn"
                        onclick="toggleUserDropdown(event)"
                        aria-label="Account settings"
                        title="Account settings"
                    >
                        <i class="fas fa-user-circle"></i>
                        <span class="nav-icon-tooltip" role="tooltip">Account</span>
                    </button>

                    <div class="dropdown-menu" id="userDropdownMenu">

                        <!-- User Name -->
                        <div style="
                            padding: 0.75rem 1rem;
                            font-weight: 700;
                            color: var(--brown);
                            border-bottom: 1px solid var(--border-color);
                            font-size: 0.9rem;
                        ">
                            Hi, <?php echo htmlspecialchars($user['name'] ?? 'User'); ?>
                        </div>

                        <!-- My Profile -->
                        <a
                            href="account.php"
                            style="
                                display: block;
                                padding: 0.65rem 1rem;
                                color: var(--text-dark);
                                text-decoration: none;
                                font-size: 0.9rem;
                            "
                        >
                            <i class="fas fa-user-cog" style="width: 20px; color: var(--brown);"></i>
                            My Profile
                        </a>

                        <!-- My Orders -->
                        <a
                            href="orders.php"
                            style="
                                display: block;
                                padding: 0.65rem 1rem;
                                color: var(--text-dark);
                                text-decoration: none;
                                font-size: 0.9rem;
                            "
                        >
                            <i class="fas fa-box" style="width: 20px; color: var(--brown);"></i>
                            My Orders
                        </a>

                        <!-- My Wishlist -->
                        <a
                            href="wishlist.php"
                            style="
                                display: block;
                                padding: 0.65rem 1rem;
                                color: var(--text-dark);
                                text-decoration: none;
                                font-size: 0.9rem;
                            "
                        >
                            <i class="fas fa-heart" style="width: 20px; color: #e74c3c;"></i>
                            My Wishlist
                        </a>

                        <hr style="
                            margin: 0.5rem 0;
                            border: none;
                            border-top: 1px solid var(--border-color);
                        ">

                        <!-- Logout -->
                        <a
                            href="logout.php"
                            onclick="showLogoutModal(event)"
                            style="
                                display: block;
                                padding: 0.65rem 1rem;
                                color: #dc3545;
                                text-decoration: none;
                                font-size: 0.9rem;
                                font-weight: 600;
                            "
                        >
                            <i class="fas fa-sign-out-alt" style="width: 20px;"></i>
                            Logout
                        </a>

                    </div>

                </div>

            <?php else: ?>

                <a
                    href="login.php"
                    class="nav-icon nav-action-icon"
                    aria-label="Login or create an account"
                    title="Login or create an account"
                >
                    <i class="far fa-user" aria-hidden="true"></i>
                    <span class="nav-icon-tooltip" role="tooltip">Login / Register</span>
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>


<!-- ==================== LOGOUT CONFIRMATION MODAL ==================== -->

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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        "
    >

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

            <!-- Yes Button -->
            <button
                type="button"
                onclick="confirmLogout()"
                class="btn"
            >
                Yes
            </button>

            <!-- No Button -->
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
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    const modal = document.getElementById("logoutModal");

    if (modal) {
        modal.style.display = "flex";
    }

    const navMenu = document.getElementById("navMenu");
    const navToggle = document.getElementById("navToggle");
    const overlay = document.getElementById("mobileMenuOverlay");

    if (navMenu) navMenu.classList.remove("active");
    if (navToggle) navToggle.classList.remove("active");
    if (overlay) overlay.classList.remove("active");

    document.body.style.overflow = "";
}

function closeLogoutModal() {
    const modal = document.getElementById("logoutModal");

    if (modal) {
        modal.style.display = "none";
    }
}

function confirmLogout() {
    window.location.href = "logout.php";
}

document.addEventListener("click", function (event) {
    const modal = document.getElementById("logoutModal");

    if (modal && event.target === modal) {
        closeLogoutModal();
    }
});

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeLogoutModal();
    }
});
</script>
