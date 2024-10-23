let currenBtn;

function DropdownShow(btn) {
    currenBtn = btn;
    currenBtn.classList.toggle('dropdown__button-active');
    let user_options = document.getElementById("user_options");
    user_options.classList.toggle('show');
}

window.onclick = function (event) {
    if (!event.target.matches('.dropdown__button')) {
        var dropdowns = document.getElementsByClassName("dropdown__content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
                currenBtn.classList.remove('dropdown__button-active');
            }
        }
    }
} 