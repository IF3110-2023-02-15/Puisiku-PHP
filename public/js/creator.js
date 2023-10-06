document.addEventListener('DOMContentLoaded', function(){
    let addPoemForm = document.getElementById("add-poem-form");
    
    const addPoemModal = document.getElementById("add-poem-modal");
    const addUserButtonCreator = document.getElementById("add-poem-button-on-creator");
    const closeButtonModal = document.getElementById("close-add-poem-modal");


    addUserButtonCreator.addEventListener('click', function(){
        console.log("mashook");
        addPoemModal.style.display = "block";
    
    });

    closeButtonModal.onclick = function() {
        addPoemModal.style.display = "none";
    }


    function addModal() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `/creator/getModal`, true);
        xhr.onload = function(){
            if(xhr.status === 200){
                console.log(xhr.responseText);
            } else {
                console.error('Error add modal:', xhr.statusText);
            }
        }
        xhr.onerror = function(){
            console.error('Network error occured.');
        }
        xhr.send();
    }

});