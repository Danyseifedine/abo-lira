@extends('layout.master')
@section('content')

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <nav aria-label="breadcrumb">
                            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
                                <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link" style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">
                                    {{ __('detail.home') }}
                                </a>
                                <span style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;" aria-current="page">About Us</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start about section -->
    <section class="about__section section--padding mb-95">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__thumb d-flex">
                        <div class="about__thumb--items">
                            <img class="about__thumb--img border-radius-5" src="{{ asset('assets/img/other/about-thumb-list1.webp') }}" alt="about-thumb">
                        </div>
                        <div class="about__thumb--items position__relative">
                            <img class="about__thumb--img border-radius-5" src="{{ asset('assets/img/other/about-thumb-list2.webp') }}" alt="about-thumb">
                            <div class="banner__bideo--play about__thumb--play">
                                <a class="banner__bideo--play__icon about__thumb--play__icon glightbox" href="https://vimeo.com/115041822" data-gallery="video">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 31 37">
                                        <path id="Polygon_1" data-name="Polygon 1" d="M16.783,2.878a2,2,0,0,1,3.435,0l14.977,25.1A2,2,0,0,1,33.477,31H3.523a2,2,0,0,1-1.717-3.025Z" transform="translate(31) rotate(90)" fill="currentColor" />
                                    </svg>
                                    <span class="visually-hidden">bideo play</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__content">
                        <span class="about__content--subtitle text__secondary mb-20"> Why Choose us</span>
                        <h2 class="about__content--maintitle mb-25">We do not compromise on quality & service.</h2>
                        <p class="about__content--desc mb-20">
                            With over ten years of hands-on experience, Amin Abou Lira has built a trusted reputation as one of the leading
                            motorcycle mechanics in the region. His workshops are known for precision, reliability, and passion — where every
                            motorcycle, from classic to modern, receives the highest level of care.
                        </p>
                        <p class="about__content--desc mb-25">
                            Supported by a skilled team of technicians and equipped shops, Amin offers complete repair solutions,
                            from engine overhauls to fine-tuning and customization. He also provides premium spare parts and the finest
                            accessories to keep every bike running smoothly and looking its best.
                        </p>
                        <div class="about__author position__relative d-flex align-items-center gap-3">
                            <div>
                                <h3 class="about__author--name h4">Amin Abou Lira</h3>
                                <span class="about__author--rank">Motorcycle Mechanic & Workshop Owner</span>
                            </div>
                            <!-- <img class="" src="{{ asset('assets/img/icon/signature.webp') }}" alt="signature"> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End about section -->

    <!-- Start counterup banner section -->
    <div class="counterup__banner--section counterup__banner__bg2" id="funfactId">
        <div class="container">
            <div class="row row-cols-1 align-items-center">
                <div class="col">
                    <div class="counterup__banner--inner position__relative d-flex align-items-center justify-content-between">
                        <div class="counterup__items text-center">
                            <h2 class="counterup__title">YEARS OF <br>
                                FOUNDATION</h2>
                            <span class="counterup__number js-counter" data-count="10">10</span>
                        </div>
                        <div class="counterup__items text-center">
                            <h2 class="counterup__title">SKILLED TEAM <br>
                                MEMBERS </h2>
                            <span class="counterup__number js-counter" data-count="7">7</span>
                        </div>
                        <div class="counterup__items text-center">
                            <h2 class="counterup__title">HAPPY <br>
                                CUSTOMERS</h2>
                            <span class="counterup__number js-counter" data-count="80">0</span>
                        </div>
                        <div class="counterup__items text-center">
                            <h2 class="counterup__title">MONTHLY <br>
                                ORDERS</h2>
                            <span class="counterup__number js-counter" data-count="70">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End counterup banner section -->

    <!-- Start team members section -->
    <section class="team__section section--padding">
        <div class="container">
            <div class="section__heading style2 text-center mb-40">
                <h2 class="section__heading--maintitle">The Owner</h2>
            </div>
            <div class="team__container">
                <div class="row mb--n30">
                    <div class="col-12 mb-30">
                        <div class="team__items text-center">
                            <div class="team__thumb">
                                <img class="team__thumb--img" src="{{ asset('assets/img/other/team1.webp') }}" alt="team img">
                            </div>
                            <div class="team__content ">
                                <h3 class="team__content--title">Amin Abou Lira</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End team members section -->

    <!-- Start brand section -->
    <div class="brand__section brand__section--style3 section--padding">
        <div class="container">
            <div class="brand__section--inner__style3 d-flex justify-content-between align-items-center">
                <div class="brang__logo--items">
                    <img class="brang__logo--img" src="{{ asset('assets/img/logo/brand-logo1.webp') }}" alt="brand-logo">
                </div>
                <div class="brang__logo--items">
                    <img class="brang__logo--img" src="{{ asset('assets/img/logo/brand-logo2.webp') }}" alt="brand-logo">
                </div>
                <div class="brang__logo--items">
                    <img class="brang__logo--img" src="{{ asset('assets/img/logo/brand-logo3.webp') }}" alt="brand-logo">
                </div>
                <div class="brang__logo--items">
                    <img class="brang__logo--img" src="{{ asset('assets/img/logo/brand-logo4.webp') }}" alt="brand-logo">
                </div>
                <div class="brang__logo--items">
                    <img class="brang__logo--img" src="{{ asset('assets/img/logo/brand-logo5.webp') }}" alt="brand-logo">
                </div>
            </div>
        </div>
    </div>
    <!-- End brand section -->
</main>

@endsection