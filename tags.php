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
        <div class="row">
        <?php
            
            if(isset($_GET['name'])) {
                $tag = $_GET['name'];
                // echo "<h1 class='h1 text-center'>" .  $tag  . "</h1>";
                echo "<h1 class='h1 text-center'>" .  strtoupper($tag)  . "</h1>";

                $tagItems = getAllFromV2("*", "items", "WHERE Tags LIKE '%$tag%'", "AND Approve = 1", "item_ID", "DESC");
                
                foreach ($tagItems as $items) {
                    // echo $items['Name'] . '<br>';
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

            } else {
                echo "<div class='alert alert-danger'>You Must Enter Tag Name</div>";
            }
        ?>
        </div>
    </div>

<?php include $tpl . 'footer.php';  ?>