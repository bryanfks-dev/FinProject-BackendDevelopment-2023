<tr>
    <form class="product-data" action="/dashboard/update_item/{{$product->id}}" method="POST">
        @csrf
        {{-- Product id --}}
        <input type="hidden" name="id" value={{$product->id}}>
        {{-- Product name cell --}}
        <td>
            <input type="text" name="name" placeholder="Product name" value='{{$product->name}}' disabled>
        </td>
        {{-- Price cell --}}
        <td>
            <p>Rp. </p>
            <input type="text" name="price" placeholder="Product price" value={{$product->price}} disabled>
        </td>
        {{-- Stock cell --}}
        <td>
            <input class="@if($product->stock <= 1) alert @endif" type="text" name="stock" placeholder="Product stock" value={{$product->stock}} disabled>
        </td>
        {{-- Description cell --}}
        <td>
            <textarea name="description" placeholder="Product description" minlength="10" cols="50" rows="5" disabled>{{$product->description}}</textarea>
        </td>
        {{-- Action cell --}}
        <td>
            <div>
                {{-- Edit button --}}
                <i class='bx bx-edit-alt' id="edit-btn"></i>
                {{-- Delete button --}}
                <a onclick="return confirm('Are you sure want to delete this?')" href="{{url('dashboard/delete_item', $product->id)}}">
                    <i class='bx bx-trash'></i>
                </a>
            </div>
        </td>
    </form>
</tr>
