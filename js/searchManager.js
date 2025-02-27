document.addEventListener("DOMContentLoaded", function () {

    // document.getElementById("icon-menu").addEventListener("click", toggleMenu);
    let searchBarVisible = false;
    const btnSearch = document.getElementById("button-search");
    const searchBarContent = document.getElementsByClassName("search-bar-content")[0];
    const searchBar = document.getElementsByClassName("search-bar-container")[0];
    const closeBtn = document.querySelector(".search-bar-content .close-btn");
    // const links = document.querySelectorAll('box-search li a');

    let isLink = false;

    btnSearch.addEventListener('click', showSearchBar);
    closeBtn.addEventListener('click', hideSearchBar);

    let mq = window.matchMedia("(max-width: 1024px)");

    function handleMediaQueryChange(mq) {
        if (!mq.matches) {
            hideSearchBar();
        }
    }

    // Añadir un listener para cambios en la media query
    mq.addEventListener('change', handleMediaQueryChange);

    // Llamar a la función al inicio para verificar el estado inicial
    handleMediaQueryChange(mq);

    // document.getElementById("cover-ctn-search").addEventListener("click", hideSearchBar);
    document.getElementById("inputSearch").addEventListener("input", searchInternal);

    document.getElementById("inputSearch").addEventListener("focus", function(){
        if(this.value !== '')
            boxSearch.classList.add('show-boxSearch')
    });
    document.addEventListener('click', (e)=>{
        if(!e.target.classList.contains('internal-link') && !e.target.classList.contains('search-bar-input')){
            boxSearch.classList.remove('show-boxSearch')
        }
    });
    // document.getElementById("inputSearch").addEventListener("blur", function(e){
    //     document.addEventListener('click', (e)=>{

    //     });
    //     if(!isLink)
    //         boxSearch.classList.remove('show-boxSearch')
    // });

    const boxSearch = document.getElementsByClassName("box-search")[0];
    const noResultsMessage = document.createElement('li');
    noResultsMessage.textContent = 'No se encontraron resultados';
    noResultsMessage.id = 'no-results-message';


    function toggleMenu() {
        document.getElementById("move-content").classList.toggle('move-container-all');
        document.getElementById("show-menu").classList.toggle('show-lateral');
    }

    function toggleSearchBar() {
        searchBarVisible = !searchBarVisible;
        if (searchBarVisible) {
            showSearchBar();
        } else {
            hideSearchBar();
        }
    }

    function showSearchBar() {
        searchBarContent.classList.add('show-searchBar');
        let inputElement = document.getElementById('inputSearch');
        inputElement.focus();
        // // const coverCtnSearch = document.getElementById("cover-ctn-search");
        // const inputSearch = document.getElementById("inputSearch");
        // searchBar.style.top = "115px";
        // searchBar.classList.add('zchange');
        // // barsSearch.style.display = "block";
        // // coverCtnSearch.style.display = "block";
        // inputSearch.focus();
        // if (inputSearch.value === "") {
        //     boxSearch.style.display = "none";
        // }
    }

    function hideSearchBar() {
        searchBarContent.classList.remove('show-searchBar');
        // const barsSearch = document.getElementById("cont-bars-search");
        // const coverCtnSearch = document.getElementById("cover-ctn-search");
        // const inputSearch = document.getElementById("inputSearch");

        // barsSearch.style.top = "40px";
        // barsSearch.classList.remove('zchange');
        // barsSearch.style.display = "none";
    }

    function searchInternal() {
        const filter = this.value.trim().toUpperCase();
        const li = boxSearch.getElementsByTagName("li");
        let found = false;
        let allItemsHidden = true;

        if (filter === "") {
            // boxSearch.style.display = "none";
            boxSearch.classList.remove('show-boxSearch');
            return;
        }

        for (let i = 0; i < li.length; i++) {
            const a = li[i].querySelector("a");
            if (a) {
                const textValue = a.textContent || a.innerText;
                if (textValue.toUpperCase().includes(filter)) {
                    li[i].style.display = "";
                    found = true;
                    allItemsHidden = false;
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        const noResultsMessageElement = document.getElementById('no-results-message');
        if (!found) {
            if (!noResultsMessageElement) {
                boxSearch.appendChild(noResultsMessage);
            }
        } else {
            if (noResultsMessageElement) {
                noResultsMessageElement.remove();
            }
        }

        // boxSearch.style.display = found || allItemsHidden ? "block" : "none";

        if(found || allItemsHidden)
            boxSearch.classList.add('show-boxSearch');
        else
            boxSearch.classList.remove('show-boxSearch');

    }
});