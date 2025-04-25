document.addEventListener('DOMContentLoaded', () => {
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const modalContainer = document.getElementById('modalContainer');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');
  
    forgotPasswordLink.addEventListener('click', (e) => {
      e.preventDefault();
      modalContainer.style.display = 'flex';
    });
  
    cancelBtn.addEventListener('click', () => {
      modalContainer.style.display = 'none';
    });
  
    confirmBtn.addEventListener('click', () => {
      alert('Password recovery email triggered (example).');
      modalContainer.style.display = 'none';
    });
  });
  