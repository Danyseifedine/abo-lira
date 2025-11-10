// Get cart data from hidden div
function getCartData() {
    const cartData = document.getElementById('cart-data');
    if (!cartData) {
        return {
            errorOccurred: 'An error occurred',
            errorUpdatingQuantity: 'Error updating quantity',
            errorRemovingItem: 'Error removing item',
            removeConfirm: 'Are you sure you want to remove this item?',
            emptyCart: 'Your cart is empty',
            continueShopping: 'Continue Shopping',
            changeQuantityUrl: '/cart/change-quantity',
            removeUrl: '/cart/remove',
            shopUrl: '/shop',
            csrfToken: ''
        };
    }
    return {
        errorOccurred: cartData.getAttribute('data-error-occurred') || 'An error occurred',
        errorUpdatingQuantity: cartData.getAttribute('data-error-updating-quantity') || 'Error updating quantity',
        errorRemovingItem: cartData.getAttribute('data-error-removing-item') || 'Error removing item',
        removeConfirm: cartData.getAttribute('data-remove-confirm') || 'Are you sure you want to remove this item?',
        emptyCart: cartData.getAttribute('data-empty-cart') || 'Your cart is empty',
        continueShopping: cartData.getAttribute('data-continue-shopping') || 'Continue Shopping',
        changeQuantityUrl: cartData.getAttribute('data-change-quantity-url') || '/cart/change-quantity',
        removeUrl: cartData.getAttribute('data-remove-url') || '/cart/remove',
        shopUrl: cartData.getAttribute('data-shop-url') || '/shop',
        csrfToken: cartData.getAttribute('data-csrf-token') || ''
    };
}

function disableAllCartButtons() {
    // Disable all quantity buttons
    document.querySelectorAll('.quantity__value').forEach(btn => btn.disabled = true);

    // Disable all remove buttons
    document.querySelectorAll('.remove-cart-item').forEach(btn => btn.disabled = true);

    // Disable checkout and update buttons
    const checkoutBtn = document.getElementById('checkout-btn');
    const updateBtn = document.getElementById('update-cart-btn');
    if (checkoutBtn) checkoutBtn.style.pointerEvents = 'none';
    if (updateBtn) updateBtn.disabled = true;
}

function enableAllCartButtons() {
    // Enable all quantity buttons
    document.querySelectorAll('.quantity__value').forEach(btn => btn.disabled = false);

    // Enable all remove buttons
    document.querySelectorAll('.remove-cart-item').forEach(btn => btn.disabled = false);

    // Enable checkout and update buttons
    const checkoutBtn = document.getElementById('checkout-btn');
    const updateBtn = document.getElementById('update-cart-btn');
    if (checkoutBtn) checkoutBtn.style.pointerEvents = 'auto';
    if (updateBtn) updateBtn.disabled = false;
}

function changeQuantity(itemId, action, number = 1) {
    // Disable all cart buttons
    disableAllCartButtons();

    // Get specific elements for this item
    const decreaseBtn = document.querySelector(`.decrease[data-item-id="${itemId}"]`);
    const increaseBtn = document.querySelector(`.increase[data-item-id="${itemId}"]`);
    const quantityInput = document.querySelector(`.quantity__number[data-item-id="${itemId}"]`);
    const totalElement = document.querySelector(`.cart-item-total[data-item-id="${itemId}"]`);
    const loadingIcon = document.querySelector(`.quantity__loading[data-item-id="${itemId}"]`);

    // Show loading for this specific item
    if (quantityInput) quantityInput.style.opacity = '0';
    if (loadingIcon) loadingIcon.style.display = 'block';

    const cartData = getCartData();
    
    fetch(cartData.changeQuantityUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || cartData.csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                itemId,
                action,
                number
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update quantity input
                if (quantityInput) {
                    quantityInput.value = data.data.item.quantity;
                }

                // Update total for this item
                if (totalElement) {
                    totalElement.textContent = data.data.item.total + '$';
                }

                // Update subtotal
                const subtotalElement = document.getElementById('cart-subtotal');
                if (subtotalElement) {
                    subtotalElement.textContent = data.data.subtotal + '$';
                }
            } else {
                alert(data.message || cartData.errorOccurred);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(cartData.errorUpdatingQuantity);
        })
        .finally(() => {
            // Re-enable all buttons and hide loading
            enableAllCartButtons();
            if (quantityInput) quantityInput.style.opacity = '1';
            if (loadingIcon) loadingIcon.style.display = 'none';
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const cartData = getCartData();
    
    // Add CSRF token to meta tag if not exists
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = cartData.csrfToken;
        document.getElementsByTagName('head')[0].appendChild(meta);
    }

    // Increase button handlers
    document.querySelectorAll('.quantity__value.increase').forEach(function(button) {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            if (itemId) {
                changeQuantity(itemId, 'increase', 1);
            }
        });
    });

    // Decrease button handlers
    document.querySelectorAll('.quantity__value.decrease').forEach(function(button) {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            if (itemId) {
                changeQuantity(itemId, 'decrease', 1);
            }
        });
    });

    // Remove item button handlers
    document.querySelectorAll('.remove-cart-item').forEach(function(button) {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            if (itemId) {
                removeCartItem(itemId);
            }
        });
    });
});

function removeCartItem(itemId) {
    const cartData = getCartData();
    
    // Confirm removal
    if (!confirm(cartData.removeConfirm)) {
        return;
    }

    // Disable all cart buttons
    disableAllCartButtons();

    // Get the row element to remove
    const removeBtn = document.querySelector(`.remove-cart-item[data-item-id="${itemId}"]`);
    const cartRow = removeBtn?.closest('tr');
    const removeIcon = removeBtn?.querySelector('.remove-icon');
    const removeLoading = document.querySelector(`.remove-loading[data-item-id="${itemId}"]`);

    // Hide X icon and show loading spinner
    if (removeIcon) removeIcon.style.display = 'none';
    if (removeLoading) removeLoading.style.display = 'block';

    fetch(`${cartData.removeUrl}/${itemId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || cartData.csrfToken,
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from table with fade out animation
                if (cartRow) {
                    cartRow.style.transition = 'opacity 0.3s ease-out';
                    cartRow.style.opacity = '0';
                    setTimeout(() => {
                        cartRow.remove();

                        // Check if cart is empty
                        const tbody = document.querySelector('.cart__table--body');
                        const remainingRows = tbody.querySelectorAll('tr.cart__table--body__items');

                        if (remainingRows.length === 0) {
                            // Show empty cart message
                            tbody.innerHTML = `
                                <tr class="cart__table--body__items">
                                    <td colspan="4" class="text-center py-5">
                                        <p class="mb-0">${cartData.emptyCart}</p>
                                        <a href="${cartData.shopUrl}" class="primary__btn mt-3">${cartData.continueShopping}</a>
                                    </td>
                                </tr>
                            `;
                        }
                    }, 300);
                }

                // Update subtotal
                const subtotalElement = document.getElementById('cart-subtotal');
                if (subtotalElement) {
                    subtotalElement.textContent = data.data.subtotal + '$';
                }
            } else {
                alert(data.message || cartData.errorOccurred);
                enableAllCartButtons();
                // Restore remove button icon
                if (removeIcon) removeIcon.style.display = 'block';
                if (removeLoading) removeLoading.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(cartData.errorRemovingItem);
            enableAllCartButtons();
            // Restore remove button icon
            if (removeIcon) removeIcon.style.display = 'block';
            if (removeLoading) removeLoading.style.display = 'none';
        });
}