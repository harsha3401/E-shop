<?php
session_start();
require "connection.php";

if (!empty($_GET["t"])) {

    $txt = $_GET["t"];

    $w_rs = Database::search("SELECT * FROM `watchlist` INNER JOIN `product` ON
    watchlist.product_id=product.id WHERE `title` LIKE '%" . $txt . "%'");
    $w_num = $w_rs->num_rows;


    if ($w_num == 1) {

?>
        <?php
        for ($x = 0; $x < $w_num; $x++) {
            $watch_data = $w_rs->fetch_assoc();

        ?>

            <!-- have Products -->


            <div class="card mb-3 mx-0 mx-lg-2 col-12">
                <div class="row g-0">
                    <?php
                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $watch_data["product_id"] . "'");
                    $product_data = $product_rs->fetch_assoc();

                    $p_color_rs = Database::search("SELECT * FROM `colour` WHERE `id`='" . $product_data["colour_id"] . "'");
                    $p_color_data = $p_color_rs->fetch_assoc();

                    $con_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "' ");
                    $con_data = $con_rs->fetch_assoc();

                    $img_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $watch_data["product_id"] . "'");
                    $img_data = $img_rs->fetch_assoc();
                    ?>
                    <div class="col-md-3 mt-3">
                        <img src="<?php echo ($img_data["code"]); ?>" class="img-fluid rounded-start" style="height: 200px;" />
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <h5 class="card-title fs-2 fw-bold text-primary"><?php echo ($product_data["title"]); ?></h5>
                            <span class="fs-5 fw-bold text-black-50">Color : <?php echo ($p_color_data["name"]); ?></span>
                            &nbsp;&nbsp; | &nbsp;&nbsp;
                            <span class="fs-5 fw-bold text-black-50">Condition : <?php echo ($con_data["name"]); ?></span><br />
                            <span class="fs-5 fw-bold text-black-50">Price : </span>&nbsp;&nbsp;
                            <span class="fs-5 fw-bold text-black">Rs : <?php echo ($product_data["price"]); ?> .00</span><br />
                            <span class="fs-5 fw-bold text-black-50">Quantity : </span>&nbsp;&nbsp;
                            <span class="fs-5 fw-bold text-black"><?php echo ($product_data["qty"]); ?> Items Available</span><br />
                            <span class="fs-5 fw-bold text-black-50">Seller : </span><br />
                            <span class="fs-5 fw-bold text-black"><?php echo ($_SESSION["u"]["fname"]); ?></span>
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
    <?php

    } else {
    ?>
        <!-- empty view -->
        <div class="offset-5 col-2 mt-5">
            <span class="fw-bold text-black-50"><i class="bi bi-search" style="font-size: 100px;"></i></span>
        </div>
        <div class="col-12 text-center">
            <label class="form-label fs-1 fw-bold">This product has not been added to the watchlist.</label>
        </div>
        <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
            <a href="home.php" class="btn btn-outline-warning fs-3 fw-bold">Start Shopping</a>
        </div>
        <!-- empty view -->
<?php
    }
} else {
    echo ("no");
}
?>