<?php

require "connection.php";

if (isset($_GET["id"])) {
    $txt = $_GET["id"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE '%" . $txt . "%'");
    $product_num = $product_rs->num_rows;

    if ($product_num == 1) {

        $product_data = $product_rs->fetch_assoc();
?>

        <?php
        $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `product_id`='" . $product_data["id"] . "'");
        $invoice_data = $invoice_rs->fetch_assoc();
        ?>
        <div class="col-1 bg-secondary text-end">
            <label class="form-label fs-5 fw-bold text-white mt-1 mb-1"><?php echo ($invoice_data["id"]); ?></label>
        </div>

        <div class="col-3 bg-body text-end">
            <label class="form-label fs-5 fw-bold text-black mt-1 mb-1"><?php echo ($product_data["title"]); ?></label>
        </div>
        <?php
        $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $invoice_data["user_email"] . "'");
        $user_data = $user_rs->fetch_assoc();
        ?>
        <div class="col-3 bg-secondary text-end">
            <label class="form-label fs-5 fw-bold text-white mt-1 mb-1"><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></label>
        </div>
        <div class="col-2 bg-body text-end">
            <label class="form-label fs-5 fw-bold text-black mt-1 mb-1">Rs. <?php echo ($invoice_data["total"]); ?> .00</label>
        </div>
        <div class="col-1 bg-secondary text-end">
            <label class="form-label fs-5 fw-bold text-white mt-1 mb-1"><?php echo ($invoice_data["qty"]); ?></label>
        </div>
        <div class="col-2 bg-white d-grid">
            <?php
            if ($invoice_data["status"] == 0) {
            ?>
                <button class="btn btn-success fw-bold mt-1 mb-1" id="btn<?php echo ($invoice_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($invoice_data['id']); ?>');">Confirm Oder</button>
            <?php
            } else if ($invoice_data["status"] == 1) {
            ?>
                <button class="btn btn-warning fw-bold mt-1 mb-1" id="btn<?php echo ($invoice_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($invoice_data['id']); ?>');">Paccking</button>
            <?php
            } else if ($invoice_data["status"] == 2) {
            ?>
                <button class="btn btn-info fw-bold mt-1 mb-1" id="btn<?php echo ($invoice_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($invoice_data['id']); ?>');">Dispatch</button>
            <?php
            } else if ($invoice_data["status"] == 3) {
            ?>
                <button class="btn btn-primary fw-bold mt-1 mb-1" id="btn<?php echo ($invoice_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($invoice_data['id']); ?>');">Shipping</button>
            <?php
            } else if ($invoice_data["status"] == 4) {
            ?>
                <button class="btn btn-danger fw-bold mt-1 mb-1" id="btn<?php echo ($invoice_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($invoice_data['id']); ?>');" disabled>Delivered</button>
            <?php
            }
            ?>

        </div>

    <?php

    } else {
    ?>
        <?php
        $query = "SELECT * FROM `invoice`";
        $pageno;

        if (isset($_GET["page"])) {
            $pageno = $_GET["page"];
        } else {
            $pageno = 1;
        }

        $invoice_rs = Database::search($query);
        $invoice_num = $invoice_rs->num_rows;


        $results_per_page = 5;
        $number_of_pages = ceil($invoice_num / $results_per_page);

        $page_results = ($pageno - 1) * $results_per_page;
        $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

        $selected_num = $selected_rs->num_rows;

        for ($x = 0; $x < $selected_num; $x++) {
            $selected_data = $selected_rs->fetch_assoc();

            $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $selected_data["product_id"] . "'");
            $product_data = $product_rs->fetch_assoc();
        ?>
            <div class="col-1 bg-secondary text-end">
                <label class="form-label fs-5 fw-bold text-white mt-1 mb-1"><?php echo ($selected_data["id"]); ?></label>
            </div>
            <div class="col-3 bg-body text-end">
                <label class="form-label fs-5 fw-bold text-black mt-1 mb-1"><?php echo ($product_data["title"]); ?></label>
            </div>
            <?php
            $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $selected_data["user_email"] . "'");
            $user_data = $user_rs->fetch_assoc();
            ?>
            <div class="col-3 bg-secondary text-end">
                <label class="form-label fs-5 fw-bold text-white mt-1 mb-1"><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></label>
            </div>
            <div class="col-2 bg-body text-end">
                <label class="form-label fs-5 fw-bold text-black mt-1 mb-1">Rs. <?php echo ($selected_data["total"]); ?> .00</label>
            </div>
            <div class="col-1 bg-secondary text-end">
                <label class="form-label fs-5 fw-bold text-white mt-1 mb-1"><?php echo ($selected_data["qty"]); ?></label>
            </div>
            <div class="col-2 bg-white d-grid">
                <?php
                if ($selected_data["status"] == 0) {
                ?>
                    <button class="btn btn-success fw-bold mt-1 mb-1" id="btn<?php echo ($selected_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($selected_data['id']); ?>');">Confirm Oder</button>
                <?php
                } else if ($selected_data["status"] == 1) {
                ?>
                    <button class="btn btn-warning fw-bold mt-1 mb-1" id="btn<?php echo ($selected_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($selected_data['id']); ?>');">Paccking</button>
                <?php
                } else if ($selected_data["status"] == 2) {
                ?>
                    <button class="btn btn-info fw-bold mt-1 mb-1" id="btn<?php echo ($selected_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($selected_data['id']); ?>');">Dispatch</button>
                <?php
                } else if ($selected_data["status"] == 3) {
                ?>
                    <button class="btn btn-primary fw-bold mt-1 mb-1" id="btn<?php echo ($selected_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($selected_data['id']); ?>');">Shipping</button>
                <?php
                } else if ($selected_data["status"] == 4) {
                ?>
                    <button class="btn btn-danger fw-bold mt-1 mb-1" id="btn<?php echo ($selected_data['id']); ?>" onclick="changeInvoiceStatus('<?php echo ($selected_data['id']); ?>');" disabled>Delivered</button>
                <?php
                }
                ?>

            </div>
        <?php
        }
        ?>
<?php
    }
}

?>