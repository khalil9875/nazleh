<!-- Cart Sidebar -->
<div class="cart-overlay" id="cart-overlay" onclick="toggleCart()"></div>
<div class="cart-sidebar" id="cart-sidebar">
    <div class="cart-header">
        <h3>Shopping Cart</h3>
        <button class="close-cart" onclick="toggleCart()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="cart-content">
        <div class="cart-items" id="cart-items">
            <!-- Cart items will be loaded dynamically -->
        </div>
        <div class="empty-cart" id="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <p>Your cart is empty</p>
        </div>
    </div>
    
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total: $<span id="cart-total">0.00</span></span>
        </div>
        <button class="btn btn-primary checkout-btn" onclick="proceedToCheckout()">
            Proceed to Checkout
        </button>
    </div>
</div>