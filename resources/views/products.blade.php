<x-app-layout>
    @push('custom-links')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    @endpush
    @push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // const table = document.getElementById('myTable');
            let table = new DataTable('#myTable',{
                processing: true,
                serverSide: true,
                ajax: "api/products",
                columns: [
                    { render: function(data, type, row, meta) {
                            // Add the start index to the current row number
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name'},
                    { data: 'description'},
                    { data: 'stock_quantity'},
                    { data: 'price'},
                    { data: 'category_id'},
                    { data: 'created_at'},
                    { data: null},
                ],
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false,
                        className: 'px-6 py-4 whitespace-nowrap text-right',
                        render: function(data, type, row, meta) {
                            return `<button type="button" class="bg-blue-500 hover:bg-blue-600 dark:text-gray-200 font-semibold rounded-full px-4 py-2 ">Edit</button>
                            <button type="button" class="bg-red-500 hover:bg-red-600 dark:text-gray-200 font-semibold rounded-full px-4 py-2 ">Delete</button>`;
                        }
                    }
                ]
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="myTable" class="w-full text-sm text-left dark:text-gray-200 text-center">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                                <th scope="col" class="px-6 py-3">Category</th>
                                <th scope="col" class="px-6 py-3">Created</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
