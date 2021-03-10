<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/reset.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<div class="container">
    <br>
    <?php if(isset($_SESSION) && $_SESSION['id']) :?>
        <div class="row">
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
                            location.href = "/posts/create";
                        }, 1000);
                    </script>
                <?php endif ?>

                <a href="/"><i class="fa fa-home"></i> Go to homepage</a>
                <hr>
                <h3 class="text-center">Post</h3><br>
                <form enctype="multipart/form-data" action="/posts/create" method="POST">
                    <div class="mb-3 row">
                        <label class="col-form-label"><b>Title</b></label>
                        <div class="col-12">
                            <input type="text" class="form-control" name="title">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-form-label"><b>Description</b></label>
                        <div class="col-12">
                            <textarea type="text" class="form-control" name="content" style="height: 150px"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-form-label"><b>Use tags</b></label>
                        <div class="col-12">
                            <select id="tags" class="form-control" name="usetags[]" multiple="multiple">
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-form-label"><b>Create new tags</b> Ex: #something, v.v.</label>
                        <div class="col-12">
                            <input type="text" class="form-control" name="tags">
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" onchange="loadFile(event)" name="images[]" accept="image/x-png,image/gif,image/jpeg" multiple>
                    </div>
                    <input type="hidden" class="form-control" name="user_id" value="<?php echo $_SESSION['id'] ?>">
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
                <br>
            </div>
            <div class="col-8">
                <div id="image-list">
                    <img id="output" style="width: 100%;"/>
                </div>

                <script>
                    let loadFile = function(event) {
                        let image_list = document.getElementById("image-list");
                        image_list.innerHTML = "";
                        for (let i=0; i < event.target.files.length; i++ ){
                            let src = URL.createObjectURL(event.target.files[i]);
                            let image = document.createElement("img");
                            image.src = src;
                            image.style.maxWidth = "100%";
                            image.style.display = "block";
                            image.style.margin = "20px auto";
                            image_list.appendChild(image);
                        }
                    };
                </script>
            </div>
        </div>
    <?php else:?>
        <h3 class="text-center">You must login to create new post</h3>
    <?php endif ?>
</div>

<script>
    $(document).ready(function() {
        $('#tags').select2();
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>
