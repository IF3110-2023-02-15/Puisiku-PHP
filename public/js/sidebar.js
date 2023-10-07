const addPlaylistForm = document.getElementById('add-playlist-form');
const addPlaylistModal = document.getElementById("add-playlist-modal");
const addPlaylistBtn = document.getElementById("add-playlist-button");
const spanClosePlaylistModal = document.getElementById("add-playlist-close-button");
const addPlaylistImg = document.getElementById('add-playlist-img');
const addPlaylistInputImg = document.getElementById('add-playlist-image-input');

const notification = document.getElementById('notification');

addPlaylistInputImg.addEventListener('change', function(e) {
    let reader = new FileReader();

    reader.onload = function(event) {
        addPlaylistImg.src = event.target.result;
    }

    reader.readAsDataURL(e.target.files[0]);
});

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

const settingsButton = document.getElementById('sidebar-settings-button');
settingsButton.addEventListener('click', function(event) {
    console.log(settingsButton);
    let h3Element = settingsButton.querySelector('h3');

    if (h3Element.innerText === 'Be a creator!') {
        const upgradeRoleConfirmationModal = document.getElementById('upgrade-role-confirmation-modal');
        const upgradeRoleCloseBtn = document.getElementById('upgrade-role-close-button');
        const upgradeRoleYesBtn = document.getElementById('upgrade-role-yes-button');
        const upgradeRoleNoBtn = document.getElementById('upgrade-role-no-button');

        upgradeRoleConfirmationModal.style.display = 'block';

        upgradeRoleCloseBtn.addEventListener('click', function() {
            upgradeRoleConfirmationModal.style.display = 'none';
        })

        upgradeRoleNoBtn.addEventListener('click', function() {
            upgradeRoleConfirmationModal.style.display= 'none';
        })

        upgradeRoleYesBtn.addEventListener('click', function() {
            upgradeRoleConfirmationModal.style.display= 'none';

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/profile/upgrade', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                let response = JSON.parse(xhr.responseText);

                if ('success' in response) {
                    window.location.href = '/';
                } else {
                    notification.textContent = 'Failed to upgrade user';
                    notification.classList.add('notification-error');

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove( "notification-error");
                    }, 3000);
                }
            }

            xhr.send()
        })
    }
})