document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll(".navbarProfile a");
  
    for (let i = 0; i < links.length; i++) {
      const link = links[i];
      const href = link.getAttribute("href");
      const currentPagePath = window.location.pathname;
  
      if (currentPagePath.endsWith("profile.php") && href.endsWith("profile.php")) {
        link.classList.add("active");
      } else if (currentPagePath.endsWith("historyLocations.php") && href.endsWith("historyLocations.php")) {
        link.classList.add("active");
      } else if (currentPagePath.endsWith("billings.php") && href.endsWith("billings.php")) {
        link.classList.add("active");
      } else if (currentPagePath.endsWith("message.php") && href.endsWith("message.php")) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    }
  });
  
