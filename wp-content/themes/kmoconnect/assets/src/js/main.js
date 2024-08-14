// Sass & vendor import
import "../sass/style.scss";

// Bootstrap module import
import * as bootstrap from "bootstrap";

// Own JS files
import setupScrollToTop from "./Modules/scrollToTop";
import phoneCaller from "./Modules/phoneCaller";

// AOS animate
import AOS from "aos";
import "aos/dist/aos.css";
import addToCartQuantityBtn from "./Modules/add-to-cart-quantity-btn";
import { setupCollapsedHeaders, setupScrollHeaders } from "./Modules/header";
import initializeIsotope from "./Modules/projects-filter";

document.addEventListener("DOMContentLoaded", () => {
  setupScrollToTop();
  setupScrollHeaders();
  setupCollapsedHeaders();
  setupScrollToTop();
  phoneCaller();
  initializeIsotope(".group-cards__wrap");

  AOS.init({
    once: true,
    delay: 50,
    offset: 60,
    duration: 750,
  });
});
