<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cart | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "header.php";

            require "connection.php";

            if (isset($_SESSION["u"])) {

                $email = $_SESSION["u"]["email"];

                $total = 0;
                $subtotal = 0;
                $shipping = 0;

            ?>

                <div class="col-12 pt-3" style="background-color: #E3E5E4;">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>

                </div>

                <div class="col-12 border border-1 border-primary rounded mb-3">
                    <div class="row">

                        <div class="col-12">
                            <label class="form-label fs-1 fw-bolder">Cart <i class="bi bi-cart4 fs-1 text-success"></i></label>
                        </div>

                        <div class="col-12 col-lg-6">
                            <hr />
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="offset-lg-2 col-12 col-lg-6 mb-3">
                                    <input type="text" class="form-control" placeholder="Search in Cart..." id="search" onkeyup="cartSearch();"/>
                                </div>
                                <div class="col-12 col-lg-2 d-grid mb-3">
                                    <button class="btn btn-primary" onclick="cartSearch();">Search</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr />
                        </div>

                        <?php

                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "' ");
                        $cart_num = $cart_rs->num_rows;

                        if ($cart_num == 0) {
                        ?>
                            <!-- empty View -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 emptyCart"></div>
                                    <div class="col-12 text-center mb-2">
                                        <label class="form-label fs-1 fw-bold">
                                            You have no items in your Crat yet.
                                        </label>
                                    </div>
                                    <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                        <a href="home.php" class="btn btn-outline-info fs-3 fw-bold">Start Shopping</a>
                                    </div>
                                </div>
                            </div>
                            <!-- empty View -->
                        <?php
                        } else {
                        ?>

                            <div class="col-12">
                                <div class="row" id="view">

                                    <!-- products -->
                                    <div class="col-12 col-lg-9">
                                        <div class="row">

                                            <?php

                                            for ($x = 0; $x < $cart_num; $x++) {
                                                $cart_data = $cart_rs->fetch_assoc();

                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $cart_data["product_id"] . "'");
                                                $product_data = $product_rs->fetch_assoc();

                                                $total = $total + ($product_data["price"] * $cart_data["qty"]);

                                                $address_rs = Database::search("SELECT district.id AS did FROM `user_has_address` INNER JOIN `city` ON 
                                        user_has_address.city_id=city.id INNER JOIN `district` ON 
                                        city.district_id=district.id WHERE `user_email`='" . $email . "' ");

                                                $address_data = $address_rs->fetch_assoc();

                                                $ship = 0;

                                                if ($address_data["did"] == 2) {
                                                    $ship = $product_data["delivery_fee_colombo"];
                                                    $shipping = $shipping + $ship;
                                                } else {
                                                    $ship = $product_data["delivery_fee_other"];
                                                    $shipping = $shipping + $ship;
                                                }

                                                $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "' ");
                                                $seller_data = $seller_rs->fetch_assoc();
                                                $seller = $seller_data["fname"] . " " . $seller_data["lname"];

                                            ?>

                                                <div class="card mb-3 mx-0 col-12">
                                                    <div class="row g-0">
                                                        <div class="col-md-12 mt-3 mb-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <span class="fw-bold text-black-50 fs-5">Seller :</span>&nbsp;
                                                                    <span class="fw-bold text-black fs-5"><?php echo ($seller); ?></span>&nbsp;
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <?php
                                                        $img_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $product_data["id"] . "'");
                                                        $img_data = $img_rs->fetch_assoc();
                                                        ?>

                                                        <div class="col-md-4">
                                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                            data-bs-content="<?php echo ($product_data["description"]); ?>" title="Product Details">
                                                                <img src="<?php echo ($img_data["code"]); ?>" class="img-fluid rounded-start" style="max-width: 200px;">
                                                            </span>


                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="card-body">

                                                                <?php
                                                                $color_rs = Database::search("SELECT * FROM `colour` WHERE `id`='" . $product_data["colour_id"] . "'");
                                                                $color_data = $color_rs->fetch_assoc();

                                                                $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "'");
                                                                $condition_data = $condition_rs->fetch_assoc();
                                                                ?>

                                                                <h3 class="card-title"><?php echo ($product_data["title"]); ?></h3>

                                                                <span class="fw-bold text-black-50">Colour : <?php echo ($color_data["name"]); ?></span> &nbsp; |

                                                                &nbsp; <span class="fw-bold text-black-50">Condition : <?php echo ($condition_data["name"]); ?></span>
                                                                <br>
                                                                <span class="fw-bold text-black-50 fs-5">Price :</span>&nbsp;
                                                                <span class="fw-bold text-black fs-5">Rs.<?php echo ($product_data["price"]); ?>.00</span>
                                                                <br>

                                                                <div class="col-10 my-2">
                                                                    <div class="row g-2">
                                                                        <div class="border border-1 border-secondary rounded overflow-hidden 
                                                        float-left mt-1 position-relative product-qty">
                                                                            <div class="col-12">
                                                                                <span>Quantity : </span>
                                                                                <input type="text" class="border-0 fs-5 fw-bold text-start" style="outline: none;" pattern="[0-9]" value="1" id="qty_input" onkeyup='checkValue(<?php echo ($product_data["qty"]); ?>);' />

                                                                                <div class="position-absolute qty-buttons">
                                                                                    <div class="justify-content-center d-flex flex-column align-items-center 
                                                                border border-1 border-secondary qty-inc">
                                                                                        <i class="bi bi-caret-up-fill text-primary fs-5" onclick='qty_inc(<?php echo ($product_data["qty"]); ?>);'></i>
                                                                                    </div>
                                                                                    <div class="justify-content-center d-flex flex-column align-items-center 
                                                                border border-1 border-secondary qty-dec">
                                                                                        <i class="bi bi-caret-down-fill text-primary fs-5" onclick="qty_dec();"></i>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <br><br>
                                                                <?php
                                                                if ($address_data["did"] == 2) {
                                                                ?>
                                                                    <span class="fw-bold fs-5 text-black-50">Delivery Fee : </span>
                                                                    <span class="fs-6 text-black">Rs. <?php echo ($product_data["delivery_fee_colombo"]); ?> .00</span>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span class="fw-bold fs-5 text-black-50">Delivery Fee : </span>
                                                                    <span class="fs-6 text-black">Rs. <?php echo ($product_data["delivery_fee_other"]); ?> .00</span>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="card-body d-grid">
                                                                <a class="btn btn-outline-success mb-2">Buy Now</a>
                                                                <a class="btn btn-outline-danger mb-2" onclick="deleteFromCart(<?php echo ($cart_data['id']) ?>);">Remove</a>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <div class="col-md-12 mt-3 mb-3">
                                                            <div class="row">
                                                                <div class="col-6 col-md-6">
                                                                    <span class="fw-bold fs-5 text-black-50">Requested Total <i class="bi bi-info-circle"></i></span>
                                                                </div>
                                                                <div class="col-6 col-md-6 text-end">
                                                                    <span class="fw-bold fs-5 text-black-50">Rs.<?php echo ($product_data["price"] * $cart_data["qty"]) + $ship; ?>.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php

                                            }

                                            ?>



                                        </div>
                                    </div>
                                    <!-- products -->

                                    <!-- summary -->
                                    <div class="col-12 col-lg-3">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fs-3 fw-bold">Summary</label>
                                            </div>

                                            <div class="col-12">
                                                <hr />
                                            </div>

                                            <div class="col-6 mb-3">
                                                <span class="fs-6 fw-bold">items (<?php echo ($cart_num); ?>)</span>
                                            </div>

                                            <div class="col-6 text-end mb-3">
                                                <span class="fs-6 fw-bold">Rs. <?php echo ($total); ?> .00</span>
                                            </div>

                                            <div class="col-6">
                                                <span class="fs-6 fw-bold">Shipping</span>
                                            </div>

                                            <div class="col-6 text-end">
                                                <span class="fs-6 fw-bold">Rs. <?php echo ($shipping); ?> .00</span>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <hr />
                                            </div>

                                            <div class="col-6 mt-2">
                                                <span class="fs-5 fw-bold">Total</span>
                                            </div>

                                            <div class="col-6 mt-2 text-end">
                                                <span class="fs-5 fw-bold">Rs. <?php echo ($shipping + $total); ?> .00</span>
                                            </div>

                                            <div class="col-12 mt-3 mb-3 d-grid">
                                                <button class="btn btn-primary fs-5 fw-bold">CHECKOUT</button>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- summary -->

                                </div>
                            </div>

                        <?php
                        }

                        ?>





                    </div>
                </div>

            <?php

            } else {
                header("Location:index.php");
            }

            ?>

            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>

    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
    </script>
</body>

</html>