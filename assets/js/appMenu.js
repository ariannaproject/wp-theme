//gestione del menu
const menuIcon = document.getElementById('menuIcon');
menuIcon.addEventListener('click', () => {
  if (menuIcon.classList.contains('active')) {
    document.getElementById('menuMobile').style.height = '65px';
    document.querySelectorAll('.linkMobile').forEach((element) => (element.style.opacity = '0'));
  } else {
    document.getElementById('menuMobile').style.height = '100vh';
    document.querySelectorAll('.linkMobile').forEach((element) => (element.style.opacity = '100'));
  }
  menuIcon.classList.toggle('active');
});