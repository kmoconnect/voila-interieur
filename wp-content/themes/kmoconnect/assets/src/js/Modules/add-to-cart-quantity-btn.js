export default function () {
  document.addEventListener("click", function (event) {
    const target = event.target;

    // Check if the clicked element or its parent is the decrement button
    if (
      target.matches('[data-action="decrement"]') ||
      target.closest('[data-action="decrement"]')
    ) {
      const button = target.matches('[data-action="decrement"]')
        ? target
        : target.closest('[data-action="decrement"]');
      const quantityInput = button.closest(".quantity").querySelector(".qty");
      updateQuantity(quantityInput, -1);
    } else if (
      target.matches('[data-action="increment"]') ||
      target.closest('[data-action="increment"]')
    ) {
      const button = target.matches('[data-action="increment"]')
        ? target
        : target.closest('[data-action="increment"]');
      const quantityInput = button.closest(".quantity").querySelector(".qty");
      updateQuantity(quantityInput, 1);
    }
  });

  // Event listener for manual changes in the quantity input
  document.addEventListener("input", function (event) {
    const target = event.target;

    if (target.classList.contains("qty")) {
      updateQuantity(target, 0);
    }
  });

  function updateQuantity(input, delta) {
    const currentValue = parseFloat(input.value) || 0;
    const step = parseFloat(input.getAttribute("step")) || 1;
    const min = parseFloat(input.getAttribute("min")) || 0;
    const max = parseFloat(input.getAttribute("max"));

    let newValue = currentValue + delta * step;

    if (typeof max === "number" && newValue > max) {
      newValue = max;
    }

    if (newValue < min) {
      newValue = min;
    }

    if (newValue === 0) {
      return;
    }

    input.value = newValue;

    // Trigger change event on the input (for compatibility with other scripts)
    input.dispatchEvent(new Event("change", { bubbles: true }));

    // Trigger change event on the update_cart button(s)
    const updateCartButtons = document.getElementsByName("update_cart");

    updateCartButtons.forEach((button) => {
      button.disabled = false; // Enable the button
      button.click(); // Simulate a click event on the button
    });
  }
}
