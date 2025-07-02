document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput");
  const productCards = document.querySelectorAll(".product-card");

  searchInput?.addEventListener("keyup", () => {
    const filter = searchInput.value.toLowerCase();
    productCards.forEach(card => {
      const title = card.querySelector(".product-title").textContent.toLowerCase();
      card.style.display = title.includes(filter) ? "block" : "none";
    });
  });

  const categoryButtons = document.querySelectorAll(".category-btn");
  categoryButtons.forEach(button => {
    button.addEventListener("click", () => {
      const category = button.dataset.category;
      productCards.forEach(card => {
        card.style.display = category === "all" || card.dataset.category === category ? "block" : "none";
      });
    });
  });
});
