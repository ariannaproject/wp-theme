  //gestione del carosello nella homepage.
  const carousels = document.querySelectorAll('.cardGroup');
  carousels.forEach(carousel => {
    carousel.addEventListener('mouseenter', () => {
      carousels.forEach(c => c.style.animationPlayState = 'paused');
    });
  
    carousel.addEventListener('mouseleave', () => {
      carousels.forEach(c => c.style.animationPlayState = 'running');
    });
  });