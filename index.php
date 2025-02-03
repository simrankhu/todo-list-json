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

    <style>
    :root {
        --pico-background-color: #13171f;
        --pico-color: #c2c7d0;
        --pico-text-selection-color: rgba(1, 170, 255, 0.1875);
        --pico-muted-color: #7b8495;
        --pico-muted-border-color: #202632;
        --pico-primary: #01aaff;
        --pico-primary-background: #0172ad;
        --pico-primary-border: var(--pico-primary-background);
        --pico-primary-underline: rgba(1, 170, 255, 0.5);
        --pico-primary-hover: #79c0ff;
        --pico-primary-hover-background: #017fc0;
        --pico-primary-hover-border: var(--pico-primary-hover-background);
        --pico-primary-hover-underline: var(--pico-primary-hover);
        --pico-primary-focus: rgba(1, 170, 255, 0.375);
        --pico-primary-inverse: #fff;
        --pico-secondary: #969eaf;
        --pico-secondary-background: #525f7a;
        --pico-secondary-border: var(--pico-secondary-background);
        --pico-secondary-underline: rgba(150, 158, 175, 0.5);
        --pico-secondary-hover: #b3b9c5;
        --pico-secondary-hover-background: #5d6b89;
        --pico-secondary-hover-border: var(--pico-secondary-hover-background);
        --pico-secondary-hover-underline: var(--pico-secondary-hover);
        --pico-secondary-focus: rgba(144, 158, 190, 0.25);
        --pico-secondary-inverse: #fff;
        --pico-contrast: #dfe3eb;
        --pico-contrast-background: #eff1f4;
        --pico-contrast-border: var(--pico-contrast-background);
        --pico-contrast-underline: rgba(223, 227, 235, 0.5);
        --pico-contrast-hover: #fff;
        --pico-contrast-hover-background: #fff;
        --pico-contrast-hover-border: var(--pico-contrast-hover-background);
        --pico-contrast-hover-underline: var(--pico-contrast-hover);
        --pico-contrast-focus: rgba(207, 213, 226, 0.25);
        --pico-contrast-inverse: #000;
        --pico-box-shadow: 0.0145rem 0.029rem 0.174rem rgba(7, 9, 12, 0.01698), 0.0335rem 0.067rem 0.402rem rgba(7, 9, 12, 0.024), 0.0625rem 0.125rem 0.75rem rgba(7, 9, 12, 0.03), 0.1125rem 0.225rem 1.35rem rgba(7, 9, 12, 0.036), 0.2085rem 0.417rem 2.502rem rgba(7, 9, 12, 0.04302), 0.5rem 1rem 6rem rgba(7, 9, 12, 0.06), 0 0 0 0.0625rem rgba(7, 9, 12, 0.015);
        --pico-h1-color: #f0f1f3;
        --pico-h2-color: #e0e3e7;
        --pico-h3-color: #c2c7d0;
        --pico-h4-color: #b3b9c5;
        --pico-h5-color: #a4acba;
        --pico-h6-color: #8891a4;
        --pico-mark-background-color: #014063;
        --pico-mark-color: #fff;
        --pico-ins-color: #62af9a;
        --pico-del-color: #ce7e7b;
        --pico-blockquote-border-color: var(--pico-muted-border-color);
        --pico-blockquote-footer-color: var(--pico-muted-color);
        --pico-button-box-shadow: 0 0 0 rgba(0, 0, 0, 0);
        --pico-button-hover-box-shadow: 0 0 0 rgba(0, 0, 0, 0);

    }

    @media (min-width: 576px) {
        :root {
            --pico-font-size: 106.25%;
        }
    }

    body {

        background: var(--pico-background-color);

    }

    .todolist {
        padding-left: 0;
    }

    .todolist li {
        list-style: none;
        padding: var(--pico-form-element-spacing-vertical) 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .todolist i {
        cursor: pointer;
    }

    .todolist li:not(:last-child) {
        border-bottom: 1.5px solid var(--pico-form-element-border-color);
    }

    .todolist>li>label:has(input:checked) {
        text-decoration: line-through;
    }

    footer {
        text-align: center;
    }

    form>small {
        text-align: right;
    }

    #modeToggle {
        margin-left: .5rem;
    }

    nav {
        display: flex;
        justify-content: space-between;
        padding: 20px 20px;
    }

    nav h1 {
        color: var(--pico-h1-color);
        margin-top: 0;
        margin-bottom: 10px;
        font-weight: 800;
        font-size: 2rem;
        line-height: 1.25;

        font-family: system-ui, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, Helvetica, Arial, "Helvetica Neue", sans-serif;
    }

    nav i {
        color: var(--pico-color);
    }

    article {
        margin-bottom: 10px;
        padding: 20px 0px;
        border-radius: 10px;
        background: #181c25;
        box-shadow: var(--pico-card-box-shadow);
        color: var(--pico-color);
    }

    article>header {
        margin-top: calc(var(--pico-block-spacing-vertical)* -1);
        margin-bottom: var(--pico-block-spacing-vertical);
        border-bottom: #181c25;
        border-top-right-radius: var(--pico-border-radius);
        border-top-left-radius: var(--pico-border-radius);
        margin-right: calc(var(--pico-block-spacing-horizontal)* -1);
        margin-left: calc(var(--pico-block-spacing-horizontal)* -1);
        padding: 20px 20px;
        background-color: #1a1f28;
    }

    [role=group],
    [role=search] {
        display: inline-flex;
        position: relative;
        width: 100%;
        margin-bottom: var(--pico-spacing);
        border-radius: var(--pico-border-radius);
        box-shadow: var(--pico-group-box-shadow, 0 0 0 transparent);
        vertical-align: middle;
        transition: box-shadow var(--pico-transition);
    }

    .add {
        background: #0172ad;
        color: var(--pico-primary-inverse);
        border: none;
        padding: 10px 20px;

    }

    form {
        width: 90%;
        margin: 0px auto;

    }

    form input {
        padding: 10px 20px;
        width: 80%;
    }

    .todolist {
        padding: 10px 60px;
    }

    .todolist i {
        color: red;
    }

    .container {
        /* max-width: 510px;
        padding-right: 0;
        padding-left: 0; */
    }
    </style>
</head>

<body>
    <header class="container">
        <nav>
            <h1>To Do List</h1>
            <label>
                <i class="fa-solid fa-sun"></i>
                <i class="fa-solid fa-moon"></i>
                <input type="checkbox" id="modeToggle" role="switch">
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



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>