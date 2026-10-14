<?php
$page_title = "Frequently Asked Questions - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="dh-faq-page">
    <section class="dh-faq-hero" aria-labelledby="dh-faq-title">
        <div class="dh-faq-hero-copy">
            <span class="dh-faq-eyebrow">Help &amp; Support</span>
            <h1 id="dh-faq-title">Frequently Asked Questions</h1>
            <p>Everything you need to know about our products, orders, delivery, and more.</p>
        </div>
        <div class="dh-faq-hero-image">
            <img src="images/kitchen.jpg" alt="A warm, thoughtfully styled home kitchen">
        </div>
    </section>

    <section class="dh-faq-content" aria-label="Frequently asked questions">
        <aside class="dh-faq-intro">
            <span class="dh-faq-script">We’re here to help!</span>
            <p>Find quick answers to the most common questions. If you don’t see your question here, feel free to contact us — we're happy to assist you!</p>
            <a class="dh-faq-contact" href="contact.php">
                Contact Us <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </aside>

        <div class="dh-faq-list">
            <article class="dh-faq-item is-open">
                <h2 class="dh-faq-question-heading">
                    <button class="dh-faq-trigger" type="button" id="dh-faq-trigger-1"
                            aria-expanded="true" aria-controls="dh-faq-answer-1">
                        <span class="dh-faq-number">01</span>
                        <span class="dh-faq-question">How can I place an order?</span>
                        <span class="dh-faq-toggle" aria-hidden="true">−</span>
                    </button>
                </h2>
                <div class="dh-faq-answer" id="dh-faq-answer-1" role="region"
                     aria-labelledby="dh-faq-trigger-1" aria-hidden="false">
                    <p>You can browse our products, open the product details, add the item to your cart, and proceed to checkout. It's quick, easy, and secure.</p>
                </div>
            </article>

            <article class="dh-faq-item">
                <h2 class="dh-faq-question-heading">
                    <button class="dh-faq-trigger" type="button" id="dh-faq-trigger-2"
                            aria-expanded="false" aria-controls="dh-faq-answer-2">
                        <span class="dh-faq-number">02</span>
                        <span class="dh-faq-question">Do you offer delivery?</span>
                        <span class="dh-faq-toggle" aria-hidden="true">+</span>
                    </button>
                </h2>
                <div class="dh-faq-answer" id="dh-faq-answer-2" role="region"
                     aria-labelledby="dh-faq-trigger-2" aria-hidden="true">
                    <p>Yes, we offer delivery for orders placed through Delight Home. Delivery details and charges can be shown during checkout.</p>
                </div>
            </article>

            <article class="dh-faq-item">
                <h2 class="dh-faq-question-heading">
                    <button class="dh-faq-trigger" type="button" id="dh-faq-trigger-3"
                            aria-expanded="false" aria-controls="dh-faq-answer-3">
                        <span class="dh-faq-number">03</span>
                        <span class="dh-faq-question">How can I track my order?</span>
                        <span class="dh-faq-toggle" aria-hidden="true">+</span>
                    </button>
                </h2>
                <div class="dh-faq-answer" id="dh-faq-answer-3" role="region"
                     aria-labelledby="dh-faq-trigger-3" aria-hidden="true">
                    <p>You can check your order status from your account/order section. If you need additional assistance, contact our support team.</p>
                </div>
            </article>

            <article class="dh-faq-item">
                <h2 class="dh-faq-question-heading">
                    <button class="dh-faq-trigger" type="button" id="dh-faq-trigger-4"
                            aria-expanded="false" aria-controls="dh-faq-answer-4">
                        <span class="dh-faq-number">04</span>
                        <span class="dh-faq-question">What payment methods do you accept?</span>
                        <span class="dh-faq-toggle" aria-hidden="true">+</span>
                    </button>
                </h2>
                <div class="dh-faq-answer" id="dh-faq-answer-4" role="region"
                     aria-labelledby="dh-faq-trigger-4" aria-hidden="true">
                    <p>We accept the payment methods currently available during checkout. Select your preferred option and complete your order securely.</p>
                </div>
            </article>

            <article class="dh-faq-item">
                <h2 class="dh-faq-question-heading">
                    <button class="dh-faq-trigger" type="button" id="dh-faq-trigger-5"
                            aria-expanded="false" aria-controls="dh-faq-answer-5">
                        <span class="dh-faq-number">05</span>
                        <span class="dh-faq-question">Can I cancel my order?</span>
                        <span class="dh-faq-toggle" aria-hidden="true">+</span>
                    </button>
                </h2>
                <div class="dh-faq-answer" id="dh-faq-answer-5" role="region"
                     aria-labelledby="dh-faq-trigger-5" aria-hidden="true">
                    <p>Order cancellation depends on the current status of your order. Please contact Delight Home support as soon as possible if you want to request a cancellation.</p>
                </div>
            </article>

            <article class="dh-faq-item">
                <h2 class="dh-faq-question-heading">
                    <button class="dh-faq-trigger" type="button" id="dh-faq-trigger-6"
                            aria-expanded="false" aria-controls="dh-faq-answer-6">
                        <span class="dh-faq-number">06</span>
                        <span class="dh-faq-question">Are your products suitable for commercial use?</span>
                        <span class="dh-faq-toggle" aria-hidden="true">+</span>
                    </button>
                </h2>
                <div class="dh-faq-answer" id="dh-faq-answer-6" role="region"
                     aria-labelledby="dh-faq-trigger-6" aria-hidden="true">
                    <p>Yes. Many of our kitchen and homeware products are suitable for restaurants, cafés, bakeries, businesses, and commercial environments. Check the individual product details for specifications.</p>
                </div>
            </article>

            <article class="dh-faq-item">
                <h2 class="dh-faq-question-heading">
                    <button class="dh-faq-trigger" type="button" id="dh-faq-trigger-7"
                            aria-expanded="false" aria-controls="dh-faq-answer-7">
                        <span class="dh-faq-number">07</span>
                        <span class="dh-faq-question">How can I contact Delight Home?</span>
                        <span class="dh-faq-toggle" aria-hidden="true">+</span>
                    </button>
                </h2>
                <div class="dh-faq-answer" id="dh-faq-answer-7" role="region"
                     aria-labelledby="dh-faq-trigger-7" aria-hidden="true">
                    <p>You can contact us through the Contact Us page. Our team will be happy to assist you with products, orders, delivery, and other questions.</p>
                </div>
            </article>
        </div>
    </section>

    <section class="dh-faq-benefits" aria-label="The Delight Home difference">
        <div class="dh-faq-benefit">
            <i class="fas fa-truck-fast" aria-hidden="true"></i>
            <span>Fast &amp; Reliable Delivery</span>
        </div>
        <div class="dh-faq-benefit">
            <i class="fas fa-lock" aria-hidden="true"></i>
            <span>Secure Payments</span>
        </div>
        <div class="dh-faq-benefit">
            <i class="fas fa-headset" aria-hidden="true"></i>
            <span>Dedicated Support</span>
        </div>
        <div class="dh-faq-benefit">
            <i class="fas fa-gem" aria-hidden="true"></i>
            <span>Premium Quality Products</span>
        </div>
    </section>
</main>

<script src="js/faq.js" defer></script>
<?php include 'includes/footer.php'; ?>
