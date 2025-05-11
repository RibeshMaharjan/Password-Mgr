<?php include './includes/header.php'; ?>
<?php include './includes/nav.php'; ?>
<?php include_once './lib/aes.php'; ?>
<?php
$aes = new AES();
?>
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
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

        <?php


            if (isset($_GET['id'])) {
                $_SESSION['site_id'] = $_GET['id'];
            }
            $site_id = $_GET['id'];

            $stmt = $dbh->prepare("SELECT * FROM sites WHERE site_id = :site_id;");
            $stmt->bindParam(':site_id', $site_id);
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
        ?>
        <?php
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
                    <a id="deleteBtn" class="px-4 py-2 bg-red-100 text-red-600 rounded-md hover:bg-red-200 text-sm">
                        Delete
                    </a>
                </div>
            </div>

            <!-- Edit Mode Actions -->
            <div class="edit-actions mb-4 justify-end space-x-2">
                <a id="cancelEditBtn" class="px-4 py-2 border rounded-md hover:bg-gray-100 text-sm">
                    Cancel
                </a>
                <button id="saveEditBtn" name="update" type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 text-sm">
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
                    <a class="ml-2 p-2 py-3 bg-gray-100 rounded-md hover:bg-gray-200" onclick="copyField('username')">
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
                    <a class="ml-2 p-2 py-3 bg-gray-100 rounded-md hover:bg-gray-200" onclick="togglePassword()">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    <a class="ml-2 p-2 py-3 bg-gray-100 rounded-md hover:bg-gray-200" onclick="copyField('password')">
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
                    <textarea id="notesTextarea" name="notes" class="form-input w-full" placeholder="Add your notes"><?= $row['notes'] ?></textarea>
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
            document.getElementById('editBtn').addEventListener('click', enableEditMode);
            document.getElementById('cancelEditBtn').addEventListener('click', disableEditMode);
            // document.getElementById('saveEditBtn').addEventListener('click', saveChanges);
            document.getElementById('deleteBtn').addEventListener('click', deletePassword);
        });


        // Helper function to format dates
        function formatDate(date) {
            return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`;
        }

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }

        // Copy field content to clipboard
        function copyField(fieldId) {
            const input = document.getElementById(fieldId);
            input.select();
            document.execCommand('copy');
        }

        // Enable edit mode
        function enableEditMode() {
            const passwordDetail = document.getElementById('passwordDetail');
            passwordDetail.classList.add('edit-mode');
            
            // Make fields editable
            document.getElementById('username').readOnly = false;
            document.getElementById('password').readOnly = false;
            document.getElementById('notesTextarea').readOnly = false;
        }

        // Disable edit mode
        function disableEditMode() {
            const passwordDetail = document.getElementById('passwordDetail');
            passwordDetail.classList.remove('edit-mode');
            
            // Make fields readonly
            document.getElementById('username').readOnly = true;
            document.getElementById('password').readOnly = true;
            document.getElementById('notesTextarea').readOnly = true;


        }

        // Delete password
        function deletePassword() {
            if (!currentPassword) return;
            
            if (confirm('Are you sure you want to delete this password? This action cannot be undone.')) {
                // Get passwords from localStorage
                const passwords = JSON.parse(localStorage.getItem('passwords')) || [];
                
                // Filter out the current password
                const updatedPasswords = passwords.filter(p => p.id != currentPassword.id);
                
                // Save to localStorage
                localStorage.setItem('passwords', JSON.stringify(updatedPasswords));
                
                // Redirect to dashboard
                window.location.href = 'dashboard.html';
            }
        }
    </script>

<?php require './includes/footer.php'; ?>