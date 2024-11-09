                <footer>
                    <!-- place footer here -->
                </footer>
            </div>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
                    });
                }
            );
        </script>
    </body>
</html>