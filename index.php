<?php 

session_start();
$data = [];
$ch_len = "";
if(file_exists('data.json')){
    $json_data = file_get_contents('data.json');
    $data = json_decode($json_data,true)??[];
}

 if(isset($_POST['submit']) && !empty(trim($_POST['input_text']))){ 
    $new_task = trim($_POST['input_text']);
    array_unshift($data,   $new_task);
    file_put_contents('data.json',json_encode($data,JSON_PRETTY_PRINT));
 }

 if(isset($_GET['delete'])){
    unset($data[$_GET['delete']]);
    file_put_contents("data.json", json_encode(array_values($data), JSON_PRETTY_PRINT));
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
 if(isset($_GET['edit'])){
    $edit_index = $_GET['edit'];
    if(isset($_POST['update_task']) && !empty($_POST['input_text'])){
        $data[$edit_index] = trim($_POST['input_text']);
        file_put_contents('data.json',json_encode($data,JSON_PRETTY_PRINT));
        header("Location: ".$_SERVER['PHP_SELF']); 
        exit();
    }
 }
 
 if (isset($_POST['toggleTheme'])) {
    $_SESSION['theme'] = ($_SESSION['theme'] ?? 'dark') === 'light' ? 'light' : 'dark';
    exit(); // Stop execution after updating the session
}

// Set the theme (default: light)
$theme = $_SESSION['theme'] ?? 'dark';

?>
<!doctype html>
<html lang="en">

<head>
    <title>TODO LIST</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">

    <script>
    function counter() {
        let text = document.getElementsByName('input_text')[0].value;
        let ch_len = text.length;
        document.getElementById('ch-count').textContent = ch_len + " characters";
        let word_len = text.trim().split(/\s+/).length;
        if (word_len === "") {
            word_len = 0;
        }
        document.getElementById('word-count').textContent = word_len + " words";
    }
    </script>

</head>

<body class="<?= $theme ?>">
    <header class="container">
        <nav>
            <h1>To Do List</h1>
            <label>
                <i class="fa-solid fa-sun" id="sunIcon"></i>
                <input type="checkbox" id="modeToggle" role="switch" <?= $theme === 'dark' ? 'checked' : '' ?>>
                <i class="fa-solid fa-moon" id="moonIcon"></i>
            </label>
        </nav>
    </header>
    <main class="container">
        <article>
            <header>
                <?php if(isset($_GET['edit'])):?>
                <?php $edit_index = $_GET['edit']; ?>
                <form id="editForm" action="" method="post" oninput="counter();">
                    <fieldset role="group">
                        <input id="listInput" type="text" name="input_text" placeholder="Buy milk and eggs..."
                            value="<?=$data[$edit_index]?>">
                        <button class="add" type="submit" name="update_task"><i class="fa-solid fa-pen"></i></button>
                    </fieldset>
                    <small><span id="word-count"></span> <span id="ch-count"></span></small>
                </form>
                <?php else: ?>
                <form id="addForm" action="" method="post" oninput="counter();">
                    <fieldset role="group">
                        <input id="listInput" type="text" name="input_text" placeholder="Buy milk and eggs..." value="">
                        <button class="add" type="submit" name="submit"><i class="fa-solid fa-plus"></i></button>
                    </fieldset>
                    <small><span id="word-count"></span> <span id="ch-count"></span></small>
                </form>
                <?php endif;?>
            </header>
            <ul id="todolist" class="todolist">
                <?php foreach($data as $index => $task ): ?>
                <li>
                    <p style="padding-bottom:10px;"><?=$task?></p>
                    <div>
                        <a href="?edit=<?=$index?>"><i class="fa-solid fa-pen text-success"></i></a>

                        <a href="?delete=<?=$index?>"> <i class="fa-solid fa-trash"></i></a>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </article>
    </main>


    <script>
    document.getElementById("modeToggle").addEventListener("change", () => {
        fetch("", {
                method: "POST",
                body: "toggleTheme=true"
            })
            .then(() => document.body.classList.toggle("dark"));
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>