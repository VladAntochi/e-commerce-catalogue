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
function displayData() {
    const container = document.getElementById('data-container');
    container.innerHTML = '';

    // Calculate start and end indexes
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedItems = apiData.slice(start, end);

    // Display only items for the current page
    paginatedItems.forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');

        productCard.innerHTML = `
            <img src="${product.image}" alt="${product.title}">
            <h2>${product.title}</h2>
            <p class="price">&pound;${product.price.toFixed(2)}</p>
            <button class="view-btn">View Details</button>
        `;

        container.appendChild(productCard);
    });

    updatePaginationButtons();
}

// Function to update pagination controls
function updatePaginationButtons() {
    const totalPages = Math.ceil(apiData.length / itemsPerPage);
    document.getElementById('page-info').textContent = `Page ${currentPage} of ${totalPages}`;

    document.getElementById('prev-btn').disabled = currentPage === 1;
    document.getElementById('next-btn').disabled = currentPage === totalPages;
}

// Event listeners for pagination buttons
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

// Load data when the page loads
window.onload = fetchData;
