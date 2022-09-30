<?php
    // Printing The Page ID
    // echo 'Welcome To Categories Page<br>';
    // echo 'Your Page ID Is : ' . $_GET['pageid'] . '<br>';
    // echo 'Your Page Name Is : ' . str_replace('-', ' ', $_GET['pagename']);
?>

<?php 
    // echo str_replace('-', ' ', $_GET['pagename'])
    session_start();
    include 'init.php'; 
?>
    
    <div class="container">
        <h1 class="h1 text-center">Show Category Items</h1>
        <div class="row">
        <?php
            // $pageid = $_GET['pageid'];
            // $getItems = getAddItems('Cat_ID', $pageid);
            //  This Is Short If Code
            // $category = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0 ;

            if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
                $category = intval($_GET['pageid']);
                $getItems2 = getAllFromV2("*", "items", "WHERE Cat_ID = {$category}", "AND Approve = 1", "item_ID", "DESC");

                foreach ($getItems2 as $items) {
                    // echo $items['Name'] . '<br>';
                    echo '<div class="col-sm-6 col-md-3">';
                        echo '<div class="thumbnail item-box">';
                            echo '<span class="price-tag">' . $items['Price']. '</span>';
                            echo '<img src="is.jpg" alt="" />'; 
                            echo '<div class="caption">';
                                echo '<h3><a href="items.php?itemid=' . $items['item_ID']. '">' . $items['Name'] . '</a></h3>';
                                echo '<p>' . $items['Description'] . '</p>';
                                echo '<div class="date">' . $items['Add_Date'] . '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='alert alert-danger'>You Did Not Specified Page ID You Need To Add It</div>";
            }
        ?>
        </div>
    </div>

<?php include $tpl . 'footer.php';  ?>