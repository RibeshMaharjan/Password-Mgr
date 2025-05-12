<?php include './includes/header.php'; ?>
<?php include './includes/nav.php'; ?>
<?php include_once './lib/aes.php'; ?>
<?php
$aes = new AES();
?>
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
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
        <style>
                .eye-icon, .copy-icon {
                    cursor: pointer;
                }
                .password-history-item {
                    padding: 12px 0;
                    border-bottom: 1px solid #eee;
                }
                .edit-mode .edit-actions {
                    display: flex;
                }
                .edit-actions {
                    display: none;
                }
            </style>
        <!-- Delete Model -->
        <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
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
                            <form action="./php/credential.php" method="post">
                                <input type="hidden" name="id" id="modal-account-id"/>
                                <input type="hidden" name="site_id" value="<?= $_GET['id'] ?>" id="modal-site-id"/>
                                <button data-modal-hide="popup-modal" type="submit" name="delete_credential" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                                    Yes, I'm sure
                                </button>
                            </form>
                            <button data-modal-hide="popup-modal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">No, cancel</button>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <?php
            if (isset($_GET['id'])) {
                $_SESSION['site_id'] = $_GET['id'];
            }
            $site_id = $_GET['id'];

            $stmt = $dbh->prepare("SELECT * FROM sites WHERE user_id = :user_id AND site_id = :site_id;");
            $stmt->bindParam(':site_id', $site_id);
            $stmt->bindParam(':user_id', $_SESSION["userid"]);
            $stmt->execute();

            $site = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <!-- Back Button -->
        <div class="mb-6">
            <a href="dashboard.php" class="flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4">

        <?php

            $stmt = $dbh->prepare("SELECT credentials.account_id, credentials.username, credentials.password, credentials.notes, credentials.created_at, credentials.updated_at, sites.site_name, sites.site_url FROM credentials INNER JOIN sites ON credentials.site_id = sites.site_id WHERE credentials.users_id = ? AND sites.site_id=?;");
            $stmt->execute(array($_SESSION["userid"], $site_id));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


            foreach($data as &$row) {
                $row['decrypted_password'] = $aes->decrypt($row['password'], $_SESSION["password"]);
            }
            unset($row);

            foreach ($data as $row) {
        ?>
        <!-- Password Detail View -->
        <div id="passwordDetail" class="bg-white col-auto rounded-2xl shadow p-6 w-full max-w-3xl mx-auto">
            <form action="./php/credential.php" method="post">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold capitalize" id="passwordTitle"><?= $site['site_name'] ?></h2>
                    <div class="flex space-x-2">
                        <a href="<?= $site['site_url'] ?>" id="visitSiteBtn" class="px-4 py-2 bg-gray-100 rounded-md hover:bg-gray-200 text-sm" target="_blank">
                            Visit Site
                        </a>
                        <!-- Edit Button -->
                        <a id="editBtn" class="px-4 py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 text-sm">
                            Edit
                        </a>
                        <!-- Delete Button -->
                        <button data-modal-target="popup-modal" id="deleteBtn" data-modal-toggle="popup-modal" data-account-id="<?= $row['account_id'] ?>" class="px-4 py-2 bg-red-100 text-red-600 rounded-md hover:bg-red-200 text-sm" type="button">
                            Delete
                        </button>
                    </div>
                </div>

            <!-- Edit Mode Actions -->
            <div class="edit-actions mb-4 justify-end space-x-2">
                <a id="cancelEditBtn" class="px-4 py-2 border rounded-md hover:bg-gray-100 text-sm">
                    Cancel
                </a>
                <button id="saveEditBtn" name="update_credential" type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 text-sm">
                    Save Changes
                </button>
            </div>


            <input type="hidden" name="id" value="<?= $row['account_id'] ?>" />
            <input type="hidden" name="site_id" value="<?= $site['site_id'] ?>" />
            <!-- Username field -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Username</label>
                <div class="flex">
                    <input type="text" name="username" id="username" value="<?= $row['username'] ?>" class="form-input flex-grow" readonly>
                    <a class="ml-2 p-2 py-3 bg-gray-100 rounded-md hover:bg-gray-200 copy-button">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Password field -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Password</label>
                <div class="flex">
                    <input type="password" id="password" name="password" value="<?= $row['decrypted_password'] ?>" class="form-input flex-grow" readonly>
                    <a class="ml-2 p-2 py-3 bg-gray-100 rounded-md hover:bg-gray-20 hidden-toggle" >
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    <a class="ml-2 p-2 py-3 bg-gray-100 rounded-md hover:bg-gray-200 copy-button">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Notes field -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Notes</label>
                <div id="notesContainer">
                    <textarea id="notesTextarea" name="notes" class="form-input w-full" placeholder="Add your notes" readonly><?= $row['notes'] ?></textarea>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="flex justify-between text-sm text-gray-600 mb-8">
                <div>
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Created: <span id="createdDate"><?= $row['created_at'] ?></span>
                </div>
                <div>
                    Last modified: <span id="modifiedDate"><?= $row['updated_at'] ?></span>
                </div>
            </div>
        </form>


            <?php

                $stmt = $dbh->prepare("SELECT * from password_history WHERE account_id = ?;");
                $stmt->execute(array($row['account_id']));
                $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($history as &$row) {
                    $row['decrypted_password'] = $aes->decrypt($row['previous_password'], $_SESSION["password"]);
                }
                unset($row);
            ?>
            <!-- Password History -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Password History</h3>
                <div id="passwordHistory">
                    <?php
                        foreach ($history as $item) {
                            echo "
                                    <div class='password-history-item flex justify-between'>
                                        <div class='font-mono'>". $item['decrypted_password'] ."</div>
                                        <div class='text-gray-500'>". $item['changed_time'] ."</div>
                                    </div>
                                ";

                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        </div>

    </main>

    <!-- Scripts -->
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/navigation.js"></script>
    <script>
        // Get password ID from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const passwordId = urlParams.get('id');
        let currentPassword = null;

        document.addEventListener('DOMContentLoaded', () => {
            // If password ID exists, load password data
            if (passwordId) {
                // loadPasswordData(passwordId);
            } else {
                // Redirect to dashboard if no ID provided
                window.location.href = 'dashboard.html';
            }

            // Set up edit button
            document.getElementById('deleteBtn').addEventListener('click', deletePassword);
        });


        // Helper function to format dates
        function formatDate(date) {
            return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`;
        }

        const hiddenIcon = document.querySelectorAll(".hidden-toggle");
        hiddenIcon.forEach(icon => {
            icon.addEventListener('click', (e) => {
                let passwordInput = e.target.parentElement.parentElement.querySelector('#password');
                passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
            })
        })

        const copyBtn = document.querySelectorAll(".copy-button");
        copyBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                let passwordInput = e.target.parentElement.parentElement.querySelector('input');
                passwordInput.select();
                document.execCommand('copy');
            })
        })

        const editBtn = document.querySelectorAll("#editBtn");
        editBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const passwordDetail = e.target.parentElement.parentElement.parentElement.parentElement;
                passwordDetail.classList.add('edit-mode');

                // Make fields editable
                passwordDetail.querySelector('#username').readOnly = false;
                passwordDetail.querySelector('#password').readOnly = false;
                passwordDetail.querySelector('#notesTextarea').readOnly = false;
            })
        })

        const cancelBtn = document.querySelectorAll("#cancelEditBtn");
        cancelBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const passwordDetail = e.target.parentElement.parentElement.parentElement;
                passwordDetail.classList.remove('edit-mode');

                // Make fields editable
                passwordDetail.querySelector('#username').readOnly = true;
                passwordDetail.querySelector('#password').readOnly = true;
                passwordDetail.querySelector('#notesTextarea').readOnly = true;
            })
        })

        const deleteBtn = document.querySelectorAll("#deleteBtn");
        deleteBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const account_id = e.target.getAttribute('data-account-id');
                const modalAccountIdInput = document.getElementById('modal-account-id');
                modalAccountIdInput.value = account_id;
            })
        })
    </script>

<?php require './includes/footer.php'; ?>