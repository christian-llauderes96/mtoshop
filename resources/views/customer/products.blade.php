<x-app-layout>
    @push('custom-links')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <style>
        #toast-container {
            top: 70px; 
        }
    </style>
    @endpush
    @push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.querySelectorAll('.product-addto-cart').forEach(button => {
            button.addEventListener('click', function() {
                const _prodID = this.getAttribute("data-id");

                // kunin ang cart or iinitialize
                let cart = JSON.parse(localStorage.getItem('gcart')) || [];

                // Check if the product is already in the cart
                if (!cart.includes(_prodID)) {
                    cart.push(_prodID); // Add product ID to the cart
                    localStorage.setItem('gcart', JSON.stringify(cart)); // Update local storage
                    showToast("success", "Product", "Product was added to cart!");
                } else {
                    showToast("warning", "Product", "Product is already in the cart!");
                }
            });
        });
    </script>
    @endpush
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center p-4 space-y-2 sm:space-y-0">
                    <div class="flex space-x-2 w-full sm:w-auto">
                        <select class="form-select bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 w-full rounded" aria-label="Default select example">
                            <option selected>Sort by</option>
                            <option value="1">Price: Low to High</option>
                            <option value="2">Price: High to Low</option>
                            <option value="3">Newest Arrivals</option>
                        </select>
                    </div>
                
                    <div class="flex space-x-2 w-full sm:w-auto">
                        <input type="text" placeholder="Search products..." class="form-input bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 w-full rounded" />
                        <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition dark:bg-blue-600 dark:hover:bg-blue-700 w-full sm:w-auto">Search</button>
                    </div>
                </div>
                
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden dark:bg-gray-800 border border-blue-400 dark:border-blue-700">
                        <div class="flex item-center">
                            <img src="{{ is_null($product->p_image)? "/assets/img/default.webp":asset("storage/".$product->file_path."/".$product->p_image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover" />
                        </div>
                
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $product->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ Str::limit($product->description, 70, '...') }}</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-gray-200">Php {{ $product->price }}</p>
                            <div class="mt-2">
                                <button data-id="{{ $product->id }}" type="button" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition dark:bg-blue-600 dark:hover:bg-blue-700 product-addto-cart">Add to Cart</button>
                                <button data-id="{{ $product->id }}" type="button" class="bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 transition dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 product-view">View Details</button>
                            </div>
                            <div class="mt-2 text-yellow-500">
                                
                                @php
                                    // Set the min and max star values
                                    $minStars = 3;
                                    $maxStars = 5;
                                    $randomStars = rand($minStars, $maxStars);
                                    $stars = str_repeat('⭐', $randomStars) . str_repeat('☆', $maxStars - $randomStars);
                                @endphp
                                {{ $stars }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Repeat for other products -->
                </div>
                
                

                

                
                

                
               
            </div>
        </div>
    </div>
</x-app-layout>
