const handleLoading = (isLoading) => {
    const navSearchButtonText = document.getElementById('nav-search-button-text');
    if(navSearchButtonText !== null) {
        navSearchButtonText.style.display = isLoading ? 'none' : 'block';
    }

    const navSearchLoading = document.getElementById('nav-search-loading');
    if(navSearchLoading !== null) {
        navSearchLoading.style.display = isLoading ? 'flex' : 'none';
    }
};

const fetchSearchResults = (search) => {
    handleLoading(true);

    fetch(`/search-products/${search}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            Accept: 'application/json',
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const navSearchResults = document.getElementById('nav-search-results');

                if(navSearchResults !== null) {
                    navSearchResults.innerHTML = '';
                    navSearchResults.innerHTML = data.html;
                }
            } 
        })
        .catch((error) => {
            console.error('Error fetching search results:', error);
        })
        .finally(() => {
            handleLoading(false);
        });
};

document.addEventListener('DOMContentLoaded', function () {
    const navSearchButton = document.getElementById('nav-search-button');
    const navSearchInput = document.getElementById('nav-search-input');

    navSearchButton.addEventListener('click', function (e) {
        e.preventDefault();

        if(navSearchInput.value.trim() !== '') {
            fetchSearchResults(navSearchInput.value.trim());
        }
    });
});