document.addEventListener('DOMContentLoaded', function() {
    function fetchAndDisplayUsers() {
        const userContainer = document.getElementById('users-container');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/admin/getUsers', true); 
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                // console.log(xhr.responseText);
                const users = JSON.parse(xhr.responseText);
                // console.log(users);
                
                userContainer.innerHTML = users;

                const deleteButtons = document.querySelectorAll('.delete-user-button');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = button.getAttribute('data-user-id');
    
                        deleteUser(userId);
                    });
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

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                fetchAndDisplayUsers();
            } else {
                console.error('Error deleting user:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    // Similar functions for fetching and displaying poems and playlists
    function fetchAndDisplayPoems() {
        const poemsContainer = document.getElementById('poems-container');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/admin/getPoems', true); 
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const poems = JSON.parse(xhr.responseText);
                
                // Set the innerHTML of the userContainer
                poemsContainer.innerHTML = poems;

                const deleteButtons = document.querySelectorAll('.delete-user-button');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const poemId = button.getAttribute('data-user-id');
    
                        deletePoem(poemId);
                    });
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
                fetchAndDisplayPoems();
            } else {
                console.error('Error deleting Poem:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    function fetchAndDisplayPlaylists() {
        const playlistsContainer = document.getElementById('playlists-container');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/admin/getPlaylists', true); 
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const playlists = JSON.parse(xhr.responseText);
                
                playlistsContainer.innerHTML = playlists;
                const deleteButtons = document.querySelectorAll('.delete-user-button');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const playlistId = button.getAttribute('data-user-id');
    
                        deletePlaylist(playlistId);
                    });
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
        xhr.open('DELETE', `/admin/deleteUser/${playlistId}`, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
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

    // Call the functions to fetch and display data for users, poems, and playlists
    fetchAndDisplayUsers();
    fetchAndDisplayPoems();
    fetchAndDisplayPlaylists();
});
