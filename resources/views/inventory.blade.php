<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div x-data="productData()">
                        <!-- Search Input -->
                        <input type="text" class="mb-4 p-2 border dark:bg-gray-800 dark:text-white" placeholder="Search Products..." x-model="search" @input="fetchPosts">
                    
                        <!-- Posts Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full dark:bg-gray-800 dark:text-white border border-gray-300 hover:table-fixed">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b cursor-pointer" @click="sortBy('id')">ID</th>
                                        <th class="py-2 px-4 border-b cursor-pointer" @click="sortBy('name')">Name</th>
                                        <th class="py-2 px-4 border-b">Description</th>
                                        <th class="py-2 px-4 border-b cursor-pointer" @click="sortBy('price')">Price</th>
                                        <th class="py-2 px-4 border-b">Quantity</th>
                                        <th class="py-2 px-4 border-b">Category</th>
                                        <th class="py-2 px-4 border-b cursor-pointer" @click="sortBy('created_at')">Created Date</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <template x-for="prod in products" :key="prod.id">
                                        <tr>
                                            <td class="py-2 px-4 border-b" x-text="prod.id"></td>
                                            <td class="py-2 px-4 border-b" x-text="prod.name"></td>
                                            <td class="py-2 px-4 border-b" x-text="prod.description"></td>
                                            <td class="py-2 px-4 border-b" x-text="prod.price"></td>
                                            <td class="py-2 px-4 border-b" x-text="prod.stock_quantity"></td>
                                            <td class="py-2 px-4 border-b" x-text="prod.category_id"></td>
                                            <td class="py-2 px-4 border-b" x-text="prod.updated_at"></td>
                                            <td class="py-2 px-4 border-b">
                                                <button class="bg-yellow-500 dark:text-white px-2 py-1 rounded" @click="editProduct(prod)">Edit</button>
                                                <button class="bg-red-500 dark:text-white px-2 py-1 rounded ml-2" @click="deleteProduct(prod.id)">Delete</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    
                        <!-- Pagination -->
                        <div class="mt-4 flex justify-between items-center">
                            <button class="bg-gray-300 dark:bg-gray-700 px-4 py-2 rounded" @click="prevPage" :disabled="page <= 1">Previous</button>
                            <span class="dark:text-white" x-text="'Page ' + page + ' of ' + totalPages"></span>
                            <button class="bg-gray-300 dark:bg-gray-700 px-4 py-2 rounded" @click="nextPage" :disabled="page >= totalPages">Next</button>
                        </div>
                    </div>
                    
                    <script>
                        function productData() {
                            return {
                                products: [],
                                page: 1,
                                totalPages: 1,
                                search: '',
                                sortByField: 'id',
                                sortDirection: 'asc',
                                
                                fetchPosts() {
                                    axios.get('/api/products', {
                                        params: {
                                            page: this.page,
                                            search: this.search,
                                            sortBy: this.sortByField,
                                            sortDirection: this.sortDirection
                                        }
                                    }).then(response => {
                                        this.products = response.data.data;
                                        this.totalPages = response.data.last_page;
                                    }).catch(error => console.error(error));
                                },
                                
                                deletePost(id) {
                                    axios.delete(`/api/posts/${id}`)
                                        .then(() => {
                                            this.fetchPosts();  // Refetch after delete
                                        })
                                        .catch(error => console.error(error));
                                },
                                
                                sortBy(field) {
                                    if (this.sortByField === field) {
                                        // Toggle sort direction
                                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                                    } else {
                                        this.sortByField = field;
                                        this.sortDirection = 'asc';  // Default sort direction
                                    }
                                    this.fetchPosts();
                                },
                                
                                nextPage() {
                                    if (this.page < this.totalPages) {
                                        this.page++;
                                        this.fetchPosts();
                                    }
                                },
                                
                                prevPage() {
                                    if (this.page > 1) {
                                        this.page--;
                                        this.fetchPosts();
                                    }
                                }
                            }
                        }
                    </script>
                    
                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
