document.querySelector("#openModalBtn").addEventListener("click", function () {
  document.body.classList.add("modal-open"); // Add blur
});

document.querySelector("#closeModalBtn").addEventListener("click", function () {
  document.body.classList.remove("modal-open"); // Remove blur
});
