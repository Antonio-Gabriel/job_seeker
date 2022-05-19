const links = document.querySelectorAll(".pagination .container .pages .page");

links.forEach((element) => {
  element.addEventListener("click", () => {
    resetLinks();
    element.classList.add("active");
  });
});

function resetLinks() {
  links.forEach((element) => element.classList.remove("active"));
}
