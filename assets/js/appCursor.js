const cursor_dot = document.querySelector("[data-cursor-dot]");
  window.addEventListener("mousemove", function (e) {
    const posX = e.clientX;
    const posY = e.clientY;

    cursor_dot.style.left = `${posX}px`;
    cursor_dot.style.top = `${posY}px`;
  });

  document.querySelectorAll('a, button').forEach(element => {
    element.addEventListener('mouseenter', () => {
      cursor_dot.style.backgroundColor = 'var(--accent)';
      cursor_dot.style.boxShadow = '0 0 10px var(--accent), 0 0 20px var(--accent), 0 0 30px var(--accent)';
    });
    element.addEventListener('mouseleave', () => {
      cursor_dot.style.transition = 'background-color 0.2s ease, box-shadow 0.2s ease';
      cursor_dot.style.backgroundColor = '';
      cursor_dot.style.boxShadow = '';
    });
});