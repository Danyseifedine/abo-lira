 <!-- Start shipping section -->
 <section class="shipping__section section--padding">
     <div class="container">
         <div class="shipping__inner mb-0 style2 d-flex">
             <div class="shipping__items style2 d-flex align-items-center">
                 <div class="shipping__icon">
                     <img src="{{ asset('assets/img/other/shipping1.webp') }}" alt="icon-img">
                 </div>
                 <div class="shipping__content">
                     <h2 class="shipping__content--title h3">{{ __('footer.quality_guarantee') }}</h2>
                     <p class="shipping__content--desc">{{ __('footer.quality_desc') }}</p>
                 </div>
             </div>
             <div class="shipping__items style2 d-flex align-items-center">
                 <div class="shipping__icon">
                     <img src="{{ asset('assets/img/other/shipping2.webp') }}" alt="icon-img">
                 </div>
                 <div class="shipping__content">
                     <h2 class="shipping__content--title h3">{{ __('footer.support_24_7') }}</h2>
                     <p class="shipping__content--desc">{{ __('footer.support_desc') }}</p>
                 </div>
             </div>
             <div class="shipping__items style2 d-flex align-items-center">
                 <div class="shipping__icon">
                     <img src="{{ asset('assets/img/other/shipping3.webp') }}" alt="icon-img">
                 </div>
                 <div class="shipping__content">
                     <h2 class="shipping__content--title h3">{{ __('footer.fast_delivery') }}</h2>
                     <p class="shipping__content--desc">{{ __('footer.delivery_desc') }}</p>
                 </div>
             </div>
             <div class="shipping__items style2 d-flex align-items-center">
                 <div class="shipping__icon">
                     <img src="{{ asset('assets/img/other/shipping4.webp') }}" alt="icon-img">
                 </div>
                 <div class="shipping__content">
                     <h2 class="shipping__content--title h3">{{ __('footer.payment_secure') }}</h2>
                     <p class="shipping__content--desc">{{ __('footer.payment_desc') }}</p>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- End shipping section -->

 <!-- Start footer section -->
 <footer class="footer__section footer__bg5 footer__color--style">
     <div class="container">
         <div class="main__footer">
             <!-- Centered Logo and Description -->
             <div class="row justify-content-center mb-5">
                 <div class="col-lg-8 col-md-10 text-center">
                     <div class="footer__brand mb-4">
                         <a href="{{ route('home') }}" class="footer__logo d-inline-block mb-3">
                             <img src="{{ asset('logos/logo.png') }}" alt="Abo Lira Logo" class="footer__logo--img"
                                 style="max-height: 100px;">
                         </a>
                         <h4 class="footer__brand--desc mb-4" style="max-width: 600px; margin: 0 auto;">
                             {{ __('footer.brand_description') }}
                         </h4>
                     </div>
                 </div>
             </div>

             <!-- Centered Navigation Links -->
             <div class="row justify-content-center mb-5">
                 <div class="col-lg-8 col-md-10">
                     <div class="footer__navigation text-center d-flex flex-column align-items-center">
                         <div class="footer__nav--section">
                             <h4 class="footer__nav--title mb-4 text-uppercase fw-bold">
                                 {{ __('footer.connect_with_us') }}</h4>
                             <ul class="social__share footer__social d-flex justify-content-center flex-wrap gap-3"
                                 style="justify-content: center !important;">
                                 <li class="social__share--list">
                                     <a class="social__share--icon__style2" target="_blank"
                                         href="https://www.facebook.com/share/17YdRAALDT/" title="Facebook">
                                         <svg width="20" height="20" viewBox="0 0 9 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path
                                                 d="M7.62891 8.625L8.01172 6.10938H5.57812V4.46875C5.57812 3.75781 5.90625 3.10156 7 3.10156H8.12109V0.941406C8.12109 0.941406 7.10938 0.75 6.15234 0.75C4.15625 0.75 2.84375 1.98047 2.84375 4.16797V6.10938H0.601562V8.625H2.84375V14.75H5.57812V8.625H7.62891Z"
                                                 fill="currentColor" />
                                         </svg>
                                         <span class="visually-hidden">Facebook</span>
                                     </a>
                                 </li>
                                 <li class="social__share--list">
                                     <a class="social__share--icon__style2" target="_blank"
                                         href="https://www.tiktok.com/@amin.aboliraa?_r=1&_t=ZS-910sl53h3Kv"
                                         title="TikTok">
                                         <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <g>
                                                 <path
                                                     d="M15.988 6.009c-1.001 0-1.888-.607-2.253-1.473V12.5c0 2.488-2.022 4.513-4.513 4.513S4.71 14.988 4.71 12.5s2.025-4.512 4.513-4.512c.086 0 .171.003.256.006V10.13a2.055 2.055 0 0 0-.256-.018c-1.245 0-2.258 1.012-2.258 2.259 0 1.245 1.013 2.258 2.258 2.258 1.246 0 2.26-1.013 2.26-2.258V2.5h2.019c.005.926.46 1.744 1.152 2.24a3.566 3.566 0 0 0 1.826.597v1.918a5.371 5.371 0 0 1-1.977-.246z"
                                                     fill="currentColor" />
                                             </g>
                                         </svg>
                                         <span class="visually-hidden">TikTok</span>
                                     </a>
                                 </li>
                                 <li class="social__share--list">
                                     <a class="social__share--icon__style2" target="_blank"
                                         href="https://www.instagram.com/amin_abolira?igsh=MW14ZGJzNmxpYjM4Zg=="
                                         title="Instagram">
                                         <svg width="20" height="20" viewBox="0 0 14 13" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path
                                                 d="M7.125 3.60547C5.375 3.60547 3.98047 5.02734 3.98047 6.75C3.98047 8.5 5.375 9.89453 7.125 9.89453C8.84766 9.89453 10.2695 8.5 10.2695 6.75C10.2695 5.02734 8.84766 3.60547 7.125 3.60547ZM7.125 8.80078C6.00391 8.80078 5.07422 7.89844 5.07422 6.75C5.07422 5.62891 5.97656 4.72656 7.125 4.72656C8.24609 4.72656 9.14844 5.62891 9.14844 6.75C9.14844 7.89844 8.24609 8.80078 7.125 8.80078ZM11.1172 3.49609C11.1172 3.08594 10.7891 2.75781 10.3789 2.75781C9.96875 2.75781 9.64062 3.08594 9.64062 3.49609C9.64062 3.90625 9.96875 4.23438 10.3789 4.23438C10.7891 4.23438 11.1172 3.90625 11.1172 3.49609ZM13.1953 4.23438C13.1406 3.25 12.9219 2.375 12.2109 1.66406C11.5 0.953125 10.625 0.734375 9.64062 0.679688C8.62891 0.625 5.59375 0.625 4.58203 0.679688C3.59766 0.734375 2.75 0.953125 2.01172 1.66406C1.30078 2.375 1.08203 3.25 1.02734 4.23438C0.972656 5.24609 0.972656 8.28125 1.02734 9.29297C1.08203 10.2773 1.30078 11.125 2.01172 11.8633C2.75 12.5742 3.59766 12.793 4.58203 12.8477C5.59375 12.9023 8.62891 12.9023 9.64062 12.8477C10.625 12.793 11.5 12.5742 12.2109 11.8633C12.9219 11.125 13.1406 10.2773 13.1953 9.29297C13.25 8.28125 13.25 5.24609 13.1953 4.23438ZM11.8828 10.3594C11.6914 10.9062 11.2539 11.3164 10.7344 11.5352C9.91406 11.8633 8 11.7812 7.125 11.7812C6.22266 11.7812 4.30859 11.8633 3.51562 11.5352C2.96875 11.3164 2.55859 10.9062 2.33984 10.3594C2.01172 9.56641 2.09375 7.65234 2.09375 6.75C2.09375 5.875 2.01172 3.96094 2.33984 3.14062C2.55859 2.62109 2.96875 2.21094 3.51562 1.99219C4.30859 1.66406 6.22266 1.74609 7.125 1.74609C8 1.74609 9.91406 1.66406 10.7344 1.99219C11.2539 2.18359 11.6641 2.62109 11.8828 3.14062C12.2109 3.96094 12.1289 5.875 12.1289 6.75C12.1289 7.65234 12.2109 9.56641 11.8828 10.3594Z"
                                                 fill="currentColor" />
                                         </svg>
                                         <span class="visually-hidden">Instagram</span>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Footer Bottom -->
         <div class="footer__bottom">
             <div class="container">
                 <div class="footer__bottom--inner d-flex justify-content-center align-items-center">
                     <p class="copyright__content text-center m-0 w-100">
                         <span class="text__secondary">
                             <script>
                                 document.write(new Date().getFullYear());
                             </script>
                         </span>
                         <a class="copyright__content--link" href="https://www.lebify.dev/">Lebify</a>
                         - {{ __('footer.all_rights_reserved') }}
                     </p>
                 </div>
             </div>
         </div>
 </footer>
 <!-- End footer section -->
