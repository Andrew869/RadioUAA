let defaultTab = document.getElementById("defaultOpen");
let rows = document.getElementsByClassName('values');
let currentContent;
let currentPK;

if(localStorage.getItem('currentContent') !== null)
	ShowContent(localStorage.getItem('currentContent'));
else
	ShowContent("programa")

for (let i = 0; i < rows.length; i++) {
	rows[i].addEventListener('click', function () {
		currentPK = rows[i].querySelector('.contentId').textContent;
		window.location.href = window.location.pathname + '?' + currentContent + '=' + currentPK;
	});
}

function ShowContent(content) {
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
		// tablinks[i].className = tablinks[i].className.replace(" active", "");
		tablinks[i].classList.remove('active');
	}
	document.querySelector(`.tablinks.${content}`).classList.add("active");

	// Show the current tab, and add an "active" class to the button that opened the tab
	document.getElementById(content).style.display = "block";
	// evt.currentTarget.className += " active";

	localStorage.setItem('currentContent', content);
}