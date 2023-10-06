document.addEventListener('DOMContentLoaded', function(){

    function fetchDisplay(){
        const addPoemModal = document.getElementById("add-poem-modal");
        const addPoemButtonCreator = document.getElementById("add-poem-button-on-creator");
        const closeButtonModal = document.getElementById("close-add-poem-modal");
        const addPoemSubmit = document.getElementById("add-poem-submit");


        addPoemButtonCreator.addEventListener('click', function(){
            console.log("mashook");
            addPoemModal.style.display = "block";
        
        });

        addPoemSubmit.onclick = function() {
            addPoem();
            addPoemModal.style.display = "none";
        }

        closeButtonModal.onclick = function() {
            addPoemModal.style.display = "none";
        }
    }
    
    

    function addPoem() {
        const xhr = new XMLHttpRequest();
        let addPoemForm = document.getElementById("add-poem-form");
        let formData = new FormData(addPoemForm);

        xhr.open('POST', `/creator`, true);

        
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

    fetchDisplay();

});