let toggle=document.getElementById('toggle');
let label_toggle=document.getElementById('label_toggle');
let body = document.getElementById('mainBody');

toggle.addEventListener('change', (event)=> {
    let checked = event.target.checked;
    if (checked) {
        console.log("chi  chirve")
        label_toggle.innerHTML='<i class="fa-regular fa-sun"></i>';
        label_toggle.style.color="white";
        body.className = "dark";
    }else{
        label_toggle.innerHTML='<i class="fa-solid fa-moon"></i>';
        label_toggle.style.color="black";
        body.className = "white";
    }
})