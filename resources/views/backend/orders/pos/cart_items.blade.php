@if (session('cart') && count(session('cart')) > 0)
    @php $serial = 1; @endphp
    @foreach (session('cart') as $cartIndex => $details)
        <tr>
            <th class="text-center">
                {{ $serial++ }}
                <input type="hidden" name="product_id[]" value="{{ $details['product_id'] }}">
                <input type="hidden" name="color_id[]" value="{{ $details['color_id'] }}">
                <input type="hidden" name="size_id[]" value="{{ $details['size_id'] }}">
                <input type="hidden" name="purchase_product_warehouse_id[]"
                    value="{{ $details['purchase_product_warehouse_id'] }}">
                <input type="hidden" name="purchase_product_warehouse_room_id[]"
                    value="{{ $details['purchase_product_warehouse_room_id'] }}">
                <input type="hidden" name="purchase_product_warehouse_room_cartoon_id[]"
                    value="{{ $details['purchase_product_warehouse_room_cartoon_id'] }}">
                <input type="hidden" name="price[]" value="{{ $details['price'] }}">
            </th>
            <td class="text-center">
                <img src="{{ url($details['image']) }}" style="width: 30px; height: 30px">
            </td>
            <td class="text-left">
                {{ $details['name'] }} ({{ $details['code'] }}),
                @if ($details['color_id'])
                    <b>Color:</b> {{ $details['color_name'] }},
                @endif
                @if ($details['size_id'])
                    <b>Size:</b> {{ $details['size_name'] }}
                @endif
            </td>
            <td class="text-center">৳{{ $details['price'] }}</td>

            <td class="text-center">
                <input type="number" class="text-center" style="width: 50px; -moz-appearance: textfield; appearance: textfield;" min="1"
                    data-cart-index="{{ $cartIndex }}"
                    onkeyup="if(this.value < 1) this.value = 1; 
                    updateCartQty(this, '{{ $cartIndex }}')"
                    value="{{ $details['quantity'] }}" name="quantity[]" 
                    onwheel="this.blur()" />
                <style>
                    /* Hide number input arrows for Chrome, Safari, Edge, Opera */
                    input[type=number]::-webkit-inner-spin-button, 
                    input[type=number]::-webkit-outer-spin-button { 
                        -webkit-appearance: none; 
                        margin: 0; 
                    }
                    /* Hide number input arrows for Firefox */
                    input[type=number] {
                        -moz-appearance: textfield;
                    }
                </style>
            </td>

            <td class="text-center">
                <input type="number" class=" text-center" style="width: 50px; -moz-appearance: textfield; appearance: textfield;" min="0" onwheel="this.blur()"
                    value="{{ $details['discounted_price'] }}" name="discounted_price[]" required
                    onkeyup="if(this.value < 1) this.value = 0; updateCartDiscount(this, '{{ $cartIndex }}')" 
                    />
            </td>

            <td class="text-center subtotal-cell">
                ৳{{ $details['price'] * $details['quantity'] - (isset($details['discounted_price']) ? $details['discounted_price'] : 0) }}
            </td>
            <td class="text-center">
                <button type="button" onclick="removeCartItem('{{ $cartIndex }}')"
                    class="btn btn-danger btn-sm m-0">
                    <i class="fa fa-times"></i>
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" class="text-center">No item is Added</td>
    </tr>
@endif


<script>
    // User-friendly discount update
    function updateCartDiscount(input, cartIndex) {
        let discount = parseFloat(input.value) || 0;
        var row = input.closest('tr');
        var price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
        var qty = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 1;
        var subtotal = price * qty;

        // Prevent discount greater than subtotal
        if (discount > subtotal) {
            discount = 0;
            input.value = 0;
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.timeOut = 1500;
            toastr.error('Discount cannot be greater than subtotal!');
        }

        // Update subtotal cell immediately for smooth UX
        var subtotalCell = row.querySelector('.subtotal-cell');
        var newSubtotal = subtotal - discount;
        if (newSubtotal < 0) newSubtotal = 0;
        subtotalCell.innerHTML = '৳' + newSubtotal.toFixed(2);

        // Update the cart item discount in backend, but do NOT reload the whole cart_items
        $.get("{{ url('update/cart/discount') }}/" + cartIndex + "/" + discount, function(data) {
            // Only update the totals section, not the cart rows
            $('.cart_calculation').html(data.cart_calculation);
        });
    }

    // Improved quantity update: keep focus and cursor after AJAX
    function updateCartQty(inputElem, cartIndex) {
        // Save cursor position and value
        var selectionStart = inputElem.selectionStart;
        var selectionEnd = inputElem.selectionEnd;
        var value = inputElem.value;
        // Save cartIndex to restore focus
        window._posCartQtyFocus = {
            cartIndex: cartIndex,
            selectionStart: selectionStart,
            selectionEnd: selectionEnd,
            value: value
        };
        $.get("{{ url('update/cart/item') }}" + '/' + cartIndex + '/' + value, function(data) {
            $('.cart_items').html(data.rendered_cart);
            $('.cart_calculation').html(data.cart_calculation);
            // Reset coupon price as cart updates invalidate coupon
            if (typeof couponPrice !== 'undefined') {
                couponPrice = 0;
            }
            // Restore focus and cursor position
            setTimeout(function() {
                var focusData = window._posCartQtyFocus;
                if (!focusData) return;
                var qtyInput = document.querySelector('input[data-cart-index="' + focusData.cartIndex +
                    '"]');
                if (qtyInput) {
                    qtyInput.focus();
                    // Restore cursor position if possible
                    try {
                        qtyInput.setSelectionRange(focusData.selectionStart, focusData.selectionEnd);
                    } catch (e) {
                        // fallback: move cursor to end
                        var val = qtyInput.value;
                        qtyInput.value = '';
                        qtyInput.value = val;
                    }
                }
            }, 10);
        });
    }

    function removeCartItem(cartIndex) {
        $.get("{{ url('remove/cart/item') }}" + '/' + cartIndex, function(data) {
            // toastr.error("Item Removed");
            $('.cart_items').html(data.rendered_cart);
            $('.cart_calculation').html(data.cart_calculation);
            // Reset coupon price as cart updates invalidate coupon
            if (typeof couponPrice !== 'undefined') {
                couponPrice = 0;
            }
        })
    }
</script>
