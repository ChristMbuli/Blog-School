<div class="col-span-1 lg:sticky lg:top-0 hidden lg:block">
    <h1 class="text-xl font-bold text-gray-700">Profil</h1>
    <div class="bg-white p-8 rounded-lg shadow-md  max-w-md w-full">
        <!-- Banner Profile -->
        <div class="relative">
            <?php
            // Tableau de classes CSS de couleurs de fond prédéfinies
            $backgroundColors = [
                'bg-blue-500',
                'bg-red-500',
                'bg-green-500',
                'bg-yellow-500',
                'bg-purple-500',
                'bg-indigo-500',
                'bg-pink-500',
                'bg-teal-500',
                'bg-orange-500',
                'bg-gray-500',
            ];

            // Sélectionnez aléatoirement une couleur du tableau de couleurs
            $randomColorClass = $backgroundColors[array_rand($backgroundColors)];

            if ($_SESSION['student_profil'] === null) {
                // Extraire les initiales de `$_SESSION['student_name']`
                $studentName = $_SESSION['student_name'];
                $initials = strtoupper(substr($studentName, 0, 1)); // Première lettre
                if (strlen($studentName) > 1) {
                    $initials .= strtoupper(substr($studentName, 1, 1)); // Deuxième lettre
                }

                // Afficher les initiales avec une couleur de fond aléatoire
                echo '<div class="absolute bottom-0 left-2/4 transform -translate-x-1/2 translate-y-1/2 w-24 h-24 rounded-full border-4 border-white flex items-center justify-center ' . $randomColorClass . ' text-white font-bold">';
                echo $initials;
                echo '</div>';
            } else {
                // Afficher l'image de profil si `$_SESSION['student_profil']` n'est pas null
                echo '<img src="' . $_SESSION['student_profil'] . '" alt="Profile Picture" class="absolute bottom-0 left-2/4 transform -translate-x-1/2 translate-y-1/2 w-24 h-24 rounded-full border-4 border-white">';
            }
            ?>


        </div>
        <!-- User Info with Verified Button -->
        <div class="flex items-center mt-14 " style="margin-left: 23%;">
            <h2 class="text-xl font-bold text-gray-800"><?= $_SESSION['student_name'] ?></h2>
        </div>
        <!-- Bio -->
        <div class="flex items-center justify-between">
            <p class="text-gray-700 mt-2"><i class="fa-solid fa-graduation-cap"></i> Etudiant(e) à</p>
            <div class="flex items-center">
                <img src="https://placekitten.com/150/150" alt="Profile Picture"
                    class=" w-10 h-10 rounded-full border-4 border-white">
                <p class="text-sm font-semibold">SUP'RH</p>
            </div>

        </div>
        <hr class="mt-3">
        <!-- Social Links -->
        <div class="flex items-center mt-1 space-x-3" style="margin-left:30px">
            <a href="#" class="text-gray-500 hover:underline p-1 rounded-lg"><i class="fa-solid fa-circle-user"></i>
                Profil </a>
            <a href="#" class="text-gray-500 hover:underline p-1 rounded-lg"> <i class="fa-solid fa-users"></i>
                Ami(e)s
            </a>
        </div>
    </div>