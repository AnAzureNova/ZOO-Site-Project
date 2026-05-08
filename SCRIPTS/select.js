document.querySelectorAll(".evidence_sideNav a").forEach(link => {
    const linkPage = new URL(link.href).searchParams.get("page");
    const currentPage = new URLSearchParams(window.location.search).get("page") ?? "home";
    if (linkPage === currentPage) link.classList.add("active");
});