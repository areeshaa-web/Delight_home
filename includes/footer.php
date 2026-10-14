<?php
$path_prefix = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3 class="dh-footer-brand">
                <a href="<?php echo $path_prefix; ?>index.php" class="dh-brand-link">
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
            </h3>
            <p>Premium homeware and kitchenware products crafted for modern living. Quality, elegance, and functionality in every piece.</p>
            <div class="social-icons">
                <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                <!-- <a href="#" class="social-link"><i class="fab fa-twitter"></i></a> -->
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                <!-- <a href="#" class="social-link"><i class="fab fa-pinterest"></i></a> -->
            </div>
        </div>
        
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="<?php echo $path_prefix; ?>index.php">Home</a></li>
                <li><a href="<?php echo $path_prefix; ?>about.php">About Us</a></li>
                <li><a href="<?php echo $path_prefix; ?>products.php">Products</a></li>
                <li><a href="<?php echo $path_prefix; ?>categories.php">Categories</a></li>
                <li><a href="<?php echo $path_prefix; ?>faq.php">FAQs</a></li>
                <li><a href="<?php echo $path_prefix; ?>contact.php">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section footer-explore">
            <h3>Explore</h3>
            <ul>
                <li><a href="<?php echo $path_prefix; ?>products.php">Shop</a></li>
                <li><a href="<?php echo $path_prefix; ?>wishlist.php">Your Wishlist</a></li>
                <li><a href="<?php echo $path_prefix; ?>cart.php">Your Cart</a></li>
            </ul>
        </div>
        
        <!-- <div class="footer-section">
            <h3>Customer Service</h3>
            <ul>
                <li><a href="#">Track Order</a></li>
                <li><a href="#">Returns & Exchange</a></li>
                <li><a href="#">Shipping Info</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div> -->
        
        <div class="footer-section">
            <h3>Contact Info</h3>
            <p><i class="fas fa-envelope"></i> info@delighthome.com</p>
            <p><i class="fas fa-phone"></i> +1 (800) 123-4567</p>
            <!-- <p><i class="fas fa-map-marker-alt"></i> 123 Elegance Street, Design City, DC 12345</p> -->
            <p><i class="fas fa-clock"></i> Monday - Saturday</p>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2026 Delight Home. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a></p>
    </div>
</footer>

<script src="<?php echo $path_prefix; ?>js/script.js?v=20261007-2"></script>
</body>
</html>
