document.addEventListener('DOMContentLoaded', function(){

    function fetchDisplay(){
        const addPoemModal = document.getElementById("add-poem-modal");
        const addPoemButtonCreator = document.getElementById("add-poem-button-on-creator");
        const closeButtonModal = document.getElementById("close-add-poem-modal");
        const addPoemSubmit = document.getElementById("add-poem-submit");
        const updatePoemListModal = document.getElementById("update-poem-list-modal");
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
            button.addEventListener('click', function() {
                const poemId = this.getAttribute('data-id-delete-poem-list');
                selectedId = poemId;
                deletePoemCreator(selectedId);
            });
        });

        const updatePoemListButton = document.querySelectorAll('.update-poem-list-button');
        const submitUpdatePoemList = document.getElementById('submit-update-poem-list');
        updatePoemListButton.forEach(function(button) {
            const poemId = button.getAttribute('data-id-update-poem-list');
            button.addEventListener('click', function() {
                selectedId = poemId
                updatePoemListModal.style.display = "block";
            });

            submitUpdatePoemList.onclick = function(event) {
                event.preventDefault();
                if(selectedId){
                    updatePoemCreator(selectedId);
                    updatePoemListModal.style.display = "none";
                }
            }
        });
    }
    


    function addPoem() {
        const xhr = new XMLHttpRequest();
        let addPoemForm = document.getElementById("add-poem-form");
        let formData = new FormData(addPoemForm);

        xhr.open('POST', '/creator/addPoem', true);

        
        xhr.onload = function() {
            console.log("ini", xhr.status);
            if (xhr.status === 200) {
                console.log("masuk");
                console.log(xhr.responseText);
            } else {
                console.error('Error add poem:', xhr.statusText);
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

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send();
    }

    function updatePoemCreator(poemId) {
        const xhr = new XMLHttpRequest();
        let updatePoemListForm = document.getElementById("poem-update-list-form");
        let formData = new FormData(updatePoemListForm);
        for (const pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        xhr.open('POST', `/creator/updatePoem/${poemId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                fetchDisplay();
            } else {
                console.error('Error updating poem:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error occurred.');
        };

        xhr.send(formData);
    }

    fetchDisplay();

});