<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/public/css/reset.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>SHOW POST INFORMATION</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>
<body style="background: #e1e1e1">
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
<div class="container" style="padding: 50px 0px;">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4>Post infomartion</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-form-label"><b>Title</b></label>
                        <div class="col-12">
                            <?php echo $data['post']['title']?>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-form-label"><b>Description</b></label>
                        <div class="col-12">
                            <?php echo $data['post']['content']?>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-form-label"><b>Tags</b></label>
                        <div class="col-12">
                            <div class="d-flex-wrap">
                                <?php if(is_array($data['tags'])):?>
                                    <?php foreach ($data['tags'] as $tag):?>
                                        <div class="badge bg-secondary">#<?php echo $tag['title'] ?></div>
                                    <?php endforeach;?>
                                <?php endif?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if($data['post']['user_id'] == $_SESSION['id']): ?>
                        <a href="/posts/edit/<?php echo $data['post']['id'] ?>" class="btn btn-primary">Edit</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="col-8 d-flex-wrap">
            <?php if(is_array($data['images'])): ?>
                <?php foreach ($data['images'] as $key) : ?>
                    <img class="img-fluid mx-auto d-block img-thumbnail" src="<?php echo $key['url']; ?>">
                <?php endforeach;?>
            <?php endif?>
        </div>
    </div>
</div>
</body>
</html>
