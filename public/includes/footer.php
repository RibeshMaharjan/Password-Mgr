                <footer>
                    <!-- place footer here -->
                </footer>
            </div>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
        <!-- Jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="./assets/js/nav.js"
        ></script>
        <script
            src="./assets/js/dashboard.js"
        ></script>
        <script
            src="./assets/js/app.js"
        ></script>
        <script>
            $(document).ready(
                function() {
                    $(".edit-btn").on('click', function() {
                        $('#credential-edit').modal('show');
                        $tr = $(this).closest('.dashboard-table-row');

                        var text = $tr.children(".dashboard-table-cell").map(function() {
                            return $(this).text();
                        }).get();

                        $('#id').val(text[0]);
                        $('#site').val(text[1]);
                        $('#username').val(text[2]);
                        $('#password').val(text[3]);
                    });

                    // $(".delete-btn").on('click', function() {
                    //     $('#credential-delete').modal('show');
                    //     $tr = $(this).closest('.dashboard-table-row');

                    //     var text = $tr.children(".dashboard-table-cell").map(function() {
                    //         return $(this).text();
                    //     }).get();

                    //     $('#delete-id').val(text[0]);
                    // });
                }
            );
        </script>
    </body>
</html>