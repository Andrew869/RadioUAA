// export function ManagePrograms(){
//     document.
// }
// document.addEventListener("DOMContentLoaded", function() {
// let img1 = document.getElementById('image1');
// let img2 = document.getElementById('image2');

// function loaded1() {
//     console.log('loaded1')
// }

// function loaded2() {
//     console.log('loaded2')
// }

// if (img1.complete) {
//     loaded1()
// } else {
//     img1.addEventListener('load', loaded1)
//     img1.addEventListener('error', function () {
//         console.log('error')
//     })
// }

// if (img2.complete) {
//     loaded2()
// } else {
//     img2.addEventListener('load', loaded2)
//     img2.addEventListener('error', function () {
//         console.log('error')
//     })
// }

// });

// window.onload = function () {

//     let img1 = document.getElementById('image1');

//     img1.onload = function () {
//         console.log("The image has loaded!");		
//     };

//     setTimeout(function(){
//         img1.src = 'resources/uploads/img/programa_103[v0]';         
//     }, 5000);
// };

export function IsSticky(){
    console.log("amIhere");
    window.addEventListener('scroll', function() {
        const thead = document.querySelector('thead');
        const isSticky = thead.getBoundingClientRect().top <= 60;
        const top_Left = document.querySelector('thead > tr:first-child th:first-child');
        const top_right = document.querySelector('thead > tr:first-child th:last-child');

        if (isSticky) {
            // console.log('El encabezado está en modo sticky.');
            top_Left.style.borderRadius = "0";
            top_right.style.borderRadius = "0";
        } else {
            // console.log('El encabezado ya no está en modo sticky.');
            top_Left.style.borderRadius = "12px 0 0 0";
            top_right.style.borderRadius = "0 12px 0 0";
        }
    });
}