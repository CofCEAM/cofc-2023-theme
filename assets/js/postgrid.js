$(document).ready(() => {
  // when you click on a post in one of the post grids, it should trigger
  // the click on the link to that post. by default you have to know to click
  // the link button even though the full item looks clickable. this makes it more intuitive.
  document.querySelectorAll(".cofc-post-grid-item").forEach((el) => {
    el.addEventListener("click", () => {
      el.querySelector("a.card-news__button").click();
    });
  });
});
