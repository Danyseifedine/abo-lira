   <style>
       .txt-loading {
           position: relative;
           display: inline-flex;
           align-items: center;
           justify-content: center;
       }

       .spinner-wrapper {
           position: relative;
           display: inline-flex;
           align-items: center;
           justify-content: center;
       }

       .spinner-ring {
           position: absolute;
           width: 140px;
           height: 140px;
           border: 3px solid transparent;
           border-top-color: #dc2626;
           border-right-color: #ef4444;
           border-radius: 50%;
           animation: spin 1s linear infinite;
       }

       .spinner-ring-2 {
           position: absolute;
           width: 120px;
           height: 120px;
           border: 2px solid transparent;
           border-bottom-color: #f87171;
           border-left-color: #dc2626;
           border-radius: 50%;
           animation: spin 1.5s linear infinite reverse;
       }

       .spinner-ring-3 {
           position: absolute;
           width: 160px;
           height: 160px;
           border: 2px solid transparent;
           border-top-color: #fca5a5;
           border-radius: 50%;
           animation: spin 2s linear infinite;
       }

       @keyframes spin {
           0% {
               transform: rotate(0deg);
           }

           100% {
               transform: rotate(360deg);
           }
       }

       .txt-loading img {
           position: relative;
           z-index: 10;
           animation: pulse 2s ease-in-out infinite;
       }

       @keyframes pulse {

           0%,
           100% {
               transform: scale(1);
           }

           50% {
               transform: scale(1.05);
           }
       }
   </style>

   <!-- Start preloader -->
   <div id="preloader">
       <div id="ctn-preloader" class="ctn-preloader">
           <div class="animation-preloader">
               <div class="txt-loading">
                   <div class="spinner-wrapper">
                       <div class="spinner-ring-3"></div>
                       <div class="spinner-ring"></div>
                       <div class="spinner-ring-2"></div>
                       <img src="{{ asset('logos/logo.png') }}" alt="Logo" width="100">
                   </div>
               </div>
           </div>
           <div class="loader-section section-left"></div>
           <div class="loader-section section-right"></div>
       </div>
   </div>
   <!-- End preloader -->
