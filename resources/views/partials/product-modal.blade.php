<!-- Product Modal -->
<div class="modal-overlay" id="modal-overlay" onclick="closeProductModal()"></div>
<div class="product-modal" id="product-modal">
    <div class="modal-header">
        <h3 id="modal-product-name">Product Name</h3>
        <button class="close-modal" onclick="closeProductModal()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="modal-content">
        <div class="modal-image">
            <img id="modal-product-image" src="" alt="Product Image">
        </div>
        
        <div class="modal-details">
            <div class="product-price">
                $<span id="modal-product-price">0.00</span>
            </div>
            
            <div class="product-description">
                <p id="modal-product-description">Product description will appear here.</p>
            </div>
            
            <div class="quantity-selector">
                <label>Quantity:</label>
                <div class="quantity-controls-modal">
                    <button onclick="decreaseQuantity()">-</button>
                    <input type="number" id="modal-quantity" value="1" min="1">
                    <button onclick="increaseQuantity()">+</button>
                </div>
            </div>
            
            <button class="btn btn-primary add-to-cart-modal" onclick="addToCartFromModal()">
                <i class="fas fa-cart-plus"></i> Add to Cart
            </button>
        </div>
    </div>
    
    <div class="modal-comments">
        <h4>Customer Reviews</h4>
        <div class="comments-list" id="comments-list">
            <!-- Comments will be loaded dynamically -->
        </div>
        
        <form class="comment-form" id="comment-form">
            <h5>Leave a Review</h5>
            <div class="rating-input">
                <label>Rating:</label>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="form-group">
                <input type="text" id="comment-name" placeholder="Your Name" required>
            </div>
            <div class="form-group">
                <input type="email" id="comment-email" placeholder="Your Email" required>
            </div>
            <div class="form-group">
                <textarea id="comment-text" placeholder="Your Review" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-secondary">Submit Review</button>
        </form>
    </div>
</div>