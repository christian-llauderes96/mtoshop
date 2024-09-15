<x-app-layout>
    @push('custom-links')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"> --}}
    @endpush
    @push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script>
    
    
    

    if (document.getElementById("pagination-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        // const dataTable = new simpleDatatables.DataTable("#pagination-table", {
        //     paging: true,
        //     perPage: 5,
        //     perPageSelect: [5, 10, 15, 20, 25],
        //     sortable: false
        // });
        // $(() => {
        //     $('#pagination-table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "api/products",
        //         columns: [
        //             { render: function(data, type, row, meta) {return meta.row + 1;}},
        //             { data: 'id'},
        //             { data: 'name'},
        //             { data: 'description'},
        //             { data: 'stock_quantity'},
        //             { data: 'price'},
        //             { data: 'category_id'},
        //             { data: 'created_at'},
        //         ]
        //     });
        // });
        document.addEventListener('DOMContentLoaded', async () => {
            const table = document.querySelector('#pagination-table');

            async function fetchData(page = 1) {
                const response = await fetch(`api/products?page=${page}`);
                const data = await response.json();
                return data;
            }

            async function initializeTable() {
                const data = await fetchData();

                const dataTable = new DataTable(table, {
                    data: {
                        headings: ["#", "ID", "Name", "Description", "Stock Quantity", "Price", "Category", "Created Date"],
                        data: data.data.map((item, index) => [
                            index + 1, 
                            item.id, 
                            item.name, 
                            item.description, 
                            item.stock_quantity, 
                            item.price, 
                            item.category_id, 
                            item.created_at
                        ])
                    },
                    perPage: 5,
                    perPageSelect: [5, 10, 15, 20, 25]
                });

                // Handle pagination
                document.querySelector('.dataTable-pagination').addEventListener('click', async (event) => {
                    if (event.target.classList.contains('page-link')) {
                        const page = parseInt(event.target.getAttribute('data-page'));
                        const newData = await fetchData(page);
                        dataTable.update({
                            data: {
                                data: newData.data.map((item, index) => [
                                    index + 1, 
                                    item.id, 
                                    item.name, 
                                    item.description, 
                                    item.stock_quantity, 
                                    item.price, 
                                    item.category_id, 
                                    item.created_at
                                ])
                            }
                        });
                    }
                });
            }

            initializeTable();
        });
    }



        
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
                    

                   

                    

                    
<table id="pagination-table">
    <thead>
        <tr>
            <th>
                <span class="flex items-center">
                    Model Name
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Developer
                </span>
            </th>
            <th data-type="date" data-format="Month YYYY">
                <span class="flex items-center">
                    Release Date
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Parameters
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Primary Application
                </span>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">GPT-4</td>
            <td>OpenAI</td>
            <td>March 2023</td>
            <td>1 trillion</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">BERT</td>
            <td>Google</td>
            <td>October 2018</td>
            <td>340 million</td>
            <td>Natural Language Understanding</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">DALL-E 2</td>
            <td>OpenAI</td>
            <td>April 2022</td>
            <td>3.5 billion</td>
            <td>Image Generation</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">T5</td>
            <td>Google</td>
            <td>October 2019</td>
            <td>11 billion</td>
            <td>Text-to-Text Transfer</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">GPT-3.5</td>
            <td>OpenAI</td>
            <td>November 2022</td>
            <td>175 billion</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Codex</td>
            <td>OpenAI</td>
            <td>August 2021</td>
            <td>12 billion</td>
            <td>Code Generation</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">PaLM 2</td>
            <td>Google</td>
            <td>May 2023</td>
            <td>540 billion</td>
            <td>Multilingual Understanding</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">LaMDA</td>
            <td>Google</td>
            <td>May 2021</td>
            <td>137 billion</td>
            <td>Conversational AI</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">CLIP</td>
            <td>OpenAI</td>
            <td>January 2021</td>
            <td>400 million</td>
            <td>Image and Text Understanding</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">XLNet</td>
            <td>Google</td>
            <td>June 2019</td>
            <td>340 million</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Meena</td>
            <td>Google</td>
            <td>January 2020</td>
            <td>2.6 billion</td>
            <td>Conversational AI</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">BigGAN</td>
            <td>Google</td>
            <td>September 2018</td>
            <td>Unlimited</td>
            <td>Image Generation</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Electra</td>
            <td>Google</td>
            <td>March 2020</td>
            <td>14 million</td>
            <td>Natural Language Understanding</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Swin Transformer</td>
            <td>Microsoft</td>
            <td>April 2021</td>
            <td>88 million</td>
            <td>Vision Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">GPT-NeoX-20B</td>
            <td>EleutherAI</td>
            <td>April 2022</td>
            <td>20 billion</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Ernie 3.0</td>
            <td>Baidu</td>
            <td>July 2021</td>
            <td>10 billion</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Turing-NLG</td>
            <td>Microsoft</td>
            <td>February 2020</td>
            <td>17 billion</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Wu Dao 2.0</td>
            <td>Beijing Academy of AI</td>
            <td>June 2021</td>
            <td>1.75 trillion</td>
            <td>Multimodal Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Jukebox</td>
            <td>OpenAI</td>
            <td>April 2020</td>
            <td>1.2 billion</td>
            <td>Music Generation</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">StyleGAN2</td>
            <td>NVIDIA</td>
            <td>February 2020</td>
            <td>Unlimited</td>
            <td>Image Generation</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">FLAN</td>
            <td>Google</td>
            <td>December 2021</td>
            <td>137 billion</td>
            <td>Few-shot Learning</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">GShard</td>
            <td>Google</td>
            <td>June 2020</td>
            <td>600 billion</td>
            <td>Multilingual Understanding</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">AlphaFold</td>
            <td>DeepMind</td>
            <td>December 2020</td>
            <td>Unknown</td>
            <td>Protein Folding</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">GPT-J</td>
            <td>EleutherAI</td>
            <td>June 2021</td>
            <td>6 billion</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">M6</td>
            <td>Alibaba</td>
            <td>December 2020</td>
            <td>10 billion</td>
            <td>Multimodal Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Megatron-Turing NLG</td>
            <td>NVIDIA & Microsoft</td>
            <td>October 2021</td>
            <td>530 billion</td>
            <td>Natural Language Processing</td>
        </tr>
        <tr>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">DeepSpeed</td>
            <td>Microsoft</td>
            <td>February 2020</td>
            <td>Not disclosed</td>
            <td>AI Training Optimization</td>
        </tr>
    </tbody>
</table>

                    

                    

                    

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
