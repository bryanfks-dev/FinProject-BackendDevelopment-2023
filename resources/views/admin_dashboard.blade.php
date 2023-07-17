<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Joelbid Furnishing | Dashboard</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/dashboard.css')}}">

    <!-- Boxicons css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Header -->
    <header>
        @include('partials.admin_navbar')
    </header>
    <!-- Main -->
    <main>
        <div class="menus">
            <!-- Create item menu -->
            <div class="create-item">
                Create Item
            </div>
            <div>
                <!-- Sort menu -->
                <div class="sort">
                    <div>
                        <span>Sort</span>
                        <div>
                            <i class='bx bxs-down-arrow'></i>
                        </div>
                    </div>
                    <div class="sort-menu">
                        <a href="{{url('dashboard/sort_item', '0')}}">Name</a>
                        <a href="{{url('dashboard/sort_item', '1')}}">Price</a>
                        <a href="{{url('dashboard/sort_item', '2')}}">Stock</a>
                    </div>
                </div>
                <!-- Search menu -->
                <form action="/dashboard/search" method="GET">
                    @csrf
                    <input type="text" placeholder="Search" name="search">
                    <button type="submit">
                        <i class='bx bx-search'></i>
                    </button>
                </form>
            </div>
        </div>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            {{-- Contents here --}}
            @forelse($products as $product)
                @include('partials.item_dashboard')
            @empty
                <table>
                    <div>
                        <p>No data found</p>
                    </div>
                </table>
            @endforelse
        </table>
        <!-- Return to top button -->
        <div class="return-to-top">
            <i class='bx bx-chevron-up'></i>
        </div>
    </main>
    <!-- Create item section -->
    <section>
        <div class="dim-bg"></div>
        <!-- Create item modal -->
        <div class="modal-container">
            <div class="modal">
                <div>
                    <h3>Create new item</h3>
                    <i class='bx bx-x'></i>
                </div>
                <form name="create_new_item" action="/dashboard/add_item" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="name" placeholder="Product name" required>
                    <input type="number" name="price" placeholder="Product price" min="50" required>
                    <input type="number" name="stock" placeholder="Stock" min="1" required>
                    <textarea placeholder="Description" name="description" cols="50" rows="5" required></textarea>
                    <input type="file" name="image" accept="image/png, image/jpeg" required>
                    <button type="submit">Create</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Sort menus js -->
    <script type="text/javascript">
        const sort_btn = document.querySelector(".sort div:first-of-type");
        const sort_btn_i = document.querySelector(".sort div:first-of-type i");
        const sort_menu = document.querySelector(".sort-menu");

        // Sort button on click listener
        sort_btn.addEventListener("click", () => {
            // Check sort menu height
            if (sort_menu.clientHeight === 0) {
                // Set sort menu height and rotate arrow
                sort_menu.style.height = `${sort_menu.scrollHeight}px`;
                sort_btn_i.style.transform = "rotate(180deg)";
            }
            else {
                // Set sort menu height and rotate arrow
                sort_menu.style.height = "0px";
                sort_btn_i.style.transform = "rotate(0deg)";
            }
        });
    </script>

    <!-- Scroll to top js -->
    <script type="text/javascript">
        const scroll_button = document.querySelector(".return-to-top");
        const nav = document.querySelector("nav");

        // Window on scroll listener
        addEventListener("scroll", () => {
            // Check if user scroll more than screen height
            if (scrollY > innerHeight - nav.scrollHeight) {
                // Display button
                scroll_button.style.display = "block";
            }
            else {
                // Hide button
                scroll_button.style.display = "none";
            }
        });

        // Scroll button on click listener
        scroll_button.addEventListener("click", () => {
            // Scroll back to the top of the page with smooth scrolling
            scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    <!-- Edit item button js -->
    <script type="text/javascript">
        const edit_btn = document.querySelectorAll("i#edit-btn");
        const prod_data_form = document.querySelectorAll("form.product-data");
        const prod_input = document.querySelectorAll("input[name='name']");
        const price_input = document.querySelectorAll("input[name='price']");
        const stock_input = document.querySelectorAll("input[name='stock']");
        const desc_input = document.querySelectorAll("textarea[name='description']");

        // Edit button on click listener
        edit_btn.forEach((ele, idx) => {
            ele.addEventListener("click", () => {
                if (ele.classList.contains("bx-edit-alt")) {
                    prod_input[idx].disabled = false;
                    price_input[idx].disabled = false;
                    stock_input[idx].disabled = false;
                    desc_input[idx].disabled = false;

                    ele.classList.remove("bx-edit-alt");
                    ele.classList.add("bx-check");
                }
                else {
                    // Submit form
                    prod_data_form[idx].submit();
                }
            });
        });
    </script>

    <!-- Create new item js -->
    <script type="text/javascript">
        const create_item_btn = document.querySelector(".create-item");
        const create_item_section = document.querySelector("section");
        const x_btn = document.querySelector(".bx-x");
        const submit_btn = document.querySelector("button[name='submit_new_item']");

        // Create item button on click listener
        create_item_btn.addEventListener("click", () => {
            create_item_section.style.display = "block";
        });

        // X button on click listener
        x_btn.addEventListener("click", () => {
            create_item_section.style.display = "none";
        });
    </script>
</body>
</html>
