<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Product List</h1>

    <!-- Search Bar with Button -->
    <div class="search-container">
        <input type="text" id="search-bar" placeholder="Search products...">
        <button id="search-btn">Search</button>
    </div>


    <div id="data-container" class="product-grid"></div>

    <!-- Pagination Controls -->
    <div class="pagination">
        <button id="prev-btn" disabled>Previous</button>
        <span id="page-info">Page 1</span>
        <button id="next-btn">Next</button>
    </div>
</div>

<script src="script.js"></script>

</body>
</html>
