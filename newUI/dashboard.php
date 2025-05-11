<?php require './includes/header.php'; ?>
<?php require './includes/nav.php'; ?>
<!-- Main Content -->
<main class="container mx-auto px-4 py-6">
    <!-- Main Dashboard View -->
    <div id="dashboardView">
        <!-- Alert Message-->
        <?php
           if(isset($_SESSION['error'])) {
               echo '
                   <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                     <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                       <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                     </svg>
                     <span class="sr-only">Info</span>
                     <div>
                       '.$_SESSION['error'].'
                     </div>
                   </div>
               ';
               unset($_SESSION['error']);
           }
           if(isset($_SESSION['success'])) {
               echo '
                   <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                     <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                       <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                     </svg>
                     <span class="sr-only">Info</span>
                     <div>
                       '.$_SESSION['success'].'
                     </div>
                   </div>
               ';
               unset($_SESSION['success']);
           }
        ?>
        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Passwords</p>
                        <h3 class="text-2xl text-blue-600 font-bold" id="totalPasswords">
                            <?php
                                $stmt = $dbh->prepare('SELECT COUNT(*) as total_passwords FROM credentials WHERE users_id = ?;');
                                $stmt->execute(array($_SESSION['userid']));
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_passwords'];
                            ?>
                        </h3>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Site</p>
                        <h3 class="text-2xl font-bold text-red-600" id="totalSites">0
                            <?php
//                                $stmt = $dbh->prepare('SELECT COUNT(*) as total_sites FROM sites WHERE users_id = ?;');
//                                $stmt->execute(array($_SESSION['userid']));
//                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
//                                echo $result['total_sites'];
                            ?>
                        </h3>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Reused Passwords</p>
                        <h3 class="text-2xl font-bold text-yellow-600" id="reusedPasswords">0</h3>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Security Score</p>
                        <h3 class="text-2xl font-bold text-green-600" id="securityScore">0</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Password List -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">Your Passwords</h2>
                        <button id="addPasswordBtn" class="h-9 bg-black rounded-md text-white text-sm px-4 py-2 hover:bg-gray-800 transition-all duration-200"><i class="fa-solid fa-circle-plus mr-2"></i>Add New Password</button>
                    </div>

                    <div class="space-y-4" id="passwordList">
                        <!-- Password items will be dynamically added here -->
                        <?php
                                $stmt = $dbh->prepare("SELECT * FROM sites");
                                   $stmt->execute();

                                   $siteResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                   // $stmt = null;
                                   $stmt = $dbh->prepare("SELECT * FROM credentials WHERE users_id = :user_id");
                                   $stmt->bindParam(':user_id', $_SESSION['userid']);
                                   $stmt->execute();
                                   $credentials = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                   $sites = [];

                                   foreach($siteResult as $site){
                                           $count = 0;
                                       foreach($credentials as $credential){
                                           if($site['site_id'] == $credential['site_id']) {
                                               $count++;
                                           }
                                       }
                                       if($count > 0){
                                           $site['count'] = $count;
                                           $sites[] = $site;
                                       }
                                   }

                                   foreach($sites as $row){
                               ?>
                                   <div class="border border-gray-200 rounded-lg p-4 bg-white mb-4 shadow-sm">
                                       <div class="flex justify-between items-center mb-1">
                                           <h3 class="font-bold"><?= $row['site_name'] ?></h3>
                                           <div class="flex space-x-2">
                                               <a href="single.php?id=<?= $row['site_id'] ?>" class="details-btn px-3 py-1 text-sm border rounded hover:bg-gray-50">
                                                   Details
                                               </a>
                                           </div>
                                       </div>
                                       <p class="text-gray-600 text-sm"><?= $row['count'] ?> Accounts</p>
                                   </div>
                               <?php
                               }
                           ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="card">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button class="btn btn-outline w-full text-left" onclick="window.location.href='password-generator.php'">
                            Generate New Password
                        </button>
                        <button class="btn btn-outline w-full text-left" id="importPasswordsBtn">
                            Import Passwords
                        </button>
                        <button class="btn btn-outline w-full text-left" id="exportPasswordsBtn">
                            Export Passwords
                        </button>
                    </div>
                </div>

                <div class="card">
                    <h3 class="text-lg font-semibold mb-4">Security Tips</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-100 rounded-full">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium">Use Strong Passwords</h4>
                                <p class="text-sm text-gray-600">Create unique passwords for each account</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-100 rounded-full">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium">Enable 2FA</h4>
                                <p class="text-sm text-gray-600">Add an extra layer of security</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Password Modal -->
<div id="addPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Add New Password</h3>
            <form id="addPasswordForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" name="title" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Username/Email</label>
                    <input type="text" name="username" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Website</label>
                    <input type="url" name="website" class="form-input">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" class="btn btn-outline" id="cancelAddPassword">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require './includes/footer.php'; ?>