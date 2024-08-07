export function scrollToAnchorWithOffset(event) {
    event.preventDefault();

    let targetId;

    if (event.target.tagName === 'A') {
        targetId = event.target.getAttribute('href').split('#')[1];
    } else {
        targetId = event.target.parentNode.getAttribute('href').split('#')[1];
    }

    const targetElement = document.getElementById(targetId);

    if (targetElement) {
        const offset = targetElement.dataset.offset || 0;
        const targetOffset = targetElement.offsetTop - offset;

        window.scrollTo({
            top: targetOffset,
            behavior: 'smooth'
        });
    }
}
