<?php include './includes/header.php'; ?>
    <div class="container">
        <main>
            <div class="password-generator-body">
                <div class="title">
                    <h1>Password Generator</h1>
                </div>
                <div class="body">
                    <?php 
                        $generator = new GeneratorController();
                        $generator->showPassword(); 
                    ?>
                </div>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>a