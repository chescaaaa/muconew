<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-i+6J7M4FjrpxXxM7b7cjo7+MudR/BsL97M7Si+rP6E8L3NszdNxkD4BhEz89b3BUHJ9vKp8qF+ZIyI7qGONxcw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Product List</title>
    <script src="https://kit.fontawesome.com/80a719bb33.js" crossorigin="anonymous"></script>
    <style>
        /* Custom styles for the dark sidebar */
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40; /* Dark background color */
            color: #ffffff; /* White text color */
        }

        .nav-link {
            color: #ffffff !important; /* White text color for links */
        }

        .nav-link.active {
            background-color: #495057; /* Darker background color for active link */
        }

        .nav-item{
          position:fixed;
        }

        .list{
          margin-top: 5%;
        }
        .add{
          margin-top: 9%;
        }
        .orders{
          margin-top: 11%;
        }
        .logout{
          margin-top: 44%;
        }

        .btn-generate-qr{
           width: 86px;
           height: 65px;
           color: white;
        }
    </style>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item"><br>
                            <a class="nav-link active" href="#">
                                Dashboard <i class="fa-solid fa-chart-line"></i>
                            </a>
                        </li><br>
                        <li class="nav-item list">
                            <a class="nav-link" href="/inventory">
                                Product List <i class="fa-solid fa-list"></i>
                            </a>
                        </li><br>
                        <li class="nav-item add">
                            <a class="nav-link" href="/inventory/create">
                                Add Product <i class="fa-solid fa-plus"></i>
                            </a>
                        </li><br>
                        <li class="nav-item orders">
                            <a class="nav-link" href="/inventory/orders"><br>
                                Orders <i class="fa-solid fa-bag-shopping"></i>
                            </a>
                        </li><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        <li class="nav-item logout">
                        <a class="nav-link" href="javascript:void(0);" onclick="confirmLogout()">
                            <i class="fa-solid fa-door-open"></i>  Log Out 
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="container">
                    <?= $this->renderSection('body') ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        function confirmLogout() {
            var confirmLogout = confirm("Are you sure you want to logout?");
            if (confirmLogout) {
                window.location.href = "/logout"; // Redirect to logout page
            }
        }
    </script>
  </body>
</html>
