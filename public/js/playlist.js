function uploadFile(fileInputElement, url = '/file') {
    return new Promise((resolve, reject) => {
        // Create a new FormData instance
        let formData = new FormData();

        // Add the file to the FormData instance
        formData.append('file', fileInputElement.files[0]);

        // Create a new XMLHttpRequest
        let xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', url , true);

        // Set up handlers for the request
        xhr.onload = function() {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                if (response.success) {
                    resolve(response.success);
                } else {
                    reject('Error: ' + xhr.responseText);
                }
            } else {
                reject('Request failed with status ' + xhr.status);
            }
        };

        xhr.send(formData);
    });
}

function parseFormDataObject(formData) {
    let object = {};
    formData.forEach((value, key) => object[key] = value);
    return object;
}

document.addEventListener('DOMContentLoaded', function() {
    const playlistNotification = document.getElementById('playlist-notification');
    const information = document.getElementById('information');
    const playlistId = information.dataset.playlistId;

    // Clickable Row
    const clickableRows = document.querySelectorAll('.clickable-row');

    clickableRows.forEach(function(row) {
        row.addEventListener('click', function() {
            window.location.href = row.getAttribute('data-href');
        });
    });


    // Edit Playlist Modal
    const editPlaylistBtn = document.getElementById('edit-playlist');
    const editPlaylistModal = document.getElementById('edit-playlist-modal');
    const closeModalBtn = document.getElementById('edit-playlist-close-button');
    const editPlaylistImg = document.getElementById('edit-playlist-img');
    const editPlaylistForm = document.getElementById('edit-playlist-form');
    const editPlaylistInputImg = document.getElementById('edit-playlist-image-input');

    editPlaylistInputImg.addEventListener('change', function(e) {
        let reader = new FileReader();

        reader.onload = function(event) {
            editPlaylistImg.src = event.target.result;
        }

        reader.readAsDataURL(e.target.files[0]);
    });

    closeModalBtn.addEventListener('click', function() {
        editPlaylistModal.style.display = 'none';
    });

    editPlaylistBtn.addEventListener('click', function() {
        editPlaylistModal.style.display = 'block';
    });

    editPlaylistForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const updatePlaylistConfirmationModal = document.getElementById('update-playlist-confirmation-modal');
        const updatePlaylistCloseBtn = document.getElementById('update-playlist-close-button');
        const updatePlaylistYesBtn = document.getElementById('update-playlist-yes-button');
        const updatePlaylistNoBtn = document.getElementById('update-playlist-no-button');

        updatePlaylistConfirmationModal.style.display = 'block';

        updatePlaylistCloseBtn.addEventListener('click', function() {
            updatePlaylistConfirmationModal.style.display = 'none';
        })

        updatePlaylistYesBtn.addEventListener('click', async function() {
            updatePlaylistConfirmationModal.style.display = 'none';
            editPlaylistModal.style.display = 'none';

            let image_path = '';

            if (editPlaylistInputImg.files.length > 0) {
                try {
                    image_path = await uploadFile(editPlaylistInputImg);
                } catch (error) {
                    playlistNotification.textContent = "Failed to upload file!";
                    playlistNotification.classList.add("notification-error");

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-error");
                    }, 2000);

                    return;
                }
            }

            let formData = new FormData(editPlaylistForm);
            let formDataObject = parseFormDataObject(formData);

            formDataObject['playlist-image'] = image_path;

            let jsonFormData = JSON.stringify(formDataObject);

            let xhr = new XMLHttpRequest();
            xhr.open('PUT', '/playlist/' + playlistId, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);

                    if ('success' in response) {
                        location.reload();
                    } else {
                        notification.textContent = "An error occurred when updating playlist.";
                        notification.classList.add("notification-error");

                        setTimeout(function() {
                            notification.textContent = "";
                            notification.classList.remove( "notification-error");
                        }, 3000);
                    }
                }
            }

            xhr.send(jsonFormData);
        });

        updatePlaylistNoBtn.addEventListener('click', function() {
            updatePlaylistConfirmationModal.style.display = 'none';
        })
    });


    // Delete Playlist
    const deletePlaylistConfirmationModal = document.getElementById('delete-playlist-confirmation-modal');
    const deletePlaylistCloseBtn = document.getElementById('delete-playlist-close-button');
    const deletePlaylistYesBtn = document.getElementById('delete-playlist-yes-button');
    const deletePlaylistNoBtn = document.getElementById('delete-playlist-no-button');
    const deletePlaylistBtn = document.getElementById('delete-playlist');

    deletePlaylistBtn.addEventListener('click', function() {
        deletePlaylistConfirmationModal.style.display = 'block';
    });

    deletePlaylistCloseBtn.addEventListener('click', function() {
        deletePlaylistConfirmationModal.style.display = 'none';
    })

    deletePlaylistYesBtn.addEventListener('click', function() {
        deletePlaylistConfirmationModal.style.display = 'none';

        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/playlist/' + playlistId, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                if ('success' in response) {
                    window.location.href = '/';
                } else {
                    notification.textContent = "An error occurred when deleting playlist.";
                    notification.classList.add("notification-error");

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove( "notification-error");
                    }, 3000);
                }
            }
        }

        xhr.send();
    });

    deletePlaylistNoBtn.addEventListener('click', function() {
        deletePlaylistConfirmationModal.style.display = 'none';
    })
});