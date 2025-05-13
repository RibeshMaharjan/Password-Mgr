<?php include_once './php/dbh.php'; ?>
<?php include_once './includes/header.php'; ?>
<?php include_once './includes/nav.php'; ?>

<?php
    require_once './lib/aes.php';
    $aes = new AES();

    $user_id = $_SESSION["userid"];
    $saltKey = $_SESSION["password"];
    $userInfo = getUserInfo();
?>

<!-- Main Content -->
<main class="container mx-auto px-4 py-6">
    <!-- 2FA Model -->
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <?php
                    if($userInfo['is_2FA_enabled']) {
                        echo '
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                  <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                      <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                      </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                      <h3 class="text-base font-semibold text-gray-900" id="modal-title">Diable 2FA</h3>
                                      <div class="mt-2">
                                        <p class="text-sm text-gray-500">Are you sure you want to disable the 2FA for your account?</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <form action="php/auth.php" method="post">
                                        <input type="hidden" name="id" id="modal-account-id"/>
                                        <button data-modal-hide="popup-modal" type="submit" name="send_disable_mail" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                                            Yes, I am sure
                                        </button>
                                    </form>
                                    <button data-modal-hide="popup-modal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" onclick="toggleCheckbox()">No, cancel</button>
                                </div>
                        ';
                    } else {
                        echo '
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                              <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                  <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                  </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                  <h3 class="text-base font-semibold text-gray-900" id="modal-title">Enable 2FA</h3>
                                  <div class="mt-2">
                                    <p class="text-sm text-gray-500">A 6-digit code will be send to your Mail.</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <form action="php/auth.php" method="post">
                                    <input type="hidden" name="id" id="modal-account-id"/>
                                    <button data-modal-hide="popup-modal" type="submit" name="send_enable_mail" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                                        Yes, I am sure
                                    </button>
                                </form>
                                <button data-modal-hide="popup-modal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" onclick="toggleCheckbox()">No, cancel</button>
                            </div>
                        ';
                    }
                ?>
              </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto p-4 max-w-4xl">
        <!-- Tabs -->
        <div id="user-profile-tab" class="mb-4 bg-gray-100 inline-flex h-9 w-fit items-center justify-center rounded-lg p-[3px] shadow-sm">
            <button class="text-sm tab-btn px-2 py-1 rounded-lg bg-white shadow text-black font-medium focus:outline-none transition-all duration-200 active" data-tab="profile">Profile</button>
            <button class="text-sm tab-btn px-2 py-1 rounded-lg bg-transparent text-black font-medium focus:outline-none transition-all duration-200" data-tab="security">Security</button>
        </div>

        <!-- Profile Tab Content -->
        <div id="profile-tab-content" class="flex-1 outline-none shadow tab-content bg-white rounded-xl">
            <div class="flex flex-col gap-6 py-6 px-8">
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
//                        unset($_SESSION['error']);
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
//                        unset($_SESSION['success']);
                    }
                ?>
                <h2 class="text-lg font-bold">User Profile</h2>
                <div class="flex flex-col items-center mb-4">
                    <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center text-4xl font-semibold text-gray-500" id="userAvatar">J</div>
                </div>
                <form action="./php/updateUserprofile.php" method="POST" id="profileForm" class="space-y-6">
                    <input type="hidden" name="userid" value="<?= $userInfo['user_id'] ?>">
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" name="fullname" value="<?= $userInfo['users_fullname'] ?>" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <div class="flex items-center space-x-2">
                            <input type="email" name="email" id="email" value="<?= $userInfo['users_email'] ?>" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200" disabled>
                            <?php
                                if(!$userInfo['isVerified']) {
                                    echo '
                                        <button type="button" id="verifyEmailBtn" class="whitespace-nowrap h-10 text-black transition-all duration-200 hover:bg-gray-100 border border-gray-300 py-2 px-4 rounded-md text-sm">Verify Email</button>
                                    ';
                                }
                            ?>
                        </div>
                        <?php
                            if(!$userInfo['isVerified']) {
                                echo '
                                    <div class="flex items-center mt-1 text-sm text-yellow-600" id="emailNotVerified">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Email not verified
                                    </div>
                                ';
                            }
                        ?>

                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Username</label>
                        <input type="text" name="username" id="username" value="<?= $userInfo['users_name'] ?>" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200" disabled />
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="cancelEditBtn" class="h-10 border border-gray-300 bg-white rounded-md text-black px-4 py-2 hover:bg-gray-100 transition-all duration-200 mr-2 hidden">Cancel</button>
                        <button type="submit" name="updateProfile" id="saveChangesBtn" class="h-10 bg-black rounded-md text-white px-4 py-2 hover:bg-gray-800 transition-all duration-200 hidden">Save Changes</button>
                        <button type="button" id="editProfileBtn" class="h-10 bg-black rounded-md text-white px-4 py-2 hover:bg-gray-800 transition-all duration-200">Edit Profile</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Tab Content -->
        <div id="security-tab-content" class="flex-1 outline-none shadow tab-content bg-white rounded-xl hidden">
            <div class="flex flex-col gap-6 py-6 px-8">
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
                              <div class="message-container">'.$_SESSION['success'].'</div>
                            </div>
                        ';
                        unset($_SESSION['success']);
                    }
                ?>
                <h2 class="text-lg font-bold">Security Settings</h2>
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="font-medium">Two-Factor Authentication</h3>
                        <p class="text-sm text-gray-600">Add an extra layer of security to your account</p>
                    </div>



                <label class="inline-flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        class="sr-only peer" <?= $userInfo['is_2FA_enabled'] ? 'checked' : '' ?>
                        data-modal-target="popup-modal"
                        data-modal-toggle="popup-modal"
                    >
                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gray-300 rounded-full peer peer-checked:after:translate-x-[22px] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gray-900"></div>
                </label>

                </div>
                <form method="post" action="php/updateUserprofile.php" id="passwordForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Current Password</label>
                        <input type="password" name="currentPassword" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">New Password</label>
                        <input type="password" name="newPassword" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                        <input type="password" name="confirmPassword" class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200">
                    </div>
                    <button type="submit" name="changePassword" class="h-10 bg-black rounded-md text-white px-4 py-2 hover:bg-gray-800 transition-all duration-200">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    function toggleCheckbox() {
        if(document.querySelector('input[type="checkbox"]').checked) {
            document.querySelector('input[type="checkbox"]').checked = false;
        } else {
            document.querySelector('input[type="checkbox"]').checked = true;
        }
    }
</script>

<?php include_once 'includes/footer.php'; ?>