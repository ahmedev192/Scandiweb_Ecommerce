document.getElementById('delete-product-btn').addEventListener('click', async () => {
    const checkedBoxes = document.querySelectorAll('.delete-checkbox:checked');
    const idsToDelete = Array.from(checkedBoxes).map(cb => cb.value);

    if (idsToDelete.length === 0) return;

    try {
        const response = await fetch('/deleteproducts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: idsToDelete })
        });

        const data = await response.json();

        if (data.success) {
            location.reload(); // Refresh the page after deletion
        }
    } catch (error) {
        console.error("Error:", error);
    }
});
