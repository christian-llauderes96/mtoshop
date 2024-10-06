$(()=>{
    const prodMods = new manageModal('manage-product-modal');
    $("#add-product").on("click", function(){
        prodMods.setTitle("Add Product");
        prodMods.setFormValues({pid: ""});
        prodMods.resetForm();
        prodMods.open();
    });
    let table = new DataTable('#myTable',{
        processing: true,
        serverSide: true,
        ajax: {
            url: "products/lists",
            headers: {
                'Authorization': `Bearer ${_TOKEN}`,
                'X-CSRF-Token': _TOKEN
            }
        },
        columns: [
            { render: function(data, type, row, meta) {
                    // Add the start index to the current row number
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'id', className:"whitespace-nowrap", render: function(data) {
                return "P-"+data;
            }},
            { data: 'name'},
            { data: 'description'},
            { data: 'stock_quantity'},
            { data: 'price'},
            { data: 'category.name'},
            { data: 'created_at', name: 'created_at', render: function(data) {
                return formatDate(data);
            }},
            { data: null},
        ],
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                className: 'px-6 py-4 whitespace-nowrap text-right',
                render: function(data, type, row, meta) {
                    return `<div class="flex justify-between gap-2">
                                <button data-id=${row.id} type="button" class="prod-edit bg-blue-700 hover:bg-blue-600 dark:text-gray-200 font-semibold rounded-full px-4 py-2 me-1">Edit</button>
                                <button data-id=${row.id} type="button" class="prod-delete bg-red-500 hover:bg-red-600 dark:text-gray-200 font-semibold rounded-full px-4 py-2">Delete</button>
                            </div>`;
                }
            }
        ],
        rowCallback: function(row, data, index) {
            $(row).addClass('dark:hover:bg-gray-700 hover:bg-gray-200');
        }
    });

    if(table)
    {
        $(document).on("click", ".prod-edit, .prod-delete", function() {
            const _id = $(this).data("id");
            const _action = $(this).hasClass("prod-edit") ? "Edit" : "Delete";

            // Find the row corresponding to the clicked button
            const rowData = table.row($(this).closest('tr')).data();
            if (rowData) {
                // console.log(rowData);
                if (_action === "Edit") {
                    // Populate the modal with the product data for editing
                    prodMods.setTitle(`Edit Product: ${rowData.name}`);
                    prodMods.resetForm();

                    // Set the form values for editing // this targets element name
                    prodMods.setFormValues({
                        pname: rowData.name, 
                        price: rowData.price, 
                        pcategory: rowData.category_id,
                        pdescription: rowData.description, 
                        pid: rowData.id,
                    });
                    if(rowData.p_image != null){
                        console.log(ASSETS_URL + rowData.p_image);
                        prodMods.setImageSrc(ASSETS_URL + rowData.p_image);
                        $("#manage-product-modal-preview").removeClass('hidden');
                    }else{
                        prodMods.setImageSrc("#");
                        $("#manage-product-modal-preview").addClass('hidden');
                    }
                    prodMods.open();
                } else if (_action === "Delete") {
                    // Handle delete action (e.g., show confirmation)
                    if (confirm(`Are you sure you want to delete ${rowData.name}?`)) {
                        // Perform the delete action, e.g., call your delete API
                        console.log(`Deleting Product ID: ${_id}`);
                        // Add your delete logic here
                    }
                }
            } else {
                console.log("No data found for this row.");
            }


            // alert(`${_action} Product: ${_id}`);
            // prodMods.setTitle("Edit product name");
            // prodMods.resetForm();
            // prodMods.open();
        });
    }

    document.getElementById('file_input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('manage-product-modal-preview');
    
        if (file) {
            const reader = new FileReader();
    
            reader.onload = function(e) {
                preview.src = e.target.result;  // Set the src of the image to the file's data URL
                preview.classList.remove('hidden'); // Show the image element
            };
    
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            preview.classList.add('hidden'); // Hide the preview if no file is selected
        }
    });
    
    $("form").on("submit", function(e){
        e.preventDefault();
        const _form = $(this),
        _pid = _form.find("#pid").val(),
        url = _pid ? `/products/${_pid}` : '/products',
        // method = _pid ? 'PUT' : 'POST',
        formData = new FormData(this);
        // if (_pid) {
        //     formData.append('_method', 'PUT');
        // }
       
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': _TOKEN
            },
            success: function(response) {
                if(response.code === 200)
                {
                    _form[0].reset();
                    showToast("success", "Product", response.message);
                    $("#product-errors").addClass("hidden");
                    $("#manage-product-modal-preview").addClass("hidden");
                    prodMods.close();
                }
                table.ajax.reload();
            },
            error: function(jqXHR) {
                showToast("error", "Product", "Something went wrong!");
                console.error('Error:', jqXHR.responseText); // Handle error
                const errors = jqXHR.responseJSON.errors;
                displayErrors("product-errors-ul",errors);
                $("#product-errors").removeClass("hidden");
            }
        });
        
    });
    // showToast("error", "Product", "Something went wrong!");
});