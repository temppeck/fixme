<?php

print('<div class="container">');
print('<div class="row">
            <div class="col-lg-12 text-center">
                <h1>Guestbook</h1>
            </div>
        </div>
        <!-- /.row -->
    ');

global $db;

if (isset($_POST['entry']) && $_POST['entry'] != "") {
    $id = $_SESSION['userid'];
    $entry = $_POST['entry'];

    $mysql_query = $db_pdo->prepare("select * from `users` where `id` = ? LIMIT 1");
    $mysql_query -> bindParam(1, $id);
    $mysql_query -> execute();
    $mysql_list = $mysql_query -> fetch(PDO::FETCH_ASSOC);
    
    if ($mysql_list) {
        $username = $mysql_list['username'];
    }

    $entry = strip_tags($entry);
    $entry = htmlspecialchars($entry);

    $mysql_query = $db_pdo->prepare("INSERT INTO `guestbook` (`username`, `entry`) VALUES (?, ?);");
    $mysql_query -> bindParam(1, $username);
    $mysql_query -> bindParam(2, $entry);
    $mysql_query -> execute();

    print('<div class="row">
            <div class="col-lg-12 text-center">
                Your entry was recorded.
            </div>
        </div>');
}


    $mysql_query = $db_pdo->prepare("select * from `guestbook` ORDER BY `id` DESC ");
    $mysql_query -> execute();
    $result = $mysql_query -> fetchAll(PDO::FETCH_ASSOC);

if ($mysql_query->rowCount() > 0) {
    print('<table class="table table-striped table-responsive"><thead><tr><th>Author</th><th>Entry</th></tr></thead><tbody>');
    foreach ($result as $row) {
        $username = $row['username'];
        $entry = $row['entry'];
        print('<tr><td>' . $username . '</td><td>' . $entry . '</td></tr>');
    }
    print('</tbody></table>');
} else {
    print('<div class="row">
            <div class="col-lg-12 text-center">
                Sorry. There is nothing here!
            </div>
        </div>
        <!-- /.row -->
    ');
}

if (logged_in()) {
    print('<div class="row">
            <div class="col-lg-12 text-center">
    <form action="#" method="POST">
    <textarea class="form-control" rows="4" cols="50" name="entry" id="entry" value="entry" label="entry" placeholder="My entry ..."></textarea><br />
    <input class="btn btn-default" type="submit" name="submit" id="submit" value="submit" label="submit" />
    </form>
            </div>
        </div>
        <!-- /.row -->
    ');
} else {
    print('<div class="row">
            <div class="col-lg-12 text-center">
                Sorry. You need to log in to write something.
            </div>
        </div>
        <!-- /.row -->
    ');
}


print('
    </div>
    <!-- /.container -->');
