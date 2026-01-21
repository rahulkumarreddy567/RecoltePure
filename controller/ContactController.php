<?php
// controllers/ContactController.php

class ContactController
{

    public function index()
    {
        $errorMsg = null;
        $successMsg = null;

        // Check for Success Message from Redirect
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $successMsg = "Your message has been sent successfully! We'll get back to you soon.";
        }

        // Handle POST Request (Form Submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmission($errorMsg, $successMsg);
        }

        // Load the View
        include 'view/contact.php';
    }

    private function handleSubmission(&$errorMsg, &$successMsg)
    {
        // Sanitize
        $firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
        $lastName = htmlspecialchars(trim($_POST['lastName'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
        $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
        $message = htmlspecialchars(trim($_POST['message'] ?? ''));

        // Validate
        if (empty($firstName) || empty($lastName) || empty($email) || empty($subject) || empty($message)) {
            $errorMsg = "Please fill in all required fields.";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg = "Please enter a valid email address.";
            return;
        }

        // Just show success message (no database save)
        $successMsg = "Thank you for contacting us! Your message has been received.";
    }
}
?>