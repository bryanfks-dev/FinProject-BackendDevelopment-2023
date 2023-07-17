<style>
    header nav {
        background-color: #803ad0;
        font-size: 24px;
        padding: .6em 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    header nav > a {
        color: white;
    }

    header nav .guest-menu,
    header nav .user-menu a {
        font-size: 20px;
        font-weight: 500;
        color: black;
        background-color: #f5f5f5;
        padding: .3em .5em;
        display: flex;
        align-items: center;
        gap: .5em;
        border-radius: .3rem;
        -webkit-border-radius: .3rem;
        -moz-border-radius: .3rem;
        -ms-border-radius: .3rem;
        -o-border-radius: .3rem;
        cursor: pointer;
    }

    header nav .user-menu {
        display: flex;
        gap: 1.3rem;
    }

    header nav .user-menu a {
        padding: .5em .6em;
    }
</style>

<nav>
    <a href="/market">
        <b>Joelbid's Furnishing</b>
    </a>
    {{-- Check if user is guest --}}
    @auth
        <div class="user-menu">
            <a href="/logout">
                <i class='bx bx-log-out'></i>
            </a>
            <a href="/cart">
                <i class='bx bx-cart'></i>
            </a>
        </div>
    @else
        <a href="/login" class="guest-menu">
            <span>Login</span>
        </a>
    @endauth
</nav>
