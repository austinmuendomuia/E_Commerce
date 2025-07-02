document.addEventListener("DOMContentLoaded", () => {
  const forms = document.querySelectorAll("form");
  forms.forEach(form => {
    form.addEventListener("submit", (e) => {
      const password = form.querySelector("input[name='password']")?.value;
      if (password.length < 6) {
        alert("Password must be at least 6 characters");
        e.preventDefault();
      }
    });
  });
});