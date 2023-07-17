<div class="card">
    <div class="pic-border">
        <div class="pic" style="background-image: url('{{url('storage/product_img', $product->image)}}')"></div>
    </div>
    <div class="name-price">
        <span><b>{{$product->name}}</b></span>
        <span>@currency($product->price)</span>
    </div>
    <div class="desc">{{$product->description}}</div>
    <div class="stock-add">
        <span>Stock: {{$product->stock}}</span>
        <a href="{{url('add', $product->id)}}">
            <i class='bx bx-plus'></i>
        </a>
    </div>
</div>
