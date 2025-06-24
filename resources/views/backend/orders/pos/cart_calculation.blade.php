<tr>
    <td class="text-center">
        @php
            $total = 0;
            if (session('cart') && count(session('cart')) > 0) {
                foreach (session('cart') as $cartIndex => $details) {
                    $total = $total + $details['price'] * $details['quantity'];
                    if (isset($details['discounted_price'])) {
                        $total = $total - $details['discounted_price'];
                    }
                }
            }
        @endphp
        ৳ {{ number_format($total, 2) }}
        <input type="hidden" name="subtotal" id="subtotal" value="{{ $total }}">
    </td>
    {{-- <td class="text-center">৳ 0</td> --}}
    <td class="text-center">
        @php
            if (session('shipping_charge')) {
                $total = $total + session('shipping_charge');
            }
        @endphp
        ৳ <input type="number" class="text-center" style="width: 50px;" onkeyup="if(this.value < 1) this.value = 0; updateOrderTotalAmount()"
            @if (session('shipping_charge')) value="{{ session('shipping_charge') }}" @else value="0" @endif
            min="0" id="shipping_charge" name="shipping_charge" />
    </td>
    <td class="text-center">
        @php
            if (session('pos_discount')) {
                $total -= session('pos_discount');
            }
            // if (session('discount')) {
            //     $total -= session('discount');
            // }
        @endphp
        ৳ <input type="number" class="text-center" style="width: 50px;" onkeyup="if(this.value < 1) this.value = 0; updateOrderTotalAmount()"
            @if (session('discount')) value="{{ session('discount') }}" @else value="0" @endif min="0"
            id="discount" name="discount" />
    </td>
    <th class="text-center" id="total_cart_calculation">৳ {{ number_format($total, 2) }}</th>
</tr>
