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
        html {
            scroll-behavior: smooth;
        }
        :root {
            --base-1: #D4AF37 !important; /* Gold */
            --base-rgb: 212, 175, 55 !important;
            --base-2: #FFD700 !important; /* Lighter Gold */
            --base-rgb-2: 255, 215, 0 !important;
        }

        /* Generic primary color overrides */
        .primary-color, .text--base, .text-base {
            color: var(--base-1) !important;
        }
        .bg--base, .bg-base, .cmn--btn {
            background-color: var(--base-1) !important;
        }
        .btn-primary-premium {
            background: var(--base-1) !important;
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3) !important;
        }
        .btn-primary-premium:hover {
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4) !important;
        }
        .hero-title {
            background: linear-gradient(90deg, var(--title-clr), #D4AF37) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }
        .product-price, .section-title-premium h2::after {
            color: var(--base-1) !important;
        }
        .section-title-premium h2::after {
            background: var(--base-1) !important;
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
        .why-choose-us, .testimonial-section {
            padding: 100px 0;
        }

        /* New Improved Feature Grid */
        .feature-grid-v2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
        }
        .feature-item-premium {
            background: #fff;
            padding: 50px 35px;
            border-radius: 30px;
            text-align: center;
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
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

        /* Improved Testimonials */
        .testimonial-card-v2 {
            background: #fff;
            padding: 50px;
            border-radius: 35px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.04);
            position: relative;
            border: 1px solid #f8f8f8;
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .testimonial-card-v2:hover {
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border-color: rgba(212, 175, 55, 0.2);
        }
        .quote-icon-v2 {
            font-size: 60px;
            color: var(--base-1);
            opacity: 0.1;
            position: absolute;
            top: 40px;
            left: 40px;
            line-height: 1;
        }
        .testimonial-text-v2 {
            font-size: 18px;
            line-height: 1.9;
            color: var(--body-clr);
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
            font-style: italic;
            flex-grow: 1;
        }
        .testimonial-author-v2 {
            display: flex;
            align-items: center;
            gap: 20px;
            padding-top: 30px;
            border-top: 1px solid #f0f0f0;
        }
        .author-img-v2 {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .author-meta-v2 h4 {
            font-size: 20px;
            font-weight: 800;
            margin: 0 0 5px;
            color: var(--title-clr);
        }
        .author-meta-v2 span {
            font-size: 15px;
            color: var(--base-1);
            font-weight: 600;
        }
        /* Grid Layout */
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .testimonial-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .testimonial-grid {
                grid-template-columns: 1fr;
            }
        }

        /* تصغير الكارت */
        .testimonial-card-v2 {
            padding: 30px;
            border-radius: 25px;
        }

        /* تصغير النص */
        .testimonial-text-v2 {
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        /* تصغير الصورة */
        .author-img-v2 {
            width: 55px;
            height: 55px;
        }

        /* تصغير الاسم */
        .author-meta-v2 h4 {
            font-size: 17px;
        }

        .author-meta-v2 span {
            font-size: 13px;
        }


        /* Partners Loop Smoothing */
        .partners-section-v2 {
            padding: 80px 0;
            background: #fff;
            border-top: 1px solid #f5f5f5;
        }
        .partners-marquee-v2 {
            display: flex;
            overflow: hidden;
            width: 100%;
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }
        .partners-track-v2 {
            display: flex;
            width: max-content;
            animation: marquee-scroll 40s linear infinite;
        }
        .partner-box-v2 {
            padding: 0 50px;
            display: flex;
            align-items: center;
        }
        .partner-box-v2 img {
            height: 45px;
            filter: grayscale(1);
            opacity: 0.4;
            transition: all 0.4s ease;
        }
        .partner-box-v2:hover img {
            filter: grayscale(0);
            opacity: 1;
            transform: scale(1.1);
        }
        @keyframes marquee-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
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

    <!-- ==== Premium Hero Section Starts Here ==== -->
    <section class="hero-section" id="hero">
        <div class="hero-bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content wow fadeInLeft">
                    <h1 class="hero-title">{{ translate('NASIA Market') }}</h1>
                    <p class="hero-subtitle">{{ translate('Experience the future of e-commerce with our premium selection of quality products. Fast delivery, secure payments, and unbeatable variety tailored just for you.') }}</p>

                    <div class="hero-search-wrapper">
                        <input type="text" class="hero-search-input" placeholder="{{ translate('Search for fresh products...') }}">
                        <button class="hero-search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="hero-btns">
                        <a href="#products-section" class="btn-premium btn-primary-premium">{{ translate('Shop Now') }}</a>
                        <a href="{{ route('about-us') }}" class="btn-premium btn-secondary-premium">{{ translate('Learn More') }}</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image-wrapper wow fadeInRight">
                    <div class="position-relative">
                        <img src="{{asset('public/assets/landing/img/super.jpg')}}" class="hero-main-img" alt="NASIA EC Hero">

                        <div class="floating-badge badge-1">
                            <i class="fas fa-shipping-fast text-success fs-4"></i>
                            <div>
                                <div class="fw-bold text-dark">{{ translate('Fast Delivery') }}</div>
                                <div class="small">{{ translate('Within 24 Hours') }}</div>
                            </div>
                        </div>

                        <div class="floating-badge badge-2">
                            <i class="fas fa-shield-alt text-primary fs-4"></i>
                            <div>
                                <div class="fw-bold text-dark">{{ translate('Secure Payment') }}</div>
                                <div class="small">{{ translate('100% Protected') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Premium Hero Section Ends Here ==== -->


    <!-- ==== Category Discovery Slider (Departments) Starts Here ==== -->
    @if(count($landing_data['landing_departments']) > 0)
    <section class="category-discovery-section py-4">
        <div class="container px-3">
            <div class="owl-carousel owl-theme category-slider-v3">
                @foreach($landing_data['landing_departments'] as $department)
                <div class="category-item-v3">
                    <a href="#dept-{{ $department->id }}">
                        <div class="category-icon-wrapper" style="background-image: url('{{ $department->cover_image ? asset('storage/'.$department->cover_image) : asset('assets/landing/img/super.jpg') }}')">
                        </div>
                        <h4 class="category-name-v3 text-center">{{ $department->title }}</h4>
                        
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ==== Light Premium Flash Showroom Starts Here ==== -->

    <!-- ==== Light Premium Flash Showroom Starts Here ==== -->
    @foreach($landing_data['flash_sales'] as $fIndex => $campaign)
    <section class="premium-flash-showroom @if($fIndex > 0) pt-0 @endif">
        <div class="container">
            <div class="showroom-header">
                <span class="flash-badge-light">{{ translate('Exclusive Limited Offers') }}</span>
                <h2 class="showroom-title">{{ $campaign->headline }}</h2>
                <div class="showroom-timer-inline flash-countdown-wrapper" data-end-time="{{ $campaign->ends_at->format('Y-m-d H:i:s') }}">
                    <div class="timer-unit"><span class="timer-val hours">00</span><span class="timer-lab">{{ translate('Hours') }}</span></div>
                    <div class="timer-unit"><span class="timer-val mins">00</span><span class="timer-lab">{{ translate('Mins') }}</span></div>
                    <div class="timer-unit"><span class="timer-val secs">00</span><span class="timer-lab">{{ translate('Secs') }}</span></div>
                </div>
            </div>

            <div class="ld-flash-grid">
                @foreach($campaign->stockUnits as $unit)
                    <div class="light-glass-card">
                        <span class="showroom-discount-tag">-{{ $unit->pivot->discount_rate }}% OFF</span>
                        
                        <div class="showroom-img-box">
                            <img src="{{ $unit->thumbnail ? asset('storage/'.$unit->thumbnail) : 'https://via.placeholder.com/400x300' }}" alt="{{ $unit->title }}">
                        </div>

                        <div class="showroom-details">
                            <span class="showroom-p-category">{{ translate('Elite Selection') }}</span>
                            <h3 class="showroom-p-title">{{ $unit->title }}</h3>
                            
                            <div class="showroom-price-box">
                                @if($unit->base_price > 0 && $unit->base_price > $unit->final_price)
                                    <span class="showroom-price-was">{{ number_format($unit->base_price,2) }} EGP</span>
                                @endif
                                <span class="showroom-price-now">{{ number_format($unit->final_price,2) }} EGP</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endforeach

    <!-- ==== All Departments Section ==== -->
    @if($landing_data['landing_departments']->count() > 0)
    <section class="ld-departments-section" id="products-section">
        <div class="container">
        @foreach($landing_data['landing_departments'] as $department)
            <div class="ld-department-wrapper mb-80">
                <div class="ld-department-header mb-4">
                    <h2 class="showroom-title" style="font-size: 2.5rem;">🔹 {{ $department->title }}</h2>
                </div>

                <div class="ld-products-grid" id="dept-{{ $department->id }}">
                    @foreach($department->stockUnits->take(4) as $unit)
                        <div class="light-glass-card">
                            <div class="showroom-img-box" style="height: 200px;">
                                <img src="{{ $unit->thumbnail ? asset('storage/'.$unit->thumbnail) : 'https://via.placeholder.com/400x300' }}">
                            </div>
                            <div class="showroom-details">
                                <h3 class="showroom-p-title" style="font-size: 1.1rem;">{{ $unit->title }}</h3>
                                <div class="showroom-price-box">
                                    @if($unit->base_price > 0 && $unit->base_price > $unit->final_price)
                                        <span class="showroom-price-was" style="font-size: 0.85rem;">{{ number_format($unit->base_price,2) }} EGP</span>
                                    @endif
                                    <span class="showroom-price-now">{{ number_format($unit->final_price,2) }} EGP</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($department->stockUnits->count() > 4)
                    <div class="text-center mt-4" id="btn-container-{{ $department->id }}">
                        <button class="btn-premium btn-secondary-premium" onclick="loadMoreProducts({{ $department->id }})">{{ translate('Show More') }}</button>
                    </div>
                @endif
            </div>
        @endforeach
        </div>
    </section>
    @endif
    <!-- ==== Custom Products Section Ends Here ==== -->

    <!-- ==== Why Choose Us Section Combined Styles ==== -->

    <section class="why-choose-us pt-100 pb-100" id="features" style="background: #fafaf8;">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="text-base fw-bold text-uppercase mb-2 d-block" style="letter-spacing: 3px;">{{ translate('Excellence') }}</span>
                <h2 class="mb-0">{{ translate('Why Choose NASIA Market') }}</h2>
            </div>
            <div class="feature-grid-v2">
                <div class="feature-item-premium wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-icon-v2">
                        <img src="{{ asset('public/assets/landing/img/feature/trusted.svg') }}" alt="Quality">
                    </div>
                    <h3>{{ translate('Premium Selection') }}</h3>
                    <p>{{ translate('Every item in our collection is handpicked to meet the highest standards of luxury and durability.') }}</p>
                </div>
                <div class="feature-item-premium wow fadeInUp" data-wow-delay="0.2s">
                    <div class="feature-icon-v2">
                        <img src="{{ asset('public/assets/landing/img/feature/delivery.svg') }}" alt="Delivery">
                    </div>
                    <h3>{{ translate('Gold Standard Shipping') }}</h3>
                    <p>{{ translate('Precision logistics ensure your premium products arrive in perfect condition, exactly when you expect them.') }}</p>
                </div>
                <div class="feature-item-premium wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-icon-v2">
                        <img src="{{ asset('public/assets/landing/img/feature/payment.svg') }}" alt="Security">
                    </div>
                    <h3>{{ translate('Secure Elite Pay') }}</h3>
                    <p>{{ translate('Our military-grade encryption systems provide the most secure shopping environment available today.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==== Testimonials Section Starts Here ==== -->
    @php($testimonials = \App\Models\AdminTestimonial::all())
    <section class="testimonial-section pt-100 pb-100" id="testimonials" style="background: #fff;">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="text-base fw-bold text-uppercase mb-2 d-block" style="letter-spacing: 3px;">{{ translate('Voices') }}</span>
                <h2 class="mb-0">{{ translate('Client Perspectives') }}</h2>
            </div>
            <div class="testimonial-grid">
                <!-- Manual Elite Reviews -->
                @foreach($extra_testimonials as $extra)
                <div class="testimonial-card-v2 wow fadeInUp">
                    <div class="quote-icon-v2"><i class="fas fa-quote-left"></i></div>
                    <div class="testimonial-text-v2">
                        "{{ translate($extra['desc']) }}"
                    </div>
                    <div class="testimonial-author-v2">
                        <div class="author-meta-v2">
                            <h4>{{ translate($extra['name']) }}</h4>
                            <span>{{ translate($extra['position']) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </section>

    <!-- ==== Partners Marquee Section Starts Here ==== -->
    <section class="partners-section-v2 pt-80 pb-80" id="partners">
        <div class="container">
            <div class="partners-marquee-v2">
                <div class="partners-track-v2">
                    @for($i = 0; $i < 4; $i++)
                    <div class="partner-box-v2"><img src="{{ asset('public/assets/landing/img/client/logo-1.svg') }}" alt="Partner"></div>
                    <div class="partner-box-v2"><img src="{{ asset('public/assets/landing/img/client/logo-2.svg') }}" alt="Partner"></div>
                    <div class="partner-box-v2"><img src="{{ asset('public/assets/landing/img/client/logo-3.svg') }}" alt="Partner"></div>
                    <div class="partner-box-v2"><img src="{{ asset('public/assets/landing/img/client/logo-4.svg') }}" alt="Partner"></div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- ==== Departments Gallery Section ==== -->
    @if(count($landing_data['landing_departments']) > 0)
    <section class="categories-gallery-section pt-120 pb-120" id="categories">
        <div class="container">
            <div class="section-title-premium text-center mb-80 wow fadeInUp">
                <span class="text-base fw-bold text-uppercase mb-2 d-block" style="letter-spacing: 3px;">{{ translate('The Collection') }}</span>
                <h2 class="mb-0">{{ translate('Elite Departments') }}</h2>
            </div>

            <div class="category-grid-v2">
                @foreach($landing_data['landing_departments']->take(4) as $index => $dept)
                <div class="category-card-v2 wow fadeInUp" data-wow-delay="0.{{ $index + 1 }}s">
                    <img src="{{ $dept->cover_image ? asset('storage/'.$dept->cover_image) : asset('assets/landing/img/super.jpg') }}" class="category-img-v2" alt="{{ $dept->title }}">
                    <div class="category-overlay-v2">
                        <div class="category-content-v2">
                            <span class="category-badge-v2">{{ translate('Elite') }}</span>
                            <h3 class="category-title-v2">{{ $dept->title }}</h3>
                            <p class="category-desc-v2">{{ translate('Explore our curated selection in ') . $dept->title }}</p>
                            <a href="#dept-{{ $dept->id }}" class="category-link-v2">
                                {{ translate('Explore Now') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
