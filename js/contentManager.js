let defaultTab = document.getElementById("defaultOpen");
let rows = document.getElementsByClassName('values');
let currentContent;
let currentPK;

for (let i = 0; i < rows.length; i++) {
	rows[i].addEventListener('click', function () {
		// console.log(rows[i].querySelector('.pk').textContent);
		// console.log("Ruta (como PHP_SELF): " + window.location.pathname);
		currentPK = rows[i].querySelector('.pk').textContent;
		window.location.href = window.location.pathname + '?' + currentContent + '=' + currentPK;
	});
}

function ShowContent(evt, content) {
	// Declare all variables
	var i, tabcontent, tablinks;

	currentContent = content;

	// Get all elements with class="tabcontent" and hide them
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	// Get all elements with class="tablinks" and remove the class "active"
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	// Show the current tab, and add an "active" class to the button that opened the tab
	document.getElementById(content).style.display = "block";
	evt.currentTarget.className += " active";
}

if(defaultTab)
	defaultTab.click();

// function DeleteContent(e, content) {

// }


// Get the modal
var modal = document.getElementById("deleteModal");

// Get the button that opens the modal
var deleteBtn = document.getElementById("deleteBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var cancelBtn = document.getElementById('cancelBtn');
var confirmBtn = document.getElementById('confirmBtn');

// When the user clicks the button, open the modal 
if(deleteBtn){
	deleteBtn.onclick = function() {
	modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	modal.style.display = "none";
	}

	cancelBtn.addEventListener('click', function(){ 
		modal.style.display = 'none';
	});

	confirmBtn.addEventListener('click', deleteRecord);

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
	}
}

function deleteRecord(e) {
	currentContent = e.currentTarget.getAttribute('content');
	currentPK = e.currentTarget.getAttribute('pk');

    fetch("deleteContent.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: encodeURIComponent(currentContent) + '=' + encodeURIComponent(currentPK)
    })
    .then(response => response.text())
        .then(data => {
            // console.log("Respuesta del servidor:", data);
            // Recargar la página después de enviar los datos exitosamente
            window.location.href = window.location.pathname;
        })
        .catch(error => {
        console.error("Error:", error);
    });
}