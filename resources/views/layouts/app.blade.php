<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nazleh - Premium Shopping Experience</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="stylesheet" href="css/myul.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        
        :root {
            --primary-color: #3a86ff;
            --secondary-color: #ff006e;
            --accent-color: #8338ec;
            --dark-color: #1a1a2e;
            --light-color: #f8f9fa;
            --success-color: #4cc9f0;
            --warning-color: #ffbe0b;
            --text-dark: #333;
            --text-light: #6c757d;
            --gradient-primary: linear-gradient(135deg, #3a86ff 0%, #8338ec 100%);
            --gradient-secondary: linear-gradient(135deg, #ff006e 0%, #ffbe0b 100%);
            --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background-color: var(--light-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            z-index: 1000;
            transition: var(--transition);
        }

        .header.scrolled {
            box-shadow: var(--shadow-md);
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2px;
        }

        .logo span {
            font-size: 12px;
            color: var(--text-light);
            letter-spacing: 1px;
        }

        .nav-menu ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            position: relative;
            padding: 8px 0;
            transition: var(--transition);
        }

        .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link:hover:after, .nav-link.active:after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-box input {
            padding: 10px 15px;
            padding-right: 40px;
            border: 1px solid #e2e8f0;
            border-radius: 30px;
            font-size: 14px;
            width: 200px;
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            width: 250px;
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            transition: var(--transition);
        }

        .search-box input:focus + .search-btn {
            color: var(--primary-color);
        }

        .cart-icon, .user-btn {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-color);
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .cart-icon:hover, .user-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--secondary-color);
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background: var(--text-dark);
            border-radius: 2px;
            transition: var(--transition);
        }

        /* Hero Section */
        .hero {
            padding: 160px 0 80px;
            background: linear-gradient(135deg, rgba(248, 249, 250, 0.9) 0%, rgba(255, 255, 255, 0.9) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero:before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(58, 134, 255, 0.05) 0%, transparent 70%);
            z-index: -1;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .hero-text {
            flex: 1;
            max-width: 550px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .brand-highlight {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-secondary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-dark);
            border: 2px solid #e2e8f0;
        }

        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            position: relative;
        }

        .hero-graphic {
            position: relative;
            width: 400px;
            height: 400px;
        }

        .floating-card {
            position: absolute;
            background: white;
            padding: 15px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            transition: var(--transition);
            animation: float 6s ease-in-out infinite;
        }

        .floating-card i {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .floating-card span {
            font-size: 10px;
            font-weight: 600;
            text-align: center;
        }

        .floating-card:hover {
            transform: scale(1.1) translateY(-5px);
            z-index: 10;
        }

        .card-1 {
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, #ffbe0b 0%, #ff9e00 100%);
            color: white;
            animation-delay: 0s;
        }

        .card-2 {
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #8338ec 0%, #5a13c8 100%);
            color: white;
            animation-delay: 1s;
        }

        .card-3 {
            bottom: 20px;
            left: 20px;
            background: linear-gradient(135deg, #3a86ff 0%, #1a56db 100%);
            color: white;
            animation-delay: 2s;
        }

        .card-4 {
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ff006e 0%, #c5014f 100%);
            color: white;
            animation-delay: 3s;
        }

        .card-5 {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, #4cc9f0 0%, #2a9d8f 100%);
            color: white;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-15px) rotate(3deg);
            }
        }

        /* Section Styles */
        section {
            padding: 80px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-header h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Categories Section */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .category-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            text-align: center;
            position: relative;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .category-image {
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .category-image i {
            font-size: 50px;
            color: var(--primary-color);
        }

        .category-content {
            padding: 20px;
        }

        .category-content h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .category-content p {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .category-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .category-link:hover {
            gap: 8px;
        }

        /* Products Section */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .product-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--secondary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }

        .product-image {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            max-width: 80%;
            max-height: 80%;
            transition: var(--transition);
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-actions {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.9);
            transition: var(--transition);
        }

        .product-card:hover .product-actions {
            bottom: 0;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-color);
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        .product-content {
            padding: 20px;
        }

        .product-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .current-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .original-price {
            font-size: 14px;
            color: var(--text-light);
            text-decoration: line-through;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 15px;
        }

        .stars {
            color: var(--warning-color);
        }

        .rating-count {
            font-size: 12px;
            color: var(--text-light);
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 10px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .load-more-section {
            text-align: center;
        }

        /* About Section */
        .about {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .about-text {
            flex: 1;
        }

        .about-text h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
        }

        .about-text p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: var(--text-light);
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .feature {
            text-align: center;
            padding: 25px 20px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .feature:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .feature i {
            font-size: 40px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .feature h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .feature p {
            font-size: 14px;
            margin-bottom: 0;
        }

        .about-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .about-graphic {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px 20px;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stat-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }

        .stat-card p {
            font-size: 14px;
            color: var(--text-light);
        }

        /* Contact Section */
        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .contact-item i {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .contact-item h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .contact-item p {
            color: var(--text-light);
        }

        .contact-form {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: var(--transition);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.1);
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3,
        .footer-section h4 {
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .footer-section h3:after,
        .footer-section h4:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .footer-section p {
            color: #a0aec0;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #a0aec0;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-section ul li a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #2d3748;
            color: #a0aec0;
            font-size: 14px;
        }

        /* Cart Sidebar */
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .cart-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 380px;
            height: 100%;
            background: white;
            z-index: 1000;
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.active {
            right: 0;
        }

        .cart-header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .close-cart {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-light);
            transition: var(--transition);
        }

        .close-cart:hover {
            color: var(--secondary-color);
            transform: rotate(90deg);
        }

        .cart-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-image img {
            max-width: 70%;
            max-height: 70%;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quantity-controls button {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .quantity-controls button:hover {
            background: var(--primary-color);
            color: white;
        }

        .quantity-controls span {
            width: 30px;
            text-align: center;
        }

        .remove-item {
            color: var(--secondary-color);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            margin-left: auto;
            transition: var(--transition);
        }

        .remove-item:hover {
            color: #c5014f;
        }

        .cart-footer {
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 700;
        }

        .checkout-btn {
            width: 100%;
        }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
            display: none;
        }

        .empty-cart.visible {
            display: block;
        }

        .empty-cart i {
            font-size: 50px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Product Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .product-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            background: white;
            border-radius: var(--border-radius);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            overflow-y: auto;
            transition: var(--transition);
        }

        .product-modal.active {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1);
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            background: white;
            z-index: 2;
        }

        .modal-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-light);
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--secondary-color);
            transform: rotate(90deg);
        }

        .modal-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 25px;
        }

        .modal-image {
            background: #f8f9fa;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .modal-image img {
            max-width: 100%;
            max-height: 300px;
        }

        .modal-details {
            display: flex;
            flex-direction: column;
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .product-description {
            margin-bottom: 20px;
            color: var(--text-light);
            line-height: 1.6;
        }

        .quantity-selector {
            margin-bottom: 25px;
        }

        .quantity-selector label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .quantity-controls-modal {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-controls-modal button {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .quantity-controls-modal button:hover {
            background: var(--primary-color);
            color: white;
        }

                .quantity-controls-modal input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-weight: 600;
        }

        .add-to-cart-modal {
            margin-top: auto;
        }

        .modal-comments {
            padding: 25px;
            border-top: 1px solid #e2e8f0;
        }

        .modal-comments h4 {
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .comments-list {
            margin-bottom: 30px;
        }

        .comment {
            padding: 15px;
            background: #f8f9fa;
            border-radius: var(--border-radius);
            margin-bottom: 15px;
        }

        .comment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-author {
            font-weight: 600;
        }

        .comment-rating {
            color: var(--warning-color);
        }

        .comment-text {
            color: var(--text-light);
        }

        .comment-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: var(--border-radius);
        }

        .comment-form h5 {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .rating-input {
            margin-bottom: 15px;
        }

        .rating-input label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .rating-input .stars {
            cursor: pointer;
        }

        .rating-input .stars i {
            transition: var(--transition);
        }

        .rating-input .stars i:hover,
        .rating-input .stars i.active {
            transform: scale(1.2);
        }

        /* Auth Styles */
        .auth-container {
            padding: 120px 0 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
        }

        .auth-form {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 450px;
        }

        .auth-form h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        .auth-form .form-group {
            margin-bottom: 20px;
        }

        .auth-form .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: var(--transition);
        }

        .auth-form .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.1);
        }

        .auth-form .remember {
            display: flex;
            align-items: center;
        }

        .auth-form .remember label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .auth-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-light);
        }

        .auth-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #b91c1c;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 10px 0;
            min-width: 150px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition);
        }

        .user-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
        }

        .dropdown-menu a:hover {
            background: #f8f9fa;
            color: var(--primary-color);
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .auth-buttons a {
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: var(--transition);
        }

        .auth-buttons .btn-outline {
            background: transparent;
            color: var(--text-dark);
            border: 2px solid #e2e8f0;
        }

        .auth-buttons .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .auth-buttons .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .mobile-auth {
            display: none;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-text {
                max-width: 100%;
            }
            
            .hero-buttons {
                justify-content: center;
            }
            
            .about-content {
                flex-direction: column;
            }
            
            .contact-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: white;
                transition: var(--transition);
                z-index: 999;
                padding: 20px;
            }
            
            .nav-menu.active {
                left: 0;
            }
            
            .nav-menu ul {
                flex-direction: column;
                gap: 20px;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .mobile-menu-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }
            
            .mobile-menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }
            
            .mobile-menu-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .modal-content {
                grid-template-columns: 1fr;
            }
            
            .cart-sidebar {
                width: 100%;
                right: -100%;
            }

            .auth-buttons {
                display: none;
            }
            
            .mobile-auth {
                display: block;
            }
            
            .user-dropdown {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .section-header h2 {
                font-size: 2rem;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .about-features {
                grid-template-columns: 1fr;
            }
            
            .about-graphic {
                grid-template-columns: 1fr;
            }
            
            .floating-card {
                width: 80px;
                height: 80px;
            }
            
            .floating-card i {
                font-size: 20px;
            }
            
            .floating-card span {
                font-size: 9px;
            }
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .hidden {
            display: none;
        }

        .visible {
            display: block;
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        .slide-up {
            animation: slideUp 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>
    @include('partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    @include('partials.cart')
    
    @yield('modals')
    
    <script>
        // جميع scripts الأساسية هنا
        const API_BASE_URL = '/api';
        
        // ... باقي الـ scripts الأساسية
    </script>
    
    @yield('scripts')
</body>
</html>