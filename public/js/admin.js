document.addEventListener('DOMContentLoaded', function() {
    let updateUserForm = document.getElementById("user-update-form");
    let updatePoemForm = document.getElementById("poem-update-form");
    let updatePlaylistForm = document.getElementById("playlist-update-form");

    let updateImageUser = document.getElementById("update-image");
    let updateImagePoem = document.getElementById("image-update-poem");
    let updateAudioPoem = document.getElementById("audio-update-poem");
    let updateImagePlaylist = document.getElementById("image-update-playlist");

    const idUpdateUserForm = document.getElementById("id-update-user-form");
    const idUpdatePoemForm = document.getElementById("id-update-poem-form");
    const idUpdatePlaylistForm = document.getElementById("id-update-playlist-form");

    let updateUserModal = document.getElementById("update-user-modal");
    const notification = document.getElementById('notification');

    updateUserForm.addEventListener('submit', function(event) {
        event.preventDefault();
        updateUser(idUpdateUserForm.value);
        updateUserModal.style.display = "none";
    })

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

                
                let submitUserButton = document.getElementById("update-submit");
                let closeButtonUpdateUser = document.getElementById("update-close-button");

                let confirmationUserModal = document.getElementById('confirmation-modal-user');
                let confirmationUserTextModal = document.getElementById('confirmation-modal-text-user');
                let closeUserButton = document.getElementById("close-button-user");
                let yesUserButton = document.getElementById("confirm-delete-user");
                let noUserButton = document.getElementById("cancel-delete-user");
                

                deleteUserButton.forEach(button => {
                    const userId = button.getAttribute('data-user-id');

                    button.addEventListener('click', function() {
                        const userName = button.getAttribute('data-username');
                        selectedUserId = userId;
                        confirmationUserTextModal.textContent = `Are you sure to delete ${userName}?`;
                        confirmationUserModal.style.display = "block";

                        
                    });
                    
                    closeUserButton.onclick = function() {
                        confirmationUserModal.style.display = "none";
                    };
                    
                    yesUserButton.onclick = function() {
                        deleteUser(selectedUserId);
                        confirmationUserModal.style.display = "none";

                    };
            
                    noUserButton.onclick = function() {
                        confirmationUserModal.style.display = "none";
                    };

                });

                const updateUserName = document.getElementById("update-username");
                const updateDescription = document.getElementById("update-description");
    
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
                        };

                        const xhr2 = new XMLHttpRequest();

                        xhr2.open('GET', `/admin/getUserData/${selectedUserId}`, true);
                        
                        xhr2.onload = function() {
                            if (xhr2.status === 200) {
                                let response = JSON.parse(xhr2.responseText);
                                updateUserName.value = response.success['username'];
                                updateDescription.value = response.success['description'];
                                idUpdateUserForm.value = selectedUserId;
                            } else {
                                console.error('Error add poem:', xhr2.statusText);
                            };
                        };

                        xhr2.send();

                    });

                    closeButtonUpdateUser.onclick = function(event) {
                        event.preventDefault();
                        updateUserModal.style.display = "none";
                    };

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
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', `/admin/deleteUser/${userId}`, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully deleting user!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when delete user information.";
                        notification.classList.add("notification-error");
                    }
                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-success", "notification-error");
                    }, 2000);
                }
            }
        };

        fetchAndDisplayUsers();
        fetchAndDisplayPoems();
        fetchAndDisplayPlaylists();


        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    async function updateUser(userId) {
        let image_path_user = '';

        if (updateImageUser.files.length > 0) {
            try {
                image_path_user = await uploadFile(updateImageUser);
            } catch (error) {
                notification.textContent = "Failed to upload file!";
                notification.classList.add("notification-error");

                setTimeout(function() {
                    notification.textContent = "";
                    notification.classList.remove("notification-error");
                }, 2000);

                return;
            }
        }


        const xhr = new XMLHttpRequest();
        let formData = new FormData(updateUserForm);

        let formDataObject = parseFormDataObject(formData);

        formDataObject['update-user-image-path'] = image_path_user;

        let jsonFormData = JSON.stringify(formDataObject);

        xhr.open('PUT', `/admin/updateUser/${userId}`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    
                    let response = JSON.parse(xhr.responseText);
                    
                    if ('success' in response) {
                        notification.textContent = "Successfully updating user!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when update user information.";
                        notification.classList.add("notification-error");
                    }
                    

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-success", "notification-error");
                    }, 2000);
                }
            }
        };

        fetchAndDisplayUsers();
        fetchAndDisplayPoems();
        fetchAndDisplayPlaylists();

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send(jsonFormData);
    }

    let updatePoemModal = document.getElementById("update-poem-modal");

    updatePoemForm.addEventListener('submit', function(event) {
        event.preventDefault();

            updatePoem(idUpdatePoemForm.value);
            updatePoemModal.style.display = "none";

    })
    
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

                
                let submitPoemButton = document.getElementById("submit-update-poem");
                let closePoemModal = document.getElementById("close-poem-modal");

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
                        selectedPoemId = poemId;

                        
                    });
                    const poemId = button.getAttribute('data-poem-id');

                    closeUserButton.onclick = function() {
                        confirmationPoemModal.style.display = "none";
                    }
            
                    yesPoemButton.onclick = function() {
                        deletePoem(selectedPoemId);
                        confirmationPoemModal.style.display = "none";
                    }
            
                    noPoemButton.onclick = function() {
                        confirmationPoemModal.style.display = "none";
                    }

                });
                
                const titleUpdatePoem = document.getElementById("title-update-poem");
                const genreUpdatePoem = document.getElementById("genre-update-poem");
                const contentUpdatePoem = document.getElementById("content-update-poem");
                updatePoemButton.forEach(button => {
                    const poemId = button.getAttribute('data-poem-id');
                    const userName = button.getAttribute('data-poem-title');

                    button.addEventListener('click', function() {
                        updatePoemModal.style.display = "block";
                        selectedPoemId = poemId;

                        const xhr2 = new XMLHttpRequest();

                        xhr2.open('GET', `/creator/getPoemData/${poemId}`, true);
                        
                        xhr2.onload = function() {
                            if (xhr2.status === 200) {
                                let response = JSON.parse(xhr2.responseText);
                                titleUpdatePoem.value = response.success['title'];
                                genreUpdatePoem.value = response.success['genre'];
                                contentUpdatePoem.value = response.success['content'];
                                idUpdatePoemForm.value = response.success['id'];
                            } else {
                                console.error('Error add poem:', xhr2.statusText);
                            }
                        };

                        xhr2.send();

                    });

                    

                    closePoemModal.onclick = function(event) {
                        event.preventDefault();
                        updatePoemModal.style.display = "none";
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

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully deleting poem!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when delete poem information.";
                        notification.classList.add("notification-error");
                    }
                    fetchAndDisplayUsers();
                    fetchAndDisplayPoems();
                    fetchAndDisplayPlaylists();

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-success", "notification-error");
                    }, 2000);
                }
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    async function updatePoem(poemId) {
        let image_path_poem = '';
        let audio_path_poem = '';

        if (updateImagePoem.files.length > 0) {
            try {
                image_path_poem = await uploadFile(updateImagePoem);
            } catch (error) {
                notification.textContent = "Failed to upload file!";
                notification.classList.add("notification-error");

                setTimeout(function() {
                    notification.textContent = "";
                    notification.classList.remove("notification-error");
                }, 2000);

                return;
            }
        }

        if (updateAudioPoem.files.length > 0) {
            try {
                audio_path_poem = await uploadFile(updateAudioPoem);
            } catch (error) {
                notification.textContent = "Failed to upload file!";
                notification.classList.add("notification-error");

                setTimeout(function() {
                    notification.textContent = "";
                    notification.classList.remove("notification-error");
                }, 2000);

                return;
            }
        }

        const xhr = new XMLHttpRequest();
        let formData = new FormData(updatePoemForm);

        let formDataObject = parseFormDataObject(formData);

        formDataObject['update-poem-admin-image-path'] = image_path_poem;
        formDataObject['update-poem-admin-audio-path'] = audio_path_poem;

        let jsonFormData = JSON.stringify(formDataObject);
        

        xhr.open('PUT', `/admin/updatePoem/${poemId}`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully updating poem!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when update poem information.";
                        notification.classList.add("notification-error");
                    }
                    fetchAndDisplayUsers();
                    fetchAndDisplayPoems();
                    fetchAndDisplayPlaylists();

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-success", "notification-error");
                    }, 2000);
                }
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send(jsonFormData);
    }

    function fetchAndDisplayPlaylists() {
        const playlistsContainer = document.getElementById('playlists-container');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `/admin/getPlaylists`, true); 

        xhr.onload = function() {
            if (xhr.status === 200) {
                const playlists = JSON.parse(xhr.responseText);
                
                playlistsContainer.innerHTML = playlists;

                let selectedPlaylistId = null;

                const deletePlaylistButton = document.querySelectorAll('.delete-playlist-button');
                const updatePlaylistButton = document.querySelectorAll('.update-playlist-button');

                //update button
                const updatePlaylistModal = document.getElementById("update-playlist-modal");
                let submitPlaylistButton = document.getElementById("submit-playlist-poem");
                const spanClosePlaylistModal = document.getElementById("close-playlist-modal");

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

                const titleUpdatePlaylist = document.getElementById("title-update-playlist")
                updatePlaylistButton.forEach(button => {
                    const playlistId = button.getAttribute('data-playlist-id');
                    const userName = button.getAttribute('data-playlist-title');

                    button.addEventListener('click', function() {
                        
                        selectedPlaylistId = playlistId;
                        
                        updatePlaylistModal.style.display = "block";

                        const xhr2 = new XMLHttpRequest();

                        xhr2.open('GET', `/admin/getPlaylistData/${playlistId}`, true);
                        
                        xhr2.onload = function() {
                            if (xhr2.status === 200) {
                                let response = JSON.parse(xhr2.responseText);
                                idUpdatePlaylistForm.value = selectedPlaylistId;
                                titleUpdatePlaylist.value = response.success['title'];
                            } else {
                                console.error('Error add poem:', xhr2.statusText);
                            }
                        }

                        xhr2.send();
                    });

                    updatePlaylistForm.addEventListener('submit', function() {
                        updatePlaylist(idUpdatePlaylistForm);
                        updatePlaylistModal.style.display = "none";
                        
                    })

                    spanClosePlaylistModal.onclick = function(event) {
                        event.preventDefault();
                        updatePlaylistModal.style.display = "none";
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

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully deleting playlist!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when delete playlist information.";
                        notification.classList.add("notification-error");
                    }
                    fetchAndDisplayUsers();
                    fetchAndDisplayPoems();
                    fetchAndDisplayPlaylists();

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-success", "notification-error");
                    }, 2000);
                }
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    async function updatePlaylist(playlistId) {
        let image_path_playlist = '';

        if (updateImagePlaylist.files.length > 0) {
            try {
                image_path_playlist = await uploadFile(updateImagePlaylist);
            } catch (error) {
                notification.textContent = "Failed to upload file!";
                notification.classList.add("notification-error");

                setTimeout(function() {
                    notification.textContent = "";
                    notification.classList.remove("notification-error");
                }, 2000);

                return;
            }
        }

        const xhr = new XMLHttpRequest();
        let formData = new FormData(updatePlaylistForm);

        let formDataObject = parseFormDataObject(formData);

        formDataObject['update-playlist-image-path'] = image_path_playlist;

        let jsonFormData = JSON.stringify(formDataObject);

        xhr.open('PUT', `/admin/updatePlaylist/${playlistId}`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully updating playlist!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when update playlist information.";
                        notification.classList.add("notification-error");
                    }
                    fetchAndDisplayUsers();
                    fetchAndDisplayPoems();
                    fetchAndDisplayPlaylists();

                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-success", "notification-error");
                    }, 2000);
                }
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send(jsonFormData);
    }

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

    fetchAndDisplayUsers();
    fetchAndDisplayPoems();
    fetchAndDisplayPlaylists();
});
