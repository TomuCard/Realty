const currentPagePath = window.location.pathname;

const links = document.getElementsByClassName("global-buttonHref");

// On parcourt chaque lien pour vérifier s'il correspond à la page actuelle
for (let i = 0; i < links.length; i++) {
  const link = links[i];
  const href = link.getAttribute("href");

  if (currentPagePath.endsWith("dashboard.php") && href.endsWith("dashboard.php")) {
    link.classList.add("global-activeButton");
  } else if (currentPagePath.endsWith("employeemessage.php") && href.endsWith("employeemessage.php")) {
    link.classList.add("global-activeButton");
  } else if (currentPagePath.endsWith("checklist.php") && href.endsWith("checklist.php")) {
    link.classList.add("global-activeButton");
  } else if (currentPagePath.endsWith("planning.php") && href.endsWith("planning.php")) {
    link.classList.add("global-activeButton");
  } else if (currentPagePath.endsWith("report.php") && href.endsWith("report.php")) {
    link.classList.add("global-activeButton");
  } else {
    link.classList.remove("global-activeButton");
  }
}
