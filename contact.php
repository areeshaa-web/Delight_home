<?php
$page_title = "Contact Us - Delight Home";
require_once 'includes/db.php';
require_once 'includes/functions.php';

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all required fields (Name, Email, Subject, and Message)';
    } elseif (!isValidEmail($email)) {
        $error = 'Please enter a valid email address';
    } else {
        $name_e = $conn->real_escape_string($name);
        $email_e = $conn->real_escape_string($email);
        $phone_e = $conn->real_escape_string($phone);
        $subject_e = $conn->real_escape_string($subject);
        $message_e = $conn->real_escape_string($message);
        
        $sql = "INSERT INTO contact_messages (name, email, phone, subject, message) VALUES ('$name_e', '$email_e', '$phone_e', '$subject_e', '$message_e')";
        
        if ($conn->query($sql)) {
            $success = true;
            $_POST = array(); // Clear form fields after successful submit
        } else {
            $error = 'Database error: Unable to save message. ' . $conn->error;
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Page Header -->
<section class="dh-page-heading" style="background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--tertiary-bg) 100%); padding: 60px 2rem; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; color: var(--brown); margin-bottom: 1rem;">Contact Us</h1>
        <p style="font-size: 1.1rem; color: var(--text-light);">We'd love to hear from you. Get in touch with our team!</p>
    </div>
</section>

<!-- Contact Section -->
<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
            
            <!-- Contact Form -->
            <div class="card" style="padding: 2rem;">
                <h2 style="margin-bottom: 1.5rem; font-size: 1.5rem;">Send us a Message</h2>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>Thank you for your message! We'll get back to you soon.</span>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-input" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-input" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone *</label>
                        <input type="tel" name="phone" class="form-input" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Subject *</label>
                        <input type="text" name="subject" class="form-input" value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-textarea" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn" style="width: 100%;">Send Message</button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div>
                <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
                    <h3 style="margin-bottom: 1.5rem; font-size: 1.3rem;">Get in Touch</h3>
                    
                    <div style="margin-bottom: 2rem;">
                        <h4 style="margin-bottom: 0.5rem;"><i class="fas fa-envelope" style="color: var(--brown); margin-right: 0.75rem;"></i>Email</h4>
                        <p style="color: var(--text-light);">info@delighthome.com</p>
                        <p style="color: var(--text-light);">support@delighthome.com</p>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <h4 style="margin-bottom: 0.5rem;"><i class="fas fa-phone" style="color: var(--brown); margin-right: 0.75rem;"></i>Phone</h4>
                        <p style="color: var(--text-light);">+1 (800) 123-4567</p>
                        <p style="color: var(--text-light);">+1 (800) 987-6543</p>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <h4 style="margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt" style="color: var(--brown); margin-right: 0.75rem;"></i>Address</h4>
                        <p style="color: var(--text-light);">123 Elegance Street<br>Design City, DC 12345<br>United States</p>
                    </div>
                    
                    <div>
                        <h4 style="margin-bottom: 0.5rem;"><i class="fas fa-clock" style="color: var(--brown); margin-right: 0.75rem;"></i>Business Hours</h4>
                        <p style="color: var(--text-light);">Monday - Friday: 9:00 AM - 6:00 PM</p>
                        <p style="color: var(--text-light);">Saturday - Sunday: 10:00 AM - 4:00 PM</p>
                    </div>
                </div>
                
                <div class="card dh-contact-social" style="padding: 1rem;">
                    <h3 style="margin-bottom: 1.2rem; font-size: 1.3rem;">Follow Us</h3>
                    <div class="social-icons">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <!-- <a href="#" class="social-link"><i class="fab fa-twitter"></i></a> -->
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                         <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                        <!-- <a href="#" class="social-link"><i class="fab fa-pinterest"></i></a> -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include 'includes/footer.php'; ?>
