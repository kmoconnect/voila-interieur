// Import dependencies
import jQueryBridget from "jquery-bridget";
import Isotope from "isotope-layout";

// Make Isotope a jQuery plugin
jQueryBridget("isotope", Isotope, jQuery);

export default function initializeIsotope(containerSelector = "#projects") {
  // Ensure jQuery is available
  if (typeof jQuery === "undefined") {
    console.error("jQuery is not loaded.");
    return;
  }

  jQuery(function ($) {
    // Check if the element with the given selector exists
    if ($(containerSelector).length > 0) {
      // Initialize Isotope
      let $grid = $(containerSelector).isotope({
        itemSelector: ".archive-projects__item",
        filter: "*",
        layoutMode: "fitRows",
        fitRows: {
          gutter: 50,
        },
      });

      // Set up event listener for filtering items on button click
      $(".filter__wrapper").on("click", "button", function () {
        let filterValue = $(this).attr("data-filter");
        $grid.isotope({ filter: filterValue });
      });

      $(window).on("load", function () {
        console.log("test");
        $(containerSelector).isotope("layout");
      });
    } else {
      console.warn(`Element with selector "${containerSelector}" not found.`);
    }
  });
}
