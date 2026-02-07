<?php
$pageTitle = "Feedback - Allami Homes";
include 'includes/header.php';

// Process form submission
$messageSent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // In a real application, you would save this to a database
    // For now, we'll just set a flag to show success message
    $messageSent = true;
}
?>

<div class="container">
    <h1>We Value Your Feedback</h1>
    
    <?php if ($messageSent): ?>
    <div class="success-message">
        <p>Thank you for your feedback! We'll get back to you soon.</p>
    </div>
    <?php endif; ?>
    
    <form method="POST" action="feedback.php" class="feedback-form">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        
        <button type="submit" class="cta-button">Send Feedback</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>