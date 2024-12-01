  // ChatGPT 
  $(document).ready(function() {
    $('.like-button').click(function() {
        const button = $(this);
        const postId = button.data('id');
        const likesSpan = button.find('span');
        const isLiked = button.hasClass('liked'); // Vérifier si le bouton est déjà liké

        $.ajax({
            url: '../../controller/controllerAlumis/like_post.php',
            method: 'POST',
            data: {
                postId: postId,
                action: isLiked ? 'unlike' : 'like' // Si déjà liké, on envoie 'unlike'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let currentLikes = parseInt(likesSpan.text());
                    if (isLiked) {
                        currentLikes -= 1; // Décrémenter les likes
                        button.removeClass('liked');
                    } else {
                        currentLikes += 1; // Incrémenter les likes
                        button.addClass('liked');
                    }
                    likesSpan.text(currentLikes);
                } else {
                    alert(response.message || 'Une erreur est survenue.');
                }
            },
            error: function() {
                alert('Erreur lors de la requête AJAX.');
            }
        });
    });
});

function toggleReplyForm(commentId) {
    var form = document.getElementById('reply-form-' + commentId);
    if (form.style.display === "none" || form.style.display === "") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}

function toggleReplies(commentId) {
    var repliesSection = document.getElementById('replies-' + commentId);
    if (repliesSection.style.display === "none" || repliesSection.style.display === "") {
        repliesSection.style.display = "block";
    } else {
        repliesSection.style.display = "none";
    }
}


