@extends('layout.master')
@section('content')
    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title mb-25"> Cart</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span>Shopping Cart</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- cart section start -->
        <section class="cart__section section--padding">
            <div class="container-fluid">
                <div class="cart__section--inner">
                    <form action="#">
                        <h2 class="cart__title mb-30">Shopping Cart</h2>
                        <!-- Products Section - Full Width -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="cart__table">
                                    <table class="cart__table--inner">
                                        <thead class="cart__table--header">
                                            <tr class="cart__table--header__items">
                                                <th class="cart__table--header__list">Product</th>
                                                <th class="cart__table--header__list">Price</th>
                                                <th class="cart__table--header__list">Quantity</th>
                                                <th class="cart__table--header__list">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cart__table--body">
                                            <x-cart-product
                                                image="assets/img/product/small-product/product9.webp"
                                                name="Fluids & Chemicals"
                                                :variants="['COLOR: Blue', 'WEIGHT: 2 Kg']"
                                                price="65.00"
                                                :quantity="1"
                                                total="130.00"
                                                link="{{ route('detail') }}"
                                            />


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                        </div>

                        <!-- Subtotal Section - Centered -->
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-8">
                                <div class="cart__summary border-radius-10 text-center">
                                    <div class="cart__summary--total mb-20">
                                        <div class="text-center" style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 2px solid #dc3545;">
                                            <div style="font-size: 1.8rem; font-weight: 800; color: #2c3e50; margin-bottom: 8px; text-transform: uppercase;">SUBTOTAL</div>
                                            <div style="font-size: 2rem; font-weight: 700; color: #dc3545;">$860.00</div>
                                        </div>
                                    </div>
                                    <div class="cart__summary--footer">
                                        <ul class="d-flex justify-content-center gap-3">
                                            <li><button class="cart__summary--footer__btn primary__btn cart" type="submit">Update</button></li>
                                            <li><a class="cart__summary--footer__btn primary__btn checkout" href="{{ route('checkout') }}">Checkout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- cart section end -->


        <!-- Start brand section -->
        <div class="brand__section section--padding pt-0">
            <div class="container">
                <div class="brand__section--inner d-flex justify-content-between align-items-center">
                    <div class="brang__logo--items">
                        <img class="brang__logo--img" src="assets/img/logo/brand-logo1.webp" alt="brand-logo">
                    </div>
                    <div class="brang__logo--items">
                        <img class="brang__logo--img" src="assets/img/logo/brand-logo2.webp" alt="brand-logo">
                    </div>
                    <div class="brang__logo--items">
                        <img class="brang__logo--img" src="assets/img/logo/brand-logo3.webp" alt="brand-logo">
                    </div>
                    <div class="brang__logo--items">
                        <img class="brang__logo--img" src="assets/img/logo/brand-logo4.webp" alt="brand-logo">
                    </div>
                    <div class="brang__logo--items">
                        <img class="brang__logo--img" src="assets/img/logo/brand-logo5.webp" alt="brand-logo">
                    </div>
                </div>
            </div>
        </div>
        <!-- End brand section -->

    </main>
@endsection
