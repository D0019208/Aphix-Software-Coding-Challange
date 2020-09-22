<header>
    <nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
        <a class='navbar-brand' style='font-weight: bold;'>YouTube Search</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target="#search_menu" aria-controls="search_menu" aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>

        <div class='collapse navbar-collapse' id='search_menu'>
            <ul class='navbar-nav mr-auto'>
                <li class='nav-item active'>
                    <a class='nav-link' href='{{ route('home-route') }}'>Home <span class='sr-only'>(current)</span></a>
                </li>
            </ul>
            <span class='form-inline'>
                <input class='form-control mr-sm-2' type='search' placeholder='Search Videos' name='search_term' aria-label='Search'>
                <button class='btn btn-success btn-submit' id='search_button'>Search</button>
            </span>
        </div>
    </nav>
</header>