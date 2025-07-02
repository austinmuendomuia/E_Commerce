document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registerForm");
  form?.addEventListener("submit", e => {
    const pwd = document.getElementById("password").value;
    const confirm = document.getElementById("confirmPassword").value;
    if (pwd !== confirm) {
      e.preventDefault();
      alert("Passwords do not match.");
    }
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirmPassword");

  usernameInput?.addEventListener("input", () => {
    if (usernameInput.value.length < 3) {
      usernameInput.setCustomValidity("Username must be at least 3 characters long.");
    } else {
      usernameInput.setCustomValidity("");
    }
  });

  passwordInput?.addEventListener("input", () => {
    if (passwordInput.value.length < 6) {
      passwordInput.setCustomValidity("Password must be at least 6 characters long.");
    } else {
      passwordInput.setCustomValidity("");
    }
  });

  confirmPasswordInput?.addEventListener("input", () => {
    if (confirmPasswordInput.value !== passwordInput.value) {
      confirmPasswordInput.setCustomValidity("Passwords do not match.");
    } else {
      confirmPasswordInput.setCustomValidity("");
    }
  });
});