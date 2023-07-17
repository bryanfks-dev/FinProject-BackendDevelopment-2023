<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joelbid Furnishing | Incoming Invoice</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/incoming_invoice.css')}}">

    <!-- Boxicons css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        @include('partials.admin_navbar')
    </header>
    <main>
        <div>
            <h2>Incoming Invoice</h2>
            <div class="menus">
                <!-- Sort menu -->
                <div class="sort">
                    <div>
                        <span>Sort</span>
                        <div>
                            <i class='bx bxs-down-arrow'></i>
                        </div>
                    </div>
                    <div class="sort-menu">
                        <a href="{{url('incoming_invoice/sort', '0')}}">Name</a>
                        <a href="{{url('incoming_invoice/sort', '1')}}">Date</a>
                    </div>
                </div>
                <!-- Search menu -->
                <form action="/incoming_invoice/search" method="GET">
                    @csrf
                    <input type="text" placeholder="Search" name="search">
                    <button type="submit">
                        <i class='bx bx-search'></i>
                    </button>
                </form>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contents here --}}
                @forelse ($invoices as $invoice)
                    @include('partials.admin_invoice_item_cell')
                @empty
                    <table>
                        <div>
                            <p>No data found</p>
                        </div>
                    </table>
                @endforelse
            </tbody>
        </table>
        <!-- Return to top button -->
        <div class="return-to-top">
            <i class='bx bx-chevron-up'></i>
        </div>
    </main>

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
</body>
</html>
