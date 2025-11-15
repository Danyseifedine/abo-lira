@extends('layout.master')

@section('content')

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title mb-25">{{ __('track_order.title') }}</h1>
                        <nav aria-label="breadcrumb">
                            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
                                <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link" style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">{{ __('track_order.home') }}</a>
                                <span style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;" aria-current="page">{{ __('track_order.track_order') }}</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start track order section -->
    <section class="track__order--section section--padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    @if($order)
                    <div class="alert alert-success alert-dismissible fade show mb-15" role="alert">
                        {!! __('track_order.order_placed_success', ['order_number' => '<span class="fw-bold">' . $order->order_number . '</span>']) !!}
                    </div>
                    @endif

                    <div class="track__order--wrapper border-radius-10 p-4" style="background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <!-- Track Order Form -->
                        <div id="track-order-form" class="track__order--form mb-4">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <label class="checkout__input--label mb-1" for="order_number">{{ __('track_order.order_number') }} <span class="checkout__input--label__star">*</span></label>
                                </div>
                                <div class="col-12 d-flex flex-column flex-md-row align-items-center mb-1 position-relative">
                                    <input class="checkout__input--field border-radius-5" name="order_number" placeholder="{{ __('track_order.order_number_placeholder') }}"
                                        id="order_number_input" type="text" value="{{ old('order_number', $order->order_number ?? '') }}" required style="width: 100% !important;">
                                    <button
                                        class="track-btn"
                                        id="track-btn"
                                        type="button"
                                        form="track-order-form">
                                        <span id="track-btn-text">{{ __('track_order.track') }}</span>
                                        <span id="track-btn-loading" style="display: none; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                                                <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" stroke-opacity="0.75"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                <div class="col-12">
                                    <div id="order_number_error" class="text-danger mt-2" style="display: none; font-size: 0.875rem;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div id="error-message" class="alert alert-danger" style="display: none; border-radius: 8px; padding: 15px 20px; margin-bottom: 20px;">
                            <strong>{{ __('track_order.error_occurred') }}</strong>
                            <span id="error-text"></span>
                        </div>

                        <div id="empty-order-details" style="display: {{ $order ? 'none' : 'block' }};">
                            <div class="order__details--card border-radius-10 p-4" style="background: #f8f9fa; border: 1px solid #dc3545;">
                                <h3 class="order__details--title text-center mb-4" style="font-size: 1.5rem; font-weight: 700; text-transform: uppercase;">
                                    {{ __('track_order.order_details') }}
                                </h3>
                                <div class="order__details--content py-5 d-flex align-items-center justify-content-center">
                                    <span id="no-order-details-text" style="display: none; font-size: 1.25rem; font-weight: 400; color: #2c3e50;">
                                        {{ __('track_order.no_order_details_found') }}
                                    </span>
                                    <span id="put-order-details-text" style="font-size: 1.25rem; font-weight: 400; color: #2c3e50;">
                                        {{ __('track_order.put_your_order_first') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Histories -->
                        <div id="order-histories" class="mb-5"
                            data-title="{{ __('track_order.order_history') }}"
                            style="display: {{ $order ? 'block' : 'none' }};">
                            <div class="order__history--card border-radius-10 p-4 mb-4" style="background: #f8f9fa; border: 1px solid #dc3545;">
                                <h3 class="order__history--title text-center mb-4" style="font-size: 1.5rem; font-weight: 700; text-transform: uppercase;">
                                    {{ __('track_order.order_history') }}
                                </h3>
                                <div class="d-flex gap-3 flex-wrap">
                                    @if($orderHistories && $orderHistories->count() > 0)
                                    @foreach($orderHistories as $index => $orderHistory)
                                    <div class="d-flex align-items-center gap-3 px-3 py-1 shadow-sm" style="background-color: #fff; width: fit-content; box-shadow: 0 5px 12px rgba(0,0,0,0.1); border-radius: 5px;">
                                        <div class="d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; border-radius: 50%; background-color: #dc3545; color: #fff;">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold {{ $orderHistory->status_raw }}-status-text" style="font-size: 1.4rem;">{{ $orderHistory->status_formatted }}</span>
                                            <span style="font-size: 1rem; direction: ltr;">{{ $orderHistory->created_at_formatted }} - {{ $orderHistory->created_at_time }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div id="order-details" style="display: {{ $order ? 'block' : 'none' }};">
                            <div class="order__details--card border-radius-10 p-4" style="background: #f8f9fa; border: 1px solid #dc3545;">
                                <h3 class="order__details--title text-center mb-4" style="font-size: 1.5rem; font-weight: 700; text-transform: uppercase;">
                                    {{ __('track_order.order_details') }}
                                </h3>
                                <div class="order__details--content">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="order__detail--item p-3 border-radius-5">
                                                <label class="order__detail--label d-block" style="font-size: 1rem; color: #666; font-weight: 600;">
                                                    {{ __('track_order.order_number_label') }}
                                                </label>
                                                <div class="order__detail--value px-3 py-2" id="display-order-number"
                                                    style="font-size: 1.25rem; font-weight: 700; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    {{ $order ? $order->order_number : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order__detail--item p-3 border-radius-5">
                                                <label class="order__detail--label d-block" style="font-size: 1rem; color: #666; font-weight: 600;">
                                                    {{ __('track_order.order_status') }}
                                                </label>
                                                <div class="order__detail--value px-3 py-2 {{ $order ? $order->status_raw . '-status-class' : '' }}"
                                                    id="display-order-status"
                                                    style="font-size: 1.25rem; font-weight: 700; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    {{ $order ? $order->status_formatted : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order__detail--item p-3 border-radius-5">
                                                <label class="order__detail--label d-block" style="font-size: 1rem; color: #666; font-weight: 600;">
                                                    {{ __('track_order.first_name') }}
                                                </label>
                                                <div class="order__detail--value px-3 py-2" id="display-order-f-name"
                                                    style="font-size: 1.25rem; font-weight: 700; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    {{ $order ? $order->f_name : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order__detail--item p-3 border-radius-5">
                                                <label class="order__detail--label d-block" style="font-size: 1rem; color: #666; font-weight: 600;">
                                                    {{ __('track_order.last_name') }}
                                                </label>
                                                <div class="order__detail--value px-3 py-2" id="display-order-l-name"
                                                    style="font-size: 1.25rem; font-weight: 700; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    {{ $order ? $order->l_name : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order__detail--item p-3 border-radius-5">
                                                <label class="order__detail--label d-block" style="font-size: 1rem; color: #666; font-weight: 600;">
                                                    {{ __('track_order.phone_number') }}
                                                </label>
                                                <a href="tel:+961{{ $order ? $order->phone_number : '' }}" class="order__detail--value px-3 py-2" id="display-order-phone-number"
                                                    style="width: 100%; direction: ltr; font-size: 1.25rem; font-weight: 700; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    +961{{ $order ? $order->phone_number : '' }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order__detail--item p-3 border-radius-5">
                                                <label class="order__detail--label d-block" style="font-size: 1rem; color: #666; font-weight: 600;">
                                                    {{ __('track_order.total_amount') }}
                                                </label>
                                                <div class="order__detail--value px-3 py-2" id="display-order-total-amount"
                                                    style="color:#dc3545; font-size: 1.25rem; font-weight: 700; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    {{ $order ? $order->total_amount . '$' : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="order__detail--item p-3 border-radius-5">
                                                <label class="order__detail--label d-block" style="font-size: 1rem; color: #666; font-weight: 600;">
                                                    {{ __('track_order.address') }}
                                                </label>
                                                <div class="order__detail--value px-3 py-2" id="display-order-address"
                                                    style="font-size: 1.25rem; font-weight: 700; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    {{ $order ? $order->address . ', ' . $order->city : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <span id="display-order-date" style="font-size: 1.25rem; font-weight: 400; color: #2c3e50;">
                                                {{ $order ? $order->created_at_formatted : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End track order section -->

</main>

@push('scripts')
<script>
    const handleTrackLoading = (isLoading) => {
        const trackBtnText = document.getElementById('track-btn-text');
        if (trackBtnText !== null) {
            trackBtnText.style.display = isLoading ? 'none' : 'block';
        }

        const trackBtnLoading = document.getElementById('track-btn-loading');
        if (trackBtnLoading !== null) {
            trackBtnLoading.style.display = isLoading ? 'block' : 'none';
        }
    }

    const handleOrderStatusColor = (status) => {
        switch (status) {
            case 'pending':
                return 'pending-status-class';
            case 'accepted':
                return 'accepted-status-class';
            case 'on_the_way':
                return 'on_the_way-status-class';
            case 'completed':
                return 'completed-status-class';
            case 'refunded':
                return 'refunded-status-class';
            case 'rejected':
                return 'rejected-status-class';
            default:
                return 'pending-status-class';
        }
    }

    const getStatusIcon = (status) => {
        const icons = {
            'pending': 'fa-clock',
            'accepted': 'fa-check-circle',
            'on_the_way': 'fa-truck',
            'completed': 'fa-check-double',
            'rejected': 'fa-times-circle',
            'refunded': 'fa-undo'
        };
        return icons[status] || 'fa-circle';
    }

    const handleOrderHistories = (orderHistories) => {
        const orderHistoriesContainer = document.getElementById('order-histories');
        if (!orderHistoriesContainer) {
            return;
        }

        if (!orderHistories || orderHistories.length === 0) {
            orderHistoriesContainer.style.display = 'none';
            return;
        }

        const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.getAttribute('lang') === 'ar';
        const timelineHTML = orderHistories.map((history, index) => {
            const isLast = index === orderHistories.length - 1;
            const iconClass = getStatusIcon(history.status);
            const dirAttr = isRTL ? 'dir="rtl"' : '';

            const lowerCaseStatus = history.status_raw.toLowerCase();

            return `
                <div class="d-flex align-items-center gap-3 px-3 py-1 shadow-sm" style="background-color: #fff; width: fit-content; box-shadow: 0 5px 12px rgba(0,0,0,0.1); border-radius: 5px;">
                    <div class="d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; border-radius: 50%; background-color: #dc3545; color: #fff;">
                        ${index + 1}
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-bold ${lowerCaseStatus}-status-text" style="font-size: 1.4rem;">${history.status_formatted}</span>
                        <span class="" style="font-size: 1rem; direction: ltr;">${history.created_at_formatted} - ${history.created_at_time}</span>
                    </div>
                </div>
            `;
        }).join('');

        const orderHistoryTitle = orderHistoriesContainer.getAttribute('data-title') || 'Order History';
        const timelineWrapper = `
            <div class="order__history--card border-radius-10 p-4 mb-4" style="background: #f8f9fa; border: 1px solid #dc3545;">
                <h3 class="order__history--title text-center mb-4" style="font-size: 1.5rem; font-weight: 700; text-transform: uppercase;">
                    ${orderHistoryTitle}
                </h3>
                <div class="d-flex flex-wrap gap-3">
                    ${timelineHTML}
                </div>
            </div>
        `;

        orderHistoriesContainer.innerHTML = timelineWrapper;
        orderHistoriesContainer.style.display = 'block';
    }

    const handleOrderDetailsData = (order) => {
        const orderNumberElement = document.getElementById('display-order-number');
        const orderStatusElement = document.getElementById('display-order-status');
        const orderDateElement = document.getElementById('display-order-date');
        const orderFNameElement = document.getElementById('display-order-f-name');
        const orderLNameElement = document.getElementById('display-order-l-name');
        const orderPhoneNumberElement = document.getElementById('display-order-phone-number');
        const orderTotalAmountElement = document.getElementById('display-order-total-amount');
        const orderAddressElement = document.getElementById('display-order-address');

        if (orderNumberElement !== null) {
            orderNumberElement.textContent = order.order_number;
        }
        if (orderStatusElement !== null) {
            orderStatusElement.textContent = order.status_formatted;
            orderStatusElement.classList.add(handleOrderStatusColor(order.status));
        }
        if (orderDateElement !== null) {
            orderDateElement.textContent = order.created_at_formatted;
        }
        if (orderFNameElement !== null) {
            orderFNameElement.textContent = order.f_name;
        }
        if (orderLNameElement !== null) {
            orderLNameElement.textContent = order.l_name;
        }
        if (orderPhoneNumberElement !== null) {
            orderPhoneNumberElement.href = 'tel:+961' + order.phone_number;
            orderPhoneNumberElement.textContent = '+961' + order.phone_number;
        }
        if (orderTotalAmountElement !== null) {
            orderTotalAmountElement.textContent = order.total_amount + '$';
        }
        if (orderAddressElement !== null) {
            orderAddressElement.textContent = order.address + ', ' + order.city;
        }
    }

    const fetchOrder = (orderNumber) => {
        handleTrackLoading(true);

        const currentPath = window.location.pathname;
        const localePrefix = currentPath.split('/')[1];
        const isLocalized = ['ar', 'en'].includes(localePrefix);
        const apiUrl = isLocalized ? `/${localePrefix}/get-order` : '/get-order';

        fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    Accept: 'application/json',
                },
                body: JSON.stringify({
                    order_number: orderNumber,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                const orderDetails = document.getElementById('order-details');
                const emptyOrderDetails = document.getElementById('empty-order-details');
                const putOrderDetailsText = document.getElementById('put-order-details-text');
                const noOrderDetailsText = document.getElementById('no-order-details-text');

                if (data.success) {

                    handleOrderDetailsData(data.order);
                    handleOrderHistories(data.orderHistories);

                    console.log(data);


                    if (orderDetails !== null) {
                        orderDetails.style.display = 'block';
                    }
                    if (emptyOrderDetails !== null) {
                        emptyOrderDetails.style.display = 'none';
                    }
                } else {
                    if (putOrderDetailsText !== null) {
                        putOrderDetailsText.style.display = 'none';
                    }
                    if (noOrderDetailsText !== null) {
                        noOrderDetailsText.style.display = 'block';
                    }
                    if (emptyOrderDetails !== null) {
                        emptyOrderDetails.style.display = 'block';
                    }
                    if (orderDetails !== null) {
                        orderDetails.style.display = 'none';
                    }

                    console.error('Error:', data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            })
            .finally(() => {
                handleTrackLoading(false);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const trackBtn = document.getElementById('track-btn');
        const orderNumberInput = document.getElementById('order_number_input');

        trackBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const orderNumber = orderNumberInput.value;
            if (orderNumber.trim() === '') {
                return;
            }

            fetchOrder(orderNumber);
        });
    });
</script>
@endpush

@push('styles')
<style>
    .track-btn {
        position: absolute;
        top: 3.5px;
        right: 20px;
        font-weight: 600;
        display: inline-block;
        font-size: 1.4rem;
        line-height: 3.8rem;
        height: 3.7rem;
        padding: 0 3rem;
        border-radius: 2.4rem !important;
        background: var(--secondary-color);
        color: var(--text-white-color);
        border: 0;
    }

    [dir="rtl"] .track-btn {
        right: auto;
        left: 20px;
    }

    @media (max-width: 500px) {
        .track-btn {
            position: relative;
            top: 5px;
            right: 0;
            width: 100%;
        }

        [dir="rtl"] .track-btn {
            left: 0;
            right: auto;
        }
    }

    .pending-status-class {
        color: #ffc107;
    }

    .accepted-status-class {
        color: #17a2b8;
    }

    .on_the_way-status-class {
        color: #6f42c1;
    }

    .completed-status-class {
        color: #28a745;
    }

    .rejected-status-class {
        color: #ff0000;
    }

    .refunded-status-class {
        color: #dc3545;
    }

    /* Timeline Styles */
    .order__timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        margin-bottom: 0;
    }

    .timeline-item-last {
        margin-bottom: 0;
    }

    .timeline-icon-wrapper {
        position: relative;
        width: 50px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .timeline-icon {
        width: 50px;
        height: 50px;
        background: #fff;
        border: 3px solid #e0e0e0;
        color: #666;
        font-size: 20px;
        z-index: 2;
        position: relative;
        transition: all 0.3s ease;
    }

    .timeline-line {
        width: 3px;
        height: calc(100% - 10px);
        background: linear-gradient(to bottom, #dc3545, #e0e0e0);
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
    }

    [dir="rtl"] .timeline-line {
        left: auto;
        right: 50%;
        transform: translateX(50%);
    }

    .timeline-item-last .timeline-line {
        display: none;
    }

    .timeline-content {
        min-height: 80px;
    }

    .timeline-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .timeline-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    /* Status Icon Colors */
    .pending-status-icon {
        border-color: #ffc107 !important;
        color: #ffc107 !important;
        background: #fffbf0 !important;
    }

    .accepted-status-icon {
        border-color: #17a2b8 !important;
        color: #17a2b8 !important;
        background: #e8f4f8 !important;
    }

    .on_the_way-status-icon {
        border-color: #6f42c1 !important;
        color: #6f42c1 !important;
        background: #f3f0f9 !important;
    }

    .completed-status-icon {
        border-color: #28a745 !important;
        color: #28a745 !important;
        background: #e8f5e9 !important;
    }

    .rejected-status-icon {
        border-color: #ff0000 !important;
        color: #ff0000 !important;
        background: #ffe8e8 !important;
    }

    .refunded-status-icon {
        border-color: #dc3545 !important;
        color: #dc3545 !important;
        background: #ffe8e8 !important;
    }

    /* Status Text Colors */
    .pending-status-text {
        color: #ffc107;
    }

    .accepted-status-text {
        color: #17a2b8;
    }

    .on_the_way-status-text {
        color: #6f42c1;
    }

    .completed-status-text {
        color: #28a745;
    }

    .rejected-status-text {
        color: #ff0000;
    }

    .refunded-status-text {
        color: #dc3545;
    }

    /* RTL Support */
    [dir="rtl"] .timeline-content {
        text-align: right;
    }

    [dir="rtl"] .timeline-date {
        flex-direction: row-reverse;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .timeline-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .timeline-icon-wrapper {
            width: 40px;
        }

        .timeline-line {
            top: 40px;
        }

        .timeline-content {
            min-height: 70px;
        }

        .timeline-card {
            padding: 12px !important;
        }

        .timeline-status {
            font-size: 1rem !important;
        }

        .timeline-date {
            font-size: 0.85rem !important;
        }
    }
</style>
@endpush

@endsection