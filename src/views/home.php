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
                <img style="width: 40px" src="/public/user-icon.png">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if($_SESSION['id']) :?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/posts">My posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/posts/create">Up post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profile">Profile</a>
                        </li>
                    <?php endif?>
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
            <div class="col-lg-8">
                <?php if($_SESSION['id']) :?>
                <div class="card">
                    <div class="card-body new-post">
                        <a class="create-post-btn" href="/posts/create"><i class="fa fa-plus"></i> Create new post</a>
                    </div>
                </div>
                <br/>
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
                                <div class="post__header-time"><i class="fa fa-clock-o"></i> <?php echo $key['created_at']; ?></div>
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
                            <a class="btn btn-outline-primary" href="/posts/show/<?php echo $key['id']; ?>" style="margin-right: 5px">Detail</a>
                            <?php if($key['user_id'] == $_SESSION['id']): ?>
                                <button class="btn btn-outline-danger" onclick="deletePost(<?php echo $key['id'] ?>)">Delete</button>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif;?>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Tags
                    </div>
                    <div class="card-body d-flex-wrap">
                        <div class="badge bg-secondary">#nguoiyeucu</div>
                        <div class="badge bg-primary">#nihon</div>
                        <div class="badge bg-danger">#newyear</div>
                        <div class="badge bg-success">#shop</div>
                        <div class="badge bg-secondary">#2021</div>
                        <div class="badge bg-warning">#corona</div>
                        <div class="badge bg-secondary">#prtimes</div>
                        <div class="badge bg-secondary">#tayori</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
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
