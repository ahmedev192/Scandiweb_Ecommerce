   $(document).ready(function() {
            $('#productType').change(function() {
                const selectedType = $(this).val();
                $('.hidden').hide(); // Hide all specific fields

                if (selectedType === 'DVD') {
                    $('#dvdFields').show();
                } else if (selectedType === 'Book') {
                    $('#bookFields').show();
                } else if (selectedType === 'Furniture') {
                    $('#furnitureFields').show();
                }
            });

            $('#saveButton').click(function() {
                const sku = sanitizeInput($('#sku').val());
                const name = sanitizeInput($('#name').val());
                const price = sanitizeInput($('#price').val());
                const type = $('#productType').val();
                let valid = true;

                // Validate mandatory fields
                if (!sku || !name || !price || !type) {
                    valid = false;
                }

                // Validate specific fields based on the selected type
                let attributes = {};
                if (type === 'DVD') {
                    if (!$('#size').val()) valid = false;
                    attributes.size = sanitizeInput($('#size').val());
                } else if (type === 'Book') {
                    if (!$('#weight').val()) valid = false;
                    attributes.weight = sanitizeInput($('#weight').val());
                } else if (type === 'Furniture') {
                    if (!$('#height').val() || !$('#width').val() || !$('#length').val()) valid = false;
                    attributes.height = sanitizeInput($('#height').val());
                    attributes.width = sanitizeInput($('#width').val());
                    attributes.length = sanitizeInput($('#length').val());
                }

                if (!valid) {
                    $('#errorMessage').show();
                    return;
                } else {
                    $('#errorMessage').hide();
                }

                // Prepare data to send via AJAX
                const formData = {
                    sku: sku,
                    name: name,
                    price: price,
                    type: type,
                    attributes: attributes
                };

                // AJAX request
                $.ajax({
                    url: '/saveproduct', // Correct route to handle saving
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/'; // Redirect to the product list page
                        } else {
                          //  alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       // alert('An error occurred: ' + textStatus);
                    }
                });

            });

            $('#cancelButton').click(function() {
                // Redirect to the product list page
                window.location.href = '/';
            });

            // Function to sanitize input
            function sanitizeInput(input) {
                return input.replace(/<\/?[^>]+(>|$)/g, ""); // Removes any HTML tags
            }
        });