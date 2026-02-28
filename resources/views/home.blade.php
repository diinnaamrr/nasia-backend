@extends('layouts.landing.app')
@php
    $landing_site_direction = session()->get('landing_site_direction');
    $business_name = \App\CentralLogics\Helpers::get_settings('business_name');
    $extra_testimonials = [
        ['name' => 'Sarah Johnson', 'position' => 'Premium Member', 'desc' => 'NASIA Market has completely changed how I shop for my family. The quality of their organic harvest is unmatched.'],
        ['name' => 'Michael Chen', 'position' => 'Executive Chef', 'desc' => 'As a chef, I am extremely particular about my ingredients. NASIA specialty cuts meet the highest standards.'],
        ['name' => 'Aisha Al-Hashim', 'position' => 'Loyal Client', 'desc' => 'The service is truly world-class. Fast delivery and the gold-standard presentation make every order feel like a luxury.'],
        ['name' => 'James Wilson', 'position' => 'Gourmet Enthusiast', 'desc' => 'Finding international cheeses and specialty deli items used to be a chore. Now, it is a delightful weekly ritual.'],
        ['name' => 'Elena Rodriguez', 'position' => 'Daily Shopper', 'desc' => 'The attention to detail in packaging and the freshness of the bakery items is simply outstanding. Highly recommended!'],
        ['name' => 'Omar Farooq', 'position' => 'Tech Professional', 'desc' => 'A seamless digital experience followed by lightning-fast delivery. This is exactly what a modern supermarket should be.'],
    ];

    $nearestEnd = null;
    if(isset($landing_data['flash_sales'])) {
        foreach($landing_data['flash_sales'] as $c) {
            if (!$nearestEnd || $c->ends_at < $nearestEnd) {
                $nearestEnd = $c->ends_at;
            }
        }
    }
    $endTime = $nearestEnd ? $nearestEnd->format('Y-m-d H:i:s') : null;
@endphp
@section('title', 'Nasia Market')

@section('content')

    <!-- Basic Settings -->
    @php($front_end_url = \App\Models\BusinessSetting::where(['key' => 'front_end_url'])->first())
    @php($front_end_url = $front_end_url ? $front_end_url->value : null)
    @php($landing_page_text = \App\Models\BusinessSetting::where(['key' => 'landing_page_text'])->first())
    @php($landing_page_text = isset($landing_page_text->value) ? json_decode($landing_page_text->value, true) : null)
    @php($landing_page_links = \App\Models\BusinessSetting::where(['key' => 'landing_page_links'])->first())
    @php($landing_page_links = isset($landing_page_links->value) ? json_decode($landing_page_links->value, true) : null)
    @php($landing_page_images = \App\Models\BusinessSetting::where(['key' => 'landing_page_images'])->first())
    @php($landing_page_images = isset($landing_page_images->value) ? json_decode($landing_page_images->value, true) : null)
    
    <!-- ==== Banner Section Starts Here ==== -->
    @php($logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first())
    <!-- ==== Global Theme Overrides ==== -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap');
        
        html {
            scroll-behavior: smooth;
        }
        :root {
            --base-1: #D4AF37 !important; /* Gold */
            --base-rgb: 212, 175, 55 !important;
            --base-2: #FFD700 !important; /* Lighter Gold */
            --base-rgb-2: 255, 215, 0 !important;
            --font-main: 'Inter', 'Segoe UI', Roboto, sans-serif;
        }

        body {
            font-family: var(--font-main);
            color: #4B5563;
            background-color: #fff;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-main);
            font-weight: 800;
            color: #111827;
        }

        /* Generic primary color overrides */
        .primary-color, .text--base, .text-base {
            color: var(--base-1) !important;
        }
        .bg--base, .bg-base, .cmn--btn {
            background-color: var(--base-1) !important;
        }

        /* Glassmorphism Classes */
        .glass-premium {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }
        .glass-dark {
            background: rgba(17, 24, 39, 0.8) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        /* Global Luxury Spacing */
        section {
            padding: 120px 0 !important;
        }
        @media (max-width: 768px) {
            section {
                padding: 80px 0 !important;
            }
        }
        /* Primary Button Glow */
        .btn-primary-premium {
            background: var(--base-1) !important;
            color: #fff !important;
            border: none !important;
            box-shadow: 0 10px 30px rgba(var(--base-rgb), 0.3) !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }
        .btn-primary-premium:hover {
            transform: translateY(-5px) scale(1.05) !important;
            box-shadow: 0 20px 40px rgba(var(--base-rgb), 0.4) !important;
            background: var(--base-2) !important;
        }

        /* Glass Header (Targeting typical classes) */
        header, .navbar, .top-nav {
            backdrop-filter: blur(15px) !important;
            -webkit-backdrop-filter: blur(15px) !important;
            background: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.4s ease !important;
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
        }

        /* Advanced Section Titles */
        .section-title-premium h2 {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 900;
            color: #111827;
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }
        .section-title-premium h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--base-1);
            border-radius: 10px;
        }

        /* Standard Elite Pill */
        .elite-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(var(--base-rgb), 0.1);
            color: var(--base-1);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 20px;
            border: 1px solid rgba(var(--base-rgb), 0.2);
            transition: all 0.3s ease;
        }
        .elite-pill:hover {
            background: rgba(var(--base-rgb), 0.2);
            transform: scale(1.05);
        }
        .product-btn {
            background: var(--base-1) !important;
        }
        .hero-section {
            min-height: 70vh;
            background: linear-gradient(135deg, #fdfbf7 0%, #fff9e6 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 60px 0;
        }
        .hero-bg-shapes .shape {
            position: absolute;
            filter: blur(80px);
            z-index: 1;
            border-radius: 50%;
        }
        .hero-bg-shapes .shape-1 {
            width: 400px;
            height: 400px;
            background: rgba(var(--base-rgb), 0.15);
            top: -100px;
            right: -100px;
        }
        .hero-bg-shapes .shape-2 {
            width: 300px;
            height: 300px;
            background: rgba(var(--base-rgb-2), 0.1);
            bottom: -50px;
            left: -50px;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-title {
            font-size: clamp(48px, 8vw, 84px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 25px;
            background: linear-gradient(90deg, var(--title-clr), var(--base-1));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: -2px;
        }
        .hero-subtitle {
            font-size: 20px;
            line-height: 1.6;
            margin-bottom: 40px;
            color: var(--body-clr);
            max-width: 550px;
        }
        .hero-btns {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .btn-premium {
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 18px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-primary-premium {
            background: var(--base-1);
            color: #fff !important;
            box-shadow: 0 10px 20px rgba(var(--base-rgb), 0.3);
        }
        .btn-primary-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(var(--base-rgb), 0.4);
        }
        .btn-secondary-premium {
            background: #fff;
            color: var(--title-clr) !important;
            border: 2px solid var(--border-clr);
        }
        .delivery-content .btn-role-cta:hover {
        background: #C3A04B !important;
        color: #fff !important;
    }

    /* Testimonials Redesign */
    .testimonial-card-premium {
        background: #fff;
        border-radius: 30px;
        padding: 40px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
        position: relative;
    }
    .testimonial-card-premium:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.06);
        border-color: rgba(195, 160, 75, 0.1);
    }
    .testi-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
    }
    .testi-author-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .testi-avatar {
        width: 65px;
        height: 65px;
        border-radius: 20px;
        overflow: hidden;
        background: #f8f9fa;
        border: 2px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .testi-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .testi-author-info h4 {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 3px;
        color: #1A1D23;
    }
    .testi-role {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 50px;
        letter-spacing: 0.5px;
    }
    .testi-role.buyer { background: rgba(39, 190, 215, 0.1); color: #27BED7; }
    .testi-role.seller { background: rgba(195, 160, 75, 0.1); color: #C3A04B; }

    .testi-rating {
        color: #FFB800;
        font-size: 14px;
        display: flex;
        gap: 3px;
    }
    .testi-body p {
        font-size: 16px;
        line-height: 1.7;
        color: #6B7280;
        font-style: italic;
        margin-bottom: 0;
    }
    .testi-footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px dashed rgba(0,0,0,0.06);
        display: flex;
        justify-content: flex-end;
    }
    .testi-date {
        font-size: 13px;
        color: #9CA3AF;
        font-weight: 500;
    }

    }
        .btn-secondary-premium:hover {
            background: var(--title-clr);
            color: #fff !important;
            border-color: var(--title-clr);
            transform: translateY(-5px);
        }
        .hero-image-wrapper {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hero-main-img {
            max-width: 100%;
            height: auto;
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.15);
            border: 10px solid #fff;
            transform: rotate(2deg);
            transition: all 0.5s ease;
        }
        .hero-main-img:hover {
            transform: rotate(0deg) scale(1.02);
        }
        .floating-badge {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 15px 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 3;
            animation: float 4s ease-in-out infinite;
        }
        .badge-1 { top: 10%; right: -5%; animation-delay: 0s; }
        .badge-2 { bottom: 10%; left: -5%; animation-delay: 2s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Hero Search Bar Styles */
        .hero-search-wrapper {
            max-width: 550px;
            margin-top: 35px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            padding: 8px;
            border-radius: 50px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            display: flex;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .hero-search-wrapper:focus-within {
            border-color: var(--base-1);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.15);
        }
        .hero-search-input {
            background: transparent;
            border: none;
            padding: 10px 25px;
            color: #000;
            width: 100%;
            outline: none;
            font-size: 16px;
        }
        .hero-search-input::placeholder {
            color: rgba(8, 0, 0, 0.5);
        }
        .hero-search-btn {
            background: var(--base-1);
            color: #fff;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .hero-search-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        }

        /* Category Slider Styles */
        .category-discovery-section {
            padding: 30px 0;
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .category-item-v3 {
            text-align: center;
            padding: 15px;
            transition: all 0.3s ease;
        }
        .category-icon-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #f8f8f8;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }
        .category-item-v3:hover .category-icon-wrapper {
            border-color: var(--base-1);
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.2);
        }
        .category-name-v3 {
            font-size: 14px;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .category-item-v3:hover .category-name-v3 {
            color: var(--base-1);
        }

        @media (max-width: 991px) {
            .hero-section { text-align: center; padding: 60px 0; }
            .hero-subtitle { margin-left: auto; margin-right: auto; }
            .hero-btns { justify-content: center; }
            .hero-image-wrapper { margin-top: 60px; }
            .badge-1, .badge-2 { display: none; }
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 30px;
            padding: 40px 0;
        }
        .product-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #eee;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .product-img-wrapper {
            position: relative;
            padding-top: 75%; /* 4:3 Aspect Ratio */
            background: #f9f9f9;
        }
        .product-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .product-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--title-clr);
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }
        .product-price {
            font-size: 20px;
            color: var(--base-1);
            font-weight: 900;
            margin-top: auto;
        }
        .product-btn {
            background: var(--base-1);
            color: #fff !important;
            padding: 10px 20px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            margin-top: 15px;
            font-weight: 700;
            transition: opacity 0.3s;
        }
        .product-btn:hover {
            opacity: 0.9;
        }
        .section-title-premium {
            text-align: center;
            margin-bottom: 40px;
        }
        .section-title-premium h2 {
            font-size: 36px;
            font-weight: 900;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        .section-title-premium h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--base-1);
            border-radius: 2px;
        }

        /* New Improved Feature Grid */
        .feature-grid-v2 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        @media (max-width: 1199px) {
            .feature-grid-v2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 767px) {
            .feature-grid-v2 {
                grid-template-columns: 1fr;
            }
        }
        .feature-item-premium {
            padding: 40px 20px;
            border-radius: 30px;
            text-align: center;
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .feature-item-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--base-1);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }
        .feature-item-premium:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(212, 175, 55, 0.12);
        }
        .feature-item-premium:hover::before {
            transform: scaleX(1);
        }
        .feature-icon-v2 {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.02) 100%);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            transition: all 0.5s ease;
        }
        .feature-item-premium:hover .feature-icon-v2 {
            background: var(--base-1);
            border-radius: 50%;
            transform: scale(1.1) rotate(10deg);
        }
        .feature-icon-v2 img {
            width: 45px;
            height: 45px;
            transition: all 0.3s ease;
        }
        .feature-item-premium:hover .feature-icon-v2 img {
            filter: brightness(0) invert(1);
        }
        .feature-item-premium h3 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--title-clr);
            letter-spacing: -0.5px;
        }
        .feature-item-premium p {
            color: var(--body-clr);
            line-height: 1.8;
            font-size: 16px;
            margin: 0;
        }




        /* Elite Categories Gallery Styles */
        .categories-gallery-section {
            padding: 120px 0;
            background: #fafaf8;
        }
        .category-grid-v2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        .category-card-v2 {
            height: 450px;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
            background-color: #000;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .category-card-v2:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(212, 175, 55, 0.2);
        }
        .category-img-v2 {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7;
            transition: all 0.8s ease;
            filter: grayscale(0.2);
        }
        .category-card-v2:hover .category-img-v2 {
            opacity: 0.5;
            transform: scale(1.1);
            filter: grayscale(0);
        }
        .category-overlay-v2 {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            z-index: 2;
        }
        .category-content-v2 {
            transform: translateY(20px);
            transition: all 0.5s ease;
        }
        .category-card-v2:hover .category-content-v2 {
            transform: translateY(0);
        }
        .category-badge-v2 {
            background: var(--base-1);
            color: #fff;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: inline-block;
            margin-bottom: 15px;
        }
        .category-title-v2 {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.2;
        }
        .category-desc-v2 {
            color: rgba(255,255,255,0.6);
            font-size: 15px;
            margin-bottom: 25px;
            opacity: 0;
            transition: all 0.4s ease;
        }
        .category-card-v2:hover .category-desc-v2 {
            opacity: 1;
        }
        .category-link-v2 {
            color: var(--base-1);
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .category-link-v2 i {
            transition: transform 0.3s ease;
        }
        .category-card-v2:hover .category-link-v2 i {
            transform: translateX(5px);
        }
        /* ============================================================
           LIGHT PREMIUM FLASH SHOWROOM 
           ============================================================ */
        .premium-flash-showroom {
            padding: 60px 0;
            background: #ffffff;
            position: relative;
        }

        .showroom-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .flash-badge-light {
            background: rgba(212, 175, 55, 0.1);
            color: #D4AF37;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 15px;
        }

        .showroom-title {
            font-size: clamp(30px, 4vw, 48px);
            font-weight: 900;
            color: #1e293b;
            letter-spacing: -1.5px;
            line-height: 1.1;
        }

        /* Light Glassmorphism Card */
        .light-glass-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 28px;
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .light-glass-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px -12px rgba(212, 175, 55, 0.15);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .showroom-discount-tag {
            position: absolute;
            top: 24px;
            left: 24px;
            background: #000;
            color: var(--base-1);
            padding: 6px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            z-index: 3;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .showroom-img-box {
            width: 100%;
            height: 220px;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 25px;
            background: #f8fafc;
        }

        .showroom-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .light-glass-card:hover .showroom-img-box img {
            transform: scale(1.08);
        }

        .showroom-p-category {
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }

        .showroom-p-title {
            color: #1e293b;
            font-size: 1.35rem;
            font-weight: 800;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .showroom-price-box {
            display: flex;
            align-items: baseline;
            gap: 12px;
            margin-top: auto;
            margin-bottom: 25px;
        }

        .showroom-price-now {
            font-size: 1.6rem;
            font-weight: 800;
            color: #D4AF37;
        }

        .showroom-price-was {
            font-size: 1rem;
            color: #94a3b8;
            text-decoration: line-through;
        }

        .showroom-buy-btn {
            background: #111827;
            color: #fff !important;
            width: 100%;
            padding: 16px;
            border-radius: 18px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .showroom-buy-btn:hover {
            background: #D4AF37;
            color: #000 !important;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
        }

        .showroom-timer-inline {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }

        .timer-unit {
            background: #f1f5f9;
            padding: 12px 15px;
            border-radius: 14px;
            min-width: 70px;
            text-align: center;
        }

        .timer-val {
            display: block;
            font-size: 1.6rem;
            font-weight: 900;
            color: #1e293b;
            line-height: 1;
        }

        .timer-lab {
            font-size: 0.65rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 800;
            margin-top: 4px;
            display: block;
        }

        /* Responsive Grid for Showroom & Departments */
        .ld-flash-grid, .ld-products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 20px;
            padding: 20px 0;
        }

        @media (max-width: 1100px) {
            .ld-flash-grid, .ld-products-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }

        @media (max-width: 991px) {
            .ld-flash-grid, .ld-products-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 15px;
            }
            .light-glass-card { padding: 10px; border-radius: 15px; }
            .showroom-img-box { height: 140px; }
            .showroom-p-title { font-size: 0.9rem; }
            .showroom-price-now { font-size: 1rem; }
        }

        @media (max-width: 480px) {
            .ld-flash-grid, .ld-products-grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* Ensure Slider Visibility */
        .category-discovery-section {
            min-height: 150px;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative;
            z-index: 10;
        }
        [dir="rtl"] .category-discovery-section {
            direction: rtl !important;
        }
        .category-slider-v3.owl-loaded {
            display: block !important;
        }

        /* Responsive Fix for Product Cards */
        .light-glass-card {
            min-width: 0; /* Prevent grid blowout */
        }
    </style>

    <!-- ==== ULTRA PREMIUM HERO ==== -->
    <style>
        /* ====== ULTRA HERO ====== */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap');

        .ultra-hero {
            min-height: 85vh;
            background: url('{{ asset('assets/ba.png') }}') center center / cover no-repeat;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 80px 0 60px;
            font-family: 'Inter', sans-serif;
        }
        /* Strong dark overlay so text stays readable */
        .ultra-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(5,5,10,0.92) 0%,
                rgba(10,10,20,0.85) 50%,
                rgba(0,0,0,0.90) 100%
            );
            z-index: 1;
        }

        /* ---- Particle Canvas BG ---- */
        #hero-particles {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        /* ---- Gold Glow Orbs ---- */
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }
        .hero-orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%);
            top: -200px; right: -150px;
        }
        .hero-orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(212,175,55,0.10) 0%, transparent 70%);
            bottom: -100px; left: -100px;
        }
        .hero-orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(100,150,255,0.05) 0%, transparent 70%);
            top: 40%; left: 40%;
        }

        /* ---- Grid Lines BG ---- */
        .hero-grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(212,175,55,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212,175,55,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
        }

        /* ---- Content ---- */
        .ultra-hero .container { position: relative; z-index: 2; }

        /* Eyebrow pill */
        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(212,175,55,0.08);
            border: 1px solid rgba(212,175,55,0.25);
            padding: 10px 24px;
            border-radius: 50px;
            margin-bottom: 32px;
        }
        .hero-pill-dot {
            width: 8px; height: 8px;
            background: #D4AF37;
            border-radius: 50%;
            box-shadow: 0 0 8px #D4AF37;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 6px #D4AF37; }
            50% { box-shadow: 0 0 16px #D4AF37, 0 0 30px rgba(212,175,55,0.4); }
        }
        .hero-pill-text {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--base-1);
        }

        /* Headline */
        .ultra-hero-title {
            font-size: clamp(52px, 8vw, 96px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 35px;
            letter-spacing: -1px;
        }
        .title-line-solid {
            display: block;
            color: #D4AF37;
        }
        .title-line-gold {
            display: block;
            background: linear-gradient(90deg, var(--title-clr), #D4AF37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .title-line-outline {
            display: block;
            -webkit-text-stroke: 2px rgba(212,175,55,0.5);
            color: transparent;
        }

        /* Subtitle */
        .ultra-hero-sub {
            font-size: 18px;
            line-height: 1.8;
            color: rgba(255,255,255,0.85);
            max-width: 600px;
            margin-bottom: 50px;
            border-left: 3px solid var(--base-1);
            padding-left: 20px;
        }

        /* Store buttons */
        .ultra-store-btns {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 56px;
        }
        .ultra-store-btn {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 16px 30px;
            border-radius: 18px;
            text-decoration: none !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        .ultra-store-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .ultra-store-btn:hover::before { opacity: 1; }
        .usb-gold {
            background: linear-gradient(135deg, var(--base-1) 0%, var(--base-2) 100%);
            box-shadow: 0 10px 35px rgba(var(--base-rgb), 0.4), 0 0 0 1px rgba(var(--base-rgb), 0.3);
            color: #000 !important;
        }
        .usb-gold:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 50px rgba(var(--base-rgb), 0.55), 0 0 0 1px rgba(var(--base-rgb), 0.5);
        }
        .usb-dark {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff !important;
            backdrop-filter: blur(10px);
        }
        .usb-dark:hover {
            border-color: rgba(212,175,55,0.4);
            background: rgba(212,175,55,0.08);
            color: #D4AF37 !important;
            transform: translateY(-5px);
        }
        .usb-icon { font-size: 28px; }
        .usb-text .t-label { font-size: 10px; letter-spacing: 1px; opacity: 0.7; display: block; line-height: 1; }
        .usb-text .t-name { font-size: 18px; font-weight: 800; line-height: 1.3; }

        /* Stats */
        .ultra-stats {
            display: flex;
            gap: 0;
            border-top: 1px solid rgba(255,255,255,0.07);
            padding-top: 28px;
        }
        .ultra-stat {
            flex: 1;
            padding: 0 24px 0 0;
            border-right: 1px solid rgba(255,255,255,0.07);
        }
        .ultra-stat:first-child { padding-left: 0; }
        .ultra-stat:last-child { border-right: none; }
        .ultra-stat-num {
            font-size: 32px;
            font-weight: 900;
            background: linear-gradient(90deg, var(--base-1), var(--base-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 6px;
        }
        .ultra-stat-lbl {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Full-width centered content */
        .ultra-hero .hero-center-col {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }
        .ultra-hero .ultra-hero-sub {
            margin-left: auto;
            margin-right: auto;
            border-left: none;
            border-top: 3px solid var(--base-1);
            padding-left: 0;
            padding-top: 20px;
            text-align: center;
        }
        .ultra-store-btns { justify-content: center; }
        .ultra-stats { justify-content: center; }

        /* Floating mini cards */
        .ultra-float-card {
            position: absolute;
            background: rgba(18,18,24,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: 20px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 10;
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        }
        @media (max-width: 991px) {
            .ultra-float-card { display: none !important; }
        }
        .ufc-1 {
            top: 0px; right: 10px;
            animation: uFloat 5s ease-in-out infinite;
        }
        .ufc-2 {
            bottom: 40px; left: -10px;
            animation: uFloat 5s ease-in-out infinite 1.5s;
        }
        .ufc-3 {
            top: 42%; right: -20px;
            animation: uFloat 5s ease-in-out infinite 3s;
        }
        @keyframes uFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-14px); }
        }
        .ufc-icon {
            width: 60px; height: 60px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .ufc-icon.g { background: none; }
        .ufc-icon.b { background: none; }
        .ufc-icon.e { background: none; }
        .ufc-icon img { width: 100%; height: 100%; object-fit: contain; }
        .ufc-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
            max-width: 150px;
        }
        .ufc-label { font-size: 13px; font-weight: 800; color: #fff; line-height: 1.3; }
        .ufc-sub { font-size: 11px; color: rgba(255,255,255,0.45); line-height: 1.2; }

        /* Scrolldown */
        .hero-scroll-hint {
            position: absolute;
            bottom: 35px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            color: rgba(255,255,255,0.25);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .scroll-mouse {
            width: 24px; height: 38px;
            border: 2px solid rgba(212,175,55,0.3);
            border-radius: 12px;
            position: relative;
        }
        .scroll-mouse::before {
            content: '';
            position: absolute;
            top: 6px; left: 50%; transform: translateX(-50%);
            width: 4px; height: 8px;
            background: #D4AF37;
            border-radius: 2px;
            animation: scroll-wheel 2s ease-in-out infinite;
        }
        @keyframes scroll-wheel {
            0% { transform: translateX(-50%) translateY(0); opacity: 1; }
            100% { transform: translateX(-50%) translateY(14px); opacity: 0; }
        }

        /* Bottom wave */
        .hero-wave {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 80px;
            z-index: 1;
        }

        @media (max-width: 991px) {
            .ultra-hero { padding: 100px 0 60px; min-height: auto; }
            .ultra-hero-title { letter-spacing: -2px; }
            .ultra-stat { padding: 0 16px; }
            .hero-scroll-hint { display: none; }
        }

        /* Features Carousel Section (Figma Replica) */
        #features-carousel {
            background: #ffffff;
            padding: 20px 0 10px 0;
            position: relative;
            overflow: hidden;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .feature-card {
            background-size: cover !important;
            background-position: center !important;
            padding: 50px 20px;
            text-align: center;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            height: 520px;
            width: 95%;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(10,10,20,0.65) 0%, rgba(0,0,0,0.8) 100%);
            border-radius: 30px;
            z-index: 0;
        }
        .feature-card:hover {
            transform: scale(1.02);
            box-shadow: 0 30px 80px rgba(0,0,0,0.35);
        }
        .feature-card > * {
            position: relative;
            z-index: 1;
        }
        .feature-icon-box {
            width: 120px;
            height: 120px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .feature-icon-box svg {
            width: 100%;
            height: 100%;
        }
        .feature-title {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 800;
            color: #1A1D23;
            margin-bottom: 25px;
            line-height: 1.2;
        }
        .feature-text {
            font-size: clamp(18px, 1.8vw, 24px);
            color: #8E9196;
            line-height: 1.8;
            margin: 0;
            width: 100%;
            max-width: 900px;
        }
        /* Figma Pagination Dots */
        #features-carousel .owl-dots {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }
        #features-carousel .owl-dot span {
            width: 10px !important;
            height: 10px !important;
            background: #E5E7EB !important;
            margin: 0 !important;
            border-radius: 50% !important;
            transition: all 0.3s ease;
        }
        #features-carousel .owl-dot.active span {
            width: 32px !important;
            border-radius: 10px !important;
            background: #C3A04B !important;
        }
        #features-carousel .owl-nav { display: none !important; }

        /* How it Works Section */
        .hiw-section {
            background: #ffffff;
            padding: 10px 0 60px;
            position: relative;
        }
        .hiw-step-card {
            text-align: center;
            padding: 30px;
            position: relative;
            z-index: 2;
            transition: all 0.4s ease;
        }
        .hiw-icon-wrapper {
            width: 140px;
            height: 140px;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .hiw-icon-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .hiw-step-card:hover .hiw-icon-wrapper img {
            transform: translateY(-15px) scale(1.1);
        }
        .hiw-number {
            position: absolute;
            top: -10px;
            right: 0;
            font-size: 80px;
            font-weight: 900;
            color: rgba(195, 160, 75, 0.08);
            line-height: 1;
            z-index: -1;
            font-family: 'Inter', sans-serif;
        }
        .hiw-title {
            font-size: 22px;
            font-weight: 800;
            color: #1A1D23;
            margin-bottom: 15px;
        }
        .hiw-desc {
            font-size: 16px;
            color: #8E9196;
            line-height: 1.6;
        }
        /* Connecting Line (Desktop) */
        .hiw-row {
            position: relative;
        }
        @media (min-width: 992px) {
            .hiw-row::before {
                content: '';
                position: absolute;
                top: 70px;
                left: 10%;
                right: 10%;
                height: 2px;
                background: linear-gradient(to right, transparent, rgba(195, 160, 75, 0.2), transparent);
                z-index: 1;
            }
        }
        .hiw-badge {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(195, 160, 75, 0.1);
            color: #C3A04B;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Role-Specific Sections Styles */
        .role-section {
            padding: 10px 0;
            position: relative;
            overflow: hidden;
        }
        .role-section-alt {
            background: #fafaf8;
        }
        .role-card { 
            background: #ffffff;
            border-radius: 30px;
            padding: 20px 30px;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0,0,0,0.03);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .role-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.06);
            border-color: rgba(195, 160, 75, 0.2);
        }
        .role-icon-box {
            width: 90px;
            height: 90px;
            background: rgba(195, 160, 75, 0.05);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            transition: all 0.4s ease;
        }
        .role-card:hover .role-icon-box {
            background: #C3A04B;
            transform: scale(1.1) rotate(10deg);
            border-radius: 50%;
        }
        .role-icon-box img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            transition: all 0.3s ease;
        }
        .role-card:hover .role-icon-box img {
            filter: brightness(0) invert(1);
        }
        .role-card h4 {
            font-size: 20px;
            font-weight: 800;
            color: #1A1D23;
            margin-bottom: 15px;
        }
        .role-card p {
            font-size: 15px;
            color: #6B7280;
            line-height: 1.6;
            margin: 0;
        }
        .role-cta-wrapper {
            margin-top: 50px;
            text-align: center;
        }
        .btn-role-cta {
            padding: 10px 45px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 1px;
            text-transform: uppercase; 
            transition: all 0.4s ease;
            box-shadow: 0 10px 25px rgba(195, 160, 75, 0.2);
        }
        .btn-role-cta:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(195, 160, 75, 0.3);
        }
        .delivery-showcase-box {
            background: #fdfdfb;
            border-radius: 30px;
            padding: 40px 60px;
            display: flex;
            align-items: center;
            gap: 30px;
            box-shadow: 0 40px 80px rgba(0,0,0,0.12), 0 10px 20px rgba(195, 160, 75, 0.05);
            border: 1px solid rgba(195, 160, 75, 0.1);
        }
        .delivery-img-wrapper {
            max-width: 350px;
            flex-shrink: 0;
            transition: all 0.4s ease;
        }
        @media (max-width: 991px) {
            .delivery-showcase-box {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }
            .delivery-img-wrapper {
                max-width: 300px;
                margin: 0 auto;
            }
        }
        .delivery-img-wrapper img {
            width: 100%;
            height: auto;
            animation: float 5s ease-in-out infinite;
        }

        /* Testimonials Redesign */
        .testimonial-card-premium {
            background: #fff;
            border-radius: 30px;
            padding: 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 10px 40px rgba(0,0,0,0.02);
            position: relative;
        }
        .testimonial-card-premium:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.06);
            border-color: rgba(195, 160, 75, 0.1);
        }
        .testi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        .testi-author-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .testi-avatar {
            width: 65px;
            height: 65px;
            border-radius: 20px;
            overflow: hidden;
            background: #f8f9fa;
            border: 2px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .testi-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .testi-author-info h4 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 3px;
            color: #1A1D23;
        }
        .testi-role {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 50px;
            letter-spacing: 0.5px;
        }
        .testi-role.buyer { background: rgba(39, 190, 215, 0.1); color: #27BED7; }
        .testi-role.seller { background: rgba(195, 160, 75, 0.1); color: #C3A04B; }

        .testi-rating {
            color: #FFB800;
            font-size: 14px;
            display: flex;
            gap: 3px;
        }
        .testi-body p {
            font-size: 16px;
            line-height: 1.7;
            color: #6B7280;
            font-style: italic;
            margin-bottom: 0;
        }
        .testi-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed rgba(0,0,0,0.06);
            display: flex;
            justify-content: flex-end;
        }
        .testi-date {
            font-size: 13px;
            color: #9CA3AF;
            font-weight: 500;
        }

        /* Final CTA Section */
        .final-cta-section {
            background: #1A1D23;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
            border-radius: 60px;
            margin-top: -40px;
            margin-bottom: 40px;
            z-index: 5;
        }
        .final-cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(195, 160, 75, 0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .cta-content-wrapper {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        .cta-title-ultra {
            font-size: 48px;
            font-weight: 900;
            color: #fff;
            margin-bottom: 40px;
            line-height: 1.2;
        }
        .cta-btns-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-cta-big {
            padding: 20px 50px;
            border-radius: 60px;
            font-size: 18px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-cta-gold {
            background: #C3A04B !important;
            color: #fff !important;
            box-shadow: 0 15px 35px rgba(195, 160, 75, 0.3);
        }
        .btn-cta-gold:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(195, 160, 75, 0.4);
        }
        .btn-cta-outline {
            background: transparent !important;
            color: #fff !important;
            border: 2px solid rgba(255,255,255,0.1) !important;
        }
        .btn-cta-outline:hover {
            background: rgba(255,255,255,0.05) !important;
            border-color: #C3A04B !important;
            transform: translateY(-8px);
        }

        @media (max-width: 768px) {
            .cta-title-ultra {
                font-size: 32px;
            }
            .btn-cta-big {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <section class="ultra-hero" id="hero">
        {{-- Backgrounds --}}
        <canvas id="hero-particles"></canvas>
        <div class="hero-grid-bg"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>

        <div class="container" style="position:relative; z-index:2;">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8 hero-center-col wow fadeInUp" data-wow-delay="0.05s">


                    <h1 class="ultra-hero-title">
                        <span class="title-line-solid">{{ translate('NASIA') }}</span>
                        <span class="title-line-gold">{{ translate('MARKET') }}</span>
                    </h1>

                    {{-- Floating Elements --}}
                    <div class="ultra-float-card ufc-1 wow fadeInRight" data-wow-delay="0.8s">
                        <div class="ufc-icon g">
                            <img src="https://img.icons8.com/3d-fluency/188/shopping-basket.png" alt="Shopping">
                        </div>
                        <div class="ufc-text">
                            <span class="ufc-label">{{ translate('Quick shopping') }}</span>
                            <span class="ufc-sub">{{ translate('Your favorite products are here') }}</span>
                        </div>
                    </div>

                    <div class="ultra-float-card ufc-2 wow fadeInLeft" data-wow-delay="1s">
                        <div class="ufc-icon b">
                            <img src="https://img.icons8.com/3d-fluency/188/shop.png" alt="Seller">
                        </div>
                        <div class="ufc-text">
                            <span class="ufc-label">{{ translate('Be a seller') }}</span>
                            <span class="ufc-sub">{{ translate('Showcase your products immediately') }}</span>
                        </div>
                    </div>

                    <div class="ultra-float-card ufc-3 wow fadeInRight" data-wow-delay="1.2s">
                        <div class="ufc-icon e">
                            <img src="https://img.icons8.com/3d-fluency/188/truck.png" alt="Delivery">
                        </div>
                        <div class="ufc-text">
                            <span class="ufc-label">{{ translate('For delivery') }}</span>
                            <span class="ufc-sub">{{ translate('Safe delivery') }}</span>
                        </div>
                    </div>

                    {{-- Subtitle --}}
                    <p class="ultra-hero-sub">
                        {{ translate('Shop, sell, and deliver your products with ease.') }}<br>
                        <span style="font-size:14px; opacity:0.7;">{{ translate('Nasia – The integrated e-commerce platform for individuals and sellers') }}</span>
                    </p>

                    <div class="ultra-store-btns">
                        <a href="#download-app" class="ultra-store-btn usb-gold">
                            <span class="usb-icon"><i class="fab fa-google-play"></i></span>
                            <span class="usb-text">
                                <span class="t-name">{{ translate('Download App') }}</span>
                            </span>
                        </a>
                        <a href="{{ route('about-us') }}" class="ultra-store-btn usb-dark">
                            <span class="usb-icon"><i class="fas fa-arrow-right"></i></span>
                            <span class="usb-text">
                                <span class="t-name">{{ translate('More about') }}</span>
                            </span>
                        </a>
                    </div>



                </div>
            </div>
        </div>

        {{-- Scroll Hint --}}
        <div class="hero-scroll-hint">
            <div class="scroll-mouse"></div>
            <span>{{ translate('Scroll') }}</span>
        </div>

        {{-- Bottom Wave --}}
        <svg class="hero-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#ffffff"/>
        </svg>
    </section>

    

    {{-- How it Works Section --}}
    <section class="hiw-section section-luxury-spacing">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="elite-pill">{{ translate('الرحلة تبدأ هنا') }}</span>
                <h2 class="fw-900" style="color: #1A1D23;">{{ translate('إزاي بيشتغل التطبيق؟') }}</h2>
            </div>

            <div class="row hiw-row g-4">
                {{-- Step 1 --}}
                <div class="col-lg-3 col-md-6">
                    <div class="hiw-step-card wow fadeInUp" data-wow-delay="0.1s">
                        <span class="hiw-number">01</span>
                        <div class="hiw-icon-wrapper">
                            <img src="https://img.icons8.com/3d-fluency/188/shopping-cart.png" alt="Browse & Buy">
                        </div>
                        <h4 class="hiw-title">{{ translate('تصفح واشتري') }}</h4>
                        <p class="hiw-desc">{{ translate('المستخدم يختار المنتجات ويضيفها للعربة بكل سهولة') }}</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="col-lg-3 col-md-6">
                    <div class="hiw-step-card wow fadeInUp" data-wow-delay="0.2s">
                        <span class="hiw-number">02</span>
                        <div class="hiw-icon-wrapper">
                            <img src="https://img.icons8.com/3d-fluency/188/shop.png" alt="Be a Seller">
                        </div>
                        <h4 class="hiw-title">{{ translate('كن بائع') }}</h4>
                        <p class="hiw-desc">{{ translate('بلمسة واحدة زر Be a Vendor يحولك لبائع مباشرة') }}</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="col-lg-3 col-md-6">
                    <div class="hiw-step-card wow fadeInUp" data-wow-delay="0.3s">
                        <span class="hiw-number">03</span>
                        <div class="hiw-icon-wrapper">
                            <img src="https://img.icons8.com/3d-fluency/188/upload.png" alt="Upload Products">
                        </div>
                        <h4 class="hiw-title">{{ translate('رفع المنتجات') }}</h4>
                        <p class="hiw-desc">{{ translate('تحكم كامل في الكمية دون أي قيود برمجية') }}</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="col-lg-3 col-md-6">
                    <div class="hiw-step-card wow fadeInUp" data-wow-delay="0.4s">
                        <span class="hiw-number">04</span>
                        <div class="hiw-icon-wrapper">
                            <img src="https://img.icons8.com/3d-fluency/188/truck.png" alt="Fast Delivery">
                        </div>
                        <h4 class="hiw-title">{{ translate('توصيل سريع') }}</h4>
                        <p class="hiw-desc">{{ translate('مندوب التوصيل يستلم الأوردر ويوصله للعميل فوراً') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    // ---- Particle Canvas ----
    (function(){
        const canvas = document.getElementById('hero-particles');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let W, H, particles = [];
        function resize() {
            W = canvas.width = canvas.offsetWidth;
            H = canvas.height = canvas.offsetHeight;
        }
        function Particle() {
            this.x = Math.random() * W;
            this.y = Math.random() * H;
            this.r = Math.random() * 1.5 + 0.3;
            this.dx = (Math.random() - 0.5) * 0.3;
            this.dy = (Math.random() - 0.5) * 0.3;
            this.alpha = Math.random() * 0.4 + 0.1;
        }
        Particle.prototype.update = function() {
            this.x += this.dx; this.y += this.dy;
            if (this.x < 0) this.x = W; if (this.x > W) this.x = 0;
            if (this.y < 0) this.y = H; if (this.y > H) this.y = 0;
        };
        function init() {
            resize();
            particles = [];
            for (let i = 0; i < 120; i++) particles.push(new Particle());
        }
        function draw() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(p => {
                p.update();
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(212,175,55,${p.alpha})`;
                ctx.fill();
            });
            requestAnimationFrame(draw);
        }
        window.addEventListener('resize', init);
        init(); draw();
    })();

    // ---- Animated Counters ----
    (function(){
        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-target'));
            const duration = 2000;
            const start = performance.now();
            function update(now) {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(eased * target);
                el.textContent = current >= 1000 ? (current/1000).toFixed(0) + 'K+' : current + '+';
                if (progress < 1) requestAnimationFrame(update);
                else el.textContent = target >= 1000 ? (target/1000).toFixed(0) + 'K+' : target + '+';
            }
            requestAnimationFrame(update);
        }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { animateCounter(e.target); observer.unobserve(e.target); }});
        }, { threshold: 0.5 });
        document.querySelectorAll('.ultra-stat-num.counter').forEach(el => observer.observe(el));
    })();
    </script>
    

    <!-- ==== Why Choose Us Section Combined Styles ==== -->

    <section class="why-choose-us section-luxury-spacing" id="features" style="background: #fafaf8;">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="elite-pill">{{ translate('Excellence') }}</span>
                <h2 class="mb-0">{{ translate('Why Choose NASIA APP') }}</h2>
            </div>
            <div class="feature-grid-v2">
                {{-- Card 1: Multi-Vendor --}}
                <div class="feature-item-premium wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-icon-v2">
                        <img src="https://img.icons8.com/3d-fluency/188/shopping-bag.png" alt="Multi-Vendor">
                    </div>
                    <h3>{{ translate('دعم متعدد البائعين') }}</h3>
                    <p>{{ translate('منصة واحدة… وفرص بيع بلا حدود.') }}</p>
                </div>
                {{-- Card 3: Control --}}
                <div class="feature-item-premium wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-icon-v2">
                        <img src="https://img.icons8.com/3d-fluency/188/administrative-tools.png" alt="Control">
                    </div>
                    <h3>{{ translate('تحكم كامل في البيع') }}</h3>
                    <p>{{ translate('حدد الكمية بحرية تامة — أنت المتحكم.') }}</p>
                </div>

                {{-- Card 4: Notifications --}}
                <div class="feature-item-premium wow fadeInUp" data-wow-delay="0.4s">
                    <div class="feature-icon-v2">
                        <img src="https://img.icons8.com/3d-fluency/188/bell.png" alt="Notifications">
                    </div>
                    <h3>{{ translate('إشعارات لحظية') }}</h3>
                    <p>{{ translate('كل طلب جديد يوصلك فورًا بدون تأخير.') }}</p>
                </div>

                {{-- Card 5: Bilingual --}}
                <div class="feature-item-premium wow fadeInUp" data-wow-delay="0.5s">
                    <div class="feature-icon-v2">
                        <img src="https://img.icons8.com/3d-fluency/188/globe.png" alt="Bilingual">
                    </div>
                    <h3>{{ translate('عربي & English') }}</h3>
                    <p>{{ translate('تجربة سلسة بلغتين تناسب الجميع.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features-carousel">
        <div class="container-fluid p-0">
            <div class="owl-carousel owl-theme" id="features-owl">
                {{-- Card 1: Shopping --}}
                <div class="item">
                    <div class="feature-card" style="background: url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?q=80&w=1740&auto=format&fit=crop') center/cover no-repeat;">
                        <div class="feature-icon-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="8" width="18" height="13" rx="4" />
                                <path d="M8 8V6a4 4 0 0 1 8 0v2" />
                                <path d="M12 11a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                <path d="M9 16c0 1.5 1.3 2.5 3 2.5s3-1 3-2.5" />
                            </svg>
                        </div>
                        <h3 class="feature-title" style="color:#fff;">{{ translate('تسوق من بائعين متعددين') }}</h3>
                        <p class="feature-text" style="color:rgba(255,255,255,0.8);">{{ translate('اكتشف منتجات متنوعة من بائعين مختلفين في مكان واحد') }}</p>
                    </div>
                </div>

                {{-- Card 2: Tracking --}}
                <div class="item">
                    <div class="feature-card" style="background: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=1740&auto=format&fit=crop') center/cover no-repeat;">
                        <div class="feature-icon-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14" />
                                <path d="m7.5 4.27 4.5 2.57 4.5-2.57" />
                                <path d="m3 8 9 5.14 9-5.14" />
                                <path d="m12 13v8.57" />
                                <circle cx="18" cy="18" r="3" />
                                <path d="m20 20 2 2" />
                            </svg>
                        </div>
                        <h3 class="feature-title" style="color:#fff;">{{ translate('تتبع طلباتك بسهوله') }}</h3>
                        <p class="feature-text" style="color:rgba(255,255,255,0.8);">{{ translate('راقب حاله طلبك من لحظه الشراء حتي التسليم') }}</p>
                    </div>
                </div>

                {{-- Card 3: Seller --}}
                <div class="item">
                    <div class="feature-card" style="background: url('https://images.unsplash.com/photo-1664575602276-acd073f104c1?q=80&w=1740&auto=format&fit=crop') center/cover no-repeat;">
                        <div class="feature-icon-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                                <path d="M2 9h20" />
                                <path d="M10 9V7a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" />
                            </svg>
                        </div>
                        <h3 class="feature-title" style="color:#fff;">{{ translate('كن بائعا وابدأ التجاره') }}</h3>
                        <p class="feature-text" style="color:rgba(255,255,255,0.8);">{{ translate('حول حسابك الي متجر وابدأ بيع منتجاتك بسهوله') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Role Section 1: For Vendors --}}
    <section class="role-section">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="elite-pill">{{ translate('Providers') }}</span>
                <h2 class="mb-0">{{ translate('للبائعين والعارضين') }}</h2>
                <p class="mt-3" style="color: #6B7280; font-size: 18px;">{{ translate('كن بائعاً بسهولة، بدون أوراق أو تعقيدات.') }}</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.1s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/shop.png" alt="Join"> 
                        </div>
                        <h4>{{ translate('Join Platform') }}</h4>
                        <p>{{ translate('An easy start with no complicated paperwork or entry barriers.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.2s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/plus.png" alt="Upload">
                        </div>
                        <h4>{{ translate('رفع منتجاتك مباشرة') }}</h4>
                        <p>{{ translate('Upload your collection instantly with full control over images and details.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.3s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/administrative-tools.png" alt="Pricing">
                        </div>
                        <h4>{{ translate('تحديد الكمية بحرية') }}</h4>
                        <p>{{ translate('عدل مخزونك في أي وقت بدون قيود.') }}</p>
                    </div> 
                </div> 
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.4s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/group.png" alt="Customers">
                        </div>
                        <h4>{{ translate('انتشار أوسع') }}</h4>
                        <p>{{ translate('Reach thousands of active shoppers looking for premium products every day.') }}</p>
                    </div>
                </div>
            </div>

            <div class="role-cta-wrapper wow fadeInUp" data-wow-delay="0.5s">
                <a href="#download-app" class="btn-premium btn-role-cta" style="background: #C3A04B; color: #fff;">{{ translate('ابدأ البيع الآن') }}</a>
            </div>
        </div>
    </section>

    {{-- Role Section 2: For Shoppers --}}
    <section class="role-section role-section-alt section-luxury-spacing">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="elite-pill">{{ translate('Shopping') }}</span>
                <h2 class="mb-0">{{ translate('للمشترين') }}</h2>
                <p class="mt-3" style="color: #6B7280; font-size: 18px;">{{ translate('استمتع بتجربة تسوق فاخرة وسهلة مع منصة ناسيا.') }}</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.1s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/search.png" alt="Search">
                        </div>
                        <h4>{{ translate('سهولة البحث والشراء') }}</h4>
                        <p>{{ translate('Find your luxury items effortlessly with our smart search and filtering.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.2s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/track-order.png" alt="Track">
                        </div>
                        <h4>{{ translate('متابعة الطلبات في الوقت الحقيقي') }}</h4>
                        <p>{{ translate('Know exactly where your package is from the moment of purchase to delivery.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.3s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/cash-in-hand.png" alt="Payment">
                        </div>
                        <h4>{{ translate('خيارات دفع متنوعة') }}</h4>
                        <p>{{ translate('Multiple secure payment gateways to provide you the most convenient checkout.') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="role-card glass-premium wow fadeInUp" data-wow-delay="0.4s">
                        <div class="role-icon-box">
                            <img src="https://img.icons8.com/3d-fluency/188/truck.png" alt="Delivery">
                        </div>
                        <h4>{{ translate('توصيل سريع وآمن') }}</h4>
                        <p>{{ translate('Your premium orders are handled with care and delivered with gold-standard speed.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Role Section 3: For Delivery --}}
    <section class="role-section section-luxury-spacing">
        <div class="container">
            <div class="delivery-showcase-box glass-premium wow fadeInUp">
                <div class="delivery-img-wrapper">
                    <img src="https://img.icons8.com/3d-fluency/400/truck.png" alt="Delivery App">
                </div>
                <div class="delivery-content">
                    <h2 class="fw-900 mb-4" style="font-size: 36px; color: #1A1D23;">{{ translate('للمندوبين') }}</h2>
                    <p class="mb-4" style="font-size: 18px; color: #6B7280; line-height: 1.8;">
                        {{ translate('استلم طلباتك وتابع مواقع التوصيل بذكاء من خلال تطبيق المندوب المتطور.') }}
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#download-app" class="btn-premium btn-role-cta" style="background: #1A1D23; color: #fff;">{{ translate('Join Now') }}</a>
                    </div>
                </div>
            </div> 
        </div>
    </section>

    <!-- ==== Testimonials Section Starts Here ==== -->
    <section class="testimonial-section section-luxury-spacing" id="testimonials" style="background: #fff;">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="elite-pill">{{ translate('قالوا عن ناصية') }}</span>
                <h2 class="mb-0">{{ translate('آراء عملائنا') }}</h2>
            </div>
            
            <div class="row g-4 align-items-stretch">
                {{-- Testimonial 1: Buyer --}}
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card-premium wow fadeInUp" data-wow-delay="0.1s">
                        <div class="testi-header">
                            <div class="testi-author-info">
                                <div class="testi-avatar">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&h=150&auto=format&fit=crop" alt="User">
                                </div>
                                <div>
                                    <h4>Ahmed Ali</h4>
                                    <span class="testi-role buyer">{{ translate('مشتري') }}</span>
                                </div>
                            </div>
                            <div class="testi-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="testi-body">
                            <p>"{{ translate('تجربة تسوق رائعة، التطبيق سهل جداً في الاستخدام والتوصيل كان أسرع مما توقعت. جودة المنتجات ممتازة.') }}"</p>
                        </div>
                        <div class="testi-footer">
                            <span class="testi-date">Feb 20, 2024</span>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2: Seller --}}
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card-premium wow fadeInUp" data-wow-delay="0.2s">
                        <div class="testi-header">
                            <div class="testi-author-info">
                                <div class="testi-avatar">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=150&h=150&auto=format&fit=crop" alt="Seller">
                                </div>
                                <div>
                                    <h4>Nour Fashion</h4>
                                    <span class="testi-role seller">{{ translate('بائع') }}</span>
                                </div>
                            </div>
                            <div class="testi-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="testi-body">
                            <p>"{{ translate('لوحة تحكم البائع ساعدتني جداً في إدارة مخزوني وطلباتي بسهولة. ناصية فتحت لي سوق جديد وعملاء أكتر.') }}"</p>
                        </div>
                        <div class="testi-footer">
                            <span class="testi-date">Feb 15, 2024</span>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3: Buyer --}}
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card-premium wow fadeInUp" data-wow-delay="0.3s">
                        <div class="testi-header">
                            <div class="testi-author-info">
                                <div class="testi-avatar">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&h=150&auto=format&fit=crop" alt="User">
                                </div>
                                <div>
                                    <h4>Sara Khaled</h4>
                                    <span class="testi-role buyer">{{ translate('مشتري') }}</span>
                                </div>
                            </div>
                            <div class="testi-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        <div class="testi-body">
                            <p>"{{ translate('أفضل تطبيق للتسوق في المنطقة. خيارات الدفع متنوعة ومريحة، والدعم الفني دايماً موجود للمساعدة.') }}"</p>
                        </div>
                        <div class="testi-footer">
                            <span class="testi-date">Jan 28, 2024</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==== Final CTA Section ==== -->
    <section class="final-cta-section wow fadeInUp">
        <div class="container">
            <div class="cta-content-wrapper">
                <h2 class="cta-title-ultra">{{ translate('حمل التطبيق وابدأ رحلتك الآن') }}</h2>
                <div class="cta-btns-group">
                    <a href="#download-app" class="btn-cta-big btn-cta-gold">
                        <i class="fab fa-google-play"></i>
                        {{ translate('Download App') }}
                    </a>
                    <a href="#download-app" class="btn-cta-big btn-cta-outline">
                        <i class="fas fa-store"></i>
                        {{ translate('Be a Vendor') }}
                    </a>
                </div>
            </div>
        </div>
    </section>



@endsection
@push('script_2')
    <script>
        $(document).ready(function() {
            $('#welcome-modal').modal('show');
        });
    </script>
    <script>
        "use strict";
        $(document).ready(function() {
            "use strict";
            $('.onerror-image').on('error', function() {
                let img = $(this).data('onerror-image')
                $(this).attr('src', img);
            });
        });
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))

        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
    <script>
        $(document).ready(function() {
            // Consolidated Category Slider Initialization
            if ($('.category-slider-v3').length) {
                var isRtl = $('html').attr('dir') === 'rtl';
                $('.category-slider-v3').owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    smartSpeed: 1000,
                    rtl: isRtl,
                    responsive: {
                        0: { items: 2 },
                        480: { items: 3 },
                        768: { items: 4 },
                        992: { items: 6 },
                        1200: { items: 8 }
                    }
                });
            }

            // Hero Search Logic
            $('.hero-search-btn').on('click', function() {
                executeSearch();
            });

            $('.hero-search-input').on('keypress', function(e) {
                if(e.which == 13) {
                    executeSearch();
                }
            });

            function executeSearch() {
                let query = $('.hero-search-input').val();
                if(query.length > 0) {
                    window.location.href = "{{ route('home') }}?search=" + encodeURIComponent(query) + "#products-section";
                } else {
                    $('html, body').animate({
                        scrollTop: $("#products-section").offset().top - 100
                    }, 800);
                }
            }

            // Flash Showroom Countdown
            function updateAllFlashCounters() {
                const now = new Date().getTime();
                
                $('.flash-countdown-wrapper').each(function() {
                    const endTimeStr = $(this).data('end-time');
                    const flashTargetDate = new Date(endTimeStr).getTime();
                    const distance = flashTargetDate - now;
                    
                    if (distance < 0) {
                        $(this).html("<h3 style='color:#ef4444'>CAMPAIGN ENDED</h3>");
                        return;
                    }
                    
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    $(this).find(".hours").html(hours.toString().padStart(2, '0'));
                    $(this).find(".mins").html(minutes.toString().padStart(2, '0'));
                    $(this).find(".secs").html(seconds.toString().padStart(2, '0'));
                });
            }
            
            setInterval(updateAllFlashCounters, 1000);
            updateAllFlashCounters();

            // Features Carousel (Figma Version)
            if ($('#features-owl').length) {
                var isRtl = $('html').attr('dir') === 'rtl';
                $('#features-owl').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    smartSpeed: 1000,
                    rtl: isRtl,
                    items: 1,
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn'
                });
            }
        });
    </script>
    <script>
function loadMoreProducts(departmentId){
    fetch('/get-all-products/' + departmentId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('dept-'+departmentId).innerHTML = data;
            document.getElementById('btn-container-'+departmentId).style.display = 'none';
        });
}
</script>
@endpush
