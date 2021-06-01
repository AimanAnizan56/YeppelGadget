<?php 
    session_start();
    require_once("../../database/config.php"); 
    $db = Database::getInstance();
?>
<div class="card-panel z-depth-2"  style="margin-bottom: 3rem;">
    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>Username</th>
                <th>Name</th>
                <th>User Role</th>
                <th>Created At</th>
                <th>Total Purchased</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $users = $db -> query("SELECT user.id, user.username, user.name, user.created_at, role.type as role_type FROM user INNER JOIN role ON user.role_id = role.id") or die("Query Error: ".$db -> error);

                foreach($users as $user): ?>
                <tr>
                    <td> <?php echo $user['id']; ?> </td>
                    <td> 
                        <?php 
                            if($user['id'] == $_SESSION['id'])
                                echo "<b class='light-blue-text text-darken-1'>".$user['username']."</b>"; 
                            else
                                echo $user['username']; 
                        ?> 
                    </td>
                    <td> <?php echo $user['name']; ?> </td>
                    <td> <?php echo ucwords($user['role_type']); ?> </td>
                    <td> <?php echo date("d F Y", strtotime($user['created_at'])); ?> </td>
                    <td>
                        <?php
                            if($user['role_type'] != 'admin'){
                                $total_purchased = $db -> query("select sum(total) as total from payment inner join orders on orders.id = payment.orders_id where orders.user_id = '".$user['id']."'");
                                if($total_purchased -> num_rows > 0){
                                    echo "RM ".number_format($total_purchased -> fetch_assoc()['total']);
                                }else {
                                    echo "RM 0";
                                }
                            }else {
                                echo "------------";
                            }
                        ?>
                    </td>
                    <td> 
                        <?php if($user['role_type'] != 'admin'): ?>
                            <a href="" onclick="event.preventDefault();confirmbox_deleteUser(<?php echo $user['id']; ?>)" class="transparent"><i class="material-icons red-text">delete</i></a> 
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach;
            ?>
        </tbody>
    </table>
</div>