
document.addEventListener('DOMContentLoaded', function(){

    const imageInputPoem = document.getElementById("image-update-poem-list");
    const audioInputPoem = document.getElementById("audio-update-poem-list");

    const notification = document.getElementById('notification');
    let updatePoemListForm = document.getElementById("poem-update-list-form");
    let addPoemForm = document.getElementById("add-poem-form");

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
    const idUpdateListPoemForm = document.getElementById("id-update-list-poem-form");

    addPoemButtonCreator.addEventListener('click', function(){
        addPoemModal.style.display = "block";
    
    });

    addPoemForm.addEventListener('submit', function(event){
        event.preventDefault();
        addPoem();
        fetchDisplay();
        addPoemModal.style.display = "none";
    })   
        
    closeButtonModal.onclick = function() {
        addPoemModal.style.display = "none";
    }

    updatePoemListForm.addEventListener('submit', function(event) {
        event.preventDefault();

        updatePoemCreator(idUpdateListPoemForm.value);
        updatePoemListModal.style.display = "none";
    })

    const titleUpdatePoemListInput = document.getElementById('title-update-poem-list');
    const genreUpdatePoemListSelect = document.getElementById('genre-update-poem-list');
    const contentUpdatePoemListTextarea = document.getElementById('content-update-poem-list');


    function fetchDisplay(){
        const poemListContainer = document.getElementById('poem-list-container');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/creator/getPoems', true); 

        xhr.onload = function() {
            if (xhr.status === 200){
                const table = JSON.parse(xhr.responseText);

                poemListContainer.innerHTML = table;

                let selectedId = null;

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
                                titleUpdatePoemListInput.value = response.success['title'];
                                genreUpdatePoemListSelect.value = response.success['genre'];
                                contentUpdatePoemListTextarea.value = response.success['content'];
                                idUpdateListPoemForm.value = response.success['id'];
                            } else {
                                console.error('Error add poem:', xhr2.statusText);
                            }
                        };

                        xhr2.send();
                    });



                    closeListModal.onclick = function(event) {
                        event.preventDefault();
                        updatePoemListModal.style.display = "none";
                    }
                    
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
        let formData = new FormData(addPoemForm);

        xhr.open('POST', '/creator/addPoem', true);
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    fetchDisplay();
                    if ('success' in response) {
                        notification.textContent = "Successfully add poem information!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when add poem information.";
                        notification.classList.add("notification-error");
                    }
                    addPoemForm.reset();

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


        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        fetchDisplay();
                        notification.textContent = "Successfully delete poem information!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when deleting poem information.";
                        notification.classList.add("notification-error");
                    }
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

    async function updatePoemCreator(poemId) {
        let image_path = '';
        let audio_path = '';

        if (imageInputPoem.files.length > 0) {
            try {
                image_path = await uploadFile(imageInputPoem);
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

        if (audioInputPoem.files.length > 0) {
            try {
                audio_path = await uploadFile(audioInputPoem);
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
        let formData = new FormData(updatePoemListForm);

        let formDataObject = parseFormDataObject(formData);

        formDataObject['update-poem-image-path'] = image_path;
        formDataObject['update-poem-audio-path'] = audio_path;

        let jsonFormData = JSON.stringify(formDataObject);

        xhr.open('PUT', `/creator/updatePoem/${poemId}`, true);


        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
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

        xhr.send(jsonFormData);
    }
    

    function parseFormDataObject(formData) {
        let object = {};
        formData.forEach((value, key) => object[key] = value);
        return object;
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
    
    
    

    fetchDisplay();

});