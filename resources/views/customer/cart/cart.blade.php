<x-app-layout>
    @push('custom-links')
    @endpush
    @push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        //if user is logged in merge cart
        // const guestCart = JSON.parse(localStorage.getItem('gcart')) || [];

        // if (guestCart.length > 0) {
        //     fetch('/user/cart/merge', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'X-CSRF-TOKEN': _TOKEN
        //         },
        //         body: JSON.stringify({ guestCart }),
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             // Successfully merged or transferred the cart
        //             localStorage.removeItem('gcart'); // Clear guest cart
        //             showToast("success", "Cart", "Your cart has been updated!");
        //         } else {
        //             showToast("error", "Cart", "Failed to update cart.");
        //         }
        //     })
        //     .catch(error => console.error('Error merging cart:', error));
        // }

        function displayCart(products) {
        const cart = JSON.parse(localStorage.getItem('gcart')) || [];
        const cartItemsContainer = document.getElementById('cart-items');
        const cartTotalContainer = document.getElementById('cart-total');
        let total = 0;

        // Clear previous cart items
        cartItemsContainer.innerHTML = '';

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `<div class="p-4 text-gray-500 dark:text-gray-400">Your cart is empty.</div>`;
            cartTotalContainer.value = '';
            return;
        }

        products.forEach(data => {
            // Create Flowbite card for each product
            const itemCard = document.createElement('div');
            itemCard.className = 'flex items-center p-4 border rounded-lg shadow-sm bg-white dark:bg-gray-800';
            itemCard.innerHTML = `
                <img src="/storage/${data.image}" alt="${data.name}" class="w-16 h-16 object-cover rounded mr-4" />
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-2 gap-1">
                        <div class="mr-0">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100">${data.name}</h3>
                            <p class="text-gray-600 dark:text-gray-400">Price: ₱ ${data.price}</p>
                            <p class="text-gray-600 dark:text-gray-400">Stock: ${data.quantity}</p>
                        </div>
                        <div class="text-end sm:text-start me-1">
                            <label for="quantity-${data.id}" class="text-sm text-gray-600 dark:text-gray-400 sm:mr-2">Quantity:</label>
                            <input type="number" id="quantity-${data.id}" value="1" min="1" max="${data.quantity}" class="quantity-input border rounded w-16 text-center" data-id="${data.id}" data-price="${data.price}">
                        </div>
                    </div>
                    <p class="text-red-500 hidden" id="stock-error-${data.id}">Exceeds available stock!</p>
                </div>
                <button class="sm:ms-3 text-red-500 remove-item" data-id="${data.id}"><i class="fa-solid fa-trash-can fa-lg px-6 sm:px-0"></i><span class="hidden sm:block">Remove</span></button>
            `;
            cartItemsContainer.appendChild(itemCard);

            // Add to total for initial load
            total += parseFloat(data.price);
        });

        // cartTotalContainer.innerHTML = `<h3 class="font-bold text-gray-900 dark:text-gray-100">Total: ₱ ${total.toFixed(2)}</h3>`;
        // cartTotalContainer.value = `₱ ${total.toFixed(2)}`;
        cartTotalContainer.value = `₱ ${PHP_FORMAT(total)}`;
        // Handle quantity changes and remove items
        handleQuantityChange();
        handleRemoveItem();
    }

    // Function to update total price dynamically
    function updateCartTotal() {
        let total = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            const price = parseFloat(input.getAttribute('data-price'));
            const quantity = parseInt(input.value);
            total += price * quantity;
        });

        // document.getElementById('cart-total').value = `₱ ${total.toFixed(2)}`;
        document.getElementById('cart-total').value = `₱ ${PHP_FORMAT(total)}`;
    }

    // Function to handle checkout
    function handleCheckout() {
        const cart = JSON.parse(localStorage.getItem('gcart')) || [];
        if (cart.length === 0) {
            showToast("info", "Cart", "Your cart is empty!");
            return;
        }

        // Prepare checkout data
        const products = [];
        document.querySelectorAll('.quantity-input').forEach(input => {
            products.push({
                id: input.getAttribute('data-id'),
                quantity: input.value
            });
        });

        // Send checkout data to server
        fetch('/u/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': _TOKEN
            },
            body: JSON.stringify({ products: products }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.removeItem('gcart'); // Clear cart after successful checkout
                fetchCartProductsAndDisplay();    // Refresh cart display
                showToast("success", "Checkout", "Order placed successfully!");
            } else {
                showToast("error", "Checkout", data.message || "Checkout failed. Please try again.");
            }
        })
        .catch(error => {
            console.error('Checkout error:', error);
            showToast("error", "Checkout", "Failed to process the checkout. Please try again.");
        });
    }

    // Attach checkout event listener
    document.getElementById('checkout-btn').addEventListener('click', handleCheckout);

    // Function to handle quantity changes
    function handleQuantityChange() {
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function () {
                const id = this.getAttribute('data-id');
                const quantity = parseInt(this.value);
                const maxStock = parseInt(this.getAttribute('max'));

                if (quantity > maxStock) {
                    document.getElementById(`stock-error-${id}`).classList.remove('hidden');
                    this.value = maxStock;
                    return;
                } else {
                    document.getElementById(`stock-error-${id}`).classList.add('hidden');
                }

                updateCartTotal(); // Update total whenever quantity changes
            });
        });
    }

    // Function to handle item removal
    function handleRemoveItem() {
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function () {
                const idToRemove = this.getAttribute('data-id');
                if (confirm("Are you sure you want to remove this item?"))
                    removeFromCart(idToRemove);
            });
        });
    }

    // Remove item from the cart and update display
    function removeFromCart(productId) {
        let cart = JSON.parse(localStorage.getItem('gcart')) || [];
        cart = cart.filter(itemId => itemId != productId); // Remove the product from the cart array

        // Update localStorage
        localStorage.setItem('gcart', JSON.stringify(cart));

        // Re-fetch and display updated cart
        fetchCartProductsAndDisplay();
    }

    // Fetch and display cart products
    function fetchCartProductsAndDisplay() {
        const cart = JSON.parse(localStorage.getItem('gcart')) || [];
        if (cart.length > 0) {
            fetch('/u/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': _TOKEN
                },
                body: JSON.stringify({ productIDs: cart }),
            })
            .then(response => response.json())
            .then(data => {
                displayCart(data.products);
            })
            .catch(error => {
                console.error('Error fetching cart data:', error);
                showToast("error", "Cart", "Failed to load cart products. Please try again.");
            });
        } else {
            document.getElementById('cart-items').innerHTML = '';
            document.getElementById('cart-total').innerHTML = '';
            showToast("info", "Cart", "Your cart is empty!");
        }
    }

    // Initial display of cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetchCartProductsAndDisplay();
    });


    </script>
    @endpush
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>


    <div class="pt-8 pb-10 h-[95vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full">
                
                <div id="cart" class="max-w-5xl mx-auto mt-6 flex flex-col h-full p-1 sm:p-4">
                    <h2 class="mb-2 text-center sm:text-start text-xl font-bold text-gray-900 dark:text-gray-100">Your Cart</h2>
                    <hr class="h-1 mb-3 bg-blue-700 border-0 dark:bg-blue-500">
    
                    <!-- Make this div scrollable if the items overflow -->
                    <div id="cart-items" class="space-y-4 overflow-y-auto flex-1 max-h-[65vh] custom-scrollbar"></div>
                
                    <!-- Total and checkout button should stay at the bottom -->
                    <hr class="h-1 mt-5 bg-blue-700 border-0 dark:bg-blue-500">
                    <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between py-4">
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            GRAND TOTAL
                            </span>
                            <input type="text" id="cart-total" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-end text-lg border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly/>
                        </div>
                        <button id="checkout-btn" class="mt-4 mb-6 sm:mb-0 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Proceed to Checkout</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</x-app-layout>
