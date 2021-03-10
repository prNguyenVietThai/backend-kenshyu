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
</head>
<body style="padding: 50px">
    <div class="row">
        <?php if(isset($data) && $data['message'] != 'Permission denied' && $data['message'] != 'Unauthenticated'): ?>
            <div class="col-4">
                <?php if(isset($data['ok']) && $data['ok']): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fa fa-check"></i></strong> <?php echo $data['message'];  ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif(isset($data['ok']) && !$data['ok']): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fa fa-close"></i></strong> <?php echo $data['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>

                <a class="btn btn-primary" href="/"><i class="fa fa-home"></i> Go to homepage</a>
                <hr>
                <h3 class="text-center">Post</h3><br>
                <form id="form-edit" action="/posts/edit/<?php echo $data['post']['id']; ?>" method="POST">
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
                    <input type="hidden" name="_method" value="PATCH">
                    <button id="edit-post" type="submit" class="btn btn-success">Save</button>
                    <a href="/posts/show/<?php echo $data['post']['id'] ?>" class="btn btn-danger">Cancel</a>
                </form>
                <br>
            </div>
            <div class="col-8 d-flex-wrap">
                <?php foreach ($data['images'] as $key) : ?>
                    <img class="img-fluid mx-auto d-block img-thumbnail" src="<?php echo $key['url']; ?>">
                    <br>
                <?php endforeach;?>
            </div>
        <?php else: ?>
            <h4 class="text-center"><?php echo $data['message']?></h4>
        <?php endif ?>
    </div>
</body>
</html>
