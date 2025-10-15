<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Watchlist | eShop</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "header.php";

            if (isset($_SESSION["u"])) {

            ?>

                <div class="col-12">
                    <div class="row">

                        <div class="col-12 border border-1 border-primary rounded mb-2">
                            <div class="row">

                                <div class="col-12">
                                    <label class="form-label fs-1 fw-bold">Watchlist &hearts;</label>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <hr />
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="offset-lg-2 col-12 col-lg-6 mb-3">
                                            <input type="text" class="form-control" placeholder="Search in Watchlist..." id="text" onkeyup="watchlistSearch();"/>
                                        </div>
                                        <div class="col-12 col-lg-2 mb-3 d-grid">
                                            <button class="btn btn-primary" onclick="watchlistSearch();">Search</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>

                                <div class="col-11 col-lg-2 border-0 border-end border-1 border-primary">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Watchlist</li>
                                        </ol>
                                    </nav>
                                    <nav class="nav nav-pills flex-column">
                                        <a class="nav-link active" aria-current="page" href="watchlist.php">My Watchlist</a>
                                        <a class="nav-link" href="cart.php">My Cart</a>
                                        <a class="nav-link" href="#">Recents</a>
                                    </nav>
                                </div>

                                <?php
                                require "connection.php";
                                $user = $_SESSION["u"]["email"];

                                $watch_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $user . "'");
                                $watch_num = $watch_rs->num_rows;

                                if ($watch_num == 0) {

                                ?>

                                    <!-- empty view -->
                                    <div class="col-12 col-lg-9">
                                        <div class="row">
                                            <div class="col-12 emptyView"></div>
                                            <div class="col-12 text-center">
                                                <label class="form-label fs-1 fw-bold">You have no items in your Watchlist yet.</label>
                                            </div>
                                            <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                                <a href="home.php" class="btn btn-outline-warning fs-3 fw-bold">Start Shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- empty view -->

                                <?php

                                } else {
                                ?>
                                    <div class="col-12 col-lg-9">
                                        <div class="row" id="view">
                                            <?php
                                            for ($x = 0; $x < $watch_num; $x++) {
                                                $watch_data = $watch_rs->fetch_assoc();
                                            ?>

                                                <!-- have Products -->


                                                <div class="card mb-3 mx-0 mx-lg-2 col-12">
                                                    <div class="row g-0">
                                                        <?php
                                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$watch_data["product_id"]."'");
                                                        $product_data = $product_rs->fetch_assoc();

                                                        $p_color_rs = Database::search("SELECT * FROM `colour` WHERE `id`='".$product_data["colour_id"]."'");
                                                        $p_color_data = $p_color_rs->fetch_assoc();

                                                        $con_rs = Database::search("SELECT * FROM `condition` WHERE `id`='".$product_data["condition_id"]."' ");
                                                        $con_data = $con_rs->fetch_assoc();

                                                        $img_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='".$watch_data["product_id"]."'");
                                                        $img_data = $img_rs->fetch_assoc();
                                                        ?>
                                                        <div class="col-md-3 mt-3">
                                                            <img src="<?php echo($img_data["code"]); ?>" class="img-fluid rounded-start" style="height: 200px;" />
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="card-body">
                                                                <h5 class="card-title fs-2 fw-bold text-primary"><?php echo($product_data["title"]); ?></h5>
                                                                <span class="fs-5 fw-bold text-black-50">Color : <?php echo($p_color_data["name"]); ?></span>
                                                                &nbsp;&nbsp; | &nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold text-black-50">Condition : <?php echo($con_data["name"]); ?></span><br />
                                                                <span class="fs-5 fw-bold text-black-50">Price : </span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold text-black">Rs : <?php echo($product_data["price"]); ?> .00</span><br />
                                                                <span class="fs-5 fw-bold text-black-50">Quantity : </span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold text-black"><?php echo($product_data["qty"]); ?> Items Available</span><br />
                                                                <span class="fs-5 fw-bold text-black-50">Seller : </span><br />
                                                                <span class="fs-5 fw-bold text-black"><?php echo($_SESSION["u"]["fname"]); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-lg-5">
                                                            <div class="card-body d-grid d-lg-grid">
                                                                <a href='<?php echo ("singleProductView.php?id=" . $product_data["id"]); ?>' class="btn btn-outline-success mb-2">Buy Now</a>
                                                                <a href="#" class="btn btn-outline-warning mb-2" onclick='addToCart(<?php echo ($watch_data["id"]); ?>);'>Add To Cart</a>
                                                                <a href="#" class="btn btn-outline-danger" onclick='removeFromWatchlist(<?php echo ($watch_data["id"]); ?>);'>Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- have Products -->

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }

                                ?>





                            </div>
                        </div>

                    </div>
                </div>

            <?php

            } else {
                echo ("Please Login First");
            }

            ?>

            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>