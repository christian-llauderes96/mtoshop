<x-app-layout>
    @push('custom-links')
    <style>
        #toast-container {
            top: 70px; 
        }
    </style>
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

            // Clear previous cart items
            cartItemsContainer.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {

                cartItemsContainer.innerHTML = `<div class="p-4 text-gray-500 dark:text-gray-400">Your cart is empty.</div>`;
                cartTotalContainer.innerHTML = '';
                return;
            }
            products.forEach(data => {
                // Create a Flowbite card for each product in the cart
                const itemCard = document.createElement('div');
                itemCard.className = 'flex items-center p-4 border border-gray-200 rounded-lg shadow-sm bg-white dark:bg-gray-800 dark:border-gray-600';
                itemCard.innerHTML = `
                    <img src="/storage/${data.image}" alt="${data.name}" class="w-16 h-16 object-cover rounded mr-4" />
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">${data.name}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Price: ₱ ${data.price}</p>
                    </div>
                    <button class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 remove-item" data-id="${data.id}">
                        Remove
                    </button>
                `;
                cartItemsContainer.appendChild(itemCard);

                // Add to total
                total += parseFloat(data.price);
            });

            // Display total price
            cartTotalContainer.innerHTML = `<h3 class="font-bold text-gray-900 dark:text-gray-100">Total: ₱ ${total.toFixed(2)}</h3>`; // Show total with two decimal places

            // Add event listeners for remove buttons
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const idToRemove = this.getAttribute('data-id');
                    removeFromCart(idToRemove);
                });
            });
        }

        // Function to remove an item from the cart
        function removeFromCart(prodID) {
            let cart = JSON.parse(localStorage.getItem('gcart')) || [];
            cart = cart.filter(id => id !== prodID);
            localStorage.setItem('gcart', JSON.stringify(cart));
            // Fetch products again from localStorage or an API if needed
            fetchCartProductsAndDisplay(); // Function to refetch products and display cart
            showToast("success", "Product", "Product was removed from your cart.");
        }

        // Fetch cart products and display them
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
                    displayCart(data.products); // Assume data contains product details
                })
                .catch(error => {
                    console.error('Error fetching cart data:', error);
                    showToast("error", "Cart", "Failed to load cart products. Please try again.");
                });
            } else {
                // Handle empty cart scenario
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


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <div id="cart" class="max-w-5xl mx-auto mt-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Your Cart</h2>
                    <div id="cart-items" class="space-y-4"></div>
                    <div id="cart-total" class="mt-4 text-lg font-semibold"></div>
                </div>
                
                
               
            </div>
        </div>
    </div>
</x-app-layout>
