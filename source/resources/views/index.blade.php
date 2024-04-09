<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TestTask</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="container" style="max-width: 800px;padding-top: 200px;">
        <form>
            <label for="url" class="form-label">Enter url</label>
            <input type="text" name="url" id="url" class="form-control" placeholder="https://google.com" />
            <button class="btn btn-primary btn-md" type="submit" style="margin-top: 15px;">Submit</button>
        </form>
        <div class="alert alert-success" role="alert" style="display: none;margin-top: 15px;">
            <h3>Short url created successfully</h3>
            <div class="input-group">
                <input type="text" class="form-control" />
                <span class="input-group-text" id="copy" style="cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="alert alert-danger" role="alert" style="display: none;margin-top: 15px;">
            <h3></h3>
        </div>
    </div>

    <script type="text/javascript">
        $('#copy').on('click', function(){
            $('.alert-success input').select();
            document.execCommand('copy');
        });
        $('form').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'get',
            url: '/api/shortener',
            data: $(this).serialize(),
            contentType: false,
            cache: false,
            processData: false,
        }).done(function(data){
            if(data.success){
                $('.alert-danger').css('display', 'none');
                $('.alert-success').css('display', 'inherit');
                $('.alert-success input').val(data.message);
            }
        }).fail(function(data){
            $('.alert-success').css('display', 'none');
            $('.alert-danger').css('display', 'inherit');
            $('.alert-danger h3').text(data.responseJSON.message);
        });
    });
    </script>

</body>
</html>