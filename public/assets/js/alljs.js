function manageModal(id) {
    const modalElement = document.getElementById(id);
    const modal = new Modal(modalElement, {
        backdrop: 'static',
        closable: true,
    });

    // Open the modal
    this.open = function() {
        modal.show();
    };

    // Close the modal
    this.close = function() {
        modal.hide();
    };

    // Reset the form in the modal
    this.resetForm = function() {
        const form = modalElement.querySelector("form");
        if (form) {
            form.reset();
        }
    };

    // Set the modal title
    this.setTitle = function(title) {
        const titleElement = document.getElementById(`${id}-title`); // Use the correct selector
        if (titleElement) {
            titleElement.textContent = title;
        }
    };

    this.setFormValues = function(values) {
        const form = modalElement.querySelector("form");
        if (form) {
            for (const [name, value] of Object.entries(values)) {
                const input = form.elements[name];
                if (input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = (input.value === value);
                    }else if (input.tagName.toLowerCase() === 'select') {
                        // Set the selected value for select elements
                        Array.from(input.options).forEach(option => {
                            option.selected = (option.value == value);
                        });
                    } else {
                        input.value = value;
                    }
                }
            }
        }
    };

    // Set the image source
    this.setImageSrc = function(imageUrl) {
        const imageElement = document.getElementById(`${id}-preview`);
        if (imageElement) {
            imageElement.src = imageUrl;
        }
    };
    

    // Attach event listeners for closing the modal when clicking on buttons with data-modal-hide
    $(document).on("click", `[data-modal-hide='${id}']`, () => this.close());
}

function displayErrors(id_hold, errors) {
    const errorList = $(`#${id_hold}`); // Assuming you have a container to display errors
    errorList.empty(); // Clear previous errors
    for (const key in errors) {
        errors[key].forEach(error => {
            errorList.append(`<li>${error}</li>`); // Display each error in the list
        });
    }
}

//toastr
function showToast(toastType, title, message){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr[toastType](message, title);
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
    return new Date(dateString).toLocaleString('en-US', options);
}

function PHP_FORMAT(value){
    // return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(value); //with currency symbol
    return new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2 }).format(value); //without currency symbol
}