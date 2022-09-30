<?php 

    session_start();  
    ob_start();
    $pageTitle = 'HomePage';

  // session_start();
    include 'init.php';

      // echo "Welcome";
    // $stmt2 = $con->prepare("SELECT * FROM categories");
    // $stmt2->execute();
    // $cats = $stmt2->fetchAll();
    // foreach ($cats as $cat) {
    //     echo "<br>". $cat['Name'];
    // }

    // $categories = getCats();
    // foreach($categories as $cat) {
    //     echo $cat['Name'];
    // }
?>
    <div class="container">
        <div class="row">
                <?php
                    // $allItems = getAllFrom('items', 'item_ID', 'WHERE Approve = 1');
                    $allItems2 = getAllFromV2('*', 'items', 'WHERE Approve = 1', '', 'item_ID', 'DESC');
                    foreach ($allItems2 as $items) {
                        echo '<div class="col-sm-6 col-md-3">';
                            echo '<div class="thumbnail item-box">';
                                echo '<span class="price-tag">' . $items['Price']. '</span>';
                                echo '<img src="info.jpg" alt="" />'; 
                                echo '<div class="caption">';
                                    echo '<h3><a href="items.php?itemid=' . $items['item_ID']. '">' . $items['Name'] . '</a></h3>';
                                    echo '<p>' . $items['Description'] . '</p>';
                                    echo '<div class="date">' . $items['Add_Date'] . '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                ?>
        </div>
    </div>

<?php

    include $tpl . 'footer.php'; 
    ob_end_flush();
?>