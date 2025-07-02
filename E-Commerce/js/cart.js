document.addEventListener("DOMContentLoaded", () => {
  const removeButtons = document.querySelectorAll(".remove-from-cart");
  removeButtons.forEach(button => {
    button.addEventListener("click", () => {
      const productId = button.dataset.productId;
      fetch(`remove_from_cart.php?id=${productId}`)
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert("Error removing item.");
          }
        });
    });
  });
});
    const updateButtons = document.querySelectorAll(".update-cart");
    updateButtons.forEach(button => {
        button.addEventListener("click", () => {
        const productId = button.dataset.productId;
        const quantityInput = document.querySelector(`input[name="quantity[${productId}]"]`);
        const quantity = quantityInput.value;
        fetch(`update_cart.php?id=${productId}&quantity=${quantity}`)
            .then(res => res.json())
            .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert("Error updating item.");
            }
            });
        });
    });
    const checkoutButton = document.getElementById("checkoutButton");
    if (checkoutButton) {
        checkoutButton.addEventListener("click", () => {
            fetch("checkout.php")
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Checkout successful!");
                        location.href = "order_confirmation.php";
                    } else {
                        alert("Error during checkout.");
                    }
                });
        });
    }
document.addEventListener('DOMContentLoaded', function () {
  const qtyInputs = document.querySelectorAll('input[type="number"]');
  
  qtyInputs.forEach(input => {
    input.addEventListener('change', () => {
      document.querySelector('button[name="update"]').click();
    });
  });
});
