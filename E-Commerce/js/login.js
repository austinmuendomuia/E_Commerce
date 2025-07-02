document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  form?.addEventListener("submit", e => {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    if (!username || !password) {
      e.preventDefault();
      alert("Please fill in all fields.");
    }
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const registerForm = document.getElementById("registerForm");
  registerForm?.addEventListener("submit", e => {
    const username = document.getElementById("regUsername").value;
    const password = document.getElementById("regPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    if (!username || !password || !confirmPassword) {
      e.preventDefault();
      alert("Please fill in all fields.");
    } else if (password !== confirmPassword) {
      e.preventDefault();
      alert("Passwords do not match.");
    }
  });
});