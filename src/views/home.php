<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/reset.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/style.css">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img style="width: 40px" src="/public/logo.png">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php if(isset($_SESSION) && $_SESSION['name']): ?>
                    Hi, <strong><?php echo $_SESSION['name'] ?></strong>
                <?php endif?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <div class="d-flex">
                    <?php if(isset($_SESSION) && $_SESSION["name"] && $_SESSION["email"]): ?>
                        <a href="/logout" class="btn btn-outline-danger">Logout</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-success" style="margin-right: 5px;">Login</a>
                        <a href="/signup" class="btn btn-outline-primary">Signup</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Tags
                    </div>
                    <div id="tag-list" class="card-body d-flex-wrap">
                        <?php if(is_array($data['tags'])):?>
                            <?php foreach ($data['tags'] as $tag):?>
                                <div class="badge bg-secondary">#<?php echo $tag['title'] ?></div>
                            <?php endforeach;?>
                        <?php endif?>
                    </div>
                </div>
                <?php if($_SESSION['id']): ?>
                    <div class="tag-create">
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fa fa-plus"></i>
                            Create new tag
                        </button>
                    </div>
                <?php endif?>
            </div>
            <div class="col-lg-8">
                <?php if($_SESSION['id']) :?>
                <a class="btn btn-outline-secondary" href="/posts/create" style="width: 100%; margin-bottom: 30px">
                    <i class="fa fa-plus"></i> Create new post
                </a>
                <?php endif?>
                <?php if(is_array($data['posts'])):?>
                <?php foreach ($data['posts'] as $key) : ?>
                    <div id="<?php echo 'post-'.$key['id']  ?>" class="post">
                        <div class="post__header">
                            <div class="post__header-image">
                                <img src="/public/user-icon.png">
                            </div>
                            <div class="post__header-info">
                                <div class="post__header-title"><?php echo $key['user_name']; ?></div>
                                <time class="post__header-time"><i class="fa fa-clock-o"></i> <?php echo $key['created_at']; ?></time>
                            </div>
                        </div>
                        <div class="post__body">
                            <div class="post__body-title">
                                <?php echo($key['title']); ?>
                            </div>
                            <div class="post__body-description">
                                <?php echo($key['content']); ?>
                            </div>
                            <div class="post__body-thumbnail">
                                <img src="<?php echo $key['thumbnail']; ?>">
                            </div>
                        </div>
                        <div class="post__footer">
                            <a class="text-success" href="/posts/show/<?php echo $key['id']; ?>" style="margin-right: 5px"><i class="fa fa-book"> See more </i></a>
                            <?php if($key['user_id'] == $_SESSION['id']): ?>
                                <a class="text-danger" onclick="deletePost(<?php echo $key['id'] ?>)"><i class="fa fa-trash"> Delete </i></a>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create new tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-create-tag">
                        <div class="mb-3 row">
                            <label class="col-form-label"><b>Title</b></label>
                            <div class="col-12">
                                <input id="tag-title" type="text" class="form-control" name="title">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label"><b>Description</b></label>
                            <div class="col-12">
                                <textarea id="tag-description" type="text" class="form-control" name="description" style="height: 150px"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createTag()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function createTag() {
            let title = document.getElementById("tag-title");
            let description = document.getElementById("tag-description");
            let form = new FormData(document.getElementById("form-create-tag"));

            fetch("/tags/create", {
                method: "POST",
                body: form
            })
                .then(res => res.json())
                .then(res => {
                    title.value = "";
                    description.value = "";
                    Swal.fire({
                        position: 'center',
                        icon: res.ok ? 'success' : 'error',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    let taglist = document.getElementById("tag-list");
                    console.log(taglist);
                    console.log(res);
                    let tag = document.createElement("div");
                    tag.appendChild(document.createTextNode(`#${res.tag.title}`))
                    tag.classList.add("badge");
                    tag.classList.add("bg-secondary");
                    taglist.appendChild(tag);
                });
        }

        function deletePost(id){
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("/posts/delete/"+id, {
                        method: "DELETE"
                    })
                    .then(res => res.json())
                    .then(res => {
                        if(res.ok){
                            $(`#post-${id}`).remove();
                        }
                        Swal.fire({
                            position: 'center',
                            icon: res.ok ? 'success' : 'error',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    });
                }
            })
        }
    </script>
</body>
</html>
