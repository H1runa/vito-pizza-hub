import './bootstrap';  // Import Laravel Bootstrap helper

// sure you want to delete? button function
function confirmDelete(button) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to undo this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            button.nextElementSibling.submit(); // Submit the form
        }
    });
}
