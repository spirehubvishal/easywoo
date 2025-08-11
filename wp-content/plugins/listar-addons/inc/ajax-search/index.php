<html lang="en">
<head>
    <title>jquery select2 ajax php example</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
</head>
<body>
    <div class="row mt-5">
        <div class="col-md-6 offset-3 mt-5">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>JQuery Select2 Ajax PHP Example - Nicesnippets.com</h4>
                </div>
                <div class="card-body" style="height: 280px;">
                    <div>
                        <select class="postName form-control" style="width:500px" name="postName"></select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.postName').select2({
            placeholder: 'Select an item',
            ajax: {
                url: 'http://gplcenter.org/testeselect2/autocompletePro.php',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
        });
    </script>
</body>
</html>