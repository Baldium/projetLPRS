//ChatGPT 
// Ouvre le modal avec l'image du CV
function openModal(imageSrc) {
    document.getElementById("modalImage").src = imageSrc; // Met l'image src
    document.getElementById("myModal").style.display = "block"; // Affiche le modal
}

// Ferme le modal
function closeModal() {
    document.getElementById("myModal").style.display = "none"; // Masque le modal
}

// Ferme le modal si l'utilisateur clique en dehors de l'image
window.onclick = function(event) {
    const modal = document.getElementById("myModal");
    if (event.target == modal) {
        closeModal();
    }
}
