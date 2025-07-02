document.querySelector("form").addEventListener("submit", function(e) {
  const name = document.querySelector("[name='fullname']").value.trim();
  const address = document.querySelector("[name='address']").value.trim();
  
  if (!name || !address) {
    alert("Please fill in all fields.");
    e.preventDefault();
  }
});
