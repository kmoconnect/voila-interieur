export default function setupScrollToTop(config = {}) {
  const defaultConfig = {
    buttonSelector: "#scrollTop",
    scrollOffset: 100,
    scrollDuration: 800
  };

  const finalConfig = { ...defaultConfig, ...config };

  const scrollTop = document.querySelector(finalConfig.buttonSelector);

  window.addEventListener("scroll", function () {
    const topPos = window.scrollY;

    if (topPos > finalConfig.scrollOffset) {
      scrollTop.style.opacity = "1";
    } else {
      scrollTop.style.opacity = "0";
    }
  });

  scrollTop.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
      duration: finalConfig.scrollDuration
    });
  });
}
