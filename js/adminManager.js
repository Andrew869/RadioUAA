const creationForm = document.getElementById('creation_form');
// const updateForm = document.getElementById('update_form');

function edit(primary_key){
    // updateForm.style.display = "initial";
    creationForm.style.display = "none";
}

function showForm(){
    creationForm.style.display = "initial";
    // updateForm.style.display = "none";
}