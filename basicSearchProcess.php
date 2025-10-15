<?php

require "connection.php";

$txt = $_POST["t"];
$select = $_POST["s"];

$query = "SELECT * FROM `product`";

if (!empty($txt) && $select == 0) {
    $query .= " WHERE `title` LIKE '%" . $txt . "%'";
} else if (empty($txt) && $select != 0) {
    $query .= " WHERE `category_id`='" . $select . "'";
} else if (!empty($txt) && $select != 0) {
    $query .= " WHERE `title` LIKE '%" . $txt . "%' AND `category_id`='" . $select . "' ";
}

?>

<div class="row">
    <div class="offset-lg-2 col-12 col-lg-10  text-center">
        <div class="row">

            <?php


            if ("0" != ($_POST["page"])) {
                $pageno = $_POST["page"];
            } else {
                $pageno = 1;
            }

            $product_rs = Database::search($query);
            $product_num = $product_rs->num_rows;


            $results_per_page = 10;
            $number_of_pages = ceil($product_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

            $selected_num = $selected_rs->num_rows;

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();
                $product_data = $product_rs->fetch_assoc();

                $image_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $product_data["id"] . "' ");
                $image_data = $image_rs->fetch_assoc();
            ?>

                <div class="card" style="width: 18rem;">
                    <img src="<?php echo ($image_data["code"]) ?>" class="card-img-top" style="height: 180px;" />
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo ($product_data["title"]); ?> <br /> <span class="badge bg-info">New</span></h5>
                        </h5>
                        <span class="card-text text-primary">Rs. <?php echo ($product_data["price"]); ?> .00</span><br />

                        <?php

                        if ($product_data["qty"] > 0) {

                        ?>

                            <span class="card-text text-warning fw-bold">In Stock</span> <br />
                            <span class="card-text text-success fw-bold"><?php echo ($product_data["qty"]); ?> Items Available</span> <br /><br /><br />

                            <button class="col-12 btn btn-success" onclick="window.location = 'singleProductView.php';">Buy Now</button>
                            <button class="col-12 btn btn-danger mt-2" onclick="window.location = 'cart.php';">Add to Cart</button>

                        <?php

                        } else {

                        ?>

                            <span class="card-text text-danger fw-bold">Out of Stock</span> <br />
                            <span class="card-text text-danger fw-bold">0 Items Available</span> <br /><br /><br />

                            <button class="col-12 btn btn-success disabled">Buy Now</button>
                            <button class="col-12 btn btn-danger mt-2 disabled">Add to Cart</button>

                        <?php
                        }

                        ?>

                        <button class="col-12 btn btn-outline-light mt-2 border border-info"><i class="bi bi-heart-fill text-danger fs-5"></i></button>

                    </div>
                </div>

            <?php
            }
            ?>



        </div>
    </div>
    <!--  -->
    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php if ($pageno <= 1) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="basicSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                } ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php

                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $pageno) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="basicSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="basicSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }

                ?>

                <li class="page-item">
                    <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                echo ("#");
                                            } else {
                                            ?> onclick="basicSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                } ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!--  -->
</div>