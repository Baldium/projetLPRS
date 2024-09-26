const deleteBtn = document.getElementById('delete-btn');
    const confirmDeleteSection = document.getElementById('confirm-delete');
    const confirmBtn = document.getElementById('confirm-btn');

    deleteBtn.addEventListener('click', () => {
      confirmDeleteSection.style.display = 'block';
    });

    confirmBtn.addEventListener('click', () => {
      window.location.href = "http://localhost:8888/SchumanLink/projetLPRS/controller/DeleteProfilBusiness.php"; 
    });