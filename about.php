<?php
$page_title = "About Delight Home - Our Story";
require_once 'includes/db.php';
require_once 'includes/functions.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Page Header -->
<section class="dh-page-heading" style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 60px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;">About Delight Home</h1>
        <p style="font-size: 1.1rem; color: var(--text-light);">Crafting Elegance, One Product at a Time</p>
    </div>
</section>

<!-- Brand Story -->
<section class="section dh-about-story">
    <div class="container">
        <div class="grid grid-2" style="align-items: center; gap: 3rem;">
            <div class="dh-about-story-copy">
                <h2 style="font-size: 2rem; color: var(--brown); margin-bottom: 1.5rem;">Our Story</h2>
                <p style="margin-bottom: 1rem; line-height: 1.8;">
Delight Home is a growing homeware and kitchenware brand with one simple vision: to make premium-quality products accessible for every modern home.
We’ve been in this business for the last 6 years, and for the past 1 year we’ve been serving customers online.                 </p>
                
<p style="margin-bottom: 1rem; line-height: 1.8;">
We carefully curate elegant, durable, and functional pieces that bring together quality, style, and everyday practicality.                 </p>
                
<p style="margin-bottom: 1rem; line-height: 1.8;">
What started as a passion project is now a trusted online destination for homemakers, chefs, and design lovers. We’re committed to building strong customer relationships through quality products, honest service, and continuous improvement.
                </p>
                
<p style="margin-bottom: 1rem; line-height: 1.8;">
Today, we proudly serve thousands of customers across the country. Our goal is to become a trusted name in the homeware industry by adding comfort, convenience, and a touch of elegance to every home.
                </p>
            </div>
            <div class="dh-about-story-image">
                <img src="images/kitchen.jpg" alt="Delight Home Story" style="width: 100%; box-shadow: var(--shadow-lg);" onerror="this.onerror=null; this.src='images/placeholder.jpg'"/>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section dh-about-mission" style="background-color: var(--secondary-bg);">
    <div class="container">
        <h2 class="section-title">Our Mission & Vision</h2>
        
        <div class="grid grid-2">
            <div class="card">
                <div style="padding: 2rem;">
                    <i class="fas fa-target" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">Our Mission</h3>
                    <p>To provide premium homeware and kitchenware products that inspire creativity, enhance daily living, and bring joy to every household. We're committed to quality, sustainability, and exceptional customer service.</p>
                </div>
            </div>
            
            <div class="card">
                <div style="padding: 2rem;">
                    <i class="fas fa-eye" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">Our Vision</h3>
                    <p>To be the leading online destination for elegant, high-quality homeware products that elevate everyday moments. We envision homes filled with beauty, comfort, and timeless pieces that tell a story.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section dh-about-values">
    <div class="container">
        <h2 class="section-title">Our Core Values</h2>
        
        <div class="grid grid-3">
            <div class="card">
                <div style="padding: 2rem; text-align: center;">
                    <i class="fas fa-gem" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">Quality</h3>
                    <p>We never compromise on quality. Every product is carefully selected and tested to ensure it meets our high standards.</p>
                </div>
            </div>
            
            <div class="card">
                <div style="padding: 2rem; text-align: center;">
                    <i class="fas fa-heart" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">Customer Focus</h3>
                    <p>Our customers are at the heart of everything we do. Your satisfaction is our success.</p>
                </div>
            </div>
            
            <div class="card">
                <div style="padding: 2rem; text-align: center;">
                    <i class="fas fa-leaf" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">Sustainability</h3>
                    <p>We're committed to environmentally responsible practices in sourcing and packaging.</p>
                </div>
            </div>
            
            <div class="card">
                <div style="padding: 2rem; text-align: center;">
                    <i class="fas fa-lightbulb" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">Innovation</h3>
                    <p>We continually explore new products and designs to stay at the forefront of home trends.</p>
                </div>
            </div>
            
            <div class="card">
                <div style="padding: 2rem; text-align: center;">
                    <i class="fas fa-handshake" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">Trust</h3>
                    <p>We believe in building lasting relationships with our customers based on honesty and transparency.</p>
                </div>
            </div>
            
            <div class="card">
                <div style="padding: 2rem; text-align: center;">
                    <i class="fas fa-users" style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 0.5rem;">Community</h3>
                    <p>We're more than a business - we're a community of people who love beautiful homes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="section dh-about-why" style="background-color: var(--secondary-bg);">
    <div class="container">
        <h2 class="section-title">Why Choose Delight Home?</h2>
        <p class="section-subtitle">What Sets Us Apart</p>
        
        <div class="grid grid-2" style="gap: 2rem;">
            <div style="display: flex; gap: 1.5rem;">
                <div>
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--brown); margin-top: 0.25rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Curated Collections</h4>
                    <p>Every item in our collection is handpicked by our team of design experts to ensure quality and style.</p>
                </div>
            </div>
            
            <div style="display: flex; gap: 1.5rem;">
                <div>
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--brown); margin-top: 0.25rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Competitive Pricing</h4>
                    <p>We offer premium quality at affordable prices with regular sales and exclusive member discounts.</p>
                </div>
            </div>
            
            <div style="display: flex; gap: 1.5rem;">
                <div>
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--brown); margin-top: 0.25rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Fast & Secure Shipping</h4>
                    <p>We partner with reliable shipping providers to ensure your orders arrive safely and on time.</p>
                </div>
            </div>
            
            <div style="display: flex; gap: 1.5rem;">
                <div>
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--brown); margin-top: 0.25rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Hassle-Free Returns</h4>
                    <p>30-day return policy with no questions asked. Your satisfaction is guaranteed.</p>
                </div>
            </div>
            
            <div style="display: flex; gap: 1.5rem;">
                <div>
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--brown); margin-top: 0.25rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Expert Support</h4>
                    <p>Our knowledgeable team is available 24/7 to answer questions and help you find the perfect products.</p>
                </div>
            </div>
            
            <div style="display: flex; gap: 1.5rem;">
                <div>
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--brown); margin-top: 0.25rem;"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Secure Checkout</h4>
                    <p>State-of-the-art encryption and multiple payment options for your peace of mind.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="section">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2rem; color: var(--brown); margin-bottom: 1rem;">Get in Touch</h2>
        <p style="font-size: 1.1rem; color: var(--text-light); margin-bottom: 2rem;">Have questions? We'd love to hear from you!</p>
        <a href="contact.php" class="btn">Contact Us</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
