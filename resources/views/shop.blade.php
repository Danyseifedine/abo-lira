@extends('layout.master')
@section('content')
    <!-- Start offcanvas filter sidebar -->
    <div class="offcanvas__filter--sidebar widget__area">
        <button type="button" class="offcanvas__filter--close" data-offcanvas>
            <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"></path></svg> <span class="offcanvas__filter--close__text">Close</span>
        </button>
        <div class="offcanvas__filter--sidebar__inner">
            <div class="single__widget widget__bg">
                <h2 class="widget__title h3">Categories</h2>
                <ul class="widget__categories--menu">
                    <li class="widget__categories--menu__list">
                        <label class="widget__categories--menu__label d-flex align-items-center">
                            <img class="widget__categories--menu__img" src="assets/img/product/small-product/product1.webp" alt="categories-img">
                            <span class="widget__categories--menu__text">Smart Devices</span>
                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                <path  d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </label>
                        <ul class="widget__categories--sub__menu">
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">resh Nuts</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Millk Cream</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="widget__categories--menu__list">
                        <label class="widget__categories--menu__label d-flex align-items-center">
                            <img class="widget__categories--menu__img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                            <span class="widget__categories--menu__text">Break disc Parts</span>
                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" >
                                <path  d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </label>
                        <ul class="widget__categories--sub__menu">
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">resh Nuts</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Millk Cream</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="widget__categories--menu__list">
                        <label class="widget__categories--menu__label d-flex align-items-center">
                            <img class="widget__categories--menu__img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                            <span class="widget__categories--menu__text">Service Kits</span>
                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                <path  d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </label>
                        <ul class="widget__categories--sub__menu">
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">resh Nuts</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Millk Cream</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="widget__categories--menu__list">
                        <label class="widget__categories--menu__label d-flex align-items-center">
                            <img class="widget__categories--menu__img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                            <span class="widget__categories--menu__text">Engine Parts</span>
                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                <path  d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </label>
                        <ul class="widget__categories--sub__menu">
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">resh Nuts</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Millk Cream</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="widget__categories--menu__list">
                        <label class="widget__categories--menu__label d-flex align-items-center">
                            <img class="widget__categories--menu__img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                            <span class="widget__categories--menu__text">Oil & Lubricants</span>
                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                <path  d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </label>
                        <ul class="widget__categories--sub__menu">
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">resh Nuts</span>
                                </a>
                            </li>
                            <li class="widget__categories--sub__menu--list">
                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                    <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                    <span class="widget__categories--sub__menu--text">Millk Cream</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="single__widget widget__bg">
                <h2 class="widget__title h3">Dietary Needs</h2>
                <ul class="widget__form--check">
                    <li class="widget__form--check__list">
                        <label class="widget__form--check__label" for="check6">Body Parts</label>
                        <input class="widget__form--check__input" id="check6" type="checkbox">
                        <span class="widget__form--checkmark"></span>
                    </li>
                    <li class="widget__form--check__list">
                        <label class="widget__form--check__label" for="check7">Oiles Fluids</label>
                        <input class="widget__form--check__input" id="check7" type="checkbox">
                        <span class="widget__form--checkmark"></span>
                    </li>
                    <li class="widget__form--check__list">
                        <label class="widget__form--check__label" for="check8">Car care kits</label>
                        <input class="widget__form--check__input" id="check8" type="checkbox">
                        <span class="widget__form--checkmark"></span>
                    </li>
                    <li class="widget__form--check__list">
                        <label class="widget__form--check__label" for="check9">Brake disks</label>
                        <input class="widget__form--check__input" id="check9" type="checkbox">
                        <span class="widget__form--checkmark"></span>
                    </li>
                    <li class="widget__form--check__list">
                        <label class="widget__form--check__label" for="check10">Repair Parts</label>
                        <input class="widget__form--check__input" id="check10" type="checkbox">
                        <span class="widget__form--checkmark"></span>
                    </li>
                </ul>
            </div>
            <div class="single__widget price__filter widget__bg">
                <h2 class="widget__title h3">Filter By Price</h2>
                <form class="price__filter--form" action="#">
                    <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                        <div class="price__filter--group">
                            <label class="price__filter--label" for="Filter-Price-GTE">From</label>
                            <div class="price__filter--input">
                                <span class="price__filter--currency">$</span>
                                <input class="price__filter--input__field border-0" name="filter.v.price.gte" id="Filter-Price-GTE" type="number" placeholder="0" min="0" max="250.00">
                            </div>
                        </div>
                        <div class="price__divider">
                            <span>-</span>
                        </div>
                        <div class="price__filter--group">
                            <label class="price__filter--label" for="Filter-Price-LTE">To</label>
                            <div class="price__filter--input">
                                <span class="price__filter--currency">$</span>
                                <input class="price__filter--input__field border-0" name="filter.v.price.lte" id="Filter-Price-LTE" type="number" min="0" placeholder="250.00" max="250.00">
                            </div>
                        </div>
                    </div>
                    <button class="primary__btn price__filter--btn" type="submit">Filter</button>
                </form>
            </div>
            <div class="single__widget widget__bg">
                <h2 class="widget__title h3">Top Rated Product</h2>
                <div class="shop__sidebar--product">
                    <div class="small__product--card d-flex">
                        <div class="small__product--thumbnail">
                            <a class="display-block" href="product-details.html"><img src="assets/img/product/small-product/product6.webp" alt="product-img"></a>
                        </div>
                        <div class="small__product--content">
                            <h3 class="small__product--card__title"><a href="product-details.html">Black Air Pods </a></h3>
                            <div class="small__product--card__price">
                                <span class="current__price">$239.52</span>
                            </div>
                            <ul class="rating small__product--rating d-flex">
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.4141 4.53125L8.99219 4.03906L7.44531 0.921875C7.1875 0.382812 6.39062 0.359375 6.10938 0.921875L4.58594 4.03906L1.14062 4.53125C0.53125 4.625 0.296875 5.375 0.742188 5.82031L3.20312 8.23438L2.61719 11.6328C2.52344 12.2422 3.17969 12.7109 3.71875 12.4297L6.78906 10.8125L9.83594 12.4297C10.375 12.7109 11.0312 12.2422 10.9375 11.6328L10.3516 8.23438L12.8125 5.82031C13.2578 5.375 13.0234 4.625 12.4141 4.53125ZM9.53125 7.95312L10.1875 11.75L6.78906 9.96875L3.36719 11.75L4.02344 7.95312L1.25781 5.28125L5.07812 4.71875L6.78906 1.25L8.47656 4.71875L12.2969 5.28125L9.53125 7.95312Z" fill="currentColor"/>
                                         </svg>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="small__product--card d-flex">
                        <div class="small__product--thumbnail">
                            <a class="display-block" href="product-details.html"><img src="assets/img/product/small-product/product7.webp" alt="product-img"></a>
                        </div>
                        <div class="small__product--content">
                            <h3 class="small__product--card__title"><a href="product-details.html">Amazon Cloud  </a></h3>
                            <div class="small__product--card__price">
                                <span class="current__price">$178.52</span>
                            </div>
                            <ul class="rating small__product--rating d-flex">
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.4141 4.53125L8.99219 4.03906L7.44531 0.921875C7.1875 0.382812 6.39062 0.359375 6.10938 0.921875L4.58594 4.03906L1.14062 4.53125C0.53125 4.625 0.296875 5.375 0.742188 5.82031L3.20312 8.23438L2.61719 11.6328C2.52344 12.2422 3.17969 12.7109 3.71875 12.4297L6.78906 10.8125L9.83594 12.4297C10.375 12.7109 11.0312 12.2422 10.9375 11.6328L10.3516 8.23438L12.8125 5.82031C13.2578 5.375 13.0234 4.625 12.4141 4.53125ZM9.53125 7.95312L10.1875 11.75L6.78906 9.96875L3.36719 11.75L4.02344 7.95312L1.25781 5.28125L5.07812 4.71875L6.78906 1.25L8.47656 4.71875L12.2969 5.28125L9.53125 7.95312Z" fill="currentColor"/>
                                         </svg>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="small__product--card d-flex">
                        <div class="small__product--thumbnail">
                            <a class="display-block" href="product-details.html"><img src="assets/img/product/small-product/product8.webp" alt="product-img"></a>
                        </div>
                        <div class="small__product--content">
                            <h3 class="small__product--card__title"><a href="product-details.html">Lorem ipsum sit. </a></h3>
                            <div class="small__product--card__price">
                                <span class="current__price">$276.52</span>
                            </div>
                            <ul class="rating small__product--rating d-flex">
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.08398 0.921875L4.56055 4.03906L1.11523 4.53125C0.505859 4.625 0.271484 5.375 0.716797 5.82031L3.17773 8.23438L2.5918 11.6328C2.49805 12.2422 3.1543 12.7109 3.69336 12.4297L6.76367 10.8125L9.81055 12.4297C10.3496 12.7109 11.0059 12.2422 10.9121 11.6328L10.3262 8.23438L12.7871 5.82031C13.2324 5.375 12.998 4.625 12.3887 4.53125L8.9668 4.03906L7.41992 0.921875C7.16211 0.382812 6.36523 0.359375 6.08398 0.921875Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__icon">
                                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.4141 4.53125L8.99219 4.03906L7.44531 0.921875C7.1875 0.382812 6.39062 0.359375 6.10938 0.921875L4.58594 4.03906L1.14062 4.53125C0.53125 4.625 0.296875 5.375 0.742188 5.82031L3.20312 8.23438L2.61719 11.6328C2.52344 12.2422 3.17969 12.7109 3.71875 12.4297L6.78906 10.8125L9.83594 12.4297C10.375 12.7109 11.0312 12.2422 10.9375 11.6328L10.3516 8.23438L12.8125 5.82031C13.2578 5.375 13.0234 4.625 12.4141 4.53125ZM9.53125 7.95312L10.1875 11.75L6.78906 9.96875L3.36719 11.75L4.02344 7.95312L1.25781 5.28125L5.07812 4.71875L6.78906 1.25L8.47656 4.71875L12.2969 5.28125L9.53125 7.95312Z" fill="currentColor"/>
                                         </svg>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single__widget widget__bg">
                <h2 class="widget__title h3">Brands</h2>
                <ul class="widget__tagcloud">
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html"> Paintworks
                    </a></li>
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Lighting</a></li>
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Gaming</a></li>
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Bumpers </a></li>
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Hoods </a></li>
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Air Boxes</a></li>
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Fog Lights</a></li>
                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="shop.html">Interior </a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End offcanvas filter sidebar -->

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title">Product</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a href="index.html">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span>Product</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start shop section -->
        <div class="shop__section section--padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 shop-col-width-lg-4">
                        <div class="shop__sidebar--widget widget__area d-none d-lg-block">

                            <div class="single__widget price__filter widget__bg">
                                <h2 class="widget__title h3">Filter By Price</h2>
                                <form class="price__filter--form" action="#">
                                    <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                                        <div class="price__filter--group">
                                            <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
                                            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                                <span class="price__filter--currency">$</span>
                                                <input class="price__filter--input__field border-0" name="filter.v.price.gte" id="Filter-Price-GTE2" type="number" placeholder="0" min="0" max="250.00">
                                            </div>
                                        </div>
                                        <div class="price__divider">
                                            <span>-</span>
                                        </div>
                                        <div class="price__filter--group">
                                            <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
                                            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                                <span class="price__filter--currency">$</span>
                                                <input class="price__filter--input__field border-0" name="filter.v.price.lte" id="Filter-Price-LTE2" type="number" min="0" placeholder="250.00" max="250.00">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="primary__btn price__filter--btn" type="submit">Filter</button>
                                </form>
                            </div>


                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 shop-col-width-lg-8">
                        <div class="shop__right--sidebar">
                            <!-- Start categories section -->
                            <section class="categories__section mb-30">
            <div class="container">
                <div class="section__heading border-bottom mb-30">
                    <h2 class="section__heading--maintitle">Shop by <span>Categories</span></h2>
                </div>
                <div class="categories__inner--style3 d-flex">

                <x-category
                            image="assets/img/categories/categories-product1.webp"
                            link="{{ route('shop') }}"
                            name="Engine Parts"
                            :itemCount="18"
                        />
            </div>
        </section>
                            <!-- End categories section -->
                            <div class="shop__product--wrapper">
                                <div class="shop__header d-flex align-items-center justify-content-between mb-30">
                                    <!-- Sort select input aligned left, view modes aligned right -->
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <div class="product__view--mode__list product__short--by align-items-center d-flex">
                                            <label class="product__view--label mb-0">Sort By :</label>
                                            <div class="select shop__header--select ms-2">
                                                <select class="product__view--select">
                                                    <option selected value="1">Sort by latest</option>
                                                    <option value="2">Sort by popularity</option>
                                                    <option value="3">Sort by newness</option>
                                                    <option value="4">Sort by  rating </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="widget__filter--btn d-flex d-lg-none align-items-center me-3" data-offcanvas>
                                            <svg  class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80"/><circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"/><circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"/><circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"/></svg>
                                            <span class="widget__filter--btn__text">Filter</span>
                                        </button>
                                        <div class="product__view--mode__list">
                                            <div class="product__tab--one product__grid--column__buttons d-flex justify-content-center">
                                                <button class="product__grid--column__buttons--icons active" aria-label="grid btn" data-toggle="tab" data-target="#product_grid">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 9 9">
                                                        <g  transform="translate(-1360 -479)">
                                                          <rect id="Rectangle_5725" data-name="Rectangle 5725" width="4" height="4" transform="translate(1360 479)" fill="currentColor"/>
                                                          <rect id="Rectangle_5727" data-name="Rectangle 5727" width="4" height="4" transform="translate(1360 484)" fill="currentColor"/>
                                                          <rect id="Rectangle_5726" data-name="Rectangle 5726" width="4" height="4" transform="translate(1365 479)" fill="currentColor"/>
                                                          <rect id="Rectangle_5728" data-name="Rectangle 5728" width="4" height="4" transform="translate(1365 484)" fill="currentColor"/>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button class="product__grid--column__buttons--icons" aria-label="list btn" data-toggle="tab" data-target="#product_list">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 13 8">
                                                        <g id="Group_14700" data-name="Group 14700" transform="translate(-1376 -478)">
                                                          <g  transform="translate(12 -2)">
                                                            <g id="Group_1326" data-name="Group 1326">
                                                              <rect id="Rectangle_5729" data-name="Rectangle 5729" width="3" height="2" transform="translate(1364 483)" fill="currentColor"/>
                                                              <rect id="Rectangle_5730" data-name="Rectangle 5730" width="9" height="2" transform="translate(1368 483)" fill="currentColor"/>
                                                            </g>
                                                            <g id="Group_1328" data-name="Group 1328" transform="translate(0 -3)">
                                                              <rect id="Rectangle_5729-2" data-name="Rectangle 5729" width="3" height="2" transform="translate(1364 483)" fill="currentColor"/>
                                                              <rect id="Rectangle_5730-2" data-name="Rectangle 5730" width="9" height="2" transform="translate(1368 483)" fill="currentColor"/>
                                                            </g>
                                                            <g id="Group_1327" data-name="Group 1327" transform="translate(0 -1)">
                                                              <rect id="Rectangle_5731" data-name="Rectangle 5731" width="3" height="2" transform="translate(1364 487)" fill="currentColor"/>
                                                              <rect id="Rectangle_5732" data-name="Rectangle 5732" width="9" height="2" transform="translate(1368 487)" fill="currentColor"/>
                                                            </g>
                                                          </g>
                                                        </g>
                                                      </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab_content">
                                    <div id="product_grid" class="tab_pane active show">
                                        <div class="product__section--inner">
                                            <div class="row mb--n30">
                                                <x-product
                                        primaryImage="assets/img/product/main-product/product5.webp"
                                        name="1"
                                        currentPrice="239.52"
                                        oldPrice="362.00"
                                        discount="14"
                        />

                        <x-product
                                        primaryImage="assets/img/product/main-product/product5.webp"
                                        name="1"
                                        currentPrice="239.52"
                                        oldPrice="362.00"
                                        discount="14"
                        />
                                            </div>
                                        </div>
                                    </div>
                                    <div id="product_list" class="tab_pane">
                                        <div class="product__section--inner product__section--style3__inner">
                                            <div class="row row-cols-1 mb--n30">
                                                <x-product-wide
                                        primaryImage="assets/img/product/main-product/product5.webp"
                                        name="1"
                                        currentPrice="239.52"
                                        oldPrice="362.00"
                                        discount="14"
                                        description="Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia voluptas dolore doloribus architecto sequi corporis deleniti officia culpa dolor esse there consectetur eligendi, natus at rem ab quae amet molestiae quod voluptates."
                        />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End shop section -->

    </main>

@endsection
