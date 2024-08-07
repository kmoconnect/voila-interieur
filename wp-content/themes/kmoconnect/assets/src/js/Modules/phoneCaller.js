export default function PhoneCaller() {
  const callLinks = document.querySelectorAll(`[data-phone]`);

  if (!callLinks.length) {
    return;
  }

  callLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();

      const phoneNumber = link.getAttribute("data-phone");
      window.location.href = "tel:" + phoneNumber;
    });
  });
}
