const bars = document.querySelector(".menu-icon");

bars.addEventListener("click", () => {
  const sidebar = document.querySelector(".sidebar");
  sidebar.classList.toggle("active");
});
