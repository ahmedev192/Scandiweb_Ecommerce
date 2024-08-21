

    document.getElementById('delete-product-btn').addEventListener('click', function () {
            const checkedBoxes = document.querySelectorAll('.delete-checkbox:checked');
            const idsToDelete = Array.from(checkedBoxes).map(cb => cb.value);

            if (idsToDelete.length > 0) {
                fetch('/deleteproducts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ ids: idsToDelete })
                })
                .then(response => {
                    return response.json().catch(() => {
                        throw new Error("Failed to parse JSON");
                    });
                })
                .then(data => {
                    if (data.success) {
                        location.reload(); // Refresh the page after deletion
                    } else {
                      //  alert('Failed to delete selected products.');
                    }
                })
                .catch(error => {
                    //console.error(error);
                 //   alert('An error occurred while processing your request.');
                });
            } else {
                //alert('Please select at least one product to delete.');
            }
        });



