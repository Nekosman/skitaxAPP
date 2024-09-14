<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: 100vh;
            transition: width 0.3s;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .nav-link {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
            color: #6c757d;
        }

        .nav-link:hover, .nav-link.active {
            border-color: black;
            color: black !important;
        }

        .nav-link:not(.active):hover {
            background-color: #f8f9fa;
        }

        .nav-link.active {
            background-color: transparent;
            border-color: black;
            color: black !important;
        }

        .sidebar.collapsed .nav-link .icon {
            margin-right: 0;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .nav-link .icon {
            margin-right: 10px;
            transition: margin 0.3s;
        }

        .sidebar img {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
            transition: width 0.3s;
        }

        .sidebar.collapsed img {
            width: 50px;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        
        <div class="sidebar p-3" id="sidebar">
            <img src="{{ url('img/logo.png') }}" alt="Sidebar Image" class="img-fluid mx-auto d-block">
            <br>
            <button class="btn btn-muted" id="toggleButton">
                <li class="lni lni-menu"></li>
            </button>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('petugas.home') }}">
                        <i class="icon lni lni-grid-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.index') }}">
                        <i class="lni lni-producthunt"></i> 
                        <span>Products list</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        <i class="icon lni lni-information"></i>
                        <span>Add Item</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories') }}">
                        <i class="icon lni lni-spray"></i>
                        <span>Add Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.history') }}">
                        <i class="lni lni-ticket-alt"></i>
                        <span>Report Sale</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#submenu" role="button" aria-expanded="false" aria-controls="submenu">
                        <i class="icon lni lni-archive"></i>
                        <span>Menu</span>
                    </a>
                    <ul class="collapse nav flex-column ms-3" id="submenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="icon lni lni-cog"></i>
                                <span>Settings</span>
                            </a>
                        </li> 
                        <li class="nav-item">
                           
                            <a class="nav-link" href="{{ url('/logout') }}"> 
                            <i class="icon lni lni-arrow-left"></i>
                            <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="content p-4">
            <!-- Main content goes here -->
            @yield('contents')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });

        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
