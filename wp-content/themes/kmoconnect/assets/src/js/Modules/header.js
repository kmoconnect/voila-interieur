export function setupScrollHeaders(config = {}) {
  const defaultConfig = {
    headerSelectors: [".header", ".navbar"],
    scrollThreshold: 0,
  };

  const finalConfig = { ...defaultConfig, ...config };

  const headers = finalConfig.headerSelectors.map((selector) =>
    document.querySelector(selector),
  );

  document.addEventListener("scroll", () => {
    const shouldScroll = window.scrollY > finalConfig.scrollThreshold;
    headers.forEach((header) => {
      if (shouldScroll) {
        header.classList.add(`${header.classList[0]}--scroll`);
      } else {
        header.classList.remove(`${header.classList[0]}--scroll`);
      }
    });
  });
}

export function setupCollapsedHeaders(config = {}) {
  const defaultConfig = {
    header: ".header",
    navbar: ".navbar",
  };

  const finalConfig = { ...defaultConfig, ...config };

  const navbar = document.querySelector(finalConfig.navbar);
  const header = document.querySelector(finalConfig.header);

  const body = document.body;
  const html = document.documentElement;

  navbar.addEventListener("show.bs.collapse", (event) => {
    header.classList.add("header--collapsed");
    navbar.classList.add("navbar--collapsed");
    body.classList.add("overflow-hidden");
    html.classList.add("overflow-hidden");
  });

  navbar.addEventListener("hide.bs.collapse", (event) => {
    header.classList.remove("header--collapsed");
    navbar.classList.remove("navbar--collapsed");
    body.classList.remove("overflow-hidden");
    html.classList.remove("overflow-hidden");
  });
}
