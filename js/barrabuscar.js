document.addEventListener("DOMContentLoaded", function () {

    // document.getElementById("icon-menu").addEventListener("click", toggleMenu);
    let searchBarVisible = false;
    let icon = document.getElementById("icon-search");

    icon.addEventListener('click', toggleSearchBar);

    // document.getElementById("cover-ctn-search").addEventListener("click", hideSearchBar);
    document.getElementById("inputSearch").addEventListener("input", searchInternal);

    const boxSearch = document.getElementById("box-search");
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
        const barsSearch = document.getElementById("cont-bars-search");
        // const coverCtnSearch = document.getElementById("cover-ctn-search");
        const inputSearch = document.getElementById("inputSearch");
        barsSearch.style.top = "115px";
        barsSearch.classList.add('zchange');
        // barsSearch.style.display = "block";
        // coverCtnSearch.style.display = "block";
        inputSearch.focus();
        if (inputSearch.value === "") {
            boxSearch.style.display = "none";
        }
    }

    function hideSearchBar() {
        const barsSearch = document.getElementById("cont-bars-search");
        // const coverCtnSearch = document.getElementById("cover-ctn-search");
        const inputSearch = document.getElementById("inputSearch");

        barsSearch.style.top = "40px";
        barsSearch.classList.remove('zchange');
        // barsSearch.style.display = "none";
    }

    function searchInternal() {
        const filter = this.value.trim().toUpperCase();
        const li = boxSearch.getElementsByTagName("li");
        let found = false;
        let allItemsHidden = true;

        if (filter === "") {
            boxSearch.style.display = "none";
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

        boxSearch.style.display = found || allItemsHidden ? "block" : "none";
    }
});