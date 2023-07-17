<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$products->find($order->product_id)->name}}</td>
    <td>{{$order->quantity}}</td>
    <td>@currency($products->find($order->product_id)->price)</td>
    <td class="total">@currency($order->quantity * $products->find($order->product_id)->price)</td>
</tr>
