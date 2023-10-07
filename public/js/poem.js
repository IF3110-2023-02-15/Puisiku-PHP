document.addEventListener('DOMContentLoaded', function() {
    const addToPlaylistBtn = document.getElementById('poem-add-to-playlist');
    const addToPlaylistModal = document.getElementById('poem-modal-add-to-playlist');
    const confirmBtn = document.getElementById('confirm-add-to-playlist');
    const closeBtn = document.getElementById('playlist-modal-close-button');
    const selectElmt = document.getElementsByName('chosen-playlist')[0];

    addToPlaylistBtn.addEventListener('click', function() {
        addToPlaylistModal.style.display = "block";
    });

    closeBtn.addEventListener('click', function() {
        addToPlaylistModal.style.display = "none";
    });

    confirmBtn.addEventListener('click', function() {
        let playlistId = selectElmt.value;
        let poemId = addToPlaylistModal.dataset.poemId;

        if (playlistId === '') {
            notification.textContent = 'Please select a playlist!';
            notification.classList.add("notification-error");

            setTimeout(function() {
                notification.textContent = "";
                notification.classList.remove("notification-error");
            }, 2000);

            return;
        }

        let formData = new FormData();
        formData.append('playlistId', playlistId);
        formData.append('poemId', poemId);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/playlistItem', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                addToPlaylistModal.style.display = "none";
                let response = JSON.parse(xhr.responseText);

                if ('success' in response) {
                    notification.textContent = "Successfully added poem to playlist";
                    notification.classList.add("notification-success");
                } else {
                    notification.textContent = response.error;
                    notification.classList.add("notification-error");
                }

                setTimeout(function() {
                    notification.textContent = "";
                    notification.classList.remove("notification-success", "notification-error");
                }, 2000);
            }
        };

        xhr.send(formData);
    });
})