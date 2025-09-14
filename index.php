<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Palace Gala Dinner - Book Your Tickets</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a365d;
            --secondary: #d4af37;
            --accent: #2d3748;
            --light: #f7fafc;
            --dark: #2d3748;
            --success: #38a169;
            --danger: #e53e3e;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background-color: #f8f9fa;
            line-height: 1.6;
            scroll-behavior: smooth;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(135deg, var(--primary) 0%, #2c5282 100%);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        header.scrolled {
            padding: 0.5rem 0;
            background: rgba(26, 54, 93, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        
        .logo-img {
            height: 50px; /* Adjust based on your image proportions */
            width: auto;
            margin-right: 15px;
            transition: transform 0.3s ease;
        }
        
        .logo:hover .logo-img {
            transform: scale(1.05);
        }
        
        .logo i {
            margin-right: 10px;
            color: var(--secondary);
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 2rem;
            position: relative;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            padding: 0.5rem 0;
        }
        
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: width 0.3s ease;
        }
        
        nav ul li a:hover::after {
            width: 100%;
        }
        
        nav ul li a:hover {
            color: var(--secondary);
        }
        
        /* Hero Section */
        .hero {
            background: url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            height: 500px;
            display: flex;
            align-items: center;
            position: relative;
            color: white;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        
        .hero-content {
            position: relative;
            max-width: 600px;
            padding: 2rem;
            animation: fadeInUp 1s ease-out;
        }
        
        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        .btn {
            display: inline-block;
            background: var(--secondary);
            color: var(--primary);
            padding: 12px 28px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            background: #c99c2c;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Section Styles */
        section {
            padding: 5rem 0;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 1rem;
        }
        
        section h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--secondary);
        }
        
        /* About Section */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        
        .about-text {
            padding-right: 2rem;
        }
        
        .about-image {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }
        
        .about-image:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        
        .about-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }
        
        .about-image:hover img {
            transform: scale(1.05);
        }
        
        /* Pricing Section */
        .pricing {
            background-color: var(--light);
        }
        
        .pricing-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .pricing-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        
        .pricing-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .pricing-header {
            background: var(--primary);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .pricing-body {
            padding: 2rem;
        }
        
        .price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            margin: 1rem 0;
        }
        
        .price-desc {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        /* Seating Chart */
        .seating-section {
            background: linear-gradient(to bottom, #f8f9fa 0%, white 100%);
        }
        
        .seating-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }
        
        .table-categories {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        
        .category {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            flex: 1;
            margin: 0 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .category:hover {
            transform: translateY(-5px);
        }
        
        .category-kings {
            background: rgba(180, 83, 9, 0.1);
            border: 1px solid rgb(180, 83, 9);
        }
        
        .category-vip {
            background: rgba(109, 40, 217, 0.1);
            border: 1px solid rgb(109, 40, 217);
        }
        
        .category-general {
            background: rgba(28, 100, 242, 0.1);
            border: 1px solid rgb(28, 100, 242);
        }
        
        .seating-chart {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1.5rem;
        }
        
        .table {
            background: var(--light);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }
        
        .table::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        
        .table:hover::before {
            transform: translateY(0);
        }
        
        .table:hover {
            transform: scale(1.05);
        }
        
        .table.available {
            background: #f0fff4;
            border-color: var(--success);
        }
        
        .table.reserved {
            background: #fed7d7;
            border-color: var(--danger);
            cursor: not-allowed;
        }
        
        .table.selected {
            background: #ebf8ff;
            border-color: #3182ce;
        }
        
        /* Booking Form */
        .booking-form {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        /* Payment & RSVP Section */
        .payment-info {
            background-color: var(--primary);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .payment-info::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 280px;
            height: 310px;
            background: url('Ubumbano No background.png') no-repeat center center/contain;
            opacity: 0.3;
        }
        
        .payment-info h2 {
            color: white;
        }
        
        .info-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
        }
        
        .info-card h3 {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .info-card h3 i {
            margin-right: 10px;
            color: var(--secondary);
        }
        
        .bank-details {
            margin-bottom: 1.5rem;
        }
        
        .bank-detail {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background-color 0.3s;
        }
        
        .bank-detail:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .bank-detail:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
        }
        
        .rsvp-list {
            list-style: none;
        }
        
        .rsvp-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            transition: transform 0.3s;
        }
        
        .rsvp-list li:hover {
            transform: translateX(5px);
        }
        
        .rsvp-list i {
            margin-right: 10px;
            color: var(--secondary);
        }
        
        .prize-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            text-align: center;
            transition: all 0.3s;
        }
        
        .prize-info:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.02);
        }
        
        /* Footer */
        footer {
            background: var(--primary);
            color: white;
            padding: 3rem 0;
            position: relative;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        
        .footer-section h3 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--secondary);
        }
        
        .contact-info {
            list-style: none;
        }
        
        .contact-info li {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .contact-info i {
            margin-right: 10px;
            color: var(--secondary);
        }
        
        .footer-bottom {
            text-align: center;
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-ubumbano {
            position: absolute;
            bottom: 150px;
            left: 20px;
            opacity: 0.8;
        }
        
        .footer-ubumbano img {
            height: 130px;
            width: auto;
            transition: all 0.3s ease;
        }
        
        .footer-ubumbano img:hover {
            opacity: 1;
            transform: scale(1.05);
        }
        
        /* Success/Error Messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .about-content {
                grid-template-columns: 1fr;
            }
            
            .pricing-options {
                grid-template-columns: 1fr 1fr;
            }
            
            .info-cards {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .logo {
                margin-bottom: 1rem;
            }
            
            nav ul {
                margin-top: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            nav ul li {
                margin: 0 0.5rem 0.5rem;
            }
            
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .pricing-options {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .seating-chart {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
            
            .footer-ubumbano {
                position: relative;
                bottom: auto;
                left: auto;
                text-align: center;
                margin-top: 2rem;
            }
            
            .payment-info::before {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="zondi clan.png" alt="Zondi Clan" class="logo-img">
                <span>Royal Palace Gala</span>
            </div>
            <nav>
                <ul>
                    <li><a href="#about">About</a></li>
                    <li><a href="#pricing">Tickets</a></li>
                    <li><a href="#seating">Seating</a></li>
                    <li><a href="#booking">Book Now</a></li>
                    <li><a href="#payment">Payment Info</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-content">
            <h1>Honoring Inkosi Nsikayezwe Zondi</h1>
            <p>Join us for an evening of elegance and celebration at the Annual Royal Palace Gala Dinner</p>
            <a href="#booking" class="btn">Reserve Your Seat</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <h2>About The Event</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>The Royal Palace Gala Dinner is an annual event dedicated to honoring the legacy of Inkosi Nsikayezwe Zondi and celebrating the rich cultural heritage of the Zondi Kings.</p>
                    <p>This prestigious event brings together community leaders, dignitaries, and supporters for an evening of fine dining, cultural performances, and meaningful connections.</p>
                    <p>Hosted by the Ubumbano IwamaZondi Committee, this year's gala will take place at the beautiful Pietermaritzburg Protea Hotel, featuring gourmet cuisine, live entertainment, and inspiring speeches.</p>
                    <p>Proceeds from the event will support community development initiatives and educational programs for the youth.</p>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Gala Dinner Event">
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing">
        <div class="container">
            <h2>Ticket Options</h2>
            <div class="pricing-options">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Kings & Mayors</h3>
                    </div>
                    <div class="pricing-body">
                        <div class="price">Invitation Only</div>
                        <p class="price-desc">Reserved for Royalty and Dignitaries</p>
                        <ul>
                            <li><i class="fas fa-check"></i> Premium Seating</li>
                            <li><i class="fas fa-check"></i> VIP Reception</li>
                            <li><i class="fas fa-check"></i> Gift Package</li>
                            <li><i class="fas fa-check"></i> Photo Opportunity</li>
                        </ul>
                    </div>
                </div>
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>VIP Guests</h3>
                    </div>
                    <div class="pricing-body">
                        <div class="price">R500</div>
                        <p class="price-desc">Preferred seating and benefits</p>
                        <ul>
                            <li><i class="fas fa-check"></i> Priority Seating</li>
                            <li><i class="fas fa-check"></i> Complimentary Drink</li>
                            <li><i class="fas fa-check"></i> Special Recognition</li>
                            <li><i class="fas fa-check"></i> Preferred Parking</li>
                        </ul>
                    </div>
                </div>
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>General Admission</h3>
                    </div>
                    <div class="pricing-body">
                        <div class="price">R250</div>
                        <p class="price-desc">Standard seating</p>
                        <ul>
                            <li><i class="fas fa-check"></i> Gala Dinner Access</li>
                            <li><i class="fas fa-check"></i> Cultural Performances</li>
                            <li><i class="fas fa-check"></i> Event Program</li>
                            <li><i class="fas fa-check"></i> Networking Opportunities</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment & RSVP Information Section -->
    <section id="payment" class="payment-info">
        <div class="container">
            <h2>Payment & RSVP Information</h2>
            <div class="info-cards">
                <div class="info-card">
                    <h3><i class="fas fa-university"></i> Banking Details</h3>
                    <div class="bank-details">
                        <div class="bank-detail">
                            <span class="detail-label">Bank:</span>
                            <span>Nedbank</span>
                        </div>
                        <div class="bank-detail">
                            <span class="detail-label">Account Number:</span>
                            <span>2003668659</span>
                        </div>
                        <div class="bank-detail">
                            <span class="detail-label">Account Holder:</span>
                            <span>Ubumbano LamaZondi</span>
                        </div>
                        <div class="bank-detail">
                            <span class="detail-label">Account Type:</span>
                            <span>Club Account</span>
                        </div>
                        <div class="bank-detail">
                            <span class="detail-label">Branch:</span>
                            <span>Scottville, Pietermaritzburg</span>
                        </div>
                    </div>
                    <p><strong>Important:</strong> Payments must be made 3 weeks prior to the gala dinner.</p>
                </div>
                
                <div class="info-card">
                    <h3><i class="fas fa-phone-alt"></i> RSVP Contacts</h3>
                    <ul class="rsvp-list">
                        <li>
                            <i class="fas fa-user"></i>
                            <div>
                                <strong>Mr Bheka Zondi</strong>
                                <div>Cell: 082 324 0960</div>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-user"></i>
                            <div>
                                <strong>Mr M.G Zondi</strong>
                                <div>Cell: 072 301 8401</div>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-user"></i>
                            <div>
                                <strong>Ms Ngcebo Zondi</strong>
                                <div>Cell: 060 993 0090</div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="prize-info">
                        <h4><i class="fas fa-gift"></i> Special Prizes</h4>
                        <p>Best-dressed Male & Female will win exciting prizes!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seating Section -->
    <section id="seating" class="seating-section">
        <div class="container">
            <h2>Seating Chart</h2>
            <div class="seating-container">
                <div class="table-categories">
                    <div class="category category-kings">
                        <h3>Tables 1-2</h3>
                        <p>Kings & Mayors</p>
                    </div>
                    <div class="category category-vip">
                        <h3>Tables 3-4</h3>
                        <p>VIP Guests</p>
                    </div>
                    <div class="category category-general">
                        <h3>Tables 5-20</h3>
                        <p>General Admission</p>
                    </div>
                </div>
                
                <div class="seating-chart">
                    <!-- Tables will be generated dynamically with JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="booking">
        <div class="container">
            <h2>Book Your Tickets</h2>
            <div class="booking-form">
                <div id="alert-container"></div>
                <div id="loading" class="loading">
                    <div class="spinner"></div>
                    <p>Processing your booking...</p>
                </div>
                
                <form id="ticket-booking-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Home Address</label>
                        <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="table">Select Table</label>
                            <select id="table" name="table" class="form-control" required>
                                <option value="">-- Select Table --</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="seat">Select Seat</label>
                            <select id="seat" name="seat" class="form-control" required>
                                <option value="">-- Select Seat --</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment">Payment Method</label>
                        <select id="payment" name="payment" class="form-control" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="ozow">Ozow Instant EFT</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="bank">Bank Transfer</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Complete Booking</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>The Ubumbano IwamaZondi Committee is dedicated to preserving and promoting the cultural heritage of the Zondi nation through events, education, and community development.</p>
                    <div class="footer-ubumbano">
                        <img src="Ubumbano No background.png" alt="Ubumbano">
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Contact Information</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> Scottville, Pietermaritzburg</li>
                        <li><i class="fas fa-envelope"></i> info@zondigala.co.za</li>
                        <li><i class="fas fa-phone"></i> 078 757 2258</li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Developed By</h3>
                    <p>MZondi Integrated Solutions (Pty) Ltd</p>
                    <p>Professional web development and digital solutions</p>
                    <p>Visit: <a href="https://mzondiintegratedsolutions.co.za" style="color: var(--secondary);">mzondiintegratedsolutions.co.za</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Royal Palace Gala Dinner. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Generate seating chart
        document.addEventListener('DOMContentLoaded', function() {
            const seatingChart = document.querySelector('.seating-chart');
            const tableSelect = document.getElementById('table');
            const seatSelect = document.getElementById('seat');
            
            // Generate tables
            for (let i = 1; i <= 20; i++) {
                // Create table element for seating chart
                const tableElement = document.createElement('div');
                tableElement.className = 'table available';
                tableElement.innerHTML = `<h4>Table ${i}</h4><p>10 Seats</p>`;
                
                // Add click event
                tableElement.addEventListener('click', function() {
                    if (this.classList.contains('available')) {
                        document.querySelectorAll('.table').forEach(t => t.classList.remove('selected'));
                        this.classList.add('selected');
                        tableSelect.value = i;
                        updateSeats(i);
                    }
                });
                
                seatingChart.appendChild(tableElement);
                
                // Add option to table select
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Table ${i}`;
                tableSelect.appendChild(option);
            }
            
            // Table select change event
            tableSelect.addEventListener('change', function() {
                const tableNum = parseInt(this.value);
                if (tableNum) {
                    document.querySelectorAll('.table').forEach(t => t.classList.remove('selected'));
                    document.querySelectorAll('.table')[tableNum-1].classList.add('selected');
                    updateSeats(tableNum);
                }
            });
            
            // Update seats based on selected table
            function updateSeats(tableNum) {
                // Clear previous seats
                seatSelect.innerHTML = '<option value="">-- Select Seat --</option>';
                
                // Add new seat options
                for (let i = 1; i <= 10; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = `Seat ${i}`;
                    seatSelect.appendChild(option);
                }
            }
            
            // Form submission
            document.getElementById('ticket-booking-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading
                document.getElementById('loading').style.display = 'block';
                document.getElementById('alert-container').innerHTML = '';
                
                // Get form data
                const formData = new FormData(this);
                
                // Submit form
                fetch('process_booking.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loading').style.display = 'none';
                    
                    if (data.success) {
                        // Show success message
                        showAlert('success', `Booking successful! Your booking ID is ${data.data.booking_id}. Payment Reference: ${data.data.payment_reference}. Amount: R${data.data.amount}. Please complete payment within 24 hours.`);
                        
                        // Reset form
                        this.reset();
                        document.querySelectorAll('.table').forEach(t => t.classList.remove('selected'));
                    } else {
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    document.getElementById('loading').style.display = 'none';
                    showAlert('error', 'An error occurred. Please try again.');
                    console.error('Error:', error);
                });
            });
            
            // Show alert function
            function showAlert(type, message) {
                const alertContainer = document.getElementById('alert-container');
                const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
                alertContainer.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
                
                // Scroll to alert
                alertContainer.scrollIntoView({ behavior: 'smooth' });
            }
            
            // Scroll animations
            const sections = document.querySelectorAll('section');
            
            function checkScroll() {
                sections.forEach(section => {
                    const sectionTop = section.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (sectionTop < windowHeight * 0.75) {
                        section.classList.add('visible');
                    }
                });
                
                // Header scroll effect
                if (window.scrollY > 50) {
                    document.querySelector('header').classList.add('scrolled');
                } else {
                    document.querySelector('header').classList.remove('scrolled');
                }
            }
            
            // Initial check
            checkScroll();
            
            // Listen for scroll events
            window.addEventListener('scroll', checkScroll);
        });
    </script>
</body>
</html>