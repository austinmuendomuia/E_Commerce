document.addEventListener("DOMContentLoaded", () => {
  const toggles = document.querySelectorAll("[data-toggle]");
  toggles.forEach(btn => {
    btn.addEventListener("click", () => {
      const targetId = btn.dataset.toggle;
      const el = document.getElementById(targetId);
      el?.classList.toggle("hidden");
    });
  });
});