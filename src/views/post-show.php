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
<body style="padding: 50px">
<form>
    <div class="row">
        <div class="col-4">
            <a href="/"><i class="fa fa-home"></i> Go to homepage</a>
            <hr>
            <h3 class="text-center">Post</h3><br>
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

            <?php if($data['post']['user_id'] == $_SESSION['id']): ?>
                <a href="/posts/edit/<?php echo $data['post']['id'] ?>" class="btn btn-primary">Edit</a>
            <?php endif ?>
            <br>
        </div>
        <div class="col-8 d-flex-wrap">
            <?php if(is_array($data['images'])): ?>
                <?php foreach ($data['images'] as $key) : ?>
                    <img class="img-fluid mx-auto d-block img-thumbnail" src="<?php echo $key['url']; ?>">
                    <br>
                <?php endforeach;?>
            <?php endif?>
        </div>
    </div>
</form>
</body>
</html>
