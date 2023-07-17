<style>
    nav {
        background-color: #803ad0;
        font-size: 24px;
        padding: .6em 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    nav > a {
        color: white;
    }

    nav .guest-menu,
    nav .user-menu a {
        font-size: 20px;
        font-weight: 500;
        color: black;
        background-color: #f5f5f5;
        padding: .5em;
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

    nav .user-menu {
        display: flex;
        gap: 1.3rem;
    }
</style>

<nav>
    <a href="/dashboard">
        <b>Joelbid's Furnishing</b>
    </a>
    <div class="user-menu">
        <a href="/logout">
            <i class='bx bx-log-out'></i>
        </a>
        <a href="/incoming_invoice">
            <i class='bx bx-list-ul'></i>
        </a>
    </div>
</nav>
