<div id="main-screen" class="main-screen">
	<h1 class="store-title">SiteGround Store</h1>
	<div id="actions">
		<button id="admin-side" class="button normal">Admin Side (Create/Edit)</button>
		<button id="user-side" class="button normal">User Side (Pick/Buy)</button>
	</div>
</div>
<div id="admin-screen" class="admin-screen hidden">
	<button id="back-button" screen="main" class="button back">Back</button>
	<h1 class="screen-title">Welcome to the Admin Screen!</h1>
	<h2 class="screen-sub-title">Create, Edit & Remove store items from here.</h2>
	<div id="actions">
		<button id='add-item' class='button add'>Add new</button>
	</div>
	<div id="items-list"></div>
</div>
<div id="user-screen" class="user-screen hidden">
	<button id="back-button" screen="main" class="button back">Back</button>
	<h1 class="screen-title">Welcome to the User Screen!</h1>
	<h2 class="screen-sub-title">Pick a product, proceed to Cart and Buy the desired quantity it!</h2>
	<div id="items-list"></div>
	<div id="cart">
		<h2 class="cart-title">Your cart</h2>
		<div id="list"></div>
		<div id="total">
			Total: <span id="amount">0</span>
		</div>
		<button id="buy-button" class="button add">Buy</button>
	</div>
</div>
