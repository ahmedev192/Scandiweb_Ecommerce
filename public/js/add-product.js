$(document).ready(() => {
    // Handle product type change
    $('#productType').change(function() {
        const selectedType = $(this).val();
        $('.hidden').hide(); // Hide all specific fields

        switch (selectedType) {
            case 'DVD':
                $('#dvdFields').show();
                break;
            case 'Book':
                $('#bookFields').show();
                break;
            case 'Furniture':
                $('#furnitureFields').show();
                break;
        }
    });

    // Handle save button click
    $('#saveButton').click(() => {
        const sku = sanitizeInput($('#sku').val());
        const name = sanitizeInput($('#name').val());
        const price = sanitizeInput($('#price').val());
        const type = $('#productType').val();
        const attributes = {};
        let valid = true;

        // Validate mandatory fields
        if (!sku || !name || !price || !type) {
            valid = false;
        }

        // Validate specific fields based on the selected type
        switch (type) {
            case 'DVD':
                if (!$('#size').val()) valid = false;
                attributes.size = sanitizeInput($('#size').val());
                break;
            case 'Book':
                if (!$('#weight').val()) valid = false;
                attributes.weight = sanitizeInput($('#weight').val());
                break;
            case 'Furniture':
                if (!$('#height').val() || !$('#width').val() || !$('#length').val()) valid = false;
                attributes.height = sanitizeInput($('#height').val());
                attributes.width = sanitizeInput($('#width').val());
                attributes.length = sanitizeInput($('#length').val());
                break;
        }

        if (!valid) {
            $('#errorMessage').show();
            return;
        }
        $('#errorMessage').hide();

        // Prepare data to send via AJAX
        const formData = {
            sku,
            name,
            price,
            type,
            attributes
        };

        // AJAX request
        $.ajax({
            url: '/saveproduct',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            dataType: 'json',
            success: response => {
                if (response.success) {
                    window.location.href = '/'; // Redirect to the product list page
                } else {
                    alert(response.message);
                }
            },
            error: (jqXHR, textStatus) => {
                alert('An error occurred: ' + textStatus);
            }
        });
    });

    // Handle cancel button click
    $('#cancelButton').click(() => {
        window.location.href = '/'; // Redirect to the product list page
    });

    // Function to sanitize input
    function sanitizeInput(input) {
        return input.replace(/<\/?[^>]+(>|$)/g, ""); // Removes any HTML tags
    }
});
