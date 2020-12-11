<?php

function login($username, $password)
{
    global $db_pdo;

    $mysql_query = $db_pdo->prepare("select `id` from `users` where `username` = ? AND `password` = ?");
    $mysql_query -> bindParam(1, $username);
    $mysql_query -> bindParam(2, $password);
    $mysql_query -> execute();
    $mysql_list = $mysql_query -> fetchAll(PDO::FETCH_ASSOC);

    if ($mysql_query->rowCount() > 0 && $mysql_list[0]['id']) {
        session_regenerate_id();
        $_SESSION['logged_in'] = true;
        $_SESSION['userid'] = $mysql_list[0]['id'];
        return(true);
    }
    print('<div class="row"><div class="col-lg-12 text-center" style="color:red;">Login unsuccessful!</div></div>');
    return(false);
}



print('<div class="container">');


if (logged_in() || (isset($_POST['username']) && isset($_POST['password']) && login($_POST['username'], $_POST['password']))) {
    $id = $_SESSION['userid'];

    global $db_pdo;

    $mysql_query = $db_pdo->prepare("select * from `users` where `id` = ? LIMIT 1");
    $mysql_query -> bindParam(1, $id);
    $mysql_query -> execute();
    $result = $mysql_query -> fetch(PDO::FETCH_ASSOC);


    if ($result) {
        $username = $result['username'];
    }

    print('<div class="row">
            <div class="col-lg-12 text-center">
                <h1>Private Area</h1>
                Hey ' . $username . '. Nice to have you here!
            <p>
                <a class="btn btn-danger" href="?site=logout.php">Logout</a>
            </p>
            </div>
        </div>
        <!-- /.row -->
    ');
} else {
    print('<div class="row">
            <div class="col-lg-offset-3 col-lg-6 text-center">
                <h1>Login</h1>
                <br />
                <form class="form-horizontal" action="#" method="POST">
                  <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input name="loggedin" id="loggedin" type="checkbox" checked="checked"> Remember me
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Sign in</button>
                    </div>
                  </div>
                </form>
                </div>
            </div>
            <!-- /.row -->');
}

print('
    </div>
    <!-- /.container -->');
