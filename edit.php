<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<?php
/**
 * Nạp kết nối CSDL
 */
include_once "config.php";
/**
 * Lấy id từ trên url xuống
 */
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

$sqlSelect = "SELECT * FROM newwords WHERE id=".$id;

$result = $connection->query($sqlSelect);

$row = $result->fetch_assoc();

?>

<?php
/**
 * Kiểm tra xem có dữ liệu submit đi hay không
 * !empty($_POST) có nghĩa là không rỗng tức là có dữ liệu trong mảng này
 * isset($_POST) dùng để kiểm tra biến có tồn tại hay không
 */
if (isset($_POST) && !empty($_POST) && isset($_POST["id"])) {

    /**
     * Tạo ra 1 biến để check lỗi mặc định là rỗng
     */
    $errors = array();

    /**
     * !isset($_POST["name"]) => không tồn tại
     *  empty($_POST["name"]) => rỗng
     */
    if (!isset($_POST["newword"]) || empty($_POST["newword"])) {
        $errors[] = "Từ mới không hợp lệ";
    }

    if (!isset($_POST["mean"]) || empty($_POST["mean"])) {
        $errors[] = "Ý nghĩa không hợp lệ";
    }

    if (!isset($_POST["type"]) || empty($_POST["type"])) {
        $errors[] = "Kiểu từ không hợp lệ";
    }

    /**
     * $errors rỗng tức là không có lỗi
     */
    if (empty($errors)) {
        $id = (int) $_POST["id"];
        $newword = $_POST['newword'];
        $mean = $_POST['mean'];
        $type = $_POST['type'];

        $sqlUpdate = "UPDATE newwords SET newword='$newword',mean='$mean',type='$type' WHERE id=$id";
        // Thực hiện câu SQL

        echo $sqlUpdate;
        $result = $connection->query($sqlUpdate);

        if ($result == true) {
            echo "<div class='alert alert-success'>
Sửa thành công ! <a href='index.php'>Trang chủ</a>
</div>";
        } else {
            echo "<div class='alert alert-danger'>
Sua thất bại !
</div>";
        }
    }else{
        /**
         * Chuyển mảng $errors thành chuỗi = hàm implode()
         */
        $errors_string = implode("<br>", $errors);
        echo "<div class='alert alert-danger'>$errors_string</div>";
    }
}
?>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <img src="toeic.png" width="40px" height="40px" style="margin-right: 10px;margin-left: 20px ">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="search.php">Từ điển</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">
                            <span data-feather="layers"></span>
                            Dictionaries home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <span data-feather="home"></span>
                            English <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file"></span>
                            American English
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="shopping-cart"></span>
                            Academic
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="users"></span>
                            <Collocations></Collocations>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="bar-chart-2"></span>
                            German-English
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Grammar</span>
                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Grammar home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Practical English Usage
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2""><h1>Sửa từ mới : </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar"></span>
                        This week
                    </button>
                </div>
            </div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Sửa từ mới</h1>
            <form name="edit" action="" method="post">

                <input type="hidden" name="id" value="<?php echo $row["id"] ?>">

                <div class="form-group">
                    <label>Từ mới:</label>
                    <input type="text" name="newword" class="form-control" value="<?php echo $row["newword"] ?>">
                </div>
                <div class="form-group">
                    <label>Ý nghĩa:</label>
                    <input type="text" name="mean" class="form-control" value="<?php echo $row["mean"] ?>">
                </div>
                <div class="form-group">
                    <label>Kiểu từ:</label>
                    <input type="text" name="type" class="form-control" value="<?php echo $row["type"] ?>">
                </div>

                <button type="submit" class="btn btn-warning">sửa từ mới</button>
                <a href="index.php" class="btn btn-info">Quay lại</a>
            </form>

        </div>
    </div>
</div>
            <!-- FOOTER -->
            <footer class="pt-4 my-md-5 pt-md-5 border-top" style="margin-left:30px ">
                <div class="row">
                    <div class="col-12 col-md">
                        <img class="mb-2" src="toeic.png" alt="" width="24" height="24">
                        <small class="d-block mb-3 text-muted">&copy; 2017-2020</small>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Features</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Cool stuff</a></li>
                            <li><a class="text-muted" href="#">Random feature</a></li>
                            <li><a class="text-muted" href="#">Team feature</a></li>
                            <li><a class="text-muted" href="#">Stuff for developers</a></li>
                            <li><a class="text-muted" href="#">Another one</a></li>
                            <li><a class="text-muted" href="#">Last time</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Resources</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Resource</a></li>
                            <li><a class="text-muted" href="#">Resource name</a></li>
                            <li><a class="text-muted" href="#">Another resource</a></li>
                            <li><a class="text-muted" href="#">Final resource</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>About</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Team</a></li>
                            <li><a class="text-muted" href="#">Locations</a></li>
                            <li><a class="text-muted" href="#">Privacy</a></li>
                            <li><a class="text-muted" href="#">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </footer>
</body>
</html>