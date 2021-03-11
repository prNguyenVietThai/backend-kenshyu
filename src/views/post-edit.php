<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/reset.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body style="background: #e1e1e1">
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
        <?php if(isset($data) && $data['message'] != 'Permission denied' && $data['message'] != 'Unauthenticated'): ?>
            <div class="col-4">
                <?php if(isset($data['ok'])): ?>
                    <script>
                        Swal.fire({
                            position: 'center',
                            icon: '<?php echo($data["ok"] ? "success" : "error");?>',
                            title: '<?php echo $data['message']; ?>',
                            showConfirmButton: false,
                            timer: 1000,
                            allowOutsideClick: false
                        });
                        setTimeout(function (){
                            location.href = "/posts/edit/<?php echo $data['post']['id']; ?>";
                        }, 1000);
                    </script>
                <?php endif ?>

                <div class="card">
                    <form id="form-edit" action="/posts/edit/<?php echo $data['post']['id']; ?>" method="POST">
                    <div class="card-header">
                        <h4>Edit post</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-form-label"><b>Title</b></label>
                            <div class="col-12">
                                <input type="text" class="form-control" name="title" value="<?php echo $data['post']['title']?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label"><b>Description</b></label>
                            <div class="col-12">
                                <textarea type="text" class="form-control" name="content" style="height: 150px"><?php echo $data['post']['content']?></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label"><b>Use tags</b></label>
                            <div class="col-12">
                                <select id="tags" class="form-control" name="tags[]" multiple="multiple">
                                    <?php foreach ($data['tags'] as $tag):?>
                                        <option
                                                value="<?php echo $tag['id'] ?>"
                                                <?php if(is_numeric(array_search($tag['id'], array_map(function ($tag){
                                                    return $tag['id'];
                                                },$data['tagsOfPost'])))): ?>
                                                selected
                                                <?php endif?>
                                        ><?php echo $tag['title'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="_method" value="PATCH">
                    </div>
                    <div class="card-footer">
                        <button id="edit-post" type="submit" class="btn btn-success">Save</button>
                        <a href="/posts/show/<?php echo $data['post']['id'] ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </form>
                </div>

            </div>
            <div class="col-8 d-flex-wrap">
                <?php foreach ($data['images'] as $key) : ?>
                    <img class="img-fluid mx-auto d-block img-thumbnail" src="<?php echo $key['url']; ?>">
                <?php endforeach;?>
            </div>
        <?php else: ?>
            <h4 class="text-center"><?php echo $data['message']?></h4>
        <?php endif ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tags').select2();
    });
    function checkTag(tagId, arrTag) {
        for(let i=0; i< arrTag.length; i++){
            if(tagId == arrTag[i]){
                return true;
            }
        }
        return false;
    }
</script>
</body>
</html>
