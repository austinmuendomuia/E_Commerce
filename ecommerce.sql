<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechShop - Premium Electronics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global Styles */
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #e63946;
            --warning: #ff9e00;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --shadow: 0 4px 6px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .page {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s, transform 0.5s;
            padding: 30px 0 60px;
            flex: 1;
        }
        
        .page.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: white;
            color: var(--primary);
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            font-size: 16px;
            text-align: center;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c1121f;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 32px;
            color: var(--dark);
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        /* Header Styles */
        header {
            background-color: white;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        .logo span {
            color: var(--success);
        }
        
        .search-bar {
            flex: 1;
            max-width: 500px;
            margin: 0 20px;
            position: relative;
        }
        
        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid var(--light-gray);
            border-radius: 30px;
            font-size: 16px;
        }
        
        .search-bar button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
        }
        
        .header-icons {
            display: flex;
            gap: 20px;
        }
        
        .icon-btn {
            background: none;
            border: none;
            position: relative;
            cursor: pointer;
            color: var(--dark);
            font-size: 20px;
            text-decoration: none;
        }
        
        .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--success);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        nav {
            background-color: var(--primary);
            padding: 12px 0;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 25px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            padding: 5px 10px;
            border-radius: 4px;
        }
        
        .nav-links a:hover, .nav-links a.active {
            background-color: rgba(255,255,255,0.2);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #4361ee, #4cc9f0);
            color: white;
            padding: 80px 0;
            text-align: center;
            margin-bottom: 50px;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        /* Categories */
        .categories {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        
        .category-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            padding: 30px 15px;
            text-decoration: none;
            color: var(--dark);
            cursor: pointer;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .category-icon {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .category-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        /* Products */
        .products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 50px;
        }
        
        .product-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .product-img {
            height: 200px;
            background-color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .product-img img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }
        
        .product-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: var(--success);
            color: white;
            padding: 5px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-category {
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .product-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .product-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .price-current {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .price-old {
            font-size: 16px;
            color: var(--gray);
            text-decoration: line-through;
        }
        
        .product-rating {
            color: #ffc107;
            margin-bottom: 15px;
        }
        
        .product-actions {
            display: flex;
            gap: 10px;
        }
        
        .action-btn {
            flex: 1;
            padding: 10px;
            background-color: var(--light-gray);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        
        .action-btn:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .add-to-cart {
            background-color: var(--primary);
            color: white;
            flex: 2;
        }
        
        .add-to-cart:hover {
            background-color: var(--secondary);
        }
        
        /* Cart Page */
        .cart-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .cart-items {
            flex: 2;
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 25px;
        }
        
        .cart-summary {
            flex: 1;
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 25px;
            align-self: flex-start;
        }
        
        .cart-item {
            display: flex;
            padding: 20px 0;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-img {
            width: 120px;
            height: 120px;
            background: var(--light-gray);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }
        
        .cart-item-img img {
            max-width: 80%;
            max-height: 80%;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .cart-item-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .cart-item-actions {
            display: flex;
            gap: 15px;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid var(--light-gray);
            border-radius: 30px;
            overflow: hidden;
        }
        
        .quantity-btn {
            width: 35px;
            height: 35px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            background-color: var(--light-gray);
        }
        
        .quantity-input {
            width: 50px;
            height: 35px;
            border: none;
            text-align: center;
            font-size: 16px;
        }
        
        .remove-btn {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .cart-summary h3 {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .summary-total {
            font-size: 20px;
            font-weight: 700;
            padding-top: 15px;
            border-top: 1px solid var(--light-gray);
            margin-top: 10px;
        }
        
        /* Login Page */
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 60vh;
        }
        
        .auth-form {
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }
        
        .auth-form h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--light-gray);
            border-radius: 8px;
            font-size: 16px;
            transition: var(--transition);
        }
        
        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .form-options a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .form-options a:hover {
            text-decoration: underline;
        }
        
        .form-switch {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
        }
        
        .form-switch a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .form-switch a:hover {
            text-decoration: underline;
        }
        
        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 60px 0 30px;
            margin-top: auto;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .footer-col h3 {
            font-size: 20px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-col h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--success);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .footer-links a:hover {
            color: var(--success);
            padding-left: 5px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #343a40;
            border-radius: 50%;
            color: white;
            transition: var(--transition);
        }
        
        .social-link:hover {
            background-color: var(--success);
            transform: translateY(-5px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #343a40;
            color: #adb5bd;
            font-size: 14px;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .categories,
            .products,
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .cart-container {
                flex-direction: column;
            }
        }
        
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-bar {
                max-width: 100%;
                margin: 10px 0;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero {
                padding: 50px 0;
            }
            
            .hero h1 {
                font-size: 28px;
            }
            
            .hero p {
                font-size: 16px;
            }
            
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .categories,
            .products {
                grid-template-columns: 1fr;
            }
            
            .auth-form {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="top-bar">
                <a href="#" class="logo" onclick="showPage('home')">Tech<span>Shop</span></a>
                <div class="search-bar">
                    <input type="text" placeholder="Search for products...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="header-icons">
                    <button class="icon-btn" onclick="showPage('account')">
                        <i class="far fa-user"></i>
                    </button>
                    <button class="icon-btn">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="icon-btn cart-btn" onclick="showPage('cart')">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge" id="cart-count">0</span>
                    </button>
                </div>
            </div>
        </div>
        
        <nav>
            <div class="container">
                <ul class="nav-links">
                    <li><a href="#" onclick="showPage('home')" class="active"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="#" onclick="showCategory('smartphones')">Smartphones</a></li>
                    <li><a href="#" onclick="showCategory('laptops')">Laptops</a></li>
                    <li><a href="#" onclick="showCategory('tablets')">Tablets</a></li>
                    <li><a href="#" onclick="showCategory('headphones')">Headphones</a></li>
                    <li><a href="#" onclick="showCategory('wearables')">Wearables</a></li>
                    <li><a href="#" onclick="showCategory('accessories')">Accessories</a></li>
                    <li><a href="#">Deals</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Home Page -->
    <section id="home" class="page active">
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Premium Electronics at Unbeatable Prices</h1>
                <p>Discover the latest gadgets, smartphones, laptops, and accessories with exclusive discounts and fast delivery.</p>
                <a href="#products" class="btn btn-primary">Shop Now</a>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="container">
            <h2 class="section-title">Browse Categories</h2>
            <div class="categories">
                <div class="category-card" onclick="showCategory('smartphones')">
                    <div class="category-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Smartphones</h3>
                    <p>24 Products</p>
                </div>
                <div class="category-card" onclick="showCategory('laptops')">
                    <div class="category-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Laptops</h3>
                    <p>18 Products</p>
                </div>
                <div class="category-card" onclick="showCategory('tablets')">
                    <div class="category-icon">
                        <i class="fas fa-tablet-alt"></i>
                    </div>
                    <h3>Tablets</h3>
                    <p>15 Products</p>
                </div>
                <div class="category-card" onclick="showCategory('headphones')">
                    <div class="category-icon">
                        <i class="fas fa-headphones"></i>
                    </div>
                    <h3>Headphones</h3>
                    <p>32 Products</p>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="container" id="products">
            <h2 class="section-title">Featured Products</h2>
            <div class="products" id="featured-products">
                <!-- Featured products will be inserted here by JavaScript -->
            </div>
        </section>
    </section>

    <!-- Product Category Page -->
    <section id="category" class="page">
        <section class="container">
            <h2 class="section-title" id="category-title">Products</h2>
            <div class="products" id="category-products">
                <!-- Category products will be inserted here by JavaScript -->
            </div>
        </section>
    </section>

    <!-- Cart Page -->
    <section id="cart" class="page">
        <section class="container">
            <h2 class="section-title">Your Shopping Cart</h2>
            <div class="cart-container">
                <div class="cart-items" id="cart-items">
                    <!-- Cart items will be inserted here by JavaScript -->
                </div>
                
                <div class="cart-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">$0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span id="cart-tax">$0.00</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span id="cart-total">$0.00</span>
                    </div>
                    <button class="btn btn-primary" style="width: 100%; margin-top: 20px;">Proceed to Checkout</button>
                    <button class="btn btn-outline" style="width: 100%; margin-top: 10px;" onclick="showPage('home')">Continue Shopping</button>
                </div>
            </div>
        </section>
    </section>

    <!-- Login Page -->
    <section id="login" class="page">
        <section class="container auth-container">
            <div class="auth-form">
                <h2>Login to Your Account</h2>
                <form id="login-form">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="login-email" required placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="login-password" required placeholder="Enter your password">
                    </div>
                    <div class="form-options">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                </form>
                <div class="form-switch">
                    Don't have an account? <a href="#" onclick="showPage('register')">Register</a>
                </div>
            </div>
        </section>
    </section>

    <!-- Register Page -->
    <section id="register" class="page">
        <section class="container auth-container">
            <div class="auth-form">
                <h2>Create an Account</h2>
                <form id="register-form">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="register-name" required placeholder="Enter your full name">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="register-email" required placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="register-password" required placeholder="Create a password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" id="register-confirm" required placeholder="Confirm your password">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
                </form>
                <div class="form-switch">
                    Already have an account? <a href="#" onclick="showPage('login')">Login</a>
                </div>
            </div>
        </section>
    </section>

    <!-- Account Page -->
    <section id="account" class="page">
        <section class="container">
            <h2 class="section-title">My Account</h2>
            <div class="auth-form">
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--light-gray); display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 40px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 id="account-name">Guest User</h3>
                    <p id="account-email">guest@example.com</p>
                </div>
                
                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button class="btn btn-outline" style="flex: 1;" onclick="showPage('login')">Login</button>
                    <button class="btn btn-primary" style="flex: 1;" onclick="showPage('register')">Register</button>
                    <button class="btn btn-danger" style="flex: 1;" onclick="logout()">Logout</button>
                </div>
            </div>
        </section>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>TechShop</h3>
                    <p>Your one-stop destination for the latest electronics and gadgets at competitive prices with fast shipping and excellent customer service.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#" onclick="showPage('home')">Home</a></li>
                        <li><a href="#" onclick="showCategory('smartphones')">Shop</a></li>
                        <li><a href="#">Categories</a></li>
                        <li><a href="#">Deals & Offers</a></li>
                        <li><a href="#">New Arrivals</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Customer Service</h3>
                    <ul class="footer-links">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Returns & Exchanges</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Newsletter</h3>
                    <p>Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
                    <div class="search-bar" style="margin-top: 15px;">
                        <input type="email" placeholder="Enter your email">
                        <button style="background: var(--success); color: white; border-radius: 0 30px 30px 0; padding: 0 15px; right: 0;"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 TechShop. All Rights Reserved. | Designed with <i class="fas fa-heart" style="color: var(--success);"></i> for Tech Lovers</p>
            </div>
        </div>
    </footer>

    <script>
        // Sample product data
        const products = [
            {
                id: 1,
                name: "Apple iPhone 13 Pro",
                price: 999.00,
                category: "smartphones",
                image: "https://via.placeholder.com/300x300?text=iPhone+13",
                description: "The latest iPhone with Pro camera system.",
                rating: 4.5,
                reviews: 128
            },
            {
                id: 2,
                name: "MacBook Pro 14\" M1 Pro",
                price: 1899.00,
                category: "laptops",
                image: "https://via.placeholder.com/300x300?text=MacBook+Pro",
                description: "Powerful laptop for professionals.",
                rating: 4.7,
                reviews: 94
            },
            {
                id: 3,
                name: "Sony WH-1000XM4",
                price: 349.99,
                category: "headphones",
                image: "https://via.placeholder.com/300x300?text=Sony+Headphones",
                description: "Industry leading noise cancellation.",
                rating: 4.9,
                reviews: 247
            },
            {
                id: 4,
                name: "Samsung Galaxy S22 Ultra",
                price: 1199.99,
                category: "smartphones",
                image: "https://via.placeholder.com/300x300?text=Samsung+Galaxy",
                description: "Premium Android smartphone with S Pen.",
                rating: 4.6,
                reviews: 187
            },
            {
                id: 5,
                name: "Apple Watch Series 7",
                price: 399.00,
                category: "wearables",
                image: "https://via.placeholder.com/300x300?text=Apple+Watch",
                description: "Advanced health and fitness tracker.",
                rating: 4.4,
                reviews: 142
            },
            {
                id: 6,
                name: "Apple AirPods Pro",
                price: 249.00,
                category: "headphones",
                image: "https://via.placeholder.com/300x300?text=AirPods+Pro",
                description: "Active Noise Cancellation for immersive sound.",
                rating: 4.8,
                reviews: 324
            },
            {
                id: 7,
                name: "Microsoft Surface Laptop 4",
                price: 1299.00,
                category: "laptops",
                image: "https://via.placeholder.com/300x300?text=Surface+Laptop",
                description: "Sleek design with powerful performance.",
                rating: 4.3,
                reviews: 76
            },
            {
                id: 8,
                name: "Apple iPad Pro 12.9\"",
                price: 1099.00,
                category: "tablets",
                image: "https://via.placeholder.com/300x300?text=iPad+Pro",
                description: "The ultimate iPad experience with M1 chip.",
                rating: 4.9,
                reviews: 210
            },
            {
                id: 9,
                name: "Samsung Galaxy Tab S8",
                price: 699.99,
                category: "tablets",
                image: "https://via.placeholder.com/300x300?text=Galaxy+Tab",
                description: "Powerful Android tablet for productivity.",
                rating: 4.5,
                reviews: 93
            },
            {
                id: 10,
                name: "Bose QuietComfort 45",
                price: 329.00,
                category: "headphones",
                image: "https://via.placeholder.com/300x300?text=Bose+QC45",
                description: "Premium noise cancelling headphones.",
                rating: 4.7,
                reviews: 156
            }
        ];

        // Cart data
        let cart = [];
        let user = null;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderFeaturedProducts();
            updateCartCount();
            
            // Setup form submissions
            document.getElementById('login-form').addEventListener('submit', login);
            document.getElementById('register-form').addEventListener('submit', register);
        });

        // Show a specific page
        function showPage(pageId) {
            // Hide all pages
            document.querySelectorAll('.page').forEach(page => {
                page.classList.remove('active');
            });
            
            // Show the requested page
            document.getElementById(pageId).classList.add('active');
            
            // Update navigation active state
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.classList.remove('active');
            });
            
            // Update active nav link for home
            if (pageId === 'home') {
                document.querySelector('.nav-links a[onclick="showPage(\'home\')"]').classList.add('active');
            }
            
            // Special handling for certain pages
            if (pageId === 'cart') {
                renderCart();
            } else if (pageId === 'account') {
                updateAccountInfo();
            }
        }

        // Show a product category
        function showCategory(category) {
            showPage('category');
            
            // Set category title
            document.getElementById('category-title').textContent = category.charAt(0).toUpperCase() + category.slice(1);
            
            // Filter products by category
            const categoryProducts = products.filter(product => product.category === category);
            
            // Render products
            const productsContainer = document.getElementById('category-products');
            productsContainer.innerHTML = '';
            
            categoryProducts.forEach(product => {
                productsContainer.innerHTML += createProductCard(product);
            });
        }

        // Render featured products on home page
        function renderFeaturedProducts() {
            const productsContainer = document.getElementById('featured-products');
            productsContainer.innerHTML = '';
            
            // Get 8 featured products
            const featured = products.slice(0, 8);
            
            featured.forEach(product => {
                productsContainer.innerHTML += createProductCard(product);
            });
            
            // Add event listeners to add-to-cart buttons
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    addToCart(productId);
                });
            });
        }

        // Create HTML for a product card
        function createProductCard(product) {
            return `
                <div class="product-card">
                    <div class="product-img">
                        <img src="${product.image}" alt="${product.name}">
                        <div class="product-tag">New</div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">${product.category.charAt(0).toUpperCase() + product.category.slice(1)}</div>
                        <h3 class="product-name">${product.name}</h3>
                        <div class="product-price">
                            <span class="price-current">$${product.price.toFixed(2)}</span>
                        </div>
                        <div class="product-rating">
                            ${createRatingStars(product.rating)}
                            <span>(${product.reviews})</span>
                        </div>
                        <div class="product-actions">
                            <button class="action-btn"><i class="far fa-heart"></i></button>
                            <button class="action-btn"><i class="fas fa-chart-bar"></i></button>
                            <button class="action-btn add-to-cart" data-id="${product.id}"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Create rating stars HTML
        function createRatingStars(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const halfStar = rating % 1 >= 0.5;
            
            for (let i = 0; i < fullStars; i++) {
                stars += '<i class="fas fa-star"></i>';
            }
            
            if (halfStar) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            }
            
            const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                stars += '<i class="far fa-star"></i>';
            }
            
            return stars;
        }

        // Add product to cart
        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            
            // Check if product is already in cart
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1
                });
            }
            
            // Update UI
            updateCartCount();
            
            // Show notification
            showNotification(`Added ${product.name} to cart`);
        }

        // Update cart count in header
        function updateCartCount() {
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('cart-count').textContent = count;
        }

        // Render cart page
        function renderCart() {
            const cartItemsContainer = document.getElementById('cart-items');
            
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added anything to your cart yet</p>
                        <a href="#" class="btn btn-primary" onclick="showPage('home')">Continue Shopping</a>
                    </div>
                `;
                
                // Clear summary
                document.getElementById('cart-subtotal').textContent = '$0.00';
                document.getElementById('cart-tax').textContent = '$0.00';
                document.getElementById('cart-total').textContent = '$0.00';
                
                return;
            }
            
            // Render cart items
            cartItemsContainer.innerHTML = '';
            let subtotal = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                cartItemsContainer.innerHTML += `
                    <div class="cart-item">
                        <div class="cart-item-img">
                            <img src="${item.image}" alt="${item.name}">
                        </div>
                        <div class="cart-item-details">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-price">$${item.price.toFixed(2)}</div>
                            <div class="cart-item-actions">
                                <div class="quantity-control">
                                    <button class="quantity-btn minus" onclick="updateCartItem(${item.id}, -1)">-</button>
                                    <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                                    <button class="quantity-btn plus" onclick="updateCartItem(${item.id}, 1)">+</button>
                                </div>
                                <button class="remove-btn" onclick="removeCartItem(${item.id})">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            // Calculate totals
            const tax = subtotal * 0.08;
            const total = subtotal + tax;
            
            // Update summary
            document.getElementById('cart-subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('cart-tax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
        }

        // Update cart item quantity
        function updateCartItem(productId, change) {
            const item = cart.find(item => item.id === productId);
            if (!item) return;
            
            item.quantity += change;
            
            // Remove if quantity becomes 0
            if (item.quantity <= 0) {
                cart = cart.filter(item => item.id !== productId);
            }
            
            // Update UI
            updateCartCount();
            renderCart();
        }

        // Remove item from cart
        function removeCartItem(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCartCount();
            renderCart();
            showNotification('Item removed from cart');
        }

        // Handle login
        function login(e) {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            
            // Simple validation
            if (email && password) {
                user = {
                    name: "John Doe",
                    email: email
                };
                
                showNotification('Login successful!');
                showPage('home');
            } else {
                showNotification('Please enter email and password', 'error');
            }
        }

        // Handle registration
        function register(e) {
            e.preventDefault();
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('register-confirm').value;
            
            // Simple validation
            if (password !== confirmPassword) {
                showNotification('Passwords do not match', 'error');
                return;
            }
            
            if (name && email && password) {
                user = {
                    name: name,
                    email: email
                };
                
                showNotification('Registration successful!');
                showPage('home');
            } else {
                showNotification('Please fill all fields', 'error');
            }
        }

        // Logout
        function logout() {
            user = null;
            showNotification('You have been logged out');
            showPage('home');
        }

        // Update account info
        function updateAccountInfo() {
            if (user) {
                document.getElementById('account-name').textContent = user.name;
                document.getElementById('account-email').textContent = user.email;
            } else {
                document.getElementById('account-name').textContent = 'Guest User';
                document.getElementById('account-email').textContent = 'guest@example.com';
            }
        }

        // Show notification
        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.position = 'fixed';
            notification.style.bottom = '20px';
            notification.style.right = '20px';
            notification.style.backgroundColor = type === 'error' ? 'var(--danger)' : 'var(--success)';
            notification.style.color = 'white';
            notification.style.padding = '15px 25px';
            notification.style.borderRadius = '5px';
            notification.style.zIndex = '1000';
            notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(20px)';
            notification.style.transition = 'opacity 0.3s, transform 0.3s';
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 10);
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>