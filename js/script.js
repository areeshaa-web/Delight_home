// Delight Home - JavaScript Functionality

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const overlay = document.getElementById('mobileMenuOverlay');

    function closeMobileMenu() {
        if (navMenu) navMenu.classList.remove('active');
        if (navToggle) navToggle.classList.remove('active');
        if (navToggle) navToggle.setAttribute('aria-expanded', 'false');
        if (navToggle) navToggle.setAttribute('aria-label', 'Open navigation');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openMobileMenu() {
        if (navMenu) navMenu.classList.add('active');
        if (navToggle) navToggle.classList.add('active');
        if (navToggle) navToggle.setAttribute('aria-expanded', 'true');
        if (navToggle) navToggle.setAttribute('aria-label', 'Close navigation');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    if (navToggle && navMenu) {
        navToggle.setAttribute('aria-controls', 'navMenu');
        navToggle.setAttribute('aria-expanded', 'false');

        navToggle.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            if (navMenu.classList.contains('active')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        const navLinks = navMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMobileMenu();
            });
        });

        if (overlay) {
            overlay.addEventListener('click', function() {
                closeMobileMenu();
            });
        }
    }

    // Homepage collection slider
    const heroSlider = document.querySelector('.dh-hero-slider');
    if (heroSlider) {
        const slides = Array.from(heroSlider.querySelectorAll('[data-hero-slide]'));
        const dots = Array.from(heroSlider.querySelectorAll('.dh-hero-dot'));
        const previous = heroSlider.querySelector('.dh-hero-previous');
        const next = heroSlider.querySelector('.dh-hero-next');
        let activeSlide = Math.max(0, slides.findIndex(slide => slide.classList.contains('is-active')));
        let sliderTimer = null;
        let isHovered = false;

        function showSlide(index) {
            if (slides.length === 0) return;

            activeSlide = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                const isActive = slideIndex === activeSlide;
                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-hidden', String(!isActive));
                if (dots[slideIndex]) {
                    dots[slideIndex].classList.toggle('is-active', isActive);
                    if (isActive) {
                        dots[slideIndex].setAttribute('aria-current', 'true');
                    } else {
                        dots[slideIndex].removeAttribute('aria-current');
                    }
                }
            });
        }

        function stopSlider() {
            if (sliderTimer !== null) {
                window.clearInterval(sliderTimer);
                sliderTimer = null;
            }
        }

        function startSlider() {
            stopSlider();
            if (slides.length > 1 && !isHovered) {
                sliderTimer = window.setInterval(() => showSlide(activeSlide + 1), 3600);
            }
        }

        function pauseSlider() {
            stopSlider();
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                startSlider();
            });
        });
        if (previous) {
            previous.addEventListener('click', () => {
                showSlide(activeSlide - 1);
                startSlider();
            });
        }
        if (next) {
            next.addEventListener('click', () => {
                showSlide(activeSlide + 1);
                startSlider();
            });
        }
        heroSlider.addEventListener('mouseenter', () => {
            isHovered = true;
            pauseSlider();
        });
        heroSlider.addEventListener('mouseleave', () => {
            isHovered = false;
            startSlider();
        });
        startSlider();
    }

        const revealItems = document.querySelectorAll('.dh-category-card, .dh-product-card, .dh-story, .dh-promo, .dh-benefit');
        if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            const revealObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealItems.forEach(item => {
                item.classList.add('dh-reveal');
                revealObserver.observe(item);
            });
        }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    });

    // Cart count update
    updateCartCount();

    // Wishlist functionality
    const wishlistBtns = document.querySelectorAll('.product-wishlist');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            toggleWishlist(productId, this);
        });
    });

    // Quantity controls
    const quantityMinus = document.querySelectorAll('.qty-minus');
    const quantityPlus = document.querySelectorAll('.qty-plus');

    quantityMinus.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.nextElementSibling;
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });
    });

    quantityPlus.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            let value = parseInt(input.value);
            input.value = value + 1;
        });
    });

    // Remove from cart with confirmation
    const removeCartBtns = document.querySelectorAll('.btn-remove-cart');
    removeCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Remove this item from cart?')) {
                const cartId = this.dataset.cartId;
                removeFromCart(cartId);
            }
        });
    });

    // Add to cart form submission
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const quantity = this.querySelector('input[name="quantity"]')?.value || 1;
            addToCart(productId, quantity);
        });
    });

    // Price filtering slider (if exists)
    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        priceRange.addEventListener('input', function() {
            document.getElementById('priceValue').textContent = '$' + this.value;
        });
    }

    // Form validation
    const forms = document.querySelectorAll('form[data-validate="true"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});

// Add to cart via AJAX
function addToCart(productId, quantity = 1) {
    const formData = new FormData();
    formData.append('action', 'add_to_cart');
    formData.append('product_id', productId);
    formData.append('quantity', quantity);

    fetch('api/cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Added to cart!', 'success');
            updateCartCount();
        } else {
            showNotification(data.message || 'Error adding to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to cart', 'error');
    });
}

// Remove from cart via AJAX
function removeFromCart(cartId) {
    const formData = new FormData();
    formData.append('action', 'remove_from_cart');
    formData.append('cart_id', cartId);

    fetch('api/cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Item removed from cart', 'success');
            setTimeout(() => location.reload(), 500);
        } else {
            showNotification('Error removing item', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error removing item', 'error');
    });
}

// Update cart count
function updateCartCount() {
    fetch('api/cart.php?action=get_count')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.count || 0;
            }
        })
        .catch(error => console.error('Error:', error));
}

// Toggle wishlist
function toggleWishlist(productId, button) {
    if (!button.closest('body')) return;

    const formData = new FormData();
    formData.append('action', 'toggle_wishlist');
    formData.append('product_id', productId);

    fetch('api/wishlist.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.toggle('active');
            const icon = button.querySelector('i');
            if (icon) {
                if (data.added) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    icon.style.color = '#e74c3c';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    icon.style.color = '';
                }
            }
            showNotification(data.message, 'success');
        } else {
            showNotification('Please login to use wishlist', 'info');
            window.location.href = 'login.php?msg=login_required';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating wishlist', 'error');
    });
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} fade-in`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;

    // Insert at top of page
    const body = document.body;
    body.insertBefore(notification, body.firstChild);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Validate form
function validateForm(form) {
    const inputs = form.querySelectorAll('[data-required="true"]');
    let isValid = true;

    inputs.forEach(input => {
        const errorEl = input.nextElementSibling;
        if (!input.value.trim()) {
            input.classList.add('error');
            if (errorEl && errorEl.classList.contains('form-error')) {
                errorEl.textContent = 'This field is required';
            }
            isValid = false;
        } else {
            input.classList.remove('error');
            if (errorEl && errorEl.classList.contains('form-error')) {
                errorEl.textContent = '';
            }
        }

        // Email validation
        if (input.type === 'email' && input.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(input.value)) {
                input.classList.add('error');
                if (errorEl && errorEl.classList.contains('form-error')) {
                    errorEl.textContent = 'Please enter a valid email';
                }
                isValid = false;
            }
        }

        // Phone validation
        if (input.type === 'tel' && input.value) {
            const phoneRegex = /^[\d\s\-\+\(\)]+$/;
            if (!phoneRegex.test(input.value)) {
                input.classList.add('error');
                if (errorEl && errorEl.classList.contains('form-error')) {
                    errorEl.textContent = 'Please enter a valid phone number';
                }
                isValid = false;
            }
        }
    });

    return isValid;
}

// Update cart quantity via AJAX
function updateQuantity(cartId, quantity) {
    const formData = new FormData();
    formData.append('action', 'update_quantity');
    formData.append('cart_id', cartId);
    formData.append('quantity', quantity);

    fetch('api/cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showNotification('Error updating quantity', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating quantity', 'error');
    });
}

// Format price
function formatPrice(price) {
    return '$' + parseFloat(price).toFixed(2);
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach(dropdown => {
        if (!dropdown.parentElement.contains(event.target)) {
            dropdown.style.opacity = '0';
            dropdown.style.visibility = 'hidden';
        }
    });
});

// Lazy load images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('fade-in');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}
