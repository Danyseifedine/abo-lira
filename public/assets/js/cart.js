const cartData = {
    csrfToken: '{{ csrf_token() }}',
};

const updateCartItem = (itemId, item, subtotal) => {
    // Update quantity input
    const inputCartQuantities = document.querySelectorAll('#input-cart-quantity');
    if (inputCartQuantities.length > 0) {
        inputCartQuantities.forEach((input) => {
            if (input.getAttribute('data-item-id') === itemId) {
                input.value = item.quantity;
            }
        });
    }

    // Update total for this item
    const cartItemTotals = document.querySelectorAll('#cart-item-total');
    if (cartItemTotals.length > 0) {
        cartItemTotals.forEach((total) => {
            if (total.getAttribute('data-item-id') === itemId) {
                total.textContent = item.total + '$';
            }
        });
    }

    // Update subtotal
    const cartSubtotal = document.getElementById('cart-subtotal');
    if (cartSubtotal !== null) {
        cartSubtotal.textContent = subtotal + '$';
    }

    const minicartSubtotal = document.getElementById('mini-cart-subtotal');
    if (minicartSubtotal !== null) {
        minicartSubtotal.textContent = subtotal + '$';
    }
};

handleAfterRemoveCartItem = (itemId, data) => {
    // Remove item from cart
    const cartItems = document.querySelectorAll('#parent-cart-item');
    if (cartItems.length > 0) {
        cartItems.forEach((item) => {
            if (item.getAttribute('data-item-id') === itemId) {
                item.remove();
            }
        });
    }

    // Update subtotal
    const cartSubtotal = document.getElementById('cart-subtotal');
    if (cartSubtotal !== null) {
        cartSubtotal.textContent = data.subtotal + '$';
    }

    const minicartSubtotal = document.getElementById('mini-cart-subtotal');
    if (minicartSubtotal !== null) {
        minicartSubtotal.textContent = data.subtotal + '$';
    }

    if (data.items_count === 0) {
        const cartEmpty = document.getElementById('cart-empty-container');
        if (cartEmpty !== null) {
            cartEmpty.style.display = 'block';
        }

        const minicartEmpty = document.getElementById('minicart-empty-container');
        if (minicartEmpty !== null) {
            minicartEmpty.style.display = 'block';
        }

        const mincartCheckoutBn = document.getElementById('mincart-checkout-btn');
        if (mincartCheckoutBn !== null) {
            mincartCheckoutBn.style.opacity = '0.5';
            mincartCheckoutBn.style.cursor = 'not-allowed';
            mincartCheckoutBn.style.pointerEvents = 'none';
        }
    }
};

handleInputLoading = (itemId, isLoading) => {
    const inputCartQuantities = document.querySelectorAll('#input-cart-quantity');
    inputCartQuantities.forEach((input) => {
        if (input.getAttribute('data-item-id') === itemId) {
            input.style.display = isLoading ? 'none' : 'block';
        }
    });

    const cartQuantityLoading = document.querySelectorAll('#cart-quantity-loading');
    cartQuantityLoading.forEach((loadingElement) => {
        if (loadingElement.getAttribute('data-item-id') === itemId) {
            loadingElement.style.display = isLoading ? 'block' : 'none';
        }
    });
};

handleRemoveLoading = (itemId, isLoading) => {
    const cartRemoveIcons = document.querySelectorAll('#cart-remove-icon');
    cartRemoveIcons.forEach((iconElement) => {
        if (iconElement.getAttribute('data-item-id') === itemId) {
            iconElement.style.display = isLoading ? 'none' : 'block';
        }
    });

    const cartRemoveLoadings = document.querySelectorAll('#cart-remove-loading');
    cartRemoveLoadings.forEach((loadingElement) => {
        if (loadingElement.getAttribute('data-item-id') === itemId) {
            loadingElement.style.display = isLoading ? 'block' : 'none';
        }
    });
};

handleDisabledOnFetch = (isDisabled) => {
    const elements = document.querySelectorAll('.disabled-on-fetch');
    elements.forEach((element) => {
        element.style.pointerEvents = isDisabled ? 'none' : 'auto';
        element.style.opacity = isDisabled ? '0.5' : '1';
        element.style.cursor = isDisabled ? 'not-allowed' : 'pointer';
    });
};

const alertNotification = (type, message) => {
    Swal.fire({
        position: "top-end",
        icon: type,
        text: message,
        showConfirmButton: false,
        timer: 1000
    });
};

const updateQuantity = (itemId, action, number = 1) => {
    handleInputLoading(itemId, true);
    handleDisabledOnFetch(true);

    fetch('/cart/change-quantity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || cartData.csrfToken,
            Accept: 'application/json',
        },
        body: JSON.stringify({
            itemId,
            action,
            number,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alertNotification('success', data.message);

                updateCartItem(itemId, data.data.item, data.data.subtotal);
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        })
        .finally(() => {
            handleInputLoading(itemId, false);
            handleDisabledOnFetch(false);
        });
};

const removeCartItem = (itemId) => {
    handleRemoveLoading(itemId, true);
    handleDisabledOnFetch(true);

    fetch(`/cart/remove/${itemId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || cartData.csrfToken,
            Accept: 'application/json',
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alertNotification('success', data.message);

                handleAfterRemoveCartItem(itemId, data.data);
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        })
        .finally(() => {
            handleRemoveLoading(itemId, false);
            handleDisabledOnFetch(false);
        });
};

const fetchMiniCartItems = () => {
    const minicartLoading = document.getElementById('minicart-loading');
    if (minicartLoading !== null) {
        minicartLoading.style.display = 'flex';
    }

    fetch('/cart', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || cartData.csrfToken,
            Accept: 'application/json',
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const minicartContainer = document.getElementById('minicart-container');
                if (minicartContainer !== null) {
                    minicartContainer.innerHTML = '';
                    minicartContainer.innerHTML = data.html;
                }

                const minicartSubtotal = document.getElementById('mini-cart-subtotal');
                if (minicartSubtotal !== null) {
                    minicartSubtotal.innerHTML = '';
                    minicartSubtotal.innerHTML = data.subtotal + '$';
                }

                handleDom();
            }
        })
        .catch((error) => {
            console.error('Error fetching mini cart items:', error);
        })
        .finally(() => {
            const minicartLoading = document.getElementById('minicart-loading');
            if (minicartLoading !== null) {
                minicartLoading.style.display = 'none';
            }
        });
};

const handleDom = () => {
    // Quantity
    const cartIncreaseQuantities = document.querySelectorAll('#cart-increase-quantity');
    const cartDecreaseQuantities = document.querySelectorAll('#cart-decrease-quantity');

    // Remove
    const cartRemoveBtns = document.querySelectorAll('#cart-remove-btn');

    // Minicart open btn
    const minicartOpenBtn = document.querySelectorAll('#minicart-open-btn');

    // Add event listeners to quantity buttons
    cartIncreaseQuantities.forEach((button) => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');

            updateQuantity(itemId, 'increase');
        });
    });
    cartDecreaseQuantities.forEach((button) => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');

            updateQuantity(itemId, 'decrease');
        });
    });

    // Add event listeners to remove buttons
    cartRemoveBtns.forEach((button) => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');

            removeCartItem(itemId);
        });
    });

    // Add event listeners to get cart items to minicart
    minicartOpenBtn.forEach((button) => {
        button.addEventListener('click', function () {
            fetchMiniCartItems();
        });
    });
};

document.addEventListener('DOMContentLoaded', function () {
    handleDom();
});
