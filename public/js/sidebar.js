const addPlaylistForm = document.getElementById('add-playlist-form');
const addPlaylistModal = document.getElementById("add-playlist-modal");
const addPlaylistBtn = document.getElementById("add-playlist-button");
const spanClosePlaylistModal = document.getElementById("close-playlist-modal-button");
const notification = document.getElementById('notification');

addPlaylistBtn.addEventListener('click',  function() {
    addPlaylistModal.style.display = "block";
});

spanClosePlaylistModal.addEventListener('click',  function() {
    addPlaylistModal.style.display = "none";
});

addPlaylistForm.addEventListener('submit', function(event) {
    event.preventDefault();

    let addPlaylistFormData = new FormData(addPlaylistForm);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/playlist', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
        addPlaylistModal.style.display = "none";
        addPlaylistForm.reset();

        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);

            if ('success' in response) {
                window.location.href = '/playlist/' + response.result.id;
            } else {
                notification.textContent = "An error occurred when adding new playlist.";
                notification.classList.add("notification-error");

                setTimeout(function() {
                    notification.textContent = "";
                    notification.classList.remove( "notification-error");
                }, 3000);
            }
        }
    };

    xhr.send(addPlaylistFormData);
});
