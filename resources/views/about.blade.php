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
                                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap"
                                    @if (app()->getLocale() === 'ar') dir="rtl" @endif>
                                    <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link"
                                        style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">
                                        {{ __('detail.home') }}
                                    </a>
                                    <span
                                        style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                    <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;"
                                        aria-current="page">{{ __('about.breadcrumb') }}</span>
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
                    <div class="col-lg-12">
                        <div class="about__content">
                            <span class="about__content--subtitle text__secondary mb-20">{{ __('about.why_choose_us') }}</span>
                            <h2 class="about__content--maintitle mb-25">{{ __('about.main_title') }}</h2>
                            <p class="about__content--desc mb-20">
                                {{ __('about.description_1') }}
                            </p>
                            <p class="about__content--desc mb-25">
                                {{ __('about.description_2') }}
                            </p>
                            <div class="about__author position__relative d-flex align-items-center gap-3">
                                <div>
                                    <h3 class="about__author--name h4">{{ __('about.author_name') }}</h3>
                                    <span class="about__author--rank">{{ __('about.author_rank') }}</span>
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
                        <div
                            class="counterup__banner--inner position__relative d-flex align-items-center justify-content-between">
                            <div class="counterup__items text-center">
                                <h2 class="counterup__title">{!! __('about.years_foundation') !!}</h2>
                                <span class="counterup__number js-counter" data-count="10">10</span>
                            </div>
                            <div class="counterup__items text-center">
                                <h2 class="counterup__title">{!! __('about.skilled_team_members') !!}</h2>
                                <span class="counterup__number js-counter" data-count="7">7</span>
                            </div>
                            <div class="counterup__items text-center">
                                <h2 class="counterup__title">{!! __('about.happy_customers') !!}</h2>
                                <span class="counterup__number js-counter" data-count="15000">0</span>
                            </div>
                            <div class="counterup__items text-center">
                                <h2 class="counterup__title">{!! __('about.monthly_orders') !!}</h2>
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
                    <h2 class="section__heading--maintitle">{{ __('about.the_owner') }}</h2>
                </div>
                <div class="team__container">
                    <div class="row mb--n30">
                        <div class="col-12 mb-30">
                            <div class="team__items text-center">
                                <div class="team__thumb">
                                    <img class="team__thumb--img"
                                        src="{{ asset('assets/img/abo-lira/amin-abo-lira.jpeg') }}"
                                        style="height: 400px;width: 400px;object-fit: cover;" alt="{{ __('about.team_img_alt') }}">
                                </div>
                                <div class="team__content ">
                                    <h3 class="team__content--title">{{ __('about.author_name') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End team members section -->

        <!-- Start brand section -->
        <div class="brand__section section--padding" style="background-color: #f1f3fb;">
            <div class="container">
                <div class="brand__section--inner__style3 d-flex justify-content-between align-items-center">
                    <div class="brang__logo--items">
                        <img src="{{ asset('assets/img/abo-lira/yamaha-logo.png') }}" alt="yamaha"
                            style="height: 40px; object-fit: cover;">
                    </div>
                    <div class="brang__logo--items">
                        <img style="height: 40px; object-fit: cover;" src="{{ asset('assets/img/abo-lira/suzuki.png') }}"
                            alt="suzuki">
                    </div>
                    <div class="brang__logo--items">
                        <img src="{{ asset('assets/img/abo-lira/kawasaki.png') }}" alt="kawasaki"
                            style="height: 40px; object-fit: cover;">
                    </div>
                    <div class="brang__logo--items">
                        <img src="{{ asset('assets/img/abo-lira/honda.png') }}" style="height: 80px; object-fit: cover;"
                            alt="honda">
                    </div>
                    <div>
                        <img src="{{ asset('assets/img/abo-lira/bmw.png') }}" style="height: 80px; object-fit: cover;"
                            alt="bmw">
                    </div>
                </div>
            </div>
        </div>
        <!-- End brand section -->
    </main>
@endsection
