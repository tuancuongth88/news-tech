<script id="backToTopScript">
    document.addEventListener("DOMContentLoaded", function () {
        const backToTopButton = document.getElementById("backToTop");
        window.addEventListener("scroll", function () {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add("visible");
            } else {
                backToTopButton.classList.remove("visible");
            }
        });
        backToTopButton.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const marquee = document.querySelector(".animate-marquee");
        if (marquee) {
            const cloneContent = marquee.innerHTML;
            marquee.innerHTML = cloneContent + cloneContent;
            const style = document.createElement("style");
            style.textContent = `
  @keyframes marquee {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
  }
  .animate-marquee {
  display: inline-block;
  animation: marquee 90s linear infinite;
  }
  .animate-marquee:hover {
  animation-play-state: paused;
  }
  `;
            document.head.appendChild(style);
        }
    });
</script>
