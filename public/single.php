<?php
session_start();
require '../backend/Logout.php';
require '../backend/SinglePost.php';



?>
<style>
.zeze {
    margin-top: 80px;
}
</style>
<?php include './components/head.php' ?>

<div class="overflow-x-hidden bg-gray-100">
    <?php include './components/navbar.php' ?>

    <div class="container mx-auto px-6 py-8 zeze ">
        <div class="grid grid-cols-4 gap-5 ">
            <!-- Section Messages -->
            <?php include './partials/section_m.php' ?>

            <!-- Section Publication -->
            <div class="col-span-2 lg:col-span-2 w-full lg:w-full">
                <?php include './partials/ss.php' ?>
            </div>

            <!-- Section Profil -->
            <?php if (isset($_SESSION['student'])) { ?>
            <?php include './partials/section_p.php' ?>
            <?php } ?>
        </div>
    </div>
</div>



<?php include './components/footer.php' ?>