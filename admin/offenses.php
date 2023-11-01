<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offenses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <h1>Offenses</h1>

        <table class="table table-borderless table-striped table-hover">
            <thead class="table-dark">
                <th>Name</th>
                <th>Amount</th>
                <th>Date Added</th>
                <th></th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../utils/js/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script>
        $(document).ready(function() {

            $(document).on({
                ajaxStart: function() {
                    // Show full page LoadingOverlay
                    $.LoadingOverlay("show");
                },
                ajaxStop: function() {
                    // Hide it after 3 seconds
                    $.LoadingOverlay("hide");
                }
            });

            function fetchAllOffense() {
                $.ajax({
                    type: "GET",
                    url: "../api/fetch-all-offense",
                    success: function(result) {
                        console.log(result);
                        if (result.success) {
                            data = result.message;
                            $("tbody").html("");
                            $.each(data, function(index, value) {
                                $("tbody").append(
                                    "<tr key='" + value.id + "'>" +
                                    "<td>" + value.name + "</td>" +
                                    "<td>" + value.amount + "</td>" +
                                    "<td>" + value.added_at + "</td>" +
                                    "<td>" +
                                    "<button class='btn btn-sm btn-primary me-2'>Edit</button>" +
                                    "<button class='btn btn-sm btn-danger'>Delete</button></td>" +
                                    "</tr>"
                                )
                            })
                        } else {
                            alert(result['message']);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            fetchAllOffense();

        });
    </script>

</body>

</html>