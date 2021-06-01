<?php
    require_once("../../database/config.php");
    $db = Database::getInstance();
    // select item.id as id, item.quantity as quantity, item.price as price, item.orders_id as orders_id, item.product_id as product_id, product.name as product_name, count(orders_id) from item inner join product on product.id = item.product_id inner join orders on orders.id = item.orders_id where orders_id != 'NULL' and orders.status = 'complete' group by product.name order by count(product.name) desc;
    $result_most_sales = $db -> query("select item.id as id, item.price as price, product.name as product_name, count(orders_id) as total_sold from item inner join product on product.id = item.product_id inner join orders on orders.id = item.orders_id where orders_id != 'NULL' and orders.status_id = '2' group by product.name order by count(product.name) desc limit 5")
    or die("Query Failed: ".$db -> error);
    // select user.username as username, orders.id as orders_id, orders.status as ordres_status, sum(payment.total) as total_purchase from orders inner join user on user.id = orders.user_id inner join payment on payment.orders_id = orders.id where orders.status = 'complete' group by user.username order by sum(payment.total) desc;
    $result_most_purchased_user = $db -> query("select user.username as username, user.name as name, sum(payment.total) as total_purchase from orders inner join user on user.id = orders.user_id inner join payment on payment.orders_id = orders.id where orders.status_id = '2' group by user.username order by sum(payment.total) desc limit 5") 
    or die("Query Error: ".$db -> error);
    $counter = 0;
?>
<div class="card-panel z-depth-2"  style="margin-bottom: 3rem;">
    <div class="row">
        <div class="col s12">
            <?php if($result_most_sales -> num_rows > 0): ?>
                <h4 class="center" style="margin-bottom: 2rem;">
                    Most Product Sold
                </h4>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Quantity Sold</th>
                            <th>Total Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($result_most_sales as $row): ?>
                        <?php //echo "<pre>", print_r($row), "</pre>"; ?>
                        <tr>
                            <td> <?php echo ++$counter; ?> </td>
                            <td> <?php echo $row['product_name']; ?> </td>
                            <td> <?php echo "RM ".number_format($row['price']); ?> </td>
                            <td> <?php echo $row['total_sold']; ?> </td>
                            <th class="light-blue-text darken-1"> <?php echo "RM ".number_format($row['price'] * $row['total_sold']); ?> </th>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card-panel z-depth-2"  style="margin-bottom: 3rem;">
    <div class="row">
        <div class="col s12">
            <?php if($result_most_purchased_user -> num_rows > 0):  $counter = 0; ?>
                <h4 class="center" style="margin-bottom: 2rem;">
                    Most Purchased User
                </h4>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Total Purchased</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($result_most_purchased_user as $row): ?>
                        <?php //echo "<pre>", print_r($row), "</pre>"; ?>
                        <tr>
                            <td> <?php echo ++$counter; ?> </td>
                            <td> <?php echo $row['username']; ?> </td>
                            <td> <?php echo $row['name']; ?> </td>
                            <th class="light-blue-text darken-1"> <?php echo "RM ".number_format($row['total_purchase']); ?> </th>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>