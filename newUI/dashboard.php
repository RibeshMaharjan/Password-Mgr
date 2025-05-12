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
                     <div class="message-container">'.$_SESSION['error'].'</div>
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
                     <div class="message-container">'.$_SESSION['success'].'</div>
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
                        <h3 class="text-2xl font-bold text-red-600" id="totalSites">
                            <?php
                                $stmt = $dbh->prepare('SELECT COUNT(*) as total_sites FROM sites WHERE user_id = ?;');
                                $stmt->execute(array($_SESSION['userid']));
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_sites'];
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
                        <div>
                            <!-- Add Site Modal toggle -->
                            <button data-modal-target="add-site-modal" data-modal-toggle="add-site-modal"  id="addSiteBtn" class="h-9 bg-black rounded-md text-white text-sm px-4 py-2 hover:bg-gray-800 transition-all duration-200"><i class="fa-solid fa-circle-plus mr-2"></i>Add New Site</button>
                            <!-- Add Password Modal toggle -->
                            <button data-modal-target="password-modal" data-modal-toggle="password-modal"  id="addPasswordBtn" class="h-9 bg-black rounded-md text-white text-sm px-4 py-2 hover:bg-gray-800 transition-all duration-200"><i class="fa-solid fa-circle-plus mr-2"></i>Add New Password</button>
                        </div>
                    </div>

                    <div class="space-y-4" id="passwordList">
                        <!-- Password items will be dynamically added here -->
                        <?php
                                $stmt = $dbh->prepare("SELECT * FROM sites WHERE user_id = :user_id");
                                $stmt->bindParam(':user_id', $_SESSION['userid']);
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
                                               <button data-modal-target="update-site-modal" data-modal-toggle="update-site-modal" data-site-id="<?= $row['site_id'] ?>" data-site-name="<?= $row['site_name'] ?>" data-site-url="<?= $row['site_url'] ?>"  id="updateSiteBtn" class="details-btn px-3 py-1 text-sm border rounded hover:bg-gray-50">
                                                  Update
                                               </button>
                                               <!-- Delete Button -->
                                               <button data-modal-target="delete-site-modal" id="deleteSiteBtn" data-modal-toggle="delete-site-modal" data-delete-site-id="<?= $row['site_id'] ?>" class="details-btn px-3 py-1 text-sm border rounded hover:bg-gray-50">
                                                   Delete
                                               </button>
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

    <!-- Main modal -->
    <div id="password-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Add New Password
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="password-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4 grid grid-cols-2 gap-4" action="php/credential.php" method="post">
                        <div class="mt-4 mb-0">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Your Username/Email</label>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="asura_007" required />
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Your password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " required />
                        </div>
                        <div class="">
                            <label for="site_id" class="block mb-2 text-sm font-medium text-gray-900">Sites</label>
                            <select id="site_id" name="site_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option selected="">Select Site</option>
                                <?php
                                    $stmt = $dbh->prepare("SELECT * FROM sites WHERE user_id = :user_id");
                                    $stmt->bindParam(':user_id', $_SESSION['userid']);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result as $row){
                                        echo '<option value="'.$row['site_id'].'">'.$row['site_name'].'</option>';
                                    };
                                ?>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="notes" class="block mb-2 text-sm font-medium text-gray-900">Notes</label>
                            <textarea id="notes" name="notes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Place your notes here"></textarea>
                        </div>
                        <div class="col-span-2 grid grid-cols-subgrid gap-4">
                            <button type="submit" name="add_credential" class="col-start-2 w-full text-white bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add New Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Site modal -->
        <div id="add-site-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Add New Site
                        </h3>
                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-site-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4 grid col-span-2 gap-2" action="php/site.php" method="post">
                            <div>
                                <label for="site_name" class="block mb-2 text-sm font-medium text-gray-900">Site Name</label>
                                <input type="text" name="site_name" id="site_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Google" required />
                            </div>
                            <div class="mt-4 mb-0">
                                <label for="site_url" class="block mb-2 text-sm font-medium text-gray-900">Site Url</label>
                                Update Site               <input type="text" name="site_url" id="site_url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="google.com" required />
                            </div>
                            <button type="submit" name="add_site" class="w-full text-white bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add Site</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Update Site modal -->
        <div id="update-site-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Add New Site
                        </h3>
                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="update-site-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4 grid col-span-2 gap-2" action="php/site.php" method="post">
                            <input type="hidden" name="site_id" id="model_site_id" value="">
                            <div>
                                <label for="model_site_name" class="block mb-2 text-sm font-medium text-gray-900">Site Name</label>
                                <input type="text" name="site_name" id="model_site_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Google" required />
                            </div>
                            <div class="mt-4 mb-0">
                                <label for="model_site_url" class="block mb-2 text-sm font-medium text-gray-900">Site Url</label>
                                <input type="text" name="site_url" id="model_site_url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="google.com" required />
                            </div>
                            <button type="submit" name="update_site" class="w-full text-white bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add Site</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Delete Model -->
            <div id="delete-site-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                              <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                  <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                  </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                  <h3 class="text-base font-semibold text-gray-900" id="modal-title">Deactivate account</h3>
                                  <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <form action="php/site.php" method="post">
                                  <input type="hidden" value="" name="site_id" id="delete_model_site_id" >
                                  <button type="submit" name="delete_site" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                                      Yes, I'm sure
                                  </button>
                                </form>
                                <button data-modal-hide="delete-site-modal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">No, cancel</button>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        <script>
            const updateBtn = document.querySelectorAll("#updateSiteBtn");
            updateBtn.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const site_id = e.target.getAttribute('data-site-id');
                    const modalSiteIdInput = document.getElementById('model_site_id');
                    modalSiteIdInput.value = site_id;

                    const site_name = e.target.getAttribute('data-site-name');
                    const modalSiteNameInput = document.getElementById('model_site_name');
                    modalSiteNameInput.value = site_name;

                    const site_url = e.target.getAttribute('data-site-url');
                    const modalSiteUrlInput = document.getElementById('model_site_url');
                    modalSiteUrlInput.value = site_url;
                })
            })

            const deleteBtn = document.querySelectorAll("#deleteSiteBtn");
            deleteBtn.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const site_id = e.target.getAttribute('data-delete-site-id');
                    const modelSiteIdInput = document.getElementById('delete_model_site_id');
                    modelSiteIdInput.value = site_id;
                })
            })
        </script>
<?php require './includes/footer.php'; ?>