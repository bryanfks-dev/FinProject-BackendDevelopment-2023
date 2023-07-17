<tr>
    <td>
        <div><div style="background-image: url('{{url('storage/product_img', $products->find($order->product_id)->image)}}"></div></div>
        <p>{{$products->find($order->product_id)->name}}</p>
    </td>
    {{-- Price cell --}}
    <td>
        <p>Rp. {{$products->find($order->product_id)->price}}</p>
    </td>
    {{-- Quantity cell --}}
    <td>
        <div>
            <a href="{{url('cart/min', $order->id)}}">
                <i class='bx bxs-minus-circle'></i>
            </a>
            <p class="quantity">{{$order->quantity}}</p>
            <a href="{{url('cart/add', $order->id)}}">
                <i class='bx bxs-plus-circle'></i>
            </a>
            <a href="{{url('cart/drop', $order->id)}}">
                <i class='bx bx-trash'></i>
            </a>
        </div>
    </td>
    {{-- Total cell --}}
    <td></td>
</tr>
