document.addEventListener('DOMContentLoaded', function(){

    const notification = document.getElementById('notification');
    let updatePoemListForm = document.getElementById("poem-update-list-form");

    function fetchDisplay(){
        const poemListContainer = document.getElementById('poem-list-container');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/creator/getPoems', true); 

        xhr.onload = function() {
            if (xhr.status === 200){
                const table = JSON.parse(xhr.responseText);

                poemListContainer.innerHTML = table;
                const addPoemModal = document.getElementById("add-poem-modal");
                const addPoemButtonCreator = document.getElementById("add-poem-button-on-creator");
                const closeButtonModal = document.getElementById("close-add-poem-modal");
                const closeListModal = document.getElementById("close-poem-list-modal");
                const addPoemSubmit = document.getElementById("add-poem-submit");
                const updatePoemListModal = document.getElementById("update-poem-list-modal");
                const confirmationDeletePoemModal = document.getElementById("confirmation-modal-poem-list");
                const closeButtonDelete = document.getElementById("close-button-poem-list");
                const confirmDeleteButton = document.getElementById("confirm-delete-poem-list");
                const cancelDeleteButton = document.getElementById("cancel-delete-poem-list");
                const confirmationModalTextDeletePoemList = document.getElementById("confirmation-modal-text-poem-list");

                let selectedId = null;

                addPoemButtonCreator.addEventListener('click', function(){
                    console.log("mashook");
                    addPoemModal.style.display = "block";
                
                });

                addPoemSubmit.onclick = function(event) {
                    event.preventDefault();
                    addPoem();
                    addPoemModal.style.display = "none";
                }

                closeButtonModal.onclick = function() {
                    addPoemModal.style.display = "none";
                }

                const deletePoemList = document.querySelectorAll('.delete-poem-list-button');
                deletePoemList.forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const poemId = this.getAttribute('data-id-delete-poem-list');
                        const titlePoem = this.getAttribute('data-title-delete-poem-list');
                        confirmationModalTextDeletePoemList.textContent = `Are you sure to delete ${titlePoem}?`;
                        confirmationDeletePoemModal.style.display = "block";
                        selectedId = poemId;
                        
                    });

                    closeButtonDelete.onclick = function() {
                        confirmationDeletePoemModal.style.display = "none";
                    }

                    confirmDeleteButton.onclick = function(event) {
                        event.preventDefault();
                        if(selectedId){
                            deletePoemCreator(selectedId);
                            confirmationDeletePoemModal.style.display = "none";
                        }
                    }

                    cancelDeleteButton.onclick = function() {
                        confirmationDeletePoemModal.style.display = "none";
                    }
                });


                const titleUpdatePoemListInput = document.getElementById('title-update-poem-list');
                const genreUpdatePoemListSelect = document.getElementById('genre-update-poem-list');
                const contentUpdatePoemListTextarea = document.getElementById('content-update-poem-list');

                const updatePoemListButton = document.querySelectorAll('.update-poem-list-button');
                const submitUpdatePoemList = document.getElementById('submit-update-poem-list');
                updatePoemListButton.forEach(function(button) {
                    const poemId = button.getAttribute('data-id-update-poem-list');
                    button.addEventListener('click', function() {
                        selectedId = poemId;
                        updatePoemListModal.style.display = "block";

                        const xhr2 = new XMLHttpRequest();

                        xhr2.open('GET', `/creator/getPoemData/${poemId}`, true);
                        
                        xhr2.onload = function() {
                            if (xhr2.status === 200) {
                                let response = JSON.parse(xhr2.responseText);
                                console.log(response);
                                titleUpdatePoemListInput.value = response.success['title'];
                                genreUpdatePoemListSelect.value = response.success['genre'];
                                contentUpdatePoemListTextarea.value = response.success['content']
                                console.log("yang mau dicek", xhr2.responseText);
                            } else {
                                console.error('Error add poem:', xhr2.statusText);
                            }
                        };

                        xhr2.send();
                    });

                    // submitUpdatePoemList.addEventListener = function(event) {
                    //     event.preventDefault();
                    //     if(selectedId){
                    //         updatePoemCreator(selectedId);
                    //         updatePoemListModal.style.display = "none";
                    //     }
                    // }

                    updatePoemListForm.addEventListener('submit', function(event) {
                        event.preventDefault();
                        console.log("kesubmit");
                    })

                    closeListModal.onclick = function(event) {
                        event.preventDefault();
                        updatePoemListModal.style.display = "none";
                    }

                    window.addEventListener('click', function(event) {
                        if (event.target === updatePoemListModal) {
                            updatePoemListModal.style.display = "none";
                        }
                    });
                });
            }
        }
        xhr.onerror = function() {
            console.error('Network error occurred.');
        };
        
        xhr.send();
    }
    
    

    function addPoem() {
        const xhr = new XMLHttpRequest();
        let addPoemForm = document.getElementById("add-poem-form");
        let formData = new FormData(addPoemForm);

        xhr.open('POST', '/creator/addPoem', true);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                fetchDisplay();
                console.log(xhr.responseText);
            } else {
                console.error('Error add poem:', xhr.statusText);
            }
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully add poem information!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when add poem information.";
                        notification.classList.add("notification-error");
                    }
                    // Show the notification for 3 seconds
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
        xhr.send(formData);

    }

    function deletePoemCreator(poemId) {
        const xhr = new XMLHttpRequest();
        xhr.open('DELETE', `/creator/deletePoem/${poemId}`, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                fetchDisplay();
            } else {
                console.error('Error deleting Poem:', xhr.statusText);
            }
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully delete poem information!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when deleting poem information.";
                        notification.classList.add("notification-error");
                    }
                    // Show the notification for 3 seconds
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

    function updatePoemCreator(poemId) {
        const xhr = new XMLHttpRequest();
        let formData = new FormData(updatePoemListForm);
        for (const pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        xhr.open('POST', `/creator/updatePoem/${poemId}`, true);
        // xhr.onload = function() {
        //     if (xhr.status === 200) {
        //         console.log(xhr.responseText);
        //         fetchDisplay();
        //     } else {
        //         console.error('Error updating poem:', xhr.statusText);
        //     }
        // };

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    console.log(xhr.responseText);
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        fetchDisplay();
                        notification.textContent = "Successfully update poem information!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when updating poem information.";
                        notification.classList.add("notification-error");
                    }
                    // Show the notification for 3 seconds
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

        xhr.send(formData);
    }

    fetchDisplay();

});