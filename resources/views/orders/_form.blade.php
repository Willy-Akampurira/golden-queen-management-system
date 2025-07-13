<form id="order-form" action="{{ route('orders.store') }}" method="POST">
    @csrf

    <h2>Place Your Order</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success')}}
    </div>
    @endif

    <div class="form-group">
        <label for="customer_name">Name:</label>
        <input type="text" id="customer_name" name="customer_name" required maxlength="50" placeholder="Your name">
    </div>

    <div class="form-group">
        <label>Gender:</label>
        <div class="radio-group">
            <label><input type="radio" name="gender" value="male" required>Male</label>
            <label><input type="radio" name="gender" value="female">Female</label>
            <label><input type="radio" name="gender" value="other">Other</label>
        </div>
    </div>

    <div class="form-group">
        <label for="menu_item_id">Choosen Meal</label>
        <select id="menu_item_id" name="menu_item_id" required>
            <option value="">-- Select a meal --</option>
            @foreach($menuItems as $item)
            <option value="{{ $item->id }}">{{ $item->name }} - ${{ number_format($item->price, 2) }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="table_number">Table Number:</label>
        <input type="number" id="table_number" min="1" max="12" required placeholder="1 - 12">
    </div>

    <div>
        <label>Drinks:</label>
        <div class="checkbox-group">
            <label><input type="checkbox" name="drinks[]" value="wine">Wine</label>
            <label><input type="checkbox" name="drinks[]" value="beer">Beer</label>
            <label><input type="checkbox" name="drinks[]" value="soda">Soda</label>
            <label><input type="checkbox" name="drinks[]" value="water">Water</label>
        </div>
    </div>

    <button type="submit" class="submit-btn">Place Order</button>
</form>