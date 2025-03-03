document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product-id');
    if (productId) {
        fetchProductDetails(productId);
    } else {
        document.getElementById('product-details-container').innerText = "Product not found.";
    }
});

async function fetchProductDetails(id) {
    const apiUrl = `https://fakestoreapi.com/products/${id}`;
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error('Product not found');
        }
        const product = await response.json();
        displayProductDetails(product);
    } catch (error) {
        document.getElementById('product-details-container').innerText = 'Error loading product details';
        console.error('Error fetching product:', error);
    }
}

function displayProductDetails(product) {
    const container = document.getElementById('product-details-container');
    container.innerHTML = `
        <div class="product-image-gallery">
            <img src="${product.image}" alt="${product.title}" id="main-product-image">
        </div>

        <div class="product-info">
            <h2>${product.title}</h2>
            <p class="price">&pound;${product.price.toFixed(2)}</p>
            <p class="product-description">${product.description}</p>
            <ul class="product-specifications">
                <li>Category: ${product.category}</li>
                <li>Rating: ${product.rating.rate} / 5 (Based on ${product.rating.count} reviews)</li>
            </ul>
        </div>
    `;
}

// Function to change the main product image when a thumbnail is clicked
function changeImage(image) {
    document.getElementById('main-product-image').src = image;
}

// Event listener for Add to Cart button
document.getElementById('add-to-cart').addEventListener('click', function () {
    alert('Product added to cart!');
});
