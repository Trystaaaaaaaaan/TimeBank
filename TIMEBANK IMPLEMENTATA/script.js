// script.js

// Funzione per ingrandire le immagini al clic
function openImageModal(imageUrl) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    modalImage.src = imageUrl;
    modal.style.display = 'block';
}

// Funzione per chiudere la finestra modale
function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
}

// Event listener per i click sulle miniature dei corsi
const courseThumbnails = document.querySelectorAll('.course img');
courseThumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener('click', () => {
        const imageUrl = thumbnail.src;
        openImageModal(imageUrl);
    });
});

// Event listener per il pulsante di chiusura della finestra modale
const closeButton = document.getElementById('closeButton');
closeButton.addEventListener('click', closeImageModal);
