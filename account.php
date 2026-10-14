<?php
$page_title = "My Account - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: /areeshaaaa/areesha/login.php');
    exit;
}

$user = getCurrentUser();
$orders = getUserOrders($user['id']);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Page Header -->
<section style="
    background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%);
    padding: 60px 2rem;
    text-align: center;
">

    <div class="container">

        <h1 style="
            font-size: 2.5rem;
            color: var(--brown);
            margin-bottom: 1rem;
        ">
            My Account
        </h1>

    </div>

</section>


<!-- Account Content -->
<section class="section">

    <div class="container">

        <div style="
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        ">


            <!-- Sidebar -->
            <aside>

                <div class="card" style="
                    padding: 2rem;
                    text-align: center;
                ">

                    <i
                        class="fas fa-user-circle"
                        style="
                            font-size: 4rem;
                            color: var(--brown);
                            margin-bottom: 1rem;
                        "
                    ></i>


                    <h3 style="margin-top: 0;">
                        <?php echo htmlspecialchars($user['name']); ?>
                    </h3>


                    <p style="
                        color: var(--text-light);
                        margin-bottom: 1.5rem;
                    ">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </p>


                    <!-- Logout Button -->
                    <a
                        href="#"
                        onclick="showLogoutPopup(event)"
                        class="btn"
                        style="width: 100%;"
                    >
                        Logout
                    </a>

                </div>

            </aside>


            <!-- Main Content -->
            <main>


                <!-- Account Information -->
                <div class="card" style="
                    padding: 2rem;
                    margin-bottom: 2rem;
                ">

                    <h2 style="
                        margin-top: 0;
                        color: var(--brown);
                    ">
                        Account Information
                    </h2>


                    <div style="
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 1.5rem;
                    ">

                        <div>

                            <strong>Full Name</strong>
                            <br>

                            <span style="color: var(--text-light);">
                                <?php echo htmlspecialchars($user['name']); ?>
                            </span>

                        </div>


                        <div>

                            <strong>Email Address</strong>
                            <br>

                            <span style="color: var(--text-light);">
                                <?php echo htmlspecialchars($user['email']); ?>
                            </span>

                        </div>


                        <div>

                            <strong>Phone Number</strong>
                            <br>

                            <span style="color: var(--text-light);">
                                <?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?>
                            </span>

                        </div>


                        <div>

                            <strong>City</strong>
                            <br>

                            <span style="color: var(--text-light);">
                                <?php echo htmlspecialchars($user['city'] ?? 'Not provided'); ?>
                            </span>

                        </div>


                        <div style="grid-column: 1 / -1;">

                            <strong>Address</strong>
                            <br>

                            <span style="color: var(--text-light);">
                                <?php echo htmlspecialchars($user['address'] ?? 'Not provided'); ?>
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Order History -->
                <div class="card" style="padding: 2rem;">

                    <h2 style="
                        margin-top: 0;
                        color: var(--brown);
                    ">
                        Order History
                    </h2>


                    <?php if (count($orders) > 0): ?>

                        <table style="
                            width: 100%;
                            border-collapse: collapse;
                        ">

                            <thead>

                                <tr style="
                                    background-color: var(--secondary-bg);
                                    border-bottom: 2px solid var(--border-color);
                                ">

                                    <th style="
                                        padding: 1rem;
                                        text-align: left;
                                    ">
                                        Order ID
                                    </th>


                                    <th style="
                                        padding: 1rem;
                                        text-align: left;
                                    ">
                                        Total
                                    </th>


                                    <th style="
                                        padding: 1rem;
                                        text-align: left;
                                    ">
                                        Status
                                    </th>


                                    <th style="
                                        padding: 1rem;
                                        text-align: left;
                                    ">
                                        Date
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php foreach ($orders as $order): ?>

                                    <tr style="
                                        border-bottom: 1px solid var(--border-color);
                                    ">

                                        <td style="padding: 1rem;">

                                            #<?php echo str_pad(
                                                $order['id'],
                                                6,
                                                '0',
                                                STR_PAD_LEFT
                                            ); ?>

                                        </td>


                                        <td style="padding: 1rem;">

                                            <?php echo formatPrice(
                                                $order['total_amount']
                                            ); ?>

                                        </td>


                                        <td style="padding: 1rem;">

                                            <span style="
                                                display: inline-block;
                                                padding: 0.4rem 0.8rem;
                                                border-radius: 4px;
                                                background-color: var(--secondary-bg);
                                                font-size: 0.85rem;
                                                font-weight: 600;
                                            ">

                                                <?php echo htmlspecialchars(
                                                    $order['status']
                                                ); ?>

                                            </span>

                                        </td>


                                        <td style="padding: 1rem;">

                                            <?php echo date(
                                                'M d, Y',
                                                strtotime($order['created_at'])
                                            ); ?>

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

                            No orders yet.

                            <a
                                href="/areeshaaaa/areesha/products.php"
                                style="color: var(--brown);"
                            >
                                Start shopping
                            </a>

                        </p>

                    <?php endif; ?>

                </div>

            </main>

        </div>

    </div>

</section>



<!-- ================================================= -->
<!-- LOGOUT POPUP -->
<!-- ================================================= -->

<div
    id="logoutPopup"
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

    <div style="
        background: white;
        width: 90%;
        max-width: 400px;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    ">


        <!-- Popup Icon -->
        <div style="
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            background-color: var(--secondary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        ">

            <i
                class="fas fa-sign-out-alt"
                style="
                    font-size: 1.5rem;
                    color: var(--brown);
                "
            ></i>

        </div>


        <!-- Popup Heading -->
        <h2 style="
            color: var(--brown);
            margin-top: 0;
            margin-bottom: 0.75rem;
        ">
            Logout
        </h2>


        <!-- Popup Message -->
        <p style="
            margin-bottom: 1.5rem;
            color: var(--text-dark);
        ">
            Do you want to logout?
        </p>


        <!-- Buttons -->
        <div style="
            display: flex;
            justify-content: center;
            gap: 1rem;
        ">


            <!-- YES -->
            <button
                type="button"
                onclick="confirmLogout()"
                class="btn"
                style="
                    min-width: 100px;
                    border: none;
                    cursor: pointer;
                "
            >
                Yes
            </button>


            <!-- NO -->
            <button
                type="button"
                onclick="closeLogoutPopup()"
                class="btn btn-secondary"
                style="
                    min-width: 100px;
                    cursor: pointer;
                "
            >
                No
            </button>

        </div>

    </div>

</div>



<!-- ================================================= -->
<!-- LOGOUT POPUP JAVASCRIPT -->
<!-- ================================================= -->

<script>

function showLogoutPopup(event) {

    if (event) {
        event.preventDefault();
    }

    document.getElementById('logoutPopup').style.display = 'flex';

}


function closeLogoutPopup() {

    document.getElementById('logoutPopup').style.display = 'none';

}


function confirmLogout() {

    window.location.href = '/areeshaaaa/areesha/logout.php';

}


// Close popup when clicking outside the popup box
document.getElementById('logoutPopup').addEventListener('click', function(event) {

    if (event.target === this) {

        closeLogoutPopup();

    }

});


// Close popup by pressing Escape key
document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeLogoutPopup();

    }

});

</script>


<?php include 'includes/footer.php'; ?>