<x-app-layout>
    <!-- Custom links and scripts -->
    @push('custom-links')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/jquery.dataTables.min.css">
    <style>
        /* Custom styles for DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-1 border rounded-md text-gray-800 bg-white border-gray-300;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            @apply bg-gray-800 text-white;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply border rounded-md px-3 py-1;
        }

        .dataTables_wrapper .dataTables_info {
            @apply text-sm text-gray-700 dark:text-gray-400;
        }

        .dataTables_wrapper .dataTables_length select {
            @apply border rounded-md px-2 py-1;
        }
    </style>
    @endpush

    @push('custom-scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script>
        $(() => {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "api/products",
                columns: [
                    { render: function(data, type, row, meta) {return meta.row + 1;}},
                    { data: 'id'},
                    { data: 'name'},
                    { data: 'description'},
                    { data: 'stock_quantity'},
                    { data: 'price'},
                    { data: 'category_id'},
                    { data: 'created_at'},
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
                    <table id="myTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Create Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            <!-- DataTables will populate this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
