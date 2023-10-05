document.addEventListener('DOMContentLoaded', function() {
    let updateUserForm = document.getElementById("user-update-form");
    let updatePoemForm = document.getElementById("poem-update-form");
    let updatePlaylistForm = document.getElementById("playlist-update-form");

    function fetchAndDisplayUsers() {
        const userContainer = document.getElementById('users-container');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/admin/getUsers', true); 
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const users = JSON.parse(xhr.responseText);
                
                userContainer.innerHTML = users;

                let selectedUserId = null;
                let deleteUserButton = document.querySelectorAll('.delete-user-button');
                let updateUserButton = document.querySelectorAll('.update-user-button');

                let updateUserModal = document.getElementById("update-user-modal");
                let submitUserButton = document.getElementById("update-submit");

                let confirmationUserModal = document.getElementById('confirmation-modal-user');
                let confirmationUserTextModal = document.getElementById('confirmation-modal-text-user');
                let closeUserButton = document.getElementById("close-button-user");
                let yesUserButton = document.getElementById("confirm-delete-user");
                let noUserButton = document.getElementById("cancel-delete-user");
                

                deleteUserButton.forEach(button => {
                    const userId = button.getAttribute('data-user-id');

                    button.addEventListener('click', function() {
                        console.log('keklik say');
                        console.log(userId);
                        const userName = button.getAttribute('data-username');
                        selectedUserId = userId;
                        console.log(selectedUserId);
                        confirmationUserTextModal.textContent = `Are you sure to delete ${userName}?`;
                        confirmationUserModal.style.display = "block";

                        
                    });
                    
                    closeUserButton.onclick = function() {
                        confirmationUserModal.style.display = "none";
                    }
                    
                    yesUserButton.onclick = function() {
                        console.log("yes" + selectedUserId);
                        deleteUser(selectedUserId);
                        confirmationUserModal.style.display = "none";

                    }
            
                    noUserButton.onclick = function() {
                        confirmationUserModal.style.display = "none";
                    }

                });

                updateUserButton.forEach(button => {
                    const userId = button.getAttribute('data-user-id');
                    const userRole = button.getAttribute('data-user-role');

                    button.addEventListener('click', function() {
                        updateUserModal.style.display = "block";
                        selectedUserId = userId;

                        const upgradeToCreatorRadio = document.getElementById('update-role-creator');
                        const updateRadiobuttonText = document.getElementById('update-radiobutton-text');
                        if (userRole === 'user') {
                            upgradeToCreatorRadio.style.display = 'inline-block';
                            updateRadiobuttonText.style.display = 'inline block';
                        } else {
                            upgradeToCreatorRadio.style.display = 'none';
                            updateRadiobuttonText.style.display = 'none';
                        }

                    });

                    submitUserButton.onclick = function(event) {
                        event.preventDefault();
                        if(selectedUserId){
                            updateUser(selectedUserId);
                            updateUserModal.style.display = "none";
                        }
                    }

                });
            } else {
                console.error('Error fetching user data:', xhr.statusText);
            }
        };
        
        xhr.onerror = function() {
            console.error('Network error occurred.');
        };
        
        xhr.send();
    }

    function deleteUser(userId) {
        console.log(userId);
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', `/admin/deleteUser/${userId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                fetchAndDisplayUsers();
                fetchAndDisplayPoems();
                fetchAndDisplayPlaylists();
            } else {
                console.error('Error deleting user:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    function updateUser(userId) {
        const xhr = new XMLHttpRequest();
        let formData = new FormData(updateUserForm);
        for (const pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        console.log('========')
        xhr.open('POST', `/admin/updateUser/${userId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                fetchAndDisplayUsers();
                fetchAndDisplayPoems();
                fetchAndDisplayPlaylists();
            } else {
                console.error('Error deleting user:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send(formData);
    }
    
    function fetchAndDisplayPoems(id) {
        const poemsContainer = document.getElementById('poems-container');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `/admin/getPoems/${id}`, true); 
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const poems = JSON.parse(xhr.responseText);
                
                poemsContainer.innerHTML = poems;

                let selectedPoemId = null;
                const deletePoemButton = document.querySelectorAll('.delete-poem-button');
                const updatePoemButton = document.querySelectorAll('.update-poem-button');

                let updatePoemModal = document.getElementById("update-poem-modal");
                let submitPoemButton = document.getElementById("submit-update-poem");

                const confirmationPoemModal = document.getElementById('confirmation-modal-poem');
                const confirmationPoemModalText = document.getElementById('confirmation-modal-text-poem');
                let closeUserButton = document.getElementById("close-button-poem");
                let yesPoemButton = document.getElementById("confirm-delete-poem");
                let noPoemButton = document.getElementById("cancel-delete-poem");
                

                deletePoemButton.forEach(button => {
                    button.addEventListener('click', function() {
                        const userName = button.getAttribute('data-poem-title');

                        confirmationPoemModalText.textContent = `Are you sure to delete ${userName}?`;
                        confirmationPoemModal.style.display = "block";
                        console.log("Ini poem id nya ",poemId);
                        selectedPoemId = poemId;

                        
                    });
                    const poemId = button.getAttribute('data-poem-id');

                    closeUserButton.onclick = function() {
                        confirmationPoemModal.style.display = "none";
                    }
            
                    yesPoemButton.onclick = function() {
                        deletePoem(selectedPoemId);
                        console.log("Ini poem id nya ",poemId);
                        confirmationPoemModal.style.display = "none";
                    }
            
                    noPoemButton.onclick = function() {
                        confirmationPoemModal.style.display = "none";
                    }

                });

                updatePoemButton.forEach(button => {
                    console.log("update poem button");
                    const poemId = button.getAttribute('data-poem-id');
                    const userName = button.getAttribute('data-poem-title');

                    button.addEventListener('click', function() {
                        updatePoemModal.style.display = "block";
                        selectedPoemId = poemId;

                    });

                    submitPoemButton.onclick = function(event) {
                        event.preventDefault();
                        if(selectedPoemId){
                            updatePoem(selectedPoemId);
                            updatePoemModal.style.display = "none";
                        }
                    }

                });
            } else {
                console.error('Error fetching user data:', xhr.statusText);
            }
        };
        
        xhr.onerror = function() {
            console.error('Network error occurred.');
        };
        
        xhr.send();
    }

    function deletePoem(poemId) {
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', `/admin/deletePoem/${poemId}`, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                fetchAndDisplayUsers();
                fetchAndDisplayPoems();
                fetchAndDisplayPlaylists();
            } else {
                console.error('Error deleting Poem:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    function updatePoem(poemId) {
        const xhr = new XMLHttpRequest();
        let formData = new FormData(updatePoemForm);
        for (const pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        xhr.open('POST', `/admin/updatePoem/${poemId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                fetchAndDisplayUsers();
                fetchAndDisplayPoems();
                fetchAndDisplayPlaylists();
            } else {
                console.error('Error updating poem:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send(formData);
    }

    function fetchAndDisplayPlaylists(id) {
        const playlistsContainer = document.getElementById('playlists-container');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `/admin/getPlaylists/${id}`, true); 
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const playlists = JSON.parse(xhr.responseText);
                
                playlistsContainer.innerHTML = playlists;

                let selectedPlaylistId = null;

                const deletePlaylistButton = document.querySelectorAll('.delete-playlist-button');
                const updatePlaylistButton = document.querySelectorAll('.update-playlist-button');

                //update button
                const updatePlaylistModal = document.getElementById("update-playlist-modal");
                const submitPlaylistButton = document.getElementById("submit-update-playlist");

                //delete button
                const confirmationPlaylistModal = document.getElementById('confirmation-modal-playlist');
                const confirmationPlaylistModalText = document.getElementById('confirmation-modal-text-playlist');
                let closePlaylistButton = document.getElementById("close-button-playlist");
                let yesPlaylistButton = document.getElementById("confirm-delete-playlist");
                let noPlaylistButton = document.getElementById("cancel-delete-playlist");
                

                deletePlaylistButton.forEach(button => {
                    button.addEventListener('click', function() {
                        const userName = button.getAttribute('data-playlist-title');
                        const playlistId = button.getAttribute('data-playlist-id');
                        selectedPlaylistId = playlistId;
                        confirmationPlaylistModalText.textContent = `Are you sure to delete ${userName}?`;
                        confirmationPlaylistModal.style.display = "block";
                        
                    });

                    closePlaylistButton.onclick = function() {
                        confirmationPlaylistModal.style.display = "none";
                    }
            
                    yesPlaylistButton.onclick = function() {
                        deletePlaylist(selectedPlaylistId);
                        confirmationPlaylistModal.style.display = "none";
                    }
            
                    noPlaylistButton.onclick = function() {
                        confirmationPlaylistModal.style.display = "none";
                    }
                });

                updatePlaylistButton.forEach(button => {
                    const playlistId = button.getAttribute('data-playlist-id');
                    const userName = button.getAttribute('data-playlist-title');

                    button.addEventListener('click', function() {
                        updatePlaylistModal.style.display = "block";
                        selectedPlaylistId = playlistId;

                        const playlistStatus = button.getAttribute('data-playlist-status');
                        const statusPublicButton = document.getElementById('status-public-update-playlist');
                        const statusPrivateButton = document.getElementById('status-private-update-playlist');
                        const statusPublicText = document.getElementById('update-radiobutton-text-public-playlist');
                        const statusPrivateText = document.getElementById('update-radiobutton-text-private-playlist');

                        console.log("ini status playlist :", playlistStatus);
                        if (playlistStatus == 0) {
                            statusPrivateButton.style.display = 'inline-block';
                            statusPrivateText.style.display = 'inline block';
                            statusPublicButton.style.display = 'none';
                            statusPublicText.style.display = 'none';
                        } else if (playlistStatus == 1) {
                            statusPrivateButton.style.display = 'none';
                            statusPrivateText.style.display = 'none';
                            statusPublicButton.style.display = 'inline-block';
                            statusPublicText.style.display = 'inline-block';
                        } 

                    });

                    submitPlaylistButton.onclick = function(event) {
                        event.preventDefault();
                        if(selectedPlaylistId){
                            updatePlaylist(selectedPlaylistId);
                            updatePlaylistModal.style.display = "none";
                        }
                    }

                });
            } else {
                console.error('Error fetching user data:', xhr.statusText);
            }
        };
        
        xhr.onerror = function() {
            console.error('Network error occurred.');
        };
        
        xhr.send();
    }

    function deletePlaylist(playlistId) {
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', `/admin/deletePlaylist/${playlistId}`, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                fetchAndDisplayUsers();
                fetchAndDisplayPoems();
                fetchAndDisplayPlaylists();
            } else {
                console.error('Error deleting playlist:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    function updatePlaylist(playlistId) {
        const xhr = new XMLHttpRequest();
        let formData = new FormData(updatePlaylistForm);
        for (const pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        xhr.open('POST', `/admin/updatePlaylist/${playlistId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                fetchAndDisplayUsers();
                fetchAndDisplayPoems();
                fetchAndDisplayPlaylists();
            } else {
                console.error('Error updating poem:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send(formData);
    }

    fetchAndDisplayUsers();
    fetchAndDisplayPoems();
    fetchAndDisplayPlaylists();
});
