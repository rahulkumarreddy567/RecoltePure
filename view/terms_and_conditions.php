<?php include 'view/layout/header.php'; ?>

<style>
    .terms-container {
        max-width: 1000px;
        margin: 80px auto 50px;
        padding: 40px;
        background: #FFF6ED;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        font-family: 'Poppins', sans-serif;
    }

    .terms-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .terms-header h1 {
        font-size: 2.5rem;
        color: #2d3436;
        margin-bottom: 10px;
    }

    .terms-header p {
        color: #666;
        font-size: 1rem;
    }

    .terms-section {
        margin-bottom: 30px;
    }

    .terms-section h2 {
        font-size: 1.5rem;
        color: #ff4d2d;
        margin-bottom: 15px;
        border-bottom: 2px solid #ff4d2d;
        padding-bottom: 10px;
    }

    .terms-section h3 {
        font-size: 1.2rem;
        color: #2d3436;
        margin: 20px 0 10px;
    }

    .terms-section p,
    .terms-section li {
        color: #555;
        line-height: 1.8;
        margin-bottom: 15px;
        text-align: justify;
    }

    .terms-section ul {
        margin-left: 30px;
        margin-bottom: 20px;
    }

    .terms-section ul li {
        margin-bottom: 10px;
    }

    .last-updated {
        text-align: center;
        color: #888;
        font-size: 0.9rem;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }
</style>

<div class="terms-container">
    <div class="terms-header">
        <h1>Terms & Conditions</h1>
        <p>Please read these terms and conditions carefully before using our service</p>
    </div>

    <div class="terms-section">
        <h2>1. Introduction</h2>
        <p>
            Welcome to RecoltePure. These Terms and Conditions govern your use of our website and the purchase of
            products from our platform. By accessing our website and placing an order, you accept these terms in full.
            If you disagree with any part of these terms, please do not use our website.
        </p>
    </div>

    <div class="terms-section">
        <h2>2. Product Information</h2>
        <p>
            We strive to provide accurate descriptions and images of our farm-fresh products. However, please note:
        </p>
        <ul>
            <li>Product appearance may vary slightly from images due to natural variations in fresh produce</li>
            <li>Weights and quantities are approximate and may vary by ±5%</li>
            <li>We reserve the right to substitute products of equal or greater value if items are unavailable</li>
            <li>All products are grown and sourced locally from verified farmers</li>
        </ul>
    </div>

    <div class="terms-section">
        <h2>3. Orders and Pricing</h2>
        <h3>3.1 Order Acceptance</h3>
        <p>
            All orders are subject to availability and confirmation. We reserve the right to refuse or cancel any order
            at our discretion. If your order is cancelled after payment, a full refund will be issued.
        </p>

        <h3>3.2 Pricing</h3>
        <p>
            All prices are listed in USD and are subject to change without notice. The price at the time of order
            confirmation will be honored. Prices include applicable taxes unless otherwise stated.
        </p>
    </div>

    <div class="terms-section">
        <h2>4. Payment</h2>
        <p>
            We accept payment through Stripe, which supports various payment methods including credit cards, debit
            cards, and digital wallets. Payment must be completed at the time of order. All transactions are secure and
            encrypted.
        </p>
    </div>

    <div class="terms-section">
        <h2>5. Delivery</h2>
        <h3>5.1 Delivery Times</h3>
        <p>
            We aim to deliver fresh products within 24-48 hours of order confirmation. Delivery times may vary based on
            location and product availability.
        </p>

        <h3>5.2 Delivery Charges</h3>
        <p>
            Delivery charges are calculated based on your location and order value. Free delivery may be available for
            orders above a certain amount.
        </p>

        <h3>5.3 Failed Deliveries</h3>
        <p>
            If delivery cannot be completed due to incorrect address or unavailability, additional delivery charges may
            apply for re-delivery attempts.
        </p>
    </div>

    <div class="terms-section">
        <h2>6. Returns and Refunds</h2>
        <h3>6.1 Fresh Produce Policy</h3>
        <p>
            Due to the perishable nature of our products, we cannot accept returns unless the product is damaged,
            defective, or not as described. Claims must be made within 24 hours of delivery with photographic evidence.
        </p>

        <h3>6.2 Refund Process</h3>
        <p>
            Approved refunds will be processed within 7-10 business days to the original payment method.
        </p>
    </div>

    <div class="terms-section">
        <h2>7. User Accounts</h2>
        <p>
            When creating an account, you agree to:
        </p>
        <ul>
            <li>Provide accurate and complete information</li>
            <li>Maintain the security of your account credentials</li>
            <li>Accept responsibility for all activities under your account</li>
            <li>Notify us immediately of any unauthorized access</li>
        </ul>
    </div>

    <div class="terms-section">
        <h2>8. Privacy and Data Protection</h2>
        <p>
            We are committed to protecting your privacy. Your personal information is collected and used in accordance
            with our Privacy Policy. We do not sell or share your personal information with third parties except as
            necessary to process your orders.
        </p>
    </div>

    <div class="terms-section">
        <h2>9. Intellectual Property</h2>
        <p>
            All content on this website, including text, images, logos, and design elements, is the property of
            RecoltePure and is protected by copyright laws. Unauthorized use is prohibited.
        </p>
    </div>

    <div class="terms-section">
        <h2>10. Limitation of Liability</h2>
        <p>
            RecoltePure shall not be liable for any indirect, incidental, or consequential damages arising from the use
            of our products or services. Our liability is limited to the purchase price of the products in question.
        </p>
    </div>

    <div class="terms-section">
        <h2>11. Farmer Partners</h2>
        <p>
            All farmers on our platform are verified and must meet our quality standards. However, RecoltePure acts as a
            marketplace and is not directly responsible for the production of goods by individual farmers.
        </p>
    </div>

    <div class="terms-section">
        <h2>12. Modifications to Terms</h2>
        <p>
            We reserve the right to modify these Terms and Conditions at any time. Changes will be effective immediately
            upon posting to the website. Your continued use of the service constitutes acceptance of the modified terms.
        </p>
    </div>

    <div class="terms-section">
        <h2>13. Governing Law</h2>
        <p>
            These Terms and Conditions are governed by and construed in accordance with applicable laws. Any disputes
            shall be resolved in the appropriate courts of jurisdiction.
        </p>
    </div>

    <div class="terms-section">
        <h2>14. Contact Information</h2>
        <p>
            If you have any questions about these Terms and Conditions, please contact us at:
        </p>
        <p>
            <strong>Email:</strong> support@recoltepure.com<br>
            <strong>Phone:</strong> +1 (555) 123-4567<br>
            <strong>Address:</strong> 123 Farm Road, Green Valley, CA 12345
        </p>
    </div>

    <div class="last-updated">
        Last Updated: January 22, 2026
    </div>
</div>

<?php include 'view/layout/footer.php'; ?>