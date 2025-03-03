document.addEventListener("DOMContentLoaded", function () {
    const searchButton = document.getElementById("search-btn");
    searchButton.addEventListener("click", searchProducts);

});

// Store API data globally
let apiData = [];
let currentPage = 1;
const itemsPerPage = 8;

// Fetch products from API
async function fetchData() {
    const apiUrl = 'https://fakestoreapi.com/products';
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        apiData = await response.json();
        displayData();
    } catch (error) {
        console.error('Error fetching data:', error);
        document.getElementById('data-container').textContent = 'Error loading data';
    }
}

// Function to display products based on pagination
function displayData(filteredData = null) {
    const container = document.getElementById('data-container');
    container.innerHTML = '';

    // Use filteredData if provided, otherwise use full apiData
    const dataToDisplay = filteredData || apiData;

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedItems = dataToDisplay.slice(start, end);

    paginatedItems.forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');

        productCard.innerHTML = `
            <img src="${product.image}" alt="${product.title}">
            <h2>${product.title}</h2>
            <p class="price">&pound;${product.price.toFixed(2)}</p>
            <a href="productDetails.php?product-id=${product.id}" class="view-btn">View Details</a>        
        `;

        container.appendChild(productCard);
    });
    updatePaginationButtons(dataToDisplay);
}

// Search function
function searchProducts() {
    let input = document.getElementById('search-bar').value.toLowerCase();

    // Filter API data based on search input
    let filteredData = apiData.filter(product =>
        product.title.toLowerCase().includes(input)
    );

    // Reset to first page and display filtered results
    currentPage = 1;
    displayData(filteredData);
}

// Function to update pagination controls
function updatePaginationButtons(dataSet) {
    const totalPages = Math.ceil(dataSet.length / itemsPerPage);
    document.getElementById('page-info').textContent = `Page ${currentPage} of ${totalPages || 1}`;

    document.getElementById('prev-btn').disabled = currentPage === 1;
    document.getElementById('next-btn').disabled = currentPage === totalPages;
}

// Pagination event listeners
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('prev-btn').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayData();
        }
    });

    document.getElementById('next-btn').addEventListener('click', () => {
        const totalPages = Math.ceil(apiData.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayData();
        }
    });

    fetchData();
});