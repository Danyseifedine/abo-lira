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
                                <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link" style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">{{ __('nav.home') }}</a>
                                <span style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;" aria-current="page">{{ __('nav.need') }}</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start contact section -->
    <section class="contact__section section--padding">
        <div class="container">
            <div class="contact__section--heading text-center mb-40">
                <h2 class="contact__section--heading__maintitle">{{ __('needs.request_your_needs') }}</h2>
                <!-- <p class="contact__section--heading__desc">Beyond more stoic this along goodness this sed wow manatee mongos flusterd impressive man farcrud opened.</p> -->
            </div>
            <div class="main__contact--area position__relative" style="padding-bottom: 100px;">
                <div class="contact__form">
                    <!-- <h3 class="contact__form--title mb-30">Request your needs</h3> -->
                    <form class="contact__form--inner" id="needs-form" action="{{ route('request-product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger mb-4">
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="" for="input1">{{ __('checkout.first_name') }} <span class="contact__form--label__star">*</span></label>
                                    <input class="checkout__input--field border-radius-5 @error('f_name') is-invalid @enderror" name="f_name" id="input1" placeholder="{{ __('needs.first_name_placeholder') }}" type="text" value="{{ old('f_name') }}" required>
                                    @error('f_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="" for="input2">{{ __('checkout.last_name') }} <span class="contact__form--label__star">*</span></label>
                                    <input class="checkout__input--field border-radius-5 @error('l_name') is-invalid @enderror" name="l_name" id="input2" placeholder="{{ __('needs.last_name_placeholder') }}" type="text" value="{{ old('l_name') }}" required>
                                    @error('l_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="" for="input3">{{ __('checkout.phone_number') }} <span class="contact__form--label__star">*</span></label>
                                    <label class="d-flex align-items-center" style="position: relative; direction: ltr;">
                                        <span class="d-flex justify-content-center align-items-center"
                                            style="width: 50px; position: absolute; left: 0; top: 0; bottom: 0; margin: auto;">+961
                                        </span>
                                        <input class="checkout__input--field border-radius-5 @error('phone_number') is-invalid @enderror" id="input3" name="phone_number" placeholder="{{ __('checkout.phone_number_placeholder') }}" type="number" value="{{ old('phone_number') }}" style="padding-left: 50px;" required>
                                    </label>
                                    @error('phone_number')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="contact__form--list mb-20">
                                    <label class="" for="input4">{{ __('needs.request_image') }}</label>
                                    <input class="checkout__input--field border-radius-5 @error('image') is-invalid @enderror" id="input4" name="image"
                                        type="file" accept="image/*">
                                    @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact__form--list mb-15">
                                    <label class="" for="input5">{{ __('needs.write_your_message') }} <span class="contact__form--label__star"></span></label>
                                    <textarea class="contact__form--textarea @error('message') is-invalid @enderror" name="message" id="input5" placeholder="{{ __('needs.write_your_message_placeholder') }}" required>{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="contact__form--btn primary__btn" id="submit-btn" type="submit">
                            <span id="submit-text">{{ __('needs.submit_now') }}</span>
                        </button>
                    </form>

                    <div id="image-preview-container" class="mt-3" style="display: none; width: 100%;">
                        <img id="image-preview" src="" alt="Preview" class="border-radius-5 w-100" style="max-width: 100%; max-height: 300px; object-fit: contain; border: 1px solid #ddd; padding: 8px;">
                    </div>
                </div>
                <div class="contact__info border-radius-5">
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">{{ __('needs.contact_us') }}</h3>
                        <div class="contact__info--items__inner d-flex align-items-center gap-3">
                            <div class="contact__info--icon" style="margin-right: 0 !important;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.568" height="31.128" viewBox="0 0 31.568 31.128">
                                    <path id="ic_phone_forwarded_24px" d="M26.676,16.564l7.892-7.782L26.676,1V5.669H20.362v6.226h6.314Zm3.157,7a18.162,18.162,0,0,1-5.635-.887,1.627,1.627,0,0,0-1.61.374l-3.472,3.424a23.585,23.585,0,0,1-10.4-10.257l3.472-3.44a1.48,1.48,0,0,0,.395-1.556,17.457,17.457,0,0,1-.9-5.556A1.572,1.572,0,0,0,10.1,4.113H4.578A1.572,1.572,0,0,0,3,5.669,26.645,26.645,0,0,0,29.832,32.128a1.572,1.572,0,0,0,1.578-1.556V25.124A1.572,1.572,0,0,0,29.832,23.568Z" transform="translate(-3 -1)" fill="currentColor" />
                                </svg>
                            </div>
                            <a href="https://wa.link/03etwr" class="text-white" style="direction: ltr;">+961 70 025 668</a>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">{{ __('needs.office_location') }}</h3>
                        <div class="contact__info--items__inner d-flex align-items-center gap-3">
                            <div class="contact__info--icon" style="margin-right: 0 !important;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13" viewBox="0 0 31.57 31.13">
                                    <path id="ic_account_balance_24px" d="M5.323,14.341V24.718h4.985V14.341Zm9.969,0V24.718h4.985V14.341ZM2,32.13H33.57V27.683H2ZM25.262,14.341V24.718h4.985V14.341ZM17.785,1,2,8.412v2.965H33.57V8.412Z" transform="translate(-2 -1)" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="contact__info--content">
                                <p class="contact__info--content__desc text-white">{{ __('needs.location') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="contact__info--items">
                        <h3 class="contact__info--content__title text-white mb-15">{{ __('needs.follow_us') }}</h3>
                        <ul class="contact__info--social d-flex align-items-center gap-3" style="margin-right: 0 !important;">
                            <li class="contact__info--social__list" style="margin-right: 0 !important;">
                                <a class="contact__info--social__icon" target="_blank" href="https://www.facebook.com/share/17YdRAALDT/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524" viewBox="0 0 7.667 16.524">
                                        <path data-name="Path 237" d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z" transform="translate(-960.13 -345.407)" fill="currentColor"></path>
                                    </svg>
                                    <span class="visually-hidden">{{ __('nav.facebook') }}</span>
                                </a>
                            </li>
                            <li class="contact__info--social__list" style="margin-right: 0 !important;">
                                <a class="contact__info--social__icon" target="_blank" href="https://www.instagram.com/amin_abolira?igsh=MW14ZGJzNmxpYjM4Zg==">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.497" height="16.492" viewBox="0 0 19.497 19.492">
                                        <path data-name="Icon awesome-instagram" d="M9.747,6.24a5,5,0,1,0,5,5A4.99,4.99,0,0,0,9.747,6.24Zm0,8.247A3.249,3.249,0,1,1,13,11.238a3.255,3.255,0,0,1-3.249,3.249Zm6.368-8.451A1.166,1.166,0,1,1,14.949,4.87,1.163,1.163,0,0,1,16.115,6.036Zm3.31,1.183A5.769,5.769,0,0,0,17.85,3.135,5.807,5.807,0,0,0,13.766,1.56c-1.609-.091-6.433-.091-8.042,0A5.8,5.8,0,0,0,1.64,3.13,5.788,5.788,0,0,0,.065,7.215c-.091,1.609-.091,6.433,0,8.042A5.769,5.769,0,0,0,1.64,19.341a5.814,5.814,0,0,0,4.084,1.575c1.609.091,6.433.091,8.042,0a5.769,5.769,0,0,0,4.084-1.575,5.807,5.807,0,0,0,1.575-4.084c.091-1.609.091-6.429,0-8.038Zm-2.079,9.765a3.289,3.289,0,0,1-1.853,1.853c-1.283.509-4.328.391-5.746.391S5.28,19.341,4,18.837a3.289,3.289,0,0,1-1.853-1.853c-.509-1.283-.391-4.328-.391-5.746s-.113-4.467.391-5.746A3.289,3.289,0,0,1,4,3.639c1.283-.509,4.328-.391,5.746-.391s4.467-.113,5.746.391a3.289,3.289,0,0,1,1.853,1.853c.509,1.283.391,4.328.391,5.746S17.855,15.705,17.346,16.984Z" transform="translate(0.004 -1.492)" fill="currentColor"></path>
                                    </svg>
                                    <span class="visually-hidden">{{ __('nav.instagram') }}</span>
                                </a>
                            </li>
                            <li class="contact__info--social__list" style="margin-right: 0 !important;">
                                <a class="contact__info--social__icon" target="_blank" href="https://www.tiktok.com/@amin.aboliraa?_r=1&_t=ZS-910sl53h3Kv">
                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.375 0.96875H8.75V10.0625C8.75 11.3125 7.71875 12.3438 6.46875 12.3438C5.21875 12.3438 4.1875 11.3125 4.1875 10.0625C4.1875 8.84375 5.1875 7.84375 6.375 7.78125V5.125C3.78125 5.1875 1.6875 7.3125 1.6875 9.9375C1.6875 12.5938 3.8125 14.7188 6.46875 14.7188C9.125 14.7188 11.25 12.5938 11.25 9.9375V5.75C12.2188 6.46875 13.4062 6.875 14.6875 6.90625V4.28125C12.7812 4.1875 11.375 2.71875 11.375 0.96875Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span class="visually-hidden">{{ __('nav.tiktok') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End contact section -->

    <!-- Start contact map area -->
    <div class="contact__map--area section--padding pt-0">
        <iframe class="contact__map--iframe" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d681.4657597714271!2d35.43810789262789!3d33.6549853348428!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ee35fe1c8546f%3A0xdf3eb7acceedc28a!2z2YPYp9ix2KfYrCDYo9mF2YrZhiDYo9io2Ygg2YTZitix2Kk!5e0!3m2!1sen!2sbd!4v1763008301639!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-- End contact map area -->

</main>

@push('styles')
<style>
    #input4[type="file"] {
        padding-top: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    #input4[type="file"]::file-selector-button {
        padding: 4px 8px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
    }

    /* #input4[type="file"]::file-selector-button:hover {
    } */
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('needs-form').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submit-btn');

        submitBtn.style.opacity = '0.5';
        submitBtn.disabled = true;
    });

    // Image preview functionality
    document.getElementById('input4').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');

        if (file) {
            // Check if file is an image
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    previewContainer.style.width = '100%';  
                };

                reader.readAsDataURL(file);
            } else {
                alert('Please select a valid image file.');
                e.target.value = '';
                previewContainer.style.display = 'none';
            }
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endpush

@endsection