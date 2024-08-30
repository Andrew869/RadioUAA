let toggle=document.getElementById('toggle');
let label_toggle=document.getElementById('label_toggle');
toggle.addEventListener('change', (event)=> {
let checked=event.target.checked;
document.body.classList.toggle('dark');
if (checked==true) {
    console.log("chi  chirve")
label_toggle.innerHTML='<i class="fa-solid fa-radio"></i>';
label_toggle.style.color="white";
}else{
label_toggle.innerHTML='<i class="fa-solid fa-radio"></i>';
label_toggle.style.color="black";
}
})