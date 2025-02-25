document.addEventListener("DOMContentLoaded", function () {
    let profileDropdownList = document.querySelector(".profile-dropdown-list");
    let btn = document.querySelector(".profile-dropdown-btn");
  
    if (!profileDropdownList || !btn) {
      console.error("Dropdown elements not found!");
      return;
    }
  
    btn.addEventListener("click", function (e) {
      profileDropdownList.classList.toggle("active");
      e.stopPropagation(); // Prevents closing when clicking the button
    });
  
    window.addEventListener("click", function (e) {
      if (!btn.contains(e.target)) profileDropdownList.classList.remove("active");
    });
  });
  