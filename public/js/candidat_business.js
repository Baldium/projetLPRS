// script.js

function openModal(imgSrc) {
    document.getElementById('modalImage').src = imgSrc; // Change la source de l'image
    document.getElementById('myModal').style.display = 'block'; // Affiche le modal
}

function closeModal() {
    document.getElementById('myModal').style.display = 'none'; // Cache le modal
}

// Ferme le modal quand on clique à l'extérieur de l'image
window.onclick = function(event) {
    const modal = document.getElementById('myModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
